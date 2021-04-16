<?php
namespace App\Controller;

use Cake\ORM\TableRegistry;
use App\Model\Entity\Usuario;
use App\Model\Entity\Pedido;
use App\Model\Entity\UsuarioRelacionamento;

class UsuariosController extends AppController
{
    public $helpers = ["FrontEnd"];
	public function initialize(){
        parent::initialize();

        $this->loadComponent("UString");
        $this->loadComponent("UNumero");
        $this->loadComponent('Flash');
        $this->loadComponent('USessao');
        $this->set('slug_pai', "usuarios");
    }

	public function detalhe($slug){
		$slug = $this->UString->AntiXSSComLimite($slug, 100);

        if(strlen($slug) == 0){
            $this->set("url", "/usuarios/$slug");
            $this->set("message", "404");
            $this->render('/Error/error400');
            return;
        }

        $usuarioBU = new Usuario();
        $usuarioBU->Slug = $slug;

        $moderar = true;

        // verifica se usuário logado é o mesmo do slug
        if($this->USessao->EstaLogadoFront($this->request)){
            $usuarioLogado = $this->USessao->GetUsuarioFront($this->request);

            if($usuarioLogado->Slug == $slug){
                $moderar = false;
            }
        }

        $usuario = $usuarioBU->ListarPorSlug($moderar);

        if($usuario == null)
        {
            $this->set("url", "/usuarios/$slug");
            $this->set("message", "404");
            $this->render('/Error/error400');
            return;
        }   

        $pagina = 1;

        if($this->request->is('post')){
            $pagina = $this->UNumero->ValidarNumeroEmArray($this->request->data, 'pagina');
        }

        $pedidoBU = new Pedido();
        $pedidoBU->CodigoUsuario = $usuario["Codigo"];
        $pedidos = $pedidoBU->ListarPorUsuario($pagina, 5, true);

        $avaliacao = 2;

        $this->set('pagina', $pagina);
        $this->set('usuario', $usuario);
        $this->set('pedidos', $pedidos);
        $this->set('avaliacao', $avaliacao);
    }

    public function relacionamento($slug, $tipo){

        $slug = $this->UString->AntiXSSComLimite($slug, 100);

        if(strlen($slug) == 0){
            $this->set("url", "/usuarios/$slug");
            $this->set("message", "404");
            $this->render('/Error/error400');
            return;
        }

        $usuarioBU = new Usuario();
        $usuarioBU->Slug = $slug;

        $moderar = true;

        // verifica se usuário logado é o mesmo do slug
        if($this->USessao->EstaLogadoFront($this->request)){
            $usuarioLogado = $this->USessao->GetUsuarioFront($this->request);

            if($usuarioLogado->Slug == $slug){
                $moderar = false;
            }
        }
        $usuario = $usuarioBU->ListarPorSlug($moderar);

        if($usuario == null)
        {
            $this->set("url", "/usuarios/$slug");
            $this->set("message", "404");
            $this->render('/Error/error400');
            return;
        }   

        $usuarioRelacionamentoBU = new UsuarioRelacionamento();
        $feed = [];
        $pagina = 1;
        $start = 0;
        $total = 0;

        $usuarioRelacionamentoBU->CodigoUsuario = $usuario["Codigo"];

        if($tipo == "seguindo")
        {
            $total = $usuarioRelacionamentoBU->TotalSeguindo();
            $feed = $usuarioRelacionamentoBU->Listar($start, 15);

        }else if($tipo == "seguidores")
        {
            $total = $usuarioRelacionamentoBU->TotalQuemSegue();
            $feed = $usuarioRelacionamentoBU->ListarQuemSegue($start, 15);
        }else{
            $this->set("url", "/usuarios/$slug");
            $this->set("message", "404");
            $this->render('/Error/error400');
            return;
        }

        $this->set('pagina', $pagina);
        $this->set('usuario', $usuario);
        $this->set('feed', $feed);
        $this->set('total', $total);
        $this->set('tipo', $tipo);
    }

 }

 ?>