<?php
namespace App\Controller;

use Cake\ORM\TableRegistry;
use App\Model\Entity\Dados;

class DadosController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->response->header('Access-Control-Allow-Origin', '*');
        $this->set('slug_pai', "dados");
    }

    public function index(){

        $record = new Dados();
        $result = $record->Sumario();

        $this->set("sumario", $result);
    }

    public function TaxaDeAtendimentoPorAno() {
        $record = new Dados();
        $result = $record->TaxaDeAtendimentoPorAno();
        echo($result);
        $this->autoRender = false;        
    }

    public function AtendimentoPedidosPorAnoETipo() {
        $record = new Dados();
        $result = $record->AtendimentoPedidosPorAnoETipo();
        echo($result);
        $this->autoRender = false;

    }

    public function PedidosPorUFPoderENivel() {
        $record = new Dados();
        $result = $record->PedidosPorUFPoderENivel();
        echo($result);
        $this->autoRender = false;

    }

    public function PedidosAtendimentoPorAno_V2() {
        $record = new Dados();
        $result = $record->PedidosAtendimentoPorAno_V2();
        echo($result);
        $this->autoRender = false;
    }


    public function PedidosAtendimentoPorAno() {
        $record = new Dados();
        $result = $record->PedidosAtendimentoPorAno();
        echo($result);
        $this->autoRender = false;
    }

    public function Sumario() {

        $record = new Dados();
        $result = $record->Sumario();

        echo($result);
        $this->autoRender = false;

    }

    public function PedidosTempoMedioDeTramitacao() {
        $record = new Dados();
        $result = $record->PedidosTempoMedioDeTramitacao();
        echo($result);
        $this->autoRender = false;
    }

    public function TaxaDeReversao() {
        $record = new Dados();
        $result = $record->TaxaDeReversao();
        echo($result);
        $this->autoRender = false;
    }

}