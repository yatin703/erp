<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Springtube_printing_control_plan_qc extends CI_Controller {

  function __construct(){

    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('sales_order_book_model');
      $this->load->model('sales_order_status_model');
      $this->load->model('artwork_springtube_model');
      $this->load->model('springtube_printing_control_plan_qc_model');
       //$this->load->model('springtube_extrusion_production_model');
      
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

              $table='springtube_printing_control_plan_qc';
              include('pagination.php');
              $data['springtube_printing_control_plan_qc']=$this->springtube_printing_control_plan_qc_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
             
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
              
              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $dataa = array('process_id' =>'2');
              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['springtube_shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
             
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

              $this->form_validation->set_rules('inspection_date','Inspection Date' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('shift','Shift' ,'required|trim|xss_clean');

              $this->form_validation->set_rules('machine','Machine Name' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('jobcard_no','Jobcard No.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('operator','Operator' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('de_value','DE Value' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('treatment','Treatment' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('treatment_status','Treatment Status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('shade_variation','Shade Variations' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('shade_variation_status','Shade Variations Status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('text_proof','Text Proof' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('text_proof_status','Text Proof Status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('lacquer_over_under','Lacquer (Over/Under)' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('lacquer_over_under_status','Lacquer (Over/Under) Status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('non_print_area','Non Print Area' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('non_print_area_status','Non Print Area Status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('i_mark_position','I Mark Position' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('i_mark_position_status','I Mark Position Status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('repeat_length_variation','Repeat Length Variation' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('repeat_length_variation_status','Repeat Length Variation Status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('print_cut','Print Cut' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('print_cut_status','Print Cut Status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('smudge_print','Smudge Print' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('smudge_print_status','Smudge Print status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('ink_dot','Ink Dot' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('ink_dot_status','Ink Dot Status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('ghost_print','Ghost Print' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('ghost_print_status','Ghost Print Status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('motling','Motling' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('motling_status','Motling status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('tape_test','Tape Test' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('tape_test_status','Tape Test Status ' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('rub_test','Rub Test' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('rub_test_status','Rub Test Status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('print_surface_line','Print Surface Line' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('print_surface_line_status','Print Surface Line Status' ,'required|trim|xss_clean');

              $this->form_validation->set_rules('miss_print','Miss Print' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('miss_print_status','Miss Print status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('barcode_test','Barcode test' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('barcode_test_status','Barcode test status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('contamination','Contamination Issue' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('contamination_status','Contamination Issue status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('non_lacquer_area','Non Lacquer Area' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('non_lacquer_area_status','Non Lacquer Area status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('wet_lacquer','Wet Lacquer' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('wet_lacquer_status','Wet Lacquer status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('lacquer_peeloff','Lacquer Peeloff' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('lacquer_peeloff_status','Lacquer Peeloff status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('wavy_lacquer','Wavy Lacquer' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('wavy_lacquer_status','Wavy Lacquer status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('dull_lacquer','Dull Lacquer' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('dull_lacquer_status','Dull Lacquer status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('dirty_lacquer','Dirty Lacquer' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('dirty_lacquer_status','Dirty Lacquer status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('foil_cut','Foil Cut' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('foil_cut_status','Foil Cut status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('foil_shift_vertical','Foil Shift (Vertical)' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('foil_shift_vertical_status','Foil Shift (Vertical) status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('foil_shift_horizontal','Foil Shift (Horizontal)' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('foil_shift_horizontal_status','Foil Shift (Horizontal) status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('foil_thickness','Foil Thickness' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('foil_thickness_status','Foil Thickness status' ,'required|trim|xss_clean');
              
              $this->form_validation->set_rules('masterfile_jobcard_return_status','Master file & Jobcard return status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('rm_return_status','RM return status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('red_create_status','Red create status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('rejected_rolls_clear_status','rejected rolls clear status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('no_loose_tools_status','No loose tools status' ,'required|trim|xss_clean');

              $this->form_validation->set_rules('no_film_roll_status','No Film Roll of Previous Job status' ,'required|trim|xss_clean');

              $this->form_validation->set_rules('machine_cleane_status','Machine cleane status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('machine_ready_status','Machine ready status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('finger_comb_status','Finger comb status' ,'required|trim|xss_clean');
             
              //$this->form_validation->set_rules('new_job','New job/Power Failure/Material Change' ,'required|trim|xss_clean');
             // $this->form_validation->set_rules('shift_change','Shift change/Trial' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('qc_remarks','QC remarks' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('qc_inspection_status','QC inspection status' ,'required|trim|xss_clean');

           
            if($this->form_validation->run()==FALSE){

              $dataa = array('process_id' =>'2');
              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

              $data['springtube_shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
              
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


                $data=array(
                  'company_id'=>$this->session->userdata['logged_in']['company_id'],
                  'inspection_date'=>$this->input->post('inspection_date'),
                  'shift'=>$this->input->post('shift'),
                  'inspection_time'=>date('H:i:s'),
                  'machine_id'=>$this->input->post('machine'),
                  'jobcard_no'=>$this->input->post('jobcard_no'),                  
                  'operator'=>trim(strtoupper($this->input->post('operator'))),

                  'de_value'=>$this->input->post('de_value'),
                  'de_value_status'=>$this->input->post('de_value_status'),
                  'treatment'=>$this->input->post('treatment'),
                  'treatment_status'=>$this->input->post('treatment_status'),
                  'shade_variation'=>$this->input->post('shade_variation'),
                  'shade_variation_status'=>$this->input->post('shade_variation_status'),
                  'text_proof'=>$this->input->post('text_proof'),
                  'text_proof_status'=>$this->input->post('text_proof_status'),
                  'lacquer_over_under'=>$this->input->post('lacquer_over_under'),
                  'lacquer_over_under_status'=>$this->input->post('lacquer_over_under_status'),
                  'non_print_area'=>$this->input->post('non_print_area'),
                  'non_print_area_status'=>$this->input->post('non_print_area_status'),
                  'i_mark_position'=>$this->input->post('i_mark_position'),
                  'i_mark_position_status'=>$this->input->post('i_mark_position_status'),
                  'repeat_length_variation'=>$this->input->post('repeat_length_variation'),
                  'repeat_length_variation_status'=>$this->input->post('repeat_length_variation_status'),
                  'print_cut'=>$this->input->post('print_cut'),
                  'print_cut_status'=>$this->input->post('print_cut_status'),
                  'smudge_print'=>$this->input->post('smudge_print'),
                  'smudge_print_status'=>$this->input->post('smudge_print_status'),
                  'ink_dot'=>$this->input->post('ink_dot'),
                  'ink_dot_status'=>$this->input->post('ink_dot_status'),
                  'ghost_print'=>$this->input->post('ghost_print'),
                  'ghost_print_status'=>$this->input->post('ghost_print_status'),
                  'motling'=>$this->input->post('motling'),
                  'motling_status'=>$this->input->post('motling_status'),
                  'tape_test'=>$this->input->post('tape_test'),
                  'tape_test_status'=>$this->input->post('tape_test_status'),
                  'rub_test'=>$this->input->post('rub_test'),
                  'rub_test_status'=>$this->input->post('rub_test_status'),
                  'print_surface_line'=>$this->input->post('print_surface_line'),
                  'print_surface_line_status'=>$this->input->post('print_surface_line_status'),
                  'miss_print'=>$this->input->post('miss_print'),
                  'miss_print_status'=>$this->input->post('miss_print_status'),
                  'barcode_test'=>$this->input->post('barcode_test'),
                  'barcode_test_status'=>$this->input->post('barcode_test_status'),
                  'contamination'=>$this->input->post('contamination'),
                  'contamination_status'=>$this->input->post('contamination_status'),
                  'non_lacquer_area'=>$this->input->post('non_lacquer_area'),
                  'non_lacquer_area_status'=>$this->input->post('non_lacquer_area_status'),
                  'wet_lacquer'=>$this->input->post('wet_lacquer'),
                  'wet_lacquer_status'=>$this->input->post('wet_lacquer_status'),
                  'lacquer_peeloff'=>$this->input->post('lacquer_peeloff'),
                  'lacquer_peeloff_status'=>$this->input->post('lacquer_peeloff_status'),
                  'wavy_lacquer'=>$this->input->post('wavy_lacquer'),
                  'wavy_lacquer_status'=>$this->input->post('wavy_lacquer_status'),
                  'dull_lacquer'=>$this->input->post('dull_lacquer'),
                  'dull_lacquer_status'=>$this->input->post('dull_lacquer_status'),
                  'dirty_lacquer'=>$this->input->post('dirty_lacquer'),
                  'dirty_lacquer_status'=>$this->input->post('dirty_lacquer_status'),
                  'foil_cut'=>$this->input->post('foil_cut'),
                  'foil_cut_status'=>$this->input->post('foil_cut_status'),
                  'foil_shift_vertical'=>$this->input->post('foil_shift_vertical'),
                  'foil_shift_vertical_status'=>$this->input->post('foil_shift_vertical_status'),
                  'foil_shift_horizontal'=>$this->input->post('foil_shift_horizontal'),
                  'foil_shift_horizontal_status'=>$this->input->post('foil_shift_horizontal_status'),
                  'foil_thickness'=>$this->input->post('foil_thickness'),
                  'foil_thickness_status'=>$this->input->post('foil_thickness_status'),
                  'masterfile_jobcard_return_status'=>$this->input->post('masterfile_jobcard_return_status'),
                  'rm_return_status'=>$this->input->post('rm_return_status'),
                  'red_create_status'=>$this->input->post('red_create_status'),
                  'rejected_rolls_clear_status'=>$this->input->post('rejected_rolls_clear_status'),
                  'no_film_roll_status'=>$this->input->post('no_film_roll_status'),
                  'no_loose_tools_status'=>$this->input->post('no_loose_tools_status'),
                  'machine_cleane_status'=>$this->input->post('machine_cleane_status'),
                  'machine_ready_status'=>$this->input->post('machine_ready_status'),
                  'finger_comb_status'=>$this->input->post('finger_comb_status'),                  
                  //'new_job'=>$this->input->post('new_job'),
                  //'shift_change'=>$this->input->post('shift_change'),
                  'new_job_status'=>(!empty($this->input->post('new_job_status')) ? 1 : 0),
                  'power_failure_status'=>(!empty($this->input->post('power_failure_status')) ? 1 : 0),
                  'change_of_rm_status'=>(!empty($this->input->post('change_of_rm_status')) ? 1 : 0),
                  'shift_change_status'=>(!empty($this->input->post('shift_change_status')) ? 1 : 0),
                  'trial_status'=>(!empty($this->input->post('trial_status')) ? 1 : 0),
                  'machine_maintainance_status'=>(!empty($this->input->post('machine_maintainance_status')) ? 1 : 0),
                  'qc_remarks'=>trim(strtoupper($this->input->post('qc_remarks'))),
                  'qc_inspection_status'=>$this->input->post('qc_inspection_status'),                                                  
                  'user_id'=>$this->session->userdata['logged_in']['user_id'],
                  'created_date'=>date('Y-m-d H:i:s')
                  
                  );

                $result=$this->common_model->save('springtube_printing_control_plan_qc',$data); 

                               
                
                $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

                $data['note']='Create Transaction Completed';

                header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

              
                $dataa = array('process_id' =>'2');
                $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

                $data['springtube_shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);


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

  function modify($cp_id){
       
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){
             
              $dataa = array('process_id' =>'2');
              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

              $data['springtube_shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
              
              $table='springtube_printing_control_plan_qc';
              $data['springtube_printing_control_plan_qc']=$this->springtube_printing_control_plan_qc_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'cp_id',$cp_id);

              
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
              
              $this->form_validation->set_rules('inspection_date','Inspection Date' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('shift','Shift' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('machine','Machine Name' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('jobcard_no','Jobcard No.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('operator','Operator' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('de_value','DE Value' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('treatment','Treatment' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('treatment_status','Treatment Status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('shade_variation','Shade Variations' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('shade_variation_status','Shade Variations Status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('text_proof','Text Proof' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('text_proof_status','Text Proof Status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('lacquer_over_under','Lacquer (Over/Under)' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('lacquer_over_under_status','Lacquer (Over/Under) Status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('non_print_area','Non Print Area' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('non_print_area_status','Non Print Area Status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('i_mark_position','I Mark Position' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('i_mark_position_status','I Mark Position Status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('repeat_length_variation','Repeat Length Variation' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('repeat_length_variation_status','Repeat Length Variation Status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('print_cut','Print Cut' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('print_cut_status','Print Cut Status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('smudge_print','Smudge Print' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('smudge_print_status','Smudge Print status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('ink_dot','Ink Dot' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('ink_dot_status','Ink Dot Status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('ghost_print','Ghost Print' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('ghost_print_status','Ghost Print Status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('motling','Motling' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('motling_status','Motling status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('tape_test','Tape Test' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('tape_test_status','Tape Test Status ' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('rub_test','Rub Test' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('rub_test_status','Rub Test Status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('print_surface_line','Print Surface Line' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('print_surface_line_status','Print Surface Line Status' ,'required|trim|xss_clean');

              $this->form_validation->set_rules('miss_print','Miss Print' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('miss_print_status','Miss Print status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('barcode_test','Barcode test' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('barcode_test_status','Barcode test status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('contamination','Contamination Issue' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('contamination_status','Contamination Issue status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('non_lacquer_area','Non Lacquer Area' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('non_lacquer_area_status','Non Lacquer Area status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('wet_lacquer','Wet Lacquer' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('wet_lacquer_status','Wet Lacquer status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('lacquer_peeloff','Lacquer Peeloff' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('lacquer_peeloff_status','Lacquer Peeloff status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('wavy_lacquer','Wavy Lacquer' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('wavy_lacquer_status','Wavy Lacquer status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('dull_lacquer','Dull Lacquer' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('dull_lacquer_status','Dull Lacquer status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('dirty_lacquer','Dirty Lacquer' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('dirty_lacquer_status','Dirty Lacquer status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('foil_cut','Foil Cut' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('foil_cut_status','Foil Cut status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('foil_shift_vertical','Foil Shift (Vertical)' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('foil_shift_vertical_status','Foil Shift (Vertical) status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('foil_shift_horizontal','Foil Shift (Horizontal)' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('foil_shift_horizontal_status','Foil Shift (Horizontal) status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('foil_thickness','Foil Thickness' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('foil_thickness_status','Foil Thickness status' ,'required|trim|xss_clean');
              
              $this->form_validation->set_rules('masterfile_jobcard_return_status','Master file & Jobcard return status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('rm_return_status','RM return status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('red_create_status','Red create status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('rejected_rolls_clear_status','rejected rolls clear status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('no_loose_tools_status','No loose tools status' ,'required|trim|xss_clean');

              $this->form_validation->set_rules('no_film_roll_status','No Film Roll of Previous Job status' ,'required|trim|xss_clean');

              $this->form_validation->set_rules('machine_cleane_status','Machine cleane status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('machine_ready_status','Machine ready status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('finger_comb_status','Finger comb status' ,'required|trim|xss_clean');
             
              //$this->form_validation->set_rules('new_job','New job/Power Failure/Material Change' ,'required|trim|xss_clean');
              //$this->form_validation->set_rules('shift_change','Shift change/Trial' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('qc_remarks','QC remarks' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('qc_inspection_status','QC inspection status' ,'required|trim|xss_clean');   


            if($this->form_validation->run()==FALSE){

              $cp_id=$this->input->post('cp_id');

              $dataa = array('process_id' =>'2');
              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['springtube_shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
              
              $table='springtube_printing_control_plan_qc';
              $data['springtube_printing_control_plan_qc']=$this->springtube_printing_control_plan_qc_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'cp_id',$cp_id);

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
                $this->load->view('Home/footer');

              }else{

                
                // Updating Master Table--------
                $data=array(

                  'inspection_date'=>$this->input->post('inspection_date'),
                  'shift'=>$this->input->post('shift'), 
                  'jobcard_no'=>$this->input->post('jobcard_no'),                                  
                  'operator'=>trim(strtoupper($this->input->post('operator'))),
                  'de_value'=>$this->input->post('de_value'),
                  'de_value_status'=>$this->input->post('de_value_status'),
                  'treatment'=>$this->input->post('treatment'),
                  'treatment_status'=>$this->input->post('treatment_status'),
                  'shade_variation'=>$this->input->post('shade_variation'),
                  'shade_variation_status'=>$this->input->post('shade_variation_status'),
                  'text_proof'=>$this->input->post('text_proof'),
                  'text_proof_status'=>$this->input->post('text_proof_status'),
                  'lacquer_over_under'=>$this->input->post('lacquer_over_under'),
                  'lacquer_over_under_status'=>$this->input->post('lacquer_over_under_status'),
                  'non_print_area'=>$this->input->post('non_print_area'),
                  'non_print_area_status'=>$this->input->post('non_print_area_status'),
                  'i_mark_position'=>$this->input->post('i_mark_position'),
                  'i_mark_position_status'=>$this->input->post('i_mark_position_status'),
                  'repeat_length_variation'=>$this->input->post('repeat_length_variation'),
                  'repeat_length_variation_status'=>$this->input->post('repeat_length_variation_status'),
                  'print_cut'=>$this->input->post('print_cut'),
                  'print_cut_status'=>$this->input->post('print_cut_status'),
                  'smudge_print'=>$this->input->post('smudge_print'),
                  'smudge_print_status'=>$this->input->post('smudge_print_status'),
                  'ink_dot'=>$this->input->post('ink_dot'),
                  'ink_dot_status'=>$this->input->post('ink_dot_status'),
                  'ghost_print'=>$this->input->post('ghost_print'),
                  'ghost_print_status'=>$this->input->post('ghost_print_status'),
                  'motling'=>$this->input->post('motling'),
                  'motling_status'=>$this->input->post('motling_status'),
                  'tape_test'=>$this->input->post('tape_test'),
                  'tape_test_status'=>$this->input->post('tape_test_status'),
                  'rub_test'=>$this->input->post('rub_test'),
                  'rub_test_status'=>$this->input->post('rub_test_status'),
                  'print_surface_line'=>$this->input->post('print_surface_line'),
                  'print_surface_line_status'=>$this->input->post('print_surface_line_status'),
                  'miss_print'=>$this->input->post('miss_print'),
                  'miss_print_status'=>$this->input->post('miss_print_status'),
                  'barcode_test'=>$this->input->post('barcode_test'),
                  'barcode_test_status'=>$this->input->post('barcode_test_status'),
                  'contamination'=>$this->input->post('contamination'),
                  'contamination_status'=>$this->input->post('contamination_status'),
                  'non_lacquer_area'=>$this->input->post('non_lacquer_area'),
                  'non_lacquer_area_status'=>$this->input->post('non_lacquer_area_status'),
                  'wet_lacquer'=>$this->input->post('wet_lacquer'),
                  'wet_lacquer_status'=>$this->input->post('wet_lacquer_status'),
                  'lacquer_peeloff'=>$this->input->post('lacquer_peeloff'),
                  'lacquer_peeloff_status'=>$this->input->post('lacquer_peeloff_status'),
                  'wavy_lacquer'=>$this->input->post('wavy_lacquer'),
                  'wavy_lacquer_status'=>$this->input->post('wavy_lacquer_status'),
                  'dull_lacquer'=>$this->input->post('dull_lacquer'),
                  'dull_lacquer_status'=>$this->input->post('dull_lacquer_status'),
                  'dirty_lacquer'=>$this->input->post('dirty_lacquer'),
                  'dirty_lacquer_status'=>$this->input->post('dirty_lacquer_status'),
                  'foil_cut'=>$this->input->post('foil_cut'),
                  'foil_cut_status'=>$this->input->post('foil_cut_status'),
                  'foil_shift_vertical'=>$this->input->post('foil_shift_vertical'),
                  'foil_shift_vertical_status'=>$this->input->post('foil_shift_vertical_status'),
                  'foil_shift_horizontal'=>$this->input->post('foil_shift_horizontal'),
                  'foil_shift_horizontal_status'=>$this->input->post('foil_shift_horizontal_status'),
                  'foil_thickness'=>$this->input->post('foil_thickness'),
                  'foil_thickness_status'=>$this->input->post('foil_thickness_status'),
                  'masterfile_jobcard_return_status'=>$this->input->post('masterfile_jobcard_return_status'),
                  'rm_return_status'=>$this->input->post('rm_return_status'),
                  'red_create_status'=>$this->input->post('red_create_status'),
                  'rejected_rolls_clear_status'=>$this->input->post('rejected_rolls_clear_status'),
                  'no_film_roll_status'=>$this->input->post('no_film_roll_status'),
                  'no_loose_tools_status'=>$this->input->post('no_loose_tools_status'),
                  'machine_cleane_status'=>$this->input->post('machine_cleane_status'),
                  'machine_ready_status'=>$this->input->post('machine_ready_status'),
                  'finger_comb_status'=>$this->input->post('finger_comb_status'),                  
                  //'new_job'=>$this->input->post('new_job'),
                  //'shift_change'=>$this->input->post('shift_change'),
                  'new_job_status'=>(!empty($this->input->post('new_job_status')) ? 1 : 0),
                  'power_failure_status'=>(!empty($this->input->post('power_failure_status')) ? 1 : 0),
                  'change_of_rm_status'=>(!empty($this->input->post('change_of_rm_status')) ? 1 : 0),
                  'shift_change_status'=>(!empty($this->input->post('shift_change_status')) ? 1 : 0),
                  'trial_status'=>(!empty($this->input->post('trial_status')) ? 1 : 0),
                  'machine_maintainance_status'=>(!empty($this->input->post('machine_maintainance_status')) ? 1 : 0),
                  'qc_remarks'=>trim(strtoupper($this->input->post('qc_remarks'))),
                  'qc_inspection_status'=>$this->input->post('qc_inspection_status')
                  
                  );

                $this->common_model->update_one_active_record('springtube_printing_control_plan_qc',$data,'cp_id',$this->input->post('cp_id'),$this->session->userdata['logged_in']['company_id']);                
                

                $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());        
                

                $cp_id=$this->input->post('cp_id');

                $dataa = array('process_id' =>'2');
                $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
                $data['springtube_shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
                
                $table='springtube_printing_control_plan_qc';
                $data['springtube_printing_control_plan_qc']=$this->springtube_printing_control_plan_qc_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'cp_id',$cp_id);

                
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

              $table='springtube_printing_control_plan_qc';
              include('pagination_archive.php');
              $data['springtube_printing_control_plan_qc']=$this->springtube_printing_control_plan_qc_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
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

  function delete($cp_id){

      $data['page_name']='Production';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

              $data=array('archive'=>'1');

              $result=$this->common_model->update_one_active_record('springtube_printing_control_plan_qc',$data,'cp_id',$cp_id,$this->session->userdata['logged_in']['company_id']);

              //$result=$this->common_model->update_one_active_record('springtube_article_history',$data,'production_id',$id,$this->session->userdata['logged_in']['company_id']);

              $dataa = array('process_id' =>'2');
              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

              $data['springtube_shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
                
              $table='springtube_printing_control_plan_qc';
              $data['springtube_printing_control_plan_qc']=$this->springtube_printing_control_plan_qc_model->select_one_inactive_record($table,$this->session->userdata['logged_in']['company_id'],'cp_id',$cp_id); 
                
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


     function dearchive($cp_id){

      $data['page_name']='Production';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

              $data=array('archive'=>'0');

              $result=$this->common_model->update_one_active_record('springtube_printing_control_plan_qc',$data,'cp_id',$cp_id,$this->session->userdata['logged_in']['company_id']);

                //$result=$this->common_model->update_one_active_record('springtube_article_history',$data,'production_id',$id,$this->session->userdata['logged_in']['company_id']);

              $dataa = array('process_id' =>'2');
              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['springtube_shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
                
              $table='springtube_printing_control_plan_qc';
              $data['springtube_printing_control_plan_qc']=$this->springtube_printing_control_plan_qc_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'cp_id',$cp_id);
                
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
    function view($cp_id){

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

            $data['springtube_printing_control_plan_qc']=$this->springtube_printing_control_plan_qc_model->select_one_active_record('springtube_printing_control_plan_qc',$this->session->userdata['logged_in']['company_id'],'springtube_printing_control_plan_qc.cp_id',$cp_id);

            

            
            $data['page_name']='Production';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
            $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

            //$this->load->view('Home/header');
            //$this->load->view('Home/nav',$data);
            //$this->load->view('Home/subnav');

            $springtube_printing_control_plan_qc = $data['springtube_printing_control_plan_qc'];
            
            foreach ($springtube_printing_control_plan_qc as $master_row){
             $date1 = $master_row->inspection_date;
            } 

            $date2 = '2023-05-15';

            if($date1 >= $date2){
               $this->load->view('Print/springtube-printing-header',$data);
            }else{
              $this->load->view('Print/header',$data);
            }

            //$this->load->view('Print/header',$data);
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

              $dataa = array('process_id' =>'2');
              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa); 

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
            
            $this->form_validation->set_rules('machine','Machine Name' ,'trim|xss_clean');
            $this->form_validation->set_rules('jobcard_no','Jobcard No.' ,'trim|xss_clean');
            $this->form_validation->set_rules('operator','Operator Name' ,'trim|xss_clean');
            $this->form_validation->set_rules('qc_inspection_status','Inspection status' ,'trim|xss_clean');
            $this->form_validation->set_rules('user_id','Created by' ,'trim|xss_clean');
            
                       
            if($this->form_validation->run()==FALSE){

              $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);

              $dataa = array('process_id' =>'2');
              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa); 

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
              

              $dataa=array(
                  'machine_id'=>$this->input->post('machine'),
                  'jobcard_no'=>$this->input->post('jobcard_no'),
                  'operator'=>$this->input->post('operator'),
                  'qc_inspection_status'=>$this->input->post('qc_inspection_status'),
                  'user_id'=>$this->input->post('user_id')
              );

              $data['springtube_printing_control_plan_qc']=$this->springtube_printing_control_plan_qc_model->active_record_search('springtube_printing_control_plan_qc',$this->session->userdata['logged_in']['company_id'],$dataa,$this->input->post('from_date'),$this->input->post('to_date'));             

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

  function create_parameters($cp_id){    
    
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->new==1){             

              
              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
              
             
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/add-parameter-form',$data);
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

  function save_parameters(){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            
            $this->form_validation->set_rules('operator','Operator' ,'required|trim|xss_clean|alpha');
            
            $this->form_validation->set_rules('flexo_1_corona','Flexa-1 Corona' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('uv_power_1','UV Power' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('uv_speed_1','UV Speed' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('flexo_2_corona','Flexa-2 Corona' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('uv_power_2','UV Power 2' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('uv_speed_2','UV Speed 2' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('printing_speed','Digital Printing Speed' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('corona_dose','Corona Dose' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('unwind_tension','Unwind tension-Tension-Rewind tention6' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('uv_cutting','UV Cutting' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('dyne_test','Dyne Test' ,'required|trim|xss_clean');
            
            
           
            if($this->form_validation->run()==FALSE){       

              
              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/add-parameter-form',$data);
              $this->load->view('Home/footer');
            }else{


                $data=array(
                                    
                  'inspection_time'=>date('h:i:s'),
                  'cp_id'=>$this->input->post('cp_id'),
                  'operator'=>trim(strtoupper($this->input->post('operator'))),
                  'flexo_1_corona'=>$this->input->post('flexo_1_corona'),
                  'uv_power_1'=>$this->input->post('uv_power_1'),
                  'uv_speed_1'=>$this->input->post('uv_speed_1'),
                  'flexo_2_corona'=>$this->input->post('flexo_2_corona'),
                  'uv_power_2'=>$this->input->post('uv_power_2'),
                  'uv_speed_2'=>$this->input->post('uv_speed_2'),
                  'printing_speed'=>$this->input->post('printing_speed'),
                  'corona_dose'=>$this->input->post('corona_dose'),
                  'unwind_tension'=>$this->input->post('unwind_tension'),
                  'uv_cutting'=>$this->input->post('uv_cutting'),
                  'dyne_test'=>$this->input->post('dyne_test'),
                  'company_id'=>$this->session->userdata['logged_in']['company_id']
                  
                  );

                $result=$this->common_model->save('springtube_printing_control_plan_qc_details',$data);                               
                
                
                $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

                $data['note']='Create Transaction Completed';

                header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/add-parameter-form',$data);
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

   

   
  

}

