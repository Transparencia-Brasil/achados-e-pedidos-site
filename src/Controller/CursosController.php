<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
use App\Model\Entity\Curso;

class CursosController extends AppController
{
	var $conn = null;

	public function initialize()
	{
		parent::initialize();

		$this->set('slug_pai', "cursos");
	}


	public function index()
    {
    	$objCurso = new Curso();

    	$cursos = $objCurso->Listar();

    	$this->set('title', "Cursos");
    	$this->set("cursos", $cursos);
    }
}

?>