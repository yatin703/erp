<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coex_printing extends CI_Controller {

  function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('coex_printing_model');
      $this->load->model('coex_runtime_downtime_model');
      $this->load->model('costsheet_model');
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

             $table='coex_printing';
             include('pagination.php');
             $data['coex_printing']=$this->coex_printing_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
              $this->load->view('Home/footer');
            }else{
              $data['note']='No View rights Thanks';
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

   function create(){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){
            $dataa = array('process_id' =>'3','user_id'=>$this->session->userdata['logged_in']['user_id']);
            $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
            //echo $this->db->last_query();
            $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
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


  function runtime_search(){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $dataa = array('process_id' =>'3');
            $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
            $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
            $dataa = array('process_id' =>'3','start_stop_flag'=>'0');
            $data['coex_extrusion_machine_stop_reasons']=$this->common_model->select_active_records_where('coex_machine_start_stop_reasons',$this->session->userdata['logged_in']['company_id'],$dataa);
            //echo $this->db->last_query();
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/search-form-runtime',$data);
            $this->load->view('Home/footer');
          }else{
            $data['note']='No View Rights Thanks';
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
      $data['note']='No View Rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  }

  function downtime_search(){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $dataa = array('process_id' =>'3');
            $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
            $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
            $dataa = array('process_id'=>'3','start_stop_flag'=>'0');
            $data['coex_extrusion_machine_stop_reasons']=$this->common_model->select_active_records_where('coex_machine_start_stop_reasons',$this->session->userdata['logged_in']['company_id'],$dataa);
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/search-form-downtime',$data);
            $this->load->view('Home/footer');
          }else{
            $data['note']='No View Rights Thanks';
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
      $data['note']='No View Rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  }

  function printing_time_summary(){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $dataa = array('process_id' =>'3');
            $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
            $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
            $dataa = array('process_id'=>'3','start_stop_flag'=>'0');
            $data['coex_extrusion_machine_stop_reasons']=$this->common_model->select_active_records_where('coex_machine_start_stop_reasons',$this->session->userdata['logged_in']['company_id'],$dataa);
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/search-form-printing-time',$data);
            $this->load->view('Home/footer');
          }else{
            $data['note']='No View Rights Thanks';
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
      $data['note']='No View Rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  }

  function printing_time_summary_result(){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

            $this->form_validation->set_rules('from_date','From Date' ,'trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('to_date','To Date' ,'trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('customer_category','Customer' ,'trim|xss_clean');
            $this->form_validation->set_rules('order_no','Order no' ,'trim|xss_clean');
            $this->form_validation->set_rules('article_no','Product' ,'trim|xss_clean');
            $this->form_validation->set_rules('machine','Machine' ,'trim|xss_clean');
            
            if($this->form_validation->run()==FALSE){

              $dataa = array('process_id' =>'3');
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
              $dataa = array('process_id'=>'3','start_stop_flag'=>'0');
              $data['coex_extrusion_machine_stop_reasons']=$this->common_model->select_active_records_where('coex_machine_start_stop_reasons',$this->session->userdata['logged_in']['company_id'],$dataa);
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form-printing-time',$data);
              $this->load->view('Home/footer');
            } 
            else{

              $from='';
              $to='';
              $data=array();
              if(!empty($this->input->post('from_date'))){
                $from=$this->input->post('from_date');
              }
              if(!empty($this->input->post('to_date'))){
                $to=$this->input->post('to_date');
              }
              if(!empty($this->input->post('machine'))){
                $data['coex_machine_master.machine_id']=$this->input->post('machine');
              }
              if(!empty($this->input->post('order_no'))){
                $data['production_master.sales_ord_no']=$this->input->post('order_no');
                $from='';
                $to='';

              }
              if(!empty($this->input->post('article_no'))){
                $arr=explode("//", $this->input->post('article_no'));
                if(count($arr)>=2){
                   $data['production_master.article_no']=$arr[1];
                }
                
              }
              $customer_category='';
              if(!empty($this->input->post('customer_category'))){
                $arr=explode("//", $this->input->post('customer_category'));
                if(count($arr)>=2){
                   $customer_category=$arr[1];
                }
                
              }

              $data['coex_machine_runtime_jobcards']=$this->coex_runtime_downtime_model->active_record_search_group_by('coex_machine_runtime',$data,$from,$to,$this->session->userdata['logged_in']['company_id'],$customer_category);

              //print_r($data['coex_machine_runtime']);

              $data['page_name']='Prodution';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());              

              $dataa = array('process_id' =>'3');
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
              $dataa = array('process_id'=>'3','start_stop_flag'=>'0');
              $data['coex_extrusion_machine_stop_reasons']=$this->common_model->select_active_records_where('coex_machine_start_stop_reasons',$this->session->userdata['logged_in']['company_id'],$dataa);
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form-printing-time',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-result-printing-time',$data);
              $this->load->view('Home/footer');

            }

          }else{
            $data['note']='No View Rights Thanks';
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
      $data['note']='No View Rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  }



  function summary(){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $dataa = array('process_id' =>'3');
            $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
            $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
            $dataa = array('process_id' =>'3','start_stop_flag'=>'0');
            $data['coex_extrusion_machine_stop_reasons']=$this->common_model->select_active_records_where('coex_machine_start_stop_reasons',$this->session->userdata['logged_in']['company_id'],$dataa);
            //echo $this->db->last_query();
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/search-form-summary',$data);
            $this->load->view('Home/footer');
          }else{
            $data['note']='No View Rights Thanks';
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
      $data['note']='No View Rights Thanks';
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
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){
            $dataa = array('process_id' =>'3');
            $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
            $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
            $this->load->view('Home/footer');
          }else{
            $data['note']='No View Rights Thanks';
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
      $data['note']='No View Rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  }


  function runtime(){
    
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){
            $this->load->model('job_card_model');
            $table='coex_machine_runtime';
            include('pagination.php');
            $dataa = array('process_id' =>'3');

            $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
            $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
            $dataa = array('process_id' =>'3','start_stop_flag'=>'0');
            $data['coex_extrusion_machine_stop_reasons']=$this->common_model->select_active_records_where('coex_machine_start_stop_reasons',$this->session->userdata['logged_in']['company_id'],$dataa);

             $data['coex_machine_runtime']=$this->coex_printing_model->select_runtime_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/active-records-runtime',$data);
              $this->load->view('Home/footer');
            }else{
              $data['note']='No View rights Thanks';
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

  function downtime(){
    
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){
             $table='coex_machine_downtime';
             include('pagination.php');
             $data['coex_machine_downtime']=$this->coex_printing_model->select_downtime_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/active-records-downtime',$data);
              $this->load->view('Home/footer');
            }else{
              $data['note']='No View rights Thanks';
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



  function summary_search_result(){

  $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $this->form_validation->set_rules('from_date','From Date' ,'trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('to_date','To Date' ,'trim|xss_clean|max_length[10]');
            
            if($this->form_validation->run()==FALSE){
              $dataa = array('process_id' =>'3');
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $dataa = array('process_id' =>'3','start_stop_flag'=>'0');
              //echo $this->db->last_query();
              $data['page_name']='production';
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form-summary',$data);
              $this->load->view('Home/footer');
            }else{
              $data=array('coex_machine_downtime.machine_id'=>$this->input->post('machine'),'coex_machine_downtime.process_id'=>'3');
              $from=$this->common_model->change_date_format($this->input->post('from_date'),$this->session->userdata['logged_in']['company_id']);
              $to=$this->common_model->change_date_format($this->input->post('to_date'),$this->session->userdata['logged_in']['company_id']);
              $this->load->model('coex_runtime_downtime_model');
              $data = array_filter($data);
                if(!empty($from)){
                  $data['coex_machine_downtime']=$this->coex_runtime_downtime_model->coex_downtime_summary($from,$to,$this->session->userdata['logged_in']['company_id']);

                  $data['coex_machine_downtime_total']=$this->coex_runtime_downtime_model->coex_downtime_summary_total($from,$to,$this->session->userdata['logged_in']['company_id']);
                }else{
                 // $data['coex_machine_downtime']=$this->coex_runtime_downtime_model->coex_downtime_summary($from="",$to=$this->session->userdata['logged_in']['company_id']);
                }
                //echo $this->db->last_query();
                $data['page_name']='Prodution';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/search-form-summary',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/search-result-summary',$data);
                $this->load->view('Home/footer');
              }

          }else{
            $data['note']='No View rights Thanks';
            $data['page_name']='production';
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
      $data['note']='No view rights Thanks';
      $data['page_name']='production';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
    
  }

  function downtime_search_result(){

  $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $this->form_validation->set_rules('from_date','From Date' ,'trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('to_date','To Date' ,'trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('machine','Machine' ,'trim|xss_clean');
            if($this->form_validation->run()==FALSE){
              $dataa = array('process_id' =>'3');
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
              $dataa = array('process_id' =>'3','start_stop_flag'=>'0');
              $data['coex_extrusion_machine_stop_reasons']=$this->common_model->select_active_records_where('coex_machine_start_stop_reasons',$this->session->userdata['logged_in']['company_id'],$dataa);
              //echo $this->db->last_query();
              $data['page_name']='production';
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form-downtime',$data);
              $this->load->view('Home/footer');
            }else{
              $data=array('coex_machine_downtime.machine_id'=>$this->input->post('machine'),'coex_machine_downtime.process_id'=>'3');
              $from=$this->common_model->change_date_format($this->input->post('from_date'),$this->session->userdata['logged_in']['company_id']);
              $to=$this->common_model->change_date_format($this->input->post('to_date'),$this->session->userdata['logged_in']['company_id']);
              $this->load->model('coex_runtime_downtime_model');
              $data = array_filter($data);
                if(!empty($from)){
                  $data['coex_machine_downtime']=$this->coex_runtime_downtime_model->active_record_search_by_date_downtime('coex_machine_downtime',$data,$from,$to,$this->session->userdata['logged_in']['company_id']);
                }else{
                  $data['coex_machine_downtime']=$this->coex_runtime_downtime_model->active_record_search('coex_machine_downtime',$data,$this->session->userdata['logged_in']['company_id']);
                }
                //echo $this->db->last_query();
                $data['page_name']='Prodution';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/active-records-downtime',$data);
                $this->load->view('Home/footer');
              }

          }else{
            $data['note']='No View rights Thanks';
            $data['page_name']='production';
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
      $data['note']='No view rights Thanks';
      $data['page_name']='production';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
    
  }



function runtime_search_result(){

  $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $this->load->model('job_card_model');
            $this->form_validation->set_rules('from_date','From Date' ,'trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('to_date','To Date' ,'trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('machine','Machine' ,'trim|xss_clean');
            
            if($this->form_validation->run()==FALSE){
              $dataa = array('process_id' =>'3');
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
              $dataa = array('process_id' =>'3','start_stop_flag'=>'0');
              $data['coex_extrusion_machine_stop_reasons']=$this->common_model->select_active_records_where('coex_machine_start_stop_reasons',$this->session->userdata['logged_in']['company_id'],$dataa);
              //echo $this->db->last_query();
              $data['page_name']='production';
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form-runtime',$data);
              $this->load->view('Home/footer');
            }else{
              $data=array('coex_machine_runtime.machine_id'=>$this->input->post('machine'),
                'coex_machine_runtime.process_id'=>'3','mp_pos_no'=>$this->input->post('mp_pos_no'));
              $from=$this->common_model->change_date_format($this->input->post('from_date'),$this->session->userdata['logged_in']['company_id']);
              $to=$this->common_model->change_date_format($this->input->post('to_date'),$this->session->userdata['logged_in']['company_id']);
              $this->load->model('coex_runtime_downtime_model');
              $data = array_filter($data);
                if(!empty($from)){
                  $data['coex_machine_runtime']=$this->coex_runtime_downtime_model->active_record_search_by_date('coex_machine_runtime',$data,$from,$to,$this->session->userdata['logged_in']['company_id']);
                }else{
                  $data['coex_machine_runtime']=$this->coex_runtime_downtime_model->active_record_search('coex_machine_runtime',$data,$this->session->userdata['logged_in']['company_id']);
                }
                //echo $this->db->last_query();
                $data['page_name']='Prodution';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/active-records-runtime',$data);
                $this->load->view('Home/footer');

            }

          }else{
            $data['note']='No View rights Thanks';
            $data['page_name']='production';
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
      $data['note']='No view rights Thanks';
      $data['page_name']='production';
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
            $this->form_validation->set_rules('from_date','From Date' ,'required|trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('to_date','To Date' ,'required|trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('machine','Machine' ,'trim|xss_clean');
            if($this->form_validation->run()==FALSE){
              $dataa = array('process_id' =>'1');
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
              //echo $this->db->last_query();
              $data['page_name']='production';
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
              $this->load->view('Home/footer');
            }else{
              $data=array('coex_extrusion.machine_id'=>$this->input->post('machine'));
              $from=$this->common_model->change_date_format($this->input->post('from_date'),$this->session->userdata['logged_in']['company_id']);
              $to=$this->common_model->change_date_format($this->input->post('to_date'),$this->session->userdata['logged_in']['company_id']);
              
              $data = array_filter($data);
                if(!empty($from)){
                  $data['coex_extrusion']=$this->coex_printing_model->active_record_search('coex_extrusion',$data,$from,$to,$this->session->userdata['logged_in']['company_id']);
                }else{
                  $data['coex_extrusion']=$this->coex_printing_model->active_record_search('coex_extrusion',$data,$from="",$to="",$this->session->userdata['logged_in']['company_id']);
                }
                $data['page_name']='Prodution';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/search-result',$data);
                $this->load->view('Home/footer');

            }

          }else{
            $data['note']='No View rights Thanks';
            $data['page_name']='production';
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
      $data['note']='No view rights Thanks';
      $data['page_name']='production';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
    
  }

function save(){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $this->form_validation->set_rules('extrusion_date','Date' ,'required|trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('shift','Shift' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('machine','Machine' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('operator','Operator' ,'required|trim|xss_clean');

            for($i=1;$i<=count($this->input->post('sr_no'));$i++){

              $this->common_model->save_number($this->input->post('unit_rate_'.$i.''),$this->session->userdata['logged_in']['company_id']);

              $this->form_validation->set_rules('job_card_no_'.$i.'','JOBCARD NO '.$i.'' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('rm_mixing_'.$i.'','RM Mixing Quantity '.$i.'' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('ok_qty_'.$i.'','OK Quantity '.$i.'' ,'required|trim|xss_clean|max_length[20]|is_natural');
              $this->form_validation->set_rules('scrap_weight_'.$i.'','Scrap Weight '.$i.'' ,'required|trim|xss_clean|numeric');
              $this->form_validation->set_rules('cutting_speed_'.$i.'','Cutting Speed '.$i.'' ,'required|trim|xss_clean|is_natural_no_zero');

            }

            if($this->form_validation->run()==FALSE){
              $dataa = array('process_id' =>'1');
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
              $dataa = array('process_id' =>'1','start_stop_flag'=>'0');
              $data['coex_extrusion_machine_stop_reasons']=$this->common_model->select_active_records_where('coex_machine_start_stop_reasons',$this->session->userdata['logged_in']['company_id'],$dataa);

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
              $this->load->view('Home/footer');
            }else{

              

              for($i=1;$i<=count($this->input->post('sr_no[]'));$i++){ 

                if($this->input->post('job_card_no_'.$i.'')!='WAS-SLUM-000-0001'){

                 $result_jobcard=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$this->input->post('job_card_no_'.$i.''));
                if($result_jobcard==FALSE){
                  $order_no="";
                  $product_no="";
                }else{
                  foreach($result_jobcard as $row){
                    $order_no=$row->sales_ord_no;
                    $product_no=$row->article_no;
                  }
                }

                $order_data=array('order_no'=>$order_no,'article_no'=>$product_no);
                $result_bom=$this->common_model->select_one_active_record_nonlanguage_without_archives('order_details',$this->session->userdata['logged_in']['company_id'],$order_data);
                if($result_bom==FALSE){
                  $spec_id="";
                  $spec_version_no="";
                }else{
                  foreach($result_bom as $result_bom_row){
                    $spec_id=$result_bom_row->spec_id;
                    $spec_version_no=$result_bom_row->spec_version_no;
                  }
                }

                $data_bom=array('bom_no'=>$spec_id,
                'bom_version_no'=>$spec_version_no);
                $data['bom_details']=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data_bom);
                if($data['bom_details']==FALSE){
                   $sleeve_code="";
                }else{
                  foreach($data['bom_details'] as $bom_details_row){
                    $sleeve_code=$bom_details_row->sleeve_code;
                      if(substr($sleeve_code,0,3)=="SLV"){
                        $data['sleeve_specs']=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$sleeve_code);
                        foreach($data['sleeve_specs'] as $sleeve_specs){

                          $sleeve_specss['spec_id']=$sleeve_specs->spec_id;
                          $sleeve_specss['spec_version_no']=$sleeve_specs->spec_version_no;

                          $sleeve_specs_master_result=$this->common_model->select_active_records_where('specification_sheet',$this->session->userdata['logged_in']['company_id'],$sleeve_specss);
                            if($sleeve_specs_master_result){
                                foreach($sleeve_specs_master_result as $sleeve_specs_master_result_row){
                                  $layer_arr=explode("|", $sleeve_specs_master_result_row->dyn_qty_present);
                                  $layer_no=substr($layer_arr[1],0,1);
                                }
                            }
                          $this->load->model('sales_order_book_model');
                          $this->load->model('specification_model');
                          $sleeve_specs_result=$this->sales_order_book_model->select_sleeve_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$sleeve_specss);
                          if($sleeve_specs_result){
                            foreach($sleeve_specs_result as $specs_row){
                              $dia=$specs_row->SLEEVE_DIA;
                              $length=$specs_row->SLEEVE_LENGTH+3;
                              $sleeve_length=$specs_row->SLEEVE_LENGTH;
                            }
                          }else{
                            $dia="";
                            $sleeve_length="";
                          }

                          $pi=3.14;
                          $total_sleeve_weight="";
                          for($j=1;$j<=$layer_no;$j++){
                            $gauge="";
                            $data['specification_sleeve_details']=$this->specification_model->select_details_record_for_jobcard_where_gauge('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$sleeve_specs->spec_id,'specification_sheet_details.spec_version_no',$sleeve_specs->spec_version_no,'item_group_id','3','layer_no',$i,'parameter_name','GUAGE','srd_id','asc','layer_no','asc');
                            foreach($data['specification_sleeve_details'] as $specification_sleeve_details_row){
                              $gauge=rtrim($specification_sleeve_details_row->parameter_value," MIC");
                              $density="";
                              $sleeve_weight="";
                              if($layer_no==5 && $i==3){
                                $density=1.18;
                              }else{
                                $density=0.92;
                              }
                              $sleeve_weight=($dia*$length*$gauge*$pi*$density)/1000000;
                        
                              $sleeve_weight=$sleeve_weight/1000;

                              $total_sleeve_weight+=$sleeve_weight;

                            }
                          }
                        }
                      }
                    }
                  }
                  $total_sleeve_weight=floor($total_sleeve_weight*10000)/10000;
                
                $rejection=(100-($this->input->post('ok_qty_'.$i.'')/($this->input->post('rm_mixing_'.$i.'')/$total_sleeve_weight))*100);
                $dat=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'extrusion_date'=>$this->input->post('extrusion_date'),
                'machine_id'=>$this->input->post('machine'),
                'shift_id'=>$this->input->post('shift'),
                'user_id'=>$this->session->userdata['logged_in']['user_id'],
                'operator'=>$this->input->post('operator'),
                'jobcard_no'=>$this->input->post('job_card_no_'.$i.''),
                'order_no'=>$order_no,
                'article_no'=>$product_no,
                'diameter'=>$dia,
                'length'=>$sleeve_length,
                'sleeve_weight_kg'=>$total_sleeve_weight,
                'rm_mixed_qty_kg'=>$this->input->post('rm_mixing_'.$i.''),
                'ok_qty_no'=>$this->input->post('ok_qty_'.$i.''),
                'scrap_weight_kg'=>$this->input->post('scrap_weight_'.$i.''),
                'scrap_tube_no'=>round($this->input->post('scrap_weight_'.$i.'')/$total_sleeve_weight),
                'cutting_speed_minutes'=>$this->input->post('cutting_speed_'.$i.''),
                'job_runtime_minutes'=>round(($this->input->post('ok_qty_'.$i.'')+($this->input->post('scrap_weight_'.$i.'')/$total_sleeve_weight))/$this->input->post('cutting_speed_'.$i.'')),
                'rejection_percentage'=>$rejection
              );

              }else{
                $dat=array(
                  'company_id'=>$this->session->userdata['logged_in']['company_id'],
                  'extrusion_date'=>$this->input->post('extrusion_date'),
                  'machine_id'=>$this->input->post('machine'),
                  'shift_id'=>$this->input->post('shift'),
                  'user_id'=>$this->session->userdata['logged_in']['user_id'],
                  'operator'=>$this->input->post('operator'),
                  'order_no'=>'PURGING',
                  'article_no'=>$this->input->post('job_card_no_'.$i.''),
                  'jobcard_no'=>$this->input->post('job_card_no_'.$i.''),
                  'rm_mixed_qty_kg'=>$this->input->post('rm_mixing_'.$i.''),
                  'ok_qty_no'=>$this->input->post('ok_qty_'.$i.''),
                  'scrap_weight_kg'=>$this->input->post('scrap_weight_'.$i.''),
                  'cutting_speed_minutes'=>$this->input->post('cutting_speed_'.$i.''),
                  'rejection_percentage'=>'100'
                );
              }
              $result=$this->common_model->save('coex_extrusion',$dat);
            }

              $dataa = array('process_id' =>'1');
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
              $dataa = array('process_id' =>'1','start_stop_flag'=>'0');
              $data['coex_extrusion_machine_stop_reasons']=$this->common_model->select_active_records_where('coex_machine_start_stop_reasons',$this->session->userdata['logged_in']['company_id'],$dataa);

              $data['page_name']='Prodution';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $data['note']='Create Transaction Completed';
              header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
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
      $data['note']='No Creat rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
}



  function update(){
      $data['page_name']='Production';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,'coex_extrusion');

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){

              $this->form_validation->set_rules('extrusion_date','Date' ,'required|trim|xss_clean|max_length[10]');
              $this->form_validation->set_rules('shift','Shift' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('machine','Machine' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('operator','Operator' ,'required|trim|xss_clean');

              for($i=1;$i<=count($this->input->post('sr_no'));$i++){

                $this->form_validation->set_rules('job_card_no_'.$i.'','JOBCARD NO '.$i.'' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('rm_mixing_'.$i.'','RM Mixing Quantity '.$i.'' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('ok_qty_'.$i.'','OK Quantity '.$i.'' ,'required|trim|xss_clean|max_length[20]|is_natural');
                $this->form_validation->set_rules('scrap_weight_'.$i.'','Scrap Weight '.$i.'' ,'required|trim|xss_clean|numeric');
                $this->form_validation->set_rules('cutting_speed_'.$i.'','Cutting Speed '.$i.'' ,'required|trim|xss_clean|is_natural_no_zero');

              }

            if($this->form_validation->run()==FALSE){
                $dataa = array('process_id' =>'1');
                $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
                $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
                $data['coex_extrusion']=$this->coex_printing_model->select_one_active_record('coex_extrusion',$this->session->userdata['logged_in']['company_id'],'coex_extrusion.ce_id',$this->input->post('ce_id'));

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
                $this->load->view('Home/footer');

              }else{

                for($i=1;$i<=count($this->input->post('sr_no[]'));$i++){ 
                  if($this->input->post('job_card_no_'.$i.'')!='WAS-SLUM-000-0001'){

                    $result_jobcard=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$this->input->post('job_card_no_'.$i.''));
                      if($result_jobcard==FALSE){
                        $order_no="";
                        $product_no="";
                      }else{
                        foreach($result_jobcard as $row){
                          $order_no=$row->sales_ord_no;
                          $product_no=$row->article_no;
                        }
                      }

                    $order_data=array('order_no'=>$order_no,'article_no'=>$product_no);
                    $result_bom=$this->common_model->select_one_active_record_nonlanguage_without_archives('order_details',$this->session->userdata['logged_in']['company_id'],$order_data);
                    if($result_bom==FALSE){
                      $spec_id="";
                      $spec_version_no="";
                    }else{
                      foreach($result_bom as $result_bom_row){
                        $spec_id=$result_bom_row->spec_id;
                        $spec_version_no=$result_bom_row->spec_version_no;
                      }
                    }

                    $data_bom=array('bom_no'=>$spec_id,
                    'bom_version_no'=>$spec_version_no);
                    $data['bom_details']=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data_bom);
                    if($data['bom_details']==FALSE){
                       $sleeve_code="";
                    }else{
                      foreach($data['bom_details'] as $bom_details_row){
                        $sleeve_code=$bom_details_row->sleeve_code;
                          if(substr($sleeve_code,0,3)=="SLV"){
                            $data['sleeve_specs']=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$sleeve_code);
                            foreach($data['sleeve_specs'] as $sleeve_specs){

                              $sleeve_specss['spec_id']=$sleeve_specs->spec_id;
                              $sleeve_specss['spec_version_no']=$sleeve_specs->spec_version_no;

                              $sleeve_specs_master_result=$this->common_model->select_active_records_where('specification_sheet',$this->session->userdata['logged_in']['company_id'],$sleeve_specss);
                                if($sleeve_specs_master_result){
                                    foreach($sleeve_specs_master_result as $sleeve_specs_master_result_row){
                                      $layer_arr=explode("|", $sleeve_specs_master_result_row->dyn_qty_present);
                                      $layer_no=substr($layer_arr[1],0,1);
                                    }
                                }
                              $this->load->model('sales_order_book_model');
                              $this->load->model('specification_model');
                              $sleeve_specs_result=$this->sales_order_book_model->select_sleeve_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$sleeve_specss);
                              if($sleeve_specs_result){
                                foreach($sleeve_specs_result as $specs_row){
                                  $dia=$specs_row->SLEEVE_DIA;
                                  $length=$specs_row->SLEEVE_LENGTH+3;
                                  $sleeve_length=$specs_row->SLEEVE_LENGTH;
                                }
                              }else{
                                $dia="";
                                $sleeve_length="";
                              }

                              $pi=3.14;
                              $total_sleeve_weight="";
                              for($j=1;$j<=$layer_no;$j++){
                                $gauge="";
                                $data['specification_sleeve_details']=$this->specification_model->select_details_record_for_jobcard_where_gauge('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$sleeve_specs->spec_id,'specification_sheet_details.spec_version_no',$sleeve_specs->spec_version_no,'item_group_id','3','layer_no',$i,'parameter_name','GUAGE','srd_id','asc','layer_no','asc');
                                foreach($data['specification_sleeve_details'] as $specification_sleeve_details_row){
                                  $gauge=rtrim($specification_sleeve_details_row->parameter_value," MIC");
                                  $density="";
                                  $sleeve_weight="";
                                  if($layer_no==5 && $i==3){
                                    $density=1.18;
                                  }else{
                                    $density=0.92;
                                  }
                                  $sleeve_weight=($dia*$length*$gauge*$pi*$density)/1000000;
                            
                                  $sleeve_weight=$sleeve_weight/1000;

                                  $total_sleeve_weight+=$sleeve_weight;
                                 
                                }
                              }
                            }
                          }
                        }
                      }
                      $total_sleeve_weight=floor($total_sleeve_weight*10000)/10000;
                      $rejection=(100-($this->input->post('ok_qty_'.$i.'')/($this->input->post('rm_mixing_'.$i.'')/$total_sleeve_weight))*100);
                      $dat=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                      'extrusion_date'=>$this->input->post('extrusion_date'),
                      'machine_id'=>$this->input->post('machine'),
                      'shift_id'=>$this->input->post('shift'),
                      'user_id'=>$this->session->userdata['logged_in']['user_id'],
                      'operator'=>$this->input->post('operator'),
                      'jobcard_no'=>$this->input->post('job_card_no_'.$i.''),
                      'order_no'=>$order_no,
                      'article_no'=>$product_no,
                      'diameter'=>$dia,
                      'length'=>$sleeve_length,
                      'sleeve_weight_kg'=>$total_sleeve_weight,
                      'rm_mixed_qty_kg'=>$this->input->post('rm_mixing_'.$i.''),
                      'ok_qty_no'=>$this->input->post('ok_qty_'.$i.''),
                      'scrap_weight_kg'=>$this->input->post('scrap_weight_'.$i.''),
                      'scrap_tube_no'=>round($this->input->post('scrap_weight_'.$i.'')/$total_sleeve_weight),
                      'cutting_speed_minutes'=>$this->input->post('cutting_speed_'.$i.''),
                      'job_runtime_minutes'=>round(($this->input->post('ok_qty_'.$i.'')+($this->input->post('scrap_weight_'.$i.'')/$total_sleeve_weight))/$this->input->post('cutting_speed_'.$i.'')),
                      'rejection_percentage'=>$rejection
                    );


                  }else{
                     $dat=array(
                      'company_id'=>$this->session->userdata['logged_in']['company_id'],
                      'extrusion_date'=>$this->input->post('extrusion_date'),
                      'machine_id'=>$this->input->post('machine'),
                      'shift_id'=>$this->input->post('shift'),
                      'user_id'=>$this->session->userdata['logged_in']['user_id'],
                      'operator'=>$this->input->post('operator'),
                      'order_no'=>'PURGING',
                      'article_no'=>$this->input->post('job_card_no_'.$i.''),
                      'jobcard_no'=>$this->input->post('job_card_no_'.$i.''),
                      'rm_mixed_qty_kg'=>$this->input->post('rm_mixing_'.$i.''),
                      'ok_qty_no'=>$this->input->post('ok_qty_'.$i.''),
                      'scrap_weight_kg'=>$this->input->post('scrap_weight_'.$i.''),
                      'cutting_speed_minutes'=>$this->input->post('cutting_speed_'.$i.''),
                      'rejection_percentage'=>'100'
                    );
                  }

                  $result=$this->common_model->update_one_active_record('coex_extrusion',$dat,'ce_id',$this->input->post('ce_id'),$this->session->userdata['logged_in']['company_id']);

                }



                

                $dataa = array('process_id' =>'1');
                $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
                $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
                $data['coex_extrusion']=$this->coex_printing_model->select_one_active_record('coex_extrusion',$this->session->userdata['logged_in']['company_id'],'coex_extrusion.ce_id',$this->input->post('ce_id'));

                $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,'coex_extrusion');

                $data['note']='Update Transaction Completed';
                header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                  $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
                  $this->load->view('Home/footer');
              }
            }else{
              $data['note']='No Modify rights Thanks';
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
      $data['note']='No Modify rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  }


function current_status(){
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,'coex_printing');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            
            $this->load->model('coex_runtime_downtime_model');
            $dataa = array('process_id' =>'3');
            $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
            
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            //$this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/current-status',$data);
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


  function view(){

   $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            
            $data['company']=$this->common_model->select_one_active_record('company_master',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);


            $data['company_details']=$this->common_model->select_one_active_record('company_system_parameters',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);

            $data['coex_extrusion']=$this->coex_printing_model->select_one_active_record('coex_extrusion',$this->session->userdata['logged_in']['company_id'],'coex_extrusion.ce_id',$this->uri->segment(3));
            
            $this->load->view('Print/header',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/view-form',$data);
          }else{
              $data['note']='No View rights Thanks';
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
      $data['note']='No view rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  
  }



  function modify(){

      $data['page_name']='Production';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,'coex_extrusion');

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){

                  $dataa=array('process_id' =>'1');
                  $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
                  $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
                  $data['coex_extrusion']=$this->coex_printing_model->select_one_active_record('coex_extrusion',$this->session->userdata['logged_in']['company_id'],'coex_extrusion.ce_id',$this->uri->segment(3));
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                  $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
                  $this->load->view('Home/footer');
            }else{
                $data['note']='No modify rights Thanks';
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
        $data['note']='No modify rights Thanks';
        $data['page_name']='production';
        $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
        $this->load->view('Home/header');
        $this->load->view('Home/nav',$data);
        $this->load->view('Home/subnav');
        $this->load->view('Error/error-title',$data);
        $this->load->view('Home/footer');
      }
    }


  function delete(){

      $data['page_name']='Production';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,'coex_extrusion_rm_mixing');

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

                $data=array('archive'=>'1');

                $result=$this->common_model->archive_one_record('coex_extrusion_rm_mixing',$data,'cerm_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

                $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,'coex_extrusion_qc_control_plan');
                $dataa = array('process_id' =>'1');
                $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
                $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
                $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['coex_extrusion_rm_mixing']=$this->coex_extrusion_rm_mixing_model->select_one_active_record('coex_extrusion_rm_mixing',$this->session->userdata['logged_in']['company_id'],'coex_extrusion_rm_mixing.cerm_id',$this->uri->segment(3));

                $data['note']='Archive Transaction completed';
               // header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                  $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
                  $this->load->view('Home/footer');
            }else{
                $data['note']='No Archive rights Thanks';
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
        $data['note']='No Archive rights Thanks';
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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,'coex_extrusion_qc_control_plan');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->delete==1){
            $table='coex_extrusion_qc_control_plan';
            include('pagination_archive.php');
            $data['coex_extrusion_qc_control_plan']=$this->coex_extrusion_qc_control_plan_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
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


  function qc_check(){

      $data['page_name']='Production';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,'coex_extrusion');

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){

                  $dataa=array('process_id' =>'1');
                  $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
                  $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
                  $data['coex_extrusion']=$this->coex_printing_model->select_one_active_record('coex_extrusion',$this->session->userdata['logged_in']['company_id'],'coex_extrusion.ce_id',$this->uri->segment(3));
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                  $this->load->view(ucwords($this->router->fetch_class()).'/qc-form',$data);
                  $this->load->view('Home/footer');
            }else{
                $data['note']='No modify rights Thanks';
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
        $data['note']='No modify rights Thanks';
        $data['page_name']='production';
        $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
        $this->load->view('Home/header');
        $this->load->view('Home/nav',$data);
        $this->load->view('Home/subnav');
        $this->load->view('Error/error-title',$data);
        $this->load->view('Home/footer');
      }
    }





}

