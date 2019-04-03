<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Apostas Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\JogosTable|\Cake\ORM\Association\BelongsTo $Jogos
 * @property \App\Model\Table\EquipesTable|\Cake\ORM\Association\BelongsTo $Equipes
 *
 * @method \App\Model\Entity\Aposta get($primaryKey, $options = [])
 * @method \App\Model\Entity\Aposta newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Aposta[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Aposta|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Aposta|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Aposta patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Aposta[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Aposta findOrCreate($search, callable $callback = null, $options = [])
 */
class ApostasTable extends Table
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

        $this->setTable('apostas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'users_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Jogos', [
            'foreignKey' => 'jogos_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Equipes', [
            'foreignKey' => 'equipes_id',
            'joinType' => 'INNER'
        ]);

        $this->hasOne('Pontos', [
            'foreignKey' => 'apostas_id'
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
            ->scalar('aposta')
            ->maxLength('aposta', 50)
            ->requirePresence('aposta', 'create')
            ->allowEmptyString('aposta', false);

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
        $rules->add($rules->existsIn(['users_id'], 'Users'));
        $rules->add($rules->existsIn(['jogos_id'], 'Jogos'));
        // $rules->add($rules->existsIn(['equipes_id'], 'Equipes'));

        return $rules;
    }
}
