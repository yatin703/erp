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
   
    
      $data['page_name']='home';
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Home/change-password-form');
      //$this->load->view('Home/home');
      $this->load->view('Home/footer');
  }

   function change_password_save(){


    $this->form_validation->set_rules('new_password','New Password' ,'required|trim|xss_clean|max_length[20]');
    $this->form_validation->set_rules('confirm_password','Confirm Password' ,'required|trim|xss_clean|max_length[20]|matches[new_password]');

    if($this->form_validation->run()==FALSE){

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $data['page_name']='home';
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Home/change-password-form');
      //$this->load->view('Home/home');
      $this->load->view('Home/footer');

    }else{
      $this->load->model('login_model');
      $password = $this->login_model->cop_f_encrypt('pass',$this->input->post('new_password'),"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890-/.");
      $user_id=$this->session->userdata['logged_in']['user_id'];

      $data=array('password'=>$password);

      $result=$this->common_model->update_one_active_record('user_master',$data,'user_id',$user_id,$this->session->userdata['logged_in']['company_id']);
      if($result){

        $data['note']='Password Changed Successfully!';

        $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

        $data['page_name']='home';
        $this->load->view('Home/header');
        $this->load->view('Home/nav',$data);
        $this->load->view('Home/subnav');
        $this->load->view('Home/change-password-form');
        //$this->load->view('Home/home');
        $this->load->view('Home/footer');


        $this->session->unset_userdata('logged_in');
        $this->session->sess_destroy();
        header("refresh:1;url=".base_url()."index.php/login");


      }else{

        $data['error']='Error while changing password!';
        $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

        $data['page_name']='home';
        $this->load->view('Home/header');
        $this->load->view('Home/nav',$data);
        $this->load->view('Home/subnav');
        $this->load->view('Error/error-title',$data);
        $this->load->view('Home/change-password-form');
        //$this->load->view('Home/home');
        $this->load->view('Home/footer');


      }

    }     
 
 
  }


 
}
?>