<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Jogo Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenDate $data
 * @property \Cake\I18n\FrozenTime $horario
 * @property string $estadio
 * @property int $rodadas_id
 * @property int $visitante
 * @property int $casa
 * @property string $placar_final
 * @property int $vencedor
 *
 * @property \App\Model\Entity\Rodada $rodada
 */
class Jogo extends Entity
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
        'id' => true,
        'data' => true,
        'horario' => true,
        'estadio' => true,
        'rodadas_id' => true,
        'visitante' => true,
        'casa' => true,
        'placar_final' => true,
        'vencedor' => true,
        'rodada' => true
    ];
}
