<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class User extends CI_Controller {

    function __construct(){
      parent::__construct();

      if($this->session->userdata('logged_in') && $this->session->userdata['logged_in']['admin']==1){

        $this->load->model('common_model');
        $this->load->model('login_model');
        $this->load->model('user_model');
      }else{
        redirect('login','refresh');
      }

    }



  public function index(){


    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

   
    $table='user_master';

    include('pagination.php');

    $data['user']=$this->user_model->select_active_records($config["per_page"], $this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
    

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


    $data['employee']=$this->common_model->select_active_drop_down('employee_master',$this->session->userdata['logged_in']['company_id']);

    $data['user_level']=$this->common_model->select_active_drop_down_noncompany_nonarchive('user_level_master');

    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

    $this->load->view('Home/footer');
  }

  public function save(){
    
    $this->form_validation->set_rules('employee','Employee' ,'xss_clean|required|is_unique[user_master.user_id]');
    $this->form_validation->set_rules('login_name','Login Name' ,'xss_clean|max_length[50]|trim|required');
    $this->form_validation->set_rules('password','Password' ,'xss_clean|max_length[50]|trim|required');
    $this->form_validation->set_rules('admin','Admin' ,'xss_clean');
    

    if($this->form_validation->run()==FALSE){

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $data['employee']=$this->common_model->select_active_drop_down('employee_master',$this->session->userdata['logged_in']['company_id']);

      $data['user_level']=$this->common_model->select_active_drop_down_noncompany_nonarchive('user_level_master');

      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

      $this->load->view('Home/footer');

    }
    else{

        $password = $this->login_model->cop_f_encrypt('pass',$this->input->post('password'),"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890-/.");

        $admin = (!empty($this->input->post('admin'))) ? $this->input->post('admin') : 0;

        $data=array('user_id'=>$this->input->post('employee'),'login_name'=>$this->input->post('login_name'),'company_id'=>$this->session->userdata['logged_in']['company_id'],'language_id'=>$this->session->userdata['logged_in']['language_id'],'admin'=>$admin,'user_level'=>$this->input->post('user_level'),'password'=>$password,'archive'=>'0');


         $result=$this->common_model->save('user_master',$data);

          if($result==1){

            $data['note']='Save Transaction Completed';

            $data['page_name']='setup';

            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

            $data['employee']=$this->common_model->select_active_drop_down('employee_master',$this->session->userdata['logged_in']['company_id']);

            $data['user_level']=$this->common_model->select_active_drop_down_noncompany_nonarchive('user_level_master');


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
   
    $data['user']=$this->common_model->select_one_active_record('user_master',$this->session->userdata['logged_in']['company_id'],'user_id',$this->uri->segment(3));

    $data['employee']=$this->common_model->select_active_drop_down('employee_master',$this->session->userdata['logged_in']['company_id']);

    $data['user_level']=$this->common_model->select_active_drop_down_noncompany_nonarchive('user_level_master');


    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

    $this->load->view('Home/footer');

  }



  public function update(){

    $this->form_validation->set_rules('employee','Employee' ,'xss_clean|required');
    $this->form_validation->set_rules('login_name','Login Name' ,'xss_clean|max_length[50]|trim|required');
    $this->form_validation->set_rules('password','Password' ,'xss_clean|max_length[50]|trim|required');
    $this->form_validation->set_rules('admin','Admin' ,'xss_clean');
    
     

    if($this->form_validation->run()==FALSE){

      
      $data['user']=$this->common_model->select_one_active_record('user_master',$this->session->userdata['logged_in']['company_id'],'user_id',$this->input->post('employee'));

      $data['employee']=$this->common_model->select_active_drop_down('employee_master',$this->session->userdata['logged_in']['company_id']);

      $data['user_level']=$this->common_model->select_active_drop_down_noncompany_nonarchive('user_level_master');


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

        $password = $this->login_model->cop_f_encrypt('pass',$this->input->post('password'),"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890-/.");

        $admin = (!empty($this->input->post('admin'))) ? $this->input->post('admin') : 0;

        $data=array('login_name'=>$this->input->post('login_name'),'company_id'=>$this->session->userdata['logged_in']['company_id'],'language_id'=>$this->session->userdata['logged_in']['language_id'],'admin'=>$admin,'user_level'=>$this->input->post('user_level'),'password'=>$password,'archive'=>'0');


          $result=$this->common_model->update_one_active_record('user_master',$data,'user_id',$this->input->post('employee'),$this->session->userdata['logged_in']['company_id']);
        
        if( $result==1){

            $data['note']='Update Transaction Completed';

            $data['user']=$this->common_model->select_one_active_record('user_master',$this->session->userdata['logged_in']['company_id'],'user_id',$this->input->post('employee'));

            $data['employee']=$this->common_model->select_active_drop_down('employee_master',$this->session->userdata['logged_in']['company_id']);

            $data['user_level']=$this->common_model->select_active_drop_down_noncompany_nonarchive('user_level_master');

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
    $result=$this->common_model->update_one_active_record('user_master',$data,'user_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

    if($result){

      $data['note']="Archive Transaction completed";

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
   
      $data['user']=$this->common_model->select_one_inactive_record('user_master',$this->session->userdata['logged_in']['company_id'],'user_id',$this->uri->segment(3));

      $data['employee']=$this->common_model->select_active_drop_down('employee_master',$this->session->userdata['logged_in']['company_id']);

      $data['user_level']=$this->common_model->select_active_drop_down_noncompany_nonarchive('user_level_master');

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

   
    $table='user_master';

    include('pagination_archive.php');

    $data['user']=$this->user_model->select_archive_records($config["per_page"], $this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/archive-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/archive-records',$data);

    $this->load->view('Home/footer');


  }


  function dearchive(){

    $data=array('archive'=>'0');
    $result=$this->common_model->update_one_active_record('user_master',$data,'user_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

    if($result){

      $data['note']="Dearchive Transaction completed";

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
     
      $data['user']=$this->common_model->select_one_active_record('user_master',$this->session->userdata['logged_in']['company_id'],'user_id',$this->uri->segment(3));

      $data['employee']=$this->common_model->select_active_drop_down('employee_master',$this->session->userdata['logged_in']['company_id']);

      $data['user_level']=$this->common_model->select_active_drop_down_noncompany_nonarchive('user_level_master');

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

    $data['employee']=$this->common_model->select_active_drop_down('employee_master',$this->session->userdata['logged_in']['company_id']);

    $data['user_level']=$this->common_model->select_active_drop_down_noncompany_nonarchive('user_level_master');

    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);

    $this->load->view('Home/footer');


  }


  public function search_result(){

    $this->form_validation->set_rules('user_id','User Id' ,'xss_clean');
    $this->form_validation->set_rules('employee','Employee' ,'xss_clean');
    $this->form_validation->set_rules('login_name','Login Name' ,'xss_clean|max_length[50]|trim');
    $this->form_validation->set_rules('password','Password' ,'xss_clean|max_length[50]|trim');
    $this->form_validation->set_rules('admin','Admin' ,'xss_clean');

    if($this->form_validation->run()==FALSE){

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $data['employee']=$this->common_model->select_active_drop_down('employee_master',$this->session->userdata['logged_in']['company_id']);

      $data['user_level']=$this->common_model->select_active_drop_down_noncompany_nonarchive('user_level_master');
     

      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);

      $this->load->view('Home/footer');

    }
    else{
      
          $admin = (!empty($this->input->post('admin'))) ? $this->input->post('admin') : 0;

          $data=array('user_id'=>$this->input->post('employee'),'login_name'=>$this->input->post('login_name'),'company_id'=>$this->session->userdata['logged_in']['company_id'],'language_id'=>$this->session->userdata['logged_in']['language_id'],'admin'=>$admin,'user_level'=>$this->input->post('user_level'));

          $data['user']=$this->user_model->active_record_search('user_master',$data,$this->session->userdata['logged_in']['company_id']);

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
