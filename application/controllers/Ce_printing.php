<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ce_printing extends CI_Controller {

  function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('coex_extrusion_printing_model');
      $this->load->model('fiscal_model');
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
              $table='coex_extrusion_printing';
              include('pagination.php');
              $data['coex_extrusion_printing']=$this->coex_extrusion_printing_model->select_active_records($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

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
            $dataa = array('process_id' =>'1');
            $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
            $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
            $data['coex_extrusion']=$this->coex_extrusion_printing_model->select_one_active_record_printing('coex_extrusion_printing',$this->session->userdata['logged_in']['company_id'],'coex_extrusion_printing.printing_id',$this->uri->segment(3));

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/form',$data);
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
        $this->form_validation->set_rules('ok_by_qc','WIP QTY' ,'required|trim|xss_clean');
        $this->form_validation->set_rules('hold_by_qc','Hold QTY' ,'required|trim|xss_clean');
        $this->form_validation->set_rules('inspection_name','Operator Name' ,'required|trim|xss_clean');

        if($this->form_validation->run()==FALSE){
          $dataa = array('process_id' =>'1');
          $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
          $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);

          $this->load->view('Home/header');
          $this->load->view('Home/nav',$data);
          $this->load->view('Home/subnav');
          $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
          $this->load->view(ucwords($this->router->fetch_class()).'/form',$data);
          $this->load->view('Home/footer');
        }else{
      
          $data_wip=array(
            'company_id'=>$this->session->userdata['logged_in']['company_id'],
            'printing_id'=> $this->input->post('printing_id'),
            'inspection_name'=> $this->input->post('inspection_name'),
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
            'created_date'=>date('d-m-y'),
            'archive'=> '0',
            'form_process'=> 'Heading Production',
            'user_id'=>$this->session->userdata['logged_in']['user_id']         
          );
          $result=$this->common_model->save('coex_extrusion_printing_wip',$data_wip);

          $data_qc=array(
            'company_id'=>$this->session->userdata['logged_in']['company_id'],
            'printing_id'=> $this->input->post('printing_id'),
            'inspection_name'=> $this->input->post('inspection_name'),
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
            'created_date'=>date('d-m-y'),
            'archive'=> '0',
            'form_process'=> 'Heading Production',
            'user_id'=>$this->session->userdata['logged_in']['user_id']         
          );        
          $result=$this->common_model->save('coex_extrusion_printing_qc',$data_qc);
               
          $data_ce=array(
              'flag'=> '1',
              'printing_date'=>date('d-m-y')
          );
          $result=$this->common_model->update_one_active_record('coex_extrusion_printing',$data_ce,'printing_id',$this->input->post('printing_id'),$this->session->userdata['logged_in']['company_id']);

          $dataa = array('process_id' =>'1');
          $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
          $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
          $data['coex_extrusion']=$this->coex_extrusion_printing_model->select_one_active_record_printing('coex_extrusion_printing',$this->session->userdata['logged_in']['company_id'],'coex_extrusion_printing.printing_id',$this->uri->segment(3));
          $data['page_name']='Prodution';
          $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          $data['note']='Create Transaction Completed';
          header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
          $this->load->view('Home/header');
          $this->load->view('Home/nav',$data);
          $this->load->view('Home/subnav');
          $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
          $this->load->view(ucwords($this->router->fetch_class()).'/form',$data);
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
    $data['note']='No Creat rights Thanks';
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