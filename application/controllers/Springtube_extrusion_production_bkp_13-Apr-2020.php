<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Springtube_extrusion_production extends CI_Controller {

  function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('sales_order_book_model');
      $this->load->model('sales_order_status_model');
      $this->load->model('artwork_springtube_model');
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

              $table='springtube_extrusion_production_master';
              include('pagination.php');
              $data['springtube_extrusion_production_master']=$this->springtube_extrusion_production_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
             
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
              $dataa = array('process_id' =>'1');
              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

              $data_shift_issue=array('archive'=>0,'process_id'=>1);
              $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue); 


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

  function save(){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){


            $this->form_validation->set_rules('production_date','Production Date' ,'trim|xss_clean|callback_shift_check');
            
            $this->form_validation->set_rules('machine','Machine Name' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('qc_incharge','QC Incharge Name' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('shift_issue','Shift Issues' ,'trim|xss_clean');

            $this->form_validation->set_rules('remarks','Remarks' ,'trim|xss_clean');
            
            foreach($this->input->post('sr_no') as $sr_no => $sr_no_value){

              
              $this->form_validation->set_rules('jobcard_no_'.$sr_no_value.'','Jobcard No '.$sr_no_value.'' ,'required|trim|xss_clean|max_length[50]');
              $this->form_validation->set_rules('total_meters_produced_'.$sr_no_value.'','Total Meters Produced '.$sr_no_value.'' ,'required|trim|xss_clean|max_length[10]|callback_jobcard_meters_check['.$this->input->post('jobcard_no_'.$sr_no_value).']');
              $this->form_validation->set_rules('total_job_weight_'.$sr_no_value.'','Total Job Weight (Kg) '.$sr_no_value.'' ,'required|trim|xss_clean');              
              $this->form_validation->set_rules('total_waste_'.$sr_no_value.'','Total Waste (Kg) '.$sr_no_value.'' ,'required|trim|xss_clean|max_length[15]');
              
              
            }         


           
            if($this->form_validation->run()==FALSE){

              $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);
              
              $dataa = array('process_id' =>'1');
              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

              $data_shift_issue=array('archive'=>0,'process_id'=>1);
              $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue); 

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

                $customer='';
                $order_no='';
                $article_no='';
                $bom_no='';
                $bom_version_no='';
                $film_code='';
                $jobcard_no='';
                $shift_issues='';

                //print_r($this->input->post('shift_issue'));

                if(!empty($this->input->post('shift_issue'))){

                  $shift_issues=implode("," , $this->input->post('shift_issue'));
                }

                $shift='';
                $production_time=date('H:i:s');
                $production_date=date('Y-m-d');

                if($production_time >'08:00:00' AND $production_time <'15:59:59' ){                  
                  $shift='1';                  
                }else if($production_time >'16:00:00' AND $production_time <'23:59:59'){               
                  $shift='2';                  
                }else if($production_time >'00:00:00' AND $production_time <'07:59:59'){
                  $shift='3';
                  $production_date=date('Y-m-d',strtotime("-1 days"));
                  
                }else{

                  $shift='';
                }


                $data=array(
                  'company_id'=>$this->session->userdata['logged_in']['company_id'],
                  'production_date'=>$production_date,
                  'shift'=>$shift,                                       
                  'process_id'=>'1',
                  'machine_id'=>$this->input->post('machine'),
                  'qc_incharge'=>trim(strtoupper($this->input->post('qc_incharge'))),
                  'remarks'=>trim(strtoupper($this->input->post('remarks'))),
                  'shift_issues'=>$shift_issues,                                   
                  'user_id'=>$this->session->userdata['logged_in']['user_id'],
                  'created_date'=>date('Y-m-d H:i:s'),
                  'production_time'=>date('H:i:s')
                  );

                $production_id=$this->common_model->save_return_pkey('springtube_extrusion_production_master',$data); 

                if($production_id!=''){

                  foreach($this->input->post('sr_no') as $sr_no => $sr_no_value){

                    $jobcard_no= $this->input->post('jobcard_no_'.$sr_no_value); 

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

                    $produced_qty=0;

                    $production_qty=$this->jobcard_meters_to_qty($jobcard_no,$this->input->post('total_meters_produced_'.$sr_no_value));

                    $data=array(                      
                      'production_id'=>$production_id,
                      'customer'=>$customer,
                      'jobcard_no'=>$jobcard_no,
                      'order_no'=>$order_no,
                      'article_no'=>$article_no,
                      'sleeve_dia'=>$sleeve_diameter,
                      'sleeve_length'=>$sleeve_length,
                      'total_microns'=>$total_microns,
                      'job_pos_no'=>$sr_no_value,                                          
                      'film_code'=>$film_code,
                      'second_layer_mb'=>$sleeve_mb_2,
                      'sixth_layer_mb'=>$sleeve_mb_6,                                         
                      'total_meters_produced'=>$this->input->post('total_meters_produced_'.$sr_no_value),
                      'production_qty'=>$production_qty,
                      'total_job_weight'=>$this->input->post('total_job_weight_'.$sr_no_value),
                      'total_waste'=>$this->input->post('total_waste_'.$sr_no_value),
                      'date'=>date('Y-m-d')
                    );                

                    $result=$this->common_model->save('springtube_extrusion_production_details',$data);

                    

                }//Foreach  

              }else{

                $data['note']='Error while saving master data';

              }  

              
                
                $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

                $data['note']='Create Transaction Completed';

                header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);
              
                $dataa = array('process_id' =>'1');
                $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

                $data_shift_issue=array('archive'=>0,'process_id'=>1);
                $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue); 

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
              $dataa = array('process_id' =>'1');
              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

              $data_shift_issue=array('archive'=>0,'process_id'=>1);
              $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue);  

              $table='springtube_extrusion_production_master';
              $data['springtube_extrusion_production_master']=$this->springtube_extrusion_production_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'production_id',$production_id);

              $dataa=array('production_id'=>$production_id);
              $table='springtube_extrusion_production_details';
              $data['springtube_extrusion_production_details']=$this->springtube_extrusion_production_model->active_details_records($table,$dataa);
              
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

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){

      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {

            if($formrights_row->modify==1){
              
              $this->form_validation->set_rules('machine','Machine Name' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('qc_incharge','QC Incharge Name' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('shift_issue','Shift Issues' ,'trim|xss_clean');

              $this->form_validation->set_rules('remarks','Remarks' ,'trim|xss_clean');
              
              foreach($this->input->post('sr_no') as $sr_no => $sr_no_value){
                
                $this->form_validation->set_rules('jobcard_no_'.$sr_no_value.'','Jobcard No '.$sr_no_value.'' ,'required|trim|xss_clean|max_length[50]');
                $this->form_validation->set_rules('total_meters_produced_'.$sr_no_value.'','Total Meters Produced '.$sr_no_value.'' ,'required|trim|xss_clean|max_length[10]');
				//$this->form_validation->set_rules('total_meters_produced_'.$sr_no_value.'','Total Meters Produced '.$sr_no_value.'' ,'required|trim|xss_clean|max_length[10]');
                $this->form_validation->set_rules('total_job_weight_'.$sr_no_value.'','Total Job Weight (Kg) '.$sr_no_value.'' ,'required|trim|xss_clean');              
                $this->form_validation->set_rules('total_waste_'.$sr_no_value.'','Total Waste (Kg) '.$sr_no_value.'' ,'required|trim|xss_clean|max_length[15]');
                
              }

              if($this->form_validation->run()==FALSE){

                $production_id=$this->input->post('production_id');

                $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);
                //echo $this->db->last_query();
                $dataa = array('process_id' =>'1');
                $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

                $data_shift_issue=array('archive'=>0,'process_id'=>1);
                $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue);  

                $table='springtube_extrusion_production_master';
                $data['springtube_extrusion_production_master']=$this->springtube_extrusion_production_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'production_id',$production_id);

                $dataa=array('production_id'=>$production_id);
                $table='springtube_extrusion_production_details';
                $data['springtube_extrusion_production_details']=$this->springtube_extrusion_production_model->active_details_records($table,$dataa);

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
                $this->load->view('Home/footer');

              }else{

                if(!empty($this->input->post('shift_issue'))){

                  $shift_issues=implode("," , $this->input->post('shift_issue'));
                }
                // Updating Master Table--------
                $data=array(
                  
                  'qc_incharge'=>trim(strtoupper($this->input->post('qc_incharge'))),
                  'remarks'=>trim(strtoupper($this->input->post('remarks'))),
                  'shift_issues'=>$shift_issues                               
                  
                  );

                $this->common_model->update_one_active_record('springtube_extrusion_production_master',$data,'production_id',$this->input->post('production_id'),$this->session->userdata['logged_in']['company_id']);

                // Saving History of old Job to backup database---

                $dataa=array('production_id'=>$this->input->post('production_id'));
                $springtube_extrusion_production_details_result=$this->springtube_extrusion_production_model->active_details_records('springtube_extrusion_production_details',$dataa); 
                foreach ($springtube_extrusion_production_details_result as $springtube_extrusion_production_details_row) {

                  $data=array(

                    'details_id'=>$springtube_extrusion_production_details_row->details_id,
                    'production_id'=>$springtube_extrusion_production_details_row->production_id,
                    'jobcard_no'=>$springtube_extrusion_production_details_row->jobcard_no,
                    'customer'=>$springtube_extrusion_production_details_row->customer,
                    'order_no'=>$springtube_extrusion_production_details_row->order_no,
                    'article_no'=>$springtube_extrusion_production_details_row->article_no,
                    'sleeve_dia'=>$springtube_extrusion_production_details_row->sleeve_dia,
                    'sleeve_length'=>$springtube_extrusion_production_details_row->sleeve_length,
                    'total_microns'=>$springtube_extrusion_production_details_row->total_microns,
                    'job_pos_no'=>$springtube_extrusion_production_details_row->job_pos_no,
                    'film_code'=>$springtube_extrusion_production_details_row->film_code,
                    'second_layer_mb'=>$springtube_extrusion_production_details_row->second_layer_mb,
                    'sixth_layer_mb'=>$springtube_extrusion_production_details_row->sixth_layer_mb,
                    'total_meters_produced'=>$springtube_extrusion_production_details_row->total_meters_produced,
                    'production_qty'=>$springtube_extrusion_production_details_row->production_qty,
                    'total_ok_meters'=>$springtube_extrusion_production_details_row->total_ok_meters,
                    'ok_qty'=>$springtube_extrusion_production_details_row->ok_qty,
                    'total_qc_hold_meters'=>$springtube_extrusion_production_details_row->total_qc_hold_meters,
                    'hold_qty'=>$springtube_extrusion_production_details_row->hold_qty,
                    'total_job_weight'=>$springtube_extrusion_production_details_row->total_job_weight,
                    'total_waste'=>$springtube_extrusion_production_details_row->total_waste,
                    'date'=>$springtube_extrusion_production_details_row->date,                    
                    'qc_id'=>$springtube_extrusion_production_details_row->qc_id,
                    'qc_remarks'=>$springtube_extrusion_production_details_row->qc_remarks

                  );

                  $result=$this->common_model->save('production.springtube_extrusion_production_details',$data);                  
                }
                //Removing Old records from current table
                $result=$this->common_model->delete_one_active_record_noncompany('springtube_extrusion_production_details','production_id',$this->input->post('production_id'));

                //Adding new records to details table--------

                foreach($this->input->post('sr_no') as $sr_no => $sr_no_value){

                    $jobcard_no= $this->input->post('jobcard_no_'.$sr_no_value); 

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

                    $production_qty=$this->jobcard_meters_to_qty($jobcard_no,$this->input->post('total_meters_produced_'.$sr_no_value)); 

                    $data=array(                      
                      'production_id'=>$this->input->post('production_id'),
                      'jobcard_no'=>$jobcard_no,
                      'customer'=>$customer,
                      'order_no'=>$order_no,
                      'article_no'=>$article_no,
                      'sleeve_dia'=>$sleeve_diameter,
                      'sleeve_length'=>$sleeve_length,
                      'total_microns'=>$total_microns,
                      'job_pos_no'=>$sr_no_value,                                          
                      'film_code'=>$film_code,
                      'second_layer_mb'=>$sleeve_mb_2,
                      'sixth_layer_mb'=>$sleeve_mb_6,                                         
                      'total_meters_produced'=>$this->input->post('total_meters_produced_'.$sr_no_value),
                      'production_qty'=>$production_qty,
                      'total_job_weight'=>$this->input->post('total_job_weight_'.$sr_no_value),
                      'total_waste'=>$this->input->post('total_waste_'.$sr_no_value),
                      'date'=>date('Y-m-d')
                    );                

                    $result=$this->common_model->save('neo.springtube_extrusion_production_details',$data);

                    

                }//Foreach

                $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
                
                $data['note']='Upate Transaction Completed';

                $production_id=$this->input->post('production_id');

                $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);
                //echo $this->db->last_query();
                $dataa = array('process_id' =>'1');
                $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

                $data_shift_issue=array('archive'=>0,'process_id'=>1);
                $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue);  

                $table='springtube_extrusion_production_master';
                $data['springtube_extrusion_production_master']=$this->springtube_extrusion_production_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'production_id',$production_id);

                $dataa=array('production_id'=>$production_id);
                $table='springtube_extrusion_production_details';
                $data['springtube_extrusion_production_details']=$this->springtube_extrusion_production_model->active_details_records($table,$dataa);

                $data['note']='Update Transaction Completed';
                header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
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

              $table='springtube_extrusion_production_master';
              include('pagination_archive.php');
              $data['springtube_extrusion_production_master']=$this->springtube_extrusion_production_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
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

              $result=$this->common_model->update_one_active_record('springtube_extrusion_production_master',$data,'production_id',$production_id,$this->session->userdata['logged_in']['company_id']);

              $dataa=array('production_id'=>$production_id);
              $table='springtube_extrusion_production_details';
              $data['springtube_extrusion_production_details']=$this->springtube_extrusion_production_model->active_details_records($table,$dataa);


              foreach ($data['springtube_extrusion_production_details'] as $details_row) {
                
                $details_id=$details_row->details_id;
                //Archive Records from QC
                $data=array('archive'=>'1');
                $result=$this->common_model->update_one_active_record('springtube_extrusion_qc_master',$data,'details_id',$details_id,$this->session->userdata['logged_in']['company_id']);

                //Archiving Records from WIP
                $data=array('archive'=>'1');
                $result=$this->common_model->update_one_active_record('springtube_extrusion_wip_master',$data,'details_id',$details_id,$this->session->userdata['logged_in']['company_id']);
                //Archive Records from Scrap

                $data=array('archive'=>'1');
                $result=$this->common_model->update_one_active_record('springtube_extrusion_scrap_master',$data,'details_id',$details_id,$this->session->userdata['logged_in']['company_id']);

              
              }
              // UPDATING DETAILS RECORD------------
              $data=array('archive'=>'1');
              $result=$this->common_model->update_one_active_record('springtube_extrusion_production_details',$data,'production_id',$production_id,$this->session->userdata['logged_in']['company_id']);
                  

              $data['springtube_extrusion_production_master']=$this->springtube_extrusion_production_model->select_one_inactive_record('springtube_extrusion_production_master',$this->session->userdata['logged_in']['company_id'],'production_id',$production_id);

              $dataa=array('production_id'=>$production_id);
              $table='springtube_extrusion_production_details';
              $data['springtube_extrusion_production_details']=$this->springtube_extrusion_production_model->inactive_details_records($table,$dataa);


              $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);
                //echo $this->db->last_query();
              $dataa = array('process_id' =>'1');
              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

              $data_shift_issue=array('archive'=>0,'process_id'=>1);
              $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue);  
                
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

              $result=$this->common_model->update_one_active_record('springtube_extrusion_production_master',$data,'production_id',$production_id,$this->session->userdata['logged_in']['company_id']);

              $dataa=array('production_id'=>$production_id);
              $table='springtube_extrusion_production_details';
              $data['springtube_extrusion_production_details']=$this->springtube_extrusion_production_model->inactive_details_records($table,$dataa);


              foreach ($data['springtube_extrusion_production_details'] as $details_row) {
                
                $details_id=$details_row->details_id;
                //Archive Records from QC
                $data=array('archive'=>'2');
                $result=$this->common_model->update_one_active_record('springtube_extrusion_qc_master',$data,'details_id',$details_id,$this->session->userdata['logged_in']['company_id']);

                //Archiving Records from WIP
                $data=array('archive'=>'2');
                $result=$this->common_model->update_one_active_record('springtube_extrusion_wip_master',$data,'details_id',$details_id,$this->session->userdata['logged_in']['company_id']);
                //Archive Records from Scrap

                $data=array('archive'=>'2');
                $result=$this->common_model->update_one_active_record('springtube_extrusion_scrap_master',$data,'details_id',$details_id,$this->session->userdata['logged_in']['company_id']);

              
              }
              $data=array('archive'=>'2');
              $result=$this->common_model->update_one_active_record('springtube_extrusion_production_details',$data,'production_id',$production_id,$this->session->userdata['logged_in']['company_id']);

              $data['springtube_extrusion_production_master']=$this->springtube_extrusion_production_model->select_one_active_record('springtube_extrusion_production_master',$this->session->userdata['logged_in']['company_id'],'production_id',$production_id);

              $dataa=array('production_id'=>$production_id);
              $table='springtube_extrusion_production_details';
              $data['springtube_extrusion_production_details']=$this->springtube_extrusion_production_model->active_details_records($table,$dataa);


              $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);
                //echo $this->db->last_query();
              $dataa = array('process_id' =>'1');
              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

              $data_shift_issue=array('archive'=>0,'process_id'=>1);
                $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue);  
                
              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());                  

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

            $data['springtube_extrusion_production_master']=$this->springtube_extrusion_production_model->select_one_active_record('springtube_extrusion_production_master',$this->session->userdata['logged_in']['company_id'],'springtube_extrusion_production_master.production_id',$this->uri->segment(3));

            
            $data['springtube_extrusion_production_details']=$this->common_model->select_one_details_record_noncompany('springtube_extrusion_production_details','production_id',$this->uri->segment(3));



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
              $dataa = array('process_id' =>'1');
              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

              $data_shift_issue=array('archive'=>0,'process_id'=>1);
              $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue);  

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

              $data_shift_issue=array('archive'=>0,'process_id'=>1);
              $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue);  

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
                
              $shift_issues='';
                //print_r($this->input->post('shift_issue'));
              if(!empty($this->input->post('shift_issue'))){
                $shift_issues=implode("," , $this->input->post('shift_issue'));
              }

              $dataa=array(
                  'springtube_extrusion_production_master.machine_id'=>$this->input->post('machine'),
                  'springtube_extrusion_production_master.user_id'=>$this->input->post('user_id')
                  //'qc_incharge'=>$this->input->post('qc_incharge'),
                  //'shift_issues'=>$shift_issues,
                  //'remarks'=>$this->input->post('remarks') 
                );

              $data['springtube_extrusion_production_master']=$this->springtube_extrusion_production_model->active_record_search('springtube_extrusion_production_master',$this->session->userdata['logged_in']['company_id'],$dataa,$this->input->post('from_date'),$this->input->post('to_date'));                 

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

   function approval($production_id){

      $data['page_name']='Production';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->new==1){

              $data=array('final_approval_flag'=>'1',
                          'approved_by'=>$this->session->userdata['logged_in']['user_id'],
                          'approved_date'=>date('Y-m-d')
            );

              $result=$this->common_model->update_one_active_record('springtube_extrusion_production_master',$data,'production_id',$production_id,$this->session->userdata['logged_in']['company_id']);

                  //$result=$this->common_model->update_one_active_record('springtube_article_history',$data,'production_id',$id,$this->session->userdata['logged_in']['company_id']);

              $data['springtube_extrusion_production_master']=$this->springtube_extrusion_production_model->select_one_active_record('springtube_extrusion_production_master',$this->session->userdata['logged_in']['company_id'],'production_id',$production_id);

              $dataa=array('production_id'=>$production_id);
              $table='springtube_extrusion_production_details';
              $data['springtube_extrusion_production_details']=$this->springtube_extrusion_production_model->active_details_records($table,$dataa);


              $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);
                //echo $this->db->last_query();
              $dataa = array('process_id' =>'1');
              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

              $data_shift_issue=array('archive'=>0,'process_id'=>1);
              $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue);  
                
              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());                  

              $data['note']='Approval Transaction completed';
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

    function qc_inspection($production_id,$details_id){
       
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
              $dataa = array('process_id' =>'1');
              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

              $data_shift_issue=array('archive'=>0,'process_id'=>1);
              $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue);  

              $table='springtube_extrusion_production_master';
              $data['springtube_extrusion_production_master']=$this->springtube_extrusion_production_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'production_id',$production_id);

              $dataa=array('details_id'=>$details_id);
              $table='springtube_extrusion_production_details';
              $data['springtube_extrusion_production_details']=$this->springtube_extrusion_production_model->active_details_records($table,$dataa);
              
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
       
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->new==1){
              
              $this->form_validation->set_rules('jobcard_no','Jobcard No' ,'required|trim|xss_clean|max_length[50]');
              $this->form_validation->set_rules('total_meters_produced','Total Meters Produced' ,'required|trim|xss_clean|max_length[10]');
              $this->form_validation->set_rules('total_ok_meters','Total Ok Meters' ,'required|trim|xss_clean|max_length[10]');
              $this->form_validation->set_rules('total_qc_hold_meters','Total QC Hold Meters' ,'required|trim|xss_clean|max_length[10]');
              $this->form_validation->set_rules('total_job_weight','Total Job Weight (Kg) ' ,'required|trim|xss_clean');              
              $this->form_validation->set_rules('total_waste','Total Waste (Kg)' ,'required|trim|xss_clean|max_length[15]'); 


              if($this->form_validation->run()==FALSE){

                $production_id=$this->input->post('production_id');
                $details_id=$this->input->post('details_id');

                $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);
                //echo $this->db->last_query();
                $dataa = array('process_id' =>'1');
                $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

                $data_shift_issue=array('archive'=>0,'process_id'=>1);
                $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue);  

                $table='springtube_extrusion_production_master';
                $data['springtube_extrusion_production_master']=$this->springtube_extrusion_production_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'production_id',$production_id);

                $dataa=array('details_id'=>$details_id);
                $table='springtube_extrusion_production_details';
                $data['springtube_extrusion_production_details']=$this->springtube_extrusion_production_model->active_details_records($table,$dataa);
                
               // echo $this->db->last_query();

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/qc-form',$data);
                $this->load->view('Home/footer');

              }else{

                  $customer='';
                  $order_no='';
                  $article_no='';
                  $bom_no='';
                  $bom_version_no='';
                  $film_code='';
                  
                  $jobcard_no=$this->input->post('jobcard_no');

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

                    $ok_qty=$this->jobcard_meters_to_qty($jobcard_no,$this->input->post('total_ok_meters'));
                    $data=array(
                      'wip_date'=>date('Y-m-d'),                      
                      'details_id'=>$this->input->post('details_id'),
                      'jobcard_no'=>$jobcard_no,
                      'customer'=>$customer,
                      'order_no'=>$order_no,
                      'article_no'=>$article_no,
                      'sleeve_dia'=>$sleeve_diameter,
                      'sleeve_length'=>$sleeve_length,
                      'total_microns'=>$total_microns,
                      'second_layer_mb'=>$sleeve_mb_2,
                      'sixth_layer_mb'=>$sleeve_mb_6,                           
                      'film_code'=>$film_code,                                          
                      'total_ok_meters'=>$this->input->post('total_ok_meters'),
                      'ok_qty'=>$ok_qty,                      
                      'created_date'=>date('Y-m-d h:i:s'),
                      'company_id'=>$this->session->userdata['logged_in']['company_id'],
                      'from_process'=>'1',
                      'user_id'=>$this->session->userdata['logged_in']['user_id']
                    );                

					$result=$this->common_model->save('springtube_extrusion_wip_master',$data);
					
					$hold_qty=$this->jobcard_meters_to_qty($jobcard_no,$this->input->post('total_qc_hold_meters'));
					
					if($result && $this->input->post('total_qc_hold_meters')!='0'){

                        
                        
                        $data=array(
                        'qc_date'=>date('Y-m-d'),                      
                        'details_id'=>$this->input->post('details_id'),
                        'jobcard_no'=>$jobcard_no,
                        'customer'=>$customer,
                        'order_no'=>$order_no,
                        'article_no'=>$article_no,
                        'sleeve_dia'=>$sleeve_diameter,
                        'sleeve_length'=>$sleeve_length,
                        'total_microns'=>$total_microns,
                        'second_layer_mb'=>$sleeve_mb_2,
                        'sixth_layer_mb'=>$sleeve_mb_6,                           
                        'film_code'=>$film_code,                                          
                        'total_qc_hold_meters'=>$this->input->post('total_qc_hold_meters'),
                        'hold_qty' =>$hold_qty,                     
                        'created_date'=>date('Y-m-d H:i:s'),
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'from_process'=>'1',
                        'user_id'=>$this->session->userdata['logged_in']['user_id']                        
                        );

                        $result=$this->common_model->save('springtube_extrusion_qc_master',$data);
                    }

                  $data=array(
                            'total_ok_meters'=>$this->input->post('total_ok_meters'),
                            'ok_qty'=>$ok_qty,
                            'total_qc_hold_meters'=>$this->input->post('total_qc_hold_meters'),
                            'hold_qty'=>$hold_qty,                      
                            'qc_id'=>$this->session->userdata['logged_in']['user_id'],
                            'qc_check'=>'1',
                            'qc_remarks'=>$this->input->post('qc_remarks')                
                          );

                  $result=$this->common_model->update_one_active_record_noncompany('springtube_extrusion_production_details',$data,'details_id',$this->input->post('details_id'));

                  // $data=array(
                  //           'final_approval_flag'=>'1',
                  //           'approved_by'=>$this->session->userdata['logged_in']['user_id'],
                  //           'approved_date'=>date('Y-m-d')               
                  //         );

                  // $result=$this->common_model->update_one_active_record('springtube_extrusion_production_master',$data,'production_id',$this->input->post('production_id'));


                  $data['note']='Qc Save Transaction Completed';
                
                  $production_id=$this->input->post('production_id');
                  $details_id=$this->input->post('details_id');

                  $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);
                //echo $this->db->last_query();
                  $dataa = array('process_id' =>'1');
                  $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

                  $data_shift_issue=array('archive'=>0,'process_id'=>1);
                  $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue);  

                  $table='springtube_extrusion_production_master';
                  $data['springtube_extrusion_production_master']=$this->springtube_extrusion_production_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'production_id',$production_id);

                  $dataa=array('details_id'=>$details_id);
                  $table='springtube_extrusion_production_details';
                  $data['springtube_extrusion_production_details']=$this->springtube_extrusion_production_model->active_details_records($table,$dataa);

                  $data['page_name']='Production';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());                 

                  header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/qc-form',$data);
                $this->load->view('Home/footer');
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

    public function jobcard_meters_check($total_meters_produced,$jobcard_no){      

          if($jobcard_no!='' && $total_meters_produced!=''){

            $total_meters_planned=0;
            $total_meters_exist=0;

            $data['production_master']=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no', $jobcard_no);

            $dataa=array('jobcard_no'=>$jobcard_no);
            $data['springtube_extrusion_production_details']=$this->springtube_extrusion_production_model->active_details_records('springtube_extrusion_production_details',$dataa);

            foreach ($data['springtube_extrusion_production_details'] as $details_row) {
              $total_meters_exist+=$details_row->total_meters_produced;
            }
            
            foreach ($data['production_master'] as $row) {

              $total_meters_planned= $row->no_of_reels*$row->reel_length;

              if ($total_meters_planned >= ($total_meters_produced+$total_meters_exist)){
                return TRUE;
              }else{
                $this->form_validation->set_message('jobcard_meters_check','The {field} is not more than Jobcard Quantity (Meters).');
              return FALSE;

              }
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


   public function shift_check(){
    
      $shift='';
      $production_time=date('H:i:s');
      $production_date=date('Y-m-d');

      if($production_time >'08:00:00' AND $production_time <'15:59:59' ){                  
        $shift='1';                  
      }else if($production_time >'16:00:00' AND $production_time <'23:59:59'){               
        $shift='2';                  
      }else if($production_time >'00:00:00' AND $production_time <'07:59:59'){
        $shift='3';
        $production_date=date('Y-m-d',strtotime("-1 days"));
        
      }else{
        $shift='';
      }

      $shift_data=array('production_date'=>$production_date,'shift'=>$shift);
      $result=$this->common_model->select_active_records_where('springtube_extrusion_production_master',$this->session->userdata['logged_in']['company_id'],$shift_data);

      if($result){

        $this->form_validation->set_message('shift_check', 'Entry on this {field} and shift is already exist');
        return FALSE;

      }
      
        
      
    }

    function consolidated_search(){    
    
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
             
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/consolidated-search-form',$data);
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

  function consolidated_search_result(){

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
            $this->form_validation->set_rules('adr_company_id','Company Name' ,'trim|xss_clean|max_length[150]|strtoupper|callback_customer_check');
            //$this->form_validation->set_rules('jobcard_no','Jobcard No.' ,'trim|xss_clean');
            $this->form_validation->set_rules('order_no','So No.' ,'trim|xss_clean');
            $this->form_validation->set_rules('article_no','Article No' ,'trim|xss_clean|callback_article_check');
            //$this->form_validation->set_rules('film_code','Film code' ,'trim|xss_clean');      
            //$this->form_validation->set_rules('machine','Machine Name' ,'trim|xss_clean');
            //$this->form_validation->set_rules('user_id','Created by.' ,'trim|xss_clean');
            //$this->form_validation->set_rules('qc_incharge','QC Incharge Name' ,'trim|xss_clean');
            //$this->form_validation->set_rules('shift_issue','Shift Issues' ,'trim|xss_clean');
            //$this->form_validation->set_rules('remarks','Remarks' ,'trim|xss_clean');
                       
            if($this->form_validation->run()==FALSE){                 

              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/consolidated-search-form',$data);
              $this->load->view('Home/footer');
            }else{
                
                $search=array();           
                if(!empty($this->input->post('adr_company_id'))){
                     $arr=explode('//',$this->input->post('adr_company_id'));
                     $search['springtube_extrusion_production_details.customer']=$arr[1];
                } 
                if(!empty($this->input->post('order_no'))){
                     $search['springtube_extrusion_production_details.order_no']=$this->input->post('order_no');
                }                 
                if(!empty($this->input->post('article_no'))){

                    $arr=explode("//",$this->input->post('article_no'));
                    $article_no=$arr[1];

                    $search['springtube_extrusion_production_details.article_no']=$article_no;

                }
                $data['springtube_extrusion_production_master']=$this->springtube_extrusion_production_model->active_record_search_consolidated('springtube_extrusion_production_master',$this->session->userdata['logged_in']['company_id'],$search,$this->input->post('from_date'),$this->input->post('to_date'));                 

                $data['page_name']='Production';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);                
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
               

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                //$this->load->view(ucwords($this->router->fetch_class()).'/consolidated-search-form',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/consolidated-search-result',$data);
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

  public function customer_check($str){
    if(!empty($str)){
    $customer_code=explode('//',$str);
    if(!empty($customer_code[1])){
    $data['customer']=$this->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'name1',$customer_code[0]);
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

