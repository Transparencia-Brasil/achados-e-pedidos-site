<?php

namespace App\Model\Entity;

use Cake\ORM\TableRegistry;

class ModeracaoElementoGenerico {
	
	public $Codigo;
	public $Nome;
	public $Descricao;
	public $NomeTipoObjeto;
	public $CodigoTipoObjeto;
	public $CodigoStatusModeracao;

	public function getElementos($listaNaoModerados)
	{
		if($listaNaoModerados == null)
			return null;

		$lista = new array();
		$contador = 0;
		foreach($listaNaoModerados as $elemento)
		{
			$lista[$contador] = PreencherObjeto($elemento->Codigo, $elemento->CodigoTipoObjeto, $elemento->CodigoStatusModeracao);
			$contador++;
		}

		return $lista;
	}

	public function PreencherObjeto($idElemento, $codigoTipo, $codigoStatusModeracao)
	{
		$elemento = new ModeracaoElementoGenerico();
		$conn = TableRegistry::get($this->TipoElemento($codigoTipo));
		$conn_tipo = TableRegistry::get("TipoObjetos");
		$objeto = $conn->find()->where(['codigo' => $idElemento])->first();

		if($objeto == null)
			return null;

		$elemento->CodigoTipoObjeto = $codigoTipo;
		$elemento->CodigoStatusModeracao = $codigoStatusModeracao;
		$elemento->NomeTipoObjeto = $conn_tipo->find()->where(['codigo' => $codigoTipo])->first()->Nome;

		switch($codigoTipo)
		{
			case 1: // Pedidos
			
				$elemento->Codigo = $objeto->Codigo;
				$elemento->Nome = $objeto->Nome;
				$elemento->Descricao = $objeto->Titulo;

				return $elemento;
			case 2: // Agentes
				$elemento->Codigo = $objeto->Codigo;
				$elemento->Nome = $objeto->Nome;
				$elemento->Descricao = $objeto->Nome;

				return $elemento;
			case 3: // Usuários
				$elemento->Codigo = $objeto->Codigo;
				$elemento->Nome = $objeto->Nome;
				$elemento->Descricao = $objeto->Email;

				return $elemento;
			case 4: // Comentários
				$elemento->Codigo = $objeto->Codigo;
				$elemento->Nome = "Comentário";
				$elemento->Descricao = $objeto->Texto;

				return $elemento;
			default: return null;
		}


	}

	public function TipoElemento($tipo)
	{
		switch($tipo)
		{
			case 1: return "Pedidos";
			case 2: return "Agentes";
			case 3: return "Usuarios";
			case 4: return "Comentarios";
			default: return "";
		}

	}
}

?>