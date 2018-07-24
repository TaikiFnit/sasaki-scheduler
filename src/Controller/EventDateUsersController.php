<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * EventDateUsers Controller
 *
 * @property \App\Model\Table\EventDateUsersTable $EventDateUsers
 *
 * @method \App\Model\Entity\EventDateUser[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EventDateUsersController extends AppController
{
    public function initialize()
    {
        $this->loadComponent('RequestHandler');
    }

    public function view($id = null)
    {
        $this->autoRender = false;
        $this->response->type('application/json');
        $this->response->header("Access-Control-Allow-Origin: *");

        $access_token = $this->request->query['access_token'];
        $fetchedUser = $this->fetchUserDataByAccessToken($access_token);

        if (array_key_exists('email', $fetchedUser)) {
            $usersTable = TableRegistry::get('Users');
            $eventsTable = TableRegistry::get('Events');
            $eventDatesTable = TableRegistry::get('EventDates');
            $user = $usersTable->find('all')->where(['email' => $fetchedUser['email']])->first();

            // TODO: i determine the event_id is ever there.
            $event = $eventsTable->get($id);
            // TIPS: in php, we have to pass parent variables using 'use' when we want to use any parent variable in closure func.
            $event_dates = $eventDatesTable->find('all')->contain('EventDateUsers', function ($q) use ($user) {
                return $q->where(['EventDateUsers.user_id' => $user->id]);
            })->where(['EventDates.event_id' => $event->id])->enableHydration(false)->toArray();

            $map_event_date_user = function ($event_date) {
                return $event_date['event_date_users'][0];
            };

            $filter_event_date_user = function ($event_date) {
                return count($event_date['event_date_users']) > 0;
            };

            $filtered_event_date_user = array_filter($event_dates, $filter_event_date_user);
            $maped_event_date_user = array_map($map_event_date_user, $filtered_event_date_user);

            $results = ['status' => true, 'event_date_users' => $maped_event_date_user];
        } else {
            $results = ['status' => false, 'message' => "Invalid access_token"];
        }

        // $this->set('event', $user);
        $this->set('_serialize', 'user');
        $this->response->body(json_encode($results));
    }

    public function add($id = null)
    {
        $this->autoRender = false;
        $this->response->type('application/json');
        $this->response->header("Access-Control-Allow-Origin: *");

        $access_token = $this->request->query['access_token'];
        $fetchedUser = $this->fetchUserDataByAccessToken($access_token);

        if (array_key_exists('email', $fetchedUser)) {

            $usersTable = TableRegistry::get('Users');
            $eventDateUser = $this->EventDateUsers->newEntity();

            $user = $usersTable->find('all')->where(['email' => $fetchedUser['email']])->first();

            if ($this->request->is('post')) {
                $requestedData = $this->request->getData();

                $eventDateUser = $this->EventDateUsers->patchEntity($eventDateUser, ['status' => $requestedData['status'], 'event_date_id' => $id, 'user_id' => $user->id]);

                if ($this->EventDateUsers->save($eventDateUser)) {
                    // save succeed
                    $result = ["status" => true, 'event_date_user' => $eventDateUser];
                } else {
                    // save failed
                    $result = ["status" => false, "message" => "Faild to save. check your request body is correct", "errors" => $eventDateUser->errors()];
                }
            } else {
                $result = ["status" => false, "message" => "API for /event_date_user/add is only for POST method"];
            }
        } else {
            $result = ["status" => false, "message" => "invalid access token"];
        }

        $this->set('status', $result);
        $this->set('_serializer', 'status');
        $this->response->body(json_encode($result));
    }

    public function delete($id = null)
    {
        $this->autoRender = false;
        $this->response->type('application/json');
        $this->response->header("Access-Control-Allow-Origin: *");

        $access_token = $this->request->query['access_token'];
        $fetchedUser = $this->fetchUserDataByAccessToken($access_token);

        $this->request->allowMethod(['post', 'delete', 'OPTIONS']);
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
