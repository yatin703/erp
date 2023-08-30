-- phpMyAdmin SQL Dump
-- version 2.10.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Jan 25, 2017 at 03:24 PM
-- Server version: 5.1.47
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `neo`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `article_history`
-- 

CREATE TABLE `article_history` (
  `article_no` varchar(35) NOT NULL DEFAULT '',
  `art_pos_no` varchar(15) NOT NULL DEFAULT '',
  `sales_purchase_flag` tinyint(1) NOT NULL DEFAULT '0',
  `charge_no` varchar(15) DEFAULT NULL,
  `customer_supplier_no` varchar(15) DEFAULT NULL,
  `customer_supplier` varchar(50) DEFAULT NULL,
  `delivery_purchase_no` varchar(35) DEFAULT NULL,
  `ar_er_no` varchar(50) DEFAULT NULL,
  `price` double DEFAULT '0',
  `ah_qty` double DEFAULT '0',
  `tax` double DEFAULT '0',
  `discount` double DEFAULT '0',
  `ah_total_price` double DEFAULT '0',
  `date` date DEFAULT NULL,
  `archive` tinyint(1) DEFAULT NULL,
  `company_id` varchar(15) NOT NULL DEFAULT '',
  `bin_card_no` varchar(15) NOT NULL DEFAULT '',
  `po_so_no` varchar(35) DEFAULT NULL,
  `po_so_pos_no` varchar(15) NOT NULL DEFAULT '',
  `uom_id` varchar(15) DEFAULT NULL,
  `stock_place_id` varchar(15) DEFAULT NULL,
  `op_flag` tinyint(1) unsigned DEFAULT '0',
  `sub_company_id` varchar(15) DEFAULT NULL,
  `ah_time` time DEFAULT NULL,
  `ah_qty_rel` double DEFAULT NULL,
  `batch_no` varchar(35) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `manuf_date` date DEFAULT NULL,
  `mrp` double DEFAULT NULL,
  `status` tinyint(1) unsigned DEFAULT '0',
  `landed_rate` double DEFAULT NULL,
  `landed_total` double DEFAULT NULL,
  `ptr` double DEFAULT NULL,
  `rate_excise` double DEFAULT '0',
  `value_rate_excise` double DEFAULT '0',
  `calculated_purchase_price` double DEFAULT '0',
  `calculated_purchase_value` double DEFAULT '0',
  `plant_id` varchar(15) DEFAULT NULL,
  `annexure_id` varchar(15) DEFAULT NULL,
  `rg_flag` tinyint(1) unsigned DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `changed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `remaining_batch_qty` varchar(20) NOT NULL,
  PRIMARY KEY (`article_no`,`art_pos_no`,`company_id`,`bin_card_no`,`po_so_pos_no`),
  KEY `article_no` (`article_no`),
  KEY `art_pos_no` (`art_pos_no`),
  KEY `company_id` (`company_id`),
  KEY `po_so_no` (`po_so_no`),
  KEY `ar_er_no` (`ar_er_no`),
  KEY `po_so_pos_no` (`po_so_pos_no`),
  KEY `for_inv_bi_tools4` (`article_no`,`date`,`ah_qty`,`sales_purchase_flag`),
  KEY `for_inv_bi_tools7` (`calculated_purchase_price`,`date`,`ah_qty`,`sales_purchase_flag`,`delivery_purchase_no`,`customer_supplier_no`,`article_no`),
  KEY `for_current_stock_article_history` (`article_no`,`delivery_purchase_no`,`ah_qty`,`date`,`po_so_no`,`stock_place_id`,`value_rate_excise`,`calculated_purchase_price`,`calculated_purchase_value`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `article_history`
-- 

INSERT INTO `article_history` (`article_no`, `art_pos_no`, `sales_purchase_flag`, `charge_no`, `customer_supplier_no`, `customer_supplier`, `delivery_purchase_no`, `ar_er_no`, `price`, `ah_qty`, `tax`, `discount`, `ah_total_price`, `date`, `archive`, `company_id`, `bin_card_no`, `po_so_no`, `po_so_pos_no`, `uom_id`, `stock_place_id`, `op_flag`, `sub_company_id`, `ah_time`, `ah_qty_rel`, `batch_no`, `expiry_date`, `manuf_date`, `mrp`, `status`, `landed_rate`, `landed_total`, `ptr`, `rate_excise`, `value_rate_excise`, `calculated_purchase_price`, `calculated_purchase_value`, `plant_id`, `annexure_id`, `rg_flag`, `created_at`, `changed_at`, `remaining_batch_qty`) VALUES 
('CAP-STD-SSCR-0318', '463453', 0, NULL, '2216', NULL, 'PGRIR-16-17-4959', NULL, 38, 4375000, 0, 0, 1662500, '2017-01-25', NULL, '000020', '', 'PO-16-17-3350_1', '1', '', '1', 0, '000020', '10:04:37', 0, '0', '2018-01-23', '2017-01-24', 38, 0, NULL, NULL, NULL, 0, 40, 40, 1750000, '', NULL, 0, '0000-00-00 00:00:00', '2017-01-25 10:04:37', ''),
('PM-CB-000-0065', '463454', 0, NULL, '1969', NULL, 'PGRIR-16-17-4959', NULL, 1760, 328700, 0, 0, 5785120, '2017-01-25', NULL, '000020', '', 'PO-16-17-3356', '1', '', '1', 0, '000020', '10:04:37', 0, '1243', '2018-01-23', '2017-01-24', 1760, 0, NULL, NULL, NULL, 0, 43, 822, 141341, '', NULL, 0, '0000-00-00 00:00:00', '2017-01-25 10:06:22', '');
-- Functions
-- 

CREATE DEFINER=`root`@`localhost` FUNCTION `strSplit`(x varchar(255), delim varchar(12), pos int) RETURNS varchar(255) CHARSET latin1
return replace(substring(substring_index(x, delim, pos), length(substring_index(x, delim, pos - 1)) + 1), delim, '')

