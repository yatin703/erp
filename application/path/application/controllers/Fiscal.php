<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Fiscal extends CI_Controller {



	function __construct(){

    parent::__construct();

    if($this->session->userdata('logged_in') && $this->session->userdata['logged_in']['admin']==1){

      $this->load->model('common_model');
      $this->load->model('fiscal_model');


		}else{

			redirect('login','refresh');

		}

  }



  public function index(){


    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

   
    $table='account_periods_master';

    include('pagination_status.php');

    $data['account_periods_master']=$this->fiscal_model->select_active_records($config["per_page"], $this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

  	$this->load->view('Home/header');

  	$this->load->view('Home/nav',$data);

  	$this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

  	$this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);

  	$this->load->view('Home/footer');

  }
    public function archive_records(){


    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

   
    $table='account_periods_master';

    include('pagination_archive_status.php');

    $data['account_periods_master']=$this->fiscal_model->select_archive_records($config["per_page"], $this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/archive-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/archive-records',$data);

    $this->load->view('Home/footer');

  }







 } 