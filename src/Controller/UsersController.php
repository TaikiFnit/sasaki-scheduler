<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->autoRender = false;
        $this->response->type('application/json');
        $this->response->header("Access-Control-Allow-Origin: *");

        $email = $this->request->getData()["email"];
        $tokenId = $this->request->getData()["tokenId"];
        $googleId = $this->request->getData()["googleId"];
        $accessToken = $this->request->getData()["accessToken"];

        $res = $this->fetchUserData($tokenId);

        if (strcmp($email, $res['email']) != 0) {
            $this->response->body(json_encode(['status' => "fa"]));
            return;
        }

        $user = $this->Users->find('all')->where(['email =' => $email])->first();
        if ($user == null) {
            $user = $this->Users->newEntity();
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, [
                'name' => $res['name'],
                'family_name' => $res['family_name'],
                'given_name' => $res['given_name'],
                'picture' => $res['picture'],
                'email' => $email,
                'token_id' => $tokenId,
                'google_id' => $googleId,
                'access_token' => $accessToken,
            ]);
            if ($this->Users->save($user)) {
                $joinedUser = $this->Users->find()->contain(['Events', 'EventDateUsers'])->where(['id' => $user->id])->first();
                $result = ["status" => true, 'user' => $joinedUser];
            } else {
                $result = ["status" => false];
            }
        } else {
            $result = ['message' => 'there are no routing for GET /users/'];
        }

        $this->set('status', $result);
        $this->set('_serializer', 'status');
        $this->response->body(json_encode($result));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($access_token = null)
    {
        $this->autoRender = false;
        $this->response->type('application/json');
        $this->response->header("Access-Control-Allow-Origin: *");

        $fetchedUser = $this->fetchUserDataByAccessToken($access_token);

        if (array_key_exists('email', $fetchedUser)) {
            $user = $this->Users->find('all')->contain(['Events', 'EventDateUsers'])->where(['email' => $fetchedUser['email']])->first();
            $result = ['status' => true, 'user' => $user];
        } else {
            $result = ['status' => false, 'message' => "Invalid Access Token"];
        }

        $this->set('status', $result);
        $this->set('_serializer', 'status');
        $this->response->body(json_encode($result));
    }
}
