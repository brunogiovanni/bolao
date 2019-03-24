<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Rodadas Controller
 *
 * @property \App\Model\Table\RodadasTable $Rodadas
 *
 * @method \App\Model\Entity\Rodada[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RodadasController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $rodadas = $this->paginate($this->Rodadas);

        $this->set(compact('rodadas'));
    }

    /**
     * View method
     *
     * @param string|null $id Rodada id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $rodada = $this->Rodadas->get($id, [
            'contain' => []
        ]);

        $this->set('rodada', $rodada);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $rodada = $this->Rodadas->newEntity();
        if ($this->request->is('post')) {
            $rodada = $this->Rodadas->patchEntity($rodada, $this->request->getData());
            if ($this->Rodadas->save($rodada)) {
                $this->Flash->success(__('The rodada has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The rodada could not be saved. Please, try again.'));
        }
        $this->set(compact('rodada'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Rodada id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $rodada = $this->Rodadas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $rodada = $this->Rodadas->patchEntity($rodada, $this->request->getData());
            if ($this->Rodadas->save($rodada)) {
                $this->Flash->success(__('The rodada has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The rodada could not be saved. Please, try again.'));
        }
        $this->set(compact('rodada'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Rodada id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $rodada = $this->Rodadas->get($id);
        if ($this->Rodadas->delete($rodada)) {
            $this->Flash->success(__('The rodada has been deleted.'));
        } else {
            $this->Flash->error(__('The rodada could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function consumirAPI()
    {
        $opt = \curl_init('http://jsuol.com.br/c/monaco/utils/gestor/commons.js?file=commons.uol.com.br/sistemas/esporte/modalidades/futebol/campeonatos/dados/2019/30/dados.json');
        \curl_setopt($opt, CURLOPT_RETURNTRANSFER, true);
        $retorno = \curl_exec($opt);
        $dados = json_decode($retorno);
        $rodadas = [];
        foreach ($dados->fases as $fase) {
            for ($i = 1; $i <= $fase->rodada->total; $i++) {
                $rodadas[] = ['numero_rodada' => $i, 'data_inicio' => '1900-01-01', 'data_final' => '1900-01-01'];
            }
        }
        $entidades = $this->Rodadas->newEntities($rodadas);
        if ($this->Rodadas->saveMany($entidades)) {
            $this->Flash->success('Sincronizado com sucesso!');
        } else {
            $this->Flash->error('Falha ao sincronizar dados!');
        }

        return $this->redirect(['action' => 'index']);
    }
}
