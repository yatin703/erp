<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ce_printing_wip extends CI_Controller {

  function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('coex_extrusion_printing_model');
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
              $table='coex_extrusion_printing_wip';
              include('pagination.php');
              $data['coex_extrusion_printing_wip']=$this->coex_extrusion_printing_model->select_active_records_printing_wip($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

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

function wip_release($prt_wip_id){       
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->new==1){

              $table='coex_extrusion_printing_wip';
              $data['coex_extrusion_printing_wip']=$this->coex_extrusion_printing_model->select_one_active_record_wip($table,$this->session->userdata['logged_in']['company_id'],'prt_wip_id',$prt_wip_id);

              $dataa=array('process_id' =>'1');
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']); 

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


   function wip_release_save(){
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
            $this->form_validation->set_rules('sleeve_weight_gm','Sleeve Weight' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('diameter','Diameter' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('length','Length' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ok_by_qc','WIP Qty' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('release_qty','Release Qty' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('to_process','To Process' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('inspection_name','Released By' ,'required|trim|xss_clean');
            if($this->form_validation->run()==FALSE){
              $dataa = array('process_id' =>'1');
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
              $table='coex_extrusion_printing_wip';
              $data['coex_extrusion_printing_wip']=$this->coex_extrusion_printing_model->select_one_active_record_wip($table,$this->session->userdata['logged_in']['company_id'],'prt_wip_id',$prt_wip_id);
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
              $this->load->view('Home/footer');
            }else{
          
              if($this->input->post('to_process')=='8'){
                $data_scrap=array(
                  'company_id'       =>$this->session->userdata['logged_in']['company_id'],
                  'printing_id'      => $this->input->post('printing_id'),
                  'qc_id'            => $this->input->post('qc_id'),
                  'wip_id'           => $this->input->post('wip_id'),
                  'extrusion_date'   => $this->input->post('extrusion_date'),
                  'shift_id'         => $this->input->post('shift'),
                  'machine_id'       => $this->input->post('machine'),
                  'operator'         => $this->input->post('operator'),
                  'order_no'         => $this->input->post('order_no'),
                  'article_no'       => $this->input->post('article_no'),
                  'jobcard_no'       => $this->input->post('jobcard_no'),
                  'diameter'         => $this->input->post('diameter'),
                  'sleeve_weight_gm' => $this->input->post('sleeve_weight_gm'),
                  'length'           => $this->input->post('length'),                
                  'qty_scrap'        => $this->input->post('release_qty'),
                  'to_process'       => $this->input->post('to_process'),
                  'inspection_name'  => $this->input->post('inspection_name'),
                  'remark'           => $this->input->post('remark'),
                  'created_date'     => date('Y-m-d H:i:s'),
                  'archive'          => '0',
                  'status'           => '0',
                  'form_process'     => 'Printing WIP',
                  'user_id'          => $this->session->userdata['logged_in']['user_id']         
                );
                $result=$this->common_model->save('coex_extrusion_printing_wip_scrap',$data_scrap);

                }elseif($this->input->post('to_process')=='2'){
        
                $data_printing=array(
                  'company_id'       =>$this->session->userdata['logged_in']['company_id'],
                  'printing_id'      => $this->input->post('printing_id'),
                  'qc_id'            => $this->input->post('qc_id'),
                  'wip_id'           => $this->input->post('wip_id'), 
                  'release_date'     => $this->input->post('extrusion_date'),
                  'shift_id'         => $this->input->post('shift'),
                  'machine_id'       => $this->input->post('machine'),
                  'operator'         => $this->input->post('operator'),
                  'order_no'         => $this->input->post('order_no'),
                  'article_no'       => $this->input->post('article_no'),
                  'jobcard_no'       => $this->input->post('jobcard_no'),
                  'diameter'         => $this->input->post('diameter'),
                  'sleeve_weight_gm' => $this->input->post('sleeve_weight_gm'),
                  'length'           => $this->input->post('length'),                
                  'heading_qty'      => $this->input->post('release_qty'),
                  'to_process'       => $this->input->post('to_process'),
                  'release_by'       => $this->input->post('inspection_name'),
                  'remark'           => $this->input->post('remark'),
                  'created_date'     => date('Y-m-d H:i:s'),
                  'archive'          => '0',
                  'status'           => '0',
                  'form_process'     => 'Printing WIP',
                  'user_id'          => $this->session->userdata['logged_in']['user_id']         
                );
                $result=$this->common_model->save('coex_extrusion_heading',$data_printing);
                
              }elseif($this->input->post('to_process')=='6'){
        
                $data_capping=array(
                  'company_id'       =>$this->session->userdata['logged_in']['company_id'],
                  'printing_id'      => $this->input->post('printing_id'),
                  'qc_id'            => $this->input->post('qc_id'),
                  'wip_id'           => $this->input->post('wip_id'),
                  'extrusion_date'   => $this->input->post('extrusion_date'),
                  'shift_id'         => $this->input->post('shift'),
                  'machine_id'       => $this->input->post('machine'),
                  'operator'         => $this->input->post('operator'),
                  'order_no'         => $this->input->post('order_no'),
                  'article_no'       => $this->input->post('article_no'),
                  'jobcard_no'       => $this->input->post('jobcard_no'),
                  'sleeve_weight_gm' => $this->input->post('sleeve_weight_gm'),
                  'diameter'         => $this->input->post('diameter'),
                  'length'           => $this->input->post('length'),                
                  'capping_qty'      => $this->input->post('release_qty'),
                  'to_process'       => $this->input->post('to_process'),
                  'inspection_name'  => $this->input->post('inspection_name'),
                  'remark'           => $this->input->post('remark'),
                  'created_date'     => date('Y-m-d H:i:s'),
                  'archive'          => '0',
                  'status'           => '0',
                  'form_process'     => 'Printing WIP',
                  'user_id'          =>$this->session->userdata['logged_in']['user_id']         
                );
                $result=$this->common_model->save('coex_extrusion_capping',$data_capping);
        
              }else{
        
                $data_release_qc=array(
                  'company_id'       =>$this->session->userdata['logged_in']['company_id'],
                  'printing_id'      => $this->input->post('printing_id'),
                  'qc_id'            => $this->input->post('qc_id'),
                  'wip_id'           => $this->input->post('wip_id'),
                  'extrusion_date'   => $this->input->post('extrusion_date'),
                  'shift_id'         => $this->input->post('shift'),
                  'machine_id'       => $this->input->post('machine'),
                  'operator'         => $this->input->post('operator'),
                  'order_no'         => $this->input->post('order_no'),
                  'article_no'       => $this->input->post('article_no'),
                  'diameter'         => $this->input->post('diameter'),
                  'length'           => $this->input->post('length'),
                  'sleeve_weight_gm' => $this->input->post('sleeve_weight_gm'),
                  'jobcard_no'       => $this->input->post('jobcard_no'),
                  'production_qty'   => $this->input->post('ok_by_qc'),
                  'hold_by_qc'       => $this->input->post('release_qty'),
                  'inspection_name'  => $this->input->post('inspection_name'),
                  'remark'           => $this->input->post('remark'),
                  'created_date'     => date('Y-m-d'),
                  'archive'          => '0',
                  'status'           => '1',
                  'form_process'     => 'Return Printing WIP',
                  'user_id'          =>$this->session->userdata['logged_in']['user_id']         
                );
                  $result=$this->common_model->save('coex_extrusion_printing_qc',$data_release_qc);
                }

              $data_ce=array(
                  'release_date'     => $this->input->post('extrusion_date'),
                  'release_order_no' => $this->input->post('order_no'),
                  'ok_by_qc'         => $this->input->post('ok_by_qc'),
                  'status'           => '1'
              );
              
              $result=$this->common_model->update_one_active_record('coex_extrusion_printing_wip',$data_ce,'prt_wip_id',$this->input->post('wip_id'),$this->session->userdata['logged_in']['company_id']);

              $data['page_name']='Prodution';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
              $data['note']='Create Transaction Completed';
              $dataa = array('process_id' =>'1');
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
              $data['coex_extrusion_printing_wip']=$this->coex_extrusion_printing_model->select_one_active_record_wip('coex_extrusion_printing_wip',$this->session->userdata['logged_in']['company_id'],'coex_extrusion_printing_wip.prt_wip_id',$this->uri->segment(3));
             
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