<?php

namespace App\Model\Entity;

use Cake\I18n\Date;
use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string $phone
 * @property string $wallet
 * @property string $clickid
 * @property string $otp_hash
 * @property int $status
 * @property int $country
 * @property int $name
 * @property int $ref_user
 * @property int $age
 * @property int $is_admin
 * @property int $kyc_reached
 * @property int $personal_bonus
 * @property int $personal_referal_bonus
 * @property int $bonus_for_referals
 * @property float $balance
 * @property float $tokens
 * @property float $in_chain
 * @property float $tokens_bonus
 * @property Date $created
 * @property Transaction[] $transactions
 * @property string registration_data
 */
class User extends Entity
{

    const STATUS_NOTVERIFY = 0;
    const STATUS_VERIFIED = 1;

    const KYC_REACHED = 1;
    const KYC_NOT_REACHED = 0;

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
        '*'  => true,
        'id' => false,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
    ];

    /**
     * Get SAFT data (filled on registration)
     *
     * @return mixed|null
     */
    public function getSaftData()
    {


        if (!$this->registration_data) {
            return null;
        }

        if (is_array($this->registration_data)) {
            return $this->registration_data;
        }

        return json_decode(
            $this->registration_data
        );
    }
}
