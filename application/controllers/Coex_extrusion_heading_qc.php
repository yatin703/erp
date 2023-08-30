<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coex_extrusion_heading_qc extends CI_Controller {

  function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('coex_extrusion_heading_model');
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
              $table='coex_extrusion_heading_qc';
              include('pagination.php');
              $data['coex_extrusion_heading_qc']=$this->coex_extrusion_heading_model->select_active_records_heading_qc($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

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
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,'coex_extrusion');

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->modify==1){
                  
                  $dataa=array('process_id' =>'1');
                  $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
                  $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']); 
                  $data['hold_data']=$this->coex_extrusion_heading_model->select_one_active_record_hold('coex_extrusion_heading_qc',$this->session->userdata['logged_in']['company_id'],'coex_extrusion_heading_qc.hqc_id',$this->uri->segment(3));
                  $this->load->view('Home/header');
                  $this->load->view('Home/nav',$data);
                  $this->load->view('Home/subnav');
                  $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
                  $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
                  $this->load->view('Home/footer');
            }else{
                $data['note']='No modify rights Thanks';
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
      $data['note']='No modify rights Thanks';
      $data['page_name']='production';
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
            $this->form_validation->set_rules('extrusion_date','Date' ,'required|trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('shift','Shift' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('machine','Machine' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('operator','Operator' ,'required|trim|xss_clean');        
            $this->form_validation->set_rules('order_no','Order No' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('article_no','Product No' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('jobcard_no','Jobcard No' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sleeve_weight_gm','Sleeve Weight GM' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('diameter','Diameter' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('length','Length' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('production_qty','Production QTY' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ok_by_qc','Ok by QC' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('scrap_by_qc','Scrap by QC' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('inspection_name','Oprator Name' ,'required|trim|xss_clean');
            if($this->form_validation->run()==FALSE){
              $dataa = array('process_id' =>'1');
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
              $data['hold_data']=$this->coex_extrusion_heading_model->select_one_active_record_hold('coex_extrusion_heading_qc',$this->session->userdata['logged_in']['company_id'],'coex_extrusion_heading_qc.hqc_id',$this->uri->segment(3));
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
              $this->load->view('Home/footer');
            }else{

              $data_wip=array(
                'company_id'=>$this->session->userdata['logged_in']['company_id'],
                'qc_id'=> $this->input->post('hqc_id'),
                'heading_id'=> $this->input->post('heading_id'),
                'extrusion_date'=> $this->input->post('extrusion_date'),
                'shift_id'=> $this->input->post('shift'),
                'machine_id'=> $this->input->post('machine'),
                'operator'=> $this->input->post('operator'),
                'order_no'=> $this->input->post('order_no'),
                'article_no'=> $this->input->post('article_no'),
                'diameter'=> $this->input->post('diameter'),
                'length'=> $this->input->post('length'),
                'sleeve_weight_gm'=> $this->input->post('sleeve_weight_gm'),
                'jobcard_no'=> $this->input->post('jobcard_no'),
                'production_qty'=> $this->input->post('production_qty'),
                'ok_by_qc'=> $this->input->post('ok_by_qc'),
                'inspection_name'=> $this->input->post('inspection_name'),
                'remark'=> $this->input->post('remark'),
                'created_date'=>date('Y-m-d'),
                'archive'=> '0',
                'status'=> '0',
                'form_process'=> 'Heading QC',
                'user_id'=>$this->session->userdata['logged_in']['user_id']         
              );
              $result=$this->common_model->save('coex_extrusion_heading_wip',$data_wip);
              
              $data_qc=array(
                'company_id'=>$this->session->userdata['logged_in']['company_id'],
                'qc_id'=> $this->input->post('hqc_id'),
                'heading_id'=> $this->input->post('heading_id'),
                'extrusion_date'=> $this->input->post('extrusion_date'),
                'shift_id'=> $this->input->post('shift'),
                'machine_id'=> $this->input->post('machine'),
                'operator'=> $this->input->post('operator'),
                'order_no'=> $this->input->post('order_no'),
                'article_no'=> $this->input->post('article_no'),
                'diameter'=> $this->input->post('diameter'),
                'length'=> $this->input->post('length'),
                'sleeve_weight_gm'=> $this->input->post('sleeve_weight_gm'),
                'jobcard_no'=> $this->input->post('jobcard_no'),
                'production_qty'=> $this->input->post('production_qty'),
                'hold_by_qc'=> $this->input->post('hold_by_qc'),
                'inspection_name'=> $this->input->post('inspection_name'),
                'remark'=> $this->input->post('remark'),
                'created_date'=>date('Y-m-d'),
                'archive'=> '0',
                'status'=> '1',
                'form_process'=> 'Heading QC',
                'user_id'=>$this->session->userdata['logged_in']['user_id']         
              );
              $result=$this->common_model->save('coex_extrusion_heading_qc',$data_qc);
        
              $data_scrap=array(
                'company_id'=>$this->session->userdata['logged_in']['company_id'],
                'qc_id'=> $this->input->post('hqc_id'),
                'heading_id'=> $this->input->post('heading_id'),
                'extrusion_date'=> $this->input->post('extrusion_date'),
                'shift_id'=> $this->input->post('shift'),
                'machine_id'=> $this->input->post('machine'),
                'operator'=> $this->input->post('operator'),
                'order_no'=> $this->input->post('order_no'),
                'article_no'=> $this->input->post('article_no'),
                'diameter'=> $this->input->post('diameter'),
                'length'=> $this->input->post('length'),
                'sleeve_weight_gm'=> $this->input->post('sleeve_weight_gm'),
                'jobcard_no'=> $this->input->post('jobcard_no'),
                'production_qty'=> $this->input->post('production_qty'),
                'scrap_by_qc'=> $this->input->post('scrap_by_qc'),
                'inspection_name'=> $this->input->post('inspection_name'),
                'remark'=> $this->input->post('remark'),
                'created_date'=>date('Y-m-d'),
                'archive'=> '0',
                'status'=> '0',
                'form_process'=> 'Heading QC',
                'user_id'=>$this->session->userdata['logged_in']['user_id']         
              );
              $result=$this->common_model->save('coex_extrusion_heading_scrap',$data_scrap);

              $data_ce=array(
                 'flag'=> '1',
                 'heading_date'=> date('Y-m-d')
              );
              $result=$this->common_model->update_one_active_record('coex_extrusion_heading_qc',$data_ce,'hqc_id',$this->input->post('hqc_id'),$this->session->userdata['logged_in']['company_id']);

              $data['page_name']='Prodution';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
              $data['note']='Create Transaction Completed';
              $dataa=array('process_id' =>'1');
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']); 
              $data['hold_data']=$this->coex_extrusion_heading_model->select_one_active_record_hold('coex_extrusion_heading_qc',$this->session->userdata['logged_in']['company_id'],'coex_extrusion_heading_qc.hqc_id',$this->uri->segment(3));
              
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

}