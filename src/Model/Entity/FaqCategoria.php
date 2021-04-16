<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class FaqCategoria extends Entity{
	
	
	public function Listar(){

		$conn = TableRegistry::get("Faq_Categorias");

		$categorias = $conn->find('all')->where(["Ativo" => 1]);

		return $categorias;
	}

	public function ListarCompleto(){

		$categorias = $this->Listar();
		$pergunta = new FaqPergunta();
		foreach ($categorias as $categoria) {
			$pergunta->CodigoFaqCategoria = $categoria->Codigo;

			$categoria->Perguntas = $pergunta->ListarCompleto();
		}

		return $categorias;
	}

}


?>