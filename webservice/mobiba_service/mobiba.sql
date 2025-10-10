-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 04, 2013 at 08:53 AM
-- Server version: 5.5.24-0ubuntu0.12.04.1
-- PHP Version: 5.3.10-1ubuntu3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mobiba`
--

-- --------------------------------------------------------

--
-- Table structure for table `deposit`
--

CREATE TABLE IF NOT EXISTS `deposit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `remarks` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `deposit`
--

INSERT INTO `deposit` (`id`, `users_id`, `amount`, `created_at`, `remarks`) VALUES
(1, 12, 3000, '2012-12-27 16:21:26', NULL),
(2, 13, 3000, '2012-12-27 17:10:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transfer_from`
--

CREATE TABLE IF NOT EXISTS `transfer_from` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id` int(11) NOT NULL,
  `account_no` bigint(20) NOT NULL,
  `amount` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `remarks` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `transfer_from`
--

INSERT INTO `transfer_from` (`id`, `users_id`, `account_no`, `amount`, `created_at`, `remarks`) VALUES
(1, 13, 1000000, 200, '2012-12-27 17:12:12', NULL),
(2, 13, 1000000, 300, '2012-12-27 18:45:02', NULL),
(3, 13, 1000000, 300, '2012-12-27 18:46:42', NULL),
(4, 13, 1000000, 300, '2012-12-27 18:47:06', NULL),
(5, 13, 1000000, 300, '2012-12-27 18:47:24', NULL),
(6, 12, 123456, 2323, '2012-12-29 16:40:26', NULL),
(7, 12, 12345678, 12, '2012-12-30 02:56:06', NULL),
(8, 12, 12345678, 200, '2012-12-30 03:00:40', NULL),
(9, 12, 12345678, 200, '2012-12-30 03:02:14', NULL),
(10, 12, 12345678, 200, '2012-12-30 03:02:35', NULL),
(11, 12, 12345678, 200, '2012-12-30 03:02:43', NULL),
(12, 12, 12345678, 200, '2012-12-30 03:02:45', NULL),
(13, 12, 12345678, 200, '2012-12-30 03:02:47', NULL),
(14, 12, 12345678, 20.12, '2012-12-30 03:03:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transfer_to`
--

CREATE TABLE IF NOT EXISTS `transfer_to` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id` int(11) NOT NULL,
  `account_no` bigint(20) NOT NULL,
  `amount` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `remarks` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `transfer_to`
--

INSERT INTO `transfer_to` (`id`, `users_id`, `account_no`, `amount`, `created_at`, `remarks`) VALUES
(1, 12, 1000001, 200, '2012-12-27 17:12:12', NULL),
(2, 12, 1000001, 300, '2012-12-27 18:45:02', NULL),
(3, 12, 1000001, 300, '2012-12-27 18:46:42', NULL),
(4, 12, 1000001, 300, '2012-12-27 18:47:06', NULL),
(5, 12, 1000001, 300, '2012-12-27 18:47:24', NULL),
(6, 0, 1000000, 2323, '2012-12-29 16:40:26', NULL),
(7, 13, 1000000, 12, '2012-12-30 02:56:06', NULL),
(8, 13, 1000000, 200, '2012-12-30 03:00:40', NULL),
(9, 13, 1000000, 200, '2012-12-30 03:02:14', NULL),
(10, 13, 1000000, 200, '2012-12-30 03:02:35', NULL),
(11, 13, 1000000, 200, '2012-12-30 03:02:43', NULL),
(12, 13, 1000000, 200, '2012-12-30 03:02:45', NULL),
(13, 13, 1000000, 200, '2012-12-30 03:02:47', NULL),
(14, 13, 1000000, 20.12, '2012-12-30 03:03:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(30) NOT NULL,
  `password` varchar(60) NOT NULL,
  `account_no` bigint(20) NOT NULL,
  `balance` double NOT NULL,
  `fname` varchar(50) DEFAULT NULL,
  `lname` varchar(50) DEFAULT NULL,
  `remarks` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`email`,`account_no`),
  UNIQUE KEY `account_no` (`account_no`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `account_no`, `balance`, `fname`, `lname`, `remarks`, `created_at`) VALUES
(12, 'abc@abc.com', 'password', 1000000, 844.88, 'dip3ak', 'pokeharel', NULL, '2012-12-27 16:21:26'),
(13, 'ram32@abc.com', 'password', 12345678, 2832.12, 'dip3ak', 'pokeharel', NULL, '2012-12-27 17:10:19');

-- --------------------------------------------------------

--
-- Table structure for table `withdraw`
--

CREATE TABLE IF NOT EXISTS `withdraw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `remarks` text,
  PRIMARY KEY (`id`),
  KEY `users_id` (`users_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
