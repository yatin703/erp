<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_invoice_book extends CI_Controller {

	function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('purchase_invoice_book_model');
      $this->load->model('country_model');
      $this->load->model('customer_model');
      $this->load->model('tax_grid_model');
      $this->load->model('relate_model');
      $this->load->model('specification_model');
      $this->load->model('property_model');
    }else{
			redirect('login','refresh');
		}
  }

  function index(){
  	$data['page_name']='Purchase';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
    	if($module_row->module_name==='Purchase'){
    		$data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,'purchase_invoice_book');

		  	foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $table='ap_invoice';
            include('pagination.php');
                    
            $from="2017-07-01";
            $to=date('Y-m-d');
            $search="";
           $data['ap_invoice']=$this->purchase_invoice_book_model->active_record_search_index($config["per_page"],$this->uri->segment(3),'ap_invoice',$search,$from,$to,$this->session->userdata['logged_in']['company_id']);
                 
            $data['tax_header']=$this->purchase_invoice_book_model->fun_tax_header($from,$to,$this->session->userdata['logged_in']['company_id']);

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
            $this->load->view('Home/footer');
          }else{
            $data['note']='No rights Thanks';
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Error/error-title',$data);
            $this->load->view('Home/footer');
          }
        }
		  	
    		}
    	}
  	}
    else{
    	$data['note']='No View rights Thanks';
    	$data['page_name']='home';
    	$data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
  		$this->load->view('Home/header');
  		$this->load->view('Home/nav',$data);
  		$this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
  		$this->load->view('Home/footer');
    }
  }

  function view(){

    $ar_invoice_no=$this->uri->segment(3);
    $data['page_name']='Purchase';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {

      if($module_row->module_name==='Purchase'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,'purchase_order_book');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            
            $data['ap_invoice']=$this->purchase_invoice_book_model->select_one_active_record('ap_invoice',$this->session->userdata['logged_in']['company_id'],'ap_invoice.ar_invoice_no',$ar_invoice_no);

            $data['ar_invoice_details']=$this->purchase_invoice_book_model->active_details_records('ar_invoice_details',array('ar_invoice_no'=>$ar_invoice_no),$this->session->userdata['logged_in']['company_id']);

            // $data['order_master']=$this->purchase_invoice_book_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'ap_invoice.ar_invoice_no',$ar_invoice_no);

            // $data['order_details']=$this->purchase_invoice_book_model->active_details_records('order_details',array('ar_invoice_no'=>$ar_invoice_no),$this->session->userdata['logged_in']['company_id']);


            $this->load->model('tax_grid_model');
            $data['tax_master']=$this->tax_grid_model->select_purchase_invoice_tax_grid($ar_invoice_no);

            $data['company']=$this->common_model->select_one_active_record('company_master',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);

            $data['company_details']=$this->common_model->select_one_active_record('company_system_parameters',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);

            $data['followup']=$this->common_model->select_followup_records('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$ar_invoice_no);

            $this->load->view('Print/header',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/view-form',$data);
          }else{
              $data['note']='No Modify rights Thanks';
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view('Error/error-title',$data);
              $this->load->view('Home/footer');
          }
        }
      }
    }
  }else{
      $data['note']='No Modify rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  
  }



   

  public function customer_check($str){
    if(!empty($str)){
    $customer_code=explode('//',$str);
    if(!empty($customer_code[1])){
      $data=array('address_master.adr_company_id'=>$customer_code[1],
        'address_master.name1'=>$customer_code[0]);
    $data['customer']=$this->customer_model->active_record_search('address_master',$data,$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    foreach ($data['customer'] as $customer_row) {

      if ($customer_row->adr_company_id == $customer_code[1]){
        return TRUE;
      }else{
        $this->form_validation->set_message('customer_check', 'The {field} field is incorrect');
        return FALSE;
        }
      } 
    }else{
        $this->form_validation->set_message('customer_check', 'The {field} field is incorrect');
        return FALSE;
        } 

    }
  }


  function search(){
   
    $data['page_name']='Purchase';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Purchase'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,'purchase_invoice_book');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
           

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
            $this->load->view('Home/footer');
          }else{
            $data['note']='No rights Thanks';
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Error/error-title',$data);
            $this->load->view('Home/footer');
          }
        }
        
        }
      }
    }
    else{
      $data['note']='No View rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  }

  function search_result(){

    $data['page_name']='Purchase';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Purchase'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],2,'purchase_invoice_book');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
           
            $this->form_validation->set_rules('adr_company_id','Supplier Name' ,'trim|xss_clean|max_length[150]|strtoupper|callback_customer_check');
            $this->form_validation->set_rules('consin_adr_company_id','Ship To' ,'trim|xss_clean|max_length[150]|strtoupper|callback_customer_check');
            $this->form_validation->set_rules('article_no','Article No' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('from_date','From Date' ,'required|trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('to_date','To Date' ,'required|trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('ar_invoice_no','Purchase invoice no.' ,'trim|xss_clean');
            $this->form_validation->set_rules('for_export','Invoice Type' ,'trim|xss_clean');
           

            if($this->form_validation->run()==FALSE){

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                $this->load->view('Home/footer');
            }else{

                  $from=$this->common_model->change_date_format($this->input->post('from_date'),$this->session->userdata['logged_in']['company_id']);
                  $to=$this->common_model->change_date_format($this->input->post('to_date'),$this->session->userdata['logged_in']['company_id']);

                                                    
                  $search=array();
                  
                  if(!empty($this->input->post('adr_company_id'))){
                     $arr=explode('//',$this->input->post('adr_company_id'));
                     $search['adr_company_id']=$arr[1];
                  }
                  if(!empty($this->input->post('ap_invoice_no'))){
                     $search['ap_invoice_no']=$this->input->post('ap_invoice_no');
                  }
                  if(!empty($this->input->post('invoice_no'))){
                       $search['invoice_no']=$this->input->post('invoice_no');
                  }

                $data['ap_invoice']=$this->purchase_invoice_book_model->active_record_search('ap_invoice',$search,$from,$to,$this->session->userdata['logged_in']['company_id']);
                //echo $this->db->last_query(); 

                $data['tax_header']=$this->purchase_invoice_book_model->fun_tax_header($from,$to,$this->session->userdata['logged_in']['company_id']);
                
                 
                if($data['ap_invoice']!=FALSE){
                    $data['page_name']='Purchase';
                    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                    $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'purchase_order_book');                      
                    
                    $this->load->view('Home/header');
                    $this->load->view('Home/nav',$data);
                    $this->load->view('Home/subnav');
                    $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                    $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                    $this->load->view(ucwords($this->router->fetch_class()).'/search-result',$data);
                    $this->load->view('Home/footer');
                }else{
                      $data['page_name']='Purchase';
                      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                      $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'purchase_invoice_book');
                      
                      $data['error']='No record in search transaction';
                      $this->load->view('Home/header');
                      $this->load->view('Home/nav',$data);
                      $this->load->view('Home/subnav');
                      $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                      $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                      $this->load->view('Home/footer');
                }
                
            }

          }else{
                  $data['page_name']='home';
                  $data['note']='No rights Thanks';
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view('Error/error-title',$data);
                  $this->load->view('Home/footer');
                }
              }
              
              }
            }
          }
          else{
            $data['note']='No New rights Thanks';
            $data['page_name']='home';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Error/error-title',$data);
            $this->load->view('Home/footer');
          }


  }


  

    public function customer_supplier_check($str){
      
      if($str!=''){

        $customer_supplier_code=explode('//',$str);

        if(!empty($customer_supplier_code[1])){
          $data['customer_supplier']=$this->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'name1',$customer_supplier_code[0]);
          foreach ($data['customer_supplier'] as $customer_supplier_row){

            if ($customer_supplier_row->adr_company_id == $customer_supplier_code[1]){
              return TRUE;
            }else{
              $this->form_validation->set_message('adr_company_id', 'The {field} field is incorrect');
              return FALSE;
            }

          } 
        }else{
            $this->form_validation->set_message('adr_company_id', 'The {field} field is incorrect');
            return FALSE;
        } 


      }
      
  }

  public function article_check($str){
    if(!empty($str)){
    $item_code=explode('//',$str);
    if(!empty($item_code[1])){
    $data['item']=$this->common_model->select_one_active_record_nonlanguage_without_archive('article_name_info',$this->session->userdata['logged_in']['company_id'],'lang_article_description',$item_code[0]);
    foreach ($data['item'] as $item_row) {
      if ($item_row->article_no == $item_code[1]){
        return TRUE;
      }else{
        $this->form_validation->set_message('article_check', 'The {field} field is incorrect');
        return FALSE;
        }
      } 
    }else{
        $this->form_validation->set_message('article_check', 'The {field} field is incorrect');
        return FALSE;
      }
    } 
  }

  

}