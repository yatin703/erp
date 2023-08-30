<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tube_specification extends CI_Controller {

  function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('tube_specification_model');
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
            include('pagination-tube.php');
            $data['specification']=$this->tube_specification_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
           
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

  function view_cap(){
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

            $data['specification_cap_details']=$this->tube_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$this->uri->segment(3),'specification_sheet_details.spec_version_no',$this->uri->segment(4),'item_group_id','5','srd_id','asc');

            $data['followup']=$this->common_model->select_followup_records('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$this->uri->segment(3).'@@@'.$this->uri->segment(4));

            $data['company']=$this->common_model->select_one_active_record('company_master',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);
            $data['company_details']=$this->common_model->select_one_active_record('company_system_parameters',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);

            $this->load->view('Print/header',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/view-form-cap',$data);
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


  function create_single_layer(){

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
            $data['ldpe']=$this->article_model->spec_active_record_search('article','7',$this->session->userdata['logged_in']['company_id']);
            $data['lldpe']=$this->article_model->spec_active_record_search('article','8',$this->session->userdata['logged_in']['company_id']);
            $data['hdpe']=$this->article_model->spec_active_record_search('article','6',$this->session->userdata['logged_in']['company_id']);
            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);


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


  function save_cap(){

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
            /*
            if($this->input->post('specific')==1){
              $this->form_validation->set_rules('customer','Customer' ,'required|trim|xss_clean|callback_customer_check');
            }
            */
            
            $this->form_validation->set_rules('cap_type','Cap Type' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('cap_finish','Cap Finish' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('cap_dia','Cap Dia' ,'required|trim|xss_clean');

            $this->form_validation->set_rules('cap_masterbatch','Cap Masterbatch' ,'required|trim|xss_clean');
            if($this->input->post('cap_masterbatch')!=='RM-MB-TRA-0007//TRANSPARENT'){
              $this->form_validation->set_rules('cap_mb_supplier','Cap Masterbatch Supplier' ,'required|trim|xss_clean|callback_supplier_check');
            }
            
            $this->form_validation->set_rules('cap_mb_per','Cap Masterbatch %' ,'required|trim|xss_clean|numeric|max_length[3]');

            $this->form_validation->set_rules('pp_per','Cap PP %' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');
            $this->form_validation->set_rules('cap_pp','Cap PP' ,'required|trim|xss_clean');

            $this->form_validation->set_rules('cap_shrink_sleeve','Cap Shrink Sleeve' ,'trim|xss_clean|strtoupper');
            $this->form_validation->set_rules('cap_foil','Cap Foil' ,'trim|xss_clean|strtoupper');
            $this->form_validation->set_rules('cap_foil_width','Cap Foil Width' ,'trim|xss_clean|strtoupper');
            $this->form_validation->set_rules('cap_foil_dist_frm_bottom','Cap Foil Distance From Bottom' ,'trim|xss_clean|strtoupper');
               
            

            if($this->form_validation->run()==FALSE){
              
            $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
            $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);
            $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
            $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);
            $data['cap_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);
            $data['cap_shrink_sleeve']=$this->article_model->spec_all_active_record_search('article','213',$this->session->userdata['logged_in']['company_id']);


              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-cap-form',$data);
              $this->load->view('Home/footer');
            }else{
              /*
              if(!empty($this->input->post('customer'))){
                $customer_arr=explode('//',$this->input->post('customer'));
              }else{
                $customer_arr[1]="";
              }*/

              if(!empty($this->input->post('cap_mb_supplier'))){
                $cap_mb_supplier=explode('//',$this->input->post('cap_mb_supplier'));
              }else{
                $cap_mb_supplier[1]='';
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

              if(!empty($this->input->post('cap_masterbatch'))){
                $cap_masterbatch=explode('//',$this->input->post('cap_masterbatch'));
              }else{
                $cap_masterbatch[1]='';
              }

              if(!empty($this->input->post('cap_foil_color'))){
                $cap_foil_color=explode('//',$this->input->post('cap_foil_color'));
              }else{
                $cap_foil_color[0]='';
                $cap_foil_color[1]='';
              }

              if(!empty($this->input->post('cap_shrink_sleeve'))){
                $cap_shrink_sleeve=explode('//',$this->input->post('cap_shrink_sleeve'));
              }else{
                $cap_shrink_sleeve[0]='';
                $cap_shrink_sleeve[1]='';
              }

              $article_description=$cap_type[0]." ".$cap_finish[0]." ".$cap_dia[0]." ".$cap_orifice[0]." ".$cap_masterbatch[1]." ".$this->input->post('cap_mb_per')."%";

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
                              'archive'=>'0');

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

                        $data['auto']=$this->common_model->select_one_active_record_nonlanguage_without_archive('autogeneration_format_master',$this->session->userdata['logged_in']['company_id'],'form_id','1238');
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
                        $this->common_model->update_one_active_record('autogeneration_format_master',$data,'form_id','1238',$this->session->userdata['logged_in']['company_id']);
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
                              'dyn_qty_present'=>'CAP|1',
                              );

                        $result=$this->common_model->save('specification_sheet',$data);


                        

                        $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                          'spec_id'=>$spec_no,
                          'disp_id'=>'177',
                          'item_group_id'=>'5',
                          'item_group_flag'=>'1',
                          'parameter_name'=>'DRAWING',
                          'item_group_material'=>'',
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
                          'disp_id'=>'178',
                          'item_group_id'=>'5',
                          'item_group_flag'=>'1',
                          'parameter_name'=>'STYLE',
                          'item_group_material'=>'',
                          'parameter_value'=>'',
                          'relating_master_value'=>$cap_type[0],
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
                          'relating_master_value'=>$cap_finish[0],
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
                          'relating_master_value'=>$cap_dia[0],
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
                          'parameter_value'=>$cap_shrink_sleeve[1],
                          'item_group_material'=>'213',
                          'relating_master_value'=>'',
                          'material'=>'1',
                          'supplier_no'=>'',
                          'mat_info'=>'',
                          'property_id'=>'',
                          'mat_article_no'=>$cap_shrink_sleeve[0],
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
                          'relating_master_value'=>$cap_orifice[0],
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
                          'supplier_no'=>$cap_mb_supplier[1],
                          'mat_info'=>$this->input->post('cap_mb_per')."%",
                          'mat_article_no'=>$cap_masterbatch[0],
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
                          'mat_info'=>$this->input->post('pp_per')."%",
                          'mat_article_no'=>$this->input->post('cap_pp'),
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
                          'mat_article_no'=>$cap_foil_color[0],
                          'material'=>'1',
                          'supplier_no'=>'',
                          'property_id'=>'',
                          'parameter_value'=>$cap_foil_color[1],
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
                          'parameter_value'=>$this->input->post('cap_foil_width'),
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
                        'parameter_value'=>$this->input->post('cap_foil_dist_frm_bottom'),
                        'srd_id'=>'3_11',
                        'item_group_material_flag'=>'0',
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
             $data['error']='Same Cap alerdy Exist';
          }

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
              
              
                  $data['main_group']=$this->common_model->select_active_drop_down('article_main_group',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);
                  $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                  $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_shrink_sleeve']=$this->article_model->spec_all_active_record_search('article','213',$this->session->userdata['logged_in']['company_id']);
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                  $this->load->view(ucwords($this->router->fetch_class()).'/create-cap-form',$data);
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
            $data['specification']=$this->tube_specification_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
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


  

  function modify_cap(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){

            $data['specification']=$this->tube_specification_model->select_one_active_unapproved_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->uri->segment(3),'specification_sheet.spec_version_no',$this->uri->segment(4),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);
            
                  $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

                  $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);

                  $data['cap_shrink_sleeve']=$this->article_model->spec_all_active_record_search('article','213',$this->session->userdata['logged_in']['company_id']);
                  $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);

                  $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/cap-modify-form',$data);
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


  function update_cap(){
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

            $this->form_validation->set_rules('cap_type','Cap Type' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('cap_finish','Cap Finish' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('cap_dia','Cap Dia' ,'required|trim|xss_clean');

            $this->form_validation->set_rules('cap_masterbatch','Cap Masterbatch' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('cap_mb_supplier','Cap Masterbatch Supplier' ,'trim|xss_clean|callback_supplier_check');
            $this->form_validation->set_rules('cap_mb_per','Cap Masterbatch %' ,'required|trim|xss_clean|numeric|max_length[3]');

            $this->form_validation->set_rules('pp_per','Cap PP %' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');
            $this->form_validation->set_rules('cap_pp','Cap PP' ,'required|trim|xss_clean');

            $this->form_validation->set_rules('cap_shrink_sleeve','Cap Shrink Sleeve' ,'trim|xss_clean|strtoupper');
            $this->form_validation->set_rules('cap_foil_color','Cap Foil' ,'trim|xss_clean|strtoupper');
            $this->form_validation->set_rules('cap_foil_width','Cap Foil Width' ,'trim|xss_clean|strtoupper');
            $this->form_validation->set_rules('cap_foil_dist_frm_bottom','Cap Foil Distance From Bottom' ,'trim|xss_clean|strtoupper');
            
              

              if($this->form_validation->run()==FALSE){

                
                $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
                $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
                $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

                
                $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);

                $data['cap_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);

                $data['cap_shrink_sleeve']=$this->article_model->spec_all_active_record_search('article','213',$this->session->userdata['logged_in']['company_id']);

                $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

                $data['specification']=$this->tube_specification_model->select_one_active_unapproved_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->input->post('spec_id'),'specification_sheet.spec_version_no',$this->input->post('spec_version_no'),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/cap-modify-form',$data);
                $this->load->view('Home/footer');

              }else{

                    if(!empty($this->input->post('cap_mb_supplier'))){
                      $cap_mb_supplier=explode('//',$this->input->post('cap_mb_supplier'));
                    }else{
                      $cap_mb_supplier[1]='';
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

                     if(!empty($this->input->post('cap_masterbatch'))){
                      $cap_masterbatch=explode('//',$this->input->post('cap_masterbatch'));
                    }else{
                      $cap_masterbatch[1]='';
                    }


                    if(!empty($this->input->post('cap_foil_color'))){
                      $cap_foil_color=explode('//',$this->input->post('cap_foil_color'));
                    }else{
                      $cap_foil_color[0]='';
                      $cap_foil_color[1]='';
                    }

                    if(!empty($this->input->post('cap_shrink_sleeve'))){
                      $cap_shrink_sleeve=explode('//',$this->input->post('cap_shrink_sleeve'));
                    }else{
                      $cap_shrink_sleeve[0]='';
                      $cap_shrink_sleeve[1]='';
                    }

              $article_description=$cap_type[0]." ".$cap_finish[0]." ".$cap_dia[0]." ".$cap_orifice[0]." ".$cap_masterbatch[1]." ".$this->input->post('cap_mb_per')."%";

              /*$data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article_name_info.lang_article_description',$article_description);

              if($data['article']==FALSE){*/


              $data=array('lang_article_description'=>$article_description);

              $result=$this->common_model->update_one_active_record('article_name_info',$data,'article_no',$this->input->post('article_no'),$this->session->userdata['logged_in']['company_id']);
                  

                  $data=array('relating_master_value'=>$cap_type[0]);

                  $result=$this->tube_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_2',$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$cap_finish[0]);

                  $result=$this->tube_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_3',$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$cap_dia[0]);

                  $result=$this->tube_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_4',$this->session->userdata['logged_in']['company_id']);

                  $data=array('relating_master_value'=>$cap_orifice[0]);

                  $result=$this->tube_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_6',$this->session->userdata['logged_in']['company_id']);


                  $data=array('mat_article_no'=>$cap_masterbatch[0],'mat_info'=>$this->input->post('cap_mb_per').'%','supplier_no'=>$cap_mb_supplier[1]);

                  $result=$this->tube_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_7_0',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$cap_shrink_sleeve[0],'parameter_value'=>$cap_shrink_sleeve[1]);

                  $result=$this->tube_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_5',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$cap_foil_color[0],'parameter_value'=>$cap_foil_color[1]);

                  $result=$this->tube_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_9',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('cap_foil_width'));

                  $result=$this->tube_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_10',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('cap_foil_dist_frm_bottom'));

                  $result=$this->tube_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_11',$this->session->userdata['logged_in']['company_id']);

                  $data=array('mat_article_no'=>$this->input->post('cap_pp'),'mat_info'=>$this->input->post('pp_per').'%');

                  $result=$this->tube_specification_model->update_details_record_where('specification_sheet_details',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),'srd_id','3_8_1',$this->session->userdata['logged_in']['company_id']);

                  if(!empty($this->input->post('approval_authority'))){

                    $data=array('pending_flag'=>'1');

                    $result=$this->tube_specification_model->update_one_active_record('specification_sheet',$data,'spec_id',$this->input->post('spec_id'),'spec_version_no',$this->input->post('spec_version_no'),$this->session->userdata['logged_in']['company_id']);

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

                /*}else{
                  $data['error']='Update Transaction Incomplete';
                }*/

                  
                  $data['specification']=$this->tube_specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->input->post('spec_id'),'specification_sheet.spec_version_no',$this->input->post('spec_version_no'),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);
                  
                  $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);

                  $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                  $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);

                  $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

                  

                  $data['page_name']='Sales';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                  $this->load->view(ucwords($this->router->fetch_class()).'/cap-modify-form',$data);
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



  function copy(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->copy==1){

            $data['specification']=$this->tube_specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->uri->segment(3),'specification_sheet.spec_version_no',$this->uri->segment(4),'specification_sheet.user_id',$this->session->userdata['logged_in']['user_id']);

            //echo $this->db->last_query();

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


 


  function save_copy(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->copy==1){

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
              $this->form_validation->set_rules('sl_mb_supplier','Sleeve Masterbatch Supplier','required|trim|xss_clean|callback_supplier_check');
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
              $this->form_validation->set_rules('sh_mb_supplier','Shoulder Masterbatch Supplier' ,'required|trim|xss_clean|callback_supplier_check');
              $this->form_validation->set_rules('sh_mb_per','Shoulder Masterbatch %' ,'required|trim|xss_clean|numeric|max_length[3]');
              $this->form_validation->set_rules('sh_hdpe_one_per','Shoulder HDPE %' ,'trim|xss_clean|is_natural|max_length[3]|callback_shoulder_per_check');
              $this->form_validation->set_rules('sh_hdpe_two_per','Shoulder HDPE %' ,'trim|xss_clean|is_natural|max_length[3]|callback_shoulder_per_check');

               if(!empty($this->input->post('sh_hdpe_one_per'))){
                $this->form_validation->set_rules('sh_hdpe_one','Shoulder Hdpe' ,'trim|xss_clean|required');
                }if(!empty($this->input->post('sh_hdpe_two_per'))){
                $this->form_validation->set_rules('sh_hdpe_two','Shoulder Hdpe' ,'trim|xss_clean|required');
                }

            }


            if($this->input->post('cap_type') || $this->input->post('cap_finish') || $this->input->post('cap_dia') || $this->input->post('cap_masterbatch') || $this->input->post('cap_mb_per') || $this->input->post('pp_per') || $this->input->post('cap_pp')){

              $this->form_validation->set_rules('cap_type','Cap Type' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_finish','Cap Finish' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_dia','Cap Dia' ,'required|trim|xss_clean');

              $this->form_validation->set_rules('cap_masterbatch','Cap Masterbatch' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cap_mb_supplier','Cap Masterbatch Supplier' ,'required|trim|xss_clean|callback_supplier_check');
              $this->form_validation->set_rules('cap_mb_per','Cap Masterbatch %' ,'required|trim|xss_clean|numeric|max_length[3]');

               $this->form_validation->set_rules('pp_per','Cap PP %' ,'required|trim|xss_clean|is_natural_no_zero|max_length[3]');
               $this->form_validation->set_rules('cap_pp','Cap PP' ,'required|trim|xss_clean');
               $this->form_validation->set_rules('cap_foil_color','Cap Foil Color' ,'required|trim|xss_clean|strtoupper');
               $this->form_validation->set_rules('cap_foil_width','Cap Foil Width' ,'required|trim|xss_clean|strtoupper');
               $this->form_validation->set_rules('cap_foil_dist_frm_bottom','Cap Foil Distance From Bottom|' ,'required|trim|xss_clean|strtoupper');
            }

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

            $data['specification']=$this->tube_specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->input->post('spec_id'),'specification_sheet.spec_version_no',$this->input->post('copy_version_no'));


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

              $data['spec_version']=$this->tube_specification_model->select_specification_verion_no('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$article_no_arr[1]);
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
                'material'=>'0',
                'item_group_material'=>'',
                'parameter_name'=>'SHOULDER FOIL TAG',
                'parameter_value'=>$this->input->post('shoulder_foil_tag'),
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'srd_id'=>'2_8',
                'item_group_material_flag'=>'0',
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
                'parameter_name'=>'DRAWING',
                'item_group_material'=>'',
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
                'disp_id'=>'178',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'STYLE',
                'item_group_material'=>'',
                'parameter_value'=>'',
                'relating_master_value'=>$cap_type[0],
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
                'relating_master_value'=>$cap_finish[0],
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
                'relating_master_value'=>$cap_dia[0],
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
                'parameter_name'=>'HEIGHT',
                'parameter_value'=>'',
                'item_group_material'=>'',
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
                'disp_id'=>'182',
                'item_group_id'=>'5',
                'item_group_flag'=>'1',
                'parameter_name'=>'ORIFICE',
                'parameter_value'=>'',
                'item_group_material'=>'',
                'relating_master_value'=>$cap_orifice[0],
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
                'supplier_no'=>$cap_mb_supplier[1],
                'mat_info'=>$this->input->post('cap_mb_per')."%",
                'mat_article_no'=>$this->input->post('cap_masterbatch'),
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
                'mat_info'=>$this->input->post('pp_per')."%",
                'mat_article_no'=>$this->input->post('cap_pp'),
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
                'item_group_material'=>'',
                'relating_master_value'=>'',
                'supplier_no'=>'',
                'mat_info'=>'',
                'property_id'=>'',
                'mat_article_no'=>'',
                'material'=>'0',
                'supplier_no'=>'',
                'property_id'=>'',
                'parameter_value'=>$this->input->post('cap_foil_color'),
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
                'parameter_value'=>$this->input->post('cap_foil_width'),
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
              'parameter_value'=>$this->input->post('cap_foil_dist_frm_bottom'),
              'srd_id'=>'3_11',
              'item_group_material_flag'=>'0',
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

                  $data['specification']=$this->tube_specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$spec_no,'specification_sheet.spec_version_no',$spec_version_no);

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



  function delete_cap(){

      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

                  $data=array('archive'=>'1');

                  $result=$this->tube_specification_model->update_one_active_record('specification_sheet',$data,'spec_id',$this->uri->segment(3),'spec_version_no',$this->uri->segment(4),$this->session->userdata['logged_in']['company_id']);

                  $data['specification']=$this->tube_specification_model->select_one_inactive_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->uri->segment(3),'specification_sheet.spec_version_no',$this->input->post('spec_version_no'));
                
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


    function dearchive_cap(){

      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

                  $data=array('archive'=>'2');

                  $result=$this->tube_specification_model->update_one_active_record('specification_sheet',$data,'spec_id',$this->uri->segment(3),'spec_version_no',$this->uri->segment(4),$this->session->userdata['logged_in']['company_id']);

                  $data['specification']=$this->tube_specification_model->select_one_inactive_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$this->uri->segment(3),'specification_sheet.spec_version_no',$this->input->post('spec_version_no'));
                
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

                $data['specification']=$this->tube_specification_model->active_record_search('specification_sheet',$data,$this->common_model->change_date_format($this->input->post('from_date'),$this->session->userdata['logged_in']['company_id']),$this->common_model->change_date_format($this->input->post('to_date'),$this->session->userdata['logged_in']['company_id']),$this->session->userdata['logged_in']['company_id']);
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


    function copy_cap(){
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
                  $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_finish']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_dia']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_orifice']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);
                  $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_foil']=$this->article_model->spec_all_active_record_search('article','71',$this->session->userdata['logged_in']['company_id']);
                  $data['cap_shrink_sleeve']=$this->article_model->spec_all_active_record_search('article','213',$this->session->userdata['logged_in']['company_id']);
                  $data['pp']=$this->article_model->spec_all_active_record_search('article','9',$this->session->userdata['logged_in']['company_id']);

                 

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/copy-cap-form',$data);
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
  

}