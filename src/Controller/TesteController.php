<?php
namespace App\Controller;

use Cake\ORM\TableRegistry;
use App\Model\Entity\Pedido;
use App\Model\Entity\PedidoInteracao;
use App\Model\Entity\PedidoAnexo;

class TesteController extends AppController
{
	public function initialize(){
        parent::initialize();

        $this->loadComponent("UString");
        $this->loadComponent("UNumero");
        $this->loadComponent('Flash');
        $this->loadComponent('UEmail');
        $this->set('slug_pai', "blog");
    }

    public function emailTeste(){
        //$status = $this->UEmail->EmailContato("Lincon Ribeiro", 'linconcr@gmail.com', 'Teste', 'Teste de conteúdo');

        //$status = $this->UEmail->EnviarEmailEsqueciASenha("aaaaaa", 'linconcr@gmail.com', 'Lincon');
        //$status = $this->UEmail->EnviarEmailPedidoCadastrado('linconcr@gmail.com', 'Lincon', 'teste de título', 'stage.achadosepedidos.org.br');
        
    }

    public function es_pedido($id)
    {
        $pedidoBU = new Pedido();

        $retorno = $pedidoBU->ES_InserirAtualizarPedidos($id);

        die('ok');
    }

    public function es_pedidos_interacao($id)
    {
        $pedidoIBU = new PedidoInteracao();

        $retorno = $pedidoIBU->ES_AtualizarInserirInteracoes($id);

        die('ok');
    }

    public function es_pedidos_anexo($id)
    {
        $pedidoAnexoBU = new PedidoAnexo();

        $retorno = $pedidoAnexoBU->ES_AtualizarInserirAnexos($id);

        die('ok');
    }
}

?>