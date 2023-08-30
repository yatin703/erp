-- phpMyAdmin SQL Dump
-- version 2.10.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: May 26, 2017 at 05:46 PM
-- Server version: 5.1.47
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `neo`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `ap_invoice_details`
-- 

CREATE TABLE `ap_invoice_details` (
  `ap_invoice_no` varchar(30) NOT NULL,
  `delivery_note_no` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `article_no` varchar(35) DEFAULT NULL,
  `manufacturer_id` varchar(15) DEFAULT NULL,
  `supply_date` date DEFAULT NULL,
  `ar_invoice_no` varchar(30) DEFAULT NULL,
  `customer_no` varchar(15) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `creation_date` date DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `apid_pos_no` varchar(15) NOT NULL DEFAULT '',
  `quantity` double DEFAULT NULL,
  `uom_id` varchar(15) DEFAULT NULL,
  `net_price` double DEFAULT NULL,
  `total_amount` double DEFAULT NULL,
  `company_id` varchar(15) NOT NULL DEFAULT '',
  `other_taxes` double DEFAULT NULL,
  `temp_tax_pos_no` varchar(15) DEFAULT NULL,
  `edu_cess` double DEFAULT '0',
  `edu_cess_amt` double DEFAULT '0',
  `other_taxes_amt` double DEFAULT '0',
  `tax_pos_no` varchar(15) DEFAULT NULL,
  `total_tax` double DEFAULT NULL,
  `unit_rate` double DEFAULT NULL,
  `discount_perc` double DEFAULT NULL,
  `discount_amount` double DEFAULT NULL,
  `tax_code` varchar(15) DEFAULT NULL,
  `packing_type_id` varchar(15) DEFAULT NULL,
  `bal_qty_for_sale` double DEFAULT NULL,
  `ref_no` varchar(35) DEFAULT NULL,
  `ref_pos_no` varchar(15) DEFAULT NULL,
  `trans_flag` tinyint(1) DEFAULT '0',
  `priceunit_fc` double DEFAULT NULL,
  `manuf_rate` double DEFAULT NULL,
  `sub_company_id` varchar(15) DEFAULT NULL,
  `mrp_multiple` double DEFAULT NULL,
  `tax_grid_amount` varchar(255) DEFAULT NULL,
  `not_proportionate_flag` tinyint(1) unsigned DEFAULT '0',
  `rel_uom_id` varchar(15) DEFAULT NULL,
  `flag_calcon` tinyint(1) unsigned DEFAULT '0',
  `flag_uom_type` tinyint(1) unsigned DEFAULT '0',
  `pnf_perc` double DEFAULT NULL,
  `pnf_amount` double DEFAULT NULL,
  `freight_perc` double DEFAULT NULL,
  `freight_amount` double DEFAULT NULL,
  `insu_perc` double DEFAULT NULL,
  `insu_amount` double DEFAULT NULL,
  `octroi_perc` double DEFAULT NULL,
  `octroi_amount` double DEFAULT NULL,
  `calc_sell_price` double DEFAULT NULL,
  `rel_po_qty` double DEFAULT NULL,
  `pfi_det_calcon` tinyint(1) unsigned DEFAULT '0',
  `packing_calcon` varchar(10) DEFAULT NULL,
  `freight_calcon` varchar(10) DEFAULT NULL,
  `insu_calcon` varchar(10) DEFAULT NULL,
  `octroi_calcon` varchar(10) DEFAULT NULL,
  `prop_tax1` double DEFAULT NULL,
  `prop_tax2` double DEFAULT NULL,
  `packing_tax_flag` tinyint(1) DEFAULT '0',
  `freight_tax_flag` tinyint(1) DEFAULT '0',
  `insu_tax_flag` tinyint(1) DEFAULT '0',
  `tax_calc_str` varchar(255) DEFAULT NULL,
  `update_tax_recs` tinyint(1) DEFAULT '0',
  `unit_tax` double DEFAULT NULL,
  PRIMARY KEY (`ap_invoice_no`,`apid_pos_no`,`company_id`),
  KEY `ap_invoice_no` (`ap_invoice_no`),
  KEY `article_no` (`article_no`),
  KEY `ar_invoice_no` (`ar_invoice_no`),
  KEY `apid_pos_no` (`apid_pos_no`),
  KEY `company_id` (`company_id`),
  KEY `delivery_note_no` (`delivery_note_no`),
  KEY `for_purchase_bi_tools4` (`article_no`,`quantity`,`net_price`,`unit_rate`,`discount_amount`,`ap_invoice_no`),
  KEY `for_purchase_bi_tools9` (`ap_invoice_no`,`ref_no`,`ref_pos_no`,`trans_flag`,`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `ap_invoice_details`
-- 

INSERT INTO `ap_invoice_details` (`ap_invoice_no`, `delivery_note_no`, `description`, `article_no`, `manufacturer_id`, `supply_date`, `ar_invoice_no`, `customer_no`, `invoice_date`, `creation_date`, `remark`, `apid_pos_no`, `quantity`, `uom_id`, `net_price`, `total_amount`, `company_id`, `other_taxes`, `temp_tax_pos_no`, `edu_cess`, `edu_cess_amt`, `other_taxes_amt`, `tax_pos_no`, `total_tax`, `unit_rate`, `discount_perc`, `discount_amount`, `tax_code`, `packing_type_id`, `bal_qty_for_sale`, `ref_no`, `ref_pos_no`, `trans_flag`, `priceunit_fc`, `manuf_rate`, `sub_company_id`, `mrp_multiple`, `tax_grid_amount`, `not_proportionate_flag`, `rel_uom_id`, `flag_calcon`, `flag_uom_type`, `pnf_perc`, `pnf_amount`, `freight_perc`, `freight_amount`, `insu_perc`, `insu_amount`, `octroi_perc`, `octroi_amount`, `calc_sell_price`, `rel_po_qty`, `pfi_det_calcon`, `packing_calcon`, `freight_calcon`, `insu_calcon`, `octroi_calcon`, `prop_tax1`, `prop_tax2`, `packing_tax_flag`, `freight_tax_flag`, `insu_tax_flag`, `tax_calc_str`, `update_tax_recs`, `unit_tax`) VALUES 
('INV-17-18-1543', '', 'TIMER BELT 540L 20MM ', 'SS-BEL-VB-0073', NULL, '2017-05-20', NULL, NULL, NULL, NULL, NULL, '1', 300, 'UOM001', 225000, 229500, '000020', NULL, NULL, 0, 0, 0, '8', 4500, 75000, 0, 0, '', '', 300, 'PGRIR-17-18-0936', '1', 1, 0, 0, '', 0, '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 765, 0, 0, '', '', '', '1|0|0|0|0', 0, 0, 0, 0, 0, '45', 0, 15);
-- Functions
-- 

CREATE DEFINER=`root`@`localhost` FUNCTION `strSplit`(x varchar(255), delim varchar(12), pos int) RETURNS varchar(255) CHARSET latin1
return replace(substring(substring_index(x, delim, pos), length(substring_index(x, delim, pos - 1)) + 1), delim, '')

