<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class DestaqueHome extends Entity{
	
	public function Listar(){
		$conn = TableRegistry::get("DestaquesHome");
		$elementos = "";

		//$elementos = $conn->find('all')->where(['Ativo' => 1, 'Inicio <= current_timestamp', 'Termino >= current_timestamp']);
		$elementos = $conn->find('CodigoTipoDestaqueHome, Link, Imagem, Nome, Resumo')
			->where(['Ativo = 1 AND (Inicio <="'.date("Y-m-d H:i:s").'" OR Inicio is Null) AND (Termino >="'.date("Y-m-d H:i:s").'" OR Termino is Null)']);
		
		return $elementos;
	}
}

?>