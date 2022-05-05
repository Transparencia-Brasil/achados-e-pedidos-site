<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Model\Entity\Pedido;
use App\Model\Entity\PedidoInteracao;
use App\Model\Entity\PedidoAnexo;
//use App\Model\Entity\Moderacao;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
use App\Controller\Component\UTaskComponent;
use App\Tasks\TaskEnvHelper;
class PedidosController extends AppController{

    public $paginate = [
        'limit' => 50,
        'order' => [
            'Pedidos.Criacao' => 'Desc'
        ]
    ];

	public function initialize()
	{
		parent::initialize();
		$this->layout = 'admin';
		$this->loadComponent('Flash');
        $this->loadComponent('UData');
        $this->loadComponent('UString');
        $this->loadComponent('Paginator');
	}

	public function index($id = null)
	{
        $title = $this->request->query('t');

        if (!empty($title)) {
            $query = ['Pedidos.Titulo LIKE' => '%'.$title.'%'];
        } else {
            $query = ["1" => "1"];
        }

        $pedidos = $this->paginate($this->Pedidos->find('all')->where(['Pedidos.Ativo' => true])->where($query)->contain(['Agentes'])->order(['Pedidos.Criacao' => 'DESC']));
        // $this->render('/Error/error400');
        // $pedidos = $this->paginate($this->Pedidos->find('all')->where(['Pedidos.Ativo' => true])->where($query)->contain(['Agentes'])->order(['Pedidos.Criacao' => 'DESC']));
        $this->set('pedidos', $pedidos);
	}

	public function edit($id = null)
	{
		$pedido = isset($id) ? $this->Pedidos->find('all')->where(['codigo' => $id])->first() : new Pedido();
		$pedido = $pedido == null ? new Pedido() : $pedido;


		$agentes = TableRegistry::get('Agentes')->find('list', ['keyField' => 'Codigo', 'valueField' => 'Nome']);
		$tipo_origem = TableRegistry::get('TipoPedidoOrigem')->find('list', ['keyField' => 'Codigo', 'valueField' => 'Nome']);
		$tipo_situacao = TableRegistry::get('TipoPedidoSituacao')->find('list', ['keyField' => 'Codigo', 'valueField' => 'Nome']);
		$status_pedido = TableRegistry::get('StatusPedido')->find('list', ['keyField' => 'Codigo', 'valueField' => 'Nome']);
        $tipo_resposta = TableRegistry::get('TipoPedidoResposta')->find('list', ['keyField' => 'Codigo', 'valueField' => 'Nome']);

		if ($this->request->is(['post', 'put'])) {
            $this->Pedidos->patchEntity($pedido, $this->request->data);

            if($pedido->errors())
                $this->Flash->success('Erro ao salvar pedido. Verifique os campos obrigatórios.');
            else{
								$pedido->DataEnvio = $this->UData->ConverterMySQL($pedido->DataEnvio);

                if(strlen($pedido->Slug) == 0)
                    $pedido->Slug = substr($this->UString->Slugfy($pedido->Titulo), 0, 200);

                if($this->Pedidos->save($pedido)){

                    $this->Flash->success('Pedido salvo com sucesso!');
                    $this->redirect(array('action' => 'index'));
                }else
                {
                    $this->Flash->error('Erro ao salvar pedido!');
                }
            }
        }

        if(isset($id) && !$pedido->isNew())
        {
            $pedido->DataEnvio = !is_null($pedido->DataEnvio) ? $this->UData->ConverterDataBrasil($pedido->DataEnvio) : $this->request->data['Pedidos']['DataEnvio'] = $this->UData->ConverterDataBrasil(date('Y-m-d'));
            $pedidoInteracao = new PedidoInteracao();
            $pedidoInteracao->CodigoPedido = $id;
            $pedido->Respostas = $pedidoInteracao->Listar();

            $connRevisoes = TableRegistry::get("PedidosRevisoes");
            $lista = $connRevisoes->find('all')->where(['PedidosRevisoes.Respondido' => 0, 'PedidosRevisoes.CodigoPedido' => $pedido->Codigo])->contain(['Pedidos', 'Usuarios'])->order(['PedidosRevisoes.Criacao' => 'DESC']);

            $pedido->Revisoes = $lista;

            $pedido->ES_InserirAtualizarPedidos($pedido->Codigo);


        }

		$this->set('pedido', $pedido);
		$this->set('agentes', $agentes);
		$this->set('tipo_origem', $tipo_origem);
		$this->set('tipo_situacao', $tipo_situacao);
		$this->set('status_pedido', $status_pedido);
        $this->set('tipo_resposta', $tipo_resposta);

	}

    public function limparPastas()
    {
        $pedidoAnexoEdicaoBU = new PedidoAnexo();
        $pedidoAnexoEdicaoBU->apagarpastas();

        return $this->redirect('/admin/pedidos/import');
    }

    public function import()
    {

        $pedidoBU = new Pedido();
        $pedidoInteracaoEdicaoBU = new PedidoInteracao();
        $pedidoAnexoEdicaoBU = new PedidoAnexo();
        $estadoIndexacao = UTaskComponent::estadoTarefa("EsIndexarPedidos");
        $executandoIndexacao = UTaskComponent::estaRodando("EsIndexarPedidos");
        $progressoMsg = "";
        $progressoPerc = 0;

        if ($this->request->is(['post', 'put'])) {
            // Inicia o Processo em Plano de Fundo para a Indexação
            if(!$executandoIndexacao) {
                UTaskComponent::iniciarTarefa("EsIndexarPedidos");
                $estadoIndexacao = "NEW";
                $executandoIndexacao = true;
            }
        }

        if($executandoIndexacao) {
            TaskEnvHelper::getInstance()->Init("EsIndexarPedidos");
            $progressoMsg = TaskEnvHelper::getInstance()->getMessage();
            $progressoPerc = TaskEnvHelper::getInstance()->getPercent();
        }

        $TotalImportados = $pedidoBU->TotalPedidosModerados("and pedidos.CodigoTipoOrigem = 3",$moderacao = false);
        $TotalPendentesES = $pedidoBU->ES_TotalPedidosPendentesImportacao();
        $TotalPendentesInteracoesES = $pedidoBU->ES_TotalPedidosInteracoesPendentesImportacao();
        //2017-03-09 Paulo Campos: Adicionado metodo
        $TotalPendentesAnexosES = $pedidoBU->ES_TotalPedidosAnexosPendentesImportacao();
        $TotalPendentesAnexosPastasES = $pedidoBU->ES_TotalPedidosAnexosPendentesImportacaoPastas();


        $this->set('TotalPendentesES', $TotalPendentesES);
        $this->set('TotalPendentesInteracoesES', $TotalPendentesInteracoesES);
        $this->set('TotalPendentesAnexosPastasES', $TotalPendentesAnexosPastasES);
        $this->set('TotalPendentesAnexosES', $TotalPendentesAnexosES);
        $this->set('TotalImportados', $TotalImportados);
        $this->set('estadoIndexacao', $estadoIndexacao);
        $this->set('executandoIndexacao', $executandoIndexacao);
        $this->set('pedidoBU', $pedidoBU);
        $this->set('progressoMsg', $progressoMsg);
        $this->set('progressoPerc', $progressoPerc);
    }

    public function editInteracao()
    {
        $pedidoInteracao = new PedidoInteracao();
        $connInteracao = TableRegistry::get("PedidosInteracoes");

        if ($this->request->is(['post', 'put'])) {

            $connInteracao->patchEntity($pedidoInteracao, $this->request->data);

            $pedidoInteracao->DataResposta = $this->UData->ConverterMySQL($pedidoInteracao->DataResposta);
            if($connInteracao->save($pedidoInteracao)){

								$pedidoInteracao->ES_AtualizarInserirInteracoes($pedidoInteracao->Codigo);
                $this->Flash->success('Pedido salvo com sucesso!');
                $this->redirect(array('action' => 'index'));
            }else
            {
                $this->Flash->error('Erro ao salvar pedido!');
            }

        }
    }

    public function removerArquivo($id)
    {
        $this->autoRender = false;
        $this->response->type('application/json');

        $connArquivo = TableRegistry::get("PedidosAnexos");

        $elemento = $connArquivo->find()->where(['Codigo' => $id])->first();

        if($elemento != null)
        {
            $elemento->Ativo = 0;
            if($connArquivo->save($elemento))
            {
                $pedidoAnexoEdicaoBU = new PedidoAnexo();
                $pedidoAnexoEdicaoBU->ES_RemoverAnexo($id);
                $retorno = ["status" => 1];
            }else{
                $retorno = ["erro" => true, "msg" => "Erro ao remover arquivo."];
            }
        }else{
            $retorno = ["erro" => true, "msg" => "Erro ao remover arquivo."];
        }

        echo json_encode($retorno);
    }

    public function responderRevisao($codigo)
    {
        $this->autoRender = false;
        $this->response->type('application/json');

        if($codigo != null){
            $connPedidoRevisao = TableRegistry::get("PedidosRevisoes");
            $elemento = $connPedidoRevisao->find()->where(['Codigo' => $codigo])->first();

            if($elemento != null)
            {
                $elemento->Respondido = 1;

                if($connPedidoRevisao->save($elemento)){
                    $retorno = ["status" => 1];
                }else
                {
                    $retorno = ["erro" => true, "msg" => "Erro ao salvar revisão"];
                }
            }else{
                $retorno = ["erro" => true, "msg" => "Revisão não encontrada."];
            }
        }

        echo json_encode($retorno);
    }

	public function delete($id)
	{
		$pedido = null;
        if(isset($id)){
            $pedido = $this->Pedidos->find('all')->where(['Codigo' => $id /*, 'Ativo' => true */])->first();
            if($pedido != null){
                $pedido->Ativo = false;

                $status = $this->Pedidos->save($pedido);
                if($status){
                    $this->Flash->success('Pedido excluído com sucesso.');
                    // remove pedido do elastic search
                    $pedidoBU = new Pedido();
                    $pedidoBU->ES_RemoverPedido($pedido->Codigo);

                }else{
                    $this->Flash->error('Erro ao excluir pedido.');
                }
            }else{
                $this->Flash->error('Pedido não encontrado.');
            }
        }
        else{
            $this->Flash->error('Id inválido.');
        }

        $this->redirect(array('action' => 'index'));
	}
}
