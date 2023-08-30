<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Springtube_printing_jobsetup_followup extends CI_Controller {

	function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('springtube_printing_jobsetup_followup_model');
       $this->load->model('springtube_printing_jobsetup_model');

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
            $data['followup_received']=$this->springtube_printing_jobsetup_followup_model->select_followup_received_records($table,$this->session->userdata['logged_in']['company_id'],'followup.user_id',$this->session->userdata['logged_in']['user_id'],'status','1','followup.form_id','74');

            
            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/received-records',$data);
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

            $jobcard_no=$this->uri->segment(3);
            $job_id=$this->uri->segment(4);
            $record_no=$this->uri->segment(3).'@@@'.$this->uri->segment(4);
            //$transaction_no=$this->uri->segment(5);

            $order_no='';
            $article_no='';

            $production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no', $jobcard_no);
              
            foreach($production_master_result as $row) {
              $order_no=$row->sales_ord_no;
              $article_no=$row->article_no;
            }

            $data=array('status'=>'99');
            $result=$this->common_model->update_one_active_record_where('followup',$data,'record_no',$record_no,'transaction_no',$this->uri->segment(5),$this->session->userdata['logged_in']['company_id']);

            $data=array('pending_flag'=>'1','final_approval_flag'=>'1','approval_date'=>date('Y-m-d'),'approved_by'=>$this->session->userdata['logged_in']['user_id']);

            $result=$this->common_model->update_one_active_record('springtube_printing_jobsetup_master',$data,'job_id',$job_id,$this->session->userdata['logged_in']['company_id']);

            if($result){

              $data_search=array('manu_order_no'=>$jobcard_no,'completed_flag'=>'0','from_printing_jobsetup'=>'1');

              $material_manufacturing_result=$this->common_model->select_active_records_where_order_by('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$data_search,'part_pos_no','asc');

              foreach ($material_manufacturing_result as $key => $material_manufacturing_row) {

                $pos_no='';
                $result_pos_no=$this->common_model->select_max_pkey_noncompany('reserved_quantity_manu','pos_no');
                if($result_pos_no){
                  foreach($result_pos_no as $result_pos_no_row){
                    $pos_no=$result_pos_no_row->pos_no;
                    $pos_no=$pos_no+1;
                  }
                }

                $data=array(
                  'company_id'=>$this->session->userdata['logged_in']['company_id'],
                  'manu_order_no'=>$jobcard_no,
                  'sales_order_no'=>$order_no,
                  'qty'=>$material_manufacturing_row->demand_qty,
                  'date_required'=>date('Y-m-d'),
                  'article_no'=>$material_manufacturing_row->article_no,
                  'pos_no'=>$pos_no,
                  'type_flag'=>2,
                  'total_qty'=>$material_manufacturing_row->demand_qty,
                  'rel_uom_id'=>'0',
                  'qty_rel'=>'0',
                  'amt_manual'=>'',
                  'document_no'=>'',
                  'calculated_purchase_price'=>'',
                  'voucher_no'=>'',
                  'plant_id'=>'3',
                  'created_annexure'=>'0',
                  'grn'=>'',
                  'ref_mm_id'=>$material_manufacturing_row->mm_id);

                $result_reserved_quantity_manu=$this->common_model->save('reserved_quantity_manu',$data);
                if($result_reserved_quantity_manu){

                   $quantity_decimal=($material_manufacturing_row->demand_qty!=0?$material_manufacturing_row->demand_qty/100:0);

                  //Jobcard to tally_material_issue_master ---------------------
                  $jobcard_tally=$jobcard_no.'/'.$order_no.'/'.$pos_no;
                  $data_tally=array('issue_date'=>date('Y-m-d'),
                               'jobcard_no'=>$jobcard_tally,
                               'part_no'=>$material_manufacturing_row->article_no,
                               'qty'=>$quantity_decimal,
                               'transaction_date'=>date('Y-m-d')
                              );

                  $result_tally_material_issue_master=$this->common_model->save('tally_material_issue_master',$data_tally);
                  //---------------------------------------------------------


                  $data_mat=array('completed_flag'=>'1');

                  $result=$this->common_model->update_one_active_record('material_manufacturing',$data_mat,'mm_id',$material_manufacturing_row->mm_id,$this->session->userdata['logged_in']['company_id']);
                
                }

              }

            }  

            $data['followup']=$this->common_model->select_one_active_record_nonlanguage_without_archive('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$record_no);

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
                        'form_id'=>'74',
                        'transaction_no'=>$transaction_no,
                        'status'=>'999',
                        'followup_date'=>date('Y-m-d'),
                        'approved_flag'=>'1',
                        'approval_date'=>date('Y-m-d'),
                        'contact_person_id'=>$this->session->userdata['logged_in']['user_id'],
                        'record_no'=>$record_no,
                        );
            $result=$this->common_model->save('followup',$data);

            $data['note']='Approval Transaction Completed';

            $data['followup_received']=$this->springtube_printing_jobsetup_followup_model->select_followup_received_records('followup',$this->session->userdata['logged_in']['company_id'],'followup.user_id',$this->session->userdata['logged_in']['user_id'],'status','1','followup.form_id','74');

            header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());

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
            $result=$this->common_model->update_one_active_record_where('followup',$data,'record_no',$this->uri->segment(3).'@@@'.$this->uri->segment(4),'transaction_no',$this->uri->segment(5),$this->session->userdata['logged_in']['company_id']);

            $data=array('pending_flag'=>'0');

            $result=$this->common_model->update_one_active_record('springtube_printing_jobsetup_master',$data,'job_id',$this->uri->segment(4),$this->session->userdata['logged_in']['company_id']);

            $data['followup']=$this->common_model->select_one_active_record_nonlanguage_without_archive('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$this->uri->segment(3).'@@@'.$this->uri->segment(4));

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
                        'form_id'=>'74',
                        'transaction_no'=>$transaction_no,
                        'status'=>'999',
                        'followup_date'=>date('Y-m-d'),
                        'approved_flag'=>'2',
                        'approval_date'=>date('Y-m-d'),
                        'contact_person_id'=>$this->session->userdata['logged_in']['user_id'],
                        'record_no'=>$this->uri->segment(3).'@@@'.$this->uri->segment(4),
                        );
            $result=$this->common_model->save('followup',$data);
            
            $data['note']='Rejected Transaction Completed';
            /*

            $data['employee']=$this->common_model->select_one_active_record('employee_master',$this->session->userdata['logged_in']['company_id'],'employee_id',$this->session->userdata['logged_in']['user_id']);

                      foreach ($data['employee'] as $employee_row) {
                        $config['protocol'] = 'smtp';
                        $config['smtp_host'] = 'ssl://smtp.googlemail.com';
                        $config['smtp_port'] = 465;
                        $this->load->library('email', $config);
                        $this->email->from($employee_row->mailbox);
                        $this->email->to("graphic@3dpackaging.in");
                        $this->email->cc($employee_row->mailbox);
                        $this->email->subject("Rejected ".$this->uri->segment(3)."_R".$this->uri->segment(4));
                        $this->email->message("Dear Graphics Team, The subjected artwork has been rejected");

                        if ($this->email->send()) {
                          $data['note']='Rejected Transaction Completed';
                        } 
                  }
                  */




            $data['followup_received']=$this->springtube_printing_jobsetup_followup_model->select_followup_received_records('followup',$this->session->userdata['logged_in']['company_id'],'followup.user_id',$this->session->userdata['logged_in']['user_id'],'status','1','followup.form_id','74');

             header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
            
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
  
  

}