<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Springtube_bodymaking_control_plan_qc extends CI_Controller {

  function __construct(){

    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('sales_order_book_model');
      $this->load->model('sales_order_status_model');
      $this->load->model('artwork_springtube_model');
      $this->load->model('springtube_bodymaking_control_plan_qc_model');
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

              $table='springtube_bodymaking_control_plan_qc';
              include('pagination.php');
              $data['springtube_bodymaking_control_plan_qc']=$this->springtube_bodymaking_control_plan_qc_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
             
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

              $dataa = array('process_id' =>'5');
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
            $this->form_validation->set_rules('shade_variation','Shade Variations' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('shade_variation_status','Shade Variations Status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('text_proof','Text Proof' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('text_proof_status','Text Proof Status' ,'required|trim|xss_clean');
            
            $this->form_validation->set_rules('non_print_area','Non Print Area' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('non_print_area_status','Non Print Area Status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('i_mark_position','I Mark Position' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('i_mark_position_status','I Mark Position Status' ,'required|trim|xss_clean');
            
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

            $this->form_validation->set_rules('cap_pintle_damage','Cap Pintle' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('cap_pintle_damage_status','Cap pintle status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('cap_damage','Cap damage' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('cap_damage_status','Cap damage status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('cap_scratch','Cap scratch' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('cap_scratch_status','Cap scratch status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('cap_allignment','Cap allignment' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('cap_allignment_status','Cap allignment status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('cap_tube_folding','Cap tube folding' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('cap_tube_folding_status','Cap tube folding status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('cap_fitting','Cap fitting' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('cap_fitting_status','Cap fitting status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('cap_air_leackage','Cap air leackage' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('cap_air_leackage_status','Cap air leackage status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('cap_rotation','Cap rotation' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('cap_rotation_status','Cap rotation status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('cap_pull_force','Cap pull force' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('cap_pull_force_status','Cap pull force status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('cap_hinge_breack','Cap hinge breack' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('cap_hinge_breack_status','Cap hinge breack status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('cap_foil','Cap foil' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('cap_foil_status','Cap foil status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('cap_shrink_sleeve','Cap shrink sleeve (printed/plain)' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('cap_shrink_sleeve_status','Cap shrink sleeve status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('cap_foil_thickness_vari','Cap foil thickness vari' ,'required|trim|xss_clean');

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

            $this->form_validation->set_rules('sleeve_color_code','Sleeve color code' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sleeve_color_code_status','Sleeve color code status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('tube_length','Tube length' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('tube_length_status','Tube length status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('orifice_diameter','Orifice diameter' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('orifice_diameter_status','Orifice diameter status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('welding_defect','Welding defect' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('welding_defect_status','Welding defect status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('shoulder_blend','Shoulder blend' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('shoulder_blend_status','Shoulder blend status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('thread_flash','Thread flash' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('thread_flash_status','Thread flash status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('excess_material','Excess material' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('excess_material_status','Excess material status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('short_shot','Short shot' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('short_shot_status','Short shot status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('orifice_block','Orifice block' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('orifice_block_status','Orifice block status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('shoulder_folding','Shoulder folding' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('shoulder_folding_status','Shoulder folding status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('tube_perforated','Tube perforated' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('tube_perforated_status','Tube perforated status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('shoulder_contamination','Shoulder contamination' ,'required|trim|xss_clean');

            
            $this->form_validation->set_rules('masterfile_jobcard_return_status','Master file & Jobcard return status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('rm_return_status','RM return status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('red_create_status','Red create status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('rejected_tubes_clear_status','rejected Tubes clear status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('no_loose_tools_status','No loose tools status' ,'required|trim|xss_clean');

            $this->form_validation->set_rules('no_tubes_prevjob_status','No Tubes of Previous Job status' ,'required|trim|xss_clean');

            $this->form_validation->set_rules('machine_clean_status','Machine cleane status' ,'required|trim|xss_clean');

            $this->form_validation->set_rules('machine_ready_status','Machine ready status' ,'required|trim|xss_clean');            

            $this->form_validation->set_rules('finger_comb_status','Finger comb status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('finger_comb_status','Finger comb status' ,'required|trim|xss_clean');
           
            //$this->form_validation->set_rules('new_job','New job/Power Failure/Material Change' ,'required|trim|xss_clean');
            //$this->form_validation->set_rules('shift_change','Shift change/Trial' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('qc_remarks','QC remarks' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('qc_inspection_status','QC inspection status' ,'required|trim|xss_clean');             

           
            if($this->form_validation->run()==FALSE){

              $dataa = array('process_id' =>'5');
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

                  'shade_variation'=>$this->input->post('shade_variation'),
                  'shade_variation_status'=>$this->input->post('shade_variation_status'),
                  'text_proof'=>$this->input->post('text_proof'),
                  'text_proof_status'=>$this->input->post('text_proof_status'),
                  
                  'non_print_area'=>$this->input->post('non_print_area'),
                  'non_print_area_status'=>$this->input->post('non_print_area_status'),
                  'i_mark_position'=>$this->input->post('i_mark_position'),
                  'i_mark_position_status'=>$this->input->post('i_mark_position_status'),
                   
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

                  'cap_pintle_damage'=>$this->input->post('cap_pintle_damage'),
                  'cap_pintle_damage_status'=>$this->input->post('cap_pintle_damage_status'),
                  'cap_damage'=>$this->input->post('cap_damage'),
                  'cap_damage_status'=>$this->input->post('cap_damage_status'),
                  'cap_scratch'=>$this->input->post('cap_scratch'),
                  'cap_scratch_status'=>$this->input->post('cap_scratch_status'),
                  'cap_allignment'=>$this->input->post('cap_allignment'),
                  'cap_allignment_status'=>$this->input->post('cap_allignment_status'),
                  'cap_tube_folding'=>$this->input->post('cap_tube_folding'),
                  'cap_tube_folding_status'=>$this->input->post('cap_tube_folding_status'),
                  'cap_fitting'=>$this->input->post('cap_fitting'),
                  'cap_fitting_status'=>$this->input->post('cap_fitting_status'),
                  'cap_air_leackage'=>$this->input->post('cap_air_leackage'),
                  'cap_air_leackage_status'=>$this->input->post('cap_air_leackage_status'),
                  'cap_rotation'=>$this->input->post('cap_rotation'),
                  'cap_rotation_status'=>$this->input->post('cap_rotation_status'),
                  'cap_pull_force'=>$this->input->post('cap_pull_force'),
                  'cap_pull_force_status'=>$this->input->post('cap_pull_force_status'),
                  'cap_hinge_breack'=>$this->input->post('cap_hinge_breack'),
                  'cap_hinge_breack_status'=>$this->input->post('cap_hinge_breack_status'),
                  'cap_shrink_sleeve'=>$this->input->post('cap_shrink_sleeve'),
                  'cap_shrink_sleeve_status'=>$this->input->post('cap_shrink_sleeve_status'),
                  'cap_foil'=>$this->input->post('cap_foil'),
                  'cap_foil_status'=>$this->input->post('cap_foil_status'),
                  'cap_foil_thickness_vari'=>$this->input->post('cap_foil_thickness_vari'),


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

                  'sleeve_color_code'=>$this->input->post('sleeve_color_code'),
                  'sleeve_color_code_status'=>$this->input->post('sleeve_color_code_status'),
                  'tube_length'=>$this->input->post('tube_length'),
                  'tube_length_status'=>$this->input->post('tube_length_status'),
                  'orifice_diameter'=>$this->input->post('orifice_diameter'),
                  'orifice_diameter_status'=>$this->input->post('orifice_diameter_status'),
                  'welding_defect'=>$this->input->post('welding_defect'),
                  'welding_defect_status'=>$this->input->post('welding_defect_status'),
                  'shoulder_blend'=>$this->input->post('shoulder_blend'),
                  'shoulder_blend_status'=>$this->input->post('shoulder_blend_status'),
                  'thread_flash'=>$this->input->post('thread_flash'),
                  'thread_flash_status'=>$this->input->post('thread_flash_status'),
                  'excess_material'=>$this->input->post('excess_material'),
                  'excess_material_status'=>$this->input->post('excess_material_status'),
                  'short_shot'=>$this->input->post('short_shot'),
                  'short_shot_status'=>$this->input->post('short_shot_status'),
                  'orifice_block'=>$this->input->post('orifice_block'),
                  'orifice_block_status'=>$this->input->post('orifice_block_status'),
                  'shoulder_folding'=>$this->input->post('shoulder_folding'),
                  'shoulder_folding_status'=>$this->input->post('shoulder_folding_status'),
                  'tube_perforated'=>$this->input->post('tube_perforated'),
                  'tube_perforated_status'=>$this->input->post('tube_perforated_status'),
                  'shoulder_contamination'=>$this->input->post('shoulder_contamination'),

                  'masterfile_jobcard_return_status'=>$this->input->post('masterfile_jobcard_return_status'),
                  'rm_return_status'=>$this->input->post('rm_return_status'),
                  'red_create_status'=>$this->input->post('red_create_status'),
                  'rejected_tubes_clear_status'=>$this->input->post('rejected_tubes_clear_status'),
                  
                  'no_tubes_prevjob_status'=>$this->input->post('no_tubes_prevjob_status'),
                  'no_loose_tools_status'=>$this->input->post('no_loose_tools_status'),
                  'machine_clean_status'=>$this->input->post('machine_clean_status'),
                  'machine_ready_status'=>$this->input->post('machine_ready_status'),
                  'finger_comb_status'=>$this->input->post('finger_comb_status'),
                  'hooper_cleaning_status'=>$this->input->post('hooper_cleaning_status'),                  
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
                  'created_date'=>date('Y-m-d h:i:s')
                  
                  );

                $result=$this->common_model->save('springtube_bodymaking_control_plan_qc',$data); 
                               
                
                $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

                $data['note']='Create Transaction Completed';

                header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

              
                $dataa = array('process_id' =>'5');
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
             
              $dataa = array('process_id' =>'5');
              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              
              $table='springtube_bodymaking_control_plan_qc';
              $data['springtube_bodymaking_control_plan_qc']=$this->springtube_bodymaking_control_plan_qc_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'cp_id',$cp_id);

              
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
              $this->form_validation->set_rules('jobcard_no','Jobcard No.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('operator','Operator' ,'required|trim|xss_clean');            
              $this->form_validation->set_rules('shade_variation','Shade Variations' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('shade_variation_status','Shade Variations Status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('text_proof','Text Proof' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('text_proof_status','Text Proof Status' ,'required|trim|xss_clean');
              
              $this->form_validation->set_rules('non_print_area','Non Print Area' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('non_print_area_status','Non Print Area Status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('i_mark_position','I Mark Position' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('i_mark_position_status','I Mark Position Status' ,'required|trim|xss_clean');
              
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

              $this->form_validation->set_rules('cap_pintle_damage','Cap Pintle' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_pintle_damage_status','Cap pintle status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_damage','Cap damage' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_damage_status','Cap damage status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_scratch','Cap scratch' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_scratch_status','Cap scratch status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_allignment','Cap allignment' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_allignment_status','Cap allignment status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_tube_folding','Cap tube folding' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_tube_folding_status','Cap tube folding status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_fitting','Cap fitting' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_fitting_status','Cap fitting status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_air_leackage','Cap air leackage' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_air_leackage_status','Cap air leackage status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_rotation','Cap rotation' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_rotation_status','Cap rotation status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_pull_force','Cap pull force' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_pull_force_status','Cap pull force status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_hinge_breack','Cap hinge breack' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_hinge_breack_status','Cap hinge breack status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_foil','Cap foil' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_foil_status','Cap foil status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_shrink_sleeve','Cap shrink sleeve (printed/plain)' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_shrink_sleeve_status','Cap shrink sleeve status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_foil_thickness_vari','Cap foil thickness vari' ,'required|trim|xss_clean');

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

              $this->form_validation->set_rules('sleeve_color_code','Sleeve color code' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sleeve_color_code_status','Sleeve color code status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('tube_length','Tube length' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('tube_length_status','Tube length status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('orifice_diameter','Orifice diameter' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('orifice_diameter_status','Orifice diameter status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('welding_defect','Welding defect' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('welding_defect_status','Welding defect status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('shoulder_blend','Shoulder blend' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('shoulder_blend_status','Shoulder blend status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('thread_flash','Thread flash' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('thread_flash_status','Thread flash status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('excess_material','Excess material' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('excess_material_status','Excess material status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('short_shot','Short shot' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('short_shot_status','Short shot status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('orifice_block','Orifice block' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('orifice_block_status','Orifice block status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('shoulder_folding','Shoulder folding' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('shoulder_folding_status','Shoulder folding status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('tube_perforated','Tube perforated' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('tube_perforated_status','Tube perforated status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('shoulder_contamination','Shoulder contamination' ,'required|trim|xss_clean');

              
              $this->form_validation->set_rules('masterfile_jobcard_return_status','Master file & Jobcard return status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('rm_return_status','RM return status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('red_create_status','Red create status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('rejected_tubes_clear_status','rejected Tubes clear status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('no_loose_tools_status','No loose tools status' ,'required|trim|xss_clean');

              $this->form_validation->set_rules('no_tubes_prevjob_status','No Tubes of Previous Job status' ,'required|trim|xss_clean');

              $this->form_validation->set_rules('machine_clean_status','Machine cleane status' ,'required|trim|xss_clean');

              $this->form_validation->set_rules('machine_ready_status','Machine ready status' ,'required|trim|xss_clean');            

              $this->form_validation->set_rules('finger_comb_status','Finger comb status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('finger_comb_status','Finger comb status' ,'required|trim|xss_clean');
             
              //$this->form_validation->set_rules('new_job','New job/Power Failure/Material Change' ,'required|trim|xss_clean');
              //$this->form_validation->set_rules('shift_change','Shift change/Trial' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('qc_remarks','QC remarks' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('qc_inspection_status','QC inspection status' ,'required|trim|xss_clean');   


            if($this->form_validation->run()==FALSE){

              $cp_id=$this->input->post('cp_id');

              $dataa = array('process_id' =>'5');
              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              
              $table='springtube_bodymaking_control_plan_qc';
              $data['springtube_bodymaking_control_plan_qc']=$this->springtube_bodymaking_control_plan_qc_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'cp_id',$cp_id);

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
                $this->load->view('Home/footer');

              }else{

                
                // Updating Master Table--------
                 $data=array(

                  // 'company_id'=>$this->session->userdata['logged_in']['company_id'],
                  // 'inspection_date'=>$this->input->post('inspection_date'),
                  // 'inspection_time'=>date('h:i:s'),
                  // 'machine_id'=>$this->input->post('machine'),
                  'jobcard_no'=>$this->input->post('jobcard_no'),                  
                  'operator'=>trim(strtoupper($this->input->post('operator'))),

                  'shade_variation'=>$this->input->post('shade_variation'),
                  'shade_variation_status'=>$this->input->post('shade_variation_status'),
                  'text_proof'=>$this->input->post('text_proof'),
                  'text_proof_status'=>$this->input->post('text_proof_status'),
                  
                  'non_print_area'=>$this->input->post('non_print_area'),
                  'non_print_area_status'=>$this->input->post('non_print_area_status'),
                  'i_mark_position'=>$this->input->post('i_mark_position'),
                  'i_mark_position_status'=>$this->input->post('i_mark_position_status'),
                   
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

                  'cap_pintle_damage'=>$this->input->post('cap_pintle_damage'),
                  'cap_pintle_damage_status'=>$this->input->post('cap_pintle_damage_status'),
                  'cap_damage'=>$this->input->post('cap_damage'),
                  'cap_damage_status'=>$this->input->post('cap_damage_status'),
                  'cap_scratch'=>$this->input->post('cap_scratch'),
                  'cap_scratch_status'=>$this->input->post('cap_scratch_status'),
                  'cap_allignment'=>$this->input->post('cap_allignment'),
                  'cap_allignment_status'=>$this->input->post('cap_allignment_status'),
                  'cap_tube_folding'=>$this->input->post('cap_tube_folding'),
                  'cap_tube_folding_status'=>$this->input->post('cap_tube_folding_status'),
                  'cap_fitting'=>$this->input->post('cap_fitting'),
                  'cap_fitting_status'=>$this->input->post('cap_fitting_status'),
                  'cap_air_leackage'=>$this->input->post('cap_air_leackage'),
                  'cap_air_leackage_status'=>$this->input->post('cap_air_leackage_status'),
                  'cap_rotation'=>$this->input->post('cap_rotation'),
                  'cap_rotation_status'=>$this->input->post('cap_rotation_status'),
                  'cap_pull_force'=>$this->input->post('cap_pull_force'),
                  'cap_pull_force_status'=>$this->input->post('cap_pull_force_status'),
                  'cap_hinge_breack'=>$this->input->post('cap_hinge_breack'),
                  'cap_hinge_breack_status'=>$this->input->post('cap_hinge_breack_status'),
                  'cap_shrink_sleeve'=>$this->input->post('cap_shrink_sleeve'),
                  'cap_shrink_sleeve_status'=>$this->input->post('cap_shrink_sleeve_status'),
                  'cap_foil'=>$this->input->post('cap_foil'),
                  'cap_foil_status'=>$this->input->post('cap_foil_status'),
                  'cap_foil_thickness_vari'=>$this->input->post('cap_foil_thickness_vari'),


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

                  'sleeve_color_code'=>$this->input->post('sleeve_color_code'),
                  'sleeve_color_code_status'=>$this->input->post('sleeve_color_code_status'),
                  'tube_length'=>$this->input->post('tube_length'),
                  'tube_length_status'=>$this->input->post('tube_length_status'),
                  'orifice_diameter'=>$this->input->post('orifice_diameter'),
                  'orifice_diameter_status'=>$this->input->post('orifice_diameter_status'),
                  'welding_defect'=>$this->input->post('welding_defect'),
                  'welding_defect_status'=>$this->input->post('welding_defect_status'),
                  'shoulder_blend'=>$this->input->post('shoulder_blend'),
                  'shoulder_blend_status'=>$this->input->post('shoulder_blend_status'),
                  'thread_flash'=>$this->input->post('thread_flash'),
                  'thread_flash_status'=>$this->input->post('thread_flash_status'),
                  'excess_material'=>$this->input->post('excess_material'),
                  'excess_material_status'=>$this->input->post('excess_material_status'),
                  'short_shot'=>$this->input->post('short_shot'),
                  'short_shot_status'=>$this->input->post('short_shot_status'),
                  'orifice_block'=>$this->input->post('orifice_block'),
                  'orifice_block_status'=>$this->input->post('orifice_block_status'),
                  'shoulder_folding'=>$this->input->post('shoulder_folding'),
                  'shoulder_folding_status'=>$this->input->post('shoulder_folding_status'),
                  'tube_perforated'=>$this->input->post('tube_perforated'),
                  'tube_perforated_status'=>$this->input->post('tube_perforated_status'),
                  'shoulder_contamination'=>$this->input->post('shoulder_contamination'),

                  'masterfile_jobcard_return_status'=>$this->input->post('masterfile_jobcard_return_status'),
                  'rm_return_status'=>$this->input->post('rm_return_status'),
                  'red_create_status'=>$this->input->post('red_create_status'),
                  'rejected_tubes_clear_status'=>$this->input->post('rejected_tubes_clear_status'),
                  
                  'no_tubes_prevjob_status'=>$this->input->post('no_tubes_prevjob_status'),
                  'no_loose_tools_status'=>$this->input->post('no_loose_tools_status'),
                  'machine_clean_status'=>$this->input->post('machine_clean_status'),
                  'machine_ready_status'=>$this->input->post('machine_ready_status'),
                  'finger_comb_status'=>$this->input->post('finger_comb_status'),
                  'hooper_cleaning_status'=>$this->input->post('hooper_cleaning_status'),                  
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
                  'user_id'=>$this->session->userdata['logged_in']['user_id']
                  
                  
                  );

                $this->common_model->update_one_active_record('springtube_bodymaking_control_plan_qc',$data,'cp_id',$this->input->post('cp_id'),$this->session->userdata['logged_in']['company_id']);                
                

                $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());        
                

                $cp_id=$this->input->post('cp_id');

                $dataa = array('process_id' =>'5');
                $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
                
                $table='springtube_bodymaking_control_plan_qc';
                $data['springtube_bodymaking_control_plan_qc']=$this->springtube_bodymaking_control_plan_qc_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'cp_id',$cp_id);

                
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

              $table='springtube_bodymaking_control_plan_qc';
              include('pagination_archive.php');
              $data['springtube_bodymaking_control_plan_qc']=$this->springtube_bodymaking_control_plan_qc_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
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

              $result=$this->common_model->update_one_active_record('springtube_bodymaking_control_plan_qc',$data,'cp_id',$cp_id,$this->session->userdata['logged_in']['company_id']);

              //$result=$this->common_model->update_one_active_record('springtube_article_history',$data,'production_id',$id,$this->session->userdata['logged_in']['company_id']);

              $dataa = array('process_id' =>'5');
              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
                
              $table='springtube_bodymaking_control_plan_qc';
              $data['springtube_bodymaking_control_plan_qc']=$this->springtube_bodymaking_control_plan_qc_model->select_one_inactive_record($table,$this->session->userdata['logged_in']['company_id'],'cp_id',$cp_id); 
                
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

              $result=$this->common_model->update_one_active_record('springtube_bodymaking_control_plan_qc',$data,'cp_id',$cp_id,$this->session->userdata['logged_in']['company_id']);

                //$result=$this->common_model->update_one_active_record('springtube_article_history',$data,'production_id',$id,$this->session->userdata['logged_in']['company_id']);

              $dataa = array('process_id' =>'5');
              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
                
              $table='springtube_bodymaking_control_plan_qc';
              $data['springtube_bodymaking_control_plan_qc']=$this->springtube_bodymaking_control_plan_qc_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'cp_id',$cp_id);
                
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

            $data['springtube_bodymaking_control_plan_qc']=$this->springtube_bodymaking_control_plan_qc_model->select_one_active_record('springtube_bodymaking_control_plan_qc',$this->session->userdata['logged_in']['company_id'],'springtube_bodymaking_control_plan_qc.cp_id',$cp_id);

            

            
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

              $dataa = array('process_id' =>'5');
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

              $dataa = array('process_id' =>'5');
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

              $data['springtube_bodymaking_control_plan_qc']=$this->springtube_bodymaking_control_plan_qc_model->active_record_search('springtube_bodymaking_control_plan_qc',$this->session->userdata['logged_in']['company_id'],$dataa,$this->input->post('from_date'),$this->input->post('to_date'));             

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
            
            $this->form_validation->set_rules('chillar_temp','Chiller Temp' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('shaft_temp','Shaft Temp' ,'required|trim|xss_clean');
            //$this->form_validation->set_rules('uv_speed_1','UV Speed' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('laminate_terming_cut','Laminate Terming Cut' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('hf_temp_external','HF Temp External' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('hf_temp_internal','HF Temp Internal' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('pressure_metalic_belt_internal','Pressure Metalic Belt Internal' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('pressure_metalic_belt_external','Pressure Metalic Belt External' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('external_inductor_pressure_1','External Inductor Pressure 1' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('external_inductor_pressure_2','External Inductor Pressure 2' ,'required|trim|xss_clean');

            $this->form_validation->set_rules('pressure_transition_pad','Pressure Transition Pad' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('pressure_cooling_pad','Pressure Cooling Pad' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('triple_reforming_roller','Triple Reforming Roller' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('single_reforming_roller','Single Reforming Roller' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('torque_internal_belt','Torque Internal Belt' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('torque_external_belt','Torque External Belt' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('welding_test_side_seam','Welding Test Side Seam' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('welding_test_tube_head','Welding Test Tube Head' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('cap_fitment','Cap Fitment' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('air_leakage_with_cap','Air Leakage With Cap' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('pull_force_snap_cap','Pull Force Snap Cap' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('cap_alignment','Cap Alignment' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('cap_foil_thickness','Cap Foil Thickness' ,'required|trim|xss_clean');
            
            
           
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
                  'chillar_temp'=>$this->input->post('chillar_temp'),
                  'shaft_temp'=>$this->input->post('shaft_temp'),
                  'laminate_terming_cut'=>$this->input->post('laminate_terming_cut'),
                  'hf_temp_external'=>$this->input->post('hf_temp_external'),
                  'hf_temp_internal'=>$this->input->post('hf_temp_internal'),
                  'pressure_metalic_belt_internal'=>$this->input->post('pressure_metalic_belt_internal'),
                  'pressure_metalic_belt_external'=>$this->input->post('pressure_metalic_belt_external'),
                  'external_inductor_pressure_1'=>$this->input->post('external_inductor_pressure_1'),
                  'external_inductor_pressure_2'=>$this->input->post('external_inductor_pressure_2'),
                  'pressure_transition_pad'=>$this->input->post('pressure_transition_pad'),
                  'pressure_roller_1'=>$this->input->post('pressure_roller_1'),
                  'pressure_cooling_pad'=>$this->input->post('pressure_cooling_pad'),
                  'triple_reforming_roller'=>$this->input->post('triple_reforming_roller'),
                  'single_reforming_roller'=>$this->input->post('single_reforming_roller'),
                  'torque_internal_belt'=>$this->input->post('torque_internal_belt'),
                  'torque_external_belt'=>$this->input->post('torque_external_belt'),
                  'welding_test_side_seam'=>$this->input->post('welding_test_side_seam'),
                  'welding_test_tube_head'=>$this->input->post('welding_test_tube_head'),
                  'cap_fitment'=>$this->input->post('cap_fitment'),
                  'air_leakage_with_cap'=>$this->input->post('air_leakage_with_cap'),
                  'pull_force_snap_cap'=>$this->input->post('pull_force_snap_cap'),
                  'cap_alignment'=>$this->input->post('cap_alignment'),
                  'cap_foil_thickness'=>$this->input->post('cap_foil_thickness'),
                  'company_id'=>$this->session->userdata['logged_in']['company_id']
                  
                  );

                $result=$this->common_model->save('springtube_bodymaking_control_plan_qc_details',$data);                               
                
                
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

