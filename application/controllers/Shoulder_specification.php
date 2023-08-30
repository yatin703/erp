<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shoulder_specification extends CI_Controller {

  function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('shoulder_specification_model');
      $this->load->model('tube_specification_model');
      $this->load->model('article_model');
      $this->load->model('customer_model');
      $this->load->model('supplier_model');
      $this->load->model('artwork_model');
      $this->load->model('sub_group_model');
      $this->load->model('second_sub_group_model');
      $this->load->model('sales_order_book_model');
      $this->load->model('fiscal_model');
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
            include('pagination-tube.php');
            $data['specification']=$this->shoulder_specification_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
           
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
            $data['specification']=$this->tube_specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->uri->segment(3),'specification_sheet.spec_version_no',$this->uri->segment(4));

            $spec_lang=array();
            $spec_lang['spec_id']=$this->uri->segment(3);
            $spec_lang['spec_version_no']=$this->uri->segment(4);

            $data['specification_sheet_lang']=$this->common_model->select_active_records_where('specification_sheet_lang',$this->session->userdata['logged_in']['company_id'],$spec_lang);

            //echo $this->db->last_query();
           
           $data['specification_sleeve_details']=$this->tube_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$this->uri->segment(3),'specification_sheet_details.spec_version_no',$this->uri->segment(4),'item_group_id','3','srd_id','asc');

            $data['specification_shoulder_details']=$this->tube_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$this->uri->segment(3),'specification_sheet_details.spec_version_no',$this->uri->segment(4),'item_group_id','4','srd_id','asc');

            $data['specification_cap_details']=$this->tube_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$this->uri->segment(3),'specification_sheet_details.spec_version_no',$this->uri->segment(4),'item_group_id','5','srd_id','asc');

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

  function view_shoulder(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $data['specification']=$this->shoulder_specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->uri->segment(3),'specification_sheet.spec_version_no',$this->uri->segment(4));

            $spec_lang=array();
            $spec_lang['spec_id']=$this->uri->segment(3);
            $spec_lang['spec_version_no']=$this->uri->segment(4);

            $data['specification_sheet_lang']=$this->common_model->select_active_records_where('specification_sheet_lang',$this->session->userdata['logged_in']['company_id'],$spec_lang);

            $data['specification_shoulder_details']=$this->shoulder_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$this->uri->segment(3),'specification_sheet_details.spec_version_no',$this->uri->segment(4),'item_group_id','4','srd_id','asc');

            $data['followup']=$this->common_model->select_followup_records('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$this->uri->segment(3).'@@@'.$this->uri->segment(4));

            $data['company']=$this->common_model->select_one_active_record('company_master',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);

            $data['company_details']=$this->common_model->select_one_active_record('company_system_parameters',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);

            $this->load->view('Print/header',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/view-shoulder',$data);
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


  function create(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);

            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

            $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);

            $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
           
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);

            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);

            $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);

            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

            $data['page_name']='Sales';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
            $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/create-shoulder-form',$data);
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


function save_shoulder(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){
            $this->form_validation->set_rules('main_group','Main Group' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('article_no','Article No' ,'required|trim|xss_clean|max_length[20]');
            //echo $this->input->post('sh_hdpe_two');
            /*
            if($this->input->post('specific')==1){
              $this->form_validation->set_rules('customer','Customer' ,'required|trim|xss_clean|callback_customer_check');
            }
            */
            
            $this->form_validation->set_rules('sleeve_dia','DIAMETER' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('shoulder','Shoulder Type' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('shoulder_orifice','Shoulder Orifice' ,'trim|xss_clean');

            $this->form_validation->set_rules('sh_masterbatch','Shoulder Masterbatch' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sh_mb_per','Shoulder Masterbatch %' ,'required|trim|xss_clean|numeric|max_length[3]');
            
            if($this->input->post('sh_masterbatch')=='RM-MB-TRA-0007'){
              $this->form_validation->set_rules('sh_mb_per','Shoulder Masterbatch %' ,'required|trim|xss_clean|numeric|max_length[1]|less_than[1]');
            }
            
            
            //$this->form_validation->set_rules('sh_hdpe_one_per','Shoulder HDPE One %' ,'trim|xss_clean|is_natural|max_length[3]|callback_shoulder_per_check');

            //$this->form_validation->set_rules('sh_hdpe_two_per','Shoulder HDPE Two %' ,'trim|xss_clean|is_natural|max_length[3]|in_list[70]|callback_shoulder_per_check');

            //$this->form_validation->set_rules('sh_hdpe_three_per','Shoulder HDPE Three %' ,'trim|xss_clean|is_natural|max_length[3]|in_list[70]|callback_shoulder_per_check');

            $this->form_validation->set_rules('sh_hdpe_one_per','Shoulder HDPE One %' ,'trim|xss_clean|is_natural|max_length[3]|callback_shoulder_per_check|required');
           
            $this->form_validation->set_rules('sh_hdpe_two_per','Shoulder HDPE Two %' ,'trim|xss_clean|is_natural|max_length[3]|callback_shoulder_per_check');

             $this->form_validation->set_rules('sh_hdpe_three_per','Shoulder HDPE Three %' ,'trim|xss_clean|is_natural|max_length[3]|callback_shoulder_per_check');

            if(!empty($this->input->post('sh_hdpe_one_per'))){
               $this->form_validation->set_rules('sh_hdpe_one','Shoulder Hdpe One' ,'trim|xss_clean|required');
            }
            
            if(!empty($this->input->post('sh_hdpe_two_per'))){
               $this->form_validation->set_rules('sh_hdpe_two','Shoulder Hdpe Two' ,'trim|xss_clean|required');
            }

            if(!empty($this->input->post('sh_hdpe_three_per'))){
               $this->form_validation->set_rules('sh_hdpe_three','Shoulder Hdpe Three' ,'trim|xss_clean|required');
            }

            
               
            

            if($this->form_validation->run()==FALSE){
              
            $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);

            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

            $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
            
            $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
           
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);

            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);

            $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);

            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');


              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-shoulder-form',$data);
              $this->load->view('Home/footer');
            }else{

              $sh_hdpe_one="";
              $sh_hdpe_two="";
              $sh_hdpe_three="";

              /*
              if(!empty($this->input->post('customer'))){
                $customer_arr=explode('//',$this->input->post('customer'));
              }else{
                $customer_arr[1]="";
              }*/

              if(!empty($this->input->post('sleeve_dia'))){
                $sleeve_dia=explode('//',$this->input->post('sleeve_dia'));
              }else{
                $sleeve_dia[0]='';
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


              $data['sleeve_diameter_master']=$this->common_model->select_one_active_record('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id'],'sleeve_diameter',$sleeve_dia[0]);

                if($data['sleeve_diameter_master']==FALSE){
                  $sleeve_id="";
                }else{
                 foreach($data['sleeve_diameter_master'] as $sleeve_diameter_master_row){
                  $sleeve_id=$sleeve_diameter_master_row->sleeve_id;
                 }
               }

            $data['shoulder_types_master']=$this->common_model->select_one_active_record('shoulder_types_master',$this->session->userdata['logged_in']['company_id'],'shoulder_type',$shoulder[0]);
            if($data['shoulder_types_master']==FALSE){
              $shld_type_id="";
            }else{
              foreach($data['shoulder_types_master'] as $shoulder_types_master_row){
              $shld_type_id=$shoulder_types_master_row->shld_type_id;
               }
             }

             $data['shoulder_orifice_master']=$this->common_model->select_one_active_record('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id'],'shoulder_orifice',$shoulder_orifice[0]);
              if($data['shoulder_orifice_master']==FALSE){
                $orifice_id="";
                }else{
                foreach($data['shoulder_orifice_master'] as $shoulder_orifice_master_row){
                  $orifice_id=$shoulder_orifice_master_row->orifice_id;
                 }
              }

              $combination_data=array(
              'sleeve_id'=>$sleeve_id,
              'shld_type_id'=>$shld_type_id,
              'shld_orifice_id'=>$orifice_id);

             $this->load->model('shoulder_orifice_dependancy_model');
             $this->shoulder_orifice_dependancy_model->select_one_active_combination_record('shoulder_orifice_dependancy',$this->session->userdata['logged_in']['company_id'],$combination_data);
             //$this->db->last_query();
             if($this->shoulder_orifice_dependancy_model->select_one_active_combination_record('shoulder_orifice_dependancy',$this->session->userdata['logged_in']['company_id'],$combination_data)>0){

              if(!empty($this->input->post('sh_mb_supplier'))){
                $sh_mb_supplier=explode('//',$this->input->post('sh_mb_supplier'));
              }else{
                $sh_mb_supplier[1]='';
              }

              $data['sh_masterbatch']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sh_masterbatch'));

              foreach($data['sh_masterbatch'] as $sh_masterbatch_row){
                $sh_masterbatch=$sh_masterbatch_row->article_name;
              }

              $data['sh_hdpe_one']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sh_hdpe_one'));
              foreach($data['sh_hdpe_one'] as $sh_hdpe_one_row){
                $sh_hdpe_one=$sh_hdpe_one_row->article_name;
              }

              $data['sh_hdpe_two']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sh_hdpe_two'));
              foreach($data['sh_hdpe_two'] as $sh_hdpe_two_row){
                $sh_hdpe_two=$sh_hdpe_two_row->article_name;
              }

              $data['sh_hdpe_three']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sh_hdpe_three'));
              foreach($data['sh_hdpe_three'] as $sh_hdpe_three_row){
                $sh_hdpe_three=$sh_hdpe_three_row->article_name;
              }

              $data['shoulder_foil_tag']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('shoulder_foil_tag'));
              if($data['shoulder_foil_tag']==FALSE){
                $shoulder_foil_tag="";
              }else{
                foreach($data['shoulder_foil_tag'] as $shoulder_foil_tag_row){
                  $shoulder_foil_tag=$shoulder_foil_tag_row->article_name;
                }
              }
              
              

              $article_description=$sleeve_dia[0]." ".$shoulder[0]." ".$shoulder_orifice[0]." ".$sh_masterbatch." ".$this->input->post('sh_mb_per')."% ".($sh_hdpe_one<>'' ? $sh_hdpe_one : '')." ".($this->input->post('sh_hdpe_one_per')!='' ? $this->input->post('sh_hdpe_one_per').'%' : '')." ".($sh_hdpe_two<>'' ? $sh_hdpe_two : '')." ".($this->input->post('sh_hdpe_two_per')!='' ? $this->input->post('sh_hdpe_two_per').'%' : '')." ".($sh_hdpe_three<>'' ? $sh_hdpe_three : '')." ".($this->input->post('sh_hdpe_three_per')!='' ? $this->input->post('sh_hdpe_three_per').'%' : '')." ".$shoulder_foil_tag;
              
              //print_r($article_description);die();

              $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article_name_info.lang_article_description',$article_description);

                      if($data['article']==FALSE){

                        $article_no=$this->main_group_article($this->input->post('main_group'));

                        $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                              'main_group_id'=>$this->input->post('main_group'),
                              'article_group_id'=>'999999999999999',
                              'sub_sub_grp_id'=>'999999999999999',
                              'article_no'=>$article_no,
                              'uom'=>'UOM001',
                              'sales_purchase_flag'=>'2',
                              'spec_item_flag'=>'1',
                              'archive'=>'0',
                              'article_date'=>date('Y-m-d'), 
                              'article_modified_date'=>date('Y-m-d')
                            );

                        $result=$this->common_model->save('article',$data);

                        $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                              'language_id'=>$this->session->userdata['logged_in']['language_id'],
                              'article_no'=>$article_no,
                              'lang_article_description'=>$article_description,
                              'lang_sub_description'=>'',
                              'main_group_id'=>$this->input->post('main_group'),
                              'article_group_id'=>'999999999999999',
                              'sub_sub_grp_id'=>'999999999999999');

                        $result=$this->common_model->save('article_name_info',$data);

                        $data['auto']=$this->common_model->select_one_active_record_nonlanguage_without_archive('autogeneration_format_master',$this->session->userdata['logged_in']['company_id'],'form_id','1240');
                        $no="";
                        foreach ($data['auto'] as $auto_row) {

                          $data['account_periods']=$this->common_model->select_one_active_record_nonlanguage_without_archive('account_periods_master',$this->session->userdata['logged_in']['company_id'],'finyear_close_opt','0');
                          foreach($data['account_periods'] as $account_periods_row){
                            $start=date('y', strtotime($account_periods_row->fin_year_start));
                            $end=date('y', strtotime($account_periods_row->fin_year_end));
                          }
                          $no=str_pad($auto_row->curr_val,4,"0",STR_PAD_LEFT);
                          $spec_no=$auto_row->textcode.$no;
                          $next_spec_no=$auto_row->curr_val+1;
                        }
                        $data=array('curr_val'=>$next_spec_no);
                        $this->common_model->update_one_active_record('autogeneration_format_master',$data,'form_id','1240',$this->session->userdata['logged_in']['company_id']);
                        $spec_version_no='1';

                        $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                              'spec_id'=>$spec_no,
                              'spec_created_date'=>date('Y-m-d'),
                              'spec_version_no'=>$spec_version_no,
                              'adr_company_id'=>'',
                              'article_no'=>$article_no,
                              'pending_flag'=>'0',
                              'final_approval_flag'=>'0',
                              'user_id'=>$this->session->userdata['logged_in']['user_id'],
                              'dyn_qty_present'=>'SHOULDER|1',
                              );

                        $result=$this->common_model->save('specification_sheet',$data);


                        

                $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'170',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'DIAMETER',
                'item_group_material'=>'',
                'material'=>'0',
                'parameter_value'=>'',
                'relating_master_value'=>$sleeve_dia[0],
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
                'mat_info'=>$this->input->post('sh_mb_per'),
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sh_masterbatch'),
                'srd_id'=>'2_6_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
              $result=$this->common_model->save('specification_sheet_details',$data);
              

          if($this->input->post('sh_hdpe_one')!='' && $this->input->post('sh_hdpe_one_per')!=''){
                $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'176',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'HDPE ONE',
                'parameter_value'=>'',
                'material'=>'1',
                'item_group_material'=>'6',
                'supplier_no'=>'',
                'relating_master_value'=>'',
                'mat_info'=>$this->input->post('sh_hdpe_one_per'),
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sh_hdpe_one'),
                'srd_id'=>'2_7_0',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
            $result=$this->common_model->save('specification_sheet_details',$data);
          }
                     

          if($this->input->post('sh_hdpe_two')!='' && $this->input->post('sh_hdpe_two_per')!=''){
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'176',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'HDPE TWO',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sh_hdpe_two_per'),
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sh_hdpe_two'),
                'srd_id'=>'2_7_1',
                'item_group_material_flag'=>'1',
                'dyn_qty_no'=>'1',
                'sub_company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_version_no'=>$spec_version_no,
                'layer_no'=>'1');
            $result=$this->common_model->save('specification_sheet_details',$data);
          }  

          if($this->input->post('sh_hdpe_three')!='' && $this->input->post('sh_hdpe_three_per')!=''){
              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                'spec_id'=>$spec_no,
                'disp_id'=>'176',
                'item_group_id'=>'4',
                'item_group_flag'=>'1',
                'parameter_name'=>'HDPE THREE',
                'material'=>'1',
                'item_group_material'=>'6',
                'parameter_value'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>$this->input->post('sh_hdpe_three_per'),
                'property_id'=>'',
                'mat_article_no'=>$this->input->post('sh_hdpe_three'),
                'srd_id'=>'2_7_2',
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
                'srd_id'=>'2_8',
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
              //header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

              if(!empty($this->input->post('approval_authority'))){

                    $data=array('pending_flag'=>'1');

                    $result=$this->shoulder_specification_model->update_one_active_record('specification_sheet',$data,'spec_id',$spec_no,'spec_version_no',$spec_version_no,$this->session->userdata['logged_in']['company_id']);

                    $data['followup']=$this->common_model->select_one_active_record_nonlanguage_without_archive('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$spec_no.'@@@'.$spec_version_no);
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
                        'record_no'=>$spec_no.'@@@'.$spec_version_no);

                      $result=$this->common_model->save('followup',$data);

                      $data['note']='Create Transaction Completed';
                      $data['error']='Sent for Approval';

                      header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                  }

                }else{
                $data['error']='Same Shoulder alerdy Exist';
              }

               }else{
              $data['error']='Wrong combination';
             }

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
              
            $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);

            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

            $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
            
            $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
           
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);

            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);

            $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);

            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                  $this->load->view(ucwords($this->router->fetch_class()).'/create-shoulder-form',$data);
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
            include('pagination-archive-cap.php');
            $data['specification']=$this->shoulder_specification_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
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


  

  function modify_shoulder(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){

            $data['specification']=$this->tube_specification_model->select_one_active_unapproved_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->uri->segment(3),'specification_sheet.spec_version_no',$this->uri->segment(4),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);
            
              $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

              $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
              
              $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
             
              $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);

              $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);

              $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);

              $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/shoulder-modify-form',$data);
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


  function update_shoulder(){
      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){

            $this->form_validation->set_rules('spec_id','Spec No' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('spec_version_no','Spec Version No' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('article_no','Article No' ,'required|trim|xss_clean');

            /*
            if(!empty($this->input->post('customer'))){
              $this->form_validation->set_rules('customer','Customer' ,'required|trim|xss_clean|callback_customer_check');
            }*/

           // $this->form_validation->set_rules('main_group','Main Group' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('article_no','Article No' ,'required|trim|xss_clean|max_length[20]');
            /*
            if($this->input->post('specific')==1){
              $this->form_validation->set_rules('customer','Customer' ,'required|trim|xss_clean|callback_customer_check');
            }
            */
            
            $this->form_validation->set_rules('sleeve_dia','DIAMETER' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('shoulder','Shoulder Type' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('shoulder_orifice','Shoulder Orifice' ,'trim|xss_clean');

            $this->form_validation->set_rules('sh_masterbatch','Shoulder Masterbatch' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sh_mb_per','Shoulder Masterbatch %' ,'required|trim|xss_clean|numeric|max_length[3]');
            /*if($this->input->post('sh_masterbatch')!=='RM-MB-TRA-0007'){*/
              
           /* }*/
            

            if($this->input->post('sh_masterbatch')=='RM-MB-TRA-0007'){
              $this->form_validation->set_rules('sh_mb_per','Shoulder Masterbatch %' ,'required|trim|xss_clean|numeric|max_length[1]|less_than[1]');
            }
            

           $this->form_validation->set_rules('sh_hdpe_one_per','Shoulder HDPE %' ,'trim|xss_clean|is_natural|max_length[3]|callback_shoulder_per_check');
            $this->form_validation->set_rules('sh_hdpe_two_per','Shoulder HDPE %' ,'trim|xss_clean|is_natural|max_length[3]|callback_shoulder_per_check');
            $this->form_validation->set_rules('sh_hdpe_three_per','Shoulder HDPE %' ,'trim|xss_clean|is_natural|max_length[3]|callback_shoulder_per_check');

            if(!empty($this->input->post('sh_hdpe_one_per'))){
              $this->form_validation->set_rules('sh_hdpe_one','Shoulder Hdpe' ,'trim|xss_clean|required');
            }if(!empty($this->input->post('sh_hdpe_two_per'))){
              $this->form_validation->set_rules('sh_hdpe_two','Shoulder Hdpe' ,'trim|xss_clean|required');
            }if(!empty($this->input->post('sh_hdpe_three_per'))){
              $this->form_validation->set_rules('sh_hdpe_three','Shoulder Hdpe' ,'trim|xss_clean|required');
            }
            
              

              if($this->form_validation->run()==FALSE){

                $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);

                $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

                $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
            
                $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
           
                $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);

                $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);

                $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);

                $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

                $data['specification']=$this->tube_specification_model->select_one_active_unapproved_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->input->post('spec_id'),'specification_sheet.spec_version_no',$this->input->post('spec_version_no'),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/shoulder-modify-form',$data);
                $this->load->view('Home/footer');

              }else{

              if(!empty($this->input->post('sleeve_dia'))){
                $sleeve_dia=explode('//',$this->input->post('sleeve_dia'));
              }else{
                $sleeve_dia[0]='';
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

              if(!empty($this->input->post('sh_mb_supplier'))){
                $sh_mb_supplier=explode('//',$this->input->post('sh_mb_supplier'));
              }else{
                $sh_mb_supplier[1]='';
              }


              $data['sleeve_diameter_master']=$this->common_model->select_one_active_record('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id'],'sleeve_diameter',$sleeve_dia[0]);

                if($data['sleeve_diameter_master']==FALSE){
                  $sleeve_id="";
                }else{
                 foreach($data['sleeve_diameter_master'] as $sleeve_diameter_master_row){
                  $sleeve_id=$sleeve_diameter_master_row->sleeve_id;
                 }
               }

            $data['shoulder_types_master']=$this->common_model->select_one_active_record('shoulder_types_master',$this->session->userdata['logged_in']['company_id'],'shoulder_type',$shoulder[0]);
            if($data['shoulder_types_master']==FALSE){
              $shld_type_id="";
            }else{
              foreach($data['shoulder_types_master'] as $shoulder_types_master_row){
              $shld_type_id=$shoulder_types_master_row->shld_type_id;
               }
             }

             $data['shoulder_orifice_master']=$this->common_model->select_one_active_record('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id'],'shoulder_orifice',$shoulder_orifice[0]);
              if($data['shoulder_orifice_master']==FALSE){
                $orifice_id="";
                }else{
                foreach($data['shoulder_orifice_master'] as $shoulder_orifice_master_row){
                  $orifice_id=$shoulder_orifice_master_row->orifice_id;
                 }
              }

              $combination_data=array(
              'sleeve_id'=>$sleeve_id,
              'shld_type_id'=>$shld_type_id,
              'shld_orifice_id'=>$orifice_id);

             $this->load->model('shoulder_orifice_dependancy_model');
             $this->shoulder_orifice_dependancy_model->select_one_active_combination_record('shoulder_orifice_dependancy',$this->session->userdata['logged_in']['company_id'],$combination_data);
             $this->db->last_query();
             if($this->shoulder_orifice_dependancy_model->select_one_active_combination_record('shoulder_orifice_dependancy',$this->session->userdata['logged_in']['company_id'],$combination_data)>0){

              if(!empty($this->input->post('sh_mb_supplier'))){
                $sh_mb_supplier=explode('//',$this->input->post('sh_mb_supplier'));
              }else{
                $sh_mb_supplier[1]='';
              }

              $data['sh_masterbatch']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sh_masterbatch'));

              foreach($data['sh_masterbatch'] as $sh_masterbatch_row){
                $sh_masterbatch=$sh_masterbatch_row->article_name;
              }

              $data['sh_hdpe_one']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sh_hdpe_one'));
              foreach($data['sh_hdpe_one'] as $sh_hdpe_one_row){
                $sh_hdpe_one=$sh_hdpe_one_row->article_name;
              }

              $sh_hdpe_two="";

              $data['sh_hdpe_two']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sh_hdpe_two'));
              foreach($data['sh_hdpe_two'] as $sh_hdpe_two_row){
                $sh_hdpe_two=$sh_hdpe_two_row->article_name;
              }


              $sh_hdpe_three="";

              $data['sh_hdpe_three']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sh_hdpe_three'));
              foreach($data['sh_hdpe_three'] as $sh_hdpe_three_row){
                $sh_hdpe_three=$sh_hdpe_three_row->article_name;
              }

              $data['shoulder_foil_tag']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('shoulder_foil_tag'));
              if($data['shoulder_foil_tag']==FALSE){
                $shoulder_foil_tag="";
              }else{
                foreach($data['shoulder_foil_tag'] as $shoulder_foil_tag_row){
                  $shoulder_foil_tag=$shoulder_foil_tag_row->article_name;
                }
              }
              

             

              $article_description=$sleeve_dia[0]." ".$shoulder[0]." ".$shoulder_orifice[0]." ".$sh_masterbatch." ".$this->input->post('sh_mb_per')."% ".$sh_hdpe_one." ".$this->input->post('sh_hdpe_one_per')."% ".$sh_hdpe_two." ".$this->input->post('sh_hdpe_two_per')."% ".$sh_hdpe_three." ".$this->input->post('sh_hdpe_three_per')."% ".$shoulder_foil_tag;

              $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article_name_info.lang_article_description',$article_description);

                if($data['article']==FALSE){


              $data=array('lang_article_description'=>$article_description);

              $result=$this->common_model->update_one_active_record('article_name_info',$data,'article_no',$this->input->post('article_no'),$this->session->userdata['logged_in']['company_id']);

              $data_article=array('article_modified_date'=>date('Y-m-d'));

              $result=$this->common_model->update_one_active_record('article',$data_article,'article_no',$this->input->post('article_no'),$this->session->userdata['logged_in']['company_id']);
                  

                  $data=array('relating_master_value'=>$sleeve_dia[0]);

                  $result=$this->shoulder_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_1',$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$shoulder[0]);

                  $result=$this->shoulder_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_2',$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$shoulder[0]);

                  $result=$this->shoulder_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_3',$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$shoulder_orifice[0]);

                  $result=$this->shoulder_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_4',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sh_masterbatch'),'mat_info'=>$this->input->post('sh_mb_per'),'supplier_no'=>$sh_mb_supplier[1]);

                  $result=$this->shoulder_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_6_0',$this->session->userdata['logged_in']['company_id']);


                  $data=array('mat_article_no'=>$this->input->post('sh_hdpe_one'),'mat_info'=>$this->input->post('sh_hdpe_one_per'));

                  $result=$this->shoulder_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_7_0',$this->session->userdata['logged_in']['company_id']);


                  $data=array('mat_article_no'=>$this->input->post('sh_hdpe_two'),'mat_info'=>$this->input->post('sh_hdpe_two_per'));

                  $result=$this->shoulder_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_7_1',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('sh_hdpe_three'),'mat_info'=>$this->input->post('sh_hdpe_three_per'));

                  $result=$this->shoulder_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_7_2',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('shoulder_foil_tag'));

                  $result=$this->shoulder_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','2_8',$this->session->userdata['logged_in']['company_id']);

                  $data['note']='Update Transaction Completed';

                  if(!empty($this->input->post('approval_authority'))){

                    $data=array('pending_flag'=>'1');

                    $result=$this->shoulder_specification_model->update_one_active_record('specification_sheet',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),$this->session->userdata['logged_in']['company_id']);

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

                      $data['error']='Sent for approval';
                      $data['note']='Update Transaction Completed';
                  }

                  
                  //header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                }else{
                  $data['error']='Same Shoulder Already Exist';

                  if(!empty($this->input->post('approval_authority'))){

                    $data=array('pending_flag'=>'1');

                    $result=$this->shoulder_specification_model->update_one_active_record('specification_sheet',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),$this->session->userdata['logged_in']['company_id']);

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

                      $data['note']='Sent for approval';
                      //header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                  }
                }

                }else{
                   $data['error']='Wrong combination';
                }

                  
                $data['specification']=$this->shoulder_specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->input->post('spec_id'),'specification_sheet.spec_version_no',$this->input->post('spec_version_no'),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);
                  
                $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);

                $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

                $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
            
                $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
           
                $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);

                $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);

                $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);

                $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

                  

                  $data['page_name']='Sales';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                  $this->load->view(ucwords($this->router->fetch_class()).'/shoulder-modify-form',$data);
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



    function dearchive_shoulder(){

      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

                  $data=array('archive'=>'2');

                  $result=$this->shoulder_specification_model->update_one_active_record('specification_sheet',$data,'spec_id',$this->uri->segment(3),'spec_version_no',$this->uri->segment(4),$this->session->userdata['logged_in']['company_id']);

                  $data['specification']=$this->shoulder_specification_model->select_one_inactive_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->uri->segment(3),'specification_sheet.spec_version_no',$this->uri->segment(4));
                
                  $data['page_name']='Sales';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
                  

                  $data['note']='Dearchive Transaction completed';
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
        $data['note']='No Dearchive rights Thanks';
        $data['page_name']='home';
        $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
        $this->load->view('Home/header');
        $this->load->view('Home/nav',$data);
        $this->load->view('Home/subnav');
        $this->load->view('Error/error-title',$data);
        $this->load->view('Home/footer');
      }
    }

     function delete_shoulder(){

      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

                  $data=array('archive'=>'1');

                  $result=$this->shoulder_specification_model->update_one_active_record('specification_sheet',$data,'spec_id',$this->uri->segment(3),'spec_version_no',$this->uri->segment(4),$this->session->userdata['logged_in']['company_id']);

                  $data['specification']=$this->shoulder_specification_model->select_one_inactive_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->uri->segment(3),'specification_sheet.spec_version_no',$this->uri->segment(4));
                
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
        $data['note']='No Dearchive rights Thanks';
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

            $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);           
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
            $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);
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
              $this->form_validation->set_rules('article_no','Article No' ,'trim|xss_clean|callback_article_check');
              $this->form_validation->set_rules('sleeve_dia','Dia' ,'trim|xss_clean');
              $this->form_validation->set_rules('shoulder','Shoulder' ,'trim|xss_clean');
              $this->form_validation->set_rules('shoulder_orifice','Shoulder Orifice' ,'trim|xss_clean');
              $this->form_validation->set_rules('shoulder_foil_tag','Top Sealed Foil' ,'trim|xss_clean');
              $this->form_validation->set_rules('sh_masterbatch','Masterbatch' ,'trim|xss_clean');
              $this->form_validation->set_rules('final_approval_flag','Approval Status' ,'trim|xss_clean');
              $this->form_validation->set_rules('user_id','Created By' ,'trim|xss_clean');
              
              if($this->input->post('sh_masterbatch')!=='RM-MB-TRA-0007//TRANSPARENT'){
                      $this->form_validation->set_rules('sh_mb_supplier','Masterbatch Supplier' ,'trim|xss_clean|callback_supplier_check');

                      $this->form_validation->set_rules('sh_mb_per','Masterbatch %' ,'trim|xss_clean|numeric|max_length[3]');
              }

              $this->form_validation->set_rules('sh_hdpe_one','HDPE' ,'trim|xss_clean');
              if(!empty($this->input->post('sh_hdpe_one_per'))){                
                $this->form_validation->set_rules('sh_hdpe_one_per','Shoulder HDPE %' ,'trim|xss_clean|is_natural|max_length[3]');
              }
              $this->form_validation->set_rules('sh_hdpe_two','HDPE' ,'trim|xss_clean');
              if(!empty($this->input->post('sh_hdpe_two_per'))){                
                $this->form_validation->set_rules('sh_hdpe_two_per','Shoulder HDPE %' ,'trim|xss_clean|is_natural|max_length[3]');
              }
              
              $arr_input=array_filter($this->input->post(),'strlen');
              if(empty($arr_input)){
                $this->form_validation->set_rules('from_date','From Date' ,'required|trim|xss_clean|exact_length[10]');
                $this->form_validation->set_rules('to_date','To Date' ,'required|trim|xss_clean|exact_length[10]');

              }


            if($this->form_validation->run()==FALSE){

              $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
              $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);           
              $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
              $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
              $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);
              $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                $this->load->view('Home/footer');
            }else{

                if(!empty($this->input->post('article_no'))){
                    $article_no_arr=explode('//',$this->input->post('article_no'));
                    $article_no=$article_no_arr[1];
                  }else{
                    $article_no='';
                  }

                  if(!empty($this->input->post('sh_mb_supplier'))){
                    $sh_mb_supplier=explode('//',$this->input->post('sh_mb_supplier'));
                  }else{
                    $sh_mb_supplier[1]='';
                  }

                  if(!empty($this->input->post('sleeve_dia'))){
                    $shoulder_dia=explode('//',$this->input->post('sleeve_dia'));
                  }else{
                    $shoulder_dia[0]='';
                    $shoulder_dia[1]='';
                  }
                  if(!empty($this->input->post('shoulder'))){
                      $shoulder_type=explode('//',$this->input->post('shoulder'));
                  }else{
                    $shoulder_type[0]='';
                    $shoulder_type[1]='';
                  }
                  if(!empty($this->input->post('shoulder_orifice'))){
                      $shoulder_orifice=explode('//',$this->input->post('shoulder_orifice'));
                  }else{
                    $shoulder_orifice[0]='';
                    $shoulder_orifice[1]='';
                  }

                  if(!empty($this->input->post('shoulder_foil_tag'))){
                      $shoulder_foil_tag=explode('//',$this->input->post('shoulder_foil_tag'));
                  }else{
                    $shoulder_foil_tag[0]='';
                    $shoulder_foil_tag[1]='';
                  }

                  if(!empty($this->input->post('sh_masterbatch'))){
                      $sh_masterbatch=explode('//',$this->input->post('sh_masterbatch'));
                  }else{
                    $sh_masterbatch[0]='';
                    $sh_masterbatch[1]='';
                  }
                  if(!empty($this->input->post('sh_mb_per'))){
                      $sh_mb_per=$this->input->post('sh_mb_per');
                  }else{
                      $sh_mb_per='';
                  }
                  if(!empty($this->input->post('sh_hdpe_one'))){
                      $sh_hdpe_one=explode('//',$this->input->post('sh_hdpe_one'));
                  }else{
                    $sh_hdpe_one[0]='';
                    $sh_hdpe_one[1]='';
                  }

                  if(!empty($this->input->post('sh_hdpe_one_per'))){
                      $sh_hdpe_one_per=$this->input->post('sh_hdpe_one_per');
                  }else{
                      $sh_hdpe_one_per='';
                  }
                  if(!empty($this->input->post('sh_hdpe_two'))){
                      $sh_hdpe_two=explode('//',$this->input->post('sh_hdpe_two'));
                  }else{
                    $sh_hdpe_two[0]='';
                    $sh_hdpe_two[1]='';
                  }
                  if(!empty($this->input->post('sh_hdpe_two_per'))){
                      $sh_hdpe_two_per=$this->input->post('sh_hdpe_two_per');
                  }else{
                      $sh_hdpe_two_per='';
                  }

                $master_array= array('a.article_no' => $article_no,
                                      'final_approval_flag'=>$this->input->post('final_approval_flag'),
                                      'a.user_id'=>$this->input->post('user_id')
                                    );  
                $data1=array_filter($master_array);

                $data_search=array(
                  'shoulder_dia'=>$shoulder_dia[0],
                  'shoulder_style'=>$shoulder_type[0],
                  'shoulder_orifice'=>$shoulder_orifice[0],
                  'shoulder_foil_tag'=>$shoulder_foil_tag[0],
                  'shoulder_master_batch'=>$sh_masterbatch[0],
                  'shoulder_mb_perc'=>$sh_mb_per,
                  'shoulder_mb_supplier'=>$sh_mb_supplier[1],
                  'shoulder_hdpe_one'=>$sh_hdpe_one[0],
                  'shoulder_hdpe_one_per'=>$sh_hdpe_one_per,
                  'shoulder_hdpe_two'=>$sh_hdpe_two[0],
                  'shoulder_hdpe_two_per'=>$sh_hdpe_two_per,
                );

                $search=array_filter($data_search);
                //print_r($search);

                 $data['specification']=$this->shoulder_specification_model->active_record_search_new('specification_sheet',$data1,$search,$this->common_model->change_date_format($this->input->post('from_date'),$this->session->userdata['logged_in']['company_id']),$this->common_model->change_date_format($this->input->post('to_date'),$this->session->userdata['logged_in']['company_id']),$this->session->userdata['logged_in']['company_id']);
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

                      $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
                      $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                      $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
                      $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);           
                      $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
                      $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                      $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);
                      $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);

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


    function copy_shoulder(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->copy==1){

            $data['specification']=$this->tube_specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->uri->segment(3),'specification_sheet.spec_version_no',$this->uri->segment(4),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);

            $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);

            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

            $data['shoulder_types']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
            
            $data['shoulder_orifice']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
           
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);

            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);

            $data['hot_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);

            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/copy-shoulder-form',$data);
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
  
public function shoulder_per_check($str){
    $sh_hdpe_one_per=$this->input->post('sh_hdpe_one_per');
    $sh_hdpe_two_per=$this->input->post('sh_hdpe_two_per');
    $sh_hdpe_three_per=$this->input->post('sh_hdpe_three_per');
    $total_per=$sh_hdpe_one_per+$sh_hdpe_two_per+$sh_hdpe_three_per;

    if($total_per!=100){
      $this->form_validation->set_message('shoulder_per_check', 'The {field} field is incorrect');
      return FALSE;
    }else{
      return TRUE;
    }

  }

}