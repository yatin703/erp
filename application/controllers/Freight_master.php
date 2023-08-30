<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Freight_master extends CI_Controller {



  function __construct(){

    parent::__construct();

    if($this->session->userdata('logged_in')){

      $this->load->model('common_model');
      $this->load->model('customer_model'); 
      $this->load->model('freight_master_model');    
      
    }else{

      redirect('login','refresh');

    }

  }


  public function index(){    
    
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){

      foreach ($data['module'] as $module_row) {

        if($module_row->module_name==='Sales'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {

            if($formrights_row->view==1){
   
              $table='freight_master';
              include('pagination.php');

              $data['freight_master']=$this->freight_master_model->select_active_records($config["per_page"], $this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());


              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
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

  public function create(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

              $data['sleeve_diameter_master']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
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

  public function save(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

    foreach ($data['formrights'] as $formrights_row) {
    if($formrights_row->new==1){
   
    
      $this->form_validation->set_rules('from_date','Apply From Date' ,'required|xss_clean|callback_check_data');
      $this->form_validation->set_rules('to_date','Apply To Date','required|xss_clean');
      $this->form_validation->set_rules('customer_no','Customer','required|xss_clean');
      $this->form_validation->set_rules('sleeve_id','Dia','required|xss_clean');
      $this->form_validation->set_rules('cost_per_tube','Cost Per Tube','required|xss_clean');
       

    if($this->form_validation->run()==FALSE){

      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $data['sleeve_diameter_master']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
      
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
      $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
      $this->load->view('Home/footer');

    }
    else{

          $customer_no='';
          $customer_arr=explode("//",$this->input->post('customer_no'));
          if(count($customer_arr)>=3){

            $customer_no=$customer_arr[1];
          }

          $data=array(                  
            'customer_no'=>$customer_no,
            'sleeve_id'=>$this->input->post('sleeve_id'),
            'cost_per_tube'=>$this->input->post('cost_per_tube'),
            'company_id'=>$this->session->userdata['logged_in']['company_id'],
            'apply_from_date'=>$this->input->post('from_date'),
            'apply_to_date'=>$this->input->post('to_date')
          );

          $result=$this->common_model->save('freight_master',$data);

          if($result==1){

            $data['note']='Save Transaction Completed';

            header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

            $data['page_name']='Sales';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
            $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
            $this->load->view('Home/footer');

             
          }
          else{

            $data['note']='Error in Save Transaction';

            $data['page_name']='Sales';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Error/error-title',$data);
            $this->load->view('Home/footer');

        }

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

            $data['sleeve_diameter_master']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
   
            $data['freight_master']=$this->common_model->select_one_active_record('freight_master',$this->session->userdata['logged_in']['company_id'],'freight_master_id',$this->uri->segment(3));

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



  public function update(){

     $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){

              $this->form_validation->set_rules('from_date','Apply From Date' ,'required|xss_clean');
              $this->form_validation->set_rules('to_date','Apply To Date','required|xss_clean');
              $this->form_validation->set_rules('customer_no','Customer','required|xss_clean');
              $this->form_validation->set_rules('sleeve_id','Dia','required|xss_clean');
              $this->form_validation->set_rules('cost_per_tube','Cost Per Tube','required|xss_clean');
               

             

    if($this->form_validation->run()==FALSE){

      
      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $data['sleeve_diameter_master']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
   
      $data['freight_master']=$this->common_model->select_one_active_record('freight_master',$this->session->userdata['logged_in']['company_id'],'freight_master_id',$this->input->post('freight_master_id'));

      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
      $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
      $this->load->view('Home/footer');

    }
    else{

      $customer_no='';
          $customer_arr=explode("//",$this->input->post('customer_no'));
          if(count($customer_arr)>=3){

            $customer_no=$customer_arr[1];
          }

          $data=array(                  
            'customer_no'=>$customer_no,
            'sleeve_id'=>$this->input->post('sleeve_id'),
            'cost_per_tube'=>$this->input->post('cost_per_tube'),
            'company_id'=>$this->session->userdata['logged_in']['company_id'],
            'apply_from_date'=>$this->input->post('from_date'),
            'apply_to_date'=>$this->input->post('to_date')
          );         


          $result=$this->common_model->update_one_active_record('freight_master',$data,'freight_master_id',$this->input->post('freight_master_id'),$this->session->userdata['logged_in']['company_id']);
        
        if($result==1){

            $data['note']='Update Transaction Completed';

            header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

            $data['sleeve_diameter_master']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
   
            $data['freight_master']=$this->common_model->select_one_active_record('freight_master',$this->session->userdata['logged_in']['company_id'],'freight_master_id',$this->input->post('freight_master_id'));

            $data['page_name']='Sales';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
            $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
            $this->load->view('Home/footer');


        }
        else{

          $data['note']='Error in Update Transaction';

          $data['page_name']='Sales';
          $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

          $this->load->view('Home/header');
          $this->load->view('Home/nav',$data);
          $this->load->view('Home/subnav');
          $this->load->view('Error/error-title',$data);
          $this->load->view('Home/footer');

        }

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

  public function delete(){

    $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

              $data=array('archive'=>'1');
              $result=$this->common_model->update_one_active_record('freight_master',$data,'freight_master_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);
        

    if($result){

      $data['note']="Archive Transaction completed";

      header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());


      $data['sleeve_diameter_master']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
   
      $data['freight_master']=$this->common_model->select_one_inactive_record('freight_master',$this->session->userdata['logged_in']['company_id'],'freight_master_id',$this->uri->segment(3));
         

      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
      $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
      $this->load->view('Home/footer');


    }
    else{
        $data['note']='Error in Archive Transaction';

        $data['page_name']='Sales';
        $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

        $this->load->view('Home/header');
        $this->load->view('Home/nav',$data);
        $this->load->view('Home/subnav');
        $this->load->view('Error/error-title',$data);
        $this->load->view('Home/footer');



    }

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

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->delete==1){

              $table='freight_master';

              include('pagination_archive.php');

              $data['freight_master']=$this->common_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/archive-title');
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

            $data=array('archive'=>'0');
            $result=$this->common_model->update_one_active_record('freight_master',$data,'freight_master_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

            if($result){

              $data['note']="Dearchive Transaction completed";

              header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

              $data['sleeve_diameter_master']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
           
              $data['freight_master']=$this->common_model->select_one_active_record('freight_master',$this->session->userdata['logged_in']['company_id'],'freight_master_id',$this->uri->segment(3));
             
           


              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
              $this->load->view('Home/footer');


            }
            else{
                $data['note']='Error in Dearchive Transaction';

                $data['page_name']='Sales';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view('Error/error-title',$data);
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

  public function search(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){

              $data['sleeve_diameter_master']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
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

    public function search_result(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

    foreach ($data['formrights'] as $formrights_row) {
    if($formrights_row->view==1){   
    
      $this->form_validation->set_rules('from_date','Apply From Date' ,'xss_clean');
      $this->form_validation->set_rules('to_date','Apply To Date','xss_clean');
      $this->form_validation->set_rules('customer_no','Customer','xss_clean');
      $this->form_validation->set_rules('sleeve_id','Dia','xss_clean');
      $this->form_validation->set_rules('cost_per_tube','Cost Per Tube','xss_clean');
      

    if($this->form_validation->run()==FALSE){

      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $data['sleeve_diameter_master']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

      
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
      $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
      $this->load->view('Home/footer');

    }
    else{    

          $customer_no='';
          $customer_arr=explode("//",$this->input->post('customer_no'));
          if(count($customer_arr)>=3){

            $customer_no=$customer_arr[1];
          }

          $data=array(                  
            'customer_no'=>$customer_no,
            'sleeve_id'=>$this->input->post('sleeve_id'),
            'cost_per_tube'=>$this->input->post('cost_per_tube'),
            'company_id'=>$this->session->userdata['logged_in']['company_id'],
            'apply_from_date'=>$this->input->post('from_date'),
            'apply_to_date'=>$this->input->post('to_date')
          );


          $data['freight_master']=$this->common_model->active_record_search('freight_master',$data,$this->session->userdata['logged_in']['company_id']);

          $data['sleeve_diameter_master']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

          //echo $this->db->last_query();
          //echo '<pre>';
          //print_r($data['freight_master']);

          $data['page_name']='Sales';
          $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          $this->load->view('Home/header');
          $this->load->view('Home/nav',$data);
          $this->load->view('Home/subnav');
          $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
          $this->load->view(ucwords($this->router->fetch_class()).'/search-form');
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

  function check_data() {
    $from_date = $this->input->post('from_date');// get fiest name
    $to_date = $this->input->post('to_date');// get last name
    $sleeve_id = $this->input->post('sleeve_id');
    $customer_no='';
    $customer_arr=explode("//",$this->input->post('customer_no'));
    if(count($customer_arr)>=3){
      $customer_no=$customer_arr[1];
    }

    $this->db->select('*');
    $this->db->from('freight_master');
    $this->db->where('customer_no', $customer_no);
    $this->db->where('sleeve_id', $sleeve_id);
    $this->db->where('apply_from_date', $from_date);
    $this->db->where('apply_to_date', $to_date);
    $this->db->where('archive<>','1');
    
    $query = $this->db->get();
    $num = $query->num_rows();
    if ($num > 0) {
        $this->form_validation->set_message('check_data', 'Duplicate Entry Error!');
        return FALSE;
    } else {
        return TRUE;
    }
  }



}
