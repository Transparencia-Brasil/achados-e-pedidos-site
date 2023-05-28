DELIMITER $$
 CREATE DEFINER=`achadosepedidos`@`%` PROCEDURE `sp_calc_taxa_atendimento_ano`()
BEGIN
    DECLARE cTotalPedidos INT;
    DECLARE cTotalStatusPedidos INT;
    DECLARE cPercPedidos INT;
    DECLARE sAnoEnvio INT;
    DECLARE sStatusNome VARCHAR(255);
    DECLARE done INT DEFAULT FALSE;

DECLARE search CURSOR FOR select  year(p.DataEnvio) as AnoEnvio, sp.Nome as NomeStatusPedido
from pedidos as p
left join status_pedido as sp on (p.CodigoStatusPedido = sp.Codigo)
Where p.Ativo = 1 AND YEAR(p.DataEnvio) != YEAR(CURDATE()) 
group by sp.Nome, year(p.DataEnvio);       
DECLARE
CONTINUE HANDLER FOR NOT FOUND
SET
done = TRUE;

    CREATE TEMPORARY Table taxaAtendimentoAno(AnoEnvio INT, StatusNome VARCHAR(255), Total INT, TotalStatus INT, PercStatus DECIMAL);  
    
OPEN search;    
    search_loop:
    LOOP
FETCH NEXT FROM search INTO sAnoEnvio, sStatusNome;        
IF done THEN 
LEAVE search_loop; 
ELSE 
   CALL sp_perc_pedidos_ano(sAnoEnvio, sStatusNome, cTotalPedidos, cTotalStatusPedidos, cPercPedidos);        
   INSERT INTO taxaAtendimentoAno VALUES ( sAnoEnvio, sStatusNome, cTotalPedidos, cTotalStatusPedidos, cPercPedidos);
END IF;
END LOOP;
    
    CLOSE search;
    
    SELECT * FROM taxaAtendimentoAno;
    
    Drop temporary table taxaAtendimentoAno;

END$$
DELIMITER ;