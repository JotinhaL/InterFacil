-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: intercambio
-- ------------------------------------------------------
-- Server version	8.1.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `fluencia`
--

DROP TABLE IF EXISTS `fluencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fluencia` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fluencia`
--

LOCK TABLES `fluencia` WRITE;
/*!40000 ALTER TABLE `fluencia` DISABLE KEYS */;
INSERT INTO `fluencia` VALUES (1,'Básico'),(2,'Intermedário'),(3,'Avançado'),(4,'Fluente'),(5,'Nativo');
/*!40000 ALTER TABLE `fluencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `idioma`
--

DROP TABLE IF EXISTS `idioma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `idioma` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `idioma`
--

LOCK TABLES `idioma` WRITE;
/*!40000 ALTER TABLE `idioma` DISABLE KEYS */;
INSERT INTO `idioma` VALUES (1,'Inglês'),(2,'Espanhol'),(3,'Italiano'),(4,'Sueco'),(5,'Norueguês'),(6,'Português'),(7,'Português Brasil'),(8,'Mandarim'),(9,'Francês');
/*!40000 ALTER TABLE `idioma` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `idiomas_usuario`
--

DROP TABLE IF EXISTS `idiomas_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `idiomas_usuario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `id_idioma` int NOT NULL,
  `id_fluencia` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_idioma` (`id_idioma`),
  KEY `id_fluencia` (`id_fluencia`),
  CONSTRAINT `idiomas_usuario_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`),
  CONSTRAINT `idiomas_usuario_ibfk_2` FOREIGN KEY (`id_idioma`) REFERENCES `idioma` (`id`),
  CONSTRAINT `idiomas_usuario_ibfk_3` FOREIGN KEY (`id_fluencia`) REFERENCES `fluencia` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `idiomas_usuario`
--

LOCK TABLES `idiomas_usuario` WRITE;
/*!40000 ALTER TABLE `idiomas_usuario` DISABLE KEYS */;
INSERT INTO `idiomas_usuario` VALUES (1,1,7,2),(2,1,1,3),(3,1,9,1),(4,1,8,5);
/*!40000 ALTER TABLE `idiomas_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `idiomas_vaga`
--

DROP TABLE IF EXISTS `idiomas_vaga`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `idiomas_vaga` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_vaga` int NOT NULL,
  `id_idioma` int NOT NULL,
  `id_fluencia` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_vaga` (`id_vaga`),
  KEY `id_idioma` (`id_idioma`),
  KEY `id_fluencia` (`id_fluencia`),
  CONSTRAINT `idiomas_vaga_ibfk_1` FOREIGN KEY (`id_vaga`) REFERENCES `vaga` (`id`),
  CONSTRAINT `idiomas_vaga_ibfk_2` FOREIGN KEY (`id_idioma`) REFERENCES `idioma` (`id`),
  CONSTRAINT `idiomas_vaga_ibfk_3` FOREIGN KEY (`id_fluencia`) REFERENCES `fluencia` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `idiomas_vaga`
--

LOCK TABLES `idiomas_vaga` WRITE;
/*!40000 ALTER TABLE `idiomas_vaga` DISABLE KEYS */;
INSERT INTO `idiomas_vaga` VALUES (1,1,1,4),(2,1,6,1),(3,1,8,5),(4,1,4,2);
/*!40000 ALTER TABLE `idiomas_vaga` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nivel_ensino`
--

DROP TABLE IF EXISTS `nivel_ensino`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nivel_ensino` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nivel_ensino`
--

LOCK TABLES `nivel_ensino` WRITE;
/*!40000 ALTER TABLE `nivel_ensino` DISABLE KEYS */;
INSERT INTO `nivel_ensino` VALUES (1,'Ensino Fundamental'),(2,'Ensino Médio'),(3,'Ensino Superior'),(4,'Pós Graduação'),(5,'Doutorado'),(6,'Mestrado');
/*!40000 ALTER TABLE `nivel_ensino` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status_ensino`
--

DROP TABLE IF EXISTS `status_ensino`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `status_ensino` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status_ensino`
--

LOCK TABLES `status_ensino` WRITE;
/*!40000 ALTER TABLE `status_ensino` DISABLE KEYS */;
INSERT INTO `status_ensino` VALUES (1,'Completo'),(2,'Incompleto'),(3,'Cursando');
/*!40000 ALTER TABLE `status_ensino` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_usuario`
--

DROP TABLE IF EXISTS `tipo_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_usuario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_usuario`
--

LOCK TABLES `tipo_usuario` WRITE;
/*!40000 ALTER TABLE `tipo_usuario` DISABLE KEYS */;
INSERT INTO `tipo_usuario` VALUES (1,'Estudante'),(2,'Empresa');
/*!40000 ALTER TABLE `tipo_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_tipo_usuario` int NOT NULL,
  `nome` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `dataNascimento` datetime NOT NULL,
  `nivelEnsino` int NOT NULL,
  `statusEnsino` int NOT NULL,
  `experiencia` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_tipo_usuario` (`id_tipo_usuario`),
  KEY `nivelEnsino` (`nivelEnsino`),
  KEY `statusEnsino` (`statusEnsino`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `tipo_usuario` (`id`),
  CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`nivelEnsino`) REFERENCES `nivel_ensino` (`id`),
  CONSTRAINT `usuario_ibfk_3` FOREIGN KEY (`statusEnsino`) REFERENCES `status_ensino` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,1,'joao kleber','$2y$10$9T1y.DLqO9KFeMX2c9QSBOKwnvqOo9RP6ujLUk9.qEGDSzyD58Mpi','1994-12-05 00:00:00',3,3,'boa experiencia','joao.kleber@email.com');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario_vaga`
--

DROP TABLE IF EXISTS `usuario_vaga`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario_vaga` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `id_vaga` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_vaga` (`id_vaga`),
  CONSTRAINT `usuario_vaga_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`),
  CONSTRAINT `usuario_vaga_ibfk_2` FOREIGN KEY (`id_vaga`) REFERENCES `vaga` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario_vaga`
--

LOCK TABLES `usuario_vaga` WRITE;
/*!40000 ALTER TABLE `usuario_vaga` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuario_vaga` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vaga`
--

DROP TABLE IF EXISTS `vaga`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vaga` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `nivelEnsino` int NOT NULL,
  `statusEnsino` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `nivelEnsino` (`nivelEnsino`),
  KEY `statusEnsino` (`statusEnsino`),
  CONSTRAINT `vaga_ibfk_1` FOREIGN KEY (`nivelEnsino`) REFERENCES `nivel_ensino` (`id`),
  CONSTRAINT `vaga_ibfk_2` FOREIGN KEY (`statusEnsino`) REFERENCES `status_ensino` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vaga`
--

LOCK TABLES `vaga` WRITE;
/*!40000 ALTER TABLE `vaga` DISABLE KEYS */;
INSERT INTO `vaga` VALUES (1,'intercambio na espanha','aprender sobre a cultura espanhola',3,3);
/*!40000 ALTER TABLE `vaga` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'intercambio'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-11-18 10:59:29
