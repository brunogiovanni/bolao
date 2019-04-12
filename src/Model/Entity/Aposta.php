<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Aposta Entity
 *
 * @property int $id
 * @property int $users_id
 * @property int $jogos_id
 * @property int $placar1
 * @property int $placar2
 * @property int $vencedor
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Jogo $jogo
 * @property \App\Model\Entity\Equipe $equipe
 */
class Aposta extends Entity
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
        'placar1' => true,
        'placar2' => true,
        'vencedor' => true,
        'users_id' => true,
        'jogos_id' => true,
        'user' => true,
        'jogo' => true,
        'equipe' => true
    ];
}
