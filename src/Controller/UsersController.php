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

        $this->Auth->allow(['login', '_loginFormulario', 'logout', 'recuperarSenha']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate['contain'] = ['Groups'];
        $this->paginate['conditions'] = ['username <>' => 'brunogiovanni'];
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
            'contain' => ['Pontos' => ['Apostas' => ['Jogos' => ['Fora', 'Mandante']]]]
        ]);

        $totalPontos = 0;

        $this->set(compact('user', 'totalPontos'));
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
            $data = $this->request->getData();
            $data['ativo'] = 'S';
            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                $this->Flash->success('Registro salvo com sucesso!', ['key' => 'users']);

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Erro ao salvar registros! Tente novamente!', ['key' => 'users']);
        }
        $groups = $this->Users->Groups->find('list', ['conditions' => ['id >' => 1]]);
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
            $data = $this->request->getData();
            if (!empty($data['nova_senha'])) {
                $data['password'] = $data['nova_senha'];
            }
            $data['ativo'] = 'S';
            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                $this->Flash->success('Registro atualizado com sucesso!', ['key' => 'users']);

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Erro ao atualizar registro! Tente novamente!', ['key' => 'users']);
        }
        $groups = $this->Users->Groups->find('list', ['conditions' => ['id >' => 1]]);
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
            $this->Flash->success('Registro excluído com sucesso!', ['key' => 'users']);
        } else {
            $this->Flash->error('Erro ao excluir registro! Tente novamente!', ['key' => 'users']);
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
                if ($user['ativo'] === 'S') {
                    $this->Auth->setUser($user);
                    return $this->redirect($this->Auth->redirectUrl());
                } else {
                    $this->Flash->error('Seu perfil ainda está inativo! Aguarde!', ['key' => 'login']);
                }
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


    public function addPublic()
    {
        $this->viewBuilder()->setLayout('login');
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['group_id'] = 3;
            if (isset($data['confirmado']) && $data['confirmado'] === 1) {
                $data['ativo'] = 'S';
            } else {
                $data['ativo'] = 'N';
            }
            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                $this->Flash->success('Registro salvo com sucesso!', ['key' => 'login']);

                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error('Erro ao salvar registros! Tente novamente!', ['key' => 'login']);
        }
        $this->set(compact('user'));
    }

    public function recuperarSenha()
    {
        if ($this->request->is('post')) {
            $user = $this->Users->find('all', [
                'conditions' => ['email' => $this->request->getData('email')]
            ])->first();
            if ($user) {
                $senha = $this->_geraSenha();
                $user->password = $senha;

                if ($this->Users->save($user)) {
                    $email = new Email('default');
                    $mensagem = 'Seu usuário é: ' . $user->username . '<br>';
                    $mensagem .= 'Sua nova senha é: ' . $senha;
                    $email->to($user->email)
                        ->subject('Recuperação de senha')
                        ->send($mensagem);
                }
            } else {
                $this->Flash->error('Este e-mail não está cadastrado!', ['key' => 'login']);
            }
        }
        $this->viewBuilder()->setLayout('login');
    }

    /**
     * Função para gerar senhas aleatórias
     *
     *
     * @param integer $tamanho Tamanho da senha a ser gerada
     * @param boolean $maiusculas Se terá letras maiúsculas
     * @param boolean $numeros Se terá números
     * @param boolean $simbolos Se terá símbolos
     *
     * @return string A senha gerada
     */
    private function _geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
    {
        $lmin = 'abcdefghijklmnopqrstuvwxyz';
        $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num = '1234567890';
        $simb = '!@#$%*-';
        $retorno = '';
        $caracteres = '';
        $caracteres .= $lmin;

        if ($maiusculas) {
            $caracteres .= $lmai;
        }
        if ($numeros) {
            $caracteres .= $num;
        }
        if ($simbolos) {
            $caracteres .= $simb;
        }

        $len = strlen($caracteres);

        for ($n = 1; $n <= $tamanho; $n++) {
            $rand = mt_rand(1, $len);
            $retorno .= $caracteres[$rand - 1];
        }
        return $retorno;
    }
}
