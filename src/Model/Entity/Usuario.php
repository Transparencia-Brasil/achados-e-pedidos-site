<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
use Cake\Core\App;
use App\Controller\Component\UStringComponent;
use App\Controller\Component\UNumeroComponent;
use App\Controller\Component\UEmailComponent;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\ConnectionManager;
use App\Model\Entity\UsuarioRelacionamento;
use App\Model\Entity\Pedido;

class Usuario extends Entity{
	
	public $key = 'wt1U5MACWJFTXGenFoZoiLwQGrLgdbHA';

	public function Usuario(){
		
	}

	public function JaExiste(){

		$arrayErros = [];
		$conn = TableRegistry::get("Usuarios");

		$documento = UNumeroComponent::SomenteNumeros($this->Documento);
		$codigoUsuarioDocumento = Documento::ListarCodigoUsuarioPorDocumento($documento);

		if($codigoUsuarioDocumento > 0){
			$arrayErros["Documento"] = "Documento já cadastrado no sistema";
		}

		$usuarioCPF = $conn->find()->where(["email" => $this->Email])->first();

		if($usuarioCPF != null){
			$arrayErros["Email"] = "E-mail já cadastrado no sistema";
		}

		return $arrayErros;
	}

	//2017-01-27 Paulo Campos: criado metodo
	public function JaExisteViaAdmin($valida_doc,$valida_email){

		$arrayErros = [];
		$conn = TableRegistry::get("Usuarios");
		if ($valida_doc) {
			$documento = UNumeroComponent::SomenteNumeros($valida_doc);
			$codigoUsuarioDocumento = Documento::ListarCodigoUsuarioPorDocumento($documento);

			if($codigoUsuarioDocumento > 0){
				$arrayErros["Documento"] = "Documento já cadastrado no sistema";
			}
		}

		if ($valida_email) {
			$usuarioCPF = $conn->find()->where(["email" => $valida_email])->first();

			if($usuarioCPF != null){
				$arrayErros["Email"] = "E-mail já cadastrado no sistema";
			}
		}

		return $arrayErros;
	}

	// 2017-01-26 Paulo Campos: criado metodo
	public function ValidarCadastroViaAdmin($request,$codigo_usuario=null,$email_atual,$documento_atual) {

		if ($request["Documentos"]["Valor"])
		$documento = UNumeroComponent::SomenteNumeros($request["Documentos"]["Valor"]);
		$valida_email = false;
		if ($request["Usuarios"]["Email"] != $email_atual)
				$valida_email = $request["Usuarios"]["Email"];

		$valida_doc = false;
		if ($request["Documentos"]["Valor"] != $documento_atual)
				$valida_doc = $request["Documentos"]["Valor"];

		$arrayErros = $this->JaExisteViaAdmin($valida_doc,$valida_email);

		$this->Nome = UStringComponent::AntiXSSComLimite($request["Usuarios"]["Nome"], 150);
		$this->Email = UStringComponent::AntiXSSComLimite($this->Email, 150);
		$this->Senha = UStringComponent::AntiXSSComLimite($this->Senha, 200);

		if(!isset($request["Usuarios"]["Nome"]) || strlen($request["Usuarios"]["Nome"]) < 5)
		{
			$arrayErros["Nome"] = "Preencha o campo nome corretamente";
		}

		if(!isset($this->Email) || !UStringComponent::ValidarEmail($request["Usuarios"]["Email"]))
		{
			$arrayErros["Email"] = "Preencha o campo e-mail corretamente";
		}

		if (empty($codigo_usuario)) {
			if(!isset($request["Usuarios"]["Senha"]) || !UStringComponent::ValidarSenha($request["Usuarios"]["Senha"]))
			{
				$arrayErros["Senha"] = "Preencha o campo senha corretamente. A senha deve ter no mínimo 6 caracteres, uma letra maiúscula, uma minúscula e um número.";
			}
			if(strcmp($request["Usuarios"]["Senha"], $request["Usuarios"]["ConfirmaSenha"]) != 0)
			{
				$arrayErros["ConfirmarSenha"] = "Os campos senha e confirmar senha devem ser iguais";
			}
		}

		$tamanhoDocumento = strlen($documento);

		if($tamanhoDocumento < 11)
		{
			$arrayErros["Documento"] = "O CPF / CNPJ digitado é inválido";
		}
		else if(strlen($documento) == 11)
		{
			if(!UNumeroComponent::ValidarCPF($documento)){
				$arrayErros["Documento"] = "O CPF digitado é inválido";
			}
			$this->CodigoTipoDocumento = 1;
		}
		else {
			$this->CodigoTipoDocumento = 2;
			if(!UNumeroComponent::ValidarCNPJ($documento)){
				$arrayErros["Documento"] = "O CNPJ digitado é inválido";
			}
		}

		if(count($arrayErros) == 0){
			$this->Documento = UNumeroComponent::SomenteNumeros($documento);
		}
		return $arrayErros;
	}


	/*
	valida os valores para a primeira parte do cadastro.
	*/
	public function ValidarPasso1(){

		$arrayErros = $this->JaExiste();

		$documento = UNumeroComponent::SomenteNumeros($this->Documento);

		$this->AceiteRegulamento = UNumeroComponent::SomenteNumeros($this->AceiteRegulamento);
		$this->AceiteComunicacao = UNumeroComponent::SomenteNumeros($this->AceiteComunicacao);

		$this->AceiteComunicacao = $this->AceiteComunicacao <= 0 || $this->AceiteComunicacao > 1 ? 0 : $this->AceiteComunicacao;
		$this->AceiteRegulamento = $this->AceiteRegulamento <= 0 || $this->AceiteRegulamento > 1 ? 0 : $this->AceiteRegulamento;

		$this->Nome = UStringComponent::AntiXSSComLimite($this->Nome, 150);
		$this->Email = UStringComponent::AntiXSSComLimite($this->Email, 150);
		$this->Senha = UStringComponent::AntiXSSComLimite($this->Senha, 200);

		if(!isset($this->Nome) || strlen($this->Nome) < 5)
		{
			$arrayErros["Nome"] = "Preencha o campo nome corretamente";
		}

		if(!isset($this->Email) || !UStringComponent::ValidarEmail($this->Email))
		{
			$arrayErros["Email"] = "Preencha o campo e-mail corretamente";
		}

		if(!isset($this->Senha) || !UStringComponent::ValidarSenha($this->Senha))
		{
			$arrayErros["Senha"] = "Preencha o campo senha corretamente. A senha deve ter no mínimo 6 caracteres, uma letra maiúscula, uma minúscula e um número.";
		}

		if(strcmp($this->Senha, $this->ConfirmarSenha) != 0)
		{
			$arrayErros["ConfirmarSenha"] = "Os campos senha e confirmar senha devem ser iguais";
		}

		if(strcmp($this->Email, $this->ConfirmarEmail) != 0)
		{
			$arrayErros["ConfirmarEmail"] = "Os campos e-mail e confirmar e-mail devem ser iguais";
		}

		$tamanhoDocumento = strlen($documento);

		if($tamanhoDocumento < 11)
		{
			$arrayErros["Documento"] = "O CPF / CNPJ digitado é inválido";
		}
		else if(strlen($documento) == 11)
		{
			if(!UNumeroComponent::ValidarCPF($documento)){
				$arrayErros["Documento"] = "O CPF digitado é inválido";
			}
			$this->CodigoTipoDocumento = 1;
		}
		else {
			$this->CodigoTipoDocumento = 2;
			if(!UNumeroComponent::ValidarCNPJ($documento)){
				$arrayErros["Documento"] = "O CNPJ digitado é inválido";
			}
		}

		if(count($arrayErros) == 0){
			$this->Documento = UNumeroComponent::SomenteNumeros($documento);
		}

		if($this->AceiteRegulamento != 1)
		{
			$arrayErros["AceiteRegulamento"] = "Você deve aceitar o regulamento para continuar.";
		}

		return $arrayErros;
	}

	public function salvar()
	{
		$conn = TableRegistry::get("Usuarios");

		$usuario = new Usuario();
		$usuario->Nome = $this->Nome;
		$usuario->CodigoTipoUsuario = 1; // tipo usuário padrão
        $usuario->Ativo = 1;
        $usuario->Senha = (new DefaultPasswordHasher)->hash($this->Senha);
        $usuario->Email = $this->Email;
        $usuario->AceiteComunicacao = $this->AceiteComunicacao;
        $usuario->Slug = $this->GerarSlug();

        $codigoDocumento = Documento::InserirNovoDocumento($this->Documento, $this->CodigoTipoDocumento);

        if($conn->save($usuario));
        {
        	if($codigoDocumento > 0)
            	$codigoUsuarioDocumento = Documento::InserirUsuarioDocumento($codigoDocumento, $usuario->Codigo);

            $this->Codigo = $usuario->Codigo;
            
            return true;
        }

        return false;
	}

	public function GerarSlug($email=null){

		if (!empty($email))
			$this->Email = $email;

		$posicaoArroba = strpos($this->Email, "@");
		$slug = UStringComponent::Slugfy(substr($this->Email, 0, $posicaoArroba));

		$conn = TableRegistry::get("Usuarios");

		$elemento = $conn->find()->where(["Slug" => $slug])->first();
		if($elemento == null)
		{
			return $slug;
		}

		$contador = 1;
		while(true){

			$elemento = $conn->find()->where(["Slug" => $slug . "_" . $contador])->first();
			if($elemento == null)
				break;
			$contador++;
		}

		return $slug . "_" . $contador;
	}

	public function GetByCodigo(){
		
		$conn = TableRegistry::get("Usuarios");

		$usuarioEncontrado = $conn->find()->where(['Codigo' => $this->Codigo, 'ativo' => 1])->first();

		return $usuarioEncontrado;
	}

	public function EfetuarLogin($login, $senha)
	{
		$conn = TableRegistry::get("Usuarios");
		$arrayErros = [];

		$usuarioEncontrado = $conn->find()->where(['email' => $login, 'ativo' => 1])->first();

        if($login == null || $senha == null)
            $arrayErros["Senha"] = "Login ou senha inválidos.";
        
        if(count($usuarioEncontrado) == 0)
            $arrayErros["Senha"] = "Login ou senha inválidos.";
        else {

        	if($usuarioEncontrado->Bloqueado === true){
	        	$this->Codigo = $usuarioEncontrado->Codigo;
	        	$arrayErros["Email"] = "Usuário bloqueado. Entre em contato com o administrador do sistema.";
        	}
        	else if(!(new DefaultPasswordHasher)->check($senha, $usuarioEncontrado->Senha)){
        		$arrayErros["Senha"] = "Login ou senha inválidos.";
        	}

    		$this->Codigo = $usuarioEncontrado->Codigo;
        	
        }

        return $arrayErros;
	}

	public function updateUltimoAcesso(){

	}

	public function PossuiPerfil()
	{
		$conn = TableRegistry::get("UsuarioPerfis");

		$perfil = $conn->find()->where(["CodigoUsuario" => $this->CodigoUsuario])->first();

		return $perfil !== null;
	}

	public function CarregarPerfil()
	{
		$conn = TableRegistry::get("UsuariosPerfis");

		$perfil = $conn->find()->where(["CodigoUsuario" => $this->Codigo])->first();

		// carregar documento
		$documento = new Documento();
		$documento->CodigoUsuario = $this->Codigo;
		$ocupacao = new Ocupacao();
		
		$this->Documento = $documento->ListarPorUsuario();

		if($perfil != null){
			$this->UsuarioPerfil = $perfil;

			if($perfil->CodigoTipoOcupacao != null){ 
				$ocupacao->Codigo = $this->UsuarioPerfil->CodigoTipoOcupacao;
				$this->UsuarioPerfil->Ocupacao = $ocupacao->Listar()->Nome;
			}

			if($perfil->CodigoUF != null){
				$uf = new UF();
				$this->UsuarioPerfil->SiglaUF = $uf->SiglaUFPorCodigo($perfil->CodigoUF);
			}
		}
	}

	public function EsqueciASenha(){
		$arrayErros = [];
		$conn = TableRegistry::get("Usuarios");

		$usuario = $conn->find()->where(["Email" => $this->Email])->first();

		if($usuario == null){
			$arrayErros["Email"] = "E-mail não encontrado no sistema";
		}
		else{
			// gera o código de desbloqueio e dispara o e-mail
			$chave = UStringComponent::guid() . strtotime(date("Y-m-d H:i:s"));
			$usuario->ChaveRecuperacaoSenha  = $chave;
			$usuario->DataGeracaoSenha = date("Y-m-d H:i:s");

			if($conn->save($usuario)){

				$url = BASE_URL . "esqueci-a-senha/nova-senha/" . $chave;
				
				// envia e-mail com o código de desbloqueio
				UEmailComponent::EnviarEmailEsqueciASenha($chave, $usuario->Email, $usuario->Nome);
			}
		}

		return $arrayErros;
	}

	public function ListarPorChaveEsqueciASenha($chave){
		$conn = TableRegistry::get("Usuarios");

		$usuario = $conn->find()->where(["ChaveRecuperacaoSenha" => $chave, "Ativo" => 1])->first();

		if($usuario != null){
			$data1 = date_create($usuario->DataGeracaoSenha);
			$data2 = date_create(date("Y/m/d"));			

			$interval = date_diff($data1, $data2);
			$dias = $interval->d;

			if($dias > 2){
				return -1;
			}

			return $usuario;
		}

		return null;
	}

	public function ValidarNovaSenha($senhaAtual, $novaSenha, $confirmarSenha){
		$arrayErros = [];

		if(strcmp($novaSenha, $confirmarSenha) != 0){
			$arrayErros["ConfirmarSenha"] = "Os campos \"senha\" e \"confirmar senha\" devem ser iguais.";
		}

		if(!isset($this->Senha) || !UStringComponent::ValidarSenha($novaSenha))
		{
			$arrayErros["Senha"] = "Preencha o campo senha corretamente. A senha deve ter no mínimo 6 caracteres, uma letra maiúscula, uma minúscula e um número.";
		}

		if(!(new DefaultPasswordHasher)->check($senhaAtual, $this->Senha))
		{
			$arrayErros["SenhaAtual"] = "A senha atual está incorreta";
		}

		return $arrayErros;
	}

	public function ValidarTrocaDeSenha($novaSenha, $confirmarSenha)
	{
		$arrayErros = [];

		if(strcmp($novaSenha, $confirmarSenha) != 0 || !isset($confirmarSenha)){
			$arrayErros["ConfirmarSenha"] = "Os campos \"senha\" e \"confirmar senha\" devem ser iguais.";
		}

		if(!isset($novaSenha) || !UStringComponent::ValidarSenha($novaSenha))
		{
			$arrayErros["Senha"] = "Preencha o campo senha corretamente. A senha deve ter no mínimo 6 caracteres, uma letra maiúscula, uma minúscula e um número";
		}

		return $arrayErros;
	}

	public function AlterarSenha($novaSenha)
	{
		$this->Senha = (new DefaultPasswordHasher)->hash($novaSenha);
		$this->DataGeracaoSenha = null;
		$this->ChaveRecuperacaoSenha = null;

		// gravar no histórico de senhas?
		$conn = TableRegistry::get("Usuarios");

		return $conn->save($this);
	}

	public function Excluir()
	{
		$conn = TableRegistry::get("Usuarios");

		$usuario = $conn->get($this->Codigo);

		if($usuario != null){
			$usuario->Ativo = 0;

			if($conn->save($usuario)){
				// atualizar pedidos para anônimo
				$pedido = new Pedido();
				$pedido->AtualizarPedidosUsuarioExcluido($usuario->Codigo);

				return true;
			}
		}

		return false;
	}

	public function TotalSeguindo($codigoUsuario)
	{
		$usuarioRelBU = new UsuarioRelacionamento();
		$usuarioRelBU->CodigoUsuario = $codigoUsuario;

		$total = $usuarioRelBU->TotalSeguindo();
		
		return $total;
	}

	public function TotalSeguidores($codigoUsuario)
	{
		$usuarioRelBU = new UsuarioRelacionamento();
		$usuarioRelBU->CodigoUsuario = $codigoUsuario;

		$total = $usuarioRelBU->TotalQuemSegue();

		return $total;
	}

	public function ValidarDadosPerfil()
	{
		$conn = TableRegistry::get("Usuarios");

		$documento = new Documento();

		$arrayErros = [];

		if(!isset($this->Nome) || strlen($this->Nome) < 10)
		{
			$arrayErros["Nome"] = "Preencha o campo nome corretamente";
		}

		/*
		Verifica se o código do usuário dono do documento é o mesmo do usuário atual.
		Caso seja, não é necessário modificar
		*/
		/*$codigoUsuario = $documento->ListarCodigoUsuarioPorDocumento($this->Documento);

		if($codigoUsuario != $this->Codigo){
			$tamanhoDocumento = strlen($usuario->Documento);
			if($tamanhoDocumento < 11)
			{
				$arrayErros["Documento"] = "O CPF / CNPJ digitado é inválido";
			}
			else if(strlen($usuario->Documento) == 11)
			{
				if(!UNumeroComponent::ValidarCPF($usuario->Documento)){
					$arrayErros["Documento"] = "O CPF digitado é inválido";
				}
				$usuario->CodigoTipoDocumento = 1;
			}
			else if(!UNumeroComponent::ValidarCNPJ($usuario->Documento)){
				$arrayErros["Documento"] = "O CNPJ digitado é inválido";
				$usuario->CodigoTipoDocumento = 2;
			}
		}*/

		return $arrayErros;
	}

	public function AtualizarDoPerfil()
	{
		$conn = TableRegistry::get("Usuarios");
		$elemento = $conn->find()->where(["Codigo" => $this->Codigo])->first();

		if($elemento != null){

			$elemento->Nome = $this->Nome;

			return $conn->save($this);
		}

		return false;
	}

	public function AtualizarOptin($status)
	{
		$this->AceiteComunicacao = $status;
		$conn = TableRegistry::get("Usuarios");

		return $conn->save($this);
	}

	public function ListarPorSlug($moderados = true)
	{
		if($moderados)
			$elementos = $this->ListarModerados($this->Slug);
		else
			$elementos = $this->Listar($this->Slug);

		if(count($elementos) == 0) return null;
		
		$usuario = $elementos[0];

		$usuario["TotalSeguidores"] = $this->TotalSeguidores($usuario["Codigo"]);
        $usuario["TotalSeguindo"] = $this->TotalSeguindo($usuario["Codigo"]);

        $pedidoBU = new Pedido();
        $pedidoBU->CodigoUsuario = $usuario["Codigo"];

        $usuario["TotalPedidos"] = $pedidoBU->TotalPorUsuario();

        $avaliacaoBU = new Avaliacao();

        $avaliacaoBU->CodigoObjeto = $usuario["Codigo"];
		$avaliacaoBU->TipoCodigoObjeto = 3;

        $usuario["Avaliacao"] = $avaliacaoBU->CalcularMediaAvaliacoes();
        $usuario["TotalAvaliacoes"] = $avaliacaoBU->TotalAvaliacoes();

        return $usuario;
	}

	public function ListarModerados($slug, $filtro = "", $pagina = 1, $qtd = 0, $startLimit = 0)
	{
		$condicao = !empty($slug) && strlen($slug) > 0 ? " and (usuario.Slug = '". $slug ."' Or '".$slug."' is null) " : "";
		$limite = "";
		
		$condicao .= $filtro;

		if($qtd > 0){
			$limite = " limit " . $startLimit . "," . $qtd;
		}

		$connection = ConnectionManager::get('default');

		$query = 'select 
			usuario.Codigo, usuario.CodigoTipoUsuario, usuario.Nome, usuario.Email, usuario.Slug,
			usuario.Bloqueado, usuario.ChaveRecuperacaoSenha, usuario.DataGeracaoSenha, usuario.Ativo,
			usuario.AceiteComunicacao, usuario.Criacao
		from 
			usuarios usuario join  
			moderacoes b on usuario.Codigo = b.CodigoObjeto and b.CodigoTipoObjeto = 3 
        where	
           	b.CodigoStatusModeracao = 2 and usuario.Ativo = 1 ' . $condicao . $limite;
        //debug($query);die();
		$results = $connection->execute($query)->fetchAll('assoc');

    	return $results;
	}

	public function Listar($slug, $filtro = "", $pagina = 1, $qtd = 0, $startLimit = 0)
	{
		$condicao = !empty($slug) && strlen($slug) > 0 ? " and (usuario.Slug = '". $slug ."' Or '".$slug."' is null) " : "";
		$limite = "";
		
		$condicao .= $filtro;

		if($qtd > 0){
			$limite = " limit " . $startLimit . "," . $qtd;
		}

		$connection = ConnectionManager::get('default');

		$query = 'select 
			usuario.Codigo, usuario.CodigoTipoUsuario, usuario.Nome, usuario.Email, usuario.Slug,
			usuario.Bloqueado, usuario.ChaveRecuperacaoSenha, usuario.DataGeracaoSenha, usuario.Ativo,
			usuario.AceiteComunicacao, usuario.Criacao
		from 
			usuarios usuario 
        where	
           	usuario.Ativo = 1 ' . $condicao . $limite;
        //debug($query);die();
		$results = $connection->execute($query)->fetchAll('assoc');

    	return $results;
	}

	public function Filtrar($data, $pagina, $qtd)
	{
		$filtro = "";

		if(array_key_exists("textoBusca", $data)){
			$filtro = " and (Nome like '%".$data["textoBusca"]."%' Or Slug like '%".$data["textoBusca"]."%') ";
		}

		$start = ($pagina - 1) * $qtd;

		$usuarios = $this->ListarModerados("", $filtro, $pagina, $qtd, $start);

		$usuariosRetorno = [];

		foreach($usuarios as $usuario){
			$usuario["TotalSeguidores"] = $this->TotalSeguidores($usuario["Codigo"]);
	        $usuario["TotalSeguindo"] = $this->TotalSeguindo($usuario["Codigo"]);

	        $pedidoBU = new Pedido();
	        $pedidoBU->CodigoUsuario = $usuario["Codigo"];

	        $usuario["TotalPedidos"] = $pedidoBU->TotalPorUsuario();

	        $avaliacaoBU = new Avaliacao();

	        $avaliacaoBU->CodigoObjeto = $usuario["Codigo"];
			$avaliacaoBU->TipoCodigoObjeto = 3;

	        $usuario["Avaliacao"] = $avaliacaoBU->CalcularMediaAvaliacoes();
	        $usuario["TotalAvaliacoes"] = $avaliacaoBU->TotalAvaliacoes();

	        array_push($usuariosRetorno, $usuario);
		}

		return $usuariosRetorno;
	}
}

?>
