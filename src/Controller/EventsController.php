<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Mailer\Email;
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
        $this->response->header("Access-Control-Allow-Origin: *");
        $this->response->withHeader('Access-Control-Allow-Origin', '*');

        $events = $this->Events->find('all',
            ['contain' =>
                ['EventTypes', 'Users', 'EventDates' => function ($q) {
                    return $q->contain(['EventDateUsers']);
                }],
            ]
        );

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
        $this->autoRender = false;
        $this->response->type('application/json');
        $this->response->header("Access-Control-Allow-Origin: *");
        $this->response->withHeader('Access-Control-Allow-Origin', '*');

        $event = $this->Events->get($id, ['contain' =>
            ['EventTypes', 'Users', 'EventDates' => function ($q) {
                return $q->contain('EventDateUsers', function ($q2) {
                    return $q2->contain('Users', function ($user) {
                        return $user->select(['id', 'name', 'family_name', 'given_name', 'picture', 'email']);
                    });
                });
            }]]);

        $this->set('event', $event);
        $this->set('_serialize', 'event');
        $this->response->body(json_encode($event));
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
        $this->response->header("Access-Control-Allow-Origin: *");
        $this->response->withHeader('Access-Control-Allow-Origin', '*');

        if ($this->request->is('post')) {
            $event = $this->Events->newEntity();
            $event = $this->Events->patchEntity($event, $this->request->getData());
            if ($this->Events->save($event)) {
                // save succeed

                $event_prospectives = "";
                // store dates associated events if needed
                $eventDatesTable = TableRegistry::get('EventDates');
                if (isset($this->request->getData()["dates"])) {
                    foreach ($this->request->getData()["dates"] as $date) {
                        $eventDate = $eventDatesTable->newEntity();
                        $eventDate->event_id = $event->id;
                        $eventDate->prospective_date = $date["prospective_date"];
                        if (isset($date["prospective_time"])) {
                            $eventDate->prospective_time = $date["prospective_time"];
                        }

                        $eventDatesTable->save($eventDate);
                        $event_prospectives = $event_prospectives . ", {$date["prospective_date"]}";
                    }
                }

                // store users associated events
                $eventUserTable = TableRegistry::get('EventUsers');
                if (isset($this->request->getData()["user_ids"])) {
                    foreach ($this->request->getData()["user_ids"] as $user_id) {
                        $eventUser = $eventUserTable->newEntity();
                        $eventUser->user_id = $user_id;
                        $eventUser->event_id = $event->id;
                        $eventUser->invited = true;

                        $eventUserTable->save($eventUser);
                    }
                }

                $emails = [];
                $userTable = TableRegistry::get('Users');
                if (isset($this->request->getData()["grades"])) {
                    foreach ($this->request->getData()["grades"] as $grade) {
                        $graded_users = $userTable->find('all')->where(['grade' => $grade]);

                        foreach ($graded_users as $graded_user) {
                            $eventUser = $eventUserTable->newEntity();
                            $eventUser->user_id = $graded_user->id;
                            $eventUser->event_id = $event->id;
                            $eventUser->invited = true;

                            $eventUserTable->save($eventUser);
                            array_push($emails, $graded_user->email);
                        }
                    }
                }

                $eventAsResponse = $this->Events->get($event->id, ['contain' =>
                    ['EventTypes', 'Users', 'EventDates' => function ($q) {
                        return $q->contain(['EventDateUsers']);
                    }]]);

                foreach ($eventAsResponse->users as $user) {
                    array_push($emails, $user->email);
                }

                $result = ["status" => true, "event" => $eventAsResponse];

                if (isset($this->request->getData()["should_send"])) {
                    $should_send = $this->request->getData()["should_send"] == 'true' ? true : false;
                } else {
                    $should_send = false;
                }

                if (count($emails) != 0 && $should_send == true) {
                    if (strlen($event_prospectives) > 2) {
                        $event_prospectives = substr($event_prospectives, 2);
                    } else {

                    }

                    $event_detail = "イベントについて\nイベント名: {$event->title}\n概要: {$event->description}\n入力期限日: {$event->deadline}\n候補日: {$event_prospectives}";

                    $email = new Email('default');
                    $email->from(['sasaki.scheduler@gmail.com' => 'Sasaki Scheduler'])
                        ->to($emails)
                        ->subject($event->title . ' - 佐々木研で新たなイベントの出席登録が開始されました')
                        ->send('佐々木研で, ' . $event->title . " の出席登録が開始されました.\n\n https://sasaki-scheduler.surge.sh より, 出席登録を行ってください. \n\n 入力期限日は[" . $event->deadline . "] となっているので, 早めの登録をお願いします.\n\n\n" . $event_detail);
                }
            } else {
                // save failed
                $result = ["status" => false];
            }
        } else if ($this->request->is('get')) {
            $eventTypeTable = TableRegistry::get('EventTypes');
            $userTable = TableRegistry::get('Users');
            $feedbackTable = TableRegistry::get('Feedbacks');

            $event_types = $eventTypeTable->find('all');
            $users = $userTable->find('all')->select(['id', 'name', 'family_name', 'given_name', 'picture', 'email', 'grade']);
            $grades = ['T', 'M2', 'M1', 'B4', 'B3', 'B2', 'B1'];
            $feedbacks = $feedbackTable->find('all', ['contain' => ['Users']]);

            $result = ['status' => true, 'event_types' => $event_types, 'users' => $users, 'grades' => $grades, 'feedbacks' => $feedbacks];
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
        $this->autoRender = false;
        $this->response->type('application/json');
        $this->response->header("Access-Control-Allow-Origin: *");

        $event = $this->Events->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $event = $this->Events->patchEntity($event, $this->request->getData());
            if ($this->Events->save($event)) {
                $result = ["status" => true];
            } else {
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
     * @param string|null $id Event id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->autoRender = false;
        $this->response->type('application/json');
        $this->response->header("Access-Control-Allow-Origin: *");

        $this->request->allowMethod(['post', 'delete']);
        $event = $this->Events->get($id);

        if ($this->Events->delete($event)) {
            $result = ["status" => true];
        } else {
            $result = ["status" => false];
        }

        $this->set('status', $result);
        $this->set('_serializer', 'status');
        $this->response->body(json_encode($result));
    }
}
