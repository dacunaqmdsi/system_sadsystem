/*
SQLyog Ultimate v8.55 
MySQL - 5.5.5-10.4.32-MariaDB : Database - inventory
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `tblaccounts` */

DROP TABLE IF EXISTS `tblaccounts`;

CREATE TABLE `tblaccounts` (
  `accountid` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(128) DEFAULT '',
  `username` varchar(128) DEFAULT '',
  `account_password` varchar(128) DEFAULT '',
  `first_name` varchar(128) DEFAULT '',
  `last_name` varchar(128) DEFAULT '',
  `middle_name` varchar(128) DEFAULT '',
  `address` varchar(255) DEFAULT '',
  `age` int(11) DEFAULT 0,
  `email_address` varchar(128) DEFAULT '',
  `contact_number` varchar(128) DEFAULT '',
  `account_type` varchar(128) DEFAULT '',
  `is_blocked` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`accountid`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tblaccounts` */

insert  into `tblaccounts`(`accountid`,`user_id`,`username`,`account_password`,`first_name`,`last_name`,`middle_name`,`address`,`age`,`email_address`,`contact_number`,`account_type`,`is_blocked`) values (7,'001','darren','darren','darren','acuna','','Bulacan',23,'darren@gmail.com','09611917651','System Admin',0),(8,'12313132','kelly','darren','kelly','kelly','','kelly',23,'kelly@gmail.com','091231231','Inventory Personnel',1);

/*Table structure for table `tblaudittrail` */

DROP TABLE IF EXISTS `tblaudittrail`;

CREATE TABLE `tblaudittrail` (
  `audit_id` int(11) NOT NULL AUTO_INCREMENT,
  `activity` varchar(128) DEFAULT '',
  `description` varchar(128) DEFAULT '',
  `accountid` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`audit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=241 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tblaudittrail` */

insert  into `tblaudittrail`(`audit_id`,`activity`,`description`,`accountid`,`created_at`) values (1,'Login','Login',7,'2025-05-13 20:15:47'),(2,'Login','Login',7,'2025-05-13 20:16:21'),(3,'Logout','Logout',7,'2025-05-13 20:16:45'),(4,'Login','Login',7,'2025-05-13 20:16:57'),(5,'Login','Login',7,'2025-05-13 20:18:33'),(6,'Update user','Update user',7,'2025-05-13 20:19:00'),(7,'Login','Login',7,'2025-05-13 20:19:15'),(8,'Login','Login',7,'2025-05-13 20:20:14'),(9,'Login','Login',7,'2025-05-13 20:20:28'),(10,'Login','Login',7,'2025-05-13 20:20:41'),(11,'Login','Login',7,'2025-05-13 20:22:23'),(12,'Login','Login',7,'2025-05-13 20:23:57'),(13,'Login','Login',7,'2025-05-13 20:24:31'),(14,'Login','Login',7,'2025-05-13 20:28:22'),(15,'Login','Login',7,'2025-05-13 20:28:39'),(16,'Login','Login',7,'2025-05-13 20:29:37'),(17,'Login','Login',7,'2025-05-13 20:33:46'),(18,'Login','Login',7,'2025-05-13 20:33:52'),(19,'Login','Login',7,'2025-05-13 20:34:09'),(20,'Login','Login',7,'2025-05-13 20:41:07'),(21,'Login','Login',7,'2025-05-13 20:43:15'),(22,'Login','Login',7,'2025-05-13 20:44:04'),(23,'Login','Login',7,'2025-05-13 20:56:37'),(24,'Login','Login',7,'2025-05-13 20:57:04'),(25,'Login','Login',7,'2025-05-13 21:03:41'),(26,'Login','Login',7,'2025-05-13 21:05:01'),(27,'Login','Login',7,'2025-05-13 21:08:05'),(28,'Login','Login',7,'2025-05-13 21:10:06'),(29,'Login','Login',7,'2025-05-13 21:17:43'),(30,'Login','Login',7,'2025-05-13 21:19:32'),(31,'Login','Login',7,'2025-05-13 21:21:29'),(32,'Login','Login',7,'2025-05-13 21:23:43'),(33,'Login','Login',7,'2025-05-13 21:26:26'),(34,'Login','Login',7,'2025-05-13 21:34:55'),(35,'Login','Login',7,'2025-05-13 21:35:48'),(36,'Login','Login',7,'2025-05-13 21:41:20'),(37,'Login','Login',7,'2025-05-13 21:42:47'),(38,'Login','Login',7,'2025-05-13 21:42:52'),(39,'Login','Login',7,'2025-05-13 21:43:24'),(40,'Login','Login',7,'2025-05-13 22:01:53'),(41,'Login','Login',7,'2025-05-13 23:01:36'),(42,'Login','Login',7,'2025-05-13 23:02:08'),(43,'Login','Login',7,'2025-05-13 23:23:35'),(44,'Login','Login',7,'2025-05-13 23:25:04'),(45,'Login','Login',7,'2025-05-13 23:35:35'),(46,'Login','Login',7,'2025-05-13 23:41:01'),(47,'Updated category','Updated category',0,'2025-05-14 00:13:45'),(48,'Logout','Logout',7,'2025-05-14 00:18:51'),(49,'Login','Login',7,'2025-05-14 00:19:39'),(50,'Logout','Logout',7,'2025-05-14 00:22:51'),(51,'Login','Login',7,'2025-05-14 00:28:57'),(52,'Logout','Logout',7,'2025-05-14 00:30:24'),(53,'Login','Login',7,'2025-05-14 08:28:16'),(54,'Update inventory','Inventory item updated successfully',0,'2025-05-14 08:29:16'),(55,'Login','Login',7,'2025-05-14 09:40:50'),(56,'Update inventory','Inventory item updated successfully',0,'2025-05-14 09:44:23'),(57,'Update inventory','Inventory item updated successfully',0,'2025-05-14 09:45:18'),(58,'Login','Login',7,'2025-05-14 09:45:59'),(59,'Update inventory','Inventory item updated successfully',0,'2025-05-14 09:46:03'),(60,'Added inventory','Inventory item added successfully',0,'2025-05-14 09:46:19'),(61,'Login','Login',7,'2025-05-14 10:04:02'),(62,'Login','Login',7,'2025-05-14 10:04:53'),(63,'Login','Login',7,'2025-05-14 10:07:39'),(64,'Login','Login',7,'2025-05-14 10:14:13'),(65,'Login','Login',7,'2025-05-14 10:20:04'),(66,'Login','Login',7,'2025-05-14 10:23:00'),(67,'Login','Login',7,'2025-05-14 10:23:39'),(68,'Login','Login',7,'2025-05-14 10:25:46'),(69,'Login','Login',7,'2025-05-14 10:28:55'),(70,'Login','Login',7,'2025-05-14 11:11:01'),(71,'Login','Login',7,'2025-05-14 11:15:22'),(72,'Login','Login',7,'2025-05-14 11:28:37'),(73,'Login','Login',7,'2025-05-14 11:29:04'),(74,'Login','Login',7,'2025-05-14 11:29:10'),(75,'Login','Login',7,'2025-05-14 11:29:14'),(76,'Login','Login',7,'2025-05-14 11:29:42'),(77,'Login','Login',7,'2025-05-14 11:29:43'),(78,'Login','Login',7,'2025-05-14 11:29:43'),(79,'Login','Login',7,'2025-05-14 11:29:44'),(80,'Login','Login',7,'2025-05-14 11:30:28'),(81,'Login','Login',7,'2025-05-14 11:30:38'),(82,'Login','Login',7,'2025-05-14 11:30:41'),(83,'Login','Login',7,'2025-05-14 11:31:58'),(84,'Login','Login',7,'2025-05-14 11:32:57'),(85,'Login','Login',7,'2025-05-14 11:33:06'),(86,'Login','Login',7,'2025-05-14 11:33:23'),(87,'Login','Login',7,'2025-05-14 11:33:39'),(88,'Login','Login',7,'2025-05-14 11:33:40'),(89,'Login','Login',7,'2025-05-14 11:33:41'),(90,'Login','Login',7,'2025-05-14 11:34:13'),(91,'Login','Login',7,'2025-05-14 11:34:14'),(92,'Login','Login',7,'2025-05-14 11:35:17'),(93,'Login','Login',7,'2025-05-14 11:35:19'),(94,'Login','Login',7,'2025-05-14 11:35:23'),(95,'Login','Login',7,'2025-05-14 11:35:23'),(96,'Login','Login',7,'2025-05-14 11:35:23'),(97,'Login','Login',7,'2025-05-14 11:35:24'),(98,'Login','Login',7,'2025-05-14 11:35:24'),(99,'Login','Login',7,'2025-05-14 11:35:24'),(100,'Login','Login',7,'2025-05-14 11:35:24'),(101,'Login','Login',7,'2025-05-14 11:35:25'),(102,'Login','Login',7,'2025-05-14 11:35:25'),(103,'Login','Login',7,'2025-05-14 11:35:58'),(104,'Login','Login',7,'2025-05-14 11:36:13'),(105,'Login','Login',7,'2025-05-14 11:36:21'),(106,'Login','Login',7,'2025-05-14 11:36:24'),(107,'Login','Login',7,'2025-05-14 11:36:24'),(108,'Login','Login',7,'2025-05-14 11:36:25'),(109,'Login','Login',7,'2025-05-14 11:36:25'),(110,'Login','Login',7,'2025-05-14 11:36:25'),(111,'Login','Login',7,'2025-05-14 11:36:27'),(112,'Login','Login',7,'2025-05-14 11:36:34'),(113,'Login','Login',7,'2025-05-14 11:36:35'),(114,'Login','Login',7,'2025-05-14 11:36:37'),(115,'Login','Login',7,'2025-05-14 11:36:37'),(116,'Login','Login',7,'2025-05-14 11:36:37'),(117,'Login','Login',7,'2025-05-14 11:36:37'),(118,'Login','Login',7,'2025-05-14 11:36:38'),(119,'Login','Login',7,'2025-05-14 11:36:39'),(120,'Login','Login',7,'2025-05-14 11:51:48'),(121,'Update inventory','Inventory item updated successfully',0,'2025-05-14 11:52:24'),(122,'Update inventory','Inventory item updated successfully',0,'2025-05-14 11:52:30'),(123,'Login','Login',7,'2025-05-14 12:07:29'),(124,'Login','Login',7,'2025-05-14 12:08:15'),(125,'Update inventory','Inventory item updated successfully',0,'2025-05-14 12:11:20'),(126,'Update inventory','Inventory item updated successfully',0,'2025-05-14 12:11:27'),(127,'Login','Login',7,'2025-05-14 12:14:46'),(128,'Login','Login',7,'2025-05-14 12:15:06'),(129,'Login','Login',7,'2025-05-14 12:16:07'),(130,'Update inventory','Inventory item updated successfully',0,'2025-05-14 12:16:29'),(131,'Login','Login',7,'2025-05-14 12:21:29'),(132,'Login','Login',7,'2025-05-14 12:24:44'),(133,'Added inventory','Inventory item added successfully',0,'2025-05-14 13:15:22'),(134,'Logout','Logout',7,'2025-05-14 13:57:38'),(135,'Login','Login',7,'2025-05-14 13:57:41'),(136,'Login','Login',7,'2025-05-14 13:57:47'),(137,'Login','Login',7,'2025-05-14 13:57:48'),(138,'Login','Login',7,'2025-05-14 13:57:48'),(139,'Login','Login',7,'2025-05-14 13:57:48'),(140,'Login','Login',7,'2025-05-14 13:57:49'),(141,'Login','Login',7,'2025-05-14 13:57:49'),(142,'Login','Login',7,'2025-05-14 13:57:49'),(143,'Login','Login',7,'2025-05-14 13:57:50'),(144,'Login','Login',7,'2025-05-14 13:57:50'),(145,'Login','Login',7,'2025-05-14 13:57:50'),(146,'Login','Login',7,'2025-05-14 13:57:51'),(147,'Login','Login',7,'2025-05-14 13:57:51'),(148,'Login','Login',7,'2025-05-14 13:57:51'),(149,'Login','Login',7,'2025-05-14 13:57:51'),(150,'Login','Login',7,'2025-05-14 13:58:03'),(151,'Login','Login',7,'2025-05-14 13:59:28'),(152,'Login','Login',7,'2025-05-14 14:01:15'),(153,'Login','Login',7,'2025-05-14 14:02:38'),(154,'Login','Login',7,'2025-05-14 14:03:11'),(155,'Login','Login',7,'2025-05-14 14:04:17'),(156,'Logout','Logout',7,'2025-05-14 14:04:19'),(157,'Login','Login',7,'2025-05-14 14:04:37'),(158,'Login','Login',7,'2025-05-14 14:05:49'),(159,'Login','Login',7,'2025-05-14 14:07:57'),(160,'Login','Login',7,'2025-05-14 14:08:47'),(161,'Login','Login',7,'2025-05-14 14:10:31'),(162,'Login','Login',7,'2025-05-14 14:14:22'),(163,'Login','Login',7,'2025-05-14 14:16:13'),(164,'Login','Login',7,'2025-05-14 14:16:33'),(165,'Login','Login',7,'2025-05-14 14:16:33'),(166,'Login','Login',7,'2025-05-14 14:16:33'),(167,'Login','Login',7,'2025-05-14 14:16:33'),(168,'Login','Login',7,'2025-05-14 14:25:39'),(169,'Login','Login',7,'2025-05-14 14:56:04'),(170,'Login','Login',7,'2025-05-14 14:59:01'),(171,'Login','Login',7,'2025-05-14 15:00:33'),(172,'Login','Login',7,'2025-05-14 15:14:56'),(173,'Login','Login',7,'2025-05-14 15:15:43'),(174,'Login','Login',7,'2025-05-14 15:15:51'),(175,'Login','Login',7,'2025-05-14 15:16:18'),(176,'Login','Login',7,'2025-05-14 15:22:53'),(177,'Login','Login',7,'2025-05-14 15:22:54'),(178,'Login','Login',7,'2025-05-14 15:22:55'),(179,'Login','Login',7,'2025-05-14 15:30:32'),(180,'Login','Login',7,'2025-05-14 15:31:43'),(181,'Login','Login',7,'2025-05-14 15:33:04'),(182,'Login','Login',7,'2025-05-14 15:33:26'),(183,'Login','Login',7,'2025-05-14 15:35:27'),(184,'Login','Login',7,'2025-05-14 15:35:45'),(185,'Added category','Added category',0,'2025-05-14 15:35:58'),(186,'Added category','Added category',0,'2025-05-14 15:36:00'),(187,'Login','Login',7,'2025-05-14 15:36:01'),(188,'Login','Login',7,'2025-05-14 15:36:44'),(189,'Login','Login',7,'2025-05-14 15:36:53'),(190,'Login','Login',7,'2025-05-14 15:36:58'),(191,'Login','Login',7,'2025-05-14 15:37:08'),(192,'Login','Login',7,'2025-05-14 15:37:13'),(193,'Login','Login',7,'2025-05-14 15:37:42'),(194,'Update inventory','Inventory item updated successfully',0,'2025-05-14 15:57:17'),(195,'Logout','Logout',7,'2025-05-14 16:18:36'),(196,'Login','Login',7,'2025-05-14 16:18:43'),(197,'Update inventory','Inventory item updated successfully',0,'2025-05-14 16:19:46'),(198,'Update inventory','Inventory item updated successfully',0,'2025-05-14 16:19:50'),(199,'Login','Login',7,'2025-05-14 16:25:45'),(200,'Login','Login',7,'2025-05-14 16:26:33'),(201,'Login','Login',7,'2025-05-14 16:27:47'),(202,'Login','Login',7,'2025-05-14 16:32:42'),(203,'Login','Login',7,'2025-05-14 16:51:59'),(204,'Login','Login',7,'2025-05-14 16:53:12'),(205,'Added new user','Added new user',7,'2025-05-14 16:56:09'),(206,'Login','Login',7,'2025-05-14 17:06:54'),(207,'Login','Login',7,'2025-05-14 17:07:06'),(208,'Login','Login',8,'2025-05-14 17:07:50'),(209,'Login','Login',8,'2025-05-14 17:08:01'),(210,'Login','Login',8,'2025-05-14 17:08:01'),(211,'Login','Login',8,'2025-05-14 17:08:05'),(212,'Login','Login',8,'2025-05-14 17:08:05'),(213,'Login','Login',8,'2025-05-14 17:08:05'),(214,'Login','Login',7,'2025-05-14 17:11:42'),(215,'Login','Login',8,'2025-05-14 17:11:46'),(216,'Login','Login',8,'2025-05-14 17:11:53'),(217,'Login','Login',8,'2025-05-14 17:12:08'),(218,'Login','Login',8,'2025-05-14 17:12:18'),(219,'Login','Login',8,'2025-05-14 17:12:26'),(220,'Login','Login',8,'2025-05-14 17:12:35'),(221,'Login','Login',8,'2025-05-14 17:12:47'),(222,'Login','Login',7,'2025-05-14 17:14:21'),(223,'Logout','Logout',7,'2025-05-14 17:17:47'),(224,'Login','Login',7,'2025-05-15 08:05:17'),(225,'Login','Login',7,'2025-05-15 08:05:24'),(226,'Login','Login',7,'2025-05-15 08:05:24'),(227,'Login','Login',7,'2025-05-15 08:10:22'),(228,'Update inventory','Inventory item updated successfully',0,'2025-05-15 08:10:38'),(229,'Login','Login',7,'2025-05-15 08:10:57'),(230,'Login','Login',7,'2025-05-15 08:12:05'),(231,'Login','Login',7,'2025-05-15 08:12:07'),(232,'Login','Login',7,'2025-05-15 08:12:07'),(233,'Login','Login',7,'2025-05-15 08:12:07'),(234,'Login','Login',7,'2025-05-15 08:12:08'),(235,'Login','Login',7,'2025-05-15 08:12:08'),(236,'Login','Login',7,'2025-05-15 08:16:03'),(237,'Login','Login',7,'2025-05-15 08:16:10'),(238,'Login','Login',7,'2025-05-15 08:18:03'),(239,'Login','Login',7,'2025-05-15 08:18:09'),(240,'Login','Login',7,'2025-05-15 08:18:31');

/*Table structure for table `tblcategory` */

DROP TABLE IF EXISTS `tblcategory`;

CREATE TABLE `tblcategory` (
  `categoryid` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(128) DEFAULT '',
  `is_archived` varchar(128) DEFAULT 'No',
  PRIMARY KEY (`categoryid`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tblcategory` */

insert  into `tblcategory`(`categoryid`,`category`,`is_archived`) values (1,'darren','Yes'),(2,'Sample hehe','No'),(3,'Kelly','No'),(4,'Carpentry Tools','No'),(5,'Blacksmith Tools','Yes'),(6,'Farming Tools','No'),(7,'Masonry Tools','No'),(8,'Shoemaking Tools','No');

/*Table structure for table `tblcooperative` */

DROP TABLE IF EXISTS `tblcooperative`;

CREATE TABLE `tblcooperative` (
  `cooperativeid` int(11) NOT NULL AUTO_INCREMENT,
  `cooperative` varchar(128) DEFAULT '',
  `is_archived` varchar(128) DEFAULT 'No',
  PRIMARY KEY (`cooperativeid`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tblcooperative` */

insert  into `tblcooperative`(`cooperativeid`,`cooperative`,`is_archived`) values (1,'asdf','No'),(2,'Heritage Smiths Guild','No'),(3,'Vintage Tools Co-op','No'),(4,'Craft Revival Society','No'),(5,'Old Hands Collective','No'),(6,'Traditional Makers Group','No'),(7,'Rural Tools Workshop','No');

/*Table structure for table `tblinventory` */

DROP TABLE IF EXISTS `tblinventory`;

CREATE TABLE `tblinventory` (
  `inventory_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` varchar(128) DEFAULT '',
  `product_name` varchar(128) DEFAULT '',
  `color` varchar(128) DEFAULT '',
  `categoryid` int(11) DEFAULT 0,
  `subcategoryid` int(11) DEFAULT 0,
  `sizesid` int(11) DEFAULT 0,
  `madefromid` int(11) DEFAULT 0,
  `cooperativeid` int(11) DEFAULT 0,
  `qty_available` double DEFAULT 0,
  `reorder_threshold` varchar(128) DEFAULT '',
  `storageid` int(11) DEFAULT 0,
  `cost_price` double DEFAULT 0,
  `retail_price` double DEFAULT 0,
  `unitid` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `current_stock` double DEFAULT 0,
  `current_stock_date` datetime DEFAULT NULL,
  `new_stock` double DEFAULT 0,
  `new_stock_date` datetime DEFAULT NULL,
  `total_stock` double DEFAULT 0,
  PRIMARY KEY (`inventory_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tblinventory` */

insert  into `tblinventory`(`inventory_id`,`product_id`,`product_name`,`color`,`categoryid`,`subcategoryid`,`sizesid`,`madefromid`,`cooperativeid`,`qty_available`,`reorder_threshold`,`storageid`,`cost_price`,`retail_price`,`unitid`,`created_at`,`current_stock`,`current_stock_date`,`new_stock`,`new_stock_date`,`total_stock`) values (6,'C-C-L-0006','Darrend','Blue',3,2,6,4,2,0,'',7,100,0,5,'2025-05-13 23:43:22',99,'2025-05-15 08:10:46',0,NULL,0),(7,'F-C-O-0007','Walis','Yellow',6,2,7,3,4,0,'',1,250,0,5,'2025-05-14 09:46:19',0,NULL,0,NULL,100),(8,'C-C-L-0008','Tambo','Red',6,7,6,8,4,20,'',5,299,0,7,'2025-05-14 13:15:22',0,NULL,0,NULL,0);

/*Table structure for table `tblinventory_prices` */

DROP TABLE IF EXISTS `tblinventory_prices`;

CREATE TABLE `tblinventory_prices` (
  `price_id` int(11) NOT NULL AUTO_INCREMENT,
  `inventory_id` int(11) DEFAULT 0,
  `price` decimal(10,2) NOT NULL,
  `effective_date` date NOT NULL,
  `effective_date_to` date DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`price_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tblinventory_prices` */

insert  into `tblinventory_prices`(`price_id`,`inventory_id`,`price`,`effective_date`,`effective_date_to`,`created_at`) values (1,6,'200.00','2025-05-14','2025-05-21','2025-05-14 10:05:02'),(2,7,'200.00','2025-05-14','2025-05-21','2025-05-14 10:05:47'),(3,7,'3333.00','2025-05-14',NULL,'2025-05-14 10:07:01'),(4,7,'3777.00','2025-05-26',NULL,'2025-05-14 10:08:40'),(5,6,'200.00','2025-05-22','0000-00-00','2025-05-14 10:14:06'),(6,7,'266.00','2025-05-14','2025-05-14','2025-05-14 10:14:26'),(7,6,'233.00','2025-05-14','2025-05-21','2025-05-14 10:23:54'),(8,7,'200.00','2025-05-28','2025-05-29','2025-05-14 10:26:02'),(9,8,'500.00','2025-05-14','2025-05-28','2025-05-14 13:15:50');

/*Table structure for table `tblmadefrom` */

DROP TABLE IF EXISTS `tblmadefrom`;

CREATE TABLE `tblmadefrom` (
  `madefromid` int(11) NOT NULL AUTO_INCREMENT,
  `madefrom` varchar(128) DEFAULT '',
  `is_archived` varchar(128) DEFAULT 'No',
  PRIMARY KEY (`madefromid`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tblmadefrom` */

insert  into `tblmadefrom`(`madefromid`,`madefrom`,`is_archived`) values (1,'PH','No'),(2,'ausasdfasdf','Yes'),(3,'Iron','No'),(4,'Bronze','No'),(5,'Wood','No'),(6,'Steel','No'),(7,'Stone','No'),(8,'Bone','No');

/*Table structure for table `tblsales` */

DROP TABLE IF EXISTS `tblsales`;

CREATE TABLE `tblsales` (
  `sales_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(128) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `processed_by` int(11) DEFAULT 0,
  `payment_method` varchar(128) DEFAULT '',
  `price_pay` double DEFAULT 0,
  `is_void` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`sales_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tblsales` */

insert  into `tblsales`(`sales_id`,`order_id`,`created_at`,`processed_by`,`payment_method`,`price_pay`,`is_void`) values (1,'ORD-0001','2025-05-14 14:13:09',7,'GCash',0,0),(2,'ORD-0002','2025-05-14 14:13:54',7,'GCash',0,0),(3,'ORD-0003','2025-05-14 14:14:40',7,'GCash',0,0),(4,'ORD-0004','2025-05-14 16:13:02',7,'GCash',0,0),(5,'ORD-0005','2025-05-14 16:28:01',7,'Cash',0,0),(6,'ORD-0006','2025-05-14 16:52:18',7,'Cash',0,0),(7,'ORD-0007','2025-05-15 08:10:46',7,'Cash',0,0),(8,'ORD-0008','2025-01-05 10:15:00',7,'Cash',0,0),(9,'ORD-0009','2025-01-15 12:30:00',7,'GCash',0,0),(10,'ORD-0010','2025-02-01 09:00:00',7,'Cash',0,0),(11,'ORD-0011','2025-02-20 14:45:00',7,'GCash',0,0),(12,'ORD-0012','2025-03-03 11:00:00',7,'Cash',0,0),(13,'ORD-0013','2025-03-10 16:00:00',7,'GCash',0,0),(14,'ORD-0014','2025-03-28 13:00:00',7,'Cash',0,0),(15,'ORD-0015','2025-04-01 08:30:00',7,'GCash',0,0),(16,'ORD-0016','2025-04-15 15:45:00',7,'Cash',0,0),(17,'ORD-0017','2025-04-30 10:00:00',7,'GCash',0,0),(18,'ORD-0018','2025-05-01 09:00:00',7,'Cash',0,0),(19,'ORD-0019','2025-05-05 11:20:00',7,'GCash',0,0),(20,'ORD-0020','2025-05-10 14:40:00',7,'Cash',0,0),(21,'ORD-0021','2025-05-12 13:50:00',7,'GCash',0,0),(22,'ORD-0022','2025-05-14 10:10:00',7,'Cash',0,0),(23,'ORD-0023','2025-05-14 17:30:00',7,'GCash',0,0),(24,'ORD-0024','2025-05-15 08:00:00',7,'Cash',0,0),(25,'ORD-0025','2025-05-15 09:30:00',7,'GCash',0,0),(26,'ORD-0026','2025-05-15 10:45:00',7,'Cash',0,0),(27,'ORD-0027','2025-05-15 11:55:00',7,'GCash',0,0);

/*Table structure for table `tblsales_details` */

DROP TABLE IF EXISTS `tblsales_details`;

CREATE TABLE `tblsales_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sales_id` int(11) DEFAULT 0,
  `inventory_id` int(11) DEFAULT 0,
  `qty` double DEFAULT 0,
  `puhunan` double DEFAULT 0,
  `price` double DEFAULT 0,
  `is_void` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tblsales_details` */

insert  into `tblsales_details`(`id`,`sales_id`,`inventory_id`,`qty`,`puhunan`,`price`,`is_void`) values (1,1,0,0,0,0,0),(2,2,6,2,100,233,0),(3,2,8,2,299,500,0),(4,3,6,2,100,233,0),(5,3,8,1,299,500,0),(6,4,8,2,299,500,0),(7,5,6,2,100,233,0),(8,5,8,3,299,500,0),(9,6,6,4,100,233,0),(10,6,8,5,299,500,0),(11,7,6,1,100,233,0),(12,8,6,2,100,233,0),(13,8,8,1,299,500,0),(14,9,7,3,250,350,0),(15,10,6,2,100,233,0),(16,10,8,2,299,500,0),(17,11,6,1,100,233,0),(18,12,8,3,299,500,0),(19,13,7,2,250,350,0),(20,14,6,2,100,233,0),(21,15,6,1,100,233,0),(22,15,8,1,299,500,0),(23,16,8,2,299,500,0),(24,17,7,1,250,350,0),(25,18,6,3,100,233,0),(26,19,6,1,100,233,0),(27,19,8,2,299,500,0),(28,20,7,1,250,350,0),(29,21,8,3,299,500,0),(30,22,6,2,100,233,0),(31,23,6,2,100,233,0),(32,23,7,2,250,350,0),(33,24,8,1,299,500,0),(34,25,6,1,100,233,0),(35,26,6,2,100,233,0),(36,27,8,3,299,500,0);

/*Table structure for table `tblsizes` */

DROP TABLE IF EXISTS `tblsizes`;

CREATE TABLE `tblsizes` (
  `sizesid` int(11) NOT NULL AUTO_INCREMENT,
  `size` varchar(128) DEFAULT '',
  `is_archived` varchar(128) DEFAULT 'No',
  PRIMARY KEY (`sizesid`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tblsizes` */

insert  into `tblsizes`(`sizesid`,`size`,`is_archived`) values (1,'Small','No'),(2,'Larges','Yes'),(3,'Miniature','No'),(4,'Small','No'),(5,'Medium','No'),(6,'Large','No'),(7,'Oversized','No'),(8,'Custom','No');

/*Table structure for table `tblstorage` */

DROP TABLE IF EXISTS `tblstorage`;

CREATE TABLE `tblstorage` (
  `storageid` int(11) NOT NULL AUTO_INCREMENT,
  `storage` varchar(128) DEFAULT '',
  `is_archived` varchar(128) DEFAULT 'No',
  PRIMARY KEY (`storageid`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tblstorage` */

insert  into `tblstorage`(`storageid`,`storage`,`is_archived`) values (1,'kel','No'),(2,'darreb','Yes'),(3,'Tool Shed A','No'),(4,'Restoration Barn','No'),(5,'Main Storage Hall','No'),(6,'Warehouse 3','No'),(7,'Blacksmith Vault','No'),(8,'Antique Locker Room','No');

/*Table structure for table `tblsubcategory` */

DROP TABLE IF EXISTS `tblsubcategory`;

CREATE TABLE `tblsubcategory` (
  `subcategoryid` int(11) NOT NULL AUTO_INCREMENT,
  `subcategory` varchar(128) DEFAULT '',
  `is_archived` varchar(128) DEFAULT 'No',
  PRIMARY KEY (`subcategoryid`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tblsubcategory` */

insert  into `tblsubcategory`(`subcategoryid`,`subcategory`,`is_archived`) values (1,'Sub2','No'),(2,'Chisels','No'),(3,'Hammers','No'),(4,'Plows','No'),(5,'Trowels','No'),(6,'Awls','No'),(7,'Calipers','No');

/*Table structure for table `tblunit` */

DROP TABLE IF EXISTS `tblunit`;

CREATE TABLE `tblunit` (
  `unitid` int(11) NOT NULL AUTO_INCREMENT,
  `unit` varchar(128) DEFAULT '',
  `is_archived` varchar(128) DEFAULT 'No',
  PRIMARY KEY (`unitid`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tblunit` */

insert  into `tblunit`(`unitid`,`unit`,`is_archived`) values (1,'9234','No'),(2,'unitaer','No'),(3,'Piece','No'),(4,'Set','No'),(5,'Box','No'),(6,'Kit','No'),(7,'Bundle','No'),(8,'Pair','No');

/*Table structure for table `tmp_order7` */

DROP TABLE IF EXISTS `tmp_order7`;

CREATE TABLE `tmp_order7` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inventory_id` double DEFAULT 0,
  `qty` double DEFAULT 0,
  `puhunan` double DEFAULT 0,
  `price` double DEFAULT 0,
  `order_id` varchar(128) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `tmp_order7` */

/*Table structure for table `tmp_order8` */

DROP TABLE IF EXISTS `tmp_order8`;

CREATE TABLE `tmp_order8` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inventory_id` double DEFAULT 0,
  `qty` double DEFAULT 0,
  `puhunan` double DEFAULT 0,
  `price` double DEFAULT 0,
  `order_id` varchar(128) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `tmp_order8` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
