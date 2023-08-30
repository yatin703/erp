<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Other_consumable_consumption_master extends CI_Controller {



  function __construct(){

    parent::__construct();

    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('lacquer_model');
      $this->load->model('article_model');
      $this->load->model('other_consumable_consumption_model');
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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'other_consumable_consumption_master');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

   
    $table='other_consumable_consumption_master';

    include('pagination-other-consumable.php');

    $data['other_consumable_consumption_master']=$this->other_consumable_consumption_model->select_active_records($config["per_page"], $this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'other_consumable_consumption_master');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

    $data['consumable_category_master']=$this->common_model->select_active_drop_down('consumable_category_master',$this->session->userdata['logged_in']['company_id']);

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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'other_consumable_consumption_master');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){
    
    $this->form_validation->set_rules('from_date','From Date' ,'required|xss_clean');
    $this->form_validation->set_rules('to_date','To Date','required|xss_clean');
    $this->form_validation->set_rules('consumable_category_id','Consumable Category','required|xss_clean|callback_check_duplicate');
    //$this->form_validation->set_rules('consumable','Consumable','required|xss_clean');
    $this->form_validation->set_rules('consumption_value','Consumption Value','required|xss_clean');
    $this->form_validation->set_rules('sale_of_tubes','Sale Of Tube','required|xss_clean');
    $this->form_validation->set_rules('cost_per_tube','Cost Per Tube','required|xss_clean');
    //$this->form_validation->set_rules('apply_from_date','From Date' ,'required|xss_clean');
    //$this->form_validation->set_rules('apply_to_date','To Date','required|xss_clean');
   
  

    if($this->form_validation->run()==FALSE){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $data['consumable_category_master']=$this->common_model->select_active_drop_down('consumable_category_master',$this->session->userdata['logged_in']['company_id']);
      
      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

      $this->load->view('Home/footer');

    }
    else{

        $consumable_category='';
       $result_consumable_category_master=$this->common_model->select_one_active_record('consumable_category_master',$this->session->userdata['logged_in']['company_id'],'ccm_id',$this->input->post('consumable_category_id'));

        foreach ($result_consumable_category_master as $consumable_category_master_row) {
          $consumable_category=strtoupper($consumable_category_master_row->consumable_category);
        }

      $time_from=strtotime($this->input->post('from_date'));
      $month_from=date("F",$time_from);
      $year_from=date("Y",$time_from);

      $time_to=strtotime($this->input->post('to_date'));
      $month_to=date("F",$time_to);
      $year_to=date("Y",$time_to);

      $consumable= $month_from.' '.$year_from.' '.($month_from!=$month_to?' TO '.$month_to.' '.$year_to :'').' '.$consumable_category;

      $data=array('from_date'=>$this->input->post('from_date'),
                  'to_date'=>$this->input->post('to_date'),
                  'consumable_category_id'=>$this->input->post('consumable_category_id'),
                  'consumable'=>strtoupper($consumable),
                  'consumption_value'=>$this->input->post('consumption_value'),
                  'sale_of_tubes'=>$this->input->post('sale_of_tubes'),
                  'cost_per_tube'=>round($this->input->post('consumption_value')/$this->input->post('sale_of_tubes'),4),                 
                  'company_id'=>$this->session->userdata['logged_in']['company_id'],
                 'apply_from_date'=>date('Y-m-01',strtotime('+3 month',strtotime($this->input->post('from_date')))),
                  'apply_to_date'=>date('Y-m-t',strtotime('+3 month',strtotime($this->input->post('from_date'))))
                );


          $result=$this->common_model->save('other_consumable_consumption_master',$data);

          if($result==1){

            $data['note']='Save Transaction Completed';

            header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

            $data['page_name']='Sales';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

            $data['consumable_category_master']=$this->common_model->select_active_drop_down('consumable_category_master',$this->session->userdata['logged_in']['company_id']);


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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'other_consumable_consumption_master');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){
   
    $data['other_consumable_consumption_master']=$this->common_model->select_one_active_record('other_consumable_consumption_master',$this->session->userdata['logged_in']['company_id'],'ocm_id',$this->uri->segment(3));

    $data['consumable_category_master']=$this->common_model->select_active_drop_down('consumable_category_master',$this->session->userdata['logged_in']['company_id']);

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
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'other_consumable_consumption_master');

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){

    $this->form_validation->set_rules('from_date','From Date' ,'required|xss_clean');
    $this->form_validation->set_rules('to_date','To Date','required|xss_clean');
    //$this->form_validation->set_rules('consumable_category_id','Consumable Category','required|xss_clean');
   // $this->form_validation->set_rules('consumable','Consumable','required|xss_clean');
    $this->form_validation->set_rules('consumption_value','Consumption Value','required|xss_clean');
    $this->form_validation->set_rules('sale_of_tubes','Sale Of Tube','required|xss_clean');
    $this->form_validation->set_rules('cost_per_tube','Cost Per Tube','required|xss_clean');
   //$this->form_validation->set_rules('apply_from_date','From Date' ,'required|xss_clean');
   // $this->form_validation->set_rules('apply_to_date','To Date','required|xss_clean');
     

    if($this->form_validation->run()==FALSE){

      
      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
     
      $data['other_consumable_consumption_master']=$this->common_model->select_one_active_record('other_consumable_consumption_master',$this->session->userdata['logged_in']['company_id'],'ocm_id',$this->input->post('ocm_id'));

      $data['consumable_category_master']=$this->common_model->select_active_drop_down('consumable_category_master',$this->session->userdata['logged_in']['company_id']);

      $this->load->view('Home/header');

      $this->load->view('Home/nav',$data);

      $this->load->view('Home/subnav');

      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

      $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);

      $this->load->view('Home/footer');

    }
    else{

          $consumable_category='';
          $result_consumable_category_master=$this->common_model->select_one_active_record('consumable_category_master',$this->session->userdata['logged_in']['company_id'],'ccm_id',$this->input->post('consumable_category_id'));

        foreach ($result_consumable_category_master as $consumable_category_master_row) {
          $consumable_category=strtoupper($consumable_category_master_row->consumable_category);
        }

      $time_from=strtotime($this->input->post('from_date'));
      $month_from=date("F",$time_from);
      $year_from=date("Y",$time_from);

      $time_to=strtotime($this->input->post('to_date'));
      $month_to=date("F",$time_to);
      $year_to=date("Y",$time_to);

      $consumable= $month_from.' '.$year_from.' '.($month_from!=$month_to?' TO '.$month_to.' '.$year_to :'').' '.$consumable_category;


          $data=array('from_date'=>$this->input->post('from_date'),
                  'to_date'=>$this->input->post('to_date'),
                  //'consumable_category_id'=>$this->input->post('consumable_category_id'),
                   'consumable'=>strtoupper($consumable),
                  'consumption_value'=>$this->input->post('consumption_value'),
                  'sale_of_tubes'=>$this->input->post('sale_of_tubes'),
                  'cost_per_tube'=>round($this->input->post('consumption_value')/$this->input->post('sale_of_tubes'),4),
                  'apply_from_date'=>date('Y-m-01',strtotime('+3 month',strtotime($this->input->post('from_date')))),
                  'apply_to_date'=>date('Y-m-t',strtotime('+3 month',strtotime($this->input->post('from_date'))))
                );


        $result=$this->common_model->update_one_active_record('other_consumable_consumption_master',$data,'ocm_id',$this->input->post('ocm_id'),$this->session->userdata['logged_in']['company_id']);
        
        if($result==1){

            $data['note']='Update Transaction Completed';

            header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

            $data['other_consumable_consumption_master']=$this->common_model->select_one_active_record('other_consumable_consumption_master',$this->session->userdata['logged_in']['company_id'],'ocm_id',$this->input->post('ocm_id'));

            $data['consumable_category_master']=$this->common_model->select_active_drop_down('consumable_category_master',$this->session->userdata['logged_in']['company_id']);

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
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'stores_and_spares_consumption_master');

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

    $data=array('archive'=>'1');
    $result=$this->common_model->update_one_active_record('other_consumable_consumption_master',$data,'ocm_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);
        

    if($result){

      $data['note']="Archive Transaction completed";

      header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
   
      $data['other_consumable_consumption_master']=$this->common_model->select_one_inactive_record('other_consumable_consumption_master',$this->session->userdata['logged_in']['company_id'],'ocm_id',$this->uri->segment(3)); 

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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'other_consumable_consumption_master');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->delete==1){

    $table='other_consumable_consumption_master';

    include('pagination_archive.php');

    $data['other_consumable_consumption_master']=$this->other_consumable_consumption_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'other_consumable_consumption_master');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->dearchive==1){

    $data=array('archive'=>'0');
    $result=$this->common_model->update_one_active_record('other_consumable_consumption_master',$data,'ocm_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

    if($result){

      $data['note']="Dearchive Transaction completed";

      header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

      $data['other_consumable_consumption_master']=$this->common_model->select_one_active_record('other_consumable_consumption_master',$this->session->userdata['logged_in']['company_id'],'ocm_id',$this->uri->segment(3));
     
   


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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'other_consumable_consumption_master');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

    $data['consumable_category_master']=$this->common_model->select_active_drop_down('consumable_category_master',$this->session->userdata['logged_in']['company_id']);
    
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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'other_consumable_consumption_master');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
    
    $this->form_validation->set_rules('from_date','From Date' ,'xss_clean');
    $this->form_validation->set_rules('to_date','To Date','xss_clean');
    $this->form_validation->set_rules('consumable_category_id','Consumable Category','xss_clean');
    $this->form_validation->set_rules('consumable','Consumable','xss_clean');
    $this->form_validation->set_rules('consumption_value','Consumption Value','xss_clean');
    $this->form_validation->set_rules('sale_of_tubes','Sale Of Tube','xss_clean');
    $this->form_validation->set_rules('cost_per_tube','Cost Per Tube','xss_clean');
    $this->form_validation->set_rules('apply_from_date','Apply From Date','xss_clean');
    $this->form_validation->set_rules('apply_to_date','Apply To Date','xss_clean');
  

    if($this->form_validation->run()==FALSE){

      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $data['consumable_category_master']=$this->common_model->select_active_drop_down('consumable_category_master',$this->session->userdata['logged_in']['company_id']);

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
                  'consumable_category_master.ccm_id'=>$this->input->post('consumable_category_id'),
                  'consumable'=>$this->input->post('consumable'),
                  'consumption_value'=>$this->input->post('consumption_value'),
                  'sale_of_tubes'=>$this->input->post('sale_of_tubes'),
                  'cost_per_tube'=>$this->input->post('cost_per_tube'),
                  'apply_from_date'=>$this->input->post('apply_from_date'),
                  'apply_to_date'=>$this->input->post('apply_to_date'),
                  'consumable_category_master.company_id'=>$this->session->userdata['logged_in']['company_id']);


          $data['other_consumable_consumption_master']=$this->other_consumable_consumption_model->active_record_search('other_consumable_consumption_master',$data);
          
          $data['page_name']='Sales';
          $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

          $this->load->view('Home/header');

          $this->load->view('Home/nav',$data);

          $this->load->view('Home/subnav');

          $this->load->view(ucwords($this->router->fetch_class()).'/active-title');

          $this->load->view(ucwords($this->router->fetch_class()).'/search-records',$data);

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

  function check_duplicate(){
    
    $from_date = $this->input->post('from_date');
    $to_date = $this->input->post('to_date'); 
    $consumable_category_id = $this->input->post('consumable_category_id');
    $this->db->select('*');
    $this->db->from('other_consumable_consumption_master');
    $this->db->where('from_date', $from_date);
    $this->db->where('to_date', $to_date);
    $this->db->where('archive<>','1');
    $this->db->where('consumable_category_id', $consumable_category_id);
    $query = $this->db->get();
    $num = $query->num_rows();
    if ($num > 0) {
      $this->form_validation->set_message('check_duplicate', 'Duplicate Entry Error');
      return FALSE;
    } 
    else {
      return TRUE;
    }      
      
  }



}
