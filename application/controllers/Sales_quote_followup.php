<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_quote_followup extends CI_Controller {

  function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in')){
      $this->load->model('common_model');
      $this->load->model('sales_quote_followup_model');
      $this->load->model('sales_quote_model');
      $this->load->model('article_model');
      $this->load->model('process_model');

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
            $data['followup_received']=$this->sales_quote_followup_model->select_followup_received_records($table,$this->session->userdata['logged_in']['company_id'],'followup.user_id',$this->session->userdata['logged_in']['user_id'],'status','1','followup.form_id','91');

            
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

            $data=array('status'=>'99');
            $result=$this->common_model->update_one_active_record_where('followup',$data,'record_no',$this->uri->segment(3),'transaction_no',$this->uri->segment(4),$this->session->userdata['logged_in']['company_id']);

            $data=array('pending_flag'=>'1','final_approval_flag'=>'1','approval_date'=>date('Y-m-d'),'approved_by'=>$this->session->userdata['logged_in']['user_id']);

            $result=$this->common_model->update_one_active_record('sales_quote_master',$data,'quotation_no',$this->uri->segment(3),$this->session->userdata['logged_in']['company_id']);

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
                        'form_id'=>'91',
                        'transaction_no'=>$transaction_no,
                        'status'=>'999',
                        'followup_date'=>date('Y-m-d'),
                        'approved_flag'=>'1',
                        'approval_date'=>date('Y-m-d'),
                        'contact_person_id'=>$this->session->userdata['logged_in']['user_id'],
                        'record_no'=>$this->uri->segment(3)
            );
            $result=$this->common_model->save('followup',$data);

            $data['note']='Approval Transaction Completed';

            $data['employee']=$this->common_model->select_one_active_record('employee_master',$this->session->userdata['logged_in']['company_id'],'employee_id',$this->session->userdata['logged_in']['user_id']);

                      foreach ($data['employee'] as $employee_row) {
                         $filename = base_url('assets/img/logo.png');
                        $config['protocol'] = 'smtp';
                        $config['smtp_host'] = 'ssl://smtp.googlemail.com';
                        $config['smtp_port'] = 465;
                        $this->load->library('email', $config);
                        $this->email->from("auto.mailer@3d-neopac.com");
                        $this->email->to("pravin.shinde@3d-neopac.com");
                        $this->email->cc('');
                        $this->email->subject("".$this->uri->segment(3).' REV'.$this->uri->segment(4)." is approve");
                        $cid = $this->email->attachment_cid($filename);
                       

                        $data['sales_quote_master']=$this->sales_quote_model->select_one_active_record_where('sales_quote_master',$this->session->userdata['logged_in']['company_id'],'sales_quote_master.quotation_no',$this->uri->segment(3),'sales_quote_revision.version_no',$this->uri->segment(4));

                        foreach ($data['sales_quote_master'] as $sales_quote_master_row)
                        {
                          $email_content = '<!DOCTYPE>
                                    <html>
                                    <head><title>SALES QUOTE</title>
                                      <style>
                                        table {
                                          border:1px solid #ddd;
                                          border-collapse:collapse;
                                          font-size:10px;
                                          width:100%;
                                          color:black;
                                          font-family:verdana;
                                        }

                                        th {

                                          border:1px solid #ddd;
                                          text-align: left;
                                          background-color:#DFFCFC;
                                          font-weight:bold;
                                          font-size:11px;
                                        }

                                        td {
                                          border:1px solid #ddd;
                                          text-align: left;            
                                          font-size:11px;
                                        }        
                                        
                                      </style>
                                    </head>         
                                    <body>';
                                  $email_content.="<div style='font-family:verdana;border:1px solid #ddd;padding:10px;width:900px;'>
                    <div style='text-align:center;'>
                    <img src='cid:".$cid."' style='max-width:130px;height:30px;'><br/>
                    <span style='font-size:10px;'><b>3D TECHNOPACK PVT LTD</b><br/>
                    SURVEY NO 8/1, VILLAGE ATHAL, SILVASSA, DADRA NAGAR HAVELI, PIN : 396230, INDIA</span>
                    </div>
                  </br>
                  <div style='text-align:center;padding:15px;font-size:10px;'><span style='background-color:black;padding:4px;color:white;font-weight:bold;'>SALES QUOTE</span><br/><br>";
                                   
                                   $email_content.='

                                    <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9">
                                      <tr class="heading">
                                          <th width="15%"><b>QUOTE NO</td>
                                          <th width="1%"></td>
                                          <th width="34%" style="border-right:1px solid #D9d9d9"><b>'.$sales_quote_master_row->quotation_no.' </b>

                                          </th>
                                          <th width="15%">QUOTE DATE</th>
                                          <th width="1%"></th>
                                          <th width="34%">'.$this->common_model->view_date($sales_quote_master_row->quotation_date,$this->session->userdata['logged_in']['company_id']).'</th>

                                                               
                                       
                                    </tr>

                                    <tr class="item last">
                                        <td>PREPARED BY  </td>
                                        <td></td>
                                        <td style="border-right:1px solid #D9d9d9">
                                            '. $this->common_model->get_user_name($sales_quote_master_row->user_id,$this->session->userdata['logged_in']['company_id']).'

                                        </td>
                                        <td>QUOTE VALIDITY</td>
                                        <td></td>
                                        <td><i>FOR 30 DAYS</i></td>
                                        </tr>

                                          <tr class="heading">
                                          <th width="15%"><b>BILLING </tdh>
                                          <th width="1%"></th>
                                          <th width="34%" style="border-right:1px solid #D9d9d9"></th>
                                          <th width="15%"><b>SHIPPING</th>
                                          <th width="1%"></th>
                                          <th width="34%"></th>
                                      </tr>

                                      <tr class="item">
                                      <td><b>BILL TO</b></td>
                                      <td></td>
                                      <td style="border-right:1px solid #D9d9d9"><b>';

                     $customer_result=$this->common_model->select_one_active_record("address_category_master",$this->session->userdata["logged_in"]["company_id"],"adr_category_id",$sales_quote_master_row->customer_no);
                if($customer_result==TRUE){
                    foreach($customer_result as $customer_row){
                        $email_content.= $customer_row->category_name;
                    }
                }
                 $email_content.= '
                                        </b></td>
                                        <td><b>SHIP TO</b></td>
                                        <td></td>
                                        <td>SAME AS BILLING</td>
                                        </tr>


                                        <tr class="item">
                                        <td><b>NAME</b></td>
                                        <td></td>
                                        <td style="border-right:1px solid #D9d9d9">';
                                            
                    $sales_quote_customer_contact_details=$this->common_model->select_one_record_with_company('address_category_contact_details',$this->session->userdata['logged_in']['company_id'],'address_category_contact_id',$sales_quote_master_row->pm_1);
                                    foreach ($sales_quote_customer_contact_details as $key => $sales_quote_customer_contact_details_row) {
                                       $email_content.=  $sales_quote_customer_contact_details_row->contact_name;
                                    }

                    $email_content.= '
                    
                </td>
                <td><b>NAME</b></td>
                <td></td>
                <td>-</td>
            </tr>

             <tr class="item">
                <td><b>CONTACT NO</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9">
                     '.$sales_quote_master_row->company_contact_no .'
                    
                </td>
                <td><b>CONTACT NO</b></td>
                <td></td>
                <td>-</td>
            </tr>

            <tr class="item">
                <td><b>ADDRESS</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9">
                '. $sales_quote_master_row->address .'   

                </td>
                <td><b>ADDRESS</b></td>
                <td></td>
                <td>-</td>
            </tr>

             <tr class="item">
                <td><b>EMAIL</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9">

                '. strtoupper($sales_quote_master_row->company_email) .' 

                </td>
                <td><b>EMAIL</b></td>
                <td></td>
                <td>-</td>
            </tr>

            <tr class="item">
                <td><b>STATE</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9">
                    '.strtoupper($this->common_model->get_state_name($sales_quote_master_row->state,$this->session->userdata['logged_in']['company_id'])) .'
                </td>
                <td><b>STATE</b></td>
                <td></td>
                <td>-</td>
            </tr>

            <tr class="item">
                <td><b>COUNTRY</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9">
                 '. $sales_quote_master_row->lang_country_name .'

                </td>
                <td><b>COUNTRY</b></td>
                <td></td>
                <td>-</td>
            </tr>

            <tr class="item last">
                <td><b>PAYMENT TERM</b></td>
                <td></td>
                <td style="border-right:1px solid #D9d9d9">
                  '. $sales_quote_master_row->credit_days.' Days

                </td>
               
            </tr>
             </table>

               <br/>


              <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            

            <tr class="heading">
                <th width="5%"><b>SR NO</th>
                <th width="1%" style="border-right:1px solid #D9d9d9"></th>
                <th width="45%"  style="border-right:1px solid #D9d9d9" >PRODUCT NAME</th>
                <th width="12%" style="border-right:1px solid #D9d9d9; text-align: right;">QUANTITY</th>
                <th width="12%" style="border-right:1px solid #D9d9d9; text-align: right;">UNIT PRICE</th>                
                <th width="20%" style="text-align: right;">NET AMOUNT</th>
                
            </tr>';

            $i=1;
    $total_quantity=0;
    $total_net_value=0;
    $total_amount=0;

    if($sales_quote_master_row->_5k_flag==1){  
     $email_content.= ' 
     <tr class="item">
               <td>'.$i.'</td>
                <td style="border-right:1px solid #D9d9d9"></td>
                <td style="border-right:1px solid #D9d9d9">'.strtoupper ($sales_quote_master_row->product_name).'</td>
                <td style="border-right:1px solid #D9d9d9; text-align: right;">5,000</td>                               
                <td style="border-right:1px solid #D9d9d9; text-align: right;">&#8377;'.($sales_quote_master_row->_5k_rev_price).'</td>
                <td style="text-align: right;">'.$sales_quote_master_row->_5k_rev_price<>'' ? $sales_quote_master_row->_5k_rev_price : ''.'/-</td>
            </tr>';
             $total_quantity+=5000;
        $total_net_value+=(5000*(int)$sales_quote_master_row->_5k_rev_price);
        $i++;
    }

    $sales_quote_master_row->_10k_flag;
    if($sales_quote_master_row->_10k_flag==1){
      $email_content.= ' 
      <tr class="item">
                <td>'.$i.'</td>
                <td style="border-right:1px solid #D9d9d9"></td>               
                <td style="border-right:1px solid #D9d9d9">'.strtoupper ($sales_quote_master_row->product_name).'</td>
                <td style="border-right:1px solid #D9d9d9;text-align: right;">10,000</td>              
                <td style="border-right:1px solid #D9d9d9;text-align: right;">&#8377;'.($sales_quote_master_row->_10k_rev_price<>0 ? $sales_quote_master_row->_10k_rev_price : '').'</td>
                <td style="text-align: right;">'.($sales_quote_master_row->_10k_rev_price<>'' ? money_format('%.0n',(10000*$sales_quote_master_row->_10k_rev_price)) : '').'/-</td>
            </tr>';
        $total_quantity+=10000;
        $total_net_value+=(10000*(int)$sales_quote_master_row->_10k_rev_price);

        $i++;
    }

    if($sales_quote_master_row->_25k_flag==1){
      $email_content.= ' 
      <tr class="item">
                <td>'.$i.'</td>
                <td style="border-right:1px solid #D9d9d9"></td>  
                <td style="border-right:1px solid #D9d9d9">'.strtoupper ($sales_quote_master_row->product_name).'</td>             
                <td style="border-right:1px solid #D9d9d9;text-align: right;">25,000</td>
                <td style="border-right:1px solid #D9d9d9;text-align: right;">&#8377;'.($sales_quote_master_row->_25k_rev_price<>0 ? $sales_quote_master_row->_25k_rev_price : '').'</td>                
                <td style="text-align: right;">'.($sales_quote_master_row->_25k_rev_price<>'' ? money_format('%.0n',(25000*$sales_quote_master_row->_25k_rev_price)) : '').'/-</td>/-</td>
            </tr>';
        $total_quantity+=25000;
        $total_net_value+=(25000*(int)$sales_quote_master_row->_25k_rev_price);
        $i++;
    }

    if($sales_quote_master_row->_50k_flag==1){
       $email_content.= '
      <tr class="item">
                <td>'.$i.'</td>
                <td style="border-right:1px solid #D9d9d9"></td>
                <td style="border-right:1px solid #D9d9d9">'.strtoupper ($sales_quote_master_row->product_name).'</td>
                <td style="border-right:1px solid #D9d9d9;text-align: right;">50,000</td>
               <td style="border-right:1px solid #D9d9d9;text-align: right;">&#8377;'.($sales_quote_master_row->_50k_rev_price<>0 ? $sales_quote_master_row->_50k_rev_price : '').'</td>                
                <td style="text-align: right;">'.($sales_quote_master_row->_50k_rev_price<>'' ? money_format('%.0n',(50000*$sales_quote_master_row->_50k_rev_price)) : '').'/-</td>/-</td>
            </tr>';
        $total_quantity+=50000;
        $total_net_value+=(50000*(int)$sales_quote_master_row->_50k_rev_price);
        $i++;
    }

    if($sales_quote_master_row->_100k_flag==1){
      $email_content.= '
       <tr class="item">
                <td>'.$i.'</td>
                <td style="border-right:1px solid #D9d9d9"></td>
                <td style="border-right:1px solid #D9d9d9">'.strtoupper ($sales_quote_master_row->product_name).'</td>                
                <td style="border-right:1px solid #D9d9d9;text-align: right;">1,00,000</td>
                <td style="border-right:1px solid #D9d9d9;text-align: right;">&#8377;'.($sales_quote_master_row->_100k_rev_price<>0 ? number_format($sales_quote_master_row->_100k_rev_price,2,'.','') : '').'</td>                
                <td style="border-right:1px solid #D9d9d9;text-align: right;">'.money_format('%.0n',(100000*$sales_quote_master_row->_100k_rev_price)).'/-</td>
            </tr>';
        $total_quantity+=100000;
        $total_net_value+=(100000*$sales_quote_master_row->_100k_rev_price);
        $i++;
    }

    if($sales_quote_master_row->free_flag==1){
       $email_content.= '
       <tr class="item">
                <td>'.$i.'</td>
                <td style="border-right:1px solid #D9d9d9"></td> 
                <td style="border-right:1px solid #D9d9d9">'.strtoupper ($sales_quote_master_row->product_name).'</td>               
                <td style="border-right:1px solid #D9d9d9;text-align: right;">'.$sales_quote_master_row->free_quantity.'</td>
                <td style="border-right:1px solid #D9d9d9;text-align: right;">&#8377;'.$sales_quote_master_row->_free_rev_price.'</td>
               
            </tr>';

             $total_quantity+=$sales_quote_master_row->free_quantity ;
        $total_net_value+=((int)$sales_quote_master_row->free_quantity*(int)$sales_quote_master_row->_free_rev_price);
        $i++;
    }
     $email_content.= '
    

            <tr class="item">
                <td colspan="3" style="border-right:1px solid #D9d9d9;text-align: right;"><b>TOTAL</b></td>
                <td style="border-right:1px solid #D9d9d9"><b>'. ($total_quantity<>0 ? $total_quantity : '').'</b></td>
                
                <td style="border-right:1px solid #D9d9d9;text-align: right;"><b>NET AMOUNT</b></td>
                <td style="text-align: right;"><b>'. ($total_net_value).'</b></td>
            </tr>
            <tr class="item">
                <td colspan="5" style="border-right:1px solid #D9d9d9;text-align: right;"><b>GST 18%</b></td>
                <td style="text-align: right;"><b>'.($total_net_value/100*18).'</b></td>
            </tr>
            <tr class="item last">
                <td colspan="5" style="border-right:1px solid #D9d9d9;text-align: right;"><b>GROSS AMOUNT</b></td>
                <td style="text-align: right;"><b>'. ($total_net_value+($total_net_value/100*18)).'</b></td>
            </tr>   

             </table>

              <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">

            <tr class="heading">
                <th width="100%" colspan="7" style="border-bottom:1px solid #D9d9d9"><b>PRODUCT SPECIFICATION</th>
            </tr>

            <tr class="heading">
                <th width="33%" colspan="2" ><b>TUBE</th>
                <th width="1%" style="border-right:1px solid #D9d9d9" ></th>
                 <th width="33%" colspan="2" style="border-right:1px solid #D9d9d9"><b>CAP</th>
                 <th width="33%" colspan="2"><b>DECORATIVE ELEMENTS</th>   
            </tr>

            <tr class="item">
                <td width="15%"><b>TUBE DIA X LENGTH</b></td>
                <td width="1%"></td>
                <td width="17%"style="border-right:1px solid #D9d9d9">';
               
                $sleeve_dia_result=$this->common_model->select_one_active_record('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id'],'sleeve_id',$sales_quote_master_row->sleeve_dia);
                if($sleeve_dia_result==TRUE){
                    foreach($sleeve_dia_result as $sleeve_dia_row){
                        $sleeve_dia=$sleeve_dia_row->sleeve_diameter;
                    }
                }
                
                 $email_content.= ' 
                '. $sales_quote_master_row->sleeve_diameter." X ".$sales_quote_master_row->sleeve_length." MM" .'
               
                <td width="15%"><b>CAP TYPE</b></td>
                <td width="18%" style="border-right:1px solid #D9d9d9">'. $sales_quote_master_row->cap_types.'</td>
                <td width="15%" ><b>SPECIAL INK</b></td>
                <td width="18%" >'.($sales_quote_master_row->special_ink== 'YES' ? 'YES' : '-') .' </td>
            </tr>

             <tr class="item">
                <td width="15%"><b>TUBE LAYER</b></td>
                <td width="1%"></td>
                <td width="17%"style="border-right:1px solid #D9d9d9">
                     '.($sales_quote_master_row->layer== '1' ? 'MONO LAYER' : ($sales_quote_master_row->layer== '7' ? 'SPRING': ($sales_quote_master_row->layer== '5' ? 'MULTI LAYER': ($sales_quote_master_row->layer== '2' ? '2 LAYER': ($sales_quote_master_row->layer== '3' ? '3 LAYER': '-')) ) )).'  

                    </td>
                <td width="15%"><b>CAP COLOR</b></td>
                <td width="18%"style="border-right:1px solid #D9d9d9">'. strtoupper( $sales_quote_master_row->cap_color).'</td>
                <td width="15%"><b>SHOULDER FOIL</b></td>
                <td width="18%">'. ($sales_quote_master_row->shoulder_foil== 'YES' ? 'YES' : '-').' </td>
            </tr>

             <tr class="item">
                <td width="15%"><b>TUBE COLOR</b></td>
                <td width="1%"></td>
                <td width="17%"style="border-right:1px solid #D9d9d9">'. strtoupper($sales_quote_master_row->tube_color).'</td>
                <td width="15%"><b>CAP FINISH</b></td>
                <td width="18%"style="border-right:1px solid #D9d9d9">'. strtoupper($sales_quote_master_row->cap_finishes).'</td>
                <td width="15%"><b>CAP FOIL</b></td>
                <td width="18%">'. ($sales_quote_master_row->cap_foil== 'YES' ? 'YES' : '-').'</td>
            </tr>

            <tr class="item">
                <td width="15%"><b>TUBE PRINT TYPE</b></td>
                <td width="1%"></td>
                <td width="17%" style="border-right:1px solid #D9d9d9">'. $sales_quote_master_row->print_type.'</td>
                <td width="15%"><b>CAP DIA</b></td>
                <td width="18%"style="border-right:1px solid #D9d9d9"> '. strtoupper($sales_quote_master_row->cap_dias).'</td>
                <td width="15%"><b>CAP SHRINK SLEEVE</b></td>
                <td width="18%">'. ($sales_quote_master_row->cap_shrink_sleeve== 'YES' ? 'YES' : '-').'</td>
            </tr>

              <tr class="item">
                <td width="15%"><b>TUBE LACQUER </b></td>
                <td width="1%"></td>
                <td width="17%" style="border-right:1px solid #D9d9d9">'.strtoupper ($sales_quote_master_row->tube_lacquer) .'</td>
                <td width="15%"><b>CAP ORIFICE</b></td>
                <td width="18%" style="border-right:1px solid #D9d9d9">
                    '. ($sales_quote_master_row->cap_ori).' </td>
                <td width="15%"><b>CAP METALIZATION</b></td>
                <td width="18%">'. ($sales_quote_master_row->cap_metalization== 'YES' ? 'YES' : '-').' </td>
                
            </tr>

            <tr class="item">
                <td width="15%"><b>SHOULDER </b></td>
                <td width="1%"></td>
                <td width="17%" style="border-right:1px solid #D9d9d9">'. strtoupper ($sales_quote_master_row->shoulder_type).'</td>
                <td width="15%"><b></b></td>
                <td width="18%" style="border-right:1px solid #D9d9d9"></td>
                <td width="15%"><b>TUBE FOIL</b></td>
                <td width="18%">'. ($sales_quote_master_row->tube_foil== 'YES' ? 'YES' : '-').' </td>
            </tr>

            <tr class="item">
                <td width="15%"><b>SHOULDER ORIFACE </b></td>
                <td width="1%"></td>
                <td width="17%" style="border-right:1px solid #D9d9d9">'.strtoupper ($sales_quote_master_row->shoulder_ori).'</td>
                <td width="15%"><b></b></td>
                <td width="18%" style="border-right:1px solid #D9d9d9"> </td>
                <td width="15%"><b></b></td>
                <td width="18%"> '. $sales_quote_master_row->label_price.'</td>
            </tr>

            <tr class="item last">
                <td width="15%"><b>SHOULDER COLOR </b></td>
                <td width="1%"></td>
                <td width="17%" style="border-right:1px solid #D9d9d9">'.strtoupper ($sales_quote_master_row->shoulder_color).' </td>
                <td width="15%"><b></b></td>
                <td width="18%">  </td>
                <td width="15%"></td>
                <td width="18%"><?php  ?></td>
            </tr>

             </table>

               <br/>

              <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">

              <tr class="heading">
                <td colspan="7"><b>REMARKS</b></td>
                <!-- <td style="border-right:1px solid #D9d9d9"></td>
                <th><b>REMARK</b></th> -->
            </tr>
            <tr class="item last">
                <td></td>
                <td></td>
                <td width="100%"  style="border-right:1px solid #D9d9d9"><span style="color:red;"><'. strtoupper($sales_quote_master_row->remarks).'</span></td>               
            </tr>
             </table>  
               <br/> 

             <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">


             <tr class="heading">
                <th colspan="7"><b>TERMS AND CONDITIONS </b></th>
                <!-- <td style="border-right:1px solid #D9d9d9"></td>
                <td><b>REMARK</b></td> -->
            </tr>
            <td width="5%"  style="font-size: 11px; text-transform: uppercase;line-height: 15px;border-right:1px solid #D9d9d9">
                <ol>
                <li>The above Rates are basic rate/ex-factory.</li>
                <li>Supply will be done from Silvassa Factory.</li>
                <li><b>Excise duty shall be charged @ I GST of 18% </b></li>
                <li><b>Delivery Lead Time: 4-6 Weeks from date of PO or Receipt of artwork approval whichever is Later </b></li>
                <li>Freight: On Parties A/c.</li>
                <li>Quotation Validity: 60 Days.</li>
                <li>Compatibility & Stability of the tube is not our responsibility.</li>
                <li>*Tubes are manufactured under Air Conditioner rooms.</li>
                <li><b> 10% +/- variation in the ordered quantity is to be accepted.</b></li>
                <li>Rates are subject to change depending upon change in the final artwork.</li>
                <li>Insurance – On Parties Account.</li>
                <li>Preferable Transporter to be suggested by Party.</li>


                </ol></td>

                 </table>
                   <br/>

                  <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">

                 <tr class="heading">
                <td colspan="7"><b>IF YOU HAVE ANY QUESTIONS CONCERNING THIS QUOTATION CONTACT OR E-MAIL US : SALES@3D-NEOPAC.COM </b></td>
                </tr>
                  </table>
                    <br/>    
            
                
                </div>';
                
                        }

                         $this->email->message($email_content);
                        $this->email->set_mailtype('html');

                  
                        if ($this->email->send()) {
                          $data['note']='approve Transaction Completed';
                        } 
                  }

            $data['followup_received']=$this->sales_quote_followup_model->select_followup_received_records('followup',$this->session->userdata['logged_in']['company_id'],'followup.user_id',$this->session->userdata['logged_in']['user_id'],'status','1','followup.form_id','91');
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
            $result=$this->common_model->update_one_active_record_where('followup',$data,'record_no',$this->uri->segment('3').'@@@'.$this->uri->segment('4'),'transaction_no',$this->uri->segment('5'),$this->session->userdata['logged_in']['company_id']);

            // echo $this->uri->segment('3').'@@@'.$this->uri->segment('4');
            // echo $this->uri->segment('5');
            //echo $this->db->last_query();

            $data=array('pending_flag'=>'0','final_approval_flag'=>'0');

            $result=$this->common_model->update_one_active_record_where('sales_quote_master',$data,'sales_quote_master.quotation_no',$this->uri->segment('3'),'sales_quote_master.version_no',$this->uri->segment('4'),$this->session->userdata['logged_in']['company_id']);
             //echo $this->db->last_query();

            $data['followup']=$this->common_model->select_one_active_record_nonlanguage_without_archive('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$this->uri->segment('3').'@@@'.$this->uri->segment('4'));

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
                        'form_id'=>'91',
                        'transaction_no'=>$transaction_no,
                        'status'=>'999',
                        'followup_date'=>date('Y-m-d'),
                        'approved_flag'=>'2',
                        'approval_date'=>date('Y-m-d'),
                        'contact_person_id'=>$this->session->userdata['logged_in']['user_id'],
                        'record_no'=>$this->uri->segment('3').'@@@'.$this->uri->segment('4')
                        );
            $result=$this->common_model->save('followup',$data);
            $data['note']='Rejected Transaction Completed';
            

            $data['employee']=$this->common_model->select_one_active_record('employee_master',$this->session->userdata['logged_in']['company_id'],'employee_id',$this->session->userdata['logged_in']['user_id']);

                      foreach ($data['employee'] as $employee_row) {
                        $config['protocol'] = 'smtp';
                        $config['smtp_host'] = 'ssl://smtp.googlemail.com';
                        $config['smtp_port'] = 465;
                        $this->load->library('email', $config);
                        $this->email->from("auto.mailer@3d-neopac.com");
                        $this->email->to("vaibhav.singh@3d-neopac.com,soumen.nandan@3d-neopac.com,vishal.gupta@3d-neopac.com,
                          shailendra.singh@3d-neopac.com,erp@3d-neopac.com");
                        $this->email->cc($employee_row->mailbox);
                        $this->email->subject("".$this->uri->segment(3).' REV'.$this->uri->segment(4)." is Rejected");
                        $this->email->message("Dear Sales Team, The subjected Quote has been Rejected");

                        if ($this->email->send()) {
                          $data['note']='Rejected Transaction Completed';
                        } 
                  }
                  
            



            $data['followup_received']=$this->sales_quote_followup_model->select_followup_received_records('followup',$this->session->userdata['logged_in']['company_id'],'followup.user_id',$this->session->userdata['logged_in']['user_id'],'status','1','followup.form_id','91');
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