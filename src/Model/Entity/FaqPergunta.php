<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class FaqPergunta extends Entity{

	public function Listar(){

		$conn = TableRegistry::get("FaqPerguntas");

		$perguntas = $conn->find('all')->where(["CodigoFaqCategoria" => $this->CodigoFaqCategoria, "Ativo" => 1]);

		return $perguntas;
	}

	public function ListarCompleto(){
		$perguntas = $this->Listar();

		foreach ($perguntas as $pergunta) {
			
			$codigoPergunta = $pergunta->Codigo;
			$resposta = new FaqResposta();
			$resposta->CodigoFaqPergunta = $pergunta->Codigo;

			$pergunta->Respostas = $resposta->Listar();
		}

		return $perguntas;
	}

}

?>