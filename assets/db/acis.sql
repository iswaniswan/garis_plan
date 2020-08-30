CREATE DATABASE  IF NOT EXISTS `acis` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `acis`;
-- MySQL dump 10.13  Distrib 5.6.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: acis
-- ------------------------------------------------------
-- Server version	5.7.30

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
-- Table structure for table `facility`
--

DROP TABLE IF EXISTS `facility`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `facility` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `condition` varchar(45) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facility`
--

LOCK TABLES `facility` WRITE;
/*!40000 ALTER TABLE `facility` DISABLE KEYS */;
INSERT INTO `facility` VALUES (1,'Computer','good',NULL,'2020-08-22 03:49:24',NULL,0),(2,'Laptop','good',NULL,'2020-08-22 03:49:24',NULL,0),(3,'AC','bad','need service','2020-08-22 03:49:24',NULL,0),(4,'Water dispenser','good',NULL,'2020-08-22 03:49:24',NULL,0),(5,'Internet','good','WiFi','2020-08-22 13:21:22',NULL,0),(6,'Projector','good',NULL,'2020-08-22 03:49:24',NULL,0),(7,'Visualizer document','good',NULL,'2020-08-22 03:49:24',NULL,0),(8,'Speaker','good',NULL,'2020-08-22 03:49:24',NULL,0),(9,'Phone','good',NULL,'2020-08-22 03:49:24',NULL,0);
/*!40000 ALTER TABLE `facility` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `holiday`
--

DROP TABLE IF EXISTS `holiday`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `holiday` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_start` datetime NOT NULL,
  `date_end` datetime DEFAULT NULL,
  `celebration` varchar(255) NOT NULL,
  `type` varchar(45) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `holiday`
--

LOCK TABLES `holiday` WRITE;
/*!40000 ALTER TABLE `holiday` DISABLE KEYS */;
INSERT INTO `holiday` VALUES (1,'2020-01-01 00:00:00','2020-01-01 00:00:00','Tahun Baru 2020 Masehi','nasional',NULL,'2020-08-23 12:24:24',NULL,0),(2,'2020-01-25 00:00:00','2020-01-25 00:00:00','Tahun Baru Imlek 2571 Kongzili','nasional',NULL,'2020-08-23 12:24:24',NULL,0),(3,'2020-03-22 00:00:00','2020-03-22 00:00:00','Isra Mikraj Nabi Muhammad SAW','nasional',NULL,'2020-08-23 12:24:24',NULL,0),(4,'2020-03-25 00:00:00','2020-03-25 00:00:00','Hari Suci Nyepi Tahun Baru Saka 1942','nasional',NULL,'2020-08-23 12:24:24',NULL,0),(5,'2020-04-10 00:00:00','2020-04-10 00:00:00','Wafat Isa Al Masih','nasional',NULL,'2020-08-23 12:24:24',NULL,0),(6,'2020-05-01 00:00:00','2020-05-01 00:00:00','Hari Buruh Internasional','nasional',NULL,'2020-08-23 12:24:24',NULL,0),(7,'2020-05-07 00:00:00','2020-05-07 00:00:00','Hari Raya Waisak 2564','nasional',NULL,'2020-08-23 12:24:24',NULL,0),(8,'2020-05-21 00:00:00','2020-05-21 00:00:00','Kenaikan Isa Al Masih','nasional',NULL,'2020-08-23 12:24:24',NULL,0),(9,'2020-05-22 00:00:00','2020-05-27 00:00:00','Idul Fitri','nasional','Hari Raya Idul Fitri 1441 Hijriyah','2020-08-23 13:13:08',NULL,0),(14,'2020-06-01 00:00:00','2020-06-01 00:00:00','Pancasila','nasional','Hari Lahir Pancasila','2020-08-23 13:13:08',NULL,0),(15,'2020-07-31 00:00:00','2020-07-31 00:00:00','Idul Adha','nasional','Hari Raya Idul Adha 1441 Hijriyah','2020-08-23 13:13:08',NULL,0),(16,'2020-08-17 00:00:00','2020-08-17 00:00:00','HUT RI','nasional','Hari Kemerdekaan RI','2020-08-23 14:22:41',NULL,0),(17,'2020-08-20 00:00:00','2020-08-20 00:00:00','Tahun Baru Islam 1442 Hijriyah','nasional',NULL,'2020-08-23 12:25:56',NULL,0),(18,'2020-10-29 00:00:00','2020-10-29 00:00:00','Maulid Nabi Muhammad SAW','nasional',NULL,'2020-08-23 12:25:56',NULL,0),(19,'2020-12-24 00:00:00','2020-12-25 00:00:00','Hari raya Natal','nasional',NULL,'2020-08-23 13:07:01',NULL,0),(21,'2020-08-27 00:00:00','2020-08-27 00:00:00','diliburkan','private','jadwal diliburkan','2020-08-29 12:06:13',NULL,0),(22,'2020-08-20 00:00:00','2020-08-20 00:00:00','diliburkan','private','jadwal diliburkan','2020-08-29 12:06:13',NULL,0);
/*!40000 ALTER TABLE `holiday` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `room`
--

DROP TABLE IF EXISTS `room`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `room` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8 NOT NULL,
  `capacity` int(11) NOT NULL,
  `facilities` json DEFAULT NULL,
  `floor` smallint(6) NOT NULL DEFAULT '0',
  `location` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `is_available` smallint(6) DEFAULT '0',
  `is_deleted` smallint(6) DEFAULT '0',
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room`
--

LOCK TABLES `room` WRITE;
/*!40000 ALTER TABLE `room` DISABLE KEYS */;
INSERT INTO `room` VALUES (1,'MAWAR',10,'[1, 3, 4, 5, 6, 7, 9]',2,'bandung',1,0,'2020-08-30 13:27:33',NULL),(2,'DAHLIA',6,'[1, 3, 5]',2,'pasuruan',1,0,'2020-08-30 11:23:10',NULL),(6,'LINGUISTIC',10,'[1, 2, 7, 8]',2,'jakarta',0,1,'2020-08-30 16:01:00',0),(8,'test',10,'[1, 2]',2,'bandung',1,1,'2020-08-30 05:47:28',98);
/*!40000 ALTER TABLE `room` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-08-30 23:18:07
