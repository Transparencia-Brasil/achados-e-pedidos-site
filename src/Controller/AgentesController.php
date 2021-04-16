<?php
namespace App\Controller;

use Cake\ORM\TableRegistry;
use App\Model\Entity\Agente;
use App\Model\Entity\Pedido;
use App\Model\Entity\Avaliacao;
use App\Model\Entity\Comentario;

class AgentesController extends AppController
{
    public $helpers = ["FrontEnd"];
    
	public function initialize(){
        parent::initialize();

        $this->loadComponent("UString");
        $this->loadComponent("UNumero");
        $this->loadComponent('Flash');
        $this->set('slug_pai', "agentes");
    }

    public function index(){

        $agente = new Agente();

        $total = 0;
        $pagina = 1;

        if ($this->request->is('post')) {

            $data = $this->request->data;
            
            $pagina = $this->UNumero->ValidarNumero($data["pagina"]);
            $pagina = $pagina <= 0 ? 1 : $pagina;

            $agentesTotal = $agente->FiltrarAgentes($data, 1, 0);
            $dados = $agente->FiltrarAgentes($data, $pagina);
            $total = count($agentesTotal);

        }else{
            $dados = $agente->ListarModerados();

            $total = count($dados);
            
            $this->request->data["codigoPoder"] = "";
            $this->request->data["codigoNivelFederativo"] = "";
        }

        $this->set("agentes", $dados);    	
        $textoBusca = "";
        if(array_key_exists("textoBusca", $this->request->data)){
          $textoBusca = $this->request->data["textoBusca"];
        }        
        
        $this->set('title', "Órgãos Públicos");
        $this->set("pagina", $pagina);
        $this->set("textoBusca", $textoBusca);
        $this->set("total", $total);
    }

    public function detalhe($slug ){

        $slug = $this->UString->AntiXSSComLimite($slug, 200);

        $agenteBU = new Agente();

        $agente = $agenteBU->ListarPorSlug($slug);

        if($agente == null){
            $this->set("url", "/agentes/$slug");
            $this->set("message", "404");
            $this->render('/Error/error400');

            return;
        }

        /*
        Carregamento dos subelementos
        */
        $avaliacaoBU = new Avaliacao();
        $pedidosBU = new Pedido();
        $comentarioBU = new Comentario();

        $pagina = 1;

        if($this->request->is('post')){
            $pagina = $this->UNumero->ValidarNumeroEmArray($this->request->data, 'pagina');
        }

        $codigoAgente = $agente["Codigo"];
        $avaliacaoBU->CodigoObjeto = $codigoAgente;
        $avaliacao = $avaliacaoBU->ListarParaAgente();
        $totalAvaliacao = $avaliacaoBU->TotalAvaliacoes();

        $pedidosBU->CodigoAgente = $codigoAgente;
        $pedidos = $pedidosBU->ListarPorAgente($pagina, 5);
        $totalPedidos = $pedidosBU->TotalPorAgente($moderacao=true);

        $comentarioBU->CodigoObjeto = $codigoAgente;
        $comentarios = $comentarioBU->ListarPorAgente();

        $totalSeguidores = $agenteBU->TotalSeguidores($agente["Codigo"]);

        $this->set('title', "Órgão Público - " . $agente["Nome"]);
        $this->set("pagina", $pagina);
        $this->set("agente", $agente);
        $this->set("totalPedidos", $totalPedidos);
        $this->set("avaliacao", $avaliacao);
        $this->set("totalAvaliacao", $totalAvaliacao);
        $this->set("totalSeguidores", $totalSeguidores);
        $this->set("pedidos", $pedidos);
        $this->set("comentarios", $comentarios);
    }
}