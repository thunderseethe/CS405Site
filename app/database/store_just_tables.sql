-- MySQL dump 10.13  Distrib 5.6.21, for osx10.8 (x86_64)
--
-- Host: localhost    Database: store
-- ------------------------------------------------------
-- Server version	5.6.21

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
-- Table structure for table `auctions`
--

DROP TABLE IF EXISTS `auctions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auctions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `end` timestamp NULL DEFAULT NULL,
  `status` varchar(64) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auctions`
--

LOCK TABLES `auctions` WRITE;
/*!40000 ALTER TABLE `auctions` DISABLE KEYS */;
INSERT INTO `auctions` VALUES (1,2,4,'2014-11-29 03:41:16','Shipped','2014-11-29 12:25:01',NULL),(2,2,3,'2014-11-29 03:46:32','Pending',NULL,NULL);
/*!40000 ALTER TABLE `auctions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bids`
--

DROP TABLE IF EXISTS `bids`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bids` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `auction_id` int(11) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bids`
--

LOCK TABLES `bids` WRITE;
/*!40000 ALTER TABLE `bids` DISABLE KEYS */;
INSERT INTO `bids` VALUES (8,3,1,1.5,'2014-11-28 08:06:02','2014-11-28 08:06:02','2014-11-28 08:06:02'),(9,3,1,1.75,'2014-11-28 08:06:41','2014-11-28 08:06:41','2014-11-28 08:06:41'),(10,3,1,1,'2014-11-28 08:07:41','2014-11-28 08:07:41','2014-11-28 08:07:41'),(11,5,1,1.25,'2014-11-28 13:51:35','2014-11-28 13:51:35','2014-11-28 13:51:35'),(12,5,2,3,'2014-11-29 10:32:13','2014-11-29 10:32:13','2014-11-29 10:32:13');
/*!40000 ALTER TABLE `bids` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `items` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  `description` text,
  `keywords` text,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` VALUES (1,'test item 1','A description for test item 1','test,item,1,description,useless',NULL,NULL),(2,'test item 2','A description for test item 2','test,item,2,description,useless',NULL,NULL),(3,'shampoo','Cleans your hair','cleans,hygiene,hair,shower',NULL,NULL),(4,'hammer','Also cleans hair, and hammers nails','cleans,hygiene,hair,nails',NULL,NULL),(5,'test item 3','A description for test item 3','test,item,3,description,useless\n',NULL,NULL),(23,'Tusk','A tusk of an elephant','tusk,elephant,ivory','2014-11-29 11:51:58','2014-11-29 11:51:58'),(24,'ItemAdder','Adds Items','add,items,verb','2014-11-29 11:54:34','2014-11-29 11:54:34');
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ordereditems`
--

DROP TABLE IF EXISTS `ordereditems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ordereditems` (
  `order_id` int(11) unsigned NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordereditems`
--

LOCK TABLES `ordereditems` WRITE;
/*!40000 ALTER TABLE `ordereditems` DISABLE KEYS */;
INSERT INTO `ordereditems` VALUES (12,1,2,3.25),(12,2,2,2.5),(12,3,2,1.75),(13,1,2,3.25),(13,3,3,1.75),(17,1,1,3.25),(18,1,1,1.25),(23,1,1,3.25),(23,2,2,2.25);
/*!40000 ALTER TABLE `ordereditems` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `status` varchar(64) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (12,3,1,'2014-11-21 11:08:12','Shipped','2014-11-24 00:31:56','2014-11-21 11:08:12'),(13,3,1,'2014-11-24 19:19:58','Shipped','2014-11-24 19:26:16','2014-11-24 19:19:58'),(17,3,1,'2014-11-26 09:02:37','Pending','2014-11-26 09:02:37','2014-11-26 09:02:37'),(18,3,2,'2014-11-26 09:02:37','Pending','2014-11-26 09:02:37','2014-11-26 09:02:37'),(23,3,1,'2014-11-27 19:58:17','Pending','2014-11-27 19:58:17','2014-11-27 19:58:17');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stocks`
--

DROP TABLE IF EXISTS `stocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stocks` (
  `store_id` int(11) unsigned NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `type` int(1) DEFAULT NULL,
  `promotion_rate` double DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stocks`
--

LOCK TABLES `stocks` WRITE;
/*!40000 ALTER TABLE `stocks` DISABLE KEYS */;
INSERT INTO `stocks` VALUES (1,1,4,3.25,0,1),(1,2,4,2.5,0,0.9),(1,3,3,1.75,0,1),(2,1,100,1.25,0,1),(2,3,6,2,1,1),(2,4,15,6,1,1),(1,5,12,4,0,1),(2,11,2,107.25,0,1),(2,12,2,107.25,0,1),(2,13,2,107.25,0,1),(2,14,2,107.25,0,1),(2,19,NULL,NULL,1,1),(2,20,NULL,NULL,1,1),(2,21,NULL,NULL,1,1),(2,22,NULL,NULL,1,1),(2,24,10,50.34,0,1);
/*!40000 ALTER TABLE `stocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stores`
--

DROP TABLE IF EXISTS `stores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stores` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stores`
--

LOCK TABLES `stores` WRITE;
/*!40000 ALTER TABLE `stores` DISABLE KEYS */;
INSERT INTO `stores` VALUES (1,3,'Stores R Us','The main store for our site, selling a lot of items...mostly test items',NULL,NULL),(2,5,'TomStore','Hi, I\'m Tom. this is my store, come and buy something. I added to the description. Add some more to double check.',NULL,'2014-11-28 11:45:29');
/*!40000 ALTER TABLE `stores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(64) DEFAULT NULL,
  `last_name` varchar(64) DEFAULT NULL,
  `username` varchar(64) DEFAULT NULL,
  `type` int(1) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `remember_token` varchar(128) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Emily','Thorn','emily',1,'$2y$10$exGNLDw156NftFX1ZZcOEePRRBGzw9NTlvWxPKVvimNpOyY1sgsPS',NULL,'2014-11-13 09:50:03','2014-11-13 09:50:03'),(2,'Fred','Jackson','fred',3,'$2y$10$hegpg93ihZ0ghJdDmWPhDuBZMMuDkV2KdfT6lqA/8uPl0bCJtucfC','WseyiyiTH5UpmutL2afcH8pSIJNZCqbNI021zKER8Q3NUJN9cphhuFqSU3Ls','2014-11-13 09:50:03','2014-11-28 11:20:47'),(3,'Ethan','Smith','ethan',4,'$2y$10$yn/6DWQGA0tTdHiJiI650eM/FKXfDxHTo19dTWzgF7ICC5fOWwgZ2','7hn6zjWa5A48iny3IQW1NNh6LvYbtP72y8ii6nqRScZtffipCI4ugyAOG0Jd','2014-11-13 09:50:03','2014-11-28 09:41:00'),(5,'Tom','Ford','tom',2,'$2y$10$k7ox0c1a/e7Mdu4Y9.6ggOwFd9qUX4KwQzHgRfuPMgL9kaq/GwwU.','yKGq70hR6cgJaMKE2InAaKkhw5LXxwIFAtpS0Bi83DL1ptkp261HZ0MZRcJg','2014-11-18 00:33:15','2014-11-28 10:14:25');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-11-29 13:14:16
