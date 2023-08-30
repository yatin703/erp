
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Springtube_rfd extends CI_Controller {

  function __construct(){    
    parent::__construct();
    if($this->session->userdata('logged_in')){
      
      $this->load->model('common_model');
      $this->load->model('article_model');
      $this->load->model('sales_order_book_model');
      $this->load->model('sales_order_status_model');
      $this->load->model('artwork_springtube_model');
      $this->load->model('springtube_bodymaking_wip_model');
      $this->load->model('springtube_rfd_model');
      
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

              $table='springtube_rfd_master';
              include('pagination.php');
              $data['springtube_rfd_master']=$this->springtube_rfd_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
             
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

              $data_search=array();

              $data['springtube_rfd_master']=$this->springtube_rfd_model->active_record_search('springtube_rfd_master',$this->session->userdata['logged_in']['company_id'],$data_search,date('Y-m-d'),date('Y-m-d')); 
              
              
             
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
            //$this->form_validation->set_rules('film_code','Film Code' ,'trim|xss_clean|callback_article_check');
            //$this->form_validation->set_rules('film_masterbatch_two','Second Layer MB' ,'trim|xss_clean');
            $this->form_validation->set_rules('customer','Customer' ,'trim|xss_clean|callback_customer_check');
            //$this->form_validation->set_rules('status','Status' ,'trim|xss_clean');
                       
            if($this->form_validation->run()==FALSE){

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              
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
                $customer_arr=explode("//",$this->input->post('article_no'));
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
              if($this->input->post('status')!=''){
                $data_search['status']=$this->input->post('status');
              }
               

              $data['springtube_rfd_master']=$this->springtube_rfd_model->active_record_search('springtube_rfd_master',$this->session->userdata['logged_in']['company_id'],$data_search,$this->input->post('from_date'),$this->input->post('to_date')); 
             //echo $this->db->last_query();            

              $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);                
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
               

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

  public function article_check($str){
    
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

  // function save_consume(){

  //   $data['page_name']='Production';
  //   $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
  //   if($data['module']!=FALSE){
  //   foreach ($data['module'] as $module_row) {
  //     if($module_row->module_name==='Production'){

  //       $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

  //       foreach ($data['formrights'] as $formrights_row) {
          
  //         if($formrights_row->new==1){

  //           if(count($this->input->post('aql_id[]'))=='0' OR empty($this->input->post('aql_id[]'))){                              
  //             $this->form_validation->set_rules('aql_id[]',"Order no", "required|trim|xss_clean");
  //             $this->form_validation->run();

  //             $data_search=array();
  //             if($this->input->post('jobcard_no')!=''){
  //               $data_search['jobcard_no']=$this->input->post('jobcard_no');
  //             }
  //             if($this->input->post('customer')!=''){
  //               $customer_arr=explode("//",$this->input->post('article_no'));
  //               $data_search['customer']=$customer_arr[1];
  //             }
  //             if($this->input->post('order_no')!=''){
  //               $data_search['order_no']=$this->input->post('order_no');
  //             }
  //             if($this->input->post('sleeve_dia')!=''){
  //               $sleeve_dia_arr=explode("//", $this->input->post('sleeve_dia'));
  //               $data_search['sleeve_dia']=$sleeve_dia_arr[0];
  //             }
  //             if($this->input->post('sleeve_length')!=''){
  //               $data_search['sleeve_length']=$this->input->post('sleeve_length');
  //             }
  //             if($this->input->post('article_no')!=''){
  //               $article_arr=explode("//",$this->input->post('article_no'));
  //               $data_search['article_no']=$article_arr[1];
  //             }
               

  //             $data['springtube_aql_rfd_master']=$this->springtube_aql_rfd_model->active_record_search('springtube_aql_rfd_master',$this->session->userdata['logged_in']['company_id'],$data_search,$this->input->post('from_date'),$this->input->post('to_date')); 
  //            //echo $this->db->last_query();            

  //             $data['page_name']='Production';
  //               $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);                
  //             $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
  //             $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
               

  //               $this->load->view('Home/header');
  //               $this->load->view('Home/nav',$data);
  //               $this->load->view('Home/subnav');
  //               $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
  //               $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
  //               $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
  //               $this->load->view('Home/footer'); 




  //           }

  //           // if($this->form_validation->run()==FALSE){

  //           //   $data_search=array();
  //           //   if($this->input->post('jobcard_no')!=''){
  //           //     $data_search['jobcard_no']=$this->input->post('jobcard_no');
  //           //   }
  //           //   if($this->input->post('customer')!=''){
  //           //     $customer_arr=explode("//",$this->input->post('article_no'));
  //           //     $data_search['customer']=$customer_arr[1];
  //           //   }
  //           //   if($this->input->post('order_no')!=''){
  //           //     $data_search['order_no']=$this->input->post('order_no');
  //           //   }
  //           //   if($this->input->post('sleeve_dia')!=''){
  //           //     $sleeve_dia_arr=explode("//", $this->input->post('sleeve_dia'));
  //           //     $data_search['sleeve_dia']=$sleeve_dia_arr[0];
  //           //   }
  //           //   if($this->input->post('sleeve_length')!=''){
  //           //     $data_search['sleeve_length']=$this->input->post('sleeve_length');
  //           //   }
  //           //   if($this->input->post('article_no')!=''){
  //           //     $article_arr=explode("//",$this->input->post('article_no'));
  //           //     $data_search['article_no']=$article_arr[1];
  //           //   }
               

  //           //   $data['springtube_aql_rfd_master']=$this->springtube_aql_rfd_model->active_record_search('springtube_aql_rfd_master',$this->session->userdata['logged_in']['company_id'],$data_search,$this->input->post('from_date'),$this->input->post('to_date')); 
  //           //  //echo $this->db->last_query();            

  //           //   $data['page_name']='Production';
  //           //     $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);                
  //           //   $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
  //           //   $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
               

  //           //     $this->load->view('Home/header');
  //           //     $this->load->view('Home/nav',$data);
  //           //     $this->load->view('Home/subnav');
  //           //     $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
  //           //     $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
  //           //     $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
  //           //     $this->load->view('Home/footer');

  //           // }
  //           else{  

  //           //echo 'true';            
              
  //             foreach ($this->input->post('aql_id[]') as $key => $aql_id) {
                
  //               //echo $aql_id;
  //               $order_no='';
  //               $released_qty=0;
  //               $springtube_aql_rfd_master_result=$this->common_model->select_one_active_record('springtube_aql_rfd_master',$this->session->userdata['logged_in']['company_id'],'aql_id',$aql_id);
                

  //               foreach ($springtube_aql_rfd_master_result as $key => $springtube_aql_rfd_master_row) {

  //                 $released_qty=$springtube_aql_rfd_master_row->rfd_qty;
  //                 $order_no=$springtube_aql_rfd_master_row->order_no;
  //               }

  //               $data_update=array('status'=>'1',
  //                           'release_date'=>date('Y-m-d'),
  //                           'release_qty'=>$released_qty,
  //                           'release_by'=>$this->session->userdata['logged_in']['user_id'],
  //                           'next_process'=>'18'
  //                         );

  //              // print_r($data_update);

  //               $result=$this->common_model->update_one_active_record('springtube_aql_rfd_master',$data_update,'aql_id',$aql_id,$this->session->userdata['logged_in']['company_id']);

  //               $data['note']=$order_no.' - RFD consumed Successfully';

  //             }          


  //             $data_search=array();
  //             if($this->input->post('jobcard_no')!=''){
  //               $data_search['jobcard_no']=$this->input->post('jobcard_no');
  //             }
  //             if($this->input->post('customer')!=''){
  //               $customer_arr=explode("//",$this->input->post('article_no'));
  //               $data_search['customer']=$customer_arr[1];
  //             }
  //             if($this->input->post('order_no')!=''){
  //               $data_search['order_no']=$this->input->post('order_no');
  //             }
  //             if($this->input->post('sleeve_dia')!=''){
  //               $sleeve_dia_arr=explode("//", $this->input->post('sleeve_dia'));
  //               $data_search['sleeve_dia']=$sleeve_dia_arr[0];
  //             }
  //             if($this->input->post('sleeve_length')!=''){
  //               $data_search['sleeve_length']=$this->input->post('sleeve_length');
  //             }
  //             if($this->input->post('article_no')!=''){
  //               $article_arr=explode("//",$this->input->post('article_no'));
  //               $data_search['article_no']=$article_arr[1];
  //             }
               

  //             $data['springtube_aql_rfd_master']=$this->springtube_aql_rfd_model->active_record_search('springtube_aql_rfd_master',$this->session->userdata['logged_in']['company_id'],$data_search,$this->input->post('from_date'),$this->input->post('to_date')); 
  //            //echo $this->db->last_query();            

  //             $data['page_name']='Production';
  //               $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);                
  //             $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
  //             $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
               

  //               $this->load->view('Home/header');
  //               $this->load->view('Home/nav',$data);
  //               $this->load->view('Home/subnav');
  //               $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
  //               $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
  //               $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
  //               $this->load->view('Home/footer');                             
  //           }

  //         }else{
  //           $data['note']='No New rights Thanks';
  //           $this->load->view('Home/header');
  //           $this->load->view('Home/nav',$data);
  //           $this->load->view('Home/subnav');
  //           $this->load->view('Error/error-title',$data);
  //           $this->load->view('Home/footer');
  //         }
  //       }
  //     }
  //   }
  // }
  // else{
  //     $data['note']='No New rights Thanks';
  //     $data['page_name']='home';
  //     $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
  //     $this->load->view('Home/header');
  //     $this->load->view('Home/nav',$data);
  //     $this->load->view('Home/subnav');
  //     $this->load->view('Error/error-title',$data);
  //     $this->load->view('Home/footer');
  //   }
  // }

  function rfd_consume(){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {

      if($module_row->module_name==='Production'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $data=array(              
              'order_no'=>$this->uri->segment(3)              
            );

            $data['order']=$this->sales_order_book_model->active_details_records('order_master',$data,$this->session->userdata['logged_in']['company_id']);
            //echo $this->db->last_query();

            $dataa=array('order_no'=>$this->uri->segment(3),
              'article_no'=>$this->uri->segment(4));

            $data['order_details']=$this->common_model->select_one_active_record_nonlanguage_without_archives('order_details',$this->session->userdata['logged_in']['company_id'],$dataa);

            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','75');

            //-------------------------------------------------------

            $data_rfd_search=array('order_no'=>$this->uri->segment(3),
              'article_no'=>$this->uri->segment(4),
              'status'=>'0',
              'archive'=>'0'
            );

            $data['springtube_rfd_master']=$this->common_model->select_active_records_where('springtube_rfd_master',$this->session->userdata['logged_in']['company_id'],$data_rfd_search);

            //-------------------------------------------------------


            $data['page_name']='Production';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
            $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
              
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/rfd-consume-form',$data);
              $this->load->view('Home/footer');
          }else{
              $data['note']='No Create rights Thanks';
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
      $data['note']='No Create rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  
  }

  function save_rfd_consume(){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    
    if($data['module']!=FALSE){

      foreach ($data['module'] as $module_row) {

        if($module_row->module_name==='Production'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            
            if($formrights_row->new==1){

              $this->form_validation->set_rules('order_no','Order No' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('article_no','Product Code' ,'required|trim|xss_clean');            
              $this->form_validation->set_rules('total_rfd_qty','Total RFD Qty ' ,'required|trim|xss_clean|greater_than[0]');
              $this->form_validation->set_rules('release_qty','Invoice Qty' ,'required|trim|xss_clean|greater_than[0]|less_than_equal_to['.$this->input->post('total_rfd_qty').']');            
              $this->form_validation->set_rules('pending_rfd_qty','Pending RFD Qty' ,'required|trim|xss_clean');

              if($this->form_validation->run()===FALSE){

                $data=array(              
                'order_no'=>$this->uri->segment(3)              
                );

                $data['order']=$this->sales_order_book_model->active_details_records('order_master',$data,$this->session->userdata['logged_in']['company_id']);
                //echo $this->db->last_query();

                $dataa=array('order_no'=>$this->uri->segment(3),
                'article_no'=>$this->uri->segment(4)
                );

                $data['order_details']=$this->common_model->select_one_active_record_nonlanguage_without_archives('order_details',$this->session->userdata['logged_in']['company_id'],$dataa);

                $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','75');

                //-------------------------------------------------------

                $data_rfd_search=array('order_no'=>$this->uri->segment(3),
                'article_no'=>$this->uri->segment(4),
                'status'=>'0',
                'archive'=>'0'
                );

                $data['springtube_rfd_master']=$this->common_model->select_active_records_where('springtube_rfd_master',$this->session->userdata['logged_in']['company_id'],$data_rfd_search);

                //-------------------------------------------------------

                $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
              
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/rfd-consume-form',$data);
                $this->load->view('Home/footer'); 
                
              }else{

                $order_no= $this->input->post('order_no');
                $article_no=$this->input->post('article_no');
                $total_rfd_qty=$this->input->post('total_rfd_qty');              
                $release_qty=$this->input->post('release_qty'); 
                $pending_rfd_qty=0;
                //$pending_rfd_qty=$this->input->post('total_rfd_qty')-$this->input->post('release_qty');
                
                 
                //-------------------------------------------------------
                $data_rfd_search=array('order_no'=>$this->input->post('order_no'),
                'article_no'=>$this->input->post('article_no'),
                'status'=>'0',
                'archive'=>'0'
                );

                $data['springtube_rfd_master']=$this->common_model->select_active_records_where('springtube_rfd_master',$this->session->userdata['logged_in']['company_id'],$data_rfd_search);

                //print_r($data['springtube_rfd_master']);

              //-------------------------------------------------------

                //$pending_rfd_qty=0;
                foreach ($data['springtube_rfd_master'] as  $springtube_rfd_master_row) {
                                          
                  if($release_qty>0 && $release_qty<=$springtube_rfd_master_row->rfd_qty){
                      
                    $data_rfd_update=array(
                      'status'=>'1',
                      'release_date'=>date('Y-m-d'),
                      'release_qty'=>$release_qty,
                      'release_by'=>$this->session->userdata['logged_in']['user_id'],
                      'next_process'=>'18'
                    );

                    $result=$this->common_model->update_one_active_record('springtube_rfd_master',$data_rfd_update,'rfd_id',$springtube_rfd_master_row->rfd_id,$this->session->userdata['logged_in']['company_id']);
                   
                    $pending_rfd_qty=$springtube_rfd_master_row->rfd_qty-$release_qty;

                    if($pending_rfd_qty>0){

                      $data_pending_rfd= array(
                       'rfd_date'=>date('Y-m-d'),
                       'jobcard_no'=>$springtube_rfd_master_row->jobcard_no,
                        'customer'=>$springtube_rfd_master_row->customer,
                        'order_no'=>$springtube_rfd_master_row->order_no,
                        'article_no'=>$springtube_rfd_master_row->article_no,
                        'sleeve_dia'=>$springtube_rfd_master_row->sleeve_dia,
                        'sleeve_length'=>$springtube_rfd_master_row->sleeve_length,
                        'total_microns'=>$springtube_rfd_master_row->total_microns,
                        'second_layer_mb'=>$springtube_rfd_master_row->second_layer_mb,
                        'sixth_layer_mb'=>$springtube_rfd_master_row->sixth_layer_mb,
                        'film_code'=>$springtube_rfd_master_row->film_code,
                        'created_date'=>date('Y-m-d H:i:s'),
                        'rfd_qty'=>$pending_rfd_qty,
                        'user_id'=>$this->session->userdata['logged_in']['user_id'],
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'from_process'=>'18'
                        );

                        $rfd_id=$this->common_model->save_return_pkey('springtube_rfd_master',$data_pending_rfd);

                    }

                    $release_qty=$release_qty-$springtube_rfd_master_row->rfd_qty;


                  }else if($release_qty>0 && $release_qty>$springtube_rfd_master_row->rfd_qty){
                      
                    $data_rfd_update=array(
                      'status'=>'1',
                      'release_date'=>date('Y-m-d'),
                      'release_qty'=>$springtube_rfd_master_row->rfd_qty,
                      'release_by'=>$this->session->userdata['logged_in']['user_id'],
                      'next_process'=>'18'
                    );

                    $result=$this->common_model->update_one_active_record('springtube_rfd_master',$data_rfd_update,'rfd_id',$springtube_rfd_master_row->rfd_id,$this->session->userdata['logged_in']['company_id']);
                    
                    $pending_rfd_qty=$springtube_rfd_master_row->rfd_qty-$release_qty;

                    if($pending_rfd_qty>0){

                      $data_pending_rfd= array(
                        'rfd_date'=>date('Y-m-d'),
                        'jobcard_no'=>$springtube_rfd_master_row->jobcard_no,
                        'customer'=>$springtube_rfd_master_row->customer,
                        'order_no'=>$springtube_rfd_master_row->order_no,
                        'article_no'=>$springtube_rfd_master_row->article_no,
                        'sleeve_dia'=>$springtube_rfd_master_row->sleeve_dia,
                        'sleeve_length'=>$springtube_rfd_master_row->sleeve_length,
                        'total_microns'=>$springtube_rfd_master_row->total_microns,
                        'second_layer_mb'=>$springtube_rfd_master_row->second_layer_mb,
                        'sixth_layer_mb'=>$springtube_rfd_master_row->sixth_layer_mb,
                        'film_code'=>$springtube_rfd_master_row->film_code,
                        'created_date'=>date('Y-m-d H:i:s'),
                        'rfd_qty'=>$pending_rfd_qty,
                        'user_id'=>$this->session->userdata['logged_in']['user_id'],
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'from_process'=>'18'
                        );

                        $rfd_id=$this->common_model->save_return_pkey('springtube_rfd_master',$data_pending_rfd);
                    }

                    $release_qty=$release_qty-$springtube_rfd_master_row->rfd_qty;


                  }//Else if

                  

                } // Foreach

                
                 
                
                $data=array(              
                'order_no'=>$this->input->post('order_no')
                );

                $data['order']=$this->sales_order_book_model->active_details_records('order_master',$data,$this->session->userdata['logged_in']['company_id']);
                //echo $this->db->last_query();

                $dataa=array('order_no'=>$this->input->post('order_no'),
                'article_no'=>$this->input->post('article_no')
              );

                $data['order_details']=$this->common_model->select_one_active_record_nonlanguage_without_archives('order_details',$this->session->userdata['logged_in']['company_id'],$dataa);

                $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','75');

                //-------------------------------------------------------

                $data_rfd_search=array('order_no'=>$this->input->post('order_no'),
                'article_no'=>$this->input->post('article_no'),
                'status'=>'0',
                'archive'=>'0'
                );

                $data['springtube_rfd_master']=$this->common_model->select_active_records_where('springtube_rfd_master',$this->session->userdata['logged_in']['company_id'],$data_rfd_search);

                
                //-------------------------------------------------------

                if($result){
                  $data['note']='RFD Consumed Succesfully!';
                }else{
                  $data['error']='Error while consuming RFD';
                }

                header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class()."");
                
                  $data['page_name']='Production';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

                    $this->load->view('Home/header');
                    $this->load->view('Home/nav',$data);
                    $this->load->view('Home/subnav');
                    //$this->load->view('Loading/loading');
                    $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                    $this->load->view(ucwords($this->router->fetch_class()).'/rfd-consume-form',$data);
                    $this->load->view('Home/footer');



              }// Form validation else
              
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

