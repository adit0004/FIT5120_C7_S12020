-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 15, 2020 at 09:37 AM
-- Server version: 5.7.24
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eldvisor`
--

-- --------------------------------------------------------

--
-- Table structure for table `days_of_physical_activity`
--

DROP TABLE IF EXISTS `days_of_physical_activity`;
CREATE TABLE IF NOT EXISTS `days_of_physical_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number_of_days_of_exercise` varchar(6) DEFAULT NULL,
  `age` varchar(5) DEFAULT NULL,
  `number_of_people` decimal(5,2) DEFAULT NULL,
  `proportion` decimal(6,2) DEFAULT NULL,
  `gender` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=99 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `days_of_physical_activity`
--

INSERT INTO `days_of_physical_activity` (`id`, `number_of_days_of_exercise`, `age`, `number_of_people`, `proportion`, `gender`) VALUES
(1, 'One', '18-24', '118.20', '17.40', 'Male'),
(2, 'One', '25-34', '198.60', '20.70', 'Male'),
(3, 'One', '35-44', '214.10', '22.60', 'Male'),
(4, 'One', '45-54', '154.10', '19.00', 'Male'),
(5, 'One', '55-64', '120.00', '16.70', 'Male'),
(6, 'One', '65-74', '46.80', '11.10', 'Male'),
(7, 'One', '75 +', '18.90', '8.50', 'Male'),
(8, 'Two', '18-24', '133.80', '19.70', 'Male'),
(9, 'Two', '25-34', '174.80', '18.20', 'Male'),
(10, 'Two', '35-44', '202.10', '21.30', 'Male'),
(11, 'Two', '45-54', '147.70', '18.20', 'Male'),
(12, 'Two', '55-64', '109.10', '15.20', 'Male'),
(13, 'Two', '65-74', '57.40', '13.70', 'Male'),
(14, 'Two', '75 +', '39.10', '17.50', 'Male'),
(15, 'Three', '18-24', '140.60', '20.70', 'Male'),
(16, 'Three', '25-34', '190.80', '19.90', 'Male'),
(17, 'Three', '35-44', '174.20', '18.40', 'Male'),
(18, 'Three', '45-54', '114.80', '14.20', 'Male'),
(19, 'Three', '55-64', '111.80', '15.60', 'Male'),
(20, 'Three', '65-74', '51.50', '12.20', 'Male'),
(21, 'Three', '75 +', '29.90', '13.40', 'Male'),
(22, 'Four', '18-24', '93.10', '13.70', 'Male'),
(23, 'Four', '25-34', '113.90', '11.90', 'Male'),
(24, 'Four', '35-44', '100.70', '10.60', 'Male'),
(25, 'Four', '45-54', '69.60', '8.60', 'Male'),
(26, 'Four', '55-64', '83.50', '11.60', 'Male'),
(27, 'Four', '65-74', '40.70', '9.70', 'Male'),
(28, 'Four', '75 +', '14.90', '6.70', 'Male'),
(29, 'Five', '18-24', '73.40', '10.80', 'Male'),
(30, 'Five', '25-34', '99.50', '10.40', 'Male'),
(31, 'Five', '35-44', '106.60', '11.30', 'Male'),
(32, 'Five', '45-54', '96.50', '11.90', 'Male'),
(33, 'Five', '55-64', '89.90', '12.50', 'Male'),
(34, 'Five', '65-74', '40.00', '9.50', 'Male'),
(35, 'Five', '75 +', '23.50', '10.50', 'Male'),
(36, 'Six', '18-24', '27.90', '4.10', 'Male'),
(37, 'Six', '25-34', '53.30', '5.60', 'Male'),
(38, 'Six', '35-44', '33.10', '3.50', 'Male'),
(39, 'Six', '45-54', '39.80', '4.90', 'Male'),
(40, 'Six', '55-64', '45.20', '6.30', 'Male'),
(41, 'Six', '65-74', '31.60', '7.50', 'Male'),
(42, 'Six', '75 +', '16.20', '7.30', 'Male'),
(43, 'Seven', '18-24', '92.90', '13.70', 'Male'),
(44, 'Seven', '25-34', '127.30', '13.30', 'Male'),
(45, 'Seven', '35-44', '116.20', '12.30', 'Male'),
(46, 'Seven', '45-54', '188.20', '23.20', 'Male'),
(47, 'Seven', '55-64', '159.00', '22.10', 'Male'),
(48, 'Seven', '65-74', '152.20', '36.20', 'Male'),
(49, 'Seven', '75 +', '80.80', '36.20', 'Male'),
(50, 'One', '18-24', '105.50', '17.40', 'Female'),
(51, 'One', '25-34', '195.60', '20.90', 'Female'),
(52, 'One', '35-44', '176.10', '18.70', 'Female'),
(53, 'One', '45-54', '160.60', '17.80', 'Female'),
(54, 'One', '55-64', '119.60', '17.20', 'Female'),
(55, 'One', '65-74', '46.00', '11.00', 'Female'),
(56, 'One', '75 +', '33.60', '13.20', 'Female'),
(57, 'Two', '18-24', '111.70', '18.50', 'Female'),
(58, 'Two', '25-34', '188.80', '20.20', 'Female'),
(59, 'Two', '35-44', '216.10', '22.90', 'Female'),
(60, 'Two', '45-54', '175.30', '19.50', 'Female'),
(61, 'Two', '55-64', '107.00', '15.40', 'Female'),
(62, 'Two', '65-74', '64.30', '15.40', 'Female'),
(63, 'Two', '75 +', '48.40', '19.10', 'Female'),
(64, 'Three', '18-24', '119.10', '19.70', 'Female'),
(65, 'Three', '25-34', '166.40', '17.80', 'Female'),
(66, 'Three', '35-44', '172.70', '18.30', 'Female'),
(67, 'Three', '45-54', '151.40', '16.80', 'Female'),
(68, 'Three', '55-64', '124.90', '17.90', 'Female'),
(69, 'Three', '65-74', '78.00', '18.70', 'Female'),
(70, 'Three', '75 +', '35.50', '14.00', 'Female'),
(71, 'Four', '18-24', '90.00', '14.90', 'Female'),
(72, 'Four', '25-34', '108.80', '11.60', 'Female'),
(73, 'Four', '35-44', '81.30', '8.60', 'Female'),
(74, 'Four', '45-54', '105.00', '11.70', 'Female'),
(75, 'Four', '55-64', '82.50', '11.80', 'Female'),
(76, 'Four', '65-74', '34.80', '8.30', 'Female'),
(77, 'Four', '75 +', '17.90', '7.10', 'Female'),
(78, 'Five', '18-24', '79.30', '13.10', 'Female'),
(79, 'Five', '25-34', '101.80', '10.90', 'Female'),
(80, 'Five', '35-44', '131.60', '13.90', 'Female'),
(81, 'Five', '45-54', '110.50', '12.30', 'Female'),
(82, 'Five', '55-64', '86.90', '12.50', 'Female'),
(83, 'Five', '65-74', '47.00', '11.30', 'Female'),
(84, 'Five', '75 +', '20.50', '8.10', 'Female'),
(85, 'Six', '18-24', '18.40', '3.00', 'Female'),
(86, 'Six', '25-34', '53.80', '5.80', 'Female'),
(87, 'Six', '35-44', '46.80', '5.00', 'Female'),
(88, 'Six', '45-54', '48.00', '5.30', 'Female'),
(89, 'Six', '55-64', '33.80', '4.90', 'Female'),
(90, 'Six', '65-74', '33.50', '8.00', 'Female'),
(91, 'Six', '75 +', '13.70', '5.40', 'Female'),
(92, 'Seven', '18-24', '80.50', '13.30', 'Female'),
(93, 'Seven', '25-34', '118.70', '12.70', 'Female'),
(94, 'Seven', '35-44', '119.10', '12.60', 'Female'),
(95, 'Seven', '45-54', '149.00', '16.60', 'Female'),
(96, 'Seven', '55-64', '141.60', '20.30', 'Female'),
(97, 'Seven', '65-74', '114.00', '27.30', 'Female'),
(98, 'Seven', '75 +', '84.00', '33.10', 'Female');

-- --------------------------------------------------------

--
-- Table structure for table `met_guidelines`
--

DROP TABLE IF EXISTS `met_guidelines`;
CREATE TABLE IF NOT EXISTS `met_guidelines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `age` varchar(5) DEFAULT NULL,
  `met_guidelines` varchar(3) DEFAULT NULL,
  `gender` varchar(6) DEFAULT NULL,
  `met_guidelines_proportional` decimal(3,1) DEFAULT NULL,
  `number` decimal(4,1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `met_guidelines`
--

INSERT INTO `met_guidelines` (`id`, `age`, `met_guidelines`, `gender`, `met_guidelines_proportional`, `number`) VALUES
(1, '18-24', 'Yes', 'Male', '37.3', '380.3'),
(2, '25-34', 'Yes', 'Male', '34.3', '495.8'),
(3, '35-44', 'Yes', 'Male', '29.5', '443.8'),
(4, '45-54', 'Yes', 'Male', '31.6', '449.2'),
(5, '55-64', 'Yes', 'Male', '34.6', '405.8'),
(6, '65-74', 'Yes', 'Male', '38.6', '272.2'),
(7, '75 +', 'Yes', 'Male', '27.5', '138.7'),
(8, '18-24', 'Yes', 'Female', '32.7', '321.2'),
(9, '25-34', 'Yes', 'Female', '33.7', '481.9'),
(10, '35-44', 'Yes', 'Female', '30.2', '466.0'),
(11, '45-54', 'Yes', 'Female', '29.8', '436.5'),
(12, '55-64', 'Yes', 'Female', '27.1', '317.3'),
(13, '65-74', 'Yes', 'Female', '29.5', '217.7'),
(14, '75 +', 'Yes', 'Female', '16.1', '105.1'),
(15, '18-24', 'No', 'Male', '53.0', '539.5'),
(16, '25-34', 'No', 'Male', '57.9', '837.7'),
(17, '35-44', 'No', 'Male', '62.2', '934.1'),
(18, '45-54', 'No', 'Male', '63.3', '900.6'),
(19, '55-64', 'No', 'Male', '59.1', '692.2'),
(20, '65-74', 'No', 'Male', '56.8', '400.4'),
(21, '75 +', 'No', 'Male', '70.3', '354.6'),
(22, '18-24', 'No', 'Female', '59.0', '579.5'),
(23, '25-34', 'No', 'Female', '58.1', '830.0'),
(24, '35-44', 'No', 'Female', '63.3', '977.0'),
(25, '45-54', 'No', 'Female', '64.5', '943.1'),
(26, '55-64', 'No', 'Female', '65.5', '767.1'),
(27, '65-74', 'No', 'Female', '63.9', '472.1'),
(28, '75 +', 'No', 'Female', '80.2', '523.9');

-- --------------------------------------------------------

--
-- Table structure for table `type_of_exercise`
--

DROP TABLE IF EXISTS `type_of_exercise`;
CREATE TABLE IF NOT EXISTS `type_of_exercise` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_of_exercise` varchar(11) DEFAULT NULL,
  `age` varchar(5) DEFAULT NULL,
  `gender` varchar(6) DEFAULT NULL,
  `proportion` decimal(3,1) DEFAULT NULL,
  `number` decimal(4,1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `type_of_exercise`
--

INSERT INTO `type_of_exercise` (`id`, `type_of_exercise`, `age`, `gender`, `proportion`, `number`) VALUES
(1, 'No exercise', '18-24', 'Male', '33.2', '338.2'),
(2, 'No exercise', '25-34', 'Male', '33.8', '488.9'),
(3, 'No exercise', '35-44', 'Male', '37.0', '555.6'),
(4, 'No exercise', '45-54', 'Male', '43.0', '611.4'),
(5, 'No exercise', '55-64', 'Male', '38.7', '453.1'),
(6, 'No exercise', '65-74', 'Male', '40.4', '284.9'),
(7, 'No exercise', '75 +', 'Male', '55.7', '280.9'),
(8, 'Walking', '18-24', 'Male', '28.9', '294.0'),
(9, 'Walking', '25-34', 'Male', '39.4', '570.8'),
(10, 'Walking', '35-44', 'Male', '41.3', '620.0'),
(11, 'Walking', '45-54', 'Male', '43.6', '620.0'),
(12, 'Walking', '55-64', 'Male', '45.5', '533.5'),
(13, 'Walking', '65-74', 'Male', '50.3', '354.7'),
(14, 'Walking', '75 +', 'Male', '36.1', '182.0'),
(15, 'Moderate', '18-24', 'Male', '47.2', '480.5'),
(16, 'Moderate', '25-34', 'Male', '41.5', '600.5'),
(17, 'Moderate', '35-44', 'Male', '36.2', '544.2'),
(18, 'Moderate', '45-54', 'Male', '29.8', '424.3'),
(19, 'Moderate', '55-64', 'Male', '28.6', '335.6'),
(20, 'Moderate', '65-74', 'Male', '22.9', '161.6'),
(21, 'Moderate', '75 +', 'Male', '17.6', '88.5'),
(22, 'Vigorous', '18-24', 'Male', '32.2', '328.2'),
(23, 'Vigorous', '25-34', 'Male', '22.6', '327.1'),
(24, 'Vigorous', '35-44', 'Male', '18.5', '277.9'),
(25, 'Vigorous', '45-54', 'Male', '13.3', '188.7'),
(26, 'Vigorous', '55-64', 'Male', '7.9', '92.1'),
(27, 'Vigorous', '65-74', 'Male', '4.4', '31.1'),
(28, 'Vigorous', '75 +', 'Male', '1.9', '9.4'),
(29, 'No exercise', '18-24', 'Female', '38.5', '378.3'),
(30, 'No exercise', '25-34', 'Female', '34.7', '495.5'),
(31, 'No exercise', '35-44', 'Female', '38.8', '599.1'),
(32, 'No exercise', '45-54', 'Female', '38.5', '562.4'),
(33, 'No exercise', '55-64', 'Female', '40.5', '474.6'),
(34, 'No exercise', '65-74', 'Female', '43.5', '320.9'),
(35, 'No exercise', '75 +', 'Female', '61.2', '399.7'),
(36, 'Walking', '18-24', 'Female', '43.2', '425.0'),
(37, 'Walking', '25-34', 'Female', '49.0', '701.2'),
(38, 'Walking', '35-44', 'Female', '47.0', '725.5'),
(39, 'Walking', '45-54', 'Female', '50.0', '731.1'),
(40, 'Walking', '55-64', 'Female', '48.5', '567.9'),
(41, 'Walking', '65-74', 'Female', '46.7', '344.9'),
(42, 'Walking', '75 +', 'Female', '31.3', '204.4'),
(43, 'Moderate', '18-24', 'Female', '34.9', '343.4'),
(44, 'Moderate', '25-34', 'Female', '35.8', '512.1'),
(45, 'Moderate', '35-44', 'Female', '29.5', '455.4'),
(46, 'Moderate', '45-54', 'Female', '27.2', '397.6'),
(47, 'Moderate', '55-64', 'Female', '27.6', '323.5'),
(48, 'Moderate', '65-74', 'Female', '22.5', '166.2'),
(49, 'Moderate', '75 +', 'Female', '13.8', '89.9'),
(50, 'Vigorous', '18-24', 'Female', '16.7', '164.4'),
(51, 'Vigorous', '25-34', 'Female', '15.7', '224.0'),
(52, 'Vigorous', '35-44', 'Female', '11.0', '169.0'),
(53, 'Vigorous', '45-54', 'Female', '7.7', '112.5'),
(54, 'Vigorous', '55-64', 'Female', '6.1', '71.5'),
(55, 'Vigorous', '65-74', 'Female', '2.4', '17.5'),
(56, 'Vigorous', '75 +', 'Female', '0.5', '3.4');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
