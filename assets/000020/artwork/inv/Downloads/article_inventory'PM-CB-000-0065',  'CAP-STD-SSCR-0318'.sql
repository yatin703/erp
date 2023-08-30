-- phpMyAdmin SQL Dump
-- version 2.10.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Jan 25, 2017 at 03:29 PM
-- Server version: 5.1.47
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `neo`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `article_inventory`
-- 

CREATE TABLE `article_inventory` (
  `article_no` varchar(35) NOT NULL DEFAULT '',
  `stock_place_id` varchar(15) NOT NULL DEFAULT '',
  `stock_on_hand` double DEFAULT '0',
  `archive` tinyint(1) DEFAULT NULL,
  `company_id` varchar(15) NOT NULL DEFAULT '',
  `stock_take_qty` double DEFAULT '0',
  `stock_take_date` date NOT NULL DEFAULT '0000-00-00',
  `flag` tinyint(1) DEFAULT '0',
  `stock_on_hand_rel` double DEFAULT NULL,
  `calculated_purchase_price` double DEFAULT '0',
  `calculated_purchase_value` double DEFAULT '0',
  PRIMARY KEY (`article_no`,`stock_place_id`,`company_id`,`stock_take_date`),
  KEY `article_no` (`article_no`),
  KEY `stock_place_id` (`stock_place_id`),
  KEY `company_id` (`company_id`),
  KEY `stock_take_date` (`stock_take_date`),
  KEY `for_current_stock_article_inventory` (`article_no`,`stock_on_hand`,`stock_take_date`,`calculated_purchase_price`,`calculated_purchase_value`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `article_inventory`
-- 

INSERT INTO `article_inventory` (`article_no`, `stock_place_id`, `stock_on_hand`, `archive`, `company_id`, `stock_take_qty`, `stock_take_date`, `flag`, `stock_on_hand_rel`, `calculated_purchase_price`, `calculated_purchase_value`) VALUES 
('CAP-STD-SSCR-0318', '1', 8750000, NULL, '000020', 0, '2017-01-25', 0, 0, 40, 3500000),
('PM-CB-000-0065', '1', 572510, NULL, '000020', 0, '2017-01-25', 0, 0, 822, 4710340);
-- Functions
-- 

CREATE DEFINER=`root`@`localhost` FUNCTION `strSplit`(x varchar(255), delim varchar(12), pos int) RETURNS varchar(255) CHARSET latin1
return replace(substring(substring_index(x, delim, pos), length(substring_index(x, delim, pos - 1)) + 1), delim, '')

