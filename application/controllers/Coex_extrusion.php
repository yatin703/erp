<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coex_extrusion extends CI_Controller {

  function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('coex_extrusion_model');
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
             $table='coex_extrusion';
             include('pagination.php');
             $data['coex_extrusion']=$this->coex_extrusion_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
              //echo $this->db->last_query();
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
            $dataa = array('process_id' =>'1');
            $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
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
          if($formrights_row->new==1){
            $dataa = array('process_id' =>'1');
            $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
            $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
            $dataa = array('process_id' =>'1','start_stop_flag'=>'0');
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
          if($formrights_row->new==1){
            $dataa = array('process_id' =>'1');
            $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
            $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
            $dataa = array('process_id'=>'1','start_stop_flag'=>'0');
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

   function search(){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){
            $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
            $dataa = array('process_id' =>'1');
            $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
            $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']); 
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
            $table='coex_machine_runtime';
            include('pagination.php');
            $dataa = array('process_id' =>'1');
            $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
            $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
            $dataa = array('process_id' =>'1','start_stop_flag'=>'0');
            $data['coex_extrusion_machine_stop_reasons']=$this->common_model->select_active_records_where('coex_machine_start_stop_reasons',$this->session->userdata['logged_in']['company_id'],$dataa);

             $data['coex_machine_runtime']=$this->coex_extrusion_model->select_runtime_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

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
             $data['coex_machine_downtime']=$this->coex_extrusion_model->select_downtime_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

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
              $dataa = array('process_id' =>'1');
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
              $dataa = array('process_id' =>'1','start_stop_flag'=>'0');
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
              $data=array('coex_machine_downtime.machine_id'=>$this->input->post('machine'),
                'coex_machine_downtime.process_id'=>'1');
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
            $this->form_validation->set_rules('from_date','From Date' ,'trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('to_date','To Date' ,'trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('machine','Machine' ,'trim|xss_clean');
            if($this->form_validation->run()==FALSE){
              $dataa = array('process_id' =>'1');
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
              $dataa = array('process_id' =>'1','start_stop_flag'=>'0');
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
              $data=array('coex_machine_runtime.machine_id'=>$this->input->post('machine'));
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

          $this->form_validation->set_rules('from_date','From Date' ,'trim|xss_clean|exact_length[10]');
          $this->form_validation->set_rules('to_date','To Date' ,'trim|xss_clean|exact_length[10]');
          $this->form_validation->set_rules('release_from_date','Release From Date','trim|xss_clean|exact_length[10]');
          $this->form_validation->set_rules('release_to_date','Release To Date','trim|xss_clean|exact_length[10]');
                     
          if($this->form_validation->run()==FALSE){
            $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
            $dataa = array('process_id' =>'1');
            $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
            $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);

            $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
            
             $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
             
            $data['page_name']='Production';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

            $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

             $data_search_1=array('status'=>'0');

            $data['coex_extrusion']=$this->coex_extrusion_model->active_record_search_coex('coex_extrusion',$this->session->userdata['logged_in']['company_id'],$data_search_1,$this->input->post('from_date'),$this->input->post('to_date'),$this->input->post('release_from_date'),$this->input->post('release_to_date')); 

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
            $this->load->view('Home/footer');
          }else{              
            
            
            $data_search=array();
            if($this->input->post('shift')!=''){
              $data_search['shift_id']=$this->input->post('shift');
            }
            if($this->input->post('machine')!=''){
              $data_search['machine_id']=$this->input->post('machine');
            }
            /*if($this->input->post('diameter')!=''){
              $data_search['diameter']=$this->input->post('diameter');
            }*/
            if($this->input->post('sleeve_dia')!=''){
              $sleeve_dia_arr=explode("//", $this->input->post('sleeve_dia'));
              $data_search['diameter']=$sleeve_dia_arr[0];
            }
            if($this->input->post('length')!=''){
              $data_search['length']=$this->input->post('length');
            }
            if($this->input->post('jobcard_no')!=''){
              $data_search['jobcard_no']=$this->input->post('jobcard_no');
            }
            if($this->input->post('order_no')!=''){
              $data_search['order_no']=$this->input->post('order_no');
            }
            if($this->input->post('release_to_order_no')!=''){
              $data_search['release_order_no']=$this->input->post('release_to_order_no');
            }
            if($this->input->post('article_no')!=''){
              $article_arr=explode("//",$this->input->post('article_no'));
              $data_search['article_no']=$article_arr[1];
            }
            if($this->input->post('status')!=''){
              $data_search['status']=$this->input->post('status');
            }
           
            $data['coex_extrusion']=$this->coex_extrusion_model->active_record_search_coex('coex_extrusion',$this->session->userdata['logged_in']['company_id'],$data_search,$this->input->post('from_date'),$this->input->post('to_date'),$this->input->post('release_from_date'),$this->input->post('release_to_date')); 
           //echo $this->db->last_query();            

            $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);                
            $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

            $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']); 

            $dataa = array('process_id' =>'1');
            $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
            $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);


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
            $this->form_validation->set_rules('shift','Shift' ,'required|trim|xss_clean|callback_production_entry_check');
            $this->form_validation->set_rules('machine','Machine' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('operator','Operator' ,'required|trim|xss_clean');

            for($i=1;$i<=count($this->input->post('sr_no'));$i++){

              $this->common_model->save_number($this->input->post('unit_rate_'.$i.''),$this->session->userdata['logged_in']['company_id']);

              $this->form_validation->set_rules('job_card_no_'.$i.'','JOBCARD NO '.$i.'' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('rm_mixing_'.$i.'','RM Mixing Quantity '.$i.'' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('ok_qty_'.$i.'','OK Quantity '.$i.'' ,'required|trim|xss_clean|max_length[20]|is_natural|callback_possible_check['.$this->input->post('rm_mixing_'.$i.'').'||'.$this->input->post('job_card_no_'.$i.'').']');
              $this->form_validation->set_rules('scrap_weight_'.$i.'','Scrap Weight '.$i.'' ,'trim|xss_clean|numeric');
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
                            $data['specification_sleeve_details']=$this->specification_model->select_details_record_for_jobcard_where_gauge('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$sleeve_specs->spec_id,'specification_sheet_details.spec_version_no',$sleeve_specs->spec_version_no,'item_group_id','3','layer_no',$j,'parameter_name','GUAGE','srd_id','asc','layer_no','asc');
                            foreach($data['specification_sleeve_details'] as $specification_sleeve_details_row){
                              $gauge=rtrim($specification_sleeve_details_row->parameter_value," MIC");
                              $density="";
                              $sleeve_weight="";
                              if($layer_no==5 && $j==3){
                                $density=1.18;
                              }else{
                                $density=0.92;
                              }
                             $sleeve_weight=((($dia*$length*$gauge*$pi*$density)/1000000)+(((($dia*$length*$gauge*$pi*$density)/1000000)/100)*5))/1000;
                             

                              $total_sleeve_weight+=$sleeve_weight;

                            }
                            
                          }
                        }
                      }
                    }
                  }
                  $total_sleeve_weight=floor($total_sleeve_weight*10000)/10000;


                
                $rejection=(100-(($this->input->post('ok_qty_'.$i.'')/($this->input->post('rm_mixing_'.$i.'')/$total_sleeve_weight))*100));


                $scrap_tube_no=(($this->input->post('rm_mixing_'.$i.'')/$total_sleeve_weight)-$this->input->post('ok_qty_'.$i.''));

                $dat=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'sleeve_code'=>$sleeve_code,
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
                'layer_no'=>$layer_no,
                'sleeve_weight_kg'=>$total_sleeve_weight,
                'rm_mixed_qty_kg'=>$this->input->post('rm_mixing_'.$i.''),
                'ok_qty_no'=>$this->input->post('ok_qty_'.$i.''),
                'scrap_weight_kg'=>round($scrap_tube_no*$total_sleeve_weight,2),
                'scrap_tube_no'=>round($scrap_tube_no),
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
                $this->form_validation->set_rules('scrap_weight_'.$i.'','Scrap Weight '.$i.'' ,'trim|xss_clean|numeric');
                $this->form_validation->set_rules('cutting_speed_'.$i.'','Cutting Speed '.$i.'' ,'required|trim|xss_clean|is_natural_no_zero');

              }

            if($this->form_validation->run()==FALSE){
                $dataa = array('process_id' =>'1');
                $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
                $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
                $data['coex_extrusion']=$this->coex_extrusion_model->select_one_active_record('coex_extrusion',$this->session->userdata['logged_in']['company_id'],'coex_extrusion.ce_id',$this->input->post('ce_id'));

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/qc-form',$data);
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
                    $total_sleeve_weight="";
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
                              $total_sleeve_weight=0;
                              for($j=1;$j<=$layer_no;$j++){
                                $gauge="";
                                $data['specification_sleeve_details']=$this->specification_model->select_details_record_for_jobcard_where_gauge('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$sleeve_specs->spec_id,'specification_sheet_details.spec_version_no',$sleeve_specs->spec_version_no,'item_group_id','3','layer_no',$j,'parameter_name','GUAGE','srd_id','asc','layer_no','asc');
                                foreach($data['specification_sleeve_details'] as $specification_sleeve_details_row){
                                  $gauge=rtrim($specification_sleeve_details_row->parameter_value," MIC");
                                  $density="";
                                  $sleeve_weight="";
                                  if($layer_no==5 && $i==3){
                                    $density=1.18;
                                  }else{
                                    $density=0.92;
                                  }
                                 
                                  $sleeve_weight=((($dia*$length*$gauge*$pi*$density)/1000000)+(((($dia*$length*$gauge*$pi*$density)/1000000)/100)*5))/1000;
                             

                                  $total_sleeve_weight+=$sleeve_weight;
                                 
                                }
                              }
                            }
                          }
                        }
                      }
                      $total_sleeve_weight=floor($total_sleeve_weight*10000)/10000;
                      $rejection=(100-(($this->input->post('ok_qty_'.$i.'')/($this->input->post('rm_mixing_'.$i.'')/$total_sleeve_weight))*100));
                      $scrap_tube_no=(($this->input->post('rm_mixing_'.$i.'')/$total_sleeve_weight)-$this->input->post('ok_qty_'.$i.''));
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
                      'scrap_weight_kg'=>round($scrap_tube_no*$total_sleeve_weight,2),
                      'scrap_tube_no'=>round($scrap_tube_no),
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
                  
                  date_default_timezone_set('Asia/Kolkata'); 
                  /*$data_qc_ok=array(
                    'company_id'=>$this->session->userdata['logged_in']['company_id'],
                    'user_id'=>$this->session->userdata['logged_in']['user_id'],
                    'ce_id'=>$this->input->post('ce_id'),
                    'jobcard_no'=>$this->input->post('job_card_no_1'),
                    'production_qty'=>$this->input->post('production_qty'),
                    'added_date'=>date('d-m-y h:i:s'),
                  );                
                  $result=$this->common_model->save('coex_extrusion_qc',$data_qc_ok);

                  $data_qc_hold=array(
                    'company_id'=>$this->session->userdata['logged_in']['company_id'],
                    'user_id'=>$this->session->userdata['logged_in']['user_id'],
                    'ce_id'=>$this->input->post('ce_id'),
                    'jobcard_no'=>$this->input->post('job_card_no_1'),
                    'hold_by_qc'=>$this->input->post('hold_by_qc'),
                    'added_date'=>date('d-m-y h:i:s'),
                  );                
                  $result=$this->common_model->save('coex_extrusion_wip',$data_qc_hold);*/
                }
                
                $dataa = array('process_id' =>'1');
                $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
                $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
                $data['coex_extrusion']=$this->coex_extrusion_model->select_one_active_record('coex_extrusion',$this->session->userdata['logged_in']['company_id'],'coex_extrusion.ce_id',$this->input->post('ce_id'));

                $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,'coex_extrusion');

                $data['note']='Update Transaction Completed';
                header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,'coex_extrusion');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            
            $this->load->model('coex_runtime_downtime_model');
            $dataa = array('process_id' =>'1');
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

            $data['coex_extrusion']=$this->coex_extrusion_model->select_one_active_record('coex_extrusion',$this->session->userdata['logged_in']['company_id'],'coex_extrusion.ce_id',$this->uri->segment(3));
            
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
                  $data['coex_extrusion']=$this->coex_extrusion_model->select_one_active_record('coex_extrusion',$this->session->userdata['logged_in']['company_id'],'coex_extrusion.ce_id',$this->uri->segment(3));
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

function qc_create(){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){
            $dataa = array('process_id' =>'1');
            $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
            $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
            $data['coex_extrusion']=$this->coex_extrusion_model->select_one_active_record('coex_extrusion',$this->session->userdata['logged_in']['company_id'],'coex_extrusion.ce_id',$this->uri->segment(3));
            $data['defect']=$this->coex_extrusion_model->select_defect_model('coex_extrusion_defect');
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/qc-form',$data);
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

function qc_save(){

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
            $this->form_validation->set_rules('order_no','Order No' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('article_no','Product No' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('jobcard_no','Jobcard No' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sleeve_weight_gm','Sleeve Weight GM' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('diameter','Diameter' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('length','Length' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('production_qty','Production QTY' ,'required|trim|xss_clean|is_natural|callback_production_qty_check');
            $this->form_validation->set_rules('ok_by_qc','WIP QTY' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('hold_by_qc','Hold QTY' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('inspection_name','Inspection Name' ,'required|trim|xss_clean');

            if($this->form_validation->run()==FALSE){
              $dataa = array('process_id' =>'1');
            $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
            $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
            $data['coex_extrusion']=$this->coex_extrusion_model->select_one_active_record('coex_extrusion',$this->session->userdata['logged_in']['company_id'],'coex_extrusion.ce_id',$this->input->post('ce_id'));
            $data['defect']=$this->coex_extrusion_model->select_defect_model('coex_extrusion_defect');
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/qc-form',$data);
            $this->load->view('Home/footer');
            }else{

              $data_wip=array(
                  'company_id'       => $this->session->userdata['logged_in']['company_id'],
                  'ce_id'            => $this->input->post('ce_id'),
                  'extrusion_date'   => $this->input->post('extrusion_date'),
                  'shift_id'         => $this->input->post('shift'),
                  'machine_id'       => $this->input->post('machine'),
                  'operator'         => $this->input->post('operator'),
                  'article_no'       => $this->input->post('article_no'),
                  'jobcard_no'       => $this->input->post('jobcard_no'),
                  'order_no'         => $this->input->post('order_no'),
                  'diameter'         => $this->input->post('diameter'),
                  'length'           => $this->input->post('length'),
                  'sleeve_weight_gm' => $this->input->post('sleeve_weight_gm'),                  
                  'production_qty'   => $this->input->post('production_qty'),
                  'ok_by_qc'         => $this->input->post('ok_by_qc'),
                  'inspection_name'  => $this->input->post('inspection_name'),
                  'form_process'     => 'Extrusion Production',
                  'to_process'       => '1',
                  'user_id'          => $this->session->userdata['logged_in']['user_id'],
                  'archive'          => '0',
                  'created_date'     => date('Y-m-d H:i:s')         
                );
                $result=$this->common_model->save('coex_extrusion_wip',$data_wip);
        
                $data_wip_prod=array(
                  'company_id'       => $this->session->userdata['logged_in']['company_id'],
                  'ce_id'            => $this->input->post('ce_id'),
                  'extrusion_date'   => $this->input->post('extrusion_date'),
                  'shift_id'         => $this->input->post('shift'),
                  'machine_id'       => $this->input->post('machine'),
                  'operator'         => $this->input->post('operator'),
                  'article_no'       => $this->input->post('article_no'),
                  'jobcard_no'       => $this->input->post('jobcard_no'),
                  'order_no'         => $this->input->post('order_no'),
                  'diameter'         => $this->input->post('diameter'),
                  'length'           => $this->input->post('length'),
                  'sleeve_weight_gm' => $this->input->post('sleeve_weight_gm'),                  
                  'production_qty'   => $this->input->post('production_qty'),
                  'ok_by_qc'         => $this->input->post('ok_by_qc'),
                  'inspection_name'  => $this->input->post('inspection_name'),
                  'form_process'     => 'Extrusion Production',
                  'to_process'       => '1',
                  'user_id'          => $this->session->userdata['logged_in']['user_id'],
                  'archive'          => '0',
                  'created_date'     => date('Y-m-d H:i:s')         
                );
                $result=$this->common_model->save('coex_extrusion_wip_production',$data_wip_prod);
                
                $data_qc=array(
                  'company_id'       => $this->session->userdata['logged_in']['company_id'],
                  'ce_id'            => $this->input->post('ce_id'),
                  'extrusion_date'   => $this->input->post('extrusion_date'),
                  'shift_id'         => $this->input->post('shift'),
                  'machine_id'       => $this->input->post('machine'),
                  'operator'         => $this->input->post('operator'),
                  'article_no'       => $this->input->post('article_no'),
                  'jobcard_no'       => $this->input->post('jobcard_no'),
                  'order_no'         => $this->input->post('order_no'),
                  'diameter'         => $this->input->post('diameter'),
                  'length'           => $this->input->post('length'),
                  'sleeve_weight_gm' => $this->input->post('sleeve_weight_gm'),
                  'production_qty'   => $this->input->post('production_qty'),
                  'hold_by_qc'       => $this->input->post('hold_by_qc'),
                  'defect'           => implode(",",$this->input->post('defect')),
                  'inspection_name'  => $this->input->post('inspection_name'),
                  'form_process'     => 'Extrusion Production',
                  'to_process'       => '1',
                  'user_id'          => $this->session->userdata['logged_in']['user_id'],
                  'archive'          => '0',
                  'created_date'     => date('Y-m-d H:i:s')         
                );        
                $result=$this->common_model->save('coex_extrusion_qc',$data_qc);
                
                $data_ce=array(
                    'qc_flag'=> '1',
                    'qc_date'=>date('Y-m-d H:i:s')
                );
                $result=$this->common_model->update_one_active_record('coex_extrusion',$data_ce,'ce_id',$this->input->post('ce_id'),$this->session->userdata['logged_in']['company_id']);

              $dataa = array('process_id' =>'1');
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
              $data['coex_extrusion']=$this->coex_extrusion_model->select_one_active_record('coex_extrusion',$this->session->userdata['logged_in']['company_id'],'coex_extrusion.ce_id',$this->input->post('ce_id'));
              $data['defect']=$this->coex_extrusion_model->select_defect_model('coex_extrusion_defect');
        
              $data['page_name']='Prodution';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $data['note']='Create Transaction Completed';
              header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/qc-form',$data);
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

    function machine_vice_search(){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){
            $dataa = array('process_id' =>'1');
            $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/machine-vice-search-form',$data);
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
  
   function machine_vice_search_result(){

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
            if($this->form_validation->run()==FALSE){
              $dataa = array('process_id' =>'1');
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              //echo $this->db->last_query();
              $data['page_name']='production';
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/machine-vice-search-form',$data);
              $this->load->view('Home/footer');
            }else{
             // $data=array('coex_extrusion.machine_id'=>$this->input->post('machine'));
              $data = "";
              $from=$this->input->post('from_date');
              $to=$this->input->post('to_date');
              $data['coex_extrusion']=$this->coex_extrusion_model->active_record_search('coex_extrusion',$data='',$from,$to,$this->session->userdata['logged_in']['company_id']);
              //echo $this->db->last_query();
                $data['page_name']='Prodution';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
                $dataa = array('process_id' =>'1');
                $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
            
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/machine-vice-search-form',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/machine-vice-search-result',$data);
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



function mis_report(){ 

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){
           
            $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

             $data['invoice_types_master_lang']=$this->common_model->select_active_drop_down('invoice_types_master_lang',$this->session->userdata['logged_in']['company_id']); 


           
            if($data['account_periods_master']==FALSE){
              $from_date="";
            }else{
              foreach($data['account_periods_master'] as $account_periods_master_row){
                $from_date=$account_periods_master_row->fin_year_start;
              }
            }
            
           
             

           
            
             $data['gcm2']=$this->coex_extrusion_model->select_extrusion_monthwise_mis_gcm2($from_date,date('Y-m-d'));
             

           //echo $this->db->last_query();
            
            
           
           
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/mis_report_search',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/mis_report_view',$data);
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



  public function production_qty_check($str){
    $production_qty = $this->input->post('production_qty');
    $ok_by_qc       = $this->input->post('ok_by_qc');
    $hold_by_qc     = $this->input->post('hold_by_qc');
    $total_qty      = $ok_by_qc+$hold_by_qc;

    if($production_qty < $total_qty){
      $this->form_validation->set_message('production_qty_check', 'The {field} does not match');
      return FALSE;
    }else if($production_qty > $total_qty){
      $this->form_validation->set_message('production_qty_check', 'The {field} does not match');
      return FALSE;
    }else{
      return TRUE;
    }

  }


  public function possible_check($str,$fiel){
    //echo $str;
    //echo "<br/>";

    $var=explode("||",$fiel);

    //echo $var[0];

   // echo "<br/>";

    //echo $var[1];

    //echo "<br/>";
    
    $result_jobcard=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$var[1]);
    //echo $this->db->last_query();
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
                $total_sleeve_weight="";
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
                            $data['specification_sleeve_details']=$this->specification_model->select_details_record_for_jobcard_where_gauge('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$sleeve_specs->spec_id,'specification_sheet_details.spec_version_no',$sleeve_specs->spec_version_no,'item_group_id','3','layer_no',$j,'parameter_name','GUAGE','srd_id','asc','layer_no','asc');
                            foreach($data['specification_sleeve_details'] as $specification_sleeve_details_row){
                              $gauge=rtrim($specification_sleeve_details_row->parameter_value," MIC");
                              $density="";
                              $sleeve_weight="";
                              if($layer_no==5 && $j==3){
                                $density=1.18;
                              }else{
                                $density=0.92;
                              }
                              $sleeve_weight=((($dia*$length*$gauge*$pi*$density)/1000000)+(((($dia*$length*$gauge*$pi*$density)/1000000)/100)*5))/1000;
                              $total_sleeve_weight+=$sleeve_weight;

                            }
                            
                          }
                        }
                      }
                    }
                  }
                  $total_sleeve_weight=floor($total_sleeve_weight*10000)/10000;

                  $possible_qty=$fiel/$total_sleeve_weight;

                  //echo $possible_qty;

                  //echo $var[0];

                  
                  if($possible_qty<$str){

                    
                    $this->form_validation->set_message('possible_check', 'The {field} is not possible in the specified RM');
                    //echo "Wait";
                       return FALSE;
                  }else{

                    //echo "I AM HERE";
                    return TRUE;
                 }
}

public function production_entry_check($str)
  {
    $extrusion_date = $this->input->post('extrusion_date');
    $shift          = $this->input->post('shift');
    $machine        = $this->input->post('machine');

    $this->db->select('ce_id');
    $this->db->from('coex_extrusion');
    $this->db->where('extrusion_date', $extrusion_date);
    $this->db->where('shift_id', $shift);
    $this->db->where('machine_id', $machine);
    $query = $this->db->get();
    $num = $query->num_rows();
    if($num > 0){
      $this->form_validation->set_message('production_entry_check', 'The {field} Already Exit.');
      return FALSE;
    }else{
      return TRUE;
    }
  }



  function data_transform(){

    $table='coex_extrusion';

    $this->db2 = $this->load->database('another_db2', TRUE);
    $exidrow=$this->coex_extrusion_model->get_extrusion_('extrusion');
 
    $lastexid=$exidrow['maxexid'];
    $newexid=$lastexid+1;

    $data['dbdata']=$this->common_model->select_db1_record();

    $count = 1;
    $sleeve_weight_kg=0;
    $rm_mixed_qty_kg=0;
    $ok_qty_no=0;
    $scrap_weight_kg=0;
    $scrap_tube_no=0;
    $cutting_speed_minutes=0;
    $job_runtime_minutes=0;
    $shift_id1=0;
    $transform_flag='';
    $c='';
    $d='';
    $g='';
    $f='';
    $y='';

    $currentDateTime = date('Y-m-d H:i:s');
     
    foreach($data['dbdata'] as $dbdata1){

      $a=$dbdata1->ce_id;
      $b=$dbdata1->extrusion_date;
      $c=$dbdata1->machine_id;
      $d=$dbdata1->shift_id;
      $e=$dbdata1->user_id;
      $f=$dbdata1->jobcard_no;
      $g=$dbdata1->order_no;
      $h=$dbdata1->article_no;
      $i=$dbdata1->diameter;
      $j=$dbdata1->length;
      $k=$dbdata1->layer_no;
      $l=$dbdata1->sleeve_weight_kg;
      $m=$dbdata1->rm_mixed_qty_kg;
      $n=$dbdata1->ok_qty_no;
      $o=$dbdata1->scrap_weight_kg;
      $p=$dbdata1->scrap_tube_no;
      $q=$dbdata1->cutting_speed_minutes;
      $r=$dbdata1->job_runtime_minutes;
      $s=$dbdata1->qc_date;
      $rp=$dbdata1->rejection_percentage;
      $operator=$dbdata1->operator;
      $transform_flag=$dbdata1->transform_flag;
      $bb = date("d-m-Y", strtotime($b));

      if ($transform_flag=='0') {
              
        $query = $this->db->query("SELECT * FROM coex_extrusion where machine_id='1' and shift_id='1' and `extrusion_date`='2023-05-19'" );
        $this->db->last_query();
        $query->num_rows();
          
        if($query->num_rows()>0){
          if($d==1 and $c==1){ 
            $shift_id1++;
            $maximum=0;
            
            $sleeve_weight_kg=$sleeve_weight_kg+$l;
            $rm_mixed_qty_kg=$rm_mixed_qty_kg+$m;
            $ok_qty_no=$ok_qty_no+$n;
            $scrap_weight_kg=$scrap_weight_kg+$o;
            $scrap_tube_no=$scrap_tube_no+$p;
            $expected_sleeve_prod=$n+$p;
            $sp_minutes = $n+$p/$q;
            $job_runtime_minutes=$job_runtime_minutes+$r;

            $this->db2 = $this->load->database('another_db2', TRUE);
             
            $jobcard_qty['jqty']=$this->coex_extrusion_model->get_jobcard_qty($g,$f);
                foreach($jobcard_qty['jqty'] as $j){
                  $y=$j->actual_qty_manufactured/100;
                }
        
                  $dataa = array( 'ex_id'=>$newexid,
                    'date' =>$bb,
                    'shift_id'=>$d,
                    'plant_id'=>'3',
                    'machine_id'=>$c,
                    'process_id'=>'1',
                    'job_no'=>'JOB'.$count,
                    'psp_psm_no'=>$h,
                    'job_card_no'=>$f,
                    'so_no'=>$g,
                    'total_rm_kg'=>$m,
                    //'ttotal_rm_kg'=>$m,
                    'time'=>time(),
                    'expected_sleeve_prod'=>$expected_sleeve_prod,
                    'sp_minutes'=>$sp_minutes,
                    'job_order_quantity'=>$y,
                    'rp'=>$rp,
                    'wp'=>$rp,
                    'operator_id'=>$operator,                    
                    'sleeve_weight_kg'=>$sleeve_weight_kg,
                    'sleeve_to_header'=>$n,
                    'sleeve_waste_kg'=>$o,
                    'sleeve_waste_no'=>$p,
                    'minutes'=>$r,
                  );
                        $count++;
                        $data['db2data']=$this->common_model->save_db2('extrusion',$dataa);
                    }
                }
            }
        }
    
        if ($transform_flag=='0') {

            $query = $this->db->query("SELECT * FROM coex_extrusion where machine_id='1' and shift_id='1' and `extrusion_date`='2023-05-19'" );
            $query->num_rows();
          
            if($query->num_rows()>0){          
            
                if($shift_id1<7){
                    $z=5;
            
                    for ($x = $shift_id1; $x <= $z; $x++) {
              $a=' ';
              $y=$x+1;

                        $dataa = array('ex_id'=>$newexid,
                     'date' =>' ',
                     'shift_id'=>' ',
                     'machine_id'=>' ',
                     'job_no'=>'JOB'.$y,
                     'job_card_no'=>' ',
                     'so_no'=>' ',
                     'operator_id'=>' ',
                     'shift_id'=>$d,
                     'plant_id'=>'3',
                     'machine_id'=>$c,
                     'process_id'=>'1',
                  );
                        $maximum;
                        $data['db2data']=$this->common_model->save_db2('extrusion',$dataa);

            }       
        }else{
           'contect to erp team';
        }
        
                $dataa = array('ex_id'=>$newexid,
                               'job_no'=>'TOTAL',
                               'total_rm_kg'=>$m,                               
                               'expected_sleeve_prod'=>$expected_sleeve_prod,
                               'sleeve_to_header' =>$ok_qty_no,
                               'sleeve_waste_kg' =>$scrap_weight_kg,
                               'sleeve_waste_no' =>$scrap_tube_no,
                               'downminutesbysystem'=> 480 - $r,
                               'rp'=>$rp,
                               'wp'=>$rp,
                               'minutes' =>$job_runtime_minutes,
                               'shift_id'=>$d,
                               'plant_id'=>'3',
                               'machine_id'=>$c,
                               'process_id'=>'1',
                            );

                $data['db2data']=$this->common_model->save_db2('extrusion',$dataa);
            }
        }

        $dates='2023-05-19';
        $data_update=array(
            'transform_flag'=> '1'
        );
              
        $result=$this->common_model->update_one_active_record_where_where('coex_extrusion',$data_update,'extrusion_date',$dates, 'machine_id', '1', 'shift_id','1',$this->session->userdata['logged_in']['company_id']);

//******************************//

    $this->db2 = $this->load->database('another_db2', TRUE);
    $exidrow=$this->coex_extrusion_model->get_extrusion_('extrusion');
    $lastexid=$exidrow['maxexid'];
    $newexid=$lastexid+1;

        $data['dbdata']=$this->common_model->select_db1_record();

    $count = 1;
    $sleeve_weight_kg=0;
    $rm_mixed_qty_kg=0;
    $ok_qty_no=0;
    $scrap_weight_kg=0;
    $scrap_tube_no=0;
    $cutting_speed_minutes=0;
    $job_runtime_minutes=0;
    $shift_id2=0;
    $transform_flag='';
   
        foreach($data['dbdata'] as $dbdata1){
               $a=$dbdata1->ce_id;
               $b=$dbdata1->extrusion_date;
               $c=$dbdata1->machine_id;
               $d=$dbdata1->shift_id;
               $e=$dbdata1->user_id;
               $f=$dbdata1->jobcard_no;
               $g=$dbdata1->order_no;
               $h=$dbdata1->article_no;
               $i=$dbdata1->diameter;
               $j=$dbdata1->length;
               $k=$dbdata1->layer_no;
               $l=$dbdata1->sleeve_weight_kg;
               $m=$dbdata1->rm_mixed_qty_kg;
               $n=$dbdata1->ok_qty_no;
               $o=$dbdata1->scrap_weight_kg;
               $p=$dbdata1->scrap_tube_no;
               $q=$dbdata1->cutting_speed_minutes;
               $r=$dbdata1->job_runtime_minutes;
               $s=$dbdata1->qc_date;
               $transform_flag=$dbdata1->transform_flag;
               $bb = date("d-m-Y", strtotime($b));
         
            if($transform_flag=='0'){
        
        $query = $this->db->query("SELECT * FROM coex_extrusion where machine_id='1' and shift_id='3' and `extrusion_date`='2023-05-19'" );
                $this->db->last_query();
                $query->num_rows();
          
                if($query->num_rows()>0){
        
                    if($d==1 and $c==3){
                        $shift_id2++;
            
            $sleeve_weight_kg=$sleeve_weight_kg+$l;
            $rm_mixed_qty_kg=$rm_mixed_qty_kg+$m;
            $ok_qty_no=$ok_qty_no+$n;
            $scrap_weight_kg=$scrap_weight_kg+$o;
            $scrap_tube_no=$scrap_tube_no+$p;
            $expected_sleeve_prod=$n+$p;
            $sp_minutes = $n+$p/$q;
            $job_runtime_minutes=$job_runtime_minutes+$r;

                        $this->db2 = $this->load->database('another_db2', TRUE);
       
              $jobcard_qty['jqty']=$this->coex_extrusion_model->get_jobcard_qty($g,$f);
              foreach($jobcard_qty['jqty'] as $j){
                $y=$j->actual_qty_manufactured/100;
              }

                        $dataa = array( 'ex_id'=>$newexid,
                    'date' =>$bb,
                    'shift_id'=>$d,
                    'plant_id'=>'3',
                    'machine_id'=>$c,
                    'process_id'=>'1',
                    'job_no'=>'JOB'.$count,
                    'psp_psm_no'=>$h,
                    'job_card_no'=>$f,
                    'so_no'=>$g,
                    'total_rm_kg'=>$m,
                    //'ttotal_rm_kg'=>$m,
                    'time'=>time(),
                    'expected_sleeve_prod'=>$expected_sleeve_prod,
                    'sp_minutes'=>$sp_minutes,
                    'job_order_quantity'=>$y,
                    'rp'=>$rp,
                    'wp'=>$rp,
                    'operator_id'=>$operator,
                    'sleeve_weight_kg'=>$sleeve_weight_kg,
                    'sleeve_to_header'=>$n,
                    'sleeve_waste_kg'=>$o,
                    'sleeve_waste_no'=>$p,
                    'minutes'=>$r,                        
                                    );
                        $count++;
                        $data['db2data']=$this->common_model->save_db2('extrusion',$dataa);
                    }
            }
            }
        }

        if($transform_flag=='0'){
       
        $query = $this->db->query("SELECT * FROM coex_extrusion where machine_id='1' and shift_id='3' and `extrusion_date`='2023-05-19'" );
            $query->num_rows();
          
            if($query->num_rows()>0){
            
                if($shift_id2<7){
                    $z=5;

                    for ($x = $shift_id2; $x <= $z; $x++) {
              $a=' ';
              $y=$x+1;

                        $dataa = array('ex_id'=>$newexid,
                     'date' =>' ',
                     'shift_id'=>' ',
                     'machine_id'=>' ',
                     'job_no'=>'JOB'.$y,
                     'job_card_no'=>' ',
                     'so_no'=>' ',
                     'operator_id'=>' ',
                     'shift_id'=>$d,
                     'plant_id'=>'3',
                     'machine_id'=>$c,
                     'process_id'=>'1'
                  );

                        $data['db2data']=$this->common_model->save_db2('extrusion',$dataa);
          }
        }else{
           'contect to erp team';
        }
        
        $dataa = array( 'ex_id'=>$newexid,
                'job_no'=>'TOTAL',
                'total_rm_kg'=>$m,
                //'sleeve_weight_kg' =>$sleeve_weight_kg,
                'sleeve_to_header' =>$ok_qty_no,
                'sleeve_waste_kg' =>$scrap_weight_kg,
                'sleeve_waste_no' =>$scrap_tube_no,
                'minutes' =>$job_runtime_minutes,
                'downminutesbysystem'=> 480 - $r,
                'rp'=>$rp,
                'wp'=>$rp,
                'shift_id'=>$d,
                'plant_id'=>'3',
                'machine_id'=>$c,
                'process_id'=>'1'
                    );

        $data['db2data']=$this->common_model->save_db2('extrusion',$dataa);
      }
    }
          
    $dates='2023-05-19';
        $data_update=array(
            'transform_flag'=> '1'
        );
              
        $result=$this->common_model->update_one_active_record_where_where('coex_extrusion',$data_update,'extrusion_date',$dates, 'machine_id', '1', 'shift_id','3',$this->session->userdata['logged_in']['company_id']);

             

//****************************************//

        $data['dbdata']=$this->common_model->select_db1_record();
        $this->db2 = $this->load->database('another_db2', TRUE);
        $exidrow=$this->coex_extrusion_model->get_extrusion_('extrusion');
        $lastexid=$exidrow['maxexid'];
        $newexid=$lastexid+1;

    $count = 1;
    $sleeve_weight_kg=0;
    $rm_mixed_qty_kg=0;
    $ok_qty_no=0;
    $scrap_weight_kg=0;
    $scrap_tube_no=0;
    $cutting_speed_minutes=0;
    $job_runtime_minutes=0;
    $shift_id3=0;
    $transform_flag='';
 
        foreach($data['dbdata'] as $dbdata1){
      $a=$dbdata1->ce_id;
      $b=$dbdata1->extrusion_date;
      $c=$dbdata1->machine_id;
      $d=$dbdata1->shift_id;
      $e=$dbdata1->user_id;
      $f=$dbdata1->jobcard_no;
      $g=$dbdata1->order_no;
      $h=$dbdata1->article_no;
      $i=$dbdata1->diameter;
      $j=$dbdata1->length;
      $k=$dbdata1->layer_no;
      $l=$dbdata1->sleeve_weight_kg;
      $m=$dbdata1->rm_mixed_qty_kg;
      $n=$dbdata1->ok_qty_no;
      $o=$dbdata1->scrap_weight_kg;
      $p=$dbdata1->scrap_tube_no;
      $q=$dbdata1->cutting_speed_minutes;
      $r=$dbdata1->job_runtime_minutes;
      $s=$dbdata1->qc_date;
      $transform_flag=$dbdata1->transform_flag;
            $bb = date("d-m-Y", strtotime($b));
      
            if($transform_flag=='0'){
        
        $query = $this->db->query("SELECT * FROM coex_extrusion where machine_id='1' and shift_id='2' and `extrusion_date`='2023-05-19'" );
                $query->num_rows();
          
                if($query->num_rows()>0){
        
                    if($d==1 and $c==2){
                        $shift_id3++;

            $sleeve_weight_kg=$sleeve_weight_kg+$l;
            $rm_mixed_qty_kg=$rm_mixed_qty_kg+$m;
            $ok_qty_no=$ok_qty_no+$n;
            $scrap_weight_kg=$scrap_weight_kg+$o;
            $scrap_tube_no=$scrap_tube_no+$p;
            $expected_sleeve_prod=$n+$p;
            $sp_minutes = $n+$p/$q;
            $job_runtime_minutes=$job_runtime_minutes+$r;

            $this->db2 = $this->load->database('another_db2', TRUE);
             
            $jobcard_qty['jqty']=$this->coex_extrusion_model->get_jobcard_qty($g,$f);
                foreach($jobcard_qty['jqty'] as $j){
                  $y=$j->actual_qty_manufactured/100;
                }
        
                        $dataa = array( 'ex_id'=>$newexid,
                    'date' =>$bb,
                    'shift_id'=>$d,
                    'plant_id'=>'3',
                    'machine_id'=>$c,
                    'process_id'=>'1',
                    'job_no'=>'JOB'.$count,
                    'psp_psm_no'=>$h,
                    'job_card_no'=>$f,
                    'so_no'=>$g,
                    'total_rm_kg'=>$m,
                    //'ttotal_rm_kg'=>$m,
                    'time'=>time(),
                    'expected_sleeve_prod'=>$expected_sleeve_prod,
                    'sp_minutes'=>$sp_minutes,
                    'job_order_quantity'=>$y,
                    'rp'=>$rp,
                    'wp'=>$rp,
                    'operator_id'=>$operator,
                    //'downminutesbysystem'=> 480 - $r,
                    'sleeve_weight_kg'=>$sleeve_weight_kg,
                    'sleeve_to_header'=>$n,
                    'sleeve_waste_kg'=>$o,
                    'sleeve_waste_no'=>$p,
                    'minutes'=>$r,
                  );
                        $count++;
                        $data['db2data']=$this->common_model->save_db2('extrusion',$dataa);
                    }
            }
            }
        }
    
        if($transform_flag=='0'){
      
      $query = $this->db->query("SELECT * FROM coex_extrusion where machine_id='1' and shift_id='2' and `extrusion_date`='2023-05-19'" );
            $query->num_rows();
          
            if($query->num_rows()>0){
            
                if($shift_id3<7){
                    $z=5;

                    for ($x = $shift_id3; $x <= $z; $x++) {
              $a=' ';
              $y=$x+1;

                        $dataa = array('ex_id'=>$newexid,
                     'date' =>' ',
                     'shift_id'=>' ',
                     'machine_id'=>' ',
                     'job_no'=>'JOB'.$y,
                     'job_card_no'=>' ',
                     'so_no'=>' ',
                     'operator_id'=>' ',
                     'shift_id'=>$d,
                     'plant_id'=>'3',
                     'machine_id'=>$c,
                     'process_id'=>'1'
                  );

                        $data['db2data']=$this->common_model->save_db2('extrusion',$dataa);
                    }            
        }else{
           'contect to erp team';
        }
        
                $dataa = array('ex_id'=>$newexid,
                               'job_no'=>'TOTAL',
                               //'sleeve_weight_kg' =>$sleeve_weight_kg,
                               'total_rm_kg'=>$m,
                               'sleeve_to_header' =>$ok_qty_no,
                               'sleeve_waste_kg' =>$scrap_weight_kg,
                               'sleeve_waste_no' =>$scrap_tube_no,
                               'minutes' =>$job_runtime_minutes,
                               'downminutesbysystem'=> 480 - $r,
                               'rp'=>$rp,
                               'wp'=>$rp,
                               'shift_id'=>$d,
                               'plant_id'=>'3',
                               'machine_id'=>$c,
                               'process_id'=>'1'
                            );
              
                $data['db2data']=$this->common_model->save_db2('extrusion',$dataa);
            }
    }
      
    $dates='2023-05-19';
        $data_update=array(
            'transform_flag'=> '1'
        );
              
        $result=$this->common_model->update_one_active_record_where_where('coex_extrusion',$data_update,'extrusion_date',$dates, 'machine_id', '1', 'shift_id','2',$this->session->userdata['logged_in']['company_id']);

//*****************************************//

        $data['dbdata']=$this->common_model->select_db1_record();
        $this->db2 = $this->load->database('another_db2', TRUE);
        $exidrow=$this->coex_extrusion_model->get_extrusion_('extrusion');
        $lastexid=$exidrow['maxexid'];
        $newexid=$lastexid+1;

    $count = 1;
    $sleeve_weight_kg=0;
    $rm_mixed_qty_kg=0;
    $ok_qty_no=0;
    $scrap_weight_kg=0;
    $scrap_tube_no=0;
    $cutting_speed_minutes=0;
    $job_runtime_minutes=0;
    $shift_id4=0;
    $transform_flag='0';
 
        foreach($data['dbdata'] as $dbdata1){
       $a=$dbdata1->ce_id;
       $b=$dbdata1->extrusion_date;
       $c=$dbdata1->machine_id;
       $d=$dbdata1->shift_id;
       $e=$dbdata1->user_id;
       $f=$dbdata1->jobcard_no;
       $g=$dbdata1->order_no;
       $h=$dbdata1->article_no;
       $i=$dbdata1->diameter;
       $j=$dbdata1->length;
       $k=$dbdata1->layer_no;
       $l=$dbdata1->sleeve_weight_kg;
       $m=$dbdata1->rm_mixed_qty_kg;
       $n=$dbdata1->ok_qty_no;
       $o=$dbdata1->scrap_weight_kg;
       $p=$dbdata1->scrap_tube_no;
       $q=$dbdata1->cutting_speed_minutes;
       $r=$dbdata1->job_runtime_minutes;
       $s=$dbdata1->qc_date;
       $transform_flag=$dbdata1->transform_flag;
           $bb = date("d-m-Y", strtotime($b));
      
            if($transform_flag=='0'){
        
        $query = $this->db->query("SELECT * FROM coex_extrusion where machine_id='1' and shift_id='4' and `extrusion_date`='2023-05-19'" );
                $query->num_rows();
          
                if($query->num_rows()>0){

                    if($d==1 and $c==4){
                        $shift_id4++;
              
            $sleeve_weight_kg=$sleeve_weight_kg+$l;
            $rm_mixed_qty_kg=$rm_mixed_qty_kg+$m;
            $ok_qty_no=$ok_qty_no+$n;
            $scrap_weight_kg=$scrap_weight_kg+$o;
            $scrap_tube_no=$scrap_tube_no+$p;
            $expected_sleeve_prod=$n+$p;
            $sp_minutes = $n+$p/$q;
            $job_runtime_minutes=$job_runtime_minutes+$r;

                        $this->db2 = $this->load->database('another_db2', TRUE);
             
            $jobcard_qty['jqty']=$this->coex_extrusion_model->get_jobcard_qty($g,$f);
                foreach($jobcard_qty['jqty'] as $j){
                  $y=$j->actual_qty_manufactured/100;
                }
        
                        $dataa = array( 'ex_id'=>$newexid,
                    'date' =>$bb,
                    'shift_id'=>$d,
                    'plant_id'=>'3',
                    'machine_id'=>$c,
                    'process_id'=>'1',
                    'job_no'=>'JOB'.$count,
                    'psp_psm_no'=>$h,
                    'job_card_no'=>$f,
                    'so_no'=>$g,
                    'total_rm_kg'=>$m,
                    //'ttotal_rm_kg'=>$m,
                    'time'=>time(),
                    'expected_sleeve_prod'=>$expected_sleeve_prod,
                    'sp_minutes'=>$sp_minutes,
                    'job_order_quantity'=>$y,
                    'rp'=>$rp,
                    'wp'=>$rp,
                    'operator_id'=>$operator,
                    //'downminutesbysystem'=> 480 - $r,
                    'sleeve_weight_kg'=>$sleeve_weight_kg,
                    'sleeve_to_header'=>$n,
                    'sleeve_waste_kg'=>$o,
                    'sleeve_waste_no'=>$p,
                    'minutes'=>$r,
                                    );
                        $count++;
                        $data['db2data']=$this->common_model->save_db2('extrusion',$dataa);
                    }
            }
            }
        }
    
        if($transform_flag=='0'){
      
      $query = $this->db->query("SELECT * FROM coex_extrusion where machine_id='1' and shift_id='4' and `extrusion_date`='2023-05-19'" );
            $query->num_rows();
          
            if($query->num_rows()>0){

                if($shift_id4<7){
                    $z=5;

                    for ($x = $shift_id4; $x <= $z; $x++) {
              $a=' ';
              $y=$x+1;

                        $dataa = array('ex_id'=>$newexid,
                     'date' =>' ',
                     'shift_id'=>' ',
                     'machine_id'=>' ',
                     'job_no'=>'JOB'.$y,
                     'job_card_no'=>' ',
                     'so_no'=>' ',
                     'operator_id'=>' ',
                     'shift_id'=>$d,
                     'plant_id'=>'3',
                     'machine_id'=>$c,
                     'process_id'=>'1'
                  );

                        $data['db2data']=$this->common_model->save_db2('extrusion',$dataa);

                    }            
        }else{
           'contect to erp team';
        }
                $dataa = array( 'ex_id'=>$newexid,
                'job_no'=>'TOTAL',
                //'sleeve_weight_kg' =>$sleeve_weight_kg,
                'total_rm_kg'=>$m,
                'sleeve_to_header' =>$ok_qty_no,
                'sleeve_waste_kg' =>$scrap_weight_kg,
                'sleeve_waste_no' =>$scrap_tube_no,
                'minutes' =>$job_runtime_minutes,
                'downminutesbysystem'=> 480 - $r,
                'rp'=>$rp,
                'wp'=>$rp,
                'shift_id'=>$d,
                'plant_id'=>'3',
                'machine_id'=>$c,
                'process_id'=>'1'
                            );

                $data['db2data']=$this->common_model->save_db2('extrusion',$dataa);
            }
    }
      
    $dates='2023-05-19';
        $data_update=array(
            'transform_flag'=> '1'
        );
              
        $result=$this->common_model->update_one_active_record_where_where('coex_extrusion',$data_update,'extrusion_date',$dates, 'machine_id', '1', 'shift_id','4',$this->session->userdata['logged_in']['company_id']);



//******************************************//

        $data['dbdata']=$this->common_model->select_db1_record();
        $this->db2 = $this->load->database('another_db2', TRUE);
    $exidrow=$this->coex_extrusion_model->get_extrusion_('extrusion');
    $lastexid=$exidrow['maxexid'];
    $newexid=$lastexid+1;

    $count = 1;
    $sleeve_weight_kg=0;
    $rm_mixed_qty_kg=0;
    $ok_qty_no=0;
    $scrap_weight_kg=0;
    $scrap_tube_no=0;
    $cutting_speed_minutes=0;
    $job_runtime_minutes=0;
    $shift_id5=0;
    $transform_flag='';

        foreach($data['dbdata'] as $dbdata1){
      $a=$dbdata1->ce_id;
      $b=$dbdata1->extrusion_date;
      $c=$dbdata1->machine_id;
      $d=$dbdata1->shift_id;
      $e=$dbdata1->user_id;
      $f=$dbdata1->jobcard_no;
      $g=$dbdata1->order_no;
      $h=$dbdata1->article_no;
      $i=$dbdata1->diameter;
      $j=$dbdata1->length;
      $k=$dbdata1->layer_no;
      $l=$dbdata1->sleeve_weight_kg;
      $m=$dbdata1->rm_mixed_qty_kg;
      $n=$dbdata1->ok_qty_no;
      $o=$dbdata1->scrap_weight_kg;
      $p=$dbdata1->scrap_tube_no;
      $q=$dbdata1->cutting_speed_minutes;
      $r=$dbdata1->job_runtime_minutes;
      $s=$dbdata1->qc_date;
      $transform_flag=$dbdata1->transform_flag;
            $bb = date("d-m-Y", strtotime($b));
      
            if($transform_flag=='0'){
        
        $query = $this->db->query("SELECT * FROM coex_extrusion where machine_id='2' and shift_id='1' and `extrusion_date`='2023-05-19'" );          
        $query->num_rows();
          
        if($query->num_rows()>0){
                    if($d==2 and $c==1){
                        $shift_id5++;

            $sleeve_weight_kg=$sleeve_weight_kg+$l;
            $rm_mixed_qty_kg=$rm_mixed_qty_kg+$m;
            $ok_qty_no=$ok_qty_no+$n;
            $scrap_weight_kg=$scrap_weight_kg+$o;
            $scrap_tube_no=$scrap_tube_no+$p;
            $expected_sleeve_prod=$n+$p;
            $sp_minutes = $n+$p/$q;
            $job_runtime_minutes=$job_runtime_minutes+$r;

                        $this->db2 = $this->load->database('another_db2', TRUE);
             
            $jobcard_qty['jqty']=$this->coex_extrusion_model->get_jobcard_qty($g,$f);
              foreach($jobcard_qty['jqty'] as $j){
                  $y=$j->actual_qty_manufactured/100;
                }
        
            $dataa = array( 'ex_id'=>$newexid,
                    'date' =>$bb,
                    'shift_id'=>$d,
                    'plant_id'=>'3',
                    'machine_id'=>$c,
                    'process_id'=>'1',
                    'job_no'=>'JOB'.$count,
                    'psp_psm_no'=>$h,
                    'job_card_no'=>$f,
                    'so_no'=>$g,
                    'total_rm_kg'=>$m,
                    //'ttotal_rm_kg'=>$m,
                    'time'=>time(),
                    'expected_sleeve_prod'=>$expected_sleeve_prod,
                      'sp_minutes'=>$sp_minutes,
                    'job_order_quantity'=>$y,
                    'rp'=>$rp,
                    'wp'=>$rp,
                    'operator_id'=>$operator,
                    //'downminutesbysystem'=> 480 - $r,
                    'sleeve_weight_kg'=>$sleeve_weight_kg,
                    'sleeve_to_header'=>$n,
                    'sleeve_waste_kg'=>$o,
                    'sleeve_waste_no'=>$p,
                    'minutes'=>$r,
                      );
            $count++;
            $data['db2data']=$this->common_model->save_db2('extrusion',$dataa);
          }
        }
      }
        }

        if($transform_flag=='0'){
       $query = $this->db->query("SELECT * FROM coex_extrusion where machine_id='2' and shift_id='1' and `extrusion_date`='2023-05-19'" );
            $query->num_rows();
          
      if($query->num_rows()>0){
            
        if($shift_id5<7){
          $z=5;

                    for ($x = $shift_id5; $x <= $z; $x++) {
             $a=' ';
             $y=$x+1;

                        $dataa = array('ex_id'=>$newexid,
                     'date' =>' ',
                     'shift_id'=>' ',
                     'machine_id'=>' ',
                     'job_no'=>'JOB'.$y,
                     'job_card_no'=>' ',
                     'so_no'=>' ',
                     'operator_id'=>' ',
                     'shift_id'=>$d,
                     'plant_id'=>'3',
                     'machine_id'=>$c,
                     'process_id'=>'1'
                  );

                        $data['db2data']=$this->common_model->save_db2('extrusion',$dataa);
                    }            
        }else{
           'contect to erp team';
        }
         
                $dataa = array( 'ex_id'=>$newexid,
                'job_no'=>'TOTAL',
                //'sleeve_weight_kg' =>$sleeve_weight_kg,
                'total_rm_kg'=>$m,
                'sleeve_to_header' =>$ok_qty_no,
                'sleeve_waste_kg' =>$scrap_weight_kg,
                'sleeve_waste_no' =>$scrap_tube_no,
                'minutes' =>$job_runtime_minutes,
                'downminutesbysystem'=> 480 - $r,
                               'rp'=>$rp,
                               'wp'=>$rp,
                'shift_id'=>$d,
                'plant_id'=>'3',
                'machine_id'=>$c,
                'process_id'=>'1'
                            );

                $data['db2data']=$this->common_model->save_db2('extrusion',$dataa);
            }
    }
      
    $dates='2023-05-19';
        $data_update=array(
            'transform_flag'=> '1'
        );
              
        $result=$this->common_model->update_one_active_record_where_where('coex_extrusion',$data_update,'extrusion_date',$dates, 'machine_id', '2', 'shift_id','1',$this->session->userdata['logged_in']['company_id']);

//***********************************//

    $data['dbdata']=$this->common_model->select_db1_record();
    $this->db2 = $this->load->database('another_db2', TRUE);
      $exidrow=$this->coex_extrusion_model->get_extrusion_('extrusion');
      $lastexid=$exidrow['maxexid'];
    $newexid=$lastexid+1;

    $count = 1;
    $sleeve_weight_kg=0;
    $rm_mixed_qty_kg=0;
    $ok_qty_no=0;
    $scrap_weight_kg=0;
    $scrap_tube_no=0;
    $cutting_speed_minutes=0;
    $job_runtime_minutes=0;
    $shift_id6=0;
    $transform_flag='';
   
        foreach($data['dbdata'] as $dbdata1){
       $a=$dbdata1->ce_id;
       $b=$dbdata1->extrusion_date;
       $c=$dbdata1->machine_id;
       $d=$dbdata1->shift_id;
       $e=$dbdata1->user_id;
       $f=$dbdata1->jobcard_no;
       $g=$dbdata1->order_no;
       $h=$dbdata1->article_no;
       $i=$dbdata1->diameter;
       $j=$dbdata1->length;
       $k=$dbdata1->layer_no;
       $l=$dbdata1->sleeve_weight_kg;
       $m=$dbdata1->rm_mixed_qty_kg;
       $n=$dbdata1->ok_qty_no;
       $o=$dbdata1->scrap_weight_kg;
       $p=$dbdata1->scrap_tube_no;
       $q=$dbdata1->cutting_speed_minutes;
       $r=$dbdata1->job_runtime_minutes;
       $s=$dbdata1->qc_date;
       $transform_flag=$dbdata1->transform_flag;
           $bb = date("d-m-Y", strtotime($b));

            if($transform_flag=='0'){
        
        $query = $this->db->query("SELECT * FROM coex_extrusion where machine_id='2' and shift_id='2' and `extrusion_date`='2023-05-19'" );
                $query->num_rows();
          
                if($query->num_rows()>0){
                    if($d==2 and $c==2){
                        $shift_id6++;
            
            $sleeve_weight_kg=$sleeve_weight_kg+$l;
            $rm_mixed_qty_kg=$rm_mixed_qty_kg+$m;
            $ok_qty_no=$ok_qty_no+$n;
            $scrap_weight_kg=$scrap_weight_kg+$o;
            $scrap_tube_no=$scrap_tube_no+$p;
            $expected_sleeve_prod=$n+$p;
            $sp_minutes = $n+$p/$q;            
            $job_runtime_minutes=$job_runtime_minutes+$r;

            $this->db2 = $this->load->database('another_db2', TRUE);
              
            $jobcard_qty['jqty']=$this->coex_extrusion_model->get_jobcard_qty($g,$f);
              foreach($jobcard_qty['jqty'] as $j){
                $y=$j->actual_qty_manufactured/100;
              }
        
            $dataa = array( 'ex_id'=>$newexid,
                    'date' =>$bb,
                    'shift_id'=>$d,
                    'plant_id'=>'3',
                    'machine_id'=>$c,
                    'process_id'=>'1',
                    'job_no'=>'JOB'.$count,
                    'psp_psm_no'=>$h,
                    'job_card_no'=>$f,
                    'so_no'=>$g,
                    'total_rm_kg'=>$m,
                    //'ttotal_rm_kg'=>$m,
                    'time'=>time(),
                    'expected_sleeve_prod'=>$expected_sleeve_prod,
                    'sp_minutes'=>$sp_minutes,
                    'job_order_quantity'=>$y,
                    'rp'=>$rp,
                    'wp'=>$rp,
                    'operator_id'=>$operator,
                    //'downminutesbysystem'=> 480 - $r,
                    'sleeve_weight_kg'=>$sleeve_weight_kg,
                    'sleeve_to_header'=>$n,
                    'sleeve_waste_kg'=>$o,
                    'sleeve_waste_no'=>$p,
                    'minutes'=>$r,  
                                    );
            $count++;
            $data['db2data']=$this->common_model->save_db2('extrusion',$dataa);
                    }
            }
            }
        }
      
        if($transform_flag=='0'){
      $query = $this->db->query("SELECT * FROM coex_extrusion where machine_id='2' and shift_id='2' and `extrusion_date`='2023-05-19'" );
            $query->num_rows();
          
            if($query->num_rows()>0){
      
                if($shift_id6<7){
                    $z=5;

                    for ($x = $shift_id6; $x <= $z; $x++) {
             $a=' ';
             $y=$x+1;

                        $dataa = array('ex_id'=>$newexid,
                     'date' =>' ',
                     'shift_id'=>' ',
                     'machine_id'=>' ',
                     'job_no'=>'JOB'.$y,
                     'job_card_no'=>' ',
                     'so_no'=>' ',
                     'operator_id'=>' ',
                     'shift_id'=>$d,
                     'plant_id'=>'3',
                     'machine_id'=>$c,
                     'process_id'=>'1'
                  );

                        $data['db2data']=$this->common_model->save_db2('extrusion',$dataa);
                    }
        }else{
           'contect to erp team';
        }
         
                $dataa = array('ex_id'=>$newexid,
                'job_no'=>'TOTAL',
                //'sleeve_weight_kg' =>$sleeve_weight_kg,
                'total_rm_kg'=>$m,
                'sleeve_to_header' =>$ok_qty_no,
                'sleeve_waste_kg' =>$scrap_weight_kg,
                'sleeve_waste_no' =>$scrap_tube_no,
                'minutes' =>$job_runtime_minutes,
                'downminutesbysystem'=> 480 - $r,
                               'rp'=>$rp,
                               'wp'=>$rp,
                'shift_id'=>$d,
                'plant_id'=>'3',
                'machine_id'=>$c,
                'process_id'=>'1'
                            );

                $data['db2data']=$this->common_model->save_db2('extrusion',$dataa);
            }
    }
      
    $dates='2023-05-19';
        $data_update=array(
            'transform_flag'=> '1'
        );
              
        $result=$this->common_model->update_one_active_record_where_where('coex_extrusion',$data_update,'extrusion_date',$dates, 'machine_id', '2', 'shift_id','2',$this->session->userdata['logged_in']['company_id']);

//**********************************//

      $data['dbdata']=$this->common_model->select_db1_record();
    $this->db2 = $this->load->database('another_db2', TRUE);
    $exidrow=$this->coex_extrusion_model->get_extrusion_('extrusion');
    $lastexid=$exidrow['maxexid'];
    $newexid=$lastexid+1;

    $count = 1;
    $sleeve_weight_kg=0;
    $rm_mixed_qty_kg=0;
    $ok_qty_no=0;
    $scrap_weight_kg=0;
    $scrap_tube_no=0;
    $cutting_speed_minutes=0;
    $job_runtime_minutes=0;
    $shift_id7=0;
    $transform_flag='';
  
        foreach($data['dbdata'] as $dbdata1){
       $a=$dbdata1->ce_id;
       $b=$dbdata1->extrusion_date;
       $c=$dbdata1->machine_id;
       $d=$dbdata1->shift_id;
       $e=$dbdata1->user_id;
       $f=$dbdata1->jobcard_no;
       $g=$dbdata1->order_no;
       $h=$dbdata1->article_no;
       $i=$dbdata1->diameter;
       $j=$dbdata1->length;
       $k=$dbdata1->layer_no;
       $l=$dbdata1->sleeve_weight_kg;
       $m=$dbdata1->rm_mixed_qty_kg;
       $n=$dbdata1->ok_qty_no;
       $o=$dbdata1->scrap_weight_kg;
       $p=$dbdata1->scrap_tube_no;
       $q=$dbdata1->cutting_speed_minutes;
       $r=$dbdata1->job_runtime_minutes;
       $s=$dbdata1->qc_date;
       $transform_flag=$dbdata1->transform_flag;
           $bb = date("d-m-Y", strtotime($b));
      
            if($transform_flag=='0') {
      
        $query = $this->db->query("SELECT * FROM coex_extrusion where machine_id='2' and shift_id='3' and `extrusion_date`='2023-05-19'" );
                $query->num_rows();
          
                if($query->num_rows()>0){
                    if($d==2 and $c==3){
                        $shift_id7++;

            $sleeve_weight_kg=$sleeve_weight_kg+$l;
            $rm_mixed_qty_kg=$rm_mixed_qty_kg+$m;
            $ok_qty_no=$ok_qty_no+$n;
            $scrap_weight_kg=$scrap_weight_kg+$o;
            $scrap_tube_no=$scrap_tube_no+$p;
            $expected_sleeve_prod=$n+$p;
                $sp_minutes = $n+$p/$q;
                        $job_runtime_minutes=$job_runtime_minutes+$r;

                        $this->db2 = $this->load->database('another_db2', TRUE);
             
                        $jobcard_qty['jqty']=$this->coex_extrusion_model->get_jobcard_qty($g,$f);
              foreach($jobcard_qty['jqty'] as $j){
                $y=$j->actual_qty_manufactured/100;
                            }
        
                        $dataa = array( 'ex_id'=>$newexid,
                    'date' =>$bb,
                    'shift_id'=>$d,
                    'plant_id'=>'3',
                    'machine_id'=>$c,
                    'process_id'=>'1',
                    'job_no'=>'JOB'.$count,
                    'psp_psm_no'=>$h,
                    'job_card_no'=>$f,
                    'so_no'=>$g,
                    'total_rm_kg'=>$m,
                    //'ttotal_rm_kg'=>$m,
                    'time'=>time(),
                    'expected_sleeve_prod'=>$expected_sleeve_prod,
                    'sp_minutes'=>$sp_minutes,
                    'job_order_quantity'=>$y,
                    'rp'=>$rp,
                    'wp'=>$rp,
                    'operator_id'=>$operator,
                    //'downminutesbysystem'=> 480 - $r,
                    'sleeve_weight_kg'=>$sleeve_weight_kg,
                    'sleeve_to_header'=>$n,
                    'sleeve_waste_kg'=>$o,
                    'sleeve_waste_no'=>$p,
                    'minutes'=>$r,
                                    );
                        $count++;
                        $data['db2data']=$this->common_model->save_db2('extrusion',$dataa);
                    }
            }
            }
        }
    
        if($transform_flag=='0'){

           $query = $this->db->query("SELECT * FROM coex_extrusion where machine_id='2' and shift_id='3' and `extrusion_date`='2023-05-19'" );
            $query->num_rows();
          
            if($query->num_rows()>0){
            
        if($shift_id7<7){
                    $z=5;

                    for ($x = $shift_id7; $x <= $z; $x++) {
             $a=' ';
             $y=$x+1;

                        $dataa = array('ex_id'=>$newexid,
                     'date' =>' ',
                     'shift_id'=>' ',
                     'machine_id'=>' ',
                     'job_no'=>'JOB'.$y,
                     'job_card_no'=>' ',
                     'so_no'=>' ',
                     'operator_id'=>' ',
                     'shift_id'=>$d,
                     'plant_id'=>'3',
                     'machine_id'=>$c,
                     'process_id'=>'1'
                  );

                        $data['db2data']=$this->common_model->save_db2('extrusion',$dataa);
                    }            
                }else{
                    'contect to erp team';
                }
       
                $dataa = array( 'ex_id'=>$newexid,
                'job_no'=>'TOTAL',
                //'sleeve_weight_kg' =>$sleeve_weight_kg,
                'total_rm_kg'=>$m,
                'sleeve_to_header' =>$ok_qty_no,
                'sleeve_waste_kg' =>$scrap_weight_kg,
                'sleeve_waste_no' =>$scrap_tube_no,
                'minutes' =>$job_runtime_minutes,
                'downminutesbysystem'=> 480 - $r,
                               'rp'=>$rp,
                               'wp'=>$rp,
                'shift_id'=>$d,
                'plant_id'=>'3',
                'machine_id'=>$c,
                'process_id'=>'1'
                            );

                $data['db2data']=$this->common_model->save_db2('extrusion',$dataa);
            }
    }
      
    $dates='2023-05-19';
        $data_update=array(
            'transform_flag'=> '1'
        );
              
        $result=$this->common_model->update_one_active_record_where_where('coex_extrusion',$data_update,'extrusion_date',$dates, 'machine_id', '2', 'shift_id','3',$this->session->userdata['logged_in']['company_id']);

//*********************************//

        $data['dbdata']=$this->common_model->select_db1_record();
        $this->db2 = $this->load->database('another_db2', TRUE);
        $exidrow=$this->coex_extrusion_model->get_extrusion_('extrusion');
        $lastexid=$exidrow['maxexid'];
        $newexid=$lastexid+1;

    $count = 1;
    $sleeve_weight_kg=0;
    $rm_mixed_qty_kg=0;
    $ok_qty_no=0;
    $scrap_weight_kg=0;
    $scrap_tube_no=0;
    $cutting_speed_minutes=0;
    $job_runtime_minutes=0;
    $shift_id8=0;
    $transform_flag='';
 
        foreach($data['dbdata'] as $dbdata1){
        $a=$dbdata1->ce_id;
        $b=$dbdata1->extrusion_date;
        $c=$dbdata1->machine_id;
        $d=$dbdata1->shift_id;
        $e=$dbdata1->user_id;
        $f=$dbdata1->jobcard_no;
        $g=$dbdata1->order_no;
        $h=$dbdata1->article_no;
        $i=$dbdata1->diameter;
        $j=$dbdata1->length;
        $k=$dbdata1->layer_no;
        $l=$dbdata1->sleeve_weight_kg;
        $m=$dbdata1->rm_mixed_qty_kg;
        $n=$dbdata1->ok_qty_no;
        $o=$dbdata1->scrap_weight_kg;
        $p=$dbdata1->scrap_tube_no;
        $q=$dbdata1->cutting_speed_minutes;
        $r=$dbdata1->job_runtime_minutes;
        $s=$dbdata1->qc_date;
        $transform_flag=$dbdata1->transform_flag;
            $bb = date("d-m-Y", strtotime($b));
      
            if($transform_flag=='0'){
                $query = $this->db->query("SELECT * FROM coex_extrusion where machine_id='2' and shift_id='4' and `extrusion_date`='2023-05-19'" );
                $query->num_rows();
          
                if($query->num_rows()>0){

                    if($d==2 and $c==4){
                        $shift_id8++;

            $sleeve_weight_kg=$sleeve_weight_kg+$l;
            $rm_mixed_qty_kg=$rm_mixed_qty_kg+$m;
            $ok_qty_no=$ok_qty_no+$n;
            $scrap_weight_kg=$scrap_weight_kg+$o;
            $scrap_tube_no=$scrap_tube_no+$p;
            $expected_sleeve_prod=$n+$p;
                $sp_minutes = $n+$p/$q;
            $job_runtime_minutes=$job_runtime_minutes+$r;

                        $this->db2 = $this->load->database('another_db2', TRUE);
             
              $jobcard_qty['jqty']=$this->coex_extrusion_model->get_jobcard_qty($g,$f);
              foreach($jobcard_qty['jqty'] as $j){
                $y=$j->actual_qty_manufactured/100;
                }
        
                        $dataa = array('ex_id'=>$newexid,
                     'date' =>$bb,
                     'shift_id'=>$d,
                     'plant_id'=>'3',
                     'machine_id'=>$c,
                     'process_id'=>'1',
                     'job_no'=>'JOB'.$count,
                     'psp_psm_no'=>$h,
                     'job_card_no'=>$f,
                     'so_no'=>$g,
                     'total_rm_kg'=>$m,
                     //'ttotal_rm_kg'=>$m,
                     'time'=>time(),
                     'expected_sleeve_prod'=>$expected_sleeve_prod,
                     'sp_minutes'=>$sp_minutes,
                     'job_order_quantity'=>$y,
                     'rp'=>$rp,
                     'wp'=>$rp,
                     'operator_id'=>$operator,
                     //'downminutesbysystem'=> 480 - $r,
                     'sleeve_weight_kg'=>$sleeve_weight_kg,
                     'sleeve_to_header'=>$n,
                     'sleeve_waste_kg'=>$o,
                     'sleeve_waste_no'=>$p,
                     'minutes'=>$r,
                                    );
                        $count++;
                        $data['db2data']=$this->common_model->save_db2('extrusion',$dataa);
                    }
            }
            }
        }
    
        if($transform_flag=='0'){

            $query = $this->db->query("SELECT * FROM coex_extrusion where machine_id='2' and shift_id='4' and `extrusion_date`='2023-05-19'" );
            $query->num_rows();
          
            if($query->num_rows()>0){
            
                if($shift_id8<7){
                    $z=5;

                    for ($x = $shift_id8; $x <= $z; $x++) {
             $a=' ';
             $y=$x+1;

            $dataa = array('ex_id'=>$newexid,
                     'date' =>' ',
                     'shift_id'=>' ',
                     'machine_id'=>' ',
                     'job_no'=>'JOB'.$y,
                     'job_card_no'=>' ',
                     'so_no'=>' ',
                     'operator_id'=>' ',
                     'shift_id'=>$d,
                     'plant_id'=>'3',
                     'machine_id'=>$c,
                     'process_id'=>'1'
                                    );

            $data['db2data']=$this->common_model->save_db2('extrusion',$dataa);
          }
        }else{
           'contect to erp team';
        }
        
                $dataa = array( 'ex_id'=>$newexid,
                'job_no'=>'TOTAL',
                //'sleeve_weight_kg' =>$sleeve_weight_kg,
                'total_rm_kg'=>$m,
                'sleeve_to_header' =>$ok_qty_no,
                'sleeve_waste_kg' =>$scrap_weight_kg,
                'sleeve_waste_no' =>$scrap_tube_no,
                'minutes' =>$job_runtime_minutes,
                'downminutesbysystem'=> 480 - $r,
                               'rp'=>$rp,
                               'wp'=>$rp,
                'shift_id'=>$d,
                'plant_id'=>'3',
                'machine_id'=>$c,
                'process_id'=>'1'
                            );
                $data['db2data']=$this->common_model->save_db2('extrusion',$dataa);
            }
    }
      
    $dates='2023-05-19';
        $data_update=array(
            'transform_flag'=> '1'
        );
              
        $result=$this->common_model->update_one_active_record_where_where('coex_extrusion',$data_update,'extrusion_date',$dates, 'machine_id', '2', 'shift_id','4',$this->session->userdata['logged_in']['company_id']);

//*********************************//

        $data['dbdata']=$this->common_model->select_db1_record();
        $this->db2 = $this->load->database('another_db2', TRUE);
        $exidrow=$this->coex_extrusion_model->get_extrusion_('extrusion');
        $lastexid=$exidrow['maxexid'];
        $newexid=$lastexid+1;

     $count = 1;
     $sleeve_weight_kg=0;
     $rm_mixed_qty_kg=0;
     $ok_qty_no=0;
     $scrap_weight_kg=0;
     $scrap_tube_no=0;
     $cutting_speed_minutes=0;
     $job_runtime_minutes=0;
     $shift_id9=0;
     $transform_flag='';  
            
        foreach($data['dbdata'] as $dbdata1){
               $a=$dbdata1->ce_id;
               $b=$dbdata1->extrusion_date;
               $c=$dbdata1->machine_id;
               $d=$dbdata1->shift_id;
               $e=$dbdata1->user_id;
               $f=$dbdata1->jobcard_no;
               $g=$dbdata1->order_no;
               $h=$dbdata1->article_no;
               $i=$dbdata1->diameter;
               $j=$dbdata1->length;
               $k=$dbdata1->layer_no;
               $l=$dbdata1->sleeve_weight_kg;
               $m=$dbdata1->rm_mixed_qty_kg;
               $n=$dbdata1->ok_qty_no;
               $o=$dbdata1->scrap_weight_kg;
               $p=$dbdata1->scrap_tube_no;
               $q=$dbdata1->cutting_speed_minutes;
               $r=$dbdata1->job_runtime_minutes;
               $s=$dbdata1->qc_date;
               $transform_flag=$dbdata1->transform_flag;
               $bb = date("d-m-Y", strtotime($b));
      
            if($transform_flag=='0'){

                $query = $this->db->query("SELECT * FROM coex_extrusion where machine_id='3' and shift_id='1' and `extrusion_date`='2023-05-19'" );
                $query->num_rows();
          
                if($query->num_rows()>0){
      
                    if($d==3 and $c==1){
                        $shift_id9++;
      
            $sleeve_weight_kg=$sleeve_weight_kg+$l;
            $rm_mixed_qty_kg=$rm_mixed_qty_kg+$m;
            $ok_qty_no=$ok_qty_no+$n;
            $scrap_weight_kg=$scrap_weight_kg+$o;
            $scrap_tube_no=$scrap_tube_no+$p;
            $expected_sleeve_prod=$n+$p;
                $sp_minutes = $n+$p/$q;
            $job_runtime_minutes=$job_runtime_minutes+$r;
            $this->db2 = $this->load->database('another_db2', TRUE);
             
              $jobcard_qty['jqty']=$this->coex_extrusion_model->get_jobcard_qty($g,$f);
              foreach($jobcard_qty['jqty'] as $j){
                $y=$j->actual_qty_manufactured/100;
              }
        
                        $dataa = array( 'ex_id'=>$newexid,
                    'date' =>$bb,
                    'shift_id'=>$d,
                    'plant_id'=>'3',
                    'machine_id'=>$c,
                    'process_id'=>'1',
                    'job_no'=>'JOB'.$count,
                    'psp_psm_no'=>$h,
                    'job_card_no'=>$f,
                    'so_no'=>$g,
                    'total_rm_kg'=>$m,
                    //'ttotal_rm_kg'=>$m,
                    'time'=>time(),
                    'expected_sleeve_prod'=>$expected_sleeve_prod,
                    'sp_minutes'=>$sp_minutes,
                    'job_order_quantity'=>$y,
                    'rp'=>$rp,
                    'wp'=>$rp,
                    'operator_id'=>$operator,
                    //'downminutesbysystem'=> 480 - $r,
                    'sleeve_weight_kg'=>$sleeve_weight_kg,
                    'sleeve_to_header'=>$n,
                    'sleeve_waste_kg'=>$o,
                    'sleeve_waste_no'=>$p,
                    'minutes'=>$r,
                                    );
            $count++;
            $data['db2data']=$this->common_model->save_db2('extrusion',$dataa);
                    }
            } 
            }
        }
        if($transform_flag=='0'){

            $query = $this->db->query("SELECT * FROM coex_extrusion where machine_id='3' and shift_id='1' and `extrusion_date`='2023-05-19'" );
            $query->num_rows();
          
            if($query->num_rows()>0){
            
                if($shift_id9<7){
                    $z=5;

                    for ($x = $shift_id9; $x <= $z; $x++) {
              $a=' ';
              $y=$x+1;

                        $dataa = array('ex_id'=>$newexid,
                     'date' =>' ',
                     'shift_id'=>' ',
                     'machine_id'=>' ',
                     'job_no'=>'JOB'.$y,
                     'job_card_no'=>' ',
                     'so_no'=>' ',
                     'operator_id'=>' ',
                     'shift_id'=>$d,
                     'plant_id'=>'3',
                     'machine_id'=>$c,
                     'process_id'=>'1'
                                    );

                        $data['db2data']=$this->common_model->save_db2('extrusion',$dataa);
                    }           
                }else{
                    'contect to erp team';
                }
        
                 $dataa = array('ex_id'=>$newexid,
                'job_no'=>'TOTAL',
                //'sleeve_weight_kg' =>$sleeve_weight_kg,
                'total_rm_kg'=>$m,
                'sleeve_to_header' =>$ok_qty_no,
                'sleeve_waste_kg' =>$scrap_weight_kg,
                'sleeve_waste_no' =>$scrap_tube_no,
                'minutes' =>$job_runtime_minutes,
                'downminutesbysystem'=> 480 - $r,
                               'rp'=>$rp,
                               'wp'=>$rp,
                'shift_id'=>$d,
                'plant_id'=>'3',
                'machine_id'=>$c,
                'process_id'=>'1'
                            );

                $data['db2data']=$this->common_model->save_db2('extrusion',$dataa);
            } 
    }


        $dates='2023-05-19';
        $data_update=array(
            'transform_flag'=> '1'
        );
              
        $result=$this->common_model->update_one_active_record_where_where('coex_extrusion',$data_update,'extrusion_date',$dates, 'machine_id', '3', 'shift_id','1',$this->session->userdata['logged_in']['company_id']);

//*********************************//

        $data['dbdata']=$this->common_model->select_db1_record();
        $this->db2 = $this->load->database('another_db2', TRUE);
        $exidrow=$this->coex_extrusion_model->get_extrusion_('extrusion');
        $lastexid=$exidrow['maxexid'];
        $newexid=$lastexid+1;

    $count =1;
    $sleeve_weight_kg=0;
    $rm_mixed_qty_kg=0;
    $ok_qty_no=0;
    $scrap_weight_kg=0;
    $scrap_tube_no=0;
    $cutting_speed_minutes=0;
    $job_runtime_minutes=0;
    $shift_id10=0;
    $transform_flag='';
  
        foreach($data['dbdata'] as $dbdata1){
               $a=$dbdata1->ce_id;
               $b=$dbdata1->extrusion_date;
               $c=$dbdata1->machine_id;
               $d=$dbdata1->shift_id;
               $e=$dbdata1->user_id;
               $f=$dbdata1->jobcard_no;
               $g=$dbdata1->order_no;
               $h=$dbdata1->article_no;
               $i=$dbdata1->diameter;
               $j=$dbdata1->length;
               $k=$dbdata1->layer_no;
               $l=$dbdata1->sleeve_weight_kg;
               $m=$dbdata1->rm_mixed_qty_kg;
               $n=$dbdata1->ok_qty_no;
               $o=$dbdata1->scrap_weight_kg;
               $p=$dbdata1->scrap_tube_no;
               $q=$dbdata1->cutting_speed_minutes;
               $r=$dbdata1->job_runtime_minutes;
               $s=$dbdata1->qc_date;
               $transform_flag=$dbdata1->transform_flag;
               $bb = date("d-m-Y", strtotime($b));
      
            if($transform_flag=='0'){
                $query = $this->db->query("SELECT * FROM coex_extrusion where machine_id='3' and shift_id='2' and `extrusion_date`='2023-05-19'" );
                $query->num_rows();
          
                if($query->num_rows()>0){

                    if($d==3 and $c==2){
                        $shift_id10++;

              $sleeve_weight_kg=$sleeve_weight_kg+$l;
              $rm_mixed_qty_kg=$rm_mixed_qty_kg+$m;
              $ok_qty_no=$ok_qty_no+$n;
              $scrap_weight_kg=$scrap_weight_kg+$o;
              $scrap_tube_no=$scrap_tube_no+$p;
              $expected_sleeve_prod=$n+$p;
                  $sp_minutes = $n+$p/$q;
              $job_runtime_minutes=$job_runtime_minutes+$r;

                            $this->db2 = $this->load->database('another_db2', TRUE);
             
                $jobcard_qty['jqty']=$this->coex_extrusion_model->get_jobcard_qty($g,$f);
                  foreach($jobcard_qty['jqty'] as $j){
                    $y=$j->actual_qty_manufactured/100;
                  }
        
                            $dataa = array( 'ex_id'=>$newexid,
                      'date' =>$bb,
                      'shift_id'=>$d,
                      'plant_id'=>'3',
                      'machine_id'=>$c,
                        'process_id'=>'1',
                      'job_no'=>'JOB'.$count,
                      'psp_psm_no'=>$h,
                      'job_card_no'=>$f,
                      'so_no'=>$g,
                      'total_rm_kg'=>$m,
                      //'ttotal_rm_kg'=>$m,
                      'time'=>time(),
                      'expected_sleeve_prod'=>$expected_sleeve_prod,
                      'sp_minutes'=>$sp_minutes,
                      'job_order_quantity'=>$y,
                      'rp'=>$rp,
                      'wp'=>$rp,
                      'operator_id'=>$operator,
                      ///'downminutesbysystem'=> 480 - $r,
                      'sleeve_weight_kg'=>$sleeve_weight_kg,
                      'sleeve_to_header'=>$n,
                      'sleeve_waste_kg'=>$o,
                      'sleeve_waste_no'=>$p,
                      'minutes'=>$r,
                                        );
                        $count++;
                        $data['db2data']=$this->common_model->save_db2('extrusion',$dataa);
                    }
            }
            }
        }
    
        if($transform_flag=='0'){

           $query = $this->db->query("SELECT * FROM coex_extrusion where machine_id='3' and shift_id='2' and `extrusion_date`='2023-05-19'" );
            $query->num_rows();
          
            if($query->num_rows()>0){
            
                if($shift_id10<7){
                    $z=5;

                    for ($x = $shift_id10; $x <= $z; $x++) {
            $a=' ';
            $y=$x+1;

                        $dataa = array('ex_id'=>$newexid,
                     'date' =>' ',
                     'shift_id'=>' ',
                     'machine_id'=>' ',
                     'job_no'=>'JOB'.$y,
                     'job_card_no'=>' ',
                     'so_no'=>' ',
                     'operator_id'=>' ',
                     'shift_id'=>$d,
                     'plant_id'=>'3',
                     'machine_id'=>$c,
                     'process_id'=>'1'
                  );

                        $data['db2data']=$this->common_model->save_db2('extrusion',$dataa);
                    }
                }else{
                    'contect to erp team';
                }
        
                $dataa = array('ex_id'=>$newexid,
                               'job_no'=>'TOTAL',
                               //'sleeve_weight_kg' =>$sleeve_weight_kg,
                               'total_rm_kg'=>$m,
                               'sleeve_to_header' =>$ok_qty_no,
                               'sleeve_waste_kg' =>$scrap_weight_kg,
                               'sleeve_waste_no' =>$scrap_tube_no,
                               'minutes' =>$job_runtime_minutes,
                               'downminutesbysystem'=> 480 - $r,
                               'rp'=>$rp,
                               'wp'=>$rp,
                               'shift_id'=>$d,
                               'plant_id'=>'3',
                               'machine_id'=>$c,
                               'process_id'=>'1'
                            );

                $data['db2data']=$this->common_model->save_db2('extrusion',$dataa);
            }
    }
      
    $dates='2023-05-19';
        $data_update=array(
            'transform_flag'=> '1'
        );
              
        $result=$this->common_model->update_one_active_record_where_where('coex_extrusion',$data_update,'extrusion_date',$dates, 'machine_id', '3', 'shift_id','2',$this->session->userdata['logged_in']['company_id']);

//*********************************//

        $data['dbdata']=$this->common_model->select_db1_record();
        $this->db2 = $this->load->database('another_db2', TRUE);
        $exidrow=$this->coex_extrusion_model->get_extrusion_('extrusion');
        $lastexid=$exidrow['maxexid'];
        $newexid=$lastexid+1;

    $count = 1;
    $sleeve_weight_kg=0;
    $rm_mixed_qty_kg=0;
    $ok_qty_no=0;
    $scrap_weight_kg=0;
    $scrap_tube_no=0;
    $cutting_speed_minutes=0;
    $job_runtime_minutes=0;
    $shift_id11=0;
    $transform_flag='';
            
            foreach($data['dbdata'] as $dbdata1){
               $a=$dbdata1->ce_id;
               $b=$dbdata1->extrusion_date;
               $c=$dbdata1->machine_id;
               $d=$dbdata1->shift_id;
               $e=$dbdata1->user_id;
               $f=$dbdata1->jobcard_no;
               $g=$dbdata1->order_no;
               $h=$dbdata1->article_no;
               $i=$dbdata1->diameter;
               $j=$dbdata1->length;
               $k=$dbdata1->layer_no;
               $l=$dbdata1->sleeve_weight_kg;
               $m=$dbdata1->rm_mixed_qty_kg;
               $n=$dbdata1->ok_qty_no;
               $o=$dbdata1->scrap_weight_kg;
               $p=$dbdata1->scrap_tube_no;
               $q=$dbdata1->cutting_speed_minutes;
               $r=$dbdata1->job_runtime_minutes;
               $s=$dbdata1->qc_date;
               $transform_flag=$dbdata1->transform_flag;

               $bb = date("d-m-Y", strtotime($b));
                if($transform_flag=='0'){
         
          $query = $this->db->query("SELECT * FROM coex_extrusion where machine_id='3' and shift_id='3' and `extrusion_date`='2023-05-19'" );
            $query->num_rows();
          
                    if($query->num_rows()>0){

                        if($d==3 and $c==3){
                            $shift_id11++;

              $sleeve_weight_kg=$sleeve_weight_kg+$l;
              $rm_mixed_qty_kg=$rm_mixed_qty_kg+$m;
              $ok_qty_no=$ok_qty_no+$n;
              $scrap_weight_kg=$scrap_weight_kg+$o;
              $scrap_tube_no=$scrap_tube_no+$p;
              $expected_sleeve_prod=$n+$p;
                  $sp_minutes = $n+$p/$q;
              $job_runtime_minutes=$job_runtime_minutes+$r;

                            $this->db2 = $this->load->database('another_db2', TRUE);
             
                $jobcard_qty['jqty']=$this->coex_extrusion_model->get_jobcard_qty($g,$f);
                foreach($jobcard_qty['jqty'] as $j){
                  $y=$j->actual_qty_manufactured/100;
                }
        
                            $dataa = array('ex_id'=>$newexid,
                       'date' =>$bb,
                       'shift_id'=>$d,
                       'plant_id'=>'3',
                       'machine_id'=>$c,
                       'process_id'=>'1',
                       'job_no'=>'JOB'.$count,
                       'psp_psm_no'=>$h,
                       'job_card_no'=>$f,
                       'so_no'=>$g,
                       'total_rm_kg'=>$m,
                       //'ttotal_rm_kg'=>$m,
                       'time'=>time(),
                       'expected_sleeve_prod'=>$expected_sleeve_prod,
                       'sp_minutes'=>$sp_minutes,
                       'job_order_quantity'=>$y,
                       'rp'=>$rp,
                       'wp'=>$rp,
                       'operator_id'=>$operator,
                       //'downminutesbysystem'=> 480 - $r,
                       'sleeve_weight_kg'=>$sleeve_weight_kg,
                       'sleeve_to_header'=>$n,
                       'sleeve_waste_kg'=>$o,
                       'sleeve_waste_no'=>$p,
                       'minutes'=>$r,
                                        );
              $count++;
              $data['db2data']=$this->common_model->save_db2('extrusion',$dataa);
                        }
                }
                }
            }
      
            if($transform_flag=='0'){
      
        $query = $this->db->query("SELECT * FROM coex_extrusion where machine_id='3' and shift_id='3' and `extrusion_date`='2023-05-19'" );
        $query->num_rows();
          
                if($query->num_rows()>0){

                    if($shift_id11<7){
                        $z=5;

                            for ($x = $shift_id11; $x <= $z; $x++) {
                $a=' ';
                $y=$x+1;

                            $dataa = array('ex_id'=>$newexid,
                       'date' =>' ',
                       'shift_id'=>' ',
                       'machine_id'=>' ',
                       'job_no'=>'JOB'.$y,
                       'job_card_no'=>' ',
                       'so_no'=>' ',
                       'operator_id'=>' ',
                       'shift_id'=>$d,
                       'plant_id'=>'3',
                       'machine_id'=>$c,
                       'process_id'=>'1'
                    );

                            $data['db2data']=$this->common_model->save_db2('extrusion',$dataa);
                        }
                    }else{
             'contect to erp team';
          }
          
                    $dataa = array('ex_id'=>$newexid,
                  'job_no'=>'TOTAL',
                  //'sleeve_weight_kg' =>$sleeve_weight_kg,
                  'total_rm_kg'=>$m,
                  'sleeve_to_header' =>$ok_qty_no,
                  'sleeve_waste_kg' =>$scrap_weight_kg,
                  'sleeve_waste_no' =>$scrap_tube_no,
                  'minutes' =>$job_runtime_minutes,
                  'downminutesbysystem'=> 480 - $r,
                               'rp'=>$rp,
                               'wp'=>$rp,
                  'shift_id'=>$d,
                  'plant_id'=>'3',
                  'machine_id'=>$c,
                  'process_id'=>'1'
                                );

                    $data['db2data']=$this->common_model->save_db2('extrusion',$dataa); 
                }
        }
      
    $dates='2023-05-19';
        $data_update=array(
            'transform_flag'=> '1'
        );
              
        $result=$this->common_model->update_one_active_record_where_where('coex_extrusion',$data_update,'extrusion_date',$dates, 'machine_id', '3', 'shift_id','3',$this->session->userdata['logged_in']['company_id']);



 //*********************************//

    $data['dbdata']=$this->common_model->select_db1_record();
    $this->db2 = $this->load->database('another_db2', TRUE);
    $exidrow=$this->coex_extrusion_model->get_extrusion_('extrusion');
    $lastexid=$exidrow['maxexid'];
    $newexid=$lastexid+1;
    
    $count = 1;
    $sleeve_weight_kg=0;
    $rm_mixed_qty_kg=0;
    $ok_qty_no=0;
    $scrap_weight_kg=0;
    $scrap_tube_no=0;
    $cutting_speed_minutes=0;
    $job_runtime_minutes=0;
    $shift_id12=0;
    $transform_flag='';

            foreach($data['dbdata'] as $dbdata1){
                $a=$dbdata1->ce_id;
                $b=$dbdata1->extrusion_date;
                $c=$dbdata1->machine_id;
                $d=$dbdata1->shift_id;
                $e=$dbdata1->user_id;
                $f=$dbdata1->jobcard_no;
                $g=$dbdata1->order_no;
                $h=$dbdata1->article_no;
                $i=$dbdata1->diameter;
                $j=$dbdata1->length;
                $k=$dbdata1->layer_no;
                $l=$dbdata1->sleeve_weight_kg;
                $m=$dbdata1->rm_mixed_qty_kg;
                $n=$dbdata1->ok_qty_no;
                $o=$dbdata1->scrap_weight_kg;
                $p=$dbdata1->scrap_tube_no;
                $q=$dbdata1->cutting_speed_minutes;
                $r=$dbdata1->job_runtime_minutes;
                $s=$dbdata1->qc_date;
                $transform_flag=$dbdata1->transform_flag;
                $bb = date("d-m-Y", strtotime($b));
        
                if($transform_flag=='0'){
              $query = $this->db->query("SELECT * FROM coex_extrusion where machine_id='3' and shift_id='4' and `extrusion_date`='2023-05-19'" );
                    $query->num_rows();
          
                    if($query->num_rows()>0){

                        if($d==3 and $c==4){
                            $shift_id12++;
            
              $sleeve_weight_kg=$sleeve_weight_kg+$l;
              $rm_mixed_qty_kg=$rm_mixed_qty_kg+$m;
              $ok_qty_no=$ok_qty_no+$n;
              $scrap_weight_kg=$scrap_weight_kg+$o;
              $scrap_tube_no=$scrap_tube_no+$p;
              $expected_sleeve_prod=$n+$p;
                $sp_minutes = $n+$p/$q;
                            $job_runtime_minutes=$job_runtime_minutes+$r;

                            $this->db2 = $this->load->database('another_db2', TRUE);
             
                $jobcard_qty['jqty']=$this->coex_extrusion_model->get_jobcard_qty($g,$f);
                  foreach($jobcard_qty['jqty'] as $j){
                    $y=$j->actual_qty_manufactured/100;
                  }
        
              $dataa = array('ex_id'=>$newexid,
                       'date' =>$bb,
                       'shift_id'=>$d,
                       'plant_id'=>'3',
                       'machine_id'=>$c,
                       'process_id'=>'1',
                       'job_no'=>'JOB'.$count,
                       'psp_psm_no'=>$h,
                       'job_card_no'=>$f,
                       'so_no'=>$g,
                       'total_rm_kg'=>$m,
                       //'ttotal_rm_kg'=>$m,
                       'time'=>time(),
                       'expected_sleeve_prod'=>$expected_sleeve_prod,
                       'sp_minutes'=>$sp_minutes,
                       'job_order_quantity'=>$y,
                       'rp'=>$rp,
                       'wp'=>$rp,
                       'operator_id'=>$operator,
                       //'downminutesbysystem'=> 480 - $r,
                       'sleeve_weight_kg'=>$sleeve_weight_kg,
                       'sleeve_to_header'=>$n,
                       'sleeve_waste_kg'=>$o,
                       'sleeve_waste_no'=>$p,
                       'minutes'=>$r,
                          );
              
              $count++;

              $data['db2data']=$this->common_model->save_db2('extrusion',$dataa);
                          
            }
          }
        }
            }
      
            if($transform_flag=='0'){
        $query = $this->db->query("SELECT * FROM coex_extrusion where machine_id='3' and shift_id='4' and `extrusion_date`='2023-05-19'" );
        //echo $this->db->last_query();
        $query->num_rows();
          
        if($query->num_rows()>0){
         
          if($shift_id12<7){
           $z=5;

            for ($x = $shift_id12; $x <= $z; $x++) {
              $a=' ';
              $y=$x+1;

              $dataa = array('ex_id'=>$newexid,
                     'date' =>' ',
                     'shift_id'=>' ',
                     'machine_id'=>' ',
                     'job_no'=>'JOB'.$y,
                     'job_card_no'=>' ',
                     'so_no'=>' ',
                     'operator_id'=>' ',
                     'shift_id'=>$d,
                     'plant_id'=>'3',
                     'machine_id'=>$c,
                     'process_id'=>'1'
                  );

              $data['db2data']=$this->common_model->save_db2('extrusion',$dataa);
            } 
          }
          else{
             'contect to erp team';
          }
        
          $dataa = array('ex_id'=>$newexid,
                'job_no'=>'TOTAL',
                //'sleeve_weight_kg' =>$sleeve_weight_kg,
                'total_rm_kg'=>$m,
                'sleeve_to_header' =>$ok_qty_no,
                'sleeve_waste_kg' =>$scrap_weight_kg,
                'sleeve_waste_no' =>$scrap_tube_no,
                'minutes' =>$job_runtime_minutes,
                'downminutesbysystem'=> 480 - $r,
                               'rp'=>$rp,
                               'wp'=>$rp,
                'shift_id'=>$d,
                'plant_id'=>'3',
                'machine_id'=>$c,
                'process_id'=>'1'
              );

          $data['db2data']=$this->common_model->save_db2('extrusion',$dataa); 
        
        }
      }

        $dates='2023-05-19';

        $data_update=array(
            'transform_flag'=> '1'
        );
              
        $result=$this->common_model->update_one_active_record_where_where('coex_extrusion',$data_update,'extrusion_date',$dates, 'machine_id', '3', 'shift_id','4',$this->session->userdata['logged_in']['company_id']);

    echo "completed !!";
       
}


}


