<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

	function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('sales_invoice_book_model');
      $this->load->model('sales_order_book_model');
      $this->load->model('artwork_model');
      $this->load->model('country_model');
      $this->load->model('customer_model');
      $this->load->model('tax_grid_model');
      $this->load->model('relate_model');
      $this->load->model('specification_model');
      $this->load->model('property_model');
      $this->load->model('fiscal_model');
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
    		$data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'reports');

		  	foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $table='ar_invoice_master';
            include('pagination.php');
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            //$this->load->view('Loading/loading');
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
    	$data['page_name']='home';
    	$data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
  		$this->load->view('Home/header');
  		$this->load->view('Home/nav',$data);
  		$this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
  		$this->load->view('Home/footer');
    }
  }

  
    

   

  public function customer_check($str){
    if(!empty($str)){
    $customer_code=explode('//',$str);
    if(!empty($customer_code[1])){
      $data=array('address_master.adr_company_id'=>$customer_code[1],
        'address_master.name1'=>$customer_code[0]);
    $data['customer']=$this->customer_model->active_record_search('address_master',$data,$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    foreach ($data['customer'] as $customer_row) {

      if ($customer_row->adr_company_id == $customer_code[1]){
        return TRUE;
      }else{
        $this->form_validation->set_message('customer_check', 'The {field} field is incorrect');
        return FALSE;
        }
      } 
    }else{
        $this->form_validation->set_message('customer_check', 'The {field} field is incorrect');
        return FALSE;
        } 

    }
  }


  
  

    public function customer_supplier_check($str){
      
      if($str!=''){

        $customer_supplier_code=explode('//',$str);

        if(!empty($customer_supplier_code[1])){
          $data['customer_supplier']=$this->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'name1',$customer_supplier_code[0]);
          foreach ($data['customer_supplier'] as $customer_supplier_row){

            if ($customer_supplier_row->adr_company_id == $customer_supplier_code[1]){
              return TRUE;
            }else{
              $this->form_validation->set_message('adr_company_id', 'The {field} field is incorrect');
              return FALSE;
            }

          } 
        }else{
            $this->form_validation->set_message('adr_company_id', 'The {field} field is incorrect');
            return FALSE;
        } 


      }
      
  }

  public function article_check($str){
    if(!empty($str)){
    $item_code=explode('//',$str);
    if(!empty($item_code[1])){
    $data['item']=$this->common_model->select_one_active_record_nonlanguage_without_archive('article_name_info',$this->session->userdata['logged_in']['company_id'],'lang_article_description',$item_code[0]);
    foreach ($data['item'] as $item_row) {
      if ($item_row->article_no == $item_code[1]){
        return TRUE;
      }else{
        $this->form_validation->set_message('article_check', 'The {field} field is incorrect');
        return FALSE;
        }
      } 
    }else{
        $this->form_validation->set_message('article_check', 'The {field} field is incorrect');
        return FALSE;
      }
    } 
  }

  function capa_report(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'reports');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
            $this->load->model('complaint_register_model');

            if($data['account_periods_master']==FALSE){
              $from_date="";
            }else{
              foreach($data['account_periods_master'] as $account_periods_master_row){
                $from_date=$account_periods_master_row->fin_year_start;
              }
            }

            $data['capa']=$this->complaint_register_model->capa_mis();
            
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/capa-report',$data);
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


  function capa_internal_report(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'reports');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
            $this->load->model('complaint_register_model');

            if($data['account_periods_master']==FALSE){
              $from_date="";
            }else{
              foreach($data['account_periods_master'] as $account_periods_master_row){
                $from_date=$account_periods_master_row->fin_year_start;
              }
            }

            $data['capa']=$this->complaint_register_model->capa_mis();
            
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/capa-report',$data);
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

  function sales_five_year_monthwise(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'reports');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $table='ar_invoice_master';
            include('pagination.php');

            $data['sales_apr_march_yearwise']=$this->sales_invoice_book_model->sales_five_year_apr_march_monthwise($table,'2019-04-01','2024-03-31');

            $data['sales_jan_dec_yearwise']=$this->sales_invoice_book_model->sales_five_year_jan_dec_monthwise($table,'2018-01-01','2022-12-31');
           

            //echo $this->db->last_query();
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            //$this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/five-year-monthwise-sales',$data);
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


   function sales_five_year_print_type_wise(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'reports');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $table='ar_invoice_master';
            include('pagination.php');

            $data['sales_five_year_print_type_wise']=$this->sales_invoice_book_model->sales_five_year_print_type_wise($table,'2019-01-01','2024-12-31');

            $data['sales_five_year_print_type_apr_mar_wise']=$this->sales_invoice_book_model->sales_five_year_print_type_apr_mar_wise($table,'2019-04-01','2024-03-31');

            //echo $this->db->last_query();

            //$data['sales_five_year_print_type_wise']=$this->sales_invoice_book_model->sales_five_year_print_type_wise($table,'2016-01-01','2020-12-31');
           

            $this->db->last_query();
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            //$this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/five-year-print-type-wise-sales',$data);
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

  

  function big_dia_small_dia_wise_sales(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'reports');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $table='ar_invoice_master';
            include('pagination.php');
            $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

            $data['invoice_types_master_lang']=$this->common_model->select_active_drop_down('invoice_types_master_lang',$this->session->userdata['logged_in']['company_id']); 

            if($data['account_periods_master']==FALSE){
              $from_date="";
            }else{
              foreach($data['account_periods_master'] as $account_periods_master_row){
                $from_date=$account_periods_master_row->fin_year_start;
              }
            }
            
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            //$data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);

            $data['dia_wise_sales']=$this->sales_invoice_book_model->select_dia_wise_sales($table,$from_date,date('Y-m-d'),'','');
            
            //$data['dia_wise_sales_coex']=$this->sales_invoice_book_model->select_dia_wise_coex_sales_record($table,$from_date,date('Y-m-d'),'','');
            //echo $this->db->last_query();
            //$data['dia_wise_sales_spring']=$this->sales_invoice_book_model->select_dia_wise_spring_sales_record($table,$from_date,date('Y-m-d'),'','');

            //echo $this->db->last_query();
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/dia-wise-sales',$data);
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

  function domestic_export_sales(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'reports');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $table='ar_invoice_master';
            include('pagination.php');
            $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

           // $data['invoice_types_master_lang']=$this->common_model->select_active_drop_down('invoice_types_master_lang',$this->session->userdata['logged_in']['company_id']); 

            if($data['account_periods_master']==FALSE){
              $from_date="";
            }else{
              foreach($data['account_periods_master'] as $account_periods_master_row){
                $from_date=$account_periods_master_row->fin_year_start;
              }
            }
            
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            //$data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);

            $data['domestic_export_sales']=$this->sales_invoice_book_model->select_domestic_export_wise_sales($table,$from_date,date('Y-m-d'),'','');
            
            //$data['dia_wise_sales_coex']=$this->sales_invoice_book_model->select_dia_wise_coex_sales_record($table,$from_date,date('Y-m-d'),'','');
            //echo $this->db->last_query();
            //$data['dia_wise_sales_spring']=$this->sales_invoice_book_model->select_dia_wise_spring_sales_record($table,$from_date,date('Y-m-d'),'','');

            //echo $this->db->last_query();
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/domestic-export-sales',$data);
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


  function print_type_wise_sales(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'reports');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $table='ar_invoice_master';
            include('pagination.php');

            $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

            $data['invoice_types_master_lang']=$this->common_model->select_active_drop_down('invoice_types_master_lang',$this->session->userdata['logged_in']['company_id']); 

            if($data['account_periods_master']==FALSE){
              $from_date="";
            }else{
              foreach($data['account_periods_master'] as $account_periods_master_row){
                $from_date=$account_periods_master_row->fin_year_start;
              }
            }

            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            //$data['customer_category']=$this->common_model->select_active_drop_down('address_category_master',$this->session->userdata['logged_in']['company_id']);
            
            $data['print_type_wise_sales_coex']=$this->sales_invoice_book_model->select_print_type_wise_sales($table,$from_date,date('Y-m-d'),'','','','','');
            
            //$data['print_type_wise_sales_coex']=$this->sales_invoice_book_model->select_print_type_wise_coex_sales_record($table,$from_date,date('Y-m-d'),'','','','','');
            //$data['print_type_wise_sales_spring']=$this->sales_invoice_book_model->select_print_type_wise_spring_sales_record($table,$from_date,date('Y-m-d'),'','','','','');

            //echo $this->db->last_query();
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/print-type-wise-sales',$data);
            //$this->load->view(ucwords($this->router->fetch_class()).'/print-type-wise-sales_bkp_3jun2021',$data);
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


  function dia_wise_sales(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'reports');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $table='ar_invoice_master';
            include('pagination.php');

            $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

            $data['invoice_types_master_lang']=$this->common_model->select_active_drop_down('invoice_types_master_lang',$this->session->userdata['logged_in']['company_id']); 

            if($data['account_periods_master']==FALSE){
              $from_date="";
            }else{
              foreach($data['account_periods_master'] as $account_periods_master_row){
                $from_date=$account_periods_master_row->fin_year_start;
              }
            }

            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            //$data['customer_category']=$this->common_model->select_active_drop_down('address_category_master',$this->session->userdata['logged_in']['company_id']);
            
            $data['print_type_wise_sales_coex']=$this->sales_invoice_book_model->select_dia_wise_saless($table,$from_date,date('Y-m-d'),'','','','','');
            
            //$data['print_type_wise_sales_coex']=$this->sales_invoice_book_model->select_print_type_wise_coex_sales_record($table,$from_date,date('Y-m-d'),'','','','','');
            //$data['print_type_wise_sales_spring']=$this->sales_invoice_book_model->select_print_type_wise_spring_sales_record($table,$from_date,date('Y-m-d'),'','','','','');

            //echo $this->db->last_query();
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/dia-wise-sales-new',$data);
            //$this->load->view(ucwords($this->router->fetch_class()).'/print-type-wise-sales_bkp_3jun2021',$data);
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
  
  

  function top_customer_sales(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'reports');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $table='ar_invoice_master';
            include('pagination.php');

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

            $data['top_customer_coex']=$this->sales_invoice_book_model->select_top_customer($table,$this->session->userdata['logged_in']['company_id'],$from_date,date('Y-m-d'),'','');

            //echo $this->db->last_query();
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/top-customer-sales',$data);
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


  function top_customer_sales_diawise(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'reports');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $table='ar_invoice_master';
            include('pagination.php');

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

            $data['top_customer_coex']=$this->sales_invoice_book_model->select_top_customer($table,$this->session->userdata['logged_in']['company_id'],$from_date,date('Y-m-d'),'','');


            //echo $this->db->last_query();
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/top-customer-sales-diawise',$data);
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


  function pending_sales_order_by_diameter(){
   
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_book');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $this->load->model('sales_invoice_book_model');

            $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

            $data['invoice_types_master_lang']=$this->common_model->select_active_drop_down('invoice_types_master_lang',$this->session->userdata['logged_in']['company_id']); 

            if($data['account_periods_master']==FALSE){
              $from_date="";
            }else{
              foreach($data['account_periods_master'] as $account_periods_master_row){
                $from_date=$account_periods_master_row->fin_year_start;
              }
            }

            $data['sales_order_summary']=$this->sales_order_book_model->pending_sales_order('order_master',$from_date,date('Y-m-d'));
            //echo $this->db->last_query();


            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/pending-sales-order',$data);
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



  function pending_sales_order_monthwise(){
   
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_book');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $this->load->model('sales_invoice_book_model');

            $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

            $data['invoice_types_master_lang']=$this->common_model->select_active_drop_down('invoice_types_master_lang',$this->session->userdata['logged_in']['company_id']); 

            if($data['account_periods_master']==FALSE){
              $from_date="";
            }else{
              foreach($data['account_periods_master'] as $account_periods_master_row){
                $from_date=$account_periods_master_row->fin_year_start;
                $new_from_date = date('Y-m-d',strtotime('-120 days', strtotime($account_periods_master_row->fin_year_start)));
                    

              }
            }

            $data['pending_sales_order']=$this->sales_order_book_model->pending_sales_order_monthwise('order_master',$new_from_date,date('Y-m-d'),'');
            //echo $this->db->last_query();

            
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/pending-sales-order-monthwise',$data);
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

function pending_sales_order_on_delivery_date(){
   
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_book');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $this->load->model('sales_invoice_book_model');

            $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

            $data['invoice_types_master_lang']=$this->common_model->select_active_drop_down('invoice_types_master_lang',$this->session->userdata['logged_in']['company_id']); 

            if($data['account_periods_master']==FALSE){
              $from_date="";
            }else{
              foreach($data['account_periods_master'] as $account_periods_master_row){
                $from_date=$account_periods_master_row->fin_year_start;
                $new_from_date = date('Y-m-d',strtotime('-120 days', strtotime($account_periods_master_row->fin_year_start)));

                $new_to_date = date('Y-m-d',strtotime('+180 days'));
                    

              }
            }

            $data['pending_sales_order']=$this->sales_order_book_model->pending_sales_order_on_delivery_date('order_master',$new_from_date,$new_to_date,'');
            //echo $this->db->last_query();

            
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/pending-sales-order-delivery',$data);
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


function pending_sales_order_on_oc_date(){
   
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_book');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $this->load->model('sales_invoice_book_model');

            $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

            $data['invoice_types_master_lang']=$this->common_model->select_active_drop_down('invoice_types_master_lang',$this->session->userdata['logged_in']['company_id']); 

            if($data['account_periods_master']==FALSE){
              $from_date="";
            }else{
              foreach($data['account_periods_master'] as $account_periods_master_row){
                $from_date=$account_periods_master_row->fin_year_start;
                $new_from_date = date('Y-m-d',strtotime('-120 days', strtotime($account_periods_master_row->fin_year_start)));

                $new_to_date = date('Y-m-d',strtotime('+180 days'));
                    

              }
            }

            $data['pending_sales_order']=$this->sales_order_book_model->pending_sales_order_on_oc_date('order_master',$new_from_date,$new_to_date,'');
            //echo $this->db->last_query();
            $data['pending_sales_order_without_oc']=$this->sales_order_book_model->pending_sales_order_monthwise_without_oc('order_master',$new_from_date,$new_to_date,'');
            

            
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/pending-sales-order-on-oc',$data);
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
  
function approved_unapproved_pending_sales_order_on_delivery_date(){
   
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_book');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $this->load->model('sales_invoice_book_model');

            $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

            $data['invoice_types_master_lang']=$this->common_model->select_active_drop_down('invoice_types_master_lang',$this->session->userdata['logged_in']['company_id']); 

            if($data['account_periods_master']==FALSE){
              $from_date="";
            }else{
              foreach($data['account_periods_master'] as $account_periods_master_row){
                $from_date=$account_periods_master_row->fin_year_start;
                $new_from_date = date('Y-m-d',strtotime('-120 days', strtotime($account_periods_master_row->fin_year_start)));

                $new_to_date = date('Y-m-d',strtotime('+180 days'));
                    

              }
            }

            $data['pending_sales_order']=$this->sales_order_book_model->approved_unapproved_pending_sales_order_delivery_date('order_master',$new_from_date,$new_to_date,'','');
           // echo $this->db->last_query();

            
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/approved-unapproved-pending-sales-order-delivery',$data);
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


  function pending_sales_order_by_customer(){
   
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_book');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $this->load->model('sales_invoice_book_model');

            $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

            $data['invoice_types_master_lang']=$this->common_model->select_active_drop_down('invoice_types_master_lang',$this->session->userdata['logged_in']['company_id']); 

            if($data['account_periods_master']==FALSE){
              $from_date="";
            }else{
              foreach($data['account_periods_master'] as $account_periods_master_row){
                $from_date=$account_periods_master_row->fin_year_start;
                $new_from_date = date('Y-m-d', strtotime('-120 days', strtotime($from_date)));
              }
            }

            $data['pending_sales_order']=$this->sales_order_book_model->pending_sales_order_by_customer('order_master',$new_from_date,date('Y-m-d'));
            //echo $this->db->last_query();

            
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/pending-sales-order-customer',$data);
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


  function cap_forecast_by_cap_code(){
   
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'reports');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $this->load->model('sales_invoice_book_model');

            $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

            $data['invoice_types_master_lang']=$this->common_model->select_active_drop_down('invoice_types_master_lang',$this->session->userdata['logged_in']['company_id']); 

            if($data['account_periods_master']==FALSE){
              $from_date="";
            }else{
              foreach($data['account_periods_master'] as $account_periods_master_row){
                $from_date=$account_periods_master_row->fin_year_start;
                $new_from_date = date('Y-m-d', strtotime('-120 days',strtotime($account_periods_master_row->fin_year_start)));
              }
            }

            $data['pending_sales_order']=$this->sales_order_book_model->pending_sales_order_by_customer_with_cap('order_master',$new_from_date,date('Y-m-d'),$cap_code="");
            //echo $this->db->last_query();

            
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/pending-sales-order-cap',$data);
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


  function cap_forecast_by_customer(){
   
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'reports');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $this->load->model('sales_invoice_book_model');

            $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

            $data['invoice_types_master_lang']=$this->common_model->select_active_drop_down('invoice_types_master_lang',$this->session->userdata['logged_in']['company_id']); 

            if($data['account_periods_master']==FALSE){
              $from_date="";
            }else{
              foreach($data['account_periods_master'] as $account_periods_master_row){
                $from_date=$account_periods_master_row->fin_year_start;
                $new_from_date = date('Y-m-d', strtotime('-120 days',strtotime($account_periods_master_row->fin_year_start)));
              }
            }

            $data['pending_sales_order']=$this->sales_order_book_model->pending_sales_order_cap_by_customer('order_master',$new_from_date,date('Y-m-d'),$customer="");
            
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/pending-sales-order-cap-by-customer',$data);
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



  function production_monthwise(){
   
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_book');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

            $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

            if($data['account_periods_master']==FALSE){
              $from_date="";
            }else{
              foreach($data['account_periods_master'] as $account_periods_master_row){
                $from_date=$account_periods_master_row->fin_year_start;
              }
            }

            $CI = &get_instance();

            $this->db2= $CI->load->database('another_db', TRUE);

            $this->load->model('production_model');
            $data['extrusion']=$this->production_model->select_extrusion_monthwise('extrusion',$this->session->userdata['logged_in']['company_id'],$from_date,date('Y-m-d'));


            $data['heading']=$this->production_model->select_heading_monthwise('heading',$this->session->userdata['logged_in']['company_id'],$from_date,date('Y-m-d'));

            $data['printing']=$this->production_model->select_printing_monthwise('printing',$this->session->userdata['logged_in']['company_id'],$from_date,date('Y-m-d'));

            $data['labeling']=$this->production_model->select_labeling_monthwise('labeling',$this->session->userdata['logged_in']['company_id'],$from_date,date('Y-m-d'));

            $data['capping']=$this->production_model->select_capping_monthwise('capping',$this->session->userdata['logged_in']['company_id'],$from_date,date('Y-m-d'));
            
            $data['foiling']=$this->production_model->select_foiling_monthwise('foiling',$this->session->userdata['logged_in']['company_id'],$from_date,date('Y-m-d'));

            
            // Springtube production------------------
            $data['spring_extrusion']=$this->production_model->select_spring_extrusion_monthwise('springtube_extrusion_production_master',$this->session->userdata['logged_in']['company_id'],$from_date,date('Y-m-d'));


            $data['spring_printing']=$this->production_model->select_spring_printing_monthwise('springtube_printing_production_master',$this->session->userdata['logged_in']['company_id'],$from_date,date('Y-m-d'));

            $data['spring_bodymaking']=$this->production_model->select_spring_bodymaking_monthwise('springtube_bodymaking_production_master',$this->session->userdata['logged_in']['company_id'],$from_date,date('Y-m-d'));

           
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/production-monthwise',$data);
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



  function dashboard_sales(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'reports');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $table='ar_invoice_master';
            $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
            if($data['account_periods_master']==FALSE){
              $from_date="";
            }else{
              foreach($data['account_periods_master'] as $account_periods_master_row){
                $from_date_fin=$account_periods_master_row->fin_year_start;
                $from_date=date('Y-m-01');
              }
            }

            $data['print_type_wise_sales_coex']=$this->sales_invoice_book_model->select_print_type_wise_diawise_sales($table,$from_date,date('Y-m-d'),'','','','','');

            if(strtoupper(date('M',strtotime("".date("Y-m-01")." -1 month")))=="FEB"){
              $data['print_type_wise_sales_coex_last_month']=$this->sales_invoice_book_model->select_print_type_wise_diawise_sales($table,date("Y-m-01",strtotime("".date("Y-m-01")." -1 month")),date('Y-m-t',strtotime(date('Y-m')."-1 month")),'','','','','');
            }else{
              $data['print_type_wise_sales_coex_last_month']=$this->sales_invoice_book_model->select_print_type_wise_diawise_sales($table,date("Y-m-01",strtotime("-1 month")),date('Y-m-d',strtotime("-1 month")),'','','','','');
            }
            
            



           //echo $this->db->last_query();

            $data['print_type_wise_sales_coex_2ndlast_month']=$this->sales_invoice_book_model->select_print_type_wise_diawise_sales($table,date("Y-m-01",strtotime("-2 month")),date('Y-m-d',strtotime("-2 month")),'','','','','');

            $data['print_type_wise_sales_coex_3rdlast_month']=$this->sales_invoice_book_model->select_print_type_wise_diawise_sales($table,date("Y-m-01",strtotime("-3 month")),date('Y-m-d',strtotime("-3 month")),'','','','','');

            $data['print_type_wise_sales_coex_total_year']=$this->sales_invoice_book_model->select_print_type_wise_diawise_sales($table,$from_date_fin,date('Y-m-d'),'','','','','');
            $this->load->model('costsheet_model');
            
            $this->load->model('costsheet_model');
            $cdata=array('status_flag'=>'1');
            $data['contribution']=$this->costsheet_model->select_contriubution('costsheet_master',$from_date,date('Y-m-d'),$cdata);

            $data['contribution_last_month']=$this->costsheet_model->select_contriubution('costsheet_master',date("Y-m-01",strtotime("-1 month")),date('Y-m-d',strtotime("-1 month")),$cdata);
            
            $CI = &get_instance();

            $this->db2= $CI->load->database('another_db', TRUE);
            $this->load->model('production_model');
            $data['printing']=$this->production_model->select_printing_monthwise('printing',$this->session->userdata['logged_in']['company_id'],$from_date,date('Y-m-d'));

            $data['spring_printing']=$this->production_model->select_spring_printing_monthwise('springtube_printing_production_details',$this->session->userdata['logged_in']['company_id'],$from_date,date('Y-m-d'));
            
            $data['labeling']=$this->production_model->select_labeling_monthwise('labeling',$this->session->userdata['logged_in']['company_id'],$from_date,date('Y-m-d'));

            $data['printing_last_month']=$this->production_model->select_printing_monthwise('printing',$this->session->userdata['logged_in']['company_id'],date("Y-m-01",strtotime("-1 month")),date('Y-m-d',strtotime("-1 month")));

            $data['spring_printing_last_month']=$this->production_model->select_spring_printing_monthwise('springtube_printing_production_details',$this->session->userdata['logged_in']['company_id'],date("Y-m-01",strtotime("-1 month")),date('Y-m-d',strtotime("-1 month")));
            
            $data['labeling_last_month']=$this->production_model->select_labeling_monthwise('labeling',$this->session->userdata['logged_in']['company_id'],date("Y-m-01",strtotime("-1 month")),date('Y-m-d',strtotime("-1 month")));

            $data['printing_2ndlast_month']=$this->production_model->select_printing_monthwise('printing',$this->session->userdata['logged_in']['company_id'],date("Y-m-01",strtotime("-2 month")),date('Y-m-d',strtotime("-2 month")));

            $data['spring_printing_2ndlast_month']=$this->production_model->select_spring_printing_monthwise('springtube_printing_production_details',$this->session->userdata['logged_in']['company_id'],date("Y-m-01",strtotime("-2 month")),date('Y-m-d',strtotime("-2 month")));
            
            $data['labeling_2ndlast_month']=$this->production_model->select_labeling_monthwise('labeling',$this->session->userdata['logged_in']['company_id'],date("Y-m-01",strtotime("-2 month")),date('Y-m-d',strtotime("-2 month")));

            $data['printing_3rdlast_month']=$this->production_model->select_printing_monthwise('printing',$this->session->userdata['logged_in']['company_id'],date("Y-m-01",strtotime("-3 month")),date('Y-m-d',strtotime("-3 month")));

            $data['spring_printing_3rdlast_month']=$this->production_model->select_spring_printing_monthwise('springtube_printing_production_details',$this->session->userdata['logged_in']['company_id'],date("Y-m-01",strtotime("-3 month")),date('Y-m-d',strtotime("-3 month")));
            
            $data['labeling_3rdlast_month']=$this->production_model->select_labeling_monthwise('labeling',$this->session->userdata['logged_in']['company_id'],date("Y-m-01",strtotime("-3 month")),date('Y-m-d',strtotime("-3 month")));

            $data['printing_total_year']=$this->production_model->select_printing_monthwise('printing',$this->session->userdata['logged_in']['company_id'],$from_date_fin,date('Y-m-d'));

            $data['labeling_total_year']=$this->production_model->select_labeling_monthwise('labeling',$this->session->userdata['logged_in']['company_id'],$from_date_fin,date('Y-m-d'));

            $data['spring_printing_total_year']=$this->production_model->select_spring_printing_monthwise('springtube_printing_production_details',$this->session->userdata['logged_in']['company_id'],$from_date_fin,date('Y-m-d'));

            $data['top_customer_coex']=$this->sales_invoice_book_model->select_top_customer($table,$this->session->userdata['logged_in']['company_id'],$from_date,date('Y-m-d'),'','');


            $data['print_type_wise_sales_domestic']=$this->sales_invoice_book_model->select_print_type_wise_sales($table,$from_date,date('Y-m-d'),'','','','','1,2,8');
            $data['print_type_wise_sales_export_local']=$this->sales_invoice_book_model->select_print_type_wise_sales($table,$from_date,date('Y-m-d'),'','','','','3');
            
            $data['print_type_wise_sales_export_fze']=$this->sales_invoice_book_model->select_print_type_wise_sales($table,$from_date,date('Y-m-d'),'','','','','11');

            $data['pending_sales_order_opening']=$this->sales_order_book_model->pending_sales_order_monthwise('order_master','2020-04-01',date('Y-m-d', strtotime('-1 day', strtotime($from_date))),'');

            //echo $this->db->last_query();

            $data['pending_sales_order']=$this->sales_order_book_model->pending_sales_order_monthwise('order_master',$from_date,date('Y-m-d'),'');

            $data['print_type_wise_sales_coex_m']=$this->sales_invoice_book_model->select_print_type_wise_sales($table,$from_date,date('Y-m-d'),'','','','','');

            $data['order_dispatched_count']=$this->sales_invoice_book_model->sales_total_order_dispathed_count($from_date,date('Y-m-d'));
            $data['order_completed_dispatched_count']=$this->sales_invoice_book_model->sales_total_order_completed_count($from_date,date('Y-m-d'));
            $data['order_short_completed_dispatched_count']=$this->sales_invoice_book_model->sales_total_order_short_completed_count($from_date,date('Y-m-d'));

            $data['open_order_count']=$this->sales_invoice_book_model->sales_open_order_count($from_date,date('Y-m-d'));

            $data['order_completed_dispatched_volume']=$this->sales_invoice_book_model->sales_total_order_completed_volume($from_date,date('Y-m-d'));
            $data['order_open_dispatched_volume']=$this->sales_invoice_book_model->sales_total_open_order_dispatch_volume($from_date,date('Y-m-d'));
            $data['order_short_completed_dispatched_volume']=$this->sales_invoice_book_model->sales_total_short_completed_volume($from_date,date('Y-m-d'));


            $data['sales_total_order_completed_net']=$this->sales_invoice_book_model->sales_total_order_completed_net($from_date,date('Y-m-d'));

            $data['sales_total_order_short_completed_net']=$this->sales_invoice_book_model->sales_total_order_short_completed_net($from_date,date('Y-m-d'));

            include('pagination.php');
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/dashboard-sales',$data);
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



  function dashboard_production(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'reports');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
            if($data['account_periods_master']==FALSE){
              $from_date="";
            }else{
              foreach($data['account_periods_master'] as $account_periods_master_row){
                $from_date_fin=$account_periods_master_row->fin_year_start;
                $from_date=date('Y-m-01');
              }
            }
            $this->load->model('coex_runtime_downtime_model');
            $dataa = array('process_id' =>'1');
            $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
            
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/dashboard-production',$data);
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


  function print_type_wise_sales_order(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'reports');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $table='ar_invoice_master';
            include('pagination.php');

            $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
            

            if($data['account_periods_master']==FALSE){
              $from_date="";
            }else{
              foreach($data['account_periods_master'] as $account_periods_master_row){
                $from_date=$account_periods_master_row->fin_year_start;
              }
            }

            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

            $data['print_type_wise_sales_order']=$this->sales_order_book_model->print_type_wise_sales_order($table,$from_date,date('Y-m-d'));
            
            //echo $this->db->last_query();
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/print-type-wise-sales-order',$data);
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


  function print_type_wise_total_sales_order_on_delivery_date(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'reports');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $table='ar_invoice_master';
            include('pagination.php');

            $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
            

            if($data['account_periods_master']==FALSE){
              $from_date="";
            }else{
              foreach($data['account_periods_master'] as $account_periods_master_row){
                $from_date=$account_periods_master_row->fin_year_start;
                $new_from_date = date('Y-m-d',strtotime('-120 days', strtotime($account_periods_master_row->fin_year_start)));
                $new_to_date = date('Y-m-d',strtotime('+180 days'));
              }
            }

            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

            $data['print_type_wise_sales_order']=$this->sales_order_book_model->print_type_wise_total_sales_order_on_delivery_date($table,$new_from_date,$new_to_date);
            
            //echo $this->db->last_query();
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/print-type-wise-sales-order-on-delivery-date',$data);
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

  function total_order_received_by_customer(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'reports');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

            $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
            

            if($data['account_periods_master']==FALSE){
              $from_date="";
            }else{
              foreach($data['account_periods_master'] as $account_periods_master_row){
                $from_date=$account_periods_master_row->fin_year_start;
              }
            }

            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

            $data['total_order_received_by_customer']=$this->sales_order_book_model->total_order_received_by_customer('order_master',$from_date,date('Y-m-d'),'');
            
            //echo $this->db->last_query();
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/total-order-received-by-customer',$data);
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


  function total_order_received_by_customer_on_order_date(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'reports');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

            $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
            

            if($data['account_periods_master']==FALSE){
              $from_date="";
            }else{
              foreach($data['account_periods_master'] as $account_periods_master_row){
                $from_date=$account_periods_master_row->fin_year_start;
              }
            }

            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

            $data['total_order_received_by_customer']=$this->sales_order_book_model->total_order_received_by_customer_on_order_date('order_master',$from_date,date('Y-m-d'),'');
            
            //echo $this->db->last_query();
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/total-order-received-by-customer-on-order-date',$data);
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

  function top_products_costsheet(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'reports');

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
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/top-products-costsheet',$data);
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

  function avg_dia(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'reports');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            
            //include('pagination.php');

            //$data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','printing_group',$this->session->userdata['logged_in']['company_id']);
            $data['customer_category']=$this->common_model->select_active_drop_down('address_category_master',$this->session->userdata['logged_in']['company_id']);
            

            //$data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            
            //$data['invoice_types_master_lang']=$this->common_model->select_active_drop_down('invoice_types_master_lang',$this->session->userdata['logged_in']['company_id']); 

            $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

            if($data['account_periods_master']==FALSE){
              $from_date="";
            }else{
              foreach($data['account_periods_master'] as $account_periods_master_row){
                $from_date=$account_periods_master_row->fin_year_start;
              }
            }
            // Current year---------------
            $data['sales_avg_dia']=$this->sales_invoice_book_model->sales_avg_dia($from_date,date('Y-m-d'),'');

            // Last Year-----------------
            $from_date_last=date("Y-m-d", strtotime("-1 year", strtotime($from_date)));
            $to_date_last=date("Y-m-d", strtotime("-1 year"));
            $data['sales_avg_dia_last_year']=$this->sales_invoice_book_model->sales_avg_dia($from_date_last,$to_date_last,'');
            //echo $this->db->last_query();
            // Prevoius Year--------------
            $from_date_prev=date("Y-m-d", strtotime("-2 year", strtotime($from_date)));
            $to_date_prev=date("Y-m-d", strtotime("-2 year"));
            $data['sales_avg_dia_prev_year']=$this->sales_invoice_book_model->sales_avg_dia($from_date_prev,$to_date_prev,'');

            //echo $this->db->last_query();
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/sales-avg-dia',$data);
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

  function sales_report_pcb(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_invoice_book');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $table='ar_invoice_master';
            include('pagination.php');
            
            $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

            if($data['account_periods_master']==FALSE){
              $from_date="";
            }else{
              foreach($data['account_periods_master'] as $account_periods_master_row){
                $from_date=$account_periods_master_row->fin_year_start;
              }
            }
                    
            $from="2018-04-01";
            $to=date('Y-m-d');
            $search="";
            $data['ar_invoice_master']=$this->sales_invoice_book_model->active_record_search_index_report($config["per_page"],$this->uri->segment(3),'ar_invoice_master',$search,$from,$to,$this->session->userdata['logged_in']['company_id']);
            //echo $this->db->last_query();
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            //$this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/sales-report-pcb',$data);
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