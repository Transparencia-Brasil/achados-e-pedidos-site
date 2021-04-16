<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class Ocupacao extends Entity{
	
	public function Listar(){
		$conn_ocupacao = TableRegistry::get("TipoOcupacao");

		$elemento = $conn_ocupacao->find()->where(["Codigo" => $this->Codigo])->first();

		if($elemento != null)
			return $elemento;

		return null;
	}
}

?>