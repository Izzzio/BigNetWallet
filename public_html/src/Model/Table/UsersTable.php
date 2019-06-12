<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null)
 */
class UsersTable extends AppTable
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

        $this->table('users');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->hasMany(TransactionsTable::getAlias(), [
            'foreignKey' => 'user_id',
            'bindingKey' => 'id'
        ]);

        $this->hasMany('ADmad/HybridAuth.SocialProfiles');
        \Cake\Event\EventManager::instance()->on('HybridAuth.newUser', [$this, 'createUser']);

        $this->hasMany(UsersSettingsTable::getAlias(), [
            'foreignKey' => 'user_id',
            'bindingKey' => 'id'
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
            ->requirePresence('email', 'create')
            ->notEmpty('email');

        $validator
            ->requirePresence('phone', 'create')
            ->allowEmpty('phone');;

        $validator
            ->requirePresence('password', 'create')
            ->allowEmpty('password');


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
        $rules->add($rules->isUnique(['email']));

        return $rules;
    }

    public function createUser(\Cake\Event\Event $event) {
        // Entity representing record in social_profiles table
        $profileSocial = $event->data()['profile'];

        // Make sure here that all the required fields are actually present
        $email = $profileSocial->email_verified ? $profileSocial->email_verified : ($profileSocial->email ? $profileSocial->email : 0);
        $name = $profileSocial->first_name.' '.$profileSocial->last_name;
        if(empty(trim($name))) {
            $name = $profileSocial->display_name;
        }
        if(empty(trim($name)) && 0 != $email) {
            $name = $email;
        }
        $user = $this->newEntity(
            [
                'email' => $email,
                'phone' => $profileSocial->phone,
                'password'  => '',
                'status' => 1,
                'name'  => $name,
                'country'   => $profileSocial->country,
            ]
        );
        $user = $this->save($user);

        if (!$user) {
            throw new \RuntimeException('Unable to save new user');
        }

        return $user;
    }
}
