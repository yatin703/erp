<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
		}else{
			redirect('login','refresh');
		}
  }

  public function index(){
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $data['page_name']='home';
  		$this->load->view('Home/header');
  		$this->load->view('Home/nav',$data);
  		$this->load->view('Home/subnav');
  		$this->load->view('Home/home');
  		$this->load->view('Home/footer');
  	}

  public function logout(){
    $this->session->unset_userdata('logged_in');
  	$this->session->sess_destroy();
		redirect('login', 'refresh');
  }

  function change_password(){   

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
   
    //$data['user']=$this->common_model->select_one_active_record('user_master',$this->session->userdata['logged_in']['company_id'],'user_id',$this->uri->segment(3));

    //$data['employee']=$this->common_model->select_active_drop_down('employee_master',$this->session->userdata['logged_in']['company_id']);

    //$data['user_level']=$this->common_model->select_active_drop_down_noncompany_nonarchive('user_level_master');


      $data['page_name']='home';
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Home/change-password-form');
      //$this->load->view('Home/home');
      $this->load->view('Home/footer');
  }

   

}
?>