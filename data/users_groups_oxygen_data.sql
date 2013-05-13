-- phpMyAdmin SQL Dump
-- version 3.5.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 13, 2013 at 04:12 PM
-- Server version: 5.6.10
-- PHP Version: 5.4.12

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `e3-unity_local`
--

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `address1` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `address2` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `town` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `county` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `postcode` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `country` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=6 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `type`, `name`, `address1`, `address2`, `town`, `county`, `postcode`, `country`) VALUES
(5, 'company', 'Oxygen', '12a Churchyard', NULL, 'Hitchin', 'Herts', 'SG5 1HR', 'UK');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT NULL,
  `password` varchar(250) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `role` varchar(25) NOT NULL DEFAULT 'user',
  `phone` varchar(100) DEFAULT NULL,
  `extension` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `group_id`, `password`, `first_name`, `last_name`, `email`, `role`, `phone`, `extension`) VALUES
(21, 5, '0fe2a1ffdaa9d9d99b9dfa23c2001db8', 'Marc', 'Hampson', 'marc.hampson@oxygenate.net', 'hal9000', '01462 636800', NULL),
(22, 5, '0fe2a1ffdaa9d9d99b9dfa23c2001db8', 'Joel', 'Ide', 'joel.ide@oxygenate.net', 'hal9000', '01462 636800', NULL),
(23, 5, '0fe2a1ffdaa9d9d99b9dfa23c2001db8', 'Geoff', 'Ide', 'geoff.ide@oxygenate.net', 'Admin', '01462 636800', NULL),
(24, 5, '0fe2a1ffdaa9d9d99b9dfa23c2001db8', 'Marcia', 'Smith', 'marcia.smith@oxygenate.net', 'hal9000', '01462 636800', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
