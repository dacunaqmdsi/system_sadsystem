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

insert  into `tblaccounts`(`accountid`,`user_id`,`username`,`account_password`,`first_name`,`last_name`,`middle_name`,`address`,`age`,`email_address`,`contact_number`,`account_type`,`is_blocked`) values (7,'001','darren','darren','darren','acuna','','Bulacan',23,'darren@gmail.com','09611917651','System Admin',0),(8,'12313132','kelly','kelly','kelly','kelly','','kelly',23,'kelly@gmail.com','091231231','Inventory Personnel',0);

/*Table structure for table `tblaudittrail` */

DROP TABLE IF EXISTS `tblaudittrail`;

CREATE TABLE `tblaudittrail` (
  `audit_id` int(11) NOT NULL AUTO_INCREMENT,
  `activity` varchar(128) DEFAULT '',
  `description` varchar(128) DEFAULT '',
  `accountid` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`audit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tblaudittrail` */

/*Table structure for table `tblcategory` */

DROP TABLE IF EXISTS `tblcategory`;

CREATE TABLE `tblcategory` (
  `categoryid` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(128) DEFAULT '',
  `is_archived` varchar(128) DEFAULT 'No',
  PRIMARY KEY (`categoryid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tblcategory` */

insert  into `tblcategory`(`categoryid`,`category`,`is_archived`) values (1,'Cate1','No');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tblinventory` */

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tblinventory_prices` */

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tblsales` */

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tblsales_details` */

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
