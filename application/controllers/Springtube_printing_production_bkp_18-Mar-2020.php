<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Springtube_printing_production extends CI_Controller {

  function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('sales_order_book_model');
      $this->load->model('sales_order_status_model');
      $this->load->model('artwork_springtube_model');
      $this->load->model('springtube_printing_production_model');
      $this->load->model('job_card_model');
      
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

              $table='springtube_printing_production_master';
              include('pagination.php');
              $data['springtube_printing_production_master']=$this->springtube_printing_production_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
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
    
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->new==1){


              $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);
             //echo $this->db->last_query();
              $dataa = array('process_id' =>'2');
              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

              $data['springtube_printing_jobtype_master']=$this->common_model->select_active_drop_down('springtube_printing_jobtype_master',$this->session->userdata['logged_in']['company_id']);
               


              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
             
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
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

  function start_job(){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {

          if($formrights_row->new==1){

        
            $this->form_validation->set_rules('production_date','Production Date' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('jobcard_no','Jobcard no' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('shift','Shift' ,'trim|xss_clean|callback_printing_shift_check');
            $this->form_validation->set_rules('machine','Machine' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('job_type','Job Type' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('job_category','Job Category' ,'required|trim|xss_clean');
                       
           
            if($this->form_validation->run()==FALSE){

              $data=array('status'=>false,'message'=>validation_errors(),'production_id'=>0);

              echo  json_encode($data);         
            
              
            }else{              

                $customer='';
                $order_no='';
                $article_no='';
                $ad_id='';
                $version_no='';
                $dia='';
                $length='';
                $print_type='';
                $laminate_color='';
                $body_making_type='';

                $jobcard_no= $this->input->post('jobcard_no');
                $production_date= $this->input->post('production_date'); 
                $shift= $this->input->post('shift');
                $machine= $this->input->post('machine');
                $job_type= $this->input->post('job_type');
                $job_category= $this->input->post('job_category');

                

                $production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no', $jobcard_no);
              
                foreach($production_master_result as $row) {
                  $order_no=$row->sales_ord_no;
                  $article_no=$row->article_no;
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
                  $ad_id=$order_details_row->ad_id;
                  $version_no=$order_details_row->version_no;
                  $bom_no=$order_details_row->spec_id;
                  $bom_version_no=$order_details_row->spec_version_no;
                }

                //Artwork Deatils-------------------------

                $data=array('ad_id'=>$ad_id,
                    'version_no'=>$version_no
                      );
                $springtube_artwork_result=$this->artwork_springtube_model->active_record_search_new('springtube_artwork_devel_master',$data,'','','',$this->session->userdata['logged_in']['company_id']);

                foreach ($springtube_artwork_result as $springtube_artwork_row) {
                  $body_making_type=$springtube_artwork_row->body_making_type;
                  $print_type=$springtube_artwork_row->print_type;
                  $dia=$springtube_artwork_row->sleeve_dia;
                  $length=$springtube_artwork_row->sleeve_length;
                  $laminate_color=$springtube_artwork_row->laminate_color;
                }

                
                $production_time=date('H:i:s');
                $production_date=date('Y-m-d');               

                $data=array(
                  'company_id'=>$this->session->userdata['logged_in']['company_id'],
                  'production_date'=>$production_date,
                  'shift'=>$shift,                                       
                  'process_id'=>'2',
                  'machine_id'=>$this->input->post('machine'),
                  'jobcard_no'=>$this->input->post('jobcard_no'),
                  'customer'=>$customer,
                  'order_no'=>$order_no,
                  'article_no'=>$article_no,
                  'sleeve_dia'=>$dia,
                  'sleeve_length'=>$length,
                  'print_type'=>$print_type,
                  'laminate_color'=>$laminate_color,
                  'body_making_type'=>$body_making_type,
                  'job_type'=>$this->input->post('job_type'),
                  'job_category'=>$this->input->post('job_category'),                                                     
                  'user_id'=>$this->session->userdata['logged_in']['user_id'],
                  'created_date'=>date('Y-m-d H:i:s'),
                  'production_time'=>date('H:i:s'),
                  'job_started_flag'=>1,
                  'job_started_on'=>date('Y-m-d H:i:s'),
                  );

                  $production_id=$this->common_model->save_return_pkey('springtube_printing_production_master',$data);
                  
                  $data=array('status'=>true,'message'=>'Job Started successfully!','production_id'=>$production_id);
                  echo  json_encode($data);         
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

  function save_counter(){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          
          if($formrights_row->new==1){

            $this->form_validation->set_rules('production_id','Production Id' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('jobcard_no','Jobcard no' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('counter','Counter' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('stop_reason','Stop reason' ,'required|trim|xss_clean');
                       
              $total_counter='';
              $pending_counter='';
              $jobcard_qty='';


            if($this->form_validation->run()==FALSE){

              $data_total_counter=array(                  
                'jobcard_no'=>$this->input->post('jobcard_no')                        
              );

              $result_total_counter=$this->springtube_printing_production_model->select_total_counter('springtube_printing_production_master',$data_total_counter);
              foreach ($result_total_counter as  $total_counter_row) {
                    $total_counter=$total_counter_row->total_counter;
              }

              $pending_counter=round($jobcard_qty/2)-$total_counter;

              $data=array('status'=>false,'message'=>validation_errors(),'pending_counter'=>0,'data'=>null);

              echo  json_encode($data);         
            
              
            }else{              

                
                //$jobcard_no= $this->input->post('jobcard_no');
                //$production_id= $this->input->post('production_id'); 
                $counter= $this->input->post('counter');
                $stop_reason= $this->input->post('stop_reason');
                //
                

                $production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no', $this->input->post('jobcard_no'));
              
                foreach($production_master_result as $row) {
                  $order_no=$row->sales_ord_no;
                  $article_no=$row->article_no;
                  $jobcard_qty=$this->common_model->read_number($row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']);
                }                          
                             

                $data=array(                  
                  'production_id'=>$this->input->post('production_id'),                 
                  'jobcard_no'=>$this->input->post('jobcard_no'),
                  'counter'=>$this->input->post('counter'),
                  'stop_reason'=>$this->input->post('stop_reason')                  
                  );

                $result=$this->common_model->save('springtube_printing_production_details',$data);

                if($result){

                  $data=array(                  
                  'production_id'=>$this->input->post('production_id'),                 
                  'jobcard_no'=>$this->input->post('jobcard_no')                        
                  );

                  $result_counter=$this->springtube_printing_production_model->active_details_records('springtube_printing_production_details',$data);

                  $data_total_counter=array(                  
                  'jobcard_no'=>$this->input->post('jobcard_no')                        
                  );

                  $result_total_counter=$this->springtube_printing_production_model->select_total_counter('springtube_printing_production_master',$data_total_counter);
                  foreach ($result_total_counter as  $total_counter_row) {
                      $total_counter=$total_counter_row->total_counter;
                  }

                  $pending_counter=round($jobcard_qty/2)-$total_counter;

                  $data=array('status'=>true,'message'=>'Counter Saved successfully!','pending_counter'=>$pending_counter,'total_counter'=>$total_counter,'details_data'=>$result_counter);
                  echo  json_encode($data);
                }  
                           
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

  function job_end(){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          
          if($formrights_row->new==1){

            $this->form_validation->set_rules('production_id','Production Id' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('jobcard_no','Jobcard no' ,'required|trim|xss_clean');
          
            if($this->form_validation->run()==FALSE){

               $data=array('status'=>false,'message'=>validation_errors());
                  echo  json_encode($data);      
            
              
            }else{                                         

              $data=array('printing_done'=>1);

              $result=$this->common_model->update_one_active_record('production_master',$data,'mp_pos_no',$this->input->post('jobcard_no'),$this->session->userdata['logged_in']['company_id']);

              $data=array('job_ended_flag'=>1,'job_ended_on'=>date('Y-m-d h:i:s'));

              $result=$this->common_model->update_one_active_record('springtube_printing_production_master',$data,'production_id',$this->input->post('production_id'),$this->session->userdata['logged_in']['company_id']);



              if($result){

                $data=array('status'=>true,'message'=>'Job ended successfully!');
                  echo  json_encode($data);

              }else{

                  $data=array('status'=>false,'message'=>'Error in ending Job!');
                  echo  json_encode($data);

              }

                 
                           
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


    function shift_end(){

    $production_id=$this->input->post('production_id');

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          
          if($formrights_row->new==1){

            $this->form_validation->set_rules('production_id','Production Id' ,'required|trim|xss_clean');
            //$this->form_validation->set_rules('jobcard_no','Jobcard no' ,'required|trim|xss_clean');
          
            if($this->form_validation->run()==FALSE){

              $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);
             //echo $this->db->last_query();
              $dataa = array('process_id' =>'2');

              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

              $data['springtube_printing_jobtype_master']=$this->common_model->select_active_drop_down('springtube_printing_jobtype_master',$this->session->userdata['logged_in']['company_id']); 

              $table='springtube_printing_production_master';
              $data['springtube_printing_production_master']=$this->springtube_printing_production_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'springtube_printing_production_master.production_id',$production_id);

              $dataa=array('production_id'=>$production_id);
              $table='springtube_printing_production_details';
              $data['springtube_printing_production_details']=$this->springtube_printing_production_model->active_details_records($table,$dataa);
              
             // echo $this->db->last_query();          


              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
             
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
              $this->load->view('Home/footer');        
            
              
            }else{                                         

              $data=array(
                'shift_break'=>date('Y-m-d H:i:s')
              );

              $result=$this->common_model->update_one_active_record('springtube_printing_production_master',$data,'production_id',$this->input->post('production_id'),$this->session->userdata['logged_in']['company_id']);

              $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);
             //echo $this->db->last_query();
              $dataa = array('process_id' =>'2');

              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

              $data['springtube_printing_jobtype_master']=$this->common_model->select_active_drop_down('springtube_printing_jobtype_master',$this->session->userdata['logged_in']['company_id']); 

              $table='springtube_printing_production_master';
              $data['springtube_printing_production_master']=$this->springtube_printing_production_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'springtube_printing_production_master.production_id',$production_id);

              $dataa=array('production_id'=>$production_id);
              $table='springtube_printing_production_details';
              $data['springtube_printing_production_details']=$this->springtube_printing_production_model->active_details_records($table,$dataa);
              
             // echo $this->db->last_query();            

              $data['note']='Shift entry saved Successfully';

              header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

              
              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
               
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

  function modify($production_id){
       
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){

              $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);
             //echo $this->db->last_query();
              $dataa = array('process_id' =>'2');

              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

              $data['springtube_printing_jobtype_master']=$this->common_model->select_active_drop_down('springtube_printing_jobtype_master',$this->session->userdata['logged_in']['company_id']); 

              $table='springtube_printing_production_master';
              $data['springtube_printing_production_master']=$this->springtube_printing_production_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'springtube_printing_production_master.production_id',$production_id);

              //echo $this->db->last_query();

              $dataa=array('production_id'=>$production_id);
              $table='springtube_printing_production_details';
              $data['springtube_printing_production_details']=$this->springtube_printing_production_model->active_details_records($table,$dataa);
              
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

              $table='springtube_printing_production_master';
              include('pagination_archive.php');
              $data['springtube_printing_production_master']=$this->springtube_printing_production_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
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

  function delete($production_id){

      $data['page_name']='Production';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

              $data=array('archive'=>'1');

              $result=$this->common_model->update_one_active_record('springtube_printing_production_master',$data,'production_id',$production_id,$this->session->userdata['logged_in']['company_id']);
              
         
              $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);
              //echo $this->db->last_query();
              $dataa = array('process_id' =>'2');

              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

              $data['springtube_printing_jobtype_master']=$this->common_model->select_active_drop_down('springtube_printing_jobtype_master',$this->session->userdata['logged_in']['company_id']); 

              $table='springtube_printing_production_master';
              $data['springtube_printing_production_master']=$this->springtube_printing_production_model->select_one_inactive_record($table,$this->session->userdata['logged_in']['company_id'],'springtube_printing_production_master.production_id',$production_id);

              

              $dataa=array('production_id'=>$production_id);
              $table='springtube_printing_production_details';
              $data['springtube_printing_production_details']=$this->springtube_printing_production_model->active_details_records($table,$dataa); 

              //echo $this->db->last_query();
                
              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());                  

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


     function dearchive($production_id){

      $data['page_name']='Production';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

              $data=array('archive'=>'2');

              $result=$this->common_model->update_one_active_record('springtube_printing_production_master',$data,'production_id',$production_id,$this->session->userdata['logged_in']['company_id']);

              $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);
              //echo $this->db->last_query();
              $dataa = array('process_id' =>'2');

              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

              $data['springtube_printing_jobtype_master']=$this->common_model->select_active_drop_down('springtube_printing_jobtype_master',$this->session->userdata['logged_in']['company_id']); 

              $table='springtube_printing_production_master';
              $data['springtube_printing_production_master']=$this->springtube_printing_production_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'springtube_printing_production_master.production_id',$production_id);

              $dataa=array('production_id'=>$production_id);
              $table='springtube_printing_production_details';
              $data['springtube_printing_production_details']=$this->springtube_printing_production_model->active_details_records($table,$dataa);  
                
              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());                  

              $data['note']='Dearchive Transaction completed';
              //header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

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
    function view(){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

            $data['company']=$this->common_model->select_one_active_record('company_master',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);
            
            $data['company_details']=$this->common_model->select_one_active_record('company_system_parameters',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);

            $data['springtube_printing_production_master']=$this->springtube_printing_production_model->select_one_active_record('springtube_printing_production_master',$this->session->userdata['logged_in']['company_id'],'springtube_printing_production_master.production_id',$this->uri->segment(3));

            
            $dataa=array('production_id'=>$this->uri->segment(3));
             $table='springtube_printing_production_details';
            $data['springtube_printing_production_details']=$this->springtube_printing_production_model->active_details_records($table,$dataa);



            $data['page_name']='Production';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
            $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

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

              $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);

              $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);
              //echo $this->db->last_query();
              $dataa = array('process_id' =>'2');

              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

              $data['springtube_printing_jobtype_master']=$this->common_model->select_active_drop_down('springtube_printing_jobtype_master',$this->session->userdata['logged_in']['company_id']); 

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
            $this->form_validation->set_rules('jobcard_no','Jobcard No.' ,'trim|xss_clean');
            $this->form_validation->set_rules('order_no','So No.' ,'trim|xss_clean');
            $this->form_validation->set_rules('article_no','Article No' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('film_code','Film code' ,'trim|xss_clean');      
            $this->form_validation->set_rules('machine','Machine Name' ,'trim|xss_clean');
            $this->form_validation->set_rules('user_id','Created by.' ,'trim|xss_clean');
            //$this->form_validation->set_rules('qc_incharge','QC Incharge Name' ,'trim|xss_clean');
            //$this->form_validation->set_rules('shift_issue','Shift Issues' ,'trim|xss_clean');
            //$this->form_validation->set_rules('remarks','Remarks' ,'trim|xss_clean');
                       
            if($this->form_validation->run()==FALSE){

              $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);

              $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);
              
              $dataa = array('process_id' =>'1');
              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

              $data['springtube_shift_issues_master']=$this->common_model->select_active_drop_down('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id']); 

              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
              $this->load->view('Home/footer');
            }else{
                
              $shift_issues='';
                //print_r($this->input->post('shift_issue'));
              if(!empty($this->input->post('shift_issue'))){
                $shift_issues=implode("," , $this->input->post('shift_issue'));
              }

              $dataa=array(
                  'springtube_printing_production_master.machine_id'=>$this->input->post('machine'),
                  'springtube_printing_production_master.user_id'=>$this->input->post('user_id')
                  //'qc_incharge'=>$this->input->post('qc_incharge'),
                  //'shift_issues'=>$shift_issues,
                  //'remarks'=>$this->input->post('remarks') 
                );

              $data['springtube_printing_production_master']=$this->springtube_printing_production_model->active_record_search('springtube_printing_production_master',$this->session->userdata['logged_in']['company_id'],$dataa,$this->input->post('from_date'),$this->input->post('to_date'));                 

              $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);                
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
               

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
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

    

    function jobcard_meters_to_qty($jobcard_no,$total_meters){     
      //(NO Of reels * reel Length * 1000 / Sleeve Length For printing) * Ups

      //$reel_length=$this->config->item('springtube_reel_length');
      //$reel_length=0;
      $expected_tubes=0;
      $jobcard_qty=0;
      $order_no='';
      $article_no='';
      $final_length_in_mm=0;
      $body_making_type='';
      

      if($jobcard_no!='' && $total_meters!='' && $total_meters!='0'){

        $customer='';
        $order_no='';
        $article_no='';
        $bom_no='';
        $bom_version_no='';
        $film_code='';
        $ad_id='';
        $version_no='';
        

        $production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$jobcard_no);
    
        foreach($production_master_result as $row) {
          $order_no=$row->sales_ord_no;
          $article_no=$row->article_no;
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
          $ad_id=$order_details_row->ad_id;
          $version_no=$order_details_row->version_no;
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
        
        if($specs_result){                      

          foreach($specs_result as $specs_row){
              $sleeve_diameter=$specs_row->SLEEVE_DIA;
              $sleeve_length=$specs_row->SLEEVE_LENGTH;
              $sleeve_mb_2=$specs_row->FILM_MASTER_BATCH_2;
              $sleeve_mb_6=$specs_row->FILM_MASTER_BATCH_6; 
              $micron_1=$specs_row->FILM_GUAGE_1;
              $micron_2=$specs_row->FILM_GUAGE_2; 
              $micron_3=$specs_row->FILM_GUAGE_3; 
              $micron_4=$specs_row->FILM_GUAGE_4; 
              $micron_5=$specs_row->FILM_GUAGE_5;       
              $micron_6=$specs_row->FILM_GUAGE_6; 
              $micron_7=$specs_row->FILM_GUAGE_7; 

          }

          $total_microns=$micron_1+$micron_2+$micron_3+$micron_4+$micron_5+$micron_6+$micron_7;

        }

        //Artwork Deatils-------------------------
        $data=array('ad_id'=>$ad_id,
              'version_no'=>$version_no
                );
        $springtube_artwork_result=$this->artwork_springtube_model->active_record_search_new('springtube_artwork_devel_master',$data,'','','',$this->session->userdata['logged_in']['company_id']);

        foreach ($springtube_artwork_result as $springtube_artwork_row) {
          $body_making_type=$springtube_artwork_row->body_making_type;
        }

        
        $sleeve_dia_id='';
        $result_sleeve_diameter_master=$this->common_model->select_one_active_record('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id'],'sleeve_diameter',$sleeve_diameter);
        //print_r($result_sleeve_diameter_master);
        foreach ($result_sleeve_diameter_master as $sleeve_diameter_master_row ) {
          $sleeve_dia_id=$sleeve_diameter_master_row->sleeve_id;
       
        }
        $data=array('sleeve_dia_id'=>$sleeve_dia_id,
                        'seam_type'=>$body_making_type);

        $result_spring_width_calculation=$this->common_model->select_active_records_where('spring_width_calculation',$this->session->userdata['logged_in']['company_id'],$data);

        $reel_width=0;
        $ups=0;
        $sleeve_length_printing=$sleeve_length+2.5;
                  
        foreach ($result_spring_width_calculation as $spring_width_calculation_row) {
          $ups=$spring_width_calculation_row->ups;
          $reel_width=($spring_width_calculation_row->slit_width)+($spring_width_calculation_row->ups*$spring_width_calculation_row->distance_each_side);
        }

        $expected_tubes=($total_meters*$ups*1000)/$sleeve_length_printing;
                //$final_length_in_mm=($sleeve_length_printing*$jobcard_qty/1000)/$ups;
                //$no_of_reels_planned=round(($final_length_in_mm/$reel_length),2);
                //$no_of_reels_planned= round($no_of_reels_planned,2);
        return round($expected_tubes,0);

     
      
    }else{
      return '0';
    }  

  }


   public function printing_shift_check(){
    
          
      $shift_data=array('production_date'=>$this->input->post('production_date'),'shift'=>$this->input->post('shift'),'jobcard_no'=>$this->input->post('jobcard_no'));
      
      $result=$this->common_model->select_active_records_where('springtube_printing_production_master',$this->session->userdata['logged_in']['company_id'],$shift_data);

      if($result){

        $this->form_validation->set_message('printing_shift_check', ' {field} entry for this jobcard is already exist');
        return FALSE;

      }
      
        
      
    }
  

}

