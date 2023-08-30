<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Test_ankit extends CI_Controller 
{ 
  public function __construct() 
  { parent::__construct(); 
    $this->load->library('excel');
    $this->load->model('common_model');
    $this->load->model('sales_order_book_model');
    $this->load->model('payment_term_model');
    $this->load->model('customer_model');
    $this->load->model('property_model');
    $this->load->model('tax_grid_model');
    $this->load->model('sales_invoice_book_model');

  }

  public function index()
  {
      //$date_raw =  '2023-05-24';
      $yes  = date('Y-m-d', strtotime('-1 day'));
      echo $yes1 = $yes;
  }
}