<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PlacarFinal Entity
 *
 * @property int $id
 * @property int $gols_casa
 * @property int $gols_visitante
 * @property int $jogos_id
 *
 * @property \App\Model\Entity\Jogo $jogo
 */
class PlacarFinal extends Entity
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
        'gols_casa' => true,
        'gols_visitante' => true,
        'jogos_id' => true,
        'jogo' => true
    ];
}
