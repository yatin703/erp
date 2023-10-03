<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Springtube_extrusion_production extends CI_Controller {

  function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('article_model');
      $this->load->model('fiscal_model');
      $this->load->model('sales_order_book_model');
      $this->load->model('sales_order_status_model');
      $this->load->model('artwork_springtube_model');
      $this->load->model('springtube_extrusion_production_model');
      $this->load->model('specification_model');
      $this->load->model('job_card_model');
    }else{
      redirect('login','refresh');
    }
  }

  function index(){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){

              $table='springtube_extrusion_production_master';
              include('pagination.php');
              $data['springtube_extrusion_production_master']=$this->springtube_extrusion_production_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
             //echo $this->db->last_query();
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
              //$this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
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
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->new==1){


              $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);
             //echo $this->db->last_query();
              $dataa = array('process_id' =>'1');
              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

              $data_shift_issue=array('archive'=>0,'process_id'=>1);
              $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue);

              //springtube_shift_master
              $data['springtube_shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);


              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
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

  function save(){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){

        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){


            $this->form_validation->set_rules('production_date','Production Date' ,'required|trim|xss_clean|callback_shift_check_new');

            $this->form_validation->set_rules('shift','shift' ,'required|trim|xss_clean');

            $this->form_validation->set_rules('machine','Machine Name' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('qc_incharge','QC Incharge Name' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('shift_issue','Shift Issues' ,'trim|xss_clean');

            $this->form_validation->set_rules('remarks','Remarks' ,'trim|xss_clean');

            foreach($this->input->post('sr_no') as $sr_no => $sr_no_value){

              $this->form_validation->set_rules('jobcard_no_'.$sr_no_value.'','Jobcard No '.$sr_no_value.'' ,'required|trim|xss_clean|max_length[50]|callback_jobcard_close_check|callback_material_issue_check');
              $this->form_validation->set_rules('total_meters_produced_'.$sr_no_value.'','Total Meters Produced '.$sr_no_value.'' ,'required|trim|xss_clean|max_length[10]|greater_than[0]|callback_jobcard_meters_check['.$this->input->post('jobcard_no_'.$sr_no_value).']');
              $this->form_validation->set_rules('total_job_weight_'.$sr_no_value.'','Total Job Weight (Kg) '.$sr_no_value.'' ,'required|trim|xss_clean|greater_than[0]');
              $this->form_validation->set_rules('total_waste_'.$sr_no_value.'','Total Waste (Kg) '.$sr_no_value.'' ,'required|trim|xss_clean|max_length[15]|greater_than[0]');

              // Setup
              $this->form_validation->set_rules('total_setup_meters_'.$sr_no_value,'Total Setup Meters '.$sr_no_value.'' ,'trim|xss_clean');
              $this->form_validation->set_rules('total_setup_weight_'.$sr_no_value,'Total Setup Weight '.$sr_no_value.'' ,'trim|xss_clean');

              if(!empty($this->input->post('total_setup_weight_'.$sr_no_value)) && $this->input->post('total_setup_weight_'.$sr_no_value)>0){

                $this->form_validation->set_rules('setup_reason_'.$sr_no_value,'Setup Reason '.$sr_no_value.'' ,'required|trim|xss_clean');
              }

              // Purging

              $this->form_validation->set_rules('total_purging_weight_'.$sr_no_value,'Total Perging Weight '.$sr_no_value.'' ,'trim|xss_clean');

              if(!empty($this->input->post('total_purging_weight_'.$sr_no_value)) && $this->input->post('total_purging_weight_'.$sr_no_value)>0){

                $this->form_validation->set_rules('purging_reason_'.$sr_no_value,'Purging Reason '.$sr_no_value.'' ,'required|trim|xss_clean');
              }

            }



            if($this->form_validation->run()==FALSE){

              $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);

              $dataa = array('process_id' =>'1');
              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

              $data_shift_issue=array('archive'=>0,'process_id'=>1);
              $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue);

              //springtube_shift_master
              $data['springtube_shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);

              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
              $this->load->view('Home/footer');
            }else{

                $customer='';
                $order_no='';
                $article_no='';
                $bom_no='';
                $bom_version_no='';
                $film_code='';
                $jobcard_no='';


                //print_r($this->input->post('shift_issue'));
                $shift_issues='';
                if(!empty($this->input->post('shift_issue'))){
                  $shift_issues=implode("," , $this->input->post('shift_issue'));
                }

                $shift='';
                $shift=$this->input->post('shift');
                $production_time=date('H:i:s');
                // $production_date=date('Y-m-d');

                // if($production_time >'08:00:00' AND $production_time <'15:59:59' ){
                //   $shift='1';
                // }else if($production_time >'16:00:00' AND $production_time <'23:59:59'){
                //   $shift='2';
                // }else if($production_time >'00:00:00' AND $production_time <'07:59:59'){
                //   $shift='3';
                //   $production_date=date('Y-m-d',strtotime("-1 days"));

                // }else{

                //   $shift='';
                // }


                $production_date=$this->input->post('production_date');

                $data=array(
                  'company_id'=>$this->session->userdata['logged_in']['company_id'],
                  'production_date'=>$production_date,
                  'shift'=>$shift,
                  'process_id'=>'1',
                  'machine_id'=>$this->input->post('machine'),
                  'qc_incharge'=>trim(strtoupper($this->input->post('qc_incharge'))),
                  'remarks'=>trim(strtoupper($this->input->post('remarks'))),
                  'shift_issues'=>$shift_issues,
                  'user_id'=>$this->session->userdata['logged_in']['user_id'],
                  'created_date'=>date('Y-m-d H:i:s'),
                  'production_time'=>date('H:i:s')
                  );

                $production_id=$this->common_model->save_return_pkey('springtube_extrusion_production_master',$data);

                if($production_id!=''){

                  foreach($this->input->post('sr_no') as $sr_no => $sr_no_value){

                    $jobcard_no= $this->input->post('jobcard_no_'.$sr_no_value);

                    $production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no', $jobcard_no);

                    foreach($production_master_result as $row) {
                      $order_no=$row->sales_ord_no;
                      $article_no=$row->article_no;
                    }

                    $order_master_result=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$order_no);
                    foreach($order_master_result as $order_master_row){
                      $customer=$order_master_row->customer_no;
                    }

                    $data_order_details=array(
                    'order_no'=>$order_no,
                    'article_no'=>$article_no
                    );

                    $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
                    foreach($order_details_result as $order_details_row){
                      $bom_no=$order_details_row->spec_id;
                      $bom_version_no=$order_details_row->spec_version_no;
                    }

                    $data=array('bom_no'=>$bom_no,'bom_version_no'=>$bom_version_no);

                    $bill_of_material_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data);

                    foreach ($bill_of_material_result as $bill_of_material_row) {
                      $bom_id=$bill_of_material_row->bom_id;
                      $film_code=$bill_of_material_row->sleeve_code;

                    }
                    //SLEEVE---------------------------------

                      $film_spec_id='';
                      $film_spec_version='';

                      $film_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$film_code);

                      foreach($film_code_result as $film_code_row){
                        $film_spec_id=$film_code_row->spec_id;
                        $film_spec_version=$film_code_row->spec_version_no;
                      }

                    $specs['spec_id']=$film_spec_id;
                    $specs['spec_version_no']=$film_spec_version;

                    $specs_result=$this->sales_order_book_model->select_film_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$specs);

                    $total_microns=0;
                    if($specs_result){

                      foreach($specs_result as $specs_row){
                          $sleeve_diameter=$specs_row->SLEEVE_DIA;
                          $sleeve_length=$specs_row->SLEEVE_LENGTH;
                          $sleeve_mb_2=$specs_row->FILM_MASTER_BATCH_2;
                          $sleeve_mb_6=$specs_row->FILM_MASTER_BATCH_6;
                          $micron_1=$specs_row->FILM_GUAGE_1;
                          $micron_2=$specs_row->FILM_GUAGE_2;
                          $micron_3=$specs_row->FILM_GUAGE_3;
                          $micron_4=$specs_row->FILM_GUAGE_4;
                          $micron_5=$specs_row->FILM_GUAGE_5;
                          $micron_6=$specs_row->FILM_GUAGE_6;
                          $micron_7=$specs_row->FILM_GUAGE_7;

                      }

                      $total_microns=$micron_1+$micron_2+$micron_3+$micron_4+$micron_5+$micron_6+$micron_7;

                    }

                    $produced_qty=0;
                    $production_qty=$this->jobcard_meters_to_qty($jobcard_no,$this->input->post('total_meters_produced_'.$sr_no_value));

                    //Setup jobcard creation--------
                    $setup_jobcard_no='';
                    if(!empty($this->input->post('total_setup_weight_'.$sr_no_value)) && $this->input->post('total_setup_weight_'.$sr_no_value)>0){

                      $setup_jobcard_no=$this->create_setup_jobcard($jobcard_no,$this->input->post('total_setup_meters_'.$sr_no_value),$this->input->post('total_setup_weight_'.$sr_no_value));
                    }

                    //Purging Jobcard creation------
                      $purging_jobcard_no='';
                    if(!empty($this->input->post('total_purging_weight_'.$sr_no_value)) && $this->input->post('total_purging_weight_'.$sr_no_value)>0){

                      $purging_jobcard_no=$this->create_purging_jobcard($jobcard_no,$this->input->post('total_purging_weight_'.$sr_no_value));
                    }

                    $data=array(
                      'production_id'=>$production_id,
                      'customer'=>$customer,
                      'jobcard_no'=>$jobcard_no,
                      'order_no'=>$order_no,
                      'article_no'=>$article_no,
                      'sleeve_dia'=>$sleeve_diameter,
                      'sleeve_length'=>$sleeve_length,
                      'total_microns'=>$total_microns,
                      'job_pos_no'=>$sr_no_value,
                      'film_code'=>$film_code,
                      'second_layer_mb'=>$sleeve_mb_2,
                      'sixth_layer_mb'=>$sleeve_mb_6,
                      'total_meters_produced'=>$this->input->post('total_meters_produced_'.$sr_no_value),
                      'production_qty'=>$production_qty,
                      'total_job_weight'=>$this->input->post('total_job_weight_'.$sr_no_value),
                      'total_waste'=>$this->input->post('total_waste_'.$sr_no_value),
                      'date'=>date('Y-m-d'),
                      'setup_jobcard_no'=>$setup_jobcard_no,
                      'total_setup_meters'=>$this->input->post('total_setup_meters_'.$sr_no_value),
                      'total_setup_weight'=>$this->input->post('total_setup_weight_'.$sr_no_value),
                      'setup_reason'=>$this->input->post('setup_reason_'.$sr_no_value),
                      'purging_jobcard'=>$purging_jobcard_no,
                      'total_purging_weight'=>$this->input->post('total_purging_weight_'.$sr_no_value),
                      'purging_reason'=>$this->input->post('purging_reason_'.$sr_no_value),
                    );

                    $result=$this->common_model->save('springtube_extrusion_production_details',$data);



                }//Foreach

              }else{

                $data['note']='Error while saving master data';

              }



                $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

                $data['note']='Create Transaction Completed';

                header("refresh:0;url=".base_url()."index.php/".$this->router->fetch_class());

                $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);

                $dataa = array('process_id' =>'1');
                $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

                $data_shift_issue=array('archive'=>0,'process_id'=>1);
                $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue);

                //springtube_shift_master
              $data['springtube_shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);

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

  function modify($production_id){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){

              $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);
             //echo $this->db->last_query();
              $dataa = array('process_id' =>'1');
              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

              $data_shift_issue=array('archive'=>0,'process_id'=>1);
              $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue);

              $table='springtube_extrusion_production_master';
              $data['springtube_extrusion_production_master']=$this->springtube_extrusion_production_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'production_id',$production_id);

              $dataa=array('production_id'=>$production_id);
              $table='springtube_extrusion_production_details';
              $data['springtube_extrusion_production_details']=$this->springtube_extrusion_production_model->active_details_records($table,$dataa);

             // echo $this->db->last_query();

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

    function update(){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){

      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {

            if($formrights_row->modify==1){

              $this->form_validation->set_rules('machine','Machine Name' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('qc_incharge','QC Incharge Name' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('shift_issue','Shift Issues' ,'trim|xss_clean');

              $this->form_validation->set_rules('remarks','Remarks' ,'trim|xss_clean');

              foreach($this->input->post('sr_no') as $sr_no => $sr_no_value){

                $this->form_validation->set_rules('jobcard_no_'.$sr_no_value.'','Jobcard No '.$sr_no_value.'' ,'required|trim|xss_clean|max_length[50]');
                $this->form_validation->set_rules('total_meters_produced_'.$sr_no_value.'','Total Meters Produced '.$sr_no_value.'' ,'required|trim|xss_clean|max_length[10]');
				        //$this->form_validation->set_rules('total_meters_produced_'.$sr_no_value.'','Total Meters Produced '.$sr_no_value.'' ,'required|trim|xss_clean|max_length[10]');
                $this->form_validation->set_rules('total_job_weight_'.$sr_no_value.'','Total Job Weight (Kg) '.$sr_no_value.'' ,'required|trim|xss_clean');
                $this->form_validation->set_rules('total_waste_'.$sr_no_value.'','Total Waste (Kg) '.$sr_no_value.'' ,'required|trim|xss_clean|max_length[15]');

                // Setup
                $this->form_validation->set_rules('total_setup_meters_'.$sr_no_value,'Total Setup Meters '.$sr_no_value.'' ,'trim|xss_clean');
                $this->form_validation->set_rules('total_setup_weight_'.$sr_no_value,'Total Setup Weight '.$sr_no_value.'' ,'trim|xss_clean');
                $this->form_validation->set_rules('setup_reason_'.$sr_no_value,'Setup Reason '.$sr_no_value.'' ,'trim|xss_clean');

                // Purging

                $this->form_validation->set_rules('total_purging_weight_'.$sr_no_value,'Total Perging Weight '.$sr_no_value.'' ,'trim|xss_clean');
                $this->form_validation->set_rules('purging_reason_'.$sr_no_value,'Purging Reason '.$sr_no_value.'' ,'trim|xss_clean');


              }

              if($this->form_validation->run()==FALSE){

                $production_id=$this->input->post('production_id');

                $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);
                //echo $this->db->last_query();
                $dataa = array('process_id' =>'1');
                $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

                $data_shift_issue=array('archive'=>0,'process_id'=>1);
                $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue);

                $table='springtube_extrusion_production_master';
                $data['springtube_extrusion_production_master']=$this->springtube_extrusion_production_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'production_id',$production_id);

                $dataa=array('production_id'=>$production_id);
                $table='springtube_extrusion_production_details';
                $data['springtube_extrusion_production_details']=$this->springtube_extrusion_production_model->active_details_records($table,$dataa);

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
                $this->load->view('Home/footer');

              }else{

                $shift_issues='';

                if(!empty($this->input->post('shift_issue'))){

                  $shift_issues=implode("," , $this->input->post('shift_issue'));
                }
                // Updating Master Table--------
                $data=array(

                  'qc_incharge'=>trim(strtoupper($this->input->post('qc_incharge'))),
                  'remarks'=>trim(strtoupper($this->input->post('remarks'))),
                  'shift_issues'=>$shift_issues

                  );

                $this->common_model->update_one_active_record('springtube_extrusion_production_master',$data,'production_id',$this->input->post('production_id'),$this->session->userdata['logged_in']['company_id']);

                // Saving History of old Job to backup database---

                $dataa=array('production_id'=>$this->input->post('production_id'));
                $springtube_extrusion_production_details_result=$this->springtube_extrusion_production_model->active_details_records('springtube_extrusion_production_details',$dataa);
                foreach ($springtube_extrusion_production_details_result as $springtube_extrusion_production_details_row) {

                  $data=array(

                    'details_id'=>$springtube_extrusion_production_details_row->details_id,
                    'production_id'=>$springtube_extrusion_production_details_row->production_id,
                    'jobcard_no'=>$springtube_extrusion_production_details_row->jobcard_no,
                    'customer'=>$springtube_extrusion_production_details_row->customer,
                    'order_no'=>$springtube_extrusion_production_details_row->order_no,
                    'article_no'=>$springtube_extrusion_production_details_row->article_no,
                    'sleeve_dia'=>$springtube_extrusion_production_details_row->sleeve_dia,
                    'sleeve_length'=>$springtube_extrusion_production_details_row->sleeve_length,
                    'total_microns'=>$springtube_extrusion_production_details_row->total_microns,
                    'job_pos_no'=>$springtube_extrusion_production_details_row->job_pos_no,
                    'film_code'=>$springtube_extrusion_production_details_row->film_code,
                    'second_layer_mb'=>$springtube_extrusion_production_details_row->second_layer_mb,
                    'sixth_layer_mb'=>$springtube_extrusion_production_details_row->sixth_layer_mb,
                    'total_meters_produced'=>$springtube_extrusion_production_details_row->total_meters_produced,
                    'production_qty'=>$springtube_extrusion_production_details_row->production_qty,
                    'total_ok_meters'=>$springtube_extrusion_production_details_row->total_ok_meters,
                    'ok_qty'=>$springtube_extrusion_production_details_row->ok_qty,
                    'total_qc_hold_meters'=>$springtube_extrusion_production_details_row->total_qc_hold_meters,
                    'hold_qty'=>$springtube_extrusion_production_details_row->hold_qty,
                    'total_job_weight'=>$springtube_extrusion_production_details_row->total_job_weight,
                    'total_waste'=>$springtube_extrusion_production_details_row->total_waste,
                    'date'=>$springtube_extrusion_production_details_row->date,
                    'qc_id'=>$springtube_extrusion_production_details_row->qc_id,
                    'qc_remarks'=>$springtube_extrusion_production_details_row->qc_remarks,
                    'setup_jobcard_no'=>$springtube_extrusion_production_details_row->setup_jobcard_no,
                    'total_setup_meters'=>$springtube_extrusion_production_details_row->total_setup_meters,
                    'total_setup_weight'=>$springtube_extrusion_production_details_row->total_setup_weight,
                    'setup_reason'=>$springtube_extrusion_production_details_row->setup_reason,
                    'purging_jobcard'=>$springtube_extrusion_production_details_row->purging_jobcard,
                    'total_purging_weight'=>$springtube_extrusion_production_details_row->total_purging_weight,
                    'purging_reason'=>$springtube_extrusion_production_details_row->purging_reason,
                  );

                  $result=$this->common_model->save('production.springtube_extrusion_production_details',$data);

                  if($springtube_extrusion_production_details_row->setup_jobcard_no!=''){

                    $data=array('archive'=>'1');
                    $result=$this->common_model->update_one_active_record('production_master',$data,'mp_pos_no',$springtube_extrusion_production_details_row->setup_jobcard_no,$this->session->userdata['logged_in']['company_id']);

                  }

                  if($springtube_extrusion_production_details_row->purging_jobcard!=''){

                    $data=array('archive'=>'1');
                    $result=$this->common_model->update_one_active_record('production_master',$data,'mp_pos_no',$springtube_extrusion_production_details_row->purging_jobcard,$this->session->userdata['logged_in']['company_id']);

                  }


                }
                //Removing Old records from current table
                $result=$this->common_model->delete_one_active_record_noncompany('springtube_extrusion_production_details','production_id',$this->input->post('production_id'));

                //Adding new records to details table--------

                foreach($this->input->post('sr_no') as $sr_no => $sr_no_value){

                    $jobcard_no= $this->input->post('jobcard_no_'.$sr_no_value);

                    $production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no', $jobcard_no);

                    foreach($production_master_result as $row) {
                      $order_no=$row->sales_ord_no;
                      $article_no=$row->article_no;
                    }

                    $order_master_result=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$order_no);
                    foreach($order_master_result as $order_master_row){
                      $customer=$order_master_row->customer_no;
                    }

                    $data_order_details=array(
                    'order_no'=>$order_no,
                    'article_no'=>$article_no
                    );

                    $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
                    foreach($order_details_result as $order_details_row){
                      $bom_no=$order_details_row->spec_id;
                      $bom_version_no=$order_details_row->spec_version_no;
                    }

                    $data=array('bom_no'=>$bom_no,'bom_version_no'=>$bom_version_no);

                    $bill_of_material_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data);

                    foreach ($bill_of_material_result as $bill_of_material_row) {
                      $bom_id=$bill_of_material_row->bom_id;
                      $film_code=$bill_of_material_row->sleeve_code;

                    }
                     //SLEEVE---------------------------------

                    $film_spec_id='';
                    $film_spec_version='';

                    $film_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$film_code);

                    foreach($film_code_result as $film_code_row){
                      $film_spec_id=$film_code_row->spec_id;
                      $film_spec_version=$film_code_row->spec_version_no;
                    }

                    $specs['spec_id']=$film_spec_id;
                    $specs['spec_version_no']=$film_spec_version;

                    $specs_result=$this->sales_order_book_model->select_film_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$specs);

                    $total_microns=0;
                    if($specs_result){

                      foreach($specs_result as $specs_row){
                          $sleeve_diameter=$specs_row->SLEEVE_DIA;
                          $sleeve_length=$specs_row->SLEEVE_LENGTH;
                          $sleeve_mb_2=$specs_row->FILM_MASTER_BATCH_2;
                          $sleeve_mb_6=$specs_row->FILM_MASTER_BATCH_6;
                          $micron_1=$specs_row->FILM_GUAGE_1;
                          $micron_2=$specs_row->FILM_GUAGE_2;
                          $micron_3=$specs_row->FILM_GUAGE_3;
                          $micron_4=$specs_row->FILM_GUAGE_4;
                          $micron_5=$specs_row->FILM_GUAGE_5;
                          $micron_6=$specs_row->FILM_GUAGE_6;
                          $micron_7=$specs_row->FILM_GUAGE_7;

                      }

                      $total_microns=$micron_1+$micron_2+$micron_3+$micron_4+$micron_5+$micron_6+$micron_7;

                    }

                    $production_qty=$this->jobcard_meters_to_qty($jobcard_no,$this->input->post('total_meters_produced_'.$sr_no_value));

                     //Setup jobcard creation--------
                    $setup_jobcard_no='';
                    if(!empty($this->input->post('total_setup_weight_'.$sr_no_value)) && $this->input->post('total_setup_weight_'.$sr_no_value)>0){

                      $setup_jobcard_no=$this->create_setup_jobcard($jobcard_no,$this->input->post('total_setup_meters_'.$sr_no_value),$this->input->post('total_setup_weight_'.$sr_no_value));
                    }

                    //Purging Jobcard creation------
                    $purging_jobcard_no='';
                    if(!empty($this->input->post('total_purging_weight_'.$sr_no_value)) && $this->input->post('total_purging_weight_'.$sr_no_value)>0){

                      $purging_jobcard_no=$this->create_purging_jobcard($jobcard_no,$this->input->post('total_purging_weight_'.$sr_no_value));
                    }

                    $data=array(
                      'production_id'=>$this->input->post('production_id'),
                      'customer'=>$customer,
                      'jobcard_no'=>$jobcard_no,
                      'order_no'=>$order_no,
                      'article_no'=>$article_no,
                      'sleeve_dia'=>$sleeve_diameter,
                      'sleeve_length'=>$sleeve_length,
                      'total_microns'=>$total_microns,
                      'job_pos_no'=>$sr_no_value,
                      'film_code'=>$film_code,
                      'second_layer_mb'=>$sleeve_mb_2,
                      'sixth_layer_mb'=>$sleeve_mb_6,
                      'total_meters_produced'=>$this->input->post('total_meters_produced_'.$sr_no_value),
                      'production_qty'=>$production_qty,
                      'total_job_weight'=>$this->input->post('total_job_weight_'.$sr_no_value),
                      'total_waste'=>$this->input->post('total_waste_'.$sr_no_value),
                      'date'=>date('Y-m-d'),
                      'setup_jobcard_no'=>$setup_jobcard_no,
                      'total_setup_meters'=>$this->input->post('total_setup_meters_'.$sr_no_value),
                      'total_setup_weight'=>$this->input->post('total_setup_weight_'.$sr_no_value),
                      'setup_reason'=>$this->input->post('setup_reason_'.$sr_no_value),
                      'purging_jobcard'=>$purging_jobcard_no,
                      'total_purging_weight'=>$this->input->post('total_purging_weight_'.$sr_no_value),
                      'purging_reason'=>$this->input->post('purging_reason_'.$sr_no_value),
                    );

                    $result=$this->common_model->save('springtube_extrusion_production_details',$data);





                }//Foreach

                $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

                $data['note']='Upate Transaction Completed';

                $production_id=$this->input->post('production_id');

                $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);
                //echo $this->db->last_query();
                $dataa = array('process_id' =>'1');
                $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

                $data_shift_issue=array('archive'=>0,'process_id'=>1);
                $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue);

                $table='springtube_extrusion_production_master';
                $data['springtube_extrusion_production_master']=$this->springtube_extrusion_production_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'production_id',$production_id);

                $dataa=array('production_id'=>$production_id);
                $table='springtube_extrusion_production_details';
                $data['springtube_extrusion_production_details']=$this->springtube_extrusion_production_model->active_details_records($table,$dataa);

                $data['note']='Update Transaction Completed';
                //header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
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


  function archive_records(){
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
          //print_r( $data['formrights']);

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

              $table='springtube_extrusion_production_master';
              include('pagination_archive.php');
              $data['springtube_extrusion_production_master']=$this->springtube_extrusion_production_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
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
      $data['note']='No View rights Thanks';
      $data['page_name']='home';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      $this->load->view('Error/error-title',$data);
      $this->load->view('Home/footer');
    }

  }

  function delete($production_id){

      $data['page_name']='Production';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

              $data=array('archive'=>'1');

              $result=$this->common_model->update_one_active_record('springtube_extrusion_production_master',$data,'production_id',$production_id,$this->session->userdata['logged_in']['company_id']);

              $dataa=array('production_id'=>$production_id);
              $table='springtube_extrusion_production_details';
              $data['springtube_extrusion_production_details']=$this->springtube_extrusion_production_model->active_details_records($table,$dataa);


              foreach ($data['springtube_extrusion_production_details'] as $details_row) {

                $details_id=$details_row->details_id;
                //Archive Records from QC
                $data=array('archive'=>'1');
                $result=$this->common_model->update_one_active_record('springtube_extrusion_qc_master',$data,'details_id',$details_id,$this->session->userdata['logged_in']['company_id']);

                //Archiving Records from WIP
                $data=array('archive'=>'1');
                $result=$this->common_model->update_one_active_record('springtube_extrusion_wip_master',$data,'details_id',$details_id,$this->session->userdata['logged_in']['company_id']);
                //Archive Records from Scrap

                $data=array('archive'=>'1');
                $result=$this->common_model->update_one_active_record('springtube_extrusion_scrap_master',$data,'details_id',$details_id,$this->session->userdata['logged_in']['company_id']);

                // Archiving Setup and Purgig Jobcard

                if($details_row->setup_jobcard_no!=''){

                    $data=array('archive'=>'1');
                    $result=$this->common_model->update_one_active_record('production_master',$data,'mp_pos_no',$details_row->setup_jobcard_no,$this->session->userdata['logged_in']['company_id']);
                }

                if($details_row->purging_jobcard!=''){

                    $data=array('archive'=>'1');
                    $result=$this->common_model->update_one_active_record('production_master',$data,'mp_pos_no',$details_row->purging_jobcard,$this->session->userdata['logged_in']['company_id']);
                }


              }
              // UPDATING DETAILS RECORD------------
              $data=array('archive'=>'1');
              $result=$this->common_model->update_one_active_record('springtube_extrusion_production_details',$data,'production_id',$production_id,$this->session->userdata['logged_in']['company_id']);


              $data['springtube_extrusion_production_master']=$this->springtube_extrusion_production_model->select_one_inactive_record('springtube_extrusion_production_master',$this->session->userdata['logged_in']['company_id'],'production_id',$production_id);

              $dataa=array('production_id'=>$production_id);
              $table='springtube_extrusion_production_details';
              $data['springtube_extrusion_production_details']=$this->springtube_extrusion_production_model->inactive_details_records($table,$dataa);


              $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);
                //echo $this->db->last_query();
              $dataa = array('process_id' =>'1');
              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

              $data_shift_issue=array('archive'=>0,'process_id'=>1);
              $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue);

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


     function dearchive($production_id){

      $data['page_name']='Production';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

              $data=array('archive'=>'0');

              $result=$this->common_model->update_one_active_record('springtube_extrusion_production_master',$data,'production_id',$production_id,$this->session->userdata['logged_in']['company_id']);

              $dataa=array('production_id'=>$production_id);
              $table='springtube_extrusion_production_details';
              $data['springtube_extrusion_production_details']=$this->springtube_extrusion_production_model->inactive_details_records($table,$dataa);


              foreach ($data['springtube_extrusion_production_details'] as $details_row) {

                $details_id=$details_row->details_id;
                //Archive Records from QC
                $data=array('archive'=>'0');
                $result=$this->common_model->update_one_active_record('springtube_extrusion_qc_master',$data,'details_id',$details_id,$this->session->userdata['logged_in']['company_id']);

                //Archiving Records from WIP
                $data=array('archive'=>'0');
                $result=$this->common_model->update_one_active_record('springtube_extrusion_wip_master',$data,'details_id',$details_id,$this->session->userdata['logged_in']['company_id']);
                //Archive Records from Scrap

                $data=array('archive'=>'0');
                $result=$this->common_model->update_one_active_record('springtube_extrusion_scrap_master',$data,'details_id',$details_id,$this->session->userdata['logged_in']['company_id']);

                // Dearchiving Setup and Purging Jobcard

                if($details_row->setup_jobcard_no!=''){

                    $data=array('archive'=>'0');
                    $result=$this->common_model->update_one_active_record('production_master',$data,'mp_pos_no',$details_row->setup_jobcard_no,$this->session->userdata['logged_in']['company_id']);
                }

                if($details_row->purging_jobcard!=''){

                    $data=array('archive'=>'0');
                    $result=$this->common_model->update_one_active_record('production_master',$data,'mp_pos_no',$details_row->purging_jobcard,$this->session->userdata['logged_in']['company_id']);
                }


              }
              $data=array('archive'=>'0');
              $result=$this->common_model->update_one_active_record('springtube_extrusion_production_details',$data,'production_id',$production_id,$this->session->userdata['logged_in']['company_id']);

              $data['springtube_extrusion_production_master']=$this->springtube_extrusion_production_model->select_one_active_record('springtube_extrusion_production_master',$this->session->userdata['logged_in']['company_id'],'production_id',$production_id);

              $dataa=array('production_id'=>$production_id);
              $table='springtube_extrusion_production_details';
              $data['springtube_extrusion_production_details']=$this->springtube_extrusion_production_model->active_details_records($table,$dataa);


              $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);
                //echo $this->db->last_query();
              $dataa = array('process_id' =>'1');
              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

              $data_shift_issue=array('archive'=>0,'process_id'=>1);
                $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue);

              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

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

            $data['springtube_extrusion_production_master']=$this->springtube_extrusion_production_model->select_one_active_record('springtube_extrusion_production_master',$this->session->userdata['logged_in']['company_id'],'springtube_extrusion_production_master.production_id',$this->uri->segment(3));


            $data['springtube_extrusion_production_details']=$this->common_model->select_one_details_record_noncompany('springtube_extrusion_production_details','production_id',$this->uri->segment(3));



            $data['page_name']='Production';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
            $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

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

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){

              $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);

              $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);
             //echo $this->db->last_query();
              $dataa = array('process_id' =>'1');
              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

              $data_shift_issue=array('archive'=>0,'process_id'=>1);
              $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue);

              $data['sleeve_diameter_master']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

              $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);


              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

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
            $this->form_validation->set_rules('jobcard_no','Jobcard No.' ,'trim|xss_clean');
            $this->form_validation->set_rules('order_no','So No.' ,'trim|xss_clean');
            $this->form_validation->set_rules('article_no','Article No' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('film_code','Film code' ,'trim|xss_clean');
            $this->form_validation->set_rules('machine','Machine Name' ,'trim|xss_clean');
            $this->form_validation->set_rules('user_id','Created by.' ,'trim|xss_clean');
            //$this->form_validation->set_rules('qc_incharge','QC Incharge Name' ,'trim|xss_clean');
            //$this->form_validation->set_rules('shift_issue','Shift Issues' ,'trim|xss_clean');
            //$this->form_validation->set_rules('remarks','Remarks' ,'trim|xss_clean');

            if($this->form_validation->run()==FALSE){

              $data['user_master']=$this->common_model->select_active_drop_down('user_master',$this->session->userdata['logged_in']['company_id']);

              $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);

              $dataa = array('process_id' =>'1');
              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

              $data_shift_issue=array('archive'=>0,'process_id'=>1);
              $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue);

              $data['sleeve_diameter_master']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

              $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);


              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
              $this->load->view('Home/footer');
            }else{

              $shift_issues='';
                //print_r($this->input->post('shift_issue'));
              if(!empty($this->input->post('shift_issue'))){
                $shift_issues=implode("," , $this->input->post('shift_issue'));
              }

              $dataa=array(
                  'springtube_extrusion_production_master.machine_id'=>$this->input->post('machine'),
                  'springtube_extrusion_production_master.user_id'=>$this->input->post('user_id'),
                  'springtube_extrusion_production_master.shift'=>$this->input->post('shift')
                  //'qc_incharge'=>$this->input->post('qc_incharge'),
                  //'shift_issues'=>$shift_issues,
                  //'remarks'=>$this->input->post('remarks')
                );

              $data['springtube_extrusion_production_master']=$this->springtube_extrusion_production_model->active_record_search('springtube_extrusion_production_master',$this->session->userdata['logged_in']['company_id'],$dataa,$this->input->post('from_date'),$this->input->post('to_date'));
              $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);


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

  function search_scrap_diawise(){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){

              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

              $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);

              $data['from_date']=$this->input->get('from_date');
              $data['to_date']=$this->input->get('to_date');

              $data_search=array();
              $data['springtube_extrusion_production_master']=$this->springtube_extrusion_production_model->setup_purging_search_groupby('springtube_extrusion_production_master',$this->session->userdata['logged_in']['company_id'],$data_search,$this->input->get('from_date'),$this->input->get('to_date'));

              // echo '<pre>';
              // print_r($data['springtube_extrusion_production_master']);
              // echo '</pre>';

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form-scrap-diawise',$data);
              //$this->load->view(ucwords($this->router->fetch_class()).'/active-records-scrap-diawise',$data);
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
  function search_result_scrap_diawise(){

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
            //$this->form_validation->set_rules('order_no','Order No.' ,'trim|xss_clean');
            //$this->form_validation->set_rules('release_to_order_no','Released Order No.' ,'trim|xss_clean');
            //$this->form_validation->set_rules('jobcard_no','Jobcard No.' ,'trim|xss_clean');
            $this->form_validation->set_rules('sleeve_dia','Sleeve Dia' ,'trim|xss_clean');
            $this->form_validation->set_rules('total_microns','Microns' ,'trim|xss_clean');
            //$this->form_validation->set_rules('sleeve_length','Sleeve Length' ,'trim|xss_clean');
            //$this->form_validation->set_rules('article_no','article_no' ,'trim|xss_clean|callback_article_check');
            //$this->form_validation->set_rules('film_code','Film Code' ,'trim|xss_clean|callback_article_check');
            $this->form_validation->set_rules('film_masterbatch_two','Second Layer MB' ,'trim|xss_clean');
            //$this->form_validation->set_rules('customer','Customer' ,'trim|xss_clean|callback_customer_check');
            //$this->form_validation->set_rules('status','Status' ,'trim|xss_clean');

            if($this->form_validation->run()==FALSE){

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

              $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);

              $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

              $data_search=array();
              $data['springtube_extrusion_production_master']=$this->springtube_extrusion_production_model->setup_purging_search_groupby('springtube_extrusion_production_master',$this->session->userdata['logged_in']['company_id'],$data_search,$this->input->post('from_date'),$this->input->post('to_date'));

              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form-scrap-diawise',$data);
              $this->load->view('Home/footer');
            }else{


              $data_search=array();

              if($this->input->post('sleeve_dia')!=''){
                $sleeve_dia_arr=explode("//", $this->input->post('sleeve_dia'));
                $data_search['sleeve_dia']=$sleeve_dia_arr[0];
              }

              if($this->input->post('total_microns')!=''){
                $data_search['total_microns']=$this->input->post('total_microns');
              }
              if($this->input->post('film_masterbatch_two')!=''){
                $data_search['second_layer_mb']=$this->input->post('film_masterbatch_two');
              }


              $data['springtube_extrusion_production_master']=$this->springtube_extrusion_production_model->setup_purging_search_groupby('springtube_extrusion_production_master',$this->session->userdata['logged_in']['company_id'],$data_search,$this->input->post('from_date'),$this->input->post('to_date'));

              $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              $data['masterbatch']=$this->article_model->spec_all_active_record_search('article','12',$this->session->userdata['logged_in']['company_id']);
              $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);



                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                 $this->load->view(ucwords($this->router->fetch_class()).'/search-form-scrap-diawise',$data);
                //$this->load->view(ucwords($this->router->fetch_class()).'/active-records-wip-diawise',$data);
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




   function approval($production_id){

      $data['page_name']='Production';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
      if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->new==1){

              $data=array('final_approval_flag'=>'1',
                          'approved_by'=>$this->session->userdata['logged_in']['user_id'],
                          'approved_date'=>date('Y-m-d')
            );

              $result=$this->common_model->update_one_active_record('springtube_extrusion_production_master',$data,'production_id',$production_id,$this->session->userdata['logged_in']['company_id']);

                  //$result=$this->common_model->update_one_active_record('springtube_article_history',$data,'production_id',$id,$this->session->userdata['logged_in']['company_id']);

              $data['springtube_extrusion_production_master']=$this->springtube_extrusion_production_model->select_one_active_record('springtube_extrusion_production_master',$this->session->userdata['logged_in']['company_id'],'production_id',$production_id);

              $dataa=array('production_id'=>$production_id);
              $table='springtube_extrusion_production_details';
              $data['springtube_extrusion_production_details']=$this->springtube_extrusion_production_model->active_details_records($table,$dataa);


              $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);
                //echo $this->db->last_query();
              $dataa = array('process_id' =>'1');
              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

              $data_shift_issue=array('archive'=>0,'process_id'=>1);
              $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue);

              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $data['note']='Approval Transaction completed';
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

    function qc_inspection($production_id,$details_id){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->new==1){

              $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);
             //echo $this->db->last_query();
              $dataa = array('process_id' =>'1');
              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

              $data_shift_issue=array('archive'=>0,'process_id'=>1);
              $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue);

              $data['springtube_extrusion_reel_scrap_reasons']=$this->common_model->select_active_drop_down('springtube_extrusion_reel_scrap_reasons',$this->session->userdata['logged_in']['company_id']);

              $table='springtube_extrusion_production_master';
              $data['springtube_extrusion_production_master']=$this->springtube_extrusion_production_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'production_id',$production_id);

              $dataa=array('details_id'=>$details_id);
              $table='springtube_extrusion_production_details';
              $data['springtube_extrusion_production_details']=$this->springtube_extrusion_production_model->active_details_records($table,$dataa);

             // echo $this->db->last_query();

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/qc-form',$data);
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


  function qc_save(){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->new==1){

              $this->form_validation->set_rules('jobcard_no','Jobcard No' ,'required|trim|xss_clean|max_length[50]');
              $this->form_validation->set_rules('total_meters_produced','Total Meters Produced' ,'required|trim|xss_clean|max_length[10]');
              $this->form_validation->set_rules('total_ok_meters','Total Ok Meters' ,'required|trim|xss_clean|max_length[10]|callback_ok_meter_check');
              $this->form_validation->set_rules('total_qc_hold_meters','Total QC Hold Meters' ,'required|trim|xss_clean|max_length[10]');
              $this->form_validation->set_rules('total_job_weight','Total Job Weight (Kg) ' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('total_waste','Total Waste (Kg)' ,'required|trim|xss_clean|max_length[15]');

              if($this->input->post('total_qc_hold_meters')>0){
                $this->form_validation->set_rules('qc_hol_reasons','QC Hold Reasons' ,'required|trim|xss_clean');
              }else{
                $this->form_validation->set_rules('qc_hol_reasons','QC Hold Reasons' ,'trim|xss_clean');
              }


              if($this->form_validation->run()==FALSE){

                $production_id=$this->input->post('production_id');
                $details_id=$this->input->post('details_id');

                $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);
                //echo $this->db->last_query();
                $dataa = array('process_id' =>'1');
                $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

                $data_shift_issue=array('archive'=>0,'process_id'=>1);
                $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue);

                $data['springtube_extrusion_reel_scrap_reasons']=$this->common_model->select_active_drop_down('springtube_extrusion_reel_scrap_reasons',$this->session->userdata['logged_in']['company_id']);

                $table='springtube_extrusion_production_master';
                $data['springtube_extrusion_production_master']=$this->springtube_extrusion_production_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'production_id',$production_id);

                $data_details=array('details_id'=>$details_id);
                $table='springtube_extrusion_production_details';
                $data['springtube_extrusion_production_details']=$this->springtube_extrusion_production_model->active_details_records($table,$data_details);

                //echo $this->db->last_query();

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/qc-form',$data);
                $this->load->view('Home/footer');

              }else{



                  $customer='';
                  $order_no='';
                  $article_no='';
                  $bom_no='';
                  $bom_version_no='';
                  $film_code='';



                  $jobcard_no=$this->input->post('jobcard_no');

                  $production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$jobcard_no);

                  foreach($production_master_result as $row) {
                    $order_no=$row->sales_ord_no;
                    $article_no=$row->article_no;
                  }

                  $order_master_result=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$order_no);
                    foreach($order_master_result as $order_master_row){
                      $customer=$order_master_row->customer_no;
                    }


                  $data_order_details=array(
                  'order_no'=>$order_no,
                  'article_no'=>$article_no
                  );

                  $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
                  foreach($order_details_result as $order_details_row){
                    $bom_no=$order_details_row->spec_id;
                    $bom_version_no=$order_details_row->spec_version_no;
                  }

                  $data=array('bom_no'=>$bom_no,'bom_version_no'=>$bom_version_no);

                  $bill_of_material_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data);

                  foreach ($bill_of_material_result as $bill_of_material_row) {
                    $bom_id=$bill_of_material_row->bom_id;
                    $film_code=$bill_of_material_row->sleeve_code;

                  }
                  //SLEEVE---------------------------------

                  $film_spec_id='';
                  $film_spec_version='';

                  $film_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$film_code);

                  foreach($film_code_result as $film_code_row){
                      $film_spec_id=$film_code_row->spec_id;
                      $film_spec_version=$film_code_row->spec_version_no;
                  }

                  $specs['spec_id']=$film_spec_id;
                  $specs['spec_version_no']=$film_spec_version;

                  $specs_result=$this->sales_order_book_model->select_film_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$specs);

                    $total_microns=0;
                    if($specs_result){

                      foreach($specs_result as $specs_row){
                          $sleeve_diameter=$specs_row->SLEEVE_DIA;
                          $sleeve_length=$specs_row->SLEEVE_LENGTH;
                          $sleeve_mb_2=$specs_row->FILM_MASTER_BATCH_2;
                          $sleeve_mb_6=$specs_row->FILM_MASTER_BATCH_6;
                          $micron_1=$specs_row->FILM_GUAGE_1;
                          $micron_2=$specs_row->FILM_GUAGE_2;
                          $micron_3=$specs_row->FILM_GUAGE_3;
                          $micron_4=$specs_row->FILM_GUAGE_4;
                          $micron_5=$specs_row->FILM_GUAGE_5;
                          $micron_6=$specs_row->FILM_GUAGE_6;
                          $micron_7=$specs_row->FILM_GUAGE_7;

                      }

                      $total_microns=$micron_1+$micron_2+$micron_3+$micron_4+$micron_5+$micron_6+$micron_7;

                    }

                    $ok_qty=$this->jobcard_meters_to_qty($jobcard_no,$this->input->post('total_ok_meters'));
                    $data=array(
                      'wip_date'=>date('Y-m-d'),
                      'details_id'=>$this->input->post('details_id'),
                      'jobcard_no'=>$jobcard_no,
                      'customer'=>$customer,
                      'order_no'=>$order_no,
                      'article_no'=>$article_no,
                      'sleeve_dia'=>$sleeve_diameter,
                      'sleeve_length'=>$sleeve_length,
                      'total_microns'=>$total_microns,
                      'second_layer_mb'=>$sleeve_mb_2,
                      'sixth_layer_mb'=>$sleeve_mb_6,
                      'film_code'=>$film_code,
                      'total_ok_meters'=>$this->input->post('total_ok_meters'),
                      'ok_qty'=>$ok_qty,
                      'created_date'=>date('Y-m-d h:i:s'),
                      'company_id'=>$this->session->userdata['logged_in']['company_id'],
                      'from_process'=>'1',
                      'user_id'=>$this->session->userdata['logged_in']['user_id']
                    );

					$result=$this->common_model->save('springtube_extrusion_wip_master',$data);

					$hold_qty=$this->jobcard_meters_to_qty($jobcard_no,$this->input->post('total_qc_hold_meters'));

					//if($result && $this->input->post('total_qc_hold_meters')!='0' ){

          if($result && $this->input->post('total_qc_hold_meters')>0){

            $data_qc=array(
            'qc_date'=>date('Y-m-d'),
            'details_id'=>$this->input->post('details_id'),
            'jobcard_no'=>$jobcard_no,
            'customer'=>$customer,
            'order_no'=>$order_no,
            'article_no'=>$article_no,
            'sleeve_dia'=>$sleeve_diameter,
            'sleeve_length'=>$sleeve_length,
            'total_microns'=>$total_microns,
            'second_layer_mb'=>$sleeve_mb_2,
            'sixth_layer_mb'=>$sleeve_mb_6,
            'film_code'=>$film_code,
            'total_qc_hold_meters'=>$this->input->post('total_qc_hold_meters'),
            'qc_hold_reasons'=>$this->input->post('qc_hold_reasons'),
            'hold_qty' =>$hold_qty,
            'created_date'=>date('Y-m-d H:i:s'),
            'company_id'=>$this->session->userdata['logged_in']['company_id'],
            'from_process'=>'1',
            'user_id'=>$this->session->userdata['logged_in']['user_id']
            );

            $result=$this->common_model->save('springtube_extrusion_qc_master',$data_qc);
    }

            $data_details=array(
              'total_ok_meters'=>$this->input->post('total_ok_meters'),
              'ok_qty'=>$ok_qty,
              'total_qc_hold_meters'=>$this->input->post('total_qc_hold_meters'),
              'hold_qty'=>$hold_qty,
              'qc_hold_reasons'=>$this->input->post('qc_hold_reasons'),
              'qc_id'=>$this->session->userdata['logged_in']['user_id'],
              'qc_check'=>'1',
              'qc_remarks'=>$this->input->post('qc_remarks'),
              'qc_date'=>date('Y-m-d')
            );

            $result=$this->common_model->update_one_active_record_noncompany('springtube_extrusion_production_details',$data_details,'details_id',$this->input->post('details_id'));

                  // $data=array(
                  //           'final_approval_flag'=>'1',
                  //           'approved_by'=>$this->session->userdata['logged_in']['user_id'],
                  //           'approved_date'=>date('Y-m-d')
                  //         );

                  // $result=$this->common_model->update_one_active_record('springtube_extrusion_production_master',$data,'production_id',$this->input->post('production_id'));


                  $data['note']='Qc Save Transaction Completed';

                  $production_id=$this->input->post('production_id');
                  $details_id=$this->input->post('details_id');

                  $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);
                //echo $this->db->last_query();
                  $dataa = array('process_id' =>'1');
                  $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

                  $data_shift_issue=array('archive'=>0,'process_id'=>1);
                  $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue);

                  $data['springtube_extrusion_reel_scrap_reasons']=$this->common_model->select_active_drop_down('springtube_extrusion_reel_scrap_reasons',$this->session->userdata['logged_in']['company_id']);

                  $table='springtube_extrusion_production_master';
                  $data['springtube_extrusion_production_master']=$this->springtube_extrusion_production_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'production_id',$production_id);

                  $dataa=array('details_id'=>$details_id);
                  $table='springtube_extrusion_production_details';
                  $data['springtube_extrusion_production_details']=$this->springtube_extrusion_production_model->active_details_records($table,$dataa);

                  $data['page_name']='Production';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

                header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/qc-form',$data);
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

    function modify_qc_inspection($production_id,$details_id){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->new==1){

              $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);
             //echo $this->db->last_query();
              $dataa = array('process_id' =>'1');
              $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

              $data_shift_issue=array('archive'=>0,'process_id'=>1);
              $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue);

              $data['springtube_extrusion_reel_scrap_reasons']=$this->common_model->select_active_drop_down('springtube_extrusion_reel_scrap_reasons',$this->session->userdata['logged_in']['company_id']);

              $table='springtube_extrusion_production_master';
              $data['springtube_extrusion_production_master']=$this->springtube_extrusion_production_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'production_id',$production_id);

              $dataa=array('details_id'=>$details_id);
              $table='springtube_extrusion_production_details';
              $data['springtube_extrusion_production_details']=$this->springtube_extrusion_production_model->active_details_records($table,$dataa);

             // echo $this->db->last_query();

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/qc-modify-form',$data);
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
  function update_qc_save(){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->new==1){

              $this->form_validation->set_rules('jobcard_no','Jobcard No' ,'required|trim|xss_clean|max_length[50]');
              $this->form_validation->set_rules('total_meters_produced','Total Meters Produced' ,'required|trim|xss_clean|max_length[10]');
              $this->form_validation->set_rules('total_ok_meters','Total Ok Meters' ,'required|trim|xss_clean|max_length[10]|callback_ok_meter_check');
              $this->form_validation->set_rules('total_qc_hold_meters','Total QC Hold Meters' ,'required|trim|xss_clean|max_length[10]');
              $this->form_validation->set_rules('total_job_weight','Total Job Weight (Kg) ' ,'required|trim|xss_clean');
              $this->form_validation->set_rules('total_waste','Total Waste (Kg)' ,'required|trim|xss_clean|max_length[15]');


              if($this->form_validation->run()==FALSE){

                $production_id=$this->input->post('production_id');
                $details_id=$this->input->post('details_id');

                $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);
                //echo $this->db->last_query();
                $dataa = array('process_id' =>'1');
                $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

                $data_shift_issue=array('archive'=>0,'process_id'=>1);
                $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue);

                $data['springtube_extrusion_reel_scrap_reasons']=$this->common_model->select_active_drop_down('springtube_extrusion_reel_scrap_reasons',$this->session->userdata['logged_in']['company_id']);


                $table='springtube_extrusion_production_master';
                $data['springtube_extrusion_production_master']=$this->springtube_extrusion_production_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'production_id',$production_id);

                $dataa=array('details_id'=>$details_id);
                $table='springtube_extrusion_production_details';
                $data['springtube_extrusion_production_details']=$this->springtube_extrusion_production_model->active_details_records($table,$dataa);

               // echo $this->db->last_query();

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/qc-modify-form',$data);
                $this->load->view('Home/footer');

              }else{


                  $customer='';
                  $order_no='';
                  $article_no='';
                  $bom_no='';
                  $bom_version_no='';
                  $film_code='';

                  $jobcard_no=$this->input->post('jobcard_no');

                  $production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$jobcard_no);

                  foreach($production_master_result as $row) {
                    $order_no=$row->sales_ord_no;
                    $article_no=$row->article_no;
                  }

                  $order_master_result=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$order_no);
                    foreach($order_master_result as $order_master_row){
                      $customer=$order_master_row->customer_no;
                    }


                  $data_order_details=array(
                  'order_no'=>$order_no,
                  'article_no'=>$article_no
                  );

                  $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
                  foreach($order_details_result as $order_details_row){
                    $bom_no=$order_details_row->spec_id;
                    $bom_version_no=$order_details_row->spec_version_no;
                  }

                  $data=array('bom_no'=>$bom_no,'bom_version_no'=>$bom_version_no);

                  $bill_of_material_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data);

                  foreach ($bill_of_material_result as $bill_of_material_row) {
                    $bom_id=$bill_of_material_row->bom_id;
                    $film_code=$bill_of_material_row->sleeve_code;

                  }
                  //SLEEVE---------------------------------

                  $film_spec_id='';
                  $film_spec_version='';

                  $film_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$film_code);

                  foreach($film_code_result as $film_code_row){
                      $film_spec_id=$film_code_row->spec_id;
                      $film_spec_version=$film_code_row->spec_version_no;
                  }

                  $specs['spec_id']=$film_spec_id;
                  $specs['spec_version_no']=$film_spec_version;

                  $specs_result=$this->sales_order_book_model->select_film_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$specs);

                    $total_microns=0;
                    if($specs_result){

                      foreach($specs_result as $specs_row){
                          $sleeve_diameter=$specs_row->SLEEVE_DIA;
                          $sleeve_length=$specs_row->SLEEVE_LENGTH;
                          $sleeve_mb_2=$specs_row->FILM_MASTER_BATCH_2;
                          $sleeve_mb_6=$specs_row->FILM_MASTER_BATCH_6;
                          $micron_1=$specs_row->FILM_GUAGE_1;
                          $micron_2=$specs_row->FILM_GUAGE_2;
                          $micron_3=$specs_row->FILM_GUAGE_3;
                          $micron_4=$specs_row->FILM_GUAGE_4;
                          $micron_5=$specs_row->FILM_GUAGE_5;
                          $micron_6=$specs_row->FILM_GUAGE_6;
                          $micron_7=$specs_row->FILM_GUAGE_7;

                      }

                      $total_microns=$micron_1+$micron_2+$micron_3+$micron_4+$micron_5+$micron_6+$micron_7;

                    }

                    // Removing Old Data from WIP---------
                    $data_wip=array('archive'=>1);
                    $result=$this->common_model->update_one_active_record('springtube_extrusion_wip_master',$data_wip,'details_id',$this->input->post('details_id'),$this->session->userdata['logged_in']['company_id']);

                    // Removing Old Data from QC----------
                    $data_qc=array('archive'=>1);
                    $result=$this->common_model->update_one_active_record('springtube_extrusion_qc_master',$data_qc,'details_id',$this->input->post('details_id'),$this->session->userdata['logged_in']['company_id']);

                    // Inserting New data to WIP---------
                    $ok_qty=$this->jobcard_meters_to_qty($jobcard_no,$this->input->post('total_ok_meters'));

                    $data=array(
                      'wip_date'=>date('Y-m-d'),
                      'details_id'=>$this->input->post('details_id'),
                      'jobcard_no'=>$jobcard_no,
                      'customer'=>$customer,
                      'order_no'=>$order_no,
                      'article_no'=>$article_no,
                      'sleeve_dia'=>$sleeve_diameter,
                      'sleeve_length'=>$sleeve_length,
                      'total_microns'=>$total_microns,
                      'second_layer_mb'=>$sleeve_mb_2,
                      'sixth_layer_mb'=>$sleeve_mb_6,
                      'film_code'=>$film_code,
                      'total_ok_meters'=>$this->input->post('total_ok_meters'),
                      'ok_qty'=>$ok_qty,
                      'created_date'=>date('Y-m-d h:i:s'),
                      'company_id'=>$this->session->userdata['logged_in']['company_id'],
                      'from_process'=>'1',
                      'user_id'=>$this->session->userdata['logged_in']['user_id']
                    );

                    $result=$this->common_model->save('springtube_extrusion_wip_master',$data);

                     $hold_qty=$this->jobcard_meters_to_qty($jobcard_no,$this->input->post('total_qc_hold_meters'));

                    if($result && !empty($this->input->post('total_qc_hold_meters')) && $this->input->post('total_qc_hold_meters')>0){

                        $data=array(
                        'qc_date'=>date('Y-m-d'),
                        'details_id'=>$this->input->post('details_id'),
                        'jobcard_no'=>$jobcard_no,
                        'customer'=>$customer,
                        'order_no'=>$order_no,
                        'article_no'=>$article_no,
                        'sleeve_dia'=>$sleeve_diameter,
                        'sleeve_length'=>$sleeve_length,
                        'total_microns'=>$total_microns,
                        'second_layer_mb'=>$sleeve_mb_2,
                        'sixth_layer_mb'=>$sleeve_mb_6,
                        'film_code'=>$film_code,
                        'total_qc_hold_meters'=>$this->input->post('total_qc_hold_meters'),
                        'hold_qty' =>$hold_qty,
                        'qc_hold_reasons'=>$this->input->post('qc_hold_reasons'),
                        'created_date'=>date('Y-m-d H:i:s'),
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'from_process'=>'1',
                        'user_id'=>$this->session->userdata['logged_in']['user_id']
                        );

                        $result=$this->common_model->save('springtube_extrusion_qc_master',$data);
                    }

                    $data=array(
                      'total_ok_meters'=>$this->input->post('total_ok_meters'),
                      'ok_qty'=>$ok_qty,
                      'total_qc_hold_meters'=>$this->input->post('total_qc_hold_meters'),
                      'hold_qty'=>$hold_qty,
                      'qc_id'=>$this->session->userdata['logged_in']['user_id'],
                      'qc_check'=>'1',
                       'qc_hold_reasons'=>$this->input->post('qc_hold_reasons'),
                      'qc_remarks'=>$this->input->post('qc_remarks'),
                      'qc_date'=>date('Y-m-d')
                    );

                  $result=$this->common_model->update_one_active_record_noncompany('springtube_extrusion_production_details',$data,'details_id',$this->input->post('details_id'));

                  // $data=array(
                  //           'final_approval_flag'=>'1',
                  //           'approved_by'=>$this->session->userdata['logged_in']['user_id'],
                  //           'approved_date'=>date('Y-m-d')
                  //         );

                  // $result=$this->common_model->update_one_active_record('springtube_extrusion_production_master',$data,'production_id',$this->input->post('production_id'));


                  $data['note']='Qc Update Transaction Completed';

                  $production_id=$this->input->post('production_id');
                  $details_id=$this->input->post('details_id');

                  $data['springtube_process_master']=$this->common_model->select_active_drop_down('springtube_process_master',$this->session->userdata['logged_in']['company_id']);
                //echo $this->db->last_query();
                  $dataa = array('process_id' =>'1');
                  $data['springtube_machine_master']=$this->common_model->select_active_records_where('springtube_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);

                  $data_shift_issue=array('archive'=>0,'process_id'=>1);
                  $data['springtube_shift_issues_master']=$this->common_model->select_active_records_where('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],$data_shift_issue);

                  $data['springtube_extrusion_reel_scrap_reasons']=$this->common_model->select_active_drop_down('springtube_extrusion_reel_scrap_reasons',$this->session->userdata['logged_in']['company_id']);

                  $table='springtube_extrusion_production_master';
                  $data['springtube_extrusion_production_master']=$this->springtube_extrusion_production_model->select_one_active_record($table,$this->session->userdata['logged_in']['company_id'],'production_id',$production_id);

                  $dataa=array('details_id'=>$details_id);
                  $table='springtube_extrusion_production_details';
                  $data['springtube_extrusion_production_details']=$this->springtube_extrusion_production_model->active_details_records($table,$dataa);

                  $data['page_name']='Production';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

                  header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/qc-modify-form',$data);
                $this->load->view('Home/footer');
              }

             // echo $this->db->last_query();

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/qc-modify-form',$data);
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

    public function jobcard_meters_check($total_meters_produced,$jobcard_no){

          if($jobcard_no!='' && $total_meters_produced!=''){

            // echo $jobcard_no.'->'.$total_meters_produced;
            // echo '</br>';

            $total_meters_planned=0;
            $total_meters_exist=0;

            $data['production_master']=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no', $jobcard_no);

            $dataa=array('jobcard_no'=>$jobcard_no);
            $data['springtube_extrusion_production_details']=$this->springtube_extrusion_production_model->active_details_records('springtube_extrusion_production_details',$dataa);

            foreach ($data['springtube_extrusion_production_details'] as $details_row) {
              $total_meters_exist+=$details_row->total_meters_produced;
            }

            foreach ($data['production_master'] as $row) {

              //$total_meters_planned= $row->no_of_reels*$row->reel_length;
              $total_meters_planned= $row->total_meters;
              //echo '<br/>';
              //echo $total_meters_exist;
             // echo $abc=$total_meters_produced+$total_meters_exist;

              if ($total_meters_planned >= ($total_meters_produced+$total_meters_exist)){
                return TRUE;
              }else{
                $this->form_validation->set_message('jobcard_meters_check','The {field} should not be more than Jobcard Quantity (Meters).');
              return FALSE;

              }
            }
          }



    }

    function jobcard_meters_to_qty($jobcard_no,$total_meters){
      //(NO Of reels * reel Length * 1000 / Sleeve Length For Extrusion) * Ups

      //$reel_length=$this->config->item('springtube_reel_length');
      //$reel_length=0;
      $expected_tubes=0;
      $jobcard_qty=0;
      $order_no='';
      $article_no='';
      $final_length_in_mm=0;
      $body_making_type='';


      if($jobcard_no!='' && $total_meters!='' && $total_meters!='0'){

        $customer='';
        $order_no='';
        $article_no='';
        $bom_no='';
        $bom_version_no='';
        $film_code='';
        $ad_id='';
        $version_no='';


        $production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$jobcard_no);

        foreach($production_master_result as $row) {
          $order_no=$row->sales_ord_no;
          $article_no=$row->article_no;
        }

        $order_master_result=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$order_no);
          foreach($order_master_result as $order_master_row){
            $customer=$order_master_row->customer_no;
          }


        $data_order_details=array(
        'order_no'=>$order_no,
        'article_no'=>$article_no
        );

        $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
        foreach($order_details_result as $order_details_row){
          $bom_no=$order_details_row->spec_id;
          $bom_version_no=$order_details_row->spec_version_no;
          $ad_id=$order_details_row->ad_id;
          $version_no=$order_details_row->version_no;
        }

        $data=array('bom_no'=>$bom_no,'bom_version_no'=>$bom_version_no);

        $bill_of_material_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data);

        foreach ($bill_of_material_result as $bill_of_material_row) {
          $bom_id=$bill_of_material_row->bom_id;
          $film_code=$bill_of_material_row->sleeve_code;

        }
        //SLEEVE---------------------------------

        $film_spec_id='';
        $film_spec_version='';

        $film_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$film_code);

        foreach($film_code_result as $film_code_row){
            $film_spec_id=$film_code_row->spec_id;
            $film_spec_version=$film_code_row->spec_version_no;
        }

        $specs['spec_id']=$film_spec_id;
        $specs['spec_version_no']=$film_spec_version;

        $specs_result=$this->sales_order_book_model->select_film_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$specs);

        $total_microns=0;

        if($specs_result){

          foreach($specs_result as $specs_row){
              $sleeve_diameter=$specs_row->SLEEVE_DIA;
              $sleeve_length=$specs_row->SLEEVE_LENGTH;
              $sleeve_mb_2=$specs_row->FILM_MASTER_BATCH_2;
              $sleeve_mb_6=$specs_row->FILM_MASTER_BATCH_6;
              $micron_1=$specs_row->FILM_GUAGE_1;
              $micron_2=$specs_row->FILM_GUAGE_2;
              $micron_3=$specs_row->FILM_GUAGE_3;
              $micron_4=$specs_row->FILM_GUAGE_4;
              $micron_5=$specs_row->FILM_GUAGE_5;
              $micron_6=$specs_row->FILM_GUAGE_6;
              $micron_7=$specs_row->FILM_GUAGE_7;

          }

          $total_microns=$micron_1+$micron_2+$micron_3+$micron_4+$micron_5+$micron_6+$micron_7;

        }

        //Artwork Deatils-------------------------
        $data=array('ad_id'=>$ad_id,
              'version_no'=>$version_no
                );
        $springtube_artwork_result=$this->artwork_springtube_model->active_record_search_new('springtube_artwork_devel_master',$data,'','','',$this->session->userdata['logged_in']['company_id']);

        foreach ($springtube_artwork_result as $springtube_artwork_row) {
          $body_making_type=$springtube_artwork_row->body_making_type;
        }


        $sleeve_dia_id='';
        $result_sleeve_diameter_master=$this->common_model->select_one_active_record('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id'],'sleeve_diameter',$sleeve_diameter);
        //print_r($result_sleeve_diameter_master);
        foreach ($result_sleeve_diameter_master as $sleeve_diameter_master_row ) {
          $sleeve_dia_id=$sleeve_diameter_master_row->sleeve_id;

        }
        // $data=array('sleeve_dia_id'=>$sleeve_dia_id,
        //                 'seam_type'=>$body_making_type);

        $data=array('sleeve_dia_id'=>$sleeve_dia_id);

        $result_spring_width_calculation=$this->common_model->select_active_records_where('spring_width_calculation',$this->session->userdata['logged_in']['company_id'],$data);

        $reel_width=0;
        $ups=0;
        $sleeve_length_extrusion=$sleeve_length+2.5;

        foreach ($result_spring_width_calculation as $spring_width_calculation_row) {
          $ups=$spring_width_calculation_row->ups;
          $reel_width=($spring_width_calculation_row->slit_width)+($spring_width_calculation_row->ups*$spring_width_calculation_row->distance_each_side);
        }

        $expected_tubes=($total_meters*$ups*1000)/$sleeve_length_extrusion;
                //$final_length_in_mm=($sleeve_length_extrusion*$jobcard_qty/1000)/$ups;
                //$no_of_reels_planned=round(($final_length_in_mm/$reel_length),2);
                //$no_of_reels_planned= round($no_of_reels_planned,2);
        return round($expected_tubes,0);



    }else{
      return '0';
    }

  }


   public function shift_check(){

      $shift='';
      $production_time=date('H:i:s');
      $production_date=date('Y-m-d');

      if($production_time >'08:00:00' AND $production_time <'15:59:59' ){
        $shift='1';
      }else if($production_time >'16:00:00' AND $production_time <'23:59:59'){
        $shift='2';
      }else if($production_time >'00:00:00' AND $production_time <'07:59:59'){
        $shift='3';
        $production_date=date('Y-m-d',strtotime("-1 days"));

      }else{
        $shift='';
      }

      $shift_data=array('production_date'=>$production_date,'shift'=>$shift);
      $result=$this->common_model->select_active_records_where('springtube_extrusion_production_master',$this->session->userdata['logged_in']['company_id'],$shift_data);

      if($result){

        $this->form_validation->set_message('shift_check', 'Entry on this {field} and shift is already exist');
        return FALSE;

      }



    }

    public function shift_check_new($production_date){

      $shift=$this->input->post('shift');

      $date1=date_create($production_date);
      $date2=date_create(date('Y-m-d'));
      $diff=date_diff($date1,$date2);
      $a=$diff->format("%R%a");


      $shift_data=array('production_date'=>$production_date,'shift'=>$shift);
      $result=$this->common_model->select_active_records_where('springtube_extrusion_production_master',$this->session->userdata['logged_in']['company_id'],$shift_data);

      if(count($result)==0 && $a>=0){
        return TRUE;

      }else{
        $this->form_validation->set_message('shift_check_new', 'Entry on this {field} and shift is not allowed');
        return FALSE;
      }



    }

    public function jobcard_close_check($jobcard_no){

      // $data=array('mp_pos_no'=>$jobcard_no,'archive'=>'0','jobcard_status'=>0);
      // $result=$this->common_model->select_active_records_where('production_master',$this->session->userdata['logged_in']['company_id'],$data);

      $query=$this->db->query("SELECT * FROM production_master P INNER JOIN order_master O ON P.sales_ord_no=O.order_no WHERE P.archive=0 AND P.company_id = '000020' AND P.jobcard_type =1 AND P.jobcard_status=0 AND  P.mp_pos_no = '".$jobcard_no."' AND O.order_closed<>1 AND O.trans_closed<>1 AND O.cancel_flag<>1");
      //echo $this->db->last_query();

      $result=$query->result();
      //print_r($result);

      if($result==TRUE){
        return TRUE;
      }else{

        $this->form_validation->set_message('jobcard_close_check', '{field} is already closed, Entry not allowed.');
        return FALSE;

      }



    }

    function consolidated_search(){

    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){


              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/consolidated-search-form',$data);
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

  function consolidated_search_result(){

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
            $this->form_validation->set_rules('adr_company_id','Company Name' ,'trim|xss_clean|max_length[150]|strtoupper|callback_customer_check');
            //$this->form_validation->set_rules('jobcard_no','Jobcard No.' ,'trim|xss_clean');
            $this->form_validation->set_rules('order_no','So No.' ,'trim|xss_clean');
            $this->form_validation->set_rules('article_no','Article No' ,'trim|xss_clean|callback_article_check');
            //$this->form_validation->set_rules('film_code','Film code' ,'trim|xss_clean');
            //$this->form_validation->set_rules('machine','Machine Name' ,'trim|xss_clean');
            //$this->form_validation->set_rules('user_id','Created by.' ,'trim|xss_clean');
            //$this->form_validation->set_rules('qc_incharge','QC Incharge Name' ,'trim|xss_clean');
            //$this->form_validation->set_rules('shift_issue','Shift Issues' ,'trim|xss_clean');
            //$this->form_validation->set_rules('remarks','Remarks' ,'trim|xss_clean');

            if($this->form_validation->run()==FALSE){

              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/consolidated-search-form',$data);
              $this->load->view('Home/footer');
            }else{

                $search=array();
                if(!empty($this->input->post('adr_company_id'))){
                     $arr=explode('//',$this->input->post('adr_company_id'));
                     $search['springtube_extrusion_production_details.customer']=$arr[1];
                }
                if(!empty($this->input->post('order_no'))){
                     $search['springtube_extrusion_production_details.order_no']=$this->input->post('order_no');
                }
                if(!empty($this->input->post('article_no'))){

                    $arr=explode("//",$this->input->post('article_no'));
                    $article_no=$arr[1];

                    $search['springtube_extrusion_production_details.article_no']=$article_no;

                }
                $data['springtube_extrusion_production_master']=$this->springtube_extrusion_production_model->active_record_search_consolidated('springtube_extrusion_production_master',$this->session->userdata['logged_in']['company_id'],$search,$this->input->post('from_date'),$this->input->post('to_date'));

                $data['page_name']='Production';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());


                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                //$this->load->view(ucwords($this->router->fetch_class()).'/consolidated-search-form',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/consolidated-search-result',$data);
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

  public function customer_check($str){
    if(!empty($str)){
    $customer_code=explode('//',$str);
    if(!empty($customer_code[1])){
    $data['customer']=$this->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'name1',$customer_code[0]);
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

  function ok_meter_check($str){

    if(!empty($str)){
      $total_produced=$this->input->post('total_meters_produced');
      $total_ok=$this->input->post('total_ok_meters');
      if($total_ok>$total_produced){
        $this->form_validation->set_message('ok_meter_check', 'Total Ok Meters should not greater than total produced');
        return FALSE;
      }else{

        return TRUE;
      }
    }
    else{
      $this->form_validation->set_message('ok_meter_check', 'The {field} field is incorrect');
        return FALSE;
    }


  }

  function create_setup_jobcard($jobcard_no,$total_setup_meters,$total_setup_weight){
    $setup_jobcard_no='';
    $form_id='103244'; //SETUP SJOB----
    $jobcard_type='4';// FOR SETUP
    $reel_length=$this->config->item('springtube_reel_length');


    // Jobcard details---------------------
    $customer='';
    $order_no='';
    $article_no='';
    $order_qty=0;
    $ord_pos_no='';
    $bom_no='';
    $bom_version_no='';
    $film_code='';
    $ad_id='';
    $version_no='';


    $production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$jobcard_no);

    foreach($production_master_result as $row) {
      $order_no=$row->sales_ord_no;
      $article_no=$row->article_no;
    }

    $order_master_result=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$order_no);
    foreach($order_master_result as $order_master_row){
      $customer=$order_master_row->customer_no;
    }

    $data_order_details=array(
    'order_no'=>$order_no,
    'article_no'=>$article_no
    );

    $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
    foreach($order_details_result as $order_details_row){
      $ord_pos_no=$order_details_row->ord_pos_no;
      $order_qty=$order_details_row->total_order_quantity;
      $bom_no=$order_details_row->spec_id;
      $bom_version_no=$order_details_row->spec_version_no;
      $ad_id=$order_details_row->ad_id;
      $version_no=$order_details_row->version_no;
    }

    // $data=array('bom_no'=>$bom_no,'bom_version_no'=>$bom_version_no);

    // $bill_of_material_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data);

    // foreach ($bill_of_material_result as $bill_of_material_row) {
    //   $bom_id=$bill_of_material_row->bom_id;
    //   $film_code=$bill_of_material_row->sleeve_code;

    // }
    //SETUP JOBCARD CREATION---------------------------------

    $no_of_reels=round($total_setup_meters/$reel_length,1);
    $job_card_length_in_meters=$total_setup_meters;
    $jobcard_qty=$this->jobcard_meters_to_qty($jobcard_no,$total_setup_meters);
    $jobcard_qty_erp=$this->common_model->save_number($jobcard_qty,$this->session->userdata['logged_in']['company_id']);

    $data['auto']=$this->common_model->select_one_active_record_nonlanguage_without_archive('autogeneration_format_master',$this->session->userdata['logged_in']['company_id'],'form_id',$form_id);
    $no="";
    foreach ($data['auto'] as $auto_row) {

      $data['account_periods']=$this->common_model->select_one_active_record_nonlanguage_without_archive('account_periods_master',$this->session->userdata['logged_in']['company_id'],'finyear_close_opt','0');
      foreach($data['account_periods'] as $account_periods_row){
        $start=date('y', strtotime($account_periods_row->fin_year_start));
        $end=date('y', strtotime($account_periods_row->fin_year_end));
      }
      $no=str_pad($auto_row->curr_val,4,"0",STR_PAD_LEFT);
      $setup_jobcard_no=$auto_row->textcode.$auto_row->seperator.$start.$auto_row->seperator.$end.$auto_row->seperator.$no;
      $next_jobcard_no=$auto_row->curr_val+1;
    }

    $data=array('curr_val'=>$next_jobcard_no);

    $this->common_model->update_one_active_record('autogeneration_format_master',$data,'form_id',$form_id,$this->session->userdata['logged_in']['company_id']);

    $data['max']=$this->common_model->select_max_pkey_numeric('production_master','manu_order_no',$this->session->userdata['logged_in']['company_id']);
    foreach($data['max'] as $max_value){
    $manu_order_no=$max_value->manu_order_no+1;
    }

    $data=array('manu_order_no'=>$manu_order_no,
      'company_id'=>$this->session->userdata['logged_in']['company_id'],
      'mp_pos_no'=>$setup_jobcard_no,
      'article_no'=>$article_no,
      'mp_qty'=>$order_qty,
      'actual_qty_manufactured'=>$jobcard_qty_erp,
      'manu_plan_date'=>date('Y-m-d'),
      'employee_id'=>$this->session->userdata['logged_in']['user_id'],
      'sales_ord_no'=>$order_no,
      'ord_pos_no'=>$ord_pos_no,
      'jobcard_type'=>$jobcard_type,
      'no_of_reels'=>$no_of_reels,
      'reel_length'=>$reel_length,
      'total_meters'=>$job_card_length_in_meters,
      'ref_jobcard_no'=>$jobcard_no
    );

    $result=$this->common_model->save('production_master',$data);


    $data=array('bom_no'=>$bom_no,'bom_version_no'=>$bom_version_no);

    $bill_of_material_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data);

      // foreach ($bill_of_material_result as $bill_of_material_row) {
      //   $bom_id=$bill_of_material_row->bom_id;
      //   $film_code=$bill_of_material_row->sleeve_code;

      // }

      foreach($bill_of_material_result as $bill_of_material_row){

        $film_code=$bill_of_material_row->sleeve_code;
        $shoulder_code=$bill_of_material_row->shoulder_code;
        $label_code=$bill_of_material_row->label_code;
        $cap_code=$bill_of_material_row->cap_code;
        $for_export=$bill_of_material_row->for_export;


        $data['film_specs']=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$film_code);
          foreach($data['film_specs'] as $film_specs){

            $film_specss['spec_id']=$film_specs->spec_id;
            $film_specss['spec_version_no']=$film_specs->spec_version_no;

            $film_specs_master_result=$this->common_model->select_active_records_where('specification_sheet',$this->session->userdata['logged_in']['company_id'],$film_specss);
            if($film_specs_master_result){
              foreach($film_specs_master_result as $film_specs_master_result_row){
                $layer_arr=explode("|", $film_specs_master_result_row->dyn_qty_present);
                $layer_no=substr($layer_arr[1],0,1);

              }
            }

            $film_specs_result=$this->sales_order_book_model->select_film_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$film_specss);


            foreach($film_specs_result as $specs_row){

              $dia=$specs_row->SLEEVE_DIA;
              $length=$specs_row->SLEEVE_LENGTH;
              $total_film_guage=$specs_row->FILM_GUAGE_1+$specs_row->FILM_GUAGE_2+$specs_row->FILM_GUAGE_3+$specs_row->FILM_GUAGE_4+$specs_row->FILM_GUAGE_5+$specs_row->FILM_GUAGE_6+$specs_row->FILM_GUAGE_7;

              $data['sleeve_diameter_master']=$this->common_model->select_one_active_record('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id'],'sleeve_diameter',$dia);
              foreach($data['sleeve_diameter_master'] as $sleeve_dia_row){
                $sleeve_dia_id=$sleeve_dia_row->sleeve_id;
              }

              //$data=array('sleeve_dia_id'=>$sleeve_dia_id,'seam_type'=>$body_making_type);
              $data=array('sleeve_dia_id'=>$sleeve_dia_id);
              $result_spring_width_calculation=$this->common_model->active_record_search('spring_width_calculation',$data,$this->session->userdata['logged_in']['company_id']);

              foreach($result_spring_width_calculation as $spring_width_calculation_row){

                $film_width=$spring_width_calculation_row->slit_width+($spring_width_calculation_row->distance_each_side*$spring_width_calculation_row->ups);

                $qty_to_be_printed=$jobcard_qty/$spring_width_calculation_row->ups;

                $film_length=$qty_to_be_printed*($length+2.5);
                //echo "<br/>";
                $total_film_guagee=$total_film_guage/1000;
                //echo "<br/>";
                $total_film_volume=$total_film_guagee*$film_length*$film_width;
                $density=0.00098;
                //echo "<br/>";
                $total_film_material=($total_film_volume*$density)/1000;

              }

            }


            $t=1;

            for($a=1;$a<=$layer_no;$a++){

              $data['specification_film_details']=$this->specification_model->select_details_record_for_jobcard_where_gauge('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$film_specs->spec_id,'specification_sheet_details.spec_version_no',$film_specs->spec_version_no,'item_group_id','3','layer_no',$a,'parameter_name','GUAGE','srd_id','asc','layer_no','asc');

              foreach($data['specification_film_details'] as $specification_film_details_row){

                $gauge=rtrim($specification_film_details_row->parameter_value," MIC");

                $data['specification_film_details']=$this->specification_model->select_details_record_for_jobcard_where_gauge('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$film_specs->spec_id,'specification_sheet_details.spec_version_no',$film_specs->spec_version_no,'item_group_id','3','mat_article_no<>','','layer_no',$a,'srd_id','asc','layer_no','asc');

                foreach($data['specification_film_details'] as $specification_film_details_row){

                  if(!empty($specification_film_details_row->mat_info) && !empty($specification_film_details_row->mat_article_no)){

                    $density='';

                    if($a=='1' || $a=='3' || $a=='5' || $a=='7' ){
                      $density=0.92;
                    }
                    elseif($a=='2' || $a=='6'){
                      $density=0.94;
                    }
                    elseif($a=='4'){
                      $density=1.19;
                    }


                    $rm_per_sleeve=(($length+2.5)*$film_width*$gauge*$density)/1000000;
                    //echo "<br/>";
                    //echo 'RM per sleeve in kg= ';
                    $rm_per_sleeve_in_kg=$rm_per_sleeve/1000;
                   //echo "<br/>";
                    //echo "Total Rm=";
                  //Changes done on 22nd Apr 2020 for  setup weight
                  //$rm_total=($rm_per_sleeve_in_kg*$qty_to_be_printed);
                    //echo "<br/>";
                    //echo "Total Rm perc%";

                    $rm_total=($total_setup_weight*$gauge)/$total_film_guage;

                    $rm_qty=$rm_total*($specification_film_details_row->mat_info/100);
                    //echo "<br/>";

                    $data['max_mm']=$this->common_model->select_max_pkey_numeric('material_manufacturing','mm_id',$this->session->userdata['logged_in']['company_id']);
                    foreach($data['max_mm'] as $max_mm_row){
                      $mm_id=$max_mm_row->mm_id+1;
                    }


                    $data=array(
                      'manu_order_no'=>$setup_jobcard_no,
                      'article_no'=>$specification_film_details_row->mat_article_no,
                      'demand_qty'=>$this->common_model->save_number($rm_qty,$this->session->userdata['logged_in']['company_id']),
                      'company_id'=>$this->session->userdata['logged_in']['company_id'],
                      //'work_proc_no'=>'15',
                      'work_proc_no'=>'1',
                      'from_job_card'=>'1',
                      'rel_demand_qty'=>$this->common_model->save_number($rm_qty*1000,$this->session->userdata['logged_in']['company_id']),
                      'flag_uom_type'=>'1',
                      'mm_id'=>$mm_id,
                      'rel_uom_id'=>'UOM013',
                      'part_pos_no'=>$t,
                      'layer_no'=>$a);
                      $this->common_model->save('material_manufacturing',$data);

                      $t++;

                  }

                }

              }

            }//LAYER FOR

          }//FOREACH FILMSPEC



      }

       return $setup_jobcard_no;

  }

  function create_purging_jobcard($jobcard_no,$purging_weight){

    //PURGING JOBCARD START
    $purging_jobcard_no='';
    $jobcard_type='5';// FOR PURGINNG

    // Jobcard details---------------------

    $customer='';
    $order_no='';
    $article_no='';
    $order_qty=0;
    $ord_pos_no='';
    $bom_no='';
    $bom_version_no='';
    $film_code='';
    $ad_id='';
    $version_no='';


    $production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$jobcard_no);

    foreach($production_master_result as $row) {
      $order_no=$row->sales_ord_no;
      $article_no=$row->article_no;
    }

    $order_master_result=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$order_no);
    foreach($order_master_result as $order_master_row){
      $customer=$order_master_row->customer_no;
    }

    $data_order_details=array(
    'order_no'=>$order_no,
    'article_no'=>$article_no
    );

    $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
    foreach($order_details_result as $order_details_row){
      $ord_pos_no=$order_details_row->ord_pos_no;
      $order_qty=$order_details_row->total_order_quantity;
      $bom_no=$order_details_row->spec_id;
      $bom_version_no=$order_details_row->spec_version_no;
      $ad_id=$order_details_row->ad_id;
      $version_no=$order_details_row->version_no;
    }


    $form_id='5400';

    $data['auto']=$this->common_model->select_one_active_record_nonlanguage_without_archive('autogeneration_format_master',$this->session->userdata['logged_in']['company_id'],'form_id',$form_id);
    $no="";
    foreach ($data['auto'] as $auto_row) {

      $data['account_periods']=$this->common_model->select_one_active_record_nonlanguage_without_archive('account_periods_master',$this->session->userdata['logged_in']['company_id'],'finyear_close_opt','0');
      foreach($data['account_periods'] as $account_periods_row){
        $start=date('y', strtotime($account_periods_row->fin_year_start));
        $end=date('y', strtotime($account_periods_row->fin_year_end));
      }
      $no=str_pad($auto_row->curr_val,4,"0",STR_PAD_LEFT);
      $purging_jobcard_no=$auto_row->textcode.$auto_row->seperator.$start.$auto_row->seperator.$end.$auto_row->seperator.$no;
      $next_jobcard_no=$auto_row->curr_val+1;
    }
    $data=array('curr_val'=>$next_jobcard_no);

    $this->common_model->update_one_active_record('autogeneration_format_master',$data,'form_id',$form_id,$this->session->userdata['logged_in']['company_id']);


    $data['max']=$this->common_model->select_max_pkey_numeric('production_master','manu_order_no',$this->session->userdata['logged_in']['company_id']);
    foreach($data['max'] as $max_value){
      $manu_order_no=$max_value->manu_order_no+1;
    }

    $data=array('manu_order_no'=>$manu_order_no,
      'company_id'=>$this->session->userdata['logged_in']['company_id'],
      'mp_pos_no'=>$purging_jobcard_no,
      'article_no'=>$article_no,
      'mp_qty'=>'',
      'actual_qty_manufactured'=>0,
      'manu_plan_date'=>date('Y-m-d'),
      'employee_id'=>$this->session->userdata['logged_in']['user_id'],
      'sales_ord_no'=>$order_no,
      'ord_pos_no'=>$ord_pos_no,
      'jobcard_type'=>'5',
      'ref_jobcard_no'=>$jobcard_no

    );

    $result=$this->common_model->save('production_master',$data);


    $data=array('bom_no'=>$bom_no,'bom_version_no'=>$bom_version_no);

    $bill_of_material_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data);

    foreach($bill_of_material_result as $bill_of_material_row){
        $film_code=$bill_of_material_row->sleeve_code;
        $shoulder_code=$bill_of_material_row->shoulder_code;
        $label_code=$bill_of_material_row->label_code;
        $cap_code=$bill_of_material_row->cap_code;
        $for_export=$bill_of_material_row->for_export;

        $data['film_specs']=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$film_code);
        foreach($data['film_specs'] as $film_specs){
          $film_specss['spec_id']=$film_specs->spec_id;
          $film_specss['spec_version_no']=$film_specs->spec_version_no;

          $film_specs_master_result=$this->common_model->select_active_records_where('specification_sheet',$this->session->userdata['logged_in']['company_id'],$film_specss);
            if($film_specs_master_result){
              foreach($film_specs_master_result as $film_specs_master_result_row){
                $layer_arr=explode("|", $film_specs_master_result_row->dyn_qty_present);
                $layer_no=substr($layer_arr[1],0,1);
              }
            }

          $film_specs_result=$this->sales_order_book_model->select_film_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$film_specss);

          foreach($film_specs_result as $specs_row){

              $dia=$specs_row->SLEEVE_DIA;
              $length=$specs_row->SLEEVE_LENGTH;
              $total_film_guage=$specs_row->FILM_GUAGE_1+$specs_row->FILM_GUAGE_2+$specs_row->FILM_GUAGE_3+$specs_row->FILM_GUAGE_4+$specs_row->FILM_GUAGE_5+$specs_row->FILM_GUAGE_6+$specs_row->FILM_GUAGE_7;

              $t=1;

            for($a=1;$a<=$layer_no;$a++){

              $data['specification_film_details']=$this->specification_model->select_details_record_for_jobcard_where_gauge('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$film_specs->spec_id,'specification_sheet_details.spec_version_no',$film_specs->spec_version_no,'item_group_id','3','layer_no',$a,'parameter_name','GUAGE','srd_id','asc','layer_no','asc');

              foreach($data['specification_film_details'] as $specification_film_details_row){

                $gauge=rtrim($specification_film_details_row->parameter_value," MIC");

                $data['specification_film_details']=$this->specification_model->select_details_record_for_jobcard_where_gauge('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$film_specs->spec_id,'specification_sheet_details.spec_version_no',$film_specs->spec_version_no,'item_group_id','3','mat_article_no<>','','layer_no',$a,'srd_id','asc','layer_no','asc');

                foreach($data['specification_film_details'] as $specification_film_details_row){
                  if($specification_film_details_row->item_group_material<>12){
                  if(!empty($specification_film_details_row->mat_info) && !empty($specification_film_details_row->mat_article_no)){

                    $density='';

                    if($a=='1' || $a=='3' || $a=='5' || $a=='7' ){
                      $density=0.92;
                    }
                    elseif($a=='2' || $a=='6'){
                      $density=0.94;
                      //$density=0.92;
                    }
                    elseif($a=='4'){
                      $density=1.19;
                      //$density=0.92;
                    }


                    //$rm_per_sleeve=(($length+2.5)*$film_width*$gauge*$density)/1000000;
                    //echo "<br/>";
                    //echo 'RM per sleeve in kg= ';
                    //$rm_per_sleeve_in_kg=$rm_per_sleeve/1000;
                   //echo "<br/>";
                    //echo "Total Rm=";
                  //Changes done on 22nd Apr 2020 for  setup weight
                  //$rm_total=($rm_per_sleeve_in_kg*$qty_to_be_printed);
                    //echo "<br/>";
                    //echo "Total Rm perc%";

                    $rm_total=($purging_weight*$gauge)/$total_film_guage;

                    $rm_qty=$rm_total*($specification_film_details_row->mat_info/100);
                    //echo "<br/>";

                    $data['max_mm']=$this->common_model->select_max_pkey_numeric('material_manufacturing','mm_id',$this->session->userdata['logged_in']['company_id']);
                    foreach($data['max_mm'] as $max_mm_row){
                      $mm_id=$max_mm_row->mm_id+1;
                    }


                    $data=array(
                      'manu_order_no'=>$purging_jobcard_no,
                      'article_no'=>$specification_film_details_row->mat_article_no,
                      'demand_qty'=>$this->common_model->save_number($rm_qty,$this->session->userdata['logged_in']['company_id']),
                      'company_id'=>$this->session->userdata['logged_in']['company_id'],
                      //'work_proc_no'=>'15',
                      'work_proc_no'=>'1',
                      'from_job_card'=>'1',
                      'rel_demand_qty'=>$this->common_model->save_number($rm_qty*1000,$this->session->userdata['logged_in']['company_id']),
                      'flag_uom_type'=>'1',
                      'mm_id'=>$mm_id,
                      'rel_uom_id'=>'UOM013',
                      'part_pos_no'=>$t,
                      'layer_no'=>$a);
                      $this->common_model->save('material_manufacturing',$data);

                      $t++;

                  }
                }

                }

              }

            }

            }

        }
    }
    // Jobcard quantity for material manufacturing--------------

    // $purging_materials=array('ldpe'=>'RM-LDPE-000-0018','lldpe'=>'RM-LLDPE-000-0008');
    //
    // //print_r();
    // $i=1;
    //
    //
    // foreach ($purging_materials  as $key =>$value) {
    //
    //   $rel_qty=0;
    //   $mat_article_no='';
    //
    //   if($key=='ldpe'){
    //
    //     $rel_qty=($purging_weight*70)/100;
    //     $mat_article_no= $value;   //70%
    //
    //   }else{
    //     $rel_qty=($purging_weight*30)/100;    //30%
    //     $mat_article_no= $value;
    //   }
    //
    //
    //   $data['max_mm']=$this->common_model->select_max_pkey_numeric('material_manufacturing','mm_id',$this->session->userdata['logged_in']['company_id']);
    //
    //   foreach($data['max_mm'] as $max_mm_row){
    //     $mm_id=$max_mm_row->mm_id+1;
    //   }
    //
    //   $rel_qty=$this->common_model->save_number($rel_qty,$this->session->userdata['logged_in']['company_id']);
    //   $data=array('manu_order_no'=>$purging_jobcard_no,
    //     'article_no'=>$mat_article_no,
    //     'demand_qty'=>$rel_qty,
    //     'company_id'=>$this->session->userdata['logged_in']['company_id'],
    //     'work_proc_no'=>'9',
    //     'from_job_card'=>'1',
    //     'rel_demand_qty'=>$rel_qty*1000,
    //     'flag_uom_type'=>'1',
    //     'mm_id'=>$mm_id,
    //     'rel_uom_id'=>'UOM013',
    //     'part_pos_no'=>$i ,
    //     'layer_no'=>'1');
    //
    //   $this->common_model->save('material_manufacturing',$data);
    //   $i++;
    //
    // }

    return $purging_jobcard_no;

  }

  function material_issue_check($jobcard_no){

    $material_pending=0;

    $material_manu_data=array('manu_order_no'=>$jobcard_no,'archive'=>'0');
    $material_manufacturing_result=$this->common_model->select_active_records_where('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$material_manu_data);

    //echo $this->db->last_query();

    if($material_manufacturing_result == FALSE){
      $material_pending=1;
    }else{
      foreach ($material_manufacturing_result as $material_manufacturing_row){
        if($material_manufacturing_row->completed_flag=='0'){
          $material_pending=1;
          break;

        }
        // else if($material_manufacturing_row->completed_flag=='1' && $material_manufacturing_row->calculated_purchase_price==0){
        //   $material_pending=1;
        //   break;

        // }
      }
    }


    if($material_pending==1){
      $this->form_validation->set_message('material_issue_check', 'Material issue is pending for Jobcard no. '.$jobcard_no.', So entry not allowed');
        return FALSE;
    }else{
      return TRUE;
    }
  }




}
