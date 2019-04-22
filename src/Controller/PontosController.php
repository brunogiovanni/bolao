<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Pontos Controller
 *
 * @property \App\Model\Table\PontosTable $Pontos
 *
 * @method \App\Model\Entity\Ponto[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PontosController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->loadModel('Regras');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($jogoId = null)
    {
        $jogo = [];
        $this->paginate['fields'] = ['Pontos.id', 'Pontos.pontos', 'Users.nome', 'Apostas.id', 'Jogos.id', 'Fora.brasao', 'Fora.descricao', 'Mandante.brasao', 'Mandante.descricao'];
        $this->paginate['contain'] = ['Users', 'Apostas' => ['Jogos' => ['Fora', 'Mandante']]];
        if ($this->Auth->user('group_id') === 3) {
            $this->paginate['conditions'] = ['Pontos.users_id' => $this->Auth->user('id')];
        }
        if (!empty($jogoId)) {
            array_push($this->paginate['conditions'], ['Apostas.jogos_id' => $jogoId]);
            $jogo = $this->Pontos->Apostas->Jogos->get($jogoId, [
                'contain' => ['Fora', 'Mandante']
            ]);
        }
        $pontos = $this->paginate($this->Pontos);

        $this->set(compact('pontos', 'jogo'));
    }

    /**
     * View method
     *
     * @param string|null $id Ponto id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ponto = $this->Pontos->get($id, [
            'contain' => ['Users', 'Apostas']
        ]);

        $this->set('ponto', $ponto);
    }

    public function contabilizarPontos($jogoId)
    {
        $this->request->allowMethod(['post']);

        // $regras = $this->Regras->find('all');
        $apostas = $this->Pontos->Apostas->find('all', [
            'conditions' => ['jogos_id' => $jogoId]
        ]);
        $jogo = $this->Pontos->Apostas->Jogos->get($jogoId);
        $data = [];
        foreach ($apostas as $aposta) {
            if ($aposta->placar1 === $jogo->placar1 && $aposta->placar2 === $jogo->placar2) {
                $data[] = ['pontos' => 10, 'users_id' => $aposta->users_id, 'apostas_id' => $aposta->id];
            } elseif (($aposta->placar1 === $jogo->placar1 || $aposta->placar2 === $jogo->placar2) && ((!empty($jogo->vencedor) && $aposta->vencedor !== 0) && $jogo->vencedor === $aposta->vencedor)) {
                $data[] = ['pontos' => 7, 'users_id' => $aposta->users_id, 'apostas_id' => $aposta->id];
            } elseif ((!empty($jogo->vencedor) && $aposta->vencedor !== 0) && ($jogo->vencedor === $aposta->vencedor)) {
                $data[] = ['pontos' => 5, 'users_id' => $aposta->users_id, 'apostas_id' => $aposta->id];
            } elseif ($aposta->placar1 === $jogo->placar1 || $aposta->placar2 === $jogo->placar2) {
                $data[] = ['pontos' => 2, 'users_id' => $aposta->users_id, 'apostas_id' => $aposta->id];
            } else {
                $data[] = ['pontos' => 0, 'users_id' => $aposta->users_id, 'apostas_id' => $aposta->id];
            }
        }
        $pontos = $this->Pontos->newEntities($data);
        if ($this->Pontos->saveMany($pontos)) {
            $this->Flash->success('Pontos contabilizados como sucesso', ['key' => 'pontos']);
            return $this->redirect(['action' => 'index', $jogoId]);
        }
        $this->Flash->error('Erro ao contabilizar pontos! Tente novamente!', ['key' => 'apostas']);
        return $this->redirect(['controller' => 'Apostas', 'action' => 'index', $jogoId]);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ponto = $this->Pontos->newEntity();
        if ($this->request->is('post')) {
            $ponto = $this->Pontos->patchEntity($ponto, $this->request->getData());
            if ($this->Pontos->save($ponto)) {
                $this->Flash->success(__('The ponto has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ponto could not be saved. Please, try again.'));
        }
        $users = $this->Pontos->Users->find('list', ['limit' => 200]);
        $apostas = $this->Pontos->Apostas->find('list', ['limit' => 200]);
        $this->set(compact('ponto', 'users', 'apostas'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Ponto id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ponto = $this->Pontos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ponto = $this->Pontos->patchEntity($ponto, $this->request->getData());
            if ($this->Pontos->save($ponto)) {
                $this->Flash->success(__('The ponto has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ponto could not be saved. Please, try again.'));
        }
        $users = $this->Pontos->Users->find('list', ['limit' => 200]);
        $apostas = $this->Pontos->Apostas->find('list', ['limit' => 200]);
        $this->set(compact('ponto', 'users', 'apostas'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Ponto id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ponto = $this->Pontos->get($id);
        if ($this->Pontos->delete($ponto)) {
            $this->Flash->success(__('The ponto has been deleted.'));
        } else {
            $this->Flash->error(__('The ponto could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function placarGeral()
    {
        $pontos = $this->Pontos->find('all', [
            'fields' => ['Pontos.id', 'Pontos.pontos', 'Users.id', 'Users.nome'],
            'contain' => ['Users']
        ]);

        $totalPontos = [];
        foreach ($pontos as $ponto) {
            if (!isset($totalPontos[$ponto->user->id])) {
                $totalPontos[$ponto->user->id] = ['pontos' => $ponto->pontos, 'usuario' => $ponto->user->nome];
            } else {
                $totalPontos[$ponto->user->id]['pontos'] += $ponto->pontos;
            }
        }
        arsort($totalPontos);

        $this->set(compact('totalPontos'));
    }
}
