<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_supplier_tally extends CI_Controller {

	function __construct(){

    parent::__construct();

    if($this->session->userdata('logged_in') && $this->session->userdata['logged_in']['admin']==1){

      $this->load->model('common_model');
      $this->load->model('customer_supplier_tally_model');

		}else{
			redirect('login','refresh');
		}

  }

  public function index(){


    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
   
    $table='tally_ledger_master';

    include('pagination_tally.php');

    $data['tally_ledger_master']=$this->common_model->select_active_records_tally($config["per_page"], $this->uri->segment(3),$table);

  	$this->load->view('Home/header');

  	$this->load->view('Home/nav',$data);

  	$this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

  	$this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);

  	$this->load->view('Home/footer');

  }

  public function search(){

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
    
    $this->form_validation->set_rules('from_date','From Date' ,'xss_clean');
    $this->form_validation->set_rules('to_date','To Date' ,'xss_clean');
    $this->form_validation->set_rules('name','Party Name' ,'xss_clean');
    $this->form_validation->set_rules('status','Status' ,'xss_clean');

    if($this->form_validation->run()==FALSE){

      $data['page_name']='setup';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);

      $this->load->view('Home/footer');

    }
    else{
          // $data=array('name'=>$this->input->post('name'),
          //             'status'=>$this->input->post('status')
          //           );

          // $data=array_filter($data);

          $search=array();

          if($this->input->post('name')!=''){
            $search['name']=$this->input->post('name');
          }
          if($this->input->post('status')!='--'){
              $search['status']=$this->input->post('status');
          }

          //print_r($search);

          $data['tally_ledger_master']=$this->customer_supplier_tally_model->active_record_search('tally_ledger_master',$search,$this->input->post('from_date'),$this->input->post('to_date'));

          //echo $this->db->last_query();

          $data['page_name']='setup';

          $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);


          $this->load->view('Home/header');

          $this->load->view('Home/nav',$data);

          $this->load->view('Home/subnav');

          $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
          $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
          $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);

          $this->load->view('Home/footer');
         

    }

  }




}
