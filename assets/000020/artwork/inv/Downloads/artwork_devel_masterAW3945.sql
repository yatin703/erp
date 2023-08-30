-- phpMyAdmin SQL Dump
-- version 2.10.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: May 15, 2017 at 04:27 PM
-- Server version: 5.1.47
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `neo`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `artwork_devel_master`
-- 

CREATE TABLE `artwork_devel_master` (
  `company_id` varchar(15) NOT NULL DEFAULT '',
  `ad_id` varchar(30) NOT NULL DEFAULT '',
  `version_no` int(4) NOT NULL DEFAULT '0',
  `ad_date` date DEFAULT NULL,
  `adr_company_id` varchar(15) DEFAULT NULL,
  `article_no` varchar(35) DEFAULT NULL,
  `pending_flag` tinyint(1) DEFAULT '0',
  `final_approval_flag` tinyint(1) DEFAULT '0',
  `approval_date` date DEFAULT NULL,
  `approved_by` varchar(15) DEFAULT NULL,
  `user_id` varchar(15) DEFAULT NULL,
  `mat_sent_date` date DEFAULT NULL,
  `CAD_program` varchar(25) DEFAULT NULL,
  `mat_sent_net` tinyint(1) DEFAULT NULL,
  `mat_sent_cd` tinyint(1) DEFAULT NULL,
  `cd_ref` varchar(25) DEFAULT NULL,
  `mat_sent_courier` tinyint(1) DEFAULT NULL,
  `courier_ref` varchar(25) DEFAULT NULL,
  `archive` tinyint(1) DEFAULT '0',
  `courier_ref_date` date DEFAULT NULL,
  `property_id` varchar(15) DEFAULT NULL,
  `artwork_image_nm` varchar(200) DEFAULT NULL,
  `other_info` varchar(50) DEFAULT NULL,
  `referred_by` varchar(50) DEFAULT NULL,
  `customer_article_no` varchar(60) NOT NULL,
  PRIMARY KEY (`company_id`,`ad_id`,`version_no`),
  KEY `company_id` (`company_id`),
  KEY `ad_id` (`ad_id`),
  KEY `version_no` (`version_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `artwork_devel_master`
-- 

INSERT INTO `artwork_devel_master` (`company_id`, `ad_id`, `version_no`, `ad_date`, `adr_company_id`, `article_no`, `pending_flag`, `final_approval_flag`, `approval_date`, `approved_by`, `user_id`, `mat_sent_date`, `CAD_program`, `mat_sent_net`, `mat_sent_cd`, `cd_ref`, `mat_sent_courier`, `courier_ref`, `archive`, `courier_ref_date`, `property_id`, `artwork_image_nm`, `other_info`, `referred_by`, `customer_article_no`) VALUES 
('000020', 'AW3945', 1, '2017-05-11', '68', 'PSP-000-1156', 0, 0, NULL, NULL, 'EMP195', '0000-00-00', '', 0, 0, '', 0, '', 0, '0000-00-00', '1', '', '', 'STEVAN', ''),
('000020', 'AW3945', 2, '2017-05-15', '68', 'PSP-000-1156', 0, 0, NULL, NULL, 'EMP151', '0000-00-00', '', 0, 0, '', 0, '', 0, '0000-00-00', '', '', '', 'STEVAN', '');
-- Functions
-- 

CREATE DEFINER=`root`@`localhost` FUNCTION `strSplit`(x varchar(255), delim varchar(12), pos int) RETURNS varchar(255) CHARSET latin1
return replace(substring(substring_index(x, delim, pos), length(substring_index(x, delim, pos - 1)) + 1), delim, '')

