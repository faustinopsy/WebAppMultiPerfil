
DROP TABLE IF EXISTS `perfis`;
CREATE TABLE `perfis` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome` (`nome`)
) ;

INSERT INTO `perfis` VALUES (1,'admin'),(3,'administrador'),(2,'comum');

DROP TABLE IF EXISTS `permissoes`;
CREATE TABLE `permissoes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome` (`nome`)
) ;

INSERT INTO `permissoes` VALUES (3,'admin'),(1,'index'),(5,'login'),(2,'produtos'),(4,'usuarios');


DROP TABLE IF EXISTS `perfilpermissoes`;
CREATE TABLE `perfilpermissoes` (
  `perfilid` int NOT NULL,
  `permissao_id` int NOT NULL,
  PRIMARY KEY (`perfilid`,`permissao_id`),
  KEY `perfil_permissoes_ibfk_2` (`permissao_id`),
  CONSTRAINT `perfilpermissoes_ibfk_1` FOREIGN KEY (`perfilid`) REFERENCES `perfis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `perfilpermissoes_ibfk_2` FOREIGN KEY (`permissao_id`) REFERENCES `permissoes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ;
INSERT INTO `perfilpermissoes` VALUES (1,1),(1,2),(2,2),(1,3),(1,4),(2,5);

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
) ;


DROP TABLE IF EXISTS `produtos`;
CREATE TABLE `produtos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(75) DEFAULT NULL,
  `preco` decimal(9,2) DEFAULT NULL,
  `quantidade` int DEFAULT NULL,
  `ativo` int DEFAULT '1',
  PRIMARY KEY (`id`)
) ;

INSERT INTO `produtos` VALUES (1,'Ford Ka',10000.00,3,1),(2,'Corsa',13000.00,2,1),(3,'Celta',9000.00,4,1);

