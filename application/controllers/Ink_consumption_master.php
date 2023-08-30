<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Ink_consumption_master extends CI_Controller {



  function __construct(){

    parent::__construct();

    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('lacquer_model');
      $this->load->model('article_model');
      $this->load->model('ink_consumption_model');

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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'ink_consumption_master');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

   
    $table='ink_consumption_master';

    include('pagination.php');

    $data['ink_consumption_master']=$this->ink_consumption_model->select_active_records($config["per_page"], $this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'ink_consumption_master');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

        $data['lacquer_types_master']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']); 

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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'ink_consumption_master');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){
    
    $this->form_validation->set_rules('from_date','From Date' ,'required|xss_clean');
    $this->form_validation->set_rules('to_date','To Date','required|xss_clean');

    $arr=$this->input->post('lacquer_type_id');
           
    if(is_array($arr)){
      for($i=0;$i<count($arr);$i++){
        $this->form_validation->set_rules('lacquer_type_id[]','Print Type'.$i ,'required|trim|xss_clean|callback_check_data');      

      }
    }
    $this->form_validation->set_rules('consumption_value','Consumption Value','required|xss_clean');
    $this->form_validation->set_rules('sale_of_tubes','Consumption Quantity','required|xss_clean');
    $this->form_validation->set_rules('cost_per_tube','Consumption Unit Rate','required|xss_clean');
    
  

    if($this->form_validation->run()==FALSE){

      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $data['lacquer_types_master']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']); 
      
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

      
      $print_type='';
      foreach($this->input->post('lacquer_type_id') as $lacquer_type){

        $result_lacquer_type=$this->common_model->select_one_active_record('lacquer_types_master',$this->session->userdata['logged_in']['company_id'],'lacquer_type_id',$lacquer_type);

        foreach ($result_lacquer_type as $lacquer_type_row) {
          $print_type=strtoupper($lacquer_type_row->lacquer_type);
        }
        
        $rm= strtoupper($month_from).' '.$year_from.' '.($month_from!=$month_to?' TO '.strtoupper($month_to).' '.$year_to :'').' '.$print_type.' INK CONSUMPTION';


      $data=array('from_date'=>$this->input->post('from_date'),
                  'to_date'=>$this->input->post('to_date'),
                  'lacquer_type_id'=>$lacquer_type,
                  'rm'=>$rm,
                  'consumption_value'=>$this->input->post('consumption_value'),
                  'sale_of_tubes'=>$this->input->post('sale_of_tubes'),
                  'cost_per_tube'=>round($this->input->post('consumption_value')/$this->input->post('sale_of_tubes'),4),
                  'apply_from_date'=>date('Y-m-01',strtotime('+3 month',strtotime($this->input->post('from_date')))),
                  'apply_to_date'=>date('Y-m-t',strtotime('+3 month',strtotime($this->input->post('from_date')))),
                  'company_id'=>$this->session->userdata['logged_in']['company_id']
                );


          $result=$this->common_model->save('ink_consumption_master',$data);
      }    
          if($result==1){

            $data['note']='Save Transaction Completed';

            header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

            $data['page_name']='Sales';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

            $data['lacquer_types_master']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']); 

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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'ink_consumption_master');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){
   
    $data['ink_consumption_master']=$this->common_model->select_one_active_record('ink_consumption_master',$this->session->userdata['logged_in']['company_id'],'icm_id',$this->uri->segment(3));
    
    $data['lacquer_types_master']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']); 

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
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'ink_consumption_master');

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){

    $this->form_validation->set_rules('from_date','From Date' ,'required|xss_clean');
    $this->form_validation->set_rules('to_date','To Date','required|xss_clean');
    $arr=$this->input->post('lacquer_type_id');
           
    if(is_array($arr)){
      for($i=0;$i<count($arr);$i++){

        $this->form_validation->set_rules('lacquer_type_id[]','Print Type'.$i ,'required|trim|xss_clean');
        

      }
    }
    $this->form_validation->set_rules('consumption_value','Consumption Value','required|xss_clean');
    $this->form_validation->set_rules('sale_of_tubes','Consumption Quantity','required|xss_clean');
    $this->form_validation->set_rules('cost_per_tube','Consumption Unit Rate','required|xss_clean');
    //$this->form_validation->set_rules('apply_from_date','Apply From Rate','required|xss_clean');
    //$this->form_validation->set_rules('apply_to_date','Apply To Rate','required|xss_clean');
     

    if($this->form_validation->run()==FALSE){

      
      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
     
      $data['ink_consumption_master']=$this->common_model->select_one_active_record('ink_consumption_master',$this->session->userdata['logged_in']['company_id'],'icm_id',$this->input->post('icm_id'));

      $data['lacquer_types_master']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']); 

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

          
          $print_type='';
          foreach($this->input->post('lacquer_type_id') as $lacquer_type){

            $result_lacquer_type=$this->common_model->select_one_active_record('lacquer_types_master',$this->session->userdata['logged_in']['company_id'],'lacquer_type_id',$lacquer_type);

            foreach ($result_lacquer_type as $lacquer_type_row) {
              $print_type=strtoupper($lacquer_type_row->lacquer_type);
            }
            
            $rm= strtoupper($month_from).' '.$year_from.' '.($month_from!=$month_to?' TO '.strtoupper($month_to).' '.$year_to :'').' '.$print_type.' INK CONSUMPTION';

          $data=array('from_date'=>$this->input->post('from_date'),
                  'to_date'=>$this->input->post('to_date'),
                  'lacquer_type_id'=>$lacquer_type,
                  'rm'=>$rm,
                  'consumption_value'=>$this->input->post('consumption_value'),
                  'sale_of_tubes'=>$this->input->post('sale_of_tubes'),
                  'cost_per_tube'=>round($this->input->post('consumption_value')/$this->input->post('sale_of_tubes'),4),
                  'apply_from_date'=>date('Y-m-01',strtotime('+3 month',strtotime($this->input->post('from_date')))),
                  'apply_to_date'=>date('Y-m-t',strtotime('+3 month',strtotime($this->input->post('from_date'))))

                );


        $result=$this->common_model->update_one_active_record('ink_consumption_master',$data,'icm_id',$this->input->post('icm_id'),$this->session->userdata['logged_in']['company_id']);
      } 
        
        if($result==1){

            $data['note']='Update Transaction Completed';

            header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

            $data['ink_consumption_master']=$this->common_model->select_one_active_record('ink_consumption_master',$this->session->userdata['logged_in']['company_id'],'icm_id',$this->input->post('icm_id'));

            $data['lacquer_types_master']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']); 

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
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'ink_consumption_master');

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

    $data=array('archive'=>'1');
    $result=$this->common_model->update_one_active_record('ink_consumption_master',$data,'icm_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);
        

    if($result){

      $data['note']="Archive Transaction completed";

      header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
   
      $data['ink_consumption_master']=$this->common_model->select_one_inactive_record('ink_consumption_master',$this->session->userdata['logged_in']['company_id'],'icm_id',$this->uri->segment(3)); 

       $data['lacquer_types_master']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']); 

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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'ink_consumption_master');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->delete==1){

    $table='ink_consumption_master';

    include('pagination_archive.php');

    $data['ink_consumption_master']=$this->ink_consumption_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'ink_consumption_master');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->dearchive==1){

    $data=array('archive'=>'0');
    $result=$this->common_model->update_one_active_record('ink_consumption_master',$data,'icm_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

    if($result){

      $data['note']="Dearchive Transaction completed";

      header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

      $data['ink_consumption_master']=$this->common_model->select_one_active_record('ink_consumption_master',$this->session->userdata['logged_in']['company_id'],'icm_id',$this->uri->segment(3));

       $data['lacquer_types_master']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']);    


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

  function copy(){

     $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'ink_consumption_master');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->copy==1){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
   
    $data['ink_consumption_master']=$this->common_model->select_one_active_record('ink_consumption_master',$this->session->userdata['logged_in']['company_id'],'icm_id',$this->uri->segment(3));
    
    $data['lacquer_types_master']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']); 

    $this->load->view('Home/header');
    $this->load->view('Home/nav',$data);
    $this->load->view('Home/subnav');
    $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'ink_consumption_master');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

   $data['lacquer_types_master']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']); 

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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'ink_consumption_master');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){


    
    $this->form_validation->set_rules('from_date','From Date' ,'xss_clean');
    $this->form_validation->set_rules('to_date','To Date','xss_clean');
    //$this->form_validation->set_rules('lacquer_type_id','Print Type','xss_clean');
    //$this->form_validation->set_rules('rm','RM','xss_clean');
    $this->form_validation->set_rules('consumption_value','Consumption Value','xss_clean');
    $this->form_validation->set_rules('sale_of_tubes','Consumption Quantity','xss_clean');
    $this->form_validation->set_rules('cost_per_tube','Consumption Unit Rate','xss_clean');
    //$this->form_validation->set_rules('apply_from_date','Apply From Date','xss_clean');
    //$this->form_validation->set_rules('apply_to_date','Apply To Date','xss_clean');
  

    if($this->form_validation->run()==FALSE){

      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $data['lacquer_types_master']=$this->common_model->select_active_drop_down('lacquer_types_master',$this->session->userdata['logged_in']['company_id']); 
      
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
      $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
      $this->load->view('Home/footer');

    }
    else{
      $search='';
      if(!empty($this->input->post('lacquer_type_id[]'))){
        $search=$this->input->post('lacquer_type_id[]');

      }

      $data=array('from_date'=>$this->input->post('from_date'),
                  'to_date'=>$this->input->post('to_date'),
                                    
                  'consumption_value'=>$this->input->post('consumption_value'),
                  'sale_of_tubes'=>$this->input->post('sale_of_tubes'),
                  'cost_per_tube'=>$this->input->post('cost_per_tube'),                  
                  'ink_consumption_master.company_id'=>$this->session->userdata['logged_in']['company_id']
                );

          $data['ink_consumption_master']=$this->ink_consumption_model->active_record_search('ink_consumption_master',$data,$search);
          
          $data['page_name']='Sales';
          $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'ink_consumption_master');

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
  function check_data($str) {
    $from_date = $this->input->post('from_date');// get fiest name
    $to_date = $this->input->post('to_date');// get last name
    $lacquer_type_id = $str;
    $this->db->select('*');
    $this->db->from('ink_consumption_master');
    $this->db->where('from_date', $from_date);
    $this->db->where('to_date', $to_date);
    $this->db->where('archive<>','1');
    $this->db->where('lacquer_type_id', $lacquer_type_id);
    $query = $this->db->get();
    $num = $query->num_rows();
    if ($num > 0) {
        $this->form_validation->set_message('check_data', 'Duplicate Entry Error');
        return FALSE;
    } else {
        return TRUE;
    }
  }



}
