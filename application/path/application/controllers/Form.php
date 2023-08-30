<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Form extends CI_Controller {



	function __construct(){

    parent::__construct();

    if($this->session->userdata('logged_in') && $this->session->userdata['logged_in']['admin']==1){

      $this->load->model('common_model');

      $this->load->model('form_model');

		}else{

			redirect('login','refresh');

		}

  }



  public function index(){

    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

    $table='form_master';

    include('pagination.php');

    $data['form']=$this->form_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

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

    $data['modules']=$this->common_model->select_active_drop_down_noncompany('module_master');
    $data['parent']=$this->common_model->select_active_drop_down('form_master',$this->session->userdata['logged_in']['company_id']);

    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

    $this->load->view('Home/footer');
  }

  public function save(){
    
    $this->form_validation->set_rules('module','Module' ,'required|xss_clean');
    $this->form_validation->set_rules('form_name','Form Name' ,'required|xss_clean|is_unique[form_master.form_name]|max_length[64]');
    $this->form_validation->set_rules('file_name','File Name' ,'required|xss_clean|is_unique[form_master.file_name]|max_length[64]');

    $this->form_validation->set_rules('view','View' ,'required|xss_clean');
    $this->form_validation->set_rules('new','New' ,'xss_clean');
    $this->form_validation->set_rules('modify','Modify' ,'xss_clean');
    $this->form_validation->set_rules('delete','Delete' ,'xss_clean');
    $this->form_validation->set_rules('copy','Copy' ,'xss_clean');
    $this->form_validation->set_rules('dearchive','Dearchive' ,'xss_clean');

    if($this->form_validation->run()==FALSE){

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $data['modules']=$this->common_model->select_active_drop_down_noncompany('module_master');
      $data['parent']=$this->common_model->select_active_drop_down('form_master',$this->session->userdata['logged_in']['company_id']);

      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

      $this->load->view('Home/footer');

    }
    else{


        $table='form_master';
        $view = (!empty($this->input->post('view'))) ? $this->input->post('view') : 0;
        $new = (!empty($this->input->post('new'))) ? $this->input->post('new') : 0;
        $modify = (!empty($this->input->post('modify'))) ? $this->input->post('modify') : 0;
        $delete = (!empty($this->input->post('delete'))) ? $this->input->post('delete') : 0;
        $copy = (!empty($this->input->post('copy'))) ? $this->input->post('copy') : 0;
        $dearchive = (!empty($this->input->post('dearchive'))) ? $this->input->post('dearchive') : 0;

        $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'module_id'=>$this->input->post('module'),'form_name'=>$this->input->post('form_name'),'parent_form_id'=>$this->input->post('parent'),'file_name'=>$this->input->post('file_name'),'view'=>$view,'new'=>$new,'modify'=>$modify,'delete'=>$delete,'copy'=>$copy,'dearchive'=>$dearchive,'toc'=>$this->input->post('toc'),'archive'=>'0','icon'=>$this->input->post('icon'));
        $result=$this->common_model->save($table,$data);

        if($result==1){

          $data['note']='Save Transaction Completed';

          header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

          $data['page_name']='setup';
          $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
          $data['modules']=$this->common_model->select_active_drop_down_noncompany('module_master');
          $data['parent']=$this->common_model->select_active_drop_down('form_master',$this->session->userdata['logged_in']['company_id']);
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
    $data['form']=$this->common_model->select_one_active_record('form_master',$this->session->userdata['logged_in']['company_id'],'form_id',$this->uri->segment(3));
    $data['modules']=$this->common_model->select_active_drop_down('module_master',$this->session->userdata['logged_in']['company_id']);
    $data['parent']=$this->common_model->select_active_drop_down('form_master',$this->session->userdata['logged_in']['company_id']);

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
    $this->form_validation->set_rules('module','Module' ,'required|xss_clean');
    $this->form_validation->set_rules('form_name','Form Name' ,'required|xss_clean|max_length[64]');
    $this->form_validation->set_rules('file_name','File Name' ,'required|xss_clean|max_length[64]');

    $this->form_validation->set_rules('view','View' ,'required|xss_clean');
    $this->form_validation->set_rules('new','New' ,'xss_clean');
    $this->form_validation->set_rules('modify','Modify' ,'xss_clean');
    $this->form_validation->set_rules('delete','Delete' ,'xss_clean');
    $this->form_validation->set_rules('copy','Copy' ,'xss_clean');
    $this->form_validation->set_rules('dearchive','Archive' ,'xss_clean');

    if($this->form_validation->run()==FALSE){

      $data['form']=$this->common_model->select_one_active_record('form_master',$this->session->userdata['logged_in']['company_id'],'form_id',$this->input->post('form_id'));
      $data['modules']=$this->common_model->select_active_drop_down('module_master',$this->session->userdata['logged_in']['company_id']);
      $data['parent']=$this->common_model->select_active_drop_down('form_master',$this->session->userdata['logged_in']['company_id']);

      $data['page_name']='setup';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view(ucwords($this->router->fetch_class()).'/form-active-title');
      $this->load->view(ucwords($this->router->fetch_class()).'/form-modify-form',$data);
      $this->load->view('Home/footer');
    }else{

        $view = (!empty($this->input->post('view'))) ? $this->input->post('view') : 0;
        $new = (!empty($this->input->post('new'))) ? $this->input->post('new') : 0;
        $modify = (!empty($this->input->post('modify'))) ? $this->input->post('modify') : 0;
        $delete = (!empty($this->input->post('delete'))) ? $this->input->post('delete') : 0;
        $copy = (!empty($this->input->post('copy'))) ? $this->input->post('copy') : 0;
        $dearchive = (!empty($this->input->post('dearchive'))) ? $this->input->post('dearchive') : 0;

        $data=array('module_id'=>$this->input->post('module'),'form_name'=>$this->input->post('form_name'),'parent_form_id'=>$this->input->post('parent'),'file_name'=>$this->input->post('file_name'),'view'=>$view,'new'=>$new,'modify'=>$modify,'delete'=>$delete,'copy'=>$copy,'dearchive'=>$dearchive,'toc'=>$this->input->post('toc'),'archive'=>'2','icon'=>$this->input->post('icon'));

        $result=$this->common_model->update_one_active_record('form_master',$data,'form_id',$this->input->post('form_id'),$this->session->userdata['logged_in']['company_id']);

        if($result==1){

          $data['form']=$this->common_model->select_one_active_record('form_master',$this->session->userdata['logged_in']['company_id'],'form_id',$this->input->post('form_id'));
          $data['modules']=$this->common_model->select_active_drop_down('module_master',$this->session->userdata['logged_in']['company_id']);
          $data['parent']=$this->common_model->select_active_drop_down('form_master',$this->session->userdata['logged_in']['company_id']);

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
    $result=$this->common_model->update_one_active_record('form_master',$data,'form_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);
    if($result==1){
      $data['form']=$this->common_model->select_one_inactive_record('form_master',$this->session->userdata['logged_in']['company_id'],'form_id',$this->uri->segment(3));
      
      $data['modules']=$this->common_model->select_active_drop_down('module_master',$this->session->userdata['logged_in']['company_id']);
      $data['parent']=$this->common_model->select_active_drop_down('form_master',$this->session->userdata['logged_in']['company_id']);

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
    
    $table="form_master";
    include('archive_pagination.php');
    $data['form']=$this->form_model->select_archive_records($config["per_page"],$this->uri->segment(3),'form_master',$this->session->userdata['logged_in']['company_id']);
    $data['modules']=$this->common_model->select_active_drop_down('module_master',$this->session->userdata['logged_in']['company_id']);
    $data['parent']=$this->common_model->select_active_drop_down('form_master',$this->session->userdata['logged_in']['company_id']);

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
    $result=$this->common_model->update_one_active_record('form_master',$data,'form_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);
    if($result==1){
      $data['form']=$this->common_model->select_one_active_record('form_master',$this->session->userdata['logged_in']['company_id'],'form_id',$this->uri->segment(3));
      $data['page_name']='setup';
      $data['modules']=$this->common_model->select_active_drop_down('module_master',$this->session->userdata['logged_in']['company_id']);
      $data['parent']=$this->common_model->select_active_drop_down('form_master',$this->session->userdata['logged_in']['company_id']);

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
    $data['modules']=$this->common_model->select_active_drop_down('module_master',$this->session->userdata['logged_in']['company_id']);
    $data['parent']=$this->common_model->select_active_drop_down('form_master',$this->session->userdata['logged_in']['company_id']);
    $this->load->view('Home/header');
    $this->load->view('Home/nav',$data);
    $this->load->view('Home/subnav');
    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
    $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
    $this->load->view('Home/footer');
  }


  public function search_result(){
      $this->form_validation->set_rules('module','Module' ,'xss_clean');
      $this->form_validation->set_rules('form_name','Form Name' ,'xss_clean|max_length[64]');
      $this->form_validation->set_rules('file_name','File Name' ,'xss_clean|trim|max_length[64]');

      $this->form_validation->set_rules('view','View' ,'xss_clean');
      $this->form_validation->set_rules('new','New' ,'xss_clean');
      $this->form_validation->set_rules('modify','Modify' ,'xss_clean');
      $this->form_validation->set_rules('delete','Delete' ,'xss_clean');
      $this->form_validation->set_rules('copy','Archive' ,'xss_clean');
      $this->form_validation->set_rules('dearchive','Archive' ,'xss_clean');

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

        $view = (!empty($this->input->post('view'))) ? $this->input->post('view') : '';
        $new = (!empty($this->input->post('new'))) ? $this->input->post('new') : '';
        $modify = (!empty($this->input->post('modify'))) ? $this->input->post('modify') : '';
        $delete = (!empty($this->input->post('delete'))) ? $this->input->post('delete') : '';
        $copy = (!empty($this->input->post('copy'))) ? $this->input->post('copy') : '';
        $dearchive = (!empty($this->input->post('dearchive'))) ? $this->input->post('dearchive') : '';


        $data=array('module_id'=>$this->input->post('module'),
          'form_name'=>$this->input->post('form_name'),
          'file_name'=>$this->input->post('file_name'),
          'view'=>$view,
          'new'=>$new,
          'modify'=>$modify,
          'delete'=>$delete,
          'copy'=>$copy,
          'dearchive'=>$dearchive);
        $data['form']=$this->form_model->active_record_search('form_master',$data,$this->session->userdata['logged_in']['company_id']);
        if($data['form']){
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
            $data['note']='No Search Record';
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
