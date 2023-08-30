<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coex_extrusion_qc_control_plan extends CI_Controller {

  function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('coex_extrusion_qc_control_plan_model');
      $this->load->model('coex_extrusion_qc_control_plan_parameters_model');
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
              $table='coex_extrusion_qc_control_plan';
              include('pagination.php');
             $data['coex_extrusion_qc_control_plan']=$this->coex_extrusion_qc_control_plan_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

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
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){
            $dataa = array('process_id' =>'1');
            $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
            $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
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

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $this->form_validation->set_rules('inspection_date','inspection Date' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('machine','Machine' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('shift','Shift' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('jobcard_no','Job Card No' ,'required|trim|xss_clean');

            if($this->form_validation->run()==FALSE){
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
              $this->load->view('Home/footer');
            }else{

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'inspection_date'=>date('Y-m-d'),
                'inspection_time'=>date('h:i:s'),
                'machine_id'=>$this->input->post('machine'),
                'shift_id'=>$this->input->post('shift'),
                'jobcard_no'=>$this->input->post('jobcard_no'),
                'order_no'=>$this->input->post('order_no'),
                'article_no'=>$this->input->post('article_no'),
                'operator'=>$this->input->post('operator'),                
                'masterfile_jobcard_return_status'=>$this->input->post('masterfile_jobcard_return_status'),
                'rm_return_status'=>$this->input->post('rm_return_status'),
                'red_create_status'=>$this->input->post('red_create_status'),
                'rejected_sleeves_clear_status'=>$this->input->post('rejected_sleeves_clear_status'),
                'no_loose_tools_status'=>$this->input->post('no_loose_tools_status'),
                'no_sleeves_of_previous_job_status'=>$this->input->post('no_sleeves_of_previous_job_status'),
                'machine_clean_status'=>$this->input->post('machine_clean_status'),
                'machine_ready_status'=>$this->input->post('machine_ready_status'),
                'finger_comb_status'=>$this->input->post('finger_comb_status'),
                'new_job_status'=>(!empty($this->input->post('new_job_status')) ? 1 : 0),                
                'power_failure_status'=>(!empty($this->input->post('power_failure_status')) ? 1 : 0),
                'change_of_rm_status'=>(!empty($this->input->post('change_of_rm_status')) ? 1 : 0),
                'shift_change_status'=>(!empty($this->input->post('shift_change_status')) ? 1 : 0),
                'mould_trial_status'=>(!empty($this->input->post('mould_trial_status')) ? 1 : 0),
                'machine_maintainance_status'=>(!empty($this->input->post('machine_maintainance_status')) ? 1 : 0),
                'remark'=>$this->input->post('remark'),
                'inspection_status'=>$this->input->post('inspection_status'),
                'inspector'=>$this->input->post('inspector'),
                'std_dia_actual'=>$this->input->post('std_dia_actual'),
                'std_dia_status'=>$this->input->post('std_dia_status'),
                'outer_dia_actual'=>$this->input->post('outer_dia_actual'),
                'outer_dia_status'=>$this->input->post('outer_dia_status'),
                'inner_dia_actual'=>$this->input->post('inner_dia_actual'),
                'inner_dia_status'=>$this->input->post('inner_dia_status'),
                'total_thickness_actual'=>$this->input->post('total_thickness_actual'),
                'total_thickness_status'=>$this->input->post('total_thickness_status'),
                'std_weight_actual'=>$this->input->post('std_weight_actual'),
                'std_weight_status'=>$this->input->post('std_weight_status'),
                'std_length_actual'=>$this->input->post('std_length_actual'),
                'gauge_layer_1'=>$this->input->post('gauge_layer_1'),
                'gauge_layer_one_status'=>$this->input->post('gauge_layer_one_status'),                
                'gauge_layer_2'=>$this->input->post('gauge_layer_2'),
                'gauge_layer_two_status'=>$this->input->post('gauge_layer_two_status'),
                'gauge_layer_3'=>$this->input->post('gauge_layer_3'),
                'gauge_layer_three_status'=>$this->input->post('gauge_layer_three_status'),
                'gauge_layer_4'=>$this->input->post('gauge_layer_4'),
                'gauge_layer_four_status'=>$this->input->post('gauge_layer_four_status'),
                'gauge_layer_5'=>$this->input->post('gauge_layer_5'),
                'gauge_layer_five_status'=>$this->input->post('gauge_layer_five_status'),
                'layer_one'=>$this->input->post('layer_one'),
                'layer_one_status'=>$this->input->post('layer_one_status'),
                'layer_two'=>$this->input->post('layer_two'),
                'layer_two_status'=>$this->input->post('layer_two_status'),
                'layer_three'=>$this->input->post('layer_three'),
                'layer_three_status'=>$this->input->post('layer_three_status'),
                'layer_four'=>$this->input->post('layer_four'),
                'layer_four_status'=>$this->input->post('layer_four_status'),
                'layer_five'=>$this->input->post('layer_five'),
                'layer_five_status'=>$this->input->post('layer_five_status'),
                'sleeve_length_actual'=>$this->input->post('sleeve_length_actual'),
                'sleeve_length_status'=>$this->input->post('sleeve_length_status'),
                'color_diffrence_actual'=>$this->input->post('color_diffrence_actual'),
                'color_diffrence_status'=>$this->input->post('color_diffrence_status'),
                'opacity_actual'=>$this->input->post('opacity_actual'),
                'opacity_status'=>$this->input->post('opacity_status'),
                'cutting_quality_actual'=>$this->input->post('cutting_quality_actual'),
                'cutting_quality_status'=>$this->input->post('cutting_quality_status'),
                'die_line_actual'=>$this->input->post('die_line_actual'),
                'die_line_status'=>$this->input->post('die_line_status'),
                'scratch_line_actual'=>$this->input->post('scratch_line_actual'),
                'scratch_line_status'=>$this->input->post('scratch_line_status'),
                'pit_watermark_actual'=>$this->input->post('pit_watermark_actual'),
                'pit_watermark_status'=>$this->input->post('pit_watermark_status'),
                'contamination_actual'=>$this->input->post('contamination_actual'),
                'contamination_status'=>$this->input->post('contamination_status'),
                'rings_inside_outside_actual'=>$this->input->post('rings_inside_outside_actual'),
                'rings_inside_outside_status'=>$this->input->post('rings_inside_outside_status'),
                'color_dispersion_actual'=>$this->input->post('color_dispersion_actual'),
                'color_dispersion_status'=>$this->input->post('color_dispersion_status'),
                'oval_tube_actual'=>$this->input->post('oval_tube_actual'),
                'oval_tube_status'=>$this->input->post('oval_tube_status'),
                'master_batch_inner_layer'=>$this->input->post('master_batch_inner_layer'),
                'inner_layer_master_batch_status'=>$this->input->post('inner_layer_master_batch_status'),
                'master_batch_outer_layer'=>$this->input->post('master_batch_outer_layer'),
                'outer_layer_master_batch_status'=>$this->input->post('outer_layer_master_batch_status'),
                'user_id'=>$this->session->userdata['logged_in']['user_id']
                 );

              $result=$this->common_model->save('coex_extrusion_qc_control_plan',$data);

              $data['page_name']='Prodution';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $data['note']='Create Transaction Completed';

              header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

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

function add(){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form-parameters',$data);
              $this->load->view('Home/footer');
            
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

function save_parameter(){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $this->form_validation->set_rules('inspection_date','inspection Date' ,'required|trim|xss_clean');

            if($this->form_validation->run()==FALSE){

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form-parameters',$data);
              $this->load->view('Home/footer');
            }else{

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'inspection_date'=>$this->input->post('inspection_date'),
                'jobcard_no'=>$this->input->post('jobcard_no'),
                'ceqcp_id'=>$this->input->post('ceqcp_id'),
                'inspection_time'=>$this->input->post('time'),
                'extruder_1_hooper_throat_std'=>$this->input->post('extruder_1_hooper_throat_std'),
                'extruder_1_hooper_throat_actual'=>$this->input->post('extruder_1_hooper_throat_actual'),
                'extruder_1_zone_1_std'=>$this->input->post('extruder_1_zone_1_std'),
                'extruder_1_zone_1_actual'=>$this->input->post('extruder_1_zone_1_actual'),
                'extruder_1_zone_2_std'=>$this->input->post('extruder_1_zone_2_std'),
                'extruder_1_zone_2_actual'=>$this->input->post('extruder_1_zone_2_actual'),
                'extruder_1_zone_3_std'=>$this->input->post('extruder_1_zone_3_std'),
                'extruder_1_zone_3_actual'=>$this->input->post('extruder_1_zone_3_actual'),
                'extruder_1_zone_4_std'=>$this->input->post('extruder_1_zone_4_std'),
                'extruder_1_zone_4_actual'=>$this->input->post('extruder_1_zone_4_actual'),
                'extruder_1_zone_6_std'=>$this->input->post('extruder_1_zone_6_std'),
                'extruder_1_zone_6_actual'=>$this->input->post('extruder_1_zone_6_actual'),
                'extruder_2_hooper_throat_std'=>$this->input->post('extruder_2_hooper_throat_std'),
                'extruder_2_hooper_throat_actual'=>$this->input->post('extruder_2_hooper_throat_actual'),
                'extruder_2_zone_1_std'=>$this->input->post('extruder_2_zone_1_std'),
                'extruder_2_zone_1_actual'=>$this->input->post('extruder_2_zone_1_actual'),
                'extruder_2_zone_2_std'=>$this->input->post('extruder_2_zone_2_std'),
                'extruder_2_zone_2_actual'=>$this->input->post('extruder_2_zone_2_actual'),
                'extruder_2_zone_3_std'=>$this->input->post('extruder_2_zone_3_std'),
                'extruder_2_zone_3_actual'=>$this->input->post('extruder_2_zone_3_actual'),
                'extruder_2_zone_4_std'=>$this->input->post('extruder_2_zone_4_std'),
                'extruder_2_zone_4_actual'=>$this->input->post('extruder_2_zone_4_actual'),
                'extruder_3_hooper_throat_std'=>$this->input->post('extruder_3_hooper_throat_std'),
                'extruder_3_hooper_throat_actual'=>$this->input->post('extruder_3_hooper_throat_actual'),
                'extruder_3_zone_1_std'=>$this->input->post('extruder_3_zone_1_std'),
                'extruder_3_zone_1_actual'=>$this->input->post('extruder_3_zone_1_actual'),
                'extruder_3_zone_2_std'=>$this->input->post('extruder_3_zone_2_std'),
                'extruder_3_zone_2_actual'=>$this->input->post('extruder_3_zone_2_actual'),
                'extruder_3_zone_3_std'=>$this->input->post('extruder_3_zone_3_std'),
                'extruder_3_zone_3_actual'=>$this->input->post('extruder_3_zone_3_actual'),
                'extruder_3_zone_4_std'=>$this->input->post('extruder_3_zone_4_std'),
                'extruder_3_zone_4_actual'=>$this->input->post('extruder_3_zone_4_actual'),
                'extruder_4_hooper_throat_std'=>$this->input->post('extruder_4_hooper_throat_std'),
                'extruder_4_hooper_throat_actual'=>$this->input->post('extruder_4_hooper_throat_actual'),
                'extruder_4_zone_1_std'=>$this->input->post('extruder_4_zone_1_std'),
                'extruder_4_zone_1_actual'=>$this->input->post('extruder_4_zone_1_actual'),
                'extruder_4_zone_2_std'=>$this->input->post('extruder_4_zone_2_std'),
                'extruder_4_zone_2_actual'=>$this->input->post('extruder_4_zone_2_actual'),
                'extruder_4_zone_3_std'=>$this->input->post('extruder_4_zone_3_std'),
                'extruder_4_zone_3_actual'=>$this->input->post('extruder_4_zone_3_actual'),
                'extruder_4_zone_4_std'=>$this->input->post('extruder_4_zone_4_std'),
                'extruder_4_zone_4_actual'=>$this->input->post('extruder_4_zone_4_actual'),
                'extruder_4_zone_5_std'=>$this->input->post('extruder_4_zone_5_std'),
                'extruder_4_zone_5_actual'=>$this->input->post('extruder_4_zone_5_actual'),
                'extruder_4_zone_6_std'=>$this->input->post('extruder_4_zone_6_std'),
                'extruder_4_zone_6_actual'=>$this->input->post('extruder_4_zone_6_actual'),
                'die_head_zone_6_std'=>$this->input->post('die_head_zone_6_std'),
                'die_head_zone_6_actual'=>$this->input->post('die_head_zone_6_actual'),
                'die_head_zone_7_std'=>$this->input->post('die_head_zone_7_std'),
                'die_head_zone_7_actual'=>$this->input->post('die_head_zone_7_actual'),
                'die_head_zone_8_std'=>$this->input->post('die_head_zone_8_std'),
                'die_head_zone_8_actual'=>$this->input->post('die_head_zone_8_actual'),
                'die_head_zone_9_std'=>$this->input->post('die_head_zone_9_std'),
                'die_head_zone_9_actual'=>$this->input->post('die_head_zone_9_actual'),
                'die_head_zone_10_std'=>$this->input->post('die_head_zone_10_std'),
                'die_head_zone_10_actual'=>$this->input->post('die_head_zone_10_actual'),
                'die_head_zone_11_std'=>$this->input->post('die_head_zone_11_std'),
                'die_head_zone_11_actual'=>$this->input->post('die_head_zone_11_actual'),
                'screw_rpm_outer_layer_std'=>$this->input->post('screw_rpm_outer_layer_std'),
                'screw_rpm_outer_layer_actual'=>$this->input->post('screw_rpm_outer_layer_actual'),
                'screw_rpm_admer_layer_std'=>$this->input->post('screw_rpm_admer_layer_std'),
                'screw_rpm_admer_layer_actual'=>$this->input->post('screw_rpm_admer_layer_actual'),
                'screw_rpm_evoh_layer_std'=>$this->input->post('screw_rpm_evoh_layer_std'),
                'screw_rpm_evoh_layer_actual'=>$this->input->post('screw_rpm_evoh_layer_actual'),
                'screw_rpm_inner_layer_std'=>$this->input->post('screw_rpm_inner_layer_std'),
                'screw_rpm_inner_layer_actual'=>$this->input->post('screw_rpm_inner_layer_actual'),
                'temp_z1_std'=>$this->input->post('temp_z1_std'),
                'temp_z1_actual'=>$this->input->post('temp_z1_actual'),
                'temp_z2_std'=>$this->input->post('temp_z2_std'),
                'temp_z2_actual'=>$this->input->post('temp_z2_actual'),
                'temp_z3_std'=>$this->input->post('temp_z3_std'),
                'temp_z3_actual'=>$this->input->post('temp_z3_actual'),
                'temp_z4_std'=>$this->input->post('temp_z4_std'),
                'temp_z4_actual'=>$this->input->post('temp_z4_actual'),
                'temp_z5_std'=>$this->input->post('temp_z5_std'),
                'temp_z5_actual'=>$this->input->post('temp_z5_actual'),
                'temp_z6_std'=>$this->input->post('temp_z6_std'),
                'temp_z6_actual'=>$this->input->post('temp_z6_actual'),
                'temp_z7_std'=>$this->input->post('temp_z7_std'),
                'temp_z7_actual'=>$this->input->post('temp_z7_actual'),
                'temp_z8_std'=>$this->input->post('temp_z8_std'),
                'temp_z8_actual'=>$this->input->post('temp_z8_actual'),
                'temp_z9_std'=>$this->input->post('temp_z9_std'),
                'temp_z9_actual'=>$this->input->post('temp_z9_actual'),
                'vacuum_tank_1_std'=>$this->input->post('vacuum_tank_1_std'),
                'vacuum_tank_1_actual'=>$this->input->post('vacuum_tank_1_actual'),
                'vacuum_tank_2_std'=>$this->input->post('vacuum_tank_2_std'),
                'vacuum_tank_2_actual'=>$this->input->post('vacuum_tank_2_actual'),
                'water_temp_tank_1_std'=>$this->input->post('water_temp_tank_1_std'),
                'water_temp_tank_1_actual'=>$this->input->post('water_temp_tank_1_actual'),
                'water_temp_tank_2_std'=>$this->input->post('water_temp_tank_2_std'),
                'water_temp_tank_2_actual'=>$this->input->post('water_temp_tank_2_actual'),
                'annealing_water_temp_t2_std'=>$this->input->post('annealing_water_temp_t2_std'),
                'annealing_water_temp_t2_actual'=>$this->input->post('annealing_water_temp_t2_actual'),
                'cutting_setting_value_std'=>$this->input->post('cutting_setting_value_std'),
                'cutting_setting_value_atual'=>$this->input->post('cutting_setting_value_atual'),
                'calibrator_water_d4_std'=>$this->input->post('calibrator_water_d4_std'),
                'calibrator_water_d4_actual'=>$this->input->post('calibrator_water_d4_actual'),
                'calibrator_water_d5_std'=>$this->input->post('calibrator_water_d5_std'),
                'calibrator_water_d5_actual'=>$this->input->post('calibrator_water_d5_actual'),
                'calibrator_water_d6_std'=>$this->input->post('calibrator_water_d6_std'),
                'calibrator_water_d6_actual'=>$this->input->post('calibrator_water_d6_actual'),
                'calibrator_water_d7_std'=>$this->input->post('calibrator_water_d7_std'),
                'calibrator_water_d7_actual'=>$this->input->post('calibrator_water_d7_actual'),
                'calibrator_water_d8_std'=>$this->input->post('calibrator_water_d8_std'),
                'calibrator_water_d8_actual'=>$this->input->post('calibrator_water_d8_actual'),
                'annealing_zone_d9_std'=>$this->input->post('annealing_zone_d9_std'),
                'annealing_zone_d9_actual'=>$this->input->post('annealing_zone_d9_actual'),
                'annealing_zone_d10_std'=>$this->input->post('annealing_zone_d10_std'),
                'annealing_zone_d10_actual'=>$this->input->post('annealing_zone_d10_actual'),
                'zumbac_value_std'=>$this->input->post('zumbac_value_std'),
                'zumbac_value_actual'=>$this->input->post('zumbac_value_actual'),
                'length_observed_std'=>$this->input->post('length_observed_std'),
                'length_observed_actual'=>$this->input->post('length_observed_actual'),
                'outer_diameter_std'=>$this->input->post('outer_diameter_std'),
                'outer_diameter_actual'=>$this->input->post('outer_diameter_actual'),
                'inner_diameter_std'=>$this->input->post('inner_diameter_std'),
                'inner_diameter_actual'=>$this->input->post('inner_diameter_actual'),
                'thickness_std'=>$this->input->post('thickness_std'),
                'thickness_actual'=>$this->input->post('thickness_actual'),
                'weight_std'=>$this->input->post('weight_std'),
                'weight_actual'=>$this->input->post('weight_actual'),
                'hourly_sign_tube_std'=>$this->input->post('hourly_sign_tube_std'),
                'hourly_sign_tube_actual'=>$this->input->post('hourly_sign_tube_actual'),
                'checked_by_operator'=>$this->input->post('checked_by_operator'),
                'verified_by_qc'=>$this->input->post('verified_by_qc'));
                
        $result=$this->common_model->save('coex_extrusion_qc_control_plan_parameter',$data);

              $data['page_name']='Prodution';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $data['note']='Create Transaction Completed';

              header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form-parameters',$data);
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

            $data['coex_extrusion_qc_control_plan']=$this->coex_extrusion_qc_control_plan_model->select_one_active_record('coex_extrusion_qc_control_plan',$this->session->userdata['logged_in']['company_id'],'coex_extrusion_qc_control_plan.ceqcp_id',$this->uri->segment(3));

            $data['coex_extrusion_qc_control_plan_parameters']=$this->common_model->select_one_active_record('coex_extrusion_qc_control_plan_parameter',$this->session->userdata['logged_in']['company_id'],'coex_extrusion_qc_control_plan_parameter.ceqcp_id',$this->uri->segment(3));
            //echo $this->db->last_query();


            $this->load->view('Print/header',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/view-form',$data);
          }else{
              $data['note']='No View rights Thanks';
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
      $data['note']='No view rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  
  }



    function modify(){
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,'Coex_extrusion_qc_control_plan');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){

            $dataa = array('process_id' =>'1');
            $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
            $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['coex_extrusion_qc_control_plan']=$this->coex_extrusion_qc_control_plan_model->select_one_active_record('coex_extrusion_qc_control_plan',$this->session->userdata['logged_in']['company_id'],'coex_extrusion_qc_control_plan.ceqcp_id',$this->uri->segment(3));



              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
              $this->load->view('Home/footer');
          }else{
              $data['note']='No Modify rights Thanks';
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
      $data['note']='No Modify rights Thanks';
      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  
  }

  function modify_parameter(){
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,'Coex_extrusion_qc_control_plan');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){

            $dataa = array('process_id' =>'1');

            $data['coex_extrusion_qc_control_plan_parameter']=$this->common_model->select_one_active_record('coex_extrusion_qc_control_plan_parameter',$this->session->userdata['logged_in']['company_id'],'coex_extrusion_qc_control_plan_parameter.ceqcpp_id',$this->uri->segment(3));



              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/modify-form-parameters',$data);
              $this->load->view('Home/footer');
          }else{
              $data['note']='No Modify rights Thanks';
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
      $data['note']='No Modify rights Thanks';
      $data['page_name']='Sales';
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
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,'coex_extrusion_qc_control_plan');

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){

            $this->form_validation->set_rules('project_name','Project Name' ,'required|trim|xss_clean');


              if($this->form_validation->run()==FALSE){
                $dataa = array('process_id' =>'1');
                $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
                $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
                $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['coex_extrusion_qc_control_plan']=$this->coex_extrusion_qc_control_plan_model->select_one_active_record('coex_extrusion_qc_control_plan',$this->session->userdata['logged_in']['company_id'],'coex_extrusion_qc_control_plan.ceqcp_id',$this->input->post('ceqcp_id'));

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
                $this->load->view('Home/footer');

              }else{

                $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'inspection_date'=>date('Y-m-d'),
                'inspection_time'=>date('h:i:s'),
                'machine_id'=>$this->input->post('machine'),
                'shift_id'=>$this->input->post('shift'),
                'jobcard_no'=>$this->input->post('jobcard_no'),
                'order_no'=>$this->input->post('order_no'),
                'article_no'=>$this->input->post('article_no'),
                'masterfile_jobcard_return_status'=>$this->input->post('masterfile_jobcard_return_status'),
                'rm_return_status'=>$this->input->post('rm_return_status'),
                'red_create_status'=>$this->input->post('red_create_status'),
                'rejected_sleeves_clear_status'=>$this->input->post('rejected_sleeves_clear_status'),
                'no_loose_tools_status'=>$this->input->post('no_loose_tools_status'),
                'no_sleeves_of_previous_job_status'=>$this->input->post('no_sleeves_of_previous_job_status'),
                'machine_clean_status'=>$this->input->post('machine_clean_status'),
                'machine_ready_status'=>$this->input->post('machine_ready_status'),
                'finger_comb_status'=>$this->input->post('finger_comb_status'),
                'new_job_status'=>(!empty($this->input->post('new_job_status')) ? 1 : 0),
                'power_failure_status'=>(!empty($this->input->post('power_failure_status')) ? 1 : 0),
                'change_of_rm_status'=>(!empty($this->input->post('change_of_rm_status')) ? 1 : 0),
                'shift_change_status'=>(!empty($this->input->post('shift_change_status')) ? 1 : 0),
                'mould_trial_status'=>(!empty($this->input->post('mould_trial_status')) ? 1 : 0),
                'machine_maintainance_status'=>(!empty($this->input->post('machine_maintainance_status')) ? 1 : 0),
                'remark'=>$this->input->post('remark'),
                'inspection_status'=>$this->input->post('inspection_status'),
                'inspector'=>$this->input->post('inspector'),
                'std_dia_actual'=>$this->input->post('std_dia_actual'),
                'std_dia_status'=>$this->input->post('std_dia_status'),
                'outer_dia_actual'=>$this->input->post('outer_dia_actual'),
                'outer_dia_status'=>$this->input->post('outer_dia_status'),
                'inner_dia_actual'=>$this->input->post('inner_dia_actual'),
                'inner_dia_status'=>$this->input->post('inner_dia_status'),
                'total_thickness_actual'=>$this->input->post('total_thickness_actual'),
                'total_thickness_status'=>$this->input->post('total_thickness_status'),
                'std_weight_actual'=>$this->input->post('std_weight_actual'),
                'std_weight_status'=>$this->input->post('std_weight_status'),
                'std_length_actual'=>$this->input->post('std_length_actual'),
                'outer_layer_micron_actual'=>$this->input->post('outer_layer_micron_actual'),
                'outer_layer_micron_status'=>$this->input->post('outer_layer_micron_status'),
                'inner_layer_micron_actual'=>$this->input->post('inner_layer_micron_actual'),
                'inner_layer_micron_status'=>$this->input->post('inner_layer_micron_status'),
                'admer_layer_one_micron_actual'=>$this->input->post('admer_layer_one_micron_actual'),
                'admer_layer_one_micron_status'=>$this->input->post('admer_layer_one_micron_status'),
                'evoh_layer_micron_actual'=>$this->input->post('evoh_layer_micron_actual'),
                'evoh_layer_micron_status'=>$this->input->post('evoh_layer_micron_status'),
                'admer_layer_two_micron_actual'=>$this->input->post('admer_layer_two_micron_actual'),
                'grade_perc_of_blend_actual'=>$this->input->post('grade_perc_of_blend_actual'),
                'grade_perc_of_blend_status'=>$this->input->post('grade_perc_of_blend_status'),
                'sleeve_length_actual'=>$this->input->post('sleeve_length_actual'),
                'sleeve_length_status'=>$this->input->post('sleeve_length_status'),
                'color_diffrence_actual'=>$this->input->post('color_diffrence_actual'),
                'color_diffrence_status'=>$this->input->post('color_diffrence_status'),
                'opacity_actual'=>$this->input->post('opacity_actual'),
                'opacity_status'=>$this->input->post('opacity_status'),
                'cutting_quality_actual'=>$this->input->post('cutting_quality_actual'),
                'cutting_quality_status'=>$this->input->post('cutting_quality_status'),
                'die_line_actual'=>$this->input->post('die_line_actual'),
                'die_line_status'=>$this->input->post('die_line_status'),
                'scratch_line_actual'=>$this->input->post('scratch_line_actual'),
                'scratch_line_status'=>$this->input->post('scratch_line_status'),
                'pit_watermark_actual'=>$this->input->post('pit_watermark_actual'),
                'pit_watermark_status'=>$this->input->post('pit_watermark_status'),
                'contamination_actual'=>$this->input->post('contamination_actual'),
                'contamination_status'=>$this->input->post('contamination_status'),
                'rings_inside_outside_actual'=>$this->input->post('rings_inside_outside_actual'),
                'rings_inside_outside_status'=>$this->input->post('rings_inside_outside_status'),
                'color_dispersion_actual'=>$this->input->post('color_dispersion_actual'),
                'color_dispersion_status'=>$this->input->post('color_dispersion_status'),
                'oval_tube_actual'=>$this->input->post('oval_tube_actual'),
                'oval_tube_status'=>$this->input->post('oval_tube_status'),
                'mb_color_perc_actual'=>$this->input->post('mb_color_perc_actual'),
                'mb_color_perc_status'=>$this->input->post('mb_color_perc_status'));

                $result=$this->common_model->update_one_active_record('coex_extrusion_qc_control_plan',$data,'ceqcp_id',$this->input->post('ceqcp_id'),$this->session->userdata['logged_in']['company_id']);
                $dataa = array('process_id' =>'1');
                $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
                $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
                $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['coex_extrusion_qc_control_plan']=$this->coex_extrusion_qc_control_plan_model->select_one_active_record('coex_extrusion_qc_control_plan',$this->session->userdata['logged_in']['company_id'],'coex_extrusion_qc_control_plan.ceqcp_id',$this->input->post('ceqcp_id'));

                $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,'coex_extrusion_qc_control_plan');

                  $data['note']='Update Transaction Completed';
                  //header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                  $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
                  $this->load->view('Home/footer');
              }
            }else{
              $data['note']='No Modify rights Thanks';
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
      $data['note']='No Modify rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  }


  function update_parameter(){
      $data['page_name']='Production';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,'coex_extrusion_qc_control_plan');

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){

              $this->form_validation->set_rules('inspection_date','Inspection Date' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('jobcard_no','Job Card No' ,'required|trim|xss_clean');


              if($this->form_validation->run()==FALSE){
               $data['coex_extrusion_qc_control_plan_parameter']=$this->common_model->select_one_active_record('coex_extrusion_qc_control_plan_parameter',$this->session->userdata['logged_in']['company_id'],'coex_extrusion_qc_control_plan_parameter.ceqcpp_id',$this->input->post('ceqcpp_id'));

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/modify-form-parameters',$data);
                $this->load->view('Home/footer');

              }else{

                $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'inspection_date'=>$this->input->post('inspection_date'),
                'jobcard_no'=>$this->input->post('jobcard_no'),
                'ceqcp_id'=>$this->input->post('ceqcp_id'),
                'inspection_time'=>$this->input->post('time'),
                'extruder_1_hooper_throat_std'=>$this->input->post('extruder_1_hooper_throat_std'),
                'extruder_1_hooper_throat_actual'=>$this->input->post('extruder_1_hooper_throat_actual'),
                'extruder_1_zone_1_std'=>$this->input->post('extruder_1_zone_1_std'),
                'extruder_1_zone_1_actual'=>$this->input->post('extruder_1_zone_1_actual'),
                'extruder_1_zone_2_std'=>$this->input->post('extruder_1_zone_2_std'),
                'extruder_1_zone_2_actual'=>$this->input->post('extruder_1_zone_2_actual'),
                'extruder_1_zone_3_std'=>$this->input->post('extruder_1_zone_3_std'),
                'extruder_1_zone_3_actual'=>$this->input->post('extruder_1_zone_3_actual'),
                'extruder_1_zone_4_std'=>$this->input->post('extruder_1_zone_4_std'),
                'extruder_1_zone_4_actual'=>$this->input->post('extruder_1_zone_4_actual'),
                'extruder_1_zone_6_std'=>$this->input->post('extruder_1_zone_6_std'),
                'extruder_1_zone_6_actual'=>$this->input->post('extruder_1_zone_6_actual'),
                'extruder_2_hooper_throat_std'=>$this->input->post('extruder_2_hooper_throat_std'),
                'extruder_2_hooper_throat_actual'=>$this->input->post('extruder_2_hooper_throat_actual'),
                'extruder_2_zone_1_std'=>$this->input->post('extruder_2_zone_1_std'),
                'extruder_2_zone_1_actual'=>$this->input->post('extruder_2_zone_1_actual'),
                'extruder_2_zone_2_std'=>$this->input->post('extruder_2_zone_2_std'),
                'extruder_2_zone_2_actual'=>$this->input->post('extruder_2_zone_2_actual'),
                'extruder_2_zone_3_std'=>$this->input->post('extruder_2_zone_3_std'),
                'extruder_2_zone_3_actual'=>$this->input->post('extruder_2_zone_3_actual'),
                'extruder_2_zone_4_std'=>$this->input->post('extruder_2_zone_4_std'),
                'extruder_2_zone_4_actual'=>$this->input->post('extruder_2_zone_4_actual'),
                'extruder_3_hooper_throat_std'=>$this->input->post('extruder_3_hooper_throat_std'),
                'extruder_3_hooper_throat_actual'=>$this->input->post('extruder_3_hooper_throat_actual'),
                'extruder_3_zone_1_std'=>$this->input->post('extruder_3_zone_1_std'),
                'extruder_3_zone_1_actual'=>$this->input->post('extruder_3_zone_1_actual'),
                'extruder_3_zone_2_std'=>$this->input->post('extruder_3_zone_2_std'),
                'extruder_3_zone_2_actual'=>$this->input->post('extruder_3_zone_2_actual'),
                'extruder_3_zone_3_std'=>$this->input->post('extruder_3_zone_3_std'),
                'extruder_3_zone_3_actual'=>$this->input->post('extruder_3_zone_3_actual'),
                'extruder_3_zone_4_std'=>$this->input->post('extruder_3_zone_4_std'),
                'extruder_3_zone_4_actual'=>$this->input->post('extruder_3_zone_4_actual'),
                'extruder_4_hooper_throat_std'=>$this->input->post('extruder_4_hooper_throat_std'),
                'extruder_4_hooper_throat_actual'=>$this->input->post('extruder_4_hooper_throat_actual'),
                'extruder_4_zone_1_std'=>$this->input->post('extruder_4_zone_1_std'),
                'extruder_4_zone_1_actual'=>$this->input->post('extruder_4_zone_1_actual'),
                'extruder_4_zone_2_std'=>$this->input->post('extruder_4_zone_2_std'),
                'extruder_4_zone_2_actual'=>$this->input->post('extruder_4_zone_2_actual'),
                'extruder_4_zone_3_std'=>$this->input->post('extruder_4_zone_3_std'),
                'extruder_4_zone_3_actual'=>$this->input->post('extruder_4_zone_3_actual'),
                'extruder_4_zone_4_std'=>$this->input->post('extruder_4_zone_4_std'),
                'extruder_4_zone_4_actual'=>$this->input->post('extruder_4_zone_4_actual'),
                'extruder_4_zone_5_std'=>$this->input->post('extruder_4_zone_5_std'),
                'extruder_4_zone_5_actual'=>$this->input->post('extruder_4_zone_5_actual'),
                'extruder_4_zone_6_std'=>$this->input->post('extruder_4_zone_6_std'),
                'extruder_4_zone_6_actual'=>$this->input->post('extruder_4_zone_6_actual'),
                'die_head_zone_6_std'=>$this->input->post('die_head_zone_6_std'),
                'die_head_zone_6_actual'=>$this->input->post('die_head_zone_6_actual'),
                'die_head_zone_7_std'=>$this->input->post('die_head_zone_7_std'),
                'die_head_zone_7_actual'=>$this->input->post('die_head_zone_7_actual'),
                'die_head_zone_8_std'=>$this->input->post('die_head_zone_8_std'),
                'die_head_zone_8_actual'=>$this->input->post('die_head_zone_8_actual'),
                'die_head_zone_9_std'=>$this->input->post('die_head_zone_9_std'),
                'die_head_zone_9_actual'=>$this->input->post('die_head_zone_9_actual'),
                'die_head_zone_10_std'=>$this->input->post('die_head_zone_10_std'),
                'die_head_zone_10_actual'=>$this->input->post('die_head_zone_10_actual'),
                'die_head_zone_11_std'=>$this->input->post('die_head_zone_11_std'),
                'die_head_zone_11_actual'=>$this->input->post('die_head_zone_11_actual'),
                'screw_rpm_outer_layer_std'=>$this->input->post('screw_rpm_outer_layer_std'),
                'screw_rpm_outer_layer_actual'=>$this->input->post('screw_rpm_outer_layer_actual'),
                'screw_rpm_admer_layer_std'=>$this->input->post('screw_rpm_admer_layer_std'),
                'screw_rpm_admer_layer_actual'=>$this->input->post('screw_rpm_admer_layer_actual'),
                'screw_rpm_evoh_layer_std'=>$this->input->post('screw_rpm_evoh_layer_std'),
                'screw_rpm_evoh_layer_actual'=>$this->input->post('screw_rpm_evoh_layer_actual'),
                'screw_rpm_inner_layer_std'=>$this->input->post('screw_rpm_inner_layer_std'),
                'screw_rpm_inner_layer_actual'=>$this->input->post('screw_rpm_inner_layer_actual'),
                'temp_z1_std'=>$this->input->post('temp_z1_std'),
                'temp_z1_actual'=>$this->input->post('temp_z1_actual'),
                'temp_z2_std'=>$this->input->post('temp_z2_std'),
                'temp_z2_actual'=>$this->input->post('temp_z2_actual'),
                'temp_z3_std'=>$this->input->post('temp_z3_std'),
                'temp_z3_actual'=>$this->input->post('temp_z3_actual'),
                'temp_z4_std'=>$this->input->post('temp_z4_std'),
                'temp_z4_actual'=>$this->input->post('temp_z4_actual'),
                'temp_z5_std'=>$this->input->post('temp_z5_std'),
                'temp_z5_actual'=>$this->input->post('temp_z5_actual'),
                'temp_z6_std'=>$this->input->post('temp_z6_std'),
                'temp_z6_actual'=>$this->input->post('temp_z6_actual'),
                'temp_z7_std'=>$this->input->post('temp_z7_std'),
                'temp_z7_actual'=>$this->input->post('temp_z7_actual'),
                'temp_z8_std'=>$this->input->post('temp_z8_std'),
                'temp_z8_actual'=>$this->input->post('temp_z8_actual'),
                'temp_z9_std'=>$this->input->post('temp_z9_std'),
                'temp_z9_actual'=>$this->input->post('temp_z9_actual'),
                'vacuum_tank_1_std'=>$this->input->post('vacuum_tank_1_std'),
                'vacuum_tank_1_actual'=>$this->input->post('vacuum_tank_1_actual'),
                'vacuum_tank_2_std'=>$this->input->post('vacuum_tank_2_std'),
                'vacuum_tank_2_actual'=>$this->input->post('vacuum_tank_2_actual'),
                'water_temp_tank_1_std'=>$this->input->post('water_temp_tank_1_std'),
                'water_temp_tank_1_actual'=>$this->input->post('water_temp_tank_1_actual'),
                'water_temp_tank_2_std'=>$this->input->post('water_temp_tank_2_std'),
                'water_temp_tank_2_actual'=>$this->input->post('water_temp_tank_2_actual'),
                'annealing_water_temp_t2_std'=>$this->input->post('annealing_water_temp_t2_std'),
                'annealing_water_temp_t2_actual'=>$this->input->post('annealing_water_temp_t2_actual'),
                'cutting_setting_value_std'=>$this->input->post('cutting_setting_value_std'),
                'cutting_setting_value_atual'=>$this->input->post('cutting_setting_value_atual'),
                'calibrator_water_d4_std'=>$this->input->post('calibrator_water_d4_std'),
                'calibrator_water_d4_actual'=>$this->input->post('calibrator_water_d4_actual'),
                'calibrator_water_d5_std'=>$this->input->post('calibrator_water_d5_std'),
                'calibrator_water_d5_actual'=>$this->input->post('calibrator_water_d5_actual'),
                'calibrator_water_d6_std'=>$this->input->post('calibrator_water_d6_std'),
                'calibrator_water_d6_actual'=>$this->input->post('calibrator_water_d6_actual'),
                'calibrator_water_d7_std'=>$this->input->post('calibrator_water_d7_std'),
                'calibrator_water_d7_actual'=>$this->input->post('calibrator_water_d7_actual'),
                'calibrator_water_d8_std'=>$this->input->post('calibrator_water_d8_std'),
                'calibrator_water_d8_actual'=>$this->input->post('calibrator_water_d8_actual'),
                'annealing_zone_d9_std'=>$this->input->post('annealing_zone_d9_std'),
                'annealing_zone_d9_actual'=>$this->input->post('annealing_zone_d9_actual'),
                'annealing_zone_d10_std'=>$this->input->post('annealing_zone_d10_std'),
                'annealing_zone_d10_actual'=>$this->input->post('annealing_zone_d10_actual'),
                'zumbac_value_std'=>$this->input->post('zumbac_value_std'),
                'zumbac_value_actual'=>$this->input->post('zumbac_value_actual'),
                'length_observed_std'=>$this->input->post('length_observed_std'),
                'length_observed_actual'=>$this->input->post('length_observed_actual'),
                'outer_diameter_std'=>$this->input->post('outer_diameter_std'),
                'outer_diameter_actual'=>$this->input->post('outer_diameter_actual'),
                'inner_diameter_std'=>$this->input->post('inner_diameter_std'),
                'inner_diameter_actual'=>$this->input->post('inner_diameter_actual'),
                'thickness_std'=>$this->input->post('thickness_std'),
                'thickness_actual'=>$this->input->post('thickness_actual'),
                'weight_std'=>$this->input->post('weight_std'),
                'weight_actual'=>$this->input->post('weight_actual'),
                'hourly_sign_tube_std'=>$this->input->post('hourly_sign_tube_std'),
                'hourly_sign_tube_actual'=>$this->input->post('hourly_sign_tube_actual'),
                'checked_by_operator'=>$this->input->post('checked_by_operator'),
                'verified_by_qc'=>$this->input->post('verified_by_qc'));

                $result=$this->common_model->update_one_active_record('coex_extrusion_qc_control_plan_parameter',$data,'ceqcpp_id',$this->input->post('ceqcpp_id'),$this->session->userdata['logged_in']['company_id']);
                
                $data['coex_extrusion_qc_control_plan_parameter']=$this->common_model->select_one_active_record('coex_extrusion_qc_control_plan_parameter',$this->session->userdata['logged_in']['company_id'],'coex_extrusion_qc_control_plan_parameter.ceqcpp_id',$this->input->post('ceqcpp_id'));

                $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,'coex_extrusion_qc_control_plan');

                $data['note']='Update Transaction Completed';
                header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                  $this->load->view(ucwords($this->router->fetch_class()).'/modify-form-parameters',$data);
                  $this->load->view('Home/footer');
              }
            }else{
              $data['note']='No Modify rights Thanks';
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
      $data['note']='No Modify rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  }




  function delete(){

      $data['page_name']='Production';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,'coex_extrusion_qc_control_plan');

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

                $data=array('archive'=>'1');

                $result=$this->common_model->archive_one_record('coex_extrusion_qc_control_plan',$data,'ceqcp_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

                $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,'coex_extrusion_qc_control_plan');
                $dataa = array('process_id' =>'1');
                $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
                $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
                $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['coex_extrusion_qc_control_plan']=$this->coex_extrusion_qc_control_plan_model->select_one_active_record('coex_extrusion_qc_control_plan',$this->session->userdata['logged_in']['company_id'],'coex_extrusion_qc_control_plan.ceqcp_id',$this->uri->segment(3));

                $data['note']='Archive Transaction completed';
               // header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
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
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,'coex_extrusion_qc_control_plan');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->delete==1){
            $table='coex_extrusion_qc_control_plan';
            include('pagination_archive.php');
            $data['coex_extrusion_qc_control_plan']=$this->coex_extrusion_qc_control_plan_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
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
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $dataa = array('process_id' =>'1');
            $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
            $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
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



  function search_result(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
        foreach ($data['module'] as $module_row) {
          if($module_row->module_name==='Production'){

             $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              foreach ($data['formrights'] as $formrights_row) {
                if($formrights_row->view==1){

                    $this->form_validation->set_rules('from_date','From Date' ,'trim|xss_clean|exact_length[10]');
                    $this->form_validation->set_rules('to_date','To Date' ,'trim|xss_clean|exact_length[10]');
                    $this->form_validation->set_rules('shift','Shift' ,'trim|xss_clean');
                    $this->form_validation->set_rules('machine','Machine' ,'trim|xss_clean');

                    if($this->form_validation->run()==FALSE){

                        $dataa = array('process_id' =>'1');
                        $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
                        $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
                        $this->load->view('Home/header');
                        $this->load->view('Home/nav',$data);
                        $this->load->view('Home/subnav');
                        $this->load->view('Loading/loading');
                        $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                        $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                        $this->load->view('Home/footer');

                      }else{

                        $from=$this->common_model->change_date_format($this->input->post('from_date'),$this->session->userdata['logged_in']['company_id']);
                        $to=$this->common_model->change_date_format($this->input->post('to_date'),$this->session->userdata['logged_in']['company_id']);

                        $master_array= array('coex_extrusion_qc_control_plan.product_no'=>$this->input->post('product_no'),
                                             'coex_extrusion_qc_control_plan.order_no'=>$this->input->post('order_no'),
                                             'coex_extrusion_qc_control_plan.jobcard_no'=>$this->input->post('jobcard_no'),
                                             'coex_extrusion_qc_control_plan.shift_id'=>$this->input->post('shift'),
                                             'coex_extrusion_qc_control_plan.machine_id'=>$this->input->post('machine'),
                                             'coex_extrusion_qc_control_plan.operator'=>$this->input->post('operator'));
                          
                          $data1=array_filter($master_array);                      
                          $data['coex_extrusion_qc_control_plan']=$this->coex_extrusion_qc_control_plan_model->active_record_search('coex_extrusion_qc_control_plan',$data1,$from,$to,$this->session->userdata['logged_in']['company_id']);
                          
                          

                          $this->load->view('Home/header');
                          $this->load->view('Home/nav',$data);
                          $this->load->view('Home/subnav');
                          $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                          $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                          $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
                          $this->load->view('Home/footer');


                      }


                }
                else{
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


    }else{
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

public function get_ajax_jobcard_no_id()
    {
        $jobcard_no_id = $this->input->post('jobcard_no');
        $this->coex_extrusion_qc_control_plan_model->get_ajax_jobcard_no_id($jobcard_no_id);
        //echo $this->db->last_query();
    }
  




}

