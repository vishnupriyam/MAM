-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2014 at 04:12 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.19






SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mypasswordmanager`
--
CREATE DATABASE IF NOT EXISTS `mypasswordmanager` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `mypasswordmanager`;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `root` int(10) unsigned DEFAULT NULL,
  `lft` int(10) unsigned NOT NULL,
  `rgt` int(10) unsigned NOT NULL,
  `level` smallint(5) unsigned NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lft` (`lft`),
  KEY `rgt` (`rgt`),
  KEY `level` (`level`),
  KEY `root` (`root`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=111 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `root`, `lft`, `rgt`, `level`, `name`, `description`) VALUES
(90, 90, 1, 19, 1, 'IIT Bombay Summer Internship Groups', ''),
(91, 90, 2, 9, 2, 'Ekshiksha', ''),
(92, 90, 7, 8, 3, 'Assessment', ''),
(93, 90, 5, 6, 3, 'Question Managementss', ''),
(94, 90, 10, 13, 2, 'Aakash School Education', ''),
(95, 90, 11, 12, 3, 'Evaluation System', ''),
(96, 90, 13, 18, 2, 'Cdeep', ''),
(97, 96, 16, 17, 3, 'Media Asset Management', ''),
(98, 96, 14, 15, 3, 'Concepts Tutor', ''),
(99, 90, 3, 4, 3, 'Software Arena', '');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `unitCode` int(11) NOT NULL,
  `unitName` int(11) NOT NULL,
  `note` text,
  PRIMARY KEY (`unitCode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE IF NOT EXISTS `module` (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`mid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`mid`, `name`) VALUES
(1, 'USER_MODULE'),
(2, 'ASSETS');

-- --------------------------------------------------------

--
-- Table structure for table `organisation`
--

CREATE TABLE IF NOT EXISTS `organisation` (
  `orgName` text NOT NULL,
  `empNo` int(5) DEFAULT NULL,
  `phone` int(13) DEFAULT NULL,
  `email` varchar(26) DEFAULT NULL,
  `addr1` varchar(20) DEFAULT NULL,
  `addr2` varchar(20) DEFAULT NULL,
  `state` text,
  `country` text,
  `orgType` text,
  `note` varchar(150) DEFAULT NULL,
  `fax` int(10) DEFAULT NULL,
  `password` varchar(10) DEFAULT NULL,
  `orgId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`orgId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12346 ;

--
-- Dumping data for table `organisation`
--

INSERT INTO `organisation` (`orgName`, `empNo`, `phone`, `email`, `addr1`, `addr2`, `state`, `country`, `orgType`, `note`, `fax`, `password`, `orgId`) VALUES
('CDEEP ', 100, 909090909, 'cdeeep2@iitb.ac.in', 'iit powai', 'iit powai', 'Maharashtra', 'India', '1', 'dasdasdasdasdasdasd', NULL, 'dsd', 123),
('sdfjsdf', NULL, NULL, '', '', '', '', '', '0', '', NULL, '', 125),
('asassass', 12, 1212121212, 'aks@gmail.com', 'asasas', 'asasasas', 'asasasas', 'asasassas', '1', 'asasassasa', 123456, NULL, 12345);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(65) NOT NULL,
  `description` text NOT NULL,
  `module_mid` int(11) NOT NULL,
  PRIMARY KEY (`pid`),
  KEY `fk_permissions_module1_idx` (`module_mid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`pid`, `name`, `description`, `module_mid`) VALUES
(1, 'ADD USER', 'FOR ADDING A USER', 1),
(2, 'DELETE USER', 'DELETING USER', 1),
(3, 'MANAGE USER', 'MANAGING A USER', 1),
(4, 'MANAGE OWN', 'MANAGING YOUR OWN ..', 1),
(5, 'CHECK IN', 'FOR UPLOADING A DOCUMENTS,FILES,VIDEOS FOR REVIEW', 2),
(6, 'CHECK OUT', 'FOR DOWNLOADING PURPOSE ..', 2),
(7, 'REVIEW', 'WENT FOR REVIEWING ..', 2);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `rid` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `weight` mediumint(9) NOT NULL,
  PRIMARY KEY (`rid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`rid`, `name`, `weight`) VALUES
(1, 'admin', 0),
(2, 'editor', 1),
(3, 'reviewer', 2),
(4, 'author', 3);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `role_rid` bigint(20) NOT NULL,
  `permissions_pid` int(11) NOT NULL,
  PRIMARY KEY (`role_rid`,`permissions_pid`),
  KEY `fk_role_has_permissions_permissions1_idx` (`permissions_pid`),
  KEY `fk_role_has_permissions_role1_idx` (`role_rid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `password` text NOT NULL,
  `email` varchar(60) NOT NULL,
  `login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `logout` timestamp NULL DEFAULT NULL,
  `status` varchar(60) DEFAULT NULL,
  `picture` blob,
  `mobile` varchar(45) DEFAULT NULL,
  `quota` int(11) DEFAULT NULL,
  `DateCreated` datetime NOT NULL,
  `LastUpdate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `name`, `password`, `email`, `login`, `logout`, `status`, `picture`, `mobile`, `quota`, `DateCreated`, `LastUpdate`) VALUES
(1, 'ashish', '123', 'aks@gmail.com', '2014-05-26 11:11:39', '2014-05-26 11:11:39', NULL, NULL, NULL, NULL, '2014-05-26 16:41:39', NULL),
(2, 'ash', '123', 'aks1@gmail.com', '2012-03-13 18:30:00', '0000-00-00 00:00:00', '', '', '', NULL, '2012-01-14 00:00:00', '0000-00-00 00:00:00'),
(3, 'ash1', 'saEZ6MlWYV9nQ', 'aks2@gmail.com', '2012-03-13 18:30:00', '0000-00-00 00:00:00', '', '', '', NULL, '2012-01-14 00:00:00', '0000-00-00 00:00:00'),
(4, 'admin', 'sa1aY64JOY94w', 'ash2@gmail.com', '2012-03-13 18:30:00', '0000-00-00 00:00:00', '', '', '', NULL, '2012-01-14 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users_has_role`
--

CREATE TABLE IF NOT EXISTS `users_has_role` (
  `users_uid` int(11) NOT NULL,
  `role_rid` bigint(20) NOT NULL,
  PRIMARY KEY (`users_uid`,`role_rid`),
  KEY `fk_users_has_role_role1_idx` (`role_rid`),
  KEY `fk_users_has_role_users_idx` (`users_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_has_role`
--

INSERT INTO `users_has_role` (`users_uid`, `role_rid`) VALUES
(1, 2),
(1, 4);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `fk_permissions_module1` FOREIGN KEY (`module_mid`) REFERENCES `module` (`mid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `fk_role_has_permissions_role1` FOREIGN KEY (`role_rid`) REFERENCES `role` (`rid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_role_has_permissions_permissions1` FOREIGN KEY (`permissions_pid`) REFERENCES `permissions` (`pid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users_has_role`
--
ALTER TABLE `users_has_role`
  ADD CONSTRAINT `fk_users_has_role_users` FOREIGN KEY (`users_uid`) REFERENCES `users` (`uid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_has_role_role1` FOREIGN KEY (`role_rid`) REFERENCES `role` (`rid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
