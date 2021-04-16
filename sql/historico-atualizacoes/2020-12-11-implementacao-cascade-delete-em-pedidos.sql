ALTER TABLE es_pedidos drop foreign key fk_es_pedidos;
ALTER TABLE es_pedidos add foreign key (CodigoPedido) references pedidos(Codigo) on DELETE CASCADE

ALTER TABLE pedidos_interacoes drop foreign key fk_pedidointeracao_pedido;
ALTER TABLE pedidos_interacoes add foreign key (CodigoPedido) references pedidos(Codigo) on DELETE CASCADE

ALTER TABLE es_pedidos_interacoes DROP foreign key fk_es_pedidos_interacoes;
ALTER TABLE es_pedidos_interacoes add foreign key (CodigoPedidoInteracao) references pedidos_interacoes(Codigo) on DELETE CASCADE

ALTER TABLE pedidos_anexos DROP foreign key fk_pedidoanexo_pedidointeracao;
ALTER TABLE pedidos_anexos add foreign key (CodigoPedidoInteracao) references pedidos_interacoes(Codigo) on DELETE CASCADE

ALTER TABLE es_pedidos_anexos add foreign key (CodigoPedidoAnexo) references pedidos_anexos(Codigo) on DELETE CASCADE