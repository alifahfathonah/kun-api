-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 26, 2020 at 03:43 PM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kun-database`
--

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

DROP TABLE IF EXISTS `classes`;
CREATE TABLE IF NOT EXISTS `classes` (
  `class_id` int(30) NOT NULL AUTO_INCREMENT,
  `class_code` varchar(20) NOT NULL,
  `class_name` varchar(150) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `maximum_students` int(2) NOT NULL,
  `add_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `status` enum('open','close') NOT NULL DEFAULT 'open',
  PRIMARY KEY (`class_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`class_id`, `class_code`, `class_name`, `description`, `maximum_students`, `add_date`, `update_date`, `status`) VALUES
(1, 'ABCDEF', 'First Standard', 'This is first standard class', 10, '2020-11-26 14:25:49', '2020-11-26 14:26:42', 'open'),
(2, 'BCD', 'Second Standard', 'This is second standard class', 2, '2020-11-26 14:47:39', '2020-11-26 14:48:44', 'open'),
(3, 'BCD', 'Second Standard', 'This is second standard class', 10, '2020-11-26 15:25:56', '2020-11-26 15:25:56', 'open'),
(4, 'BCD1', '', 'This is second standard class', 10, '2020-11-26 15:29:17', '2020-11-26 15:29:17', 'open'),
(5, '', '', 'This is second standard class', 10, '2020-11-26 15:31:54', '2020-11-26 15:31:54', 'open'),
(6, 'DEF', 'TEST', 'This is second standard class', 10, '2020-11-26 15:40:30', '2020-11-26 15:40:30', 'open');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE IF NOT EXISTS `students` (
  `student_id` int(20) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(150) CHARACTER SET utf8 NOT NULL,
  `last_name` varchar(150) CHARACTER SET utf8 NOT NULL,
  `class_code` varchar(20) NOT NULL,
  `date_of_birth` date NOT NULL,
  `add_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  PRIMARY KEY (`student_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `first_name`, `last_name`, `class_code`, `date_of_birth`, `add_date`, `update_date`) VALUES
(1, 'Mo.', 'Aslam', 'BCD', '1985-01-05', '2020-11-26 15:07:43', '2020-11-26 15:07:43'),
(2, 'Mohd.', 'Arif', 'BCD', '1990-01-05', '2020-11-26 15:08:43', '2020-11-26 15:08:43');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
