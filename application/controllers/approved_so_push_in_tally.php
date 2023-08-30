<?php

$data['order_master']=$this->sales_order_book_model->active_record_search_new('order_master',$search_data,$from,$to,$this->session->userdata['logged_in']['company_id'],$order_closed_arr,$approval_from_date,$approval_to_date);
{

}

/*
$tally_sales_order_master_result=$this->common_model->select_one_details_record_noncompany('tally_sales_order_master','order_no',$this->input->post('order_no'));

            // CHECKING RECORDS IN TALLY TABLE
            if(count($tally_sales_order_master_result)==0){       


              $data=array('status'=>'99');
              $result=$this->common_model->update_one_active_record_where('followup',$data,'record_no',$this->input->post('order_no'),'transaction_no',$this->input->post('transaction_no'),$this->session->userdata['logged_in']['company_id']);

              $data=array('final_approval_flag'=>'1','approval_date'=>date('Y-m-d'),'approved_by'=>$this->session->userdata['logged_in']['user_id']);

              $result=$this->common_model->update_one_active_record('order_master',$data,'order_no',$this->input->post('order_no'),$this->session->userdata['logged_in']['company_id']);

              //Sql Integration For tally 05-Apr-2019---------------------------


              
              $order_no=$this->input->post('order_no');
              $order_date='';
              $sales_ledger='';
              $bill_to='';
              $ship_to='';
              $po_no='';
              $part_no='';
              $order_quantity='';
              $currency='';
              $rate_of_exchange='';
              $unit_rate='';
              $net_amount='';

             
              $data['order_master_details']=$this->sales_order_book_model->select_one_active_record_for_tally_sql('order_master',$this->session->userdata['logged_in']['company_id'],'order_master.order_no',$order_no);

               //print_r($data['order_master']);
              foreach ($data['order_master_details'] as $row) {

                //Sales Ledger Types-------------


                if($row->for_export=='1'){
                  
                  if($row->customer_no=='1255' || $row->customer_no=='1231'){
                      $sales_ledger='Sales - Exports Inter company';
                  }
                  else{
                       $sales_ledger='Sales - Exports';
                  }
                  
                }else{

                  if($row->zip_code=='DN'){
                    $sales_ledger='Sales - Local';
                  }
                  else if($row->party_type=='SEZ'){
                    $sales_ledger='Sales - Deemed Exports';
                  }
                  else{
                    $sales_ledger='Sales - Interstate';
                  }

                }

                //Consignee Details--------
                if($row->consin_adr_company_id!=''){
                  $arr_consignee=explode("|",$row->consin_adr_company_id);

                  $data['ship_to']=$this->customer_model->select_one_active_record("address_master",$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$arr_consignee[0]);
                  foreach($data['ship_to'] as $ship_to_row){
                   $ship_to= $ship_to_row->name1;                        
                  }
               }else{
                $ship_to=$row->name1;
               }
                $order_date=$row->order_date;              
                $bill_to=$row->name1;              
                $po_no=$row->cust_order_no.','.$row->cust_order_date;
                $part_no=$row->article_no;

                if($row->for_export=='1'){
                  $unit_rate=$row->calc_sell_price;
                  $net_amount=$this->common_model->read_number($row->total_order_quantity,$this->session->userdata['logged_in']['company_id']) * $row->calc_sell_price;
                }

                else{

                  $unit_rate=$this->common_model->read_number($row->selling_price,$this->session->userdata['logged_in']['company_id']);
                  $net_amount=$this->common_model->read_number($row->total_order_quantity,$this->session->userdata['logged_in']['company_id']) * $this->common_model->read_number($row->selling_price,$this->session->userdata['logged_in']['company_id']);  
                }
               
                $order_quantity=$this->common_model->read_number($row->total_order_quantity,$this->session->userdata['logged_in']['company_id']);
                $currency=$row->currency_id;
                $rate_of_exchange=$this->common_model->read_number($row->exchange_rate,$this->session->userdata['logged_in']['company_id']);

                $data_tally=array('order_date'=>$order_date,
                            'order_no'=>$order_no,
                            'sales_ledger'=>$sales_ledger,
                            'bill_to'=>$bill_to,
                            'ship_to'=>$ship_to,
                            'po_no'=>$po_no,
                            'part_no'=>$part_no,
                            'order_quantity'=>$order_quantity,
                            'currency'=>$currency,
                            'rate_of_exchange'=>$rate_of_exchange,
                            'unit_rate'=>$unit_rate,
                            'net_amount'=>$net_amount,
                            'transaction_date'=>date('Y-m-d')
                          );

                $result=$this->common_model->save('tally_sales_order_master',$data_tally);
                
                
              }
  }else{
  echo "SO";
}
*/
?>