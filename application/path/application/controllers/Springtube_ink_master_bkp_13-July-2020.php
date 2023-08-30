<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Springtube_ink_master extends CI_Controller {

  function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');       
      $this->load->model('article_model');
      $this->load->model('second_sub_group_model');
      $this->load->model('springtube_ink_master_model');       
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
            $table='springtube_ink_master';
            include('pagination.php');
            $data['springtube_ink_master']=$this->springtube_ink_master_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

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

            $data['springtube_laminate_color_master']=$this->common_model->select_active_drop_down('springtube_laminate_color_master',$this->session->userdata['logged_in']['company_id']);         

            $dataa=array();
            $data['article']=$this->article_model->springtube_printing_ink_lacquer('article',$dataa,$this->session->userdata['logged_in']['company_id']);

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

            $this->form_validation->set_rules('substrate','Substrate' ,'required|trim|xss_clean');

            $this->form_validation->set_rules('ink_manufacturer','Ink Manufacturer' ,'required|trim|xss_clean|max_length[100]');
            
            $this->form_validation->set_rules('ink_name','Ink Name' ,'required|trim|xss_clean|max_length[100]');

            $this->form_validation->set_rules('ink_code','Ink Code' ,'required|trim|xss_clean|max_length[100]');
            
            $this->form_validation->set_rules('ink_category','Ink category' ,'required|trim|xss_clean');

            $this->form_validation->set_rules('ink_migration','Ink migration' ,'required|trim|xss_clean');

            $this->form_validation->set_rules('ink_composition','Ink composition' ,'required|trim|xss_clean');

            $this->form_validation->set_rules('comment','Comment' ,'trim|xss_clean');

            if($this->input->post('ink_composition')==1){

              $this->form_validation->set_rules('article_no','Article No' ,'required|trim|xss_clean|callback_article_check|is_unique[springtube_ink_master.article_no]');
            } 
            

            if($this->form_validation->run()==FALSE){
              
              $data['springtube_laminate_color_master']=$this->common_model->select_active_drop_down('springtube_laminate_color_master',$this->session->userdata['logged_in']['company_id']);         

              $dataa=array();
              $data['article']=$this->article_model->springtube_printing_ink_lacquer('article',$dataa,$this->session->userdata['logged_in']['company_id']);


              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
              $this->load->view('Home/footer');
            }else{


              $article_no='';
              if($this->input->post('ink_composition')=='1'){
                if($this->input->post('article_no')!=''){
                  $article_arr=explode("//", $this->input->post('article_no'));
                  $article_no=$article_arr[1];
                }else{
                  $article_no='';
                }

              }else{
                $article_no='';
              }
                          
              $ink_desc=strtoupper($this->input->post('ink_manufacturer')).' '.strtoupper($this->input->post('ink_category')).' '.strtoupper($this->input->post('ink_migration')).' '.strtoupper($this->input->post('substrate')).' '.strtoupper($this->input->post('ink_name')).' '.strtoupper($this->input->post('ink_code'));

              $count=$this->common_model->active_record_count_where_pkey('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],'ink_desc',$ink_desc);

              if($count>0){

                $data['error']='Same Ink already exist';

              }else{
              
                $data=array(                    
                   
                  'substrate'=>strtoupper($this->input->post('substrate')),
                  'ink_manufacturer'=>strtoupper($this->input->post('ink_manufacturer')),
                  'ink_name'=>strtoupper($this->input->post('ink_name')),
                  'ink_code'=>strtoupper($this->input->post('ink_code')),
                  'ink_category'=>strtoupper($this->input->post('ink_category')),
                  'ink_migration'=>strtoupper($this->input->post('ink_migration')),
                  'ink_composition'=>$this->input->post('ink_composition'),
                  'article_no'=>$article_no,                 
                  'comment'=>strtoupper($this->input->post('comment')),
                  'user_id'=>$this->session->userdata['logged_in']['user_id'],
                  'company_id'=>$this->session->userdata['logged_in']['company_id'],
                  'ink_creation_date'=>date('Y-m-d'),
                  'ink_desc'=>$ink_desc
                       
                );

              $result=$this->common_model->save('springtube_ink_master',$data);

              if($result){
                 $data['note']='Create Transaction Completed';
              }else{
                $data['error']='Create Transaction failed';
              }
            }                 

              

              header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
               
              $data['springtube_laminate_color_master']=$this->common_model->select_active_drop_down('springtube_laminate_color_master',$this->session->userdata['logged_in']['company_id']);         

              $dataa=array();
              $data['article']=$this->article_model->springtube_printing_ink_lacquer('article',$dataa,$this->session->userdata['logged_in']['company_id']);

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

            $data['springtube_ink_master']=$this->springtube_ink_master_model->select_one_active_record('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],'ink_id',$this->uri->segment(3));

            $data['springtube_laminate_color_master']=$this->common_model->select_active_drop_down('springtube_laminate_color_master',$this->session->userdata['logged_in']['company_id']);         

            $dataa=array();
            $data['article']=$this->article_model->springtube_printing_ink_lacquer('article',$dataa,$this->session->userdata['logged_in']['company_id']);


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

              $this->form_validation->set_rules('substrate','Substrate' ,'required|trim|xss_clean');

              $this->form_validation->set_rules('ink_manufacturer','Ink Manufacturer' ,'required|trim|xss_clean|max_length[100]');
              
              $this->form_validation->set_rules('ink_name','Ink Name' ,'required|trim|xss_clean|max_length[100]');

              $this->form_validation->set_rules('ink_code','Ink Code' ,'required|trim|xss_clean|max_length[100]');
              
              $this->form_validation->set_rules('ink_category','Ink category' ,'required|trim|xss_clean');

              $this->form_validation->set_rules('ink_migration','Ink migration' ,'required|trim|xss_clean');

              $this->form_validation->set_rules('ink_composition','Ink composition' ,'required|trim|xss_clean');

              $this->form_validation->set_rules('comment','Comment' ,'trim|xss_clean');

              if($this->input->post('ink_composition')==1){

                $this->form_validation->set_rules('article_no','Article No' ,'required|trim|xss_clean|callback_article_check');
              } 

              if($this->form_validation->run()==FALSE){

                
                $data['springtube_ink_master']=$this->springtube_ink_master_model->select_one_active_record('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],'ink_id',$this->uri->segment(3));

                $data['springtube_laminate_color_master']=$this->common_model->select_active_drop_down('springtube_laminate_color_master',$this->session->userdata['logged_in']['company_id']);         

                $dataa=array();
                $data['article']=$this->article_model->springtube_printing_ink_lacquer('article',$dataa,$this->session->userdata['logged_in']['company_id']);
                
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
                $this->load->view('Home/footer');

              }else{                 

                $article_no='';
                if($this->input->post('ink_composition')=='1'){
                  if($this->input->post('article_no')!=''){
                    $article_arr=explode("//", $this->input->post('article_no'));
                    $article_no=$article_arr[1];
                  }else{
                    $article_no='';
                  }

              }else{
                  $article_no='';
                }

                $ink_desc=strtoupper($this->input->post('ink_manufacturer')).' '.strtoupper($this->input->post('ink_category')).' '.strtoupper($this->input->post('ink_migration')).' '.strtoupper($this->input->post('substrate')).' '.strtoupper($this->input->post('ink_name')).' '.strtoupper($this->input->post('ink_code'));
                
                $count=$this->common_model->active_record_count_where_pkey('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],'ink_desc',$ink_desc);

              if($count>0){

                $data['error']='Same Ink already exist';

              }else{
                
                $data=array(                    
                   
                  'substrate'=>strtoupper($this->input->post('substrate')),
                  'ink_manufacturer'=>strtoupper($this->input->post('ink_manufacturer')),
                  'ink_name'=>strtoupper($this->input->post('ink_name')),
                  'ink_code'=>strtoupper($this->input->post('ink_code')),
                  'ink_category'=>strtoupper($this->input->post('ink_category')),
                  'ink_migration'=>strtoupper($this->input->post('ink_migration')),
                  'ink_composition'=>$this->input->post('ink_composition'),
                  'article_no'=>$article_no,                 
                  'comment'=>strtoupper($this->input->post('comment')),
                  'user_id'=>$this->session->userdata['logged_in']['user_id'],
                  'ink_desc'=>$ink_desc                   
                       
                );

                $result=$this->common_model->update_one_active_record('springtube_ink_master',$data,'ink_id',$this->input->post('ink_id'),$this->session->userdata['logged_in']['company_id']);

                if($result){                  
                  $data['note']='Update Transaction Completed';
                }else{
                  $data['error']='Update Transaction Failed';
                }
              }
                 
                
                header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                $data['springtube_ink_master']=$this->springtube_ink_master_model->select_one_active_record('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],'ink_id',$this->input->post('ink_id'));

                $data['springtube_laminate_color_master']=$this->common_model->select_active_drop_down('springtube_laminate_color_master',$this->session->userdata['logged_in']['company_id']);         

                $dataa=array();
                $data['article']=$this->article_model->springtube_printing_ink_lacquer('article',$dataa,$this->session->userdata['logged_in']['company_id']); 

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

                  $result=$this->common_model->update_one_active_record('springtube_ink_master',$data,'ink_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

                  $data['springtube_ink_master']=$this->springtube_ink_master_model->select_one_active_record('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],'ink_id',$this->uri->segment(3));

                  $data['springtube_laminate_color_master']=$this->common_model->select_active_drop_down('springtube_laminate_color_master',$this->session->userdata['logged_in']['company_id']);         

                  $dataa=array();
                  $data['article']=$this->article_model->springtube_printing_ink_lacquer('article',$dataa,$this->session->userdata['logged_in']['company_id']);

                                   
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

              $data=array('archive'=>'0');

              $result=$this->common_model->update_one_active_record('springtube_ink_master',$data,'ink_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

              $data['springtube_ink_master']=$this->springtube_ink_master_model->select_one_active_record('springtube_ink_master',$this->session->userdata['logged_in']['company_id'],'ink_id',$this->uri->segment(3));

              $data['springtube_laminate_color_master']=$this->common_model->select_active_drop_down('springtube_laminate_color_master',$this->session->userdata['logged_in']['company_id']);         

              $dataa=array();
              $data['article']=$this->article_model->springtube_printing_ink_lacquer('article',$dataa,$this->session->userdata['logged_in']['company_id']);

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

             $table='springtube_ink_master';
            include('pagination.php');
            $data['springtube_ink_master']=$this->springtube_ink_master_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

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

            $data['springtube_laminate_color_master']=$this->common_model->select_active_drop_down('springtube_laminate_color_master',$this->session->userdata['logged_in']['company_id']);         

            $dataa=array();
            $data['article']=$this->article_model->springtube_printing_ink_lacquer('article',$dataa,$this->session->userdata['logged_in']['company_id']);


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

              $this->form_validation->set_rules('substrate','Substrate' ,'trim|xss_clean');

              $this->form_validation->set_rules('ink_manufacturer','Ink Manufacturer' ,'trim|xss_clean|max_length[100]');
              
              $this->form_validation->set_rules('ink_name','Ink Name' ,'trim|xss_clean|max_length[100]');

              $this->form_validation->set_rules('ink_code','Ink Code' ,'trim|xss_clean|max_length[100]');
              
              $this->form_validation->set_rules('ink_category','Ink category' ,'trim|xss_clean');

              $this->form_validation->set_rules('ink_migration','Ink migration' ,'trim|xss_clean');

              $this->form_validation->set_rules('ink_composition','Ink composition' ,'trim|xss_clean');

              $this->form_validation->set_rules('comment','Comment' ,'trim|xss_clean');

              $this->form_validation->set_rules('article_no','Article No' ,'trim|xss_clean');
                

            if($this->form_validation->run()==FALSE){

              $data['springtube_laminate_color_master']=$this->common_model->select_active_drop_down('springtube_laminate_color_master',$this->session->userdata['logged_in']['company_id']);         

              $dataa=array();
              $data['article']=$this->article_model->springtube_printing_ink_lacquer('article',$dataa,$this->session->userdata['logged_in']['company_id']);
  

               
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                $this->load->view('Home/footer');
            }else{

              $article_no='';

              if($this->input->post('article_no')!=''){
                $article_no=$this->input->post('article_no');
              }
              

               
              $data=array(                    
                 
                'substrate'=>strtoupper($this->input->post('substrate')),
                'ink_manufacturer'=>strtoupper($this->input->post('ink_manufacturer')),
                'ink_name'=>strtoupper($this->input->post('ink_name')),
                'ink_code'=>strtoupper($this->input->post('ink_code')),
                'ink_category'=>strtoupper($this->input->post('ink_category')),
                'ink_migration'=>strtoupper($this->input->post('ink_migration')),
                'ink_composition'=>$this->input->post('ink_composition'),
                'article_no'=>$article_no,                 
                'comment'=>strtoupper($this->input->post('comment'))
                //'ink_desc'=strtoupper($this->input->post('ink_desc'))
                     
              );

                $data['springtube_ink_master']=$this->springtube_ink_master_model->active_record_search('springtube_ink_master',$data,$this->common_model->change_date_format($this->input->post('from_date'),$this->session->userdata['logged_in']['company_id']),$this->common_model->change_date_format($this->input->post('to_date'),$this->session->userdata['logged_in']['company_id']),$this->session->userdata['logged_in']['company_id']);
                //$this->db->last_query();
                 
                if($data['springtube_ink_master']!=FALSE){

                    $data['springtube_laminate_color_master']=$this->common_model->select_active_drop_down('springtube_laminate_color_master',$this->session->userdata['logged_in']['company_id']);         

                    $dataa=array();
                    $data['article']=$this->article_model->springtube_printing_ink_lacquer('article',$dataa,$this->session->userdata['logged_in']['company_id']);


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

                      $data['springtube_laminate_color_master']=$this->common_model->select_active_drop_down('springtube_laminate_color_master',$this->session->userdata['logged_in']['company_id']);         

                      $dataa=array();
                      $data['article']=$this->article_model->springtube_printing_ink_lacquer('article',$dataa,$this->session->userdata['logged_in']['company_id']);
                    

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

 

  
}