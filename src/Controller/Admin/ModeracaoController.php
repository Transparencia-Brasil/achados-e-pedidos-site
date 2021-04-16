<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Model\Entity\Moderacao;
use App\Model\Entity\Pedido;
use App\Model\Entity\PedidoInteracao;
use App\Model\Entity\PedidoAnexo;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class ModeracaoController extends AppController{

	public function initialize()
	{
		parent::initialize();
		$this->layout = 'admin';
		$this->loadComponent('Flash');
		$this->loadComponent("UNumero");
        $this->loadComponent('UData');
        $this->loadComponent('UEmail');
	}

	public function index($id = null)
	{
		// carregar todos os elementos não moderados
		// separar dados base dos elementos para exibição
		$moderacaoBU = new Moderacao();

		$lista = $moderacaoBU->ListarNaoModerados();

		$this->set('lista', $lista);
	}

	public function moderar($codigo, $status)
	{
		$this->autoRender = false;
        $this->response->type('application/json');

		$conn = TableRegistry::get("Moderacoes");

		$codigo = $this->UNumero->ValidarNumero($codigo);
		$status = $this->UNumero->ValidarNumero($status);

		$elemento = $conn->find('all')->where(["codigo" => $codigo])->first();
		if($elemento == null)
		{
			$retorno = ["erro" => true, "msg" => "Elemento não encontrado"];
		}else{
			if($status < 1 || $status > 4)
			{
				$retorno = ["erro" => true, "msg" => "Status inválido."];	
			}else{
			
				$elemento->CodigoStatusModeracao = $status;

				if($conn->save($elemento))
				{
					$retorno = ["status" => 1];
				}else{
					$retorno = ["erro" => true, "msg" => "Erro ao salvar elemento."];	
				}

				// se for do tipo 1 e aprovado, atualiza no elastic search 
				//2017-03-14 Paulo Campos: Coloquei depois de atualizar o status da moderacao para 2
				if($elemento->CodigoTipoObjeto == 1 && $status == 2)
				{
					
					$pedidoBU = new Pedido();
					$pedidoBU->ES_InserirAtualizarPedidos($elemento->CodigoObjeto);
					$pedidoInteracaoBU = new PedidoInteracao();
					$pedidoInteracaoBU->ES_InserirAtualizarInteracaoPorPedido($elemento->CodigoObjeto);
					$pedidoAnexoBU = new PedidoAnexo();
					$pedidoAnexoBU->ES_AtualizarInserirAnexosPorPedido($elemento->CodigoObjeto);
					$moderacaoBU = new Moderacao();
					$usuario = $moderacaoBU->ListarUsuarioObjetoModeracao($elemento->CodigoObjeto);
					
					//envia email de moderação aprovada se o cliente aceitar comunicações.
					if($usuario["AceiteComunicacao"] == 1){
						
						$this->UEmail->
							EnviarEmailPedidoModeradoAceito(
							$usuario["Email"], 
							$usuario["NomeUsuario"], 
							$usuario["TituloPedido"],
							BASE_URL . 'minhaconta/pedidos/editar/' .$usuario["slug"]);
					}

				}
			}
		}

		echo json_encode($retorno);
	}


}
