<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
use App\Controller\Component\UDataComponent;
use App\Controller\Component\UStringComponent;
use App\Controller\Component\UCurlComponent;
use App\Controller\Component\UNumeroComponent;
use Cake\Datasource\ConnectionManager;
use Cake\Log\Log;
class PedidoInteracao extends Entity{

	public function Validar(){
		$arrayErros = [];
		$conn_pedido = TableRegistry::get("Pedidos");

		//$this->CodigoStatusPedido = UNumeroComponent::ValidarNumero($this->CodigoStatusPedido);
		//2017-04-27 Paulo Campos: Aumentando o limite de strings de 3.000 para 100.000
		//$this->Descricao = UStringComponent::AntiXSSComLimite($this->Descricao, 1000);
		$this->Descricao = UStringComponent::AntiXSSComLimite($this->Descricao, 100000);
		$this->CodigoTipoPedidoResposta = UNumeroComponent::ValidarNumero($this->CodigoTipoPedidoResposta);


		$elemento = $conn_pedido->find()->where(["Codigo" => $this->CodigoPedido])->first();

		// verifica se pedido existe
		if($elemento == null){
			$arrayErros["Pedido"] = "Pedido inválido. Por favor, recarregue a página.";
			return $arrayErros;
		}

		//2018-04-26 Paulo Campos - Comentado
		// if(strlen($this->Descricao) <= 30){
		// 	$arrayErros["Descricao"] = "Descricao inválida. Digite ao menos 30 caracteres.";
		// }

		if(!isset($this->DataResposta) || !UDataComponent::validateDate($this->DataResposta)){
			$arrayErros["DataResposta"] = "A data digitada é inválida.";
		}

		//2016-01-16 Paulo Campos - Comentado
		//$elemento = TableRegistry::get("TipoPedidoSituacao")->find()->where(["Codigo" => $this->CodigoTipoPedidoSituacao])->first();
		//if($elemento == null){
		//	$arrayErros["CodigoTipoPedidoSituacao"] = "Selecione a situação em que se encontra o seu pedido.";
		//}

		//2016-01-16 Paulo Campos - Comentado
		$elemento = TableRegistry::get("StatusPedido")->find()->where(["Codigo" => $this->CodigoStatusPedido])->first();
		if($elemento == null){
			$arrayErros["CodigoStatusPedido"] = "Selecione o status em que se encontra o seu pedido.";
		}

		$elemento = TableRegistry::get("TipoPedidoResposta")->find()->where(["Codigo" => $this->CodigoTipoPedidoResposta])->first();
		if($elemento == null){
			$arrayErros["CodigoTipoPedidoResposta"] = "Selecione o tipo de resposta do pedido.";
		}

		return $arrayErros;
	}

	public function ValidarAtualizacao(){
		$arrayErros = [];
		$conn_pedido = TableRegistry::get("Pedidos");

		//2017-04-27 Paulo Campos: Aumentando o limite de strings de 3.000 para 100.000
		//$this->Descricao = UStringComponent::AntiXSSComLimite($this->Descricao, 1000);
		$this->Descricao = UStringComponent::AntiXSSComLimite($this->Descricao, 100000);

		$elemento = $conn_pedido->find()->where(["Codigo" => $this->CodigoPedido])->first();
		// verifica se pedido existe
		if($elemento == null){
			$arrayErros["Pedido"] = "Pedido inválido. Por favor, recarregue a página.";
		}

		if(!isset($this->CodigoTipoPedidoResposta) || empty($this->CodigoTipoPedidoResposta)){
			$arrayErros["CodigoTipoPedidoResposta"] = "Este campo é obrigatório.";
		}

		//2018-04-26 Paulo Campos - Comentado
		// if(strlen($this->Descricao) <= 30){
		// 	$arrayErros["Descricao"] = "Descricao inválida. Digite ao menos 30 caracteres.";
		// }

		if(!isset($this->DataResposta) || !UDataComponent::validateDate($this->DataResposta)){
			$arrayErros["DataResposta"] = "A data digitada é inválida.";
		}
		return $arrayErros;
	}

	public function Salvar(){
		$conn = TableRegistry::get("PedidosInteracoes");

		$this->DataResposta = UDataComponent::ConverterMySQL($this->DataResposta);

		if($conn->save($this)){
			//2016-01-16 Paulo Campos - Comentado
			// atualiza o status o pedido
			// if($this->CodigoTipoPedidoSituacao > 0){
			// 	$pedido = new Pedido();
			// 	$pedido->Codigo = $this->CodigoPedido;
			// 	$pedido->CodigoTipoPedidoSituacao = $this->CodigoTipoPedidoSituacao;

			// 	$pedido->AtualizarStatus();
			// }
			return true;
		}

		return false;
	}

	public function Listar()
	{
		$conn = TableRegistry::get("PedidosInteracoes");
		$conn_anexo = TableRegistry::get("PedidosAnexos");

		$elementos = $conn->find()->where(["CodigoPedido" => $this->CodigoPedido])->contain(["TipoPedidoResposta"])->order(['DataResposta' =>'Asc']);

		if(count($elementos) > 0){
			// carregar anexos
			foreach($elementos as $elemento){
				$elemento->Arquivos = $conn_anexo->find()->where(["CodigoPedidoInteracao" => $elemento->Codigo, "Ativo" => 1]);
			}
		}

		return $elementos;
	}

	public function ES_AtualizarPorCodidoPedido($codigoPedido)
	{
		if($codigoPedido != null && $codigoPedido > 0){

			// monta loop para atualizar todas as interações de um pedido
			$this->CodigoPedido = $codigoPedido;

			$interacoes = $this->Listar();

			foreach($interacoes as $interacao)
			{
				$this->ES_EnviarDados($interacao->Codigo);
			}
		}
	}

	public function ES_AtualizarInserirInteracoes($codigoPedidoInteracao)
	{
		$connection = ConnectionManager::get('default');

		if($codigoPedidoInteracao != null)
			$filtro = ' and pi.Codigo = ' . $codigoPedidoInteracao;
		else
			$filtro = ' and b.Codigo is null ';

		// 2017-01-17 Paulo Campos - Comentado. Tirei o Join de moderacao
		// $query = 'Select
		// 		pi.Codigo interacoes_codigo,
		// 	    tpr.Codigo tipo_pedidos_resposta_codigo_local,
		// 	    tpr.Nome tipo_pedidos_resposta_nome_local,
		// 	    pi.Descricao interacoes_descricao_local,
		// 	     DATE_FORMAT(pi.DataResposta,"%Y-%m-%d") interacoes_data_resposta_local,
		// 		a.Codigo pedidos_codigo,
		// 	    case when b.Codigo is null Then 0 Else 1 end JaEnviado,
		// 	    a.CodigoUsuario usuarios_codigo,
		// 	    d.Codigo agentes_codigo,
		// 	    c.Nome usuarios_nome,
		// 	    d.Nome agentes_nome,
		// 	    c.Email usuarios_email,
		// 	    a.CodigoStatusPedido status_pedido_codigo,
		// 	    a.CodigoStatusPedidoInterno status_pedido_interno_codigo,
		// 	    e.Nome status_pedido_nome,
		// 	    f.Nome status_pedido_interno_nome,
		// 	    a.CodigoTipoPedidoSituacao tipo_pedido_situacao_codigo,
		// 	    g.Nome tipo_pedido_situacao_nome,
		// 	    h.Nome tipo_pedido_origem_nome,
		// 	    tp.Codigo tipo_poder_codigo,
		// 	    tp.Nome tipo_poder_nome,
		// 	    tnf.Codigo tipo_nivel_federativo_codigo,
		// 	    tnf.Nome tipo_nivel_federativo_nome,
		// 	    a.Protocolo pedidos_protocolo,
		// 	    a.Titulo pedidos_titulo,
		// 	    a.Slug pedidos_slug,
		// 	    a.Descricao pedidos_descricao,
		// 	    a.FoiProrrogado pedidos_foi_prorrogado,
		// 	    a.Anonimo pedidos_anonimo,
		// 	    DATE_FORMAT(a.DataEnvio,"%Y-%m-%d") pedidos_data_envio,
		// 	    "" pedidos_enviado_para
		// 	from
		// 		pedidos a join
		// 	    pedidos_interacoes pi on a.Codigo = pi.CodigoPedido left join
		// 		es_pedidos_interacoes b on pi.Codigo = b.CodigoPedidoInteracao join
		// 	    usuarios c on a.CodigoUsuario = c.Codigo join
		// 	    agentes d on d.Codigo = a.CodigoAgente join
		// 	    status_pedido e on a.CodigoStatusPedido = e.Codigo join
		// 	    status_pedido f on a.CodigoStatusPedidoInterno = f.Codigo join
		// 	    tipo_pedido_situacao g on g.Codigo = a.CodigoTipoPedidoSituacao join
		// 	    tipo_pedido_origem h on a.CodigoTipoOrigem = h.Codigo join
		// 	    tipo_poder tp on tp.Codigo = d.CodigoPoder join
		// 	    tipo_nivel_federativo tnf on tnf.Codigo = d.CodigoNivelFederativo join
		// 	    tipo_pedido_resposta tpr on tpr.Codigo = pi.CodigoTipoPedidoResposta join
		// 	    moderacoes modera on modera.CodigoObjeto = a.Codigo and modera.CodigoTipoObjeto = 1 and modera.CodigoStatusModeracao = 2
		// 	where
		// 		a.Ativo = 1 ' . $filtro;

		//2017-03-14 Paulo Campos: Adição de join para moderacao
		$query = 'Select
				pi.Codigo interacoes_codigo,
			    tpr.Codigo tipo_pedidos_resposta_codigo_local,
			    tpr.Nome tipo_pedidos_resposta_nome_local,
			    pi.Descricao interacoes_descricao_local,
			     DATE_FORMAT(pi.DataResposta,"%Y-%m-%d") interacoes_data_resposta_local,
				a.Codigo pedidos_codigo,
			    case when b.Codigo is null Then 0 Else 1 end JaEnviado,
			    a.CodigoUsuario usuarios_codigo,
			    d.Codigo agentes_codigo,
			    c.Nome usuarios_nome,
			    d.Nome agentes_nome,
			    c.Email usuarios_email,
			    a.CodigoStatusPedido status_pedido_codigo,
			    a.CodigoStatusPedidoInterno status_pedido_interno_codigo,
			    e.Nome status_pedido_nome,
			    f.Nome status_pedido_interno_nome,
			    a.CodigoTipoPedidoSituacao tipo_pedido_situacao_codigo,
			    g.Nome tipo_pedido_situacao_nome,
			    h.Nome tipo_pedido_origem_nome,
			    tp.Codigo tipo_poder_codigo,
			    tp.Nome tipo_poder_nome,
			    tnf.Codigo tipo_nivel_federativo_codigo,
			    tnf.Nome tipo_nivel_federativo_nome,
			    a.Protocolo pedidos_protocolo,
			    a.Titulo pedidos_titulo,
			    a.Slug pedidos_slug,
			    a.Descricao pedidos_descricao,
			    a.FoiProrrogado pedidos_foi_prorrogado,
			    a.Anonimo pedidos_anonimo,
			    DATE_FORMAT(a.DataEnvio,"%Y-%m-%d") pedidos_data_envio,
			    "" pedidos_enviado_para
			from
				pedidos a join
			    pedidos_interacoes pi on a.Codigo = pi.CodigoPedido left join
				es_pedidos_interacoes b on pi.Codigo = b.CodigoPedidoInteracao join
			    usuarios c on a.CodigoUsuario = c.Codigo join
			    agentes d on d.Codigo = a.CodigoAgente join
			    status_pedido e on a.CodigoStatusPedido = e.Codigo join
			    status_pedido f on a.CodigoStatusPedidoInterno = f.Codigo join
			    tipo_pedido_situacao g on g.Codigo = a.CodigoTipoPedidoSituacao join
			    tipo_pedido_origem h on a.CodigoTipoOrigem = h.Codigo join
			    tipo_poder tp on tp.Codigo = d.CodigoPoder join
			    tipo_nivel_federativo tnf on tnf.Codigo = d.CodigoNivelFederativo join
			    tipo_pedido_resposta tpr on tpr.Codigo = pi.CodigoTipoPedidoResposta join
		 	    moderacoes modera on modera.CodigoObjeto = a.Codigo and modera.CodigoTipoObjeto = 1 and modera.CodigoStatusModeracao = 2
			where
				a.Ativo = 1 ' . $filtro;

        Log::info("[TASK] Indexando Interações .. ");

		try{
		    $results = $connection->execute($query)->fetchAll('assoc');
            Log::info("[TASK] Há indexar: " . count($results));
			if(count($results) > 0){

				foreach($results as $item){

					$codigo = $item["interacoes_codigo"];
					$json = json_encode($item);
					$url = ES_URL . 'interacoes/gravar/' . $codigo;

                    Log::info("[TASK] Indexando: " . $codigo);

					$retorno = UCurlComponent::enviarDadosJson($url, $json, "PUT");

					if($retorno !== false)
					{
						$retornoJson = json_decode($retorno);
						// debug ($retornoJson);
						// die();
						if((isset($retornoJson->success)) and ($retornoJson->success != null)){
							$pedidoBU = new Pedido();

							$pedidoBU->ES_InserirAtualizarPedidos($item["pedidos_codigo"], $item["tipo_pedidos_resposta_nome_local"], $item["tipo_pedidos_resposta_codigo_local"]);
							// atualiza pra cada item no banco local
							$this->ES_InserirAtualizarLocalmente($codigo);
						}
					}
				}
			}
		}catch(Exception $ex)
		{
			// logar erro no banco
			$url = $_SERVER['REQUEST_URI'];
			$variaveis = "Erro ao enviar interação ao elastic search:" . (is_null($codigoPedidoInteracao) ? "0" : $codigoPedidoInteracao);
			UStringComponent::registrarErro($url, $ex, $variaveis);
		}

	}

	//2017-03-14 Paulo Campos: Criada funcao para inserir interacoes em bloco por pedido
	public function ES_InserirAtualizarInteracaoPorPedido($codigoPedido)
	{
		$connection = ConnectionManager::get('default');

		if($codigoPedido != null)
			$filtro = ' and a.Codigo = ' . $codigoPedido;
		else
			$filtro = ' and b.Codigo is null ';
		//2017-03-14 Paulo Campos: Adição de join para moderacao
		$query = 'Select
				pi.Codigo interacoes_codigo,
			    tpr.Codigo tipo_pedidos_resposta_codigo_local,
			    tpr.Nome tipo_pedidos_resposta_nome_local,
			    pi.Descricao interacoes_descricao_local,
			     DATE_FORMAT(pi.DataResposta,"%Y-%m-%d") interacoes_data_resposta_local,
				a.Codigo pedidos_codigo,
			    case when b.Codigo is null Then 0 Else 1 end JaEnviado,
			    a.CodigoUsuario usuarios_codigo,
			    d.Codigo agentes_codigo,
			    c.Nome usuarios_nome,
			    d.Nome agentes_nome,
			    c.Email usuarios_email,
			    a.CodigoStatusPedido status_pedido_codigo,
			    a.CodigoStatusPedidoInterno status_pedido_interno_codigo,
			    e.Nome status_pedido_nome,
			    f.Nome status_pedido_interno_nome,
			    a.CodigoTipoPedidoSituacao tipo_pedido_situacao_codigo,
			    g.Nome tipo_pedido_situacao_nome,
			    h.Nome tipo_pedido_origem_nome,
			    tp.Codigo tipo_poder_codigo,
			    tp.Nome tipo_poder_nome,
			    tnf.Codigo tipo_nivel_federativo_codigo,
			    tnf.Nome tipo_nivel_federativo_nome,
			    a.Protocolo pedidos_protocolo,
			    a.Titulo pedidos_titulo,
			    a.Slug pedidos_slug,
			    a.Descricao pedidos_descricao,
			    a.FoiProrrogado pedidos_foi_prorrogado,
			    a.Anonimo pedidos_anonimo,
			    DATE_FORMAT(a.DataEnvio,"%Y-%m-%d") pedidos_data_envio,
			    "" pedidos_enviado_para
			from
				pedidos a join
			    pedidos_interacoes pi on a.Codigo = pi.CodigoPedido left join
				es_pedidos_interacoes b on pi.Codigo = b.CodigoPedidoInteracao join
			    usuarios c on a.CodigoUsuario = c.Codigo join
			    agentes d on d.Codigo = a.CodigoAgente join
			    status_pedido e on a.CodigoStatusPedido = e.Codigo join
			    status_pedido f on a.CodigoStatusPedidoInterno = f.Codigo join
			    tipo_pedido_situacao g on g.Codigo = a.CodigoTipoPedidoSituacao join
			    tipo_pedido_origem h on a.CodigoTipoOrigem = h.Codigo join
			    tipo_poder tp on tp.Codigo = d.CodigoPoder join
			    tipo_nivel_federativo tnf on tnf.Codigo = d.CodigoNivelFederativo join
			    tipo_pedido_resposta tpr on tpr.Codigo = pi.CodigoTipoPedidoResposta join
		 	    moderacoes modera on modera.CodigoObjeto = a.Codigo and modera.CodigoTipoObjeto = 1 and modera.CodigoStatusModeracao = 2
			where
				a.Ativo = 1 ' . $filtro;

		$results = $connection->execute($query)->fetchAll('assoc');
		try{
			if(count($results) > 0){

				foreach($results as $item){

					$codigo = $item["interacoes_codigo"];
					$json = json_encode($item);
					$url = ES_URL . 'interacoes/gravar/' . $codigo;
					$retorno = UCurlComponent::enviarDadosJson($url, $json, "PUT");

					if($retorno !== false)
					{
						$retornoJson = json_decode($retorno);

						if($retornoJson->success != null){
							$pedidoBU = new Pedido();

							//$pedidoBU->ES_InserirAtualizarPedidos($item["pedidos_codigo"], $item["tipo_pedidos_resposta_nome_local"], $item["tipo_pedidos_resposta_codigo_local"]);
							// atualiza pra cada item no banco local
							$this->ES_InserirAtualizarLocalmente($codigo);
						}
					}
				}
			}
		}catch(Exception $ex)
		{
			// logar erro no banco
			$url = $_SERVER['REQUEST_URI'];
			$variaveis = "Erro ao enviar interação ao elastic search:" . (is_null($codigoPedido) ? "0" : $codigoPedido);
			UStringComponent::registrarErro($url, $ex, $variaveis);
		}

	}

	public function ES_InserirAtualizarLocalmente($codigo)
	{
		$conn_es_pedido_interacao = TableRegistry::get("EsPedidosInteracoes");

		$elemento = $conn_es_pedido_interacao->find('all')->where(["CodigoPedidoInteracao" => $codigo])->first();

		if($elemento == null){
			$elemento = $conn_es_pedido_interacao->newEntity();
			$elemento->CodigoPedidoInteracao = $codigo;
		}else{
			$data = date_default_timezone_get();
			$elemento->Alteracao = $data;
		}

		$conn_es_pedido_interacao->save($elemento);
	}

	public function ES_RemoverInteracaoPorPedido($codigoPedido)
	{
		if($codigoPedido != null && $codigoPedido > 0){

			// monta loop para atualizar todas as interações de um pedido
			$this->CodigoPedido = $codigoPedido;

			$interacoes = $this->Listar();

			foreach($interacoes as $interacao)
			{
				$this->ES_RemoverInteracao($interacao->Codigo);
			}
		}
	}

	public function ES_RemoverInteracao($codigoPedidoInteracao)
	{
		try{
			$url = ES_URL . 'interacoes/apagar/' . $codigoPedidoInteracao;

			$retorno = UCurlComponent::enviarDadosJson($url, "", "DELETE");

			if($retorno !== false)
			{
				$retornoJson = json_decode($retorno);

				if(strpos($retorno, "error") === false){
					// atualiza pra cada item no banco local
					$this->ES_InserirAtualizarLocalmente($codigoPedidoInteracao);

					// remove anexos relacionados
					$pedidoAnexoBU = new PedidoAnexo();
					$pedidoAnexoBU->ES_RemoverAnexoPorInteracao($codigoPedidoInteracao);
				}
			}
		}catch(Exception $ex)
		{
			// logar erro no banco
			$url = $_SERVER['REQUEST_URI'];
			$variaveis = "Erro ao remover interação do elastic search:" . (is_null($codigoPedidoInteracao) ? "0" : $codigoPedidoInteracao);
			UStringComponent::registrarErro($url, $ex, $variaveis);
		}
	}
}

?>
