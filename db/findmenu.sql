CREATE DATABASE  IF NOT EXISTS `findmenu` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `findmenu`;
-- MySQL dump 10.13  Distrib 5.7.9, for linux-glibc2.5 (x86_64)
--
-- Host: localhost    Database: rural_shop
-- ------------------------------------------------------
-- Server version	5.6.27-0ubuntu0.15.04.1

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
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menus` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `bar_name` varchar(100) NOT NULL,
  `price` float NOT NULL DEFAULT '0',
  `categorie` varchar(100) DEFAULT NULL,/* checkboxes 1 o mas tipos (almuerzo, comida...)*/
  `description` varchar(180) DEFAULT NULL,
  `push_date` varchar(10) DEFAULT NULL,/* Fecha de añadido*/
  `expiry_date` varchar(10) DEFAULT NULL,/*Fecha limite de ofrecer el menu*/
  `bar_email` varchar(100) DEFAULT NULL,
  `bar_phone` varchar(20) DEFAULT NULL,
  `country` varchar(30) DEFAULT NULL,
  `province` varchar(30) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` (`product_name`, `price`, `description`, `discharge_date`, `expiry_date`, `provider_email`, `provider_phone`,`country`,`province`,`city`, `season`, `categorie`, `avatar` )
VALUES ('First_product','100.11', 'This is the first innsert on database product', '9/10/2016','19/10/2016','firstmail@gmail.com','+34 666 555 444','Spain','Valencia','Ontinyent','All','Electronics:Other', '/media/default-avatar.png');
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;


DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `birthdate` varchar(10) DEFAULT NULL,
  `singindate` varchar(10) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `user` varchar(50) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `usertype` varchar(10) DEFAULT NULL,
  `avatar` varchar(200) DEFAULT NULL,
  `country` varchar(45) DEFAULT NULL,
  `province` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `favorites` varchar(200) DEFAULT NULL,/*id de los menus favoritos del usuario */
  `active` boolean DEFAULT NULL,
  `token` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`name`, `lastname`, `birthdate`, `singindate`, `email`, `user`, `password`, `usertype`,`avatar`,`country`,`province`,`city`, `favorites`, `active`, `token` )
VALUES ('Jordi','Martinez Frias','20/12/1982','01/12/2016','jordimart@gmail.com','jordimart','pass_jordi123','admin','default-avatar.png','ES','46','Ontinyent', '101:103:104:105', '1', 'wefPFve09eEvveffEEFEe9E'),
('Oscar','Otero Millán','5/5/1986','25/12/2016','oscarompro@gmail.com','Partida lombria','osotemi','pass_oscar123','default-avatar.png','ES','46','Ontinyent', '101:102:105', '1', 'wsc23eE2y5U655hefPFve09eEvveffEEFEe9E');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-11-04 18:58:01
