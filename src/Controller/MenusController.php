<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Menus Controller
 *
 * @property \App\Model\Table\MenusTable $Menus
 *
 * @method \App\Model\Entity\Menu[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MenusController extends AppController
{
    public $tiposMenu = [
        'C' => 'Controller', 'A' => 'Action', 'D' => 'Principal'
    ];

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate['contain'] = ['Acos'];
        $menus = $this->paginate($this->Menus);

        $this->set(compact('menus'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $menu = $this->Menus->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            if (empty($data['acos_id'])) {
                $data['acos_id'] = 0;
            }
            if (empty($data['parent_id'])) {
                $data['parent_id'] = 0;
            }
            $menu = $this->Menus->patchEntity($menu, $data);
            if ($this->Menus->save($menu)) {
                $this->Flash->success('Registro salvo com sucesso!', ['key' => 'menus']);

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Erro ao salvar registro! Tente novamente!', ['key' => 'menus']);
        }
        $parentMenus = $this->Menus->find('list', ['conditions' => ['tipo' => 'D']]);
        $acos = $this->Menus->Acos->find('list', [
            'keyField' => 'id', 'valueField' => 'alias',
            'order' => ['lft' => 'asc', 'rght' => 'asc']
        ]);
        $this->set(compact('menu', 'parentMenus', 'acos'));
        $this->set('tiposMenu', $this->tiposMenu);
    }

    /**
     * Edit method
     *
     * @param string|null $id Menu id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $menu = $this->Menus->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            if (empty($data['acos_id'])) {
                $data['acos_id'] = 0;
            }
            if (empty($data['parent_id'])) {
                $data['parent_id'] = 0;
            }
            $menu = $this->Menus->patchEntity($menu, $data);
            if ($this->Menus->save($menu)) {
                $this->Flash->success('Registro atualizado com sucesso!', ['key' => 'menus']);

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Erro ao atualizar registro! Tente novamente!', ['key' => 'menus']);
        }
        $parentMenus = $this->Menus->find('list', ['conditions' => ['tipo' => 'D']]);
        $acos = $this->Menus->Acos->find('list', [
            'keyField' => 'id', 'valueField' => 'alias',
            'order' => ['lft' => 'asc', 'rght' => 'asc']
        ]);
        $this->set(compact('menu', 'parentMenus', 'acos'));
        $this->set('tiposMenu', $this->tiposMenu);
    }

    /**
     * Delete method
     *
     * @param string|null $id Menu id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $menu = $this->Menus->get($id);
        if ($this->Menus->delete($menu)) {
            $this->Flash->success('Registro excluído com sucesso!', ['key' => 'menus']);
        } else {
            $this->Flash->error('Erro ao excluir registro! Tente novamente!', ['key' => 'menus']);
        }

        return $this->redirect(['action' => 'index']);
    }
}
