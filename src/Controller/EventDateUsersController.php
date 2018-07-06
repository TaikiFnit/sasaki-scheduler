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
     * Edit method
     *
     * @param string|null $id Event Date User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $eventDateUser = $this->EventDateUsers->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $eventDateUser = $this->EventDateUsers->patchEntity($eventDateUser, $this->request->getData());
            if ($this->EventDateUsers->save($eventDateUser)) {
                $this->Flash->success(__('The event date user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The event date user could not be saved. Please, try again.'));
        }
        $eventDates = $this->EventDateUsers->EventDates->find('list', ['limit' => 200]);
        $users = $this->EventDateUsers->Users->find('list', ['limit' => 200]);
        $this->set(compact('eventDateUser', 'eventDates', 'users'));
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
        $this->request->allowMethod(['post', 'delete']);
        $eventDateUser = $this->EventDateUsers->get($id);
        if ($this->EventDateUsers->delete($eventDateUser)) {
            $this->Flash->success(__('The event date user has been deleted.'));
        } else {
            $this->Flash->error(__('The event date user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
