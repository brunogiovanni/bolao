<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Regras Model
 *
 * @method \App\Model\Entity\Regra get($primaryKey, $options = [])
 * @method \App\Model\Entity\Regra newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Regra[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Regra|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Regra|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Regra patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Regra[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Regra findOrCreate($search, callable $callback = null, $options = [])
 */
class RegrasTable extends Table
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

        $this->setTable('regras');
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
            ->maxLength('descricao', 100)
            ->requirePresence('descricao', 'create')
            ->allowEmptyString('descricao', false)
            ->add('descricao', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Regra já cadastrada!']);

        $validator
            ->integer('pontos')
            ->requirePresence('pontos', 'create')
            ->allowEmptyString('pontos', false);

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['descricao'], 'Regra já cadastrada!'));

        return $rules;
    }
}
