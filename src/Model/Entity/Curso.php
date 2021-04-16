<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class Curso extends Entity{

	public function Listar(){

		$cursos = TableRegistry::get("Cursos")->find('all')->where(["Cursos.ativo" => 1])->contain(["TipoCursos"])->contain(["Cidades"])->contain(["UF"]);

		return $cursos;
	}
}


?>