<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Event Entity
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $locale
 * @property int $event_type_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\EventType $event_type
 * @property \App\Model\Entity\EventDate[] $event_dates
 * @property \App\Model\Entity\EventUser[] $event_users
 */
class Event extends Entity
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
        'title' => true,
        'description' => true,
        'locale' => true,
        'deadline' => true,
        'event_type_id' => true,
        'created' => true,
        'modified' => true,
        'event_type' => true,
        'event_dates' => true,
        'event_users' => true,
    ];
}
