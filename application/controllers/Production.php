<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Production extends CI_Controller {

	function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');

		}else{
			redirect('login','refresh');
		}
  }

  function index(){
  	$data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
    	if($module_row->module_name==='Production'){
    		$data['formrights']=$this->common_model->select_assign_forms($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5);
		  	$this->load->view('Home/header');
		  	$this->load->view('Home/nav',$data);
		  	$this->load->view('Home/subnav');
		  	$this->load->view('Production/production-home',$data);
		  	$this->load->view('Home/footer');
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



}