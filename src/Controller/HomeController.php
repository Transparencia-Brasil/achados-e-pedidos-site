<?php
namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
use Cake\Datasource\ConnectionManager;
use App\Model\Entity\Pedido;
use App\Model\Entity\DestaqueHome;
use Cake\Cache\Cache;

class HomeController extends AppController
{
	public function initialize(){
        parent::initialize();
        $this->set('slug_pai', "home");

        $this->loadComponent("UString");
        $this->loadComponent("UData");
        $this->loadComponent('USessao');
    }
    
	public function index()
    {
        $dataAtual = Time::now();
        $dataAtual->timezone = 'America/Sao_Paulo';
        $dataAtual = $dataAtual->i18nFormat('YYYY-MM-dd HH:mm:ss');

        $pedidoBU = new Pedido();
        $destaqueBU = new DestaqueHome();

        $viewModel = [];
        //$ultimosPedidos = $pedidoBU->PedidosRecentes(4);
        $destaques = $destaqueBU->Listar();
        $destaques2 = $destaqueBU->Listar();
        $destaques3 = $destaqueBU->Listar();

        //$viewModel["UltimosPedidos"] = $ultimosPedidos;
        $this->set("viewModel", $viewModel);
        $this->set("destaques", $destaques);
        $this->set("destaques2", $destaques2);
        $this->set("destaques3", $destaques3);
    }
}

?>
