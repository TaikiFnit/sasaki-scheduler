<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EventDate Entity
 *
 * @property int $id
 * @property int $event_id
 * @property \Cake\I18n\FrozenDate $prospective_date
 * @property \Cake\I18n\FrozenTime $prospective_time
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Event $event
 * @property \App\Model\Entity\EventDateUser[] $event_date_users
 */
class EventDate extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'event_id' => true,
        'prospective_date' => true,
        'prospective_time' => true,
        'created' => true,
        'modified' => true,
        'event' => true,
        'event_date_users' => true
    ];
}
