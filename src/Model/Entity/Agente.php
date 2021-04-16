<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
use Cake\Datasource\ConnectionManager;
use App\Controller\Component\UStringComponent;
use App\Controller\Component\UNumeroComponent;

class Agente extends Entity{

	public function Validar(){

		$arrayErros = [];
		$conn_agente = TableRegistry::get("Agentes");

		if(isset($this->CodigoPai) && $this->CodigoPai > 0){
			$elemento = $conn_agente->find()->where(["Codigo" => $this->CodigoPai])->first();

			if($elemento == null){
				$arrayErros["OrgaoSuperior"] = "O órgão superior selecionado é inválido";
			}else{
				$this->CodigoNivelFederativo = $elemento->CodigoNivelFederativo;
				$this->CodigoPoder = $elemento->CodigoPoder;
				$this->CodigoCidade = $elemento->CodigoCidade;
			}
		}

		return $arrayErros;
	}

	public function JaExiste()
	{
		$conn_agente = TableRegistry::get("Agentes");
		// pesquisa se o elemento já existe
        $elemento = $conn_agente->find()->where(["Nome" => $this->Nome, "CodigoPoder" => $this->CodigoPoder, "CodigoNivelFederativo" => $this->CodigoNivelFederativo, "CodigoPai" => $this->CodigoPai])->first();

        return $elemento;
	}

	public function Salvar()
	{
		$conn_agente = TableRegistry::get("Agentes");

		$this->CriadoExternamente = true;
		$this->Slug = substr(UStringComponent::Slugfy($this->Nome), 0, 200);

		return $conn_agente->save($this);
	}

	public function ListarPorNome($nome){
		$conn_agente = TableRegistry::get("Agentes");

		$agentes = $conn_agente->find()->where(["nome LIKE " => '%'.$nome.'%'])->andWhere(["Ativo" => 1]);

		return $agentes;
	}
	
	public function Listar(){

		$conn = TableRegistry::get("Agentes");

		$agentes = $conn->find('all')->where(["Ativo" => 1]);

		$agenteCategoria = new AgenteCategoria();
		foreach($agentes as $agente){
			$agente->Categorias = $agenteCategoria->Listar($agente->Codigo);
			$agente->TotalPedidos = $this->TotalPedidos($agente->Codigo);
			$agente->TotalSeguidores = $this->TotalSeguidores($agente->Codigo);
		}

		return $agentes;
	}

		public function ListarAdmin(){

		//$conn = TableRegistry::get("Agentes");
		$conn = ConnectionManager::get('default');
		//$agentes = $conn->find('all');

		$query = 'SELECT * FROM agentes';
		$agentes = $conn->execute($query)->fetchAll('assoc');

		//print_r($agentes);
		//die();

		return $agentes;
	}

	public function TotalPedidos($codigoAgente){

		$connection = ConnectionManager::get('default');

		$results = $connection
    		->execute("SELECT count(1) total from pedidos WHERE CodigoAgente = :codigoAgente", ['codigoAgente' => $codigoAgente])
    		->fetchAll('assoc');

    	if(count($results) == 0)
    	{
    		return 0;
    	}

    	$total = $results[0]["total"];

    	return $total;
	}

	public function TotalSeguidores($codigoAgente){

		$connection = ConnectionManager::get('default');

		$results = $connection
    		->execute("SELECT count(Codigo) total from usuarios_relacionamentos WHERE CodigoObjeto = :codigoAgente and CodigoTipoObjeto = 3", ['codigoAgente' => $codigoAgente])
    		->fetchAll('assoc');

    	if(count($results) == 0)
    	{
    		return 0;
    	}

    	$total = $results[0]["total"];

    	return $total;
	}
	

	public function ListarModerados($nome = "", $codigoPoder = 0, $codigoNivelFederativo = 0, $superior = false, $codigoCidade = 0, $slug = "", $filtro = "", $startLimit = 0, $qtd = 10){
		$connection = ConnectionManager::get('default');

		$condicao = !empty($nome) ? " and (agente.nome like '%".$nome."%' or '".$nome."' is null) " : "";
		$condicao .= !empty($codigoPoder) && $codigoPoder > 0 ? " and (agente.codigoPoder = ".$codigoPoder." or ".$codigoPoder." is null)" : "";
		$condicao .= !empty($codigoNivelFederativo) && $codigoNivelFederativo > 0 ? " (and agente.codigoNivelFederativo = ".$codigoNivelFederativo." or ".$codigoPoder." is null)" : "";
		$condicao .= !empty($codigoCidade) && $codigoCidade > 0 ? " and (agente.codigoCidade = ".$codigoCidade." or ".$codigoCidade." is null)" : "";
		$condicao .= !empty($superior) && $superior === true ? " and (agente.CodigoPai is null) " : "";
		$condicao .= !empty($slug) && strlen($slug) ? " and (agente.Slug = '". $slug ."' Or '".$slug."' is null) " : "";
		$condicao .= " and agente.Ativo = 1";

		$limite = "";
		if($qtd > 0)
			$limite = " limit " . $startLimit . "," . $qtd;

		$query = 'select
    				agente.Codigo, agente.CodigoPoder, agente.CodigoNivelFederativo, agente.CodigoPai, agente.CodigoUF, agente.CodigoCidade, agente.CriadoExternamente, agente.Nome, agente.Descricao, agente.Link, agente.Slug,
				agente.Ativo, agente.Criacao, agente.Descricao, poder.Nome NomePoder, nfed.Nome NomeNivelFederativo, cida.Nome NomeCidade, uf.Sigla SiglaUF
				from
					agentes agente join
        			moderacoes b on agente.Codigo = b.CodigoObjeto and b.CodigoTipoObjeto = 2
        			join tipo_poder poder on agente.CodigoPoder = poder.Codigo
        			join tipo_nivel_federativo nfed on nfed.Codigo = agente.CodigoNivelFederativo
        			left join cidade cida on agente.CodigoCidade = cida.Codigo
        			left join uf uf on agente.CodigoUF = uf.Codigo
        			where	b.CodigoStatusModeracao = 2' . $condicao . $filtro . ' order by agente.Nome ' .$limite;
        //die(debug($query));
		$results = $connection
    		->execute($query)->fetchAll('assoc');

    	return $results;
	}

	public function FiltrarAgentes($data, $pagina = 0, $qtd = 10)
	{
		$codigoPoder = "";
        $codigoNivelFederativo = "";
        $filtro = "";

        if(array_key_exists("codigoNivelFederativo", $data)){
        	$codigoNivelFederativo = UNumeroComponent::ValidarSequencia($data["codigoNivelFederativo"]);
        	if(strlen($codigoNivelFederativo) > 0)
        		$filtro .= " and codigoNivelFederativo in (" . $codigoNivelFederativo . ")";
        }

        if(array_key_exists("codigoPoder",$data)){
        	$codigoPoder = UNumeroComponent::ValidarSequencia($data["codigoPoder"]);
        	if(strlen($codigoPoder) > 0)
        		$filtro .= " and codigoPoder in (" . $codigoPoder . ")";
        }

        if(array_key_exists("textoBusca", $data) == true){
        	$textoBusca = $data["textoBusca"];
        	if(strlen($textoBusca) > 1)
        		$filtro .= " and (agente.Nome like '%" . $textoBusca . "%' or agente.Descricao like '%" . $textoBusca . "%' or agente.slug like '%". $textoBusca. "%')";
        }

        $filtro .= " and agente.Ativo = 1";

        $start = ($pagina - 1) * $qtd;

        return $this->ListarModerados("",0,0,false,0,"", $filtro, $start, $qtd);
	}

	public function ListarPorSlug($slug){
		if($slug == null || empty($slug)){
			return null;
		}

		$elementos = $this->ListarModerados("", 0, 0, false, 0, $slug);

		if(count($elementos) > 0){
			return $elementos[0];
		}

		return null;
	}

	public function GetCodigoBySlug(){

		$conn_pedido = TableRegistry::get("Agentes");

		$elemento = $conn_pedido->find()->where(["Slug" => $this->Slug])->first();

		if($elemento != null){
			return $elemento->Codigo;
		}

		return 0;
	}

	public function GetByCodigo()
	{
		$conn_pedido = TableRegistry::get("Agentes");

		$elemento = $conn_pedido->find()->where(["Codigo" => $this->Codigo])->first();

		return $elemento;
	}

}

?>
