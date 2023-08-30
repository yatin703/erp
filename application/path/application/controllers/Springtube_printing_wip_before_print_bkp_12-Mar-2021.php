<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Springtube_printing_wip_before_print extends CI_Controller {

  function __construct(){    
    parent::__construct();
    if($this->session->userdata('logged_in')){
      
      $this->load->model('common_model');
      $this->load->model('article_model');
      $this->load->model('customer_model');
      $this->load->model('sales_order_book_model');
      $this->load->model('sales_order_status_model');
      $this->load->model('artwork_springtube_model');
      $this->load->model('springtube_printing_wip_before_print_model');
      $this->load->model('artwork_model');
      $this->load->model('fiscal_model');
      $this->load->model('process_model');
      $this->load->model('artwork_springtube_model');
      
      
    }else{
      redirect('login','refresh');
    }
  }

  function index(){
    
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){

              $table='springtube_printing_wip_master_before';
              include('pagination_wip.php');
              $data['springtube_printing_wip_master_before']=$this->springtube_printing_wip_before_print_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
             
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
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
      $data['note']='No rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }

  }


  function archive_records(){
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
          //print_r( $data['formrights']);

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

              $table='springtube_printing_wip_master_before';
              include('pagination_archive.php');
              $data['springtube_printing_wip_master_before']=$this->springtube_printing_wip_before_print_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/archive-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/archive-records',$data);
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

  

  function search(){    
    
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){


              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              
              $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);

              $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

              $data_search=array('springtube_printing_wip_master_before.status'=>0);
              $data['springtube_printing_wip_master_before']=$this->springtube_printing_wip_before_print_model->active_record_search('springtube_printing_wip_master_before',$this->session->userdata['logged_in']['company_id'],$data_search,$this->input->get('from_date'),$this->input->get('to_date')); 
             
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
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
      $data['note']='No rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }

  }


  function search_result(){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

            $this->form_validation->set_rules('from_date','From Date' ,'trim|xss_clean|exact_length[10]');
            $this->form_validation->set_rules('to_date','To Date' ,'trim|xss_clean|exact_length[10]');
            $this->form_validation->set_rules('order_no','Order No.' ,'trim|xss_clean');        
            $this->form_validation->set_rules('jobcard_no','Jobcard No.' ,'trim|xss_clean');
            $this->form_validation->set_rules('sleeve_dia','Sleeve Dia' ,'trim|xss_clean');
            $this->form_validation->set_rules('sleeve_length','Sleeve Length' ,'trim|xss_clean');
            $this->form_validation->set_rules('article_no','article_no' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('film_code','Film Code' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('film_masterbatch_two','Second Layer MB' ,'trim|xss_clean');
            $this->form_validation->set_rules('film_masterbatch_six','Sixth Layer MB' ,'trim|xss_clean');
            $this->form_validation->set_rules('customer','Customer' ,'trim|xss_clean|callback_customer_check');
            $this->form_validation->set_rules('from_order_no','From Stock SO.' ,'trim|xss_clean'); 
                       
            if($this->form_validation->run()==FALSE){

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
              $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
              $this->load->view('Home/footer');
            }else{              
              
              
              $data_search=array();
              if($this->input->post('jobcard_no')!=''){
                $data_search['springtube_printing_wip_master_before.jobcard_no']=$this->input->post('jobcard_no');
              }
              if($this->input->post('customer')!=''){
                $customer_arr=explode("//",$this->input->post('article_no'));
                $data_search['springtube_printing_wip_master_before.customer']=$customer_arr[1];
              }


              if($this->input->post('order_no')!=''){
                $data_search['springtube_printing_wip_master_before.order_no']=$this->input->post('order_no');
              }
              if($this->input->post('sleeve_dia')!=''){
                $sleeve_dia_arr=explode("//", $this->input->post('sleeve_dia'));
                $data_search['springtube_printing_wip_master_before.sleeve_dia']=$sleeve_dia_arr[0];
              }
              if($this->input->post('sleeve_length')!=''){
                $data_search['springtube_printing_wip_master_before.sleeve_length']=$this->input->post('sleeve_length');
              }
              if($this->input->post('article_no')!=''){
                $article_arr=explode("//",$this->input->post('article_no'));
                $data_search['springtube_printing_wip_master_before.article_no']=$article_arr[1];
              }
              if($this->input->post('film_code')!=''){
                $film_code_arr=explode("//",$this->input->post('film_code'));
                $data_search['springtube_printing_wip_master_before.film_code']=$film_code_arr[1];
              }
              if($this->input->post('total_microns')!=''){
                $data_search['springtube_printing_wip_master_before.total_microns']=$this->input->post('total_microns');
              }
              if($this->input->post('film_masterbatch_two')!=''){
                $data_search['springtube_printing_wip_master_before.second_layer_mb']=$this->input->post('film_masterbatch_two');
              }
              if($this->input->post('film_masterbatch_six')!=''){
                $data_search['springtube_printing_wip_master_before.sixth_layer_mb']=$this->input->post('film_masterbatch_six');
              }

              if($this->input->post('from_order_no')!=''){
                $data_search['springtube_extrusion_wip_master.order_no']=$this->input->post('from_order_no');
              }
              if($this->input->post('status')!=''){
                $data_search['springtube_printing_wip_master_before.status']=$this->input->post('status');
              }
             

              $data['springtube_printing_wip_master_before']=$this->springtube_printing_wip_before_print_model->active_record_search('springtube_printing_wip_master_before',$this->session->userdata['logged_in']['company_id'],$data_search,$this->input->post('from_date'),$this->input->post('to_date'));
              //echo $this->db->last_query();             

              $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);                
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
              $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
               

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
                $this->load->view('Home/footer');                             
            }

          }else{
            $data['note']='No New rights Thanks';
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
      $data['note']='No New rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  }

  function search_wip(){    
    
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){


              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());      

              
             
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form-wip',$data);
              //$this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
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
      $data['note']='No rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }

  }

  function search_result_wip(){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

            $this->form_validation->set_rules('from_date','From Date' ,'trim|xss_clean|exact_length[10]');
            $this->form_validation->set_rules('to_date','To Date' ,'trim|xss_clean|exact_length[10]');
              
                       
            if($this->form_validation->run()==FALSE){

               
              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
              $this->load->view('Home/footer');
            }else{              
              
              
              
             
              $data_search=array();
              $data['springtube_printing_wip_master_before']=$this->springtube_printing_wip_before_print_model->active_record_search_wip('springtube_printing_wip_master_before',$this->session->userdata['logged_in']['company_id'],$data_search,$this->input->post('from_date'),$this->input->post('to_date'));             

              $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);                
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/search-form-wip',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/active-records-wip',$data);
                $this->load->view('Home/footer');                             
            }

          }else{
            $data['note']='No New rights Thanks';
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
      $data['note']='No New rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  }


  

  public function article_check($str){
    
      if(!empty($str)){
      $item_code=explode('//',$str);
      if(!empty($item_code[1])){
      $data['item']=$this->common_model->select_one_active_record_nonlanguage_without_archive('article_name_info',$this->session->userdata['logged_in']['company_id'],'article_no',$item_code[1]);
      //echo $this->db->last_query();

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

    function customer_check($str){

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

  function create_printing_jobcard(){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {

      if($module_row->module_name==='Production'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $data=array(
              'final_approval_flag'=>'1',
              'order_no'=>$this->uri->segment(3),
              'trans_closed'=>'0',
              'order_closed <>'=>'1',
              'hold_flag'=>'0');

            $data['order']=$this->sales_order_book_model->active_details_records('order_master',$data,$this->session->userdata['logged_in']['company_id']);
            //echo $this->db->last_query();

            $dataa=array('order_no'=>$this->uri->segment(3),
              'article_no'=>$this->uri->segment(4));

            $data['order_details']=$this->common_model->select_one_active_record_nonlanguage_without_archives('order_details',$this->session->userdata['logged_in']['company_id'],$dataa);

            //-------------------------------------------------------

            $data_bwip_search=array('order_no'=>$this->uri->segment(3),
              'article_no'=>$this->uri->segment(4),
              'status'=>'0',
              'archive'=>0
            );

            $data['springtube_printing_wip_master_before']=$this->common_model->select_active_records_where('springtube_printing_wip_master_before',$this->session->userdata['logged_in']['company_id'],$data_bwip_search);

            //-------------------------------------------------------

            $data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_details.property_id','1');

            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','75');

            $data['page_name']='Sales';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
            $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_item_parameterwise');
              
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/create-print-jobcard-form',$data);
              $this->load->view('Home/footer');
          }else{
              $data['note']='No Create rights Thanks';
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view('Error/error-title',$data);
              $this->load->view('Home/footer');
          }
        }
      }
    }
  }else{
      $data['note']='No Create rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  
  }

  function save_printing_jobcard(){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {

      if($module_row->module_name==='Production'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $this->form_validation->set_rules('order_no','Order No' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('article_no','Product Code' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('spec_no','Spec No' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('spec_version_no','Spec Version No' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('artwork_no','Artwork No' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('artwork_version_no','Artwork Version No' ,'required|trim|xss_clean');

            $this->form_validation->set_rules('total_bprint_wip_meters','Total Meters released for Printing ' ,'required|trim|xss_clean|greater_than[0]');
            $this->form_validation->set_rules('total_bprint_wip_qty','Total Qty released for Printing' ,'required|trim|xss_clean|greater_than[0]');
            $this->form_validation->set_rules('release_meters','No. of Meters taken for Printing Job Card' ,'required|trim|xss_clean|greater_than[0]');
            $this->form_validation->set_rules('release_qty','Printing Job Card Quantity' ,'required|trim|xss_clean|greater_than[0]');

            if($this->form_validation->run()===FALSE){

              $data=array(
              'final_approval_flag'=>'1',
              'order_no'=>$this->input->post('order_no'),
              'trans_closed'=>'0',
              'order_closed <>'=>'1',
              'hold_flag'=>'0');

              $data['order']=$this->sales_order_book_model->active_details_records('order_master',$data,$this->session->userdata['logged_in']['company_id']);
              //echo $this->db->last_query();

              $dataa=array('order_no'=>$this->input->post('order_no'),
                'article_no'=>$this->input->post('article_no'));

              $data['order_details']=$this->common_model->select_one_active_record_nonlanguage_without_archives('order_details',$this->session->userdata['logged_in']['company_id'],$dataa);

              //-------------------------------------------------------

              $data_bwip_search=array('order_no'=>$this->input->post('order_no'),
                'article_no'=>$this->input->post('article_no'),
                'status'=>'0','archive'=>0);

              $data['springtube_printing_wip_master_before']=$this->common_model->select_active_records_where('springtube_printing_wip_master_before',$this->session->userdata['logged_in']['company_id'],$data_bwip_search);

              //-------------------------------------------------------
              $data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_details.property_id','1');

              $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','75');

              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_item_parameterwise');
              
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/create-print-jobcard-form',$data);
              $this->load->view('Home/footer'); 
              
            }else{

              // Form ID---------------------

              $form_id='103333';
              $jobcard_type='2';// Printing

              $order_no= $this->input->post('order_no');
              $article_no=$this->input->post('article_no');
              $total_bprint_wip_meters=$this->input->post('total_bprint_wip_meters');
              $total_bprint_wip_qty=$this->input->post('total_bprint_wip_qty');
              $release_meters=$this->input->post('release_meters');
              $release_qty=$this->input->post('release_qty'); 

              $reel_length=$this->config->item('springtube_reel_length');
              $no_of_reels=$release_meters/$reel_length;

              $data['auto']=$this->common_model->select_one_active_record_nonlanguage_without_archive('autogeneration_format_master',$this->session->userdata['logged_in']['company_id'],'form_id',$form_id);
              
              $no="";
              foreach ($data['auto'] as $auto_row) {

                $data['account_periods']=$this->common_model->select_one_active_record_nonlanguage_without_archive('account_periods_master',$this->session->userdata['logged_in']['company_id'],'finyear_close_opt','0');
                foreach($data['account_periods'] as $account_periods_row){
                  $start=date('y', strtotime($account_periods_row->fin_year_start));
                  $end=date('y', strtotime($account_periods_row->fin_year_end));
                }
                $no=str_pad($auto_row->curr_val,4,"0",STR_PAD_LEFT);
                $jobcard_no=$auto_row->textcode.$auto_row->seperator.$start.$auto_row->seperator.$end.$auto_row->seperator.$no;
                $next_jobcard_no=$auto_row->curr_val+1;
              }

              $data=array('curr_val'=>$next_jobcard_no);              
              $this->common_model->update_one_active_record('autogeneration_format_master',$data,'form_id',$form_id,$this->session->userdata['logged_in']['company_id']);


              $data['max']=$this->common_model->select_max_pkey_numeric('production_master','manu_order_no',$this->session->userdata['logged_in']['company_id']);
              foreach($data['max'] as $max_value){
                $manu_order_no=$max_value->manu_order_no+1;
              }

              $data=array('manu_order_no'=>$manu_order_no,
                'company_id'=>$this->session->userdata['logged_in']['company_id'],
                'mp_pos_no'=>$jobcard_no,
                'article_no'=>$this->input->post('article_no'),
                'mp_qty'=>$this->common_model->save_number($this->input->post('order_qty'),$this->session->userdata['logged_in']['company_id']),
                'actual_qty_manufactured'=>$this->common_model->save_number($release_qty,$this->session->userdata['logged_in']['company_id']),
                'manu_plan_date'=>date('Y-m-d'),
                'employee_id'=>$this->session->userdata['logged_in']['user_id'],
                'sales_ord_no'=>$this->input->post('order_no'),
                'ord_pos_no'=>$this->input->post('ord_pos_no'),
                'jobcard_type'=>$jobcard_type,
                'no_of_reels'=>$no_of_reels,
                'reel_length'=>$reel_length,
                'total_meters'=>$release_meters
                );

               $result=$this->common_model->save('production_master',$data);

              if($result){

                $data=array('curr_val'=>$next_jobcard_no);              
                $this->common_model->update_one_active_record('autogeneration_format_master',$data,'form_id',$form_id,$this->session->userdata['logged_in']['company_id']);
              
                $data_order_details=array(
                  'order_no'=>$order_no,
                  'article_no'=>$article_no
                  );

                $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
                foreach($order_details_result as $order_details_row){
                  $bom_no=$order_details_row->spec_id;
                  $bom_version_no=$order_details_row->spec_version_no;
                }

                $data=array('bom_no'=>$bom_no,'bom_version_no'=>$bom_version_no);

                $bill_of_material_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data);

                foreach ($bill_of_material_result as $bill_of_material_row) {
                  $bom_id=$bill_of_material_row->bom_id;
                  $film_code=$bill_of_material_row->sleeve_code;
                   
                } 
                //SLEEVE---------------------------------

                $film_spec_id='';
                $film_spec_version='';

                $film_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$film_code);

                foreach($film_code_result as $film_code_row){                   
                  $film_spec_id=$film_code_row->spec_id;
                  $film_spec_version=$film_code_row->spec_version_no;
                }

                $specs['spec_id']=$film_spec_id;
                $specs['spec_version_no']=$film_spec_version;

                $specs_result=$this->sales_order_book_model->select_film_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$specs);
                
                $total_microns=0;
                $sleeve_id='';
                if($specs_result){                      

                  foreach($specs_result as $specs_row){
                      $sleeve_diameter=$specs_row->SLEEVE_DIA;
                      $sleeve_length=$specs_row->SLEEVE_LENGTH;
                      // $sleeve_mb_2=$specs_row->FILM_MASTER_BATCH_2;
                      // $sleeve_mb_6=$specs_row->FILM_MASTER_BATCH_6; 
                      // $micron_1=$specs_row->FILM_GUAGE_1;
                      // $micron_2=$specs_row->FILM_GUAGE_2; 
                      // $micron_3=$specs_row->FILM_GUAGE_3; 
                      // $micron_4=$specs_row->FILM_GUAGE_4; 
                      // $micron_5=$specs_row->FILM_GUAGE_5;       
                      // $micron_6=$specs_row->FILM_GUAGE_6; 
                      // $micron_7=$specs_row->FILM_GUAGE_7; 

                  }

                  $data['sleeve_diameter_master']=$this->common_model->select_one_active_record('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id'],'sleeve_diameter',$sleeve_diameter);
                  foreach($data['sleeve_diameter_master'] as $sleeve_dia_row){
                    $sleeve_id=$sleeve_dia_row->sleeve_id;
                  }

                }


                if($this->input->post('artwork_no')!='' && $this->input->post('artwork_version_no')!=''){

                  //WIP RATE and Material IN JOBCARD STARTED----

                  $part_pos_no=1;

                  if($this->input->post('film_code')!='' && $this->input->post('bwip_cost_per_meter')!=''){
                    //echo $this->input->post('film_code');
                    //echo $this->input->post('bwip_cost_per_meter');

                    $data['max_mm']=$this->common_model->select_max_pkey_numeric('material_manufacturing','mm_id',$this->session->userdata['logged_in']['company_id']);
                    foreach($data['max_mm'] as $max_mm_row){
                      $mm_id=$max_mm_row->mm_id+1;
                    }

                    $data=array(
                      'manu_order_no'=>$jobcard_no,
                      'article_no'=>$this->input->post('film_code'),
                      'demand_qty'=>$this->common_model->save_number($release_meters,$this->session->userdata['logged_in']['company_id']),
                      'company_id'=>$this->session->userdata['logged_in']['company_id'],
                      'work_proc_no'=>'1',
                      'from_job_card'=>'1',
                      'rel_demand_qty'=>$this->common_model->save_number($release_meters*1000,$this->session->userdata['logged_in']['company_id']),
                      'flag_uom_type'=>'1',
                      'mm_id'=>$mm_id,
                      'rel_uom_id'=>'UOM004',
                      'completed_flag'=>'1',
                      'calculated_purchase_price'=>$this->common_model->save_number($this->input->post('bwip_cost_per_meter'),$this->session->userdata['logged_in']['company_id']),
                      'sfg_flag'=>1,
                      'part_pos_no'=>$part_pos_no++
                    );

                    // print_r($data);
                    // exit;

                    $result=$this->common_model->save('material_manufacturing',$data);
                    


                    if($result){

                      $result_pos_no=$this->common_model->select_max_pkey_noncompany('reserved_quantity_manu','pos_no');

                      if($result_pos_no){
                        foreach($result_pos_no as $result_pos_no_row){
                          $pos_no=$result_pos_no_row->pos_no;
                          $pos_no=$pos_no+1;
                        }
                      }

                      $amt_manual=round(($release_meters*$this->input->post('bwip_cost_per_meter')),2);  

                      $data=array(
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'manu_order_no'=>$jobcard_no,
                        'sales_order_no'=>$order_no,
                        'qty'=>$this->common_model->save_number($release_meters,$this->session->userdata['logged_in']['company_id']),
                        'date_required'=>date('Y-m-d'),
                        'article_no'=>$this->input->post('film_code'),
                        'pos_no'=>$pos_no,
                        'type_flag'=>'2',
                        'total_qty'=>$this->common_model->save_number($release_meters,$this->session->userdata['logged_in']['company_id']),
                        'rel_uom_id'=>'0',
                        'qty_rel'=>'0',
                        'amt_manual'=>$this->common_model->save_number($amt_manual,$this->session->userdata['logged_in']['company_id']),
                        'document_no'=>'',
                        'calculated_purchase_price'=>$this->common_model->save_number($this->input->post('bwip_cost_per_meter'),$this->session->userdata['logged_in']['company_id']),
                        'voucher_no'=>'',
                        'plant_id'=>'3',
                        'created_annexure'=>'0',
                        'grn'=>'',
                        'ref_mm_id'=>$mm_id,
                        'sfg_flag'=>1
                      );

                      $result_reserved_quantity_manu=$this->common_model->save('reserved_quantity_manu',$data);

                      $dataa_wip_search=array('order_no'=>$this->input->post('order_no'),
                      'article_no'=>$this->input->post('article_no'),
                      'status'=>0,'archive'=>0);

                      $data['springtube_printing_wip_master_before']=$this->common_model->select_active_records_where('springtube_printing_wip_master_before',$this->session->userdata['logged_in']['company_id'],$dataa_wip_search);


                      foreach ($data['springtube_printing_wip_master_before'] as  $springtube_printing_wip_master_before_row) {
                                                
                        $data_bwip_update=array('status'=>'1','print_jobcard_created'=>'1','print_jobcard_no'=>$jobcard_no,'release_date'=>date('Y-m-d'));

                        $result=$this->common_model->update_one_active_record('springtube_printing_wip_master_before',$data_bwip_update,'bprint_wip_id',$springtube_printing_wip_master_before_row->bprint_wip_id,$this->session->userdata['logged_in']['company_id']);


                      }

                    }


                  }
                  

                  // FOIL STARTED------------------------------

                  $foil="";

                  $artwork_data=array('ad_id'=>$this->input->post('artwork_no'),'version_no'=>$this->input->post('artwork_version_no'));
                  
                  $this->load->model('artwork_springtube_model');

                  $result_print_type=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('artwork_version_no'),'artwork_para_id','18');
                  if($result_print_type){

                    foreach($result_print_type as $print_type_row){
                      strtoupper($print_type_row->parameter_value);
                    }

                  } 

                  // COLD FOIL--------------------------------- 

                  // Foil into jobcard is commented on 21-Jan-2021 due to adding foil in printing jobsetup----  

                  /*           
                   
                  $result_cold_foil_one=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('artwork_version_no'),'artwork_para_id','4');

                  $result_cold_foil_one_length=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('artwork_version_no'),'artwork_para_id','19');

                  $result_cold_foil_one_width=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('artwork_version_no'),'artwork_para_id','20');                  
                
                  $result_cold_foil_two=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('artwork_version_no'),'artwork_para_id','6');

                  $result_cold_foil_two_length=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('artwork_version_no'),'artwork_para_id','21');

                  $result_cold_foil_two_width=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('artwork_version_no'),'artwork_para_id','22');


                
                      
                    $cold_foil_one='';
                    $cold_foil_one_width='';
                    $cold_foil_two='';
                    $cold_foil_two_width='';

                    if($result_cold_foil_one==TRUE){
                      
                      foreach($result_cold_foil_one as $cold_foil_one_row){
                        $cold_foil_one=$cold_foil_one_row->parameter_value;
                      }

                      if($cold_foil_one!=''){
                        
                        $foil=1;                          
                        foreach($result_cold_foil_one_width as $cold_foil_one_width_row){
                          $cold_foil_one_width=$cold_foil_one_width_row->parameter_value;

                          if($cold_foil_one_width!=''){

                            $cold_foil_one_rm_qty=($cold_foil_one_width/1000)*$release_meters;

                            $data['max_mm']=$this->common_model->select_max_pkey_numeric('material_manufacturing','mm_id',$this->session->userdata['logged_in']['company_id']);
                            foreach($data['max_mm'] as $max_mm_row){
                              $mm_id=$max_mm_row->mm_id+1;
                            }

                            $data=array(
                              'manu_order_no'=>$jobcard_no,
                              'article_no'=>$cold_foil_one,
                              'demand_qty'=>$this->common_model->save_number($cold_foil_one_rm_qty,$this->session->userdata['logged_in']['company_id']),
                              'company_id'=>$this->session->userdata['logged_in']['company_id'],
                              'work_proc_no'=>'6',
                              'from_job_card'=>'1',
                              'rel_demand_qty'=>$this->common_model->save_number($cold_foil_one_rm_qty*1000,$this->session->userdata['logged_in']['company_id']),
                              'flag_uom_type'=>'1',
                              'mm_id'=>$mm_id,
                              'rel_uom_id'=>'9',
                              'part_pos_no'=>$part_pos_no++
                            );

                            $this->common_model->save('material_manufacturing',$data);
                               

                            }                            
                          }
                        }
                      }


                    if($result_cold_foil_two==TRUE){
                      
                      foreach($result_cold_foil_two as $cold_foil_two_row){
                        $cold_foil_two=$cold_foil_two_row->parameter_value;
                      }

                      if($cold_foil_two!=''){
                        
                        $foil=2;                          
                        foreach($result_cold_foil_two_width as $cold_foil_two_width_row){
                          $cold_foil_two_width=$cold_foil_two_width_row->parameter_value;

                          if($cold_foil_two_width!=''){

                            $cold_foil_two_rm_qty=($cold_foil_two_width/1000)*$release_meters;

                            $data['max_mm']=$this->common_model->select_max_pkey_numeric('material_manufacturing','mm_id',$this->session->userdata['logged_in']['company_id']);
                            foreach($data['max_mm'] as $max_mm_row){
                              $mm_id=$max_mm_row->mm_id+1;
                            }

                            $data=array(
                              'manu_order_no'=>$jobcard_no,
                              'article_no'=>$cold_foil_two,
                              'demand_qty'=>$this->common_model->save_number($cold_foil_two_rm_qty,$this->session->userdata['logged_in']['company_id']),
                              'company_id'=>$this->session->userdata['logged_in']['company_id'],
                              'work_proc_no'=>'6',
                              'from_job_card'=>'1',
                              'rel_demand_qty'=>$this->common_model->save_number($cold_foil_two_rm_qty*1000,$this->session->userdata['logged_in']['company_id']),
                              'flag_uom_type'=>'1',
                              'mm_id'=>$mm_id,
                              'rel_uom_id'=>'9',
                              'part_pos_no'=>$part_pos_no++
                            );
                                
                            $this->common_model->save('material_manufacturing',$data);
                               

                            }                            
                          }
                        }
                      }

                     */ 
                      
                }//ARTWORK IF

              } //Production master IF
              
               
              
              $data=array(
              'final_approval_flag'=>'1',
              'order_no'=>$this->input->post('order_no'),
              'trans_closed'=>'0',
              'order_closed <>'=>'1',
              'hold_flag'=>'0');

              $data['order']=$this->sales_order_book_model->active_details_records('order_master',$data,$this->session->userdata['logged_in']['company_id']);
              //echo $this->db->last_query();

              $dataa=array('order_no'=>$this->input->post('order_no'),
                'article_no'=>$this->input->post('article_no'));

              $data['order_details']=$this->common_model->select_one_active_record_nonlanguage_without_archives('order_details',$this->session->userdata['logged_in']['company_id'],$dataa);

              //-------------------------------------------------------

               $data['springtube_printing_wip_master_before']=$this->common_model->select_active_records_where('springtube_printing_wip_master_before',$this->session->userdata['logged_in']['company_id'],$dataa);

              //-------------------------------------------------------
              $data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_details.property_id','1');

              $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','75');

              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_item_parameterwise');

              $data['note']='Create Transaction Completed'; 

              header("refresh:1;url=".base_url()."index.php/sales_order_item_parameterwise");
              
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/create-print-jobcard-form',$data);
              $this->load->view('Home/footer');


            }

            
          }else{
              $data['note']='No Create rights Thanks';
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view('Error/error-title',$data);
              $this->load->view('Home/footer');
          }
        }
      }
    }
  }else{
      $data['note']='No Create rights Thanks';
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

