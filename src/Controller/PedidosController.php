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