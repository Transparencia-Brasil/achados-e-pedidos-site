<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use App\Model\Entity\Usuario;
use App\Model\Entity\UsuarioPerfil;

class CadastroController extends AppController
{
    public $helpers = ['ValidationText'];

	public function initialize()
    {
        parent::initialize();
        
        $this->loadModel('Usuario');
        $this->set('slug_pai', "cadastro");

        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth');
        $this->loadComponent('UString');
        $this->loadComponent('USessao');
        $this->loadComponent('UEmail');
        $this->loadComponent('UNumero');
        $this->loadComponent('UData');
    }

    /*
    Exibe tela de cadastro se não logado. Se logado, manda pra minha conta.
    Ao postar os dados, valida se cliente já existe.
    */
    public function index(){

        $erros = [];
        $this->Auth->sessionKey = 'Auth.MinhaContaFront';

        // verifica se usuário está logado
        $sessao = $this->request->session();

        if($this->Auth->user() != null){
            $this->redirect(array('controller' => 'Home','action' => 'index', 'prefix' => 'minhaconta'));
            return;
        }

        // pegar dados do form e validá-los
        if ($this->request->is('post')) {
           

            $conn_usuario = TableRegistry::get("Usuarios");
            /*
                1 - verificar se email / documento já existem no sistema
                2 - validar variáveis
                3 - gravar usuário no sistema
                4 - autenticar usuário
                5 - redirecionar para o passo 2
            */
            $usuario = new Usuario();
            $conn_usuario->patchEntity($usuario, $this->request->data);

            $erros = $usuario->ValidarPasso1();

            if(strcmp(strtolower($sessao->read("palavra")), strtolower($this->request->data["Captcha"])) !== 0){
                $erros["Captcha"] = "Caracteres inválidos. Por favor, digite os caracteres da imagem acima.";
            }

            if(count($erros) == 0)
            {
                $status = $usuario->salvar();              

                if($status){
                    // dispara email de bem vindo
                    $this->UEmail->EnviarEmailBemVindo($usuario->Email, $usuario->Nome);
                    
                    $arrUsuario = array('username' => $usuario->Email, 'password'=> $usuario->Senha, 'id' => $usuario->Codigo);
                    
                    $this->Auth->setUser($arrUsuario);

                    $this->redirect(array('controller' => 'Cadastro', 'action' => 'perfil'));
                    return;
                }else{
                    $erros["ErroInterno"] = "Erro ao finalizar cadastro. Por favor, tente novamente mais tarde";
                }
            }
        }

        $this->set('title', "Cadastro");
        $this->set("usuario", new Usuario());
        $this->set("erros", $erros);
    }

    public function perfil()
    {
        $erros = [];
        $sucesso = null;

        if(!$this->USessao->EstaLogadoFront($this->request)){
            $this->redirect(array('controller' => 'Login','action' => 'logar', 'prefix' => 'minhaconta'));
            return;
        }

        $codigoUsuario = $this->USessao->GetUsuarioFrontID($this->request);

        $conn_usuario_perfil = TableRegistry::get("UsuariosPerfis");
        $usuario_perfil = $conn_usuario_perfil->newEntity();

        if($usuario_perfil->PossuiPerfil($codigoUsuario))
        {
            $this->redirect(array('controller' => 'Home','action' => 'index', 'prefix' => 'minhaconta'));
            return;
        }

        // pegar dados do form e validá-los
        if ($this->request->is('post')) {
            
            $usuario_perfil->CodigoTipoOcupacao = 0;
            $conn_usuario_perfil->patchEntity($usuario_perfil, $this->request->data);
            
            $erros = $usuario_perfil->ValidarPasso2();
            
            if(count($erros) == 0)
            {
                $usuario_perfil->CodigoUsuario = $codigoUsuario;
                if($usuario_perfil->salvar()){

                    $sucesso = true;
                }else{
                    $sucesso = false;
                }
            }
        }

        $paises = TableRegistry::get("Pais")->find('list', ['keyField' => 'Codigo', 'valueField' => 'Nome']);
        $generos = TableRegistry::get("TipoGeneros")->find('list', ['keyField' => 'Codigo', 'valueField' => 'Nome']);

        $this->set('title', "Meu Perfil");
        $this->set("sucesso", $sucesso);
        $this->set("paises", $paises);
        $this->set("generos", $generos);
        $this->set("usuario_perfil", $usuario_perfil);
        $this->set("erros", $erros);
    }

    public function gerarCaptcha($largura,$altura,$tamanho_fonte,$quantidade_letras)
    {
        $this->autoRender = false;
        $this->response->type('jpg');

        $imagem = imagecreate($largura,$altura); // define a largura e a altura da imagem
        $fonte = WWW_ROOT . "assets" . DS . "fonts" . DS . "arial.ttf"; //voce deve ter essa ou outra fonte de sua preferencia em sua pasta
        
        $preto  = imagecolorallocate($imagem,0,0,0); // define a cor preta
        $branco = imagecolorallocate($imagem,255,255,255); // define a cor branca
        
        // define a palavra conforme a quantidade de letras definidas no parametro $quantidade_letras
        $palavra = substr(str_shuffle("AaBbCcDdEeFfGgHhIiJjKkLlMmNnPpQqRrSsTtUuVvYyXxWwZz23456789"),0,($quantidade_letras)); 

        $this->request->session()->write("palavra", $palavra); // atribui para a sessao a palavra gerada
        for($i = 1; $i <= $quantidade_letras; $i++){ 
            imagettftext($imagem,$tamanho_fonte,rand(-25,25),($tamanho_fonte*$i),($tamanho_fonte + 10),$branco,$fonte,substr($palavra,($i-1),1)); // atribui as letras a imagem
        }
        imagejpeg($imagem); // gera a imagem
        imagedestroy($imagem); // limpa a imagem da memoria

        $this->response->body($imagem);
    }
}

?>