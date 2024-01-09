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

    public function TotalPedidosRespondidos() {
        $connection = ConnectionManager::get('default');

        $query = "SELECT (CASE WHEN (DATEDIFF(DataResposta, DataEnvio) <= 20) THEN 1 ELSE 0 END) as pedidosNoPrazo FROM v_pedidos_count_dias_resposta";
        $total = $connection->execute($query)->fetchAll('assoc');
        $pedidosTotal = 0;

        foreach ($total as $key => $value) {
            $pedidosTotal += floatval($value["pedidosNoPrazo"]);
        }

        $pedidosTotal = ($pedidosTotal / count($total));

        return $pedidosTotal;
    }

    public function TempoMedioPrimeiraResposta() {
        $connection = ConnectionManager::get('default');

        $query = "SELECT DATEDIFF(DataResposta, DataEnvio) AS MediaDiasResposta FROM v_pedidos_count_dias_resposta";
        $tempoMedioPrimeiraRespostaRes = $connection->execute($query)->fetchAll('assoc');
        $tempoMedioPrimeiraResposta = 0;
        if(count($tempoMedioPrimeiraRespostaRes) > 0) {
            foreach ($tempoMedioPrimeiraRespostaRes as $iItem => $item) {
                $tempoMedioPrimeiraResposta += floatval($item["MediaDiasResposta"]);
            }

            $tempoMedioPrimeiraResposta = ($tempoMedioPrimeiraResposta / count($tempoMedioPrimeiraRespostaRes));
        }
        
        return $tempoMedioPrimeiraResposta;
    }

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
        

        $query = "SELECT p.Ativo,  COUNT(p.Codigo) as QuantidadePedido, sp.Nome as StatusPedido
            FROM pedidos as p
            INNER JOIN status_pedido as sp 
            ON p.CodigoStatusPedido = sp.Codigo
            WHERE p.Ativo = 1
            GROUP BY sp.Nome;
            ";
        
        $totalPedido_array = $connection->execute($query)->fetchAll('assoc');
        $totalCount = array_sum(array_column($totalPedido_array,'QuantidadePedido'));
        $totalPedido_new_array = [];
        foreach ($totalPedido_array as $pedido) {
            $perc = round($pedido['QuantidadePedido']/$totalCount * 100,1) ;
            $totalPedido_new_array[$pedido["StatusPedido"]] = ['label' => $pedido['StatusPedido'],'count' => $pedido['QuantidadePedido'],'percent' => $perc . '%'];
            
        }
        
        $pedidos = TableRegistry::get("Pedidos");

        //Tempo médios de primeira resposta (em dias)
        //  "SELECT AVG(DATEDIFF(DataResposta, DataEnvio)) AS MediaDiasResposta FROM v_pedidos_count_dias_resposta;"
        //Total de pedidos na base de dados
        $tempoMedioPrimeiraResposta = $this->TempoMedioPrimeiraResposta();
        
        //Total de pedidos respondidos em até 20 dias
        //  "SELECT SUM(CASE WHEN (DATEDIFF(DataResposta, DataEnvio) <= 20) THEN 1 ELSE 0 END) / COUNT(CodigoPedido) AS PedidosNoPrazo FROM v_pedidos_count_dias_resposta;"        
        $totalPedidosRespondidosEmAteVinteDias = $this->TotalPedidosRespondidos();
    

        //Total de pedidos com recurso
        $query3 = $pedidos->find()->where(['PedidosInteracoes.CodigoTipoPedidoResposta IN (4,5,6,7,8,9,10,11) AND Pedidos.Ativo = 1']);
        $totalPedidosComRecursos = $query3->select(['totalPedidos' => 'count(distinct(Pedidos.Codigo))'])->contain(['PedidosInteracoes'])->first();
        $totalPedidosComRecursos = floatval($totalPedidosComRecursos->totalPedidos);
        //Total de pedidos com recurso e que foram atendidos
        $query4 = $pedidos->find()->where(['PedidosInteracoes.CodigoTipoPedidoResposta IN (4,5,6,7,8,9,10,11) AND CodigoStatusPedido = 1 AND Pedidos.Ativo = 1']);
        $totalPedidosComRecursosAtendidos = $query4->select(['totalPedidos' => 'count(distinct(Pedidos.Codigo))'])->contain(['PedidosInteracoes'])->first();
        $totalPedidosComRecursosAtendidos = floatval($totalPedidosComRecursosAtendidos->totalPedidos);

        $results = [
            'totalPedidosClassificacao'=>$totalPedido_new_array
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
    
    public function TaxaDeAtendimentoPorAno() {
        $connection = ConnectionManager::get('default');
        $query = "select p.Ativo,count(p.Codigo) as QuantidadePedido,year(p.DataEnvio) as AnoEnvio,sp.Nome as NomeStatusPedido from pedidos as p inner join status_pedido as sp on (p.CodigoStatusPedido = sp.Codigo) AND Ativo = 1 group by sp.Nome, year(p.DataEnvio)";
        $atendimentoPedidosPorAno_arr = $connection->execute($query)->fetchAll('assoc');
        return json_encode($atendimentoPedidosPorAno_arr);        
    }

    public function PedidosAtendimentoPorAno() {
        $connection = ConnectionManager::get('default');
        
        $query = "SELECT Count(CodigoPedido) as Qtd, year(DataEnvio) As Ano, StatusResposta FROM v_pedidos_ativos_status_resposta Group By Ano, StatusResposta";


        $pedidos = $connection->execute($query)->fetchAll('assoc');
        return json_encode($pedidos);
    }

    public function PedidosAtendimentoPorAno_V2() {
        $connection = ConnectionManager::get('default');
        
        $query = "CALL `sp_calc_taxa_atendimento_ano`()";

        $pedidos = $connection->execute($query)->fetchAll('assoc');
        return json_encode($pedidos);
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
    public function PedidosPorUFPoderENivelEStatus() {
        $connection = ConnectionManager::get('default');
        
        $connection->execute("call sp_count_total()")->execute();

        //Total de pedidos na base de dados
        $query = "select p.Ativo,
            sp.Nome as NomeStatusPedido,
            count(p.Codigo) as QuantidadePedido,
            pd.Nome as NomePoder,
            nf.Nome as NomeNivelFederativo,
            uf.Sigla as SiglaUF
        from pedidos p
            left join status_pedido as sp on (p.CodigoStatusPedido = sp.Codigo)
            left join agentes as a on (p.CodigoAgente = a.Codigo)
            left join tipo_poder as pd on (a.CodigoPoder = pd.Codigo)
            left join tipo_nivel_federativo as nf on (a.CodigoNivelFederativo = nf.Codigo)
            left join uf as uf on (a.CodigoUF = uf.Codigo)
            group by sp.Nome, pd.Nome, nf.Nome, uf.Sigla
            having Ativo = 1 AND NomeStatusPedido <> 'Não Classificado'";

        $pedidos = $connection->execute($query)->fetchAll('assoc');

        return json_encode($pedidos);
    }

    public function PedidosTempoMedioDeTramitacao() {

        $connection = ConnectionManager::get('default');
        $query = "SELECT * FROM v_pedidos_count_dias_resposta";
        return  json_encode($connection->execute($query)->fetchAll('assoc'));
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