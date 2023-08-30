<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Springtube_extrusion_qc extends CI_Controller {

  function __construct(){    
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('fiscal_model');
      $this->load->model('sales_order_book_model');
      $this->load->model('sales_order_status_model');
      $this->load->model('artwork_springtube_model');
      $this->load->model('springtube_extrusion_qc_model');
       $this->load->model('springtube_extrusion_production_model');
      
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

              $table='springtube_extrusion_qc_master';
              include('pagination.php');
              $data['springtube_extrusion_qc_master']=$this->springtube_extrusion_qc_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
             
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

  function qc_release($qc_id){
       
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->new==1){

              $data['springtube_extrusion_reel_scrap_reasons']=$this->common_model->select_active_drop_down('springtube_extrusion_reel_scrap_reasons',$this->session->userdata['logged_in']['company_id']);

              $table='springtube_extrusion_qc_master';
              $data['springtube_extrusion_qc_master']=$this->springtube_extrusion_qc_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'qc_id',$qc_id);


             // echo $this->db->last_query();

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/qc-release-form',$data);
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
  function qc_release_save(){
       
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
              $this->form_validation->set_rules('total_qc_hold_meters','Total Hold Meters' ,'required|trim|xss_clean|max_length[10]');
              $this->form_validation->set_rules('release_meters','Release Meters' ,'required|trim|xss_clean|max_length[10]|greater_than[0]');
              $this->form_validation->set_rules('release_to','Release To' ,'required|trim|xss_clean');
              if(!empty($this->input->post('release_to')) && $this->input->post('release_to')==2) {
                $this->form_validation->set_rules('scrap_reasons[]','Reel Scrap Reasons' ,'required|trim|xss_clean');
              }
              $this->form_validation->set_rules('qc_remarks','Qc remarks' ,'required|trim|xss_clean|max_length[256]');              


              if($this->form_validation->run()==FALSE){

                $qc_id=$this->input->post('qc_id');  

                $data['springtube_extrusion_reel_scrap_reasons']=$this->common_model->select_active_drop_down('springtube_extrusion_reel_scrap_reasons',$this->session->userdata['logged_in']['company_id']);              

                $table='springtube_extrusion_qc_master';
                $data['springtube_extrusion_qc_master']=$this->springtube_extrusion_qc_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'qc_id',$qc_id);
                
               // echo $this->db->last_query();

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/qc-release-form',$data);
                $this->load->view('Home/footer');

              }else{ 

                
                  $qc_id=$this->input->post('qc_id'); 
                  $details_id='';
                  $customer='';
                  $jobcard_no='';
                  $order_no='';
                  $article_no='';
                  $sleeve_dia='';
                  $sleeve_length='';
                  $total_microns='';
                  $sleeve_mb_2='';
                  $sleeve_mb_6='';
                  $film_code='';
                  $total_ok_meters=0;
                  $pending_meters=0;

                  $total_plan_meters=0;

                  $springtube_extrusion_qc_master_result=$this->common_model->select_one_active_record('springtube_extrusion_qc_master',$this->session->userdata['logged_in']['company_id'],'qc_id',$qc_id);
              
                  foreach($springtube_extrusion_qc_master_result as $row) {
                    $details_id=$row->details_id;
                    $jobcard_no=$row->jobcard_no;
                    $customer=$row->customer;
                    $order_no=$row->order_no;
                    $article_no=$row->article_no;
                    $sleeve_dia=$row->sleeve_dia;
                    $sleeve_length=$row->sleeve_length;
                    $total_microns=$row->total_microns;
                    $sleeve_mb_2=$row->second_layer_mb;
                    $sleeve_mb_6=$row->sixth_layer_mb;
                    $film_code=$row->film_code;
                  }

                  $production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no', $jobcard_no);
              
                  foreach($production_master_result as $production_master_row) {
                    $order_no=$production_master_row->sales_ord_no;
                    $article_no=$production_master_row->article_no;
                    $total_plan_meters=$production_master_row->total_meters;
                  }

                  $total_qc_hold_meters=$this->input->post('total_qc_hold_meters');
                  $release_meters=$this->input->post('release_meters');

                  //TO FILM WIP
                  if($this->input->post('release_to')=='1'){

                    $pending_meters=$total_qc_hold_meters-$release_meters;
                    //Partially release to WIP
                    if($pending_meters>0){ 

                      $ok_qty=$this->jobcard_meters_to_qty($jobcard_no,$release_meters);

                      $data=array(
                        'wip_date'=>date('Y-m-d'),                      
                        'details_id'=>$details_id,
                        'jobcard_no'=>$jobcard_no,
                        'customer'=>$customer,
                        'order_no'=>$order_no,
                        'article_no'=>$article_no,
                        'sleeve_dia'=>$sleeve_dia,
                        'sleeve_length'=>$sleeve_length,
                        'total_microns'=>$total_microns,
                        'second_layer_mb'=>$sleeve_mb_2,
                        'sixth_layer_mb'=>$sleeve_mb_6,                           
                        'film_code'=>$film_code,                                          
                        'total_ok_meters'=>$release_meters,
                        'ok_qty'=>$ok_qty,                      
                        'created_date'=>date('Y-m-d H:i:s'),
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'from_process'=>'7',
                        'user_id'=>$this->session->userdata['logged_in']['user_id']
                      );                

                      $result=$this->common_model->save('springtube_extrusion_wip_master',$data);

                      $hold_qty=$this->jobcard_meters_to_qty($jobcard_no,$pending_meters);

                      $data=array(
                        'qc_date'=>date('Y-m-d'),                      
                        'details_id'=>$details_id,
                        'jobcard_no'=>$jobcard_no,
                        'customer'=>$customer,
                        'order_no'=>$order_no,
                        'article_no'=>$article_no,
                        'sleeve_dia'=>$sleeve_dia,
                        'sleeve_length'=>$sleeve_length,
                        'total_microns'=>$total_microns,
                        'second_layer_mb'=>$sleeve_mb_2,
                        'sixth_layer_mb'=>$sleeve_mb_6,                           
                        'film_code'=>$film_code,                                          
                        'total_qc_hold_meters'=>$pending_meters, 
                        'hold_qty'=>$hold_qty,                     
                        'created_date'=>date('Y-m-d H:i:s'),
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'from_process'=>'7',
                        'user_id'=>$this->session->userdata['logged_in']['user_id']                        
                        );

                        $result=$this->common_model->save('springtube_extrusion_qc_master',$data);

                        $data=array( 'status'=>'1',
                        'release_meters'=>$release_meters,
                        'release_qty'=>$ok_qty,
                        'release_date'=>date('Y-m-d'),
                        'release_by'=>$this->session->userdata['logged_in']['user_id'],
                        'next_process'=>'6',
                        'qc_remarks'=>$this->input->post('qc_remarks'));

                        $result=$this->common_model->update_one_active_record('springtube_extrusion_qc_master',$data,'qc_id',$qc_id,$this->session->userdata['logged_in']['company_id']);



                    }else{ 
                      
                    // FUll release to WIP

                      $ok_qty=$this->jobcard_meters_to_qty($jobcard_no,$release_meters);

                      $data=array(
                        'wip_date'=>date('Y-m-d'),                      
                        'details_id'=>$details_id,
                        'jobcard_no'=>$jobcard_no,
                        'customer'=>$customer,
                        'order_no'=>$order_no,
                        'article_no'=>$article_no,
                        'sleeve_dia'=>$sleeve_dia,
                        'sleeve_length'=>$sleeve_length,
                        'total_microns'=>$total_microns,
                        'second_layer_mb'=>$sleeve_mb_2,
                        'sixth_layer_mb'=>$sleeve_mb_6,                           
                        'film_code'=>$film_code,                                          
                        'total_ok_meters'=>$release_meters,
                        'ok_qty'=>$ok_qty,
                        'created_date'=>date('Y-m-d H:i:s'),
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'from_process'=>'7',
                        'user_id'=>$this->session->userdata['logged_in']['user_id']
                      );                

                      $result=$this->common_model->save('springtube_extrusion_wip_master',$data);

                      $data=array( 'status'=>'1',
                                    'release_meters'=>$release_meters,
                                    'release_qty'=>$ok_qty,
                                    'release_date'=>date('Y-m-d'),
                                    'release_by'=>$this->session->userdata['logged_in']['user_id'],
                                    'next_process'=>'6',
                                    'qc_remarks'=>$this->input->post('qc_remarks')
                                  );
                      $result=$this->common_model->update_one_active_record('springtube_extrusion_qc_master',$data,'qc_id',$qc_id,$this->session->userdata['logged_in']['company_id']);

                    }
                  }else{ 

                    // TO FILM QC SCRAP-------------------

                    // SCRAP WEIGHT

                    $weight_result=$this->springtube_extrusion_production_model->get_job_weight_extrusion($jobcard_no,$this->session->userdata['logged_in']['company_id']);

                    $total_weight=0;  
                    foreach ($weight_result as $key => $weight_row) {
                      $total_weight=$this->common_model->read_number($weight_row->total_qty,$this->session->userdata['logged_in']['company_id']);
                    }
                    $one_meter_weight=($total_weight/$total_plan_meters);

                    $scrap_weight=round($one_meter_weight*$release_meters,2);      


                    $scrap_reason='';


                    if(!empty($this->input->post('release_to')) && $this->input->post('release_to')==2) {
                      
                      $scrap_reason=implode(",",$this->input->post('scrap_reasons[]'));
                    }

                    $pending_meters=$total_qc_hold_meters-$release_meters;

                    //Partially release to Scrap
                    if($pending_meters>0){

                      $scrap_qty=$this->jobcard_meters_to_qty($jobcard_no,$release_meters); 

                      $data=array(
                        'scrap_date'=>date('Y-m-d'),                      
                        'details_id'=>$details_id,
                        'jobcard_no'=>$jobcard_no,
                        'customer'=>$customer,
                        'order_no'=>$order_no,
                        'article_no'=>$article_no,
                        'sleeve_dia'=>$sleeve_dia,
                        'sleeve_length'=>$sleeve_length,
                        'total_microns'=>$total_microns,
                        'second_layer_mb'=>$sleeve_mb_2,
                        'sixth_layer_mb'=>$sleeve_mb_6,                           
                        'film_code'=>$film_code,                                          
                        'total_scrap_meters'=>$release_meters,
                        'scrap_qty'=>$scrap_qty, 
                        'scrap_weight'=>$scrap_weight,                     
                        'created_date'=>date('Y-m-d H:i:s'),
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'from_process'=>'7',
                        'user_id'=>$this->session->userdata['logged_in']['user_id'],
                        'scrap_reason'=>$scrap_reason
                      );                

                      $result=$this->common_model->save('springtube_extrusion_scrap_master',$data);

                      $hold_qty=$this->jobcard_meters_to_qty($jobcard_no,$pending_meters);
                      $data=array(
                        'qc_date'=>date('Y-m-d'),                      
                        'details_id'=>$details_id,
                        'jobcard_no'=>$jobcard_no,
                        'customer'=>$customer,
                        'order_no'=>$order_no,
                        'article_no'=>$article_no,
                        'sleeve_dia'=>$sleeve_dia,
                        'sleeve_length'=>$sleeve_length,
                        'total_microns'=>$total_microns,
                        'second_layer_mb'=>$sleeve_mb_2,
                        'sixth_layer_mb'=>$sleeve_mb_6,                           
                        'film_code'=>$film_code,                                          
                        'total_qc_hold_meters'=>$pending_meters,
                        'hold_qty'=>$hold_qty,                      
                        'created_date'=>date('Y-m-d H:i:s'),
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'from_process'=>'7',
                        'user_id'=>$this->session->userdata['logged_in']['user_id']                        
                        );

                        $result=$this->common_model->save('springtube_extrusion_qc_master',$data);

                        $data=array('status'=>'1',
                                    'release_meters'=>$release_meters,
                                    'release_qty'=>$scrap_qty,
                                    'release_date'=>date('Y-m-d'),
                                    'release_by'=>$this->session->userdata['logged_in']['user_id'],
                                    'next_process'=>'11',
                                    'qc_remarks'=>$this->input->post('qc_remarks'),
                                    'scrap_reason'=>$scrap_reason
                                  );

                        $result=$this->common_model->update_one_active_record('springtube_extrusion_qc_master',$data,'qc_id',$qc_id,$this->session->userdata['logged_in']['company_id']);



                    }else{ // FUll release to SCRAP

                      $scrap_qty=$this->jobcard_meters_to_qty($jobcard_no,$release_meters);

                      $data=array(
                        'scrap_date'=>date('Y-m-d'),                      
                        'details_id'=>$details_id,
                        'jobcard_no'=>$jobcard_no,
                        'customer'=>$customer,
                        'order_no'=>$order_no,
                        'article_no'=>$article_no,
                        'sleeve_dia'=>$sleeve_dia,
                        'sleeve_length'=>$sleeve_length,
                        'total_microns'=>$total_microns,
                        'second_layer_mb'=>$sleeve_mb_2,
                        'sixth_layer_mb'=>$sleeve_mb_6,                           
                        'film_code'=>$film_code,                                          
                        'total_scrap_meters'=>$release_meters,
                        'scrap_qty'=>$scrap_qty,
                        'scrap_weight'=>$scrap_weight,                      
                        'created_date'=>date('Y-m-d H:i:s'),
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'from_process'=>'7',
                        'user_id'=>$this->session->userdata['logged_in']['user_id'],
                        'scrap_reason'=>$scrap_reason
                      );                

                      $result=$this->common_model->save('springtube_extrusion_scrap_master',$data);

                      $data=array(  'status'=>'1',
                                    'release_meters'=>$release_meters,
                                    'release_qty'=>$scrap_qty,
                                    'release_date'=>date('Y-m-d'),
                                    'release_by'=>$this->session->userdata['logged_in']['user_id'],
                                    'next_process'=>'11',
                                    'qc_remarks'=>$this->input->post('qc_remarks'),
                                    'scrap_reason'=>$scrap_reason
                                  );
                      $result=$this->common_model->update_one_active_record('springtube_extrusion_qc_master',$data,'qc_id',$qc_id,$this->session->userdata['logged_in']['company_id']);

                    }                   


                  }

                  
                  $data['note']='Qc Save Transaction Completed';
                
                  $table='springtube_extrusion_qc_master';
                  $data['springtube_extrusion_qc_master']=$this->springtube_extrusion_qc_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'qc_id',$qc_id);

                  $data['springtube_extrusion_reel_scrap_reasons']=$this->common_model->select_active_drop_down('springtube_extrusion_reel_scrap_reasons',$this->session->userdata['logged_in']['company_id']);

                  $data['page_name']='Production';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());                 

                  header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/qc-release-form',$data);
                $this->load->view('Home/footer');
              }       
               
             // echo $this->db->last_query();

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/qc-release-form',$data);
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

              $table='springtube_extrusion_qc_master';
              include('pagination_archive.php');
              $data['springtube_extrusion_qc_master']=$this->springtube_extrusion_qc_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
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

              $data['sleeve_diameter_master']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

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
            $this->form_validation->set_rules('order_no','Order No.' ,'trim|xss_clean');       
            $this->form_validation->set_rules('jobcard_no','Jobcard No.' ,'trim|xss_clean');
            $this->form_validation->set_rules('article_no','article_no' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('film_code','Film Code' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('status','Status.' ,'trim|xss_clean');           
                       
            if($this->form_validation->run()==FALSE){

              $data['sleeve_diameter_master']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

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

              if($this->input->post('customer')!=''){
                $customer_arr=explode("//",$this->input->post('customer'));
                $data_search['customer']=$customer_arr[1];
              }


              if($this->input->post('jobcard_no')!=''){
                $data_search['jobcard_no']=$this->input->post('jobcard_no');
              }
              if($this->input->post('order_no')!=''){
                $data_search['order_no']=$this->input->post('order_no');
              }
              if($this->input->post('article_no')!=''){
                $article_arr=explode("//",$this->input->post('article_no'));
                $data_search['article_no']=$article_arr[1];
              }
              if($this->input->post('film_code')!=''){
                $film_code_arr=explode("//",$this->input->post('film_code'));
                $data_search['film_code']=$film_code_arr[1];
              }

              if($this->input->post('status')!=''){                
                $data_search['status']=$this->input->post('status');
              }

              if($this->input->post('sleeve_diameter')!=''){                
                $data_search['sleeve_dia']=$this->input->post('sleeve_diameter');
              }
                           

              $data['springtube_extrusion_qc_master']=$this->springtube_extrusion_qc_model->active_record_search('springtube_extrusion_qc_master',$this->session->userdata['logged_in']['company_id'],$data_search,$this->input->post('from_date'),$this->input->post('to_date')); 
              //echo $this->db->last_query(); 

              $data['sleeve_diameter_master']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);           

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

  // Scrap ------

  function scrap_search(){    
    
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){

              $data['sleeve_diameter_master']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

              $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

              $data['springtube_extrusion_scrap_master']=$this->springtube_extrusion_qc_model->scrap_active_record_search('springtube_extrusion_scrap_master',$this->session->userdata['logged_in']['company_id'],$data_search=array('from_process'=>'7'),$this->input->get('from_date'),$this->input->get('to_date'));

              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
             
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/scrap-search-form',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/scrap-active-records',$data);
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
  function scrap_search_result(){

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
            $this->form_validation->set_rules('article_no','article_no' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('film_code','Film Code' ,'trim|xss_clean|callback_article_check');           
            
            
                       
            if($this->form_validation->run()==FALSE){

              $data['sleeve_diameter_master']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/scrap-search-form',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/scrap-active-records',$data);
              $this->load->view('Home/footer');
            }else{       
                            

              $data_search=array();
              $data_search['from_process']='7';
             

              if($this->input->post('jobcard_no')!=''){
                $data_search['jobcard_no']=$this->input->post('jobcard_no');
              }
              if($this->input->post('order_no')!=''){
                $data_search['order_no']=$this->input->post('order_no');
              }
              if($this->input->post('article_no')!=''){
                $article_arr=explode("//",$this->input->post('article_no'));
                $data_search['article_no']=$article_arr[1];
              }
              if($this->input->post('film_code')!=''){
                $film_code_arr=explode("//",$this->input->post('film_code'));
                $data_search['film_code']=$film_code_arr[1];
              }  

              if($this->input->post('customer')!=''){
                $customer_arr=explode("//",$this->input->post('customer'));
                $data_search['customer']=$customer_arr[1];
              }

              if($this->input->post('sleeve_diameter')!=''){
                $data_search['sleeve_dia']=$this->input->post('sleeve_diameter');
              }            
              

              $data['springtube_extrusion_scrap_master']=$this->springtube_extrusion_qc_model->scrap_active_record_search('springtube_extrusion_scrap_master',$this->session->userdata['logged_in']['company_id'],$data_search,$this->input->post('from_date'),$this->input->post('to_date'));

              $data['sleeve_diameter_master']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

              $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

              $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);                
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());               

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/scrap-search-form',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/scrap-active-records',$data);
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
      //(NO Of reels * reel Length * 1000 / Sleeve Length For Extrusion) * Ups

      //$reel_length=$this->config->item('springtube_reel_length');
      //$reel_length=0;
      $expected_tubes=0;
      $jobcard_qty=0;
      $order_no='';
      $article_no='';
      $final_length_in_mm=0;
      $body_making_type='';
      

      if($jobcard_no!='' && $total_meters!=''){

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
        $sleeve_length_extrusion=$sleeve_length+2.5;
                  
        foreach ($result_spring_width_calculation as $spring_width_calculation_row) {
          $ups=$spring_width_calculation_row->ups;
          $reel_width=($spring_width_calculation_row->slit_width)+($spring_width_calculation_row->ups*$spring_width_calculation_row->distance_each_side);
        }

        $expected_tubes=($total_meters*$ups*1000)/$sleeve_length_extrusion;
                //$final_length_in_mm=($sleeve_length_extrusion*$jobcard_qty/1000)/$ups;
                //$no_of_reels_planned=round(($final_length_in_mm/$reel_length),2);
                //$no_of_reels_planned= round($no_of_reels_planned,2);
        return round($expected_tubes,0);

     
      
    }else{
      return '0';
    }  

  }

  

}

