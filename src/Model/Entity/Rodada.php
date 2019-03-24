<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Rodada Entity
 *
 * @property int $id
 * @property int $numero_rodada
 * @property \Cake\I18n\FrozenDate $data_inicio
 * @property \Cake\I18n\FrozenDate $data_final
 */
class Rodada extends Entity
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
        'numero_rodada' => true,
        'data_inicio' => true,
        'data_final' => true
    ];
}