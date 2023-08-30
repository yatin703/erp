<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_order_followup extends CI_Controller {

	function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('sales_order_followup_model');

		}else{
			redirect('login','refresh');
		}
  }

  function index(){
  	$data['page_name']='Followup';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
    	if($module_row->module_name==='Followup'){
    		$data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],7,$this->router->fetch_class());

		  	foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->view==1){
            $table='followup';
            $data['followup_received']=$this->sales_order_followup_model->select_followup_received_records($table,$this->session->userdata['logged_in']['company_id'],'followup.user_id',$this->session->userdata['logged_in']['user_id'],'status','1','followup.form_id','75');

            $data['followup_sent']=$this->sales_order_followup_model->select_followup_received_records($table,$this->session->userdata['logged_in']['company_id'],'followup.contact_person_id',$this->session->userdata['logged_in']['user_id'],'status','1','followup.form_id','75');
            $this->db->last_query();

            $data['page_name']='Followup';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
            $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],7,$this->router->fetch_class());

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/received-records',$data);
            $data=array('followup.status'=>'999','followup.approved_flag'=>'2','followup.form_id'=>'75','followup.user_id'=>$this->session->userdata['logged_in']['user_id']);
            $order_by=array('followup.transaction_no'=>'desc');

            $data['followup_rejected']=$this->sales_order_followup_model->select_followup_rejected_records($table,$this->session->userdata['logged_in']['company_id'],$data,$order_by);
            $this->load->view(ucwords($this->router->fetch_class()).'/rejected-records',$data);
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


  function approved(){
    $data['page_name']='Followup';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Followup'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],7,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $data=array('status'=>'99');
            $result=$this->common_model->update_one_active_record_where('followup',$data,'record_no',$this->uri->segment(3),'transaction_no',$this->uri->segment(4),$this->session->userdata['logged_in']['company_id']);

            $data=array('final_approval_flag'=>'1','approval_date'=>date('Y-m-d'),'approved_by'=>$this->session->userdata['logged_in']['user_id']);

            $result=$this->common_model->update_one_active_record('order_master',$data,'order_no',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

            $data['followup']=$this->common_model->select_one_active_record_nonlanguage_without_archive('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$this->uri->segment(3));

            if($data['followup']==FALSE){
              $transaction_no=1;
              $status=1;
            }else{
              $i=1;
              foreach ($data['followup'] as $followup_row) {
               $transaction_no=$followup_row->transaction_no;
               $status=1;
               $contact_person_id=$followup_row->contact_person_id;
               $i++;
             }
             $transaction_no=$i;
            }
            $data=array(
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'user_id'=>$contact_person_id,
                        'form_id'=>'75',
                        'transaction_no'=>$transaction_no,
                        'status'=>'999',
                        'followup_date'=>date('Y-m-d'),
                        'approved_flag'=>'1',
                        'approval_date'=>date('Y-m-d'),
                        'contact_person_id'=>$this->session->userdata['logged_in']['user_id'],
                        'record_no'=>$this->uri->segment(3),
                        );
            $result=$this->common_model->save('followup',$data);
            $data['note']='Approval Transaction Completed';
            header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
            $data['followup_received']=$this->sales_order_followup_model->select_followup_received_records('followup',$this->session->userdata['logged_in']['company_id'],'followup.user_id',$this->session->userdata['logged_in']['user_id'],'status','1','followup.form_id','75');
            $data['followup_sent']=$this->sales_order_followup_model->select_followup_received_records('followup',$this->session->userdata['logged_in']['company_id'],'followup.contact_person_id',$this->session->userdata['logged_in']['user_id'],'status','1','followup.form_id','75');
            $data['page_name']='Followup';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
             $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],7,$this->router->fetch_class());
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/received-records',$data);
            $this->load->view('Home/footer');
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

  function notapproved(){
    $data['page_name']='Followup';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    if($data['module']!=FALSE){
    foreach ($data['module'] as $module_row) {
      if($module_row->module_name==='Followup'){
        $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],7,$this->router->fetch_class());

        foreach ($data['formrights'] as $formrights_row) {
          if($formrights_row->new==1){

            $data=array('status'=>'99');
            $result=$this->common_model->update_one_active_record_where('followup',$data,'record_no',$this->uri->segment(3),'transaction_no',$this->uri->segment(4),$this->session->userdata['logged_in']['company_id']);

            $data=array('pending_flag'=>'0');

            $result=$this->common_model->update_one_active_record('order_master',$data,'order_no',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

            $data['followup']=$this->common_model->select_one_active_record_nonlanguage_without_archive('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$this->uri->segment(3));

            if($data['followup']==FALSE){
              $transaction_no=1;
              $status=1;
            }else{
              $i=1;
              foreach ($data['followup'] as $followup_row) {
               $transaction_no=$followup_row->transaction_no;
               $status=1;
               $i++;
               $contact_person_id=$followup_row->contact_person_id;
             }
             $transaction_no=$i;
            }
            $data=array(
                        'company_id'=>$this->session->userdata['logged_in']['company_id'],
                        'user_id'=>$contact_person_id,
                        'form_id'=>'75',
                        'transaction_no'=>$transaction_no,
                        'status'=>'999',
                        'followup_date'=>date('Y-m-d'),
                        'approved_flag'=>'2',
                        'approval_date'=>date('Y-m-d'),
                        'contact_person_id'=>$this->session->userdata['logged_in']['user_id'],
                        'record_no'=>$this->uri->segment(3)
                        );
            $result=$this->common_model->save('followup',$data);

            $data['note']='Rejected Transaction Completed';
            header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
            $data['followup_received']=$this->sales_order_followup_model->select_followup_received_records('followup',$this->session->userdata['logged_in']['company_id'],'followup.user_id',$this->session->userdata['logged_in']['user_id'],'status','1','followup.form_id','75');
            $data['page_name']='Followup';
            $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
             $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],7,$this->router->fetch_class());
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/received-records',$data);
            $this->load->view('Home/footer');
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
  
  

}