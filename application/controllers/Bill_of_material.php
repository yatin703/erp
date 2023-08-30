<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bill_of_material extends CI_Controller {

  function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('sales_order_book_model');
      $this->load->model('bill_of_material_model');
      $this->load->model('sleeve_specification_model');
      $this->load->model('shoulder_specification_model');
      $this->load->model('label_specification_model');
      $this->load->model('cap_specification_model');
      $this->load->model('article_model');
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
            $table='bill_of_material';
            include('pagination.php');
            $data['bill_of_material']=$this->bill_of_material_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

            //echo $this->db->last_query();

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
    //echo "HI";
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

            /*saurabh changes Start*/

            $data['bill_of_material']=$this->bill_of_material_model->select_one_active_record('bill_of_material',$this->session->userdata['logged_in']['company_id'],'bill_of_material.bom_id',$this->uri->segment(3));
            //echo $this->db->last_query();
            $data['bom_guage_total']=$this->bill_of_material_model->bom_gauge_total($this->uri->segment(3));

            /*saurabh changes End */

            $data['bill_of_material']=$this->bill_of_material_model->select_one_active_record('bill_of_material',$this->session->userdata['logged_in']['company_id'],'bill_of_material.bom_id',$this->uri->segment(3));
            //echo $this->db->last_query();

            foreach($data['bill_of_material'] as $bill_of_material_row){
              $bom_no=$bill_of_material_row->bom_no;
              $bom_version_no=$bill_of_material_row->bom_version_no;
              $sleeve_code=$bill_of_material_row->sleeve_code;
              $shoulder_code=$bill_of_material_row->shoulder_code;
              $cap_code=$bill_of_material_row->cap_code;
              $label_code=$bill_of_material_row->label_code;
            }


            $data['sleeve_code']=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$sleeve_code);
            //echo $this->db->last_query();
            foreach($data['sleeve_code'] as $sleeve_code_row){
              $sleeve_specs_no=$sleeve_code_row->spec_id;
              $sleeve_specs_version_no=$sleeve_code_row->spec_version_no;

              $data['sleeve_specification']=$this->sleeve_specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$sleeve_specs_no,'specification_sheet.spec_version_no',$sleeve_specs_version_no);

              
              $data['specification_sleeve_details']=$this->sleeve_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$sleeve_specs_no,'specification_sheet_details.spec_version_no',$sleeve_specs_version_no,'item_group_id','3','srd_id','asc');
            }


            $data['shoulder_code']=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$shoulder_code);
            foreach($data['shoulder_code'] as $shoulder_code_row){
              $shoulder_specs_no=$shoulder_code_row->spec_id;
              $shoulder_specs_version_no=$shoulder_code_row->spec_version_no;

              $data['shoulder_specification']=$this->shoulder_specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$shoulder_specs_no,'specification_sheet.spec_version_no',$shoulder_specs_version_no);

              
              $data['specification_shoulder_details']=$this->shoulder_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$shoulder_specs_no,'specification_sheet_details.spec_version_no',$shoulder_specs_version_no,'item_group_id','4','srd_id','asc');
            }


            $data['label_code']=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$label_code);
            if($data['label_code']==FALSE){
              $data['label_specification']="";
              $data['specification_label_details']="";
            }else{
              foreach($data['label_code'] as $label_code_row){

                $label_specs_no=$label_code_row->spec_id;
                $label_specs_version_no=$label_code_row->spec_version_no;

                $data['label_specification']=$this->label_specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$label_specs_no,'specification_sheet.spec_version_no',$label_specs_version_no);

                $data['specification_label_details']=$this->label_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$label_specs_no,'specification_sheet_details.spec_version_no',$label_specs_version_no,'item_group_id','6','srd_id','asc');
              }
            }


            $data['cap_code']=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$cap_code);
            foreach($data['cap_code'] as $cap_code_row){

              $cap_specs_no=$cap_code_row->spec_id;
              $cap_specs_version_no=$cap_code_row->spec_version_no;

              $data['cap_specification']=$this->cap_specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$cap_specs_no,'specification_sheet.spec_version_no',$cap_specs_version_no);

              $data['specification_cap_details']=$this->cap_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$cap_specs_no,'specification_sheet_details.spec_version_no',$cap_specs_version_no,'item_group_id','5','srd_id','asc');
            }





            //echo $this->db->last_query();
           
            

            $data['followup']=$this->common_model->select_followup_records('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$bom_no.'@@@'.$bom_version_no);

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


  function create(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');
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

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $this->form_validation->set_rules('article_no','Product Code' ,'required|trim|xss_clean|callback_article_check|callback_tube_check');
            $this->form_validation->set_rules('sleeve_code','Sleeve Code' ,'required|trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('paper_film_code','Paper Film Code' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('print_type','Print Type' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('shoulder_code','Shoulder Code' ,'required|trim|xss_clean|callback_article_check');

            //$this->form_validation->set_rules('cap_code','Cap Code' ,'required|trim|xss_clean|callback_article_check');

            $this->form_validation->set_rules('label_code','Label Code' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('for_export','Packing Type' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('comment','Comment' ,'trim|xss_clean|max_length[512]');
            $this->form_validation->set_rules('approval_authority','Approval Authority' ,'trim|xss_clean');


              if(!empty($this->input->post('article_no'))){
                $article_no=explode('//',$this->input->post('article_no'));
              }else{
                $article_no[1]='';
              }

              if(substr($article_no[1],0,2)=="PS" || substr($article_no[1],0,2)=="SR"){
                if(!empty($this->input->post('sleeve_code'))){
                $sleeve_code=explode('//',$this->input->post('sleeve_code'));
                }else{
                $sleeve_code[1]='';
                }

                if(substr($sleeve_code[1],0,3)!="SLV"){
                  $this->form_validation->set_rules('sleeve_code', 'Tube/Film Code', 'rule1',
                    array('rule1' => 'Please check Tube/Film Code')
                    );
                  
                }
              }

              if(substr($article_no[1],0,2)=="SP" || substr($article_no[1],0,2)=="SS"){
                if(!empty($this->input->post('sleeve_code'))){
                $sleeve_code=explode('//',$this->input->post('sleeve_code'));
                }else{
                $sleeve_code[1]='';
                }

                if(substr($sleeve_code[1],0,3)!="LMN"){
                  $this->form_validation->set_rules('sleeve_code', 'Tube/Film Code', 'rule1',
                    array('rule1' => 'Please check Tube/Film Code')
                    );
                  
                }
              }

              if(substr($article_no[1],0,2)=="SP" || substr($article_no[1],0,2)=="SS"){
                if(!empty($this->input->post('paper_film_code'))){
                $paper_film_code=explode('//',$this->input->post('paper_film_code'));
                }else{
                $paper_film_code[1]='';
                }

                if(substr($paper_film_code[1],0,2)!="RM"){
                  $this->form_validation->set_rules('paper_film_code', 'Paper Film Code', 'rule1',
                    array('rule1' => 'Please check Paper Film Code')
                    );
                  
                }
              }


             //--SHOULDER CHECK FOR TEAR OFF--------------------------
            $shld_type_id="";
            if(!empty($this->input->post('shoulder_code'))){
                $shoulder_code=explode('//',$this->input->post('shoulder_code'));
              }else{
                $shoulder_code[1]='';
              }
              if($shoulder_code[1]!=''){
                $shoulder_specification_sheet=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$shoulder_code[1]);
                $spec_id='';
                $spec_version_no='';
                foreach($shoulder_specification_sheet as $shoulder_specification_sheet_row){
                    $spec_id=$shoulder_specification_sheet_row->spec_id;
                    $spec_version_no=$shoulder_specification_sheet_row->spec_version_no;                    
                }
                $data= array('spec_id' =>$spec_id,'spec_version_no'=>$spec_version_no);                
                $shoulder_specification_sheet_details=$this->sales_order_book_model->select_shoulder_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data);
                // echo $this->db->last_query();
                $shoulder_type='';
                $shoulder_orifice='';
                foreach($shoulder_specification_sheet_details as $shoulder_specification_sheet_details_row){
                  $shoulder_type=$shoulder_specification_sheet_details_row->SHOULDER_STYLE;
                  $shoulder_orifice=$shoulder_specification_sheet_details_row->SHOULDER_ORIFICE;

                }
                $data['shoulder_types_master']=$this->common_model->select_one_active_record('shoulder_types_master',$this->session->userdata['logged_in']['company_id'],'shoulder_type',$shoulder_type);
                //echo $this->db->last_query();
                if($data['shoulder_types_master']==FALSE){
                  $shld_type_id="";
                }else{
                 foreach($data['shoulder_types_master'] as $shoulder_types_master_row){
                  $shld_type_id=$shoulder_types_master_row->shld_type_id;
                 }
                }
               

              }

              // if($shld_type_id!='' && $shld_type_id!='4'){

              //    $this->form_validation->set_rules('cap_code','Cap Code' ,'required|trim|xss_clean|callback_article_check');

              // }

            //VALIDATION TRUE
            if($this->form_validation->run()){

              if(!empty($this->input->post('article_no'))){
                $article_no=explode('//',$this->input->post('article_no'));
              }else{
                $article_no[1]='';
              }

              if(!empty($this->input->post('sleeve_code'))){
                $sleeve_code=explode('//',$this->input->post('sleeve_code'));
              }else{
                $sleeve_code[1]='';
              }

              if(!empty($this->input->post('paper_film_code'))){
                $paper_film_code=explode('//',$this->input->post('paper_film_code'));
              }else{
                $paper_film_code[1]='';
              }

              if(!empty($this->input->post('shoulder_code'))){
                $shoulder_code=explode('//',$this->input->post('shoulder_code'));
              }else{
                $shoulder_code[1]='';
              }
              if(!empty($this->input->post('cap_code'))){
                $cap_code=explode('//',$this->input->post('cap_code'));
              }else{
                $cap_code[1]='';
              }
              if(!empty($this->input->post('label_code'))){
                $label_code=explode('//',$this->input->post('label_code'));
              }else{
                $label_code[1]='';
              }
              //--SLEEVE----------------------------------
              $sleeve_dia_id='';
              if($sleeve_code[1]!=''){
                $sleeve_specification_sheet=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$sleeve_code[1]);
                $spec_id='';
                $spec_version_no='';
                foreach($sleeve_specification_sheet as $sleeve_specification_sheet_row){
                    $spec_id=$sleeve_specification_sheet_row->spec_id;
                    $spec_version_no=$sleeve_specification_sheet_row->spec_version_no;                    
                }
                $data= array('spec_id' =>$spec_id,'spec_version_no'=>$spec_version_no);                
                $sleeve_specification_sheet_details=$this->sales_order_book_model->select_sleeve_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data);
                //echo $this->db->last_query();

                $sleeve_dia='';
                foreach($sleeve_specification_sheet_details as $sleeve_specification_sheet_details_row){
                  $sleeve_dia=$sleeve_specification_sheet_details_row->SLEEVE_DIA;

                }

                $data['sleeve_diameter_master']=$this->common_model->select_one_active_record('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id'],'sleeve_diameter',$sleeve_dia);
                //echo $this->db->last_query();
                if($data['sleeve_diameter_master']==FALSE){
                  $sleeve_dia_id="";
                }else{
                 foreach($data['sleeve_diameter_master'] as $sleeve_diameter_master_row){
                  $sleeve_dia_id=$sleeve_diameter_master_row->sleeve_id;
                 }
                }


              }


              //--Paper Film Code----------------------------------
              if($paper_film_code[1]!=''){
                $sleeve_specification_sheet=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$paper_film_code[1]);
                $spec_id='';
                $spec_version_no='';
                foreach($sleeve_specification_sheet as $sleeve_specification_sheet_row){
                    $spec_id=$sleeve_specification_sheet_row->spec_id;
                    $spec_version_no=$sleeve_specification_sheet_row->spec_version_no;                    
                }
                $data= array('spec_id' =>$spec_id,'spec_version_no'=>$spec_version_no);                
                $sleeve_specification_sheet_details=$this->sales_order_book_model->select_sleeve_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data);
                //echo $this->db->last_query();

                $sleeve_dia='';
                foreach($sleeve_specification_sheet_details as $sleeve_specification_sheet_details_row){
                  $sleeve_dia=$sleeve_specification_sheet_details_row->SLEEVE_DIA;

                }

                $data['sleeve_diameter_master']=$this->common_model->select_one_active_record('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id'],'sleeve_diameter',$sleeve_dia);
                //echo $this->db->last_query();
                if($data['sleeve_diameter_master']==FALSE){
                  $sleeve_dia_id="";
                }else{
                 foreach($data['sleeve_diameter_master'] as $sleeve_diameter_master_row){
                  $sleeve_dia_id=$sleeve_diameter_master_row->sleeve_id;
                 }
                }


              }

              //--SHOULDER--------------------------
              if($shoulder_code[1]!=''){
                $shoulder_specification_sheet=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$shoulder_code[1]);
                $spec_id='';
                $spec_version_no='';
                foreach($shoulder_specification_sheet as $shoulder_specification_sheet_row){
                    $spec_id=$shoulder_specification_sheet_row->spec_id;
                    $spec_version_no=$shoulder_specification_sheet_row->spec_version_no;                    
                }
                $data= array('spec_id' =>$spec_id,'spec_version_no'=>$spec_version_no);                
                $shoulder_specification_sheet_details=$this->sales_order_book_model->select_shoulder_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data);
                // echo $this->db->last_query();
                $shoulder_type='';
                $shoulder_orifice='';
                foreach($shoulder_specification_sheet_details as $shoulder_specification_sheet_details_row){
                  $shoulder_type=$shoulder_specification_sheet_details_row->SHOULDER_STYLE;
                  $shoulder_orifice=$shoulder_specification_sheet_details_row->SHOULDER_ORIFICE;

                }
                $data['shoulder_types_master']=$this->common_model->select_one_active_record('shoulder_types_master',$this->session->userdata['logged_in']['company_id'],'shoulder_type',$shoulder_type);
                //echo $this->db->last_query();
                if($data['shoulder_types_master']==FALSE){
                  $shld_type_id="";
                }else{
                 foreach($data['shoulder_types_master'] as $shoulder_types_master_row){
                  $shld_type_id=$shoulder_types_master_row->shld_type_id;
                 }
                }
                $data['shoulder_orifice_master']=$this->common_model->select_one_active_record('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id'],'shoulder_orifice',$shoulder_orifice);
                //echo $this->db->last_query();
                if($data['shoulder_orifice_master']==FALSE){
                  $orifice_id="";
                }else{
                 foreach($data['shoulder_orifice_master'] as $shoulder_orifice_master_row){
                  $orifice_id=$shoulder_orifice_master_row->orifice_id;
                 }
                }

              }
              //--CAP--------------------------
                $cap_dia='';
                $cap_type='';
                $cap_finish='';
                $cap_orifice='';

                $cap_dia_id='';
                $cap_orifice_id='';
                $cap_type_id='';
                $cap_finish_id='';

              if($cap_code[1]!=''){

                $cap_specification_sheet=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$cap_code[1]);
                $spec_id='';
                $spec_version_no='';
                foreach($cap_specification_sheet as $cap_specification_sheet_row){
                    $spec_id=$cap_specification_sheet_row->spec_id;
                    $spec_version_no=$cap_specification_sheet_row->spec_version_no;                    
                }

                $data= array('spec_id' =>$spec_id,'spec_version_no'=>$spec_version_no);                
                $cap_specification_sheet_details=$this->sales_order_book_model->select_cap_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data);

                

                foreach($cap_specification_sheet_details as $cap_specification_sheet_details_row){
                  $cap_dia = $cap_specification_sheet_details_row->CAP_DIA;
                  $cap_type = $cap_specification_sheet_details_row->CAP_STYLE;
                  $cap_finish = $cap_specification_sheet_details_row->CAP_MOLD_FINISH;
                  $cap_orifice = $cap_specification_sheet_details_row->CAP_ORIFICE;                 
                }

                $data['cap_diameter_master']=$this->common_model->select_one_active_record('cap_diameter_master',$this->session->userdata['logged_in']['company_id'],'cap_dia',$cap_dia);
                //echo $this->db->last_query();
                if($data['cap_diameter_master']==FALSE){
                  $cap_dia_id="";
                }else{
                  foreach($data['cap_diameter_master'] as $cap_diameter_master_row){
                    $cap_dia_id=$cap_diameter_master_row->cap_dia_id;
                  }
                }

                $data['cap_orifice_master']=$this->common_model->select_one_active_record('cap_orifice_master',$this->session->userdata['logged_in']['company_id'],'cap_orifice',$cap_orifice);
                if($data['cap_orifice_master']==FALSE){
                  $cap_orifice_id="";
                }else{
                  foreach($data['cap_orifice_master'] as $cap_orifice_master_row){
                    $cap_orifice_id=$cap_orifice_master_row->cap_orifice_id;
                  }
                }

                $data['cap_types_master']=$this->common_model->select_one_active_record('cap_types_master',$this->session->userdata['logged_in']['company_id'],'cap_type',$cap_type);
                if($data['cap_types_master']==FALSE){
                  $cap_type_id="";
                }else{
                  foreach($data['cap_types_master'] as $cap_types_master_row){
                    $cap_type_id=$cap_types_master_row->cap_type_id;
                  }
                }
                $data['cap_finish_master']=$this->common_model->select_one_active_record('cap_finish_master',$this->session->userdata['logged_in']['company_id'],'cap_finish',$cap_finish);
                if($data['cap_finish_master']==FALSE){
                  $cap_finish_id="";
                }else{
                    foreach($data['cap_finish_master'] as $cap_finish_master_row){
                      $cap_finish_id=$cap_finish_master_row->cap_finish_id;
                    }
                }

              }

              //--SHOULDER DEPENDANCY CHECK-----------------------------

              $combination_data_arr=array('sleeve_id'=>$sleeve_dia_id,
              'shld_type_id'=>$shld_type_id,
              'shld_orifice_id'=>$orifice_id,
              'cap_dia_id'=>$cap_dia_id,
              'cap_orifice_id'=>$cap_orifice_id,
              'cap_type_id'=>$cap_type_id,
              'cap_finish_id'=>$cap_finish_id);

              $combination_data=array_filter($combination_data_arr);

              $this->load->model('shoulder_orifice_dependancy_model');
              
              $shoulder_orifice_dependancy=$this->shoulder_orifice_dependancy_model->select_one_active_combination_record('shoulder_orifice_dependancy',$this->session->userdata['logged_in']['company_id'],$combination_data);
              
              
              if($shoulder_orifice_dependancy>0){

                //--DUPLICATE CHECK---------------------------
                $data = array('article_no' =>$article_no[1]);
                $bill_of_material=$this->common_model->select_one_active_record('bill_of_material',$this->session->userdata['logged_in']['company_id'],'article_no',$article_no[1]);                

                $data['bom_version']=$this->bill_of_material_model->select_bom_verion_no('bill_of_material',$this->session->userdata['logged_in']['company_id'],'article_no',$article_no[1]);
                
                foreach ($data['bom_version'] as $bom_version_row) {

                  if($bom_version_row->bom_version_no==NULL){
                    $max_pkey=0;
                    $result=$this->common_model->select_max_pkey('bill_of_material','bom_no',$this->session->userdata['logged_in']['company_id']); 
                    //echo $this->db->last_query();
                    foreach($result as $row){
                      echo $max_pkey=$row->bom_no;
                      $max_pkey=substr($max_pkey,3);
                      $max_pkey=$max_pkey+1;
                      echo $bom_no=str_pad($max_pkey,4,0,STR_PAD_LEFT);
                      $bom_no="BOM".$bom_no;
                    }
                    $bom_version_no=1;
                  }else{
                    $bom_version_no=$bom_version_row->bom_version_no;
                    $bom_no=$bom_version_row->bom_no;
                  }

                }
                
                /*if(count($bill_of_material)==0){*/
                  /*
                  $data['auto']=$this->common_model->select_one_active_record_nonlanguage_without_archive('autogeneration_format_master',$this->session->userdata['logged_in']['company_id'],'form_id','1243');
                  $no="";
                  foreach ($data['auto'] as $auto_row) {

                    $no=str_pad($auto_row->curr_val,4,"0",STR_PAD_LEFT);
                    $bom_no=$auto_row->textcode.$auto_row->seperator.$auto_row->seperator.$auto_row->seperator.$no;
                    $next_bom_no=$auto_row->curr_val+1;
                  }
                  $data=array('curr_val'=>$next_bom_no);
                  $this->common_model->update_one_active_record('autogeneration_format_master',$data,'form_id','1243',$this->session->userdata['logged_in']['company_id']);

              */
                  if($sleeve_code[1] != ''){
                      $sleeve = $sleeve_code[1];
                  }else{
                      $sleeve = $paper_film_code[1];
                  }

                  $data= array('company_id' =>$this->session->userdata['logged_in']['company_id'],
                               'bom_no'=>$bom_no,
                               'bom_version_no'=>$bom_version_no,
                               'article_no'=>$article_no[1],
                               'sleeve_code'=> $sleeve,
                               'print_type'=>$this->input->post('print_type'),
                               'shoulder_code'=>$shoulder_code[1],
                               'cap_code'=>$cap_code[1],
                               'label_code'=>$label_code[1],
                               'user_id'=>$this->session->userdata['logged_in']['user_id'],
                               'for_export'=>$this->input->post('for_export'),
                               'bom_creation_date'=>date('Y-m-d'),
                               'comment'=>$this->input->post('comment')
                             );

                

                  $result=$this->common_model->save('bill_of_material',$data);
                  $bom_id = $this->db->insert_id();

                  if(!empty($this->input->post('approval_authority'))){

                    $data=array('pending_flag'=>'1');

                    $result=$this->common_model->update_one_active_record('bill_of_material',$data,'bom_no',$bom_no,$this->session->userdata['logged_in']['company_id']);

                    $data['followup']=$this->common_model->select_one_active_record_nonlanguage_without_archive('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$bom_no.'@@@'.$bom_version_no);
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
                        'form_id'=>'791',
                        'transaction_no'=>$transaction_no,
                        'status'=>$status,
                        'followup_date'=>date('Y-m-d'),
                        'contact_person_id'=>$this->session->userdata['logged_in']['user_id'],
                        'record_no'=>$bom_no.'@@@'.$bom_version_no);

                      $result=$this->common_model->save('followup',$data);

                      $data['note']='Sent For the Approval';
                  }



                  $data['note']='Create Transaction Completed';
                  header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
               
               /* }
                else{
                  $data['error']='Duplicate Record';                  
                }*/

              }
              else{
                $data['error']='Wrong combination';
              }

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
              $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
            
              $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');
            
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              //$this->load->view('Loading/loading');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
              $this->load->view('Home/footer');
              
            //VALIDATION FALSE
            }else{
              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
              $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
              
              $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');
            
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              //$this->load->view('Loading/loading');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
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

  function modify(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){

            $table='bill_of_material';
            $data['bill_of_material']=$this->bill_of_material_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'bom_id',$this->uri->segment(3));

           // echo $this->db->last_query();
            $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');
            
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
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

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->copy==1){

            $table='bill_of_material';
            $data['bill_of_material']=$this->bill_of_material_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'bom_id',$this->uri->segment(3));

           // echo $this->db->last_query();
            $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');
            
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/copy-form',$data);
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

  

    function update(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){

            $this->form_validation->set_rules('article_no','Product Code' ,'required|trim|xss_clean|callback_article_check|callback_tube_check');
            $this->form_validation->set_rules('sleeve_code','Sleeve Code' ,'required|trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('paper_film_code','Paper Film Code' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('print_type','Print Type' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('shoulder_code','Shoulder Code' ,'required|trim|xss_clean|callback_article_check');
            //$this->form_validation->set_rules('cap_code','Cap Code' ,'required|trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('label_code','Label Code' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('for_export','Packing Type' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('approval_authority','Approval Authority' ,'trim|xss_clean');



              if(!empty($this->input->post('article_no'))){
                $article_no=explode('//',$this->input->post('article_no'));
              }else{
                $article_no[1]='';
              }

              if(substr($article_no[1],0,2)=="PS" || substr($article_no[1],0,2)=="SR"){
                if(!empty($this->input->post('sleeve_code'))){
                $sleeve_code=explode('//',$this->input->post('sleeve_code'));
                }else{
                $sleeve_code[1]='';
                }

                if(substr($sleeve_code[1],0,3)!="SLV"){
                  $this->form_validation->set_rules('sleeve_code', 'Tube/Film Code', 'rule1',
                    array('rule1' => 'Please check Tube/Film Code')
                    );
                  
                }
              }

              if(substr($article_no[1],0,2)=="SP" || substr($article_no[1],0,2)=="SS"){
                if(!empty($this->input->post('sleeve_code'))){
                $sleeve_code=explode('//',$this->input->post('sleeve_code'));
                }else{
                $sleeve_code[1]='';
                }

                if(substr($sleeve_code[1],0,3)!="LMN"){
                  $this->form_validation->set_rules('sleeve_code', 'Tube/Film Code', 'rule1',
                    array('rule1' => 'Please check Tube/Film Code')
                    );
                  
                }
              }

              if(substr($article_no[1],0,2)=="SP" || substr($article_no[1],0,2)=="SS"){
                if(!empty($this->input->post('paper_film_code'))){
                $paper_film_code=explode('//',$this->input->post('paper_film_code'));
                }else{
                $paper_film_code[1]='';
                }

                if(substr($paper_film_code[1],0,2)!="RM"){
                  $this->form_validation->set_rules('paper_film_code', 'Paper Film Code', 'rule1',
                    array('rule1' => 'Please check Paper Film Code')
                    );
                  
                }
              }

             //--SHOULDER CHECK FOR TEAR OFF--------------------------
            $shld_type_id="";
            if(!empty($this->input->post('shoulder_code'))){
                $shoulder_code=explode('//',$this->input->post('shoulder_code'));
              }else{
                $shoulder_code[1]='';
              }
              if($shoulder_code[1]!=''){
                $shoulder_specification_sheet=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$shoulder_code[1]);
                $spec_id='';
                $spec_version_no='';
                foreach($shoulder_specification_sheet as $shoulder_specification_sheet_row){
                    $spec_id=$shoulder_specification_sheet_row->spec_id;
                    $spec_version_no=$shoulder_specification_sheet_row->spec_version_no;                    
                }
                $data= array('spec_id' =>$spec_id,'spec_version_no'=>$spec_version_no);                
                $shoulder_specification_sheet_details=$this->sales_order_book_model->select_shoulder_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data);
                // echo $this->db->last_query();
                $shoulder_type='';
                $shoulder_orifice='';
                foreach($shoulder_specification_sheet_details as $shoulder_specification_sheet_details_row){
                  $shoulder_type=$shoulder_specification_sheet_details_row->SHOULDER_STYLE;
                  $shoulder_orifice=$shoulder_specification_sheet_details_row->SHOULDER_ORIFICE;

                }
                $data['shoulder_types_master']=$this->common_model->select_one_active_record('shoulder_types_master',$this->session->userdata['logged_in']['company_id'],'shoulder_type',$shoulder_type);
                //echo $this->db->last_query();
                if($data['shoulder_types_master']==FALSE){
                  $shld_type_id="";
                }else{
                 foreach($data['shoulder_types_master'] as $shoulder_types_master_row){
                  $shld_type_id=$shoulder_types_master_row->shld_type_id;
                 }
                }
               

              }

              // if($shld_type_id!='' && $shld_type_id!='4'){

              //    $this->form_validation->set_rules('cap_code','Cap Code' ,'required|trim|xss_clean|callback_article_check');

              // }



            //VALIDATION TRUE
            if($this->form_validation->run()){

              if(!empty($this->input->post('article_no'))){
                $article_no=explode('//',$this->input->post('article_no'));
              }else{
                $article_no[1]='';
              }

              if(!empty($this->input->post('sleeve_code'))){
                $sleeve_code=explode('//',$this->input->post('sleeve_code'));
              }else{
                $sleeve_code[1]='';
              }

              if(!empty($this->input->post('paper_film_code'))){
                $paper_film_code=explode('//',$this->input->post('paper_film_code'));
              }else{
                $paper_film_code[1]='';
              }
        
              if(!empty($this->input->post('shoulder_code'))){
                $shoulder_code=explode('//',$this->input->post('shoulder_code'));
              }else{
                $shoulder_code[1]='';
              }
              if(!empty($this->input->post('cap_code'))){
                $cap_code=explode('//',$this->input->post('cap_code'));
              }else{
                $cap_code[1]='';
              }
              if(!empty($this->input->post('label_code'))){
                $label_code=explode('//',$this->input->post('label_code'));
              }else{
                $label_code[1]='';
              }
              //--SLEEVE----------------------------------
              if($sleeve_code[1]!=''){
                $sleeve_specification_sheet=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$sleeve_code[1]);
                $spec_id='';
                $spec_version_no='';
                foreach($sleeve_specification_sheet as $sleeve_specification_sheet_row){
                    $spec_id=$sleeve_specification_sheet_row->spec_id;
                    $spec_version_no=$sleeve_specification_sheet_row->spec_version_no;                    
                }
                $data= array('spec_id' =>$spec_id,'spec_version_no'=>$spec_version_no);                
                $sleeve_specification_sheet_details=$this->sales_order_book_model->select_sleeve_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data);
                //echo $this->db->last_query();

                $sleeve_dia='';
                foreach($sleeve_specification_sheet_details as $sleeve_specification_sheet_details_row){
                  $sleeve_dia=$sleeve_specification_sheet_details_row->SLEEVE_DIA;

                }

                $data['sleeve_diameter_master']=$this->common_model->select_one_active_record('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id'],'sleeve_diameter',$sleeve_dia);
                //echo $this->db->last_query();
                if($data['sleeve_diameter_master']==FALSE){
                  $sleeve_dia_id="";
                }else{
                 foreach($data['sleeve_diameter_master'] as $sleeve_diameter_master_row){
                  $sleeve_dia_id=$sleeve_diameter_master_row->sleeve_id;
                 }
                }


              }
        
              //--Paper Film Code----------------------------------
              if($paper_film_code[1]!=''){
                $sleeve_specification_sheet=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$paper_film_code[1]);
                $spec_id='';
                $spec_version_no='';
                foreach($sleeve_specification_sheet as $sleeve_specification_sheet_row){
                    $spec_id=$sleeve_specification_sheet_row->spec_id;
                    $spec_version_no=$sleeve_specification_sheet_row->spec_version_no;                    
                }
                $data= array('spec_id' =>$spec_id,'spec_version_no'=>$spec_version_no);                
                $sleeve_specification_sheet_details=$this->sales_order_book_model->select_sleeve_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data);
                //echo $this->db->last_query();

                $sleeve_dia='';
                foreach($sleeve_specification_sheet_details as $sleeve_specification_sheet_details_row){
                  $sleeve_dia=$sleeve_specification_sheet_details_row->SLEEVE_DIA;

                }

                $data['sleeve_diameter_master']=$this->common_model->select_one_active_record('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id'],'sleeve_diameter',$sleeve_dia);
                //echo $this->db->last_query();
                if($data['sleeve_diameter_master']==FALSE){
                  $sleeve_dia_id="";
                }else{
                 foreach($data['sleeve_diameter_master'] as $sleeve_diameter_master_row){
                  $sleeve_dia_id=$sleeve_diameter_master_row->sleeve_id;
                 }
                }


              }
              //--SHOULDER--------------------------
              if($shoulder_code[1]!=''){
                $shoulder_specification_sheet=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$shoulder_code[1]);
                $spec_id='';
                $spec_version_no='';
                foreach($shoulder_specification_sheet as $shoulder_specification_sheet_row){
                    $spec_id=$shoulder_specification_sheet_row->spec_id;
                    $spec_version_no=$shoulder_specification_sheet_row->spec_version_no;                    
                }
                $data= array('spec_id' =>$spec_id,'spec_version_no'=>$spec_version_no);                
                $shoulder_specification_sheet_details=$this->sales_order_book_model->select_shoulder_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data);
                // echo $this->db->last_query();
                $shoulder_type='';
                $shoulder_orifice='';
                foreach($shoulder_specification_sheet_details as $shoulder_specification_sheet_details_row){
                  $shoulder_type=$shoulder_specification_sheet_details_row->SHOULDER_STYLE;
                  $shoulder_orifice=$shoulder_specification_sheet_details_row->SHOULDER_ORIFICE;

                }
                $data['shoulder_types_master']=$this->common_model->select_one_active_record('shoulder_types_master',$this->session->userdata['logged_in']['company_id'],'shoulder_type',$shoulder_type);
                //echo $this->db->last_query();
                if($data['shoulder_types_master']==FALSE){
                  $shld_type_id="";
                }else{
                 foreach($data['shoulder_types_master'] as $shoulder_types_master_row){
                  $shld_type_id=$shoulder_types_master_row->shld_type_id;
                 }
                }
                $data['shoulder_orifice_master']=$this->common_model->select_one_active_record('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id'],'shoulder_orifice',$shoulder_orifice);
                //echo $this->db->last_query();
                if($data['shoulder_orifice_master']==FALSE){
                  $orifice_id="";
                }else{
                 foreach($data['shoulder_orifice_master'] as $shoulder_orifice_master_row){
                  $orifice_id=$shoulder_orifice_master_row->orifice_id;
                 }
                }

              }
              //--CAP--------------------------

                $cap_dia='';
                $cap_type='';
                $cap_finish='';
                $cap_orifice='';
                
                $cap_dia_id='';
                $cap_orifice_id='';
                $cap_type_id='';
                $cap_finish_id='';


              if($cap_code[1]!=''){

                $cap_specification_sheet=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$cap_code[1]);
                $spec_id='';
                $spec_version_no='';
                foreach($cap_specification_sheet as $cap_specification_sheet_row){
                    $spec_id=$cap_specification_sheet_row->spec_id;
                    $spec_version_no=$cap_specification_sheet_row->spec_version_no;                    
                }

                $data= array('spec_id' =>$spec_id,'spec_version_no'=>$spec_version_no);                
                $cap_specification_sheet_details=$this->sales_order_book_model->select_cap_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data);


                

                foreach($cap_specification_sheet_details as $cap_specification_sheet_details_row){
                  $cap_dia = $cap_specification_sheet_details_row->CAP_DIA;
                  $cap_type = $cap_specification_sheet_details_row->CAP_STYLE;
                  $cap_finish = $cap_specification_sheet_details_row->CAP_MOLD_FINISH;
                  $cap_orifice = $cap_specification_sheet_details_row->CAP_ORIFICE;                 
                }

                $data['cap_diameter_master']=$this->common_model->select_one_active_record('cap_diameter_master',$this->session->userdata['logged_in']['company_id'],'cap_dia',$cap_dia);
                //echo $this->db->last_query();
                if($data['cap_diameter_master']==FALSE){
                  $cap_dia_id="";
                }else{
                  foreach($data['cap_diameter_master'] as $cap_diameter_master_row){
                    $cap_dia_id=$cap_diameter_master_row->cap_dia_id;
                  }
                }

                $data['cap_orifice_master']=$this->common_model->select_one_active_record('cap_orifice_master',$this->session->userdata['logged_in']['company_id'],'cap_orifice',$cap_orifice);
                if($data['cap_orifice_master']==FALSE){
                  $cap_orifice_id="";
                }else{
                  foreach($data['cap_orifice_master'] as $cap_orifice_master_row){
                    $cap_orifice_id=$cap_orifice_master_row->cap_orifice_id;
                  }
                }

                $data['cap_types_master']=$this->common_model->select_one_active_record('cap_types_master',$this->session->userdata['logged_in']['company_id'],'cap_type',$cap_type);
                if($data['cap_types_master']==FALSE){
                  $cap_type_id="";
                }else{
                  foreach($data['cap_types_master'] as $cap_types_master_row){
                    $cap_type_id=$cap_types_master_row->cap_type_id;
                  }
                }
                $data['cap_finish_master']=$this->common_model->select_one_active_record('cap_finish_master',$this->session->userdata['logged_in']['company_id'],'cap_finish',$cap_finish);
                if($data['cap_finish_master']==FALSE){
                  $cap_finish_id="";
                }else{
                    foreach($data['cap_finish_master'] as $cap_finish_master_row){
                      $cap_finish_id=$cap_finish_master_row->cap_finish_id;
                    }
                }

              }

              //--SHOULDER DEPENDANCY CHECK-----------------------------

              $combination_data_arr=array('sleeve_id'=>$sleeve_dia_id,
              'shld_type_id'=>$shld_type_id,
              'shld_orifice_id'=>$orifice_id,
              'cap_dia_id'=>$cap_dia_id,
              'cap_orifice_id'=>$cap_orifice_id,
              'cap_type_id'=>$cap_type_id,
              'cap_finish_id'=>$cap_finish_id);

              $combination_data=array_filter($combination_data_arr);

              $this->load->model('shoulder_orifice_dependancy_model');
              $shoulder_orifice_dependancy=$this->shoulder_orifice_dependancy_model->select_one_active_combination_record('shoulder_orifice_dependancy',$this->session->userdata['logged_in']['company_id'],$combination_data);
             
              if($this->shoulder_orifice_dependancy_model->select_one_active_combination_record('shoulder_orifice_dependancy',$this->session->userdata['logged_in']['company_id'],$combination_data)>0){
              
                  if($sleeve_code[1] != ''){
                      $sleeve = $sleeve_code[1];
                  }else{
                      $sleeve = $paper_film_code[1];
                  }       
                //--DUPLICATE CHECK---------------------------
                $data = array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                               'article_no'=>$article_no[1],
                               'sleeve_code'=>$sleeve,
                               'shoulder_code'=>$shoulder_code[1],
                               'cap_code'=>$cap_code[1],
                               'label_code'=>$label_code[1],
                               'archive'=>'0',
                               'for_export'=>$this->input->post('for_export'),
                               'print_type'=>$this->input->post('print_type'),
                               'comment'=>$this->input->post('comment'),
                              );

                $bill_of_material=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data); 

               
                if(count($bill_of_material)==0){

                  $data= array(
                               'sleeve_code'=>$sleeve,
                               'shoulder_code'=>$shoulder_code[1],
                               'cap_code'=>$cap_code[1],
                               'label_code'=>$label_code[1],
                               'for_export'=>$this->input->post('for_export'),
                               'comment'=>$this->input->post('comment'),
                               'print_type'=>$this->input->post('print_type')                             
                             );

                

                  $result=$this->common_model->update_one_active_record('bill_of_material',$data,'bom_id',$this->input->post('bom_id'),$this->session->userdata['logged_in']['company_id']);

                   //echo $this->db->last_query();   

                   if(!empty($this->input->post('approval_authority'))){

                    $data=array('pending_flag'=>'1');

                    $result=$this->common_model->update_one_active_record('bill_of_material',$data,'bom_id',$this->input->post('bom_id'),$this->session->userdata['logged_in']['company_id']);

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
                        'form_id'=>'791',
                        'transaction_no'=>$transaction_no,
                        'status'=>$status,
                        'followup_date'=>date('Y-m-d'),
                        'contact_person_id'=>$this->session->userdata['logged_in']['user_id'],
                        'record_no'=>$this->input->post('record_no'));

                      $result=$this->common_model->save('followup',$data);

                      $data['error']='Sent for approval';
                      header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                  }  
                               

                  $data['note']='Update Transaction Completed';
                  header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                }
                else{
                  //$data['error']='Duplicate Record';

                  if(!empty($this->input->post('approval_authority'))){

                    $data=array('pending_flag'=>'1');

                    $result=$this->common_model->update_one_active_record('bill_of_material',$data,'bom_id',$this->input->post('bom_id'),$this->session->userdata['logged_in']['company_id']);

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
                        'form_id'=>'791',
                        'transaction_no'=>$transaction_no,
                        'status'=>$status,
                        'followup_date'=>date('Y-m-d'),
                        'contact_person_id'=>$this->session->userdata['logged_in']['user_id'],
                        'record_no'=>$this->input->post('record_no'));

                      $result=$this->common_model->save('followup',$data);
                      header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                      $data['note']='Sent for approval';
                      //header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                  }                  
                }

              }
              else{
                $data['error']='Wrong combination';
              }


              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

              $table='bill_of_material';
              $data['bill_of_material']=$this->bill_of_material_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'bom_id',$this->input->post('bom_id'));
              $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
              $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');
            
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              //$this->load->view('Loading/loading');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
              $this->load->view('Home/footer');
              
            //VALIDATION FALSE
            }else{

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

              $table='bill_of_material';
              $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
              
              $data['bill_of_material']=$this->bill_of_material_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'bom_id',$this->input->post('bom_id'));

              $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','985');

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              //$this->load->view('Loading/loading');
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




  function delete(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->delete==1){
            
            $data = array('archive' =>'1');
            $result=$this->common_model->archive_one_record('bill_of_material',$data,'bom_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

            $table='bill_of_material';
            $data['bill_of_material']=$this->bill_of_material_model->select_one_inactive_record($table,$this->session->userdata['logged_in']['company_id'],'bom_id',$this->uri->segment(3));


            $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
            $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

            $data['note']='Archive Transaction completed';
            header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());            

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
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


  function archive_records(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $table='bill_of_material';
            include('pagination_archive.php');
            $data['bill_of_material']=$this->bill_of_material_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

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

  function dearchive(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->dearchive==1){
            
            $data = array('archive' =>'0');
            $result=$this->common_model->archive_one_record('bill_of_material',$data,'bom_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

            $table='bill_of_material';
            $data['bill_of_material']=$this->bill_of_material_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'bom_id',$this->uri->segment(3));

            $data['page_name']='Sales';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
            $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

            $data['note']='Dearchive Transaction completed';
            header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
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

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

            $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);
             $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['sleeve_diameter_master']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['lacquer_types_master']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['shoulder_types_master']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['shoulder_orifice_master']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_diameter_master']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_types_master']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_orifice_master']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_finish_master']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);
            

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
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

              $this->form_validation->set_rules('from_date','From Date' ,'trim|xss_clean');
              $this->form_validation->set_rules('to_date','To Date' ,'trim|xss_clean');
              $this->form_validation->set_rules('bom_no','BOM No.' ,'trim|xss_clean');
              $this->form_validation->set_rules('bom_version_no','BOM Version No.' ,'trim|xss_clean|numeric');
              $this->form_validation->set_rules('article_no','Product Code' ,'trim|xss_clean|callback_article_check');
              $this->form_validation->set_rules('sleeve_code','Sleeve Code' ,'trim|xss_clean');
              $this->form_validation->set_rules('shoulder_code','Shoulder Code' ,'trim|xss_clean');
              $this->form_validation->set_rules('cap_code','Cap Code' ,'trim|xss_clean');
              $this->form_validation->set_rules('label_code','Label Code' ,'trim|xss_clean');
              $this->form_validation->set_rules('sleeve_dia','Sleeve Diameter' ,'xss_clean|strtoupper');
              $this->form_validation->set_rules('sleeve_length','Sleeve Length' ,'xss_clean|numeric');
              $this->form_validation->set_rules('layer_no','Sleeve layer' ,'xss_clean|is_natural_no_zero|max_length[2]');
              $this->form_validation->set_rules('sleeve_master_batch','Sleeve Master Batch' ,'xss_clean|strtoupper');
              $this->form_validation->set_rules('shoulder_type','Shoulder type' ,'xss_clean|strtoupper');
              $this->form_validation->set_rules('shoulder_orifice','Shoulder Orifice' ,'xss_clean|strtoupper');
              $this->form_validation->set_rules('cap_dia','Cap Dia' ,'xss_clean|strtoupper');
              $this->form_validation->set_rules('cap_type','Cap Type' ,'xss_clean|strtoupper');
              $this->form_validation->set_rules('cap_orifice','Cap Orifice' ,'xss_clean|strtoupper');
              $this->form_validation->set_rules('cap_finish','Cap finish' ,'xss_clean|strtoupper');

              $this->form_validation->set_rules('for_export','Box Type' ,'trim|xss_clean');
              $this->form_validation->set_rules('bom_type','Bom Type' ,'trim|xss_clean');

              if(!empty($this->input->post('sleeve_master_batch'))){
                    if($this->input->post('sleeve_layer_no')==''){
                       $this->form_validation->set_rules('sleeve_layer_no','Layer Position' ,'required|xss_clean|is_natural_no_zero|max_length[2]');                     
                    }                   
              }

              //if($this->form_validation->run()){

              if(!empty($this->input->post('from_date'))){
                 $from=$this->common_model->change_date_format($this->input->post('from_date'),$this->session->userdata['logged_in']['company_id']);
              }else{
                $from='';
              }
              if(!empty($this->input->post('to_date'))){
                 $to=$this->common_model->change_date_format($this->input->post('to_date'),$this->session->userdata['logged_in']['company_id']);
              }else{
                $to='';
              }                

              if(!empty($this->input->post('article_no'))){
              $article_no=explode('//',$this->input->post('article_no'));
              }else{
                $article_no[1]='';
                $article_no[0]='';
              }

              if(!empty($this->input->post('sleeve_code'))){
                $sleeve_code=explode('//',$this->input->post('sleeve_code'));
              }else{
                $sleeve_code[1]='';
                $sleeve_code[0]='';
              }
              if(!empty($this->input->post('shoulder_code'))){
                $shoulder_code=explode('//',$this->input->post('shoulder_code'));
              }else{
                $shoulder_code[1]='';
                $shoulder_code[0]='';
              }
              if(!empty($this->input->post('cap_code'))){
                $cap_code=explode('//',$this->input->post('cap_code'));
              }else{
                $cap_code[1]='';
                $cap_code[0]='';
              }
              if(!empty($this->input->post('label_code'))){
                $label_code=explode('//',$this->input->post('label_code'));
              }else{
                $label_code[1]='';
                $label_code[0]='';
              }

              if(!empty($this->input->post('sleeve_master_batch'))){
                  $sleeve_master_batch=explode('//',$this->input->post('sleeve_master_batch'));                   
              }else{
                $sleeve_master_batch[1]='';
                $sleeve_master_batch[0]='';
              }

              $flag=$this->input->post('bom_type');


              

              $arr= array( 'bom_no'=>$this->input->post('bom_no'),
                           'bom_version_no'=>$this->input->post('bom_version_no'),  
                           'bill_of_material.article_no'=>$article_no[1],
                           'sleeve_code'=>$sleeve_code[1],
                           'shoulder_code'=>$shoulder_code[1],
                           'cap_code'=>$cap_code[1],
                           'label_code'=>$label_code[1],
                           'final_approval_flag'=>$this->input->post('final_approval_flag'),
                           'bill_of_material.user_id'=>$this->input->post('user_id'),
                           'print_type' =>$this->input->post('print_type'),
                           'for_export'=>$this->input->post('for_export')                             
                          );

              $data=array_filter($arr,'strlen');
              //print_r($data);


              $search_arr = array(

                              'sleeve_diameter' =>$this->input->post('sleeve_dia'),
                              'sleeve_length' =>$this->input->post('sleeve_length'),
                              'sleeve_master_batch_'.$this->input->post('sleeve_layer_no') =>$sleeve_master_batch[1],
                              'shoulder_type' =>$this->input->post('shoulder_type'),
                              'shoulder_orifice' =>$this->input->post('shoulder_orifice'),
                              'cap_dia' =>$this->input->post('cap_dia'),
                              'cap_type' =>$this->input->post('cap_type'),
                              'cap_orifice' =>$this->input->post('cap_orifice'),
                              'cap_finish' =>$this->input->post('cap_finish'),
                              'layer_no'=>$this->input->post('layer_no') 
                            );


              $search=array_filter($search_arr);                

              if(empty($data) && empty($search)){

                $this->form_validation->set_rules('from_date','From Date' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('to_date','To Date' ,'required|trim|xss_clean');

              }

              // VALIDATION CHECK-------------
              if($this->form_validation->run()){


                $table='bill_of_material';                
                $data['bill_of_material']=$this->bill_of_material_model->active_records_search($table,$this->session->userdata['logged_in']['company_id'],$data,$from,$to,$flag);

               //echo $this->db->last_query();
                 

                $data['page_name']='Sales';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);
                 $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
                $data['sleeve_diameter_master']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['lacquer_types_master']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
                $data['shoulder_types_master']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
                $data['shoulder_orifice_master']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
                $data['cap_types_master']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
                $data['cap_diameter_master']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['cap_orifice_master']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);
                $data['cap_finish_master']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
                $this->load->view('Home/footer');


              }else{ // VALIDATION FALSE----------------

                $data['page_name']='Sales';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);
                 $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
                $data['sleeve_diameter_master']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['lacquer_types_master']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
                $data['shoulder_types_master']=$this->common_model->select_active_drop_down('shoulder_types_master',$this->session->userdata['logged_in']['company_id']);
                $data['shoulder_orifice_master']=$this->common_model->select_active_drop_down('shoulder_orifice_master',$this->session->userdata['logged_in']['company_id']);
                $data['cap_diameter_master']=$this->common_model->select_active_drop_down('cap_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['cap_types_master']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
                $data['cap_orifice_master']=$this->common_model->select_active_drop_down('cap_orifice_master',$this->session->userdata['logged_in']['company_id']);
                $data['cap_finish_master']=$this->common_model->select_active_drop_down('cap_finish_master',$this->session->userdata['logged_in']['company_id']);

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                //$this->load->view('Loading/loading');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
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

  public function tube_check($str){
    $sleeve_code     = $this->input->post('sleeve_code');
    //echo "<br/>";
     $paper_film_code = $this->input->post('paper_film_code');


      if($paper_film_code=='' && $sleeve_code==''){
        //echo '1';
         $this->form_validation->set_message('tube_check', 'Please select either film code or paper code.');
        return FALSE;
      }else if($paper_film_code!='' && $sleeve_code!=''){
        //echo "2";
         $this->form_validation->set_message('tube_check', 'Film and Paper code, Both can not be processed at same time');
        return FALSE;
      }else{

        //echo "DONE";
        return TRUE;
      }     
    }






}