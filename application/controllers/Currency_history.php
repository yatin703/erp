<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Currency_history extends CI_Controller {



	function __construct(){

    parent::__construct();

    if($this->session->userdata('logged_in')){

      $this->load->model('common_model');
      $this->load->model('country_model');
      $this->load->model('currency_model');
    


		}else{

			redirect('login','refresh');

		}

  }

  public function index(){
	  
	$data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){  

				$country_id=$this->uri->segment(3);
				$for_currency=$this->uri->segment(4);
				$to_currency=$this->uri->segment(5);

				$pkey=array('country_id'=>$country_id,
							'for_currency'=>$for_currency,
							'to_currency'=>$to_currency
							);

				$table='currency_rates_master';
				$data['currency_rates_master']=$this->currency_model->select_one_active_record($table,$pkey);
				
				$table='currency_history';
				$data['currency_history']=$this->currency_model->select_history_records($table,$pkey);
				

				$data['page_name']='setup';

				$data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

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

  public function create(){
	  
	$data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->new==1){  

    
				$country_id=$this->uri->segment(3);
				$for_currency=$this->uri->segment(4);
				$to_currency=$this->uri->segment(5);

				$pkey=array('country_id'=>$country_id,
								   'for_currency'=>$for_currency,
								   'to_currency'=>$to_currency
								   );
				$table='currency_rates_master';
				$data['currency_rates_master']=$this->currency_model->select_one_active_record($table,$pkey);  
				
				$data['country_master_lang']=$this->country_model->select_one_active_record('country_master','country_master.country_id',$country_id);

				$data['page_name']='Sales';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
				
				  $this->load->view('Home/header');
				  $this->load->view('Home/nav',$data);
				  $this->load->view('Home/subnav');
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


  public function save(){
	  
	$data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
			if($formrights_row->new==1){  

				$this->form_validation->set_rules('country_id','Country','required|xss_clean');
				$this->form_validation->set_rules('for_currency','For Currency','required|xss_clean');
				$this->form_validation->set_rules('to_currency','To Currency','required|xss_clean');
				$this->form_validation->set_rules('exchange_rate','Exchange rate','required|xss_clean|max_length[10]');

				if( $this->form_validation->run()==FALSE){

				  

				  $country_id=$this->input->post('country_id');
				  $for_currency=$this->input->post('for_currency');
				  $to_currency=$this->input->post('to_currency');

				  $pkey=array('country_id'=>$country_id,
								   'for_currency'=>$for_currency,
								   'to_currency'=>$to_currency
								   );
				  $table='currency_rates_master';
				  $data['currency_rates_master']=$this->currency_model->select_one_active_record($table,$pkey);  
				
				  $data['country_master_lang']=$this->country_model->select_one_active_record('country_master','country_master.country_id',$country_id);


				$data['page_name']='Sales';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

				  $this->load->view('Home/header');
				  $this->load->view('Home/nav',$data);
				  $this->load->view('Home/subnav');
				  $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
				  $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
				  $this->load->view('Home/footer');



				}
				else{


				   $country_id=$this->input->post('country_id');
				   $for_currency=$this->input->post('for_currency');
				   $to_currency=$this->input->post('to_currency');
				   $exchange_rate=($this->input->post('exchange_rate')!=0?$this->input->post('exchange_rate')*100 :'');

					$data=array('country_id'=>$country_id,
							  'for_currency'=>$for_currency,
							  'to_currency'=>$to_currency,
							  'exchange_rate'=>$exchange_rate,
							  'date_created'=>date('Y-m-d H:s:i')
							);
				
					$table='currency_history';

					$result=$this->common_model->save($table,$data);

					if($result==1){

					  $data['note']='Save Transaction Completed';
					  header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class().'/index/'.$country_id.'/'.$for_currency.'/'.$to_currency);

					  $pkey=array('country_id'=>$country_id,
							  'for_currency'=>$for_currency,
							  'to_currency'=>$to_currency
							  );
					  
					  $table='currency_history';
					  
					  $data['currency_history']=$this->currency_model->select_history_records($table,$pkey);
					 // echo $this->db->last_query();
					  
					  $table='currency_rates_master';
					  $data['currency_rates_master']=$this->currency_model->select_one_active_record($table,$pkey); 

					$data['page_name']='Sales';
					$data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
					$data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

					  $this->load->view('Home/header');
					  $this->load->view('Home/nav',$data);
					  $this->load->view('Home/subnav');
					  $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
					  $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
					  $this->load->view('Home/footer');


					}
					else{


					  $data['note']='Error in Save Transaction.';
					  header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class().'/index/'.$country_id.'/'.$for_currency.'/'.$to_currency);

					  $pkey=array('country_id'=>$country_id,
							  'for_currency'=>$for_currency,
							  'to_currency'=>$to_currency
							  );
					  
					  $table='currency_history';
					  $data['currency_history']=$this->currency_model->select_history_records($table,$pkey);
					  
					  $table='currency_rates_master';
					  $data['currency_rates_master']=$this->currency_model->select_one_active_record($table,$pkey); 

					  $data['page_name']='Sales';
					  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                      $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

					  $this->load->view('Home/header');
					  $this->load->view('Home/nav',$data);
					  $this->load->view('Home/subnav');
					  $this->load->view('Error/error-title',$data);
					  $this->load->view('Home/footer');




					}
			   
				}
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


 } 