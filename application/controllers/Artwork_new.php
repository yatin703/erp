<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Artwork_new extends CI_Controller {

  function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('artwork_model');
      $this->load->model('customer_model');
      $this->load->model('article_model');
      $this->load->model('second_sub_group_model');
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
            $table='artwork_devel_master';
            include('pagination.php');
            $data['artwork']=$this->artwork_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

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
            $data['artwork']=$this->artwork_model->select_one_active_record('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'artwork_devel_master.ad_id',$this->uri->segment(3),'artwork_devel_master.version_no',$this->uri->segment(4));

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



  function xml(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $data['artwork']=$this->artwork_model->select_one_active_record('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'artwork_devel_master.ad_id',$this->uri->segment(3),'artwork_devel_master.version_no',$this->uri->segment(4));

           foreach($data['artwork'] as $artwork_row){

            $result_dia=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','1');
            if($result_dia==FALSE){
              $dia="";
            }else{
              foreach($result_dia as $dia_row){ $dia=$dia_row->parameter_value; }
            }

          $result_length=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','2');

           if($result_length==FALSE){
              $length="";
            }else{
              foreach($result_length as $length_row){ $length=$length_row->parameter_value; } 
            }

          $result_sleeve_color=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','7');

          if($result_sleeve_color==FALSE){
              $sleeve_color="";
            }else{
              foreach($result_sleeve_color as $sleeve_color_row){ $sleeve_color=$sleeve_color_row->parameter_value; }
            }

          $result_print_type=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','17');

          if($result_print_type==FALSE){
              $print_type="";
            }else{
              foreach($result_print_type as $print_type_row){ $print_type=$print_type_row->parameter_value; }
            }


         $result_printing_upto_neck=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','8');

         if($result_printing_upto_neck==FALSE){
              $printing_upto_neck="";
            }else{
              foreach($result_printing_upto_neck as $printing_upto_neck_row){ $printing_upto_neck=$printing_upto_neck_row->parameter_value; }
            }

          $result_hot_foil=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','11');

          if($result_hot_foil==FALSE){
              $hot_foil="";
            }else{
              foreach($result_hot_foil as $hot_foil_row){
                    $hot_foil=substr($hot_foil_row->parameter_value,strpos($hot_foil_row->parameter_value, "||") + 2);
                    $hot_foil=strtoupper(str_replace("^"," + ",$hot_foil));
                    } 
            }

          $result_lacquer_type=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_row->ad_id,'version_no',$artwork_row->version_no,'artwork_para_id','12');

          if($result_lacquer_type==FALSE){
              $lacquer_type="";
            }else{
              foreach($result_lacquer_type as $lacquer_row){
                    $lacquer=substr($lacquer_row->parameter_value,strpos($lacquer_row->parameter_value, "||") + 2);
                    $lacquer_type=strtoupper(str_replace("^"," + ",$lacquer));
                    }
            }


            $xmlString ='<?xml version="1.0" encoding="UTF-8"?>
                            <parent>
                            <child>
                              <adr_date>'.$artwork_row->ad_date.'</adr_date>
                              <saw_id>'.str_replace('AW','AW00',$artwork_row->ad_id).'</saw_id>
                              <revision>'.$artwork_row->version_no.'</revision>
                              <customer_name>'.$artwork_row->customer_name.'</customer_name>
                              <article_code>'.$artwork_row->article_no.'</article_code>
                              <article_name>'.$artwork_row->article_name.'</article_name>
                              <dia>'.$dia.'</dia>
                              <tube_length>'.$length.'</tube_length>
                              <substrate_colour>'.$sleeve_color.'</substrate_colour>
                              <print_type>'.$print_type.'</print_type>
                              <print_upto_neck>'.$printing_upto_neck.'</print_upto_neck>
                              <hot_foil>'.$hot_foil.'</hot_foil>
                              <lacquer>'.$lacquer_type.'</lacquer>
                              </child>
                            </parent>';

                  

           }

           header('Content-type: text/xml');
                  header('Content-Disposition: attachment; filename="'.str_replace('AW','AW00',$artwork_row->ad_id).'_R'.$artwork_row->version_no.'.xml"');
                  echo $xmlString;
           
            //$this->load->view('Print/header',$data);
            //$this->load->view(ucwords($this->router->fetch_class()).'/view-form',$data);
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


  function create(){


    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['hot_foil']=$this->article_model->spec_all_active_record_search_foil('article','71',$this->session->userdata['logged_in']['company_id']);
           // echo $this->db->last_query();
            $data['lacquer']=$this->article_model->spec_all_active_record_search('article','14',$this->session->userdata['logged_in']['company_id']);
            $data['second_sub_group']=$this->second_sub_group_model->select_active_drop_down('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
            $data['cold_foil']=$this->article_model->spec_all_active_record_search_cold_foil('article','304',$this->session->userdata['logged_in']['company_id']);
            
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
            $this->form_validation->set_rules('version_no','Version No' ,'required|trim|xss_clean|numeric');
            $this->form_validation->set_rules('sleeve_dia','Sleeve Dia' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sleeve_length','Sleeve Length' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sleeve_color','Sleeve Color' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('print_type','Print Type' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('printing_upto_neck','Printing Upto Neck' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('screen_ink','Screen Ink' ,'trim|xss_clean|decimal');
            $this->form_validation->set_rules('offset_ink','Offset Ink' ,'trim|xss_clean|decimal');
            $this->form_validation->set_rules('flexo_ink','Flexo Ink' ,'trim|xss_clean|decimal');
            $this->form_validation->set_rules('special_ink','Special Ink' ,'trim|xss_clean|decimal');
            $this->form_validation->set_rules('sealing_non_lacquering_area','Sealing Non Lacquering Area' ,'required|trim|xss_clean|numeric');

            $this->form_validation->set_rules('hot_foil_1','Hot Foil 1' ,'trim|xss_clean');
            if(!empty($this->input->post('hot_foil_1'))){
              $this->form_validation->set_rules('hot_foil_1_per_tube','Hot Foil 1 SQM/Tube' ,'trim|xss_clean|decimal');
            }
            

            $this->form_validation->set_rules('hot_foil_2','Hot Foil 2' ,'trim|xss_clean');
            if(!empty($this->input->post('hot_foil_2'))){
            $this->form_validation->set_rules('hot_foil_2_per_tube','Hot Foil 2 SQM/Tube' ,'trim|xss_clean|decimal');
            }

            $this->form_validation->set_rules('lacquer_type_1','Lacquer 1' ,'required|trim|xss_clean');
            if(!empty($this->input->post('lacquer_type_1'))){
            $this->form_validation->set_rules('lacquer_mixing_pc_1','Lacquer 1 Mixing %' ,'required|trim|xss_clean|numeric|callback_lcq_per_check');
            }

            $this->form_validation->set_rules('lacquer_type_2','Lacquer 2' ,'trim|xss_clean');
            if(!empty($this->input->post('lacquer_type_2'))){
            $this->form_validation->set_rules('lacquer_mixing_pc_2','Lacquer 2 Mixing %' ,'required|trim|xss_clean|numeric|callback_lcq_per_check');
            }

            if($this->form_validation->run()==FALSE){
              
              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
              $data['hot_foil']=$this->article_model->spec_all_active_record_search_foil('article','71',$this->session->userdata['logged_in']['company_id']);
              $data['lacquer']=$this->article_model->spec_all_active_record_search('article','14',$this->session->userdata['logged_in']['company_id']);
              $data['cold_foil']=$this->article_model->spec_all_active_record_search_cold_foil('article','304',$this->session->userdata['logged_in']['company_id']);
            
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
              $this->load->view('Home/footer');
            }else{

              if(!empty($this->input->post('customer'))){
                $customer_arr=explode('//',$this->input->post('customer'));
              }

              if(!empty($this->input->post('article_no'))){
                $article_no_arr=explode('//',$this->input->post('article_no'));
              }

              $data['version']=$this->artwork_model->select_artwork_verion_no('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'article_no',$article_no_arr[1]);
              foreach ($data['version'] as $version_row) {

                if($version_row->version_no==NULL){
                  $max_pkey=0;
                  $result=$this->common_model->select_max_pkey('artwork_devel_master','ad_id',$this->session->userdata['logged_in']['company_id']); 
                  foreach($result as $row){
                    $max_pkey=$row->ad_id;
                    $max_pkey=substr($max_pkey,2);
                    $max_pkey=$max_pkey+1;
                    $artwork_no=str_pad($max_pkey,4,0,STR_PAD_LEFT);
                    $artwork_no="AW".$artwork_no;
                  }
                  $version_no=1;
                }else{
                  $version_no=$version_row->version_no;
                  $artwork_no=$version_row->ad_id;
                }
              }

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                    'ad_id'=>$artwork_no,
                    'version_no'=>$version_no,
                    'ad_date'=>date('Y-m-d'),
                    'adr_company_id'=>$customer_arr[1],
                    'article_no'=>$article_no_arr[1],
                    'pending_flag'=>'0',
                    'final_approval_flag'=>'0',
                    'user_id'=>$this->session->userdata['logged_in']['user_id'],
                    'archive'=>'0'
                    );

              $result=$this->common_model->save('artwork_devel_master',$data);

              

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'1','parameter_value'=>$this->input->post('sleeve_dia'),'flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'2','parameter_value'=>$this->input->post('sleeve_length'),'flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'3','parameter_value'=>'','flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'4','parameter_value'=>'','flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'5','parameter_value'=>$this->input->post('sealing_non_lacquering_area'),'flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'6','parameter_value'=>'','flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'7','parameter_value'=>$this->input->post('sleeve_color'),'flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'8','parameter_value'=>$this->input->post('printing_upto_neck'),'flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'9','parameter_value'=>'||','flag_multiple'=>'1');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'10','parameter_value'=>'||','flag_multiple'=>'1');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'19','parameter_value'=>$this->input->post('screen_ink'),'flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'20','parameter_value'=>$this->input->post('flexo_ink'),'flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'21','parameter_value'=>$this->input->post('offset_ink'),'flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'22','parameter_value'=>$this->input->post('special_ink'),'flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'23','parameter_value'=>$this->input->post('hot_foil_1'),'flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'24','parameter_value'=>$this->input->post('hot_foil_1_per_tube'),'flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'25','parameter_value'=>$this->input->post('hot_foil_2'),'flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'26','parameter_value'=>$this->input->post('hot_foil_2_per_tube'),'flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'27','parameter_value'=>$this->input->post('lacquer_type_1'),'flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'28','parameter_value'=>$this->input->post('lacquer_mixing_pc_1'),'flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'29','parameter_value'=>$this->input->post('lacquer_type_2'),'flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'30','parameter_value'=>$this->input->post('lacquer_mixing_pc_2'),'flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'13','parameter_value'=>'','flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'14','parameter_value'=>'','flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'15','parameter_value'=>'','flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'16','parameter_value'=>'','flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'17','parameter_value'=>$this->input->post('print_type'),'flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'18','parameter_value'=>'||','flag_multiple'=>'1');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                    'ad_id'=>$artwork_no,
                    'version_no'=>$version_no,
                    'lang_comments'=>'',
                    'language_id'=>$this->session->userdata['logged_in']['language_id']
                    );
              $result=$this->common_model->save('artwork_devel_master_lang',$data);

              /*

              $data['employee']=$this->common_model->select_one_active_record('employee_master',$this->session->userdata['logged_in']['company_id'],'employee_id',$this->session->userdata['logged_in']['user_id']);

                      foreach ($data['employee'] as $employee_row) {
                        $config['protocol'] = 'smtp';
                        $config['smtp_host'] = 'ssl://smtp.googlemail.com';
                        $config['smtp_port'] = 465;
                        $this->load->library('email', $config);
                        $this->email->from($employee_row->mailbox);
                        $this->email->to("graphic@3dpackaging.in");
                        $this->email->cc($employee_row->mailbox);
                        $this->email->subject("ADR for ".$artwork_no."_R".$version_no);
                        $this->email->message("Dear Graphics Team, We have created subjected ADR in System, Please provide artwork PDF for Customer Approval");

                        if ($this->email->send()) {
                          $data['note']='Create Transaction Completed';
                        } 
                  }
              */

              $data['note']='Create Transaction Completed';

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

              $data['note']='Create Transaction Completed';
              header("refresh:0;url=".base_url()."index.php/".$this->router->fetch_class());

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
              $data['hot_foil']=$this->article_model->spec_all_active_record_search_foil('article','71',$this->session->userdata['logged_in']['company_id']);
              $data['lacquer']=$this->article_model->spec_all_active_record_search('article','14',$this->session->userdata['logged_in']['company_id']);
              $data['cold_foil']=$this->article_model->spec_all_active_record_search_cold_foil('article','304',$this->session->userdata['logged_in']['company_id']);
            
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

  // public function customer_check($str){
  //   if(!empty($str)){
  //   $customer_code=explode('//',$str);
  //   if(!empty($customer_code[1])){
  //   $data['customer']=$this->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'name1',$customer_code[0]);
  //   //echo $this->db->last_query();
  //   foreach ($data['customer'] as $customer_row) {

  //     if ($customer_row->adr_company_id == $customer_code[1]){
  //       return TRUE;
  //     }else{
  //       $this->form_validation->set_message('customer_check', 'The {field} field is incorrect');
  //       return FALSE;
  //       }
  //     } 
  //   }else{
  //       $this->form_validation->set_message('customer_check', 'The {field} field is incorrect');
  //       return FALSE;
  //       }
  //   } 
  // }

    public function customer_check($str){
    if(!empty($str)){
    $customer_code=explode('//',$str);
    if(!empty($customer_code[1])){
      $data=array('address_master.adr_company_id'=>$customer_code[1],
        'address_master.name1'=>$customer_code[0]);
    $data['customer']=$this->customer_model->active_record_search('address_master',$data,$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
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
  

  public function article_check($str){
    if(!empty($str)){
    $item_code=explode('//',$str);
    if(!empty($item_code[1])){
    $data['item']=$this->common_model->select_one_active_record_nonlanguage_without_archive('article_name_info',$this->session->userdata['logged_in']['company_id'],'article_no',$item_code[1]);
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
            $table='artwork_devel_master';
            include('pagination_archive.php');
            $data['artwork']=$this->artwork_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
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


  function modify(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){

            $data['artwork']=$this->artwork_model->select_one_active_record('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'artwork_devel_master.ad_id',$this->uri->segment(3),'artwork_devel_master.version_no',$this->uri->segment(4));
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['hot_foil']=$this->article_model->spec_all_active_record_search_foil('article','71',$this->session->userdata['logged_in']['company_id']);
            $data['lacquer']=$this->article_model->spec_all_active_record_search('article','14',$this->session->userdata['logged_in']['company_id']);
            $data['cold_foil']=$this->article_model->spec_all_active_record_search_cold_foil('article','304',$this->session->userdata['logged_in']['company_id']);
            
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
              $this->form_validation->set_rules('version_no','Version No' ,'required|trim|xss_clean|numeric');
              $this->form_validation->set_rules('sleeve_dia','Sleeve Dia' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sleeve_length','Sleeve Length' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sleeve_color','Sleeve Color' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('print_type','Print Type' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('printing_upto_neck','Printing Upto Neck' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('sealing_non_lacquering_area','Sealing Non Lacquering Area' ,'required|trim|xss_clean');

              $this->form_validation->set_rules('hot_foil_1','Hot Foil 1' ,'trim|xss_clean');
              if(!empty($this->input->post('hot_foil_1'))){
                $this->form_validation->set_rules('hot_foil_1_per_tube','Hot Foil 1 SQM/Tube' ,'trim|xss_clean|decimal');
              }
              

              $this->form_validation->set_rules('hot_foil_2','Hot Foil 2' ,'trim|xss_clean');
              if(!empty($this->input->post('hot_foil_2'))){
              $this->form_validation->set_rules('hot_foil_2_per_tube','Hot Foil 2 SQM/Tube' ,'trim|xss_clean|decimal');
              }

              $this->form_validation->set_rules('lacquer_type_1','Lacquer 1' ,'required|trim|xss_clean');
              if(!empty($this->input->post('lacquer_type_1'))){
              $this->form_validation->set_rules('lacquer_mixing_pc_1','Lacquer 1 Mixing %' ,'required|trim|xss_clean|numeric|callback_lcq_per_check');
              }

              $this->form_validation->set_rules('lacquer_type_2','Lacquer 2' ,'trim|xss_clean');
              if(!empty($this->input->post('lacquer_type_2'))){
              $this->form_validation->set_rules('lacquer_mixing_pc_2','Lacquer 2 Mixing %' ,'required|trim|xss_clean|numeric|callback_lcq_per_check');
              }
              

              if($this->form_validation->run()==FALSE){

                $data['artwork']=$this->artwork_model->select_one_active_unapproved_record('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'artwork_devel_master.ad_id',$this->input->post('artwork_no'),'artwork_devel_master.version_no',$this->input->post('version_no'));
                $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
                $data['hot_foil']=$this->article_model->spec_all_active_record_search_foil('article','71',$this->session->userdata['logged_in']['company_id']);
                $data['lacquer']=$this->article_model->spec_all_active_record_search('article','14',$this->session->userdata['logged_in']['company_id']);
                $data['cold_foil']=$this->article_model->spec_all_active_record_search_cold_foil('article','304',$this->session->userdata['logged_in']['company_id']);
            
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
                $this->load->view('Home/footer');

              }else{

                if(!empty($this->input->post('customer'))){
                  $customer_arr=explode('//',$this->input->post('customer'));
                }

                $data=array('adr_company_id'=>$customer_arr[1]);

                $result=$this->artwork_model->update_one_active_record('artwork_devel_master',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),$this->session->userdata['logged_in']['company_id']);

                $data=array('parameter_value'=>$this->input->post('sleeve_dia'));

                $result=$this->artwork_model->update_details_record_where('artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','1',$this->session->userdata['logged_in']['company_id']);

                $data=array('parameter_value'=>$this->input->post('sleeve_length'));

                $result=$this->artwork_model->update_details_record_where('artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','2',$this->session->userdata['logged_in']['company_id']);

                $data=array('parameter_value'=>$this->input->post('sleeve_color'));

                $result=$this->artwork_model->update_details_record_where('artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','7',$this->session->userdata['logged_in']['company_id']);

                $data=array('parameter_value'=>$this->input->post('print_type'));

                $result=$this->artwork_model->update_details_record_where('artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','17',$this->session->userdata['logged_in']['company_id']);

                $data=array('parameter_value'=>$this->input->post('printing_upto_neck'));

                $result=$this->artwork_model->update_details_record_where('artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','8',$this->session->userdata['logged_in']['company_id']);

                $data=array('parameter_value'=>$this->input->post('sealing_non_lacquering_area'));

                $result=$this->artwork_model->update_details_record_where('artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','5',$this->session->userdata['logged_in']['company_id']);

                $data=array('parameter_value'=>$this->input->post('screen_ink'));
                $result=$this->artwork_model->update_details_record_where('artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','19',$this->session->userdata['logged_in']['company_id']);

                $data=array('parameter_value'=>$this->input->post('flexo_ink'));
                $result=$this->artwork_model->update_details_record_where('artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','20',$this->session->userdata['logged_in']['company_id']);

                $data=array('parameter_value'=>$this->input->post('offset_ink'));
                $result=$this->artwork_model->update_details_record_where('artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','21',$this->session->userdata['logged_in']['company_id']);

                $data=array('parameter_value'=>$this->input->post('special_ink'));
                $result=$this->artwork_model->update_details_record_where('artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','22',$this->session->userdata['logged_in']['company_id']);

                $data=array('parameter_value'=>$this->input->post('hot_foil_1'));
                $result=$this->artwork_model->update_details_record_where('artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','23',$this->session->userdata['logged_in']['company_id']);

                $data=array('parameter_value'=>$this->input->post('hot_foil_1_per_tube'));
                $result=$this->artwork_model->update_details_record_where('artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','24',$this->session->userdata['logged_in']['company_id']);


                $data=array('parameter_value'=>$this->input->post('hot_foil_2'));
                $result=$this->artwork_model->update_details_record_where('artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','25',$this->session->userdata['logged_in']['company_id']);

                $data=array('parameter_value'=>$this->input->post('hot_foil_2_per_tube'));
                $result=$this->artwork_model->update_details_record_where('artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','26',$this->session->userdata['logged_in']['company_id']);


                $data=array('parameter_value'=>$this->input->post('lacquer_type_1'));
                $result=$this->artwork_model->update_details_record_where('artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','27',$this->session->userdata['logged_in']['company_id']);

                $data=array('parameter_value'=>$this->input->post('lacquer_mixing_pc_1'));
                $result=$this->artwork_model->update_details_record_where('artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','28',$this->session->userdata['logged_in']['company_id']);


                 $data=array('parameter_value'=>$this->input->post('lacquer_type_2'));
                $result=$this->artwork_model->update_details_record_where('artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','29',$this->session->userdata['logged_in']['company_id']);

                $data=array('parameter_value'=>$this->input->post('lacquer_mixing_pc_2'));
                $result=$this->artwork_model->update_details_record_where('artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','30',$this->session->userdata['logged_in']['company_id']);

               

                $data['page_name']='Sales';

                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                $data['artwork']=$this->artwork_model->select_one_active_unapproved_record('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'artwork_devel_master.ad_id',$this->input->post('artwork_no'),'artwork_devel_master.version_no',$this->input->post('version_no'));
                $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
                $data['hot_foil']=$this->article_model->spec_all_active_record_search_foil('article','71',$this->session->userdata['logged_in']['company_id']);
                $data['lacquer']=$this->article_model->spec_all_active_record_search('article','14',$this->session->userdata['logged_in']['company_id']);
                $data['cold_foil']=$this->article_model->spec_all_active_record_search_cold_foil('article','304',$this->session->userdata['logged_in']['company_id']);
            
                $data['note']='Update Transaction Completed';

                header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
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


  function attach(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->copy==1){
            
            $data['artwork']=$this->artwork_model->select_one_active_unapproved_record('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'artwork_devel_master.ad_id',$this->uri->segment(3),'artwork_devel_master.version_no',$this->uri->segment(4));
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['hot_foil']=$this->article_model->spec_all_active_record_search_foil('article','71',$this->session->userdata['logged_in']['company_id']);
            $data['lacquer']=$this->article_model->spec_all_active_record_search('article','14',$this->session->userdata['logged_in']['company_id']);
            $data['cold_foil']=$this->article_model->spec_all_active_record_search_cold_foil('article','304',$this->session->userdata['logged_in']['company_id']);
            

            $data['coex_machine_master']=$this->common_model->select_one_active_record('coex_machine_master',$this->session->userdata['logged_in']['company_id'],'process_id',3);
            
            
            $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','980');
            $data['user']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);


              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/attach-form',$data);
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
      $data['note']='No Attachment rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  
  }


  function attach_update(){
      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->copy==1){

              $this->form_validation->set_rules('hot_foil_1','Hot Foil 1' ,'trim|xss_clean');
              if(!empty($this->input->post('hot_foil_1'))){
                $this->form_validation->set_rules('hot_foil_1_per_tube','Hot Foil 1 SQM/Tube' ,'required|trim|xss_clean|decimal');
              }
              
              $this->input->post('machine[]','Machine','required');
              $this->form_validation->set_rules('hot_foil_2','Hot Foil 2' ,'trim|xss_clean');
              if(!empty($this->input->post('hot_foil_2'))){
              $this->form_validation->set_rules('hot_foil_2_per_tube','Hot Foil 2 SQM/Tube' ,'required|trim|xss_clean|decimal');
              }

              if (empty($_FILES['userfile']['name'])){
                $this->form_validation->set_rules('userfile', 'File', 'required');
              }

              $this->form_validation->set_rules('approval_authority','Approval Authority' ,'required|trim|xss_clean');

              if($this->form_validation->run()==FALSE){

                $data['artwork']=$this->artwork_model->select_one_active_unapproved_record('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'artwork_devel_master.ad_id',$this->input->post('artwork_no'),'artwork_devel_master.version_no',$this->input->post('version_no'));
                $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
                $data['hot_foil']=$this->article_model->spec_all_active_record_search_foil('article','71',$this->session->userdata['logged_in']['company_id']);
                $data['lacquer']=$this->article_model->spec_all_active_record_search('article','14',$this->session->userdata['logged_in']['company_id']);
                $data['cold_foil']=$this->article_model->spec_all_active_record_search_cold_foil('article','304',$this->session->userdata['logged_in']['company_id']);
            
                $data['user']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);

                $data['coex_machine_master']=$this->common_model->select_one_active_record('coex_machine_master',$this->session->userdata['logged_in']['company_id'],'process_id',3);

                $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','980');
                
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/attach-form',$data);
                $this->load->view('Home/footer');

              }else{

                
                $config['upload_path'] = './assets/'.$this->session->userdata['logged_in']['company_id'].'/artwork/';
                $config['allowed_types'] = 'pdf|PDF';
                $config['max_size'] = '0';
                $this->load->library('upload',$config);
                $this->upload->initialize($config);


                  if($this->upload->do_upload('userfile')){
                  $data= $this->upload->data();
                  $filename=$data['file_name'];
                  $data=array('artwork_image_nm'=>$filename);



                  $result=$this->artwork_model->update_one_active_record('artwork_devel_master',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('hot_foil_1_per_tube'));
                  $result=$this->artwork_model->update_details_record_where('artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','24',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('hot_foil_2_per_tube'));
                  $result=$this->artwork_model->update_details_record_where('artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','26',$this->session->userdata['logged_in']['company_id']);


                  $data['note']='Update Transaction Completed';
                  }else{
                  echo $data['error'] = $this->upload->display_errors();
                }

                if(!empty($this->input->post('approval_authority'))){

                      $update_data=array('archive'=>'1');
                      $this->common_model->update_one_active_record_where('artwork_machine_master',$update_data,'artwork_no',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),$this->session->userdata['logged_in']['company_id']);

                      for($i=0;$i<=count($this->input->post('machine[]'));$i++){ 



                        if(!empty($this->input->post('machine['.$i.']'))){

                        $dataa=array(
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'artwork_no'=>$this->input->post('artwork_no'),
                        'version_no'=>$this->input->post('version_no'),
                        'machine_id'=>$this->input->post('machine['.$i.']'));

                        $result=$this->common_model->save('artwork_machine_master',$dataa);

                        }

                      }


                      $data=array('pending_flag'=>'1');
                      $result=$this->artwork_model->update_one_active_record('artwork_devel_master',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),$this->session->userdata['logged_in']['company_id']);

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
                        'form_id'=>'980',
                        'transaction_no'=>$transaction_no,
                        'status'=>$status,
                        'followup_date'=>date('Y-m-d'),
                        'contact_person_id'=>$this->session->userdata['logged_in']['user_id'],
                        'record_no'=>$this->input->post('record_no'),
                        );

                      $result=$this->common_model->save('followup',$data);

                      $data['note']='Update Transaction Completed';

                      /*
                      $data['employee']=$this->common_model->select_one_active_record('employee_master',$this->session->userdata['logged_in']['company_id'],'employee_id',$this->input->post('user'));

                      foreach ($data['employee'] as $employee_row) {
                        $config['protocol'] = 'smtp';
                        $config['smtp_host'] = 'ssl://smtp.googlemail.com';
                        $config['smtp_port'] = 465;
                        $this->load->library('email', $config);
                        $data['employee_from']=$this->common_model->select_one_active_record('employee_master',$this->session->userdata['logged_in']['company_id'],'employee_id',$this->session->userdata['logged_in']['user_id']);
                        foreach ($data['employee_from'] as $employee_from_row) {
                           $this->email->from($employee_from_row->mailbox);
                           $this->email->cc("graphic@3dpackaging.in");
                           $this->email->cc($employee_from_row->mailbox);
                        }
                        $this->email->to($employee_row->mailbox);
                        $this->email->subject("".$this->input->post('artwork_no')."_R".$this->input->post('version_no')." for Approval");
                        $this->email->message("We have uploaded Approved PDF in system. Kindly Approve from your followups");

                        if ($this->email->send()) {
                          $data['note']='Update Transaction Completed';
                        } 
                      }
                      */
                    

                  }

                

                $data['page_name']='Sales';

                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                $data['artwork']=$this->artwork_model->select_one_active_record('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'artwork_devel_master.ad_id',$this->input->post('artwork_no'),'artwork_devel_master.version_no',$this->input->post('version_no'));
                $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
                $data['hot_foil']=$this->article_model->spec_all_active_record_search_foil('article','71',$this->session->userdata['logged_in']['company_id']);
                $data['lacquer']=$this->article_model->spec_all_active_record_search('article','14',$this->session->userdata['logged_in']['company_id']);

                $data['user']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);

                $data['coex_machine_master']=$this->common_model->select_one_active_record('coex_machine_master',$this->session->userdata['logged_in']['company_id'],'process_id',3);

                  //header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                  $this->load->view(ucwords($this->router->fetch_class()).'/attach-form',$data);
                  $this->load->view('Home/footer');
              }
            }else{
              $data['note']='No Attachment rights Thanks';
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

      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

                  $data=array('archive'=>'1');

                  $result=$this->artwork_model->update_one_active_record('artwork_devel_master',$data,'ad_id',$this->uri->segment(3),'version_no',$this->uri->segment(4),$this->session->userdata['logged_in']['company_id']);

                  $data['artwork']=$this->artwork_model->select_one_inactive_record('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'artwork_devel_master.ad_id',$this->uri->segment(3),'artwork_devel_master.version_no',$this->input->post('version_no'));
                
                  $data['page_name']='Sales';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
                  $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                  $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['hot_foil']=$this->article_model->spec_all_active_record_search_foil('article','71',$this->session->userdata['logged_in']['company_id']);
                  $data['lacquer']=$this->article_model->spec_all_active_record_search('article','14',$this->session->userdata['logged_in']['company_id']);
                  $data['cold_foil']=$this->article_model->spec_all_active_record_search_cold_foil('article','304',$this->session->userdata['logged_in']['company_id']);
            
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
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->dearchive==1){
              $data=array('archive'=>'2');

              $result=$this->artwork_model->update_one_active_record('artwork_devel_master',$data,'ad_id',$this->uri->segment(3),'version_no',$this->uri->segment(4),$this->session->userdata['logged_in']['company_id']);

              $data['artwork']=$this->artwork_model->select_one_active_record('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'artwork_devel_master.ad_id',$this->uri->segment(3),'artwork_devel_master.version_no',$this->input->post('version_no'));

              $data['page_name']='Sales';

              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
              $data['hot_foil']=$this->article_model->spec_all_active_record_search_foil('article','71',$this->session->userdata['logged_in']['company_id']);
              $data['lacquer']=$this->article_model->spec_all_active_record_search('article','14',$this->session->userdata['logged_in']['company_id']);
              $data['cold_foil']=$this->article_model->spec_all_active_record_search_cold_foil('article','304',$this->session->userdata['logged_in']['company_id']);
               

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
            $data['hot_foil']=$this->article_model->spec_all_active_record_search_foil('article','71',$this->session->userdata['logged_in']['company_id']);
            $data['lacquer']=$this->article_model->spec_all_active_record_search('article','14',$this->session->userdata['logged_in']['company_id']);
            $data['cold_foil']=$this->article_model->spec_all_active_record_search_cold_foil('article','304',$this->session->userdata['logged_in']['company_id']);

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
    //Eknath

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
              $this->form_validation->set_rules('artwork_no','Artwork No' ,'trim|xss_clean|max_length[6]');
              $this->form_validation->set_rules('from_date','From Date' ,'required|trim|xss_clean|exact_length[10]');
              $this->form_validation->set_rules('to_date','To Date' ,'required|trim|xss_clean|exact_length[10]');
              $this->form_validation->set_rules('adr_company_id','Customer' ,'trim|xss_clean|callback_customer_check');
              $this->form_validation->set_rules('article_no','Article No' ,'trim|xss_clean|callback_article_check');
              $this->form_validation->set_rules('version_no','Version No' ,'trim|xss_clean|numeric|max_length[3]');
              $this->form_validation->set_rules('sleeve_dia','Sleeve Dia' ,'trim|xss_clean');
              $this->form_validation->set_rules('sleeve_length','Sleeve Length' ,'trim|xss_clean');
              $this->form_validation->set_rules('sleeve_color','Sleeve Color' ,'trim|xss_clean');
              $this->form_validation->set_rules('print_type','Print Type' ,'trim|xss_clean');
              $this->form_validation->set_rules('print_upto_neck','Printing Upto Neck' ,'trim|xss_clean');
               $this->form_validation->set_rules('screen_ink','Screen Ink' ,'trim|xss_clean|decimal');
              $this->form_validation->set_rules('offset_ink','Offset Ink' ,'trim|xss_clean|decimal');
              $this->form_validation->set_rules('flexo_ink','Flexo Ink' ,'trim|xss_clean|decimal');
              $this->form_validation->set_rules('special_ink','Special Ink' ,'trim|xss_clean|decimal');
              $this->form_validation->set_rules('sealing_non_lacquering_area','Sealing Non Lacquering Area' ,'trim|xss_clean');

              $this->form_validation->set_rules('hot_foil_1','Hot Foil 1' ,'trim|xss_clean');
              if(!empty($this->input->post('hot_foil_1'))){
                $this->form_validation->set_rules('hot_foil_1_per_tube','Hot Foil 1 SQM/Tube' ,'trim|xss_clean|decimal');
              }
              $this->form_validation->set_rules('hot_foil_2','Hot Foil 2' ,'trim|xss_clean');
              if(!empty($this->input->post('hot_foil_2'))){
              $this->form_validation->set_rules('hot_foil_2_per_tube','Hot Foil 2 SQM/Tube' ,'trim|xss_clean|decimal');
              }
              $this->form_validation->set_rules('lacquer_type_1','Lacquer 1' ,'trim|xss_clean');
              if(!empty($this->input->post('lacquer_type_1'))){
              $this->form_validation->set_rules('lacquer_mixing_pc_1','Lacquer 1 Mixing %' ,'trim|xss_clean|numeric');
              }
              $this->form_validation->set_rules('lacquer_type_2','Lacquer 2' ,'trim|xss_clean');
              if(!empty($this->input->post('lacquer_type_2'))){
              $this->form_validation->set_rules('lacquer_mixing_pc_2','Lacquer 2 Mixing %' ,'trim|xss_clean|numeric');
              }


            if($this->form_validation->run()==FALSE){

                $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
                $data['hot_foil']=$this->article_model->spec_all_active_record_search_foil('article','71',$this->session->userdata['logged_in']['company_id']);
                $data['lacquer']=$this->article_model->spec_all_active_record_search('article','14',$this->session->userdata['logged_in']['company_id']);
                $data['cold_foil']=$this->article_model->spec_all_active_record_search_cold_foil('article','304',$this->session->userdata['logged_in']['company_id']);
            
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                $this->load->view('Home/footer');
            }else{
                  $data=array();
                  $search=array();

                if(!empty($this->input->post('adr_company_id'))){
                  $customer_arr=explode('//',$this->input->post('adr_company_id'));
                  $data['adr_company_id']=$customer_arr[1];
                }
                if(!empty($this->input->post('article_no'))){
                  $article_no_arr=explode('//',$this->input->post('article_no'));
                  $data['article_no']=$article_no_arr[1];
                }
                if(!empty($this->input->post('artwork_no'))){
                  $data['ad_id']=$this->input->post('artwork_no');
                }
                if(!empty($this->input->post('version_no'))){
                  $data['version_no']=$this->input->post('version_no');
                }
                if(!empty($this->input->post('final_approval_flag'))){
                  $data['final_approval_flag']=$this->input->post('final_approval_flag');
                }

                 if(!empty($this->input->post('sleeve_dia'))){
                  $search['sleeve_dia']=$this->input->post('sleeve_dia');
                 }
                 if(!empty($this->input->post('sleeve_length'))){
                  $search['sleeve_length']=$this->input->post('sleeve_length');
                 }
                 if(!empty($this->input->post('sleeve_color'))){
                  $search['sleeve_color']=$this->input->post('sleeve_color');
                 }
                 if(!empty($this->input->post('print_type'))){
                  $search['print_type']=$this->input->post('print_type');
                 }
                 if($this->input->post('print_upto_neck')!='--' && $this->input->post('print_upto_neck')!='' ){
                  $search['print_upto_neck']=$this->input->post('print_upto_neck');
                 }
                 if($this->input->post('hot_foil')!='--'  && $this->input->post('hot_foil')!=''){
                  $search['hot_foil']=$this->input->post('hot_foil');
                 }
                 if(!empty($this->input->post('lacquer_type'))){
                  $search['lacquer_type']=$this->input->post('lacquer_type');
                 }
                 if(!empty($this->input->post('non_lacquer_area'))){
                  $search['non_lacquer_area']=$this->input->post('non_lacquer_area');
                 }
                  //New-------------------------------------------------------

                 if(!empty($this->input->post('screen_ink'))){
                  $search['screen_ink']=$this->input->post('screen_ink');
                 }
                 if(!empty($this->input->post('offest_ink'))){
                  $search['offset_ink']=$this->input->post('offset_ink');
                 }
                 if(!empty($this->input->post('flexo_ink'))){
                  $search['flexo_ink']=$this->input->post('flexo_ink');
                 }
                 if(!empty($this->input->post('special_ink'))){
                  $search['special_ink']=$this->input->post('special_ink');
                 }
                 if(!empty($this->input->post('hot_foil_1'))){
                  $search['hot_foil_1']=$this->input->post('hot_foil_1');
                 }
                 if(!empty($this->input->post('hot_foil_1_per_tube'))){
                  $search['hot_foil_1_per_tube']=$this->input->post('hot_foil_1_per_tube');
                 }
                 if(!empty($this->input->post('hot_foil_2'))){
                  $search['hot_foil_2']=$this->input->post('hot_foil_2');
                 }
                 if(!empty($this->input->post('hot_foil_2_per_tube'))){
                  $search['hot_foil_2_per_tube']=$this->input->post('hot_foil_2_per_tube');
                 }
                  if(!empty($this->input->post('lacquer_type_1'))){
                  $search['lacquer_1']=$this->input->post('lacquer_type_1');
                 }
                 if(!empty($this->input->post('lacquer_mixing_pc_1'))){
                  $search['lacquer_1_perc']=$this->input->post('lacquer_mixing_pc_1');
                 }
                 if(!empty($this->input->post('lacquer_type_2'))){
                  $search['lacquer_2']=$this->input->post('lacquer_type_2');
                 }
                 if(!empty($this->input->post('lacquer_mixing_pc_2'))){
                  $search['lacquer_2_perc']=$this->input->post('lacquer_mixing_pc_2');
                 }

                $data['artwork']=$this->artwork_model->active_record_search_new('artwork_devel_master',$data,$search,$this->common_model->change_date_format($this->input->post('from_date'),$this->session->userdata['logged_in']['company_id']),$this->common_model->change_date_format($this->input->post('to_date'),$this->session->userdata['logged_in']['company_id']),$this->session->userdata['logged_in']['company_id']);
                //echo $this->db->last_query();
                 
                if($data['artwork']!=FALSE){
                    $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                    $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
                    $data['hot_foil']=$this->article_model->spec_all_active_record_search_foil('article','71',$this->session->userdata['logged_in']['company_id']);
                    $data['lacquer']=$this->article_model->spec_all_active_record_search('article','14',$this->session->userdata['logged_in']['company_id']);
                    $data['cold_foil']=$this->article_model->spec_all_active_record_search_cold_foil('article','304',$this->session->userdata['logged_in']['company_id']);
            
                    $data['page_name']='Sales';
                    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                    $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                    $this->load->view('Home/header');
                    $this->load->view('Home/nav',$data);
                    $this->load->view('Home/subnav');
                    $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                    $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                    $this->load->view(ucwords($this->router->fetch_class()).'/search-result',$data);
                    $this->load->view('Home/footer');
                }else{
                      $data['page_name']='Sales';
                      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                      $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                      $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                      $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
                      $data['hot_foil']=$this->article_model->spec_all_active_record_search_foil('article','71',$this->session->userdata['logged_in']['company_id']);
                      $data['lacquer']=$this->article_model->spec_all_active_record_search('article','14',$this->session->userdata['logged_in']['company_id']);
                      

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
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->copy==1){

            $data['artwork']=$this->artwork_model->select_one_active_record('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'artwork_devel_master.ad_id',$this->uri->segment(3),'artwork_devel_master.version_no',$this->uri->segment(4));
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['hot_foil']=$this->article_model->spec_all_active_record_search_foil('article','71',$this->session->userdata['logged_in']['company_id']);
            $data['lacquer']=$this->article_model->spec_all_active_record_search('article','14',$this->session->userdata['logged_in']['company_id']);
            $data['cold_foil']=$this->article_model->spec_all_active_record_search_cold_foil('article','304',$this->session->userdata['logged_in']['company_id']);
            
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/copy-form',$data);
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
      $data['note']='No copy rights Thanks';
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
            $this->form_validation->set_rules('version_no','Version No' ,'required|trim|xss_clean|numeric');
            $this->form_validation->set_rules('sleeve_dia','Sleeve Dia' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sleeve_length','Sleeve Length' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sleeve_color','Sleeve Color' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('print_type','Print Type' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('printing_upto_neck','Printing Upto Neck' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sealing_non_lacquering_area','Sealing Non Lacquering Area' ,'required|trim|xss_clean|numeric');

            $this->form_validation->set_rules('hot_foil_1','Hot Foil 1' ,'trim|xss_clean');
            if(!empty($this->input->post('hot_foil_1'))){
              $this->form_validation->set_rules('hot_foil_1_per_tube','Hot Foil 1 SQM/Tube' ,'trim|xss_clean|decimal');
            }
            

            $this->form_validation->set_rules('hot_foil_2','Hot Foil 2' ,'trim|xss_clean');
            if(!empty($this->input->post('hot_foil_2'))){
            $this->form_validation->set_rules('hot_foil_2_per_tube','Hot Foil 2 SQM/Tube' ,'trim|xss_clean|decimal');
            }

            $this->form_validation->set_rules('lacquer_type_1','Lacquer 1' ,'required|trim|xss_clean');
            if(!empty($this->input->post('lacquer_type_1'))){
            $this->form_validation->set_rules('lacquer_mixing_pc_1','Lacquer 1 Mixing %' ,'required|trim|xss_clean|numeric|callback_lcq_per_check');
            }

            $this->form_validation->set_rules('lacquer_type_2','Lacquer 2' ,'trim|xss_clean');
            if(!empty($this->input->post('lacquer_type_2'))){
            $this->form_validation->set_rules('lacquer_mixing_pc_2','Lacquer 2 Mixing %' ,'required|trim|xss_clean|numeric|callback_lcq_per_check');
            }

            

            if($this->form_validation->run()==FALSE){
              
              $data['artwork']=$this->artwork_model->select_one_active_record('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'artwork_devel_master.ad_id',$this->input->post('artwork_no'),'artwork_devel_master.version_no',$this->input->post('copy_version_no'));
              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
              $data['hot_foil']=$this->article_model->spec_all_active_record_search_foil('article','71',$this->session->userdata['logged_in']['company_id']);
              $data['lacquer']=$this->article_model->spec_all_active_record_search('article','14',$this->session->userdata['logged_in']['company_id']);
              $data['cold_foil']=$this->article_model->spec_all_active_record_search_cold_foil('article','304',$this->session->userdata['logged_in']['company_id']);
            
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/copy-form',$data);
              $this->load->view('Home/footer');
            }else{

              if(!empty($this->input->post('customer'))){
                $customer_arr=explode('//',$this->input->post('customer'));
              }

              if(!empty($this->input->post('article_no'))){
                $article_no_arr=explode('//',$this->input->post('article_no'));
              }

              $data['version']=$this->artwork_model->select_artwork_verion_no('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'article_no',$article_no_arr[1]);
              foreach ($data['version'] as $version_row) {

                if($version_row->version_no==NULL){
                  $max_pkey=0;
                  $result=$this->common_model->select_max_pkey('artwork_devel_master','ad_id',$this->session->userdata['logged_in']['company_id']); 
                  foreach($result as $row){
                    $max_pkey=$row->ad_id;
                    $max_pkey=substr($max_pkey,2);
                    $max_pkey=$max_pkey+1;
                    $artwork_no=str_pad($max_pkey,4,0,STR_PAD_LEFT);
                    $artwork_no="AW".$artwork_no;
                  }
                  $version_no=1;
                }else{
                  $version_no=$version_row->version_no;
                  $artwork_no=$version_row->ad_id;
                }
              }

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                    'ad_id'=>$artwork_no,
                    'version_no'=>$version_no,
                    'ad_date'=>date('Y-m-d'),
                    'adr_company_id'=>$customer_arr[1],
                    'article_no'=>$article_no_arr[1],
                    'pending_flag'=>'0',
                    'final_approval_flag'=>'0',
                    'user_id'=>$this->session->userdata['logged_in']['user_id'],
                    'archive'=>'0');

              $result=$this->common_model->save('artwork_devel_master',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'1','parameter_value'=>$this->input->post('sleeve_dia'),'flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'2','parameter_value'=>$this->input->post('sleeve_length'),'flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'3','parameter_value'=>'','flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'4','parameter_value'=>'','flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'5','parameter_value'=>$this->input->post('sealing_non_lacquering_area'),'flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'6','parameter_value'=>'','flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'7','parameter_value'=>$this->input->post('sleeve_color'),'flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'8','parameter_value'=>$this->input->post('printing_upto_neck'),'flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'9','parameter_value'=>'||','flag_multiple'=>'1');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'10','parameter_value'=>'||','flag_multiple'=>'1');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'11','parameter_value'=>'||','flag_multiple'=>'1');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'12','parameter_value'=>'||','flag_multiple'=>'1');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'13','parameter_value'=>'','flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'14','parameter_value'=>'','flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'15','parameter_value'=>'','flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'16','parameter_value'=>'','flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'17','parameter_value'=>$this->input->post('print_type'),'flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'18','parameter_value'=>'||','flag_multiple'=>'1');
              $result=$this->common_model->save('artwork_devel_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'19','parameter_value'=>$this->input->post('screen_ink'),'flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'20','parameter_value'=>$this->input->post('flexo_ink'),'flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'21','parameter_value'=>$this->input->post('offset_ink'),'flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'22','parameter_value'=>$this->input->post('special_ink'),'flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'23','parameter_value'=>$this->input->post('hot_foil_1'),'flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'24','parameter_value'=>$this->input->post('hot_foil_1_per_tube'),'flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'25','parameter_value'=>$this->input->post('hot_foil_2'),'flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'26','parameter_value'=>$this->input->post('hot_foil_2_per_tube'),'flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'27','parameter_value'=>$this->input->post('lacquer_type_1'),'flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'28','parameter_value'=>$this->input->post('lacquer_mixing_pc_1'),'flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'29','parameter_value'=>$this->input->post('lacquer_type_2'),'flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'30','parameter_value'=>$this->input->post('lacquer_mixing_pc_2'),'flag_multiple'=>'0');
              $result=$this->common_model->save('artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                    'ad_id'=>$artwork_no,
                    'version_no'=>$version_no,
                    'lang_comments'=>'',
                    'language_id'=>$this->session->userdata['logged_in']['language_id']
                    );
              $result=$this->common_model->save('artwork_devel_master_lang',$data);

              /*

              $data['employee']=$this->common_model->select_one_active_record('employee_master',$this->session->userdata['logged_in']['company_id'],'employee_id',$this->session->userdata['logged_in']['user_id']);

                      foreach ($data['employee'] as $employee_row) {
                        $config['protocol'] = 'smtp';
                        $config['smtp_host'] = 'ssl://smtp.googlemail.com';
                        $config['smtp_port'] = 465;
                        $this->load->library('email', $config);
                        $this->email->from($employee_row->mailbox);
                        $this->email->to("graphic@3dpackaging.in");
                        $this->email->cc($employee_row->mailbox);
                        $this->email->subject("ADR for ".$artwork_no."_R".$version_no);
                        $this->email->message("Dear Graphics Team, We have created subjected ADR in System, Please provide artwork PDF for Customer Approval");

                        if ($this->email->send()) {
                          $data['note']='Create Transaction Completed';
                        } 
                  }
              */

              

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
             
              $data['note']='Copy Transaction Completed';
              header("refresh:0;url=".base_url()."index.php/".$this->router->fetch_class());
              

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
              $data['hot_foil']=$this->article_model->spec_all_active_record_search_foil('article','71',$this->session->userdata['logged_in']['company_id']);
              $data['lacquer']=$this->article_model->spec_all_active_record_search('article','14',$this->session->userdata['logged_in']['company_id']);
              $data['artwork']=$this->artwork_model->select_one_active_record('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'artwork_devel_master.ad_id',$artwork_no,'artwork_devel_master.version_no',$version_no);
              $data['cold_foil']=$this->article_model->spec_all_active_record_search_cold_foil('article','304',$this->session->userdata['logged_in']['company_id']);
            
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                  $this->load->view(ucwords($this->router->fetch_class()).'/copy-form',$data);
                  $this->load->view('Home/footer');
              
            }
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
  }
  else{
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
  
  public function export_to_excel()
  {
    require(APPPATH.'third_party/PHPExcel/Classes/PHPExcel.php');
    require(APPPATH.'third_party/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php');

    if(empty($this->input->get('from_date')) && empty($this->input->get('to_date'))){
      echo 'From Date and To date Should not Blank';
    }
    else{

      $from_date=$this->common_model->change_date_format($this->input->get('from_date'),$this->session->userdata['logged_in']['company_id']);
      $to_date=$this->common_model->change_date_format($this->input->get('to_date'),$this->session->userdata['logged_in']['company_id']);
      $data=array();
      $search=array();

      if(!empty($this->input->get('adr_company_id'))){
        $customer_arr=explode('//',$this->input->get('adr_company_id'));
        $data['adr_company_id']=$customer_arr[1];
      }
      if(!empty($this->input->get('article_no'))){
        $article_no_arr=explode('//',$this->input->get('article_no'));
        $data['article_no']=$article_no_arr[1];
      }
      if(!empty($this->input->get('artwork_no'))){
        $data['ad_id']=$this->input->get('artwork_no');
      }
      if(!empty($this->input->get('version_no'))){
        $data['version_no']=$this->input->get('version_no');
      }
      if(!empty($this->input->get('final_approval_flag'))){
        $data['final_approval_flag']=$this->input->get('final_approval_flag');
      }

       if(!empty($this->input->get('sleeve_dia'))){
        $search['sleeve_dia']=$this->input->get('sleeve_dia');
       }
       if(!empty($this->input->get('sleeve_length'))){
        $search['sleeve_length']=$this->input->get('sleeve_length');
       }
       if(!empty($this->input->get('sleeve_color'))){
        $search['sleeve_color']=$this->input->get('sleeve_color');
       }
       if(!empty($this->input->get('print_type'))){
        $search['print_type']=$this->input->get('print_type');
       }
       if($this->input->get('print_upto_neck')!='--' && $this->input->get('print_upto_neck')!='' ){
        $search['print_upto_neck']=$this->input->get('print_upto_neck');
       }

       if($this->input->get('hot_foil')!='--'  && $this->input->get('hot_foil')!=''){
        $search['hot_foil']=$this->input->get('hot_foil');
       }
       if(!empty($this->input->get('lacquer_type'))){
        $search['lacquer_type']=$this->input->get('lacquer_type');
       }
       if(!empty($this->input->get('non_lacquer_area'))){
        $search['non_lacquer_area']=$this->input->get('non_lacquer_area');
       }


      $data['artwork']=$this->artwork_model->active_record_search('artwork_devel_master',$data,$search,$from_date,$to_date,$this->session->userdata['logged_in']['company_id']);

      $ObjPHPExcel=new PHPExcel();
      $ObjPHPExcel->SetActiveSheetIndex(0);
      $ObjPHPExcel->getActiveSheet()->SetCellValue('A1','Id');
      $ObjPHPExcel->getActiveSheet()->SetCellValue('B1','Artwork No');
      $ObjPHPExcel->getActiveSheet()->SetCellValue('C1','Version');
      $ObjPHPExcel->getActiveSheet()->SetCellValue('D1','File');
      $ObjPHPExcel->getActiveSheet()->SetCellValue('E1','Date');
      $ObjPHPExcel->getActiveSheet()->SetCellValue('F1','Customer');
      $ObjPHPExcel->getActiveSheet()->SetCellValue('G1','Article No');
      $ObjPHPExcel->getActiveSheet()->SetCellValue('H1','Article Name');
      $ObjPHPExcel->getActiveSheet()->SetCellValue('I1','Sleeve Dia');
      $ObjPHPExcel->getActiveSheet()->SetCellValue('J1','Sleeve Length');
      $ObjPHPExcel->getActiveSheet()->SetCellValue('K1','Sleeve Color');
      $ObjPHPExcel->getActiveSheet()->SetCellValue('L1','Print Type');
      $ObjPHPExcel->getActiveSheet()->SetCellValue('M1','Printing Upto Neck');
      $ObjPHPExcel->getActiveSheet()->SetCellValue('N1','Foil');
      $ObjPHPExcel->getActiveSheet()->SetCellValue('O1','Lacquer Type');
      $ObjPHPExcel->getActiveSheet()->SetCellValue('P1','Sealing Non Lacquering Area');
      $ObjPHPExcel->getActiveSheet()->SetCellValue('Q1','Created By');
      $ObjPHPExcel->getActiveSheet()->SetCellValue('R1','Approved Date');
      $ObjPHPExcel->getActiveSheet()->SetCellValue('S1','Approved By');

      $row=2;
      $i=1;
      foreach($data['artwork'] as $key => $value) {
        
        $customer=$this->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'adr_company_id',$value->adr_company_id);
        foreach ($customer as $customer_row) {
          $customer_name=$customer_row->name1;
        }

        $article=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$value->article_no);
        foreach ($article as $article_row) {
          $article_name=$article_row->article_name.($article_row->article_sub_description!=''?' ('.$article_row->article_sub_description.')':'');
        }

        $hot_foil=substr($value->hot_foil,strpos($value->hot_foil, "||") + 2);
        $hot_foil= strtoupper(str_replace("^"," + ",$hot_foil));
        $lacquer=substr($value->lacquer_type,strpos($value->lacquer_type, "||") + 2);
        $lacquer=strtoupper(str_replace("^"," + ",$lacquer));
        $user_name=$this->common_model->get_user_name($value->user_id,$this->session->userdata['logged_in']['company_id']);
        $approved_by=$this->common_model->get_user_name($value->approved_by,$this->session->userdata['logged_in']['company_id']);
        
         $ObjPHPExcel->getActiveSheet()->SetCellValue('A'.$row,$i++);
         $ObjPHPExcel->getActiveSheet()->SetCellValue('B'.$row,str_replace('AW','AW00',$value->ad_id));
         $ObjPHPExcel->getActiveSheet()->SetCellValue('C'.$row,$value->version_no);
         $ObjPHPExcel->getActiveSheet()->SetCellValue('D'.$row,'');
         $ObjPHPExcel->getActiveSheet()->SetCellValue('E'.$row,$value->ad_date);
         $ObjPHPExcel->getActiveSheet()->SetCellValue('F'.$row,$customer_name);
         $ObjPHPExcel->getActiveSheet()->SetCellValue('G'.$row,$value->article_no);
         $ObjPHPExcel->getActiveSheet()->SetCellValue('H'.$row,$article_name);
         $ObjPHPExcel->getActiveSheet()->SetCellValue('I'.$row,$value->sleeve_dia);
         $ObjPHPExcel->getActiveSheet()->SetCellValue('J'.$row,$value->sleeve_length);
         $ObjPHPExcel->getActiveSheet()->SetCellValue('K'.$row,$value->sleeve_color);
         $ObjPHPExcel->getActiveSheet()->SetCellValue('L'.$row,$value->print_type);
         $ObjPHPExcel->getActiveSheet()->SetCellValue('M'.$row,$value->print_upto_neck);
         $ObjPHPExcel->getActiveSheet()->SetCellValue('N'.$row,$hot_foil);
         $ObjPHPExcel->getActiveSheet()->SetCellValue('O'.$row,$lacquer);
         $ObjPHPExcel->getActiveSheet()->SetCellValue('P'.$row,$value->non_lacquer_area);
         $ObjPHPExcel->getActiveSheet()->SetCellValue('Q'.$row,$user_name);
         $ObjPHPExcel->getActiveSheet()->SetCellValue('R'.$row,$value->approval_date);
         $ObjPHPExcel->getActiveSheet()->SetCellValue('S'.$row,$approved_by);

         $row++;

      }

      $file_name='Artwork_report_'.date('Y-m-d-H:i:s').'.xlsx';
      $ObjPHPExcel->getActiveSheet()->setTitle('Artwork Data');

      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="'.$file_name.'"');
      header('Cache-Control: max-age=0');

      $writer=PHPExcel_IOFactory::createWriter($ObjPHPExcel,'Excel2007');
      $writer->save('php://output');
      exit;

    } 





  }


  public function export_to_excel_1()
  {
    
    require(APPPATH.'third_party/PHPExcel/Classes/PHPExcel.php');
    require(APPPATH.'third_party/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php');

    if(empty($this->input->get('from_date')) && empty($this->input->get('to_date'))){
      echo 'From Date and To date Should not Blank';
    }
    else{

      $from_date=$this->common_model->change_date_format($this->input->get('from_date'),$this->session->userdata['logged_in']['company_id']);
      $to_date=$this->common_model->change_date_format($this->input->get('to_date'),$this->session->userdata['logged_in']['company_id']);
      $data=array();
      $search=array();

      if(!empty($this->input->get('adr_company_id'))){
        $customer_arr=explode('//',$this->input->get('adr_company_id'));
        $data['adr_company_id']=$customer_arr[1];
      }
      if(!empty($this->input->get('article_no'))){
        $article_no_arr=explode('//',$this->input->get('article_no'));
        $data['article_no']=$article_no_arr[1];
      }
      if(!empty($this->input->get('artwork_no'))){
        $data['ad_id']=$this->input->get('artwork_no');
      }
      if(!empty($this->input->get('version_no'))){
        $data['version_no']=$this->input->get('version_no');
      }
      if(!empty($this->input->get('final_approval_flag'))){
        $data['final_approval_flag']=$this->input->get('final_approval_flag');
      }

       if(!empty($this->input->get('sleeve_dia'))){
        $search['sleeve_dia']=$this->input->get('sleeve_dia');
       }
       if(!empty($this->input->get('sleeve_length'))){
        $search['sleeve_length']=$this->input->get('sleeve_length');
       }
       if(!empty($this->input->get('sleeve_color'))){
        $search['sleeve_color']=$this->input->get('sleeve_color');
       }
       if(!empty($this->input->get('print_type'))){
        $search['print_type']=$this->input->get('print_type');
       }
       if($this->input->get('print_upto_neck')!='--' && $this->input->get('print_upto_neck')!='' ){
        $search['print_upto_neck']=$this->input->get('print_upto_neck');
       }
       if($this->input->get('hot_foil')!='--'  && $this->input->get('hot_foil')!=''){
        $search['hot_foil']=$this->input->get('hot_foil');
       }
       if(!empty($this->input->get('lacquer_type'))){
        $search['lacquer_type']=$this->input->get('lacquer_type');
       }
       if(!empty($this->input->get('non_lacquer_area'))){
        $search['non_lacquer_area']=$this->input->get('non_lacquer_area');
       }


      $data['artwork']=$this->artwork_model->active_record_search('artwork_devel_master',$data,$search,$from_date,$to_date,$this->session->userdata['logged_in']['company_id']);

      $ObjPHPExcel=new PHPExcel();
      $ObjPHPExcel->SetActiveSheetIndex(0);
      $ObjPHPExcel->getActiveSheet()->SetCellValue('A1','Id');
      $ObjPHPExcel->getActiveSheet()->SetCellValue('B1','Artwork No');
      $ObjPHPExcel->getActiveSheet()->SetCellValue('C1','Version');
      $ObjPHPExcel->getActiveSheet()->SetCellValue('D1','File');
      $ObjPHPExcel->getActiveSheet()->SetCellValue('E1','Date');
      $ObjPHPExcel->getActiveSheet()->SetCellValue('F1','Customer');
      $ObjPHPExcel->getActiveSheet()->SetCellValue('G1','Article No');
      $ObjPHPExcel->getActiveSheet()->SetCellValue('H1','Article Name');
      $ObjPHPExcel->getActiveSheet()->SetCellValue('I1','Sleeve Dia');
      $ObjPHPExcel->getActiveSheet()->SetCellValue('J1','Sleeve Length');
      $ObjPHPExcel->getActiveSheet()->SetCellValue('K1','Sleeve Color');
      $ObjPHPExcel->getActiveSheet()->SetCellValue('L1','Print Type');
      $ObjPHPExcel->getActiveSheet()->SetCellValue('M1','Printing Upto Neck');
      $ObjPHPExcel->getActiveSheet()->SetCellValue('N1','Foil');
      $ObjPHPExcel->getActiveSheet()->SetCellValue('O1','Lacquer Type');
      $ObjPHPExcel->getActiveSheet()->SetCellValue('P1','Sealing Non Lacquering Area');
      $ObjPHPExcel->getActiveSheet()->SetCellValue('Q1','Created By');
      $ObjPHPExcel->getActiveSheet()->SetCellValue('R1','Approved Date');
      $ObjPHPExcel->getActiveSheet()->SetCellValue('S1','Approved By');

      
      $column=66;
    
      
      foreach($data['artwork'][0] as $key => $value) {
        
        $alpha=''.chr($column).'1';  
        $ObjPHPExcel->getActiveSheet()->SetCellValue($alpha,$key);  
        $column++;    
        
      }

      $row=2;
       $i=1;

      foreach($data['artwork'] as $key => $value) {     

        
        $customer=$this->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'adr_company_id',$value->adr_company_id);
        foreach ($customer as $customer_row) {
          $customer_name=$customer_row->name1;
        }

        $article=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$value->article_no);
        foreach ($article as $article_row) {
          $article_name=$article_row->article_name.($article_row->article_sub_description!=''?' ('.$article_row->article_sub_description.')':'');
        }

        $hot_foil=substr($value->hot_foil,strpos($value->hot_foil, "||") + 2);
        $hot_foil= strtoupper(str_replace("^"," + ",$hot_foil));
        $lacquer=substr($value->lacquer_type,strpos($value->lacquer_type, "||") + 2);
        $lacquer=strtoupper(str_replace("^"," + ",$lacquer));
        $user_name=$this->common_model->get_user_name($value->user_id,$this->session->userdata['logged_in']['company_id']);
        $approved_by=$this->common_model->get_user_name($value->approved_by,$this->session->userdata['logged_in']['company_id']);
        
         $ObjPHPExcel->getActiveSheet()->SetCellValue('A'.$row,$i++);
         $ObjPHPExcel->getActiveSheet()->SetCellValue('B'.$row,str_replace('AW','AW00',$value->ad_id));
         $ObjPHPExcel->getActiveSheet()->SetCellValue('C'.$row,$value->version_no);
         $ObjPHPExcel->getActiveSheet()->SetCellValue('D'.$row,'');
         $ObjPHPExcel->getActiveSheet()->SetCellValue('E'.$row,$value->ad_date);
         $ObjPHPExcel->getActiveSheet()->SetCellValue('F'.$row,$customer_name);
         $ObjPHPExcel->getActiveSheet()->SetCellValue('G'.$row,$value->article_no);
         $ObjPHPExcel->getActiveSheet()->SetCellValue('H'.$row,$article_name);
         $ObjPHPExcel->getActiveSheet()->SetCellValue('I'.$row,$value->sleeve_dia);
         $ObjPHPExcel->getActiveSheet()->SetCellValue('J'.$row,$value->sleeve_length);
         $ObjPHPExcel->getActiveSheet()->SetCellValue('K'.$row,$value->sleeve_color);
         $ObjPHPExcel->getActiveSheet()->SetCellValue('L'.$row,$value->print_type);
         $ObjPHPExcel->getActiveSheet()->SetCellValue('M'.$row,$value->print_upto_neck);
         $ObjPHPExcel->getActiveSheet()->SetCellValue('N'.$row,$hot_foil);
         $ObjPHPExcel->getActiveSheet()->SetCellValue('O'.$row,$lacquer);
         $ObjPHPExcel->getActiveSheet()->SetCellValue('P'.$row,$value->non_lacquer_area);
         $ObjPHPExcel->getActiveSheet()->SetCellValue('Q'.$row,$user_name);
         $ObjPHPExcel->getActiveSheet()->SetCellValue('R'.$row,$value->approval_date);
         $ObjPHPExcel->getActiveSheet()->SetCellValue('S'.$row,$approved_by);

         $row++;

      }

      $file_name='Artwork_report_'.date('Y-m-d-H:i:s').'.xlsx';
      $ObjPHPExcel->getActiveSheet()->setTitle('Artwork Data');

      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="'.$file_name.'"');
      header('Cache-Control: max-age=0');

      $writer=PHPExcel_IOFactory::createWriter($ObjPHPExcel,'Excel2007');
      $writer->save('php://output');
      exit;

    } 
  
  }

  public function lcq_per_check($str){
    $lacquer_mixing_pc_1=$this->input->post('lacquer_mixing_pc_1');
    $lacquer_mixing_pc_2=$this->input->post('lacquer_mixing_pc_2');
    $total_per=$lacquer_mixing_pc_2+$lacquer_mixing_pc_1;

    if($total_per!=100){
      $this->form_validation->set_message('lcq_per_check', 'The {field} field is incorrect');
      return FALSE;
    }else{
      return TRUE;
    }
  }

  function remove_approval(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->delete==1){

            $data['artwork']=$this->artwork_model->select_one_active_record('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'artwork_devel_master.ad_id',$this->uri->segment(3),'artwork_devel_master.version_no',$this->uri->segment(4));

            // $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            // $data['print_type']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
            // $data['hot_foil']=$this->article_model->spec_all_active_record_search_foil('article','71',$this->session->userdata['logged_in']['company_id']);
            // $data['lacquer']=$this->article_model->spec_all_active_record_search('article','14',$this->session->userdata['logged_in']['company_id']);
            // $data['cold_foil']=$this->article_model->spec_all_active_record_search_cold_foil('article','304',$this->session->userdata['logged_in']['company_id']);
            
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/remove-approval-form',$data);
              $this->load->view('Home/footer');
          }else{
              $data['note']='No Approval Reject rights Thanks';
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
      $data['note']='No Approval Reject rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }
  
  }

    function save_remove_approval(){
      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){
              
              $this->form_validation->set_rules('artwork_no','Artwork No' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('version_no','Version No' ,'required|trim|xss_clean|numeric');
              $this->form_validation->set_rules('final_approval_flag','Final Approval Flag' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('pending_flag','Pending Flag' ,'required|trim|xss_clean|numeric');

              if($this->form_validation->run()==FALSE){
                
                $data['artwork']=$this->artwork_model->select_one_active_record('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'artwork_devel_master.ad_id',$this->input->post('artwork_no'),'artwork_devel_master.version_no',$this->input->post('version_no'));
                
            
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/remove-approval-form',$data);
                $this->load->view('Home/footer');

              }else{                

                $data=array('final_approval_flag'=>$this->input->post('final_approval_flag'),
                'pending_flag'=>$this->input->post('pending_flag'),'approved_by'=>'');

                $result=$this->artwork_model->update_one_active_record('artwork_devel_master',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),$this->session->userdata['logged_in']['company_id']);

                if($result){

                  $result=$this->common_model->delete_one_active_record('followup','record_no',$this->input->post('artwork_no').'@@@'.$this->input->post('version_no'),$this->session->userdata['logged_in']['company_id']);

                }


                $data['page_name']='Sales';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                $data['artwork']=$this->artwork_model->select_one_active_record('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'artwork_devel_master.ad_id',$this->input->post('artwork_no'),'artwork_devel_master.version_no',$this->input->post('version_no'));
                 
            
                $data['note']='Update Transaction Completed';

                header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                  $this->load->view(ucwords($this->router->fetch_class()).'/remove-approval-form',$data);
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

    function attach_customer_file(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $data['artwork']=$this->artwork_model->select_one_active_record('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'artwork_devel_master.ad_id',$this->uri->segment(3),'artwork_devel_master.version_no',$this->uri->segment(4));   


              $this->load->view('Home/header');
              //$this->load->view('Home/nav',$data);
              //$this->load->view('Home/subnav');
              //$this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/attach-customer-pdf',$data);
              //$this->load->view('Home/footer');
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
      $data['note']='No Attachment rights Thanks';
      //$data['page_name']='home';
     // $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
     // $this->load->view('Home/nav',$data);
     // $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      //$this->load->view('Home/footer');
    }
  
  }

  function save_attach_customer_file(){

      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {

            if($formrights_row->new==1){


              if(empty($_FILES['userfile1']['name'])){ 

                 echo $this->upload->display_errors();

                  $data['artwork']=$this->artwork_model->select_one_active_record('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'artwork_devel_master.ad_id',$this->input->post('artwork_no'),'artwork_devel_master.version_no',$this->input->post('version_no')); 

                
                $this->load->view('Home/header');
                //$this->load->view('Home/nav',$data);
                //$this->load->view('Home/subnav');
                //$this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                 $this->load->view('Error/error-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/attach-customer-pdf',$data);
                //$this->load->view('Home/footer');

              }else{

                  // File Upload---------------------------------                  
                  $config['upload_path'] = './assets/000020/artwork/';
                  $config['allowed_types'] = 'pdf|PDF|gif|jpeg|jpg|png';
                  $config['max_size'] = '0';
                  $this->load->library('upload',$config);
                  $this->upload->initialize($config);

                  if($this->upload->do_upload('userfile1')){
                      $data= $this->upload->data();
                      $filename=$data['file_name'];

                      $data=array('customer_artwork_pdf'=>$filename);
                       

                      $result=$this->artwork_model->update_one_active_record('artwork_devel_master',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),$this->session->userdata['logged_in']['company_id']);

                      //$data['note']='File Successfully Uploaded.';


                  $artwork_no = $this->input->post('artwork_no');
                  $version_no = $this->input->post('version_no');

                  $artwork_row=$this->artwork_model->select_details_record_print($artwork_no,$version_no);
                  
                  $data['employee']=$this->common_model->select_one_active_record('employee_master',$this->session->userdata['logged_in']['company_id'],'employee_id',$this->session->userdata['logged_in']['user_id']);

                  $user_email='';
                  $data['employee']=$this->common_model->select_one_active_record('employee_master',$this->session->userdata['logged_in']['company_id'],'employee_id',$this->session->userdata['logged_in']['user_id']);
                  if($data['employee']==FALSE){

                  }else{
                    foreach($data['employee'] as $employee_row) {
                      $user_email=$employee_row->mailbox;
                    }
                  }

                  $filename = base_url('assets/img/logo.png');
                  $smtp_user=$this->config->item('smtp_user');
                  $smtp_pass=$this->config->item('smtp_pass');
                  $config['protocol'] = 'smtp';
                  $config['smtp_host'] = 'ssl://smtp.googlemail.com';
                  $config['smtp_port'] = 465;
                  $config['smtp_timeout'] = 60;
                  $config['charset'] = 'utf-8';
                  $config['mailtype'] = 'html';
                  $config['validation'] = 'TRUE';
                  $config['smtp_user']= 'auto.mailer@3d-neopac.com';
                  $config['smtp_pass']='auto@2223';
                  $config['newline']= "\r\n";
                  $this->load->library('email', $config);
                  $this->email->from("auto.mailer@3d-neopac.com");
                  $this->email->to('graphic@3d-neopac.com,santosh.chavan@3d-neopac.com');
                  $this->email->cc($user_email);
                  //$this->email->cc('ankit.shukla@3d-neopac.com');
                  $this->email->subject("Customer File Uploaded For ".$this->input->post('artwork_no')." Version ".$this->input->post('version_no')." ");
                  $this->email->attach($filename);
                  $cid = $this->email->attachment_cid($filename);

                  $html = '<!DOCTYPE>
                    <html>
                    <head><title>Sales Order</title>
                      <style>
                        table {
                          border:1px solid #ddd;
                          border-collapse:collapse;
                          font-size:10px;
                          width:100%;
                          color:black;
                          font-family:verdana;
                        }

                        th {

                          border:1px solid #ddd;
                          text-align: left;
                          background-color:#DFFCFC;
                          font-weight:bold;
                          font-size:11px;
                        }

                        td {
                          border:1px solid #ddd;
                          text-align: left;            
                          font-size:11px;
                        }        
                        .ui.teal.labels .label {
                            background-color: #00b5ad!important;
                            border-color: #00b5ad!important;
                            color: #fff!important;
                        }
                        .invoice-box table {
                            width: 100%;
                            line-height: 12px;
                            text-align: left;
                        }
                        .invoice-box table td {
                            padding: 3px !important;
                        }
                        .invoice-box table tr td:nth-child(2) {
                            text-align: center;
                        }
                      </style>
                    </head>         
                    <body>
                    <div style="margin-top:5px;width:900px;margin:0px auto;background-color:#ddd;border:1px solid #ddd;font-family:verdana;">
                    <div style="padding:3px;background-color: #f5f5f5">  
                    <div style="margin-top:20px;>
                    <table cellpadding="0" cellspacing="0" border="0">          
                        <tbody><tr>
                            <td class="title" width="5%">
                               <div style="text-align:center;"">
                    <img src="cid:'.$cid.'" style="max-width:130px;height:30px;"><br/>
                    <span style="font-size:10px;"><b>3D TECHNOPACK PVT LTD</b><br/>
                    SURVEY NO 8/1, VILLAGE ATHAL, SILVASSA, DADRA NAGAR HAVELI, PIN : 396230, INDIA</span>
                    </div>
                            </td>
                        </tr>                      
                    </tbody>
                    </table>
                    <div class="ui teal labels" style="text-align: center;">
                      <div class="ui label">
                        Artwork Coex Tube 
                      </div>
                    </div>
                    <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
                      <tr class="heading">
                        <td width=""><b>ARTWORK NO</td>
                        <td width="" style="border-right:1px solid #D9d9d9;"><b>'.$artwork_row['ad_id'].'</b></td>
                        <td width=""><b>VERSION NO</b></td>
                        <td width="">'.$artwork_row['version_no'].'</td>                        
                      </tr>
                      <tr class="item last">
                        <td><b>CUSTOMER</b></td>
                        <td style="border-right:1px solid #D9d9d9;">'.$artwork_row['customer_name'].' // '.$artwork_row['adr_company_id'].'</td>                        
                        <td><b>ARTICLE</b></td>
                        <td>'.$artwork_row['article_name'].' // '.$artwork_row['article_no'].'</td>
                      </tr>      

                      <tr class="heading">
                        <td colspan="6">
                          <b>OTHER DETAILS</b>
                        </td>            
                      </tr>

                       <tr class="item last">
                        <td ><b>ARTWORK FILE</b></td>
                        <td style="border-right:1px solid #D9d9d9;">'.$artwork_row['artwork_image_nm'].'
                        </td>
                        <td><b>CUSTOMER APPR FILE</b></td>
                        <td style="border-right:1px solid #D9d9d9;">'.$artwork_row['customer_artwork_pdf'].'</td>
                      </tr>
                                
                      <tr class="item last">
                        <td width="15%"><b>DIA</b></td>
                        <td style="border-right:1px solid #D9d9d9;">'.$artwork_row['ARTWORK_PARA_1'].'</td>
                        <td ><b>LENGTH</b></td>
                        <td>'.$artwork_row['ARTWORK_PARA_2'].'</td>
                      </tr>
                          
                      <tr class="item last">
                        <td><b>SLEEVE COLOR</b></td>
                        <td style="border-right:1px solid #D9d9d9;">'.$artwork_row['ARTWORK_PARA_7'].'</td>
                        <td><b>PRINT TYPE</b></td>
                        <td>'.$artwork_row['ARTWORK_PARA_17'].'</td>
                      </tr>
                      
                      <tr class="item last">
                        <td><b>PRINT UP TO NECK</b></td>
                        <td>'.$artwork_row['ARTWORK_PARA_8'].'</td>
                        <td><b>SEALING AND NON LACQUERING AREA</b></td>
                        <td style="border-right:1px solid #D9d9d9;">'.$artwork_row['ARTWORK_PARA_5'].'</td>
                      </tr>
                      
                      <tr class="item last">
                        <td><b>EYE MARK DIMENSION</b></td>
                        <td style="border-right:1px solid #D9d9d9;">'.$artwork_row['ARTWORK_PARA_13'].'</td>
                        <td><b>EYE MARK POSITION FROM OPEN END</b></td>
                        <td style="border-right:1px solid #D9d9d9;">'.$artwork_row['ARTWORK_PARA_14'].'</td>           
                      </tr>
                      
                      <tr class="item last">
                        <td><b>FOIL ONE</b></td>
                        <td style="border-right:1px solid #D9d9d9;">'.$artwork_row['ARTWORK_PARA_23'].'</td>
                        <td><b>FOIL SQM/TUBE</b></td>
                        <td>'.$artwork_row['ARTWORK_PARA_24'].'</td>
                      </tr>
                      
                      <tr class="item last">
                        <td><b>FOIL TWO</b></td>
                        <td style="border-right:1px solid #D9d9d9;">'.$artwork_row['ARTWORK_PARA_25'].'</td>
                        <td><b>FOIL SQM/TUBE</b></td>
                        <td>'.$artwork_row['ARTWORK_PARA_26'].'</td>
                      </tr>
                      
                      <tr class="item last">
                        <td><b>LACQUER ONE</b></td>
                        <td style="border-right:1px solid #D9d9d9;">'.$artwork_row['ARTWORK_PARA_27'].'</td>
                        <td><b>LACQUER ONE %</b></td>
                        <td>'.$artwork_row['ARTWORK_PARA_28'].'</td>
                      </tr>

                      <tr class="item last">
                        <td><b>LACQUER TWO</b></td>
                        <td style="border-right:1px solid #D9d9d9;">'.$artwork_row['ARTWORK_PARA_29'].'</td>
                        <td><b>LACQUER TWO %</b></td>
                        <td>'.$artwork_row['ARTWORK_PARA_30'].'</td>
                      </tr>
                      
                      <tr class="item last">
                        <td><b>LACQUER COMMENT</b></td>
                        <td style="border-right:1px solid #D9d9d9;">'.$artwork_row['ARTWORK_PARA_12'].'</td>
                        <td><b>CREATED BY</b></td>
                       <td style="border-right:1px solid #D9d9d9;">'.$artwork_row['user_name'].'</td>
                      </tr>
                  
                    </table> 

                  </div>
                </div>
              </div>
            </body>
          </html>';
                       
              $this->email->message($html);
              $this->email->set_mailtype("html");
              if ($this->email->send()) {
                $data['note']= 'File Uploaded Succesfully!';
                //return 1;
              } 
              else{
                $data['error']='Email send failed!';
                //$errors = $this->email->print_debugger();
                //print_r($errors);
              } 
            }else{
                echo $this->upload->display_errors();
            }
             
                
                $data['page_name']='Sales';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                                
                 $data['artwork']=$this->artwork_model->select_one_active_record('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'artwork_devel_master.ad_id',$this->input->post('artwork_no'),'artwork_devel_master.version_no',$this->input->post('version_no'));
                 //echo $this->db->last_query();

                //print_r($data['artwork_springtube']);

                  //header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
                  $this->load->view('Home/header');
                  //$this->load->view('Home/nav',$data);
                  //$this->load->view('Home/subnav');
                  //$this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                  //$this->load->view('Error/error-title',$data);
                  $this->load->view(ucwords($this->router->fetch_class()).'/attach-customer-pdf',$data);
                  //$this->load->view('Home/footer');
              }     
              
            }else{
              $data['note']='No Attachment rights Thanks';
              $this->load->view('Home/header');
              //$this->load->view('Home/nav',$data);
              //$this->load->view('Home/subnav');
              $this->load->view('Error/error-title',$data);
              //$this->load->view('Home/footer');
            }
          }
        }
      }
    }else{
      $data['note']='No Modify rights Thanks';
      //$data['page_name']='home';
      //$data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
     // $this->load->view('Home/nav',$data);
     // $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      //$this->load->view('Home/footer');
    }
  }

public function csv_coex()
{
 $data['artwork'] = $this->artwork_model->active_record_search_csv_coex($this->uri->segment(3), $this->uri->segment(4));



 foreach ($data['artwork'] as $artwork_row) {

  $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$artwork_row->foil_23);
  $a='';
   
  foreach($data['article'] as $article_row){
     $a=$article_row->article_name;
  }
}
echo $z=$a;
if($z){
$parts = explode(' ',$z);
$foils = $parts[2];

if($foils=='ALUFIN'){

  $foils='SILVER';
}
elseif($foils=='LUXOR'){

  $foils='GOLD';
}else{
  $foils;
}
}else{
  $foils=' & '.$foils;
}



 //echo $foils; 

$data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$artwork_row->hot_foil_2);
  $k='';
  $hot_foils='';
   
  foreach($data['article'] as $article_row){
     $k=$article_row->article_name;
  }

    $t=$k;
    
    if($t){
      
      $parts = explode(' ',$t);
      $hot_foils = $parts[2];

        if($hot_foils=='ALUFIN'){
          $hot_foils=' & SILVER';
        }
        elseif($hot_foils=='LUXOR'){
          $hot_foils=' & GOLD';
        }else{
          $hot_foils=' & '.$hot_foils;
        }
    }
    


foreach ($data['artwork'] as $artwork_row) {
$data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$artwork_row->laqure);
 $b='';

 foreach($data['article'] as $article_row){
     $b=$article_row->article_name;
  }
}
 $d='';
foreach ($data['artwork'] as $artwork_row) {

$d=$artwork_row->laqure_28;

}

$e=$b.' '.$d;

if($e=='VARNISH GLOSS 5411000004 100'){

  $laqure_type='GLOSS';
}elseif($e=='VARNISH MATT 5420500006 100'){

  $laqure_type='MATT';
}elseif($e=='VARNISH MATT 5420500006 70'){

  $laqure_type='SATIN MATT';
}elseif($e=='VARNISH MATT 5420500006 50'){

  $laqure_type='SEMI MATT';
}else{
   $laqure_type='';
}

$print_type_1='';
$printing_upto_neck_1='';
foreach ($data['artwork'] as $artwork_row) {

$print_type_1=$artwork_row->print_type;
$printing_upto_neck_1=$artwork_row->printing_upto_neck;

}

if($print_type_1=='SCREEN' && $laqure_type=='MATT'){
  $varnish_sequence='PRE ? / POST ?';
}elseif($print_type_1=='SCREEN' && $laqure_type=='SATIN MATT'){
  $varnish_sequence='PRE ? / POST ?';
}elseif($print_type_1=='SCREEN' && $laqure_type=='MATT' && $printing_upto_neck_1=='YES'){
  $varnish_sequence='PRE ? / POST ?';
}elseif($print_type_1=='SCREEN' && $laqure_type=='SATIN MATT' && $printing_upto_neck_1=='YES'){
  $varnish_sequence='PRE ? / POST ?';
}else{
  $varnish_sequence='POST';
}



// Set the filename for the downloaded CSV file
 $fileName1 =  str_replace('AW','AW00',$artwork_row->ad_id).'_R'.$artwork_row->version_no.'.csv';

 // Set the content type and headers for the download
 header("Content-Type: text/csv");
 header("Content-Disposition: attachment; filename=$fileName1");

 // Open the output buffer for writing the CSV data
 $output = fopen("php://output", "w");

 // Write the header row to the CSV file
 fputcsv($output, array(
 'article_code',
 'saw_id',
 'revision',
 'customer_name',
 'article_name',
 'substrate_colour',
 'dia',
 'tube_length',
'print_upto_neck',
 'print_type',
 'non_varnish_length',
 'foil',
 'adr_date',
 'download_date',
 'varnish',
 'varnish_sequence'
 ));

 // Loop through the data and write each row to the CSV file
 foreach ($data['artwork'] as $artwork_row) {
 

 
   

 fputcsv($output, array(
 $artwork_row->article_no,
 str_replace('AW','AW00',$artwork_row->ad_id),
 $artwork_row->version_no,
 $artwork_row->name1,
$artwork_row->lang_article_description,
 $artwork_row->laminate_color,
 str_replace('MM',' ',$artwork_row->sleeve_dia),
 $artwork_row->sleeve_length,
 $artwork_row->printing_upto_neck,
 $artwork_row->print_type,
 $artwork_row->length,
 $foils.' '.$hot_foils,
 $artwork_row->ad_date,
 date('d-M-Y'),
$laqure_type,
$varnish_sequence
 
));

}

 // Close the output buffer and exit the script
 fclose($output);
exit();
}

  
}