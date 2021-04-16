 DELIMITER $$
 CREATE TRIGGER pedidosModeracoes AFTER INSERT ON pedidos 
 FOR EACH ROW
   BEGIN
    IF NEW.CodigoTipoOrigem = 3 THEN
       insert into moderacoes (CodigoTipoObjeto, CodigoStatusModeracao, CodigoObjeto) VALUES (1, 2, New.Codigo);
    END IF;
  END $$
 DELIMITER;