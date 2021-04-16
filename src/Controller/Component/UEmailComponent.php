<?php

namespace App\Controller\Component;

use Cake\Network\Email\Email;
use Cake\Controller\Component;
use Cake\I18n\Time;
use Cake\Filesystem\File;
use App\Controller\Component\UStringComponent;

class UEmailComponent extends Component
{

	public static function EnviarEmail($nomeDestinatario, $emailDestinatario, $titulo, $body, $boolHtml, $replyEmail="")
	{
		try{
			$from = "lai@transparencia.org.br";


			$email = new Email('default');
			$email->to($emailDestinatario, $nomeDestinatario);
			$email->sender($from, 'Achados e Pedidos');
			if (!empty($replyEmail))
				$email->replyTo($replyEmail);

			if($boolHtml)
				$email->emailFormat('html');

			$email->from($from);
			$email->subject($titulo);

			$resultado = $email->send($body);

			return true;

		}catch(Exception $ex)
		{
			// logar no banco
			$url = $_SERVER['REQUEST_URI'];
			$variaveis = "Erro ao enviar e-mail:" . $titulo . " " . $emailDestinatario;
			UStringComponent::registrarErro($url, $ex, $variaveis);
			return false;
		}
	}

	public static function EnviarEmailPedidoModeradoAceito($emailCliente, $nomeCliente, $tituloPedido, $linkPedido){
		try{
			$arquivo = WWW_ROOT . "emails" . DS . "pedido-moderado-aceito.html";

			$file = new File($arquivo);
			$conteudo = $file->read();

			$file->close();

			$conteudo = str_replace("{LINK}", $linkPedido, $conteudo);
			$conteudo = str_replace("{TITULOPEDIDO}", $tituloPedido, $conteudo);
			$conteudo = str_replace("{NOME}", $nomeCliente, $conteudo);

			return UEmailComponent::EnviarEmail($nomeCliente, $emailCliente, "[Achados e Pedidos] - Seu pedido foi aceito", $conteudo, true);
		}
		catch(Exception $ex)
		{
			$url = $_SERVER['REQUEST_URI'];
			$variaveis = "Erro ao enviar e-mail de pedido cadastrado:" . $emailDestinatario . " " . $linkPedido;
			UStringComponent::registrarErro($url, $ex, $variaveis);
			return false;
		}
	}

	public static function EnviarEmailEsqueciASenha($codigoDesbloqueio, $emailCliente, $nomeCliente)
	{
		try{
			$arquivo = WWW_ROOT . "emails" . DS . "alterar-senha.html";

			$file = new File($arquivo);
			$conteudo = $file->read();

			$file->close();

			$link = BASE_URL . "esqueci-a-senha/nova-senha/" . $codigoDesbloqueio;
			$conteudo = str_replace("{LINK}", $link, $conteudo);
			$conteudo = str_replace("{NOME}", $nomeCliente, $conteudo);

			return UEmailComponent::EnviarEmail($nomeCliente, $emailCliente, "[Achados e Pedidos] - Favor resetar a sua senha.", $conteudo, true);
		}
		catch(Exception $ex)
		{
			$url = $_SERVER['REQUEST_URI'];
			$variaveis = "Erro ao enviar e-mail de esqueci a senha:" . $emailDestinatario;
			UStringComponent::registrarErro($url, $ex, $variaveis);
			return false;
		}
	}

	public static function EnviarEmailBemVindo($emailCliente, $nomeCliente){
		try{
			$arquivo = WWW_ROOT . "emails" . DS . "cadastro-efetuado-com-sucesso.html";

			$file = new File($arquivo);
			$conteudo = $file->read();

			$file->close();

			$conteudo = str_replace("{NOME}", $nomeCliente, $conteudo);

			return UEmailComponent::EnviarEmail($nomeCliente, $emailCliente, "[Achados e Pedidos] - Seu cadastro foi efetuado com sucesso!", $conteudo, true);
		}
		catch(Exception $ex)
		{
			$url = $_SERVER['REQUEST_URI'];
			$variaveis = "Erro ao enviar e-mail de bem vindo:" . $emailDestinatario;
			UStringComponent::registrarErro($url, $ex, $variaveis);
			return false;
		}

	}

	public static function EnviarEmailPedidoCadastrado($emailCliente, $nomeCliente, $tituloPedido, $linkPedido)
	{
		try{
			$arquivo = WWW_ROOT . "emails" . DS . "pedido-cadastrado-com-sucesso.html";

			$file = new File($arquivo);
			$conteudo = $file->read();

			$file->close();

			$conteudo = str_replace("{LINK}", $linkPedido, $conteudo);
			$conteudo = str_replace("{TITULOPEDIDO}", $tituloPedido, $conteudo);
			$conteudo = str_replace("{NOME}", $nomeCliente, $conteudo);

			return UEmailComponent::EnviarEmail($nomeCliente, $emailCliente, "[Achados e Pedidos] - Seu pedido cadastrado com sucesso!", $conteudo, true);
		}
		catch(Exception $ex)
		{
			$url = $_SERVER['REQUEST_URI'];
			$variaveis = "Erro ao enviar e-mail de pedido cadastrado:" . $emailDestinatario . " " . $linkPedido;
			UStringComponent::registrarErro($url, $ex, $variaveis);
			return false;
		}
	}

	public static function EmailContato($nome, $email, $assunto, $mensagem)
	{
		$email_destino = "lai@transparencia.org.br";
		$assuntoEmail = " [Achados e Pedidos] Contato: " . $assunto;
		$replyEmail = $email;

		$arquivo = WWW_ROOT . "emails" . DS . "contato.html";

		$file = new File($arquivo);
		$conteudo = $file->read();

		$file->close();

		$conteudo = str_replace("{NOME}", $nome, $conteudo);
		$conteudo = str_replace("{EMAIL}", $email, $conteudo);
		$conteudo = str_replace("{ASSUNTO}", $assunto, $conteudo);
		$conteudo = str_replace("{MENSAGEM}", $mensagem, $conteudo);


		return UEmailComponent::EnviarEmail("", $email_destino, $assuntoEmail, $conteudo, true, $replyEmail);
	}
}

?>
