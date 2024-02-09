
DROP TABLE IF EXISTS `analiticos`;
CREATE TABLE `analiticos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `visitor_id` varchar(255) NOT NULL,
  `x` int NOT NULL,
  `y` int NOT NULL,
  `time` datetime DEFAULT NULL,
  `isMobile` tinyint DEFAULT NULL,
  `screenWidth` int DEFAULT NULL,
  `screenHeight` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ;

DROP TABLE IF EXISTS `enderecos`;
CREATE TABLE `enderecos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cep` varchar(10) DEFAULT NULL,
  `rua` varchar(200) DEFAULT NULL,
  `bairro` varchar(200) DEFAULT NULL,
  `cidade` varchar(200) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `latitude` varchar(25) DEFAULT NULL,
  `longitude` varchar(25) DEFAULT NULL,
  `ativo` int DEFAULT NULL,
  `idusuario` int DEFAULT NULL,
  `idsalao` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_userendereco_idx` (`idusuario`),
  KEY `fk_salao_idx` (`idsalao`),
  CONSTRAINT `fk_salao` FOREIGN KEY (`idsalao`) REFERENCES `saloes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_userendereco` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ;


DROP TABLE IF EXISTS `perfis`;
CREATE TABLE `perfis` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome` (`nome`)
) ;
INSERT INTO `perfis` VALUES (1,'admin'),(2,'comum');

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `perfilid` int DEFAULT NULL,
  `ativo` int DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `usuario_ibfk_1` (`perfilid`),
  CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`perfilid`) REFERENCES `perfis` (`id`)
) 


DROP TABLE IF EXISTS `permissoes`;
CREATE TABLE `permissoes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome` (`nome`)
) ;
INSERT INTO `permissoes` VALUES (3,'admin'),(8,'gerirsaloes'),(1,'index'),(5,'login'),(12,'mapa'),(2,'produtos'),(6,'saloes'),(4,'usuarios');

DROP TABLE IF EXISTS `perfilpermissoes`;
CREATE TABLE `perfilpermissoes` (
  `perfilid` int NOT NULL,
  `permissao_id` int NOT NULL,
  PRIMARY KEY (`perfilid`,`permissao_id`),
  KEY `perfil_permissoes_ibfk_2` (`permissao_id`),
  CONSTRAINT `perfilpermissoes_ibfk_1` FOREIGN KEY (`perfilid`) REFERENCES `perfis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `perfilpermissoes_ibfk_2` FOREIGN KEY (`permissao_id`) REFERENCES `permissoes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ;
;
INSERT INTO `perfilpermissoes` VALUES (1,1),(2,1),(1,2),(1,3),(1,4),(1,6),(2,6),(2,8),(1,12),(2,12);



DROP TABLE IF EXISTS `saloes`;
CREATE TABLE `saloes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `idusuario` int DEFAULT NULL,
  `ativo` int DEFAULT '1',
  `servicos` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_proprietario_idx` (`idusuario`),
  CONSTRAINT `fk_proprietario` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ;

INSERT INTO `saloes` VALUES (20,'xxxxx ddddd',1,1,'xxxxxxxxxx'),(23,'Corta tudo',2,1,'xxxxxxxxxxx');

