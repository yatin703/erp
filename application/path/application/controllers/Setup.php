<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup extends CI_Controller {

	function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in') && $this->session->userdata['logged_in']['admin']==1){
      $this->load->model('common_model');
		}else{
			redirect('login','refresh');
		}
  }

  public function index(){
  	$data['page_name']='setup';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
  	$this->load->view('Home/header');
  	$this->load->view('Home/nav',$data);
  	$this->load->view('Home/subnav');
  	$this->load->view('Setup/setup-home');
  	$this->load->view('Home/footer');
  }

  

}