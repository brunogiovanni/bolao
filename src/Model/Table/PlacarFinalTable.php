<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PlacarFinal Model
 *
 * @property \App\Model\Table\JogosTable|\Cake\ORM\Association\BelongsTo $Jogos
 *
 * @method \App\Model\Entity\PlacarFinal get($primaryKey, $options = [])
 * @method \App\Model\Entity\PlacarFinal newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PlacarFinal[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PlacarFinal|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlacarFinal|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlacarFinal patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PlacarFinal[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PlacarFinal findOrCreate($search, callable $callback = null, $options = [])
 */
class PlacarFinalTable extends Table
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

        $this->setTable('placar_final');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Jogos', [
            'foreignKey' => 'jogos_id',
            'joinType' => 'INNER'
        ]);
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
            ->integer('gols_casa')
            ->requirePresence('gols_casa', 'create')
            ->allowEmptyString('gols_casa', false);

        $validator
            ->integer('gols_visitante')
            ->requirePresence('gols_visitante', 'create')
            ->allowEmptyString('gols_visitante', false);

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
        $rules->add($rules->existsIn(['jogos_id'], 'Jogos'));

        return $rules;
    }
}
