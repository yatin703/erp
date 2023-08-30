<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_quote_customer extends CI_Controller {

  function __construct(){    
    parent::__construct();
    if($this->session->userdata('logged_in')){
      
      $this->load->model('common_model');
      $this->load->model('fiscal_model');
      $this->load->model('article_model');
      $this->load->model('sales_quote_customer_model');
      $this->load->model('customer_model');
      $this->load->model('country_model');
      $this->load->model('state_model');

 
      
    }else{
      redirect('login','refresh');
    }
  }

  function index(){
    
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){

              $table='address_category_details';
              include('pagination.php');
              $data['sales_quote_customer_master']=$this->sales_quote_customer_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
             //echo $this->db->last_query();
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
  
  function create(){    
    
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->new==1){
              
              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

              $data['country']=$this->country_model->select_active_drop_down('country_master');
              $data['state']=$this->state_model->select_active_drop_down('zip_code_master',$this->session->userdata['logged_in']['language_id']);
              $data['employee_master']=$this->common_model->select_one_active_record('employee_master',$this->session->userdata['logged_in']['company_id'],'department_id','3');

              $data['sales_quotes_ownership_type_master']=$this->common_model->select_active_drop_down('sales_quotes_ownership_type_master',$this->session->userdata['logged_in']['company_id']);

              $data['sales_quotes_company_type_master']=$this->common_model->select_active_drop_down('sales_quotes_company_type_master',$this->session->userdata['logged_in']['company_id']);
              $data['sales_quotes_designation_master']=$this->common_model->select_active_drop_down('sales_quotes_designation_master',$this->session->userdata['logged_in']['company_id']);

              $data['sales_quotes_product_types_master']=$this->common_model->select_active_drop_down('sales_quotes_product_types_master',$this->session->userdata['logged_in']['company_id']);

              $data['sales_quotes_product_category_master']=$this->common_model->select_active_drop_down('sales_quotes_product_category_master',$this->session->userdata['logged_in']['company_id']);

              $data['sales_quotes_packaging_master']=$this->common_model->select_active_drop_down('sales_quotes_packaging_master',$this->session->userdata['logged_in']['company_id']);

              $data['sales_quotes_printing_technology_master']=$this->common_model->select_active_drop_down('sales_quotes_printing_technology_master',$this->session->userdata['logged_in']['company_id']);

              $data['sales_quotes_supplier_master']=$this->common_model->select_active_drop_down('sales_quotes_supplier_master',$this->session->userdata['logged_in']['company_id']);
              
               $data['customer_category']=$this->common_model->select_active_drop_down('address_category_master',$this->session->userdata['logged_in']['company_id']);
            
             
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view('Loading/loading');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
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


  function existing(){    
    
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->new==1){
              
              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

              $data['country']=$this->country_model->select_active_drop_down('country_master');
              $data['state']=$this->state_model->select_active_drop_down('zip_code_master',$this->session->userdata['logged_in']['language_id']);
              $data['employee_master']=$this->common_model->select_one_active_record('employee_master',$this->session->userdata['logged_in']['company_id'],'department_id','3');

              $data['sales_quotes_ownership_type_master']=$this->common_model->select_active_drop_down('sales_quotes_ownership_type_master',$this->session->userdata['logged_in']['company_id']);

              $data['sales_quotes_company_type_master']=$this->common_model->select_active_drop_down('sales_quotes_company_type_master',$this->session->userdata['logged_in']['company_id']);
              $data['sales_quotes_designation_master']=$this->common_model->select_active_drop_down('sales_quotes_designation_master',$this->session->userdata['logged_in']['company_id']);

              $data['sales_quotes_product_types_master']=$this->common_model->select_active_drop_down('sales_quotes_product_types_master',$this->session->userdata['logged_in']['company_id']);

              $data['sales_quotes_product_category_master']=$this->common_model->select_active_drop_down('sales_quotes_product_category_master',$this->session->userdata['logged_in']['company_id']);

              $data['sales_quotes_packaging_master']=$this->common_model->select_active_drop_down('sales_quotes_packaging_master',$this->session->userdata['logged_in']['company_id']);

              $data['sales_quotes_printing_technology_master']=$this->common_model->select_active_drop_down('sales_quotes_printing_technology_master',$this->session->userdata['logged_in']['company_id']);

              $data['sales_quotes_supplier_master']=$this->common_model->select_active_drop_down('sales_quotes_supplier_master',$this->session->userdata['logged_in']['company_id']);
              
               $data['customer_category']=$this->common_model->select_active_drop_down('address_category_master',$this->session->userdata['logged_in']['company_id']);
            
             
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view('Loading/loading');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-existing',$data);
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


  function add_contact(){    
    
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->new==1){
              
              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
              $data['customer_master']=$this->sales_quote_customer_model->select_one_active_record('address_category_details',$this->session->userdata['logged_in']['company_id'],'address_category_details_id',$this->uri->segment(3));
              $data['sales_quotes_designation_master']=$this->common_model->select_active_drop_down('sales_quotes_designation_master',$this->session->userdata['logged_in']['company_id']);
              $data['employee_master']=$this->common_model->select_one_active_record('employee_master',$this->session->userdata['logged_in']['company_id'],'department_id','3');


             
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view('Loading/loading');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form-contact',$data);
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


  function save_contact(){    
    
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->new==1){

              if(is_array($this->input->post('sr_no[]'))){ 
                $i=0;
                $j=1; 
                foreach ($this->input->post('sr_no[]') as $key => $value) {          
                  $this->form_validation->set_rules('contact_name['.$i.']','Contact Name ' .$j ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('rank['.$i.']','Rank '.$j ,'trim|xss_clean');
                  $this->form_validation->set_rules('position['.$i.']','Position '.$j ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('company_contact_no['.$i.']','Company Contact No. '.$j ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('personal_contact_no['.$i.']','Personal Contact No. '.$j ,'trim|xss_clean');

                  $this->form_validation->set_rules('company_email['.$i.']','Company email '.$j ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('personal_email['.$i.']','Personal email '.$j ,'trim|xss_clean');
                  $this->form_validation->set_rules('located_at['.$i.']','Located at '.$j ,'trim|xss_clean');
                  $this->form_validation->set_rules('birth_date['.$i.']','Birth date '.$j ,'trim|xss_clean');
                  $this->form_validation->set_rules('previous_job['.$i.']','Previous job '.$j ,'trim|xss_clean');
                  $this->form_validation->set_rules('previous_position['.$i.']','Previous position '.$j ,'trim|xss_clean');
                  $this->form_validation->set_rules('history_if_any['.$i.']','History if any '.$j ,'trim|xss_clean');
                  $this->form_validation->set_rules('repesentative_3d['.$i.']','3D Repesentative '.$j ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('active['.$i.']','Status '.$j ,'required|trim|xss_clean');            
                

                  $i++;
                  $j++;
                }
              }

              if($this->form_validation->run()==FALSE){
                  $data['page_name']='Sales';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
                  $data['customer_master']=$this->sales_quote_customer_model->select_one_active_record('address_category_details',$this->session->userdata['logged_in']['company_id'],'address_category_details_id',$this->input->post('address_category_details_id'));
                  $data['sales_quotes_designation_master']=$this->common_model->select_active_drop_down('sales_quotes_designation_master',$this->session->userdata['logged_in']['company_id']);
                  $data['employee_master']=$this->common_model->select_one_active_record('employee_master',$this->session->userdata['logged_in']['company_id'],'department_id','3');
                 
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view('Loading/loading');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                  $this->load->view(ucwords($this->router->fetch_class()).'/create-form-contact',$data);
                  $this->load->view('Home/footer');
              }else{

                  $arr1=$this->input->post('sr_no[]');
                      //print_r($arr1);
                  if(is_array($arr1)){
                    $j=1;
                    for($i=0;$i<count($arr1);$i++){
                      $report_to="";
                      if(!empty($this->input->post('report_to['.$i.']'))){
                        $report_to_arr=explode('//',$this->input->post('report_to['.$i.']'));
                        $report_to=$report_to_arr[1];
                      }else{
                        $report_to="";
                      }
                              
                      $data_contact=array(
                              'address_category_details_id'=>$this->input->post('address_category_details_id'),
                              'adr_category_id'=>$this->input->post('adr_category_id'),                
                              'seq_no'=>$j,
                              'rank'=>$this->input->post('rank['.$i.']'),
                              'contact_name'=>strtoupper($this->input->post('contact_name['.$i.']')),
                              'position'=>$this->input->post('position['.$i.']'),
                              'report_to'=>$report_to,
                              'company_contact_no'=>$this->input->post('company_contact_no['.$i.']'),
                              'personal_contact_no'=>$this->input->post('personal_contact_no['.$i.']'),
                              'company_email'=>$this->input->post('company_email['.$i.']'),
                              'personal_email'=>$this->input->post('personal_email['.$i.']'),
                              'video_link'=>$this->input->post('video_link['.$i.']'),
                              'linked_in_link'=>$this->input->post('linked_in_link['.$i.']'),
                              'located_at'=>strtoupper($this->input->post('located_at['.$i.']')),
                              'birth_date'=>$this->input->post('birth_date['.$i.']'),
                              'anniversary_date'=>$this->input->post('anniversary_date['.$i.']'),
                              'hobbies'=>$this->input->post('hobbies['.$i.']'),
                              'previous_job'=>strtoupper($this->input->post('previous_job['.$i.']')),
                              'previous_position'=>$this->input->post('previous_position['.$i.']'),
                              'previous_from_date'=>$this->input->post('previous_from_date['.$i.']'),
                              'previous_to_date'=>$this->input->post('previous_to_date['.$i.']'),
                              'history_if_any'=>strtoupper($this->input->post('history_if_any['.$i.']')),
                              'repesentative_3d'=>$this->input->post('repesentative_3d['.$i.']'),
                              'active'=>$this->input->post('active['.$i.']'),
                              'company_id'=>$this->session->userdata['logged_in']['company_id']
                                         
                              );
                            
                        $result=$this->common_model->save('address_category_contact_details',$data_contact);
                        $j++; 

                    }
                  }//If Details

                  

                  $data['page_name']='Sales';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                  if($result){
                    $data['note']='Create Transaction Completed';
                    header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                  }



                  $data['customer_master']=$this->sales_quote_customer_model->select_one_active_record('address_category_details',$this->session->userdata['logged_in']['company_id'],'address_category_details_id',$this->input->post('address_category_details_id'));
                  //echo $this->db->last_query();
                  $data['sales_quotes_designation_master']=$this->common_model->select_active_drop_down('sales_quotes_designation_master',$this->session->userdata['logged_in']['company_id']);
                  $data['employee_master']=$this->common_model->select_one_active_record('employee_master',$this->session->userdata['logged_in']['company_id'],'department_id','3');


                 
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view('Loading/loading');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                  $this->load->view(ucwords($this->router->fetch_class()).'/create-form-contact',$data);
                  $this->load->view('Home/footer');


              }

            }
          }
        }
      }
    }
  }


  function update_contact(){    
    
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){
        
                  $this->form_validation->set_rules('contact_name','Contact Name' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('rank','Rank','trim|xss_clean');
                  $this->form_validation->set_rules('position','Position','required|trim|xss_clean');
                  $this->form_validation->set_rules('report_to','Report To','trim|xss_clean|callback_primary_contact_check');
                  $this->form_validation->set_rules('company_contact_no','Company Contact No','required|trim|xss_clean');
                  $this->form_validation->set_rules('personal_contact_no','Personal Contact No' ,'trim|xss_clean');

                  $this->form_validation->set_rules('company_email','Company email' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('personal_email','Personal email' ,'trim|xss_clean');
                  $this->form_validation->set_rules('located_at','Located at','trim|xss_clean');
                  $this->form_validation->set_rules('birth_date','Birth date' ,'trim|xss_clean');
                  $this->form_validation->set_rules('previous_job','Previous job' ,'trim|xss_clean');
                  $this->form_validation->set_rules('previous_position','Previous position' ,'trim|xss_clean');
                  $this->form_validation->set_rules('history_if_any','History if any' ,'trim|xss_clean');
                  $this->form_validation->set_rules('repesentative_3d','3D Repesentative' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('active','Status' ,'required|trim|xss_clean');            
 


              if($this->form_validation->run()==FALSE){
                  $data['page_name']='Sales';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
                  
                  $data['customer_master']=$this->sales_quote_customer_model->select_one_active_record('address_category_details',$this->session->userdata['logged_in']['company_id'],'address_category_details_id',$this->input->post('address_category_details_id'));
                  
                  $data['sales_quotes_designation_master']=$this->common_model->select_active_drop_down('sales_quotes_designation_master',$this->session->userdata['logged_in']['company_id']);
                  $data['employee_master']=$this->common_model->select_one_active_record('employee_master',$this->session->userdata['logged_in']['company_id'],'department_id','3');


                  $search= array(
                  'address_category_contact_id'=>$this->input->post('address_category_contact_id'),
                  'archive'=>0
                  );

                  $data['sales_quote_customer_contact_details_result']=$this->common_model->select_active_records_where('address_category_contact_details',$this->session->userdata['logged_in']['company_id'],$search);
              

                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view('Loading/loading');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                  $this->load->view(ucwords($this->router->fetch_class()).'/modify-form-contact',$data);
                  
                  $this->load->view('Home/footer');
              }else{

                      $report_to="";
                      if(!empty($this->input->post('report_to'))){
                        $report_to_arr=explode('//',$this->input->post('report_to'));
                        $report_to=$report_to_arr[1];
                      }else{
                        $report_to="";
                      }
                              
                      $data_contact=array(
                              'rank'=>$this->input->post('rank'),
                              'contact_name'=>strtoupper($this->input->post('contact_name')),
                              'position'=>$this->input->post('position'),
                              'report_to'=>$report_to,
                              'company_contact_no'=>$this->input->post('company_contact_no'),
                              'personal_contact_no'=>$this->input->post('personal_contact_no'),
                              'company_email'=>$this->input->post('company_email'),
                              'personal_email'=>$this->input->post('personal_email'),
                              'video_link'=>$this->input->post('video_link'),
                              'linked_in_link'=>$this->input->post('linked_in_link'),
                              'located_at'=>strtoupper($this->input->post('located_at')),
                              'birth_date'=>$this->input->post('birth_date'),
                              'anniversary_date'=>$this->input->post('anniversary_date'),
                              'hobbies'=>$this->input->post('hobbies'),
                              'previous_job'=>strtoupper($this->input->post('previous_job')),
                              'previous_position'=>$this->input->post('previous_position'),
                              'previous_from_date'=>$this->input->post('previous_from_date'),
                              'previous_to_date'=>$this->input->post('previous_to_date'),
                              'history_if_any'=>strtoupper($this->input->post('history_if_any')),
                              'repesentative_3d'=>$this->input->post('repesentative_3d'),
                              'active'=>$this->input->post('active'),
                              'company_id'=>$this->session->userdata['logged_in']['company_id']
                                         
                              );
                            
                        $result=$this->common_model->update_one_active_record('address_category_contact_details',$data_contact,'address_category_contact_id',$this->input->post('address_category_contact_id'),$this->session->userdata['logged_in']['company_id']);
                                        

                  $data['page_name']='Sales';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                  if($result){
                    $data['note']='Update Transaction Completed';
                    //header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                  }


                  $data['customer_master']=$this->sales_quote_customer_model->select_one_active_record('address_category_details',$this->session->userdata['logged_in']['company_id'],'address_category_details_id',$this->input->post('address_category_details_id'));
                  
                  $data['sales_quotes_designation_master']=$this->common_model->select_active_drop_down('sales_quotes_designation_master',$this->session->userdata['logged_in']['company_id']);
                  $data['employee_master']=$this->common_model->select_one_active_record('employee_master',$this->session->userdata['logged_in']['company_id'],'department_id','3');


                  $search= array(
                  'address_category_contact_id'=>$this->input->post('address_category_contact_id'),
                  'archive'=>0
                  );

                  $data['sales_quote_customer_contact_details_result']=$this->common_model->select_active_records_where('address_category_contact_details',$this->session->userdata['logged_in']['company_id'],$search);
              


                 
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view('Loading/loading');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                  $this->load->view(ucwords($this->router->fetch_class()).'/modify-form-contact',$data);
                  $this->load->view('Home/footer');


              }

            }
          }
        }
      }
    }
  }

  function save_existing(){    
    
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->new==1){


                //already exist

                //echo $this->input->post('new');
              $this->form_validation->set_rules('customer_category','Customer','required|trim|xss_clean|callback_customer_check'); 

              $this->form_validation->set_rules('adr_company_id','Bill To' ,'required|trim|xss_clean|callback_c_check');


              
              $this->form_validation->set_rules('company_type','Company Type','required|trim|xss_clean');
              //$this->form_validation->set_rules('primary_contact','Primary Contact','trim|xss_clean|callback_primary_contact_check');
             // $this->form_validation->set_rules('secondary_contact','Secondary Contact','trim|xss_clean|callback_primary_contact_check');
              //--Contact Details-----------------------------

              /*if(is_array($this->input->post('sr_no[]'))){ 
                $i=0;
                $j=1; 
                foreach ($this->input->post('sr_no[]') as $key => $value) {          
                  $this->form_validation->set_rules('contact_name['.$i.']','Contact Name ' .$j ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('position['.$i.']','Position '.$j ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('company_contact_no['.$i.']','Company Contact No. '.$j ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('personal_contact_no['.$i.']','Personal Contact No. '.$j ,'required|trim|xss_clean');

                  $this->form_validation->set_rules('company_email['.$i.']','Company email '.$j ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('personal_email['.$i.']','Personal email '.$j ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('located_at['.$i.']','Located at '.$j ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('birth_date['.$i.']','Birth date '.$j ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('previous_job['.$i.']','Previous job '.$j ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('previous_position['.$i.']','Previous position '.$j ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('history_if_any['.$i.']','History if any '.$j ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('repesentative_3d['.$i.']','3D Repesentative '.$j ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('active['.$i.']','Status '.$j ,'required|trim|xss_clean');            
 

                  $i++;
                  $j++;
                }
              }*/

              
              // Product Info-------------------------------
              $this->form_validation->set_rules('product_category[]','Product Category','trim|xss_clean|required');

              $this->form_validation->set_rules('packaging_type[]','Packing Type','trim|xss_clean|required');

              $this->form_validation->set_rules('product_type[]','Product Type','trim|xss_clean|required');

              $this->form_validation->set_rules('printing_technology[]','Printing Technology','trim|xss_clean|required');

              $this->form_validation->set_rules('current_supplier[]','Current supplier','trim|xss_clean|required');

              $this->form_validation->set_rules('product_price_range_min','Product price range min','trim|xss_clean|required');

              $this->form_validation->set_rules('product_price_range_max','Product price range max','trim|xss_clean|required');

              $this->form_validation->set_rules('product_price_range_intubes_min','Tube price range min','trim|xss_clean|required');

              $this->form_validation->set_rules('product_price_range_intubes_max','Tube price range max','trim|xss_clean|required');
              

              //Buying Potential -----------------------------

              if(is_array($this->input->post('buying_potential_sr_no[]'))){ 
                $i=0;
                $j=1; 
                foreach ($this->input->post('buying_potential_sr_no[]') as $key => $value) {          
                  $this->form_validation->set_rules('tubes_currently_buying['.$i.']','Tubes currently buying '.$j ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('min_volume['.$i.']','Min volume '.$j ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('max_volume['.$i.']','Max volume '.$j ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('three_d_volume['.$i.']','3D volume '.$j ,'required|trim|xss_clean');
                  $i++;
                  $j++;
                }
              }  
               

              if($this->form_validation->run()==FALSE){

                $data['page_name']='Sales';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                $data['country']=$this->country_model->select_active_drop_down('country_master');
                $data['state']=$this->state_model->select_active_drop_down('zip_code_master',$this->session->userdata['logged_in']['language_id']);
                $data['employee_master']=$this->common_model->select_one_active_record('employee_master',$this->session->userdata['logged_in']['company_id'],'department_id','3');

                $data['sales_quotes_ownership_type_master']=$this->common_model->select_active_drop_down('sales_quotes_ownership_type_master',$this->session->userdata['logged_in']['company_id']);

                $data['sales_quotes_company_type_master']=$this->common_model->select_active_drop_down('sales_quotes_company_type_master',$this->session->userdata['logged_in']['company_id']);
                $data['sales_quotes_designation_master']=$this->common_model->select_active_drop_down('sales_quotes_designation_master',$this->session->userdata['logged_in']['company_id']);

                $data['sales_quotes_product_types_master']=$this->common_model->select_active_drop_down('sales_quotes_product_types_master',$this->session->userdata['logged_in']['company_id']);

                $data['sales_quotes_product_category_master']=$this->common_model->select_active_drop_down('sales_quotes_product_category_master',$this->session->userdata['logged_in']['company_id']);

                $data['sales_quotes_packaging_master']=$this->common_model->select_active_drop_down('sales_quotes_packaging_master',$this->session->userdata['logged_in']['company_id']);

                $data['sales_quotes_printing_technology_master']=$this->common_model->select_active_drop_down('sales_quotes_printing_technology_master',$this->session->userdata['logged_in']['company_id']);

                $data['sales_quotes_supplier_master']=$this->common_model->select_active_drop_down('sales_quotes_supplier_master',$this->session->userdata['logged_in']['company_id']);
                
                $data['customer_category']=$this->common_model->select_active_drop_down('address_category_master',$this->session->userdata['logged_in']['company_id']);
            

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                //$this->load->view('Loading/loading');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/create-existing',$data);
                $this->load->view('Home/footer');
              }else{

               // print_r($this->input->post('sr_no[]'));
                //exit();
                  //already exist
                if(!empty($this->input->post('customer_category'))){
                    $customer_category_arr=explode('//',$this->input->post('customer_category'));
                    $customer_category=$customer_category_arr[1];
                  }else{
                    $customer_category="";
                  }

                  if(!empty($this->input->post('adr_company_id'))){
                      $arr=explode('//',$this->input->post('adr_company_id'));        
                       if(!empty($arr[1])){  
                       $data=array('address_master.adr_company_id'=>$arr[1]);      
                        $this->load->model('customer_model');
                        $data['customer']=$this->customer_model->active_record_customer_bill_to_address('address_master',$data,$this->session->userdata['logged_in']['company_id']);
                        if($data['customer']==FALSE){
                          $address="";
                          $city="";
                          $state="";
                          $pin="";
                          $country="";
                          //echo "No Record Found";
                        }else{
                          foreach ($data['customer'] as $customer_row){
                            $address=$customer_row->strno." ".$customer_row->name2." ".$customer_row->street;
                            $city=$customer_row->name3;
                            $state=$customer_row->zip_code;
                            $pin=$customer_row->city_code;
                            $country=$customer_row->country_id;
                          }     
                        }
                      }
                  }

                

                if(!empty($this->input->post('primary_contact'))){
                    $primary_contact_arr=explode('//',$this->input->post('primary_contact'));
                    $primary_contact_id=$primary_contact_arr[1];
                  }else{
                    $primary_contact_id="";
                  }

                  if(!empty($this->input->post('secondary_contact'))){
                    $secondary_contact_arr=explode('//',$this->input->post('secondary_contact'));
                    $secondary_contact_id=$secondary_contact_arr[1];
                  }else{
                    $secondary_contact_id="";
                  }


                $ownership='';
                if(!empty($this->input->post('ownership[]'))){
                  $ownership=implode(",",$this->input->post('ownership[]'));
                }

                $product_type='';  
                if(!empty($this->input->post('product_type[]'))){
                  $product_type=implode(",",$this->input->post('product_type[]'));
                }
                $product_category='';  
                if(!empty($this->input->post('product_category[]'))){
                  $product_category=implode(",",$this->input->post('product_category[]'));
                }
                
                $packaging_type='';  
                if(!empty($this->input->post('packaging_type[]'))){
                  $packaging_type=implode(",",$this->input->post('packaging_type[]'));
                }                

                $printing_technology='';  
                if(!empty($this->input->post('printing_technology[]'))){
                  $printing_technology=implode(",",$this->input->post('printing_technology[]'));
                }

                $current_supplier='';  
                if(!empty($this->input->post('current_supplier[]'))){
                  $current_supplier=implode(",",$this->input->post('current_supplier[]'));
                }


                // File Upload----------------------------------  

                $image_status='';
                $image_name='';
                $path = './assets/'.$this->session->userdata['logged_in']['company_id'].'/customer_quotation/';

                if(!empty($_FILES['images']['name'][0])) {
                  $image_status=$this->upload_files($path,$_FILES['images']);
                }             
              
                $file_upload_flag=1;
                $result='';
                if($image_status===FALSE){
                  $data['error']=$this->upload->display_errors();
                  $file_upload_flag=0;
                }else{

                  if(is_array($image_status)){
                    $image_name=implode(",",$image_status);
                  }
                  $file_upload_flag=1;
                } 

                if($file_upload_flag){

                  $data=array(
                  'adr_category_id'=>$customer_category,
                  /*'customer_name'=>strtoupper($this->input->post('customer_name')),*/
                  'address'=>$address,
                  'city'=>$city,
                  'pincode'=>$pin,
                  'company_type'=>$this->input->post('company_type'),
                  'country'=>$country,
                  'state'=>$state,
                  'ownership'=>$ownership,
                  'primary_contact_id'=>$primary_contact_id,
                  'secondary_contact_id'=>$secondary_contact_id,
                  'product_type'=>$product_type,
                  'product_category'=>$product_category,
                  'packaging_type'=>$packaging_type,
                  'printing_technology'=>$printing_technology,
                  'product_price_range_min'=>$this->input->post('product_price_range_min'),
                  'product_price_range_max'=>$this->input->post('product_price_range_max'),
                  'product_price_range_intubes_min'=>$this->input->post('product_price_range_intubes_min'),
                  'product_price_range_intubes_max'=>$this->input->post('product_price_range_intubes_max'),
                  'current_supplier'=>$current_supplier,
                  'user_id'=>$this->session->userdata['logged_in']['user_id'],
                  'company_id'=>$this->session->userdata['logged_in']['company_id'],
                  'images'=>$image_name
                      
                );

                $customer_id=$this->common_model->save_return_pkey('address_category_details',$data);
                
                // Buying Potentials

                $arr2=$this->input->post('buying_potential_sr_no[]');
                    //print_r($arr1);
                if(is_array($arr2)){
                  $j=1;
                  for($i=0;$i<count($arr2);$i++){
                            
                    $data_buying=array(  
                            'address_category_details_id'=>$customer_id,              
                            'adr_category_id'=>$customer_category,
                            'seq_no'=>$j,
                            'tubes_currently_buying'=>$this->input->post('tubes_currently_buying['.$i.']'),
                            'min_volume'=>$this->input->post('min_volume['.$i.']'),
                            'max_volume'=>$this->input->post('max_volume['.$i.']'),
                            'three_d_volume'=>$this->input->post('three_d_volume['.$i.']'),
                            'company_id'=>$this->session->userdata['logged_in']['company_id']
                                       
                            );
                          
                    $result=$this->common_model->save('sales_quote_customer_buying_potential',$data_buying);
                    $j++; 

                  }
                }//If Details

            


            }//File upload if
            

                if($customer_id){
                     $data['note']='Data saved Successfully';
                }else{
                    $data['error']='Error while saving data';
                }

                header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                $data['page_name']='Sales';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                $data['country']=$this->country_model->select_active_drop_down('country_master');
                $data['state']=$this->state_model->select_active_drop_down('zip_code_master',$this->session->userdata['logged_in']['language_id']);
                $data['employee_master']=$this->common_model->select_one_active_record('employee_master',$this->session->userdata['logged_in']['company_id'],'department_id','3');

                $data['sales_quotes_company_type_master']=$this->common_model->select_active_drop_down('sales_quotes_company_type_master',$this->session->userdata['logged_in']['company_id']);
                $data['sales_quotes_designation_master']=$this->common_model->select_active_drop_down('sales_quotes_designation_master',$this->session->userdata['logged_in']['company_id']);

                $data['sales_quotes_product_types_master']=$this->common_model->select_active_drop_down('sales_quotes_product_types_master',$this->session->userdata['logged_in']['company_id']);

                $data['sales_quotes_product_category_master']=$this->common_model->select_active_drop_down('sales_quotes_product_category_master',$this->session->userdata['logged_in']['company_id']);

                $data['sales_quotes_packaging_master']=$this->common_model->select_active_drop_down('sales_quotes_packaging_master',$this->session->userdata['logged_in']['company_id']);

                $data['sales_quotes_printing_technology_master']=$this->common_model->select_active_drop_down('sales_quotes_printing_technology_master',$this->session->userdata['logged_in']['company_id']);

                $data['sales_quotes_supplier_master']=$this->common_model->select_active_drop_down('sales_quotes_supplier_master',$this->session->userdata['logged_in']['company_id']);
                $data['sales_quotes_ownership_type_master']=$this->common_model->select_active_drop_down('sales_quotes_ownership_type_master',$this->session->userdata['logged_in']['company_id']);

               $data['customer_category']=$this->common_model->select_active_drop_down('address_category_master',$this->session->userdata['logged_in']['company_id']);
            
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view('Error/error-title',$data);
                $this->load->view('Loading/loading');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/create-existing',$data);
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

  function save(){    
    
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->new==1){


              // Customer Info-----------
              $this->form_validation->set_rules('new','Customer Name','required|trim|xss_clean');

                //new customer
               $this->form_validation->set_rules('customer_category','Customer','required|trim|xss_clean|is_unique[address_category_master.category_name]'); 
               $this->form_validation->set_rules('address','Address','required|trim|xss_clean');
               $this->form_validation->set_rules('country','Country','required|trim|xss_clean');
               $this->form_validation->set_rules('state','State','required|trim|xss_clean');
               $this->form_validation->set_rules('city','City','required|trim|xss_clean');
               $this->form_validation->set_rules('pincode','Pin code','required|trim|xss_clean');

              

              
              $this->form_validation->set_rules('company_type','Company Type','required|trim|xss_clean');
              //$this->form_validation->set_rules('primary_contact','Primary Contact','trim|xss_clean|callback_primary_contact_check');
             // $this->form_validation->set_rules('secondary_contact','Secondary Contact','trim|xss_clean|callback_primary_contact_check');
              //--Contact Details-----------------------------

              /*if(is_array($this->input->post('sr_no[]'))){ 
                $i=0;
                $j=1; 
                foreach ($this->input->post('sr_no[]') as $key => $value) {          
                  $this->form_validation->set_rules('contact_name['.$i.']','Contact Name ' .$j ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('position['.$i.']','Position '.$j ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('company_contact_no['.$i.']','Company Contact No. '.$j ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('personal_contact_no['.$i.']','Personal Contact No. '.$j ,'required|trim|xss_clean');

                  $this->form_validation->set_rules('company_email['.$i.']','Company email '.$j ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('personal_email['.$i.']','Personal email '.$j ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('located_at['.$i.']','Located at '.$j ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('birth_date['.$i.']','Birth date '.$j ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('previous_job['.$i.']','Previous job '.$j ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('previous_position['.$i.']','Previous position '.$j ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('history_if_any['.$i.']','History if any '.$j ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('repesentative_3d['.$i.']','3D Repesentative '.$j ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('active['.$i.']','Status '.$j ,'required|trim|xss_clean');            
 

                  $i++;
                  $j++;
                }
              }*/

              
              // Product Info-------------------------------
              $this->form_validation->set_rules('product_category[]','Product Category','trim|xss_clean|required');

              $this->form_validation->set_rules('packaging_type[]','Packing Type','trim|xss_clean|required');

              $this->form_validation->set_rules('product_type[]','Product Type','trim|xss_clean|required');

              $this->form_validation->set_rules('printing_technology[]','Printing Technology','trim|xss_clean|required');

              $this->form_validation->set_rules('current_supplier[]','Current supplier','trim|xss_clean|required');

              $this->form_validation->set_rules('product_price_range_min','Product price range min','trim|xss_clean|required');

              $this->form_validation->set_rules('product_price_range_max','Product price range max','trim|xss_clean|required');

              $this->form_validation->set_rules('product_price_range_intubes_min','Tube price range min','trim|xss_clean|required');

              $this->form_validation->set_rules('product_price_range_intubes_max','Tube price range max','trim|xss_clean|required');
              

              //Buying Potential -----------------------------

              if(is_array($this->input->post('buying_potential_sr_no[]'))){ 
                $i=0;
                $j=1; 
                foreach ($this->input->post('buying_potential_sr_no[]') as $key => $value) {          
                  $this->form_validation->set_rules('tubes_currently_buying['.$i.']','Tubes currently buying '.$j ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('min_volume['.$i.']','Min volume '.$j ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('max_volume['.$i.']','Max volume '.$j ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('three_d_volume['.$i.']','3D volume '.$j ,'required|trim|xss_clean');
                  $i++;
                  $j++;
                }
              }  
               

              if($this->form_validation->run()==FALSE){

                $data['page_name']='Sales';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                $data['country']=$this->country_model->select_active_drop_down('country_master');
                $data['state']=$this->state_model->select_active_drop_down('zip_code_master',$this->session->userdata['logged_in']['language_id']);
                $data['employee_master']=$this->common_model->select_one_active_record('employee_master',$this->session->userdata['logged_in']['company_id'],'department_id','3');

                $data['sales_quotes_ownership_type_master']=$this->common_model->select_active_drop_down('sales_quotes_ownership_type_master',$this->session->userdata['logged_in']['company_id']);

                $data['sales_quotes_company_type_master']=$this->common_model->select_active_drop_down('sales_quotes_company_type_master',$this->session->userdata['logged_in']['company_id']);
                $data['sales_quotes_designation_master']=$this->common_model->select_active_drop_down('sales_quotes_designation_master',$this->session->userdata['logged_in']['company_id']);

                $data['sales_quotes_product_types_master']=$this->common_model->select_active_drop_down('sales_quotes_product_types_master',$this->session->userdata['logged_in']['company_id']);

                $data['sales_quotes_product_category_master']=$this->common_model->select_active_drop_down('sales_quotes_product_category_master',$this->session->userdata['logged_in']['company_id']);

                $data['sales_quotes_packaging_master']=$this->common_model->select_active_drop_down('sales_quotes_packaging_master',$this->session->userdata['logged_in']['company_id']);

                $data['sales_quotes_printing_technology_master']=$this->common_model->select_active_drop_down('sales_quotes_printing_technology_master',$this->session->userdata['logged_in']['company_id']);

                $data['sales_quotes_supplier_master']=$this->common_model->select_active_drop_down('sales_quotes_supplier_master',$this->session->userdata['logged_in']['company_id']);
                
                $data['customer_category']=$this->common_model->select_active_drop_down('address_category_master',$this->session->userdata['logged_in']['company_id']);
            

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                //$this->load->view('Loading/loading');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
                $this->load->view('Home/footer');
              }else{

               // print_r($this->input->post('sr_no[]'));
                //exit();
                /*if($this->input->post('new')==2){
                  //already exist
                if(!empty($this->input->post('customer_category'))){
                    $customer_category_arr=explode('//',$this->input->post('customer_category'));
                    $customer_category=$customer_category_arr[1];
                  }else{
                    $customer_category="";
                  }

                  if(!empty($this->input->post('adr_company_id'))){
                      $arr=explode('//',$this->input->post('adr_company_id'));        
                       if(!empty($arr[1])){  
                       $data=array('address_master.adr_company_id'=>$arr[1]);      
                        $this->load->model('customer_model');
                        $data['customer']=$this->customer_model->active_record_customer_bill_to_address('address_master',$data,$this->session->userdata['logged_in']['company_id']);
                        if($data['customer']==FALSE){
                          $address="";
                          $city="";
                          $state="";
                          $pin="";
                          $country="";
                          //echo "No Record Found";
                        }else{
                          foreach ($data['customer'] as $customer_row){
                            $address=$customer_row->strno." ".$customer_row->name2." ".$customer_row->street;
                            $city=$customer_row->name3;
                            $state=$customer_row->zip_code;
                            $pin=$customer_row->city_code;
                            $country=$customer_row->country_id;
                          }     
                        }
                      }
                  }

                }else{*/
                  $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'category_name'=>strtoupper($this->input->post('customer_category')));
                  $this->common_model->save('address_category_master',$data);
                  $customer_category = $this->db->insert_id();
               /* }*/

                if(!empty($this->input->post('primary_contact'))){
                    $primary_contact_arr=explode('//',$this->input->post('primary_contact'));
                    $primary_contact_id=$primary_contact_arr[1];
                  }else{
                    $primary_contact_id="";
                  }

                  if(!empty($this->input->post('secondary_contact'))){
                    $secondary_contact_arr=explode('//',$this->input->post('secondary_contact'));
                    $secondary_contact_id=$secondary_contact_arr[1];
                  }else{
                    $secondary_contact_id="";
                  }


                $ownership='';
                if(!empty($this->input->post('ownership[]'))){
                  $ownership=implode(",",$this->input->post('ownership[]'));
                }

                $product_type='';  
                if(!empty($this->input->post('product_type[]'))){
                  $product_type=implode(",",$this->input->post('product_type[]'));
                }
                $product_category='';  
                if(!empty($this->input->post('product_category[]'))){
                  $product_category=implode(",",$this->input->post('product_category[]'));
                }
                
                $packaging_type='';  
                if(!empty($this->input->post('packaging_type[]'))){
                  $packaging_type=implode(",",$this->input->post('packaging_type[]'));
                }                

                $printing_technology='';  
                if(!empty($this->input->post('printing_technology[]'))){
                  $printing_technology=implode(",",$this->input->post('printing_technology[]'));
                }

                $current_supplier='';  
                if(!empty($this->input->post('current_supplier[]'))){
                  $current_supplier=implode(",",$this->input->post('current_supplier[]'));
                }


                // File Upload----------------------------------  

                $image_status='';
                $image_name='';
                $path = './assets/'.$this->session->userdata['logged_in']['company_id'].'/customer_quotation/';

                if(!empty($_FILES['images']['name'][0])) {
                  $image_status=$this->upload_files($path,$_FILES['images']);
                }             
              
                $file_upload_flag=1;
                $result='';
                if($image_status===FALSE){
                  $data['error']=$this->upload->display_errors();
                  $file_upload_flag=0;
                }else{

                  if(is_array($image_status)){
                    $image_name=implode(",",$image_status);
                  }
                  $file_upload_flag=1;
                } 

                if($file_upload_flag){

                  $data=array(
                  'adr_category_id'=>$customer_category,
                  /*'customer_name'=>strtoupper($this->input->post('customer_name')),*/
                  'address'=>$this->input->post('address'),
                  'city'=>$this->input->post('city'),
                  'pincode'=>$this->input->post('pincode'),
                  'company_type'=>$this->input->post('company_type'),
                  'country'=>$this->input->post('country'),
                  'state'=>$this->input->post('state'),
                  'ownership'=>$ownership,
                  'primary_contact_id'=>$primary_contact_id,
                  'secondary_contact_id'=>$secondary_contact_id,
                  'product_type'=>$product_type,
                  'product_category'=>$product_category,
                  'packaging_type'=>$packaging_type,
                  'printing_technology'=>$printing_technology,
                  'product_price_range_min'=>$this->input->post('product_price_range_min'),
                  'product_price_range_max'=>$this->input->post('product_price_range_max'),
                  'product_price_range_intubes_min'=>$this->input->post('product_price_range_intubes_min'),
                  'product_price_range_intubes_max'=>$this->input->post('product_price_range_intubes_max'),
                  'current_supplier'=>$current_supplier,
                  'user_id'=>$this->session->userdata['logged_in']['user_id'],
                  'company_id'=>$this->session->userdata['logged_in']['company_id'],
                  'images'=>$image_name
                      
                );

                $customer_id=$this->common_model->save_return_pkey('address_category_details',$data);
                
                // Buying Potentials

                $arr2=$this->input->post('buying_potential_sr_no[]');
                    //print_r($arr1);
                if(is_array($arr2)){
                  $j=1;
                  for($i=0;$i<count($arr2);$i++){
                            
                    $data_buying=array(  
                            'address_category_details_id'=>$customer_id,              
                            'adr_category_id'=>$customer_category,
                            'seq_no'=>$j,
                            'tubes_currently_buying'=>$this->input->post('tubes_currently_buying['.$i.']'),
                            'min_volume'=>$this->input->post('min_volume['.$i.']'),
                            'max_volume'=>$this->input->post('max_volume['.$i.']'),
                            'three_d_volume'=>$this->input->post('three_d_volume['.$i.']'),
                            'company_id'=>$this->session->userdata['logged_in']['company_id']
                                       
                            );
                          
                    $result=$this->common_model->save('sales_quote_customer_buying_potential',$data_buying);
                    $j++; 

                  }
                }//If Details

            


            }//File upload if
            

                if($customer_id){
                     $data['note']='Data saved Successfully';
                }else{
                    $data['error']='Error while saving data';
                }

                header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                $data['page_name']='Sales';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                $data['country']=$this->country_model->select_active_drop_down('country_master');
                $data['state']=$this->state_model->select_active_drop_down('zip_code_master',$this->session->userdata['logged_in']['language_id']);
                $data['employee_master']=$this->common_model->select_one_active_record('employee_master',$this->session->userdata['logged_in']['company_id'],'department_id','3');

                $data['sales_quotes_company_type_master']=$this->common_model->select_active_drop_down('sales_quotes_company_type_master',$this->session->userdata['logged_in']['company_id']);
                $data['sales_quotes_designation_master']=$this->common_model->select_active_drop_down('sales_quotes_designation_master',$this->session->userdata['logged_in']['company_id']);

                $data['sales_quotes_product_types_master']=$this->common_model->select_active_drop_down('sales_quotes_product_types_master',$this->session->userdata['logged_in']['company_id']);

                $data['sales_quotes_product_category_master']=$this->common_model->select_active_drop_down('sales_quotes_product_category_master',$this->session->userdata['logged_in']['company_id']);

                $data['sales_quotes_packaging_master']=$this->common_model->select_active_drop_down('sales_quotes_packaging_master',$this->session->userdata['logged_in']['company_id']);

                $data['sales_quotes_printing_technology_master']=$this->common_model->select_active_drop_down('sales_quotes_printing_technology_master',$this->session->userdata['logged_in']['company_id']);

                $data['sales_quotes_supplier_master']=$this->common_model->select_active_drop_down('sales_quotes_supplier_master',$this->session->userdata['logged_in']['company_id']);
                $data['sales_quotes_ownership_type_master']=$this->common_model->select_active_drop_down('sales_quotes_ownership_type_master',$this->session->userdata['logged_in']['company_id']);

               $data['customer_category']=$this->common_model->select_active_drop_down('address_category_master',$this->session->userdata['logged_in']['company_id']);
            
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view('Error/error-title',$data);
                $this->load->view('Loading/loading');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
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

  function modify($id){
       
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){ 

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

              $data['country']=$this->country_model->select_active_drop_down('country_master');
              $data['state']=$this->state_model->select_active_drop_down('zip_code_master',$this->session->userdata['logged_in']['language_id']);

              $data['employee_master']=$this->common_model->select_one_active_record('employee_master',$this->session->userdata['logged_in']['company_id'],'department_id','3');
              $data['sales_quotes_ownership_type_master']=$this->common_model->select_active_drop_down('sales_quotes_ownership_type_master',$this->session->userdata['logged_in']['company_id']);
              $data['sales_quotes_company_type_master']=$this->common_model->select_active_drop_down('sales_quotes_company_type_master',$this->session->userdata['logged_in']['company_id']);
              $data['sales_quotes_designation_master']=$this->common_model->select_active_drop_down('sales_quotes_designation_master',$this->session->userdata['logged_in']['company_id']);
              $data['sales_quotes_product_types_master']=$this->common_model->select_active_drop_down('sales_quotes_product_types_master',$this->session->userdata['logged_in']['company_id']);
              $data['sales_quotes_product_category_master']=$this->common_model->select_active_drop_down('sales_quotes_product_category_master',$this->session->userdata['logged_in']['company_id']);
              $data['sales_quotes_packaging_master']=$this->common_model->select_active_drop_down('sales_quotes_packaging_master',$this->session->userdata['logged_in']['company_id']);
              $data['sales_quotes_printing_technology_master']=$this->common_model->select_active_drop_down('sales_quotes_printing_technology_master',$this->session->userdata['logged_in']['company_id']);
              $data['sales_quotes_supplier_master']=$this->common_model->select_active_drop_down('sales_quotes_supplier_master',$this->session->userdata['logged_in']['company_id']);
              

              $data['sales_quote_customer_master']=$this->sales_quote_customer_model->select_one_active_record('address_category_details',$this->session->userdata['logged_in']['company_id'],'address_category_details_id',$id);

              
             //echo $this->db->last_query();

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
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


  function modify_contact($id){
       
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){ 

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

              $data['customer_master']=$this->sales_quote_customer_model->select_one_active_record('address_category_details',$this->session->userdata['logged_in']['company_id'],'address_category_details_id',$this->uri->segment(3));
              
              $data['sales_quotes_designation_master']=$this->common_model->select_active_drop_down('sales_quotes_designation_master',$this->session->userdata['logged_in']['company_id']);
              $data['employee_master']=$this->common_model->select_one_active_record('employee_master',$this->session->userdata['logged_in']['company_id'],'department_id','3');


              $search= array(
              'address_category_contact_id'=>$this->uri->segment(4),
              'archive'=>0
              );

              $data['sales_quote_customer_contact_details_result']=$this->common_model->select_active_records_where('address_category_contact_details',$this->session->userdata['logged_in']['company_id'],$search);
              
             //echo $this->db->last_query();

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/modify-form-contact',$data);
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

  function update(){    
    
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){              
              // Customer Info-----------
              $this->form_validation->set_rules('customer_category','Customer','required|trim|xss_clean');
              //$this->form_validation->set_rules('address','Address','required|trim|xss_clean');
             // $this->form_validation->set_rules('city','City','required|trim|xss_clean');
              //$this->form_validation->set_rules('pincode','Pin code','required|trim|xss_clean');
              $this->form_validation->set_rules('company_type','Company Type','required|trim|xss_clean');
              //$this->form_validation->set_rules('country','Country','required|trim|xss_clean');
              //$this->form_validation->set_rules('state','State','required|trim|xss_clean');

                            
              // Product Info-------------------------------

              $this->form_validation->set_rules('product_price_range_min','Product price range min','trim|xss_clean');
              $this->form_validation->set_rules('product_price_range_max','Product price range max','trim|xss_clean');
              $this->form_validation->set_rules('product_price_range_intubes_min','Product price range intubes min','trim|xss_clean');
              $this->form_validation->set_rules('product_price_range_intubes_max','Product price range intubes max','trim|xss_clean');
              $this->form_validation->set_rules('current_supplier','Current supplier','trim|xss_clean');

              //Buying Potential -----------------------------

              if(is_array($this->input->post('buying_potential_sr_no[]'))){ 
                $i=0;
                $j=1; 
                foreach ($this->input->post('buying_potential_sr_no[]') as $key => $value) {          
                  $this->form_validation->set_rules('tubes_currently_buying['.$i.']','Tubes currently buying '.$j ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('min_volume['.$i.']','Min volume '.$j ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('max_volume['.$i.']','Max volume '.$j ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('three_d_volume['.$i.']','3D volume '.$j ,'required|trim|xss_clean');
                  $i++;
                  $j++;
                }
              }  
              

              if($this->form_validation->run()==FALSE){

                
                $data['page_name']='Sales';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                $data['country']=$this->country_model->select_active_drop_down('country_master');
                $data['state']=$this->state_model->select_active_drop_down('zip_code_master',$this->session->userdata['logged_in']['language_id']);

                $data['employee_master']=$this->common_model->select_one_active_record('employee_master',$this->session->userdata['logged_in']['company_id'],'department_id','3');
                $data['sales_quotes_ownership_type_master']=$this->common_model->select_active_drop_down('sales_quotes_ownership_type_master',$this->session->userdata['logged_in']['company_id']);
                $data['sales_quotes_company_type_master']=$this->common_model->select_active_drop_down('sales_quotes_company_type_master',$this->session->userdata['logged_in']['company_id']);
                $data['sales_quotes_designation_master']=$this->common_model->select_active_drop_down('sales_quotes_designation_master',$this->session->userdata['logged_in']['company_id']);
                $data['sales_quotes_product_types_master']=$this->common_model->select_active_drop_down('sales_quotes_product_types_master',$this->session->userdata['logged_in']['company_id']);
                $data['sales_quotes_product_category_master']=$this->common_model->select_active_drop_down('sales_quotes_product_category_master',$this->session->userdata['logged_in']['company_id']);
                $data['sales_quotes_packaging_master']=$this->common_model->select_active_drop_down('sales_quotes_packaging_master',$this->session->userdata['logged_in']['company_id']);
                $data['sales_quotes_printing_technology_master']=$this->common_model->select_active_drop_down('sales_quotes_printing_technology_master',$this->session->userdata['logged_in']['company_id']);
                $data['sales_quotes_supplier_master']=$this->common_model->select_active_drop_down('sales_quotes_supplier_master',$this->session->userdata['logged_in']['company_id']);
                $data['customer_category']=$this->common_model->select_active_drop_down('address_category_master',$this->session->userdata['logged_in']['company_id']);
            
             


                $data['sales_quote_customer_master']=$this->sales_quote_customer_model->select_one_active_record('address_category_details',$this->session->userdata['logged_in']['company_id'],'address_category_details_id',$this->input->post('address_category_details_id'));



                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                //$this->load->view('Loading/loading');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
                $this->load->view('Home/footer');
              }else{



                if(!empty($this->input->post('customer_category'))){
                    $customer_category_arr=explode('//',$this->input->post('customer_category'));
                    $customer_category=$customer_category_arr[1];
                  }else{
                    $customer_category="";
                  }

                if(!empty($this->input->post('primary_contact'))){
                    $primary_contact_arr=explode('//',$this->input->post('primary_contact'));
                    $primary_contact_id=$primary_contact_arr[1];
                  }else{
                    $primary_contact_id="";
                  }

                  if(!empty($this->input->post('secondary_contact'))){
                    $secondary_contact_arr=explode('//',$this->input->post('secondary_contact'));
                    $secondary_contact_id=$secondary_contact_arr[1];
                  }else{
                    $secondary_contact_id="";
                  }

                $ownership='';
                if(!empty($this->input->post('ownership[]'))){
                  $ownership=implode(",",$this->input->post('ownership[]'));
                }

                $product_type='';  
                if(!empty($this->input->post('product_type[]'))){
                  $product_type=implode(",",$this->input->post('product_type[]'));
                }
                $product_category='';  
                if(!empty($this->input->post('product_category[]'))){
                  $product_category=implode(",",$this->input->post('product_category[]'));
                }
                
                $packaging_type='';  
                if(!empty($this->input->post('packaging_type[]'))){
                  $packaging_type=implode(",",$this->input->post('packaging_type[]'));
                }                

                $printing_technology='';  
                if(!empty($this->input->post('printing_technology[]'))){
                  $printing_technology=implode(",",$this->input->post('printing_technology[]'));
                }

                $current_supplier='';  
                if(!empty($this->input->post('current_supplier[]'))){
                  $current_supplier=implode(",",$this->input->post('current_supplier[]'));
                }


                // File Upload---------------------------------- 


                $image_status='';
                $image_name=$this->input->post('image_path');
                $path = './assets/'.$this->session->userdata['logged_in']['company_id'].'/customer_quotation/';

                if(!empty($_FILES['images']['name'][0])) {
                  $image_status=$this->upload_files($path,$_FILES['images']);
                }             
              
                $file_upload_flag=1;
                $result='';
                if($image_status===FALSE){
                  $data['error']=$this->upload->display_errors();
                  $file_upload_flag=0;
                }else{

                  if(is_array($image_status)){
                    $image_name=implode(",",$image_status);
                  }
                  $file_upload_flag=1;
                }

                $data_update=array(
                  'adr_category_id'=>$customer_category,
                  'address'=>strtoupper($this->input->post('address')),
                  'city'=>strtoupper($this->input->post('city')),
                  'pincode'=>$this->input->post('pincode'),
                  'company_type'=>$this->input->post('company_type'),
                  'country'=>$this->input->post('country'),
                  'state'=>$this->input->post('state'),
                  'ownership'=>$ownership,
                  'primary_contact_id'=>$primary_contact_id,
                  'secondary_contact_id'=>$secondary_contact_id,
                  'product_type'=>$product_type,
                  'product_category'=>$product_category,
                  'packaging_type'=>$packaging_type,
                  'printing_technology'=>$printing_technology,
                  'product_price_range_min'=>$this->input->post('product_price_range_min'),
                  'product_price_range_max'=>$this->input->post('product_price_range_max'),
                  'product_price_range_intubes_min'=>$this->input->post('product_price_range_intubes_min'),
                  'product_price_range_intubes_max'=>$this->input->post('product_price_range_intubes_max'),
                  'current_supplier'=>$current_supplier,
                  'images'=>$image_name                
                                    
                      
                );

                $result_update=$this->common_model->update_one_active_record('address_category_details',$data_update,'address_category_details_id',$this->input->post('address_category_details_id'),$this->session->userdata['logged_in']['company_id']);

                $data_array=array('archive'=>'1');
                $result_delete1=$this->common_model->update_one_active_record('sales_quote_customer_buying_potential',$data_array,'adr_category_id',$customer_category,$this->session->userdata['logged_in']['company_id']);




                $arr2=$this->input->post('buying_potential_sr_no[]');
                    //print_r($arr1);
                if(is_array($arr2)){
                  $j=1;
                  for($i=0;$i<count($arr2);$i++){
                            
                    $data_buying=array(                    
                      'adr_category_id'=>$customer_category,
                      'seq_no'=>$j,
                      'tubes_currently_buying'=>$this->input->post('tubes_currently_buying['.$i.']'),
                      'min_volume'=>$this->input->post('min_volume['.$i.']'),
                      'max_volume'=>$this->input->post('max_volume['.$i.']'),
                      'three_d_volume'=>$this->input->post('three_d_volume['.$i.']'),
                      'company_id'=>$this->session->userdata['logged_in']['company_id']
                                 
                      );
                          
                    $result_buying_potential=$this->common_model->save('sales_quote_customer_buying_potential',$data_buying);
                    $j++; 

                  }
                }//If Details  

                   
              if($result_update){
                $data['note']='Data Updated Successfully';
              }else{
                $data['error']='Error while Updating data';
              }

             // header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
               

                $data['page_name']='Sales';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                $data['country']=$this->country_model->select_active_drop_down('country_master');
                $data['state']=$this->state_model->select_active_drop_down('zip_code_master',$this->session->userdata['logged_in']['language_id']);
                $data['employee_master']=$this->common_model->select_one_active_record('employee_master',$this->session->userdata['logged_in']['company_id'],'department_id','3');

                $data['sales_quotes_company_type_master']=$this->common_model->select_active_drop_down('sales_quotes_company_type_master',$this->session->userdata['logged_in']['company_id']);
                $data['sales_quotes_designation_master']=$this->common_model->select_active_drop_down('sales_quotes_designation_master',$this->session->userdata['logged_in']['company_id']);

                $data['sales_quotes_product_types_master']=$this->common_model->select_active_drop_down('sales_quotes_product_types_master',$this->session->userdata['logged_in']['company_id']);

                $data['sales_quotes_product_category_master']=$this->common_model->select_active_drop_down('sales_quotes_product_category_master',$this->session->userdata['logged_in']['company_id']);

                $data['sales_quotes_packaging_master']=$this->common_model->select_active_drop_down('sales_quotes_packaging_master',$this->session->userdata['logged_in']['company_id']);

                $data['sales_quotes_printing_technology_master']=$this->common_model->select_active_drop_down('sales_quotes_printing_technology_master',$this->session->userdata['logged_in']['company_id']);

                $data['sales_quotes_supplier_master']=$this->common_model->select_active_drop_down('sales_quotes_supplier_master',$this->session->userdata['logged_in']['company_id']);
                $data['sales_quotes_ownership_type_master']=$this->common_model->select_active_drop_down('sales_quotes_ownership_type_master',$this->session->userdata['logged_in']['company_id']);

                $data['sales_quote_customer_master']=$this->sales_quote_customer_model->select_one_active_record('address_category_details',$this->session->userdata['logged_in']['company_id'],'address_category_details_id',$this->input->post('address_category_details_id'));


                $data['customer_category']=$this->common_model->select_active_drop_down('address_category_master',$this->session->userdata['logged_in']['company_id']);
               
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view('Loading/loading');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
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

  function delete($id){

      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

              
              $data=array('archive'=>'1');
              $result=$this->common_model->update_one_active_record('address_category_details',$data,'address_category_details_id',$id,$this->session->userdata['logged_in']['company_id']); 

              $data=array('archive'=>'1');
              $result=$this->common_model->update_one_active_record('address_category_contact_details',$data,'address_category_details_id',$id,$this->session->userdata['logged_in']['company_id']); 

               $result=$this->common_model->update_one_active_record('sales_quote_customer_buying_potential',$data,'adr_category_id',$id,$this->session->userdata['logged_in']['company_id']);

              $data['sales_quote_customer_master']=$this->common_model->select_one_inactive_record('address_category_details',$this->session->userdata['logged_in']['company_id'],'address_category_details_id',$id); 


              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

              $data['country']=$this->country_model->select_active_drop_down('country_master');
              $data['state']=$this->state_model->select_active_drop_down('zip_code_master',$this->session->userdata['logged_in']['language_id']);
              $data['employee_master']=$this->common_model->select_one_active_record('employee_master',$this->session->userdata['logged_in']['company_id'],'department_id','3');

              $data['sales_quotes_company_type_master']=$this->common_model->select_active_drop_down('sales_quotes_company_type_master',$this->session->userdata['logged_in']['company_id']);
              $data['sales_quotes_designation_master']=$this->common_model->select_active_drop_down('sales_quotes_designation_master',$this->session->userdata['logged_in']['company_id']);

              $data['sales_quotes_product_types_master']=$this->common_model->select_active_drop_down('sales_quotes_product_types_master',$this->session->userdata['logged_in']['company_id']);

              $data['sales_quotes_product_category_master']=$this->common_model->select_active_drop_down('sales_quotes_product_category_master',$this->session->userdata['logged_in']['company_id']);

              $data['sales_quotes_packaging_master']=$this->common_model->select_active_drop_down('sales_quotes_packaging_master',$this->session->userdata['logged_in']['company_id']);

              $data['sales_quotes_printing_technology_master']=$this->common_model->select_active_drop_down('sales_quotes_printing_technology_master',$this->session->userdata['logged_in']['company_id']);

              $data['sales_quotes_supplier_master']=$this->common_model->select_active_drop_down('sales_quotes_supplier_master',$this->session->userdata['logged_in']['company_id']);
              $data['sales_quotes_ownership_type_master']=$this->common_model->select_active_drop_down('sales_quotes_ownership_type_master',$this->session->userdata['logged_in']['company_id']);

                 

               
              $data['note']='Archive Transaction completed';
              header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
              $this->load->view('Home/footer');
            }else{
                $data['note']='No Archive rights Thanks';
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
        $data['note']='No Archive rights Thanks';
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
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
          //print_r( $data['formrights']);

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

              $table='sales_quote_customer_master';
              include('pagination_archive.php');
              $data['sales_quote_customer_master']=$this->sales_quote_customer_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
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

  function dearchive($id){

      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

              
              $data=array('archive'=>'0');
              $result=$this->common_model->update_one_active_record('sales_quote_customer_master',$data,'id',$id,$this->session->userdata['logged_in']['company_id']);  


              $data=array('archive'=>'0');
              $result=$this->common_model->update_one_active_record('sales_quote_customer_contact_details',$data,'customer_id',$id,$this->session->userdata['logged_in']['company_id']); 

               $result=$this->common_model->update_one_active_record('sales_quote_customer_buying_potential',$data,'customer_id',$id,$this->session->userdata['logged_in']['company_id']);

              $data['sales_quote_customer_master']=$this->common_model->select_one_active_record('sales_quote_customer_master',$this->session->userdata['logged_in']['company_id'],'customer_id',$id); 


              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

              $data['country']=$this->country_model->select_active_drop_down('country_master');
              $data['state']=$this->state_model->select_active_drop_down('zip_code_master',$this->session->userdata['logged_in']['language_id']);
              $data['employee_master']=$this->common_model->select_one_active_record('employee_master',$this->session->userdata['logged_in']['company_id'],'department_id','3');

              $data['sales_quotes_company_type_master']=$this->common_model->select_active_drop_down('sales_quotes_company_type_master',$this->session->userdata['logged_in']['company_id']);
              $data['sales_quotes_designation_master']=$this->common_model->select_active_drop_down('sales_quotes_designation_master',$this->session->userdata['logged_in']['company_id']);

              $data['sales_quotes_product_types_master']=$this->common_model->select_active_drop_down('sales_quotes_product_types_master',$this->session->userdata['logged_in']['company_id']);

              $data['sales_quotes_product_category_master']=$this->common_model->select_active_drop_down('sales_quotes_product_category_master',$this->session->userdata['logged_in']['company_id']);

              $data['sales_quotes_packaging_master']=$this->common_model->select_active_drop_down('sales_quotes_packaging_master',$this->session->userdata['logged_in']['company_id']);

              $data['sales_quotes_printing_technology_master']=$this->common_model->select_active_drop_down('sales_quotes_printing_technology_master',$this->session->userdata['logged_in']['company_id']);

              $data['sales_quotes_supplier_master']=$this->common_model->select_active_drop_down('sales_quotes_supplier_master',$this->session->userdata['logged_in']['company_id']);
              $data['sales_quotes_ownership_type_master']=$this->common_model->select_active_drop_down('sales_quotes_ownership_type_master',$this->session->userdata['logged_in']['company_id']);


               
              $data['note']='Dearchive Transaction completed';
              header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
              $this->load->view('Home/footer');
            }else{
                $data['note']='No Archive rights Thanks';
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
        $data['note']='No Archive rights Thanks';
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
    
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){


              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

              $data['country']=$this->country_model->select_active_drop_down('country_master');
              $data['state']=$this->state_model->select_active_drop_down('zip_code_master',$this->session->userdata['logged_in']['language_id']);
              $data['employee_master']=$this->common_model->select_one_active_record('employee_master',$this->session->userdata['logged_in']['company_id'],'department_id','3');

              $data['sales_quotes_company_type_master']=$this->common_model->select_active_drop_down('sales_quotes_company_type_master',$this->session->userdata['logged_in']['company_id']);
              $data['sales_quotes_designation_master']=$this->common_model->select_active_drop_down('sales_quotes_designation_master',$this->session->userdata['logged_in']['company_id']);

              $data['sales_quotes_product_types_master']=$this->common_model->select_active_drop_down('sales_quotes_product_types_master',$this->session->userdata['logged_in']['company_id']);

              $data['sales_quotes_product_category_master']=$this->common_model->select_active_drop_down('sales_quotes_product_category_master',$this->session->userdata['logged_in']['company_id']);

              $data['sales_quotes_packaging_master']=$this->common_model->select_active_drop_down('sales_quotes_packaging_master',$this->session->userdata['logged_in']['company_id']);

              $data['sales_quotes_printing_technology_master']=$this->common_model->select_active_drop_down('sales_quotes_printing_technology_master',$this->session->userdata['logged_in']['company_id']);

              $data['sales_quotes_supplier_master']=$this->common_model->select_active_drop_down('sales_quotes_supplier_master',$this->session->userdata['logged_in']['company_id']);
              $data['sales_quotes_ownership_type_master']=$this->common_model->select_active_drop_down('sales_quotes_ownership_type_master',$this->session->userdata['logged_in']['company_id']);

             
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

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

            $this->form_validation->set_rules('from_date','From Date' ,'trim|xss_clean|exact_length[10]');
            $this->form_validation->set_rules('to_date','To Date' ,'trim|xss_clean|exact_length[10]');
            $this->form_validation->set_rules('customer_name','Customer name','trim|xss_clean|callback_customer');
            $this->form_validation->set_rules('address','Address','trim|xss_clean');
            $this->form_validation->set_rules('city','City','trim|xss_clean');
            $this->form_validation->set_rules('pincode','Pin code','trim|xss_clean');
            $this->form_validation->set_rules('company_type','Company Type','trim|xss_clean');
            $this->form_validation->set_rules('country','Country','trim|xss_clean');
            $this->form_validation->set_rules('state','State','trim|xss_clean');

              
                          
            if($this->form_validation->run()==FALSE){

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

               
              $data['country']=$this->country_model->select_active_drop_down('country_master');
              $data['state']=$this->state_model->select_active_drop_down('zip_code_master',$this->session->userdata['logged_in']['language_id']);
              $data['employee_master']=$this->common_model->select_one_active_record('employee_master',$this->session->userdata['logged_in']['company_id'],'department_id','3');

              $data['sales_quotes_company_type_master']=$this->common_model->select_active_drop_down('sales_quotes_company_type_master',$this->session->userdata['logged_in']['company_id']);
              $data['sales_quotes_designation_master']=$this->common_model->select_active_drop_down('sales_quotes_designation_master',$this->session->userdata['logged_in']['company_id']);

              $data['sales_quotes_product_types_master']=$this->common_model->select_active_drop_down('sales_quotes_product_types_master',$this->session->userdata['logged_in']['company_id']);

              $data['sales_quotes_product_category_master']=$this->common_model->select_active_drop_down('sales_quotes_product_category_master',$this->session->userdata['logged_in']['company_id']);

              $data['sales_quotes_packaging_master']=$this->common_model->select_active_drop_down('sales_quotes_packaging_master',$this->session->userdata['logged_in']['company_id']);

              $data['sales_quotes_printing_technology_master']=$this->common_model->select_active_drop_down('sales_quotes_printing_technology_master',$this->session->userdata['logged_in']['company_id']);

              $data['sales_quotes_supplier_master']=$this->common_model->select_active_drop_down('sales_quotes_supplier_master',$this->session->userdata['logged_in']['company_id']);
              $data['sales_quotes_ownership_type_master']=$this->common_model->select_active_drop_down('sales_quotes_ownership_type_master',$this->session->userdata['logged_in']['company_id']);

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
              $this->load->view('Home/footer');
            }else{ 

                $master_array=array();

                if(!empty($this->input->post('customer_name'))){
                    $customer_name_arr=explode('//',$this->input->post('customer_name'));
                    $master_array['adr_category_id']=$customer_name_arr[1];
                  }else{

                  $customer_name="";
                  }

                if(!empty($this->input->post('address'))){
                  $master_array['address']=$this->input->post('address');
                }
                if(!empty($this->input->post('city'))){
                  $master_array['city']=$this->input->post('city');
                }
                if(!empty($this->input->post('pincode'))){
                  $master_array['pincode']=$this->input->post('pincode');
                }
                if(!empty($this->input->post('company_type'))){
                  $master_array['company_type']=$this->input->post('company_type');
                }
                if(!empty($this->input->post('country'))){
                  $master_array['country']=$this->input->post('country');
                }
                if(!empty($this->input->post('state'))){
                  $master_array['state']=$this->input->post('state');
                }
                if(!empty($this->input->post('product_price_range_min'))){
                  $master_array['product_price_range_min']=$this->input->post('product_price_range_min');
                }
                if(!empty($this->input->post('product_price_range_max'))){
                  $master_array['product_price_range_max']=$this->input->post('product_price_range_max');
                }

                if(!empty($this->input->post('product_price_range_intubes_min'))){
                  $master_array['product_price_range_intubes_min']=$this->input->post('product_price_range_intubes_min');
                }
                if(!empty($this->input->post('product_price_range_intubes_max'))){
                  $master_array['product_price_range_intubes_max']=$this->input->post('product_price_range_intubes_max');
                }



                $ownership='';
                if(!empty($this->input->post('ownership[]'))){
                 $master_array['ownership']=implode(",",$this->input->post('ownership[]'));
                }
                $product_type='';  
                if(!empty($this->input->post('product_type[]'))){
                  $master_array['product_type']=implode(",",$this->input->post('product_type[]'));
                }
                $product_category='';  
                if(!empty($this->input->post('product_category[]'))){
                  $master_array['product_category']=implode(",",$this->input->post('product_category[]'));
                }
                
                $packaging_type='';  
                if(!empty($this->input->post('packaging_type[]'))){
                  $master_array['packaging_type']=implode(",",$this->input->post('packaging_type[]'));
                }                

                $printing_technology='';  
                if(!empty($this->input->post('printing_technology[]'))){
                  $master_array['printing_technology']=implode(",",$this->input->post('printing_technology[]'));
                }

                $current_supplier='';  
                if(!empty($this->input->post('current_supplier[]'))){
                  $master_array['current_supplier']=implode(",",$this->input->post('current_supplier[]'));
                }   
              
               
                  

              $data['sales_quote_customer_master']=$this->sales_quote_customer_model->active_record_search('address_category_details',$this->session->userdata['logged_in']['company_id'],$master_array,$this->input->post('from_date'),$this->input->post('to_date')); 
             //echo $this->db->last_query();            

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

              $data['country']=$this->country_model->select_active_drop_down('country_master');
              $data['state']=$this->state_model->select_active_drop_down('zip_code_master',$this->session->userdata['logged_in']['language_id']);
              $data['employee_master']=$this->common_model->select_one_active_record('employee_master',$this->session->userdata['logged_in']['company_id'],'department_id','3');

              $data['sales_quotes_company_type_master']=$this->common_model->select_active_drop_down('sales_quotes_company_type_master',$this->session->userdata['logged_in']['company_id']);
              $data['sales_quotes_designation_master']=$this->common_model->select_active_drop_down('sales_quotes_designation_master',$this->session->userdata['logged_in']['company_id']);

              $data['sales_quotes_product_types_master']=$this->common_model->select_active_drop_down('sales_quotes_product_types_master',$this->session->userdata['logged_in']['company_id']);

              $data['sales_quotes_product_category_master']=$this->common_model->select_active_drop_down('sales_quotes_product_category_master',$this->session->userdata['logged_in']['company_id']);

              $data['sales_quotes_packaging_master']=$this->common_model->select_active_drop_down('sales_quotes_packaging_master',$this->session->userdata['logged_in']['company_id']);

              $data['sales_quotes_printing_technology_master']=$this->common_model->select_active_drop_down('sales_quotes_printing_technology_master',$this->session->userdata['logged_in']['company_id']);

              $data['sales_quotes_supplier_master']=$this->common_model->select_active_drop_down('sales_quotes_supplier_master',$this->session->userdata['logged_in']['company_id']);
              $data['sales_quotes_ownership_type_master']=$this->common_model->select_active_drop_down('sales_quotes_ownership_type_master',$this->session->userdata['logged_in']['company_id']);


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



  function view($id){
       
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){


              $data['company']=$this->common_model->select_one_active_record('company_master',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);
            
              $data['company_details']=$this->common_model->select_one_active_record('company_system_parameters',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);
 
              
              $data['sales_quote_customer_master']=$this->sales_quote_customer_model->select_one_active_record('address_category_details',$this->session->userdata['logged_in']['company_id'],'address_category_details.address_category_details_id',$id);

              $data['sales_quote_customer_buying_potential']=$this->common_model->select_one_active_record('sales_quote_customer_buying_potential',$this->session->userdata['logged_in']['company_id'],'address_category_details_id',$id);

              $abc=array('adr_category_id'=>$this->uri->segment(4),
                         'archive'=>'0');
              $data['customer_contact_details']=$this->common_model->select_active_records_where('address_category_contact_details',$this->session->userdata['logged_in']['company_id'],$abc);

              $data['sales_quote_customer_buying_potential']=$this->common_model->select_active_records_where('sales_quote_customer_buying_potential',$this->session->userdata['logged_in']['company_id'],$abc);

             //echo $this->db->last_query();

              //$this->load->view('Home/header');
              //$this->load->view('Home/nav',$data);
              //$this->load->view('Home/subnav');
              $this->load->view('Print/header',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/view-form',$data);
              //$this->load->view('Home/footer');
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

  function upload_files($path,$files){
        //echo'function started';

        $config = array(
            'upload_path'   => $path,
            'max_size'      =>150000,
            'remove_spaces' =>TRUE,
            'allowed_types' => 'pdf|PDF|jpeg|JPEG|jpg|JPG|png|PNG'           

        );

        $this->load->library('upload', $config);

        $images = array();
        $i=1;
        foreach ($files['name'] as $key => $image) {

            $_FILES['images[]']['name']= $files['name'][$key];
            $_FILES['images[]']['type']= $files['type'][$key];
            $_FILES['images[]']['tmp_name']= $files['tmp_name'][$key];
            $_FILES['images[]']['error']= $files['error'][$key];
            $_FILES['images[]']['size']= $files['size'][$key];

            //$fileName =  $image;

            $fileExt = pathinfo($files['name'][$key], PATHINFO_EXTENSION);

            $image=time().$i.'.'.$fileExt;

            $images[] = $image;
            $config['file_name'] = $image;

            $this->upload->initialize($config);

            if($this->upload->do_upload('images[]')) {
                $this->upload->data();
            }else {
                return false;
            }

            $i++;
        }

        return $images;
  }


  public function c_check($str){
    //echo $str;
    if(!empty($str)){
    $customer_code=explode('//',$str);
    //print_r($customer_code);
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


  public function customer_check($str){
    //echo $str;
    if(!empty($str)){
    $customer_code=explode('//',$str);
    if(!empty($customer_code[1])){

      $data=array('adr_category_id'=>$customer_code[1],
        'category_name'=>$customer_code[0]);
      $count="";
      $count=$this->common_model->active_record_count_where_pkey('address_category_details',$this->session->userdata['logged_in']['company_id'],'adr_category_id',$customer_code[1]);
      
      if($count>0){
        
        $this->form_validation->set_message('customer_check', 'The {field} already exist');
        return FALSE;
      }
      
      $data['customer']=$this->common_model->select_one_active_record_nonlanguage_without_archives('address_category_master',$this->session->userdata['logged_in']['company_id'],$data);
    //echo $this->db->last_query();
    foreach ($data['customer'] as $customer_row) {

      if ($customer_row->adr_category_id == $customer_code[1]){
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

  public function customer($str){
    //echo $str;
    if(!empty($str)){
    $customer_code=explode('//',$str);
    if(!empty($customer_code[1])){

      $data=array('adr_category_id'=>$customer_code[1],
        'category_name'=>$customer_code[0]);
      $count="";
      $count=$this->common_model->active_record_count_where_pkey('address_category_details',$this->session->userdata['logged_in']['company_id'],'adr_category_id',$customer_code[1]);
      
      if($count>0){
        return TRUE;
      }else{
        $this->form_validation->set_message('customer', 'The {field} field is incorrect');
        return FALSE;
      }
          
    }else{
        $this->form_validation->set_message('customer', 'The {field} field is incorrect');
        return FALSE;
        } 

    }

  }

  public function primary_contact_check($str){
    //echo $str;
    if(!empty($str)){
    $contact_id=explode('//',$str);
    //print_r($customer_code);
    if(!empty($contact_id[1])){
      $data=array('address_category_contact_id'=>$contact_id[1],
        'contact_name'=>$contact_id[0]);
    $data['contact_details']=$this->common_model->select_one_active_record_nonlanguage_without_archives('address_category_contact_details',$this->session->userdata['logged_in']['company_id'],$data);
    //echo $this->db->last_query();
    foreach ($data['contact_details'] as $row) {

      if ($row->address_category_contact_id == $contact_id[1]){
        return TRUE;
      }else{
        $this->form_validation->set_message('primary_contact_check', 'The {field} field is incorrect');
        return FALSE;
        }
      } 
    }else{
        $this->form_validation->set_message('primary_contact_check', 'The {field} field is incorrect');
        return FALSE;
        } 

    }
  }



}

