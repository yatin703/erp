<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coextube_ink_mixing extends CI_Controller {

  function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');       
      $this->load->model('coextube_ink_mixing_model');
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
            $table='coextube_ink_mixing_master';
            include('pagination.php');
            $data['coextube_ink_mixing_master']=$this->coextube_ink_mixing_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

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

            $data['coextube_color_master']=$this->common_model->select_active_drop_down('coextube_color_master',$this->session->userdata['logged_in']['company_id']);

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

            $this->form_validation->set_rules('master_ink','Pantone Code' ,'required|trim|xss_clean|is_unique[coextube_ink_mixing_master.pantone_code]|max_length[45]|callback_check_pantone_code');
             $this->form_validation->set_rules('substrate','Substrate' ,'required|trim|xss_clean|is_unique[coextube_ink_mixing_master.substrate]|max_length[45]');
             
            $arr=$this->input->post('inks');
            //print_r($this->input->post('pantone'));
            if(is_array($arr)){
              for($i=0;$i<count($arr);$i++){

                $this->form_validation->set_rules('inks[]','Inks '.$i ,'required|trim|xss_clean');
                $this->form_validation->set_rules('quantity[]','Quantity (Grams) '.$i ,'required|trim|xss_clean'); 
              }
            }
            

            if($this->form_validation->run()==FALSE){

              $data['coextube_color_master']=$this->common_model->select_active_drop_down('coextube_color_master',$this->session->userdata['logged_in']['company_id']);


              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
              $this->load->view('Home/footer');
            }else{

              $pantone_name='';
              if($this->input->post('master_ink')!=''){
                $pantone_code=$this->input->post('master_ink');
                $pantone_replaces    = str_replace(' ','',$pantone_code);
                $pantone_name        = preg_replace('/[^A-Za-z0-9 ]/', '', $pantone_replaces);
              }
              
              $data=array(                    
                'ink_mixing_date'=>date('Y-m-d'),
                'substrate'=>$this->input->post('substrate'),
                'pantone_code'=>$pantone_name,
                'user_id'=>$this->session->userdata['logged_in']['user_id'],
                'company_id'=>$this->session->userdata['logged_in']['company_id']                 
              );

              $mixing_id=$this->common_model->save_return_pkey('coextube_ink_mixing_master',$data);
              //$mixing_id=0;  
              $arr1=$this->input->post('inks');
              //print_r($arr1); 
              if($mixing_id!='' || $mixing_id!=0){               

                $arr1=$this->input->post('inks');
                 
                    //print_r($arr1);
                if(is_array($arr1)){
                  $j=1;
                  for($i=0;$i<count($arr1);$i++){
                      $ink_id='';
                      $ink_arr=explode("//", $this->input->post('inks['.$i.']'));
                      $ink_id= $ink_arr[1]; 
                      $data=array(                    
                        'mixing_id'=>$mixing_id,
                        'ink_seq_no'=>$j,
                        'ink_name'=>$ink_id,
                        'quantity'=>$this->input->post('quantity['.$i.']'),
                                   
                      );
                      
                      $result=$this->common_model->save('coextube_ink_mixing_details',$data);
                    $j++;  
                  }
                }

              }


              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
              $data['coextube_color_master']=$this->common_model->select_active_drop_down('coextube_color_master',$this->session->userdata['logged_in']['company_id']);

              $data['note']='Create Transaction Completed';
              header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

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

            $data['coextube_ink_mixing_master']=$this->coextube_ink_mixing_model->select_one_active_record('coextube_ink_mixing_master',$this->session->userdata['logged_in']['company_id'],'coextube_ink_mixing_master.mixing_id',$this->uri->segment(3));

            
            $dataa=array('mixing_id'=>$this->uri->segment(3));

            $data['coextube_ink_mixing_details']=$this->coextube_ink_mixing_model->active_details_records('coextube_ink_mixing_details',$dataa,$this->session->userdata['logged_in']['company_id']);
            
            $data['page_name']='Production';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
            $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

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
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){             

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
            $this->form_validation->set_rules('pantone_code','Pantone Code' ,'trim|xss_clean');         
                       
            if($this->form_validation->run()==FALSE){
              

              $data['page_name']='Production';

              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
              //$this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
              $this->load->view('Home/footer');
              
            }else{
                                            
              $data_search=array();

              if($this->input->post('pantone_code')!=''){                
                $data_search['pantone_code']=$this->input->post('pantone_code');
              }

              $data['coextube_ink_mixing_master']=$this->coextube_ink_mixing_model->active_record_search_1('coextube_ink_mixing_master',$this->session->userdata['logged_in']['company_id'],$data_search,$this->input->post('from_date'),$this->input->post('to_date'));
              //echo $this->db->last_query(); 

             $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);                
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());               

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
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


  function modify(){
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){
            
            $data['coextube_color_master']=$this->common_model->select_active_drop_down('coextube_color_master',$this->session->userdata['logged_in']['company_id']);

            $data['coextube_ink_mixing_master']=$this->coextube_ink_mixing_model->select_one_active_record_2('coextube_ink_mixing_master',$this->session->userdata['logged_in']['company_id'],'coextube_ink_mixing_master.mixing_id',$this->uri->segment(3));

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

              $this->form_validation->set_rules('master_ink','Pantone Code' ,'required|trim|xss_clean|is_unique[coextube_ink_mixing_master.pantone_code]|max_length[45]|callback_check_pantone_code');
             $this->form_validation->set_rules('substrate','Substrate' ,'required|trim|xss_clean|is_unique[coextube_ink_mixing_master.substrate]|max_length[45]');
             
              $arr=$this->input->post('inks');
              //print_r($this->input->post('pantone'));
              if(is_array($arr)){
                for($i=0;$i<count($arr);$i++){

                  $this->form_validation->set_rules('inks[]','Inks '.$i ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('quantity[]','Quantity (Grams) '.$i ,'required|trim|xss_clean');
                    
                }
              }             

              if($this->form_validation->run()==FALSE){
                
                $data['coextube_color_master']=$this->common_model->select_active_drop_down('coextube_color_master',$this->session->userdata['logged_in']['company_id']);

                $data['coextube_ink_mixing_master']=$this->coextube_ink_mixing_model->select_one_active_record_2('coextube_ink_mixing_master',$this->session->userdata['logged_in']['company_id'],'coextube_ink_mixing_master.mixing_id',$this->input->post('mixing_id'));
                
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
                $this->load->view('Home/footer');

              }else{

              $pantone_name='';
              if($this->input->post('master_ink')!=''){
                $pantone_code=$this->input->post('master_ink');
                $pantone_replaces    = str_replace(' ','',$pantone_code);
                $pantone_name        = preg_replace('/[^A-Za-z0-9 ]/', '', $pantone_replaces);
              }

                $data=array(                    
                  'ink_mixing_date'=>date('Y-m-d'),
                  'substrate'=>$this->input->post('substrate'),
                  'pantone_code'=>$pantone_name,
                  'user_id'=>$this->session->userdata['logged_in']['user_id'],
                  'company_id'=>$this->session->userdata['logged_in']['company_id']                 
                );

                $result=$this->common_model->update_one_active_record('coextube_ink_mixing_master',$data,'mixing_id',$this->input->post('mixing_id'),$this->session->userdata['logged_in']['company_id']);

                // Removing Ink details and inserting new
                $result=$this->common_model->delete_one_active_record_noncompany('coextube_ink_mixing_details','mixing_id',$this->input->post('mixing_id'));

                $arr1=$this->input->post('inks');
                //print_r($arr1); 
                    if($this->input->post('mixing_id')!='' || $this->input->post('mixing_id')!=0){

                      $arr1=$this->input->post('inks');
                      //print_r($arr1);
                      if(is_array($arr1)){
                        $j=1;

                        for($i=0;$i<count($arr1);$i++){

                            $ink_id='';
                            $ink_arr=explode("//", $this->input->post('inks['.$i.']'));
                            $ink_id= $ink_arr[1];

                            $data=array(                    
                              'mixing_id'=>$this->input->post('mixing_id'),
                              'ink_seq_no'=>$j,
                              'ink_name'=>$ink_id,
                              'quantity'=>$this->input->post('quantity['.$i.']'), 
                            );
                              
                            $result=$this->common_model->save('coextube_ink_mixing_details',$data);
                            $j++;  
                        }
                      }
                    }

                    if($result){              
                      $data['note']='Update Transaction Completed';
                    }else{
                      $data['error']='Update Transaction failed';
                    }

                  header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                  $data['page_name']='Production';

                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
                  
                  $data['coextube_color_master']=$this->common_model->select_active_drop_down('coextube_color_master',$this->session->userdata['logged_in']['company_id']);

                  $data['coextube_ink_mixing_master']=$this->coextube_ink_mixing_model->select_one_active_record_2('coextube_ink_mixing_master',$this->session->userdata['logged_in']['company_id'],'coextube_ink_mixing_master.mixing_id',$this->input->post('mixing_id'));
                 
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

                $result=$this->common_model->update_one_active_record('coextube_ink_mixing_master',$data,'mixing_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

                $data['coextube_ink_mixing_master']=$this->coextube_ink_mixing_model->select_one_inactive_record('coextube_ink_mixing_master',$this->session->userdata['logged_in']['company_id'],'coextube_ink_mixing_master.mixing_id',$this->uri->segment(3));


              
                $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

                 

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

  function archive_records(){
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->delete==1){

            $table='coextube_ink_mixing_master';
            include('pagination.php');
            $data['coextube_ink_mixing_master']=$this->coextube_ink_mixing_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

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
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->dearchive==1){
              

              $data=array('archive'=>'0');              

              $result=$this->common_model->update_one_active_record('coextube_ink_mixing_master',$data,'mixing_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

              $data['coextube_ink_mixing_master']=$this->coextube_ink_mixing_model->select_one_active_record('coextube_ink_mixing_master',$this->session->userdata['logged_in']['company_id'],'coextube_ink_mixing_master.mixing_id',$this->uri->segment(3));

              $data['page_name']='Production';

              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());              
                  

                  $data['note']='Dearchive Transaction completed';
                  header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
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

  
  
  


  public function check_pantone_code($str)
  { 

    if(!empty($str)){
    $master_ink             = $this->input->post('master_ink');
    $master_ink_replaces    = str_replace(' ','',$master_ink);
    $pantone_code           = preg_replace('/[^A-Za-z0-9 ]/', '', $master_ink_replaces);

    $result   = $this->coextube_ink_mixing_model->get_pantone_code($pantone_code);
      
    $pantone='';
      if($result == TRUE){
        foreach ($result as $item) {
          $pantone =  $item['pantone_code'];
        }
      }else{
        //echo'0';
      } 
    
      if($pantone_code == $pantone){
        $this->form_validation->set_message('check_pantone_code', '{field} Already Exit');
          return false;
      }else{
          return TRUE;
      } 

    }
  }







}