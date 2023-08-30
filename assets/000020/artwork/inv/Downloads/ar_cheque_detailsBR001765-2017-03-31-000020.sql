-- phpMyAdmin SQL Dump
-- version 2.10.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Mar 31, 2017 at 11:54 PM
-- Server version: 5.1.47
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `neo`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `ar_cheque_details`
-- 

CREATE TABLE `ar_cheque_details` (
  `company_id` varchar(15) NOT NULL DEFAULT '',
  `adr_company_id` varchar(15) NOT NULL DEFAULT '',
  `chq_no` varchar(50) NOT NULL,
  `chq_date` date DEFAULT NULL,
  `bank_id` varchar(15) DEFAULT NULL,
  `account_no` varchar(15) DEFAULT NULL,
  `chq_amt` double DEFAULT NULL,
  `chq_deposit_date` date DEFAULT NULL,
  `chq_cleared_date` date DEFAULT NULL,
  `difference_amt` double DEFAULT NULL,
  `chq_return_date` date DEFAULT NULL,
  `chq_cancelled_flag` tinyint(1) DEFAULT NULL,
  `clubbed_chq_flag` tinyint(1) DEFAULT NULL,
  `chq_printed` tinyint(1) DEFAULT '0',
  `total_inv_amt` double DEFAULT '0',
  `chq_det_id` int(8) NOT NULL DEFAULT '0',
  `voucher_no` varchar(30) DEFAULT NULL,
  `voucher_date` date DEFAULT '0000-00-00',
  `type_flag` tinyint(1) DEFAULT '0',
  `exchange_rate` double DEFAULT NULL,
  PRIMARY KEY (`company_id`,`adr_company_id`,`chq_det_id`,`chq_no`),
  KEY `company_id` (`company_id`),
  KEY `adr_company_id` (`adr_company_id`),
  KEY `chq_det_id` (`chq_det_id`),
  KEY `i1` (`chq_no`,`chq_date`,`voucher_no`,`voucher_date`),
  KEY `for_bank_reco_ar_cheque` (`chq_amt`,`adr_company_id`,`chq_date`,`voucher_no`,`voucher_date`,`account_no`),
  KEY `for_bank_bal_entry_ar_cheque` (`chq_amt`,`adr_company_id`,`chq_date`,`chq_cancelled_flag`,`chq_cleared_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `ar_cheque_details`
-- 

INSERT INTO `ar_cheque_details` (`company_id`, `adr_company_id`, `chq_no`, `chq_date`, `bank_id`, `account_no`, `chq_amt`, `chq_deposit_date`, `chq_cleared_date`, `difference_amt`, `chq_return_date`, `chq_cancelled_flag`, `clubbed_chq_flag`, `chq_printed`, `total_inv_amt`, `chq_det_id`, `voucher_no`, `voucher_date`, `type_flag`, `exchange_rate`) VALUES 
('000020', '551', '999999', '2017-03-31', NULL, NULL, 376100, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 13288, 'BR001765|2017-03-31|000020', '2017-03-31', 2, 0);
-- Functions
-- 

CREATE DEFINER=`root`@`localhost` FUNCTION `strSplit`(x varchar(255), delim varchar(12), pos int) RETURNS varchar(255) CHARSET latin1
return replace(substring(substring_index(x, delim, pos), length(substring_index(x, delim, pos - 1)) + 1), delim, '')

