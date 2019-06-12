<?php

namespace App\Model\Entity;

use Cake\I18n\Date;
use Cake\ORM\Entity;

/**
 * KycAttempts Entity
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $kyc_user_id
 * @property string $applicant_id
 * @property string $result
 * @property string $comment
 * @property Date $start
 * @property Date $finish
  */

class KycAttempts extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}