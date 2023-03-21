<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
use Cake\Log\Log;
use Cake\Datasource\ConnectionManager;
use App\Controller\Component\UDataComponent;
use App\Controller\Component\UStringComponent;
use App\Controller\Component\UNumeroComponent;
use App\Controller\Component\UCurlComponent;
use Psy\Exception\ThrowUpException;
use Exception;

class PedidoAnexo extends Entity{

	public $PASTA_UPLOAD = WWW_ROOT . "uploads". DS . "pedidos" . DS;
	public $EXTENSOES_VALIDAS = ["pdf","xls","txt","xlsx", "doc","docx", "csv","rar","zip","7z","jpg","jpeg","png"];
	//Ricardo:maio 2017 - Por uma questão de segurança o certo era validar também o mime do arquivo
	//mas como o csv não tem um padrão bem definido, podendo ser até "application/octet-stream".
	//validar será preciso de um passo amais.
	/*public $MIMES_VALIDOS = ["application/pdf","text/plain","application/vnd.ms-excel",
	"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"," application/msword",
	"application/vnd.openxmlformats-officedocument.spreadsheetml.template",
	"application/vnd.ms-excel.sheet.macroEnabled.12","application/msexcel","application/x-msexcel",
	"application/x-ms-excel","application/x-excel","application/x-dos_ms_excel","application/xls",
	"application/x-xls","application/vnd.openxmlformats-officedocument.wordprocessingml.document",
	"application/vnd.openxmlformats-officedocument.wordprocessingml.template",
	"application/vnd.ms-word.document.macroEnabled.12","application/vnd.ms-word.template.macroEnabled.12"];
	*/
	public function Validar($arquivoStream){
		$arrayErros = [];
		if($arquivoStream == null || empty($arquivoStream['name']))
		{
			$arrayErros["Arquivo"] = "Nenhum arquivo recebido.";
		}else{
	
			// Tamanho do Arquivo
			$tamanho = $arquivoStream['size']/1048576;		
			if($tamanho > 200){
				$arrayErros["Arquivo"] = "O Arquivo ".$arquivoStream['name'].", ultrapassa os 100MB permitidos por arquivo.";
			}

			// Formatos Permitidos
			$extensao = pathinfo($arquivoStream['name'], PATHINFO_EXTENSION);
			if(array_search(strtolower($extensao), $this->EXTENSOES_VALIDAS) === false){
				$arrayErros["Arquivo"] = "Tipo de arquivo inválido: ". $arquivoStream['name']. ". Por favor, envie os arquivos no formatos: \"pdf\", \"xls\", \"xlsx\", \"txt\", \"doc\",\"docx\", \"csv\",\"rar\",\"zip\",\"7z\",\"jpg\",\"jpeg";
			}
			// Erro do PHP
			if($arquivoStream['error'] > 0) {

				Log::error("[Validar.Arquivo] " . $$arquivoStream['name'] . " : " . $arquivoStream['error']);

				switch ($arquivoStream['error']) {
					case UPLOAD_ERR_INI_SIZE:
						$arrayErros["Arquivo"] = "O Arquivo ".$arquivoStream['name'].", ultrapassa o tamanho máximo de envio de 100MB.";
						break;
					case UPLOAD_ERR_FORM_SIZE:
						$arrayErros["Arquivo"] = "O Arquivo ".$arquivoStream['name'].", ultrapassa o tamanho máximo de envio de 100MB. ";
						break;
						
					default:
						$arrayErros['Arquivo'] = "Um erro foi encontrado ao realizar o upload do arquivo!";
						break;
				}

				$arrayErros['Arquivo'] = $arrayErros['Arquivo'] . " (" . $arquivoStream['error'] . ")";
			}
		}

		return $arrayErros;
	}

	public function SalvarMultiplos($arquivos, $codigoPedidoInteracao, $codigoPedido = null, &$erros = "")
	{
		$temErro = false;

		try{
            foreach ($arquivos as $arquivo) {
				try {
                	$pedidoAnexo = new PedidoAnexo();
                	$pedidoAnexo->CodigoPedidoInteracao = $codigoPedidoInteracao;
					$status = $pedidoAnexo->Salvar($arquivo);
				}
				catch(Exception $ex) {
					$erros += "Falha ao tentar salvar o anexo: " . $arquivo['name'] . " \r\n";
					$temErro = true;
				}
			}
			$pedidoAnexo->ES_AtualizarInserirAnexosPorPedido($codigoPedido);
        }
        catch(Exception $ex){
            $temErro = true;
			$erros += "Falha ao Salvar os Anexos \r\n";
        }

		if($temErro) {
			Log::error("[SalvarArquivos] Interacao = " . $codigoPedidoInteracao . " : " . $erros);
		}

		return $temErro;
	}

	public function Salvar($arquivoStream){
		$conn = TableRegistry::get("PedidosAnexos");

		if($this->SalvarArquivo($arquivoStream)){
			return $conn->save($this);
		}

		return false;
	}

	public function SalvarArquivo($arquivoStream){

		$extensao = pathinfo($arquivoStream['name'], PATHINFO_EXTENSION);

		$nomeArquivo = str_replace("." . $extensao, "", $arquivoStream["name"]);

		$novoNome = preg_replace("/[^A-Za-z0-9]/", "", $nomeArquivo . "_" . $this->CodigoPedidoInteracao);

		$contador = 1;

		while(true)
		{
			if(!file_exists($this->PASTA_UPLOAD . $novoNome . '_' . $contador . '.' . $extensao)){
				break;
			}
			$contador++;
		}

		$novoNome .=  '_' . $contador . "." . $extensao;

		$boolArquivoOk = move_uploaded_file($arquivoStream['tmp_name'], $this->PASTA_UPLOAD . $novoNome);

		if($boolArquivoOk){
			$this->Arquivo = $novoNome;
			$this->ArquivoFullPath = $this->PASTA_UPLOAD . $novoNome;
			return true;
		}

		return false;
	}

	public function ValidarArquivos($arquivos){
		$errosArquivo = [];

		/* efetua loop de arquivos para validar */
        $contador = 0;
        $tamanhoArquivosTotal =0;
        foreach ($arquivos as $arquivo) {

	       	 $tamanhoArquivosTotal += $arquivo["size"];
	       	 $validou = $this->Validar($arquivo);
	       	 //Verifica se existe algum erro
	       	 if( array_key_exists("Arquivo",$validou)){
	       	 	$errosArquivo["Erro"] = $validou["Arquivo"];
	       	 	return $errosArquivo;
	       	 }

	         if($contador >20){
	         	$errosArquivo["Erro"] = "Só é permitido 20 arquivos por interação";
	         }

	        $contador++;

    	}

    	$tamanhoEmMegaBytes = round($tamanhoArquivosTotal/1048576);

    	if($tamanhoEmMegaBytes > 1500){
    		$errosArquivo["Erro"] = "O tamanho do lote é: ".$tamanhoEmMegaBytes
    		." MB e o máximo por interação 1500MB";
    	}


        return $errosArquivo;
	}

	public function Listar()
	{
		$conn_anexo = TableRegistry::get("PedidosAnexos");

		$elementos = $conn_anexo->find()->where(["CodigoPedidoInteracao" => $this->CodigoPedidoInteracao]);

		return $elementos;
	}

	public function apagarpastas()
	{
		$connection = ConnectionManager::get('default');
		$connection->execute('SET FOREIGN_KEY_CHECKS = 0');
		$query = 'DELETE FROM pedidos_anexos WHERE Arquivo LIKE "%/";';
		$results = $connection->execute($query);
	}

	public function ES_AtualizarPorCodidoPedidoInteracao($codigoPedidoInteracao)
	{
		if($codigoPedidoInteracao != null && $codigoPedidoInteracao > 0){

			// monta loop para atualizar todas as interações de um pedido
			$this->CodigoPedidoInteracao = $codigoPedidoInteracao;

			$anexos = $this->Listar();

			foreach($anexos as $anexo)
			{
				$this->ES_AtualizarInserirAnexos($anexo->Codigo);
			}
		}
	}

	public function ES_AtualizarInserirAnexos($codigoPedidoAnexo)
	{
		$connection = ConnectionManager::get('default');

		if($codigoPedidoAnexo != null)
			$filtro = ' and pa.Codigo = ' . $codigoPedidoAnexo;
		else
			$filtro = ' and b.Codigo is null ';
	    //tpr.Codigo tipo_pedidos_resposta_codigo_local = tpr.Codigo tipo_pedido_origem_codigo,
	    //tpr.Nome tipo_pedidos_resposta_nome_local = tpr.Nome tipo_pedido_origem_nome,
	    //a.CodigoStatusPedidoInterno status_pedido_interno_codigo,
		$query = '
				Select
					pa.Codigo anexos_codigo,
				    pa.Arquivo anexos_arquivo,
				    "" anexos_conteudo_arquivo,
					pi.Codigo interacoes_codigo,
					pi.Descricao interacoes_descricao,
					DATE_FORMAT(pi.DataResposta,"%Y-%m-%d") interacoes_data_resposta,
					a.Codigo pedidos_codigo,
					a.CodigoUsuario usuarios_codigo,
					c.Nome usuarios_nome,
					c.Nome usuarios_slug,
					c.Email usuarios_email,
				    d.Codigo agentes_codigo,
				    d.Nome agentes_nome,
				    d.Nome agentes_slug,
				    h.Codigo tipo_pedido_origem_codigo,
				    h.Nome tipo_pedido_origem_nome,
					a.CodigoTipoPedidoSituacao tipo_pedido_situacao_codigo,
				    g.Nome tipo_pedido_situacao_nome,
					a.CodigoStatusPedido status_pedido_codigo,
				    e.Nome status_pedido_nome,
				    f.Codigo status_pedido_interno_codigo,
				    f.Nome status_pedido_interno_nome,
				    tpr.Codigo tipo_pedidos_resposta_codigo,
				    tpr.Nome tipo_pedido_origem_nome,
					tp.Codigo tipo_poder_codigo,
				    tp.Nome tipo_poder_nome,
				    tnf.Codigo tipo_nivel_federativo_codigo,
				    tnf.Nome tipo_nivel_federativo_nome,
				    a.Protocolo pedidos_protocolo,
				    a.Titulo pedidos_titulo,
				    a.Slug pedidos_slug,
				    a.Descricao pedidos_descricao,
				    "" pedidos_enviado_para,
				   	DATE_FORMAT(a.DataEnvio,"%Y-%m-%d") pedidos_data_envio,
				    a.FoiProrrogado pedidos_foi_prorrogado,
				    a.Anonimo pedidos_anonimo,
				    case when b.Codigo is null Then 0 Else 1 end JaEnviado ' ;
		$from = ' from
					pedidos a join
				    pedidos_interacoes pi on a.Codigo = pi.CodigoPedido join
				    pedidos_anexos pa on pa.CodigoPedidoInteracao = pi.Codigo left join
					es_pedidos_anexos b on pa.Codigo = b.CodigoPedidoAnexo join
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

        Log::info("[TASK] Indexando os Anexos...");

		try{

            $query = $query . $from;
            $countQuery = 'Select Count(*) As Qtd '. $from;
            $countResult = $connection->execute($countQuery)->fetchAll('assoc');
            $CntAnexos =  $countResult[0]["Qtd"];

			if(count($CntAnexos) > 0){
                $qtdLotes = ceil($CntAnexos / 300);
                Log::info("Lotes: " . $qtdLotes);

                for ($iLote=0; $iLote < $qtdLotes ; $iLote++) {
                    $pular = $iLote * 300;
                    $queryLimite = $query . " ORDER BY pa.Codigo DESC LIMIT 100 OFFSET $pular";

                    $batch =  $connection->execute($queryLimite)->fetchAll('assoc');

                    Log::info("Anexos: " . count($batch));

                    $this->ES_EnviarBulkAnexos($batch);
                }
			}
		}catch(Exception $ex)
		{
			// logar erro no banco
			$url = $_SERVER['REQUEST_URI'];
			$variaveis = "Erro ao enviar os anexos!";
			UStringComponent::registrarErro($url, $ex, $variaveis);
		}

	}

    private function ES_EnviarBulkAnexos($anexos) {
        $json = json_encode($anexos);
        $url = ES_URL . 'anexos/gravar-varios';


        Log::info("Indexando Batch: " . count($anexos));

        $retorno = UCurlComponent::enviarDadosJson($url, $json, "PUT");

        if($retorno !== false)
        {
            Log::info("Batch enviado!");
            Log::info($retorno);
            $retornoJson = json_decode($retorno);
            if($retornoJson->success != null){
                // atualiza pra cada item no banco local
                foreach ($anexos as $i => $anexo) {
                    $this->ES_InserirAtualizarLocalmente($anexo["anexos_codigo"]);
                }
            }
        }
        else {
            Log::info("Batch falhou!");
            $variaveis = "Erro ao enviar os anexos!";
            $url = $_SERVER['REQUEST_URI'];
			UStringComponent::registrarErro($url, new Exception("Falha na indexação dos anexos!"), $variaveis);
        }
    }

	//2017-03-14 Paulo Campos: Criada funcao para inserir anexos em bloco por pedido
	public function ES_AtualizarInserirAnexosPorPedido($codigoPedido)
	{
		$connection = ConnectionManager::get('default');

		if($codigoPedido != null)
			$filtro = ' and paesview.pedidos_codigo = ' . $codigoPedido;
		else
			$filtro = ' and paesview.es_pedidos_anexos_codigo is null ';
	    //tpr.Codigo tipo_pedidos_resposta_codigo_local = tpr.Codigo tipo_pedido_origem_codigo,
	    //tpr.Nome tipo_pedidos_resposta_nome_local = tpr.Nome tipo_pedido_origem_nome,
	    //a.CodigoStatusPedidoInterno status_pedido_interno_codigo,
		$query = '
		SELECT 
			paesview.*,
			"" anexos_conteudo_arquivo, 
			pi.Descricao interacoes_descricao, 
			DATE_FORMAT(pi.DataResposta,"%Y-%m-%d") interacoes_data_resposta,
			c.Nome usuarios_nome,
			c.Nome usuarios_slug,
			c.Email usuarios_email,
			d.Codigo agentes_codigo,
			d.Nome agentes_nome,
			d.Nome agentes_slug,
			h.Codigo tipo_pedido_origem_codigo,
			h.Nome tipo_pedido_origem_nome,
			g.Nome tipo_pedido_situacao_nome,
			e.Nome status_pedido_nome,
			f.Codigo status_pedido_interno_codigo,
			f.Nome status_pedido_interno_nome,
			tpr.Codigo tipo_pedidos_resposta_codigo,
			tpr.Nome tipo_pedido_origem_nome,
			tp.Codigo tipo_poder_codigo,
			tp.Nome tipo_poder_nome,
			tnf.Codigo tipo_nivel_federativo_codigo,
			tnf.Nome tipo_nivel_federativo_nome,
			p.Protocolo pedidos_protocolo,
			p.Titulo pedidos_titulo,
			p.Slug pedidos_slug,
			p.Descricao pedidos_descricao,
			"" pedidos_enviado_para,
			DATE_FORMAT(p.DataEnvio,"%Y-%m-%d") pedidos_data_envio,
			p.FoiProrrogado pedidos_foi_prorrogado,
			p.Anonimo pedidos_anonimo
		FROM 
			pedidosAnexosElasticSearchView as paesview
			LEFT JOIN pedidos as p ON p.Codigo =  paesview.pedidos_codigo
			LEFT JOIN pedidos_interacoes as pi ON pi.CodigoPedido = p.Codigo
			LEFT JOIN usuarios c on p.CodigoUsuario = c.Codigo 
			LEFT JOIN agentes d on d.Codigo = p.CodigoAgente 
			LEFT JOIN status_pedido e on p.CodigoStatusPedido = e.Codigo 
			LEFT JOIN status_pedido f on p.CodigoStatusPedidoInterno = f.Codigo 
			LEFT JOIN tipo_pedido_situacao g on g.Codigo = p.CodigoTipoPedidoSituacao 
			LEFT JOIN tipo_pedido_origem h on p.CodigoTipoOrigem = h.Codigo 
			LEFT JOIN tipo_poder tp on tp.Codigo = d.CodigoPoder 
			LEFT JOIN tipo_nivel_federativo tnf on tnf.Codigo = d.CodigoNivelFederativo 
			LEFT JOIN tipo_pedido_resposta tpr on tpr.Codigo = pi.CodigoTipoPedidoResposta
		WHERE 1 = 1 ' . $filtro;

		$results = $connection->execute($query)->fetchAll('assoc');
		try{
			if(count($results) > 0){

				foreach($results as $item){

					$codigo = $item["anexos_codigo"];
					$json = json_encode($item);
					$url = ES_URL . 'anexos/gravar/' . $codigo;

					$retorno = UCurlComponent::enviarDadosJson($url, $json, "PUT");

					if($retorno !== false)
					{
						//debug($retorno);
						$retornoJson = json_decode($retorno);
						if($retornoJson->success != null){
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
			$variaveis = "Erro ao enviar anexo ao elastic search:" . (is_null($codigoPedidoAnexo) ? "0" : $codigoPedidoAnexo);
			UStringComponent::registrarErro($url, $ex, $variaveis);
		}

	}

	public function ES_InserirAtualizarLocalmente($codigo)
	{
		$conn_es_pedido_interacao_anexo = TableRegistry::get("EsPedidosAnexos");

		$elemento = $conn_es_pedido_interacao_anexo->find('all')->where(["CodigoPedidoAnexo" => $codigo])->first();

		if($elemento == null){
			$elemento = $conn_es_pedido_interacao_anexo->newEntity();
			$elemento->CodigoPedidoAnexo = $codigo;
		}else{
			$data = date_default_timezone_get();
			$elemento->Alteracao = $data;
		}

		$conn_es_pedido_interacao_anexo->save($elemento);
	}

	public function ES_RemoverAnexoPorInteracao($codigoPedidoInteracao)
	{
		if($codigoPedidoInteracao != null && $codigoPedidoInteracao > 0){

			// monta loop para atualizar todas as interações de um pedido
			$this->CodigoPedidoInteracao = $codigoPedidoInteracao;

			$anexos = $this->Listar();

			foreach($anexos as $anexo)
			{
				$this->ES_RemoverAnexo($anexo->Codigo);
			}
		}
	}

	public function ES_RemoverAnexo($codigoPedidoAnexo)
	{
		try{
			$url = ES_URL . 'anexos/apagar/' . $codigoPedidoAnexo;

			$retorno = UCurlComponent::enviarDadosJson($url, "", "DELETE");

			if($retorno !== false)
			{
				$retornoJson = json_decode($retorno);

				if(strpos($retorno, "error") === false){
					// atualiza pra cada item no banco local
					$this->ES_InserirAtualizarLocalmente($codigoPedidoAnexo);
				}
			}
		}catch(Exception $ex)
		{
			// logar erro no banco
			$url = $_SERVER['REQUEST_URI'];
			$variaveis = "Erro ao remover anexo do elastic search:" . (is_null($codigoPedidoAnexo) ? "0" : $codigoPedidoAnexo);
			UStringComponent::registrarErro($url, $ex, $variaveis);
		}
	}
}
