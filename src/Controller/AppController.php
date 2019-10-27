<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Core\Configure;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    public $paginate = [
        'contain'=> [], 'conditions' => [], 'fields' => [],
        'join' => [], 'order' => [], 'group' => [],
        'limit' => 10
    ];

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');
        // $this->loadComponent('Security');

        // $headers = $this->_getAllHeaders();
        // if ((isset($headers['Authorization']) || isset($headers['authorization'])) && (!empty($headers['Authorization']) || !empty($headers['authorization']))) {
        //     $this->configurarAuthJWT();
        // } else {
        //     $this->loadComponent('Acl', ['className' => 'Acl.Acl']);
        //     $this->configurarAuth();
        // }
        $this->configurarAuth();
        // $this->_configurarGrowlytics();
    }

    private function _configurarGrowlytics()
    {
        \Growlytics\Growlytics::init([

            'project_id' => '46ru4om5ejuycbr5z',
            'api_key' => '46ru4om5ejuycbr5x46ru4om5ejuycbr5y',

            // Enable disable plugin, by default its enable if not provided
            'enabled' => true,

            // Make sure env matches with browser's env
            'env' => env('APP_ENV'),


            'skip_api_fields' => ['pwd', 'name'],
        ]);

        try {
            // Some potentially crashy code
        } catch (Exception $ex) {
            $user = $this->Auth->user();
            // You can report Error, Exception or Throwable
            \Growlytics\Growlytics::notifyError($ex, $user);
        }
    }

    /**
     * Configurar o component Auth padrão
     */
    private function configurarAuth()
    {
        $this->loadComponent('Acl', ['className' => 'Acl.Acl']);
        $this->loadComponent('Auth', [
            'authorize' => ['Acl.Actions' => ['actionPath' => 'controllers/']],
            'loginRedirect' => '/',
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login'
            ],
            'unauthorizedRedirect' => ['controller' => 'Users', 'action' => 'login'],
            'authError' => 'Parece que você não tem permissão para acessar essa página!',
            'flash' => ['element' => 'error', 'key' => 'permissao']
        ]);

        // $this->Auth->allow();
    }

    /**
     * Configurar o componente Auth com JWT
     */
    private function configurarAuthJWT()
    {
        $this->loadComponent('Auth', [
            'storage' => 'Memory',
            'authenticate' => [
                'Form',
                'ADmad/JwtAuth.Jwt' => [
                    'parameter' => 'token',
                    'userModel' => 'Users',
                    'fields' => [
                        'username' => 'id'
                    ],
                    'queryDatasource' => true
                ]
            ],
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login'
            ],
            'unauthorizedRedirect' => false,
            'checkAuthIn' => 'Controller.initialize'
        ]);
    }

    public function beforeRender(Event $event)
    {
        $pluginParam = $this->request->getParam('plugin');
        if ($pluginParam === 'AclManager') {
            $this->viewBuilder()->layout('cakephp');
        }
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->getType(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        if (!empty($this->Auth->user('id')) && $this->request->getParam('_ext') !== 'json') {
            $this->_montarMenu();
            $this->set('usuario', $this->Auth->user());
        }
    }

    protected function salvarLog(array $logs)
    {
        $this->loadModel('Logs');
        $log = $this->Logs->newEntity();
        $log = $this->Logs->patchEntity($log, $logs);
        $this->Logs->save($log);
    }

    /**
     * Montagem de menu para usuário logado
     */
    private function _montarMenu()
    {
        $this->loadModel('Menus');
        $permissoes = $this->Menus->Acos->Aros->find('all', [
            'conditions' => [
                'foreign_key' => $this->Auth->user('group_id'),
                'model' => 'Groups'
            ],
            'contain' => ['Acos']
        ])->first();
        $menusPais = $this->Menus->find('all', [
            'conditions' => ['tipo' => 'D']
        ]);
        if ($this->Auth->user('group_id') === 1) {
            $menus = $this->Menus->find('all', [
                // 'conditions' => ['tipo' => 'C'],
                'contain' => ['Acos']
            ]);
            $parentMenu = [];
        } else {
            $acosId = [];
            foreach ($permissoes->acos as $aco) {
                if ($aco->_joinData->_create == 1 && $aco->_joinData->_read == 1 && $aco->_joinData->_update == 1 && $aco->_joinData->_delete == 1) {
                    $acosId[] = $aco->id;
                }
            }

            $menus = $this->Menus->find('all', [
                'conditions' => [
                    'acos_id IN' => $acosId
                ],
                'contain' => ['Acos']
            ]);
        }

        foreach ($menus as $menu) {
            if (!empty($menu->aco) && $menu->aco->parent_id > 1) {
                $parentMenu[$menu->id] = $this->Menus->Acos->find('all', [
                    'conditions' => ['id' => $menu->aco->parent_id]
                ])->first();
            }
        }

        $this->set('menuPai', $menusPais);
        $this->set('menuLateral', $menus);
        $this->set('parentMenu', $parentMenu);
    }

    /**
     * Converte data para formado yyyy-mm-dd
     *
     * @param string $data Data a ser convertida;
     * @return string Data convertida
     */
    protected function converterData($data)
    {
        $arrayData = explode('/', $data);
        return $arrayData[2] . '-' . $arrayData[1] . '-' . $arrayData[0];
    }

    /**
     * Captura os cabeçalhos das requisições HTTP
     *
     * @return array Cabeçalhos HTTP
     */
    private function _getAllHeaders()
    {
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }
    
    /**
     * Pega a rodada marcada como atual
     *
     * @return int Código da rodada
     */
    protected function pegarRodadaAtual()
    {
        $this->loadModel('Rodadas');
        $rodada = $this->Rodadas->find('all', [
            'conditions' => ['atual' => 'S']
        ])->first();
        
        return $rodada->id;
    }
}
