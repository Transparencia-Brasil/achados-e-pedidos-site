<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
use Cake\Datasource\ConnectionManager;

class Comentario extends Entity{
	
	public function Validar(){
		$arrayErros = [];
		$objeto = new TipoObjeto();

		if(strlen($this->Texto) == 0)
		{
			$arrayErros["Texto"] = "Texto inválido.";
		}

		if($this->CodigoUsuario <= 0){
			$arrayErros["Texto"] = "Usuário não logado. Por favor, efetue login para inserir o comentário.";
		}

		if($objeto->ObjetoValido($this->Codigo)){
			$arrayErros["Texto"] = "Erro interno. Por favor, tente novamente mais tarde.";	
		}

		return $arrayErros;
	}

	public function Salvar(){

		$conn_comentarios = TableRegistry::get("Comentarios");

		return $conn_comentarios->save($this);
	}

	public 	function ListarComentarios()
	{
		$connection = ConnectionManager::get('default');

		$query = "select distinct
					comentario.Codigo,
					comentario.CodigoUsuario, 
					comentario.CodigoTipoObjeto, 
					comentario.CodigoObjeto, 
					comentario.Ativo, 
					comentario.Texto,
					usuario.Nome NomeUsuario,
					comentario.Criacao
				from
					comentarios comentario join
					moderacoes moderacao on 
					moderacao.CodigoTipoObjeto = 4 and comentario.Codigo = moderacao.CodigoObjeto join
					usuarios usuario on comentario.CodigoUsuario = usuario.Codigo
				where
					CodigoStatusModeracao = 2 
					and comentario.CodigoObjeto = :CodigoObjeto 
					and comentario.CodigoTipoObjeto = :CodigoTipoObjeto";
		
		$results = $connection->execute($query, ["CodigoTipoObjeto" => $this->CodigoTipoObjeto, "CodigoObjeto" => $this->CodigoObjeto])->fetchAll('assoc');

		return $results;
	}

	public function ListarPorAgente(){
		$this->CodigoTipoObjeto = 2;

		return $this->ListarComentarios();
	}

	public function ListarPorPedido(){
		$this->CodigoTipoObjeto = 1;

		return $this->ListarComentarios();
	}
}

?>