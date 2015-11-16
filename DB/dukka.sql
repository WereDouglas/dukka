-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 16, 2015 at 04:58 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dukka`
--

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE IF NOT EXISTS `location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `distance` varchar(50) NOT NULL,
  `lat` varchar(50) NOT NULL,
  `lng` varchar(50) NOT NULL,
  `created` varchar(50) NOT NULL,
  `session` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=58 ;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `username`, `distance`, `lat`, `lng`, `created`, `session`) VALUES
(2, 'Douglas', '0', '0.3419005', '32.594444', '2015-11-16 15:03:54', NULL),
(3, 'Douglas', '27', '0.3418042', '32.5942181', '2015-11-16 15:07:48', NULL),
(4, 'Douglas', '27', '0.3418042', '32.5942181', '2015-11-16 15:07:48', NULL),
(5, 'Douglas', '26', '0.3419486', '32.5944019', '2015-11-16 15:07:48', NULL),
(6, 'Douglas', '33', '0.3416716', '32.5942859', '2015-11-16 15:08:11', NULL),
(7, 'Douglas', '218', '0.3433701', '32.5952708', '2015-11-16 15:11:46', NULL),
(8, 'Douglas', '195', '0.3418617', '32.5943604', '2015-11-16 15:18:54', NULL),
(9, 'Douglas', '24', '0.3416654', '32.594269', '2015-11-16 17:06:50', NULL),
(10, 'Douglas', '25', '0.3418698', '32.5943747', '2015-11-16 17:07:04', NULL),
(11, 'Douglas', '25', '0.3418698', '32.5943747', '2015-11-16 17:07:05', NULL),
(12, 'Douglas', '25', '0.3416741', '32.594262', '2015-11-16 17:08:29', NULL),
(13, 'Douglas', '23', '0.3418453', '32.5943808', '2015-11-16 17:09:12', NULL),
(14, 'Douglas', '24', '0.3416557', '32.5942658', '2015-11-16 17:09:54', NULL),
(15, 'Douglas', '23', '0.3418368', '32.5943744', '2015-11-16 17:10:07', NULL),
(16, 'Douglas', '23', '0.3418368', '32.5943744', '2015-11-16 17:10:07', NULL),
(17, 'Douglas', '21', '0.3416976', '32.5942389', '2015-11-16 17:10:42', NULL),
(18, 'Douglas', '28', '0.3418859', '32.5944158', '2015-11-16 17:10:52', NULL),
(19, 'Douglas', '26', '0.3416892', '32.5942818', '2015-11-16 17:12:04', NULL),
(20, 'Douglas', '22', '0.3418505', '32.5943961', '2015-11-16 17:12:15', NULL),
(21, 'Douglas', '25', '0.341652', '32.5942768', '2015-11-16 17:12:36', NULL),
(22, 'Douglas', '27', '0.3418621', '32.5944085', '2015-11-16 17:12:47', NULL),
(23, 'Douglas', '30', '0.3416534', '32.5942293', '2015-11-16 17:15:19', NULL),
(24, 'Douglas', '29', '0.3418531', '32.5943977', '2015-11-16 17:15:27', NULL),
(25, 'Douglas', '29', '0.3418531', '32.5943977', '2015-11-16 17:15:27', NULL),
(26, 'Douglas', '27', '0.3416409', '32.5942687', '2015-11-16 17:15:58', NULL),
(27, 'Douglas', '27', '0.3416409', '32.5942687', '2015-11-16 17:15:58', NULL),
(28, 'Douglas', '25', '0.3418372', '32.594381', '2015-11-16 17:16:03', NULL),
(29, 'Douglas', '27', '0.3416394', '32.5942409', '2015-11-16 17:19:17', NULL),
(30, 'Douglas', '27', '0.3416394', '32.5942409', '2015-11-16 17:19:17', NULL),
(31, 'Douglas', '24', '0.3418256', '32.5943538', '2015-11-16 17:19:23', NULL),
(32, 'Douglas', '24', '0.3418256', '32.5943538', '2015-11-16 17:19:23', NULL),
(33, 'Douglas', '27', '0.3416187', '32.5942209', '2015-11-16 17:20:19', NULL),
(34, 'Douglas', '27', '0.3416187', '32.5942209', '2015-11-16 17:20:19', NULL),
(35, 'Douglas', '31', '0.341864', '32.5943639', '2015-11-16 17:20:24', NULL),
(36, 'Douglas', '31', '0.341864', '32.5943639', '2015-11-16 17:20:24', NULL),
(37, 'Douglas', '25', '0.3416818', '32.5942318', '2015-11-16 17:20:40', NULL),
(38, 'Douglas', '25', '0.3418638', '32.5943725', '2015-11-16 17:20:59', NULL),
(39, 'Douglas', '21', '0.3417225', '32.5942448', '2015-11-16 17:21:05', NULL),
(40, 'Douglas', '21', '0.3417225', '32.5942448', '2015-11-16 17:21:05', NULL),
(41, 'Douglas', '24', '0.3418803', '32.5943916', '2015-11-16 17:21:15', NULL),
(42, 'Douglas', '24', '0.3418803', '32.5943916', '2015-11-16 17:21:15', NULL),
(43, 'Douglas', '21', '0.3417139', '32.5942894', '2015-11-16 17:21:35', NULL),
(44, 'Douglas', '21', '0.3417139', '32.5942894', '2015-11-16 17:21:35', NULL),
(45, 'Douglas', '25', '0.3418951', '32.5944227', '2015-11-16 17:21:45', NULL),
(46, 'Douglas', '25', '0.3418951', '32.5944227', '2015-11-16 17:21:45', NULL),
(47, 'Douglas', '22', '0.3417526', '32.5942823', '2015-11-16 17:22:46', NULL),
(48, 'Douglas', '22', '0.3417526', '32.5942823', '2015-11-16 17:22:46', NULL),
(49, 'Douglas', '21', '0.341906', '32.5944012', '2015-11-16 17:37:24', NULL),
(50, 'Douglas', '28', '0.3416793', '32.5942814', '2015-11-16 17:41:43', NULL),
(51, 'Douglas', '24', '0.3418646', '32.5944007', '2015-11-16 17:42:03', NULL),
(52, 'Douglas', '24', '0.3416757', '32.5942843', '2015-11-16 17:42:55', NULL),
(53, 'Douglas', '23', '0.3418514', '32.5943984', '2015-11-16 17:43:06', NULL),
(54, 'Douglas', '26', '0.3416434', '32.5942762', '2015-11-16 17:46:12', NULL),
(55, 'Douglas', '26', '0.3418682', '32.5943666', '2015-11-16 17:46:22', NULL),
(56, 'Douglas', '22', '0.341677', '32.5942934', '2015-11-16 17:54:09', NULL),
(57, 'Douglas', '34', '0.3419013', '32.5945008', '2015-11-16 18:32:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `image`, `created`) VALUES
(1, 'Douglas', 'xCc3kmS3dRZTcM9K/F2fqnqGWqugJWSUaT2mcZHZL9MD4L/CE5AzxgUWiCOvbL2nDHrAye+b5PQ9svLcOqZKxw==', NULL, '2015-11-16');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
