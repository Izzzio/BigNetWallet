<?php

namespace App\Model\Table;

/**
 * KYC attempts Model
 *
 * @method \App\Model\Entity\KycAttempts get($primaryKey, $options = [])
 * @method \App\Model\Entity\KycAttempts newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\KycAttempts[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\KycAttempts|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\KycAttempts patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\KycAttempts[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\KycAttempts findOrCreate($search, callable $callback = null)
 */
class KycAttemptsTable extends AppTable
{
    public function initialize(array $config)
    {
        $this->table('kyc_attempts');
        $this->hasOne(UsersTable::getAlias(), [
            'foreignKey' => 'id',
            'bindingKey' => 'user_id'
        ]);
    }

    public function findLastAttempt($userId = null, $KYCUserId = null)
    {
        $userId = intval($userId);
        $conditions = [
            'user_id' => $userId,
            'kyc_user_id' => $KYCUserId,
        ];
        $row = $this
            ->find(
                'all',
                [
                    'conditions' => $conditions,
                ]
            )
            ->order(
                [
                    'start' => 'DESC'
                ]
            )
            ->first();
        return $row;
    }
}