<?php
namespace App\Controller;

use Cake\ORM\TableRegistry;
use App\Model\Entity\Pedido;
use App\Model\Entity\Avaliacao;
use App\Model\Entity\PedidoInteracao;
use App\Model\Entity\UsuarioRelacionamento;
use App\Model\Entity\Comentario;

class PedidosController extends AppController
{
    public $helpers = ["FrontEnd"];
	public function initialize(){
        parent::initialize();

        $this->loadComponent("UString");
        $this->loadComponent("UNumero");
        $this->loadComponent('Flash');
        $this->loadComponent('USessao');
        $this->set('slug_pai', "pedidos");
        
    }

    public function index(){
    	$usuarioLogado = $this->USessao->EstaLogadoFront($this->request);

        $pedido = new Pedido();
        $total = 0;
        $pagina = 1;
        $pedidos = "";

        if ($this->request->is('post')) {

            $data = $this->request->data;
            if (!empty($data["pagina"])) {
                $pagina = $this->UNumero->ValidarNumero($data["pagina"]);
                $pagina = $pagina <= 0 ? 1 : $pagina;

                $pedidosTotal = $pedido->FiltrarPedidos($data, 1, 0);
                $pedidos = $pedido->FiltrarPedidos($data, $pagina);

                $total = count($pedidosTotal);
            }

        }else{
            
            $total = $pedido->TotalPedidosModerados();
        	$pedidos = $pedido->ListarModerados();

            $this->request->data["codigoStatusPedido"] = "";
            $this->request->data["CodigoTipoPedidoSituacao"] = "";
            $this->request->data["codigoPoder"] = "";
            $this->request->data["codigoTipoPedidoSituacao"] = "";
            $this->request->data["codigoNivelFederativo"] = "";
            $this->request->data["recurso"] = "";
        }

        $recurso = 0;
        if(array_key_exists("recurso", $this->request->data)){
          $recurso = $this->request->data["recurso"];
        }

        $textoBusca = "";
        if(array_key_exists("textoBusca", $this->request->data)){
          $textoBusca = $this->request->data["textoBusca"];
        }        
    	
        $this->set('title', "Pedidos");
        $this->set("pagina", $pagina);
        $this->set("textoBusca", $textoBusca);
        $this->set("recurso", $recurso);
        $this->set("pedidos", $pedidos);
        $this->set("total", $total);
 		$this->set("usuarioLogado", $usuarioLogado);
    }

    public function buscaAvancada(){
    	
    }

    public function detalhe($slug){

        $slug = $this->UString->AntiXSSComLimite($slug, 200);

        $pedidoBU = new Pedido();

        $pedidoBU->Slug = $slug;
        //2017-01-18 Paulo Campos: Coloquei moderação = false (ListarPorSlug(false))
        $pedido = $pedidoBU->ListarPorSlug(false);


        //debug($pedido);
        if($pedido == null){
            $this->set("url", "/pedidos/$slug");
            $this->set("message", "404");
            $this->render('/Error/error400');
        }

        $comentarioBU = new Comentario();
        $comentarioBU->CodigoObjeto = $pedido["Codigo"];
        $comentarios = $comentarioBU->ListarPorPedido();

        $pedidoInteracaoBU = new PedidoInteracao();
        $pedidoInteracaoBU->CodigoPedido = $pedido["Codigo"];

        $interacoes = $pedidoInteracaoBU->Listar();
        $usuarioRelacionamentoBU = new UsuarioRelacionamento();
        $usuarioRelacionamentoBU->CodigoTipoObjeto = 1;
        $usuarioRelacionamentoBU->CodigoObjeto = $pedido["Codigo"];
        
        $totalSeguidores = $usuarioRelacionamentoBU->TotalSeguindoPedido();

        $estaSeguindo = false;
        if($this->USessao->EstaLogadoFront($this->request)){
            $usuarioRelacionamentoBU->CodigoUsuario = 1;

            $estaSeguindo = $usuarioRelacionamentoBU->EstaSeguindoObjeto();
        }

        $avaliacao = new Avaliacao();
        $avaliacao->CodigoObjeto = $pedido["Codigo"];
        $avaliacao->CodigoTipoObjeto = 1;

        $nota = $avaliacao->CalcularMediaAvaliacoes();
        $totalAvaliacoes = $avaliacao->TotalAvaliacoes();

        $this->set('title', $pedido["Titulo"]);
        $this->set('pedido', $pedido);
        $this->set('interacoes', $interacoes);
        $this->set('comentarios', $comentarios);
        $this->set('estaSeguindo', $estaSeguindo);
        $this->set('totalSeguidores', $totalSeguidores);
        $this->set('nota', $nota);
        $this->set('totalAvaliacoes', $totalAvaliacoes);
        $this->set('usuarioLogado', $this->USessao->EstaLogadoFront($this->request));
    }

}