DELIMITER $$
CREATE DEFINER=`achadosepedidos`@`%` PROCEDURE `sp_perc_pedidos_ano`(IN ano INT, IN statusPedido varchar(255), OUT  qtdPedidosTotal int, OUT qtdPedidosStatus int, OUT percPedidosAno decimal)
BEGIN    
	select count(p.Codigo) 
		INTO  qtdPedidosTotal
		from pedidos as p
		left join status_pedido as sp on (p.CodigoStatusPedido = sp.Codigo)
		where p.Ativo = 1 AND year(p.DataEnvio) = ano AND sp.Nome <> 'Nao Classificado';
        
	select count(p.Codigo) 
		INTO  qtdPedidosStatus
		from pedidos as p
		left join status_pedido as sp on (p.CodigoStatusPedido = sp.Codigo)
		where p.Ativo = 1 AND sp.Nome = statusPedido AND year(p.DataEnvio) = ano AND sp.Nome <> 'Nao Classificado';
        
	SET percPedidosAno = (qtdPedidosStatus / qtdPedidosTotal) * 100;
END$$
DELIMITER ;
