<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Springtube_bodymaking_wip extends CI_Controller {

  function __construct(){    
    parent::__construct();
    if($this->session->userdata('logged_in')){
      
      $this->load->model('common_model');
      $this->load->model('article_model');
        $this->load->model('customer_model');
      $this->load->model('sales_order_book_model');
      $this->load->model('sales_order_status_model');
      $this->load->model('artwork_springtube_model');
      $this->load->model('springtube_bodymaking_wip_model');
      $this->load->model('springtube_bodymaking_production_model');
      $this->load->model('fiscal_model');
      
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

              $table='springtube_bodymaking_wip_master';
              //include('pagination_wip.php');
             // $data['springtube_bodymaking_wip_master']=$this->springtube_bodymaking_wip_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);


            //$this->load->model('complaint_register_model');


            $data_search=array('status'=>0);
            $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

            if($data['account_periods_master']==FALSE){
              $from_date="";
            }else{
              foreach($data['account_periods_master'] as $account_periods_master_row){
                $from_date=$account_periods_master_row->fin_year_start;
              }
            }
              $data['springtube_bodymaking_wip_master']=$this->springtube_bodymaking_wip_model->active_record_search('springtube_bodymaking_wip_master',$this->session->userdata['logged_in']['company_id'],$data_search,$from_date,date('Y-m-d')); 
             
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

              $table='springtube_bodymaking_wip_master';
              include('pagination_archive.php');
              $data['springtube_bodymaking_wip_master']=$this->springtube_bodymaking_wip_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
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
              
              //$data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);

              //$data_search=array('status'=>0);
              //$data['springtube_bodymaking_wip_master']=$this->springtube_bodymaking_wip_model->active_record_search('springtube_bodymaking_wip_master',$this->session->userdata['logged_in']['company_id'],$data_search,$this->input->post('from_date'),$this->input->post('to_date')); 
             //echo $this->db->last_query(); 

            $data_search=array('status'=>0);
            $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

            if($data['account_periods_master']==FALSE){
              $from_date="";
            }else{
              foreach($data['account_periods_master'] as $account_periods_master_row){
                $from_date=$account_periods_master_row->fin_year_start;
              }
            }
              $data['springtube_bodymaking_wip_master']=$this->springtube_bodymaking_wip_model->active_record_search('springtube_bodymaking_wip_master',$this->session->userdata['logged_in']['company_id'],$data_search,$from_date,date('Y-m-d')); 
             
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
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
            $this->form_validation->set_rules('customer','Customer' ,'trim|xss_clean|callback_customer_check');
            $this->form_validation->set_rules('status','Status' ,'trim|xss_clean');
                       
            if($this->form_validation->run()==FALSE){

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);

              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

            $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

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
                $customer_arr=explode("//",$this->input->post('customer'));
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

              if($this->input->post('status')!=''){
                $data_search['status']=$this->input->post('status');
              }
             

              //$data_search=array('status'=>0);
              $data['springtube_bodymaking_wip_master']=$this->springtube_bodymaking_wip_model->active_record_search('springtube_bodymaking_wip_master',$this->session->userdata['logged_in']['company_id'],$data_search,$this->input->post('from_date'),$this->input->post('to_date')); 
             //echo $this->db->last_query();            

              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);                
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());


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

  function article_check($str){
    
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
  
 function wip_release($bm_wip_id){
       
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->new==1){

              $table='springtube_bodymaking_wip_master';
              $data['springtube_bodymaking_wip_master']=$this->springtube_bodymaking_wip_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'bm_wip_id',$bm_wip_id);

              
              
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
                $this->form_validation->set_rules('release_date','Release Date','required');
                $this->form_validation->set_rules('jobcard_no','Jobcard No','required');            
                $this->form_validation->set_rules('order_no','Order No','required');
                $this->form_validation->set_rules('article_no','Article No','required');
                $this->form_validation->set_rules('shortfall_qty','Input Qty','required');
                $this->form_validation->set_rules('scrap_qty','Release Qty','required|less_than[shortfall_qty]');
                $this->form_validation->set_rules('to_process','Release Towards','required');
                if($this->form_validation->run()==FALSE){
 
                $bm_wip_id=$this->input->post('bm_wip_id');               

                $table='springtube_bodymaking_wip_master';
                $data['springtube_bodymaking_wip_master']=$this->springtube_bodymaking_wip_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'bm_wip_id',$bm_wip_id);
               
                
                //echo $this->db->last_query();

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/wip-release-form',$data);
                $this->load->view('Home/footer');
                }else{

                $update_scrap=array('scrap_qty'=>$this->input->post('scrap_qty'));

                $this->load->model('Springtube_bodymaking_wip_model');
                $data['scrap_result']=$this->Springtube_bodymaking_wip_model->update_scrap($update_scrap,$this->input->post('bm_wip_id'));

                $table='springtube_bodymaking_scrap_master';
                $this->session->set_flashdata('success', 'Scrap update successfully');


                $table='springtube_bodymaking_wip_master';
                include('pagination_wip.php');
                $data['springtube_bodymaking_wip_master']=$this->springtube_bodymaking_wip_model->select_active_input_release_records($table,$this->input->post('bm_wip_id'));

                  //$this->db->last_query();

                 foreach($data['springtube_bodymaking_wip_master'] as $input){
                
                 $var_input=$input->bm_wip_qty;
                 $var_scrap=$input->scrap_qty;
                 $var_wip_qty=$var_input - $var_scrap;

                 $update_wip_qty['bm_wip_qty'] = $var_wip_qty;

                 $this->load->model('Springtube_bodymaking_wip_model');
                 $data['scrap_result']=$this->Springtube_bodymaking_wip_model->update_scrap($update_wip_qty,$this->input->post('bm_wip_id'));
                 $data['note']='Create Transaction Completed';
                 header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());


                $table='springtube_bodymaking_wip_master';
                $data['springtube_bodymaking_wip_master']=$this->springtube_bodymaking_wip_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'bm_wip_id',$this->input->post('bm_wip_id'));
               
                
                //echo $this->db->last_query();

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/wip-release-form',$data);
                $this->load->view('Home/footer');
              }
            }
          }else{
        }
      }
    }
  }
}
}



function scrap_search(){

     $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']); 


    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){

              $table='springtube_bodymaking_wip_master';
              include('pagination_wip.php');
              $data['springtube_bodymaking_wip_master']=$this->springtube_bodymaking_wip_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
             
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form-scrap',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/active-record',$data);
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



  function search_result_scrap(){

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
            $this->form_validation->set_rules('customer','Customer' ,'trim|xss_clean|callback_customer_check');
            $this->form_validation->set_rules('status','Status' ,'trim|xss_clean');
                       
            if($this->form_validation->run()==FALSE){

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);

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
                $customer_arr=explode("//",$this->input->post('customer'));
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

              if($this->input->post('status')!=''){
                $data_search['status']=$this->input->post('status');
              }
             

              //$data_search=array('status'=>0);
              $data['springtube_bodymaking_wip_master']=$this->springtube_bodymaking_wip_model->active_record_search('springtube_bodymaking_wip_master',$this->session->userdata['logged_in']['company_id'],$data_search,$this->input->post('from_date'),$this->input->post('to_date')); 
             //echo $this->db->last_query();            

              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);                
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
               

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form-scrap',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/active-record',$data);
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

