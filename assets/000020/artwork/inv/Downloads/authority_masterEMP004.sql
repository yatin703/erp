-- phpMyAdmin SQL Dump
-- version 2.10.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Jul 05, 2017 at 03:31 PM
-- Server version: 5.1.47
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `neo`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `authority_master`
-- 

CREATE TABLE `authority_master` (
  `company_id` varchar(15) NOT NULL DEFAULT '',
  `employee_id` varchar(15) NOT NULL DEFAULT '',
  `form_id` int(4) NOT NULL DEFAULT '0',
  `for_approval` tinyint(1) unsigned DEFAULT NULL,
  `approval_level` tinyint(1) DEFAULT NULL,
  `alternate_approver` varchar(15) DEFAULT NULL,
  `ident_for_branch` varchar(15) DEFAULT NULL,
  `surpassable` tinyint(1) unsigned DEFAULT NULL,
  `from_corp_branch_flag` tinyint(1) unsigned DEFAULT '0',
  `corp_factory_level_flag` tinyint(1) unsigned DEFAULT '0',
  `for_corp_branch_flag` tinyint(1) unsigned DEFAULT '0',
  `pos_id` int(4) unsigned NOT NULL DEFAULT '0',
  `department_id` varchar(15) DEFAULT NULL,
  `amount_limit` double DEFAULT NULL,
  `auth_password` varchar(30) DEFAULT '0',
  `authority_level` tinyint(1) DEFAULT '0',
  `amount_limit_to` double DEFAULT NULL,
  `specify_amount_limit` tinyint(1) unsigned DEFAULT '0',
  `flag_to_corp` tinyint(1) DEFAULT '0',
  `reaction_time` int(2) unsigned DEFAULT NULL,
  `reaction_time_unit` varchar(15) DEFAULT NULL,
  `transac_forms_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`company_id`,`employee_id`,`form_id`,`pos_id`),
  KEY `company_id` (`company_id`),
  KEY `employee_id` (`employee_id`),
  KEY `form_id` (`form_id`),
  KEY `pos_id` (`pos_id`),
  KEY `department_id` (`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `authority_master`
-- 

INSERT INTO `authority_master` (`company_id`, `employee_id`, `form_id`, `for_approval`, `approval_level`, `alternate_approver`, `ident_for_branch`, `surpassable`, `from_corp_branch_flag`, `corp_factory_level_flag`, `for_corp_branch_flag`, `pos_id`, `department_id`, `amount_limit`, `auth_password`, `authority_level`, `amount_limit_to`, `specify_amount_limit`, `flag_to_corp`, `reaction_time`, `reaction_time_unit`, `transac_forms_id`) VALUES 
('000020', 'EMP004', 979, 0, 1, NULL, '', 0, 0, 0, 0, 2, '', 0, '0', 0, 0, 0, 0, 30, '2', ''),
('000020', 'EMP004', 985, 0, 1, NULL, '', 0, 0, 0, 0, 3, '', 0, '0', 0, 0, 0, 0, 30, '2', '');
-- Functions
-- 

CREATE DEFINER=`root`@`localhost` FUNCTION `strSplit`(x varchar(255), delim varchar(12), pos int) RETURNS varchar(255) CHARSET latin1
return replace(substring(substring_index(x, delim, pos), length(substring_index(x, delim, pos - 1)) + 1), delim, '')

