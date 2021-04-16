<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class PedidoRevisao extends Entity{
	
	public function Salvar(){

		$conn = TableRegistry::get("PedidosRevisoes");

		return $conn->save($this);
	}
}

?>