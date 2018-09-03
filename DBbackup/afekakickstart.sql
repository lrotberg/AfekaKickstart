-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 03, 2018 at 06:20 AM
-- Server version: 5.7.21
-- PHP Version: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `afekakickstart`
--

-- --------------------------------------------------------

--
-- Table structure for table `donation`
--

DROP TABLE IF EXISTS `donation`;
CREATE TABLE IF NOT EXISTS `donation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `donator_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `amount` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `donation`
--

INSERT INTO `donation` (`id`, `project_id`, `donator_id`, `date`, `amount`) VALUES
(1, 1, 1, '2018-08-03 11:07:06', 200),
(2, 1, 4, '2018-08-03 20:17:21', 100),
(3, 1, 4, '2018-08-03 20:18:34', 12),
(4, 1, 4, '2018-08-03 20:20:10', 13),
(5, 1, 6, '2018-08-04 19:59:20', 105),
(6, 1, 1, '2018-08-04 20:28:11', 50),
(7, 1, 8, '2018-08-04 20:28:47', 100),
(9, 1, 4, '2018-08-05 17:22:03', 40),
(12, 1, 4, '2018-08-25 10:23:37', 500);

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

DROP TABLE IF EXISTS `permission`;
CREATE TABLE IF NOT EXISTS `permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_type` int(11) NOT NULL,
  `permission_user` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `type`) VALUES
(1, 'guest'),
(2, 'user'),
(3, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

DROP TABLE IF EXISTS `project`;
CREATE TABLE IF NOT EXISTS `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `creator` varchar(20) NOT NULL,
  `overview` varchar(250) NOT NULL,
  `amount` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `active` bit(1) NOT NULL,
  `funded` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `name`, `creator`, `overview`, `amount`, `start_date`, `end_date`, `active`, `funded`) VALUES
(1, 'Flappy Bird', 'Lior Rotberg', 'Multiplayer web flappy bird game using Node', 1000, '2018-08-03 00:00:00', '2018-08-31 20:00:00', b'0', b'1'),
(2, 'The Lancasters sends their regards', 'Stark', 'A detailed view of the war of the roses', 2200, '2018-07-01 00:00:00', '2018-08-04 08:00:00', b'0', b'0'),
(8, 'stam', 'mmm', 'fnnlfndfdfghdhg', 200, '2018-08-26 10:50:18', '2018-08-31 00:00:00', b'0', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(6) NOT NULL AUTO_INCREMENT,
  `USERNAME` varchar(20) NOT NULL,
  `PASSWORD` varchar(64) NOT NULL,
  `PERMISSIONS` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `USERNAME`, `PASSWORD`, `PERMISSIONS`) VALUES
(1, 'Lior Rotberg', '4A83C7116DDDC8CA4D26D9CAF39264DBBE2115BF088E8A2482D3D20D4F40DC1F', 2),
(2, 'John Smith', 'DF7F8868D3FAFBE7457EDF8B55C5F28F6E857972301FA45CBCB7C18774811FEB', 2),
(4, 'Stark', '3E0109C7650E7101A438F0F08C3F46FE2124A9E573ACF9CAB95CDBB555274E70', 2),
(5, 'Weasley', '239E80B6E1915EFE6B8DC3C0409EF83C244DA28D4709878917DB9E6E7077E24E', 2),
(6, 'Eldad', '3E0109C7650E7101A438F0F08C3F46FE2124A9E573ACF9CAB95CDBB555274E70', 2),
(7, 'Adi', '3E0109C7650E7101A438F0F08C3F46FE2124A9E573ACF9CAB95CDBB555274E70', 2),
(8, 'Mami', 'BCC7536E01FDFBDC8297F0758EFBC47CC0239788EB994CCAAC3C72AF9CCD802E', 2),
(9, 'Admin', 'FCF5DD353E95EBFB9F169C43C18E31A560C555481591A9045351F22930991503', 3),
(10, 'mmm', '3E0109C7650E7101A438F0F08C3F46FE2124A9E573ACF9CAB95CDBB555274E70', 2),
(11, 'kkfso', '3E0109C7650E7101A438F0F08C3F46FE2124A9E573ACF9CAB95CDBB555274E70', 2);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
