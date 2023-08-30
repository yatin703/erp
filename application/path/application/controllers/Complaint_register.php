<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Complaint_register extends CI_Controller {

  function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('fiscal_model');
      $this->load->model('customer_model');
      $this->load->model('article_model');
      $this->load->model('complaint_register_model');
      
    

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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          
          if($formrights_row->view==1){
            $table='capa_complaint_register_master';
            include('pagination.php');
            $data['capa_complaint_register_master']=$this->complaint_register_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

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
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          
          if($formrights_row->view==1){
            $table='capa_complaint_register_master';
            include('pagination.php');
            $data['capa_complaint_register_master']=$this->complaint_register_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
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
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){
            
            $data['capa_complaint_nature_master']=$this->common_model->select_active_drop_down('capa_complaint_nature_master',$this->session->userdata['logged_in']['company_id']);
            
            $data['springtube_shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);

            $data['coex_machine_master']=$this->common_model->select_active_drop_down('coex_machine_master',$this->session->userdata['logged_in']['company_id']);
            
             
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



  function save(){
  
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {

          if($formrights_row->new==1){            
             
            $this->form_validation->set_rules('email_date','Email Date' ,'required|trim|xss_clean');  
            $this->form_validation->set_rules('complaint_source','Complaint Source' ,'required|trim|xss_clean');

            if($this->input->post('complaint_source')=='0'){
              $this->form_validation->set_rules('order_no','Order No' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('order_tubes_hold','No. Of Tubes Hold' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('defective_tubes','Defective Tubes' ,'trim|xss_clean');

              $this->form_validation->set_rules('shift','Shift' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('machine','Machine name' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('operator','Responsible Person' ,'required|trim|xss_clean');

              
            }else{
              $this->form_validation->set_rules('invoice_no','Invoice No' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('invoice_tubes_checked','No. Of Tubes checked' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('defective_tubes','Defective Tubes' ,'required|trim|xss_clean');

              if(empty($_FILES['images']['name'][0])) {
                $this->form_validation->set_rules('images','Evidence' ,'required');
              }
              $this->form_validation->set_rules('shift','Shift' ,'trim|xss_clean');

              $this->form_validation->set_rules('machine','Machine name' ,'trim|xss_clean');
              $this->form_validation->set_rules('operator','Responsible Person' ,'trim|xss_clean');


            }

            $this->form_validation->set_rules('article_no[]','Article No' ,'required|trim|xss_clean');

            
            $this->form_validation->set_rules('complaint_nature[]','Nature of Complaints' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('comment','Comment' ,'required|trim|xss_clean');

            if($this->input->post('is_pallet_checked')=='1'){
              $this->form_validation->set_rules('pallets','No Of Pallets' ,'required|trim|xss_clean');
            }
            if($this->input->post('is_box_checked')=='1'){
              $this->form_validation->set_rules('boxes','No Of Boxes' ,'required|trim|xss_clean');
            }

            $this->form_validation->set_rules('claim_inspection','Claim Inspection' ,'required|trim|xss_clean');
           
            //$this->form_validation->set_rules('complaint_status','Complaint Status' ,'required|trim|xss_clean');

            // if(empty($_FILES['images']['name'][0])) {

            //   $this->form_validation->set_rules('images','Evidence' ,'required');
            // }        
            
            
            

            if($this->form_validation->run()==FALSE){
              
              $data['capa_complaint_nature_master']=$this->common_model->select_active_drop_down('capa_complaint_nature_master',$this->session->userdata['logged_in']['company_id']);
              
              $data['springtube_shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);

              $data['coex_machine_master']=$this->common_model->select_active_drop_down('coex_machine_master',$this->session->userdata['logged_in']['company_id']);
            
       
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
              $this->load->view('Home/footer');
            }else{ 

              //Autogeneration Format Master---FORM ID  90----------------------------
              $complaint_no='';
              $next_complaint_no='';
              $data['auto']=$this->common_model->select_one_active_record_nonlanguage_without_archive('autogeneration_format_master',$this->session->userdata['logged_in']['company_id'],'form_id','90');
                $no="";
                foreach ($data['auto'] as $auto_row) {

                  $data['account_periods']=$this->common_model->select_one_active_record_nonlanguage_without_archive('account_periods_master',$this->session->userdata['logged_in']['company_id'],'finyear_close_opt','0');
                  foreach($data['account_periods'] as $account_periods_row){
                    $start=date('y', strtotime($account_periods_row->fin_year_start));
                    $end=date('y', strtotime($account_periods_row->fin_year_end));
                  }
                  $no=str_pad($auto_row->curr_val,4,"0",STR_PAD_LEFT);
                  $complaint_no=$auto_row->textcode.$auto_row->seperator.$start.$auto_row->seperator.$end.$auto_row->seperator.$no;
                  $next_complaint_no=$auto_row->curr_val+1;
                }

                $data=array('curr_val'=>$next_complaint_no);
                $this->common_model->update_one_active_record('autogeneration_format_master',$data,'form_id','90',$this->session->userdata['logged_in']['company_id']);
             
                
                $ref_no='';
                $customer='';
                $order_no='';
                $tubes_hold_checked='';
                 
                $article_no='';
                $qty='';


                if($this->input->post('complaint_source')=='0'){
                  
                  $ref_no=$this->input->post('order_no');
                  $tubes_hold_checked=$this->input->post('order_tubes_hold');
                  
                  $order_master_result=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$ref_no);
                    foreach($order_master_result as $order_master_row){
                      $customer=$order_master_row->customer_no;                      
                    }

                    if(!empty($this->input->post('article_no[]')) && is_array($this->input->post('article_no[]'))){

                      foreach ($this->input->post('article_no[]')as $key => $value) {
                        
                        $data_order_details=array(
                        'order_no'=>$ref_no,
                        'article_no'=>$value                    
                        );

                        $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
                        foreach($order_details_result as $order_details_row){
                          $qty+=$this->common_model->read_number($order_details_row->total_order_quantity,$this->session->userdata['logged_in']['company_id']);
                        }
                      }

                      $article_no=implode(",", $this->input->post('article_no[]'));
                      
                    }

                    
                }else{

                  $ref_no=$this->input->post('invoice_no');
                  $tubes_hold_checked=$this->input->post('invoice_tubes_checked');

                  $ar_invoice_master_result=$this->common_model->select_one_active_record('ar_invoice_master',$this->session->userdata['logged_in']['company_id'],'ar_invoice_no',$ref_no);
                    foreach($ar_invoice_master_result as $ar_invoice_master_row){
                      $customer=$ar_invoice_master_row->customer_no;                      
                    }

                    if(!empty($this->input->post('article_no[]')) && is_array($this->input->post('article_no[]'))){

                      foreach ($this->input->post('article_no[]')as $key => $value) {
                        
                        $data_invoice_details=array(
                        'ar_invoice_no'=>$ref_no,
                        'article_no'=>$value                    
                        );

                        $invoice_details_result=$this->common_model->select_active_records_where('ar_invoice_details',$this->session->userdata['logged_in']['company_id'],$data_invoice_details);
                        foreach($invoice_details_result as $invoice_details_row){
                          $qty+=$this->common_model->read_number($invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
                        }
                      }

                      $article_no=implode(",", $this->input->post('article_no[]'));
                      
                    }
                }     
                      
                $pallets='';
                if($this->input->post('is_pallet_checked')=='1'){
                  $pallets=$this->input->post('pallets');
                }
                $boxes='';
                if($this->input->post('is_box_checked')=='1'){
                  $boxes=$this->input->post('boxes');
                } 
            



               // File Upload----------------------------------  

              $image_status='';
              $image_name='';
              $path = './assets/'.$this->session->userdata['logged_in']['company_id'].'/complaints/';

              if(!empty($_FILES['images']['name'][0])) {
                $image_status=$this->upload_files($path,$_FILES['images']);
              }             
            
              $result='';
              if($image_status===FALSE){
                $data['error']=$this->upload->display_errors();
              }else{

                if(is_array($image_status)){
                  $image_name=implode(",",$image_status);
                }

                

              $complaint_nature=implode(",", $this->input->post('complaint_nature[]'));

              $data=array(
                'email_date'=>$this->input->post('email_date'),
                'complaint_no'=>$complaint_no,                    
                'complaint_date'=>date('Y-m-d'),
                'customer'=>$customer,
                'complaint_source'=>$this->input->post('complaint_source'),
                'reference_no'=>$ref_no,
                'article_no'=>$article_no,
                'qty'=>$qty,
                'defective_tubes'=>$this->input->post('defective_tubes'),
                'tubes_hold_checked'=>$tubes_hold_checked,

                'complaint_nature'=>$complaint_nature, 
                'is_pallet_checked'=>(!empty($this->input->post('is_pallet_checked'))?1:0), 
                'pallets'=>$pallets,                
                'is_box_checked'=>(!empty($this->input->post('is_box_checked'))?1:0),
                'boxes'=>$boxes, 
                'claim_inspection'=>$this->input->post('claim_inspection'), 
               // 'complaint_status'=>$this->input->post('complaint_status'), 
                'comment'=>$this->input->post('comment'),
                'images'=>$image_name,
                'company_id'=>$this->session->userdata['logged_in']['company_id'],
                'user_id'=>$this->session->userdata['logged_in']['user_id'],
                'shift'=>$this->input->post('shift'),
                'machine'=>$this->input->post('machine'),
                'operator'=>$this->input->post('operator')
              );

              $result=$this->common_model->save('capa_complaint_register_master',$data); 

            }

              if($result){
                $data['note']='Data saved successfully.';
              }                

              //header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
               
              $data['capa_complaint_nature_master']=$this->common_model->select_active_drop_down('capa_complaint_nature_master',$this->session->userdata['logged_in']['company_id']);

              $data['springtube_shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);

              $data['coex_machine_master']=$this->common_model->select_active_drop_down('coex_machine_master',$this->session->userdata['logged_in']['company_id']);
            

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
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

              $data['capa_complaint_nature_master']=$this->common_model->select_active_drop_down('capa_complaint_nature_master',$this->session->userdata['logged_in']['company_id']);

             
              $data['capa_complaint_register_master']=$this->common_model->select_one_active_record('capa_complaint_register_master',$this->session->userdata['logged_in']['company_id'],'id',$id);

              $data['springtube_shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);

              $data['coex_machine_master']=$this->common_model->select_active_drop_down('coex_machine_master',$this->session->userdata['logged_in']['company_id']);
            

              //print_r($data['capa_complaint_register_master']);

              foreach ($data['capa_complaint_register_master'] as $key => $row) {
                if($row->complaint_source=='0'){
                  $data['article_no_result']=$this->common_model->select_one_details_record('order_details',$this->session->userdata['logged_in']['company_id'],'order_no',$row->reference_no);
                }
                else if($row->complaint_source=='1'){
                  $data['article_no_result']=$this->common_model->select_one_details_record('ar_invoice_details',$this->session->userdata['logged_in']['company_id'],'ar_invoice_no',$row->reference_no);
                }

              }

              
             // echo $this->db->last_query();

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

  function update(){
  
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {

          if($formrights_row->modify==1){            
            

            

            $this->form_validation->set_rules('id','Primary Key' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('email_date','Email Date' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('complaint_source','Complaint Source' ,'required|trim|xss_clean');

            if($this->input->post('complaint_source')=='0'){

               
              $this->form_validation->set_rules('order_no','Order No' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('order_tubes_hold','No. Of Tubes Hold' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('defective_tubes','Defective Tubes' ,'trim|xss_clean');

              $this->form_validation->set_rules('shift','Shift' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('machine','Machine name' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('operator','Responsible Person' ,'required|trim|xss_clean');


            }else{
                
              $this->form_validation->set_rules('invoice_no','Invoice No' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('invoice_tubes_checked','No. Of Tubes checked' ,'required|trim|xss_clean');

              $this->form_validation->set_rules('shift','Shift' ,'trim|xss_clean');
              $this->form_validation->set_rules('machine','Machine name' ,'trim|xss_clean');
              $this->form_validation->set_rules('operator','Responsible Person' ,'trim|xss_clean');
            }

            $this->form_validation->set_rules('article_no[]','Article No' ,'required|trim|xss_clean');
            
            $this->form_validation->set_rules('complaint_nature[]','Nature of Complaints' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('comment','Comment' ,'required|trim|xss_clean');

            if($this->input->post('is_pallet_checked')=='1'){
              $this->form_validation->set_rules('pallets','No Of Pallets' ,'required|trim|xss_clean');
            }
            if($this->input->post('is_box_checked')=='1'){
              $this->form_validation->set_rules('boxes','No Of Boxes' ,'required|trim|xss_clean');
            }

            $this->form_validation->set_rules('claim_inspection','Claim Inspection' ,'required|trim|xss_clean');
           
            //$this->form_validation->set_rules('complaint_status','Complaint Status' ,'required|trim|xss_clean');

            if(empty($_FILES['images']['name'][0])) {

              $this->form_validation->set_rules('images','Evidence' ,'trim|xss_clean');
            }

            if($this->form_validation->run()==FALSE){
              
              $data['capa_complaint_nature_master']=$this->common_model->select_active_drop_down('capa_complaint_nature_master',$this->session->userdata['logged_in']['company_id']);

              $data['springtube_shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);

              $data['coex_machine_master']=$this->common_model->select_active_drop_down('coex_machine_master',$this->session->userdata['logged_in']['company_id']);
            

              $data['capa_complaint_register_master']=$this->common_model->select_one_active_record('capa_complaint_register_master',$this->session->userdata['logged_in']['company_id'],'id',$this->input->post('id'));

              foreach ($data['capa_complaint_register_master'] as $key => $row) {
                if($row->complaint_source=='0'){
                  $data['article_no_result']=$this->common_model->select_one_details_record('order_details',$this->session->userdata['logged_in']['company_id'],'order_no',$row->reference_no);
                }
                else if($row->complaint_source=='1'){
                  $data['article_no_result']=$this->common_model->select_one_details_record('ar_invoice_details',$this->session->userdata['logged_in']['company_id'],'ar_invoice_no',$row->reference_no);
                }

              }

              
       
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
              $this->load->view('Home/footer');
            }else{ 

               
                
                $ref_no='';
                $customer='';
                $order_no='';
                $article_no='';
                $qty='';
                $tubes_hold_checked='';

                if($this->input->post('complaint_source')=='0'){
                  
                  $ref_no=$this->input->post('order_no');
                  $tubes_hold_checked=$this->input->post('order_tubes_hold');
                  
                  $order_master_result=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$ref_no);
                    foreach($order_master_result as $order_master_row){
                      $customer=$order_master_row->customer_no;                      
                    }

                    if(!empty($this->input->post('article_no[]')) && is_array($this->input->post('article_no[]'))){

                      foreach ($this->input->post('article_no[]')as $key => $value) {
                        
                        $data_order_details=array(
                        'order_no'=>$ref_no,
                        'article_no'=>$value                    
                        );

                        $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
                        foreach($order_details_result as $order_details_row){
                          $qty+=$this->common_model->read_number($order_details_row->total_order_quantity,$this->session->userdata['logged_in']['company_id']);
                        }
                      }

                      $article_no=implode(",", $this->input->post('article_no[]'));
                      
                    }

                    
                }else{

                  $ref_no=$this->input->post('invoice_no');
                  $tubes_hold_checked=$this->input->post('invoice_tubes_checked');

                  $ar_invoice_master_result=$this->common_model->select_one_active_record('ar_invoice_master',$this->session->userdata['logged_in']['company_id'],'ar_invoice_no',$ref_no);
                    foreach($ar_invoice_master_result as $ar_invoice_master_row){
                      $customer=$ar_invoice_master_row->customer_no;                      
                    }

                    if(!empty($this->input->post('article_no[]')) && is_array($this->input->post('article_no[]'))){

                      foreach ($this->input->post('article_no[]')as $key => $value) {
                        
                        $data_invoice_details=array(
                        'ar_invoice_no'=>$ref_no,
                        'article_no'=>$value                    
                        );

                        $invoice_details_result=$this->common_model->select_active_records_where('ar_invoice_details',$this->session->userdata['logged_in']['company_id'],$data_invoice_details);
                        foreach($invoice_details_result as $invoice_details_row){
                          $qty+=$this->common_model->read_number($invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
                        }
                      }

                      $article_no=implode(",", $this->input->post('article_no[]'));
                      
                    }
                }     
                      
                $pallets='';
                if($this->input->post('is_pallet_checked')=='1'){
                  $pallets=$this->input->post('pallets');
                }
                $boxes='';
                if($this->input->post('is_box_checked')=='1'){
                  $boxes=$this->input->post('boxes');
                } 
            



               // File Upload----------------------------------  

              $image_status='';
              $image_name=$this->input->post('image_name');
              $path = './assets/'.$this->session->userdata['logged_in']['company_id'].'/complaints/';

              if(!empty($_FILES['images']['name'][0])) {

                $image_status=$this->upload_files($path,$_FILES['images']);
                if(is_array($image_status)){
                  $image_name=implode(",", $image_status);
                }
                else if($image_status===FALSE){
                  $data['note']=$this->upload->display_errors();
                }                               

              }
              
            //if($image_name!=''){
              

              $complaint_nature=implode(",", $this->input->post('complaint_nature[]'));

              $data=array(
                           
                'email_date'=>$this->input->post('email_date'),                    
                'complaint_date'=>date('Y-m-d'),
                'customer'=>$customer,
                'complaint_source'=>$this->input->post('complaint_source'),
                'reference_no'=>$ref_no,
                'article_no'=>$article_no,
                'qty'=>$qty,
                'defective_tubes'=>$this->input->post('defective_tubes'),
                'tubes_hold_checked'=>$tubes_hold_checked,
                'complaint_nature'=>$complaint_nature, 
                'is_pallet_checked'=>(!empty($this->input->post('is_pallet_checked'))?1:0), 
                'pallets'=>$pallets,                
                'is_box_checked'=>(!empty($this->input->post('is_box_checked'))?1:0),
                'boxes'=>$boxes, 
                'claim_inspection'=>$this->input->post('claim_inspection'), 
                // 'complaint_status'=>$this->input->post('complaint_status'), 
                'comment'=>$this->input->post('comment'),                
                'images'=>$image_name,                
                'user_id'=>$this->session->userdata['logged_in']['user_id'],
                
                'shift'=>$this->input->post('shift'),
                'machine'=>$this->input->post('machine'),
                'operator'=>$this->input->post('operator')

              );

              $result=$this->common_model->update_one_active_record('capa_complaint_register_master',$data,'id',$this->input->post('id'),$this->session->userdata['logged_in']['company_id']); 

            //}

              if($result){
                $data['note']='Data Updated successfully.';
              }else{
                $data['error']='Error while Updating data.';
              } 

              $data['capa_complaint_register_master']=$this->common_model->select_one_active_record('capa_complaint_register_master',$this->session->userdata['logged_in']['company_id'],'id',$this->input->post('id'));
              foreach ($data['capa_complaint_register_master'] as $key => $row) {
                if($row->complaint_source==0){
                  $data['article_no_result']=$this->common_model->select_one_details_record('order_details',$this->session->userdata['logged_in']['company_id'],'order_no',$row->reference_no);
                }
                else if($row->complaint_source==1){
                  $data['article_no_result']=$this->common_model->select_one_details_record('ar_invoice_details',$this->session->userdata['logged_in']['company_id'],'ar_invoice_no',$row->reference_no);
                }

              }              

              header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
               
              $data['capa_complaint_nature_master']=$this->common_model->select_active_drop_down('capa_complaint_nature_master',$this->session->userdata['logged_in']['company_id']);
              
              $data['springtube_shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);

              $data['coex_machine_master']=$this->common_model->select_active_drop_down('coex_machine_master',$this->session->userdata['logged_in']['company_id']);
            

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

  function qc($id){
       
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->new=='1' && $formrights_row->copy=='1'){

              $data['workprocedure_types_master']=$this->common_model->select_active_drop_down('workprocedure_types_master',$this->session->userdata['logged_in']['company_id']);


              $data['capa_complaint_nature_master']=$this->common_model->select_active_drop_down('capa_complaint_nature_master',$this->session->userdata['logged_in']['company_id']);

             
              $data['capa_complaint_register_master']=$this->common_model->select_one_active_record('capa_complaint_register_master',$this->session->userdata['logged_in']['company_id'],'id',$id);

              $data['springtube_shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);

              $data['coex_machine_master']=$this->common_model->select_active_drop_down('coex_machine_master',$this->session->userdata['logged_in']['company_id']);
            

              //print_r($data['capa_complaint_register_master']);

              foreach ($data['capa_complaint_register_master'] as $key => $row) {
                if($row->complaint_source==0){
                  $data['article_no_result']=$this->common_model->select_one_details_record('order_details',$this->session->userdata['logged_in']['company_id'],'order_no',$row->reference_no);
                }
                else if($row->complaint_source==1){
                  $data['article_no_result']=$this->common_model->select_one_details_record('ar_invoice_details',$this->session->userdata['logged_in']['company_id'],'ar_invoice_no',$row->reference_no);
                }

              }

              
             // echo $this->db->last_query();

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/qc-form',$data);
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

  function qc_save(){
  
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {

          if($formrights_row->new=='1' && $formrights_row->copy=='1'){            
             

            $this->form_validation->set_rules('id','Primary Key' ,'required|trim|xss_clean');
           
            $this->form_validation->set_rules('hourly_samples_check','hourly_samples_check' ,'trim|xss_clean');
            $this->form_validation->set_rules('retention_samples_check','retention_samples_check' ,'trim|xss_clean');
            $this->form_validation->set_rules('bpr_check','bpr_check' ,'trim|xss_clean');
            $this->form_validation->set_rules('samples_recieved','samples_recieved' ,'trim|xss_clean');
            $this->form_validation->set_rules('stage_problem_occurance','stage_problem_occurance' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('any_known_problem','any_known_problem' ,'trim|xss_clean');
            $this->form_validation->set_rules('investigation','investigation' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('root_cause','Root cause' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('corrective_action','Corrective action' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('corrective_action_date','corrective_action_date' ,'required|trim|xss_clean');
              
            $this->form_validation->set_rules('preventive_action','preventive_action' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('preventive_action_date','preventive_action_date' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('is_training_provided','is_training_provided' ,'trim|xss_clean');
            
            $this->form_validation->set_rules('verification_of_effectiveness','verification_of_effectiveness' ,'trim|xss_clean');
            $this->form_validation->set_rules('effectiveness_action_taken','effectiveness_action_taken' ,'trim|xss_clean');
            $this->form_validation->set_rules('poor_quality_cost','poor_quality_cost' ,'required|trim|xss_clean');

            if($this->input->post('is_training_provided')=='1'){
              $this->form_validation->set_rules('training_date','training_date' ,'required|trim|xss_clean');
              if (empty($_FILES['training_doc']['name'])){                
                $this->form_validation->set_rules('training_doc','Training Doc' ,'required');
              }
              
            }

            
            $this->form_validation->set_rules('complaint_status','Complaint Status' ,'required|trim|xss_clean');

             
            if($this->form_validation->run()==FALSE){

              $data['workprocedure_types_master']=$this->common_model->select_active_drop_down('workprocedure_types_master',$this->session->userdata['logged_in']['company_id']);
              
              $data['capa_complaint_nature_master']=$this->common_model->select_active_drop_down('capa_complaint_nature_master',$this->session->userdata['logged_in']['company_id']);

              $data['capa_complaint_register_master']=$this->common_model->select_one_active_record('capa_complaint_register_master',$this->session->userdata['logged_in']['company_id'],'id',$this->input->post('id'));

              $data['springtube_shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);

              $data['coex_machine_master']=$this->common_model->select_active_drop_down('coex_machine_master',$this->session->userdata['logged_in']['company_id']);
            


              foreach ($data['capa_complaint_register_master'] as $key => $row) {
                if($row->complaint_source==0){
                  $data['article_no_result']=$this->common_model->select_one_details_record('order_details',$this->session->userdata['logged_in']['company_id'],'order_no',$row->reference_no);
                }
                else if($row->complaint_source==1){
                  $data['article_no_result']=$this->common_model->select_one_details_record('ar_invoice_details',$this->session->userdata['logged_in']['company_id'],'ar_invoice_no',$row->reference_no);
                }

              }

              
       
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/qc-form',$data);
              $this->load->view('Home/footer');
            }else{                
                
                       
                $training_date='';
                $training_doc_file_name='';
                if($this->input->post('is_training_provided')=='1'){

                  $training_date=$this->input->post('training_date');

                  $config['upload_path'] = './assets/'.$this->session->userdata['logged_in']['company_id'].'/complaints/';
                  $config['allowed_types'] = 'pdf|PDF|jpeg|JPEG|jpg|JPG|png|PNG';
                  $config['max_size'] = '0';

                  //Filename------------
                  $fileExt = pathinfo($_FILES['training_doc']['name'], PATHINFO_EXTENSION);
                  $fileName=time().'.'.$fileExt;
                  $config['file_name'] =$fileName; 
                  
                  $this->load->library('upload',$config);
                  $this->upload->initialize($config);


                  if($this->upload->do_upload('training_doc')){                  
                                         
                      $data= $this->upload->data();
                      $training_doc_file_name=$fileName;

                  }else{
                     echo $this->upload->display_errors();
                  } 
                }
            
              if(!empty($this->input->post('id'))){

                $data=array(
                  'qc_check'=>1,
                  'qc_date'=>date('Y-m-d'),
                  'qc_name'=>$this->session->userdata['logged_in']['user_id'],
                  'hourly_samples_check'=>$this->input->post('hourly_samples_check'),
                  'retention_samples_check'=>$this->input->post('retention_samples_check'),
                  'bpr_check'=>$this->input->post('bpr_check'),
                  'samples_recieved'=>$this->input->post('samples_recieved'),
                  'stage_problem_occurance'=>$this->input->post('stage_problem_occurance'),
                  'any_known_problem'=>$this->input->post('any_known_problem'),
                  'investigation'=>$this->input->post('investigation'),
                  'root_cause'=>$this->input->post('root_cause'),
                  'corrective_action'=>$this->input->post('corrective_action'),
                  'corrective_action_date'=>$this->input->post('corrective_action_date'),
                  'preventive_action'=>$this->input->post('preventive_action'),
                  'preventive_action_date'=>$this->input->post('preventive_action_date'),
                  'is_training_provided'=>(!empty($this->input->post('is_training_provided'))?1:0),
                  'training_date'=>$training_date,
                  'training_docs'=>$training_doc_file_name,
                  'verification_of_effectiveness'=>$this->input->post('verification_of_effectiveness'),
                  'effectiveness_action_taken'=>$this->input->post('effectiveness_action_taken'),
                  'poor_quality_cost'=>$this->input->post('poor_quality_cost'),
                  'complaint_status'=>$this->input->post('complaint_status'), 
                  'modify_date'=>date('Y-m-d H:i:s')
                   
                );

                $result=$this->common_model->update_one_active_record('capa_complaint_register_master',$data,'id',$this->input->post('id'),$this->session->userdata['logged_in']['company_id']); 

            }

              if($result){
                $data['note']='Data Saved successfully.';
              }else{
                $data['error']='Error while Saving data.';
              } 

              $data['springtube_shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);

              $data['coex_machine_master']=$this->common_model->select_active_drop_down('coex_machine_master',$this->session->userdata['logged_in']['company_id']);        


              $data['capa_complaint_register_master']=$this->common_model->select_one_active_record('capa_complaint_register_master',$this->session->userdata['logged_in']['company_id'],'id',$this->input->post('id'));
              foreach ($data['capa_complaint_register_master'] as $key => $row) {
                if($row->complaint_source==0){
                  $data['article_no_result']=$this->common_model->select_one_details_record('order_details',$this->session->userdata['logged_in']['company_id'],'order_no',$row->reference_no);
                }
                else if($row->complaint_source==1){
                  $data['article_no_result']=$this->common_model->select_one_details_record('ar_invoice_details',$this->session->userdata['logged_in']['company_id'],'ar_invoice_no',$row->reference_no);
                }

              }              

              header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
               
              $data['capa_complaint_nature_master']=$this->common_model->select_active_drop_down('capa_complaint_nature_master',$this->session->userdata['logged_in']['company_id']);

              $data['workprocedure_types_master']=$this->common_model->select_active_drop_down('workprocedure_types_master',$this->session->userdata['logged_in']['company_id']);
              

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/qc-form',$data);
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

  function qc_modify($id){
       
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify=='1' && $formrights_row->copy=='1'){

              $data['capa_complaint_nature_master']=$this->common_model->select_active_drop_down('capa_complaint_nature_master',$this->session->userdata['logged_in']['company_id']);

             
              $data['capa_complaint_register_master']=$this->common_model->select_one_active_record('capa_complaint_register_master',$this->session->userdata['logged_in']['company_id'],'id',$id);

              $data['springtube_shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);

              $data['coex_machine_master']=$this->common_model->select_active_drop_down('coex_machine_master',$this->session->userdata['logged_in']['company_id']);
            


              //print_r($data['capa_complaint_register_master']);

              foreach ($data['capa_complaint_register_master'] as $key => $row) {
                if($row->complaint_source==0){
                  $data['article_no_result']=$this->common_model->select_one_details_record('order_details',$this->session->userdata['logged_in']['company_id'],'order_no',$row->reference_no);
                }
                else if($row->complaint_source==1){
                  $data['article_no_result']=$this->common_model->select_one_details_record('ar_invoice_details',$this->session->userdata['logged_in']['company_id'],'ar_invoice_no',$row->reference_no);
                }

              }

              
             // echo $this->db->last_query();

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/qc-modify-form',$data);
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
  function qc_update(){
  
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {

          if($formrights_row->modify=='1' && $formrights_row->copy=='1'){            
             

            $this->form_validation->set_rules('id','Primary Key' ,'required|trim|xss_clean');
           
            $this->form_validation->set_rules('hourly_samples_check','hourly_samples_check' ,'trim|xss_clean');
            $this->form_validation->set_rules('retention_samples_check','retention_samples_check' ,'trim|xss_clean');
            $this->form_validation->set_rules('bpr_check','bpr_check' ,'trim|xss_clean');
            $this->form_validation->set_rules('samples_recieved','samples_recieved' ,'trim|xss_clean');
            $this->form_validation->set_rules('stage_problem_occurance','stage_problem_occurance' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('any_known_problem','any_known_problem' ,'trim|xss_clean');
            $this->form_validation->set_rules('investigation','investigation' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('root_cause','root_cause' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('corrective_action','corrective_action' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('preventive_action','preventive_action' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('is_training_provided','is_training_provided' ,'trim|xss_clean');
            
            $this->form_validation->set_rules('verification_of_effectiveness','verification_of_effectiveness' ,'trim|xss_clean');
            $this->form_validation->set_rules('effectiveness_action_taken','effectiveness_action_taken' ,'trim|xss_clean');
            $this->form_validation->set_rules('poor_quality_cost','poor_quality_cost' ,'required|trim|xss_clean');

            if($this->input->post('is_training_provided')=='1'){
              $this->form_validation->set_rules('training_date','training_date' ,'required|trim|xss_clean');              
              
            }

             
            if($this->form_validation->run()==FALSE){
              
              $data['capa_complaint_nature_master']=$this->common_model->select_active_drop_down('capa_complaint_nature_master',$this->session->userdata['logged_in']['company_id']);

              $data['capa_complaint_register_master']=$this->common_model->select_one_active_record('capa_complaint_register_master',$this->session->userdata['logged_in']['company_id'],'id',$this->input->post('id'));

              $data['springtube_shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);

              $data['coex_machine_master']=$this->common_model->select_active_drop_down('coex_machine_master',$this->session->userdata['logged_in']['company_id']);
            


              foreach ($data['capa_complaint_register_master'] as $key => $row) {
                if($row->complaint_source==0){
                  $data['article_no_result']=$this->common_model->select_one_details_record('order_details',$this->session->userdata['logged_in']['company_id'],'order_no',$row->reference_no);
                }
                else if($row->complaint_source==1){
                  $data['article_no_result']=$this->common_model->select_one_details_record('ar_invoice_details',$this->session->userdata['logged_in']['company_id'],'ar_invoice_no',$row->reference_no);
                }

              }

              
       
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/qc-modify-form',$data);
              $this->load->view('Home/footer');
            }else{                
                
                       
              // $training_date='';
              // if($this->input->post('is_training_provided')=='1'){
              //   $training_date=$this->input->post('training_date');
              // } 

                $training_date='';
                $training_doc_file_name='';
                
                if($this->input->post('is_training_provided')=='1'){

                  $training_date=$this->input->post('training_date');
                  $training_doc_file_name=$this->input->post('training_doc');

                  if(!empty($_FILES['training_doc']['name'])){

                    
                    $config['upload_path'] = './assets/'.$this->session->userdata['logged_in']['company_id'].'/complaints/';
                    $config['allowed_types'] = 'pdf|PDF|jpeg|JPEG|jpg|JPG|png|PNG';
                    $config['max_size'] = '0';

                    //Filename------------
                    $fileExt = pathinfo($_FILES['training_doc']['name'], PATHINFO_EXTENSION);
                    $fileName=time().'.'.$fileExt;
                    $config['file_name'] =$fileName; 
                  
                    $this->load->library('upload',$config);
                    $this->upload->initialize($config);


                    if($this->upload->do_upload('training_doc')){                  
                                           
                        $data= $this->upload->data();
                        $training_doc_file_name=$fileName;

                    }else{
                       echo $this->upload->display_errors();
                    }

                  }

                   
                }
  

            
              if(!empty($this->input->post('id'))){

                $data=array(
                  'qc_check'=>1,
                  'qc_date'=>date('Y-m-d'),
                  'qc_name'=>$this->session->userdata['logged_in']['user_id'],
                  'hourly_samples_check'=>$this->input->post('hourly_samples_check'),
                  'retention_samples_check'=>$this->input->post('retention_samples_check'),
                  'bpr_check'=>$this->input->post('bpr_check'),
                  'samples_recieved'=>$this->input->post('samples_recieved'),
                  'stage_problem_occurance'=>$this->input->post('stage_problem_occurance'),
                  'any_known_problem'=>$this->input->post('any_known_problem'),
                  'investigation'=>$this->input->post('investigation'),
                  'root_cause'=>$this->input->post('root_cause'),
                  'corrective_action'=>$this->input->post('corrective_action'),
                  'preventive_action'=>$this->input->post('preventive_action'),
                  'is_training_provided'=>(!empty($this->input->post('is_training_provided'))?1:0),
                  'training_date'=>$training_date,                  
                  'training_docs'=>$training_doc_file_name,                                   
                  'verification_of_effectiveness'=>$this->input->post('verification_of_effectiveness'),
                  'effectiveness_action_taken'=>$this->input->post('effectiveness_action_taken'),
                  'poor_quality_cost'=>$this->input->post('poor_quality_cost'),                  
                  'modify_date'=>date('Y-m-d H:i:s'),
                  'complaint_status'=>$this->input->post('complaint_status')
                   
                );

                $result=$this->common_model->update_one_active_record('capa_complaint_register_master',$data,'id',$this->input->post('id'),$this->session->userdata['logged_in']['company_id']); 

            }

              if($result){
                $data['note']='Data updated successfully.';
              }else{
                $data['error']='Error while Updating data.';
              } 

              $data['capa_complaint_register_master']=$this->common_model->select_one_active_record('capa_complaint_register_master',$this->session->userdata['logged_in']['company_id'],'id',$this->input->post('id'));
              foreach ($data['capa_complaint_register_master'] as $key => $row) {
                if($row->complaint_source==0){
                  $data['article_no_result']=$this->common_model->select_one_details_record('order_details',$this->session->userdata['logged_in']['company_id'],'order_no',$row->reference_no);
                }
                else if($row->complaint_source==1){
                  $data['article_no_result']=$this->common_model->select_one_details_record('ar_invoice_details',$this->session->userdata['logged_in']['company_id'],'ar_invoice_no',$row->reference_no);
                }

              }              

              header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
               
              $data['capa_complaint_nature_master']=$this->common_model->select_active_drop_down('capa_complaint_nature_master',$this->session->userdata['logged_in']['company_id']);

              $data['springtube_shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);

              $data['coex_machine_master']=$this->common_model->select_active_drop_down('coex_machine_master',$this->session->userdata['logged_in']['company_id']);
            


              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/qc-modify-form',$data);
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

  function delete($id){
       
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

              $data=array('archive'=>1);
              $result=$this->common_model->update_one_active_record('capa_complaint_register_master',$data,'id',$id,$this->session->userdata['logged_in']['company_id']);

              $data['capa_complaint_nature_master']=$this->common_model->select_active_drop_down('capa_complaint_nature_master',$this->session->userdata['logged_in']['company_id']);

              $data['springtube_shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);

              $data['coex_machine_master']=$this->common_model->select_active_drop_down('coex_machine_master',$this->session->userdata['logged_in']['company_id']);
            

             
              $data['capa_complaint_register_master']=$this->common_model->select_one_inactive_record('capa_complaint_register_master',$this->session->userdata['logged_in']['company_id'],'id',$id);

              //print_r($data['capa_complaint_register_master']);

              foreach ($data['capa_complaint_register_master'] as $key => $row) {
                if($row->complaint_source==0){
                  $data['article_no_result']=$this->common_model->select_one_details_record('order_details',$this->session->userdata['logged_in']['company_id'],'order_no',$row->reference_no);
                }
                else if($row->complaint_source==1){
                  $data['article_no_result']=$this->common_model->select_one_details_record('ar_invoice_details',$this->session->userdata['logged_in']['company_id'],'ar_invoice_no',$row->reference_no);
                }

              }

              if($result){
                $data['note']='Record archived successfully.';
              }else{
                $data['error']='Error while archiving data.';
              } 

              header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
               
              $data['capa_complaint_nature_master']=$this->common_model->select_active_drop_down('capa_complaint_nature_master',$this->session->userdata['logged_in']['company_id']);

              
             // echo $this->db->last_query();

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/qc-modify-form',$data);
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
  function dearchive($id){
       
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

              $data=array('archive'=>0);
              $result=$this->common_model->update_one_active_record('capa_complaint_register_master',$data,'id',$id,$this->session->userdata['logged_in']['company_id']);

              $data['capa_complaint_nature_master']=$this->common_model->select_active_drop_down('capa_complaint_nature_master',$this->session->userdata['logged_in']['company_id']);

              $data['springtube_shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);

              $data['coex_machine_master']=$this->common_model->select_active_drop_down('coex_machine_master',$this->session->userdata['logged_in']['company_id']);
            

             
              $data['capa_complaint_register_master']=$this->common_model->select_one_active_record('capa_complaint_register_master',$this->session->userdata['logged_in']['company_id'],'id',$id);

              //print_r($data['capa_complaint_register_master']);

              foreach ($data['capa_complaint_register_master'] as $key => $row) {
                if($row->complaint_source==0){
                  $data['article_no_result']=$this->common_model->select_one_details_record('order_details',$this->session->userdata['logged_in']['company_id'],'order_no',$row->reference_no);
                }
                else if($row->complaint_source==1){
                  $data['article_no_result']=$this->common_model->select_one_details_record('ar_invoice_details',$this->session->userdata['logged_in']['company_id'],'ar_invoice_no',$row->reference_no);
                }

              }

              if($result){
                $data['note']='Record dearchived successfully.';
              }else{
                $data['error']='Error while dearchiving data.';
              } 

              header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
               
              $data['capa_complaint_nature_master']=$this->common_model->select_active_drop_down('capa_complaint_nature_master',$this->session->userdata['logged_in']['company_id']);

              
             // echo $this->db->last_query();

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/qc-modify-form',$data);
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
   
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            
            $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

            $data['capa_complaint_nature_master']=$this->common_model->select_active_drop_down('capa_complaint_nature_master',$this->session->userdata['logged_in']['company_id']);

            $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);


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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
           
            $this->form_validation->set_rules('customer','Customer' ,'trim|xss_clean|max_length[150]|strtoupper|callback_customer_check');
             $this->form_validation->set_rules('article_no','Article No' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('from_date','From Date' ,'required|trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('to_date','To Date' ,'required|trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('complaint_no','Complaint no' ,'trim|xss_clean');

            $this->form_validation->set_rules('order_no','Sales order' ,'trim|xss_clean');
            $this->form_validation->set_rules('invoice_no','Invoice no' ,'trim|xss_clean');
            $this->form_validation->set_rules('complaint_source','Complaint Source' ,'trim|xss_clean');
            $this->form_validation->set_rules('claim_inspection','Claim Inspection' ,'trim|xss_clean');
            $this->form_validation->set_rules('complaint_status','Complaint Status' ,'trim|xss_clean');
              
            
            if($this->form_validation->run()==FALSE){

              $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

              $data['capa_complaint_nature_master']=$this->common_model->select_active_drop_down('capa_complaint_nature_master',$this->session->userdata['logged_in']['company_id']);

              $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);

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

              if(!empty($this->input->post('complaint_no'))){
                 $search['complaint_no']=$this->input->post('complaint_no');
              }
              if(!empty($this->input->post('customer'))){
                 $arr=explode('//',$this->input->post('customer'));
                 $search['customer']=$arr[1];
              }
              if(!empty($this->input->post('article_no'))){
                 $arr_article=explode('//',$this->input->post('article_no'));                
                 $search['article_no']=$arr_article[1];
              }
              if(!empty($this->input->post('order_no'))){
                 $search['reference_no']=$this->input->post('order_no');
              }
              if(!empty($this->input->post('invoice_no'))){
                 $search['reference_no']=$this->input->post('invoice_no');
              }
              if($this->input->post('complaint_source')!=''){
                 $search['complaint_source']=$this->input->post('complaint_source');
              }
              echo $this->input->post('complaint_nature');
              if(!empty($this->input->post('complaint_nature'))){
                 $search['complaint_nature']=$this->input->post('complaint_nature');
              }

              if(!empty($this->input->post('claim_inspection'))){
                 $search['claim_inspection']=$this->input->post('claim_inspection');
              }

              if(!empty($this->input->post('complaint_status'))){
                 $search['complaint_status']=$this->input->post('complaint_status');
              }

              //print_r($search);
               
              //$search_data=array_filter($search);
              $search_data=$search;
                  
              $data['capa_complaint_register_master']=$this->complaint_register_model->active_record_search('capa_complaint_register_master',$search_data,$from,$to,$this->session->userdata['logged_in']['company_id'] );

              //echo $this->db->last_query();               
              //print_r($data['capa_complaint_register_master']);
                 
              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

              $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
                
              $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);

              $data['capa_complaint_nature_master']=$this->common_model->select_active_drop_down('capa_complaint_nature_master',$this->session->userdata['logged_in']['company_id']);
                  
              //$data['error']='No record in search transaction';
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
              $this->load->view('Home/footer');
            
                
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

  function upload_files($path,$files){
        //echo'function started';

        $config = array(
            'upload_path'   => $path,
            'max_size'      =>150000,
            'remove_spaces' =>TRUE,
            'allowed_types' => 'pdf|PDF|jpeg|JPEG|jpg|JPG|png|PNG|mp4|MP4'           

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

  function view($id){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

            $qc_date='';

            $data['company']=$this->common_model->select_one_active_record('company_master',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);
            $data['company_details']=$this->common_model->select_one_active_record('company_system_parameters',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);

            //$data['capa_complaint_nature_master']=$this->common_model->select_active_drop_down('capa_complaint_nature_master',$this->session->userdata['logged_in']['company_id']);

             
            $data['capa_complaint_register_master']=$this->common_model->select_one_active_record('capa_complaint_register_master',$this->session->userdata['logged_in']['company_id'],'id',$id);

              //print_r($data['capa_complaint_register_master']);

              foreach ($data['capa_complaint_register_master'] as $key => $row) {
                $qc_date=$row->qc_date;
                if($row->complaint_source==0){
                  $data['article_no_result']=$this->common_model->select_one_details_record('order_details',$this->session->userdata['logged_in']['company_id'],'order_no',$row->reference_no);
                }
                else if($row->complaint_source==1){
                  $data['article_no_result']=$this->common_model->select_one_details_record('ar_invoice_details',$this->session->userdata['logged_in']['company_id'],'ar_invoice_no',$row->reference_no);
                }

              }
             
             
            
            $data['page_name']='Sales';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
            $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

            //$this->load->view('Home/header');
            //$this->load->view('Home/nav',$data);
            //$this->load->view('Home/subnav');
            $data['doc']=array('doc_no'=>'Doc. No : QC/F/23','rev_no'=>'4','date'=>$qc_date);

            $this->load->view('Print/header-docno',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/view-form-new',$data);
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




 
  
}