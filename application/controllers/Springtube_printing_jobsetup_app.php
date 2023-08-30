<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/ImplementJWT.php';
class Springtube_printing_jobsetup_app extends CI_Controller {

	function __construct(){
    parent::__construct(); 

      
      $this->load->model('common_model');
      $this->load->model('springtube_printing_jobsetup_followup_model');
      $this->load->model('springtube_printing_jobsetup_model');
      $this->objOfJwt= new ImplementJWT();

  }


  function approved($token){

    //if(!empty($token)){

      $data_token=$this->objOfJwt->DecodeToken($token);   

      echo $jobcard_no=$data_token['jobcard_no'];
      echo $job_id=$data_token['job_id'];
      echo $record_no=$jobcard_no.'@@@'.$job_id;
      echo $approving_user=$data_token['user_id'];
      //$transaction_no=$data_token['transaction_no'];
    if($jobcard_no!='' && $job_id!='' && $record_no!='' && $approving_user!=''){
      
      $data_jobid=array('job_id'=>$job_id,'final_approval_flag'=>'0','pending_flag'=>'1','archive'=>0);

      $springtube_printing_jobsetup_master_result=$this->common_model->select_active_records_where('springtube_printing_jobsetup_master',$data_token['company_id'],$data_jobid);

      if($springtube_printing_jobsetup_master_result){

        $order_no='';
        $article_no='';

        $production_master_result=$this->common_model->select_one_active_record('production_master',$data_token['company_id'],'mp_pos_no', $jobcard_no);
          
        foreach($production_master_result as $row) {
          $order_no=$row->sales_ord_no;
          $article_no=$row->article_no;
        }

        $data=array('status'=>'99');
        $result=$this->common_model->update_one_active_record_where('followup',$data,'record_no',$record_no,'transaction_no',$data_token['transaction_no'],$data_token['company_id']);

        $data=array('pending_flag'=>'1','final_approval_flag'=>'1','approval_date'=>date('Y-m-d'),'approved_by'=>$approving_user);

        $result=$this->common_model->update_one_active_record('springtube_printing_jobsetup_master',$data,'job_id',$job_id,$data_token['company_id']);

        if($result){

          $data_search=array('manu_order_no'=>$jobcard_no,'completed_flag'=>'0','from_printing_jobsetup'=>'1');

          $material_manufacturing_result=$this->common_model->select_active_records_where_order_by('material_manufacturing',$data_token['company_id'],$data_search,'part_pos_no','asc');

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
              'company_id'=>$data_token['company_id'],
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

              $result=$this->common_model->update_one_active_record('material_manufacturing',$data_mat,'mm_id',$material_manufacturing_row->mm_id,$data_token['company_id']);
            
            }

          }

        }  

        $data['followup']=$this->common_model->select_one_active_record_nonlanguage_without_archive('followup',$data_token['company_id'],'record_no',$record_no);

        $contact_person_id='';

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
                    'company_id'=>$data_token['company_id'],
                    'user_id'=>$contact_person_id,
                    'form_id'=>'74',
                    'transaction_no'=>$transaction_no,
                    'status'=>'999',
                    'followup_date'=>date('Y-m-d'),
                    'approved_flag'=>'1',
                    'approval_date'=>date('Y-m-d'),
                    'contact_person_id'=>$approving_user,
                    'record_no'=>$record_no,
                    );
        $result=$this->common_model->save('followup',$data);

        echo 'Approval Transaction Completed';
      // Email Setup--------------------------------------------------------------

        $smtp_user=$this->config->item('smtp_user');
        $smtp_pass=$this->config->item('smtp_pass');
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.googlemail.com';
        $config['smtp_port'] = 465;
        $config['smtp_timeout'] = 60;
        $config['charset'] = 'utf-8';
        $config['mailtype'] = 'html';
        $config['validation'] = 'TRUE';
        // $config['smtp_user']=$smtp_user;
        // $config['smtp_pass']=$smtp_pass;
        $config['smtp_user']='auto.mailer@3d-neopac.com';
        $config['smtp_pass']='auto@202021';
        
        $this->load->library('email', $config);
        //$this->email->from($employee_row->mailbox);
        //$this->email->from('eknath.parkhe@3d-neopac.com');
        $this->email->from('auto.mailer@3d-neopac.com');
        //$this->email->to("eknath.parkhe@3d-neopac.com");
        $this->email->to("springprint@3d-neopac.com");
        $this->email->cc("eknath.parkhe@3d-neopac.com");
        $this->email->cc("pravin.shinde@3d-neopac.com");
        $this->email->subject("Approved Spring Printing Jobsetup :-".$jobcard_no);
        $this->email->message("Approved Spring Printing Jobsetup :-".$jobcard_no);
        $this->email->set_mailtype("html");

        if ($this->email->send()) {
          echo 'Email send succesfully!';          
        } 
        else{
          echo 'Email send failed!';         

        }



        }else{

          echo 'Approval already done.';

        }        

    }else{

      echo 'Incorrect Fields';
    }    
            

           
  
  }

  function notapproved($token){

    if(!empty($token)){

      $data_token=$this->objOfJwt->DecodeToken($token);

      $jobcard_no=$data_token['jobcard_no'];
      $job_id=$data_token['job_id'];
      $record_no=$jobcard_no.'@@@'.$job_id;

      $data_jobid=array('job_id'=>$data_token['job_id'],'final_approval_flag'=>0,'pending_flag'=>1,'archive'=>0);

      $springtube_printing_jobsetup_master_result=$this->common_model->select_active_records_where('springtube_printing_jobsetup_master',$data_token['company_id'],$data_jobid);

      if($springtube_printing_jobsetup_master_result){

          $data=array('status'=>'99');
          $result=$this->common_model->update_one_active_record_where('followup',$data,'record_no',$record_no,'transaction_no',$data_token['transaction_no'],$data_token['company_id']);

          $data1=array('pending_flag'=>'0');

          $result=$this->common_model->update_one_active_record('springtube_printing_jobsetup_master',$data1,'job_id',$data_token['job_id'],$data_token['company_id']);

          $data['followup']=$this->common_model->select_one_active_record_nonlanguage_without_archive('followup',$data_token['company_id'],'record_no',$record_no);

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
                      'company_id'=>$data_token['company_id'],
                      'user_id'=>$contact_person_id,
                      'form_id'=>'74',
                      'transaction_no'=>$transaction_no,
                      'status'=>'999',
                      'followup_date'=>date('Y-m-d'),
                      'approved_flag'=>'2',
                      'approval_date'=>date('Y-m-d'),
                      'contact_person_id'=>$data_token['user_id'],
                      'record_no'=>$record_no,
                      );
          $result=$this->common_model->save('followup',$data);
          
          echo 'Rejected Transaction Completed';
          // Email Setup--------------------------------------------------------------
          
          $smtp_user=$this->config->item('smtp_user');
          $smtp_pass=$this->config->item('smtp_pass');
          $config['protocol'] = 'smtp';
          $config['smtp_host'] = 'ssl://smtp.googlemail.com';
          $config['smtp_port'] = 465;
          $config['smtp_timeout'] = 60;
          $config['charset'] = 'utf-8';
          $config['mailtype'] = 'html';
          $config['validation'] = 'TRUE';
          // $config['smtp_user']=$smtp_user;
          // $config['smtp_pass']=$smtp_pass;

          //echo'<script> var email= prompt("Enter your e=Email id");</script>';
          //$email='<script>document.write(email);</script>';

          //echo'<script> var password= prompt("Enter the Email Password");</script>';          
          //$password='<script>document.write(password);</script>';

          $emailContent = '<!DOCTYPE>
      <html>
      <head><title>Springtube Printing Jobsetup</title>      
        <style>
          body {
            border: 1px solid #008ae6;
            text-color:black;
            width: 100%;
            cellpadding:2px;
            cellspacing:0;
            font-size:10px;
            font-style:verdana;
          }         
        </style></head>
      <body>
    <table width="100%">
          <tr>
            <th colspan="10"><b>';
          
         echo'<script> var comment= prompt("Enter the comment");</script>';          
         $comments='<script>document.write(comment);</script>';

          $emailContent.=$comments;
          $emailContent.='</b>
            </th>
          </tr>
          </table>
          </body>
          </html>';


          $config['smtp_user']='auto.mailer@3d-neopac.com';
          $config['smtp_pass']='auto@202021';
          
          $this->load->library('email', $config);
          //$message='<script type="text/JavaScript">  
                //prompt("Please Enter comment"); 
              //</script>';

          //$this->email->from($employee_row->mailbox);
          //$this->email->from('eknath.parkhe@3d-neopac.com');
          $this->email->from('auto.mailer@3d-neopac.com');
          //$this->email->to("eknath.parkhe@3d-neopac.com");
          $this->email->to("springprint@3d-neopac.com");
          $this->email->cc("eknath.parkhe@3d-neopac.com");
          $this->email->cc("pravin.shinde@3d-neopac.com");
          $this->email->subject("Rejected Spring Printing Jobsetup :-".$jobcard_no);
          $this->email->message($emailContent);
          $this->email->set_mailtype("html");

          if ($this->email->send()) {
            echo 'Email send succesfully!';          
          } 
          else{
            echo 'Email send failed!';         

          }
        

      }else{

          echo 'Already Rejected!';
      }

          

    }else{

      echo'Error!';

    }

            
  
  }
  
  

}