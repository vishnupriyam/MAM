-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2014 at 07:42 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `final_28`
--

-- --------------------------------------------------------

--
-- Table structure for table `basic_permissions`
--

CREATE TABLE IF NOT EXISTS `basic_permissions` (
  `id` int(11) NOT NULL,
  `vpermission` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `basic_permissions`
--

INSERT INTO `basic_permissions` (`id`, `vpermission`) VALUES
(1, 'create'),
(2, 'read'),
(3, 'update'),
(4, 'delete');

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

-- --------------------------------------------------------

--
-- Table structure for table `category1`
--

CREATE TABLE IF NOT EXISTS `category1` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) NOT NULL,
  `orgId` int(11) NOT NULL,
  `unitCode` int(11) NOT NULL,
  `orgName` varchar(45) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `category1`
--

INSERT INTO `category1` (`cat_id`, `Name`, `orgId`, `unitCode`, `orgName`) VALUES
(38, 'abc', 512, 33, ''),
(39, 'def', 512, 35, ''),
(40, 'fed', 512, 33, '');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `unitCode` int(11) NOT NULL,
  `unitName` text NOT NULL,
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
  `description` varchar(100) DEFAULT NULL,
  `orgId` int(11) NOT NULL,
  PRIMARY KEY (`mid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`mid`, `name`, `description`, `orgId`) VALUES
(1, 'Online viewer', 'for adding assets', 510),
(10, 'Online Editor', 'For adding assets', 510),
(11, 'Streaming', 'Downloading requests enabled', 510),
(12, 'Asset', 'Uploading requests enabled', 510),
(14, 'Add asset', 'For adding assets', 511),
(15, 'Check in', 'Downloading requests enabled', 511),
(16, 'Check out', 'Uploading requests enabled', 511),
(17, 'Admin', 'CRUD for user, role, module, tag, category, permission', 511),
(18, 'Add asset', 'For adding assets', 512),
(19, 'Check in', 'Downloading requests enabled', 512),
(20, 'Check out', 'Uploading requests enabled', 512),
(21, 'Admin', 'CRUD for user, role, module, tag, category, permission', 512),
(22, 'Add asset', 'For adding assets', 513),
(23, 'Check in', 'Downloading requests enabled', 513),
(24, 'Check out', 'Uploading requests enabled', 513),
(25, 'Admin', 'CRUD for user, role, module, tag, category, permission', 513),
(26, 'Add asset', 'For adding assets', 514),
(27, 'Check in', 'Downloading requests enabled', 514),
(28, 'Check out', 'Uploading requests enabled', 514),
(29, 'Admin', 'CRUD for user, role, module, tag, category, permission', 514),
(30, 'Add asset', 'For adding assets', 515),
(31, 'Check in', 'Downloading requests enabled', 515),
(32, 'Check out', 'Uploading requests enabled', 515),
(33, 'Admin', 'CRUD for user, role, module, tag, category, permission', 515),
(34, 'Add asset', 'For adding assets', 516),
(35, 'Check in', 'Downloading requests enabled', 516),
(36, 'Check out', 'Uploading requests enabled', 516),
(37, 'Admin', 'CRUD for user, role, module, tag, category, permission', 516);

-- --------------------------------------------------------

--
-- Table structure for table `mod_data`
--

CREATE TABLE IF NOT EXISTS `mod_data` (
  `mod_id` int(11) NOT NULL AUTO_INCREMENT,
  `mod_name` varchar(100) NOT NULL,
  `mod_desc` varchar(100) NOT NULL,
  PRIMARY KEY (`mod_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `mod_data`
--

INSERT INTO `mod_data` (`mod_id`, `mod_name`, `mod_desc`) VALUES
(1, 'online viewer', ''),
(2, 'online editor', ''),
(3, 'Streaming', ''),
(4, 'Assets', ''),
(5, 'file upload', '');

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
  `valid` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`orgId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=517 ;

--
-- Dumping data for table `organisation`
--

INSERT INTO `organisation` (`orgName`, `empNo`, `phone`, `email`, `addr1`, `addr2`, `state`, `country`, `orgType`, `note`, `fax`, `password`, `orgId`, `valid`) VALUES
('us', 0, 0, '0', '0', '0', '0', '0', '0', '0', 0, 'saIam1KByh', 500, 1),
('org1', 5, 2147483647, 'ucchiruchi@gmail.com', '189 manas nagar new ', 'agra', 'Uttar Pradesh', 'India', '0', '123', 123, NULL, 501, 1),
('org2', 5, 2147483647, 'ucchiruchi@gmail.com', '189 manas nagar new ', 'agra', 'Uttar Pradesh', 'India', '0', '123', 123, NULL, 502, 1),
('rakhi org', 5, 5, 'r@g.c', '189 manas nagar new ', 'agra', 'Uttar Pradesh', 'India', '0', '123', 123, NULL, 503, 1),
('mansi', 5, 2147483647, 'ucchiruchi@gmail.com', '189 manas nagar new ', 'agra', 'Uttar Pradesh', 'India', '0', '', NULL, NULL, 504, 1),
('banani', 5, 2147483647, 'ucchiruchi@gmail.com', '189 manas nagar new ', 'agra', 'Uttar Pradesh', 'India', '0', '123', 123, NULL, 505, 1),
('banani', 5, 2147483647, 'ucchiruchi@gmail.com', '189 manas nagar new ', 'agra', 'Uttar Pradesh', 'India', '0', '123', 123, NULL, 506, 1),
('banani', 5, 2147483647, 'ucchiruchi@gmail.com', '189 manas nagar new ', 'agra', 'Uttar Pradesh', 'India', '0', '123', 123, NULL, 507, 1),
('yogesh gupta', 5, 2147483647, 'ucchiruchi@gmail.com', '189 manas nagar new ', 'agra', 'Uttar Pradesh', 'India', '0', '123', 123, NULL, 508, 1),
('yogesh', 5, 2147483647, 'ucchiruchi@gmail.com', '189 manas nagar new ', 'agra', 'Uttar Pradesh', 'India', '0', '123', 123, NULL, 509, 1),
('didi', 5, 2147483647, 'ucchiruchi@gmail.com', '189 manas nagar new ', 'agra', 'Uttar Pradesh', 'India', '0', '123', 123, NULL, 510, 1),
('IIT Bombay', 5, 2147483647, 'ucchiruchi@gmail.com', '189 manas nagar new ', '', 'Uttar Pradesh', 'India', '0', '123', 123, NULL, 511, 1),
('testcase', 5, 2147483647, 'ucchiruchi@gmail.com', '189 manas nagar new ', '', 'Uttar Pradesh', 'India', '0', '', NULL, NULL, 512, 1),
('ashish', 5, 2147483647, 'ucchiruchi@gmail.com', '189 manas nagar new ', '', 'Uttar Pradesh', 'India', '0', 'qq', 123, NULL, 513, 1),
('newww', 5, 2147483647, 'ucchiruchi@gmail.com', '189 manas nagar new ', '', 'Uttar Pradesh', 'India', '0', '', NULL, NULL, 514, 1),
('aaq', 5, 2147483647, 'ucchiruchi@gmail.com', '189 manas nagar new ', '', 'Uttar Pradesh', 'India', '0', 'aaq', NULL, NULL, 515, 1),
('bvbjh', NULL, NULL, '', '', '', '', '', '0', '', NULL, NULL, 516, 1);

-- --------------------------------------------------------

--
-- Table structure for table `org_ou`
--

CREATE TABLE IF NOT EXISTS `org_ou` (
  `orgId` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `org_ou`
--

INSERT INTO `org_ou` (`orgId`, `id`) VALUES
(500, 1),
(501, 5),
(502, 8),
(503, 11),
(504, 14),
(505, 17),
(505, 18),
(505, 19),
(508, 20),
(509, 21),
(510, 22),
(511, 31),
(512, 33),
(513, 36),
(514, 39),
(515, 40),
(516, 41);

-- --------------------------------------------------------

--
-- Table structure for table `ou_structure`
--

CREATE TABLE IF NOT EXISTS `ou_structure` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;

--
-- Dumping data for table `ou_structure`
--

INSERT INTO `ou_structure` (`id`, `root`, `lft`, `rgt`, `level`, `name`, `description`) VALUES
(1, 1, 1, 8, 1, 'us', 'us'),
(2, 1, 2, 3, 2, 'us1', 'abc'),
(3, 1, 4, 7, 2, 'us2', 'us2'),
(4, 1, 5, 6, 3, 'us3', 'us3'),
(5, 5, 1, 6, 1, 'org1', 'hello'),
(6, 5, 2, 3, 2, 'org1 dept 1', ''),
(7, 5, 4, 5, 2, 'org1 dept 2', ''),
(8, 8, 1, 6, 1, 'org2', 'hello'),
(9, 8, 2, 3, 2, 'org2 dept1', ''),
(10, 8, 4, 5, 2, 'org2 dept 2', ''),
(11, 11, 1, 6, 1, 'rakhi org', 'hello'),
(12, 11, 2, 3, 2, 'rakhi org dept 1', ''),
(13, 11, 4, 5, 2, 'rakhi org dept 2', ''),
(14, 14, 1, 6, 1, 'mansi', 'hello'),
(15, 14, 2, 3, 2, 'mansi dept 1', ''),
(16, 14, 4, 5, 2, 'mansi dept 2', ''),
(17, 17, 1, 2, 1, 'banani', 'hello'),
(18, 18, 1, 2, 1, 'banani', 'hello'),
(19, 19, 1, 2, 1, 'banani', 'hello'),
(20, 20, 1, 2, 1, 'yogesh gupta', 'hello'),
(21, 21, 1, 2, 1, 'yogesh', 'hello'),
(22, 22, 1, 10, 1, 'didi', 'hello'),
(23, 22, 2, 7, 2, 'didi1', '123'),
(24, 22, 8, 9, 2, 'didi2', '123'),
(26, 22, 3, 4, 3, 'didi1_2', ''),
(32, 31, 2, 3, 2, 'iitb dept 1', 'this is dept 1'),
(31, 31, 1, 4, 1, 'IIT Bombay', 'hello'),
(30, 22, 5, 6, 3, 'hgg', ''),
(33, 33, 1, 14, 1, 'testcase', 'hello'),
(34, 33, 2, 9, 2, 'testcase1', ''),
(35, 33, 10, 13, 2, 'testcase2', ''),
(36, 36, 1, 6, 1, 'ashish', 'hello'),
(37, 36, 2, 3, 2, 'ashish1', ''),
(38, 36, 4, 5, 2, 'ashish2', ''),
(39, 39, 1, 2, 1, 'newww', 'hello'),
(40, 40, 1, 2, 1, 'aaq', 'hello'),
(41, 41, 1, 2, 1, 'bvbjh', 'hello'),
(42, 33, 3, 4, 3, 'zsv', 'dfgdg'),
(43, 33, 5, 6, 3, 'fgh', 'ddgdgfg'),
(44, 33, 11, 12, 3, 'fghery', 'etrert'),
(45, 33, 7, 8, 3, 'fghi', 'dgffffggf');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(65) NOT NULL,
  `description` text NOT NULL,
  `module_mid` int(11) NOT NULL,
  `role_rid` int(11) NOT NULL,
  PRIMARY KEY (`pid`),
  KEY `fk_permissions_module1_idx` (`module_mid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`pid`, `name`, `description`, `module_mid`, `role_rid`) VALUES
(2, 'read', '', 1, 0),
(3, 'update', '', 1, 0),
(4, 'delete', '', 1, 0),
(5, 'create', '123', 16, 24),
(6, 'create', '', 14, 24),
(7, 'create', '', 15, 24),
(8, 'create', '123', 15, 24),
(9, 'create', '', 15, 23),
(10, 'create', '', 15, 23),
(11, 'create', '', 15, 24),
(12, 'create', '', 15, 24),
(13, 'create', '', 15, 24),
(14, 'create', '', 16, 23),
(15, 'create', '', 15, 24),
(16, 'create', '', 15, 24),
(17, 'create', '123', 19, 26),
(18, 'create', '123', 23, 27);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `rid` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `weight` mediumint(9) NOT NULL,
  `orgId` int(11) NOT NULL,
  PRIMARY KEY (`rid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`rid`, `name`, `weight`, `orgId`) VALUES
(16, 'oldrole', 1, 503),
(17, 'my role 1', 1, 503),
(18, 'role1', 1, 504),
(19, 'role2', 2, 504),
(20, 'new role', 2, 504),
(21, 'didi role', 1, 510),
(22, 'bhaiya role1', 1, 510),
(23, 'role1', 1, 511),
(24, 'role2', 2, 511),
(25, 'testcase role1', 1, 512),
(26, 'testcase role2', 2, 512),
(27, 'role 1', 1, 513),
(28, 'role3', 3, 512);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `role_rid` bigint(20) NOT NULL,
  `permissions_pid` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  PRIMARY KEY (`role_rid`,`permissions_pid`),
  KEY `fk_role_has_permissions_permissions1_idx` (`permissions_pid`),
  KEY `fk_role_has_permissions_role1_idx` (`role_rid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`role_rid`, `permissions_pid`, `mid`) VALUES
(23, 14, 16),
(24, 2, 16),
(24, 5, 15),
(24, 11, 15),
(24, 12, 15),
(24, 13, 15),
(24, 15, 15),
(24, 16, 15),
(26, 17, 19),
(27, 18, 23);

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE IF NOT EXISTS `session` (
  `id` char(32) NOT NULL,
  `expire` int(11) NOT NULL,
  `data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `tagId` int(11) NOT NULL AUTO_INCREMENT,
  `tagName` varchar(45) NOT NULL,
  `orgId` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  PRIMARY KEY (`tagId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tagId`, `tagName`, `orgId`, `dept_id`) VALUES
(1, 'civil', 503, 13),
(2, 'cse', 503, 13),
(3, 'new tag', 503, 13),
(4, 'new tag org2', 503, 13),
(5, 'rakhi org', 503, 13),
(6, 'rakhi org', 503, 13),
(7, 'neeeee', 503, 13),
(8, 'dsfsdd', 503, 13),
(9, 'sss', 503, 13),
(10, 'gfg', 503, 11),
(11, 'aaa', 503, 11),
(12, 'new tag', 503, 0),
(13, 'new tag2', 503, 0),
(14, 'dd', 503, 0),
(15, 'create it', 503, 0),
(16, 'creating', 503, 0),
(17, 'sss', 503, 0),
(18, 'newwww', 503, 0),
(19, 'hi hello', 503, 0),
(20, 'new tagsss', 503, 12),
(21, 'ushhzx', 503, 12),
(22, 'vcc', 503, 11),
(23, 'org2 tag', 502, 8),
(24, 'test tag', 502, 8),
(25, 'org2 tagg', 502, 8),
(26, 'org2 tagg', 502, 10),
(27, 'tag1', 504, 14),
(28, 'tag1', 504, 15),
(29, 'tag1', 504, 16),
(30, 'didi1', 510, 23),
(31, 'didi', 510, 22),
(32, 'didi2', 510, 24),
(33, 'didi1_1', 510, 25),
(34, 'cdeep', 511, 31),
(35, 'college', 511, 31),
(36, 'testcase tag', 512, 33),
(37, 'testcase1 tag', 512, 34),
(38, 'testcase2 tag', 512, 35),
(39, 'ashish tag', 513, 36),
(40, 'ashish1 tag', 513, 37),
(41, 'ashish2 tag', 513, 38),
(42, 'tag for testcase 1', 512, 34);

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
  `orgId` int(11) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `name`, `password`, `email`, `login`, `logout`, `status`, `picture`, `mobile`, `quota`, `DateCreated`, `LastUpdate`, `orgId`) VALUES
(1, 'us', 'saIam1KByhr6c', '0', '2014-05-29 14:15:16', '0000-00-00 00:00:00', '1', NULL, '0', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 500),
(2, 'org1', 'saPPmoXIbs91M', 'ucchiruchi@gmail.com', '2014-05-29 14:17:45', NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, 501),
(3, 'org2', 'saPPmoXIbs91M', 'ucchiruchi@gmail.com', '2014-05-29 14:23:07', NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, 502),
(4, 'rakhi org', 'saPPmoXIbs91M', 'r@g.c', '2014-05-29 16:01:24', NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, 503),
(5, 'ruchi', 'saEZ6MlWYV9nQ', 'ucchiruchi@gmail.com', '2014-05-29 16:03:38', NULL, '', NULL, '7599328505', NULL, '0000-00-00 00:00:00', NULL, 503),
(6, 'mansi', 'saPPmoXIbs91M', 'ucchiruchi@gmail.com', '2014-05-29 17:41:48', NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, 504),
(7, 'banani', 'saPPmoXIbs91M', 'ucchiruchi@gmail.com', '2014-05-29 19:51:42', NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, 505),
(8, 'banani', 'saPPmoXIbs91M', 'ucchiruchi@gmail.com', '2014-05-29 19:55:32', NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, 505),
(9, 'banani', 'saPPmoXIbs91M', 'ucchiruchi@gmail.com', '2014-05-29 19:57:08', NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, 505),
(10, 'yogesh gupta', 'saPPmoXIbs91M', 'ucchiruchi@gmail.com', '2014-05-29 19:58:45', NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, 508),
(11, 'yogesh', 'saPPmoXIbs91M', 'ucchiruchi@gmail.com', '2014-05-29 19:59:41', NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, 509),
(12, 'didi', 'saPPmoXIbs91M', 'ucchiruchi@gmail.com', '2014-05-29 20:02:15', NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, 510),
(13, 'bhaiya', 'saEZ6MlWYV9nQ', 'ucchiruchi@gmail.com', '2014-05-29 20:06:00', NULL, '1', NULL, '7599328505', NULL, '0000-00-00 00:00:00', NULL, 510),
(14, 'IIT Bombay', 'saPPmoXIbs91M', 'ucchiruchi@gmail.com', '2014-05-30 02:19:30', NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, 511),
(15, 'my user', 'saEZ6MlWYV9nQ', 'ucchiruchi@gmail.com', '2014-05-30 02:32:19', NULL, '', NULL, '7599328505', NULL, '0000-00-00 00:00:00', NULL, 511),
(16, 'testcase', 'sadgC/1v9zmic', 'ucchiruchi@gmail.com', '2014-05-30 09:06:38', NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, 512),
(17, 'testcase user1', 'sadgC/1v9zmic', 'ucchiruchi@gmail.com', '2014-05-30 09:06:38', NULL, '1', NULL, '7599328505', NULL, '0000-00-00 00:00:00', NULL, 512),
(18, 'testcase user2', 'sadgC/1v9zmic', 'ucchiruchi@gmail.com', '2014-05-30 09:06:38', NULL, '1', NULL, '', NULL, '0000-00-00 00:00:00', NULL, 512),
(19, 'ashish', '123', 'ucchiruchi@gmail.com', '2014-05-30 05:23:39', NULL, '1', NULL, '', NULL, '0000-00-00 00:00:00', NULL, 513),
(20, 'ashish user1', 'saEZ6MlWYV9nQ', 'ucchiruchi@gmail.com', '2014-05-30 05:26:29', NULL, '1', NULL, '7599328505', NULL, '0000-00-00 00:00:00', NULL, 513),
(21, 'ashish user 2', 'saEZ6MlWYV9nQ', 'ucchiruchi@gmail.com', '2014-05-30 05:31:13', NULL, '', NULL, '', NULL, '0000-00-00 00:00:00', NULL, 513),
(22, 'newww', 'sadgC/1v9zmic', 'ucchiruchi@gmail.com', '2014-05-30 05:49:08', NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, 514),
(23, 'aaq', 'saPPmoXIbs91M', 'ucchiruchi@gmail.com', '2014-05-30 07:28:57', NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, 515),
(24, 'bvbjh', 'saPPmoXIbs91M', '', '2014-05-30 11:13:12', NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, 516);

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
  ADD CONSTRAINT `fk_role_has_permissions_permissions1` FOREIGN KEY (`permissions_pid`) REFERENCES `permissions` (`pid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_role_has_permissions_role1` FOREIGN KEY (`role_rid`) REFERENCES `role` (`rid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users_has_role`
--
ALTER TABLE `users_has_role`
  ADD CONSTRAINT `fk_users_has_role_role1` FOREIGN KEY (`role_rid`) REFERENCES `role` (`rid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_has_role_users` FOREIGN KEY (`users_uid`) REFERENCES `users` (`uid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
