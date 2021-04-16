<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class TipoObjeto extends Entity{
	
	public function ObjetoValido($codigo){
		/*
		1 - Pedido
		2 - Agente
		3 - Usuario
		4 - Comentário
		*/
		if($codigo <= 0 || $codigo > 4){
			return false;
		}

		return true;
	}

}


?>