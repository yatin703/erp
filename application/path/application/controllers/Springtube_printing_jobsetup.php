<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/ImplementJWT.php';

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

      $this->objOfJwt= new ImplementJWT();

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
              $this->form_validation->set_rules('digital_cost_per_qty',$durst.'Digital Cost Per Qty','required|trim|xss_clean');
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

            $cold_foil_1='';
            $cold_foil_1_width='';
            $cold_foil_1_length='';
            $cold_foil_1_area='';

            $cold_foil_2='';
            $cold_foil_2_width='';
            $cold_foil_2_length='';
            $cold_foil_2_area='';



              // FOIL 1 VALIDATION
            if(!empty($this->input->post('cold_foil_1'))){

              $arr_1=explode("//",$this->input->post('cold_foil_1'));
              $cold_foil_1=$arr_1[1];
              $cold_foil_1_width=$this->input->post('cold_foil_1_width');
              $cold_foil_1_length=$this->input->post('cold_foil_1_length');
              $cold_foil_1_area=$this->input->post('cold_foil_1_area');
            }

            // FOIL 2 VALIDATION
            if(!empty($this->input->post('cold_foil_2'))){

              $arr_2=explode("//",$this->input->post('cold_foil_2'));
              $cold_foil_2=$arr_1[1];
              $cold_foil_2_width=$this->input->post('cold_foil_2_width');
              $cold_foil_2_length=$this->input->post('cold_foil_2_length');
              $cold_foil_2_area=$this->input->post('cold_foil_2_area');

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
                'digital_cost_per_qty'=>$this->input->post('digital_cost_per_qty'),

                 
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

                'cold_foil_1'=>$cold_foil_1,
                'cold_foil_1_width'=>$cold_foil_1_width,
                'cold_foil_1_length'=>$cold_foil_1_length,
                'cold_foil_1_area'=>$cold_foil_1_area,

                'cold_foil_2'=>$cold_foil_2,
                'cold_foil_2_width'=>$cold_foil_2_width,
                'cold_foil_2_length'=>$cold_foil_2_length,
                'cold_foil_2_area'=>$cold_foil_2_area
                     
              );

              $job_id=$this->common_model->save_return_pkey('springtube_printing_jobsetup_master',$data); 


              if($job_id){

                $result_ink =$this->insert_inks_to_jobcard($ink_1,$this->input->post('abg1_ink_usage_1'),$ink_2,$this->input->post('abg1_ink_usage_2'),$ink_3,$this->input->post('abg1_ink_usage_3'),$ink_4,$this->input->post('abg1_ink_usage_4'),$ink_5,$this->input->post('abg2_ink_usage_1'),$ink_6,$this->input->post('abg2_ink_usage_2')); 

                // Change due to flexo plates are not issueing to tally in sqmm--- 
                //$result_plates=$this->insert_plates_to_jobcard($this->input->post('order_no'),
                //$this->input->post('article_no'),$this->input->post('jobcard_no'));

                $result_foils=$this->insert_foils_to_jobcard($this->input->post('jobcard_no'),$cold_foil_1,$cold_foil_1_area,$cold_foil_2,$cold_foil_2_area);


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

                    $result=$this->send_email($job_id,$transaction_no,$this->input->post('approval_authority'));
                }


                if($result_ink){
                  $data['note']='Ink Save Transaction Completed';

                }else{                  
                  $data['error']='Ink Save Transaction failed';
                }

                if($result_foils){

                  $data['note']='Foils Save Transaction Completed';

                }else{                  
                  $data['error']='Foil Save Failed';
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
                $this->form_validation->set_rules('digital_cost_per_qty',$durst.'Digital Cost Per Qty','required|trim|xss_clean');

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

              $cold_foil_1='';
              $cold_foil_1_width='';
              $cold_foil_1_length='';
              $cold_foil_1_area='';

              $cold_foil_2='';
              $cold_foil_2_width='';
              $cold_foil_2_length='';
              $cold_foil_2_area='';



                // FOIL 1 VALIDATION
              if(!empty($this->input->post('cold_foil_1'))){

                $arr_1=explode("//",$this->input->post('cold_foil_1'));
                $cold_foil_1=$arr_1[1];
                $cold_foil_1_width=$this->input->post('cold_foil_1_width');
                $cold_foil_1_length=$this->input->post('cold_foil_1_length');
                $cold_foil_1_area=$this->input->post('cold_foil_1_area');
              }

              // FOIL 2 VALIDATION
              if(!empty($this->input->post('cold_foil_2'))){

                $arr_2=explode("//",$this->input->post('cold_foil_2'));
                $cold_foil_2=$arr_1[1];
                $cold_foil_2_width=$this->input->post('cold_foil_2_width');
                $cold_foil_2_length=$this->input->post('cold_foil_2_length');
                $cold_foil_2_area=$this->input->post('cold_foil_2_area');

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
                'digital_cost_per_qty'=>$this->input->post('digital_cost_per_qty'), 
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
                 
                'cold_foil_1'=>$cold_foil_1,
                'cold_foil_1_width'=>$cold_foil_1_width,
                'cold_foil_1_length'=>$cold_foil_1_length,
                'cold_foil_1_area'=>$cold_foil_1_area,

                'cold_foil_2'=>$cold_foil_2,
                'cold_foil_2_width'=>$cold_foil_2_width,
                'cold_foil_2_length'=>$cold_foil_2_length,
                'cold_foil_2_area'=>$cold_foil_2_area            
                 
                     
              );                          

              $result=$this->common_model->update_one_active_record('springtube_printing_jobsetup_master',$data,'job_id',$this->input->post('job_id'),$this->session->userdata['logged_in']['company_id']);

              if($result){

                $result_ink =$this->insert_inks_to_jobcard($ink_1,$this->input->post('abg1_ink_usage_1'),$ink_2,$this->input->post('abg1_ink_usage_2'),$ink_3,$this->input->post('abg1_ink_usage_3'),$ink_4,$this->input->post('abg1_ink_usage_4'),$ink_5,$this->input->post('abg2_ink_usage_1'),$ink_6,$this->input->post('abg2_ink_usage_2')); 


                $result_foils=$this->insert_foils_to_jobcard($this->input->post('jobcard_no'),$cold_foil_1,$cold_foil_1_area,$cold_foil_2,$cold_foil_2_area);


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

                      $result=$this->send_email($this->input->post('job_id'),$transaction_no,$this->input->post('approval_authority'));
                }
                 
                if($result){                  
                  $data['note']='Update Transaction Completed';
                }else{
                  $data['error']='Update Transaction Failed';
                }

                //header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

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
              $this->form_validation->set_rules('digital_cost_per_qty',$durst.'Digital Cost Per Qty','required|trim|xss_clean');

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

            $cold_foil_1='';
            $cold_foil_1_width='';
            $cold_foil_1_length='';
            $cold_foil_1_area='';

            $cold_foil_2='';
            $cold_foil_2_width='';
            $cold_foil_2_length='';
            $cold_foil_2_area='';



              // FOIL 1 VALIDATION
            if(!empty($this->input->post('cold_foil_1'))){

              $arr_1=explode("//",$this->input->post('cold_foil_1'));
              $cold_foil_1=$arr_1[1];
              $cold_foil_1_width=$this->input->post('cold_foil_1_width');
              $cold_foil_1_length=$this->input->post('cold_foil_1_length');
              $cold_foil_1_area=$this->input->post('cold_foil_1_area');
            }

            // FOIL 2 VALIDATION
            if(!empty($this->input->post('cold_foil_2'))){

              $arr_2=explode("//",$this->input->post('cold_foil_2'));
              $cold_foil_2=$arr_1[1];
              $cold_foil_2_width=$this->input->post('cold_foil_2_width');
              $cold_foil_2_length=$this->input->post('cold_foil_2_length');
              $cold_foil_2_area=$this->input->post('cold_foil_2_area');

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
                'digital_cost_per_qty'=>$this->input->post('digital_cost_per_qty'),
                 
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

                'cold_foil_1'=>$cold_foil_1,
                'cold_foil_1_width'=>$cold_foil_1_width,
                'cold_foil_1_length'=>$cold_foil_1_length,
                'cold_foil_1_area'=>$cold_foil_1_area,

                'cold_foil_2'=>$cold_foil_2,
                'cold_foil_2_width'=>$cold_foil_2_width,
                'cold_foil_2_length'=>$cold_foil_2_length,
                'cold_foil_2_area'=>$cold_foil_2_area                 
                     
              );

              $job_id=$this->common_model->save_return_pkey('springtube_printing_jobsetup_master',$data); 


              if($job_id){

                $result_ink =$this->insert_inks_to_jobcard($ink_1,$this->input->post('abg1_ink_usage_1'),$ink_2,$this->input->post('abg1_ink_usage_2'),$ink_3,$this->input->post('abg1_ink_usage_3'),$ink_4,$this->input->post('abg1_ink_usage_4'),$ink_5,$this->input->post('abg2_ink_usage_1'),$ink_6,$this->input->post('abg2_ink_usage_2')); 

                $result_foils=$this->insert_foils_to_jobcard($this->input->post('jobcard_no'),$cold_foil_1,$cold_foil_1_area,$cold_foil_2,$cold_foil_2_area);


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
    $result=0;
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


  function insert_foils_to_jobcard($jobcard_no,$cold_foil_1,$cold_foil_1_area,$cold_foil_2,$cold_foil_2_area){  


    
    if(!empty($cold_foil_1)){

      $data['part_pos_no']=$this->common_model->select_max_pkey_where('material_manufacturing','part_pos_no','manu_order_no',$jobcard_no,$this->session->userdata['logged_in']['company_id']);

      foreach($data['part_pos_no'] as $part_pos_no_row){
        $part_pos_no=$part_pos_no_row->part_pos_no+1;
      }
      

      $data['max_mm']=$this->common_model->select_max_pkey_numeric('material_manufacturing','mm_id',$this->session->userdata['logged_in']['company_id']);

      foreach($data['max_mm'] as $max_mm_row){
        $mm_id=$max_mm_row->mm_id+1;
      }

      $data_1=array(
        'manu_order_no'=>$jobcard_no,
        'article_no'=>$cold_foil_1,
        'demand_qty'=>$this->common_model->save_number($cold_foil_1_area,$this->session->userdata['logged_in']['company_id']),
        'company_id'=>$this->session->userdata['logged_in']['company_id'],
        'work_proc_no'=>'3',
        'from_job_card'=>'1',
        'rel_demand_qty'=>$this->common_model->save_number($cold_foil_1_area*1000,$this->session->userdata['logged_in']['company_id']),
        'flag_uom_type'=>'1',
        'mm_id'=>$mm_id,
        'rel_uom_id'=>'9',
        'from_printing_jobsetup'=>'1',
        'part_pos_no'=>$part_pos_no
      );     
      
        
      $result_1=$this->common_model->save('material_manufacturing',$data_1);      


      }

      if(!empty($cold_foil_2)){

      $data['part_pos_no']=$this->common_model->select_max_pkey_where('material_manufacturing','part_pos_no','manu_order_no',$jobcard_no,$this->session->userdata['logged_in']['company_id']);

      foreach($data['part_pos_no'] as $part_pos_no_row){
        $part_pos_no=$part_pos_no_row->part_pos_no+1;
      }
      

      $data['max_mm']=$this->common_model->select_max_pkey_numeric('material_manufacturing','mm_id',$this->session->userdata['logged_in']['company_id']);

      foreach($data['max_mm'] as $max_mm_row){
        $mm_id=$max_mm_row->mm_id+1;
      }

      $data_2=array(
        'manu_order_no'=>$jobcard_no,
        'article_no'=>$cold_foil_2,
        'demand_qty'=>$this->common_model->save_number($cold_foil_2_area,$this->session->userdata['logged_in']['company_id']),
        'company_id'=>$this->session->userdata['logged_in']['company_id'],
        'work_proc_no'=>'3',
        'from_job_card'=>'1',
        'rel_demand_qty'=>$this->common_model->save_number($cold_foil_2_area*1000,$this->session->userdata['logged_in']['company_id']),
        'flag_uom_type'=>'1',
        'mm_id'=>$mm_id,
        'rel_uom_id'=>'9',
        'from_printing_jobsetup'=>'1',
        'part_pos_no'=>$part_pos_no
      );     
      
        
      $result_2=$this->common_model->save('material_manufacturing',$data_2);      


      }
      
      return $result_1;
    

  }

  function send_email($job_id,$transaction_no,$approving_user){

    $jobcard_no='';    
    

    $result_springtube_printing_jobsetup_master=$this->common_model->select_one_active_record('springtube_printing_jobsetup_master',$this->session->userdata['logged_in']['company_id'],'job_id',$job_id);

    foreach ($result_springtube_printing_jobsetup_master as $row) {

      $customer='';
      $jobcard_qty=0;
      $order_no='';
      $article_no='';
      $ad_id='';
      $version_no='';
      $dia='';
      $length='';
      $print_type='';
      $laminate_color='';
      $body_making_type='';
      $total_order_quantity='';
      $printed_counter=0;

      $cold_foil_1_jobsetup=$row->cold_foil_1;
      $cold_foil_1_width_jobsetup=$row->cold_foil_1_width;
      $cold_foil_1_length_jobsetup=$row->cold_foil_1_length;
      $cold_foil_1_area_jobsetup=$row->cold_foil_1_area;
      $cold_foil_2_jobsetup=$row->cold_foil_2;
      $cold_foil_2_width_jobsetup=$row->cold_foil_2_width;
      $cold_foil_2_length_jobsetup=$row->cold_foil_2_length;
      $cold_foil_2_area_jobsetup=$row->cold_foil_2_area;


      $cold_foil_1_artwork='';
      $cold_foil_1_width_artwork=0;
      $cold_foil_1_area_artwork=0;
      $cold_foil_2_artwork='';
      $cold_foil_2_width_artwork=0;
      $cold_foil_2_area_artwork=0;

      $total_meters='';

      $data['production_master']=$this->job_card_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$row->jobcard_no);

      foreach ($data['production_master'] as $production_master_row) {
                            
          $jobcard_qty=$this->common_model->read_number($production_master_row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']);
          $order_no=$production_master_row->sales_ord_no;
          $article_no=$production_master_row->article_no;
          $total_meters=$production_master_row->total_meters;

      }

      $order_master_result=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$order_no);
      foreach($order_master_result as $order_master_row){
        $customer=$order_master_row->customer_no;                      
      }

      $data_order_details=array('order_no'=>$order_no,'article_no'=>$article_no);

      $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
      foreach($order_details_result as $order_details_row){
        $total_order_quantity=$order_details_row->total_order_quantity;
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

          $cold_foil_1_artwork=$springtube_artwork_row->cold_foil_1;
          $cold_foil_1_width_artwork=$springtube_artwork_row->cold_foil_1_width;
          $cold_foil_2_artwork=$springtube_artwork_row->cold_foil_2;
          $cold_foil_2_width_artwork=$springtube_artwork_row->cold_foil_2_width;
      }   


      $cold_foil_1=($cold_foil_1_jobsetup!=''?$cold_foil_1_jobsetup:$cold_foil_1_artwork);
      $cold_foil_1_width=($cold_foil_1_width_jobsetup!=''?$cold_foil_1_width_jobsetup:$cold_foil_1_width_artwork);
      $cold_foil_1_length=($cold_foil_1_length_jobsetup!=''?$cold_foil_1_length_jobsetup:$total_meters);
      $cold_foil_1_area=($cold_foil_1_area_jobsetup!=''?$cold_foil_1_area_jobsetup:round(($cold_foil_1_width/1000)*$total_meters,2));

      $cold_foil_2=($cold_foil_2_jobsetup!=''?$cold_foil_2_jobsetup:$cold_foil_2_artwork);
      $cold_foil_2_width=($cold_foil_2_width_jobsetup!=''?$cold_foil_2_width_jobsetup:$cold_foil_2_width_artwork);
      $cold_foil_2_length=($cold_foil_1_length_jobsetup!=''?$cold_foil_2_length_jobsetup:$total_meters);
      $cold_foil_2_area=($cold_foil_2_area_jobsetup!=''?$cold_foil_2_area_jobsetup:round(($cold_foil_2_width/1000)*$total_meters,2));                        

      $search_data=array('jobcard_no'=>$row->jobcard_no);
      $counter_result=$this->springtube_printing_production_model->select_total_counter('springtube_printing_production_master',$search_data);
      foreach ($counter_result as $counter_row) {
        $printed_counter=$counter_row->total_counter;
      }


      $emailContent = '<!DOCTYPE>
      <html>
      <head><title>Springtube Printing Jobsetup</title>
      
        <style>
          table {
            border: 1px solid #008ae6;
            border-collapse: collapse;
            width: 100%;
            cellpadding:2px;
            cellspacing:0;
            font-size:10px;
            font-style:verdana;
          }

          th {
            border: 1px solid #008ae6;
            text-align: left;
            padding: 2px;
            vertical-align:top;
            font-weight:bold;
            background-color:#DFFCFC;
          }
          td {
            border: 1px solid #008ae6;
            text-align: left;
            padding: 2px;
            vertical-align:top;
          }

          .btn {
          border: 2px solid black;
          border-radius: 5px;
          background-color: white;
          color: black;
          padding: 8px 20px;
          font-size: 16px;
          cursor: pointer;
        }

        /* Green */
        .success {
          border-color: #4CAF50;
          color: green;
        }

        .success:hover {
          background-color: #4CAF50;
          color: white;
        }               

        /* Red */
        .danger {
          border-color: #f44336;
          color: red
        }

        .danger:hover {
          background: #f44336;
          color: white;
        }

        

        .default:hover {
          background: #e7e7e7;
        }

          
        </style>


  </head>
      <body>
      <div style="width:900px;margin:0px auto;border:1px solid #ddd;font-family:verdana;">  
    <table width="100%">
          <tr>
            <th style="padding-left:3%;text-align:center" colspan="10"><b>SPRINGTUBE PRINTING JOBSETUP : <a href="'.base_url('index.php/sales_order_item_parameterwise/view_new/'.$row->jobcard_no.'/'.$bom_no.'/'.$bom_version_no).'" target="_blank">'.$row->jobcard_no.'</a>
            </th>
          </tr>';
    //$emailContent .='<tr><td style="height:20px" colspan="10">Order  Details</td></tr>';


    $emailContent .= '<tr><th style="height:20px" colspan="10">ORDER DETAILS </th></tr>
    <tr>
      <th style="height:20px">CUSTOMER</th>
      <th>ORDER NO</th>
      <th>ARTICLE NO</th>
      <th>ARTICLE NAME</th>
      <th>ARTWORK NO</th>
      <th>ORDER QTY</th>
      <th>JOBCARD NO</th>
      <th>JOBCARD QTY</th>
      <th>PRINTING QTY</th>
      <th>CREATED BY</th>
    </tr>
    <tr>
      <td>'.$this->common_model->get_customer_name($customer,$this->session->userdata['logged_in']['company_id']).'</td>
      <td>'.$order_no.'</td>
      <td>'.$article_no.'</td>
      <td>'.$this->common_model->get_article_name($article_no,$this->session->userdata['logged_in']['company_id']).'</td>
      <td><a href="'.base_url('index.php/artwork_springtube/view/'.$ad_id.'/'.$version_no).'" target="_blank">'.$ad_id.'_R'.$version_no.'</a>'.'</td>
      <td>'.$this->common_model->read_number($total_order_quantity,$this->session->userdata['logged_in']['company_id']).'</td>
      <td>'.'<a href="'.base_url('index.php/sales_order_item_parameterwise/view_new/'.$row->jobcard_no.'/'.$bom_no.'/'.$bom_version_no).'" target="_blank">'.$row->jobcard_no.'</a>'.'</td>
      <td>'.$jobcard_qty.'</td>
      <td>'.round(($printed_counter*2),2).'</td>
      <td>'.strtoupper($this->common_model->get_user_name($row->user_id,$this->session->userdata['logged_in']['company_id'])).'</td>
      
    </tr>
    </table>
    <br/>';

    $emailContent .='
      <table width="100%">
        <tr>
          <td colspan="10">            
            <table>
              <tr>
                <!-- INK 1 -->
                <td width="25%">
                  <table>
                    <tr>
                      <th colspan="2"><b>ABG 1-FLEXO UNIT-1</b></th>                        
                    </tr>
                      <tr>
                        <td style="width: 25%;">CARONA</td>
                        <td>'.$row->abg1_carona_1.'</td>
                      </tr>
                      <tr>
                        <td style="height:400px;">COLOUR</td>
                          <td>';
                            $ink_1=$row->abg1_ink_id_1;

                            if($ink_1!=''|| $ink_1!='0'){

                              $ink_1_qty_gram=$row->abg1_ink_usage_1;
                                 
                              $ink_1_result=$this->springtube_ink_master_model->select_one_active_record('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],'ink_id',$ink_1);

                              foreach ($ink_1_result as $ink_1_row) {

                                if($ink_1_row->ink_composition==1){

                                  $emailContent .= $ink_1_row->ink_desc;
                                         
                                }else{
                                  $emailContent .=$ink_1_row->ink_desc;
                                  $emailContent .='<p>';
                                  $emailContent .='<table>
                                              <tr class="heading">
                                              <th >MIXED_INK_DETAILS</th>
                                              <th  >INK%</th>
                                              <th  >GRAMS</th>
                                              <th  >KGS</th>
                                              </tr>';

                                  $ink_1_mixing_master_result=$this->springtube_ink_mixing_model->select_one_active_record('springtube_ink_mixing_master',$this->session->userdata['logged_in']['company_id'],'springtube_ink_mixing_master.ink_id',$ink_1);
                                    
                                    foreach ($ink_1_mixing_master_result as $ink_1_mixing_master_row) {                                 
                                          
                                      $data_mixing_1=array('mixing_id'=>$ink_1_mixing_master_row->mixing_id);

                                      $ink_1_mixing_details_result=$this->springtube_ink_mixing_model->active_details_records('springtube_ink_mixing_details',$data_mixing_1,$this->session->userdata['logged_in']['company_id']);


                                        $sum_perc=0;
                                        $sum_grams=0; 
                                        $sum_kgs=0;
                                        foreach ($ink_1_mixing_details_result as $ink_1_mixing_details_row) {

                                          $emailContent .='<tr>
                                          <td>'.$ink_1_mixing_details_row->ink_desc.'</td>
                                          <td>'.$ink_1_mixing_details_row->ink_perc.'%</td>
                                          <td>'.round(($row->abg1_ink_usage_1*$ink_1_mixing_details_row->ink_perc/100),2).' Grams</td>
                                          <td>'.round(($row->abg1_ink_usage_1*$ink_1_mixing_details_row->ink_perc/100),2).' Kgs</td>
                                          </tr>';

                                          $sum_perc+=$ink_1_mixing_details_row->ink_perc;
                                          $sum_grams+=round(($row->abg1_ink_usage_1*$ink_1_mixing_details_row->ink_perc/100),2);
                                                  
                                                
                                        }

                                        $emailContent .='<tr style="font-weight:bold;">
                                        <td><b>TOTAL</b></td><td >'.$sum_perc.'%</td><td>'.$sum_grams.'</td><td>'.($sum_grams/1000).'</td></tr>';
                                                     

                                    }

                                 $emailContent .='</table>';
                              }
                          }
                      }//ink1

                        $emailContent .='</td>
                      </tr>
                      <tr><td >INK_USAGE</td>
                          <td >'.$row->abg1_ink_usage_1.($row->abg1_ink_usage_1!=''?' Grams {'.round($row->abg1_ink_usage_1/1000,2).' Kgs}':'').'</td>
                      </tr>
                      <tr><td  >ANILOX</td>
                          <td  >';

                          $springtube_anilox_master_result=$this->common_model->select_one_active_record('springtube_anilox_master',$this->session->userdata['logged_in']['company_id'],'anilox_id',$row->abg1_anilox_1);
                          foreach ($springtube_anilox_master_result as $key => $springtube_anilox_master_row) {

                            $emailContent .= $springtube_anilox_master_row->anilox_lpi;
                              
                          }
                          //echo $row->abg1_anilox_1;
                          $emailContent .='</td>
                      </tr>
                      <tr><td  >METHOD</td>
                          <td>'.($row->abg1_applying_method_1!=''?($row->abg1_applying_method_1==1?'Plate Through':'Roller Through'):'').'</td style="border:1px solid #D9d9d9;">
                      </tr>
                      <tr><td  >TEETH</td>
                          <td  >'; 
                          $cylinder_master_result_1=$this->common_model->select_one_active_record('springtube_cylinder_master',$this->session->userdata['logged_in']['company_id'],'cylinder_id',$row->abg1_cylinder_teeth_1);
                          foreach ($cylinder_master_result_1 as $cylinder_master_row_1) {
                              $emailContent .= $cylinder_master_row_1->teeth;
                          }
                          $emailContent .='</td>
                      </tr>
                      <tr><td  >SR/FR</td>
                          <td  >'.($row->abg1_rotary_1!=''?($row->abg1_rotary_1==1?'[SR]-Semi Rotary':'[FR]-Full Rotary'):'').'</td>
                      </tr>
                      <tr><td  >UV POWER</td>
                          <td  >'.$row->abg1_uv_power_1.($row->abg1_uv_power_1!=''?' %':'').'</td>
                      </tr>
                      <tr>
                          <td >UV SPEED</td>
                          <td >'.$row->abg1_uv_speed_1.($row->abg1_uv_speed_1!=''?' %':'').'</td>
                      </tr>
                      <tr>
                          <td  >UV HOUR</td>
                          <td  >'.$row->abg1_uv_hours_1.($row->abg1_uv_hours_1!=''?' Hrs':'').'</td>
                      </tr>
                      <tr><td  >COMMENT</td>
                          <td style=" line-height:50px">'.$row->abg1_unit_1_comment.'</td>
                      </tr>
                  </table>
                </td>

                <!-- INK 2 -->
                <td width="25%">
                  <table>
                    <tr>
                      <th colspan="2"><b>ABG 1-FLEXO UNIT-2</b></th>                        
                    </tr>
                      <tr>
                        <td style="width: 25%;">CARONA</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td style="height:400px;">COLOUR</td>
                          <td>';
                            $ink_2=$row->abg1_ink_id_2;

                            if($ink_2!=''|| $ink_2!='0'){

                              $ink_2_qty_gram=$row->abg1_ink_usage_2;
                                 
                              $ink_2_result=$this->springtube_ink_master_model->select_one_active_record('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],'ink_id',$ink_2);

                              foreach ($ink_2_result as $ink_2_row) {

                                if($ink_2_row->ink_composition==1){

                                  $emailContent .= $ink_2_row->ink_desc;
                                         
                                }else{
                                  $emailContent .=$ink_2_row->ink_desc;
                                  $emailContent .='<p>';
                                  $emailContent .='<table>
                                              <tr class="heading">
                                              <th >MIXED_INK_DETAILS</th>
                                              <th  >INK%</th>
                                              <th  >GRAMS</th>
                                              <th  >KGS</th>
                                              </tr>';

                                  $ink_2_mixing_master_result=$this->springtube_ink_mixing_model->select_one_active_record('springtube_ink_mixing_master',$this->session->userdata['logged_in']['company_id'],'springtube_ink_mixing_master.ink_id',$ink_2);
                                    
                                    foreach ($ink_2_mixing_master_result as $ink_2_mixing_master_row) {                                 
                                          
                                      $data_mixing_2=array('mixing_id'=>$ink_2_mixing_master_row->mixing_id);

                                      $ink_2_mixing_details_result=$this->springtube_ink_mixing_model->active_details_records('springtube_ink_mixing_details',$data_mixing_2,$this->session->userdata['logged_in']['company_id']);


                                        $sum_perc=0;
                                        $sum_grams=0; 
                                        $sum_kgs=0;
                                        foreach ($ink_2_mixing_details_result as $ink_2_mixing_details_row) {

                                          $emailContent .='<tr>
                                          <td>'.$ink_2_mixing_details_row->ink_desc.'</td>
                                          <td>'.$ink_2_mixing_details_row->ink_perc.'%</td>
                                          <td>'.round(($row->abg1_ink_usage_2*$ink_2_mixing_details_row->ink_perc/100),2).' Grams</td>
                                          <td>'.round(($row->abg1_ink_usage_2*$ink_2_mixing_details_row->ink_perc/100),2).' Kgs</td>
                                          </tr>';

                                          $sum_perc+=$ink_2_mixing_details_row->ink_perc;
                                          $sum_grams+=round(($row->abg1_ink_usage_2*$ink_2_mixing_details_row->ink_perc/100),2);
                                                  
                                                
                                        }

                                        $emailContent .='<tr style="font-weight:bold;">
                                        <td><b>TOTAL</b></td><td >'.$sum_perc.'%</td><td>'.$sum_grams.'</td><td>'.($sum_grams/1000).'</td></tr>';
                                                     

                                    }

                                 $emailContent .='</table>';
                              }
                          }
                      }//ink1

                        $emailContent .='</td>
                      </tr>
                      <tr><td >INK_USAGE</td>
                          <td >'.$row->abg1_ink_usage_2.($row->abg1_ink_usage_2!=''?' Grams {'.round($row->abg1_ink_usage_2/1000,2).' Kgs}':'').'</td>
                      </tr>
                      <tr><td  >ANILOX</td>
                          <td  >';

                          $springtube_anilox_master_result=$this->common_model->select_one_active_record('springtube_anilox_master',$this->session->userdata['logged_in']['company_id'],'anilox_id',$row->abg1_anilox_2);
                          foreach ($springtube_anilox_master_result as $key => $springtube_anilox_master_row) {

                            $emailContent .= $springtube_anilox_master_row->anilox_lpi;
                              
                          }
                          //echo $row->abg1_anilox_1;
                          $emailContent .='</td>
                      </tr>
                      <tr><td  >METHOD</td>
                          <td>'.($row->abg1_applying_method_2!=''?($row->abg1_applying_method_2==1?'Plate Through':'Roller Through'):'').'</td style="border:1px solid #D9d9d9;">
                      </tr>
                      <tr><td  >TEETH</td>
                          <td  >'; 
                          $cylinder_master_result_2=$this->common_model->select_one_active_record('springtube_cylinder_master',$this->session->userdata['logged_in']['company_id'],'cylinder_id',$row->abg1_cylinder_teeth_2);
                          foreach ($cylinder_master_result_2 as $cylinder_master_row_2) {
                              $emailContent .= $cylinder_master_row_2->teeth;
                          }
                          $emailContent .='</td>
                      </tr>
                      <tr><td  >SR/FR</td>
                          <td  >'.($row->abg1_rotary_2!=''?($row->abg1_rotary_2==1?'[SR]-Semi Rotary':'[FR]-Full Rotary'):'').'</td>
                      </tr>
                      <tr><td  >UV POWER</td>
                          <td  >'.$row->abg1_uv_power_2.($row->abg1_uv_power_2!=''?' %':'').'</td>
                      </tr>
                      <tr>
                          <td >UV SPEED</td>
                          <td >'.$row->abg1_uv_speed_2.($row->abg1_uv_speed_2!=''?' %':'').'</td>
                      </tr>
                      <tr>
                          <td  >UV HOUR</td>
                          <td  >'.$row->abg1_uv_hours_2.($row->abg1_uv_hours_2!=''?' Hrs':'').'</td>
                      </tr>
                      <tr><td  >COMMENT</td>
                          <td style=" line-height:50px">'.$row->abg1_unit_2_comment.'</td>
                      </tr>
                  </table>
                </td>

                <!-- INK 3 -->
                <td width="25%">
                  <table>
                    <tr>
                      <th colspan="2"><b>ABG 1-FLEXO UNIT-3</b></th>                        
                    </tr>
                      <tr>
                        <td style="width: 25%;">CARONA</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td style="height:400px;">COLOUR</td>
                          <td>';
                            $ink_3=$row->abg1_ink_id_3;

                            if($ink_3!=''|| $ink_3!='0'){

                              $ink_3_qty_gram=$row->abg1_ink_usage_3;
                                 
                              $ink_3_result=$this->springtube_ink_master_model->select_one_active_record('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],'ink_id',$ink_3);

                              foreach ($ink_3_result as $ink_3_row) {

                                if($ink_3_row->ink_composition==1){

                                  $emailContent .= $ink_3_row->ink_desc;
                                         
                                }else{
                                  $emailContent .=$ink_3_row->ink_desc;
                                  $emailContent .='<p>';
                                  $emailContent .='<table>
                                              <tr class="heading">
                                              <th >MIXED_INK_DETAILS</th>
                                              <th  >INK%</th>
                                              <th  >GRAMS</th>
                                              <th  >KGS</th>
                                              </tr>';

                                  $ink_3_mixing_master_result=$this->springtube_ink_mixing_model->select_one_active_record('springtube_ink_mixing_master',$this->session->userdata['logged_in']['company_id'],'springtube_ink_mixing_master.ink_id',$ink_3);
                                    
                                    foreach ($ink_3_mixing_master_result as $ink_3_mixing_master_row) {                                 
                                          
                                      $data_mixing_3=array('mixing_id'=>$ink_3_mixing_master_row->mixing_id);

                                      $ink_3_mixing_details_result=$this->springtube_ink_mixing_model->active_details_records('springtube_ink_mixing_details',$data_mixing_3,$this->session->userdata['logged_in']['company_id']);


                                        $sum_perc=0;
                                        $sum_grams=0; 
                                        $sum_kgs=0;
                                        foreach ($ink_3_mixing_details_result as $ink_3_mixing_details_row) {

                                          $emailContent .='<tr>
                                          <td>'.$ink_3_mixing_details_row->ink_desc.'</td>
                                          <td>'.$ink_3_mixing_details_row->ink_perc.'%</td>
                                          <td>'.round(($row->abg1_ink_usage_3*$ink_3_mixing_details_row->ink_perc/100),2).' Grams</td>
                                          <td>'.round(($row->abg1_ink_usage_3*$ink_3_mixing_details_row->ink_perc/100),2).' Kgs</td>
                                          </tr>';

                                          $sum_perc+=$ink_3_mixing_details_row->ink_perc;
                                          $sum_grams+=round(($row->abg1_ink_usage_3*$ink_3_mixing_details_row->ink_perc/100),2);
                                                  
                                                
                                        }

                                        $emailContent .='<tr style="font-weight:bold;">
                                        <td><b>TOTAL</b></td><td >'.$sum_perc.'%</td><td>'.$sum_grams.'</td><td>'.($sum_grams/1000).'</td></tr>';
                                                     

                                    }

                                 $emailContent .='</table>';
                              }
                          }
                      }//ink1

                        $emailContent .='</td>
                      </tr>
                      <tr><td >INK_USAGE</td>
                          <td >'.$row->abg1_ink_usage_3.($row->abg1_ink_usage_3!=''?' Grams {'.round($row->abg1_ink_usage_3/1000,2).' Kgs}':'').'</td>
                      </tr>
                      <tr><td  >ANILOX</td>
                          <td  >';

                          $springtube_anilox_master_result=$this->common_model->select_one_active_record('springtube_anilox_master',$this->session->userdata['logged_in']['company_id'],'anilox_id',$row->abg1_anilox_3);
                          foreach ($springtube_anilox_master_result as $key => $springtube_anilox_master_row) {

                            $emailContent .= $springtube_anilox_master_row->anilox_lpi;
                              
                          }
                          //echo $row->abg1_anilox_1;
                          $emailContent .='</td>
                      </tr>
                      <tr><td  >METHOD</td>
                          <td>'.($row->abg1_applying_method_3!=''?($row->abg1_applying_method_3==1?'Plate Through':'Roller Through'):'').'</td style="border:1px solid #D9d9d9;">
                      </tr>
                      <tr><td  >TEETH</td>
                          <td  >'; 
                          $cylinder_master_result_3=$this->common_model->select_one_active_record('springtube_cylinder_master',$this->session->userdata['logged_in']['company_id'],'cylinder_id',$row->abg1_cylinder_teeth_3);
                          foreach ($cylinder_master_result_3 as $cylinder_master_row_3) {
                              $emailContent .= $cylinder_master_row_3->teeth;
                          }
                          $emailContent .='</td>
                      </tr>
                      <tr><td  >SR/FR</td>
                          <td  >'.($row->abg1_rotary_3!=''?($row->abg1_rotary_3==1?'[SR]-Semi Rotary':'[FR]-Full Rotary'):'').'</td>
                      </tr>
                      <tr><td  >UV POWER</td>
                          <td  >'.$row->abg1_uv_power_3.($row->abg1_uv_power_3!=''?' %':'').'</td>
                      </tr>
                      <tr>
                          <td >UV SPEED</td>
                          <td >'.$row->abg1_uv_speed_3.($row->abg1_uv_speed_3!=''?' %':'').'</td>
                      </tr>
                      <tr>
                          <td  >UV HOUR</td>
                          <td  >'.$row->abg1_uv_hours_3.($row->abg1_uv_hours_3!=''?' Hrs':'').'</td>
                      </tr>
                      <tr><td  >COMMENT</td>
                          <td style=" line-height:50px">'.$row->abg1_unit_3_comment.'</td>
                      </tr>
                  </table>
                </td>          

                <!-- INK 4 -->
                <td width="25%">
                  <table>
                    <tr>
                      <th colspan="2"><b>ABG 1-FLEXO UNIT-4</b></th>                        
                    </tr>
                      <tr>
                        <td style="width: 25%;">CARONA</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td style="height:400px;">COLOUR</td>
                          <td>';
                            $ink_4=$row->abg1_ink_id_4;

                            if($ink_4!=''|| $ink_4!='0'){

                              $ink_4_qty_gram=$row->abg1_ink_usage_4;
                                 
                              $ink_4_result=$this->springtube_ink_master_model->select_one_active_record('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],'ink_id',$ink_4);

                              foreach ($ink_4_result as $ink_4_row) {

                                if($ink_4_row->ink_composition==1){

                                  $emailContent .= $ink_4_row->ink_desc;
                                         
                                }else{
                                  $emailContent .=$ink_4_row->ink_desc;
                                  $emailContent .='<p>';
                                  $emailContent .='<table>
                                              <tr class="heading">
                                              <th >MIXED_INK_DETAILS</th>
                                              <th  >INK%</th>
                                              <th  >GRAMS</th>
                                              <th  >KGS</th>
                                              </tr>';

                                  $ink_4_mixing_master_result=$this->springtube_ink_mixing_model->select_one_active_record('springtube_ink_mixing_master',$this->session->userdata['logged_in']['company_id'],'springtube_ink_mixing_master.ink_id',$ink_4);
                                    
                                    foreach ($ink_4_mixing_master_result as $ink_4_mixing_master_row) {                                 
                                          
                                      $data_mixing_4=array('mixing_id'=>$ink_4_mixing_master_row->mixing_id);

                                      $ink_4_mixing_details_result=$this->springtube_ink_mixing_model->active_details_records('springtube_ink_mixing_details',$data_mixing_4,$this->session->userdata['logged_in']['company_id']);


                                        $sum_perc=0;
                                        $sum_grams=0; 
                                        $sum_kgs=0;
                                        foreach ($ink_4_mixing_details_result as $ink_4_mixing_details_row) {

                                          $emailContent .='<tr>
                                          <td>'.$ink_4_mixing_details_row->ink_desc.'</td>
                                          <td>'.$ink_4_mixing_details_row->ink_perc.'%</td>
                                          <td>'.round(($row->abg1_ink_usage_4*$ink_4_mixing_details_row->ink_perc/100),2).' Grams</td>
                                          <td>'.round(($row->abg1_ink_usage_4*$ink_4_mixing_details_row->ink_perc/100),2).' Kgs</td>
                                          </tr>';

                                          $sum_perc+=$ink_4_mixing_details_row->ink_perc;
                                          $sum_grams+=round(($row->abg1_ink_usage_4*$ink_4_mixing_details_row->ink_perc/100),2);
                                                  
                                                
                                        }

                                        $emailContent .='<tr style="font-weight:bold;">
                                        <td><b>TOTAL</b></td><td >'.$sum_perc.'%</td><td>'.$sum_grams.'</td><td>'.($sum_grams/1000).'</td></tr>';
                                                     

                                    }

                                 $emailContent .='</table>';
                              }
                          }
                      }//ink1

                        $emailContent .='</td>
                      </tr>
                      <tr><td >INK_USAGE</td>
                          <td >'.$row->abg1_ink_usage_4.($row->abg1_ink_usage_4!=''?' Grams {'.round($row->abg1_ink_usage_4/1000,2).' Kgs}':'').'</td>
                      </tr>
                      <tr><td  >ANILOX</td>
                          <td  >';

                          $springtube_anilox_master_result=$this->common_model->select_one_active_record('springtube_anilox_master',$this->session->userdata['logged_in']['company_id'],'anilox_id',$row->abg1_anilox_4);
                          foreach ($springtube_anilox_master_result as $key => $springtube_anilox_master_row) {

                            $emailContent .= $springtube_anilox_master_row->anilox_lpi;
                              
                          }
                          //echo $row->abg1_anilox_1;
                          $emailContent .='</td>
                      </tr>
                      <tr><td  >METHOD</td>
                          <td>'.($row->abg1_applying_method_4!=''?($row->abg1_applying_method_4==1?'Plate Through':'Roller Through'):'').'</td style="border:1px solid #D9d9d9;">
                      </tr>
                      <tr><td  >TEETH</td>
                          <td  >'; 
                          $cylinder_master_result_4=$this->common_model->select_one_active_record('springtube_cylinder_master',$this->session->userdata['logged_in']['company_id'],'cylinder_id',$row->abg1_cylinder_teeth_4);
                          foreach ($cylinder_master_result_4 as $cylinder_master_row_4) {
                              $emailContent .= $cylinder_master_row_4->teeth;
                          }
                          $emailContent .='</td>
                      </tr>
                      <tr><td  >SR/FR</td>
                          <td  >'.($row->abg1_rotary_4!=''?($row->abg1_rotary_4==1?'[SR]-Semi Rotary':'[FR]-Full Rotary'):'').'</td>
                      </tr>
                      <tr><td  >UV POWER</td>
                          <td  >'.$row->abg1_uv_power_4.($row->abg1_uv_power_4!=''?' %':'').'</td>
                      </tr>
                      <tr>
                          <td >UV SPEED</td>
                          <td >'.$row->abg1_uv_speed_4.($row->abg1_uv_speed_4!=''?' %':'').'</td>
                      </tr>
                      <tr>
                          <td  >UV HOUR</td>
                          <td  >'.$row->abg1_uv_hours_4.($row->abg1_uv_hours_4!=''?' Hrs':'').'</td>
                      </tr>
                      <tr><td  >COMMENT</td>
                          <td style=" line-height:50px">'.$row->abg1_unit_4_comment.'</td>
                      </tr>
                  </table>
                </td>           
         
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <br/>';

      $emailContent .='<table><tr><th colspan="17">DURST</th></tr>
        <tr>
          <th>CORONA DOSE</th>
          <th>PRINT CONFIG</th>
          <th>DEFAULT WHITE</th>
          <th>COLOUR POLICY</th>
          <th>SUBSTARTE DEF</th>
          <th>PRINT SPEED (MTR/MIN)</th>
          <th>UNWIND TENSION</th>
          <th>PINNING W</th>
          <th>PINNING K</th>
          <th>UV1</th>
          <th>UV1 HRS</th>
          <th>UV2</th>
          <th>UV2 HRS</th>
          <th>NITROGEN</th>
          <th>DIGITAL COST (EURO)</th>
          <th>TRACK (UPS)</th>

        </tr>
        <tr>
          <td>'.($row->durst_corona==''?'-':$row->durst_corona).'</td>
          <td>'.$row->print_confg.'</td>
          <td>'.$row->digital_white.'</td>
          <td>';
          $springtube_printing_color_policy_master_result=$this->common_model->select_one_active_record('springtube_printing_color_policy_master',$this->session->userdata['logged_in']['company_id'],'id',$row->colour_policy);
            foreach ($springtube_printing_color_policy_master_result as $key => $springtube_printing_color_policy_master_row) {                
              $emailContent .=$springtube_printing_color_policy_master_row->colour_policy;
            }
            $emailContent .='</td>

          <td>'.$row->substrate_defination.'</td>
          <td>'.$row->printing_speed.'</td>
          <td>'.$row->unwind_tension.'</td>
          <td>'.$row->pinning_w.($row->pinning_w!=''?' %':'').'</td>
          <td>'.$row->pinning_k.($row->pinning_k!=''?' %':'').'</td>
          <td>'.$row->durst_uv_curing_1.($row->durst_uv_curing_1!=''?' %':'').'</td>
          <td>'.$row->durst_uv_lamp_hrs_1.'</td>          
          <td>'.$row->durst_uv_curing_2.($row->durst_uv_curing_2!=''?' %':'').'</td>          
          <td>'.$row->durst_uv_lamp_hrs_2.'</td>
          <td>'.$row->nitrogen.'</td>
          <td>'.$row->digital_cost_in_euro.'</td>
          <td>'.$row->digital_cost_per_qty.'</td> 
          
        </tr>
    </table>
    <br/>';

    $emailContent .='
      <table width="100%">
        <tr>
          <td colspan="10">            
            <table>
              <tr>
                <!-- INK 5 -->
                <td width="25%">
                  <table>
                    <tr>
                      <th colspan="2"><b>ABG 2-FLEXO UNIT-1</b></th>                        
                    </tr>
                      <tr>
                        <td style="width: 25%;">CARONA</td>
                        <td>'.$row->abg2_carona_1.'</td>
                      </tr>
                      <tr>
                        <td style="height:400px;">COLOUR</td>
                          <td>';
                            $ink_5=$row->abg2_ink_id_1;

                            if($ink_5!=''|| $ink_5!='0'){

                              $ink_5_qty_gram=$row->abg2_ink_usage_1;
                                 
                              $ink_5_result=$this->springtube_ink_master_model->select_one_active_record('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],'ink_id',$ink_5);

                              foreach ($ink_5_result as $ink_5_row) {

                                if($ink_5_row->ink_composition==1){

                                  $emailContent .= $ink_5_row->ink_desc;
                                         
                                }else{
                                  $emailContent .=$ink_5_row->ink_desc;
                                  $emailContent .='<p>';
                                  $emailContent .='<table>
                                              <tr class="heading">
                                              <th >MIXED_INK_DETAILS</th>
                                              <th  >INK%</th>
                                              <th  >GRAMS</th>
                                              <th  >KGS</th>
                                              </tr>';

                                  $ink_5_mixing_master_result=$this->springtube_ink_mixing_model->select_one_active_record('springtube_ink_mixing_master',$this->session->userdata['logged_in']['company_id'],'springtube_ink_mixing_master.ink_id',$ink_5);
                                    
                                    foreach ($ink_5_mixing_master_result as $ink_5_mixing_master_row) {                                 
                                          
                                      $data_mixing_5=array('mixing_id'=>$ink_5_mixing_master_row->mixing_id);

                                      $ink_5_mixing_details_result=$this->springtube_ink_mixing_model->active_details_records('springtube_ink_mixing_details',$data_mixing_5,$this->session->userdata['logged_in']['company_id']);


                                        $sum_perc=0;
                                        $sum_grams=0; 
                                        $sum_kgs=0;
                                        foreach ($ink_5_mixing_details_result as $ink_5_mixing_details_row) {

                                          $emailContent .='<tr>
                                          <td>'.$ink_5_mixing_details_row->ink_desc.'</td>
                                          <td>'.$ink_5_mixing_details_row->ink_perc.'%</td>
                                          <td>'.round(($row->abg2_ink_usage_1*$ink_5_mixing_details_row->ink_perc/100),2).' Grams</td>
                                          <td>'.round(($row->abg2_ink_usage_1*$ink_5_mixing_details_row->ink_perc/100),2).' Kgs</td>
                                          </tr>';

                                          $sum_perc+=$ink_5_mixing_details_row->ink_perc;
                                          $sum_grams+=round(($row->abg2_ink_usage_1*$ink_5_mixing_details_row->ink_perc/100),2);
                                                  
                                                
                                        }

                                        $emailContent .='<tr style="font-weight:bold;">
                                        <td><b>TOTAL</b></td><td >'.$sum_perc.'%</td><td>'.$sum_grams.'</td><td>'.($sum_grams/1000).'</td></tr>';
                                                     

                                    }

                                 $emailContent .='</table>';
                              }
                          }
                      }//ink1

                        $emailContent .='</td>
                      </tr>
                      <tr><td >INK_USAGE</td>
                          <td >'.$row->abg2_ink_usage_1.($row->abg2_ink_usage_1!=''?' Grams {'.round($row->abg2_ink_usage_1/1000,2).' Kgs}':'').'</td>
                      </tr>
                      <tr><td  >ANILOX</td>
                          <td  >';

                          $springtube_anilox_master_result=$this->common_model->select_one_active_record('springtube_anilox_master',$this->session->userdata['logged_in']['company_id'],'anilox_id',$row->abg2_anilox_1);
                          foreach ($springtube_anilox_master_result as $key => $springtube_anilox_master_row) {

                            $emailContent .= $springtube_anilox_master_row->anilox_lpi;
                              
                          }
                          //echo $row->abg1_anilox_1;
                          $emailContent .='</td>
                      </tr>
                      <tr><td  >METHOD</td>
                          <td>'.($row->abg2_applying_method_1!=''?($row->abg2_applying_method_1==1?'Plate Through':'Roller Through'):'').'</td style="border:1px solid #D9d9d9;">
                      </tr>
                      <tr><td  >TEETH</td>
                          <td  >'; 
                          $cylinder_master_result_5=$this->common_model->select_one_active_record('springtube_cylinder_master',$this->session->userdata['logged_in']['company_id'],'cylinder_id',$row->abg2_cylinder_teeth_1);
                          foreach ($cylinder_master_result_5 as $cylinder_master_row_5) {
                              $emailContent .= $cylinder_master_row_5->teeth;
                          }
                          $emailContent .='</td>
                      </tr>
                      <tr><td  >SR/FR</td>
                          <td  >'.($row->abg2_rotary_1!=''?($row->abg2_rotary_1==1?'[SR]-Semi Rotary':'[FR]-Full Rotary'):'').'</td>
                      </tr>
                      <tr><td  >UV POWER</td>
                          <td  >'.$row->abg2_uv_power_1.($row->abg2_uv_power_1!=''?' %':'').'</td>
                      </tr>
                      <tr>
                          <td >UV SPEED</td>
                          <td >'.$row->abg2_uv_speed_1.($row->abg2_uv_speed_1!=''?' %':'').'</td>
                      </tr>
                      <tr>
                          <td  >UV HOUR</td>
                          <td  >'.$row->abg2_uv_hours_1.($row->abg2_uv_hours_1!=''?' Hrs':'').'</td>
                      </tr>
                      <tr><td  >COMMENT</td>
                          <td style=" line-height:50px">'.$row->abg2_unit_1_comment.'</td>
                      </tr>
                  </table>
                </td>

                <!-- INK 6 -->
                <td width="25%">
                  <table>
                    <tr>
                      <th colspan="2"><b>ABG 2-FLEXO UNIT-2</b></th>                        
                    </tr>
                      <tr>
                        <td style="width: 25%;">CARONA</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td style="height:400px;">COLOUR</td>
                          <td>';
                            $ink_6=$row->abg2_ink_id_2;

                            if($ink_6!=''|| $ink_6!='0'){

                              $ink_6_qty_gram=$row->abg2_ink_usage_2;
                                 
                              $ink_6_result=$this->springtube_ink_master_model->select_one_active_record('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],'ink_id',$ink_6);

                              foreach ($ink_6_result as $ink_6_row) {

                                if($ink_6_row->ink_composition==1){

                                  $emailContent .= $ink_6_row->ink_desc;
                                         
                                }else{
                                  $emailContent .=$ink_6_row->ink_desc;
                                  $emailContent .='<p>';
                                  $emailContent .='<table>
                                              <tr class="heading">
                                              <th>MIXED_INK_DETAILS</th>
                                              <th>INK%</th>
                                              <th>GRAMS</th>
                                              <th>KGS</th>
                                              </tr>';

                                  $ink_6_mixing_master_result=$this->springtube_ink_mixing_model->select_one_active_record('springtube_ink_mixing_master',$this->session->userdata['logged_in']['company_id'],'springtube_ink_mixing_master.ink_id',$ink_6);
                                    
                                    foreach ($ink_6_mixing_master_result as $ink_6_mixing_master_row) {                                 
                                          
                                      $data_mixing_6=array('mixing_id'=>$ink_6_mixing_master_row->mixing_id);

                                      $ink_6_mixing_details_result=$this->springtube_ink_mixing_model->active_details_records('springtube_ink_mixing_details',$data_mixing_6,$this->session->userdata['logged_in']['company_id']);


                                        $sum_perc=0;
                                        $sum_grams=0; 
                                        $sum_kgs=0;
                                        foreach ($ink_6_mixing_details_result as $ink_6_mixing_details_row) {

                                          $emailContent .='<tr>
                                          <td>'.$ink_6_mixing_details_row->ink_desc.'</td>
                                          <td>'.$ink_6_mixing_details_row->ink_perc.'%</td>
                                          <td>'.round(($row->abg2_ink_usage_2*$ink_6_mixing_details_row->ink_perc/100),2).' Grams</td>
                                          <td>'.round(($row->abg2_ink_usage_2*$ink_6_mixing_details_row->ink_perc/100),2).' Kgs</td>
                                          </tr>';

                                          $sum_perc+=$ink_6_mixing_details_row->ink_perc;
                                          $sum_grams+=round(($row->abg2_ink_usage_2*$ink_6_mixing_details_row->ink_perc/100),2);
                                                  
                                                
                                        }

                                        $emailContent .='<tr style="font-weight:bold;">
                                        <td><b>TOTAL</b></td><td >'.$sum_perc.'%</td><td>'.$sum_grams.'</td><td>'.($sum_grams/1000).'</td></tr>';
                                                     

                                    }

                                 $emailContent .='</table>';
                              }
                          }
                      }//ink1

                        $emailContent .='</td>
                      </tr>
                      <tr><td >INK_USAGE</td>
                          <td >'.$row->abg2_ink_usage_2.($row->abg2_ink_usage_2!=''?' Grams {'.round($row->abg2_ink_usage_2/1000,2).' Kgs}':'').'</td>
                      </tr>
                      <tr><td  >ANILOX</td>
                          <td  >';

                          $springtube_anilox_master_result=$this->common_model->select_one_active_record('springtube_anilox_master',$this->session->userdata['logged_in']['company_id'],'anilox_id',$row->abg2_anilox_2);
                          foreach ($springtube_anilox_master_result as $key => $springtube_anilox_master_row) {

                            $emailContent .= $springtube_anilox_master_row->anilox_lpi;
                              
                          }
                          //echo $row->abg1_anilox_1;
                          $emailContent .='</td>
                      </tr>
                      <tr><td  >METHOD</td>
                          <td>'.($row->abg2_applying_method_2!=''?($row->abg2_applying_method_2==1?'Plate Through':'Roller Through'):'').'</td style="border:1px solid #D9d9d9;">
                      </tr>
                      <tr><td  >TEETH</td>
                          <td  >'; 
                          $cylinder_master_result_2=$this->common_model->select_one_active_record('springtube_cylinder_master',$this->session->userdata['logged_in']['company_id'],'cylinder_id',$row->abg2_cylinder_teeth_2);
                          foreach ($cylinder_master_result_2 as $cylinder_master_row_2) {
                              $emailContent .= $cylinder_master_row_2->teeth;
                          }
                          $emailContent .='</td>
                      </tr>
                      <tr><td  >SR/FR</td>
                          <td  >'.($row->abg2_rotary_2!=''?($row->abg2_rotary_2==1?'[SR]-Semi Rotary':'[FR]-Full Rotary'):'').'</td>
                      </tr>
                      <tr><td  >UV POWER</td>
                          <td  >'.($row->is_extended_path=="YES"?$row->abg2_extended_uv_power_2.' %' :$row->abg2_uv_power_2.' %').'</td>
                      </tr>
                      <tr>
                          <td >UV SPEED</td>
                          <td >'.($row->is_extended_path=="YES"?$row->abg2_extended_uv_speed_2.' %':$row->abg2_uv_speed_2.' %').'</td>
                      </tr>
                      <tr>
                          <td  >UV HOUR</td>
                          <td  >'.($row->is_extended_path=="YES"?$row->abg2_extended_uv_hours_2.' Hrs' :$row->abg2_uv_hours_2.' Hrs').'</td>
                      </tr>
                      <tr><td style="line-height:30px">COMMENT</td>
                          <td >'.$row->abg2_unit_2_comment.'</td>
                      </tr>
                      <tr><td style="line-height:20px">EXT.WEBPATH</td>
                          <td >'.$row->is_extended_path.'</td>
                      </tr>
                  </table>
                </td>

                <!-- COLD FOIL 1 -->
                <td width="25%">
                  <table >
                    <tr class="heading">
                        <th colspan="2"><b>COLD FOIL 1</b></th>
                        
                    </tr>
                    <tr><td  ></td>
                        <td  >&nbsp;</td>
                    </tr>
                    <tr><td  style="height:400px;">NAME</td>
                        <td  >'.$this->common_model->get_article_name($cold_foil_1,$this->session->userdata['logged_in']['company_id']).'</td>
                    </tr>
                    <tr><td  >AREA</td>
                        <td  >'.($cold_foil_1!=''?$cold_foil_1_area.' SQMTR':'').'</td>
                    </tr>
                    <tr><td  >WIDTH</td>
                        <td  >'.($cold_foil_1!=''?$cold_foil_1_width.' MM':'').'</td>
                    </tr>
                    <tr><td  >LENGTH</td>
                        <td  >'.($cold_foil_1!=''?$cold_foil_1_length.' MTRS':'').'</td>
                    </tr>
                    <tr><td  >&nbsp;</td>
                        <td  >&nbsp;</td>
                    </tr>
                    <tr><td  >&nbsp;</td>
                        <td  >&nbsp;</td>
                    </tr>
                    <tr><td >&nbsp;</td>
                        <td  >&nbsp;</td>
                    </tr>
                    <tr><td  >&nbsp;</td>
                        <td  >&nbsp;</td>
                    </tr>
                    <tr><td  >&nbsp;</td>
                        <td >&nbsp;</td>
                    </tr>
                    <tr><td  style="line-height:50px">&nbsp;</td>
                        <td  >&nbsp;</td>
                    </tr>
                    
                        
                  </table>  
                </td>           

                <!-- COLD FOIL 2 -->
                <td width="25%">
                  <table >
                    <tr class="heading">
                        <th colspan="2"><b>COLD FOIL 2</b></th>
                        
                    </tr>
                    <tr><td  ></td>
                        <td  >&nbsp;</td>
                    </tr>
                    <tr><td style="height:400px;">NAME</td>
                        <td  >'.$this->common_model->get_article_name($cold_foil_2,$this->session->userdata['logged_in']['company_id']).'</td>
                    </tr>
                    <tr><td  >AREA</td>
                        <td  >'.($cold_foil_2!=''?$cold_foil_2_area.' SQMTR':'').'</td>
                    </tr>
                    <tr><td  >WIDTH</td>
                        <td  >'.($cold_foil_2!=''?$cold_foil_2_width.' MM':'').'</td>
                    </tr>
                    <tr><td  >LENGTH</td>
                        <td  >'.($cold_foil_2!=''?$cold_foil_2_length.' MTRS':'').'</td>
                    </tr>
                    <tr><td  >&nbsp;</td>
                        <td  >&nbsp;</td>
                    </tr>
                    <tr><td  >&nbsp;</td>
                        <td  >&nbsp;</td>
                    </tr>
                    <tr><td >&nbsp;</td>
                        <td  >&nbsp;</td>
                    </tr>
                    <tr><td  >&nbsp;</td>
                        <td  >&nbsp;</td>
                    </tr>
                    <tr><td  >&nbsp;</td>
                        <td >&nbsp;</td>
                    </tr>
                    <tr><td  style="line-height:50px">&nbsp;</td>
                        <td  >&nbsp;</td>
                    </tr>                    
                        
                  </table>  
                </td>            
         
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <br/>';

      $followup_result=$this->common_model->select_followup_records('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$row->jobcard_no.'@@@'.$job_id);

       $emailContent .='
       <table>
       <tr>
          <th colspan="5">FOLLOW UPS</th>
        </tr>
        <tr>
          <th >SR NO</th>
          <th >DATE</th>
          <th >FROM</th>
          <th >TO</th>
          <th >STATUS</th>
        </tr>';

        if($followup_result==FALSE){
          $emailContent .='<tr>
                <td colspan="6" >NO RECORD FOUND</td>
              </tr>';

        }else{
          
          foreach($followup_result as $followup_row){

            $emailContent .='<tr>
                                <td >'.$followup_row->transaction_no.'</td>                                
                                <td >'.$this->common_model->view_date($followup_row->followup_date,$this->session->userdata['logged_in']['company_id']).'</td>
                                <td >'.strtoupper($followup_row->from_user).'</td>
                                <td  >'.strtoupper($followup_row->to_user).'</td>
                                <td >'.($followup_row->status==99 ? 'SETTLED' : '').'
                                    '.($followup_row->status==999 && $followup_row->approved_flag==1 ? 'APPROVED' : '').'
                                    '.($followup_row->status==999 && $followup_row->approved_flag==2 ? 'REJECTED' : '').'
                                    '.($followup_row->status==1 ? 'PENDING' : '').'</td>
                            </tr>';

          }
        }
      $emailContent .='</table><br/>';

      $taken_data=array(
        'job_id'=>$job_id,
        'transaction_no'=>$transaction_no,
        'jobcard_no'=>$row->jobcard_no,
        'user_id'=>$approving_user,
        'company_id'=>$this->session->userdata['logged_in']['company_id'],

      );

      $token=$this->objOfJwt->GenerateToken($taken_data);

      //header('Content-Type : application/json');
      //echo json_encode(array('Token'=>$token));
      $emailContent .='
       <table>
       <tr>
          <td style="text-align:center;">
            <button class="btn success">
              <a href="http://123.252.171.218:3030/erp/index.php/springtube_printing_jobsetup_app/approved/'.$token.'" ><b>Approve</b>
              </a>
            </button>
             
          </td>
          <!--<td style="text-align:center;">
            <button class="btn danger">
              <a href="http://123.252.171.218:3030/erp/index.php/springtube_printing_jobsetup_app/notapproved/'.$token.'" ><b>Reject</b>
              </a>
             </button>
          </td>
          -->
         <td style="text-align:center;">
            <button class="btn danger">
              <a href="'.base_url().'/index.php/springtube_printing_jobsetup_app/notapproved/'.$token.'" ><b>Reject</b>
              </a>
             </button>
          </td>
          
        </tr> 
        </table>
      </div>'; 

    //$emailContent .= "<tr> <td style='background:white;color: white;padding: 2%;text-align: center;font-size: 11px;'></td></tr></table></body></html>";

// Email Setup--------------------------------------------------------------

      $smtp_user=$this->config->item('smtp_user');
      $smtp_pass=$this->config->item('smtp_pass');
      $config['protocol'] = 'smtp';
      $config['smtp_host'] = 'ssl://smtp.googlemail.com';
      $config['smtp_port'] = 465;
      $config['smtp_timeout'] = 60;
      $config['charset'] = 'utf-8';
      $config['mailtype'] = 'html';
      $config['validation'] = 'TRUE';
      // $config['smtp_user']=$smtp_user;
      // $config['smtp_pass']=$smtp_pass;
      // $config['smtp_user']='springprint@3d-neopac.com';
      // $config['smtp_pass']='spring@321';

      $config['smtp_user']='auto.mailer@3d-neopac.com';
      $config['smtp_pass']='auto@202021';

      $cc=array("eknath.parkhe@3d-neopac.com","pravin.shinde@3d-neopac.com");
      
      $this->load->library('email', $config);
      //$this->email->from($employee_row->mailbox);
      //$this->email->from('eknath.parkhe@3d-neopac.com');
      //$this->email->from('springprint@3d-neopac.com');
      $this->email->from('auto.mailer@3d-neopac.com');
      //$this->email->to("eknath.parkhe@3d-neopac.com");
      $this->email->to("atul.singh@3d-neopac.com");
      //$this->email->to("springaw@3d-neopac.com");
      $this->email->cc($cc);
      //$this->email->cc("pravin.shinde@3d-neopac.com");
      $this->email->subject("Spring Printing Jobsetup :-".$row->jobcard_no);
      $this->email->message($emailContent);
      $this->email->set_mailtype("html");

      if ($this->email->send()) {
        $data['note']= 'Email send succesfully!';
        return 1;
      } 
      else{
        $data['error']='Email send failed!';
        return 0;

      }

    } 
    

  } 

  
}