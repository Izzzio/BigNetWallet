<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Logs Model
 *
 * @method \App\Model\Entity\Log get($primaryKey, $options = [])
 * @method \App\Model\Entity\Log newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Log[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Log|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Log patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Log[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Log findOrCreate($search, callable $callback = null)
 */
class LogTable extends AppTable
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

        $this->table('logs');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->hasOne(UsersTable::getAlias(), [
            'foreignKey' => 'id',
            'bindingKey' => 'user_id',
        ]);
    }

    /**
     * Writes data to info log
     * @param string $type
     * @param string|array $data
     * @param null|int $userId
     */
    public static function write($type, $data = null, $userId = null)
    {
        if (!is_string($data)) {
            $data = json_encode($data);
        }
        $entity = self::instance()->newEntity([
            'type'    => $type,
            'user_id' => $userId,
            'data'    => $data,
        ]);

        self::instance()->save($entity);
    }

}
