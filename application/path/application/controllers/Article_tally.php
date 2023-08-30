<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Article_tally extends CI_Controller {

	function __construct(){

    parent::__construct();

    if($this->session->userdata('logged_in') && $this->session->userdata['logged_in']['admin']==1){

      $this->load->model('common_model');
      $this->load->model('article_tally_model');

		}else{
			redirect('login','refresh');
		}

  }

  public function index(){


    $data['page_name']='setup';

    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
   
    $table='tally_stock_items_master';

    include('pagination_tally.php');

    $data['tally_stock_items_master']=$this->common_model->select_active_records_tally($config["per_page"], $this->uri->segment(3),$table);

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
    $this->form_validation->set_rules('part_no','Article No' ,'xss_clean');
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
          $article_no='';

          if(!empty($this->input->post('part_no'))){
            
              $arr_article=explode("//",$this->input->post('part_no'));
              $article_no=$arr_article[1];
              $search['part_no']=$article_no;
          
            
            //$search['part_no']=$this->input->post('part_no');
          }
         
          if($this->input->post('status')!='--'){
            $search['status']=$this->input->post('status');
          }         
                    
          //print_r($search);

          //$data=array_filter($data);

          $data['tally_stock_items_master']=$this->article_tally_model->active_record_search('tally_stock_items_master',$search,$this->input->post('from_date'),$this->input->post('to_date'));

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
   
    $data['tally_stock_items_master']=$this->common_model->select_one_details_record_noncompany('tally_stock_items_master','id',$this->uri->segment(3));


    $this->load->view('Home/header');

    $this->load->view('Home/nav',$data);

    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

    $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

    $this->load->view('Home/footer');

  }

  public function update(){

    $this->form_validation->set_rules('name','Article Name' ,'required|xss_clean');
    $this->form_validation->set_rules('part_no','Part No','required|xss_clean');
    $this->form_validation->set_rules('description','Description','xss_clean');
    $this->form_validation->set_rules('under_group','Group Name','required|xss_clean');
    $this->form_validation->set_rules('units','Unit','required|xss_clean');
    $this->form_validation->set_rules('maintain_in_batches','Maintain In Batches','xss_clean');
    $this->form_validation->set_rules('date_of_manufacturing','Date Of Manufacturing','xss_clean');
    $this->form_validation->set_rules('expiry_date','Expiry Date','xss_clean');
    $this->form_validation->set_rules('gst_applicable','Gst Applicable','xss_clean');
    $this->form_validation->set_rules('hsn_no','HSN.SAC No','xss_clean');
    $this->form_validation->set_rules('hsn_description','HSN Description','xss_clean');
    $this->form_validation->set_rules('calculation_type','Calculation Type','xss_clean');
    $this->form_validation->set_rules('taxability','Taxability','xss_clean');
    $this->form_validation->set_rules('igst','IGST','xss_clean');
    $this->form_validation->set_rules('cgst','CGST','xss_clean');
    $this->form_validation->set_rules('utgst','UTGST','xss_clean');
    $this->form_validation->set_rules('cess','CESS','xss_clean');
    $this->form_validation->set_rules('type_of_supply','Type Of Supply','xss_clean');
    $this->form_validation->set_rules('status','Status','xss_clean');
    $this->form_validation->set_rules('remarks','Remarks','xss_clean');
     

    if($this->form_validation->run()==FALSE){

      
      $data['page_name']='setup';

      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
     
      $data['tally_stock_items_master']=$this->common_model->select_one_details_record_noncompany('tally_stock_items_master','id',$this->input->post('id'));


      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

      $this->load->view('Home/footer');

    }
    else{

          $data=array('name'=>$this->input->post('name'),
                      'part_no'=>$this->input->post('part_no'),
                      'description'=>$this->input->post('description'),
                      'under_group'=>$this->input->post('under_group'),
                      'units'=>$this->input->post('units'),
                      'maintain_in_batches'=>$this->input->post('maintain_in_batches'),
                      'date_of_manufacturing'=>$this->input->post('date_of_manufacturing'),
                      'expiry_date'=>$this->input->post('expiry_date'),
                      'gst_applicable'=>$this->input->post('gst_applicable'),
                      'hsn_no'=>$this->input->post('hsn_no'),
                      'hsn_description'=>$this->input->post('hsn_description'),
                      'calculation_type'=>$this->input->post('calculation_type'),
                      'taxability'=>$this->input->post('taxability'),
                      'igst'=>$this->input->post('igst'),
                      'cgst'=>$this->input->post('cgst'),
                      'utgst'=>$this->input->post('utgst'),
                      'cess'=>$this->input->post('cess'),
                      'type_of_supply'=>$this->input->post('type_of_supply'),
                      'status'=>$this->input->post('status'),
                      'remarks'=>$this->input->post('remarks')

                    );

        

        $result=$this->common_model->update_one_active_record_noncompany('tally_stock_items_master',$data,'id',$this->input->post('id'));
        
        if($result==1){

            $data['note']='Update Transaction Completed';

           // header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

            $data['tally_stock_items_master']=$this->common_model->select_one_details_record_noncompany('tally_stock_items_master','id',$this->input->post('id'));

            

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
