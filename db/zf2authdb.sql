-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2013 at 12:35 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `asterisk`
--

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

DROP TABLE IF EXISTS `profiles`;
CREATE TABLE IF NOT EXISTS `profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `customer_id` int(10) unsigned DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `user_id`, `first_name`, `last_name`, `customer_id`, `created`, `modified`) VALUES
(1, 1, 'Tahmina', 'Khatoon', NULL, '2013-11-29 06:02:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

DROP TABLE IF EXISTS `resources`;
CREATE TABLE IF NOT EXISTS `resources` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=61 ;

--
-- Dumping data for table `resources`
--

INSERT INTO `resources` (`id`, `name`) VALUES
(22, 'application'),
(23, 'application/default'),
(27, 'ast_cdr'),
(49, 'customers'),
(52, 'customers/add'),
(54, 'customers/delete'),
(53, 'customers/edit'),
(51, 'customers/index'),
(50, 'customers/search'),
(1, 'home'),
(26, 'number'),
(29, 'profiles'),
(39, 'profiles/add'),
(42, 'profiles/delete'),
(40, 'profiles/edit'),
(38, 'profiles/index'),
(37, 'profiles/search'),
(41, 'profiles/view'),
(25, 'prompt'),
(24, 'queue'),
(30, 'resources'),
(57, 'resources/add'),
(59, 'resources/delete'),
(58, 'resources/edit'),
(56, 'resources/index'),
(60, 'resources/refreshResources'),
(55, 'resources/search'),
(11, 'roles'),
(45, 'roles/add'),
(48, 'roles/delete'),
(46, 'roles/edit'),
(44, 'roles/index'),
(43, 'roles/search'),
(47, 'roles/view'),
(31, 'role_resources'),
(33, 'users'),
(4, 'users/add'),
(9, 'users/authenticate'),
(36, 'users/change-password'),
(21, 'users/confirmEmail'),
(6, 'users/delete'),
(5, 'users/edit'),
(34, 'users/forget-password'),
(3, 'users/index'),
(7, 'users/login'),
(8, 'users/logout'),
(10, 'users/registration'),
(35, 'users/reset-password'),
(2, 'users/search'),
(32, 'user_roles'),
(28, 'zf2auth');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'Administrator'),
(2, 'Customer'),
(3, 'Guest');

-- --------------------------------------------------------

--
-- Table structure for table `role_resources`
--

DROP TABLE IF EXISTS `role_resources`;
CREATE TABLE IF NOT EXISTS `role_resources` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `resource_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_resource` (`role_id`,`resource_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `role_resources`
--

INSERT INTO `role_resources` (`id`, `role_id`, `resource_id`) VALUES
(1, 1, 1),
(21, 1, 2),
(17, 1, 3),
(12, 1, 4),
(16, 1, 5),
(15, 1, 6),
(18, 1, 7),
(19, 1, 8),
(13, 1, 9),
(20, 1, 10),
(11, 1, 11),
(10, 1, 12),
(7, 1, 13),
(9, 1, 14),
(8, 1, 15),
(6, 1, 16),
(5, 1, 17),
(2, 1, 18),
(4, 1, 19),
(3, 1, 20),
(14, 1, 21),
(27, 1, 22),
(29, 1, 41),
(22, 3, 1),
(23, 3, 7),
(24, 3, 8),
(25, 3, 9),
(26, 3, 10),
(28, 3, 22);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `email_check_code` varchar(256) DEFAULT NULL,
  `is_disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `email_check_code`, `is_disabled`, `created`, `modified`) VALUES
(1, 'admin', 'admin@oskall.com', 'e10adc3949ba59abbe56e057f20f883e', '123456', 0, '2013-01-01 00:00:00', '2013-01-01 00:00:00'),
(2, 'tahmina8765', 'tahmina8765@yahoo.com', 'e10adc3949ba59abbe56e057f20f883e', '123456', 0, '2013-01-01 00:00:00', '2013-01-01 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

DROP TABLE IF EXISTS `user_roles`;
CREATE TABLE IF NOT EXISTS `user_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_role` (`user_id`,`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `user_id`, `role_id`) VALUES
(1, 1, 1);
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
