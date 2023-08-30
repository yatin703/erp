-- phpMyAdmin SQL Dump
-- version 2.10.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: May 15, 2017 at 04:28 PM
-- Server version: 5.1.47
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `neo`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `artwork_devel_details`
-- 

CREATE TABLE `artwork_devel_details` (
  `company_id` varchar(15) NOT NULL DEFAULT '',
  `ad_id` varchar(30) NOT NULL DEFAULT '',
  `version_no` int(4) NOT NULL DEFAULT '0',
  `artwork_para_id` varchar(15) NOT NULL,
  `parameter_value` varchar(255) DEFAULT NULL,
  `flag_multiple` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`company_id`,`ad_id`,`version_no`,`artwork_para_id`),
  KEY `company_id` (`company_id`),
  KEY `ad_id` (`ad_id`),
  KEY `version_no` (`version_no`),
  KEY `artwork_para_id` (`artwork_para_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `artwork_devel_details`
-- 

INSERT INTO `artwork_devel_details` (`company_id`, `ad_id`, `version_no`, `artwork_para_id`, `parameter_value`, `flag_multiple`) VALUES 
('000020', 'AW3945', 2, '1', '35 MM', 0),
('000020', 'AW3945', 2, '10', '||', 1),
('000020', 'AW3945', 2, '11', '||', 1),
('000020', 'AW3945', 2, '12', '||', 1),
('000020', 'AW3945', 2, '13', '', 0),
('000020', 'AW3945', 2, '14', '', 0),
('000020', 'AW3945', 2, '15', '', 0),
('000020', 'AW3945', 2, '16', '', 0),
('000020', 'AW3945', 2, '17', 'OFFSET', 0),
('000020', 'AW3945', 2, '18', '||', 1),
('000020', 'AW3945', 2, '2', '95 MM', 0),
('000020', 'AW3945', 2, '3', '', 0),
('000020', 'AW3945', 2, '4', '', 0),
('000020', 'AW3945', 2, '5', '', 0),
('000020', 'AW3945', 2, '6', '', 0),
('000020', 'AW3945', 2, '7', 'WHITE', 0),
('000020', 'AW3945', 2, '8', '', 0),
('000020', 'AW3945', 2, '9', '||', 1);
-- Functions
-- 

CREATE DEFINER=`root`@`localhost` FUNCTION `strSplit`(x varchar(255), delim varchar(12), pos int) RETURNS varchar(255) CHARSET latin1
return replace(substring(substring_index(x, delim, pos), length(substring_index(x, delim, pos - 1)) + 1), delim, '')

