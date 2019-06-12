<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * User settings Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $block
 * @property string $name
 * @property string $value
 */

class UserSettings extends Entity
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
        '*'  => true,
        'id' => false,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [];

    /**
     * Get SAFT data (filled on registration)
     *
     * @return mixed|null
     */
    public function isTwoFactorAuthEnabled()
    {
        return $this->two_factor_auth ? $this->two_factor_auth : null;
    }
}