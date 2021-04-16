<?php
namespace App\Controller;

use Cake\ORM\TableRegistry;
use App\Model\Entity\FaqCategoria;

class FaqController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        
        $this->set('slug_pai', "faq");
        $this->loadComponent('Flash');
        $this->loadComponent('Auth');
        $this->loadComponent('UString');
        $this->loadComponent('UNumero');
    }

    public function index(){

        $categoria = new FaqCategoria();

        $categorias = $categoria->Listar();
        $dados = $categoria->ListarCompleto();
        
        $this->set("dados", $dados->toArray());
        $this->set("categorias", $categorias);
    }

}