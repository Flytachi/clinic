-- MariaDB dump 10.17  Distrib 10.5.6-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: clinic
-- ------------------------------------------------------
-- Server version	10.5.6-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bed_type`
--

DROP TABLE IF EXISTS `bed_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bed_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `price` decimal(35,0) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bed_type`
--

LOCK TABLES `bed_type` WRITE;
/*!40000 ALTER TABLE `bed_type` DISABLE KEYS */;
INSERT INTO `bed_type` VALUES (1,'Обычная',100),(2,'VIP',500);
/*!40000 ALTER TABLE `bed_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `beds`
--

DROP TABLE IF EXISTS `beds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `beds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `floor` tinyint(4) NOT NULL,
  `ward` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `types` tinyint(1) DEFAULT 0,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `beds`
--

LOCK TABLES `beds` WRITE;
/*!40000 ALTER TABLE `beds` DISABLE KEYS */;
INSERT INTO `beds` VALUES (1,1,1,1,2,45),(2,1,1,2,1,52),(4,1,2,1,1,43);
/*!40000 ALTER TABLE `beds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chat`
--

DROP TABLE IF EXISTS `chat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_push` varchar(255) DEFAULT NULL,
  `id_pull` varchar(255) DEFAULT NULL,
  `message` text CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat`
--

LOCK TABLES `chat` WRITE;
/*!40000 ALTER TABLE `chat` DISABLE KEYS */;
INSERT INTO `chat` VALUES (1,'77','66','парапрап',NULL,NULL),(2,'22','47','afdasdfasdf',NULL,NULL),(3,'22','47','авфыфаывафваф',NULL,NULL),(4,'22','47','ыф',NULL,NULL),(5,'22','47','[eq',NULL,NULL),(6,'47','22','vbcbcvb',NULL,NULL),(7,'22','47',' ghgvhnvgnvbnbvnghvjh',NULL,NULL),(8,'22','47','cvxvxcvxv',NULL,NULL),(9,'22','47','fsdfsdfa',NULL,NULL),(10,'47','33','ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss',NULL,NULL),(11,'47','33','eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee',NULL,NULL),(12,'33','22','suck',NULL,NULL),(13,'22','33','dadsda',NULL,NULL),(14,'22','33','fasdfasdf',NULL,NULL),(15,'33','22','fafasdfasdf',NULL,NULL),(16,'47','22','fdadfasfsfd',NULL,NULL),(17,'33','11','rqwerqwer',NULL,NULL),(18,'33','11','gffgssggsdfgsdfgsf',NULL,NULL),(19,'33','11','rrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr',NULL,NULL),(20,'33','53','reqwrqwer',NULL,NULL),(21,'33','11','rqerewerqwerqwr',NULL,NULL),(22,'33','11','tertrwetrwtwertwertwerter',NULL,NULL),(23,'33','11','twertwetwertwertwertwertwertwert',NULL,NULL),(24,'33','47','fasdfasds',NULL,NULL),(25,'33','47','fsdasdfasdf',NULL,NULL),(26,'33','47','eeeeeeeeeeeeeeee',NULL,NULL),(27,'33','47','fgdsfgsdfgsdfg',NULL,NULL),(28,'33','47','fasdfasdfasdf',NULL,NULL),(29,'47','22','ладно',NULL,NULL),(30,'33','22','vzcxczvcvzxcvzxcv','2020.11.18','12:57'),(31,'33','22','rtwertwertwertertre','2020.11.18','12:58'),(32,'47','22','rrrrrrrrrrrrrrrr','2020.11.18','13:00'),(33,'22','47','erqrqrqwrqwerqwer','2020.11.18','13:00'),(34,'33','47','rrrrrrrrrrrrrrrrrrrrrrtwretwer','2020.11.18','13:02'),(35,'33','47','tretwertwertwe','2020.11.18','13:02'),(36,'33','47','tttttttttttttttttttttttttttttttttttttttttttttt','2020.11.18','13:03'),(37,'47','53','rweqwrerqwrqwerer','2020.11.18','13:07'),(38,'22','33','fasdfasdfasdf','2020.11.18','13:14'),(39,'22','33','fasdfsdfasdfasdf','2020.11.18','13:15'),(40,'22','33','adfafafasfasdf','2020.11.18','13:15'),(41,'22','33','fdasfsdfas','2020.11.18','13:16'),(42,'22','33','fdsfafasdf','2020.11.18','13:17'),(43,'22','33','fdadsfasdfasdfads','2020.11.18','13:17'),(44,'22','33','fasdfasdfasf','2020.11.18','13:18'),(45,'22','33','fasdfasdfasdf','2020.11.18','13:19'),(46,'22','33','dfasdfsdfsdf','2020.11.18','13:19'),(47,'22','33','fdadfasdfasdfasdaf','2020.11.18','13:20'),(48,'22','33','fdsadfasfasf','2020.11.18','13:20'),(49,'22','33','fasdfasdfasdsdfasdfasfasfasdfsdfasdfasdfasd','2020.11.18','13:26'),(51,'22','33','dfasafdsfasdfasdfasdfasdfas','2020.11.18','13:29'),(52,'22','33','fasdfdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdf','2020.11.18','13:30'),(53,'33','47','привет ','2020.11.18','16:18'),(54,'33','47','варвшцщрйв','2020.11.18','16:19'),(55,'33','47','\nqqqqqqqqq','2020.11.18','16:19');
/*!40000 ALTER TABLE `chat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `division`
--

DROP TABLE IF EXISTS `division`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `division` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` tinyint(4) DEFAULT NULL,
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `division`
--

LOCK TABLES `division` WRITE;
/*!40000 ALTER TABLE `division` DISABLE KEYS */;
INSERT INTO `division` VALUES (1,5,'Травматалогия','Травматолог'),(2,5,'Хирургия','Хирург'),(3,5,'Стоматология','Стоматолог'),(6,5,'Радиология','Радиолог'),(7,6,'Лаборатория','Лаборант');
/*!40000 ALTER TABLE `division` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notes`
--

DROP TABLE IF EXISTS `notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notes`
--

LOCK TABLES `notes` WRITE;
/*!40000 ALTER TABLE `notes` DISABLE KEYS */;
INSERT INTO `notes` VALUES (1,'21 ноября','посетить пациента 00032'),(2,'30 ноября','поитграть ');
/*!40000 ALTER TABLE `notes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service`
--

DROP TABLE IF EXISTS `service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_level` tinyint(4) DEFAULT NULL,
  `division_id` int(11) DEFAULT NULL,
  `name` varchar(500) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `price` decimal(65,1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service`
--

LOCK TABLES `service` WRITE;
/*!40000 ALTER TABLE `service` DISABLE KEYS */;
INSERT INTO `service` VALUES (1,1,NULL,'Стационарный Осмотр',NULL),(2,5,3,'Вырвать зуб',23434.0),(4,5,6,'MRT',1000.0),(5,5,2,'Грыжа диска',100000.0),(6,5,2,'Апендицид',200.0);
/*!40000 ALTER TABLE `service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `storage_type`
--

DROP TABLE IF EXISTS `storage_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `storage_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `storage_type`
--

LOCK TABLES `storage_type` WRITE;
/*!40000 ALTER TABLE `storage_type` DISABLE KEYS */;
INSERT INTO `storage_type` VALUES (1,'Аптечный склад');
/*!40000 ALTER TABLE `storage_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `username` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `password` varchar(70) DEFAULT NULL,
  `first_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `last_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `father_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `dateBith` date DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `passport` varchar(255) DEFAULT NULL,
  `placeWork` varchar(1000) DEFAULT NULL,
  `position` varchar(1000) DEFAULT NULL,
  `numberPhone` varchar(255) DEFAULT NULL,
  `residenceAddress` varchar(1000) DEFAULT NULL,
  `registrationAddress` varchar(1000) DEFAULT NULL,
  `gender` tinyint(1) DEFAULT NULL,
  `user_level` tinyint(4) NOT NULL,
  `division_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `share` float DEFAULT 0,
  `allergy` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `add_date` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,NULL,'admin','d033e22ae348aeb5660fc2140aec35850c4da997','Jasur','Rakhmatov','Ilhomovich',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,1,99.1,NULL,'2020-10-31 17:48:15'),(2,NULL,'legion','bd53add93b49c4dff72730e05f11f1ee31074fe4','legion','legion','legion',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,2,NULL,1,20,NULL,'2020-11-08 14:03:49'),(22,NULL,'doc_3','09cad82f43c6fcf04357b175cdf4763a3daf9a89','Шерзод','Ахмедов','Турсунович',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,5,6,1,20,NULL,'2020-11-09 16:07:37'),(26,NULL,'kassa','913c8fd5abbf64f58c66b63dd31f6c310c757702','kassa','kassa','kassa',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,3,NULL,1,2,NULL,'2020-11-09 17:49:52'),(33,NULL,'doc_1','09cad82f43c6fcf04357b175cdf4763a3daf9a89','Умрбек','Юнусов','Абдурасулович',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,5,2,1,1,NULL,'2020-11-10 16:11:47'),(43,2,NULL,NULL,'Жасур','Рахматов','Ильхомович','2003-05-18','Ромитан','АВ1234567','Химчан','ИТ','998912474353','Алпомиш 9','Алпомиш 9',1,15,NULL,1,0,'Коффе','2020-11-11 14:06:10'),(44,2,NULL,NULL,'Фарход','Якубов','Абдурасулович','1988-04-19','Ромитан','АВ12345678','Химчан','ИТ','998997700870','Рухшобод 196','кучабог 8',1,15,NULL,1,0,'нет','2020-11-11 14:09:39'),(45,2,NULL,NULL,'clone','clone','clone','2003-05-18','Ромитан','АВ1234567','Химчан','ИТ','998912474353','Алпомиш 9','Алпомиш 9',1,15,NULL,1,0,'болить голова','2020-11-11 14:06:10'),(46,2,NULL,NULL,'Антон','Дяченко','Игорович','1992-01-09','Ромитан','13344455','Himcha','IT','998912474353','Рухшобот 196','Кучабох 8',1,15,NULL,NULL,0,'Торты','2020-11-12 10:17:35'),(47,NULL,'doc_2','09cad82f43c6fcf04357b175cdf4763a3daf9a89','doc','doc','doc',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,5,2,1,1,NULL,'2020-11-12 11:39:18'),(52,2,NULL,NULL,'clon','1','1','2020-11-12','Ромитан','ewqewqeqw','ewqewqeqw','qweqweqw','32424324234','qqwewqewq','weqwewq',NULL,15,NULL,1,0,'qweqwwqqwdwdq','2020-11-14 12:46:51'),(53,2,NULL,NULL,'Вадим','121','212','2000-02-21','Миробод','усусусус','усусу','усус','9963654544','всвус','усус',1,15,NULL,NULL,0,'усусусусус','2020-11-17 14:36:19');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visit`
--

DROP TABLE IF EXISTS `visit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `visit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `route_id` int(11) DEFAULT NULL,
  `direction` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `complaint` varchar(300) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `failure` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `add_date` datetime DEFAULT current_timestamp(),
  `accept_date` datetime DEFAULT NULL,
  `discharge_date` datetime DEFAULT NULL,
  `completed` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visit`
--

LOCK TABLES `visit` WRITE;
/*!40000 ALTER TABLE `visit` DISABLE KEYS */;
INSERT INTO `visit` VALUES (1,43,22,2,NULL,NULL,'Боль в спине',NULL,'2020-11-14 20:23:56','2020-11-14 20:25:24',NULL,'2020-11-14 20:25:49'),(2,43,33,2,NULL,NULL,'Нужна операция на спину',NULL,'2020-11-14 20:27:12','2020-11-14 20:27:52',NULL,'2020-11-15 01:19:39'),(3,44,33,2,NULL,NULL,'Боль в животе',NULL,'2020-11-14 20:29:03','2020-11-15 00:39:52',NULL,'2020-11-16 16:20:43'),(4,45,33,2,1,2,'Жалоба CLONe',NULL,'2020-11-15 00:38:02','2020-11-15 00:38:22',NULL,NULL),(5,43,33,2,NULL,NULL,'111',NULL,'2020-11-15 01:20:08','2020-11-15 01:20:29',NULL,'2020-11-15 01:52:33'),(6,43,33,2,NULL,NULL,'wqewqeq',NULL,'2020-11-15 01:52:52','2020-11-15 01:53:10',NULL,'2020-11-16 19:57:53'),(7,46,47,2,NULL,2,'`1',NULL,'2020-11-15 22:03:03','2020-11-16 20:42:42',NULL,NULL),(8,52,33,2,1,2,'11',NULL,'2020-11-15 22:03:38','2020-11-16 16:50:36',NULL,NULL),(9,43,22,33,NULL,NULL,NULL,NULL,'2020-11-16 15:41:18','2020-11-16 16:12:55',NULL,'2020-11-16 16:14:51'),(10,44,33,2,NULL,NULL,'Боль в животе',NULL,'2020-11-16 16:53:08','2020-11-16 16:55:06',NULL,'2020-11-16 17:16:33'),(11,44,47,33,NULL,NULL,NULL,NULL,'2020-11-16 17:08:21','2020-11-16 17:10:56',NULL,'2020-11-16 17:13:00'),(12,44,33,2,NULL,NULL,'m,nj,kj,kj,khjkh',NULL,'2020-11-16 20:18:40','2020-11-16 20:19:16',NULL,'2020-11-16 20:31:57'),(13,43,47,2,NULL,NULL,'qwqe',NULL,'2020-11-16 20:42:20','2020-11-17 17:48:25',NULL,'2020-11-17 17:49:09'),(14,46,33,47,NULL,NULL,NULL,NULL,'2020-11-17 16:56:32','2020-11-17 16:57:39',NULL,'2020-11-17 16:57:50'),(15,43,33,2,NULL,NULL,'uuuu',NULL,'2020-11-17 17:49:59','2020-11-17 17:50:40',NULL,'2020-11-17 18:01:27'),(19,43,33,2,1,NULL,'qwee',NULL,'2020-11-17 18:26:50','2020-11-17 18:27:16',NULL,'2020-11-17 18:50:52'),(20,43,33,2,1,2,'wqewqewq',NULL,'2020-11-17 18:51:52','2020-11-17 18:53:13',NULL,NULL),(21,53,22,2,NULL,NULL,NULL,NULL,'2020-11-17 19:41:46','2020-11-17 19:43:48',NULL,'2020-11-17 19:46:49'),(22,53,33,22,NULL,0,NULL,NULL,'2020-11-17 19:44:45',NULL,NULL,NULL),(23,44,33,2,NULL,2,'qwe',NULL,'2020-11-17 21:00:47','2020-11-17 21:01:22',NULL,NULL);
/*!40000 ALTER TABLE `visit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visit_price`
--

DROP TABLE IF EXISTS `visit_price`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `visit_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `visit_id` int(11) NOT NULL,
  `price_cash` decimal(65,1) DEFAULT NULL,
  `price_card` decimal(65,1) DEFAULT NULL,
  `price_transfer` decimal(65,1) DEFAULT NULL,
  `sale` tinyint(4) DEFAULT NULL,
  `price_payment` decimal(65,1) DEFAULT NULL,
  `add_date` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visit_price`
--

LOCK TABLES `visit_price` WRITE;
/*!40000 ALTER TABLE `visit_price` DISABLE KEYS */;
INSERT INTO `visit_price` VALUES (1,1,1000.0,NULL,NULL,NULL,NULL,'2020-11-14 15:24:38'),(2,2,100000.0,NULL,NULL,NULL,NULL,'2020-11-14 15:27:32'),(3,3,200.0,NULL,NULL,NULL,NULL,'2020-11-14 15:29:20'),(4,5,102000.0,NULL,NULL,NULL,NULL,'2020-11-14 20:20:21'),(5,6,100000.0,NULL,NULL,NULL,NULL,'2020-11-14 20:53:03'),(6,8,NULL,NULL,NULL,NULL,1000.0,'2020-11-15 17:32:37'),(7,9,1000.0,NULL,NULL,NULL,NULL,'2020-11-16 10:44:16'),(8,10,200.0,NULL,NULL,NULL,NULL,'2020-11-16 11:53:37'),(9,11,100000.0,NULL,NULL,NULL,NULL,'2020-11-16 12:08:56'),(10,7,100000.0,NULL,NULL,NULL,NULL,'2020-11-16 15:18:49'),(11,12,200.0,NULL,NULL,NULL,NULL,'2020-11-16 15:18:54'),(12,13,100000.0,NULL,NULL,NULL,NULL,'2020-11-16 15:42:34'),(13,14,100000.0,NULL,NULL,NULL,NULL,'2020-11-17 11:57:11'),(14,15,100000.0,NULL,NULL,NULL,NULL,'2020-11-17 12:50:12'),(15,21,1000.0,NULL,NULL,NULL,NULL,'2020-11-17 14:42:57'),(16,23,200.0,NULL,NULL,NULL,NULL,'2020-11-17 16:01:11');
/*!40000 ALTER TABLE `visit_price` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visit_service`
--

DROP TABLE IF EXISTS `visit_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `visit_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `visit_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `priced` datetime DEFAULT NULL,
  `report` text CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `completed` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visit_service`
--

LOCK TABLES `visit_service` WRITE;
/*!40000 ALTER TABLE `visit_service` DISABLE KEYS */;
INSERT INTO `visit_service` VALUES (1,1,4,'2020-11-14 20:24:38','<div id=\"exportContent\" style=\"border-radius:10px; border:0px solid #ffffff; margin-bottom:5%; margin-left:5%; margin-right:5%; margin-top:5%; outline:0px solid #000000; padding:10px; text-align:center; width:85%\">\r\n<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"height:85px; width:698px\">\r\n	<tbody>\r\n		<tr>\r\n			<td>йцйцй</td>\r\n			<td>йцйцйцйц</td>\r\n		</tr>\r\n		<tr>\r\n			<td>фывйццйу</td>\r\n			<td>йцуйу</td>\r\n		</tr>\r\n		<tr>\r\n			<td>уй</td>\r\n			<td>уйуй</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p><strong>Товар муддатли тўлов асосида</strong> <strong>тақдим қилиаыаы</strong></p>\r\n\r\n<p style=\"text-align:center\"><strong>Шартномаси № 5054-11/14q</strong></p>\r\n\r\n<p style=\"text-align:right\"><strong>14-11-2020</strong></p>\r\n\r\n<p style=\"text-align:justify\">Мен, <strong>qweq eqw eqweqw</strong> бир тарафдан ва <strong>&ldquo;Shoxona-Savdo&rdquo; МЧЖ</strong> номидан Устав асосида фаолият юритувчи ва кейинги ўринларда &ldquo;Сотувчи-товарни муддатли қарзга берувчи&rdquo; деб номланувчи директор <strong>Ж.Ҳ.Сафаров </strong>иккинчи тарафдан ушбу шартномани қуйидагилар ҳақида туздик:</p>\r\n\r\n<p style=\"text-align:center\"><strong>1. Шартнома предмети </strong></p>\r\n\r\n<p style=\"text-align:justify\">1.1. Ушбу Шартномага асосан &quot;Сотувчи-Кредит берувчи&quot; товарларни &quot;Харидор-Қарз олувчи&rdquo;нинг эгалигига топшириш, &laquo;Харидор- муддатли қарз берувчи&raquo; эса ушбу товарларни қабул қилиб олиш ва улар учун шартномада белгиланган қийматни тўлаш мажбуриятини ўз зиммасига олади.<br />\r\n1.2. &laquo;Харидор-Қарз олувчи&raquo; томонидан танланган товарларнинг миқдори ва хилма-хиллиги ушбу Шартноманинг ажралмас қисми бўлмиш 1-илованинг спецификациясида келтирилган.</p>\r\n\r\n<p style=\"text-align:center\"><strong>2. Шартнома суммаси ва хисоб-китоблар тартиби </strong></p>\r\n\r\n<p style=\"text-align:justify\">2.1. Ушбу шартноманинг суммаси <strong>1-иловада</strong> ҚҚС билан кўрсатилган.<br />\r\n2.2. Товар &laquo;Харидор-Қарз олувчи&raquo;га муддатли тўлов шартларида, ушбу Шартномада кўзда тутилган тартибда топширилади.<br />\r\n2.3. Товар &quot;Сотувчи- товарни муддатли қарзга берувчи &quot; эгалик ҳуқуқи асосида тегишли бўлиб, учинчи шахсларнинг ҳар қандай ҳуқуқларидан озод этилган, гаров билан юкланмаган, тақиқ солинмаган.<br />\r\n2.4. Ушбу Шартнома тузилганидан сўнг, &quot;Харидор-Қарз олувчи&quot; товарлар учун тўловни шартноманинг ажралмас қисми бўлган тўлов жадвалига (2-илова) мувофиқ амалга оширади.<br />\r\n2.5. &laquo;Харидор-Қарз олувчи&raquo; томонидан шартнома имзолангач, ўзининг номида бўлган пластик картани электрон тизим орқали автотўлов режимига ўтказиб бергандан сўнг, товарлар қабул қилиш-топшириш далолатномасига асосан харидорга топширилади.<br />\r\n2.6. Харид килинган товарлар қийматининг суммаси &laquo;Харидор-Қарз олувчи&raquo; томонидан муддатли тўлов асосида, тўлов жадвалида кўрсатилган сумма харидорнинг пластик картасидан автотўлов режими асосида тўлаб борилади. &laquo;Харидор-Қарз олувчи&raquo;нинг пластик картасидан автотўлов амалга оширилмаган тақдирда тўлов нақд ёки пўл кўчириш йўли билан амалга оширилади. (2-илова).<br />\r\n2.7. &laquo;Харидор-Қарз олувчи&raquo; пластик картани алмаштирган тақдирда янги олинган картани зудлик билан автотўлов режимига ўтказиш мажбуриятини олади. Агар &laquo;Харидор-Қарз олувчи&raquo; томонидан ушбу мажбурият бажарилмаганда шартнома бир томонлама бекор қилиниб, суд орқали ундириш чоралари кўрилади. 2.8. &laquo;Харидор-Қарз олувчи&raquo; томонидан ушбу шартнома имзоланганидан сўнг шартномани расмийлаштириш учун қилинадиган харажатларни қоплаш мақсадида қўшимча 30 000.0 (ўттиз минг) сўм миқдорида тўловни амалга оширади.</p>\r\n\r\n<p style=\"text-align:center\"><strong>3. Товарни такдим қилиш тартиби </strong></p>\r\n\r\n<p style=\"text-align:justify\">3.1. &quot;Сотyвчи- товарни муддатли қарзга берувчи&quot; 1-иловада келтирилган товарларни, Шартномада кўрсатилган шартлар асосида, &quot;Харидор-Қарз олувчи&quot; томонидан барча ҳужжатлар, шу жумладан, мажбуриятлар таъминоти тўғри расмийлаштирилиб, такдим этилганда топширади.<br />\r\n3.2. Товарларни такдим этиш санаси товарларнинг &quot;Сотувчи- товарни муддатли қарзга берувчи&quot; томонидан &laquo;Харидор-Қарз олувчи&raquo;га топширган санаси ҳисобланиб, &laquo;Харидор-Қарз олувчи&raquo; томонидан қабул килиш-топшириш далолатномаси имзоланиши билан тасдиқланади.<br />\r\n3.3. Товарлар &laquo;Харидор-Қарз олувчи&raquo;га ушбу Шартномада белгиланган тўлов шартларида берилади.</p>\r\n&ldquo;Сотувчи-товарни муддатли қарзга берувчи&quot; &ldquo;Харидор-Қарз олувчи&rdquo;дан мажбуриятларининг бажаришини талаб қилиш мақсадида бошқа ташкилотга ўтказган харажатлари.</div>\r\n',1),(2,2,5,'2020-11-14 20:27:32','<div id=\"exportContent\" style=\"border-radius:10px; border:0px solid #ffffff; margin-bottom:5%; margin-left:5%; margin-right:5%; margin-top:5%; outline:0px solid #000000; padding:10px; text-align:center; width:85%\">\r\n<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"height:85px; width:698px\">\r\n	<tbody>\r\n		<tr>\r\n			<td>йцйцй</td>\r\n			<td>йцйцйцйц</td>\r\n		</tr>\r\n		<tr>\r\n			<td>фывйццйу</td>\r\n			<td>йцуйу</td>\r\n		</tr>\r\n		<tr>\r\n			<td>уй</td>\r\n			<td>уйуй</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p><strong>Товар муддатли тўлов асосида</strong> <strong>тақдим қилиаыаы</strong></p>\r\n\r\n<p style=\"text-align:center\"><strong>Шартномаси № 5054-11/14q</strong></p>\r\n\r\n<p style=\"text-align:right\"><strong>14-11-2020</strong></p>\r\n\r\n<p style=\"text-align:justify\">Мен, <strong>qweq eqw eqweqw</strong> бир тарафдан ва <strong>&ldquo;Shoxona-Savdo&rdquo; МЧЖ</strong> номидан Устав асосида фаолият юритувчи ва кейинги ўринларда &ldquo;Сотувчи-товарни муддатли қарзга берувчи&rdquo; деб номланувчи директор <strong>Ж.Ҳ.Сафаров </strong>иккинчи тарафдан ушбу шартномани қуйидагилар ҳақида туздик:</p>\r\n\r\n<p style=\"text-align:center\"><strong>1. Шартнома предмети </strong></p>\r\n\r\n<p style=\"text-align:justify\">1.1. Ушбу Шартномага асосан &quot;Сотувчи-Кредит берувчи&quot; товарларни &quot;Харидор-Қарз олувчи&rdquo;нинг эгалигига топшириш, &laquo;Харидор- муддатли қарз берувчи&raquo; эса ушбу товарларни қабул қилиб олиш ва улар учун шартномада белгиланган қийматни тўлаш мажбуриятини ўз зиммасига олади.<br />\r\n1.2. &laquo;Харидор-Қарз олувчи&raquo; томонидан танланган товарларнинг миқдори ва хилма-хиллиги ушбу Шартноманинг ажралмас қисми бўлмиш 1-илованинг спецификациясида келтирилган.</p>\r\n\r\n<p style=\"text-align:center\"><strong>2. Шартнома суммаси ва хисоб-китоблар тартиби </strong></p>\r\n\r\n<p style=\"text-align:justify\">2.1. Ушбу шартноманинг суммаси <strong>1-иловада</strong> ҚҚС билан кўрсатилган.<br />\r\n2.2. Товар &laquo;Харидор-Қарз олувчи&raquo;га муддатли тўлов шартларида, ушбу Шартномада кўзда тутилган тартибда топширилади.<br />\r\n2.3. Товар &quot;Сотувчи- товарни муддатли қарзга берувчи &quot; эгалик ҳуқуқи асосида тегишли бўлиб, учинчи шахсларнинг ҳар қандай ҳуқуқларидан озод этилган, гаров билан юкланмаган, тақиқ солинмаган.<br />\r\n2.4. Ушбу Шартнома тузилганидан сўнг, &quot;Харидор-Қарз олувчи&quot; товарлар учун тўловни шартноманинг ажралмас қисми бўлган тўлов жадвалига (2-илова) мувофиқ амалга оширади.<br />\r\n2.5. &laquo;Харидор-Қарз олувчи&raquo; томонидан шартнома имзолангач, ўзининг номида бўлган пластик картани электрон тизим орқали автотўлов режимига ўтказиб бергандан сўнг, товарлар қабул қилиш-топшириш далолатномасига асосан харидорга топширилади.<br />\r\n2.6. Харид килинган товарлар қийматининг суммаси &laquo;Харидор-Қарз олувчи&raquo; томонидан муддатли тўлов асосида, тўлов жадвалида кўрсатилган сумма харидорнинг пластик картасидан автотўлов режими асосида тўлаб борилади. &laquo;Харидор-Қарз олувчи&raquo;нинг пластик картасидан автотўлов амалга оширилмаган тақдирда тўлов нақд ёки пўл кўчириш йўли билан амалга оширилади. (2-илова).<br />\r\n2.7. &laquo;Харидор-Қарз олувчи&raquo; пластик картани алмаштирган тақдирда янги олинган картани зудлик билан автотўлов режимига ўтказиш мажбуриятини олади. Агар &laquo;Харидор-Қарз олувчи&raquo; томонидан ушбу мажбурият бажарилмаганда шартнома бир томонлама бекор қилиниб, суд орқали ундириш чоралари кўрилади. 2.8. &laquo;Харидор-Қарз олувчи&raquo; томонидан ушбу шартнома имзоланганидан сўнг шартномани расмийлаштириш учун қилинадиган харажатларни қоплаш мақсадида қўшимча 30 000.0 (ўттиз минг) сўм миқдорида тўловни амалга оширади.</p>\r\n\r\n<p style=\"text-align:center\"><strong>3. Товарни такдим қилиш тартиби </strong></p>\r\n\r\n<p style=\"text-align:justify\">3.1. &quot;Сотyвчи- товарни муддатли қарзга берувчи&quot; 1-иловада келтирилган товарларни, Шартномада кўрсатилган шартлар асосида, &quot;Харидор-Қарз олувчи&quot; томонидан барча ҳужжатлар, шу жумладан, мажбуриятлар таъминоти тўғри расмийлаштирилиб, такдим этилганда топширади.<br />\r\n3.2. Товарларни такдим этиш санаси товарларнинг &quot;Сотувчи- товарни муддатли қарзга берувчи&quot; томонидан &laquo;Харидор-Қарз олувчи&raquo;га топширган санаси ҳисобланиб, &laquo;Харидор-Қарз олувчи&raquo; томонидан қабул килиш-топшириш далолатномаси имзоланиши билан тасдиқланади.<br />\r\n3.3. Товарлар &laquo;Харидор-Қарз олувчи&raquo;га ушбу Шартномада белгиланган тўлов шартларида берилади.</p>\r\n&ldquo;Сотувчи-товарни муддатли қарзга берувчи&quot; &ldquo;Харидор-Қарз олувчи&rdquo;дан мажбуриятларининг бажаришини талаб қилиш мақсадида бошқа ташкилотга ўтказган харажатлари.</div>\r\n',1),(3,3,6,'2020-11-14 20:29:20','<p>1 очёт</p>\r\n',1),(4,5,5,'2020-11-15 01:20:21','<h2 style=\"font-style:italic; text-align:center\"><span style=\"font-size:36px\"><strong>Грыжа диска</strong></span></h2>\r\n\r\n<p style=\"text-align:center\">2.1. Ушбу шартноманинг суммаси <strong>1-иловада</strong> ҚҚС билан кўрсатилган.<br />\r\n2.2. Товар &laquo;Харидор-Қарз олувчи&raquo;га муддатли тўлов шартларида, ушбу Шартномада кўзда тутилган тартибда топширилади.<br />\r\n2.3. Товар &quot;Сотувчи- товарни муддатли қарзга берувчи &quot; эгалик ҳуқуқи асосида тегишли бўлиб, учинчи шахсларнинг ҳар қандай ҳуқуқларидан озод этилган, гаров билан юкланмаган, тақиқ солинмаган.<br />\r\n2.4. Ушбу Шартнома тузилганидан сўнг, &quot;Харидор-Қарз олувчи&quot; товарлар учун тўловни шартноманинг ажралмас қисми бўлган тўлов жадвалига (2-илова) мувофиқ амалга оширади.<br />\r\n2.5. &laquo;Харидор-Қарз олувчи&raquo; томонидан шартнома имзолангач, ўзининг номида бўлган пластик картани электрон тизим орқали автотўлов режимига ўтказиб бергандан сўнг, товарлар қабул қилиш-топшириш далолатномасига асосан харидорга топширилади.<br />\r\n2.6. Харид килинган товарлар қийматининг суммаси &laquo;Харидор-Қарз олувчи&raquo; томонидан муддатли тўлов асосида, тўлов жадвалида кўрсатилган сумма харидорнинг пластик картасидан автотўлов режими асосида тўлаб борилади. &laquo;Харидор-Қарз олувчи&raquo;нинг пластик картасидан автотўлов амалга оширилмаган тақдирда тўлов нақд ёки пўл кўчириш йўли билан амалга оширилади. (2-илова).<br />\r\n2.7. &laquo;Харидор-Қарз олувчи&raquo; пластик картани алмаштирган тақдирда янги олинган картани зудлик билан автотўлов режимига ўтказиш мажбуриятини олади. Агар &laquo;Харидор-Қарз олувчи&raquo; томонидан ушбу мажбурият бажарилмаганда шартнома бир томонлама бекор қилиниб, суд орқали ундириш чоралари кўрилади. 2.8. &laquo;Харидор-Қарз олувчи&raquo; томонидан ушбу шартнома имзоланганидан сўнг шартномани расмийлаштириш учун қилинадиган харажатларни қоплаш мақсадида қўшимча 30 000.0 (ўттиз минг) сўм миқдорида тўловни амалга оширади.</p>\r\n',1),(5,5,6,'2020-11-15 01:20:21','<h2 style=\"font-style:italic; text-align:center\"><span style=\"font-size:36px\"><strong>Апендицид </strong></span></h2>\r\n\r\n<div style=\"background:#eeeeee none repeat scroll 0% 0%; border:1px solid #cccccc; padding:5px 10px; text-align:center\">Апендицит</div>\r\n\r\n<p style=\"text-align:center\">2.1. Ушбу шартноманинг суммаси <strong>1-иловада</strong> ҚҚС билан кўрсатилган.<br />\r\n2.2. Товар &laquo;Харидор-Қарз олувчи&raquo;га муддатли тўлов шартларида, ушбу Шартномада кўзда тутилган тартибда топширилади.<br />\r\n2.3. Товар &quot;Сотувчи- товарни муддатли қарзга берувчи &quot; эгалик ҳуқуқи асосида тегишли бўлиб, учинчи шахсларнинг ҳар қандай ҳуқуқларидан озод этилган, гаров билан юкланмаган, тақиқ солинмаган.<br />\r\n2.4. Ушбу Шартнома тузилганидан сўнг, &quot;Харидор-Қарз олувчи&quot; товарлар учун тўловни шартноманинг ажралмас қисми бўлган тўлов жадвалига (2-илова) мувофиқ амалга оширади.<br />\r\n2.5. &laquo;Харидор-Қарз олувчи&raquo; томонидан шартнома имзолангач, ўзининг номида бўлган пластик картани электрон тизим орқали автотўлов режимига ўтказиб бергандан сўнг, товарлар қабул қилиш-топшириш далолатномасига асосан харидорга топширилади.<br />\r\n2.6. Харид килинган товарлар қийматининг суммаси &laquo;Харидор-Қарз олувчи&raquo; томонидан муддатли тўлов асосида, тўлов жадвалида кўрсатилган сумма харидорнинг пластик картасидан автотўлов режими асосида тўлаб борилади. &laquo;Харидор-Қарз олувчи&raquo;нинг пластик картасидан автотўлов амалга оширилмаган тақдирда тўлов нақд ёки пўл кўчириш йўли билан амалга оширилади. (2-илова).<br />\r\n2.7. &laquo;Харидор-Қарз олувчи&raquo; пластик картани алмаштирган тақдирда янги олинган картани зудлик билан автотўлов режимига ўтказиш мажбуриятини олади. Агар &laquo;Харидор-Қарз олувчи&raquo; томонидан ушбу мажбурият бажарилмаганда шартнома бир томонлама бекор қилиниб, суд орқали ундириш чоралари кўрилади. 2.8. &laquo;Харидор-Қарз олувчи&raquo; томонидан ушбу шартнома имзоланганидан сўнг шартномани расмийлаштириш учун қилинадиган харажатларни қоплаш мақсадида қўшимча 30 000.0 (ўттиз минг) сўм миқдорида тўловни амалга оширади.</p>\r\n',1),(6,6,5,'2020-11-15 01:53:03','<p style=\"text-align:center\">wqewq13123212132131232111111111111111111111111111111111111111111111111111111111111111111111111133333333333333333333333333333</p>\r\n\r\n<p style=\"text-align:center\">qewqieqwiehyqwieqiehqeihqweqweqw</p>\r\n\r\n<p style=\"text-align:center\">spadkpqwkdpqkdpwqkdqwpdkwqpdkqwpdqwkdpwqkdpqwkdpqwdkqpwdkqwpdkqwpdkqwpdkqwpdkpwdqkdpkqwdpkqwpdkwpdqk</p>\r\n',1),(7,7,5,'2020-11-16 20:18:49','<p>eqweqeqweqwewqdsadsa</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>adsaasas</p>\r\n\r\n<p>asds</p>\r\n\r\n<p>a</p>\r\n\r\n<p>asdsa</p>\r\n\r\n<p>as</p>\r\n\r\n<p>dsa</p>\r\n\r\n<p>dsa</p>\r\n\r\n<p>d</p>\r\n\r\n<p>as</p>\r\n\r\n<p>das</p>\r\n\r\n<p><br />\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $(&#39;#form_&lt;?= __CLASS__ ?&gt;&#39;).submit(function(ev) {<br />\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; console.log();<br />\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; });sda</p>\r\n',1),(8,9,4,'2020-11-16 15:44:16','<p>jhgjuygjhghjgj</p>\r\n',1),(9,10,6,'2020-11-16 16:53:37','<p>Апендицит № 3</p>\r\n',1),(10,11,5,'2020-11-16 17:08:56','<p>2 отчёт Грыжа</p>\r\n',1),(11,12,6,'2020-11-16 20:18:54','<p style=\"text-align:center\">asdqwdqwdqweqweqwdx&nbsp; asdas</p>\r\n\r\n<p style=\"text-align:center\">dasd&#39;d&#39;d&#39;w</p>\r\n\r\n<p style=\"text-align:center\">asd;qwd;q]da</p>\r\n\r\n<p style=\"text-align:center\">dqdq[dlq[dq</p>\r\n\r\n<p style=\"text-align:center\">wadl[wda</p>\r\n\r\n<p style=\"text-align:center\">dlaw][dlqw]dlawlda</p>\r\n\r\n<p style=\"text-align:center\">dqld]l;qwdw</p>\r\n\r\n<p style=\"text-align:center\">adwdlq[dlqwd</p>\r\n\r\n<p style=\"text-align:center\">awd;awd.]ad;a</p>\r\n\r\n<p style=\"text-align:center\">dal;dwa;dad</p>\r\n\r\n<p style=\"text-align:center\">a</p>\r\n',1),(12,13,5,'2020-11-16 20:42:34','<p>qwewqewqewq</p>\r\n',1),(13,14,5,'2020-11-17 16:57:11','<p>qeqwewqeqweqw</p>\r\n',1),(14,15,5,'2020-11-17 17:50:12','<p>qweqweqeqwwq</p>\r\n',1),(16,19,1,NULL,NULL,NULL),(17,20,1,NULL,'<p>whhh</p>\r\n\r\n<p>&nbsp;</p>\r\n',1),(18,21,4,'2020-11-17 19:42:57','<p>,nmj,nm,nm,hj,hj,hj,hm, m ,nm,h,hnm nm ,nm&nbsp;</p>\r\n',1),(19,22,5,NULL,NULL,NULL),(20,23,6,'2020-11-17 21:01:11',NULL,NULL);
/*!40000 ALTER TABLE `visit_service` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-11-18 16:21:57
