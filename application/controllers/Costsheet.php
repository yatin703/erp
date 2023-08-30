<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Costsheet extends CI_Controller {

	function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('sales_invoice_book_model');
      $this->load->model('costsheet_model');
      $this->load->model('sales_order_book_model');
      $this->load->model('artwork_springtube_model');
      $this->load->model('artwork_model');
      $this->load->model('country_model');
      $this->load->model('customer_model');
      $this->load->model('tax_grid_model');
      $this->load->model('relate_model');
      $this->load->model('job_card_model');
      $this->load->model('specification_model');
      $this->load->model('property_model');
      $this->load->model('daily_plates_record_model');
      $this->load->model('daily_screen_record_model');
      $this->load->model('article_model');
      $this->load->model('process_model');
      $this->load->model('sales_order_item_parameterwise_model');
      $this->load->model('fiscal_model');
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
    		$data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'Costsheet');

		  	foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','printing_group',$this->session->userdata['logged_in']['company_id']);
            $data['customer_category']=$this->common_model->select_active_drop_down('address_category_master',$this->session->userdata['logged_in']['company_id']);

            $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
            
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/search-form-new',$data);
            $this->load->view('Home/footer');
            /*
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            //$this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
            $this->load->view('Home/footer');*/
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


    function index_value(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'Costsheet');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','printing_group',$this->session->userdata['logged_in']['company_id']);
            $data['customer_category']=$this->common_model->select_active_drop_down('address_category_master',$this->session->userdata['logged_in']['company_id']);

            $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
            
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/search-form-neww',$data);
            $this->load->view('Home/footer');
            /*
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            //$this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
            $this->load->view('Home/footer');*/
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



  function search_by_product(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'Costsheet');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','printing_group',$this->session->userdata['logged_in']['company_id']);
            $data['customer_category']=$this->common_model->select_active_drop_down('address_category_master',$this->session->userdata['logged_in']['company_id']);
            
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/search-form-product',$data);
            $this->load->view('Home/footer');
            /*
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            //$this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
            $this->load->view('Home/footer');*/
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



  function new_report(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'Costsheet');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','printing_group',$this->session->userdata['logged_in']['company_id']);
            $data['customer_category']=$this->common_model->select_active_drop_down('address_category_master',$this->session->userdata['logged_in']['company_id']);
            
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/new-report-form',$data);
            $this->load->view('Home/footer');
            /*
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            //$this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
            $this->load->view('Home/footer');*/
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


  function view_product(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {

      if($module_row->module_name==='Sales'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'Costsheet');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

            $data=array('article_no'=>$this->uri->segment(3),'from_date'=>$this->uri->segment(4),'to_date'=>$this->uri->segment(5));


            $data['company']=$this->common_model->select_one_active_record('company_master',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);

            $data['company_details']=$this->common_model->select_one_active_record('company_system_parameters',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);

            

            $this->load->view('Print/header',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/view-product',$data);
          }else{
              $data['note']='No View rights Thanks';
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
    $sales_order_no=$this->uri->segment(4);
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {

      if($module_row->module_name==='Sales'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'Costsheet');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            


            $data['ar_invoice_master']=$this->sales_invoice_book_model->select_one_active_record('ar_invoice_master',$this->session->userdata['logged_in']['company_id'],'ar_invoice_master.ar_invoice_no',$ar_invoice_no);

            $data['ar_invoice_details']=$this->sales_invoice_book_model->active_details_records('ar_invoice_details',array('ar_invoice_no'=>$ar_invoice_no,'ref_ord_no'=>$sales_order_no),$this->session->userdata['logged_in']['company_id']);

            $datae=array('invoice_no'=>$this->uri->segment(3),
                          'order_no'=>$this->uri->segment(4),
                          'article_no'=>$this->uri->segment(5));

            $data['costsheet_master']=$this->common_model->select_one_active_record_nonlanguage_without_archives('costsheet_master',$this->session->userdata['logged_in']['company_id'],$datae);

            $data['costsheet_remark']=$this->common_model->select_active_drop_down('costsheet_remark_master',$this->session->userdata['logged_in']['company_id']);

            //echo $this->db->last_query();

            // $data['order_master']=$this->sales_invoice_book_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'ar_invoice_master.ar_invoice_no',$ar_invoice_no);

            // $data['order_details']=$this->sales_invoice_book_model->active_details_records('order_details',array('ar_invoice_no'=>$ar_invoice_no),$this->session->userdata['logged_in']['company_id']);

            $data['company']=$this->common_model->select_one_active_record('company_master',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);

            $data['company_details']=$this->common_model->select_one_active_record('company_system_parameters',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);

            $data['followup']=$this->common_model->select_followup_records('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$ar_invoice_no);



            $this->load->view('Print/header',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/view-form',$data);
          }else{
              $data['note']='No View rights Thanks';
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


  function modify(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {

      if($module_row->module_name==='Sales'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){


            $data['costsheet_master']=$this->common_model->select_one_active_record('costsheet_master',$this->session->userdata['logged_in']['company_id'],'costheet_id',$this->uri->segment(3));
            
           

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

  public function update(){

     $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){

              $this->form_validation->set_rules('remark','Remark ' ,'xss_clean');
              $this->form_validation->set_rules('check_flag','Check Flag','xss_clean');
              

               
    if($this->form_validation->run()==FALSE){

      //echo 'if';
      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $datae=array('invoice_no'=>$this->input->post('invoice_no'),
                          'order_no'=>$this->input->post('order_no'),
                          'article_no'=>$this->input->post('article_no'));

      $data['costsheet_master']=$this->common_model->select_one_active_record_nonlanguage_without_archives('costsheet_master',$this->session->userdata['logged_in']['company_id'],$datae);

      $data['costsheet_remark']=$this->common_model->select_active_drop_down('costsheet_remark_master',$this->session->userdata['logged_in']['company_id']);

      //echo $this->db->last_query();

      $data['ar_invoice_master']=$this->sales_invoice_book_model->select_one_active_record('ar_invoice_master',$this->session->userdata['logged_in']['company_id'],'ar_invoice_master.ar_invoice_no',$this->input->post('invoice_no'));

      $data['ar_invoice_details']=$this->sales_invoice_book_model->active_details_records('ar_invoice_details',array('ar_invoice_no'=>$this->input->post('invoice_no'),'ref_ord_no'=>$this->input->post('order_no')),$this->session->userdata['logged_in']['company_id']);

      $data['company']=$this->common_model->select_one_active_record('company_master',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);

        $data['company_details']=$this->common_model->select_one_active_record('company_system_parameters',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);

        $data['followup']=$this->common_model->select_followup_records('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$this->input->post('invoice_no'));


      $this->load->view('Print/header',$data);
      $this->load->view(ucwords($this->router->fetch_class()).'/view-form',$data);

    }
    else{
          //echo '1';
          $table='costsheet_master';                         

          $check_flag = (!empty($this->input->post('check_flag'))) ? $this->input->post('check_flag') : 0;
          
          if(!empty($this->input->post('remark[]'))){
                  $remark = implode(', ', $this->input->post('remark[]'));
          }else{
                  $remark="";
          }

          $data=array(                             
            'remark'=>$remark,
            'check_flag'=>$check_flag,
            'checked_by'=>$this->session->userdata['logged_in']['user_id'],
            'checked_on'=>date('Y-m-d h:i:s'));         

          $result=$this->common_model->update_one_active_record('costsheet_master',$data,'costheet_id',$this->input->post('costheet_ide'),$this->session->userdata['logged_in']['company_id']);
         // echo $this->db->last_query();
        
        if($result==1){

            $data['note']='Update Transaction Completed';

            //header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

            
   
            $datae=array('invoice_no'=>$this->input->post('invoice_no'),
                          'order_no'=>$this->input->post('order_no'),
                          'article_no'=>$this->input->post('article_no'));

      $data['costsheet_master']=$this->common_model->select_one_active_record_nonlanguage_without_archives('costsheet_master',$this->session->userdata['logged_in']['company_id'],$datae);

      $data['costsheet_remark']=$this->common_model->select_active_drop_down('costsheet_remark_master',$this->session->userdata['logged_in']['company_id']);

      //echo $this->db->last_query();

      $data['ar_invoice_master']=$this->sales_invoice_book_model->select_one_active_record('ar_invoice_master',$this->session->userdata['logged_in']['company_id'],'ar_invoice_master.ar_invoice_no',$this->input->post('invoice_no'));

      $data['ar_invoice_details']=$this->sales_invoice_book_model->active_details_records('ar_invoice_details',array('ar_invoice_no'=>$this->input->post('invoice_no'),'ref_ord_no'=>$this->input->post('order_no')),$this->session->userdata['logged_in']['company_id']);

      $data['company']=$this->common_model->select_one_active_record('company_master',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);

        $data['company_details']=$this->common_model->select_one_active_record('company_system_parameters',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);

        $data['followup']=$this->common_model->select_followup_records('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$this->input->post('invoice_no'));


      $this->load->view('Print/header',$data);
      $this->load->view(ucwords($this->router->fetch_class()).'/view-form',$data);

        }
        else{

          $data['note']='Error in Update Transaction';

          $data['page_name']='Sales';
          $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

          $this->load->view('Home/header');
          $this->load->view('Home/nav',$data);
          $this->load->view('Home/subnav');
          $this->load->view('Error/error-title',$data);
          $this->load->view('Home/footer');

        }

    }

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



  
    function production_time(){

    $jobcard_no=$this->uri->segment(3);
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {

      if($module_row->module_name==='Sales'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'Costsheet');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $data['company']=$this->common_model->select_one_active_record('company_master',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);

            $data['company_details']=$this->common_model->select_one_active_record('company_system_parameters',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);

              $this->load->view('Print/header',$data);
              
              $data=array('coex_machine_runtime.mp_pos_no'=>$jobcard_no);
              $this->load->model('coex_runtime_downtime_model');
              $data = array_filter($data);
              $data['coex_machine_runtime']=$this->coex_runtime_downtime_model->active_record_search('coex_machine_runtime',$data,$this->session->userdata['logged_in']['company_id']);
                
              
            
            
            $this->load->view(ucwords($this->router->fetch_class()).'/view-production-time',$data);
          }else{
              $data['note']='No View rights Thanks';
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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'Costsheet');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
           
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','printing_group',$this->session->userdata['logged_in']['company_id']);
            $data['customer_category']=$this->common_model->select_active_drop_down('address_category_master',$this->session->userdata['logged_in']['company_id']);
            
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

  function search_spring(){
   
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'Costsheet');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
           
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','printing_group',$this->session->userdata['logged_in']['company_id']);
            $data['customer_category']=$this->common_model->select_active_drop_down('address_category_master',$this->session->userdata['logged_in']['company_id']);
            
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/search-form-spring',$data);
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


  function new_report_result(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'Costsheet');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
           
            $this->form_validation->set_rules('adr_company_id','Bill To' ,'trim|xss_clean|max_length[150]|strtoupper|callback_customer_check');
            $this->form_validation->set_rules('consin_adr_company_id','Ship To' ,'trim|xss_clean|max_length[150]|strtoupper|callback_customer_check');
            $this->form_validation->set_rules('article_no','Article No' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('from_date','From Date' ,'required|trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('to_date','To Date' ,'required|trim|xss_clean|max_length[10]');
           

            if($this->form_validation->run()==FALSE){

              if(!empty($this->input->post('adr_company_id'))){

                $customer_arr=explode('//',$this->input->post('adr_company_id'));
                if(!empty($customer_arr[1])){
                  $data['ship_to']=$this->relate_model->select_one_active_record('adr_relate_companies',$this->session->userdata['logged_in']['company_id'],'adr_relate_companies.adr_company_id',$customer_arr[1],$this->session->userdata['logged_in']['language_id']);
                }
                
              }
              $data['customer_category']=$this->common_model->select_active_drop_down('address_category_master',$this->session->userdata['logged_in']['company_id']);
            
            

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/new-report-form',$data);
                $this->load->view('Home/footer');
            }else{

                  $from=$this->common_model->change_date_format($this->input->post('from_date'),$this->session->userdata['logged_in']['company_id']);
                  $to=$this->common_model->change_date_format($this->input->post('to_date'),$this->session->userdata['logged_in']['company_id']);

                                   
                  $search=array();

                  if(!empty($this->input->post('customer_category'))){
                    $customer_category_arr=explode('//',$this->input->post('customer_category'));
                    $customer_category=$customer_category_arr[1];
                  }else{

                  $customer_category="";
                  }
                  
                  if(!empty($this->input->post('adr_company_id'))){
                     $arr=explode('//',$this->input->post('adr_company_id'));
                     $search['customer_no']=$arr[1];
                  }
                  if(!empty($this->input->post('consin_adr_company_id'))){
                     $arr=explode('//',$this->input->post('consin_adr_company_id'));
                     $consignee=$arr[1].'|';
                   }
                   

                 
                 
                               

                $data['ar_invoice_master']=$this->costsheet_model->active_record_search('ar_invoice_master',$search,$from,$to,$this->session->userdata['logged_in']['company_id'],$customer_category);
                //echo $this->db->last_query(); 

                //$data['tax_header']=$this->sales_invoice_book_model->fun_tax_header($from,$to,$this->session->userdata['logged_in']['company_id']);
                //print_r( $data['tax_header']);
                
                 
                if($data['ar_invoice_master']!=FALSE){
                    $data['page_name']='Sales';
                    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                    $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'Costsheet');

                    if(!empty($this->input->post('adr_company_id'))){

                      $customer_arr=explode('//',$this->input->post('adr_company_id'));
                      if(!empty($customer_arr[1])){
                        $data['ship_to']=$this->relate_model->select_one_active_record('adr_relate_companies',$this->session->userdata['logged_in']['company_id'],'adr_relate_companies.adr_company_id',$customer_arr[1],$this->session->userdata['logged_in']['language_id']);
                      }
                      
                    }
                    $data['customer_category']=$this->common_model->select_active_drop_down('address_category_master',$this->session->userdata['logged_in']['company_id']);
            
            
                    $this->load->view('Home/header');
                    $this->load->view('Home/nav',$data);
                    $this->load->view('Home/subnav');
                    $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                    $this->load->view(ucwords($this->router->fetch_class()).'/new-report-form',$data);
                    $this->load->view(ucwords($this->router->fetch_class()).'/new-report-result',$data);
                    $this->load->view('Home/footer');
                }else{
                      $data['page_name']='Sales';
                      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                      $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_invoice_book');
                      
                      $data['error']='No record in search transaction';
                      $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                      $data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','printing_group',$this->session->userdata['logged_in']['company_id']);
                      $data['customer_category']=$this->common_model->select_active_drop_down('address_category_master',$this->session->userdata['logged_in']['company_id']);
            
            
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


  function Contribution_by_print_type(){


    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'Costsheet');

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){
                $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
                if($data['account_periods_master']==FALSE){
                  $from_date="";
                }else{
                  foreach($data['account_periods_master'] as $account_periods_master_row){
                    $from_date=$account_periods_master_row->fin_year_start;
                  }
                }
                $data['print_type_wise']=$this->costsheet_model->contribution_print_type_wise('2022-04-01',date('Y-m-d'));
                //echo $this->db->last_query();

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view('Loading/loading');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/print-type-wise',$data);
                //$this->load->view(ucwords($this->router->fetch_class()).'/print-type-wise-sales_bkp_3jun2021',$data);
                $this->load->view('Home/footer');
          
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

    function Contribution_by_customer(){


    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'Costsheet');

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){
                $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
                if($data['account_periods_master']==FALSE){
                  $from_date="";
                }else{
                  foreach($data['account_periods_master'] as $account_periods_master_row){
                    $from_date=$account_periods_master_row->fin_year_start;
                  }
                }
                $data['print_type_wise']=$this->costsheet_model->contribution_by_customer('2023-04-01',date('Y-m-d'));
                //echo $this->db->last_query();

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view('Loading/loading');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/contribution-by-customer',$data);
                //$this->load->view(ucwords($this->router->fetch_class()).'/print-type-wise-sales_bkp_3jun2021',$data);
                $this->load->view('Home/footer');
          
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



  function Contribution_by_big_dia_small_dia_with_print_type(){


    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'Costsheet');

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){
                $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
                if($data['account_periods_master']==FALSE){
                  $from_date="";
                }else{
                  foreach($data['account_periods_master'] as $account_periods_master_row){
                    $from_date=$account_periods_master_row->fin_year_start;
                  }
                }
                $data['print_type_wise']=$this->costsheet_model->contribution_print_type_wise('2022-04-01',date('Y-m-d'));
                //echo $this->db->last_query();

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view('Loading/loading');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/big-dia-small-dia-with-print-type',$data);
                //$this->load->view(ucwords($this->router->fetch_class()).'/print-type-wise-sales_bkp_3jun2021',$data);
                $this->load->view('Home/footer');
          
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
  function search_result_product(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'Costsheet');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
           
            $this->form_validation->set_rules('adr_company_id','Bill To' ,'trim|xss_clean|max_length[150]|strtoupper|callback_customer_check');
            $this->form_validation->set_rules('consin_adr_company_id','Ship To' ,'trim|xss_clean|max_length[150]|strtoupper|callback_customer_check');
            $this->form_validation->set_rules('article_no','Article No' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('from_date','From Date' ,'required|trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('to_date','To Date' ,'required|trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('ar_invoice_no','Sales invoice no.' ,'trim|xss_clean');
            $this->form_validation->set_rules('for_export','Invoice Type' ,'trim|xss_clean');
           

            if($this->form_validation->run()==FALSE){

              if(!empty($this->input->post('adr_company_id'))){

                $customer_arr=explode('//',$this->input->post('adr_company_id'));
                if(!empty($customer_arr[1])){
                  $data['ship_to']=$this->relate_model->select_one_active_record('adr_relate_companies',$this->session->userdata['logged_in']['company_id'],'adr_relate_companies.adr_company_id',$customer_arr[1],$this->session->userdata['logged_in']['language_id']);
                }
                
              }

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              $data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','printing_group',$this->session->userdata['logged_in']['company_id']);
              $data['customer_category']=$this->common_model->select_active_drop_down('address_category_master',$this->session->userdata['logged_in']['company_id']);
            
            

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/search-form-product',$data);
                $this->load->view('Home/footer');
            }else{

                  $from=$this->common_model->change_date_format($this->input->post('from_date'),$this->session->userdata['logged_in']['company_id']);
                  $to=$this->common_model->change_date_format($this->input->post('to_date'),$this->session->userdata['logged_in']['company_id']);

                  $order_flag=$this->input->post('order_flag');
                  $dia=$this->input->post('sleeve_dia');
                  $order_no=$this->input->post('order_no');
                  $invoice_no=$this->input->post('invoice_no');
                  $print=$this->input->post('print_type');

                  if(!empty($this->input->post('customer_category'))){
                    $customer_category_arr=explode('//',$this->input->post('customer_category'));
                    $customer_category=$customer_category_arr[1];
                  }else{

                  $customer_category="";
                  }
                                   
                  $search=array();
                  

                  if(!empty($this->input->post('article_no'))){
                    $article_no_arr=explode('//',$this->input->post('article_no'));
                    $search['ar_invoice_details.article_no']=$article_no_arr[1];
                  } 

                  
                  if($order_flag!=''){
                    $search['ar_invoice_details.order_flag']=$order_flag;
                  }

                  if($dia!=''){
                    $search['ar_invoice_details.sleeve_dia']=$dia;
                  }

                  if($order_no!=''){
                    $search['ar_invoice_details.ref_ord_no']=$order_no;
                  }
                  
                  if($invoice_no!=''){
                    $search['ar_invoice_details.invoice_no']=$invoice_no;
                  }

                 
                 
                               

                $data['ar_invoice_master']=$this->costsheet_model->active_record_search_by_product('ar_invoice_master',$from,$to,$search,$customer_category,$this->session->userdata['logged_in']['company_id'],$print);
                //echo $this->db->last_query(); 

                //$data['tax_header']=$this->sales_invoice_book_model->fun_tax_header($from,$to,$this->session->userdata['logged_in']['company_id']);
                //print_r( $data['tax_header']);
                
                 
                if($data['ar_invoice_master']!=FALSE){
                    $data['page_name']='Sales';
                    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                    $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'costsheet');

                    if(!empty($this->input->post('adr_company_id'))){

                      $customer_arr=explode('//',$this->input->post('adr_company_id'));
                      if(!empty($customer_arr[1])){
                        $data['ship_to']=$this->relate_model->select_one_active_record('adr_relate_companies',$this->session->userdata['logged_in']['company_id'],'adr_relate_companies.adr_company_id',$customer_arr[1],$this->session->userdata['logged_in']['language_id']);
                      }
                      
                    }

                    $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                    $data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','printing_group',$this->session->userdata['logged_in']['company_id']);
                    $data['customer_category']=$this->common_model->select_active_drop_down('address_category_master',$this->session->userdata['logged_in']['company_id']);
            
            
                    $this->load->view('Home/header');
                    $this->load->view('Home/nav',$data);
                    $this->load->view('Home/subnav');
                    $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                    $this->load->view(ucwords($this->router->fetch_class()).'/search-form-product',$data);
                    $this->load->view(ucwords($this->router->fetch_class()).'/search-result-product',$data);
                    $this->load->view('Home/footer');
                }else{
                      $data['page_name']='Sales';
                      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                      $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'costsheet');
                      
                      $data['error']='No record in search transaction';
                      $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                      $data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','printing_group',$this->session->userdata['logged_in']['company_id']);
                      $data['customer_category']=$this->common_model->select_active_drop_down('address_category_master',$this->session->userdata['logged_in']['company_id']);
            
            
                      $this->load->view('Home/header');
                      $this->load->view('Home/nav',$data);
                      $this->load->view('Home/subnav');
                      $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                      $this->load->view(ucwords($this->router->fetch_class()).'/search-form-product',$data);
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

  function search_result(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'Costsheet');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
           
            $this->form_validation->set_rules('adr_company_id','Bill To' ,'trim|xss_clean|max_length[150]|strtoupper|callback_customer_check');
            $this->form_validation->set_rules('consin_adr_company_id','Ship To' ,'trim|xss_clean|max_length[150]|strtoupper|callback_customer_check');
            $this->form_validation->set_rules('article_no','Article No' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('from_date','From Date' ,'required|trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('to_date','To Date' ,'required|trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('ar_invoice_no','Sales invoice no.' ,'trim|xss_clean');
            $this->form_validation->set_rules('for_export','Invoice Type' ,'trim|xss_clean');
           

            if($this->form_validation->run()==FALSE){

              if(!empty($this->input->post('adr_company_id'))){

                $customer_arr=explode('//',$this->input->post('adr_company_id'));
                if(!empty($customer_arr[1])){
                  $data['ship_to']=$this->relate_model->select_one_active_record('adr_relate_companies',$this->session->userdata['logged_in']['company_id'],'adr_relate_companies.adr_company_id',$customer_arr[1],$this->session->userdata['logged_in']['language_id']);
                }
                
              }

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              $data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','printing_group',$this->session->userdata['logged_in']['company_id']);
              $data['customer_category']=$this->common_model->select_active_drop_down('address_category_master',$this->session->userdata['logged_in']['company_id']);
            
            

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
                  if($for_export!=''){
                      $search['for_export']=$for_export;
                  }

                 
                 
                               

                $data['ar_invoice_master']=$this->costsheet_model->active_record_search('ar_invoice_master',$search,$from,$to,$this->session->userdata['logged_in']['company_id'],$customer_category="");
                //echo $this->db->last_query(); 

                //$data['tax_header']=$this->sales_invoice_book_model->fun_tax_header($from,$to,$this->session->userdata['logged_in']['company_id']);
                //print_r( $data['tax_header']);
                
                 
                if($data['ar_invoice_master']!=FALSE){
                    $data['page_name']='Sales';
                    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                    $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'sales_order_book');

                    if(!empty($this->input->post('adr_company_id'))){

                      $customer_arr=explode('//',$this->input->post('adr_company_id'));
                      if(!empty($customer_arr[1])){
                        $data['ship_to']=$this->relate_model->select_one_active_record('adr_relate_companies',$this->session->userdata['logged_in']['company_id'],'adr_relate_companies.adr_company_id',$customer_arr[1],$this->session->userdata['logged_in']['language_id']);
                      }
                      
                    }

                    $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                    $data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','printing_group',$this->session->userdata['logged_in']['company_id']);
                    $data['customer_category']=$this->common_model->select_active_drop_down('address_category_master',$this->session->userdata['logged_in']['company_id']);
            
            
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
                      
                      $data['error']='No record in search transaction';
                      $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                      $data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','printing_group',$this->session->userdata['logged_in']['company_id']);
                      $data['customer_category']=$this->common_model->select_active_drop_down('address_category_master',$this->session->userdata['logged_in']['company_id']);
            
            
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



  function search_result_spring(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'Costsheet');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
           
            $this->form_validation->set_rules('adr_company_id','Bill To' ,'trim|xss_clean|max_length[150]|strtoupper|callback_customer_check');
            $this->form_validation->set_rules('consin_adr_company_id','Ship To' ,'trim|xss_clean|max_length[150]|strtoupper|callback_customer_check');
            $this->form_validation->set_rules('article_no','Article No' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('from_date','From Date' ,'required|trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('to_date','To Date' ,'required|trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('ar_invoice_no','Sales invoice no.' ,'trim|xss_clean');
            $this->form_validation->set_rules('for_export','Invoice Type' ,'trim|xss_clean');
           

            if($this->form_validation->run()==FALSE){

              if(!empty($this->input->post('adr_company_id'))){

                $customer_arr=explode('//',$this->input->post('adr_company_id'));
                if(!empty($customer_arr[1])){
                  $data['ship_to']=$this->relate_model->select_one_active_record('adr_relate_companies',$this->session->userdata['logged_in']['company_id'],'adr_relate_companies.adr_company_id',$customer_arr[1],$this->session->userdata['logged_in']['language_id']);
                }
                
              }

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              $data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','printing_group',$this->session->userdata['logged_in']['company_id']);
              $data['customer_category']=$this->common_model->select_active_drop_down('address_category_master',$this->session->userdata['logged_in']['company_id']);
            
            

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/search-form-spring',$data);
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
                  if($for_export!=''){
                      $search['for_export']=$for_export;
                  }

                 $data['ar_invoice_master']=$this->costsheet_model->active_record_search('ar_invoice_master',$search,$from,$to,$this->session->userdata['logged_in']['company_id'],$customer_category="");
                  echo $this->db->last_query();            
                 
                if($data['ar_invoice_master']!=FALSE){
                    $data['page_name']='Sales';
                    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                    $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'Costsheet');

                    if(!empty($this->input->post('adr_company_id'))){

                      $customer_arr=explode('//',$this->input->post('adr_company_id'));
                      if(!empty($customer_arr[1])){
                        $data['ship_to']=$this->relate_model->select_one_active_record('adr_relate_companies',$this->session->userdata['logged_in']['company_id'],'adr_relate_companies.adr_company_id',$customer_arr[1],$this->session->userdata['logged_in']['language_id']);
                      }
                      
                    }

                    $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                    $data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','printing_group',$this->session->userdata['logged_in']['company_id']);
                    $data['customer_category']=$this->common_model->select_active_drop_down('address_category_master',$this->session->userdata['logged_in']['company_id']);
            
            
                    $this->load->view('Home/header');
                    $this->load->view('Home/nav',$data);
                    $this->load->view('Home/subnav');
                    $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                    $this->load->view(ucwords($this->router->fetch_class()).'/search-form-spring',$data);
                    $this->load->view(ucwords($this->router->fetch_class()).'/search-result-spring',$data);
                    $this->load->view('Home/footer');
                }else{
                      $data['page_name']='Sales';
                      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                      $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'Costsheet');
                      
                      $data['error']='No record in search transaction';
                      $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                      $data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','printing_group',$this->session->userdata['logged_in']['company_id']);
                      $data['customer_category']=$this->common_model->select_active_drop_down('address_category_master',$this->session->userdata['logged_in']['company_id']);
            
            
                      $this->load->view('Home/header');
                      $this->load->view('Home/nav',$data);
                      $this->load->view('Home/subnav');
                      $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                      $this->load->view(ucwords($this->router->fetch_class()).'/search-form-spring',$data);
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

  function index_result(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'Costsheet');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
           
            $this->form_validation->set_rules('adr_company_id','Bill To' ,'trim|xss_clean|max_length[150]|strtoupper|callback_customer_check');
            $this->form_validation->set_rules('consin_adr_company_id','Ship To' ,'trim|xss_clean|max_length[150]|strtoupper|callback_customer_check');
            $this->form_validation->set_rules('article_no','Article No' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('from_date','From Date' ,'required|trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('to_date','To Date' ,'required|trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('ar_invoice_no','Sales invoice no.' ,'trim|xss_clean');
            $this->form_validation->set_rules('for_export','Invoice Type' ,'trim|xss_clean');
           

            if($this->form_validation->run()==FALSE){

              if(!empty($this->input->post('adr_company_id'))){

                $customer_arr=explode('//',$this->input->post('adr_company_id'));
                if(!empty($customer_arr[1])){
                  $data['ship_to']=$this->relate_model->select_one_active_record('adr_relate_companies',$this->session->userdata['logged_in']['company_id'],'adr_relate_companies.adr_company_id',$customer_arr[1],$this->session->userdata['logged_in']['language_id']);
                }
                
              }

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              $data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','printing_group',$this->session->userdata['logged_in']['company_id']);
              $data['customer_category']=$this->common_model->select_active_drop_down('address_category_master',$this->session->userdata['logged_in']['company_id']);
              $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
              $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']); 
              $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);            
            
            

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

                  $status_flag=$this->input->post('status_flag');
                  $order_flag=$this->input->post('order_flag');
                  $dia=$this->input->post('sleeve_dia');
                  $order_no=$this->input->post('order_no');
                  $invoice_no=$this->input->post('invoice_no');

                  $print=$this->input->post('print_type');
                  $layer=$this->input->post('layer');

                  $length_from=$this->input->post('sleeve_length_from');
                  $length_to=$this->input->post('sleeve_length_to');

                  $shoulder_type=$this->input->post('shoulder_type');
                  $shoulder_foil=$this->input->post('shoulder_foil');
                  $cap_dia=$this->input->post('cap_dia');
                  $cap_type=$this->input->post('cap_type');
                  $cap_finish=$this->input->post('cap_finish');
                  $cap_foil=$this->input->post('cap_foil');
                  $cap_metalization=$this->input->post('cap_metalization');
                  $cap_shrink_sleeve=$this->input->post('cap_shrink_sleeve');
                  $tube_foil_1=$this->input->post('tube_foil_1');


                  if(!empty($this->input->post('customer_category'))){
                    $customer_category_arr=explode('//',$this->input->post('customer_category'));
                    $customer_category=$customer_category_arr[1];
                  }else{

                  $customer_category="";
                  }
 
                  if(!empty($this->input->post('article_no'))){
                    $article_no_arr=explode('//',$this->input->post('article_no'));
                    $search['costsheet_master.article_no']=$article_no_arr[1];
                  } 

                  if($status_flag!=''){
                    $search['status_flag']=$status_flag;
                  }

                  if($order_flag!=''){
                    $search['order_type']=$order_flag;
                  }

                  if($dia!=''){
                    $search['dia']=$dia;
                  }

                  if($layer!=''){
                    $search['layer']=$layer;
                  }
                  

                  if(!empty($this->input->post('shoulder_type'))){
                    $shoulder_array=explode("//",$this->input->post('shoulder_type'));
                    $search['shoulder_type']=$shoulder_array[0];
                  }

                  if(!empty($this->input->post('cap_dia'))){
                  $cap_dia_array=explode("//",$this->input->post('cap_dia'));
                  $search['cap_dia']=$cap_dia_array[0];
                  }

                  if(!empty($this->input->post('cap_type'))){
                  $cap_type_array=explode("//",$this->input->post('cap_type'));
                  $search['cap_type']=$cap_type_array[0];
                  }

                  if($cap_finish!=''){
                    $search['cap_finish']=$cap_finish;
                  }

                  if($shoulder_foil!=''){
                    $search['shoulder_foil']=$shoulder_foil;
                  }

                  if($cap_foil!=''){
                    $search['cap_foil']=$cap_foil;
                  }

                  if($cap_metalization!=''){
                    $search['cap_metalization']=$cap_metalization;
                  }

                  if($cap_shrink_sleeve!=''){
                    $search['cap_shrink_sleeve']=$cap_shrink_sleeve;
                  }

                  if($tube_foil_1!=''){
                    $search['tube_foil_1']=$tube_foil_1;
                  }



                  if($order_no!=''){
                    $search['order_no']=$order_no;
                  }
                  
                  if($invoice_no!=''){
                    $search['invoice_no']=$invoice_no;
                  }

                  if(!empty($this->input->post('status'))){
                      $status=$this->input->post('status');
                  }else{
                      $status="";
                  }

                  if(!empty($this->input->post('sort_by'))){
                      $sort_by=$this->input->post('sort_by');
                  }else{
                      $sort_by="";
                  }

                  if(!empty($this->input->post('filter_by'))){
                      $filter_by=$this->input->post('filter_by');
                  }else{
                      $filter_by="";
                  }
                 
                 //$search = array_filter($search);
                               

                $data['costsheet_master']=$this->costsheet_model->active_record_search_costsheet('costsheet_master',$search,$from,$to,$length_from,$length_to,$print,$customer_category,$status,$sort_by,$this->session->userdata['logged_in']['company_id'],$filter_by);
                //echo $this->db->last_query();
                 
                if($data['costsheet_master']!=FALSE){
                    $data['page_name']='Sales';
                    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                    $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'Costsheet');

                    if(!empty($this->input->post('adr_company_id'))){

                      $customer_arr=explode('//',$this->input->post('adr_company_id'));
                      if(!empty($customer_arr[1])){
                        $data['ship_to']=$this->relate_model->select_one_active_record('adr_relate_companies',$this->session->userdata['logged_in']['company_id'],'adr_relate_companies.adr_company_id',$customer_arr[1],$this->session->userdata['logged_in']['language_id']);
                      }
                      
                    }

                    $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                    $data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','printing_group',$this->session->userdata['logged_in']['company_id']);
                    $data['customer_category']=$this->common_model->select_active_drop_down('address_category_master',$this->session->userdata['logged_in']['company_id']);
                    $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
                    $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
                    $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
                    
            
                    $this->load->view('Home/header');
                    $this->load->view('Home/nav',$data);
                    $this->load->view('Home/subnav');
                    $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                    $this->load->view(ucwords($this->router->fetch_class()).'/search-form-new',$data);
                    $this->load->view(ucwords($this->router->fetch_class()).'/search-result-new',$data);
                    $this->load->view('Home/footer');
                }else{
                      $data['page_name']='Sales';
                      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                      $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'Costsheet');
                      
                      $data['error']='No record in search transaction';
                      $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                      $data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','printing_group',$this->session->userdata['logged_in']['company_id']);
                      $data['customer_category']=$this->common_model->select_active_drop_down('address_category_master',$this->session->userdata['logged_in']['company_id']);
                      $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
                      $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
                      $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
            
            
                      $this->load->view('Home/header');
                      $this->load->view('Home/nav',$data);
                      $this->load->view('Home/subnav');
                      $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                      $this->load->view(ucwords($this->router->fetch_class()).'/search-form-new',$data);
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



  function index_resultt(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'Costsheet');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
           
            $this->form_validation->set_rules('adr_company_id','Bill To' ,'trim|xss_clean|max_length[150]|strtoupper|callback_customer_check');
            $this->form_validation->set_rules('consin_adr_company_id','Ship To' ,'trim|xss_clean|max_length[150]|strtoupper|callback_customer_check');
            $this->form_validation->set_rules('article_no','Article No' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('from_date','From Date' ,'required|trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('to_date','To Date' ,'required|trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('ar_invoice_no','Sales invoice no.' ,'trim|xss_clean');
            $this->form_validation->set_rules('for_export','Invoice Type' ,'trim|xss_clean');
           

            if($this->form_validation->run()==FALSE){

              if(!empty($this->input->post('adr_company_id'))){

                $customer_arr=explode('//',$this->input->post('adr_company_id'));
                if(!empty($customer_arr[1])){
                  $data['ship_to']=$this->relate_model->select_one_active_record('adr_relate_companies',$this->session->userdata['logged_in']['company_id'],'adr_relate_companies.adr_company_id',$customer_arr[1],$this->session->userdata['logged_in']['language_id']);
                }
                
              }

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              $data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','printing_group',$this->session->userdata['logged_in']['company_id']);
              $data['customer_category']=$this->common_model->select_active_drop_down('address_category_master',$this->session->userdata['logged_in']['company_id']);
              $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
              $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']); 
              $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);            
            
            

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/search-form-neww',$data);
                $this->load->view('Home/footer');
            }else{

                  $from=$this->common_model->change_date_format($this->input->post('from_date'),$this->session->userdata['logged_in']['company_id']);
                  $to=$this->common_model->change_date_format($this->input->post('to_date'),$this->session->userdata['logged_in']['company_id']);

                  

                  $search=array();

                  $status_flag=$this->input->post('status_flag');
                  $order_flag=$this->input->post('order_flag');
                  $dia=$this->input->post('sleeve_dia');
                  $order_no=$this->input->post('order_no');
                  $invoice_no=$this->input->post('invoice_no');

                  $print=$this->input->post('print_type');
                  $layer=$this->input->post('layer');

                  $length_from=$this->input->post('sleeve_length_from');
                  $length_to=$this->input->post('sleeve_length_to');

                  $shoulder_type=$this->input->post('shoulder_type');
                  $shoulder_foil=$this->input->post('shoulder_foil');
                  $cap_dia=$this->input->post('cap_dia');
                  $cap_type=$this->input->post('cap_type');
                  $cap_finish=$this->input->post('cap_finish');
                  $cap_foil=$this->input->post('cap_foil');
                  $cap_metalization=$this->input->post('cap_metalization');
                  $cap_shrink_sleeve=$this->input->post('cap_shrink_sleeve');
                  $tube_foil_1=$this->input->post('tube_foil_1');


                  if(!empty($this->input->post('customer_category'))){
                    $customer_category_arr=explode('//',$this->input->post('customer_category'));
                    $customer_category=$customer_category_arr[1];
                  }else{

                  $customer_category="";
                  }
 
                  if(!empty($this->input->post('article_no'))){
                    $article_no_arr=explode('//',$this->input->post('article_no'));
                    $search['costsheet_master.article_no']=$article_no_arr[1];
                  } 

                  if($status_flag!=''){
                    $search['status_flag']=$status_flag;
                  }

                  if($order_flag!=''){
                    $search['order_type']=$order_flag;
                  }

                  if($dia!=''){
                    $search['dia']=$dia;
                  }

                  if($layer!=''){
                    $search['layer']=$layer;
                  }
                  

                  if(!empty($this->input->post('shoulder_type'))){
                    $shoulder_array=explode("//",$this->input->post('shoulder_type'));
                    $search['shoulder_type']=$shoulder_array[0];
                  }

                  if(!empty($this->input->post('cap_dia'))){
                  $cap_dia_array=explode("//",$this->input->post('cap_dia'));
                  $search['cap_dia']=$cap_dia_array[0];
                  }

                  if(!empty($this->input->post('cap_type'))){
                  $cap_type_array=explode("//",$this->input->post('cap_type'));
                  $search['cap_type']=$cap_type_array[0];
                  }

                  if($cap_finish!=''){
                    $search['cap_finish']=$cap_finish;
                  }

                  if($shoulder_foil!=''){
                    $search['shoulder_foil']=$shoulder_foil;
                  }

                  if($cap_foil!=''){
                    $search['cap_foil']=$cap_foil;
                  }

                  if($cap_metalization!=''){
                    $search['cap_metalization']=$cap_metalization;
                  }

                  if($cap_shrink_sleeve!=''){
                    $search['cap_shrink_sleeve']=$cap_shrink_sleeve;
                  }

                  if($tube_foil_1!=''){
                    $search['tube_foil_1']=$tube_foil_1;
                  }



                  if($order_no!=''){
                    $search['order_no']=$order_no;
                  }
                  
                  if($invoice_no!=''){
                    $search['invoice_no']=$invoice_no;
                  }

                  if(!empty($this->input->post('status'))){
                      $status=$this->input->post('status');
                  }else{
                      $status="";
                  }

                  if(!empty($this->input->post('sort_by'))){
                      $sort_by=$this->input->post('sort_by');
                  }else{
                      $sort_by="";
                  }

                  if(!empty($this->input->post('filter_by'))){
                      $filter_by=$this->input->post('filter_by');
                  }else{
                      $filter_by="";
                  }
                 
                 //$search = array_filter($search);
                               

                $data['costsheet_master']=$this->costsheet_model->active_record_search_costsheet('costsheet_value_master',$search,$from,$to,$length_from,$length_to,$print,$customer_category,$status,$sort_by,$this->session->userdata['logged_in']['company_id'],$filter_by);
                //echo $this->db->last_query();
                 
                if($data['costsheet_master']!=FALSE){
                    $data['page_name']='Sales';
                    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                    $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'Costsheet');

                    if(!empty($this->input->post('adr_company_id'))){

                      $customer_arr=explode('//',$this->input->post('adr_company_id'));
                      if(!empty($customer_arr[1])){
                        $data['ship_to']=$this->relate_model->select_one_active_record('adr_relate_companies',$this->session->userdata['logged_in']['company_id'],'adr_relate_companies.adr_company_id',$customer_arr[1],$this->session->userdata['logged_in']['language_id']);
                      }
                      
                    }

                    $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                    $data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','printing_group',$this->session->userdata['logged_in']['company_id']);
                    $data['customer_category']=$this->common_model->select_active_drop_down('address_category_master',$this->session->userdata['logged_in']['company_id']);
                    $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
                    $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
                    $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
                    
            
                    $this->load->view('Home/header');
                    $this->load->view('Home/nav',$data);
                    $this->load->view('Home/subnav');
                    $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                    $this->load->view(ucwords($this->router->fetch_class()).'/search-form-neww',$data);
                    $this->load->view(ucwords($this->router->fetch_class()).'/search-result-neww',$data);
                    $this->load->view('Home/footer');
                }else{
                      $data['page_name']='Sales';
                      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                      $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'Costsheet');
                      
                      $data['error']='No record in search transaction';
                      $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                      $data['print_type']=$this->common_model->select_active_distinct_drop_down('lacquer_types_master','printing_group',$this->session->userdata['logged_in']['company_id']);
                      $data['customer_category']=$this->common_model->select_active_drop_down('address_category_master',$this->session->userdata['logged_in']['company_id']);
                      $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
                      $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
                      $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
            
            
                      $this->load->view('Home/header');
                      $this->load->view('Home/nav',$data);
                      $this->load->view('Home/subnav');
                      $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                      $this->load->view(ucwords($this->router->fetch_class()).'/search-form-neww',$data);
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



  public function compare(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'Costsheet');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

            $this->form_validation->set_rules('costsheet_id[]','Selection', 'required');
            if($this->form_validation->run()==FALSE){
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
              $this->load->view('Home/footer');
            }else{

              for($i=1;$i<=count($this->input->post('costsheet_id[]'));$i++){
                //echo $this->input->post('costsheet_id['.$i.']');

              }
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/compare',$this->input->post('costsheet_id[]'));
              $this->load->view('Home/footer');


            
          }
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