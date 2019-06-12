<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Card Entity
 *
 * @property int $id
 * @property string $barcode
 * @property int $customer
 * @property int $enter_from
 * @property int $enter_to
 * @property \Cake\I18n\Time $due_date
 * @property \Cake\I18n\Time $created
 * @property string $description
 * @property string $tariff
 * @property string $agreement
 * @property string payment_type
 * @property float price
 * @property string start
 */
class Card extends Entity
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
        '*' => true,
        'id' => false
    ];
}
