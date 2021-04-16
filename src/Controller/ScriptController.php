<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use App\Model\Entity\PedidoAnexo;
use App\Controller\Component\UCurlComponent;
use Cake\Datasource\ConnectionManager;

class ScriptController extends AppController{

    public function criaAnexosES(){

        echo "Script de criação de anemos no ES<br><br>";

        $pedidoAnexo = new PedidoAnexo();
        $connection = ConnectionManager::get('default');

        $filtro = ' and b.Codigo is null ';

        $query = '
				Select
					pa.Codigo anexos_codigo,
				    pa.Arquivo anexos_arquivo,
				    "" anexos_conteudo_arquivo,
					pi.Codigo interacoes_codigo,
					pi.Descricao interacoes_descricao,
					DATE_FORMAT(pi.DataResposta,"%Y-%m-%d") interacoes_data_resposta,
					a.Codigo pedidos_codigo,
					a.CodigoUsuario usuarios_codigo,
					c.Nome usuarios_nome,
					c.Nome usuarios_slug,
					c.Email usuarios_email,
				    d.Codigo agentes_codigo,
				    d.Nome agentes_nome,
				    d.Nome agentes_slug,
				    h.Codigo tipo_pedido_origem_codigo,
				    h.Nome tipo_pedido_origem_nome,
					a.CodigoTipoPedidoSituacao tipo_pedido_situacao_codigo,
				    g.Nome tipo_pedido_situacao_nome,
					a.CodigoStatusPedido status_pedido_codigo,
				    e.Nome status_pedido_nome,
				    f.Codigo status_pedido_interno_codigo,
				    f.Nome status_pedido_interno_nome,
				    tpr.Codigo tipo_pedidos_resposta_codigo,
				    tpr.Nome tipo_pedido_origem_nome,
					tp.Codigo tipo_poder_codigo,
				    tp.Nome tipo_poder_nome,
				    tnf.Codigo tipo_nivel_federativo_codigo,
				    tnf.Nome tipo_nivel_federativo_nome,
				    a.Protocolo pedidos_protocolo,
				    a.Titulo pedidos_titulo,
				    a.Slug pedidos_slug,
				    a.Descricao pedidos_descricao,
				    "" pedidos_enviado_para,
				   	DATE_FORMAT(a.DataEnvio,"%Y-%m-%d") pedidos_data_envio,
				    a.FoiProrrogado pedidos_foi_prorrogado,
				    a.Anonimo pedidos_anonimo,
				    case when b.Codigo is null Then 0 Else 1 end JaEnviado
				from
					pedidos a join
				    pedidos_interacoes pi on a.Codigo = pi.CodigoPedido join
				    pedidos_anexos pa on pa.CodigoPedidoInteracao = pi.Codigo left join
					es_pedidos_anexos b on pa.Codigo = b.CodigoPedidoAnexo join
				    usuarios c on a.CodigoUsuario = c.Codigo join
				    agentes d on d.Codigo = a.CodigoAgente join
				    status_pedido e on a.CodigoStatusPedido = e.Codigo join
				    status_pedido f on a.CodigoStatusPedidoInterno = f.Codigo join
				    tipo_pedido_situacao g on g.Codigo = a.CodigoTipoPedidoSituacao join
				    tipo_pedido_origem h on a.CodigoTipoOrigem = h.Codigo join
				    tipo_poder tp on tp.Codigo = d.CodigoPoder join
				    tipo_nivel_federativo tnf on tnf.Codigo = d.CodigoNivelFederativo join
				    tipo_pedido_resposta tpr on tpr.Codigo = pi.CodigoTipoPedidoResposta join
				    moderacoes modera on modera.CodigoObjeto = a.Codigo and modera.CodigoTipoObjeto = 1 and modera.CodigoStatusModeracao = 2
				where
					a.Ativo = 1 ' . $filtro;

        $results = $connection->execute($query)->fetchAll('assoc');
        echo "Quantidade de pedido_anexos: ".count($results)." <br>";

//        try{
//
//            if(count($results) > 0){
//
//                foreach($results as $item){
//
//                    $codigo = $item["anexos_codigo"];
//                    $json = json_encode($item);
//                    $url = ES_URL . 'anexos/gravar/' . $codigo;
//
//                    $retorno = UCurlComponent::enviarDadosJson($url, $json, "PUT");
//
//                    if($retorno !== false)
//                    {
//                        //debug($retorno);
//                        $retornoJson = json_decode($retorno);
//                        if($retornoJson->success != null){
//                            // atualiza pra cada item no banco local
//                            $pedidoAnexo->ES_InserirAtualizarLocalmente($codigo);
//                        }
//                    }
//                }
//            }
//        }catch(Exception $ex)
//        {
//            // logar erro no banco
//            $url = $_SERVER['REQUEST_URI'];
//            $variaveis = "Erro ao enviar anexo ao elastic search:" . (is_null(null) ? "0" : $codigoPedidoAnexo);
//            UStringComponent::registrarErro($url, $ex, $variaveis);
//        }
//
//        $pedidosAnexos = TableRegistry::get('PedidosAnexos');
//
//        $query = $pedidosAnexos->find();
//
//        foreach ($query as $row) {
//            echo $row;
//            echo "<hr>";
//        }


        $this->autoRender = false;
    }
}
?>
