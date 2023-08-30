<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Autogeneration extends CI_Controller {



	function __construct(){

    parent::__construct();

    if($this->session->userdata('logged_in') && $this->session->userdata['logged_in']['admin']==1){

      $this->load->model('common_model');
      $this->load->model('autogeneration_model');

		}else{

			redirect('login','refresh');

		}

  }



  public function index(){


    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

    $table='autogeneration_format_master';

    $data['autogeneration']=$this->autogeneration_model->select_active_records($table,$this->session->userdata['logged_in']['company_id']);

  	$this->load->view('Home/header');

  	$this->load->view('Home/nav',$data);

  	$this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

  	$this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);

  	$this->load->view('Home/footer');

  }

  public function create(){
    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);


    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

    $this->load->view('Home/footer');
  }

  public function save(){
    
    $this->form_validation->set_rules('name1','First Name' ,'xss_clean|max_length[50]|strtoupper|trim');
    $this->form_validation->set_rules('name2','Last Name' ,'xss_clean|max_length[50]|strtoupper|trim');
    $this->form_validation->set_rules('gender','Gender' ,'xss_clean|max_length[10]|strtoupper');
    $this->form_validation->set_rules('marital_status','Marital Status' ,'xss_clean|required');
    $this->form_validation->set_rules('address','Address' ,'xss_clean|required');
    $this->form_validation->set_rules('country','Country' ,'required|xss_clean');
    $this->form_validation->set_rules('mailbox','Mail Box' ,'required|xss_clean|max_length[50]');
    $this->form_validation->set_rules('mobile_no','Mobile No' ,'required|xss_clean|max_length[25]');
    $this->form_validation->set_rules('dob','Date Of Birth' ,'required|xss_clean|exact_length[10]');
    $this->form_validation->set_rules('department','Department' ,'xss_clean|required');
    $this->form_validation->set_rules('hire_date','Date of Joining' ,'xss_clean|required|exact_length[10]');
    $this->form_validation->set_rules('exit_date','Date of Exit' ,'xss_clean|exact_length[10]');
    

    if($this->form_validation->run()==FALSE){

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      


      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

      $this->load->view('Home/footer');

    }
    else{

           $data=array('zip_code'=>$this->input->post('zip_code'),
                       'lang_city'=>ucwords($this->input->post('lang_city')),
                       'state_code'=>$this->input->post('state_code'), 
                       'zone_id'=>$this->input->post('zone_id'),
                       'country_id'=>$this->input->post('country_id'),
                       'language_id'=>$this->session->userdata['logged_in']['language_id'],
                       'archive'=>'0'
                       );


          $result=$this->common_model->save('zip_code_master',$data);

          if($result==1){

            $data['note']='Save Transaction Completed';

             redirect('/state');
          }
          else{

            $data['note']='Error in Save Transaction';

            $data['page_name']='setup';

            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

            $this->load->view('Home/header');

            $this->load->view('Home/nav',$data);

            $this->load->view('Home/subnav');

            $this->load->view('Error/error-title',$data);

            $this->load->view('Home/footer');

        }

    }


    
  }




  function modify(){

    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
   
    $data['state']=$this->state_model->select_one_active_record('zip_code_master','zip_code',$this->uri->segment(3),$this->session->userdata['logged_in']['language_id']);

   $data['zone']=$this->state_model->select_active_drop_down('zone_master_lang',$this->session->userdata['logged_in']['language_id']);
    $data['country']=$this->country_model->select_active_drop_down('country_master');


    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

    $this->load->view('Home/footer');

  }



  public function update(){

      $this->form_validation->set_rules('lang_city','State' ,'required|xss_clean|max_length[50]');
      $this->form_validation->set_rules('state_code','State Code' ,'xss_clean|max_length[5]');
      $this->form_validation->set_rules('zone_id','Zone' ,'xss_clean|max_length[5]');
      $this->form_validation->set_rules('country_id','Country' ,'required|xss_clean|max_length[5]');
     

    if($this->form_validation->run()==FALSE){

      
      $data['state']=$this->state_model->select_one_active_record('zip_code_master','zip_code',$this->input->post('zip_code'),$this->session->userdata['logged_in']['language_id']);

     $data['zone']=$this->state_model->select_active_drop_down('zone_master_lang',$this->session->userdata['logged_in']['language_id']);

      $data['country']=$this->country_model->select_active_drop_down('country_master');

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

      $this->load->view('Home/footer');

    }
    else{

          $data=array( 'lang_city'=>ucwords($this->input->post('lang_city')),
                       'state_code'=>$this->input->post('state_code'), 
                       'zone_id'=>$this->input->post('zone_id'),
                       'country_id'=>$this->input->post('country_id')
                      );


        $result=$this->state_model->update_one_active_record_noncompany('zip_code_master',$data,'zip_code',$this->input->post('zip_code'),$this->session->userdata['logged_in']['language_id']);
        
        if( $result==1){

            $data['note']='Update Transaction Completed';

            $data['state']=$this->state_model->select_one_active_record('zip_code_master','zip_code',$this->input->post('zip_code'),$this->session->userdata['logged_in']['language_id']);

            $data['zone']=$this->state_model->select_active_drop_down('zone_master_lang',$this->session->userdata['logged_in']['language_id']);

            $data['country']=$this->country_model->select_active_drop_down('country_master');

            $data['page_name']='setup';

            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

            $this->load->view('Home/header');

            $this->load->view('Home/nav',$data);

            $this->load->view('Home/subnav');

            $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

            $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

            $this->load->view('Home/footer');


        }
        else{

          $data['note']='Error in Update Transaction';

          $data['page_name']='setup';

          $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

          $this->load->view('Home/header');

          $this->load->view('Home/nav',$data);

          $this->load->view('Home/subnav');

          $this->load->view('Error/error-title',$data);

          $this->load->view('Home/footer');

        }

    }
    
  }

  public function delete(){

    $data=array('archive'=>'1');
    $result=$this->state_model->update_one_active_record_noncompany('zip_code_master',$data,'zip_code',$this->uri->segment(3),$this->session->userdata['logged_in']['language_id']);

    if($result){

      $data['note']="Archive Transaction completed";

      $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
   
    $data['state']=$this->state_model->select_one_active_record('zip_code_master','zip_code',$this->uri->segment(3),$this->session->userdata['logged_in']['language_id']);

   $data['zone']=$this->state_model->select_active_drop_down('zone_master_lang',$this->session->userdata['logged_in']['language_id']);
    $data['country']=$this->country_model->select_active_drop_down('country_master');


    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

    $this->load->view('Home/footer');


    }
    else{
        $data['note']='Error in Archive Transaction';

        $data['page_name']='setup';

        $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

        $this->load->view('Home/header');

        $this->load->view('Home/nav',$data);

        $this->load->view('Home/subnav');

        $this->load->view('Error/error-title',$data);

        $this->load->view('Home/footer');



    }

  }

  function archive_records(){

    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

   
     $table='employee_master';

    include('pagination_archive.php');

    $data['employee']=$this->common_model->select_archive_records($config["per_page"], $this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/archive-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/archive-records',$data);

    $this->load->view('Home/footer');


  }


  function dearchive(){

    $data=array('archive'=>'0');
    $result=$this->state_model->update_one_active_record_noncompany('zip_code_master',$data,'zip_code',$this->uri->segment(3),$this->session->userdata['logged_in']['language_id']);

    if($result){

      $data['note']="Dearchive Transaction completed";

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
     
      $data['state']=$this->state_model->select_one_active_record('zip_code_master','zip_code',$this->uri->segment(3),$this->session->userdata['logged_in']['language_id']);

     $data['zone']=$this->state_model->select_active_drop_down('zone_master_lang',$this->session->userdata['logged_in']['language_id']);
      $data['country']=$this->country_model->select_active_drop_down('country_master');


      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

      $this->load->view('Home/footer');


    }
    else{
        $data['note']='Error in Archive Transaction';

        $data['page_name']='setup';

        $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

        $this->load->view('Home/header');

        $this->load->view('Home/nav',$data);

        $this->load->view('Home/subnav');

        $this->load->view('Error/error-title',$data);

        $this->load->view('Home/footer');



    }

  }

  public function search(){

    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

    $data['zone']=$this->state_model->select_active_drop_down('zone_master_lang',$this->session->userdata['logged_in']['language_id']);
    $data['country']=$this->country_model->select_active_drop_down('country_master');

    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);

    $this->load->view('Home/footer');


  }


  public function search_result(){

    
     $this->form_validation->set_rules('zip_code','Short Id' ,'xss_clean|max_length[15]');
    $this->form_validation->set_rules('lang_city','State' ,'xss_clean|max_length[50]');
    $this->form_validation->set_rules('state_code','State Code' ,'xss_clean|max_length[5]');
    $this->form_validation->set_rules('zone_id','Zone' ,'xss_clean|max_length[5]');
    $this->form_validation->set_rules('country_id','Country' ,'xss_clean|max_length[5]');

    if($this->form_validation->run()==FALSE){

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $data['zone']=$this->state_model->select_active_drop_down('zone_master_lang',$this->session->userdata['logged_in']['language_id']);
      $data['country']=$this->country_model->select_active_drop_down('country_master');

      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);

      $this->load->view('Home/footer');

    }
    else{
          $data=array('zip_code'=>$this->input->post('zip_code'),
                       'lang_city'=>ucwords($this->input->post('lang_city')),
                       'state_code'=>$this->input->post('state_code'), 
                       'zone_id'=>$this->input->post('zone_id'),
                       'country_id'=>$this->input->post('country_id'),
                       
                       );

          $data['state']=$this->state_model->active_record_search('zip_code_master',$data,$this->session->userdata['logged_in']['language_id']);

          $data['page_name']='setup';

          $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);


          $this->load->view('Home/header');

          $this->load->view('Home/nav',$data);

          $this->load->view('Home/subnav');

          $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

          $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);

          $this->load->view('Home/footer');
         

    }

  }




}
