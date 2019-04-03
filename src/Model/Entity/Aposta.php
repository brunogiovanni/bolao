<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Aposta Entity
 *
 * @property int $id
 * @property int $users_id
 * @property int $jogos_id
 * @property string $aposta
 * @property int $equipes_id
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
        'aposta' => true,
        'equipes_id' => true,
        'users_id' => true,
        'jogos_id' => true,
        'user' => true,
        'jogo' => true,
        'equipe' => true
    ];
}
