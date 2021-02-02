-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2020 at 07:28 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `filevine_connect`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `Id` int(2) NOT NULL,
  `Category` varchar(20) NOT NULL,
  `Description` text DEFAULT NULL,
  `Created_at` datetime DEFAULT NULL,
  `Updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`Id`, `Category`, `Description`, `Created_at`, `Updated_at`) VALUES
(1, 'Intake', 'We recognize this is a difficult time for you, and you may have many questions. During this phase, we make ourselves available to answer your concerns. Your Intake Coordinator can answer many of these questions, and if they can’t your assigned Case Manager can. If your case manager has been assigned, you will see their contact information to the left of this screen. Once this team is assigned, they will be assigned to you for the duration of the case.', NULL, NULL),
(2, 'Pre-suit', 'We have begun working on your case. Your most important job at this time is to continue treating. If surgery is recommended by your doctor, we will go over these options at this time.', NULL, NULL),
(3, 'Litigation', '', NULL, NULL),
(4, 'Settled', '', NULL, NULL),
(5, 'Closing', '', NULL, NULL),
(6, 'Archived', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE `config` (
  `Id` int(2) NOT NULL,
  `Type` varchar(20) NOT NULL,
  `Value` varchar(100) DEFAULT NULL,
  `Status` tinyint(4) DEFAULT NULL,
  `Created_at` datetime DEFAULT NULL,
  `Updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`Id`, `Type`, `Value`, `Status`, `Created_at`, `Updated_at`) VALUES
(1, 'Product License', 'rtertert6565856', NULL, NULL, '2020-11-20 21:23:55'),
(2, 'API Key', 'tytuytrutru987978', NULL, NULL, '2020-11-20 21:23:55'),
(3, 'Key Secret', 'yytiytityiyt8989789', NULL, NULL, '2020-11-20 21:23:55'),
(4, 'Logo', 'Logo.png', NULL, NULL, '2020-11-20 21:23:55');

-- --------------------------------------------------------

--
-- Table structure for table `legalteam_config`
--

CREATE TABLE `legalteam_config` (
  `Id` int(2) NOT NULL,
  `Type` varchar(30) NOT NULL,
  `Status` tinyint(4) DEFAULT NULL,
  `Full_name` varchar(20) DEFAULT NULL,
  `Email` varchar(30) DEFAULT NULL,
  `Phonenumber` varchar(30) DEFAULT NULL,
  `Created_at` datetime DEFAULT NULL,
  `Updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `legalteam_config`
--

INSERT INTO `legalteam_config` (`Id`, `Type`, `Status`, `Full_name`, `Email`, `Phonenumber`, `Created_at`, `Updated_at`) VALUES
(1, 'Paralegal', 2, 'Kasten Kenig', 'kkenig@800goldlaw.com', '(561)555-5555', NULL, '2020-11-25 18:02:28'),
(2, 'Assistant', 2, 'Meredith Schiller', 'MSchiller@800goldlaw.com', '(561)555-5555', NULL, '2020-11-25 17:45:23'),
(3, 'Attorney', 2, 'Don Vollender', 'dvollender@800goldlaw.com', '(561)555-5555', NULL, '2020-11-25 17:45:23'),
(4, 'Client Relations Manager', 1, 'Casey Smith', 'csmith@800goldlaw.com', '(561)555-5555', NULL, '2020-11-25 17:45:23');

-- --------------------------------------------------------

--
-- Table structure for table `phase`
--

CREATE TABLE `phase` (
  `Id` int(2) NOT NULL,
  `Category_Id` int(2) NOT NULL,
  `Phase` varchar(30) NOT NULL,
  `Description` text DEFAULT NULL,
  `Created_at` datetime DEFAULT NULL,
  `Updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phase`
--

INSERT INTO `phase` (`Id`, `Category_Id`, `Phase`, `Description`, `Created_at`, `Updated_at`) VALUES
(1, 1, 'PC: Intake', 'Congratulations! We’ve accepted your case and look forward to representing you for your personal injury case. We recognize this is a difficult time for you, and you may have many questions. During this phase, we make ourselves available to answer your concerns. Your Intake Coordinator can answer many of these questions, and if they can’t your assigned Case Manager can. If your case manager has been assigned, you will see their contact information to the left of this screen.', NULL, NULL),
(2, 1, 'PC: Approved Sign Up', NULL, NULL, NULL),
(3, 1, 'PC: Turndown', NULL, NULL, NULL),
(4, 2, 'PC: Lost Intake', NULL, NULL, NULL),
(5, 2, 'PC: No Contact', NULL, NULL, NULL),
(6, 2, 'PC: Pending', NULL, NULL, NULL),
(7, 3, 'PS: Initial Letters', NULL, NULL, NULL),
(8, 3, 'PS: Medically Treating', NULL, NULL, NULL),
(9, 3, 'PS: Demand to be Done', NULL, NULL, NULL),
(10, 4, 'PS: Demand Sent', NULL, NULL, NULL),
(11, 4, 'PS: Demand In Reply', NULL, NULL, NULL),
(12, 5, 'PS: Negotiations', NULL, NULL, NULL),
(13, 5, 'PS: Settled', NULL, NULL, NULL),
(14, 6, 'LIT: PSV to be Done', NULL, NULL, NULL),
(15, 6, 'LIST: PSV Now Done', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `phase_template`
--

CREATE TABLE `phase_template` (
  `Id` int(11) NOT NULL,
  `Template` varchar(100) NOT NULL,
  `Category` varchar(50) NOT NULL,
  `Created_at` datetime DEFAULT NULL,
  `Updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phase_template`
--

INSERT INTO `phase_template` (`Id`, `Template`, `Category`, `Created_at`, `Updated_at`) VALUES
(1, 'Personal Injury Law Firm', 'Intake', NULL, NULL),
(2, 'Personal Injury Law Firm', 'Pre-suit', NULL, NULL),
(3, 'Personal Injury Law Firm', 'Litigation', NULL, NULL),
(4, 'Personal Injury Law Firm', 'Settled', NULL, NULL),
(5, 'Personal Injury Law Firm', 'Closing', NULL, NULL),
(6, 'Personal Injury Law Firm', 'Archived', NULL, NULL),
(7, 'Criminal Defense Law Firm', 'Intake', NULL, NULL),
(8, 'Worker\'s Comp Law Firm', 'Intake', NULL, NULL),
(9, 'Mass Tort Law Firm', 'Intake', NULL, NULL),
(10, 'Medical Device Manufacturer', 'Intake', NULL, NULL),
(11, 'Tax/Accounting Audit Firm', 'Intake', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `Id` int(2) NOT NULL,
  `Full_name` varchar(30) DEFAULT NULL,
  `Email` varchar(30) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Created_at` datetime DEFAULT NULL,
  `Updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`Id`, `Full_name`, `Email`, `Password`, `Created_at`, `Updated_at`) VALUES
(5, 'Developer 1', 'dev1@gmail.com', '61bd60c60d9fb60cc8fc7767669d40a1', '2020-11-20 17:56:45', '2020-11-23 15:22:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `legalteam_config`
--
ALTER TABLE `legalteam_config`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `phase`
--
ALTER TABLE `phase`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `phase_template`
--
ALTER TABLE `phase_template`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `Id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `config`
--
ALTER TABLE `config`
  MODIFY `Id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `legalteam_config`
--
ALTER TABLE `legalteam_config`
  MODIFY `Id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `phase`
--
ALTER TABLE `phase`
  MODIFY `Id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `phase_template`
--
ALTER TABLE `phase_template`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `Id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
