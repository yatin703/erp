<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coex_extrusion_qc extends CI_Controller {

  function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('coex_extrusion_model');
      $this->load->model('fiscal_model');
    }else{
      redirect('login','refresh');
    }
  }

/*================== QC Pending ==================*/

  function index(){
    
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){
              $table='coex_extrusion';
              include('pagination_qc_pending.php');
              $data['total_pending'] = $this->coex_extrusion_model->count_pending();
              $data['coex_extrusion']=$this->coex_extrusion_model->select_active_records_pending_qc($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
              //echo $this->db->last_query();
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/active-records-pending',$data);
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

/*==================   QC Hold ==================*/

function pending(){
    
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){
              $table='coex_extrusion_qc';
              include('pagination_qc_hold.php');
              $data['total_hold'] = $this->coex_extrusion_model->count_hold();
              $data['coex_extrusion_qc']=$this->coex_extrusion_model->select_active_records_qc($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
                //echo $this->db->last_query();
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

/*==================   QC Released ==================*/

function released(){
    
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){
              $table='coex_extrusion_qc';
              include('pagination_qc_released.php');
              $data['total_realesed'] = $this->coex_extrusion_model->count_realesed();
              $data['coex_extrusion_qc']=$this->coex_extrusion_model->select_active_records_qc_released($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
                //echo $this->db->last_query();
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/active-records-released',$data);
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


/*==================   QC Hold Create ==================*/

function hold_qc(){

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
            $data['hold_qc']=$this->coex_extrusion_model->select_one_active_record_hold('coex_extrusion_qc',$this->session->userdata['logged_in']['company_id'],'coex_extrusion_qc.qc_id',$this->uri->segment(3));
            $data['defect']=$this->coex_extrusion_model->select_defect_model('coex_extrusion_defect');
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

 function save_qc(){

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
            $this->form_validation->set_rules('production_qty','Production QTY' ,'required|trim|xss_clean|is_natural|callback_production_qty_check');
            $this->form_validation->set_rules('ok_by_qc','Ok by QC' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('scrap_by_qc','Scrap by QC' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('inspection_name','Inspection Name' ,'required|trim|xss_clean');

            if($this->form_validation->run()==FALSE){
              $dataa = array('process_id' =>'1');
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
              $data['hold_qc']=$this->coex_extrusion_model->select_one_active_record_hold('coex_extrusion_qc',$this->session->userdata['logged_in']['company_id'],'coex_extrusion_qc.qc_id',$this->input->post('ceqc_id'));
              $data['defect']=$this->coex_extrusion_model->select_defect_model('coex_extrusion_defect');
        
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
              $this->load->view('Home/footer');
            }else{
              $cost=0;
              $purchase_price=0;
              $total_wip_qty=0;

              $jobcard_total_qty=$this->common_model->select_one_active_record('coex_extrusion_wip',$this->session->userdata['logged_in']['company_id'],'jobcard_no',$this->input->post('jobcard_no'));
              if($jobcard_total_qty==TRUE){
                foreach($jobcard_total_qty as $rowj){
                  $total_wip_qty+=$rowj->ok_by_qc;
                }
              }else{
                $total_wip_qty=0;
              }

             //echo $total_wip_qty;
              //echo "<br>";


            $data['jobcard_purchase_price']=$this->coex_extrusion_model->active_record_jobcard_purchase_price($this->input->post('jobcard_no'));
              foreach($data['jobcard_purchase_price'] as $price){
                 $purchase_price=$price->material_price;
              }

            $wip_jobcard_qty =$this->coex_extrusion_model->active_record_jobcard_qty_released_total($this->input->post('jobcard_no'));
            if($wip_jobcard_qty==TRUE){
              foreach($wip_jobcard_qty as $rowjj){
                $jobcard_qty = $rowjj->ok_qty;
              }
            }else{
                $jobcard_qty=0;
            }

            $total_qty = $total_wip_qty - $jobcard_qty;

            //echo $total_qty;
            //echo "<br>";

            $total = $total_qty + $this->input->post('ok_by_qc');

            //echo $total;
            //echo "<br>";

            $cost     = $purchase_price/$total;

            //echo $cost;
            //echo "<br>";die();
            //$cost  = $purchase_price/($this->input->post('ok_by_qc')+$total_wip_qty);

                        // echo "<br>";

                        // echo $cost;

                         // echo "<br>";

                        //$wip_cost = $row->total_qty*$cost;

              $data_wip=array(
                'company_id'       => $this->session->userdata['logged_in']['company_id'],
                'ce_id'            => $this->input->post('ce_id'),
                'qc_id'            => $this->input->post('ceqc_id'),
                'extrusion_date'   => $this->input->post('extrusion_date'),
                'shift_id'         => $this->input->post('shift'),
                'machine_id'       => $this->input->post('machine'),
                'operator'         => $this->input->post('operator'),
                'article_no'       => $this->input->post('article_no'),
                'jobcard_no'       => $this->input->post('jobcard_no'),
                'order_no'         => $this->input->post('order_no'),
                'diameter'         => $this->input->post('diameter'),
                'length'           => $this->input->post('length'),
                'layer_no'         => $this->input->post('layer_no'),
                'sleeve_weight_gm' => $this->input->post('sleeve_weight_gm'),                  
                'production_qty'   => $this->input->post('production_qty'),
                'ok_by_qc'         => $this->input->post('ok_by_qc'),
                'inspection_name'  => $this->input->post('inspection_name'),
                'remark'           => $this->input->post('remark'),
                'form_process'     => 'Extrusion QC',
                'user_id'          => $this->session->userdata['logged_in']['user_id'],
                'archive'          => '0',
                'created_date'     => date('Y-m-d'),
                'cost'             => $cost       
              );
              $result=$this->common_model->save('coex_extrusion_wip',$data_wip);
                
              $data_qc=array(
                'company_id'       =>$this->session->userdata['logged_in']['company_id'],
                'ce_id'            => $this->input->post('ce_id'),
                'ceqc_id'          => $this->input->post('ceqc_id'),
                'extrusion_date'   => $this->input->post('extrusion_date'),
                'shift_id'         => $this->input->post('shift'),
                'machine_id'       => $this->input->post('machine'),
                'operator'         => $this->input->post('operator'),
                'article_no'       => $this->input->post('article_no'),
                'jobcard_no'       => $this->input->post('jobcard_no'),
                'order_no'         => $this->input->post('order_no'),
                'diameter'         => $this->input->post('diameter'),
                'length'           => $this->input->post('length'),
                'layer_no'         => $this->input->post('layer_no'),
                'sleeve_weight_gm' => $this->input->post('sleeve_weight_gm'),
                'production_qty'   => $this->input->post('production_qty'),
                'hold_by_qc'       => $this->input->post('hold_by_qc'),
                'defect'           => ($this->input->post('defect')!='' ? implode(",",$this->input->post('defect')) : ''),
                'inspection_name'  => $this->input->post('inspection_name'),
                'remark'           => $this->input->post('remark'),
                'form_process'     => 'Extrusion QC',
                'user_id'          => $this->session->userdata['logged_in']['user_id'],
                'archive'          => '0',
                'created_date'     => date('Y-m-d')      
              );
              $result=$this->common_model->save('coex_extrusion_qc',$data_qc);
              
              $data_scrap=array(
                'company_id'       =>$this->session->userdata['logged_in']['company_id'],
                'ce_id'            => $this->input->post('ce_id'),
                'qc_id'            => $this->input->post('ceqc_id'),
                'extrusion_date'   => $this->input->post('extrusion_date'),
                'shift_id'         => $this->input->post('shift'),
                'machine_id'       => $this->input->post('machine'),
                'operator'         => $this->input->post('operator'),
                'article_no'       => $this->input->post('article_no'),
                'jobcard_no'       => $this->input->post('jobcard_no'),
                'order_no'         => $this->input->post('order_no'),
                'diameter'         => $this->input->post('diameter'),
                'length'           => $this->input->post('length'),
                'layer_no'         => $this->input->post('layer_no'),
                'sleeve_weight_gm' => $this->input->post('sleeve_weight_gm'),
                'production_qty'   => $this->input->post('production_qty'),
                'scrap_by_qc'      => $this->input->post('scrap_by_qc'),
                'inspection_name'  => $this->input->post('inspection_name'),
                'remark'           => $this->input->post('remark'),
                'form_process'     => 'Extrusion QC',
                'user_id'          =>$this->session->userdata['logged_in']['user_id'],
                'archive'          => '0',
                'created_date'     => date('Y-m-d')         
              );
              $result=$this->common_model->save('coex_extrusion_scrap',$data_scrap);
        
              $data_ce=array(
                'release_qty'   => $this->input->post('ok_by_qc'),
                'flag'          => '1'
              );
              $result=$this->common_model->update_one_active_record('coex_extrusion_qc',$data_ce,'qc_id',$this->input->post('ceqc_id'),$this->session->userdata['logged_in']['company_id']);
                    
              $data_job_cost=array(
                 'cost'   => $cost,
                 'cost_date'=> date('Y-m-d H:i:s')
              );
              $result=$this->common_model->update_one_active_record('coex_extrusion_wip',$data_job_cost,'jobcard_no',$this->input->post('jobcard_no'),$this->session->userdata['logged_in']['company_id']);

              $dataa = array('process_id' =>'1');
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
              $data['hold_qc']=$this->coex_extrusion_model->select_one_active_record_hold('coex_extrusion_qc',$this->session->userdata['logged_in']['company_id'],'coex_extrusion_qc.qc_id',$this->input->post('ceqc_id'));
              $data['defect']=$this->coex_extrusion_model->select_defect_model('coex_extrusion_defect');
              $data['page_name']='Prodution';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

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


/*==================   QC Search ==================*/

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
              
              $dataa = array('process_id' =>'1');
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              //$data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
             
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
                       
            if($this->form_validation->run()==FALSE){
              
              $dataa = array('process_id' =>'1');
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
              //$data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
              
               $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/active-records-search',$data);
              $this->load->view('Home/footer');
              
            }else{
                                            
              $data_search=array();

              if($this->input->post('sleeve_dia')!=''){
                $sleeve_dia_arr=explode("//", $this->input->post('sleeve_dia'));
                $data_search['diameter']=$sleeve_dia_arr[0];
              }
              if($this->input->post('length')!=''){                
                $data_search['length']=$this->input->post('length');
              }
              if($this->input->post('shift')!=''){                
                $data_search['shift_id']=$this->input->post('shift');
              }
              if($this->input->post('machine')!=''){                
                $data_search['machine_id']=$this->input->post('machine');
              }
              if($this->input->post('jobcard_no')!=''){
                $data_search['jobcard_no']=$this->input->post('jobcard_no');
              }
              if($this->input->post('order_no')!=''){
                $data_search['order_no']=$this->input->post('order_no');
              }
              if($this->input->post('article_no')!=''){
                $article_arr=explode("//",$this->input->post('article_no'));
                $data_search['article_no']=$article_arr[1];
              }
              if($this->input->post('flag')!=''){                
                $data_search['flag']=$this->input->post('flag');
              }
                           

              $data['coex_extrusion_qc']=$this->coex_extrusion_model->active_record_qc_search('coex_extrusion_qc',$this->session->userdata['logged_in']['company_id'],$data_search,$this->input->post('from_date'),$this->input->post('to_date')); 
              //echo $this->db->last_query(); 
        
              $dataa = array('process_id' =>'1');
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
               $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
               //$data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
              $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);                
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());               

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/active-records-search',$data);
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




  /*==================   QC Released Search ==================*/

function released_search(){    
    
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){
              
              $dataa = array('process_id' =>'1');
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              //$data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
             
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/released-search-form',$data);
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
  
  
  
  function released_search_result(){

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
                       
            if($this->form_validation->run()==FALSE){
              
              $dataa = array('process_id' =>'1');
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
              //$data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
              
               $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/released-search-form',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/active-records-released-search',$data);
              $this->load->view('Home/footer');
              
            }else{
                                            
              $data_search=array();

              if($this->input->post('sleeve_dia')!=''){
                $sleeve_dia_arr=explode("//", $this->input->post('sleeve_dia'));
                $data_search['diameter']=$sleeve_dia_arr[0];
              }
              if($this->input->post('length')!=''){                
                $data_search['length']=$this->input->post('length');
              }
              if($this->input->post('shift')!=''){                
                $data_search['shift_id']=$this->input->post('shift');
              }
              if($this->input->post('machine')!=''){                
                $data_search['machine_id']=$this->input->post('machine');
              }
              if($this->input->post('jobcard_no')!=''){
                $data_search['jobcard_no']=$this->input->post('jobcard_no');
              }
              if($this->input->post('order_no')!=''){
                $data_search['order_no']=$this->input->post('order_no');
              }
              if($this->input->post('article_no')!=''){
                $article_arr=explode("//",$this->input->post('article_no'));
                $data_search['article_no']=$article_arr[1];
              }
              if($this->input->post('flag')!=''){                
                $data_search['flag']=$this->input->post('flag');
              }
                           

              $data['coex_extrusion_qc']=$this->coex_extrusion_model->active_record_qc_released_search('coex_extrusion_qc',$this->session->userdata['logged_in']['company_id'],$data_search,$this->input->post('from_date'),$this->input->post('to_date')); 
              //echo $this->db->last_query(); 
        
              $dataa = array('process_id' =>'1');
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
               $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
               //$data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
              $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);                
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());               

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/released-search-form',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/active-records-released-search',$data);
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

/*==================   callback_production_qty_check ==================*/

  public function production_qty_check($str){
    $production_qty = $this->input->post('production_qty');
    $hold_by_qc     = $this->input->post('hold_by_qc');
    $ok_by_qc       = $this->input->post('ok_by_qc');
    $scrap_by_qc    = $this->input->post('scrap_by_qc');
    $total_qty      = $scrap_by_qc+$ok_by_qc+$hold_by_qc;
     
    if($production_qty < $total_qty){
    $this->form_validation->set_message('production_qty_check', 'The {field} does not match');
      return FALSE;
    }else if($production_qty > $total_qty){
    $this->form_validation->set_message('production_qty_check', 'The {field} does not match');
      return FALSE;
    }else{
      return TRUE;
    }    
  }

/*==================   QC Scrap ==================*/

  function hold_scrap(){
    
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){
              $table='coex_extrusion_scrap';
              include('pagination_qc_scrap.php');
              $data['total_hold_scrap'] = $this->coex_extrusion_model->count_hold_scrap();
              $data['coex_extrusion_scrap']=$this->coex_extrusion_model->select_active_records_scrap($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/active-records-scrap',$data);
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

/*==================   QC Scrap Search ==================*/

function scrap_search(){    
    
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){
              
              $dataa = array('process_id' =>'1');
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              //$data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
             
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form-scrap',$data);
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


function scrap_search_result(){

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
                       
            if($this->form_validation->run()==FALSE){
              
              $dataa = array('process_id' =>'1');
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
              //$data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
              
               $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/search-form-scrap',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/search-result-scrap',$data);
              $this->load->view('Home/footer');
              
            }else{
                                            
              $data_search=array();

              if($this->input->post('sleeve_dia')!=''){
                $sleeve_dia_arr=explode("//", $this->input->post('sleeve_dia'));
                $data_search['diameter']=$sleeve_dia_arr[0];
              }
              if($this->input->post('length')!=''){                
                $data_search['length']=$this->input->post('length');
              }
              if($this->input->post('shift')!=''){                
                $data_search['shift_id']=$this->input->post('shift');
              }
              if($this->input->post('machine')!=''){                
                $data_search['machine_id']=$this->input->post('machine');
              }
              if($this->input->post('jobcard_no')!=''){
                $data_search['jobcard_no']=$this->input->post('jobcard_no');
              }
              if($this->input->post('order_no')!=''){
                $data_search['order_no']=$this->input->post('order_no');
              }
              if($this->input->post('article_no')!=''){
                $article_arr=explode("//",$this->input->post('article_no'));
                $data_search['article_no']=$article_arr[1];
              }
              if($this->input->post('flag')!=''){                
                $data_search['flag']=$this->input->post('flag');
              }
                           

              $data['coex_extrusion_scrap']=$this->coex_extrusion_model->select_archive_records_scrap('coex_extrusion_scrap',$this->session->userdata['logged_in']['company_id'],$data_search,$this->input->post('from_date'),$this->input->post('to_date')); 
        
        
              //echo $this->db->last_query(); 
        
              $dataa = array('process_id' =>'1');
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
               $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              //$data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
              $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);                
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());               

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/search-form-scrap',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/search-result-scrap',$data);
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



/*================== QC Pending Create ==================*/

function qc_create(){

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
            $data['coex_extrusion']=$this->coex_extrusion_model->select_one_active_record('coex_extrusion',$this->session->userdata['logged_in']['company_id'],'coex_extrusion.ce_id',$this->uri->segment(3));
            $data['defect']=$this->coex_extrusion_model->select_defect_model('coex_extrusion_defect');
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
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

  function qc_save(){

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
            $this->form_validation->set_rules('production_qty','Production QTY' ,'required|trim|xss_clean|is_natural|callback_production_qty_check');
            $this->form_validation->set_rules('ok_by_qc','WIP QTY' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('hold_by_qc','Hold QTY' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('inspection_name','Inspection Name' ,'required|trim|xss_clean');
             $this->form_validation->set_rules('defect[]','QC Defect' ,'required|trim|xss_clean');

            if($this->form_validation->run()==FALSE){
              $dataa = array('process_id' =>'1');
            $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
            $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
            $data['coex_extrusion']=$this->coex_extrusion_model->select_one_active_record('coex_extrusion',$this->session->userdata['logged_in']['company_id'],'coex_extrusion.ce_id',$this->input->post('ce_id'));
            $data['defect']=$this->coex_extrusion_model->select_defect_model('coex_extrusion_defect');
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view('Loading/loading');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/qc-form',$data);
            $this->load->view('Home/footer');
            }else{

              $cost=0;
              $purchase_price=0;
              $total_wip_qty=0;

              $jobcard_total_qty=$this->common_model->select_one_active_record('coex_extrusion_wip',$this->session->userdata['logged_in']['company_id'],'jobcard_no',$this->input->post('jobcard_no'));
              if($jobcard_total_qty==TRUE){
                foreach($jobcard_total_qty as $rowj){
                  $total_wip_qty+=$rowj->ok_by_qc;
                }
              }else{
                $total_wip_qty=0;
              }

              //echo $total_wip_qty;
              //echo "<br>";


              $data['jobcard_purchase_price']=$this->coex_extrusion_model->active_record_jobcard_purchase_price($this->input->post('jobcard_no'));
                        foreach($data['jobcard_purchase_price'] as $price){
                           $purchase_price=$price->material_price;
                        }

                        $cost     = $purchase_price/($this->input->post('ok_by_qc')+$total_wip_qty);

                         //echo "<br>";

                        // echo $cost;

                          //echo "<br>";

                $data_wip=array(
                  'company_id'       => $this->session->userdata['logged_in']['company_id'],
                  'ce_id'            => $this->input->post('ce_id'),
                  'extrusion_date'   => $this->input->post('extrusion_date'),
                  'shift_id'         => $this->input->post('shift'),
                  'machine_id'       => $this->input->post('machine'),
                  'operator'         => $this->input->post('operator'),
                  'article_no'       => $this->input->post('article_no'),
                  'jobcard_no'       => $this->input->post('jobcard_no'),
                  'order_no'         => $this->input->post('order_no'),
                  'diameter'         => $this->input->post('diameter'),
                  'length'           => $this->input->post('length'),
                  'layer_no'         => $this->input->post('layer_no'),
                  'sleeve_weight_gm' => $this->input->post('sleeve_weight_gm'),                  
                  'production_qty'   => $this->input->post('production_qty'),
                  'ok_by_qc'         => $this->input->post('ok_by_qc'),
                  'inspection_name'  => $this->input->post('inspection_name'),
                  'remark'           => $this->input->post('remark'),
                  'form_process'     => 'Extrusion Production',
                  'user_id'          => $this->session->userdata['logged_in']['user_id'],
                  'archive'          => '0',
                  'created_date'     => date('Y-m-d'),
                  'cost'             => $cost       
                );
                $result=$this->common_model->save('coex_extrusion_wip',$data_wip);
                
                $data_qc=array(
                  'company_id'       => $this->session->userdata['logged_in']['company_id'],
                  'ce_id'            => $this->input->post('ce_id'),
                  'extrusion_date'   => $this->input->post('extrusion_date'),
                  'shift_id'         => $this->input->post('shift'),
                  'machine_id'       => $this->input->post('machine'),
                  'operator'         => $this->input->post('operator'),
                  'article_no'       => $this->input->post('article_no'),
                  'jobcard_no'       => $this->input->post('jobcard_no'),
                  'order_no'         => $this->input->post('order_no'),
                  'diameter'         => $this->input->post('diameter'),
                  'length'           => $this->input->post('length'),
                  'layer_no'         => $this->input->post('layer_no'),
                  'sleeve_weight_gm' => $this->input->post('sleeve_weight_gm'),
                  'production_qty'   => $this->input->post('production_qty'),
                  'hold_by_qc'       => $this->input->post('hold_by_qc'),
                  //'defect'           => implode(",",$this->input->post('defect')),
                  'defect'           => ($this->input->post('defect')!='' ? implode(",",$this->input->post('defect')) : ''),
                  'inspection_name'  => $this->input->post('inspection_name'),
                  'remark'           => $this->input->post('remark'),
                  'form_process'     => 'Extrusion Production',
                  'user_id'          => $this->session->userdata['logged_in']['user_id'],
                  'archive'          => '0',
                  'created_date'     => date('Y-m-d')         
                );        
                $result=$this->common_model->save('coex_extrusion_qc',$data_qc);
                
                $data_ce=array(
                    'qc_flag'=> '1',
                    'qc_date'=>date('Y-m-d'),
                    'qc_user_id'=> $this->session->userdata['logged_in']['user_id']
                );
                $result=$this->common_model->update_one_active_record('coex_extrusion',$data_ce,'ce_id',$this->input->post('ce_id'),$this->session->userdata['logged_in']['company_id']);

              $dataa = array('process_id' =>'1');
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
              $data['coex_extrusion']=$this->coex_extrusion_model->select_one_active_record('coex_extrusion',$this->session->userdata['logged_in']['company_id'],'coex_extrusion.ce_id',$this->input->post('ce_id'));
              $data['defect']=$this->coex_extrusion_model->select_defect_model('coex_extrusion_defect');
        
              $data['page_name']='Prodution';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $data['note']='Create Transaction Completed';
              header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/qc-form',$data);
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

/*==================   QC Pending Search ==================*/


function pending_search(){    
    
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    //echo $this->db->last_query();
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){

          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){
              
              $dataa = array('process_id' =>'1');
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              //$data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
             
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form-pending',$data);
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
  
  
  
  function search_result_pending(){

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
                       
            if($this->form_validation->run()==FALSE){
              
              $dataa = array('process_id' =>'1');
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
              //$data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
              
               $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form-pending',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-result-pending',$data);
              $this->load->view('Home/footer');
              
            }else{
                                            
              $data_search=array();

              if($this->input->post('sleeve_dia')!=''){
                $sleeve_dia_arr=explode("//", $this->input->post('sleeve_dia'));
                $data_search['diameter']=$sleeve_dia_arr[0];
              }
              if($this->input->post('length')!=''){                
                $data_search['length']=$this->input->post('length');
              }
              if($this->input->post('shift')!=''){                
                $data_search['shift_id']=$this->input->post('shift');
              }
              if($this->input->post('machine')!=''){                
                $data_search['machine_id']=$this->input->post('machine');
              }
              if($this->input->post('jobcard_no')!=''){
                $data_search['jobcard_no']=$this->input->post('jobcard_no');
              }
              if($this->input->post('order_no')!=''){
                $data_search['order_no']=$this->input->post('order_no');
              }
              if($this->input->post('article_no')!=''){
                $article_arr=explode("//",$this->input->post('article_no'));
                $data_search['article_no']=$article_arr[1];
              }
                           

              $data['coex_extrusion']=$this->coex_extrusion_model->active_record_search_pending_coex('coex_extrusion',$this->session->userdata['logged_in']['company_id'],$data_search,$this->input->post('from_date'),$this->input->post('to_date')); 
              //echo $this->db->last_query(); 
        
              $dataa = array('process_id' =>'1');
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
               $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
               //$data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
              $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);                
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());               

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/search-form-pending',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/search-result-pending',$data);
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

}