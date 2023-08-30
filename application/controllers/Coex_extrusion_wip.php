<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coex_extrusion_wip extends CI_Controller {

  function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('coex_extrusion_model');
      $this->load->model('fiscal_model');
      $this->load->model('coex_extrusion_wip_scrap_model');
    }else{
      redirect('login','refresh');
    }
  }



/*========================= WIP ==============================*/

function index(){    
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){
              $table='coex_extrusion_wip';
              include('pagination_ce_wip.php');
              $data['coex_extrusion_wip']=$this->coex_extrusion_model->select_active_records_wip_($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
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

/*========================= WIP Create ==============================*/

function wip_release($cewip_id){       
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->new==1){

              $table='coex_extrusion_wip';
              $data['coex_extrusion_wip']=$this->coex_extrusion_model->select_one_active_record_wip($table,$this->session->userdata['logged_in']['company_id'],'cewip_id',$cewip_id);

              $dataa=array('process_id' =>'1');
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']); 

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/wip-release-form',$data);
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
            //$this->form_validation->set_rules('//','Qty' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ok_by_qc','WIP Qty' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('release_qty','Release Qty' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('to_process','To Process' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('inspection_name','Inspection Name' ,'required|trim|xss_clean');
            if($this->form_validation->run()==FALSE){
              $dataa = array('process_id' =>'1');
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
              $table='coex_extrusion_wip';
              $data['coex_extrusion_wip']=$this->coex_extrusion_model->select_one_active_record_wip($table,$this->session->userdata['logged_in']['company_id'],'cewip_id',$this->input->post('wip_id'));
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/wip-release-form',$data);
              $this->load->view('Home/footer');
            }else{


            $cost=0;
            $purchase_price=0;
            $total_wip_qty=0;
            
            if($this->input->post('to_process')=='4'  ||  $this->input->post('to_process')=='7'){          
        
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
                        
                          
                //echo $jobcard_qty;
                //echo "<br>";

                $wip_qty_rel = $this->input->post('release_qty') + $jobcard_qty;

                //echo $wip_qty_rel;
                //echo "<br>";

                $total_qty = $total_wip_qty- $wip_qty_rel;

                //echo $total_qty;
                //echo "<br>";

                $cost = $purchase_price/$total_qty;

                //$cost = $purchase_price/($total_wip_qty- $this->input->post('release_qty'));

                //echo $cost;
                //echo "<br>";die();
                
              }

            /*$jobcard_total_qty=$this->common_model->select_one_active_record('coex_extrusion_wip',$this->session->userdata['logged_in']['company_id'],'jobcard_no',$this->input->post('jobcard_no'));
            if($jobcard_total_qty==TRUE){
              foreach($jobcard_total_qty as $rowj){
                $total_wip_qty+=$rowj->ok_by_qc;
              }
            }else{
              $total_wip_qty=0;
            }*/

            //echo $total_wip_qty;
            //echo "<br>";

            /*$data['jobcard_purchase_price']=$this->coex_extrusion_model->active_record_jobcard_purchase_price($this->input->post('jobcard_no'));
                foreach($data['jobcard_purchase_price'] as $price){
                  $purchase_price=$price->material_price;
            }

            $cost     = $purchase_price/($total_wip_qty- $this->input->post('release_qty'));*/
            
            //echo "<br>";

            //echo $cost;

            //echo "<br>";die();

              if($this->input->post('to_process')=='4'){
                $data_scrap=array(
                'company_id'       =>$this->session->userdata['logged_in']['company_id'],
                'ce_id'            => $this->input->post('ce_id'),
                'qc_id'            => $this->input->post('qc_id'),
                'wip_id'           => $this->input->post('wip_id'),
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
                'scrap_qty'        => $this->input->post('release_qty'),
                'inspection_name'  => $this->input->post('inspection_name'),
                'remark'           => $this->input->post('remark'),
                'form_process'     => 'Extrusion WIP',
                'user_id'          => $this->session->userdata['logged_in']['user_id'],
                'status'           => '0',
                'archive'          => '0',
                'created_date'     => date('Y-m-d'),         
                );
                $result=$this->common_model->save('coex_extrusion_wip_scrap',$data_scrap);

                $data_wip=array(
                  'company_id'       =>$this->session->userdata['logged_in']['company_id'],
                  'ce_id'            => $this->input->post('ce_id'),
                  'qc_id'            => $this->input->post('qc_id'),
                  'wip_id'           => $this->input->post('wip_id'),
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
                  'production_qty'   => $this->input->post('ok_qty'),        
                  'ok_by_qc'         => $this->input->post('ok_by_qc'),
                  'inspection_name'  => $this->input->post('inspection_name'),
                  'remark'           => $this->input->post('remark'),
                  'form_process'     => 'Extrusion WIP',
                  'to_process'       => '',
                  'user_id'          => $this->session->userdata['logged_in']['user_id'],
                  'status'           => '0',
                  'archive'          => '0',
                  'created_date'     => date('Y-m-d'),         
                );

                $result=$this->common_model->save('coex_extrusion_wip',$data_wip);

                }elseif($this->input->post('to_process')=='2'){

                $data_heading=array(
                'company_id'       => $this->session->userdata['logged_in']['company_id'],
                'ce_id'            => $this->input->post('ce_id'),
                'qc_id'            => $this->input->post('qc_id'),
                'wip_id'           => $this->input->post('wip_id'),
                'extrusion_date'   => $this->input->post('extrusion_date'),
                'shift_id'         => $this->input->post('shift'),
                'machine_id'       => $this->input->post('machine'),
                'operator'         => $this->input->post('operator'),
                'article_no'       => $this->input->post('article_no'),
                'jobcard_no'       => $this->input->post('jobcard_no'),
                'order_no'         => $this->input->post('order_no'),
                'sleeve_weight_gm' => $this->input->post('sleeve_weight_gm'),
                'diameter'         => $this->input->post('diameter'),
                'length'           => $this->input->post('length'), 
                'layer_no'         => $this->input->post('layer_no'),
                'production_qty'   => $this->input->post('ok_by_qc'),               
                'heading_qty'      => $this->input->post('release_qty'),
                'inspector_name'   => $this->input->post('inspection_name'),
                'remark'           => $this->input->post('remark'),
                'form_process'     => 'Extrusion WIP',
                'to_process'       => '',
                'user_id'          => $this->session->userdata['logged_in']['user_id'],
                'status'           => '0',
                'archive'          => '0',
                'created_date'     => date('Y-m-d'),         
                );
                $result=$this->common_model->save('coex_extrusion_heading',$data_heading);

                $data_wip=array(
                  'company_id'       =>$this->session->userdata['logged_in']['company_id'],
                  'ce_id'            => $this->input->post('ce_id'),
                  'qc_id'            => $this->input->post('qc_id'),
                  'wip_id'           => $this->input->post('wip_id'),
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
                  'production_qty'   => $this->input->post('ok_qty'),        
                  'ok_by_qc'         => $this->input->post('ok_by_qc'),
                  'inspection_name'  => $this->input->post('inspection_name'),
                  'remark'           => $this->input->post('remark'),
                  'form_process'     => 'Extrusion WIP',
                  'to_process'       => '',
                  'user_id'          => $this->session->userdata['logged_in']['user_id'],
                  'status'           => '0',
                  'archive'          => '0',
                  'created_date'     => date('Y-m-d'),        
                  );
                $result=$this->common_model->save('coex_extrusion_wip',$data_wip);

                }elseif($this->input->post('to_process')=='3'){

                $data_printing=array(
                  'company_id'       =>$this->session->userdata['logged_in']['company_id'],
                  'ce_id'            => $this->input->post('ce_id'),
                  'qc_id'            => $this->input->post('qc_id'),
                  'wip_id'           => $this->input->post('wip_id'), 
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
                  'production_qty'   => $this->input->post('ok_by_qc'),
                  'printing_qty'     => $this->input->post('release_qty'),
                  'inspection_name'  => $this->input->post('inspection_name'),
                  'remark'           => $this->input->post('remark'),
                  'form_process'     => 'Extrusion WIP',
                  'to_process'       => '',
                  'user_id'          => $this->session->userdata['logged_in']['user_id'],
                  'status'           => '0',
                  'archive'          => '0',
                  'created_date'     => date('Y-m-d'),         
                );
                $result=$this->common_model->save('coex_extrusion_printing',$data_printing);

                $data_wip=array(
                  'company_id'       =>$this->session->userdata['logged_in']['company_id'],
                  'ce_id'            => $this->input->post('ce_id'),
                  'qc_id'            => $this->input->post('qc_id'),
                  'wip_id'           => $this->input->post('wip_id'),
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
                  'production_qty'   => $this->input->post('ok_qty'),        
                  'ok_by_qc'         => $this->input->post('ok_by_qc'),
                  'inspection_name'  => $this->input->post('inspection_name'),
                  'remark'           => $this->input->post('remark'),
                  'form_process'     => 'Extrusion WIP',
                  'to_process'       => '',
                  'user_id'          => $this->session->userdata['logged_in']['user_id'],
                  'status'           => '0',
                  'archive'          => '0',
                  'created_date'     => date('Y-m-d'),         
                  );
                $result=$this->common_model->save('coex_extrusion_wip',$data_wip);

                }else{

                $data_release_qc=array(
                  'company_id'       => $this->session->userdata['logged_in']['company_id'],
                  'ce_id'            => $this->input->post('ce_id'),
                  'ceqc_id'          => $this->input->post('qc_id'),
                  'wip_id'           => $this->input->post('wip_id'),
                  'extrusion_date'   => $this->input->post('extrusion_date'),
                  'shift_id'         => $this->input->post('shift'),
                  'machine_id'       => $this->input->post('machine'),
                  'operator'         => $this->input->post('operator'),
                  'order_no'         => $this->input->post('order_no'),
                  'article_no'       => $this->input->post('article_no'),
                  'diameter'         => $this->input->post('diameter'),
                  'length'           => $this->input->post('length'),
                  'layer_no'         => $this->input->post('layer_no'),
                  'sleeve_weight_gm' => $this->input->post('sleeve_weight_gm'),
                  'jobcard_no'       => $this->input->post('jobcard_no'),
                  'production_qty'   => $this->input->post('ok_by_qc'),
                  'hold_by_qc'       => $this->input->post('release_qty'),
                  'inspection_name'  => $this->input->post('inspection_name'),
                  'remark'           => $this->input->post('remark'),
                  'form_process'     => 'Extrusion WIP',
                  'to_process'       => '',
                  'user_id'          => $this->session->userdata['logged_in']['user_id'],
                  'flag'             => '0',
                  'archive'          => '0',
                  'created_date'     => date('Y-m-d'),
                  );
                $result=$this->common_model->save('coex_extrusion_qc',$data_release_qc);

                $data_wip=array(
                  'company_id'       =>$this->session->userdata['logged_in']['company_id'],
                  'ce_id'            => $this->input->post('ce_id'),
                  'qc_id'            => $this->input->post('qc_id'),
                  'wip_id'           => $this->input->post('wip_id'),
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
                  'production_qty'   => $this->input->post('ok_qty'),        
                  'ok_by_qc'         => $this->input->post('ok_by_qc'),
                  'inspection_name'  => $this->input->post('inspection_name'),
                  'remark'           => $this->input->post('remark'),
                  'form_process'     => 'Extrusion WIP',
                  'to_process'       => '',
                  'user_id'          => $this->session->userdata['logged_in']['user_id'],
                  'status'           => '0',
                  'archive'          => '0',
                  'created_date'     => date('Y-m-d'),
                           
                );
                $result=$this->common_model->save('coex_extrusion_wip',$data_wip);
              }


              $data_ce=array(
              'release_qty'        => $this->input->post('release_qty'),
              'release_date'       => date('Y-m-d'),
              'release_order_no'   => $this->input->post('order_no'), 
              'release_jobcard_no' => $this->input->post('jobcard_no'),                 
              'to_process'         => $this->input->post('to_process'),
              'status'             => '1',
              );
              
              $result=$this->common_model->update_one_active_record('coex_extrusion_wip',$data_ce,'cewip_id',$this->input->post('wip_id'),$this->session->userdata['logged_in']['company_id']);
              

              if($this->input->post('to_process')=='4'  || $this->input->post('to_process')=='7'){
                    
                  $data_job_cost=array(
                     'cost'          => $cost,
                     'cost_wip_date' => date('Y-m-d')
                  );

                  $result=$this->common_model->update_one_active_record('coex_extrusion_wip',$data_job_cost,'jobcard_no',$this->input->post('jobcard_no'),$this->session->userdata['logged_in']['company_id']);
              }else{

                $data_job_cost=array(
                     'cost'          => $this->input->post('cost'),
                     'cost_wip_date' => date('Y-m-d')
                  );

                  $result=$this->common_model->update_one_active_record('coex_extrusion_wip',$data_job_cost,'jobcard_no',$this->input->post('jobcard_no'),$this->session->userdata['logged_in']['company_id']);
              }
    
              

              $data['page_name']='Prodution';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
              $data['note']='Create Transaction Completed';
              $dataa = array('process_id' =>'1');
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
              $data['coex_extrusion_wip']=$this->coex_extrusion_model->select_one_active_record_wip('coex_extrusion_wip',$this->session->userdata['logged_in']['company_id'],'coex_extrusion_wip.cewip_id',$this->input->post('wip_id'));
             
              $data['note']='Create Transaction Completed';
              header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/wip-release-form',$data);
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


/*========================= WIP Search ==============================*/

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


              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
              
              $dataa = array('process_id' =>'1');
        
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
        
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);


              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

              $data_search=array('group'=>'PRODUCTION','archive'=>0);

               $in_arr=array();
               $data_search_1=array('status'=>'0');

              $data['coex_extrusion_wip']=$this->coex_extrusion_model->active_record_search_in('coex_extrusion_wip',$this->session->userdata['logged_in']['company_id'],$data_search_1,date('Y-m-d'),date('Y-m-d'),'','',$in_arr); 
             //echo $this->db->last_query();  
             
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
            $this->form_validation->set_rules('release_from_date','Release From Date','trim|xss_clean|exact_length[10]');
            $this->form_validation->set_rules('release_to_date','Release To Date','trim|xss_clean|exact_length[10]');
                       
            if($this->form_validation->run()==FALSE){

              $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              
             $dataa = array('process_id' =>'0');
        
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
        
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);

              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $in_arr=array();
              $data_search_1=array('status'=>'1');

              $data['coex_extrusion_wip']=$this->coex_extrusion_model->active_record_search_in('coex_extrusion_wip',$this->session->userdata['logged_in']['company_id'],$data_search_1,$this->input->post('from_date'),$this->input->post('to_date'),$this->input->post('release_from_date'),$this->input->post('release_to_date'),$in_arr); 

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/active-records-search',$data);
              $this->load->view('Home/footer');
            }else{              
              
              
              $data_search=array();
              if($this->input->post('shift')!=''){
                $data_search['shift_id']=$this->input->post('shift');
              }
              if($this->input->post('machine')!=''){
                $data_search['machine_id']=$this->input->post('machine');
              }
              if($this->input->post('sleeve_dia')!=''){
                $sleeve_dia_arr=explode("//", $this->input->post('sleeve_dia'));
                $data_search['diameter']=$sleeve_dia_arr[0];
              }
              if($this->input->post('length')!=''){
                $data_search['length']=$this->input->post('length');
              }
              if($this->input->post('jobcard_no')!=''){
                $data_search['jobcard_no']=$this->input->post('jobcard_no');
              }
              if($this->input->post('order_no')!=''){
                $data_search['order_no']=$this->input->post('order_no');
              }
              if($this->input->post('release_to_order_no')!=''){
                $data_search['release_order_no']=$this->input->post('release_to_order_no');
              }
              if($this->input->post('release_jobcard_no')!=''){
                $data_search['release_jobcard_no']=$this->input->post('release_jobcard_no');
              }
              if($this->input->post('article_no')!=''){
                $article_arr=explode("//",$this->input->post('article_no'));
                $data_search['article_no']=$article_arr[1];
              }
             
              $data['coex_extrusion_wip']=$this->coex_extrusion_model->active_record_search_in('coex_extrusion_wip',$this->session->userdata['logged_in']['company_id'],$data_search,$this->input->post('from_date'),$this->input->post('to_date'),$this->input->post('release_from_date'),$this->input->post('release_to_date')); 
             //echo $this->db->last_query();            

              $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);                
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);
              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              $dataa = array('process_id' =>'1');
        
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
        
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
               

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



  function search_wip_diawise(){    
    
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

              $from_date='2020-04-01';
              $to_date=date('Y-m-d');

              $data['from_date']=$from_date;
              $data['to_date']=$to_date;

              $data_search=array();
              $data['coex_extrusion_wip']=$this->coex_extrusion_model->wip_active_record_search_groupby('coex_extrusion_wip',$this->session->userdata['logged_in']['company_id'],$data_search,$from_date,$to_date);
             
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form-wip-diawise',$data);
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



  function search_result_wip_diawise(){

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
            $this->form_validation->set_rules('diameter','Diameter' ,'trim|xss_clean');
                       
            if($this->form_validation->run()==FALSE){

              $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form-wip-diawise',$data);
              $this->load->view('Home/footer');
            }else{                            
              
                $data_search=array();
                 if($this->input->post('diameter')!=''){
                  $data_search['diameter']=$this->input->post('diameter');
                }
             
                $data['coex_extrusion_wip']=$this->coex_extrusion_model->wip_active_record_search_groupby('coex_extrusion_wip',$this->session->userdata['logged_in']['company_id'],$data_search,$this->input->post('from_date'),$this->input->post('to_date')); 
             //echo $this->db->last_query();            

                $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);                
                $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
                $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/search-form-wip-diawise',$data);
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

  public function qty_check($str){
    $ok_qty        = $this->input->post('ok_qty');
    $release_qty  = $this->input->post('release_qty');
     
    if($ok_qty < $release_qty){
    $this->form_validation->set_message('qty_check', 'The {field} does not match');
      return FALSE;
    }else{
      return TRUE;
    }    
  }

  
/*========================= WIP Scrap ==============================*/

  function scrap(){    
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){
              $table='coex_extrusion_wip_scrap';
              include('coex_extrusion_pagination/pagination_wip_scrap.php');
              $data['coex_extrusion_wip_scrap']=$this->coex_extrusion_wip_scrap_model->select_active_records_wip($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);

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

/*========================= WIP Scrap Create ==============================*/

function return_scrap($scrap_id){       
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->new==1){

              $table='coex_extrusion_wip_scrap';
              $data['coex_extrusion_wip_scrap']=$this->coex_extrusion_wip_scrap_model->select_one_active_record_wip_scrap($table,$this->session->userdata['logged_in']['company_id'],'wip_scrap_id',$scrap_id);

              $dataa=array('process_id' =>'1');
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']); 

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form-wip-scrap',$data);
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

function return_scrap_wip(){
  $data['page_name']='Production';
  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Production'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){
            $this->form_validation->set_rules('release_date','Date' ,'required|trim|xss_clean|max_length[10]');
            $this->form_validation->set_rules('shift','Shift' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('machine','Machine' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('operator','Operator' ,'required|trim|xss_clean');        
            $this->form_validation->set_rules('order_no','Order No' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('article_no','Product No' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('jobcard_no','Jobcard No' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('sleeve_weight_gm','Sleeve Weight' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('diameter','Diameter' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('length','Length' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('ok_by_qc','Scrap Qty' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('release_qty','Release Qty' ,'required|trim|xss_clean');
            $this->form_validation->set_rules('release_by','Released By' ,'required|trim|xss_clean');
            if($this->form_validation->run()==FALSE){
              $dataa = array('process_id' =>'1');
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
              $table='coex_extrusion_wip_scrap';
              $data['coex_extrusion_wip_scrap']=$this->coex_extrusion_wip_scrap_model->select_one_active_record_wip_scrap($table,$this->session->userdata['logged_in']['company_id'],'wip_scrap_id',$this->input->post('wip_scrap_id'));
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form-wip-scrap',$data);
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

              //echo $jobcard_qty;
              //echo "<br>";
             
             $total_qty = $total_wip_qty - $jobcard_qty;

             //echo $total_qty;
              //echo "<br>";

            $total = $total_qty + $this->input->post('release_qty');
            
            //echo $Q;
            //echo "<br>";
            
            $cost     = $purchase_price/$total;

            //$cost     = $purchase_price/($total_wip_qty + $this->input->post('release_qty'));
            
            //echo "<br>";
            //echo $cost;
            //echo "<br>";die();

              $data_scrap=array(
                'company_id'=>$this->session->userdata['logged_in']['company_id'],
                'wip_scrap_id'=> $this->input->post('wip_scrap_id'),
                'ce_id'=> $this->input->post('ce_id'),
                'qc_id'=> $this->input->post('qc_id'),
                'wip_id'=> $this->input->post('wip_id'),
                'extrusion_date'   => $this->input->post('release_date'),
                'shift_id'=> $this->input->post('shift'),
                'machine_id'=> $this->input->post('machine'),
                'operator'=> $this->input->post('operator'),
                'order_no'=> $this->input->post('order_no'),
                'article_no'=> $this->input->post('article_no'),
                'jobcard_no'=> $this->input->post('jobcard_no'),
                'diameter'=> $this->input->post('diameter'),
                'sleeve_weight_gm'=> $this->input->post('sleeve_weight_gm'),
                'length'=> $this->input->post('length'), 
                'layer_no'=> $this->input->post('layer_no'),
                'production_qty'=> $this->input->post('ok_qty'),               
                'ok_by_qc'=> $this->input->post('release_qty'),                
                'to_process'=> ' ',
                'cost'   => $cost,
                'inspection_name'=> $this->input->post('release_by'),
                'remark'=> $this->input->post('remark'),
                'created_date'=>date('Y-m-d'),
                'archive'=> '0',
                'status'=> '0',
                'form_process'=> 'Extrusion WIP Scrap',
                'user_id'=>$this->session->userdata['logged_in']['user_id']         
              );
              
              $result=$this->common_model->save('coex_extrusion_wip',$data_scrap);

              $data_wip_scrap=array(
                'company_id'       =>$this->session->userdata['logged_in']['company_id'],
                'ce_id'            => $this->input->post('ce_id'),
                'qc_id'            => $this->input->post('qc_id'),
                'wip_id'           => $this->input->post('wip_id'),
                'extrusion_date'   => $this->input->post('release_date'),
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
                'scrap_qty'        => $this->input->post('release_qty'),
                'inspection_name'  => $this->input->post('release_by'),
                'remark'           => $this->input->post('remark'),
                'form_process'     => 'Extrusion WIP Scrap',
                'user_id'          => $this->session->userdata['logged_in']['user_id'],
                'status'           => '2',
                'archive'          => '0',
                'created_date'     => date('Y-m-d'),
                'release_date'     => $this->input->post('release_date'),
                'release_order_no' => $this->input->post('order_no'),         
              );
              $result=$this->common_model->save('coex_extrusion_wip_scrap',$data_wip_scrap);

              $data_wip_scrap=array(
                'company_id'       =>$this->session->userdata['logged_in']['company_id'],
                'ce_id'            => $this->input->post('ce_id'),
                'qc_id'            => $this->input->post('qc_id'),
                'wip_id'           => $this->input->post('wip_id'),
                'extrusion_date'   => $this->input->post('release_date'),
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
                'scrap_qty'        => $this->input->post('ok_by_qc'),
                'inspection_name'  => $this->input->post('release_by'),
                'remark'           => $this->input->post('remark'),
                'form_process'     => 'Extrusion WIP Scrap',
                'user_id'          => $this->session->userdata['logged_in']['user_id'],
                'status'           => '0',
                'archive'          => '0',
                'created_date'     => date('Y-m-d'),         
              );
              $result=$this->common_model->save('coex_extrusion_wip_scrap',$data_wip_scrap);
               
              $data_ce=array(                  
                  'status'           => '1',
              );
              
              $result=$this->common_model->update_one_active_record('coex_extrusion_wip_scrap',$data_ce,'wip_scrap_id',$this->input->post('wip_scrap_id'),$this->session->userdata['logged_in']['company_id']);

              $data_job_cost=array(
                 'cost'   => $cost,
                 'cost_wip_scrap_date'=> date('Y-m-d')
              );
              $result=$this->common_model->update_one_active_record('coex_extrusion_wip',$data_job_cost,'jobcard_no',$this->input->post('jobcard_no'),$this->session->userdata['logged_in']['company_id']);
              
              $data['page_name']='Prodution';

              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
              
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
              $data['note']='Create Transaction Completed';
              
              $dataa = array('process_id' =>'1');
              
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);

              $data['coex_extrusion_wip_scrap']=$this->coex_extrusion_model->select_one_active_record_wip('coex_extrusion_wip_scrap',$this->session->userdata['logged_in']['company_id'],'coex_extrusion_wip_scrap.wip_scrap_id',$this->input->post('wip_scrap_id'));

              $data['note']='Create Transaction Completed';
              //header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
              
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/create-form-wip-scrap',$data);
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

/*========================= WIP Scrap Search ==============================*/

public function search_wip_scrap(){
  $data['page_name']='Production';
  $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){ 
              
              $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

              $dataa = array('process_id' =>'1');
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);
              
              $data_search_1=array('status'=>'0');
              
              $in_arr=array();

              foreach ($data['account_periods_master'] as $key => $row) {
                  $from_date=$row->fin_year_start;
                  
               }

               $data['coex_extrusion_wip_scrap']=$this->coex_extrusion_wip_scrap_model->active_record_search_in('coex_extrusion_wip_scrap',$this->session->userdata['logged_in']['company_id'],$data_search_1,$from_date,date('Y-m-d'),'','',$in_arr); 

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title');
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form-wip-scrap',$data);
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


function search_result_wip_scrap(){

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
            $this->form_validation->set_rules('release_from_date','Release From Date','trim|xss_clean|exact_length[10]');
            $this->form_validation->set_rules('release_to_date','Release To Date','trim|xss_clean|exact_length[10]');
                       
            if($this->form_validation->run()==FALSE){
              
              $dataa = array('process_id' =>'1');
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);
              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

              $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

              $data['page_name']='Production';
              $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

               $data_search_1=array('status'=>'0');

              $data['coex_extrusion_wip_scrap']=$this->coex_extrusion_wip_scrap_model->active_record_search_in('coex_extrusion_wip_scrap',$this->session->userdata['logged_in']['company_id'],$data_search_1,$this->input->post('from_date'),$this->input->post('to_date'),$this->input->post('release_from_date'),$this->input->post('release_to_date')); 

              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/search-form-wip-scrap',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/active-records-wip-scrap',$data);
              $this->load->view('Home/footer');
            }else{              
              
              
              $data_search=array();
              if($this->input->post('shift')!=''){
                $data_search['shift_id']=$this->input->post('shift');
              }
              if($this->input->post('machine')!=''){
                $data_search['machine_id']=$this->input->post('machine');
              }
              if($this->input->post('sleeve_dia')!=''){
                $sleeve_dia_arr=explode("//", $this->input->post('sleeve_dia'));
                $data_search['diameter']=$sleeve_dia_arr[0];
              }
              if($this->input->post('length')!=''){
                $data_search['length']=$this->input->post('length');
              }
              if($this->input->post('jobcard_no')!=''){
                $data_search['jobcard_no']=$this->input->post('jobcard_no');
              }
              if($this->input->post('order_no')!=''){
                $data_search['order_no']=$this->input->post('order_no');
              }
              if($this->input->post('release_to_order_no')!=''){
                $data_search['release_order_no']=$this->input->post('release_to_order_no');
              }
              if($this->input->post('article_no')!=''){
                $article_arr=explode("//",$this->input->post('article_no'));
                $data_search['article_no']=$article_arr[1];
              }
              if($this->input->post('status')!=''){
                $data_search['status']=$this->input->post('status');
              }
             
              $data['coex_extrusion_wip_scrap']=$this->coex_extrusion_wip_scrap_model->active_record_search_in('coex_extrusion_wip_scrap',$this->session->userdata['logged_in']['company_id'],$data_search,$this->input->post('from_date'),$this->input->post('to_date'),$this->input->post('release_from_date'),$this->input->post('release_to_date')); 
             //echo $this->db->last_query();            

              $data['page_name']='Production';
                $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);                
              $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

              $data['account_periods_master']=$this->fiscal_model->select_current_financial_year('account_periods_master',$this->session->userdata['logged_in']['company_id']);

              $data['sleeve_dia']=$this->common_model->select_active_drop_down('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id']);

              $dataa = array('process_id' =>'1');
              $data['coex_machine_master']=$this->common_model->select_active_records_where('coex_machine_master',$this->session->userdata['logged_in']['company_id'],$dataa);
              $data['shift_master']=$this->common_model->select_active_drop_down('springtube_shift_master',$this->session->userdata['logged_in']['company_id']);


                $this->load->view('Home/header');
                $this->load->view('Home/nav',$data);
                $this->load->view('Home/subnav');
                $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/search-form-wip-scrap',$data);
                $this->load->view(ucwords($this->router->fetch_class()).'/active-records-wip-scrap',$data);
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



/*========================= WIP Release==============================*/

function wip_release_qty(){    
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){
              $table='coex_extrusion_wip';
              include('pagination_ce_wip.php');
              $data['coex_extrusion_wip']=$this->coex_extrusion_model->select_active_records_wip_($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
            //echo $this->db->last_query();
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/active-records-release',$data);
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


/*========================= WIP Release Active Record========================*/

function released(){    
    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
      foreach ($data['module'] as $module_row) {
        if($module_row->module_name==='Production'){
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());

          foreach ($data['formrights'] as $formrights_row) {
            if($formrights_row->view==1){
              $table='coex_extrusion_wip';
              include('coex_extrusion_pagination/pagination_wip_released.php');
              $data['coex_extrusion_wip']=$this->coex_extrusion_model->select_active_records_wip_released($config["per_page"],$this->uri->segment(3),$table,$this->session->userdata['logged_in']['company_id']);
            //echo $this->db->last_query();
              $this->load->view('Home/header');
              $this->load->view('Home/nav',$data);
              $this->load->view('Home/subnav');
              $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
              $this->load->view(ucwords($this->router->fetch_class()).'/active-records-wip-released',$data);
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










}