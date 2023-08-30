<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_order_confirmation extends CI_Controller {

	function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){

      $this->load->model('common_model');
      $this->load->model('sales_order_book_model');
      $this->load->model('sales_order_status_model');
      $this->load->model('sales_invoice_book_model');
      $this->load->model('artwork_model');
      $this->load->model('country_model');
      $this->load->model('customer_model');
      $this->load->model('tax_grid_model');
      $this->load->model('relate_model');
      $this->load->model('specification_model');
      $this->load->model('property_model');
      $this->load->model('payment_term_model');
      $this->load->model('customer_model');
      $this->load->model('article_model');
      $this->load->model('fiscal_model');
      $this->load->model('sleeve_specification_model');
      $this->load->model('shoulder_specification_model');
      $this->load->model('cap_specification_model');
      $this->load->model('label_specification_model');
      $this->load->model('freight_type_model');
      $this->load->model('artwork_springtube_model');
      $this->load->model('springtube_extrusion_production_model');
      $this->load->model('sales_order_followup_model');
      
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
    		$data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_item_parameterwise');

		  	foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){
            $from="2022-01-20";
            $to=date('Y-m-d');
            $search="";
            
            $data['order_master']=$this->sales_order_book_model->active_record_oc('order_master',$search,$from="",$to="",$this->session->userdata['logged_in']['company_id'],$order_closed_arr="",'2022-02-10',date('Y-m-d'),$cancelled_from_date="",$cancelled_to_date="");

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
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
    	$data['page_name']='Sales';
    	$data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
  		$this->load->view('Home/header');
  		$this->load->view('Home/nav',$data);
  		$this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
  		$this->load->view('Home/footer');
    }
  }

 
}