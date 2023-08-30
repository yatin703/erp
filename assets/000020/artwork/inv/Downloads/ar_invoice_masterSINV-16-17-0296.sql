-- phpMyAdmin SQL Dump
-- version 2.10.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Apr 11, 2017 at 06:48 PM
-- Server version: 5.1.47
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `neo`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `ar_invoice_master`
-- 

CREATE TABLE `ar_invoice_master` (
  `manu_order_no` varchar(15) NOT NULL,
  `ar_invoice_no` varchar(30) NOT NULL DEFAULT '',
  `invoice_date` date NOT NULL DEFAULT '0000-00-00',
  `user_id` varchar(15) DEFAULT NULL,
  `group_bank_order_no` varchar(15) DEFAULT NULL,
  `customer_no` varchar(15) DEFAULT NULL,
  `order_confirmation_no` varchar(35) DEFAULT NULL,
  `order_confirmation_date` date DEFAULT NULL,
  `total_octroi` double DEFAULT NULL,
  `followup_info` text,
  `followup_id` varchar(15) DEFAULT NULL,
  `company_id` varchar(15) NOT NULL DEFAULT '',
  `cust_po_info` text,
  `contact_person_id` varchar(15) DEFAULT NULL,
  `quotation_no` varchar(30) DEFAULT NULL,
  `payment_condition_id` varchar(15) DEFAULT NULL,
  `delivery_terms_id` varchar(15) DEFAULT NULL,
  `totalprice` double DEFAULT NULL,
  `totaltax1` double DEFAULT NULL,
  `packagingcost` double DEFAULT NULL,
  `transportationcost` double DEFAULT NULL,
  `totalpricewithtax` double DEFAULT NULL,
  `netdays` int(11) DEFAULT NULL,
  `cash_discountdays` int(11) DEFAULT NULL,
  `cash_discount` double DEFAULT NULL,
  `discountamount` double DEFAULT NULL,
  `netamountdate` date DEFAULT NULL,
  `discountamountdate` date DEFAULT NULL,
  `actualpaymentdate` date DEFAULT NULL,
  `hire_purchase` varchar(10) DEFAULT NULL,
  `amt_received` double DEFAULT '0',
  `invoicecompleteflag` tinyint(1) NOT NULL DEFAULT '0',
  `cancel_invoice` tinyint(1) NOT NULL DEFAULT '0',
  `invoiceremarks` varchar(25) DEFAULT NULL,
  `latestpaymentdate` date DEFAULT NULL,
  `latestpaymentamount` double DEFAULT NULL,
  `interestokflag` tinyint(1) NOT NULL DEFAULT '0',
  `lastreminderdate` date DEFAULT NULL,
  `archive` tinyint(1) DEFAULT '0',
  `inquiry_no` varchar(30) DEFAULT '0',
  `discount_days` int(3) DEFAULT '0',
  `net_amount_days` int(3) DEFAULT '0',
  `create_ident` date DEFAULT '0000-00-00',
  `send_ident_to` varchar(60) DEFAULT '0',
  `final_approval_flag` tinyint(1) DEFAULT '0',
  `pending_flag` tinyint(1) DEFAULT '0',
  `approved_by` varchar(15) DEFAULT '0',
  `approval_date` date DEFAULT '0000-00-00',
  `totaltax2` double DEFAULT NULL,
  `order_no` varchar(30) DEFAULT NULL,
  `department_id` varchar(15) DEFAULT NULL,
  `printed` tinyint(1) DEFAULT NULL,
  `reminder_no` tinyint(1) DEFAULT NULL,
  `reminder1_date` date DEFAULT NULL,
  `reminder2_date` date DEFAULT NULL,
  `reminder3_date` date DEFAULT NULL,
  `inquiry_through` varchar(15) DEFAULT NULL,
  `forward_copy` tinyint(1) DEFAULT '0',
  `handover_to_other_emp` varchar(225) DEFAULT NULL,
  `copy_reason` tinytext,
  `handover_reason` tinytext,
  `cust_order_no` varchar(30) DEFAULT '',
  `cust_order_date` date DEFAULT '0000-00-00',
  `po_sr_no` int(4) DEFAULT '0',
  `cust_inward_no` varchar(25) DEFAULT NULL,
  `cust_inward_date` date DEFAULT NULL,
  `cust_inward_no1` varchar(25) DEFAULT NULL,
  `cust_inward_date1` date DEFAULT NULL,
  `excise_invoice_idt_no` varchar(25) DEFAULT NULL,
  `excise_invoice_idt_date` date DEFAULT NULL,
  `deli_docket_no` varchar(25) DEFAULT NULL,
  `deli_docket_date` date DEFAULT NULL,
  `exciseable` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `rem_fine1` double DEFAULT '0',
  `rem_fine2` double DEFAULT '0',
  `rem_fine3` double DEFAULT '0',
  `cust_inward_no2` varchar(25) DEFAULT NULL,
  `cust_inward_date2` date DEFAULT NULL,
  `invoice_time` time DEFAULT NULL,
  `bill_flag` tinyint(1) DEFAULT '0',
  `freight_id` varchar(15) DEFAULT NULL,
  `delivery_note_no` varchar(255) DEFAULT NULL,
  `created_dc` tinyint(1) unsigned DEFAULT '0',
  `warehouse_id` varchar(15) DEFAULT NULL,
  `round_val` double DEFAULT NULL,
  `consin_adr_company_id` varchar(15) DEFAULT NULL,
  `country_id` varchar(15) DEFAULT '',
  `currency_id` varchar(20) DEFAULT NULL,
  `exchange_rate` double DEFAULT NULL,
  `exchange_rate_date` datetime DEFAULT NULL,
  `inclusive_price` tinyint(1) DEFAULT '0',
  `sub_company_id` varchar(225) DEFAULT NULL,
  `net_amount_deci` varchar(50) DEFAULT NULL,
  `pckg_cost_prop_flag` tinyint(1) DEFAULT '0',
  `debit_credit_flag` tinyint(1) unsigned DEFAULT '0',
  `btn_flag` tinyint(1) DEFAULT '0',
  `ap_invoice_no` varchar(35) DEFAULT NULL,
  `property_id` varchar(15) DEFAULT NULL,
  `cenvat_flag` tinyint(1) unsigned DEFAULT '0',
  `transport_packing_perc` double DEFAULT NULL,
  `transport_packing_calcon` varchar(5) DEFAULT NULL,
  `freight_perc` double DEFAULT NULL,
  `freight_amt` double DEFAULT NULL,
  `freight_calcon` varchar(5) DEFAULT NULL,
  `insu_perc` double DEFAULT NULL,
  `insu_amt` double DEFAULT NULL,
  `insu_calcon` varchar(5) DEFAULT NULL,
  `pckg_cost_prop_flag1` tinyint(1) DEFAULT '0',
  `inv_type` int(1) DEFAULT '0',
  `agent_id` varchar(15) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `sales_rep_id` varchar(15) DEFAULT NULL,
  `fcl_lcl` tinyint(1) unsigned DEFAULT '0',
  `no_of_fcl` int(4) DEFAULT NULL,
  `consignee_on_bl` varchar(150) DEFAULT NULL,
  `clearing_agent` varchar(150) DEFAULT NULL,
  `for_export` tinyint(1) unsigned DEFAULT '0',
  `for_sampling` tinyint(1) unsigned DEFAULT '0',
  `export_license_type` tinyint(1) DEFAULT '0',
  `file_no` varchar(50) DEFAULT NULL,
  `lc_reqd` tinyint(1) unsigned DEFAULT '0',
  `lc_no` varchar(50) DEFAULT NULL,
  `agent_comm_perc` double DEFAULT NULL,
  `agent_comm_amt` double DEFAULT NULL,
  `voucher_no` varchar(30) DEFAULT NULL,
  `voucher_date` date DEFAULT NULL,
  `epcg_license_no` varchar(50) DEFAULT NULL,
  `calc_local_curr` tinyint(1) DEFAULT '0',
  `discount_amount` double DEFAULT NULL,
  `cash_discount_amount` double DEFAULT NULL,
  `type_flag` tinyint(1) DEFAULT '0',
  `other_adr_company_ids` varchar(255) DEFAULT NULL,
  `csl_pos_id` varchar(255) DEFAULT NULL,
  `consignee_accnt_flag` varchar(1) NOT NULL DEFAULT '0',
  `tax_app` tinyint(1) DEFAULT '0',
  `octroi_app` tinyint(1) unsigned DEFAULT '0',
  `transit_days` int(11) unsigned DEFAULT '0',
  `c_form_pending_flag` tinyint(1) unsigned DEFAULT '0',
  `c_form_note` varchar(255) NOT NULL,
  `inv_print_flag` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ar_invoice_no`,`company_id`,`exciseable`),
  KEY `ar_invoice_no` (`ar_invoice_no`),
  KEY `invoice_date` (`invoice_date`),
  KEY `customer_no` (`customer_no`),
  KEY `company_id` (`company_id`),
  KEY `quotation_no` (`quotation_no`),
  KEY `order_no` (`order_no`),
  KEY `cust_order_no` (`cust_order_no`),
  KEY `po_sr_no` (`po_sr_no`),
  KEY `exciseable` (`exciseable`),
  KEY `warehouse_id` (`warehouse_id`),
  KEY `i1` (`voucher_no`,`voucher_date`),
  KEY `for_collection` (`invoice_date`,`netamountdate`,`ar_invoice_no`,`currency_id`,`exchange_rate`,`totalpricewithtax`,`invoicecompleteflag`,`company_id`),
  KEY `for_finance_debtor` (`customer_no`,`property_id`,`company_id`,`archive`),
  KEY `for_BI_AR1` (`invoice_date`,`totalpricewithtax`,`ar_invoice_no`,`invoicecompleteflag`,`type_flag`,`voucher_no`,`voucher_date`,`net_amount_days`,`transit_days`,`netamountdate`),
  KEY `for_sales_bi_tools5` (`totalpricewithtax`,`invoice_date`,`company_id`,`customer_no`,`ar_invoice_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `ar_invoice_master`
-- 

INSERT INTO `ar_invoice_master` (`manu_order_no`, `ar_invoice_no`, `invoice_date`, `user_id`, `group_bank_order_no`, `customer_no`, `order_confirmation_no`, `order_confirmation_date`, `total_octroi`, `followup_info`, `followup_id`, `company_id`, `cust_po_info`, `contact_person_id`, `quotation_no`, `payment_condition_id`, `delivery_terms_id`, `totalprice`, `totaltax1`, `packagingcost`, `transportationcost`, `totalpricewithtax`, `netdays`, `cash_discountdays`, `cash_discount`, `discountamount`, `netamountdate`, `discountamountdate`, `actualpaymentdate`, `hire_purchase`, `amt_received`, `invoicecompleteflag`, `cancel_invoice`, `invoiceremarks`, `latestpaymentdate`, `latestpaymentamount`, `interestokflag`, `lastreminderdate`, `archive`, `inquiry_no`, `discount_days`, `net_amount_days`, `create_ident`, `send_ident_to`, `final_approval_flag`, `pending_flag`, `approved_by`, `approval_date`, `totaltax2`, `order_no`, `department_id`, `printed`, `reminder_no`, `reminder1_date`, `reminder2_date`, `reminder3_date`, `inquiry_through`, `forward_copy`, `handover_to_other_emp`, `copy_reason`, `handover_reason`, `cust_order_no`, `cust_order_date`, `po_sr_no`, `cust_inward_no`, `cust_inward_date`, `cust_inward_no1`, `cust_inward_date1`, `excise_invoice_idt_no`, `excise_invoice_idt_date`, `deli_docket_no`, `deli_docket_date`, `exciseable`, `rem_fine1`, `rem_fine2`, `rem_fine3`, `cust_inward_no2`, `cust_inward_date2`, `invoice_time`, `bill_flag`, `freight_id`, `delivery_note_no`, `created_dc`, `warehouse_id`, `round_val`, `consin_adr_company_id`, `country_id`, `currency_id`, `exchange_rate`, `exchange_rate_date`, `inclusive_price`, `sub_company_id`, `net_amount_deci`, `pckg_cost_prop_flag`, `debit_credit_flag`, `btn_flag`, `ap_invoice_no`, `property_id`, `cenvat_flag`, `transport_packing_perc`, `transport_packing_calcon`, `freight_perc`, `freight_amt`, `freight_calcon`, `insu_perc`, `insu_amt`, `insu_calcon`, `pckg_cost_prop_flag1`, `inv_type`, `agent_id`, `due_date`, `sales_rep_id`, `fcl_lcl`, `no_of_fcl`, `consignee_on_bl`, `clearing_agent`, `for_export`, `for_sampling`, `export_license_type`, `file_no`, `lc_reqd`, `lc_no`, `agent_comm_perc`, `agent_comm_amt`, `voucher_no`, `voucher_date`, `epcg_license_no`, `calc_local_curr`, `discount_amount`, `cash_discount_amount`, `type_flag`, `other_adr_company_ids`, `csl_pos_id`, `consignee_accnt_flag`, `tax_app`, `octroi_app`, `transit_days`, `c_form_pending_flag`, `c_form_note`, `inv_print_flag`) VALUES 
('', 'SINV-16-17-0296', '2016-05-11', 'EMP157', NULL, '81', '', '0000-00-00', 0, '', '', '000020', '', '', '', '1', '4', 9776000, 1441960, 0, 0, 11218000, NULL, 0, 0, 0, '2016-06-20', '2016-05-11', NULL, NULL, 11218000, 1, 0, '', NULL, NULL, 0, NULL, 0, '', 0, 30, '0000-00-00', '', 0, 0, '', '0000-00-00', 0, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, '', '', '', '', '0000-00-00', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, NULL, NULL, '11:16:46', 0, '11', 'DC-16-17-0325', 1, '1', 40, '', '', '', 0, '0000-00-00 00:00:00', 0, '', '', 0, 0, 0, '', '1', 0, 0, '', 0, 0, '', 0, 0, '', 0, 1, '', '0000-00-00', '', 0, 0, '', '', 0, 0, 0, NULL, 0, NULL, 0, 0, 'SI000298|2016-05-11|000020', '2016-05-11', NULL, 0, 0, 0, 0, NULL, NULL, '0', 0, 0, 10, 0, '', 1);
-- Functions
-- 

CREATE DEFINER=`root`@`localhost` FUNCTION `strSplit`(x varchar(255), delim varchar(12), pos int) RETURNS varchar(255) CHARSET latin1
return replace(substring(substring_index(x, delim, pos), length(substring_index(x, delim, pos - 1)) + 1), delim, '')

