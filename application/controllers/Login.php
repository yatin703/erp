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

	public function forget_password(){
		$data['company_data']=$this->common_model->select_active_drop_down('company_master','000020');
		$data['user_data']=$this->common_model->select_active_drop_down('user_master','000020');
		$this->load->view(ucwords($this->router->fetch_class()).'/header');
		$this->load->view(ucwords($this->router->fetch_class()).'/forgot_password',$data);
		$this->load->view(ucwords($this->router->fetch_class()).'/footer'); 
		
	}

	public function forgot_password_link(){
   		$this->form_validation->set_rules('username','Username','required|xss_clean'); 
   		if($this->form_validation->run()==FALSE){
   			$data['company_data']=$this->common_model->select_active_drop_down('company_master','000020');
			$data['user_data']=$this->common_model->select_active_drop_down('user_master','000020');
			$this->load->view(ucwords($this->router->fetch_class()).'/header');
			$this->load->view(ucwords($this->router->fetch_class()).'/forgot_password',$data);
			$this->load->view(ucwords($this->router->fetch_class()).'/footer');
			
		}else{
			//echo $this->input->post('username');
			$result=$this->common_model->select_one_active_record('employee_master',$this->input->post('company'),'employee_id',$this->input->post('username')); 
		 if($result==FALSE){
				echo "Mail id not exist";
			}else{
				foreach($result as $row){

					$config['protocol']    = 'smtp';
				    $config['smtp_host']    = 'ssl://smtp.gmail.com';
				    $config['smtp_port']    = '465';
				    $config['smtp_timeout'] = '7';
				    $config['smtp_user']    = 'auto.mailer@3d-neopac.com'; 
				    $config['smtp_pass']    = 'auto@2223';
				    $config['charset']    = 'utf-8';
				    $config['newline']    = "\r\n";
				    $config['mailtype'] = 'text'; // or html 
				    $config['validation'] = TRUE; 
				    
				    $this->load->helper('string');

				    $this->email->initialize($config);

				    $this->email->set_newline("\r\n");
				    $mailbox=$this->input->post('mailbox');
   
   
			        $this->email->from('auto.mailer@3d-neopac.com', '3D Neopac'); 
			        $this->email->to($row->mailbox);
          			
          			$reset_call = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 20);
          
         			$this->email->subject('Reset Password Link'); 
        			$this->email->message("Click On This Link to Reset Password  ".base_url('index.php/login/reset_password/'.$reset_call.'')." This Link Will Expire In 2 Minuts !!");
               

       
         
			        if($this->email->send()) {
			         	$data['success'] = 'Email Successfully Send !';
			         	$update_data=array('reset_code'=>$reset_call,'reset_time'=>time() );
			         	
			         	$result=$this->common_model->update_one_active_record('user_master',$update_data,'user_id',$this->input->post('username'),$this->input->post('company'));
			         	if($result){
			         		$data['note'] = 'Reset Password Link Sent on your registred email id';
			         		$data['company_data']=$this->common_model->select_active_drop_down('company_master','000020');
							$data['user_data']=$this->common_model->select_active_drop_down('user_master','000020');
							$this->load->view(ucwords($this->router->fetch_class()).'/header');
							$this->load->view(ucwords($this->router->fetch_class()).'/forgot_password',$data);
							$this->load->view(ucwords($this->router->fetch_class()).'/footer');
			         	}
			 
			         else {
		           		show_error($this->email->print_debugger());
		           		$data['error'] = 'Someting Wrong';
		         		$data['company_data']=$this->common_model->select_active_drop_down('company_master','000020');
						$data['user_data']=$this->common_model->select_active_drop_down('user_master','000020');
						$this->load->view(ucwords($this->router->fetch_class()).'/header');
						$this->load->view(ucwords($this->router->fetch_class()).'/forgot_password',$data);
						$this->load->view(ucwords($this->router->fetch_class()).'/footer');
       				} 

       			
        	}
        }
	}
	
	}
	}

	public function reset_password(){

		$result=$this->common_model->select_one_active_record_noncompany('user_master','reset_code',$this->uri->segment(3));
		if($result==TRUE){
			foreach($result as $row){
				$reset_time=$row->reset_time;

			}
		}else{
			$reset_time="";
		}	

       // $reset_time=$row->reset_time;
		$time = time();
		$exp_time = $time - $reset_time;			         	
		if($exp_time<120){
		    //echo $this->uri->segment(3);
				$data['company_data']=$this->common_model->select_active_drop_down('company_master','000020');
				$data['user_data']=$this->common_model->select_active_drop_down('user_master','000020');
				$this->load->view(ucwords($this->router->fetch_class()).'/header');
				$this->load->view(ucwords($this->router->fetch_class()).'/reset_password',$data);
				$this->load->view(ucwords($this->router->fetch_class()).'/footer');
			}else{

       			    $data['error'] = 'LINK TIME OUT !! PLEASE TRY AGAIN.';
		         	$data['company_data']=$this->common_model->select_active_drop_down('company_master','000020');
					$data['user_data']=$this->common_model->select_active_drop_down('user_master','000020');
					$this->load->view(ucwords($this->router->fetch_class()).'/header');
					$this->load->view(ucwords($this->router->fetch_class()).'/forgot_password',$data);
					$this->load->view(ucwords($this->router->fetch_class()).'/footer');
		}
		
	}

	public function update_password(){ 
	                    
	    $this->form_validation->set_rules('new_password','Password','required');
		$this->form_validation->set_rules('confirm_password','Retype Password','required|matches[new_password]');
		if($this->form_validation->run()==FALSE){
			
           
			$this->load->view(ucwords($this->router->fetch_class()).'/header');
			$this->load->view(ucwords($this->router->fetch_class()).'/reset_password_view');
			$this->load->view(ucwords($this->router->fetch_class()).'/footer');


		}else{
			
			 $update_data=array('password'=>$this->login_model->cop_f_encrypt('pass',$this->input->post('new_password'),"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890-/."));
               $this->common_model->update_one_active_record('user_master',$update_data,'reset_code',$this->input->post('reset_code'),'000020');
               $data['note'] = 'Password updated successfully, Please Login Now !';
               $data['company_data']=$this->common_model->select_active_drop_down('company_master','000020');
				$data_search=array('archive'=>'0');
				$data['user_data']=$this->common_model->select_active_records_where_order_by('user_master','000020',$data_search,'login_name','asc');
				$this->load->view(ucwords($this->router->fetch_class()).'/header');
				$this->load->view(ucwords($this->router->fetch_class()).'/login-form',$data);
				$this->load->view(ucwords($this->router->fetch_class()).'/footer');
				 
       		 }
       		


                

		}
	
}
