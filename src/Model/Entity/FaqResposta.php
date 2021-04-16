<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class FaqResposta extends Entity{
	
	public function Listar(){

		$conn = TableRegistry::get("FaqRespostas");

		$respostas = $conn->find('all')->where(["CodigoFaqPergunta" => $this->CodigoFaqPergunta, "Ativo" => 1]);

		return $respostas->toArray();
	}
}

?>