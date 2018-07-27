<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Feedbacks Controller
 *
 * @property \App\Model\Table\FeedbacksTable $Feedbacks
 *
 * @method \App\Model\Entity\Feedback[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FeedbacksController extends AppController
{
    public function index()
    {
        $this->autoRender = false;
        $this->response->type('application/json');
        $this->response->header("Access-Control-Allow-Origin: *");
        $this->response->withHeader('Access-Control-Allow-Origin', '*');

        $feedbacks = $this->Feedbacks->find('all', ['contain' => ['Users']]);
        $result = ['status' => true, 'feedbacks' => $feedbacks];

        $this->set('feedbacks', $result);
        $this->set('_serialize', 'feedbacks');
        $this->response->body(json_encode($result));
    }

    // $id means event_type_id
    public function view($id = null)
    {
        $this->autoRender = false;
        $this->response->type('application/json');
        $this->response->header("Access-Control-Allow-Origin: *");
        $this->response->withHeader('Access-Control-Allow-Origin', '*');

        $feedbacks = $this->Feedbacks->find('all', ['contain' => ['Users']])->where(['event_type_id' => $id]);
        $result = ['status' => true, 'feedbacks' => $feedbacks];

        $this->set('feedbacks', $result);
        $this->set('_serialize', 'feedbacks');
        $this->response->body(json_encode($result));
    }

    public function add()
    {
        $this->autoRender = false;
        $this->response->type('application/json');
        $this->response->header("Access-Control-Allow-Origin: *");
        $this->response->withHeader('Access-Control-Allow-Origin', '*');

        $access_token = $this->request->query['access_token'];
        $fetchedUser = $this->fetchUserDataByAccessToken($access_token);

        if (array_key_exists('email', $fetchedUser)) {
            $usersTable = TableRegistry::get('Users');
            $user = $usersTable->find('all')->where(['email' => $fetchedUser['email']])->first();

            if ($this->request->is('post')) {
                $feedback = $this->Feedbacks->newEntity();
                $body = $this->request->getData();
                $body['user_id'] = $user->id;
                $feedback = $this->Feedbacks->patchEntity($feedback, $body);
                if ($this->Feedbacks->save($feedback)) {
                    // save succeed
                    $result = ['status' => true];
                } else {
                    $result = ['status' => false];
                }
            }
        } else {
            $result = ['status' => false, 'message' => "invalid access_token"];
        }

        $this->set('feedbacks', $result);
        $this->set('_serialize', 'feedbacks');
        $this->response->body(json_encode($result));
    }
}
