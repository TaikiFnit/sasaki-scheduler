<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * EventDateUsers Controller
 *
 * @property \App\Model\Table\EventDateUsersTable $EventDateUsers
 *
 * @method \App\Model\Entity\EventDateUser[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EventDateUsersController extends AppController
{
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->autoRender = false;
        $this->response->type('application/json');
        $this->response->header("Access-Control-Allow-Origin: *");

        $eventDateUser = $this->EventDateUsers->newEntity();
        if ($this->request->is('post')) {
            $requestedData = $this->request->getData();
            $eventDateUser = $this->EventDateUsers->patchEntity($eventDateUser, $requestedData);
            if ($this->EventDateUsers->save($eventDateUser)) {
                // save succeed
                $result = ["status" => true];
            } else {
                // save failed
                $result = ["status" => false];
            }
        }

        $this->set('status', $result);
        $this->set('_serializer', 'status');
        $this->response->body(json_encode($result));
    }

    /**
     * Delete method
     *
     * @param string|null $id Event Date User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->autoRender = false;
        $this->response->type('application/json');
        $this->response->header("Access-Control-Allow-Origin: *");

        $this->request->allowMethod(['post', 'delete']);
        $eventDateUser = $this->EventDateUsers->get($id);
        if ($this->EventDateUsers->delete($eventDateUser)) {
            $result = ["status" => true];
        } else {
            $result = ["status" => false];
        }

        $this->set('status', $result);
        $this->set('_serializer', 'status');
        $this->response->body(json_encode($result));
    }
}
