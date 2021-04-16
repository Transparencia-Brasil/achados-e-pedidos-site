<?php
namespace App\Controller\Minhaconta;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use App\Model\Entity\Usuario;
use App\Model\Entity\UsuarioPerfil;


class PerfilController extends AppController {

    public function initialize()
    {
        parent::initialize();

        $this->loadModel('UsuarioPerfil');
        $this->set('slug_pai', "minha-conta");

        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth');
        $this->loadComponent('UString');
        $this->loadComponent('UData');
        $this->loadComponent('UNumero');
        $this->loadComponent('USessao');
    }

   	public function index(){
        $usuario = $this->USessao->GetUsuarioFront($this->request);

        $usuario->CarregarPerfil();

        if(isset($usuario->UsuarioPerfil) && isset($usuario->UsuarioPerfil->Nascimento)){
            $usuario->UsuarioPerfil->Nascimento = $this->UData->ConverterDataBrasil($usuario->UsuarioPerfil->Nascimento);
        }

        $erros = [];
        $errosUsuario = [];
        $errosPerfil = [];
        $sucesso = null;

        if($this->request->is('post') || $this->request->is('put')) {

            $data = $this->request->data;

            $usuarioPerfil = new UsuarioPerfil();
            $usuarioPerfil->CodigoUsuario = $usuario->Codigo;

            $usuario->Nome = $this->UString->AntiXSSEmArrayComLimite($data, "Nome", 150);

            $errosUsuario = $usuario->ValidarDadosPerfil();

            $errosPerfil = $usuarioPerfil->ValidarPerfilMinhaConta($data);

            $erros = array_merge($errosUsuario, $errosPerfil);

            if(count($erros) == 0){

                if($usuario->AtualizarDoPerfil() && $usuarioPerfil->AtualizarPerfil())
                    $this->redirect(array('controller' => 'Perfil', 'action' => 'index', 'prefix' => 'minhaconta', 'sucesso' => 1));
                else
                    $sucesso = false;
            }
        }

        $paises = TableRegistry::get("Pais")->find('list', ['keyField' => 'Codigo', 'valueField' => 'Nome']);
        $generos = TableRegistry::get("TipoGeneros")->find('list', ['keyField' => 'Codigo', 'valueField' => 'Nome']);

        $this->set("usuario", $usuario);
        $this->set("sucesso", $sucesso);
        $this->set('sucessoExclusao', null);
        $this->set("erros", $erros);
        $this->set("paises", $paises);
        $this->set("generos", $generos);
   	}

    public function alterarSenha(){

        $sucesso = null;
        $erros = [];
        if ($this->request->is('post')) {

            $usuario = $this->USessao->GetUsuarioFront($this->request);

            $senhaAtual         = $this->UString->AntiXSSComLimite($this->request->data["SenhaAtual"], 50);
            $novaSenha          = $this->UString->AntiXSSComLimite($this->request->data["Senha"], 50);
            $confirmarSenha     = $this->UString->AntiXSSComLimite($this->request->data["ConfirmarSenha"], 50);

            $erros = $usuario->ValidarNovaSenha($senhaAtual, $novaSenha, $confirmarSenha);

            if(count($erros) == 0){

                $sucesso = $usuario->AlterarSenha($novaSenha);
            }
        }

        $this->set("sucesso", $sucesso);
        $this->set("erros", $erros);
        $this->render('alterarsenha');
    }

    public function toggleOptin($status){
        $this->autoRender = false;
        $this->response->type('application/json');

        $status = $status == 1 ? 1 : 0;

        $usuario = $this->USessao->GetUsuarioFront($this->request);

        if($usuario->AtualizarOptin($status)){
            $retorno = true;
        }else{
            $retorno = false;
        }

        echo json_encode($retorno);
    }

    public function excluirConta(){
        $usuario = $this->USessao->GetUsuarioFront($this->request);
        $sucesso = null;

        if ($this->request->is('post')) {
            $sucesso = $usuario->Excluir();

            if($sucesso){
                // redirecionar para tela de sucesso
                $this->USessao->LogoutFront($this);
            }
        }

        $this->set('sucessoExclusao', $sucesso);
        $this->render('exclusaosucesso');
    }
}
?>
