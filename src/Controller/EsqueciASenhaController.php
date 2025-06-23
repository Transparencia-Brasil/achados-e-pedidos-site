<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use App\Model\Entity\Usuario;

class EsqueciASenhaController extends AppController
{
    public $helpers = ["UCaptcha"];
    public function initialize()
    {
        parent::initialize();

        $this->loadModel('Usuario');
        $this->set('slug_pai', "esqueci-a-senha");

        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth');
        $this->loadComponent('UString');
        $this->loadComponent('UNumero');
        $this->loadComponent('UCaptcha');
    }


    public function index()
    {
        $erros = [];
        $sucesso = null;

        // pegar dados do form e validá-los
        if ($this->request->is('post')) {
            $captchaResult = $this->UCaptcha->ValidateToken($this->request->data['recaptcha_token']);
            if ($captchaResult !== 'human') {
                $erros['Email'] = 'Por favor, tente novamente não foi possivel validar a sua requisição.';
            } else {
                $email = $this->UString->AntiXSSComLimite($this->request->data['email'], 100);

                $usuario = new Usuario();
                $usuario->Email = $email;

                $erros = $usuario->EsqueciASenha();
            }

            $sucesso = count($erros) == 0;
        }

        $this->set('title', "Esquecia a senha");
        $this->set('erros', $erros);
        $this->set('sucesso', $sucesso);
    }

    public function novasenha($chave)
    {
        $chave = $this->UString->AntiXSSComLimite($chave, 300);
        $chaveVencida = null;
        $usuarioNaoEncontrado = null;
        $sucesso = null;
        $erros = [];

        $captchaResult = $this->UCaptcha->ValidateToken($this->request->data['recaptcha_token']);
        if ($captchaResult !== 'human') {
            $erros['Email'] = 'Por favor, tente novamente não foi possivel validar a sua requisição.';
            $sucesso = false;
        } else {
            $usuarioBU = new Usuario();

            $usuario = $usuarioBU->ListarPorChaveEsqueciASenha($chave);

            if ($usuario != null) {
                if (is_numeric($usuario)) {
                    $chaveVencida = true;
                    $usuario = null;
                }
            } else {
                $usuarioNaoEncontrado = true;
            }

            if ($this->request->isPost() && $usuario != null) {
                $novaSenha = $this->UString->AntiXSSEmArrayComLimite($this->request->data, "Senha", 100);
                $confirmarSenha = $this->UString->AntiXSSEmArrayComLimite($this->request->data, "ConfirmarSenha", 100);

                $erros = $usuarioBU->ValidarTrocaDeSenha($novaSenha, $confirmarSenha);

                if (count($erros) == 0) {
                    $sucesso = $usuario->AlterarSenha($novaSenha);
                }
            }
        }

        $this->set('usuarioNaoEncontrado', $usuarioNaoEncontrado);
        $this->set('chaveVencida', $chaveVencida);
        $this->set('sucesso', $sucesso);
        $this->set('erros', $erros);
    }
}

?>