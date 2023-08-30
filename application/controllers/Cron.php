<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Cron extends CI_Controller {
	function __construct(){
    parent::__construct();
    $this->load->model('common_model');
    $this->load->model('login_model');
    $this->load->model('Cron_model');
  }

	public function auto_mailer(){
		  $to_date = date('Y-m-d');
		  $from_date =  date('Y-m-d', strtotime($to_date. ' - 120 days'));

  $result=$this->Cron_model->ink_email_send($from_date,$to_date);
  echo $this->db->last_query();
 
			if($result==FALSE){
				echo 'ERROR';
			}else{
						$filename = base_url('assets/img/logo.png');
					  $config['protocol']    = 'smtp';
				    $config['smtp_host']    = 'ssl://smtp.gmail.com';
				    $config['smtp_port']    = '465';
				    $config['smtp_timeout'] = '7';
				    $config['smtp_user']    = 'auto.mailer@3d-neopac.com'; 
				    $config['smtp_pass']    = 'auto@2223';
				    $config['charset']    = 'utf-8';
				    $config['newline']    = "\r\n";
				    $config['mailtype'] = 'text'; // or html 
				    $config['validation'] = TRUE; 


				    $this->email->initialize($config);
				    $this->load->model('Cron_model');
				    $this->email->set_newline("\r\n");
				    $this->email->attach($filename);
				    $cid = $this->email->attachment_cid($filename);
				    
   
   
			        $this->email->from('auto.mailer@3d-neopac.com', '3D Neopac'); 
			        $this->email->to('pravin.shinde@3d-neopac.com');
       
         			$this->email->subject('Reminder for Updating Coex Ink Gm/Tube for Pending Products'); 


         			$email_content ='<!DOCTYPE><html>
                  <head><title>Sales Order</title>
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
                    <div style="text-align:center;">
                    <img src=cid:'.$cid.' style="max-width:130px;height:30px;"><br/>
                    <span style="font-size:10px;"><b>3D TECHNOPACK PVT LTD</b><br/>
                    SURVEY NO 8/1, VILLAGE ATHAL, SILVASSA, DADRA NAGAR HAVELI, PIN : 396230, INDIA</span>
                    </div>
                  </br>
                  <div style="text-align:center;padding:15px;font-size:10px;"><span style="background-color:black;padding:4px;color:white;font-weight:bold;">PENDING LIST</span><br/>
                  </div><br/>
                  <div>           
                    
                    <div>
																						<table cellpadding="5" cellspacing="0">
																						 
																	      <tr>
																	        <th>Invoice date</th> 
																	         <th>Invoice Number</th>                 
																	        <th>Order No</th>                
																	        <th>Article No</th>
																	        <th>Artwork No</th>
																	        <th>Version No</th>																	        
																	        <th>Print Type</th>
																	      </tr>';

																	      foreach($result as $row){
																	     $email_content.='
																	      <tr>
																	        
																	        <td>'.$this->common_model->view_date($row->invoice_date,$this->session->userdata['logged_in']['company_id']).'</td>
																	        <td>'.$row->ar_invoice_no.'</td>
																	        <td>'.$row->ref_ord_no.'</td>
																	        <td>'.$row->article_no.'</td>
																	        <td>'.$row->artwork_no.'</td> 
																	        <td>'.$row->artwork_version_no.'</td>
																	        <td>'.$row->print_type.'</td>
																	      </tr>';
																	     }
																	     $email_content.='
																	    </table>
																	    </div>
																	    </body>
																	    </html>';


        	 	 $this->email->message($email_content);
            $this->email->set_mailtype("html");
            if ($this->email->send()) {
							        $data['note']= 'Email send succesfully!';
							        return 1;
							      } 
							      else{
							        $data['error']='Email send failed!';
							        return 0;
							      }



			}
		}
	}


 
