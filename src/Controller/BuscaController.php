<?php
namespace App\Controller;

use Cake\ORM\TableRegistry;
use App\Model\Entity\Agente;
use App\Model\Entity\Pedido;
use App\Model\Entity\Usuario;

class BuscaController extends AppController
{
    public $helpers = ["FrontEnd"];
    
	public function initialize(){
        parent::initialize();

        $this->loadComponent("UString");
        $this->loadComponent("UNumero");
        $this->loadComponent('Flash');
        $this->set('slug_pai', "busca");
    }

	public function index($tipo = "pedidos"){
		$termo = $this->UString->AntiXSSEmArrayComLimite($this->request->query, "termo", 50);

		// Alteração para integração com o Elastic Search
		if($tipo == "pedidos"){
			$this->set("termo", $termo);
			$this->set("tipo", $tipo);

			$this->render('index_pedidos');
			return;
		}

		$resultado = [];
		$pagina = 1;
		$total = 0;
		$qtd = 1;
		$data = [];

		if(strlen($termo) > 0)
		{
			$pagina = $this->UNumero->ValidarNumeroEmArray($this->request->query, "pagina");
			$pagina = $pagina == 0 ? 1 : $pagina;

			$data["textoBusca"] = $termo;

			// efetua pesquisa em usuários, agentes e pedidos
			if($tipo == "pedidos"){
				$pedidoBU = new Pedido();

				
				$qtd = 4;

				// verifica a qtd de elementos
				$total = count($pedidoBU->FiltrarPedidos($data, 1, 0));
				$resultado = $pedidoBU->FiltrarPedidos($data, $pagina, $qtd);
		
			}else if($tipo == "agentes"){
				
				$agenteBU = new Agente();
				$qtd = 6;

				$total = count($agenteBU->FiltrarAgentes($data, 1, 0));
            	$resultado = $agenteBU->FiltrarAgentes($data, $pagina, $qtd);

			}else if($tipo == "usuarios"){
				$usuarioBU = new Usuario();

				$qtd = 6;

				$total = count($usuarioBU->Filtrar($data, 1, 0));
				
				$resultado = $usuarioBU->Filtrar($data, $pagina, $qtd);
			}
		}

		$this->set('title', "Busca");
		$this->set("qtd", $qtd);
		$this->set("total", $total);
		$this->set("pagina", $pagina);
		$this->set("termo", $termo);
		$this->set("tipo", $tipo);
		$this->set("resultado", $resultado);
	}
}	

?>