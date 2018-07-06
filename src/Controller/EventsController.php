<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Events Controller
 *
 * @property \App\Model\Table\EventsTable $Events
 *
 * @method \App\Model\Entity\Event[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EventsController extends AppController
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

        $events = $this->Events->find('all', ['contain' => 
            ['EventTypes', 'Users', 'EventDates' => function($q) {
                return $q->contain(['Users']);
            } ]]);
        $this->set('events', $events);
        $this->set('_serialize', 'events');
        $this->response->body(json_encode($events));
    }

    /**
     * View method
     *
     * @param string|null $id Event id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $event = $this->Events->get($id, [
            'contain' => ['EventTypes', 'EventDates', 'EventUsers']
        ]);

        $this->set('event', $event);
        $this->set('_serialize', 'event');
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->autoRender = false;
        $this->response->type('application/json');


        $event = $this->Events->newEntity();
        if ($this->request->is('post')) {
            $event = $this->Events->patchEntity($event, $this->request->getData());
            if ($this->Events->save($event)) {
                // save succeed

                // store dates associated events if needed
                $eventDatesTable = TableRegistry::get('EventDates');
                if ( isset($this->request->getData()["dates"]) ) {
                    foreach($this->request->getData()["dates"] as $date) {
                        $eventDate = $eventDatesTable->newEntity();
                        $eventDate->event_id = $event->id;
                        $eventDate->prospective_date = $date["prospective_date"];
                        $eventDate->prospective_time = $date["prospective_time"];

                        $eventDatesTable->save($eventDate);
                    }
                }

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
     * @param string|null $id Event id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $event = $this->Events->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $event = $this->Events->patchEntity($event, $this->request->getData());
            if ($this->Events->save($event)) {
                $this->Flash->success(__('The event has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The event could not be saved. Please, try again.'));
        }
        $eventTypes = $this->Events->EventTypes->find('list', ['limit' => 200]);
        $this->set(compact('event', 'eventTypes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Event id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $event = $this->Events->get($id);
        if ($this->Events->delete($event)) {
            $this->Flash->success(__('The event has been deleted.'));
        } else {
            $this->Flash->error(__('The event could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
