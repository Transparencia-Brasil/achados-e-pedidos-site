<?php

//file_put_contents(TMP . "/EsIndexarPedidos.task", "RUNNING");
//file_put_contents(TMP . "/EsIndexarPedidos.pid", getmypid());

$tmp = dirname(__DIR__) . '/../tmp';

file_put_contents( $tmp . "/EsIndexarPedidos.task", "RUNNING");
file_put_contents( $tmp . "/EsIndexarPedidos.pid", getmypid());

require dirname(__DIR__) . '/../config/bootstrap.php';

use App\Controller\Component\UCurlComponent;
use App\Model\Entity\PedidoAnexo;
use App\Model\Entity\Pedido;
use App\Model\Entity\PedidoInteracao;
use Cake\Log\Log;
use App\Tasks\TaskEnvHelper;

Log::info("[TASK] Iniciando Indexação de Pedidos ...");

TaskEnvHelper::getInstance()->Init("EsIndexarPedidos");

try {
    $pedidoBU = new Pedido();
    $pedidoInteracaoEdicaoBU = new PedidoInteracao();
    $pedidoAnexoEdicaoBU = new PedidoAnexo();

    TaskEnvHelper::getInstance()->setProgress("Pedidos", 1);
    $pedidoBU->ES_InserirAtualizarPedidos();

    TaskEnvHelper::getInstance()->setProgress("Interações", 1);
    $pedido_interacao_codigo = null; //insere novo pedido no ES
    $pedidoInteracaoEdicaoBU->ES_AtualizarInserirInteracoes($pedido_interacao_codigo);

    TaskEnvHelper::getInstance()->setProgress("Anexos", 1);
    $pedido_anexo_codigo = null; //insere novo anexo no ES
    $pedidoAnexoEdicaoBU->ES_AtualizarInserirAnexos($pedido_anexo_codigo);

    // Realiza o Force Merge
    UCurlComponent::get(ES_URL . "/utils/forceMerge");

    Log::info("[TASK] Finalizando a Indexação de Pedidos ...");
    file_put_contents($tmp . "/EsIndexarPedidos.task", "OKAY");
} catch (\Throwable $th) {
    Log::error("[TASK] Erro na Indexação: " . $th->getMessage());
    file_put_contents($tmp . "/EsIndexarPedidos.task", "ERRO");
}

TaskEnvHelper::getInstance()->setProgress("Concluido", 100);
