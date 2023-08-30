<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Test extends CI_Controller 
{ 
  public function __construct() 
  { parent::__construct(); 
    $this->load->library('excel');
    $this->load->model('common_model');
    $this->load->model('sales_order_book_model');
    $this->load->model('payment_term_model');
    $this->load->model('customer_model');
    $this->load->model('property_model');
    $this->load->model('tax_grid_model');
    $this->load->model('sales_invoice_book_model');

  }
 
  public function index()
  {
      $data['rs'] =  $this->db->get('countries');
      $this->load->view('Test/test', $data);
  }

  public function email_order(){

    echo $this->on_order_closed_send_email('SO-21-22-0564','eknath.parkhe@3d-neopac.com','testing cancel order','');


  }
  public function fixed_column(){

    $this->load->view('Test/fixed_column');

  }

  public function show_popup(){

    $this->load->view('Test/popup_test');

  }


  public function batch_insert(){

        //     $data = array(

        //    array(
        //       'sr_no' => '1' ,
        //       'name' => 'Eknath' ,
              
        //    ),
        //    array(
        //       'sr_no' => '2' ,
        //       'name' => 'Rudra' 
              
        //    )
        // );
      $parent_arr='';
      $j=1;
      for($i=0;$i<5;$i++){
        $child_arr=array('sr_no'=>$i+1,
                          'name'=>'Eknath_'.$j);
        $parent_arr[$i]=$child_arr;
        $j++;
      }  


      print_r($parent_arr);

      $this->db->insert_batch('test_batch_insert', $parent_arr); 



      




  }


  public function excel()
  {
                $this->excel->setActiveSheetIndex(0);
                //name the worksheet
       //          $this->excel->getActiveSheet()->setTitle('Countries');
       //          //set cell A1 content with some text
       //          $this->excel->getActiveSheet()->setCellValue('A1', 'Country Excel Sheet');
       //          $this->excel->getActiveSheet()->setCellValue('A4', 'S.No.');
       //          $this->excel->getActiveSheet()->setCellValue('B4', 'Country Code');
       //          $this->excel->getActiveSheet()->setCellValue('C4', 'Country Name');
       //          //merge cell A1 until C1
       //          $this->excel->getActiveSheet()->mergeCells('A1:C1');
       //          //set aligment to center for that merged cell (A1 to C1)
       //          $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
       //          //make the font become bold
       //          $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
       //          $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
       //          $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
       // for($col = ord('A'); $col <= ord('C'); $col++){ //set column dimension $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
       //           //change the font size
       //          $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
                 
       //          $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
       //  }
                //retrive contries table data
                $rs = $this->db->get('countries');
                $exceldata="";
        foreach ($rs->result_array() as $row){
                $exceldata[] = $row;
        }
                //Fill data 
                $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A5');
                 
                // $this->excel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                // $this->excel->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                // $this->excel->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                 
                $filename='PHPExcelDemo.xls'; //save our workbook as this file name
                header('Content-Type: application/vnd.ms-excel'); //mime type
                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
                header('Cache-Control: max-age=0'); //no cache
 
                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
                //if you want to save it as .XLSX Excel 2007 format
                $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
                //force user to download the Excel file without writing it to server's HD
                $objWriter->save('php://output');
                 
    }

    function test_script(){

          //echo'<script> var email= prompt("Enter your email");</script>';
          //email='<script>document.write(email);</script>';

          echo'<script> confirm(prompt("Enter the password"));</script>';          
          echo $password='<script>document.write(password);</script>';


          /*echo '<script> var comment= prompt("Enter the comment");</script>'; 

          //$com='<script>document.write(comment);</script>';
          $emailContent='<!DOCTYPE html><html><head><title>Page Title</title></head><body><h1><script>document.write(comment);</script></h1></body></html>';

        
          if($emailContent!=''){


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
          // $config['smtp_user']='springprint@3d-neopac.com';
          // $config['smtp_pass']='spring@321';

          $config['smtp_user']='springprint@3d-neopac.com';
          $config['smtp_pass']='spring@321';
          
          $this->load->library('email', $config);
          //$this->email->from($employee_row->mailbox);
          //$this->email->from('eknath.parkhe@3d-neopac.com');
          //$this->email->from('springprint@3d-neopac.com');
          $this->email->from('springprint@3d-neopac.com');
          //$this->email->to("eknath.parkhe@3d-neopac.com");
          $this->email->to("eknath.parkhe@3d-neopac.com");
          
          $this->email->subject("Test");
          $this->email->message($emailContent);
          $this->email->set_mailtype("html");

          if ($this->email->send()) {
            echo 'Email send succesfully!';
            
          } 
          else{
            echo 'Email send failed!';
           

          }
        }  
      
          
*/



          //$out=readline('Please enter!');
          //echo $email;
          //echo $password;
          //echo $comment;
          //echo $out;

    }

  function array_loop(){

    $jobcard_no='PJOB-20-21-0380';
    $new_so='SO-20-21-3286';

    $table_array=array(
      "springtube_extrusion_production_details",
      "springtube_extrusion_qc_master",
      "springtube_extrusion_scrap_master",
      "springtube_extrusion_wip_master",
      "springtube_printing_production_master",
      "springtube_printing_jobsetup_master",
      "springtube_printing_inspection_details",
      "springtube_printing_wip_master_after",
      "springtube_bodymaking_production_details",
      "springtube_bodymaking_qc_master",
      "springtube_bodymaking_scrap_master",
      "springtube_bodymaking_wip_master",
      "springtube_aql_rfd_master",
      "springtube_rfd_master");

    foreach ($table_array as  $table) {

      $sql="select * from ".$table." where jobcard_no='".$jobcard_no."'";      
      $query=$this->db->query($sql);
      $result=$query->result();
      if(count($result)>0){
        $sql_update="update ".$table." set order_no='".$new_so."' WHERE jobcard_no='".$jobcard_no."'";
        //$query_update=$this->db->query($sql_update);
        //$result_update=$query_update->result();
       
      }
    }
    
  }

  function  input_array_example(){


    $data['page_name']='Production';
    $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
    $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
   
    $this->load->view('Home/header');
    $this->load->view('Home/nav',$data);
    $this->load->view('Home/subnav');

    $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

  }

  function save_input_array_example(){

    try{

        $this->form_validation->set_rules('production_date','Production Date' ,'required|trim|xss_clean');
          $i=1;
        if(is_array($this->input->post('jobcard_no[]'))){  
          foreach ($this->input->post('jobcard_no[]') as $key => $value) {          
            $this->form_validation->set_rules('jobcard_no[]','Jobcard no' .$i ,'required|trim|xss_clean');
            $this->form_validation->set_rules('total_sleeve_produced[]','total_sleeve_produced'.$i ,'required|trim|xss_clean');


            $i++;
          }
        }

        if($this->form_validation->run()==FALSE){

          $data['page_name']='Production';
          $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
       
          $this->load->view('Home/header');
          $this->load->view('Home/nav',$data);
          $this->load->view('Home/subnav');
          $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);

        }else{

          echo 'Passes';


          $data['page_name']='Production';
          $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);
          $data['formrights']=$this->common_model->select_active_formrights_of_form($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id'],5,$this->router->fetch_class());
     
          $this->load->view('Home/header');
          $this->load->view('Home/nav',$data);
          $this->load->view('Home/subnav');
          $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);


        }
        
    }
    catch(Exception $ex){
        die($ex->getMessage());
    }



  }

  public function check_rm(){

    $this->load->model('common_model');
    $this->load->model('sales_order_book_model');
    $this->load->model('specification_model');

    echo $rm=$this->get_material_qty('BOM2274','1','100000','7');

  }




  function get_material_qty($bom_no,$bom_version_no,$qty,$item_group_material){

    $pi=3.14;
    $rejection=5;
    $total_rm_qty=0;

    $data=array('bom_no'=>$bom_no,
                'bom_version_no'=>$bom_version_no
    );
    $data['bom_details']=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data);

    foreach($data['bom_details'] as $bom_details_row){
      $sleeve_code=$bom_details_row->sleeve_code;
      $shoulder_code=$bom_details_row->shoulder_code;
      $label_code=$bom_details_row->label_code;
      $cap_code=$bom_details_row->cap_code;
      $for_export=$bom_details_row->for_export;
    } 

    if(substr($sleeve_code,0,3)=="SLV"){

      $data['sleeve_specs']=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$sleeve_code);

      foreach($data['sleeve_specs'] as $sleeve_specs){

        $sleeve_specss['spec_id']=$sleeve_specs->spec_id;
        $sleeve_specss['spec_version_no']=$sleeve_specs->spec_version_no;

        $sleeve_specs_master_result=$this->common_model->select_active_records_where('specification_sheet',$this->session->userdata['logged_in']['company_id'],$sleeve_specss);
        foreach($sleeve_specs_master_result as $sleeve_specs_master_result_row){
          $layer_arr=explode("|", $sleeve_specs_master_result_row->dyn_qty_present);
          $layer_no=substr($layer_arr[1],0,1);              

        }

        $sleeve_specs_details_result=$this->sales_order_book_model->select_sleeve_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$sleeve_specss);
        //print_r($sleeve_specs_details_result);
         
        foreach($sleeve_specs_details_result as $sleeve_specs_details_row){
          $dia=$sleeve_specs_details_row->SLEEVE_DIA;
          $length=$sleeve_specs_details_row->SLEEVE_LENGTH+3;
          $sleeve_length=$sleeve_specs_details_row->SLEEVE_LENGTH;
        }

        for($i=1;$i<=$layer_no;$i++){
          //Guage----------------
          $guage=0;         

          $data['specification_sleeve_details']=$this->specification_model->select_details_record_for_jobcard_where_gauge('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$sleeve_specs->spec_id,'specification_sheet_details.spec_version_no',$sleeve_specs->spec_version_no,'item_group_id','3','layer_no',$i,'parameter_name','GUAGE','srd_id','asc','layer_no','asc');

          foreach($data['specification_sleeve_details'] as $specification_sleeve_details_row){
            
            $gauge=rtrim($specification_sleeve_details_row->parameter_value," MIC");
            //echo'</br>';
            $sleeve_weight="";
            $density="";

            if($layer_no==5 && $i==3){
              $density=1.18;
              
            }else{
              $density=0.92;
            }

            $dia1=substr($dia,0,2);

            //$sleeve_weight=((((($dia1*$length*$gauge*$pi*$density)/1000000)*$rejection/100)+(($dia1*$length*$gauge*$pi*$density)/1000000))/1000)*$qty;
            $weight=(($dia1*$length*$gauge*$pi*$density)/1000000);
            $rejection_weight=$weight*(5/100);

            $total_weight=(($weight+$rejection_weight)*$qty)/1000;
                        
            $sleeve_weight=$total_weight/100;
            //echo '</br>';

            $data['specification_sleeve_details']=$this->specification_model->select_details_record_for_jobcard_where_gauge_new('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$sleeve_specs->spec_id,'specification_sheet_details.spec_version_no',$sleeve_specs->spec_version_no,'item_group_id','3','mat_article_no<>','','layer_no',$i,'item_group_material',$item_group_material,'srd_id','asc','layer_no','asc');

            //echo $this->db->last_query();
              
                        
              foreach($data['specification_sleeve_details'] as $specification_sleeve_details_row){
                if(!empty($specification_sleeve_details_row->mat_info) && !empty($specification_sleeve_details_row->mat_article_no)){
                  
                  //$specification_sleeve_details_row->mat_article_no."-".$specification_sleeve_details_row->mat_info;

                 
                  echo $rm_qty=round($sleeve_weight*$specification_sleeve_details_row->mat_info,2);

                  echo '</br>';

                  $total_rm_qty+=$rm_qty;
                }

              }




          } // foreach specsheet_details


          
          

         



        }// Layer for

      }//foreach sleeve_specs

    }//if SLV
            
    return $total_rm_qty;

  }//function get_material

  function on_order_closed_send_email($order_no,$to,$subject,$body){
    
    //$order_no='SO-21-22-0543';
    // echo $to;
    // echo $subject;
    //echo base_url();
    $body=' This is a testing Email';

    $order_master=$this->sales_order_book_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_master.order_no',$order_no);
    $order_details=$this->sales_order_book_model->active_details_records('order_details',array('order_no'=>$order_no),$this->session->userdata['logged_in']['company_id']);    
    $tax_master=$this->tax_grid_model->select_sales_order_tax_grid($order_no);

    $followup=$this->common_model->select_followup_records('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$order_no);

    $abcd=array('order_no'=>$order_no);
    $order_transaction=$this->common_model->select_one_active_record_nonlanguage_without_archives_order_by('order_transaction',$this->session->userdata['logged_in']['company_id'],$abcd,$group_by="",$order_by="");


    $reasons='';
    $order_close_reasons_master_result=$this->common_model->select_one_active_record('order_close_reasons_master',$this->session->userdata['logged_in']['company_id'],'id',$order_master_row->trans_closed_reason);
    foreach ($order_close_reasons_master_result as $key => $order_close_reasons_master_row) {
      $reasons=$order_close_reasons_master_row->reasons;
    }


    foreach ($order_master as $order_master_row):      

      $email_content = '<!DOCTYPE>
      <html>
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

            border:1px solid #ddd;
            text-align: left;
            background-color:#DFFCFC;
            font-weight:bold;
            font-size:12px;
          }

          td {
            border:1px solid #ddd;
            text-align: left;            
            font-size:10px;
          }        
          
        </style>
      </head>         
      <body>';
      $email_content.="<div style='width:900px;margin:0px auto;background-color:#ddd;border:1px solid #ddd;font-family:verdana;'>
    
      <div style='padding:20px;font-size:15px;'> 
        ".$order_master_row->order_no."<span style='font-weight:bold;font-size:15px;color:#28929B;float:right;'></span>
      </div>
      <div style='padding:20px;background-color:white;'>   
        
        
        <div style='margin-top:20px;'>
          <table cellpadding='5'>          
            <tr>
              <th width='15%'>SO NO</td>
              <th width='35%'>".$order_master_row->order_no."</td>
              <th width='15%'>PO NO</td>
              <th width='35%'>".$order_master_row->cust_order_no.($order_master_row->cust_product_no!='' ? $order_master_row->cust_product_no : '-')."</td>
            </tr>
            <tr>
                <td>SO DATE</td>               
                <td>".$this->common_model->view_date($order_master_row->order_date,$this->session->userdata['logged_in']['company_id'])."</td>
                <td>PO DATE</td>               
                <td>".$this->common_model->view_date($order_master_row->cust_order_date,$this->session->userdata['logged_in']['company_id'])."</td>
            </tr>
          </table>";

           $email_content.='<table cellpadding="5">
              <tr>
                <th width="15%"><b>BILLING</hd>                
                <th width="35%"></hd>
                <th width="15%"><b>SHIPPING</th>              
                <th width="35%"></th>
              </tr>

              <tr>
                <td width="15%"><b>BILL TO</td>                
                <td width="35%"><b>'.$order_master_row->customer_name.'</b></td>
                <td width="15%"><b>SHIP TO</td>              
                <td width="35%">';

                if(!empty($order_master_row->consin_adr_company_id)){
                    explode("|",$order_master_row->consin_adr_company_id)[0];
                    $data['ship_to']=$this->customer_model->select_one_active_record("address_master",$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',explode("|",$order_master_row->consin_adr_company_id)[0]);
                    foreach($data['ship_to'] as $ship_to_row){
                        $email_content.=$ship_to_row->name1;
                        //echo explode("|",$order_master_row->consin_adr_company_id)[0];
                        $data['property']=$this->property_model->select_one_active_record_noncompany_withlanguage('property_master','property_id',explode("|",$order_master_row->consin_adr_company_id)[1],$this->session->userdata['logged_in']['language_id']);
                        foreach($data['property'] as $property_row){
                            //echo "//".$property_row->lang_property_name;
                        }
                    }
                }else{
                    $email_content.='SAME AS BILLING';
                }


                $email_content.='</td>
              </tr>
              <tr>
                <td>ADDRESS</td>                
                <td>'.$order_master_row->strno.''.$order_master_row->name2.''.$order_master_row->street.''.$order_master_row->name3.'</td>
                <td>ADDRESS</td>
                <td>';
                if(!empty($order_master_row->consin_adr_company_id)){
                    explode("|",$order_master_row->consin_adr_company_id)[0];
                    $data['ship_to']=$this->customer_model->select_one_active_record("address_master",$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',explode("|",$order_master_row->consin_adr_company_id)[0]);
                    foreach($data['ship_to'] as $ship_to_row){
                    $email_content.=$ship_to_row->strno.' '.$ship_to_row->name2.' '.$ship_to_row->street.' '.$ship_to_row->name3;
                    
                    }
                }else{
                    $email_content.='-';
                }
                $email_content.='</td>
              </tr>
              <tr>
                <td>GSTIN</td>                
                <td>'.$order_master_row->isdn_local.'</td>
                <td>GSTIN</td>
                <td>';

                if(!empty($order_master_row->consin_adr_company_id)){
                        explode("|",$order_master_row->consin_adr_company_id)[0];
                        $data['ship_to']=$this->customer_model->select_one_active_record("address_master",$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',explode("|",$order_master_row->consin_adr_company_id)[0]);
                        foreach($data['ship_to'] as $ship_to_row){
                          $email_content.=$ship_to_row->isdn_local;
                        
                        }
                    }else{
                        $email_content.='-';
                    }
                $email_content.='</td>
            </tr>
            <tr>
              <td>STATE</td>
              <td>'.strtoupper($order_master_row->lang_city).'</td>                
              <td>STATE</td>             
              <td>';        
                  if(!empty($order_master_row->consin_adr_company_id)){
                      explode("|",$order_master_row->consin_adr_company_id)[0];
                      $data['ship_to']=$this->customer_model->select_one_active_record("address_master",$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',explode("|",$order_master_row->consin_adr_company_id)[0]);
                      foreach($data['ship_to'] as $ship_to_row){
                      $email_content.=strtoupper($ship_to_row->lang_city);
                      
                      }
                  }else{
                      $email_content.='-';
                  }
              $email_content.='</td>
            </tr>
            <tr class="item">
                <td>STATE CODE</td>                
                <td>'.$order_master_row->state_code.'</td>                
                <td>STATE CODE</td>               
                <td>';
        
                    if(!empty($order_master_row->consin_adr_company_id)){
                        explode("|",$order_master_row->consin_adr_company_id)[0];
                        $data['ship_to']=$this->customer_model->select_one_active_record("address_master",$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',explode("|",$order_master_row->consin_adr_company_id)[0]);
                        foreach($data['ship_to'] as $ship_to_row){
                          $email_content.=$ship_to_row->state_code;
                        
                        }
                    }else{
                        $email_content.= '-';
                    }
                $email_content.='</td>
            </tr>
            <tr>
              <td>COUNTRY</td>               
              <td>'.$order_master_row->country_name.'</td>                
              <td>COUNTRY</td>              
              <td>';
                  $data['customer']=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',explode("|",$order_master_row->consin_adr_company_id)[0]);
                  if($data['customer']==TRUE){
                      foreach($data['customer'] as $customer_row){
                          $country_result=$this->customer_model->select_one_active_state_country_record('country_master_lang',$this->session->userdata['logged_in']['company_id'],'country_id',$customer_row->country_id);
                         // echo $this->db->last_query();
                          if($country_result==FALSE){
                              //echo '';
                          }else{
                              foreach($country_result as $country){
                                  $email_content.=$country->lang_country_name;
                              }
                          }
                      }
                  }

              $email_content.='</td>
            </tr>
            <tr>
              <td>TYPE</td>              
              <td style="border-right:1px solid #D9d9d9;">'.($order_master_row->for_export==1 ? 'EXPORT' : 'LOCAL').'</td>
              <td>SAMPLE</td>
              
              <td>'.($order_master_row->for_sampling==1 ? 'SAMPLE' : 'NO').'</td>
            </tr>
            <tr>';            
            if($order_master_row->for_export==1){
                    
              $email_content.="<tr>
              <td>CURRENCY</td>
              <td style='border-right:1px solid #D9d9d9;'>".$order_master_row->currency_id."</td>
              <td>EXCHANGE RATE</td>
               <td>".$this->common_model->read_number($order_master_row->exchange_rate,$this->session->userdata['logged_in']['company_id'])."</td>
            </tr>";
            }
            $email_content.='
            </table>

            <table cellpadding="5">
              <tr>
                  <th><b>DETAILS</th>
                  <th colspan="3"></th>
              </tr>';            
            
            if(!empty($order_master_row->payment_condition_id)){

              $payment_term=$this->payment_term_model->select_one_active_record('payment_condition_master','id',$order_master_row->payment_condition_id,$this->session->userdata['logged_in']['language_id']);
                if($payment_term==FALSE){

                }else{
                    foreach($payment_term as $payment_term_row){

                      $email_content.='
                      <tr>
                        <td width="15%">PAYMENT TERM</td>
                        
                        <td width="35%">'.$payment_term_row->lang_description.'</td>
                        <td width="15%">CREDIT DAYS</td>                         
                        <td width="35%">'.$payment_term_row->net_days.'</td>
                      </tr>';
                    }
                }

            }else{

                $address_details=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$order_master_row->customer_no);
                //echo $this->db->last_query();

                if($address_details==FALSE){

                }else{
                    foreach($address_details as $address_details_row){
                        //echo $address_details_row->payment_condition_id;
                      $payment_term=$this->payment_term_model->select_one_active_record('payment_condition_master','id',$address_details_row->payment_condition_id,$this->session->userdata['logged_in']['language_id']);
                      if($payment_term==FALSE){

                      }else{
                          foreach($payment_term as $payment_term_row){

                            $email_content.='<tr>
                                <td width="15%">PAYMENT TERM</td>                                 
                                <td width="35%">'.$payment_term_row->lang_description.'</td>
                                <td width="10%">CREDIT DAYS</td>
                                 <td width="35%">'.$payment_term_row->net_days.'</td>
                              </tr>';
                            }
                        }                
                    }
                }
            }        

            $email_content.='<tr>
                <td width="15%">CREATED BY</td>
                <td width="35%">'.strtoupper($order_master_row->username).'</td>
                <td width="15%">APPROVED BY</td>
                <td width="35%">'.(empty($order_master_row->approval_username) ? '-' : strtoupper($order_master_row->approval_username)).'</td>
            </tr>';
            $order_master_lang_result=$this->common_model->select_one_active_record_nonlanguage_without_archive('order_master_lang',$this->session->userdata['logged_in']['company_id'],'order_master_lang.order_no',$order_master_row->order_no);
            if($order_master_lang_result==FALSE){

            }else{
                foreach($order_master_lang_result as $order_comment_row){
                    $email_content.='<tr>
                      <td><b>COMMENT</b></td>
                     <td colspan="4">'.strtoupper($order_comment_row->lang_addi_info).'</td>
                    </tr>';
                }
            }

            $email_content.='</table>';


            if($order_master_row->trans_closed==1){

              // $reasons='';
              // $order_close_reasons_master_result=$this->common_model->select_one_active_record('order_close_reasons_master',$this->session->userdata['logged_in']['company_id'],'id',$order_master_row->trans_closed_reason);
              // foreach ($order_close_reasons_master_result as $key => $order_close_reasons_master_row) {
              //   $reasons=$order_close_reasons_master_row->reasons;
              // }
                 
              $email_content.='<table cellpadding="5">
              <tr>
                  <th width="15%"><b>TRANSACTION</th>
                  <th colspan="3"></th>
              </tr>
              <tr>
                <td><b>REMARK</b></td>
                <td colspan="3" style="color:red"><b>'.strtoupper($reasons.','.$order_master_row->trans_closed_remarks).'</td>
              </tr>
              </table>';
                
            }

            $email_content.='</table>
        <br/>
        <table cellpadding="5">
            <tr >
                <th width="2%">#</th>                
                <th width="20%">PRODUCT</th>
                <th width="10%">SPEC</th>
                <th width="10%">QUANTITY</th>
                <th width="10%">UNIT RATE</td>
                <th width="10%">NET AMOUNT  '.(!empty($order_master_row->currency_id)?'('.$order_master_row->currency_id.')':'').'</th>';
                
                global $tax_arr;
                $i=0;
                foreach ($tax_master as $tax_value) {
                    $tax_arr[$i]=0;
                    $email_content.="<th colspan='2' width='10%' >".strtoupper($tax_value->lang_tax_code_desc)."</th>";
                    $i++;
                }
                
                $email_content.='<th width="10%">TOTAL'.(!empty($order_master_row->currency_id)?'('.$order_master_row->currency_id.')':'').'</th>
            </tr>
            <tr>
                <th colspan="6"></th>
                ';
            foreach ($tax_master as $tax_value) {
              $email_content.="<th>RATE</th>
                    <th>AMT</th>";
            }
            $email_content.='<th></th>
            </tr>';            
            $quantity=0;
            $total_quantity=0;
            $amount=0;
            $total_amount=0;
            $total_selling_price=0;
            foreach ($order_details as $order_details_row) {
                $quantity=$order_details_row->total_order_quantity;
                if($order_master_row->for_export==1){
                    $amount=$this->common_model->read_number($order_details_row->total_order_quantity,$this->session->userdata['logged_in']['company_id'])*$order_details_row->calc_sell_price;
                }else{
                    $amount=$this->common_model->read_number($order_details_row->total_order_quantity,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($order_details_row->selling_price,$this->session->userdata['logged_in']['company_id']);
                }
                $email_content.="<tr >
                        <td width='2%'>$order_details_row->ord_pos_no</td>
                        <td width='20%'>[$order_details_row->article_no] <br/>".$this->common_model->get_article_name($order_details_row->article_no,$this->session->userdata['logged_in']['company_id'])."</td>
                        <td>";
                        if(!empty($order_details_row->spec_id)){
                            if(substr($order_details_row->spec_id,0,1)=="S"){
                                $email_content.="<b><a href='".base_url()."/index.php/specification/view/".$order_details_row->spec_id."/".$order_details_row->spec_version_no." ' target='blank'>".$order_details_row->spec_id."_".$order_details_row->spec_version_no."</a></b>";
                            }else{
                                $bom=array('bom_no'=>$order_details_row->spec_id,
                                    'bom_version_no'=>$order_details_row->spec_version_no);
                                $data['bom']=$this->common_model->select_active_records_where("bill_of_material",$this->session->userdata['logged_in']['company_id'],$bom);
                                    foreach($data['bom'] as $bom_row){                                          
                                        $email_content.="<b><a href='".base_url()."/index.php/bill_of_material/view/".$bom_row->bom_id."' target='blank'>".$order_details_row->spec_id."_".$order_details_row->spec_version_no."</a></b>";
                                    }                                   
                                }
                            }

                        $email_content.="<br/>
                        <b><a href='".($order_master_row->order_flag==0?base_url('/index.php/artwork_new/view/'):base_url('/index.php/artwork_springtube/view/'))."".$order_details_row->ad_id."/".$order_details_row->version_no."' target='blank'>".($order_details_row->ad_id!=""? $order_details_row->ad_id."_".$order_details_row->version_no:"")."</a></b>
                        <br/><br/>";
                        if($order_details_row->delivery_date!="0000-00-00"){

                            $email_content.="<i>DELIVERY DATE</i><br/>".$this->common_model->view_date($order_details_row->delivery_date,$this->session->userdata['logged_in']['company_id']);
                        }
                       $email_content.="</td>
                        <td width='10%'>".$this->common_model->read_number($order_details_row->total_order_quantity,$this->session->userdata['logged_in']['company_id'])."</td>";

                        if($order_master_row->for_export==1){
                           $email_content.="<td width='10%' >".$order_details_row->calc_sell_price."</td>";
                        }else{
                           $email_content.="<td width='10%'>".$this->common_model->read_number($order_details_row->selling_price,$this->session->userdata['logged_in']['company_id'])."</td>";
                        }

                        $email_content.="<td width='10%'>".$amount."</td>";
                        $m=0;
                        $k=0;
                        foreach ($tax_master as $tax_value) {
                          $output = array ();
                          $data['tax_pos']=$this->common_model->select_one_active_record_nonlanguage_without_archive('tax_grid_details',$this->session->userdata['logged_in']['company_id'],'tax_id',$order_details_row->tax_pos_no);
                            foreach ($data['tax_pos'] as $tax_pos_row) {
                                $output[]=$tax_pos_row->tax_code;
                            }
                          $flag=0;
                          $out = array ();
                          $email_content.="<td>".$this->common_model->read_number($tax_value->tax_rate,$this->session->userdata['logged_in']['company_id'])."%</td><td>";

                        foreach($output as $value){
                            if($value!=''){
                                if($tax_value->tax_code==$value){
                                    $t_amount=explode ('|',$order_details_row->tax_grid_amount);
                                    $flag++;
                                }
                            }
                            if($flag>0){
                                $out[]=$flag;
                            }
                        }

                        if(!empty($out)){
                            $t_amount=explode ('|',$order_details_row->tax_grid_amount);
                            if($t_amount[$k]==''){
                                $email_content.="0";
                            }else{
                                $email_content.=$t_amount[$k];
                            }
                            $tax_arr[$m]+=$t_amount[$k];
                            $k++;
                        }
                        $email_content.='</td>';
                        $m++;

                        }
                  $email_content.="<td >".$this->common_model->read_number($order_details_row->total_selling_price,$this->session->userdata['logged_in']['company_id'])."</td>";

                  $email_content.="</tr>";

                  $total_quantity+=$quantity;
                  $total_amount+=$amount;
                  $total_selling_price+=$order_details_row->total_selling_price;

                }

                $total_gross=$total_amount+$this->common_model->read_number($total_selling_price,$this->session->userdata['logged_in']['company_id']);

                $email_content.="<tr >
                        <td colspan='3'><b>TOTAL</b></td>
                        <td ><b>".$this->common_model->read_number($total_quantity,$this->session->userdata['logged_in']['company_id'])."/-</td>
                        <td ></td>
                        <td ><b>".$total_amount."/-</td>";
                        $l=0;
                        foreach ($tax_master as $tax_value) {
                            $email_content.="<td></td>
                                <td ><b>".$tax_arr[$l]."/-</td>";
                                $l++;
                        }

                $email_content.="<td ><b>".$this->common_model->read_number($total_selling_price,$this->session->userdata['logged_in']['company_id'])."/-</td>
                    </tr>
      </table>";

      $email_content.='<br/>
      <table cellpadding="5">
        <tr >
          <th colspan="6">ORDER FOLLOWUPS</th>
        </tr>
        <tr>
          <th>SR NO</th>          
          <th>DATE</th>
          <th>FROM</th>
          <th>TO</th>
          <th>STATUS</th>
          <th>REMARK</th>
        </tr>';
          
      if($followup==FALSE){
        $email_content.="<tr>
            <td colspan='6'>NO RECORD FOUND</td>
          </tr>";

      }else{
        foreach($followup as $followup_row){

          $email_content.="<tr>
              <td>$followup_row->transaction_no</td>
               <td >".$this->common_model->view_date($followup_row->followup_date,$this->session->userdata['logged_in']['company_id'])."</td>
              <td >".strtoupper($followup_row->from_user)."</td>
              <td >".strtoupper($followup_row->to_user)."</td>
              <td >".($followup_row->status==99 ? 'SETTLED' : '')."
                ".($followup_row->status==999 && $followup_row->approved_flag==1 ? 'APPROVED' : '')."
                ".($followup_row->status==999 && $followup_row->approved_flag==2 ? 'REJECTED' : '')."
                ".($followup_row->status==1 ? 'PENDING' : '')."</td>
                <td >".strtoupper($followup_row->remark)."</td>
            </tr>";
         }
      }
    
    $email_content.='</table>
    <br/>
    <table cellpadding="5" cellspacing="0" >
            <tr class="heading" style="background-color:#DFFCFC;">
                <th colspan="5">ORDER HOLD/UNHOLD TRANSACTIONS</th>
            </tr>
            <tr>
                <td >SR NO</td>
                <td >DATE</td>
                <td >BY</td>
                <td >STATUS</td>
                <td >REASON</td>
            </tr>';
        
                if($order_transaction==FALSE){
                    $email_content.="<tr>
                            <td colspan='5' >NO RECORD FOUND</td>
                        </tr>";

                }else{
                    $j=1;
                    foreach($order_transaction as $order_transaction_row){

                        $email_content.="<tr class='item'>
                                <td >".$j."</td>
                                 <td >".$this->common_model->view_date($order_transaction_row->order_hold_date,$this->session->userdata['logged_in']['company_id'])."</td>
                                <td >".$this->common_model->get_user_name($order_transaction_row->user_id,$this->session->userdata['logged_in']['company_id'])."</td>
                                <td >".($order_transaction_row->hold_flag==1 ? 'HOLD' : 'UNHOLD')."</td>
                                <td >".$order_transaction_row->hold_reason."</td>
                            </tr>";
                            $j++;
                     }
                }
           
    $email_content.='</table>
    <br/>
    <table cellpadding="5">
            <tr >
                <th colspan="6">JOBCARD DETAILS</th>
            </tr>
            <tr >
                <th>SR NO</th>
                <th>DATE</th>
                <th>SO NO</th>
                <th>ARTICLE NO</th>
                <th>JOBCARD NO</th>
                <th>JOBCARD QTY</th>
            </tr>';

      if($order_master_row->order_flag=='1'){
        $search_production=array('sales_ord_no' =>$order_master_row->order_no,'jobcard_type'=>'2','archive'=>'0');  
      }else{
        $search_production=array('sales_ord_no' =>$order_master_row->order_no,'jobcard_type'=>'0','archive'=>'0');
      } 
           
      $production_master_result=$this->common_model->select_active_records_where('production_master',$this->session->userdata['logged_in']['company_id'],$search_production); 

      $total_jobcard_qty=0;

      if($production_master_result==FALSE){
          $email_content.="<tr>
                  <td colspan='6' >NO RECORD FOUND</td>
              </tr>";

      }else{
        $i=1;   
        foreach ($production_master_result as $production_master_row) {
          $email_content.="<tr>
              <td >".$i."</td>
               <td >".$this->common_model->view_date($production_master_row->manu_plan_date,$this->session->userdata['logged_in']['company_id'])."</td>
              <td >".$production_master_row->sales_ord_no."</td>
              <td >".$production_master_row->article_no."</td>
              <td >".$production_master_row->mp_pos_no."</td>
              <td >".$this->common_model->read_number($production_master_row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id'])."</td>
          </tr>";
          $total_jobcard_qty+=$this->common_model->read_number($production_master_row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']);
          $i++;                         
        } 

        $email_content.='<tr>TOTAL</td><td>'.$total_jobcard_qty.'</td>';
      }
      $email_content.='</table>
    <br/>
    <table cellpadding="5" cellspacing="0" >
      <tr >
          <th colspan="4">DISPATCH DETAILS</th>
      </tr>
      <tr >
          <th>SR NO</th>                  
          <th >INV DATE</th>                
          <th>INVOICE NO</th>
          <th>INVOICE QTY</th>
          
      </tr>';

      $search_invoice=array('ar_invoice_details.ref_ord_no'=>$order_master_row->order_no);

      $invoice_result=$this->sales_invoice_book_model->active_records_search_costsheet('ar_invoice_master',$search_invoice,'','',$this->session->userdata['logged_in']['company_id']); 

      $total_invoice_qty=0;

      if($invoice_result==FALSE){
          $email_content.="<tr>
                  <td colspan='4' >NO RECORD FOUND</td>
              </tr>";

      }else{
        $i=1;   
        foreach ($invoice_result as $invoice_row) {
          $email_content.="<tr >
              <td >".$i."</td>
               
              <td >".$this->common_model->view_date($invoice_row->invoice_date,$this->session->userdata['logged_in']['company_id'])."</td>
              <td >".$invoice_row->ar_invoice_no."</td>              
              <td >".$this->common_model->read_number($invoice_row->arid_qty,$this->session->userdata['logged_in']['company_id'])."</td>
          </tr>";
          $total_invoice_qty+=$this->common_model->read_number($invoice_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
          $i++;                         
        } 

        $email_content.='<tr style="font-weight:bold;"><td colspan="4" >TOTAL</td><td style="text-align:left;">'.$total_invoice_qty.'</td>';
      }  

    $email_content.="</table>";
    endforeach; 
        $email_content.="</div>
      </div>
    </body>
  </html>";



    echo $email_content;  
        
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
      $config['smtp_user']='auto.mailer@3d-neopac.com';
      $config['smtp_pass']='auto@202021';
      
      $this->load->library('email', $config);
      //$this->email->from($employee_row->mailbox);
      //$this->email->from('eknath.parkhe@3d-neopac.com');
      //$this->email->from('springprint@3d-neopac.com');
      $this->email->from('auto.mailer@3d-neopac.com');
      $this->email->to("eknath.parkhe@3d-neopac.com");
      //$this->email->to($to);     
      $this->email->cc("eknath.parkhe@3d-neopac.com");      
      $this->email->subject($subject);
      $this->email->message($email_content);
      $this->email->set_mailtype("html");

      // if ($this->email->send()) {
      //   $data['note']= 'Email send succesfully!';
      //   return 1;
      // } 
      // else{
      //   $data['error']='Email send failed!';
      //   return 0;

      // }
  


  }//function

  function create(){
      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      //$this->load->view('Loading/loading');
      //$this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
      $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
      $this->load->view('Home/footer');
  }

    function Save(){
      $data['page_name']='Sales';
      $data['module']=$this->common_model->select_active_module($this->session->userdata['logged_in']['user_id'],$this->session->userdata['logged_in']['company_id']);

       $this->form_validation->set_rules('jobcard_no[]','Jobcard_no ' ,'required|trim|xss_clean'); 

      if($this->form_validation->run()==FALSE){

        echo 'validation';
        

      }else{

        echo 'Save';
      } 

      $this->load->view('Home/header');
      $this->load->view('Home/nav',$data);
      $this->load->view('Home/subnav');
      //$this->load->view('Loading/loading');
      $this->load->view(ucwords($this->router->fetch_class()).'/active-title',$data);
      $this->load->view(ucwords($this->router->fetch_class()).'/create-form',$data);
      $this->load->view('Home/footer'); 

      
    }




         
}
 
/* End of file welcome.php */
/* Location: ./application/controllers/home.php */
