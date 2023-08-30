
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trackmyorder extends CI_Controller {

  function __construct(){    
    parent::__construct();
    if($this->session->userdata('logged_in')){
      
      $this->load->model('common_model');
      $this->load->model('article_model');
      $this->load->model('sales_order_book_model');
      $this->load->model('sales_order_status_model');
      $this->load->model('artwork_springtube_model');
      $this->load->model('springtube_printing_production_model');
      $this->load->model('springtube_printing_inspection_model');
      $this->load->model('springtube_printing_wip_after_print_model');       
      $this->load->model('springtube_bodymaking_production_model');
      $this->load->model('springtube_bodymaking_wip_model');      
      $this->load->model('springtube_aql_rfd_model');
      $this->load->model('springtube_rfd_model');
      $this->load->model('trackmyorder_model');

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

              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

              $data_search=array();
              $data['springtube_printing_production_master']=$this->trackmyorder_model->active_record_search('springtube_printing_production_master',$this->session->userdata['logged_in']['company_id'],$customer_category="",$data_search,date('Y-m-01'),date('Y-m-d')); 
              //echo $this->db->last_query();            
             
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-result',$data);
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


              $data['customer_category']=$this->common_model->select_active_drop_down('address_category_master',$this->session->userdata['logged_in']['company_id']);

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              
              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
              //$this->load->view(ucwords($this->router->fetch_class()).'/search-result',$data);
              $this->load->view('Home/footer');
            }else{              
              
              
              $data_search=array();
              // if($this->input->post('jobcard_no')!=''){
              //   $data_search['jobcard_no']=$this->input->post('jobcard_no');
              // }


              if(!empty($this->input->post('customer_category'))){
                    $customer_category_arr=explode('//',$this->input->post('customer_category'));
                    $customer_category=$customer_category_arr[1];
                  }else{

                  $customer_category="";
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
              // if($this->input->post('status')!=''){
              //   $data_search['status']=$this->input->post('status');
              // }
              $from_date='';
              if(!empty($this->input->post('from_date'))){
                $from_date=$this->input->post('from_date');
              }
              $to_date='';
              if(!empty($this->input->post('to_date'))){
                $to_date=$this->input->post('to_date');
              }

              if($from_date=='' && $to_date==''){
                $from_date=date('Y-m-d');
                $to_date=date('Y-m-d');

              }

              //echo $from_date;
              //echo $to_date;
               

              $data['springtube_printing_production_master']=$this->trackmyorder_model->active_record_search('springtube_printing_production_master',$this->session->userdata['logged_in']['company_id'],$customer_category,$data_search,$from_date,$to_date); 
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
                $this->load->view(ucwords($this->router->fetch_class()).'/search-result',$data);
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

   
      
}

