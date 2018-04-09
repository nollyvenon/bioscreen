/*
SQLyog Ultimate v11.5 (64 bit)
MySQL - 5.6.17 : Database - bioscreen1
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `announcements` */

DROP TABLE IF EXISTS `announcements`;

CREATE TABLE `announcements` (
  `announcement_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `announcement_date` date NOT NULL,
  `announcement_title` varchar(200) NOT NULL,
  `announcement_detail` varchar(1000) NOT NULL,
  `user_type` varchar(100) NOT NULL,
  `announcement_status` varchar(50) NOT NULL,
  PRIMARY KEY (`announcement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `announcements` */

/*Table structure for table `clients` */

DROP TABLE IF EXISTS `clients`;

CREATE TABLE `clients` (
  `client_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(200) NOT NULL,
  `business_title` varchar(200) NOT NULL,
  `mobile` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `age` varchar(4) DEFAULT NULL,
  `blood_group` varchar(4) DEFAULT NULL,
  `birth_date` varchar(20) DEFAULT NULL,
  `HMO_name` varchar(50) DEFAULT NULL,
  `city` varchar(200) NOT NULL,
  `state` varchar(200) NOT NULL,
  `country` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `price_level` varchar(200) NOT NULL,
  `notes` varchar(400) NOT NULL,
  `store_id` bigint(20) NOT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `clients` */

insert  into `clients`(`client_id`,`full_name`,`business_title`,`mobile`,`phone`,`address`,`age`,`blood_group`,`birth_date`,`HMO_name`,`city`,`state`,`country`,`email`,`price_level`,`notes`,`store_id`) values (1,'john azuka','','','','',NULL,NULL,NULL,NULL,'','','','','','',0);

/*Table structure for table `creditors` */

DROP TABLE IF EXISTS `creditors`;

CREATE TABLE `creditors` (
  `credit_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `receiveable` double NOT NULL,
  `received` double NOT NULL,
  `client_id` bigint(20) NOT NULL,
  `store_id` bigint(20) NOT NULL,
  PRIMARY KEY (`credit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `creditors` */

/*Table structure for table `customer_log` */

DROP TABLE IF EXISTS `customer_log`;

CREATE TABLE `customer_log` (
  `customer_log_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `client_id` bigint(20) NOT NULL,
  `transaction_type` varchar(200) NOT NULL,
  `type_table_id` bigint(20) NOT NULL,
  `store_id` bigint(20) NOT NULL,
  PRIMARY KEY (`customer_log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `customer_log` */

/*Table structure for table `debts` */

DROP TABLE IF EXISTS `debts`;

CREATE TABLE `debts` (
  `debt_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `payable` double NOT NULL,
  `paid` double NOT NULL,
  `vendor_id` bigint(20) NOT NULL,
  `store_id` bigint(20) NOT NULL,
  PRIMARY KEY (`debt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `debts` */

/*Table structure for table `expense_types` */

DROP TABLE IF EXISTS `expense_types`;

CREATE TABLE `expense_types` (
  `type_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(200) NOT NULL,
  `type_description` varchar(600) NOT NULL,
  `store_id` bigint(20) NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `expense_types` */

/*Table structure for table `expenses` */

DROP TABLE IF EXISTS `expenses`;

CREATE TABLE `expenses` (
  `expense_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type_id` bigint(20) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `title` varchar(400) DEFAULT NULL,
  `description` varchar(1000) NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `agent_id` bigint(20) NOT NULL,
  `store_id` bigint(20) NOT NULL,
  PRIMARY KEY (`expense_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `expenses` */

/*Table structure for table `inventory` */

DROP TABLE IF EXISTS `inventory`;

CREATE TABLE `inventory` (
  `inventory_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `inn` bigint(20) NOT NULL,
  `out_inv` bigint(20) NOT NULL,
  `store_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `warehouse_id` bigint(20) NOT NULL,
  PRIMARY KEY (`inventory_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `inventory` */

/*Table structure for table `laboratorist` */

DROP TABLE IF EXISTS `laboratorist`;

CREATE TABLE `laboratorist` (
  `laboratorist_id` int(11) NOT NULL AUTO_INCREMENT,
  `laboratorist_manual_id` tinyint(3) DEFAULT NULL,
  `laboratorist_name` varchar(30) DEFAULT NULL,
  `store_id` tinyint(3) DEFAULT '1',
  PRIMARY KEY (`laboratorist_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `laboratorist` */

insert  into `laboratorist`(`laboratorist_id`,`laboratorist_manual_id`,`laboratorist_name`,`store_id`) values (1,1,'Grace',1);

/*Table structure for table `message_meta` */

DROP TABLE IF EXISTS `message_meta`;

CREATE TABLE `message_meta` (
  `msg_meta_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `message_id` bigint(20) NOT NULL,
  `status` varchar(100) NOT NULL,
  `from_id` bigint(20) NOT NULL,
  `to_id` bigint(20) NOT NULL,
  `subject_id` bigint(20) NOT NULL,
  PRIMARY KEY (`msg_meta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `message_meta` */

/*Table structure for table `messages` */

DROP TABLE IF EXISTS `messages`;

CREATE TABLE `messages` (
  `message_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `message_datetime` datetime NOT NULL,
  `message_detail` varchar(1000) NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `messages` */

/*Table structure for table `notes` */

DROP TABLE IF EXISTS `notes`;

CREATE TABLE `notes` (
  `note_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `note_date` date NOT NULL,
  `note_title` varchar(200) NOT NULL,
  `note_detail` varchar(600) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  PRIMARY KEY (`note_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `notes` */

/*Table structure for table `options` */

DROP TABLE IF EXISTS `options`;

CREATE TABLE `options` (
  `option_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `option_name` varchar(500) NOT NULL,
  `option_value` varchar(500) NOT NULL,
  PRIMARY KEY (`option_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

/*Data for the table `options` */

insert  into `options`(`option_id`,`option_name`,`option_value`) values (6,'site_url','http://localhost/bioscreen1/'),(7,'site_name','Bioscreen Medical Laboratory Ltd'),(8,'email_from','info@bioscreenlaboratoryltd.com'),(9,'email_to','info@bioscreenlaboratoryltd.com'),(10,'installation','Yes'),(11,'version','2.1'),(12,'language','english'),(13,'redirect_on_logout','index.php'),(14,'register_user_level','subscriber'),(15,'session_timeout','180'),(16,'maximum_login_attempts','10'),(17,'wrong_attempts_time','10'),(21,'1_default_warehouse','1'),(22,'1_default_customer',''),(23,'1_pos_items','');

/*Table structure for table `payments` */

DROP TABLE IF EXISTS `payments`;

CREATE TABLE `payments` (
  `payment_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `method` varchar(200) NOT NULL,
  `ref_no` varchar(200) NOT NULL,
  `memo` varchar(200) NOT NULL,
  `amount` double NOT NULL,
  `vendor_id` bigint(20) NOT NULL,
  `agent_id` bigint(20) NOT NULL,
  `store_id` bigint(20) NOT NULL,
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `payments` */

/*Table structure for table `price` */

DROP TABLE IF EXISTS `price`;

CREATE TABLE `price` (
  `price_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cost` float NOT NULL,
  `selling_price` float NOT NULL,
  `tax` double NOT NULL,
  `store_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  PRIMARY KEY (`price_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `price` */

/*Table structure for table `product_categories` */

DROP TABLE IF EXISTS `product_categories`;

CREATE TABLE `product_categories` (
  `category_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(200) NOT NULL,
  `category_description` varchar(600) NOT NULL,
  `store_id` bigint(20) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `product_categories` */

/*Table structure for table `product_rates` */

DROP TABLE IF EXISTS `product_rates`;

CREATE TABLE `product_rates` (
  `rate_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `default_rate` float NOT NULL,
  `level_1` float NOT NULL,
  `level_2` float NOT NULL,
  `level_3` float NOT NULL,
  `level_4` float NOT NULL,
  `level_5` float NOT NULL,
  `store_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  PRIMARY KEY (`rate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `product_rates` */

/*Table structure for table `product_taxes` */

DROP TABLE IF EXISTS `product_taxes`;

CREATE TABLE `product_taxes` (
  `tax_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tax_name` varchar(200) NOT NULL,
  `tax_rate` varchar(200) NOT NULL,
  `tax_type` varchar(200) NOT NULL,
  `tax_description` varchar(600) NOT NULL,
  `store_id` bigint(20) NOT NULL,
  PRIMARY KEY (`tax_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `product_taxes` */

/*Table structure for table `products` */

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `product_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `product_manual_id` varchar(200) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `product_description` varchar(600) NOT NULL,
  `product_unit` varchar(200) NOT NULL,
  `category_id` bigint(20) NOT NULL,
  `tax_id` bigint(20) NOT NULL,
  `product_image` varchar(400) NOT NULL,
  `alert_units` varchar(100) NOT NULL,
  `store_id` bigint(20) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `products` */

/*Table structure for table `purchase_detail` */

DROP TABLE IF EXISTS `purchase_detail`;

CREATE TABLE `purchase_detail` (
  `purchase_detail_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `purchase_id` bigint(20) NOT NULL,
  `store_id` bigint(20) NOT NULL,
  `price_id` bigint(20) NOT NULL,
  `inventory_id` bigint(20) NOT NULL,
  `debt_id` bigint(20) NOT NULL,
  PRIMARY KEY (`purchase_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `purchase_detail` */

/*Table structure for table `purchase_return_detail` */

DROP TABLE IF EXISTS `purchase_return_detail`;

CREATE TABLE `purchase_return_detail` (
  `purchase_detail_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `purchase_rt_id` bigint(20) NOT NULL,
  `store_id` bigint(20) NOT NULL,
  `price_id` bigint(20) NOT NULL,
  `inventory_id` bigint(20) NOT NULL,
  `debt_id` bigint(20) NOT NULL,
  `reason_id` bigint(20) NOT NULL,
  PRIMARY KEY (`purchase_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `purchase_return_detail` */

/*Table structure for table `purchase_return_receiving` */

DROP TABLE IF EXISTS `purchase_return_receiving`;

CREATE TABLE `purchase_return_receiving` (
  `return_receiving_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `method` varchar(200) NOT NULL,
  `ref_no` varchar(200) NOT NULL,
  `memo` varchar(200) NOT NULL,
  `amount` double NOT NULL,
  `vendor_id` bigint(20) NOT NULL,
  `agent_id` bigint(20) NOT NULL,
  `store_id` bigint(20) NOT NULL,
  PRIMARY KEY (`return_receiving_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `purchase_return_receiving` */

/*Table structure for table `purchase_returns` */

DROP TABLE IF EXISTS `purchase_returns`;

CREATE TABLE `purchase_returns` (
  `purchase_rt_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `invoice_no` varchar(200) NOT NULL,
  `memo` varchar(200) NOT NULL,
  `vendor_id` bigint(20) NOT NULL,
  `payment_status` varchar(200) NOT NULL,
  `store_id` bigint(20) NOT NULL,
  `agent_id` bigint(20) NOT NULL,
  PRIMARY KEY (`purchase_rt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `purchase_returns` */

/*Table structure for table `purchases` */

DROP TABLE IF EXISTS `purchases`;

CREATE TABLE `purchases` (
  `purchase_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `supp_inv_no` varchar(200) NOT NULL,
  `memo` varchar(200) NOT NULL,
  `vendor_id` bigint(20) NOT NULL,
  `payment_status` varchar(200) NOT NULL,
  `store_id` bigint(20) NOT NULL,
  `agent_id` bigint(20) NOT NULL,
  PRIMARY KEY (`purchase_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `purchases` */

/*Table structure for table `receivings` */

DROP TABLE IF EXISTS `receivings`;

CREATE TABLE `receivings` (
  `receiving_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `method` varchar(200) NOT NULL,
  `ref_no` varchar(200) NOT NULL,
  `memo` varchar(200) NOT NULL,
  `amount` double NOT NULL,
  `client_id` bigint(20) NOT NULL,
  `agent_id` bigint(20) NOT NULL,
  `store_id` bigint(20) NOT NULL,
  PRIMARY KEY (`receiving_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `receivings` */

/*Table structure for table `return_reasons` */

DROP TABLE IF EXISTS `return_reasons`;

CREATE TABLE `return_reasons` (
  `reason_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `description` varchar(200) NOT NULL,
  `store_id` bigint(20) NOT NULL,
  PRIMARY KEY (`reason_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `return_reasons` */

/*Table structure for table `sale_detail` */

DROP TABLE IF EXISTS `sale_detail`;

CREATE TABLE `sale_detail` (
  `sale_detail_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sale_id` bigint(20) NOT NULL,
  `store_id` bigint(20) NOT NULL,
  `price_id` bigint(20) NOT NULL,
  `inventory_id` bigint(20) NOT NULL,
  `credit_id` bigint(20) NOT NULL,
  PRIMARY KEY (`sale_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `sale_detail` */

/*Table structure for table `sale_return_detail` */

DROP TABLE IF EXISTS `sale_return_detail`;

CREATE TABLE `sale_return_detail` (
  `return_detail_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sale_rt_id` bigint(20) NOT NULL,
  `store_id` bigint(20) NOT NULL,
  `price_id` bigint(20) NOT NULL,
  `inventory_id` bigint(20) NOT NULL,
  `credit_id` bigint(20) NOT NULL,
  `reason_id` bigint(20) NOT NULL,
  PRIMARY KEY (`return_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `sale_return_detail` */

/*Table structure for table `sale_return_payment` */

DROP TABLE IF EXISTS `sale_return_payment`;

CREATE TABLE `sale_return_payment` (
  `return_payment_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `method` varchar(200) NOT NULL,
  `ref_no` varchar(200) NOT NULL,
  `memo` varchar(200) NOT NULL,
  `amount` double NOT NULL,
  `client_id` bigint(20) NOT NULL,
  `agent_id` bigint(20) NOT NULL,
  `store_id` bigint(20) NOT NULL,
  PRIMARY KEY (`return_payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `sale_return_payment` */

/*Table structure for table `sale_returns` */

DROP TABLE IF EXISTS `sale_returns`;

CREATE TABLE `sale_returns` (
  `sale_rt_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `invoice_no` varchar(200) NOT NULL,
  `memo` varchar(200) NOT NULL,
  `client_id` bigint(20) NOT NULL,
  `payment_status` varchar(200) NOT NULL,
  `store_id` bigint(20) NOT NULL,
  `agent_id` bigint(20) NOT NULL,
  PRIMARY KEY (`sale_rt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `sale_returns` */

/*Table structure for table `sales` */

DROP TABLE IF EXISTS `sales`;

CREATE TABLE `sales` (
  `sale_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `manual_inv_no` varchar(200) NOT NULL,
  `memo` varchar(200) NOT NULL,
  `client_id` bigint(20) NOT NULL,
  `payment_status` varchar(200) NOT NULL,
  `store_id` bigint(20) NOT NULL,
  `agent_id` bigint(20) NOT NULL,
  PRIMARY KEY (`sale_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `sales` */

/*Table structure for table `sample_types` */

DROP TABLE IF EXISTS `sample_types`;

CREATE TABLE `sample_types` (
  `sample_type_id` int(10) NOT NULL AUTO_INCREMENT,
  `sample_type_manual_id` varchar(10) DEFAULT NULL,
  `sample_type_name` tinytext,
  `sample_type_description` tinytext,
  `status` enum('0','1') DEFAULT '1',
  `user_id` tinyint(3) DEFAULT NULL,
  `store_id` tinyint(3) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`sample_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `sample_types` */

insert  into `sample_types`(`sample_type_id`,`sample_type_manual_id`,`sample_type_name`,`sample_type_description`,`status`,`user_id`,`store_id`,`timestamp`) values (1,'','',NULL,'1',1,1,'2016-03-16 21:00:45'),(2,'sds ','',NULL,'1',1,1,'2016-03-16 21:03:52'),(3,'sdsd  sds','','sdsdss','1',1,1,'2016-03-16 21:05:28'),(4,'sdsds sdss','sdsds wasa y','sds dfdfd dgfdg Holy i','',1,1,'2016-03-16 21:06:08');

/*Table structure for table `samples` */

DROP TABLE IF EXISTS `samples`;

CREATE TABLE `samples` (
  `sample_id` int(5) NOT NULL AUTO_INCREMENT,
  `sample_manual_id` varchar(10) DEFAULT NULL,
  `sample_name` varchar(200) DEFAULT NULL,
  `client_id` int(5) DEFAULT NULL,
  `sample_description` mediumtext,
  `sample_unit` tinytext,
  `pay_status` varchar(10) DEFAULT NULL,
  `sample_image` blob,
  `date_taken` datetime DEFAULT NULL,
  `sample_result` tinytext,
  `result_taken` datetime DEFAULT NULL,
  `sample_type` tinytext,
  `comment` mediumtext,
  `lab_scientist` varchar(100) DEFAULT NULL,
  `user_id` varchar(10) DEFAULT NULL,
  `store_id` int(3) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`sample_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `samples` */

insert  into `samples`(`sample_id`,`sample_manual_id`,`sample_name`,`client_id`,`sample_description`,`sample_unit`,`pay_status`,`sample_image`,`date_taken`,`sample_result`,`result_taken`,`sample_type`,`comment`,`lab_scientist`,`user_id`,`store_id`,`timestamp`) values (1,'456-890','dds',1,'dfdf','Kg','','upload/f375d5712f33b40fIMG-20160217-WA000.jpg','2016-03-15 05:18:35','dcdfd','2016-03-16 00:00:00','4','sdsdsdsds   sdsdsds','1','1',1,'2016-03-15 15:51:34');

/*Table structure for table `store_access` */

DROP TABLE IF EXISTS `store_access`;

CREATE TABLE `store_access` (
  `access_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `store_id` bigint(20) NOT NULL,
  `sales` bigint(20) NOT NULL,
  `purchase` bigint(20) NOT NULL,
  `vendors` bigint(20) NOT NULL,
  `clients` bigint(20) NOT NULL,
  `products` bigint(20) NOT NULL,
  `warehouse` bigint(20) NOT NULL,
  `returns` bigint(20) NOT NULL,
  `price_level` bigint(20) NOT NULL,
  `reports` bigint(20) NOT NULL,
  `expenses` bigint(20) NOT NULL,
  PRIMARY KEY (`access_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `store_access` */

/*Table structure for table `store_logs` */

DROP TABLE IF EXISTS `store_logs`;

CREATE TABLE `store_logs` (
  `log_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `log_datetime` datetime NOT NULL,
  `description` varchar(600) NOT NULL,
  `store_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `store_logs` */

/*Table structure for table `stores` */

DROP TABLE IF EXISTS `stores`;

CREATE TABLE `stores` (
  `store_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `store_manual_id` varchar(100) NOT NULL,
  `store_name` varchar(100) NOT NULL,
  `business_type` varchar(100) NOT NULL,
  `address1` varchar(200) NOT NULL,
  `address2` varchar(200) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `zip_code` varchar(100) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `currency` varchar(50) NOT NULL,
  `store_logo` varchar(500) NOT NULL,
  `description` varchar(600) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  PRIMARY KEY (`store_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `stores` */

insert  into `stores`(`store_id`,`store_manual_id`,`store_name`,`business_type`,`address1`,`address2`,`city`,`state`,`country`,`zip_code`,`phone`,`email`,`currency`,`store_logo`,`description`,`user_id`) values (1,'1','Bioscreen Medical Laboratory Diagnostic Ltd','Medical','30 Kotie Street, Off Okumagba Avenue, Warri, Delta State.','','Warri','Delta','Nigeria','1000001','','','N','upload/9bb3a21a4557b2aelogo.jpg','A medical laboratory','1');

/*Table structure for table `subjects` */

DROP TABLE IF EXISTS `subjects`;

CREATE TABLE `subjects` (
  `subject_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `subject_title` varchar(600) NOT NULL,
  PRIMARY KEY (`subject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `subjects` */

/*Table structure for table `syncrecord` */

DROP TABLE IF EXISTS `syncrecord`;

CREATE TABLE `syncrecord` (
  `startdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `syncrecord` */

insert  into `syncrecord`(`startdate`) values ('2015-07-30 03:15:59');

/*Table structure for table `user_level` */

DROP TABLE IF EXISTS `user_level`;

CREATE TABLE `user_level` (
  `level_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `level_name` varchar(200) NOT NULL,
  `level_description` varchar(600) NOT NULL,
  `level_page` varchar(100) NOT NULL,
  PRIMARY KEY (`level_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `user_level` */

insert  into `user_level`(`level_id`,`level_name`,`level_description`,`level_page`) values (1,'subscriber','Default user level given access to profile.php','profile.php');

/*Table structure for table `user_meta` */

DROP TABLE IF EXISTS `user_meta`;

CREATE TABLE `user_meta` (
  `user_meta_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `message_email` varchar(50) NOT NULL,
  `last_login_time` datetime NOT NULL,
  `last_login_ip` varchar(120) NOT NULL,
  `login_attempt` bigint(20) NOT NULL,
  `login_lock` varchar(50) NOT NULL,
  PRIMARY KEY (`user_meta_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `user_meta` */

insert  into `user_meta`(`user_meta_id`,`user_id`,`message_email`,`last_login_time`,`last_login_ip`,`login_attempt`,`login_lock`) values (1,1,'','2016-03-17 04:40:47','127.0.0.1',0,'No');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  `address1` varchar(200) NOT NULL,
  `address2` varchar(200) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `zip_code` varchar(100) NOT NULL,
  `mobile` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `profile_image` varchar(500) NOT NULL,
  `description` varchar(600) NOT NULL,
  `status` varchar(100) NOT NULL,
  `activation_key` varchar(100) NOT NULL,
  `date_register` date NOT NULL,
  `user_type` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`user_id`,`first_name`,`last_name`,`gender`,`date_of_birth`,`address1`,`address2`,`city`,`state`,`country`,`zip_code`,`mobile`,`phone`,`username`,`email`,`password`,`profile_image`,`description`,`status`,`activation_key`,`date_register`,`user_type`) values (1,'Bioscreen','Laboratory','','0000-00-00','','','','','','','','','','info@bioscreenlaboratoryltd.com','a908e676e4de3a9f59d3a50bfadaadfd','','','activate','','2016-03-14','admin');

/*Table structure for table `vendor_log` */

DROP TABLE IF EXISTS `vendor_log`;

CREATE TABLE `vendor_log` (
  `vendor_log_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `vendor_id` bigint(20) NOT NULL,
  `transaction_type` varchar(200) NOT NULL,
  `type_table_id` bigint(20) NOT NULL,
  `store_id` bigint(20) NOT NULL,
  PRIMARY KEY (`vendor_log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `vendor_log` */

/*Table structure for table `vendors` */

DROP TABLE IF EXISTS `vendors`;

CREATE TABLE `vendors` (
  `vendor_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(200) NOT NULL,
  `contact_person` varchar(200) NOT NULL,
  `mobile` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `city` varchar(200) NOT NULL,
  `state` varchar(200) NOT NULL,
  `country` varchar(200) NOT NULL,
  `provider_of` varchar(200) NOT NULL,
  `store_id` bigint(20) NOT NULL,
  PRIMARY KEY (`vendor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `vendors` */

/*Table structure for table `warehouse_log` */

DROP TABLE IF EXISTS `warehouse_log`;

CREATE TABLE `warehouse_log` (
  `wh_log_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `units` bigint(20) NOT NULL,
  `current_wh_id` bigint(20) NOT NULL,
  `new_wh_id` bigint(20) NOT NULL,
  `store_id` bigint(20) NOT NULL,
  `agent_id` bigint(20) NOT NULL,
  PRIMARY KEY (`wh_log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `warehouse_log` */

/*Table structure for table `warehouses` */

DROP TABLE IF EXISTS `warehouses`;

CREATE TABLE `warehouses` (
  `warehouse_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `city` varchar(200) NOT NULL,
  `state` varchar(200) NOT NULL,
  `country` varchar(200) NOT NULL,
  `manager` varchar(200) NOT NULL,
  `contact` varchar(200) NOT NULL,
  `store_id` bigint(20) NOT NULL,
  PRIMARY KEY (`warehouse_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `warehouses` */

insert  into `warehouses`(`warehouse_id`,`name`,`address`,`city`,`state`,`country`,`manager`,`contact`,`store_id`) values (1,'Kotie Street Warehouse','30 Kotie Street, Off Okumagba Avenue','Warri','Delta','Nigeria','Grace','0803',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
