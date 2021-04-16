<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class Documento extends Entity{
	
	public static function ListarCodigoDocumento($valor)
	{
		$conn = TableRegistry::get("Documentos");

		$documento = $conn->find()->where(["Valor" => $valor])->first();

		if($documento == null)
			return 0;

		return $documento->Codigo;
	}

	public function ListarDocumento($codigoDocumento){
		$conn = TableRegistry::get("Documentos");

		$elemento = $conn->find()->where(["Codigo" => $codigoDocumento])->first();

		if($elemento == null)
			return "";

		return $elemento->Valor;
	}

	public function ListarPorUsuario()
	{
		$conn = TableRegistry::get("UsuarioDocumentos");

		$usuarioDocumento = $conn->find()->where(["CodigoUsuario" => $this->CodigoUsuario, "Ativo" => 1])->first();

		if($usuarioDocumento == null)
			return "";

		return $this->ListarDocumento($usuarioDocumento->CodigoDocumento);
	}

	public static function ListarCodigoUsuarioPorDocumento($valor)
	{
		$codigoDocumento = Documento::ListarCodigoDocumento($valor);

		if($codigoDocumento == 0)
			return 0;

		$conn = TableRegistry::get("UsuarioDocumentos");

		$usuarioDocumento = $conn->find()->where(["CodigoDocumento" => $codigoDocumento, "Ativo" => 1])->first();

		if($usuarioDocumento == null)
			return 0;

		return $usuarioDocumento->CodigoUsuario;
	}
	
	public static function InserirNovoDocumento($valor, $codigoTipoDocumento){
		$conn = TableRegistry::get("Documentos");
		$codigoDocumento = Documento::ListarCodigoDocumento($valor);
		
		if($codigoDocumento == 0){
			$documento = new Documento();

			$documento->CodigoTipoDocumento = $codigoTipoDocumento;
			$documento->Valor = $valor;

			if($conn->save($documento))
				return $documento->Codigo;

			return 0; // erro
		}

		return $codigoDocumento;
	}

	public static function InserirUsuarioDocumento($codigoDocumento, $codigoUsuario)
	{
		$conn = TableRegistry::get("UsuarioDocumentos");

		$elemento = $conn->find()->where(["CodigoUsuario" => $codigoUsuario, "CodigoDocumento" => $codigoDocumento, "Ativo" => 1])->first();

		if($elemento == null){

			$usuarioDocumento = new UsuarioDocumento();

			$usuarioDocumento->CodigoUsuario = $codigoUsuario;
			$usuarioDocumento->CodigoDocumento = $codigoDocumento;
			$usuarioDocumento->Ativo = 1;

			if($conn->save($usuarioDocumento))
				return $usuarioDocumento->Codigo;

			return 0;
		}

		return $elemento->Codigo;
	}

	//2017-01-27 Paulo Campos: Criada função  para alterar CPF via Admin
	public static function AtualizaDocumento($Codigo, $valor, $codigoTipoDocumento) {
		$conn = TableRegistry::get("Documentos");

		if(!empty($Codigo)) {
			$documento = new Documento();

			$documento->Codigo = $Codigo;
			$documento->CodigoTipoDocumento = $codigoTipoDocumento;
			$documento->Valor = $valor;

			if($conn->save($documento))
				return $documento->Codigo;

			return 0; // erro
		}

		return $Codigo;
	}
}

?>