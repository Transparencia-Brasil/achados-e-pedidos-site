CREATE VIEW pedidosAnexosElasticSearchView AS
    Select 
        a.Codigo as pedidos_codigo,
        a.CodigoTipoPedidoSituacao as tipo_pedido_situacao_codigo,
        a.CodigoStatusPedidoInterno,
        a.CodigoStatusPedido as status_pedido_codigo,
        a.CodigoAgente,
        a.CodigoUsuario as usuarios_codigo,
        a.CodigoTipoOrigem,
        pi.Codigo as interacoes_codigo,
        pi.CodigoTipoPedidoResposta,
        pa.Codigo as anexos_codigo,
        pa.Arquivo anexos_arquivo,
        b.Codigo as es_pedidos_anexos_codigo,
        case when b.Codigo is null Then 0 Else 1 end JaEnviado
        from pedidos as a 
            join pedidos_interacoes as pi on a.Codigo = pi.CodigoPedido 
            join pedidos_anexos as pa on pa.CodigoPedidoInteracao = pi.Codigo 
            left join es_pedidos_anexos as b on pa.Codigo = b.CodigoPedidoAnexo
            join moderacoes as modera on modera.CodigoObjeto = a.Codigo and modera.CodigoTipoObjeto = 1 and modera.CodigoStatusModeracao = 2 
        where a.Ativo = 1;