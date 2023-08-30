<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Other_cost_master extends CI_Controller {

  function __construct(){

    parent::__construct();

    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
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
   
    $table='other_cost_master';

    include('pagination.php');

    $data['other_cost_master']=$this->common_model->select_active_records($config["per_page"], $this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

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

          $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
          $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
            
            

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

            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
          
          
          $this->form_validation->set_rules('from_date','From Date' ,'required|xss_clean');
          $this->form_validation->set_rules('to_date','To Date','required|xss_clean');
          $this->form_validation->set_rules('sleeve_dia','Sleeve Dia' ,'xss_clean');
          $this->form_validation->set_rules('other_cost','Other Cost','required|xss_clean');
          //$this->form_validation->set_rules('consumable','Consumable','required|xss_clean');
          $this->form_validation->set_rules('other_cost_value','Value','required|xss_clean');
          $this->form_validation->set_rules('sale_of_tubes','Sale Of Tube','required|xss_clean');
          $this->form_validation->set_rules('cost_per_tube','Cost Per Tube','required|xss_clean');

          if($this->form_validation->run()==FALSE){

          $data['page_name']='Sales';
          $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

          $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
          $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
            
            
            $this->load->view('Home/header');

            $this->load->view('Home/nav',$data);

            $this->load->view('Home/subnav');

            $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

            $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

            $this->load->view('Home/footer');

          }
          else{

          $time_from=strtotime($this->input->post('from_date'));
          $month_from=date("F",$time_from);
          $year_from=date("Y",$time_from);

          $time_to=strtotime($this->input->post('to_date'));
          $month_to=date("F",$time_to);
          $year_to=date("Y",$time_to);

          $apply_from_date=date('Y-m-01',strtotime('+1 month',strtotime($this->input->post('from_date'))));
          $apply_to_date=date('Y-m-t',strtotime('+3 month',strtotime($this->input->post('from_date'))));

            $data=array(
              'sleeve_dia'=>$this->input->post('sleeve_dia'),
              'cap_type'=>$this->input->post('cap_type'),
              'from_date'=>$this->input->post('from_date'),
                        'to_date'=>$this->input->post('to_date'),
                        'other_cost'=>$this->input->post('other_cost'),
                        'other_cost_value'=>$this->input->post('other_cost_value'),
                        'sale_of_tubes'=>$this->input->post('sale_of_tubes'),
                        'order_flag'=>$this->input->post('order_flag'),
                        'cost_per_tube'=>$this->input->post('cost_per_tube'),                 
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'apply_from_date'=>$apply_from_date,
                        'apply_to_date'=>$apply_to_date
                      );


          $result=$this->common_model->save('other_cost_master',$data);

          if($result==1){

            $data['note']='Save Transaction Completed';

            header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

            $data['page_name']='Sales';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            
            $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
          

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
       
        $data['other_cost_master']=$this->common_model->select_one_active_record('other_cost_master',$this->session->userdata['logged_in']['company_id'],'ocsm_id ',$this->uri->segment(3));

        $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
          
        $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
          

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
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'other_cost_master');

  foreach ($data['formrights'] as $formrights_row) {
    if($formrights_row->modify==1){

    $this->form_validation->set_rules('from_date','From Date' ,'required|xss_clean');
    $this->form_validation->set_rules('to_date','To Date','required|xss_clean');
    $this->form_validation->set_rules('other_cost_value','Other Cost Value','required|xss_clean');
    $this->form_validation->set_rules('sale_of_tubes','Sale Of Tube','required|xss_clean');
    $this->form_validation->set_rules('cost_per_tube','Cost Per Tube','required|xss_clean');

    $this->form_validation->set_rules('apply_from_date','Apply From Date','required|xss_clean');

    $this->form_validation->set_rules('apply_to_date','Apply To Date','required|xss_clean');
   
   if($this->form_validation->run()==FALSE){

      
      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
     
      $data['other_cost_master']=$this->common_model->select_one_active_record('other_cost_master',$this->session->userdata['logged_in']['company_id'],'ocm_id',$this->input->post('ocsm_id'));

      $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
      

    $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
          

      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

      $this->load->view('Home/footer');

    }
    else{

      $time_from=strtotime($this->input->post('from_date'));
      $month_from=date("F",$time_from);
      $year_from=date("Y",$time_from);

      $time_to=strtotime($this->input->post('to_date'));
      $month_to=date("F",$time_to);
      $year_to=date("Y",$time_to);

      //$apply_from_date=date('Y-m-01',strtotime('+1 month',strtotime($this->input->post('from_date'))));
      //$apply_to_date=date('Y-m-t',strtotime('+3 month',strtotime($this->input->post('from_date'))));

      $data=array('sleeve_dia'=>$this->input->post('sleeve_dia'),
        'cap_type'=>$this->input->post('cap_type'),
                  'from_date'=>$this->input->post('from_date'),
                  'to_date'=>$this->input->post('to_date'),
                  'order_flag'=>$this->input->post('order_flag'),
                  'other_cost'=>$this->input->post('other_cost'),
                  'other_cost_value'=>$this->input->post('other_cost_value'),
                  'sale_of_tubes'=>$this->input->post('sale_of_tubes'),
                  'cost_per_tube'=>$this->input->post('cost_per_tube'),
                  'apply_from_date'=>$this->input->post('apply_from_date'),
                  'apply_to_date'=>$this->input->post('apply_to_date')
                );


        $result=$this->common_model->update_one_active_record('other_cost_master',$data,'ocsm_id',$this->input->post('ocsm_id'),$this->session->userdata['logged_in']['company_id']);
        
        if($result==1){

            $data['note']='Update Transaction Completed';

            header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

            $data['other_cost_master']=$this->common_model->select_one_active_record('other_cost_master',$this->session->userdata['logged_in']['company_id'],'ocsm_id',$this->input->post('ocsm_id'));


            $data['page_name']='Sales';
            
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

            $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
            
            $data['cap_type']=$this->common_model->select_active_drop_down('cap_types_master',$this->session->userdata['logged_in']['company_id']);
          

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
          $result=$this->common_model->update_one_active_record('other_cost_master',$data,'ocsm_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);
              

            if($result){

              $data['note']="Archive Transaction completed";

              header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
           
              $data['other_cost_master']=$this->common_model->select_one_inactive_record('other_cost_master',$this->session->userdata['logged_in']['company_id'],'ocsm_id',$this->uri->segment(3)); 

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
      

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

    $table='other_cost_master';

    include('pagination_archive.php');

    $data['other_cost_master']=$this->common_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

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
    $result=$this->common_model->update_one_active_record('other_cost_master',$data,'ocsm_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

    if($result){

      $data['note']="Dearchive Transaction completed";

      header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

      $data['other_cost_master']=$this->common_model->select_one_active_record('other_cost_master',$this->session->userdata['logged_in']['company_id'],'ocsm_id',$this->uri->segment(3));

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

    $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
      
    
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


  public function search_result(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
    
    $this->form_validation->set_rules('from_date','From Date' ,'xss_clean');
    $this->form_validation->set_rules('to_date','To Date','xss_clean');
    $this->form_validation->set_rules('other_cost','Other cost','xss_clean');
    $this->form_validation->set_rules('sale_of_tubes','Sale Of Tube','xss_clean');
    $this->form_validation->set_rules('cost_per_tube','Cost Per Tube','xss_clean');
    $this->form_validation->set_rules('apply_from_date','Apply From Date','xss_clean');
    $this->form_validation->set_rules('apply_to_date','Apply To Date','xss_clean');
  

    if($this->form_validation->run()==FALSE){

      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);


      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);

      $this->load->view('Home/footer');

    }
    else{

      $data=array('from_date'=>$this->input->post('from_date'),
                  'to_date'=>$this->input->post('to_date'),
                  'order_flag'=>$this->input->post('order_flag'),
                  'other_cost'=>$this->input->post('other_cost'),
                  'other_cost_value'=>$this->input->post('other_cost_value'),
                  'sale_of_tubes'=>$this->input->post('sale_of_tubes'),
                  'cost_per_tube'=>$this->input->post('cost_per_tube'),
                  'apply_from_date'=>$this->input->post('apply_from_date'),
                  'apply_to_date'=>$this->input->post('apply_to_date'));


          $data['other_cost_master']=$this->common_model->active_record_search('other_cost_master',$data,$this->session->userdata['logged_in']['company_id']);
          
          $data['page_name']='Sales';
          $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          $this->load->view('Home/header');

          $this->load->view('Home/nav',$data);

          $this->load->view('Home/subnav');

          $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

          $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);

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



}
