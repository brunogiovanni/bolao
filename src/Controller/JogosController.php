<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Jogos Controller
 *
 * @property \App\Model\Table\JogosTable $Jogos
 *
 * @method \App\Model\Entity\Jogo[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class JogosController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Rodadas', 'Fora', 'Mandante'],
            'order' => ['rodadas_id' => 'ASC', 'data' => 'asc', 'horario' => 'asc']
        ];
        $jogos = $this->paginate($this->Jogos);

        $this->set(compact('jogos'));
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
            $jogo = $this->Jogos->patchEntity($jogo, $this->request->getData());
            if ($this->Jogos->save($jogo)) {
                $this->Flash->success(__('The jogo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The jogo could not be saved. Please, try again.'));
        }
        $rodadas = $this->Jogos->Rodadas->find('list', ['limit' => 200]);
        $this->set(compact('jogo', 'rodadas'));
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
        $jogo = $this->Jogos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $jogo = $this->Jogos->patchEntity($jogo, $this->request->getData());
            if ($this->Jogos->save($jogo)) {
                $this->Flash->success(__('The jogo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The jogo could not be saved. Please, try again.'));
        }
        $rodadas = $this->Jogos->Rodadas->find('list', ['limit' => 200]);
        $this->set(compact('jogo', 'rodadas'));
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
            $this->Flash->success(__('The jogo has been deleted.'));
        } else {
            $this->Flash->error(__('The jogo could not be deleted. Please, try again.'));
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
            $this->Flash->success('Sincronizado com sucesso!');
        } else {
            $this->Flash->error('Falha ao sincronizar dados!');
        }

        return $this->redirect(['action' => 'index']);
    }
}
