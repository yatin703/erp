<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Property extends CI_Controller {



	function __construct(){

    parent::__construct();

    if($this->session->userdata('logged_in') && $this->session->userdata['logged_in']['admin']==1){

      $this->load->model('common_model');
      $this->load->model('property_model');

		}else{

			redirect('login','refresh');

		}

  }



  public function index(){

    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

    $table='property_master';

    include('pagination_noncompany_withlanguage.php');

    $data['property']=$this->property_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['language_id']);

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

    $data['master_property']=$this->property_model->select_active_drop_down_master_property('master_property_master',$this->session->userdata['logged_in']['language_id']);

    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

    $this->load->view('Home/footer');
  }

  public function save(){
    
    $this->form_validation->set_rules('master_property','Master Property' ,'required|xss_clean');
    $this->form_validation->set_rules('property','Property' ,'required|xss_clean|is_unique[property_master.lang_property_name]|max_length[64]');

    if($this->form_validation->run()==FALSE){

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $data['master_property']=$this->property_model->select_active_drop_down_master_property('master_property_master',$this->session->userdata['logged_in']['language_id']);

      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

      $this->load->view('Home/footer');

    }
    else{


        $table='property_master';

        $max_pkey=0;
        $result=$this->common_model->select_max_pkey_noncompany('property_master','property_id'); 
        
        foreach($result as $row){
          $max_pkey=$row->property_id;
        }

        $property_id=$max_pkey+1;
        $data=array('property_id'=>$property_id,'master_property_id'=>$this->input->post('master_property'),'lang_property_name'=>$this->input->post('property'),'archive'=>'0','language_id'=>$this->session->userdata['logged_in']['language_id']);
        $result=$this->common_model->save($table,$data);

        if($result==1){
          $data['page_name']='setup';
          $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

          $data['master_property']=$this->property_model->select_active_drop_down_master_property('master_property_master',$this->session->userdata['logged_in']['language_id']);
          
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
    $data['property']=$this->property_model->select_one_active_record_noncompany_withlanguage('property_master','property_id',$this->uri->segment(3),$this->session->userdata['logged_in']['language_id']);
    $data['master_property']=$this->property_model->select_active_drop_down_master_property('master_property_master',$this->session->userdata['logged_in']['language_id']);

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
    $this->form_validation->set_rules('master_property','Master Property' ,'required|xss_clean');
    $this->form_validation->set_rules('property','Property' ,'required|xss_clean|max_length[64]');
    if($this->form_validation->run()==FALSE){
      $data['property']=$this->property_model->select_one_active_record_noncompany_withlanguage('property_master','property_id',$this->input->post('property_id'),$this->session->userdata['logged_in']['language_id']);
      $data['master_property']=$this->property_model->select_active_drop_down_master_property('master_property_master',$this->session->userdata['logged_in']['language_id']);
      $data['page_name']='setup';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
      $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
      $this->load->view('Home/footer');
    }else{

        $data=array('master_property_id'=>$this->input->post('master_property'),'language_id'=>$this->session->userdata['logged_in']['language_id'],'lang_property_name'=>$this->input->post('property'),'archive'=>'2');

        $result=$this->property_model->update_one_active_record_noncompany_withlanguage('property_master',$data,'property_id',$this->input->post('property_id'),$this->session->userdata['logged_in']['language_id']);

        if($result==1){

          $data['property']=$this->property_model->select_one_active_record_noncompany_withlanguage('property_master','property_id',$this->input->post('property_id'),$this->session->userdata['logged_in']['language_id']);
          $data['master_property']=$this->property_model->select_active_drop_down_master_property('master_property_master',$this->session->userdata['logged_in']['language_id']);
          header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
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
    $result=$this->property_model->update_one_active_record_noncompany_withlanguage('property_master',$data,'property_id',$this->uri->segment(3),$this->session->userdata['logged_in']['language_id']);

    if($result==1){
      $data['property']=$this->property_model->select_one_archive_record_noncompany_withlanguage('property_master','property_id',$this->uri->segment(3),$this->session->userdata['logged_in']['language_id']);
      $data['master_property']=$this->property_model->select_active_drop_down_master_property('master_property_master',$this->session->userdata['logged_in']['language_id']);
      header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
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
    
    $table="property_master";
    include('pagination_archive_noncompany_withlanguage.php');
    $data['property']=$this->property_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['language_id']);
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
    $result=$this->property_model->update_one_active_record_noncompany_withlanguage('property_master',$data,'property_id',$this->uri->segment(3),$this->session->userdata['logged_in']['language_id']);

    if($result==1){
      $data['property']=$this->property_model->select_one_archive_record_noncompany_withlanguage('property_master','property_id',$this->uri->segment(3),$this->session->userdata['logged_in']['language_id']);
      $data['master_property']=$this->property_model->select_active_drop_down_master_property('master_property_master',$this->session->userdata['logged_in']['language_id']);

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
    $data['master_property']=$this->property_model->select_active_drop_down_master_property('master_property_master',$this->session->userdata['logged_in']['language_id']);
    
    $this->load->view('Home/header');
    $this->load->view('Home/nav',$data);
    $this->load->view('Home/subnav');
    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
    $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
    $this->load->view('Home/footer');
  }


  public function search_result(){
    $this->form_validation->set_rules('master_property','Master Property' ,'xss_clean');
    $this->form_validation->set_rules('property','Property' ,'xss_clean|max_length[64]');

      if($this->form_validation->run()==FALSE){
        $data['page_name']='setup';
        $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
        $data['master_property']=$this->property_model->select_active_drop_down_master_property('master_property_master',$this->session->userdata['logged_in']['language_id']);
        
        $this->load->view('Home/header');
        $this->load->view('Home/nav',$data);
        $this->load->view('Home/subnav');
        $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
        $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
        $this->load->view('Home/footer');
      }else{

        $data=array('master_property_id'=>$this->input->post('master_property'),
          'lang_property_name'=>$this->input->post('property'));
        $data['property']=$this->property_model->active_record_search('property_master',$data,$this->session->userdata['logged_in']['language_id']);
       
        $data['master_property']=$this->property_model->select_active_drop_down_master_property('master_property_master',$this->session->userdata['logged_in']['language_id']);
        if($data['property']){
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
