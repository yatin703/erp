<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tube_with_cap_new extends CI_Controller {

  function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('specification_model');
      $this->load->model('tube_with_cap_specification_model');
      $this->load->model('article_model');
      $this->load->model('customer_model');
      $this->load->model('supplier_model');
      $this->load->model('artwork_model');
      $this->load->model('sub_group_model');
      $this->load->model('second_sub_group_model');
      $this->load->model('sales_order_book_model');
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
            $table='specification_sheet';
            include('pagination-tube-with-cap.php');
            $data['specification']=$this->tube_with_cap_specification_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
           
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


  function view(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $data['specification']=$this->tube_with_cap_specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->uri->segment(3),'specification_sheet.spec_version_no',$this->uri->segment(4));

            $spec_lang=array();
            $spec_lang['spec_id']=$this->uri->segment(3);
            $spec_lang['spec_version_no']=$this->uri->segment(4);

            $data['specification_sheet_lang']=$this->common_model->select_active_records_where('specification_sheet_lang',$this->session->userdata['logged_in']['company_id'],$spec_lang);
           
           $data['specification_sleeve_details']=$this->tube_with_cap_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$this->uri->segment(3),'specification_sheet_details.spec_version_no',$this->uri->segment(4),'item_group_id','3','srd_id','asc');

            $data['specification_shoulder_details']=$this->tube_with_cap_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$this->uri->segment(3),'specification_sheet_details.spec_version_no',$this->uri->segment(4),'item_group_id','4','srd_id','asc');

            $data['specification_cap_details']=$this->tube_with_cap_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$this->uri->segment(3),'specification_sheet_details.spec_version_no',$this->uri->segment(4),'item_group_id','5','srd_id','asc');

            $data['specification_label_details']=$this->tube_with_cap_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$this->uri->segment(3),'specification_sheet_details.spec_version_no',$this->uri->segment(4),'item_group_id','6','srd_id','asc');

            $data['followup']=$this->common_model->select_followup_records('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$this->uri->segment(3).'@@@'.$this->uri->segment(4));

            $data['company']=$this->common_model->select_one_active_record('company_master',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);
            $data['company_details']=$this->common_model->select_one_active_record('company_system_parameters',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);

            $this->load->view('Print/header',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/view-form',$data);
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



  function create_single_layer_with_cap(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

            $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
            $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
            $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);

            $dataa=array('article_main_group.main_group_id'=>'5');
            $data['label']=$this->article_model->active_record_search('article',$dataa,$this->session->userdata['logged_in']['company_id']);
            $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);

            $data['page_name']='home';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
            $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/create-single-form',$data);
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


  function create_two_layer_with_cap(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

            $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
            $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
            $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);

            $dataa=array('article_main_group.main_group_id'=>'5');
            $data['label']=$this->article_model->active_record_search('article',$dataa,$this->session->userdata['logged_in']['company_id']);
            $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/create-two-form',$data);
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

  function save_single_layer_with_cap(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $this->form_validation->set_rules('customer','Customer' ,'required|trim|xss_clean|callback_customer_check');
            $this->form_validation->set_rules('article_no','Article No' ,'required|trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('spec_version_no','Spec Version No' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('artwork_final_version_no','Artwork Version No' ,'trim|xss_clean');

            if($this->input->post('sleeve_dia')){

              $this->form_validation->set_rules('sleeve_dia','Sleeve Dia' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sleeve_length','Sleeve Length' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');
              $this->form_validation->set_rules('gauge','Gauge' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');
              $this->form_validation->set_rules('print_type','Print Type' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sl_masterbatch','Sleeve Masterbatch' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sl_mb_supplier','Sleeve Masterbatch Supplier','trim|xss_clean|callback_supplier_check');
              $this->form_validation->set_rules('sl_mb_per','Sleeve Masterbatch %' ,'required|trim|xss_clean|numeric|max_length[3]');

              $this->form_validation->set_rules('sl_ldpe_per','Sleeve Ldpe %' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_check');
              $this->form_validation->set_rules('sl_lldpe_per','Sleeve Lldpe %' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_check');
              $this->form_validation->set_rules('sl_hdpe_per','Sleeve Hdpe %' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_check');

              if(!empty($this->input->post('sl_ldpe_per'))){
                $this->form_validation->set_rules('sl_ldpe','Sleeve Ldpe' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_lldpe_per'))){
                $this->form_validation->set_rules('sl_lldpe','Sleeve Lldpe' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_hdpe_per'))){
                $this->form_validation->set_rules('sl_hdpe','Sleeve Hdpe' ,'trim|xss_clean|required');
              }
            
            }
            
            if($this->input->post('shoulder')){
            
              $this->form_validation->set_rules('shoulder','Shoulder' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('shoulder_orifice','Shoulder Orifice' ,'trim|xss_clean');
              $this->form_validation->set_rules('sh_masterbatch','Shoulder Masterbatch' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sh_mb_supplier','Shoulder Masterbatch Supplier' ,'trim|xss_clean|callback_supplier_check');
              $this->form_validation->set_rules('sh_mb_per','Shoulder Masterbatch %' ,'required|trim|xss_clean|numeric|max_length[3]');
              $this->form_validation->set_rules('sh_hdpe_one_per','Shoulder HDPE %' ,'trim|xss_clean|is_natural|max_length[3]|callback_shoulder_per_check');
              $this->form_validation->set_rules('sh_hdpe_two_per','Shoulder HDPE %' ,'trim|xss_clean|is_natural|max_length[3]|callback_shoulder_per_check');

               if(!empty($this->input->post('sh_hdpe_one_per'))){
                $this->form_validation->set_rules('sh_hdpe_one','Shoulder Hdpe' ,'trim|xss_clean|required');
                }if(!empty($this->input->post('sh_hdpe_two_per'))){
                $this->form_validation->set_rules('sh_hdpe_two','Shoulder Hdpe' ,'trim|xss_clean|required');
                }

            }

            if(!empty($this->input->post('cap_spec_no'))){
              $this->form_validation->set_rules('cap_spec_no','Cap Spec No' ,'trim|xss_clean|required|exact_length[9]');
              $this->form_validation->set_rules('cap_spec_version_no','Cap Spec Version' ,'trim|xss_clean|required');
            }


            $this->form_validation->set_rules('label_article_no','Label Article No' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('cap_article_no','Cap Article No' ,'trim|xss_clean|callback_article_check');

            
            

            if($this->form_validation->run()==FALSE){
              
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
            
            $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
            $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);

            $dataa=array('article_main_group.main_group_id'=>'5');
            $data['label']=$this->article_model->active_record_search('article',$dataa,$this->session->userdata['logged_in']['company_id']);
            $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-single-form',$data);
              $this->load->view('Home/footer');
            }else{

              if(!empty($this->input->post('customer'))){
                $customer_arr=explode('//',$this->input->post('customer'));
              }

              if(!empty($this->input->post('article_no'))){
                $article_no_arr=explode('//',$this->input->post('article_no'));
              }

              if(!empty($this->input->post('cap_article_no'))){
                $cap_article_no_arr=explode('//',$this->input->post('cap_article_no'));
              }

              

              if(!empty($this->input->post('cap_spec_no'))){
                $cap_article_no_arr[2]=$this->input->post('cap_spec_no');
                $cap_article_no_arr[3]=$this->input->post('cap_spec_version_no');
              }


              $data=array('spec_id'=>$cap_article_no_arr[2],
                  'spec_version_no'=>$cap_article_no_arr[3]);
                $data['specs_details']=$this->sales_order_book_model->select_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data);
                if($data['specs_details']==FALSE){
                  $CAP_DIA="";
                  $CAP_STYLE="";
                  $CAP_MOLD_FINISH="";
                  $CAP_ORIFICE="";
                  $CAP_MASTER_BATCH="";
                  $CAP_MB_PERC="";
                  $CAP_MB_SUPPLIER="";
                  $CAP_PP="";
                  $CAP_PP_PERC="";
                  $CAP_FOIL_COLOR="";
                  $CAP_FOIL_WIDTH="";
                  $CAP_FOIL_DIST_FROM_BOT="";
                  $CAP_SHRINK_SLEEVE="";
                  $CAP_SHRINK_SLEEVE_NAME="";
                }else{
                  foreach($data['specs_details'] as $specs_details_row){
                  $CAP_DIA=$specs_details_row->CAP_DIA;
                  $CAP_STYLE=$specs_details_row->CAP_STYLE;
                  $CAP_MOLD_FINISH=$specs_details_row->CAP_MOLD_FINISH;
                  $CAP_ORIFICE=$specs_details_row->CAP_ORIFICE;
                  $CAP_MASTER_BATCH=$specs_details_row->CAP_MASTER_BATCH;
                  $CAP_MB_PERC=$specs_details_row->CAP_MB_PERC;
                  $CAP_MB_SUPPLIER=$specs_details_row->CAP_MB_SUPPLIER;
                  $CAP_PP=$specs_details_row->CAP_PP;
                  $CAP_PP_PERC=$specs_details_row->CAP_PP_PERC;
                  $CAP_FOIL_COLOR=$specs_details_row->CAP_FOIL_COLOR;
                  $CAP_FOIL_WIDTH=$specs_details_row->CAP_FOIL_WIDTH;
                  $CAP_FOIL_DIST_FROM_BOT=$specs_details_row->CAP_FOIL_DIST_FROM_BOT;
                  $CAP_SHRINK_SLEEVE=$specs_details_row->CAP_SHRINK_SLEEVE;
                  $CAP_SHRINK_SLEEVE_NAME=$specs_details_row->CAP_SHRINK_SLEEVE_NAME;
                  }
                }
                
              if(!empty($this->input->post('label_article_no'))){
                $label_article=explode('//',$this->input->post('label_article_no'));
              }else{
                $label_article[1]="";
              }


              if(!empty($this->input->post('sleeve_dia'))){
                $sleeve_dia=explode('//',$this->input->post('sleeve_dia'));
              }else{
                $sleeve_dia[0]='';
              }

              if(!empty($this->input->post('sl_mb_supplier'))){
                $sl_mb_supplier=explode('//',$this->input->post('sl_mb_supplier'));
              }else{
                $sl_mb_supplier[1]='';
              }

              if(!empty($this->input->post('sh_mb_supplier'))){
                $sh_mb_supplier=explode('//',$this->input->post('sh_mb_supplier'));
              }else{
                $sh_mb_supplier[1]='';
              }

              

              if(!empty($this->input->post('shoulder'))){
                $shoulder=explode('//',$this->input->post('shoulder'));
              }else{
                $shoulder[0]='';
              }

              if(!empty($this->input->post('shoulder_orifice'))){
                $shoulder_orifice=explode('//',$this->input->post('shoulder_orifice'));
              }else{
                $shoulder_orifice[0]='';
                $shoulder_orifice[1]='';
              }


              if(!empty($this->input->post('cap_mb_supplier'))){
                $cap_mb_supplier=explode('//',$this->input->post('cap_mb_supplier'));
              }else{
                $cap_mb_supplier[1]='';
              }

              if(!empty($this->input->post('shoulder'))){
                $shoulder=explode('//',$this->input->post('shoulder'));
              }else{
                $shoulder[0]='';
              }

              if(!empty($this->input->post('shoulder_orifice'))){
                $shoulder_orifice=explode('//',$this->input->post('shoulder_orifice'));
              }else{
                $shoulder_orifice[0]='';
              }

              if(!empty($this->input->post('cap_type'))){
                $cap_type=explode('//',$this->input->post('cap_type'));
              }else{
                $cap_type[0]='';
              }

              if(!empty($this->input->post('cap_finish'))){
                $cap_finish=explode('//',$this->input->post('cap_finish'));
              }else{
                $cap_finish[0]='';
              }

              if(!empty($this->input->post('cap_dia'))){
                $cap_dia=explode('//',$this->input->post('cap_dia'));
              }else{
                $cap_dia[0]='';
              }

              if(!empty($this->input->post('cap_orifice'))){
                $cap_orifice=explode('//',$this->input->post('cap_orifice'));
              }else{
                $cap_orifice[0]='';
              }

            $data['cap_diameter_master']=$this->common_model->select_one_active_record('cap_diameter_master',$this->session->userdata['logged_in']['company_id'],'cap_dia',$CAP_DIA);
            //echo $this->db->last_query();
            if($data['cap_diameter_master']==FALSE){
              $cap_dia_id="";
            }else{
             foreach($data['cap_diameter_master'] as $cap_diameter_master_row){
              $cap_dia_id=$cap_diameter_master_row->cap_dia_id;
             }
           }

            $data['cap_orifice_master']=$this->common_model->select_one_active_record('cap_orifice_master',$this->session->userdata['logged_in']['company_id'],'cap_orifice',$CAP_ORIFICE);
            if($data['cap_orifice_master']==FALSE){
              $cap_orifice_id="";
            }else{
              foreach($data['cap_orifice_master'] as $cap_orifice_master_row){
              $cap_orifice_id=$cap_orifice_master_row->cap_orifice_id;
               }
             }

             $data['cap_types_master']=$this->common_model->select_one_active_record('cap_types_master',$this->session->userdata['logged_in']['company_id'],'cap_type',$CAP_STYLE);
              if($data['cap_types_master']==FALSE){
                $cap_type_id="";
                }else{
                foreach($data['cap_types_master'] as $cap_types_master_row){
                  $cap_type_id=$cap_types_master_row->cap_type_id;
                 }
              }

             $data['cap_finish_master']=$this->common_model->select_one_active_record('cap_finish_master',$this->session->userdata['logged_in']['company_id'],'cap_finish',$CAP_MOLD_FINISH);
             if($data['cap_finish_master']==FALSE){
              $cap_finish_id="";
              }else{
              foreach($data['cap_finish_master'] as $cap_finish_master_row){
                $cap_finish_id=$cap_finish_master_row->cap_finish_id;
              }
              }



             
             $combination_data=array('sleeve_id'=>$sleeve_dia[1],
              'shld_type_id'=>$shoulder[1],
              'shld_orifice_id'=>$shoulder_orifice[1],
              'cap_dia_id'=>$cap_dia_id,
              'cap_orifice_id'=>$cap_orifice_id,
              'cap_type_id'=>$cap_type_id,
              'cap_finish_id'=>$cap_finish_id);

             $this->load->model('shoulder_orifice_dependancy_model');
             $this->shoulder_orifice_dependancy_model->select_one_active_combination_record('shoulder_orifice_dependancy',$this->session->userdata['logged_in']['company_id'],$combination_data);
             //echo $this->db->last_query();
             if($this->shoulder_orifice_dependancy_model->select_one_active_combination_record('shoulder_orifice_dependancy',$this->session->userdata['logged_in']['company_id'],$combination_data)>0){



              //echo "correct combination";
             

             


             

              $data['spec_version']=$this->specification_model->select_specification_verion_no('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$article_no_arr[1]);
              foreach ($data['spec_version'] as $spec_version_row) {

                if($spec_version_row->spec_version_no==NULL){
                  $max_pkey=0;
                  $result=$this->common_model->select_max_pkey('specification_sheet','spec_id',$this->session->userdata['logged_in']['company_id']); 
                  foreach($result as $row){
                    $max_pkey=$row->spec_id;
                    $max_pkey=substr($max_pkey,4);
                    $max_pkey=$max_pkey+1;
                    $spec_no=str_pad($max_pkey,4,0,STR_PAD_LEFT);
                    $spec_no="SPEC".$spec_no;
                  }
                  $spec_version_no=1;
                }else{
                  $spec_version_no=$spec_version_row->spec_version_no;
                  $spec_no=$spec_version_row->spec_id;
                }
              }

              $artwork_no="";
              $artwork_version_no="";
              if(!empty($this->input->post('artwork_final_version_no'))){

                $data['artwork_final_version_no']=$this->artwork_model->select_artwork_final_version('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'article_no',$article_no_arr[1],'final_approval_flag','1','archive<>','1','ad_date','desc','ad_id','desc','version_no','desc');
                foreach ($data['artwork_final_version_no'] as $artwork_final_version_no_row){
                   $artwork_no=$artwork_final_version_no_row->ad_id;
                   $artwork_version_no=$artwork_final_version_no_row->version_no;
                }

              }
              

              $data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$customer_arr[1]);
              foreach ($data['customer'] as $customer_row) {
                $property=$customer_row->property_id;
              }

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                    'spec_id'=>$spec_no,
                    'spec_created_date'=>date('Y-m-d'),
                    'spec_version_no'=>$spec_version_no,
                    'property_id'=>$property,
                    'adr_company_id'=>$customer_arr[1],
                    'article_no'=>$article_no_arr[1],
                    'pending_flag'=>'0',
                    'final_approval_flag'=>'0',
                    'user_id'=>$this->session->userdata['logged_in']['user_id'],
                    'ad_id'=>$artwork_no,
                    'version_no'=>$artwork_version_no,
                    'dyn_qty_present'=>'SLEEVE|1^^^SHOULDER|1^^^CAP|1',
                    );

              $result=$this->common_model->save('specification_sheet',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'164',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DIA',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$sleeve_dia[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_1',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'165',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LENGTH',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('sleeve_length')." MM",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_2',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'166',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DRAWING',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_3',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'167',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'GUAGE',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('gauge')." MIC",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_4',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'168',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'material'=>'1',
                'item_group_material'=>'12',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>$sl_mb_supplier[1],
                'mat_info'=>$this->input->post('sl_mb_per')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_masterbatch'),
                'srd_id'=>'1_5_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
            

              

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'7',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_ldpe_per')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_ldpe'),
                'srd_id'=>'1_6_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

            

              
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'8',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_lldpe_per')."%",
                'mat_article_no'=>$this->input->post('sl_lldpe'),
                'property_id'=>'',
                'srd_id'=>'1_6_1',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
            

            

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_hdpe_per')."%",
                'mat_article_no'=>$this->input->post('sl_hdpe'),
                'property_id'=>'',
                'srd_id'=>'1_6_2',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

            
              


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'185',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'PRINT TYPE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$this->input->post('print_type'),
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_7',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'170',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'DRAWING',
                'item_group_material'=>'',
                'material'=>'0',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_1',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'171',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'STYLE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$shoulder[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_2',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'172',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'NECK TYPE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$shoulder[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_3',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'173',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'ORIFICE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$shoulder_orifice[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_4',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'174',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'PEEL OFF TE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_5',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'175',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'material'=>'1',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'item_group_material'=>'12',
                'supplier_no'=>$sh_mb_supplier[1],
                'mat_info'=>$this->input->post('sh_mb_per')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sh_masterbatch'),
                'srd_id'=>'2_6_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              
                $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'176',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'parameter_value'=>'',
                'material'=>'1',
                'item_group_material'=>'6',
                'supplier_no'=>'',
                'relating_master_value'=>'',
                'mat_info'=>$this->input->post('sh_hdpe_one_per')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sh_hdpe_one'),
                'srd_id'=>'2_7_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
              
              

              
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'176',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sh_hdpe_two_per')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sh_hdpe_two'),
                'srd_id'=>'2_7_1',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
            

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'186',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'material'=>'1',
                'item_group_material'=>'106',
                'parameter_name'=>'SHOULDER FOIL TAG',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('shoulder_foil_tag'),
                'srd_id'=>'2_8',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'177',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'CSPEC',
                'item_group_material'=>'',
                'parameter_value'=>$cap_article_no_arr[2]."//".$cap_article_no_arr[3],
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_1',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);



              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'178',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'STYLE',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$CAP_STYLE,
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_2',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'179',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'MOLD FINISH',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$CAP_MOLD_FINISH,
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_3',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'180',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'DIAMETER',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$CAP_DIA,
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_4',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'181',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'SHRINK SLEEVE',
                'parameter_value'=>$CAP_SHRINK_SLEEVE_NAME,
                'item_group_material'=>'213',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'material'=>'1',
                'mat_article_no'=>$CAP_SHRINK_SLEEVE,
                'srd_id'=>'3_5',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'182',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'ORIFICE',
                'parameter_value'=>'',
                'item_group_material'=>'',
                'relating_master_value'=>$CAP_ORIFICE,
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_6',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'183',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'material'=>'1',
                'item_group_material'=>'12',
                'property_id'=>'',
                'supplier_no'=>$CAP_MB_SUPPLIER,
                'mat_info'=>$CAP_MB_PERC,
                'mat_article_no'=>$CAP_MASTER_BATCH,
                'srd_id'=>'3_7_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'184',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'material'=>'1',
                'supplier_no'=>'',
                'property_id'=>'',
                'item_group_material'=>'9',
                'mat_info'=>$CAP_PP_PERC,
                'mat_article_no'=>$CAP_PP,
                'srd_id'=>'3_8_1',
                'item_group_material_flag'=>'2',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'187',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'CAP FOIL COLOR',
                'item_group_material'=>'71',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>$CAP_FOIL_COLOR,
                'material'=>'1',
                'supplier_no'=>'',
                'property_id'=>'',
                'parameter_value'=>'',
                'srd_id'=>'3_9',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'188',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'CAP FOIL WIDTH',
                'item_group_material'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'material'=>'0',
                'parameter_value'=>$CAP_FOIL_WIDTH,
                'srd_id'=>'3_10',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

            $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
              'spec_id'=>$spec_no,
              'disp_id'=>'189',
              'item_group_id'=>'5',
              'item_group_flag'=>'1',
              'parameter_name'=>'C.FOIL DIST FROM BOT',
              'item_group_material'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
              'material'=>'0',
              'parameter_value'=>$CAP_FOIL_DIST_FROM_BOT,
              'srd_id'=>'3_11',
              'item_group_material_flag'=>'0',
              'dyn_qty_no'=>'1',
              'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
              'spec_version_no'=>$spec_version_no,
              'layer_no'=>'1');
            $result=$this->common_model->save('specification_sheet_details',$data);


            $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
              'spec_id'=>$spec_no,
              'disp_id'=>'190',
              'item_group_id'=>'6',
              'item_group_flag'=>'1',
              'parameter_name'=>'LABEL',
              'item_group_material'=>'5',
              'relating_master_value'=>'',
              'supplier_no'=>'',
              'mat_info'=>'',
              'property_id'=>'',
              'mat_article_no'=>$label_article[1],
              'material'=>'1',
              'parameter_value'=>'',
              'srd_id'=>'3_12',
              'item_group_material_flag'=>'1',
              'dyn_qty_no'=>'1',
              'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
              'spec_version_no'=>$spec_version_no,
              'layer_no'=>'1');
            $result=$this->common_model->save('specification_sheet_details',$data);


            $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
              'spec_id'=>$spec_no,
              'lang_comments'=>$this->input->post('comment'),
              'language_id'=>$this->session->userdata['logged_in']['language_id'],
              'spec_version_no'=>$spec_version_no);
            $result=$this->common_model->save('specification_sheet_lang',$data);

              $data['note']='Create Transaction Completed';
              header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

              }else{
              $data['error']='Wrong combination';
             }

             $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

              
                  $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

                  $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
                  $dataa=array('article_main_group.main_group_id'=>'5');
                  $data['label']=$this->article_model->active_record_search('article',$dataa,$this->session->userdata['logged_in']['company_id']);
                  $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
                  $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
                  $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
                  $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                  $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);

                  $dataa=array('article_main_group.main_group_id'=>'5');
                  $data['label']=$this->article_model->active_record_search('article',$dataa,$this->session->userdata['logged_in']['company_id']);
                  $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                  $this->load->view(ucwords($this->router->fetch_class()).'/create-single-form',$data);
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

  function save_single_layer_with_cap_copy(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $this->form_validation->set_rules('customer','Customer' ,'required|trim|xss_clean|callback_customer_check');
            $this->form_validation->set_rules('article_no','Article No' ,'required|trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('spec_version_no','Spec Version No' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('artwork_final_version_no','Artwork Version No' ,'trim|xss_clean');

            if($this->input->post('sleeve_dia') || $this->input->post('sleeve_length') || $this->input->post('gauge') || $this->input->post('print_type') || $this->input->post('sl_masterbatch') || $this->input->post('sl_mb_per')){

              $this->form_validation->set_rules('sleeve_dia','Sleeve Dia' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sleeve_length','Sleeve Length' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');
              $this->form_validation->set_rules('gauge','Gauge' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');
              $this->form_validation->set_rules('print_type','Print Type' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sl_masterbatch','Sleeve Masterbatch' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sl_mb_supplier','Sleeve Masterbatch Supplier','trim|xss_clean|callback_supplier_check');
              $this->form_validation->set_rules('sl_mb_per','Sleeve Masterbatch %' ,'required|trim|xss_clean|numeric|max_length[3]');

              $this->form_validation->set_rules('sl_ldpe_per','Sleeve Ldpe %' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_check');
              $this->form_validation->set_rules('sl_lldpe_per','Sleeve Lldpe %' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_check');
              $this->form_validation->set_rules('sl_hdpe_per','Sleeve Hdpe %' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_check');

              if(!empty($this->input->post('sl_ldpe_per'))){
                $this->form_validation->set_rules('sl_ldpe','Sleeve Ldpe' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_lldpe_per'))){
                $this->form_validation->set_rules('sl_lldpe','Sleeve Lldpe' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_hdpe_per'))){
                $this->form_validation->set_rules('sl_hdpe','Sleeve Hdpe' ,'trim|xss_clean|required');
              }
              

            }
            
            if($this->input->post('shoulder') || $this->input->post('shoulder_orifice') || $this->input->post('sh_masterbatch') || $this->input->post('sh_mb_per')){
            
              $this->form_validation->set_rules('shoulder','Shoulder' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('shoulder_orifice','Shoulder Orifice' ,'trim|xss_clean');
              $this->form_validation->set_rules('sh_masterbatch','Shoulder Masterbatch' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sh_mb_supplier','Shoulder Masterbatch Supplier' ,'trim|xss_clean|callback_supplier_check');
              $this->form_validation->set_rules('sh_mb_per','Shoulder Masterbatch %' ,'required|trim|xss_clean|numeric|max_length[3]');
              $this->form_validation->set_rules('sh_hdpe_one_per','Shoulder HDPE %' ,'trim|xss_clean|is_natural|max_length[3]|callback_shoulder_per_check');
              $this->form_validation->set_rules('sh_hdpe_two_per','Shoulder HDPE %' ,'trim|xss_clean|is_natural|max_length[3]|callback_shoulder_per_check');

               if(!empty($this->input->post('sh_hdpe_one_per'))){
                $this->form_validation->set_rules('sh_hdpe_one','Shoulder Hdpe' ,'trim|xss_clean|required');
                }if(!empty($this->input->post('sh_hdpe_two_per'))){
                $this->form_validation->set_rules('sh_hdpe_two','Shoulder Hdpe' ,'trim|xss_clean|required');
                }

            }

            if(!empty($this->input->post('cap_spec_no'))){
              $this->form_validation->set_rules('cap_spec_no','Cap Spec No' ,'trim|xss_clean|required|exact_length[9]');
              $this->form_validation->set_rules('cap_spec_version_no','Cap Spec Version' ,'trim|xss_clean|required');
            }


            $this->form_validation->set_rules('label_article_no','Label Article No' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('cap_article_no','Cap Article No' ,'trim|xss_clean|callback_article_check');

            
            

            if($this->form_validation->run()==FALSE){
              
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);
            
            $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
            $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
            $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);

            $dataa=array('article_main_group.main_group_id'=>'5');
            $data['label']=$this->article_model->active_record_search('article',$dataa,$this->session->userdata['logged_in']['company_id']);
            $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);

            $data['specification']=$this->specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->input->post('spec_id'),'specification_sheet.spec_version_no',$this->input->post('copy_version_no'));

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/single-copy-form',$data);
              $this->load->view('Home/footer');
            }else{

              if(!empty($this->input->post('customer'))){
                $customer_arr=explode('//',$this->input->post('customer'));
              }

              if(!empty($this->input->post('article_no'))){
                $article_no_arr=explode('//',$this->input->post('article_no'));
              }

              if(!empty($this->input->post('cap_article_no'))){
                $cap_article_no_arr=explode('//',$this->input->post('cap_article_no'));
              }

              if(!empty($this->input->post('cap_spec_no'))){
                $cap_article_no_arr[2]=$this->input->post('cap_spec_no');
                $cap_article_no_arr[3]=$this->input->post('cap_spec_version_no');
              }


              $data=array('spec_id'=>$cap_article_no_arr[2],
                  'spec_version_no'=>$cap_article_no_arr[3]);
                $data['specs_details']=$this->sales_order_book_model->select_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data);
                if($data['specs_details']==FALSE){
                  $CAP_DIA="";
                  $CAP_STYLE="";
                  $CAP_MOLD_FINISH="";
                  $CAP_ORIFICE="";
                  $CAP_MASTER_BATCH="";
                  $CAP_MB_PERC="";
                  $CAP_MB_SUPPLIER="";
                  $CAP_PP="";
                  $CAP_PP_PERC="";
                  $CAP_FOIL_COLOR="";
                  $CAP_FOIL_WIDTH="";
                  $CAP_FOIL_DIST_FROM_BOT="";
                  $CAP_SHRINK_SLEEVE="";
                  $CAP_SHRINK_SLEEVE_NAME="";
                }else{
                  foreach($data['specs_details'] as $specs_details_row){
                  $CAP_DIA=$specs_details_row->CAP_DIA;
                  $CAP_STYLE=$specs_details_row->CAP_STYLE;
                  $CAP_MOLD_FINISH=$specs_details_row->CAP_MOLD_FINISH;
                  $CAP_ORIFICE=$specs_details_row->CAP_ORIFICE;
                  $CAP_MASTER_BATCH=$specs_details_row->CAP_MASTER_BATCH;
                  $CAP_MB_PERC=$specs_details_row->CAP_MB_PERC;
                  $CAP_MB_SUPPLIER=$specs_details_row->CAP_MB_SUPPLIER;
                  $CAP_PP=$specs_details_row->CAP_PP;
                  $CAP_PP_PERC=$specs_details_row->CAP_PP_PERC;
                  $CAP_FOIL_COLOR=$specs_details_row->CAP_FOIL_COLOR;
                  $CAP_FOIL_WIDTH=$specs_details_row->CAP_FOIL_WIDTH;
                  $CAP_FOIL_DIST_FROM_BOT=$specs_details_row->CAP_FOIL_DIST_FROM_BOT;
                  $CAP_SHRINK_SLEEVE=$specs_details_row->CAP_SHRINK_SLEEVE;
                  $CAP_SHRINK_SLEEVE_NAME=$specs_details_row->CAP_SHRINK_SLEEVE_NAME;
                  }
                }
                

              if(!empty($this->input->post('label_article_no'))){
                $label_article=explode('//',$this->input->post('label_article_no'));
              }else{
                $label_article[1]='';
              }

              if(!empty($this->input->post('sleeve_dia'))){
                $sleeve_dia=explode('//',$this->input->post('sleeve_dia'));
              }else{
                $sleeve_dia[0]='';
              }

              if(!empty($this->input->post('sl_mb_supplier'))){
                $sl_mb_supplier=explode('//',$this->input->post('sl_mb_supplier'));
              }else{
                $sl_mb_supplier[1]='';
              }

              if(!empty($this->input->post('sh_mb_supplier'))){
                $sh_mb_supplier=explode('//',$this->input->post('sh_mb_supplier'));
              }else{
                $sh_mb_supplier[1]='';
              }

              

              if(!empty($this->input->post('shoulder'))){
                $shoulder=explode('//',$this->input->post('shoulder'));
              }else{
                $shoulder[0]='';
              }

              if(!empty($this->input->post('shoulder_orifice'))){
                $shoulder_orifice=explode('//',$this->input->post('shoulder_orifice'));
              }else{
                $shoulder_orifice[0]='';
              }


              if(!empty($this->input->post('cap_mb_supplier'))){
                $cap_mb_supplier=explode('//',$this->input->post('cap_mb_supplier'));
              }else{
                $cap_mb_supplier[1]='';
              }

              if(!empty($this->input->post('shoulder'))){
                $shoulder=explode('//',$this->input->post('shoulder'));
              }else{
                $shoulder[0]='';
              }

              if(!empty($this->input->post('shoulder_orifice'))){
                $shoulder_orifice=explode('//',$this->input->post('shoulder_orifice'));
              }else{
                $shoulder_orifice[0]='';
              }

              if(!empty($this->input->post('cap_type'))){
                $cap_type=explode('//',$this->input->post('cap_type'));
              }else{
                $cap_type[0]='';
              }

              if(!empty($this->input->post('cap_finish'))){
                $cap_finish=explode('//',$this->input->post('cap_finish'));
              }else{
                $cap_finish[0]='';
              }

              if(!empty($this->input->post('cap_dia'))){
                $cap_dia=explode('//',$this->input->post('cap_dia'));
              }else{
                $cap_dia[0]='';
              }

              if(!empty($this->input->post('cap_orifice'))){
                $cap_orifice=explode('//',$this->input->post('cap_orifice'));
              }else{
                $cap_orifice[0]='';
              }

             

             

              $data['spec_version']=$this->specification_model->select_specification_verion_no('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$article_no_arr[1]);
              foreach ($data['spec_version'] as $spec_version_row) {

                if($spec_version_row->spec_version_no==NULL){
                  $max_pkey=0;
                  $result=$this->common_model->select_max_pkey('specification_sheet','spec_id',$this->session->userdata['logged_in']['company_id']); 
                  foreach($result as $row){
                    $max_pkey=$row->spec_id;
                    $max_pkey=substr($max_pkey,4);
                    $max_pkey=$max_pkey+1;
                    $spec_no=str_pad($max_pkey,4,0,STR_PAD_LEFT);
                    $spec_no="SPEC".$spec_no;
                  }
                  $spec_version_no=1;
                }else{
                  $spec_version_no=$spec_version_row->spec_version_no;
                  $spec_no=$spec_version_row->spec_id;
                }
              }

              $artwork_no="";
              $artwork_version_no="";
              if(!empty($this->input->post('artwork_final_version_no'))){

                $data['artwork_final_version_no']=$this->artwork_model->select_artwork_final_version('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'article_no',$article_no_arr[1],'final_approval_flag','1','archive<>','1','ad_date','desc','ad_id','desc','version_no','desc');
                foreach ($data['artwork_final_version_no'] as $artwork_final_version_no_row){
                   $artwork_no=$artwork_final_version_no_row->ad_id;
                   $artwork_version_no=$artwork_final_version_no_row->version_no;
                }

              }
              

              $data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$customer_arr[1]);
              foreach ($data['customer'] as $customer_row) {
                $property=$customer_row->property_id;
              }

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                    'spec_id'=>$spec_no,
                    'spec_created_date'=>date('Y-m-d'),
                    'spec_version_no'=>$spec_version_no,
                    'property_id'=>$property,
                    'adr_company_id'=>$customer_arr[1],
                    'article_no'=>$article_no_arr[1],
                    'pending_flag'=>'0',
                    'final_approval_flag'=>'0',
                    'user_id'=>$this->session->userdata['logged_in']['user_id'],
                    'ad_id'=>$artwork_no,
                    'version_no'=>$artwork_version_no,
                    'dyn_qty_present'=>'SLEEVE|1^^^SHOULDER|1^^^CAP|1',
                    );

              $result=$this->common_model->save('specification_sheet',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'164',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DIA',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$sleeve_dia[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_1',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'165',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LENGTH',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('sleeve_length')." MM",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_2',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'166',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DRAWING',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_3',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'167',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'GUAGE',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('gauge')." MIC",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_4',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'168',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'material'=>'1',
                'item_group_material'=>'12',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>$sl_mb_supplier[1],
                'mat_info'=>$this->input->post('sl_mb_per')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_masterbatch'),
                'srd_id'=>'1_5_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
            

              

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'7',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_ldpe_per')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_ldpe'),
                'srd_id'=>'1_6_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

            

              
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'8',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_lldpe_per')."%",
                'mat_article_no'=>$this->input->post('sl_lldpe'),
                'property_id'=>'',
                'srd_id'=>'1_6_1',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
            

            

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_hdpe_per')."%",
                'mat_article_no'=>$this->input->post('sl_hdpe'),
                'property_id'=>'',
                'srd_id'=>'1_6_2',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

            
              


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'185',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'PRINT TYPE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$this->input->post('print_type'),
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_7',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'170',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'DRAWING',
                'item_group_material'=>'',
                'material'=>'0',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_1',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'171',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'STYLE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$shoulder[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_2',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'172',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'NECK TYPE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$shoulder[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_3',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'173',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'ORIFICE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$shoulder_orifice[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_4',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'174',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'PEEL OFF TE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_5',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'175',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'material'=>'1',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'item_group_material'=>'12',
                'supplier_no'=>$sh_mb_supplier[1],
                'mat_info'=>$this->input->post('sh_mb_per')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sh_masterbatch'),
                'srd_id'=>'2_6_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              
                $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'176',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'parameter_value'=>'',
                'material'=>'1',
                'item_group_material'=>'6',
                'supplier_no'=>'',
                'relating_master_value'=>'',
                'mat_info'=>$this->input->post('sh_hdpe_one_per')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sh_hdpe_one'),
                'srd_id'=>'2_7_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
              
              

              
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'176',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sh_hdpe_two_per')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sh_hdpe_two'),
                'srd_id'=>'2_7_1',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
            

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'186',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'material'=>'1',
                'item_group_material'=>'106',
                'parameter_name'=>'SHOULDER FOIL TAG',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('shoulder_foil_tag'),
                'srd_id'=>'2_8',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'177',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'CSPEC',
                'item_group_material'=>'',
                'parameter_value'=>$cap_article_no_arr[2]."//".$cap_article_no_arr[3],
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_1',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);



              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'178',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'STYLE',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$CAP_STYLE,
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_2',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'179',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'MOLD FINISH',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$CAP_MOLD_FINISH,
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_3',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'180',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'DIAMETER',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$CAP_DIA,
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_4',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'181',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'SHRINK SLEEVE',
                'parameter_value'=>$CAP_SHRINK_SLEEVE_NAME,
                'item_group_material'=>'213',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'material'=>'1',
                'mat_article_no'=>$CAP_SHRINK_SLEEVE,
                'srd_id'=>'3_5',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'182',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'ORIFICE',
                'parameter_value'=>'',
                'item_group_material'=>'',
                'relating_master_value'=>$CAP_ORIFICE,
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_6',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'183',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'material'=>'1',
                'item_group_material'=>'12',
                'property_id'=>'',
                'supplier_no'=>$CAP_MB_SUPPLIER,
                'mat_info'=>$CAP_MB_PERC,
                'mat_article_no'=>$CAP_MASTER_BATCH,
                'srd_id'=>'3_7_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'184',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'material'=>'1',
                'supplier_no'=>'',
                'property_id'=>'',
                'item_group_material'=>'9',
                'mat_info'=>$CAP_PP_PERC,
                'mat_article_no'=>$CAP_PP,
                'srd_id'=>'3_8_1',
                'item_group_material_flag'=>'2',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'187',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'CAP FOIL COLOR',
                'item_group_material'=>'71',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>$CAP_FOIL_COLOR,
                'material'=>'1',
                'supplier_no'=>'',
                'property_id'=>'',
                'parameter_value'=>'',
                'srd_id'=>'3_9',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'188',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'CAP FOIL WIDTH',
                'item_group_material'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'material'=>'0',
                'parameter_value'=>$CAP_FOIL_WIDTH,
                'srd_id'=>'3_10',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

            $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
              'spec_id'=>$spec_no,
              'disp_id'=>'189',
              'item_group_id'=>'5',
              'item_group_flag'=>'1',
              'parameter_name'=>'C.FOIL DIST FROM BOT',
              'item_group_material'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
              'material'=>'0',
              'parameter_value'=>$CAP_FOIL_DIST_FROM_BOT,
              'srd_id'=>'3_11',
              'item_group_material_flag'=>'0',
              'dyn_qty_no'=>'1',
              'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
              'spec_version_no'=>$spec_version_no,
              'layer_no'=>'1');
            $result=$this->common_model->save('specification_sheet_details',$data);

            $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
              'spec_id'=>$spec_no,
              'disp_id'=>'190',
              'item_group_id'=>'6',
              'item_group_flag'=>'1',
              'parameter_name'=>'LABEL',
              'item_group_material'=>'5',
              'relating_master_value'=>'',
              'supplier_no'=>'',
              'mat_info'=>'',
              'property_id'=>'',
              'mat_article_no'=>$label_article[1],
              'material'=>'1',
              'parameter_value'=>'',
              'srd_id'=>'3_12',
              'item_group_material_flag'=>'1',
              'dyn_qty_no'=>'1',
              'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
              'spec_version_no'=>$spec_version_no,
              'layer_no'=>'1');
            $result=$this->common_model->save('specification_sheet_details',$data);


            $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
              'spec_id'=>$spec_no,
              'lang_comments'=>$this->input->post('comment'),
              'language_id'=>$this->session->userdata['logged_in']['language_id'],
              'spec_version_no'=>$spec_version_no);
            $result=$this->common_model->save('specification_sheet_lang',$data);

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
              $data['note']='Copy Transaction Completed';
              header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
              
                  $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

                  

                  $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
                  $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
                  $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
                  $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                  $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);

                  $dataa=array('article_main_group.main_group_id'=>'5');
                  $data['label']=$this->article_model->active_record_search('article',$dataa,$this->session->userdata['logged_in']['company_id']);
                  $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);

                  $data['specification']=$this->specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$spec_no,'specification_sheet.spec_version_no',$spec_version_no);
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                  $this->load->view(ucwords($this->router->fetch_class()).'/single-copy-form',$data);
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


  function save_two_layer_with_cap(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $this->form_validation->set_rules('customer','Customer' ,'required|trim|xss_clean|callback_customer_check');
            $this->form_validation->set_rules('article_no','Article No' ,'required|trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('spec_version_no','Spec Version No' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('artwork_final_version_no','Artwork Version No' ,'trim|xss_clean');

            if($this->input->post('sleeve_dia')){

              $this->form_validation->set_rules('sleeve_dia','Sleeve Dia' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sleeve_length','Sleeve Length' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');
              $this->form_validation->set_rules('gauge_one','Gauge Layer One' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');
              $this->form_validation->set_rules('print_type','Print Type' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sl_masterbatch_one','Sleeve Masterbatch Layer One' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sl_mb_supplier_one','Sleeve Masterbatch Supplier Layer One','trim|xss_clean|callback_supplier_check');
              $this->form_validation->set_rules('sl_mb_per_one','Sleeve Masterbatch % Layer One' ,'required|trim|xss_clean|numeric|max_length[3]');

              $this->form_validation->set_rules('sl_ldpe_per_one','Sleeve Ldpe % Layer One' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_one_check');
              $this->form_validation->set_rules('sl_lldpe_per_one','Sleeve Lldpe % Layer One' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_one_check');
              $this->form_validation->set_rules('sl_hdpe_per_one','Sleeve Hdpe % Layer One' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_one_check');

              if(!empty($this->input->post('sl_ldpe_per_one'))){
                $this->form_validation->set_rules('sl_ldpe_one','Sleeve Ldpe Layer One' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_lldpe_per_one'))){
                $this->form_validation->set_rules('sl_lldpe_one','Sleeve Lldpe Layer One' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_hdpe_per_one'))){
                $this->form_validation->set_rules('sl_hdpe_one','Sleeve Hdpe Layer One' ,'trim|xss_clean|required');
              }


              

              $this->form_validation->set_rules('gauge_two','Gauge Layer Two' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');
              $this->form_validation->set_rules('sl_masterbatch_two','Sleeve Masterbatch Layer Two' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sl_mb_supplier_two','Sleeve Masterbatch Supplier Layer Two','trim|xss_clean|callback_supplier_check');
              $this->form_validation->set_rules('sl_mb_per_two','Sleeve Masterbatch % Layer Two' ,'required|trim|xss_clean|numeric|max_length[3]');

              $this->form_validation->set_rules('sl_ldpe_per_two','Sleeve Ldpe % Layer Two' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_two_check');
              $this->form_validation->set_rules('sl_lldpe_per_two','Sleeve Lldpe % Layer Two' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_two_check');
              $this->form_validation->set_rules('sl_hdpe_per_two','Sleeve Hdpe % Layer Two' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_two_check');

              if(!empty($this->input->post('sl_ldpe_per_two'))){
                $this->form_validation->set_rules('sl_ldpe_two','Sleeve Ldpe Layer Two' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_lldpe_per_two'))){
                $this->form_validation->set_rules('sl_lldpe_two','Sleeve Lldpe Layer Two' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_hdpe_per_two'))){
                $this->form_validation->set_rules('sl_hdpe_two','Sleeve Hdpe Layer Two' ,'trim|xss_clean|required');
              }
              

            }
            
            if($this->input->post('shoulder')){
            
              $this->form_validation->set_rules('shoulder','Shoulder' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('shoulder_orifice','Shoulder Orifice' ,'trim|xss_clean');
              $this->form_validation->set_rules('sh_masterbatch','Shoulder Masterbatch' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sh_mb_supplier','Shoulder Masterbatch Supplier' ,'trim|xss_clean|callback_supplier_check');
              $this->form_validation->set_rules('sh_mb_per','Shoulder Masterbatch %' ,'required|trim|xss_clean|numeric|max_length[3]');
              $this->form_validation->set_rules('sh_hdpe_one_per','Shoulder HDPE %' ,'trim|xss_clean|numeric|max_length[3]|callback_shoulder_per_check');
              $this->form_validation->set_rules('sh_hdpe_two_per','Shoulder HDPE %' ,'trim|xss_clean|numeric|max_length[3]|callback_shoulder_per_check');

               if(!empty($this->input->post('sh_hdpe_one_per'))){
                $this->form_validation->set_rules('sh_hdpe_one','Shoulder Hdpe' ,'trim|xss_clean|required');
                }if(!empty($this->input->post('sh_hdpe_two_per'))){
                $this->form_validation->set_rules('sh_hdpe_two','Shoulder Hdpe' ,'trim|xss_clean|required');
                }

            }


            if(!empty($this->input->post('cap_spec_no'))){
              $this->form_validation->set_rules('cap_spec_no','Cap Spec No' ,'trim|xss_clean|required|exact_length[9]');
              $this->form_validation->set_rules('cap_spec_version_no','Cap Spec Version' ,'trim|xss_clean|required');
            }

            $this->form_validation->set_rules('label_article_no','Label Article No' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('cap_article_no','Cap Article No' ,'trim|xss_clean|callback_article_check');


            if($this->form_validation->run()==FALSE){
              
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

            $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
            $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
            $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);

            $dataa=array('article_main_group.main_group_id'=>'5');
            $data['label']=$this->article_model->active_record_search('article',$dataa,$this->session->userdata['logged_in']['company_id']);
            $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);



              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-two-form',$data);
              $this->load->view('Home/footer');
            }else{

              if(!empty($this->input->post('customer'))){
                $customer_arr=explode('//',$this->input->post('customer'));
              }

              if(!empty($this->input->post('article_no'))){
                $article_no_arr=explode('//',$this->input->post('article_no'));
              }

              if(!empty($this->input->post('cap_article_no'))){
                $cap_article_no_arr=explode('//',$this->input->post('cap_article_no'));
              }

              if(!empty($this->input->post('cap_spec_no'))){
                $cap_article_no_arr[2]=$this->input->post('cap_spec_no');
                $cap_article_no_arr[3]=$this->input->post('cap_spec_version_no');
              }


              $data=array('spec_id'=>$cap_article_no_arr[2],
                  'spec_version_no'=>$cap_article_no_arr[3]);
                $data['specs_details']=$this->sales_order_book_model->select_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data);
                if($data['specs_details']==FALSE){
                  $CAP_DIA="";
                  $CAP_STYLE="";
                  $CAP_MOLD_FINISH="";
                  $CAP_ORIFICE="";
                  $CAP_MASTER_BATCH="";
                  $CAP_MB_PERC="";
                  $CAP_MB_SUPPLIER="";
                  $CAP_PP="";
                  $CAP_PP_PERC="";
                  $CAP_FOIL_COLOR="";
                  $CAP_FOIL_WIDTH="";
                  $CAP_FOIL_DIST_FROM_BOT="";
                  $CAP_SHRINK_SLEEVE="";
                  $CAP_SHRINK_SLEEVE_NAME="";
                }else{
                  foreach($data['specs_details'] as $specs_details_row){
                  $CAP_DIA=$specs_details_row->CAP_DIA;
                  $CAP_STYLE=$specs_details_row->CAP_STYLE;
                  $CAP_MOLD_FINISH=$specs_details_row->CAP_MOLD_FINISH;
                  $CAP_ORIFICE=$specs_details_row->CAP_ORIFICE;
                  $CAP_MASTER_BATCH=$specs_details_row->CAP_MASTER_BATCH;
                  $CAP_MB_PERC=$specs_details_row->CAP_MB_PERC;
                  $CAP_MB_SUPPLIER=$specs_details_row->CAP_MB_SUPPLIER;
                  $CAP_PP=$specs_details_row->CAP_PP;
                  $CAP_PP_PERC=$specs_details_row->CAP_PP_PERC;
                  $CAP_FOIL_COLOR=$specs_details_row->CAP_FOIL_COLOR;
                  $CAP_FOIL_WIDTH=$specs_details_row->CAP_FOIL_WIDTH;
                  $CAP_FOIL_DIST_FROM_BOT=$specs_details_row->CAP_FOIL_DIST_FROM_BOT;
                  $CAP_SHRINK_SLEEVE=$specs_details_row->CAP_SHRINK_SLEEVE;
                  $CAP_SHRINK_SLEEVE_NAME=$specs_details_row->CAP_SHRINK_SLEEVE_NAME;
                  }
                }


              if(!empty($this->input->post('label_article_no'))){
                $label_article=explode('//',$this->input->post('label_article_no'));
              }else{
                $label_article[1]='';
              }

              if(!empty($this->input->post('sleeve_dia'))){
                $sleeve_dia=explode('//',$this->input->post('sleeve_dia'));
              }else{
                $sleeve_dia[0]='';
              }

              if(!empty($this->input->post('sl_mb_supplier_one'))){
                $sl_mb_supplier_one=explode('//',$this->input->post('sl_mb_supplier_one'));
              }else{
                $sl_mb_supplier_one[1]='';
              }

              if(!empty($this->input->post('sl_mb_supplier_two'))){
                $sl_mb_supplier_two=explode('//',$this->input->post('sl_mb_supplier_two'));
              }else{
                $sl_mb_supplier_two[1]='';
              }

              if(!empty($this->input->post('sh_mb_supplier'))){
                $sh_mb_supplier=explode('//',$this->input->post('sh_mb_supplier'));
              }else{
                $sh_mb_supplier[1]='';
              }

              if(!empty($this->input->post('cap_mb_supplier'))){
                $cap_mb_supplier=explode('//',$this->input->post('cap_mb_supplier'));
              }else{
                $cap_mb_supplier[1]='';
              }

              if(!empty($this->input->post('shoulder'))){
                $shoulder=explode('//',$this->input->post('shoulder'));
              }else{
                $shoulder[0]='';
              }

              if(!empty($this->input->post('shoulder_orifice'))){
                $shoulder_orifice=explode('//',$this->input->post('shoulder_orifice'));
              }else{
                $shoulder_orifice[0]='';
              }

              $data['cap_diameter_master']=$this->common_model->select_one_active_record('cap_diameter_master',$this->session->userdata['logged_in']['company_id'],'cap_dia',$CAP_DIA);
            if($data['cap_diameter_master']==FALSE){
              $cap_dia_id="";
            }else{
             foreach($data['cap_diameter_master'] as $cap_diameter_master_row){
              $cap_dia_id=$cap_diameter_master_row->cap_dia_id;
             }
           }

            $data['cap_orifice_master']=$this->common_model->select_one_active_record('cap_orifice_master',$this->session->userdata['logged_in']['company_id'],'cap_orifice',$CAP_ORIFICE);
            if($data['cap_orifice_master']==FALSE){
              $cap_orifice_id="";
            }else{
              foreach($data['cap_orifice_master'] as $cap_orifice_master_row){
              $cap_orifice_id=$cap_orifice_master_row->cap_orifice_id;
               }
             }

             $data['cap_types_master']=$this->common_model->select_one_active_record('cap_types_master',$this->session->userdata['logged_in']['company_id'],'cap_type',$CAP_STYLE);
              if($data['cap_types_master']==FALSE){
                $cap_type_id="";
                }else{
                foreach($data['cap_types_master'] as $cap_types_master_row){
                  $cap_type_id=$cap_types_master_row->cap_type_id;
                 }
              }

             $data['cap_finish_master']=$this->common_model->select_one_active_record('cap_finish_master',$this->session->userdata['logged_in']['company_id'],'cap_finish',$CAP_MOLD_FINISH);
             if($data['cap_finish_master']==FALSE){
              $cap_finish_id="";
              }else{
              foreach($data['cap_finish_master'] as $cap_finish_master_row){
                $cap_finish_id=$cap_finish_master_row->cap_finish_id;
              }
              }

             
             $combination_data=array('sleeve_id'=>$sleeve_dia[1],
              'shld_type_id'=>$shoulder[1],
              'shld_orifice_id'=>$shoulder_orifice[1],
              'cap_dia_id'=>$cap_dia_id,
              'cap_orifice_id'=>$cap_orifice_id,
              'cap_type_id'=>$cap_type_id,
              'cap_finish_id'=>$cap_finish_id);

             $this->load->model('shoulder_orifice_dependancy_model');
             if($this->shoulder_orifice_dependancy_model->select_one_active_combination_record('shoulder_orifice_dependancy',$this->session->userdata['logged_in']['company_id'],$combination_data)>0){


              $data['spec_version']=$this->specification_model->select_specification_verion_no('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$article_no_arr[1]);
              foreach ($data['spec_version'] as $spec_version_row) {

                if($spec_version_row->spec_version_no==NULL){
                  $max_pkey=0;
                  $result=$this->common_model->select_max_pkey('specification_sheet','spec_id',$this->session->userdata['logged_in']['company_id']); 
                  foreach($result as $row){
                    $max_pkey=$row->spec_id;
                    $max_pkey=substr($max_pkey,4);
                    $max_pkey=$max_pkey+1;
                    $spec_no=str_pad($max_pkey,4,0,STR_PAD_LEFT);
                    $spec_no="SPEC".$spec_no;
                  }
                  $spec_version_no=1;
                }else{
                  $spec_version_no=$spec_version_row->spec_version_no;
                  $spec_no=$spec_version_row->spec_id;
                }
              }

              $artwork_no="";
              $artwork_version_no=0;
              if(!empty($this->input->post('artwork_final_version_no'))){
                $data['artwork_final_version_no']=$this->artwork_model->select_artwork_final_version('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'article_no',$article_no_arr[1],'final_approval_flag','1','archive<>','1','ad_date','desc','ad_id','desc','version_no','desc');
                if($data['artwork_final_version_no']==FALSE){
                  $artwork_no="";
                  $artwork_version_no=0;
                }else{
                  foreach ($data['artwork_final_version_no'] as $artwork_final_version_no_row){
                     $artwork_no=$artwork_final_version_no_row->ad_id;
                     $artwork_version_no=$artwork_final_version_no_row->version_no;
                  }
                }
              }
              
               

              $data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$customer_arr[1]);
              foreach ($data['customer'] as $customer_row) {
                $property=$customer_row->property_id;
              }

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                    'spec_id'=>$spec_no,
                    'spec_created_date'=>date('Y-m-d'),
                    'spec_version_no'=>$spec_version_no,
                    'property_id'=>$property,
                    'adr_company_id'=>$customer_arr[1],
                    'article_no'=>$article_no_arr[1],
                    'pending_flag'=>'0',
                    'final_approval_flag'=>'0',
                    'user_id'=>$this->session->userdata['logged_in']['user_id'],
                    'ad_id'=>$artwork_no,
                    'version_no'=>$artwork_version_no,
                    'dyn_qty_present'=>'SLEEVE|2^^^SHOULDER|1^^^CAP|1',
                    );

              $result=$this->common_model->save('specification_sheet',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'164',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DIA',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$sleeve_dia[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_1',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'165',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LENGTH',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('sleeve_length')." MM",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_2',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'166',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DRAWING',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_3',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'167',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'GUAGE',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('gauge_one')." MIC",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_4',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'168',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'material'=>'1',
                'item_group_material'=>'12',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>$sl_mb_supplier_one[1],
                'mat_info'=>$this->input->post('sl_mb_per_one')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_masterbatch_one'),
                'srd_id'=>'1_5_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
            

              

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'7',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_ldpe_per_one')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_ldpe_one'),
                'srd_id'=>'1_6_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

            

              
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'8',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_lldpe_per_one')."%",
                'mat_article_no'=>$this->input->post('sl_lldpe_one'),
                'property_id'=>'',
                'srd_id'=>'1_6_1',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
            

            

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_hdpe_per_one')."%",
                'mat_article_no'=>$this->input->post('sl_hdpe_one'),
                'property_id'=>'',
                'srd_id'=>'1_6_2',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

            
              


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'185',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'PRINT TYPE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$this->input->post('print_type'),
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_7',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              //Layer 2

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'164',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DIA',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$sleeve_dia[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_1',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'165',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LENGTH',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('sleeve_length')." MM",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_2',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'166',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DRAWING',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_3',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'167',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'GUAGE',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('gauge_two')." MIC",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_4',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);
              
              $sl_mb_per_two=$this->input->post('sl_mb_per_two')."%";
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'168',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'material'=>'1',
                'item_group_material'=>'12',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>$sl_mb_supplier_two[1],
                'mat_info'=>$sl_mb_per_two,
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_masterbatch_two'),
                'srd_id'=>'2_5_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);
            

              

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'7',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_ldpe_per_two')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_ldpe_two'),
                'srd_id'=>'2_6_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);

            

              
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'8',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_lldpe_per_two')."%",
                'mat_article_no'=>$this->input->post('sl_lldpe_two'),
                'property_id'=>'',
                'srd_id'=>'2_6_1',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);
            

            

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_hdpe_per_two')."%",
                'mat_article_no'=>$this->input->post('sl_hdpe_two'),
                'property_id'=>'',
                'srd_id'=>'2_6_2',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'185',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'PRINT TYPE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$this->input->post('print_type'),
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_7',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'170',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'DRAWING',
                'item_group_material'=>'',
                'material'=>'0',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_1',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'171',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'STYLE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$shoulder[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_2',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'172',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'NECK TYPE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$shoulder[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_3',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'173',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'ORIFICE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$shoulder_orifice[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_4',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'174',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'PEEL OFF TE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_5',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'175',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'material'=>'1',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'item_group_material'=>'12',
                'supplier_no'=>$sh_mb_supplier[1],
                'mat_info'=>$this->input->post('sh_mb_per')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sh_masterbatch'),
                'srd_id'=>'3_6_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              
                $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'176',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'parameter_value'=>'',
                'material'=>'1',
                'item_group_material'=>'6',
                'supplier_no'=>'',
                'relating_master_value'=>'',
                'mat_info'=>$this->input->post('sh_hdpe_one_per')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sh_hdpe_one'),
                'srd_id'=>'3_7_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
              
              

              
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'176',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sh_hdpe_two_per')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sh_hdpe_two'),
                'srd_id'=>'3_7_1',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
            

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'186',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'material'=>'1',
                'item_group_material'=>'106',
                'parameter_name'=>'SHOULDER FOIL TAG',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('shoulder_foil_tag'),
                'srd_id'=>'3_8',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'177',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'CSPEC',
                'item_group_material'=>'',
                'parameter_value'=>$cap_article_no_arr[2]."//".$cap_article_no_arr[3],
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'4_1',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'178',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'STYLE',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$CAP_STYLE,
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'4_2',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'179',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'MOLD FINISH',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$CAP_MOLD_FINISH,
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'4_3',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'180',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'DIAMETER',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$CAP_DIA,
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'4_4',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'181',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'SHRINK SLEEVE',
                'parameter_value'=>$CAP_SHRINK_SLEEVE_NAME,
                'item_group_material'=>'213',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'material'=>'1',
                'property_id'=>'',
                'mat_article_no'=>$CAP_SHRINK_SLEEVE,
                'srd_id'=>'4_5',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'182',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'ORIFICE',
                'parameter_value'=>'',
                'item_group_material'=>'',
                'relating_master_value'=>$CAP_ORIFICE,
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'4_6',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'183',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'material'=>'1',
                'item_group_material'=>'12',
                'property_id'=>'',
                'supplier_no'=>$CAP_MB_SUPPLIER,
                'mat_info'=>$CAP_MB_PERC,
                'mat_article_no'=>$CAP_MASTER_BATCH,
                'srd_id'=>'4_7_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'184',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'material'=>'1',
                'supplier_no'=>'',
                'property_id'=>'',
                'item_group_material'=>'9',
                'mat_info'=>$CAP_PP_PERC,
                'mat_article_no'=>$CAP_PP,
                'srd_id'=>'4_8_1',
                'item_group_material_flag'=>'2',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'187',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'CAP FOIL COLOR',
                'item_group_material'=>'71',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>$CAP_FOIL_COLOR,
                'material'=>'0',
                'supplier_no'=>'',
                'property_id'=>'',
                'parameter_value'=>'',
                'srd_id'=>'4_9',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'188',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'CAP FOIL WIDTH',
                'item_group_material'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'material'=>'0',
                'parameter_value'=>$CAP_FOIL_WIDTH,
                'srd_id'=>'4_10',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

            $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
              'spec_id'=>$spec_no,
              'disp_id'=>'189',
              'item_group_id'=>'5',
              'item_group_flag'=>'1',
              'parameter_name'=>'C.FOIL DIST FROM BOT',
              'item_group_material'=>'',
              'relating_master_value'=>'',
              'supplier_no'=>'',
              'mat_info'=>'',
              'property_id'=>'',
              'mat_article_no'=>'',
              'material'=>'0',
              'parameter_value'=>$CAP_FOIL_DIST_FROM_BOT,
              'srd_id'=>'4_11',
              'item_group_material_flag'=>'0',
              'dyn_qty_no'=>'1',
              'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
              'spec_version_no'=>$spec_version_no,
              'layer_no'=>'1');
            $result=$this->common_model->save('specification_sheet_details',$data);

            $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
              'spec_id'=>$spec_no,
              'disp_id'=>'190',
              'item_group_id'=>'6',
              'item_group_flag'=>'1',
              'parameter_name'=>'LABEL',
              'item_group_material'=>'5',
              'relating_master_value'=>'',
              'supplier_no'=>'',
              'mat_info'=>'',
              'property_id'=>'',
              'mat_article_no'=>$label_article[1],
              'material'=>'1',
              'parameter_value'=>'',
              'srd_id'=>'4_12',
              'item_group_material_flag'=>'1',
              'dyn_qty_no'=>'1',
              'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
              'spec_version_no'=>$spec_version_no,
              'layer_no'=>'1');
            $result=$this->common_model->save('specification_sheet_details',$data);


            $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
              'spec_id'=>$spec_no,
              'lang_comments'=>$this->input->post('comment'),
              'language_id'=>$this->session->userdata['logged_in']['language_id'],
              'spec_version_no'=>$spec_version_no);
            $result=$this->common_model->save('specification_sheet_lang',$data);

              
              $data['note']='Create Transaction Completed';
              header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

              }else{
              $data['error']='Wrong combination';
             }


              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
              
                  $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

                  $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
                  $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
                  $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
                  $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                  $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);

                  $dataa=array('article_main_group.main_group_id'=>'5');
                  $data['label']=$this->article_model->active_record_search('article',$dataa,$this->session->userdata['logged_in']['company_id']);
                  $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);


                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                  $this->load->view(ucwords($this->router->fetch_class()).'/create-two-form',$data);
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


   function save_two_layer_with_cap_copy(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $this->form_validation->set_rules('customer','Customer' ,'required|trim|xss_clean|callback_customer_check');
            $this->form_validation->set_rules('article_no','Article No' ,'required|trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('spec_version_no','Spec Version No' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('artwork_final_version_no','Artwork Version No' ,'trim|xss_clean');

            if($this->input->post('sleeve_dia') || $this->input->post('sleeve_length') || $this->input->post('gauge_one') || $this->input->post('print_type') || $this->input->post('sl_masterbatch_one') || $this->input->post('sl_mb_per_one')){

              $this->form_validation->set_rules('sleeve_dia','Sleeve Dia' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sleeve_length','Sleeve Length' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');
              $this->form_validation->set_rules('gauge_one','Gauge Layer One' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');
              $this->form_validation->set_rules('print_type','Print Type' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sl_masterbatch_one','Sleeve Masterbatch Layer One' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sl_mb_supplier_one','Sleeve Masterbatch Supplier Layer One','trim|xss_clean|callback_supplier_check');
              $this->form_validation->set_rules('sl_mb_per_one','Sleeve Masterbatch % Layer One' ,'required|trim|xss_clean|numeric|max_length[3]');

              $this->form_validation->set_rules('sl_ldpe_per_one','Sleeve Ldpe % Layer One' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_one_check');
              $this->form_validation->set_rules('sl_lldpe_per_one','Sleeve Lldpe % Layer One' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_one_check');
              $this->form_validation->set_rules('sl_hdpe_per_one','Sleeve Hdpe % Layer One' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_one_check');

              if(!empty($this->input->post('sl_ldpe_per_one'))){
                $this->form_validation->set_rules('sl_ldpe_one','Sleeve Ldpe Layer One' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_lldpe_per_one'))){
                $this->form_validation->set_rules('sl_lldpe_one','Sleeve Lldpe Layer One' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_hdpe_per_one'))){
                $this->form_validation->set_rules('sl_hdpe_one','Sleeve Hdpe Layer One' ,'trim|xss_clean|required');
              }


              

              $this->form_validation->set_rules('gauge_two','Gauge Layer Two' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');
              $this->form_validation->set_rules('sl_masterbatch_two','Sleeve Masterbatch Layer Two' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sl_mb_supplier_two','Sleeve Masterbatch Supplier Layer Two','trim|xss_clean|callback_supplier_check');
              $this->form_validation->set_rules('sl_mb_per_two','Sleeve Masterbatch % Layer Two' ,'required|trim|xss_clean|numeric|max_length[3]');

              $this->form_validation->set_rules('sl_ldpe_per_two','Sleeve Ldpe % Layer Two' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_two_check');
              $this->form_validation->set_rules('sl_lldpe_per_two','Sleeve Lldpe % Layer Two' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_two_check');
              $this->form_validation->set_rules('sl_hdpe_per_two','Sleeve Hdpe % Layer Two' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_two_check');

              if(!empty($this->input->post('sl_ldpe_per_two'))){
                $this->form_validation->set_rules('sl_ldpe_two','Sleeve Ldpe Layer Two' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_lldpe_per_two'))){
                $this->form_validation->set_rules('sl_lldpe_two','Sleeve Lldpe Layer Two' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_hdpe_per_two'))){
                $this->form_validation->set_rules('sl_hdpe_two','Sleeve Hdpe Layer Two' ,'trim|xss_clean|required');
              }
              

            }
            
            if($this->input->post('shoulder') || $this->input->post('shoulder_orifice') || $this->input->post('sh_masterbatch') || $this->input->post('sh_mb_per')){
            
              $this->form_validation->set_rules('shoulder','Shoulder' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('shoulder_orifice','Shoulder Orifice' ,'trim|xss_clean');
              $this->form_validation->set_rules('sh_masterbatch','Shoulder Masterbatch' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sh_mb_supplier','Shoulder Masterbatch Supplier' ,'trim|xss_clean|callback_supplier_check');
              $this->form_validation->set_rules('sh_mb_per','Shoulder Masterbatch %' ,'required|trim|xss_clean|numeric|max_length[3]');
              $this->form_validation->set_rules('sh_hdpe_one_per','Shoulder HDPE %' ,'trim|xss_clean|numeric|max_length[3]|callback_shoulder_per_check');
              $this->form_validation->set_rules('sh_hdpe_two_per','Shoulder HDPE %' ,'trim|xss_clean|numeric|max_length[3]|callback_shoulder_per_check');

               if(!empty($this->input->post('sh_hdpe_one_per'))){
                $this->form_validation->set_rules('sh_hdpe_one','Shoulder Hdpe' ,'trim|xss_clean|required');
                }if(!empty($this->input->post('sh_hdpe_two_per'))){
                $this->form_validation->set_rules('sh_hdpe_two','Shoulder Hdpe' ,'trim|xss_clean|required');
                }

            }


            if(!empty($this->input->post('cap_spec_no'))){
              $this->form_validation->set_rules('cap_spec_no','Cap Spec No' ,'trim|xss_clean|required|exact_length[9]');
              $this->form_validation->set_rules('cap_spec_version_no','Cap Spec Version' ,'trim|xss_clean|required');
            }
            $this->form_validation->set_rules('label_article_no','Label Article No' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('cap_article_no','Cap Article No' ,'trim|xss_clean|callback_article_check');


            if($this->form_validation->run()==FALSE){
              
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

            $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
            $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
            $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);

            $dataa=array('article_main_group.main_group_id'=>'5');
            $data['label']=$this->article_model->active_record_search('article',$dataa,$this->session->userdata['logged_in']['company_id']);
            $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);

            $data['specification']=$this->specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->input->post('spec_id'),'specification_sheet.spec_version_no',$this->input->post('copy_version_no'));


              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/two-copy-form',$data);
              $this->load->view('Home/footer');
            }else{

              if(!empty($this->input->post('customer'))){
                $customer_arr=explode('//',$this->input->post('customer'));
              }

              if(!empty($this->input->post('article_no'))){
                $article_no_arr=explode('//',$this->input->post('article_no'));
              }

              if(!empty($this->input->post('cap_article_no'))){
                $cap_article_no_arr=explode('//',$this->input->post('cap_article_no'));
              }

              if(!empty($this->input->post('cap_spec_no'))){
                $cap_article_no_arr[2]=$this->input->post('cap_spec_no');
                $cap_article_no_arr[3]=$this->input->post('cap_spec_version_no');
              }


              $data=array('spec_id'=>$cap_article_no_arr[2],
                  'spec_version_no'=>$cap_article_no_arr[3]);
                $data['specs_details']=$this->sales_order_book_model->select_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data);
                if($data['specs_details']==FALSE){
                  $CAP_DIA="";
                  $CAP_STYLE="";
                  $CAP_MOLD_FINISH="";
                  $CAP_ORIFICE="";
                  $CAP_MASTER_BATCH="";
                  $CAP_MB_PERC="";
                  $CAP_MB_SUPPLIER="";
                  $CAP_PP="";
                  $CAP_PP_PERC="";
                  $CAP_FOIL_COLOR="";
                  $CAP_FOIL_WIDTH="";
                  $CAP_FOIL_DIST_FROM_BOT="";
                  $CAP_SHRINK_SLEEVE="";
                  $CAP_SHRINK_SLEEVE_NAME="";
                }else{
                  foreach($data['specs_details'] as $specs_details_row){
                  $CAP_DIA=$specs_details_row->CAP_DIA;
                  $CAP_STYLE=$specs_details_row->CAP_STYLE;
                  $CAP_MOLD_FINISH=$specs_details_row->CAP_MOLD_FINISH;
                  $CAP_ORIFICE=$specs_details_row->CAP_ORIFICE;
                  $CAP_MASTER_BATCH=$specs_details_row->CAP_MASTER_BATCH;
                  $CAP_MB_PERC=$specs_details_row->CAP_MB_PERC;
                  $CAP_MB_SUPPLIER=$specs_details_row->CAP_MB_SUPPLIER;
                  $CAP_PP=$specs_details_row->CAP_PP;
                  $CAP_PP_PERC=$specs_details_row->CAP_PP_PERC;
                  $CAP_FOIL_COLOR=$specs_details_row->CAP_FOIL_COLOR;
                  $CAP_FOIL_WIDTH=$specs_details_row->CAP_FOIL_WIDTH;
                  $CAP_FOIL_DIST_FROM_BOT=$specs_details_row->CAP_FOIL_DIST_FROM_BOT;
                  $CAP_SHRINK_SLEEVE=$specs_details_row->CAP_SHRINK_SLEEVE;
                  $CAP_SHRINK_SLEEVE_NAME=$specs_details_row->CAP_SHRINK_SLEEVE_NAME;
                  }
                }

              if(!empty($this->input->post('label_article_no'))){
                $label_article=explode('//',$this->input->post('label_article_no'));
              }else{
                $label_article[1]='';
              }

              if(!empty($this->input->post('sleeve_dia'))){
                $sleeve_dia=explode('//',$this->input->post('sleeve_dia'));
              }else{
                $sleeve_dia[0]='';
              }

              if(!empty($this->input->post('sl_mb_supplier_one'))){
                $sl_mb_supplier_one=explode('//',$this->input->post('sl_mb_supplier_one'));
              }else{
                $sl_mb_supplier_one[1]='';
              }

              if(!empty($this->input->post('sl_mb_supplier_two'))){
                $sl_mb_supplier_two=explode('//',$this->input->post('sl_mb_supplier_two'));
              }else{
                $sl_mb_supplier_two[1]='';
              }

              if(!empty($this->input->post('sh_mb_supplier'))){
                $sh_mb_supplier=explode('//',$this->input->post('sh_mb_supplier'));
              }else{
                $sh_mb_supplier[1]='';
              }

              if(!empty($this->input->post('cap_mb_supplier'))){
                $cap_mb_supplier=explode('//',$this->input->post('cap_mb_supplier'));
              }else{
                $cap_mb_supplier[1]='';
              }

              if(!empty($this->input->post('shoulder'))){
                $shoulder=explode('//',$this->input->post('shoulder'));
              }else{
                $shoulder[0]='';
              }

              if(!empty($this->input->post('shoulder_orifice'))){
                $shoulder_orifice=explode('//',$this->input->post('shoulder_orifice'));
              }else{
                $shoulder_orifice[0]='';
              }

              $data['cap_diameter_master']=$this->common_model->select_one_active_record('cap_diameter_master',$this->session->userdata['logged_in']['company_id'],'cap_dia',$CAP_DIA);
            //echo $this->db->last_query();
            if($data['cap_diameter_master']==FALSE){
              $cap_dia_id="";
            }else{
             foreach($data['cap_diameter_master'] as $cap_diameter_master_row){
              $cap_dia_id=$cap_diameter_master_row->cap_dia_id;
             }
           }

            $data['cap_orifice_master']=$this->common_model->select_one_active_record('cap_orifice_master',$this->session->userdata['logged_in']['company_id'],'cap_orifice',$CAP_ORIFICE);
            if($data['cap_orifice_master']==FALSE){
              $cap_orifice_id="";
            }else{
              foreach($data['cap_orifice_master'] as $cap_orifice_master_row){
              $cap_orifice_id=$cap_orifice_master_row->cap_orifice_id;
               }
             }

             $data['cap_types_master']=$this->common_model->select_one_active_record('cap_types_master',$this->session->userdata['logged_in']['company_id'],'cap_type',$CAP_STYLE);
              if($data['cap_types_master']==FALSE){
                $cap_type_id="";
                }else{
                foreach($data['cap_types_master'] as $cap_types_master_row){
                  $cap_type_id=$cap_types_master_row->cap_type_id;
                 }
              }

             $data['cap_finish_master']=$this->common_model->select_one_active_record('cap_finish_master',$this->session->userdata['logged_in']['company_id'],'cap_finish',$CAP_MOLD_FINISH);
             if($data['cap_finish_master']==FALSE){
              $cap_finish_id="";
              }else{
              foreach($data['cap_finish_master'] as $cap_finish_master_row){
                $cap_finish_id=$cap_finish_master_row->cap_finish_id;
              }
              }



             
             $combination_data=array('sleeve_id'=>$sleeve_dia[1],
              'shld_type_id'=>$shoulder[1],
              'shld_orifice_id'=>$shoulder_orifice[1],
              'cap_dia_id'=>$cap_dia_id,
              'cap_orifice_id'=>$cap_orifice_id,
              'cap_type_id'=>$cap_type_id,
              'cap_finish_id'=>$cap_finish_id);

             $this->load->model('shoulder_orifice_dependancy_model');
             $this->shoulder_orifice_dependancy_model->select_one_active_combination_record('shoulder_orifice_dependancy',$this->session->userdata['logged_in']['company_id'],$combination_data);
             //echo $this->db->last_query();
             if($this->shoulder_orifice_dependancy_model->select_one_active_combination_record('shoulder_orifice_dependancy',$this->session->userdata['logged_in']['company_id'],$combination_data)>0){

              $data['spec_version']=$this->specification_model->select_specification_verion_no('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$article_no_arr[1]);
              foreach ($data['spec_version'] as $spec_version_row) {

                if($spec_version_row->spec_version_no==NULL){
                  $max_pkey=0;
                  $result=$this->common_model->select_max_pkey('specification_sheet','spec_id',$this->session->userdata['logged_in']['company_id']); 
                  foreach($result as $row){
                    $max_pkey=$row->spec_id;
                    $max_pkey=substr($max_pkey,4);
                    $max_pkey=$max_pkey+1;
                    $spec_no=str_pad($max_pkey,4,0,STR_PAD_LEFT);
                    $spec_no="SPEC".$spec_no;
                  }
                  $spec_version_no=1;
                }else{
                  $spec_version_no=$spec_version_row->spec_version_no;
                  $spec_no=$spec_version_row->spec_id;
                }
              }

              $artwork_no="";
              $artwork_version_no=0;
              if(!empty($this->input->post('artwork_final_version_no'))){
                $data['artwork_final_version_no']=$this->artwork_model->select_artwork_final_version('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'article_no',$article_no_arr[1],'final_approval_flag','1','archive<>','1','ad_date','desc','ad_id','desc','version_no','desc');
                if($data['artwork_final_version_no']==FALSE){
                  $artwork_no="";
                  $artwork_version_no=0;
                }else{
                  foreach ($data['artwork_final_version_no'] as $artwork_final_version_no_row){
                     $artwork_no=$artwork_final_version_no_row->ad_id;
                     $artwork_version_no=$artwork_final_version_no_row->version_no;
                  }
                }
              }
              
               

              $data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$customer_arr[1]);
              foreach ($data['customer'] as $customer_row) {
                $property=$customer_row->property_id;
              }

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                    'spec_id'=>$spec_no,
                    'spec_created_date'=>date('Y-m-d'),
                    'spec_version_no'=>$spec_version_no,
                    'property_id'=>$property,
                    'adr_company_id'=>$customer_arr[1],
                    'article_no'=>$article_no_arr[1],
                    'pending_flag'=>'0',
                    'final_approval_flag'=>'0',
                    'user_id'=>$this->session->userdata['logged_in']['user_id'],
                    'ad_id'=>$artwork_no,
                    'version_no'=>$artwork_version_no,
                    'dyn_qty_present'=>'SLEEVE|2^^^SHOULDER|1^^^CAP|1',
                    );

              $result=$this->common_model->save('specification_sheet',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'164',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DIA',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$sleeve_dia[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_1',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'165',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LENGTH',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('sleeve_length')." MM",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_2',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'166',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DRAWING',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_3',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'167',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'GUAGE',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('gauge_one')." MIC",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_4',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'168',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'material'=>'1',
                'item_group_material'=>'12',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>$sl_mb_supplier_one[1],
                'mat_info'=>$this->input->post('sl_mb_per_one')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_masterbatch_one'),
                'srd_id'=>'1_5_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
            

              

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'7',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_ldpe_per_one')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_ldpe_one'),
                'srd_id'=>'1_6_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

            

              
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'8',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_lldpe_per_one')."%",
                'mat_article_no'=>$this->input->post('sl_lldpe_one'),
                'property_id'=>'',
                'srd_id'=>'1_6_1',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
            

            

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_hdpe_per_one')."%",
                'mat_article_no'=>$this->input->post('sl_hdpe_one'),
                'property_id'=>'',
                'srd_id'=>'1_6_2',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

            
              


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'185',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'PRINT TYPE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$this->input->post('print_type'),
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_7',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              //Layer 2

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'164',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DIA',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$sleeve_dia[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_1',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'165',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LENGTH',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('sleeve_length')." MM",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_2',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'166',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DRAWING',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_3',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'167',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'GUAGE',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('gauge_two')." MIC",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_4',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);
              
              $sl_mb_per_two=$this->input->post('sl_mb_per_two')."%";
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'168',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'material'=>'1',
                'item_group_material'=>'12',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>$sl_mb_supplier_two[1],
                'mat_info'=>$sl_mb_per_two,
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_masterbatch_two'),
                'srd_id'=>'2_5_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);
            

              

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'7',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_ldpe_per_two')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_ldpe_two'),
                'srd_id'=>'2_6_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);

            

              
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'8',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_lldpe_per_two')."%",
                'mat_article_no'=>$this->input->post('sl_lldpe_two'),
                'property_id'=>'',
                'srd_id'=>'2_6_1',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);
            

            

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_hdpe_per_two')."%",
                'mat_article_no'=>$this->input->post('sl_hdpe_two'),
                'property_id'=>'',
                'srd_id'=>'2_6_2',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'185',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'PRINT TYPE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$this->input->post('print_type'),
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_7',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'2',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'170',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'DRAWING',
                'item_group_material'=>'',
                'material'=>'0',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_1',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'171',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'STYLE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$shoulder[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_2',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'172',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'NECK TYPE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$shoulder[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_3',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'173',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'ORIFICE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$shoulder_orifice[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_4',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'174',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'PEEL OFF TE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_5',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'175',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'material'=>'1',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'item_group_material'=>'12',
                'supplier_no'=>$sh_mb_supplier[1],
                'mat_info'=>$this->input->post('sh_mb_per')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sh_masterbatch'),
                'srd_id'=>'3_6_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              
                $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'176',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'parameter_value'=>'',
                'material'=>'1',
                'item_group_material'=>'6',
                'supplier_no'=>'',
                'relating_master_value'=>'',
                'mat_info'=>$this->input->post('sh_hdpe_one_per')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sh_hdpe_one'),
                'srd_id'=>'3_7_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
              
              

              
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'176',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sh_hdpe_two_per')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sh_hdpe_two'),
                'srd_id'=>'3_7_1',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
            

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'186',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'material'=>'1',
                'item_group_material'=>'106',
                'parameter_name'=>'SHOULDER FOIL TAG',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('shoulder_foil_tag'),
                'srd_id'=>'3_8',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'177',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'CSPEC',
                'item_group_material'=>'',
                'parameter_value'=>$cap_article_no_arr[2]."//".$cap_article_no_arr[3],
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'4_1',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'178',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'STYLE',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$CAP_STYLE,
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'4_2',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'179',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'MOLD FINISH',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$CAP_MOLD_FINISH,
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'4_3',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'180',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'DIAMETER',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$CAP_DIA,
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'4_4',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'181',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'SHRINK SLEEVE',
                'parameter_value'=>$CAP_SHRINK_SLEEVE_NAME,
                'item_group_material'=>'213',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'material'=>'1',
                'property_id'=>'',
                'mat_article_no'=>$CAP_SHRINK_SLEEVE,
                'srd_id'=>'4_5',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'182',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'ORIFICE',
                'parameter_value'=>'',
                'item_group_material'=>'',
                'relating_master_value'=>$CAP_ORIFICE,
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'4_6',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'183',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'material'=>'1',
                'item_group_material'=>'12',
                'property_id'=>'',
                'supplier_no'=>$CAP_MB_SUPPLIER,
                'mat_info'=>$CAP_MB_PERC,
                'mat_article_no'=>$CAP_MASTER_BATCH,
                'srd_id'=>'4_7_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'184',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'material'=>'1',
                'supplier_no'=>'',
                'property_id'=>'',
                'item_group_material'=>'9',
                'mat_info'=>$CAP_PP_PERC,
                'mat_article_no'=>$CAP_PP,
                'srd_id'=>'4_8_1',
                'item_group_material_flag'=>'2',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'187',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'CAP FOIL COLOR',
                'item_group_material'=>'71',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>$CAP_FOIL_COLOR,
                'material'=>'0',
                'supplier_no'=>'',
                'property_id'=>'',
                'parameter_value'=>'',
                'srd_id'=>'4_9',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'188',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'CAP FOIL WIDTH',
                'item_group_material'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'material'=>'0',
                'parameter_value'=>$CAP_FOIL_WIDTH,
                'srd_id'=>'4_10',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

            $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
              'spec_id'=>$spec_no,
              'disp_id'=>'189',
              'item_group_id'=>'5',
              'item_group_flag'=>'1',
              'parameter_name'=>'C.FOIL DIST FROM BOT',
              'item_group_material'=>'',
              'relating_master_value'=>'',
              'supplier_no'=>'',
              'mat_info'=>'',
              'property_id'=>'',
              'mat_article_no'=>'',
              'material'=>'0',
              'parameter_value'=>$CAP_FOIL_DIST_FROM_BOT,
              'srd_id'=>'4_11',
              'item_group_material_flag'=>'0',
              'dyn_qty_no'=>'1',
              'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
              'spec_version_no'=>$spec_version_no,
              'layer_no'=>'1');
            $result=$this->common_model->save('specification_sheet_details',$data);

            $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
              'spec_id'=>$spec_no,
              'disp_id'=>'190',
              'item_group_id'=>'6',
              'item_group_flag'=>'1',
              'parameter_name'=>'LABEL',
              'item_group_material'=>'5',
              'relating_master_value'=>'',
              'supplier_no'=>'',
              'mat_info'=>'',
              'property_id'=>'',
              'mat_article_no'=>$label_article[1],
              'material'=>'1',
              'parameter_value'=>'',
              'srd_id'=>'4_12',
              'item_group_material_flag'=>'1',
              'dyn_qty_no'=>'1',
              'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
              'spec_version_no'=>$spec_version_no,
              'layer_no'=>'1');
            $result=$this->common_model->save('specification_sheet_details',$data);


            $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
              'spec_id'=>$spec_no,
              'lang_comments'=>$this->input->post('comment'),
              'language_id'=>$this->session->userdata['logged_in']['language_id'],
              'spec_version_no'=>$spec_version_no);
            $result=$this->common_model->save('specification_sheet_lang',$data);

              
              $data['note']='Copy Transaction Completed';
              header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

              }else{
              $data['error']='Wrong combination';
             }
                  $data['page_name']='Sales';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                   $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
              
                  $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

                  $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
                  $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
                  $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
                  $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                  $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);

                  $dataa=array('article_main_group.main_group_id'=>'5');
                  $data['label']=$this->article_model->active_record_search('article',$dataa,$this->session->userdata['logged_in']['company_id']);
                  $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);



                  $data['specification']=$this->specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$spec_no,'specification_sheet.spec_version_no',$spec_version_no);
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                  $this->load->view(ucwords($this->router->fetch_class()).'/two-copy-form',$data);
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


  function copy_three(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->copy==1){

                $data['specification']=$this->specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->uri->segment(3),'specification_sheet.spec_version_no',$this->uri->segment(4));
                $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
                $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
                $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
                $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
                $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

                $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
                $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
                $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
                $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
                $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);

                $dataa=array('article_main_group.main_group_id'=>'5');
                $data['label']=$this->article_model->active_record_search('article',$dataa,$this->session->userdata['logged_in']['company_id']);
                $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);

                $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/three-copy-form',$data);
              $this->load->view('Home/footer');
          }else{
              $data['note']='No Copy rights Thanks';
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
      $data['note']='No Copy rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  
  }


  function modify_single_layer_with_cap(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){

            $data['specification']=$this->specification_model->select_one_active_unapproved_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->uri->segment(3),'specification_sheet.spec_version_no',$this->uri->segment(4),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

                  $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
                  $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
                  $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
                  $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                  $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);

                  $dataa=array('article_main_group.main_group_id'=>'5');
                  $data['label']=$this->article_model->active_record_search('article',$dataa,$this->session->userdata['logged_in']['company_id']);
                  $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);

                  $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/single-modify-form-with-cap',$data);
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


  function modify_five_layer_with_cap(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){

            $data['specification']=$this->specification_model->select_one_active_unapproved_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->uri->segment(3),'specification_sheet.spec_version_no',$this->uri->segment(4),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);
              
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

            $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
            $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
            $data['admer']=$this->article_model->spec_active_record_search('article','15',$this->session->userdata['logged_in']['company_id']);
            $data['evoh']=$this->article_model->spec_active_record_search('article','16',$this->session->userdata['logged_in']['company_id']);
            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
            $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);

            $dataa=array('article_main_group.main_group_id'=>'5');
            $data['label']=$this->article_model->active_record_search('article',$dataa,$this->session->userdata['logged_in']['company_id']);
            $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);

            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/five-modify-form-with-cap',$data);
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



  function modify_two_layer_with_cap(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){

            $data['specification']=$this->specification_model->select_one_active_unapproved_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->uri->segment(3),'specification_sheet.spec_version_no',$this->uri->segment(4),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

                  $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
                  $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
                  $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
                  $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                  $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);

                  $dataa=array('article_main_group.main_group_id'=>'5');
                  $data['label']=$this->article_model->active_record_search('article',$dataa,$this->session->userdata['logged_in']['company_id']);
                  $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);


                  $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/two-modify-form-with-cap',$data);
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


  function modify_three_layer_with_cap(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){

            $data['specification']=$this->specification_model->select_one_active_unapproved_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->uri->segment(3),'specification_sheet.spec_version_no',$this->uri->segment(4),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

                  $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
                  $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
                  $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
                  $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                  $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);

                  $dataa=array('article_main_group.main_group_id'=>'5');
                  $data['label']=$this->article_model->active_record_search('article',$dataa,$this->session->userdata['logged_in']['company_id']);
                  $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);

                  $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/three-modify-form-with-cap',$data);
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



  function update_single_layer_with_cap(){
      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){
            $this->form_validation->set_rules('customer','Customer' ,'required|trim|xss_clean|callback_customer_check');
            $this->form_validation->set_rules('article_no','Article No' ,'required|trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('spec_version_no','Spec Version No' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('artwork_final_version_no','Artwork Version No' ,'trim|xss_clean');

            if($this->input->post('sleeve_dia') || $this->input->post('sleeve_length')){

              $this->form_validation->set_rules('sleeve_dia','Sleeve Dia' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sleeve_length','Sleeve Length' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');
              $this->form_validation->set_rules('gauge','Gauge' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');
              $this->form_validation->set_rules('print_type','Print Type' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sl_masterbatch','Sleeve Masterbatch' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sl_mb_supplier','Sleeve Masterbatch Supplier','trim|xss_clean|callback_supplier_check');
              $this->form_validation->set_rules('sl_mb_per','Sleeve Masterbatch %' ,'required|trim|xss_clean|numeric|max_length[3]');

              $this->form_validation->set_rules('sl_ldpe_per','Sleeve Ldpe %' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_check');
              $this->form_validation->set_rules('sl_lldpe_per','Sleeve Lldpe %' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_check');
              $this->form_validation->set_rules('sl_hdpe_per','Sleeve Hdpe %' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_check');

              if(!empty($this->input->post('sl_ldpe_per'))){
                $this->form_validation->set_rules('sl_ldpe','Sleeve Ldpe' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_lldpe_per'))){
                $this->form_validation->set_rules('sl_lldpe','Sleeve Lldpe' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_hdpe_per'))){
                $this->form_validation->set_rules('sl_hdpe','Sleeve Hdpe' ,'trim|xss_clean|required');
              }
              

            }
            
            if($this->input->post('shoulder')){
            
              $this->form_validation->set_rules('shoulder','Shoulder' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('shoulder_orifice','Shoulder Orifice' ,'trim|xss_clean');
              $this->form_validation->set_rules('shoulder_foil_tag','Shoulder Foil Tag' ,'trim|xss_clean');
              $this->form_validation->set_rules('sh_masterbatch','Shoulder Masterbatch' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sh_mb_supplier','Shoulder Masterbatch Supplier' ,'trim|xss_clean|callback_supplier_check');
              $this->form_validation->set_rules('sh_mb_per','Shoulder Masterbatch %' ,'required|trim|xss_clean|numeric|max_length[3]');
              $this->form_validation->set_rules('sh_hdpe_one_per','Shoulder HDPE %' ,'trim|xss_clean|is_natural|max_length[3]|callback_shoulder_per_check');
              $this->form_validation->set_rules('sh_hdpe_two_per','Shoulder HDPE %' ,'trim|xss_clean|is_natural|max_length[3]|callback_shoulder_per_check');

               if(!empty($this->input->post('sh_hdpe_one_per'))){
                $this->form_validation->set_rules('sh_hdpe_one','Shoulder Hdpe' ,'trim|xss_clean|required');
                }if(!empty($this->input->post('sh_hdpe_two_per'))){
                $this->form_validation->set_rules('sh_hdpe_two','Shoulder Hdpe' ,'trim|xss_clean|required');
                }

            }

            if(!empty($this->input->post('cap_spec_no'))){
              $this->form_validation->set_rules('cap_spec_no','Cap Spec No' ,'trim|xss_clean|required|exact_length[9]');
              $this->form_validation->set_rules('cap_spec_version_no','Cap Spec Version' ,'trim|xss_clean|required');
            }


            $this->form_validation->set_rules('label_article_no','Label Article No' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('cap_article_no','Cap Article No' ,'trim|xss_clean|callback_article_check');
           
              

              if($this->form_validation->run()==FALSE){

                $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
                $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
                

                $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
                $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
                $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
                $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
                $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);

                $dataa=array('article_main_group.main_group_id'=>'5');
                $data['label']=$this->article_model->active_record_search('article',$dataa,$this->session->userdata['logged_in']['company_id']);
                $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);

                $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

                $data['specification']=$this->specification_model->select_one_active_unapproved_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->input->post('spec_id'),'specification_sheet.spec_version_no',$this->input->post('spec_version_no'),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/single-modify-form-with-cap',$data);
                $this->load->view('Home/footer');

              }else{
                  if(!empty($this->input->post('customer'))){
                      $customer_arr=explode('//',$this->input->post('customer'));
                    }

                    if(!empty($this->input->post('article_no'))){
                      $article_no_arr=explode('//',$this->input->post('article_no'));
                    }

                    if(!empty($this->input->post('cap_article_no'))){
                      $cap_article_no_arr=explode('//',$this->input->post('cap_article_no'));
                    }

                    if(!empty($this->input->post('cap_spec_no'))){
                      $cap_article_no_arr[2]=$this->input->post('cap_spec_no');
                      $cap_article_no_arr[3]=$this->input->post('cap_spec_version_no');
                    }


                $data=array('spec_id'=>$cap_article_no_arr[2],'spec_version_no'=>$cap_article_no_arr[3]);
                $data['specs_details']=$this->sales_order_book_model->select_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data);
                if($data['specs_details']==FALSE){
                  $CAP_DIA="";
                  $CAP_STYLE="";
                  $CAP_MOLD_FINISH="";
                  $CAP_ORIFICE="";
                  $CAP_MASTER_BATCH="";
                  $CAP_MB_PERC="";
                  $CAP_MB_SUPPLIER="";
                  $CAP_PP="";
                  $CAP_PP_PERC="";
                  $CAP_FOIL_COLOR="";
                  $CAP_FOIL_WIDTH="";
                  $CAP_FOIL_DIST_FROM_BOT="";
                  $CAP_SHRINK_SLEEVE="";
                  $CAP_SHRINK_SLEEVE_NAME="";
                }else{
                  foreach($data['specs_details'] as $specs_details_row){
                  $CAP_DIA=$specs_details_row->CAP_DIA;
                  $CAP_STYLE=$specs_details_row->CAP_STYLE;
                  $CAP_MOLD_FINISH=$specs_details_row->CAP_MOLD_FINISH;
                  $CAP_ORIFICE=$specs_details_row->CAP_ORIFICE;
                  $CAP_MASTER_BATCH=$specs_details_row->CAP_MASTER_BATCH;
                  $CAP_MB_PERC=$specs_details_row->CAP_MB_PERC;
                  $CAP_MB_SUPPLIER=$specs_details_row->CAP_MB_SUPPLIER;
                  $CAP_PP=$specs_details_row->CAP_PP;
                  $CAP_SHRINK_SLEEVE=$specs_details_row->CAP_SHRINK_SLEEVE;
                  $CAP_PP_PERC=$specs_details_row->CAP_PP_PERC;
                  $CAP_FOIL_COLOR=$specs_details_row->CAP_FOIL_COLOR;
                  $CAP_FOIL_WIDTH=$specs_details_row->CAP_FOIL_WIDTH;
                  $CAP_FOIL_DIST_FROM_BOT=$specs_details_row->CAP_FOIL_DIST_FROM_BOT;
                  $CAP_SHRINK_SLEEVE_NAME=$specs_details_row->CAP_SHRINK_SLEEVE_NAME;
                  }
                }

                    if(!empty($this->input->post('label_article_no'))){
                      $label_article=explode('//',$this->input->post('label_article_no'));
                    }else{
                      $label_article[1]='';
                    }

                    if(!empty($this->input->post('sleeve_dia'))){
                      $sleeve_dia=explode('//',$this->input->post('sleeve_dia'));
                    }else{
                      $sleeve_dia[0]='';
                    }

                    if(!empty($this->input->post('sl_mb_supplier'))){
                      $sl_mb_supplier=explode('//',$this->input->post('sl_mb_supplier'));
                    }else{
                      $sl_mb_supplier[1]='';
                    }

                    if(!empty($this->input->post('sh_mb_supplier'))){
                      $sh_mb_supplier=explode('//',$this->input->post('sh_mb_supplier'));
                    }else{
                      $sh_mb_supplier[1]='';
                    }

                    if(!empty($this->input->post('cap_mb_supplier'))){
                      $cap_mb_supplier=explode('//',$this->input->post('cap_mb_supplier'));
                    }else{
                      $cap_mb_supplier[1]='';
                    }

                    if(!empty($this->input->post('shoulder'))){
                      $shoulder=explode('//',$this->input->post('shoulder'));
                    }else{
                      $shoulder[0]='';
                      $shoulder[1]='';
                    }

                    if(!empty($this->input->post('shoulder_orifice'))){
                      $shoulder_orifice=explode('//',$this->input->post('shoulder_orifice'));
                    }else{
                      $shoulder_orifice[0]='';
                      $shoulder_orifice[1]='';
                    }

                    /*
                    if(!empty($this->input->post('cap_type'))){
                      $cap_type=explode('//',$this->input->post('cap_type'));
                    }else{
                      $cap_type[0]='';
                    }

                    if(!empty($this->input->post('cap_finish'))){
                      $cap_finish=explode('//',$this->input->post('cap_finish'));
                    }else{
                      $cap_finish[0]='';
                    }

                    if(!empty($this->input->post('cap_dia'))){
                      $cap_dia=explode('//',$this->input->post('cap_dia'));
                    }else{
                      $cap_dia[0]='';
                    }

                    if(!empty($this->input->post('cap_orifice'))){
                      $cap_orifice=explode('//',$this->input->post('cap_orifice'));
                    }else{
                      $cap_orifice[0]='';
                    }*/


                    $data['cap_diameter_master']=$this->common_model->select_one_active_record('cap_diameter_master',$this->session->userdata['logged_in']['company_id'],'cap_dia',$CAP_DIA);
            //echo $this->db->last_query();
            if($data['cap_diameter_master']==FALSE){
              $cap_dia_id="";
            }else{
             foreach($data['cap_diameter_master'] as $cap_diameter_master_row){
              $cap_dia_id=$cap_diameter_master_row->cap_dia_id;
             }
           }

            $data['cap_orifice_master']=$this->common_model->select_one_active_record('cap_orifice_master',$this->session->userdata['logged_in']['company_id'],'cap_orifice',$CAP_ORIFICE);
            if($data['cap_orifice_master']==FALSE){
              $cap_orifice_id="";
            }else{
              foreach($data['cap_orifice_master'] as $cap_orifice_master_row){
              $cap_orifice_id=$cap_orifice_master_row->cap_orifice_id;
               }
             }

             $data['cap_types_master']=$this->common_model->select_one_active_record('cap_types_master',$this->session->userdata['logged_in']['company_id'],'cap_type',$CAP_STYLE);
              if($data['cap_types_master']==FALSE){
                $cap_type_id="";
                }else{
                foreach($data['cap_types_master'] as $cap_types_master_row){
                  $cap_type_id=$cap_types_master_row->cap_type_id;
                 }
              }

             $data['cap_finish_master']=$this->common_model->select_one_active_record('cap_finish_master',$this->session->userdata['logged_in']['company_id'],'cap_finish',$CAP_MOLD_FINISH);
             if($data['cap_finish_master']==FALSE){
              $cap_finish_id="";
              }else{
              foreach($data['cap_finish_master'] as $cap_finish_master_row){
                $cap_finish_id=$cap_finish_master_row->cap_finish_id;
              }
              }



             
             $combination_data=array('sleeve_id'=>$sleeve_dia[1],
              'shld_type_id'=>$shoulder[1],
              'shld_orifice_id'=>$shoulder_orifice[1],
              'cap_dia_id'=>$cap_dia_id,
              'cap_orifice_id'=>$cap_orifice_id,
              'cap_type_id'=>$cap_type_id,
              'cap_finish_id'=>$cap_finish_id);

             $this->load->model('shoulder_orifice_dependancy_model');
             $this->shoulder_orifice_dependancy_model->select_one_active_combination_record('shoulder_orifice_dependancy',$this->session->userdata['logged_in']['company_id'],$combination_data);
             //echo $this->db->last_query();
             if($this->shoulder_orifice_dependancy_model->select_one_active_combination_record('shoulder_orifice_dependancy',$this->session->userdata['logged_in']['company_id'],$combination_data)>0){



                    $artwork_no="";
                    $artwork_version_no="";
                    if(!empty($this->input->post('artwork_final_version_no'))){

                      $data['artwork_final_version_no']=$this->artwork_model->select_artwork_final_version('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'article_no',$article_no_arr[1],'final_approval_flag','1','archive<>','1','ad_date','desc','ad_id','desc','version_no','desc');
                      foreach ($data['artwork_final_version_no'] as $artwork_final_version_no_row){
                         $artwork_no=$artwork_final_version_no_row->ad_id;
                         $artwork_version_no=$artwork_final_version_no_row->version_no;
                      }

                    } 

                    $data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$customer_arr[1]);
                    //echo $this->db->last_query();
                    foreach ($data['customer'] as $customer_row) {
                      $property=$customer_row->property_id;
                    }

                    $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                    'property_id'=>$property,
                    'adr_company_id'=>$customer_arr[1],
                    'article_no'=>$article_no_arr[1],
                    'ad_id'=>$artwork_no,
                    'version_no'=>$artwork_version_no);

                  $result=$this->specification_model->update_one_active_record('specification_sheet',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),$this->session->userdata['logged_in']['company_id']);

                  $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'spec_id'=>$this->input->post('spec_id'),'lang_comments'=>$this->input->post('comment'),'language_id'=>$this->session->userdata['logged_in']['language_id'],'spec_version_no'=>$this->input->post('spec_version_no'));

                  $result=$this->specification_model->update_one_active_record('specification_sheet_lang',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$sleeve_dia[0]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_1',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('sleeve_length').' MM');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_2',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('gauge').' MIC');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_4',$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$this->input->post('print_type'));

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_7',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_masterbatch'),'mat_info'=>$this->input->post('sl_mb_per').'%','supplier_no'=>$sl_mb_supplier[1]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_5_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_ldpe'),'mat_info'=>$this->input->post('sl_ldpe_per').'%');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_6_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_lldpe'),'mat_info'=>$this->input->post('sl_lldpe_per').'%');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_6_1',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_hdpe'),'mat_info'=>$this->input->post('sl_hdpe_per').'%');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_6_2',$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$shoulder[0]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_2',$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$shoulder[0]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_3',$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$shoulder_orifice[0]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_4',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('shoulder_foil_tag'));

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_8',$this->session->userdata['logged_in']['company_id']);


                  $data=array('mat_article_no'=>$this->input->post('sh_masterbatch'),'mat_info'=>$this->input->post('sh_mb_per').'%','supplier_no'=>$sh_mb_supplier[1]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_6_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sh_hdpe_one'),'mat_info'=>$this->input->post('sh_hdpe_one_per').'%');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_7_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sh_hdpe_two'),'mat_info'=>$this->input->post('sh_hdpe_two_per').'%');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_7_1',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$cap_article_no_arr[2]."//".$cap_article_no_arr[3]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_1',$this->session->userdata['logged_in']['company_id']);


                  $data=array('relating_master_value'=>$CAP_STYLE);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_2',$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$CAP_MOLD_FINISH);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_3',$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$CAP_DIA);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_4',$this->session->userdata['logged_in']['company_id']);


                  $data=array('parameter_value'=>$CAP_SHRINK_SLEEVE_NAME,'mat_article_no'=>$CAP_SHRINK_SLEEVE);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_5',$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$CAP_ORIFICE);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_6',$this->session->userdata['logged_in']['company_id']);


                  $data=array('mat_article_no'=>$CAP_MASTER_BATCH,'mat_info'=>$CAP_MB_PERC.'%','supplier_no'=>$CAP_MB_SUPPLIER);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_7_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$CAP_PP,'mat_info'=>$CAP_PP_PERC);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_8_1',$this->session->userdata['logged_in']['company_id']);


                  $data=array('mat_article_no'=>$CAP_FOIL_COLOR);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_9',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$CAP_FOIL_WIDTH);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_10',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$CAP_FOIL_DIST_FROM_BOT);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_11',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$label_article[1]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_12',$this->session->userdata['logged_in']['company_id']);

                  

                  

                  if(!empty($this->input->post('approval_authority'))){

                    $data=array('pending_flag'=>'1');

                    $result=$this->specification_model->update_one_active_record('specification_sheet',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),$this->session->userdata['logged_in']['company_id']);

                    $data['followup']=$this->common_model->select_one_active_record_nonlanguage_without_archive('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$this->input->post('record_no'));
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
                        'form_id'=>'985',
                        'transaction_no'=>$transaction_no,
                        'status'=>$status,
                        'followup_date'=>date('Y-m-d'),
                        'contact_person_id'=>$this->session->userdata['logged_in']['user_id'],
                        'record_no'=>$this->input->post('record_no'));

                      $result=$this->common_model->save('followup',$data);
                  }

                  $data['note']='Update Transaction Completed';
                  header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                  }else{
                   $data['error']='Wrong combination';
                  }

                  $data['specification']=$this->specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->input->post('spec_id'),'specification_sheet.spec_version_no',$this->input->post('spec_version_no'),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);
                  $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

                  $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
                  $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
                  $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
                  $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                  $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);

                  $dataa=array('article_main_group.main_group_id'=>'5');
                  $data['label']=$this->article_model->active_record_search('article',$dataa,$this->session->userdata['logged_in']['company_id']);
                  $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);

                  $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

                  

                  $data['page_name']='Sales';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                  $this->load->view(ucwords($this->router->fetch_class()).'/single-modify-form-with-cap',$data);
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


  function update_two_layer_with_cap(){
      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){
            $this->form_validation->set_rules('customer','Customer' ,'required|trim|xss_clean|callback_customer_check');
            $this->form_validation->set_rules('article_no','Article No' ,'required|trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('spec_version_no','Spec Version No' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('artwork_final_version_no','Artwork Version No' ,'trim|xss_clean');

            if($this->input->post('sleeve_dia')){

              $this->form_validation->set_rules('sleeve_dia','Sleeve Dia' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sleeve_length','Sleeve Length' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');
              $this->form_validation->set_rules('print_type','Print Type' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('gauge_one','Gauge Layer One' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');

              $this->form_validation->set_rules('sl_masterbatch_one','Sleeve Masterbatch Layer One' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sl_mb_supplier_one','Sleeve Masterbatch Supplier Layer One','trim|xss_clean|callback_supplier_check');
              $this->form_validation->set_rules('sl_mb_per_one','Sleeve Masterbatch % Layer One' ,'required|trim|xss_clean|numeric|max_length[3]');

              $this->form_validation->set_rules('sl_ldpe_per_one','Sleeve Ldpe % Layer One' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_one_check');
              $this->form_validation->set_rules('sl_lldpe_per_one','Sleeve Lldpe % Layer One' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_one_check');
              $this->form_validation->set_rules('sl_hdpe_per_one','Sleeve Hdpe % Layer One' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_one_check');

              if(!empty($this->input->post('sl_ldpe_per_one'))){
                $this->form_validation->set_rules('sl_ldpe_one','Sleeve Ldpe Layer One' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_lldpe_per_one'))){
                $this->form_validation->set_rules('sl_lldpe_one','Sleeve Lldpe Layer One' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_hdpe_per_one'))){
                $this->form_validation->set_rules('sl_hdpe_one','Sleeve Hdpe Layer One' ,'trim|xss_clean|required');
              }

              $this->form_validation->set_rules('gauge_two','Gauge Layer Two' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');
              $this->form_validation->set_rules('sl_masterbatch_two','Sleeve Masterbatch Layer Two' ,'trim|xss_clean');
              $this->form_validation->set_rules('sl_mb_supplier_two','Sleeve Masterbatch Supplier Layer Two','trim|xss_clean|callback_supplier_check');
              $this->form_validation->set_rules('sl_mb_per_two','Sleeve Masterbatch % Layer Two' ,'trim|xss_clean|numeric|max_length[3]');

              $this->form_validation->set_rules('sl_ldpe_per_two','Sleeve Ldpe % Layer Two' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_two_check');
              $this->form_validation->set_rules('sl_lldpe_per_two','Sleeve Lldpe % Layer Two' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_two_check');
              $this->form_validation->set_rules('sl_hdpe_per_two','Sleeve Hdpe % Layer Two' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_two_check');

              if(!empty($this->input->post('sl_ldpe_per_two'))){
                $this->form_validation->set_rules('sl_ldpe_two','Sleeve Ldpe Layer Two' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_lldpe_per'))){
                $this->form_validation->set_rules('sl_lldpe_two','Sleeve Lldpe Layer Two' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_hdpe_per'))){
                $this->form_validation->set_rules('sl_hdpe_two','Sleeve Hdpe Layer Two' ,'trim|xss_clean|required');
              }
              

            }
            
            if($this->input->post('shoulder')){
            
              $this->form_validation->set_rules('shoulder','Shoulder' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('shoulder_orifice','Shoulder Orifice' ,'trim|xss_clean');
              $this->form_validation->set_rules('shoulder_foil_tag','Shoulder Foil Tag' ,'required|trim|xss_clean|strtoupper');
              $this->form_validation->set_rules('sh_masterbatch','Shoulder Masterbatch' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sh_mb_supplier','Shoulder Masterbatch Supplier' ,'trim|xss_clean|callback_supplier_check');
              $this->form_validation->set_rules('sh_mb_per','Shoulder Masterbatch %' ,'required|trim|xss_clean|numeric|max_length[3]');
              $this->form_validation->set_rules('sh_hdpe_one_per','Shoulder HDPE %' ,'trim|xss_clean|is_natural|max_length[3]|callback_shoulder_per_check');
              $this->form_validation->set_rules('sh_hdpe_two_per','Shoulder HDPE %' ,'trim|xss_clean|is_natural|max_length[3]|callback_shoulder_per_check');

               if(!empty($this->input->post('sh_hdpe_one_per'))){
                $this->form_validation->set_rules('sh_hdpe_one','Shoulder Hdpe' ,'trim|xss_clean|required');
                }if(!empty($this->input->post('sh_hdpe_two_per'))){
                $this->form_validation->set_rules('sh_hdpe_two','Shoulder Hdpe' ,'trim|xss_clean|required');
                }

            }


            if(!empty($this->input->post('cap_spec_no'))){
              $this->form_validation->set_rules('cap_spec_no','Cap Spec No' ,'trim|xss_clean|required|exact_length[9]');
              $this->form_validation->set_rules('cap_spec_version_no','Cap Spec Version' ,'trim|xss_clean|required');
            }
            
            $this->form_validation->set_rules('label_article_no','Label Article No' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('cap_article_no','Cap Article No' ,'trim|xss_clean|callback_article_check');
              

              if($this->form_validation->run()==FALSE){

                $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
                $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
                $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
                $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
                $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

                $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
                $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
                $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
                $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
                $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);

                $dataa=array('article_main_group.main_group_id'=>'5');
                $data['label']=$this->article_model->active_record_search('article',$dataa,$this->session->userdata['logged_in']['company_id']);
                $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);


                $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

                $data['specification']=$this->specification_model->select_one_active_unapproved_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->input->post('spec_id'),'specification_sheet.spec_version_no',$this->input->post('spec_version_no'),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/two-modify-form-with-cap',$data);
                $this->load->view('Home/footer');

              }else{
                  if(!empty($this->input->post('customer'))){
                      $customer_arr=explode('//',$this->input->post('customer'));
                    }

                    if(!empty($this->input->post('article_no'))){
                      $article_no_arr=explode('//',$this->input->post('article_no'));
                    }


                    if(!empty($this->input->post('label_article_no'))){
                      $label_article=explode('//',$this->input->post('label_article_no'));
                    }else{
                      $label_article[1]='';
                    }


                    if(!empty($this->input->post('sleeve_dia'))){
                      $sleeve_dia=explode('//',$this->input->post('sleeve_dia'));
                    }else{
                      $sleeve_dia[0]='';
                    }

                    if(!empty($this->input->post('sl_mb_supplier_one'))){
                      $sl_mb_supplier_one=explode('//',$this->input->post('sl_mb_supplier_one'));
                    }else{
                      $sl_mb_supplier_one[1]='';
                    }


                    if(!empty($this->input->post('sl_mb_supplier_two'))){
                      $sl_mb_supplier_two=explode('//',$this->input->post('sl_mb_supplier_two'));
                    }else{
                      $sl_mb_supplier_two[1]='';
                    }

                    if(!empty($this->input->post('sh_mb_supplier'))){
                      $sh_mb_supplier=explode('//',$this->input->post('sh_mb_supplier'));
                    }else{
                      $sh_mb_supplier[1]='';
                    }

                    if(!empty($this->input->post('cap_mb_supplier'))){
                      $cap_mb_supplier=explode('//',$this->input->post('cap_mb_supplier'));
                    }else{
                      $cap_mb_supplier[1]='';
                    }

                    if(!empty($this->input->post('shoulder'))){
                      $shoulder=explode('//',$this->input->post('shoulder'));
                    }else{
                      $shoulder[0]='';
                    }

                    if(!empty($this->input->post('shoulder_orifice'))){
                      $shoulder_orifice=explode('//',$this->input->post('shoulder_orifice'));
                    }else{
                      $shoulder_orifice[0]='';
                    }

                    if(!empty($this->input->post('cap_article_no'))){
                      $cap_article_no_arr=explode('//',$this->input->post('cap_article_no'));
                    }

                    if(!empty($this->input->post('cap_spec_no'))){
                      $cap_article_no_arr[2]=$this->input->post('cap_spec_no');
                      $cap_article_no_arr[3]=$this->input->post('cap_spec_version_no');
                    }


                $data=array('spec_id'=>$cap_article_no_arr[2],'spec_version_no'=>$cap_article_no_arr[3]);
                $data['specs_details']=$this->sales_order_book_model->select_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data);
                if($data['specs_details']==FALSE){
                  $CAP_DIA="";
                  $CAP_STYLE="";
                  $CAP_MOLD_FINISH="";
                  $CAP_ORIFICE="";
                  $CAP_MASTER_BATCH="";
                  $CAP_MB_PERC="";
                  $CAP_MB_SUPPLIER="";
                  $CAP_PP="";
                  $CAP_PP_PERC="";
                  $CAP_FOIL_COLOR="";
                  $CAP_FOIL_WIDTH="";
                  $CAP_FOIL_DIST_FROM_BOT="";
                  $CAP_SHRINK_SLEEVE="";
                  $CAP_SHRINK_SLEEVE_NAME="";
                }else{
                  foreach($data['specs_details'] as $specs_details_row){
                  $CAP_DIA=$specs_details_row->CAP_DIA;
                  $CAP_STYLE=$specs_details_row->CAP_STYLE;
                  $CAP_MOLD_FINISH=$specs_details_row->CAP_MOLD_FINISH;
                  $CAP_ORIFICE=$specs_details_row->CAP_ORIFICE;
                  $CAP_MASTER_BATCH=$specs_details_row->CAP_MASTER_BATCH;
                  $CAP_MB_PERC=$specs_details_row->CAP_MB_PERC;
                  $CAP_MB_SUPPLIER=$specs_details_row->CAP_MB_SUPPLIER;
                  $CAP_PP=$specs_details_row->CAP_PP;
                  $CAP_SHRINK_SLEEVE=$specs_details_row->CAP_SHRINK_SLEEVE;
                  $CAP_PP_PERC=$specs_details_row->CAP_PP_PERC;
                  $CAP_FOIL_COLOR=$specs_details_row->CAP_FOIL_COLOR;
                  $CAP_FOIL_WIDTH=$specs_details_row->CAP_FOIL_WIDTH;
                  $CAP_FOIL_DIST_FROM_BOT=$specs_details_row->CAP_FOIL_DIST_FROM_BOT;
                  $CAP_SHRINK_SLEEVE_NAME=$specs_details_row->CAP_SHRINK_SLEEVE_NAME;
                  }
                }


                $data['cap_diameter_master']=$this->common_model->select_one_active_record('cap_diameter_master',$this->session->userdata['logged_in']['company_id'],'cap_dia',$CAP_DIA);
            //echo $this->db->last_query();
            if($data['cap_diameter_master']==FALSE){
              $cap_dia_id="";
            }else{
             foreach($data['cap_diameter_master'] as $cap_diameter_master_row){
              $cap_dia_id=$cap_diameter_master_row->cap_dia_id;
             }
           }

            $data['cap_orifice_master']=$this->common_model->select_one_active_record('cap_orifice_master',$this->session->userdata['logged_in']['company_id'],'cap_orifice',$CAP_ORIFICE);
            if($data['cap_orifice_master']==FALSE){
              $cap_orifice_id="";
            }else{
              foreach($data['cap_orifice_master'] as $cap_orifice_master_row){
              $cap_orifice_id=$cap_orifice_master_row->cap_orifice_id;
               }
             }

             $data['cap_types_master']=$this->common_model->select_one_active_record('cap_types_master',$this->session->userdata['logged_in']['company_id'],'cap_type',$CAP_STYLE);
              if($data['cap_types_master']==FALSE){
                $cap_type_id="";
                }else{
                foreach($data['cap_types_master'] as $cap_types_master_row){
                  $cap_type_id=$cap_types_master_row->cap_type_id;
                 }
              }

             $data['cap_finish_master']=$this->common_model->select_one_active_record('cap_finish_master',$this->session->userdata['logged_in']['company_id'],'cap_finish',$CAP_MOLD_FINISH);
             if($data['cap_finish_master']==FALSE){
              $cap_finish_id="";
              }else{
              foreach($data['cap_finish_master'] as $cap_finish_master_row){
                $cap_finish_id=$cap_finish_master_row->cap_finish_id;
              }
              }



             
             $combination_data=array('sleeve_id'=>$sleeve_dia[1],
              'shld_type_id'=>$shoulder[1],
              'shld_orifice_id'=>$shoulder_orifice[1],
              'cap_dia_id'=>$cap_dia_id,
              'cap_orifice_id'=>$cap_orifice_id,
              'cap_type_id'=>$cap_type_id,
              'cap_finish_id'=>$cap_finish_id);

             $this->load->model('shoulder_orifice_dependancy_model');
             $this->shoulder_orifice_dependancy_model->select_one_active_combination_record('shoulder_orifice_dependancy',$this->session->userdata['logged_in']['company_id'],$combination_data);
             //echo $this->db->last_query();
             if($this->shoulder_orifice_dependancy_model->select_one_active_combination_record('shoulder_orifice_dependancy',$this->session->userdata['logged_in']['company_id'],$combination_data)>0){

                    $artwork_no='';
                    $artwork_version_no='';
                    if(!empty($this->input->post('artwork_final_version_no'))){
                      $data['artwork_final_version_no']=$this->artwork_model->select_artwork_final_version('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'article_no',$article_no_arr[1],'final_approval_flag','1','archive<>','1','ad_date','desc','ad_id','desc','version_no','desc');
                    if($data['artwork_final_version_no']==FALSE){
                      $artwork_no='';
                      $artwork_version_no='';
                    }else{
                      foreach ($data['artwork_final_version_no'] as $artwork_final_version_no_row){
                         $artwork_no=$artwork_final_version_no_row->ad_id;
                         $artwork_version_no=$artwork_final_version_no_row->version_no;
                      }
                    }
                  }
                     

                    $data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$customer_arr[1]);
                    foreach ($data['customer'] as $customer_row) {
                      $property=$customer_row->property_id;
                    }

                    $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                    'property_id'=>$property,
                    'adr_company_id'=>$customer_arr[1],
                    'article_no'=>$article_no_arr[1],
                    'ad_id'=>$artwork_no,
                    'version_no'=>$artwork_version_no);

                  $result=$this->specification_model->update_one_active_record('specification_sheet',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$sleeve_dia[0]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_1',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('sleeve_length').' MM');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_2',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('gauge_one').' MIC');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_4',$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$this->input->post('print_type'));

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_7',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_masterbatch_one'),'mat_info'=>$this->input->post('sl_mb_per_one').'%','supplier_no'=>$sl_mb_supplier_one[1]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_5_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_ldpe_one'),'mat_info'=>$this->input->post('sl_ldpe_per_one').'%');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_6_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_lldpe_one'),'mat_info'=>$this->input->post('sl_lldpe_per_one').'%');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_6_1',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_hdpe_one'),'mat_info'=>$this->input->post('sl_hdpe_per_one').'%');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_6_2',$this->session->userdata['logged_in']['company_id']);

                  //Layer 2


                  $data=array('relating_master_value'=>$sleeve_dia[0]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_1',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('sleeve_length').' MM');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_2',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('gauge_two').' MIC');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_4',$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$this->input->post('print_type'));

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_7',$this->session->userdata['logged_in']['company_id']);

                  


                  //Layer 2
                  

                  $data=array('mat_article_no'=>$this->input->post('sl_masterbatch_two'),'mat_info'=>$this->input->post('sl_mb_per_two').'%','supplier_no'=>$sl_mb_supplier_two[1]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_5_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_ldpe_two'),'mat_info'=>$this->input->post('sl_ldpe_per_two').'%');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_6_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_lldpe_two'),'mat_info'=>$this->input->post('sl_lldpe_per_two').'%');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_6_1',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_hdpe_two'),'mat_info'=>$this->input->post('sl_hdpe_per_two').'%');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_6_2',$this->session->userdata['logged_in']['company_id']);

                 
                  
                  //Shoulder

                  $data=array('relating_master_value'=>$shoulder[0]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_2',$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$shoulder[0]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_3',$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$shoulder_orifice[0]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_4',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('shoulder_foil_tag'));

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_8',$this->session->userdata['logged_in']['company_id']);


                  $data=array('mat_article_no'=>$this->input->post('sh_masterbatch'),'mat_info'=>$this->input->post('sh_mb_per').'%','supplier_no'=>$sh_mb_supplier[1]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_6_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sh_hdpe_one'),'mat_info'=>$this->input->post('sh_hdpe_one_per').'%');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_7_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sh_hdpe_two'),'mat_info'=>$this->input->post('sh_hdpe_two_per').'%');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_7_1',$this->session->userdata['logged_in']['company_id']);

                  //Cap

                  $data=array('parameter_value'=>$cap_article_no_arr[2]."//".$cap_article_no_arr[3]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','4_1',$this->session->userdata['logged_in']['company_id']);

                   $data=array('relating_master_value'=>$CAP_STYLE);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','4_2',$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$CAP_MOLD_FINISH);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','4_3',$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$CAP_DIA);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','4_4',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$CAP_SHRINK_SLEEVE_NAME,'mat_article_no'=>$CAP_SHRINK_SLEEVE);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','4_5',$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$CAP_ORIFICE);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','4_6',$this->session->userdata['logged_in']['company_id']);


                  $data=array('mat_article_no'=>$CAP_MASTER_BATCH,'mat_info'=>$CAP_MB_PERC.'%','supplier_no'=>$CAP_MB_SUPPLIER);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','4_7_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$CAP_PP,'mat_info'=>$CAP_PP_PERC.'%');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','4_8_1',$this->session->userdata['logged_in']['company_id']);


                  $data=array('mat_article_no'=>$CAP_FOIL_COLOR);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','4_9',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$CAP_FOIL_WIDTH);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','4_10',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$CAP_FOIL_DIST_FROM_BOT);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','4_11',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$label_article[1]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','4_12',$this->session->userdata['logged_in']['company_id']);

                  if(!empty($this->input->post('approval_authority'))){

                    $data=array('pending_flag'=>'1');
                    $result=$this->specification_model->update_one_active_record('specification_sheet',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),$this->session->userdata['logged_in']['company_id']);

                    $data['followup']=$this->common_model->select_one_active_record_nonlanguage_without_archive('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$this->input->post('record_no'));
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
                        'form_id'=>'985',
                        'transaction_no'=>$transaction_no,
                        'status'=>$status,
                        'followup_date'=>date('Y-m-d'),
                        'contact_person_id'=>$this->session->userdata['logged_in']['user_id'],
                        'record_no'=>$this->input->post('record_no'),
                        );

                      $result=$this->common_model->save('followup',$data);
                  }

                  $data['note']='Update Transaction Completed';
                  header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                  }else{
                    $data['error']='Wrong combination';
                  }
                  $data['specification']=$this->specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->input->post('spec_id'),'specification_sheet.spec_version_no',$this->input->post('spec_version_no'),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);
                  $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

                  $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
                  $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
                  $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
                  $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                  $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);

                  $dataa=array('article_main_group.main_group_id'=>'5');
                  $data['label']=$this->article_model->active_record_search('article',$dataa,$this->session->userdata['logged_in']['company_id']);
                  $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);


                  $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

                  

                  $data['page_name']='Sales';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                  $this->load->view(ucwords($this->router->fetch_class()).'/two-modify-form-with-cap',$data);
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


  function update_three_layer_with_cap(){
      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){
            $this->form_validation->set_rules('customer','Customer' ,'required|trim|xss_clean|callback_customer_check');
            $this->form_validation->set_rules('article_no','Article No' ,'required|trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('spec_version_no','Spec Version No' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('artwork_final_version_no','Artwork Version No' ,'trim|xss_clean');

            if($this->input->post('sleeve_dia')){

              $this->form_validation->set_rules('sleeve_dia','Sleeve Dia' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sleeve_length','Sleeve Length' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');
              $this->form_validation->set_rules('print_type','Print Type' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('gauge_one','Gauge Layer One' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');

              $this->form_validation->set_rules('sl_masterbatch_one','Sleeve Masterbatch Layer One' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sl_mb_supplier_one','Sleeve Masterbatch Supplier Layer One','trim|xss_clean|callback_supplier_check');
              $this->form_validation->set_rules('sl_mb_per_one','Sleeve Masterbatch % Layer One' ,'required|trim|xss_clean|numeric|max_length[3]');

              $this->form_validation->set_rules('sl_ldpe_per_one','Sleeve Ldpe % Layer One' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_one_check');
              $this->form_validation->set_rules('sl_lldpe_per_one','Sleeve Lldpe % Layer One' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_one_check');
              $this->form_validation->set_rules('sl_hdpe_per_one','Sleeve Hdpe % Layer One' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_one_check');

              if(!empty($this->input->post('sl_ldpe_per_one'))){
                $this->form_validation->set_rules('sl_ldpe_one','Sleeve Ldpe Layer One' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_lldpe_per_one'))){
                $this->form_validation->set_rules('sl_lldpe_one','Sleeve Lldpe Layer One' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_hdpe_per_one'))){
                $this->form_validation->set_rules('sl_hdpe_one','Sleeve Hdpe Layer One' ,'trim|xss_clean|required');
              }

              $this->form_validation->set_rules('gauge_two','Gauge Layer Two' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');
               $this->form_validation->set_rules('sl_hdpe_two','Sleeve Hdpe  Layer two' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sl_hdpe_per_two','Sleeve Hdpe % Layer two' ,'required|trim|xss_clean|numeric|exact_length[3]');

              $this->form_validation->set_rules('gauge_three','Gauge Layer Three' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');
              $this->form_validation->set_rules('sl_masterbatch_three','Sleeve Masterbatch Layer Three' ,'trim|xss_clean');
              $this->form_validation->set_rules('sl_mb_supplier_three','Sleeve Masterbatch Supplier Layer Three','trim|xss_clean|callback_supplier_check');
              $this->form_validation->set_rules('sl_mb_per_three','Sleeve Masterbatch % Layer Three' ,'trim|xss_clean|numeric|max_length[3]');

              $this->form_validation->set_rules('sl_ldpe_per_three','Sleeve Ldpe % Layer Three' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_three_check');
              $this->form_validation->set_rules('sl_lldpe_per_three','Sleeve Lldpe % Layer Three' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_three_check');
              $this->form_validation->set_rules('sl_hdpe_per_three','Sleeve Hdpe % Layer Three' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_three_check');

              if(!empty($this->input->post('sl_ldpe_per_three'))){
                $this->form_validation->set_rules('sl_ldpe_three','Sleeve Ldpe Layer Three' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_lldpe_per'))){
                $this->form_validation->set_rules('sl_lldpe_three','Sleeve Lldpe Layer Three' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_hdpe_per'))){
                $this->form_validation->set_rules('sl_hdpe_three','Sleeve Hdpe Layer Three' ,'trim|xss_clean|required');
              }
              

            }
            
            if($this->input->post('shoulder')){
            
              $this->form_validation->set_rules('shoulder','Shoulder' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('shoulder_orifice','Shoulder Orifice' ,'trim|xss_clean');
              $this->form_validation->set_rules('shoulder_foil_tag','Shoulder Foil Tag' ,'required|trim|xss_clean|strtoupper');
              $this->form_validation->set_rules('sh_masterbatch','Shoulder Masterbatch' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sh_mb_supplier','Shoulder Masterbatch Supplier' ,'trim|xss_clean|callback_supplier_check');
              $this->form_validation->set_rules('sh_mb_per','Shoulder Masterbatch %' ,'required|trim|xss_clean|numeric|max_length[3]');
              $this->form_validation->set_rules('sh_hdpe_one_per','Shoulder HDPE %' ,'trim|xss_clean|is_natural|max_length[3]|callback_shoulder_per_check');
              $this->form_validation->set_rules('sh_hdpe_two_per','Shoulder HDPE %' ,'trim|xss_clean|is_natural|max_length[3]|callback_shoulder_per_check');

               if(!empty($this->input->post('sh_hdpe_one_per'))){
                $this->form_validation->set_rules('sh_hdpe_one','Shoulder Hdpe' ,'trim|xss_clean|required');
                }if(!empty($this->input->post('sh_hdpe_two_per'))){
                $this->form_validation->set_rules('sh_hdpe_two','Shoulder Hdpe' ,'trim|xss_clean|required');
                }

            }


            if(!empty($this->input->post('cap_spec_no'))){
              $this->form_validation->set_rules('cap_spec_no','Cap Spec No' ,'trim|xss_clean|required|exact_length[9]');
              $this->form_validation->set_rules('cap_spec_version_no','Cap Spec Version' ,'trim|xss_clean|required');
            }

            $this->form_validation->set_rules('label_article_no','Label Article No' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('cap_article_no','Cap Article No' ,'trim|xss_clean|callback_article_check');
              

              if($this->form_validation->run()==FALSE){

                $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
                $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
                $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
                $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
                $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

                $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
                $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
                $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
                $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
                $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);

                $dataa=array('article_main_group.main_group_id'=>'5');
                $data['label']=$this->article_model->active_record_search('article',$dataa,$this->session->userdata['logged_in']['company_id']);
                $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);

                $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

                $data['specification']=$this->specification_model->select_one_active_unapproved_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->input->post('spec_id'),'specification_sheet.spec_version_no',$this->input->post('spec_version_no'),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/three-modify-form-with-cap',$data);
                $this->load->view('Home/footer');

              }else{
                  if(!empty($this->input->post('customer'))){
                      $customer_arr=explode('//',$this->input->post('customer'));
                    }

                    if(!empty($this->input->post('article_no'))){
                      $article_no_arr=explode('//',$this->input->post('article_no'));
                    }

                    if(!empty($this->input->post('cap_article_no'))){
                $cap_article_no_arr=explode('//',$this->input->post('cap_article_no'));
              }

              if(!empty($this->input->post('cap_spec_no'))){
                $cap_article_no_arr[2]=$this->input->post('cap_spec_no');
                $cap_article_no_arr[3]=$this->input->post('cap_spec_version_no');
              }


              $data=array('spec_id'=>$cap_article_no_arr[2],
                  'spec_version_no'=>$cap_article_no_arr[3]);
                $data['specs_details']=$this->sales_order_book_model->select_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data);
                if($data['specs_details']==FALSE){
                  $CAP_DIA="";
                  $CAP_STYLE="";
                  $CAP_MOLD_FINISH="";
                  $CAP_ORIFICE="";
                  $CAP_MASTER_BATCH="";
                  $CAP_MB_PERC="";
                  $CAP_MB_SUPPLIER="";
                  $CAP_PP="";
                  $CAP_PP_PERC="";
                  $CAP_FOIL_COLOR="";
                  $CAP_FOIL_WIDTH="";
                  $CAP_FOIL_DIST_FROM_BOT="";
                  $CAP_SHRINK_SLEEVE="";
                  $CAP_SHRINK_SLEEVE_NAME="";
                }else{
                  foreach($data['specs_details'] as $specs_details_row){
                  $CAP_DIA=$specs_details_row->CAP_DIA;
                  $CAP_STYLE=$specs_details_row->CAP_STYLE;
                  $CAP_MOLD_FINISH=$specs_details_row->CAP_MOLD_FINISH;
                  $CAP_ORIFICE=$specs_details_row->CAP_ORIFICE;
                  $CAP_MASTER_BATCH=$specs_details_row->CAP_MASTER_BATCH;
                  $CAP_MB_PERC=$specs_details_row->CAP_MB_PERC;
                  $CAP_MB_SUPPLIER=$specs_details_row->CAP_MB_SUPPLIER;
                  $CAP_PP=$specs_details_row->CAP_PP;
                  $CAP_PP_PERC=$specs_details_row->CAP_PP_PERC;
                  $CAP_FOIL_COLOR=$specs_details_row->CAP_FOIL_COLOR;
                  $CAP_FOIL_WIDTH=$specs_details_row->CAP_FOIL_WIDTH;
                  $CAP_FOIL_DIST_FROM_BOT=$specs_details_row->CAP_FOIL_DIST_FROM_BOT;
                  $CAP_SHRINK_SLEEVE=$specs_details_row->CAP_SHRINK_SLEEVE;
                  $CAP_SHRINK_SLEEVE_NAME=$specs_details_row->CAP_SHRINK_SLEEVE_NAME;
                  }
                }

                    if(!empty($this->input->post('label_article_no'))){
                      $label_article=explode('//',$this->input->post('label_article_no'));
                    }else{
                      $label_article[1]='';
                    }

                    if(!empty($this->input->post('sleeve_dia'))){
                      $sleeve_dia=explode('//',$this->input->post('sleeve_dia'));
                    }else{
                      $sleeve_dia[0]='';
                    }

                    if(!empty($this->input->post('sl_mb_supplier_one'))){
                      $sl_mb_supplier_one=explode('//',$this->input->post('sl_mb_supplier_one'));
                    }else{
                      $sl_mb_supplier_one[1]='';
                    }


                    if(!empty($this->input->post('sl_mb_supplier_three'))){
                      $sl_mb_supplier_three=explode('//',$this->input->post('sl_mb_supplier_three'));
                    }else{
                      $sl_mb_supplier_three[1]='';
                    }

                    if(!empty($this->input->post('sh_mb_supplier'))){
                      $sh_mb_supplier=explode('//',$this->input->post('sh_mb_supplier'));
                    }else{
                      $sh_mb_supplier[1]='';
                    }

                    if(!empty($this->input->post('cap_mb_supplier'))){
                      $cap_mb_supplier=explode('//',$this->input->post('cap_mb_supplier'));
                    }else{
                      $cap_mb_supplier[1]='';
                    }

                    if(!empty($this->input->post('shoulder'))){
                      $shoulder=explode('//',$this->input->post('shoulder'));
                    }else{
                      $shoulder[0]='';
                    }

                    if(!empty($this->input->post('shoulder_orifice'))){
                      $shoulder_orifice=explode('//',$this->input->post('shoulder_orifice'));
                    }else{
                      $shoulder_orifice[0]='';
                    }

                    /*
                    if(!empty($this->input->post('cap_type'))){
                      $cap_type=explode('//',$this->input->post('cap_type'));
                    }else{
                      $cap_type[0]='';
                    }

                    if(!empty($this->input->post('cap_finish'))){
                      $cap_finish=explode('//',$this->input->post('cap_finish'));
                    }else{
                      $cap_finish[0]='';
                    }

                    if(!empty($this->input->post('cap_dia'))){
                      $cap_dia=explode('//',$this->input->post('cap_dia'));
                    }else{
                      $cap_dia[0]='';
                    }

                    if(!empty($this->input->post('cap_orifice'))){
                      $cap_orifice=explode('//',$this->input->post('cap_orifice'));
                    }else{
                      $cap_orifice[0]='';
                    }
                    */


                    $data['cap_diameter_master']=$this->common_model->select_one_active_record('cap_diameter_master',$this->session->userdata['logged_in']['company_id'],'cap_dia',$CAP_DIA);
            //echo $this->db->last_query();
            if($data['cap_diameter_master']==FALSE){
              $cap_dia_id="";
            }else{
             foreach($data['cap_diameter_master'] as $cap_diameter_master_row){
              $cap_dia_id=$cap_diameter_master_row->cap_dia_id;
             }
           }

            $data['cap_orifice_master']=$this->common_model->select_one_active_record('cap_orifice_master',$this->session->userdata['logged_in']['company_id'],'cap_orifice',$CAP_ORIFICE);
            if($data['cap_orifice_master']==FALSE){
              $cap_orifice_id="";
            }else{
              foreach($data['cap_orifice_master'] as $cap_orifice_master_row){
              $cap_orifice_id=$cap_orifice_master_row->cap_orifice_id;
               }
             }

             $data['cap_types_master']=$this->common_model->select_one_active_record('cap_types_master',$this->session->userdata['logged_in']['company_id'],'cap_type',$CAP_STYLE);
              if($data['cap_types_master']==FALSE){
                $cap_type_id="";
                }else{
                foreach($data['cap_types_master'] as $cap_types_master_row){
                  $cap_type_id=$cap_types_master_row->cap_type_id;
                 }
              }

             $data['cap_finish_master']=$this->common_model->select_one_active_record('cap_finish_master',$this->session->userdata['logged_in']['company_id'],'cap_finish',$CAP_MOLD_FINISH);
             if($data['cap_finish_master']==FALSE){
              $cap_finish_id="";
              }else{
              foreach($data['cap_finish_master'] as $cap_finish_master_row){
                $cap_finish_id=$cap_finish_master_row->cap_finish_id;
              }
              }



             
             $combination_data=array('sleeve_id'=>$sleeve_dia[1],
              'shld_type_id'=>$shoulder[1],
              'shld_orifice_id'=>$shoulder_orifice[1],
              'cap_dia_id'=>$cap_dia_id,
              'cap_orifice_id'=>$cap_orifice_id,
              'cap_type_id'=>$cap_type_id,
              'cap_finish_id'=>$cap_finish_id);

             $this->load->model('shoulder_orifice_dependancy_model');
             $this->shoulder_orifice_dependancy_model->select_one_active_combination_record('shoulder_orifice_dependancy',$this->session->userdata['logged_in']['company_id'],$combination_data);
             //echo $this->db->last_query();
             if($this->shoulder_orifice_dependancy_model->select_one_active_combination_record('shoulder_orifice_dependancy',$this->session->userdata['logged_in']['company_id'],$combination_data)>0){

                    $artwork_no='';
                    $artwork_version_no='';
                    if(!empty($this->input->post('artwork_final_version_no'))){
                      $data['artwork_final_version_no']=$this->artwork_model->select_artwork_final_version('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'article_no',$article_no_arr[1],'final_approval_flag','1','archive<>','1','ad_date','desc','ad_id','desc','version_no','desc');
                    if($data['artwork_final_version_no']==FALSE){
                      $artwork_no='';
                      $artwork_version_no='';
                    }else{
                      foreach ($data['artwork_final_version_no'] as $artwork_final_version_no_row){
                         $artwork_no=$artwork_final_version_no_row->ad_id;
                         $artwork_version_no=$artwork_final_version_no_row->version_no;
                      }
                    }
                  }
                     

                    $data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$customer_arr[1]);
                    foreach ($data['customer'] as $customer_row) {
                      $property=$customer_row->property_id;
                    }

                    $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                    'property_id'=>$property,
                    'adr_company_id'=>$customer_arr[1],
                    'article_no'=>$article_no_arr[1],
                    'ad_id'=>$artwork_no,
                    'version_no'=>$artwork_version_no);

                  $result=$this->specification_model->update_one_active_record('specification_sheet',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$sleeve_dia[0]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_1',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('sleeve_length').' MM');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_2',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('gauge_one').' MIC');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_4',$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$this->input->post('print_type'));

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_7',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_masterbatch_one'),'mat_info'=>$this->input->post('sl_mb_per_one').'%','supplier_no'=>$sl_mb_supplier_one[1]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_5_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_ldpe_one'),'mat_info'=>$this->input->post('sl_ldpe_per_one').'%');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_6_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_lldpe_one'),'mat_info'=>$this->input->post('sl_lldpe_per_one').'%');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_6_1',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_hdpe_one'),'mat_info'=>$this->input->post('sl_hdpe_per_one').'%');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_6_2',$this->session->userdata['logged_in']['company_id']);

                  //Layer 2


                  $data=array('relating_master_value'=>$sleeve_dia[0]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_1',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('sleeve_length').' MM');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_2',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('gauge_two').' MIC');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_4',$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$this->input->post('print_type'));

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_7',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_hdpe_two'),'mat_info'=>$this->input->post('sl_hdpe_per_two').'%');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_6_2',$this->session->userdata['logged_in']['company_id']);


                  //Layer 3
                  $data=array('relating_master_value'=>$sleeve_dia[0]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_1',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('sleeve_length').' MM');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_2',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('gauge_two').' MIC');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_4',$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$this->input->post('print_type'));

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_7',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_masterbatch_three'),'mat_info'=>$this->input->post('sl_mb_per_three').'%','supplier_no'=>$sl_mb_supplier_three[1]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_5_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_ldpe_three'),'mat_info'=>$this->input->post('sl_ldpe_per_three').'%');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_6_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_lldpe_three'),'mat_info'=>$this->input->post('sl_lldpe_per_three').'%');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_6_1',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_hdpe_three'),'mat_info'=>$this->input->post('sl_hdpe_per_three').'%');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_6_2',$this->session->userdata['logged_in']['company_id']);
                  
                  //Shoulder

                  $data=array('relating_master_value'=>$shoulder[0]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','4_2',$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$shoulder[0]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','4_3',$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$shoulder_orifice[0]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','4_4',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('shoulder_foil_tag'));

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','4_8',$this->session->userdata['logged_in']['company_id']);


                  $data=array('mat_article_no'=>$this->input->post('sh_masterbatch'),'mat_info'=>$this->input->post('sh_mb_per').'%','supplier_no'=>$sh_mb_supplier[1]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','4_6_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sh_hdpe_one'),'mat_info'=>$this->input->post('sh_hdpe_one_per').'%');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','4_7_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sh_hdpe_two'),'mat_info'=>$this->input->post('sh_hdpe_two_per').'%');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','4_7_1',$this->session->userdata['logged_in']['company_id']);

                  //Cap

                  $data=array('parameter_value'=>$cap_article_no_arr[2]."//".$cap_article_no_arr[3]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','5_1',$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$CAP_STYLE);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','5_2',$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$CAP_MOLD_FINISH);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','5_3',$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$CAP_DIA);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','5_4',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$CAP_SHRINK_SLEEVE_NAME,'mat_article_no'=>$CAP_SHRINK_SLEEVE);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','5_5',$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$CAP_ORIFICE);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','5_6',$this->session->userdata['logged_in']['company_id']);


                  $data=array('mat_article_no'=>$CAP_MASTER_BATCH,'mat_info'=>$CAP_MB_PERC.'%','supplier_no'=>$CAP_MB_SUPPLIER);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','5_7_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$CAP_PP,'mat_info'=>$CAP_PP_PERC);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','5_8_1',$this->session->userdata['logged_in']['company_id']);


                  $data=array('mat_article_no'=>$CAP_FOIL_COLOR);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','5_9',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$CAP_FOIL_WIDTH);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','5_10',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$CAP_FOIL_DIST_FROM_BOT);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','5_11',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$label_article[1]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','5_12',$this->session->userdata['logged_in']['company_id']);

                  if(!empty($this->input->post('approval_authority'))){

                    $data=array('pending_flag'=>'1');
                    $result=$this->specification_model->update_one_active_record('specification_sheet',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),$this->session->userdata['logged_in']['company_id']);

                    $data['followup']=$this->common_model->select_one_active_record_nonlanguage_without_archive('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$this->input->post('record_no'));
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
                        'form_id'=>'985',
                        'transaction_no'=>$transaction_no,
                        'status'=>$status,
                        'followup_date'=>date('Y-m-d'),
                        'contact_person_id'=>$this->session->userdata['logged_in']['user_id'],
                        'record_no'=>$this->input->post('record_no'),
                        );

                      $result=$this->common_model->save('followup',$data);
                  }

                  $data['note']='Update Transaction Completed';

                  header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());


                  }else{
                    $data['error']='Wrong combination';
                }
                  $data['specification']=$this->specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->input->post('spec_id'),'specification_sheet.spec_version_no',$this->input->post('spec_version_no'),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);
                  $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

                  $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
                  $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
                  $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
                  $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                  $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);

                  $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

                  $dataa=array('article_main_group.main_group_id'=>'5');
                  $data['label']=$this->article_model->active_record_search('article',$dataa,$this->session->userdata['logged_in']['company_id']);
                  $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);


                  $data['page_name']='Sales';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                  $this->load->view(ucwords($this->router->fetch_class()).'/three-modify-form-with-cap',$data);
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




   function create_three_layer_with_cap(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

            $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
            $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
            $data['admer']=$this->article_model->spec_active_record_search('article','15',$this->session->userdata['logged_in']['company_id']);
            $data['evoh']=$this->article_model->spec_active_record_search('article','16',$this->session->userdata['logged_in']['company_id']);
            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
            $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);

            $dataa=array('article_main_group.main_group_id'=>'5');
            $data['label']=$this->article_model->active_record_search('article',$dataa,$this->session->userdata['logged_in']['company_id']);
            $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/create-three-form',$data);
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


  function save_three_layer_with_cap(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $this->form_validation->set_rules('customer','Customer' ,'required|trim|xss_clean|callback_customer_check');
            $this->form_validation->set_rules('article_no','Article No' ,'required|trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('spec_version_no','Spec Version No' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('artwork_final_version_no','Artwork Version No' ,'trim|xss_clean');

            if($this->input->post('sleeve_dia')){

              $this->form_validation->set_rules('sleeve_dia','Sleeve Dia' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sleeve_length','Sleeve Length' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');
              $this->form_validation->set_rules('gauge_one','Gauge Layer One' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');
              $this->form_validation->set_rules('print_type','Print Type' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sl_masterbatch_one','Sleeve Masterbatch Layer One' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sl_mb_supplier_one','Sleeve Masterbatch Supplier Layer One','trim|xss_clean|callback_supplier_check');
              $this->form_validation->set_rules('sl_mb_per_one','Sleeve Masterbatch % Layer One' ,'required|trim|xss_clean|numeric|max_length[3]');

              $this->form_validation->set_rules('sl_ldpe_per_one','Sleeve Ldpe % Layer One' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_one_check');
              $this->form_validation->set_rules('sl_lldpe_per_one','Sleeve Lldpe % Layer One' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_one_check');
              $this->form_validation->set_rules('sl_hdpe_per_one','Sleeve Hdpe % Layer One' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_one_check');

              if(!empty($this->input->post('sl_ldpe_per_one'))){
                $this->form_validation->set_rules('sl_ldpe_one','Sleeve Ldpe Layer One' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_lldpe_per'))){
                $this->form_validation->set_rules('sl_lldpe_one','Sleeve Lldpe Layer One' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_hdpe_per'))){
                $this->form_validation->set_rules('sl_hdpe_one','Sleeve Hdpe Layer One' ,'trim|xss_clean|required');
              }


              $this->form_validation->set_rules('gauge_two','Gauge Layer Two' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');
              $this->form_validation->set_rules('sl_hdpe_two','Sleeve Hdpe  Layer two' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sl_hdpe_per_two','Sleeve Hdpe % Layer two' ,'required|trim|xss_clean|numeric|max_length[3]');

              $this->form_validation->set_rules('gauge_three','Gauge Layer Three' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');
              $this->form_validation->set_rules('sl_masterbatch_three','Sleeve Masterbatch Layer Three' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sl_mb_supplier_three','Sleeve Masterbatch Supplier Layer Three','trim|xss_clean|callback_supplier_check');
              $this->form_validation->set_rules('sl_mb_per_three','Sleeve Masterbatch % Layer Three' ,'required|trim|xss_clean|numeric|max_length[3]');

              $this->form_validation->set_rules('sl_ldpe_per_three','Sleeve Ldpe % Layer Three' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_three_check');
              $this->form_validation->set_rules('sl_lldpe_per_three','Sleeve Lldpe % Layer Three' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_three_check');
              $this->form_validation->set_rules('sl_hdpe_per_three','Sleeve Hdpe % Layer Three' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_three_check');

              if(!empty($this->input->post('sl_ldpe_per_three'))){
                $this->form_validation->set_rules('sl_ldpe_three','Sleeve Ldpe Layer Three' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_lldpe_per'))){
                $this->form_validation->set_rules('sl_lldpe_three','Sleeve Lldpe Layer Three' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_hdpe_per'))){
                $this->form_validation->set_rules('sl_hdpe_three','Sleeve Hdpe Layer Three' ,'trim|xss_clean|required');
              }
              

            }
            
            if($this->input->post('shoulder')){
            
              $this->form_validation->set_rules('shoulder','Shoulder' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('shoulder_orifice','Shoulder Orifice' ,'trim|xss_clean');
              $this->form_validation->set_rules('sh_masterbatch','Shoulder Masterbatch' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sh_mb_supplier','Shoulder Masterbatch Supplier' ,'trim|xss_clean|callback_supplier_check');
              $this->form_validation->set_rules('sh_mb_per','Shoulder Masterbatch %' ,'required|trim|xss_clean|numeric|max_length[3]');
              $this->form_validation->set_rules('sh_hdpe_one_per','Shoulder HDPE %' ,'trim|xss_clean|numeric|max_length[3]|callback_shoulder_per_check');
              $this->form_validation->set_rules('sh_hdpe_two_per','Shoulder HDPE %' ,'trim|xss_clean|numeric|max_length[3]|callback_shoulder_per_check');

               if(!empty($this->input->post('sh_hdpe_one_per'))){
                $this->form_validation->set_rules('sh_hdpe_one','Shoulder Hdpe' ,'trim|xss_clean|required');
                }if(!empty($this->input->post('sh_hdpe_two_per'))){
                $this->form_validation->set_rules('sh_hdpe_two','Shoulder Hdpe' ,'trim|xss_clean|required');
                }

            }


            if(!empty($this->input->post('cap_spec_no'))){
              $this->form_validation->set_rules('cap_spec_no','Cap Spec No' ,'trim|xss_clean|required|exact_length[9]');
              $this->form_validation->set_rules('cap_spec_version_no','Cap Spec Version' ,'trim|xss_clean|required');
            }

            $this->form_validation->set_rules('label_article_no','Label Article No' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('cap_article_no','Cap Article No' ,'trim|xss_clean|callback_article_check');


            if($this->form_validation->run()==FALSE){
              
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

            $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
            $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
            $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);

            $dataa=array('article_main_group.main_group_id'=>'5');
            $data['label']=$this->article_model->active_record_search('article',$dataa,$this->session->userdata['logged_in']['company_id']);
            $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);


              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-three-form',$data);
              $this->load->view('Home/footer');
            }else{

              if(!empty($this->input->post('customer'))){
                $customer_arr=explode('//',$this->input->post('customer'));
              }

              if(!empty($this->input->post('article_no'))){
                $article_no_arr=explode('//',$this->input->post('article_no'));
              }

              if(!empty($this->input->post('cap_article_no'))){
                $cap_article_no_arr=explode('//',$this->input->post('cap_article_no'));
              }

              if(!empty($this->input->post('cap_spec_no'))){
                $cap_article_no_arr[2]=$this->input->post('cap_spec_no');
                $cap_article_no_arr[3]=$this->input->post('cap_spec_version_no');
              }


              $data=array('spec_id'=>$cap_article_no_arr[2],
                  'spec_version_no'=>$cap_article_no_arr[3]);
                $data['specs_details']=$this->sales_order_book_model->select_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data);
                if($data['specs_details']==FALSE){
                  $CAP_DIA="";
                  $CAP_STYLE="";
                  $CAP_MOLD_FINISH="";
                  $CAP_ORIFICE="";
                  $CAP_MASTER_BATCH="";
                  $CAP_MB_PERC="";
                  $CAP_MB_SUPPLIER="";
                  $CAP_PP="";
                  $CAP_PP_PERC="";
                  $CAP_FOIL_COLOR="";
                  $CAP_FOIL_WIDTH="";
                  $CAP_FOIL_DIST_FROM_BOT="";
                  $CAP_SHRINK_SLEEVE="";
                  $CAP_SHRINK_SLEEVE_NAME="";
                }else{
                  foreach($data['specs_details'] as $specs_details_row){
                  $CAP_DIA=$specs_details_row->CAP_DIA;
                  $CAP_STYLE=$specs_details_row->CAP_STYLE;
                  $CAP_MOLD_FINISH=$specs_details_row->CAP_MOLD_FINISH;
                  $CAP_ORIFICE=$specs_details_row->CAP_ORIFICE;
                  $CAP_MASTER_BATCH=$specs_details_row->CAP_MASTER_BATCH;
                  $CAP_MB_PERC=$specs_details_row->CAP_MB_PERC;
                  $CAP_MB_SUPPLIER=$specs_details_row->CAP_MB_SUPPLIER;
                  $CAP_PP=$specs_details_row->CAP_PP;
                  $CAP_PP_PERC=$specs_details_row->CAP_PP_PERC;
                  $CAP_FOIL_COLOR=$specs_details_row->CAP_FOIL_COLOR;
                  $CAP_FOIL_WIDTH=$specs_details_row->CAP_FOIL_WIDTH;
                  $CAP_FOIL_DIST_FROM_BOT=$specs_details_row->CAP_FOIL_DIST_FROM_BOT;
                  $CAP_SHRINK_SLEEVE=$specs_details_row->CAP_SHRINK_SLEEVE;
                  $CAP_SHRINK_SLEEVE_NAME=$specs_details_row->CAP_SHRINK_SLEEVE_NAME;
                  }
                }
                
              if(!empty($this->input->post('label_article_no'))){
                $label_article=explode('//',$this->input->post('label_article_no'));
              }else{
                $label_article[1]='';
              }

              if(!empty($this->input->post('sleeve_dia'))){
                $sleeve_dia=explode('//',$this->input->post('sleeve_dia'));
              }else{
                $sleeve_dia[0]='';
              }

              if(!empty($this->input->post('sl_mb_supplier_one'))){
                $sl_mb_supplier_one=explode('//',$this->input->post('sl_mb_supplier_one'));
              }else{
                $sl_mb_supplier_one[1]='';
              }

              if(!empty($this->input->post('sl_mb_supplier_three'))){
                $sl_mb_supplier_three=explode('//',$this->input->post('sl_mb_supplier_three'));
              }else{
                $sl_mb_supplier_three[1]='';
              }

              if(!empty($this->input->post('sh_mb_supplier'))){
                $sh_mb_supplier=explode('//',$this->input->post('sh_mb_supplier'));
              }else{
                $sh_mb_supplier[1]='';
              }

              if(!empty($this->input->post('cap_mb_supplier'))){
                $cap_mb_supplier=explode('//',$this->input->post('cap_mb_supplier'));
              }else{
                $cap_mb_supplier[1]='';
              }

              if(!empty($this->input->post('shoulder'))){
                $shoulder=explode('//',$this->input->post('shoulder'));
              }else{
                $shoulder[0]='';
              }

              if(!empty($this->input->post('shoulder_orifice'))){
                $shoulder_orifice=explode('//',$this->input->post('shoulder_orifice'));
              }else{
                $shoulder_orifice[0]='';
              }

              /*
              if(!empty($this->input->post('cap_type'))){
                $cap_type=explode('//',$this->input->post('cap_type'));
              }else{
                $cap_type[0]='';
              }

              if(!empty($this->input->post('cap_finish'))){
                $cap_finish=explode('//',$this->input->post('cap_finish'));
              }else{
                $cap_finish[0]='';
              }

              if(!empty($this->input->post('cap_dia'))){
                $cap_dia=explode('//',$this->input->post('cap_dia'));
              }else{
                $cap_dia[0]='';
              }

              if(!empty($this->input->post('cap_orifice'))){
                $cap_orifice=explode('//',$this->input->post('cap_orifice'));
              }else{
                $cap_orifice[0]='';
              }
                */


              $data['cap_diameter_master']=$this->common_model->select_one_active_record('cap_diameter_master',$this->session->userdata['logged_in']['company_id'],'cap_dia',$CAP_DIA);
            if($data['cap_diameter_master']==FALSE){
              $cap_dia_id="";
            }else{
             foreach($data['cap_diameter_master'] as $cap_diameter_master_row){
              $cap_dia_id=$cap_diameter_master_row->cap_dia_id;
             }
           }

            $data['cap_orifice_master']=$this->common_model->select_one_active_record('cap_orifice_master',$this->session->userdata['logged_in']['company_id'],'cap_orifice',$CAP_ORIFICE);
            if($data['cap_orifice_master']==FALSE){
              $cap_orifice_id="";
            }else{
              foreach($data['cap_orifice_master'] as $cap_orifice_master_row){
              $cap_orifice_id=$cap_orifice_master_row->cap_orifice_id;
               }
             }

             $data['cap_types_master']=$this->common_model->select_one_active_record('cap_types_master',$this->session->userdata['logged_in']['company_id'],'cap_type',$CAP_STYLE);
              if($data['cap_types_master']==FALSE){
                $cap_type_id="";
                }else{
                foreach($data['cap_types_master'] as $cap_types_master_row){
                  $cap_type_id=$cap_types_master_row->cap_type_id;
                 }
              }

             $data['cap_finish_master']=$this->common_model->select_one_active_record('cap_finish_master',$this->session->userdata['logged_in']['company_id'],'cap_finish',$CAP_MOLD_FINISH);
             if($data['cap_finish_master']==FALSE){
              $cap_finish_id="";
              }else{
              foreach($data['cap_finish_master'] as $cap_finish_master_row){
                $cap_finish_id=$cap_finish_master_row->cap_finish_id;
              }
              }

             
             $combination_data=array('sleeve_id'=>$sleeve_dia[1],
              'shld_type_id'=>$shoulder[1],
              'shld_orifice_id'=>$shoulder_orifice[1],
              'cap_dia_id'=>$cap_dia_id,
              'cap_orifice_id'=>$cap_orifice_id,
              'cap_type_id'=>$cap_type_id,
              'cap_finish_id'=>$cap_finish_id);

             $this->load->model('shoulder_orifice_dependancy_model');
             if($this->shoulder_orifice_dependancy_model->select_one_active_combination_record('shoulder_orifice_dependancy',$this->session->userdata['logged_in']['company_id'],$combination_data)>0){

              $data['spec_version']=$this->specification_model->select_specification_verion_no('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$article_no_arr[1]);
              foreach ($data['spec_version'] as $spec_version_row) {

                if($spec_version_row->spec_version_no==NULL){
                  $max_pkey=0;
                  $result=$this->common_model->select_max_pkey('specification_sheet','spec_id',$this->session->userdata['logged_in']['company_id']); 
                  foreach($result as $row){
                    $max_pkey=$row->spec_id;
                    $max_pkey=substr($max_pkey,4);
                    $max_pkey=$max_pkey+1;
                    $spec_no=str_pad($max_pkey,4,0,STR_PAD_LEFT);
                    $spec_no="SPEC".$spec_no;
                  }
                  $spec_version_no=1;
                }else{
                  $spec_version_no=$spec_version_row->spec_version_no;
                  $spec_no=$spec_version_row->spec_id;
                }
              }

              $artwork_no="";
              $artwork_version_no=0;
              if(!empty($this->input->post('artwork_final_version_no'))){
                $data['artwork_final_version_no']=$this->artwork_model->select_artwork_final_version('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'article_no',$article_no_arr[1],'final_approval_flag','1','archive<>','1','ad_date','desc','ad_id','desc','version_no','desc');
                if($data['artwork_final_version_no']==FALSE){
                  $artwork_no="";
                  $artwork_version_no=0;
                }else{
                  foreach ($data['artwork_final_version_no'] as $artwork_final_version_no_row){
                     $artwork_no=$artwork_final_version_no_row->ad_id;
                     $artwork_version_no=$artwork_final_version_no_row->version_no;
                  }
                }
              }
              
               

              $data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$customer_arr[1]);
              foreach ($data['customer'] as $customer_row) {
                $property=$customer_row->property_id;
              }

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                    'spec_id'=>$spec_no,
                    'spec_created_date'=>date('Y-m-d'),
                    'spec_version_no'=>$spec_version_no,
                    'property_id'=>$property,
                    'adr_company_id'=>$customer_arr[1],
                    'article_no'=>$article_no_arr[1],
                    'pending_flag'=>'0',
                    'final_approval_flag'=>'0',
                    'user_id'=>$this->session->userdata['logged_in']['user_id'],
                    'ad_id'=>$artwork_no,
                    'version_no'=>$artwork_version_no,
                    'dyn_qty_present'=>'SLEEVE|3^^^SHOULDER|1^^^CAP|1',
                    );

              $result=$this->common_model->save('specification_sheet',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'164',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DIA',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$sleeve_dia[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_1',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'165',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LENGTH',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('sleeve_length')." MM",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_2',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'166',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DRAWING',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_3',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'167',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'GUAGE',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('gauge_one')." MIC",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_4',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'168',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'material'=>'1',
                'item_group_material'=>'12',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>$sl_mb_supplier_one[1],
                'mat_info'=>$this->input->post('sl_mb_per_one')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_masterbatch_one'),
                'srd_id'=>'1_5_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
            

              

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'7',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_ldpe_per_one')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_ldpe_one'),
                'srd_id'=>'1_6_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

            

              
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'8',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_lldpe_per_one')."%",
                'mat_article_no'=>$this->input->post('sl_lldpe_one'),
                'property_id'=>'',
                'srd_id'=>'1_6_1',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
            

            

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_hdpe_per_one')."%",
                'mat_article_no'=>$this->input->post('sl_hdpe_one'),
                'property_id'=>'',
                'srd_id'=>'1_6_2',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

            
              


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'185',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'PRINT TYPE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$this->input->post('print_type'),
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_7',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              //Layer 2

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'164',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DIA',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$sleeve_dia[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_1',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'165',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LENGTH',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('sleeve_length')." MM",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_2',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'166',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DRAWING',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_3',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'167',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'GUAGE',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('gauge_two')." MIC",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_4',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'168',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'material'=>'1',
                'item_group_material'=>'12',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_5_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);
            


            

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_hdpe_per_two')."%",
                'mat_article_no'=>$this->input->post('sl_hdpe_two'),
                'property_id'=>'',
                'srd_id'=>'2_6_2',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);

            
              


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'185',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'PRINT TYPE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$this->input->post('print_type'),
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_7',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);

              //Layer 3

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'164',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DIA',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$sleeve_dia[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_1',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'165',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LENGTH',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('sleeve_length')." MM",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_2',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'166',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DRAWING',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_3',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'167',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'GUAGE',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('gauge_three')." MIC",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_4',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);

              
                $sl_mb_per_three=$this->input->post('sl_mb_per_three')."%";
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'168',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'material'=>'1',
                'item_group_material'=>'12',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>$sl_mb_supplier_three[1],
                'mat_info'=>$sl_mb_per_three,
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_masterbatch_three'),
                'srd_id'=>'3_5_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);
            

              

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'7',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_ldpe_per_three')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_ldpe_three'),
                'srd_id'=>'3_6_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);

            

              
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'8',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_lldpe_per_three')."%",
                'mat_article_no'=>$this->input->post('sl_lldpe_three'),
                'property_id'=>'',
                'srd_id'=>'3_6_1',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);
            

            

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_hdpe_per_three')."%",
                'mat_article_no'=>$this->input->post('sl_hdpe_three'),
                'property_id'=>'',
                'srd_id'=>'3_6_2',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);

            
              


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'185',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'PRINT TYPE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$this->input->post('print_type'),
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_7',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'170',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'DRAWING',
                'item_group_material'=>'',
                'material'=>'0',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'4_1',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'171',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'STYLE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$shoulder[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'4_2',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'172',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'NECK TYPE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$shoulder[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'4_3',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'173',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'ORIFICE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$shoulder_orifice[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'4_4',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'174',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'PEEL OFF TE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'4_5',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'175',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'material'=>'1',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'item_group_material'=>'12',
                'supplier_no'=>$sh_mb_supplier[1],
                'mat_info'=>$this->input->post('sh_mb_per')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sh_masterbatch'),
                'srd_id'=>'4_6_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              
                $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'176',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'parameter_value'=>'',
                'material'=>'1',
                'item_group_material'=>'6',
                'supplier_no'=>'',
                'relating_master_value'=>'',
                'mat_info'=>$this->input->post('sh_hdpe_one_per')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sh_hdpe_one'),
                'srd_id'=>'4_7_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
              
              

              
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'176',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sh_hdpe_two_per')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sh_hdpe_two'),
                'srd_id'=>'4_7_1',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
            

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'186',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'material'=>'1',
                'item_group_material'=>'106',
                'parameter_name'=>'SHOULDER FOIL TAG',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('shoulder_foil_tag'),
                'srd_id'=>'4_8',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'177',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'CSPEC',
                'item_group_material'=>'',
                'parameter_value'=>$cap_article_no_arr[2]."//".$cap_article_no_arr[3],
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'5_1',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'178',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'STYLE',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$CAP_STYLE,
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'5_2',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'179',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'MOLD FINISH',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$CAP_MOLD_FINISH,
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'5_3',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'180',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'DIAMETER',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$CAP_DIA,
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'5_4',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'181',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'SHRINK SLEEVE',
                'parameter_value'=>$CAP_SHRINK_SLEEVE_NAME,
                'item_group_material'=>'213',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>$CAP_SHRINK_SLEEVE,
                'srd_id'=>'5_5',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'182',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'ORIFICE',
                'parameter_value'=>'',
                'item_group_material'=>'',
                'relating_master_value'=>$CAP_ORIFICE,
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'5_6',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'183',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'material'=>'1',
                'item_group_material'=>'12',
                'property_id'=>'',
                'supplier_no'=>$CAP_MB_SUPPLIER,
                'mat_info'=>$CAP_MB_PERC,
                'mat_article_no'=>$CAP_MASTER_BATCH,
                'srd_id'=>'5_7_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'184',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'material'=>'1',
                'supplier_no'=>'',
                'property_id'=>'',
                'item_group_material'=>'9',
                'mat_info'=>$CAP_PP_PERC,
                'mat_article_no'=>$CAP_PP,
                'srd_id'=>'5_8_1',
                'item_group_material_flag'=>'2',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'187',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'CAP FOIL COLOR',
                'item_group_material'=>'71',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>$CAP_FOIL_COLOR,
                'material'=>'0',
                'supplier_no'=>'',
                'property_id'=>'',
                'parameter_value'=>$this->input->post('cap_foil_color'),
                'srd_id'=>'5_9',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'188',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'CAP FOIL WIDTH',
                'item_group_material'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'material'=>'0',
                'parameter_value'=>$CAP_FOIL_WIDTH,
                'srd_id'=>'5_10',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

            $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
              'spec_id'=>$spec_no,
              'disp_id'=>'189',
              'item_group_id'=>'5',
              'item_group_flag'=>'1',
              'parameter_name'=>'C.FOIL DIST FROM BOT',
              'item_group_material'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
              'material'=>'0',
              'parameter_value'=>$CAP_FOIL_DIST_FROM_BOT,
              'srd_id'=>'5_11',
              'item_group_material_flag'=>'0',
              'dyn_qty_no'=>'1',
              'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
              'spec_version_no'=>$spec_version_no,
              'layer_no'=>'1');
            $result=$this->common_model->save('specification_sheet_details',$data);


            $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
              'spec_id'=>$spec_no,
              'disp_id'=>'190',
              'item_group_id'=>'6',
              'item_group_flag'=>'1',
              'parameter_name'=>'LABEL',
              'item_group_material'=>'5',
              'relating_master_value'=>'',
              'supplier_no'=>'',
              'mat_info'=>'',
              'property_id'=>'',
              'mat_article_no'=>$label_article[1],
              'material'=>'1',
              'parameter_value'=>'',
              'srd_id'=>'5_12',
              'item_group_material_flag'=>'1',
              'dyn_qty_no'=>'1',
              'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
              'spec_version_no'=>$spec_version_no,
              'layer_no'=>'1');
            $result=$this->common_model->save('specification_sheet_details',$data);


            $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
              'spec_id'=>$spec_no,
              'lang_comments'=>$this->input->post('comment'),
              'language_id'=>$this->session->userdata['logged_in']['language_id'],
              'spec_version_no'=>$spec_version_no);
            $result=$this->common_model->save('specification_sheet_lang',$data);

              
              $data['note']='Create Transaction Completed';
              header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

              }else{
              $data['error']='Wrong combination';
             }

                $data['page_name']='Sales';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
              
                  $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

                  $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
                  $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
                  $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
                  $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                  $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);

                  $dataa=array('article_main_group.main_group_id'=>'5');
                  $data['label']=$this->article_model->active_record_search('article',$dataa,$this->session->userdata['logged_in']['company_id']);
                  $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                  $this->load->view(ucwords($this->router->fetch_class()).'/create-three-form',$data);
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


  function save_three_layer_with_cap_copy(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $this->form_validation->set_rules('customer','Customer' ,'required|trim|xss_clean|callback_customer_check');
            $this->form_validation->set_rules('article_no','Article No' ,'required|trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('spec_version_no','Spec Version No' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('artwork_final_version_no','Artwork Version No' ,'trim|xss_clean');

            if($this->input->post('sleeve_dia') || $this->input->post('sleeve_length') || $this->input->post('gauge_one') || $this->input->post('print_type') || $this->input->post('sl_masterbatch_one') || $this->input->post('sl_mb_per_one')){

              $this->form_validation->set_rules('sleeve_dia','Sleeve Dia' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sleeve_length','Sleeve Length' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');
              $this->form_validation->set_rules('gauge_one','Gauge Layer One' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');
              $this->form_validation->set_rules('print_type','Print Type' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sl_masterbatch_one','Sleeve Masterbatch Layer One' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sl_mb_supplier_one','Sleeve Masterbatch Supplier Layer One','trim|xss_clean|callback_supplier_check');
              $this->form_validation->set_rules('sl_mb_per_one','Sleeve Masterbatch % Layer One' ,'required|trim|xss_clean|numeric|max_length[3]');

              $this->form_validation->set_rules('sl_ldpe_per_one','Sleeve Ldpe % Layer One' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_one_check');
              $this->form_validation->set_rules('sl_lldpe_per_one','Sleeve Lldpe % Layer One' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_one_check');
              $this->form_validation->set_rules('sl_hdpe_per_one','Sleeve Hdpe % Layer One' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_one_check');

              if(!empty($this->input->post('sl_ldpe_per_one'))){
                $this->form_validation->set_rules('sl_ldpe_one','Sleeve Ldpe Layer One' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_lldpe_per'))){
                $this->form_validation->set_rules('sl_lldpe_one','Sleeve Lldpe Layer One' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_hdpe_per'))){
                $this->form_validation->set_rules('sl_hdpe_one','Sleeve Hdpe Layer One' ,'trim|xss_clean|required');
              }


              $this->form_validation->set_rules('gauge_two','Gauge Layer Two' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');
              $this->form_validation->set_rules('sl_hdpe_two','Sleeve Hdpe  Layer two' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sl_hdpe_per_two','Sleeve Hdpe % Layer two' ,'required|trim|xss_clean|numeric|max_length[3]');

              $this->form_validation->set_rules('gauge_three','Gauge Layer Three' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');
              $this->form_validation->set_rules('sl_masterbatch_three','Sleeve Masterbatch Layer Three' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sl_mb_supplier_three','Sleeve Masterbatch Supplier Layer Three','trim|xss_clean|callback_supplier_check');
              $this->form_validation->set_rules('sl_mb_per_three','Sleeve Masterbatch % Layer Three' ,'required|trim|xss_clean|numeric|max_length[3]');

              $this->form_validation->set_rules('sl_ldpe_per_three','Sleeve Ldpe % Layer Three' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_three_check');
              $this->form_validation->set_rules('sl_lldpe_per_three','Sleeve Lldpe % Layer Three' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_three_check');
              $this->form_validation->set_rules('sl_hdpe_per_three','Sleeve Hdpe % Layer Three' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_three_check');

              if(!empty($this->input->post('sl_ldpe_per_three'))){
                $this->form_validation->set_rules('sl_ldpe_three','Sleeve Ldpe Layer Three' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_lldpe_per'))){
                $this->form_validation->set_rules('sl_lldpe_three','Sleeve Lldpe Layer Three' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_hdpe_per'))){
                $this->form_validation->set_rules('sl_hdpe_three','Sleeve Hdpe Layer Three' ,'trim|xss_clean|required');
              }
              

            }
            
            if($this->input->post('shoulder') || $this->input->post('shoulder_orifice') || $this->input->post('sh_masterbatch') || $this->input->post('sh_mb_per')){
            
              $this->form_validation->set_rules('shoulder','Shoulder' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('shoulder_orifice','Shoulder Orifice' ,'trim|xss_clean');
              $this->form_validation->set_rules('sh_masterbatch','Shoulder Masterbatch' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sh_mb_supplier','Shoulder Masterbatch Supplier' ,'trim|xss_clean|callback_supplier_check');
              $this->form_validation->set_rules('sh_mb_per','Shoulder Masterbatch %' ,'required|trim|xss_clean|numeric|max_length[3]');
              $this->form_validation->set_rules('sh_hdpe_one_per','Shoulder HDPE %' ,'trim|xss_clean|numeric|max_length[3]|callback_shoulder_per_check');
              $this->form_validation->set_rules('sh_hdpe_two_per','Shoulder HDPE %' ,'trim|xss_clean|numeric|max_length[3]|callback_shoulder_per_check');

               if(!empty($this->input->post('sh_hdpe_one_per'))){
                $this->form_validation->set_rules('sh_hdpe_one','Shoulder Hdpe' ,'trim|xss_clean|required');
                }if(!empty($this->input->post('sh_hdpe_two_per'))){
                $this->form_validation->set_rules('sh_hdpe_two','Shoulder Hdpe' ,'trim|xss_clean|required');
                }

            }


            if(!empty($this->input->post('cap_spec_no'))){
              $this->form_validation->set_rules('cap_spec_no','Cap Spec No' ,'trim|xss_clean|required|exact_length[9]');
              $this->form_validation->set_rules('cap_spec_version_no','Cap Spec Version' ,'trim|xss_clean|required');
            }
            $this->form_validation->set_rules('cap_article_no','Cap Article No' ,'trim|xss_clean|callback_article_check');


            if($this->form_validation->run()==FALSE){
              
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

            $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
            $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
            $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);

            $dataa=array('article_main_group.main_group_id'=>'5');
            $data['label']=$this->article_model->active_record_search('article',$dataa,$this->session->userdata['logged_in']['company_id']);
            $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);

            $data['specification']=$this->specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->input->post('spec_id'),'specification_sheet.spec_version_no',$this->input->post('copy_version_no'));


              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-three-form',$data);
              $this->load->view('Home/footer');
            }else{

              if(!empty($this->input->post('customer'))){
                $customer_arr=explode('//',$this->input->post('customer'));
              }

              if(!empty($this->input->post('article_no'))){
                $article_no_arr=explode('//',$this->input->post('article_no'));
              }

              if(!empty($this->input->post('cap_article_no'))){
                $cap_article_no_arr=explode('//',$this->input->post('cap_article_no'));
              }

              if(!empty($this->input->post('cap_spec_no'))){
                $cap_article_no_arr[2]=$this->input->post('cap_spec_no');
                $cap_article_no_arr[3]=$this->input->post('cap_spec_version_no');
              }


              $data=array('spec_id'=>$cap_article_no_arr[2],
                  'spec_version_no'=>$cap_article_no_arr[3]);
                $data['specs_details']=$this->sales_order_book_model->select_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data);
                if($data['specs_details']==FALSE){
                  $CAP_DIA="";
                  $CAP_STYLE="";
                  $CAP_MOLD_FINISH="";
                  $CAP_ORIFICE="";
                  $CAP_MASTER_BATCH="";
                  $CAP_MB_PERC="";
                  $CAP_MB_SUPPLIER="";
                  $CAP_PP="";
                  $CAP_PP_PERC="";
                  $CAP_FOIL_COLOR="";
                  $CAP_FOIL_WIDTH="";
                  $CAP_FOIL_DIST_FROM_BOT="";
                  $CAP_SHRINK_SLEEVE="";
                  $CAP_SHRINK_SLEEVE_NAME="";
                }else{
                  foreach($data['specs_details'] as $specs_details_row){
                  $CAP_DIA=$specs_details_row->CAP_DIA;
                  $CAP_STYLE=$specs_details_row->CAP_STYLE;
                  $CAP_MOLD_FINISH=$specs_details_row->CAP_MOLD_FINISH;
                  $CAP_ORIFICE=$specs_details_row->CAP_ORIFICE;
                  $CAP_MASTER_BATCH=$specs_details_row->CAP_MASTER_BATCH;
                  $CAP_MB_PERC=$specs_details_row->CAP_MB_PERC;
                  $CAP_MB_SUPPLIER=$specs_details_row->CAP_MB_SUPPLIER;
                  $CAP_PP=$specs_details_row->CAP_PP;
                  $CAP_PP_PERC=$specs_details_row->CAP_PP_PERC;
                  $CAP_FOIL_COLOR=$specs_details_row->CAP_FOIL_COLOR;
                  $CAP_FOIL_WIDTH=$specs_details_row->CAP_FOIL_WIDTH;
                  $CAP_FOIL_DIST_FROM_BOT=$specs_details_row->CAP_FOIL_DIST_FROM_BOT;
                  $CAP_SHRINK_SLEEVE=$specs_details_row->CAP_SHRINK_SLEEVE;
                  $CAP_SHRINK_SLEEVE_NAME=$specs_details_row->CAP_SHRINK_SLEEVE_NAME;
                  }
                }
                

              if(!empty($this->input->post('label_article_no'))){
                $label_article=explode('//',$this->input->post('label_article_no'));
              }else{
                $label_article[1]='';
              }

              if(!empty($this->input->post('sleeve_dia'))){
                $sleeve_dia=explode('//',$this->input->post('sleeve_dia'));
              }else{
                $sleeve_dia[0]='';
              }

              if(!empty($this->input->post('sl_mb_supplier_one'))){
                $sl_mb_supplier_one=explode('//',$this->input->post('sl_mb_supplier_one'));
              }else{
                $sl_mb_supplier_one[1]='';
              }

              if(!empty($this->input->post('sl_mb_supplier_three'))){
                $sl_mb_supplier_three=explode('//',$this->input->post('sl_mb_supplier_three'));
              }else{
                $sl_mb_supplier_three[1]='';
              }

              if(!empty($this->input->post('sh_mb_supplier'))){
                $sh_mb_supplier=explode('//',$this->input->post('sh_mb_supplier'));
              }else{
                $sh_mb_supplier[1]='';
              }

              if(!empty($this->input->post('cap_mb_supplier'))){
                $cap_mb_supplier=explode('//',$this->input->post('cap_mb_supplier'));
              }else{
                $cap_mb_supplier[1]='';
              }

              if(!empty($this->input->post('shoulder'))){
                $shoulder=explode('//',$this->input->post('shoulder'));
              }else{
                $shoulder[0]='';
              }

              if(!empty($this->input->post('shoulder_orifice'))){
                $shoulder_orifice=explode('//',$this->input->post('shoulder_orifice'));
              }else{
                $shoulder_orifice[0]='';
              }

              /*
              if(!empty($this->input->post('cap_type'))){
                $cap_type=explode('//',$this->input->post('cap_type'));
              }else{
                $cap_type[0]='';
              }

              if(!empty($this->input->post('cap_finish'))){
                $cap_finish=explode('//',$this->input->post('cap_finish'));
              }else{
                $cap_finish[0]='';
              }

              if(!empty($this->input->post('cap_dia'))){
                $cap_dia=explode('//',$this->input->post('cap_dia'));
              }else{
                $cap_dia[0]='';
              }

              if(!empty($this->input->post('cap_orifice'))){
                $cap_orifice=explode('//',$this->input->post('cap_orifice'));
              }else{
                $cap_orifice[0]='';
              }
                */

              $data['cap_diameter_master']=$this->common_model->select_one_active_record('cap_diameter_master',$this->session->userdata['logged_in']['company_id'],'cap_dia',$CAP_DIA);
            //echo $this->db->last_query();
            if($data['cap_diameter_master']==FALSE){
              $cap_dia_id="";
            }else{
             foreach($data['cap_diameter_master'] as $cap_diameter_master_row){
              $cap_dia_id=$cap_diameter_master_row->cap_dia_id;
             }
           }

            $data['cap_orifice_master']=$this->common_model->select_one_active_record('cap_orifice_master',$this->session->userdata['logged_in']['company_id'],'cap_orifice',$CAP_ORIFICE);
            if($data['cap_orifice_master']==FALSE){
              $cap_orifice_id="";
            }else{
              foreach($data['cap_orifice_master'] as $cap_orifice_master_row){
              $cap_orifice_id=$cap_orifice_master_row->cap_orifice_id;
               }
             }

             $data['cap_types_master']=$this->common_model->select_one_active_record('cap_types_master',$this->session->userdata['logged_in']['company_id'],'cap_type',$CAP_STYLE);
              if($data['cap_types_master']==FALSE){
                $cap_type_id="";
                }else{
                foreach($data['cap_types_master'] as $cap_types_master_row){
                  $cap_type_id=$cap_types_master_row->cap_type_id;
                 }
              }

             $data['cap_finish_master']=$this->common_model->select_one_active_record('cap_finish_master',$this->session->userdata['logged_in']['company_id'],'cap_finish',$CAP_MOLD_FINISH);
             if($data['cap_finish_master']==FALSE){
              $cap_finish_id="";
              }else{
              foreach($data['cap_finish_master'] as $cap_finish_master_row){
                $cap_finish_id=$cap_finish_master_row->cap_finish_id;
              }
              }



             
             $combination_data=array('sleeve_id'=>$sleeve_dia[1],
              'shld_type_id'=>$shoulder[1],
              'shld_orifice_id'=>$shoulder_orifice[1],
              'cap_dia_id'=>$cap_dia_id,
              'cap_orifice_id'=>$cap_orifice_id,
              'cap_type_id'=>$cap_type_id,
              'cap_finish_id'=>$cap_finish_id);

             $this->load->model('shoulder_orifice_dependancy_model');
             $this->shoulder_orifice_dependancy_model->select_one_active_combination_record('shoulder_orifice_dependancy',$this->session->userdata['logged_in']['company_id'],$combination_data);
             //echo $this->db->last_query();
             if($this->shoulder_orifice_dependancy_model->select_one_active_combination_record('shoulder_orifice_dependancy',$this->session->userdata['logged_in']['company_id'],$combination_data)>0){

              $data['spec_version']=$this->specification_model->select_specification_verion_no('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$article_no_arr[1]);
              foreach ($data['spec_version'] as $spec_version_row) {

                if($spec_version_row->spec_version_no==NULL){
                  $max_pkey=0;
                  $result=$this->common_model->select_max_pkey('specification_sheet','spec_id',$this->session->userdata['logged_in']['company_id']); 
                  foreach($result as $row){
                    $max_pkey=$row->spec_id;
                    $max_pkey=substr($max_pkey,4);
                    $max_pkey=$max_pkey+1;
                    $spec_no=str_pad($max_pkey,4,0,STR_PAD_LEFT);
                    $spec_no="SPEC".$spec_no;
                  }
                  $spec_version_no=1;
                }else{
                  $spec_version_no=$spec_version_row->spec_version_no;
                  $spec_no=$spec_version_row->spec_id;
                }
              }

              $artwork_no="";
              $artwork_version_no=0;
              if(!empty($this->input->post('artwork_final_version_no'))){
                $data['artwork_final_version_no']=$this->artwork_model->select_artwork_final_version('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'article_no',$article_no_arr[1],'final_approval_flag','1','archive<>','1','ad_date','desc','ad_id','desc','version_no','desc');
                if($data['artwork_final_version_no']==FALSE){
                  $artwork_no="";
                  $artwork_version_no=0;
                }else{
                  foreach ($data['artwork_final_version_no'] as $artwork_final_version_no_row){
                     $artwork_no=$artwork_final_version_no_row->ad_id;
                     $artwork_version_no=$artwork_final_version_no_row->version_no;
                  }
                }
              }
              
               

              $data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$customer_arr[1]);
              foreach ($data['customer'] as $customer_row) {
                $property=$customer_row->property_id;
              }

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                    'spec_id'=>$spec_no,
                    'spec_created_date'=>date('Y-m-d'),
                    'spec_version_no'=>$spec_version_no,
                    'property_id'=>$property,
                    'adr_company_id'=>$customer_arr[1],
                    'article_no'=>$article_no_arr[1],
                    'pending_flag'=>'0',
                    'final_approval_flag'=>'0',
                    'user_id'=>$this->session->userdata['logged_in']['user_id'],
                    'ad_id'=>$artwork_no,
                    'version_no'=>$artwork_version_no,
                    'dyn_qty_present'=>'SLEEVE|3^^^SHOULDER|1^^^CAP|1',
                    );

              $result=$this->common_model->save('specification_sheet',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'164',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DIA',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$sleeve_dia[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_1',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'165',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LENGTH',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('sleeve_length')." MM",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_2',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'166',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DRAWING',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_3',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'167',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'GUAGE',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('gauge_one')." MIC",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_4',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'168',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'material'=>'1',
                'item_group_material'=>'12',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>$sl_mb_supplier_one[1],
                'mat_info'=>$this->input->post('sl_mb_per_one')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_masterbatch_one'),
                'srd_id'=>'1_5_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
            

              

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'7',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_ldpe_per_one')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_ldpe_one'),
                'srd_id'=>'1_6_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

            

              
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'8',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_lldpe_per_one')."%",
                'mat_article_no'=>$this->input->post('sl_lldpe_one'),
                'property_id'=>'',
                'srd_id'=>'1_6_1',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
            

            

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_hdpe_per_one')."%",
                'mat_article_no'=>$this->input->post('sl_hdpe_one'),
                'property_id'=>'',
                'srd_id'=>'1_6_2',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

            
              


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'185',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'PRINT TYPE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$this->input->post('print_type'),
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_7',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              //Layer 2

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'164',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DIA',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$sleeve_dia[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_1',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'165',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LENGTH',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('sleeve_length')." MM",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_2',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'166',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DRAWING',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_3',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'167',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'GUAGE',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('gauge_two')." MIC",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_4',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'168',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'material'=>'1',
                'item_group_material'=>'12',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_5_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);
            


            

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_hdpe_per_two')."%",
                'mat_article_no'=>$this->input->post('sl_hdpe_two'),
                'property_id'=>'',
                'srd_id'=>'2_6_2',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);

            
              


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'185',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'PRINT TYPE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$this->input->post('print_type'),
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_7',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);

              //Layer 3

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'164',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DIA',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$sleeve_dia[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_1',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'165',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LENGTH',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('sleeve_length')." MM",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_2',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'166',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DRAWING',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_3',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'167',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'GUAGE',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('gauge_three')." MIC",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_4',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);

              
                $sl_mb_per_three=$this->input->post('sl_mb_per_three')."%";
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'168',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'material'=>'1',
                'item_group_material'=>'12',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>$sl_mb_supplier_three[1],
                'mat_info'=>$sl_mb_per_three,
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_masterbatch_three'),
                'srd_id'=>'3_5_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);
            

              

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'7',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_ldpe_per_three')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_ldpe_three'),
                'srd_id'=>'3_6_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);

            

              
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'8',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_lldpe_per_three')."%",
                'mat_article_no'=>$this->input->post('sl_lldpe_three'),
                'property_id'=>'',
                'srd_id'=>'3_6_1',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);
            

            

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_hdpe_per_three')."%",
                'mat_article_no'=>$this->input->post('sl_hdpe_three'),
                'property_id'=>'',
                'srd_id'=>'3_6_2',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);

            
              


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'185',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'PRINT TYPE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$this->input->post('print_type'),
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_7',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'3',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'170',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'DRAWING',
                'item_group_material'=>'',
                'material'=>'0',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'4_1',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'171',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'STYLE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$shoulder[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'4_2',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'172',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'NECK TYPE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$shoulder[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'4_3',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'173',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'ORIFICE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$shoulder_orifice[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'4_4',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'174',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'PEEL OFF TE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'4_5',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'175',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'material'=>'1',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'item_group_material'=>'12',
                'supplier_no'=>$sh_mb_supplier[1],
                'mat_info'=>$this->input->post('sh_mb_per')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sh_masterbatch'),
                'srd_id'=>'4_6_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              
                $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'176',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'parameter_value'=>'',
                'material'=>'1',
                'item_group_material'=>'6',
                'supplier_no'=>'',
                'relating_master_value'=>'',
                'mat_info'=>$this->input->post('sh_hdpe_one_per')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sh_hdpe_one'),
                'srd_id'=>'4_7_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
              
              

              
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'176',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sh_hdpe_two_per')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sh_hdpe_two'),
                'srd_id'=>'4_7_1',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
            

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'186',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'material'=>'1',
                'item_group_material'=>'106',
                'parameter_name'=>'SHOULDER FOIL TAG',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('shoulder_foil_tag'),
                'srd_id'=>'4_8',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'177',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'CSPEC',
                'item_group_material'=>'',
                'parameter_value'=>$cap_article_no_arr[2]."//".$cap_article_no_arr[3],
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'5_1',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'178',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'STYLE',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$CAP_STYLE,
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'5_2',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'179',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'MOLD FINISH',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$CAP_MOLD_FINISH,
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'5_3',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'180',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'DIAMETER',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$CAP_DIA,
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'5_4',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'181',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'SHRINK SLEEVE',
                'parameter_value'=>$CAP_SHRINK_SLEEVE_NAME,
                'item_group_material'=>'213',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>$CAP_SHRINK_SLEEVE,
                'srd_id'=>'5_5',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'182',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'ORIFICE',
                'parameter_value'=>'',
                'item_group_material'=>'',
                'relating_master_value'=>$CAP_ORIFICE,
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'5_6',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'183',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'material'=>'1',
                'item_group_material'=>'12',
                'property_id'=>'',
                'supplier_no'=>$CAP_MB_SUPPLIER,
                'mat_info'=>$CAP_MB_PERC,
                'mat_article_no'=>$CAP_MASTER_BATCH,
                'srd_id'=>'5_7_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'184',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'material'=>'1',
                'supplier_no'=>'',
                'property_id'=>'',
                'item_group_material'=>'9',
                'mat_info'=>$CAP_PP_PERC,
                'mat_article_no'=>$CAP_PP,
                'srd_id'=>'5_8_1',
                'item_group_material_flag'=>'2',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'187',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'CAP FOIL COLOR',
                'item_group_material'=>'71',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>$CAP_FOIL_COLOR,
                'material'=>'0',
                'supplier_no'=>'',
                'property_id'=>'',
                'parameter_value'=>$this->input->post('cap_foil_color'),
                'srd_id'=>'5_9',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'188',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'CAP FOIL WIDTH',
                'item_group_material'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'material'=>'0',
                'parameter_value'=>$CAP_FOIL_WIDTH,
                'srd_id'=>'5_10',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

            $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
              'spec_id'=>$spec_no,
              'disp_id'=>'189',
              'item_group_id'=>'5',
              'item_group_flag'=>'1',
              'parameter_name'=>'C.FOIL DIST FROM BOT',
              'item_group_material'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
              'material'=>'0',
              'parameter_value'=>$CAP_FOIL_DIST_FROM_BOT,
              'srd_id'=>'5_11',
              'item_group_material_flag'=>'0',
              'dyn_qty_no'=>'1',
              'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
              'spec_version_no'=>$spec_version_no,
              'layer_no'=>'1');
            $result=$this->common_model->save('specification_sheet_details',$data);

            $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
              'spec_id'=>$spec_no,
              'disp_id'=>'190',
              'item_group_id'=>'6',
              'item_group_flag'=>'1',
              'parameter_name'=>'LABEL',
              'item_group_material'=>'5',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>$label_article[1],
              'material'=>'1',
              'parameter_value'=>'',
              'srd_id'=>'5_12',
              'item_group_material_flag'=>'1',
              'dyn_qty_no'=>'1',
              'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
              'spec_version_no'=>$spec_version_no,
              'layer_no'=>'1');
            $result=$this->common_model->save('specification_sheet_details',$data);


            $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
              'spec_id'=>$spec_no,
              'lang_comments'=>$this->input->post('comment'),
              'language_id'=>$this->session->userdata['logged_in']['language_id'],
              'spec_version_no'=>$spec_version_no);
            $result=$this->common_model->save('specification_sheet_lang',$data);

            $data['note']='Copy Transaction Completed';
              
            header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

            }else{
              $data['error']='Wrong combination';
             }

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
              
              
                  $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

                  $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
                  $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
                  $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
                  $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                  $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);


                  $dataa=array('article_main_group.main_group_id'=>'5');
                  $data['label']=$this->article_model->active_record_search('article',$dataa,$this->session->userdata['logged_in']['company_id']);
                  $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);
                  $data['specification']=$this->specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$spec_no,'specification_sheet.spec_version_no',$spec_version_no);
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                  $this->load->view(ucwords($this->router->fetch_class()).'/create-three-form',$data);
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


  function copy_five(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->copy==1){

              $data['specification']=$this->specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->uri->segment(3),'specification_sheet.spec_version_no',$this->uri->segment(4));
              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
              $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
              $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
              $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
              $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
              $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

              $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
              $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
              $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
              $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
              $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
              $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);
              $data['admer']=$this->article_model->spec_active_record_search('article','15',$this->session->userdata['logged_in']['company_id']);
              $data['evoh']=$this->article_model->spec_active_record_search('article','16',$this->session->userdata['logged_in']['company_id']);

              $dataa=array('article_main_group.main_group_id'=>'5');
              $data['label']=$this->article_model->active_record_search('article',$dataa,$this->session->userdata['logged_in']['company_id']);
              $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);


              $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/five-copy-form',$data);
              $this->load->view('Home/footer');
          }else{
              $data['note']='No Copy rights Thanks';
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


  function create_five_layer_with_cap(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

            $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
            $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
            $data['admer']=$this->article_model->spec_active_record_search('article','15',$this->session->userdata['logged_in']['company_id']);
            $data['evoh']=$this->article_model->spec_active_record_search('article','16',$this->session->userdata['logged_in']['company_id']);
            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
            $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);
            
            $dataa=array('article_main_group.main_group_id'=>'5');
            $data['label']=$this->article_model->active_record_search('article',$dataa,$this->session->userdata['logged_in']['company_id']);
            $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);


            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/create-five-form',$data);
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


  function save_five_layer_with_cap(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $this->form_validation->set_rules('customer','Customer' ,'required|trim|xss_clean|callback_customer_check');
            $this->form_validation->set_rules('article_no','Article No' ,'required|trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('spec_version_no','Spec Version No' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('artwork_final_version_no','Artwork Version No' ,'trim|xss_clean');

            if($this->input->post('sleeve_dia')){

              $this->form_validation->set_rules('sleeve_dia','Sleeve Dia' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sleeve_length','Sleeve Length' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');
              $this->form_validation->set_rules('gauge_one','Gauge Layer One' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');
              $this->form_validation->set_rules('print_type','Print Type' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sl_masterbatch_one','Sleeve Masterbatch Layer One' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sl_mb_supplier_one','Sleeve Masterbatch Supplier Layer One','trim|xss_clean|callback_supplier_check');
              $this->form_validation->set_rules('sl_mb_per_one','Sleeve Masterbatch % Layer One' ,'required|trim|xss_clean|numeric|max_length[3]');

              $this->form_validation->set_rules('sl_ldpe_per_one','Sleeve Ldpe % Layer One' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_one_check');
              $this->form_validation->set_rules('sl_lldpe_per_one','Sleeve Lldpe % Layer One' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_one_check');
              $this->form_validation->set_rules('sl_hdpe_per_one','Sleeve Hdpe % Layer One' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_one_check');

              if(!empty($this->input->post('sl_ldpe_per_one'))){
                $this->form_validation->set_rules('sl_ldpe_one','Sleeve Ldpe Layer One' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_lldpe_per'))){
                $this->form_validation->set_rules('sl_lldpe_one','Sleeve Lldpe Layer One' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_hdpe_per'))){
                $this->form_validation->set_rules('sl_hdpe_one','Sleeve Hdpe Layer One' ,'trim|xss_clean|required');
              }


              $this->form_validation->set_rules('gauge_two','Gauge Layer Two' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');

              $this->form_validation->set_rules('sl_admer_two','Sleeve Admer Layer two' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sl_admer_per_two','Sleeve Admer % Layer two' ,'required|trim|xss_clean|numeric|exact_length[3]');

              $this->form_validation->set_rules('gauge_three','Gauge Layer Three' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');

              $this->form_validation->set_rules('sl_evoh_three','Sleeve Evoh Layer Three' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sl_evoh_per_three','Sleeve Evoh % Layer Three' ,'required|trim|xss_clean|numeric|exact_length[3]');

              $this->form_validation->set_rules('gauge_four','Gauge Layer Four' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');

              $this->form_validation->set_rules('sl_admer_four','Sleeve Admer Layer Four' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sl_admer_per_four','Sleeve Admer % Layer Four' ,'required|trim|xss_clean|numeric|exact_length[3]');

              $this->form_validation->set_rules('gauge_five','Gauge Layer Five' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');
              $this->form_validation->set_rules('sl_masterbatch_five','Sleeve Masterbatch Layer Five' ,'trim|xss_clean');
              $this->form_validation->set_rules('sl_mb_supplier_five','Sleeve Masterbatch Supplier Layer Five','trim|xss_clean|callback_supplier_check');
              $this->form_validation->set_rules('sl_mb_per_five','Sleeve Masterbatch % Layer Five' ,'trim|xss_clean|numeric|max_length[3]');

              $this->form_validation->set_rules('sl_ldpe_per_five','Sleeve Ldpe % Layer Five' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_five_check');
              $this->form_validation->set_rules('sl_lldpe_per_five','Sleeve Lldpe % Layer Five' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_five_check');
              $this->form_validation->set_rules('sl_hdpe_per_five','Sleeve Hdpe % Layer Five' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_five_check');

              if(!empty($this->input->post('sl_ldpe_per_five'))){
                $this->form_validation->set_rules('sl_ldpe_five','Sleeve Ldpe Layer Five' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_lldpe_per_five'))){
                $this->form_validation->set_rules('sl_lldpe_five','Sleeve Lldpe Layer Five' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_hdpe_per_five'))){
                $this->form_validation->set_rules('sl_hdpe_five','Sleeve Hdpe Layer Five' ,'trim|xss_clean|required');
              }
              

            }
            
            if($this->input->post('shoulder')){
            
              $this->form_validation->set_rules('shoulder','Shoulder' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('shoulder_orifice','Shoulder Orifice' ,'trim|xss_clean');
              $this->form_validation->set_rules('sh_masterbatch','Shoulder Masterbatch' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sh_mb_supplier','Shoulder Masterbatch Supplier' ,'trim|xss_clean|callback_supplier_check');
              $this->form_validation->set_rules('sh_mb_per','Shoulder Masterbatch %' ,'required|trim|xss_clean|numeric|max_length[3]');
              $this->form_validation->set_rules('sh_hdpe_one_per','Shoulder HDPE %' ,'trim|xss_clean|numeric|max_length[3]|callback_shoulder_per_check');
              $this->form_validation->set_rules('sh_hdpe_two_per','Shoulder HDPE %' ,'trim|xss_clean|numeric|max_length[3]|callback_shoulder_per_check');

               if(!empty($this->input->post('sh_hdpe_one_per'))){
                $this->form_validation->set_rules('sh_hdpe_one','Shoulder Hdpe' ,'trim|xss_clean|required');
                }if(!empty($this->input->post('sh_hdpe_two_per'))){
                $this->form_validation->set_rules('sh_hdpe_two','Shoulder Hdpe' ,'trim|xss_clean|required');
                }

            }

            if(!empty($this->input->post('cap_spec_no'))){
              $this->form_validation->set_rules('cap_spec_no','Cap Spec No' ,'trim|xss_clean|required|exact_length[9]');
              $this->form_validation->set_rules('cap_spec_version_no','Cap Spec Version' ,'trim|xss_clean|required');
            }
            $this->form_validation->set_rules('label_article_no','Label Article No' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('cap_article_no','Cap Article No' ,'trim|xss_clean|callback_article_check');

            

            if($this->form_validation->run()==FALSE){
              
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

            $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
            $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
            $data['admer']=$this->article_model->spec_active_record_search('article','15',$this->session->userdata['logged_in']['company_id']);
            $data['evoh']=$this->article_model->spec_active_record_search('article','16',$this->session->userdata['logged_in']['company_id']);
            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
            $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);
            $dataa=array('article_main_group.main_group_id'=>'5');
            $data['label']=$this->article_model->active_record_search('article',$dataa,$this->session->userdata['logged_in']['company_id']);
            $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);


              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-five-form',$data);
              $this->load->view('Home/footer');
            }else{

              if(!empty($this->input->post('customer'))){
                $customer_arr=explode('//',$this->input->post('customer'));
              }

              if(!empty($this->input->post('article_no'))){
                $article_no_arr=explode('//',$this->input->post('article_no'));
              }

              if(!empty($this->input->post('cap_article_no'))){
                $cap_article_no_arr=explode('//',$this->input->post('cap_article_no'));
              }

              if(!empty($this->input->post('cap_spec_no'))){
                $cap_article_no_arr[2]=$this->input->post('cap_spec_no');
                $cap_article_no_arr[3]=$this->input->post('cap_spec_version_no');
              }


              $data=array('spec_id'=>$cap_article_no_arr[2],
                  'spec_version_no'=>$cap_article_no_arr[3]);
                $data['specs_details']=$this->sales_order_book_model->select_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data);
                if($data['specs_details']==FALSE){
                  $CAP_DIA="";
                  $CAP_STYLE="";
                  $CAP_MOLD_FINISH="";
                  $CAP_ORIFICE="";
                  $CAP_MASTER_BATCH="";
                  $CAP_MB_PERC="";
                  $CAP_MB_SUPPLIER="";
                  $CAP_PP="";
                  $CAP_PP_PERC="";
                  $CAP_FOIL_COLOR="";
                  $CAP_FOIL_WIDTH="";
                  $CAP_FOIL_DIST_FROM_BOT="";
                  $CAP_SHRINK_SLEEVE="";
                  $CAP_SHRINK_SLEEVE_NAME="";
                }else{
                  foreach($data['specs_details'] as $specs_details_row){
                  $CAP_DIA=$specs_details_row->CAP_DIA;
                  $CAP_STYLE=$specs_details_row->CAP_STYLE;
                  $CAP_MOLD_FINISH=$specs_details_row->CAP_MOLD_FINISH;
                  $CAP_ORIFICE=$specs_details_row->CAP_ORIFICE;
                  $CAP_MASTER_BATCH=$specs_details_row->CAP_MASTER_BATCH;
                  $CAP_MB_PERC=$specs_details_row->CAP_MB_PERC;
                  $CAP_MB_SUPPLIER=$specs_details_row->CAP_MB_SUPPLIER;
                  $CAP_PP=$specs_details_row->CAP_PP;
                  $CAP_PP_PERC=$specs_details_row->CAP_PP_PERC;
                  $CAP_FOIL_COLOR=$specs_details_row->CAP_FOIL_COLOR;
                  $CAP_FOIL_WIDTH=$specs_details_row->CAP_FOIL_WIDTH;
                  $CAP_FOIL_DIST_FROM_BOT=$specs_details_row->CAP_FOIL_DIST_FROM_BOT;
                  $CAP_SHRINK_SLEEVE=$specs_details_row->CAP_SHRINK_SLEEVE;
                  $CAP_SHRINK_SLEEVE_NAME=$specs_details_row->CAP_SHRINK_SLEEVE_NAME;
                  }
                }
                
              if(!empty($this->input->post('label_article_no'))){
                $label_article=explode('//',$this->input->post('label_article_no'));
              }else{
                $label_article[1]='';
              }

              if(!empty($this->input->post('sleeve_dia'))){
                $sleeve_dia=explode('//',$this->input->post('sleeve_dia'));
              }else{
                $sleeve_dia[0]='';
              }

              if(!empty($this->input->post('sl_mb_supplier_one'))){
                $sl_mb_supplier_one=explode('//',$this->input->post('sl_mb_supplier_one'));
              }else{
                $sl_mb_supplier_one[1]='';
              }

              if(!empty($this->input->post('sl_mb_supplier_five'))){
                $sl_mb_supplier_five=explode('//',$this->input->post('sl_mb_supplier_five'));
              }else{
                $sl_mb_supplier_five[1]='';
              }

              if(!empty($this->input->post('sh_mb_supplier'))){
                $sh_mb_supplier=explode('//',$this->input->post('sh_mb_supplier'));
              }else{
                $sh_mb_supplier[1]='';
              }

              if(!empty($this->input->post('cap_mb_supplier'))){
                $cap_mb_supplier=explode('//',$this->input->post('cap_mb_supplier'));
              }else{
                $cap_mb_supplier[1]='';
              }

              if(!empty($this->input->post('shoulder'))){
                $shoulder=explode('//',$this->input->post('shoulder'));
              }else{
                $shoulder[0]='';
              }

              if(!empty($this->input->post('shoulder_orifice'))){
                $shoulder_orifice=explode('//',$this->input->post('shoulder_orifice'));
              }else{
                $shoulder_orifice[0]='';
              }

              /*
              if(!empty($this->input->post('cap_type'))){
                $cap_type=explode('//',$this->input->post('cap_type'));
              }else{
                $cap_type[0]='';
              }

              if(!empty($this->input->post('cap_finish'))){
                $cap_finish=explode('//',$this->input->post('cap_finish'));
              }else{
                $cap_finish[0]='';
              }

              if(!empty($this->input->post('cap_dia'))){
                $cap_dia=explode('//',$this->input->post('cap_dia'));
              }else{
                $cap_dia[0]='';
              }

              if(!empty($this->input->post('cap_orifice'))){
                $cap_orifice=explode('//',$this->input->post('cap_orifice'));
              }else{
                $cap_orifice[0]='';
              }
              */

              $data['cap_diameter_master']=$this->common_model->select_one_active_record('cap_diameter_master',$this->session->userdata['logged_in']['company_id'],'cap_dia',$CAP_DIA);
            if($data['cap_diameter_master']==FALSE){
              $cap_dia_id="";
            }else{
             foreach($data['cap_diameter_master'] as $cap_diameter_master_row){
              $cap_dia_id=$cap_diameter_master_row->cap_dia_id;
             }
           }

            $data['cap_orifice_master']=$this->common_model->select_one_active_record('cap_orifice_master',$this->session->userdata['logged_in']['company_id'],'cap_orifice',$CAP_ORIFICE);
            if($data['cap_orifice_master']==FALSE){
              $cap_orifice_id="";
            }else{
              foreach($data['cap_orifice_master'] as $cap_orifice_master_row){
              $cap_orifice_id=$cap_orifice_master_row->cap_orifice_id;
               }
             }

             $data['cap_types_master']=$this->common_model->select_one_active_record('cap_types_master',$this->session->userdata['logged_in']['company_id'],'cap_type',$CAP_STYLE);
              if($data['cap_types_master']==FALSE){
                $cap_type_id="";
                }else{
                foreach($data['cap_types_master'] as $cap_types_master_row){
                  $cap_type_id=$cap_types_master_row->cap_type_id;
                 }
              }

             $data['cap_finish_master']=$this->common_model->select_one_active_record('cap_finish_master',$this->session->userdata['logged_in']['company_id'],'cap_finish',$CAP_MOLD_FINISH);
             if($data['cap_finish_master']==FALSE){
              $cap_finish_id="";
              }else{
              foreach($data['cap_finish_master'] as $cap_finish_master_row){
                $cap_finish_id=$cap_finish_master_row->cap_finish_id;
              }
              }

             
             $combination_data=array('sleeve_id'=>$sleeve_dia[1],
              'shld_type_id'=>$shoulder[1],
              'shld_orifice_id'=>$shoulder_orifice[1],
              'cap_dia_id'=>$cap_dia_id,
              'cap_orifice_id'=>$cap_orifice_id,
              'cap_type_id'=>$cap_type_id,
              'cap_finish_id'=>$cap_finish_id);

             $this->load->model('shoulder_orifice_dependancy_model');
             if($this->shoulder_orifice_dependancy_model->select_one_active_combination_record('shoulder_orifice_dependancy',$this->session->userdata['logged_in']['company_id'],$combination_data)>0){

              $data['spec_version']=$this->specification_model->select_specification_verion_no('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$article_no_arr[1]);
              foreach ($data['spec_version'] as $spec_version_row) {

                if($spec_version_row->spec_version_no==NULL){
                  $max_pkey=0;
                  $result=$this->common_model->select_max_pkey('specification_sheet','spec_id',$this->session->userdata['logged_in']['company_id']); 
                  foreach($result as $row){
                    $max_pkey=$row->spec_id;
                    $max_pkey=substr($max_pkey,4);
                    $max_pkey=$max_pkey+1;
                    $spec_no=str_pad($max_pkey,4,0,STR_PAD_LEFT);
                    $spec_no="SPEC".$spec_no;
                  }
                  $spec_version_no=1;
                }else{
                  $spec_version_no=$spec_version_row->spec_version_no;
                  $spec_no=$spec_version_row->spec_id;
                }
              }

              $artwork_no="";
              $artwork_version_no="";
              if(!empty($this->input->post('artwork_final_version_no'))){
                $data['artwork_final_version_no']=$this->artwork_model->select_artwork_final_version('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'article_no',$article_no_arr[1],'final_approval_flag','1','archive<>','1','ad_date','desc','ad_id','desc','version_no','desc');
              if($data['artwork_final_version_no']==FALSE){
                $artwork_no="";
                $artwork_version_no=0;
              }else{
                foreach ($data['artwork_final_version_no'] as $artwork_final_version_no_row){
                   $artwork_no=$artwork_final_version_no_row->ad_id;
                   $artwork_version_no=$artwork_final_version_no_row->version_no;
                }
                }
              }
               

              $data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$customer_arr[1]);
              foreach ($data['customer'] as $customer_row) {
                $property=$customer_row->property_id;
              }

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                    'spec_id'=>$spec_no,
                    'spec_created_date'=>date('Y-m-d'),
                    'spec_version_no'=>$spec_version_no,
                    'property_id'=>$property,
                    'adr_company_id'=>$customer_arr[1],
                    'article_no'=>$article_no_arr[1],
                    'pending_flag'=>'0',
                    'final_approval_flag'=>'0',
                    'user_id'=>$this->session->userdata['logged_in']['user_id'],
                    'ad_id'=>$artwork_no,
                    'version_no'=>$artwork_version_no,
                    'dyn_qty_present'=>'SLEEVE|5^^^SHOULDER|1^^^CAP|1',
                    );

              $result=$this->common_model->save('specification_sheet',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'164',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DIA',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$sleeve_dia[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_1',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'165',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LENGTH',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('sleeve_length')." MM",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_2',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'166',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DRAWING',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_3',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'167',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'GUAGE',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('gauge_one')." MIC",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_4',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              if(!empty($this->input->post('sl_masterbatch_one'))){
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'168',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'material'=>'1',
                'item_group_material'=>'12',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>$sl_mb_supplier_one[1],
                'mat_info'=>$this->input->post('sl_mb_per_one')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_masterbatch_one'),
                'srd_id'=>'1_5_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
            }

              if(!empty($this->input->post('sl_ldpe_one'))){

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'7',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_ldpe_per_one')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_ldpe_one'),
                'srd_id'=>'1_6_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

            }

              if(!empty($this->input->post('sl_lldpe_one'))){
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'8',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_lldpe_per_one')."%",
                'mat_article_no'=>$this->input->post('sl_lldpe_one'),
                'property_id'=>'',
                'srd_id'=>'1_6_1',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
            }

            if(!empty($this->input->post('sl_hdpe_one'))){

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_hdpe_per_one')."%",
                'mat_article_no'=>$this->input->post('sl_hdpe_one'),
                'property_id'=>'',
                'srd_id'=>'1_6_2',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

            }
              


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'185',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'PRINT TYPE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$this->input->post('print_type'),
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_7',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              //Layer 2

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'164',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DIA',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$sleeve_dia[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_1',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'165',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LENGTH',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('sleeve_length')." MM",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_2',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'166',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DRAWING',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_3',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'167',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'GUAGE',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('gauge_two')." MIC",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_4',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'168',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'material'=>'1',
                'item_group_material'=>'12',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_5_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);
            


            if(!empty($this->input->post('sl_admer_two'))){

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'15',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_admer_per_two')."%",
                'mat_article_no'=>$this->input->post('sl_admer_two'),
                'property_id'=>'',
                'srd_id'=>'2_6_4',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);

            }
              


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'185',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'PRINT TYPE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$this->input->post('print_type'),
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_7',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);

              //Layer 3

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'164',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DIA',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$sleeve_dia[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_1',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'165',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LENGTH',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('sleeve_length')." MM",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_2',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'166',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DRAWING',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_3',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'167',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'GUAGE',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('gauge_three')." MIC",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_4',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'168',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'material'=>'1',
                'item_group_material'=>'12',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_5_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);
            


            if(!empty($this->input->post('sl_evoh_three'))){

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'16',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_evoh_per_three')."%",
                'mat_article_no'=>$this->input->post('sl_evoh_three'),
                'property_id'=>'',
                'srd_id'=>'3_6_3',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);

            }
              


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'185',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'PRINT TYPE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$this->input->post('print_type'),
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_7',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);

              //layer 4

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'164',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DIA',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$sleeve_dia[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'4_1',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'4');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'165',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LENGTH',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('sleeve_length')." MM",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'4_2',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'4');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'166',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DRAWING',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'4_3',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'4');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'167',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'GUAGE',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('gauge_four')." MIC",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'4_4',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'4');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'168',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'material'=>'1',
                'item_group_material'=>'12',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'4_5_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'4');
              $result=$this->common_model->save('specification_sheet_details',$data);
            


            if(!empty($this->input->post('sl_admer_four'))){

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'15',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_admer_per_four')."%",
                'mat_article_no'=>$this->input->post('sl_admer_four'),
                'property_id'=>'',
                'srd_id'=>'4_6_4',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'4');
              $result=$this->common_model->save('specification_sheet_details',$data);

            }
              


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'185',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'PRINT TYPE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$this->input->post('print_type'),
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'4_7',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'4');
              $result=$this->common_model->save('specification_sheet_details',$data);

              //Layer 5

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'164',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DIA',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$sleeve_dia[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'5_1',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'5');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'165',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LENGTH',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('sleeve_length')." MM",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'5_2',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'5');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'166',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DRAWING',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'5_3',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'5');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'167',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'GUAGE',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('gauge_five')." MIC",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'5_4',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'5');
              $result=$this->common_model->save('specification_sheet_details',$data);

              if(!empty($this->input->post('sl_masterbatch_five'))){
                $sl_mb_per_five=$this->input->post('sl_mb_per_five')."%";
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'168',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'material'=>'1',
                'item_group_material'=>'12',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>$sl_mb_supplier_five[1],
                'mat_info'=>$sl_mb_per_five,
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_masterbatch_five'),
                'srd_id'=>'5_5_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'5');
              $result=$this->common_model->save('specification_sheet_details',$data);
            }

              if(!empty($this->input->post('sl_ldpe_five'))){

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'7',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_ldpe_per_five')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_ldpe_five'),
                'srd_id'=>'5_6_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'5');
              $result=$this->common_model->save('specification_sheet_details',$data);

            }

              if(!empty($this->input->post('sl_lldpe_five'))){
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'8',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_lldpe_per_five')."%",
                'mat_article_no'=>$this->input->post('sl_lldpe_five'),
                'property_id'=>'',
                'srd_id'=>'5_6_1',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'5');
              $result=$this->common_model->save('specification_sheet_details',$data);
            }

            if(!empty($this->input->post('sl_hdpe_five'))){

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_hdpe_per_five')."%",
                'mat_article_no'=>$this->input->post('sl_hdpe_five'),
                'property_id'=>'',
                'srd_id'=>'5_6_2',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'5');
              $result=$this->common_model->save('specification_sheet_details',$data);

            }
              


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'185',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'PRINT TYPE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$this->input->post('print_type'),
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'5_7',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'5');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'170',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'DRAWING',
                'item_group_material'=>'',
                'material'=>'0',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'6_1',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'171',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'STYLE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$shoulder[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'6_2',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'172',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'NECK TYPE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$shoulder[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'6_3',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'173',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'ORIFICE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$shoulder_orifice[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'6_4',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'174',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'PEEL OFF TE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'6_5',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'175',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'material'=>'1',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'item_group_material'=>'12',
                'supplier_no'=>$sh_mb_supplier[1],
                'mat_info'=>$this->input->post('sh_mb_per')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sh_masterbatch'),
                'srd_id'=>'6_6_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              if(!empty($this->input->post('sh_hdpe_one_per'))){
                $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'176',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'parameter_value'=>'',
                'material'=>'1',
                'item_group_material'=>'6',
                'supplier_no'=>'',
                'relating_master_value'=>'',
                'mat_info'=>$this->input->post('sh_hdpe_one_per')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sh_hdpe_one'),
                'srd_id'=>'6_7_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
              }
              

              if(!empty($this->input->post('sh_hdpe_two_per'))){
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'176',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sh_hdpe_two_per')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sh_hdpe_two'),
                'srd_id'=>'6_7_1',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
            }

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'186',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'material'=>'1',
                'item_group_material'=>'106',
                'parameter_name'=>'SHOULDER FOIL TAG',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('shoulder_foil_tag'),
                'srd_id'=>'6_8',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'177',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'CSPEC',
                'item_group_material'=>'',
                'parameter_value'=>$cap_article_no_arr[2]."//".$cap_article_no_arr[3],
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'7_1',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'178',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'STYLE',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$CAP_STYLE,
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'7_2',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'179',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'MOLD FINISH',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$CAP_MOLD_FINISH,
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'7_3',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'180',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'DIAMETER',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$CAP_DIA,
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'7_4',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'181',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'SHRINK SLEEVE',
                'parameter_value'=>$CAP_SHRINK_SLEEVE_NAME,
                'item_group_material'=>'213',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>$CAP_SHRINK_SLEEVE,
                'srd_id'=>'7_5',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'182',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'ORIFICE',
                'parameter_value'=>'',
                'item_group_material'=>'',
                'relating_master_value'=>$CAP_ORIFICE,
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'7_6',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'183',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'material'=>'1',
                'item_group_material'=>'12',
                'property_id'=>'',
                'supplier_no'=>$CAP_MB_SUPPLIER,
                'mat_info'=>$CAP_MB_PERC,
                'mat_article_no'=>$CAP_MASTER_BATCH,
                'srd_id'=>'7_7_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'184',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'material'=>'1',
                'supplier_no'=>'',
                'property_id'=>'',
                'item_group_material'=>'9',
                'mat_info'=>$CAP_PP_PERC,
                'mat_article_no'=>$CAP_PP,
                'srd_id'=>'7_8_1',
                'item_group_material_flag'=>'2',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'187',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'CAP FOIL COLOR',
                'item_group_material'=>'71',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>$CAP_FOIL_COLOR,
                'material'=>'0',
                'supplier_no'=>'',
                'property_id'=>'',
                'parameter_value'=>$this->input->post('cap_foil_color'),
                'srd_id'=>'7_9',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'188',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'CAP FOIL WIDTH',
                'item_group_material'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'material'=>'0',
                'parameter_value'=>$CAP_FOIL_WIDTH,
                'srd_id'=>'7_10',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

            $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
              'spec_id'=>$spec_no,
              'disp_id'=>'189',
              'item_group_id'=>'5',
              'item_group_flag'=>'1',
              'parameter_name'=>'C.FOIL DIST FROM BOT',
              'item_group_material'=>'',
              'relating_master_value'=>'',
              'supplier_no'=>'',
              'mat_info'=>'',
              'property_id'=>'',
              'mat_article_no'=>'',
              'material'=>'0',
              'parameter_value'=>$CAP_FOIL_DIST_FROM_BOT,
              'srd_id'=>'7_11',
              'item_group_material_flag'=>'0',
              'dyn_qty_no'=>'1',
              'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
              'spec_version_no'=>$spec_version_no,
              'layer_no'=>'1');
            $result=$this->common_model->save('specification_sheet_details',$data);

            $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
              'spec_id'=>$spec_no,
              'disp_id'=>'190',
              'item_group_id'=>'6',
              'item_group_flag'=>'1',
              'parameter_name'=>'LABEL',
              'item_group_material'=>'5',
              'relating_master_value'=>'',
              'supplier_no'=>'',
              'mat_info'=>'',
              'property_id'=>'',
              'mat_article_no'=>$label_article[1],
              'material'=>'1',
              'parameter_value'=>'',
              'srd_id'=>'7_12',
              'item_group_material_flag'=>'1',
              'dyn_qty_no'=>'1',
              'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
              'spec_version_no'=>$spec_version_no,
              'layer_no'=>'1');
            $result=$this->common_model->save('specification_sheet_details',$data);


            $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
              'spec_id'=>$spec_no,
              'lang_comments'=>$this->input->post('comment'),
              'language_id'=>$this->session->userdata['logged_in']['language_id'],
              'spec_version_no'=>$spec_version_no);
            $result=$this->common_model->save('specification_sheet_lang',$data);

              
              $data['note']='Create Transaction Completed';
              header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

              }else{
              $data['error']='Wrong combination';
             }

            $data['page_name']='Sales';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
            $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
              
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

            $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
            $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
            $data['admer']=$this->article_model->spec_active_record_search('article','15',$this->session->userdata['logged_in']['company_id']);
            $data['evoh']=$this->article_model->spec_active_record_search('article','16',$this->session->userdata['logged_in']['company_id']);
            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
            $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);

            $dataa=array('article_main_group.main_group_id'=>'5');
            $data['label']=$this->article_model->active_record_search('article',$dataa,$this->session->userdata['logged_in']['company_id']);
            $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);

                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                  $this->load->view(ucwords($this->router->fetch_class()).'/create-five-form',$data);
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

   function save_five_layer_with_cap_copy(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $this->form_validation->set_rules('customer','Customer' ,'required|trim|xss_clean|callback_customer_check');
            $this->form_validation->set_rules('article_no','Article No' ,'required|trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('spec_version_no','Spec Version No' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('artwork_final_version_no','Artwork Version No' ,'trim|xss_clean');

            if($this->input->post('sleeve_dia') || $this->input->post('sleeve_length') || $this->input->post('gauge_one') || $this->input->post('print_type') || $this->input->post('sl_masterbatch_one') || $this->input->post('sl_mb_per_one')){

              $this->form_validation->set_rules('sleeve_dia','Sleeve Dia' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sleeve_length','Sleeve Length' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');
              $this->form_validation->set_rules('gauge_one','Gauge Layer One' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');
              $this->form_validation->set_rules('print_type','Print Type' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sl_masterbatch_one','Sleeve Masterbatch Layer One' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sl_mb_supplier_one','Sleeve Masterbatch Supplier Layer One','trim|xss_clean|callback_supplier_check');
              $this->form_validation->set_rules('sl_mb_per_one','Sleeve Masterbatch % Layer One' ,'required|trim|xss_clean|numeric|max_length[3]');

              $this->form_validation->set_rules('sl_ldpe_per_one','Sleeve Ldpe % Layer One' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_one_check');
              $this->form_validation->set_rules('sl_lldpe_per_one','Sleeve Lldpe % Layer One' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_one_check');
              $this->form_validation->set_rules('sl_hdpe_per_one','Sleeve Hdpe % Layer One' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_one_check');

              if(!empty($this->input->post('sl_ldpe_per_one'))){
                $this->form_validation->set_rules('sl_ldpe_one','Sleeve Ldpe Layer One' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_lldpe_per'))){
                $this->form_validation->set_rules('sl_lldpe_one','Sleeve Lldpe Layer One' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_hdpe_per'))){
                $this->form_validation->set_rules('sl_hdpe_one','Sleeve Hdpe Layer One' ,'trim|xss_clean|required');
              }


              $this->form_validation->set_rules('gauge_two','Gauge Layer Two' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');

              $this->form_validation->set_rules('sl_admer_two','Sleeve Admer Layer two' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sl_admer_per_two','Sleeve Admer % Layer two' ,'required|trim|xss_clean|numeric|exact_length[3]');

              $this->form_validation->set_rules('gauge_three','Gauge Layer Three' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');

              $this->form_validation->set_rules('sl_evoh_three','Sleeve Evoh Layer Three' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sl_evoh_per_three','Sleeve Evoh % Layer Three' ,'required|trim|xss_clean|numeric|exact_length[3]');

              $this->form_validation->set_rules('gauge_four','Gauge Layer Four' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');

              $this->form_validation->set_rules('sl_admer_four','Sleeve Admer Layer Four' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sl_admer_per_four','Sleeve Admer % Layer Four' ,'required|trim|xss_clean|numeric|exact_length[3]');

              $this->form_validation->set_rules('gauge_five','Gauge Layer Five' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');
              $this->form_validation->set_rules('sl_masterbatch_five','Sleeve Masterbatch Layer Five' ,'trim|xss_clean');
              $this->form_validation->set_rules('sl_mb_supplier_five','Sleeve Masterbatch Supplier Layer Five','trim|xss_clean|callback_supplier_check');
              $this->form_validation->set_rules('sl_mb_per_five','Sleeve Masterbatch % Layer Five' ,'trim|xss_clean|numeric|max_length[3]');

              $this->form_validation->set_rules('sl_ldpe_per_five','Sleeve Ldpe % Layer Five' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_five_check');
              $this->form_validation->set_rules('sl_lldpe_per_five','Sleeve Lldpe % Layer Five' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_five_check');
              $this->form_validation->set_rules('sl_hdpe_per_five','Sleeve Hdpe % Layer Five' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_five_check');

              if(!empty($this->input->post('sl_ldpe_per_five'))){
                $this->form_validation->set_rules('sl_ldpe_five','Sleeve Ldpe Layer Five' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_lldpe_per_five'))){
                $this->form_validation->set_rules('sl_lldpe_five','Sleeve Lldpe Layer Five' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_hdpe_per_five'))){
                $this->form_validation->set_rules('sl_hdpe_five','Sleeve Hdpe Layer Five' ,'trim|xss_clean|required');
              }
              

            }
            
            if($this->input->post('shoulder') || $this->input->post('shoulder_orifice') || $this->input->post('sh_masterbatch') || $this->input->post('sh_mb_per')){
            
              $this->form_validation->set_rules('shoulder','Shoulder' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('shoulder_orifice','Shoulder Orifice' ,'trim|xss_clean');
              $this->form_validation->set_rules('sh_masterbatch','Shoulder Masterbatch' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sh_mb_supplier','Shoulder Masterbatch Supplier' ,'trim|xss_clean|callback_supplier_check');
              $this->form_validation->set_rules('sh_mb_per','Shoulder Masterbatch %' ,'required|trim|xss_clean|numeric|max_length[3]');
              $this->form_validation->set_rules('sh_hdpe_one_per','Shoulder HDPE %' ,'trim|xss_clean|numeric|max_length[3]|callback_shoulder_per_check');
              $this->form_validation->set_rules('sh_hdpe_two_per','Shoulder HDPE %' ,'trim|xss_clean|numeric|max_length[3]|callback_shoulder_per_check');

               if(!empty($this->input->post('sh_hdpe_one_per'))){
                $this->form_validation->set_rules('sh_hdpe_one','Shoulder Hdpe' ,'trim|xss_clean|required');
                }if(!empty($this->input->post('sh_hdpe_two_per'))){
                $this->form_validation->set_rules('sh_hdpe_two','Shoulder Hdpe' ,'trim|xss_clean|required');
                }

            }

            if(!empty($this->input->post('cap_spec_no'))){
              $this->form_validation->set_rules('cap_spec_no','Cap Spec No' ,'trim|xss_clean|required|exact_length[9]');
              $this->form_validation->set_rules('cap_spec_version_no','Cap Spec Version' ,'trim|xss_clean|required');
            }
            $this->form_validation->set_rules('label_article_no','Label Article No' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('cap_article_no','Cap Article No' ,'trim|xss_clean|callback_article_check');

            

            if($this->form_validation->run()==FALSE){
              
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

            $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
            $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
            $data['admer']=$this->article_model->spec_active_record_search('article','15',$this->session->userdata['logged_in']['company_id']);
            $data['evoh']=$this->article_model->spec_active_record_search('article','16',$this->session->userdata['logged_in']['company_id']);
            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
            $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);

            $dataa=array('article_main_group.main_group_id'=>'5');
            $data['label']=$this->article_model->active_record_search('article',$dataa,$this->session->userdata['logged_in']['company_id']);
            $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);

            $data['specification']=$this->specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->input->post('spec_id'),'specification_sheet.spec_version_no',$this->input->post('copy_version_no'));


              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/five-copy-form',$data);
              $this->load->view('Home/footer');
            }else{

              if(!empty($this->input->post('customer'))){
                $customer_arr=explode('//',$this->input->post('customer'));
              }

              if(!empty($this->input->post('article_no'))){
                $article_no_arr=explode('//',$this->input->post('article_no'));
              }

              if(!empty($this->input->post('cap_article_no'))){
                $cap_article_no_arr=explode('//',$this->input->post('cap_article_no'));
              }

              if(!empty($this->input->post('cap_spec_no'))){
                $cap_article_no_arr[2]=$this->input->post('cap_spec_no');
                $cap_article_no_arr[3]=$this->input->post('cap_spec_version_no');
              }


              $data=array('spec_id'=>$cap_article_no_arr[2],
                  'spec_version_no'=>$cap_article_no_arr[3]);
                $data['specs_details']=$this->sales_order_book_model->select_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data);
                if($data['specs_details']==FALSE){
                  $CAP_DIA="";
                  $CAP_STYLE="";
                  $CAP_MOLD_FINISH="";
                  $CAP_ORIFICE="";
                  $CAP_MASTER_BATCH="";
                  $CAP_MB_PERC="";
                  $CAP_MB_SUPPLIER="";
                  $CAP_PP="";
                  $CAP_PP_PERC="";
                  $CAP_FOIL_COLOR="";
                  $CAP_FOIL_WIDTH="";
                  $CAP_FOIL_DIST_FROM_BOT="";
                  $CAP_SHRINK_SLEEVE="";
                  $CAP_SHRINK_SLEEVE_NAME="";
                }else{
                  foreach($data['specs_details'] as $specs_details_row){
                  $CAP_DIA=$specs_details_row->CAP_DIA;
                  $CAP_STYLE=$specs_details_row->CAP_STYLE;
                  $CAP_MOLD_FINISH=$specs_details_row->CAP_MOLD_FINISH;
                  $CAP_ORIFICE=$specs_details_row->CAP_ORIFICE;
                  $CAP_MASTER_BATCH=$specs_details_row->CAP_MASTER_BATCH;
                  $CAP_MB_PERC=$specs_details_row->CAP_MB_PERC;
                  $CAP_MB_SUPPLIER=$specs_details_row->CAP_MB_SUPPLIER;
                  $CAP_PP=$specs_details_row->CAP_PP;
                  $CAP_PP_PERC=$specs_details_row->CAP_PP_PERC;
                  $CAP_FOIL_COLOR=$specs_details_row->CAP_FOIL_COLOR;
                  $CAP_FOIL_WIDTH=$specs_details_row->CAP_FOIL_WIDTH;
                  $CAP_FOIL_DIST_FROM_BOT=$specs_details_row->CAP_FOIL_DIST_FROM_BOT;
                  $CAP_SHRINK_SLEEVE=$specs_details_row->CAP_SHRINK_SLEEVE;
                  $CAP_SHRINK_SLEEVE_NAME=$specs_details_row->CAP_SHRINK_SLEEVE_NAME;
                  }
                }
                
              if(!empty($this->input->post('label_article_no'))){
                $label_article=explode('//',$this->input->post('label_article_no'));
              }else{
                $label_article[1]='';
              }

              if(!empty($this->input->post('sleeve_dia'))){
                $sleeve_dia=explode('//',$this->input->post('sleeve_dia'));
              }else{
                $sleeve_dia[0]='';
              }

              if(!empty($this->input->post('sl_mb_supplier_one'))){
                $sl_mb_supplier_one=explode('//',$this->input->post('sl_mb_supplier_one'));
              }else{
                $sl_mb_supplier_one[1]='';
              }

              if(!empty($this->input->post('sl_mb_supplier_five'))){
                $sl_mb_supplier_five=explode('//',$this->input->post('sl_mb_supplier_five'));
              }else{
                $sl_mb_supplier_five[1]='';
              }

              if(!empty($this->input->post('sh_mb_supplier'))){
                $sh_mb_supplier=explode('//',$this->input->post('sh_mb_supplier'));
              }else{
                $sh_mb_supplier[1]='';
              }

              if(!empty($this->input->post('cap_mb_supplier'))){
                $cap_mb_supplier=explode('//',$this->input->post('cap_mb_supplier'));
              }else{
                $cap_mb_supplier[1]='';
              }

              if(!empty($this->input->post('shoulder'))){
                $shoulder=explode('//',$this->input->post('shoulder'));
              }else{
                $shoulder[0]='';
              }

              if(!empty($this->input->post('shoulder_orifice'))){
                $shoulder_orifice=explode('//',$this->input->post('shoulder_orifice'));
              }else{
                $shoulder_orifice[0]='';
              }

              /*
              if(!empty($this->input->post('cap_type'))){
                $cap_type=explode('//',$this->input->post('cap_type'));
              }else{
                $cap_type[0]='';
              }

              if(!empty($this->input->post('cap_finish'))){
                $cap_finish=explode('//',$this->input->post('cap_finish'));
              }else{
                $cap_finish[0]='';
              }

              if(!empty($this->input->post('cap_dia'))){
                $cap_dia=explode('//',$this->input->post('cap_dia'));
              }else{
                $cap_dia[0]='';
              }

              if(!empty($this->input->post('cap_orifice'))){
                $cap_orifice=explode('//',$this->input->post('cap_orifice'));
              }else{
                $cap_orifice[0]='';
              }
              */

              $data['spec_version']=$this->specification_model->select_specification_verion_no('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$article_no_arr[1]);
              foreach ($data['spec_version'] as $spec_version_row) {

                if($spec_version_row->spec_version_no==NULL){
                  $max_pkey=0;
                  $result=$this->common_model->select_max_pkey('specification_sheet','spec_id',$this->session->userdata['logged_in']['company_id']); 
                  foreach($result as $row){
                    $max_pkey=$row->spec_id;
                    $max_pkey=substr($max_pkey,4);
                    $max_pkey=$max_pkey+1;
                    $spec_no=str_pad($max_pkey,4,0,STR_PAD_LEFT);
                    $spec_no="SPEC".$spec_no;
                  }
                  $spec_version_no=1;
                }else{
                  $spec_version_no=$spec_version_row->spec_version_no;
                  $spec_no=$spec_version_row->spec_id;
                }
              }

              $artwork_no="";
              $artwork_version_no="";
              if(!empty($this->input->post('artwork_final_version_no'))){
                $data['artwork_final_version_no']=$this->artwork_model->select_artwork_final_version('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'article_no',$article_no_arr[1],'final_approval_flag','1','archive<>','1','ad_date','desc','ad_id','desc','version_no','desc');
              if($data['artwork_final_version_no']==FALSE){
                $artwork_no="";
                $artwork_version_no=0;
              }else{
                foreach ($data['artwork_final_version_no'] as $artwork_final_version_no_row){
                   $artwork_no=$artwork_final_version_no_row->ad_id;
                   $artwork_version_no=$artwork_final_version_no_row->version_no;
                }
                }
              }
               

              $data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$customer_arr[1]);
              foreach ($data['customer'] as $customer_row) {
                $property=$customer_row->property_id;
              }

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                    'spec_id'=>$spec_no,
                    'spec_created_date'=>date('Y-m-d'),
                    'spec_version_no'=>$spec_version_no,
                    'property_id'=>$property,
                    'adr_company_id'=>$customer_arr[1],
                    'article_no'=>$article_no_arr[1],
                    'pending_flag'=>'0',
                    'final_approval_flag'=>'0',
                    'user_id'=>$this->session->userdata['logged_in']['user_id'],
                    'ad_id'=>$artwork_no,
                    'version_no'=>$artwork_version_no,
                    'dyn_qty_present'=>'SLEEVE|5^^^SHOULDER|1^^^CAP|1',
                    );

              $result=$this->common_model->save('specification_sheet',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'164',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DIA',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$sleeve_dia[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_1',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'165',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LENGTH',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('sleeve_length')." MM",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_2',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'166',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DRAWING',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_3',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'167',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'GUAGE',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('gauge_one')." MIC",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_4',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              if(!empty($this->input->post('sl_masterbatch_one'))){
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'168',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'material'=>'1',
                'item_group_material'=>'12',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>$sl_mb_supplier_one[1],
                'mat_info'=>$this->input->post('sl_mb_per_one')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_masterbatch_one'),
                'srd_id'=>'1_5_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
            }

              if(!empty($this->input->post('sl_ldpe_one'))){

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'7',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_ldpe_per_one')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_ldpe_one'),
                'srd_id'=>'1_6_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

            }

              if(!empty($this->input->post('sl_lldpe_one'))){
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'8',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_lldpe_per_one')."%",
                'mat_article_no'=>$this->input->post('sl_lldpe_one'),
                'property_id'=>'',
                'srd_id'=>'1_6_1',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
            }

            if(!empty($this->input->post('sl_hdpe_one'))){

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_hdpe_per_one')."%",
                'mat_article_no'=>$this->input->post('sl_hdpe_one'),
                'property_id'=>'',
                'srd_id'=>'1_6_2',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

            }
              


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'185',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'PRINT TYPE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$this->input->post('print_type'),
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'1_7',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              //Layer 2

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'164',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DIA',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$sleeve_dia[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_1',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'165',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LENGTH',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('sleeve_length')." MM",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_2',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'166',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DRAWING',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_3',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'167',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'GUAGE',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('gauge_two')." MIC",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_4',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'168',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'material'=>'1',
                'item_group_material'=>'12',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_5_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);
            


            if(!empty($this->input->post('sl_admer_two'))){

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'15',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_admer_per_two')."%",
                'mat_article_no'=>$this->input->post('sl_admer_two'),
                'property_id'=>'',
                'srd_id'=>'2_6_4',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);

            }
              


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'185',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'PRINT TYPE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$this->input->post('print_type'),
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_7',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'2');
              $result=$this->common_model->save('specification_sheet_details',$data);

              //Layer 3

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'164',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DIA',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$sleeve_dia[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_1',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'165',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LENGTH',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('sleeve_length')." MM",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_2',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'166',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DRAWING',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_3',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'167',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'GUAGE',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('gauge_three')." MIC",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_4',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'168',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'material'=>'1',
                'item_group_material'=>'12',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_5_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);
            


            if(!empty($this->input->post('sl_evoh_three'))){

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'16',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_evoh_per_three')."%",
                'mat_article_no'=>$this->input->post('sl_evoh_three'),
                'property_id'=>'',
                'srd_id'=>'3_6_3',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);

            }
              


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'185',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'PRINT TYPE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$this->input->post('print_type'),
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'3_7',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'3');
              $result=$this->common_model->save('specification_sheet_details',$data);

              //layer 4

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'164',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DIA',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$sleeve_dia[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'4_1',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'4');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'165',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LENGTH',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('sleeve_length')." MM",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'4_2',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'4');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'166',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DRAWING',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'4_3',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'4');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'167',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'GUAGE',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('gauge_four')." MIC",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'4_4',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'4');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'168',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'material'=>'1',
                'item_group_material'=>'12',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'4_5_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'4');
              $result=$this->common_model->save('specification_sheet_details',$data);
            


            if(!empty($this->input->post('sl_admer_four'))){

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'15',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_admer_per_four')."%",
                'mat_article_no'=>$this->input->post('sl_admer_four'),
                'property_id'=>'',
                'srd_id'=>'4_6_4',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'4');
              $result=$this->common_model->save('specification_sheet_details',$data);

            }
              


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'185',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'PRINT TYPE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$this->input->post('print_type'),
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'4_7',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'4');
              $result=$this->common_model->save('specification_sheet_details',$data);

              //Layer 5

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'164',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DIA',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$sleeve_dia[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'5_1',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'5');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'165',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'LENGTH',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('sleeve_length')." MM",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'5_2',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'5');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'166',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'DRAWING',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'5_3',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'5');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'167',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'GUAGE',
                'item_group_material'=>'',
                'parameter_value'=>$this->input->post('gauge_five')." MIC",
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'5_4',
                'item_group_material_flag'=>'',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'5');
              $result=$this->common_model->save('specification_sheet_details',$data);

              if(!empty($this->input->post('sl_masterbatch_five'))){
                $sl_mb_per_five=$this->input->post('sl_mb_per_five')."%";
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'168',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'material'=>'1',
                'item_group_material'=>'12',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>$sl_mb_supplier_five[1],
                'mat_info'=>$sl_mb_per_five,
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_masterbatch_five'),
                'srd_id'=>'5_5_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'5');
              $result=$this->common_model->save('specification_sheet_details',$data);
            }

              if(!empty($this->input->post('sl_ldpe_five'))){

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'7',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_ldpe_per_five')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sl_ldpe_five'),
                'srd_id'=>'5_6_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'5');
              $result=$this->common_model->save('specification_sheet_details',$data);

            }

              if(!empty($this->input->post('sl_lldpe_five'))){
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'8',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_lldpe_per_five')."%",
                'mat_article_no'=>$this->input->post('sl_lldpe_five'),
                'property_id'=>'',
                'srd_id'=>'5_6_1',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'5');
              $result=$this->common_model->save('specification_sheet_details',$data);
            }

            if(!empty($this->input->post('sl_hdpe_five'))){

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'169',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sl_hdpe_per_five')."%",
                'mat_article_no'=>$this->input->post('sl_hdpe_five'),
                'property_id'=>'',
                'srd_id'=>'5_6_2',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'5');
              $result=$this->common_model->save('specification_sheet_details',$data);

            }
              


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'185',
                'item_group_id'=>'3',
                'item_group_flag'=>'1',
                'parameter_name'=>'PRINT TYPE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$this->input->post('print_type'),
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'5_7',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'5',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'5');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'170',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'DRAWING',
                'item_group_material'=>'',
                'material'=>'0',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'6_1',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'171',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'STYLE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$shoulder[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'6_2',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'172',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'NECK TYPE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$shoulder[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'6_3',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'173',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'ORIFICE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$shoulder_orifice[0],
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'6_4',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'174',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'PEEL OFF TE',
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'6_5',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'175',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'material'=>'1',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'item_group_material'=>'12',
                'supplier_no'=>$sh_mb_supplier[1],
                'mat_info'=>$this->input->post('sh_mb_per')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sh_masterbatch'),
                'srd_id'=>'6_6_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              if(!empty($this->input->post('sh_hdpe_one_per'))){
                $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'176',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'parameter_value'=>'',
                'material'=>'1',
                'item_group_material'=>'6',
                'supplier_no'=>'',
                'relating_master_value'=>'',
                'mat_info'=>$this->input->post('sh_hdpe_one_per')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sh_hdpe_one'),
                'srd_id'=>'6_7_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
              }
              

              if(!empty($this->input->post('sh_hdpe_two_per'))){
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'176',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sh_hdpe_two_per')."%",
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sh_hdpe_two'),
                'srd_id'=>'6_7_1',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
            }

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'186',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'material'=>'1',
                'item_group_material'=>'106',
                'parameter_name'=>'SHOULDER FOIL TAG',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('shoulder_foil_tag'),
                'srd_id'=>'6_8',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'177',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'CSPEC',
                'item_group_material'=>'',
                'parameter_value'=>$cap_article_no_arr[2]."//".$cap_article_no_arr[3],
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'7_1',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'178',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'STYLE',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$CAP_STYLE,
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'7_2',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'179',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'MOLD FINISH',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$CAP_MOLD_FINISH,
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'7_3',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'180',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'DIAMETER',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$CAP_DIA,
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'7_4',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'181',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'SHRINK SLEEVE',
                'parameter_value'=>$CAP_SHRINK_SLEEVE_NAME,
                'item_group_material'=>'213',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>$CAP_SHRINK_SLEEVE,
                'srd_id'=>'7_5',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'182',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'ORIFICE',
                'parameter_value'=>'',
                'item_group_material'=>'',
                'relating_master_value'=>$CAP_ORIFICE,
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'7_6',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'183',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'MASTER BATCH',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'material'=>'1',
                'item_group_material'=>'12',
                'property_id'=>'',
                'supplier_no'=>$CAP_MB_SUPPLIER,
                'mat_info'=>$CAP_MB_PERC,
                'mat_article_no'=>$CAP_MASTER_BATCH,
                'srd_id'=>'7_7_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'184',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'material'=>'1',
                'supplier_no'=>'',
                'property_id'=>'',
                'item_group_material'=>'9',
                'mat_info'=>$CAP_PP_PERC,
                'mat_article_no'=>$CAP_PP,
                'srd_id'=>'7_8_1',
                'item_group_material_flag'=>'2',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'187',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'CAP FOIL COLOR',
                'item_group_material'=>'71',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>$CAP_FOIL_COLOR,
                'material'=>'0',
                'supplier_no'=>'',
                'property_id'=>'',
                'parameter_value'=>$this->input->post('cap_foil_color'),
                'srd_id'=>'7_9',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'188',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'CAP FOIL WIDTH',
                'item_group_material'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'material'=>'0',
                'parameter_value'=>$CAP_FOIL_WIDTH,
                'srd_id'=>'7_10',
                'item_group_material_flag'=>'0',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);

            $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
              'spec_id'=>$spec_no,
              'disp_id'=>'189',
              'item_group_id'=>'5',
              'item_group_flag'=>'1',
              'parameter_name'=>'C.FOIL DIST FROM BOT',
              'item_group_material'=>'',
              'relating_master_value'=>'',
              'supplier_no'=>'',
              'mat_info'=>'',
              'property_id'=>'',
              'mat_article_no'=>'',
              'material'=>'0',
              'parameter_value'=>$CAP_FOIL_DIST_FROM_BOT,
              'srd_id'=>'7_11',
              'item_group_material_flag'=>'0',
              'dyn_qty_no'=>'1',
              'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
              'spec_version_no'=>$spec_version_no,
              'layer_no'=>'1');
            $result=$this->common_model->save('specification_sheet_details',$data);

            $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
              'spec_id'=>$spec_no,
              'disp_id'=>'190',
              'item_group_id'=>'6',
              'item_group_flag'=>'1',
              'parameter_name'=>'LABEL',
              'item_group_material'=>'6',
              'relating_master_value'=>'',
              'supplier_no'=>'',
              'mat_info'=>'',
              'property_id'=>'',
              'mat_article_no'=>$label_article[1],
              'material'=>'1',
              'parameter_value'=>'',
              'srd_id'=>'7_12',
              'item_group_material_flag'=>'1',
              'dyn_qty_no'=>'1',
              'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
              'spec_version_no'=>$spec_version_no,
              'layer_no'=>'1');
            $result=$this->common_model->save('specification_sheet_details',$data);


            $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
              'spec_id'=>$spec_no,
              'lang_comments'=>$this->input->post('comment'),
              'language_id'=>$this->session->userdata['logged_in']['language_id'],
              'spec_version_no'=>$spec_version_no);
            $result=$this->common_model->save('specification_sheet_lang',$data);

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
              $data['note']='Copy Transaction Completed';
              header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
              
                  $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

            $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
            $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
            $data['admer']=$this->article_model->spec_active_record_search('article','15',$this->session->userdata['logged_in']['company_id']);
            $data['evoh']=$this->article_model->spec_active_record_search('article','16',$this->session->userdata['logged_in']['company_id']);
            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
            $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);

            $dataa=array('article_main_group.main_group_id'=>'5');
            $data['label']=$this->article_model->active_record_search('article',$dataa,$this->session->userdata['logged_in']['company_id']);
            $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);

            $data['specification']=$this->specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$spec_no,'specification_sheet.spec_version_no',$spec_version_no);

                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                  $this->load->view(ucwords($this->router->fetch_class()).'/five-copy-form',$data);
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


  function update_five_layer_with_cap(){
      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){
            $this->form_validation->set_rules('customer','Customer' ,'required|trim|xss_clean|callback_customer_check');
            $this->form_validation->set_rules('article_no','Article No' ,'required|trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('spec_version_no','Spec Version No' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('artwork_final_version_no','Artwork Version No' ,'trim|xss_clean');

            if($this->input->post('sleeve_dia')){

              $this->form_validation->set_rules('sleeve_dia','Sleeve Dia' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sleeve_length','Sleeve Length' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');
              $this->form_validation->set_rules('gauge_one','Gauge Layer One' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');
              $this->form_validation->set_rules('print_type','Print Type' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sl_masterbatch_one','Sleeve Masterbatch Layer One' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sl_mb_supplier_one','Sleeve Masterbatch Supplier Layer One','trim|xss_clean|callback_supplier_check');
              $this->form_validation->set_rules('sl_mb_per_one','Sleeve Masterbatch % Layer One' ,'required|trim|xss_clean|numeric|max_length[3]');

              $this->form_validation->set_rules('sl_ldpe_per_one','Sleeve Ldpe % Layer One' ,'trim|xss_clean|is_natural|max_length[3]|callback_sleeve_per_one_check');
              $this->form_validation->set_rules('sl_lldpe_per_one','Sleeve Lldpe % Layer One' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_one_check');
              $this->form_validation->set_rules('sl_hdpe_per_one','Sleeve Hdpe % Layer One' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_one_check');

              if(!empty($this->input->post('sl_ldpe_per_one'))){
                $this->form_validation->set_rules('sl_ldpe_one','Sleeve Ldpe Layer One' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_lldpe_per'))){
                $this->form_validation->set_rules('sl_lldpe_one','Sleeve Lldpe Layer One' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_hdpe_per'))){
                $this->form_validation->set_rules('sl_hdpe_one','Sleeve Hdpe Layer One' ,'trim|xss_clean|required');
              }


              $this->form_validation->set_rules('gauge_two','Gauge Layer Two' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');

              $this->form_validation->set_rules('sl_admer_two','Sleeve Admer Layer two' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sl_admer_per_two','Sleeve Admer % Layer two' ,'required|trim|xss_clean|numeric|exact_length[3]');

              $this->form_validation->set_rules('gauge_three','Gauge Layer Three' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');

              $this->form_validation->set_rules('sl_evoh_three','Sleeve Evoh Layer Three' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sl_evoh_per_three','Sleeve Evoh % Layer Three' ,'required|trim|xss_clean|numeric|exact_length[3]');

              $this->form_validation->set_rules('gauge_four','Gauge Layer Four' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');

              $this->form_validation->set_rules('sl_admer_four','Sleeve Admer Layer Four' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sl_admer_per_four','Sleeve Admer % Layer Four' ,'required|trim|xss_clean|numeric|exact_length[3]');

              $this->form_validation->set_rules('gauge_five','Gauge Layer Five' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');
              $this->form_validation->set_rules('sl_masterbatch_five','Sleeve Masterbatch Layer Five' ,'trim|xss_clean');
              $this->form_validation->set_rules('sl_mb_supplier_five','Sleeve Masterbatch Supplier Layer Five','trim|xss_clean|callback_supplier_check');
              $this->form_validation->set_rules('sl_mb_per_five','Sleeve Masterbatch % Layer Five' ,'trim|xss_clean|numeric|max_length[3]');

              $this->form_validation->set_rules('sl_ldpe_per_five','Sleeve Ldpe % Layer Five' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_five_check');
              $this->form_validation->set_rules('sl_lldpe_per_five','Sleeve Lldpe % Layer Five' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_five_check');
              $this->form_validation->set_rules('sl_hdpe_per_five','Sleeve Hdpe % Layer Five' ,'trim|xss_clean|numeric|max_length[3]|callback_sleeve_per_five_check');

              if(!empty($this->input->post('sl_ldpe_per_five'))){
                $this->form_validation->set_rules('sl_ldpe_five','Sleeve Ldpe Layer Five' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_lldpe_per_five'))){
                $this->form_validation->set_rules('sl_lldpe_five','Sleeve Lldpe Layer Five' ,'trim|xss_clean|required');
              }if(!empty($this->input->post('sl_hdpe_per_five'))){
                $this->form_validation->set_rules('sl_hdpe_five','Sleeve Hdpe Layer Five' ,'trim|xss_clean|required');
              }
              

            }
            
            if($this->input->post('shoulder')){
            
              $this->form_validation->set_rules('shoulder','Shoulder' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('shoulder_orifice','Shoulder Orifice' ,'trim|xss_clean');
              $this->form_validation->set_rules('shoulder_foil_tag','Shoulder Foil Tag' ,'required|trim|xss_clean|strtoupper');
              $this->form_validation->set_rules('sh_masterbatch','Shoulder Masterbatch' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sh_mb_supplier','Shoulder Masterbatch Supplier' ,'trim|xss_clean|callback_supplier_check');
              $this->form_validation->set_rules('sh_mb_per','Shoulder Masterbatch %' ,'required|trim|xss_clean|numeric|max_length[3]');
              $this->form_validation->set_rules('sh_hdpe_one_per','Shoulder HDPE %' ,'trim|xss_clean|is_natural|max_length[3]|callback_shoulder_per_check');
              $this->form_validation->set_rules('sh_hdpe_two_per','Shoulder HDPE %' ,'trim|xss_clean|is_natural|max_length[3]|callback_shoulder_per_check');

               if(!empty($this->input->post('sh_hdpe_one_per'))){
                $this->form_validation->set_rules('sh_hdpe_one','Shoulder Hdpe' ,'trim|xss_clean|required');
                }if(!empty($this->input->post('sh_hdpe_two_per'))){
                $this->form_validation->set_rules('sh_hdpe_two','Shoulder Hdpe' ,'trim|xss_clean|required');
                }

            }


            if(!empty($this->input->post('cap_spec_no'))){
              $this->form_validation->set_rules('cap_spec_no','Cap Spec No' ,'trim|xss_clean|required|exact_length[9]');
              $this->form_validation->set_rules('cap_spec_version_no','Cap Spec Version' ,'trim|xss_clean|required');
            }

            $this->form_validation->set_rules('label_article_no','Label Article No' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('cap_article_no','Cap Article No' ,'trim|xss_clean|callback_article_check');
              

              if($this->form_validation->run()==FALSE){

                $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
                $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
                $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
                $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
                $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

                $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
                $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
                $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
                $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
                $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);
                $data['admer']=$this->article_model->spec_active_record_search('article','15',$this->session->userdata['logged_in']['company_id']);
                $data['evoh']=$this->article_model->spec_active_record_search('article','16',$this->session->userdata['logged_in']['company_id']);

                $dataa=array('article_main_group.main_group_id'=>'5');
                $data['label']=$this->article_model->active_record_search('article',$dataa,$this->session->userdata['logged_in']['company_id']);
                $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);

                $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

                $data['specification']=$this->specification_model->select_one_active_unapproved_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->input->post('spec_id'),'specification_sheet.spec_version_no',$this->input->post('spec_version_no'),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/five-modify-form-with-cap',$data);
                $this->load->view('Home/footer');

              }else{
                  if(!empty($this->input->post('customer'))){
                      $customer_arr=explode('//',$this->input->post('customer'));
                    }

                    if(!empty($this->input->post('article_no'))){
                      $article_no_arr=explode('//',$this->input->post('article_no'));
                    }

                    if(!empty($this->input->post('cap_article_no'))){
                $cap_article_no_arr=explode('//',$this->input->post('cap_article_no'));
              }

              if(!empty($this->input->post('cap_spec_no'))){
                $cap_article_no_arr[2]=$this->input->post('cap_spec_no');
                $cap_article_no_arr[3]=$this->input->post('cap_spec_version_no');
              }


              $data=array('spec_id'=>$cap_article_no_arr[2],
                  'spec_version_no'=>$cap_article_no_arr[3]);
                $data['specs_details']=$this->sales_order_book_model->select_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data);
                if($data['specs_details']==FALSE){
                  $CAP_DIA="";
                  $CAP_STYLE="";
                  $CAP_MOLD_FINISH="";
                  $CAP_ORIFICE="";
                  $CAP_MASTER_BATCH="";
                  $CAP_MB_PERC="";
                  $CAP_MB_SUPPLIER="";
                  $CAP_PP="";
                  $CAP_PP_PERC="";
                  $CAP_FOIL_COLOR="";
                  $CAP_FOIL_WIDTH="";
                  $CAP_FOIL_DIST_FROM_BOT="";
                  $CAP_SHRINK_SLEEVE="";
                  $CAP_SHRINK_SLEEVE_NAME="";
                }else{
                  foreach($data['specs_details'] as $specs_details_row){
                  $CAP_DIA=$specs_details_row->CAP_DIA;
                  $CAP_STYLE=$specs_details_row->CAP_STYLE;
                  $CAP_MOLD_FINISH=$specs_details_row->CAP_MOLD_FINISH;
                  $CAP_ORIFICE=$specs_details_row->CAP_ORIFICE;
                  $CAP_MASTER_BATCH=$specs_details_row->CAP_MASTER_BATCH;
                  $CAP_MB_PERC=$specs_details_row->CAP_MB_PERC;
                  $CAP_MB_SUPPLIER=$specs_details_row->CAP_MB_SUPPLIER;
                  $CAP_PP=$specs_details_row->CAP_PP;
                  $CAP_PP_PERC=$specs_details_row->CAP_PP_PERC;
                  $CAP_FOIL_COLOR=$specs_details_row->CAP_FOIL_COLOR;
                  $CAP_FOIL_WIDTH=$specs_details_row->CAP_FOIL_WIDTH;
                  $CAP_FOIL_DIST_FROM_BOT=$specs_details_row->CAP_FOIL_DIST_FROM_BOT;
                  $CAP_SHRINK_SLEEVE=$specs_details_row->CAP_SHRINK_SLEEVE;
                  $CAP_SHRINK_SLEEVE_NAME=$specs_details_row->CAP_SHRINK_SLEEVE_NAME;
                  }
                }

                  if(!empty($this->input->post('label_article_no'))){
                      $label_article=explode('//',$this->input->post('label_article_no'));
                    }else{
                      $label_article[0]='';
                    }

                    if(!empty($this->input->post('sleeve_dia'))){
                      $sleeve_dia=explode('//',$this->input->post('sleeve_dia'));
                    }else{
                      $sleeve_dia[0]='';
                    }

                    if(!empty($this->input->post('sl_mb_supplier_one'))){
                      $sl_mb_supplier_one=explode('//',$this->input->post('sl_mb_supplier_one'));
                    }else{
                      $sl_mb_supplier_one[1]='';
                    }


                    if(!empty($this->input->post('sl_mb_supplier_five'))){
                      $sl_mb_supplier_five=explode('//',$this->input->post('sl_mb_supplier_five'));
                    }else{
                      $sl_mb_supplier_five[1]='';
                    }

                    if(!empty($this->input->post('sh_mb_supplier'))){
                      $sh_mb_supplier=explode('//',$this->input->post('sh_mb_supplier'));
                    }else{
                      $sh_mb_supplier[1]='';
                    }

                    if(!empty($this->input->post('cap_mb_supplier'))){
                      $cap_mb_supplier=explode('//',$this->input->post('cap_mb_supplier'));
                    }else{
                      $cap_mb_supplier[1]='';
                    }

                    if(!empty($this->input->post('shoulder'))){
                      $shoulder=explode('//',$this->input->post('shoulder'));
                    }else{
                      $shoulder[0]='';
                    }

                    if(!empty($this->input->post('shoulder_orifice'))){
                      $shoulder_orifice=explode('//',$this->input->post('shoulder_orifice'));
                    }else{
                      $shoulder_orifice[0]='';
                    }

                    /*

                    if(!empty($this->input->post('cap_type'))){
                      $cap_type=explode('//',$this->input->post('cap_type'));
                    }else{
                      $cap_type[0]='';
                    }

                    if(!empty($this->input->post('cap_finish'))){
                      $cap_finish=explode('//',$this->input->post('cap_finish'));
                    }else{
                      $cap_finish[0]='';
                    }

                    if(!empty($this->input->post('cap_dia'))){
                      $cap_dia=explode('//',$this->input->post('cap_dia'));
                    }else{
                      $cap_dia[0]='';
                    }

                    if(!empty($this->input->post('cap_orifice'))){
                      $cap_orifice=explode('//',$this->input->post('cap_orifice'));
                    }else{
                      $cap_orifice[0]='';
                    }

                    */


                    $data['cap_diameter_master']=$this->common_model->select_one_active_record('cap_diameter_master',$this->session->userdata['logged_in']['company_id'],'cap_dia',$CAP_DIA);
            //echo $this->db->last_query();
            if($data['cap_diameter_master']==FALSE){
              $cap_dia_id="";
            }else{
             foreach($data['cap_diameter_master'] as $cap_diameter_master_row){
              $cap_dia_id=$cap_diameter_master_row->cap_dia_id;
             }
           }

            $data['cap_orifice_master']=$this->common_model->select_one_active_record('cap_orifice_master',$this->session->userdata['logged_in']['company_id'],'cap_orifice',$CAP_ORIFICE);
            if($data['cap_orifice_master']==FALSE){
              $cap_orifice_id="";
            }else{
              foreach($data['cap_orifice_master'] as $cap_orifice_master_row){
              $cap_orifice_id=$cap_orifice_master_row->cap_orifice_id;
               }
             }

             $data['cap_types_master']=$this->common_model->select_one_active_record('cap_types_master',$this->session->userdata['logged_in']['company_id'],'cap_type',$CAP_STYLE);
              if($data['cap_types_master']==FALSE){
                $cap_type_id="";
                }else{
                foreach($data['cap_types_master'] as $cap_types_master_row){
                  $cap_type_id=$cap_types_master_row->cap_type_id;
                 }
              }

             $data['cap_finish_master']=$this->common_model->select_one_active_record('cap_finish_master',$this->session->userdata['logged_in']['company_id'],'cap_finish',$CAP_MOLD_FINISH);
             if($data['cap_finish_master']==FALSE){
              $cap_finish_id="";
              }else{
              foreach($data['cap_finish_master'] as $cap_finish_master_row){
                $cap_finish_id=$cap_finish_master_row->cap_finish_id;
              }
              }



             
             $combination_data=array('sleeve_id'=>$sleeve_dia[1],
              'shld_type_id'=>$shoulder[1],
              'shld_orifice_id'=>$shoulder_orifice[1],
              'cap_dia_id'=>$cap_dia_id,
              'cap_orifice_id'=>$cap_orifice_id,
              'cap_type_id'=>$cap_type_id,
              'cap_finish_id'=>$cap_finish_id);

             $this->load->model('shoulder_orifice_dependancy_model');
             $this->shoulder_orifice_dependancy_model->select_one_active_combination_record('shoulder_orifice_dependancy',$this->session->userdata['logged_in']['company_id'],$combination_data);
             //echo $this->db->last_query();
             if($this->shoulder_orifice_dependancy_model->select_one_active_combination_record('shoulder_orifice_dependancy',$this->session->userdata['logged_in']['company_id'],$combination_data)>0){

                    $artwork_no='';
                    $artwork_version_no='';
                    if(!empty($this->input->post('artwork_final_version_no'))){
                      $data['artwork_final_version_no']=$this->artwork_model->select_artwork_final_version('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'article_no',$article_no_arr[1],'final_approval_flag','1','archive<>','1','ad_date','desc','ad_id','desc','version_no','desc');
                      if($data['artwork_final_version_no']==FALSE){
                        $artwork_no='';
                        $artwork_version_no='';
                      }else{
                        foreach ($data['artwork_final_version_no'] as $artwork_final_version_no_row){
                           $artwork_no=$artwork_final_version_no_row->ad_id;
                           $artwork_version_no=$artwork_final_version_no_row->version_no;
                        }
                      }
                    }
                    
                     

                    $data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$customer_arr[1]);
                    foreach ($data['customer'] as $customer_row) {
                      $property=$customer_row->property_id;
                    }

                    $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                    'property_id'=>$property,
                    'adr_company_id'=>$customer_arr[1],
                    'article_no'=>$article_no_arr[1],
                    'ad_id'=>$artwork_no,
                    'version_no'=>$artwork_version_no);

                  $result=$this->specification_model->update_one_active_record('specification_sheet',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$sleeve_dia[0]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_1',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('sleeve_length').' MM');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_2',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('gauge_one').' MIC');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_4',$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$this->input->post('print_type'));

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_7',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_masterbatch_one'),'mat_info'=>$this->input->post('sl_mb_per_one').'%','supplier_no'=>$sl_mb_supplier_one[1]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_5_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_ldpe_one'),'mat_info'=>$this->input->post('sl_ldpe_per_one').'%');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_6_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_lldpe_one'),'mat_info'=>$this->input->post('sl_lldpe_per_one').'%');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_6_1',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_hdpe_one'),'mat_info'=>$this->input->post('sl_hdpe_per_one').'%');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','1_6_2',$this->session->userdata['logged_in']['company_id']);

                  //Layer 2


                  $data=array('relating_master_value'=>$sleeve_dia[0]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_1',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('sleeve_length').' MM');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_2',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('gauge_two').' MIC');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_4',$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$this->input->post('print_type'));

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_7',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_admer_two'),'mat_info'=>$this->input->post('sl_admer_per_two').'%');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_6_4',$this->session->userdata['logged_in']['company_id']);


                   //Layer 3


                  $data=array('relating_master_value'=>$sleeve_dia[0]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_1',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('sleeve_length').' MM');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_2',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('gauge_three').' MIC');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_4',$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$this->input->post('print_type'));

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_7',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_evoh_three'),'mat_info'=>$this->input->post('sl_evoh_per_three').'%');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_6_3',$this->session->userdata['logged_in']['company_id']);


                  //Layer 4


                  $data=array('relating_master_value'=>$sleeve_dia[0]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','4_1',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('sleeve_length').' MM');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','4_2',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('gauge_four').' MIC');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','4_4',$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$this->input->post('print_type'));

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','4_7',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_admer_four'),'mat_info'=>$this->input->post('sl_admer_per_four').'%');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','4_6_4',$this->session->userdata['logged_in']['company_id']);


                  //Layer 5
                  $data=array('relating_master_value'=>$sleeve_dia[0]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','5_1',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('sleeve_length').' MM');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','5_2',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('gauge_five').' MIC');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','5_4',$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$this->input->post('print_type'));

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','5_7',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_masterbatch_five'),'mat_info'=>$this->input->post('sl_mb_per_five').'%','supplier_no'=>$sl_mb_supplier_five[1]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','5_5_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_ldpe_five'),'mat_info'=>$this->input->post('sl_ldpe_per_five').'%');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','5_6_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_lldpe_five'),'mat_info'=>$this->input->post('sl_lldpe_per_five').'%');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','5_6_1',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sl_hdpe_five'),'mat_info'=>$this->input->post('sl_hdpe_per_five').'%');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','5_6_2',$this->session->userdata['logged_in']['company_id']);
                  
                  //Shoulder

                  $data=array('relating_master_value'=>$shoulder[0]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','6_2',$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$shoulder[0]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','6_3',$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$shoulder_orifice[0]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','6_4',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('shoulder_foil_tag'));

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','6_8',$this->session->userdata['logged_in']['company_id']);


                  $data=array('mat_article_no'=>$this->input->post('sh_masterbatch'),'mat_info'=>$this->input->post('sh_mb_per').'%','supplier_no'=>$sh_mb_supplier[1]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','6_6_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sh_hdpe_one'),'mat_info'=>$this->input->post('sh_hdpe_one_per').'%');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','6_7_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sh_hdpe_two'),'mat_info'=>$this->input->post('sh_hdpe_two_per').'%');

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','6_7_1',$this->session->userdata['logged_in']['company_id']);

                  //Cap

                  $data=array('parameter_value'=>$cap_article_no_arr[2]."//".$cap_article_no_arr[3]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','7_1',$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$CAP_STYLE);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','7_2',$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$CAP_MOLD_FINISH);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','7_3',$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$CAP_DIA);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','7_4',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$CAP_SHRINK_SLEEVE_NAME,'mat_article_no'=>$CAP_SHRINK_SLEEVE);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','7_5',$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$CAP_ORIFICE);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','7_6',$this->session->userdata['logged_in']['company_id']);


                  $data=array('mat_article_no'=>$CAP_MASTER_BATCH,'mat_info'=>$CAP_MB_PERC.'%','supplier_no'=>$CAP_MB_SUPPLIER);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','7_7_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$CAP_PP,'mat_info'=>$CAP_PP_PERC);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','7_8_1',$this->session->userdata['logged_in']['company_id']);


                  $data=array('mat_article_no'=>$CAP_FOIL_COLOR);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','7_9',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$CAP_FOIL_WIDTH);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','7_10',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$CAP_FOIL_DIST_FROM_BOT);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','7_11',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$label_article[1]);

                  $result=$this->specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','7_12',$this->session->userdata['logged_in']['company_id']);

                  if(!empty($this->input->post('approval_authority'))){

                    $data=array('pending_flag'=>'1');
                    $result=$this->specification_model->update_one_active_record('specification_sheet',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),$this->session->userdata['logged_in']['company_id']);

                    $data['followup']=$this->common_model->select_one_active_record_nonlanguage_without_archive('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$this->input->post('record_no'));
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
                        'form_id'=>'985',
                        'transaction_no'=>$transaction_no,
                        'status'=>$status,
                        'followup_date'=>date('Y-m-d'),
                        'contact_person_id'=>$this->session->userdata['logged_in']['user_id'],
                        'record_no'=>$this->input->post('record_no'),
                        );

                      $result=$this->common_model->save('followup',$data);
                  }

                  $data['note']='Update Transaction Completed';
                  header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                  }else{
                    $data['error']='Wrong combination';
                  }
                  $data['specification']=$this->specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->input->post('spec_id'),'specification_sheet.spec_version_no',$this->input->post('spec_version_no'),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);
                  $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

                  $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
                  $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
                  $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
                  $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                  $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);
                  $data['admer']=$this->article_model->spec_active_record_search('article','15',$this->session->userdata['logged_in']['company_id']);
                  $data['evoh']=$this->article_model->spec_active_record_search('article','16',$this->session->userdata['logged_in']['company_id']);

                  $dataa=array('article_main_group.main_group_id'=>'5');
                  $data['label']=$this->article_model->active_record_search('article',$dataa,$this->session->userdata['logged_in']['company_id']);
                  $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);

                  $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

                  

                  $data['page_name']='Sales';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                  $this->load->view(ucwords($this->router->fetch_class()).'/five-modify-form-with-cap',$data);
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






  function copy_single(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->copy==1){

            $data['specification']=$this->specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->uri->segment(3),'specification_sheet.spec_version_no',$this->uri->segment(4),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);

            //echo $this->db->last_query();

            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);

                  $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
                  $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
                  $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
                  $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                  $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);

                  $dataa=array('article_main_group.main_group_id'=>'5');
                  $data['label']=$this->article_model->active_record_search('article',$dataa,$this->session->userdata['logged_in']['company_id']);
                  $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);

                  $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/single-copy-form',$data);
              $this->load->view('Home/footer');
          }else{
              $data['note']='No Copy rights Thanks';
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
      $data['note']='No Copy rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  
  }


  function copy_two(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->copy==1){

                  $data['specification']=$this->specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->uri->segment(3),'specification_sheet.spec_version_no',$this->uri->segment(4),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);
                  $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

                  $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
                  $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
                  $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
                  $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                  $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);

                  $dataa=array('article_main_group.main_group_id'=>'5');
                  $data['label']=$this->article_model->active_record_search('article',$dataa,$this->session->userdata['logged_in']['company_id']);
                  $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);

                  $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/two-copy-form',$data);
              $this->load->view('Home/footer');
          }else{
              $data['note']='No Copy rights Thanks';
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
      $data['note']='No Copy rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  
  }





  public function sleeve_per_check($str){
    $sl_ldpe_per=$this->input->post('sl_ldpe_per');
    $sl_lldpe_per=$this->input->post('sl_lldpe_per');
    $sl_hdpe_per=$this->input->post('sl_hdpe_per');
    $total_per=$sl_ldpe_per+$sl_lldpe_per+$sl_hdpe_per;

    if($total_per!=100){
      $this->form_validation->set_message('sleeve_per_check', 'The {field} field is incorrect');
      return FALSE;
    }else{
      return TRUE;
    }
  }

  public function shoulder_per_check($str){
    $sh_hdpe_one_per=$this->input->post('sh_hdpe_one_per');
    $sh_hdpe_two_per=$this->input->post('sh_hdpe_two_per');
    $total_per=$sh_hdpe_one_per+$sh_hdpe_two_per;

    if($total_per!=100){
      $this->form_validation->set_message('shoulder_per_check', 'The {field} field is incorrect');
      return FALSE;
    }else{
      return TRUE;
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

 

 
  public function supplier_check($str){
    $supplier_code=explode('//',$str);
    if(!empty($supplier_code[1])){
    $data['supplier']=$this->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'name1',$supplier_code[0]);
    foreach ($data['supplier'] as $supplier_row) {

      if ($supplier_row->adr_company_id == $supplier_code[1]){
        return TRUE;
      }else{
        $this->form_validation->set_message('supplier_check', 'The {field} field is incorrect');
        return FALSE;
        }
      } 
    }
  }

  public function article_check($str){
    if(!empty($str)){
    $item_code=explode('//',$str);
    if(!empty($item_code[1])){
    $data['item']=$this->common_model->select_one_active_record_nonlanguage_without_archive('article_name_info',$this->session->userdata['logged_in']['company_id'],'lang_article_description',$item_code[0]);
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



  function archive_records(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->delete==1){
            $table='specification_sheet';
            include('pagination-archive-tube-with-cap.php');
            $data['specification']=$this->tube_with_cap_specification_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
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


  

  function delete(){

      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

                  $data=array('archive'=>'1');

                  $result=$this->specification_model->update_one_active_record('specification_sheet',$data,'spec_id',$this->uri->segment(3),'spec_version_no',$this->uri->segment(4),$this->session->userdata['logged_in']['company_id']);

                  $data['specification']=$this->specification_model->select_one_inactive_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->uri->segment(3),'specification_sheet.spec_version_no',$this->input->post('spec_version_no'));
                
                  $data['page_name']='Sales';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
                  

                  $data['note']='Archive Transaction completed';
                  header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
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
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->dearchive==1){
              $data=array('archive'=>'2');

              $result=$this->specification_model->update_one_active_record('specification_sheet',$data,'spec_id',$this->uri->segment(3),'spec_version_no',$this->uri->segment(4),$this->session->userdata['logged_in']['company_id']);

              $data['specification']=$this->specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->uri->segment(3),'specification_sheet.spec_version_no',$this->uri->segment(4));

              $data['page_name']='Sales';

              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
                  

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


  


  function search(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);

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

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
              
              $this->form_validation->set_rules('from_date','From Date' ,'trim|xss_clean|exact_length[10]');
              $this->form_validation->set_rules('to_date','To Date' ,'trim|xss_clean|exact_length[10]');
              $this->form_validation->set_rules('customer','Customer' ,'trim|xss_clean|callback_customer_check');
              $this->form_validation->set_rules('article_no','Article No' ,'trim|xss_clean|callback_article_check');
              $this->form_validation->set_rules('spec_no','Specification No' ,'trim|xss_clean|max_length[8]');
              $this->form_validation->set_rules('spec_version_no','Spec Version No' ,'trim|xss_clean|numeric|max_length[3]');
              $this->form_validation->set_rules('artwork_no','Artwork No' ,'trim|xss_clean|max_length[6]');
              $this->form_validation->set_rules('artwork_version_no','Artwork Version No' ,'trim|xss_clean|numeric|max_length[3]');
            

            if($this->form_validation->run()==FALSE){

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                $this->load->view('Home/footer');
            }else{

                if(!empty($this->input->post('customer'))){
                  $customer_arr=explode('//',$this->input->post('customer'));
                }else{
                  $customer_arr[1]='';
                }

                if(!empty($this->input->post('article_no'))){
                  $article_no_arr=explode('//',$this->input->post('article_no'));
                }else{
                  $article_no_arr[1]='';
                }


                $data=array(
                    'specification_sheet.spec_id'=>$this->input->post('spec_no'),
                    'specification_sheet.spec_version_no'=>$this->input->post('spec_version_no'),
                    'specification_sheet.ad_id'=>$this->input->post('artwork_no'),
                    'specification_sheet.version_no'=>$this->input->post('artwork_version_no'),
                    'specification_sheet.adr_company_id'=>$customer_arr[1],
                    'specification_sheet.article_no'=>$article_no_arr[1],
                    'specification_sheet.final_approval_flag'=>$this->input->post('final_approval_flag'));

                $data=array_filter($data);

                $data['specification']=$this->tube_with_cap_specification_model->active_record_search('specification_sheet',$data,$this->common_model->change_date_format($this->input->post('from_date'),$this->session->userdata['logged_in']['company_id']),$this->common_model->change_date_format($this->input->post('to_date'),$this->session->userdata['logged_in']['company_id']),$this->session->userdata['logged_in']['company_id']);

                //echo $this->db->last_query();
                 
                if($data['specification']!=FALSE){
                    $data['page_name']='Sales';
                    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                    $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                    $this->load->view('Home/header');
                    $this->load->view('Home/nav',$data);
                    $this->load->view('Home/subnav');
                    $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                    $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
                    $this->load->view('Home/footer');
                }else{
                      $data['page_name']='Sales';
                      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                      $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                      $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                      $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
                      

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


    

  public function main_group_article($main_group_id){
    $data['autogeneration']=$this->common_model->article_no_generation('article_number_circles',$this->session->userdata['logged_in']['company_id'],'main_group_id',$main_group_id,'sub_group_id','','sub_sub_grp_id','');
    //echo $this->db->last_query();
    if($data['autogeneration']==FALSE){
      $data['default']=$this->common_model->article_no_generation('article_number_circles',$this->session->userdata['logged_in']['company_id'],'main_group_id','','sub_group_id','','sub_sub_grp_id','');
      foreach ($data['default'] as $default_row) {
       
        $count=str_pad($default_row->curr_val,$default_row->number_of_digits,0,STR_PAD_LEFT);

        $data['main_group']=$this->common_model->select_one_active_record('article_main_group',$this->session->userdata['logged_in']['company_id'],'main_group_id',$main_group_id);
        foreach ($data['main_group'] as $main_group_row) {
          $main_group_row->lang_short_desc;
          return $main_group_row->lang_short_desc."-000-000-".$count;
        }

        
        }
      
    }else{
      foreach($data['autogeneration'] as $row){

        if($row->main_grp_value=='MAIN'){
          $data['main_group']=$this->common_model->select_one_active_record('article_main_group',$this->session->userdata['logged_in']['company_id'],'main_group_id',$row->main_group_id);
          foreach ($data['main_group'] as $main_group_row) {
            $main_group_initial=$main_group_row->lang_short_desc.$row->seperator;
          }
        }else if($row->main_grp_value==''){
          $main_group_initial="";
        }else{
          $main_group_initial=$row->main_grp_value.$row->seperator;
        }

        if($row->sub_grp_value=='SUB'){
          $sub_group_initial="000".$row->seperator;
        }else if($row->sub_grp_value==''){
          $sub_group_initial="";
        }else{
          $sub_group_initial=$row->sub_grp_value.$row->seperator;
        }

        if($row->sub_sub_grp_value=='SECSUB'){
            $second_sub_group_initial="000".$row->seperator;
          }else if($row->sub_sub_grp_value==''){
          $second_sub_group_initial="";
        }else{
            $second_sub_group_initial=$row->sub_sub_grp_value.$row->seperator;
        }

        $count=$this->common_model->active_record_count_where('article',$this->session->userdata['logged_in']['company_id'],'main_group_id',$row->main_group_id,'article_group_id','999999999999999','sub_sub_grp_id','999999999999999');
        //echo $this->db->last_query();
        $count=$row->step_by+$count+$row->start_value;
        $count=str_pad($count,$row->number_of_digits,0,STR_PAD_LEFT);

        return $main_group_initial.$sub_group_initial.$second_sub_group_initial.$count;
      }
     
     }
     
  }


  public function sleeve_per_one_check($str){
    $sl_ldpe_per_one=$this->input->post('sl_ldpe_per_one');
    $sl_lldpe_per_one=$this->input->post('sl_lldpe_per_one');
    $sl_hdpe_per_one=$this->input->post('sl_hdpe_per_one');
    $total_per_one=$sl_ldpe_per_one+$sl_lldpe_per_one+$sl_hdpe_per_one;

    if($total_per_one!=100){
      $this->form_validation->set_message('sleeve_per_one_check', 'The {field} field is incorrect');
      return FALSE;
    }else{
      return TRUE;
    }
  }

  public function sleeve_per_two_check($str){
    $sl_ldpe_per_two=$this->input->post('sl_ldpe_per_two');
    $sl_lldpe_per_two=$this->input->post('sl_lldpe_per_two');
    $sl_hdpe_per_two=$this->input->post('sl_hdpe_per_two');
    $total_per_two=$sl_ldpe_per_two+$sl_lldpe_per_two+$sl_hdpe_per_two;

    if($total_per_two!=100){
      $this->form_validation->set_message('sleeve_per_two_check', 'The {field} field is incorrect');
      return FALSE;
    }else{
      return TRUE;
    }
  }

  public function sleeve_per_three_check($str){
    $sl_ldpe_per_three=$this->input->post('sl_ldpe_per_three');
    $sl_lldpe_per_three=$this->input->post('sl_lldpe_per_three');
    $sl_hdpe_per_three=$this->input->post('sl_hdpe_per_three');
    $total_per_three=$sl_ldpe_per_three+$sl_lldpe_per_three+$sl_hdpe_per_three;

    if($total_per_three!=100){
      $this->form_validation->set_message('sleeve_per_three_check', 'The {field} field is incorrect');
      return FALSE;
    }else{
      return TRUE;
    }
  }


  public function sleeve_per_five_check($str){
    $sl_ldpe_per_five=$this->input->post('sl_ldpe_per_five');
    $sl_lldpe_per_five=$this->input->post('sl_lldpe_per_five');
    $sl_hdpe_per_five=$this->input->post('sl_hdpe_per_five');
    $total_per_five=$sl_ldpe_per_five+$sl_lldpe_per_five+$sl_hdpe_per_five;

    if($total_per_five!=100){
      $this->form_validation->set_message('sleeve_per_five_check', 'The {field} field is incorrect');
      return FALSE;
    }else{
      return TRUE;
    }
  }
  

}