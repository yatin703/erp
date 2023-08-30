<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Springtube_daily_plates_record extends CI_Controller {

  function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('artwork_model');
      $this->load->model('artwork_springtube_model');
      $this->load->model('customer_model');
      $this->load->model('article_model');
      $this->load->model('second_sub_group_model');
      $this->load->model('springtube_daily_plates_record_model');
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
            $table='springtube_daily_plates_master';
            include('pagination.php');
            $data['springtube_daily_plates_master']=$this->springtube_daily_plates_record_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

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

            //$data['graphics_plate_nature_master']=$this->common_model->select_active_drop_down('graphics_plate_nature_master',$this->session->userdata['logged_in']['company_id']);
            $data['graphics_shift_master']=$this->common_model->select_active_drop_down('graphics_shift_master',$this->session->userdata['logged_in']['company_id']);
            $data['graphics_plate_making_reasons']=$this->common_model->select_active_drop_down('graphics_plate_making_reasons',$this->session->userdata['logged_in']['company_id']);
            //$data['graphics_machine_master']=$this->common_model->select_active_drop_down('graphics_machine_master',$this->session->userdata['logged_in']['company_id']);
            //$data['graphics_operator_master']=$this->common_model->select_active_drop_down('graphics_operator_master',$this->session->userdata['logged_in']['company_id']);

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
            $this->form_validation->set_rules('ups','Ups' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('repeat','Repeat' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('reason_id','Reason' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('comment','Comment' ,'trim|xss_clean');

            $arr=$this->input->post('pantone');
            //print_r($this->input->post('pantone'));
            if(is_array($arr)){
              for($i=0;$i<count($arr);$i++){

                $this->form_validation->set_rules('pantone[]','Pantone'.$i ,'required|trim|xss_clean');
                $this->form_validation->set_rules('date_on_plate[]','Date On Plate'.$i ,'required|trim|xss_clean');
                 $this->form_validation->set_rules('label_on_plate[]','Label On Plate'.$i ,'required|trim|xss_clean');
                $this->form_validation->set_rules('plate_count[]','No. Of Plates'.$i ,'required|trim|xss_clean');

              }
            }
            

            if($this->form_validation->run()==FALSE){
              
              //$data['graphics_plate_nature_master']=$this->common_model->select_active_drop_down('graphics_plate_nature_master',$this->session->userdata['logged_in']['company_id']);
              $data['graphics_shift_master']=$this->common_model->select_active_drop_down('graphics_shift_master',$this->session->userdata['logged_in']['company_id']);
              $data['graphics_plate_making_reasons']=$this->common_model->select_active_drop_down('graphics_plate_making_reasons',$this->session->userdata['logged_in']['company_id']);
              // $data['graphics_machine_master']=$this->common_model->select_active_drop_down('graphics_machine_master',$this->session->userdata['logged_in']['company_id']);
              // $data['graphics_operator_master']=$this->common_model->select_active_drop_down('graphics_operator_master',$this->session->userdata['logged_in']['company_id']);

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
              $this->load->view('Home/footer');
            }else{
               
              //Artwork Deatils-------------------------
              $data_search=array('ad_id'=>$this->input->post('artwork_no'),
                    'version_no'=>$this->input->post('version_no')
                      );
              $springtube_artwork_result=$this->artwork_springtube_model->active_record_search_new('springtube_artwork_devel_master',$data_search,'','','',$this->session->userdata['logged_in']['company_id']);

              $body_making_type= '';
              $sleeve_dia='';
              $sleeve_length='';
              foreach ($springtube_artwork_result as $springtube_artwork_row) {
                $body_making_type=$springtube_artwork_row->body_making_type;
                $sleeve_dia=$springtube_artwork_row->sleeve_dia;
                $sleeve_length=$springtube_artwork_row->sleeve_length;
              }

              $sleeve_dia_id='';
              $result_sleeve_diameter_master=$this->common_model->select_one_active_record('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id'],'sleeve_diameter',$sleeve_dia);
              //print_r($result_sleeve_diameter_master);
              foreach ($result_sleeve_diameter_master as $sleeve_diameter_master_row ) {
                $sleeve_dia_id=$sleeve_diameter_master_row->sleeve_id;
              
              }
              $data=array('sleeve_dia_id'=>$sleeve_dia_id,'seam_type'=>$body_making_type,'archive'=>'0');
              $springtube_printing_reel_width_master_result=$this->common_model->select_active_records_where('springtube_printing_reel_width_master',$this->session->userdata['logged_in']['company_id'],$data);

              $reel_width=0;                
              foreach ($springtube_printing_reel_width_master_result as $springtube_printing_reel_width_master_row) {                 
                $reel_width=$springtube_printing_reel_width_master_row->reel_width;
              }
              // Deafault Flexo Plate Height is 762MM An Width is 735MM-----

              $data_plates=array('archive'=>'0');
              $springtube_flexo_plate_area_master_result=$this->common_model->select_active_records_where('springtube_flexo_plate_area_master',$this->session->userdata['logged_in']['company_id'],$data_plates);


              $default_flexo_plate_area=0;
              foreach ($springtube_flexo_plate_area_master_result as $springtube_flexo_plate_area_master_row) {
                
                  $default_flexo_plate_area=round($springtube_flexo_plate_area_master_row->width*$springtube_flexo_plate_area_master_row->height);
              }

              // FLEXO PLATE WIDTH CALCULATIONS----------------
              $flexo_plate_width=($reel_width*$this->input->post('ups'))+20;  
              //Flexo Plate Height Calculation------------------
              $flexo_plate_height=(($sleeve_length+2.5)*$this->input->post('repeat'))+20;

              $one_flexo_plate_area=$flexo_plate_width*$flexo_plate_height;

              $total_no_of_plates=0;
              foreach ( $this->input->post('plate_count[]') as $key => $value) {
                $total_no_of_plates+=$value;
              }

              $total_flexo_plate_area=$one_flexo_plate_area*$total_no_of_plates;

              $total_flexo_plates_used=round($total_flexo_plate_area/$default_flexo_plate_area,2);

              
              
              $data=array(                    
                'dpr_date'=>date('Y-m-d'),
                'order_no'=>$this->input->post('order_no'),
                'article_no'=>$this->input->post('article_no'),
                'artwork_no'=>$this->input->post('artwork_no'),
                'version_no'=>$this->input->post('version_no'),
                'jobcard_no'=>$this->input->post('jobcard_no'),
                'ups'=>$this->input->post('ups'),
                'repeat'=>$this->input->post('repeat'),
                'shift_id'=>$this->input->post('shift_id'),
                'plate_making_reason'=>$this->input->post('reason_id'), 
                'comment'=>$this->input->post('comment'),
                'user_id'=>$this->session->userdata['logged_in']['user_id'],
                'company_id'=>$this->session->userdata['logged_in']['company_id'],
                'plate_width'=>$flexo_plate_width,
                'plate_height'=>$flexo_plate_height,
                'total_plates'=>$total_no_of_plates,
                'total_flexo_plate_area'=>$total_flexo_plate_area,
                'sheet_used'=>$total_flexo_plates_used     
              );

              $dpr_id=$this->common_model->save_return_pkey('springtube_daily_plates_master',$data);
              //$dpr_id=0;  
              $arr1=$this->input->post('pantone');
              //print_r($arr1); 
              if($dpr_id!='' || $dpr_id!=0){

                    $arr1=$this->input->post('pantone');
                    //print_r($arr1);
                    if(is_array($arr1)){
                        for($i=0;$i<count($arr1);$i++){

                            $data=array(                    
                              'dpr_id'=>$dpr_id,
                              'pantone_name'=>$this->input->post('pantone['.$i.']'),
                              'label_on_plate'=>$this->input->post('label_on_plate['.$i.']'),
                              'date_on_plate'=>$this->input->post('date_on_plate['.$i.']'),
                              'no_of_plates'=>$this->input->post('plate_count['.$i.']'),
                              // 'artwork_para_id'=>$this->input->post('artwork_para_id['.$i.']'),
                              'artwork_para_id'=>'18',
                              'create_date'=>date('Y-m-d h:i:s')
                                         
                              );
                            
                            $result=$this->common_model->save('springtube_daily_plates_details',$data);

                        }
                    }
              }    

              //     // Inserting Flexo Plate CON-FLEXO-PLT-0029 in to printing Jobcard----------
                  
              //     $data['part_pos_no']=$this->common_model->select_max_pkey_where('material_manufacturing','part_pos_no','manu_order_no',$this->input->post('jobcard_no'),$this->session->userdata['logged_in']['company_id']);
    
              //     foreach($data['part_pos_no'] as $part_pos_no_row){
              //       $part_pos_no=$part_pos_no_row->part_pos_no+1;
              //     }

              //     $data['max_mm']=$this->common_model->select_max_pkey_numeric('material_manufacturing','mm_id',$this->session->userdata['logged_in']['company_id']);
    
              //     foreach($data['max_mm'] as $max_mm_row){
              //       $mm_id=$max_mm_row->mm_id+1;
              //     }
                 
              //     $data=array(
              //       'manu_order_no'=>$this->input->post('jobcard_no'),
              //       'article_no'=>'CON-FLEXO-PLT-0029',
              //       'demand_qty'=>$this->common_model->save_number($total_flexo_plate_area,$this->session->userdata['logged_in']['company_id']),
              //       'company_id'=>$this->session->userdata['logged_in']['company_id'],
              //       'work_proc_no'=>'3',
              //       'from_job_card'=>'1',
              //       'rel_demand_qty'=>$this->common_model->save_number($total_flexo_plate_area*1000,$this->session->userdata['logged_in']['company_id']),
              //       'flag_uom_type'=>'1',
              //       'mm_id'=>$mm_id,
              //       'rel_uom_id'=>'9',
              //       'part_pos_no'=>$part_pos_no
              //     );
                  
              //     $result=$this->common_model->save('material_manufacturing',$data); 

              // }

              if($result){
                 $data['note']='Create Transaction Completed';
               }else{
                $data['error']='Create Transaction failed';
               }

              header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

              $data['page_name']='Sales';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());
              $data['note']='Create Transaction Completed';
             // header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

              //$data['graphics_plate_nature_master']=$this->common_model->select_active_drop_down('graphics_plate_nature_master',$this->session->userdata['logged_in']['company_id']);
              $data['graphics_shift_master']=$this->common_model->select_active_drop_down('graphics_shift_master',$this->session->userdata['logged_in']['company_id']);
              $data['graphics_plate_making_reasons']=$this->common_model->select_active_drop_down('graphics_plate_making_reasons',$this->session->userdata['logged_in']['company_id']);
              // $data['graphics_machine_master']=$this->common_model->select_active_drop_down('graphics_machine_master',$this->session->userdata['logged_in']['company_id']);
              // $data['graphics_operator_master']=$this->common_model->select_active_drop_down('graphics_operator_master',$this->session->userdata['logged_in']['company_id']);

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

            $data['springtube_daily_plates_master']=$this->springtube_daily_plates_record_model->select_one_active_record('springtube_daily_plates_master',$this->session->userdata['logged_in']['company_id'],'springtube_daily_plates_master.dpr_id',$this->uri->segment(3));

             // $data['graphics_plate_nature_master']=$this->common_model->select_active_drop_down('graphics_plate_nature_master',$this->session->userdata['logged_in']['company_id']);
              $data['graphics_shift_master']=$this->common_model->select_active_drop_down('graphics_shift_master',$this->session->userdata['logged_in']['company_id']);
              $data['graphics_plate_making_reasons']=$this->common_model->select_active_drop_down('graphics_plate_making_reasons',$this->session->userdata['logged_in']['company_id']);
              // $data['graphics_machine_master']=$this->common_model->select_active_drop_down('graphics_machine_master',$this->session->userdata['logged_in']['company_id']);
              // $data['graphics_operator_master']=$this->common_model->select_active_drop_down('graphics_operator_master',$this->session->userdata['logged_in']['company_id']);

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
              $this->form_validation->set_rules('ups','Ups' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('repeat','Repeat' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('reason_id','Reason' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('comment','Comment' ,'trim|xss_clean');

              $arr=$this->input->post('pantone');
              
              if(is_array($arr)){
                for($i=0;$i<count($arr);$i++){

                  $this->form_validation->set_rules('pantone[]','Pantone'.$i ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('date_on_plate[]','Date On Plate'.$i ,'required|trim|xss_clean');
                   $this->form_validation->set_rules('label_on_plate[]','Label On Plate'.$i ,'required|trim|xss_clean');
                  $this->form_validation->set_rules('plate_count[]','No. Of Plates'.$i ,'required|trim|xss_clean');

                }
              }              

              if($this->form_validation->run()==FALSE){

                
                $data['springtube_daily_plates_master']=$this->springtube_daily_plates_record_model->select_one_active_record('springtube_daily_plates_master',$this->session->userdata['logged_in']['company_id'],'springtube_daily_plates_master.dpr_id',$this->input->post('dpr_id'));

                // $data['graphics_plate_nature_master']=$this->common_model->select_active_drop_down('graphics_plate_nature_master',$this->session->userdata['logged_in']['company_id']);
                $data['graphics_shift_master']=$this->common_model->select_active_drop_down('graphics_shift_master',$this->session->userdata['logged_in']['company_id']);
                $data['graphics_plate_making_reasons']=$this->common_model->select_active_drop_down('graphics_plate_making_reasons',$this->session->userdata['logged_in']['company_id']);
                // $data['graphics_machine_master']=$this->common_model->select_active_drop_down('graphics_machine_master',$this->session->userdata['logged_in']['company_id']);
                // $data['graphics_operator_master']=$this->common_model->select_active_drop_down('graphics_operator_master',$this->session->userdata['logged_in']['company_id']);
                
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
                $this->load->view('Home/footer');

              }else{

                  //Artwork Deatils-------------------------
                $data_search=array('ad_id'=>$this->input->post('artwork_no'),
                      'version_no'=>$this->input->post('version_no')
                        );
                $springtube_artwork_result=$this->artwork_springtube_model->active_record_search_new('springtube_artwork_devel_master',$data_search,'','','',$this->session->userdata['logged_in']['company_id']);

                $body_making_type= '';
                $sleeve_dia='';
                $sleeve_length='';
                foreach ($springtube_artwork_result as $springtube_artwork_row) {
                  $body_making_type=$springtube_artwork_row->body_making_type;
                  $sleeve_dia=$springtube_artwork_row->sleeve_dia;
                  $sleeve_length=$springtube_artwork_row->sleeve_length;
                }

                $sleeve_dia_id='';
                $result_sleeve_diameter_master=$this->common_model->select_one_active_record('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id'],'sleeve_diameter',$sleeve_dia);
                //print_r($result_sleeve_diameter_master);
                foreach ($result_sleeve_diameter_master as $sleeve_diameter_master_row ) {
                  $sleeve_dia_id=$sleeve_diameter_master_row->sleeve_id;
                
                }
                $data=array('sleeve_dia_id'=>$sleeve_dia_id,'seam_type'=>$body_making_type,'archive'=>'0');
                $springtube_printing_reel_width_master_result=$this->common_model->select_active_records_where('springtube_printing_reel_width_master',$this->session->userdata['logged_in']['company_id'],$data);

                $reel_width=0;                
                foreach ($springtube_printing_reel_width_master_result as $springtube_printing_reel_width_master_row) {                 
                  $reel_width=$springtube_printing_reel_width_master_row->reel_width;
                }
                // Deafault Flexo Plate Height is 762MM An Width is 735MM-----

                $data_plates=array('archive'=>'0');
                $springtube_flexo_plate_area_master_result=$this->common_model->select_active_records_where('springtube_flexo_plate_area_master',$this->session->userdata['logged_in']['company_id'],$data_plates);


                $default_flexo_plate_area=0;
                foreach ($springtube_flexo_plate_area_master_result as $springtube_flexo_plate_area_master_row) {
                  
                    $default_flexo_plate_area=round($springtube_flexo_plate_area_master_row->width*$springtube_flexo_plate_area_master_row->height);
                }

                // FLEXO PLATE WIDTH CALCULATIONS----------------
                $flexo_plate_width=($reel_width*$this->input->post('ups'))+20;  
                //Flexo Plate Height Calculation------------------
                $flexo_plate_height=(($sleeve_length+2.5)*$this->input->post('repeat'))+20;

                $one_flexo_plate_area=$flexo_plate_width*$flexo_plate_height;

                $total_no_of_plates=0;
                foreach ( $this->input->post('plate_count[]') as $key => $value) {
                  $total_no_of_plates+=$value;
                }

                $total_flexo_plate_area=$one_flexo_plate_area*$total_no_of_plates;

                $total_flexo_plates_used=round($total_flexo_plate_area/$default_flexo_plate_area,2);              
              
                $data=array(                    
                   
                  'order_no'=>$this->input->post('order_no'),
                  'article_no'=>$this->input->post('article_no'),
                  'artwork_no'=>$this->input->post('artwork_no'),
                  'version_no'=>$this->input->post('version_no'),
                  'jobcard_no'=>$this->input->post('jobcard_no'),
                  'ups'=>$this->input->post('ups'),
                  'repeat'=>$this->input->post('repeat'),
                  'shift_id'=>$this->input->post('shift_id'),
                  'plate_making_reason'=>$this->input->post('reason_id'), 
                  'comment'=>$this->input->post('comment'),
                  'user_id'=>$this->session->userdata['logged_in']['user_id'],
                  'company_id'=>$this->session->userdata['logged_in']['company_id'],
                  'plate_width'=>$flexo_plate_width,
                  'plate_height'=>$flexo_plate_height,
                  'total_plates'=>$total_no_of_plates,
                  'total_flexo_plate_area'=>$total_flexo_plate_area,
                  'sheet_used'=>$total_flexo_plates_used     
                );

                $result=$this->common_model->update_one_active_record('springtube_daily_plates_master',$data,'dpr_id',$this->input->post('dpr_id'),$this->session->userdata['logged_in']['company_id']);

                // Removing Old Plate details and inserting new
                $result=$this->common_model->delete_one_active_record_noncompany('springtube_daily_plates_details','dpr_id',$this->input->post('dpr_id'));

                $arr1=$this->input->post('pantone');
                //print_r($arr1); 
                if($this->input->post('dpr_id')!='' || $this->input->post('dpr_id')!=0){

                    $arr1=$this->input->post('pantone');
                    //print_r($arr1);
                    if(is_array($arr1)){

                        for($i=0;$i<count($arr1);$i++){

                          $data=array(                    
                            'dpr_id'=>$this->input->post('dpr_id'),
                            'pantone_name'=>$this->input->post('pantone['.$i.']'),
                            'label_on_plate'=>$this->input->post('label_on_plate['.$i.']'),
                            'date_on_plate'=>$this->input->post('date_on_plate['.$i.']'),
                            'no_of_plates'=>$this->input->post('plate_count['.$i.']'),
                            //'artwork_para_id'=>$this->input->post('artwork_para_id['.$i.']'),
                            'artwork_para_id'=>'18',
                            'create_date'=>date('Y-m-d h:i:s')
                                         
                          );
                            
                          $result=$this->common_model->save('springtube_daily_plates_details',$data);

                          // $data=array(                             
                          //   'demand_qty'=>$this->common_model->save_number($total_flexo_plate_area,$this->session->userdata['logged_in']['company_id']),                             
                          //   'rel_demand_qty'=>$this->common_model->save_number($total_flexo_plate_area*1000,$this->session->userdata['logged_in']['company_id'])                            
                          // );

                          // $result=$this->common_model->update_one_active_record_where('material_manufacturing',$data,'manu_order_no',$this->input->post('jobcard_no'),'article_no','CON-FLEXO-PLT-0029',$this->session->userdata['logged_in']['company_id']);                          

                        }
                    }
                }

                if($result){                  
                  $data['note']='Update Transaction Completed';
                }else{
                  $data['error']='Update Transaction Failed';
                }
                header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                $data['page_name']='Sales';

                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                $data['springtube_daily_plates_master']=$this->springtube_daily_plates_record_model->select_one_active_record('springtube_daily_plates_master',$this->session->userdata['logged_in']['company_id'],'springtube_daily_plates_master.dpr_id',$this->input->post('dpr_id'));

                // $data['graphics_plate_nature_master']=$this->common_model->select_active_drop_down('graphics_plate_nature_master',$this->session->userdata['logged_in']['company_id']);
                $data['graphics_shift_master']=$this->common_model->select_active_drop_down('graphics_shift_master',$this->session->userdata['logged_in']['company_id']);
                $data['graphics_plate_making_reasons']=$this->common_model->select_active_drop_down('graphics_plate_making_reasons',$this->session->userdata['logged_in']['company_id']);
                // $data['graphics_machine_master']=$this->common_model->select_active_drop_down('graphics_machine_master',$this->session->userdata['logged_in']['company_id']);
                // $data['graphics_operator_master']=$this->common_model->select_active_drop_down('graphics_operator_master',$this->session->userdata['logged_in']['company_id']);

                


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

                  $result=$this->common_model->update_one_active_record('springtube_daily_plates_master',$data,'dpr_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

                  $data['springtube_daily_plates_master']=$this->springtube_daily_plates_record_model->select_one_inactive_record('springtube_daily_plates_master',$this->session->userdata['logged_in']['company_id'],'springtube_daily_plates_master.dpr_id',$this->uri->segment(3));

                
                  $data['page_name']='Sales';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

                  //$data['graphics_plate_nature_master']=$this->common_model->select_active_drop_down('graphics_plate_nature_master',$this->session->userdata['logged_in']['company_id']);
                  $data['graphics_shift_master']=$this->common_model->select_active_drop_down('graphics_shift_master',$this->session->userdata['logged_in']['company_id']);
                  $data['graphics_plate_making_reasons']=$this->common_model->select_active_drop_down('graphics_plate_making_reasons',$this->session->userdata['logged_in']['company_id']);
                  // $data['graphics_machine_master']=$this->common_model->select_active_drop_down('graphics_machine_master',$this->session->userdata['logged_in']['company_id']);
                  // $data['graphics_operator_master']=$this->common_model->select_active_drop_down('graphics_operator_master',$this->session->userdata['logged_in']['company_id']);

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

              $result=$this->common_model->update_one_active_record('springtube_daily_plates_master',$data,'dpr_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

              $data['springtube_daily_plates_master']=$this->springtube_daily_plates_record_model->select_one_active_record('springtube_daily_plates_master',$this->session->userdata['logged_in']['company_id'],'springtube_daily_plates_master.dpr_id',$this->uri->segment(3));

              $data['page_name']='Sales';

              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

              //$data['graphics_plate_nature_master']=$this->common_model->select_active_drop_down('graphics_plate_nature_master',$this->session->userdata['logged_in']['company_id']);
              $data['graphics_shift_master']=$this->common_model->select_active_drop_down('graphics_shift_master',$this->session->userdata['logged_in']['company_id']);
              $data['graphics_plate_making_reasons']=$this->common_model->select_active_drop_down('graphics_plate_making_reasons',$this->session->userdata['logged_in']['company_id']);
              // $data['graphics_machine_master']=$this->common_model->select_active_drop_down('graphics_machine_master',$this->session->userdata['logged_in']['company_id']);
              // $data['graphics_operator_master']=$this->common_model->select_active_drop_down('graphics_operator_master',$this->session->userdata['logged_in']['company_id']);
                  

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

             $table='springtube_daily_plates_master';
            include('pagination.php');
            $data['springtube_daily_plates_master']=$this->springtube_daily_plates_record_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

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

  // function approve(){

  //     $data['page_name']='Sales';
  //     $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
  //     if($data['module']!=FALSE){
  //     foreach ($data['module'] as $module_row) {
  //       if($module_row->module_name==='Sales'){
  //         $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

  //         foreach ($data['formrights'] as $formrights_row) {
  //           if($formrights_row->copy==1){

  //                 $data=array('final_approval_flag'=>'1',
  //                             'approved_by'=>$this->session->userdata['logged_in']['user_id'],
  //                             'approved_date'=>date('Y-m-d h:i:s'));

  //                 $result=$this->common_model->update_one_active_record('springtube_daily_plates_master',$data,'dpr_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

  //                 $data['springtube_daily_plates_master']=$this->springtube_daily_plates_record_model->select_one_active_record('springtube_daily_plates_master',$this->session->userdata['logged_in']['company_id'],'springtube_daily_plates_master.dpr_id',$this->uri->segment(3));

                
  //                 $data['page_name']='Sales';
  //                 $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
  //                 $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,$this->router->fetch_class());

  //                 $data['graphics_plate_nature_master']=$this->common_model->select_active_drop_down('graphics_plate_nature_master',$this->session->userdata['logged_in']['company_id']);
  //                 $data['graphics_shift_master']=$this->common_model->select_active_drop_down('graphics_shift_master',$this->session->userdata['logged_in']['company_id']);
  //                 $data['graphics_plate_making_reasons']=$this->common_model->select_active_drop_down('graphics_plate_making_reasons',$this->session->userdata['logged_in']['company_id']);
  //                 $data['graphics_machine_master']=$this->common_model->select_active_drop_down('graphics_machine_master',$this->session->userdata['logged_in']['company_id']);
  //                 $data['graphics_operator_master']=$this->common_model->select_active_drop_down('graphics_operator_master',$this->session->userdata['logged_in']['company_id']);

  //                 $data['note']='Approve Transaction completed';
  //                 header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
  //                 $this->load->view('Home/header');
  //                 $this->load->view('Home/nav',$data);
  //                 $this->load->view('Home/subnav');
  //                 $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
  //                 $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
  //                 $this->load->view('Home/footer');
  //           }else{
  //               $data['note']='No Archive rights Thanks';
  //               $this->load->view('Home/header');
  //               $this->load->view('Home/nav',$data);
  //               $this->load->view('Home/subnav');
  //               $this->load->view('Error/error-title',$data);
  //               $this->load->view('Home/footer');
  //           }
  //         }
  //       }
  //     }
  //   }else{
  //       $data['note']='No Archive rights Thanks';
  //       $data['page_name']='home';
  //       $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
  //       $this->load->view('Home/header');
  //       $this->load->view('Home/nav',$data);
  //       $this->load->view('Home/subnav');
  //       $this->load->view('Error/error-title',$data);
  //       $this->load->view('Home/footer');
  //     }
  //   }

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

            $data['springtube_daily_plates_master']=$this->springtube_daily_plates_record_model->select_one_active_record('springtube_daily_plates_master',$this->session->userdata['logged_in']['company_id'],'springtube_daily_plates_master.dpr_id',$this->uri->segment(3));

            
            $data['springtube_daily_plates_details']=$this->common_model->select_one_details_record_noncompany('springtube_daily_plates_details','dpr_id',$this->uri->segment(3));
            
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

            // $data['graphics_plate_nature_master']=$this->common_model->select_active_drop_down('graphics_plate_nature_master',$this->session->userdata['logged_in']['company_id']);
            $data['graphics_shift_master']=$this->common_model->select_active_drop_down('graphics_shift_master',$this->session->userdata['logged_in']['company_id']);
            $data['graphics_plate_making_reasons']=$this->common_model->select_active_drop_down('graphics_plate_making_reasons',$this->session->userdata['logged_in']['company_id']);
            // $data['graphics_machine_master']=$this->common_model->select_active_drop_down('graphics_machine_master',$this->session->userdata['logged_in']['company_id']);
            // $data['graphics_operator_master']=$this->common_model->select_active_drop_down('graphics_operator_master',$this->session->userdata['logged_in']['company_id']);

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
               $this->form_validation->set_rules('article_no','SPSM/SPSP No.' ,'trim|xss_clean|callback_article_check');
              $this->form_validation->set_rules('artwork_no','Artwork No.' ,'trim|xss_clean');
              $this->form_validation->set_rules('version_no','Version No.' ,'trim|xss_clean');
              $this->form_validation->set_rules('jobcard_no','Jobcard No.' ,'trim|xss_clean');
              $this->form_validation->set_rules('shift_id','Shift' ,'trim|xss_clean');
              $this->form_validation->set_rules('ups','Ups' ,'trim|xss_clean');
              $this->form_validation->set_rules('repeat','Repeat' ,'trim|xss_clean');
              $this->form_validation->set_rules('reason_id','Reason' ,'trim|xss_clean');
              $this->form_validation->set_rules('comment','Comment' ,'trim|xss_clean');    
               
              


            if($this->form_validation->run()==FALSE){

              //$data['graphics_plate_nature_master']=$this->common_model->select_active_drop_down('graphics_plate_nature_master',$this->session->userdata['logged_in']['company_id']);
              $data['graphics_shift_master']=$this->common_model->select_active_drop_down('graphics_shift_master',$this->session->userdata['logged_in']['company_id']);
              $data['graphics_plate_making_reasons']=$this->common_model->select_active_drop_down('graphics_plate_making_reasons',$this->session->userdata['logged_in']['company_id']);
              //$data['graphics_machine_master']=$this->common_model->select_active_drop_down('graphics_machine_master',$this->session->userdata['logged_in']['company_id']);
              //$data['graphics_operator_master']=$this->common_model->select_active_drop_down('graphics_operator_master',$this->session->userdata['logged_in']['company_id']);

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
                'plate_making_reason'=>$this->input->post('reason_id'),
                'shift_id'=>$this->input->post('shift_id'),
                'ups'=>$this->input->post('ups'),
                'repeat'=>$this->input->post('repeat'),
                'comment'=>$this->input->post('comment'),
                                
                );

                $data['springtube_daily_plates_master']=$this->springtube_daily_plates_record_model->active_record_search('springtube_daily_plates_master',$data,$this->common_model->change_date_format($this->input->post('from_date'),$this->session->userdata['logged_in']['company_id']),$this->common_model->change_date_format($this->input->post('to_date'),$this->session->userdata['logged_in']['company_id']),$this->session->userdata['logged_in']['company_id']);
                //$this->db->last_query();
                 
                if($data['springtube_daily_plates_master']!=FALSE){

                    //$data['graphics_plate_nature_master']=$this->common_model->select_active_drop_down('graphics_plate_nature_master',$this->session->userdata['logged_in']['company_id']);
                    $data['graphics_shift_master']=$this->common_model->select_active_drop_down('graphics_shift_master',$this->session->userdata['logged_in']['company_id']);
                    $data['graphics_plate_making_reasons']=$this->common_model->select_active_drop_down('graphics_plate_making_reasons',$this->session->userdata['logged_in']['company_id']);
                    //$data['graphics_machine_master']=$this->common_model->select_active_drop_down('graphics_machine_master',$this->session->userdata['logged_in']['company_id']);
                    //$data['graphics_operator_master']=$this->common_model->select_active_drop_down('graphics_operator_master',$this->session->userdata['logged_in']['company_id']);

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

                      //$data['graphics_plate_nature_master']=$this->common_model->select_active_drop_down('graphics_plate_nature_master',$this->session->userdata['logged_in']['company_id']);
                      $data['graphics_shift_master']=$this->common_model->select_active_drop_down('graphics_shift_master',$this->session->userdata['logged_in']['company_id']);
                      $data['graphics_plate_making_reasons']=$this->common_model->select_active_drop_down('graphics_plate_making_reasons',$this->session->userdata['logged_in']['company_id']);
                      //$data['graphics_machine_master']=$this->common_model->select_active_drop_down('graphics_machine_master',$this->session->userdata['logged_in']['company_id']);
                      //$data['graphics_operator_master']=$this->common_model->select_active_drop_down('graphics_operator_master',$this->session->userdata['logged_in']['company_id']);
                      

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