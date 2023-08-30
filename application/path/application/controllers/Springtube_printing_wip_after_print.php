<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Springtube_printing_wip_after_print extends CI_Controller {

  function __construct(){    
    parent::__construct();
    if($this->session->userdata('logged_in')){
      
      $this->load->model('common_model');

      $this->load->model('article_model');
      $this->load->model('customer_model');
      $this->load->model('sales_order_book_model');
      $this->load->model('sales_order_status_model');
      $this->load->model('artwork_springtube_model');
      $this->load->model('springtube_printing_wip_after_print_model');
      $this->load->model('artwork_model');
      $this->load->model('fiscal_model');
      $this->load->model('process_model');
      $this->load->model('artwork_springtube_model');
      $this->load->model('sales_order_item_parameterwise_model');
      
      
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

              $table='springtube_printing_wip_master_after';
              include('pagination_wip.php');
              $data['springtube_printing_wip_master_after']=$this->springtube_printing_wip_after_print_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
             
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

              $table='springtube_printing_wip_master_after';
              include('pagination_archive.php');
              $data['springtube_printing_wip_master_after']=$this->springtube_printing_wip_after_print_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
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

              $data_search=array('status'=>0);
              $data['springtube_printing_wip_master_after']=$this->springtube_printing_wip_after_print_model->active_record_search('springtube_printing_wip_master_after',$this->session->userdata['logged_in']['company_id'],$data_search,$this->input->get('from_date'),$this->input->get('to_date')); 
             
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
                $data_search['jobcard_no']=$this->input->post('jobcard_no');
              }
              if($this->input->post('customer')!=''){
                $customer_arr=explode("//",$this->input->post('article_no'));
                $data_search['customer']=$customer_arr[1];
              }


              if($this->input->post('order_no')!=''){
                $data_search['order_no']=$this->input->post('order_no');
              }
              if($this->input->post('sleeve_dia')!=''){
                $sleeve_dia_arr=explode("//", $this->input->post('sleeve_dia'));
                $data_search['sleeve_dia']=$sleeve_dia_arr[0];
              }
              if($this->input->post('sleeve_length')!=''){
                $data_search['sleeve_length']=$this->input->post('sleeve_length');
              }
              if($this->input->post('article_no')!=''){
                $article_arr=explode("//",$this->input->post('article_no'));
                $data_search['article_no']=$article_arr[1];
              }
              if($this->input->post('film_code')!=''){
                $film_code_arr=explode("//",$this->input->post('film_code'));
                $data_search['film_code']=$film_code_arr[1];
              }
              if($this->input->post('total_microns')!=''){
                $data_search['total_microns']=$this->input->post('total_microns');
              }
              if($this->input->post('film_masterbatch_two')!=''){
                $data_search['second_layer_mb']=$this->input->post('film_masterbatch_two');
              }

              if($this->input->post('film_masterbatch_six')!=''){
                $data_search['sixth_layer_mb']=$this->input->post('film_masterbatch_six');
              }

              if($this->input->post('status')!=''){
                $data_search['status']=$this->input->post('status');
              }

              //print_r($data_search);
             

              //$data['springtube_printing_wip_master_after']=$this->springtube_printing_wip_after_print_model->active_record_search('springtube_printing_wip_master_after',$this->session->userdata['logged_in']['company_id'],$data_search,$this->input->post('from_date'),$this->input->post('to_date'));             
              $data['springtube_printing_wip_master_after']=$this->springtube_printing_wip_after_print_model->active_record_search('springtube_printing_wip_master_after',$this->session->userdata['logged_in']['company_id'],$data_search,$this->input->post('from_date'),$this->input->post('to_date'));             

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
              $data['springtube_printing_wip_master_after']=$this->springtube_printing_wip_after_print_model->active_record_search_wip('springtube_printing_wip_master_after',$this->session->userdata['logged_in']['company_id'],$data_search,$this->input->post('from_date'),$this->input->post('to_date'));             

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

  function create_bodymaking_jobcard(){

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
              'hold_flag<>'=>'1');

            $data['order']=$this->sales_order_book_model->active_details_records('order_master',$data,$this->session->userdata['logged_in']['company_id']);
            //echo $this->db->last_query();

            $dataa=array('order_no'=>$this->uri->segment(3),
              'article_no'=>$this->uri->segment(4));

            $data['order_details']=$this->common_model->select_one_active_record_nonlanguage_without_archives('order_details',$this->session->userdata['logged_in']['company_id'],$dataa);

            //-------------------------------------------------------

            $data_awip_search=array('order_no'=>$this->uri->segment(3),
              'article_no'=>$this->uri->segment(4),
              'status'=>'0',
              'archive'=>'0'
            );

            $data['springtube_printing_wip_master_after']=$this->common_model->select_active_records_where('springtube_printing_wip_master_after',$this->session->userdata['logged_in']['company_id'],$data_awip_search);

            //-------------------------------------------------------

            $data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_details.property_id','1');

            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','75');

            $data['page_name']='Production';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
            $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
              
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/create-bodymaking-jobcard-form',$data);
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

   function save_bodymaking_jobcard(){

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
            $this->form_validation->set_rules('aprint_wip_qty','Total Qty avialble for Bodymaking' ,'required|trim|xss_clean|greater_than[0]');             
            $this->form_validation->set_rules('release_qty','Bodymaking Job Card Quantity' ,'required|trim|xss_clean|greater_than[0]');

            if($this->form_validation->run()===FALSE){

              $data=array(
              'final_approval_flag'=>'1',
              'order_no'=>$this->input->post('order_no'),
              'trans_closed'=>'0',
              'order_closed <>'=>'1',
              'hold_flag<>'=>'1');

              $data['order']=$this->sales_order_book_model->active_details_records('order_master',$data,$this->session->userdata['logged_in']['company_id']);
              //echo $this->db->last_query();

              $dataa=array('order_no'=>$this->input->post('order_no'),
                'article_no'=>$this->input->post('article_no'));

              $data['order_details']=$this->common_model->select_one_active_record_nonlanguage_without_archives('order_details',$this->session->userdata['logged_in']['company_id'],$dataa);

              //-------------------------------------------------------

              $data_awip_search=array('order_no'=>$this->input->post('order_no'),
                'article_no'=>$this->input->post('article_no'),
                'status'=>'0',
                'archive'=>'0'
              );

              $data['springtube_printing_wip_master_after']=$this->common_model->select_active_records_where('springtube_printing_wip_master_after',$this->session->userdata['logged_in']['company_id'],$data_awip_search);

              //-------------------------------------------------------
              $data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_details.property_id','1');

              $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','75');

              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,'sales_order_item_parameterwise');
              
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/create-bodymaking-jobcard-form',$data);
              $this->load->view('Home/footer'); 
              
            }else{

              // TOTAL JOBCARD METERS CALCULATION---------------------
              $data_awip_search=array('order_no'=>$this->input->post('order_no'),
                'article_no'=>$this->input->post('article_no'),
                'status'=>'0',
                'archive'=>'0'
              );

              $data['springtube_printing_wip_master_after']=$this->common_model->select_active_records_where('springtube_printing_wip_master_after',$this->session->userdata['logged_in']['company_id'],$data_awip_search);

              $job_meters=0;

              foreach ($data['springtube_printing_wip_master_after'] as $key => $row) {               
                
                $production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$row->jobcard_no);

                foreach ($production_master_result as $key => $production_master_row) {
                  $job_meters+=$production_master_row->total_meters;
                }
              }


              // Form ID---------------------

              $form_id='104444';
              $jobcard_type='3';// Bodymaking

              $customer='';
              $order_no= $this->input->post('order_no');
              $article_no=$this->input->post('article_no');
              //$total_bprint_wip_meters=$this->input->post('total_bprint_wip_meters');
              $aprint_wip_qty=$this->input->post('aprint_wip_qty');
              //$release_meters=$this->input->post('release_meters');
              $release_qty=$this->input->post('release_qty'); 

              $reel_length='';
              $no_of_reels='';

              $cap_height='';
              $cap_spec_id='';
              $cap_spec_version='';
              $cap_shrink_sleeves='';
              $cap_style='';
              $cap_mold_finish='';
              $cap_orifice='';;
              $cap_dia='';

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
                'no_of_reels'=>'',
                'reel_length'=>'',
                'total_meters'=>$job_meters
                );

               $result=$this->common_model->save('production_master',$data);

              if($result){

                $data=array('curr_val'=>$next_jobcard_no);              
                $this->common_model->update_one_active_record('autogeneration_format_master',$data,'form_id',$form_id,$this->session->userdata['logged_in']['company_id']);
              

                //Order details-----------
                $order_master_result=$this->sales_order_book_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_master.order_no',$order_no);
                foreach($order_master_result as $order_master_row){
                  $customer=$order_master_row->customer_name;
                  $order_date=$order_master_row->order_date;
                }

                $data_order_details=array(
                  'order_no'=>$order_no,
                  'article_no'=>$article_no
                  );

                $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
                foreach($order_details_result as $order_details_row){
                  $bom_no=$order_details_row->spec_id;
                  $bom_version_no=$order_details_row->spec_version_no;
                  $ad_id=$order_details_row->ad_id;
                  $version_no=$order_details_row->version_no;

                }

                $data_artwork=array('ad_id'=>$ad_id,
                            'version_no'=>$version_no
                          );
              $springtube_artwork_result=$this->artwork_springtube_model->active_record_search_new('springtube_artwork_devel_master',$data_artwork,'','','',$this->session->userdata['logged_in']['company_id']);

              $body_making_type='';

              foreach ($springtube_artwork_result as $springtube_artwork_row) {
                $body_making_type=$springtube_artwork_row->body_making_type;
              }

                $data=array('bom_no'=>$bom_no,'bom_version_no'=>$bom_version_no);

                $bill_of_material_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data);

                $cap_code='';
                $for_export='';

                foreach ($bill_of_material_result as $bill_of_material_row) {
                  $bom_id=$bill_of_material_row->bom_id;
                  $film_code=$bill_of_material_row->sleeve_code;
                  $for_export=$bill_of_material_row->for_export;
                  $cap_code=$bill_of_material_row->cap_code;
                  $shoulder_code=$bill_of_material_row->shoulder_code;
                } 

                //FILM SPECIFICATION---------------------------------

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

                $sleeve_id='';
                foreach($data['sleeve_diameter_master'] as $sleeve_dia_row){
                  $sleeve_id=$sleeve_dia_row->sleeve_id;
                }

                $data=array('sleeve_dia_id'=>$sleeve_id);

                $result_spring_width_calculation=$this->common_model->select_active_records_where('spring_width_calculation',$this->session->userdata['logged_in']['company_id'],$data);

                $reel_width=0;
                $ups=0;
                $sleeve_length_extrusion=$sleeve_length+2.5;
                          
                foreach ($result_spring_width_calculation as $spring_width_calculation_row) {
                  $ups=$spring_width_calculation_row->ups;
                  $reel_width=($spring_width_calculation_row->slit_width)+($spring_width_calculation_row->ups*$spring_width_calculation_row->distance_each_side);
                }

                //$expected_tubes=($total_meters*$ups*1000)/$sleeve_length_extrusion;


                
                


                $part_pos_no=1;
                // CAP SPECIFICATION-------
                // $cap_height='';
                // $cap_spec_id='';
                // $cap_spec_version='';
                // $cap_shrink_sleeves='';
                // $cap_style='';
                // $cap_mold_finish='';
                // $cap_orifice='';;
                // $cap_dia='';



                // Adding shoulder in to Body making Jobcards for Springtube--------

                if(!empty($shoulder_code)){

                  $data['max_mm']=$this->common_model->select_max_pkey_numeric('material_manufacturing','mm_id',$this->session->userdata['logged_in']['company_id']);
                  foreach($data['max_mm'] as $max_mm_row){
                    $mm_id=$max_mm_row->mm_id+1;
                  }

                  $data=array(
                    'manu_order_no'=>$jobcard_no,
                    'article_no'=>$shoulder_code,
                    'demand_qty'=>$this->common_model->save_number($release_qty,$this->session->userdata['logged_in']['company_id']),
                    'company_id'=>$this->session->userdata['logged_in']['company_id'],
                    'work_proc_no'=>'2',
                    'from_job_card'=>'1',
                    'rel_demand_qty'=>$this->common_model->save_number($release_qty*1000,$this->session->userdata['logged_in']['company_id']),
                    'flag_uom_type'=>'1',
                    'mm_id'=>$mm_id,
                    'rel_uom_id'=>'9',
                    'part_pos_no'=>$part_pos_no++);

                  $this->common_model->save('material_manufacturing',$data);

                }

                if(!empty($cap_code)){

                  //$cap_shrink_sleeves='';

                  $cap_result_master=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$cap_code);

                  foreach($cap_result_master as $cap_result_master_row){                   
                    $cap_spec_id=$cap_result_master_row->spec_id;
                    $cap_spec_version=$cap_result_master_row->spec_version_no;
                  }

                  $cap_specs['spec_id']=$cap_spec_id;
                  $cap_specs['spec_version_no']=$cap_spec_version;

                  $cap_specs_details_result=$this->sales_order_book_model->select_cap_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$cap_specs);

                  // echo'<pre>';

                  // print_r($cap_specs_details_result);

                  // echo'</pre>';


                  foreach ($cap_specs_details_result as $cap_specs_details_row) {

                    $cap_style=$cap_specs_details_row->CAP_STYLE;
                    $cap_mold_finish=$cap_specs_details_row->CAP_MOLD_FINISH;
                    $cap_orifice=$cap_specs_details_row->CAP_ORIFICE;
                    $cap_dia=$cap_specs_details_row->CAP_DIA;                  
                    echo $cap_shrink_sleeves=$cap_specs_details_row->CAP_SHRINK_SLEEVE_CODE;
                    
                  }

                  $data['max_mm']=$this->common_model->select_max_pkey_numeric('material_manufacturing','mm_id',$this->session->userdata['logged_in']['company_id']);
                  foreach($data['max_mm'] as $max_mm_row){
                    $mm_id=$max_mm_row->mm_id+1;
                  }

                  $data=array(
                    'manu_order_no'=>$jobcard_no,
                    'article_no'=>$cap_code,
                    'demand_qty'=>$this->common_model->save_number($release_qty,$this->session->userdata['logged_in']['company_id']),
                    'company_id'=>$this->session->userdata['logged_in']['company_id'],
                    'work_proc_no'=>'11',
                    'from_job_card'=>'1',
                    'rel_demand_qty'=>$this->common_model->save_number($release_qty*1000,$this->session->userdata['logged_in']['company_id']),
                    'flag_uom_type'=>'1',
                    'mm_id'=>$mm_id,
                    'rel_uom_id'=>'9',
                    'part_pos_no'=>$part_pos_no++);

                  $this->common_model->save('material_manufacturing',$data);                

                
                  if(!empty($cap_shrink_sleeves) || $cap_shrink_sleeves!=''){

                    $data['max_mm']=$this->common_model->select_max_pkey_numeric('material_manufacturing','mm_id',$this->session->userdata['logged_in']['company_id']);
                    foreach($data['max_mm'] as $max_mm_row){
                      $mm_id=$max_mm_row->mm_id+1;
                    }

                    $data=array(
                      'manu_order_no'=>$jobcard_no,
                      'article_no'=>$cap_shrink_sleeves,
                      'demand_qty'=>$this->common_model->save_number($release_qty,$this->session->userdata['logged_in']['company_id']),
                      'company_id'=>$this->session->userdata['logged_in']['company_id'],
                      'work_proc_no'=>'11',
                      'from_job_card'=>'1',
                      'rel_demand_qty'=>$this->common_model->save_number($release_qty*1000,$this->session->userdata['logged_in']['company_id']),
                      'flag_uom_type'=>'1',
                      'mm_id'=>$mm_id,
                      'rel_uom_id'=>'9',
                      'part_pos_no'=>$part_pos_no++);

                    $this->common_model->save('material_manufacturing',$data);
                                 
                  }


                  $cap_dia_data=array('cap_dia'=>$cap_dia);
                  $cap_dia_result=$this->common_model->select_one_active_record_nonlanguage_without_archives('cap_diameter_master',$this->session->userdata['logged_in']['company_id'],$cap_dia_data);

                  $cap_dia_id='';
                  foreach($cap_dia_result as $cap_dia_result_row){
                    $cap_dia_id=$cap_dia_result_row->cap_dia_id;
                  }              

                  
                  $cap_style_data=array('cap_type'=>$cap_style,
                    'archive<>'=>1);
                  $cap_type_result=$this->common_model->select_one_active_record_nonlanguage_without_archives('cap_types_master',$this->session->userdata['logged_in']['company_id'],$cap_style_data);
                  $cap_type_id='';
                  foreach($cap_type_result as $cap_type_result_row){
                    $cap_type_id=$cap_type_result_row->cap_type_id;
                  }                  

                  $cap_height_data=array('cap_dia_id'=>$cap_dia_id,
                    'cap_type_id'=>$cap_type_id);
                  $cap_height_result=$this->common_model->select_active_records_where('shoulder_orifice_dependancy',$this->session->userdata['logged_in']['company_id'],$cap_height_data);
                  //echo $this->db->last_query();
                  
                  if($cap_height_result){
                    foreach($cap_height_result as $cap_height_result_row){
                      $cap_height=$cap_height_result_row->cap_height/100;
                    }
                  }                  
                  

              }//If cap code


              // BOX Calculations-----------------

              $packing_box_result=$this->common_model->select_one_active_record_noncompany('packing_box_master','sleeve_id',$sleeve_id);
                  
              foreach($packing_box_result as $packing_box_result_row){
                $no_of_tubes_per_box=$packing_box_result_row->no_of_tubes_per_box/100;
              }

              echo $cap_height;
              echo "<br/>";
              echo $box_min_height=$sleeve_length+$cap_height+5;
              echo "<br/>";
              echo $box_max_height=$box_min_height+20;
              echo "<br/>";
              $box_min_height=$box_min_height*100;
              
              $box_max_height=$box_max_height*100;


              if($for_export==1){

                $packing_box_parameter_data=array('type'=>'EX');
                // For Royal Talent 40 Dia PSP 5 Ply Required---------
                $dia_numeric=$this->common_model->select_number_from_string($sleeve_diameter);

                $royal_talent_psps = array("PSP-000-1645", "PSP-000-0670", "PSP-000-0625", "PSP-000-0039","PSP-000-0176");

                $psp=$this->input->post('article_no');
                if(in_array($psp, $royal_talent_psps) && $dia_numeric=='40'){

                  $packing_box_parameter_data=array('type'=>'EX','ply'=>'5');
                }
                
                //-----------------------------------------------------
              }else{

                if($customer==1948 || $customer==1974){
                  $packing_box_parameter_data=array('type'=>'RE','ply'=>'5');
                }
                else if($customer==517 || $customer==538 || $customer==2900){
                  $packing_box_parameter_data=array('type'=>'RE','ply'=>'3');
                }
                else{
                  $packing_box_parameter_data=array('type'=>'RE');
                }
                
              }

              $packing_box_parameter_result=$this->sales_order_item_parameterwise_model->select_packing_box_record('packing_box_parameter_master',$this->session->userdata['logged_in']['company_id'],$box_min_height,$box_max_height,$packing_box_parameter_data);

              //echo $this->db->last_query();

              if($packing_box_parameter_result){

                foreach($packing_box_parameter_result as $packing_box_parameter_result_row){
                  //echo "<br/>BOTTOMBOX ";
                  $packing_box_parameter_result_row->article_no;
                  $box_quantity=$release_qty/$no_of_tubes_per_box;
                  $box_quantity=round($box_quantity);
                  $data['max_mm']=$this->common_model->select_max_pkey_numeric('material_manufacturing','mm_id',$this->session->userdata['logged_in']['company_id']);
                  foreach($data['max_mm'] as $max_mm_row){
                    $mm_id=$max_mm_row->mm_id+1;
                  }

                  $data=array('manu_order_no'=>$jobcard_no,
                  'article_no'=>$packing_box_parameter_result_row->article_no,
                  'demand_qty'=>$this->common_model->save_number($box_quantity,$this->session->userdata['logged_in']['company_id']),
                  'company_id'=>$this->session->userdata['logged_in']['company_id'],
                  'work_proc_no'=>'10',
                  'from_job_card'=>'1',
                  'rel_demand_qty'=>$this->common_model->save_number($box_quantity*1000,$this->session->userdata['logged_in']['company_id']),
                  'flag_uom_type'=>'1',
                  'mm_id'=>$mm_id,
                  'rel_uom_id'=>'UOM001',
                  'part_pos_no'=>$part_pos_no++);
                
                  $this->common_model->save('material_manufacturing',$data); 

                }
              }

              $packing_box_parameter_data=array('type'=>'BOTH');
              $packing_box_parameter_result=$this->common_model->select_active_records_where('packing_box_parameter_master',$this->session->userdata['logged_in']['company_id'],$packing_box_parameter_data);

              if($packing_box_parameter_result){

                foreach($packing_box_parameter_result as $packing_box_parameter_result_row){

                  if($for_export==1){
                    $article_no='PM-CB-000-0043';
                  }else{
                    $article_no='PM-CB-000-0076';
                  }

                  
                  $packing_box_parameter_result_row->article_no;
                  $box_quantity=$release_qty/$no_of_tubes_per_box;
                  $box_quantity=round($box_quantity);
                  $data['max_mm']=$this->common_model->select_max_pkey_numeric('material_manufacturing','mm_id',$this->session->userdata['logged_in']['company_id']);
                  foreach($data['max_mm'] as $max_mm_row){
                    $mm_id=$max_mm_row->mm_id+1;
                  }

                  $data=array('manu_order_no'=>$jobcard_no,
                  'article_no'=>$article_no,
                  'demand_qty'=>$this->common_model->save_number($box_quantity,$this->session->userdata['logged_in']['company_id']),
                  'company_id'=>$this->session->userdata['logged_in']['company_id'],
                  'work_proc_no'=>'10',
                  'from_job_card'=>'1',
                  'rel_demand_qty'=>$this->common_model->save_number($box_quantity*1000,$this->session->userdata['logged_in']['company_id']),
                  'flag_uom_type'=>'1',
                  'mm_id'=>$mm_id,
                  'rel_uom_id'=>'UOM001',
                  'part_pos_no'=>$part_pos_no++);
                
                  $this->common_model->save('material_manufacturing',$data);                  

                }     
                
                

                // Liner weights added on 14Th-August 2019-------
                $liner_weight='';
                $liner_article_no='';
                $liner_height=($sleeve_length+3)+$cap_height;
                if($liner_height>120){
                  $liner_article_no='PM-PL-000-0009';
                  $liner_weight=0.029;

                }else{
                   //$liner_article_no='PM-PL-000-0008'; 
                   $liner_article_no='PM-PL-000-0009';
                   //$liner_weight=0.0275; 
                   $liner_weight=0.029; 
                }
                $liner_qty="";
                $liner_qty=$liner_weight*$box_quantity;


                $data['max_mm']=$this->common_model->select_max_pkey_numeric('material_manufacturing','mm_id',$this->session->userdata['logged_in']['company_id']);
                foreach($data['max_mm'] as $max_mm_row){
                  $mm_id=$max_mm_row->mm_id+1;
                }

                $data=array('manu_order_no'=>$jobcard_no,
                  'article_no'=>$liner_article_no,
                  'demand_qty'=>$this->common_model->save_number($liner_qty,$this->session->userdata['logged_in']['company_id']),
                  'company_id'=>$this->session->userdata['logged_in']['company_id'],
                  'work_proc_no'=>'10',
                  'from_job_card'=>'1',
                  'rel_demand_qty'=>$this->common_model->save_number($liner_qty*1000,$this->session->userdata['logged_in']['company_id']),
                  'flag_uom_type'=>'1',
                  'mm_id'=>$mm_id,
                  'rel_uom_id'=>'UOM001',
                  'part_pos_no'=>$part_pos_no);
                
                  $this->common_model->save('material_manufacturing',$data); 
                  

              }

              // New DEcoseam is added in Jobcard--------------------------29-Jul-2021

              if($body_making_type!='' && $body_making_type=='FLOWSEAM'){

                $decoseam_article_no='CST-DEC-000-0001';
                $job_meters_in_km=($job_meters/1000); 

                $data['max_mm']=$this->common_model->select_max_pkey_numeric('material_manufacturing','mm_id',$this->session->userdata['logged_in']['company_id']);
                foreach($data['max_mm'] as $max_mm_row){
                  $mm_id=$max_mm_row->mm_id+1;
                }

                $data=array('manu_order_no'=>$jobcard_no,
                  'article_no'=>$decoseam_article_no,
                  'demand_qty'=>$this->common_model->save_number($job_meters_in_km,$this->session->userdata['logged_in']['company_id']),
                  'company_id'=>$this->session->userdata['logged_in']['company_id'],
                  'work_proc_no'=>'1',
                  'from_job_card'=>'1',
                  'rel_demand_qty'=>$this->common_model->save_number($job_meters_in_km*1000,$this->session->userdata['logged_in']['company_id']),
                  'flag_uom_type'=>'1',
                  'mm_id'=>$mm_id,
                  'rel_uom_id'=>'UOM004',
                  'part_pos_no'=>$part_pos_no);
                
                  $this->common_model->save('material_manufacturing',$data); 
                  

              }
             
             


              $data_awip_search=array('order_no'=>$this->input->post('order_no'),
                'article_no'=>$this->input->post('article_no'),
                'status'=>'0',
                'archive'=>'0'
              );

              $springtube_printing_wip_master_after_result=$this->common_model->select_active_records_where('springtube_printing_wip_master_after',$this->session->userdata['logged_in']['company_id'],$data_awip_search);

              foreach ($springtube_printing_wip_master_after_result as $springtube_printing_wip_master_after_row ) {
                
                $data=array('status'=>'1','body_making_jobcard_created'=>'1','body_making_jobcard_no'=>$jobcard_no,'release_date'=>date('Y-m-d'));

                $result=$this->common_model->update_one_active_record('springtube_printing_wip_master_after',$data,'aprint_wip_id',$springtube_printing_wip_master_after_row->aprint_wip_id,$this->session->userdata['logged_in']['company_id']);

              }



            } //Success Production master  IF
              
               
              
              $data=array(
              'final_approval_flag'=>'1',
              'order_no'=>$this->input->post('order_no'),
              'trans_closed'=>'0',
              'order_closed <>'=>'1',
              'hold_flag<>'=>'1');

              $data['order']=$this->sales_order_book_model->active_details_records('order_master',$data,$this->session->userdata['logged_in']['company_id']);
              //echo $this->db->last_query();

              $dataa=array('order_no'=>$this->input->post('order_no'),
                'article_no'=>$this->input->post('article_no'),

              );

              $data['order_details']=$this->common_model->select_one_active_record_nonlanguage_without_archives('order_details',$this->session->userdata['logged_in']['company_id'],$dataa);

              //-------------------------------------------------------

              $aprint_wip_data=array('order_no'=>$this->input->post('order_no'),
                'article_no'=>$this->input->post('article_no'),
                'status'=>'0',
                'archive'=>'0'
              
              );

              $data['springtube_printing_wip_master_after']=$this->common_model->select_active_records_where('springtube_printing_wip_master_after',$this->session->userdata['logged_in']['company_id'],$aprint_wip_data);

              //-------------------------------------------------------
              $data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_details.property_id','1');

              $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','75');

              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,'sales_order_item_parameterwise');

              $data['note']='Job card create Transaction Completed'; 

              header("refresh:1;url=".base_url()."index.php/sales_order_item_parameterwise");
              
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/create-bodymaking-jobcard-form',$data);
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

