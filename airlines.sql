CREATE DATABASE  IF NOT EXISTS `airlines` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `airlines`;
-- MySQL dump 10.13  Distrib 5.6.17, for Win32 (x86)
--
-- Host: localhost    Database: airlines
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.9-MariaDB

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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `A_id` int(11) NOT NULL AUTO_INCREMENT,
  `A_name` varchar(45) NOT NULL,
  `A_pass` varchar(260) NOT NULL,
  PRIMARY KEY (`A_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'admin','d033e22ae348aeb5660fc2140aec35850c4da997');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer` (
  `C_id` int(11) NOT NULL AUTO_INCREMENT,
  `C_Fname` varchar(45) NOT NULL,
  `C_Lname` varchar(45) NOT NULL,
  `C_Trdoc` varchar(25) NOT NULL,
  `C_Bdate` date NOT NULL,
  PRIMARY KEY (`C_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `itinerary`
--

DROP TABLE IF EXISTS `itinerary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `itinerary` (
  `I_id` int(11) NOT NULL AUTO_INCREMENT,
  `I_dep` varchar(45) NOT NULL,
  `I_arr` varchar(45) NOT NULL,
  `I_dist` int(11) NOT NULL,
  `I_num` varchar(45) NOT NULL,
  `I_disc` int(11) DEFAULT '0',
  `I_Pid` int(11) DEFAULT NULL,
  `I_deptime` varchar(10) NOT NULL DEFAULT '0',
  `I_arrtime` varchar(10) NOT NULL DEFAULT '0',
  `I_active` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`I_id`),
  UNIQUE KEY `I_num_UNIQUE` (`I_num`),
  KEY `Pl_id_idx` (`I_Pid`),
  CONSTRAINT `Pl_id` FOREIGN KEY (`I_Pid`) REFERENCES `plane` (`Pl_id`) ON DELETE NO ACTION ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `itinerary`
--

LOCK TABLES `itinerary` WRITE;
/*!40000 ALTER TABLE `itinerary` DISABLE KEYS */;
INSERT INTO `itinerary` VALUES (1,'Αθήνα','Θεσσαλονίκη',360,'AS-238',0,1,'07:00','08:00',1),(2,'Αθήνα','Ρόδος',280,'AR-421',0,1,'20:00','21:00',1),(3,'Αθήνα','Χανιά',200,'AC-750',0,3,'08:00','08:50',1),(4,'Αθήνα','Αλεξανδρούπολη',440,'AA-078',20,3,'22:00','23:10',1),(5,'Θεσσαλονίκη','Αθήνα',360,'AS-338',10,1,'08:30','09:30',1),(6,'Θεσσαλονίκη','Ρόδος',350,'SR-145',0,2,'06:05','07:10',1),(7,'Θεσσαλονίκη','Χανιά',500,'SC-754',0,2,'18:30','20:00',1),(8,'Ρόδος','Αθήνα',280,'AR-521',0,1,'21:30','22:30',1),(9,'Ρόδος','Θεσσαλονίκη',350,'SR-245',0,2,'07:40','08:45',1),(10,'Ρόδος','Αλεξανδρούπολη',240,'RA-980',0,4,'13:30','14:00',1),(11,'Χανιά','Αθήνα',200,'AC-850',0,3,'09:20','10:10',1),(12,'Χανιά','Θεσσαλονίκη',500,'SC-854',0,2,'20:30','22:00',1),(13,'Χανιά','Αλεξανδρούπολη',600,'CA-361',0,4,'21:40','23:20',1),(14,'Αλεξανδρούπολη','Αθήνα',440,'AA-178',0,3,'23:40','00:50',1),(15,'Αλεξανδρούπολη','Ρόδος',240,'RA-080',0,4,'12:00','13:00',1),(16,'Αλεξανδρούπολη','Χανιά',600,'CA-461',0,4,'19:30','21:10',1),(17,'Ζαχάρω','Χαλκιδική',550,'SKK  778',15,1,'08:03','09:17',0),(18,'Ζαχάρω','Θεσσαλονίκη',500,'SK-778',0,1,'00:02','03:06',1),(19,'Θεσσαλονίκη','Χαλκιδική',200,'SC-778',0,3,'14:40','1515',0),(20,'Αθήνα','Μύκονος',246,'AB-458',0,4,'11:05','11:55',1),(21,'Θεσσαλονίκη','Ζαχάρω',500,'SK-779',0,2,'03:01','04:00',1),(22,'Μύκονος','Αθήνα',246,'AB-459',0,6,'02:04','03:04',1);
/*!40000 ALTER TABLE `itinerary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `period`
--

DROP TABLE IF EXISTS `period`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `period` (
  `Pe_id` int(11) NOT NULL AUTO_INCREMENT,
  `Pe_startdate` date NOT NULL,
  `Pe_findate` date NOT NULL,
  `Pe_type` varchar(15) NOT NULL,
  PRIMARY KEY (`Pe_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `period`
--

LOCK TABLES `period` WRITE;
/*!40000 ALTER TABLE `period` DISABLE KEYS */;
INSERT INTO `period` VALUES (1,'2016-11-01','2017-04-30','low'),(2,'2016-06-01','2016-06-30','medium'),(3,'2016-09-01','2016-10-31','medium'),(4,'2016-07-01','2016-08-31','high');
/*!40000 ALTER TABLE `period` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plane`
--

DROP TABLE IF EXISTS `plane`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plane` (
  `Pl_id` int(11) NOT NULL AUTO_INCREMENT,
  `Pl_type` varchar(45) NOT NULL,
  `Pl_seats` int(11) NOT NULL,
  `Pl_dist` int(11) NOT NULL,
  `Pl_active` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Pl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plane`
--

LOCK TABLES `plane` WRITE;
/*!40000 ALTER TABLE `plane` DISABLE KEYS */;
INSERT INTO `plane` VALUES (1,'Airbus A330-200',246,7260,1),(2,'Boeing 737-800',186,3060,1),(3,'Bombardier Q-400',78,1362,1),(4,'Antonov AN-158',96,1600,1),(5,'Concorde',306,8800,0),(6,'Concorde2',306,8800,1),(7,'Concorde3',312,550,0);
/*!40000 ALTER TABLE `plane` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `price`
--

DROP TABLE IF EXISTS `price`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `price` (
  `Pr_id` int(11) NOT NULL AUTO_INCREMENT,
  `Pr_Iid` int(11) NOT NULL,
  `Pr_Cost` int(11) NOT NULL,
  `Pr_Peid` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Pr_id`),
  KEY `I_id_idx` (`Pr_Iid`),
  KEY `Pr_Peid_idx` (`Pr_Peid`),
  CONSTRAINT `I_id` FOREIGN KEY (`Pr_Iid`) REFERENCES `itinerary` (`I_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `Pr_Peid` FOREIGN KEY (`Pr_Peid`) REFERENCES `period` (`Pe_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `price`
--

LOCK TABLES `price` WRITE;
/*!40000 ALTER TABLE `price` DISABLE KEYS */;
INSERT INTO `price` VALUES (1,1,29,1),(2,1,49,2),(3,1,69,4),(4,2,50,1),(5,2,60,2),(6,2,80,4),(7,3,39,1),(8,3,49,2),(9,3,59,4),(10,4,48,1),(11,4,58,2),(12,4,68,4),(13,5,29,1),(14,5,49,2),(15,5,69,4),(16,6,55,1),(17,6,65,2),(18,6,85,4),(19,7,34,1),(20,7,46,2),(21,7,58,4),(22,8,47,1),(23,8,57,2),(24,8,62,4),(25,9,34,1),(26,9,48,2),(27,9,60,4),(28,10,43,1),(29,10,57,2),(30,10,63,4),(31,11,33,1),(32,11,44,2),(33,11,55,4),(34,12,28,1),(35,12,36,2),(36,12,47,4),(37,13,39,1),(38,13,45,2),(39,13,58,4),(40,14,44,1),(41,14,56,2),(42,14,63,4),(43,15,27,1),(44,15,39,2),(45,15,53,4),(46,16,32,1),(47,16,47,2),(48,16,58,4),(50,1,49,3),(51,2,60,3),(52,3,49,3),(53,4,58,3),(54,5,49,3),(55,6,65,3),(56,7,46,3),(57,8,57,3),(58,9,48,3),(59,10,57,3),(60,11,44,3),(61,12,36,3),(62,13,45,3),(63,14,56,3),(64,15,39,3),(65,16,47,3),(66,17,49,1),(67,17,59,2),(68,17,59,3),(69,17,89,4),(70,18,0,1),(71,18,0,2),(72,18,0,3),(73,18,0,4),(74,19,0,1),(75,19,0,2),(76,19,0,3),(77,19,0,4),(78,20,19,1),(79,20,39,2),(80,20,39,3),(81,20,69,4),(82,21,25,1),(83,21,35,2),(84,21,35,3),(85,21,55,4),(86,22,0,1),(87,22,0,2),(88,22,0,3),(89,22,0,4);
/*!40000 ALTER TABLE `price` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reserve`
--

DROP TABLE IF EXISTS `reserve`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reserve` (
  `R_id` int(11) NOT NULL AUTO_INCREMENT,
  `R_Cid` int(11) DEFAULT NULL,
  `R_etick` varchar(45) DEFAULT NULL,
  `R_Prid` int(11) DEFAULT NULL,
  `R_seat` varchar(5) DEFAULT NULL,
  `R_seattype` varchar(10) DEFAULT NULL,
  `R_dep` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`R_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-06-23 10:00:29
