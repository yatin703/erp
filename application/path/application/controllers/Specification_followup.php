<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Specification_followup extends CI_Controller {

	function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('specification_followup_model');
      $this->load->model('article_model');

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
            $data['followup_received']=$this->specification_followup_model->select_followup_received_records($table,$this->session->userdata['logged_in']['company_id'],'followup.user_id',$this->session->userdata['logged_in']['user_id'],'status','1','followup.form_id','985');

            $data['followup_sent']=$this->specification_followup_model->select_followup_received_records('followup',$this->session->userdata['logged_in']['company_id'],'followup.contact_person_id',$this->session->userdata['logged_in']['user_id'],'status','1','followup.form_id','985');

            $this->load->view('Home/header');
            $this->load->view('Home/nav',$data);
            $this->load->view('Home/subnav');
            $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
            $this->load->view(ucwords($this->router->fetch_class()).'/received-records',$data);

            $data=array('followup.status'=>'999','followup.approved_flag'=>'2','followup.form_id'=>'985','followup.user_id'=>$this->session->userdata['logged_in']['user_id']);
            $order_by=array('followup.transaction_no'=>'desc');

            //$data['followup_rejected']=$this->specification_followup_model->select_followup_rejected_records($table,$this->session->userdata['logged_in']['company_id'],$data,$order_by);
            //$this->load->view(ucwords($this->router->fetch_class()).'/rejected-records',$data);
            
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
			
			$test_string=substr($this->uri->segment(3),0,5); 

            $data=array('status'=>'99');
            $result=$this->common_model->update_one_active_record_where('followup',$data,'record_no',$this->uri->segment(3).'@@@'.$this->uri->segment(4),'transaction_no',$this->uri->segment(5),$this->session->userdata['logged_in']['company_id']);
			
			// if(strtoupper($test_string)=='FSPEC'){
				
			// 	$data=array('pending_flag'=>'1','final_approval_flag'=>'0','approval_date'=>date('Y-m-d'),'approved_by'=>$this->session->userdata['logged_in']['user_id']);

			// 	$result=$this->common_model->update_one_active_record_where('specification_sheet',$data,'spec_id',$this->uri->segment(3),'spec_version_no',$this->uri->segment(4),$this->session->userdata['logged_in']['company_id']);

   //      $config['protocol'] = 'smtp';
   //      $config['smtp_host'] = 'ssl://smtp.googlemail.com';
   //      $config['smtp_port'] = 465;
   //      $this->load->library('email', $config);
   //      $this->email->from("sales@3d-neopac.com");
   //      $this->email->to("pravin.naik@3dpackaging.in");
   //      $this->email->cc("eknath.parkhe@3d-neopac.com");
   //      $this->email->subject("Approval request for film specification no".$this->uri->segment(3)."_R".$this->uri->segment(4));
   //      $this->email->message("Dear Pravin Naik, We have created subjected Film specification in System, Please provide your approval on the same.");

   //      if ($this->email->send()) {

   //        $data['note']='Email send!';
   //      }


			// }
   //    else{
				$data=array('pending_flag'=>'1','final_approval_flag'=>'1','approval_date'=>date('Y-m-d'),'approved_by'=>$this->session->userdata['logged_in']['user_id']);

				$result=$this->common_model->update_one_active_record_where('specification_sheet',$data,'spec_id',$this->uri->segment(3),'spec_version_no',$this->uri->segment(4),$this->session->userdata['logged_in']['company_id']);
			//}
            
           // $result=$this->common_model->update_one_active_record_where('spring_specification_sheet',$data,'spec_id',$this->uri->segment(3),'spec_version_no',$this->uri->segment(4),$this->session->userdata['logged_in']['company_id']);
            

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
                        'form_id'=>'985',
                        'transaction_no'=>$transaction_no,
                        'status'=>'999',
                        'followup_date'=>date('Y-m-d'),
                        'approved_flag'=>'1',
                        'approval_date'=>date('Y-m-d'),
                        'contact_person_id'=>$this->session->userdata['logged_in']['user_id'],
                        'record_no'=>$this->uri->segment(3).'@@@'.$this->uri->segment(4),
                        );
            $result=$this->common_model->save('followup',$data);
            $data['note']='Approval Transaction Completed';

          //CAP from ERP to Tally on 11-June 2019  by Eknath---------- 
            $spec_id=$this->uri->segment(3);
            $spec_version_no=$this->uri->segment(4);
            $this->cap_erp_to_tally($spec_id,$spec_version_no);
          //-----------------------------------------------------------  

            //header("refresh:1;url=".base_url()."index.php/".$this->router->fetch_class());
            $data['followup_received']=$this->specification_followup_model->select_followup_received_records('followup',$this->session->userdata['logged_in']['company_id'],'followup.user_id',$this->session->userdata['logged_in']['user_id'],'status','1','followup.form_id','985');
            $data['followup_sent']=$this->specification_followup_model->select_followup_received_records('followup',$this->session->userdata['logged_in']['company_id'],'followup.contact_person_id',$this->session->userdata['logged_in']['user_id'],'status','1','followup.form_id','985');
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

            $result=$this->common_model->update_one_active_record_where('specification_sheet',$data,'spec_id',$this->uri->segment(3),'spec_version_no',$this->uri->segment(4),$this->session->userdata['logged_in']['company_id']);

            

            //$result=$this->common_model->update_one_active_record_where('spring_specification_sheet',$data,'spec_id',$this->uri->segment(3),'spec_version_no',$this->uri->segment(4),$this->session->userdata['logged_in']['company_id']);

            

            $data['followup']=$this->common_model->select_one_active_record_nonlanguage_without_archive('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$this->uri->segment(3).'@@@'.$this->uri->segment(4));

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
                        'form_id'=>'985',
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
            $data['followup_received']=$this->specification_followup_model->select_followup_received_records('followup',$this->session->userdata['logged_in']['company_id'],'followup.user_id',$this->session->userdata['logged_in']['user_id'],'status','1','followup.form_id','985');
            $data['followup_sent']=$this->specification_followup_model->select_followup_received_records('followup',$this->session->userdata['logged_in']['company_id'],'followup.contact_person_id',$this->session->userdata['logged_in']['user_id'],'status','1','followup.form_id','985');
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

  
 

public function cap_erp_to_tally($spec_id,$spec_version_no){

    if($spec_id!='' && $spec_version_no!=''){
      $article_no='';
      $data=array('spec_id'=>$spec_id,'spec_version_no'=>$spec_version_no);
      $specification_sheet_result=$this->common_model->select_active_records_where('specification_sheet',$this->session->userdata['logged_in']['company_id'],$data);
        
        foreach($specification_sheet_result as  $specification_sheet_row) {
          $arr=explode("|",$specification_sheet_row->dyn_qty_present);
          if($arr[0]=='CAP'){

              $article_no=$specification_sheet_row->article_no;
              if($article_no!=''){
              
                //tally Item Master to Ledger master SQl Integration---------
                  //$name='';
                //$part_no='';
                $description='';
                  //$under_group='';
                  $units='';
                $maintain_in_batches='No'; 
                $date_of_manufacturing=''; 
                $expiry_date=''; 
                $gst_applicable='Applicable'; 
                $hsn_no=''; 
                $hsn_description='';  
                $calculation_type='On Value';  
                $taxability='Taxable';
                $igst='18';
                $cgst='9';  
                $utgst='9';
                $cess='';
                $type_of_supply='Goods';
                $status=''; 
                $remarks='';
                $transaction_date=date('Y-m-d');

                $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$article_no);
                foreach($data['article'] as $article_row){
                  $name=$article_row->article_name;
                  $units=$article_row->uom;
                }
                $data=array('name'=>$name, 
                      'part_no'=>$article_no,
                      'description'=>$description,
                      'under_group'=>'CAPS',
                      'units'=>$units,
                      'maintain_in_batches'=>$maintain_in_batches,
                      'date_of_manufacturing'=>$date_of_manufacturing, 
                      'expiry_date'=>$expiry_date, 
                      'gst_applicable'=>$gst_applicable,
                      'hsn_no'=>$hsn_no,
                      'hsn_description'=>$hsn_description,  
                      'calculation_type'=>$calculation_type, 
                      'taxability'=>$taxability,
                      'igst'=>$igst,
                      'cgst'=>$cgst,
                      'utgst'=>$utgst,
                      'cess'=>$cess,
                      'type_of_supply'=>$type_of_supply,                          
                      'transaction_date'=>$transaction_date

                      );  

                $result=$this->common_model->save('tally_stock_items_master',$data);  
                 //----------------------------------------------------------------- 


              }

          }

        }

    }

  }

  

}