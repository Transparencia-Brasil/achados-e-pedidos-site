<?php
namespace App\Controller;

use App\Model\Entity\Projeto;
use Cake\ORM\TableRegistry;
use App\Model\Entity\Publicacao;
use App\Model\Entity\PublicacaoCategoria;
use Cake\I18n\Time;

class PublicacoesController extends AppController
{
    public $helpers = ["FrontEnd"];
	public function initialize(){
        parent::initialize();

        $this->loadComponent("UNumero");
        $this->set('slug_pai', "publicacoes");
        $this->loadComponent('RequestHandler');
    }

	public function index()
    {
    	$publicacaoBU = new Publicacao();
        $publicacaoCatBU = new PublicacaoCategoria();

    	$anos = $publicacaoBU->ListarAnosParaSelect();
        $categorias = $publicacaoCatBU->ListarParaSelect();

        $pagina = 1;
        $totalGeral = $publicacaoBU->TotalPublicacao();

        if ($this->request->is('post')) {
            $data = $this->request->data;

            $pagina = $this->UNumero->ValidarNumero($data["pagina"]);
            $pagina = $pagina <= 0 ? 1 : $pagina;

            $publicacoes = $publicacaoBU->Filtrar($data, $pagina);
            $publicacoesTotal = count($publicacaoBU->Filtrar($data, 1, 0));
        }else{
            $total = $totalGeral;
            $publicacoes = $publicacaoBU->Filtrar(null, 1);

            $publicacoesTotal = count($publicacoes);
        }

        $this->set('title', "Publicações");
        $this->set('totalGeral', $totalGeral);
        $this->set('total', $publicacoesTotal);
        $this->set('pagina', $pagina);
    	$this->set('anos', $anos);
        $this->set('categorias', $categorias);
        $this->set("publicacoes", $publicacoes);
    }

    public function pesquisarPublicacoes()
    {
        $this->autoRender = false;
        $this->response->type('application/json');
        
        try{
            $ano = $this->request->data["ano"] == null ? 0 : $this->request->data["ano"];
            $categoria = $this->request->data["categoria"] == null ? 0 : $this->request->data["categoria"];

            $retorno = ["erro" => true, "msg" => "valores inválidos."];
        }catch(Exception $ex){
            $retorno = ["erro" => true, "msg" => "Erro ao buscar publicações."];
        }

        echo json_encode($retorno);
    }

    public function pesquisarPublicacoesPorBusca()
    {
    	$this->autoRender = false;
    	$this->response->type('application/json');
    	
        try{
            $busca = $this->request->data["busca"] == null ? "" : $this->request->data["busca"];

        	$retorno = "";
        	
            $retorno = ["erro" => true, "msg" => "busca vazia"];
        }
        catch(Exception $ex){
            $retorno = ["erro" => true, "msg" => "Erro ao buscar publicações"];
        }
        //die(debug($retorno));
    	echo json_encode($retorno);
    }
}

?>