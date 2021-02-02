/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 5.7.31 : Database - filevine_connect
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`filevine_connect` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `filevine_connect`;

/*Table structure for table `category` */

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `Id` int(2) NOT NULL AUTO_INCREMENT,
  `Category` varchar(20) NOT NULL,
  `Description` text,
  `Created_at` datetime DEFAULT NULL,
  `Updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `category` */

insert  into `category`(`Id`,`Category`,`Description`,`Created_at`,`Updated_at`) values 
(1,'Intake','We recognize this is a difficult time for you, and you may have many questions. During this phase, we make ourselves available to answer your concerns. Your Intake Coordinator can answer many of these questions, and if they can’t your assigned Case Manager can. If your case manager has been assigned, you will see their contact information to the left of this screen. Once this team is assigned, they will be assigned to you for the duration of the case.',NULL,NULL),
(2,'Pre-suit','We have begun working on your case. Your most important job at this time is to continue treating. If surgery is recommended by your doctor, we will go over these options at this time.',NULL,NULL),
(3,'Litigation',NULL,NULL,NULL),
(4,'Settled',NULL,NULL,NULL),
(5,'Closing',NULL,NULL,NULL),
(6,'Archived',NULL,NULL,NULL);

/*Table structure for table `config` */

DROP TABLE IF EXISTS `config`;

CREATE TABLE `config` (
  `Id` int(2) NOT NULL AUTO_INCREMENT,
  `Type` varchar(20) NOT NULL,
  `Value` varchar(100) DEFAULT NULL,
  `Status` tinyint(4) DEFAULT NULL,
  `Created_at` datetime DEFAULT NULL,
  `Updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `config` */

insert  into `config`(`Id`,`Type`,`Value`,`Status`,`Created_at`,`Updated_at`) values 
(1,'Product License',NULL,NULL,NULL,NULL),
(2,'API Key',NULL,NULL,NULL,NULL),
(3,'Key Secret',NULL,NULL,NULL,NULL),
(4,'Logo',NULL,NULL,NULL,NULL);

/*Table structure for table `legalteam_config` */

DROP TABLE IF EXISTS `legalteam_config`;

CREATE TABLE `legalteam_config` (
  `Id` int(2) NOT NULL AUTO_INCREMENT,
  `Type` varchar(30) NOT NULL,
  `Status` tinyint(4) DEFAULT NULL,
  `Full_name` varchar(20) DEFAULT NULL,
  `Email` varchar(30) DEFAULT NULL,
  `Phonenumber` varchar(30) DEFAULT NULL,
  `Created_at` datetime DEFAULT NULL,
  `Updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `legalteam_config` */

insert  into `legalteam_config`(`Id`,`Type`,`Status`,`Full_name`,`Email`,`Phonenumber`,`Created_at`,`Updated_at`) values 
(1,'Paralegal',0,NULL,NULL,NULL,NULL,NULL),
(2,'Assistant',0,NULL,NULL,NULL,NULL,NULL),
(3,'Attorney',2,NULL,NULL,NULL,NULL,NULL),
(4,'Client Relations Manager',1,NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `phase` */

DROP TABLE IF EXISTS `phase`;

CREATE TABLE `phase` (
  `Id` int(2) NOT NULL AUTO_INCREMENT,
  `Category_Id` int(2) NOT NULL,
  `Phase` varchar(30) NOT NULL,
  `Description` text,
  `Created_at` datetime DEFAULT NULL,
  `Updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

/*Data for the table `phase` */

insert  into `phase`(`Id`,`Category_Id`,`Phase`,`Description`,`Created_at`,`Updated_at`) values 
(1,1,'PC: Intake','Congratulations! We’ve accepted your case and look forward to representing you for your personal injury case. We recognize this is a difficult time for you, and you may have many questions. During this phase, we make ourselves available to answer your concerns. Your Intake Coordinator can answer many of these questions, and if they can’t your assigned Case Manager can. If your case manager has been assigned, you will see their contact information to the left of this screen.',NULL,NULL),
(2,1,'PC: Approved Sign Up',NULL,NULL,NULL),
(3,1,'PC: Turndown',NULL,NULL,NULL),
(4,2,'PC: Lost Intake',NULL,NULL,NULL),
(5,2,'PC: No Contact',NULL,NULL,NULL),
(6,2,'PC: Pending',NULL,NULL,NULL),
(7,3,'PS: Initial Letters',NULL,NULL,NULL),
(8,3,'PS: Medically Treating',NULL,NULL,NULL),
(9,3,'PS: Demand to be Done',NULL,NULL,NULL),
(10,4,'PS: Demand Sent',NULL,NULL,NULL),
(11,4,'PS: Demand In Reply',NULL,NULL,NULL),
(12,5,'PS: Negotiations',NULL,NULL,NULL),
(13,5,'PS: Settled',NULL,NULL,NULL),
(14,6,'LIT: PSV to be Done',NULL,NULL,NULL),
(15,6,'LIST: PSV Now Done',NULL,NULL,NULL);

/*Table structure for table `phase_template` */

DROP TABLE IF EXISTS `phase_template`;

CREATE TABLE `phase_template` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Template` varchar(100) NOT NULL,
  `Category` varchar(50) NOT NULL,
  `Created_at` datetime DEFAULT NULL,
  `Updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `phase_template` */

insert  into `phase_template`(`Id`,`Template`,`Category`,`Created_at`,`Updated_at`) values 
(1,'Personal Injury Law Firm','Intake',NULL,NULL),
(2,'Personal Injury Law Firm','Pre-suit',NULL,NULL),
(3,'Personal Injury Law Firm','Litigation',NULL,NULL),
(4,'Personal Injury Law Firm','Settled',NULL,NULL),
(5,'Personal Injury Law Firm','Closing',NULL,NULL),
(6,'Personal Injury Law Firm','Archived',NULL,NULL),
(7,'Criminal Defense Law Firm','Intake',NULL,NULL),
(8,'Worker\'s Comp Law Firm','Intake',NULL,NULL),
(9,'Mass Tort Law Firm','Intake',NULL,NULL),
(10,'Medical Device Manufacturer','Intake',NULL,NULL),
(11,'Tax/Accounting Audit Firm','Intake',NULL,NULL);

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `Id` int(2) NOT NULL AUTO_INCREMENT,
  `Full_name` varchar(30) DEFAULT NULL,
  `Email` varchar(30) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Created_at` datetime DEFAULT NULL,
  `Updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `user` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
