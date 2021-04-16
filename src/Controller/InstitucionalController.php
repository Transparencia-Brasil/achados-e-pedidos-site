<?php
namespace App\Controller;

class InstitucionalController extends AppController
{
	public function initialize(){
        parent::initialize();

        $this->set('slug_pai', "institucional");
    }
	
    public function index(){
        
        $this->set('title', "Institucional");
    }

	public function politicadeuso()
    {
        $this->set('title', "Termos de Uso");
    }

    public function termosdeprivacidade()
    {
        $this->set('title', "Termos de Privacidade");	
    }
}

?>