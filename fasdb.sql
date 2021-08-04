-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Jan 19, 2019 at 05:55 AM
-- Server version: 5.7.23
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fasdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

DROP TABLE IF EXISTS `address`;
CREATE TABLE IF NOT EXISTS `address` (
  `Id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `User_ID` int(11) DEFAULT NULL,
  `address_type` varchar(50) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`Id`, `User_ID`, `address_type`, `address`) VALUES
(1, 6, 'home', '21 jalan awan jawa '),
(2, 1, 'home', '21,jalan awan jawa'),
(4, 1, 'work', 'jalan awan hijaw');

-- --------------------------------------------------------

--
-- Table structure for table `authorities`
--

DROP TABLE IF EXISTS `authorities`;
CREATE TABLE IF NOT EXISTS `authorities` (
  `Id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `User_ID` int(11) DEFAULT NULL,
  `RR_Id` int(11) DEFAULT NULL,
  `resource_type` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=125 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `authorities`
--

INSERT INTO `authorities` (`Id`, `User_ID`, `RR_Id`, `resource_type`) VALUES
(60, 6, 1, 1),
(59, 1, 25, 1),
(3, 1, 24, 1),
(66, 1, 41, 1),
(5, 1, 26, 1),
(6, 1, 23, 1),
(7, 1, 28, 1),
(8, 1, 27, 1),
(9, 1, 41, 1),
(81, 14, 9, 1),
(80, 14, 2, 1),
(79, 14, 1, 1),
(13, 1, 45, 1),
(14, 1, 46, 1),
(15, 1, 47, 1),
(16, 1, 53, 1),
(78, 6, 8, 1),
(57, 1, 2, 1),
(19, 1, 5, 1),
(20, 1, 6, 1),
(21, 1, 7, 1),
(22, 1, 8, 1),
(71, 1, 1, 1),
(77, 6, 7, 1),
(25, 1, 5, 1),
(26, 1, 6, 1),
(27, 1, 7, 1),
(28, 1, 8, 1),
(29, 1, 10, 1),
(30, 1, 11, 1),
(31, 1, 12, 1),
(32, 1, 13, 1),
(33, 1, 14, 1),
(34, 1, 15, 1),
(35, 1, 16, 1),
(36, 1, 17, 1),
(37, 1, 18, 1),
(38, 1, 19, 1),
(39, 1, 20, 1),
(40, 1, 21, 1),
(41, 1, 22, 1),
(42, 1, 29, 1),
(43, 1, 30, 1),
(44, 1, 31, 1),
(45, 1, 32, 1),
(46, 1, 33, 1),
(47, 1, 34, 1),
(48, 1, 35, 1),
(49, 1, 36, 1),
(50, 1, 37, 1),
(51, 1, 38, 1),
(75, 6, 5, 1),
(74, 6, 4, 1),
(76, 6, 6, 1),
(61, 6, 2, 1),
(73, 1, 4, 1),
(72, 1, 9, 1),
(70, 1, 45, 1),
(82, 14, 4, 1),
(83, 14, 5, 1),
(84, 14, 6, 1),
(85, 14, 7, 1),
(86, 14, 8, 1),
(87, 14, 10, 1),
(88, 14, 11, 1),
(89, 14, 12, 1),
(90, 14, 13, 1),
(91, 14, 14, 1),
(92, 14, 15, 1),
(93, 14, 16, 1),
(94, 14, 17, 1),
(95, 14, 18, 1),
(96, 14, 19, 1),
(97, 14, 20, 1),
(98, 14, 21, 1),
(99, 14, 22, 1),
(100, 14, 23, 1),
(101, 14, 24, 1),
(102, 14, 25, 1),
(103, 14, 26, 1),
(104, 14, 27, 1),
(105, 14, 28, 1),
(106, 14, 29, 1),
(107, 14, 30, 1),
(108, 14, 31, 1),
(109, 14, 32, 1),
(110, 14, 33, 1),
(111, 14, 34, 1),
(112, 14, 35, 1),
(113, 14, 36, 1),
(114, 14, 37, 1),
(115, 14, 38, 1),
(116, 14, 39, 1),
(117, 14, 40, 1),
(118, 14, 41, 1),
(119, 14, 42, 1),
(120, 14, 43, 1),
(121, 14, 44, 1),
(122, 14, 45, 1),
(123, 14, 46, 1),
(124, 14, 47, 1);

-- --------------------------------------------------------

--
-- Table structure for table `chat_message`
--

DROP TABLE IF EXISTS `chat_message`;
CREATE TABLE IF NOT EXISTS `chat_message` (
  `Id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `F_Id` int(11) NOT NULL,
  `S_Id` int(11) NOT NULL,
  `Message` varchar(100) NOT NULL,
  `Device_Id` int(11) DEFAULT NULL,
  `action` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `Datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=144 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chat_message`
--

INSERT INTO `chat_message` (`Id`, `F_Id`, `S_Id`, `Message`, `Device_Id`, `action`, `status`, `Datetime`) VALUES
(1, 1, 6, 'hi', NULL, NULL, 1, '2018-12-05 20:14:20'),
(2, 6, 1, 'hi', NULL, NULL, 1, '2018-12-18 22:13:12'),
(3, 1, 6, 'how are you', NULL, NULL, 1, '2018-12-18 16:00:00'),
(4, 1, 6, 'ws', NULL, NULL, 1, '2018-12-27 03:46:45'),
(5, 1, 6, '555', NULL, NULL, 1, '2018-12-27 04:04:31'),
(6, 1, 6, '1', NULL, NULL, 1, '2018-12-27 04:21:45'),
(7, 1, 6, '0', NULL, NULL, 1, '2018-12-27 04:22:07'),
(8, 1, 6, '0', NULL, NULL, 1, '2018-12-27 04:22:23'),
(9, 1, 6, '0', NULL, NULL, 1, '2018-12-27 04:22:30'),
(10, 1, 6, '5', NULL, NULL, 1, '2018-12-27 04:22:41'),
(11, 1, 6, '2', NULL, NULL, 1, '2018-12-27 04:23:46'),
(12, 1, 6, '0', NULL, NULL, 1, '2018-12-27 04:24:04'),
(13, 1, 6, 'waseem', NULL, NULL, 1, '2018-12-27 04:25:34'),
(14, 1, 6, 'mm', NULL, NULL, 1, '2018-12-27 04:54:02'),
(15, 1, 6, 'mm', NULL, NULL, 1, '2018-12-27 06:14:10'),
(16, 1, 6, 'mmmjhh', NULL, NULL, 1, '2018-12-27 08:50:12'),
(17, 1, 6, 'oky', NULL, NULL, 1, '2018-12-27 10:40:30'),
(18, 1, 6, 'mi', NULL, NULL, 1, '2018-12-27 10:45:10'),
(19, 1, 6, 'ci', NULL, NULL, 1, '2018-12-27 10:45:54'),
(20, 1, 6, 'fifi', NULL, NULL, 1, '2018-12-27 10:46:13'),
(21, 1, 6, ' v', NULL, NULL, 1, '2018-12-27 10:50:40'),
(22, 1, 6, 'mvs', NULL, NULL, 1, '2018-12-27 10:54:32'),
(23, 1, 6, 'm', NULL, NULL, 1, '2018-12-27 11:08:09'),
(24, 1, 6, 'mm', NULL, NULL, 1, '2018-12-31 10:13:52'),
(25, 1, 6, 'mm', NULL, NULL, 1, '2018-12-31 10:13:57'),
(26, 1, 6, 'mm', NULL, NULL, 1, '2018-12-31 10:13:58'),
(27, 1, 6, 'kkl', NULL, NULL, 1, '2018-12-31 10:21:50'),
(28, 1, 6, 'nm', NULL, NULL, 1, '2018-12-31 10:24:36'),
(29, 1, 6, ',,', NULL, NULL, 1, '2018-12-31 10:32:30'),
(30, 1, 6, 'mm', NULL, NULL, 1, '2018-12-31 10:37:09'),
(31, 1, 6, 'mm', NULL, NULL, 1, '2018-12-31 10:40:38'),
(32, 1, 6, 'mm', NULL, NULL, 1, '2018-12-31 10:41:16'),
(33, 1, 6, 'mm', NULL, NULL, 1, '2018-12-31 10:41:30'),
(34, 1, 6, 'mm', NULL, NULL, 1, '2018-12-31 10:42:23'),
(35, 1, 6, 'mm', NULL, NULL, 1, '2018-12-31 10:42:29'),
(36, 1, 6, 'mm', NULL, NULL, 1, '2018-12-31 10:42:31'),
(37, 1, 6, 'mm', NULL, NULL, 1, '2018-12-31 10:42:31'),
(38, 1, 6, 'mmm', NULL, NULL, 1, '2018-12-31 10:43:33'),
(39, 1, 6, 'mmm', NULL, NULL, 1, '2018-12-31 10:43:42'),
(40, 1, 6, 'ccx', NULL, NULL, 1, '2018-12-31 10:44:16'),
(41, 1, 6, ',m', NULL, NULL, 1, '2018-12-31 10:46:16'),
(42, 1, 6, 'm', NULL, NULL, 1, '2018-12-31 10:57:42'),
(43, 1, 6, 'cfdhd', NULL, NULL, 1, '2018-12-31 11:03:34'),
(44, 1, 6, 'm', NULL, NULL, 1, '2019-01-01 06:33:10'),
(45, 1, 6, 'n', NULL, NULL, 1, '2019-01-01 06:40:13'),
(46, 1, 6, 'nm', NULL, NULL, 1, '2019-01-01 06:40:16'),
(47, 1, 6, 'nm', NULL, NULL, 1, '2019-01-01 06:40:16'),
(48, 1, 6, 'nm', NULL, NULL, 1, '2019-01-01 06:40:18'),
(49, 1, 6, 'nm', NULL, NULL, 1, '2019-01-01 06:40:19'),
(50, 1, 6, 'nm', NULL, NULL, 1, '2019-01-01 06:40:19'),
(51, 1, 6, 'nm', NULL, NULL, 1, '2019-01-01 06:40:20'),
(52, 1, 6, 'nm', NULL, NULL, 1, '2019-01-01 06:40:20'),
(53, 1, 6, 'nm', NULL, NULL, 1, '2019-01-01 06:40:20'),
(54, 1, 6, 'nm', NULL, NULL, 1, '2019-01-01 06:40:20'),
(55, 1, 6, 'nm', NULL, NULL, 1, '2019-01-01 06:40:21'),
(56, 1, 6, 'nm', NULL, NULL, 1, '2019-01-01 06:40:21'),
(57, 1, 6, 'n', NULL, NULL, 1, '2019-01-01 06:40:42'),
(58, 1, 6, 'nm', NULL, NULL, 1, '2019-01-01 06:40:44'),
(59, 1, 6, 'nmk', NULL, NULL, 1, '2019-01-01 06:40:45'),
(60, 1, 6, 'nmk', NULL, NULL, 1, '2019-01-01 06:40:46'),
(61, 1, 6, 'nmk', NULL, NULL, 1, '2019-01-01 06:40:47'),
(62, 1, 6, 'nmk', NULL, NULL, 1, '2019-01-01 06:40:47'),
(63, 1, 6, 'nmkn', NULL, NULL, 1, '2019-01-01 06:40:50'),
(64, 1, 6, 'nmkn', NULL, NULL, 1, '2019-01-01 06:40:50'),
(65, 1, 6, 'nmkn', NULL, NULL, 1, '2019-01-01 06:41:01'),
(66, 1, 6, ',mk', NULL, NULL, 1, '2019-01-01 07:06:30'),
(67, 1, 6, ',mk', NULL, NULL, 1, '2019-01-01 07:06:31'),
(68, 1, 6, 'kkkkk', NULL, NULL, 1, '2019-01-01 07:06:37'),
(69, 1, 6, 'kkkkk', NULL, NULL, 1, '2019-01-01 07:06:37'),
(70, 1, 6, 'nm', NULL, NULL, 1, '2019-01-01 07:21:46'),
(71, 1, 6, 'nm', NULL, NULL, 1, '2019-01-01 07:21:47'),
(72, 1, 6, 'nm', NULL, NULL, 1, '2019-01-01 07:21:51'),
(73, 1, 6, 'fffffffff', NULL, NULL, 1, '2019-01-01 07:21:59'),
(74, 1, 6, 'mm', NULL, NULL, 1, '2019-01-01 08:10:43'),
(75, 1, 6, 'mm', NULL, NULL, 1, '2019-01-01 08:10:44'),
(76, 1, 6, 'mm', NULL, NULL, 1, '2019-01-01 08:10:45'),
(77, 1, 6, 'last', NULL, NULL, 1, '2019-01-01 08:29:37'),
(78, 1, 6, 'last', NULL, NULL, 1, '2019-01-01 08:29:39'),
(79, 1, 6, 'kk', NULL, NULL, 1, '2019-01-01 08:32:54'),
(80, 1, 6, 'kk', NULL, NULL, 1, '2019-01-01 08:32:56'),
(81, 1, 6, 'm', NULL, NULL, 1, '2019-01-01 09:56:04'),
(82, 1, 6, 'm', NULL, NULL, 1, '2019-01-01 09:56:05'),
(83, 1, 6, 'm', NULL, NULL, 1, '2019-01-01 09:56:10'),
(84, 1, 6, 'kkk', NULL, NULL, 1, '2019-01-01 10:33:07'),
(85, 1, 6, 'mmm', NULL, NULL, 1, '2019-01-01 10:33:13'),
(86, 1, 6, 'mmm', NULL, NULL, 1, '2019-01-01 10:33:15'),
(87, 1, 6, 'mmm', NULL, NULL, 1, '2019-01-01 10:33:15'),
(88, 1, 6, 'mmmlll;l', NULL, NULL, 1, '2019-01-01 10:33:30'),
(89, 1, 6, 'kk', NULL, NULL, 1, '2019-01-01 10:41:22'),
(90, 1, 6, 'kk', NULL, NULL, 1, '2019-01-01 10:41:30'),
(91, 1, 6, 'kkn', NULL, NULL, 1, '2019-01-01 10:41:32'),
(92, 1, 6, 'kkn', NULL, NULL, 1, '2019-01-01 10:41:33'),
(93, 1, 6, ',,', NULL, NULL, 1, '2019-01-01 10:48:39'),
(94, 1, 6, 'kkkll', NULL, NULL, 1, '2019-01-01 10:48:47'),
(95, 1, 6, 'kkkll', NULL, NULL, 1, '2019-01-01 10:48:48'),
(96, 1, 6, 'kkkll', NULL, NULL, 1, '2019-01-01 10:48:49'),
(97, 1, 6, 'mmm', NULL, NULL, 1, '2019-01-02 04:54:50'),
(98, 1, 6, 'mmmdl,', NULL, NULL, 1, '2019-01-02 04:55:00'),
(99, 1, 6, 'mmmdl,', NULL, NULL, 1, '2019-01-02 04:55:01'),
(100, 1, 6, 'mmmdl,', NULL, NULL, 1, '2019-01-02 04:55:03'),
(101, 1, 6, 'mmmdl,', NULL, NULL, 1, '2019-01-02 04:55:03'),
(102, 1, 6, 'kk', NULL, NULL, 1, '2019-01-02 04:58:43'),
(103, 1, 6, 'kk', NULL, NULL, 1, '2019-01-02 04:58:47'),
(104, 1, 6, 'mjkjh', NULL, NULL, 1, '2019-01-02 04:58:54'),
(105, 1, 6, 'mjkjh', NULL, NULL, 1, '2019-01-02 04:59:03'),
(106, 1, 6, 'mjkjh', NULL, NULL, 1, '2019-01-02 04:59:06'),
(107, 1, 6, 'nn', NULL, NULL, 1, '2019-01-02 05:28:15'),
(108, 1, 6, 'km', NULL, NULL, 1, '2019-01-02 05:28:20'),
(109, 1, 6, 'hi', NULL, NULL, 1, '2019-01-02 05:28:25'),
(110, 1, 6, 'j', NULL, NULL, 1, '2019-01-02 05:30:44'),
(111, 1, 6, 'hwll', NULL, NULL, 1, '2019-01-02 05:30:49'),
(112, 1, 6, 'hwll', NULL, NULL, 1, '2019-01-02 05:30:50'),
(113, 1, 6, 'test', NULL, NULL, 1, '2019-01-02 05:31:00'),
(114, 1, 6, 'test', NULL, NULL, 1, '2019-01-02 05:31:01'),
(115, 1, 6, 'test', NULL, NULL, 1, '2019-01-02 05:31:08'),
(116, 1, 6, 'test', NULL, NULL, 1, '2019-01-02 05:31:09'),
(117, 1, 6, 'test', NULL, NULL, 1, '2019-01-02 05:31:35'),
(118, 1, 6, 'test', NULL, NULL, 1, '2019-01-02 05:31:37'),
(119, 1, 6, 'test', NULL, NULL, 1, '2019-01-02 05:31:41'),
(120, 1, 6, 'test', NULL, NULL, 1, '2019-01-02 05:31:42'),
(121, 1, 6, 'try', NULL, NULL, 1, '2019-01-02 05:32:48'),
(122, 1, 6, 'tryy', NULL, NULL, 1, '2019-01-02 05:32:50'),
(123, 1, 6, 'm', NULL, NULL, 1, '2019-01-02 05:33:00'),
(124, 6, 1, '0', NULL, NULL, 1, '2019-01-08 12:39:02'),
(125, 6, 1, '0', NULL, NULL, 1, '2019-01-08 12:42:53'),
(126, 0, 0, '0', NULL, NULL, 0, '2019-01-08 12:44:26'),
(127, 0, 0, '0', NULL, NULL, 0, '2019-01-08 12:45:06'),
(128, 0, 0, '0', NULL, NULL, 0, '2019-01-08 12:46:03'),
(129, 6, 1, ' can you please turn on room3', NULL, NULL, 1, '2019-01-08 12:52:02'),
(130, 6, 1, ' can you please turn on room3', NULL, NULL, 1, '2019-01-08 12:54:06'),
(131, 1, 6, ' can you please turn on water', NULL, NULL, 1, '2019-01-08 12:54:44'),
(132, 1, 6, ' can you please turn off water', NULL, NULL, 1, '2019-01-08 12:56:30'),
(133, 1, 6, ' room3', NULL, NULL, 1, '2019-01-08 12:56:42'),
(134, 1, 6, ' can you please turn off room3', 5, 0, 1, '2019-01-08 12:57:01'),
(135, 1, 6, ' can you please turn on water', NULL, NULL, 1, '2019-01-08 12:58:19'),
(136, 1, 6, ' can you please turn off mobile', 5, 1, 1, '2019-01-08 12:58:24'),
(137, 1, 6, ' can you please turn on room3', 5, 0, 1, '2019-01-09 08:37:53'),
(138, 6, 1, ' can you please turn on room3', 5, 1, 1, '2019-01-09 08:40:02'),
(139, 1, 6, ' can you please turn on aircon', NULL, NULL, 1, '2019-01-15 04:45:04'),
(140, 6, 1, ' can you please turn off pc', NULL, NULL, 1, '2019-01-15 06:17:57'),
(141, 1, 6, ' can you please turn on WM', NULL, NULL, 1, '2019-01-17 02:36:02'),
(142, 6, 14, 'mx,.', NULL, NULL, 1, '2019-01-19 05:06:04'),
(143, 6, 1, ' humidity', NULL, NULL, 1, '2019-01-19 05:06:13');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `Id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `User_ID` int(11) NOT NULL,
  `Contact_Type` varchar(100) NOT NULL,
  `Value` varchar(40) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`Id`, `User_ID`, `Contact_Type`, `Value`) VALUES
(2, 1, 'phone', '006037225116');

-- --------------------------------------------------------

--
-- Table structure for table `device`
--

DROP TABLE IF EXISTS `device`;
CREATE TABLE IF NOT EXISTS `device` (
  `Id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Unite_Id` int(11) DEFAULT NULL,
  `Name` varchar(30) DEFAULT NULL,
  `GPIO_id` int(11) NOT NULL,
  `Description` varchar(30) DEFAULT NULL,
  `Img` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `device`
--

INSERT INTO `device` (`Id`, `Unite_Id`, `Name`, `GPIO_id`, `Description`, `Img`) VALUES
(1, 1, 'mobile', 1, 'my mobile phone', '/FAS/img/icon/006-phone.png'),
(2, 1, 'oven', 3, 'turn on or off the oven ', '/FAS/img/icon/037-oven-1'),
(9, 3, 'aircon', 6, 'aircon', '/fas/img/icon/002-air-conditioner-2.png'),
(8, 3, 'WM', 5, 'WM', '/fas/img/icon/washing-machine.png'),
(7, 2, 'waseem', 4, 'lite', '/fas/img/icon/004-computer.png'),
(10, 5, 'nn', 7, 'nn', '/fas/img/icon/001-key.png'),
(11, 5, 'fan', 8, 'fan', '/fas/img/icon/036-air-conditioner-1.png'),
(12, 2, 'pc', 9, 'pc', '/fas/img/icon/006-home-8.png'),
(13, 1, 'temperature sensor', 10, 'temperature', '/fas/img/icon/030-thermometer.png'),
(14, 1, 'humidity', 10, 'humidity sensor', '/fas/img/icon/010-snowflake.png'),
(15, 1, '4 lite', 3, '4', '/fas/img/icon/001-light-bulb-3.png'),
(16, 1, 'nn', 3, '4', '/fas/img/icon/001-safebox.png');

-- --------------------------------------------------------

--
-- Table structure for table `gpio`
--

DROP TABLE IF EXISTS `gpio`;
CREATE TABLE IF NOT EXISTS `gpio` (
  `Id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `raspberry_id` int(11) NOT NULL,
  `GPIO_Number` int(2) NOT NULL,
  `status` int(11) NOT NULL,
  `Description` varchar(100) DEFAULT NULL,
  `Type` int(1) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gpio`
--

INSERT INTO `gpio` (`Id`, `raspberry_id`, `GPIO_Number`, `status`, `Description`, `Type`) VALUES
(1, 1, 5, 1, 'relay', 0),
(3, 1, 4, 1, 'relay', 0),
(4, 1, 18, 1, 'relay', 0),
(5, 1, 17, 1, 'relay', 0),
(6, 1, 22, 1, 'relay', 0),
(7, 1, 27, 1, 'realy', 0),
(8, 1, 23, 1, 'relay', 0),
(9, 1, 24, 1, 'relay', 0),
(11, 1, 26, 0, 'sensor', 0);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

DROP TABLE IF EXISTS `notification`;
CREATE TABLE IF NOT EXISTS `notification` (
  `Id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `PAU_Id` int(11) DEFAULT NULL,
  `Description` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `raspberry`
--

DROP TABLE IF EXISTS `raspberry`;
CREATE TABLE IF NOT EXISTS `raspberry` (
  `Id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `Description` varchar(50) NOT NULL,
  `address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `raspberry`
--

INSERT INTO `raspberry` (`Id`, `Name`, `Description`, `address`) VALUES
(1, 'raspberry 1', 'main raspberry', '192.168.1.102');

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

DROP TABLE IF EXISTS `resources`;
CREATE TABLE IF NOT EXISTS `resources` (
  `Id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Resources_Name` varchar(50) NOT NULL,
  `Description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `resources`
--

INSERT INTO `resources` (`Id`, `Resources_Name`, `Description`) VALUES
(1, 'Dashboard', 'home page'),
(2, 'Unite', 'unite page you can display add delete update unite '),
(3, 'device', 'device page you can display add delete update device'),
(6, 'raspberry', 'raspberry page you can display add delete update reaspberry'),
(7, 'gpio', 'gpio page you can display add delete update gpio'),
(8, 'sensor', 'show sensor history'),
(9, 'user', 'user control page you can display add delete update user'),
(10, 'address', 'addresses page you can display add delete update address'),
(11, 'contact', 'contacts page you can display add delete update contact'),
(12, 'role', 'display your roles'),
(13, 'authoritie', 'authorities page you can display add delete update authoritie');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `Id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Role_Name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`Id`, `Role_Name`) VALUES
(3, 'open page'),
(4, 'display data'),
(5, 'insert data'),
(6, 'delete data'),
(7, 'update data'),
(8, 'show'),
(9, 'hide');

-- --------------------------------------------------------

--
-- Table structure for table `roleresources`
--

DROP TABLE IF EXISTS `roleresources`;
CREATE TABLE IF NOT EXISTS `roleresources` (
  `Id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Role_Id` int(11) DEFAULT NULL,
  `Resoources_Id` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roleresources`
--

INSERT INTO `roleresources` (`Id`, `Role_Id`, `Resoources_Id`) VALUES
(1, 3, 1),
(2, 4, 1),
(9, 3, 3),
(4, 3, 2),
(5, 4, 2),
(6, 5, 2),
(7, 6, 2),
(8, 7, 2),
(10, 4, 3),
(11, 5, 3),
(12, 6, 3),
(13, 7, 3),
(14, 3, 6),
(15, 4, 6),
(16, 5, 6),
(17, 6, 6),
(18, 7, 6),
(19, 3, 7),
(20, 4, 7),
(21, 5, 7),
(22, 6, 7),
(23, 7, 7),
(24, 3, 9),
(25, 4, 9),
(26, 5, 9),
(27, 6, 9),
(28, 7, 9),
(29, 3, 10),
(30, 4, 10),
(31, 5, 10),
(32, 6, 10),
(33, 7, 10),
(34, 3, 11),
(35, 4, 11),
(36, 5, 11),
(37, 6, 11),
(38, 7, 11),
(39, 3, 8),
(40, 4, 8),
(41, 3, 13),
(42, 4, 13),
(43, 5, 13),
(44, 6, 13),
(45, 7, 13),
(46, 3, 12),
(47, 4, 12);

-- --------------------------------------------------------

--
-- Table structure for table `roleunite`
--

DROP TABLE IF EXISTS `roleunite`;
CREATE TABLE IF NOT EXISTS `roleunite` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Role_Id` int(11) NOT NULL,
  `Unite_Id` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roleunite`
--

INSERT INTO `roleunite` (`Id`, `Role_Id`, `Unite_Id`) VALUES
(1, 8, 1),
(2, 9, 1),
(3, 8, 2),
(4, 9, 2),
(5, 8, 3),
(6, 9, 3),
(7, 8, 5),
(8, 9, 5),
(9, 8, 7),
(10, 9, 7);

-- --------------------------------------------------------

--
-- Table structure for table `sensor`
--

DROP TABLE IF EXISTS `sensor`;
CREATE TABLE IF NOT EXISTS `sensor` (
  `Id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Device_Id` int(11) NOT NULL,
  `Value` varchar(11) NOT NULL,
  `status` int(2) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `unite`
--

DROP TABLE IF EXISTS `unite`;
CREATE TABLE IF NOT EXISTS `unite` (
  `Id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Name` varchar(30) NOT NULL,
  `Description` varchar(30) DEFAULT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `unite`
--

INSERT INTO `unite` (`Id`, `Name`, `Description`, `status`) VALUES
(1, 'room1', 'ahmad room', 1),
(2, 'room2', 'waseem room', 0),
(3, 'room3', 'samer room', 1),
(5, 'room4', 'toilet', 0),
(7, 'Room 6', 'Test', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `Id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `First_Name` varchar(30) DEFAULT NULL,
  `Last_Name` varchar(30) DEFAULT NULL,
  `password` varchar(30) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `Img` varchar(50) DEFAULT NULL,
  `Birthday` date DEFAULT NULL,
  `Gender` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`Id`, `First_Name`, `Last_Name`, `password`, `email`, `Img`, `Birthday`, `Gender`) VALUES
(1, 'waseem', 'alnounou', 'waseem', 'waseem-alnounou@hotmail.com', '/fas/img/user/was.jpg', '1994-08-31', 1),
(6, 'ahmad', 'alnounou', 'ahmad', 'ahmad@gmail.com', '/fas/img/user/ahmad.jpeg', '2000-02-02', 1),
(14, 'mohamad', 'hafizul', '12345', 'zul@hotmail.com', NULL, '2019-01-10', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
