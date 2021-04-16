<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Model\Entity\Banner;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class AgenteCategoriaController extends AppController{

	public function initialize()
	{
		parent::initialize();
		$this->layout = 'admin';
		$this->loadComponent('Flash');
        $this->loadComponent('UData');
	}

	public function index($id = null)
	{
		
	}


}