<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Http\Client;

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
                $result = ["status" => true, 'user' => $user];
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
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Events', 'EventDateUsers'],
        ]);

        $this->set('user', $user);
    }

    public function fetchUserData($tokenId)
    {
        $http = new Client();
        $response = $http->get('https://www.googleapis.com/oauth2/v3/tokeninfo', ['id_token' => $tokenId]);
        return $response->json;
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $events = $this->Users->Events->find('list', ['limit' => 200]);
        $this->set(compact('user', 'events'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Events'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $events = $this->Users->Events->find('list', ['limit' => 200]);
        $this->set(compact('user', 'events'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
