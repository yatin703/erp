<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_invoice_book extends CI_Controller {

	function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('sales_invoice_book_model');
      $this->load->model('sales_order_book_model');
      $this->load->model('artwork_model');
      $this->load->model('artwork_springtube_model');
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
  	$data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
    	if($module_row->module_name==='Sales'){
    		$data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_invoice_book');

		  	foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $table='ar_invoice_master';
            include('pagination.php');
                    
            $from="2021-04-01";
            $to=date('Y-m-d');
            $search="";
           $data['ar_invoice_master']=$this->sales_invoice_book_model->active_record_search_index($config["per_page"],$this->uri->segment(3),'ar_invoice_master',$search,$from,$to,$this->session->userdata['logged_in']['company_id']);
                 
            $data['tax_header']=$this->sales_invoice_book_model->fun_tax_header($from,$to,$this->session->userdata['logged_in']['company_id']);
            //print_r( $data['tax_header']);

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            //$this->load->view('Loading/loading');
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
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {

      if($module_row->module_name==='Sales'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_book');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            
            $data['ar_invoice_master']=$this->sales_invoice_book_model->select_one_active_record('ar_invoice_master',$this->session->userdata['logged_in']['company_id'],'ar_invoice_master.ar_invoice_no',$ar_invoice_no);

            $data['ar_invoice_details']=$this->sales_invoice_book_model->active_details_records('ar_invoice_details',array('ar_invoice_no'=>$ar_invoice_no),$this->session->userdata['logged_in']['company_id']);

            // $data['order_master']=$this->sales_invoice_book_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'ar_invoice_master.ar_invoice_no',$ar_invoice_no);

            // $data['order_details']=$this->sales_invoice_book_model->active_details_records('order_details',array('ar_invoice_no'=>$ar_invoice_no),$this->session->userdata['logged_in']['company_id']);

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

    function modify(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {

      if($module_row->module_name==='Sales'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_invoice_book');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){

            $data['invoice_types_master_lang']=$this->common_model->select_active_drop_down('invoice_types_master_lang',$this->session->userdata['logged_in']['company_id']);
            
            $data['ar_invoice_master']=$this->sales_invoice_book_model->select_one_active_record('ar_invoice_master',$this->session->userdata['logged_in']['company_id'],'ar_invoice_master.ar_invoice_no',$this->uri->segment(3));



             $data['page_name']='Sales';
             $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
             $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_invoice_book');
              
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
              $this->load->view('Home/footer');
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


  function update(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_invoice_book');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){

            $this->form_validation->set_rules('ar_invoice_no','Invoice No' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('cancel_invoice','Invoice Status' ,'trim|xss_clean');

            for($i=0;$i<=count($this->input->post('inv_type'));$i++){
                
              $this->form_validation->set_rules('inv_type[]','Invoice Type' ,'required|trim|xss_clean');

            }


            if($this->form_validation->run()==FALSE){


             $data['invoice_types_master_lang']=$this->common_model->select_active_drop_down('invoice_types_master_lang',$this->session->userdata['logged_in']['company_id']);
            
             $data['ar_invoice_master']=$this->sales_invoice_book_model->select_one_active_record('ar_invoice_master',$this->session->userdata['logged_in']['company_id'],'ar_invoice_master.ar_invoice_no',$this->input->post('ar_invoice_no'));

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_invoice_book');

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
              $this->load->view('Home/footer');
            }else{

                  $this->input->post('ar_invoice_no');
                  $inv_type='1';
                  $arr=$this->input->post('inv_type');

                  for($i=0;$i<count($this->input->post('inv_type'));$i++){
                
                    $inv_type= $arr[$i];

                  }
                  $cancel_invoice=0;
                  if(!empty($this->input->post('cancel_invoice')) OR $this->input->post('cancel_invoice')!='')
                  {
                    $cancel_invoice=$this->input->post('cancel_invoice');
                  }

                  $data=array('inv_type' =>$inv_type,'cancel_invoice'=>$cancel_invoice);

                  $result=$this->common_model->update_one_active_record('ar_invoice_master',$data,'ar_invoice_no',$this->input->post('ar_invoice_no'),$this->session->userdata['logged_in']['company_id']);
                  

                 $data['invoice_types_master_lang']=$this->common_model->select_active_drop_down('invoice_types_master_lang',$this->session->userdata['logged_in']['company_id']);
            
                 $data['ar_invoice_master']=$this->sales_invoice_book_model->select_one_active_record('ar_invoice_master',$this->session->userdata['logged_in']['company_id'],'ar_invoice_master.ar_invoice_no',$this->input->post('ar_invoice_no'));
              

                 $data['page_name']='Sales';
                 $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                 $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_invoice_book');


                  $data['note']='Update Transaction Completed';

                  //header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                  $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
                  $this->load->view('Home/footer');
              
            }
          }else{
            $data['note']='No New rights Thanks';
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
      $data['note']='No rights Thanks';
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
   
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_invoice_book');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['invoice_types_master_lang']=$this->common_model->select_active_drop_down('invoice_types_master_lang',$this->session->userdata['logged_in']['company_id']); 

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

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_invoice_book');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
           
            $this->form_validation->set_rules('adr_company_id','Bill To' ,'trim|xss_clean|max_length[150]|strtoupper|callback_customer_check');
            $this->form_validation->set_rules('consin_adr_company_id','Ship To' ,'trim|xss_clean|max_length[150]|strtoupper|callback_customer_check');
            $this->form_validation->set_rules('article_no','Article No' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('from_date','From Date' ,'required|trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('to_date','To Date' ,'required|trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('ar_invoice_no','Sales invoice no.' ,'trim|xss_clean');
            //$this->form_validation->set_rules('for_export','Invoice Type' ,'trim|xss_clean');
           

            if($this->form_validation->run()==FALSE){

              if(!empty($this->input->post('adr_company_id'))){

                $customer_arr=explode('//',$this->input->post('adr_company_id'));
                if(!empty($customer_arr[1])){
                  $data['ship_to']=$this->relate_model->select_one_active_record('adr_relate_companies',$this->session->userdata['logged_in']['company_id'],'adr_relate_companies.adr_company_id',$customer_arr[1],$this->session->userdata['logged_in']['language_id']);
                }
                
              }

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
           
               $data['invoice_types_master_lang']=$this->common_model->select_active_drop_down('invoice_types_master_lang',$this->session->userdata['logged_in']['company_id']);

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                $this->load->view('Home/footer');
            }else{

                  $from=$this->common_model->change_date_format($this->input->post('from_date'),$this->session->userdata['logged_in']['company_id']);
                  $to=$this->common_model->change_date_format($this->input->post('to_date'),$this->session->userdata['logged_in']['company_id']);

                  $for_export=$this->input->post('for_export');
                                   
                  $search=array();
                  
                  if(!empty($this->input->post('adr_company_id'))){
                     $arr=explode('//',$this->input->post('adr_company_id'));
                     $search['customer_no']=$arr[1];
                  }
                  if(!empty($this->input->post('consin_adr_company_id'))){
                     $arr=explode('//',$this->input->post('consin_adr_company_id'));
                     $consignee=$arr[1].'|';
                     $search['consin_adr_company_id']=$consignee;
                  }
                  if(!empty($this->input->post('ar_invoice_no'))){
                     $search['ar_invoice_no']=$this->input->post('ar_invoice_no');
                  }

                  /*if(!empty($this->input->post('customer_category'))){
                    $customer_category_arr=explode('//',$this->input->post('customer_category'));
                    $customer_category=$customer_category_arr[1];
                  }else{

                  $customer_category="";
                  }*/
 

                  


                  // if($for_export!=''){
                  //     $search['for_export']=$for_export;
                  // }
                 
                               

                $data['ar_invoice_master']=$this->sales_invoice_book_model->active_record_search('ar_invoice_master',$search,$from,$to,$this->session->userdata['logged_in']['company_id'],$this->input->post('inv_type[]'));
                //echo $this->db->last_query(); 

                $data['tax_header']=$this->sales_invoice_book_model->fun_tax_header($from,$to,$this->session->userdata['logged_in']['company_id']);

                $data['invoice_types_master_lang']=$this->common_model->select_active_drop_down('invoice_types_master_lang',$this->session->userdata['logged_in']['company_id']);
                //print_r( $data['tax_header']);
                
                 
                if($data['ar_invoice_master']!=FALSE){
                    $data['page_name']='Sales';
                    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                    $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_invoice_book');

                    if(!empty($this->input->post('adr_company_id'))){

                      $customer_arr=explode('//',$this->input->post('adr_company_id'));
                      if(!empty($customer_arr[1])){
                        $data['ship_to']=$this->relate_model->select_one_active_record('adr_relate_companies',$this->session->userdata['logged_in']['company_id'],'adr_relate_companies.adr_company_id',$customer_arr[1],$this->session->userdata['logged_in']['language_id']);
                      }
                      
                    }
                    $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                    $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
           
                    $data['invoice_types_master_lang']=$this->common_model->select_active_drop_down('invoice_types_master_lang',$this->session->userdata['logged_in']['company_id']);

                    $this->load->view('Home/header');
                    $this->load->view('Home/nav',$data);
                    $this->load->view('Home/subnav');
                    $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                    $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                    $this->load->view(ucwords($this->router->fetch_class()).'/search-result',$data);
                    $this->load->view('Home/footer');
                }else{
                      $data['page_name']='Sales';
                      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                      $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_invoice_book');

                      $data['invoice_types_master_lang']=$this->common_model->select_active_drop_down('invoice_types_master_lang',$this->session->userdata['logged_in']['company_id']);
                      
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


  function dashboard(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_invoice_book');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $table='ar_invoice_master';
            include('pagination.php');

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            //$this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/dashboard',$data);
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

  


  function print_type_wise(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_invoice_book');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $table='ar_invoice_master';
            include('pagination.php');

            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['customer_category']=$this->common_model->select_active_drop_down('address_category_master',$this->session->userdata['logged_in']['company_id']);
            
            
            $data['print_type_wise_sales_coex']=$this->sales_invoice_book_model->select_print_type_wise_coex_sales_record($table,'2019-04-01',date('Y-m-d'),'','','','','');
            $data['print_type_wise_sales_spring']=$this->sales_invoice_book_model->select_print_type_wise_spring_sales_record($table,'2019-04-01',date('Y-m-d'),'','','','','');

            //echo $this->db->last_query();
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/print-type-wise',$data);
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
  
  

  function top_customer(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_invoice_book');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $table='ar_invoice_master';
            include('pagination.php');

            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['customer_category']=$this->common_model->select_active_drop_down('address_category_master',$this->session->userdata['logged_in']['company_id']);
            
            
            $data['top_customer_coex']=$this->sales_invoice_book_model->select_top_customer($table,$this->session->userdata['logged_in']['company_id'],'2018-04-01','2019-03-31');

            //echo $this->db->last_query();
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/top-customer',$data);
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

}