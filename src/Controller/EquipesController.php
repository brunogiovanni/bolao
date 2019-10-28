<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Equipes Controller
 *
 * @property \App\Model\Table\EquipesTable $Equipes
 *
 * @method \App\Model\Entity\Equipe[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EquipesController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
    }

    /**
     * Lista as equipes cadastradas
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $equipes = $this->paginate($this->Equipes);

        $this->set(compact('equipes'));
    }

    /**
     * View method
     *
     * @param string|null $id Equipe id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $equipe = $this->Equipes->get($id, [
            'contain' => []
        ]);

        $this->set('equipe', $equipe);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $equipe = $this->Equipes->newEntity();
        if ($this->request->is('post')) {
            $equipe = $this->Equipes->patchEntity($equipe, $this->request->getData());
            if ($this->Equipes->save($equipe)) {
                $this->Flash->success(__('The equipe has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The equipe could not be saved. Please, try again.'));
        }
        $this->set(compact('equipe'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Equipe id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $equipe = $this->Equipes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $equipe = $this->Equipes->patchEntity($equipe, $this->request->getData());
            if ($this->Equipes->save($equipe)) {
                $this->Flash->success(__('The equipe has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The equipe could not be saved. Please, try again.'));
        }
        $this->set(compact('equipe'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Equipe id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $equipe = $this->Equipes->get($id);
        if ($this->Equipes->delete($equipe)) {
            $this->Flash->success(__('The equipe has been deleted.'));
        } else {
            $this->Flash->error(__('The equipe could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Consome API para dados de equipes participantes do campeonato
     * 
     * @return type
     */
    public function consumirAPI()
    {
        $opt = \curl_init('http://jsuol.com.br/c/monaco/utils/gestor/commons.js?file=commons.uol.com.br/sistemas/esporte/modalidades/futebol/campeonatos/dados/2019/30/dados.json');
        \curl_setopt($opt, CURLOPT_RETURNTRANSFER, true);
        $retorno = \curl_exec($opt);
        \curl_close($opt);
        $dados = json_decode($retorno);
        $equipes = $idsApi = [];
        foreach ($dados->equipes as $equipe) {
            $idsApi[] = $equipe->id;
            $equipes[$equipe->id] = ['id_api' => $equipe->id, 'descricao' => $equipe->nome, 'brasao' => $equipe->brasao, 'ano' => date('Y')];
        }
        $this->_salvarDadosApi($equipes, $idsApi);
    }

    /**
     * Salva os dados da API no banco de dados
     * 
     * @param array $dadosApi
     * @param array $idsApi
     */
    private function _salvarDadosApi($dadosApi, $idsApi = [])
    {
        if (!empty($idsApi)) {
            $equipesDB = $this->Jogos->find('all', ['conditions' => ['id IN' => $idsApi]]);
            foreach ($equipesDB as $equipe) {
                unset($dadosApi[$equipe->id_api]);
            }
        }
        $jogos = $this->Jogos->newEntities($dadosApi);

        if ($this->Jogos->saveMany($jogos)) {
            $this->Flash->success('Sincronizado com sucesso!', ['key' => 'jogos']);
        } else {
            $this->Flash->error('Falha ao sincronizar!', ['key' => 'jogos']);
        }

        return $this->redirect(['action' => 'index']);
    }
}
