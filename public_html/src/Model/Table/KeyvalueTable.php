<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Keyvalues Model
 *
 * @method \App\Model\Entity\Keyvalue get($primaryKey, $options = [])
 * @method \App\Model\Entity\Keyvalue newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Keyvalue[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Keyvalue|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Keyvalue patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Keyvalue[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Keyvalue findOrCreate($search, callable $callback = null)
 */
class KeyvalueTable extends AppTable
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

        $this->table('keyvalue');
        $this->displayField('id');
        $this->primaryKey('id');
    }

}
