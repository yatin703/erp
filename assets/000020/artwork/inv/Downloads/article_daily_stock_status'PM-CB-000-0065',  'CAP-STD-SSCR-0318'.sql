-- phpMyAdmin SQL Dump
-- version 2.10.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Jan 25, 2017 at 03:28 PM
-- Server version: 5.1.47
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `neo`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `article_daily_stock_status`
-- 

CREATE TABLE `article_daily_stock_status` (
  `company_id` varchar(15) NOT NULL DEFAULT '',
  `adss_date` date NOT NULL DEFAULT '0000-00-00',
  `article_no` varchar(35) NOT NULL DEFAULT '',
  `quantity` double DEFAULT '0',
  `quantity_rel` double DEFAULT NULL,
  `calculated_purchase_price` double DEFAULT '0',
  `calculated_purchase_value` double DEFAULT '0',
  PRIMARY KEY (`company_id`,`adss_date`,`article_no`),
  KEY `company_id` (`company_id`),
  KEY `adss_date` (`adss_date`),
  KEY `article_no` (`article_no`),
  KEY `for_inv_bi_Tools1` (`adss_date`,`article_no`,`calculated_purchase_price`),
  KEY `for_inv_bi_Tools2` (`article_no`,`quantity`,`adss_date`),
  KEY `for_inv_bi_tools3` (`adss_date`,`quantity`,`calculated_purchase_price`,`article_no`),
  KEY `for_current_stock_article_daily_stock_status` (`article_no`,`adss_date`,`quantity`,`calculated_purchase_price`,`calculated_purchase_value`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `article_daily_stock_status`
-- 

INSERT INTO `article_daily_stock_status` (`company_id`, `adss_date`, `article_no`, `quantity`, `quantity_rel`, `calculated_purchase_price`, `calculated_purchase_value`) VALUES 
('000020', '2017-01-25', 'CAP-STD-SSCR-0318', 8750000, 0, 40, 3500000),
('000020', '2017-01-25', 'PM-CB-000-0065', 572510, 0, 822, 4710340);
-- Functions
-- 

CREATE DEFINER=`root`@`localhost` FUNCTION `strSplit`(x varchar(255), delim varchar(12), pos int) RETURNS varchar(255) CHARSET latin1
return replace(substring(substring_index(x, delim, pos), length(substring_index(x, delim, pos - 1)) + 1), delim, '')

