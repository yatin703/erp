<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_order_tally extends CI_Controller {

	function __construct(){

    parent::__construct();

    if($this->session->userdata('logged_in') && $this->session->userdata['logged_in']['admin']==1){

      $this->load->model('common_model');
      $this->load->model('sales_order_tally_model');

		}else{
			redirect('login','refresh');
		}

  }

  public function index(){


    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
   
    $table='tally_sales_order_master';

    include('pagination_tally.php');

    $data['tally_sales_order_master']=$this->common_model->select_active_records_tally($config["per_page"], $this->uri->segment(3),$table);

  	$this->load->view('Home/header');

  	$this->load->view('Home/nav',$data);

  	$this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

  	$this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);

  	$this->load->view('Home/footer');

  }

  function modify(){

    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
   
    $data['tally_sales_order_master']=$this->common_model->select_one_details_record_noncompany('tally_sales_order_master','id',$this->uri->segment(3));


    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

    $this->load->view('Home/footer');

  }

  public function update(){

    $this->form_validation->set_rules('order_date','Order Date' ,'required|xss_clean');
    $this->form_validation->set_rules('order_no','Order No','required|xss_clean');
    $this->form_validation->set_rules('sales_ledger','Sales Ledger Name','required|xss_clean');
    $this->form_validation->set_rules('bill_to','Bill To','required|xss_clean');
    $this->form_validation->set_rules('ship_to','Ship to','required|xss_clean');
    $this->form_validation->set_rules('po_no','PO No','required|xss_clean');
    $this->form_validation->set_rules('part_no','Part No','required|xss_clean');
    $this->form_validation->set_rules('order_quantity','Order Qty','required|xss_clean');
    $this->form_validation->set_rules('unit_rate','Unit Rate','required|xss_clean');
    $this->form_validation->set_rules('net_amount','Net Amount','required|xss_clean');
    $this->form_validation->set_rules('status','Status','xss_clean');
    $this->form_validation->set_rules('remarks','Remarks','xss_clean');
     

    if($this->form_validation->run()==FALSE){

      
      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
     
      $data['tally_sales_order_master']=$this->common_model->select_one_details_record_noncompany('tally_sales_order_master','id',$this->input->post('id'));


      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

      $this->load->view('Home/footer');

    }
    else{

          $data=array('order_date'=>$this->input->post('order_date'),
                      'sales_ledger'=>$this->input->post('sales_ledger'),
                      'bill_to'=>$this->input->post('bill_to'),
                      'ship_to'=>$this->input->post('ship_to'),
                      'po_no'=>$this->input->post('po_no'),
                      'part_no'=>$this->input->post('part_no'),
                      'order_quantity'=>$this->input->post('order_quantity'),
                      'unit_rate'=>$this->input->post('unit_rate'),
                      'net_amount'=>$this->input->post('net_amount'),
                      'status'=>$this->input->post('status'),
                      'remarks'=>$this->input->post('remarks')
                    );

        

        $result=$this->common_model->update_one_active_record_noncompany('tally_sales_order_master',$data,'id',$this->input->post('id'));
        
        if($result==1){

            $data['note']='Update Transaction Completed';

           // header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

            $data['tally_sales_order_master']=$this->common_model->select_one_details_record_noncompany('tally_sales_order_master','id',$this->input->post('id'));

            

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
    $this->form_validation->set_rules('order_no','Order No' ,'xss_clean');
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
          // $data=array('order_no'=>$this->input->post('order_no'),
          //             'status'=>$this->input->post('status')
          //           );

          //$data=array_filter($data);

          $search=array();

          if($this->input->post('order_no')!=''){
            $search['order_no']=$this->input->post('order_no');
          }
          if($this->input->post('status')!='--'){
              $search['status']=$this->input->post('status');
          }

          //print_r($search);

          $data['tally_sales_order_master']=$this->sales_order_tally_model->active_record_search('tally_sales_order_master',$search,$this->input->post('from_date'),$this->input->post('to_date'));
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
