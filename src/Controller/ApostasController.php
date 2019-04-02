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
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Jogos' => ['Mandante', 'Fora'], 'Equipes']
        ];
        $apostas = $this->paginate($this->Apostas);

        $this->set(compact('apostas'));
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
            'contain' => ['Users', 'Jogos', 'Equipes']
        ]);

        $this->set('aposta', $aposta);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $aposta = $this->Apostas->newEntity();
        if ($this->request->is('post')) {
            $aposta = $this->Apostas->patchEntity($aposta, $this->request->getData());
            if ($this->Apostas->save($aposta)) {
                $this->Flash->success(__('The aposta has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The aposta could not be saved. Please, try again.'));
        }
        $users = $this->Apostas->Users->find('list', ['limit' => 200]);
        $jogos = $this->Apostas->Jogos->find('list', ['limit' => 200]);
        $equipes = $this->Apostas->Equipes->find('list', ['limit' => 200]);
        $this->set(compact('aposta', 'users', 'jogos', 'equipes'));
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
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $aposta = $this->Apostas->patchEntity($aposta, $this->request->getData());
            if ($this->Apostas->save($aposta)) {
                $this->Flash->success(__('The aposta has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The aposta could not be saved. Please, try again.'));
        }
        $users = $this->Apostas->Users->find('list', ['limit' => 200]);
        $jogos = $this->Apostas->Jogos->find('list', ['limit' => 200]);
        $equipes = $this->Apostas->Equipes->find('list', ['limit' => 200]);
        $this->set(compact('aposta', 'users', 'jogos', 'equipes'));
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
        $aposta = $this->Apostas->get($id);
        if ($this->Apostas->delete($aposta)) {
            $this->Flash->success(__('The aposta has been deleted.'));
        } else {
            $this->Flash->error(__('The aposta could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
