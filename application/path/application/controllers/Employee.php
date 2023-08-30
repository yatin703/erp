<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Employee extends CI_Controller {



	function __construct(){

    parent::__construct();

    if($this->session->userdata('logged_in') && $this->session->userdata['logged_in']['admin']==1){

      $this->load->model('common_model');
      $this->load->model('country_model');
      $this->load->model('employee_model');


		}else{

			redirect('login','refresh');

		}

  }



  public function index(){


    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

   
    $table='employee_master';

    include('pagination.php');

    $data['employee']=$this->common_model->select_active_records($config["per_page"], $this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

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

    $data['country']=$this->country_model->select_active_drop_down('country_master');

    $data['department']=$this->common_model->select_active_drop_down_noncompany_withlanguage('departments_master',$this->session->userdata['logged_in']['language_id']);

    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

    $this->load->view('Home/footer');
  }

  public function save(){
    
    $this->form_validation->set_rules('name1','First Name' ,'xss_clean|max_length[50]|strtoupper|trim|required');
    $this->form_validation->set_rules('name2','Last Name' ,'xss_clean|max_length[50]|strtoupper|trim|required');
    $this->form_validation->set_rules('gender','Gender' ,'xss_clean|max_length[10]|strtoupper|required');
    $this->form_validation->set_rules('marital_status','Marital Status' ,'xss_clean|required');
    $this->form_validation->set_rules('street','Address' ,'xss_clean|required|strtoupper');
    $this->form_validation->set_rules('country','Country' ,'required|xss_clean');
    $this->form_validation->set_rules('mailbox','Email' ,'required|xss_clean|max_length[50]|strtolower');
    $this->form_validation->set_rules('mobile_no','Mobile No' ,'required|xss_clean|max_length[25]');
    $this->form_validation->set_rules('dob','Date Of Birth' ,'required|xss_clean|exact_length[10]');
    $this->form_validation->set_rules('department','Department' ,'xss_clean|required');
    $this->form_validation->set_rules('hire_date','Date of Joining' ,'xss_clean|required|exact_length[10]');
    $this->form_validation->set_rules('exit_date','Date of Exit' ,'xss_clean|exact_length[10]');
    

    if($this->form_validation->run()==FALSE){

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $data['country']=$this->country_model->select_active_drop_down('country_master');

      $data['department']=$this->common_model->select_active_drop_down_noncompany_withlanguage('departments_master',$this->session->userdata['logged_in']['language_id']);


      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

      $this->load->view('Home/footer');

    }
    else{

        $max_pkey=0;
        $result=$this->employee_model->select_max_pkey('employee_master','employee_id',$this->session->userdata['logged_in']['company_id']); 
        foreach($result as $row){

          $max_pkey=$row->employee_id;
          $max_pkey=substr($max_pkey,3);
        }

         $employee_id=$max_pkey+1;

        $data=array('employee_id'=>"EMP".$employee_id,'name1'=>$this->input->post('name1'),'name2'=>$this->input->post('name2'),'gender'=>$this->input->post('gender'),'marital_status'=>$this->input->post('marital_status'),'street'=>$this->input->post('street'),'country_id'=>$this->input->post('country'),'mailbox'=>$this->input->post('mailbox'),'mobile_no'=>$this->input->post('mobile_no'),'dob'=>$this->input->post('dob'),'department_id'=>$this->input->post('department'),'hire_date'=>$this->input->post('hire_date'),'exit_date'=>$this->input->post('exit_date'),'company_id'=>$this->session->userdata['logged_in']['company_id']);


         $result=$this->common_model->save('employee_master',$data);

          if($result==1){

            $data['note']='Save Transaction Completed';

            $data['page_name']='setup';

            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

            $data['country']=$this->country_model->select_active_drop_down('country_master');

            $data['department']=$this->common_model->select_active_drop_down_noncompany_withlanguage('departments_master',$this->session->userdata['logged_in']['language_id']);


            $this->load->view('Home/header');

            $this->load->view('Home/nav',$data);

            $this->load->view('Home/subnav');

            $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

            $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

            $this->load->view('Home/footer');

             
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
   
    $data['employee']=$this->common_model->select_one_active_record('employee_master',$this->session->userdata['logged_in']['company_id'],'employee_id',$this->uri->segment(3));

    $data['country']=$this->country_model->select_active_drop_down('country_master');

    $data['department']=$this->common_model->select_active_drop_down_noncompany_withlanguage('departments_master',$this->session->userdata['logged_in']['language_id']);


    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

    $this->load->view('Home/footer');

  }



  public function update(){

    $this->form_validation->set_rules('name1','First Name' ,'xss_clean|max_length[50]|strtoupper|trim|required');
    $this->form_validation->set_rules('name2','Last Name' ,'xss_clean|max_length[50]|strtoupper|trim|required');
    $this->form_validation->set_rules('gender','Gender' ,'xss_clean|max_length[10]|strtoupper|required');
    $this->form_validation->set_rules('marital_status','Marital Status' ,'xss_clean|required');
    $this->form_validation->set_rules('street','Address' ,'xss_clean|required|strtoupper');
    $this->form_validation->set_rules('country','Country' ,'required|xss_clean');
    $this->form_validation->set_rules('mailbox','Email' ,'required|xss_clean|max_length[50]|strtolower');
    $this->form_validation->set_rules('mobile_no','Mobile No' ,'required|xss_clean|max_length[25]');
    $this->form_validation->set_rules('dob','Date Of Birth' ,'required|xss_clean|exact_length[10]');
    $this->form_validation->set_rules('department','Department' ,'xss_clean|required');
    $this->form_validation->set_rules('hire_date','Date of Joining' ,'xss_clean|required|exact_length[10]');
    $this->form_validation->set_rules('exit_date','Date of Exit' ,'xss_clean|exact_length[10]');
    
     

    if($this->form_validation->run()==FALSE){

      
      $data['employee']=$this->common_model->select_one_active_record('employee_master',$this->session->userdata['logged_in']['company_id'],'employee_id',$this->input->post('employee_id'));


      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $data['country']=$this->country_model->select_active_drop_down('country_master');

      $data['department']=$this->common_model->select_active_drop_down_noncompany_withlanguage('departments_master',$this->session->userdata['logged_in']['language_id']);

      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

      $this->load->view('Home/footer');

    }
    else{

          $data=array('name1'=>$this->input->post('name1'),'name2'=>$this->input->post('name2'),'gender'=>$this->input->post('gender'),'marital_status'=>$this->input->post('marital_status'),'street'=>$this->input->post('street'),'country_id'=>$this->input->post('country'),'mailbox'=>$this->input->post('mailbox'),'mobile_no'=>$this->input->post('mobile_no'),'dob'=>$this->input->post('dob'),'department_id'=>$this->input->post('department'),'hire_date'=>$this->input->post('hire_date'),'exit_date'=>$this->input->post('exit_date'));


          $result=$this->common_model->update_one_active_record('employee_master',$data,'employee_id',$this->input->post('employee_id'),$this->session->userdata['logged_in']['company_id']);
        
        if( $result==1){

            $data['note']='Update Transaction Completed';

            $data['employee']=$this->common_model->select_one_active_record('employee_master',$this->session->userdata['logged_in']['company_id'],'employee_id',$this->input->post('employee_id'));

            $data['country']=$this->country_model->select_active_drop_down('country_master');

            $data['department']=$this->common_model->select_active_drop_down_noncompany_withlanguage('departments_master',$this->session->userdata['logged_in']['language_id']);

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
    $result=$this->common_model->update_one_active_record('employee_master',$data,'employee_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

    if($result){

      $data['note']="Archive Transaction completed";

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
   
      $data['employee']=$this->common_model->select_one_inactive_record('employee_master',$this->session->userdata['logged_in']['company_id'],'employee_id',$this->uri->segment(3));

      $data['country']=$this->country_model->select_active_drop_down('country_master');

      $data['department']=$this->common_model->select_active_drop_down_noncompany_withlanguage('departments_master',$this->session->userdata['logged_in']['language_id']);

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
    $result=$this->common_model->update_one_active_record('employee_master',$data,'employee_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

    if($result){

      $data['note']="Dearchive Transaction completed";

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
     
      $data['employee']=$this->common_model->select_one_active_record('employee_master',$this->session->userdata['logged_in']['company_id'],'employee_id',$this->uri->segment(3));

      $data['country']=$this->country_model->select_active_drop_down('country_master');

      $data['department']=$this->common_model->select_active_drop_down_noncompany_withlanguage('departments_master',$this->session->userdata['logged_in']['language_id']);

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

    $data['country']=$this->country_model->select_active_drop_down('country_master');

    $data['department']=$this->common_model->select_active_drop_down_noncompany_withlanguage('departments_master',$this->session->userdata['logged_in']['language_id']);

    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);

    $this->load->view('Home/footer');


  }


  public function search_result(){

    $this->form_validation->set_rules('name1','First Name' ,'xss_clean|max_length[50]|strtoupper|trim');
    $this->form_validation->set_rules('name2','Last Name' ,'xss_clean|max_length[50]|strtoupper|trim');
    $this->form_validation->set_rules('gender','Gender' ,'xss_clean|max_length[10]|strtoupper');
    $this->form_validation->set_rules('marital_status','Marital Status' ,'xss_clean');
    $this->form_validation->set_rules('street','Address' ,'xss_clean|strtoupper');
    $this->form_validation->set_rules('country','Country' ,'xss_clean');
    $this->form_validation->set_rules('mailbox','Email' ,'xss_clean|max_length[50]|strtolower');
    $this->form_validation->set_rules('mobile_no','Mobile No' ,'xss_clean|max_length[25]');
    $this->form_validation->set_rules('dob','Date Of Birth' ,'xss_clean|exact_length[10]');
    $this->form_validation->set_rules('department','Department' ,'xss_clean');
    $this->form_validation->set_rules('hire_date','Date of Joining' ,'xss_clean|exact_length[10]');
    $this->form_validation->set_rules('exit_date','Date of Exit' ,'xss_clean|exact_length[10]');

    if($this->form_validation->run()==FALSE){

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $data['country']=$this->country_model->select_active_drop_down('country_master');

      $data['department']=$this->common_model->select_active_drop_down_noncompany_withlanguage('departments_master',$this->session->userdata['logged_in']['language_id']);

      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);

      $this->load->view('Home/footer');

    }
    else{
          $data=array('name1'=>$this->input->post('name1'),'name2'=>$this->input->post('name2'),'gender'=>$this->input->post('gender'),'marital_status'=>$this->input->post('marital_status'),'street'=>$this->input->post('street'),'country_id'=>$this->input->post('country'),'mailbox'=>$this->input->post('mailbox'),'mobile_no'=>$this->input->post('mobile_no'),'dob'=>$this->input->post('dob'),'department_id'=>$this->input->post('department'),'hire_date'=>$this->input->post('hire_date'),'exit_date'=>$this->input->post('exit_date'));

          $data['employee']=$this->common_model->active_record_search('employee_master',$data,$this->session->userdata['logged_in']['company_id']);

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
