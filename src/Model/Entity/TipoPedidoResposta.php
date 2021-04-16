<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class TipoPedidoResposta extends Entity{
		

	public function ListarParaSelect(){

		return $this->Listar()->find('list', ['keyField' => 'Codigo', 'valueField' => 'Nome']);
	}
	
	public function Listar(){
		$conn = TableRegistry::get("TipoPedidosRespostas");

		return $conn->find('all');
	}
}

?>