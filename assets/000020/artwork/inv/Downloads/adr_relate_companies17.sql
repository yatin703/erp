-- phpMyAdmin SQL Dump
-- version 2.10.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Jul 10, 2017 at 06:12 PM
-- Server version: 5.1.47
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `neo`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `adr_relate_companies`
-- 

CREATE TABLE `adr_relate_companies` (
  `company_id` varchar(15) NOT NULL DEFAULT '',
  `adr_company_id` varchar(15) NOT NULL DEFAULT '',
  `related_company_id` varchar(15) NOT NULL DEFAULT '',
  `related_property_id` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`company_id`,`adr_company_id`,`related_company_id`,`related_property_id`),
  KEY `company_id` (`company_id`),
  KEY `adr_company_id` (`adr_company_id`),
  KEY `related_property_id` (`related_property_id`),
  KEY `related_company_id` (`related_company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `adr_relate_companies`
-- 

INSERT INTO `adr_relate_companies` (`company_id`, `adr_company_id`, `related_company_id`, `related_property_id`) VALUES 
('000020', '17', '1342', '21'),
('000020', '17', '1711', '21'),
('000020', '17', '18', '21'),
('000020', '17', '19', '21'),
('000020', '17', '1962', '21'),
('000020', '17', '2345', '21'),
('000020', '17', '2433', '21'),
('000020', '17', '2538', '21'),
('000020', '17', '2570', '21'),
('000020', '17', '356', '21'),
('000020', '17', '41', '21'),
('000020', '17', '551', '21'),
('000020', '17', '591', '21'),
('000020', '17', '749', '21'),
('000020', '17', '774', '21'),
('000020', '17', '975', '21'),
('000020', '17', '999999911', '4'),
('000020', '17', '999999919', '4'),
('000020', '17', '999999920', '4'),
('000020', '17', '999999936', '4'),
('000020', '17', '999999955', '4'),
('000020', '17', '999999962', '4');
-- Functions
-- 

CREATE DEFINER=`root`@`localhost` FUNCTION `strSplit`(x varchar(255), delim varchar(12), pos int) RETURNS varchar(255) CHARSET latin1
return replace(substring(substring_index(x, delim, pos), length(substring_index(x, delim, pos - 1)) + 1), delim, '')

