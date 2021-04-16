<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
use App\Controller\Component\UStringComponent;

class Contato extends Entity{

	public function Validar(){

		$arrayErros = [];

		if(!isset($this->Nome) ||	strlen($this->nome)){
			$arrayErros["Nome"] = "Preencha o campo nome corretamente.";
		}

		if(UStringComponent::ValidarEmail($this->Email) == 0){
			$arrayErros["Email"] = "Preencha o campo e-mail corretamente.";
		}

		if(!isset($this->Assunto) || strlen($this->Assunto) == 0){
			$arrayErros["Assunto"] = "Preencha o campo assunto corretamente.";
		}

		if(!isset($this->Mensagem) || strlen($this->Mensagem) <= 20){
			$arrayErros["Mensagem"] = "Sua mensagem precisa ter no mínimo 20 caracteres para ser enviada.";	
		}

		return $arrayErros;
	}

	public function Salvar(){

		$conn_contatos = TableRegistry::get("Contatos");

		return $conn_contatos->save($this);
	}

}

?>
