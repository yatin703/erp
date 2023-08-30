<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_invoice_tally extends CI_Controller {

	function __construct(){

    parent::__construct();

    if($this->session->userdata('logged_in') && $this->session->userdata['logged_in']['admin']==1){

      $this->load->model('common_model');
      $this->load->model('sales_invoice_tally_model');

		}else{
			redirect('login','refresh');
		}

  }

  public function index(){


    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
   
    $table='tally_sales_invoice_details';

    include('pagination_tally.php');

    $data['tally_sales_invoice_details']=$this->common_model->select_active_records_tally($config["per_page"], $this->uri->segment(3),$table);

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
    $this->form_validation->set_rules('ar_invoice_no','Invoice No' ,'xss_clean');
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
          
          $search=array();

          if($this->input->post('ar_invoice_no')!=''){
            $search['ar_invoice_no']=$this->input->post('ar_invoice_no');
          }
          if($this->input->post('status')!='--'){
              $search['status']=$this->input->post('status');
          }
          
          //$data=array_filter($data);

          $data['tally_sales_invoice_details']=$this->sales_invoice_tally_model->active_record_search('tally_sales_invoice_details',$search,$this->input->post('from_date'),$this->input->post('to_date'));
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

  function modify(){

    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
   
    $data['tally_sales_invoice_details']=$this->common_model->select_one_details_record_noncompany('tally_sales_invoice_details','id',$this->uri->segment(3));


    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

    $this->load->view('Home/footer');

  }

  function update(){

    $this->form_validation->set_rules('invoice_date','Invoice Date' ,'required|xss_clean');
    $this->form_validation->set_rules('ar_invoice_no','Invoice No','required|xss_clean');
    $this->form_validation->set_rules('bill_to','Bill To','required|xss_clean');
    $this->form_validation->set_rules('ship_to','Ship to','required|xss_clean');
    $this->form_validation->set_rules('order_no','Order No','xss_clean');
    $this->form_validation->set_rules('article_no','Article No','required|xss_clean');
    $this->form_validation->set_rules('arid_qty','Invoice Qty','required|xss_clean');
    $this->form_validation->set_rules('selling_price','Unit Rate','required|xss_clean');
    $this->form_validation->set_rules('total_price','Net Amount','required|xss_clean');
    $this->form_validation->set_rules('total_tax','Tax Amount','required|xss_clean');
    $this->form_validation->set_rules('sgst','SGST','required|xss_clean');
    $this->form_validation->set_rules('cgst','CGST','required|xss_clean');
    $this->form_validation->set_rules('utgst','UTGST','required|xss_clean');
    $this->form_validation->set_rules('igst','IGST','required|xss_clean');
    $this->form_validation->set_rules('freight','Freight','required|xss_clean');
    $this->form_validation->set_rules('packing','Packing','required|xss_clean');
    $this->form_validation->set_rules('insurance','Insurance','required|xss_clean');
    $this->form_validation->set_rules('gross_amount','Gross Amount','required|xss_clean');
    $this->form_validation->set_rules('currency','Currency','required|xss_clean');
    $this->form_validation->set_rules('currency_rate','Currency Rate','required|xss_clean');
    $this->form_validation->set_rules('status','Status','xss_clean');
    $this->form_validation->set_rules('remarks','Remarks','xss_clean');
     

    if($this->form_validation->run()==FALSE){

      
      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
     
      $data['tally_sales_invoice_details']=$this->common_model->select_one_details_record_noncompany('tally_sales_invoice_details','id',$this->input->post('id'));


      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

      $this->load->view('Home/footer');

    }
    else{

          $data=array('invoice_date'=>$this->input->post('invoice_date'),
                      'bill_to'=>$this->input->post('bill_to'),
                      'ship_to'=>$this->input->post('ship_to'),
                      'order_no'=>$this->input->post('order_no'),
                      'article_no'=>$this->input->post('article_no'),
                      'arid_qty'=>$this->input->post('arid_qty'),
                      'selling_price'=>$this->input->post('selling_price'),
                      'total_price'=>$this->input->post('total_price'),
                      'total_tax'=>$this->input->post('total_tax'),
                      'cgst'=>$this->input->post('cgst'),
                      'utgst'=>$this->input->post('utgst'),
                      'sgst'=>$this->input->post('sgst'),
                      'igst'=>$this->input->post('igst'),
                      'freight'=>$this->input->post('freight'),
                      'packing'=>$this->input->post('packing'),
                      'insurance'=>$this->input->post('insurance'),
                      'gross_amount'=>$this->input->post('gross_amount'),
                      'currency'=>$this->input->post('currency'),
                      'currency_rate'=>$this->input->post('currency_rate'),
                      'status'=>$this->input->post('status'),
                      'remarks'=>$this->input->post('remarks')
                    );

        

        $result=$this->common_model->update_one_active_record_noncompany('tally_sales_invoice_details',$data,'id',$this->input->post('id'));
        
        if($result==1){

            $data['note']='Update Transaction Completed';

           // header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

            $data['tally_sales_invoice_details']=$this->common_model->select_one_details_record_noncompany('tally_sales_invoice_details','id',$this->input->post('id'));

            

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




}
