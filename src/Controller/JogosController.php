<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Jogos Controller
 *
 * @property \App\Model\Table\JogosTable $Jogos
 *
 * @method \App\Model\Entity\Jogo[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class JogosController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $conditions = [];
        if (!empty($this->request->getQuery('data'))) {
            $conditions = ['data' => $this->converterData($this->request->getQuery('data'))];
        }
        if (!empty($this->request->getQuery('rodada'))) {
            array_push($conditions, ['rodadas_id' => $this->request->getQuery('rodada')]);
        }
        $this->paginate['conditions'] = $conditions;
        $this->paginate['contain'] = ['Rodadas', 'Fora', 'Mandante'];
        $this->paginate['order'] = ['rodadas_id' => 'ASC', 'data' => 'asc', 'horario' => 'asc'];
        $this->paginate['fields'] = ['Jogos.rodadas_id', 'Jogos.id', 'Jogos.horario', 'Jogos.data', 'Rodadas.numero_rodada', 'Jogos.estadio', 'Mandante.descricao', 'Fora.descricao'];
        $this->paginate['group'] = ['Jogos.rodadas_id', 'Jogos.id', 'Jogos.horario', 'Jogos.data', 'Rodadas.numero_rodada', 'Jogos.estadio', 'Mandante.descricao', 'Fora.descricao'];
        $jogos = $this->paginate($this->Jogos);
        $rodadas = $this->Jogos->Rodadas->find('list', ['order' => ['numero_rodada' => 'asc']]);

        $this->set(compact('jogos', 'rodadas'));
    }

    /**
     * View method
     *
     * @param string|null $id Jogo id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $jogo = $this->Jogos->get($id, [
            'contain' => ['Rodadas']
        ]);

        $this->set('jogo', $jogo);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $jogo = $this->Jogos->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['data'] = $this->converterData($data['data']);
            $jogo = $this->Jogos->patchEntity($jogo, $this->request->getData());
            if ($this->Jogos->save($jogo)) {
                $this->Flash->success('Registro salvo com sucesso', ['key' => 'jogos']);

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Erro ao salvar registro! Tente novamente', ['key' => 'jogos']);
        }
        $rodadas = $this->Jogos->Rodadas->find('list', ['limit' => 200]);
        $casas = $this->Jogos->Mandante->find('list', ['keyField' => 'id_api']);
        $visitantes = $this->Jogos->Fora->find('list', ['keyField' => 'id_api']);
        $this->set(compact('jogo', 'rodadas', 'casas', 'visitantes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Jogo id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $jogo = $this->Jogos->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $data['data'] = $this->converterData($data['data']);
            $jogo = $this->Jogos->patchEntity($jogo, $this->request->getData());
            if ($this->Jogos->save($jogo)) {
                $this->Flash->success('Registro atualizado com sucesso', ['key' => 'jogos']);

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Erro ao atualizar registro! Tente novamente!', ['key' => 'jogos']);
        }
        $rodadas = $this->Jogos->Rodadas->find('list', ['limit' => 200]);
        $casas = $this->Jogos->Mandante->find('list', ['keyField' => 'id_api']);
        $visitantes = $this->Jogos->Fora->find('list', ['keyField' => 'id_api']);
        $this->set(compact('jogo', 'rodadas', 'casas', 'visitantes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Jogo id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $jogo = $this->Jogos->get($id);
        if ($this->Jogos->delete($jogo)) {
            $this->Flash->success('Registro excluído com sucesso', ['key' => 'jogos']);
        } else {
            $this->Flash->error('Erro ao excluir registro! Tente novamente', ['key' => 'jogos']);
        }

        return $this->redirect(['action' => 'index']);
    }

    public function consumirAPI()
    {
        $opt = \curl_init('http://jsuol.com.br/c/monaco/utils/gestor/commons.js?file=commons.uol.com.br/sistemas/esporte/modalidades/futebol/campeonatos/dados/2019/30/dados.json');
        \curl_setopt($opt, CURLOPT_RETURNTRANSFER, true);
        $retorno = \curl_exec($opt);
        \curl_close($opt);
        $dados = json_decode($retorno);
        $jogos = [];
        foreach ($dados->fases as $fase) {
            foreach ($fase->jogos->id as $i => $id) {
                $jogos[] = [
                    'data' => '1900-01-01', 'horario' => '00:00:00', 'estadio' => $id->estadio,
                    'rodadas_id' => $id->rodada, 'casa' => $id->time1, 'visitante' => $id->time2
                ];
            }
        }
        $entidades = $this->Jogos->newEntities($jogos);
        if ($this->Jogos->saveMany($entidades)) {
            $this->Flash->success('Sincronizado com sucesso!', 'jogos');
        } else {
            $this->Flash->error('Falha ao sincronizar dados!', 'jogos');
        }

        return $this->redirect(['action' => 'index']);
    }
}
