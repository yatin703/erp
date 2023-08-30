<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Springtube_bodymaking_wip extends CI_Controller {

  function __construct(){    
    parent::__construct();
    if($this->session->userdata('logged_in')){
      
      $this->load->model('common_model');
      $this->load->model('article_model');
        $this->load->model('customer_model');
      $this->load->model('sales_order_book_model');
      $this->load->model('sales_order_status_model');
      $this->load->model('artwork_springtube_model');
      $this->load->model('springtube_bodymaking_wip_model');
      $this->load->model('springtube_bodymaking_production_model');
      
    }else{
      redirect('login','refresh');
    }
  }

  function index(){
    
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){

              $table='springtube_bodymaking_wip_master';
              include('pagination_wip.php');
              $data['springtube_bodymaking_wip_master']=$this->springtube_bodymaking_wip_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
             
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
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

  function archive_records(){
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
          //print_r( $data['formrights']);

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

              $table='springtube_bodymaking_wip_master';
              include('pagination_archive.php');
              $data['springtube_bodymaking_wip_master']=$this->springtube_bodymaking_wip_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/archive-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/archive-records',$data);
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

  function search(){    
    
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){


              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              
              //$data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);

              $data_search=array('status'=>0);
              $data['springtube_bodymaking_wip_master']=$this->springtube_bodymaking_wip_model->active_record_search('springtube_bodymaking_wip_master',$this->session->userdata['logged_in']['company_id'],$data_search,$this->input->post('from_date'),$this->input->post('to_date')); 
             //echo $this->db->last_query(); 
             
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
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
  function search_result(){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

            $this->form_validation->set_rules('from_date','From Date' ,'trim|xss_clean|exact_length[10]');
            $this->form_validation->set_rules('to_date','To Date' ,'trim|xss_clean|exact_length[10]');
            $this->form_validation->set_rules('order_no','Order No.' ,'trim|xss_clean');        
            $this->form_validation->set_rules('jobcard_no','Jobcard No.' ,'trim|xss_clean');
            $this->form_validation->set_rules('sleeve_dia','Sleeve Dia' ,'trim|xss_clean');
            $this->form_validation->set_rules('sleeve_length','Sleeve Length' ,'trim|xss_clean');
            $this->form_validation->set_rules('article_no','article_no' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('film_code','Film Code' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('film_masterbatch_two','Second Layer MB' ,'trim|xss_clean');
            $this->form_validation->set_rules('customer','Customer' ,'trim|xss_clean|callback_customer_check');
            $this->form_validation->set_rules('status','Status' ,'trim|xss_clean');
                       
            if($this->form_validation->run()==FALSE){

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);

              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
              $this->load->view('Home/footer');
            }else{              
              
              
              $data_search=array();
              if($this->input->post('jobcard_no')!=''){
                $data_search['jobcard_no']=$this->input->post('jobcard_no');
              }
              if($this->input->post('customer')!=''){
                $customer_arr=explode("//",$this->input->post('customer'));
                $data_search['customer']=$customer_arr[1];
              }

              if($this->input->post('order_no')!=''){
                $data_search['order_no']=$this->input->post('order_no');
              }
              if($this->input->post('sleeve_dia')!=''){
                $sleeve_dia_arr=explode("//", $this->input->post('sleeve_dia'));
                $data_search['sleeve_dia']=$sleeve_dia_arr[0];
              }
              if($this->input->post('sleeve_length')!=''){
                $data_search['sleeve_length']=$this->input->post('sleeve_length');
              }
              if($this->input->post('article_no')!=''){
                $article_arr=explode("//",$this->input->post('article_no'));
                $data_search['article_no']=$article_arr[1];
              }
              if($this->input->post('film_code')!=''){
                $film_code_arr=explode("//",$this->input->post('film_code'));
                $data_search['film_code']=$film_code_arr[1];
              }
              if($this->input->post('total_microns')!=''){
                $data_search['total_microns']=$this->input->post('total_microns');
              }
              if($this->input->post('film_masterbatch_two')!=''){
                $data_search['second_layer_mb']=$this->input->post('film_masterbatch_two');
              }

              if($this->input->post('status')!=''){
                $data_search['status']=$this->input->post('status');
              }
             

              //$data_search=array('status'=>0);
              $data['springtube_bodymaking_wip_master']=$this->springtube_bodymaking_wip_model->active_record_search('springtube_bodymaking_wip_master',$this->session->userdata['logged_in']['company_id'],$data_search,$this->input->post('from_date'),$this->input->post('to_date')); 
             //echo $this->db->last_query();            

              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);                
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
               

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
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

  function article_check($str){
    
      if(!empty($str)){
      $item_code=explode('//',$str);
      if(!empty($item_code[1])){
      $data['item']=$this->common_model->select_one_active_record_nonlanguage_without_archive('article_name_info',$this->session->userdata['logged_in']['company_id'],'article_no',$item_code[1]);
      //echo $this->db->last_query();

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

  function customer_check($str){

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

  function wip_release($bm_wip_id){
       
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->new==1){

              $table='springtube_bodymaking_wip_master';
              $data['springtube_bodymaking_wip_master']=$this->springtube_bodymaking_wip_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'bm_wip_id',$bm_wip_id);
              
              
             // echo $this->db->last_query();

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/wip-release-form',$data);
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

  function wip_release_save(){
       
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->new==1){
              
              $this->form_validation->set_rules('jobcard_no','Jobcard No' ,'required|trim|xss_clean|max_length[50]');             ;
              $this->form_validation->set_rules('total_ok_meters','Total Ok Meters' ,'required|trim|xss_clean|max_length[10]');
               $this->form_validation->set_rules('release_meters','Release Meters' ,'required|trim|xss_clean|max_length[10]|greater_than[0]|numeric');
              $this->form_validation->set_rules('release_to','Release To' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('release_remarks','Remarks' ,'required|trim|xss_clean|max_length[256]');

              if($this->input->post('release_to')=='1'){

                $this->form_validation->set_rules('release_to_order_no','Release To Order' ,'required|trim|xss_clean|max_length[20]');
              }else{

                $this->form_validation->set_rules('release_to_order_no','Release To Order' ,'trim|xss_clean|max_length[20]');
              }
             

              //if($this->input->post('release_to')=='1' && strpos($this->input->post('order_no'),"ST")!=''){

              if($this->input->post('release_to')=='1' &&  substr($this->input->post('order_no'),0,2)=='ST'){

                //if(substr($this->input->post('order_no'),0,2)!='ST'){
              //if($this->input->post('release_to')=='1'){

                $this->form_validation->set_rules('release_to_order_no_1','Release To Order No' ,'required|trim|xss_clean|max_length[50]'); 
                $this->form_validation->set_rules('release_article_no','Release To Article No' ,'required|trim|xss_clean|max_length[50]');               

              }

              if($this->input->post('release_article_no')!=''){
                $this->form_validation->set_rules('release_article_no','Release To Article No' ,'callback_check_specification');
              }          


              if($this->form_validation->run()==FALSE){

                $wip_id=$this->input->post('wip_id');               

                $table='springtube_extrusion_wip_master';
                $data['springtube_extrusion_wip_master']=$this->springtube_extrusion_wip_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'wip_id',$wip_id);
                
                //echo $this->db->last_query();

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/wip-release-form',$data);
                $this->load->view('Home/footer');

              }else{ 
                // echo 'validation true';
                // exit;

                  $wip_id='';
                  $wip_id=$this->input->post('wip_id');

                  $status=0;

                  $details_id='';
                  $customer='';
                  $jobcard_no='';
                  $order_no='';
                  $article_no='';
                  $sleeve_diameter='';
                  $sleeve_length='';
                  $total_microns='';
                  $film_mb_2='';
                  $film_mb_6='';
                  $film_code='';
                  $total_ok_meters=0;
                  $pending_meters=0;

                  $total_plan_meters=0;

                  $release_to_bom_no='';
                  $release_to_bom_version_no='';

                  $springtube_extrusion_wip_master_result=$this->common_model->select_one_active_record('springtube_extrusion_wip_master',$this->session->userdata['logged_in']['company_id'],'wip_id',$wip_id);

              
                  foreach($springtube_extrusion_wip_master_result as $row) {

                    $details_id=$row->details_id;
                    $jobcard_no=$row->jobcard_no;
                    $status=$row->status;
                  } 

                if($status==0){
                  
                  $production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no', $jobcard_no);
              
                  foreach($production_master_result as $production_master_row) {
                    $order_no=$production_master_row->sales_ord_no;
                    $article_no=$production_master_row->article_no;
                    $total_plan_meters=$production_master_row->total_meters;
                  }

                  $order_master_result=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$order_no);
                  foreach($order_master_result as $order_master_row){
                    $customer=$order_master_row->customer_no;                      
                  }

                  $data_order_details=array(
                  'order_no'=>$order_no,
                  'article_no'=>$article_no
                  );

                  $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
                  foreach($order_details_result as $order_details_row){
                    $bom_no=$order_details_row->spec_id;
                    $bom_version_no=$order_details_row->spec_version_no;
                  }

                  $data=array('bom_no'=>$bom_no,'bom_version_no'=>$bom_version_no);

                  $bill_of_material_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data);

                  foreach ($bill_of_material_result as $bill_of_material_row) {
                    $bom_id=$bill_of_material_row->bom_id;
                    $film_code=$bill_of_material_row->sleeve_code;
                     
                  } 
                //SLEEVE---------------------------------

                  $film_spec_id='';
                  $film_spec_version='';

                  $film_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$film_code);

                  foreach($film_code_result as $film_code_row){                   
                    $film_spec_id=$film_code_row->spec_id;
                    $film_spec_version=$film_code_row->spec_version_no;
                  }

                  $specs['spec_id']=$film_spec_id;
                  $specs['spec_version_no']=$film_spec_version;

                  $specs_result=$this->sales_order_book_model->select_film_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$specs);
                
                  $total_microns=0;
                
                                             
                  foreach($specs_result as $specs_row){
                      $sleeve_diameter=$specs_row->SLEEVE_DIA;
                      $sleeve_length=$specs_row->SLEEVE_LENGTH;
                      $micron_1=$specs_row->FILM_GUAGE_1;
                      $micron_2=$specs_row->FILM_GUAGE_2;
                      $film_mb_2=$specs_row->FILM_MASTER_BATCH_2;
                      $micron_3=$specs_row->FILM_GUAGE_3;
                      $micron_4=$specs_row->FILM_GUAGE_4;
                      $micron_5=$specs_row->FILM_GUAGE_5;
                      $micron_6=$specs_row->FILM_GUAGE_6;
                      $film_mb_6=$specs_row->FILM_MASTER_BATCH_6;
                      $micron_7=$specs_row->FILM_GUAGE_7;
                       
                  }


                  $total_microns=$micron_1+$micron_2+$micron_3+$micron_4+$micron_5+$micron_6+$micron_7; 

                  // Issuing to Same SO Specs Details----------
                  
                  //if(strpos($this->input->post('order_no'),"ST")!=''){ 

                  if(substr($this->input->post('order_no'),0,2)=='ST'){
                  
                   // Issueing to Diiffrent SO Specs-----------

                      $release_to_order_master_result=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$this->input->post('release_to_order_no_1'));
                        foreach($release_to_order_master_result as $release_to_order_master_row){
                          $release_to_customer=$release_to_order_master_row->customer_no;                      
                        }

                        $data_release_to_order_details=array(
                        'order_no'=>$this->input->post('release_to_order_no_1'),
                        'article_no'=>$this->input->post('release_article_no')
                        );

                        $release_to_order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_release_to_order_details);
                        foreach($release_to_order_details_result as $release_to_order_details_row){
                          $release_to_bom_no=$release_to_order_details_row->spec_id;
                          $release_to_bom_version_no=$release_to_order_details_row->spec_version_no;
                        }

                        $data=array('bom_no'=>$release_to_bom_no,'bom_version_no'=>$release_to_bom_version_no);

                        $release_to_bill_of_material_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data);

                        $release_to_film_code='';

                        foreach ($release_to_bill_of_material_result as $release_to_bill_of_material_row) {
                          $release_to_bom_id=$release_to_bill_of_material_row->bom_id;
                          $release_to_film_code=$release_to_bill_of_material_row->sleeve_code;
                           
                        }

                        //SLEEVE---------------------------------
                        $release_to_film_spec_id='';
                        $release_to_film_spec_version='';

                        $release_to_film_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$release_to_film_code);

                        foreach($release_to_film_code_result as $release_to_film_code_row){                   
                          $release_to_film_spec_id=$release_to_film_code_row->spec_id;
                          $release_to_film_spec_version=$release_to_film_code_row->spec_version_no;
                        }

                        $specs['spec_id']=$release_to_film_spec_id;
                        $specs['spec_version_no']=$release_to_film_spec_version;

                        $release_to_specs_result=$this->sales_order_book_model->select_film_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$specs);
                         
                          $release_to_total_microns=0;
                          foreach($release_to_specs_result as $specs_row){
                            $release_to_sleeve_diameter=$specs_row->SLEEVE_DIA;
                            $release_to_sleeve_length=$specs_row->SLEEVE_LENGTH;
                            $release_to_micron_1=$specs_row->FILM_GUAGE_1;
                            $release_to_micron_2=$specs_row->FILM_GUAGE_2;
                            $release_to_film_mb_2=$specs_row->FILM_MASTER_BATCH_2;
                            $release_to_micron_3=$specs_row->FILM_GUAGE_3;
                            $release_to_micron_4=$specs_row->FILM_GUAGE_4;
                            $release_to_micron_5=$specs_row->FILM_GUAGE_5;
                            $release_to_micron_6=$specs_row->FILM_GUAGE_6;
                            $release_to_film_mb_6=$specs_row->FILM_MASTER_BATCH_6;
                            $release_to_micron_7=$specs_row->FILM_GUAGE_7;
                            
                            $release_to_total_microns=$specs_row->FILM_GUAGE_1+$specs_row->FILM_GUAGE_2+$specs_row->FILM_GUAGE_3+$specs_row->FILM_GUAGE_4+$specs_row->FILM_GUAGE_5+$specs_row->FILM_GUAGE_6+$specs_row->FILM_GUAGE_7;
                          }

                  }                   
                  

                  $total_ok_meters=$this->input->post('total_ok_meters');
                  $release_meters=$this->input->post('release_meters');
                  $pending_meters=0;
                  $pending_meters=$total_ok_meters-$release_meters;


                  $released_weight=0;
                  $weight_result=$this->springtube_extrusion_production_model->get_job_weight_extrusion($jobcard_no,$this->session->userdata['logged_in']['company_id']);

                    $total_weight=0;  
                    foreach ($weight_result as $key => $weight_row) {
                      $total_weight=$this->common_model->read_number($weight_row->total_qty,$this->session->userdata['logged_in']['company_id']);
                    }
                    $one_meter_weight=($total_weight/$total_plan_meters);

                    $released_weight=round($one_meter_weight*$release_meters,2);


                  //TO PRINTING WIP BEFORE PRINT----------------
                  if($this->input->post('release_to')=='1'){                    
                    
                    //Partially release to PRINTING WIP BEFORE PRINT--------------------
                    if($pending_meters>0){

                      //WIP Is releasing to Same SO----------------------
                      //if(strpos($this->input->post('order_no'),"ST")==''){            
                      if(substr($this->input->post('order_no'),0,2)!='ST'){                               

                        $release_qty=$this->common_model->jobcard_meters_to_qty($jobcard_no,$release_meters);

                        $data_wip_before_insert=array(
                        'bprint_wip_date'=>date('Y-m-d'),                      
                        'details_id'=>$details_id,
                        'jobcard_no'=>$jobcard_no,
                        'customer'=>$customer,
                        'order_no'=>$order_no,
                        'article_no'=>$article_no,
                        'sleeve_dia'=>$sleeve_diameter,
                        'sleeve_length'=>$sleeve_length,
                        'total_microns'=>$total_microns,
                        'second_layer_mb'=>$film_mb_2,
                        'sixth_layer_mb'=>$film_mb_6,                           
                        'film_code'=>$film_code,
                        'bwip_cost_per_meter'=>$this->input->post('wip_cost_per_meter'),
                        'bprint_wip_meters'=>$release_meters,
                        'bprint_wip_qty'=>$release_qty,                      
                        'created_date'=>date('Y-m-d H:i:s'),
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'from_process'=>'6',
                        'user_id'=>$this->session->userdata['logged_in']['user_id'],
                        'ref_wip_id'=>$this->input->post('wip_id')
                      );                

                      //$result=$this->common_model->save('springtube_printing_wip_master_before',$data);

                      $pending_ok_qty=$this->common_model->jobcard_meters_to_qty($jobcard_no,$pending_meters);

                      $data_wip_insert=array(
                        'wip_date'=>date('Y-m-d'),                      
                        'details_id'=>$details_id,
                        'jobcard_no'=>$jobcard_no,
                        'customer'=>$customer,
                        'order_no'=>$order_no,
                        'article_no'=>$article_no,
                        'sleeve_dia'=>$sleeve_diameter,
                        'sleeve_length'=>$sleeve_length,
                        'total_microns'=>$total_microns,
                        'second_layer_mb'=>$film_mb_2,
                        'sixth_layer_mb'=>$film_mb_6,                           
                        'film_code'=>$film_code,
                         'wip_cost_per_meter'=>$this->input->post('wip_cost_per_meter'),
                        'total_ok_meters'=>$pending_meters, 
                        'ok_qty'=>$pending_ok_qty,                     
                        'created_date'=>date('Y-m-d H:i:s'),
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'from_process'=>'6',
                        'user_id'=>$this->session->userdata['logged_in']['user_id']                        
                        );

                        //$result=$this->common_model->save('springtube_extrusion_wip_master',$data);

                        $data_wip_update=array(
                          'status'=>'1',
                          'release_to_order_no'=>$this->input->post('order_no'), 
                          'release_meters'=>$release_meters,
                          'release_qty'=>$release_qty,
                          'release_date'=>date('Y-m-d'),
                          'release_by'=>$this->session->userdata['logged_in']['user_id'],
                          'next_process'=>'9',
                          'release_remarks'=>$this->input->post('release_remarks') 
                        );

                        //$result=$this->common_model->update_one_active_record('springtube_extrusion_wip_master',$data,'wip_id',$wip_id,$this->session->userdata['logged_in']['company_id']);


                        $trans_status=$this->springtube_extrusion_wip_model->wip_release_partially($data_wip_before_insert,$data_wip_insert,$data_wip_update,$wip_id);

                      }else{

                       //Stock SO WIP releasing to Other SO---------                     
                        $rel_qty=0;
                        $ups=2;
                        echo $rel_qty=floor(($release_meters*1000)/($release_to_sleeve_length+2.5))*$ups;



                        $data_wip_before_insert=array(
                          'bprint_wip_date'=>date('Y-m-d'),                      
                          'details_id'=>$details_id,
                          'jobcard_no'=>'',
                          'customer'=>$release_to_customer,
                          'order_no'=>$this->input->post('release_to_order_no_1'),
                          'article_no'=>$this->input->post('release_article_no'),
                          'sleeve_dia'=>$release_to_sleeve_diameter,
                          'sleeve_length'=>$release_to_sleeve_length,
                          'total_microns'=>$release_to_total_microns,
                          'second_layer_mb'=>$release_to_film_mb_2,
                          'sixth_layer_mb'=>$release_to_film_mb_6,                           
                          'film_code'=>$release_to_film_code,
                          'bwip_cost_per_meter'=>$this->input->post('wip_cost_per_meter'),
                          'bprint_wip_meters'=>$release_meters,
                          'bprint_wip_qty'=>$rel_qty,
                          //'bprint_wip_qty'=>round(($release_meters*2*1000)/($release_to_sleeve_length+2.5)),
                          'created_date'=>date('Y-m-d H:i:s'),
                          'company_id'=>$this->session->userdata['logged_in']['company_id'],
                          'from_process'=>'6',
                          'user_id'=>$this->session->userdata['logged_in']['user_id'],
                          'ref_wip_id'=>$this->input->post('wip_id')
                        ); 



                        //$result=$this->common_model->save('springtube_printing_wip_master_before',$data);

                        $pending_ok_qty=$this->common_model->jobcard_meters_to_qty($jobcard_no,$pending_meters);

                        $data_wip_insert=array(
                          'wip_date'=>date('Y-m-d'),                      
                          'details_id'=>$details_id,
                          'jobcard_no'=>$jobcard_no,
                          'customer'=>$customer,
                          'order_no'=>$order_no,
                          'article_no'=>$article_no,
                          'sleeve_dia'=>$sleeve_diameter,
                          'sleeve_length'=>$sleeve_length,
                          'total_microns'=>$total_microns,
                          'second_layer_mb'=>$film_mb_2,
                          'sixth_layer_mb'=>$film_mb_6,                           
                          'film_code'=>$film_code,
                           'wip_cost_per_meter'=>$this->input->post('wip_cost_per_meter'),
                          'total_ok_meters'=>$pending_meters, 
                          'ok_qty'=>$pending_ok_qty,                     
                          'created_date'=>date('Y-m-d H:i:s'),
                          'company_id'=>$this->session->userdata['logged_in']['company_id'],
                          'from_process'=>'6',
                          'user_id'=>$this->session->userdata['logged_in']['user_id']                        
                        );

                        //$result=$this->common_model->save('springtube_extrusion_wip_master',$data);

                        $data_wip_update=array(
                          'status'=>'1',
                          'release_to_order_no'=>$this->input->post('release_to_order_no_1'), 
                          'release_meters'=>$release_meters,
                          'release_qty'=>$rel_qty,
                          'release_date'=>date('Y-m-d'),
                          'release_by'=>$this->session->userdata['logged_in']['user_id'],
                          'next_process'=>'9',
                          'release_remarks'=>$this->input->post('release_remarks') 
                        );

                        //$result=$this->common_model->update_one_active_record('springtube_extrusion_wip_master',$data,'wip_id',$wip_id,$this->session->userdata['logged_in']['company_id']);

                        $trans_status=$this->springtube_extrusion_wip_model->wip_release_partially($data_wip_before_insert,$data_wip_insert,$data_wip_update,$wip_id);

                      }                    



                    }else{ 
                    
                      // FUll release to PRINTING WIP BEFORE PRINT--------------------

                       //WIP Is releasing to Same SO----------------------

                      //if(strpos($this->input->post('order_no'),"ST")==''){


                      if(substr($this->input->post('order_no'),0,2)!='ST'){
                          
                        $release_qty=$this->common_model->jobcard_meters_to_qty($jobcard_no,$release_meters);

                        $data_wip_before_insert=array(
                          'bprint_wip_date'=>date('Y-m-d'),                      
                          'details_id'=>$details_id,
                          'jobcard_no'=>$jobcard_no,
                          'customer'=>$customer,
                          'order_no'=>$this->input->post('release_to_order_no'),
                          'article_no'=>$article_no,
                          'sleeve_dia'=>$sleeve_diameter,
                          'sleeve_length'=>$sleeve_length,
                          'total_microns'=>$total_microns,
                          'second_layer_mb'=>$film_mb_2,
                          'sixth_layer_mb'=>$film_mb_6,                           
                          'film_code'=>$film_code,
                          'bwip_cost_per_meter'=>$this->input->post('wip_cost_per_meter'), 
                          'bprint_wip_meters'=>$release_meters,
                          'bprint_wip_qty'=>$release_qty,
                          'created_date'=>date('Y-m-d H:i:s'),
                          'company_id'=>$this->session->userdata['logged_in']['company_id'],
                          'from_process'=>'6',
                          'user_id'=>$this->session->userdata['logged_in']['user_id'],
                          'ref_wip_id'=>$this->input->post('wip_id')
                        );                

                        //$result=$this->common_model->save('springtube_printing_wip_master_before',$data);

                        $data_wip_update=array( 
                                    'status'=>'1',
                                    'release_to_order_no'=>$this->input->post('order_no'),
                                    'release_meters'=>$release_meters,
                                    'release_qty'=>$release_qty,
                                    'release_date'=>date('Y-m-d'),
                                    'release_by'=>$this->session->userdata['logged_in']['user_id'],
                                    'next_process'=>'9',
                                    'release_remarks'=>$this->input->post('release_remarks')
                                  );
                        //$result=$this->common_model->update_one_active_record('springtube_extrusion_wip_master',$data,'wip_id',$wip_id,$this->session->userdata['logged_in']['company_id']);

                        $trans_status=$this->springtube_extrusion_wip_model->wip_release_full($data_wip_before_insert,$data_wip_update,$wip_id);
                        
                      }else{ 

                      // FUll release do Diffrent SO
                        $rel_qty=0;
                        $ups=2;
                        $rel_qty=floor(($release_meters*1000)/($release_to_sleeve_length+2.5))*$ups;

                        $data_wip_before_insert=array(
                          'bprint_wip_date'=>date('Y-m-d'),                      
                          'details_id'=>$details_id,
                          'jobcard_no'=>'',
                          'customer'=>$release_to_customer,
                          'order_no'=>$this->input->post('release_to_order_no_1'),
                          'article_no'=>$this->input->post('release_article_no'),
                          'sleeve_dia'=>$release_to_sleeve_diameter,
                          'sleeve_length'=>$release_to_sleeve_length,
                          'total_microns'=>$release_to_total_microns,
                          'second_layer_mb'=>$release_to_film_mb_2,
                          'sixth_layer_mb'=>$release_to_film_mb_6,                           
                          'film_code'=>$release_to_film_code,
                          'bwip_cost_per_meter'=>$this->input->post('wip_cost_per_meter'),
                          'bprint_wip_meters'=>$release_meters,
                          'bprint_wip_qty'=>$rel_qty,                      
                          'created_date'=>date('Y-m-d H:i:s'),
                          'company_id'=>$this->session->userdata['logged_in']['company_id'],
                          'from_process'=>'6',
                          'user_id'=>$this->session->userdata['logged_in']['user_id'],
                          'ref_wip_id'=>$this->input->post('wip_id')
                        );                

                        //$result=$this->common_model->save('springtube_printing_wip_master_before',$data);
                         
                        //$result=$this->common_model->save('springtube_extrusion_wip_master',$data);

                        $data_wip_update=array(
                          'status'=>'1',
                          'release_to_order_no'=>$this->input->post('release_to_order_no_1'), 
                          'release_meters'=>$release_meters,
                          'release_qty'=>$rel_qty,
                          'release_date'=>date('Y-m-d'),
                          'release_by'=>$this->session->userdata['logged_in']['user_id'],
                          'next_process'=>'9',
                          'release_remarks'=>$this->input->post('release_remarks') 
                        );

                        //$result=$this->common_model->update_one_active_record('springtube_extrusion_wip_master',$data,'wip_id',$wip_id,$this->session->userdata['logged_in']['company_id']);

                        $trans_status=$this->springtube_extrusion_wip_model->wip_release_full($data_wip_before_insert,$data_wip_update,$wip_id);


                      } // Else Diffrent SO                    

                    }//ELSE FULL RELEASE


                  }else{  // TO EXTRUSION WIP TO SCRAP---

                    //$pending_meters=$total_ok_meters-$release_meters;

                    //Partially release to EXTRUSION WIP Scrap 

                    if($pending_meters>0){

                      $scrap_qty=$this->common_model->jobcard_meters_to_qty($jobcard_no,$release_meters); 

                      $data_scrap_insert=array(
                        'scrap_date'=>$this->input->post('release_date'),                      
                        'details_id'=>$details_id,
                        'jobcard_no'=>$jobcard_no,
                        'customer'=>$customer,
                        'order_no'=>$order_no,
                        'article_no'=>$article_no,
                        'sleeve_dia'=>$sleeve_diameter,
                        'sleeve_length'=>$sleeve_length,
                        'total_microns'=>$total_microns,
                        'second_layer_mb'=>$film_mb_2,
                        'sixth_layer_mb'=>$film_mb_6,                           
                        'film_code'=>$film_code,
                        'scrap_cost_per_meter'=>$this->input->post('wip_cost_per_meter'),                                          
                        'total_scrap_meters'=>$release_meters,
                        'scrap_qty'=>$scrap_qty, 
                        'scrap_weight'=>$released_weight,                    
                        'created_date'=>date('Y-m-d H:i:s'),
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'from_process'=>'6',
                        'user_id'=>$this->session->userdata['logged_in']['user_id'],
                        'ref_wip_id'=>$this->input->post('wip_id')
                      );                

                      //$result=$this->common_model->save('springtube_extrusion_scrap_master',$data);

                      $pending_ok_qty=$this->common_model->jobcard_meters_to_qty($jobcard_no,$pending_meters);
                      
                      $data_wip_insert=array(
                        'wip_date'=>date('Y-m-d'),                      
                        'details_id'=>$details_id,
                        'jobcard_no'=>$jobcard_no,
                        'customer'=>$customer,
                        'order_no'=>$order_no,
                        'article_no'=>$article_no,
                        'sleeve_dia'=>$sleeve_diameter,
                        'sleeve_length'=>$sleeve_length,
                        'total_microns'=>$total_microns,
                        'second_layer_mb'=>$film_mb_2,
                        'sixth_layer_mb'=>$film_mb_6,                           
                        'film_code'=>$film_code,
                        'wip_cost_per_meter'=>$this->input->post('wip_cost_per_meter'),
                        'total_ok_meters'=>$pending_meters,
                        'ok_qty'=>$pending_ok_qty,                      
                        'created_date'=>date('Y-m-d H:i:s'),
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'from_process'=>'6',
                        'user_id'=>$this->session->userdata['logged_in']['user_id']                        
                        );

                        //$result=$this->common_model->save('springtube_extrusion_wip_master',$data_1);

                        $data_wip_update=array('status'=>'1',
                                    'release_to_order_no'=>$order_no,
                                    'release_meters'=>$release_meters,
                                    'release_qty'=>$scrap_qty,
                                    'release_date'=>$this->input->post('release_date'),
                                    'release_by'=>$this->session->userdata['logged_in']['user_id'],
                                    'next_process'=>'16',
                                    'release_remarks'=>$this->input->post('release_remarks')
                                  );

                        //$result=$this->common_model->update_one_active_record('springtube_extrusion_wip_master',$data_2,'wip_id',$wip_id,$this->session->userdata['logged_in']['company_id']);

                        $trans_status=$this->springtube_extrusion_wip_model->wip_to_scrap_partially($data_scrap_insert,$data_wip_insert,$data_wip_update,$wip_id);



                    }else{ // FUll release to SCRAP

                      $scrap_qty=$this->common_model->jobcard_meters_to_qty($jobcard_no,$release_meters);

                      $data_scrap_insert=array(
                        'scrap_date'=>$this->input->post('release_date'),                      
                        'details_id'=>$details_id,
                        'jobcard_no'=>$jobcard_no,
                        'customer'=>$customer,
                        'order_no'=>$order_no,
                        'article_no'=>$article_no,
                        'sleeve_dia'=>$sleeve_diameter,
                        'sleeve_length'=>$sleeve_length,
                        'total_microns'=>$total_microns,
                        'second_layer_mb'=>$film_mb_2,
                        'sixth_layer_mb'=>$film_mb_6,                           
                        'film_code'=>$film_code,
                        'scrap_cost_per_meter'=>$this->input->post('wip_cost_per_meter'),
                        'total_scrap_meters'=>$release_meters,
                        'scrap_qty'=>$scrap_qty,
                        'scrap_weight'=>$released_weight,                      
                        'created_date'=>date('Y-m-d H:i:s'),
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'from_process'=>'6',
                        'user_id'=>$this->session->userdata['logged_in']['user_id'],
                        'ref_wip_id'=>$this->input->post('wip_id')
                      );                

                      //$result=$this->common_model->save('springtube_extrusion_scrap_master',$data);

                      $data_wip_update=array( 'status'=>'1',
                                    'release_to_order_no'=>$order_no,
                                    'release_meters'=>$release_meters,
                                    'release_qty'=>$scrap_qty,
                                    'release_date'=>$this->input->post('release_date'),
                                    'release_by'=>$this->session->userdata['logged_in']['user_id'],
                                    'next_process'=>'16',
                                    'release_remarks'=>$this->input->post('release_remarks')
                                  );
                      //$result=$this->common_model->update_one_active_record('springtube_extrusion_wip_master',$data_1,'wip_id',$wip_id,$this->session->userdata['logged_in']['company_id']);

                      $trans_status=$this->springtube_extrusion_wip_model->wip_to_scrap_full($data_scrap_insert,$data_wip_update,$wip_id);


                    }                   


                  }///ELSE SCRAP

                  if($trans_status){
                     $data['note']='WIP Release Transaction Completed';
                  }else{
                    $data['error']='WIP Release Transaction Failed';
                  }
                 

              }                 
              else{

                  $data['error']='WIP already Released';
              }
                  
                
                  $table='springtube_extrusion_wip_master';
                  $data['springtube_extrusion_wip_master']=$this->springtube_extrusion_wip_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'wip_id',$wip_id);

                  $data['page_name']='Production';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());                 

                  header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/wip-release-form',$data);
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

  

}

