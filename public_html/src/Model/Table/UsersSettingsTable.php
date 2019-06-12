<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UserSettings Model
 *
 * @method \App\Model\Entity\UserSettings get($primaryKey, $options = [])
 * @method \App\Model\Entity\UserSettings newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\UserSettings[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\UserSettings|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UserSettings patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\UserSettings[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\UserSettings findOrCreate($search, callable $callback = null)
 */
class UsersSettingsTable extends AppTable
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

        $this->table('users_settings');
        $this->displayField('value');
        $this->primaryKey('id');

        $this->hasOne(UsersTable::getAlias(), [
            'foreignKey' => 'id',
            'bindingKey' => 'user_id'
        ]);
    }

    public function getAll($userId = null)
    {
        $res = null;
        $userId = intval($userId);
        if($userId > 0) {
            $conditions = [
                'user_id' => $userId,
            ];
            $rows = $this->find(
                    'all',
                    [
                        'conditions' => $conditions,
                    ]
                );
            if($rows) {
                $res = [];
                foreach($rows as $key => $row) {
                    if(!isset($res[$row->block])) {
                        $res[$row->block] = [];
                    }
                    $res[$row->block][$row->name] = $row->value;
                }
            }
        }
        return $res;
    }

    public function getByBlock($userId = null, $settingsBlock = null, $settingsName = null)
    {
        $res = null;
        $userId = intval($userId);
        if($userId > 0) {
            $conditions = [
                'user_id' => $userId,
            ];
            if ($settingsBlock) {
                $conditions['block'] = $settingsBlock;
            }
            if($settingsName) {
                $conditions['name'] = $settingsName;
            }
            $rows = $this->find(
                'all',
                [
                    'conditions' => $conditions,
                ]
            );
            if($rows) {
                $res = [];
                foreach($rows as $key => $row) {
                    $res[$row->name] = $row->value;
                }
            }
        }
        return $res;
    }
}