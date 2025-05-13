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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tblaccounts` */

insert  into `tblaccounts`(`accountid`,`user_id`,`username`,`account_password`,`first_name`,`last_name`,`middle_name`,`address`,`age`,`email_address`,`contact_number`,`account_type`,`is_blocked`) values (1,'0','darren','darren','','','','',0,'','','System Admin',0),(2,'0','cashier','cashier','','','','',0,'','','Cashier',0),(3,'0','inventory','inventory','','','','',0,'','','Inventory Personnel',0),(4,'234','sadfsdf','darren','asdfas','adf','asdf','dfasdf',23,'asdfasdf','23432','System Admin',0),(5,'213','asdfasdf','darreb','afd','adfa','sdf','asfas',234234,'dfasf','32423423','System Admin',0),(6,'12312312','da','darre','asdf','asdf','asdf','asdfasf',2,'3','324234','Inventory Personnel',0),(7,'3333','asdf','dada','da','23323','','sdfasdf',32,'asdf','23432','Inventory Personnel',0);

/*Table structure for table `tblcustomer` */

DROP TABLE IF EXISTS `tblcustomer`;

CREATE TABLE `tblcustomer` (
  `customerid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `actions` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`customerid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tblcustomer` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
