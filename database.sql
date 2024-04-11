-- MySQL dump 10.13  Distrib 8.0.33, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: loja
-- ------------------------------------------------------
-- Server version	8.0.33

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `analiticos`
--

DROP TABLE IF EXISTS `analiticos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `analiticos` (
  `id` char(40) NOT NULL,
  `visitor_id` varchar(255) NOT NULL,
  `x` float NOT NULL,
  `y` float NOT NULL,
  `time` datetime DEFAULT NULL,
  `isMobile` tinyint DEFAULT NULL,
  `screenWidth` int DEFAULT NULL,
  `screenHeight` int DEFAULT NULL,
  `plataforma` varchar(45) DEFAULT NULL,
  `mobile` varchar(45) DEFAULT NULL
) ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `analiticos`
--

LOCK TABLES `analiticos` WRITE;
/*!40000 ALTER TABLE `analiticos` DISABLE KEYS */;
/*!40000 ALTER TABLE `analiticos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `codigo`
--

DROP TABLE IF EXISTS `codigo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `codigo` (
  `idtoken` int NOT NULL AUTO_INCREMENT,
  `email` varchar(145) DEFAULT NULL,
  `codigo` varchar(45) DEFAULT NULL,
  `expira` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idtoken`)
) ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `codigo`
--

LOCK TABLES `codigo` WRITE;
/*!40000 ALTER TABLE `codigo` DISABLE KEYS */;
/*!40000 ALTER TABLE `codigo` ENABLE KEYS */;
UNLOCK TABLES;


--
-- Table structure for table `perfis`
--

DROP TABLE IF EXISTS `perfis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `perfis` (
  `id` char(40) NOT NULL,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome` (`nome`)
) ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perfis`
--

LOCK TABLES `perfis` WRITE;
/*!40000 ALTER TABLE `perfis` DISABLE KEYS */;
INSERT INTO `perfis` VALUES ('d448d881-a39a-4652-92b1-1359cd0dd8b2','admin'),('36da7520-db20-4963-807e-2d0a6ad938a2','comum');
/*!40000 ALTER TABLE `perfis` ENABLE KEYS */;
UNLOCK TABLES;


--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` char(40) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `perfil` varchar(55) DEFAULT NULL,
  `ativo` int DEFAULT '1',
  `twofactor` int DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES ('cf4ebcd3-94fe-4f53-a625-8ba057f22d34','faustino','comum@gmail.com','$2y$10$mJaEJ9BFI/tZJSyMEtI6t.zBdTyjrg6iV72XfDWmioXFJuu2ut.Hq','36da7520-db20-4963-807e-2d0a6ad938a2',1,0),('e6a55708-eb89-41c2-857d-8a1bf8597e37','rodrigo','admin@gmail.com','$2y$10$VmPdlULkoewp8QJ0xBor1eH87n4aCbTlkz7/GuNG0tCMuoph4XrHe','d448d881-a39a-4652-92b1-1359cd0dd8b2',1,0);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
--
-- Table structure for table `permissoes`
--

DROP TABLE IF EXISTS `permissoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissoes` (
  `id` char(40) NOT NULL,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome` (`nome`)
) ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissoes`
--

LOCK TABLES `permissoes` WRITE;
/*!40000 ALTER TABLE `permissoes` DISABLE KEYS */;
INSERT INTO `permissoes` VALUES ('691cb17d-50b3-4d5b-bdb1-0d264ed28dbe','admin'),('f29d7f7d-0498-404b-8439-6b81acc7bea1','gerirsaloes'),('6f6e5784-3691-4dfe-ba58-9e79548a3fab','mapa'),('e6695c69-e460-4f85-906c-4ede47f02936','minhaarea');
/*!40000 ALTER TABLE `permissoes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enderecos`
--

DROP TABLE IF EXISTS `enderecos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `enderecos` (
  `id` char(40) NOT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `rua` varchar(200) DEFAULT NULL,
  `bairro` varchar(200) DEFAULT NULL,
  `cidade` varchar(200) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `latitude` varchar(25) DEFAULT NULL,
  `longitude` varchar(25) DEFAULT NULL,
  `ativo` int DEFAULT NULL,
  `idusuario` char(40) DEFAULT NULL,
  `idsalao` char(40) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_enderecos_idx` (`idusuario`),
  KEY `fk_salao_idx` (`idsalao`),
  CONSTRAINT `fk_enderecos` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`id`),
  CONSTRAINT `fk_saloes` FOREIGN KEY (`idsalao`) REFERENCES `saloes` (`id`)
) ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enderecos`
--

LOCK TABLES `enderecos` WRITE;
/*!40000 ALTER TABLE `enderecos` DISABLE KEYS */;
/*!40000 ALTER TABLE `enderecos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perfilpermissoes`
--

DROP TABLE IF EXISTS `perfilpermissoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `perfilpermissoes` (
  `perfilid` char(40) NOT NULL,
  `permissao_id` char(40) NOT NULL,
  PRIMARY KEY (`perfilid`,`permissao_id`),
  KEY `fk_permss_idx` (`permissao_id`),
  CONSTRAINT `fk_perfil_perm` FOREIGN KEY (`perfilid`) REFERENCES `perfis` (`id`),
  CONSTRAINT `fk_permss` FOREIGN KEY (`permissao_id`) REFERENCES `permissoes` (`id`)
) ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perfilpermissoes`
--

LOCK TABLES `perfilpermissoes` WRITE;
/*!40000 ALTER TABLE `perfilpermissoes` DISABLE KEYS */;
INSERT INTO `perfilpermissoes` VALUES ('d448d881-a39a-4652-92b1-1359cd0dd8b2','691cb17d-50b3-4d5b-bdb1-0d264ed28dbe'),('36da7520-db20-4963-807e-2d0a6ad938a2','6f6e5784-3691-4dfe-ba58-9e79548a3fab'),('d448d881-a39a-4652-92b1-1359cd0dd8b2','6f6e5784-3691-4dfe-ba58-9e79548a3fab'),('36da7520-db20-4963-807e-2d0a6ad938a2','e6695c69-e460-4f85-906c-4ede47f02936'),('d448d881-a39a-4652-92b1-1359cd0dd8b2','e6695c69-e460-4f85-906c-4ede47f02936'),('36da7520-db20-4963-807e-2d0a6ad938a2','f29d7f7d-0498-404b-8439-6b81acc7bea1');
/*!40000 ALTER TABLE `perfilpermissoes` ENABLE KEYS */;
UNLOCK TABLES;


--
-- Table structure for table `produtos`
--

DROP TABLE IF EXISTS `produtos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `produtos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(75) DEFAULT NULL,
  `preco` decimal(9,2) DEFAULT NULL,
  `quantidade` int DEFAULT NULL,
  `ativo` int DEFAULT '1',
  PRIMARY KEY (`id`)
) ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produtos`
--

LOCK TABLES `produtos` WRITE;
/*!40000 ALTER TABLE `produtos` DISABLE KEYS */;
INSERT INTO `produtos` VALUES (1,'Ford Ka',10000.00,3,1),(2,'Corsa',13000.00,2,1),(3,'Celta',9000.00,4,1);
/*!40000 ALTER TABLE `produtos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `saloes`
--

DROP TABLE IF EXISTS `saloes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `saloes` (
  `id` char(40) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `idusuario` char(40) DEFAULT NULL,
  `ativo` int DEFAULT '1',
  `servicos` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_proprietario_idx` (`idusuario`),
  CONSTRAINT `fk_proprietario` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`id`)
) ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saloes`
--

LOCK TABLES `saloes` WRITE;
/*!40000 ALTER TABLE `saloes` DISABLE KEYS */;
INSERT INTO `saloes` VALUES ('dc6e6f0c-cfcb-4659-a636-8622ba489f7a','Corta tudo2','e6a55708-eb89-41c2-857d-8a1bf8597e37',1,'xxxxxxxxxxxxx'),('dd76be53-f634-4bcd-9166-777adc34baf3','Como resolver o crud','cf4ebcd3-94fe-4f53-a625-8ba057f22d34',1,'xxxxxxxxxxxxxxxxxxxx');
/*!40000 ALTER TABLE `saloes` ENABLE KEYS */;
UNLOCK TABLES;


/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-04-10 23:41:37
