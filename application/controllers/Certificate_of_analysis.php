<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Certificate_of_analysis extends CI_Controller {

  function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('certificate_of_analysis_model');
      $this->load->model('shoulder_orifice_dependancy_model');
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
              $table='certificate_of_analysis';
              include('pagination.php');
              $data['certificate_of_analysis']=$this->certificate_of_analysis_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

              $data['count_active_records'] = $this->certificate_of_analysis_model->count_active_records();
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
          $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','108');
          //echo $this->db->last_query();
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
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $this->form_validation->set_rules('certificate_no','Certificate No' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('so_no','Order No' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('product_name','Product No' ,'required|trim|xss_clean');

            if($this->form_validation->run()==FALSE){

             $dataa = array('ar_invoice_no'=>$this->input->post('certificate_no'));
             $data['so_no']=$this->common_model->select_active_records_where('ar_invoice_details',$this->session->userdata['logged_in']['company_id'],$dataa);
             $this->db->last_query();
             $dataaa= array('ar_invoice_no'=>$this->input->post('certificate_no'),'ref_ord_no'=>$this->input->post('so_no'));
             $data['product_name']=$this->common_model->select_active_records_where('ar_invoice_details',$this->session->userdata['logged_in']['company_id'],$dataaa);
           
             
            // echo $this->db->last_query();
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
              $this->load->view('Home/footer');
            }else{
              
              /*$so_no = $this->input->post('so_no');
              if ($so_no != '') {
                $check_so_no = $this->certificate_of_analysis_model->check_so_no_duplication('on_create', 'so_no', $so_no);
              } else {
                $check_so_no = true;
              }

              if ($check_so_no == false) {
                $data['error']='SO No. Already Taken';                
              }else{*/  
              $data=array(
                'company_id'=>$this->session->userdata['logged_in']['company_id'],
                'inspection_date'=>$this->input->post('inspection_date'),
                'certificate_no'=>$this->input->post('certificate_no'),
                'customer_name'=>$this->input->post('customer_name'),
                'quality'=>$this->input->post('quality'),
                'product_name'=> $this->input->post('product_name'),
                'total_qty'=>$this->input->post('total_qty'),
                'so_no'=>$this->input->post('so_no'),
                'sample_size'=>$this->input->post('sample_size'),
                'specification_length'=>$this->input->post('specification_length'),
                'actual_length'=>$this->input->post('actual_length'),
                'specification_inner_dia'=>$this->input->post('specification_inner_dia'),
                'actual_inner_dia'=>$this->input->post('actual_inner_dia'),
                'specification_outer_dia'=>$this->input->post('specification_outer_dia'),
                'actual_outer_dia'=>$this->input->post('actual_outer_dia'),
                'inner_tolerance'=>$this->input->post('inner_tolerance'),
                'outer_tolerance'=>$this->input->post('outer_tolerance'),             
                'shoulder_thread_type'=>$this->input->post('shoulder_thread_type'),
                'shoulder_master_batch'=>$this->input->post('shoulder_master_batch'),
                'specification_orifice'=>$this->input->post('specification_orifice'),
                'tolerance_orifice'=>$this->input->post('tolerance_orifice'),
                'actual_orifice'=>$this->input->post('actual_orifice'),
                'master_batch_orifice'=>$this->input->post('master_batch_orifice'),
                'cap_master_batch_colour'=>$this->input->post('cap_master_batch_colour'),
                'cap_type'=>$this->input->post('cap_type'),
                'specification_diameter'=>$this->input->post('specification_diameter'),
                'actual_diameter'=>$this->input->post('actual_diameter'),
                'master_batch_diameter'=>$this->input->post('master_batch_diameter'),
                'specification_height'=>$this->input->post('specification_height'),
                'actual_height'=>$this->input->post('actual_height'),
                'specification_cap_orifice'=>$this->input->post('specification_cap_orifice'),
                'actual_cap_orifice'=>$this->input->post('actual_cap_orifice'),
                'specification_shrink_sleeve'=>$this->input->post('specification_shrink_sleeve'),
                'actual_shrink_sleeve'=>$this->input->post('actual_shrink_sleeve'),
                'specification_print'=>$this->input->post('specification_print'),
                'actual_print'=>$this->input->post('actual_print'),
                'lacquer_type'=>$this->input->post('lacquer_type'),
        
                'lbl_specification'=>$this->input->post('lbl_specification'),
                'lbl_actual_print'=>$this->input->post('lbl_actual_print'),
                'lbl_lacquer_type'=>$this->input->post('lbl_lacquer_type'),
        
                'air_leakage_status'=>$this->input->post('air_leakage_status'),
                'sleeve_colour_opacity_status'=>$this->input->post('sleeve_colour_opacity_status'),
                'water_package_status'=>$this->input->post('water_package_status'),
                'gliding_test_status'=>$this->input->post('gliding_test_status'),
                'cap_fitment_status'=>$this->input->post('cap_fitment_status'),
                'uv_test_status'=>$this->input->post('uv_test_status'),
                'shoulder_welding_test_status'=>$this->input->post('shoulder_welding_test_status'),
                'drop_test_status'=>$this->input->post('drop_test_status'),
                'escr_test_status'=>$this->input->post('escr_test_status'),
                'tape_test_status'=>$this->input->post('tape_test_status'),
                'odour_test_status'=>$this->input->post('odour_test_status'),
                'rub_test_status'=>$this->input->post('rub_test_status'),
                'vertically_test_status'=>$this->input->post('vertically_test_status'),
                'sealing_test_status'=>$this->input->post('sealing_test_status'),
                'sleeve_colour_difference_status'=>$this->input->post('sleeve_colour_difference_status'),
                'bar_code_test_status'=>$this->input->post('bar_code_test_status'),
                'welding_test_side_seam_status'=>$this->input->post('welding_test_side_seam_status'),
                'total_number_of_pallets'=>$this->input->post('total_number_of_pallets'),
                'sample_per_pallets'=>$this->input->post('sample_per_pallets'),
                'number_of_pallets_rechecked'=>$this->input->post('number_of_pallets_rechecked'),
                'coa_result_status'=>$this->input->post('coa_result_status'),
                'prepared_name'=>$this->input->post('prepared_name'),
                'approval_by'=>$this->input->post('approval_by'),  
                'archive'=>'0',  
                'user_id'=>$this->session->userdata['logged_in']['user_id']            
                 );

              $result=$this->common_model->save('certificate_of_analysis',$data);
              $coa_id = $this->db->insert_id();
                        

              if(!empty($this->input->post('approval_by'))){
                $data=array('pending_flag'=>'1');
                $result=$this->common_model->update_one_active_record('certificate_of_analysis',$data,'certificate_no',$this->input->post('certificate_no'),$this->session->userdata['logged_in']['company_id']);
               $data['followup']=$this->common_model->select_one_active_record_nonlanguage_without_archive('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$this->input->post('certificate_no').'@@@'.$this->input->post('so_no').'@@@'.$this->input->post('product_name'));
                if($data['followup']==FALSE){
                  $transaction_no=1;
                  $status=1;
                }else{
                  $i=1;
                  foreach ($data['followup'] as $followup_row){
                    $transaction_no=$followup_row->transaction_no;
                    $status=1;
                    $i++;
                  }
                  $transaction_no=$i;
                }

                $data=array(
                    'company_id'=>$this->session->userdata['logged_in']['company_id'],
                    'user_id'=>$this->input->post('approval_by'),
                    'form_id'=>'108',
                    'transaction_no'=>$transaction_no,
                    'status'=>$status,
                    'followup_date'=>date('Y-m-d'),
                    'contact_person_id'=>$this->session->userdata['logged_in']['user_id'],
                    'record_no'=>$this->input->post('certificate_no').'@@@'.$this->input->post('so_no').'@@@'.$this->input->post('product_name'));
                    $result=$this->common_model->save('followup',$data);
                    $data['note']='Sent For the Approval';
            }
                
                $data['page_name']='Prodution';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
                $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','108');
              
                $data['note']='Create Transaction Completed';
              //}
              //header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
              $dataa = array('ar_invoice_no'=>$this->input->post('certificate_no'));
              $data['so_no']=$this->common_model->select_active_records_where('ar_invoice_details',$this->session->userdata['logged_in']['company_id'],$dataa);
              
              $dataaa= array('ar_invoice_no'=>$this->input->post('certificate_no'),'ref_ord_no'=>$this->input->post('so_no'));
             $data['product_name']=$this->common_model->select_active_records_where('ar_invoice_details',$this->session->userdata['logged_in']['company_id'],$dataaa);
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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,'certificate_of_analysis');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->modify==1){
             
             $dataa = array('certificate_no'=>$this->uri->segment(3));
             $data['certificate_of_analysis']=$this->common_model->select_active_records_where('certificate_of_analysis',$this->session->userdata['logged_in']['company_id'],$dataa);
             
             $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','108');
            //echo $this->db->last_query();

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
      $data['page_name']='Sales';
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
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,'certificate_of_analysis');

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){

            $this->form_validation->set_rules('certificate_no','Certificate No' ,'required|trim|xss_clean');

              if($this->form_validation->run()==FALSE){
                //echo '1';
                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
                $this->load->view('Home/footer');
              }else{
                //echo '2';
              $data=array(
                'company_id'=>$this->session->userdata['logged_in']['company_id'],
                'inspection_date'=>$this->input->post('inspection_date'),
                'certificate_no'=>$this->input->post('certificate_no'),
                'customer_name'=>$this->input->post('customer_name'),
                'quality'=>$this->input->post('quality'),
                'product_name'=>$this->input->post('product_name'),
                'total_qty'=>$this->input->post('total_qty'),
                'so_no'=>$this->input->post('so_no'),
                'sample_size'=>$this->input->post('sample_size'),
                'specification_length'=>$this->input->post('specification_length'),
                'actual_length'=>$this->input->post('actual_length'),
                'specification_inner_dia'=>$this->input->post('specification_inner_dia'),
                'actual_inner_dia'=>$this->input->post('actual_inner_dia'),
                'specification_outer_dia'=>$this->input->post('specification_outer_dia'),
                'actual_outer_dia'=>$this->input->post('actual_outer_dia'),  
                'inner_tolerance'=>$this->input->post('inner_tolerance'),
                'outer_tolerance'=>$this->input->post('outer_tolerance'),              
                'shoulder_thread_type'=>$this->input->post('shoulder_thread_type'),
                'shoulder_master_batch'=>$this->input->post('shoulder_master_batch'),
                'specification_orifice'=>$this->input->post('specification_orifice'),
                'tolerance_orifice'=>$this->input->post('tolerance_orifice'),
                'actual_orifice'=>$this->input->post('actual_orifice'),
                'master_batch_orifice'=>$this->input->post('master_batch_orifice'),
                'cap_master_batch_colour'=>$this->input->post('cap_master_batch_colour'),
                'cap_type'=>$this->input->post('cap_type'),
                'specification_diameter'=>$this->input->post('specification_diameter'),
                'actual_diameter'=>$this->input->post('actual_diameter'),
                'master_batch_diameter'=>$this->input->post('master_batch_diameter'),
                'specification_height'=>$this->input->post('specification_height'),
                'actual_height'=>$this->input->post('actual_height'),
                'specification_cap_orifice'=>$this->input->post('specification_cap_orifice'),
                'actual_cap_orifice'=>$this->input->post('actual_cap_orifice'),
                'specification_shrink_sleeve'=>$this->input->post('specification_shrink_sleeve'),
                'actual_shrink_sleeve'=>$this->input->post('actual_shrink_sleeve'),
                'specification_print'=>$this->input->post('specification_print'),
                'actual_print'=>$this->input->post('actual_print'),
                'lacquer_type'=>$this->input->post('lacquer_type'),
                'lbl_specification'=>$this->input->post('lbl_specification'),
                'lbl_actual_print'=>$this->input->post('lbl_actual_print'),
                'lbl_lacquer_type'=>$this->input->post('lbl_lacquer_type'),
                'air_leakage_status'=>$this->input->post('air_leakage_status'),
                'sleeve_colour_opacity_status'=>$this->input->post('sleeve_colour_opacity_status'),
                'water_package_status'=>$this->input->post('water_package_status'),
                'gliding_test_status'=>$this->input->post('gliding_test_status'),
                'cap_fitment_status'=>$this->input->post('cap_fitment_status'),
                'uv_test_status'=>$this->input->post('uv_test_status'),
                'shoulder_welding_test_status'=>$this->input->post('shoulder_welding_test_status'),
                'drop_test_status'=>$this->input->post('drop_test_status'),
                'escr_test_status'=>$this->input->post('escr_test_status'),
                'tape_test_status'=>$this->input->post('tape_test_status'),
                'odour_test_status'=>$this->input->post('odour_test_status'),
                'rub_test_status'=>$this->input->post('rub_test_status'),
                'vertically_test_status'=>$this->input->post('vertically_test_status'),
                'sealing_test_status'=>$this->input->post('sealing_test_status'),
                'sleeve_colour_difference_status'=>$this->input->post('sleeve_colour_difference_status'),
                'bar_code_test_status'=>$this->input->post('bar_code_test_status'),
                'welding_test_side_seam_status'=>$this->input->post('welding_test_side_seam_status'),
                'total_number_of_pallets'=>$this->input->post('total_number_of_pallets'),
                'sample_per_pallets'=>$this->input->post('sample_per_pallets'),
                'number_of_pallets_rechecked'=>$this->input->post('number_of_pallets_rechecked'),
                'coa_result_status'=>$this->input->post('coa_result_status'),
                'prepared_name'=>$this->input->post('prepared_name'),
                'archive'=>'0',
                'user_id'=>$this->session->userdata['logged_in']['user_id']
                );

                $result=$this->common_model->update_one_active_record('certificate_of_analysis',$data,'certificate_no',$this->input->post('certificate_no'),$this->session->userdata['logged_in']['company_id']);

                if(!empty($this->input->post('approval_by'))){

                    $data=array('pending_flag'=>'1');
                    
                    $result=$this->common_model->update_one_active_record('certificate_of_analysis',$data,'certificate_no',$this->input->post('certificate_no'),$this->session->userdata['logged_in']['company_id']);

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
                        'user_id'=>$this->input->post('approval_by'),
                        'form_id'=>'108',
                        'transaction_no'=>$transaction_no,
                        'status'=>$status,
                        'followup_date'=>date('Y-m-d'),
                        'contact_person_id'=>$this->session->userdata['logged_in']['user_id'],
                        'record_no'=>$this->input->post('record_no'));

                      $result=$this->common_model->save('followup',$data);
                }

                  $dataa = array('certificate_no'=>$this->input->post('certificate_no'));;
                  $data['certificate_of_analysis']=$this->common_model->select_active_records_where('certificate_of_analysis',$this->session->userdata['logged_in']['company_id'],$dataa);

                  $data['approval_authority']=$this->common_model->select_one_active_approval_authority_record('authority_master',$this->session->userdata['logged_in']['company_id'],'authority_master.form_id','108');

                  $data['page_name']='Production';
                  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                  $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],1,'certificate_of_analysis');
                 
                  $data['note']='Update Transaction Completed';
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

            $data['certificate_of_analysis']=$this->certificate_of_analysis_model->get_coa_details_id($this->session->userdata['logged_in']['company_id'],$this->uri->segment(3),$this->uri->segment(4),$this->uri->segment(5));
           
            $certificate_of_analysis = $data['certificate_of_analysis'];
            $date1 = $certificate_of_analysis['inspection_date'];
            $date2 = '2023-05-15';
            //$date1  = $this->common_model->view_date($certificate_of_analysis['inspection_date'],$this->session->userdata['logged_in']['company_id']);
            
            //$date2 = $this->common_model->view_date('15-May-2023',$this->session->userdata['logged_in']['company_id']);

            if($date1 >= $date2){
               $this->load->view('Print/coa-header',$data);
            }else{
              
              $this->load->view('Print/header',$data);
            }

            //$this->load->view('Print/header',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/view-form',$data);
          }
          else{
              $data['note']='No View rights Thanks';
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
      $data['note']='No view rights Thanks';
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
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,'certificate_of_analysis');

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->delete==1){

                $data=array('archive'=>'1');

                $result=$this->common_model->archive_one_record('certificate_of_analysis',$data,'coa_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

                $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,'certificate_of_analysis');
                $dataa = '';
             $data['certificate_of_analysis']=$this->common_model->select_active_records_where('certificate_of_analysis',$this->session->userdata['logged_in']['company_id'],$dataa);


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


function archive_records(){
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,'certificate_of_analysis');

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->delete==1){
            $table='certificate_of_analysis';

            include('pagination_archive.php');

            $data['certificate_of_analysis']=$this->common_model->select_archive_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
            $data['page_name']='Production';

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
            $result=$this->common_model->update_one_active_record('certificate_of_analysis',$data,'coa_id',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

            if($result){

              $data['note']="Dearchive Transaction completed";

              header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

              $data['certificate_of_analysis']=$this->common_model->select_one_active_record('certificate_of_analysis',$this->session->userdata['logged_in']['company_id'],'coa_id',$this->uri->segment(3));

              $data['page_name']='Production';

              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,'certificate_of_analysis');

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/modify-form',$data);
              $this->load->view('Home/footer');

            }
            else{
                $data['note']='Error in Dearchive Transaction';

                $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,'certificate_of_analysis');

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

function search_result(){
    $data['page_name']='Sales';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
        foreach ($data['module'] as $module_row) {
          if($module_row->module_name==='Production'){

             $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              foreach ($data['formrights'] as $formrights_row) {
                if($formrights_row->view==1){

                    $this->form_validation->set_rules('from_date','From Date' ,'trim|xss_clean|exact_length[10]');
                    $this->form_validation->set_rules('to_date','To Date' ,'trim|xss_clean|exact_length[10]');

                    if($this->form_validation->run()==FALSE){

                        $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
                        $this->load->view('Home/header');
                        $this->load->view('Home/nav',$data);
                        $this->load->view('Home/subnav');
                        $this->load->view('Loading/loading');
                        $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                        $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                        $this->load->view('Home/footer');
                    }else{
                        $from=$this->common_model->change_date_format($this->input->post('from_date'),$this->session->userdata['logged_in']['company_id']);
                        $to=$this->common_model->change_date_format($this->input->post('to_date'),$this->session->userdata['logged_in']['company_id']);
        
                        $master_array= array('certificate_of_analysis.certificate_no'=>$this->input->post('certificate_no'),
                                             'certificate_of_analysis.customer_name'=>$this->input->post('customer_name'),
                                             'certificate_of_analysis.product_name'=>$this->input->post('product_name'),
                                             'certificate_of_analysis.so_no'=>$this->input->post('so_no'));
                          
                          $data1=array_filter($master_array);                      
                          $data['certificate_of_analysis']=$this->certificate_of_analysis_model->active_record_search('certificate_of_analysis',$data1,$from,$to,$this->session->userdata['logged_in']['company_id']);

                          $this->load->view('Home/header');
                          $this->load->view('Home/nav',$data);
                          $this->load->view('Home/subnav');
                          $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                          $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                          $this->load->view(ucwords($this->router->fetch_class()).'/active-records',$data);
                          $this->load->view('Home/footer');
                    }
                }
                else{
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

public function get_ajax_ar_invoice_no_id()
  {
    $ar_invoice_no_id = $this->input->post('certificate_no');
    $ar_order_no_id = $this->input->post('so_no');
    $ar_product_no_id = $this->input->post('product_name');
    $this->certificate_of_analysis_model->get_ajax_ar_invoice_no_id($ar_invoice_no_id,$ar_order_no_id,$ar_product_no_id);        
  }
  
}