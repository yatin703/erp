<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Relate extends CI_Controller {



	function __construct(){

    parent::__construct();

    if($this->session->userdata('logged_in') && $this->session->userdata['logged_in']['admin']==1){

      $this->load->model('common_model');
      $this->load->model('property_model');
      $this->load->model('customer_model');
      $this->load->model('relate_model');

		}else{

			redirect('login','refresh');

		}

  }



  public function index(){

    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

    $table='adr_relate_companies';

    include('pagination_company_without_language.php');

    $data['relate']=$this->relate_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['language_id']);

    $this->db->last_query();

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

    $data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_details.property_id','1');

    $data['relate']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_details.property_id<>','1');

    $data['property']=$this->customer_model->select_active_property_drop_down('property_master',$this->session->userdata['logged_in']['language_id']);

    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

    $this->load->view('Home/footer');
  }

  public function save(){
    
    $this->form_validation->set_rules('customer','Customer' ,'required|xss_clean');
    $this->form_validation->set_rules('relate','Relate' ,'required|xss_clean');
    $this->form_validation->set_rules('property','Property' ,'required|xss_clean');

    if($this->form_validation->run()==FALSE){

      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_details.property_id','1');

      $data['relate']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_details.property_id<>','1');

      $data['property']=$this->customer_model->select_active_property_drop_down('property_master',$this->session->userdata['logged_in']['language_id']);

      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

      $this->load->view('Home/footer');

    }
    else{

        $data=array('adr_company_id'=>$this->input->post('customer'),'related_company_id'=>$this->input->post('relate'),' related_property_id'=>$this->input->post('property'),'company_id'=>$this->session->userdata['logged_in']['company_id']);

        $result=$this->common_model->save('adr_relate_companies',$data);

        if($result==1){
          $data['page_name']='setup';
          $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

          $data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_details.property_id','1');

          $data['relate']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_details.property_id<>','1');

          $data['property']=$this->customer_model->select_active_property_drop_down('property_master',$this->session->userdata['logged_in']['language_id']);

          $data['note']='Create Transaction Completed';

          header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
          
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
    $data['relate_companies']=$this->common_model->select_one_active_record_nonlanguage_without_archive('adr_relate_companies',$this->session->userdata['logged_in']['company_id'],'related_company_id',$this->uri->segment(3));

    $data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_details.property_id','1');

    $data['relate']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_details.property_id<>','1');

    $data['property']=$this->customer_model->select_active_property_drop_down('property_master',$this->session->userdata['logged_in']['language_id']);

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
    $this->form_validation->set_rules('customer','Customer' ,'required|xss_clean');
    $this->form_validation->set_rules('relate','Relate' ,'required|xss_clean');
    $this->form_validation->set_rules('property','Property' ,'required|xss_clean');

    if($this->form_validation->run()==FALSE){
      $data['relate_companies']=$this->common_model->select_one_active_record_nonlanguage_without_archive('adr_relate_companies',$this->session->userdata['logged_in']['company_id'],'related_company_id',$this->input->post('id'));

      $data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_details.property_id','1');

      $data['relate']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_details.property_id<>','1');

      $data['property']=$this->customer_model->select_active_property_drop_down('property_master',$this->session->userdata['logged_in']['language_id']);

      $data['page_name']='setup';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
      $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
      $this->load->view('Home/footer');
    }else{

        $data=array('adr_company_id'=>$this->input->post('customer'),'related_company_id'=>$this->input->post('relate'),' related_property_id'=>$this->input->post('property'),'company_id'=>$this->session->userdata['logged_in']['company_id']);

        $result=$this->common_model->update_one_active_record('adr_relate_companies',$data,'related_company_id',$this->input->post('id'),$this->session->userdata['logged_in']['company_id']);

        if($result==1){

          $data['relate_companies']=$this->common_model->select_one_active_record_nonlanguage_without_archive('adr_relate_companies',$this->session->userdata['logged_in']['company_id'],'related_company_id',$this->input->post('id'));

          $data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_details.property_id','1');

          $data['relate']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_details.property_id<>','1');

          $data['property']=$this->customer_model->select_active_property_drop_down('property_master',$this->session->userdata['logged_in']['language_id']);

          $data['note']='Update Transaction completed';

          header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

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



  

  public function search(){

    $data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_details.property_id','1');

    $data['relate']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_details.property_id<>','1');

    $data['property']=$this->customer_model->select_active_property_drop_down('property_master',$this->session->userdata['logged_in']['language_id']);

    $data['page_name']='setup';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    
    $this->load->view('Home/header');
    $this->load->view('Home/nav',$data);
    $this->load->view('Home/subnav');
    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
    $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
    $this->load->view('Home/footer');
  }


  public function search_result(){
    
    $this->form_validation->set_rules('customer','Customer' ,'xss_clean');
    $this->form_validation->set_rules('relate','Relate' ,'xss_clean');
    $this->form_validation->set_rules('property','Property' ,'xss_clean');

      if($this->form_validation->run()==FALSE){
        $data['page_name']='setup';
        $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
        $data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_details.property_id','1');

        $data['relate']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_details.property_id<>','1');

        $data['property']=$this->customer_model->select_active_property_drop_down('property_master',$this->session->userdata['logged_in']['language_id']);
        
        $this->load->view('Home/header');
        $this->load->view('Home/nav',$data);
        $this->load->view('Home/subnav');
        $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
        $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
        $this->load->view('Home/footer');
      }else{

        $data=array('adr_company_id'=>$this->input->post('customer'),
          'related_property_id'=>$this->input->post('property'),'related_company_id'=>$this->input->post('relate'));

        $data['relate']=$this->relate_model->active_record_search('adr_relate_companies',$data,$this->session->userdata['logged_in']['language_id']);

        if($data['relate']){

          $data['page_name']='setup';
          $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
          $this->load->view('Home/header');
          $this->load->view('Home/nav',$data);
          $this->load->view('Home/subnav');
          $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
          $this->load->view(ucwords($this->router->fetch_class()).'/active-records');
          $this->load->view('Home/footer');
          }else{
            $data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_details.property_id','1');

            $data['relate']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_details.property_id<>','1');

            $data['property']=$this->customer_model->select_active_property_drop_down('property_master',$this->session->userdata['logged_in']['language_id']);

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
