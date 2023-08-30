<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Formrights extends CI_Controller {

  function __construct(){

    parent::__construct();

    if($this->session->userdata('logged_in') && $this->session->userdata['logged_in']['admin']==1){

      $this->load->model('common_model');
      $this->load->model('formrights_model');
      $this->load->model('form_model');

		}else{

      redirect('login','refresh');

		}

  }



  public function index(){

    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

    $table='formrights_master';

    include('pagination.php');

    $data['formrights']=$this->formrights_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

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

    $data['user']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);
    $data['modules']=$this->common_model->select_active_drop_down_noncompany('module_master');

    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

    $this->load->view('Home/footer');
  }

  public function save(){
    
    $this->form_validation->set_rules('user','User' ,'required|xss_clean');
    $this->form_validation->set_rules('module','Module' ,'required|xss_clean');
    $this->form_validation->set_rules('form','Form' ,'required|xss_clean');

    if($this->form_validation->run()==FALSE){

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $data['user']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);
      $data['modules']=$this->common_model->select_active_drop_down_noncompany('module_master');

      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

      $this->load->view('Home/footer');

    }
    else{


      $view = (!empty($this->input->post('view'))) ? $this->input->post('view') : 0;
      $new = (!empty($this->input->post('new'))) ? $this->input->post('new') : 0;
      $modify = (!empty($this->input->post('modify'))) ? $this->input->post('modify') : 0;
      $delete = (!empty($this->input->post('delete'))) ? $this->input->post('delete') : 0;
      $copy = (!empty($this->input->post('copy'))) ? $this->input->post('copy') : 0;
      $dearchive = (!empty($this->input->post('dearchive'))) ? $this->input->post('dearchive') : 0;
	  $approval = (!empty($this->input->post('approval'))) ? $this->input->post('approval') : 0;

      $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'module_id'=>$this->input->post('module'),'user_id'=>$this->input->post('user'),'form_id'=>$this->input->post('form'),'view'=>$view,'new'=>$new,'modify'=>$modify,'delete'=>$delete,'copy'=>$copy,'dearchive'=>$dearchive,'approval'=>$approval,'archive'=>'0');
      $result=$this->common_model->save('formrights_master',$data);


        if($result==1){
          

          $data['user']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);
          $data['modules']=$this->common_model->select_active_drop_down_noncompany('module_master');

          $data['note']='Create Transaction Completed';
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
    $data['formrights']=$this->common_model->select_one_active_record('formrights_master',$this->session->userdata['logged_in']['company_id'],'formrights_id',$this->uri->segment(3));
    
    $data['user']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);
    $data['modules']=$this->common_model->select_active_drop_down_noncompany('module_master');
    $data['form']=$this->common_model->select_active_drop_down('form_master',$this->session->userdata['logged_in']['company_id']);

    $data['page_name']='setup';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    $this->load->view('Home/header');
    $this->load->view('Home/nav',$data);
    $this->load->view('Home/subnav');
    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
    $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
    $this->load->view('Home/footer');
  }


  public function update(){
    $this->form_validation->set_rules('user','User' ,'required|xss_clean');
    $this->form_validation->set_rules('module','Module' ,'required|xss_clean');
    $this->form_validation->set_rules('form','Form' ,'required|xss_clean');

    if($this->form_validation->run()==FALSE){
      $data['page_name']='setup';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
      $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
      $this->load->view('Home/footer');
    }else{

        $view = (!empty($this->input->post('view'))) ? $this->input->post('view') : 0;
        $new = (!empty($this->input->post('new'))) ? $this->input->post('new') : 0;
        $modify = (!empty($this->input->post('modify'))) ? $this->input->post('modify') : 0;
        $delete = (!empty($this->input->post('delete'))) ? $this->input->post('delete') : 0;
        $copy = (!empty($this->input->post('copy'))) ? $this->input->post('copy') : 0;
        $dearchive = (!empty($this->input->post('dearchive'))) ? $this->input->post('dearchive') : 0;
		$approval = (!empty($this->input->post('approval'))) ? $this->input->post('approval') : 0;

        $data=array('module_id'=>$this->input->post('module'),'user_id'=>$this->input->post('user'),'form_id'=>$this->input->post('form'),'view'=>$view,'new'=>$new,'modify'=>$modify,'delete'=>$delete,'copy'=>$copy,'dearchive'=>$dearchive,'approval'=>$approval,'archive'=>'2');

        $result=$this->common_model->update_one_active_record('formrights_master',$data,'formrights_id',$this->input->post('formrights_id'),$this->session->userdata['logged_in']['company_id']);

        if($result==1){

          $data['user']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);
          $data['modules']=$this->common_model->select_active_drop_down_noncompany('module_master');
          $data['form']=$this->common_model->select_active_drop_down('form_master',$this->session->userdata['logged_in']['company_id']);

          $data['formrights']=$this->common_model->select_one_active_record('formrights_master',$this->session->userdata['logged_in']['company_id'],'formrights_id',$this->input->post('formrights_id'));

          $data['note']='Update Transaction completed';
          $data['page_name']='setup';
          $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
          $this->load->view('Home/header');
          $this->load->view('Home/nav',$data);
          $this->load->view('Home/subnav');
          $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
          $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
          $this->load->view('Home/footer');

        }else{

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


  function delete(){
    $data=array('archive'=>'1');
    $result=$this->common_model->update_one_active_record('formrights_master',$data,'formrights_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);
    if($result==1){
      $data['formrights']=$this->common_model->select_one_inactive_record('formrights_master',$this->session->userdata['logged_in']['company_id'],'formrights_id',$this->uri->segment(3));

      $data['user']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);
      $data['modules']=$this->common_model->select_active_drop_down_noncompany('module_master');
      $data['form']=$this->common_model->select_active_drop_down('form_master',$this->session->userdata['logged_in']['company_id']);

      $data['note']='Delete Transaction completed';
      $data['page_name']='setup';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
      $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
      $this->load->view('Home/footer');
    }else{
        $data['note']='Error in Delete Transaction';
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
    
    $table="formrights_master";
    include('pagination_archive.php');
    $data['formrights']=$this->formrights_model->select_archive_records($config["per_page"],$this->uri->segment(3),'formrights_master',$this->session->userdata['logged_in']['company_id']);
    
    $data['page_name']='setup';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    $this->load->view('Home/header');
    $this->load->view('Home/nav',$data);
    $this->load->view('Home/subnav');
    $this->load->view(ucwords($this->router->fetch_class()).'/archive-title');
    $this->load->view(ucwords($this->router->fetch_class()).'/archive-records',$data);
    $this->load->view('Home/footer');
  }

  function dearchive(){
    $data=array('archive'=>'2');
    $result=$this->common_model->update_one_active_record('formrights_master',$data,'formrights_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);
    if($result==1){
      $data['formrights']=$this->common_model->select_one_active_record('formrights_master',$this->session->userdata['logged_in']['company_id'],'formrights_id',$this->uri->segment(3));

      $data['user']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);
      $data['modules']=$this->common_model->select_active_drop_down_noncompany('module_master');
      $data['form']=$this->common_model->select_active_drop_down('form_master',$this->session->userdata['logged_in']['company_id']);

      $data['page_name']='setup';
      $data['note']='Dearchive Transaction completed';
      $data['page_name']='setup';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
      $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
      $this->load->view('Home/footer');
    }else{
        $data['note']='Error in Dearchive Transaction';
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
    
    $data['user']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);
    $data['modules']=$this->common_model->select_active_drop_down_noncompany('module_master');
    $data['form']=$this->common_model->select_active_drop_down('form_master',$this->session->userdata['logged_in']['company_id']);
    $this->load->view('Home/header');
    $this->load->view('Home/nav',$data);
    $this->load->view('Home/subnav');
    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
    $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
    $this->load->view('Home/footer');
  }


  public function search_result(){
    $this->form_validation->set_rules('user','User' ,'xss_clean');
    $this->form_validation->set_rules('module','Module' ,'xss_clean');
    $this->form_validation->set_rules('form','Form' ,'xss_clean');

      if($this->form_validation->run()==FALSE){
        $data['page_name']='setup';
        $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
        
        $this->load->view('Home/header');
        $this->load->view('Home/nav',$data);
        $this->load->view('Home/subnav');
        $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
        $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
        $this->load->view('Home/footer');
      }else{

       $data=array('user_id'=>$this->input->post('user'),'module_id'=>$this->input->post('module'));

        $data['formrights']=$this->formrights_model->select_active_search_records('formrights_master',$this->session->userdata['logged_in']['company_id'],$data);
        if($data['formrights']){
          $data['page_name']='setup';
          $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
          $this->load->view('Home/header');
          $this->load->view('Home/nav',$data);
          $this->load->view('Home/subnav');
          $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
          $this->load->view(ucwords($this->router->fetch_class()).'/active-records');
          $this->load->view('Home/footer');
          }else{
            $data['page_name']='setup';
            $data['note']='No Search Record Found';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title'); 
            $this->load->view(ucwords($this->router->fetch_class()).'/search-form');
            $this->load->view('Home/footer');
          }
      }
  
  }



}
