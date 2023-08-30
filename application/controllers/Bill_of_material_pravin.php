<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bill_of_material extends CI_Controller {

  function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('bom_model');
      $this->load->model('article_model');
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
            $table='bill_of_material';
            include('pagination.php');
            $data['bom']=$this->bom_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
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



  function create_one_layer(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

            $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
            $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
            $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/create-one-layer',$data);
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


}