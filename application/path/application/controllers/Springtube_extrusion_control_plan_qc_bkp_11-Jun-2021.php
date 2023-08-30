<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Springtube_extrusion_control_plan_qc extends CI_Controller {

  function __construct(){

    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('sales_order_book_model');
      $this->load->model('sales_order_status_model');
      $this->load->model('artwork_springtube_model');
      $this->load->model('springtube_extrusion_control_plan_qc_model');
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

              $table='springtube_extrusion_control_plan_qc';
              include('pagination.php');
              $data['springtube_extrusion_control_plan_qc']=$this->springtube_extrusion_control_plan_qc_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
             
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

              $dataa = array('process_id' =>'1');
              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
             
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
            $this->form_validation->set_rules('machine','Machine Name' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('jobcard_no','Jobcard No.' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('operator','Operator' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('width_std','width Standard' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('width_actual','Width Actual' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('width_status','Width Status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('thickness_std','Thickness Standard' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('thickness_actual','Thickness Actual' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('thickness_status','Thickness Status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('reel_length_std','Std length of Roll' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('reel_length_actual','Actual length of Roll' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('reel_length_status','Roll length status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('first_layer_micron_std','First layer micron standard' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('first_layer_micron_actual','First layer micron actual' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('first_layer_micron_status','First layer micron status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('second_layer_micron_std','Second layer micron standard' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('second_layer_micron_actual','Second layer micron actual' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('second_layer_micron_status','Second layer micron status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('third_layer_micron_std','Third layer micron standard' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('third_layer_micron_actual','Third layer micron actual' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('third_layer_micron_status','Third layer micron status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('fourth_layer_micron_std','Fourth layer micron standard' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('fourth_layer_micron_actual','Fourth layer micron actual' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('fourth_layer_micron_status','Fourth layer micron status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('fifth_layer_micron_std','Fifth layer micron standard' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('fifth_layer_micron_actual','Fifth layer micron actual' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('fifth_layer_micron_status','Fifth layer micron status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sixth_layer_micron_std','Sixth layer micron standard' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sixth_layer_micron_actual','Sixth layer micron actual' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sixth_layer_micron_status','Sixth layer micron status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('seventh_layer_micron_std','Seventh layer micron standard' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('seventh_layer_micron_actual','Seventh layer micron actual' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('seventh_layer_micron_status','Seventh layer micron status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('grade_perc_of_bland','Grade & percantage of bland' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('grade_perc_of_bland_status','Grade percantage of bland status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('roll_color','Color of Roll' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('roll_color_status','Color of Roll status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('color_diffrence','Color diffrence' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('color_diffrence_status','Color diffrence status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('opacity','Opacity' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('opacity_status','Opacity status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('roll_winding','Winding of roll' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('roll_winding_status','Winding of roll status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('die_line','die line' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('die_line_status','Die line status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('scratch_line','Scratch line' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('scratch_line_status','Scratch line status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('pit_watermark','Pit/Watermark/FishEye' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('pit_watermark_status','Pit/Watermark/FishEye status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('contamination','Contamination' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('contamination_status','Contamination status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('roll_humps','Humps on Roll' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('roll_humps_status','Humps on Roll status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('color_dispersion','Color dispersion' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('color_dispersion_status','Color dispersion status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('cof_sf_df','COF-SF/DF' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('cof_sf_df_status','COF-SF/DF status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('mb_color_perc','Master batch color code & Percentage' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('mb_color_perc_status','Master batch color code & Percentage status' ,'required|trim|xss_clean');
            
            $this->form_validation->set_rules('masterfile_jobcard_return_status','Master file & Jobcard return status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('rm_return_status','RM return status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('red_create_status','Red create status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('rejected_rolls_clear_status','rejected rolls clear status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('no_loose_tools_status','No loose tools status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('machine_cleane_status','Machine cleane status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('machine_ready_status','Machine ready status' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('finger_comb_status','Finger comb status' ,'required|trim|xss_clean');
           
            //$this->form_validation->set_rules('new_job','New job/Power Failure/Material Change' ,'required|trim|xss_clean');
            //$this->form_validation->set_rules('shift_change','Shift change/Trial' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('qc_remarks','QC remarks' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('qc_inspection_status','QC inspection status' ,'required|trim|xss_clean');  

           
            if($this->form_validation->run()==FALSE){

              $dataa = array('process_id' =>'1');
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


                $data=array(
                  'company_id'=>$this->session->userdata['logged_in']['company_id'],
                  'inspection_date'=>$this->input->post('inspection_date'),
                  'inspection_time'=>date('H:i:s'),
                  'machine_id'=>$this->input->post('machine'),
                  'jobcard_no'=>$this->input->post('jobcard_no'),
                  'operator'=>trim(strtoupper($this->input->post('operator'))),
                  'width_std'=>$this->input->post('width_std'),
                  'width_actual'=>$this->input->post('width_actual'),
                  'width_status'=>$this->input->post('width_status'),
                  'thickness_std'=>$this->input->post('thickness_std'),
                  'thickness_actual'=>$this->input->post('thickness_actual'),
                  'thickness_status'=>$this->input->post('thickness_status'),
                  'reel_length_std'=>$this->input->post('reel_length_std'),
                  'reel_length_actual'=>$this->input->post('reel_length_actual'),
                  'reel_length_status'=>$this->input->post('reel_length_status'),
                  'first_layer_micron_std'=>$this->input->post('first_layer_micron_std'),
                  'first_layer_micron_actual'=>$this->input->post('first_layer_micron_actual'),
                  'first_layer_micron_status'=>$this->input->post('first_layer_micron_status'),
                  'second_layer_micron_std'=>$this->input->post('second_layer_micron_std'),
                  'second_layer_micron_actual'=>$this->input->post('second_layer_micron_actual'),
                  'second_layer_micron_status'=>$this->input->post('second_layer_micron_status'),
                  'third_layer_micron_std'=>$this->input->post('third_layer_micron_std'),
                  'third_layer_micron_actual'=>$this->input->post('third_layer_micron_actual'),
                  'third_layer_micron_status'=>$this->input->post('third_layer_micron_status'),
                  'fourth_layer_micron_std'=>$this->input->post('fourth_layer_micron_std'),
                  'fourth_layer_micron_actual'=>$this->input->post('fourth_layer_micron_actual'),
                  'fourth_layer_micron_status'=>$this->input->post('fourth_layer_micron_status'),
                  'fifth_layer_micron_std'=>$this->input->post('fifth_layer_micron_std'),
                  'fifth_layer_micron_actual'=>$this->input->post('fifth_layer_micron_actual'),
                  'fifth_layer_micron_status'=>$this->input->post('fifth_layer_micron_status'),
                  'sixth_layer_micron_std'=>$this->input->post('sixth_layer_micron_std'),
                  'sixth_layer_micron_actual'=>$this->input->post('sixth_layer_micron_actual'),
                  'sixth_layer_micron_status'=>$this->input->post('sixth_layer_micron_status'),
                  'seventh_layer_micron_std'=>$this->input->post('seventh_layer_micron_std'),
                  'seventh_layer_micron_actual'=>$this->input->post('seventh_layer_micron_actual'),
                  'seventh_layer_micron_status'=>$this->input->post('seventh_layer_micron_status'),
                  'grade_perc_of_bland'=>$this->input->post('grade_perc_of_bland'),
                  'grade_perc_of_bland_status'=>$this->input->post('grade_perc_of_bland_status'),
                  'roll_color'=>$this->input->post('roll_color'),
                  'roll_color_status'=>$this->input->post('roll_color_status'),
                  'color_diffrence'=>$this->input->post('color_diffrence'),
                  'color_diffrence_status'=>$this->input->post('color_diffrence_status'),
                  'opacity'=>$this->input->post('opacity'),
                  'opacity_status'=>$this->input->post('opacity_status'),
                  'roll_winding'=>$this->input->post('roll_winding'),
                  'roll_winding_status'=>$this->input->post('roll_winding_status'),
                  'die_line'=>$this->input->post('die_line'),
                  'die_line_status'=>$this->input->post('die_line_status'),
                  'scratch_line'=>$this->input->post('scratch_line'),
                  'scratch_line_status'=>$this->input->post('scratch_line_status'),
                  'pit_watermark'=>$this->input->post('pit_watermark'),
                  'pit_watermark_status'=>$this->input->post('pit_watermark_status'),
                  'contamination'=>$this->input->post('contamination'),
                  'contamination_status'=>$this->input->post('contamination_status'),
                  'roll_humps'=>$this->input->post('roll_humps'),
                  'roll_humps_status'=>$this->input->post('roll_humps_status'),
                  'color_dispersion'=>$this->input->post('color_dispersion'),
                  'color_dispersion_status'=>$this->input->post('color_dispersion_status'),
                  'cof_sf_df'=>$this->input->post('cof_sf_df'),
                  'cof_sf_df_status'=>$this->input->post('cof_sf_df_status'),
                  'mb_color_perc'=>$this->input->post('mb_color_perc'),
                  'mb_color_perc_status'=>$this->input->post('mb_color_perc_status'),
                  'masterfile_jobcard_return_status'=>$this->input->post('masterfile_jobcard_return_status'),
                  'rm_return_status'=>$this->input->post('rm_return_status'),
                  'red_create_status'=>$this->input->post('red_create_status'),
                  'rejected_rolls_clear_status'=>$this->input->post('rejected_rolls_clear_status'),
                  'no_loose_tools_status'=>$this->input->post('no_loose_tools_status'),
                  'machine_cleane_status'=>$this->input->post('machine_cleane_status'),
                  'machine_ready_status'=>$this->input->post('machine_ready_status'),
                  'finger_comb_status'=>$this->input->post('finger_comb_status'), 
                  'finger_comb_status'=>$this->input->post('finger_comb_status'),

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

                $result=$this->common_model->save('springtube_extrusion_control_plan_qc',$data); 

                               
                
                $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

                $data['note']='Create Transaction Completed';

                header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

              
                $dataa = array('process_id' =>'1');
                $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);


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
             
              $dataa = array('process_id' =>'1');
              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              
              $table='springtube_extrusion_control_plan_qc';
              $data['springtube_extrusion_control_plan_qc']=$this->springtube_extrusion_control_plan_qc_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'cp_id',$cp_id);

              
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
              $this->form_validation->set_rules('machine','Machine Name' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('jobcard_no','Jobcard No.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('operator','Operator' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('width_std','width Standard' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('width_actual','Width Actual' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('width_status','Width Status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('thickness_std','Thickness Standard' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('thickness_actual','Thickness Actual' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('thickness_status','Thickness Status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('reel_length_std','Std length of Roll' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('reel_length_actual','Actual length of Roll' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('reel_length_status','Roll length status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('first_layer_micron_std','First layer micron standard' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('first_layer_micron_actual','First layer micron actual' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('first_layer_micron_status','First layer micron status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('second_layer_micron_std','Second layer micron standard' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('second_layer_micron_actual','Second layer micron actual' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('second_layer_micron_status','Second layer micron status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('third_layer_micron_std','Third layer micron standard' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('third_layer_micron_actual','Third layer micron actual' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('third_layer_micron_status','Third layer micron status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('fourth_layer_micron_std','Fourth layer micron standard' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('fourth_layer_micron_actual','Fourth layer micron actual' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('fourth_layer_micron_status','Fourth layer micron status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('fifth_layer_micron_std','Fifth layer micron standard' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('fifth_layer_micron_actual','Fifth layer micron actual' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('fifth_layer_micron_status','Fifth layer micron status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sixth_layer_micron_std','Sixth layer micron standard' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sixth_layer_micron_actual','Sixth layer micron actual' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sixth_layer_micron_status','Sixth layer micron status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('seventh_layer_micron_std','Seventh layer micron standard' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('seventh_layer_micron_actual','Seventh layer micron actual' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('seventh_layer_micron_status','Seventh layer micron status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('grade_perc_of_bland','Grade & percantage of bland' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('grade_perc_of_bland_status','Grade percantage of bland status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('roll_color','Color of Roll' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('roll_color_status','Color of Roll status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('color_diffrence','Color diffrence' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('color_diffrence_status','Color diffrence status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('opacity','Opacity' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('opacity_status','Opacity status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('roll_winding','Winding of roll' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('roll_winding_status','Winding of roll status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('die_line','die line' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('die_line_status','Die line status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('scratch_line','Scratch line' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('scratch_line_status','Scratch line status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('pit_watermark','Pit/Watermark/FishEye' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('pit_watermark_status','Pit/Watermark/FishEye status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('contamination','Contamination' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('contamination_status','Contamination status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('roll_humps','Humps on Roll' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('roll_humps_status','Humps on Roll status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('color_dispersion','Color dispersion' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('color_dispersion_status','Color dispersion status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cof_sf_df','COF-SF/DF' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cof_sf_df_status','COF-SF/DF status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('mb_color_perc','Master batch color code & Percentage' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('mb_color_perc_status','Master batch color code & Percentage status' ,'required|trim|xss_clean');
              
              $this->form_validation->set_rules('masterfile_jobcard_return_status','Master file & Jobcard return status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('rm_return_status','RM return status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('red_create_status','Red create status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('rejected_rolls_clear_status','rejected rolls clear status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('no_loose_tools_status','No loose tools status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('machine_cleane_status','Machine cleane status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('machine_ready_status','Machine ready status' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('finger_comb_status','Finger comb status' ,'required|trim|xss_clean');
             
              //$this->form_validation->set_rules('new_job','New job/Power Failure/Material Change' ,'required|trim|xss_clean');
              //$this->form_validation->set_rules('shift_change','Shift change/Trial' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('qc_remarks','QC remarks' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('qc_inspection_status','QC inspection status' ,'required|trim|xss_clean');  


              if($this->form_validation->run()==FALSE){

                $cp_id=$this->input->post('cp_id');

                $dataa = array('process_id' =>'1');
              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              
              $table='springtube_extrusion_control_plan_qc';
              $data['springtube_extrusion_control_plan_qc']=$this->springtube_extrusion_control_plan_qc_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'cp_id',$cp_id);

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
                $this->load->view('Home/footer');

              }else{

                
                // Updating Master Table--------
                $data=array(
                  
                  'operator'=>trim(strtoupper($this->input->post('operator'))),
                  'width_std'=>$this->input->post('width_std'),
                  'width_actual'=>$this->input->post('width_actual'),
                  'width_status'=>$this->input->post('width_status'),
                  'thickness_std'=>$this->input->post('thickness_std'),
                  'thickness_actual'=>$this->input->post('thickness_actual'),
                  'thickness_status'=>$this->input->post('thickness_status'),
                  'reel_length_std'=>$this->input->post('reel_length_std'),
                  'reel_length_actual'=>$this->input->post('reel_length_actual'),
                  'reel_length_status'=>$this->input->post('reel_length_status'),
                  'first_layer_micron_std'=>$this->input->post('first_layer_micron_std'),
                  'first_layer_micron_actual'=>$this->input->post('first_layer_micron_actual'),
                  'first_layer_micron_status'=>$this->input->post('first_layer_micron_status'),
                  'second_layer_micron_std'=>$this->input->post('second_layer_micron_std'),
                  'second_layer_micron_actual'=>$this->input->post('second_layer_micron_actual'),
                  'second_layer_micron_status'=>$this->input->post('second_layer_micron_status'),
                  'third_layer_micron_std'=>$this->input->post('third_layer_micron_std'),
                  'third_layer_micron_actual'=>$this->input->post('third_layer_micron_actual'),
                  'third_layer_micron_status'=>$this->input->post('third_layer_micron_status'),
                  'fourth_layer_micron_std'=>$this->input->post('fourth_layer_micron_std'),
                  'fourth_layer_micron_actual'=>$this->input->post('fourth_layer_micron_actual'),
                  'fourth_layer_micron_status'=>$this->input->post('fourth_layer_micron_status'),
                  'fifth_layer_micron_std'=>$this->input->post('fifth_layer_micron_std'),
                  'fifth_layer_micron_actual'=>$this->input->post('fifth_layer_micron_actual'),
                  'fifth_layer_micron_status'=>$this->input->post('fifth_layer_micron_status'),
                  'sixth_layer_micron_std'=>$this->input->post('sixth_layer_micron_std'),
                  'sixth_layer_micron_actual'=>$this->input->post('sixth_layer_micron_actual'),
                  'sixth_layer_micron_status'=>$this->input->post('sixth_layer_micron_status'),
                  'seventh_layer_micron_std'=>$this->input->post('seventh_layer_micron_std'),
                  'seventh_layer_micron_actual'=>$this->input->post('seventh_layer_micron_actual'),
                  'seventh_layer_micron_status'=>$this->input->post('seventh_layer_micron_status'),
                  'grade_perc_of_bland'=>$this->input->post('grade_perc_of_bland'),
                  'grade_perc_of_bland_status'=>$this->input->post('grade_perc_of_bland_status'),
                  'roll_color'=>$this->input->post('roll_color'),
                  'roll_color_status'=>$this->input->post('roll_color_status'),
                  'color_diffrence'=>$this->input->post('color_diffrence'),
                  'color_diffrence_status'=>$this->input->post('color_diffrence_status'),
                  'opacity'=>$this->input->post('opacity'),
                  'opacity_status'=>$this->input->post('opacity_status'),
                  'roll_winding'=>$this->input->post('roll_winding'),
                  'roll_winding_status'=>$this->input->post('roll_winding_status'),
                  'die_line'=>$this->input->post('die_line'),
                  'die_line_status'=>$this->input->post('die_line_status'),
                  'scratch_line'=>$this->input->post('scratch_line'),
                  'scratch_line_status'=>$this->input->post('scratch_line_status'),
                  'pit_watermark'=>$this->input->post('pit_watermark'),
                  'pit_watermark_status'=>$this->input->post('pit_watermark_status'),
                  'contamination'=>$this->input->post('contamination'),
                  'contamination_status'=>$this->input->post('contamination_status'),
                  'roll_humps'=>$this->input->post('roll_humps'),
                  'roll_humps_status'=>$this->input->post('roll_humps_status'),
                  'color_dispersion'=>$this->input->post('color_dispersion'),
                  'color_dispersion_status'=>$this->input->post('color_dispersion_status'),
                  'cof_sf_df'=>$this->input->post('cof_sf_df'),
                  'cof_sf_df_status'=>$this->input->post('cof_sf_df_status'),
                  'mb_color_perc'=>$this->input->post('mb_color_perc'),
                  'mb_color_perc_status'=>$this->input->post('mb_color_perc_status'),
                  'masterfile_jobcard_return_status'=>$this->input->post('masterfile_jobcard_return_status'),
                  'rm_return_status'=>$this->input->post('rm_return_status'),
                  'red_create_status'=>$this->input->post('red_create_status'),
                  'rejected_rolls_clear_status'=>$this->input->post('rejected_rolls_clear_status'),
                  'no_loose_tools_status'=>$this->input->post('no_loose_tools_status'),
                  'machine_cleane_status'=>$this->input->post('machine_cleane_status'),
                  'machine_ready_status'=>$this->input->post('machine_ready_status'),
                  'finger_comb_status'=>$this->input->post('finger_comb_status'),
                                    
                  'new_job_status'=>(!empty($this->input->post('new_job_status')) ? 1 : 0),
                  'power_failure_status'=>(!empty($this->input->post('power_failure_status')) ? 1 : 0),
                  'change_of_rm_status'=>(!empty($this->input->post('change_of_rm_status')) ? 1 : 0),
                  'shift_change_status'=>(!empty($this->input->post('shift_change_status')) ? 1 : 0),
                  'trial_status'=>(!empty($this->input->post('trial_status')) ? 1 : 0),
                  'machine_maintainance_status'=>(!empty($this->input->post('machine_maintainance_status')) ? 1 : 0),
                  'qc_remarks'=>trim(strtoupper($this->input->post('qc_remarks'))),
                  'qc_inspection_status'=>$this->input->post('qc_inspection_status')                       
                  
                  );

                $this->common_model->update_one_active_record('springtube_extrusion_control_plan_qc',$data,'cp_id',$this->input->post('cp_id'),$this->session->userdata['logged_in']['company_id']);                
                

                $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());        
                

                $cp_id=$this->input->post('cp_id');

                $dataa = array('process_id' =>'1');
                $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
                
                $table='springtube_extrusion_control_plan_qc';
                $data['springtube_extrusion_control_plan_qc']=$this->springtube_extrusion_control_plan_qc_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'cp_id',$cp_id);

                
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

              $table='springtube_extrusion_control_plan_qc';
              include('pagination_archive.php');
              $data['springtube_extrusion_control_plan_qc']=$this->springtube_extrusion_control_plan_qc_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
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

              $result=$this->common_model->update_one_active_record('springtube_extrusion_control_plan_qc',$data,'cp_id',$cp_id,$this->session->userdata['logged_in']['company_id']);

                  //$result=$this->common_model->update_one_active_record('springtube_article_history',$data,'production_id',$id,$this->session->userdata['logged_in']['company_id']);

              $dataa = array('process_id' =>'1');
                $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
                
                $table='springtube_extrusion_control_plan_qc';
                $data['springtube_extrusion_control_plan_qc']=$this->springtube_extrusion_control_plan_qc_model->select_one_inactive_record($table,$this->session->userdata['logged_in']['company_id'],'cp_id',$cp_id); 
                
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

              $result=$this->common_model->update_one_active_record('springtube_extrusion_control_plan_qc',$data,'cp_id',$cp_id,$this->session->userdata['logged_in']['company_id']);

                //$result=$this->common_model->update_one_active_record('springtube_article_history',$data,'production_id',$id,$this->session->userdata['logged_in']['company_id']);

              $dataa = array('process_id' =>'1');
              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
                
              $table='springtube_extrusion_control_plan_qc';
              $data['springtube_extrusion_control_plan_qc']=$this->springtube_extrusion_control_plan_qc_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'cp_id',$cp_id);
                
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

            $data['springtube_extrusion_control_plan_qc']=$this->springtube_extrusion_control_plan_qc_model->select_one_active_record('springtube_extrusion_control_plan_qc',$this->session->userdata['logged_in']['company_id'],'springtube_extrusion_control_plan_qc.cp_id',$cp_id);

            $data['ex_a']=$this->common_model->select_one_active_record('springtube_extrusion_machine_qc_parameters',$this->session->userdata['logged_in']['company_id'],'part_name','EX-A');

            $data['ex_b']=$this->common_model->select_one_active_record('springtube_extrusion_machine_qc_parameters',$this->session->userdata['logged_in']['company_id'],'part_name','EX-B');

            $data['ex_c']=$this->common_model->select_one_active_record('springtube_extrusion_machine_qc_parameters',$this->session->userdata['logged_in']['company_id'],'part_name','EX-C');

            $data['ex_d']=$this->common_model->select_one_active_record('springtube_extrusion_machine_qc_parameters',$this->session->userdata['logged_in']['company_id'],'part_name','EX-D');

            $data['ex_e']=$this->common_model->select_one_active_record('springtube_extrusion_machine_qc_parameters',$this->session->userdata['logged_in']['company_id'],'part_name','EX-E');

            $data['feed_block']=$this->common_model->select_one_active_record('springtube_extrusion_machine_qc_parameters',$this->session->userdata['logged_in']['company_id'],'part_name','FEED BLOCK');

            $data['die_head']=$this->common_model->select_one_active_record('springtube_extrusion_machine_qc_parameters',$this->session->userdata['logged_in']['company_id'],'part_name','DIE HEAD');

            
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

              $dataa = array('process_id' =>'1');
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

              $dataa = array('process_id' =>'1');
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

              $data['springtube_extrusion_control_plan_qc']=$this->springtube_extrusion_control_plan_qc_model->active_record_search('springtube_extrusion_control_plan_qc',$this->session->userdata['logged_in']['company_id'],$dataa,$this->input->post('from_date'),$this->input->post('to_date'));             

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

              $data['ex_a']=$this->common_model->select_one_active_record('springtube_extrusion_machine_qc_parameters',$this->session->userdata['logged_in']['company_id'],'part_name','EX-A');

              $data['ex_b']=$this->common_model->select_one_active_record('springtube_extrusion_machine_qc_parameters',$this->session->userdata['logged_in']['company_id'],'part_name','EX-B');

              $data['ex_c']=$this->common_model->select_one_active_record('springtube_extrusion_machine_qc_parameters',$this->session->userdata['logged_in']['company_id'],'part_name','EX-C');

              $data['ex_d']=$this->common_model->select_one_active_record('springtube_extrusion_machine_qc_parameters',$this->session->userdata['logged_in']['company_id'],'part_name','EX-D');

              $data['ex_e']=$this->common_model->select_one_active_record('springtube_extrusion_machine_qc_parameters',$this->session->userdata['logged_in']['company_id'],'part_name','EX-E');

              $data['feed_block']=$this->common_model->select_one_active_record('springtube_extrusion_machine_qc_parameters',$this->session->userdata['logged_in']['company_id'],'part_name','FEED BLOCK');

              $data['die_head']=$this->common_model->select_one_active_record('springtube_extrusion_machine_qc_parameters',$this->session->userdata['logged_in']['company_id'],'part_name','DIE HEAD');

              
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
            
            $this->form_validation->set_rules('operator','Operator' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ex_a_actual_1','EX-A ZONE 001' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ex_a_actual_2','EX-A ZONE 002' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ex_a_actual_3','EX-A ZONE 003' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ex_a_actual_4','EX-A ZONE 004' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ex_a_actual_5','EX-A ZONE 005' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ex_a_actual_6','EX-A ZONE 006' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ex_a_actual_7','EX-A ZONE 007' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ex_a_actual_8','EX-A ZONE 008' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ex_a_actual_9','EX-A ZONE 009' ,'trim|xss_clean');

            $this->form_validation->set_rules('ex_b_actual_1','EX-B ZONE 001' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ex_b_actual_2','EX-B ZONE 002' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ex_b_actual_3','EX-B ZONE 003' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ex_b_actual_4','EX-B ZONE 004' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ex_b_actual_5','EX-B ZONE 005' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ex_b_actual_6','EX-B ZONE 006' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ex_b_actual_7','EX-B ZONE 007' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ex_b_actual_8','EX-B ZONE 008' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ex_b_actual_9','EX-B ZONE 009' ,'required|trim|xss_clean');

            $this->form_validation->set_rules('ex_c_actual_1','EX-C ZONE 001' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ex_c_actual_2','EX-C ZONE 002' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ex_c_actual_3','EX-C ZONE 003' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ex_c_actual_4','EX-C ZONE 004' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ex_c_actual_5','EX-C ZONE 005' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ex_c_actual_6','EX-C ZONE 006' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ex_c_actual_7','EX-C ZONE 007' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ex_c_actual_8','EX-C ZONE 008' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ex_c_actual_9','EX-C ZONE 009' ,'trim|xss_clean');

            $this->form_validation->set_rules('ex_d_actual_1','EX-D ZONE 001' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ex_d_actual_2','EX-D ZONE 002' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ex_d_actual_3','EX-D ZONE 003' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ex_d_actual_4','EX-D ZONE 004' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ex_d_actual_5','EX-D ZONE 005' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ex_d_actual_6','EX-D ZONE 006' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ex_d_actual_7','EX-D ZONE 007' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ex_d_actual_8','EX-D ZONE 008' ,'trim|xss_clean');
            $this->form_validation->set_rules('ex_d_actual_9','EX-D ZONE 009' ,'trim|xss_clean');

            $this->form_validation->set_rules('ex_e_actual_1','EX-E ZONE 001' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ex_e_actual_2','EX-E ZONE 002' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ex_e_actual_3','EX-E ZONE 003' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ex_e_actual_4','EX-E ZONE 004' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ex_e_actual_5','EX-E ZONE 005' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ex_e_actual_6','EX-E ZONE 006' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ex_e_actual_7','EX-E ZONE 007' ,'trim|xss_clean');
            $this->form_validation->set_rules('ex_e_actual_8','EX-E ZONE 008' ,'trim|xss_clean');
            $this->form_validation->set_rules('ex_e_actual_9','EX-E ZONE 009' ,'trim|xss_clean');

            $this->form_validation->set_rules('feed_block_actual_1','FEED BLOCK ZONE 001' ,'trim|xss_clean');
            $this->form_validation->set_rules('feed_block_actual_2','FEED BLOCK ZONE 002' ,'trim|xss_clean');
            $this->form_validation->set_rules('feed_block_actual_3','FEED BLOCK ZONE 003' ,'trim|xss_clean');
            $this->form_validation->set_rules('feed_block_actual_4','FEED BLOCK ZONE 004' ,'trim|xss_clean');
            $this->form_validation->set_rules('feed_block_actual_5','FEED BLOCK ZONE 005' ,'trim|xss_clean');
            $this->form_validation->set_rules('feed_block_actual_6','FEED BLOCK ZONE 006' ,'trim|xss_clean');
            $this->form_validation->set_rules('feed_block_actual_7','FEED BLOCK ZONE 007' ,'trim|xss_clean');
            $this->form_validation->set_rules('feed_block_actual_8','FEED BLOCK ZONE 008' ,'trim|xss_clean');
            $this->form_validation->set_rules('feed_block_actual_9','FEED BLOCK ZONE 009' ,'trim|xss_clean');

            $this->form_validation->set_rules('feed_block_actual_10','FEED BLOCK ZONE 013' ,'trim|xss_clean');
            $this->form_validation->set_rules('feed_block_actual_11','FEED BLOCK ZONE 014' ,'trim|xss_clean');
            $this->form_validation->set_rules('feed_block_actual_12','FEED BLOCK ZONE 015' ,'trim|xss_clean');
            $this->form_validation->set_rules('feed_block_actual_13','FEED BLOCK ZONE 016' ,'trim|xss_clean');
            $this->form_validation->set_rules('feed_block_actual_14','FEED BLOCK ZONE 017' ,'trim|xss_clean');

            $this->form_validation->set_rules('die_head_std_value_1','DIE HEAD ZONE 001' ,'trim|xss_clean');
            $this->form_validation->set_rules('die_head_std_value_2','DIE HEAD ZONE 002' ,'trim|xss_clean');
            $this->form_validation->set_rules('die_head_std_value_3','DIE HEAD ZONE 003' ,'trim|xss_clean');
            $this->form_validation->set_rules('die_head_std_value_4','DIE HEAD ZONE 004' ,'trim|xss_clean');
            $this->form_validation->set_rules('die_head_std_value_5','DIE HEAD ZONE 005' ,'trim|xss_clean');
            $this->form_validation->set_rules('die_head_std_value_6','DIE HEAD ZONE 006' ,'trim|xss_clean');
            $this->form_validation->set_rules('die_head_std_value_7','DIE HEAD ZONE 007' ,'trim|xss_clean');
            $this->form_validation->set_rules('die_head_std_value_8','DIE HEAD ZONE 008' ,'trim|xss_clean');
            $this->form_validation->set_rules('die_head_std_value_9','DIE HEAD ZONE 009' ,'trim|xss_clean');

            $this->form_validation->set_rules('roll_temp_1_actual','TEMPARATURE OF ROLL-1' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('roll_temp_2_actual','TEMPARATURE OF ROLL-2' ,'trim|xss_clean');
            $this->form_validation->set_rules('roll_temp_3_actual','TEMPARATURE OF ROLL-3' ,'trim|xss_clean');

            $this->form_validation->set_rules('roll_thickness_actual','THICKNESS' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('roll_length_actual','LENGTH OF ROLL' ,'required|trim|xss_clean');
            
           
            if($this->form_validation->run()==FALSE){

              $data['ex_a']=$this->common_model->select_one_active_record('springtube_extrusion_machine_qc_parameters',$this->session->userdata['logged_in']['company_id'],'part_name','EX-A');

              $data['ex_b']=$this->common_model->select_one_active_record('springtube_extrusion_machine_qc_parameters',$this->session->userdata['logged_in']['company_id'],'part_name','EX-B');

              $data['ex_c']=$this->common_model->select_one_active_record('springtube_extrusion_machine_qc_parameters',$this->session->userdata['logged_in']['company_id'],'part_name','EX-C');

              $data['ex_d']=$this->common_model->select_one_active_record('springtube_extrusion_machine_qc_parameters',$this->session->userdata['logged_in']['company_id'],'part_name','EX-D');

              $data['ex_e']=$this->common_model->select_one_active_record('springtube_extrusion_machine_qc_parameters',$this->session->userdata['logged_in']['company_id'],'part_name','EX-E');

              $data['feed_block']=$this->common_model->select_one_active_record('springtube_extrusion_machine_qc_parameters',$this->session->userdata['logged_in']['company_id'],'part_name','FEED BLOCK');

              $data['die_head']=$this->common_model->select_one_active_record('springtube_extrusion_machine_qc_parameters',$this->session->userdata['logged_in']['company_id'],'part_name','DIE HEAD');

              
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
                  'ex_a_actual_1'=>$this->input->post('ex_a_actual_1'),
                  'ex_a_actual_2'=>$this->input->post('ex_a_actual_2'),
                  'ex_a_actual_3'=>$this->input->post('ex_a_actual_3'),
                  'ex_a_actual_4'=>$this->input->post('ex_a_actual_4'),
                  'ex_a_actual_5'=>$this->input->post('ex_a_actual_5'),
                  'ex_a_actual_6'=>$this->input->post('ex_a_actual_6'),
                  'ex_a_actual_7'=>$this->input->post('ex_a_actual_7'),
                  'ex_a_actual_8'=>$this->input->post('ex_a_actual_8'),
                  'ex_a_actual_9'=>$this->input->post('ex_a_actual_9'),
                  'ex_b_actual_1'=>$this->input->post('ex_b_actual_1'),
                  'ex_b_actual_2'=>$this->input->post('ex_b_actual_2'),
                  'ex_b_actual_3'=>$this->input->post('ex_b_actual_3'),
                  'ex_b_actual_4'=>$this->input->post('ex_b_actual_4'),
                  'ex_b_actual_5'=>$this->input->post('ex_b_actual_5'),
                  'ex_b_actual_6'=>$this->input->post('ex_b_actual_6'),
                  'ex_b_actual_7'=>$this->input->post('ex_b_actual_7'),
                  'ex_b_actual_8'=>$this->input->post('ex_b_actual_8'),
                  'ex_b_actual_9'=>$this->input->post('ex_b_actual_9'),
                  'ex_c_actual_1'=>$this->input->post('ex_c_actual_1'),
                  'ex_c_actual_2'=>$this->input->post('ex_c_actual_2'),
                  'ex_c_actual_3'=>$this->input->post('ex_c_actual_3'),
                  'ex_c_actual_4'=>$this->input->post('ex_c_actual_4'),
                  'ex_c_actual_5'=>$this->input->post('ex_c_actual_5'),
                  'ex_c_actual_6'=>$this->input->post('ex_c_actual_6'),
                  'ex_c_actual_7'=>$this->input->post('ex_c_actual_7'),
                  'ex_c_actual_8'=>$this->input->post('ex_c_actual_8'),
                  'ex_c_actual_9'=>$this->input->post('ex_c_actual_9'),
                  'ex_d_actual_1'=>$this->input->post('ex_d_actual_1'),
                  'ex_d_actual_2'=>$this->input->post('ex_d_actual_2'),
                  'ex_d_actual_3'=>$this->input->post('ex_d_actual_3'),
                  'ex_d_actual_4'=>$this->input->post('ex_d_actual_4'),
                  'ex_d_actual_5'=>$this->input->post('ex_d_actual_5'),
                  'ex_d_actual_6'=>$this->input->post('ex_d_actual_6'),
                  'ex_d_actual_7'=>$this->input->post('ex_d_actual_7'),
                  'ex_d_actual_8'=>$this->input->post('ex_d_actual_8'),
                  'ex_d_actual_9'=>$this->input->post('ex_d_actual_9'),
                  'ex_e_actual_1'=>$this->input->post('ex_e_actual_1'),
                  'ex_e_actual_2'=>$this->input->post('ex_e_actual_2'),
                  'ex_e_actual_3'=>$this->input->post('ex_e_actual_3'),
                  'ex_e_actual_4'=>$this->input->post('ex_e_actual_4'),
                  'ex_e_actual_5'=>$this->input->post('ex_e_actual_5'),
                  'ex_e_actual_6'=>$this->input->post('ex_e_actual_6'),
                  'ex_e_actual_7'=>$this->input->post('ex_e_actual_7'),
                  'ex_e_actual_8'=>$this->input->post('ex_e_actual_8'),
                  'ex_e_actual_9'=>$this->input->post('ex_e_actual_9'),
                  'feed_block_actual_1'=>$this->input->post('feed_block_actual_1'),
                  'feed_block_actual_2'=>$this->input->post('feed_block_actual_2'),
                  'feed_block_actual_3'=>$this->input->post('feed_block_actual_3'),
                  'feed_block_actual_4'=>$this->input->post('feed_block_actual_4'),
                  'feed_block_actual_5'=>$this->input->post('feed_block_actual_5'),
                  'feed_block_actual_6'=>$this->input->post('feed_block_actual_6'),
                  'feed_block_actual_7'=>$this->input->post('feed_block_actual_7'),
                  'feed_block_actual_8'=>$this->input->post('feed_block_actual_8'),
                  'feed_block_actual_9'=>$this->input->post('feed_block_actual_9'),
                  'feed_block_actual_13'=>$this->input->post('feed_block_actual_10'),
                  'feed_block_actual_14'=>$this->input->post('feed_block_actual_11'),
                  'feed_block_actual_15'=>$this->input->post('feed_block_actual_12'),
                  'feed_block_actual_16'=>$this->input->post('feed_block_actual_13'),
                  'feed_block_actual_17'=>$this->input->post('feed_block_actual_14'),
                  'die_head_actual_1'=>$this->input->post('die_head_actual_1'),
                  'die_head_actual_2'=>$this->input->post('die_head_actual_2'),
                  'die_head_actual_3'=>$this->input->post('die_head_actual_3'),
                  'die_head_actual_4'=>$this->input->post('die_head_actual_4'),
                  'die_head_actual_5'=>$this->input->post('die_head_actual_5'),
                  'die_head_actual_6'=>$this->input->post('die_head_actual_6'),
                  'die_head_actual_7'=>$this->input->post('die_head_actual_7'),
                  'die_head_actual_8'=>$this->input->post('die_head_actual_8'),
                  'die_head_actual_9'=>$this->input->post('die_head_actual_9'),
                  'roll_temp_1_actual'=>$this->input->post('roll_temp_1_actual'),
                  'roll_temp_2_actual'=>$this->input->post('roll_temp_2_actual'),
                  'roll_temp_3_actual'=>$this->input->post('roll_temp_3_actual'),
                  'roll_thickness_actual'=>$this->input->post('roll_thickness_actual'),
                  'roll_length_actual'=>$this->input->post('roll_length_actual'),
                  'company_id'=>$this->session->userdata['logged_in']['company_id']
                  
                  );

                $result=$this->common_model->save('springtube_extrusion_control_plan_qc_details',$data);                               
                
                $data['ex_a']=$this->common_model->select_one_active_record('springtube_extrusion_machine_qc_parameters',$this->session->userdata['logged_in']['company_id'],'part_name','EX-A');

                $data['ex_b']=$this->common_model->select_one_active_record('springtube_extrusion_machine_qc_parameters',$this->session->userdata['logged_in']['company_id'],'part_name','EX-B');

                $data['ex_c']=$this->common_model->select_one_active_record('springtube_extrusion_machine_qc_parameters',$this->session->userdata['logged_in']['company_id'],'part_name','EX-C');

                $data['ex_d']=$this->common_model->select_one_active_record('springtube_extrusion_machine_qc_parameters',$this->session->userdata['logged_in']['company_id'],'part_name','EX-D');

                $data['ex_e']=$this->common_model->select_one_active_record('springtube_extrusion_machine_qc_parameters',$this->session->userdata['logged_in']['company_id'],'part_name','EX-E');

                $data['feed_block']=$this->common_model->select_one_active_record('springtube_extrusion_machine_qc_parameters',$this->session->userdata['logged_in']['company_id'],'part_name','FEED BLOCK');

                $data['die_head']=$this->common_model->select_one_active_record('springtube_extrusion_machine_qc_parameters',$this->session->userdata['logged_in']['company_id'],'part_name','DIE HEAD');

                
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

  function create_roll_thickness($cp_id){    
    
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

              $data['springtube_extrusion_control_plan_qc']=$this->springtube_extrusion_control_plan_qc_model->select_one_active_record('springtube_extrusion_control_plan_qc',$this->session->userdata['logged_in']['company_id'],'springtube_extrusion_control_plan_qc.cp_id',$cp_id);  
              
             
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/add-roll-thickness-form',$data);
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

  function save_roll_thickness(){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){
            
            
            $this->form_validation->set_rules('operator','Operator' ,'required|trim|xss_clean');

            foreach($this->input->post('sr_no') as $sr_no => $sr_no_value){

              $this->form_validation->set_rules('top_pos_1_roll_'.$sr_no_value,'TOP POSITION 1 OFF ROLL'.$sr_no_value ,'required|trim|xss_clean');
              $this->form_validation->set_rules('top_pos_2_roll_'.$sr_no_value,'TOP POSITION 2 OFF ROLL'.$sr_no_value ,'required|trim|xss_clean');
              $this->form_validation->set_rules('top_pos_3_roll_'.$sr_no_value,'TOP POSITION 3 OFF ROLL'.$sr_no_value ,'required|trim|xss_clean');
              $this->form_validation->set_rules('top_pos_4_roll_'.$sr_no_value,'TOP POSITION 4 OFF ROLL'.$sr_no_value ,'required|trim|xss_clean');
              $this->form_validation->set_rules('top_pos_5_roll_'.$sr_no_value,'TOP POSITION 5 OFF ROLL'.$sr_no_value ,'required|trim|xss_clean');
              $this->form_validation->set_rules('top_pos_6_roll_'.$sr_no_value,'TOP POSITION 6 OFF ROLL'.$sr_no_value ,'required|trim|xss_clean');
              $this->form_validation->set_rules('top_pos_7_roll_'.$sr_no_value,'TOP POSITION 7 OFF ROLL'.$sr_no_value ,'required|trim|xss_clean');
              $this->form_validation->set_rules('top_pos_8_roll_'.$sr_no_value,'TOP POSITION 8 OFF ROLL'.$sr_no_value ,'required|trim|xss_clean');
              $this->form_validation->set_rules('top_pos_9_roll_'.$sr_no_value,'TOP POSITION 9 OFF ROLL'.$sr_no_value ,'required|trim|xss_clean');
              $this->form_validation->set_rules('top_pos_10_roll_'.$sr_no_value,'TOP POSITION 10 OFF ROLL'.$sr_no_value ,'required|trim|xss_clean');

              $this->form_validation->set_rules('bot_pos_1_roll_'.$sr_no_value,'TOP POSITION 1 OFF ROLL'.$sr_no_value ,'required|trim|xss_clean');
              $this->form_validation->set_rules('bot_pos_2_roll_'.$sr_no_value,'TOP POSITION 2 OFF ROLL'.$sr_no_value ,'required|trim|xss_clean');
              $this->form_validation->set_rules('bot_pos_3_roll_'.$sr_no_value,'TOP POSITION 3 OFF ROLL'.$sr_no_value ,'required|trim|xss_clean');
              $this->form_validation->set_rules('bot_pos_4_roll_'.$sr_no_value,'TOP POSITION 4 OFF ROLL'.$sr_no_value ,'required|trim|xss_clean');
              $this->form_validation->set_rules('bot_pos_5_roll_'.$sr_no_value,'TOP POSITION 5 OFF ROLL'.$sr_no_value ,'required|trim|xss_clean');
              $this->form_validation->set_rules('bot_pos_6_roll_'.$sr_no_value,'TOP POSITION 6 OFF ROLL'.$sr_no_value ,'required|trim|xss_clean');
              $this->form_validation->set_rules('bot_pos_7_roll_'.$sr_no_value,'TOP POSITION 7 OFF ROLL'.$sr_no_value ,'required|trim|xss_clean');
              $this->form_validation->set_rules('bot_pos_8_roll_'.$sr_no_value,'TOP POSITION 8 OFF ROLL'.$sr_no_value ,'required|trim|xss_clean');
              $this->form_validation->set_rules('bot_pos_9_roll_'.$sr_no_value,'TOP POSITION 9 OFF ROLL'.$sr_no_value ,'required|trim|xss_clean');
              $this->form_validation->set_rules('bot_pos_10_roll_'.$sr_no_value,'TOP POSITION 10 OFF ROLL'.$sr_no_value ,'required|trim|xss_clean');
          }  

           
            
           
            if($this->form_validation->run()==FALSE){             

              
              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $data['springtube_extrusion_control_plan_qc']=$this->springtube_extrusion_control_plan_qc_model->select_one_active_record('springtube_extrusion_control_plan_qc',$this->session->userdata['logged_in']['company_id'],'springtube_extrusion_control_plan_qc.cp_id',$this->input->post('cp_id')); 

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/add-roll-thickness-form',$data);
              $this->load->view('Home/footer');
            }else{

                foreach($this->input->post('sr_no') as $sr_no => $sr_no_value){
                   
                   $data=array(
                  'cp_id'=>$this->input->post('cp_id'),
                  'operator'=>trim(strtoupper($this->input->post('operator'))),
                  'roll_no'=>$sr_no_value,
                  'top_pos_1'=>$this->input->post('top_pos_1_roll_'.$sr_no_value),
                  'top_pos_2'=>$this->input->post('top_pos_2_roll_'.$sr_no_value),
                  'top_pos_3'=>$this->input->post('top_pos_3_roll_'.$sr_no_value),
                  'top_pos_4'=>$this->input->post('top_pos_4_roll_'.$sr_no_value),
                  'top_pos_5'=>$this->input->post('top_pos_5_roll_'.$sr_no_value),
                  'top_pos_6'=>$this->input->post('top_pos_6_roll_'.$sr_no_value),
                  'top_pos_7'=>$this->input->post('top_pos_7_roll_'.$sr_no_value),
                  'top_pos_8'=>$this->input->post('top_pos_8_roll_'.$sr_no_value),
                  'top_pos_9'=>$this->input->post('top_pos_9_roll_'.$sr_no_value),
                  'top_pos_10'=>$this->input->post('top_pos_10_roll_'.$sr_no_value),
                 
                  'bot_pos_1'=>$this->input->post('bot_pos_1_roll_'.$sr_no_value),
                  'bot_pos_2'=>$this->input->post('bot_pos_2_roll_'.$sr_no_value),
                  'bot_pos_3'=>$this->input->post('bot_pos_3_roll_'.$sr_no_value),
                  'bot_pos_4'=>$this->input->post('bot_pos_4_roll_'.$sr_no_value),
                  'bot_pos_5'=>$this->input->post('bot_pos_5_roll_'.$sr_no_value),
                  'bot_pos_6'=>$this->input->post('bot_pos_6_roll_'.$sr_no_value),
                  'bot_pos_7'=>$this->input->post('bot_pos_7_roll_'.$sr_no_value),
                  'bot_pos_8'=>$this->input->post('bot_pos_8_roll_'.$sr_no_value),
                  'bot_pos_9'=>$this->input->post('bot_pos_9_roll_'.$sr_no_value),
                  'bot_pos_10'=>$this->input->post('bot_pos_10_roll_'.$sr_no_value),                
                  'company_id'=>$this->session->userdata['logged_in']['company_id']
                  
                  );
                   print_r($data);

                  $result=$this->common_model->save('springtube_extrusion_control_plan_qc_film_thickness',$data);
                }                               
               
                
                $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

                $data['springtube_extrusion_control_plan_qc']=$this->springtube_extrusion_control_plan_qc_model->select_one_active_record('springtube_extrusion_control_plan_qc',$this->session->userdata['logged_in']['company_id'],'springtube_extrusion_control_plan_qc.cp_id',$this->input->post('cp_id'));

                $data['note']='Create Transaction Completed';

                header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/add-roll-thickness-form',$data);
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


  function modify_roll_thickness($cp_id){    
    
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){        

              
              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $data['springtube_extrusion_control_plan_qc']=$this->springtube_extrusion_control_plan_qc_model->select_one_active_record('springtube_extrusion_control_plan_qc',$this->session->userdata['logged_in']['company_id'],'springtube_extrusion_control_plan_qc.cp_id',$cp_id); 

              $data['springtube_extrusion_control_plan_qc_film_thickness']=$this->common_model->select_one_active_record('springtube_extrusion_control_plan_qc_film_thickness',$this->session->userdata['logged_in']['company_id'],'cp_id',$cp_id);  
              
             
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/modify-roll-thickness-form',$data);
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

  function update_roll_thickness(){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){
            
            
            $this->form_validation->set_rules('operator','Operator' ,'required|trim|xss_clean');

            foreach($this->input->post('sr_no') as $sr_no => $sr_no_value){

              $this->form_validation->set_rules('top_pos_1_roll_'.$sr_no_value,'TOP POSITION 1 OFF ROLL'.$sr_no_value ,'required|trim|xss_clean');
              $this->form_validation->set_rules('top_pos_2_roll_'.$sr_no_value,'TOP POSITION 2 OFF ROLL'.$sr_no_value ,'required|trim|xss_clean');
              $this->form_validation->set_rules('top_pos_3_roll_'.$sr_no_value,'TOP POSITION 3 OFF ROLL'.$sr_no_value ,'required|trim|xss_clean');
              $this->form_validation->set_rules('top_pos_4_roll_'.$sr_no_value,'TOP POSITION 4 OFF ROLL'.$sr_no_value ,'required|trim|xss_clean');
              $this->form_validation->set_rules('top_pos_5_roll_'.$sr_no_value,'TOP POSITION 5 OFF ROLL'.$sr_no_value ,'required|trim|xss_clean');
              $this->form_validation->set_rules('top_pos_6_roll_'.$sr_no_value,'TOP POSITION 6 OFF ROLL'.$sr_no_value ,'required|trim|xss_clean');
              $this->form_validation->set_rules('top_pos_7_roll_'.$sr_no_value,'TOP POSITION 7 OFF ROLL'.$sr_no_value ,'required|trim|xss_clean');
              $this->form_validation->set_rules('top_pos_8_roll_'.$sr_no_value,'TOP POSITION 8 OFF ROLL'.$sr_no_value ,'required|trim|xss_clean');
              $this->form_validation->set_rules('top_pos_9_roll_'.$sr_no_value,'TOP POSITION 9 OFF ROLL'.$sr_no_value ,'required|trim|xss_clean');
              $this->form_validation->set_rules('top_pos_10_roll_'.$sr_no_value,'TOP POSITION 10 OFF ROLL'.$sr_no_value ,'required|trim|xss_clean');

              $this->form_validation->set_rules('bot_pos_1_roll_'.$sr_no_value,'TOP POSITION 1 OFF ROLL'.$sr_no_value ,'required|trim|xss_clean');
              $this->form_validation->set_rules('bot_pos_2_roll_'.$sr_no_value,'TOP POSITION 2 OFF ROLL'.$sr_no_value ,'required|trim|xss_clean');
              $this->form_validation->set_rules('bot_pos_3_roll_'.$sr_no_value,'TOP POSITION 3 OFF ROLL'.$sr_no_value ,'required|trim|xss_clean');
              $this->form_validation->set_rules('bot_pos_4_roll_'.$sr_no_value,'TOP POSITION 4 OFF ROLL'.$sr_no_value ,'required|trim|xss_clean');
              $this->form_validation->set_rules('bot_pos_5_roll_'.$sr_no_value,'TOP POSITION 5 OFF ROLL'.$sr_no_value ,'required|trim|xss_clean');
              $this->form_validation->set_rules('bot_pos_6_roll_'.$sr_no_value,'TOP POSITION 6 OFF ROLL'.$sr_no_value ,'required|trim|xss_clean');
              $this->form_validation->set_rules('bot_pos_7_roll_'.$sr_no_value,'TOP POSITION 7 OFF ROLL'.$sr_no_value ,'required|trim|xss_clean');
              $this->form_validation->set_rules('bot_pos_8_roll_'.$sr_no_value,'TOP POSITION 8 OFF ROLL'.$sr_no_value ,'required|trim|xss_clean');
              $this->form_validation->set_rules('bot_pos_9_roll_'.$sr_no_value,'TOP POSITION 9 OFF ROLL'.$sr_no_value ,'required|trim|xss_clean');
              $this->form_validation->set_rules('bot_pos_10_roll_'.$sr_no_value,'TOP POSITION 10 OFF ROLL'.$sr_no_value ,'required|trim|xss_clean');
          }  

           
            
           
            if($this->form_validation->run()==FALSE){             

              
              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $data['springtube_extrusion_control_plan_qc']=$this->springtube_extrusion_control_plan_qc_model->select_one_active_record('springtube_extrusion_control_plan_qc',$this->session->userdata['logged_in']['company_id'],'springtube_extrusion_control_plan_qc.cp_id',$this->input->post('cp_id')); 

              $data['springtube_extrusion_control_plan_qc_film_thickness']=$this->common_model->select_one_active_record('springtube_extrusion_control_plan_qc_film_thickness',$this->session->userdata['logged_in']['company_id'],'cp_id',$this->input->post('cp_id'));

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/modify-roll-thickness-form',$data);
              $this->load->view('Home/footer');
            }else{

              //Removing Old records from the table
                $result=$this->common_model->delete_one_active_record('springtube_extrusion_control_plan_qc_film_thickness','cp_id',$this->input->post('cp_id'),$this->session->userdata['logged_in']['company_id']);

              if($result){  

                foreach($this->input->post('sr_no') as $sr_no => $sr_no_value){
                   
                   $data=array(
                  'cp_id'=>$this->input->post('cp_id'),
                  'operator'=>trim(strtoupper($this->input->post('operator'))),
                  'roll_no'=>$sr_no_value,
                  'top_pos_1'=>$this->input->post('top_pos_1_roll_'.$sr_no_value),
                  'top_pos_2'=>$this->input->post('top_pos_2_roll_'.$sr_no_value),
                  'top_pos_3'=>$this->input->post('top_pos_3_roll_'.$sr_no_value),
                  'top_pos_4'=>$this->input->post('top_pos_4_roll_'.$sr_no_value),
                  'top_pos_5'=>$this->input->post('top_pos_5_roll_'.$sr_no_value),
                  'top_pos_6'=>$this->input->post('top_pos_6_roll_'.$sr_no_value),
                  'top_pos_7'=>$this->input->post('top_pos_7_roll_'.$sr_no_value),
                  'top_pos_8'=>$this->input->post('top_pos_8_roll_'.$sr_no_value),
                  'top_pos_9'=>$this->input->post('top_pos_9_roll_'.$sr_no_value),
                  'top_pos_10'=>$this->input->post('top_pos_10_roll_'.$sr_no_value),
                 
                  'bot_pos_1'=>$this->input->post('bot_pos_1_roll_'.$sr_no_value),
                  'bot_pos_2'=>$this->input->post('bot_pos_2_roll_'.$sr_no_value),
                  'bot_pos_3'=>$this->input->post('bot_pos_3_roll_'.$sr_no_value),
                  'bot_pos_4'=>$this->input->post('bot_pos_4_roll_'.$sr_no_value),
                  'bot_pos_5'=>$this->input->post('bot_pos_5_roll_'.$sr_no_value),
                  'bot_pos_6'=>$this->input->post('bot_pos_6_roll_'.$sr_no_value),
                  'bot_pos_7'=>$this->input->post('bot_pos_7_roll_'.$sr_no_value),
                  'bot_pos_8'=>$this->input->post('bot_pos_8_roll_'.$sr_no_value),
                  'bot_pos_9'=>$this->input->post('bot_pos_9_roll_'.$sr_no_value),
                  'bot_pos_10'=>$this->input->post('bot_pos_10_roll_'.$sr_no_value),                
                  'company_id'=>$this->session->userdata['logged_in']['company_id']
                  
                  );
                   //print_r($data);

                  $result=$this->common_model->save('springtube_extrusion_control_plan_qc_film_thickness',$data);
                }

              }                               
               
                
                $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

                $data['springtube_extrusion_control_plan_qc']=$this->springtube_extrusion_control_plan_qc_model->select_one_active_record('springtube_extrusion_control_plan_qc',$this->session->userdata['logged_in']['company_id'],'springtube_extrusion_control_plan_qc.cp_id',$this->input->post('cp_id'));

                $data['springtube_extrusion_control_plan_qc_film_thickness']=$this->common_model->select_one_active_record('springtube_extrusion_control_plan_qc_film_thickness',$this->session->userdata['logged_in']['company_id'],'cp_id',$this->input->post('cp_id'));

                $data['note']='Update Transaction Completed';

                header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/modify-roll-thickness-form',$data);
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

