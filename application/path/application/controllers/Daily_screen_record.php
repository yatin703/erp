<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daily_screen_record extends CI_Controller {

  function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('artwork_model');
      $this->load->model('customer_model');
      $this->load->model('article_model');
      $this->load->model('second_sub_group_model');
      $this->load->model('daily_screen_record_model');
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
            $table='graphics_daily_screen_master';
            include('pagination.php');
            $data['graphics_daily_screen_master']=$this->daily_screen_record_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

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

            $data['graphics_plate_nature_master']=$this->common_model->select_active_drop_down('graphics_plate_nature_master',$this->session->userdata['logged_in']['company_id']);
            $data['graphics_shift_master']=$this->common_model->select_active_drop_down('graphics_shift_master',$this->session->userdata['logged_in']['company_id']);
            $data['graphics_plate_making_reasons']=$this->common_model->select_active_drop_down('graphics_plate_making_reasons',$this->session->userdata['logged_in']['company_id']);
            $data['graphics_machine_master']=$this->common_model->select_active_drop_down('graphics_machine_master',$this->session->userdata['logged_in']['company_id']);
            $data['graphics_operator_master']=$this->common_model->select_active_drop_down('graphics_operator_master',$this->session->userdata['logged_in']['company_id']);

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

            $this->form_validation->set_rules('order_no','Order No.' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('article_no','PSM/PSP No.' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('artwork_no','Artwork No.' ,'trim|xss_clean');
            $this->form_validation->set_rules('version_no','Version No.' ,'trim|xss_clean');
            $this->form_validation->set_rules('jobcard_no','Jobcard No.' ,'trim|xss_clean');
            $this->form_validation->set_rules('shift_id','Shift' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('machine_id','Machine' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('operator_id','Plate Maker' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('reason_id','Reason' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('comment','Comment' ,'trim|xss_clean');

            $arr=$this->input->post('pantone');
            //print_r($this->input->post('pantone'));
            if(is_array($arr)){
              for($i=0;$i<count($arr);$i++){

                $this->form_validation->set_rules('pantone[]','Pantone'.$i ,'required|trim|xss_clean');
                 $this->form_validation->set_rules('mesh[]','Mesh'.$i ,'required|trim|xss_clean');
                $this->form_validation->set_rules('date_on_screen[]','Date On Screen'.$i ,'required|trim|xss_clean');
                 $this->form_validation->set_rules('label_on_screen[]','Label On Screen'.$i ,'required|trim|xss_clean');
                $this->form_validation->set_rules('screen_count[]','No. Of Screen'.$i ,'required|trim|xss_clean');

              }
            }
            

            if($this->form_validation->run()==FALSE){
              
              $data['graphics_plate_nature_master']=$this->common_model->select_active_drop_down('graphics_plate_nature_master',$this->session->userdata['logged_in']['company_id']);
              $data['graphics_shift_master']=$this->common_model->select_active_drop_down('graphics_shift_master',$this->session->userdata['logged_in']['company_id']);
              $data['graphics_plate_making_reasons']=$this->common_model->select_active_drop_down('graphics_plate_making_reasons',$this->session->userdata['logged_in']['company_id']);
              $data['graphics_machine_master']=$this->common_model->select_active_drop_down('graphics_machine_master',$this->session->userdata['logged_in']['company_id']);
              $data['graphics_operator_master']=$this->common_model->select_active_drop_down('graphics_operator_master',$this->session->userdata['logged_in']['company_id']);

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
              $this->load->view('Home/footer');
            }else{

              
              $data=array(                    
                    'dsr_date'=>date('Y-m-d'),
                    'order_no'=>$this->input->post('order_no'),
                    'article_no'=>$this->input->post('article_no'),
                    'artwork_no'=>$this->input->post('artwork_no'),
                    'version_no'=>$this->input->post('version_no'),
                    'jobcard_no'=>$this->input->post('jobcard_no'),
                    'screen_making_reason'=>$this->input->post('reason_id'),
                    'shift_id'=>$this->input->post('shift_id'),
                    'machine_id'=>$this->input->post('machine_id'),
                    'operator_id'=>$this->input->post('operator_id'),
                    'comment'=>$this->input->post('comment'),
                    'user_id'=>$this->session->userdata['logged_in']['user_id'],
                    'company_id'=>$this->session->userdata['logged_in']['company_id']                   
                    );

              $dsr_id=$this->common_model->save_return_pkey('graphics_daily_screen_master',$data);
              //$dpr_id=0;  
              $arr1=$this->input->post('pantone');
              //print_r($arr1); 
              if($dsr_id!='' || $dsr_id!=0){

                    $arr1=$this->input->post('pantone');
                    //print_r($arr1);
                    if(is_array($arr1)){
                        for($i=0;$i<count($arr1);$i++){

                            $data=array(                    
                              'dsr_id'=>$dsr_id,
                              'pantone_name'=>$this->input->post('pantone['.$i.']'),
                              'mesh'=>$this->input->post('mesh['.$i.']'),
                              'label_on_screen'=>$this->input->post('label_on_screen['.$i.']'),
                              'date_on_screen'=>$this->input->post('date_on_screen['.$i.']'),
                              'no_of_screen'=>$this->input->post('screen_count['.$i.']'),
                              'artwork_para_id'=>$this->input->post('artwork_para_id['.$i.']'),
                              'create_date'=>date('Y-m-d h:i:s')
                                         
                              );
                            
                            $result=$this->common_model->save('graphics_daily_screen_details',$data);

                        }
                    }

              }

              if($result){
                 $data['note']='Create Transaction Completed';
               }else{
                $data['note']='Create Transaction failed';
               }

               header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
              $data['note']='Create Transaction Completed';
             // header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

              $data['graphics_plate_nature_master']=$this->common_model->select_active_drop_down('graphics_plate_nature_master',$this->session->userdata['logged_in']['company_id']);
              $data['graphics_shift_master']=$this->common_model->select_active_drop_down('graphics_shift_master',$this->session->userdata['logged_in']['company_id']);
              $data['graphics_plate_making_reasons']=$this->common_model->select_active_drop_down('graphics_plate_making_reasons',$this->session->userdata['logged_in']['company_id']);
              $data['graphics_machine_master']=$this->common_model->select_active_drop_down('graphics_machine_master',$this->session->userdata['logged_in']['company_id']);
              $data['graphics_operator_master']=$this->common_model->select_active_drop_down('graphics_operator_master',$this->session->userdata['logged_in']['company_id']);

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

            $data['graphics_daily_screen_master']=$this->daily_screen_record_model->select_one_active_record('graphics_daily_screen_master',$this->session->userdata['logged_in']['company_id'],'graphics_daily_screen_master.dsr_id',$this->uri->segment(3));

             $data['graphics_plate_nature_master']=$this->common_model->select_active_drop_down('graphics_plate_nature_master',$this->session->userdata['logged_in']['company_id']);
              $data['graphics_shift_master']=$this->common_model->select_active_drop_down('graphics_shift_master',$this->session->userdata['logged_in']['company_id']);
              $data['graphics_plate_making_reasons']=$this->common_model->select_active_drop_down('graphics_plate_making_reasons',$this->session->userdata['logged_in']['company_id']);
              $data['graphics_machine_master']=$this->common_model->select_active_drop_down('graphics_machine_master',$this->session->userdata['logged_in']['company_id']);
              $data['graphics_operator_master']=$this->common_model->select_active_drop_down('graphics_operator_master',$this->session->userdata['logged_in']['company_id']);

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

              $this->form_validation->set_rules('order_no','Order No.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('article_no','PSM/PSP No.' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('artwork_no','Artwork No.' ,'trim|xss_clean');
              $this->form_validation->set_rules('version_no','Version No.' ,'trim|xss_clean');
              $this->form_validation->set_rules('jobcard_no','Jobcard No.' ,'trim|xss_clean');
              $this->form_validation->set_rules('shift_id','Shift' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('machine_id','Machine' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('operator_id','Plate Maker' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('reason_id','Reason' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('comment','Comment' ,'trim|xss_clean');

              $arr=$this->input->post('pantone');
              
              if(is_array($arr)){
                for($i=0;$i<count($arr);$i++){

                  $this->form_validation->set_rules('pantone[]','Pantone'.$i ,'required|trim|xss_clean');
                   $this->form_validation->set_rules('mesh[]','Mesh'.$i ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('date_on_screen[]','Date On Plate'.$i ,'required|trim|xss_clean');
                   $this->form_validation->set_rules('label_on_screen[]','Label On Screen'.$i ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('screen_count[]','No. Of Screen'.$i ,'required|trim|xss_clean');

                }
              }              

              if($this->form_validation->run()==FALSE){

                
                $data['graphics_daily_screen_master']=$this->daily_screen_record_model->select_one_active_record('graphics_daily_screen_master',$this->session->userdata['logged_in']['company_id'],'graphics_daily_screen_master.dsr_id',$this->input->post('dsr_id'));

                $data['graphics_plate_nature_master']=$this->common_model->select_active_drop_down('graphics_plate_nature_master',$this->session->userdata['logged_in']['company_id']);
                $data['graphics_shift_master']=$this->common_model->select_active_drop_down('graphics_shift_master',$this->session->userdata['logged_in']['company_id']);
                $data['graphics_plate_making_reasons']=$this->common_model->select_active_drop_down('graphics_plate_making_reasons',$this->session->userdata['logged_in']['company_id']);
                $data['graphics_machine_master']=$this->common_model->select_active_drop_down('graphics_machine_master',$this->session->userdata['logged_in']['company_id']);
                $data['graphics_operator_master']=$this->common_model->select_active_drop_down('graphics_operator_master',$this->session->userdata['logged_in']['company_id']);
                
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
                $this->load->view('Home/footer');

              }else{

                $data=array(                    
                    'dsr_date'=>date('Y-m-d'),
                    'order_no'=>$this->input->post('order_no'),
                    'article_no'=>$this->input->post('article_no'),
                    'artwork_no'=>$this->input->post('artwork_no'),
                    'version_no'=>$this->input->post('version_no'),
                    'jobcard_no'=>$this->input->post('jobcard_no'),
                    'screen_making_reason'=>$this->input->post('reason_id'),
                    'shift_id'=>$this->input->post('shift_id'),
                    'machine_id'=>$this->input->post('machine_id'),
                    'operator_id'=>$this->input->post('operator_id'),
                    'comment'=>$this->input->post('comment'),
                    'user_id'=>$this->session->userdata['logged_in']['user_id'],
                    'company_id'=>$this->session->userdata['logged_in']['company_id']                   
                    );

                $result=$this->common_model->update_one_active_record('graphics_daily_screen_master',$data,'dsr_id',$this->input->post('dsr_id'),$this->session->userdata['logged_in']['company_id']);

                // Removing Old Plate details and inserting new
                $result=$this->common_model->delete_one_active_record_noncompany('graphics_daily_screen_details','dsr_id',$this->input->post('dsr_id'));

                $arr1=$this->input->post('pantone');
              //print_r($arr1); 
              if($this->input->post('dsr_id')!='' || $this->input->post('dsr_id')!=0){

                    $arr1=$this->input->post('pantone');
                    //print_r($arr1);
                    if(is_array($arr1)){
                        for($i=0;$i<count($arr1);$i++){

                            $data=array(                    
                              'dsr_id'=>$this->input->post('dsr_id'),
                              'pantone_name'=>$this->input->post('pantone['.$i.']'),
                              'mesh'=>$this->input->post('mesh['.$i.']'),
                              'label_on_screen'=>$this->input->post('label_on_screen['.$i.']'),
                              'date_on_screen'=>$this->input->post('date_on_screen['.$i.']'),
                              'no_of_screen'=>$this->input->post('screen_count['.$i.']'),
                              'artwork_para_id'=>$this->input->post('artwork_para_id['.$i.']'),
                              'create_date'=>date('Y-m-d h:i:s')
                                         
                              );
                            
                            $result=$this->common_model->save('graphics_daily_screen_details',$data);

                        }
                    }

              }



                $data['page_name']='Sales';

                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                $data['graphics_daily_screen_master']=$this->daily_screen_record_model->select_one_active_record('graphics_daily_screen_master',$this->session->userdata['logged_in']['company_id'],'graphics_daily_screen_master.dsr_id',$this->input->post('dsr_id'));

                $data['graphics_plate_nature_master']=$this->common_model->select_active_drop_down('graphics_plate_nature_master',$this->session->userdata['logged_in']['company_id']);
                $data['graphics_shift_master']=$this->common_model->select_active_drop_down('graphics_shift_master',$this->session->userdata['logged_in']['company_id']);
                $data['graphics_plate_making_reasons']=$this->common_model->select_active_drop_down('graphics_plate_making_reasons',$this->session->userdata['logged_in']['company_id']);
                $data['graphics_machine_master']=$this->common_model->select_active_drop_down('graphics_machine_master',$this->session->userdata['logged_in']['company_id']);
                $data['graphics_operator_master']=$this->common_model->select_active_drop_down('graphics_operator_master',$this->session->userdata['logged_in']['company_id']);

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

                  $result=$this->common_model->update_one_active_record('graphics_daily_screen_master',$data,'dsr_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

                  $data['graphics_daily_screen_master']=$this->daily_screen_record_model->select_one_inactive_record('graphics_daily_screen_master',$this->session->userdata['logged_in']['company_id'],'graphics_daily_screen_master.dpr_id',$this->uri->segment(3));

                
                  $data['page_name']='Sales';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                  $data['graphics_plate_nature_master']=$this->common_model->select_active_drop_down('graphics_plate_nature_master',$this->session->userdata['logged_in']['company_id']);
                  $data['graphics_shift_master']=$this->common_model->select_active_drop_down('graphics_shift_master',$this->session->userdata['logged_in']['company_id']);
                  $data['graphics_plate_making_reasons']=$this->common_model->select_active_drop_down('graphics_plate_making_reasons',$this->session->userdata['logged_in']['company_id']);
                  $data['graphics_machine_master']=$this->common_model->select_active_drop_down('graphics_machine_master',$this->session->userdata['logged_in']['company_id']);
                  $data['graphics_operator_master']=$this->common_model->select_active_drop_down('graphics_operator_master',$this->session->userdata['logged_in']['company_id']);

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
              $data=array('archive'=>'0');

              

              $result=$this->common_model->update_one_active_record('graphics_daily_screen_master',$data,'dsr_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

              $data['graphics_daily_screen_master']=$this->daily_screen_record_model->select_one_active_record('graphics_daily_screen_master',$this->session->userdata['logged_in']['company_id'],'graphics_daily_screen_master.dsr_id',$this->uri->segment(3));

              $data['page_name']='Sales';

              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

              $data['graphics_plate_nature_master']=$this->common_model->select_active_drop_down('graphics_plate_nature_master',$this->session->userdata['logged_in']['company_id']);
              $data['graphics_shift_master']=$this->common_model->select_active_drop_down('graphics_shift_master',$this->session->userdata['logged_in']['company_id']);
              $data['graphics_plate_making_reasons']=$this->common_model->select_active_drop_down('graphics_plate_making_reasons',$this->session->userdata['logged_in']['company_id']);
              $data['graphics_machine_master']=$this->common_model->select_active_drop_down('graphics_machine_master',$this->session->userdata['logged_in']['company_id']);
              $data['graphics_operator_master']=$this->common_model->select_active_drop_down('graphics_operator_master',$this->session->userdata['logged_in']['company_id']);
                  

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
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->delete==1){

             $table='graphics_daily_screen_master';
            include('pagination.php');
            $data['graphics_daily_screen_master']=$this->daily_screen_record_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

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

  function approve(){

      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Sales'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->copy==1){

                  $data=array('final_approval_flag'=>'1',
                              'approved_by'=>$this->session->userdata['logged_in']['user_id'],
                              'approved_date'=>date('Y-m-d h:i:s'));

                  $result=$this->common_model->update_one_active_record('graphics_daily_screen_master',$data,'dsr_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

                  $data['graphics_daily_screen_master']=$this->daily_screen_record_model->select_one_active_record('graphics_daily_screen_master',$this->session->userdata['logged_in']['company_id'],'graphics_daily_screen_master.dsr_id',$this->uri->segment(3));

                
                  $data['page_name']='Sales';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                  $data['graphics_plate_nature_master']=$this->common_model->select_active_drop_down('graphics_plate_nature_master',$this->session->userdata['logged_in']['company_id']);
                  $data['graphics_shift_master']=$this->common_model->select_active_drop_down('graphics_shift_master',$this->session->userdata['logged_in']['company_id']);
                  $data['graphics_plate_making_reasons']=$this->common_model->select_active_drop_down('graphics_plate_making_reasons',$this->session->userdata['logged_in']['company_id']);
                  $data['graphics_machine_master']=$this->common_model->select_active_drop_down('graphics_machine_master',$this->session->userdata['logged_in']['company_id']);
                  $data['graphics_operator_master']=$this->common_model->select_active_drop_down('graphics_operator_master',$this->session->userdata['logged_in']['company_id']);

                  $data['note']='Approve Transaction completed';
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

function view(){

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

            $data['company']=$this->common_model->select_one_active_record('company_master',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);
            $data['company_details']=$this->common_model->select_one_active_record('company_system_parameters',$this->session->userdata['logged_in']['company_id'],'company_id',$this->session->userdata['logged_in']['company_id']);

            $data['graphics_daily_screen_master']=$this->daily_screen_record_model->select_one_active_record('graphics_daily_screen_master',$this->session->userdata['logged_in']['company_id'],'graphics_daily_screen_master.dsr_id',$this->uri->segment(3));

            
            $data['graphics_daily_screen_details']=$this->common_model->select_one_details_record_noncompany('graphics_daily_screen_details','dsr_id',$this->uri->segment(3));



            $data['page_name']='Sales';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
            $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

            //$this->load->view('Home/header');
            //$this->load->view('Home/nav',$data);
            //$this->load->view('Home/subnav');

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

    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Sales'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){

            $data['graphics_plate_nature_master']=$this->common_model->select_active_drop_down('graphics_plate_nature_master',$this->session->userdata['logged_in']['company_id']);
            $data['graphics_shift_master']=$this->common_model->select_active_drop_down('graphics_shift_master',$this->session->userdata['logged_in']['company_id']);
            $data['graphics_plate_making_reasons']=$this->common_model->select_active_drop_down('graphics_plate_making_reasons',$this->session->userdata['logged_in']['company_id']);
            $data['graphics_machine_master']=$this->common_model->select_active_drop_down('graphics_machine_master',$this->session->userdata['logged_in']['company_id']);
            $data['graphics_operator_master']=$this->common_model->select_active_drop_down('graphics_operator_master',$this->session->userdata['logged_in']['company_id']);

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
                       
              $this->form_validation->set_rules('order_no','Order No.' ,'trim|xss_clean');
               $this->form_validation->set_rules('article_no','PSM/PSP No.' ,'trim|xss_clean|callback_article_check');
              $this->form_validation->set_rules('artwork_no','Artwork No.' ,'trim|xss_clean');
              $this->form_validation->set_rules('version_no','Version No.' ,'trim|xss_clean');
              $this->form_validation->set_rules('jobcard_no','Jobcard No.' ,'trim|xss_clean');
              $this->form_validation->set_rules('artwork_no','Artwork No' ,'trim|xss_clean|max_length[6]'); 
              $this->form_validation->set_rules('version_no','Version No' ,'trim|xss_clean|numeric|max_length[3]');
              $this->form_validation->set_rules('shift_id','Shift' ,'trim|xss_clean');
              $this->form_validation->set_rules('machine_id','Machine' ,'trim|xss_clean');
              $this->form_validation->set_rules('operator_id','Plate Maker' ,'trim|xss_clean');
              $this->form_validation->set_rules('reason_id','Reason' ,'trim|xss_clean');
              $this->form_validation->set_rules('comment','Comment' ,'trim|xss_clean');
             
              $this->form_validation->set_rules('artwork_no','Artwork No' ,'trim|xss_clean|max_length[6]'); 
              $this->form_validation->set_rules('version_no','Version No' ,'trim|xss_clean|numeric|max_length[3]');
              


            if($this->form_validation->run()==FALSE){

              $data['graphics_plate_nature_master']=$this->common_model->select_active_drop_down('graphics_plate_nature_master',$this->session->userdata['logged_in']['company_id']);
              $data['graphics_shift_master']=$this->common_model->select_active_drop_down('graphics_shift_master',$this->session->userdata['logged_in']['company_id']);
              $data['graphics_plate_making_reasons']=$this->common_model->select_active_drop_down('graphics_plate_making_reasons',$this->session->userdata['logged_in']['company_id']);
              $data['graphics_machine_master']=$this->common_model->select_active_drop_down('graphics_machine_master',$this->session->userdata['logged_in']['company_id']);
              $data['graphics_operator_master']=$this->common_model->select_active_drop_down('graphics_operator_master',$this->session->userdata['logged_in']['company_id']);

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                $this->load->view('Home/footer');
            }else{
                  
              $article_no="";           

              if(!empty($this->input->post('article_no'))){
                $article_no_arr=explode('//',$this->input->post('article_no'));
                $article_no=$article_no_arr[1];

              }
              $data=array(                    
                
                'order_no'=>$this->input->post('order_no'),
                'article_no'=>$article_no,
                'artwork_no'=>$this->input->post('artwork_no'),
                'version_no'=>$this->input->post('version_no'),
                'jobcard_no'=>$this->input->post('jobcard_no'),
                'screen_making_reason'=>$this->input->post('reason_id'),
                'shift_id'=>$this->input->post('shift_id'),
                'machine_id'=>$this->input->post('machine_id'),
                'operator_id'=>$this->input->post('operator_id'),
                'comment'=>$this->input->post('comment'),
                                
                );




                $data['graphics_daily_screen_master']=$this->daily_screen_record_model->active_record_search('graphics_daily_screen_master',$data,$this->common_model->change_date_format($this->input->post('from_date'),$this->session->userdata['logged_in']['company_id']),$this->common_model->change_date_format($this->input->post('to_date'),$this->session->userdata['logged_in']['company_id']),$this->session->userdata['logged_in']['company_id']);
                //echo $this->db->last_query();
                 
                if($data['graphics_daily_screen_master']!=FALSE){

                    $data['graphics_plate_nature_master']=$this->common_model->select_active_drop_down('graphics_plate_nature_master',$this->session->userdata['logged_in']['company_id']);
                    $data['graphics_shift_master']=$this->common_model->select_active_drop_down('graphics_shift_master',$this->session->userdata['logged_in']['company_id']);
                    $data['graphics_plate_making_reasons']=$this->common_model->select_active_drop_down('graphics_plate_making_reasons',$this->session->userdata['logged_in']['company_id']);
                    $data['graphics_machine_master']=$this->common_model->select_active_drop_down('graphics_machine_master',$this->session->userdata['logged_in']['company_id']);
                    $data['graphics_operator_master']=$this->common_model->select_active_drop_down('graphics_operator_master',$this->session->userdata['logged_in']['company_id']);

                    $data['page_name']='Sales';
                    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                    $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                    $this->load->view('Home/header');
                    $this->load->view('Home/nav',$data);
                    $this->load->view('Home/subnav');
                    $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                    //$this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                    $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
                    $this->load->view('Home/footer');
                }else{
                      $data['page_name']='Sales';
                      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                      $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                      $data['graphics_plate_nature_master']=$this->common_model->select_active_drop_down('graphics_plate_nature_master',$this->session->userdata['logged_in']['company_id']);
                      $data['graphics_shift_master']=$this->common_model->select_active_drop_down('graphics_shift_master',$this->session->userdata['logged_in']['company_id']);
                      $data['graphics_plate_making_reasons']=$this->common_model->select_active_drop_down('graphics_plate_making_reasons',$this->session->userdata['logged_in']['company_id']);
                      $data['graphics_machine_master']=$this->common_model->select_active_drop_down('graphics_machine_master',$this->session->userdata['logged_in']['company_id']);
                      $data['graphics_operator_master']=$this->common_model->select_active_drop_down('graphics_operator_master',$this->session->userdata['logged_in']['company_id']);
                      

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
  
  


 

  
}