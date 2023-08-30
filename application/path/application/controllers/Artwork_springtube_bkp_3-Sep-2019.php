<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Artwork_springtube extends CI_Controller {

  function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('artwork_springtube_model');
      $this->load->model('customer_model');
      $this->load->model('article_model');
      $this->load->model('second_sub_group_model');

      //$laminate_color_arr=array('WHITE','RED','ORANGE','YELLOW','GREEN','BLUE','VIOLET','PINK','TRANSPARENT');
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
            $table='springtube_artwork_devel_master';
            include('pagination.php');
            $data['artwork_springtube']=$this->artwork_springtube_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

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

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){
            
            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['print_type']=$this->common_model->select_active_drop_down('springtube_lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['lacquer']=$this->article_model->spec_all_active_record_search('article','14',$this->session->userdata['logged_in']['company_id']);
            $data['second_sub_group']=$this->second_sub_group_model->select_active_drop_down('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
           // $data['cold_foil']=$this->article_model->spec_all_active_record_search('article','304',$this->session->userdata['logged_in']['company_id']);
            $data['cold_foil']=$this->article_model->select_all_cold_foils();

            $data['springtube_laminate_color_master']=$this->common_model->select_active_drop_down('springtube_laminate_color_master',$this->session->userdata['logged_in']['company_id']);
            
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
            $this->form_validation->set_rules('laminate_color','Laminate Color' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('print_type','Print Type' ,'required|trim|xss_clean');            
            $this->form_validation->set_rules('non_lacquer_length','Non Lacquer Length' ,'required|trim|xss_clean|numeric');
            $this->form_validation->set_rules('cold_foil_1','Cold Foil 1' ,'trim|xss_clean');
            $this->form_validation->set_rules('cold_foil_2','Cold Foil 2' ,'trim|xss_clean');
            

            $this->form_validation->set_rules('pre_lacquer_1','Pre Lacquer 1' ,'trim|xss_clean');
            if(!empty($this->input->post('pre_lacquer_1'))){
            $this->form_validation->set_rules('pre_lacquer_1_perc','Pre Lacquer 1 %' ,'required|trim|xss_clean|numeric');
            }

            $this->form_validation->set_rules('pre_lacquer_2','Pre Lacquer 2' ,'trim|xss_clean');
            if(!empty($this->input->post('pre_lacquer_2'))){
            $this->form_validation->set_rules('pre_lacquer_2_perc','Pre Lacquer 2  %' ,'required|trim|xss_clean|numeric');
            }

            $this->form_validation->set_rules('post_lacquer_1','Post Lacquer 1' ,'trim|xss_clean');
            if(!empty($this->input->post('post_lacquer_1'))){
            $this->form_validation->set_rules('post_lacquer_1_perc','Post Lacquer 1 %' ,'required|trim|xss_clean|numeric');
            }

            $this->form_validation->set_rules('post_lacquer_2','Post Lacquer 2' ,'trim|xss_clean');
            if(!empty($this->input->post('post_lacquer_2'))){
            $this->form_validation->set_rules('post_lacquer_2_perc','Post Lacquer 2  %' ,'required|trim|xss_clean|numeric');
            }

            $this->form_validation->set_rules('body_making_type','Body Making/ Seam Type' ,'required|trim|xss_clean');

            if($this->form_validation->run()==FALSE){
              
              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              $data['print_type']=$this->common_model->select_active_drop_down('springtube_lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
              $data['lacquer']=$this->article_model->spec_all_active_record_search('article','14',$this->session->userdata['logged_in']['company_id']);
              $data['second_sub_group']=$this->second_sub_group_model->select_active_drop_down('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
              //$data['cold_foil']=$this->article_model->spec_all_active_record_search('article','304',$this->session->userdata['logged_in']['company_id']);
              $data['cold_foil']=$this->article_model->select_all_cold_foils();
              $data['springtube_laminate_color_master']=$this->common_model->select_active_drop_down('springtube_laminate_color_master',$this->session->userdata['logged_in']['company_id']);
            
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

              $data['version']=$this->artwork_springtube_model->select_artwork_version_no('springtube_artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'article_no',$article_no_arr[1]);

              foreach ($data['version'] as $version_row) {

                if($version_row->version_no==NULL){
                  $max_pkey=0;
                  //$result=$this->common_model->select_max_pkey('springtube_artwork_devel_master','ad_id',$this->session->userdata['logged_in']['company_id']); 

                  $result=$this->common_model->select_max_pkey_springtube('springtube_artwork_devel_master','ad_id',$this->session->userdata['logged_in']['company_id']);

                  echo $this->db->last_query();

                  foreach($result as $row){
                    $max_pkey=$row->ad_id;
                    //$max_pkey=substr($max_pkey,3);
                    $artwork_no=$max_pkey+1;                    
                   // $artwork_no=str_pad($max_pkey,2,0,STR_PAD_LEFT);
                    echo $artwork_no="SAW".$artwork_no;
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

              $result=$this->common_model->save('springtube_artwork_devel_master',$data);
             

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'1','parameter_value'=>$this->input->post('sleeve_dia'),'flag_multiple'=>'0');
              $result=$this->common_model->save('springtube_artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'2','parameter_value'=>$this->input->post('sleeve_length'),'flag_multiple'=>'0');
              $result=$this->common_model->save('springtube_artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'3','parameter_value'=>strtoupper($this->input->post('laminate_color')),'flag_multiple'=>'0');
              $result=$this->common_model->save('springtube_artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'4','parameter_value'=>$this->input->post('cold_foil_1'),'flag_multiple'=>'0');
              $result=$this->common_model->save('springtube_artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'5','parameter_value'=>'','flag_multiple'=>'0');
              $result=$this->common_model->save('springtube_artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'6','parameter_value'=>$this->input->post('cold_foil_2'),'flag_multiple'=>'0');
              $result=$this->common_model->save('springtube_artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'7','parameter_value'=>'','flag_multiple'=>'0');
              $result=$this->common_model->save('springtube_artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'8','parameter_value'=>$this->input->post('pre_lacquer_1'),'flag_multiple'=>'0');
              $result=$this->common_model->save('springtube_artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'9','parameter_value'=>$this->input->post('pre_lacquer_1_perc'),'flag_multiple'=>'0');
              $result=$this->common_model->save('springtube_artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'10','parameter_value'=>$this->input->post('pre_lacquer_2'),'flag_multiple'=>'0');
              $result=$this->common_model->save('springtube_artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'11','parameter_value'=>$this->input->post('pre_lacquer_2_perc'),'flag_multiple'=>'0');
              $result=$this->common_model->save('springtube_artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'12','parameter_value'=>$this->input->post('post_lacquer_1'),'flag_multiple'=>'0');

              $result=$this->common_model->save('springtube_artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'13','parameter_value'=>$this->input->post('post_lacquer_1_perc'),'flag_multiple'=>'0');
              $result=$this->common_model->save('springtube_artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'14','parameter_value'=>$this->input->post('post_lacquer_2'),'flag_multiple'=>'0');

              $result=$this->common_model->save('springtube_artwork_devel_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'15','parameter_value'=>$this->input->post('post_lacquer_2_perc'),'flag_multiple'=>'0');
              $result=$this->common_model->save('springtube_artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'16','parameter_value'=>$this->input->post('non_lacquer_length'),'flag_multiple'=>'0');
              $result=$this->common_model->save('springtube_artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'17','parameter_value'=>$this->input->post('body_making_type'),'flag_multiple'=>'0');
              $result=$this->common_model->save('springtube_artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'18','parameter_value'=>$this->input->post('print_type'),'flag_multiple'=>'0');
              $result=$this->common_model->save('springtube_artwork_devel_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'19','parameter_value'=>'','flag_multiple'=>'0');
              $result=$this->common_model->save('springtube_artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'20','parameter_value'=>'','flag_multiple'=>'0');
              $result=$this->common_model->save('springtube_artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'21','parameter_value'=>'','flag_multiple'=>'0');
              $result=$this->common_model->save('springtube_artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'22','parameter_value'=>'','flag_multiple'=>'0');
              $result=$this->common_model->save('springtube_artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                    'ad_id'=>$artwork_no,
                    'version_no'=>$version_no,
                    'lang_comments'=>'',
                    'language_id'=>$this->session->userdata['logged_in']['language_id']
                    );
              $result=$this->common_model->save('springtube_artwork_devel_master_lang',$data);

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

              header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              $data['print_type']=$this->common_model->select_active_drop_down('springtube_lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
              $data['lacquer']=$this->article_model->spec_all_active_record_search('article','14',$this->session->userdata['logged_in']['company_id']);
              $data['second_sub_group']=$this->second_sub_group_model->select_active_drop_down('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
              //$data['cold_foil']=$this->article_model->spec_all_active_record_search('article','304',$this->session->userdata['logged_in']['company_id']);  
              $data['cold_foil']=$this->article_model->select_all_cold_foils();            
              $data['springtube_laminate_color_master']=$this->common_model->select_active_drop_down('springtube_laminate_color_master',$this->session->userdata['logged_in']['company_id']);
            
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

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){

            $data['artwork_springtube']=$this->artwork_springtube_model->select_one_active_record('springtube_artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'springtube_artwork_devel_master.ad_id',$this->uri->segment(3),'springtube_artwork_devel_master.version_no',$this->uri->segment(4));

            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

            $data['springtube_lacquer_types_master']=$this->common_model->select_active_drop_down('springtube_lacquer_types_master',$this->session->userdata['logged_in']['company_id']);              
            $data['lacquer']=$this->article_model->spec_all_active_record_search('article','14',$this->session->userdata['logged_in']['company_id']);

            $data['second_sub_group']=$this->second_sub_group_model->select_active_drop_down('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);

            //$data['cold_foil']=$this->article_model->spec_all_active_record_search('article','304',$this->session->userdata['logged_in']['company_id']);
            $data['cold_foil']=$this->article_model->select_all_cold_foils();

            $data['springtube_laminate_color_master']=$this->common_model->select_active_drop_down('springtube_laminate_color_master',$this->session->userdata['logged_in']['company_id']);
            
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
            $this->form_validation->set_rules('artwork_no','Artwork No' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('version_no','Version No' ,'required|trim|xss_clean|numeric');
            $this->form_validation->set_rules('sleeve_dia','Sleeve Dia' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sleeve_length','Sleeve Length' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('laminate_color','Laminate Color' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('print_type','Print Type' ,'required|trim|xss_clean');            
            $this->form_validation->set_rules('non_lacquer_length','Non Lacquer Length' ,'required|trim|xss_clean|numeric');

            $this->form_validation->set_rules('cold_foil_1','Cold Foil 1' ,'trim|xss_clean');
            if(!empty($this->input->post('cold_foil_1'))){
              //$this->form_validation->set_rules('cold_foil_1_area','Cold Foil 1 SQM/Tube' ,'required|trim|xss_clean|decimal');
              $this->form_validation->set_rules('cold_foil_1_length','Cold Foil 1 Length' ,'trim|xss_clean');
              $this->form_validation->set_rules('cold_foil_1_width','Cold Foil 1 Width' ,'trim|xss_clean');
            }            

            $this->form_validation->set_rules('cold_foil_2','Cold Foil 2' ,'trim|xss_clean');
            if(!empty($this->input->post('cold_foil_2'))){
            //$this->form_validation->set_rules('cold_foil_2_area','Cold Foil 2 SQM/Tube' ,'required|trim|xss_clean|decimal');
              $this->form_validation->set_rules('cold_foil_2_length','Cold Foil 2 Length' ,'trim|xss_clean');
              $this->form_validation->set_rules('cold_foil_2_width','Cold Foil 2 Width' ,'trim|xss_clean');
            }

            $this->form_validation->set_rules('pre_lacquer_1','Pre Lacquer 1' ,'trim|xss_clean');
            if(!empty($this->input->post('pre_lacquer_1'))){
            $this->form_validation->set_rules('pre_lacquer_1_perc','Pre Lacquer 1 %' ,'required|trim|xss_clean|numeric');
            }

            $this->form_validation->set_rules('pre_lacquer_2','Pre Lacquer 2' ,'trim|xss_clean');
            if(!empty($this->input->post('pre_lacquer_2'))){
            $this->form_validation->set_rules('pre_lacquer_2_perc','Pre Lacquer 2  %' ,'required|trim|xss_clean|numeric');
            }

            $this->form_validation->set_rules('post_lacquer_1','Post Lacquer 1' ,'trim|xss_clean');
            if(!empty($this->input->post('post_lacquer_1'))){
            $this->form_validation->set_rules('post_lacquer_1_perc','Post Lacquer 1 %' ,'required|trim|xss_clean|numeric');
            }

            $this->form_validation->set_rules('post_lacquer_2','Post Lacquer 2' ,'trim|xss_clean');
            if(!empty($this->input->post('post_lacquer_2'))){
            $this->form_validation->set_rules('post_lacquer_2_perc','Post Lacquer 2  %' ,'required|trim|xss_clean|numeric');
            }

            $this->form_validation->set_rules('body_making_type','Body Making/ Seam Type' ,'required|trim|xss_clean');

              if($this->form_validation->run()==FALSE){

                $data['artwork_springtube']=$this->artwork_springtube_model->select_one_active_record('springtube_artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'springtube_artwork_devel_master.ad_id',$this->input->post('artwork_no'),'springtube_artwork_devel_master.version_no',$this->input->post('version_no'));

                $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['springtube_lacquer_types_master']=$this->common_model->select_active_drop_down('springtube_lacquer_types_master',$this->session->userdata['logged_in']['company_id']);              
                $data['lacquer']=$this->article_model->spec_all_active_record_search('article','14',$this->session->userdata['logged_in']['company_id']);
                $data['second_sub_group']=$this->second_sub_group_model->select_active_drop_down('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
                //$data['cold_foil']=$this->article_model->spec_all_active_record_search('article','304',$this->session->userdata['logged_in']['company_id']);
                $data['cold_foil']=$this->article_model->select_all_cold_foils();
                $data['springtube_laminate_color_master']=$this->common_model->select_active_drop_down('springtube_laminate_color_master',$this->session->userdata['logged_in']['company_id']);
            
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
                // Master table  update------------
                $data=array('adr_company_id'=>$customer_arr[1]);
                $result=$this->artwork_springtube_model->update_one_active_record('springtube_artwork_devel_master',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),$this->session->userdata['logged_in']['company_id']);

                // Details table Update by artworkparaid-------------

                $data=array('parameter_value'=>$this->input->post('sleeve_dia'));
                $result=$this->artwork_springtube_model->update_details_record_where('springtube_artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','1',$this->session->userdata['logged_in']['company_id']);

                $data=array('parameter_value'=>$this->input->post('sleeve_length'));
                $result=$this->artwork_springtube_model->update_details_record_where('springtube_artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','2',$this->session->userdata['logged_in']['company_id']);

                $data=array('parameter_value'=>$this->input->post('laminate_color'));
                $result=$this->artwork_springtube_model->update_details_record_where('springtube_artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','3',$this->session->userdata['logged_in']['company_id']);

               $data=array('parameter_value'=>$this->input->post('cold_foil_1'));
                $result=$this->artwork_springtube_model->update_details_record_where('springtube_artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','4',$this->session->userdata['logged_in']['company_id']);

                $data=array('parameter_value'=>$this->input->post('cold_foil_1_length'));
                $result=$this->artwork_springtube_model->update_details_record_where('springtube_artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','19',$this->session->userdata['logged_in']['company_id']);
                $data=array('parameter_value'=>$this->input->post('cold_foil_1_width'));
                $result=$this->artwork_springtube_model->update_details_record_where('springtube_artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','20',$this->session->userdata['logged_in']['company_id']);

                $data=array('parameter_value'=>$this->input->post('cold_foil_2'));
                $result=$this->artwork_springtube_model->update_details_record_where('springtube_artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','6',$this->session->userdata['logged_in']['company_id']);

                $data=array('parameter_value'=>$this->input->post('cold_foil_2_length'));
                $result=$this->artwork_springtube_model->update_details_record_where('springtube_artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','21',$this->session->userdata['logged_in']['company_id']);

                $data=array('parameter_value'=>$this->input->post('cold_foil_2_width'));
                $result=$this->artwork_springtube_model->update_details_record_where('springtube_artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','22',$this->session->userdata['logged_in']['company_id']);

                $data=array('parameter_value'=>$this->input->post('pre_lacquer_1'));
                $result=$this->artwork_springtube_model->update_details_record_where('springtube_artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','8',$this->session->userdata['logged_in']['company_id']);

                $data=array('parameter_value'=>$this->input->post('pre_lacquer_1_perc'));
                $result=$this->artwork_springtube_model->update_details_record_where('springtube_artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','9',$this->session->userdata['logged_in']['company_id']);

                $data=array('parameter_value'=>$this->input->post('pre_lacquer_2'));
                $result=$this->artwork_springtube_model->update_details_record_where('springtube_artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','10',$this->session->userdata['logged_in']['company_id']);

                $data=array('parameter_value'=>$this->input->post('pre_lacquer_2_perc'));
                $result=$this->artwork_springtube_model->update_details_record_where('springtube_artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','11',$this->session->userdata['logged_in']['company_id']);

                $data=array('parameter_value'=>$this->input->post('post_lacquer_1'));
                $result=$this->artwork_springtube_model->update_details_record_where('springtube_artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','12',$this->session->userdata['logged_in']['company_id']);

                $data=array('parameter_value'=>$this->input->post('post_lacquer_1_perc'));
                $result=$this->artwork_springtube_model->update_details_record_where('springtube_artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','13',$this->session->userdata['logged_in']['company_id']);

                $data=array('parameter_value'=>$this->input->post('post_lacquer_2'));
                $result=$this->artwork_springtube_model->update_details_record_where('springtube_artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','14',$this->session->userdata['logged_in']['company_id']);

                $data=array('parameter_value'=>$this->input->post('post_lacquer_2_perc'));
                $result=$this->artwork_springtube_model->update_details_record_where('springtube_artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','15',$this->session->userdata['logged_in']['company_id']);

                $data=array('parameter_value'=>$this->input->post('non_lacquer_length'));
                $result=$this->artwork_springtube_model->update_details_record_where('springtube_artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','16',$this->session->userdata['logged_in']['company_id']);

                $data=array('parameter_value'=>$this->input->post('body_making_type'));
                $result=$this->artwork_springtube_model->update_details_record_where('springtube_artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','17',$this->session->userdata['logged_in']['company_id']);

                $data=array('parameter_value'=>$this->input->post('print_type'));
                $result=$this->artwork_springtube_model->update_details_record_where('springtube_artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','18',$this->session->userdata['logged_in']['company_id']);

                       

                $data['page_name']='Sales';

                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                $data['artwork_springtube']=$this->artwork_springtube_model->select_one_active_record('springtube_artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'springtube_artwork_devel_master.ad_id',$this->input->post('artwork_no'),'springtube_artwork_devel_master.version_no',$this->input->post('version_no'));
               

                $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['springtube_lacquer_types_master']=$this->common_model->select_active_drop_down('springtube_lacquer_types_master',$this->session->userdata['logged_in']['company_id']);              
                $data['lacquer']=$this->article_model->spec_all_active_record_search('article','14',$this->session->userdata['logged_in']['company_id']);
                $data['second_sub_group']=$this->second_sub_group_model->select_active_drop_down('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
                //$data['cold_foil']=$this->article_model->spec_all_active_record_search('article','304',$this->session->userdata['logged_in']['company_id']);
                $data['cold_foil']=$this->article_model->select_all_cold_foils();

                $data['springtube_laminate_color_master']=$this->common_model->select_active_drop_down('springtube_laminate_color_master',$this->session->userdata['logged_in']['company_id']);
            
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
            $table='springtube_artwork_devel_master';
            include('pagination_archive.php');
            $data['artwork_springtube']=$this->artwork_springtube_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
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

  function attach(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->copy==1){

            $data['artwork_springtube']=$this->artwork_springtube_model->select_one_active_unapproved_record('springtube_artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'springtube_artwork_devel_master.ad_id',$this->uri->segment(3),'springtube_artwork_devel_master.version_no',$this->uri->segment(4));

            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['springtube_lacquer_types_master']=$this->common_model->select_active_drop_down('springtube_lacquer_types_master',$this->session->userdata['logged_in']['company_id']);              
            $data['lacquer']=$this->article_model->spec_all_active_record_search('article','14',$this->session->userdata['logged_in']['company_id']);
            $data['second_sub_group']=$this->second_sub_group_model->select_active_drop_down('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
            //$data['cold_foil']=$this->article_model->spec_all_active_record_search('article','304',$this->session->userdata['logged_in']['company_id']); 
            $data['cold_foil']=$this->article_model->select_all_cold_foils();

            $data['springtube_laminate_color_master']=$this->common_model->select_active_drop_down('springtube_laminate_color_master',$this->session->userdata['logged_in']['company_id']);      
            
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
              
              $this->form_validation->set_rules('print_type','Print Type' ,'required|trim|xss_clean');

              $this->form_validation->set_rules('cold_foil_1','Cold Foil 1' ,'trim|xss_clean');
              if(!empty($this->input->post('cold_foil_1'))){
                $this->form_validation->set_rules('cold_foil_1_length','Cold Foil 1 Length' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('cold_foil_1_width','Cold Foil 1 Width' ,'required|trim|xss_clean');
              }
              
              $this->form_validation->set_rules('cold_foil_2','Cold Foil 2' ,'trim|xss_clean');
              if(!empty($this->input->post('cold_foil_2'))){

              $this->form_validation->set_rules('cold_foil_2_length','Cold Foil 2 Length' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('cold_foil_2_width','Cold Foil 2 Width' ,'required|trim|xss_clean');
              }
            
              if (empty($_FILES['userfile']['name'])){
                $this->form_validation->set_rules('userfile', 'File', 'required');
              }

              $this->form_validation->set_rules('approval_authority','Approval Authority' ,'required|trim|xss_clean');

              if($this->form_validation->run()==FALSE){

                $data['artwork_springtube']=$this->artwork_springtube_model->select_one_active_unapproved_record('springtube_artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'springtube_artwork_devel_master.ad_id',$this->input->post('artwork_no'),'springtube_artwork_devel_master.version_no',$this->input->post('version_no'));

                $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['springtube_lacquer_types_master']=$this->common_model->select_active_drop_down('springtube_lacquer_types_master',$this->session->userdata['logged_in']['company_id']);              
                $data['lacquer']=$this->article_model->spec_all_active_record_search('article','14',$this->session->userdata['logged_in']['company_id']);
                $data['second_sub_group']=$this->second_sub_group_model->select_active_drop_down('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
                //$data['cold_foil']=$this->article_model->spec_all_active_record_search('article','304',$this->session->userdata['logged_in']['company_id']);
                $data['cold_foil']=$this->article_model->select_all_cold_foils();  

                $data['springtube_laminate_color_master']=$this->common_model->select_active_drop_down('springtube_laminate_color_master',$this->session->userdata['logged_in']['company_id']);      
                
                $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','980');

                $data['user']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);
                
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/attach-form',$data);
                $this->load->view('Home/footer');

              }else{               

                // File Upload----------------------------------  

                $config['upload_path'] = './assets/'.$this->session->userdata['logged_in']['company_id'].'/artwork_springtube/';
                $config['allowed_types'] = 'pdf|PDF';
                $config['max_size'] = '0';
                $this->load->library('upload',$config);
                $this->upload->initialize($config);


                if($this->upload->do_upload('userfile')){
                  $data= $this->upload->data();
                  $filename=$data['file_name'];

                  $data=array('artwork_image_nm'=>$filename);

                  $result=$this->artwork_springtube_model->update_one_active_record('springtube_artwork_devel_master',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),$this->session->userdata['logged_in']['company_id']);

                  // $data=array('parameter_value'=>$this->input->post('cold_foil_1_area'));

                  // $result=$this->artwork_springtube_model->update_details_record_where('springtube_artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','5',$this->session->userdata['logged_in']['company_id']);

                  // $data=array('parameter_value'=>$this->input->post('hot_foil_2_area'));

                  // $result=$this->artwork_springtube_model->update_details_record_where('springtube_artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','7',$this->session->userdata['logged_in']['company_id']);
                  
                  $data=array('parameter_value'=>$this->input->post('print_type'));
                  $result=$this->artwork_springtube_model->update_details_record_where('springtube_artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','18',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('cold_foil_1_length'));
                  $result=$this->artwork_springtube_model->update_details_record_where('springtube_artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','19',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('cold_foil_1_width'));
                  $result=$this->artwork_springtube_model->update_details_record_where('springtube_artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','20',$this->session->userdata['logged_in']['company_id']);


                  $data=array('parameter_value'=>$this->input->post('cold_foil_2_length'));
                  $result=$this->artwork_springtube_model->update_details_record_where('springtube_artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','21',$this->session->userdata['logged_in']['company_id']);

                  $data=array('parameter_value'=>$this->input->post('cold_foil_2_width'));
                  $result=$this->artwork_springtube_model->update_details_record_where('springtube_artwork_devel_details',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),'artwork_para_id','22',$this->session->userdata['logged_in']['company_id']);


                  $data['note']='Update Transaction Completed';
              }else{
                echo $data['error'] = $this->upload->display_errors();
              }

                if(!empty($this->input->post('approval_authority'))){

                      $data=array('pending_flag'=>'1');
                      $result=$this->artwork_springtube_model->update_one_active_record('springtube_artwork_devel_master',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),$this->session->userdata['logged_in']['company_id']);

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

                //echo $this->input->post('artwork_no');

                $data['page_name']='Sales';

                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                // $data['artwork_springtube']=$this->artwork_springtube_model->select_one_active_unapproved_record('springtube_artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'springtube_artwork_devel_master.ad_id',$this->input->post('artwork_no'),'springtube_artwork_devel_master.version_no',$this->input->post('version_no'));
                 
                 $data['artwork_springtube']=$this->artwork_springtube_model->select_one_active_record('springtube_artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'springtube_artwork_devel_master.ad_id',$this->input->post('artwork_no'),'springtube_artwork_devel_master.version_no',$this->input->post('version_no'));
                 //echo $this->db->last_query();

                //print_r($data['artwork_springtube']);

                $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['springtube_lacquer_types_master']=$this->common_model->select_active_drop_down('springtube_lacquer_types_master',$this->session->userdata['logged_in']['company_id']);              
                $data['lacquer']=$this->article_model->spec_all_active_record_search('article','14',$this->session->userdata['logged_in']['company_id']);
                $data['second_sub_group']=$this->second_sub_group_model->select_active_drop_down('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
                //$data['cold_foil']=$this->article_model->spec_all_active_record_search('article','304',$this->session->userdata['logged_in']['company_id']);  
                $data['cold_foil']=$this->article_model->select_all_cold_foils();

                $data['springtube_laminate_color_master']=$this->common_model->select_active_drop_down('springtube_laminate_color_master',$this->session->userdata['logged_in']['company_id']);      
                
                $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','980');

                $data['user']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);

                  header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
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

              $result=$this->artwork_springtube_model->update_one_active_record('springtube_artwork_devel_master',$data,'ad_id',$this->uri->segment(3),'version_no',$this->uri->segment(4),$this->session->userdata['logged_in']['company_id']);

              $data['artwork_springtube']=$this->artwork_springtube_model->select_one_active_record('springtube_artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'springtube_artwork_devel_master.ad_id',$this->uri->segment(3),'springtube_artwork_devel_master.version_no',$this->uri->segment(4));

              $data['page_name']='Sales';

              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['springtube_lacquer_types_master']=$this->common_model->select_active_drop_down('springtube_lacquer_types_master',$this->session->userdata['logged_in']['company_id']);              
                $data['lacquer']=$this->article_model->spec_all_active_record_search('article','14',$this->session->userdata['logged_in']['company_id']);
                $data['second_sub_group']=$this->second_sub_group_model->select_active_drop_down('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
                //$data['cold_foil']=$this->article_model->spec_all_active_record_search('article','304',$this->session->userdata['logged_in']['company_id']);
                $data['cold_foil']=$this->article_model->select_all_cold_foils();

                $data['springtube_laminate_color_master']=$this->common_model->select_active_drop_down('springtube_laminate_color_master',$this->session->userdata['logged_in']['company_id']);
               

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

              $result=$this->artwork_springtube_model->update_one_active_record('springtube_artwork_devel_master',$data,'ad_id',$this->uri->segment(3),'version_no',$this->uri->segment(4),$this->session->userdata['logged_in']['company_id']);

              $data['artwork_springtube']=$this->artwork_springtube_model->select_one_active_record('springtube_artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'springtube_artwork_devel_master.ad_id',$this->uri->segment(3),'springtube_artwork_devel_master.version_no',$this->uri->segment(4));

              $data['page_name']='Sales';

              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['springtube_lacquer_types_master']=$this->common_model->select_active_drop_down('springtube_lacquer_types_master',$this->session->userdata['logged_in']['company_id']);              
                $data['lacquer']=$this->article_model->spec_all_active_record_search('article','14',$this->session->userdata['logged_in']['company_id']);
                $data['second_sub_group']=$this->second_sub_group_model->select_active_drop_down('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
                //$data['cold_foil']=$this->article_model->spec_all_active_record_search('article','304',$this->session->userdata['logged_in']['company_id']);
                $data['cold_foil']=$this->article_model->select_all_cold_foils();

                $data['springtube_laminate_color_master']=$this->common_model->select_active_drop_down('springtube_laminate_color_master',$this->session->userdata['logged_in']['company_id']);
               

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
            $data['print_type']=$this->common_model->select_active_drop_down('springtube_lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
            $data['lacquer']=$this->article_model->spec_all_active_record_search('article','14',$this->session->userdata['logged_in']['company_id']);
            $data['second_sub_group']=$this->second_sub_group_model->select_active_drop_down('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
            //$data['cold_foil']=$this->article_model->spec_all_active_record_search('article','304',$this->session->userdata['logged_in']['company_id']);
            $data['cold_foil']=$this->article_model->select_all_cold_foils();

            $data['springtube_laminate_color_master']=$this->common_model->select_active_drop_down('springtube_laminate_color_master',$this->session->userdata['logged_in']['company_id']);

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


            $this->form_validation->set_rules('from_date','From Date' ,'required|trim|xss_clean|exact_length[10]');
            $this->form_validation->set_rules('to_date','To Date' ,'required|trim|xss_clean|exact_length[10]');
            $this->form_validation->set_rules('adr_company_id','Customer' ,'trim|xss_clean|callback_customer_check');
            $this->form_validation->set_rules('article_no','Article No' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('artwork_no','Artwork No' ,'trim|xss_clean|max_length[7]');
            $this->form_validation->set_rules('version_no','Version No' ,'trim|xss_clean|numeric');            
            $this->form_validation->set_rules('sleeve_dia','Sleeve Dia' ,'trim|xss_clean');
            $this->form_validation->set_rules('sleeve_length','Sleeve Length' ,'trim|xss_clean');
            $this->form_validation->set_rules('laminate_color','Laminate Color' ,'trim|xss_clean');
            $this->form_validation->set_rules('print_type','Print Type' ,'trim|xss_clean');        
            $this->form_validation->set_rules('non_lacquer_length','Non Lacquer Length' ,'trim|xss_clean|numeric');
            $this->form_validation->set_rules('cold_foil_1','Cold Foil 1' ,'trim|xss_clean');
            
            //$this->form_validation->set_rules('cold_foil_1_length','Cold Foil 1' ,'trim|xss_clean');
            //$this->form_validation->set_rules('cold_foil_1_width','Cold Foil 1' ,'trim|xss_clean');
           
            //$this->form_validation->set_rules('cold_foil_1_area','Cold Foil 1 SQM/Tube' ,'trim|xss_clean|decimal');
            $this->form_validation->set_rules('cold_foil_2','Cold Foil 2' ,'trim|xss_clean');
            //$this->form_validation->set_rules('cold_foil_2_area','Cold Foil 2 SQM/Tube' ,'trim|xss_clean|decimal');
           // $this->form_validation->set_rules('cold_foil_2_length','Cold Foil 1' ,'trim|xss_clean');
            //$this->form_validation->set_rules('cold_foil_2_width','Cold Foil 1' ,'trim|xss_clean');

            $this->form_validation->set_rules('pre_lacquer_1','Pre Lacquer 1' ,'trim|xss_clean');            
            $this->form_validation->set_rules('pre_lacquer_1_perc','Pre Lacquer 1 %' ,'trim|xss_clean');     
            $this->form_validation->set_rules('pre_lacquer_2','Pre Lacquer 2' ,'trim|xss_clean');           
            $this->form_validation->set_rules('pre_lacquer_2_perc','Pre Lacquer 2  %' ,'trim|xss_clean');            
            $this->form_validation->set_rules('post_lacquer_1','Post Lacquer 1' ,'trim|xss_clean');
            $this->form_validation->set_rules('post_lacquer_1_perc','Post Lacquer 1 %' ,'trim|xss_clean');           
            $this->form_validation->set_rules('post_lacquer_2','Post Lacquer 2' ,'trim|xss_clean');
            $this->form_validation->set_rules('post_lacquer_2_perc','Post Lacquer 2  %' ,'trim|xss_clean');
            $this->form_validation->set_rules('body_making_type','Body Making/ Seam Type' ,'trim|xss_clean');


            if($this->form_validation->run()==FALSE){

                $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                $data['print_type']=$this->common_model->select_active_drop_down('springtube_lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
                $data['lacquer']=$this->article_model->spec_all_active_record_search('article','14',$this->session->userdata['logged_in']['company_id']);
                $data['second_sub_group']=$this->second_sub_group_model->select_active_drop_down('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
               // $data['cold_foil']=$this->article_model->spec_all_active_record_search('article','304',$this->session->userdata['logged_in']['company_id']);
                $data['cold_foil']=$this->article_model->select_all_cold_foils();

                $data['springtube_laminate_color_master']=$this->common_model->select_active_drop_down('springtube_laminate_color_master',$this->session->userdata['logged_in']['company_id']);
            
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

                 if(!empty($this->input->post('cold_foil_1'))){
                  $search['cold_foil_1']=$this->input->post('cold_foil_1');
                 }
                 // if(!empty($this->input->post('cold_foil_1_length'))){
                 //  $search['cold_foil_1_length']=$this->input->post('cold_foil_1_length');
                 // }
                 // if(!empty($this->input->post('cold_foil_1_width'))){
                 //  $search['cold_foil_1_width']=$this->input->post('cold_foil_1_width');
                 // }
                 // if(!empty($this->input->post('cold_foil_1_area'))){
                 //  $search['cold_foil_1_area']=$this->input->post('cold_foil_1_area');
                 // }
                 if(!empty($this->input->post('cold_foil_2'))){
                  $search['cold_foil_2']=$this->input->post('cold_foil_2');
                 }
                 // if(!empty($this->input->post('cold_foil_2_area'))){
                 //  $search['cold_foil_2_area']=$this->input->post('cold_foil_2_area');
                 // } 

                 // if(!empty($this->input->post('cold_foil_2_length'))){
                 //  $search['cold_foil_2_length']=$this->input->post('cold_foil_2_length');
                 // }
                 // if(!empty($this->input->post('cold_foil_2_width'))){
                 //  $search['cold_foil_2_width']=$this->input->post('cold_foil_2_width');
                 // }                
                 
                 if(!empty($this->input->post('non_lacquer_length'))){
                  $search['non_lacquer_length']=$this->input->post('non_lacquer_length');
                 }
                
                if(!empty($this->input->post('pre_lacquer_1'))){
                  $search['pre_lacquer_1']=$this->input->post('pre_lacquer_1');
                }
                if(!empty($this->input->post('pre_lacquer_1_perc'))){
                  $search['pre_lacquer_1_perc']=$this->input->post('pre_lacquer_1_perc');
                }
                if(!empty($this->input->post('pre_lacquer_2'))){
                  $search['pre_lacquer_2']=$this->input->post('pre_lacquer_2');
                }
                if(!empty($this->input->post('pre_lacquer_2_perc'))){
                  $search['pre_lacquer_2_perc']=$this->input->post('pre_lacquer_2_perc');
                }

                if(!empty($this->input->post('post_lacquer_1'))){
                  $search['post_lacquer_1']=$this->input->post('post_lacquer_1');
                }
                if(!empty($this->input->post('post_lacquer_1_perc'))){
                  $search['post_lacquer_1_perc']=$this->input->post('post_lacquer_1_perc');
                }
                if(!empty($this->input->post('post_lacquer_2'))){
                  $search['post_lacquer_2']=$this->input->post('post_lacquer_2');
                }
                if(!empty($this->input->post('post_lacquer_2_perc'))){
                  $search['pre_lacquer_2_perc']=$this->input->post('pre_lacquer_2_perc');
                }

                if(!empty($this->input->post('body_making_type'))){
                  $search['body_making_type']=$this->input->post('body_making_type');
                }



                $data['artwork_springtube']=$this->artwork_springtube_model->active_record_search_new('springtube_artwork_devel_master',$data,$search,$this->common_model->change_date_format($this->input->post('from_date'),$this->session->userdata['logged_in']['company_id']),$this->common_model->change_date_format($this->input->post('to_date'),$this->session->userdata['logged_in']['company_id']),$this->session->userdata['logged_in']['company_id']);
                //echo $this->db->last_query();
                 
                if($data['artwork_springtube']!=FALSE){

                  $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
                  $data['print_type']=$this->common_model->select_active_drop_down('springtube_lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
                  $data['lacquer']=$this->article_model->spec_all_active_record_search('article','14',$this->session->userdata['logged_in']['company_id']);
                  $data['second_sub_group']=$this->second_sub_group_model->select_active_drop_down('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
                  //$data['cold_foil']=$this->article_model->spec_all_active_record_search('article','304',$this->session->userdata['logged_in']['company_id']);
                  $data['cold_foil']=$this->article_model->select_all_cold_foils();

                  $data['springtube_laminate_color_master']=$this->common_model->select_active_drop_down('springtube_laminate_color_master',$this->session->userdata['logged_in']['company_id']);
            
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
                      $data['print_type']=$this->common_model->select_active_drop_down('springtube_lacquer_types_master',$this->session->userdata['logged_in']['company_id']);
                      $data['lacquer']=$this->article_model->spec_all_active_record_search('article','14',$this->session->userdata['logged_in']['company_id']);
                      $data['second_sub_group']=$this->second_sub_group_model->select_active_drop_down('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
                      $data['cold_foil']=$this->article_model->spec_all_active_record_search('article','304',$this->session->userdata['logged_in']['company_id']);
                      

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

            $data['artwork_springtube']=$this->artwork_springtube_model->select_one_active_record('springtube_artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'springtube_artwork_devel_master.ad_id',$this->uri->segment(3),'springtube_artwork_devel_master.version_no',$this->uri->segment(4));

            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['springtube_lacquer_types_master']=$this->common_model->select_active_drop_down('springtube_lacquer_types_master',$this->session->userdata['logged_in']['company_id']);              
            $data['lacquer']=$this->article_model->spec_all_active_record_search('article','14',$this->session->userdata['logged_in']['company_id']);
            $data['second_sub_group']=$this->second_sub_group_model->select_active_drop_down('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
            //$data['cold_foil']=$this->article_model->spec_all_active_record_search('article','304',$this->session->userdata['logged_in']['company_id']);
            $data['cold_foil']=$this->article_model->select_all_cold_foils();

            $data['springtube_laminate_color_master']=$this->common_model->select_active_drop_down('springtube_laminate_color_master',$this->session->userdata['logged_in']['company_id']);
            
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
            $this->form_validation->set_rules('laminate_color','Laminate Color' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('print_type','Print Type' ,'required|trim|xss_clean');            
            $this->form_validation->set_rules('non_lacquer_length','Non Lacquer Length' ,'required|trim|xss_clean|numeric');

            $this->form_validation->set_rules('cold_foil_1','Cold Foil 1' ,'trim|xss_clean');
            $this->form_validation->set_rules('cold_foil_2','Cold Foil 2' ,'trim|xss_clean');
            

            $this->form_validation->set_rules('pre_lacquer_1','Pre Lacquer 1' ,'trim|xss_clean');
            if(!empty($this->input->post('pre_lacquer_1'))){
            $this->form_validation->set_rules('pre_lacquer_1_perc','Pre Lacquer 1 %' ,'required|trim|xss_clean|numeric');
            }

            $this->form_validation->set_rules('pre_lacquer_2','Pre Lacquer 2' ,'trim|xss_clean');
            if(!empty($this->input->post('pre_lacquer_2'))){
            $this->form_validation->set_rules('pre_lacquer_2_perc','Pre Lacquer 2  %' ,'required|trim|xss_clean|numeric');
            }

            $this->form_validation->set_rules('post_lacquer_1','Post Lacquer 1' ,'trim|xss_clean');
            if(!empty($this->input->post('post_lacquer_1'))){
            $this->form_validation->set_rules('post_lacquer_1_perc','Post Lacquer 1 %' ,'required|trim|xss_clean|numeric');
            }

            $this->form_validation->set_rules('post_lacquer_2','Post Lacquer 2' ,'trim|xss_clean');
            if(!empty($this->input->post('post_lacquer_2'))){
            $this->form_validation->set_rules('post_lacquer_2_perc','Post Lacquer 2  %' ,'required|trim|xss_clean|numeric');
            }

            $this->form_validation->set_rules('body_making_type','Body Making/ Seam Type' ,'required|trim|xss_clean');

            

            if($this->form_validation->run()==FALSE){
              
              $data['artwork_springtube']=$this->artwork_springtube_model->select_one_active_record('springtube_artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'springtube_artwork_devel_master.ad_id',$this->uri->segment(3),'springtube_artwork_devel_master.version_no',$this->uri->segment(4));

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              $data['springtube_lacquer_types_master']=$this->common_model->select_active_drop_down('springtube_lacquer_types_master',$this->session->userdata['logged_in']['company_id']);              
              $data['lacquer']=$this->article_model->spec_all_active_record_search('article','14',$this->session->userdata['logged_in']['company_id']);
              $data['second_sub_group']=$this->second_sub_group_model->select_active_drop_down('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
             // $data['cold_foil']=$this->article_model->spec_all_active_record_search('article','304',$this->session->userdata['logged_in']['company_id']);

              $data['cold_foil']=$this->article_model->select_all_cold_foils();

              $data['springtube_laminate_color_master']=$this->common_model->select_active_drop_down('springtube_laminate_color_master',$this->session->userdata['logged_in']['company_id']);
            
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

              $data['version']=$this->artwork_springtube_model->select_artwork_version_no('springtube_artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'article_no',$article_no_arr[1]);

              foreach ($data['version'] as $version_row) {

                if($version_row->version_no==NULL){
                  $max_pkey=0;
                  //$result=$this->common_model->select_max_pkey('springtube_artwork_devel_master','ad_id',$this->session->userdata['logged_in']['company_id']); 
                   $result=$this->common_model->select_max_pkey_springtube('springtube_artwork_devel_master','ad_id',$this->session->userdata['logged_in']['company_id']);

                  echo $this->db->last_query();
                  foreach($result as $row){
                    $max_pkey=$row->ad_id;
                    //$max_pkey=substr($max_pkey,3);
                    $artwork_no=$max_pkey+1;
                    //$artwork_no=str_pad($max_pkey,2,0,STR_PAD_LEFT);
                    echo $artwork_no="SAW".$artwork_no;
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

              $result=$this->common_model->save('springtube_artwork_devel_master',$data);
             

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'1','parameter_value'=>$this->input->post('sleeve_dia'),'flag_multiple'=>'0');
              $result=$this->common_model->save('springtube_artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'2','parameter_value'=>$this->input->post('sleeve_length'),'flag_multiple'=>'0');
              $result=$this->common_model->save('springtube_artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'3','parameter_value'=>strtoupper($this->input->post('laminate_color')),'flag_multiple'=>'0');
              $result=$this->common_model->save('springtube_artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'4','parameter_value'=>$this->input->post('cold_foil_1'),'flag_multiple'=>'0');
              $result=$this->common_model->save('springtube_artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'5','parameter_value'=>'','flag_multiple'=>'0');
              $result=$this->common_model->save('springtube_artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'6','parameter_value'=>$this->input->post('cold_foil_2'),'flag_multiple'=>'0');
              $result=$this->common_model->save('springtube_artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'7','parameter_value'=>'','flag_multiple'=>'0');
              $result=$this->common_model->save('springtube_artwork_devel_details',$data);            

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'8','parameter_value'=>$this->input->post('pre_lacquer_1'),'flag_multiple'=>'0');
              $result=$this->common_model->save('springtube_artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'9','parameter_value'=>$this->input->post('pre_lacquer_1_perc'),'flag_multiple'=>'0');
              $result=$this->common_model->save('springtube_artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'10','parameter_value'=>$this->input->post('pre_lacquer_2'),'flag_multiple'=>'0');
              $result=$this->common_model->save('springtube_artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'11','parameter_value'=>$this->input->post('pre_lacquer_2_perc'),'flag_multiple'=>'0');
              $result=$this->common_model->save('springtube_artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'12','parameter_value'=>$this->input->post('post_lacquer_1'),'flag_multiple'=>'0');

              $result=$this->common_model->save('springtube_artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'13','parameter_value'=>$this->input->post('post_lacquer_1_perc'),'flag_multiple'=>'0');
              $result=$this->common_model->save('springtube_artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'14','parameter_value'=>$this->input->post('post_lacquer_2'),'flag_multiple'=>'0');

              $result=$this->common_model->save('springtube_artwork_devel_details',$data);


              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'15','parameter_value'=>$this->input->post('post_lacquer_2_perc'),'flag_multiple'=>'0');
              $result=$this->common_model->save('springtube_artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'16','parameter_value'=>$this->input->post('non_lacquer_length'),'flag_multiple'=>'0');
              $result=$this->common_model->save('springtube_artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'17','parameter_value'=>$this->input->post('body_making_type'),'flag_multiple'=>'0');
              $result=$this->common_model->save('springtube_artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'18','parameter_value'=>$this->input->post('print_type'),'flag_multiple'=>'0');
              $result=$this->common_model->save('springtube_artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'19','parameter_value'=>'','flag_multiple'=>'0');
              $result=$this->common_model->save('springtube_artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'20','parameter_value'=>'','flag_multiple'=>'0');
              $result=$this->common_model->save('springtube_artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'21','parameter_value'=>'','flag_multiple'=>'0');
              $result=$this->common_model->save('springtube_artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],'ad_id'=>$artwork_no,'version_no'=>$version_no,'artwork_para_id'=>'22','parameter_value'=>'','flag_multiple'=>'0');
              $result=$this->common_model->save('springtube_artwork_devel_details',$data);

              $data=array('company_id'=>$this->session->userdata['logged_in']['company_id'],
                    'ad_id'=>$artwork_no,
                    'version_no'=>$version_no,
                    'lang_comments'=>'',
                    'language_id'=>$this->session->userdata['logged_in']['language_id']
                    );
              $result=$this->common_model->save('springtube_artwork_devel_master_lang',$data);

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
             
             $data['note']='Copy Transaction Completed';

              header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

              $data['artwork_springtube']=$this->artwork_springtube_model->select_one_active_record('springtube_artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'springtube_artwork_devel_master.ad_id',$artwork_no,'springtube_artwork_devel_master.version_no',$version_no);

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              $data['springtube_lacquer_types_master']=$this->common_model->select_active_drop_down('springtube_lacquer_types_master',$this->session->userdata['logged_in']['company_id']);              
              $data['lacquer']=$this->article_model->spec_all_active_record_search('article','14',$this->session->userdata['logged_in']['company_id']);
              $data['second_sub_group']=$this->second_sub_group_model->select_active_drop_down('article_second_subgroup_master',$this->session->userdata['logged_in']['company_id'],$this->session->userdata['logged_in']['language_id']);
              //$data['cold_foil']=$this->article_model->spec_all_active_record_search('article','304',$this->session->userdata['logged_in']['company_id']);
              $data['cold_foil']=$this->article_model->select_all_cold_foils();

              $data['springtube_laminate_color_master']=$this->common_model->select_active_drop_down('springtube_laminate_color_master',$this->session->userdata['logged_in']['company_id']);
            
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

  function view(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

            $data['artwork_springtube']=$this->artwork_springtube_model->select_one_active_record('springtube_artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'springtube_artwork_devel_master.ad_id',$this->uri->segment(3),'springtube_artwork_devel_master.version_no',$this->uri->segment(4));

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
            $data['artwork_springtube']=$this->artwork_springtube_model->select_one_active_record('springtube_artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'springtube_artwork_devel_master.ad_id',$this->uri->segment(3),'springtube_artwork_devel_master.version_no',$this->uri->segment(4));

           foreach($data['artwork_springtube'] as $artwork_springtube_row){

            $result_dia=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','1');
            if($result_dia==FALSE){
              $dia="";
            }else{
              foreach($result_dia as $dia_row){ $dia=$dia_row->parameter_value; }
            }

          $result_length=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','2');

           if($result_length==FALSE){
              $length="";
            }else{
              foreach($result_length as $length_row){ $length=$length_row->parameter_value; } 
            }

          $result_sleeve_color=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','3');

          if($result_sleeve_color==FALSE){
              $laminate_color="";
            }else{
              foreach($result_sleeve_color as $sleeve_color_row){ $laminate_color=$sleeve_color_row->parameter_value; }
            }

          $result_print_type=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','18');

          if($result_print_type==FALSE){
              $print_type="";
            }else{
              foreach($result_print_type as $print_type_row){ $print_type=$print_type_row->parameter_value; }
            }

            $result_cold_foil_1=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','4');

          if($result_cold_foil_1==FALSE){
              $cold_foil_1="";
            }else{
              foreach($result_cold_foil_1 as $cold_foil_1_row){ $cold_foil_1=$cold_foil_1_row->parameter_value; }
            }

            $result_cold_foil_1_width=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','20');

          if($result_cold_foil_1_width==FALSE){
              $cold_foil_1_width="";
            }else{
              foreach($result_cold_foil_1_width as $cold_foil_1_width_row){ $cold_foil_1_width=$cold_foil_1_width_row->parameter_value; }
            }


             $result_cold_foil_2=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','6');

          if($result_cold_foil_2==FALSE){
              $cold_foil_2="";
            }else{
              foreach($result_cold_foil_2 as $cold_foil_2_row){ $cold_foil_2=$cold_foil_2_row->parameter_value; 


              }
            }

            $result_cold_foil_2_width=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','22');

          if($result_cold_foil_2_width==FALSE){
              $cold_foil_2_width="";
            }else{
              foreach($result_cold_foil_2_width as $cold_foil_2_width_row){ $cold_foil_2_width=$cold_foil_2_width_row->parameter_value; }
            }


          $result_pre_lacquer_1=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','8');

          if($result_pre_lacquer_1==FALSE){
              $pre_lacquer_1="";
            }else{
              foreach($result_pre_lacquer_1 as $pre_lacquer_1_row){ $pre_lacquer_1=$pre_lacquer_1_row->parameter_value; }
            }


            $result_pre_lacquer_2=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','10');

          if($result_pre_lacquer_2==FALSE){
              $pre_lacquer_2="";
            }else{
              foreach($result_pre_lacquer_2 as $pre_lacquer_2_row){ $pre_lacquer_2=$pre_lacquer_2_row->parameter_value; }
            }



            $result_post_lacquer_1=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','12');

          if($result_post_lacquer_1==FALSE){
              $post_lacquer_1="";
            }else{
              foreach($result_post_lacquer_1 as $post_lacquer_1_row){ $post_lacquer_1=$post_lacquer_1_row->parameter_value; }
            }


            $result_post_lacquer_2=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','14');

          if($result_post_lacquer_2==FALSE){
              $post_lacquer_2="";
            }else{
              foreach($result_post_lacquer_2 as $post_lacquer_2_row){ $post_lacquer_2=$post_lacquer_2_row->parameter_value; }
            }


            $result_non_lacquer_length=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','16');
            if($result_non_lacquer_length==FALSE){
              $non_lacquer_length="";
            }else{
              foreach($result_non_lacquer_length as $non_lacquer_length_row){ $non_lacquer_length=$non_lacquer_length_row->parameter_value; }
            }


            $result_body_making_type=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','17');
            if($result_body_making_type==FALSE){
              $body_making_type="";
            }else{
              foreach($result_body_making_type as $body_making_type_row){ $body_making_type=$body_making_type_row->parameter_value; }
            }
   
   

            $xmlString ='<?xml version="1.0" encoding="UTF-8"?>
                            <parent>
                              <child>
                                <saw_id>'.str_replace('SAW','',$artwork_springtube_row->ad_id).'</saw_id>
                                <revision>'.$artwork_springtube_row->version_no.'</revision>
                                <adr_date>'.$artwork_springtube_row->ad_date.'</adr_date>
                                <customer_id>'.$artwork_springtube_row->adr_company_id.'</customer_id>
                                <customer_name>'.$artwork_springtube_row->customer_name.'</customer_name>
                                <article_code>'.$artwork_springtube_row->article_no.'</article_code>
                                <article_name>'.$artwork_springtube_row->article_name.'</article_name>
                                <dia>'.str_replace(' MM','',$dia).'</dia>
                                <tube_length>'.$length.'</tube_length>
                                <substrate_colour>'.$laminate_color.'</substrate_colour>
                                <print_type>'.$print_type.'</print_type>
                                <cold_foil_1>'.$this->common_model->get_article_name($cold_foil_1,$this->session->userdata['logged_in']['company_id']).'</cold_foil_1>
                                <cold_foil_1_width>'.$cold_foil_1_width.'</cold_foil_1_width>
                                <cold_foil_2>'.$this->common_model->get_article_name($cold_foil_2,$this->session->userdata['logged_in']['company_id']).'</cold_foil_2>
                                <cold_foil_2_width>'.$cold_foil_2_width.'</cold_foil_2_width>
                                <pre_varnish_1>'.$this->common_model->get_article_name($pre_lacquer_1,$this->session->userdata['logged_in']['company_id']).'</pre_varnish_1>
                                <pre_varnish_2>'.$this->common_model->get_article_name($pre_lacquer_2,$this->session->userdata['logged_in']['company_id']).'</pre_varnish_2>
                                <post_varnish_1>'.$this->common_model->get_article_name($post_lacquer_1,$this->session->userdata['logged_in']['company_id']).'</post_varnish_1>
                                <post_varnish_2>'.$this->common_model->get_article_name($post_lacquer_2,$this->session->userdata['logged_in']['company_id']).'</post_varnish_2>
                                <non_varnish_length>'.$non_lacquer_length.'</non_varnish_length>
                                <seam_type>'.$body_making_type.'</seam_type>
                              </child>
                            </parent>';                  

          }

            header('Content-type: text/xml');
            header('Content-Disposition: attachment; filename="'.$artwork_springtube_row->ad_id.'_R'.$artwork_springtube_row->version_no.'.xml"');
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

      $file_name='Spring Tube Artwork_report_'.date('Y-m-d-H:i:s').'.xlsx';
      $ObjPHPExcel->getActiveSheet()->setTitle('Artwork Data');

      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="'.$file_name.'"');
      header('Cache-Control: max-age=0');

      $writer=PHPExcel_IOFactory::createWriter($ObjPHPExcel,'Excel2007');
      $writer->save('php://output');
      exit;

    } 
  
  }

  public function pre_lcq_perc_check($str){
    $pre_lacquer_1_perc=$this->input->post('pre_lacquer_1_perc');
    $pre_lacquer_2_perc=$this->input->post('pre_lacquer_2_perc');
    $total_per=$pre_lacquer_1_perc+$pre_lacquer_2_perc;

    if($total_per!=100){
      $this->form_validation->set_message('pre_lcq_perc_check', 'The {field} field is incorrect');
      return FALSE;
    }else{
      return TRUE;
    }
  }

  public function post_lcq_perc_check($str){
    $post_lacquer_1_perc=$this->input->post('post_lacquer_1_perc');
    $post_lacquer_2_perc=$this->input->post('post_lacquer_2_perc');
    $total_per=$post_lacquer_1_perc+$post_lacquer_2_perc;

    if($total_per!=100){
      $this->form_validation->set_message('post_lcq_perc_check', 'The {field} field is incorrect');
      return FALSE;
    }else{
      return TRUE;
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

            $data['artwork_springtube']=$this->artwork_springtube_model->select_one_active_record('springtube_artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'springtube_artwork_devel_master.ad_id',$this->uri->segment(3),'springtube_artwork_devel_master.version_no',$this->uri->segment(4));   


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

                  $data['artwork_springtube']=$this->artwork_springtube_model->select_one_active_record('springtube_artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'springtube_artwork_devel_master.ad_id',$this->input->post('artwork_no'),'springtube_artwork_devel_master.version_no',$this->input->post('version_no')); 

                
                $this->load->view('Home/header');
                //$this->load->view('Home/nav',$data);
                //$this->load->view('Home/subnav');
                //$this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                 $this->load->view('Error/error-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/attach-customer-pdf',$data);
                //$this->load->view('Home/footer');

              }else{

                  // File Upload---------------------------------                  
                  $config['upload_path'] = './assets/000020/artwork_springtube/';
                  $config['allowed_types'] = 'pdf|PDF|gif|jpeg|jpg|png';
                  $config['max_size'] = '0';
                  $this->load->library('upload',$config);
                  $this->upload->initialize($config);

                  if($this->upload->do_upload('userfile1')){
                      $data= $this->upload->data();
                      $filename=$data['file_name'];

                      $data=array('customer_artwork_pdf'=>$filename);

                      $result=$this->artwork_springtube_model->update_one_active_record('springtube_artwork_devel_master',$data,'ad_id',$this->input->post('artwork_no'),'version_no',$this->input->post('version_no'),$this->session->userdata['logged_in']['company_id']);

                      $data['note']='File Successfully Uploaded.';
                  }else{
                    echo $this->upload->display_errors();
                  }
               

                $data['page_name']='Sales';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                                
                 $data['artwork_springtube']=$this->artwork_springtube_model->select_one_active_record('springtube_artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'springtube_artwork_devel_master.ad_id',$this->input->post('artwork_no'),'springtube_artwork_devel_master.version_no',$this->input->post('version_no'));
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



  
}