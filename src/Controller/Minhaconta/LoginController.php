<?php
namespace App\Controller\Minhaconta;

use App\Controller\AppController;
use Cake\Log\Log;
use Cake\ORM\TableRegistry;
use App\Model\Entity\Usuario;

class LoginController extends AppController
{
    public $helpers = ["UCaptcha"];
    public function initialize()
    {
        parent::initialize();
        $this->set('slug_pai', "minha-conta");

        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth');
        $this->loadComponent('UString');
        $this->loadComponent('USessao');
        $this->loadComponent('UNumero');
        $this->loadComponent('UCaptcha');
    }

    public function index()
    {

        $this->redirect(array('action' => 'Logar'));

        return;
    }

    public function logar()
    {
        // verifica se usuário está logado
        $sessao = $this->request->session();
        $erros = [];
        $contadorLogin = 0;

        if ($this->Auth->user() != null) {
            $this->redirect(array('controller' => 'Home', 'action' => 'index', 'prefix' => 'minhaconta', 'meus-pedidos'));
            return;
        }

        // pegar dados do form e validá-los
        if ($this->request->is('post')) {
            $sessao = $this->request->session();

            $login = $this->request->data['login'];
            $senha = $this->request->data['senha'];

            if ($sessao->check('contadorLogin' . $login)) {
                $contadorLogin = $this->UNumero->ValidarNumero($sessao->read('contadorLogin' . $login));
            }

            $erros = [];
            $user_conn = TableRegistry::get('Usuarios');

            $usuario = new Usuario();
            $usuario->Codigo = 0;

            $captchaResult = $this->UCaptcha->ValidateToken($this->request->data['recaptcha_token']);
            if ($captchaResult !== 'human') {
                $erros['Email'] = 'Por favor, tente novamente não foi possivel validar a sua requisição.';
            } else {
                $erros = $usuario->EfetuarLogin($login, $senha);
            }

            // else if($login == "transparencia" && $senha = "q2w3e4Trans123")
            if (count($erros) == 0) {
                $this->Auth->sessionKey = 'Auth.MinhaContaFront';

                //debug($usuario);die();
                $usuario->updateUltimoAcesso();
                $arrUsuario = array('username' => $login, 'password' => $senha, 'id' => $usuario->Codigo);
                $this->Auth->setUser($arrUsuario);

                $sessao->delete('contadorLogin');

                $redirect = strtolower($this->Auth->redirectUrl());
                if ($redirect != null) {
                    $this->redirect(strtolower($redirect));
                    return;
                } else {
                    $this->redirect(array('controller' => 'Home', 'action' => 'index', 'prefix' => 'minhaconta', 'meus-pedidos'));
                    return;
                }
            } else {
                $contadorLogin++;
                $sessao->write('contadorLogin' . $login, $contadorLogin);
                //$this->Flash->error(__('Usuário ou senha incorretos.'), 'default',[], 'auth');
            }
        }

        // bloqueia usuário se tiver 5 tentativas inválidas de login
        if ($contadorLogin >= 5 && $usuario->Codigo > 0) {
            $usuario->Bloqueado = 1;
            $user_conn->save($usuario);
            $sessao->write('contadorLogin', 0);
        }

        $this->set('contadorLogin', $contadorLogin);
        $this->set('erros', $erros);
        $this->set('title', "Login");
        $this->render('login');
    }

    public function logout()
    {
        $this->layout = 'front';

        $this->USessao->LogoutFront($this);

        $this->redirect(array('controller' => 'Login', 'action' => 'logar', 'prefix' => 'minhaconta'));
        return;
    }
}
?>