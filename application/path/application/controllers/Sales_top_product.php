<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_top_product extends CI_Controller {

	function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('fiscal_model'); 
      $this->load->model('sales_order_book_model');
      $this->load->model('sales_invoice_book_model');
      $this->load->model('sales_order_status_model');
      $this->load->model('relate_model');
      $this->load->library('excel');
           
     

		}else{
			redirect('login','refresh');
		}
  }

  function index(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $table='costsheet_master';
            include('pagination.php');

            $data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','printing_group',$this->session->userdata['logged_in']['company_id']);
            $data['customer_category']=$this->common_model->select_active_drop_down('address_category_master',$this->session->userdata['logged_in']['company_id']);
            

            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            
            $data['invoice_types_master_lang']=$this->common_model->select_active_drop_down('invoice_types_master_lang',$this->session->userdata['logged_in']['company_id']); 

            $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

            if($data['account_periods_master']==FALSE){
              $from_date="";
            }else{
              foreach($data['account_periods_master'] as $account_periods_master_row){
                $from_date=$account_periods_master_row->fin_year_start;
              }
            }

            $data['top_products_costsheet']=$this->sales_invoice_book_model->select_top_product_by_costsheet($table,$this->session->userdata['logged_in']['company_id'],date('Y-m-01'),date('Y-m-d'),'','','','');


            //echo $this->db->last_query();
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view('Reports/active-title',$data);
            $this->load->view('Reports/top-products-costsheet',$data);
            $this->load->view('Home/footer');
          }else{
            $data['note']='No rights Thanks';
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Error/error-title',$data);
            $this->load->view('Home/footer');
          }
        }
        
        }
      }
    }
    else{
      $data['note']='No View rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  }
  
}