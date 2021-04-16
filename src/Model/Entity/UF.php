<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
use App\Model\Entity\Pais;

class UF extends Entity{
	
	public static function CodigoUFPorSigla($sigla)
	{
		$UF = TableRegistry::get("uf")->find('all')->where(['sigla' => strtoupper($sigla)])->first();

		if($UF == null)
			return 0;

		return $UF->Codigo;
	}

	public static function SiglaUFPorCodigo($codigo)
	{
		$UF = TableRegistry::get("uf")->find('all')->where(['Codigo' => $codigo])->first();

		if($UF == null)
			return 0;

		return $UF->Sigla;
	}

	public static function GetCodigoPais($codigoUF){
		$UF = TableRegistry::get("uf")->find('all')->where(['Codigo' => $codigoUF])->first();

		if($UF != null)
		{
			$paisBU = new Pais();
			return $paisBU->GetByCodigo($UF->CodigoPais);
		}	

		return null;
	}
}

?>