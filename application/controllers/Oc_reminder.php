<?php

class Oc_reminder extends CI_Controller {

	function __construct(){
    parent::__construct();
    
      $this->load->model('common_model');
      $this->load->model('sales_order_book_model');
      $this->load->model('sales_order_status_model');
      $this->load->model('sales_invoice_book_model');
      $this->load->model('artwork_model');
      $this->load->model('country_model');
      $this->load->model('customer_model');
      $this->load->model('tax_grid_model');
      $this->load->model('relate_model');
      $this->load->model('specification_model');
      $this->load->model('property_model');
      $this->load->model('payment_term_model');
      $this->load->model('customer_model');
      $this->load->model('article_model');
      $this->load->model('fiscal_model');
      $this->load->model('sleeve_specification_model');
      $this->load->model('shoulder_specification_model');
      $this->load->model('cap_specification_model');
      $this->load->model('label_specification_model');
      $this->load->model('freight_type_model');
      $this->load->model('artwork_springtube_model');
      $this->load->model('springtube_extrusion_production_model');
      $this->load->model('sales_order_followup_model');

   
  }

function index(){
  $result=$this->sales_order_book_model->sales_user_model();
    if($result==true) {
      foreach($result as $row){
        $from_date =date('Y-m-d');
        $to_date=  date('Y-m-d', strtotime($from_date. ' + 5 days'));  
        $data=$this->sales_order_book_model->oc_reminder_model($from_date,$to_date,$row->user_id);
          if($data==true) {
            $filename = base_url('assets/img/logo.png');
            $this->email->attach($filename);
            $cid = $this->email->attachment_cid($filename);
            $email_content1 ='<!DOCTYPE>
            <html>
               <head>
                  <title>Sales Order</title>
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
                     border-right:1px solid #ddd;
                     border-bottom:1px solid #ddd;
                     text-align: left;
                     background-color:#DFFCFC;
                     font-weight:bold;
                     font-size:9px;
                     }
                     td {
                     border-right:1px solid #ddd;                        
                     border-bottom:1px solid #ddd;
                     text-align: left;            
                     font-size:9px;
                     }        
                  </style>
               </head>
               <body>
                  <div style="font-family:verdana;border:1px solid #ddd;padding:12px;width:800px;">
                  <div style="text-align:center;"">
                     <img src="cid:'.$cid.'" style="max-width:130px;height:30px;"><br/>
                     <span style="font-size:10px;"><b>3D TECHNOPACK PVT LTD</b><br/>
                     SURVEY NO 8/1, VILLAGE ATHAL, SILVASSA, DADRA NAGAR HAVELI, PIN : 396230, INDIA</span>
                  </div>
                  </br>
                  <div style="text-align:center;padding:0px;font-size:10px;margin-top: 10px;"><span style="background-color: #00b5ad!important;padding: 6px;color: white;font-weight: bold;font-size: 12px;border-radius: 5px;">Sale Order Reminder List</span><br/>
                  </div>
                  <br/>
                  <div>
                  <div>
                     ';
                     $email_content =' 
                     <table cellpadding="5" cellspacing="8">
                     <tr>
                        <th>OC Date </th>
                        <th>Customer </th>
                        <th>Order No</th>
                        <th>Article No</th>
                        <th>Order Qty</th>
                        <th>Unit Rate</th>
                        <th>Dispatch Qty</th>
                        <th>Pending Qty</th>
                     </tr>
                     ';

                     foreach($data as $row){
                     if ($row->user_id=='EMP282' AND $row->user_id=='EMP284' AND $row->user_id=='EMP298') {
                     $email_content.='
                     <tr>
                        <td>'.$row->oc_date.'</td>
                        <td>'.$row->customer.'</td>
                        <td>'.$row->order_no.'</td>
                        <td>'.$row->article_no.'</td>
                        <td>'.$row->order_qty.'</td>
                        <td>'.$row->unit_rate.'</td>
                        <td>'.$row->dispatch_qty.'</td>
                        <td>'.$row->pending_qty.'</td>
                     </tr>
                     ';
                     }elseif ($row->user_id=='EMP282' AND $row->user_id=='EMP284' ) {
                     $email_content.='
                     <tr>
                        <td>'.$row->oc_date.'</td>
                        <td>'.$row->customer.'</td>
                        <td>'.$row->order_no.'</td>
                        <td>'.$row->article_no.'</td>
                        <td>'.$row->order_qty.'</td>
                        <td>'.$row->unit_rate.'</td>
                        <td>'.$row->dispatch_qty.'</td>
                        <td>'.$row->pending_qty.'</td>
                     </tr>
                     ';
                     }elseif ($row->user_id=='EMP284' AND $row->user_id=='EMP298' ) {
                     $email_content.='
                     <tr>
                        <td>'.$row->oc_date.'</td>
                        <td>'.$row->customer.'</td>
                        <td>'.$row->order_no.'</td>
                        <td>'.$row->article_no.'</td>
                        <td>'.$row->order_qty.'</td>
                        <td>'.$row->unit_rate.'</td>
                        <td>'.$row->dispatch_qty.'</td>
                        <td>'.$row->pending_qty.'</td>
                     </tr>
                     ';
                     }elseif ($row->user_id=='EMP282' AND $row->user_id=='EMP298' ) {
                     $email_content.='
                     <tr>
                        <td>'.$row->oc_date.'</td>
                        <td>'.$row->customer.'</td>
                        <td>'.$row->order_no.'</td>
                        <td>'.$row->article_no.'</td>
                        <td>'.$row->order_qty.'</td>
                        <td>'.$row->unit_rate.'</td>
                        <td>'.$row->dispatch_qty.'</td>
                        <td>'.$row->pending_qty.'</td>
                     </tr>
                     ';
                     }elseif ($row->user_id=='EMP282') {
                     $email_content.='
                     <tr>
                        <td>'.$row->oc_date.'</td>
                        <td>'.$row->customer.'</td>
                        <td>'.$row->order_no.'</td>
                        <td>'.$row->article_no.'</td>
                        <td>'.$row->order_qty.'</td>
                        <td>'.$row->unit_rate.'</td>
                        <td>'.$row->dispatch_qty.'</td>
                        <td>'.$row->pending_qty.'</td>
                     </tr>
                     ';
                     }elseif ($row->user_id=='EMP284') {
                     $email_content.='
                     <tr>
                        <td>'.$row->oc_date.'</td>
                        <td>'.$row->customer.'</td>
                        <td>'.$row->order_no.'</td>
                        <td>'.$row->article_no.'</td>
                        <td>'.$row->order_qty.'</td>
                        <td>'.$row->unit_rate.'</td>
                        <td>'.$row->dispatch_qty.'</td>
                        <td>'.$row->pending_qty.'</td>
                     </tr>
                     ';
                     }elseif ($row->user_id=='EMP298') {
                     $email_content.='
                     <tr>
                        <td>'.$row->oc_date.'</td>
                        <td>'.$row->customer.'</td>
                        <td>'.$row->order_no.'</td>
                        <td>'.$row->article_no.'</td>
                        <td>'.$row->order_qty.'</td>
                        <td>'.$row->unit_rate.'</td>
                        <td>'.$row->dispatch_qty.'</td>
                        <td>'.$row->pending_qty.'</td>
                     </tr>
                     ';
                     }
                     else{
                     "ERROR";
                     }
                  }
                }
                }
}
             

         echo '
      </div>
   </body>
</html>';

    $smtp_user=$this->config->item('smtp_user');
    $smtp_pass=$this->config->item('smtp_pass');
    $config['protocol'] = 'smtp';
    $config['smtp_host'] = 'ssl://smtp.googlemail.com';
    $config['smtp_port'] = 465;
    $config['smtp_timeout'] = 60;
    $config['charset'] = 'utf-8';
    $config['mailtype'] = 'html';
    $config['validation'] = 'TRUE';
    $config['smtp_user']= 'auto.mailer@3d-neopac.com';
    $config['smtp_pass']='auto@2223';
    $config['newline']= "\r\n";
    $this->load->library('email', $config);
    $this->email->from('automailer@3d-neopac.com', '3D Neopac');
    //$this->email->to($row->mailbox);
    //$this->email->cc('bhavesh.patel@3d-neopac.com');
    $this->email->subject('Reminder for Orders');
    $this->email->message($email_content1.''.$email_content);
    echo $this->db->last_query();
    echo $email_content1.''.$email_content;
    $this->email->set_mailtype("html");
    // if ($this->email->send()) {
    //   echo 'File Uploaded Succesfully!';
    // } 
    // else{
    //   echo 'Email send failed!';
    // }
  }
}

