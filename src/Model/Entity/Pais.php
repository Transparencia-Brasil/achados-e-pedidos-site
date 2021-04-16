<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class Pais extends Entity{
	
	public function GetByCodigo($codigo)
	{
		$elemento = TableRegistry::get("pais")->find('all')->where(['Codigo' => $codigo])->first();

		return $elemento;
	}
}

?>