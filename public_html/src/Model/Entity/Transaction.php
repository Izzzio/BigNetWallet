<?php

namespace App\Model\Entity;

use Cake\I18n\Date;
use Cake\ORM\Entity;

/**
 * Transaction Entity
 *
 * @property int $id
 * @property float $amount
 * @property string $currency
 * @property integer $user_id
 * @property Date $created
 * @property float $usd
 * @property string $rawdata
 * @property string $currencys_rate
 * @property string $type
 * @property integer $entity_id
 */
class Transaction extends Entity
{

    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}