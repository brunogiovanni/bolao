<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Mailer\Email;
use Cake\Utility\Security;
// use Firebase\JWT\JWT;
use Cake\Network\Exception\UnauthorizedException;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->Auth->allow(['login', '_loginFormulario', '_loginToken', 'logout']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Groups']
        ];
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Groups']
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $groups = $this->Users->Groups->find('list', ['limit' => 200]);
        $this->set(compact('user', 'groups'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $groups = $this->Users->Groups->find('list', ['limit' => 200]);
        $this->set(compact('user', 'groups'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Função primária de login
     * Dependendo do tipo de requisição irá chamar login de formulário ou token.
     */
    public function login()
    {
        // if ($this->request->getParam('_ext') === 'json') {
        //     $this->_loginToken();
        // } else {
        //     $this->_loginFormulario();
        // }
        $this->_loginFormulario();
    }

    /**
     * Login de formulário para chamadas diretas
     */
    private function _loginFormulario()
    {
        $this->viewBuilder()->setLayout('login');
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Flash->error('Usuário ou senha incorretos', ['key' => 'login']);
            }
        }
        $this->render('login');
    }

    /**
     * Login com token para conexão via API
     */
    // private function _loginToken()
    // {
    //     if ($this->request->is('post')) {
    //         $user = $this->Auth->identify();
    //         if ($user) {
    //             $timeantigo = (!empty($user['expira'])) ? strtotime($user['expira']->format('Y-m-d')) : '';
    //             $hoje = strtotime(date('Y-m-d'));
    //             if (!empty($timeantigo) && $timeantigo < $hoje) {
    //                 $this->set(['message' => 'Tempo expirado! Contrate os administradores!', '_serialize' => ['message']]);
    //             } else {
    //                 $this->Auth->setUser($user);
    //                 // $user = $this->dadosUsuario();
    //                 $setoresUsuario = $this->_listarSetores();
    //                 $usuario = [
    //                     'success' => true,
    //                     'data' => [
    //                         'token' => JWT::encode([
    //                             'sub' => $user['id'],
    //                             'exp' =>  time() + 604800
    //                         ],
    //                         Security::salt()),
    //                         'userId' => $user['id'],
    //                     ],
    //                     'message' => 'OK',
    //                     'setores' => $setoresUsuario];
    //                 $this->set('usuario', $usuario);
    //                 $this->set('_serialize', 'usuario');
    //             }
    //         } else {
    //             $this->set(['message' => 'Usuário ou senha inválidos!', '_serialize' => ['message']]);
    //         }
    //     }
    // }

    public function logout()
    {
        $this->redirect($this->Auth->logout());
    }
}
