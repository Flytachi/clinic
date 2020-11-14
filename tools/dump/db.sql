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
INSERT INTO `beds` VALUES (1,1,1,1,2,45),(2,1,1,2,1,NULL),(4,1,2,1,1,NULL);
/*!40000 ALTER TABLE `beds` ENABLE KEYS */;
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
INSERT INTO `service` VALUES (1,1,NULL,'Поддержка сайта и обеспечение безопасности',1499.9),(2,5,3,'Вырвать зуб',23434.0),(4,5,6,'MRT',1000.0),(5,5,2,'Грыжа диска',100000.0),(6,5,2,'Апендицид',200.0);
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
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,NULL,'admin','d033e22ae348aeb5660fc2140aec35850c4da997','Jasur','Rakhmatov','Ilhomovich',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,1,99.1,NULL,'2020-10-31 17:48:15'),(2,NULL,'legion','bd53add93b49c4dff72730e05f11f1ee31074fe4','legion','legion','legion',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,2,NULL,1,20,NULL,'2020-11-08 14:03:49'),(22,NULL,'doc_3','09cad82f43c6fcf04357b175cdf4763a3daf9a89','Шерзод','Ахмедов','Турсунович',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,5,6,1,20,NULL,'2020-11-09 16:07:37'),(26,NULL,'kassa','913c8fd5abbf64f58c66b63dd31f6c310c757702','kassa','kassa','kassa',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,3,NULL,1,2,NULL,'2020-11-09 17:49:52'),(33,NULL,'doc_1','09cad82f43c6fcf04357b175cdf4763a3daf9a89','Умрбек','Юнусов','Абдурасулович',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,5,2,1,1,NULL,'2020-11-10 16:11:47'),(43,2,NULL,NULL,'Жасур','Рахматов','Ильхомович','2003-05-18','Ромитан','АВ1234567','Химчан','ИТ','998912474353','Алпомиш 9','Алпомиш 9',1,15,NULL,1,0,'Коффе','2020-11-11 14:06:10'),(44,2,NULL,NULL,'Фарход','Якубов','Абдурасулович','1988-04-19','Ромитан','АВ12345678','Химчан','ИТ','998997700870','Рухшобод 196','кучабог 8',1,15,NULL,1,0,'нет','2020-11-11 14:09:39'),(45,2,NULL,NULL,'clone','clone','clone','2003-05-18','Ромитан','АВ1234567','Химчан','ИТ','998912474353','Алпомиш 9','Алпомиш 9',1,15,NULL,1,0,'болить голова','2020-11-11 14:06:10'),(46,2,NULL,NULL,'Антон','Дяченко','Игорович','1992-01-09','Ромитан','13344455','Himcha','IT','998912474353','Рухшобот 196','Кучабох 8',1,15,NULL,NULL,0,'Торты','2020-11-12 10:17:35'),(47,NULL,'doc_2','09cad82f43c6fcf04357b175cdf4763a3daf9a89','doc','doc','doc',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,5,2,1,1,NULL,'2020-11-12 11:39:18'),(52,2,NULL,NULL,'1','1','1','2020-11-12','Ромитан','ewqewqeqw','ewqewqeqw','qweqweqw','32424324234','qqwewqewq','weqwewq',NULL,15,NULL,NULL,0,'qweqwwqqwdwdq','2020-11-14 12:46:51');
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
  `completed` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visit`
--

LOCK TABLES `visit` WRITE;
/*!40000 ALTER TABLE `visit` DISABLE KEYS */;
INSERT INTO `visit` VALUES (1,43,22,2,NULL,NULL,'Боль в спине',NULL,'2020-11-14 20:23:56','2020-11-14 20:25:24','2020-11-14 20:25:49'),(2,43,33,2,NULL,NULL,'Нужна операция на спину',NULL,'2020-11-14 20:27:12','2020-11-14 20:27:52','2020-11-15 01:19:39'),(3,44,33,2,NULL,2,'Боль в животе',NULL,'2020-11-14 20:29:03','2020-11-15 00:39:52',NULL),(4,45,33,2,1,2,'Жалоба CLONe',NULL,'2020-11-15 00:38:02','2020-11-15 00:38:22',NULL),(5,43,33,2,NULL,NULL,'111',NULL,'2020-11-15 01:20:08','2020-11-15 01:20:29','2020-11-15 01:52:33'),(6,43,33,2,NULL,2,'wqewqeq',NULL,'2020-11-15 01:52:52','2020-11-15 01:53:10',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visit_price`
--

LOCK TABLES `visit_price` WRITE;
/*!40000 ALTER TABLE `visit_price` DISABLE KEYS */;
INSERT INTO `visit_price` VALUES (1,1,1000.0,NULL,NULL,NULL,NULL,'2020-11-14 15:24:38'),(2,2,100000.0,NULL,NULL,NULL,NULL,'2020-11-14 15:27:32'),(3,3,200.0,NULL,NULL,NULL,NULL,'2020-11-14 15:29:20'),(4,5,102000.0,NULL,NULL,NULL,NULL,'2020-11-14 20:20:21'),(5,6,100000.0,NULL,NULL,NULL,NULL,'2020-11-14 20:53:03');
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visit_service`
--

LOCK TABLES `visit_service` WRITE;
/*!40000 ALTER TABLE `visit_service` DISABLE KEYS */;
INSERT INTO `visit_service` VALUES (1,1,4,'2020-11-14 20:24:38','<div id=\"exportContent\" style=\"border-radius:10px; border:0px solid #ffffff; margin-bottom:5%; margin-left:5%; margin-right:5%; margin-top:5%; outline:0px solid #000000; padding:10px; text-align:center; width:85%\">\r\n<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"height:85px; width:698px\">\r\n	<tbody>\r\n		<tr>\r\n			<td>йцйцй</td>\r\n			<td>йцйцйцйц</td>\r\n		</tr>\r\n		<tr>\r\n			<td>фывйццйу</td>\r\n			<td>йцуйу</td>\r\n		</tr>\r\n		<tr>\r\n			<td>уй</td>\r\n			<td>уйуй</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p><strong>Товар муддатли тўлов асосида</strong> <strong>тақдим қилиаыаы</strong></p>\r\n\r\n<p style=\"text-align:center\"><strong>Шартномаси № 5054-11/14q</strong></p>\r\n\r\n<p style=\"text-align:right\"><strong>14-11-2020</strong></p>\r\n\r\n<p style=\"text-align:justify\">Мен, <strong>qweq eqw eqweqw</strong> бир тарафдан ва <strong>&ldquo;Shoxona-Savdo&rdquo; МЧЖ</strong> номидан Устав асосида фаолият юритувчи ва кейинги ўринларда &ldquo;Сотувчи-товарни муддатли қарзга берувчи&rdquo; деб номланувчи директор <strong>Ж.Ҳ.Сафаров </strong>иккинчи тарафдан ушбу шартномани қуйидагилар ҳақида туздик:</p>\r\n\r\n<p style=\"text-align:center\"><strong>1. Шартнома предмети </strong></p>\r\n\r\n<p style=\"text-align:justify\">1.1. Ушбу Шартномага асосан &quot;Сотувчи-Кредит берувчи&quot; товарларни &quot;Харидор-Қарз олувчи&rdquo;нинг эгалигига топшириш, &laquo;Харидор- муддатли қарз берувчи&raquo; эса ушбу товарларни қабул қилиб олиш ва улар учун шартномада белгиланган қийматни тўлаш мажбуриятини ўз зиммасига олади.<br />\r\n1.2. &laquo;Харидор-Қарз олувчи&raquo; томонидан танланган товарларнинг миқдори ва хилма-хиллиги ушбу Шартноманинг ажралмас қисми бўлмиш 1-илованинг спецификациясида келтирилган.</p>\r\n\r\n<p style=\"text-align:center\"><strong>2. Шартнома суммаси ва хисоб-китоблар тартиби </strong></p>\r\n\r\n<p style=\"text-align:justify\">2.1. Ушбу шартноманинг суммаси <strong>1-иловада</strong> ҚҚС билан кўрсатилган.<br />\r\n2.2. Товар &laquo;Харидор-Қарз олувчи&raquo;га муддатли тўлов шартларида, ушбу Шартномада кўзда тутилган тартибда топширилади.<br />\r\n2.3. Товар &quot;Сотувчи- товарни муддатли қарзга берувчи &quot; эгалик ҳуқуқи асосида тегишли бўлиб, учинчи шахсларнинг ҳар қандай ҳуқуқларидан озод этилган, гаров билан юкланмаган, тақиқ солинмаган.<br />\r\n2.4. Ушбу Шартнома тузилганидан сўнг, &quot;Харидор-Қарз олувчи&quot; товарлар учун тўловни шартноманинг ажралмас қисми бўлган тўлов жадвалига (2-илова) мувофиқ амалга оширади.<br />\r\n2.5. &laquo;Харидор-Қарз олувчи&raquo; томонидан шартнома имзолангач, ўзининг номида бўлган пластик картани электрон тизим орқали автотўлов режимига ўтказиб бергандан сўнг, товарлар қабул қилиш-топшириш далолатномасига асосан харидорга топширилади.<br />\r\n2.6. Харид килинган товарлар қийматининг суммаси &laquo;Харидор-Қарз олувчи&raquo; томонидан муддатли тўлов асосида, тўлов жадвалида кўрсатилган сумма харидорнинг пластик картасидан автотўлов режими асосида тўлаб борилади. &laquo;Харидор-Қарз олувчи&raquo;нинг пластик картасидан автотўлов амалга оширилмаган тақдирда тўлов нақд ёки пўл кўчириш йўли билан амалга оширилади. (2-илова).<br />\r\n2.7. &laquo;Харидор-Қарз олувчи&raquo; пластик картани алмаштирган тақдирда янги олинган картани зудлик билан автотўлов режимига ўтказиш мажбуриятини олади. Агар &laquo;Харидор-Қарз олувчи&raquo; томонидан ушбу мажбурият бажарилмаганда шартнома бир томонлама бекор қилиниб, суд орқали ундириш чоралари кўрилади. 2.8. &laquo;Харидор-Қарз олувчи&raquo; томонидан ушбу шартнома имзоланганидан сўнг шартномани расмийлаштириш учун қилинадиган харажатларни қоплаш мақсадида қўшимча 30 000.0 (ўттиз минг) сўм миқдорида тўловни амалга оширади.</p>\r\n\r\n<p style=\"text-align:center\"><strong>3. Товарни такдим қилиш тартиби </strong></p>\r\n\r\n<p style=\"text-align:justify\">3.1. &quot;Сотyвчи- товарни муддатли қарзга берувчи&quot; 1-иловада келтирилган товарларни, Шартномада кўрсатилган шартлар асосида, &quot;Харидор-Қарз олувчи&quot; томонидан барча ҳужжатлар, шу жумладан, мажбуриятлар таъминоти тўғри расмийлаштирилиб, такдим этилганда топширади.<br />\r\n3.2. Товарларни такдим этиш санаси товарларнинг &quot;Сотувчи- товарни муддатли қарзга берувчи&quot; томонидан &laquo;Харидор-Қарз олувчи&raquo;га топширган санаси ҳисобланиб, &laquo;Харидор-Қарз олувчи&raquo; томонидан қабул килиш-топшириш далолатномаси имзоланиши билан тасдиқланади.<br />\r\n3.3. Товарлар &laquo;Харидор-Қарз олувчи&raquo;га ушбу Шартномада белгиланган тўлов шартларида берилади.</p>\r\n&ldquo;Сотувчи-товарни муддатли қарзга берувчи&quot; &ldquo;Харидор-Қарз олувчи&rdquo;дан мажбуриятларининг бажаришини талаб қилиш мақсадида бошқа ташкилотга ўтказган харажатлари.</div>\r\n',1),(2,2,5,'2020-11-14 20:27:32','<div id=\"exportContent\" style=\"border-radius:10px; border:0px solid #ffffff; margin-bottom:5%; margin-left:5%; margin-right:5%; margin-top:5%; outline:0px solid #000000; padding:10px; text-align:center; width:85%\">\r\n<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"height:85px; width:698px\">\r\n	<tbody>\r\n		<tr>\r\n			<td>йцйцй</td>\r\n			<td>йцйцйцйц</td>\r\n		</tr>\r\n		<tr>\r\n			<td>фывйццйу</td>\r\n			<td>йцуйу</td>\r\n		</tr>\r\n		<tr>\r\n			<td>уй</td>\r\n			<td>уйуй</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p><strong>Товар муддатли тўлов асосида</strong> <strong>тақдим қилиаыаы</strong></p>\r\n\r\n<p style=\"text-align:center\"><strong>Шартномаси № 5054-11/14q</strong></p>\r\n\r\n<p style=\"text-align:right\"><strong>14-11-2020</strong></p>\r\n\r\n<p style=\"text-align:justify\">Мен, <strong>qweq eqw eqweqw</strong> бир тарафдан ва <strong>&ldquo;Shoxona-Savdo&rdquo; МЧЖ</strong> номидан Устав асосида фаолият юритувчи ва кейинги ўринларда &ldquo;Сотувчи-товарни муддатли қарзга берувчи&rdquo; деб номланувчи директор <strong>Ж.Ҳ.Сафаров </strong>иккинчи тарафдан ушбу шартномани қуйидагилар ҳақида туздик:</p>\r\n\r\n<p style=\"text-align:center\"><strong>1. Шартнома предмети </strong></p>\r\n\r\n<p style=\"text-align:justify\">1.1. Ушбу Шартномага асосан &quot;Сотувчи-Кредит берувчи&quot; товарларни &quot;Харидор-Қарз олувчи&rdquo;нинг эгалигига топшириш, &laquo;Харидор- муддатли қарз берувчи&raquo; эса ушбу товарларни қабул қилиб олиш ва улар учун шартномада белгиланган қийматни тўлаш мажбуриятини ўз зиммасига олади.<br />\r\n1.2. &laquo;Харидор-Қарз олувчи&raquo; томонидан танланган товарларнинг миқдори ва хилма-хиллиги ушбу Шартноманинг ажралмас қисми бўлмиш 1-илованинг спецификациясида келтирилган.</p>\r\n\r\n<p style=\"text-align:center\"><strong>2. Шартнома суммаси ва хисоб-китоблар тартиби </strong></p>\r\n\r\n<p style=\"text-align:justify\">2.1. Ушбу шартноманинг суммаси <strong>1-иловада</strong> ҚҚС билан кўрсатилган.<br />\r\n2.2. Товар &laquo;Харидор-Қарз олувчи&raquo;га муддатли тўлов шартларида, ушбу Шартномада кўзда тутилган тартибда топширилади.<br />\r\n2.3. Товар &quot;Сотувчи- товарни муддатли қарзга берувчи &quot; эгалик ҳуқуқи асосида тегишли бўлиб, учинчи шахсларнинг ҳар қандай ҳуқуқларидан озод этилган, гаров билан юкланмаган, тақиқ солинмаган.<br />\r\n2.4. Ушбу Шартнома тузилганидан сўнг, &quot;Харидор-Қарз олувчи&quot; товарлар учун тўловни шартноманинг ажралмас қисми бўлган тўлов жадвалига (2-илова) мувофиқ амалга оширади.<br />\r\n2.5. &laquo;Харидор-Қарз олувчи&raquo; томонидан шартнома имзолангач, ўзининг номида бўлган пластик картани электрон тизим орқали автотўлов режимига ўтказиб бергандан сўнг, товарлар қабул қилиш-топшириш далолатномасига асосан харидорга топширилади.<br />\r\n2.6. Харид килинган товарлар қийматининг суммаси &laquo;Харидор-Қарз олувчи&raquo; томонидан муддатли тўлов асосида, тўлов жадвалида кўрсатилган сумма харидорнинг пластик картасидан автотўлов режими асосида тўлаб борилади. &laquo;Харидор-Қарз олувчи&raquo;нинг пластик картасидан автотўлов амалга оширилмаган тақдирда тўлов нақд ёки пўл кўчириш йўли билан амалга оширилади. (2-илова).<br />\r\n2.7. &laquo;Харидор-Қарз олувчи&raquo; пластик картани алмаштирган тақдирда янги олинган картани зудлик билан автотўлов режимига ўтказиш мажбуриятини олади. Агар &laquo;Харидор-Қарз олувчи&raquo; томонидан ушбу мажбурият бажарилмаганда шартнома бир томонлама бекор қилиниб, суд орқали ундириш чоралари кўрилади. 2.8. &laquo;Харидор-Қарз олувчи&raquo; томонидан ушбу шартнома имзоланганидан сўнг шартномани расмийлаштириш учун қилинадиган харажатларни қоплаш мақсадида қўшимча 30 000.0 (ўттиз минг) сўм миқдорида тўловни амалга оширади.</p>\r\n\r\n<p style=\"text-align:center\"><strong>3. Товарни такдим қилиш тартиби </strong></p>\r\n\r\n<p style=\"text-align:justify\">3.1. &quot;Сотyвчи- товарни муддатли қарзга берувчи&quot; 1-иловада келтирилган товарларни, Шартномада кўрсатилган шартлар асосида, &quot;Харидор-Қарз олувчи&quot; томонидан барча ҳужжатлар, шу жумладан, мажбуриятлар таъминоти тўғри расмийлаштирилиб, такдим этилганда топширади.<br />\r\n3.2. Товарларни такдим этиш санаси товарларнинг &quot;Сотувчи- товарни муддатли қарзга берувчи&quot; томонидан &laquo;Харидор-Қарз олувчи&raquo;га топширган санаси ҳисобланиб, &laquo;Харидор-Қарз олувчи&raquo; томонидан қабул килиш-топшириш далолатномаси имзоланиши билан тасдиқланади.<br />\r\n3.3. Товарлар &laquo;Харидор-Қарз олувчи&raquo;га ушбу Шартномада белгиланган тўлов шартларида берилади.</p>\r\n&ldquo;Сотувчи-товарни муддатли қарзга берувчи&quot; &ldquo;Харидор-Қарз олувчи&rdquo;дан мажбуриятларининг бажаришини талаб қилиш мақсадида бошқа ташкилотга ўтказган харажатлари.</div>\r\n',1),(3,3,6,'2020-11-14 20:29:20',NULL,NULL),(4,5,5,'2020-11-15 01:20:21','<h2 style=\"font-style:italic; text-align:center\"><span style=\"font-size:36px\"><strong>Отчёт</strong></span></h2>\r\n\r\n<p style=\"text-align:center\">2.1. Ушбу шартноманинг суммаси <strong>1-иловада</strong> ҚҚС билан кўрсатилган.<br />\r\n2.2. Товар &laquo;Харидор-Қарз олувчи&raquo;га муддатли тўлов шартларида, ушбу Шартномада кўзда тутилган тартибда топширилади.<br />\r\n2.3. Товар &quot;Сотувчи- товарни муддатли қарзга берувчи &quot; эгалик ҳуқуқи асосида тегишли бўлиб, учинчи шахсларнинг ҳар қандай ҳуқуқларидан озод этилган, гаров билан юкланмаган, тақиқ солинмаган.<br />\r\n2.4. Ушбу Шартнома тузилганидан сўнг, &quot;Харидор-Қарз олувчи&quot; товарлар учун тўловни шартноманинг ажралмас қисми бўлган тўлов жадвалига (2-илова) мувофиқ амалга оширади.<br />\r\n2.5. &laquo;Харидор-Қарз олувчи&raquo; томонидан шартнома имзолангач, ўзининг номида бўлган пластик картани электрон тизим орқали автотўлов режимига ўтказиб бергандан сўнг, товарлар қабул қилиш-топшириш далолатномасига асосан харидорга топширилади.<br />\r\n2.6. Харид килинган товарлар қийматининг суммаси &laquo;Харидор-Қарз олувчи&raquo; томонидан муддатли тўлов асосида, тўлов жадвалида кўрсатилган сумма харидорнинг пластик картасидан автотўлов режими асосида тўлаб борилади. &laquo;Харидор-Қарз олувчи&raquo;нинг пластик картасидан автотўлов амалга оширилмаган тақдирда тўлов нақд ёки пўл кўчириш йўли билан амалга оширилади. (2-илова).<br />\r\n2.7. &laquo;Харидор-Қарз олувчи&raquo; пластик картани алмаштирган тақдирда янги олинган картани зудлик билан автотўлов режимига ўтказиш мажбуриятини олади. Агар &laquo;Харидор-Қарз олувчи&raquo; томонидан ушбу мажбурият бажарилмаганда шартнома бир томонлама бекор қилиниб, суд орқали ундириш чоралари кўрилади. 2.8. &laquo;Харидор-Қарз олувчи&raquo; томонидан ушбу шартнома имзоланганидан сўнг шартномани расмийлаштириш учун қилинадиган харажатларни қоплаш мақсадида қўшимча 30 000.0 (ўттиз минг) сўм миқдорида тўловни амалга оширади.</p>\r\n',1),(5,5,6,'2020-11-15 01:20:21','<h2 style=\"font-style:italic; text-align:center\"><span style=\"font-size:36px\"><strong>Отчёт 2 </strong></span></h2>\r\n\r\n<div style=\"background:#eeeeee none repeat scroll 0% 0%; border:1px solid #cccccc; padding:5px 10px; text-align:center\">Апендицит</div>\r\n\r\n<p style=\"text-align:center\">2.1. Ушбу шартноманинг суммаси <strong>1-иловада</strong> ҚҚС билан кўрсатилган.<br />\r\n2.2. Товар &laquo;Харидор-Қарз олувчи&raquo;га муддатли тўлов шартларида, ушбу Шартномада кўзда тутилган тартибда топширилади.<br />\r\n2.3. Товар &quot;Сотувчи- товарни муддатли қарзга берувчи &quot; эгалик ҳуқуқи асосида тегишли бўлиб, учинчи шахсларнинг ҳар қандай ҳуқуқларидан озод этилган, гаров билан юкланмаган, тақиқ солинмаган.<br />\r\n2.4. Ушбу Шартнома тузилганидан сўнг, &quot;Харидор-Қарз олувчи&quot; товарлар учун тўловни шартноманинг ажралмас қисми бўлган тўлов жадвалига (2-илова) мувофиқ амалга оширади.<br />\r\n2.5. &laquo;Харидор-Қарз олувчи&raquo; томонидан шартнома имзолангач, ўзининг номида бўлган пластик картани электрон тизим орқали автотўлов режимига ўтказиб бергандан сўнг, товарлар қабул қилиш-топшириш далолатномасига асосан харидорга топширилади.<br />\r\n2.6. Харид килинган товарлар қийматининг суммаси &laquo;Харидор-Қарз олувчи&raquo; томонидан муддатли тўлов асосида, тўлов жадвалида кўрсатилган сумма харидорнинг пластик картасидан автотўлов режими асосида тўлаб борилади. &laquo;Харидор-Қарз олувчи&raquo;нинг пластик картасидан автотўлов амалга оширилмаган тақдирда тўлов нақд ёки пўл кўчириш йўли билан амалга оширилади. (2-илова).<br />\r\n2.7. &laquo;Харидор-Қарз олувчи&raquo; пластик картани алмаштирган тақдирда янги олинган картани зудлик билан автотўлов режимига ўтказиш мажбуриятини олади. Агар &laquo;Харидор-Қарз олувчи&raquo; томонидан ушбу мажбурият бажарилмаганда шартнома бир томонлама бекор қилиниб, суд орқали ундириш чоралари кўрилади. 2.8. &laquo;Харидор-Қарз олувчи&raquo; томонидан ушбу шартнома имзоланганидан сўнг шартномани расмийлаштириш учун қилинадиган харажатларни қоплаш мақсадида қўшимча 30 000.0 (ўттиз минг) сўм миқдорида тўловни амалга оширади.</p>\r\n',1),(6,6,5,'2020-11-15 01:53:03',NULL,NULL);
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

-- Dump completed on 2020-11-15  2:26:24
