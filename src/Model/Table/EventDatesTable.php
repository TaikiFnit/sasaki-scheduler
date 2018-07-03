<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EventDates Model
 *
 * @property \App\Model\Table\EventsTable|\Cake\ORM\Association\BelongsTo $Events
 * @property \App\Model\Table\EventDateUsersTable|\Cake\ORM\Association\HasMany $EventDateUsers
 *
 * @method \App\Model\Entity\EventDate get($primaryKey, $options = [])
 * @method \App\Model\Entity\EventDate newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EventDate[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EventDate|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EventDate|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EventDate patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EventDate[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EventDate findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EventDatesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('event_dates');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Events', [
            'foreignKey' => 'event_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('EventDateUsers', [
            'foreignKey' => 'event_date_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->date('prospective_date')
            ->requirePresence('prospective_date', 'create')
            ->notEmpty('prospective_date');

        $validator
            ->time('prospective_time')
            ->requirePresence('prospective_time', 'create')
            ->notEmpty('prospective_time');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['event_id'], 'Events'));

        return $rules;
    }
}