<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;

/**
 * User Entity
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $nome
 * @property string $email
 * @property int $group_id
 * @property string $atitvo
 *
 * @property \App\Model\Entity\Group $group
 */
class User extends Entity
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
        'username' => true,
        'password' => true,
        'nome' => true,
        'email' => true,
        'group_id' => true,
        'group' => true,
        'ativo' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];

    /**
     * Método para hashear a senha informada
     *
     * @param string $password Senha informada no formulário
     * @return string Hash da senha
     */
    protected function _setPassword($password)
    {
        return (new DefaultPasswordHasher)->hash($password);
    }

    public function parentNode()
    {
        if (!$this->id) {
            return null;
        }
        if (isset($this->group_id)) {
            $groupId = $this->group_id;
        } else {
            $Users = TableRegistry::get('Users');
            $user = $Users->find('all', ['fields' => ['group_id']])->where(['id' => $this->id])->first();
            $groupId = $user->group_id;
        }
        if (!$groupId) {
            return null;
        }
        $Groups = TableRegistry::get('Groups');
        return $Groups->find('all', ['conditions' => ['id' => $groupId]])->first();
    }
}
