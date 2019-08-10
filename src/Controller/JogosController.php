<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use App\Model\Entity\Jogo;

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
            $rodadaAtual = $this->request->getQuery('rodada');
            array_push($conditions, ['rodadas_id' => $this->request->getQuery('rodada')]);
        } else {
            $rodadaAtual = $this->_pegarRodadaAtual();
            array_push($conditions, ['rodadas_id' => $rodadaAtual]);
        }
        
        $this->paginate['conditions'] = $conditions;
        $this->paginate['contain'] = ['Rodadas', 'Fora', 'Mandante', 'Apostas' => ['conditions' => ['Apostas.users_id' => $this->Auth->user('id')]]];
        $this->paginate['order'] = ['rodadas_id' => 'ASC', 'data' => 'asc', 'horario' => 'asc'];
        $this->paginate['fields'] = ['Jogos.rodadas_id', 'Jogos.id', 'Jogos.horario', 'Jogos.data', 'Rodadas.numero_rodada', 'Jogos.estadio', 'Mandante.descricao', 'Fora.descricao', 'Mandante.brasao', 'Fora.brasao', 'Jogos.casa', 'Jogos.visitante', 'Jogos.placar1', 'Jogos.placar2'];
        $this->paginate['group'] = ['Jogos.rodadas_id', 'Jogos.id', 'Jogos.horario', 'Jogos.data', 'Rodadas.numero_rodada', 'Jogos.estadio', 'Mandante.descricao', 'Fora.descricao', 'Mandante.brasao', 'Fora.brasao', 'Jogos.casa', 'Jogos.visitante', 'Jogos.placar1', 'Jogos.placar2'];
        $jogos = $this->paginate($this->Jogos);
        $rodadas = $this->Jogos->Rodadas->find('list', ['order' => ['numero_rodada' => 'asc']]);
        $apostas = $this->_organizarApostasJogador($jogos);
        
        $partidasAdiadas = $this->_verificarJogosAdiados($rodadaAtual);
        $apostasAdiadas = $this->_organizarApostasJogador($partidasAdiadas);
        
        $prazoHora = [];
        foreach ($jogos as $jogo) {
            $prazoHora[$jogo->id] = date('Y-m-d H:i', strtotime('-30 minutes', strtotime($jogo->data->format('Y-m-d') . 'T' . $jogo->horario->format('H:i'))));
        }
        foreach ($partidasAdiadas as $adiado) {
            $prazoHora[$adiado->id] = date('Y-m-d H:i', strtotime('-30 minutes', strtotime($adiado->data->format('Y-m-d') . 'T' . $adiado->horario->format('H:i'))));
        }

        $this->set(compact('jogos', 'rodadas', 'prazoHora', 'apostas', 'rodadaAtual', 'partidasAdiadas', 'apostasAdiadas'));
    }
    
    /**
     * Verifica partidas adiadas de rodadas anteriores
     * @param int $rodadaAtual
     * @return \Cake\ORM\Query
     */
    private function _verificarJogosAdiados($rodadaAtual)
    {
        $adiados = $this->Jogos->find('all', [
            'fields' => ['Jogos.rodadas_id', 'Jogos.id', 'Jogos.horario', 'Jogos.data', 'Rodadas.numero_rodada', 'Jogos.estadio', 'Mandante.descricao', 'Fora.descricao', 'Mandante.brasao', 'Fora.brasao', 'Jogos.casa', 'Jogos.visitante', 'Jogos.placar1', 'Jogos.placar2'],
            'conditions' => ['rodadas_id <' => $rodadaAtual, 'placar1 IS NULL', 'placar2 IS NULL'],
            'contain' => ['Rodadas', 'Fora', 'Mandante', 'Apostas' => ['conditions' => ['Apostas.users_id' => $this->Auth->user('id')]]],
            'group' => ['Jogos.rodadas_id', 'Jogos.id', 'Jogos.horario', 'Jogos.data', 'Rodadas.numero_rodada', 'Jogos.estadio', 'Mandante.descricao', 'Fora.descricao', 'Mandante.brasao', 'Fora.brasao', 'Jogos.casa', 'Jogos.visitante', 'Jogos.placar1', 'Jogos.placar2'],
            'order' => ['rodadas_id' => 'ASC', 'data' => 'asc', 'horario' => 'asc']
        ]);
        
        return $adiados;
    }
    
    /**
     * Pega a rodada marcada como atual
     * 
     * @return int Código da rodada
     */
    private function _pegarRodadaAtual()
    {
        $rodada = $this->Jogos->Rodadas->find('all', [
            'conditions' => ['atual' => 'S']
        ])->first();
        
        return $rodada->id;
    }

    /**
     * Organiza as apostas do usuário por código do jogo
     * 
     * @param Jogo $jogos
     * @return array
     */
    private function _organizarApostasJogador($jogos)
    {
        $apostaJogo = [];
        foreach ($jogos as $jogo) {
            $apostaJogo[$jogo->id] = ['time1' => '', 'time2' => '', 'id' => ''];
            foreach ($jogo->apostas as $aposta) {
                $apostaJogo[$aposta->jogos_id] = ['time1' => $aposta->placar1, 'time2' => $aposta->placar2, 'id' => $aposta->id];
            }
        }

        return $apostaJogo;
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
        $jogos = $idsApi = [];
        foreach ($dados->fases as $fase) {
            foreach ($fase->jogos->id as $i => $id) {
                $idsApi[] = $i;
                $jogos[$i] = [
                    'id' => $i,
                    'data' => ($id->data !== null) ? $id->data : '1900-01-01',
                    'horario' => ($id->horario !== '') ? str_replace('h', ':', $id->horario) : '00:00:00',
                    'estadio' => $id->estadio, 'rodadas_id' => $id->rodada, 'casa' => $id->time1,
                    'visitante' => $id->time2, 'placar1' => $id->placar1, 'placar2' => $id->placar2,
                    'vencedor' => ''
                ];
                if ($id->placar1 !== null && $id->placar2 !== null) {
                    if ($id->placar1 > $id->placar2) {
                        $jogos[$i]['vencedor'] = $id->time1;
                    } elseif ($id->placar1 < $id->placar2) {
                        $jogos[$i]['vencedor'] = $id->time2;
                    }
                }
            }
        }
        $this->_salvarDadosApi($jogos, $idsApi);
    }

    private function _salvarDadosApi($dadosApi, $idsApi = [])
    {
        if (!empty($idsApi)) {
            $jogosDB = $this->Jogos->find('all', ['conditions' => ['id IN' => $idsApi]])->count();
            if ($jogosDB > 0) {
                $jogos = [];
                foreach ($idsApi as $id) {
                    $jogo = $this->Jogos->get($id);
                    $jogo->data = $dadosApi[$jogo->id]['data'];
                    $jogo->horario = $dadosApi[$jogo->id]['horario'];
                    $jogo->estadio = $dadosApi[$jogo->id]['estadio'];
                    $jogo->visitante = $dadosApi[$jogo->id]['visitante'];
                    $jogo->casa = $dadosApi[$jogo->id]['casa'];
                    $jogo->placar1 = $dadosApi[$jogo->id]['placar1'];
                    $jogo->placar2 = $dadosApi[$jogo->id]['placar2'];
                    $jogo->vencedor = $dadosApi[$jogo->id]['vencedor'];

                    $jogos[] = $jogo;
                }
            } else {
                $jogos = $this->Jogos->newEntities($dadosApi);
            }
        } else {
            $jogos = $this->Jogos->newEntities($dadosApi);
        }

        if ($this->Jogos->saveMany($jogos)) {
            $this->Flash->success('Sincronizado com sucesso!', ['key' => 'jogos']);
        } else {
            $this->Flash->error('Falha ao sincronizar!', ['key' => 'jogos']);
        }

        return $this->redirect(['action' => 'index']);
    }
}
