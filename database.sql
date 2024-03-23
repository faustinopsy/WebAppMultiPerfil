CREATE DATABASE  IF NOT EXISTS `loja` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `loja`;
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
  `screenHeight` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `analiticos`
--

LOCK TABLES `analiticos` WRITE;
/*!40000 ALTER TABLE `analiticos` DISABLE KEYS */;
INSERT INTO `analiticos` VALUES ('24bb6988-04b0-4f63-922a-eefb1975469b','visitor-4vnwsbn0w',401,433,'2024-03-23 19:55:09',0,640,632),('24bb6988-04b0-4f63-922a-eefb1975469b','visitor-4vnwsbn0w',408,441,'2024-03-23 19:55:09',0,640,632),('24bb6988-04b0-4f63-922a-eefb1975469b','visitor-4vnwsbn0w',414,447,'2024-03-23 19:55:09',0,640,632),('24bb6988-04b0-4f63-922a-eefb1975469b','visitor-4vnwsbn0w',418,452,'2024-03-23 19:55:09',0,640,632),('24bb6988-04b0-4f63-922a-eefb1975469b','visitor-4vnwsbn0w',423,455,'2024-03-23 19:55:09',0,640,632),('24bb6988-04b0-4f63-922a-eefb1975469b','visitor-4vnwsbn0w',429,457,'2024-03-23 19:55:09',0,640,632),('24bb6988-04b0-4f63-922a-eefb1975469b','visitor-4vnwsbn0w',436,461,'2024-03-23 19:55:09',0,640,632),('24bb6988-04b0-4f63-922a-eefb1975469b','visitor-4vnwsbn0w',443,463,'2024-03-23 19:55:09',0,640,632),('24bb6988-04b0-4f63-922a-eefb1975469b','visitor-4vnwsbn0w',452,465,'2024-03-23 19:55:09',0,640,632),('24bb6988-04b0-4f63-922a-eefb1975469b','visitor-4vnwsbn0w',460,465,'2024-03-23 19:55:09',0,640,632),('24bb6988-04b0-4f63-922a-eefb1975469b','visitor-4vnwsbn0w',469,463,'2024-03-23 19:55:09',0,640,632),('24bb6988-04b0-4f63-922a-eefb1975469b','visitor-4vnwsbn0w',481,461,'2024-03-23 19:55:09',0,640,632),('24bb6988-04b0-4f63-922a-eefb1975469b','visitor-4vnwsbn0w',494,459,'2024-03-23 19:55:09',0,640,632),('b96388a3-3965-4b31-80e8-4b2ff2baebfb','visitor-y77k5nnix',762,580,'2024-03-23 20:06:01',0,771,632),('b96388a3-3965-4b31-80e8-4b2ff2baebfb','visitor-y77k5nnix',762,581,'2024-03-23 20:06:01',0,771,632),('b96388a3-3965-4b31-80e8-4b2ff2baebfb','visitor-y77k5nnix',763,581,'2024-03-23 20:06:01',0,771,632),('b96388a3-3965-4b31-80e8-4b2ff2baebfb','visitor-y77k5nnix',764,581,'2024-03-23 20:06:01',0,771,632),('b96388a3-3965-4b31-80e8-4b2ff2baebfb','visitor-y77k5nnix',766,582,'2024-03-23 20:06:01',0,771,632),('b96388a3-3965-4b31-80e8-4b2ff2baebfb','visitor-y77k5nnix',766,583,'2024-03-23 20:06:01',0,771,632),('b96388a3-3965-4b31-80e8-4b2ff2baebfb','visitor-y77k5nnix',768,583,'2024-03-23 20:06:01',0,771,632),('b96388a3-3965-4b31-80e8-4b2ff2baebfb','visitor-y77k5nnix',769,583,'2024-03-23 20:06:01',0,771,632),('b96388a3-3965-4b31-80e8-4b2ff2baebfb','visitor-y77k5nnix',770,583,'2024-03-23 20:06:01',0,771,632),('e2ed436b-e8a7-40bf-940b-1d8f814adf9f','visitor-efizuvlru',297,30,'2024-03-23 20:08:10',1,348,553),('e2ed436b-e8a7-40bf-940b-1d8f814adf9f','visitor-efizuvlru',232,659,'2024-03-23 20:08:12',1,348,553),('e2ed436b-e8a7-40bf-940b-1d8f814adf9f','visitor-efizuvlru',147,239,'2024-03-23 20:08:15',1,348,553),('e2ed436b-e8a7-40bf-940b-1d8f814adf9f','visitor-efizuvlru',180,168,'2024-03-23 20:08:16',1,348,553),('e2ed436b-e8a7-40bf-940b-1d8f814adf9f','visitor-efizuvlru',294,299,'2024-03-23 20:08:18',1,348,553),('7c4ee077-63a3-49ea-a762-2e729eb046a4','visitor-efizuvlru',639,275,'2024-03-23 20:09:13',1,348,553),('7c4ee077-63a3-49ea-a762-2e729eb046a4','visitor-efizuvlru',645,269,'2024-03-23 20:09:13',1,348,553),('7c4ee077-63a3-49ea-a762-2e729eb046a4','visitor-efizuvlru',650,263,'2024-03-23 20:09:13',1,348,553),('7c4ee077-63a3-49ea-a762-2e729eb046a4','visitor-efizuvlru',652,259,'2024-03-23 20:09:13',1,348,553),('7c4ee077-63a3-49ea-a762-2e729eb046a4','visitor-efizuvlru',654,254,'2024-03-23 20:09:13',1,348,553),('7c4ee077-63a3-49ea-a762-2e729eb046a4','visitor-efizuvlru',654,251,'2024-03-23 20:09:13',1,348,553),('cd846b68-2d21-4b1a-90b0-7010458e9fb2','visitor-2etagtxcx',514,202,'2024-03-23 20:14:39',0,720,632),('b38a894d-3f74-4ab3-a32f-7822ea2089f1','visitor-emz4mnfqp',716,631,'2024-03-23 20:21:42',1,348,553);
/*!40000 ALTER TABLE `analiticos` ENABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enderecos`
--

LOCK TABLES `enderecos` WRITE;
/*!40000 ALTER TABLE `enderecos` DISABLE KEYS */;
INSERT INTO `enderecos` VALUES ('2015d65b-6acd-47ea-8e2b-c3293f71c643','08473592','Rua Alexandre Davidenko','Conjunto Habitacional Barro Branco II','São Paulo','SP','-23.5897','-46.38989',NULL,'e6a55708-eb89-41c2-857d-8a1bf8597e37','dc6e6f0c-cfcb-4659-a636-8622ba489f7a');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perfilpermissoes`
--

LOCK TABLES `perfilpermissoes` WRITE;
/*!40000 ALTER TABLE `perfilpermissoes` DISABLE KEYS */;
INSERT INTO `perfilpermissoes` VALUES ('d448d881-a39a-4652-92b1-1359cd0dd8b2','691cb17d-50b3-4d5b-bdb1-0d264ed28dbe'),('d448d881-a39a-4652-92b1-1359cd0dd8b2','6f6e5784-3691-4dfe-ba58-9e79548a3fab');
/*!40000 ALTER TABLE `perfilpermissoes` ENABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissoes`
--

LOCK TABLES `permissoes` WRITE;
/*!40000 ALTER TABLE `permissoes` DISABLE KEYS */;
INSERT INTO `permissoes` VALUES ('691cb17d-50b3-4d5b-bdb1-0d264ed28dbe','admin'),('6f6e5784-3691-4dfe-ba58-9e79548a3fab','mapa');
/*!40000 ALTER TABLE `permissoes` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saloes`
--

LOCK TABLES `saloes` WRITE;
/*!40000 ALTER TABLE `saloes` DISABLE KEYS */;
INSERT INTO `saloes` VALUES ('dc6e6f0c-cfcb-4659-a636-8622ba489f7a','Corta tudo2','e6a55708-eb89-41c2-857d-8a1bf8597e37',1,'xxxxxxxxxxxxx');
/*!40000 ALTER TABLE `saloes` ENABLE KEYS */;
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
  `perfilid` char(40) DEFAULT NULL,
  `ativo` int DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `fk_perfil_idx` (`perfilid`),
  CONSTRAINT `fk_perfil` FOREIGN KEY (`perfilid`) REFERENCES `perfis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES ('e6a55708-eb89-41c2-857d-8a1bf8597e37','rodrigo','rodrigohipnose@gmail.com','$2y$10$HR87MIkNV5SKi7JY7B9ShutybeVkXUJ4tp5Xr/RlTO6YPopecwUjq','d448d881-a39a-4652-92b1-1359cd0dd8b2',1);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'loja'
--

--
-- Dumping routines for database 'loja'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-03-23 17:24:19
