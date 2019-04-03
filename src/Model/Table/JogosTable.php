<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Jogos Model
 *
 * @property \App\Model\Table\RodadasTable|\Cake\ORM\Association\BelongsTo $Rodadas
 *
 * @method \App\Model\Entity\Jogo get($primaryKey, $options = [])
 * @method \App\Model\Entity\Jogo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Jogo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Jogo|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Jogo|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Jogo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Jogo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Jogo findOrCreate($search, callable $callback = null, $options = [])
 */
class JogosTable extends Table
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

        $this->setTable('jogos');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Rodadas', [
            'foreignKey' => 'rodadas_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Fora', [
            'className' => 'Equipes',
            'foreignKey' => 'visitante',
            'bindingKey' => 'id_api',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Mandante', [
            'className' => 'Equipes',
            'foreignKey' => 'casa',
            'bindingKey' => 'id_api',
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
            ->date('data')
            ->requirePresence('data', 'create')
            ->allowEmptyDate('data', false);

        $validator
            ->time('horario')
            ->requirePresence('horario', 'create')
            ->allowEmptyTime('horario', false);

        $validator
            ->scalar('estadio')
            ->maxLength('estadio', 150)
            ->requirePresence('estadio', 'create')
            ->allowEmptyString('estadio', false);

        $validator
            ->scalar('placar_final')
            ->maxLength('placar_final', 5)
            ->allowEmptyString('placar_final', true);

        $validator
            ->integer('visitante')
            ->allowEmptyString('visitante', 'create');

        $validator
            ->integer('casa')
            ->allowEmptyString('casa', 'create');

        $validator
            ->integer('vencedor')
            ->allowEmptyString('vencedor', 'create');

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
        $rules->add($rules->existsIn(['rodadas_id'], 'Rodadas'));

        return $rules;
    }
}
