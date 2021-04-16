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

        //if(($viewModel = Cache::read('dadoshome')) === false){

            //$ultimosPedidos = $pedidoBU->FiltrarPedidos($this->request->data, 1, 4,"2668,3619,902,33397");
            $ultimosPedidos = $pedidoBU->FiltrarPedidos($this->request->data, 1, 4);
            $relatorioPorEstado = $pedidoBU->RelatorioPorEstado();
            $relatorioPorAgentePositivas = $pedidoBU->RelatorioPorAgente(1);
            $relatorioPorAgenteNegativas = $pedidoBU->RelatorioPorAgente(2);
            $relatorioTotal = $pedidoBU->RelatorioTotal();
            $destaques = $destaqueBU->Listar();
            $destaques2 = $destaqueBU->Listar();
            $destaques3 = $destaqueBU->Listar();
            //die(debug($destaques));

            $viewModel["UltimosPedidos"] = $ultimosPedidos;
            $viewModel["RelatorioPorEstado"] = $relatorioPorEstado;
            $viewModel["RelatorioPorAgentePositivas"] = $relatorioPorAgentePositivas;
            $viewModel["RelatorioPorAgenteNegativas"] = $relatorioPorAgenteNegativas;
            $viewModel["RelatorioTotal"] = $relatorioTotal;

            //Cache::write('dadoshome', $viewModel);
        //}
        $this->set("viewModel", $viewModel);
        $this->set("destaques", $destaques);
        $this->set("destaques2", $destaques2);
        $this->set("destaques3", $destaques3);
    }
}

?>
