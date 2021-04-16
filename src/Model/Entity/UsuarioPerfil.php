<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
use Cake\Auth\DefaultPasswordHasher;
use App\Controller\Component\UDataComponent;
use App\Controller\Component\UNumeroComponent;
use App\Controller\Component\UStringComponent;
use App\Model\Entity\Ocupacao;

class UsuarioPerfil extends Entity{
	
	/* valida os parâmetros para a segunda parte do cadastro */
	public function ValidarPasso2()
	{
		$arrayErros = [];
		$conn_genero = TableRegistry::get("TipoGenero");
		$conn_ocupacao = TableRegistry::get("TipoOcupacao");
		$conn_pais = TableRegistry::get("Pais");
		$conn_uf = TableRegistry::get("uf");
		$conn_cidade = TableRegistry::get("Cidade");

		$this->CodigoTipoGenero = $this->CodigoTipoGenero == 0 ? null : $this->CodigoTipoGenero;
		$this->CodigoPais = $this->CodigoPais == 0 ? null : $this->CodigoPais;
		$this->CodigoUF = strlen($this->CodigoUF) == 0 ? null : $this->CodigoUF;
		$this->CodigoCidade = $this->CodigoCidade == 0 ? null : $this->CodigoCidade;

		if(isset($this->CodigoTipoGenero)){
			$elemento = $conn_genero->find()->where(['Codigo' => $this->CodigoTipoGenero])->first();

			if($elemento == null)
				$arrayErros["Genero"] = "O gênero selecionado é invalido";
		}

		if(isset($this->Nascimento))
			$this->Nascimento = UDataComponent::ConverterMySQL($this->Nascimento);

		if(isset($this->Ocupacao))
		{
			// insere na tabela se não existir. do contrário puxa o código.
			$elemento = $conn_ocupacao->find()->where(['Nome' => strtoupper($this->Ocupacao)])->first();

			if($elemento == null)
			{
				$tipo_ocupacao = new Ocupacao();
				$tipo_ocupacao->Nome = strtoupper($this->Ocupacao);

				if($conn_ocupacao->save($tipo_ocupacao))
				{
					$this->CodigoTipoOcupacao = $tipo_ocupacao->Codigo;
				}
			}else{
				$this->CodigoTipoOcupacao = $elemento->Codigo;
			}
		}

		if(isset($this->CodigoPais) && $this->CodigoPais > 0){
			$elemento = $conn_pais->find()->where(["Codigo" => $this->CodigoPais])->first();
			if($elemento == null)
				$arrayErros["CodigoPais"] = "O país selecionado é invalido";
		}


		if(isset($this->CodigoUF) && strlen($this->CodigoUF) > 0){
			$elemento = $conn_uf->find()->where(["Sigla" => $this->CodigoUF])->first();
			if($elemento == null)
				$arrayErros["CodigoUF"] = "O estado selecionado é invalido";
			else
				$this->CodigoUF = $elemento->Codigo;
		}

		if(isset($this->CodigoCidade) && $this->CodigoCidade > 0){
			$elemento = $conn_cidade->find()->where(["Codigo" => $this->CodigoCidade])->first();
			if($elemento == null)
				$arrayErros["CodigoCidade"] = "A cidade selecionada é invalida";
		}

		return $arrayErros;
	}

	public function salvar(){
		$conn_usuario_perfil = TableRegistry::get("UsuariosPerfis");

		$perfil_atual = $conn_usuario_perfil->find()->where(["CodigoUsuario" => $this->CodigoUsuario])->first();

		if($perfil_atual != null){
			$perfil_atual->CodigoTipoOcupacao = $this->CodigoTipoOcupacao;
			$perfil_atual->CodigoTipoGenero = $this->CodigoTipoGenero;
			$perfil_atual->CodigoPais = $this->CodigoPais;
			$perfil_atual->CodigoUF = $this->CodigoUF;
			$perfil_atual->CodigoCidade = $this->CodigoCidade;
			//debug($perfil_atual);die();
			return $conn_usuario_perfil->save($perfil_atual);
		}else{
			return $conn_usuario_perfil->save($this);
		}
	}

	public function PossuiPerfil($codigoUsuario){
		$conn_usuario_perfil = TableRegistry::get("UsuariosPerfis");

		$elemento = $conn_usuario_perfil->find()->where(["CodigoUsuario" => $codigoUsuario])->first();

		return $elemento != null;
	}

	public function MudarSenha($senhaAtual, $novaSenha, $confirmarNovaSenha)
	{
		$arrayErros = [];

		$usuarioEncontrado = TableRegistry::get("Usuarios")->find()->where(["CodigoUsuario" => $this->CodigoUsuario]);

		if(!(new DefaultPasswordHasher)->check($senhaAtual, $usuarioEncontrado->Senha))
			$arrayErros["SenhaAtual"] = "Senha atual inválida.";

		//if($this->)

		if(!strcmp($novaSenha, $confirmarNovaSenha)){
			$arrayErros["ConfirmarSenha"] = "O campo \"senha\" e \"confirmar senha\" devem ser iguais";
		}

		return $arrayErros;
	}

	public function ValidarPerfilMinhaConta($data)
	{
		$conn_perfil = TableRegistry::get("UsuariosPerfis");

		/*Carrega os dados do perfil */
		$this->Ocupacao = UStringComponent::AntiXSSEmArrayComLimite($data["UsuarioPerfil"], "Ocupacao", 150);
		$this->CodigoTipoGenero = $data["UsuarioPerfil"]["CodigoTipoGenero"];
		$this->CodigoPais = $data["UsuarioPerfil"]["CodigoPais"];
		$this->CodigoUF = $data["UsuarioPerfil"]["CodigoUF"];
		$this->CodigoCidade = $data["UsuarioPerfil"]["CodigoCidade"];

		$arrayErros = [];

		$arrayErros = $this->ValidarPasso2();

		return $arrayErros;
	}

	public function AtualizarPerfil()
	{

		$conn_perfil = TableRegistry::get("UsuariosPerfis");
		$elemento = $conn_perfil->find()->where(["CodigoUsuario" => $this->CodigoUsuario])->first();
		if($elemento == null)
			return false;

		$this->Codigo = $elemento->Codigo;

		if($conn_perfil->save($this)){
			return true;
		}

		return false;
	}

	public function AtualizarPerfilPeloAdmin($perfil_post,$CodigoUsuario)
	{
		$conn_perfil = TableRegistry::get("UsuariosPerfis");
		$elemento = $conn_perfil->find()->where(["CodigoUsuario" => $this->CodigoUsuario])->first();

		if($elemento != null) {
			$this->Codigo = $elemento->Codigo;
		} else {
			$this->CodigoUsuario = $CodigoUsuario;
		}

		$this->Nascimento = UDataComponent::ConverterMySQL($perfil_post["UsuarioPerfil"]["Nascimento"]);
		$this->CodigoTipoGenero = $perfil_post["UsuarioPerfil"]["CodigoTipoGenero"];
		$this->Ocupacao = $perfil_post["UsuarioPerfil"]["Ocupacao"];
		$this->CodigoPais = $perfil_post["UsuarioPerfil"]["CodigoPais"];
		$this->CodigoUF = $this->CodigoUF;
		$this->CodigoCidade = $perfil_post["UsuarioPerfil"]["CodigoCidade"];

		if($conn_perfil->save($this)){
			return true;
		}

		return false;
	}

}

?>