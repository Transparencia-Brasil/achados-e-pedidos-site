<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class Cidade extends Entity{
	
	public static function GetCodigoUF($codigoCidade)
	{
		$elemento = TableRegistry::get("Cidades")->find()->where(['Codigo' => $codigoCidade])->first();

		if($elemento != null){
			return $elemento->CodigoUF;
		}

		return 0;
	}
}

?>