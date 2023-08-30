<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Springtube_printing_jobsetup extends CI_Controller {

  function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');       
      $this->load->model('job_card_model');
      $this->load->model('artwork_springtube_model');
      $this->load->model('springtube_ink_mixing_model');
      $this->load->model('springtube_ink_master_model'); 
      $this->load->model('springtube_printing_jobsetup_model');
      $this->load->model('springtube_printing_production_model');

    }else{
      redirect('login','refresh');     
    }
  }  

  function index(){
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          
          if($formrights_row->view==1){
            $table='springtube_printing_jobsetup_master';
            include('pagination.php');
            $data['springtube_printing_jobsetup_master']=$this->springtube_printing_jobsetup_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

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

            //$data['springtube_ink_master']=$this->common_model->select_active_drop_down('springtube_ink_master',$this->session->userdata['logged_in']['company_id']);
            $data['springtube_anilox_master']=$this->common_model->select_active_drop_down('springtube_anilox_master',$this->session->userdata['logged_in']['company_id']);
            $data['springtube_cylinder_master']=$this->common_model->select_active_drop_down('springtube_cylinder_master',$this->session->userdata['logged_in']['company_id']);
            $data['springtube_printing_color_policy_master']=$this->common_model->select_active_drop_down('springtube_printing_color_policy_master',$this->session->userdata['logged_in']['company_id']);

            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','74');        

            // $dataa=array();
            // $data['article']=$this->article_model->springtube_printing_ink_lacquer('article',$dataa,$this->session->userdata['logged_in']['company_id']);

           // echo $this->db->last_query();
             
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
  //Eknath
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {

          if($formrights_row->new==1){

            $this->form_validation->set_rules('order_no','Order No' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('article_no','Article No' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('jobcard_no','Jobcard No' ,'required|trim|xss_clean|is_unique[springtube_printing_jobsetup_master.jobcard_no]');
            $this->form_validation->set_rules('approval_authority','Approval Authority' ,'required|trim|xss_clean');

            // ABG-1 FLEXO UNIT-1 

            if($this->input->post('abg1_ink_usage_1')!=''){
              $this->form_validation->set_rules('abg1_ink_id_1',$str.'Color/Ink name' ,'required|trim|xss_clean|callback_ink_check');
            }

            if($this->input->post('abg1_ink_id_1')!=''){
                $str='ABG-1 FLOXO UNIT-1 ';
                $this->form_validation->set_rules('abg1_carona_1', $str.'Corona' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_ink_id_1',$str.'Color/Ink name' ,'required|trim|xss_clean|callback_ink_check');                
                $this->form_validation->set_rules('abg1_anilox_1',$str.'Anilox' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_applying_method_1',$str.'Applying Method' ,'required|trim|xss_clean');                
                $this->form_validation->set_rules('abg1_cylinder_teeth_1',$str.'Cylinder Teeth' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_rotary_1',$str.'Semi/Full Rotary' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_uv_power_1',$str.'UV Power' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_uv_speed_1',$str.'UV Speed' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_uv_hours_1',$str.'UV Lamp Hours' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_ink_usage_1',$str.'Total Ink Consumption (Grams)' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_unit_1_comment',$str.'Comment' ,'trim|xss_clean|max_length[225]');
            }

            // ABG-1 FLEXO UNIT-2 
            if($this->input->post('abg1_ink_usage_2')!=''){
              $this->form_validation->set_rules('abg1_ink_id_2',$str.'Color/Ink name' ,'required|trim|xss_clean|callback_ink_check');
            }
            if($this->input->post('abg1_ink_id_2')!=''){
                $str='ABG-1 FLOXO UNIT-2 ';
                //$this->form_validation->set_rules('abg1_carona_2', $str.'Corona' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_ink_id_2',$str.'Color/Ink name' ,'required|trim|xss_clean|callback_ink_check');                
                $this->form_validation->set_rules('abg1_anilox_2',$str.'Anilox' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_applying_method_2',$str.'Applying Method' ,'required|trim|xss_clean');                
                $this->form_validation->set_rules('abg1_cylinder_teeth_2',$str.'Cylinder Teeth' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_rotary_2',$str.'Semi/Full Rotary' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_uv_power_2',$str.'UV Power' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_uv_speed_2',$str.'UV Speed' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_uv_hours_2',$str.'UV Lamp Hours' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_ink_usage_2',$str.'Total Ink Consumption (Grams)' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_unit_2_comment',$str.'Comment' ,'trim|xss_clean|max_length[225]');
            }

            // ABG-1 FLEXO UNIT-3 
            if($this->input->post('abg1_ink_usage_3')!=''){
              $this->form_validation->set_rules('abg1_ink_id_3',$str.'Color/Ink name' ,'required|trim|xss_clean|callback_ink_check');
            }
            if($this->input->post('abg1_ink_id_3')!=''){
                $str='ABG-1 FLOXO UNIT-3 ';
                //$this->form_validation->set_rules('abg1_carona_2', $str.'Corona' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_ink_id_3',$str.'Color/Ink name' ,'required|trim|xss_clean|callback_ink_check');                
                $this->form_validation->set_rules('abg1_anilox_3',$str.'Anilox' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_applying_method_3',$str.'Applying Method' ,'required|trim|xss_clean');                
                $this->form_validation->set_rules('abg1_cylinder_teeth_3',$str.'Cylinder Teeth' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_rotary_3',$str.'Semi/Full Rotary' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_uv_power_3',$str.'UV Power' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_uv_speed_3',$str.'UV Speed' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_uv_hours_3',$str.'UV Lamp Hours' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_ink_usage_3',$str.'Total Ink Consumption (Grams)' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_unit_3_comment',$str.'Comment' ,'trim|xss_clean|max_length[225]');
            }

            // ABG-1 FLEXO UNIT-4
            if($this->input->post('abg1_ink_usage_4')!=''){
              $this->form_validation->set_rules('abg1_ink_id_4',$str.'Color/Ink name' ,'required|trim|xss_clean|callback_ink_check');
            }

            if($this->input->post('abg1_ink_id_4')!=''){
                $str='ABG-1 FLOXO UNIT-4 ';
                //$this->form_validation->set_rules('abg1_carona_2', $str.'Corona' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_ink_id_4',$str.'Color/Ink name' ,'required|trim|xss_clean|callback_ink_check');                
                $this->form_validation->set_rules('abg1_anilox_4',$str.'Anilox' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_applying_method_4',$str.'Applying Method' ,'required|trim|xss_clean');                
                $this->form_validation->set_rules('abg1_cylinder_teeth_4',$str.'Cylinder Teeth' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_rotary_4',$str.'Semi/Full Rotary' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_uv_power_4',$str.'UV Power' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_uv_speed_4',$str.'UV Speed' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_uv_hours_4',$str.'UV Lamp Hours' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_ink_usage_4',$str.'Total Ink Consumption (Grams)' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_unit_4_comment',$str.'Comment' ,'trim|xss_clean|max_length[225]');
            }

            //DURST-------------------------
            if($this->input->post('is_durst')=='1'){

              $durst='DURST ';
              $this->form_validation->set_rules('durst_corona',$durst.'Corona' ,'trim|xss_clean');
              $this->form_validation->set_rules('print_confg',$durst.'Print Configuration' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('digital_white',$durst.'Digital White In Use' ,'required|trim|xss_clean');

              if($this->input->post('digital_white')=='YES'){

                  $this->form_validation->set_rules('pinning_w',$durst.'Pinning W','required|trim|xss_clean');
              }else{

                $this->form_validation->set_rules('pinning_w',$durst.'Pinning W','trim|xss_clean');

              }
              $this->form_validation->set_rules('colour_policy',$durst.'Colour Policy' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('substrate_defination',$durst.'Substrate Defination','required|trim|xss_clean');
              $this->form_validation->set_rules('printing_speed',$durst.'Printing Speed','required|trim|xss_clean');
              $this->form_validation->set_rules('unwind_tension',$durst.'Tension','required|trim|xss_clean');
              
              $this->form_validation->set_rules('pinning_k',$durst.'Pinning K','required|trim|xss_clean');
              $this->form_validation->set_rules('durst_uv_curing_1',$durst.'UV Curing-1','required|trim|xss_clean');
              $this->form_validation->set_rules('durst_uv_lamp_hrs_1',$durst.'Lamp 1 Hours','required|trim|xss_clean');
              $this->form_validation->set_rules('durst_uv_curing_2',$durst.'UV Curing-2','required|trim|xss_clean');
              $this->form_validation->set_rules('durst_uv_lamp_hrs_2',$durst.'Lamp 2 Hours','required|trim|xss_clean');
              $this->form_validation->set_rules('nitrogen',$durst.'Nitrogen Used','required|trim|xss_clean');
              $this->form_validation->set_rules('digital_cost_in_euro',$durst.'Digital Cost In Euro','required|trim|xss_clean');
              $this->form_validation->set_rules('durst_comment',$durst.'Comment','trim|xss_clean');
            }

            // ABG-2 FLEXO UNIT-1 ------------------------------
            if($this->input->post('abg2_ink_usage_1')!=''){
              $this->form_validation->set_rules('abg2_ink_id_1',$str.'Color/Ink name' ,'required|trim|xss_clean|callback_ink_check');
            }
            if($this->input->post('abg2_ink_id_1')!=''){
                $str='ABG-2 FLOXO UNIT-1 ';
                $this->form_validation->set_rules('abg2_carona_1', $str.'Corona' ,'trim|xss_clean');
                $this->form_validation->set_rules('abg2_ink_id_1',$str.'Color/Ink name' ,'required|trim|xss_clean|callback_ink_check');                
                $this->form_validation->set_rules('abg2_anilox_1',$str.'Anilox' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg2_applying_method_1',$str.'Applying Method' ,'required|trim|xss_clean');                
                $this->form_validation->set_rules('abg2_cylinder_teeth_1',$str.'Cylinder Teeth' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg2_rotary_1',$str.'Semi/Full Rotary' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg2_uv_power_1',$str.'UV Power' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg2_uv_speed_1',$str.'UV Speed' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg2_uv_hours_1',$str.'UV Lamp Hours' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg2_ink_usage_1',$str.'Total Ink Consumption (Grams)' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg2_unit_1_comment',$str.'Comment' ,'trim|xss_clean|max_length[225]');
            }

            // ABG-2 FLEXO UNIT-2------------------------- 
            if($this->input->post('abg2_ink_usage_2')!=''){
              $this->form_validation->set_rules('abg2_ink_id_2',$str.'Color/Ink name' ,'required|trim|xss_clean|callback_ink_check');
            }
            if($this->input->post('abg2_ink_id_2')!=''){
                $str='ABG-2 FLOXO UNIT-2 ';
                //$this->form_validation->set_rules('abg1_carona_2', $str.'Corona' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg2_ink_id_2',$str.'Color/Ink name' ,'required|trim|xss_clean|callback_ink_check');                
                $this->form_validation->set_rules('abg2_anilox_2',$str.'Anilox' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg2_applying_method_2',$str.'Applying Method' ,'required|trim|xss_clean');                
                $this->form_validation->set_rules('abg2_cylinder_teeth_2',$str.'Cylinder Teeth' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg2_rotary_2',$str.'Semi/Full Rotary' ,'required|trim|xss_clean');

                $this->form_validation->set_rules('is_extended_path',$str.'Extended Web Path' ,'required|trim|xss_clean');

                if($this->input->post('is_extended_path')=='YES'){                  
                  $this->form_validation->set_rules('abg2_extended_uv_power_2',$str.'Extended UV Power' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg2_extended_uv_speed_2',$str.'Extended UV Speed' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg2_extended_uv_hours_2',$str.'Extended UV Lamp Hours' ,'required|trim|xss_clean');
                }else{
                  $this->form_validation->set_rules('abg2_uv_power_2',$str.'UV Power' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg2_uv_speed_2',$str.'UV Speed' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg2_uv_hours_2',$str.'UV Lamp Hours' ,'required|trim|xss_clean');
                }

                $this->form_validation->set_rules('abg2_ink_usage_2',$str.'Total Ink Consumption (Grams)' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg2_unit_2_comment',$str.'Comment' ,'trim|xss_clean|max_length[225]');
            } 

            // FOIL 1 VALIDATION
            if(!empty($this->input->post('cold_foil_1'))){

              $this->form_validation->set_rules('cold_foil_1_width','Cold Foil 1 Width' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cold_foil_1_length','Cold Foil 1 Length' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cold_foil_1_area','Cold Foil 1 Area' ,'required|trim|xss_clean');

            }

            // FOIL 2 VALIDATION
            if(!empty($this->input->post('cold_foil_2'))){

              $this->form_validation->set_rules('cold_foil_2_width','Cold Foil 2 Width' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cold_foil_2_length','Cold Foil 2 Length' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cold_foil_2_area','Cold Foil 2 Area' ,'required|trim|xss_clean');

            }
              
            

            if($this->form_validation->run()==FALSE){
              
              $data['springtube_anilox_master']=$this->common_model->select_active_drop_down('springtube_anilox_master',$this->session->userdata['logged_in']['company_id']);
              $data['springtube_cylinder_master']=$this->common_model->select_active_drop_down('springtube_cylinder_master',$this->session->userdata['logged_in']['company_id']); 
              $data['springtube_printing_color_policy_master']=$this->common_model->select_active_drop_down('springtube_printing_color_policy_master',$this->session->userdata['logged_in']['company_id']);

              $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','74');        
       
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
              $this->load->view('Home/footer');
            }else{

              $ink_1='';
              $ink_1_consum=0;
              if($this->input->post('abg1_ink_id_1')!=''){
                $ink_1_arr=explode("//",$this->input->post('abg1_ink_id_1'));
                $ink_1=$ink_1_arr[1];
              }
              $ink_2='';
              if($this->input->post('abg1_ink_id_2')!=''){
                $ink_2_arr=explode("//",$this->input->post('abg1_ink_id_2'));
                $ink_2=$ink_2_arr[1];
              }
              $ink_3='';
              if($this->input->post('abg1_ink_id_3')!=''){
                $ink_3_arr=explode("//",$this->input->post('abg1_ink_id_3'));
                $ink_3=$ink_3_arr[1];
              }
              $ink_4='';
              if($this->input->post('abg1_ink_id_4')!=''){
                $ink_4_arr=explode("//",$this->input->post('abg1_ink_id_4'));
                $ink_4=$ink_4_arr[1];
              }
              $ink_5='';
              if($this->input->post('abg2_ink_id_1')!=''){
                $ink_5_arr=explode("//",$this->input->post('abg2_ink_id_1'));
                $ink_5=$ink_5_arr[1];
              }
              $ink_6='';
              if($this->input->post('abg2_ink_id_2')!=''){
                $ink_6_arr=explode("//",$this->input->post('abg2_ink_id_2'));
                $ink_6=$ink_6_arr[1];
              }

              $is_extended_path='';
              $abg2_uv_power_2= '';
              $abg2_uv_speed_2='';
              $abg2_uv_hours_2='';

              $abg2_extended_uv_power_2='';
              $abg2_extended_uv_speed_2='';
              $abg2_extended_uv_hours_2='';

              if(!empty($this->input->post('is_extended_path'))){

                $is_extended_path=$this->input->post('is_extended_path');

                if($this->input->post('is_extended_path')=='YES'){
                  $abg2_extended_uv_power_2=$this->input->post('abg2_extended_uv_power_2');
                  $abg2_extended_uv_speed_2=$this->input->post('abg2_extended_uv_speed_2');
                  $abg2_extended_uv_hours_2=$this->input->post('abg2_extended_uv_hours_2');

                }else{
                  $abg2_uv_power_2=$this->input->post('abg2_uv_power_2');
                  $abg2_uv_speed_2=$this->input->post('abg2_uv_speed_2');
                  $abg2_uv_hours_2=$this->input->post('abg2_uv_hours_2');
                }

              }             
              
              $data=array(                    
                'jobsetup_date'=>date('Y-m-d'),
                'jobcard_no'=>$this->input->post('jobcard_no'),
                'order_no'=>$this->input->post('order_no'),
                'article_no'=>$this->input->post('article_no'),

                'abg1_carona_1'=>$this->input->post('abg1_carona_1'),
                'abg1_ink_id_1'=>$ink_1, 
                'abg1_anilox_1'=>$this->input->post('abg1_anilox_1'),
                'abg1_applying_method_1'=>$this->input->post('abg1_applying_method_1'),
                'abg1_cylinder_teeth_1'=>$this->input->post('abg1_cylinder_teeth_1'),
                'abg1_rotary_1'=>$this->input->post('abg1_rotary_1'),
                'abg1_uv_power_1'=>$this->input->post('abg1_uv_power_1'),
                'abg1_uv_speed_1'=>$this->input->post('abg1_uv_speed_1'),
                'abg1_uv_hours_1'=>$this->input->post('abg1_uv_hours_1'),
                'abg1_ink_usage_1'=>$this->input->post('abg1_ink_usage_1'),
                'abg1_unit_1_comment'=>$this->input->post('abg1_unit_1_comment'),

                'abg1_ink_id_2'=>$ink_2, 
                'abg1_anilox_2'=>$this->input->post('abg1_anilox_2'),
                'abg1_applying_method_2'=>$this->input->post('abg1_applying_method_2'),
                'abg1_cylinder_teeth_2'=>$this->input->post('abg1_cylinder_teeth_2'),
                'abg1_rotary_2'=>$this->input->post('abg1_rotary_2'),
                'abg1_uv_power_2'=>$this->input->post('abg1_uv_power_2'),
                'abg1_uv_speed_2'=>$this->input->post('abg1_uv_speed_2'),
                'abg1_uv_hours_2'=>$this->input->post('abg1_uv_hours_2'),
                'abg1_ink_usage_2'=>$this->input->post('abg1_ink_usage_2'),
                'abg1_unit_2_comment'=>$this->input->post('abg1_unit_2_comment'),

                'abg1_ink_id_3'=>$ink_3, 
                'abg1_anilox_3'=>$this->input->post('abg1_anilox_3'),
                'abg1_applying_method_3'=>$this->input->post('abg1_applying_method_3'),
                'abg1_cylinder_teeth_3'=>$this->input->post('abg1_cylinder_teeth_3'),
                'abg1_rotary_3'=>$this->input->post('abg1_rotary_3'),
                'abg1_uv_power_3'=>$this->input->post('abg1_uv_power_3'),
                'abg1_uv_speed_3'=>$this->input->post('abg1_uv_speed_3'),
                'abg1_uv_hours_3'=>$this->input->post('abg1_uv_hours_3'),
                'abg1_ink_usage_3'=>$this->input->post('abg1_ink_usage_3'),
                'abg1_unit_3_comment'=>$this->input->post('abg1_unit_3_comment'),

                'abg1_ink_id_4'=>$ink_4, 
                'abg1_anilox_4'=>$this->input->post('abg1_anilox_4'),
                'abg1_applying_method_4'=>$this->input->post('abg1_applying_method_4'),
                'abg1_cylinder_teeth_4'=>$this->input->post('abg1_cylinder_teeth_4'),
                'abg1_rotary_4'=>$this->input->post('abg1_rotary_4'),
                'abg1_uv_power_4'=>$this->input->post('abg1_uv_power_4'),
                'abg1_uv_speed_4'=>$this->input->post('abg1_uv_speed_4'),
                'abg1_uv_hours_4'=>$this->input->post('abg1_uv_hours_4'),
                'abg1_ink_usage_4'=>$this->input->post('abg1_ink_usage_4'),
                'abg1_unit_4_comment'=>$this->input->post('abg1_unit_4_comment'),

                'is_durst'=>(!empty($this->input->post('is_durst'))?1:0),
                'durst_corona'=>$this->input->post('durst_corona'),
                'print_confg'=>(!empty($this->input->post('print_confg'))?$this->input->post('print_confg'):''),
                'digital_white'=>(!empty($this->input->post('digital_white'))?$this->input->post('digital_white'):''),
                'colour_policy'=>$this->input->post('colour_policy'),
                'substrate_defination'=>$this->input->post('substrate_defination'),
                'printing_speed'=>$this->input->post('printing_speed'),
                'unwind_tension'=>$this->input->post('unwind_tension'),
                'pinning_w'=>$this->input->post('pinning_w'),
                'pinning_k'=>$this->input->post('pinning_k'),
                'durst_uv_curing_1'=>$this->input->post('durst_uv_curing_1'),
                'durst_uv_lamp_hrs_1'=>$this->input->post('durst_uv_lamp_hrs_1'),
                'durst_uv_curing_2'=>$this->input->post('durst_uv_curing_2'),
                'durst_uv_lamp_hrs_2'=>$this->input->post('durst_uv_lamp_hrs_2'),
                'nitrogen'=>(!empty($this->input->post('nitrogen'))?$this->input->post('nitrogen'):''),
                'durst_comment'=>$this->input->post('durst_comment'),
                'digital_cost_in_euro'=>$this->input->post('digital_cost_in_euro'),
                 
                'abg2_carona_1'=>$this->input->post('abg2_carona_1'),
                'abg2_ink_id_1'=>$ink_5, 
                'abg2_anilox_1'=>$this->input->post('abg2_anilox_1'),
                'abg2_applying_method_1'=>$this->input->post('abg2_applying_method_1'),
                'abg2_cylinder_teeth_1'=>$this->input->post('abg2_cylinder_teeth_1'),
                'abg2_rotary_1'=>$this->input->post('abg2_rotary_1'),
                'abg2_uv_power_1'=>$this->input->post('abg2_uv_power_1'),
                'abg2_uv_speed_1'=>$this->input->post('abg2_uv_speed_1'),
                'abg2_uv_hours_1'=>$this->input->post('abg2_uv_hours_1'),
                'abg2_ink_usage_1'=>$this->input->post('abg2_ink_usage_1'),
                'abg2_unit_1_comment'=>$this->input->post('abg2_unit_1_comment'),

                'abg2_ink_id_2'=>$ink_6, 
                'abg2_anilox_2'=>$this->input->post('abg2_anilox_2'),
                'abg2_applying_method_2'=>$this->input->post('abg2_applying_method_2'),
                'abg2_cylinder_teeth_2'=>$this->input->post('abg2_cylinder_teeth_2'),
                'abg2_rotary_2'=>$this->input->post('abg2_rotary_2'),
                'is_extended_path'=>$is_extended_path,
                'abg2_uv_power_2'=>$abg2_uv_power_2,
                'abg2_uv_speed_2'=>$abg2_uv_speed_2,
                'abg2_uv_hours_2'=>$abg2_uv_hours_2,
                'abg2_extended_uv_power_2'=>$abg2_extended_uv_power_2,
                'abg2_extended_uv_speed_2'=>$abg2_extended_uv_speed_2,
                'abg2_extended_uv_hours_2'=>$abg2_extended_uv_hours_2,
                'abg2_ink_usage_2'=>$this->input->post('abg2_ink_usage_2'),
                'abg2_unit_2_comment'=>$this->input->post('abg2_unit_2_comment'),
                'user_id'=>$this->session->userdata['logged_in']['user_id'],
                'company_id'=>$this->session->userdata['logged_in']['company_id'],
                
                 
                     
              );

              $job_id=$this->common_model->save_return_pkey('springtube_printing_jobsetup_master',$data); 


              if($job_id){

                $result_ink =$this->insert_inks_to_jobcard($ink_1,$this->input->post('abg1_ink_usage_1'),$ink_2,$this->input->post('abg1_ink_usage_2'),$ink_3,$this->input->post('abg1_ink_usage_3'),$ink_4,$this->input->post('abg1_ink_usage_4'),$ink_5,$this->input->post('abg2_ink_usage_1'),$ink_6,$this->input->post('abg2_ink_usage_2')); 

                // Change due to flexo plates are not issueing to tally in sqmm--- 
                //$result_plates=$this->insert_plates_to_jobcard($this->input->post('order_no'),
                //$this->input->post('article_no'),$this->input->post('jobcard_no'));


                if(!empty($this->input->post('approval_authority'))){

                  $record_no=$this->input->post('jobcard_no').'@@@'.$job_id;

                  $data=array('pending_flag'=>'1');
                  $result=$this->common_model->update_one_active_record('springtube_printing_jobsetup_master',$data,'job_id',$job_id,$this->session->userdata['logged_in']['company_id']);

                  $data['followup']=$this->common_model->select_one_active_record_nonlanguage_without_archive('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$record_no);
                  if($data['followup']==FALSE){
                        $transaction_no=1;
                        $status=1;
                  }else{
                        $i=1;
                        foreach ($data['followup'] as $followup_row) {
                          $transaction_no=$followup_row->transaction_no;
                          $status=1;
                          $i++;
                        }
                        $transaction_no=$i;
                  }

                  $data=array(
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'user_id'=>$this->input->post('approval_authority'),
                        'form_id'=>'74',
                        'transaction_no'=>$transaction_no,
                        'status'=>$status,
                        'followup_date'=>date('Y-m-d'),
                        'contact_person_id'=>$this->session->userdata['logged_in']['user_id'],
                        'record_no'=>$record_no,
                        );

                    $result=$this->common_model->save('followup',$data);
                }


                if($result_ink){
                  $data['note']='Ink Save Transaction Completed';

                }else{                  
                  $data['error']='Ink Save Transaction failed';
                }

                if($result_plates){

                  $data['note']='Flexo plates Save Transaction Completed';

                }else{                  
                  $data['error']='No Flexo plates available';
                }

                $data['note']='Create Transaction Completed';

              }else{
                $data['error']='Create Transaction failed';
              }



               

              header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
               
              $data['springtube_anilox_master']=$this->common_model->select_active_drop_down('springtube_anilox_master',$this->session->userdata['logged_in']['company_id']);
              $data['springtube_cylinder_master']=$this->common_model->select_active_drop_down('springtube_cylinder_master',$this->session->userdata['logged_in']['company_id']);
              $data['springtube_printing_color_policy_master']=$this->common_model->select_active_drop_down('springtube_printing_color_policy_master',$this->session->userdata['logged_in']['company_id']); 

              $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','74');        


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

  function modify(){
    
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){

            $data['springtube_printing_jobsetup_master']=$this->springtube_printing_jobsetup_model->select_one_active_record('springtube_printing_jobsetup_master',$this->session->userdata['logged_in']['company_id'],'job_id',$this->uri->segment(3));
            // echo'<pre>';
            // print_r($data['springtube_printing_jobsetup_master']);
            // echo'</pre>';

            $data['springtube_anilox_master']=$this->common_model->select_active_drop_down('springtube_anilox_master',$this->session->userdata['logged_in']['company_id']);
            $data['springtube_cylinder_master']=$this->common_model->select_active_drop_down('springtube_cylinder_master',$this->session->userdata['logged_in']['company_id']);
            $data['springtube_printing_color_policy_master']=$this->common_model->select_active_drop_down('springtube_printing_color_policy_master',$this->session->userdata['logged_in']['company_id']); 

            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','74');


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
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){

              $this->form_validation->set_rules('order_no','Order No' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('article_no','Article No' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('jobcard_no','Jobcard No' ,'required|trim|xss_clean');

              $this->form_validation->set_rules('approval_authority','Approval Authority' ,'required|trim|xss_clean');

              // ABG-1 FLEXO UNIT-1 
              if($this->input->post('abg1_ink_id_1')!=''){
                  $str='ABG-1 FLOXO UNIT-1 ';
                  $this->form_validation->set_rules('abg1_carona_1', $str.'Corona' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg1_ink_id_1',$str.'Color/Ink name' ,'required|trim|xss_clean|callback_ink_check');                
                  $this->form_validation->set_rules('abg1_anilox_1',$str.'Anilox' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg1_applying_method_1',$str.'Applying Method' ,'required|trim|xss_clean');                
                  $this->form_validation->set_rules('abg1_cylinder_teeth_1',$str.'Cylinder Teeth' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg1_rotary_1',$str.'Semi/Full Rotary' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg1_uv_power_1',$str.'UV Power' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg1_uv_speed_1',$str.'UV Speed' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg1_uv_hours_1',$str.'UV Lamp Hours' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg1_ink_usage_1',$str.'Total Ink Consumption (Grams)' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg1_unit_1_comment',$str.'Comment' ,'trim|xss_clean|max_length[225]');
              }

              // ABG-1 FLEXO UNIT-2 
              if($this->input->post('abg1_ink_id_2')!=''){
                  $str='ABG-1 FLOXO UNIT-2 ';
                  //$this->form_validation->set_rules('abg1_carona_2', $str.'Corona' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg1_ink_id_2',$str.'Color/Ink name' ,'required|trim|xss_clean|callback_ink_check');                
                  $this->form_validation->set_rules('abg1_anilox_2',$str.'Anilox' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg1_applying_method_2',$str.'Applying Method' ,'required|trim|xss_clean');                
                  $this->form_validation->set_rules('abg1_cylinder_teeth_2',$str.'Cylinder Teeth' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg1_rotary_2',$str.'Semi/Full Rotary' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg1_uv_power_2',$str.'UV Power' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg1_uv_speed_2',$str.'UV Speed' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg1_uv_hours_2',$str.'UV Lamp Hours' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg1_ink_usage_2',$str.'Total Ink Consumption (Grams)' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg1_unit_2_comment',$str.'Comment' ,'trim|xss_clean|max_length[225]');
              }

              // ABG-1 FLEXO UNIT-3 
              if($this->input->post('abg1_ink_id_3')!=''){
                  $str='ABG-1 FLOXO UNIT-3 ';
                  //$this->form_validation->set_rules('abg1_carona_2', $str.'Corona' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg1_ink_id_3',$str.'Color/Ink name' ,'required|trim|xss_clean|callback_ink_check');                
                  $this->form_validation->set_rules('abg1_anilox_3',$str.'Anilox' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg1_applying_method_3',$str.'Applying Method' ,'required|trim|xss_clean');                
                  $this->form_validation->set_rules('abg1_cylinder_teeth_3',$str.'Cylinder Teeth' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg1_rotary_3',$str.'Semi/Full Rotary' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg1_uv_power_3',$str.'UV Power' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg1_uv_speed_3',$str.'UV Speed' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg1_uv_hours_3',$str.'UV Lamp Hours' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg1_ink_usage_3',$str.'Total Ink Consumption (Grams)' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg1_unit_3_comment',$str.'Comment' ,'trim|xss_clean|max_length[225]');
              }

              // ABG-1 FLEXO UNIT-2 
              if($this->input->post('abg1_ink_id_4')!=''){
                  $str='ABG-1 FLOXO UNIT-4 ';
                  //$this->form_validation->set_rules('abg1_carona_2', $str.'Corona' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg1_ink_id_4',$str.'Color/Ink name' ,'required|trim|xss_clean|callback_ink_check');                
                  $this->form_validation->set_rules('abg1_anilox_4',$str.'Anilox' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg1_applying_method_4',$str.'Applying Method' ,'required|trim|xss_clean');                
                  $this->form_validation->set_rules('abg1_cylinder_teeth_4',$str.'Cylinder Teeth' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg1_rotary_4',$str.'Semi/Full Rotary' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg1_uv_power_4',$str.'UV Power' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg1_uv_speed_4',$str.'UV Speed' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg1_uv_hours_4',$str.'UV Lamp Hours' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg1_ink_usage_4',$str.'Total Ink Consumption (Grams)' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg1_unit_4_comment',$str.'Comment' ,'trim|xss_clean|max_length[225]');
              }

              //DURST-------------------------
              if($this->input->post('is_durst')=='1'){

                $durst='DURST ';
                $this->form_validation->set_rules('durst_corona',$durst.'Corona' ,'trim|xss_clean');
                $this->form_validation->set_rules('print_confg',$durst.'Print Configuration' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('digital_white',$durst.'Digital White In Use' ,'required|trim|xss_clean');
                if($this->input->post('digital_white')=='YES'){

                  $this->form_validation->set_rules('pinning_w',$durst.'Pinning W','required|trim|xss_clean');
                }else{

                  $this->form_validation->set_rules('pinning_w',$durst.'Pinning W','trim|xss_clean');

                }
                $this->form_validation->set_rules('colour_policy',$durst.'Colour Policy' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('substrate_defination',$durst.'Substrate Defination','required|trim|xss_clean');
                $this->form_validation->set_rules('printing_speed',$durst.'Printing Speed','required|trim|xss_clean');
                $this->form_validation->set_rules('unwind_tension',$durst.'Tension','required|trim|xss_clean');
                //$this->form_validation->set_rules('pinning_w',$durst.'Pinning W','required|trim|xss_clean');
                $this->form_validation->set_rules('pinning_k',$durst.'Pinning K','required|trim|xss_clean');
                $this->form_validation->set_rules('durst_uv_curing_1',$durst.'UV Curing-1','required|trim|xss_clean');
                $this->form_validation->set_rules('durst_uv_lamp_hrs_1',$durst.'Lamp 1 Hours','required|trim|xss_clean');
                $this->form_validation->set_rules('durst_uv_curing_2',$durst.'UV Curing-2','required|trim|xss_clean');
                $this->form_validation->set_rules('durst_uv_lamp_hrs_2',$durst.'Lamp 2 Hours','required|trim|xss_clean');
                $this->form_validation->set_rules('nitrogen',$durst.'Nitrogen Used','required|trim|xss_clean');
                $this->form_validation->set_rules('digital_cost_in_euro',$durst.'Digital Cost In Euro','required|trim|xss_clean');
                $this->form_validation->set_rules('durst_comment',$durst.'Comment','trim|xss_clean');
              }

              // ABG-2 FLEXO UNIT-1 ------------------------------
              if($this->input->post('abg2_ink_id_1')!=''){
                  $str='ABG-2 FLOXO UNIT-1 ';
                  $this->form_validation->set_rules('abg2_carona_1', $str.'Corona' ,'trim|xss_clean');
                  $this->form_validation->set_rules('abg2_ink_id_1',$str.'Color/Ink name' ,'required|trim|xss_clean|callback_ink_check');                
                  $this->form_validation->set_rules('abg2_anilox_1',$str.'Anilox' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg2_applying_method_1',$str.'Applying Method' ,'required|trim|xss_clean');                
                  $this->form_validation->set_rules('abg2_cylinder_teeth_1',$str.'Cylinder Teeth' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg2_rotary_1',$str.'Semi/Full Rotary' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg2_uv_power_1',$str.'UV Power' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg2_uv_speed_1',$str.'UV Speed' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg2_uv_hours_1',$str.'UV Lamp Hours' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg2_ink_usage_1',$str.'Total Ink Consumption (Grams)' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg2_unit_1_comment',$str.'Comment' ,'trim|xss_clean|max_length[225]');
              }

              // ABG-2 FLEXO UNIT-2------------------------- 
              if($this->input->post('abg2_ink_id_2')!=''){
                  $str='ABG-2 FLOXO UNIT-2 ';
                  //$this->form_validation->set_rules('abg1_carona_2', $str.'Corona' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg2_ink_id_2',$str.'Color/Ink name' ,'required|trim|xss_clean|callback_ink_check');                
                  $this->form_validation->set_rules('abg2_anilox_2',$str.'Anilox' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg2_applying_method_2',$str.'Applying Method' ,'required|trim|xss_clean');                
                  $this->form_validation->set_rules('abg2_cylinder_teeth_2',$str.'Cylinder Teeth' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg2_rotary_2',$str.'Semi/Full Rotary' ,'required|trim|xss_clean');

                  $this->form_validation->set_rules('is_extended_path',$str.'Extended Web Path' ,'required|trim|xss_clean');

                  if($this->input->post('is_extended_path')=='YES'){                  
                    $this->form_validation->set_rules('abg2_extended_uv_power_2',$str.'Extended UV Power' ,'required|trim|xss_clean');
                    $this->form_validation->set_rules('abg2_extended_uv_speed_2',$str.'Extended UV Speed' ,'required|trim|xss_clean');
                    $this->form_validation->set_rules('abg2_extended_uv_hours_2',$str.'Extended UV Lamp Hours' ,'required|trim|xss_clean');
                  }else{
                    $this->form_validation->set_rules('abg2_uv_power_2',$str.'UV Power' ,'required|trim|xss_clean');
                    $this->form_validation->set_rules('abg2_uv_speed_2',$str.'UV Speed' ,'required|trim|xss_clean');
                    $this->form_validation->set_rules('abg2_uv_hours_2',$str.'UV Lamp Hours' ,'required|trim|xss_clean');
                  }

                  $this->form_validation->set_rules('abg2_ink_usage_2',$str.'Total Ink Consumption (Grams)' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg2_unit_2_comment',$str.'Comment' ,'trim|xss_clean|max_length[225]');
              } 

              if($this->form_validation->run()==FALSE){
                
                $data['springtube_printing_jobsetup_master']=$this->springtube_printing_jobsetup_model->select_one_active_record('springtube_printing_jobsetup_master',$this->session->userdata['logged_in']['company_id'],'job_id',$this->input->post('job_id'));

                $data['springtube_anilox_master']=$this->common_model->select_active_drop_down('springtube_anilox_master',$this->session->userdata['logged_in']['company_id']);
                $data['springtube_cylinder_master']=$this->common_model->select_active_drop_down('springtube_cylinder_master',$this->session->userdata['logged_in']['company_id']);

                $data['springtube_printing_color_policy_master']=$this->common_model->select_active_drop_down('springtube_printing_color_policy_master',$this->session->userdata['logged_in']['company_id']); 

                $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','74');       
 
                
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
                $this->load->view('Home/footer');

              }else{

              $ink_1='';
              $ink_1_consum=0;
              if($this->input->post('abg1_ink_id_1')!=''){
                $ink_1_arr=explode("//",$this->input->post('abg1_ink_id_1'));
                $ink_1=$ink_1_arr[1];
              }
              $ink_2='';
              if($this->input->post('abg1_ink_id_2')!=''){
                $ink_2_arr=explode("//",$this->input->post('abg1_ink_id_2'));
                $ink_2=$ink_2_arr[1];
              }
              $ink_3='';
              if($this->input->post('abg1_ink_id_3')!=''){
                $ink_3_arr=explode("//",$this->input->post('abg1_ink_id_3'));
                $ink_3=$ink_3_arr[1];
              }
              $ink_4='';
              if($this->input->post('abg1_ink_id_4')!=''){
                $ink_4_arr=explode("//",$this->input->post('abg1_ink_id_4'));
                $ink_4=$ink_4_arr[1];
              }
              $ink_5='';
              if($this->input->post('abg2_ink_id_1')!=''){
                $ink_5_arr=explode("//",$this->input->post('abg2_ink_id_1'));
                $ink_5=$ink_5_arr[1];
              }
              $ink_6='';
              if($this->input->post('abg2_ink_id_2')!=''){
                $ink_6_arr=explode("//",$this->input->post('abg2_ink_id_2'));
                $ink_6=$ink_6_arr[1];
              }

              $is_extended_path='';
              $abg2_uv_power_2= '';
              $abg2_uv_speed_2='';
              $abg2_uv_hours_2='';

              $abg2_extended_uv_power_2='';
              $abg2_extended_uv_speed_2='';
              $abg2_extended_uv_hours_2='';

              if(!empty($this->input->post('is_extended_path'))){

                $is_extended_path=$this->input->post('is_extended_path');

                if($this->input->post('is_extended_path')=='YES'){
                  $abg2_extended_uv_power_2=$this->input->post('abg2_extended_uv_power_2');
                  $abg2_extended_uv_speed_2=$this->input->post('abg2_extended_uv_speed_2');
                  $abg2_extended_uv_hours_2=$this->input->post('abg2_extended_uv_hours_2');

                }else{
                  $abg2_uv_power_2=$this->input->post('abg2_uv_power_2');
                  $abg2_uv_speed_2=$this->input->post('abg2_uv_speed_2');
                  $abg2_uv_hours_2=$this->input->post('abg2_uv_hours_2');
                }

              }


              // Removing Old data from Jobcard-------

              $springtube_printing_jobsetup_master_result=$this->springtube_printing_jobsetup_model->select_one_active_record('springtube_printing_jobsetup_master',$this->session->userdata['logged_in']['company_id'],'job_id',$this->input->post('job_id'));

              foreach ($springtube_printing_jobsetup_master_result as $key => $springtube_printing_jobsetup_master_row) {

                if($springtube_printing_jobsetup_master_row->jobcard_no!=''){

                  $sql_insert="INSERT INTO production.material_manufacturing (`manu_order_no`, `article_no`,`sfg_flag`, `alternative_article_no`, `part_list_no`, `demand_qty`, `qty_on_hand`, `original_article_no`, `parts_list_flag`, `supplier_no`, `manufacturer_id`, `semi_manu_flag`, `company_id`,`archive`, `work_proc_no`, `from_job_card`, `mm_qty_use`, `mm_scrap_qty`, `procedures_completed`, `procedures_remaining`, `start_date`, `start_time`, `layer_no`, `stop_date`, `stop_time`, `operator_id`, `production_type`, `rel_demand_qty`, `flag_uom_type`, `rel_uom_id`, `mm_id`, `release_no`, `part_pos_no`, `club_mpw_pos_nos`, `completed_flag`, `calculated_purchase_price`, `req_purging_std_qty`, `req_purging_rel_qty`, `from_printing_jobsetup`) SELECT * FROM neo. material_manufacturing where from_printing_jobsetup ='1' AND manu_order_no='".$springtube_printing_jobsetup_master_row->jobcard_no."'";
                  
                  $query1=$this->db->query($sql_insert);                  
                  //$query1->result();

                  $sql_delete="DELETE FROM neo.material_manufacturing WHERE from_printing_jobsetup ='1' AND manu_order_no='".$springtube_printing_jobsetup_master_row->jobcard_no."'";

                  $query2=$this->db->query($sql_delete);
                  //$query2->result();

                }
                
              }

              
              $data=array(                    
                //'jobsetup_date'=>date('Y-m-d'),
                'jobcard_no'=>$this->input->post('jobcard_no'),
                'order_no'=>$this->input->post('order_no'),
                'article_no'=>$this->input->post('article_no'),
                'abg1_carona_1'=>$this->input->post('abg1_carona_1'),
                'abg1_ink_id_1'=>$ink_1, 
                'abg1_anilox_1'=>$this->input->post('abg1_anilox_1'),
                'abg1_applying_method_1'=>$this->input->post('abg1_applying_method_1'),
                'abg1_cylinder_teeth_1'=>$this->input->post('abg1_cylinder_teeth_1'),
                'abg1_rotary_1'=>$this->input->post('abg1_rotary_1'),
                'abg1_uv_power_1'=>$this->input->post('abg1_uv_power_1'),
                'abg1_uv_speed_1'=>$this->input->post('abg1_uv_speed_1'),
                'abg1_uv_hours_1'=>$this->input->post('abg1_uv_hours_1'),
                'abg1_ink_usage_1'=>$this->input->post('abg1_ink_usage_1'),
                'abg1_unit_1_comment'=>$this->input->post('abg1_unit_1_comment'),

                'abg1_ink_id_2'=>$ink_2, 
                'abg1_anilox_2'=>$this->input->post('abg1_anilox_2'),
                'abg1_applying_method_2'=>$this->input->post('abg1_applying_method_2'),
                'abg1_cylinder_teeth_2'=>$this->input->post('abg1_cylinder_teeth_2'),
                'abg1_rotary_2'=>$this->input->post('abg1_rotary_2'),
                'abg1_uv_power_2'=>$this->input->post('abg1_uv_power_2'),
                'abg1_uv_speed_2'=>$this->input->post('abg1_uv_speed_2'),
                'abg1_uv_hours_2'=>$this->input->post('abg1_uv_hours_2'),
                'abg1_ink_usage_2'=>$this->input->post('abg1_ink_usage_2'),
                'abg1_unit_2_comment'=>$this->input->post('abg1_unit_2_comment'),

                'abg1_ink_id_3'=>$ink_3, 
                'abg1_anilox_3'=>$this->input->post('abg1_anilox_3'),
                'abg1_applying_method_3'=>$this->input->post('abg1_applying_method_3'),
                'abg1_cylinder_teeth_3'=>$this->input->post('abg1_cylinder_teeth_3'),
                'abg1_rotary_3'=>$this->input->post('abg1_rotary_3'),
                'abg1_uv_power_3'=>$this->input->post('abg1_uv_power_3'),
                'abg1_uv_speed_3'=>$this->input->post('abg1_uv_speed_3'),
                'abg1_uv_hours_3'=>$this->input->post('abg1_uv_hours_3'),
                'abg1_ink_usage_3'=>$this->input->post('abg1_ink_usage_3'),
                'abg1_unit_3_comment'=>$this->input->post('abg1_unit_3_comment'),

                'abg1_ink_id_4'=>$ink_4, 
                'abg1_anilox_4'=>$this->input->post('abg1_anilox_4'),
                'abg1_applying_method_4'=>$this->input->post('abg1_applying_method_4'),
                'abg1_cylinder_teeth_4'=>$this->input->post('abg1_cylinder_teeth_4'),
                'abg1_rotary_4'=>$this->input->post('abg1_rotary_4'),
                'abg1_uv_power_4'=>$this->input->post('abg1_uv_power_4'),
                'abg1_uv_speed_4'=>$this->input->post('abg1_uv_speed_4'),
                'abg1_uv_hours_4'=>$this->input->post('abg1_uv_hours_4'),
                'abg1_ink_usage_4'=>$this->input->post('abg1_ink_usage_4'),
                'abg1_unit_4_comment'=>$this->input->post('abg1_unit_4_comment'),

                'is_durst'=>(!empty($this->input->post('is_durst'))?1:0),
                'durst_corona'=>$this->input->post('durst_corona'),
                'print_confg'=>(!empty($this->input->post('print_confg'))?$this->input->post('print_confg'):''),
                'digital_white'=>(!empty($this->input->post('digital_white'))?$this->input->post('digital_white'):''),
                'colour_policy'=>$this->input->post('colour_policy'),
                'substrate_defination'=>$this->input->post('substrate_defination'),
                'printing_speed'=>$this->input->post('printing_speed'),
                'unwind_tension'=>$this->input->post('unwind_tension'),
                'pinning_w'=>$this->input->post('pinning_w'),
                'pinning_k'=>$this->input->post('pinning_k'),
                'durst_uv_curing_1'=>$this->input->post('durst_uv_curing_1'),
                'durst_uv_lamp_hrs_1'=>$this->input->post('durst_uv_lamp_hrs_1'),
                'durst_uv_curing_2'=>$this->input->post('durst_uv_curing_2'),
                'durst_uv_lamp_hrs_2'=>$this->input->post('durst_uv_lamp_hrs_2'),
                'nitrogen'=>(!empty($this->input->post('nitrogen'))?$this->input->post('nitrogen'):''),
                'durst_comment'=>$this->input->post('durst_comment'),
                'digital_cost_in_euro'=>$this->input->post('digital_cost_in_euro'),
                 
                'abg2_carona_1'=>$this->input->post('abg2_carona_1'),
                'abg2_ink_id_1'=>$ink_5, 
                'abg2_anilox_1'=>$this->input->post('abg2_anilox_1'),
                'abg2_applying_method_1'=>$this->input->post('abg2_applying_method_1'),
                'abg2_cylinder_teeth_1'=>$this->input->post('abg2_cylinder_teeth_1'),
                'abg2_rotary_1'=>$this->input->post('abg2_rotary_1'),
                'abg2_uv_power_1'=>$this->input->post('abg2_uv_power_1'),
                'abg2_uv_speed_1'=>$this->input->post('abg2_uv_speed_1'),
                'abg2_uv_hours_1'=>$this->input->post('abg2_uv_hours_1'),
                'abg2_ink_usage_1'=>$this->input->post('abg2_ink_usage_1'),
                'abg2_unit_1_comment'=>$this->input->post('abg2_unit_1_comment'),

                'abg2_ink_id_2'=>$ink_6, 
                'abg2_anilox_2'=>$this->input->post('abg2_anilox_2'),
                'abg2_applying_method_2'=>$this->input->post('abg2_applying_method_2'),
                'abg2_cylinder_teeth_2'=>$this->input->post('abg2_cylinder_teeth_2'),
                'abg2_rotary_2'=>$this->input->post('abg2_rotary_2'),
                'is_extended_path'=>$is_extended_path,
                'abg2_uv_power_2'=>$abg2_uv_power_2,
                'abg2_uv_speed_2'=>$abg2_uv_speed_2,
                'abg2_uv_hours_2'=>$abg2_uv_hours_2,
                'abg2_extended_uv_power_2'=>$abg2_extended_uv_power_2,
                'abg2_extended_uv_speed_2'=>$abg2_extended_uv_speed_2,
                'abg2_extended_uv_hours_2'=>$abg2_extended_uv_hours_2,
                'abg2_ink_usage_2'=>$this->input->post('abg2_ink_usage_2'),
                'abg2_unit_2_comment'=>$this->input->post('abg2_unit_2_comment'),
                             
                 
                     
              );                          

              $result=$this->common_model->update_one_active_record('springtube_printing_jobsetup_master',$data,'job_id',$this->input->post('job_id'),$this->session->userdata['logged_in']['company_id']);

              if($result){

                $result_ink =$this->insert_inks_to_jobcard($ink_1,$this->input->post('abg1_ink_usage_1'),$ink_2,$this->input->post('abg1_ink_usage_2'),$ink_3,$this->input->post('abg1_ink_usage_3'),$ink_4,$this->input->post('abg1_ink_usage_4'),$ink_5,$this->input->post('abg2_ink_usage_1'),$ink_6,$this->input->post('abg2_ink_usage_2')); 


                //$result_plates=$this->insert_plates_to_jobcard($this->input->post('order_no'),
                //$this->input->post('article_no'),$this->input->post('jobcard_no'));

              }

              if(!empty($this->input->post('approval_authority'))){

                  $record_no=$this->input->post('jobcard_no').'@@@'.$this->input->post('job_id');

                  $data=array('pending_flag'=>'1');

                  $result=$this->common_model->update_one_active_record('springtube_printing_jobsetup_master',$data,'job_id',$this->input->post('job_id'),$this->session->userdata['logged_in']['company_id']);

                  $data['followup']=$this->common_model->select_one_active_record_nonlanguage_without_archive('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$record_no);
                      if($data['followup']==FALSE){
                        $transaction_no=1;
                        $status=1;
                      }else{
                        $i=1;
                        foreach ($data['followup'] as $followup_row) {

                          $transaction_no=$followup_row->transaction_no;
                          $status=1;
                          $i++;
                        }
                        $transaction_no=$i;
                      }

                      $data=array(
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'user_id'=>$this->input->post('approval_authority'),
                        'form_id'=>'74',
                        'transaction_no'=>$transaction_no,
                        'status'=>$status,
                        'followup_date'=>date('Y-m-d'),
                        'contact_person_id'=>$this->session->userdata['logged_in']['user_id'],
                        'record_no'=>$record_no);

                      $result=$this->common_model->save('followup',$data);
                }
                 
                if($result){                  
                  $data['note']='Update Transaction Completed';
                }else{
                  $data['error']='Update Transaction Failed';
                }

                header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                $data['springtube_printing_jobsetup_master']=$this->springtube_printing_jobsetup_model->select_one_active_record('springtube_printing_jobsetup_master',$this->session->userdata['logged_in']['company_id'],'job_id',$this->input->post('job_id'));

                $data['springtube_anilox_master']=$this->common_model->select_active_drop_down('springtube_anilox_master',$this->session->userdata['logged_in']['company_id']);

                $data['springtube_cylinder_master']=$this->common_model->select_active_drop_down('springtube_cylinder_master',$this->session->userdata['logged_in']['company_id']);

                $data['springtube_printing_color_policy_master']=$this->common_model->select_active_drop_down('springtube_printing_color_policy_master',$this->session->userdata['logged_in']['company_id']); 

                $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','74');
               

                $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());



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


  function delete(){

      $data['page_name']='Production';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

              $data=array('archive'=>'1');

              $result=$this->common_model->update_one_active_record('springtube_printing_jobsetup_master',$data,'job_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

              // Removing Old data from Jobcard-------

              $springtube_printing_jobsetup_master_result=$this->springtube_printing_jobsetup_model->select_one_active_record('springtube_printing_jobsetup_master',$this->session->userdata['logged_in']['company_id'],'job_id',$this->uri->segment(3));

              foreach ($springtube_printing_jobsetup_master_result as $key => $springtube_printing_jobsetup_master_row) {

                if($springtube_printing_jobsetup_master_row->jobcard_no!=''){

                  $result=$this->common_model->delete_one_active_record('production.material_manufacturing_archive','manu_order_no',$springtube_printing_jobsetup_master_row->jobcard_no,$this->session->userdata['logged_in']['company_id']);

                  $sql_insert="INSERT INTO production.material_manufacturing_archive (`manu_order_no`, `article_no`, `alternative_article_no`, `part_list_no`, `demand_qty`, `qty_on_hand`, `original_article_no`, `parts_list_flag`, `supplier_no`, `manufacturer_id`, `semi_manu_flag`, `company_id`,`archive`, `work_proc_no`, `from_job_card`, `mm_qty_use`, `mm_scrap_qty`, `procedures_completed`, `procedures_remaining`, `start_date`, `start_time`, `layer_no`, `stop_date`, `stop_time`, `operator_id`, `production_type`, `rel_demand_qty`, `flag_uom_type`, `rel_uom_id`, `mm_id`, `release_no`, `part_pos_no`, `club_mpw_pos_nos`, `completed_flag`, `calculated_purchase_price`, `req_purging_std_qty`, `req_purging_rel_qty`, `from_printing_jobsetup`) SELECT * FROM neo. material_manufacturing where from_printing_jobsetup ='1' AND manu_order_no='".$springtube_printing_jobsetup_master_row->jobcard_no."'";
                  
                  $query1=$this->db->query($sql_insert); 

                  //$query1->result();
                  $data=array('job_setup_id'=>$springtube_printing_jobsetup_master_row->job_id);

                  $result=$this->common_model->update_one_active_record('production.material_manufacturing_archive',$data,'manu_order_no',$springtube_printing_jobsetup_master_row->jobcard_no,$this->session->userdata['logged_in']['company_id']);

                  $sql_delete="DELETE FROM neo.material_manufacturing WHERE from_printing_jobsetup ='1' AND manu_order_no='".$springtube_printing_jobsetup_master_row->jobcard_no."'";

                  $query2=$this->db->query($sql_delete);
                  //$query2->result();


                }
                
              }


                  $data['springtube_printing_jobsetup_master']=$this->springtube_printing_jobsetup_model->select_one_inactive_record('springtube_printing_jobsetup_master',$this->session->userdata['logged_in']['company_id'],'job_id',$this->uri->segment(3));

                  $data['springtube_anilox_master']=$this->common_model->select_active_drop_down('springtube_anilox_master',$this->session->userdata['logged_in']['company_id']);
                  $data['springtube_cylinder_master']=$this->common_model->select_active_drop_down('springtube_cylinder_master',$this->session->userdata['logged_in']['company_id']);
                  $data['springtube_printing_color_policy_master']=$this->common_model->select_active_drop_down('springtube_printing_color_policy_master',$this->session->userdata['logged_in']['company_id']);        


                                   
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


    function dearchive(){
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->dearchive==1){

              $data=array('archive'=>'0','pending_flag'=>0,'final_approval_flag'=>0);

              $result=$this->common_model->update_one_active_record('springtube_printing_jobsetup_master',$data,'job_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);
             

              $data['springtube_printing_jobsetup_master']=$this->springtube_printing_jobsetup_model->select_one_active_record('springtube_printing_jobsetup_master',$this->session->userdata['logged_in']['company_id'],'job_id',$this->uri->segment(3));

              $data['springtube_anilox_master']=$this->common_model->select_active_drop_down('springtube_anilox_master',$this->session->userdata['logged_in']['company_id']);
                $data['springtube_cylinder_master']=$this->common_model->select_active_drop_down('springtube_cylinder_master',$this->session->userdata['logged_in']['company_id']);
                $data['springtube_printing_color_policy_master']=$this->common_model->select_active_drop_down('springtube_printing_color_policy_master',$this->session->userdata['logged_in']['company_id']);        


              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

                 

                  $data['note']='Dearchive Transaction completed';
                  header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
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
    }else{
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

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->delete==1){

             $table='springtube_printing_jobsetup_master';
            include('pagination.php');
            $data['springtube_printing_jobsetup_master']=$this->springtube_printing_jobsetup_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

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

            $data['springtube_anilox_master']=$this->common_model->select_active_drop_down('springtube_anilox_master',$this->session->userdata['logged_in']['company_id']);
            $data['springtube_cylinder_master']=$this->common_model->select_active_drop_down('springtube_cylinder_master',$this->session->userdata['logged_in']['company_id']);
            $data['springtube_printing_color_policy_master']=$this->common_model->select_active_drop_down('springtube_printing_color_policy_master',$this->session->userdata['logged_in']['company_id']);

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
            $this->form_validation->set_rules('order_no','order_no' ,'trim|xss_clean');
            $this->form_validation->set_rules('article_no','Article No.' ,'trim|xss_clean');              
            $this->form_validation->set_rules('jobcard_no','jobcard_no' ,'trim|xss_clean');


            if($this->form_validation->run()==FALSE){

              $data['springtube_anilox_master']=$this->common_model->select_active_drop_down('springtube_anilox_master',$this->session->userdata['logged_in']['company_id']);
              $data['springtube_cylinder_master']=$this->common_model->select_active_drop_down('springtube_cylinder_master',$this->session->userdata['logged_in']['company_id']);
              $data['springtube_printing_color_policy_master']=$this->common_model->select_active_drop_down('springtube_printing_color_policy_master',$this->session->userdata['logged_in']['company_id']);        
 
               
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                $this->load->view('Home/footer');
            }else{

              $article_no='';
              if($this->input->post('article_no')!=''){
                //$arr=$this->input->post('article_no');
                $arr=explode("//",$this->input->post('article_no'));
                $article_no=$arr[1];
              }
                  
               
              $data=array(                    
                 
                'order_no'=>$this->input->post('order_no'),
                'article_no'=>$article_no,
                'jobcard_no'=>$this->input->post('jobcard_no') 
                     
              );

              $data['springtube_printing_jobsetup_master']=$this->springtube_printing_jobsetup_model->active_record_search('springtube_printing_jobsetup_master',$data,$this->common_model->change_date_format($this->input->post('from_date'),$this->session->userdata['logged_in']['company_id']),$this->common_model->change_date_format($this->input->post('to_date'),$this->session->userdata['logged_in']['company_id']),$this->session->userdata['logged_in']['company_id']);
                //$this->db->last_query();
                 
              if($data['springtube_printing_jobsetup_master']!=FALSE){

                  $data['springtube_anilox_master']=$this->common_model->select_active_drop_down('springtube_anilox_master',$this->session->userdata['logged_in']['company_id']);
                  $data['springtube_cylinder_master']=$this->common_model->select_active_drop_down('springtube_cylinder_master',$this->session->userdata['logged_in']['company_id']);
                  $data['springtube_printing_color_policy_master']=$this->common_model->select_active_drop_down('springtube_printing_color_policy_master',$this->session->userdata['logged_in']['company_id']);        



                    $data['page_name']='Production';
                    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                    $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

                    $this->load->view('Home/header');
                    $this->load->view('Home/nav',$data);
                    $this->load->view('Home/subnav');
                    $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                    //$this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                    $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
                    $this->load->view('Home/footer');
                }else{
                      $data['page_name']='Production';
                      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                      $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

                      $data['springtube_anilox_master']=$this->common_model->select_active_drop_down('springtube_anilox_master',$this->session->userdata['logged_in']['company_id']);
                      $data['springtube_cylinder_master']=$this->common_model->select_active_drop_down('springtube_cylinder_master',$this->session->userdata['logged_in']['company_id']);
                      $data['springtube_printing_color_policy_master']=$this->common_model->select_active_drop_down('springtube_printing_color_policy_master',$this->session->userdata['logged_in']['company_id']);        

                    

                      $data['note']='No record in search transaction';
                      $this->load->view('Home/header');
                      $this->load->view('Home/nav',$data);
                      $this->load->view('Home/subnav');
                      $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                      $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                      $this->load->view('Home/footer');
                  }                
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
    function copy(){
    
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){

            $data['springtube_printing_jobsetup_master']=$this->springtube_printing_jobsetup_model->select_one_active_record('springtube_printing_jobsetup_master',$this->session->userdata['logged_in']['company_id'],'job_id',$this->uri->segment(3));
            // echo'<pre>';
            // print_r($data['springtube_printing_jobsetup_master']);
            // echo'</pre>';

            $data['springtube_anilox_master']=$this->common_model->select_active_drop_down('springtube_anilox_master',$this->session->userdata['logged_in']['company_id']);
            $data['springtube_cylinder_master']=$this->common_model->select_active_drop_down('springtube_cylinder_master',$this->session->userdata['logged_in']['company_id']);
            $data['springtube_printing_color_policy_master']=$this->common_model->select_active_drop_down('springtube_printing_color_policy_master',$this->session->userdata['logged_in']['company_id']); 

            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','74');


              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/copy-form',$data);
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
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  
  }

  function save_copy(){
  //Eknath
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {

          if($formrights_row->new==1){

            $this->form_validation->set_rules('order_no','Order No' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('article_no','Article No' ,'required|trim|xss_clean');
            //$this->form_validation->set_rules('jobcard_no','Jobcard No' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('jobcard_no','Jobcard No' ,'required|trim|xss_clean|is_unique[springtube_printing_jobsetup_master.jobcard_no]');
            $this->form_validation->set_rules('approval_authority','Approval Authority' ,'required|trim|xss_clean');

            // ABG-1 FLEXO UNIT-1 
            if($this->input->post('abg1_ink_id_1')!=''){
                $str='ABG-1 FLOXO UNIT-1 ';
                $this->form_validation->set_rules('abg1_carona_1', $str.'Corona' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_ink_id_1',$str.'Color/Ink name' ,'required|trim|xss_clean|callback_ink_check');                
                $this->form_validation->set_rules('abg1_anilox_1',$str.'Anilox' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_applying_method_1',$str.'Applying Method' ,'required|trim|xss_clean');                
                $this->form_validation->set_rules('abg1_cylinder_teeth_1',$str.'Cylinder Teeth' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_rotary_1',$str.'Semi/Full Rotary' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_uv_power_1',$str.'UV Power' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_uv_speed_1',$str.'UV Speed' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_uv_hours_1',$str.'UV Lamp Hours' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_ink_usage_1',$str.'Total Ink Consumption (Grams)' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_unit_1_comment',$str.'Comment' ,'trim|xss_clean|max_length[225]');
            }

            // ABG-1 FLEXO UNIT-2 
            if($this->input->post('abg1_ink_id_2')!=''){
                $str='ABG-1 FLOXO UNIT-2 ';
                //$this->form_validation->set_rules('abg1_carona_2', $str.'Corona' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_ink_id_2',$str.'Color/Ink name' ,'required|trim|xss_clean|callback_ink_check');                
                $this->form_validation->set_rules('abg1_anilox_2',$str.'Anilox' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_applying_method_2',$str.'Applying Method' ,'required|trim|xss_clean');                
                $this->form_validation->set_rules('abg1_cylinder_teeth_2',$str.'Cylinder Teeth' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_rotary_2',$str.'Semi/Full Rotary' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_uv_power_2',$str.'UV Power' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_uv_speed_2',$str.'UV Speed' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_uv_hours_2',$str.'UV Lamp Hours' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_ink_usage_2',$str.'Total Ink Consumption (Grams)' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_unit_2_comment',$str.'Comment' ,'trim|xss_clean|max_length[225]');
            }

            // ABG-1 FLEXO UNIT-3 
            if($this->input->post('abg1_ink_id_3')!=''){
                $str='ABG-1 FLOXO UNIT-3 ';
                //$this->form_validation->set_rules('abg1_carona_2', $str.'Corona' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_ink_id_3',$str.'Color/Ink name' ,'required|trim|xss_clean|callback_ink_check');                
                $this->form_validation->set_rules('abg1_anilox_3',$str.'Anilox' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_applying_method_3',$str.'Applying Method' ,'required|trim|xss_clean');                
                $this->form_validation->set_rules('abg1_cylinder_teeth_3',$str.'Cylinder Teeth' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_rotary_3',$str.'Semi/Full Rotary' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_uv_power_3',$str.'UV Power' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_uv_speed_3',$str.'UV Speed' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_uv_hours_3',$str.'UV Lamp Hours' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_ink_usage_3',$str.'Total Ink Consumption (Grams)' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_unit_3_comment',$str.'Comment' ,'trim|xss_clean|max_length[225]');
            }

            // ABG-1 FLEXO UNIT-2 
            if($this->input->post('abg1_ink_id_4')!=''){
                $str='ABG-1 FLOXO UNIT-4 ';
                //$this->form_validation->set_rules('abg1_carona_2', $str.'Corona' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_ink_id_4',$str.'Color/Ink name' ,'required|trim|xss_clean|callback_ink_check');                
                $this->form_validation->set_rules('abg1_anilox_4',$str.'Anilox' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_applying_method_4',$str.'Applying Method' ,'required|trim|xss_clean');                
                $this->form_validation->set_rules('abg1_cylinder_teeth_4',$str.'Cylinder Teeth' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_rotary_4',$str.'Semi/Full Rotary' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_uv_power_4',$str.'UV Power' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_uv_speed_4',$str.'UV Speed' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_uv_hours_4',$str.'UV Lamp Hours' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_ink_usage_4',$str.'Total Ink Consumption (Grams)' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg1_unit_4_comment',$str.'Comment' ,'trim|xss_clean|max_length[225]');
            }

            //DURST-------------------------
            if($this->input->post('is_durst')=='1'){

              $durst='DURST ';
              $this->form_validation->set_rules('durst_corona',$durst.'Corona' ,'trim|xss_clean');
              $this->form_validation->set_rules('print_confg',$durst.'Print Configuration' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('digital_white',$durst.'Digital White In Use' ,'required|trim|xss_clean');

              if($this->input->post('digital_white')=='YES'){

                $this->form_validation->set_rules('pinning_w',$durst.'Pinning W','required|trim|xss_clean');
              }else{

                $this->form_validation->set_rules('pinning_w',$durst.'Pinning W','trim|xss_clean');

              }
              $this->form_validation->set_rules('colour_policy',$durst.'Colour Policy' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('substrate_defination',$durst.'Substrate Defination','required|trim|xss_clean');
              $this->form_validation->set_rules('printing_speed',$durst.'Printing Speed','required|trim|xss_clean');
              $this->form_validation->set_rules('unwind_tension',$durst.'Tension','required|trim|xss_clean');
              //$this->form_validation->set_rules('pinning_w',$durst.'Pinning W','required|trim|xss_clean');
              $this->form_validation->set_rules('pinning_k',$durst.'Pinning K','required|trim|xss_clean');
              $this->form_validation->set_rules('durst_uv_curing_1',$durst.'UV Curing-1','required|trim|xss_clean');
              $this->form_validation->set_rules('durst_uv_lamp_hrs_1',$durst.'Lamp 1 Hours','required|trim|xss_clean');
              $this->form_validation->set_rules('durst_uv_curing_2',$durst.'UV Curing-2','required|trim|xss_clean');
              $this->form_validation->set_rules('durst_uv_lamp_hrs_2',$durst.'Lamp 2 Hours','required|trim|xss_clean');
              $this->form_validation->set_rules('nitrogen',$durst.'Nitrogen Used','required|trim|xss_clean');
              $this->form_validation->set_rules('digital_cost_in_euro',$durst.'Digital Cost In Euro','required|trim|xss_clean');
              $this->form_validation->set_rules('durst_comment',$durst.'Comment','trim|xss_clean');
            }

            // ABG-2 FLEXO UNIT-1 ------------------------------
            if($this->input->post('abg2_ink_id_1')!=''){
                $str='ABG-2 FLOXO UNIT-1 ';
                $this->form_validation->set_rules('abg2_carona_1', $str.'Corona' ,'trim|xss_clean');
                $this->form_validation->set_rules('abg2_ink_id_1',$str.'Color/Ink name' ,'required|trim|xss_clean|callback_ink_check');                
                $this->form_validation->set_rules('abg2_anilox_1',$str.'Anilox' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg2_applying_method_1',$str.'Applying Method' ,'required|trim|xss_clean');                
                $this->form_validation->set_rules('abg2_cylinder_teeth_1',$str.'Cylinder Teeth' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg2_rotary_1',$str.'Semi/Full Rotary' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg2_uv_power_1',$str.'UV Power' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg2_uv_speed_1',$str.'UV Speed' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg2_uv_hours_1',$str.'UV Lamp Hours' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg2_ink_usage_1',$str.'Total Ink Consumption (Grams)' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg2_unit_1_comment',$str.'Comment' ,'trim|xss_clean|max_length[225]');
            }

            // ABG-2 FLEXO UNIT-2------------------------- 
            if($this->input->post('abg2_ink_id_2')!=''){
                $str='ABG-2 FLOXO UNIT-2 ';
                //$this->form_validation->set_rules('abg1_carona_2', $str.'Corona' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg2_ink_id_2',$str.'Color/Ink name' ,'required|trim|xss_clean|callback_ink_check');                
                $this->form_validation->set_rules('abg2_anilox_2',$str.'Anilox' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg2_applying_method_2',$str.'Applying Method' ,'required|trim|xss_clean');                
                $this->form_validation->set_rules('abg2_cylinder_teeth_2',$str.'Cylinder Teeth' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg2_rotary_2',$str.'Semi/Full Rotary' ,'required|trim|xss_clean');

                $this->form_validation->set_rules('is_extended_path',$str.'Extended Web Path' ,'required|trim|xss_clean');

                if($this->input->post('is_extended_path')=='YES'){                  
                  $this->form_validation->set_rules('abg2_extended_uv_power_2',$str.'Extended UV Power' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg2_extended_uv_speed_2',$str.'Extended UV Speed' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg2_extended_uv_hours_2',$str.'Extended UV Lamp Hours' ,'required|trim|xss_clean');
                }else{
                  $this->form_validation->set_rules('abg2_uv_power_2',$str.'UV Power' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg2_uv_speed_2',$str.'UV Speed' ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('abg2_uv_hours_2',$str.'UV Lamp Hours' ,'required|trim|xss_clean');
                }

                $this->form_validation->set_rules('abg2_ink_usage_2',$str.'Total Ink Consumption (Grams)' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('abg2_unit_2_comment',$str.'Comment' ,'trim|xss_clean|max_length[225]');
            } 
              
            

            if($this->form_validation->run()==FALSE){

              $data['springtube_printing_jobsetup_master']=$this->springtube_printing_jobsetup_model->select_one_active_record('springtube_printing_jobsetup_master',$this->session->userdata['logged_in']['company_id'],'job_id',$this->input->post('job_id'));
              
              $data['springtube_anilox_master']=$this->common_model->select_active_drop_down('springtube_anilox_master',$this->session->userdata['logged_in']['company_id']);
              $data['springtube_cylinder_master']=$this->common_model->select_active_drop_down('springtube_cylinder_master',$this->session->userdata['logged_in']['company_id']); 
              $data['springtube_printing_color_policy_master']=$this->common_model->select_active_drop_down('springtube_printing_color_policy_master',$this->session->userdata['logged_in']['company_id']);

              $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','74');        
       
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/copy-form',$data);
              $this->load->view('Home/footer');
            }else{

              $ink_1='';
              $ink_1_consum=0;
              if($this->input->post('abg1_ink_id_1')!=''){
                $ink_1_arr=explode("//",$this->input->post('abg1_ink_id_1'));
                $ink_1=$ink_1_arr[1];
              }
              $ink_2='';
              if($this->input->post('abg1_ink_id_2')!=''){
                $ink_2_arr=explode("//",$this->input->post('abg1_ink_id_2'));
                $ink_2=$ink_2_arr[1];
              }
              $ink_3='';
              if($this->input->post('abg1_ink_id_3')!=''){
                $ink_3_arr=explode("//",$this->input->post('abg1_ink_id_3'));
                $ink_3=$ink_3_arr[1];
              }
              $ink_4='';
              if($this->input->post('abg1_ink_id_4')!=''){
                $ink_4_arr=explode("//",$this->input->post('abg1_ink_id_4'));
                $ink_4=$ink_4_arr[1];
              }
              $ink_5='';
              if($this->input->post('abg2_ink_id_1')!=''){
                $ink_5_arr=explode("//",$this->input->post('abg2_ink_id_1'));
                $ink_5=$ink_5_arr[1];
              }
              $ink_6='';
              if($this->input->post('abg2_ink_id_2')!=''){
                $ink_6_arr=explode("//",$this->input->post('abg2_ink_id_2'));
                $ink_6=$ink_6_arr[1];
              }

              $is_extended_path='';
              $abg2_uv_power_2= '';
              $abg2_uv_speed_2='';
              $abg2_uv_hours_2='';

              $abg2_extended_uv_power_2='';
              $abg2_extended_uv_speed_2='';
              $abg2_extended_uv_hours_2='';

              if(!empty($this->input->post('is_extended_path'))){

                $is_extended_path=$this->input->post('is_extended_path');

                if($this->input->post('is_extended_path')=='YES'){
                  $abg2_extended_uv_power_2=$this->input->post('abg2_extended_uv_power_2');
                  $abg2_extended_uv_speed_2=$this->input->post('abg2_extended_uv_speed_2');
                  $abg2_extended_uv_hours_2=$this->input->post('abg2_extended_uv_hours_2');

                }else{
                  $abg2_uv_power_2=$this->input->post('abg2_uv_power_2');
                  $abg2_uv_speed_2=$this->input->post('abg2_uv_speed_2');
                  $abg2_uv_hours_2=$this->input->post('abg2_uv_hours_2');
                }

              }             
              
              $data=array(                    
                'jobsetup_date'=>date('Y-m-d'),
                'jobcard_no'=>$this->input->post('jobcard_no'),
                'order_no'=>$this->input->post('order_no'),
                'article_no'=>$this->input->post('article_no'),

                'abg1_carona_1'=>$this->input->post('abg1_carona_1'),
                'abg1_ink_id_1'=>$ink_1, 
                'abg1_anilox_1'=>$this->input->post('abg1_anilox_1'),
                'abg1_applying_method_1'=>$this->input->post('abg1_applying_method_1'),
                'abg1_cylinder_teeth_1'=>$this->input->post('abg1_cylinder_teeth_1'),
                'abg1_rotary_1'=>$this->input->post('abg1_rotary_1'),
                'abg1_uv_power_1'=>$this->input->post('abg1_uv_power_1'),
                'abg1_uv_speed_1'=>$this->input->post('abg1_uv_speed_1'),
                'abg1_uv_hours_1'=>$this->input->post('abg1_uv_hours_1'),
                'abg1_ink_usage_1'=>$this->input->post('abg1_ink_usage_1'),
                'abg1_unit_1_comment'=>$this->input->post('abg1_unit_1_comment'),

                'abg1_ink_id_2'=>$ink_2, 
                'abg1_anilox_2'=>$this->input->post('abg1_anilox_2'),
                'abg1_applying_method_2'=>$this->input->post('abg1_applying_method_2'),
                'abg1_cylinder_teeth_2'=>$this->input->post('abg1_cylinder_teeth_2'),
                'abg1_rotary_2'=>$this->input->post('abg1_rotary_2'),
                'abg1_uv_power_2'=>$this->input->post('abg1_uv_power_2'),
                'abg1_uv_speed_2'=>$this->input->post('abg1_uv_speed_2'),
                'abg1_uv_hours_2'=>$this->input->post('abg1_uv_hours_2'),
                'abg1_ink_usage_2'=>$this->input->post('abg1_ink_usage_2'),
                'abg1_unit_2_comment'=>$this->input->post('abg1_unit_2_comment'),

                'abg1_ink_id_3'=>$ink_3, 
                'abg1_anilox_3'=>$this->input->post('abg1_anilox_3'),
                'abg1_applying_method_3'=>$this->input->post('abg1_applying_method_3'),
                'abg1_cylinder_teeth_3'=>$this->input->post('abg1_cylinder_teeth_3'),
                'abg1_rotary_3'=>$this->input->post('abg1_rotary_3'),
                'abg1_uv_power_3'=>$this->input->post('abg1_uv_power_3'),
                'abg1_uv_speed_3'=>$this->input->post('abg1_uv_speed_3'),
                'abg1_uv_hours_3'=>$this->input->post('abg1_uv_hours_3'),
                'abg1_ink_usage_3'=>$this->input->post('abg1_ink_usage_3'),
                'abg1_unit_3_comment'=>$this->input->post('abg1_unit_3_comment'),

                'abg1_ink_id_4'=>$ink_4, 
                'abg1_anilox_4'=>$this->input->post('abg1_anilox_4'),
                'abg1_applying_method_4'=>$this->input->post('abg1_applying_method_4'),
                'abg1_cylinder_teeth_4'=>$this->input->post('abg1_cylinder_teeth_4'),
                'abg1_rotary_4'=>$this->input->post('abg1_rotary_4'),
                'abg1_uv_power_4'=>$this->input->post('abg1_uv_power_4'),
                'abg1_uv_speed_4'=>$this->input->post('abg1_uv_speed_4'),
                'abg1_uv_hours_4'=>$this->input->post('abg1_uv_hours_4'),
                'abg1_ink_usage_4'=>$this->input->post('abg1_ink_usage_4'),
                'abg1_unit_4_comment'=>$this->input->post('abg1_unit_4_comment'),

                'is_durst'=>(!empty($this->input->post('is_durst'))?1:0),
                'durst_corona'=>$this->input->post('durst_corona'),
                'print_confg'=>(!empty($this->input->post('print_confg'))?$this->input->post('print_confg'):''),
                'digital_white'=>(!empty($this->input->post('digital_white'))?$this->input->post('digital_white'):''),
                'colour_policy'=>$this->input->post('colour_policy'),
                'substrate_defination'=>$this->input->post('substrate_defination'),
                'printing_speed'=>$this->input->post('printing_speed'),
                'unwind_tension'=>$this->input->post('unwind_tension'),
                'pinning_w'=>$this->input->post('pinning_w'),
                'pinning_k'=>$this->input->post('pinning_k'),
                'durst_uv_curing_1'=>$this->input->post('durst_uv_curing_1'),
                'durst_uv_lamp_hrs_1'=>$this->input->post('durst_uv_lamp_hrs_1'),
                'durst_uv_curing_2'=>$this->input->post('durst_uv_curing_2'),
                'durst_uv_lamp_hrs_2'=>$this->input->post('durst_uv_lamp_hrs_2'),
                'nitrogen'=>(!empty($this->input->post('nitrogen'))?$this->input->post('nitrogen'):''),
                'durst_comment'=>$this->input->post('durst_comment'),
                'digital_cost_in_euro'=>$this->input->post('digital_cost_in_euro'),
                 
                'abg2_carona_1'=>$this->input->post('abg2_carona_1'),
                'abg2_ink_id_1'=>$ink_5, 
                'abg2_anilox_1'=>$this->input->post('abg2_anilox_1'),
                'abg2_applying_method_1'=>$this->input->post('abg2_applying_method_1'),
                'abg2_cylinder_teeth_1'=>$this->input->post('abg2_cylinder_teeth_1'),
                'abg2_rotary_1'=>$this->input->post('abg2_rotary_1'),
                'abg2_uv_power_1'=>$this->input->post('abg2_uv_power_1'),
                'abg2_uv_speed_1'=>$this->input->post('abg2_uv_speed_1'),
                'abg2_uv_hours_1'=>$this->input->post('abg2_uv_hours_1'),
                'abg2_ink_usage_1'=>$this->input->post('abg2_ink_usage_1'),
                'abg2_unit_1_comment'=>$this->input->post('abg2_unit_1_comment'),

                'abg2_ink_id_2'=>$ink_6, 
                'abg2_anilox_2'=>$this->input->post('abg2_anilox_2'),
                'abg2_applying_method_2'=>$this->input->post('abg2_applying_method_2'),
                'abg2_cylinder_teeth_2'=>$this->input->post('abg2_cylinder_teeth_2'),
                'abg2_rotary_2'=>$this->input->post('abg2_rotary_2'),
                'is_extended_path'=>$is_extended_path,
                'abg2_uv_power_2'=>$abg2_uv_power_2,
                'abg2_uv_speed_2'=>$abg2_uv_speed_2,
                'abg2_uv_hours_2'=>$abg2_uv_hours_2,
                'abg2_extended_uv_power_2'=>$abg2_extended_uv_power_2,
                'abg2_extended_uv_speed_2'=>$abg2_extended_uv_speed_2,
                'abg2_extended_uv_hours_2'=>$abg2_extended_uv_hours_2,
                'abg2_ink_usage_2'=>$this->input->post('abg2_ink_usage_2'),
                'abg2_unit_2_comment'=>$this->input->post('abg2_unit_2_comment'),
                'user_id'=>$this->session->userdata['logged_in']['user_id'],
                'company_id'=>$this->session->userdata['logged_in']['company_id']
                 
                     
              );

              $job_id=$this->common_model->save_return_pkey('springtube_printing_jobsetup_master',$data); 


              if($job_id){

                $result_ink =$this->insert_inks_to_jobcard($ink_1,$this->input->post('abg1_ink_usage_1'),$ink_2,$this->input->post('abg1_ink_usage_2'),$ink_3,$this->input->post('abg1_ink_usage_3'),$ink_4,$this->input->post('abg1_ink_usage_4'),$ink_5,$this->input->post('abg2_ink_usage_1'),$ink_6,$this->input->post('abg2_ink_usage_2')); 


                //$result_plates=$this->insert_plates_to_jobcard($this->input->post('order_no'),
                //$this->input->post('article_no'),$this->input->post('jobcard_no'));


                if(!empty($this->input->post('approval_authority'))){

                  $record_no=$this->input->post('jobcard_no').'@@@'.$job_id;

                  $data=array('pending_flag'=>'1');
                  $result=$this->common_model->update_one_active_record('springtube_printing_jobsetup_master',$data,'job_id',$job_id,$this->session->userdata['logged_in']['company_id']);

                  $data['followup']=$this->common_model->select_one_active_record_nonlanguage_without_archive('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$record_no);
                  if($data['followup']==FALSE){
                        $transaction_no=1;
                        $status=1;
                  }else{
                        $i=1;
                        foreach ($data['followup'] as $followup_row) {
                          $transaction_no=$followup_row->transaction_no;
                          $status=1;
                          $i++;
                        }
                        $transaction_no=$i;
                  }

                  $data=array(
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'user_id'=>$this->input->post('approval_authority'),
                        'form_id'=>'74',
                        'transaction_no'=>$transaction_no,
                        'status'=>$status,
                        'followup_date'=>date('Y-m-d'),
                        'contact_person_id'=>$this->session->userdata['logged_in']['user_id'],
                        'record_no'=>$record_no,
                        );

                    $result=$this->common_model->save('followup',$data);
                }


                if($result_ink){
                  $data['note']='Ink Save Transaction Completed';

                }else{                  
                  $data['error']='Ink Save Transaction failed';
                }

                if($result_plates){

                  $data['note']='Flexo plates Save Transaction Completed';

                }else{                  
                  $data['error']='No Flexo plates available';
                }

                $data['note']='Create Transaction Completed';

              }else{
                $data['error']='Create Transaction failed';
              }
               

              header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $data['springtube_printing_jobsetup_master']=$this->springtube_printing_jobsetup_model->select_one_active_record('springtube_printing_jobsetup_master',$this->session->userdata['logged_in']['company_id'],'job_id',$job_id); 
               
              $data['springtube_anilox_master']=$this->common_model->select_active_drop_down('springtube_anilox_master',$this->session->userdata['logged_in']['company_id']);
              $data['springtube_cylinder_master']=$this->common_model->select_active_drop_down('springtube_cylinder_master',$this->session->userdata['logged_in']['company_id']);
              $data['springtube_printing_color_policy_master']=$this->common_model->select_active_drop_down('springtube_printing_color_policy_master',$this->session->userdata['logged_in']['company_id']); 

              $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','74');       


              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/copy-form',$data);
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

            $data['springtube_printing_jobsetup_master']=$this->springtube_printing_jobsetup_model->select_one_active_record('springtube_printing_jobsetup_master',$this->session->userdata['logged_in']['company_id'],'job_id',$this->uri->segment(3));

            $jobcard_no='';
            foreach ($data['springtube_printing_jobsetup_master'] as $key => $row) {
              $jobcard_no=$row->jobcard_no;
            }


            $data['followup']=$this->common_model->select_followup_records('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$jobcard_no.'@@@'.$this->uri->segment(3));
           
             
            
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

  function ink_check($str){

    if(!empty($str)){

      $ink_arr=explode('//',$str);

      if(!empty($ink_arr[1])){

        $data['springtube_ink_master']=$this->common_model->select_one_active_record('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],'ink_id',$ink_arr[1]);
        //echo $this->db->last_query();

        foreach ($data['springtube_ink_master'] as $row) {
          
          if ($row->ink_desc == $ink_arr[0]){
            return TRUE;
          }else{
            $this->form_validation->set_message('ink_check', 'The {field} field is incorrect');
            return FALSE;
          }
        } 
      }else{
          $this->form_validation->set_message('ink_check', 'The {field} field is incorrect');
          return FALSE;
      }

    }

  }

  //  function jobcard_check($jobcard_no){

  //   if(!empty($str)){

  //     $count=0;

  //     $count=$this->common_model->active_record_count_where_pkey('springtube_printing_jobsetup_master',$this->session->userdata['logged_in']['company_id'],'jobcard_no',$jobcard_no);
  //       //echo $this->db->last_query();               
  //         if($count>0){
  //           
  //           $this->form_validation->set_message('jobcard_check', 'The {field} field is incorrect');
  //           return FALSE;
  //         }else{
              //return TRUE;
            
  //         }
     
       
  //   }

  // }

  function insert_inks_to_jobcard($ink_1,$ink_1_consum,$ink_2,$ink_2_consum,$ink_3,$ink_3_consum,$ink_4,$ink_4_consum,$ink_5,$ink_5_consum,$ink_6,$ink_6_consum){

    $part_pos_no=0;
    $data['part_pos_no']=$this->common_model->select_max_pkey_where('material_manufacturing','part_pos_no','manu_order_no',$this->input->post('jobcard_no'),$this->session->userdata['logged_in']['company_id']);

    foreach($data['part_pos_no'] as $part_pos_no_row){
      $part_pos_no=$part_pos_no_row->part_pos_no+1;
    }

    if($ink_1!=''){

      $ink_1_qty_gram=$ink_1_consum;
      $ink_1_qty_kg=round(($ink_1_consum/1000),2);
      $ink_1_result=$this->springtube_ink_master_model->select_one_active_record('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],'ink_id',$ink_1);

      foreach ($ink_1_result as $ink_1_row) {

        if($ink_1_row->ink_composition==1){

          $work_proc_no=($ink_1_row->ink_category=='GLUE'?6:3);                    

          $data['max_mm']=$this->common_model->select_max_pkey_numeric('material_manufacturing','mm_id',$this->session->userdata['logged_in']['company_id']);
                foreach($data['max_mm'] as $max_mm_row){
                  $mm_id=$max_mm_row->mm_id+1;
                }

                $data=array(
                  'manu_order_no'=>$this->input->post('jobcard_no'),
                  'article_no'=>$ink_1_row->article_no,
                  'demand_qty'=>$this->common_model->save_number($ink_1_qty_kg,$this->session->userdata['logged_in']['company_id']),
                  'company_id'=>$this->session->userdata['logged_in']['company_id'],
                  'work_proc_no'=>$work_proc_no,
                  'from_job_card'=>'1',
                  'rel_demand_qty'=>$this->common_model->save_number($ink_1_qty_kg*1000,$this->session->userdata['logged_in']['company_id']),
                  'flag_uom_type'=>'1',
                  'mm_id'=>$mm_id,
                  'rel_uom_id'=>'9',
                  'from_printing_jobsetup'=>'1',
                  'part_pos_no'=>$part_pos_no++
                );

                $result=$this->common_model->save('material_manufacturing',$data);
        }else{

          $ink_1_mixing_master_result=$this->springtube_ink_mixing_model->select_one_active_record('springtube_ink_mixing_master',$this->session->userdata['logged_in']['company_id'],'springtube_ink_mixing_master.ink_id',$ink_1);
          foreach ($ink_1_mixing_master_result as $ink_1_mixing_master_row) {
            
            $data_mixing_1=array('mixing_id'=>$ink_1_mixing_master_row->mixing_id);

            $ink_1_mixing_details_result=$this->springtube_ink_mixing_model->active_details_records('springtube_ink_mixing_details',$data_mixing_1,$this->session->userdata['logged_in']['company_id']);

            foreach ($ink_1_mixing_details_result as $ink_1_mixing_details_row) {
              
              $data['max_mm']=$this->common_model->select_max_pkey_numeric('material_manufacturing','mm_id',$this->session->userdata['logged_in']['company_id']);
                foreach($data['max_mm'] as $max_mm_row){
                  $mm_id=$max_mm_row->mm_id+1;
                }

                $ink_rm_qty_gram=($ink_1_qty_gram*($ink_1_mixing_details_row->ink_perc/100));
                $ink_rm_qty_kg=$ink_rm_qty_gram/1000;
                $data=array(
                  'manu_order_no'=>$this->input->post('jobcard_no'),
                  'article_no'=>$ink_1_mixing_details_row->article_no,
                  'demand_qty'=>$this->common_model->save_number($ink_rm_qty_kg,$this->session->userdata['logged_in']['company_id']),
                  'company_id'=>$this->session->userdata['logged_in']['company_id'],
                  'work_proc_no'=>'3',
                  'from_job_card'=>'1',
                  'rel_demand_qty'=>$this->common_model->save_number($ink_rm_qty_kg*1000,$this->session->userdata['logged_in']['company_id']),
                  'flag_uom_type'=>'1',
                  'mm_id'=>$mm_id,
                  'rel_uom_id'=>'9',
                  'from_printing_jobsetup'=>'1',
                  'part_pos_no'=>$part_pos_no++
                );

              $result=$this->common_model->save('material_manufacturing',$data);
            }
          }
        }
      }
    }//ink1

    //INK 2  ------------------------------------------------------------

    if($ink_2!=''){

      $ink_2_qty_gram=$ink_2_consum;
      $ink_2_qty_kg=round(($ink_2_consum/1000),2);
      $ink_2_result=$this->springtube_ink_master_model->select_one_active_record('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],'ink_id',$ink_2);

      foreach ($ink_2_result as $ink_2_row) {

        if($ink_2_row->ink_composition==1){ 

          $work_proc_no=($ink_2_row->ink_category=='GLUE'?6:3);                   

          $data['max_mm']=$this->common_model->select_max_pkey_numeric('material_manufacturing','mm_id',$this->session->userdata['logged_in']['company_id']);
                foreach($data['max_mm'] as $max_mm_row){
                  $mm_id=$max_mm_row->mm_id+1;
                }

                $data=array(
                  'manu_order_no'=>$this->input->post('jobcard_no'),
                  'article_no'=>$ink_2_row->article_no,
                  'demand_qty'=>$this->common_model->save_number($ink_2_qty_kg,$this->session->userdata['logged_in']['company_id']),
                  'company_id'=>$this->session->userdata['logged_in']['company_id'],
                  'work_proc_no'=>$work_proc_no,
                  'from_job_card'=>'1',
                  'rel_demand_qty'=>$this->common_model->save_number($ink_2_qty_kg*1000,$this->session->userdata['logged_in']['company_id']),
                  'flag_uom_type'=>'1',
                  'mm_id'=>$mm_id,
                  'rel_uom_id'=>'9',
                  'from_printing_jobsetup'=>'1',
                  'part_pos_no'=>$part_pos_no++
                );

                $result=$this->common_model->save('material_manufacturing',$data);
        }else{

          $ink_2_mixing_master_result=$this->springtube_ink_mixing_model->select_one_active_record('springtube_ink_mixing_master',$this->session->userdata['logged_in']['company_id'],'springtube_ink_mixing_master.ink_id',$ink_2);
          foreach ($ink_2_mixing_master_result as $ink_2_mixing_master_row) {
            
            $data_mixing_2=array('mixing_id'=>$ink_2_mixing_master_row->mixing_id);

            $ink_2_mixing_details_result=$this->springtube_ink_mixing_model->active_details_records('springtube_ink_mixing_details',$data_mixing_2,$this->session->userdata['logged_in']['company_id']);

            foreach ($ink_2_mixing_details_result as $ink_2_mixing_details_row) {
              
              $data['max_mm']=$this->common_model->select_max_pkey_numeric('material_manufacturing','mm_id',$this->session->userdata['logged_in']['company_id']);
                foreach($data['max_mm'] as $max_mm_row){
                  $mm_id=$max_mm_row->mm_id+1;
                }

                $ink_rm_qty_gram=($ink_2_qty_gram*($ink_2_mixing_details_row->ink_perc/100));
                $ink_rm_qty_kg=$ink_rm_qty_gram/1000;
                $data=array(
                  'manu_order_no'=>$this->input->post('jobcard_no'),
                  'article_no'=>$ink_2_mixing_details_row->article_no,
                  'demand_qty'=>$this->common_model->save_number($ink_rm_qty_kg,$this->session->userdata['logged_in']['company_id']),
                  'company_id'=>$this->session->userdata['logged_in']['company_id'],
                  'work_proc_no'=>'3',
                  'from_job_card'=>'1',
                  'rel_demand_qty'=>$this->common_model->save_number($ink_rm_qty_kg*1000,$this->session->userdata['logged_in']['company_id']),
                  'flag_uom_type'=>'1',
                  'mm_id'=>$mm_id,
                  'rel_uom_id'=>'9',
                  'from_printing_jobsetup'=>'1',
                  'part_pos_no'=>$part_pos_no++
                );

              $result=$this->common_model->save('material_manufacturing',$data);
            }
          }
        }
      }
    }//ink1

    //INK 3------------------------------------------------------------


    if($ink_3!=''){

      $ink_3_qty_gram=$ink_3_consum;
      $ink_3_qty_kg=round(($ink_3_consum/1000),2);
      $ink_3_result=$this->springtube_ink_master_model->select_one_active_record('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],'ink_id',$ink_3);

      foreach ($ink_3_result as $ink_3_row) {

        if($ink_3_row->ink_composition==1){ 

          $work_proc_no=($ink_3_row->ink_category=='GLUE'?6:3);                   

          $data['max_mm']=$this->common_model->select_max_pkey_numeric('material_manufacturing','mm_id',$this->session->userdata['logged_in']['company_id']);
                foreach($data['max_mm'] as $max_mm_row){
                  $mm_id=$max_mm_row->mm_id+1;
                }

                $data=array(
                  'manu_order_no'=>$this->input->post('jobcard_no'),
                  'article_no'=>$ink_3_row->article_no,
                  'demand_qty'=>$this->common_model->save_number($ink_3_qty_kg,$this->session->userdata['logged_in']['company_id']),
                  'company_id'=>$this->session->userdata['logged_in']['company_id'],
                  'work_proc_no'=>$work_proc_no,
                  'from_job_card'=>'1',
                  'rel_demand_qty'=>$this->common_model->save_number($ink_3_qty_kg*1000,$this->session->userdata['logged_in']['company_id']),
                  'flag_uom_type'=>'1',
                  'mm_id'=>$mm_id,
                  'rel_uom_id'=>'9',
                  'from_printing_jobsetup'=>'1',
                  'part_pos_no'=>$part_pos_no++
                );

                $result=$this->common_model->save('material_manufacturing',$data);
        }else{

          $ink_3_mixing_master_result=$this->springtube_ink_mixing_model->select_one_active_record('springtube_ink_mixing_master',$this->session->userdata['logged_in']['company_id'],'springtube_ink_mixing_master.ink_id',$ink_3);
          foreach ($ink_3_mixing_master_result as $ink_3_mixing_master_row) {
            
            $data_mixing_3=array('mixing_id'=>$ink_3_mixing_master_row->mixing_id);

            $ink_3_mixing_details_result=$this->springtube_ink_mixing_model->active_details_records('springtube_ink_mixing_details',$data_mixing_3,$this->session->userdata['logged_in']['company_id']);

            foreach ($ink_3_mixing_details_result as $ink_3_mixing_details_row) {
              
              $data['max_mm']=$this->common_model->select_max_pkey_numeric('material_manufacturing','mm_id',$this->session->userdata['logged_in']['company_id']);
                foreach($data['max_mm'] as $max_mm_row){
                  $mm_id=$max_mm_row->mm_id+1;
                }

                $ink_rm_qty_gram=($ink_3_qty_gram*($ink_3_mixing_details_row->ink_perc/100));
                $ink_rm_qty_kg=$ink_rm_qty_gram/1000;
                $data=array(
                  'manu_order_no'=>$this->input->post('jobcard_no'),
                  'article_no'=>$ink_3_mixing_details_row->article_no,
                  'demand_qty'=>$this->common_model->save_number($ink_rm_qty_kg,$this->session->userdata['logged_in']['company_id']),
                  'company_id'=>$this->session->userdata['logged_in']['company_id'],
                  'work_proc_no'=>'3',
                  'from_job_card'=>'1',
                  'rel_demand_qty'=>$this->common_model->save_number($ink_rm_qty_kg*1000,$this->session->userdata['logged_in']['company_id']),
                  'flag_uom_type'=>'1',
                  'mm_id'=>$mm_id,
                  'rel_uom_id'=>'9',
                  'from_printing_jobsetup'=>'1',
                  'part_pos_no'=>$part_pos_no++
                );

              $result=$this->common_model->save('material_manufacturing',$data);
            }
          }
        }
      }
    }//ink3

    //INK 4  ------------------------------------------------------------

      if($ink_4!=''){

      $ink_4_qty_gram=$ink_4_consum;
      $ink_4_qty_kg=round(($ink_4_consum/1000),2);
      $ink_4_result=$this->springtube_ink_master_model->select_one_active_record('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],'ink_id',$ink_4);

      foreach ($ink_4_result as $ink_4_row) {

        if($ink_4_row->ink_composition==1){

          $work_proc_no=($ink_4_row->ink_category=='GLUE'?6:3);                    

          $data['max_mm']=$this->common_model->select_max_pkey_numeric('material_manufacturing','mm_id',$this->session->userdata['logged_in']['company_id']);
                foreach($data['max_mm'] as $max_mm_row){
                  $mm_id=$max_mm_row->mm_id+1;
                }

                $data=array(
                  'manu_order_no'=>$this->input->post('jobcard_no'),
                  'article_no'=>$ink_4_row->article_no,
                  'demand_qty'=>$this->common_model->save_number($ink_4_qty_kg,$this->session->userdata['logged_in']['company_id']),
                  'company_id'=>$this->session->userdata['logged_in']['company_id'],
                  'work_proc_no'=>$work_proc_no,
                  'from_job_card'=>'1',
                  'rel_demand_qty'=>$this->common_model->save_number($ink_4_qty_kg*1000,$this->session->userdata['logged_in']['company_id']),
                  'flag_uom_type'=>'1',
                  'mm_id'=>$mm_id,
                  'rel_uom_id'=>'9',
                  'from_printing_jobsetup'=>'1',
                  'part_pos_no'=>$part_pos_no++
                );

                $result=$this->common_model->save('material_manufacturing',$data);
        }else{

          $ink_4_mixing_master_result=$this->springtube_ink_mixing_model->select_one_active_record('springtube_ink_mixing_master',$this->session->userdata['logged_in']['company_id'],'springtube_ink_mixing_master.ink_id',$ink_4);
          foreach ($ink_4_mixing_master_result as $ink_4_mixing_master_row) {
            
            $data_mixing_4=array('mixing_id'=>$ink_4_mixing_master_row->mixing_id);

            $ink_4_mixing_details_result=$this->springtube_ink_mixing_model->active_details_records('springtube_ink_mixing_details',$data_mixing_4,$this->session->userdata['logged_in']['company_id']);

            foreach ($ink_4_mixing_details_result as $ink_4_mixing_details_row) {
              
              $data['max_mm']=$this->common_model->select_max_pkey_numeric('material_manufacturing','mm_id',$this->session->userdata['logged_in']['company_id']);
                foreach($data['max_mm'] as $max_mm_row){
                  $mm_id=$max_mm_row->mm_id+1;
                }

                $ink_rm_qty_gram=($ink_4_qty_gram*($ink_4_mixing_details_row->ink_perc/100));
                $ink_rm_qty_kg=$ink_rm_qty_gram/1000;
                $data=array(
                  'manu_order_no'=>$this->input->post('jobcard_no'),
                  'article_no'=>$ink_4_mixing_details_row->article_no,
                  'demand_qty'=>$this->common_model->save_number($ink_rm_qty_kg,$this->session->userdata['logged_in']['company_id']),
                  'company_id'=>$this->session->userdata['logged_in']['company_id'],
                  'work_proc_no'=>'3',
                  'from_job_card'=>'1',
                  'rel_demand_qty'=>$this->common_model->save_number($ink_rm_qty_kg*1000,$this->session->userdata['logged_in']['company_id']),
                  'flag_uom_type'=>'1',
                  'mm_id'=>$mm_id,
                  'rel_uom_id'=>'9',
                  'from_printing_jobsetup'=>'1',
                  'part_pos_no'=>$part_pos_no++
                );

              $result=$this->common_model->save('material_manufacturing',$data);
            }
          }
        }
      }
    }//ink4

    //INK 5  ------------------------------------------------------------

    if($ink_5!=''){

      $ink_5_qty_gram=$ink_5_consum;
      $ink_5_qty_kg=round(($ink_5_consum/1000),2);
      $ink_5_result=$this->springtube_ink_master_model->select_one_active_record('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],'ink_id',$ink_5);

      foreach ($ink_5_result as $ink_5_row) {

        if($ink_5_row->ink_composition==1){ 

          $work_proc_no=($ink_5_row->ink_category=='GLUE'?6:3);                   

          $data['max_mm']=$this->common_model->select_max_pkey_numeric('material_manufacturing','mm_id',$this->session->userdata['logged_in']['company_id']);
                foreach($data['max_mm'] as $max_mm_row){
                  $mm_id=$max_mm_row->mm_id+1;
                }

                $data=array(
                  'manu_order_no'=>$this->input->post('jobcard_no'),
                  'article_no'=>$ink_5_row->article_no,
                  'demand_qty'=>$this->common_model->save_number($ink_5_qty_kg,$this->session->userdata['logged_in']['company_id']),
                  'company_id'=>$this->session->userdata['logged_in']['company_id'],
                  'work_proc_no'=>$work_proc_no,
                  'from_job_card'=>'1',
                  'rel_demand_qty'=>$this->common_model->save_number($ink_5_qty_kg*1000,$this->session->userdata['logged_in']['company_id']),
                  'flag_uom_type'=>'1',
                  'mm_id'=>$mm_id,
                  'rel_uom_id'=>'9',
                  'from_printing_jobsetup'=>'1',
                  'part_pos_no'=>$part_pos_no++
                );

                $result=$this->common_model->save('material_manufacturing',$data);
        }else{

          $ink_5_mixing_master_result=$this->springtube_ink_mixing_model->select_one_active_record('springtube_ink_mixing_master',$this->session->userdata['logged_in']['company_id'],'springtube_ink_mixing_master.ink_id',$ink_5);
          foreach ($ink_5_mixing_master_result as $ink_5_mixing_master_row) {
            
            $data_mixing_5=array('mixing_id'=>$ink_5_mixing_master_row->mixing_id);

            $ink_5_mixing_details_result=$this->springtube_ink_mixing_model->active_details_records('springtube_ink_mixing_details',$data_mixing_5,$this->session->userdata['logged_in']['company_id']);

            foreach ($ink_5_mixing_details_result as $ink_5_mixing_details_row) {
              
              $data['max_mm']=$this->common_model->select_max_pkey_numeric('material_manufacturing','mm_id',$this->session->userdata['logged_in']['company_id']);
                foreach($data['max_mm'] as $max_mm_row){
                  $mm_id=$max_mm_row->mm_id+1;
                }

                $ink_rm_qty_gram=($ink_5_qty_gram*($ink_5_mixing_details_row->ink_perc/100));
                $ink_rm_qty_kg=$ink_rm_qty_gram/1000;
                $data=array(
                  'manu_order_no'=>$this->input->post('jobcard_no'),
                  'article_no'=>$ink_5_mixing_details_row->article_no,
                  'demand_qty'=>$this->common_model->save_number($ink_rm_qty_kg,$this->session->userdata['logged_in']['company_id']),
                  'company_id'=>$this->session->userdata['logged_in']['company_id'],
                  'work_proc_no'=>'3',
                  'from_job_card'=>'1',
                  'rel_demand_qty'=>$this->common_model->save_number($ink_rm_qty_kg*1000,$this->session->userdata['logged_in']['company_id']),
                  'flag_uom_type'=>'1',
                  'mm_id'=>$mm_id,
                  'rel_uom_id'=>'9',
                  'from_printing_jobsetup'=>'1',
                  'part_pos_no'=>$part_pos_no++
                );

              $result=$this->common_model->save('material_manufacturing',$data);
            }
          }
        }
      }
    }//ink5

     //INK 6  ------------------------------------------------------------
    if($ink_6!=''){

      $ink_6_qty_gram=$ink_6_consum;
      $ink_6_qty_kg=round(($ink_6_consum/1000),2);
      $ink_6_result=$this->springtube_ink_master_model->select_one_active_record('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],'ink_id',$ink_6);

      foreach ($ink_6_result as $ink_6_row) {

        if($ink_6_row->ink_composition==1){ 

          $work_proc_no=($ink_6_row->ink_category=='GLUE'?6:3);                   

          $data['max_mm']=$this->common_model->select_max_pkey_numeric('material_manufacturing','mm_id',$this->session->userdata['logged_in']['company_id']);
                foreach($data['max_mm'] as $max_mm_row){
                  $mm_id=$max_mm_row->mm_id+1;
                }

                $data=array(
                  'manu_order_no'=>$this->input->post('jobcard_no'),
                  'article_no'=>$ink_6_row->article_no,
                  'demand_qty'=>$this->common_model->save_number($ink_6_qty_kg,$this->session->userdata['logged_in']['company_id']),
                  'company_id'=>$this->session->userdata['logged_in']['company_id'],
                  'work_proc_no'=>$work_proc_no,
                  'from_job_card'=>'1',
                  'rel_demand_qty'=>$this->common_model->save_number($ink_6_qty_kg*1000,$this->session->userdata['logged_in']['company_id']),
                  'flag_uom_type'=>'1',
                  'mm_id'=>$mm_id,
                  'rel_uom_id'=>'9',
                  'from_printing_jobsetup'=>'1',
                  'part_pos_no'=>$part_pos_no++
                );

                $result=$this->common_model->save('material_manufacturing',$data);
        }else{

          $ink_6_mixing_master_result=$this->springtube_ink_mixing_model->select_one_active_record('springtube_ink_mixing_master',$this->session->userdata['logged_in']['company_id'],'springtube_ink_mixing_master.ink_id',$ink_6);
          foreach ($ink_6_mixing_master_result as $ink_6_mixing_master_row) {
            
            $data_mixing_6=array('mixing_id'=>$ink_6_mixing_master_row->mixing_id);

            $ink_6_mixing_details_result=$this->springtube_ink_mixing_model->active_details_records('springtube_ink_mixing_details',$data_mixing_6,$this->session->userdata['logged_in']['company_id']);

            foreach ($ink_6_mixing_details_result as $ink_6_mixing_details_row) {
              
              $data['max_mm']=$this->common_model->select_max_pkey_numeric('material_manufacturing','mm_id',$this->session->userdata['logged_in']['company_id']);
                foreach($data['max_mm'] as $max_mm_row){
                  $mm_id=$max_mm_row->mm_id+1;
                }

                $ink_rm_qty_gram=($ink_6_qty_gram*($ink_6_mixing_details_row->ink_perc/100));
                $ink_rm_qty_kg=$ink_rm_qty_gram/1000;
                $data=array(
                  'manu_order_no'=>$this->input->post('jobcard_no'),
                  'article_no'=>$ink_6_mixing_details_row->article_no,
                  'demand_qty'=>$this->common_model->save_number($ink_rm_qty_kg,$this->session->userdata['logged_in']['company_id']),
                  'company_id'=>$this->session->userdata['logged_in']['company_id'],
                  'work_proc_no'=>'3',
                  'from_job_card'=>'1',
                  'rel_demand_qty'=>$this->common_model->save_number($ink_rm_qty_kg*1000,$this->session->userdata['logged_in']['company_id']),
                  'flag_uom_type'=>'1',
                  'mm_id'=>$mm_id,
                  'rel_uom_id'=>'9',
                  'from_printing_jobsetup'=>'1',
                  'part_pos_no'=>$part_pos_no++
                );

              $result=$this->common_model->save('material_manufacturing',$data);
            }
          }
        }
      }
    }//ink6

    return $result;


  } 

  function insert_plates_to_jobcard($order_no,$article_no,$jobcard_no){

    $data=array('jobcard_no'=>$jobcard_no,'archive'=>0);  

    $springtube_daily_plates_master_result=$this->common_model->select_active_records_where('springtube_daily_plates_master',$this->session->userdata['logged_in']['company_id'],$data);
    if($springtube_daily_plates_master_result){

      $data['part_pos_no']=$this->common_model->select_max_pkey_where('material_manufacturing','part_pos_no','manu_order_no',$this->input->post('jobcard_no'),$this->session->userdata['logged_in']['company_id']);

      foreach($data['part_pos_no'] as $part_pos_no_row){
        $part_pos_no=$part_pos_no_row->part_pos_no+1;
      }

      foreach ($springtube_daily_plates_master_result as $master_row) {
        
        // Inserting Flexo Plate CON-FLEXO-PLT-0029 in to printing Jobcard----------

        $data['max_mm']=$this->common_model->select_max_pkey_numeric('material_manufacturing','mm_id',$this->session->userdata['logged_in']['company_id']);

        foreach($data['max_mm'] as $max_mm_row){
          $mm_id=$max_mm_row->mm_id+1;
        }
       
        $data=array(
          'manu_order_no'=>$jobcard_no,
          'article_no'=>'CON-FLEXO-PLT-0029',
          'demand_qty'=>$this->common_model->save_number($master_row->total_flexo_plate_area,$this->session->userdata['logged_in']['company_id']),
          'company_id'=>$this->session->userdata['logged_in']['company_id'],
          'work_proc_no'=>'3',
          'from_job_card'=>'1',
          'rel_demand_qty'=>$this->common_model->save_number($master_row->total_flexo_plate_area*1000,$this->session->userdata['logged_in']['company_id']),
          'flag_uom_type'=>'1',
          'mm_id'=>$mm_id,
          'rel_uom_id'=>'9',
          'from_printing_jobsetup'=>'1',
          'part_pos_no'=>$part_pos_no++
        );
        
        $result=$this->common_model->save('material_manufacturing',$data);

        $data=array('job_setup_status'=>1);
        $result=$this->common_model->update_one_active_record('springtube_daily_plates_master',$data,'dpr_id',$master_row->dpr_id,$this->session->userdata['logged_in']['company_id']);

      }
       return $result;

    }else{

      return 0;
    }
    

  }  



  
}