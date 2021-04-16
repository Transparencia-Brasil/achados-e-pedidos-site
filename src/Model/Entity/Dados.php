<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
use App\Controller\Component\UDataComponent;
use App\Controller\Component\UStringComponent;
use App\Controller\Component\UNumeroComponent;
use App\Controller\Component\UCurlComponent;
use Cake\Datasource\ConnectionManager;

class Dados extends Entity{


    /* -------------------------------------------------------------*/
    /* -------------------------------------------------------------*/
    //1. Sumário
    /* -------------------------------------------------------------*/
    /* -------------------------------------------------------------*/
    //     Total de pedidos na base de dados
    //     Total de pedidos atendidos
    //     Total de pedidos não-atendidos
    //     Total de pedidos parcialmente atendidos
    //     Total de pedidos não classificados
    //     Tempo médios de primeira resposta (em dias)
    //     XX Tempo médio de tramitação (em dias) XX
    //     Total de pedidos respondidos em até 20 dias
    //     Total de pedidos com recurso
    //     Total de pedidos com recurso e que foram atendidos
    public function Sumario() {
        $pedidos = TableRegistry::get("Pedidos");

        //Total de pedidos na base de dados
        $totalPedidos = $pedidos->find('all')->where(['Ativo = 1'])->count();
        //Total de pedidos atendidos
        $totalPedidosAtendidos = $pedidos->find('all',['conditions' => ['CodigoStatusPedido =' => '1']])->where(['Ativo = 1'])->count();
        //Total de pedidos não-atendidos
        $totalPedidosNaoAtendidos = $pedidos->find('all',['conditions' => ['CodigoStatusPedido =' => '2']])->where(['Ativo = 1'])->count();
        //Total de pedidos parcialmente atendidos
        $totalPedidosParcialAtendidos = $pedidos->find('all',['conditions' => ['CodigoStatusPedido =' => '3']])->where(['Ativo = 1'])->count();
        //Total de pedidos não classificados
        $totalPedidosNaoClassificados = $pedidos->find('all',['conditions' => ['CodigoStatusPedido =' => '4']])->where(['Ativo = 1'])->count();
        //Tempo médios de primeira resposta (em dias)
        $query = $pedidos->find()->where(['PedidosInteracoes.CodigoTipoPedidoResposta= 1 AND Pedidos.Ativo = 1']);
        $tempoMedioPrimeiraResposta = $query->select(['tempoMedio' => 'SUM(datediff(PedidosInteracoes.DataResposta, Pedidos.DataEnvio))/count(PedidosInteracoes.Codigo)'])->contain(['PedidosInteracoes'])->first();
        $tempoMedioPrimeiraResposta = floatval($tempoMedioPrimeiraResposta->tempoMedio);
        //Tempo médio de tramitação (em dias)
        // SELECT
        // AVG(datediff(PedidosInteracoes.DataResposta, Pedidos.DataEnvio)) AS `mediaPedidos`
        // FROM pedidos Pedidos
        // LEFT JOIN pedidos_interacoes PedidosInteracoes ON Pedidos.Codigo = (PedidosInteracoes.CodigoPedido)
        // WHERE PedidosInteracoes.CodigoTipoPedidoResposta = 1
        $query1 = $pedidos->find()->where(['PedidosInteracoes.CodigoTipoPedidoResposta = 1 AND Pedidos.Ativo = 1']);
        $tempoMedioEmTramitacao = $query1->select(['mediaPedidos' => 'AVG(datediff(PedidosInteracoes.DataResposta, Pedidos.DataEnvio))'])->contain(['PedidosInteracoes'])->first();
        $tempoMedioEmTramitacao = floatval($tempoMedioEmTramitacao->mediaPedidos);
        //Total de pedidos respondidos em até 20 dias
        $query2 = $pedidos->find()->where(['PedidosInteracoes.CodigoTipoPedidoResposta = 1 AND datediff(PedidosInteracoes.DataResposta, Pedidos.DataEnvio) <= 20 AND Pedidos.Ativo = 1']);
        $totalPedidosRespondidosEmAteVinteDias = $query2->select(['totalPedidos' => 'count(Pedidos.Codigo)'])->contain(['PedidosInteracoes'])->first();
        $totalPedidosRespondidosEmAteVinteDias = floatval($totalPedidosRespondidosEmAteVinteDias->totalPedidos);
        //Total de pedidos com recurso
        $query3 = $pedidos->find()->where(['PedidosInteracoes.CodigoTipoPedidoResposta IN (4,5,6,7,8,9,10,11) AND Pedidos.Ativo = 1']);
        $totalPedidosComRecursos = $query3->select(['totalPedidos' => 'count(distinct(Pedidos.Codigo))'])->contain(['PedidosInteracoes'])->first();
        $totalPedidosComRecursos = floatval($totalPedidosComRecursos->totalPedidos);
        //Total de pedidos com recurso e que foram atendidos
        $query4 = $pedidos->find()->where(['PedidosInteracoes.CodigoTipoPedidoResposta IN (4,5,6,7,8,9,10,11) AND CodigoStatusPedido = 1 AND Pedidos.Ativo = 1']);
        $totalPedidosComRecursosAtendidos = $query4->select(['totalPedidos' => 'count(distinct(Pedidos.Codigo))'])->contain(['PedidosInteracoes'])->first();
        $totalPedidosComRecursosAtendidos = floatval($totalPedidosComRecursosAtendidos->totalPedidos);

        $results = [
            'totalPedidos'=>$totalPedidos
            ,'totalPedidosAtendidos'=>$totalPedidosAtendidos
            ,'totalPedidosNaoAtendidos'=>$totalPedidosNaoAtendidos
            ,'totalPedidosParcialAtendidos'=>$totalPedidosParcialAtendidos
            ,'totalPedidosNaoClassificados'=>$totalPedidosNaoClassificados
            ,'tempoMedioPrimeiraResposta'=>$tempoMedioPrimeiraResposta
            ,'totalPedidosRespondidosEmAteVinteDias'=>$totalPedidosRespondidosEmAteVinteDias
            ,'totalPedidosComRecursos'=>$totalPedidosComRecursos
            ,'totalPedidosComRecursosAtendidos'=>$totalPedidosComRecursosAtendidos
            ,'tempoMedioEmTramitacao'=>$tempoMedioEmTramitacao
        ];

        return $results;
    }



    /* -------------------------------------------------------------*/
    /* -------------------------------------------------------------*/
    //1. Sessão Atendimento
    /* -------------------------------------------------------------*/
    /* -------------------------------------------------------------*/

    /* -------------------------------------------------------------*/
    //1.1. Atendimentos dos pedidos por ano por tipo de atendimento
    /* -------------------------------------------------------------*/
    //Consulta
    // SELECT
    // DATE_FORMAT(p.DataEnvio, '%Y') AS ano,
    // s.Nome AS status,
    // COUNT(*) AS qtd
    // FROM
    //     pedidos AS p
    // JOIN status_pedido AS s ON (p.CodigoStatusPedido = s.Codigo)
    // WHERE
    // DATE_FORMAT(p.DataEnvio, '%Y') >= 2012
    // GROUP BY
    //     Ano,
    // CodigoStatusPedido;

    // JSON de respota:
    // [
    //     {
    //         "ano" : 2012,
    //         "status" : "Atendido",
    //         "qtd" : 2500
    //     },
    //     {
    //         "ano" : 2012,
    //         "status" : "Não Atendido",
    //         "qtd" : 20
    //     }, {...}
    // ]


    public function AtendimentoPedidosPorAnoETipo() {
        $pedidos = TableRegistry::get("Pedidos");
        $query = $pedidos->find();
        $query->select(
            ['ano' => 'DATE_FORMAT(DataEnvio, "%Y")','qtd' => $query->func()->count('*')])->contain([
                'StatusPedido' => [
                        'fields' => [
                            'status' => 'StatusPedido.Nome'
                        ]
                ]
            ])->hydrate(false)->where('DATE_FORMAT(DataEnvio, "%Y") >= 2012 AND Pedidos.Ativo = 1')->group(['ano','status']);
        return json_encode($query);
    }

    /* -------------------------------------------------------------*/
    //1.2 Mapa: Pedidos por UF, Poder e Nível
    /* -------------------------------------------------------------*/
    // Consulta:
    // SELECT
    // uf.Nome AS 'uf',
    // uf.Sigla AS 'sigla',
    // n.Nome AS 'nivel',
    // po.Nome AS 'poder',
    // s.Nome AS 'status',
    // COUNT(p.Codigo) AS qtd
    // FROM
    //     pedidos AS p
    // JOIN agentes AS a ON (p.CodigoAgente = a.Codigo)
    // JOIN tipo_nivel_federativo AS n ON (a.CodigoNivelFederativo = n.Codigo)
    // JOIN tipo_poder AS po ON (a.CodigoPoder = po.Codigo)
    // JOIN status_pedido AS s ON (p.CodigoStatusPedido = s.Codigo)
    // LEFT JOIN uf ON (uf.Codigo = a.CodigoUF)
    // GROUP BY
    // uf.Codigo,
    // n.Codigo,
    // po.Codigo,
    // s.Codigo
    // JSON de resposta:
    // [
    //     {
    //         "uf" : "NULL",
    //         "sigla" : "NULL",
    //         "nivel" : "Federal",
    //         "poder" : "Legislativo",,
    //         "status" : "Atendido",
    //         "qtd" : 13
    //     },
    //     {
    //         "uf" : "São Paulo",
    //         "sigla" : "SP",
    //         "nivel" : "Estadual",
    //         "poder" : "Executivo",
    //         "status" : "Atendido",
    //         "qtd" : 69
    //     },{...}
    // ]
    public function PedidosPorUFPoderENivel() {
        $pedidos = TableRegistry::get("Pedidos");
        $query = $pedidos->find();
        $query->select(['uf' => 'Uf.Nome','sigla' => 'IF(Uf.Sigla IS NULL, "ÓrgãosFederais", Uf.Sigla)','nivel' => 'TipoNivelFederativo.Nome','poder' => 'TipoPoder.Nome','status' => 'StatusPedido.Nome','qtd' => $query->func()->count('Pedidos.Codigo')]);
        $query->matching('agentes', function ($q) {
            return $q->contain(['Uf'])->matching('TipoNivelFederativo')->matching('TipoPoder');
        });
        $query->matching('StatusPedido');
        $query->hydrate(false)->where(['Pedidos.Ativo = 1'])->group(['Uf.Codigo','TipoNivelFederativo.Codigo','TipoPoder.Codigo','StatusPedido.Codigo']);
        // print_r($query);
        // die();
        return json_encode($query);
    }

    public function PedidosTempoMedioDeTramitacao() {
        $pedidos = TableRegistry::get("Pedidos");
        $query = $pedidos->find()->where(['PedidosInteracoes.CodigoTipoPedidoResposta = 1 AND Pedidos.Ativo = 1']);
        $pedidosTempoMedioDeTramitacao = $query->select(['Codigo' => 'Pedidos.Codigo','Status' => 'StatusPedido.Nome','DataEnvio' => 'Pedidos.DataEnvio','DataResposta' => 'PedidosInteracoes.DataResposta'])->contain(['PedidosInteracoes'])->matching('StatusPedido')->all();

        return json_encode($pedidosTempoMedioDeTramitacao);
    }


    /* -------------------------------------------------------------*/
    // 3 Recursos
    // 3.1 Taxa de reversão
    /* -------------------------------------------------------------*/
    // Consulta:
    //(SELECT Interacao, Status, COUNT(*) AS 'Qtd' FROM (SELECT p.Codigo, MAX(i.CodigoTipoPedidoResposta) as 'Interacao', s.Nome as 'Status' FROM pedidos p JOIN status_pedido s ON (p.CodigoStatusPedido = s.Codigo) JOIN pedidos_interacoes i ON (p.Codigo = i.CodigoPedido) JOIN tipo_pedido_resposta r ON (r.Codigo = i.CodigoTipoPedidoResposta) WHERE s.Codigo = 1 GROUP BY p.Codigo HAVING Interacao IN (5,7,9,11) ORDER BY Interacao) AS Interacoes GROUP BY Interacao)
    //UNION
    //(SELECT i.CodigoTipoPedidoResposta AS 'Interacao', 'Todos' as 'Status', COUNT(p.Codigo) AS 'Qtd' FROM pedidos p JOIN status_pedido s ON (p.CodigoStatusPedido = s.Codigo) LEFT JOIN pedidos_interacoes i ON (p.Codigo = i.CodigoPedido) WHERE s.Codigo <> 4 AND i.CodigoTipoPedidoResposta in (4, 6, 8, 10) GROUP BY i.CodigoTipoPedidoResposta ORDER BY i.Codigo)
    //ORDER BY Interacao
    public function TaxaDeReversao() {
        $connection = ConnectionManager::get('default');
        $query = "
            (SELECT Interacao, Status, COUNT(*) AS 'Qtd' FROM (SELECT p.Codigo, MAX(i.CodigoTipoPedidoResposta) as 'Interacao', s.Nome as 'Status' FROM pedidos p JOIN status_pedido s ON (p.CodigoStatusPedido = s.Codigo) JOIN pedidos_interacoes i ON (p.Codigo = i.CodigoPedido) JOIN tipo_pedido_resposta r ON (r.Codigo = i.CodigoTipoPedidoResposta) WHERE s.Codigo = 1 GROUP BY p.Codigo HAVING Interacao IN (5,7,9,11) ORDER BY Interacao) AS Interacoes GROUP BY Interacao)
            UNION
            (SELECT i.CodigoTipoPedidoResposta AS 'Interacao', 'Todos' as 'Status', COUNT(p.Codigo) AS 'Qtd' FROM pedidos p JOIN status_pedido s ON (p.CodigoStatusPedido = s.Codigo) LEFT JOIN pedidos_interacoes i ON (p.Codigo = i.CodigoPedido) WHERE s.Codigo <> 4 AND i.CodigoTipoPedidoResposta in (4, 6, 8, 10) AND p.Ativo = 1 GROUP BY i.CodigoTipoPedidoResposta ORDER BY i.Codigo)
            ORDER BY Interacao";
        return  json_encode($connection->execute($query)->fetchAll('assoc'));
    }

}
?>
