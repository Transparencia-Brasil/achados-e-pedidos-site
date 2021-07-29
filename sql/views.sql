DROP TABLE IF EXISTS `v_count_total`;
/*!50001 DROP VIEW IF EXISTS `v_count_total`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_count_total` AS SELECT 
 1 AS `Ativo`,
 1 AS `NomeNivelFederativo`,
 1 AS `NomePoder`,
 1 AS `SiglaUF`,
 1 AS `Total`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_count_total_nao_respondido`
--

DROP TABLE IF EXISTS `v_count_total_nao_respondido`;
/*!50001 DROP VIEW IF EXISTS `v_count_total_nao_respondido`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_count_total_nao_respondido` AS SELECT 
 1 AS `Ativo`,
 1 AS `StatusResposta`,
 1 AS `NomeNivelFederativo`,
 1 AS `NomePoder`,
 1 AS `SiglaUF`,
 1 AS `TotalPedidos`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_count_total_respondido`
--

DROP TABLE IF EXISTS `v_count_total_respondido`;
/*!50001 DROP VIEW IF EXISTS `v_count_total_respondido`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_count_total_respondido` AS SELECT 
 1 AS `Ativo`,
 1 AS `StatusResposta`,
 1 AS `NomeNivelFederativo`,
 1 AS `NomePoder`,
 1 AS `SiglaUF`,
 1 AS `TotalPedidos`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_pedidos_ativos_groups`
--

DROP TABLE IF EXISTS `v_pedidos_ativos_groups`;
/*!50001 DROP VIEW IF EXISTS `v_pedidos_ativos_groups`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_pedidos_ativos_groups` AS SELECT 
 1 AS `CodigoPedido`,
 1 AS `Ativo`,
 1 AS `DataEnvio`,
 1 AS `CodigoNivelFederativo`,
 1 AS `NomeNivelFederativo`,
 1 AS `CodigoPoder`,
 1 AS `NomePoder`,
 1 AS `CodigoUF`,
 1 AS `SiglaUF`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_pedidos_ativos_status_resposta`
--

DROP TABLE IF EXISTS `v_pedidos_ativos_status_resposta`;
/*!50001 DROP VIEW IF EXISTS `v_pedidos_ativos_status_resposta`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_pedidos_ativos_status_resposta` AS SELECT 
 1 AS `CodigoPedido`,
 1 AS `DataEnvio`,
 1 AS `Ativo`,
 1 AS `StatusResposta`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_pedidos_ativos_status_resposta_ignorado`
--

DROP TABLE IF EXISTS `v_pedidos_ativos_status_resposta_ignorado`;
/*!50001 DROP VIEW IF EXISTS `v_pedidos_ativos_status_resposta_ignorado`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_pedidos_ativos_status_resposta_ignorado` AS SELECT 
 1 AS `CodigoPedido`,
 1 AS `Ativo`,
 1 AS `DataEnvio`,
 1 AS `StatusResposta`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_pedidos_ativos_status_resposta_nao_respondido`
--

DROP TABLE IF EXISTS `v_pedidos_ativos_status_resposta_nao_respondido`;
/*!50001 DROP VIEW IF EXISTS `v_pedidos_ativos_status_resposta_nao_respondido`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_pedidos_ativos_status_resposta_nao_respondido` AS SELECT 
 1 AS `CodigoPedido`,
 1 AS `Ativo`,
 1 AS `DataEnvio`,
 1 AS `StatusResposta`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_pedidos_ativos_status_resposta_respondido`
--

DROP TABLE IF EXISTS `v_pedidos_ativos_status_resposta_respondido`;
/*!50001 DROP VIEW IF EXISTS `v_pedidos_ativos_status_resposta_respondido`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_pedidos_ativos_status_resposta_respondido` AS SELECT 
 1 AS `CodigoPedido`,
 1 AS `Ativo`,
 1 AS `DataEnvio`,
 1 AS `StatusResposta`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_pedidos_count_dias_resposta`
--

DROP TABLE IF EXISTS `v_pedidos_count_dias_resposta`;
/*!50001 DROP VIEW IF EXISTS `v_pedidos_count_dias_resposta`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_pedidos_count_dias_resposta` AS SELECT 
 1 AS `CodigoPedido`,
 1 AS `DataEnvio`,
 1 AS `DataResposta`,
 1 AS `NomeEsferaPoder`,
 1 AS `NomeNivelFederativo`,
 1 AS `DiasCorridos`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_pedidos_count_orgao`
--

DROP TABLE IF EXISTS `v_pedidos_count_orgao`;
/*!50001 DROP VIEW IF EXISTS `v_pedidos_count_orgao`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_pedidos_count_orgao` AS SELECT 
 1 AS `CodigoAgente`,
 1 AS `NomeAgente`,
 1 AS `TotalPedidos`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_pedidos_count_sresposta`
--

DROP TABLE IF EXISTS `v_pedidos_count_sresposta`;
/*!50001 DROP VIEW IF EXISTS `v_pedidos_count_sresposta`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_pedidos_count_sresposta` AS SELECT 
 1 AS `StatusResposta`,
 1 AS `TotalPedidos`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_pedidos_count_sresposta_nfederativo_poder_uf`
--

DROP TABLE IF EXISTS `v_pedidos_count_sresposta_nfederativo_poder_uf`;
/*!50001 DROP VIEW IF EXISTS `v_pedidos_count_sresposta_nfederativo_poder_uf`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_pedidos_count_sresposta_nfederativo_poder_uf` AS SELECT 
 1 AS `Ativo`,
 1 AS `StatusResposta`,
 1 AS `NomeNivelFederativo`,
 1 AS `NomePoder`,
 1 AS `SiglaUF`,
 1 AS `TotalPedidos`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_pedidos_count_sresposta_orgao`
--

DROP TABLE IF EXISTS `v_pedidos_count_sresposta_orgao`;
/*!50001 DROP VIEW IF EXISTS `v_pedidos_count_sresposta_orgao`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_pedidos_count_sresposta_orgao` AS SELECT 
 1 AS `CodigoPedido`,
 1 AS `StatusResposta`,
 1 AS `CodigoAgente`,
 1 AS `NomeAgente`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_pedidos_count_sresposta_orgao_perc`
--

DROP TABLE IF EXISTS `v_pedidos_count_sresposta_orgao_perc`;
/*!50001 DROP VIEW IF EXISTS `v_pedidos_count_sresposta_orgao_perc`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_pedidos_count_sresposta_orgao_perc` AS SELECT 
 1 AS `NomeAgente`,
 1 AS `StatusResposta`,
 1 AS `TotalPedidosStatusResposta`,
 1 AS `TotalPedidos`*/;
SET character_set_client = @saved_cs_client;

--
-- Dumping routines for database 'tblai'
--
/*!50003 DROP PROCEDURE IF EXISTS `sp_count_total` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE  PROCEDURE `sp_count_total`()
BEGIN

declare SiglaUf varchar(2);
declare NomeNivelFederativo varchar(9);
declare NomePoder varchar(19);

drop temporary table if exists maps;

create temporary table maps as
select SiglaUf, NomeNivelFederativo, NomePoder;

insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('AC', 'Estadual', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('AL', 'Estadual', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('AM', 'Estadual', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('AP', 'Estadual', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('BA', 'Estadual', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('CE', 'Estadual', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('DF', 'Estadual', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('ES', 'Estadual', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('GO', 'Estadual', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('MA', 'Estadual', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('MG', 'Estadual', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('MS', 'Estadual', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('MT', 'Estadual', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PA', 'Estadual', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PB', 'Estadual', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PE', 'Estadual', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PI', 'Estadual', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PR', 'Estadual', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RJ', 'Estadual', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RN', 'Estadual', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RO', 'Estadual', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RR', 'Estadual', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RS', 'Estadual', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('SC', 'Estadual', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('SE', 'Estadual', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('SP', 'Estadual', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('TO', 'Estadual', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('AC', 'Estadual', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('AL', 'Estadual', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('AM', 'Estadual', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('AP', 'Estadual', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('BA', 'Estadual', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('CE', 'Estadual', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('DF', 'Estadual', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('ES', 'Estadual', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('GO', 'Estadual', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('MA', 'Estadual', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('MG', 'Estadual', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('MS', 'Estadual', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('MT', 'Estadual', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PA', 'Estadual', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PB', 'Estadual', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PE', 'Estadual', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PI', 'Estadual', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PR', 'Estadual', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RJ', 'Estadual', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RN', 'Estadual', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RO', 'Estadual', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RR', 'Estadual', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RS', 'Estadual', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('SC', 'Estadual', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('SE', 'Estadual', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('SP', 'Estadual', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('TO', 'Estadual', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('AC', 'Estadual', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('AL', 'Estadual', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('AM', 'Estadual', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('AP', 'Estadual', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('BA', 'Estadual', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('CE', 'Estadual', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('DF', 'Estadual', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('ES', 'Estadual', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('GO', 'Estadual', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('MA', 'Estadual', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('MG', 'Estadual', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('MS', 'Estadual', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('MT', 'Estadual', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PA', 'Estadual', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PB', 'Estadual', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PE', 'Estadual', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PI', 'Estadual', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PR', 'Estadual', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RJ', 'Estadual', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RN', 'Estadual', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RO', 'Estadual', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RR', 'Estadual', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RS', 'Estadual', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('SC', 'Estadual', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('SE', 'Estadual', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('SP', 'Estadual', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('TO', 'Estadual', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('AC', 'Estadual', 'Ministério Público');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('AL', 'Estadual', 'Ministério Público');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('AM', 'Estadual', 'Ministério Público');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('AP', 'Estadual', 'Ministério Público');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('BA', 'Estadual', 'Ministério Público');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('CE', 'Estadual', 'Ministério Público');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('DF', 'Estadual', 'Ministério Público');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('ES', 'Estadual', 'Ministério Público');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('GO', 'Estadual', 'Ministério Público');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('MA', 'Estadual', 'Ministério Público');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('MG', 'Estadual', 'Ministério Público');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('MS', 'Estadual', 'Ministério Público');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('MT', 'Estadual', 'Ministério Público');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PA', 'Estadual', 'Ministério Público');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PB', 'Estadual', 'Ministério Público');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PE', 'Estadual', 'Ministério Público');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PI', 'Estadual', 'Ministério Público');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PR', 'Estadual', 'Ministério Público');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RJ', 'Estadual', 'Ministério Público');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RN', 'Estadual', 'Ministério Público');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RO', 'Estadual', 'Ministério Público');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RR', 'Estadual', 'Ministério Público');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RS', 'Estadual', 'Ministério Público');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('SC', 'Estadual', 'Ministério Público');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('SE', 'Estadual', 'Ministério Público');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('SP', 'Estadual', 'Ministério Público');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('TO', 'Estadual', 'Ministério Público');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('AC', 'Estadual', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('AL', 'Estadual', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('AM', 'Estadual', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('AP', 'Estadual', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('BA', 'Estadual', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('CE', 'Estadual', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('DF', 'Estadual', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('ES', 'Estadual', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('GO', 'Estadual', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('MA', 'Estadual', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('MG', 'Estadual', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('MS', 'Estadual', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('MT', 'Estadual', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PA', 'Estadual', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PB', 'Estadual', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PE', 'Estadual', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PI', 'Estadual', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PR', 'Estadual', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RJ', 'Estadual', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RN', 'Estadual', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RO', 'Estadual', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RR', 'Estadual', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RS', 'Estadual', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('SC', 'Estadual', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('SE', 'Estadual', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('SP', 'Estadual', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('TO', 'Estadual', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('AC', 'Municipal', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('AL', 'Municipal', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('AM', 'Municipal', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('AP', 'Municipal', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('BA', 'Municipal', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('CE', 'Municipal', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('DF', 'Municipal', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('ES', 'Municipal', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('GO', 'Municipal', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('MA', 'Municipal', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('MG', 'Municipal', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('MS', 'Municipal', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('MT', 'Municipal', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PA', 'Municipal', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PB', 'Municipal', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PE', 'Municipal', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PI', 'Municipal', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PR', 'Municipal', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RJ', 'Municipal', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RN', 'Municipal', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RO', 'Municipal', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RR', 'Municipal', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RS', 'Municipal', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('SC', 'Municipal', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('SE', 'Municipal', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('SP', 'Municipal', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('TO', 'Municipal', 'Executivo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('AC', 'Municipal', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('AL', 'Municipal', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('AM', 'Municipal', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('AP', 'Municipal', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('BA', 'Municipal', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('CE', 'Municipal', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('DF', 'Municipal', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('ES', 'Municipal', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('GO', 'Municipal', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('MA', 'Municipal', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('MG', 'Municipal', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('MS', 'Municipal', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('MT', 'Municipal', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PA', 'Municipal', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PB', 'Municipal', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PE', 'Municipal', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PI', 'Municipal', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PR', 'Municipal', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RJ', 'Municipal', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RN', 'Municipal', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RO', 'Municipal', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RR', 'Municipal', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RS', 'Municipal', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('SC', 'Municipal', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('SE', 'Municipal', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('SP', 'Municipal', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('TO', 'Municipal', 'Judiciário');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('AC', 'Municipal', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('AL', 'Municipal', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('AM', 'Municipal', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('AP', 'Municipal', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('BA', 'Municipal', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('CE', 'Municipal', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('DF', 'Municipal', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('ES', 'Municipal', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('GO', 'Municipal', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('MA', 'Municipal', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('MG', 'Municipal', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('MS', 'Municipal', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('MT', 'Municipal', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PA', 'Municipal', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PB', 'Municipal', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PE', 'Municipal', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PI', 'Municipal', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PR', 'Municipal', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RJ', 'Municipal', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RN', 'Municipal', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RO', 'Municipal', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RR', 'Municipal', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RS', 'Municipal', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('SC', 'Municipal', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('SE', 'Municipal', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('SP', 'Municipal', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('TO', 'Municipal', 'Legislativo');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('AC', 'Municipal', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('AL', 'Municipal', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('AM', 'Municipal', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('AP', 'Municipal', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('BA', 'Municipal', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('CE', 'Municipal', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('DF', 'Municipal', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('ES', 'Municipal', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('GO', 'Municipal', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('MA', 'Municipal', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('MG', 'Municipal', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('MS', 'Municipal', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('MT', 'Municipal', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PA', 'Municipal', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PB', 'Municipal', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PE', 'Municipal', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PI', 'Municipal', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('PR', 'Municipal', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RJ', 'Municipal', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RN', 'Municipal', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RO', 'Municipal', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RR', 'Municipal', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('RS', 'Municipal', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('SC', 'Municipal', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('SE', 'Municipal', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('SP', 'Municipal', 'Tribunais de Contas');
insert into maps (SiglaUf, NomeNivelFederativo, NomePoder) values ('TO', 'Municipal', 'Tribunais de Contas');

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Final view structure for view `v_count_total`
--

/*!50001 DROP VIEW IF EXISTS `v_count_total`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `v_count_total` AS select `v_pedidos_count_sresposta_nfederativo_poder_uf`.`Ativo` AS `Ativo`,`v_pedidos_count_sresposta_nfederativo_poder_uf`.`NomeNivelFederativo` AS `NomeNivelFederativo`,`v_pedidos_count_sresposta_nfederativo_poder_uf`.`NomePoder` AS `NomePoder`,`v_pedidos_count_sresposta_nfederativo_poder_uf`.`SiglaUF` AS `SiglaUF`,sum(`v_pedidos_count_sresposta_nfederativo_poder_uf`.`TotalPedidos`) AS `Total` from `v_pedidos_count_sresposta_nfederativo_poder_uf` group by `v_pedidos_count_sresposta_nfederativo_poder_uf`.`Ativo`,`v_pedidos_count_sresposta_nfederativo_poder_uf`.`NomeNivelFederativo`,`v_pedidos_count_sresposta_nfederativo_poder_uf`.`NomePoder`,`v_pedidos_count_sresposta_nfederativo_poder_uf`.`SiglaUF` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_count_total_nao_respondido`
--

/*!50001 DROP VIEW IF EXISTS `v_count_total_nao_respondido`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `v_count_total_nao_respondido` AS select `v_pedidos_count_sresposta_nfederativo_poder_uf`.`Ativo` AS `Ativo`,`v_pedidos_count_sresposta_nfederativo_poder_uf`.`StatusResposta` AS `StatusResposta`,`v_pedidos_count_sresposta_nfederativo_poder_uf`.`NomeNivelFederativo` AS `NomeNivelFederativo`,`v_pedidos_count_sresposta_nfederativo_poder_uf`.`NomePoder` AS `NomePoder`,`v_pedidos_count_sresposta_nfederativo_poder_uf`.`SiglaUF` AS `SiglaUF`,`v_pedidos_count_sresposta_nfederativo_poder_uf`.`TotalPedidos` AS `TotalPedidos` from `v_pedidos_count_sresposta_nfederativo_poder_uf` where (`v_pedidos_count_sresposta_nfederativo_poder_uf`.`StatusResposta` = 'Não respondido') */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_count_total_respondido`
--

/*!50001 DROP VIEW IF EXISTS `v_count_total_respondido`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `v_count_total_respondido` AS select `v_pedidos_count_sresposta_nfederativo_poder_uf`.`Ativo` AS `Ativo`,`v_pedidos_count_sresposta_nfederativo_poder_uf`.`StatusResposta` AS `StatusResposta`,`v_pedidos_count_sresposta_nfederativo_poder_uf`.`NomeNivelFederativo` AS `NomeNivelFederativo`,`v_pedidos_count_sresposta_nfederativo_poder_uf`.`NomePoder` AS `NomePoder`,`v_pedidos_count_sresposta_nfederativo_poder_uf`.`SiglaUF` AS `SiglaUF`,`v_pedidos_count_sresposta_nfederativo_poder_uf`.`TotalPedidos` AS `TotalPedidos` from `v_pedidos_count_sresposta_nfederativo_poder_uf` where (`v_pedidos_count_sresposta_nfederativo_poder_uf`.`StatusResposta` = 'Respondido') */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_pedidos_ativos_groups`
--

/*!50001 DROP VIEW IF EXISTS `v_pedidos_ativos_groups`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `v_pedidos_ativos_groups` AS select `p`.`Codigo` AS `CodigoPedido`,`p`.`Ativo` AS `Ativo`,`p`.`DataEnvio` AS `DataEnvio`,`ag`.`CodigoNivelFederativo` AS `CodigoNivelFederativo`,`nf`.`Nome` AS `NomeNivelFederativo`,`ag`.`CodigoPoder` AS `CodigoPoder`,`pd`.`Nome` AS `NomePoder`,`ag`.`CodigoUF` AS `CodigoUF`,(case when (isnull(`ag`.`CodigoUF`) and (`ag`.`CodigoNivelFederativo` = 1)) then 'BR' when (isnull(`ag`.`CodigoUF`) and (`ag`.`CodigoNivelFederativo` <> 1)) then 'INDEFINIDO' else `uf`.`Sigla` end) AS `SiglaUF` from ((((`pedidos` `p` left join `agentes` `ag` on((`p`.`CodigoAgente` = `ag`.`Codigo`))) left join `tipo_poder` `pd` on((`ag`.`CodigoPoder` = `pd`.`Codigo`))) left join `tipo_nivel_federativo` `nf` on((`ag`.`CodigoNivelFederativo` = `nf`.`Codigo`))) left join `uf` on((`ag`.`CodigoUF` = `uf`.`Codigo`))) where ((`p`.`Ativo` = 1) and ((`ag`.`CodigoUF` is not null) or (`ag`.`CodigoNivelFederativo` = 1)) and (isnull(`ag`.`CodigoUF`) or (`ag`.`CodigoNivelFederativo` <> 1))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_pedidos_ativos_status_resposta`
--

/*!50001 DROP VIEW IF EXISTS `v_pedidos_ativos_status_resposta`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `v_pedidos_ativos_status_resposta` AS select `vpa_gr`.`CodigoPedido` AS `CodigoPedido`,`vpa_gr`.`DataEnvio` AS `DataEnvio`,`vpa_gr`.`Ativo` AS `Ativo`,(case when (`vpa_str`.`CodigoPedido` is not null) then 'Respondido' when (`vpa_stnr`.`CodigoPedido` is not null) then 'Não respondido' when (`vpa_sti`.`CodigoPedido` is not null) then 'Não respondido' end) AS `StatusResposta` from (((`v_pedidos_ativos_groups` `vpa_gr` left join `v_pedidos_ativos_status_resposta_respondido` `vpa_str` on((`vpa_gr`.`CodigoPedido` = `vpa_str`.`CodigoPedido`))) left join `v_pedidos_ativos_status_resposta_nao_respondido` `vpa_stnr` on((`vpa_gr`.`CodigoPedido` = `vpa_stnr`.`CodigoPedido`))) left join `v_pedidos_ativos_status_resposta_ignorado` `vpa_sti` on((`vpa_gr`.`CodigoPedido` = `vpa_sti`.`CodigoPedido`))) where (year(`vpa_gr`.`DataEnvio`) between 2011 and year(curdate())) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_pedidos_ativos_status_resposta_ignorado`
--

/*!50001 DROP VIEW IF EXISTS `v_pedidos_ativos_status_resposta_ignorado`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `v_pedidos_ativos_status_resposta_ignorado` AS select distinct `pi`.`CodigoPedido` AS `CodigoPedido`,`vpa_gr`.`Ativo` AS `Ativo`,`vpa_gr`.`DataEnvio` AS `DataEnvio`,'Não respondido - com reclamação ou recurso ignorado' AS `StatusResposta` from (`pedidos_interacoes` `pi` left join `v_pedidos_ativos_groups` `vpa_gr` on((`pi`.`CodigoPedido` = `vpa_gr`.`CodigoPedido`))) where ((`pi`.`CodigoTipoPedidoResposta` in (2,4,6,8,10)) and (not(exists(select `pi2`.`CodigoPedido` from `pedidos_interacoes` `pi2` where ((`pi2`.`CodigoTipoPedidoResposta` in (1,3,5,7,9,11)) and (`pi`.`CodigoPedido` = `pi2`.`CodigoPedido`)))))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_pedidos_ativos_status_resposta_nao_respondido`
--

/*!50001 DROP VIEW IF EXISTS `v_pedidos_ativos_status_resposta_nao_respondido`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `v_pedidos_ativos_status_resposta_nao_respondido` AS select `p`.`Codigo` AS `CodigoPedido`,`p`.`Ativo` AS `Ativo`,`p`.`DataEnvio` AS `DataEnvio`,(case when ((to_days(curdate()) - to_days(`p`.`DataEnvio`)) > 28) then 'Não respondido - prazo encerrado' else 'Não respondido - em tramitação' end) AS `StatusResposta` from (`pedidos` `p` left join `pedidos_interacoes` `pi` on((`p`.`Codigo` = `pi`.`CodigoPedido`))) where (isnull(`pi`.`CodigoPedido`) and (`p`.`Ativo` = 1)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_pedidos_ativos_status_resposta_respondido`
--

/*!50001 DROP VIEW IF EXISTS `v_pedidos_ativos_status_resposta_respondido`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `v_pedidos_ativos_status_resposta_respondido` AS select distinct `vpa_gr`.`CodigoPedido` AS `CodigoPedido`,`vpa_gr`.`Ativo` AS `Ativo`,`vpa_gr`.`DataEnvio` AS `DataEnvio`,'Respondido' AS `StatusResposta` from (`v_pedidos_ativos_groups` `vpa_gr` left join `pedidos_interacoes` `pi` on((`pi`.`CodigoPedido` = `vpa_gr`.`CodigoPedido`))) where (`pi`.`CodigoTipoPedidoResposta` in (1,3,5,7,9,11)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_pedidos_count_dias_resposta`
--

/*!50001 DROP VIEW IF EXISTS `v_pedidos_count_dias_resposta`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `v_pedidos_count_dias_resposta` AS select `p`.`Codigo` AS `CodigoPedido`,`p`.`DataEnvio` AS `DataEnvio`,`pi`.`DataResposta` AS `DataResposta`,`pd`.`Nome` AS `NomeEsferaPoder`,`nf`.`Nome` AS `NomeNivelFederativo`,(to_days(`pi`.`DataResposta`) - to_days(`p`.`DataEnvio`)) AS `DiasCorridos` from ((((`pedidos` `p` left join `pedidos_interacoes` `pi` on((`p`.`Codigo` = `pi`.`CodigoPedido`))) left join `agentes` `a` on((`p`.`CodigoAgente` = `a`.`Codigo`))) left join `tipo_poder` `pd` on((`a`.`CodigoPoder` = `pd`.`Codigo`))) left join `tipo_nivel_federativo` `nf` on((`a`.`CodigoNivelFederativo` = `nf`.`Codigo`))) where ((`pi`.`CodigoTipoPedidoResposta` = 1) and (`p`.`Ativo` = 1)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_pedidos_count_orgao`
--

/*!50001 DROP VIEW IF EXISTS `v_pedidos_count_orgao`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `v_pedidos_count_orgao` AS select `v_pedidos_count_sresposta_orgao`.`CodigoAgente` AS `CodigoAgente`,`v_pedidos_count_sresposta_orgao`.`NomeAgente` AS `NomeAgente`,count(0) AS `TotalPedidos` from `v_pedidos_count_sresposta_orgao` group by `v_pedidos_count_sresposta_orgao`.`CodigoAgente` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_pedidos_count_sresposta`
--

/*!50001 DROP VIEW IF EXISTS `v_pedidos_count_sresposta`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `v_pedidos_count_sresposta` AS select distinct `v_pedidos_ativos_status_resposta`.`StatusResposta` AS `StatusResposta`,count(`v_pedidos_ativos_status_resposta`.`StatusResposta`) AS `TotalPedidos` from `v_pedidos_ativos_status_resposta` group by `v_pedidos_ativos_status_resposta`.`StatusResposta` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_pedidos_count_sresposta_nfederativo_poder_uf`
--

/*!50001 DROP VIEW IF EXISTS `v_pedidos_count_sresposta_nfederativo_poder_uf`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `v_pedidos_count_sresposta_nfederativo_poder_uf` AS select `pa`.`Ativo` AS `Ativo`,`st`.`StatusResposta` AS `StatusResposta`,`pa`.`NomeNivelFederativo` AS `NomeNivelFederativo`,`pa`.`NomePoder` AS `NomePoder`,`pa`.`SiglaUF` AS `SiglaUF`,count(`pa`.`SiglaUF`) AS `TotalPedidos` from (`v_pedidos_ativos_groups` `pa` join `v_pedidos_ativos_status_resposta` `st` on((`pa`.`CodigoPedido` = `st`.`CodigoPedido`))) group by `st`.`StatusResposta`,`pa`.`NomeNivelFederativo`,`pa`.`NomePoder`,`pa`.`SiglaUF` order by `st`.`StatusResposta`,`pa`.`NomeNivelFederativo`,`pa`.`NomePoder`,`pa`.`SiglaUF` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_pedidos_count_sresposta_orgao`
--

/*!50001 DROP VIEW IF EXISTS `v_pedidos_count_sresposta_orgao`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `v_pedidos_count_sresposta_orgao` AS select `v`.`CodigoPedido` AS `CodigoPedido`,`v`.`StatusResposta` AS `StatusResposta`,`p`.`CodigoAgente` AS `CodigoAgente`,`a`.`Nome` AS `NomeAgente` from ((`v_pedidos_ativos_status_resposta` `v` left join `pedidos` `p` on((`v`.`CodigoPedido` = `p`.`Codigo`))) left join `agentes` `a` on((`p`.`CodigoAgente` = `a`.`Codigo`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_pedidos_count_sresposta_orgao_perc`
--

/*!50001 DROP VIEW IF EXISTS `v_pedidos_count_sresposta_orgao_perc`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `v_pedidos_count_sresposta_orgao_perc` AS select `vr`.`NomeAgente` AS `NomeAgente`,`vr`.`StatusResposta` AS `StatusResposta`,count(`vr`.`StatusResposta`) AS `TotalPedidosStatusResposta`,`vo`.`TotalPedidos` AS `TotalPedidos` from (`v_pedidos_count_sresposta_orgao` `vr` left join `v_pedidos_count_orgao` `vo` on((`vr`.`CodigoAgente` = `vo`.`CodigoAgente`))) group by `vr`.`CodigoAgente`,`vr`.`StatusResposta` having (not((`vr`.`NomeAgente` like '%Valida%'))) order by `vr`.`NomeAgente` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-07-29 19:58:42
