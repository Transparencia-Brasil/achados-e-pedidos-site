<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
use App\Controller\Component\UDataComponent;
use App\Controller\Component\UStringComponent;
use App\Controller\Component\UNumeroComponent;
use App\Controller\Component\UCurlComponent;
use Cake\Datasource\ConnectionManager;
use Cake\Log\Log;
use App\Tasks\TaskEnvHelper;
class Pedido extends Entity{

	/*
	Valida os dados antes de inserir um novo pedido no banco.
	*/
	public function ValidarNovoPedido()
	{
		$conn_pedido = TableRegistry::get("Pedidos");

		$arrayErros = [];

		$this->CodigoAgente = UNumeroComponent::ValidarNumero($this->CodigoAgente);
		$this->CodigoTipoPedidoSituacao = UNumeroComponent::ValidarNumero($this->CodigoTipoPedidoSituacao);
		$this->Protocolo = UStringComponent::AntiXSSComLimite($this->Protocolo, 200);
		$this->Protocolo = str_replace(" ", "", $this->Protocolo); // remove espaços
		$this->Titulo = UStringComponent::AntiXSSComLimite($this->Titulo, 150);
		//2017-04-27 Paulo Campos: Aumentando o limite de strings de 3.000 para 100.000
		//$this->Descricao = UStringComponent::AntiXSSComLimite($this->Descricao, 3000);
		$this->Descricao = UStringComponent::AntiXSSComLimite($this->Descricao, 100000);

		$conn_situacao = TableRegistry::get("TipoPedidoSituacao");
		$elemento = $conn_situacao->find()->where(["Codigo" => $this->CodigoTipoPedidoSituacao])->first();

		if($elemento == null)
		{
			$arrayErros["CodigoTipoPedidoSituacao"] = "Selecione a situação em que se encontra o seu pedido.";
		}

		if(!isset($this->CodigoAgente) || $this->CodigoAgente <= 0){
			$arrayErros["CodigoAgente"] = "O órgão público selecionado é inválido.";
		}

		if(!isset($this->Protocolo)){
			$arrayErros["Protocolo"] = "O protocolo digitado é inválido.";
		}

		if(!isset($this->Titulo) || strlen($this->Titulo) == 0){
			$arrayErros["Titulo"] = "O título digitado é inválido.";
		}

		if(!isset($this->DataEnvio) || !UDataComponent::validateDate($this->DataEnvio)){
			$arrayErros["DataEnvio"] = "A data digitada é inválida.";
		}
		//2018-04-26 Paulo Campos - Comentado
		// if(!isset($this->Descricao) || strlen($this->Descricao) <= 30){
		// 	$arrayErros["Descricao"] = "A descrição digitada é inválida. Digite ao menos 30 caracteres.";
		// }

		if(!isset($this->CodigoStatusPedido)){
			$arrayErros["CodigoStatusPedido"] = "Este campo é obrigatório.";
		}

		/*
		Verifica se já existe um protocolo para esse agente antes de salvar
		*/
		$pedido_jaExistente = $conn_pedido->find()->where(['Protocolo' => $this->Protocolo, 'CodigoAgente' => $this->CodigoAgente])->first();

		if($pedido_jaExistente != null){
			$arrayErros["Protocolo"] = "Este protocolo já está cadastrado para este órgão público no sistema";
		}

		return $arrayErros;
	}
/*
	Valida Status antes de inserir no banco.
	*/
	public function ValidarPedidoAtualizacaoStatus()
	{
		$arrayErros = [];

		$this->CodigoStatusPedido = UNumeroComponent::ValidarNumero($this->CodigoStatusPedido);

		if(!isset($this->CodigoStatusPedido) || empty($this->CodigoStatusPedido)){
			$arrayErros["CodigoStatusPedido"] = "Este campo é obrigatório.";
		}

		return $arrayErros;
	}

	/*
	Valida os dados antes de inserir um novo pedido no banco.
	*/
	public function ValidarPedidoAtualizacao()
	{
		$conn_pedido = TableRegistry::get("Pedidos");

		$arrayErros = [];

		$this->CodigoTipoPedidoSituacao = UNumeroComponent::ValidarNumero($this->CodigoTipoPedidoSituacao);
		$this->Protocolo = UStringComponent::AntiXSSComLimite($this->Protocolo, 200);
		$this->Protocolo = str_replace(" ", "", $this->Protocolo); // remove espaços
		//2017-04-27 Paulo Campos: Aumentando o limite de strings de 3.000 para 100.000
		//$this->Descricao = UStringComponent::AntiXSSComLimite($this->Descricao, 3000);
		$this->Descricao = UStringComponent::AntiXSSComLimite($this->Descricao, 100000);

		$conn_situacao = TableRegistry::get("TipoPedidoSituacao");
		$elemento = $conn_situacao->find()->where(["Codigo" => $this->CodigoTipoPedidoSituacao])->first();

		if($elemento == null)
		{
			$arrayErros["CodigoTipoPedidoSituacao"] = "Selecione a situação em que se encontra o seu pedido.";
		}
		//2017-01-21 Paulo Campos: tirando validação strlen
		//if(!isset($this->Protocolo) || strlen($this->Protocolo) < 5){
		if(!isset($this->Protocolo)){
			$arrayErros["Protocolo"] = "O protocolo digitado é inválido.";
		}

		if(!isset($this->Titulo) || strlen($this->Titulo) == 0){
			$arrayErros["Titulo"] = "O título digitado é inválido.";
		}

		if(!isset($this->DataEnvio) || !UDataComponent::validateDate($this->DataEnvio)){
			$arrayErros["DataEnvio"] = "A data digitada é inválida.";
		}

		//2018-04-26 Paulo Campos - Comentado
		// if(!isset($this->Descricao) || strlen($this->Descricao) <= 30){
		// 	$arrayErros["Descricao"] = "A descrição digitada é inválida. Digite ao menos 30 caracteres.";
		// }

		/*
		Verifica se já existe um protocolo para esse agente antes de salvar
		*/
		$pedido_jaExistente = $conn_pedido->find()->where(['Protocolo' => $this->Protocolo, 'CodigoAgente' => $this->CodigoAgente, "Codigo <> " => $this->Codigo])->first();

		if($pedido_jaExistente != null){
			$arrayErros["Protocolo"] = "Este protocolo já está cadastrado para este agente no sistema";
		}

		return $arrayErros;
	}

	/*
	Busca um único pedido no banco de dados. O parâmetro $completo
	indica se vai carregar os dados de interação / arquivos / comentários / etc...
	*/
	public function ListarUnico($codigo = 0, $slug = "", $completo = false){

		$conn_pedido = TableRegistry::get("Pedidos");
		$elemento = new Pedido();

		if($codigo > 0)
		{
			$elemento = $conn_pedido->find()->where(["Codigo" => $codigo])->first();
		}else if(isset($slug)){
			$elemento = $conn_pedido->find()->where(["Slug" => $slug])->first();
		}

		if($completo && $elemento != null){

			$conn_interacao = TableRegistry::get("PedidosInteracoes");
		}

		return $elemento;
	}

	public function ListarPorAgente($pagina, $qtd){

		$start = ($pagina - 1) * $qtd;

		$elementos = $this->ListarModerados(0,"", $this->CodigoAgente, 0, "", 0, 0, "", $start, $qtd, true);

		return $elementos;
	}

	public function ListarPorUsuario($pagina, $qtd, $moderar = true, $CodigoStatusModeracao=2){

		$start = ($pagina - 1) * $qtd;

		if($this->CodigoUsuario <= 0)
			return 0;

		$elementos = $this->ListarModerados(0,"", 0, $this->CodigoUsuario, "", 0, 0, "", $start, $qtd, $moderar,$CodigoStatusModeracao);

		return $elementos;
	}

	public function Salvar() {
		$conn_pedido = TableRegistry::get("Pedidos");

		$novoElemento = $conn_pedido->newEntity();

		$this->CodigoStatusPedidoInterno = 4; // não classificado
		//$this->CodigoStatusPedido = 4;
		$this->FoiProrrogado = false;
		$this->DataEnvio = UDataComponent::ConverterMySQL($this->DataEnvio);
		$this->Slug = substr(UStringComponent::Slugfy($this->Titulo), 0, 200);
		//2017-01-24 Paulo Campos: Valida Slug Unico e grante integridade nos Slugs.
		$codigoPedido = $this->validaSlugUnico($this->Slug);
		if ($codigoPedido > 0) {
			$this->Slug = $this->Slug . "-" . $codigoPedido;
		}
		//die(debug($this));
		return $conn_pedido->save($this);
	}

	/*
	Valida os dados antes de atualizar um pedido no banco.
	*/
	public function AtualizarPedido(){

		$conn_pedido = TableRegistry::get("Pedidos");

		$elemento = $conn_pedido->find()->where(["Codigo" => $this->Codigo])->first();

		if($elemento == null)
			return false;

		// nem todos os elementos podem ser atualizados
		$elemento->Titulo = $this->Titulo; //2017-01-22 Paulo Campos: Incluido titulo na atualização
		$elemento->Descricao = $this->Descricao;
		$elemento->DataEnvio = UDataComponent::ConverterMySQL($this->DataEnvio);
		$elemento->CodigoTipoPedidoSituacao = $this->CodigoTipoPedidoSituacao;
		$elemento->CodigoStatusPedido = $this->CodigoStatusPedido;

		return $conn_pedido->save($elemento);
	}

	//2017-01-24 Paulo Campos: Atualizar status FoiProrrogado
	public function AtualizarFoiProrrogado($FoiProrrogado){

		$conn_pedido = TableRegistry::get("Pedidos");

		$elemento = $conn_pedido->find()->where(["Codigo" => $this->Codigo])->first();

		if($elemento == null)
			return false;

		$elemento->FoiProrrogado = $FoiProrrogado;

		return $conn_pedido->save($elemento);
	}

	public function AtualizarStatus(){

		$conn_pedido = TableRegistry::get("Pedidos");

		$elemento = $conn_pedido->find()->where(["Codigo" => $this->Codigo])->first();

		if($elemento != null)
		{
			$elemento->CodigoTipoPedidoSituacao = $this->CodigoTipoPedidoSituacao;

			return $conn_pedido->save($this);
		}

		return false;
	}

	public function ListarModerados($codigoPedido = 0, $slug = "", $codigoAgente = 0, $codigoUsuario = 0, $nome = "", $codigoStatusPedido = 0, $CodigoTipoPedidoSituacao = 0, $filtro = "", $startLimit = 0, $qtd = 10, $moderar = true, $CodigoStatusModeracao=2)
	{
		$condicao = !empty($nome) ? " and (pedidos.nome like '%".$nome."%' or '".$nome."' is null) " : "";
		$condicao .= !empty($codigoPedido) && $codigoPedido > 0 ? " and (pedidos.CodigoPedido = ".$codigoPedido." or ".$codigoPedido." is null)" : "";
		$condicao .= !empty($codigoAgente) && $codigoAgente > 0 ? " and (pedidos.codigoAgente = ".$codigoAgente." or ".$codigoAgente." is null)" : "";
		$condicao .= !empty($codigoUsuario) && $codigoUsuario > 0 ? " and (pedidos.codigoUsuario = ".$codigoUsuario." or ".$codigoUsuario." is null)" : "";
		$condicao .= !empty($codigoStatusPedido) && $codigoStatusPedido > 0 ? " and (pedidos.codigoStatusPedido = ".$codigoStatusPedido." or ".$codigoStatusPedido." is null)" : "";
		$condicao .= !empty($CodigoTipoPedidoSituacao) && $CodigoTipoPedidoSituacao > 0 ? " and (pedidos.CodigoTipoPedidoSituacao = ".$CodigoTipoPedidoSituacao." or ".$CodigoTipoPedidoSituacao." is null)" : "";
		$condicao .= !empty($slug) && strlen($slug) > 0 ? " and (pedidos.Slug = '". $slug ."' Or '".$slug."' is null) " : "";
		$limite = "";
		if($qtd > 0)
			$limite = " limit " . $startLimit . "," . $qtd;

		$connection = ConnectionManager::get('default');

		if($moderar){
			$query = 'select distinct pedidos.Codigo, pedidos.Slug, pedidos.CodigoUsuario,pedidos.CodigoAgente,pedidos.CodigoTipoOrigem,pedidos.CodigoTipoPedidoSituacao,pedidos.CodigoStatusPedido,pedidos.CodigoStatusPedidoInterno,pedidos.IdentificadorExterno,pedidos.Protocolo,pedidos.Titulo,pedidos.Descricao,pedidos.DataEnvio,pedidos.FoiProrrogado,pedidos.Anonimo,pedidos.Criacao,pedidos.Alteracao, stat.Nome StatusPedido, statInterno.Nome StatusInternoPedido, agente.Nome NomeAgente, agente.Slug SlugAgente, usuario.Nome NomeUsuario, usuario.Slug SlugUsuario, tipoSit.Nome NomeSituacao, cidade.Nome NomeCidade, uf.Sigla SiglaUF, nfed.Nome NomeNivelFederativo from
			pedidos pedidos
			join moderacoes b on pedidos.Codigo = b.CodigoObjeto and b.CodigoTipoObjeto = 1
            join status_pedido	stat on pedidos.CodigoStatusPedido = stat.Codigo
            join status_pedido statInterno on pedidos.CodigoStatusPedidoInterno = statInterno.Codigo
            join tipo_pedido_situacao tipoSit on pedidos.CodigoTipoPedidoSituacao = tipoSit.Codigo
			join agentes agente on pedidos.CodigoAgente = agente.Codigo
			left join cidade cidade on agente.CodigoCidade = cidade.Codigo
			left join uf uf on agente.CodigoUF = uf.Codigo
			join tipo_nivel_federativo nfed on nfed.Codigo = agente.CodigoNivelFederativo
            join usuarios usuario on pedidos.CodigoUsuario = usuario.Codigo
            where	b.CodigoStatusModeracao = '.$CodigoStatusModeracao.' and agente.Ativo = 1 and pedidos.Ativo = 1 ' . $condicao . $filtro . ' order by pedidos.Criacao DESC' .$limite;
        }
        else{
        	$query = 'select distinct pedidos.Codigo, pedidos.Slug, pedidos.CodigoUsuario,pedidos.CodigoAgente,pedidos.CodigoTipoOrigem,pedidos.CodigoTipoPedidoSituacao,pedidos.CodigoStatusPedido,pedidos.CodigoStatusPedidoInterno,pedidos.IdentificadorExterno,pedidos.Protocolo,pedidos.Titulo,pedidos.Descricao,pedidos.DataEnvio,pedidos.FoiProrrogado,pedidos.Anonimo,pedidos.Criacao,pedidos.Alteracao, stat.Nome StatusPedido, statInterno.Nome StatusInternoPedido, agente.Nome NomeAgente, agente.Slug SlugAgente, usuario.Nome NomeUsuario, usuario.Slug SlugUsuario, tipoSit.Nome NomeSituacao, cidade.Nome NomeCidade, uf.Sigla SiglaUF, nfed.Nome NomeNivelFederativo from
			pedidos pedidos
            join status_pedido	stat on pedidos.CodigoStatusPedido = stat.Codigo
            join status_pedido statInterno on pedidos.CodigoStatusPedidoInterno = statInterno.Codigo
            join tipo_pedido_situacao tipoSit on pedidos.CodigoTipoPedidoSituacao = tipoSit.Codigo
			join agentes agente on pedidos.CodigoAgente = agente.Codigo
			left join cidade cidade on agente.CodigoCidade = cidade.Codigo
			left join uf uf on agente.CodigoUF = uf.Codigo
			join tipo_nivel_federativo nfed on nfed.Codigo = agente.CodigoNivelFederativo
            join usuarios usuario on pedidos.CodigoUsuario = usuario.Codigo
            where agente.Ativo = 1 and pedidos.Ativo = 1 ' . $condicao . $filtro . ' order by pedidos.Criacao DESC' .$limite;
            //2017-01-16 Paulo Campos: adicionado DESC no order by pedidos.criacao
        }
        //debug($query);die();
		$results = $connection->execute($query)->fetchAll('assoc');

    	return $results;
	}

	public function TotalPedidosModerados($filtro = "", $moderar = true,$CodigoStatusModeracao=2){
		$connection = ConnectionManager::get('default');

		if(!$moderar){
			$query = 'select count(distinct pedidos.Codigo) Total from
			pedidos pedidos join status_pedido	stat on pedidos.CodigoStatusPedido = stat.Codigo
            join status_pedido statInterno on pedidos.CodigoStatusPedidoInterno = statInterno.Codigo
            join agentes agente on pedidos.CodigoAgente = agente.Codigo
            join usuarios usuario on pedidos.CodigoUsuario = usuario.Codigo
            where pedidos.Ativo = 1 ' . $filtro;
		}else{
			$query = 'select count(distinct pedidos.Codigo) Total from
			pedidos pedidos join  moderacoes b on pedidos.Codigo = b.CodigoObjeto and b.CodigoTipoObjeto = 1
            join status_pedido	stat on pedidos.CodigoStatusPedido = stat.Codigo
            join status_pedido statInterno on pedidos.CodigoStatusPedidoInterno = statInterno.Codigo
            join agentes agente on pedidos.CodigoAgente = agente.Codigo
            join usuarios usuario on pedidos.CodigoUsuario = usuario.Codigo
            where	b.CodigoStatusModeracao = '.$CodigoStatusModeracao.' and pedidos.Ativo = 1 ' . $filtro;
        }
        //debug($query);die();
		$results = $connection
    		->execute($query)->fetchAll('assoc');

    	return $results[0]["Total"];
	}

	public function TotalPorUsuario($moderar=true,$CodigoStatusModeracao=2){

		if($this->CodigoUsuario <= 0)
			return 0;

		$filtro = " and (pedidos.CodigoUsuario = " . $this->CodigoUsuario . " )";

		return $this->TotalPedidosModerados($filtro,$moderar,$CodigoStatusModeracao);
	}

	public function TotalPorAgente($moderar=true){

		$filtro = " and (pedidos.CodigoAgente = " . $this->CodigoAgente . " )";

		return $this->TotalPedidosModerados($filtro,$moderar);
	}

	public function FiltrarPedidos($data, $pagina = 1, $qtd = 10, $fixaDestaquesHome="")
	{

        $dataInicial = "";
        $dataFinal = "";
        $codigoTipoPedidoSituacao = "";
        $codigoStatusPedido = "";
        $codigoPoder = "";
        $codigoNivelFederativo = "";
        $recurso = "";

        $filtro = "";

        if(array_key_exists("dataInicial", $data) && strlen($data["dataInicial"]) > 0){
        	$dataInicial = UDataComponent::ConverterMySQL($data["dataInicial"]);
        	$filtro = " and (pedidos.Criacao >= '" . $dataInicial . "') ";
        }

        if(array_key_exists("dataFinal", $data) && strlen($data["dataFinal"]) > 0){
        	$dataFinal = UDataComponent::ConverterMySQL($data["dataFinal"]);
        	$filtro .= " and (pedidos.Criacao <= '" . $dataFinal . "') ";
        }

        if(array_key_exists("codigoStatusPedido", $data)){
        	$codigoStatusPedido = UNumeroComponent::ValidarSequencia($data["codigoStatusPedido"]);
        	if(strlen($codigoStatusPedido) > 0)
        		$filtro .= " and codigoStatusPedido in (" . $codigoStatusPedido . ")";
        }

		if(array_key_exists("codigoTipoPedidoSituacao", $data)){
        	$codigoTipoPedidoSituacao = UNumeroComponent::ValidarSequencia($data["codigoTipoPedidoSituacao"]);
        	if(strlen($codigoTipoPedidoSituacao) > 0)
        		$filtro .= " and codigoTipoPedidoSituacao in (" . $codigoTipoPedidoSituacao . ")";
        }

		if(array_key_exists("codigoNivelFederativo", $data)){
        	$codigoNivelFederativo = UNumeroComponent::ValidarSequencia($data["codigoNivelFederativo"]);
        	if(strlen($codigoNivelFederativo) > 0)
        		$filtro .= " and codigoNivelFederativo in (" . $codigoNivelFederativo . ")";
        }

		if(array_key_exists("codigoPoder", $data)){
        	$codigoPoder = UNumeroComponent::ValidarSequencia($data["codigoPoder"]);
        	if(strlen($codigoPoder) > 0)
        		$filtro .= " and codigoPoder in (" . $codigoPoder . ")";
        }

        if(array_key_exists("textoBusca", $data) == true){
        	$textoBusca = $data["textoBusca"];
        	if(strlen($textoBusca) > 5)
        		$filtro .= " and (pedidos.Titulo like '%" . $textoBusca . "%' or pedidos.Descricao like '%" . $textoBusca . "%' or pedidos.slug like '%". $textoBusca. "%')";
        }

        if(array_key_exists("recurso", $data) == true && !UStringComponent::VazioOuNulo($data["recurso"])){
        	$recurso = UNumeroComponent::ValidarSequencia($data["recurso"]);
        }

        if (!empty($fixaDestaquesHome)) {
        	$filtro .= " and pedidos.Codigo in (".$fixaDestaquesHome.")";
        }

        $start = ($pagina - 1) * $qtd;

        return $this->ListarModerados(0,"",0,0,"",0,0, $filtro, $start, $qtd);
	}

	public function ListarPorSlug($moderar = true){

		$elementos = $this->ListarModerados(0, $this->Slug, 0, 0, "", 0, 0, "", 0, 10, $moderar);

		if(count($elementos) > 0){
			return $elementos[0];
		}

		return null;
	}

	public function GetCodigoBySlug(){

		$conn_pedido = TableRegistry::get("Pedidos");

		$elemento = $conn_pedido->find()->where(["Slug" => $this->Slug])->first();

		if($elemento != null){
			return $elemento->Codigo;
		}

		return 0;
	}

	//2017-01-24 Paulo Campos: Verifica se já existe um slug igual na base e gera unicidade
	//Garante integridade
	public function validaSlugUnico($slug){

		$conn_pedido = TableRegistry::get("Pedidos");

		$elemento = $conn_pedido->find()->where("Pedidos.Slug LIKE '%$slug%'")->order("Pedidos.Codigo DESC")->first();

		if($elemento != null){
			return $elemento->Codigo;
		}

		return 0;
	}

	public function PedidoPertenceACliente(){

		$conn_pedido = TableRegistry::get("Pedidos");

		$elemento = $conn_pedido->find()->where(["Codigo" => $this->Codigo, "CodigoUsuario" => $this->CodigoUsuario])->first();

		if($elemento == null)
		{
			return false;
		}

		return true;
	}

	public function AtualizarPedidosUsuarioExcluido($codigoUsuario)
	{
		$connection = ConnectionManager::get('default');

		$results = $connection
			->update('pedidos',['Anonimo' => 1, 'Alteracao' => 'current_timestamp'], ["CodigoUsuario" => $codigoUsuario]);
	}
	//2017-01-23 Paulo Campos: Mudança de nome do metodo
	public function PedidoDataEnvio()
	//public function PedidoAtrasado()
	{
		$dataEnvio = "";
		$pedido = $this->ListarUnico($this->Codigo, null);

		if($pedido != null && $pedido->FoiProrrogado == 0){
			$dataEnvio = date_format(date_create($pedido->DataEnvio), 'Y-m-d');
			//$dataEnvio = date_create($pedido->DataEnvio);

			//2017-01-23 Paulo Campos: Comentei. A formulá para verificar um pedido atrasado é ver se a data da resposta passou dos 20 dias da data do pedido.
			//A formula está sendo calculada em um javascript no template Minhaconta/Pedidos/pedidointeracao.ctp
			// $data2 = date_create(date("Y/m/d"));

			// $interval = date_diff($data1, $data2);
			// $dias = $interval->days;
			// return $dias > 20;
		}

		return $dataEnvio;
	}

	public function PedidoProrrogado()
	{
		$pedido = $this->ListarUnico($this->Codigo, null);

		if($pedido != null){
			$pedido->FoiProrrogado = 1;
			return $pedido->AtualizarFoiProrrogado($pedido->FoiProrrogado);
		}

		return false;
	}


	//2017-02-05 Paulo Campos: colocando join de moderacao da query
	//2017-01-24 Paulo Campos: tirando join de moderacao da query
	public function RelatorioTotal(){
		$connection = ConnectionManager::get('default');

		$query = 'select distinct
					count(pedido.Codigo) Total,
					sum(if(pedido.CodigoStatusPedido = 1, 1, 0)) TotalAtendidos,
					sum(if(pedido.CodigoStatusPedido = 2, 1, 0)) TotalNaoAtendidos
				from
					pedidos pedido join
					moderacoes m on pedido.Codigo = m.CodigoObjeto
					and m.CodigoTipoObjeto = 1 and m.CodigoStatusModeracao = 2
				';

			// $query = 'select distinct
			// 		count(pedido.Codigo) Total,
			// 		sum(if(pedido.CodigoStatusPedido = 1, 1, 0)) TotalAtendidos,
			// 		sum(if(pedido.CodigoStatusPedido = 2, 1, 0)) TotalNaoAtendidos
			// 	from
			// 		pedidos pedido
			// 	';

		$results = $connection->execute($query)->fetchAll('assoc');

    	return $results[0];
	}

	//2017-02-05 Paulo Campos: colocando join de moderacao da query
	//2017-01-24 Paulo Campos: tirando join de moderacao da query
	public function RelatorioPorEstado()
	{
		$connection = ConnectionManager::get('default');

		//2017-03-09 Paulo Campos: Tirei o Join da cidade e fiz o join direto com Agente.CodigoUF
		$query = 'select distinct
					uf.Codigo,
					uf.Nome,
				    uf.Sigla,
				    count(pedido.Codigo) Total,
				    sum(if(pedido.CodigoStatusPedido = 1, 1, 0)) TotalAtendidos,
				    sum(if(pedido.CodigoStatusPedido = 2, 1, 0)) TotalNaoAtendidos
				from
					pedidos pedido join
				    agentes agente on pedido.CodigoAgente = agente.Codigo join
				    uf on uf.Codigo = agente.CodigoUF join
				    moderacoes m on pedido.Codigo = m.CodigoObjeto
				    and m.CodigoTipoObjeto = 1 and m.CodigoStatusModeracao = 2
				group by uf.Sigla ORDER BY Total Desc';

		// $query = 'select distinct
		// 			uf.Codigo,
		// 			uf.Nome,
		// 		    uf.Sigla,
		// 		    count(pedido.Codigo) Total,
		// 		    sum(if(pedido.CodigoStatusPedido = 1, 1, 0)) TotalAtendidos,
		// 		    sum(if(pedido.CodigoStatusPedido = 2, 1, 0)) TotalNaoAtendidos
		// 		from
		// 			pedidos pedido join
		// 		    agentes agente on pedido.CodigoAgente = agente.Codigo join
		// 		    cidade cidade on agente.CodigoCidade = cidade.Codigo join
		// 		    uf on uf.Codigo = cidade.CodigoUF join
		// 		    moderacoes m on pedido.Codigo = m.CodigoObjeto
		// 		    and m.CodigoTipoObjeto = 1 and m.CodigoStatusModeracao = 2
		// 		group by uf.Sigla';

		// $query = 'select distinct
		// 			uf.Codigo,
		// 			uf.Nome,
		// 		    uf.Sigla,
		// 		    count(pedido.Codigo) Total,
		// 		    sum(if(pedido.CodigoStatusPedido = 1, 1, 0)) TotalAtendidos,
		// 		    sum(if(pedido.CodigoStatusPedido = 2, 1, 0)) TotalNaoAtendidos
		// 		from
		// 			pedidos pedido join
		// 		    agentes agente on pedido.CodigoAgente = agente.Codigo join
		// 		    cidade cidade on agente.CodigoCidade = cidade.Codigo join
		// 		    uf uf on uf.Codigo = cidade.CodigoUF
		// 		group by uf.Sigla';

		$results = $connection->execute($query)->fetchAll('assoc');

    	return $results;
	}
	//2017-02-05 Paulo Campos: colocando join de moderacao da query
	//2017-01-24 Paulo Campos: tirando join de moderacao da query
	public function RelatorioPorAgente($tipo = 1)
	{
		$connection = ConnectionManager::get('default');
		$totalMinimo = 100;
		$filtro = ' order by PorcentagemAtendido desc ';
		if($tipo == 2)
			$filtro = ' order by PorcentagemNaoAtendido desc ';

		$query = 'Select
					agente.Nome, cidade.Nome cidade, uf.Sigla uf,
				    sum(if(pedido.CodigoStatusPedido = 1, 1, 0)) TotalAtendidos,
					sum(if(pedido.CodigoStatusPedido = 2, 1, 0)) TotalNaoAtendidos,
					sum(if(pedido.CodigoStatusPedido = 1, 1, 0))/count(pedido.Codigo) as PorcentagemAtendido,
					sum(if(pedido.CodigoStatusPedido = 2, 1, 0))/count(pedido.Codigo) as PorcentagemNaoAtendido,
				    count(pedido.Codigo) Total
				from
					agentes agente join
				    pedidos pedido on agente.Codigo = pedido.CodigoAgente join
				    moderacoes m on pedido.Codigo = m.CodigoObjeto
				    and m.CodigoTipoObjeto = 1 and m.CodigoStatusModeracao = 2
					left join cidade cidade on cidade.Codigo = agente.CodigoCidade
					left join uf uf on uf.Codigo = agente.CodigoUF
				group by agente.Nome, cidade.Nome, uf.sigla
				having Total > ' . $totalMinimo . '
				' . $filtro . '
				limit 0,5';

		// $query = 'Select
		// 			agente.Nome,
		// 		    sum(if(pedido.CodigoStatusPedido = 1, 1, 0)) TotalAtendidos,
		// 		    sum(if(pedido.CodigoStatusPedido = 2, 1, 0)) TotalNaoAtendidos,
		// 		    count(pedido.Codigo) Total
		// 		from
		// 			agentes agente join
		// 		    pedidos pedido on agente.Codigo = pedido.CodigoAgente
		// 		group by agente.Nome
		// 		having Total > 0
		// 		' . $filtro . '
		// 		limit 0,5';

		$results = $connection->execute($query)->fetchAll('assoc');

    	return $results;
	}

	/*
	FUNÇÕES DO ELASTIC SEARCH
	*/
	public function ES_InserirAtualizarPedidos($codigoPedido = null, $nomeTipoResposta = "", $codigoTipoResposta = "")
	{
        Log::info("[TASK] Iniciando Indexação dos Pedidos ...");

        TaskEnvHelper::getInstance()->setProgress("Iniciando a Indexação dos Pedidos", 0);

		$connection = ConnectionManager::get('default');
		$filtro = "";

		if($codigoPedido != null)
			$filtro = ' and a.Codigo = ' . $codigoPedido;
		else
			$filtro = ' and b.Codigo is null ';

		// 2017-01-17 Paulo Campos - Comentado. Tirei o Join de moderacao
		// $query = 'Select
		// 	a.Codigo pedidos_codigo,
		// 	case when b.Codigo is null Then 0 Else 1 end JaEnviado,
		//     a.CodigoUsuario usuarios_codigo,
		//     d.Codigo agentes_codigo_local,
		//     c.Nome usuarios_nome,
		//     d.Nome agentes_nome_local,
		//     c.Email usuarios_email_local,
		//     a.CodigoStatusPedido status_pedido_codigo_local,
		//     a.CodigoStatusPedidoInterno status_pedido_interno_codigo_local,
		//     e.Nome status_pedido_nome_local,
		//     f.Nome status_pedido_interno_nome_local,
		//     a.CodigoTipoPedidoSituacao tipo_pedido_situacao_codigo_local,
		//     g.Nome tipo_pedido_situacao_nome_local,
		//     h.Nome tipo_pedido_origem_nome,
		//     tp.Codigo tipo_poder_codigo_local,
		//     tp.Nome tipo_poder_nome_local,
		//     tnf.Codigo tipo_nivel_federativo_codigo_local,
		//     tnf.Nome tipo_nivel_federativo_nome_local,
		//     a.Protocolo pedidos_protocolo_local,
		//     a.Titulo pedidos_titulo_local,
		//     a.Slug pedidos_slug_local,
		//     a.Descricao pedidos_descricao_local,
		//     a.FoiProrrogado pedidos_foi_prorrogado_local,
		//     a.Anonimo pedidos_anonimo_local,
		//     DATE_FORMAT(a.DataEnvio,"%Y-%m-%d") pedidos_data_envio_local,
		//     "" pedidos_enviado_para_local
		// from
		// 	pedidos a left join
		// 	es_pedidos b on a.Codigo = b.CodigoPedido join
		//     usuarios c on a.CodigoUsuario = c.Codigo join
		//     agentes d on d.Codigo = a.CodigoAgente join
		//     status_pedido e on a.CodigoStatusPedido = e.Codigo join
		//     status_pedido f on a.CodigoStatusPedidoInterno = f.Codigo join
		//     tipo_pedido_situacao g on g.Codigo = a.CodigoTipoPedidoSituacao join
		//     tipo_pedido_origem h on a.CodigoTipoOrigem = h.Codigo join
		//     tipo_poder tp on tp.Codigo = d.CodigoPoder join
		//     tipo_nivel_federativo tnf on tnf.Codigo = d.CodigoNivelFederativo join
		//     moderacoes modera on modera.CodigoObjeto = a.Codigo and modera.CodigoTipoObjeto = 1 and modera.CodigoStatusModeracao = 2
		// where
		// 	a.Ativo = 1 ' . $filtro;

		//2017-01-24 Paulo Campos: Mudança no label c.Nome usuarios_nome para c.Nome usuarios_nome_local, a.CodigoUsuario usuarios_codigo para a.CodigoUsuario usuarios_codigo_local e h.Nome tipo_pedido_origem_nome para h.Nome tipo_pedido_origem_nome_local
		$query = 'Select
			a.Codigo pedidos_codigo,
			case when b.Codigo is null Then 0 Else 1 end JaEnviado,
		    a.CodigoUsuario usuarios_codigo_local,
		    d.Codigo agentes_codigo_local,
		    c.Nome usuarios_nome_local,
		    c.Slug usuarios_slug_local,
		    d.Nome agentes_nome_local,
		    d.Slug agentes_slug_local,
		    c.Email usuarios_email_local,
		    a.CodigoStatusPedido status_pedido_codigo_local,
		    a.CodigoStatusPedidoInterno status_pedido_interno_codigo_local,
		    e.Nome status_pedido_nome_local,
		    f.Nome status_pedido_interno_nome_local,
		    a.CodigoTipoPedidoSituacao tipo_pedido_situacao_codigo_local,
		    g.Nome tipo_pedido_situacao_nome_local,
		    h.Nome tipo_pedido_origem_nome_local,
		    tp.Codigo tipo_poder_codigo_local,
		    tp.Nome tipo_poder_nome_local,
		    tnf.Codigo tipo_nivel_federativo_codigo_local,
		    tnf.Nome tipo_nivel_federativo_nome_local,
		    a.Protocolo pedidos_protocolo_local,
		    a.Titulo pedidos_titulo_local,
		    a.Slug pedidos_slug_local,
		    a.Descricao pedidos_descricao_local,
		    a.FoiProrrogado pedidos_foi_prorrogado_local,
		    a.Anonimo pedidos_anonimo_local,
		    DATE_FORMAT(a.DataEnvio,"%Y-%m-%d") pedidos_data_envio_local,
		    "" pedidos_enviado_para_local
		from
			pedidos a left join
			es_pedidos b on a.Codigo = b.CodigoPedido join
		    usuarios c on a.CodigoUsuario = c.Codigo join
		    agentes d on d.Codigo = a.CodigoAgente join
		    status_pedido e on a.CodigoStatusPedido = e.Codigo join
		    status_pedido f on a.CodigoStatusPedidoInterno = f.Codigo join
		    tipo_pedido_situacao g on g.Codigo = a.CodigoTipoPedidoSituacao join
		    tipo_pedido_origem h on a.CodigoTipoOrigem = h.Codigo join
		    tipo_poder tp on tp.Codigo = d.CodigoPoder join
		    tipo_nivel_federativo tnf on tnf.Codigo = d.CodigoNivelFederativo join
		    moderacoes modera on modera.CodigoObjeto = a.Codigo and modera.CodigoTipoObjeto = 1 and modera.CodigoStatusModeracao = 2
		where
			a.Ativo = 1' . $filtro;

		// debug($query);
		// die();
        Log::info("[TASK] Pesquisando ...");
        TaskEnvHelper::getInstance()->setProgress("Pesquisando", 1);
		try{
            $cntPedidos = $this->ES_TotalPedidosPendentesImportacao($codigoPedido);
            if($cntPedidos > 0) {
                Log::info("[TASK] Total para indexar: " . $cntPedidos);
                $cntPedidosPerPage = 100;
                $cntPedidosPages = ceil($cntPedidos / $cntPedidosPerPage);

                for ($iPage=0; $iPage < $cntPedidosPages ; $iPage++) {
                    TaskEnvHelper::getInstance()->setProgressFrom("Lote: $iPage", $iPage, $cntPedidosPages);
                    Log::info("[TASK] Página: $iPage");
                    $pageStart = $iPage * $cntPedidosPerPage;
                    $queryPaged = $query . " LIMIT $pageStart, $cntPedidosPerPage";

                    Log::info("[TASK] LIMIT $pageStart, $cntPedidosPerPage");

                    $results = $connection->execute($queryPaged)->fetchAll('assoc');
                    if(count($results) > 0) {
                        foreach($results as $item){

                            $codigoPedido = $item["pedidos_codigo"];
                            $json = json_encode($item);
                            $url = ES_URL . 'pedidos/gravar/' . $codigoPedido;

                            TaskEnvHelper::getInstance()->setProgressFrom("Importando: $codigoPedido", $iPage, $cntPedidosPages);
                            Log::info("[TASK] Indexando: " . $codigoPedido);
                            //echo "ES URL = " . $url;

                            $retorno = UCurlComponent::enviarDadosJson($url, $json, "PUT");
                            //echo $retorno;
                            if($retorno !== false)
                            {
                                $retornoJson = json_decode($retorno);
                                //debug($retornoJson);
                                //die();
                                // echo $retorno;
                                if((isset($retornoJson->success)) and ($retornoJson->success != null)){
                                    // atualiza pra cada item no banco local
                                    $this->ES_InserirAtualizarLocalmente($codigoPedido);
                                }
                            }
                        }
                    }
                }
            }
		} catch(\Exception $ex)
		{
			// logar erro no banco
			$url = $_SERVER['REQUEST_URI'];
			$variaveis = "Erro ao enviar pedido ao elastic search:" . (is_null($codigoPedido) ? "0" : $codigoPedido);
			UStringComponent::registrarErro($url, $ex, $variaveis);
		}

        TaskEnvHelper::getInstance()->setProgress("Concluido", 100);
	}

	public function ES_TotalPedidosPendentesImportacao($codigoPedido = null)
	{
		$connection = ConnectionManager::get('default');
		if($codigoPedido != null)
			$filtro = ' es_pedidos.CodigoPedido is null AND pedidos.Codigo = ' . $codigoPedido;
		else
			$filtro = ' es_pedidos.CodigoPedido is null ';

		$query = 'SELECT COUNT(*) as TotalPendenteES FROM pedidos LEFT JOIN es_pedidos ON pedidos.Codigo = es_pedidos.CodigoPedido WHERE ' . $filtro . ' AND pedidos.CodigoTipoOrigem IN (1,2,3);';

		$results = $connection->execute($query)->fetchAll('assoc');

		if (!empty($results))
			return $results[0]["TotalPendenteES"];

		return 0;
	}

	public function ES_TotalPedidosInteracoesPendentesImportacao()
	{
		$connection = ConnectionManager::get('default');
		$query = 'SELECT COUNT(*) as TotalPendenteES FROM pedidos_interacoes JOIN pedidos ON pedidos_interacoes.CodigoPedido = pedidos.Codigo LEFT JOIN es_pedidos_interacoes ON pedidos_interacoes.Codigo = es_pedidos_interacoes.CodigoPedidoInteracao WHERE es_pedidos_interacoes.CodigoPedidoInteracao IS NULL AND pedidos.CodigoTipoOrigem IN (1,2,3);';

		$results = $connection->execute($query)->fetchAll('assoc');

		if (!empty($results))
			return $results[0]["TotalPendenteES"];

		return 0;
	}


	//2017-03-09 Paulo Campos: Criado metodo
	public function ES_TotalPedidosAnexosPendentesImportacao()
	{
		$connection = ConnectionManager::get('default');
		$query = 'SELECT COUNT(*) as TotalPendenteES FROM pedidos_anexos JOIN pedidos_interacoes ON pedidos_anexos.CodigoPedidoInteracao = pedidos_interacoes.Codigo JOIN pedidos ON pedidos_interacoes.CodigoPedido = pedidos.Codigo LEFT JOIN es_pedidos_anexos ON pedidos_anexos.Codigo = es_pedidos_anexos.CodigoPedidoAnexo WHERE es_pedidos_anexos.CodigoPedidoAnexo IS NULL AND pedidos.CodigoTipoOrigem = 3 AND Arquivo NOT LIKE "%/";';

		$results = $connection->execute($query)->fetchAll('assoc');

		if (!empty($results))
			return $results[0]["TotalPendenteES"];

		return 0;
	}


	//2017-08-31 Paulo Campos: Criado metodo
	public function ES_TotalPedidosAnexosPendentesImportacaoPastas()
	{
		$connection = ConnectionManager::get('default');
		$query = 'SELECT COUNT(*) as TotalPendenteES FROM pedidos_anexos JOIN pedidos_interacoes ON pedidos_anexos.CodigoPedidoInteracao = pedidos_interacoes.Codigo JOIN pedidos ON pedidos_interacoes.CodigoPedido = pedidos.Codigo LEFT JOIN es_pedidos_anexos ON pedidos_anexos.Codigo = es_pedidos_anexos.CodigoPedidoAnexo WHERE es_pedidos_anexos.CodigoPedidoAnexo IS NULL AND pedidos.CodigoTipoOrigem IN (1,2,3); AND Arquivo LIKE "%/";';

		$results = $connection->execute($query)->fetchAll('assoc');

		if (!empty($results))
			return $results[0]["TotalPendenteES"];

		return 0;
	}



	public function ES_InserirAtualizarLocalmente($codigoPedido)
	{
		$conn_es_pedido = TableRegistry::get("EsPedidos");

		$elemento = $conn_es_pedido->find('all')->where(["CodigoPedido" => $codigoPedido])->first();

		if($elemento == null){
			$elemento = $conn_es_pedido->newEntity();
			$elemento->CodigoPedido = $codigoPedido;
		}else{
			//2016-03-8 Paulo Campos - alterado
			//$data = date_default_timezone_get();
			$data = date('Y-m-d H:i:s');
			$elemento->Alteracao = $data;
		}

		$conn_es_pedido->save($elemento);
	}

	public function ES_RemoverPedido($codigoPedido)
	{
		try{
			$url = ES_URL . 'pedidos/apagar/' . $codigoPedido;

			$retorno = UCurlComponent::enviarDadosJson($url, "", "DELETE");

			if($retorno !== false)
			{
				$retornoJson = json_decode($retorno);

				if(strpos($retorno, "error") === false){
					// atualiza pra cada item no banco local
					$this->ES_InserirAtualizarLocalmente($codigoPedido);

					// remove as interações relacionadas
					$pedidoInteracaoBU = new PedidoInteracao();
					$pedidoInteracaoBU->ES_RemoverInteracaoPorPedido($codigoPedido);
				}
			}
		}catch(Exception $ex)
		{
			// logar erro no banco
			$url = $_SERVER['REQUEST_URI'];
			$variaveis = "Erro ao remover pedido do elastic search:" . (is_null($codigoPedido) ? "0" : $codigoPedido);
			UStringComponent::registrarErro($url, $ex, $variaveis);
		}
	}

}

?>
