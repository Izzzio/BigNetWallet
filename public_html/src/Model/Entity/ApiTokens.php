<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * User settings Entity
 *
 * @property string $token
 * @property int $user_id
 * @property date $expiration
 */

class ApiTokens extends Entity
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
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [];
}