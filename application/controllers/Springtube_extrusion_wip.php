<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Springtube_extrusion_wip extends CI_Controller {


  function __construct(){    
    parent::__construct();

    if($this->session->userdata('logged_in')){
      
      $this->load->model('common_model');
      $this->load->model('fiscal_model');
      $this->load->model('article_model');
      $this->load->model('sales_order_book_model');
      $this->load->model('sales_order_status_model');
      $this->load->model('artwork_springtube_model');
      $this->load->model('springtube_extrusion_wip_model');
      $this->load->model('springtube_extrusion_production_model');
      $this->load->model('springtube_extrusion_qc_model');
      $this->load->model('springtube_printing_inspection_model');
      
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

              $table='springtube_extrusion_wip_master';
              //include('pagination.php');
              include('pagination_wip.php');
              $data['springtube_extrusion_wip_master']=$this->springtube_extrusion_wip_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
              //echo $this->db->last_query();
             
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

              $table='springtube_extrusion_wip_master';
              include('pagination_archive.php');
              $data['springtube_extrusion_wip_master']=$this->springtube_extrusion_wip_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
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

              $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

              $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);

              $data_search=array('group'=>'PRODUCTION','archive'=>0);

              $data['springtube_process_master']=$this->common_model->select_active_records_where('springtube_process_master',$this->session->userdata['logged_in']['company_id'],$data_search);
              //echo $this->db->last_query();

               $in_arr=array();
               $data_search_1=array('status'=>'0');

               foreach ($data['account_periods_master'] as $key => $row) {
                  $from_date=$row->fin_year_start;
                  
               }

              $data['springtube_extrusion_wip_master']=$this->springtube_extrusion_wip_model->active_record_search_in('springtube_extrusion_wip_master',$this->session->userdata['logged_in']['company_id'],$data_search_1,$from_date,date('Y-m-d'),'','',$in_arr); 
             //echo $this->db->last_query();  
             
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
            $this->form_validation->set_rules('release_to_order_no','Released Order No.' ,'trim|xss_clean');        
            $this->form_validation->set_rules('jobcard_no','Jobcard No.' ,'trim|xss_clean');
            $this->form_validation->set_rules('sleeve_dia','Sleeve Dia' ,'trim|xss_clean');
            $this->form_validation->set_rules('sleeve_length','Sleeve Length' ,'trim|xss_clean');
            $this->form_validation->set_rules('article_no','article_no' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('film_code','Film Code' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('film_masterbatch_two','Second Layer MB' ,'trim|xss_clean');
            $this->form_validation->set_rules('film_masterbatch_six','Sixth Layer MB' ,'trim|xss_clean');
            $this->form_validation->set_rules('customer','Customer' ,'trim|xss_clean|callback_customer_check');
            $this->form_validation->set_rules('status','Status' ,'trim|xss_clean');
            $this->form_validation->set_rules('wip_cost_per_meter','WIP Cost' ,'trim|xss_clean');

            $this->form_validation->set_rules('release_from_date','Release From Date' ,'trim|xss_clean|exact_length[10]');
            $this->form_validation->set_rules('release_to_date','Release To Date' ,'trim|xss_clean|exact_length[10]');
                       
            if($this->form_validation->run()==FALSE){

              $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);

              $data_process=array('group'=>'PRODUCTION','archive'=>0);

              $data['springtube_process_master']=$this->common_model->select_active_records_where('springtube_process_master',$this->session->userdata['logged_in']['company_id'],$data_process);

              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $in_arr=array();
               $data_search_1=array('status'=>'0');

              $data['springtube_extrusion_wip_master']=$this->springtube_extrusion_wip_model->active_record_search_in('springtube_extrusion_wip_master',$this->session->userdata['logged_in']['company_id'],$data_search_1,$this->input->post('from_date'),$this->input->post('to_date'),$this->input->post('release_from_date'),$this->input->post('release_to_date'),$in_arr); 
                
                //echo $this->db->last_query();
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
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
              if($this->input->post('release_to_order_no')!=''){
                $data_search['release_to_order_no']=$this->input->post('release_to_order_no');
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
              if($this->input->post('wip_cost_per_meter')!=''){
                $data_search['wip_cost_per_meter']=$this->input->post('wip_cost_per_meter');
              }
             
              $in_arr=$this->input->post('springtube_process[]');

              $data['springtube_extrusion_wip_master']=$this->springtube_extrusion_wip_model->active_record_search_in('springtube_extrusion_wip_master',$this->session->userdata['logged_in']['company_id'],$data_search,$this->input->post('from_date'),$this->input->post('to_date'),$this->input->post('release_from_date'),$this->input->post('release_to_date'),$in_arr); 
             //echo $this->db->last_query();            

              $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);                
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);

              $data_process=array('group'=>'PRODUCTION','archive'=>0);

              $data['springtube_process_master']=$this->common_model->select_active_records_where('springtube_process_master',$this->session->userdata['logged_in']['company_id'],$data_process);

              //print_r($data['springtube_process_master']);
               

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

  function search_wip_diawise(){    
    
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

              $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              
              $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);

              //$data['from_date']=$this->input->get('from_date');
              $from_date='2020-04-01';
              $to_date=date('Y-m-d');
              // foreach ($data['account_periods_master'] as $key => $account_periods_master_row) {
              //   $from_date=$account_periods_master_row->fin_year_start;
              // }

              $data['from_date']=$from_date;
              $data['to_date']=$to_date;

              $data_search=array();
              $data['springtube_extrusion_wip_master']=$this->springtube_extrusion_wip_model->wip_active_record_search_groupby('springtube_extrusion_wip_master',$this->session->userdata['logged_in']['company_id'],$data_search,$from_date,$to_date);

              //echo $this->db->last_query();


             
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form-wip-diawise',$data);
              //$this->load->view(ucwords($this->router->fetch_class()).'/active-records-wip-diawise',$data);
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

  function search_result_wip_diawise(){

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
            //$this->form_validation->set_rules('order_no','Order No.' ,'trim|xss_clean');
            //$this->form_validation->set_rules('release_to_order_no','Released Order No.' ,'trim|xss_clean');        
            //$this->form_validation->set_rules('jobcard_no','Jobcard No.' ,'trim|xss_clean');
            $this->form_validation->set_rules('sleeve_dia','Sleeve Dia' ,'trim|xss_clean');
            $this->form_validation->set_rules('total_microns','Microns' ,'trim|xss_clean');
            //$this->form_validation->set_rules('sleeve_length','Sleeve Length' ,'trim|xss_clean');
            //$this->form_validation->set_rules('article_no','article_no' ,'trim|xss_clean|callback_article_check');
            //$this->form_validation->set_rules('film_code','Film Code' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('film_masterbatch_two','Second Layer MB' ,'trim|xss_clean');
            $this->form_validation->set_rules('film_masterbatch_six','Sixth Layer MB' ,'trim|xss_clean');
            //$this->form_validation->set_rules('customer','Customer' ,'trim|xss_clean|callback_customer_check');
            //$this->form_validation->set_rules('status','Status' ,'trim|xss_clean');
                       
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
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form-wip-diawise',$data);
              $this->load->view('Home/footer');
            }else{              
              
              
              $data_search=array();
              // if($this->input->post('jobcard_no')!=''){
              //   $data_search['jobcard_no']=$this->input->post('jobcard_no');
              // }
              // if($this->input->post('customer')!=''){
              //   $customer_arr=explode("//",$this->input->post('article_no'));
              //   $data_search['customer']=$customer_arr[1];
              // }


              // if($this->input->post('order_no')!=''){
              //   $data_search['order_no']=$this->input->post('order_no');
              // }
              // if($this->input->post('release_to_order_no')!=''){
              //   $data_search['release_to_order_no']=$this->input->post('release_to_order_no');
              // }
              if($this->input->post('sleeve_dia')!=''){
                $sleeve_dia_arr=explode("//", $this->input->post('sleeve_dia'));
                $data_search['sleeve_dia']=$sleeve_dia_arr[0];
              }
              // if($this->input->post('sleeve_length')!=''){
              //   $data_search['sleeve_length']=$this->input->post('sleeve_length');
              // }
              // if($this->input->post('article_no')!=''){
              //   $article_arr=explode("//",$this->input->post('article_no'));
              //   $data_search['article_no']=$article_arr[1];
              // }
              // if($this->input->post('film_code')!=''){
              //   $film_code_arr=explode("//",$this->input->post('film_code'));
              //   $data_search['film_code']=$film_code_arr[1];
              // }
              if($this->input->post('total_microns')!=''){
                $data_search['total_microns']=$this->input->post('total_microns');
              }
              if($this->input->post('film_masterbatch_two')!=''){
                $data_search['second_layer_mb']=$this->input->post('film_masterbatch_two');
              }
              if($this->input->post('film_masterbatch_six')!=''){
                $data_search['sixth_layer_mb']=$this->input->post('film_masterbatch_six');
              }

              // if($this->input->post('status')!=''){
              //   $data_search['status']=$this->input->post('status');
              // }
             

              $data['springtube_extrusion_wip_master']=$this->springtube_extrusion_wip_model->wip_active_record_search_groupby('springtube_extrusion_wip_master',$this->session->userdata['logged_in']['company_id'],$data_search,$this->input->post('from_date'),$this->input->post('to_date')); 
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
                 $this->load->view(ucwords($this->router->fetch_class()).'/search-form-wip-diawise',$data);
                //$this->load->view(ucwords($this->router->fetch_class()).'/active-records-wip-diawise',$data);
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

 function search_wip_scrap(){    
    
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
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
        
              $data_search['from_process']='6'; 
              $table='springtube_extrusion_scrap_master';
              //include('pagination_wip.php');        
        
              $data['springtube_extrusion_scrap_master']=$this->springtube_extrusion_qc_model->scrap_active_record_search($table,/*$config["per_page"],$this->uri->segment(3),*/$this->session->userdata['logged_in']['company_id'],$data_search,$this->input->get('from_date'),$this->input->get('to_date'));
             
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form-wip-scrap',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/active-records-wip-scrap',$data);
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

  function search_result_wip_scrap(){

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
            
            $this->form_validation->set_rules('article_no','article_no' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('film_code','Film Code' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('film_masterbatch_two','Second Layer MB' ,'trim|xss_clean');
            $this->form_validation->set_rules('film_masterbatch_six','Sixth Layer MB' ,'trim|xss_clean');
            $this->form_validation->set_rules('customer','Customer' ,'trim|xss_clean|callback_customer_check');
            //$this->form_validation->set_rules('status','Status' ,'trim|xss_clean');
                       
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
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form-wip-scrap',$data);
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

              $data_search['from_process']='6';            

              $data['springtube_extrusion_scrap_master']=$this->springtube_extrusion_qc_model->scrap_active_record_search('springtube_extrusion_scrap_master',$this->session->userdata['logged_in']['company_id'],$data_search,$this->input->post('from_date'),$this->input->post('to_date'));
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
                $this->load->view(ucwords($this->router->fetch_class()).'/search-form-wip-scrap',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/active-records-wip-scrap',$data);
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


  function wip_release($wip_id){
       
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->new==1){

              $table='springtube_extrusion_wip_master';
              $data['springtube_extrusion_wip_master']=$this->springtube_extrusion_wip_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'wip_id',$wip_id);
              
              
             // echo $this->db->last_query();

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/wip-release-form',$data);
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
  




  function wip_release_save(){
       
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->new==1){
              
              $this->form_validation->set_rules('jobcard_no','Jobcard No' ,'required|trim|xss_clean|max_length[50]');             ;
              $this->form_validation->set_rules('total_ok_meters','Total Ok Meters' ,'required|trim|xss_clean|max_length[10]');
               $this->form_validation->set_rules('release_meters','Release Meters' ,'required|trim|xss_clean|max_length[10]|greater_than[0]|numeric');
              $this->form_validation->set_rules('release_to','Release To' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('release_remarks','Remarks' ,'required|trim|xss_clean|max_length[256]');

              if($this->input->post('release_to')=='1'){

                $this->form_validation->set_rules('release_to_order_no','Release To Order' ,'required|trim|xss_clean|max_length[20]');
                $this->form_validation->set_rules('release_article_no','Release To Article No' ,'callback_check_specification');

                $this->form_validation->set_rules('expected_qty','Expected Qty' ,'required|trim|xss_clean|callback_wip_issue_jobcard_quantity_check');

                //$this->form_validation->set_rules('expected_qty','Expected Qty' ,'required|trim|xss_clean|max_length[50]|callback_printing_jobcard_quantity_check');

              }else{

                $this->form_validation->set_rules('release_to_order_no','Release To Order' ,'trim|xss_clean|max_length[20]');
              }
             

              //if($this->input->post('release_to')=='1' && strpos($this->input->post('order_no'),"ST")!=''){

              if($this->input->post('release_to')=='1' &&  substr($this->input->post('order_no'),0,2)=='ST'){

                //if(substr($this->input->post('order_no'),0,2)!='ST'){
              //if($this->input->post('release_to')=='1'){

                $this->form_validation->set_rules('release_to_order_no_1','Release To Order No' ,'required|trim|xss_clean|max_length[50]'); 
                $this->form_validation->set_rules('release_article_no','Release To Article No' ,'required|trim|xss_clean|max_length[50]');

                //$this->form_validation->set_rules('expected_qty','Expected Qty' ,'required|trim|xss_clean|max_length[50]|callback_printing_jobcard_quantity_check');


              }
              //echo $this->input->post('expected_qty');
              // if($this->input->post('release_to')=='1'){

              //   //echo $this->input->post('expected_qty');

              //     $this->form_validation->set_rules('expected_qty','Expected Qty' ,'required|trim|xss_clean|max_length[50]|callback_printing_jobcard_quantity_check');

              // }

              if($this->input->post('release_article_no')!=''){
                $this->form_validation->set_rules('release_article_no','Release To Article No' ,'callback_check_specification');
              }         


              if($this->form_validation->run()==FALSE){

                $wip_id=$this->input->post('wip_id');               

                $table='springtube_extrusion_wip_master';
                $data['springtube_extrusion_wip_master']=$this->springtube_extrusion_wip_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'wip_id',$wip_id);
                
                //echo $this->db->last_query();

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/wip-release-form',$data);
                $this->load->view('Home/footer');

              }else{ 
                // echo 'validation true';
                // exit;

                  $wip_id='';
                  $wip_id=$this->input->post('wip_id');

                  $status=0;

                  $details_id='';
                  $customer='';
                  $jobcard_no='';
                  $order_no='';
                  $article_no='';
                  $sleeve_diameter='';
                  $sleeve_length='';
                  $total_microns='';
                  $film_mb_2='';
                  $film_mb_6='';
                  $film_code='';
                  $total_ok_meters=0;
                  $pending_meters=0;

                  $total_plan_meters=0;

                  $release_to_bom_no='';
                  $release_to_bom_version_no='';

                  $springtube_extrusion_wip_master_result=$this->common_model->select_one_active_record('springtube_extrusion_wip_master',$this->session->userdata['logged_in']['company_id'],'wip_id',$wip_id);

              
                  foreach($springtube_extrusion_wip_master_result as $row) {

                    $details_id=$row->details_id;
                    $jobcard_no=$row->jobcard_no;
                    $status=$row->status;
                  } 

                if($status==0){
                  
                  $production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no', $jobcard_no);
              
                  foreach($production_master_result as $production_master_row) {
                    $order_no=$production_master_row->sales_ord_no;
                    $article_no=$production_master_row->article_no;
                    $total_plan_meters=$production_master_row->total_meters;
                  }

                  $order_master_result=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$order_no);
                  foreach($order_master_result as $order_master_row){
                    $customer=$order_master_row->customer_no;                      
                  }

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
                
                                             
                  foreach($specs_result as $specs_row){
                      $sleeve_diameter=$specs_row->SLEEVE_DIA;
                      $sleeve_length=$specs_row->SLEEVE_LENGTH;
                      $micron_1=$specs_row->FILM_GUAGE_1;
                      $micron_2=$specs_row->FILM_GUAGE_2;
                      $film_mb_2=$specs_row->FILM_MASTER_BATCH_2;
                      $micron_3=$specs_row->FILM_GUAGE_3;
                      $micron_4=$specs_row->FILM_GUAGE_4;
                      $micron_5=$specs_row->FILM_GUAGE_5;
                      $micron_6=$specs_row->FILM_GUAGE_6;
                      $film_mb_6=$specs_row->FILM_MASTER_BATCH_6;
                      $micron_7=$specs_row->FILM_GUAGE_7;
                       
                  }


                  $total_microns=$micron_1+$micron_2+$micron_3+$micron_4+$micron_5+$micron_6+$micron_7; 

                  // Issuing to Same SO Specs Details----------
                  
                  //if(strpos($this->input->post('order_no'),"ST")!=''){ 

                  if(substr($this->input->post('order_no'),0,2)=='ST'){
                  
                   // Issueing to Diiffrent SO Specs-----------

                      $release_to_order_master_result=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$this->input->post('release_to_order_no_1'));
                        foreach($release_to_order_master_result as $release_to_order_master_row){
                          $release_to_customer=$release_to_order_master_row->customer_no;                      
                        }

                        $data_release_to_order_details=array(
                        'order_no'=>$this->input->post('release_to_order_no_1'),
                        'article_no'=>$this->input->post('release_article_no')
                        );

                        $release_to_order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_release_to_order_details);
                        foreach($release_to_order_details_result as $release_to_order_details_row){
                          $release_to_bom_no=$release_to_order_details_row->spec_id;
                          $release_to_bom_version_no=$release_to_order_details_row->spec_version_no;
                        }

                        $data=array('bom_no'=>$release_to_bom_no,'bom_version_no'=>$release_to_bom_version_no);

                        $release_to_bill_of_material_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data);

                        $release_to_film_code='';

                        foreach ($release_to_bill_of_material_result as $release_to_bill_of_material_row) {
                          $release_to_bom_id=$release_to_bill_of_material_row->bom_id;
                          $release_to_film_code=$release_to_bill_of_material_row->sleeve_code;
                           
                        }

                        //SLEEVE---------------------------------
                        $release_to_film_spec_id='';
                        $release_to_film_spec_version='';

                        $release_to_film_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$release_to_film_code);

                        foreach($release_to_film_code_result as $release_to_film_code_row){                   
                          $release_to_film_spec_id=$release_to_film_code_row->spec_id;
                          $release_to_film_spec_version=$release_to_film_code_row->spec_version_no;
                        }

                        $specs['spec_id']=$release_to_film_spec_id;
                        $specs['spec_version_no']=$release_to_film_spec_version;

                        $release_to_specs_result=$this->sales_order_book_model->select_film_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$specs);
                         
                          $release_to_total_microns=0;
                          foreach($release_to_specs_result as $specs_row){
                            $release_to_sleeve_diameter=$specs_row->SLEEVE_DIA;
                            $release_to_sleeve_length=$specs_row->SLEEVE_LENGTH;
                            $release_to_micron_1=$specs_row->FILM_GUAGE_1;
                            $release_to_micron_2=$specs_row->FILM_GUAGE_2;
                            $release_to_film_mb_2=$specs_row->FILM_MASTER_BATCH_2;
                            $release_to_micron_3=$specs_row->FILM_GUAGE_3;
                            $release_to_micron_4=$specs_row->FILM_GUAGE_4;
                            $release_to_micron_5=$specs_row->FILM_GUAGE_5;
                            $release_to_micron_6=$specs_row->FILM_GUAGE_6;
                            $release_to_film_mb_6=$specs_row->FILM_MASTER_BATCH_6;
                            $release_to_micron_7=$specs_row->FILM_GUAGE_7;
                            
                            $release_to_total_microns=$specs_row->FILM_GUAGE_1+$specs_row->FILM_GUAGE_2+$specs_row->FILM_GUAGE_3+$specs_row->FILM_GUAGE_4+$specs_row->FILM_GUAGE_5+$specs_row->FILM_GUAGE_6+$specs_row->FILM_GUAGE_7;
                          }

                  }                   
                  

                  $total_ok_meters=$this->input->post('total_ok_meters');
                  $release_meters=$this->input->post('release_meters');
                  $pending_meters=0;
                  $pending_meters=$total_ok_meters-$release_meters;


                  $released_weight=0;
                  $weight_result=$this->springtube_extrusion_production_model->get_job_weight_extrusion($jobcard_no,$this->session->userdata['logged_in']['company_id']);

                    $total_weight=0;  
                    foreach ($weight_result as $key => $weight_row) {
                      $total_weight=$this->common_model->read_number($weight_row->total_qty,$this->session->userdata['logged_in']['company_id']);
                    }
                    $one_meter_weight=($total_weight/$total_plan_meters);

                    $released_weight=round($one_meter_weight*$release_meters,2);


                  //TO PRINTING WIP BEFORE PRINT----------------
                  if($this->input->post('release_to')=='1'){                    
                    
                    //Partially release to PRINTING WIP BEFORE PRINT--------------------
                    if($pending_meters>0){

                      //WIP Is releasing to Same SO----------------------
                      //if(strpos($this->input->post('order_no'),"ST")==''){            
                      if(substr($this->input->post('order_no'),0,2)!='ST'){                               

                        $release_qty=$this->common_model->jobcard_meters_to_qty($jobcard_no,$release_meters);

                        $data_wip_before_insert=array(
                        'bprint_wip_date'=>date('Y-m-d'),                      
                        'details_id'=>$details_id,
                        'jobcard_no'=>$jobcard_no,
                        'customer'=>$customer,
                        'order_no'=>$order_no,
                        'article_no'=>$article_no,
                        'sleeve_dia'=>$sleeve_diameter,
                        'sleeve_length'=>$sleeve_length,
                        'total_microns'=>$total_microns,
                        'second_layer_mb'=>$film_mb_2,
                        'sixth_layer_mb'=>$film_mb_6,                           
                        'film_code'=>$film_code,
                        'bwip_cost_per_meter'=>$this->input->post('wip_cost_per_meter'),
                        'bprint_wip_meters'=>$release_meters,
                        'bprint_wip_qty'=>$release_qty,                      
                        'created_date'=>date('Y-m-d H:i:s'),
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'from_process'=>'6',
                        'user_id'=>$this->session->userdata['logged_in']['user_id'],
                        'ref_wip_id'=>$this->input->post('wip_id')
                      );                

                      //$result=$this->common_model->save('springtube_printing_wip_master_before',$data);

                      $pending_ok_qty=$this->common_model->jobcard_meters_to_qty($jobcard_no,$pending_meters);

                      $data_wip_insert=array(
                        'wip_date'=>date('Y-m-d'),                      
                        'details_id'=>$details_id,
                        'jobcard_no'=>$jobcard_no,
                        'customer'=>$customer,
                        'order_no'=>$order_no,
                        'article_no'=>$article_no,
                        'sleeve_dia'=>$sleeve_diameter,
                        'sleeve_length'=>$sleeve_length,
                        'total_microns'=>$total_microns,
                        'second_layer_mb'=>$film_mb_2,
                        'sixth_layer_mb'=>$film_mb_6,                           
                        'film_code'=>$film_code,
                         'wip_cost_per_meter'=>$this->input->post('wip_cost_per_meter'),
                        'total_ok_meters'=>$pending_meters, 
                        'ok_qty'=>$pending_ok_qty,                     
                        'created_date'=>date('Y-m-d H:i:s'),
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'from_process'=>'6',
                        'user_id'=>$this->session->userdata['logged_in']['user_id']                        
                        );

                     

                        //$result=$this->common_model->save('springtube_extrusion_wip_master',$data);

                        $data_wip_update=array(
                          'status'=>'1',
                          'release_to_order_no'=>$this->input->post('order_no'), 
                          'release_meters'=>$release_meters,
                          'release_qty'=>$release_qty,
                          'release_date'=>date('Y-m-d'),
                          'release_by'=>$this->session->userdata['logged_in']['user_id'],
                          'next_process'=>'9',
                          'release_remarks'=>$this->input->post('release_remarks') 
                        );

                        //$result=$this->common_model->update_one_active_record('springtube_extrusion_wip_master',$data,'wip_id',$wip_id,$this->session->userdata['logged_in']['company_id']);


                        $trans_status=$this->springtube_extrusion_wip_model->wip_release_partially($data_wip_before_insert,$data_wip_insert,$data_wip_update,$wip_id);

                      }else{

                       //Stock SO WIP releasing to Other SO---------                     
                        $rel_qty=0;
                        $ups=2;
                        echo $rel_qty=floor(($release_meters*1000)/($release_to_sleeve_length+2.5))*$ups;



                        $data_wip_before_insert=array(
                          'bprint_wip_date'=>date('Y-m-d'),                      
                          'details_id'=>$details_id,
                          'jobcard_no'=>'',
                          'customer'=>$release_to_customer,
                          'order_no'=>$this->input->post('release_to_order_no_1'),
                          'article_no'=>$this->input->post('release_article_no'),
                          'sleeve_dia'=>$release_to_sleeve_diameter,
                          'sleeve_length'=>$release_to_sleeve_length,
                          'total_microns'=>$release_to_total_microns,
                          'second_layer_mb'=>$release_to_film_mb_2,
                          'sixth_layer_mb'=>$release_to_film_mb_6,                           
                          'film_code'=>$release_to_film_code,
                          'bwip_cost_per_meter'=>$this->input->post('wip_cost_per_meter'),
                          'bprint_wip_meters'=>$release_meters,
                          'bprint_wip_qty'=>$rel_qty,
                          //'bprint_wip_qty'=>round(($release_meters*2*1000)/($release_to_sleeve_length+2.5)),
                          'created_date'=>date('Y-m-d H:i:s'),
                          'company_id'=>$this->session->userdata['logged_in']['company_id'],
                          'from_process'=>'6',
                          'user_id'=>$this->session->userdata['logged_in']['user_id'],
                          'ref_wip_id'=>$this->input->post('wip_id')
                        ); 


                        if($this->input->post('outsource')==1){

                        //echo "outsource 456";

                      $data_outsource_for_printing_insert=array(
                        'outsource_date'=>date('Y-m-d'),   
                        'jobcard_no'=>'',
                        'customer'=>$release_to_customer,
                        'order_no'=>$this->input->post('release_to_order_no_1'),
                        'article_no'=>$this->input->post('release_article_no'),
                        'sleeve_dia'=>$release_to_sleeve_diameter,
                        'sleeve_length'=>$release_to_sleeve_length,
                        'total_microns'=>$release_to_total_microns,
                        'second_layer_mb'=>$release_to_film_mb_2,
                        'sixth_layer_mb'=>$release_to_film_mb_6,                           
                        'film_code'=>$release_to_film_code,
                        'cost_per_meter'=>$this->input->post('wip_cost_per_meter'),
                        'released_meters'=>$release_meters, 
                        'company_id'=>$this->session->userdata['logged_in']['company_id']                  
                        );

                      $result=$this->common_model->save('springtube_outsource_for_printing',$data_outsource_for_printing_insert);

                       $count=$this->common_model->active_record_count_where_pkey('tally_stock_items_master',$this->session->userdata['logged_in']['company_id'],'part_no',$release_to_film_code);
                        if($count==0){
                          $data=array('name'=>$this->input->post('film_new_name'),
                          'part_no'=>$release_to_film_code,
                          'units'=>'SQM',
                          'maintain_in_batches'=>'No',
                          'gst_applicable'=>'Applicable',
                          'calculation_type'=>'On Value',
                          'taxability'=>'Taxable',
                          'igst'=>'18',
                          'cgst'=>'9',
                          'utgst'=>'9',
                          'type_of_supply'=>'Goods',
                          'transaction_date'=>date('Y-m-d'),
                          'appl_date'=>'01-07-2017');

                          $this->common_model->save(' tally_stock_items_master',$data);

                        }

                      }

                        //$result=$this->common_model->save('springtube_printing_wip_master_before',$data);

                        $pending_ok_qty=$this->common_model->jobcard_meters_to_qty($jobcard_no,$pending_meters);

                        $data_wip_insert=array(
                          'wip_date'=>date('Y-m-d'),                      
                          'details_id'=>$details_id,
                          'jobcard_no'=>$jobcard_no,
                          'customer'=>$customer,
                          'order_no'=>$order_no,
                          'article_no'=>$article_no,
                          'sleeve_dia'=>$sleeve_diameter,
                          'sleeve_length'=>$sleeve_length,
                          'total_microns'=>$total_microns,
                          'second_layer_mb'=>$film_mb_2,
                          'sixth_layer_mb'=>$film_mb_6,                           
                          'film_code'=>$film_code,
                           'wip_cost_per_meter'=>$this->input->post('wip_cost_per_meter'),
                          'total_ok_meters'=>$pending_meters, 
                          'ok_qty'=>$pending_ok_qty,                     
                          'created_date'=>date('Y-m-d H:i:s'),
                          'company_id'=>$this->session->userdata['logged_in']['company_id'],
                          'from_process'=>'6',
                          'user_id'=>$this->session->userdata['logged_in']['user_id']                        
                        );

                        //$result=$this->common_model->save('springtube_extrusion_wip_master',$data);

                        $data_wip_update=array(
                          'status'=>'1',
                          'release_to_order_no'=>$this->input->post('release_to_order_no_1'), 
                          'release_meters'=>$release_meters,
                          'release_qty'=>$rel_qty,
                          'release_date'=>date('Y-m-d'),
                          'release_by'=>$this->session->userdata['logged_in']['user_id'],
                          'next_process'=>'9',
                          'release_remarks'=>$this->input->post('release_remarks') 
                        );

                        //$result=$this->common_model->update_one_active_record('springtube_extrusion_wip_master',$data,'wip_id',$wip_id,$this->session->userdata['logged_in']['company_id']);

                        $trans_status=$this->springtube_extrusion_wip_model->wip_release_partially($data_wip_before_insert,$data_wip_insert,$data_wip_update,$wip_id);

                      }                    



                    }else{ 
                    
                      // FUll release to PRINTING WIP BEFORE PRINT--------------------

                       //WIP Is releasing to Same SO----------------------

                      //if(strpos($this->input->post('order_no'),"ST")==''){


                      if(substr($this->input->post('order_no'),0,2)!='ST'){
                          
                        $release_qty=$this->common_model->jobcard_meters_to_qty($jobcard_no,$release_meters);

                        $data_wip_before_insert=array(
                          'bprint_wip_date'=>date('Y-m-d'),                      
                          'details_id'=>$details_id,
                          'jobcard_no'=>$jobcard_no,
                          'customer'=>$customer,
                          'order_no'=>$this->input->post('release_to_order_no'),
                          'article_no'=>$article_no,
                          'sleeve_dia'=>$sleeve_diameter,
                          'sleeve_length'=>$sleeve_length,
                          'total_microns'=>$total_microns,
                          'second_layer_mb'=>$film_mb_2,
                          'sixth_layer_mb'=>$film_mb_6,                           
                          'film_code'=>$film_code,
                          'bwip_cost_per_meter'=>$this->input->post('wip_cost_per_meter'), 
                          'bprint_wip_meters'=>$release_meters,
                          'bprint_wip_qty'=>$release_qty,
                          'created_date'=>date('Y-m-d H:i:s'),
                          'company_id'=>$this->session->userdata['logged_in']['company_id'],
                          'from_process'=>'6',
                          'user_id'=>$this->session->userdata['logged_in']['user_id'],
                          'ref_wip_id'=>$this->input->post('wip_id')
                        );                

                        //$result=$this->common_model->save('springtube_printing_wip_master_before',$data);

                        $data_wip_update=array( 
                                    'status'=>'1',
                                    'release_to_order_no'=>$this->input->post('order_no'),
                                    'release_meters'=>$release_meters,
                                    'release_qty'=>$release_qty,
                                    'release_date'=>date('Y-m-d'),
                                    'release_by'=>$this->session->userdata['logged_in']['user_id'],
                                    'next_process'=>'9',
                                    'release_remarks'=>$this->input->post('release_remarks')
                                  );
                        //$result=$this->common_model->update_one_active_record('springtube_extrusion_wip_master',$data,'wip_id',$wip_id,$this->session->userdata['logged_in']['company_id']);

                        $trans_status=$this->springtube_extrusion_wip_model->wip_release_full($data_wip_before_insert,$data_wip_update,$wip_id);
                        
                      }else{ 

                      // FUll release do Diffrent SO
                        $rel_qty=0;
                        $ups=2;
                        $rel_qty=floor(($release_meters*1000)/($release_to_sleeve_length+2.5))*$ups;

                        $data_wip_before_insert=array(
                          'bprint_wip_date'=>date('Y-m-d'),                      
                          'details_id'=>$details_id,
                          'jobcard_no'=>'',
                          'customer'=>$release_to_customer,
                          'order_no'=>$this->input->post('release_to_order_no_1'),
                          'article_no'=>$this->input->post('release_article_no'),
                          'sleeve_dia'=>$release_to_sleeve_diameter,
                          'sleeve_length'=>$release_to_sleeve_length,
                          'total_microns'=>$release_to_total_microns,
                          'second_layer_mb'=>$release_to_film_mb_2,
                          'sixth_layer_mb'=>$release_to_film_mb_6,                           
                          'film_code'=>$release_to_film_code,
                          'bwip_cost_per_meter'=>$this->input->post('wip_cost_per_meter'),
                          'bprint_wip_meters'=>$release_meters,
                          'bprint_wip_qty'=>$rel_qty,                      
                          'created_date'=>date('Y-m-d H:i:s'),
                          'company_id'=>$this->session->userdata['logged_in']['company_id'],
                          'from_process'=>'6',
                          'user_id'=>$this->session->userdata['logged_in']['user_id'],
                          'ref_wip_id'=>$this->input->post('wip_id')
                        );  


                        if($this->input->post('outsource')==1){

                        //echo "outsource 123";

                      $data_outsource_for_printing_insert=array(
                        'outsource_date'=>date('Y-m-d'),   
                        'jobcard_no'=>'',
                        'customer'=>$release_to_customer,
                        'order_no'=>$this->input->post('release_to_order_no_1'),
                        'article_no'=>$this->input->post('release_article_no'),
                        'sleeve_dia'=>$release_to_sleeve_diameter,
                        'sleeve_length'=>$release_to_sleeve_length,
                        'total_microns'=>$release_to_total_microns,
                        'second_layer_mb'=>$release_to_film_mb_2,
                        'sixth_layer_mb'=>$release_to_film_mb_6,                           
                        'film_code'=>$release_to_film_code,
                        'cost_per_meter'=>$this->input->post('wip_cost_per_meter'),
                        'released_meters'=>$release_meters, 
                        'company_id'=>$this->session->userdata['logged_in']['company_id']                  
                        );

                        $result=$this->common_model->save('springtube_outsource_for_printing',$data_outsource_for_printing_insert);

                        $count=$this->common_model->active_record_count_where_pkey('tally_stock_items_master',$this->session->userdata['logged_in']['company_id'],'part_no',$release_to_film_code);
                        if($count==0){

                        $data=array('name'=>$this->input->post('film_new_name'),
                        'part_no'=>$release_to_film_code,
                        'units'=>'SQM',
                        'maintain_in_batches'=>'No',
                        'gst_applicable'=>'Applicable',
                        'calculation_type'=>'On Value',
                        'taxability'=>'Taxable',
                        'igst'=>'18',
                        'cgst'=>'9',
                        'utgst'=>'9',
                        'type_of_supply'=>'Goods',
                        'transaction_date'=>date('Y-m-d'),
                        'appl_date'=>'01-07-2017');

                        $this->common_model->save(' tally_stock_items_master',$data);
                        }

                      }              

                        //$result=$this->common_model->save('springtube_printing_wip_master_before',$data);
                         
                        //$result=$this->common_model->save('springtube_extrusion_wip_master',$data);

                        $data_wip_update=array(
                          'status'=>'1',
                          'release_to_order_no'=>$this->input->post('release_to_order_no_1'), 
                          'release_meters'=>$release_meters,
                          'release_qty'=>$rel_qty,
                          'release_date'=>date('Y-m-d'),
                          'release_by'=>$this->session->userdata['logged_in']['user_id'],
                          'next_process'=>'9',
                          'release_remarks'=>$this->input->post('release_remarks') 
                        );

                        //$result=$this->common_model->update_one_active_record('springtube_extrusion_wip_master',$data,'wip_id',$wip_id,$this->session->userdata['logged_in']['company_id']);

                        $trans_status=$this->springtube_extrusion_wip_model->wip_release_full($data_wip_before_insert,$data_wip_update,$wip_id);


                      } // Else Diffrent SO                    

                    }//ELSE FULL RELEASE


                  }else{  // TO EXTRUSION WIP TO SCRAP---

                    //$pending_meters=$total_ok_meters-$release_meters;

                    //Partially release to EXTRUSION WIP Scrap 

                    if($pending_meters>0){

                      $scrap_qty=$this->common_model->jobcard_meters_to_qty($jobcard_no,$release_meters); 

                      $data_scrap_insert=array(
                        'scrap_date'=>$this->input->post('release_date'),                      
                        'details_id'=>$details_id,
                        'jobcard_no'=>$jobcard_no,
                        'customer'=>$customer,
                        'order_no'=>$order_no,
                        'article_no'=>$article_no,
                        'sleeve_dia'=>$sleeve_diameter,
                        'sleeve_length'=>$sleeve_length,
                        'total_microns'=>$total_microns,
                        'second_layer_mb'=>$film_mb_2,
                        'sixth_layer_mb'=>$film_mb_6,                           
                        'film_code'=>$film_code,
                        'scrap_cost_per_meter'=>$this->input->post('wip_cost_per_meter'),                                          
                        'total_scrap_meters'=>$release_meters,
                        'scrap_qty'=>$scrap_qty, 
                        'scrap_weight'=>$released_weight,                    
                        'created_date'=>date('Y-m-d H:i:s'),
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'from_process'=>'6',
                        'user_id'=>$this->session->userdata['logged_in']['user_id'],
                        'ref_wip_id'=>$this->input->post('wip_id')
                      );                

                      //$result=$this->common_model->save('springtube_extrusion_scrap_master',$data);

                      $pending_ok_qty=$this->common_model->jobcard_meters_to_qty($jobcard_no,$pending_meters);
                      
                      $data_wip_insert=array(
                        'wip_date'=>date('Y-m-d'),                      
                        'details_id'=>$details_id,
                        'jobcard_no'=>$jobcard_no,
                        'customer'=>$customer,
                        'order_no'=>$order_no,
                        'article_no'=>$article_no,
                        'sleeve_dia'=>$sleeve_diameter,
                        'sleeve_length'=>$sleeve_length,
                        'total_microns'=>$total_microns,
                        'second_layer_mb'=>$film_mb_2,
                        'sixth_layer_mb'=>$film_mb_6,                           
                        'film_code'=>$film_code,
                        'wip_cost_per_meter'=>$this->input->post('wip_cost_per_meter'),
                        'total_ok_meters'=>$pending_meters,
                        'ok_qty'=>$pending_ok_qty,                      
                        'created_date'=>date('Y-m-d H:i:s'),
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'from_process'=>'6',
                        'user_id'=>$this->session->userdata['logged_in']['user_id']                        
                        );

                        //$result=$this->common_model->save('springtube_extrusion_wip_master',$data_1);

                        $data_wip_update=array('status'=>'1',
                                    'release_to_order_no'=>$order_no,
                                    'release_meters'=>$release_meters,
                                    'release_qty'=>$scrap_qty,
                                    'release_date'=>$this->input->post('release_date'),
                                    'release_by'=>$this->session->userdata['logged_in']['user_id'],
                                    'next_process'=>'16',
                                    'release_remarks'=>$this->input->post('release_remarks')
                                  );

                        //$result=$this->common_model->update_one_active_record('springtube_extrusion_wip_master',$data_2,'wip_id',$wip_id,$this->session->userdata['logged_in']['company_id']);

                        $trans_status=$this->springtube_extrusion_wip_model->wip_to_scrap_partially($data_scrap_insert,$data_wip_insert,$data_wip_update,$wip_id);



                    }else{ // FUll release to SCRAP

                      $scrap_qty=$this->common_model->jobcard_meters_to_qty($jobcard_no,$release_meters);

                      $data_scrap_insert=array(
                        'scrap_date'=>$this->input->post('release_date'),                      
                        'details_id'=>$details_id,
                        'jobcard_no'=>$jobcard_no,
                        'customer'=>$customer,
                        'order_no'=>$order_no,
                        'article_no'=>$article_no,
                        'sleeve_dia'=>$sleeve_diameter,
                        'sleeve_length'=>$sleeve_length,
                        'total_microns'=>$total_microns,
                        'second_layer_mb'=>$film_mb_2,
                        'sixth_layer_mb'=>$film_mb_6,                           
                        'film_code'=>$film_code,
                        'scrap_cost_per_meter'=>$this->input->post('wip_cost_per_meter'),
                        'total_scrap_meters'=>$release_meters,
                        'scrap_qty'=>$scrap_qty,
                        'scrap_weight'=>$released_weight,                      
                        'created_date'=>date('Y-m-d H:i:s'),
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'from_process'=>'6',
                        'user_id'=>$this->session->userdata['logged_in']['user_id'],
                        'ref_wip_id'=>$this->input->post('wip_id')
                      );                

                      //$result=$this->common_model->save('springtube_extrusion_scrap_master',$data);

                      $data_wip_update=array( 'status'=>'1',
                                    'release_to_order_no'=>$order_no,
                                    'release_meters'=>$release_meters,
                                    'release_qty'=>$scrap_qty,
                                    'release_date'=>$this->input->post('release_date'),
                                    'release_by'=>$this->session->userdata['logged_in']['user_id'],
                                    'next_process'=>'16',
                                    'release_remarks'=>$this->input->post('release_remarks')
                                  );
                      //$result=$this->common_model->update_one_active_record('springtube_extrusion_wip_master',$data_1,'wip_id',$wip_id,$this->session->userdata['logged_in']['company_id']);

                      $trans_status=$this->springtube_extrusion_wip_model->wip_to_scrap_full($data_scrap_insert,$data_wip_update,$wip_id);


                    }                   


                  }///ELSE SCRAP

                  if($trans_status){
                     $data['note']='WIP Release Transaction Completed';
                  }else{
                    $data['error']='WIP Release Transaction Failed';
                  }
                 

              }                 
              else{

                  $data['error']='WIP already Released';
              }
                  
                
                  $table='springtube_extrusion_wip_master';
                  $data['springtube_extrusion_wip_master']=$this->springtube_extrusion_wip_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'wip_id',$wip_id);

                  $data['page_name']='Production';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());                 

                  header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/wip-release-form',$data);
                $this->load->view('Home/footer');
              }       
               
              
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

  function check_specification(){

    //echo 'function call';

    $order_no='';
    $article_no='';
    $bom_no='';
    $bom_version_no='';
    $bom_id='';
    $film_code='';

    $sleeve_diameter='';
    $sleeve_length='';
    // Layer 1
    $micron_1='';
    $film_ldpe_1='';
    $film_ldpe_perc_1='';
    $film_lldpe_1='';
    $film_lldpe_perc_1='';
    //Layer 2
    $micron_2='';
    $film_mb_2='';
    $film_mb_perc_2='';
    $film_lldpe_2='';
    $film_lldpe_perc_2='';
    $film_hdpe_2='';
    $film_hdpe_perc_2='';
    //Layer 3
    $micron_3='';
    $film_admer_3='';
    $film_admer_perc_3='';
    //Layer 4
    $micron_4='';
    $film_evoh_4='';
    $film_evoh_perc_4='';
    //Layer 5
    $micron_5='';
    $film_admer_5='';
    $film_admer_perc_5='';
    //Layer 6
    $micron_6='';
    $film_mb_6='';
    $film_mb_perc_6='';
    $film_lldpe_6='';
    $film_lldpe_perc_6='';
    $film_hdpe_6='';
    $film_hdpe_perc_6='';
    // Layer 7
    $micron_7='';
    $film_ldpe_7='';
    $film_ldpe_perc_7='';
    $film_lldpe_7='';
    $film_lldpe_perc_7='';



    $production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no', $this->input->post('jobcard_no'));
              
    foreach($production_master_result as $row) {
      $order_no=$row->sales_ord_no;
      $article_no=$row->article_no;
    }

    // $order_master_result=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$order_no);
    // foreach($order_master_result as $order_master_row){
    //   $customer=$order_master_row->customer_no;                      
    // }

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
      
    if($specs_result){

      $total_microns=0;
      foreach($specs_result as $specs_row){
        $sleeve_diameter=$specs_row->SLEEVE_DIA;
        $sleeve_length=$specs_row->SLEEVE_LENGTH;
        // Layer 1
        $micron_1=$specs_row->FILM_GUAGE_1;
        $film_ldpe_1=$specs_row->FILM_LDPE_1;
        $film_ldpe_perc_1=$specs_row->FILM_LDPE_PERC_1;
        $film_lldpe_1=$specs_row->FILM_LLDPE_1;
        $film_lldpe_perc_1=$specs_row->FILM_LLDPE_PERC_1;
        //Layer 2
        $micron_2=$specs_row->FILM_GUAGE_2;
        $film_mb_2=$specs_row->FILM_MASTER_BATCH_2;
        $film_mb_perc_2=$specs_row->FILM_MB_PERC_2;
        $film_lldpe_2=$specs_row->FILM_LLDPE_2;
        $film_lldpe_perc_2=$specs_row->FILM_LLDPE_PERC_2;
        $film_hdpe_2=$specs_row->FILM_HDPE_2;
        $film_hdpe_perc_2=$specs_row->FILM_HDPE_PERC_2;
        //Layer 3
        $micron_3=$specs_row->FILM_GUAGE_3;
        $film_admer_3=$specs_row->FILM_ADMER_3;
        $film_admer_perc_3=$specs_row->FILM_ADMER_PERC_3;
        //Layer 4
        $micron_4=$specs_row->FILM_GUAGE_4;
        $film_evoh_4=$specs_row->FILM_EVOH_4;
        $film_evoh_perc_4=$specs_row->FILM_EVOH_PERC_4;
        //Layer 5
        $micron_5=$specs_row->FILM_GUAGE_5;
        $film_admer_5=$specs_row->FILM_ADMER_5;
        $film_admer_perc_5=$specs_row->FILM_ADMER_PERC_5;
        //Layer 6
        $micron_6=$specs_row->FILM_GUAGE_6;
        $film_mb_6=$specs_row->FILM_MASTER_BATCH_6;
        $film_mb_perc_6=$specs_row->FILM_MB_PERC_6;
        $film_lldpe_6=$specs_row->FILM_LLDPE_6;
        $film_lldpe_perc_6=$specs_row->FILM_LLDPE_PERC_6;
        $film_hdpe_6=$specs_row->FILM_HDPE_6;
        $film_hdpe_perc_6=$specs_row->FILM_HDPE_PERC_6;
        // Layer 7
        $micron_7=$specs_row->FILM_GUAGE_7;
        $film_ldpe_7=$specs_row->FILM_LDPE_7;
        $film_ldpe_perc_7=$specs_row->FILM_LDPE_PERC_7;
        $film_lldpe_7=$specs_row->FILM_LLDPE_7;
        $film_lldpe_perc_7=$specs_row->FILM_LLDPE_PERC_7;

      }                      

    } 


    // Release to order details---------------------

    $release_to_customer='';
    $release_to_order_no='';
    $release_to_article_no='';
    $release_to_bom_no='';
    $release_to_bom_version_no='';
    $release_to_bom_id='';
    $release_to_film_code='';

    $release_to_sleeve_diameter='';
    $release_to_sleeve_length='';
    // Layer 1
    $release_to_micron_1='';
    $release_to_film_ldpe_1='';
    $release_to_film_ldpe_perc_1='';
    $release_to_film_lldpe_1='';
    $release_to_film_lldpe_perc_1='';
    //Layer 2
    $release_to_micron_2='';
    $release_to_film_mb_2='';
    $release_to_film_mb_perc_2='';
    $release_to_film_lldpe_2='';
    $release_to_film_lldpe_perc_2='';
    $release_to_film_hdpe_2='';
    $release_to_film_hdpe_perc_2='';
    //Layer 3
    $release_to_micron_3='';
    $release_to_film_admer_3='';
    $release_to_film_admer_perc_3='';
    //Layer 4
    $release_to_micron_4='';
    $release_to_film_evoh_4='';
    $release_to_film_evoh_perc_4='';
    //Layer 5
    $release_to_micron_5='';
    $release_to_film_admer_5='';
    $release_to_film_admer_perc_5='';
    //Layer 6
    $release_to_micron_6='';
    $release_to_film_mb_6='';
    $release_to_film_mb_perc_6='';
    $release_to_film_lldpe_6='';
    $release_to_film_lldpe_perc_6='';
    $release_to_film_hdpe_6='';
    $release_to_film_hdpe_perc_6='';
    // Layer 7
    $release_to_micron_7='';
    $release_to_film_ldpe_7='';
    $release_to_film_ldpe_perc_7='';
    $release_to_film_lldpe_7='';
    $release_to_film_lldpe_perc_7='';

    //echo 'release'.$this->input->post('release_to_order_no_1');
    $release_to_order_master_result=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$this->input->post('release_to_order_no_1'));
    foreach($release_to_order_master_result as $release_to_order_master_row){
      $release_to_customer=$release_to_order_master_row->customer_no;                      
    }

    $data_release_to_order_details=array(
    'order_no'=>$this->input->post('release_to_order_no_1'),
    'article_no'=>$this->input->post('release_article_no')
    );

    $release_to_order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_release_to_order_details);
    foreach($release_to_order_details_result as $release_to_order_details_row){
      $release_to_bom_no=$release_to_order_details_row->spec_id;
      $release_to_bom_version_no=$release_to_order_details_row->spec_version_no;
    }

    $data=array('bom_no'=>$release_to_bom_no,'bom_version_no'=>$release_to_bom_version_no);

    $release_to_bill_of_material_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data);

    foreach ($release_to_bill_of_material_result as $release_to_bill_of_material_row) {
      $release_to_bom_id=$release_to_bill_of_material_row->bom_id;
      $release_to_film_code=$release_to_bill_of_material_row->sleeve_code;
       
    }

    //SLEEVE---------------------------------
    $release_to_film_spec_id='';
    $release_to_film_spec_version='';

    $release_to_film_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$release_to_film_code);

    foreach($release_to_film_code_result as $release_to_film_code_row){                   
      $release_to_film_spec_id=$release_to_film_code_row->spec_id;
      $release_to_film_spec_version=$release_to_film_code_row->spec_version_no;
    }

    $specs['spec_id']=$release_to_film_spec_id;
    $specs['spec_version_no']=$release_to_film_spec_version;

    $release_to_specs_result=$this->sales_order_book_model->select_film_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$specs);
     
//print_r($release_to_specs_result);

    if($release_to_specs_result){

      $release_total_microns=0;
      foreach($release_to_specs_result as $specs_row){
        $release_to_sleeve_diameter=$specs_row->SLEEVE_DIA;
        $release_to_sleeve_length=$specs_row->SLEEVE_LENGTH;
        // Layer 1
        $release_to_micron_1=$specs_row->FILM_GUAGE_1;
        $release_to_film_ldpe_1=$specs_row->FILM_LDPE_1;
        $release_to_film_ldpe_perc_1=$specs_row->FILM_LDPE_PERC_1;
        $release_to_film_lldpe_1=$specs_row->FILM_LLDPE_1;
        $release_to_film_lldpe_perc_1=$specs_row->FILM_LLDPE_PERC_1;
        //Layer 2
        $release_to_micron_2=$specs_row->FILM_GUAGE_2;
        $release_to_film_mb_2=$specs_row->FILM_MASTER_BATCH_2;
        $release_to_film_mb_perc_2=$specs_row->FILM_MB_PERC_2;
        $release_to_film_lldpe_2=$specs_row->FILM_LLDPE_2;
        $release_to_film_lldpe_perc_2=$specs_row->FILM_LLDPE_PERC_2;
        $release_to_film_hdpe_2=$specs_row->FILM_HDPE_2;
        $release_to_film_hdpe_perc_2=$specs_row->FILM_HDPE_PERC_2;
        //Layer 3
        $release_to_micron_3=$specs_row->FILM_GUAGE_3;
        $release_to_film_admer_3=$specs_row->FILM_ADMER_3;
        $release_to_film_admer_perc_3=$specs_row->FILM_ADMER_PERC_3;
        //Layer 4
        $release_to_micron_4=$specs_row->FILM_GUAGE_4;
        $release_to_film_evoh_4=$specs_row->FILM_EVOH_4;
        $release_to_film_evoh_perc_4=$specs_row->FILM_EVOH_PERC_4;
        //Layer 5
        $release_to_micron_5=$specs_row->FILM_GUAGE_5;
        $release_to_film_admer_5=$specs_row->FILM_ADMER_5;
        $release_to_film_admer_perc_5=$specs_row->FILM_ADMER_PERC_5;
        //Layer 6
        $release_to_micron_6=$specs_row->FILM_GUAGE_6;
        $release_to_film_mb_6=$specs_row->FILM_MASTER_BATCH_6;
        $release_to_film_mb_perc_6=$specs_row->FILM_MB_PERC_6;
        $release_to_film_lldpe_6=$specs_row->FILM_LLDPE_6;
        $release_to_film_lldpe_perc_6=$specs_row->FILM_LLDPE_PERC_6;
        $release_to_film_hdpe_6=$specs_row->FILM_HDPE_6;
        $release_to_film_hdpe_perc_6=$specs_row->FILM_HDPE_PERC_6;
        // Layer 7
        $release_to_micron_7=$specs_row->FILM_GUAGE_7;
        $release_to_film_ldpe_7=$specs_row->FILM_LDPE_7;
        $release_to_film_ldpe_perc_7=$specs_row->FILM_LDPE_PERC_7;
        $release_to_film_lldpe_7=$specs_row->FILM_LLDPE_7;
        $release_to_film_lldpe_perc_7=$specs_row->FILM_LLDPE_PERC_7;

        $release_total_microns=$specs_row->FILM_GUAGE_1+$specs_row->FILM_GUAGE_2+$specs_row->FILM_GUAGE_3+$specs_row->FILM_GUAGE_4+$specs_row->FILM_GUAGE_5+$specs_row->FILM_GUAGE_6+$specs_row->FILM_GUAGE_7;
      }                      

    } 

    $flag_sleeve_diameter=0;
    $flag_micron_1=0;
     
    $flag_film_ldpe_1=0;
    $flag_film_ldpe_perc_1=0;
    $flag_film_lldpe_1=0;
    $flag_film_lldpe_perc_1=0;
    //Layer 2
    $flag_micron_2=0;
    $flag_film_mb_2=0;
    $flag_film_mb_perc_2=0;
    $flag_film_lldpe_2=0;
    $flag_film_lldpe_perc_2=0;
    $flag_film_hdpe_2=0;
    $flag_film_hdpe_perc_2=0;
    //Layer 3
    $flag_micron_3=0;
    $flag_film_admer_3=0;
    $flag_film_admer_perc_3=0;
    //Layer 4
    $flag_micron_4=0;
    $flag_film_evoh_4=0;
    $flag_film_evoh_perc_4=0;
    //Layer 5
    $flag_micron_5=0;
    $flag_film_admer_5=0;
    $flag_film_admer_perc_5=0;
    //Layer 6
    $flag_micron_6=0;
    $flag_film_mb_6=0;
    $flag_film_mb_perc_6=0;
    $flag_film_lldpe_6=0;
    $flag_film_lldpe_perc_6=0;
    $flag_film_hdpe_6=0;
    $flag_film_hdpe_perc_6=0;
    // Layer 7
    $flag_micron_7=0;
    $flag_film_ldpe_7=0;
    $flag_film_ldpe_perc_7=0;
    $flag_film_lldpe_7=0;
    $flag_film_lldpe_perc_7=0;

    //echo $sleeve_diameter.','.$release_to_sleeve_diameter;
    if($sleeve_diameter!=$release_to_sleeve_diameter){

      $this->form_validation->set_message('check_specification', 'In release order specs Dia doesnot matches');
      $flag_sleeve_diameter=1;
      return false;

    }
    // Layer 1 Specs Checking--------------------------
    if($micron_1!=$release_to_micron_1){

      $this->form_validation->set_message('check_specification', 'In release order specs Layer 1 - Guage doesnot matches');
      $flag_micron_1=1;
      return false;
    }

    if($film_ldpe_1!=$release_to_film_ldpe_1){

      $this->form_validation->set_message('check_specification', 'In release order specs Layer 1 - LDPE doesnot matches');
      $flag_film_ldpe_1=1;
      return false;
    }

    if($film_ldpe_perc_1!=$release_to_film_ldpe_perc_1){

      $this->form_validation->set_message('check_specification', 'In release order specs Layer 1 - LDPE Perc doesnot matches');
      $flag_film_ldpe_perc_1=1;
      return false;
    }

    if($film_lldpe_1!=$release_to_film_lldpe_1){

      $this->form_validation->set_message('check_specification', 'In release order specs Layer 1 - LLDPE doesnot matches');
      $flag_film_lldpe_1=1;
      return false;
    }

    if($film_lldpe_perc_1!=$release_to_film_lldpe_perc_1){

      $this->form_validation->set_message('check_specification', 'In release order specs Layer 1 - LLDPE Perc doesnot matches');
      $flag_film_lldpe_perc_1=1;
      return false;
    }


     // Layer 2 Specs Checking--------------------------
    if($micron_2!=$release_to_micron_2){

      $this->form_validation->set_message('check_specification', 'In release order specs Layer 2 - Guage doesnot matches');
      $flag_micron_2=1;
    }
    if($film_mb_2!=$release_to_film_mb_2){

      $this->form_validation->set_message('check_specification', 'In release order specs Layer 2 - MB doesnot matches');
      $flag_film_mb_2=1;
      return false;
    }

    if($film_mb_perc_2!=$release_to_film_mb_perc_2){

      $this->form_validation->set_message('check_specification', 'In release order specs Layer 2 - MB Perc doesnot matches');
      $flag_film_mb_perc_2=1;
      return false;

    }

    if($film_lldpe_2!=$release_to_film_lldpe_2){

      $this->form_validation->set_message('check_specification', 'In release order specs Layer 2 - LLDPE doesnot matches');
      $flag_film_lldpe_2=1;
      return false;
    }

    if($film_lldpe_perc_2!=$release_to_film_lldpe_perc_2){

      $this->form_validation->set_message('check_specification', 'In release order specs Layer 2 - LLDPE Perc doesnot matches');
      $flag_film_lldpe_perc_2=1;
      return false;
    }

    if($film_hdpe_2!=$release_to_film_hdpe_2){

      $this->form_validation->set_message('check_specification', 'In release order specs Layer 2 - HDPE doesnot matches');
      $flag_film_hdpe_2=1;
      return false;
    }

    if($film_hdpe_perc_2!=$release_to_film_hdpe_perc_2){

      $this->form_validation->set_message('check_specification', 'In release order specs Layer 2 - HDPE Perc doesnot matches');
      $flag_film_hdpe_perc_2=1;
      return false;
    }

    // Layer 3 Specs Checking--------------------------
    if($micron_3!=$release_to_micron_3){

      $this->form_validation->set_message('check_specification', 'In release order specs Layer 3 - Guage doesnot matches');
      $flag_micron_3=1;
      return false;
    }

    if($film_admer_3!=$release_to_film_admer_3){

      $this->form_validation->set_message('check_specification', 'In release order specs Layer 3 - ADMER doesnot matches');
      $flag_film_admer_3=1;
      return false;
    }

    if($film_admer_perc_3!=$release_to_film_admer_perc_3){

      $this->form_validation->set_message('check_specification', 'In release order specs Layer 3 - ADMER Perc doesnot matches');
      $flag_film_admer_perc_3=1;
      return false;
    }

    // Layer 4 Specs Checking--------------------------
    if($micron_4!=$release_to_micron_4){

      $this->form_validation->set_message('check_specification', 'In release order specs Layer 4 - Guage doesnot matches');
      $flag_micron_4=1;
      return false;
    }

    if($film_evoh_4!=$release_to_film_evoh_4){

      $this->form_validation->set_message('check_specification', 'In release order specs Layer 4 - EVOH doesnot matches');
      $flag_film_evoh_4=1;
      return false;
    }

    if($film_evoh_perc_4!=$release_to_film_evoh_perc_4){

      $this->form_validation->set_message('check_specification', 'In release order specs Layer 4 - EVOH Perc doesnot matches');
      $flag_film_evoh_perc_4=1;
    }


  // Layer 5 Specs Checking--------------------------
    if($micron_5!=$release_to_micron_5){

      $this->form_validation->set_message('check_specification', 'In release order specs Layer 5 - Guage doesnot matches');
      $flag_micron_5=1;
      return false;
    }

    if($film_admer_5!=$release_to_film_admer_5){

      $this->form_validation->set_message('check_specification', 'In release order specs Layer 5 - ADMER doesnot matches');
      $flag_film_admer_5=1;
      return false;
    }

    if($film_admer_perc_5!=$release_to_film_admer_perc_5){

      $this->form_validation->set_message('check_specification', 'In release order specs Layer 5 - ADMER Perc doesnot matches');
      $flag_film_admer_perc_5=1;
      return false;
    }

    // Layer 6 Specs Checking--------------------------

    if($micron_6!=$release_to_micron_6){

      $this->form_validation->set_message('check_specification', 'In release order specs Layer 6 - Guage doesnot matches');
      $flag_micron_6=1;
      return false;
    }
    if($film_mb_6!=$release_to_film_mb_6){

      $this->form_validation->set_message('check_specification', 'In release order specs Layer 6 - MASTER BATCH doesnot matches');
      $flag_film_mb_6=1;
      return false;
    }

    if($film_mb_perc_6!=$release_to_film_mb_perc_6){

      $this->form_validation->set_message('check_specification', 'In release order specs Layer 6 - MASTER BATCH Perc doesnot matches');
      $flag_film_mb_perc_6=1;
      return false;
    }

    if($film_lldpe_6!=$release_to_film_lldpe_6){

      $this->form_validation->set_message('check_specification', 'In release order specs Layer 6 - LLDPE doesnot matches');
      $flag_film_lldpe_6=1;
      return false;
    }

    if($film_lldpe_perc_6!=$release_to_film_lldpe_perc_6){

      $this->form_validation->set_message('check_specification', 'In release order specs Layer 6 - LLDPE Perc doesnot matches');
      $flag_film_lldpe_perc_6=1;
      return false;
    }

    if($film_hdpe_6!=$release_to_film_hdpe_6){

      $this->form_validation->set_message('check_specification', 'In release order specs Layer 6 - HDPE doesnot matches');
      $flag_film_hdpe_6=1;
      return false;
    }

    if($film_hdpe_perc_6!=$release_to_film_hdpe_perc_6){

      $this->form_validation->set_message('check_specification', 'In release order specs Layer 6 - HDPE Perc doesnot matches');
      $flag_film_hdpe_perc_6=1;
      return false;
    }


    // Layer 7 Specs Checking--------------------------
    if($micron_7!=$release_to_micron_7){

      $this->form_validation->set_message('check_specification', 'In release order specs Layer 7 - Guage doesnot matches');
      $flag_micron_7=1;
      return false;
    }

    if($film_ldpe_7!=$release_to_film_ldpe_7){

      $this->form_validation->set_message('check_specification', 'In release order specs Layer 7 - LDPE doesnot matches');
      $flag_film_ldpe_7=1;
      return false;
    }

    if($film_ldpe_perc_7!=$release_to_film_ldpe_perc_7){

      $this->form_validation->set_message('check_specification', 'In release order specs Layer 7 - LDPE Perc doesnot matches');
      $flag_film_ldpe_perc_7=1;
      return false;
    }

    if($film_lldpe_7!=$release_to_film_lldpe_7){

      $this->form_validation->set_message('check_specification', 'In release order specs Layer 7 - LLDPE doesnot matches');
      $flag_film_lldpe_7=1;
      return false;
    }

    if($film_lldpe_perc_7!=$release_to_film_lldpe_perc_7){

      $this->form_validation->set_message('check_specification', 'In release order specs Layer 7 - LLDPE Perc doesnot matches');
      $flag_film_lldpe_perc_7=1;
      return false;
    }


    // Final Specs Check ------------------
    if($flag_sleeve_diameter==1 || $flag_micron_1==1 || $flag_film_ldpe_1==1 || $flag_film_ldpe_perc_1==1 || $flag_film_lldpe_1==1 || $flag_film_lldpe_perc_1==1 || $flag_micron_2==1 || $flag_film_mb_2==1 || $flag_film_mb_perc_2==1 || $flag_film_lldpe_2==1 || $flag_film_lldpe_perc_2==1 || $flag_film_hdpe_2== 1 || $flag_film_hdpe_perc_2==1 || $flag_micron_3==1 || $flag_film_admer_3==1 || $flag_film_admer_perc_3==1 || $flag_micron_4==1 || $flag_film_evoh_4==1 || $flag_film_evoh_perc_4==1 || $flag_micron_5==1 || $flag_film_admer_5 ==1|| $flag_film_admer_perc_5==1 || $flag_micron_6==1 || $flag_film_mb_6==1 || $flag_film_mb_perc_6==1 || $flag_film_lldpe_6==1 || $flag_film_lldpe_perc_6==1 || $flag_film_hdpe_6==1 || $flag_film_hdpe_perc_6==1 || $flag_micron_7==1 || $flag_film_ldpe_7==1 || $flag_film_ldpe_perc_7==1 || $flag_film_lldpe_7==1 || $flag_film_lldpe_perc_7==1){

      return false;

    }else{
      return true;

    }



  }//Fun Close

  function wip_issue_jobcard_quantity_check(){

    $actual_qty_issued=0;
    $calc_jobcard_qty=0;
    $order_qty=$this->input->post('release_to_order_qty');
    $job_card_quantity=$this->input->post('expected_qty');
    //echo'<br/>';
    //Jobcard Perc check----------------              
    $job_card_perc='';
    $springtube_jobcard_perc_master_result=$this->common_model->select_one_active_record('springtube_jobcard_perc_master',$this->session->userdata['logged_in']['company_id'],'jobcard_type','2');

    foreach ($springtube_jobcard_perc_master_result as $key => $springtube_jobcard_perc_master_row) {
      $job_card_perc=$springtube_jobcard_perc_master_row->perc;
    }

    $data=array('order_no'=>$this->input->post('release_to_order_no_1'),
              'article_no'=>$this->input->post('release_article_no'),
              'archive'=>'0',
              'return_flag'=>'0');

    // $production_master_result=$this->common_model->select_active_records_where('production_master',$this->session->userdata['logged_in']['company_id'],$data);
    // foreach ($production_master_result as $production_master_row) {
    //     $actual_qty_manufactured+=$this->common_model->read_number($production_master_row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']);
    // }

    $springtube_printing_wip_master_before_result=$this->common_model->select_active_records_where('springtube_printing_wip_master_before',$this->session->userdata['logged_in']['company_id'],$data);
    

    foreach ($springtube_printing_wip_master_before_result as $springtube_printing_wip_master_before_row) {
        $actual_qty_issued+=$springtube_printing_wip_master_before_row->bprint_wip_qty;
    }

    if($actual_qty_issued==0){
      $calc_jobcard_qty=$order_qty+(($order_qty*$job_card_perc)/100);

    }else{
      $calc_jobcard_qty= $order_qty+(($order_qty*$job_card_perc)/100)-$actual_qty_issued;

    }

    //echo $calc_jobcard_qty;

    if($calc_jobcard_qty<$job_card_quantity){
    $this->form_validation->set_message('wip_issue_jobcard_quantity_check', 'The {field} can not be more than specified %');
    return FALSE;

    }else{
      return TRUE;
    }

  }


  function outsource_for_printing_details(){
    
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){

              $table='springtube_outsource_for_printing';
              //include('pagination.php');
              
              $data['springtube_outsource_for_printing']=$this->springtube_extrusion_wip_model->select_active_records_papertube($table);
              //echo $this->db->last_query();
             
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/outsource_for_printing_active_records',$data);
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


  function received_after_printing(){
       
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->new==1){

              $table='springtube_outsource_for_printing';
              $sofp_id=$this->uri->segment(3);
              //echo $film_code;
              $data['springtube_outsource_for_printing']=$this->springtube_extrusion_wip_model->select_one_active_record_paper_tube($table,'sofp_id',$this->uri->segment(3));

            // $table='springtube_extrusion_wip_master';
            // $data['springtube_extrusion_wip_master']=$this->springtube_extrusion_wip_model->select_active_records($this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
              
              
             //echo $this->db->last_query();

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/received-after-printing-form',$data);
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


  function received_after_printing_save(){
       
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->new==1){
              
              $this->form_validation->set_rules('total_ok_meters','Total Release Meters' ,'required|trim|xss_clean|max_length[50]');              ;
              $this->form_validation->set_rules('total_ok_sqm','Total Release Square Meters' ,'required|trim|xss_clean|max_length[10]');
              $this->form_validation->set_rules('total_resived_sqm','Total Resived Square Meters' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('rate_per_sqm','Rate Per Sqm' ,'required|trim|xss_clean|max_length[256]');
              
             

             if($this->form_validation->run()==FALSE){

              $table='springtube_outsource_for_printing';
              $sofp_id=$this->uri->segment(3);
             // echo $film_code;
              $data['paper_tube_tally_stock_master']=$this->springtube_extrusion_wip_model->select_one_active_record_paper_tube($table,'sofp_id',$this->uri->segment(3));

            // $table='springtube_extrusion_wip_master';
            // $data['springtube_extrusion_wip_master']=$this->springtube_extrusion_wip_model->select_active_records($this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
              
              
             //echo $this->db->last_query();

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/received-after-printing-form',$data);
              $this->load->view('Home/footer');

              }else{
              $total_resived_meters=0;
              if($this->input->post('sleeve_diameter')=='35 MM'){
                $total_resived_meters=$this->input->post('total_resived_sqm')/0.244;
              }else if($this->input->post('sleeve_diameter')=='40 MM'){
                $total_resived_meters=$this->input->post('total_resived_sqm')/0.277;
              }else{
                $total_resived_meters=$this->input->post('total_resived_sqm')/0.335;
              }

              $table='springtube_outsource_for_printing';
              $sofp_id=$this->input->post('sofp_id');
              //echo $film_code;
              $data['springtube_outsource_for_printing']=$this->springtube_extrusion_wip_model->select_one_active_record_paper_tube($table,'sofp_id',$this->input->post('sofp_id'));


             
             $total_release_square_meters=$this->input->post('total_ok_sqm');
             $total_resived_square_meters=$this->input->post('total_resived_sqm');
             $rate_per_sqm=$this->input->post('rate_per_sqm');
             $total_amount=$total_resived_square_meters*$rate_per_sqm;
             $received_cost_per_meter=$total_amount/$total_resived_meters;


              $tube_resive_data=array(

                        'released_qty_in_sqm'=>$total_release_square_meters,
                        'received_date'=>date('Y-m-d'),                      
                        'received_qty_in_meter'=>$total_resived_meters,
                        'received_cost_per_meter'=>$received_cost_per_meter,
                        'received_qty_in_sqm'=>$total_resived_square_meters,
                        'received_qty_cost_per_sqm'=>$rate_per_sqm,
                        'total_amount'=>$total_amount,
                        'received_flag'=>'1'
                        );

              $result=$this->common_model->update_one_active_record('springtube_outsource_for_printing',$tube_resive_data,'sofp_id',$sofp_id,'000020');

              $data['note']='Transaction Completed';

             header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());


              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/received-after-printing-form',$data);
              $this->load->view('Home/footer');
              }       
               
              
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


  function outsource_inspection_create(){
    
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->new==1){


              $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);

               $table='springtube_outsource_for_printing';
              
              //echo $film_code;
              $data['springtube_outsource_for_printing']=$this->springtube_extrusion_wip_model->select_one_active_record_paper_tube($table,'sofp_id',$this->uri->segment(3));
              //echo $this->db->last_query();

             //echo $this->db->last_query();
              $dataa = array('process_id' =>'15');
              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

              $data_shift_issue=array('archive'=>0,'process_id'=>15);
              $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue); 

               $data['springtube_shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);


              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
             
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/outsource-printing-inspection-create-form',$data);
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

function outsource_inspection_save(){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

             $table='springtube_outsource_for_printing';
              
              //echo $film_code;
                           
            $this->form_validation->set_rules('production_date','Production Date' ,'required|trim|xss_clean');  
            $this->form_validation->set_rules('shift','Shift' ,'required|trim|xss_clean');           
            $this->form_validation->set_rules('machine','Machine Name' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('shift_issue','Shift Issues' ,'trim|xss_clean');
            $this->form_validation->set_rules('remarks','Remarks' ,'trim|xss_clean');
            $this->form_validation->set_rules('so_no','So No' ,'required');
            $this->form_validation->set_rules('total_printed_output','Total Printed Output (Qty)','trim|xss_clean|max_length[10]');              
            $this->form_validation->set_rules('inspected_output','Inspected Output(Qty)','trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('side_trim_waste','Side Trim Waste (Kg)' ,'required|trim|xss_clean|max_length[10]');
              
            if($this->form_validation->run()==FALSE){
               $data['springtube_outsource_for_printing']=$this->common_model->select_one_active_record('springtube_outsource_for_printing',$this->session->userdata['logged_in']['company_id'],'sofp_id',$this->input->post('sofp_id'));
              $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);
              $dataa = array('process_id' =>'15');
              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data_shift_issue=array('archive'=>0,'process_id'=>15);
              $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue);
              $data['springtube_shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/outsource-printing-inspection-create-form',$data);
              $this->load->view('Home/footer');
            }else{


                $customer='';
                $order_no='';
                $article_no='';
                $bom_no='';
                $bom_version_no='';
                $film_code='';
                $jobcard_no='';
                $shift_issues='';

                if(!empty($this->input->post('shift_issue'))){

                  $shift_issues=implode("," ,$this->input->post('shift_issue'));
                }

                $data=array(
                  'company_id'=>$this->session->userdata['logged_in']['company_id'],
                  'production_date'=>$this->input->post('production_date'),
                  'shift'=>$this->input->post('shift'),                                       
                  'process_id'=>'5',
                  'machine_id'=>$this->input->post('machine'),
                  'remarks'=>trim(strtoupper($this->input->post('remarks'))),
                  'shift_issues'=>$shift_issues,                                   
                  'user_id'=>$this->session->userdata['logged_in']['user_id'],
                  'created_date'=>date('Y-m-d H:i:s'),
                  'production_time'=>date('H:i:s')
                  );

                $production_id=$this->common_model->save_return_pkey('springtube_printing_inspection_master',$data); 

                if($production_id!=''){

                  //foreach($this->input->post('sr_no') as $sr_no => $sr_no_value){

                     

                    $production_master_result=$this->common_model->select_one_active_record('springtube_outsource_for_printing',$this->session->userdata['logged_in']['company_id'],'sofp_id',$this->input->post('sofp_id'));
              
                    foreach($production_master_result as $row) {
                      $so_no= $row->order_no;
                      $article_no=$row->article_no;
                      $customer=$row->customer;
                      $sleeve_diameter=$row->sleeve_dia;
                      $sleeve_length=$row->sleeve_length;
                      $total_microns=$row->total_microns;
                      $sleeve_mb_2=$row->second_layer_mb;
                      $sleeve_mb_6=$row->sixth_layer_mb;
                      $film_code=$row->film_code;
                    }

                   
                     
                    
                    $data=array(                      
                      'production_id'=>$production_id,
                      'customer'=>$customer,
                      'jobcard_no'=>'Outsource',
                      'order_no'=>$so_no,
                      'article_no'=>$article_no,
                      'sleeve_dia'=>$sleeve_diameter,
                      'sleeve_length'=>$sleeve_length,
                      'total_microns'=>$total_microns,
                      'job_pos_no'=>'1',                                          
                      'film_code'=>$film_code,
                      'second_layer_mb'=>$sleeve_mb_2,
                      'sixth_layer_mb'=>$sleeve_mb_6,
                      'inspection_input_qty'=>$this->input->post('total_printed_output'),                       
                      'inspected_output_qty'=>$this->input->post('inspected_output'),

                      'side_trim_waste'=>$this->input->post('side_trim_waste'),
                      'total_waste_qty'=>'',
                      'inspection_done'=>(!empty($this->input->post('inspection_done') ? 1:0)),
                      'date'=>date('Y-m-d')
                    );                

                    $details_id=$this->common_model->save_return_pkey('springtube_printing_inspection_details',$data);

                    if(!empty($this->input->post('inspection_done')) && $this->input->post('inspection_done')==1 ){

                      $data=array('inspection_flag'=>1);

                      $result=$this->common_model->update_one_active_record('springtube_outsource_for_printing',$data,'sofp_id',$this->input->post('sofp_id'),$this->session->userdata['logged_in']['company_id']);
                      
                      $data=array('inspection_done'=>1);

                      $result=$this->common_model->update_one_active_record('production_master',$data,'sales_ord_no',$so_no,$this->session->userdata['logged_in']['company_id']);

                      $data_search=array('order_no'=>$so_no);

                      $springtube_printing_inspection_details_result=$this->springtube_printing_inspection_model->select_total_inspection_qty('springtube_printing_inspection_master',$data_search);

                      $total_inspected_output_qty=0;

                      foreach ($springtube_printing_inspection_details_result as $springtube_printing_inspection_details_row) {

                        $total_inspected_output_qty=$springtube_printing_inspection_details_row->total_inspected_output_qty;
                        
                      }

                      $data=array(
                      'aprint_wip_date'=>date('Y-m-d'),                      
                      'details_id'=>$details_id,
                      'jobcard_no'=>'Outsource',
                      'customer'=>$customer,
                      'order_no'=>$so_no,
                      'article_no'=>$article_no,
                      'sleeve_dia'=>$sleeve_diameter,
                      'sleeve_length'=>$sleeve_length,
                      'total_microns'=>$total_microns,
                      'second_layer_mb'=>$sleeve_mb_2,
                      'sixth_layer_mb'=>$sleeve_mb_6,                           
                      'film_code'=>$film_code,
                      'aprint_wip_qty'=>$total_inspected_output_qty, 
                      'created_date'=>date('Y-m-d H:i:s'),
                      'company_id'=>$this->session->userdata['logged_in']['company_id'],
                      'from_process'=>'15',
                      'user_id'=>$this->session->userdata['logged_in']['user_id']
                      );                

                      $result=$this->common_model->save('springtube_printing_wip_master_after',$data);

                      if($result){
                        $data['note']='WIP After print saved succesfully';
                        //header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                      }else{
                           $data['note']='Error while saving WIP Data';
                      }

                    }                       
                 
                   
                //}//Foreach  

              }else{

                $data['note']='Error while saving master data';

              }               
                
                $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

                $data['note']='Create Transaction Completed';

                header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);
              
                $dataa = array('process_id' =>'15');
                $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

                $data_shift_issue=array('archive'=>0,'process_id'=>15);
                $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue); 
                
                $data['springtube_shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);

                $data['springtube_outsource_for_printing']=$this->common_model->select_one_active_record('springtube_outsource_for_printing',$this->session->userdata['logged_in']['company_id'],'sofp_id',$this->input->post('sofp_id'));
              

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/outsource-printing-inspection-create-form',$data);
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
  

}

