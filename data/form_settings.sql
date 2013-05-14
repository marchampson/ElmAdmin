-- phpMyAdmin SQL Dump
-- version 3.5.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 14, 2013 at 07:59 PM
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
-- Table structure for table `forms`
--

DROP TABLE IF EXISTS `forms`;
CREATE TABLE IF NOT EXISTS `forms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin,
  `alias` varchar(100) COLLATE utf8_bin NOT NULL,
  `status` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=6 ;

--
-- Dumping data for table `forms`
--

INSERT INTO `forms` (`id`, `name`, `description`, `alias`, `status`) VALUES
(1, 'Webpage', '', 'ElmContent\\Form\\WebpageForm', 'Live'),
(2, 'News', '', 'ElmContent\\Form\\NewsForm', 'Live'),
(3, 'Events', '', 'ElmContent\\Form\\EventForm', 'Live'),
(4, 'Banners', '', 'ElmContent\\Form\\BannerForm', 'Live'),
(5, 'Categories', '', 'ElmContent\\Form\\CategoryForm', 'Live');

-- --------------------------------------------------------

--
-- Table structure for table `form_settings`
--

DROP TABLE IF EXISTS `form_settings`;
CREATE TABLE IF NOT EXISTS `form_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_id` int(11) NOT NULL,
  `field` varchar(100) COLLATE utf8_bin NOT NULL,
  `label` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `description` text COLLATE utf8_bin,
  `status` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=81 ;

--
-- Dumping data for table `form_settings`
--

INSERT INTO `form_settings` (`id`, `form_id`, `field`, `label`, `description`, `status`) VALUES
(1, 1, 'name', 'Page Name (Pretty url)', 'This will be used to created the pretty url please only use a-z 0-9', 'Live'),
(2, 1, 'headline', '', '', 'Live'),
(3, 1, 'status', '', '', 'Live'),
(4, 1, 'parent_id', '', '', 'Live'),
(5, 1, 'introduction', '', '', 'Live'),
(6, 1, 'description', '', '', 'Live'),
(7, 1, 'main_image_preview', '', '', 'Live'),
(8, 1, 'main_image', '', '', 'Draft'),
(9, 1, 'main_image_delete', '', '', 'Live'),
(10, 1, 'main_image_alt', '', '', 'Live'),
(11, 1, 'metaTitle', '', '', 'Live'),
(12, 1, 'metaDescription', '', '', 'Live'),
(13, 1, 'featured', '', '', 'Live'),
(14, 1, 'parent_featured', '', '', 'Live'),
(15, 1, 'featured_headline', '', '', 'Live'),
(16, 1, 'featured_description', '', '', 'Live'),
(17, 1, 'featured_image', '', '', 'Live'),
(18, 1, 'featured_image_preview', '', '', 'Live'),
(19, 1, 'featured_image_delete', '', '', 'Live'),
(20, 1, 'categorypicker', '', '', 'Live'),
(21, 3, 'name', '', '', 'Live'),
(22, 3, 'headline', '', '', 'Live'),
(23, 3, 'status', '', '', 'Live'),
(24, 3, 'parent_id', '', '', 'Live'),
(25, 3, 'introduction', '', '', 'Live'),
(26, 3, 'description', '', '', 'Live'),
(27, 3, 'main_image_preview', '', '', 'Live'),
(28, 3, 'main_image', '', '', 'Live'),
(29, 3, 'main_image_delete', '', '', 'Live'),
(30, 3, 'main_image_alt', '', '', 'Live'),
(31, 3, 'metaTitle', '', '', 'Live'),
(32, 3, 'metaDescription', '', '', 'Live'),
(33, 3, 'featured', '', '', 'Live'),
(34, 3, 'parent_featured', '', '', 'Live'),
(35, 3, 'featured_headline', '', '', 'Live'),
(36, 3, 'featured_description', '', '', 'Live'),
(37, 3, 'featured_image', '', '', 'Live'),
(38, 3, 'featured_image_preview', '', '', 'Live'),
(39, 3, 'featured_image_delete', '', '', 'Live'),
(40, 3, 'categorypicker', '', '', 'Live'),
(41, 4, 'name', '', '', 'Live'),
(42, 4, 'headline', '', '', 'Live'),
(43, 4, 'status', '', '', 'Live'),
(44, 4, 'parent_id', '', '', 'Live'),
(45, 4, 'introduction', '', '', 'Live'),
(46, 4, 'description', '', '', 'Live'),
(47, 4, 'main_image_preview', '', '', 'Live'),
(48, 4, 'main_image', '', '', 'Live'),
(49, 4, 'main_image_delete', '', '', 'Live'),
(50, 4, 'main_image_alt', '', '', 'Live'),
(51, 4, 'metaTitle', '', '', 'Live'),
(52, 4, 'metaDescription', '', '', 'Live'),
(53, 4, 'featured', '', '', 'Live'),
(54, 4, 'parent_featured', '', '', 'Live'),
(55, 4, 'featured_headline', '', '', 'Live'),
(56, 4, 'featured_description', '', '', 'Live'),
(57, 4, 'featured_image', '', '', 'Live'),
(58, 4, 'featured_image_preview', '', '', 'Live'),
(59, 4, 'featured_image_delete', '', '', 'Live'),
(60, 4, 'categorypicker', '', '', 'Live'),
(61, 5, 'name', '', '', 'Live'),
(62, 5, 'headline', '', '', 'Live'),
(63, 5, 'status', '', '', 'Live'),
(64, 5, 'parent_id', '', '', 'Live'),
(65, 5, 'introduction', '', '', 'Live'),
(66, 5, 'description', '', '', 'Live'),
(67, 5, 'main_image_preview', '', '', 'Live'),
(68, 5, 'main_image', '', '', 'Live'),
(69, 5, 'main_image_delete', '', '', 'Live'),
(70, 5, 'main_image_alt', '', '', 'Live'),
(71, 5, 'metaTitle', '', '', 'Live'),
(72, 5, 'metaDescription', '', '', 'Live'),
(73, 5, 'featured', '', '', 'Live'),
(74, 5, 'parent_featured', '', '', 'Live'),
(75, 5, 'featured_headline', '', '', 'Live'),
(76, 5, 'featured_description', '', '', 'Live'),
(77, 5, 'featured_image', '', '', 'Live'),
(78, 5, 'featured_image_preview', '', '', 'Live'),
(79, 5, 'featured_image_delete', '', '', 'Live'),
(80, 5, 'categorypicker', '', '', 'Live');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
