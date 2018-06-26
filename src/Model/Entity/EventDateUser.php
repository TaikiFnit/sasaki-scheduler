<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EventDateUser Entity
 *
 * @property int $id
 * @property int $event_date_id
 * @property int $user_id
 * @property int $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\EventDate $event_date
 * @property \App\Model\Entity\User $user
 */
class EventDateUser extends Entity
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
        'event_date_id' => true,
        'user_id' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'event_date' => true,
        'user' => true
    ];
}
