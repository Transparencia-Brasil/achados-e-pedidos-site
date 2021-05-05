-- MySQL dump 10.13  Distrib 5.6.47, for Linux (x86_64)
--
-- Host: localhost    Database: tblai
-- ------------------------------------------------------
-- Server version	5.6.47

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `agentes`
--

DROP TABLE IF EXISTS `agentes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agentes` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `CodigoPoder` int(11) NOT NULL,
  `CodigoNivelFederativo` int(11) NOT NULL,
  `CodigoUF` int(11) DEFAULT NULL,
  `CodigoPai` int(11) DEFAULT NULL,
  `CodigoCidade` int(11) DEFAULT NULL,
  `CriadoExternamente` int(11) DEFAULT '0',
  `Nome` varchar(1000) DEFAULT NULL,
  `Slug` varchar(1500) DEFAULT NULL,
  `Descricao` varchar(2000) DEFAULT NULL,
  `Link` varchar(300) DEFAULT NULL,
  `Ativo` int(11) DEFAULT '1',
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Alteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `fk_agente_nivelfederativo` (`CodigoNivelFederativo`),
  KEY `fk_agente_poder` (`CodigoPoder`),
  KEY `fk_agente_cidade` (`CodigoCidade`),
  KEY `CodigoUF` (`CodigoUF`),
  FULLTEXT KEY `agentes_index` (`Nome`),
  CONSTRAINT `agentes_ibfk_1` FOREIGN KEY (`CodigoUF`) REFERENCES `uf` (`Codigo`),
  CONSTRAINT `fk_agente_cidade` FOREIGN KEY (`CodigoCidade`) REFERENCES `cidade` (`Codigo`),
  CONSTRAINT `fk_agente_nivelfederativo` FOREIGN KEY (`CodigoNivelFederativo`) REFERENCES `tipo_nivel_federativo` (`Codigo`),
  CONSTRAINT `fk_agente_poder` FOREIGN KEY (`CodigoPoder`) REFERENCES `tipo_poder` (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=12136 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `agentes_categorias`
--

DROP TABLE IF EXISTS `agentes_categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agentes_categorias` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `CodigoAgenteCategoria` int(11) NOT NULL,
  `CodigoAgente` int(11) NOT NULL,
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Alteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `fk_agentecategorias_categoria` (`CodigoAgenteCategoria`),
  KEY `fk_agentecategorias_agente` (`CodigoAgente`),
  CONSTRAINT `fk_agentecategorias_agente` FOREIGN KEY (`CodigoAgente`) REFERENCES `agentes` (`Codigo`),
  CONSTRAINT `fk_agentecategorias_categoria` FOREIGN KEY (`CodigoAgenteCategoria`) REFERENCES `agentes_categorias` (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `avaliacoes`
--

DROP TABLE IF EXISTS `avaliacoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `avaliacoes` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `CodigoTipoObjeto` int(11) NOT NULL,
  `CodigoUsuario` int(11) NOT NULL,
  `CodigoObjeto` int(11) NOT NULL,
  `Nota` int(11) NOT NULL,
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Alteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `fk_avaliacoes_usuario` (`CodigoUsuario`),
  KEY `fk_avaliacoes_tipoobjeto` (`CodigoTipoObjeto`),
  CONSTRAINT `fk_avaliacoes_tipoobjeto` FOREIGN KEY (`CodigoTipoObjeto`) REFERENCES `tipo_objeto` (`Codigo`),
  CONSTRAINT `fk_avaliacoes_usuario` FOREIGN KEY (`CodigoUsuario`) REFERENCES `usuarios` (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cidade`
--

DROP TABLE IF EXISTS `cidade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cidade` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `CodigoUF` int(11) NOT NULL,
  `Nome` varchar(200) NOT NULL,
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Alteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `fk_cidade_uf` (`CodigoUF`),
  CONSTRAINT `fk_cidade_uf` FOREIGN KEY (`CodigoUF`) REFERENCES `uf` (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=5582 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `comentarios`
--

DROP TABLE IF EXISTS `comentarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comentarios` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `CodigoTipoObjeto` int(11) NOT NULL,
  `CodigoUsuario` int(11) NOT NULL,
  `CodigoObjeto` int(11) NOT NULL,
  `Texto` varchar(1000) DEFAULT NULL,
  `Ativo` int(11) NOT NULL DEFAULT '1',
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Alteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `fk_comentarios_usuario` (`CodigoUsuario`),
  KEY `fk_comentarios_tipoobjeto` (`CodigoTipoObjeto`),
  CONSTRAINT `fk_comentarios_tipoobjeto` FOREIGN KEY (`CodigoTipoObjeto`) REFERENCES `tipo_objeto` (`Codigo`),
  CONSTRAINT `fk_comentarios_usuario` FOREIGN KEY (`CodigoUsuario`) REFERENCES `usuarios` (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contador_acesso`
--

DROP TABLE IF EXISTS `contador_acesso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contador_acesso` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `CodigoTipoObjeto` int(11) NOT NULL,
  `IP` varchar(20) DEFAULT NULL,
  `CodigoUsuario` int(11) NOT NULL,
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Alteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contatos`
--

DROP TABLE IF EXISTS `contatos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contatos` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Assunto` varchar(100) NOT NULL,
  `Mensagem` varchar(3000) NOT NULL,
  `Respondido` int(11) DEFAULT '0',
  `AceitouNovidades` int(11) DEFAULT '0',
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=2196 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cursos`
--

DROP TABLE IF EXISTS `cursos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cursos` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `CodigoTipoCurso` int(11) NOT NULL,
  `Nome` varchar(200) NOT NULL,
  `DataCurso` datetime DEFAULT NULL,
  `Titulo` varchar(150) NOT NULL,
  `Descricao` varchar(1000) NOT NULL,
  `Duracao` varchar(500) DEFAULT NULL,
  `NumeroAlunos` varchar(100) DEFAULT NULL,
  `Endereco` varchar(800) DEFAULT NULL,
  `Link` varchar(800) DEFAULT NULL,
  `CodigoUF` int(11) DEFAULT NULL,
  `CodigoCidade` int(11) DEFAULT NULL,
  `Ativo` int(11) DEFAULT '1',
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Alteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `fk_curso_tipo` (`CodigoTipoCurso`),
  KEY `fk_curso_uf` (`CodigoUF`),
  KEY `fk_curso_cidade` (`CodigoCidade`),
  CONSTRAINT `fk_curso_cidade` FOREIGN KEY (`CodigoCidade`) REFERENCES `cidade` (`Codigo`),
  CONSTRAINT `fk_curso_tipo` FOREIGN KEY (`CodigoTipoCurso`) REFERENCES `tipo_curso` (`Codigo`),
  CONSTRAINT `fk_curso_uf` FOREIGN KEY (`CodigoUF`) REFERENCES `uf` (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `destaques_home`
--

DROP TABLE IF EXISTS `destaques_home`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `destaques_home` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `CodigoTipoDestaqueHome` int(11) NOT NULL,
  `CodigoTargetTipo` int(11) NOT NULL,
  `Link` varchar(350) DEFAULT NULL,
  `Imagem` varchar(100) DEFAULT NULL,
  `Nome` varchar(250) DEFAULT NULL,
  `Resumo` varchar(300) DEFAULT NULL,
  `Inicio` datetime DEFAULT NULL,
  `Termino` datetime DEFAULT NULL,
  `Ativo` int(11) DEFAULT '0',
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Alteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `fk_tipo_destaquetipo` (`CodigoTipoDestaqueHome`),
  KEY `fk_tipo_destaquetipo_targettarget` (`CodigoTargetTipo`),
  CONSTRAINT `fk_tipo_destaquetipo` FOREIGN KEY (`CodigoTipoDestaqueHome`) REFERENCES `tipo_destaques_home` (`Codigo`),
  CONSTRAINT `fk_tipo_destaquetipo_targettarget` FOREIGN KEY (`CodigoTargetTipo`) REFERENCES `tipo_target` (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `destaques_tipo`
--

DROP TABLE IF EXISTS `destaques_tipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `destaques_tipo` (
  `Codigo` smallint(6) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(100) NOT NULL,
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Alteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `documentos`
--

DROP TABLE IF EXISTS `documentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documentos` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `CodigoTipoDocumento` int(11) NOT NULL,
  `Valor` varchar(100) DEFAULT NULL,
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Codigo`),
  KEY `fk_documentos_tipoDocumento` (`CodigoTipoDocumento`),
  CONSTRAINT `fk_documentos_tipoDocumento` FOREIGN KEY (`CodigoTipoDocumento`) REFERENCES `tipo_documento` (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=404 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `es_pedidos`
--

DROP TABLE IF EXISTS `es_pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `es_pedidos` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `CodigoPedido` int(11) NOT NULL,
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Alteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `fk_es_pedidos` (`CodigoPedido`),
  CONSTRAINT `es_pedidos_ibfk_1` FOREIGN KEY (`CodigoPedido`) REFERENCES `pedidos` (`Codigo`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=345189 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `es_pedidos_anexos`
--

DROP TABLE IF EXISTS `es_pedidos_anexos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `es_pedidos_anexos` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `CodigoPedidoAnexo` int(11) NOT NULL,
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Alteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `fk_es_pedidos_anexos` (`CodigoPedidoAnexo`),
  CONSTRAINT `es_pedidos_anexos_ibfk_1` FOREIGN KEY (`CodigoPedidoAnexo`) REFERENCES `pedidos_anexos` (`Codigo`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=94729 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `es_pedidos_interacoes`
--

DROP TABLE IF EXISTS `es_pedidos_interacoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `es_pedidos_interacoes` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `CodigoPedidoInteracao` int(11) NOT NULL,
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Alteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `fk_es_pedidos_interacoes` (`CodigoPedidoInteracao`),
  CONSTRAINT `es_pedidos_interacoes_ibfk_1` FOREIGN KEY (`CodigoPedidoInteracao`) REFERENCES `pedidos_interacoes` (`Codigo`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=148614 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `faq_categoria`
--

DROP TABLE IF EXISTS `faq_categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faq_categoria` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(150) NOT NULL,
  `Ativo` int(11) DEFAULT '1',
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `faq_pergunta`
--

DROP TABLE IF EXISTS `faq_pergunta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faq_pergunta` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `CodigoFaqCategoria` int(11) NOT NULL,
  `Pergunta` varchar(300) NOT NULL,
  `Ativo` int(11) DEFAULT '1',
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Codigo`),
  KEY `fk_faqpergunta_categoria` (`CodigoFaqCategoria`),
  CONSTRAINT `fk_faqpergunta_categoria` FOREIGN KEY (`CodigoFaqCategoria`) REFERENCES `faq_categoria` (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `faq_resposta`
--

DROP TABLE IF EXISTS `faq_resposta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faq_resposta` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `CodigoFaqPergunta` int(11) NOT NULL,
  `Resposta` varchar(8000) NOT NULL,
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Ativo` int(11) DEFAULT '1',
  `Alteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `fk_faqresposta_pergunta` (`CodigoFaqPergunta`),
  CONSTRAINT `fk_faqresposta_pergunta` FOREIGN KEY (`CodigoFaqPergunta`) REFERENCES `faq_pergunta` (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `logs_erro`
--

DROP TABLE IF EXISTS `logs_erro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logs_erro` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `Pagina` varchar(100) DEFAULT NULL,
  `Browser` varchar(100) DEFAULT NULL,
  `Mensagem` varchar(100) DEFAULT NULL,
  `Stack` varchar(1000) DEFAULT NULL,
  `Variaveis` varchar(500) DEFAULT NULL,
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `moderacao_status`
--

DROP TABLE IF EXISTS `moderacao_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `moderacao_status` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(150) NOT NULL,
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `moderacoes`
--

DROP TABLE IF EXISTS `moderacoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `moderacoes` (
  `Codigo` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `CodigoTipoObjeto` int(11) NOT NULL,
  `CodigoStatusModeracao` int(11) NOT NULL,
  `CodigoObjeto` int(11) NOT NULL,
  `CodigoUsuario` int(11) DEFAULT NULL,
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Alteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=169643 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `moderacoes_historico`
--

DROP TABLE IF EXISTS `moderacoes_historico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `moderacoes_historico` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `CodigoModeracao` int(11) NOT NULL,
  `CodigoStatusModeracao` int(11) NOT NULL,
  `CodigoUsuarioAdmin` int(11) NOT NULL,
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `na_midia`
--

DROP TABLE IF EXISTS `na_midia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `na_midia` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `Slug` varchar(500) NOT NULL,
  `NomeInterno` varchar(500) NOT NULL,
  `Titulo` varchar(500) NOT NULL,
  `Subtitulo` varchar(500) DEFAULT NULL,
  `HTML` text,
  `Link` varchar(800) DEFAULT NULL,
  `Autor` varchar(300) DEFAULT NULL,
  `ImagemResumo` varchar(300) DEFAULT NULL,
  `ImagemThumb` varchar(300) DEFAULT NULL,
  `Publicacao` datetime NOT NULL,
  `InicioExibicao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `TerminoExibicao` datetime DEFAULT NULL,
  `Ativo` int(11) DEFAULT '1',
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Alteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `newsletters`
--

DROP TABLE IF EXISTS `newsletters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `newsletters` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Apelido` varchar(100) DEFAULT NULL,
  `Ativo` bit(1) NOT NULL DEFAULT b'1',
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Alteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=861 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pais`
--

DROP TABLE IF EXISTS `pais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pais` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(150) NOT NULL,
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=253 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pedido_estagio`
--

DROP TABLE IF EXISTS `pedido_estagio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pedido_estagio` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(150) NOT NULL,
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pedido_status_interno`
--

DROP TABLE IF EXISTS `pedido_status_interno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pedido_status_interno` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(150) NOT NULL,
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pedidos` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `CodigoUsuario` int(11) NOT NULL,
  `CodigoAgente` int(11) NOT NULL,
  `CodigoTipoOrigem` int(11) NOT NULL,
  `CodigoTipoPedidoSituacao` int(11) NOT NULL,
  `CodigoStatusPedido` int(11) NOT NULL,
  `CodigoStatusPedidoInterno` int(11) NOT NULL,
  `IdentificadorExterno` varchar(150) DEFAULT NULL,
  `Protocolo` varchar(200) DEFAULT NULL,
  `Titulo` varchar(250) DEFAULT NULL,
  `Slug` varchar(300) DEFAULT NULL,
  `Descricao` longtext,
  `DataEnvio` datetime DEFAULT NULL,
  `FoiProrrogado` int(11) DEFAULT '0',
  `Anonimo` int(11) DEFAULT '0',
  `Ativo` int(11) DEFAULT '1',
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Alteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`Codigo`),
  UNIQUE KEY `CodigoAgente` (`CodigoAgente`,`Protocolo`,`Titulo`,`Slug`),
  KEY `fk_pedidos_usuario` (`CodigoUsuario`),
  KEY `fk_pedidos_agente` (`CodigoAgente`),
  KEY `fk_pedidos_tipopedidoorigem` (`CodigoTipoOrigem`),
  KEY `fk_pedidos_statuspedido` (`CodigoStatusPedido`),
  KEY `fk_pedidos_statuspedidointerno` (`CodigoStatusPedidoInterno`),
  KEY `fk_pedidos_tiposituacao` (`CodigoTipoPedidoSituacao`),
  CONSTRAINT `fk_pedidos_agente` FOREIGN KEY (`CodigoAgente`) REFERENCES `agentes` (`Codigo`),
  CONSTRAINT `fk_pedidos_statuspedido` FOREIGN KEY (`CodigoStatusPedido`) REFERENCES `status_pedido` (`Codigo`),
  CONSTRAINT `fk_pedidos_statuspedidointerno` FOREIGN KEY (`CodigoStatusPedidoInterno`) REFERENCES `status_pedido` (`Codigo`),
  CONSTRAINT `fk_pedidos_tipopedidoorigem` FOREIGN KEY (`CodigoTipoOrigem`) REFERENCES `tipo_pedido_origem` (`Codigo`),
  CONSTRAINT `fk_pedidos_tiposituacao` FOREIGN KEY (`CodigoTipoPedidoSituacao`) REFERENCES `tipo_pedido_situacao` (`Codigo`),
  CONSTRAINT `fk_pedidos_usuario` FOREIGN KEY (`CodigoUsuario`) REFERENCES `usuarios` (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=199692 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*//*!50003 TRIGGER pedidosModeracoes AFTER INSERT ON pedidos 
 FOR EACH ROW
   BEGIN
    IF NEW.CodigoTipoOrigem = 3 THEN
       insert into moderacoes (CodigoTipoObjeto, CodigoStatusModeracao, CodigoObjeto) VALUES (1, 2, New.Codigo);
    END IF;
  END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `pedidos_anexos`
--

DROP TABLE IF EXISTS `pedidos_anexos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pedidos_anexos` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `CodigoPedidoInteracao` int(11) NOT NULL,
  `ArquivoFullPath` varchar(255) NOT NULL,
  `Ativo` int(11) DEFAULT '1',
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Alteracao` datetime DEFAULT NULL,
  `CodigoStatusExportacaoES` enum('falha','extraido','extraindo','esperando') NOT NULL DEFAULT 'esperando',
  `Arquivo` varchar(255) NOT NULL DEFAULT 'caminho do arquivo',
  `ArquivoFullPathClean` varchar(255) DEFAULT NULL,
  `ArquivoClean` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Codigo`),
  UNIQUE KEY `CodigoPedidoInteracao` (`CodigoPedidoInteracao`,`Arquivo`),
  KEY `fk_pedidoanexo_pedidointeracao` (`CodigoPedidoInteracao`),
  CONSTRAINT `pedidos_anexos_ibfk_1` FOREIGN KEY (`CodigoPedidoInteracao`) REFERENCES `pedidos_interacoes` (`Codigo`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=154472 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pedidos_interacoes`
--

DROP TABLE IF EXISTS `pedidos_interacoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pedidos_interacoes` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `CodigoPedido` int(11) NOT NULL,
  `CodigoTipoPedidoResposta` int(11) NOT NULL,
  `DataResposta` datetime DEFAULT NULL,
  `Descricao` longtext,
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Alteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`Codigo`),
  UNIQUE KEY `CodigoPedido` (`CodigoPedido`,`CodigoTipoPedidoResposta`,`DataResposta`),
  KEY `fk_pedidointeracao_pedido` (`CodigoPedido`),
  KEY `fk_pedidosinteracao_tiporesposta` (`CodigoTipoPedidoResposta`),
  CONSTRAINT `fk_pedidosinteracao_tiporesposta` FOREIGN KEY (`CodigoTipoPedidoResposta`) REFERENCES `tipo_pedido_resposta` (`Codigo`),
  CONSTRAINT `pedidos_interacoes_ibfk_1` FOREIGN KEY (`CodigoPedido`) REFERENCES `pedidos` (`Codigo`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=196416 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pedidos_revisoes`
--

DROP TABLE IF EXISTS `pedidos_revisoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pedidos_revisoes` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `CodigoPedido` int(11) NOT NULL,
  `CodigoUsuario` int(11) NOT NULL,
  `CodigoUsuarioAdmin` int(11) DEFAULT NULL,
  `Texto` varchar(1000) NOT NULL,
  `ObservacaoUsuarioAdmin` varchar(500) DEFAULT NULL,
  `Respondido` int(11) DEFAULT '0',
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Alteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `fk_pedidosrevisao_usuario` (`CodigoUsuario`),
  KEY `fk_pedidosrevisao_pedido` (`CodigoPedido`),
  KEY `fk_pedidosrevisao_usuarioadmin` (`CodigoUsuarioAdmin`),
  CONSTRAINT `fk_pedidosrevisao_pedido` FOREIGN KEY (`CodigoPedido`) REFERENCES `pedidos` (`Codigo`),
  CONSTRAINT `fk_pedidosrevisao_usuario` FOREIGN KEY (`CodigoUsuario`) REFERENCES `usuarios` (`Codigo`),
  CONSTRAINT `fk_pedidosrevisao_usuarioadmin` FOREIGN KEY (`CodigoUsuarioAdmin`) REFERENCES `usuarios_admin` (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `publicacoes`
--

DROP TABLE IF EXISTS `publicacoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `publicacoes` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `CodigoCategoria` int(11) NOT NULL,
  `Nome` varchar(200) NOT NULL,
  `DataPublicacao` datetime NOT NULL,
  `Descricao` varchar(1000) DEFAULT NULL,
  `Arquivo` varchar(100) DEFAULT NULL,
  `PalavrasChave` varchar(500) DEFAULT NULL,
  `Ativo` bit(1) DEFAULT b'1',
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Alteracao` datetime DEFAULT NULL,
  `Link` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `fk_codigo_categoria` (`CodigoCategoria`),
  CONSTRAINT `fk_codigo_categoria` FOREIGN KEY (`CodigoCategoria`) REFERENCES `publicacoes_categoria` (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `publicacoes_categoria`
--

DROP TABLE IF EXISTS `publicacoes_categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `publicacoes_categoria` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(150) NOT NULL,
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `status_pedido`
--

DROP TABLE IF EXISTS `status_pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status_pedido` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(150) NOT NULL,
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tabela_update_tadepe`
--

DROP TABLE IF EXISTS `tabela_update_tadepe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tabela_update_tadepe` (
  `codigo_pedido_anexo` int(11) NOT NULL DEFAULT '0',
  `text_aux` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`codigo_pedido_anexo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tipo_agente_categoria`
--

DROP TABLE IF EXISTS `tipo_agente_categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_agente_categoria` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(150) NOT NULL,
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tipo_curso`
--

DROP TABLE IF EXISTS `tipo_curso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_curso` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(150) NOT NULL,
  `Ativo` int(11) DEFAULT '1',
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tipo_destaques_home`
--

DROP TABLE IF EXISTS `tipo_destaques_home`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_destaques_home` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(100) NOT NULL,
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Alteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tipo_documento`
--

DROP TABLE IF EXISTS `tipo_documento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_documento` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(150) NOT NULL,
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tipo_genero`
--

DROP TABLE IF EXISTS `tipo_genero`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_genero` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(150) NOT NULL,
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tipo_nivel_federativo`
--

DROP TABLE IF EXISTS `tipo_nivel_federativo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_nivel_federativo` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(150) NOT NULL,
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tipo_objeto`
--

DROP TABLE IF EXISTS `tipo_objeto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_objeto` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(150) NOT NULL,
  `Ativo` int(11) DEFAULT '1',
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tipo_ocupacao`
--

DROP TABLE IF EXISTS `tipo_ocupacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_ocupacao` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(150) NOT NULL,
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tipo_pedido_origem`
--

DROP TABLE IF EXISTS `tipo_pedido_origem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_pedido_origem` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(150) NOT NULL,
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tipo_pedido_resposta`
--

DROP TABLE IF EXISTS `tipo_pedido_resposta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_pedido_resposta` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(150) NOT NULL,
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tipo_pedido_situacao`
--

DROP TABLE IF EXISTS `tipo_pedido_situacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_pedido_situacao` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(150) NOT NULL,
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tipo_poder`
--

DROP TABLE IF EXISTS `tipo_poder`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_poder` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(150) NOT NULL,
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Alteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tipo_target`
--

DROP TABLE IF EXISTS `tipo_target`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_target` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(150) NOT NULL,
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tipo_usuario`
--

DROP TABLE IF EXISTS `tipo_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_usuario` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(150) NOT NULL,
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uf`
--

DROP TABLE IF EXISTS `uf`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uf` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `CodigoPais` int(11) NOT NULL,
  `Nome` varchar(200) NOT NULL,
  `Sigla` char(2) NOT NULL,
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Alteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `fk_uf_pais` (`CodigoPais`),
  CONSTRAINT `fk_uf_pais` FOREIGN KEY (`CodigoPais`) REFERENCES `pais` (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `CodigoTipoUsuario` int(11) NOT NULL,
  `Nome` varchar(150) NOT NULL,
  `Email` varchar(150) NOT NULL,
  `Slug` varchar(100) NOT NULL,
  `Senha` varchar(200) NOT NULL,
  `Bloqueado` smallint(6) DEFAULT '0',
  `ChaveRecuperacaoSenha` varchar(500) DEFAULT NULL,
  `DataGeracaoSenha` datetime DEFAULT NULL,
  `Ativo` smallint(6) DEFAULT '1',
  `AceiteComunicacao` smallint(6) DEFAULT '1',
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Alteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `fk_usuarios_tipoUsuario` (`CodigoTipoUsuario`),
  CONSTRAINT `fk_usuarios_tipoUsuario` FOREIGN KEY (`CodigoTipoUsuario`) REFERENCES `tipo_usuario` (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=404 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usuarios_admin`
--

DROP TABLE IF EXISTS `usuarios_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios_admin` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(100) NOT NULL,
  `Login` varchar(100) NOT NULL,
  `Senha` varchar(500) NOT NULL,
  `UltimoAcesso` datetime DEFAULT NULL,
  `ChaveTrocaSenha` varchar(100) DEFAULT NULL,
  `Bloqueado` bit(1) DEFAULT NULL,
  `Ativo` int(11) DEFAULT '1',
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Alteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usuarios_documentos`
--

DROP TABLE IF EXISTS `usuarios_documentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios_documentos` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `CodigoDocumento` int(11) NOT NULL,
  `CodigoUsuario` int(11) NOT NULL,
  `Ativo` smallint(6) DEFAULT '1',
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Alteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `fk_usuarioDocumento_Documento` (`CodigoDocumento`),
  KEY `fk_usuarioDocumento_usuario` (`CodigoUsuario`),
  CONSTRAINT `fk_usuarioDocumento_Documento` FOREIGN KEY (`CodigoDocumento`) REFERENCES `documentos` (`Codigo`),
  CONSTRAINT `fk_usuarioDocumento_usuario` FOREIGN KEY (`CodigoUsuario`) REFERENCES `usuarios` (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=390 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usuarios_perfis`
--

DROP TABLE IF EXISTS `usuarios_perfis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios_perfis` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `CodigoUsuario` int(11) NOT NULL,
  `CodigoTipoGenero` int(11) DEFAULT NULL,
  `CodigoTipoOcupacao` int(11) DEFAULT NULL,
  `CodigoPais` int(11) DEFAULT NULL,
  `CodigoUF` int(11) DEFAULT NULL,
  `CodigoCidade` int(11) DEFAULT NULL,
  `Nascimento` date DEFAULT NULL,
  `Foto` varchar(150) DEFAULT NULL,
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Alteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `fk_usuariosPerfil_TipoGenero` (`CodigoTipoGenero`),
  KEY `fk_usuariosPerfil_TipoOcupacao` (`CodigoTipoOcupacao`),
  KEY `fk_usuariosPerfil_Pais` (`CodigoPais`),
  KEY `fk_usuariosPerfil_UF` (`CodigoUF`),
  KEY `fk_usuariosPerfil_Cidade` (`CodigoCidade`),
  CONSTRAINT `fk_usuariosPerfil_Cidade` FOREIGN KEY (`CodigoCidade`) REFERENCES `cidade` (`Codigo`),
  CONSTRAINT `fk_usuariosPerfil_Pais` FOREIGN KEY (`CodigoPais`) REFERENCES `pais` (`Codigo`),
  CONSTRAINT `fk_usuariosPerfil_TipoGenero` FOREIGN KEY (`CodigoTipoGenero`) REFERENCES `tipo_genero` (`Codigo`),
  CONSTRAINT `fk_usuariosPerfil_TipoOcupacao` FOREIGN KEY (`CodigoTipoOcupacao`) REFERENCES `tipo_ocupacao` (`Codigo`),
  CONSTRAINT `fk_usuariosPerfil_UF` FOREIGN KEY (`CodigoUF`) REFERENCES `uf` (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=368 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usuarios_relacionamentos`
--

DROP TABLE IF EXISTS `usuarios_relacionamentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios_relacionamentos` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `CodigoTipoObjeto` int(11) NOT NULL,
  `CodigoObjeto` int(11) NOT NULL,
  `CodigoUsuario` int(11) NOT NULL,
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Alteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `fk_usuariosrelacionamento_usuario` (`CodigoUsuario`),
  KEY `fk_usuariosrelacionamento_tipoobjeto` (`CodigoTipoObjeto`),
  CONSTRAINT `fk_usuariosrelacionamento_tipoobjeto` FOREIGN KEY (`CodigoTipoObjeto`) REFERENCES `tipo_objeto` (`Codigo`),
  CONSTRAINT `fk_usuariosrelacionamento_usuario` FOREIGN KEY (`CodigoUsuario`) REFERENCES `usuarios` (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usuarios_status`
--

DROP TABLE IF EXISTS `usuarios_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios_status` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(150) NOT NULL,
  `Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
-- Temporary table structure for view `v_pedidos_count_nfederativo`
--

DROP TABLE IF EXISTS `v_pedidos_count_nfederativo`;
/*!50001 DROP VIEW IF EXISTS `v_pedidos_count_nfederativo`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_pedidos_count_nfederativo` AS SELECT 
 1 AS `NomeNivelFederativo`,
 1 AS `TotalPedidos`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_pedidos_count_nfederativo_poder_uf`
--

DROP TABLE IF EXISTS `v_pedidos_count_nfederativo_poder_uf`;
/*!50001 DROP VIEW IF EXISTS `v_pedidos_count_nfederativo_poder_uf`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_pedidos_count_nfederativo_poder_uf` AS SELECT 
 1 AS `NomeNivelFederativo`,
 1 AS `NomePoder`,
 1 AS `SiglaUF`,
 1 AS `TotalPedidos`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_pedidos_count_nfederativo_uf`
--

DROP TABLE IF EXISTS `v_pedidos_count_nfederativo_uf`;
/*!50001 DROP VIEW IF EXISTS `v_pedidos_count_nfederativo_uf`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_pedidos_count_nfederativo_uf` AS SELECT 
 1 AS `NomeNivelFederativo`,
 1 AS `SiglaUF`,
 1 AS `TotalPedidos`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_pedidos_count_poder`
--

DROP TABLE IF EXISTS `v_pedidos_count_poder`;
/*!50001 DROP VIEW IF EXISTS `v_pedidos_count_poder`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_pedidos_count_poder` AS SELECT 
 1 AS `NomePoder`,
 1 AS `TotalPedidos`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_pedidos_count_poder_uf`
--

DROP TABLE IF EXISTS `v_pedidos_count_poder_uf`;
/*!50001 DROP VIEW IF EXISTS `v_pedidos_count_poder_uf`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_pedidos_count_poder_uf` AS SELECT 
 1 AS `NomePoder`,
 1 AS `SiglaUF`,
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
-- Temporary table structure for view `v_pedidos_count_sresposta_nfederativo`
--

DROP TABLE IF EXISTS `v_pedidos_count_sresposta_nfederativo`;
/*!50001 DROP VIEW IF EXISTS `v_pedidos_count_sresposta_nfederativo`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_pedidos_count_sresposta_nfederativo` AS SELECT 
 1 AS `StatusResposta`,
 1 AS `NomeNivelFederativo`,
 1 AS `TotalPedidos`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_pedidos_count_sresposta_nfederativo_poder`
--

DROP TABLE IF EXISTS `v_pedidos_count_sresposta_nfederativo_poder`;
/*!50001 DROP VIEW IF EXISTS `v_pedidos_count_sresposta_nfederativo_poder`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_pedidos_count_sresposta_nfederativo_poder` AS SELECT 
 1 AS `StatusResposta`,
 1 AS `NomeNivelFederativo`,
 1 AS `NomePoder`,
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
-- Temporary table structure for view `v_pedidos_count_sresposta_nfederativo_uf`
--

DROP TABLE IF EXISTS `v_pedidos_count_sresposta_nfederativo_uf`;
/*!50001 DROP VIEW IF EXISTS `v_pedidos_count_sresposta_nfederativo_uf`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_pedidos_count_sresposta_nfederativo_uf` AS SELECT 
 1 AS `StatusResposta`,
 1 AS `NomeNivelFederativo`,
 1 AS `SiglaUF`,
 1 AS `TotalPedidos`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_pedidos_count_sresposta_poder`
--

DROP TABLE IF EXISTS `v_pedidos_count_sresposta_poder`;
/*!50001 DROP VIEW IF EXISTS `v_pedidos_count_sresposta_poder`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_pedidos_count_sresposta_poder` AS SELECT 
 1 AS `StatusResposta`,
 1 AS `NomePoder`,
 1 AS `TotalPedidos`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_pedidos_count_sresposta_poder_uf`
--

DROP TABLE IF EXISTS `v_pedidos_count_sresposta_poder_uf`;
/*!50001 DROP VIEW IF EXISTS `v_pedidos_count_sresposta_poder_uf`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_pedidos_count_sresposta_poder_uf` AS SELECT 
 1 AS `StatusResposta`,
 1 AS `NomePoder`,
 1 AS `SiglaUF`,
 1 AS `TotalPedidos`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_pedidos_count_sresposta_uf`
--

DROP TABLE IF EXISTS `v_pedidos_count_sresposta_uf`;
/*!50001 DROP VIEW IF EXISTS `v_pedidos_count_sresposta_uf`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_pedidos_count_sresposta_uf` AS SELECT 
 1 AS `StatusResposta`,
 1 AS `SiglaUF`,
 1 AS `TotalPedidos`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_pedidos_count_uf`
--

DROP TABLE IF EXISTS `v_pedidos_count_uf`;
/*!50001 DROP VIEW IF EXISTS `v_pedidos_count_uf`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_pedidos_count_uf` AS SELECT 
 1 AS `SiglaUF`,
 1 AS `TotalPedidos`*/;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `v_pedidos_ativos_groups`
--

/*!50001 DROP VIEW IF EXISTS `v_pedidos_ativos_groups`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = latin1 */;
/*!50001 SET character_set_results     = latin1 */;
/*!50001 SET collation_connection      = latin1_swedish_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
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
/*!50001 SET character_set_client      = latin1 */;
/*!50001 SET character_set_results     = latin1 */;
/*!50001 SET collation_connection      = latin1_swedish_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50001 VIEW `v_pedidos_ativos_status_resposta` AS select `vpa_gr`.`CodigoPedido` AS `CodigoPedido`,`vpa_gr`.`DataEnvio` AS `DataEnvio`,`vpa_gr`.`Ativo` AS `Ativo`,(case when (`vpa_str`.`CodigoPedido` is not null) then 'Respondido' when (`vpa_stnr`.`CodigoPedido` is not null) then 'Não respondido' when (`vpa_sti`.`CodigoPedido` is not null) then 'Não respondido' end) AS `StatusResposta` from (((`v_pedidos_ativos_groups` `vpa_gr` left join `v_pedidos_ativos_status_resposta_respondido` `vpa_str` on((`vpa_gr`.`CodigoPedido` = `vpa_str`.`CodigoPedido`))) left join `v_pedidos_ativos_status_resposta_nao_respondido` `vpa_stnr` on((`vpa_gr`.`CodigoPedido` = `vpa_stnr`.`CodigoPedido`))) left join `v_pedidos_ativos_status_resposta_ignorado` `vpa_sti` on((`vpa_gr`.`CodigoPedido` = `vpa_sti`.`CodigoPedido`))) */;
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
/*!50001 SET character_set_client      = latin1 */;
/*!50001 SET character_set_results     = latin1 */;
/*!50001 SET collation_connection      = latin1_swedish_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
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
/*!50001 SET character_set_client      = latin1 */;
/*!50001 SET character_set_results     = latin1 */;
/*!50001 SET collation_connection      = latin1_swedish_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
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
/*!50001 SET character_set_client      = latin1 */;
/*!50001 SET character_set_results     = latin1 */;
/*!50001 SET collation_connection      = latin1_swedish_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50001 VIEW `v_pedidos_ativos_status_resposta_respondido` AS select distinct `vpa_gr`.`CodigoPedido` AS `CodigoPedido`,`vpa_gr`.`Ativo` AS `Ativo`,`vpa_gr`.`DataEnvio` AS `DataEnvio`,'Respondido' AS `StatusResposta` from (`v_pedidos_ativos_groups` `vpa_gr` left join `pedidos_interacoes` `pi` on((`pi`.`CodigoPedido` = `vpa_gr`.`CodigoPedido`))) where (`pi`.`CodigoTipoPedidoResposta` in (1,3,5,7,9,11)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_pedidos_count_nfederativo`
--

/*!50001 DROP VIEW IF EXISTS `v_pedidos_count_nfederativo`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = latin1 */;
/*!50001 SET character_set_results     = latin1 */;
/*!50001 SET collation_connection      = latin1_swedish_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50001 VIEW `v_pedidos_count_nfederativo` AS select distinct `v_pedidos_ativos_groups`.`NomeNivelFederativo` AS `NomeNivelFederativo`,count(`v_pedidos_ativos_groups`.`NomeNivelFederativo`) AS `TotalPedidos` from `v_pedidos_ativos_groups` group by `v_pedidos_ativos_groups`.`NomeNivelFederativo` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_pedidos_count_nfederativo_poder_uf`
--

/*!50001 DROP VIEW IF EXISTS `v_pedidos_count_nfederativo_poder_uf`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = latin1 */;
/*!50001 SET character_set_results     = latin1 */;
/*!50001 SET collation_connection      = latin1_swedish_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50001 VIEW `v_pedidos_count_nfederativo_poder_uf` AS select `pa`.`NomeNivelFederativo` AS `NomeNivelFederativo`,`pa`.`NomePoder` AS `NomePoder`,`pa`.`SiglaUF` AS `SiglaUF`,count(`pa`.`SiglaUF`) AS `TotalPedidos` from `v_pedidos_ativos_groups` `pa` group by `pa`.`NomeNivelFederativo`,`pa`.`NomePoder`,`pa`.`SiglaUF` order by `pa`.`NomeNivelFederativo`,`pa`.`NomePoder`,`pa`.`SiglaUF` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_pedidos_count_nfederativo_uf`
--

/*!50001 DROP VIEW IF EXISTS `v_pedidos_count_nfederativo_uf`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = latin1 */;
/*!50001 SET character_set_results     = latin1 */;
/*!50001 SET collation_connection      = latin1_swedish_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50001 VIEW `v_pedidos_count_nfederativo_uf` AS select `pa`.`NomeNivelFederativo` AS `NomeNivelFederativo`,`pa`.`SiglaUF` AS `SiglaUF`,count(`pa`.`SiglaUF`) AS `TotalPedidos` from `v_pedidos_ativos_groups` `pa` group by `pa`.`NomeNivelFederativo`,`pa`.`SiglaUF` order by `pa`.`NomeNivelFederativo`,`pa`.`SiglaUF` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_pedidos_count_poder`
--

/*!50001 DROP VIEW IF EXISTS `v_pedidos_count_poder`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = latin1 */;
/*!50001 SET character_set_results     = latin1 */;
/*!50001 SET collation_connection      = latin1_swedish_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50001 VIEW `v_pedidos_count_poder` AS select distinct `v_pedidos_ativos_groups`.`NomePoder` AS `NomePoder`,count(`v_pedidos_ativos_groups`.`NomePoder`) AS `TotalPedidos` from `v_pedidos_ativos_groups` group by `v_pedidos_ativos_groups`.`NomePoder` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_pedidos_count_poder_uf`
--

/*!50001 DROP VIEW IF EXISTS `v_pedidos_count_poder_uf`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = latin1 */;
/*!50001 SET character_set_results     = latin1 */;
/*!50001 SET collation_connection      = latin1_swedish_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50001 VIEW `v_pedidos_count_poder_uf` AS select `pa`.`NomePoder` AS `NomePoder`,`pa`.`SiglaUF` AS `SiglaUF`,count(`pa`.`SiglaUF`) AS `TotalPedidos` from `v_pedidos_ativos_groups` `pa` group by `pa`.`NomePoder`,`pa`.`SiglaUF` order by `pa`.`NomePoder`,`pa`.`SiglaUF` */;
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
/*!50001 SET character_set_client      = latin1 */;
/*!50001 SET character_set_results     = latin1 */;
/*!50001 SET collation_connection      = latin1_swedish_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50001 VIEW `v_pedidos_count_sresposta` AS select distinct `v_pedidos_ativos_status_resposta`.`StatusResposta` AS `StatusResposta`,count(`v_pedidos_ativos_status_resposta`.`StatusResposta`) AS `TotalPedidos` from `v_pedidos_ativos_status_resposta` group by `v_pedidos_ativos_status_resposta`.`StatusResposta` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_pedidos_count_sresposta_nfederativo`
--

/*!50001 DROP VIEW IF EXISTS `v_pedidos_count_sresposta_nfederativo`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = latin1 */;
/*!50001 SET character_set_results     = latin1 */;
/*!50001 SET collation_connection      = latin1_swedish_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50001 VIEW `v_pedidos_count_sresposta_nfederativo` AS select `v_pedidos_count_sresposta_nfederativo_uf`.`StatusResposta` AS `StatusResposta`,`v_pedidos_count_sresposta_nfederativo_uf`.`NomeNivelFederativo` AS `NomeNivelFederativo`,sum(`v_pedidos_count_sresposta_nfederativo_uf`.`TotalPedidos`) AS `TotalPedidos` from `v_pedidos_count_sresposta_nfederativo_uf` group by `v_pedidos_count_sresposta_nfederativo_uf`.`NomeNivelFederativo`,`v_pedidos_count_sresposta_nfederativo_uf`.`StatusResposta` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_pedidos_count_sresposta_nfederativo_poder`
--

/*!50001 DROP VIEW IF EXISTS `v_pedidos_count_sresposta_nfederativo_poder`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = latin1 */;
/*!50001 SET character_set_results     = latin1 */;
/*!50001 SET collation_connection      = latin1_swedish_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50001 VIEW `v_pedidos_count_sresposta_nfederativo_poder` AS select `v_pedidos_count_sresposta_nfederativo_poder_uf`.`StatusResposta` AS `StatusResposta`,`v_pedidos_count_sresposta_nfederativo_poder_uf`.`NomeNivelFederativo` AS `NomeNivelFederativo`,`v_pedidos_count_sresposta_nfederativo_poder_uf`.`NomePoder` AS `NomePoder`,sum(`v_pedidos_count_sresposta_nfederativo_poder_uf`.`TotalPedidos`) AS `TotalPedidos` from `v_pedidos_count_sresposta_nfederativo_poder_uf` group by `v_pedidos_count_sresposta_nfederativo_poder_uf`.`NomeNivelFederativo`,`v_pedidos_count_sresposta_nfederativo_poder_uf`.`NomePoder`,`v_pedidos_count_sresposta_nfederativo_poder_uf`.`StatusResposta` */;
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
/*!50001 SET character_set_client      = latin1 */;
/*!50001 SET character_set_results     = latin1 */;
/*!50001 SET collation_connection      = latin1_swedish_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50001 VIEW `v_pedidos_count_sresposta_nfederativo_poder_uf` AS select `pa`.`Ativo` AS `Ativo`,`st`.`StatusResposta` AS `StatusResposta`,`pa`.`NomeNivelFederativo` AS `NomeNivelFederativo`,`pa`.`NomePoder` AS `NomePoder`,`pa`.`SiglaUF` AS `SiglaUF`,count(`pa`.`SiglaUF`) AS `TotalPedidos` from (`v_pedidos_ativos_groups` `pa` join `v_pedidos_ativos_status_resposta` `st` on((`pa`.`CodigoPedido` = `st`.`CodigoPedido`))) group by `st`.`StatusResposta`,`pa`.`NomeNivelFederativo`,`pa`.`NomePoder`,`pa`.`SiglaUF` order by `st`.`StatusResposta`,`pa`.`NomeNivelFederativo`,`pa`.`NomePoder`,`pa`.`SiglaUF` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_pedidos_count_sresposta_nfederativo_uf`
--

/*!50001 DROP VIEW IF EXISTS `v_pedidos_count_sresposta_nfederativo_uf`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = latin1 */;
/*!50001 SET character_set_results     = latin1 */;
/*!50001 SET collation_connection      = latin1_swedish_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50001 VIEW `v_pedidos_count_sresposta_nfederativo_uf` AS select `st`.`StatusResposta` AS `StatusResposta`,`pa`.`NomeNivelFederativo` AS `NomeNivelFederativo`,`pa`.`SiglaUF` AS `SiglaUF`,count(`pa`.`SiglaUF`) AS `TotalPedidos` from (`v_pedidos_ativos_groups` `pa` join `v_pedidos_ativos_status_resposta` `st` on((`pa`.`CodigoPedido` = `st`.`CodigoPedido`))) group by `st`.`StatusResposta`,`pa`.`NomeNivelFederativo`,`pa`.`SiglaUF` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_pedidos_count_sresposta_poder`
--

/*!50001 DROP VIEW IF EXISTS `v_pedidos_count_sresposta_poder`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = latin1 */;
/*!50001 SET character_set_results     = latin1 */;
/*!50001 SET collation_connection      = latin1_swedish_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50001 VIEW `v_pedidos_count_sresposta_poder` AS select `v_pedidos_count_sresposta_poder_uf`.`StatusResposta` AS `StatusResposta`,`v_pedidos_count_sresposta_poder_uf`.`NomePoder` AS `NomePoder`,sum(`v_pedidos_count_sresposta_poder_uf`.`TotalPedidos`) AS `TotalPedidos` from `v_pedidos_count_sresposta_poder_uf` group by `v_pedidos_count_sresposta_poder_uf`.`NomePoder`,`v_pedidos_count_sresposta_poder_uf`.`StatusResposta` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_pedidos_count_sresposta_poder_uf`
--

/*!50001 DROP VIEW IF EXISTS `v_pedidos_count_sresposta_poder_uf`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = latin1 */;
/*!50001 SET character_set_results     = latin1 */;
/*!50001 SET collation_connection      = latin1_swedish_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50001 VIEW `v_pedidos_count_sresposta_poder_uf` AS select `st`.`StatusResposta` AS `StatusResposta`,`pa`.`NomePoder` AS `NomePoder`,`pa`.`SiglaUF` AS `SiglaUF`,count(`pa`.`SiglaUF`) AS `TotalPedidos` from (`v_pedidos_ativos_groups` `pa` join `v_pedidos_ativos_status_resposta` `st` on((`pa`.`CodigoPedido` = `st`.`CodigoPedido`))) group by `st`.`StatusResposta`,`pa`.`NomePoder`,`pa`.`SiglaUF` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_pedidos_count_sresposta_uf`
--

/*!50001 DROP VIEW IF EXISTS `v_pedidos_count_sresposta_uf`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = latin1 */;
/*!50001 SET character_set_results     = latin1 */;
/*!50001 SET collation_connection      = latin1_swedish_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50001 VIEW `v_pedidos_count_sresposta_uf` AS select `st`.`StatusResposta` AS `StatusResposta`,`pa`.`SiglaUF` AS `SiglaUF`,count(`pa`.`SiglaUF`) AS `TotalPedidos` from (`v_pedidos_ativos_groups` `pa` join `v_pedidos_ativos_status_resposta` `st` on((`pa`.`CodigoPedido` = `st`.`CodigoPedido`))) group by `st`.`StatusResposta`,`pa`.`SiglaUF` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_pedidos_count_uf`
--

/*!50001 DROP VIEW IF EXISTS `v_pedidos_count_uf`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = latin1 */;
/*!50001 SET character_set_results     = latin1 */;
/*!50001 SET collation_connection      = latin1_swedish_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50001 VIEW `v_pedidos_count_uf` AS select distinct `v_pedidos_ativos_groups`.`SiglaUF` AS `SiglaUF`,count(`v_pedidos_ativos_groups`.`SiglaUF`) AS `TotalPedidos` from `v_pedidos_ativos_groups` group by `v_pedidos_ativos_groups`.`SiglaUF` */;
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

-- Dump completed on 2021-04-16 14:05:07
