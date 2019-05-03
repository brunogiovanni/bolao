<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Apostas Controller
 *
 * @property \App\Model\Table\ApostasTable $Apostas
 *
 * @method \App\Model\Entity\Aposta[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ApostasController extends AppController
{
    /**
     * Index method
     *
     * @param int $jogoId
     * @return \Cake\Http\Response|void
     */
    public function index($jogoId = null)
    {
        $this->paginate['contain'] = [
            'Users' => ['sort' => ['Users.nome' => 'asc']], 'Jogos' => ['Fora', 'Mandante', 'Rodadas'],
            'Pontos'
        ];
        $jogo = $prazoHora = $horaPosJogo = $pontos = '';
        if (!empty($jogoId)) {
            $this->paginate['conditions'] = ['jogos_id' => $jogoId];
            $jogo = $this->Apostas->Jogos->get($jogoId, [
                'contain' => ['Fora', 'Mandante']
            ]);
            $prazoHora = date('Y-m-d H:i', strtotime('-30 minutes', strtotime($jogo->data->format('Y-m-d') . 'T' . $jogo->horario->format('H:i'))));
            $horaPosJogo = date('H:i', strtotime('+2 hours', strtotime($jogo->data->format('Y-m-d') . 'T' . $jogo->horario->format('H:i'))));
            $pontos = $this->_verificarPontosContabilizados($jogoId);
        }
        $filtros = $this->request->getQuery();
        if (isset($filtros['users_id']) && !empty($filtros['users_id'])) {
            array_push($this->paginate['conditions'], ['Apostas.users_id' => $filtros['users_id']]);
        }
        if (isset($filtros['rodadas']) && !empty($filtros['rodadas'])) {
            array_push($this->paginate['conditions'], ['Rodadas.id' => $filtros['rodadas']]);
        }
        // $this->paginate['order'] = ['users_id' => 'asc'];
        $apostas = $this->paginate($this->Apostas);

        $users = $this->Apostas->Users->find('list', [
            'conditions' => ['id NOT IN' => [1, 7]],
            'order' => ['nome' => 'ASC']
        ]);
        $rodadas = $this->Apostas->Jogos->Rodadas->find('list', ['conditions' => ['numero_rodada IN' => [1, 2]]]);
        $this->set(compact('apostas', 'jogo', 'prazoHora', 'horaPosJogo', 'pontos', 'users', 'rodadas'));
    }

    private function _verificarPontosContabilizados($jogoId)
    {
        $apostas = $this->Apostas->find('all', [
            'contain' => ['Pontos'],
            'conditions' => ['jogos_id' => $jogoId, 'users_id' => $this->Auth->user('id')]
        ]);

        $pontos = 0;
        foreach ($apostas as $aposta) {
            if (!empty($aposta->ponto)) {
                $pontos++;
            }
        }

        return $pontos;
    }

    /**
     * View method
     *
     * @param string|null $id Aposta id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $aposta = $this->Apostas->get($id, [
            'contain' => ['Users', 'Jogos']
        ]);

        $this->set('aposta', $aposta);
    }

    /**
     * Add method
     *
     * @param int $jogoId
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($jogoId)
    {
        $jogo = $this->Apostas->Jogos->get($jogoId, [
            'contain' => ['Fora', 'Mandante']
        ]);
        $prazoHora = date('Y-m-d H:i', strtotime('-30 minutes', strtotime($jogo->data->format('Y-m-d') . 'T' . $jogo->horario->format('H:i'))));
        if ((strtotime(date('Y-m-d')) <= strtotime($jogo->data->format('Y-m-d'))) && (strtotime(date('H:i')) < strtotime($prazoHora))) {
            $quantidadeApostas = $this->_verificarApostasUsuario($jogoId);
            if ($quantidadeApostas <= 0) {
                $aposta = $this->Apostas->newEntity();
                if ($this->request->is('post')) {
                    $data = $this->request->getData();
                    $data['users_id'] = $this->Auth->user('id');
                    $data['jogos_id'] = $jogoId;
                    if ($data['placar1'] > $data['placar2']) {
                        $data['vencedor'] = $jogo->time1;
                    } elseif ($data['placar1'] < $data['placar2']) {
                        $data['vencedor'] = $jogo->time2;
                    } else {
                        $data['vencedor'] = 0;
                    }
                    $aposta = $this->Apostas->patchEntity($aposta, $data);
                    if ($this->Apostas->save($aposta)) {
                        $logs = [];
                        $logs['users_id'] = $this->Auth->user('id');
                        $logs['tela'] = '/apostas/add/' . $aposta->id;
                        $logs['created'] = date('Y-m-d H:i:s');
                        $this->salvarLog($logs);
                        $this->Flash->success('Aposta salva com sucesso!', ['key' => 'apostas']);

                        return $this->redirect(['action' => 'index', $jogoId]);
                    }
                    $this->Flash->error('Erro ao salvar aposta! Tente novamente!', ['key' => 'apostas']);
                }
                $equipes = [
                    $jogo->fora->id => $jogo->fora->descricao,
                    $jogo->mandante->id => $jogo->mandante->descricao,
                ];
                $this->set(compact('aposta', 'users', 'jogo', 'equipes'));
            } else {
                $this->Flash->error('Já fez uma aposta para este jogo! Não é possível realizar outra!', ['key' => 'apostas']);
                return $this->redirect(['action' => 'index', $jogoId]);
            }
        } else {
            $this->Flash->info('Apostas encerradas', ['key' => 'apostas']);
            $this->redirect(['action' => 'index', $jogoId]);
        }
    }

    /**
     * Verifica se usuário já realizou alguma aposta para o jogo selecionado
     *
     * @param int $jogoId
     *
     * @return int Quantidade de apostas
     */
    private function _verificarApostasUsuario($jogoId)
    {
        $apostas = $this->Apostas->find('all', [
            'conditions' => ['users_id' => $this->Auth->user('id'), 'jogos_id' => $jogoId]
        ]);

        return $apostas->count();
    }

    /**
     * Edit method
     *
     * @param string|null $id Aposta id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $aposta = $this->Apostas->get($id, [
            'contain' => ['Jogos' => ['Mandante', 'Fora']],
            'conditions' => ['Apostas.users_id' => $this->Auth->user('id')]
        ]);
        $prazoHora = date('Y-m-d H:i', strtotime('-30 minutes', strtotime($aposta->jogo->data->format('Y-m-d') . 'T' . $aposta->jogo->horario->format('H:i'))));
        if ((strtotime(date('Y-m-d')) <= strtotime($aposta->jogo->data->format('Y-m-d'))) && (strtotime(date('H:i')) < strtotime($prazoHora))) {
            if ($this->request->is(['patch', 'post', 'put'])) {
                $data = $this->request->getData();
                $data['users_id'] = $this->Auth->user('id');
                $data['jogos_id'] = $aposta->jogos_id;
                $aposta = $this->Apostas->patchEntity($aposta, $data);
                if ($this->Apostas->save($aposta)) {
                    $logs = [];
                    $logs['users_id'] = $this->Auth->user('id');
                    $logs['tela'] = '/apostas/edit/' . $id;
                    $logs['created'] = date('Y-m-d H:i:s');
                    $this->salvarLog($logs);
                    $this->Flash->success('Aposta atualizada com sucesso!', ['key' => 'apostas']);

                    return $this->redirect(['action' => 'index', $aposta->jogos_id]);
                }
                $this->Flash->error('Erro ao atualizar aposta! Tente novamente!', ['key' => 'apostas']);
            }
            $equipes = [
                $aposta->jogo->fora->id => $aposta->jogo->fora->descricao,
                $aposta->jogo->mandante->id => $aposta->jogo->mandante->descricao,
            ];
            $this->set(compact('aposta', 'equipes'));
        } else {
            $this->Flash->info('Apostas encerradas!', ['key' => 'apostas']);
            $this->redirect(['action' => 'index', $aposta->jogos_id]);
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Aposta id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $aposta = $this->Apostas->get($id, [
            'contain' => ['Jogos' => ['Mandante', 'Fora']],
            'conditions' => ['Apostas.users_id' => $this->Auth->user('id')]
        ]);

        $prazoHora = date('Y-m-d H:i', strtotime('-30 minutes', strtotime($aposta->jogo->data->format('Y-m-d') . 'T' . $aposta->jogo->horario->format('H:i'))));
        if ((strtotime(date('Y-m-d')) <= strtotime($aposta->jogo->data->format('Y-m-d'))) && (strtotime(date('H:i')) < strtotime($prazoHora))) {
            if ($this->Apostas->delete($aposta)) {
                $logs = [];
                $logs['users_id'] = $this->Auth->user('id');
                $logs['tela'] = '/apostas/delete/' . $id;
                $logs['created'] = date('Y-m-d H:i:s');
                $this->salvarLog($logs);
                $this->Flash->success('Aposta excluída com sucesso!', ['key' => 'apostas']);
            } else {
                $this->Flash->error('Erro ao excluir aposta!', ['key' => 'apostas']);
            }

            return $this->redirect(['action' => 'index', $aposta->jogos_id]);
        } else {
            $this->Flash->info('Apostas encerradas!', ['key' => 'apostas']);
            return $this->redirect(['action' => 'index', $aposta->jogos_id]);
        }
    }

    public function salvarApostas()
    {
        $this->request->allowMethod('post');
        if (!empty($this->request->getData('apostas'))) {
            $data = $this->_completarArrayApostas($this->request->getData('apostas'));
            if (is_array($data)) {
                $data = $this->_verificarIdAposta($data);
                if (!empty($data)) {
                    $placares = $this->Apostas->newEntities($data);
                    if ($this->Apostas->saveMany($placares)) {
                        $logs = [];
                        $logs['users_id'] = $this->Auth->user('id');
                        $logs['tela'] = '/apostas/salvarApostas';
                        $logs['created'] = date('Y-m-d H:i:s');
                        $this->salvarLog($logs);
                        $mensagem = 'sucesso';
                        $this->Flash->success('Apostas salvas com sucesso!', ['key' => 'apostas']);
                    } else {
                        $mensagem = 'erro';
                        $this->Flash->error('Erro ao salvar apostas!', ['key' => 'apostas']);
                    }
                    $this->set('mensagem', $mensagem);
                }
            }
        }
    }

    private function _completarArrayApostas(array $data)
    {
        $quantidade = count($data);
        $dadosFormatados = [];
        for ($i = 0; $i < $quantidade; $i++) {
            if ($data[$i]['placar1'] > $data[$i]['placar2']) {
                $dadosFormatados[$i]['vencedor'] = $data[$i]['time1'];
            } elseif ($data[$i]['placar1'] < $data[$i]['placar2']) {
                $dadosFormatados[$i]['vencedor'] = $data[$i]['time2'];
            } else {
                $dadosFormatados[$i]['vencedor'] = 0;
            }
            $dadosFormatados[$i]['users_id'] = $this->Auth->user('id');
            $dadosFormatados[$i]['placar1'] = $data[$i]['placar1'];
            $dadosFormatados[$i]['placar2'] = $data[$i]['placar2'];
            $dadosFormatados[$i]['jogos_id'] = $data[$i]['jogos_id'];
            $dadosFormatados[$i]['id'] = $data[$i]['id'];
        }

        return $dadosFormatados;
    }

    private function _verificarIdAposta(array $data)
    {
        $dadosAtualizar = [];
        foreach ($data as $key => $aposta) {
            if (!empty($data[$key]['id'])) {
                $dadosAtualizar[] = $aposta;
                unset($data[$key]);
            }
        }
        if (!empty($dadosAtualizar)) {
            $this->_atualizarApostas($dadosAtualizar);
        }
        return $data;
    }

    private function _atualizarApostas(array $data)
    {
        $mensagem = '';
        foreach ($data as $aposta) {
            $apostas = $this->Apostas->get($aposta['id']);
            $apostas = $this->Apostas->patchEntity($apostas, $aposta);
            if ($this->Apostas->save($apostas)) {
                $mensagem = 'sucesso';
                $logs = [];
                $logs['users_id'] = $this->Auth->user('id');
                $logs['tela'] = '/apostas/_atualizarApostas/' . $aposta['id'];
                $logs['created'] = date('Y-m-d H:i:s');
                $this->salvarLog($logs);
                $this->Flash->success('Apostas atualizadas com sucesso!', ['key' => 'apostas']);
            } else {
                $mensagem = $apostas->errors();
                $this->Flash->error('Erro ao atualizar apostas!', ['key' => 'apostas']);
            }
        }
        $this->set('mensagem', $mensagem);
    }
}
