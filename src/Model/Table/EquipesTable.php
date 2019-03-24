<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Equipes Model
 *
 * @method \App\Model\Entity\Equipe get($primaryKey, $options = [])
 * @method \App\Model\Entity\Equipe newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Equipe[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Equipe|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Equipe|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Equipe patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Equipe[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Equipe findOrCreate($search, callable $callback = null, $options = [])
 */
class EquipesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('equipes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('descricao')
            ->maxLength('descricao', 150)
            ->requirePresence('descricao', 'create')
            ->allowEmptyString('descricao', false);

        $validator
            ->scalar('brasao')
            ->maxLength('brasao', 200)
            ->allowEmptyString('brasao');

        $validator
            ->scalar('ano')
            ->maxLength('ano', 4)
            ->requirePresence('ano', 'create')
            ->allowEmptyString('ano', false);

        $validator
            ->integer('id_api')
            ->requirePresence('id_api', 'create')
            ->allowEmptyString('id_api', false);

        return $validator;
    }
}
