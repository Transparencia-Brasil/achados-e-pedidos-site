<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
use Cake\Datasource\ConnectionManager;

class Avaliacao extends Entity{
	

	public function Validar(){

		$arrayErros = [];
		$tipoObjeto = new TipoObjeto();
		// 3 propriedades 
		if($this->CodigoUsuario <= 0){
			$arrayErros["ErroInterno"] = "Usuário não logado.";
		}

		if($tipoObjeto->ObjetoValido($this->CodigoTipoObjeto)){
			$arrayErros["ErroInterno"] = "Erro ao inserir avaliação. Tente novamente mais tarde [1].";
		}

		if($this->CodigoObjeto <= 0){
			$arrayErros["ErroInterno"] = "Erro ao inserir avaliação. Tente novamente mais tarde [2].";
		}

		return $arrayErros;
	}

	/*
	Só salva um novo elemento se não existir no banco. Cliente não pode fazer duas avaliações do mesmo elemento
	*/
	public function Salvar(){

		$conn_avaliacao = TableRegistry::get("Avaliacoes");

		$elemento = $conn_avaliacao->find()->where(["CodigoUsuario" => $this->CodigoUsuario, "CodigoTipoObjeto" => $this->CodigoTipoObjeto, "CodigoObjeto" => $this->CodigoObjeto])->first();

		if($elemento == null)
			return $conn_avaliacao->save($this);
		else{
			$elemento->Nota = $this->Nota;
			return $conn_avaliacao->save($elemento);
		}
		
		return false;
	}

	public function CalcularMediaAvaliacoes(){
		$connection = ConnectionManager::get('default');

		$query = "select avg(nota) media from avaliacoes where CodigoTipoObjeto = :CodigoTipoObjeto and CodigoObjeto = :CodigoObjeto";

		$results = $connection->execute($query, ["CodigoTipoObjeto" => $this->CodigoTipoObjeto, "CodigoObjeto" => $this->CodigoObjeto])->fetchAll('assoc');

		if($results[0]["media"] == null)
			return 0;

		return $results[0]["media"];
	}

	public function TotalAvaliacoes(){
		$connection = ConnectionManager::get('default');

		$query = "select count(codigo) total from avaliacoes where CodigoTipoObjeto = :CodigoTipoObjeto and CodigoObjeto = :CodigoObjeto";

		$results = $connection->execute($query, ["CodigoTipoObjeto" => $this->CodigoTipoObjeto, "CodigoObjeto" => $this->CodigoObjeto])->fetchAll('assoc');

		if($results[0]["total"] == null)
			return 0;

		return $results[0]["total"];
	}

	public function ListarParaAgente(){
		$this->CodigoTipoObjeto = 2;

		return $this->CalcularMediaAvaliacoes();
	}

	public function ListarParaUsuario(){
		$this->CodigoTipoObjeto = 3;

		return $this->CalcularMediaAvaliacoes();
	}
	
	public function TotalParaUsuario(){
		$this->CodigoTipoObjeto = 3;

		return $this->TotalAvaliacoes();
	}
}

?>