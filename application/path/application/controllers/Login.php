<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	function __construct(){
    parent::__construct();
    $this->load->model('common_model');
    $this->load->model('login_model');
  }

	public function index(){
		$data['company_data']=$this->common_model->select_active_drop_down('company_master','000020');
		//$data['user_data']=$this->common_model->select_active_drop_down('user_master','000020');
		$data_search=array('archive'=>'0');
		$data['user_data']=$this->common_model->select_active_records_where_order_by('user_master','000020',$data_search,'login_name','asc');
		$this->load->view(ucwords($this->router->fetch_class()).'/header');
		$this->load->view(ucwords($this->router->fetch_class()).'/login-form',$data);
		$this->load->view(ucwords($this->router->fetch_class()).'/footer');

	}

	public function time(){
		echo date('d/m/Y'); 
		echo " | ";
		echo date("h:i:s a");
	}


	public function validation(){
		$this->form_validation->set_rules('username','Username','required|xss_clean');
		$this->form_validation->set_rules('password','Password','required|xss_clean');
		$this->form_validation->set_rules('company','Company','required|xss_clean|callback_check_database');
		if($this->form_validation->run()==FALSE){
			$data['company_data']=$this->common_model->select_active_drop_down('company_master','000020');
			$data['user_data']=$this->common_model->select_active_drop_down('user_master','000020');
			$this->load->view(ucwords($this->router->fetch_class()).'/header');
			$this->load->view(ucwords($this->router->fetch_class()).'/login-form',$data);
			$this->load->view(ucwords($this->router->fetch_class()).'/footer');
		}else{
			 

			  echo $this->login_model->cop_f_decrypt('pass',"GEUFF.NSpQjk","ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890-/.");

		}
	}

	function check_database($password){
		$username = $this->input->post('username');
		$password = $this->login_model->cop_f_encrypt('pass',$this->input->post('password'),"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890-/.");
		$company = $this->input->post('company');
		$result=$this->login_model->check_login_status($username,$password,$company);
		if($result==FALSE){
			$this->form_validation->set_message('check_database', 'Invalid Username and Password');
		     return false;
		}else{
		foreach($result as $row){
				$result = $this->login_model->login($username,$password,$company);
		
				if($result){
					$sess_array = array();
					foreach($result as $row){
						$sess_array = array('user_id'=>$row->user_id,'admin'=>$row->admin,'username' =>$row->login_name,'password' =>$row->password,'company_id' => $row->company_id,'language_id'=>$row->language_id);
						$this->session->set_userdata('logged_in', $sess_array);
						//User log added on 12-March-2020
						$ip_address=$_SERVER['REMOTE_ADDR'];
						$data=array('user_id' =>$row->user_id ,'date_time'=>date('Y-m-d h:i:s'),'user_login_id'=>$ip_address,'company_id' => $row->company_id,'menu_id'=>'1','operation'=>0,'table_name'=>'user_master');
						$result=$this->common_model->save('user_log',$data);
						//echo $this->db->last_query();
						redirect('home', 'refresh');
					}
					return TRUE;
				}else{
		     $this->form_validation->set_message('check_database', 'Check Username and Password');
		     return false;
		   }
			}
		}
	}
	
}
