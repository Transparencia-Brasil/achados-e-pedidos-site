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


        $connection = ConnectionManager::get('default');
        
        //Total de pedidos na base de dados
        $query = "SELECT count(*) as total FROM v_pedidos_ativos_groups";
        
        $totalPedido_array = $connection->execute($query)->fetchAll('assoc');
        $totalPedidos = $totalPedido_array[0]["total"];

        //Total de pedidos não-respondidos e respondidos
        $query = "SELECT * FROM v_pedidos_count_sresposta ORDER BY StatusResposta ASC";
        $totalPedidosRespostas_array = $connection->execute($query)->fetchAll('assoc');
        $totalPedidosNaoRespondidos = $totalPedidosRespostas_array[0]["TotalPedidos"];
        $totalPedidosRespondidos = $totalPedidosRespostas_array[1]["TotalPedidos"];
        
        $pedidos = TableRegistry::get("Pedidos");


        //Tempo médios de primeira resposta (em dias)
        //  "SELECT AVG(DATEDIFF(DataResposta, DataEnvio)) AS MediaDiasResposta FROM v_pedidos_count_dias_resposta;"
        //Total de pedidos na base de dados
        $query = "SELECT AVG(DATEDIFF(DataResposta, DataEnvio)) AS MediaDiasResposta FROM v_pedidos_count_dias_resposta";
        $tempoMedioPrimeiraResposta = $connection->execute($query)->fetchAll('assoc');
        $tempoMedioPrimeiraResposta = floatval($tempoMedioPrimeiraResposta[0]["MediaDiasResposta"]);
        
        //Total de pedidos respondidos em até 20 dias
        //  "SELECT SUM(CASE WHEN (DATEDIFF(DataResposta, DataEnvio) <= 20) THEN 1 ELSE 0 END) / COUNT(CodigoPedido) AS PedidosNoPrazo FROM v_pedidos_count_dias_resposta;"
        $query = "SELECT SUM(CASE WHEN (DATEDIFF(DataResposta, DataEnvio) <= 20) THEN 1 ELSE 0 END) / COUNT(CodigoPedido) AS PedidosNoPrazo FROM v_pedidos_count_dias_resposta";
        $totalPedidosRespondidosEmAteVinteDias = $connection->execute($query)->fetchAll('assoc');
        $totalPedidosRespondidosEmAteVinteDias = floatval($totalPedidosRespondidosEmAteVinteDias[0]["PedidosNoPrazo"]) * 100;

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
            ,'totalPedidosRespondidos'=>$totalPedidosRespondidos
            ,'totalPedidosNaoRespondidos'=>$totalPedidosNaoRespondidos
            ,'tempoMedioPrimeiraResposta'=>$tempoMedioPrimeiraResposta
            ,'totalPedidosRespondidosEmAteVinteDias'=>$totalPedidosRespondidosEmAteVinteDias
            ,'totalPedidosComRecursos'=>$totalPedidosComRecursos
            ,'totalPedidosComRecursosAtendidos'=>$totalPedidosComRecursosAtendidos
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

        $connection = ConnectionManager::get('default');
        
        //Total de pedidos na base de dados
        $query = "SELECT DATE_FORMAT(DataEnvio, '%Y') as ano, count(*) as qtd, StatusResposta as status  FROM v_pedidos_ativos_status_resposta where DATE_FORMAT(DataEnvio, '%Y') >= 2012 AND Ativo = 1 group by ano, status";
        
        $atendimentoPedidosPorAno_arr = $connection->execute($query)->fetchAll('assoc');
        // $totalPedidos = $totalPedido_array[0]["total"];
        return json_encode($atendimentoPedidosPorAno_arr);
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
        $connection = ConnectionManager::get('default');
        
        //Total de pedidos na base de dados
        $query = "select StatusResposta as status, NomeNivelFederativo as nivel, NomePoder as poder, SiglaUf as sigla, SiglaUf as uf, TotalPedidos as qtd from v_pedidos_count_sresposta_nfederativo_poder_uf";
        
        $pedidos = $connection->execute($query)->fetchAll('assoc');
        // print_r($query);
        // die();
        return json_encode($pedidos);
    }

    // public function PedidosPorUFPoderENivel() {
    //     $pedidos = TableRegistry::get("Pedidos");
    //     $query = $pedidos->find();
    //     $query->select(['uf' => 'Uf.Nome','sigla' => 'IF(Uf.Sigla IS NULL, "ÓrgãosFederais", Uf.Sigla)','nivel' => 'TipoNivelFederativo.Nome','poder' => 'TipoPoder.Nome','status' => 'StatusPedido.Nome','qtd' => $query->func()->count('Pedidos.Codigo')]);
    //     $query->matching('agentes', function ($q) {
    //         return $q->contain(['Uf'])->matching('TipoNivelFederativo')->matching('TipoPoder');
    //     });
    //     $query->matching('StatusPedido');
    //     $query->hydrate(false)->where(['Pedidos.Ativo = 1'])->group(['Uf.Codigo','TipoNivelFederativo.Codigo','TipoPoder.Codigo','StatusPedido.Codigo']);
    //     // print_r($query);
    //     // die();
    //     return json_encode($query);
    // }

    public function PedidosTempoMedioDeTramitacao() {

        $connection = ConnectionManager::get('default');
        $query = "SELECT * FROM v_pedidos_count_dias_resposta";
        return  json_encode($connection->execute($query)->fetchAll('assoc'));


        // $pedidos = TableRegistry::get("Pedidos");
        // $query = $pedidos->find()->where(['PedidosInteracoes.CodigoTipoPedidoResposta = 1 AND Pedidos.Ativo = 1']);
        // $pedidosTempoMedioDeTramitacao = $query->select(['Codigo' => 'Pedidos.Codigo','Status' => 'StatusPedido.Nome','DataEnvio' => 'Pedidos.DataEnvio','DataResposta' => 'PedidosInteracoes.DataResposta'])->contain(['PedidosInteracoes'])->matching('StatusPedido')->all();

        // return json_encode($pedidosTempoMedioDeTramitacao);
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