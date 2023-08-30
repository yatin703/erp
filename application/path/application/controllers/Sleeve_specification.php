<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sleeve_specification extends CI_Controller {

  function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('tube_specification_model');
      $this->load->model('sleeve_specification_model');
      $this->load->model('article_model');
      $this->load->model('customer_model');
      $this->load->model('supplier_model');
      $this->load->model('artwork_model');
      $this->load->model('sub_group_model');
      $this->load->model('second_sub_group_model');
      $this->load->model('sales_order_book_model');
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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $table='specification_sheet';
            include('pagination-tube.php');
            $data['specification']=$this->sleeve_specification_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

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


  function view(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $data['specification']=$this->tube_specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->uri->segment(3),'specification_sheet.spec_version_no',$this->uri->segment(4));

            $spec_lang=array();
            $spec_lang['spec_id']=$this->uri->segment(3);
            $spec_lang['spec_version_no']=$this->uri->segment(4);

            $data['specification_sheet_lang']=$this->common_model->select_active_records_where('specification_sheet_lang',$this->session->userdata['logged_in']['company_id'],$spec_lang);

            //echo $this->db->last_query();
           
            $data['specification_sleeve_details']=$this->sleeve_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$this->uri->segment(3),'specification_sheet_details.spec_version_no',$this->uri->segment(4),'item_group_id','3','srd_id','asc');

            $data['followup']=$this->common_model->select_followup_records('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$this->uri->segment(3).'@@@'.$this->uri->segment(4));

            $data['company']=$this->common_model->select_one_active_record('company_master',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);
            $data['company_details']=$this->common_model->select_one_active_record('company_system_parameters',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);

            $this->load->view('Print/header',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/view-form',$data);
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

  function view_cap(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $data['specification']=$this->tube_specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->uri->segment(3),'specification_sheet.spec_version_no',$this->uri->segment(4));

            $spec_lang=array();
            $spec_lang['spec_id']=$this->uri->segment(3);
            $spec_lang['spec_version_no']=$this->uri->segment(4);

            $data['specification_sheet_lang']=$this->common_model->select_active_records_where('specification_sheet_lang',$this->session->userdata['logged_in']['company_id'],$spec_lang);

            $data['specification_cap_details']=$this->tube_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$this->uri->segment(3),'specification_sheet_details.spec_version_no',$this->uri->segment(4),'item_group_id','5','srd_id','asc');

            $data['followup']=$this->common_model->select_followup_records('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$this->uri->segment(3).'@@@'.$this->uri->segment(4));

            $data['company']=$this->common_model->select_one_active_record('company_master',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);
            $data['company_details']=$this->common_model->select_one_active_record('company_system_parameters',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);

            $this->load->view('Print/header',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/view-form-cap',$data);
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


  function create_single_layer(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);

            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
            $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);

            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);

            //$data['uvblocker']=$this->article_model->spec_all_active_record_search_uvblocker('article','12',$this->session->userdata['logged_in']['company_id']);

            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

              

            $data['page_name']='home';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
            $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/create-single-form',$data);
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



  function create_two_layer(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);

            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
            $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

            $data['page_name']='home';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
            $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/create-two-form',$data);
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


    function create_three_layer(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);

            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
            $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

            $data['page_name']='home';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
            $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/create-three-form',$data);
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


  function create_five_layer(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);

            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
            $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
            $data['admer']=$this->article_model->spec_active_record_search('article','15',$this->session->userdata['logged_in']['company_id']);
            $data['evoh']=$this->article_model->spec_active_record_search('article','16',$this->session->userdata['logged_in']['company_id']);
            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

            $data['page_name']='home';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
            $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/create-five-form',$data);
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



  function save_single_layer(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $this->form_validation->set_rules('main_group','Main Group' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('article_no','Article No' ,'required|trim|xss_clean|max_length[20]');
            
            $this->form_validation->set_rules('sleeve_dia','Sleeve Dia' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sleeve_length','Sleeve Length' ,'required|trim|xss_clean|max_length[5]');
            $this->form_validation->set_rules('gauge','Gauge' ,'required|trim|xss_clean|exact_length[3]|in_list[400,500,550,350]');
            $this->form_validation->set_rules('sl_masterbatch','Sleeve Masterbatch' ,'required|trim|xss_clean');
            //$this->form_validation->set_rules('sl_mb_supplier','Sleeve Masterbatch Supplier','trim|xss_clean|callback_supplier_check');

            $this->form_validation->set_rules('sl_mb_per','Sleeve Masterbatch %' ,'required|trim|xss_clean|numeric|less_than_equal_to[25]|max_length[4]');
            
            if($this->input->post('sl_masterbatch')=='RM-MB-TRA-0007'){
            $this->form_validation->set_rules('sl_mb_per','Sleeve Masterbatch %' ,'required|trim|xss_clean|numeric|less_than[1]');
            }

            if($this->input->post('sleeve_dia')){
            $sleeve_dia=explode('//',$this->input->post('sleeve_dia'));
              if($sleeve_dia[0]=="19 MM" || $sleeve_dia[0]=="22 MM" || $sleeve_dia[0]=="22.6 MM"){
                $this->form_validation->set_rules('gauge','Gauge' ,'required|trim|xss_clean|in_list[400]');
              }else if($sleeve_dia[0]=="25 MM" || $sleeve_dia[0]=="30 MM" ||  $sleeve_dia[0]=="35 MM" || $sleeve_dia[0]=="40 MM"){
                $this->form_validation->set_rules('gauge','Gauge' ,'required|trim|xss_clean|in_list[500]');
              }else{
                $this->form_validation->set_rules('gauge','Gauge' ,'required|trim|xss_clean|in_list[550,350]');
              }
            }

            $this->form_validation->set_rules('sl_ldpe_per','Sleeve Ldpe %' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_check');
            $this->form_validation->set_rules('sl_lldpe_per','Sleeve Lldpe %' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_check');
            $this->form_validation->set_rules('sl_hdpe_per','Sleeve Hdpe %' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_check');

            if(!empty($this->input->post('sl_ldpe_per'))){
              $this->form_validation->set_rules('sl_ldpe','Sleeve Ldpe' ,'trim|xss_clean|required|in_list[RM-LDPE-000-0009]');
            }if(!empty($this->input->post('sl_lldpe_per'))){
              $this->form_validation->set_rules('sl_lldpe','Sleeve Lldpe' ,'trim|xss_clean|required');
            }if(!empty($this->input->post('sl_hdpe_per'))){
              $this->form_validation->set_rules('sl_hdpe','Sleeve Hdpe' ,'trim|xss_clean|required');
            }
               
            

            if($this->form_validation->run()==FALSE){
            $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
            $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

              

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-single-form',$data);
              $this->load->view('Home/footer');
            }else{

              if(!empty($this->input->post('sleeve_dia'))){
                $sleeve_dia=explode('//',$this->input->post('sleeve_dia'));
              }else{
                $sleeve_dia[0]='';
                $sleeve_dia[1]='';
              }

              if(!empty($this->input->post('sleeve_length'))){
                $sleeve_length="X".$this->input->post('sleeve_length')." 1 LAYER";
              }else{
                $sleeve_length='';
              }

              if(!empty($this->input->post('gauge'))){
                $gauge=$this->input->post('gauge')."MIC";
              }else{
                $gauge='';
              }

              if(!empty($this->input->post('sl_ldpe')) && !empty($this->input->post('sl_ldpe_per'))){

                $data['sl_ldpe']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_ldpe'));
                if($data['sl_ldpe']==FALSE){
                $sl_ldpe="";
                }else{
                foreach($data['sl_ldpe'] as $sl_ldpe_row){
                  $sl_ldpe=$sl_ldpe_row->article_name;
                }
                }
                $sl_ldpe_per=$this->input->post('sl_ldpe_per')."%";
              }else{
                $sl_ldpe='';
                $sl_ldpe_per='';
              }


              if(!empty($this->input->post('sl_lldpe')) && !empty($this->input->post('sl_lldpe_per'))){

                $data['sl_lldpe']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_lldpe'));
                if($data['sl_lldpe']==FALSE){
                $sl_lldpe="";
                }else{
                foreach($data['sl_lldpe'] as $sl_lldpe_row){
                  $sl_lldpe=$sl_lldpe_row->article_name;
                }
                }
                $sl_lldpe_per=$this->input->post('sl_lldpe_per')."%";
              }else{
                $sl_lldpe='';
                $sl_lldpe_per='';
              }


              if(!empty($this->input->post('sl_hdpe')) && !empty($this->input->post('sl_hdpe_per'))){

                $data['sl_hdpe']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_hdpe'));
                if($data['sl_hdpe']==FALSE){
                $sl_hdpe="";
                }else{
                foreach($data['sl_hdpe'] as $sl_hdpe_row){
                  $sl_hdpe=$sl_hdpe_row->article_name;
                }
                }
                $sl_hdpe_per=$this->input->post('sl_hdpe_per')."%";
              }else{
                $sl_hdpe='';
                $sl_hdpe_per='';
              }

              if(!empty($this->input->post('sl_masterbatch'))){
              $data['sl_masterbatch']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_masterbatch'));

                foreach($data['sl_masterbatch'] as $sl_masterbatch_row){
                $sl_masterbatch=$sl_masterbatch_row->article_name;

                }
                
              }else{
                $sl_masterbatch="";

              }

              if($this->input->post('sl_mb_per')!=''){
                $sl_mb_per=$this->input->post('sl_mb_per')."%";
              }else{
                $sl_mb_per="";
              }

              

              $article_description=$sleeve_dia[0]."".$sleeve_length." ".$gauge." ".$sl_masterbatch." ".$sl_mb_per." ".$sl_ldpe." ".$sl_ldpe_per." ".$sl_lldpe." ".$sl_lldpe_per." ".$sl_hdpe." ".$sl_hdpe_per;

              $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article_name_info.lang_article_description',$article_description);

                      if($data['article']==FALSE){

                        $article_no=$this->main_group_article($this->input->post('main_group'));

                        $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                              'main_group_id'=>$this->input->post('main_group'),
                              'article_group_id'=>'999999999999999',
                              'sub_sub_grp_id'=>'999999999999999',
                              'article_no'=>$article_no,
                              'uom'=>'UOM001',
                              'sales_purchase_flag'=>'2',
                              'spec_item_flag'=>'1',
                              'archive'=>'0',
                              'article_date'=>date('Y-m-d'), 
                              'article_modified_date'=>date('Y-m-d')
                            );

                        $result=$this->common_model->save('article',$data);

                        $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                              'language_id'=>$this->session->userdata['logged_in']['language_id'],
                              'article_no'=>$article_no,
                              'lang_article_description'=>$article_description,
                              'lang_sub_description'=>'',
                              'main_group_id'=>$this->input->post('main_group'),
                              'article_group_id'=>'999999999999999',
                              'sub_sub_grp_id'=>'999999999999999');

                        $result=$this->common_model->save('article_name_info',$data);

                        $data['auto']=$this->common_model->select_one_active_record_nonlanguage_without_archive('autogeneration_format_master',$this->session->userdata['logged_in']['company_id'],'form_id','1242');
                        $no="";
                        foreach ($data['auto'] as $auto_row) {

                          $data['account_periods']=$this->common_model->select_one_active_record_nonlanguage_without_archive('account_periods_master',$this->session->userdata['logged_in']['company_id'],'finyear_close_opt','0');
                          foreach($data['account_periods'] as $account_periods_row){
                            $start=date('y', strtotime($account_periods_row->fin_year_start));
                            $end=date('y', strtotime($account_periods_row->fin_year_end));
                          }
                          $no=str_pad($auto_row->curr_val,4,"0",STR_PAD_LEFT);
                          $spec_no=$auto_row->textcode.$no;
                          $next_spec_no=$auto_row->curr_val+1;
                        }
                        $data=array('curr_val'=>$next_spec_no);
                        $this->common_model->update_one_active_record('autogeneration_format_master',$data,'form_id','1242',$this->session->userdata['logged_in']['company_id']);
                        $spec_version_no='1';

                        $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                              'spec_id'=>$spec_no,
                              'spec_created_date'=>date('Y-m-d'),
                              'spec_version_no'=>$spec_version_no,
                              'adr_company_id'=>'',
                              'article_no'=>$article_no,
                              'pending_flag'=>'0',
                              'final_approval_flag'=>'0',
                              'user_id'=>$this->session->userdata['logged_in']['user_id'],
                              'dyn_qty_present'=>'SLEEVE|1',
                              );

                        $result=$this->common_model->save('specification_sheet',$data);


                        

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'164',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DIA',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$sleeve_dia[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_1',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'165',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LENGTH',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('sleeve_length'),
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_2',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'166',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DRAWING',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_3',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'167',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'GUAGE',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('gauge'),
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_4',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'168',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'material'=>'1',
                'item_group_material'=>'12',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_mb_per'),
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_masterbatch'),
                'srd_id'=>'1_5_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
            

              

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LDPE',
                'material'=>'1',
                'item_group_material'=>'7',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_ldpe_per'),
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_ldpe'),
                'srd_id'=>'1_6_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

            

              
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LLDPE',
                'material'=>'1',
                'item_group_material'=>'8',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_lldpe_per'),
                'mat_article_no'=>$this->input->post('sl_lldpe'),
                'property_id'=>'',
                'srd_id'=>'1_6_1',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
            

            

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'HDPE',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_hdpe_per'),
                'mat_article_no'=>$this->input->post('sl_hdpe'),
                'property_id'=>'',
                'srd_id'=>'1_6_2',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'spec_id'=>$spec_no,
                        'lang_comments'=>$this->input->post('comment'),
                        'language_id'=>$this->session->userdata['logged_in']['language_id'],
                        'spec_version_no'=>$spec_version_no);
              $result=$this->common_model->save('specification_sheet_lang',$data);

              $data['note']='Create Transaction Completed';
              header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

               if(!empty($this->input->post('approval_authority'))){

                    $data=array('pending_flag'=>'1');

                    $result=$this->sleeve_specification_model->update_one_active_record('specification_sheet',$data,'spec_id',$spec_no,'spec_version_no',$spec_version_no,$this->session->userdata['logged_in']['company_id']);

                    $data['followup']=$this->common_model->select_one_active_record_nonlanguage_without_archive('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$spec_no.'@@@'.$spec_version_no);
                      if($data['followup']==FALSE){
                        $transaction_no=1;
                        $status=1;
                      }else{
                        $i=1;
                        foreach ($data['followup'] as $followup_row) {

                          $transaction_no=$followup_row->transaction_no;
                          $status=1;
                          $i++;
                        }
                        $transaction_no=$i;
                      }

                      $data=array(
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'user_id'=>$this->input->post('approval_authority'),
                        'form_id'=>'985',
                        'transaction_no'=>$transaction_no,
                        'status'=>$status,
                        'followup_date'=>date('Y-m-d'),
                        'contact_person_id'=>$this->session->userdata['logged_in']['user_id'],
                        'record_no'=>$spec_no.'@@@'.$spec_version_no);

                      $result=$this->common_model->save('followup',$data);

                      $data['note']='Create Transaction Completed';
                      $data['error']='Sent for Approval';
                      header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                  }

            }else{
             $data['error']='Same Sleeve alerdy Exist';
          }

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
              
              
                  $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);

                  $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                  $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
                  $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
                  $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
                  $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                  $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                  $this->load->view(ucwords($this->router->fetch_class()).'/create-single-form',$data);
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



  function save_two_layer(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $this->form_validation->set_rules('main_group','Main Group' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('article_no','Article No' ,'required|trim|xss_clean|max_length[20]');
            
            $this->form_validation->set_rules('sleeve_dia','Sleeve Dia' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sleeve_length','Sleeve Length' ,'required|trim|xss_clean|max_length[5]');
            $this->form_validation->set_rules('gauge','Gauge' ,'required|trim|xss_clean|max_length[3]');
            $this->form_validation->set_rules('sl_masterbatch','Sleeve Masterbatch' ,'required|trim|xss_clean');
            //$this->form_validation->set_rules('sl_mb_supplier','Sleeve Masterbatch Supplier','trim|xss_clean|callback_supplier_check');
            $this->form_validation->set_rules('sl_mb_per','Sleeve Masterbatch %' ,'required|trim|xss_clean|numeric|less_than_equal_to[25]|max_length[4]');
            if($this->input->post('sl_masterbatch')=='RM-MB-TRA-0007'){
            $this->form_validation->set_rules('sl_mb_per','Sleeve Masterbatch %' ,'required|trim|xss_clean|numeric|less_than[1]');
            }
            /*
            if($this->input->post('sleeve_dia')){
            $sleeve_dia=explode('//',$this->input->post('sleeve_dia'));
              if($sleeve_dia[0]=="19 MM"){
                $this->form_validation->set_rules('gauge','Gauge' ,'required|trim|xss_clean|in_list[200]');
              }else if($sleeve_dia[0]=="25 MM" || $sleeve_dia[0]=="30 MM" ||  $sleeve_dia[0]=="35 MM" || $sleeve_dia[0]=="40 MM"){
                $this->form_validation->set_rules('gauge','Gauge' ,'required|trim|xss_clean|in_list[250]');
              }else{
                $this->form_validation->set_rules('gauge','Gauge' ,'required|trim|xss_clean|in_list[150,200]');
              }
            }*/

            $this->form_validation->set_rules('sl_ldpe_per','Sleeve Ldpe %' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_check');
            $this->form_validation->set_rules('sl_lldpe_per','Sleeve Lldpe %' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_check');
            $this->form_validation->set_rules('sl_hdpe_per','Sleeve Hdpe %' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_check');

            if(!empty($this->input->post('sl_ldpe_per'))){
              $this->form_validation->set_rules('sl_ldpe','Sleeve Ldpe' ,'trim|xss_clean|required|in_list[RM-LDPE-000-0009]');
            }if(!empty($this->input->post('sl_lldpe_per'))){
              $this->form_validation->set_rules('sl_lldpe','Sleeve Lldpe' ,'trim|xss_clean|required');
            }if(!empty($this->input->post('sl_hdpe_per'))){
              $this->form_validation->set_rules('sl_hdpe','Sleeve Hdpe' ,'trim|xss_clean|required');
            }

            $this->form_validation->set_rules('gauge_two','Gauge Layer Two' ,'required|trim|xss_clean|max_length[3]');
            $this->form_validation->set_rules('sl_masterbatch_two','Sleeve Masterbatch Layer Two' ,'trim|xss_clean');
            
            if($this->input->post('sl_masterbatch_two')=='RM-MB-TRA-0007'){
            $this->form_validation->set_rules('sl_mb_per_two','Sleeve Masterbatch % Layer Two' ,'required|trim|xss_clean|numeric|less_than[1]');
            }

            /*
            if($this->input->post('sleeve_dia')){
            $sleeve_dia=explode('//',$this->input->post('sleeve_dia'));
              if($sleeve_dia[0]=="19 MM"){
                $this->form_validation->set_rules('gauge_two','Gauge Layer Two' ,'required|trim|xss_clean|in_list[200,150,400]');
              }else if($sleeve_dia[0]=="25 MM" || $sleeve_dia[0]=="30 MM" ||  $sleeve_dia[0]=="35 MM" || $sleeve_dia[0]=="40 MM"){
                $this->form_validation->set_rules('gauge_two','Gauge Layer Two' ,'required|trim|xss_clean|in_list[250]');
              }else{
                $this->form_validation->set_rules('gauge_two','Gauge Layer Two' ,'required|trim|xss_clean|in_list[275,150,400]');
              }
            }*/


            $this->form_validation->set_rules('sl_ldpe_per_two','Sleeve Ldpe % Layer Two' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_two_check');
            $this->form_validation->set_rules('sl_lldpe_per_two','Sleeve Lldpe % Layer Two' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_two_check');
            $this->form_validation->set_rules('sl_hdpe_per_two','Sleeve Hdpe % Layer Two' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_two_check');

            if(!empty($this->input->post('sl_ldpe_per_two'))){
              $this->form_validation->set_rules('sl_ldpe_two','Sleeve Ldpe Layer Two' ,'trim|xss_clean|required|in_list[RM-LDPE-000-0009]');
            }if(!empty($this->input->post('sl_lldpe_per_two'))){
              $this->form_validation->set_rules('sl_lldpe_two','Sleeve Lldpe Layer Two' ,'trim|xss_clean|required');
            }if(!empty($this->input->post('sl_hdpe_per_two'))){
              $this->form_validation->set_rules('sl_hdpe_two','Sleeve Hdpe Layer Two' ,'trim|xss_clean|required');
            }
               
            

            if($this->form_validation->run()==FALSE){
            $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
            $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

              

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-two-form',$data);
              $this->load->view('Home/footer');
            }else{

              if(!empty($this->input->post('sleeve_dia'))){
                $sleeve_dia=explode('//',$this->input->post('sleeve_dia'));
              }else{
                $sleeve_dia[0]='';
                $sleeve_dia[1]='';
              }

              if(!empty($this->input->post('sleeve_length'))){
                $sleeve_length="X".$this->input->post('sleeve_length')." 2 LAYER";
              }else{
                $sleeve_length='';
              }

              if(!empty($this->input->post('gauge'))){
                $gauge=$this->input->post('gauge')."MIC";
              }else{
                $gauge='';
              }

              if(!empty($this->input->post('sl_ldpe')) && !empty($this->input->post('sl_ldpe_per'))){

                $data['sl_ldpe']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_ldpe'));
                if($data['sl_ldpe']==FALSE){
                $sl_ldpe="";
                }else{
                foreach($data['sl_ldpe'] as $sl_ldpe_row){
                  $sl_ldpe=$sl_ldpe_row->article_name;
                  }
                }
                if(!empty($this->input->post('sl_ldpe_per')) && $this->input->post('sl_ldpe_per')!=0){
                  $sl_ldpe_per=$this->input->post('sl_ldpe_per')."%";
                }else{
                  $sl_ldpe_per="";
                }
                
              }else{
                $sl_ldpe='';
                $sl_ldpe_per='';
              }


              if(!empty($this->input->post('sl_lldpe')) && !empty($this->input->post('sl_lldpe_per'))){

                $data['sl_lldpe']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_lldpe'));
                if($data['sl_lldpe']==FALSE){
                $sl_lldpe="";
                }else{
                foreach($data['sl_lldpe'] as $sl_lldpe_row){
                  $sl_lldpe=$sl_lldpe_row->article_name;
                  }
                }

                if(!empty($this->input->post('sl_lldpe_per')) && $this->input->post('sl_lldpe_per')!=0){
                  $sl_lldpe_per=$this->input->post('sl_lldpe_per')."%";
                }else{
                  $sl_lldpe_per="";
                }

              }else{
                $sl_lldpe='';
                $sl_lldpe_per='';
              }

              if(!empty($this->input->post('sl_hdpe')) && !empty($this->input->post('sl_hdpe_per'))){

                $data['sl_hdpe']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_hdpe'));
                if($data['sl_hdpe']==FALSE){
                
                }else{
                foreach($data['sl_hdpe'] as $sl_hdpe_row){
                  $sl_hdpe=$sl_hdpe_row->article_name;
                  }
                }

                if(!empty($this->input->post('sl_hdpe_per')) && $this->input->post('sl_hdpe_per')!=0){
                  $sl_hdpe_per=$this->input->post('sl_hdpe_per')."%";
                }else{
                  $sl_hdpe_per="";
                }

              }else{
                $sl_hdpe='';
                $sl_hdpe_per='';
              }

              if(!empty($this->input->post('sl_masterbatch'))){
              $data['sl_masterbatch']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_masterbatch'));

                foreach($data['sl_masterbatch'] as $sl_masterbatch_row){
                  $sl_masterbatch=$sl_masterbatch_row->article_name;
                }


              }else{
                $sl_masterbatch="";
              }


              if($this->input->post('sl_mb_per')!=''){
                  $sl_mb_per=$this->input->post('sl_mb_per')."%";
                }else{
                  $sl_mb_per="";
                }


              if(!empty($this->input->post('gauge_two'))){
                $gauge_two=$this->input->post('gauge_two')."MIC";
              }else{
                $gauge_two='';
              }

             
              if(!empty($this->input->post('sl_ldpe_two')) && !empty($this->input->post('sl_ldpe_per_two'))){

                $data['sl_ldpe_two']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_ldpe_two'));
                if($data['sl_ldpe_two']==FALSE){
                
                }else{
                foreach($data['sl_ldpe_two'] as $sl_ldpe_two_row){
                  $sl_ldpe_two=$sl_ldpe_two_row->article_name;
                  }
                }

                if(!empty($this->input->post('sl_ldpe_per_two')) && $this->input->post('sl_ldpe_per_two')!=0){
                  $sl_ldpe_per_two=$this->input->post('sl_ldpe_per_two')."%";
                }else{
                  $sl_ldpe_per_two="";
                }

              }else{
                $sl_ldpe_two='';
                $sl_ldpe_per_two='';
              }


              if(!empty($this->input->post('sl_lldpe_two')) && !empty($this->input->post('sl_lldpe_per_two'))){

                $data['sl_lldpe_two']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_lldpe_two'));
                if($data['sl_lldpe_two']==FALSE){
                
                }else{
                foreach($data['sl_lldpe_two'] as $sl_lldpe_two_row){
                  $sl_lldpe_two=$sl_lldpe_two_row->article_name;
                  }
                }

                if(!empty($this->input->post('sl_lldpe_per_two')) && $this->input->post('sl_lldpe_per_two')!=0){
                  $sl_lldpe_per_two=$this->input->post('sl_lldpe_per_two')."%";
                }else{
                  $sl_lldpe_per_two="";
                }

              }else{
                $sl_lldpe_two='';
                $sl_lldpe_per_two='';
              }


              if(!empty($this->input->post('sl_hdpe_two')) && !empty($this->input->post('sl_hdpe_two_per'))){

                $data['sl_hdpe_two']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_hdpe_two'));
                if($data['sl_hdpe_two']==FALSE){
                
                }else{
                foreach($data['sl_hdpe_two'] as $sl_hdpe_two_row){
                  $sl_hdpe_two=$sl_hdpe_two_row->article_name;
                  }
                }

                if(!empty($this->input->post('sl_hdpe_per_two')) && $this->input->post('sl_hdpe_per_two')!=0){
                  $sl_hdpe_per_two=$this->input->post('sl_hdpe_per_two')."%";
                }else{
                  $sl_hdpe_per_two="";
                }

              }else{
                $sl_hdpe_two='';
                $sl_hdpe_per_two='';
              }

              if(!empty($this->input->post('sl_masterbatch_two'))){
              $data['sl_masterbatch_two']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_masterbatch_two'));

                foreach($data['sl_masterbatch_two'] as $sl_masterbatch_two_row){
                  $sl_masterbatch_two=$sl_masterbatch_two_row->article_name;
                }

              }else{
                $sl_masterbatch_two="";
                $sl_mb_per_two="";
              }

              if($this->input->post('sl_mb_per_two')!=''){
                  $sl_mb_per_two=$this->input->post('sl_mb_per_two')."%";
                }else{
                  $sl_mb_per_two="";
                }

              $article_description=$sleeve_dia[0]."".$sleeve_length." ".$gauge." ".$sl_masterbatch." ".$sl_mb_per." ".$sl_ldpe." ".$sl_ldpe_per." ".$sl_lldpe." ".$sl_lldpe_per." ".$sl_hdpe." ".$sl_hdpe_per." ".$gauge_two." ".$sl_masterbatch_two." ".$sl_mb_per_two." ".$sl_ldpe_two." ".$sl_ldpe_per_two." ".$sl_lldpe_two." ".$sl_lldpe_per_two." ".$sl_hdpe_two." ".$sl_hdpe_per_two;

              $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article_name_info.lang_article_description',$article_description);

                      if($data['article']==FALSE){

                        $article_no=$this->main_group_article($this->input->post('main_group'));

                        $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                              'main_group_id'=>$this->input->post('main_group'),
                              'article_group_id'=>'999999999999999',
                              'sub_sub_grp_id'=>'999999999999999',
                              'article_no'=>$article_no,
                              'uom'=>'UOM001',
                              'sales_purchase_flag'=>'2',
                              'spec_item_flag'=>'1',
                              'archive'=>'0',
                              'article_date'=>date('Y-m-d'), 
                              'article_modified_date'=>date('Y-m-d')
                            );

                        $result=$this->common_model->save('article',$data);

                        $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                              'language_id'=>$this->session->userdata['logged_in']['language_id'],
                              'article_no'=>$article_no,
                              'lang_article_description'=>$article_description,
                              'lang_sub_description'=>'',
                              'main_group_id'=>$this->input->post('main_group'),
                              'article_group_id'=>'999999999999999',
                              'sub_sub_grp_id'=>'999999999999999');

                        $result=$this->common_model->save('article_name_info',$data);

                        $data['auto']=$this->common_model->select_one_active_record_nonlanguage_without_archive('autogeneration_format_master',$this->session->userdata['logged_in']['company_id'],'form_id','1242');
                        $no="";
                        foreach ($data['auto'] as $auto_row) {

                          $data['account_periods']=$this->common_model->select_one_active_record_nonlanguage_without_archive('account_periods_master',$this->session->userdata['logged_in']['company_id'],'finyear_close_opt','0');
                          foreach($data['account_periods'] as $account_periods_row){
                            $start=date('y', strtotime($account_periods_row->fin_year_start));
                            $end=date('y', strtotime($account_periods_row->fin_year_end));
                          }
                          $no=str_pad($auto_row->curr_val,4,"0",STR_PAD_LEFT);
                          $spec_no=$auto_row->textcode.$no;
                          $next_spec_no=$auto_row->curr_val+1;
                        }
                        $data=array('curr_val'=>$next_spec_no);
                        $this->common_model->update_one_active_record('autogeneration_format_master',$data,'form_id','1242',$this->session->userdata['logged_in']['company_id']);
                        $spec_version_no='1';

                        $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                              'spec_id'=>$spec_no,
                              'spec_created_date'=>date('Y-m-d'),
                              'spec_version_no'=>$spec_version_no,
                              'adr_company_id'=>'',
                              'article_no'=>$article_no,
                              'pending_flag'=>'0',
                              'final_approval_flag'=>'0',
                              'user_id'=>$this->session->userdata['logged_in']['user_id'],
                              'dyn_qty_present'=>'SLEEVE|2',
                              );

                        $result=$this->common_model->save('specification_sheet',$data);


                        

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'164',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DIA',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$sleeve_dia[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_1',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'165',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LENGTH',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('sleeve_length'),
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_2',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'166',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DRAWING',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_3',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'167',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'GUAGE',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('gauge'),
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_4',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'168',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'material'=>'1',
                'item_group_material'=>'12',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_mb_per'),
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_masterbatch'),
                'srd_id'=>'1_5_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
            

              

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LDPE',
                'material'=>'1',
                'item_group_material'=>'7',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_ldpe_per'),
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_ldpe'),
                'srd_id'=>'1_6_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

            

              
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LLDPE',
                'material'=>'1',
                'item_group_material'=>'8',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_lldpe_per'),
                'mat_article_no'=>$this->input->post('sl_lldpe'),
                'property_id'=>'',
                'srd_id'=>'1_6_1',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
            

            

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'HDPE',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_hdpe_per'),
                'mat_article_no'=>$this->input->post('sl_hdpe'),
                'property_id'=>'',
                'srd_id'=>'1_6_2',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'167',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'GUAGE',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('gauge_two'),
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_4',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);
              
              $sl_mb_per_two=$this->input->post('sl_mb_per_two');
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'168',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'material'=>'1',
                'item_group_material'=>'12',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$sl_mb_per_two,
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_masterbatch_two'),
                'srd_id'=>'2_5_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);
            

              

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LDPE',
                'material'=>'1',
                'item_group_material'=>'7',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_ldpe_per_two'),
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_ldpe_two'),
                'srd_id'=>'2_6_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);

            

              
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LLDPE',
                'material'=>'1',
                'item_group_material'=>'8',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_lldpe_per_two'),
                'mat_article_no'=>$this->input->post('sl_lldpe_two'),
                'property_id'=>'',
                'srd_id'=>'2_6_1',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);
            

            

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'HDPE',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_hdpe_per_two'),
                'mat_article_no'=>$this->input->post('sl_hdpe_two'),
                'property_id'=>'',
                'srd_id'=>'2_6_2',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);



              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'spec_id'=>$spec_no,
                        'lang_comments'=>$this->input->post('comment'),
                        'language_id'=>$this->session->userdata['logged_in']['language_id'],
                        'spec_version_no'=>$spec_version_no);
              $result=$this->common_model->save('specification_sheet_lang',$data);

              $data['note']='Create Transaction Completed';
              //header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

               if(!empty($this->input->post('approval_authority'))){

                    $data=array('pending_flag'=>'1');

                    $result=$this->sleeve_specification_model->update_one_active_record('specification_sheet',$data,'spec_id',$spec_no,'spec_version_no',$spec_version_no,$this->session->userdata['logged_in']['company_id']);

                    $data['followup']=$this->common_model->select_one_active_record_nonlanguage_without_archive('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$spec_no.'@@@'.$spec_version_no);
                      if($data['followup']==FALSE){
                        $transaction_no=1;
                        $status=1;
                      }else{
                        $i=1;
                        foreach ($data['followup'] as $followup_row) {

                          $transaction_no=$followup_row->transaction_no;
                          $status=1;
                          $i++;
                        }
                        $transaction_no=$i;
                      }

                      $data=array(
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'user_id'=>$this->input->post('approval_authority'),
                        'form_id'=>'985',
                        'transaction_no'=>$transaction_no,
                        'status'=>$status,
                        'followup_date'=>date('Y-m-d'),
                        'contact_person_id'=>$this->session->userdata['logged_in']['user_id'],
                        'record_no'=>$spec_no.'@@@'.$spec_version_no);

                      $result=$this->common_model->save('followup',$data);

                      $data['note']='Create Transaction Completed';
                      $data['error']='Sent for Approval';
                      header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                  }

            }else{
             $data['error']='Same Sleeve alerdy Exist';
          }

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
              
              
                  $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);

                  $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                  $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
                  $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
                  $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
                  $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                  $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                  $this->load->view(ucwords($this->router->fetch_class()).'/create-two-form',$data);
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


  function save_three_layer(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $this->form_validation->set_rules('main_group','Main Group' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('article_no','Article No' ,'required|trim|xss_clean|max_length[20]');
            
            $this->form_validation->set_rules('sleeve_dia','Sleeve Dia' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sleeve_length','Sleeve Length' ,'required|trim|xss_clean|max_length[5]');
            $this->form_validation->set_rules('gauge','Gauge' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sl_masterbatch','Sleeve Masterbatch' ,'required|trim|xss_clean');
            //$this->form_validation->set_rules('sl_mb_supplier','Sleeve Masterbatch Supplier','trim|xss_clean|callback_supplier_check');
            $this->form_validation->set_rules('sl_mb_per','Sleeve Masterbatch %' ,'required|trim|xss_clean|numeric|less_than_equal_to[25]|max_length[4]');

            if($this->input->post('sl_masterbatch')=='RM-MB-TRA-0007'){
            $this->form_validation->set_rules('sl_mb_per','Sleeve Masterbatch %' ,'required|trim|xss_clean|numeric|less_than[1]|max_length[4]');
            }

            if($this->input->post('sleeve_dia')){
            $sleeve_dia=explode('//',$this->input->post('sleeve_dia'));
              if($sleeve_dia[0]=="19 MM"){
                $this->form_validation->set_rules('gauge','Gauge' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('gauge_two','Gauge Layer Two' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('gauge_three','Gauge Layer Three' ,'required|trim|xss_clean');
              }else if($sleeve_dia[0]=="25 MM" || $sleeve_dia[0]=="30 MM" ||  $sleeve_dia[0]=="35 MM" || $sleeve_dia[0]=="40 MM"){
                $this->form_validation->set_rules('gauge','Gauge' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('gauge_two','Gauge Layer Two' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('gauge_three','Gauge Layer Three' ,'required|trim|xss_clean');
              }else{
                $this->form_validation->set_rules('gauge','Gauge' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('gauge_two','Gauge Layer Two' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('gauge_three','Gauge Layer Three' ,'required|trim|xss_clean');
              }
            }

            $this->form_validation->set_rules('sl_ldpe_per','Sleeve Ldpe %' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_check');
            $this->form_validation->set_rules('sl_lldpe_per','Sleeve Lldpe %' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_check');
            $this->form_validation->set_rules('sl_hdpe_per','Sleeve Hdpe %' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_check');

            if(!empty($this->input->post('sl_ldpe_per'))){
              $this->form_validation->set_rules('sl_ldpe','Sleeve Ldpe' ,'trim|xss_clean|required|in_list[RM-LDPE-000-0009]');
            }if(!empty($this->input->post('sl_lldpe_per'))){
              $this->form_validation->set_rules('sl_lldpe','Sleeve Lldpe' ,'trim|xss_clean|required');
            }if(!empty($this->input->post('sl_hdpe_per'))){
              $this->form_validation->set_rules('sl_hdpe','Sleeve Hdpe' ,'trim|xss_clean|required');
            }

            $this->form_validation->set_rules('gauge_two','Gauge Layer Two' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sl_hdpe_two','Sleeve Hdpe  Layer two' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sl_hdpe_per_two','Sleeve Hdpe % Layer two' ,'required|trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_two_check');

            $this->form_validation->set_rules('gauge_three','Gauge Layer Three' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sl_masterbatch_three','Sleeve Masterbatch Three' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sl_mb_per_three','Sleeve Masterbatch % Layer Three' ,'required|trim|xss_clean|numeric|less_than_equal_to[25]|max_length[4]');
            
            if($this->input->post('sl_masterbatch_three')=='RM-MB-TRA-0007'){
            $this->form_validation->set_rules('sl_mb_per_three','Sleeve Masterbatch % Layer Three' ,'required|trim|xss_clean|numeric|less_than[1]|max_length[4]');
            }

            $this->form_validation->set_rules('sl_ldpe_per_three','Sleeve Ldpe % Layer Three' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_three_check');
            $this->form_validation->set_rules('sl_lldpe_per_three','Sleeve Lldpe % Layer Three' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_three_check');
            $this->form_validation->set_rules('sl_hdpe_per_three','Sleeve Hdpe % Layer Three' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_three_check');

            if(!empty($this->input->post('sl_ldpe_per_three'))){
              $this->form_validation->set_rules('sl_ldpe_three','Sleeve Ldpe Layer Three' ,'trim|xss_clean|required|in_list[RM-LDPE-000-0009]');
            }if(!empty($this->input->post('sl_lldpe_per_three'))){
              $this->form_validation->set_rules('sl_lldpe_three','Sleeve Lldpe Layer Three' ,'trim|xss_clean|required');
            }if(!empty($this->input->post('sl_hdpe_per_three'))){
              $this->form_validation->set_rules('sl_hdpe_three','Sleeve Hdpe Layer Three' ,'trim|xss_clean|required');
            }
               
            

            if($this->form_validation->run()==FALSE){
            $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
            $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

              

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-three-form',$data);
              $this->load->view('Home/footer');
            }else{

              if(!empty($this->input->post('sleeve_dia'))){
                $sleeve_dia=explode('//',$this->input->post('sleeve_dia'));
              }else{
                $sleeve_dia[0]='';
                $sleeve_dia[1]='';
              }

              if(!empty($this->input->post('sleeve_length'))){
                $sleeve_length="X".$this->input->post('sleeve_length')." 3 LAYER";
              }else{
                $sleeve_length='';
              }

              if(!empty($this->input->post('gauge'))){
                $gauge=$this->input->post('gauge')."MIC";
              }else{
                $gauge='';
              }

              if(!empty($this->input->post('sl_ldpe')) && !empty($this->input->post('sl_ldpe_per'))){

                $data['sl_ldpe']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_ldpe'));
                if($data['sl_ldpe']==FALSE){
                $sl_ldpe="";
                }else{
                foreach($data['sl_ldpe'] as $sl_ldpe_row){
                  $sl_ldpe=$sl_ldpe_row->article_name;
                  }
                }
                if(!empty($this->input->post('sl_ldpe_per')) && $this->input->post('sl_ldpe_per')!=0){
                  $sl_ldpe_per=$this->input->post('sl_ldpe_per')."%";
                }else{
                  $sl_ldpe_per="";
                }
                
              }else{
                $sl_ldpe='';
                $sl_ldpe_per='';
              }


              if(!empty($this->input->post('sl_lldpe')) && !empty($this->input->post('sl_lldpe_per'))){

                $data['sl_lldpe']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_lldpe'));
                if($data['sl_lldpe']==FALSE){
                $sl_lldpe="";
                }else{
                foreach($data['sl_lldpe'] as $sl_lldpe_row){
                  $sl_lldpe=$sl_lldpe_row->article_name;
                  }
                }

                if(!empty($this->input->post('sl_lldpe_per')) && $this->input->post('sl_lldpe_per')!=0){
                  $sl_lldpe_per=$this->input->post('sl_lldpe_per')."%";
                }else{
                  $sl_lldpe_per="";
                }

              }else{
                $sl_lldpe='';
                $sl_lldpe_per='';
              }

              if(!empty($this->input->post('sl_hdpe')) && !empty($this->input->post('sl_hdpe_per'))){

                $data['sl_hdpe']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_hdpe'));
                if($data['sl_hdpe']==FALSE){
                
                }else{
                foreach($data['sl_hdpe'] as $sl_hdpe_row){
                  $sl_hdpe=$sl_hdpe_row->article_name;
                  }
                }

                if(!empty($this->input->post('sl_hdpe_per')) && $this->input->post('sl_hdpe_per')!=0){
                  $sl_hdpe_per=$this->input->post('sl_hdpe_per')."%";
                }else{
                  $sl_hdpe_per="";
                }

              }else{
                $sl_hdpe='';
                $sl_hdpe_per='';
              }

              if(!empty($this->input->post('sl_masterbatch'))){
              $data['sl_masterbatch']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_masterbatch'));

                foreach($data['sl_masterbatch'] as $sl_masterbatch_row){
                  $sl_masterbatch=$sl_masterbatch_row->article_name;
                }
              }else{
                $sl_masterbatch="";
              }

              if($this->input->post('sl_mb_per')!=''){
                  $sl_mb_per=$this->input->post('sl_mb_per')."%";
                }else{
                  $sl_mb_per="";
                }


              if(!empty($this->input->post('gauge_two'))){
                $gauge_two=$this->input->post('gauge_two')."MIC";
              }else{
                $gauge_two='';
              }

             if(!empty($this->input->post('sl_hdpe_two')) && !empty($this->input->post('sl_hdpe_per_two'))){

                $data['sl_hdpe_two']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_hdpe_two'));
                if($data['sl_hdpe_two']==FALSE){
                
                }else{
                foreach($data['sl_hdpe_two'] as $sl_hdpe_two_row){
                  $sl_hdpe_two=$sl_hdpe_two_row->article_name;
                  }
                }

                if(!empty($this->input->post('sl_hdpe_per_two')) && $this->input->post('sl_hdpe_per_two')!=0){
                  $sl_hdpe_per_two=$this->input->post('sl_hdpe_per_two')."%";
                }else{
                  $sl_hdpe_per_two="";
                }

              }else{
                $sl_hdpe_two='';
                $sl_hdpe_per_two='';
              }

              if(!empty($this->input->post('gauge_three'))){
                $gauge_three=$this->input->post('gauge_three')."MIC";
              }else{
                $gauge_three='';
              }

              if(!empty($this->input->post('sl_ldpe_three')) && !empty($this->input->post('sl_ldpe_per_three'))){

                $data['sl_ldpe_three']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_ldpe_three'));
                if($data['sl_ldpe_three']==FALSE){
                $sl_ldpe_three="";
                }else{
                foreach($data['sl_ldpe_three'] as $sl_ldpe_row_three){
                  $sl_ldpe_three=$sl_ldpe_row_three->article_name;
                  }
                }
                if(!empty($this->input->post('sl_ldpe_per_three')) && $this->input->post('sl_ldpe_per_three')!=0){
                  $sl_ldpe_per_three=$this->input->post('sl_ldpe_per_three')."%";
                }else{
                  $sl_ldpe_per_three="";
                }
                
              }else{
                $sl_ldpe_three='';
                $sl_ldpe_per_three='';
              }


              if(!empty($this->input->post('sl_lldpe_three')) && !empty($this->input->post('sl_lldpe_per_three'))){

                $data['sl_lldpe_three']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_lldpe_three'));
                if($data['sl_lldpe_three']==FALSE){
                $sl_lldpe_three="";
                }else{
                foreach($data['sl_lldpe_three'] as $sl_lldpe_row_three){
                  $sl_lldpe_three=$sl_lldpe_row_three->article_name;
                  }
                }

                if(!empty($this->input->post('sl_lldpe_per_three')) && $this->input->post('sl_lldpe_per_three')!=0){
                  $sl_lldpe_per_three=$this->input->post('sl_lldpe_per_three')."%";
                }else{
                  $sl_lldpe_per_three="";
                }

              }else{
                $sl_lldpe_three='';
                $sl_lldpe_per_three='';
              }

              if(!empty($this->input->post('sl_hdpe_three')) && !empty($this->input->post('sl_hdpe_per_three'))){

                $data['sl_hdpe_three']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_hdpe_three'));
                if($data['sl_hdpe_three']==FALSE){
                
                }else{
                foreach($data['sl_hdpe_three'] as $sl_hdpe_row_three){
                  $sl_hdpe_three=$sl_hdpe_row_three->article_name;
                  }
                }

                if(!empty($this->input->post('sl_hdpe_per_three')) && $this->input->post('sl_hdpe_per_three')!=0){
                  $sl_hdpe_per_three=$this->input->post('sl_hdpe_per_three')."%";
                }else{
                  $sl_hdpe_per_three="";
                }

              }else{
                $sl_hdpe_three='';
                $sl_hdpe_per_three='';
              }

              if(!empty($this->input->post('sl_masterbatch_three'))){
              $data['sl_masterbatch_three']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_masterbatch'));

                foreach($data['sl_masterbatch_three'] as $sl_masterbatch_row_three){
                  $sl_masterbatch_three=$sl_masterbatch_row_three->article_name;
                }

              }else{
                $sl_masterbatch_three="";
              }

              if($this->input->post('sl_mb_per_three')!=''){
                $sl_mb_per_three=$this->input->post('sl_mb_per_three')."%";
              }else{
                $sl_mb_per_three="";
              }

              

              $article_description=$sleeve_dia[0]."".$sleeve_length." ".$gauge." ".$sl_masterbatch." ".$sl_mb_per." ".$sl_ldpe." ".$sl_ldpe_per." ".$sl_lldpe." ".$sl_lldpe_per." ".$sl_hdpe." ".$sl_hdpe_per." ".$gauge_two." ".$sl_hdpe_two." ".$sl_hdpe_per_two." ".$gauge_three." ".$sl_masterbatch_three." ".$sl_mb_per_three." ".$sl_ldpe_three." ".$sl_ldpe_per_three." ".$sl_lldpe_three." ".$sl_lldpe_per_three." ".$sl_hdpe_three." ".$sl_hdpe_per_three;

              $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article_name_info.lang_article_description',$article_description);

                      if($data['article']==FALSE){

                        $article_no=$this->main_group_article($this->input->post('main_group'));

                        $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                              'main_group_id'=>$this->input->post('main_group'),
                              'article_group_id'=>'999999999999999',
                              'sub_sub_grp_id'=>'999999999999999',
                              'article_no'=>$article_no,
                              'uom'=>'UOM001',
                              'sales_purchase_flag'=>'2',
                              'spec_item_flag'=>'1',
                              'archive'=>'0',
                              'article_date'=>date('Y-m-d'), 
                              'article_modified_date'=>date('Y-m-d')
                            );

                        $result=$this->common_model->save('article',$data);

                        $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                              'language_id'=>$this->session->userdata['logged_in']['language_id'],
                              'article_no'=>$article_no,
                              'lang_article_description'=>$article_description,
                              'lang_sub_description'=>'',
                              'main_group_id'=>$this->input->post('main_group'),
                              'article_group_id'=>'999999999999999',
                              'sub_sub_grp_id'=>'999999999999999');

                        $result=$this->common_model->save('article_name_info',$data);

                        $data['auto']=$this->common_model->select_one_active_record_nonlanguage_without_archive('autogeneration_format_master',$this->session->userdata['logged_in']['company_id'],'form_id','1242');
                        $no="";
                        foreach ($data['auto'] as $auto_row) {

                          $data['account_periods']=$this->common_model->select_one_active_record_nonlanguage_without_archive('account_periods_master',$this->session->userdata['logged_in']['company_id'],'finyear_close_opt','0');
                          foreach($data['account_periods'] as $account_periods_row){
                            $start=date('y', strtotime($account_periods_row->fin_year_start));
                            $end=date('y', strtotime($account_periods_row->fin_year_end));
                          }
                          $no=str_pad($auto_row->curr_val,4,"0",STR_PAD_LEFT);
                          $spec_no=$auto_row->textcode.$no;
                          $next_spec_no=$auto_row->curr_val+1;
                        }
                        $data=array('curr_val'=>$next_spec_no);
                        $this->common_model->update_one_active_record('autogeneration_format_master',$data,'form_id','1242',$this->session->userdata['logged_in']['company_id']);
                        $spec_version_no='1';

                        $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                              'spec_id'=>$spec_no,
                              'spec_created_date'=>date('Y-m-d'),
                              'spec_version_no'=>$spec_version_no,
                              'adr_company_id'=>'',
                              'article_no'=>$article_no,
                              'pending_flag'=>'0',
                              'final_approval_flag'=>'0',
                              'user_id'=>$this->session->userdata['logged_in']['user_id'],
                              'dyn_qty_present'=>'SLEEVE|3',
                              );

                        $result=$this->common_model->save('specification_sheet',$data);


                        

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'164',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DIA',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$sleeve_dia[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_1',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'165',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LENGTH',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('sleeve_length'),
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_2',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'166',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DRAWING',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_3',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'167',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'GUAGE',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('gauge'),
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_4',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'168',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'material'=>'1',
                'item_group_material'=>'12',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_mb_per'),
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_masterbatch'),
                'srd_id'=>'1_5_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
            

              

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LDPE',
                'material'=>'1',
                'item_group_material'=>'7',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_ldpe_per'),
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_ldpe'),
                'srd_id'=>'1_6_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

            

              
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LLDPE',
                'material'=>'1',
                'item_group_material'=>'8',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_lldpe_per'),
                'mat_article_no'=>$this->input->post('sl_lldpe'),
                'property_id'=>'',
                'srd_id'=>'1_6_1',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
            

            

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'HDPE',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_hdpe_per'),
                'mat_article_no'=>$this->input->post('sl_hdpe'),
                'property_id'=>'',
                'srd_id'=>'1_6_2',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'167',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'GUAGE',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('gauge_two'),
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_4',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'HDPE',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_hdpe_per_two'),
                'mat_article_no'=>$this->input->post('sl_hdpe_two'),
                'property_id'=>'',
                'srd_id'=>'2_6_2',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);
            

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'167',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'GUAGE',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('gauge_three'),
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_4',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'168',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'material'=>'1',
                'item_group_material'=>'12',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$sl_mb_per_three,
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_masterbatch_three'),
                'srd_id'=>'3_5_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LDPE',
                'material'=>'1',
                'item_group_material'=>'7',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_ldpe_per_three'),
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_ldpe_three'),
                'srd_id'=>'3_6_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);

            

              
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LLDPE',
                'material'=>'1',
                'item_group_material'=>'8',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_lldpe_per_three'),
                'mat_article_no'=>$this->input->post('sl_lldpe_three'),
                'property_id'=>'',
                'srd_id'=>'3_6_1',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);
            

            

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'HDPE',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_hdpe_per_three'),
                'mat_article_no'=>$this->input->post('sl_hdpe_three'),
                'property_id'=>'',
                'srd_id'=>'3_6_2',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'spec_id'=>$spec_no,
                        'lang_comments'=>$this->input->post('comment'),
                        'language_id'=>$this->session->userdata['logged_in']['language_id'],
                        'spec_version_no'=>$spec_version_no);
              $result=$this->common_model->save('specification_sheet_lang',$data);

              $data['note']='Create Transaction Completed';
              //header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

               if(!empty($this->input->post('approval_authority'))){

                    $data=array('pending_flag'=>'1');

                    $result=$this->sleeve_specification_model->update_one_active_record('specification_sheet',$data,'spec_id',$spec_no,'spec_version_no',$spec_version_no,$this->session->userdata['logged_in']['company_id']);

                    $data['followup']=$this->common_model->select_one_active_record_nonlanguage_without_archive('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$spec_no.'@@@'.$spec_version_no);
                      if($data['followup']==FALSE){
                        $transaction_no=1;
                        $status=1;
                      }else{
                        $i=1;
                        foreach ($data['followup'] as $followup_row) {

                          $transaction_no=$followup_row->transaction_no;
                          $status=1;
                          $i++;
                        }
                        $transaction_no=$i;
                      }

                      $data=array(
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'user_id'=>$this->input->post('approval_authority'),
                        'form_id'=>'985',
                        'transaction_no'=>$transaction_no,
                        'status'=>$status,
                        'followup_date'=>date('Y-m-d'),
                        'contact_person_id'=>$this->session->userdata['logged_in']['user_id'],
                        'record_no'=>$spec_no.'@@@'.$spec_version_no);

                      $result=$this->common_model->save('followup',$data);
                  }

            }else{
             $data['error']='Same Sleeve alerdy Exist';
          }

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
              
              
                  $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);

                  $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                  $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
                  $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
                  $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
                  $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                  $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                  $this->load->view(ucwords($this->router->fetch_class()).'/create-three-form',$data);
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



  function save_five_layer(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $this->form_validation->set_rules('main_group','Main Group' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('article_no','Article No' ,'required|trim|xss_clean|max_length[20]');
            
            $this->form_validation->set_rules('sleeve_dia','Sleeve Dia' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sleeve_length','Sleeve Length' ,'required|trim|xss_clean|max_length[5]');
            $this->form_validation->set_rules('gauge','Gauge' ,'required|trim|xss_clean|max_length[5]');
            $this->form_validation->set_rules('sl_masterbatch','Sleeve Masterbatch' ,'required|trim|xss_clean');
            //$this->form_validation->set_rules('sl_mb_supplier','Sleeve Masterbatch Supplier','trim|xss_clean|callback_supplier_check');
            
            $this->form_validation->set_rules('sl_mb_per','Sleeve Masterbatch %' ,'required|trim|xss_clean|numeric|less_than_equal_to[25]|max_length[4]');

            if($this->input->post('sl_masterbatch')=='RM-MB-TRA-0007'){
            $this->form_validation->set_rules('sl_mb_per','Sleeve Masterbatch %' ,'required|trim|xss_clean|numeric|less_than[1]');
            }

            /*
            if($this->input->post('sleeve_dia')){
            $sleeve_dia=explode('//',$this->input->post('sleeve_dia'));
              if($sleeve_dia[0]=="19 MM"){
                $this->form_validation->set_rules('gauge','Gauge' ,'required|trim|xss_clean|exact_length[3]|in_list[173]');
                $this->form_validation->set_rules('gauge_five','Gauge Layer Five' ,'required|trim|xss_clean|exact_length[3]|in_list[172]');
              }else if($sleeve_dia[0]=="25 MM" || $sleeve_dia[0]=="30 MM" ||  $sleeve_dia[0]=="35 MM" || $sleeve_dia[0]=="40 MM"){
                $this->form_validation->set_rules('gauge','Gauge' ,'required|trim|xss_clean|exact_length[3]|in_list[223]');
                $this->form_validation->set_rules('gauge_five','Gauge Layer Five' ,'required|trim|xss_clean|exact_length[3]|in_list[222]');
              }else{
                $this->form_validation->set_rules('gauge','Gauge' ,'required|trim|xss_clean|exact_length[3]|in_list[248]');
                $this->form_validation->set_rules('gauge_five','Gauge Layer Five' ,'required|trim|xss_clean|exact_length[3]|in_list[247]');
              }
            }
            */
            $this->form_validation->set_rules('sl_ldpe_per','Sleeve Ldpe %' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_check');
            $this->form_validation->set_rules('sl_lldpe_per','Sleeve Lldpe %' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_check');
            $this->form_validation->set_rules('sl_hdpe_per','Sleeve Hdpe %' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_check');

            if(!empty($this->input->post('sl_ldpe_per'))){
              $this->form_validation->set_rules('sl_ldpe','Sleeve Ldpe' ,'trim|xss_clean|required|in_list[RM-LDPE-000-0009]');
            }if(!empty($this->input->post('sl_lldpe_per'))){
              $this->form_validation->set_rules('sl_lldpe','Sleeve Lldpe' ,'trim|xss_clean|required');
            }if(!empty($this->input->post('sl_hdpe_per'))){
              $this->form_validation->set_rules('sl_hdpe','Sleeve Hdpe' ,'trim|xss_clean|required');
            }

            $this->form_validation->set_rules('gauge_two','Gauge Layer Two' ,'required|trim|xss_clean|exact_length[2]|is_natural');
            $this->form_validation->set_rules('sl_admer_two','Sleeve Admer Layer two' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sl_admer_per_two','Sleeve Admer % Layer two' ,'required|trim|xss_clean|is_natural|exact_length[3]');

            $this->form_validation->set_rules('gauge_three','Gauge Layer Three' ,'required|trim|xss_clean|exact_length[2]|is_natural');
            
            $this->form_validation->set_rules('sl_evoh_three','Sleeve Evoh Layer Three' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sl_evoh_per_three','Sleeve Evoh % Layer Three' ,'required|trim|xss_clean|is_natural|exact_length[3]');

            $this->form_validation->set_rules('gauge_four','Gauge Layer Four' ,'required|trim|xss_clean|exact_length[2]|is_natural');
            $this->form_validation->set_rules('sl_admer_four','Sleeve Admer Layer Four' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sl_admer_per_four','Sleeve Admer % Layer Four' ,'required|trim|xss_clean|is_natural|exact_length[3]');

            $this->form_validation->set_rules('gauge_five','Gauge Layer Five' ,'required|trim|xss_clean|max_length[5]');
            $this->form_validation->set_rules('sl_masterbatch_five','Sleeve Masterbatch Layer Five' ,'required|trim|xss_clean');
            //$this->form_validation->set_rules('sl_mb_supplier_five','Sleeve Masterbatch Supplier Layer Five','trim|xss_clean|callback_supplier_check');
            $this->form_validation->set_rules('sl_mb_per_five','Sleeve Masterbatch % Layer Five' ,'required|trim|xss_clean|numeric|less_than_equal_to[25]|max_length[4]');

            if($this->input->post('sl_masterbatch_five')=='RM-MB-TRA-0007'){
            $this->form_validation->set_rules('sl_mb_per_five','Sleeve Masterbatch %' ,'required|trim|xss_clean|numeric|less_than[1]');
            }
            
            $this->form_validation->set_rules('sl_ldpe_per_five','Sleeve Ldpe % Layer Five' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_five_check');
            $this->form_validation->set_rules('sl_lldpe_per_five','Sleeve Lldpe % Layer Five' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_five_check');
            $this->form_validation->set_rules('sl_hdpe_per_five','Sleeve Hdpe % Layer Five' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_five_check');

              if(!empty($this->input->post('sl_ldpe_per_five'))){
                $this->form_validation->set_rules('sl_ldpe_five','Sleeve Ldpe Layer Five' ,'trim|xss_clean|required|in_list[RM-LDPE-000-0009]');
              }if(!empty($this->input->post('sl_lldpe_per_five'))){
                $this->form_validation->set_rules('sl_lldpe_five','Sleeve Lldpe Layer Five' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_hdpe_per_five'))){
                $this->form_validation->set_rules('sl_hdpe_five','Sleeve Hdpe Layer Five' ,'trim|xss_clean|required');
              }
               
            

            if($this->form_validation->run()==FALSE){
            $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
            $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
            $data['admer']=$this->article_model->spec_active_record_search('article','15',$this->session->userdata['logged_in']['company_id']);
            $data['evoh']=$this->article_model->spec_active_record_search('article','16',$this->session->userdata['logged_in']['company_id']);
            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

              

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-five-form',$data);
              $this->load->view('Home/footer');
            }else{

              if(!empty($this->input->post('sleeve_dia'))){
                $sleeve_dia=explode('//',$this->input->post('sleeve_dia'));
              }else{
                $sleeve_dia[0]='';
                $sleeve_dia[1]='';
              }

              if(!empty($this->input->post('sleeve_length'))){
                $sleeve_length="X".$this->input->post('sleeve_length')." 5 LAYER";
              }else{
                $sleeve_length='';
              }

              if(!empty($this->input->post('gauge'))){
                $gauge=$this->input->post('gauge')."MIC";
              }else{
                $gauge='';
              }

              if(!empty($this->input->post('sl_ldpe')) && !empty($this->input->post('sl_ldpe_per'))){

                $data['sl_ldpe']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_ldpe'));
                if($data['sl_ldpe']==FALSE){
                $sl_ldpe="";
                }else{
                foreach($data['sl_ldpe'] as $sl_ldpe_row){
                  $sl_ldpe=$sl_ldpe_row->article_name;
                  }
                }
                if(!empty($this->input->post('sl_ldpe_per')) && $this->input->post('sl_ldpe_per')!=0){
                  $sl_ldpe_per=$this->input->post('sl_ldpe_per')."%";
                }else{
                  $sl_ldpe_per="";
                }
                
              }else{
                $sl_ldpe='';
                $sl_ldpe_per='';
              }


              if(!empty($this->input->post('sl_lldpe')) && !empty($this->input->post('sl_lldpe_per'))){

                $data['sl_lldpe']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_lldpe'));
                if($data['sl_lldpe']==FALSE){
                $sl_lldpe="";
                }else{
                foreach($data['sl_lldpe'] as $sl_lldpe_row){
                  $sl_lldpe=$sl_lldpe_row->article_name;
                  }
                }

                if(!empty($this->input->post('sl_lldpe_per')) && $this->input->post('sl_lldpe_per')!=0){
                  $sl_lldpe_per=$this->input->post('sl_lldpe_per')."%";
                }else{
                  $sl_lldpe_per="";
                }

              }else{
                $sl_lldpe='';
                $sl_lldpe_per='';
              }

              if(!empty($this->input->post('sl_hdpe')) && !empty($this->input->post('sl_hdpe_per'))){

                $data['sl_hdpe']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_hdpe'));
                if($data['sl_hdpe']==FALSE){
                
                }else{
                foreach($data['sl_hdpe'] as $sl_hdpe_row){
                  $sl_hdpe=$sl_hdpe_row->article_name;
                  }
                }

                if(!empty($this->input->post('sl_hdpe_per')) && $this->input->post('sl_hdpe_per')!=0){
                  $sl_hdpe_per=$this->input->post('sl_hdpe_per')."%";
                }else{
                  $sl_hdpe_per="";
                }

              }else{
                $sl_hdpe='';
                $sl_hdpe_per='';
              }

              if(!empty($this->input->post('sl_masterbatch'))){
              $data['sl_masterbatch']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_masterbatch'));

                foreach($data['sl_masterbatch'] as $sl_masterbatch_row){
                  $sl_masterbatch=$sl_masterbatch_row->article_name;
                }

              }else{
                $sl_masterbatch="";
              }

              if($this->input->post('sl_mb_per')!=''){
                  $sl_mb_per=$this->input->post('sl_mb_per')."%";
              }else{
                $sl_mb_per="";
              }



              if(!empty($this->input->post('gauge_two'))){
                $gauge_two=$this->input->post('gauge_two')."MIC";
              }else{
                $gauge_two='';
              }

             if(!empty($this->input->post('sl_admer_two')) && !empty($this->input->post('sl_admer_per_two'))){

                $data['sl_admer_two']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_admer_two'));
                if($data['sl_admer_two']==FALSE){
                
                }else{
                foreach($data['sl_admer_two'] as $sl_admer_two_row){
                  $sl_admer_two=$sl_admer_two_row->article_name;
                  }
                }

                if(!empty($this->input->post('sl_admer_per_two')) && $this->input->post('sl_admer_per_two')!=0){
                  $sl_admer_per_two=$this->input->post('sl_admer_per_two')."%";
                }else{
                  $sl_admer_per_two="";
                }

              }else{
                $sl_admer_two='';
                $sl_admer_per_two='';
              }

              if(!empty($this->input->post('gauge_three'))){
                $gauge_three=$this->input->post('gauge_three')."MIC";
              }else{
                $gauge_three='';
              }

              if(!empty($this->input->post('sl_evoh_three')) && !empty($this->input->post('sl_evoh_per_three'))){

                $data['sl_evoh_three']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_evoh_three'));
                if($data['sl_evoh_three']==FALSE){
                $sl_evoh_three="";
                }else{
                foreach($data['sl_evoh_three'] as $sl_evoh_three_row){
                  $sl_evoh_three=$sl_evoh_three_row->article_name;
                  }
                }
                if(!empty($this->input->post('sl_evoh_per_three')) && $this->input->post('sl_evoh_per_three')!=0){
                  $sl_evoh_per_three=$this->input->post('sl_evoh_per_three')."%";
                }else{
                  $sl_evoh_per_three="";
                }
                
              }else{
                $sl_evoh_three='';
                $sl_evoh_per_three='';
              }



              if(!empty($this->input->post('gauge_four'))){
                $gauge_four=$this->input->post('gauge_four')."MIC";
              }else{
                $gauge_four='';
              }

             if(!empty($this->input->post('sl_admer_four')) && !empty($this->input->post('sl_admer_per_four'))){

                $data['sl_admer_four']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_admer_four'));
                if($data['sl_admer_four']==FALSE){
                
                }else{
                foreach($data['sl_admer_four'] as $sl_admer_four_row){
                  $sl_admer_four=$sl_admer_four_row->article_name;
                  }
                }

                if(!empty($this->input->post('sl_admer_per_four')) && $this->input->post('sl_admer_per_four')!=0){
                  $sl_admer_per_four=$this->input->post('sl_admer_per_four')."%";
                }else{
                  $sl_admer_per_four="";
                }

              }else{
                $sl_admer_four='';
                $sl_admer_per_four='';
              }


              if(!empty($this->input->post('gauge_five'))){
                $gauge_five=$this->input->post('gauge_five')."MIC";
              }else{
                $gauge_five='';
              }

              if(!empty($this->input->post('sl_ldpe_five')) && !empty($this->input->post('sl_ldpe_per_five'))){

                $data['sl_ldpe_five']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_ldpe_five'));
                if($data['sl_ldpe_five']==FALSE){
                $sl_ldpe_five="";
                }else{
                foreach($data['sl_ldpe_five'] as $sl_ldpe_five_row){
                  $sl_ldpe_five=$sl_ldpe_five_row->article_name;
                  }
                }
                if(!empty($this->input->post('sl_ldpe_per_five')) && $this->input->post('sl_ldpe_per_five')!=0){
                  $sl_ldpe_per_five=$this->input->post('sl_ldpe_per_five')."%";
                }else{
                  $sl_ldpe_per_five="";
                }
                
              }else{
                $sl_ldpe_five='';
                $sl_ldpe_per_five='';
              }


              if(!empty($this->input->post('sl_lldpe_five')) && !empty($this->input->post('sl_lldpe_per_five'))){

                $data['sl_lldpe_five']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_lldpe_five'));
                if($data['sl_lldpe_five']==FALSE){
                $sl_lldpe_five="";
                }else{
                foreach($data['sl_lldpe_five'] as $sl_lldpe_five_row){
                  $sl_lldpe_five=$sl_lldpe_five_row->article_name;
                  }
                }

                if(!empty($this->input->post('sl_lldpe_per_five')) && $this->input->post('sl_lldpe_per_five')!=0){
                  $sl_lldpe_per_five=$this->input->post('sl_lldpe_per_five')."%";
                }else{
                  $sl_lldpe_per_five="";
                }

              }else{
                $sl_lldpe_five='';
                $sl_lldpe_per_five='';
              }

              if(!empty($this->input->post('sl_hdpe_five')) && !empty($this->input->post('sl_hdpe_per_five'))){

                $data['sl_hdpe_five']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_hdpe_five'));
                if($data['sl_hdpe_five']==FALSE){
                
                }else{
                foreach($data['sl_hdpe_five'] as $sl_hdpe_five_row){
                  $sl_hdpe_five=$sl_hdpe_five_row->article_name;
                  }
                }

                if(!empty($this->input->post('sl_hdpe_per_five')) && $this->input->post('sl_hdpe_per_five')!=0){
                  $sl_hdpe_per_five=$this->input->post('sl_hdpe_per_five')."%";
                }else{
                  $sl_hdpe_per_five="";
                }

              }else{
                $sl_hdpe_five='';
                $sl_hdpe_per_five='';
              }

              if(!empty($this->input->post('sl_masterbatch_five'))){
              $data['sl_masterbatch_five']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_masterbatch_five'));

                foreach($data['sl_masterbatch_five'] as $sl_masterbatch_five_row){
                  $sl_masterbatch_five=$sl_masterbatch_five_row->article_name;
                }
              }else{
                $sl_masterbatch_five="";
              }




                if($this->input->post('sl_mb_per_five')!=''){
                  $sl_mb_per_five=$this->input->post('sl_mb_per_five')."%";
                }else{
                  $sl_mb_per_five="";
                }


              

              

              $article_description=$sleeve_dia[0]."".$sleeve_length." ".$gauge." ".$sl_masterbatch." ".$sl_mb_per." ".$sl_ldpe." ".$sl_ldpe_per." ".$sl_lldpe." ".$sl_lldpe_per." ".$sl_hdpe." ".$sl_hdpe_per." ".$gauge_two." ".$sl_admer_two." ".$sl_admer_per_two." ".$gauge_three." ".$sl_evoh_three." ".$sl_evoh_per_three." ".$gauge_four." ".$sl_admer_four." ".$sl_admer_per_four." ".$gauge_five." ".$sl_masterbatch_five." ".$sl_mb_per_five." ".$sl_ldpe_five." ".$sl_ldpe_per_five." ".$sl_lldpe_five." ".$sl_lldpe_per_five." ".$sl_hdpe_five." ".$sl_hdpe_per_five;

              $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article_name_info.lang_article_description',$article_description);

                      if($data['article']==FALSE){

                        $article_no=$this->main_group_article($this->input->post('main_group'));

                        $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                              'main_group_id'=>$this->input->post('main_group'),
                              'article_group_id'=>'999999999999999',
                              'sub_sub_grp_id'=>'999999999999999',
                              'article_no'=>$article_no,
                              'uom'=>'UOM001',
                              'sales_purchase_flag'=>'2',
                              'spec_item_flag'=>'1',
                              'archive'=>'0',
                              'article_date'=>date('Y-m-d'), 
                              'article_modified_date'=>date('Y-m-d')
                            );

                        $result=$this->common_model->save('article',$data);

                        $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                              'language_id'=>$this->session->userdata['logged_in']['language_id'],
                              'article_no'=>$article_no,
                              'lang_article_description'=>$article_description,
                              'lang_sub_description'=>'',
                              'main_group_id'=>$this->input->post('main_group'),
                              'article_group_id'=>'999999999999999',
                              'sub_sub_grp_id'=>'999999999999999');

                        $result=$this->common_model->save('article_name_info',$data);

                        $data['auto']=$this->common_model->select_one_active_record_nonlanguage_without_archive('autogeneration_format_master',$this->session->userdata['logged_in']['company_id'],'form_id','1242');
                        $no="";
                        foreach ($data['auto'] as $auto_row) {

                          $data['account_periods']=$this->common_model->select_one_active_record_nonlanguage_without_archive('account_periods_master',$this->session->userdata['logged_in']['company_id'],'finyear_close_opt','0');
                          foreach($data['account_periods'] as $account_periods_row){
                            $start=date('y', strtotime($account_periods_row->fin_year_start));
                            $end=date('y', strtotime($account_periods_row->fin_year_end));
                          }
                          $no=str_pad($auto_row->curr_val,4,"0",STR_PAD_LEFT);
                          $spec_no=$auto_row->textcode.$no;
                          $next_spec_no=$auto_row->curr_val+1;
                        }
                        $data=array('curr_val'=>$next_spec_no);
                        $this->common_model->update_one_active_record('autogeneration_format_master',$data,'form_id','1242',$this->session->userdata['logged_in']['company_id']);
                        $spec_version_no='1';

                        $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                              'spec_id'=>$spec_no,
                              'spec_created_date'=>date('Y-m-d'),
                              'spec_version_no'=>$spec_version_no,
                              'adr_company_id'=>'',
                              'article_no'=>$article_no,
                              'pending_flag'=>'0',
                              'final_approval_flag'=>'0',
                              'user_id'=>$this->session->userdata['logged_in']['user_id'],
                              'dyn_qty_present'=>'SLEEVE|5',
                              );

                        $result=$this->common_model->save('specification_sheet',$data);


                        

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'164',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DIA',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$sleeve_dia[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_1',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'165',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LENGTH',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('sleeve_length'),
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_2',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'166',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DRAWING',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_3',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'167',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'GUAGE',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('gauge'),
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_4',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'168',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'material'=>'1',
                'item_group_material'=>'12',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_mb_per'),
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_masterbatch'),
                'srd_id'=>'1_5_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
            

              

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LDPE',
                'material'=>'1',
                'item_group_material'=>'7',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_ldpe_per'),
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_ldpe'),
                'srd_id'=>'1_6_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

            

              
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LLDPE',
                'material'=>'1',
                'item_group_material'=>'8',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_lldpe_per'),
                'mat_article_no'=>$this->input->post('sl_lldpe'),
                'property_id'=>'',
                'srd_id'=>'1_6_1',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
            

            

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'HDPE',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_hdpe_per'),
                'mat_article_no'=>$this->input->post('sl_hdpe'),
                'property_id'=>'',
                'srd_id'=>'1_6_2',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'167',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'GUAGE',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('gauge_two'),
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_4',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'ADMER',
                'material'=>'1',
                'item_group_material'=>'15',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_admer_per_two'),
                'mat_article_no'=>$this->input->post('sl_admer_two'),
                'property_id'=>'',
                'srd_id'=>'2_6_4',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);
            

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'167',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'GUAGE',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('gauge_three'),
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_4',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'168',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'EVOH',
                'material'=>'1',
                'item_group_material'=>'16',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_evoh_per_three'),
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_evoh_three'),
                'srd_id'=>'3_6_3',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'167',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'GUAGE',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('gauge_four'),
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'4_4',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'4',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'4');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'ADMER',
                'material'=>'1',
                'item_group_material'=>'15',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_admer_per_four'),
                'mat_article_no'=>$this->input->post('sl_admer_four'),
                'property_id'=>'',
                'srd_id'=>'4_6_4',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'4',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'4');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'167',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'GUAGE',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('gauge_five'),
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'5_4',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'5');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'168',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'material'=>'1',
                'item_group_material'=>'12',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_mb_per_five'),
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_masterbatch_five'),
                'srd_id'=>'5_5_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'5');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LDPE',
                'material'=>'1',
                'item_group_material'=>'7',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_ldpe_per_five'),
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_ldpe_five'),
                'srd_id'=>'5_6_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'5');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LLDPE',
                'material'=>'1',
                'item_group_material'=>'8',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_lldpe_per_five'),
                'mat_article_no'=>$this->input->post('sl_lldpe_five'),
                'property_id'=>'',
                'srd_id'=>'5_6_1',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'5');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'HDPE',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_hdpe_per_five'),
                'mat_article_no'=>$this->input->post('sl_hdpe_five'),
                'property_id'=>'',
                'srd_id'=>'5_6_2',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'5');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'spec_id'=>$spec_no,
                        'lang_comments'=>$this->input->post('comment'),
                        'language_id'=>$this->session->userdata['logged_in']['language_id'],
                        'spec_version_no'=>$spec_version_no);
              $result=$this->common_model->save('specification_sheet_lang',$data);

              $data['note']='Create Transaction Completed';
              //header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

               if(!empty($this->input->post('approval_authority'))){

                    $data=array('pending_flag'=>'1');

                    $result=$this->sleeve_specification_model->update_one_active_record('specification_sheet',$data,'spec_id',$spec_no,'spec_version_no',$spec_version_no,$this->session->userdata['logged_in']['company_id']);

                    $data['followup']=$this->common_model->select_one_active_record_nonlanguage_without_archive('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$spec_no.'@@@'.$spec_version_no);
                      if($data['followup']==FALSE){
                        $transaction_no=1;
                        $status=1;
                      }else{
                        $i=1;
                        foreach ($data['followup'] as $followup_row) {

                          $transaction_no=$followup_row->transaction_no;
                          $status=1;
                          $i++;
                        }
                        $transaction_no=$i;
                      }

                      $data=array(
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'user_id'=>$this->input->post('approval_authority'),
                        'form_id'=>'985',
                        'transaction_no'=>$transaction_no,
                        'status'=>$status,
                        'followup_date'=>date('Y-m-d'),
                        'contact_person_id'=>$this->session->userdata['logged_in']['user_id'],
                        'record_no'=>$spec_no.'@@@'.$spec_version_no);

                      $result=$this->common_model->save('followup',$data);
                      $data['note']='Create Transaction Completed';
                      $data['error']='Sent For Approval';
                      header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                  }

            }else{
             $data['error']='Same Sleeve alerdy Exist';
          }

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
              
              
                  $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);

                  $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                  $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
                  $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
                  $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
                  $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                  $data['admer']=$this->article_model->spec_active_record_search('article','15',$this->session->userdata['logged_in']['company_id']);
                  $data['evoh']=$this->article_model->spec_active_record_search('article','16',$this->session->userdata['logged_in']['company_id']);
                  $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                  $this->load->view(ucwords($this->router->fetch_class()).'/create-five-form',$data);
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
  

  public function customer_check($str){
    if(!empty($str)){
    $customer_code=explode('//',$str);
    if(!empty($customer_code[1])){
    $data['customer']=$this->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'name1',$customer_code[0]);
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

 

 
  public function supplier_check($str){
    $supplier_code=explode('//',$str);
    if(!empty($supplier_code[1])){
    $data['supplier']=$this->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'name1',$supplier_code[0]);
    foreach ($data['supplier'] as $supplier_row) {

      if ($supplier_row->adr_company_id == $supplier_code[1]){
        return TRUE;
      }else{
        $this->form_validation->set_message('supplier_check', 'The {field} field is incorrect');
        return FALSE;
        }
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



  function archive_records(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->delete==1){
            $table='specification_sheet';
            include('pagination-archive-cap.php');
            $data['specification']=$this->tube_specification_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
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


  

  function modify_single_layer(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){

            $data['specification']=$this->sleeve_specification_model->select_one_active_unapproved_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->uri->segment(3),'specification_sheet.spec_version_no',$this->uri->segment(4),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
            $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
            $this->load->view(ucwords($this->router->fetch_class()).'/modify-single-form',$data);
            $this->load->view('Home/footer');

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



  function modify_two_layer(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){

            $data['specification']=$this->sleeve_specification_model->select_one_active_unapproved_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->uri->segment(3),'specification_sheet.spec_version_no',$this->uri->segment(4),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
            $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
            $this->load->view(ucwords($this->router->fetch_class()).'/modify-two-form',$data);
            $this->load->view('Home/footer');

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


  function modify_three_layer(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){

            $data['specification']=$this->sleeve_specification_model->select_one_active_unapproved_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->uri->segment(3),'specification_sheet.spec_version_no',$this->uri->segment(4),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
            $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
            $this->load->view(ucwords($this->router->fetch_class()).'/modify-three-form',$data);
            $this->load->view('Home/footer');

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


  function modify_five_layer(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){

            $data['specification']=$this->sleeve_specification_model->select_one_active_unapproved_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->uri->segment(3),'specification_sheet.spec_version_no',$this->uri->segment(4),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
            $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
            $data['admer']=$this->article_model->spec_active_record_search('article','15',$this->session->userdata['logged_in']['company_id']);
            $data['evoh']=$this->article_model->spec_active_record_search('article','16',$this->session->userdata['logged_in']['company_id']);
            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
            $this->load->view(ucwords($this->router->fetch_class()).'/modify-five-form',$data);
            $this->load->view('Home/footer');

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


  function update_single_layer(){
      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){

            //$this->form_validation->set_rules('main_group','Main Group' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('article_no','Article No' ,'required|trim|xss_clean|max_length[20]');
            
            $this->form_validation->set_rules('sleeve_dia','Sleeve Dia' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sleeve_length','Sleeve Length' ,'required|trim|xss_clean|max_length[5]');

            $this->form_validation->set_rules('gauge','Gauge' ,'required|trim|xss_clean|exact_length[3]|in_list[400,500,550,350]');
            $this->form_validation->set_rules('sl_masterbatch','Sleeve Masterbatch' ,'required|trim|xss_clean');
            //$this->form_validation->set_rules('sl_mb_supplier','Sleeve Masterbatch Supplier','trim|xss_clean|callback_supplier_check');
            $this->form_validation->set_rules('sl_mb_per','Sleeve Masterbatch %' ,'required|trim|xss_clean|numeric|less_than_equal_to[25]|max_length[4]');
            
            
            if($this->input->post('sl_masterbatch')=='RM-MB-TRA-0007'){
            $this->form_validation->set_rules('sl_mb_per','Sleeve Masterbatch %' ,'required|trim|xss_clean|numeric|less_than[1]');
            }

            if($this->input->post('sleeve_dia')){
            $sleeve_dia=explode('//',$this->input->post('sleeve_dia'));
              if($sleeve_dia[0]=="19 MM" || $sleeve_dia[0]=="22 MM" || $sleeve_dia[0]=="22.6 MM" ){
                $this->form_validation->set_rules('gauge','Gauge' ,'required|trim|xss_clean|in_list[400]');
              }else if($sleeve_dia[0]=="25 MM" || $sleeve_dia[0]=="30 MM" ||  $sleeve_dia[0]=="35 MM" || $sleeve_dia[0]=="40 MM"){
                $this->form_validation->set_rules('gauge','Gauge' ,'required|trim|xss_clean|in_list[500]');
              }else{
                $this->form_validation->set_rules('gauge','Gauge' ,'required|trim|xss_clean|in_list[550,350]');
              }
            }

            $this->form_validation->set_rules('sl_ldpe_per','Sleeve Ldpe %' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_check');
            $this->form_validation->set_rules('sl_lldpe_per','Sleeve Lldpe %' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_check');
            $this->form_validation->set_rules('sl_hdpe_per','Sleeve Hdpe %' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_check');

            if(!empty($this->input->post('sl_ldpe_per'))){
              $this->form_validation->set_rules('sl_ldpe','Sleeve Ldpe' ,'trim|xss_clean|required|in_list[RM-LDPE-000-0009]');
            }if(!empty($this->input->post('sl_lldpe_per'))){
              $this->form_validation->set_rules('sl_lldpe','Sleeve Lldpe' ,'trim|xss_clean|required');
            }if(!empty($this->input->post('sl_hdpe_per'))){
              $this->form_validation->set_rules('sl_hdpe','Sleeve Hdpe' ,'trim|xss_clean|required');
            }
            
              

              if($this->form_validation->run()==FALSE){

                $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);

                $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
                $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
                $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
                $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');
                $data['specification']=$this->tube_specification_model->select_one_active_unapproved_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->input->post('spec_id'),'specification_sheet.spec_version_no',$this->input->post('spec_version_no'),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);
                
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/modify-single-form',$data);
                $this->load->view('Home/footer');

              }else{

                if(!empty($this->input->post('sleeve_dia'))){
                  $sleeve_dia=explode('//',$this->input->post('sleeve_dia'));
                }else{
                  $sleeve_dia[0]='';
                  $sleeve_dia[1]='';
                }

                if(!empty($this->input->post('sleeve_length'))){
                  $sleeve_length="X".$this->input->post('sleeve_length')." 1 LAYER";
                }else{
                  $sleeve_length='';
                }

                if(!empty($this->input->post('gauge'))){
                  $gauge=$this->input->post('gauge')."MIC";
                }else{
                  $gauge='';
                }

                if(!empty($this->input->post('sl_ldpe')) && !empty($this->input->post('sl_ldpe_per'))){

                  $data['sl_ldpe']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_ldpe'));
                  if($data['sl_ldpe']==FALSE){
                  $sl_ldpe="";
                  }else{
                  foreach($data['sl_ldpe'] as $sl_ldpe_row){
                    $sl_ldpe=$sl_ldpe_row->article_name;
                  }
                  }
                  $sl_ldpe_per=$this->input->post('sl_ldpe_per')."%";
                }else{
                  $sl_ldpe='';
                  $sl_ldpe_per='';
                }


                if(!empty($this->input->post('sl_lldpe')) && !empty($this->input->post('sl_lldpe_per'))){

                  $data['sl_lldpe']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_lldpe'));
                  if($data['sl_lldpe']==FALSE){
                  $sl_lldpe="";
                  }else{
                  foreach($data['sl_lldpe'] as $sl_lldpe_row){
                    $sl_lldpe=$sl_lldpe_row->article_name;
                  }
                  }
                  $sl_lldpe_per=$this->input->post('sl_lldpe_per')."%";
                }else{
                  $sl_lldpe='';
                  $sl_lldpe_per='';
                }


                if(!empty($this->input->post('sl_hdpe')) && !empty($this->input->post('sl_hdpe_per'))){

                  $data['sl_hdpe']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_hdpe'));
                  if($data['sl_hdpe']==FALSE){
                  $sl_hdpe="";
                  }else{
                  foreach($data['sl_hdpe'] as $sl_hdpe_row){
                    $sl_hdpe=$sl_hdpe_row->article_name;
                  }
                  }
                  $sl_hdpe_per=$this->input->post('sl_hdpe_per')."%";
                }else{
                  $sl_hdpe='';
                  $sl_hdpe_per='';
                }

                if(!empty($this->input->post('sl_masterbatch'))){
                $data['sl_masterbatch']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_masterbatch'));

                  foreach($data['sl_masterbatch'] as $sl_masterbatch_row){
                    $sl_masterbatch=$sl_masterbatch_row->article_name;
                  }
                  
                }else{
                  $sl_masterbatch="";
                  
                }

                if($this->input->post('sl_mb_per')!=''){
                  $sl_mb_per=$this->input->post('sl_mb_per')."%";
                }else{
                  $sl_mb_per="";
                }

              $article_description=$sleeve_dia[0]."".$sleeve_length." ".$gauge." ".$sl_masterbatch." ".$sl_mb_per." ".$sl_ldpe." ".$sl_ldpe_per." ".$sl_lldpe." ".$sl_lldpe_per." ".$sl_hdpe." ".$sl_hdpe_per;

              $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article_name_info.lang_article_description',$article_description);

                if($data['article']==FALSE){

                  $data=array('lang_article_description'=>$article_description);

                  $result=$this->common_model->update_one_active_record('article_name_info',$data,'article_no',$this->input->post('article_no'),$this->session->userdata['logged_in']['company_id']);

                  $data_article=array('article_modified_date'=>date('Y-m-d'));
                  $result=$this->common_model->update_one_active_record('article',$data_article,'article_no',$this->input->post('article_no'),$this->session->userdata['logged_in']['company_id']);
                  
                  $data=array('relating_master_value'=>$sleeve_dia[0]);

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_1',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('sleeve_length'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_2',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('gauge'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_4',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_masterbatch'),'mat_info'=>$this->input->post('sl_mb_per'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_5_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_ldpe'),'mat_info'=>$this->input->post('sl_ldpe_per'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_6_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_lldpe'),'mat_info'=>$this->input->post('sl_lldpe_per'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_6_1',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_hdpe'),'mat_info'=>$this->input->post('sl_hdpe_per'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_6_2',$this->session->userdata['logged_in']['company_id']);

                  if(!empty($this->input->post('approval_authority'))){

                    $data=array('pending_flag'=>'1');

                    $result=$this->sleeve_specification_model->update_one_active_record('specification_sheet',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),$this->session->userdata['logged_in']['company_id']);

                    $data['followup']=$this->common_model->select_one_active_record_nonlanguage_without_archive('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$this->input->post('record_no'));
                      if($data['followup']==FALSE){
                        $transaction_no=1;
                        $status=1;
                      }else{
                        $i=1;
                        foreach ($data['followup'] as $followup_row) {

                          $transaction_no=$followup_row->transaction_no;
                          $status=1;
                          $i++;
                        }
                        $transaction_no=$i;
                      }

                      $data=array(
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'user_id'=>$this->input->post('approval_authority'),
                        'form_id'=>'985',
                        'transaction_no'=>$transaction_no,
                        'status'=>$status,
                        'followup_date'=>date('Y-m-d'),
                        'contact_person_id'=>$this->session->userdata['logged_in']['user_id'],
                        'record_no'=>$this->input->post('record_no'));

                      $result=$this->common_model->save('followup',$data);
                  }

                  $data['note']='Update Transaction Completed';
                  header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                  }else{
                  $data['error']='No change in Sleeve component, It is exist, It is exist';

                  if(!empty($this->input->post('approval_authority'))){

                    $data=array('pending_flag'=>'1');

                    $result=$this->sleeve_specification_model->update_one_active_record('specification_sheet',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),$this->session->userdata['logged_in']['company_id']);

                    $data['followup']=$this->common_model->select_one_active_record_nonlanguage_without_archive('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$this->input->post('record_no'));
                      if($data['followup']==FALSE){
                        $transaction_no=1;
                        $status=1;
                      }else{
                        $i=1;
                        foreach ($data['followup'] as $followup_row) {

                          $transaction_no=$followup_row->transaction_no;
                          $status=1;
                          $i++;
                        }
                        $transaction_no=$i;
                      }

                      $data=array(
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'user_id'=>$this->input->post('approval_authority'),
                        'form_id'=>'985',
                        'transaction_no'=>$transaction_no,
                        'status'=>$status,
                        'followup_date'=>date('Y-m-d'),
                        'contact_person_id'=>$this->session->userdata['logged_in']['user_id'],
                        'record_no'=>$this->input->post('record_no'));

                      $result=$this->common_model->save('followup',$data);

                      $data['note']='Sent for approval';
                      //header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                  }
                }


                $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
                $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
                $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
                $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');
                
                $data['specification']=$this->sleeve_specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->input->post('spec_id'),'specification_sheet.spec_version_no',$this->input->post('spec_version_no'),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);
                  
                  $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');
                  $data['page_name']='Sales';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                  $this->load->view(ucwords($this->router->fetch_class()).'/modify-single-form',$data);
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


  function update_two_layer(){
      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){

            //$this->form_validation->set_rules('main_group','Main Group' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('article_no','Article No' ,'required|trim|xss_clean|max_length[20]');
            
            $this->form_validation->set_rules('sleeve_dia','Sleeve Dia' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sleeve_length','Sleeve Length' ,'required|trim|xss_clean|max_length[5]');
            $this->form_validation->set_rules('gauge','Gauge' ,'required|trim|xss_clean|max_length[3]');
            $this->form_validation->set_rules('sl_masterbatch','Sleeve Masterbatch' ,'required|trim|xss_clean');
            //$this->form_validation->set_rules('sl_mb_supplier','Sleeve Masterbatch Supplier','trim|xss_clean|callback_supplier_check');
            $this->form_validation->set_rules('sl_mb_per','Sleeve Masterbatch %' ,'required|trim|xss_clean|numeric|less_than_equal_to[25]|max_length[4]');
            if($this->input->post('sl_masterbatch')=='RM-MB-TRA-0007'){
            $this->form_validation->set_rules('sl_mb_per','Sleeve Masterbatch %' ,'required|trim|xss_clean|numeric|less_than[1]');
            }

            /*

            if($this->input->post('sleeve_dia')){
            $sleeve_dia=explode('//',$this->input->post('sleeve_dia'));
              if($sleeve_dia[0]=="19 MM"){
                $this->form_validation->set_rules('gauge','Gauge' ,'required|trim|xss_clean|in_list[200]');
              }else if($sleeve_dia[0]=="25 MM" || $sleeve_dia[0]=="30 MM" ||  $sleeve_dia[0]=="35 MM" || $sleeve_dia[0]=="40 MM"){
                $this->form_validation->set_rules('gauge','Gauge' ,'required|trim|xss_clean|in_list[250]');
              }else{
                $this->form_validation->set_rules('gauge','Gauge' ,'required|trim|xss_clean|in_list[275]');
              }
            }
              */

            $this->form_validation->set_rules('sl_ldpe_per','Sleeve Ldpe %' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_check');
            $this->form_validation->set_rules('sl_lldpe_per','Sleeve Lldpe %' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_check');
            $this->form_validation->set_rules('sl_hdpe_per','Sleeve Hdpe %' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_check');

            if(!empty($this->input->post('sl_ldpe_per'))){
              $this->form_validation->set_rules('sl_ldpe','Sleeve Ldpe' ,'trim|xss_clean|required|in_list[RM-LDPE-000-0009]');
            }if(!empty($this->input->post('sl_lldpe_per'))){
              $this->form_validation->set_rules('sl_lldpe','Sleeve Lldpe' ,'trim|xss_clean|required');
            }if(!empty($this->input->post('sl_hdpe_per'))){
              $this->form_validation->set_rules('sl_hdpe','Sleeve Hdpe' ,'trim|xss_clean|required');
            }

            $this->form_validation->set_rules('gauge_two','Gauge Layer Two' ,'required|trim|xss_clean|max_length[3]');

            if($this->input->post('sl_masterbatch_two')=='RM-MB-TRA-0007'){
              $this->form_validation->set_rules('sl_mb_per_two','Sleeve Masterbatch % Layer Two' ,'required|trim|xss_clean|numeric|less_than[1]');
            }
            if($this->input->post('sl_masterbatch_two')){
              $this->form_validation->set_rules('sl_mb_per_two','Sleeve Masterbatch % Layer Two' ,'required|trim|xss_clean|numeric|less_than_equal_to[25]|max_length[4]');
            }
            
            /*
            if($this->input->post('sleeve_dia')){
            $sleeve_dia=explode('//',$this->input->post('sleeve_dia'));
              if($sleeve_dia[0]=="19 MM"){
                $this->form_validation->set_rules('gauge_two','Gauge Layer Two' ,'required|trim|xss_clean|in_list[200]');
              }else if($sleeve_dia[0]=="25 MM" || $sleeve_dia[0]=="30 MM" ||  $sleeve_dia[0]=="35 MM" || $sleeve_dia[0]=="40 MM"){
                $this->form_validation->set_rules('gauge_two','Gauge Layer Two' ,'required|trim|xss_clean|in_list[250]');
              }else{
                $this->form_validation->set_rules('gauge_two','Gauge Layer Two' ,'required|trim|xss_clean|in_list[275]');
              }
            }*/

            $this->form_validation->set_rules('sl_ldpe_per_two','Sleeve Ldpe % Layer Two' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_two_check');
            $this->form_validation->set_rules('sl_lldpe_per_two','Sleeve Lldpe % Layer Two' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_two_check');
            $this->form_validation->set_rules('sl_hdpe_per_two','Sleeve Hdpe % Layer Two' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_two_check');

              if(!empty($this->input->post('sl_ldpe_per_two'))){
                $this->form_validation->set_rules('sl_ldpe_two','Sleeve Ldpe Layer Two' ,'trim|xss_clean|required|in_list[RM-LDPE-000-0009]');
              }if(!empty($this->input->post('sl_lldpe_per'))){
                $this->form_validation->set_rules('sl_lldpe_two','Sleeve Lldpe Layer Two' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_hdpe_per'))){
                $this->form_validation->set_rules('sl_hdpe_two','Sleeve Hdpe Layer Two' ,'trim|xss_clean|required');
              }
            
              

              if($this->form_validation->run()==FALSE){

                $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);

                $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
                $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
                $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
                $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');
                $data['specification']=$this->tube_specification_model->select_one_active_unapproved_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->input->post('spec_id'),'specification_sheet.spec_version_no',$this->input->post('spec_version_no'),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);
                
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/modify-two-form',$data);
                $this->load->view('Home/footer');

              }else{

                if(!empty($this->input->post('sleeve_dia'))){
                  $sleeve_dia=explode('//',$this->input->post('sleeve_dia'));
                }else{
                  $sleeve_dia[0]='';
                  $sleeve_dia[1]='';
                }

                if(!empty($this->input->post('sleeve_length'))){
                  $sleeve_length="X".$this->input->post('sleeve_length')." 2 LAYER";
                }else{
                  $sleeve_length='';
                }
                

                if(!empty($this->input->post('gauge'))){
                  $gauge=$this->input->post('gauge')."MIC";
                }else{
                  $gauge='';
                }

                if(!empty($this->input->post('sl_ldpe')) && !empty($this->input->post('sl_ldpe_per'))){

                  $data['sl_ldpe']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_ldpe'));
                  if($data['sl_ldpe']==FALSE){
                  $sl_ldpe="";
                  }else{
                  foreach($data['sl_ldpe'] as $sl_ldpe_row){
                    $sl_ldpe=$sl_ldpe_row->article_name;
                    }
                  }
                  if(!empty($this->input->post('sl_ldpe_per')) && $this->input->post('sl_ldpe_per')!=0){
                    $sl_ldpe_per=$this->input->post('sl_ldpe_per')."%";
                  }else{
                    $sl_ldpe_per="";
                  }
                  
                }else{
                  $sl_ldpe='';
                  $sl_ldpe_per='';
                }


                if(!empty($this->input->post('sl_lldpe')) && !empty($this->input->post('sl_lldpe_per'))){

                  $data['sl_lldpe']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_lldpe'));
                  if($data['sl_lldpe']==FALSE){
                  $sl_lldpe="";
                  }else{
                  foreach($data['sl_lldpe'] as $sl_lldpe_row){
                    $sl_lldpe=$sl_lldpe_row->article_name;
                    }
                  }

                  if(!empty($this->input->post('sl_lldpe_per')) && $this->input->post('sl_lldpe_per')!=0){
                    $sl_lldpe_per=$this->input->post('sl_lldpe_per')."%";
                  }else{
                    $sl_lldpe_per="";
                  }

                }else{
                  $sl_lldpe='';
                  $sl_lldpe_per='';
                }

                if(!empty($this->input->post('sl_hdpe')) && !empty($this->input->post('sl_hdpe_per'))){

                  $data['sl_hdpe']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_hdpe'));
                  if($data['sl_hdpe']==FALSE){
                  
                  }else{
                  foreach($data['sl_hdpe'] as $sl_hdpe_row){
                    $sl_hdpe=$sl_hdpe_row->article_name;
                    }
                  }

                  if(!empty($this->input->post('sl_hdpe_per')) && $this->input->post('sl_hdpe_per')!=0){
                    $sl_hdpe_per=$this->input->post('sl_hdpe_per')."%";
                  }else{
                    $sl_hdpe_per="";
                  }

                }else{
                  $sl_hdpe='';
                  $sl_hdpe_per='';
                }

                if(!empty($this->input->post('sl_masterbatch'))){
                $data['sl_masterbatch']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_masterbatch'));

                  foreach($data['sl_masterbatch'] as $sl_masterbatch_row){
                    $sl_masterbatch=$sl_masterbatch_row->article_name;
                  }
                }else{
                  $sl_masterbatch="";
                  
                }

                 if($this->input->post('sl_mb_per')!=''){
                    $sl_mb_per=$this->input->post('sl_mb_per')."%";
                  }else{
                    $sl_mb_per="";
                  }


                if(!empty($this->input->post('gauge_two'))){
                  $gauge_two=$this->input->post('gauge_two')."MIC";
                }else{
                  $gauge_two='';
                }

               
                if(!empty($this->input->post('sl_ldpe_two')) && !empty($this->input->post('sl_ldpe_per_two'))){

                  $data['sl_ldpe_two']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_ldpe_two'));
                  if($data['sl_ldpe_two']==FALSE){
                  
                  }else{
                  foreach($data['sl_ldpe_two'] as $sl_ldpe_two_row){
                    $sl_ldpe_two=$sl_ldpe_two_row->article_name;
                    }
                  }

                  if(!empty($this->input->post('sl_ldpe_per_two')) && $this->input->post('sl_ldpe_per_two')!=0){
                    $sl_ldpe_per_two=$this->input->post('sl_ldpe_per_two')."%";
                  }else{
                    $sl_ldpe_per_two="";
                  }

                }else{
                  $sl_ldpe_two='';
                  $sl_ldpe_per_two='';
                }


                if(!empty($this->input->post('sl_lldpe_two')) && !empty($this->input->post('sl_lldpe_per_two'))){

                  $data['sl_lldpe_two']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_lldpe_two'));
                  if($data['sl_lldpe_two']==FALSE){
                  
                  }else{
                  foreach($data['sl_lldpe_two'] as $sl_lldpe_two_row){
                    $sl_lldpe_two=$sl_lldpe_two_row->article_name;
                    }
                  }

                  if(!empty($this->input->post('sl_lldpe_per_two')) && $this->input->post('sl_lldpe_per_two')!=0){
                    $sl_lldpe_per_two=$this->input->post('sl_lldpe_per_two')."%";
                  }else{
                    $sl_lldpe_per_two="";
                  }

                }else{
                  $sl_lldpe_two='';
                  $sl_lldpe_per_two='';
                }


                if(!empty($this->input->post('sl_hdpe_two')) && !empty($this->input->post('sl_hdpe_two_per'))){

                  $data['sl_hdpe_two']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_hdpe_two'));
                  if($data['sl_hdpe_two']==FALSE){
                  
                  }else{
                  foreach($data['sl_hdpe_two'] as $sl_hdpe_two_row){
                    $sl_hdpe_two=$sl_hdpe_two_row->article_name;
                    }
                  }

                  if(!empty($this->input->post('sl_hdpe_per_two')) && $this->input->post('sl_hdpe_per_two')!=0){
                    $sl_hdpe_per_two=$this->input->post('sl_hdpe_per_two')."%";
                  }else{
                    $sl_hdpe_per_two="";
                  }

                }else{
                  $sl_hdpe_two='';
                  $sl_hdpe_per_two='';
                }

                if(!empty($this->input->post('sl_masterbatch_two'))){
                $data['sl_masterbatch_two']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_masterbatch_two'));

                  foreach($data['sl_masterbatch_two'] as $sl_masterbatch_two_row){
                    $sl_masterbatch_two=$sl_masterbatch_two_row->article_name;
                  }

                }else{
                  $sl_masterbatch_two="";
                }

                if($this->input->post('sl_mb_per_two')!=''){
                    $sl_mb_per_two=$this->input->post('sl_mb_per_two')."%";
                  }else{
                    $sl_mb_per_two="";
                  }

                $article_description=$sleeve_dia[0]."".$sleeve_length." ".$gauge." ".$sl_masterbatch." ".$sl_mb_per." ".$sl_ldpe." ".$sl_ldpe_per." ".$sl_lldpe." ".$sl_lldpe_per." ".$sl_hdpe." ".$sl_hdpe_per." ".$gauge_two." ".$sl_masterbatch_two." ".$sl_mb_per_two." ".$sl_ldpe_two." ".$sl_ldpe_per_two." ".$sl_lldpe_two." ".$sl_lldpe_per_two." ".$sl_hdpe_two." ".$sl_hdpe_per_two;
                

              $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article_name_info.lang_article_description',$article_description);

                if($data['article']==FALSE){

                  $data=array('lang_article_description'=>$article_description);

                  $result=$this->common_model->update_one_active_record('article_name_info',$data,'article_no',$this->input->post('article_no'),$this->session->userdata['logged_in']['company_id']);

                  $data_article=array('article_modified_date'=>date('Y-m-d'));

                  $result=$this->common_model->update_one_active_record('article',$data_article,'article_no',$this->input->post('article_no'),$this->session->userdata['logged_in']['company_id']);
                  
                  $data=array('relating_master_value'=>$sleeve_dia[0]);

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_1',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('sleeve_length'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_2',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('gauge'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_4',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_masterbatch'),'mat_info'=>$this->input->post('sl_mb_per'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_5_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_ldpe'),'mat_info'=>$this->input->post('sl_ldpe_per'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_6_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_lldpe'),'mat_info'=>$this->input->post('sl_lldpe_per'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_6_1',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_hdpe'),'mat_info'=>$this->input->post('sl_hdpe_per'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_6_2',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('gauge_two'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_4',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_masterbatch_two'),'mat_info'=>$this->input->post('sl_mb_per_two'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_5_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_ldpe_two'),'mat_info'=>$this->input->post('sl_ldpe_per_two'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_6_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_lldpe_two'),'mat_info'=>$this->input->post('sl_lldpe_per_two'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_6_1',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_hdpe_two'),'mat_info'=>$this->input->post('sl_hdpe_per_two'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_6_2',$this->session->userdata['logged_in']['company_id']);



                  if(!empty($this->input->post('approval_authority'))){

                    $data=array('pending_flag'=>'1');

                    $result=$this->sleeve_specification_model->update_one_active_record('specification_sheet',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),$this->session->userdata['logged_in']['company_id']);

                    $data['followup']=$this->common_model->select_one_active_record_nonlanguage_without_archive('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$this->input->post('record_no'));
                      if($data['followup']==FALSE){
                        $transaction_no=1;
                        $status=1;
                      }else{
                        $i=1;
                        foreach ($data['followup'] as $followup_row) {

                          $transaction_no=$followup_row->transaction_no;
                          $status=1;
                          $i++;
                        }
                        $transaction_no=$i;
                      }

                      $data=array(
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'user_id'=>$this->input->post('approval_authority'),
                        'form_id'=>'985',
                        'transaction_no'=>$transaction_no,
                        'status'=>$status,
                        'followup_date'=>date('Y-m-d'),
                        'contact_person_id'=>$this->session->userdata['logged_in']['user_id'],
                        'record_no'=>$this->input->post('record_no'));

                      $result=$this->common_model->save('followup',$data);
                  }

                  $data['note']='Update Transaction Completed';
                  header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                  }else{
                  $data['error']='No change in Sleeve component, It is exist, It is exist';

                  if(!empty($this->input->post('approval_authority'))){

                    $data=array('pending_flag'=>'1');

                    $result=$this->sleeve_specification_model->update_one_active_record('specification_sheet',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),$this->session->userdata['logged_in']['company_id']);

                    $data['followup']=$this->common_model->select_one_active_record_nonlanguage_without_archive('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$this->input->post('record_no'));
                      if($data['followup']==FALSE){
                        $transaction_no=1;
                        $status=1;
                      }else{
                        $i=1;
                        foreach ($data['followup'] as $followup_row) {

                          $transaction_no=$followup_row->transaction_no;
                          $status=1;
                          $i++;
                        }
                        $transaction_no=$i;
                      }

                      $data=array(
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'user_id'=>$this->input->post('approval_authority'),
                        'form_id'=>'985',
                        'transaction_no'=>$transaction_no,
                        'status'=>$status,
                        'followup_date'=>date('Y-m-d'),
                        'contact_person_id'=>$this->session->userdata['logged_in']['user_id'],
                        'record_no'=>$this->input->post('record_no'));

                      $result=$this->common_model->save('followup',$data);

                      $data['note']='Sent for approval';
                      //header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                  }
                }


                $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
                $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
                $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
                $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');
                
                $data['specification']=$this->sleeve_specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->input->post('spec_id'),'specification_sheet.spec_version_no',$this->input->post('spec_version_no'),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);
                  
                $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');
                $data['page_name']='Sales';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                  $this->load->view(ucwords($this->router->fetch_class()).'/modify-two-form',$data);
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



  function update_three_layer(){
      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){

            //$this->form_validation->set_rules('main_group','Main Group' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('article_no','Article No' ,'required|trim|xss_clean|max_length[20]');
            
            $this->form_validation->set_rules('sleeve_dia','Sleeve Dia' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sleeve_length','Sleeve Length' ,'required|trim|xss_clean|max_length[5]');
            $this->form_validation->set_rules('gauge','Gauge' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sl_masterbatch','Sleeve Masterbatch' ,'required|trim|xss_clean');
            //$this->form_validation->set_rules('sl_mb_supplier','Sleeve Masterbatch Supplier','trim|xss_clean|callback_supplier_check');
            $this->form_validation->set_rules('sl_mb_per','Sleeve Masterbatch %' ,'required|trim|xss_clean|numeric|less_than_equal_to[25]|max_length[4]');

            if($this->input->post('sl_masterbatch')=='RM-MB-TRA-0007'){
            $this->form_validation->set_rules('sl_mb_per','Sleeve Masterbatch %' ,'required|trim|xss_clean|numeric|less_than[1]|max_length[4]');
            }
            $this->form_validation->set_rules('sl_ldpe_per','Sleeve Ldpe %' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_check');
            $this->form_validation->set_rules('sl_lldpe_per','Sleeve Lldpe %' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_check');
            $this->form_validation->set_rules('sl_hdpe_per','Sleeve Hdpe %' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_check');

            if(!empty($this->input->post('sl_ldpe_per'))){
              $this->form_validation->set_rules('sl_ldpe','Sleeve Ldpe' ,'trim|xss_clean|required|in_list[RM-LDPE-000-0009]');
            }if(!empty($this->input->post('sl_lldpe_per'))){
              $this->form_validation->set_rules('sl_lldpe','Sleeve Lldpe' ,'trim|xss_clean|required');
            }if(!empty($this->input->post('sl_hdpe_per'))){
              $this->form_validation->set_rules('sl_hdpe','Sleeve Hdpe' ,'trim|xss_clean|required');
            }

            if($this->input->post('sleeve_dia')){
            $sleeve_dia=explode('//',$this->input->post('sleeve_dia'));
              if($sleeve_dia[0]=="19 MM"){
                $this->form_validation->set_rules('gauge','Gauge' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('gauge_two','Gauge Layer Two' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('gauge_three','Gauge Layer Three' ,'required|trim|xss_clean');
              }else if($sleeve_dia[0]=="25 MM" || $sleeve_dia[0]=="30 MM" ||  $sleeve_dia[0]=="35 MM" || $sleeve_dia[0]=="40 MM"){
                $this->form_validation->set_rules('gauge','Gauge' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('gauge_two','Gauge Layer Two' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('gauge_three','Gauge Layer Three' ,'required|trim|xss_clean');
              }else{
                $this->form_validation->set_rules('gauge','Gauge' ,'required|trim');
                $this->form_validation->set_rules('gauge_two','Gauge Layer Two' ,'required|trim');
                $this->form_validation->set_rules('gauge_three','Gauge Layer Three' ,'required|trim|xss_clean');
              }
            }

            $this->form_validation->set_rules('gauge_two','Gauge Layer Two' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sl_hdpe_two','Sleeve Hdpe  Layer two' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sl_hdpe_per_two','Sleeve Hdpe % Layer two' ,'required|trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_two_check');

            $this->form_validation->set_rules('gauge_three','Gauge Layer Three' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sl_masterbatch_three','Sleeve Masterbatch Three' ,'required|trim|xss_clean');

            if($this->input->post('sl_masterbatch_three')=='RM-MB-TRA-0007'){
            $this->form_validation->set_rules('sl_mb_per_three','Sleeve Masterbatch % Layer Three' ,'required|trim|xss_clean|numeric|less_than[1]|max_length[4]');
            }

            $this->form_validation->set_rules('sl_ldpe_per_three','Sleeve Ldpe % Layer Three' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_three_check');
            $this->form_validation->set_rules('sl_lldpe_per_three','Sleeve Lldpe % Layer Three' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_three_check');
            $this->form_validation->set_rules('sl_hdpe_per_three','Sleeve Hdpe % Layer Three' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_three_check');

            if(!empty($this->input->post('sl_ldpe_per_three'))){
              $this->form_validation->set_rules('sl_ldpe_three','Sleeve Ldpe Layer Three' ,'trim|xss_clean|required|in_list[RM-LDPE-000-0009]');
            }if(!empty($this->input->post('sl_lldpe_per_three'))){
              $this->form_validation->set_rules('sl_lldpe_three','Sleeve Lldpe Layer Three' ,'trim|xss_clean|required');
            }if(!empty($this->input->post('sl_hdpe_per_three'))){
              $this->form_validation->set_rules('sl_hdpe_three','Sleeve Hdpe Layer Three' ,'trim|xss_clean|required');
            }
            
              

              if($this->form_validation->run()==FALSE){

                $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);

                $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
                $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
                $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
                $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');
                $data['specification']=$this->tube_specification_model->select_one_active_unapproved_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->input->post('spec_id'),'specification_sheet.spec_version_no',$this->input->post('spec_version_no'),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);
                
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/modify-three-form',$data);
                $this->load->view('Home/footer');

              }else{

              if(!empty($this->input->post('sleeve_dia'))){
                $sleeve_dia=explode('//',$this->input->post('sleeve_dia'));
              }else{
                $sleeve_dia[0]='';
                $sleeve_dia[1]='';
              }

              if(!empty($this->input->post('sleeve_length'))){
                $sleeve_length="X".$this->input->post('sleeve_length')." 3 LAYER";
              }else{
                $sleeve_length='';
              }

              if(!empty($this->input->post('gauge'))){
                $gauge=$this->input->post('gauge')."MIC";
              }else{
                $gauge='';
              }

              if(!empty($this->input->post('sl_ldpe')) && !empty($this->input->post('sl_ldpe_per'))){

                $data['sl_ldpe']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_ldpe'));
                if($data['sl_ldpe']==FALSE){
                $sl_ldpe="";
                }else{
                foreach($data['sl_ldpe'] as $sl_ldpe_row){
                  $sl_ldpe=$sl_ldpe_row->article_name;
                  }
                }
                if(!empty($this->input->post('sl_ldpe_per')) && $this->input->post('sl_ldpe_per')!=0){
                  $sl_ldpe_per=$this->input->post('sl_ldpe_per')."%";
                }else{
                  $sl_ldpe_per="";
                }
                
              }else{
                $sl_ldpe='';
                $sl_ldpe_per='';
              }


              if(!empty($this->input->post('sl_lldpe')) && !empty($this->input->post('sl_lldpe_per'))){

                $data['sl_lldpe']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_lldpe'));
                if($data['sl_lldpe']==FALSE){
                $sl_lldpe="";
                }else{
                foreach($data['sl_lldpe'] as $sl_lldpe_row){
                  $sl_lldpe=$sl_lldpe_row->article_name;
                  }
                }

                if(!empty($this->input->post('sl_lldpe_per')) && $this->input->post('sl_lldpe_per')!=0){
                  $sl_lldpe_per=$this->input->post('sl_lldpe_per')."%";
                }else{
                  $sl_lldpe_per="";
                }

              }else{
                $sl_lldpe='';
                $sl_lldpe_per='';
              }

              if(!empty($this->input->post('sl_hdpe')) && !empty($this->input->post('sl_hdpe_per'))){

                $data['sl_hdpe']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_hdpe'));
                if($data['sl_hdpe']==FALSE){
                
                }else{
                foreach($data['sl_hdpe'] as $sl_hdpe_row){
                  $sl_hdpe=$sl_hdpe_row->article_name;
                  }
                }

                if(!empty($this->input->post('sl_hdpe_per')) && $this->input->post('sl_hdpe_per')!=0){
                  $sl_hdpe_per=$this->input->post('sl_hdpe_per')."%";
                }else{
                  $sl_hdpe_per="";
                }

              }else{
                $sl_hdpe='';
                $sl_hdpe_per='';
              }

              if(!empty($this->input->post('sl_masterbatch'))){
              $data['sl_masterbatch']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_masterbatch'));

                foreach($data['sl_masterbatch'] as $sl_masterbatch_row){
                  $sl_masterbatch=$sl_masterbatch_row->article_name;
                }
              }else{
                $sl_masterbatch="";
              }

              if($this->input->post('sl_mb_per')!=''){
                $sl_mb_per=$this->input->post('sl_mb_per')."%";
              }else{
                $sl_mb_per="";
              }


              if(!empty($this->input->post('gauge_two'))){
                $gauge_two=$this->input->post('gauge_two')."MIC";
              }else{
                $gauge_two='';
              }

             if(!empty($this->input->post('sl_hdpe_two')) && !empty($this->input->post('sl_hdpe_per_two'))){

                $data['sl_hdpe_two']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_hdpe_two'));
                if($data['sl_hdpe_two']==FALSE){
                
                }else{
                foreach($data['sl_hdpe_two'] as $sl_hdpe_two_row){
                  $sl_hdpe_two=$sl_hdpe_two_row->article_name;
                  }

                }

                if(!empty($this->input->post('sl_hdpe_per_two')) && $this->input->post('sl_hdpe_per_two')!=0){
                  $sl_hdpe_per_two=$this->input->post('sl_hdpe_per_two')."%";
                }else{
                  $sl_hdpe_per_two="";
                }

              }else{
                $sl_hdpe_two='';
                $sl_hdpe_per_two='';
              }

              if(!empty($this->input->post('gauge_three'))){
                $gauge_three=$this->input->post('gauge_three')."MIC";
              }else{
                $gauge_three='';
              }

              if(!empty($this->input->post('sl_ldpe_three')) && !empty($this->input->post('sl_ldpe_per_three'))){

                $data['sl_ldpe_three']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_ldpe_three'));
                if($data['sl_ldpe_three']==FALSE){
                $sl_ldpe_three="";
                }else{
                foreach($data['sl_ldpe_three'] as $sl_ldpe_row_three){
                  $sl_ldpe_three=$sl_ldpe_row_three->article_name;
                  }
                }
                if(!empty($this->input->post('sl_ldpe_per_three')) && $this->input->post('sl_ldpe_per_three')!=0){
                  $sl_ldpe_per_three=$this->input->post('sl_ldpe_per_three')."%";
                }else{
                  $sl_ldpe_per_three="";
                }
                
              }else{
                $sl_ldpe_three='';
                $sl_ldpe_per_three='';
              }


              if(!empty($this->input->post('sl_lldpe_three')) && !empty($this->input->post('sl_lldpe_per_three'))){

                $data['sl_lldpe_three']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_lldpe_three'));
                if($data['sl_lldpe_three']==FALSE){
                $sl_lldpe_three="";
                }else{
                foreach($data['sl_lldpe_three'] as $sl_lldpe_row_three){
                  $sl_lldpe_three=$sl_lldpe_row_three->article_name;
                  }
                }

                if(!empty($this->input->post('sl_lldpe_per_three')) && $this->input->post('sl_lldpe_per_three')!=0){
                  $sl_lldpe_per_three=$this->input->post('sl_lldpe_per_three')."%";
                }else{
                  $sl_lldpe_per_three="";
                }

              }else{
                $sl_lldpe_three='';
                $sl_lldpe_per_three='';
              }

              if(!empty($this->input->post('sl_hdpe_three')) && !empty($this->input->post('sl_hdpe_per_three'))){

                $data['sl_hdpe_three']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_hdpe_three'));
                if($data['sl_hdpe_three']==FALSE){
                
                }else{
                foreach($data['sl_hdpe_three'] as $sl_hdpe_row_three){
                  $sl_hdpe_three=$sl_hdpe_row_three->article_name;
                  }
                }

                if(!empty($this->input->post('sl_hdpe_per_three')) && $this->input->post('sl_hdpe_per_three')!=0){
                  $sl_hdpe_per_three=$this->input->post('sl_hdpe_per_three')."%";
                }else{
                  $sl_hdpe_per_three="";
                }

              }else{
                $sl_hdpe_three='';
                $sl_hdpe_per_three='';
              }

              if(!empty($this->input->post('sl_masterbatch_three'))){
              $data['sl_masterbatch_three']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_masterbatch_three'));

                foreach($data['sl_masterbatch_three'] as $sl_masterbatch_row_three){
                  $sl_masterbatch_three=$sl_masterbatch_row_three->article_name;
                }
              }else{
                $sl_masterbatch_three="";
              }

              if($this->input->post('sl_mb_per_three')!=''){
                $sl_mb_per_three=$this->input->post('sl_mb_per_three')."%";
              }else{
                $sl_mb_per_three="";
              }

              

              $article_description=$sleeve_dia[0]."".$sleeve_length." ".$gauge." ".$sl_masterbatch." ".$sl_mb_per." ".$sl_ldpe." ".$sl_ldpe_per." ".$sl_lldpe." ".$sl_lldpe_per." ".$sl_hdpe." ".$sl_hdpe_per." ".$gauge_two." ".$sl_hdpe_two." ".$sl_hdpe_per_two." ".$gauge_three." ".$sl_masterbatch_three." ".$sl_mb_per_three." ".$sl_ldpe_three." ".$sl_ldpe_per_three." ".$sl_lldpe_three." ".$sl_lldpe_per_three." ".$sl_hdpe_three." ".$sl_hdpe_per_three;
                

              $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article_name_info.lang_article_description',$article_description);

                if($data['article']==FALSE){

                  $data=array('lang_article_description'=>$article_description);

                  $result=$this->common_model->update_one_active_record('article_name_info',$data,'article_no',$this->input->post('article_no'),$this->session->userdata['logged_in']['company_id']);

                  $data_article=array('article_modified_date'=>date('Y-m-d'));

                  $result=$this->common_model->update_one_active_record('article',$data_article,'article_no',$this->input->post('article_no'),$this->session->userdata['logged_in']['company_id']);
                  
                  $data=array('relating_master_value'=>$sleeve_dia[0]);

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_1',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('sleeve_length'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_2',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('gauge'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_4',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_masterbatch'),'mat_info'=>$this->input->post('sl_mb_per'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_5_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_ldpe'),'mat_info'=>$this->input->post('sl_ldpe_per'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_6_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_lldpe'),'mat_info'=>$this->input->post('sl_lldpe_per'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_6_1',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_hdpe'),'mat_info'=>$this->input->post('sl_hdpe_per'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_6_2',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('gauge_two'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_4',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_hdpe_two'),'mat_info'=>$this->input->post('sl_hdpe_per_two'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_6_2',$this->session->userdata['logged_in']['company_id']);


                  $data=array('parameter_value'=>$this->input->post('gauge_three'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_4',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_masterbatch_three'),'mat_info'=>$this->input->post('sl_mb_per_three'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_5_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_ldpe_three'),'mat_info'=>$this->input->post('sl_ldpe_per_three'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_6_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_lldpe_three'),'mat_info'=>$this->input->post('sl_lldpe_per_three'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_6_1',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_hdpe_three'),'mat_info'=>$this->input->post('sl_hdpe_per_three'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_6_2',$this->session->userdata['logged_in']['company_id']);



                  if(!empty($this->input->post('approval_authority'))){

                    $data=array('pending_flag'=>'1');

                    $result=$this->sleeve_specification_model->update_one_active_record('specification_sheet',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),$this->session->userdata['logged_in']['company_id']);

                    $data['followup']=$this->common_model->select_one_active_record_nonlanguage_without_archive('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$this->input->post('record_no'));
                      if($data['followup']==FALSE){
                        $transaction_no=1;
                        $status=1;
                      }else{
                        $i=1;
                        foreach ($data['followup'] as $followup_row) {

                          $transaction_no=$followup_row->transaction_no;
                          $status=1;
                          $i++;
                        }
                        $transaction_no=$i;
                      }

                      $data=array(
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'user_id'=>$this->input->post('approval_authority'),
                        'form_id'=>'985',
                        'transaction_no'=>$transaction_no,
                        'status'=>$status,
                        'followup_date'=>date('Y-m-d'),
                        'contact_person_id'=>$this->session->userdata['logged_in']['user_id'],
                        'record_no'=>$this->input->post('record_no'));

                      $result=$this->common_model->save('followup',$data);
                  }

                  $data['note']='Update Transaction Completed';
                  header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                  }else{
                  $data['error']='No change in Sleeve component, It is exist';

                  if(!empty($this->input->post('approval_authority'))){

                    $data=array('pending_flag'=>'1');

                    $result=$this->sleeve_specification_model->update_one_active_record('specification_sheet',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),$this->session->userdata['logged_in']['company_id']);

                    $data['followup']=$this->common_model->select_one_active_record_nonlanguage_without_archive('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$this->input->post('record_no'));
                      if($data['followup']==FALSE){
                        $transaction_no=1;
                        $status=1;
                      }else{
                        $i=1;
                        foreach ($data['followup'] as $followup_row) {

                          $transaction_no=$followup_row->transaction_no;
                          $status=1;
                          $i++;
                        }
                        $transaction_no=$i;
                      }

                      $data=array(
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'user_id'=>$this->input->post('approval_authority'),
                        'form_id'=>'985',
                        'transaction_no'=>$transaction_no,
                        'status'=>$status,
                        'followup_date'=>date('Y-m-d'),
                        'contact_person_id'=>$this->session->userdata['logged_in']['user_id'],
                        'record_no'=>$this->input->post('record_no'));

                      $result=$this->common_model->save('followup',$data);

                      $data['note']='Sent for approval';
                      //header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                  }
                }


                $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
                $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
                $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
                $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);

                $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');
                $data['specification']=$this->sleeve_specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->input->post('spec_id'),'specification_sheet.spec_version_no',$this->input->post('spec_version_no'),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);
                $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');
                $data['page_name']='Sales';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                  $this->load->view(ucwords($this->router->fetch_class()).'/modify-three-form',$data);
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


  function update_five_layer(){
      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){

            //$this->form_validation->set_rules('main_group','Main Group' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('article_no','Article No' ,'required|trim|xss_clean|max_length[20]');
            
            $this->form_validation->set_rules('sleeve_dia','Sleeve Dia' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sleeve_length','Sleeve Length' ,'required|trim|xss_clean|max_length[5]');
            $this->form_validation->set_rules('gauge','Gauge' ,'required|trim|xss_clean|max_length[5]');
            $this->form_validation->set_rules('sl_masterbatch','Sleeve Masterbatch' ,'required|trim|xss_clean');
            //$this->form_validation->set_rules('sl_mb_supplier','Sleeve Masterbatch Supplier','trim|xss_clean|callback_supplier_check');
            $this->form_validation->set_rules('sl_mb_per','Sleeve Masterbatch %' ,'required|trim|xss_clean|numeric|less_than_equal_to[25]|max_length[4]');

            if($this->input->post('sl_masterbatch')=='RM-MB-TRA-0007'){
            $this->form_validation->set_rules('sl_mb_per','Sleeve Masterbatch %' ,'required|trim|xss_clean|numeric|less_than[1]');
            }

            /*
            if($this->input->post('sleeve_dia')){
            $sleeve_dia=explode('//',$this->input->post('sleeve_dia'));
              if($sleeve_dia[0]=="19 MM"){
                $this->form_validation->set_rules('gauge','Gauge' ,'required|trim|xss_clean|exact_length[3]|in_list[173]');
                $this->form_validation->set_rules('gauge_five','Gauge Layer Five' ,'required|trim|xss_clean|exact_length[3]|in_list[172]');
              }else if($sleeve_dia[0]=="25 MM" || $sleeve_dia[0]=="30 MM" ||  $sleeve_dia[0]=="35 MM" || $sleeve_dia[0]=="40 MM"){
                $this->form_validation->set_rules('gauge','Gauge' ,'required|trim|xss_clean|exact_length[3]|in_list[223]');
                $this->form_validation->set_rules('gauge_five','Gauge Layer Five' ,'required|trim|xss_clean|exact_length[3]|in_list[222]');
              }else{
                $this->form_validation->set_rules('gauge','Gauge' ,'required|trim|xss_clean|exact_length[3]|in_list[248]');
                $this->form_validation->set_rules('gauge_five','Gauge Layer Five' ,'required|trim|xss_clean|exact_length[3]|in_list[247]');
              }
            }
            */

            $this->form_validation->set_rules('sl_ldpe_per','Sleeve Ldpe %' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_check');
            $this->form_validation->set_rules('sl_lldpe_per','Sleeve Lldpe %' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_check');
            $this->form_validation->set_rules('sl_hdpe_per','Sleeve Hdpe %' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_check');

            if(!empty($this->input->post('sl_ldpe_per'))){
              $this->form_validation->set_rules('sl_ldpe','Sleeve Ldpe' ,'trim|xss_clean|required|in_list[RM-LDPE-000-0009]');
            }if(!empty($this->input->post('sl_lldpe_per'))){
              $this->form_validation->set_rules('sl_lldpe','Sleeve Lldpe' ,'trim|xss_clean|required');
            }if(!empty($this->input->post('sl_hdpe_per'))){
              $this->form_validation->set_rules('sl_hdpe','Sleeve Hdpe' ,'trim|xss_clean|required');
            }

            $this->form_validation->set_rules('gauge_two','Gauge Layer Two' ,'required|trim|xss_clean|exact_length[2]');
            $this->form_validation->set_rules('sl_admer_two','Sleeve Admer Layer two' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sl_admer_per_two','Sleeve Admer % Layer two' ,'required|trim|xss_clean|is_natural|exact_length[3]');

            $this->form_validation->set_rules('gauge_three','Gauge Layer Three' ,'required|trim|xss_clean|exact_length[2]');
            
            $this->form_validation->set_rules('sl_evoh_three','Sleeve Evoh Layer Three' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sl_evoh_per_three','Sleeve Evoh % Layer Three' ,'required|trim|xss_clean|is_natural|exact_length[3]');

            $this->form_validation->set_rules('gauge_four','Gauge Layer Four' ,'required|trim|xss_clean|is_natural|exact_length[2]');
            $this->form_validation->set_rules('sl_admer_four','Sleeve Admer Layer Four' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sl_admer_per_four','Sleeve Admer % Layer Four' ,'required|trim|xss_clean|is_natural|exact_length[3]');

            $this->form_validation->set_rules('gauge_five','Gauge Layer Five' ,'required|trim|xss_clean|max_length[5]');


            $this->form_validation->set_rules('sl_masterbatch_five','Sleeve Masterbatch Layer Five' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sl_mb_per_five','Sleeve Masterbatch Five %' ,'required|trim|xss_clean|numeric|less_than_equal_to[25]|max_length[4]');


            if($this->input->post('sl_masterbatch_five')=='RM-MB-TRA-0007'){
            $this->form_validation->set_rules('sl_mb_per_five','Sleeve Masterbatch Five %' ,'required|trim|xss_clean|numeric|max_length[3]|less_than[1]');
            }

            $this->form_validation->set_rules('sl_ldpe_per_five','Sleeve Ldpe % Layer Five' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_five_check');
            $this->form_validation->set_rules('sl_lldpe_per_five','Sleeve Lldpe % Layer Five' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_five_check');
            $this->form_validation->set_rules('sl_hdpe_per_five','Sleeve Hdpe % Layer Five' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_five_check');

              if(!empty($this->input->post('sl_ldpe_per_five'))){
                $this->form_validation->set_rules('sl_ldpe_five','Sleeve Ldpe Layer Five' ,'trim|xss_clean|required|in_list[RM-LDPE-000-0009]');
              }if(!empty($this->input->post('sl_lldpe_per_five'))){
                $this->form_validation->set_rules('sl_lldpe_five','Sleeve Lldpe Layer Five' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_hdpe_per_five'))){
                $this->form_validation->set_rules('sl_hdpe_five','Sleeve Hdpe Layer Five' ,'trim|xss_clean|required');
              }
              

              if($this->form_validation->run()==FALSE){

                $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);

                $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
                $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
                $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
                $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                $data['admer']=$this->article_model->spec_active_record_search('article','15',$this->session->userdata['logged_in']['company_id']);
                $data['evoh']=$this->article_model->spec_active_record_search('article','16',$this->session->userdata['logged_in']['company_id']);
                $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');
                $data['specification']=$this->tube_specification_model->select_one_active_unapproved_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->input->post('spec_id'),'specification_sheet.spec_version_no',$this->input->post('spec_version_no'),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);
                
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/modify-five-form',$data);
                $this->load->view('Home/footer');

              }else{

              if(!empty($this->input->post('sleeve_dia'))){
                $sleeve_dia=explode('//',$this->input->post('sleeve_dia'));
              }else{
                $sleeve_dia[0]='';
                $sleeve_dia[1]='';
              }

              if(!empty($this->input->post('sleeve_length'))){
                $sleeve_length="X".$this->input->post('sleeve_length')." 5 LAYER";
              }else{
                $sleeve_length='';
              }

              if(!empty($this->input->post('gauge'))){
                $gauge=$this->input->post('gauge')."MIC";
              }else{
                $gauge='';
              }

              if(!empty($this->input->post('sl_ldpe')) && !empty($this->input->post('sl_ldpe_per'))){

                $data['sl_ldpe']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_ldpe'));
                if($data['sl_ldpe']==FALSE){
                $sl_ldpe="";
                }else{
                foreach($data['sl_ldpe'] as $sl_ldpe_row){
                  $sl_ldpe=$sl_ldpe_row->article_name;
                  }
                }
                if(!empty($this->input->post('sl_ldpe_per')) && $this->input->post('sl_ldpe_per')!=0){
                  $sl_ldpe_per=$this->input->post('sl_ldpe_per')."%";
                }else{
                  $sl_ldpe_per="";
                }
                
              }else{
                $sl_ldpe='';
                $sl_ldpe_per='';
              }


              if(!empty($this->input->post('sl_lldpe')) && !empty($this->input->post('sl_lldpe_per'))){

                $data['sl_lldpe']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_lldpe'));
                if($data['sl_lldpe']==FALSE){
                $sl_lldpe="";
                }else{
                foreach($data['sl_lldpe'] as $sl_lldpe_row){
                  $sl_lldpe=$sl_lldpe_row->article_name;
                  }
                }

                if(!empty($this->input->post('sl_lldpe_per')) && $this->input->post('sl_lldpe_per')!=0){
                  $sl_lldpe_per=$this->input->post('sl_lldpe_per')."%";
                }else{
                  $sl_lldpe_per="";
                }

              }else{
                $sl_lldpe='';
                $sl_lldpe_per='';
              }

              if(!empty($this->input->post('sl_hdpe')) && !empty($this->input->post('sl_hdpe_per'))){

                $data['sl_hdpe']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_hdpe'));
                if($data['sl_hdpe']==FALSE){
                
                }else{
                foreach($data['sl_hdpe'] as $sl_hdpe_row){
                  $sl_hdpe=$sl_hdpe_row->article_name;
                  }
                }

                if(!empty($this->input->post('sl_hdpe_per')) && $this->input->post('sl_hdpe_per')!=0){
                  $sl_hdpe_per=$this->input->post('sl_hdpe_per')."%";
                }else{
                  $sl_hdpe_per="";
                }

              }else{
                $sl_hdpe='';
                $sl_hdpe_per='';
              }

              if(!empty($this->input->post('sl_masterbatch')) || !empty($this->input->post('sl_mb_per'))!=0){
              $data['sl_masterbatch']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_masterbatch'));

                foreach($data['sl_masterbatch'] as $sl_masterbatch_row){
                  $sl_masterbatch=$sl_masterbatch_row->article_name;
                }


                if(!empty($this->input->post('sl_mb_per')) && $this->input->post('sl_mb_per')!=0){
                  $sl_mb_per=$this->input->post('sl_mb_per')."%";
                }else{
                  $sl_mb_per="";
                }


              }else{
                $sl_masterbatch="";
                $sl_mb_per="";
              }


              if(!empty($this->input->post('gauge_two'))){
                $gauge_two=$this->input->post('gauge_two')."MIC";
              }else{
                $gauge_two='';
              }

             if(!empty($this->input->post('sl_admer_two')) && !empty($this->input->post('sl_admer_per_two'))){

                $data['sl_admer_two']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_admer_two'));
                if($data['sl_admer_two']==FALSE){
                
                }else{
                foreach($data['sl_admer_two'] as $sl_admer_two_row){
                  $sl_admer_two=$sl_admer_two_row->article_name;
                  }
                }

                if(!empty($this->input->post('sl_admer_per_two')) && $this->input->post('sl_admer_per_two')!=0){
                  $sl_admer_per_two=$this->input->post('sl_admer_per_two')."%";
                }else{
                  $sl_admer_per_two="";
                }

              }else{
                $sl_admer_two='';
                $sl_admer_per_two='';
              }

              if(!empty($this->input->post('gauge_three'))){
                $gauge_three=$this->input->post('gauge_three')."MIC";
              }else{
                $gauge_three='';
              }

              if(!empty($this->input->post('sl_evoh_three')) && !empty($this->input->post('sl_evoh_per_three'))){

                $data['sl_evoh_three']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_evoh_three'));
                if($data['sl_evoh_three']==FALSE){
                $sl_evoh_three="";
                }else{
                foreach($data['sl_evoh_three'] as $sl_evoh_three_row){
                  $sl_evoh_three=$sl_evoh_three_row->article_name;
                  }
                }
                if(!empty($this->input->post('sl_evoh_per_three')) && $this->input->post('sl_evoh_per_three')!=0){
                  $sl_evoh_per_three=$this->input->post('sl_evoh_per_three')."%";
                }else{
                  $sl_evoh_per_three="";
                }
                
              }else{
                $sl_evoh_three='';
                $sl_evoh_per_three='';
              }



              if(!empty($this->input->post('gauge_four'))){
                $gauge_four=$this->input->post('gauge_four')."MIC";
              }else{
                $gauge_four='';
              }

             if(!empty($this->input->post('sl_admer_four')) && !empty($this->input->post('sl_admer_per_four'))){

                $data['sl_admer_four']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_admer_four'));
                if($data['sl_admer_four']==FALSE){
                
                }else{
                foreach($data['sl_admer_four'] as $sl_admer_four_row){
                  $sl_admer_four=$sl_admer_four_row->article_name;
                  }
                }

                if(!empty($this->input->post('sl_admer_per_four')) && $this->input->post('sl_admer_per_four')!=0){
                  $sl_admer_per_four=$this->input->post('sl_admer_per_four')."%";
                }else{
                  $sl_admer_per_four="";
                }

              }else{
                $sl_admer_four='';
                $sl_admer_per_four='';
              }


              if(!empty($this->input->post('gauge_five'))){
                $gauge_five=$this->input->post('gauge_five')."MIC";
              }else{
                $gauge_five='';
              }

              if(!empty($this->input->post('sl_ldpe_five')) && !empty($this->input->post('sl_ldpe_per_five'))){

                $data['sl_ldpe_five']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_ldpe_five'));
                if($data['sl_ldpe_five']==FALSE){
                $sl_ldpe_five="";
                }else{
                foreach($data['sl_ldpe_five'] as $sl_ldpe_five_row){
                  $sl_ldpe_five=$sl_ldpe_five_row->article_name;
                  }
                }
                if(!empty($this->input->post('sl_ldpe_per_five')) && $this->input->post('sl_ldpe_per_five')!=0){
                  $sl_ldpe_per_five=$this->input->post('sl_ldpe_per_five')."%";
                }else{
                  $sl_ldpe_per_five="";
                }
                
              }else{
                $sl_ldpe_five='';
                $sl_ldpe_per_five='';
              }


              if(!empty($this->input->post('sl_lldpe_five')) && !empty($this->input->post('sl_lldpe_per_five'))){

                $data['sl_lldpe_five']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_lldpe_five'));
                if($data['sl_lldpe_five']==FALSE){
                $sl_lldpe_five="";
                }else{
                foreach($data['sl_lldpe_five'] as $sl_lldpe_five_row){
                  $sl_lldpe_five=$sl_lldpe_five_row->article_name;
                  }
                }

                if(!empty($this->input->post('sl_lldpe_per_five')) && $this->input->post('sl_lldpe_per_five')!=0){
                  $sl_lldpe_per_five=$this->input->post('sl_lldpe_per_five')."%";
                }else{
                  $sl_lldpe_per_five="";
                }

              }else{
                $sl_lldpe_five='';
                $sl_lldpe_per_five='';
              }

              if(!empty($this->input->post('sl_hdpe_five')) && !empty($this->input->post('sl_hdpe_per_five'))){

                $data['sl_hdpe_five']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_hdpe_five'));
                if($data['sl_hdpe_five']==FALSE){
                
                }else{
                foreach($data['sl_hdpe_five'] as $sl_hdpe_five_row){
                  $sl_hdpe_five=$sl_hdpe_five_row->article_name;
                  }
                }

                if(!empty($this->input->post('sl_hdpe_per_five')) && $this->input->post('sl_hdpe_per_five')!=0){
                  $sl_hdpe_per_five=$this->input->post('sl_hdpe_per_five')."%";
                }else{
                  $sl_hdpe_per_five="";
                }

              }else{
                $sl_hdpe_five='';
                $sl_hdpe_per_five='';
              }

              if(!empty($this->input->post('sl_masterbatch_five')) || !empty($this->input->post('sl_mb_per_five'))!=0){
              $data['sl_masterbatch_five']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_masterbatch_five'));

                foreach($data['sl_masterbatch_five'] as $sl_masterbatch_five_row){
                  $sl_masterbatch_five=$sl_masterbatch_five_row->article_name;
                }


                if(!empty($this->input->post('sl_mb_per_five')) && $this->input->post('sl_mb_per_five')!=0){
                  $sl_mb_per_five=$this->input->post('sl_mb_per_five')."%";
                }else{
                  $sl_mb_per_five="";
                }


              }else{
                $sl_masterbatch_five="";
                $sl_mb_per_five="";
              }


              

              

              $article_description=$sleeve_dia[0]."".$sleeve_length." ".$gauge." ".$sl_masterbatch." ".$sl_mb_per." ".$sl_ldpe." ".$sl_ldpe_per." ".$sl_lldpe." ".$sl_lldpe_per." ".$sl_hdpe." ".$sl_hdpe_per." ".$gauge_two." ".$sl_admer_two." ".$sl_admer_per_two." ".$gauge_three." ".$sl_evoh_three." ".$sl_evoh_per_three." ".$gauge_four." ".$sl_admer_four." ".$sl_admer_per_four." ".$gauge_five." ".$sl_masterbatch_five." ".$sl_mb_per_five." ".$sl_ldpe_five." ".$sl_ldpe_per_five." ".$sl_lldpe_five." ".$sl_lldpe_per_five." ".$sl_hdpe_five." ".$sl_hdpe_per_five;
                

              $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article_name_info.lang_article_description',$article_description);

                if($data['article']==FALSE){

                  $data=array('lang_article_description'=>$article_description);

                  $result=$this->common_model->update_one_active_record('article_name_info',$data,'article_no',$this->input->post('article_no'),$this->session->userdata['logged_in']['company_id']);

                  $data_article=array('article_modified_date'=>date('Y-m-d'));
                  $result=$this->common_model->update_one_active_record('article',$data_article,'article_no',$this->input->post('article_no'),$this->session->userdata['logged_in']['company_id']);
                  
                  $data=array('relating_master_value'=>$sleeve_dia[0]);

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_1',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('sleeve_length'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_2',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('gauge'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_4',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_masterbatch'),'mat_info'=>$this->input->post('sl_mb_per'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_5_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_ldpe'),'mat_info'=>$this->input->post('sl_ldpe_per'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_6_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_lldpe'),'mat_info'=>$this->input->post('sl_lldpe_per'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_6_1',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_hdpe'),'mat_info'=>$this->input->post('sl_hdpe_per'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_6_2',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('gauge_two'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_4',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_admer_two'),'mat_info'=>$this->input->post('sl_admer_per_two'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_6_4',$this->session->userdata['logged_in']['company_id']);


                  $data=array('parameter_value'=>$this->input->post('gauge_three'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_4',$this->session->userdata['logged_in']['company_id']);


                  $data=array('mat_article_no'=>$this->input->post('sl_evoh_three'),'mat_info'=>$this->input->post('sl_evoh_per_three'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_6_3',$this->session->userdata['logged_in']['company_id']);


                  $data=array('parameter_value'=>$this->input->post('gauge_four'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','4_4',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_admer_four'),'mat_info'=>$this->input->post('sl_admer_per_four'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','4_6_4',$this->session->userdata['logged_in']['company_id']);


                  $data=array('parameter_value'=>$this->input->post('gauge_five'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','5_4',$this->session->userdata['logged_in']['company_id']);


                  $data=array('mat_article_no'=>$this->input->post('sl_masterbatch_five'),'mat_info'=>$this->input->post('sl_mb_per_five'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','5_5_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_ldpe_five'),'mat_info'=>$this->input->post('sl_ldpe_per_five'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','5_6_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_lldpe_five'),'mat_info'=>$this->input->post('sl_lldpe_per_five'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','5_6_1',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_hdpe_five'),'mat_info'=>$this->input->post('sl_hdpe_per_five'));

                  $result=$this->sleeve_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','5_6_2',$this->session->userdata['logged_in']['company_id']);
                  


                  if(!empty($this->input->post('approval_authority'))){

                    $data=array('pending_flag'=>'1');

                    $result=$this->sleeve_specification_model->update_one_active_record('specification_sheet',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),$this->session->userdata['logged_in']['company_id']);

                    $data['followup']=$this->common_model->select_one_active_record_nonlanguage_without_archive('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$this->input->post('record_no'));
                      if($data['followup']==FALSE){
                        $transaction_no=1;
                        $status=1;
                      }else{
                        $i=1;
                        foreach ($data['followup'] as $followup_row) {

                          $transaction_no=$followup_row->transaction_no;
                          $status=1;
                          $i++;
                        }
                        $transaction_no=$i;
                      }

                      $data=array(
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'user_id'=>$this->input->post('approval_authority'),
                        'form_id'=>'985',
                        'transaction_no'=>$transaction_no,
                        'status'=>$status,
                        'followup_date'=>date('Y-m-d'),
                        'contact_person_id'=>$this->session->userdata['logged_in']['user_id'],
                        'record_no'=>$this->input->post('record_no'));

                      $result=$this->common_model->save('followup',$data);
                  }

                  $data['note']='Update Transaction Completed';
                  header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                  }else{
                  $data['error']='No change in Sleeve component, It is exist';

                  if(!empty($this->input->post('approval_authority'))){

                    $data=array('pending_flag'=>'1');

                    $result=$this->sleeve_specification_model->update_one_active_record('specification_sheet',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),$this->session->userdata['logged_in']['company_id']);

                    $data['followup']=$this->common_model->select_one_active_record_nonlanguage_without_archive('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$this->input->post('record_no'));
                      if($data['followup']==FALSE){
                        $transaction_no=1;
                        $status=1;
                      }else{
                        $i=1;
                        foreach ($data['followup'] as $followup_row) {

                          $transaction_no=$followup_row->transaction_no;
                          $status=1;
                          $i++;
                        }
                        $transaction_no=$i;
                      }

                      $data=array(
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'user_id'=>$this->input->post('approval_authority'),
                        'form_id'=>'985',
                        'transaction_no'=>$transaction_no,
                        'status'=>$status,
                        'followup_date'=>date('Y-m-d'),
                        'contact_person_id'=>$this->session->userdata['logged_in']['user_id'],
                        'record_no'=>$this->input->post('record_no'));

                      $result=$this->common_model->save('followup',$data);

                      $data['note']='Sent for approval';
                      //header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                  }
                }


                $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
                $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
                $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
                $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                $data['admer']=$this->article_model->spec_active_record_search('article','15',$this->session->userdata['logged_in']['company_id']);
                  $data['evoh']=$this->article_model->spec_active_record_search('article','16',$this->session->userdata['logged_in']['company_id']);

                $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');
                $data['specification']=$this->sleeve_specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->input->post('spec_id'),'specification_sheet.spec_version_no',$this->input->post('spec_version_no'),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);
                $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');
                $data['page_name']='Sales';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                  $this->load->view(ucwords($this->router->fetch_class()).'/modify-five-form',$data);
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



  function copy_single_layer(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->copy==1){

            $data['specification']=$this->sleeve_specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->uri->segment(3),'specification_sheet.spec_version_no',$this->uri->segment(4),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);

            //echo $this->db->last_query();
            $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
            $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/copy-single-form',$data);
              $this->load->view('Home/footer');
          }else{
              $data['note']='No Copy rights Thanks';
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
      $data['note']='No Copy rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  
  }



  function copy_two_layer(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->copy==1){

            $data['specification']=$this->sleeve_specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->uri->segment(3),'specification_sheet.spec_version_no',$this->uri->segment(4),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);

            //echo $this->db->last_query();
            $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
            $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/copy-two-form',$data);
              $this->load->view('Home/footer');
          }else{
              $data['note']='No Copy rights Thanks';
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
      $data['note']='No Copy rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  
  }


  function copy_three_layer(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->copy==1){

            $data['specification']=$this->sleeve_specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->uri->segment(3),'specification_sheet.spec_version_no',$this->uri->segment(4),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);

            $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
            $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/copy-three-form',$data);
              $this->load->view('Home/footer');
          }else{
              $data['note']='No Copy rights Thanks';
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
      $data['note']='No Copy rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  
  }


  function copy_five_layer(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->copy==1){

            $data['specification']=$this->sleeve_specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->uri->segment(3),'specification_sheet.spec_version_no',$this->uri->segment(4),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);

            $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
            $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
            $data['admer']=$this->article_model->spec_active_record_search('article','15',$this->session->userdata['logged_in']['company_id']);
            $data['evoh']=$this->article_model->spec_active_record_search('article','16',$this->session->userdata['logged_in']['company_id']);
            
            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/copy-five-form',$data);
              $this->load->view('Home/footer');
          }else{
              $data['note']='No Copy rights Thanks';
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
      $data['note']='No Copy rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  
  }






  function delete(){

      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

                  $data=array('archive'=>'1');

                  $result=$this->sleeve_specification_model->update_one_active_record('specification_sheet',$data,'spec_id',$this->uri->segment(3),'spec_version_no',$this->uri->segment(4),$this->session->userdata['logged_in']['company_id']);

                  $data['specification']=$this->sleeve_specification_model->select_one_inactive_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->uri->segment(3),'specification_sheet.spec_version_no',$this->input->post('spec_version_no'));
                
                  $data['page_name']='Sales';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
                  

                  $data['note']='Archive Transaction completed';
                  header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
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


    function dearchive(){

      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

                  $data=array('archive'=>'2');

                  $result=$this->sleeve_specification_model->update_one_active_record('specification_sheet',$data,'spec_id',$this->uri->segment(3),'spec_version_no',$this->uri->segment(4),$this->session->userdata['logged_in']['company_id']);

                  $data['specification']=$this->sleeve_specification_model->select_one_inactive_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->uri->segment(3),'specification_sheet.spec_version_no',$this->input->post('spec_version_no'));
                
                  $data['page_name']='Sales';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
                  

                  $data['note']='Dearchive Transaction completed';
                  header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
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
        $data['note']='No Dearchive rights Thanks';
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

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

            $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
            $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
            $data['admer']=$this->article_model->spec_active_record_search('article','15',$this->session->userdata['logged_in']['company_id']);
            $data['evoh']=$this->article_model->spec_active_record_search('article','16',$this->session->userdata['logged_in']['company_id']);
            $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);

            $data['page_name']='home';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
            $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
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


  function search_result(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
              
            $this->form_validation->set_rules('from_date','From Date' ,'trim|xss_clean|exact_length[10]');
            $this->form_validation->set_rules('to_date','To Date' ,'trim|xss_clean|exact_length[10]');
            $this->form_validation->set_rules('article_no','Article No' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('user_id','Created By' ,'trim|xss_clean');
            $this->form_validation->set_rules('final_approval_flag','Approval Status' ,'trim|xss_clean');

              $this->form_validation->set_rules('sleeve_dia','Sleeve Dia' ,'trim|xss_clean');
              $this->form_validation->set_rules('sleeve_length','Sleeve Length' ,'trim|xss_clean|is_natural_no_zero|max_length[3]');
              $this->form_validation->set_rules('sleeve_guage','Gauge' ,'trim|xss_clean|is_natural_no_zero|max_length[3]');
              $this->form_validation->set_rules('sleeve_master_batch','Sleeve Masterbatch' ,'trim|xss_clean');
              $this->form_validation->set_rules('sleeve_mb_perc','Sleeve MB %' ,'trim|xss_clean');
              $this->form_validation->set_rules('sleeve_ldpe','Sleeve Ldpe' ,'trim|xss_clean');
              $this->form_validation->set_rules('sleeve_ldpe_perc','Sleeve Ldpe %' ,'trim|xss_clean|is_natural|max_length[3]');
              $this->form_validation->set_rules('sleeve_lldpe','Sleeve Lldpe' ,'trim|xss_clean');
              $this->form_validation->set_rules('sleeve_lldpe_perc','Sleeve Lldpe %' ,'trim|xss_clean|is_natural|max_length[3]');
              $this->form_validation->set_rules('sleeve_hdpe','Sleeve Hdpe' ,'trim|xss_clean');
              $this->form_validation->set_rules('sleeve_hdpe_perc','Sleeve Ldpe' ,'trim|xss_clean|is_natural|max_length[3]');
             
              $this->form_validation->set_rules('sleeve_guage_2','Layer-2 Gauge' ,'trim|xss_clean|is_natural_no_zero|max_length[3]');
              $this->form_validation->set_rules('sleeve_admer_2','Layer-2 Admer' ,'trim|xss_clean');
              $this->form_validation->set_rules('sleeve_admer_perc_2','Layer-2 Admer %' ,'trim|xss_clean');
              $this->form_validation->set_rules('sleeve_master_batch_2','Layer-2 Sleeve Masterbatch' ,'trim|xss_clean');
              $this->form_validation->set_rules('sleeve_mb_perc_2','Layer-2 Sleeve MB Percenatge' ,'trim|xss_clean');
              $this->form_validation->set_rules('sleeve_ldpe_2','Layer-2 Sleeve Ldpe' ,'trim|xss_clean');
              $this->form_validation->set_rules('sleeve_ldpe_perc_2','Layer-2 Sleeve Ldpe %' ,'trim|xss_clean|is_natural|max_length[3]');
              $this->form_validation->set_rules('sleeve_lldpe_2','Layer-2 Sleeve Lldpe' ,'trim|xss_clean');
              $this->form_validation->set_rules('sleeve_lldpe_perc_2','Layer-2 Sleeve Lldpe %' ,'trim|xss_clean|is_natural|max_length[3]');
              $this->form_validation->set_rules('sleeve_hdpe_2','Layer-2 Sleeve Hdpe' ,'trim|xss_clean');
              $this->form_validation->set_rules('sleeve_hdpe_perc_2','Layer-2 Sleeve Ldpe' ,'trim|xss_clean|is_natural|max_length[3]');


               $this->form_validation->set_rules('sleeve_guage_3','Layer-3 Gauge' ,'trim|xss_clean|is_natural_no_zero|max_length[3]');
              $this->form_validation->set_rules('sleeve_evoh_3','Layer-3 Evoh' ,'trim|xss_clean');
              $this->form_validation->set_rules('sleeve_evoh_perc_3','Layer-3 Evoh %' ,'trim|xss_clean');
              $this->form_validation->set_rules('sleeve_master_batch_3','Layer-3 Sleeve Masterbatch' ,'trim|xss_clean');
              $this->form_validation->set_rules('sleeve_mb_perc_3','Layer-3 Sleeve MB Percenatge' ,'trim|xss_clean');
              $this->form_validation->set_rules('sleeve_ldpe_3','Layer-3 Sleeve Ldpe' ,'trim|xss_clean');
              $this->form_validation->set_rules('sleeve_ldpe_perc_3','Layer-3 Sleeve Ldpe %' ,'trim|xss_clean|is_natural|max_length[3]');
              $this->form_validation->set_rules('sleeve_lldpe_3','Layer-3 Sleeve Lldpe' ,'trim|xss_clean');
              $this->form_validation->set_rules('sleeve_lldpe_perc_3','Layer-3 Sleeve Lldpe %' ,'trim|xss_clean|is_natural|max_length[3]');
              $this->form_validation->set_rules('sleeve_hdpe_3','Layer-3 Sleeve Hdpe' ,'trim|xss_clean');
              $this->form_validation->set_rules('sleeve_hdpe_perc_3','Layer-3 Sleeve Ldpe' ,'trim|xss_clean|is_natural|max_length[3]');

              $this->form_validation->set_rules('sleeve_guage_4','Layer-4 Gauge' ,'trim|xss_clean|is_natural_no_zero|max_length[3]');
              $this->form_validation->set_rules('sleeve_admer_4','Layer-4 Admer' ,'trim|xss_clean');
              $this->form_validation->set_rules('sleeve_admer_perc_4','Layer-4 Admer %' ,'trim|xss_clean');
                
              $this->form_validation->set_rules('sleeve_guage_5','Layer-5 Gauge' ,'trim|xss_clean|is_natural_no_zero|max_length[3]');
              $this->form_validation->set_rules('sleeve_master_batch_5','Layer-5 Sleeve Masterbatch' ,'trim|xss_clean');
              $this->form_validation->set_rules('sleeve_mb_perc_5','Layer-5 Sleeve MB %' ,'trim|xss_clean');
              $this->form_validation->set_rules('sleeve_ldpe_5','Layer-5 Sleeve Ldpe' ,'trim|xss_clean');
              $this->form_validation->set_rules('sleeve_ldpe_perc_5','Layer-5 Sleeve Ldpe %' ,'trim|xss_clean|is_natural|max_length[3]');
              $this->form_validation->set_rules('sleeve_lldpe_5','Layer-5 Sleeve Lldpe' ,'trim|xss_clean');
              $this->form_validation->set_rules('sleeve_lldpe_perc_5','Layer-5 Sleeve Lldpe %' ,'trim|xss_clean|is_natural|max_length[3]');
              $this->form_validation->set_rules('sleeve_hdpe_5','Layer-5 Sleeve Hdpe' ,'trim|xss_clean');
              $this->form_validation->set_rules('sleeve_hdpe_perc_5','Layer-5 Sleeve Ldpe' ,'trim|xss_clean|is_natural|max_length[3]');

              $arr_input=array_filter($this->input->post(),'strlen');
              if(empty($arr_input)){
                $this->form_validation->set_rules('from_date','From Date' ,'required|trim|xss_clean|exact_length[10]');
                $this->form_validation->set_rules('to_date','To Date' ,'required|trim|xss_clean|exact_length[10]');

              }
            

            if($this->form_validation->run()==FALSE){

              $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

                $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
                $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
                $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
                $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                $data['admer']=$this->article_model->spec_active_record_search('article','15',$this->session->userdata['logged_in']['company_id']);
                $data['evoh']=$this->article_model->spec_active_record_search('article','16',$this->session->userdata['logged_in']['company_id']);
                $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                $this->load->view('Home/footer');
            }else{
                $from='';
                $to='';
                if(!empty($this->input->post('from_date'))){
                  $from=$this->common_model->change_date_format($this->input->post('from_date'),$this->session->userdata['logged_in']['company_id']);
                }
                if(!empty($this->input->post('to_date'))){
                  $to=$this->common_model->change_date_format($this->input->post('to_date'),$this->session->userdata['logged_in']['company_id']);
                }            

                if(!empty($this->input->post('article_no'))){
                  $article_no_arr=explode('//',$this->input->post('article_no'));
                }else{
                  $article_no_arr[1]='';
                }

                if(!empty($this->input->post('sleeve_dia'))){

                  $sleeve_dia=explode("//", $this->input->post('sleeve_dia'));
                }
                else{
                  $sleeve_dia[0]='';
                  $sleeve_dia[1]='';
                }
                $dyn_qty_present='';
                if(!empty($this->input->post('dyn_qty_present'))){

                  $dyn_qty_present=$this->input->post('dyn_qty_present');
                }
                
                $data=array('user_id'=>$this->input->post('user_id'),                    
                            'article_no'=>$article_no_arr[1],
                            'final_approval_flag'=>$this->input->post('final_approval_flag'),
                            'dyn_qty_present'=>$dyn_qty_present
                           );

                $data=array_filter($data,'strlen');


                $search_arr = array('sleeve_dia' =>$sleeve_dia[0],
                                    'sleeve_length' =>$this->input->post('sleeve_length'),
                                    'sleeve_guage' =>$this->input->post('sleeve_guage'),
                                    'sleeve_master_batch' =>$this->input->post('sleeve_master_batch'),
                                    'sleeve_mb_perc' =>$this->input->post('sleeve_mb_perc'),
                                    'sleeve_ldpe' =>$this->input->post('sleeve_ldpe'),
                                    'sleeve_ldpe_perc' =>$this->input->post('sleeve_ldpe_perc'),
                                    'sleeve_lldpe' =>$this->input->post('sleeve_lldpe'),
                                    'sleeve_lldpe_perc' =>$this->input->post('sleeve_lldpe_perc'),
                                    'sleeve_hdpe' =>$this->input->post('sleeve_hdpe'),
                                    'sleeve_hdpe_perc' =>$this->input->post('sleeve_hdpe_perc'),
                                    'sleeve_guage_2' =>$this->input->post('sleeve_guage_2'),
                                    'sleeve_admer_2' =>$this->input->post('sleeve_admer_2'),
                                    'sleeve_admer_perc_2' =>$this->input->post('sleeve_admer_perc_2'),
                                    'sleeve_master_batch_2' =>$this->input->post('sleeve_master_batch_2'),
                                    'sleeve_mb_perc_2' =>$this->input->post('sleeve_mb_perc_2'),
                                    'sleeve_ldpe_2' =>$this->input->post('sleeve_ldpe_2'),
                                    'sleeve_ldpe_perc_2' =>$this->input->post('sleeve_ldpe_perc_2'),
                                    'sleeve_lldpe_2' =>$this->input->post('sleeve_lldpe_2'),
                                    'sleeve_lldpe_perc_2' =>$this->input->post('sleeve_lldpe_perc_2'),
                                    'sleeve_hdpe_2' =>$this->input->post('sleeve_hdpe_2'),
                                    'sleeve_hdpe_perc_2' =>$this->input->post('sleeve_hdpe_perc_2'),                                     
                                    'sleeve_guage_3' =>$this->input->post('sleeve_guage_3'),
                                    'sleeve_evoh' =>$this->input->post('sleeve_evoh'),
                                    'sleeve_evoh_perc' =>$this->input->post('sleeve_evoh_perc'),
                                    'sleeve_master_batch_3' =>$this->input->post('sleeve_master_batch_3'),
                                    'sleeve_mb_perc_3' =>$this->input->post('sleeve_mb_perc_3'),
                                    'sleeve_ldpe_3' =>$this->input->post('sleeve_ldpe_3'),
                                    'sleeve_ldpe_perc_3' =>$this->input->post('sleeve_ldpe_perc_3'),
                                    'sleeve_lldpe_3' =>$this->input->post('sleeve_lldpe_3'),
                                    'sleeve_lldpe_perc_3' =>$this->input->post('sleeve_lldpe_perc_3'),
                                    'sleeve_hdpe_3' =>$this->input->post('sleeve_hdpe_3'),
                                    'sleeve_hdpe_perc_3' =>$this->input->post('sleeve_hdpe_perc_3'), 
                                    'sleeve_guage_4' =>$this->input->post('sleeve_guage_4'),
                                    'sleeve_admer_4' =>$this->input->post('sleeve_admer_4'),
                                    'sleeve_admer_perc_4' =>$this->input->post('sleeve_admer_perc_4'),
                                    'sleeve_guage_5' =>$this->input->post('sleeve_guage_5'),
                                    'sleeve_master_batch_5' =>$this->input->post('sleeve_master_batch_5'),
                                    'sleeve_mb_perc_5' =>$this->input->post('sleeve_mb_perc_5'),
                                    'sleeve_ldpe_5' =>$this->input->post('sleeve_ldpe_5'),
                                    'sleeve_ldpe_perc_5' =>$this->input->post('sleeve_ldpe_perc_5'),
                                    'sleeve_lldpe_5' =>$this->input->post('sleeve_lldpe_5'),
                                    'sleeve_lldpe_perc_5' =>$this->input->post('sleeve_lldpe_perc_5'),
                                    'sleeve_hdpe_5' =>$this->input->post('sleeve_hdpe_5'),
                                    'sleeve_hdpe_perc_5' =>$this->input->post('sleeve_hdpe_perc_5')
                                    ); 

                $search=array_filter($search_arr);

                $data['specification']=$this->sleeve_specification_model->active_record_search_new('specification_sheet',$data,$search,$from,$to,$this->session->userdata['logged_in']['company_id']);
                //echo $this->db->last_query();
                 
                if($data['specification']!=FALSE){
                    $data['page_name']='Sales';
                    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                    $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                    $this->load->view('Home/header');
                    $this->load->view('Home/nav',$data);
                    $this->load->view('Home/subnav');
                    $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                    $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
                    $this->load->view('Home/footer');
                }else{
                      $data['page_name']='Sales';
                      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                      $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
                      
                      $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

                      $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                      $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
                      $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
                      $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
                      $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                      $data['admer']=$this->article_model->spec_active_record_search('article','15',$this->session->userdata['logged_in']['company_id']);
                      $data['evoh']=$this->article_model->spec_active_record_search('article','16',$this->session->userdata['logged_in']['company_id']);
                      $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);
                      

                      $data['note']='No record in search transaction';
                      $this->load->view('Home/header');
                      $this->load->view('Home/nav',$data);
                      $this->load->view('Home/subnav');
                      $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                      $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                      $this->load->view('Home/footer');
                  }
                
            }

          }else{
                  $data['page_name']='home';
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



  public function sleeve_per_check($str){
    $sl_ldpe_per=$this->input->post('sl_ldpe_per');
    $sl_lldpe_per=$this->input->post('sl_lldpe_per');
    $sl_hdpe_per=$this->input->post('sl_hdpe_per');
    $total_per=$sl_ldpe_per+$sl_lldpe_per+$sl_hdpe_per;

    if($total_per!=100){
      $this->form_validation->set_message('sleeve_per_check', 'The {field} field is incorrect');
      return FALSE;
    }else{
      return TRUE;
    }
  }


  public function sleeve_per_two_check($str){
    $sl_ldpe_per_two=$this->input->post('sl_ldpe_per_two');
    $sl_lldpe_per_two=$this->input->post('sl_lldpe_per_two');
    $sl_hdpe_per_two=$this->input->post('sl_hdpe_per_two');
    $total_per_two=$sl_ldpe_per_two+$sl_lldpe_per_two+$sl_hdpe_per_two;

    if($total_per_two!=100){
      $this->form_validation->set_message('sleeve_per_two_check', 'The {field} field is incorrect');
      return FALSE;
    }else{
      return TRUE;
    }
  }

  public function sleeve_per_three_check($str){
    $sl_ldpe_per_three=$this->input->post('sl_ldpe_per_three');
    $sl_lldpe_per_three=$this->input->post('sl_lldpe_per_three');
    $sl_hdpe_per_three=$this->input->post('sl_hdpe_per_three');
    $total_per_three=$sl_ldpe_per_three+$sl_lldpe_per_three+$sl_hdpe_per_three;

    if($total_per_three!=100){
      $this->form_validation->set_message('sleeve_per_three_check', 'The {field} field is incorrect');
      return FALSE;
    }else{
      return TRUE;
    }
  }


  public function sleeve_per_five_check($str){
    $sl_ldpe_per_five=$this->input->post('sl_ldpe_per_five');
    $sl_lldpe_per_five=$this->input->post('sl_lldpe_per_five');
    $sl_hdpe_per_five=$this->input->post('sl_hdpe_per_five');
    $total_per_five=$sl_ldpe_per_five+$sl_lldpe_per_five+$sl_hdpe_per_five;

    if($total_per_five!=100){
      $this->form_validation->set_message('sleeve_per_five_check', 'The {field} field is incorrect');
      return FALSE;
    }else{
      return TRUE;
    }
  }

  public function main_group_article($main_group_id){
    $data['autogeneration']=$this->common_model->article_no_generation('article_number_circles',$this->session->userdata['logged_in']['company_id'],'main_group_id',$main_group_id,'sub_group_id','','sub_sub_grp_id','');
    //echo $this->db->last_query();
    if($data['autogeneration']==FALSE){
      $data['default']=$this->common_model->article_no_generation('article_number_circles',$this->session->userdata['logged_in']['company_id'],'main_group_id','','sub_group_id','','sub_sub_grp_id','');
      foreach ($data['default'] as $default_row) {
       
        $count=str_pad($default_row->curr_val,$default_row->number_of_digits,0,STR_PAD_LEFT);

        $data['main_group']=$this->common_model->select_one_active_record('article_main_group',$this->session->userdata['logged_in']['company_id'],'main_group_id',$main_group_id);
        foreach ($data['main_group'] as $main_group_row) {
          $main_group_row->lang_short_desc;
          return $main_group_row->lang_short_desc."-000-000-".$count;
        }

        
        }
      
    }else{
      foreach($data['autogeneration'] as $row){

        if($row->main_grp_value=='MAIN'){
          $data['main_group']=$this->common_model->select_one_active_record('article_main_group',$this->session->userdata['logged_in']['company_id'],'main_group_id',$row->main_group_id);
          foreach ($data['main_group'] as $main_group_row) {
            $main_group_initial=$main_group_row->lang_short_desc.$row->seperator;
          }
        }else if($row->main_grp_value==''){
          $main_group_initial="";
        }else{
          $main_group_initial=$row->main_grp_value.$row->seperator;
        }

        if($row->sub_grp_value=='SUB'){
          $sub_group_initial="000".$row->seperator;
        }else if($row->sub_grp_value==''){
          $sub_group_initial="";
        }else{
          $sub_group_initial=$row->sub_grp_value.$row->seperator;
        }

        if($row->sub_sub_grp_value=='SECSUB'){
            $second_sub_group_initial="000".$row->seperator;
          }else if($row->sub_sub_grp_value==''){
          $second_sub_group_initial="";
        }else{
            $second_sub_group_initial=$row->sub_sub_grp_value.$row->seperator;
        }

        $count=$this->common_model->active_record_count_where('article',$this->session->userdata['logged_in']['company_id'],'main_group_id',$row->main_group_id,'article_group_id','999999999999999','sub_sub_grp_id','999999999999999');
        //echo $this->db->last_query();
        $count=$row->step_by+$count+$row->start_value;
        $count=str_pad($count,$row->number_of_digits,0,STR_PAD_LEFT);

        return $main_group_initial.$sub_group_initial.$second_sub_group_initial.$count;
      }
     
     }
     
  }


  

}