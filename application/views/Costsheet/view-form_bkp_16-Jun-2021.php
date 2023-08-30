<?php foreach ($ar_invoice_master as $ar_invoice_master_row):?>

    <?php
    $for_export=$ar_invoice_master_row->for_export;
    $exchange_rate=($ar_invoice_master_row->exchange_rate!='0' ? (strpos($ar_invoice_master_row->exchange_rate,".")!=''?$ar_invoice_master_row->exchange_rate : $this->common_model->read_number($ar_invoice_master_row->exchange_rate,$this->session->userdata['logged_in']['company_id'])) : '');
    $unit_rate='';
    $currency_id=($ar_invoice_master_row->currency_id!='' ? $ar_invoice_master_row->currency_id : '');
    
    ?>

    
    <div class="ui teal labels" style="text-align: center;">
      <div class="ui label">COST SHEET</div>
    </div>

        <?php echo $this->common_model->view_date($ar_invoice_master_row->invoice_date,$this->session->userdata['logged_in']['company_id'])!='' ? '<span class="ui blue left ribbon label"><i class="calendar alternate outline icon"></i>'.$this->common_model->view_date($ar_invoice_master_row->invoice_date,$this->session->userdata['logged_in']['company_id']).'</span>' : '';?>
        <br/>
        <br/>
        <?php foreach($ar_invoice_details as $ar_invoice_details_row):

        if($for_export==1){
        $unit_rate_in_rupees=round($ar_invoice_details_row->calc_sell_price*$exchange_rate,2);
        $net_amount_in_rupees=$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*($unit_rate_in_rupees);
        $total_tax_in_rupees=$this->common_model->read_number($ar_invoice_details_row->total_tax,$this->session->userdata['logged_in']['company_id'])*$exchange_rate;
        }else{
            $unit_rate_in_rupees=$this->common_model->read_number($ar_invoice_details_row->selling_price,$this->session->userdata['logged_in']['company_id']);
            $net_amount_in_rupees=$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$unit_rate_in_rupees;                             
            $total_tax_in_rupees=$this->common_model->read_number($ar_invoice_details_row->total_tax,$this->session->userdata['logged_in']['company_id']);
        }
        ?>


        <?php
        $order_details=array('ref_ord_no'=>$this->uri->segment(4),'article_no'=>$this->uri->segment(5));
        $result_dispatch=$this->common_model->select_active_records_where('ar_invoice_details',$this->session->userdata['logged_in']['company_id'],$order_details);
        $total_dispatch=0;
        $order_flag=0;
        //echo $this->db->last_query();
         foreach($result_dispatch as $row_total_dispatch){
            $total_dispatch+=$this->common_model->read_number($row_total_dispatch->arid_qty,$this->session->userdata['logged_in']['company_id']);
            $order_flag=$row_total_dispatch->order_flag;
        }
        $order_master_data=array('order_no'=>$this->uri->segment(4));
        $data['order_master_result']=$this->common_model->select_active_records_where('order_master',$this->session->userdata['logged_in']['company_id'],$order_master_data);
        foreach ($data['order_master_result'] as $order_master_row) {
            $po_no=$order_master_row->cust_order_no;
            $po_date=$order_master_row->cust_order_date;
            $trans_closed=$order_master_row->trans_closed;
            $packing_type=$order_master_row->for_export;
            //$order_flag=$order_master_row->order_flag;
        }
        $order_master_data=array('order_no'=>$this->uri->segment(4),'article_no'=>$this->uri->segment(5));
        $data['order_details_data']=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$order_master_data);
        $total_order_quantity=0;
        foreach($data['order_details_data'] as $order_details_row){
            $total_order_quantity=$this->common_model->read_number($order_details_row->total_order_quantity,$this->session->userdata['logged_in']['company_id']);
            $pr_pos_complete_flag=$order_details_row->pr_pos_complete_flag;
            $ad_id=$order_details_row->ad_id;
            $version_no=$order_details_row->version_no;
            $so_quantity=$order_details_row->total_order_quantity;

            if($packing_type==1){
                $order_unit_price=$order_details_row->calc_sell_price;
                $order_exchange_rate=($order_master_row->exchange_rate!='0' ? $order_master_row->exchange_rate : '');
                $order_currency_id=($order_master_row->currency_id!='' ? $order_master_row->currency_id : '');



            }else{
                $order_unit_price=$this->common_model->read_number($order_details_row->selling_price,$this->session->userdata['logged_in']['company_id']);
                $order_currency_id="";
                $order_exchange_rate="";
            }

        }

        if(!empty($ad_id)){

            $artwork['ad_id']=$ad_id;
            $artwork['version_no']=$version_no;
            $search='';
            $from='';
            $to='';
            $artwork_result=$this->artwork_model->active_record_search('artwork_devel_master',$artwork,$search,$from,$to,$this->session->userdata['logged_in']['company_id']);
			
            $this->db->last_query();
            if($artwork_result){
				foreach ($artwork_result as $artwork_row) {
                $print_type_artwork=$artwork_row->print_type;
				}
			}else{
				$artwork_result=$this->artwork_springtube_model->active_record_search('springtube_artwork_devel_master',$artwork,$search,$from,$to,$this->session->userdata['logged_in']['company_id']);
			     $this->db->last_query();
            if($artwork_result){
				foreach ($artwork_result as $artwork_row) {
                $print_type_artwork=$artwork_row->print_type;
				}
				}else{
				$print_type_artwork="";
				}
			}
            
        }else{
			
            $print_type_artwork="";
        }

        $address_master_result=$this->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'adr_company_id',$ar_invoice_master_row->customer_no);

        foreach ($address_master_result as $address_master_row) {

            $total_order_quantity=$this->common_model->read_number($so_quantity,$this->session->userdata['logged_in']['company_id']);                                   
            //Factory Tolerance-------  
            $factory_tolerance=30;
            $factory_tolerance_qty=($total_order_quantity*$factory_tolerance)/100;
            $minus_factory_dispatch_qty=$total_order_quantity-$factory_tolerance_qty;

            //Customer Tolerance-------     
            //$customer_tolerance=10;
            $customer_tolerance=0;
            $customer_tolerance=($address_master_row->dispatch_tolerance!=''?$address_master_row->dispatch_tolerance:0);

            if($customer_tolerance!=0){
                $tolerance_qty=($total_order_quantity*$customer_tolerance)/100;
                $plus_tolerance_qty=$total_order_quantity+$tolerance_qty;
                $minus_tolerance_qty=$total_order_quantity-$tolerance_qty;
            }
            else{
                
                $tolerance_qty=0;
                $plus_tolerance_qty=$total_order_quantity+$tolerance_qty;
                $minus_tolerance_qty=$total_order_quantity-$tolerance_qty;
                
            }
        }

        $total_arid_qty=0;
        $supplyqty=0;
        $cancel_qty=0;
         $search_arr=array('ref_ord_no'=>$this->uri->segment(4),'article_no'=>$this->uri->segment(5));
         $ar_invoice_details_result=$this->common_model->select_active_records_where('ar_invoice_details',$this->session->userdata['logged_in']['company_id'],$search_arr);
         foreach ($ar_invoice_details_result as $ar_invoice_details_row_row) {
                $total_arid_qty+=$ar_invoice_details_row_row->arid_qty;
            }
            $supplyqty=$this->common_model->read_number($total_arid_qty,$this->session->userdata['logged_in']['company_id']);
            $flag=0;
            if($trans_closed==1){
                $flag=1;
                if($supplyqty==0)
                    {   $status="Cancel Order";
                        $cancel_qty=$total_order_quantity;
                    }else if($supplyqty<$minus_factory_dispatch_qty){
                        $status="Manual Closed (Order cancelled from customer end) ".($pr_pos_complete_flag==0 ? "(INV)" : "(PR)")."";
                        $cancel_qty=number_format($total_order_quantity- $supplyqty,2,'.',',');
                        $status.=number_format($total_order_quantity - $supplyqty,2,'.',',');
                    }
                    else if($supplyqty<$minus_tolerance_qty && $supplyqty>$minus_factory_dispatch_qty){ 
                        $status="Manual Closed (Below Tolerance) ".($pr_pos_complete_flag==0 ? "(INV)": "(PR)")." ";
                        $cancel_qty=number_format($total_order_quantity - $supplyqty,2,'.',',');
                        $status.=number_format($total_order_quantity - $supplyqty,2,'.',',');
                        }
                    elseif($supplyqty>=$minus_tolerance_qty && $supplyqty<$total_order_quantity){
                        $status="Short Closed ".($pr_pos_complete_flag==0?"(INV)":"(PR)")." ";
                        //$cancel_qty=number_format(get_value($row_order_details['total_order_quantity'])- $supplyqty,2,'.',',');
                        $status.=number_format($total_order_quantity- $supplyqty,2,'.',',');
                    }
                    else{
                        
                        $status="Completed ".($pr_pos_complete_flag==0?"(INV)":"(PR)")." ";
                    }
                    
                }else{                              
                    
                    if($total_order_quantity<=$supplyqty && $supplyqty<>0){
                        $status="Completed ".($pr_pos_complete_flag==0?"(INV)":"(PR)")." ";
                        $flag=1;

                        //$status="Completed (INV)";
                    }
                    elseif($total_order_quantity>$supplyqty && $supplyqty<>0){
                        $status="Partially Completed ".($pr_pos_complete_flag==0?"(INV)":"(PR)")." ";
                        //$status="Partially Completed (INV)";
                        $status.=number_format($total_order_quantity- $supplyqty,2,'.',',');
                        $flag=0;

                    }
                    else{
                        $flag=0;
                        $status="Pending";
                    }
                    
                }

        $order_data=array('order_no'=>$this->uri->segment(4),'article_no'=>$this->uri->segment(5));
        $data['order']=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$order_data);
        $order_quantity=0;
        foreach($data['order'] as $order_row){
            $dia="";
            $length="";
            $print_type_bom="";
            $order_quantity=$order_row->total_order_quantity;
            if(!empty($order_row->spec_id)){
                $specs['spec_id']=$order_row->spec_id;
                $specs['spec_version_no']=$order_row->spec_version_no;
                $specs_master_result=$this->common_model->select_active_records_where('specification_sheet',$this->session->userdata['logged_in']['company_id'],$specs);
                if($specs_master_result){
                    foreach($specs_master_result as $specs_master_result_row){
                    
                    $layer_arr=explode("|", $specs_master_result_row->dyn_qty_present);
                    
                    $layer_no=substr($layer_arr[1],0,1);
                }
                $specs_result=$this->sales_order_book_model->select_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$specs);
                
                $this->db->last_query();
                if($specs_result){
                    foreach($specs_result as $specs_row){
                        $dia=$specs_row->SLEEVE_DIA;
                        $length=$specs_row->SLEEVE_LENGTH;
                        $sleeve_mb=$specs_row->SLEEVE_MASTER_BATCH;
                        $print_type_bom=$specs_row->SLEEVE_PRINT_TYPE;
                        $shoulder_type=$specs_row->SHOULDER_NECK_TYPE;
                        $shoulder_orifice=$specs_row->SHOULDER_ORIFICE;
                        $shoulder_mb=$specs_row->SHOULDER_MASTER_BATCH;
                        $shoulder_foil=$specs_row->SHOULDER_FOIL_TAG;
                        $cap_dia=$specs_row->CAP_DIA;
                        $cap_type=$specs_row->CAP_STYLE;
                        $cap_finish=$specs_row->CAP_MOLD_FINISH;
                        $cap_orifice=$specs_row->CAP_ORIFICE;
                        $cap_foil=$specs_row->CAP_FOIL_COLOR;
                        $cap_mb=$specs_row->CAP_MASTER_BATCH;
                        $cap_shrink_sleeve= $specs_row->CAP_SHRINK_SLEEVE_NAME;
                    }
                }
                $specs_lang_result=$this->common_model->select_active_records_where('specification_sheet_lang',$this->session->userdata['logged_in']['company_id'],$specs);
                if($specs_lang_result){
                    foreach ($specs_lang_result as $specs_lang_row) {
                        $specs_comment= strtoupper($specs_lang_row->lang_comments);
                        $a_ss=strpos(strtoupper($specs_lang_row->lang_comments),'SHRINK');
                        $a_met=strpos(metaphone(strtoupper($specs_lang_row->lang_comments)),'MTL');
                        $b_met=strpos(metaphone(strtoupper($specs_lang_row->lang_comments)),'MTLST');
                        $c_met=strpos(metaphone(strtoupper($specs_lang_row->lang_comments)),'MTLS');
                        if($a_ss){
                         $cap_shrink_sleeve='YES';
                     }
                     $cap_metalization="";
                     if($a_met OR $b_met OR $c_met){
                        $cap_metalization='YES';
                    }
                }
            }
        }else{
            $bom_no=$order_row->spec_id;
            $bom_version_no=$order_row->spec_version_no;
            $bom_data['bom_no']=$order_row->spec_id;
            $bom_data['bom_version_no']=$order_row->spec_version_no;
            $bom_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$bom_data);
            
            if($bom_result){
                foreach($bom_result as $bom_result_row){                                        
                    $sleeve_code=$bom_result_row->sleeve_code;
                    $shoulder_code=$bom_result_row->shoulder_code;
                    $cap_code=$bom_result_row->cap_code;
                    $label_code=$bom_result_row->label_code;
                    $print_type_bom=$bom_result_row->print_type;
                    $specs_comment=strtoupper($bom_result_row->comment);
                    $packing_type=$bom_result_row->for_export;
                }
                $sleeve_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$sleeve_code);
                //echo $this->db->last_query();
                $sleeve_spec_id="";
                $sleeve_spec_version="";
                foreach($sleeve_code_result as $sleeve_code_row){
                    $sleeve_spec_id=$sleeve_code_row->spec_id;
                    $sleeve_spec_version=$sleeve_code_row->spec_version_no;
                }

                $specs['spec_id']=$sleeve_spec_id;
                $specs['spec_version_no']=$sleeve_spec_version;

                $specs_master_result=$this->common_model->select_active_records_where('specification_sheet',$this->session->userdata['logged_in']['company_id'],$specs);
                if($specs_master_result){
                        foreach($specs_master_result as $specs_master_result_row){
                            $layer_arr=explode("|", $specs_master_result_row->dyn_qty_present);
                            $layer_no=substr($layer_arr[1],0,1);                            

                        }
                    $specs_result=$this->sales_order_book_model->select_sleeve_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$specs);
                    //echo $this->db->last_query();
                    if($specs_result){
                        foreach($specs_result as $specs_row){
                            $dia=$specs_row->SLEEVE_DIA;
                            $length=$specs_row->SLEEVE_LENGTH;
                            $sleeve_mb=$specs_row->SLEEVE_MASTER_BATCH;                             

                        }
                    }
                    //SHOULDER----------

                    $shoulder_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$shoulder_code);
                    $shoulder_spec_id="";
                    $shoulder_spec_version="";
                    foreach($shoulder_code_result as $shoulder_code_row){                                       
                        $shoulder_spec_id=$shoulder_code_row->spec_id;
                        $shoulder_spec_version=$shoulder_code_row->spec_version_no;
                    }

                    $shoulder_specs['spec_id']=$shoulder_spec_id;
                    $shoulder_specs['spec_version_no']=$shoulder_spec_version;

                    $shoulder_specs_result=$this->sales_order_book_model->select_shoulder_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$shoulder_specs);
                    if($shoulder_specs_result){
                        foreach($shoulder_specs_result as $shoulder_specs_row){
                            $shoulder_type=$shoulder_specs_row->SHOULDER_STYLE;
                            $shoulder_orifice=$shoulder_specs_row->SHOULDER_ORIFICE;
                            $shoulder_foil=($shoulder_specs_row->SHOULDER_FOIL_TAG!=''?'YES':'');
                            $shoulder_mb=$shoulder_specs_row->SHOULDER_MASTER_BATCH;                                

                        }
                    }

                    //CAP------------

                    $cap_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$cap_code);
                    $cap_spec_id="";
                    $cap_spec_version="";
                    foreach($cap_code_result as $cap_code_row){                                     
                        $cap_spec_id=$cap_code_row->spec_id;
                        $cap_spec_version=$cap_code_row->spec_version_no;
                    }

                    $cap_specs['spec_id']=$cap_spec_id;
                    $cap_specs['spec_version_no']=$cap_spec_version;

                    $cap_specs_result=$this->sales_order_book_model->select_cap_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$cap_specs);
                    
                    if($cap_specs_result==TRUE){
                        foreach($cap_specs_result as $cap_specs_row){
                            $cap_dia=$cap_specs_row->CAP_DIA;
                            $cap_type=$cap_specs_row->CAP_STYLE;
                            $cap_finish=$cap_specs_row->CAP_MOLD_FINISH;
                            $cap_orifice=$cap_specs_row->CAP_ORIFICE;
                            $cap_mb=$cap_specs_row->CAP_MASTER_BATCH;
                            $cap_foil=$this->common_model->get_article_name($cap_specs_row->CAP_FOIL_CODE,$this->session->userdata['logged_in']['company_id']);
                            $cap_shrink_sleeve=$this->common_model->get_article_name($cap_specs_row->CAP_SHRINK_SLEEVE_CODE,$this->session->userdata['logged_in']['company_id']);
                            $cap_metalization=$cap_specs_row->CAP_METALIZATION;                         

                        }
                    }else{

                            $cap_dia="";
                            $cap_type="";
                            $cap_finish="";
                            $cap_orifice="";
                            $cap_mb="";
                            $cap_foil="";
                            $cap_shrink_sleeve="";
                            $cap_metalization=""; 

                    }


                }//SPECS MASTER

            }//BOM RESULT
        }

        //ELSE
    }

    }

    if($print_type_artwork==""){

            $print_type_artwork=$print_type_bom;

        }

    ?>


        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
        
            <tr class="heading">
                <td width="10%"><b>BILLING</b></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><?php echo $ar_invoice_master_row->customer_name;?></td>
                <td width="10%"><b>PRODUCT CODE</p></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%"><?php echo $ar_invoice_details_row->article_no;?> </td>
            </tr>

            <tr class="item">
                <td width="10%"><b>PRODUCT</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="50%" colspan='4' ><?php echo $this->common_model->get_article_name($ar_invoice_details_row->article_no,$this->session->userdata['logged_in']['company_id']);?></td>
            </tr>

            <tr class="item">
                <td width="10%"><b>DIA X LENGTH</b></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><?php echo $dia."X".$length;?> <span style="border-left:1px solid #ddd;margin-left: 100px;padding-left: 10px;border-right:1px solid #ddd;padding-right: 10px;"><b>LAYER </b></span>&nbsp;&nbsp;&nbsp;<?php echo $ar_invoice_details_row->layer_no;?></td>
                <td width="10%"><b>PRINT TYPE</p></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%"><?php echo $print_type_artwork=($print_type_artwork=='' ? $print_type_bom : $print_type_artwork);?></td>
            </tr>
        
            <tr class="item">
                <td width="10%"><b>ORDER NO</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b><a href="<?php echo base_url('index.php/sales_order_book/view/'.$ar_invoice_details_row->ref_ord_no);?>" target='_blank'><?php echo $ar_invoice_details_row->ref_ord_no;?></a></b> <?php echo $status;?></td>
                <td width="10%"><b>INVOICE NO</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%"><?php echo $ar_invoice_master_row->ar_invoice_no;?></td>
            </tr>

            <tr class="item">
                <td width="10%"><b>ORDER QTY</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><?php echo number_format($this->common_model->read_number($order_quantity,$this->session->userdata['logged_in']['company_id']));?></td>
                <td width="10%"><b>INVOICE QTY</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%"><?php echo number_format($this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']));?></td>
            </tr>

            <tr class="item">
                <td width="10%"><b>ORDER RATE</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><?php echo ($order_currency_id!='' ? $order_currency_id : '')." ".$order_unit_price;?></td>
                <td width="10%"><b>INVOICE RATE</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%">&#8377; <?php echo $unit_rate_in_rupees;?> <?php echo ($for_export==1 ? "(".$ar_invoice_master_row->currency_id." ".$ar_invoice_details_row->calc_sell_price." X  Exchange Rate ".$this->common_model->read_number($ar_invoice_master_row->exchange_rate,$this->session->userdata['logged_in']['company_id']).")" : ''); ?> </td>
            </tr>

            <tr class="item">
                <td width="10%"><b>ORDER NET VALUE</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><?php echo ($order_currency_id!='' ? $order_currency_id : '');?>&nbsp;<?php echo number_format($this->common_model->read_number($order_quantity,$this->session->userdata['logged_in']['company_id'])*$order_unit_price);?>/-</td>
                <td width="10%"><b>INVOICE NET VALUE</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%">&#8377; <?php echo number_format($unit_rate_in_rupees*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']));?>/-</td>
            </tr>
        
        </table>



        <!--
        <table cellpadding='5' cellspacing='0' style='border:1px solid #D9d9d9;'>
            <?php

            
            $query=$this->db->query("SELECT DISTINCT article_name_info.article_group_id, article_name_info.main_group_id, article_group_desc.lang_article_group_desc FROM `reserved_quantity_manu`
                                    LEFT JOIN article_name_info ON reserved_quantity_manu.article_no = article_name_info.article_no
                                    LEFT JOIN article_group_desc ON article_group_desc.article_group_id = article_name_info.article_group_id
                                    WHERE reserved_quantity_manu.company_id = article_name_info.company_id
                                    AND reserved_quantity_manu.`date_required`
                                    BETWEEN '2018-04-01'
                                    AND '".$ar_invoice_master_row->invoice_date."'
                                    AND reserved_quantity_manu.type_flag =2
                                    AND article_name_info.main_group_id <>5
                                    AND article_group_desc.lang_article_group_desc IS NOT NULL
                                    GROUP BY article_name_info.article_group_id
                                    ORDER BY article_name_info.main_group_id ASC");

            $result=$query->result();

            $i=0;
            global $total_array;
            foreach($result as $row_rm){
                echo "<tr class='item'>
                <td class='label' width='10%'><b>".substr($row_rm->lang_article_group_desc,0,5)."</b></td>
                <td class='label' width='5%'></td>
                <td class='label'  width='35%'>";
                $master_array= array('article_no' =>$this->uri->segment(5),'sales_ord_no'=>$this->uri->segment(4));
                $data1=array_filter($master_array);
                $data2['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from="",$to="",$this->session->userdata['logged_in']['company_id']);
                $total_total_rm=0;
                $total_rm=0;
                echo "<table style='border:none;'' cellspacing='0' cellpadding='0'>";
                        foreach($data2['job_card'] as $job_card_row){
                            $query=$this->db->query("SELECT sum(reserved_quantity_manu.total_qty)*reserved_quantity_manu.calculated_purchase_price as rm_sum,article_name_info.article_group_id FROM `reserved_quantity_manu` LEFT JOIN article_name_info  ON  reserved_quantity_manu.article_no=article_name_info.article_no AND reserved_quantity_manu.company_id=article_name_info.company_id where reserved_quantity_manu.manu_order_no='$job_card_row->mp_pos_no' and  article_name_info.article_group_id='$row_rm->article_group_id' group by reserved_quantity_manu.calculated_purchase_price");
                            $total_rm=0;
                            $arr=array();
                            $j=0;
                            $result2=$query->result();
                            foreach($result2 as $rm_sum){
                                $a=$this->common_model->read_number($rm_sum->rm_sum,$this->session->userdata['logged_in']['company_id']);
                                if(empty($a)){echo "";}
                                 $total_rm+=$this->common_model->read_number(($a/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),$this->session->userdata['logged_in']['company_id']);
                                 if($rm_sum->article_group_id==$row_rm->article_group_id){
                                    $total_array[$i]=0;
                                    $total_array[$i]+=($a/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
                                    $i;
                                }
                                $j++;
                                echo number_format($total_rm,2);
                            }
                        }
                echo "</table>";

                echo "</td>
                <td class='label' width='10%'></td>
                <td class='label' width='5%'></td>
                <td class='label' width='35%'></td></tr>";
                $total_array[$i]=0;
                $i++;
             } 
             ?>
         </table>-->
        <br/>
        <?php

            $coex_jobcard_no='';
            $spring_printing_jobcard='';
            $spring_bodymaking_jobcard='';

            $data_jobcard= array('article_no' =>$this->uri->segment(5),'sales_ord_no'=>$this->uri->segment(4),'archive'=>0);

            $result_production_master=$this->common_model->select_active_records_where('production_master',$this->session->userdata['logged_in']['company_id'],$data_jobcard);
            foreach ($result_production_master as $key => $production_master_row) {
                if($production_master_row->jobcard_type==2){
                    $spring_printing_jobcard=$production_master_row->mp_pos_no;
                }else if($production_master_row->jobcard_type==3){
                    $spring_bodymaking_jobcard=$production_master_row->mp_pos_no;
                }else{
                    $coex_jobcard_no=$production_master_row->mp_pos_no;
                }
                
            }
            


        ?>

        
        <table cellpadding='5' cellspacing='0' style='border:1px solid #D9d9d9;'>
            <tr class="heading">
                <td colspan="8" style='border-bottom:1px solid #D9d9d9;'><b>EXTRUSION PROCESS :  <b>
                <?php 
                echo ($order_flag==1 ? "FILM " : "SLEEVE "); 
                echo "MATERIAL";?>                
                : 
                <?php 

                    if($order_flag!=1){

                        foreach ($result_production_master as $key => $production_master_row) { 

                            if($production_master_row->jobcard_type=='0'){

                                $coex_jobcard_no=$production_master_row->mp_pos_no;
                                echo'<a href="'.base_url('index.php/sales_order_item_parameterwise/view_new/').$coex_jobcard_no.'/'.$bom_no.'/'.$bom_version_no.'" target="_blank">'.$coex_jobcard_no.'</a>';
                                echo'&nbsp';

                                echo "//";

                                echo'<a href="http://localhost:19281/3dtechnopack/projects/twerp/tracking-report.php?sono='.$this->uri->segment(4).'&psppsm_no='.$this->uri->segment(5).'&jobcardno='.$coex_jobcard_no.'" target="_blank">PRODUCTION</a>';
                                echo'&nbsp';

                            }                      
                            
                        }
                
                    }                       
                      
                ?> 
                </td>
            </tr>

            <tr class="heading item">
                <td width="10%" ><b>GROUP</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b>MATERIAL</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b>QUANTITY</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>PRICE</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>TOTAL COST</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>COST/TUBE</td>
                <td width="10%" style='text-align:right'>PROCESSWISE COST/TUBE</td>
            </tr>
        <?php
        $total_extrusion_cost=0;
        $extrusion_cost=0;
        $total_extrusion_quantity=0;
        $extrusion_quantity=0;
        $master_array= array('article_no' =>$this->uri->segment(5),'sales_ord_no'=>$this->uri->segment(4));
        $data1=array_filter($master_array);
        $data2['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from="",$to="",$this->session->userdata['logged_in']['company_id']);
        //echo $this->db->last_query();

        foreach($data2['job_card'] as $job_card_row){
            if($ar_invoice_details_row->order_flag==1){
                $data=array('manu_order_no'=>$job_card_row->mp_pos_no,'completed_flag'=>'1','work_proc_no'=>'1','from_job_card'=>'1','sfg_flag'=>'1');
                $data['job_card_issued']=$this->common_model->select_one_active_record_nonlanguage_without_archives_order_by('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$data,'','work_proc_no');

                if($data['job_card_issued']==TRUE){
                
            $i=1;
            foreach ($data['job_card_issued'] as $job_card_row):
                $article_desc="";
                $calculated_purchase_price="";
                $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$job_card_row->article_no);
                foreach($data['article'] as $article_row){
                 $article_desc=$article_row->article_name;
                 $sub_group=$article_row->sub_group;
                 $main_group=$article_row->main_group;
                 $uom=$article_row->uom;
                }

            $data['workprocedure_types_master']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id',$job_card_row->work_proc_no);
                foreach($data['workprocedure_types_master'] as $row_workprocedure_types_master){
                    $process=$row_workprocedure_types_master->lang_description;
                }

            $extrusion_cost=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

            $extrusion_quantity=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

            echo "<tr class='item'><td class='label' width='10%' >".$main_group."</td>
                    <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                    <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".substr($article_desc,0,18)."</td>
                    <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".round($extrusion_quantity,2)." ".$uom."</td>
                    <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id'])." / ".$uom."</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($extrusion_cost,2)."</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'></td>
                    <td width='10%'></td>
                </tr>";
                $total_extrusion_cost+=$extrusion_cost;
                $total_extrusion_quantity+=$extrusion_quantity;
                $i++;
            endforeach;
            }else{
                    //echo "<tr><td colspan='8'>NO EXTRUSION FOR THIS JOB</td></tr>";
                }

            }else{


            $data=array('manu_order_no'=>$job_card_row->mp_pos_no,'completed_flag'=>'1','work_proc_no'=>'1','from_job_card'=>'1','sfg_flag'=>'0');
            $data['job_card_issued']=$this->common_model->select_one_active_record_nonlanguage_without_archives_order_by('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$data,'','work_proc_no');
            //echo $this->db->last_query();
            if($data['job_card_issued']==TRUE){

            $i=1;
            foreach ($data['job_card_issued'] as $job_card_row):
                $article_desc="";
                $calculated_purchase_price="";
                $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$job_card_row->article_no);
                foreach($data['article'] as $article_row){
                 $article_desc=$article_row->article_name;
                 $sub_group=$article_row->sub_group;
                 $main_group=$article_row->main_group;
                 $uom=$article_row->uom;
                }

            $data['workprocedure_types_master']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id',$job_card_row->work_proc_no);
                foreach($data['workprocedure_types_master'] as $row_workprocedure_types_master){
                    $process=$row_workprocedure_types_master->lang_description;
                }

            $extrusion_cost=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

            $extrusion_quantity=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

            echo "<tr class='item'><td class='label' width='10%' >".$sub_group."</td>
                    <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                    <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$article_desc."</td>
                    <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".round($extrusion_quantity,2)." ".$uom."</td>
                    <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>".$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id'])." / ".$uom."</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($extrusion_cost,2)."</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($extrusion_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2)."</td>
                    <td width='10%'></td>
                </tr>";
                $total_extrusion_cost+=$extrusion_cost;
                $total_extrusion_quantity+=$extrusion_quantity;
                $i++;
            endforeach;
            }else{
                    echo "<tr><td colspan='8'>NO EXTRUSION FOR THIS JOB</td></tr>";
                }
            }
        }

        echo "<tr class='heading'>
                <td><b>TOTAL</td>
                <td></td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'>".round($total_extrusion_quantity,2)."</td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'><b>&#8377; ".round($total_extrusion_cost,2)."</b></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($total_extrusion_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2)."</td>
                <td></td>
            </tr>";
        ?>
        </table>

<!-- Extrusion End -->


<!-- Purging Start -->




        <table cellpadding='5' cellspacing='0' style='border:1px solid #D9d9d9;'>
            <tr class="heading">
                <td colspan="8" style='border-bottom:1px solid #D9d9d9;'><b>PURGING MATERIAL</td>
            </tr>

            <tr class="heading item">
                <td width="10%" ><b>GROUP</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b>MATERIAL</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b>QUANTITY</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>PRICE</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>TOTAL COST</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>COST/TUBE</td>
                <td width="10%" style='text-align:right'>PROCESSWISE COST/TUBE</td>
            </tr>
        <?php
        $total_purging_cost=0;
        $purging_cost=0;
        $total_purging_quantity=0;
        $purging_quantity=0;
        $master_array= array('article_no' =>$this->uri->segment(5),'sales_ord_no'=>$this->uri->segment(4));
        $data1=array_filter($master_array);
        $data2['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from="",$to="",$this->session->userdata['logged_in']['company_id']);
        foreach($data2['job_card'] as $job_card_row){
            $data=array('manu_order_no'=>$job_card_row->mp_pos_no,'completed_flag'=>'1','work_proc_no'=>'9');
            $data['job_card_issued']=$this->common_model->select_one_active_record_nonlanguage_without_archives_order_by('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$data,'','work_proc_no');
            if($data['job_card_issued']==TRUE){
                $i=1;
            foreach ($data['job_card_issued'] as $job_card_row):
                $article_desc="";
                $calculated_purchase_price="";
                $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$job_card_row->article_no);
                foreach($data['article'] as $article_row){
                 $article_desc=$article_row->article_name;
                 $sub_group=$article_row->sub_group;
                 $main_group=$article_row->main_group;
                 $uom=$article_row->uom;
                }

            $data['workprocedure_types_master']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id',$job_card_row->work_proc_no);
                foreach($data['workprocedure_types_master'] as $row_workprocedure_types_master){
                    $process=$row_workprocedure_types_master->lang_description;
                }

            $purging_cost=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

            $purging_quantity=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

            echo "<tr class='item'><td class='label' width='10%' >".$sub_group."</td>
                    <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                    <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$article_desc."</td>
                    <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".round($purging_quantity,2)." ".$uom."</td>
                    <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id'])." / ".$uom."</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($purging_cost,5)."</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($purging_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),5)."</td>
                    <td width='10%'></td>
                </tr>";
                $total_purging_cost+=$purging_cost;
                $total_purging_quantity+=$purging_quantity;
                $i++;
            endforeach;
            }else{
                echo "<tr><td colspan='8'>NO PURGING FOR THIS JOB</td></tr>";
            }
        }

        echo "<tr class='heading'>
                <td><b>TOTAL</td>
                <td></td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'>".round($total_purging_quantity,2)."</td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'><b>&#8377; ".round($total_purging_cost,2)."</b></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($total_purging_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2)."</td>
                <td></td>
            </tr>";
        ?>
        </table>



        <br/>



        <table cellpadding='5' cellspacing='0' style='border:1px solid #D9d9d9;'>
            
            <tr class="heading">
                <td colspan="8" style='border-bottom:1px solid #D9d9d9;'><b>HEADING PROCESS : SHOULDER MATERIAL: 
                    <?php 
                    if($order_flag==1){

                       foreach ($result_production_master as $key => $production_master_row) {

                            if($production_master_row->jobcard_type=='3'){ 

                                echo'<a href="'.base_url('index.php/sales_order_item_parameterwise/view_new/').$production_master_row->mp_pos_no.'/'.$bom_no.'/'.$bom_version_no.'" target="_blank">'.$production_master_row->mp_pos_no.'</a>';

                                echo'&nbsp;: ';
                            }
                        }    
                    }

                    ?>
                </td>
            </tr>

            <tr class="heading item">
                <td width="10%" ><b>GROUP</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b>MATERIAL</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b>QUANTITY</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>PRICE</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>TOTAL COST</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>COST/TUBE</td>
                <td width="10%" style='text-align:right;'>PROCESSWISE COST/TUBE</td>
            </tr>

            
        <?php
        $total_heading_cost=0;
        $heading_cost=0;
        $total_heading_quantity=0;
        $heading_quantity=0;
        if($order_flag==1){
        $master_array= array('article_no' =>$this->uri->segment(5),'sales_ord_no'=>$this->uri->segment(4),'jobcard_type'=>'3');
        }else{
        $master_array= array('article_no' =>$this->uri->segment(5),'sales_ord_no'=>$this->uri->segment(4));
        }
        $data1=array_filter($master_array);
        $data2['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from="",$to="",$this->session->userdata['logged_in']['company_id']);
        foreach($data2['job_card'] as $job_card_row){
            $data=array('manu_order_no'=>$job_card_row->mp_pos_no,'completed_flag'=>'1','work_proc_no'=>'2','from_job_card'=>'1');
            $data['job_card_issued']=$this->common_model->select_one_active_record_nonlanguage_without_archives_order_by('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$data,'','work_proc_no');
            if($data['job_card_issued']==TRUE){
            $i=1;
           foreach ($data['job_card_issued'] as $job_card_row):
            $article_desc="";
            $calculated_purchase_price="";
            $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$job_card_row->article_no);
            foreach($data['article'] as $article_row){
             $article_desc=$article_row->article_name;
             $sub_group=$article_row->sub_group;
             $main_group=$article_row->main_group;
             $uom=$article_row->uom;
            }

            $data['workprocedure_types_master']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id',$job_card_row->work_proc_no);
                foreach($data['workprocedure_types_master'] as $row_workprocedure_types_master){
                    $process=$row_workprocedure_types_master->lang_description;
                }


            if($order_flag==1){
            

            $query=$this->db->query("SELECT * from reserved_quantity_manu where manu_order_no='$job_card_row->manu_order_no' and article_no='$job_card_row->article_no' and ref_mm_id='$job_card_row->mm_id'");

            $result_heading_value=$query->result();
            if($result_heading_value==TRUE){

            foreach($result_heading_value as $result_heading_value_row){
                if($result_heading_value_row->total_qty!=$job_card_row->demand_qty){

                $heading_cost=($this->common_model->read_number($result_heading_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

                $heading_quantity=($this->common_model->read_number($result_heading_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

                        }else{



                $heading_cost=($this->common_model->read_number($result_heading_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

                $heading_quantity=($this->common_model->read_number($result_heading_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
                        }
                    }
                }

            }else{

                $heading_cost=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

               $heading_quantity=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

            }




            echo "<tr class='item'><td class='label' width='10%' >".$sub_group."</td>
                    <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                    <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$article_desc."</td>
                    <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".round($heading_quantity,2)." ".$uom."</td>
                    <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id'])." / ".$uom."</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($heading_cost,2)."</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($heading_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2)."</td>
                    <td width='10%' style='text-align:right'></td>
                </tr>";
                $total_heading_cost+=$heading_cost;
                $total_heading_quantity+=$heading_quantity;
                $i++;
            endforeach;
        }else{
                echo "<tr><td colspan='8'>NO HEADING FOR THIS JOB</td></tr>";
            }
        }

         echo "<tr class='heading'>
                <td><b>TOTAL</td>
                <td></td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'>".round($total_heading_quantity,2)."</td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'><b>&#8377; ".round($total_heading_cost,2)."</b></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($total_heading_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2)."</td>
                <td></td>
            </tr>";
        ?>
        </table>

        <br/>

        <table cellpadding='5' cellspacing='0' style='border:1px solid #D9d9d9;'>
            <tr class="heading">
                <td colspan="8" style='border-bottom:1px solid #D9d9d9;'><b>PRINTING PROCESS:

                <?php 
                    if($order_flag==1){

                       foreach ($result_production_master as $key => $production_master_row) {

                            if($production_master_row->jobcard_type=='2'){ 

                                echo'<a href="'.base_url('index.php/sales_order_item_parameterwise/view_new/').$production_master_row->mp_pos_no.'/'.$bom_no.'/'.$bom_version_no.'" target="_blank">'.$production_master_row->mp_pos_no.'</a>';
                                echo'&nbsp;: ';
                            }
                        }    
                    }
                ?>
            </td>
            </tr>

            <tr class="heading item">
                <td width="10%" ><b>GROUP</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b>MATERIAL</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b>QUANTITY</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>PRICE</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>TOTAL COST</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>COST/TUBE</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>PROCESSWISE COST/TUBE</td>
            </tr>

        <?php
        $total_printing_cost=0;
        $printing_cost=0;
        $total_printing_quantity=0;
        $printing_quantity=0;
        $master_array= array('article_no' =>$this->uri->segment(5),'sales_ord_no'=>$this->uri->segment(4));
        $data1=array_filter($master_array);
        $data2['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from="",$to="",$this->session->userdata['logged_in']['company_id']);
        foreach($data2['job_card'] as $job_card_row){
            $data=array('manu_order_no'=>$job_card_row->mp_pos_no,'completed_flag'=>'1','work_proc_no'=>'3');
            $data['job_card_issued']=$this->common_model->select_one_active_record_nonlanguage_without_archives_order_by('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$data,'','work_proc_no');
            if($data['job_card_issued']==TRUE){
            $i=1;
           foreach ($data['job_card_issued'] as $job_card_row):
            $article_desc="";
            $calculated_purchase_price="";
            $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$job_card_row->article_no);
            foreach($data['article'] as $article_row){
             $article_desc=$article_row->article_name;
             $sub_group=$article_row->sub_group;
             $main_group=$article_row->main_group;
             $uom=$article_row->uom;
            }

            $data['workprocedure_types_master']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id',$job_card_row->work_proc_no);
                foreach($data['workprocedure_types_master'] as $row_workprocedure_types_master){
                    $process=$row_workprocedure_types_master->lang_description;
                }

                if($ar_invoice_master_row->invoice_date>'2020-10-31'){
                    $query=$this->db->query("SELECT * from reserved_quantity_manu where manu_order_no='$job_card_row->manu_order_no' and article_no='$job_card_row->article_no' and ref_mm_id='$job_card_row->mm_id'");
                }else{
                    $query=$this->db->query("SELECT * from reserved_quantity_manu where manu_order_no='$job_card_row->manu_order_no' and article_no='$job_card_row->article_no'");
                }
                
                //echo $this->db->last_query();

                $result_printing_value=$query->result();
                if($result_printing_value==FALSE){
                    $ar_printing_quantity=0;
                    $ar_printing_cost=0;
                }else{
                foreach($result_printing_value as $result_printing_value_row){

                    $ar_printing_cost=($this->common_model->read_number($result_printing_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($result_printing_value_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

                    $ar_printing_quantity=($this->common_model->read_number($result_printing_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
                    }
                }

                $m_printing_cost=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

                $m_printing_quantity=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

                if($ar_printing_quantity==$m_printing_quantity){
                
                    $printing_quantity=$m_printing_quantity;
                    $printing_cost=$m_printing_cost;
                }else{
                    $printing_quantity=$ar_printing_quantity;
                    $printing_cost=$ar_printing_cost;
                }

                //echo $this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id']);

            

           echo "<tr class='item'><td class='label' width='10%' >".$sub_group."</td>
                    <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                    <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$article_desc."</td>
                    <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".round($printing_quantity,2)." ".$uom."</td>
                    <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id'])." / ".$uom."</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($printing_cost,2)."</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($printing_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2)."</td>
                    <td width='10%' style='text-align:right'></td>
                </tr>";
                $total_printing_cost+=$printing_cost;
                $total_printing_quantity+=$printing_quantity;
                $i++;
            endforeach;
        }else{
                echo "<tr><td colspan='8'>NO LACQUERING FOR THIS JOB</td></tr>";
            }
        }

        /*echo "<tr class='heading'>
                <td><b>TOTAL</td>
                <td></td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'>".round($total_printing_quantity,2)."</td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'><b>".round($total_printing_cost,2)."</b></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'>".round($total_printing_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2)."</td>
                <td></td>
            </tr>";*/
        ?>

        <!--<tr class="heading">
            <td colspan="8" style='border-bottom:1px solid #D9d9d9;'><b>INK MATERIAL (COST MASTER)</td>
        </tr>
        <tr class="heading item">
            <td width="10%" ><b>GROUP</td>
            <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
            <td width="35%" style="border-right:1px solid #D9d9d9;"><b>MATERIAL</td>
            <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b>QUANTITY</td>
            <td width="5%" style='border-right:1px solid #D9d9d9;text-align:right'>COST/TUBE</td>
            <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>TOTAL COST</td>
            <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>COST/TUBE</td>
            <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>PROCESSWISE COST/TUBE</td>
        </tr>-->
        <?php
        $total_ink_cost=0;
        if(strcmp($print_type_artwork, 'SCREEN') == 0 || strcmp($print_type_artwork, 'SCREEN+UPTO NECK') == 0 || strcmp($print_type_artwork, 'SCREEN + LABEL') == 0 || strcmp($print_type_artwork, 'SCREEN+FLEXO') == 0 || strcmp($print_type_artwork, 'OFFSET SCREEN') == 0 || strcmp($print_type_artwork, 'FLEXO+SCREEN') == 0 || strcmp($print_type_artwork, 'Screen') == 0){

            if($ar_invoice_master_row->invoice_date<'2020-10-01'){
            

            $screen_ink_value_row=0;
            $query=$this->db->query("SELECT * from ink_consumption_master where lacquer_type_id='3' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
            $result_screen_ink_value=$query->result();
            if($result_screen_ink_value==TRUE){
            foreach($result_screen_ink_value as $result_screen_ink_value_row){
                $screen_ink_value_row=$result_screen_ink_value_row->cost_per_tube*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

                echo "<tr class='item'><td class='label' width='10%' >INK</td>
                        <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                        <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$result_screen_ink_value_row->rm."</td>
                        <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'></td>
                        <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'></td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($screen_ink_value_row,2)."</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($result_screen_ink_value_row->cost_per_tube,2)."</td>
                        <td width='10%' style='text-align:right'></td>
                    </tr>";
                    $total_ink_cost+=$screen_ink_value_row;
                }
            }else{
                echo "<tr><td colspan='8'>SCREEN INK COSTSHEET MASTER IS NOT ENTERED</td></tr>";
            }


            }else{

                $screen_ink_value_row=0;
                $s_screen_ink_value_row=0;
                $screen_ink_value_cost_per_kg=0;
                $s_screen_ink_value_cost_per_kg=0;
                $screen_ink_value_gm_tube=0;
                $s_screen_ink_value_gm_tube=0;

                $query=$this->db->query("SELECT * from ink_price_master where ink_id='3' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
                $result_screen_ink_value=$query->result();
                if($result_screen_ink_value==TRUE){
                   foreach($result_screen_ink_value as $result_screen_ink_value_row){
                        $screen_ink_value_cost_per_kg=$result_screen_ink_value_row->cost_per_kg;

                        $query=$this->db->query("SELECT * from ink_price_master where ink_id='4' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
                        $result_s_screen_ink_value=$query->result();
                        foreach($result_s_screen_ink_value as $result_s_screen_ink_value_row){
                            $s_screen_ink_value_cost_per_kg=$result_s_screen_ink_value_row->cost_per_kg;
                        }


                        $query=$this->db->query("SELECT * from coex_ink_consumption_master where article_no='".$this->uri->segment(5)."' and artwork_no='$ad_id' and artwork_version_no='$version_no' and archive<>1 limit 0,1");
                        $result_screen_ink_gm_tube_result=$query->result();

                        $screen_ink_gm_tube=0;
                        $s_screen_ink_gm_tube=0;

                        if($result_screen_ink_gm_tube_result==FALSE){

                        echo "<tr><td colspan='8'><i style='color:red;'>SCREEN INK GM/TUBE FOR PRODUCT IS NOT ENTERED</i></td></tr>";

                         }else{
                            foreach($result_screen_ink_gm_tube_result as $result_screen_ink_gm_tube_row){

                                $screen_ink_value_row=(($result_screen_ink_gm_tube_row->screen_ink_gm_tube*($ar_invoice_details_row->arid_qty/100))/1000)*$screen_ink_value_cost_per_kg;
                                $screen_ink_gm_tube=$result_screen_ink_gm_tube_row->screen_ink_gm_tube;


                                $s_screen_ink_value_row=(($result_screen_ink_gm_tube_row->special_ink_gm_tube*($ar_invoice_details_row->arid_qty/100))/1000)*$s_screen_ink_value_cost_per_kg;

                                $s_screen_ink_gm_tube=$result_screen_ink_gm_tube_row->special_ink_gm_tube;
                            }


                echo "<tr class='item'><td class='label' width='10%' >SCREEN INK</td>
                        <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                        <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$result_screen_ink_value_row->rm."<br/>".$screen_ink_gm_tube." GM/TUBE X ".($ar_invoice_details_row->arid_qty/100)."</td>
                        <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".round(($screen_ink_gm_tube*($ar_invoice_details_row->arid_qty/100)/1000),2)." KGS</td>
                        <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($screen_ink_value_cost_per_kg,2)." / KGS</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($screen_ink_value_row,2)."</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round(($screen_ink_value_row)/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2)."</td>
                        <td width='10%' style='text-align:right'></td>
                        </tr>";

                        if($s_screen_ink_gm_tube<>''){

                            echo "<tr class='item'><td class='label' width='10%' >SPECIAL SCREEN INK</td>
                        <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                        <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$result_s_screen_ink_value_row->rm."<br/>".$s_screen_ink_gm_tube." GM/TUBE X ".($ar_invoice_details_row->arid_qty/100)."</td>
                        <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".round(($s_screen_ink_gm_tube*($ar_invoice_details_row->arid_qty/100)/1000),2)." KGS</td>
                        <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($s_screen_ink_value_cost_per_kg,2)." / KGS</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($s_screen_ink_value_row,2)."</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round(($s_screen_ink_value_row)/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2)."</td>
                        <td width='10%' style='text-align:right'></td>
                        </tr>";

                        }

               

                        }


                    }

                    $total_ink_cost+=$screen_ink_value_row+$s_screen_ink_value_row; 
                }else{
                    echo "<tr><td colspan='8'>SCREEN INK COSTSHEET MASTER IS NOT ENTERED</td></tr>";
                }
                

            }

        }

        if(strcmp($print_type_artwork, 'OFFSET') == 0 || strcmp($print_type_artwork, 'OFFSET SCREEN') == 0  || strcmp($print_type_artwork, 'LABEL OFFSET') == 0){

            if($ar_invoice_master_row->invoice_date<'2020-10-01'){

            $offset_ink_value_row=0;
            $query=$this->db->query("SELECT * from ink_consumption_master where lacquer_type_id='2' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
            $result_offset_ink_value=$query->result();
            if($result_offset_ink_value==TRUE){
            foreach($result_offset_ink_value as $result_offset_ink_value_row){
                $offset_ink_value_row=$result_offset_ink_value_row->cost_per_tube*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

                echo "<tr class='item'><td class='label' width='10%' >INK</td>
                        <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                        <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$result_offset_ink_value_row->rm."</td>
                        <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'></td>
                        <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'></td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($offset_ink_value_row,2)."</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($result_offset_ink_value_row->cost_per_tube,2)."</td>
                        <td width='10%' style='text-align:right'></td>
                    </tr>";
                    $total_ink_cost+=$offset_ink_value_row;
                }
            }else{
                echo "<tr><td colspan='8'>OFFSET INK COSTSHEET MASTER IS NOT ENTERED</td></tr>";
            }

            }else{

                //echo "hiiiiiiiiiii";

                $offset_ink_value_row=0;
                $offset_ink_value_cost_per_kg=0;
                $offset_ink_value_gm_tube=0;
                $query=$this->db->query("SELECT * from ink_price_master where ink_id='2' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
                $result_offset_ink_value=$query->result();
                foreach($result_offset_ink_value as $result_offset_ink_value_row){
                    $offset_ink_value_cost_per_kg=$result_offset_ink_value_row->cost_per_kg;

                    $query=$this->db->query("SELECT * from coex_ink_consumption_master where article_no='".$this->uri->segment(5)."' and artwork_no='$ad_id' and artwork_version_no='$version_no' and archive<>1 limit 0,1");

                    $result_offset_ink_gm_tube_result=$query->result();
                    $offset_ink_gm_tube=0;
                    if($result_offset_ink_gm_tube_result==FALSE){

                        echo "<tr><td colspan='8'><i style='color:red;'>OFFSET INK GM/TUBE FOR PRODUCT IS NOT ENTERED</i></td></tr>";

                    }else{
                            foreach($result_offset_ink_gm_tube_result as $result_offset_ink_gm_tube_row){
                                $offset_ink_value_row=(($result_offset_ink_gm_tube_row->offset_ink_gm_tube*($ar_invoice_details_row->arid_qty/100))/1000)*$offset_ink_value_cost_per_kg;
                                $offset_ink_gm_tube=$result_offset_ink_gm_tube_row->offset_ink_gm_tube;
                            }

                    echo "<tr class='item'><td class='label' width='10%' >OFFSET INK</td>
                        <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                        <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$result_offset_ink_value_row->rm."<br/>".$offset_ink_gm_tube." GM/TUBE X ".($ar_invoice_details_row->arid_qty/100)."</td>
                        <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".round(($offset_ink_gm_tube*($ar_invoice_details_row->arid_qty/100)/1000),2)." KGS</td>
                        <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($offset_ink_value_cost_per_kg,2)."</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($offset_ink_value_row,2)."</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($offset_ink_value_row/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2)."</td>
                        <td width='10%' style='text-align:right'></td>
                    </tr>";

                        }

                    

                }

                $total_ink_cost+=$offset_ink_value_row;

            }
        }


        if(strcmp($print_type_artwork, 'FLEXO') == 0 || strcmp($print_type_artwork, 'SCREEN+FLEXO') == 0 || strcmp($print_type_artwork, 'FLEXO+SCREEN') == 0){

            if($ar_invoice_master_row->invoice_date<'2020-10-01'){

            $flexo_ink_value_row=0;
            $query=$this->db->query("SELECT * from ink_consumption_master where lacquer_type_id='8' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
            $result_flexo_ink_value=$query->result();
            if($result_flexo_ink_value==TRUE){
            foreach($result_flexo_ink_value as $result_flexo_ink_value_row){
                $flexo_ink_value_row=$result_flexo_ink_value_row->cost_per_tube*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

                echo "<tr class='item'><td class='label' width='10%' >INK</td>
                        <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                        <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$result_flexo_ink_value_row->rm."</td>
                        <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'></td>
                        <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'></td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($flexo_ink_value_row,2)."</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($result_flexo_ink_value_row->cost_per_tube,2)."</td>
                        <td width='10%' style='text-align:right'></td>
                    </tr>";

                    $total_ink_cost+=$flexo_ink_value_row;
                }
            }else{
                echo "<tr><td colspan='8'>FLEXO INK COSTSHEET MASTER IS NOT ENTERED</td></tr>";
                }
            }else{

                $flexo_ink_value_row=0;
                $flexo_ink_value_cost_per_kg=0;
                $flexo_ink_value_gm_tube=0;
                $query=$this->db->query("SELECT * from ink_price_master where ink_id='1' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
                $result_flexo_ink_value=$query->result();
                foreach($result_flexo_ink_value as $result_flexo_ink_value_row){
                    $flexo_ink_value_cost_per_kg=$result_flexo_ink_value_row->cost_per_kg;

                    $query=$this->db->query("SELECT * from coex_ink_consumption_master where article_no='".$this->uri->segment(5)."' and artwork_no='$ad_id' and artwork_version_no='$version_no' and archive<>1 limit 0,1");

                    $result_flexo_ink_gm_tube_result=$query->result();
                    $flexo_ink_gm_tube=0;
                    if($result_flexo_ink_gm_tube_result==FALSE){

                        echo "<tr><td colspan='8'><i style='color:red'>FLEXO INK GM/TUBE FOR PRODUCT IS NOT ENTERED</i></td></tr>";

                    }else{
                            foreach($result_flexo_ink_gm_tube_result as $result_flexo_ink_gm_tube_row){
                                $flexo_ink_value_row=(($result_flexo_ink_gm_tube_row->flexo_ink_gm_tube*($ar_invoice_details_row->arid_qty/100))/1000)*$flexo_ink_value_cost_per_kg;
                                $flexo_ink_gm_tube=$result_flexo_ink_gm_tube_row->flexo_ink_gm_tube;
                            }
                echo "<tr class='item'><td class='label' width='10%' >FLEXO INK</td>
                        <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                        <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$result_flexo_ink_value_row->rm."<br/>".$flexo_ink_gm_tube." GM/TUBE X ".($ar_invoice_details_row->arid_qty/100)."</td>
                        <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".($flexo_ink_gm_tube*($ar_invoice_details_row->arid_qty/100)/1000)." KGS</td>
                        <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($flexo_ink_value_cost_per_kg,2)."/ KGS</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($flexo_ink_value_row,2)."</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($flexo_ink_value_row/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2)."</td>
                        <td width='10%' style='text-align:right'></td>
                    </tr>";

                    }

                }

                $total_ink_cost+=$flexo_ink_value_row;

            }
        }

        if(strcmp($print_type_artwork, 'DIGITAL+FLEXO') == 0 || strcmp($print_type_artwork, 'FLEXO+DIGITAL') == 0 || strcmp($print_type_artwork, 'FLEXO+DIGITAL+FLEXO') == 0 ){

            if($ar_invoice_master_row->invoice_date<'2020-11-01'){

            $digital_ink_value_row=0;
            $query=$this->db->query("SELECT * from ink_consumption_master where lacquer_type_id='12' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
            $result_digital_ink_value=$query->result();
            if($result_digital_ink_value==TRUE){
            foreach($result_digital_ink_value as $result_digital_ink_value_row){
                $digital_ink_value_row=$result_digital_ink_value_row->cost_per_tube*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

                echo "<tr class='item'><td class='label' width='10%' >INK</td>
                        <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                        <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$result_digital_ink_value_row->rm."</td>
                        <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'></td>
                        <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'></td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($digital_ink_value_row,2)."</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($result_digital_ink_value_row->cost_per_tube,2)."</td>
                        <td width='10%' style='text-align:right'></td>
                    </tr>";

                    $total_ink_cost+=$digital_ink_value_row;
                }
            }else{
                echo "<tr><td colspan='8'>DIGITAL INK COSTSHEET MASTER IS NOT ENTERED</td></tr>";
            }
        }

        else{

        
        $digital_ink_euro_price=0;
        $query=$this->db->query("SELECT * from digital_ink_price_master where ink_id='5' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");

                                //echo $this->db->last_query();
                                $total_digi_ink=0;
                                $digital_ink_euro_pricee=0;
                                $result_digital_ink_pc=0;
                                $result_digital_ink_rate=0;
                                $result_digital_ink_pc_value=$query->result();
                                if($result_digital_ink_pc_value==TRUE){

                                        foreach($result_digital_ink_pc_value as $result_digital_ink_pc_value_row){
                                            $result_digital_ink_pc=$result_digital_ink_pc_value_row->other_charges_pc;
                                            $result_digital_ink_rate=$result_digital_ink_pc_value_row->rate_of_exchange;
                                            $rm=$result_digital_ink_pc_value_row->rm;
                                        }

                                    if($result_digital_ink_pc<>0){
                                        $query_digi=$this->db->query("SELECT * FROM `springtube_printing_jobsetup_master` WHERE `order_no`='".$this->uri->segment(4)."' AND article_no='".$this->uri->segment(5)."'");

                                        $digital_ink_value=0;
                                        $digital_ink_valuee=0;
                                        $digital_ink_valueee=0;
                                        $result_digital_ink_value=$query_digi->result();
                                        foreach($result_digital_ink_value as $result_digital_ink_value_row){
                                            $digital_ink_euro_price=$result_digital_ink_value_row->digital_cost_in_euro;
                                            $digital_ink_valuee=((($result_digital_ink_value_row->digital_cost_in_euro/2000)*$result_digital_ink_rate)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']));
                                            $digital_ink_valueee=($digital_ink_valuee/100)*$result_digital_ink_pc;
                                            $digital_ink_value=$digital_ink_valuee+$digital_ink_valueee;
                                            $total_digi_ink+=$digital_ink_value;
                                            $digital_ink_euro_pricee+=$digital_ink_euro_price;
                                            
                                            }

                                        echo "<tr class='item'><td class='label' width='10%' >DIGITAL INK</td>
                                                <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                                                <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$rm."</td>
                                                <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'></td>
                                                <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&euro; ".$digital_ink_euro_pricee."/2000 Tubes</td>
                                                <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($total_digi_ink,2)."</td>
                                                <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($total_digi_ink/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2)."</td>
                                                <td width='10%' style='text-align:right'></td>
                                            </tr>";

                                            $total_ink_cost+=$total_digi_ink;

                                    }

                                }else{

                                    echo "<tr><td colspan='8'><i style='color:red'>DIGITAL INK IS NOT ENTERED</i></td></tr>";

                                }
                                

    }
    }


        $total_total_printing_cost=0;
        $total_total_printing_cost=$total_ink_cost+$total_printing_cost;
        echo "<tr class='heading'>
                <td><b>TOTAL</td>
                <td></td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'><b>&#8377; ".round($total_total_printing_cost,2)."</b></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($total_total_printing_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2)."</td>
                <td></td>
            </tr>";
        ?>

        </table>
        <table cellpadding='5' cellspacing='0' style='border:1px solid #D9d9d9;'>
            <tr class="heading">
                <td colspan="8" style='border-bottom:1px solid #D9d9d9;'><b>CONSUMABLES</td>
            </tr>
            <tr class="heading item">
                <td width="10%" ><b>GROUP</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b>MATERIAL</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b>QUANTITY</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>PRICE</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>TOTAL COST</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>COST/TUBE</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>PROCESSWISE COST/TUBE</td>
            </tr>
            <?php
            $total_consumable=0;
            if(strcmp($print_type_artwork, 'SCREEN') == 0 || strcmp($print_type_artwork, 'SCREEN+UPTO NECK') == 0 || strcmp($print_type_artwork, 'SCREEN + LABEL') == 0 || strcmp($print_type_artwork, 'SCREEN+FLEXO') == 0 || strcmp($print_type_artwork, 'FLEXO+SCREEN') == 0 || strcmp($print_type_artwork, 'Screen') == 0){
            $other_screen_consumable=0;
            $query=$this->db->query("SELECT * from other_consumable_consumption_master where consumable_category_id='5' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
            $result_other_screen_consumable_value=$query->result();
            if($result_other_screen_consumable_value==TRUE){
            foreach($result_other_screen_consumable_value as $result_other_screen_consumable_value_row){
                $other_screen_consumable=$result_other_screen_consumable_value_row->cost_per_tube*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

                echo "<tr class='item'><td class='label' width='10%' >SCREEN</td>
                        <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                        <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$result_other_screen_consumable_value_row->consumable." &#8377; ".$result_other_screen_consumable_value_row->cost_per_tube." / NOS</td>
                        <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])." NOS</td>
                        <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".$result_other_screen_consumable_value_row->cost_per_tube." / NOS</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($other_screen_consumable,2)."</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($result_other_screen_consumable_value_row->cost_per_tube,2)."</td>
                        <td width='10%' style='text-align:right'></td>
                    </tr>";
                    $total_consumable+=$other_screen_consumable;
                }
                }else{
                    echo "<tr><td colspan='8'>OTHER SCREEN CONSUMABLE MASTER IS NOT ENTERED</td></tr>";
                }
            }

            ?>


            <?php
            if(strcmp($print_type_artwork, 'OFFSET') == 0 || strcmp($print_type_artwork, 'OFFSET SCREEN') == 0 || strcmp($print_type_artwork, 'PLAIN') == 0 || strcmp($print_type_artwork, 'LABEL OFFSET') == 0){
            $other_offset_consumable=0;
            $query=$this->db->query("SELECT * from other_consumable_consumption_master where consumable_category_id='4' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
            $result_other_offset_consumable_value=$query->result();
            if($result_other_offset_consumable_value==TRUE){
            foreach($result_other_offset_consumable_value as $result_other_offset_consumable_value_row){
                $other_offset_consumable=$result_other_offset_consumable_value_row->cost_per_tube*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

                echo "<tr class='item'><td class='label' width='10%' >OFFSET</td>
                        <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                        <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$result_other_offset_consumable_value_row->consumable." &#8377; ".$result_other_offset_consumable_value_row->cost_per_tube."</td>
                        <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])." NOS</td>
                        <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".$result_other_offset_consumable_value_row->cost_per_tube." / NOS</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($other_offset_consumable,2)."</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($result_other_offset_consumable_value_row->cost_per_tube,2)."</td>
                        <td width='10%' style='text-align:right'></td>
                    </tr>";
                    $total_consumable+=$other_offset_consumable;
                }
                }else{
                    echo "<tr><td colspan='8'>OTHER OFFSET CONSUMABLE MASTER IS NOT ENTERED</td></tr>";
                }
            }?>

            <?php
            if(strcmp($print_type_artwork, 'FLEXO') == 0 || strcmp($print_type_artwork, 'SCREEN+FLEXO') == 0 || strcmp($print_type_artwork, 'FLEXO+SCREEN') == 0){
            $other_flexo_consumable=0;
            $query=$this->db->query("SELECT * from other_consumable_consumption_master where consumable_category_id='3' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
            $result_other_flexo_consumable_value=$query->result();
            if($result_other_flexo_consumable_value==TRUE){
            foreach($result_other_flexo_consumable_value as $result_other_flexo_consumable_value_row){
                $other_flexo_consumable=$result_other_flexo_consumable_value_row->cost_per_tube*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

                echo "<tr class='item'><td class='label' width='10%' >FLEXO</td>
                        <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                        <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$result_other_flexo_consumable_value_row->consumable." &#8377; ".$result_other_flexo_consumable_value_row->cost_per_tube."</td>
                        <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])." NOS</td>
                        <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".$result_other_flexo_consumable_value_row->cost_per_tube."</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($other_flexo_consumable,2)."</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($result_other_flexo_consumable_value_row->cost_per_tube,2)."</td>
                        <td width='10%' style='text-align:right'></td>
                    </tr>";
                    $total_consumable+=$other_flexo_consumable;
                }
                }else{
                    echo "<tr><td colspan='8'>OTHER FLEXO CONSUMABLE MASTER IS NOT ENTERED</td></tr>";
                }
            }?>


            <?php
            if($order_flag==1){
                $decoseam_consumable=0;
                $query=$this->db->query("SELECT * from other_consumable_consumption_master where consumable_category_id='6' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
                $result_decoseam_consumable_value=$query->result();
            if($result_decoseam_consumable_value==TRUE){
            foreach($result_decoseam_consumable_value as $result_decoseam_consumable_value_row){
                $decoseam_consumable=$result_decoseam_consumable_value_row->cost_per_tube*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

                echo "<tr class='item'><td class='label' width='10%' >DECOSEAM</td>
                        <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                        <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$result_decoseam_consumable_value_row->consumable."</td>
                        <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'></td>
                        <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'></td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($decoseam_consumable,2)."</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($result_decoseam_consumable_value_row->cost_per_tube,2)."</td>
                        <td width='10%' style='text-align:right'></td>
                    </tr>";
                    $total_consumable+=$decoseam_consumable;
                }
                }else{
                    echo "<tr><td colspan='8'>OTHER DECOSEAM CONSUMABLE MASTER IS NOT ENTERED</td></tr>";
                }
            }
            ?>


            <?php
            
            $hygenic_consumable=0;
            $query=$this->db->query("SELECT * from other_consumable_consumption_master where consumable_category_id='2' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
            $result_hygenic_consumable_value=$query->result();
            if($result_hygenic_consumable_value==TRUE){
            foreach($result_hygenic_consumable_value as $result_hygenic_consumable_value_row){
                $hygenic_consumable=$result_hygenic_consumable_value_row->cost_per_tube*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

                echo "<tr class='item'><td class='label' width='10%' >HYGENIC</td>
                        <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                        <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$result_hygenic_consumable_value_row->consumable."</td>
                        <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'></td>
                        <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'></td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($hygenic_consumable,2)."</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($result_hygenic_consumable_value_row->cost_per_tube,2)."</td>
                        <td width='10%' style='text-align:right'></td>
                    </tr>";
                    $total_consumable+=$hygenic_consumable;
                }
                }else{
                    echo "<tr><td colspan='8'>OTHER HYGENIC CONSUMABLE MASTER IS NOT ENTERED</td></tr>";
                }
            ?>

            <?php
            
                $other_consumable=0;
                $query=$this->db->query("SELECT * from other_consumable_consumption_master where consumable_category_id='1' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
                $result_other_consumable_value=$query->result();
                if($result_other_consumable_value==TRUE){
                foreach($result_other_consumable_value as $result_other_consumable_value_row){
                    $other_consumable=$result_other_consumable_value_row->cost_per_tube*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

                echo "<tr class='item'><td class='label' width='10%' >OTHER</td>
                        <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                        <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$result_other_consumable_value_row->consumable."</td>
                        <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'></td>
                        <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'></td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($other_consumable,2)."</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($result_other_consumable_value_row->cost_per_tube,2)."</td>
                        <td width='10%' style='text-align:right'></td>
                    </tr>";
                    $total_consumable+=$other_consumable;
                    }
                }else{
                    echo "<tr><td colspan='8'>OTHER  CONSUMABLE MASTER IS NOT ENTERED</td></tr>";
                }

       /* echo "<tr class='heading'>
                <td><b>TOTAL</td>
                <td></td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'><b>".round($total_consumable,2)."</b></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'>".round($total_consumable/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2)."</td>
                <td></td>
                </tr>";*/



            $data['daily_plate_master']=$this->common_model->select_one_active_record('graphics_daily_plates_master',$this->session->userdata['logged_in']['company_id'],'order_no',$ar_invoice_details_row->ref_ord_no);

            $total_offset_plates=0;
                $total_screen_positive=0;
                $total_flexo_plates=0;
                $offset_plates=0;
                $screen_positive=0;
                $flexo_plates=0;

            if($data['daily_plate_master']==TRUE){
                
                foreach($data['daily_plate_master'] as $row_plate_record){

                    $data_plates=array('dpr_id'=>$row_plate_record->dpr_id);
                    //$this->load->model('daily_plates_record_model');
                    $result_plates=$this->daily_plates_record_model->select_no_plates('graphics_daily_plates_details',$data_plates);
                    //echo $this->db->last_query();
                    foreach ($result_plates as $row_plates) {
                        $offset_plates=$row_plates->offset;
                        $screen_positive=$row_plates->screen;
                        $flexo_plates=$row_plates->flexo;
                    }
                    $total_offset_plates+=($offset_plates/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
                    $total_screen_positive+=($screen_positive/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
                    $total_flexo_plates+=($flexo_plates/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
                }
            }else{
                /*
                $total_offset_plates=0;
                $total_screen_positive=0;
                $total_flexo_plates=0;
                $offset_plates=0;
                $screen_positive=0;
                $flexo_plates=0;
                */

            }

            //$total_flexo_plates;

                $total_screens=0;
                $screens=0;
                $data['daily_screen_master']=$this->common_model->select_one_active_record('graphics_daily_screen_master',$this->session->userdata['logged_in']['company_id'],'order_no',$ar_invoice_details_row->ref_ord_no);
                if($data['daily_screen_master']==TRUE){

                    foreach($data['daily_screen_master'] as $row_screen_record){
                        $data_screens=array('dsr_id'=>$row_screen_record->dsr_id);
                        $result_screens=$this->daily_screen_record_model->select_no_screen('graphics_daily_screen_details',$data_screens);
                        foreach ($result_screens as $row_screens) {
                            $screens=$row_screens->screen;
                        }
                    $total_screens+=($screens/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
                    }

                }
                $total_screen_plate_rate=0;
                $total_screen_and_plate_cost=0;
                $total_screen_and_plate_cost_per_tube=0;
                $screen_value=0;
                //$total_screens=0;
                ($print_type_artwork=='' ? $print_type_bom : $print_type_artwork);

                if(strpos($print_type_artwork, 'SCREEN+FLEXO') !== false || strpos($print_type_artwork, 'FLEXO+SCREEN') !== false || strpos($print_type_artwork, 'SCREEN') !== false || strpos($print_type_artwork, 'SCREEN + LABEL') !== false  || strpos($print_type_artwork, 'SCREEN+UPTO NECK') !== false || strpos($print_type_artwork, 'OFFSET SCREEN') !== false || strpos($print_type_artwork, 'Screen') !== false){

                $query=$this->db->query("SELECT * from screen_consumption_master where lacquer_type_id='3' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
                $result_screen_value=$query->result();
                $screen_rate=0;
                        if($result_screen_value==TRUE){

                            foreach($result_screen_value as $result_screen_value_row){
                                $screen_rate=$result_screen_value_row->consumption_unit_rate;
                            }
                            $screen_value=$total_screens*$screen_rate;
                            $screen_cost_per_tube=$screen_value/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
                            //$invoice_wise_screen_value=$screen_cost_per_tube*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
                            //echo round($invoice_wise_screen_value,2);
                            //$total_screens+=$invoice_wise_screen_value;
                            $total_screen_and_plate_cost+=$screen_value;
                            $total_screen_and_plate_cost_per_tube+=$screen_cost_per_tube;

                        }else{
                        //echo "Please Set the  Screen Price in Master";
                        }

                        echo "<tr class='item'><td class='label' width='10%' >SCREENS</td>
                        <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                        <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'></td>
                        <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".round($total_screens,2)."</td>
                        <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($screen_rate,2)."/SCREEN</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($screen_value,2)."</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($screen_cost_per_tube,2)."</td>
                        <td width='10%' style='text-align:right'></td>
                    </tr>";

                    }

                    $offset_plates_value=0;
                    ($print_type_artwork=='' ? $print_type_bom:$print_type_artwork);
                    //$total_offset_plates=0;
                    if(strpos($print_type_artwork, 'OFFSET') !== false || strpos($print_type_artwork, 'OFFSET SCREEN') !== false){

                        $query=$this->db->query("SELECT * from screen_consumption_master where lacquer_type_id='2' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
                            $result_offset_value=$query->result();
                            $offset_plate_rate=0;
                            if($result_offset_value==TRUE){
                                foreach($result_offset_value as $result_offset_value_row){
                                    $offset_plate_rate=$result_offset_value_row->consumption_unit_rate;
                                }
                                $total_screen_plate_rate=$offset_plate_rate;
                                $offset_plates_value=$total_offset_plates*$offset_plate_rate;
                                $offset_plates_cost_per_tube=$offset_plates_value/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
                                //$invoice_wise_offset_plates_value=$offset_plates_cost_per_tube*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
                                //echo round($invoice_wise_offset_plates_value,2);
                                //$total_offset_plates+=$invoice_wise_offset_plates_value;
                                $total_screen_and_plate_cost+=$offset_plates_value;
                                $total_screen_and_plate_cost_per_tube+=$offset_plates_cost_per_tube;
                            }else{
                            //echo "Please set the Offset Plate Price in Master";  
                            }

                            echo "<tr class='item'><td class='label' width='10%' >OFFSET PLATE</td>
                        <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                        <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'></td>
                        <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".round($total_offset_plates,2)."</td>
                        <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($offset_plate_rate)."/PLATE</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($offset_plates_value,2)."</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($offset_plates_cost_per_tube,2)."</td>
                        <td width='10%' style='text-align:right'></td>
                    </tr>";
                        }

                        if($order_flag<>1){

                            //echo $flexo_plates;

                        $flexo_plates_value=0;
                        $invoice_wise_flexo_plates_value=0;
                        ($print_type_artwork==''?$print_type_bom:$print_type_artwork);
                        //$total_flexo_plates=0;
                            // if(strpos($print_type_artwork, 'FLEXO') !== false || strpos($print_type_artwork, 'SCREEN+FLEXO') !== false || strpos($print_type_artwork, 'FLEXO+SCREEN') !== false){

                            if(strpos($print_type_artwork, 'FLEXO') !== false || strpos($print_type_artwork, 'SCREEN+FLEXO') !== false || strpos($print_type_artwork, 'FLEXO+SCREEN') !== false || strpos($print_type_artwork, 'FLEXO+DIGITAL')!== false || strpos($print_type_artwork, 'FLEXO+DIGITAL+FLEXO')!== false || strpos($print_type_artwork, 'DIGITAL+FLEXO')!== false || strpos($print_type_artwork, 'SCREEN') !== false){

                                $query=$this->db->query("SELECT * from screen_consumption_master where lacquer_type_id='8' OR lacquer_type_id='6' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");

                                $result_flexo_value=$query->result();
                                $flexo_plate_rate=0;
                                if($result_flexo_value==TRUE){
                                    foreach($result_flexo_value as $result_flexo_value_row){

                                        $flexo_plate_rate=$result_flexo_value_row->consumption_unit_rate;
                                    }
                                    $total_screen_plate_rate=$flexo_plate_rate;
                                    $flexo_plates_value=$total_flexo_plates*$flexo_plate_rate;
                                    $flexo_plates_cost_per_tube=$flexo_plates_value/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
                                   // $invoice_wise_flexo_plates_value=$flexo_plates_cost_per_tube*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
                                    //echo round($invoice_wise_flexo_plates_value,2);
                                    //$total_flexo_plates+=$invoice_wise_flexo_plates_value;
                                    $one_screen_and_plate_cost=$flexo_plate_rate;
                                    $total_screen_and_plate_cost+=$flexo_plates_value;
                                    $total_screen_and_plate_cost_per_tube+=$flexo_plates_cost_per_tube;
                                }else{
                                //echo "Please set the Flexo Plate Price in Master'";
                                }


                                echo "<tr class='item'><td class='label' width='10%' >FLEXO PLATE</td>
                                        <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                                        <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'></td>
                                        <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".round($total_flexo_plates,2)."</td>
                                        <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($flexo_plate_rate)."/PLATE</td>
                                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($flexo_plates_value,2)."</td>
                                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($flexo_plates_cost_per_tube,2)."</td>
                                        <td width='10%' style='text-align:right'></td>
                                    </tr>";

                            }
                        }
                        $total_screen_plate_quantity=0;
                        $total_screen_plate_quantity=$total_screens+$total_offset_plates+$total_flexo_plates;


                        if($order_flag==1){

                            //echo $order_flag;
                            $flexo_plates=0;
                            $total_flexo_plate_quantity=0;

                            $data_springtube_plates=array('order_no'=>$ar_invoice_details_row->ref_ord_no,'article_no'=>$ar_invoice_details_row->article_no,'archive'=>0);
                            $springtube_daily_plates_master_result=$this->common_model->select_active_records_where('springtube_daily_plates_master',$this->session->userdata['logged_in']['company_id'],$data_springtube_plates);
                            foreach ($springtube_daily_plates_master_result as $key => $springtube_daily_plates_master_row) {

                                $flexo_plates+=$springtube_daily_plates_master_row->total_plates;                                
                            }

                            $total_flexo_plate_quantity=($flexo_plates)*($this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch);

                            if($total_flexo_plate_quantity!=0){

                                $query=$this->db->query("SELECT * from screen_consumption_master where lacquer_type_id='8' OR lacquer_type_id='6' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");

                                $result_flexo_value=$query->result();
                                if($result_flexo_value==TRUE){
                                    foreach($result_flexo_value as $result_flexo_value_row){
                                       $flexo_plate_rate=$result_flexo_value_row->consumption_unit_rate;
                                    }

                                    $flexo_plates_value=$total_flexo_plate_quantity*$flexo_plate_rate;
                                    $flexo_plates_cost_per_tube=$flexo_plates_value/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
                                    
                                    $total_screen_and_plate_cost=$flexo_plates_value;
                                    $total_screen_and_plate_cost_per_tube=$flexo_plates_cost_per_tube;
                                    
                                }else{
                                //echo "Please set the Flexo Plate Price in Master'";
                                }



                                echo "<tr class='item'><td class='label' width='10%' >FLEXO PLATE</td>
                                        <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                                        <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'></td>
                                        <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".round($total_flexo_plate_quantity,2)."</td>
                                        <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($flexo_plate_rate)."/PLATE</td>
                                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($total_screen_and_plate_cost,2)."</td>
                                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($total_screen_and_plate_cost_per_tube,2)."</td>
                                        <td width='10%' style='text-align:right'></td>
                                    </tr>";


                            }

                            $total_screen_plate_quantity+=$total_flexo_plate_quantity;
                        }

                        echo "<tr class='heading'><td class='label' width='10%' colspan='3'>TOTAL SCREENS & PLATES</td>
                        <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".round($total_screen_plate_quantity,2)."</td>
                        <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'></td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($total_screen_and_plate_cost,2)."</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($total_screen_and_plate_cost_per_tube,2)."</td>
                        <td width='10%' style='text-align:right'></td>
                    </tr>";

                    $data['lacquer_types_master']=$this->costsheet_model->select_one_active_record('lacquer_types_master',$this->session->userdata['logged_in']['company_id'],'lacquer_type',$print_type_bom);

                    
                    if($data['lacquer_types_master']==TRUE){
                    $m=0;
                    foreach($data['lacquer_types_master'] as $lacquer_types_row){
                        $lacquer_type_id=$lacquer_types_row->lacquer_type_id;
                        $lacquer_array[$m] = $lacquer_type_id;
                        $m++;

                    }
                }else{
                     $lacquer_type_id="";
                }

                    $query=$this->db->query("SELECT * from uv_consumption_master where lacquer_type_id='$lacquer_type_id' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
                    $result_uv_lamp=$query->result();
                    $uv_lamp_cost=0;
                    if($result_uv_lamp==TRUE){
                    foreach($result_uv_lamp as $result_uv_lamp_row){
                        $uv_lamp_cost=$result_uv_lamp_row->cost_per_tube*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

                        echo "<tr class='item'><td class='label' width='10%' >UV</td>
                                <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                                <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$result_uv_lamp_row->rm."</td>
                                <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'></td>
                                <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'></td>
                                <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($uv_lamp_cost,2)."</td>
                                <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($result_uv_lamp_row->cost_per_tube,2)."</td>
                                <td width='10%' style='text-align:right'></td>
                            </tr>";
                            $total_consumable+=$uv_lamp_cost;
                        }
                        }else{
                            echo "<tr><td colspan='8'>UV MASTER IS NOT ENTERED</td></tr>";
                    }


                    $total_consumable+=$total_screen_and_plate_cost;
                echo "<tr class='heading'>
                <td><b>TOTAL</td>
                <td></td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'><b>&#8377; ".round($total_consumable,2)."</b></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($total_consumable/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2)."</td>
                <td></td>
                </tr>";
            ?>


        </table>


        <br/>




        <table cellpadding='5' cellspacing='0' style='border:1px solid #D9d9d9;'>
            <tr class="heading">
                <td colspan="8" style='border-bottom:1px solid #D9d9d9;'><b>LABELING PROCESS</td>
            </tr>
            <tr class="heading item">
                <td width="10%" ><b>GROUP</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b>MATERIAL</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b>QUANTITY</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>PRICE</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>TOTAL COST</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>COST/TUBE</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>PROCESSWISE COST/TUBE</td>
            </tr>
        <?php
        $total_labeling_cost=0;
        $labeling_cost=0;
        $total_labeling_quantity=0;
        $labeling_quantity=0;
        $master_array= array('article_no' =>$this->uri->segment(5),'sales_ord_no '=>$this->uri->segment(4));
        $data1=array_filter($master_array);
        $data2['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from="",$to="",$this->session->userdata['logged_in']['company_id']);
        if($data2['job_card']==TRUE){

        foreach($data2['job_card'] as $job_card_row){
            $job_card_no=$job_card_row->mp_pos_no;
        } 
    }else{

        $job_card_no="";
    }

        $query=$this->db->query("SELECT * from reserved_quantity_manu where manu_order_no='$job_card_no' and article_no like 'LBL%' ");
                $result_label_value=$query->result();
                //echo $this->db->last_query();
                foreach($result_label_value as $result_label_value_row){

                $article_desc="";
                $calculated_purchase_price="";
                $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$result_label_value_row->article_no);
                foreach($data['article'] as $article_row){
                 $article_desc=$article_row->article_name;
                 $sub_group=$article_row->sub_group;
                 $main_group=$article_row->main_group;
                 $uom=$article_row->uom;
                }

                    $labeling_cost=($this->common_model->read_number($result_label_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($result_label_value_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);


                  $labeling_quantity=($this->common_model->read_number($result_label_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);


                  echo "<tr class='item'><td class='label' width='10%' >".$main_group."</td>
                    <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                    <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$article_desc."</td>
                    <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".round($labeling_quantity,2)." ".$uom."</td>
                    <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".$this->common_model->read_number($result_label_value_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id'])." / ".$uom."</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($labeling_cost,2)."</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($labeling_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2)."</td>
                    <td width='10%' style='text-align:right'></td>
                </tr>";

                $total_labeling_cost+=$labeling_cost;
                $total_labeling_quantity+=$labeling_quantity;
                

                }
    
            echo "<tr class='heading'>
                <td><b>TOTAL</td>
                <td></td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'>".round($total_labeling_quantity,2)."</td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'><b>&#8377; ".round($total_labeling_cost,2)."</b></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($total_labeling_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2)."</td>
                <td></td>
            </tr>";


        ?>
        </table>

        <br/>

        <table cellpadding='5' cellspacing='0' style='border:1px solid #D9d9d9;'>
            <tr class="heading">
                <td colspan="8" style='border-bottom:1px solid #D9d9d9;'><b>FOILING PROCESS</td>
            </tr>
            <tr class="heading">
                <td colspan="8" style='border-bottom:1px solid #D9d9d9;'><b>TUBE FOIL MATERIAL</td>
            </tr>
            <tr class="heading item">
                <td width="10%" ><b>GROUP</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b>MATERIAL</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b>QUANTITY</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>PRICE</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>TOTAL COST</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>COST/TUBE</td>
                <td width="10%" style='text-align:right'>PROCESSWISE COST/TUBE</td>
            </tr>
        <?php
        $total_foiling_cost=0;
        $foiling_cost=0;
        $total_foiling_quantity=0;
        $foiling_quantity=0;
        $master_array= array('article_no' =>$this->uri->segment(5),'sales_ord_no'=>$this->uri->segment(4));
        $data1=array_filter($master_array);
        $data2['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from="",$to="",$this->session->userdata['logged_in']['company_id']);
        foreach($data2['job_card'] as $job_card_row){
            $data=array('manu_order_no'=>$job_card_row->mp_pos_no,'completed_flag'=>'1','work_proc_no'=>'6');
            $data['job_card_issued']=$this->common_model->select_one_active_record_nonlanguage_without_archives_order_by('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$data,'','work_proc_no');
            if($data['job_card_issued']==TRUE){
            $i=1;
            foreach ($data['job_card_issued'] as $job_card_row):
                $article_desc="";
                $calculated_purchase_price="";
                $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$job_card_row->article_no);
                foreach($data['article'] as $article_row){
                 $article_desc=$article_row->article_name;
                 $sub_group=$article_row->sub_group;
                 $main_group=$article_row->main_group;
                 $uom=$article_row->uom;
                }

            $data['workprocedure_types_master']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id',$job_card_row->work_proc_no);
                foreach($data['workprocedure_types_master'] as $row_workprocedure_types_master){
                    $process=$row_workprocedure_types_master->lang_description;
                }
            $foiling_cost=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

            $foiling_quantity=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

           echo "<tr class='item'><td class='label' width='10%' >".$sub_group."</td>
                    <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                    <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$article_desc."</td>
                    <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".round($foiling_quantity,2)." ".$uom."</td>
                    <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id'])." /  ".$uom."</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($foiling_cost,2)."</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($foiling_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2)."</td>
                    <td width='10%' style='text-align:right'></td>
                </tr>";
                $total_foiling_cost+=$foiling_cost;
                $total_foiling_quantity+=$foiling_quantity;
                $i++;
            endforeach;
            }else{
                echo "<tr>
                        <td colspan='6'>NO FOILING FOR THIS JOB</td></tr>";
            }
        }
        echo "<tr class='heading'>
                <td><b>TOTAL</td>
                <td></td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'>".round($total_foiling_quantity,2)."</td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'><b>&#8377; ".round($total_foiling_cost,2)."</b></td>
                <td style='text-align:right'>&#8377; ".round($total_foiling_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2)."</td>
                <td></td>
            </tr>";

        ?>
        </table>
        <table cellpadding='5' cellspacing='0' style='border:1px solid #D9d9d9;'>
            <tr class="heading">
                <td colspan="8" style='border-bottom:1px solid #D9d9d9;'><b>SHOULDER FOIL MATERIAL</td>
            </tr>
            <tr class="heading item">
                <td width="10%" ><b>GROUP</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b>MATERIAL</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b>QUANTITY</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>PRICE</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>TOTAL COST</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>COST/TUBE</td>
                <td width="10%" style='text-align:right'>PROCESSWISE COST/TUBE</td>
            </tr>
        <?php
            $total_shoulderfoil_cost=0;
            $total_shoulderfoil_quantity=0;
            $shouldefoil_quantity=0;
            $shouldefoil_cost=0;
            $master_array= array('article_no' =>$this->uri->segment(5),'sales_ord_no'=>$this->uri->segment(4));
            $data1=array_filter($master_array);
            $data2['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from="",$to="",$this->session->userdata['logged_in']['company_id']);
            foreach($data2['job_card'] as $job_card_row){
                $data=array('manu_order_no'=>$job_card_row->mp_pos_no,'completed_flag'=>'1','work_proc_no'=>'7');
            $data['job_card_issued']=$this->common_model->select_one_active_record_nonlanguage_without_archives_order_by('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$data,'','work_proc_no');

            if($data['job_card_issued']==TRUE){
                $i=1;
            foreach ($data['job_card_issued'] as $job_card_row):
                $article_desc="";
                $calculated_purchase_price="";
                $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$job_card_row->article_no);
                foreach($data['article'] as $article_row){
                 $article_desc=$article_row->article_name;
                 $sub_group=$article_row->sub_group;
                 $main_group=$article_row->main_group;
                 $uom=$article_row->uom;
                }

                $data['workprocedure_types_master']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id',$job_card_row->work_proc_no);
                foreach($data['workprocedure_types_master'] as $row_workprocedure_types_master){
                    $process=$row_workprocedure_types_master->lang_description;
                }

                $shouldefoil_cost=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

                $shouldefoil_quantity=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

            echo "<tr class='item'><td class='label' width='10%' >".$sub_group."</td>
                    <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                    <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$article_desc."</td>
                    <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".round($shouldefoil_quantity,2)." ".$uom."</td>
                    <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id'])." / ".$uom."</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($shouldefoil_cost,2)."</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($shouldefoil_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2)."</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;'></td>
                </tr>";
                $total_shoulderfoil_cost+=$shouldefoil_cost;
                $total_shoulderfoil_quantity+=$shouldefoil_quantity;
                $i++;
            endforeach;
            }else{
                echo "<tr>
                        <td colspan='6'>NO SHOULDER FOILING FOR THIS JOB</td></tr>";
            }
        }
        echo "<tr class='heading'>
                <td><b>TOTAL</td>
                <td></td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'>".round($total_shoulderfoil_quantity,2)."</td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'><b>&#8377; ".round($total_shoulderfoil_cost,2)."</b></td>
                <td style='text-align:right'>&#8377; ".round($total_shoulderfoil_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2)."</td>
                <td></td>
            </tr>";
        ?>
        </table>

        <br/>


        <table cellpadding='5' cellspacing='0' style='border:1px solid #D9d9d9;'>
            <tr class="heading">
                <td colspan="8" style='border-bottom:1px solid #D9d9d9;'><b>CAPPING MATERIAL 
                    <?php 
                        if($order_flag==1){

                       foreach ($result_production_master as $key => $production_master_row) {

                            if($production_master_row->jobcard_type=='3'){ 

                                echo'<a href="'.base_url('index.php/sales_order_item_parameterwise/view_new/').$production_master_row->mp_pos_no.'/'.$bom_no.'/'.$bom_version_no.'" target="_blank">'.$production_master_row->mp_pos_no.'</a>';

                                echo'&nbsp;: ';
                            }
                        }    
                    }
                    ?>
                </td>
            </tr>
            <tr class="heading item">
                <td width="10%" ><b>GROUP</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b>MATERIAL</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b>QUANTITY</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>PRICE</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>TOTAL COST</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>COST/TUBE</td>
                <td width="10%" style='text-align:right'>PROCESSWISE COST/TUBE</td>
            </tr>

            <?php
            $total_capping_s_cost=0;
            $capping_s_cost=0;
            $total_capping_s_quantity=0;
            $capping_s_quantity=0;
            if($order_flag==1){

            $master_array= array('article_no' =>$this->uri->segment(5),'sales_ord_no'=>$this->uri->segment(4),'jobcard_type'=>'3');
            $data1=array_filter($master_array);
            $data2['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from="",$to="",$this->session->userdata['logged_in']['company_id']);

            }else{

            $master_array= array('article_no' =>$this->uri->segment(5),'sales_ord_no'=>$this->uri->segment(4));
            $data1=array_filter($master_array);
            $data2['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from="",$to="",$this->session->userdata['logged_in']['company_id']);
            }
            foreach ($data2['job_card'] as $job_card_row){
                $job_card_no=$job_card_row->mp_pos_no;
           

            $query=$this->db->query("SELECT sum(total_qty) as total_qty,calculated_purchase_price,article_no from reserved_quantity_manu where manu_order_no='$job_card_no' and article_no like 'RM-CAS%'");

            // echo $this->db->last_query();

                $result_capping_s_value=$query->result();
                if($result_capping_s_value==TRUE){
                foreach($result_capping_s_value as $result_capping_value_row){
                     $cap_article=$this->common_model->get_article_name($result_capping_value_row->article_no,$this->session->userdata['logged_in']['company_id']);

                    $ar_capping_s_cost=($this->common_model->read_number($result_capping_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($result_capping_value_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

                    $ar_capping_s_quantity=($this->common_model->read_number($result_capping_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

                    $ar_cap_s_price=$this->common_model->read_number($result_capping_value_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);
                }
                    $capping_s_quantity=$ar_capping_s_quantity;
                    $capping_s_cost=$ar_capping_s_cost;
                    $cap_s_price=$ar_cap_s_price;
                
           

            echo "<tr class='item'><td class='label' width='10%' >SHRINK SLEEVE</td>
                    <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                    <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$cap_article."</td>
                    <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".round($capping_s_quantity)." NOS</td>
                    <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".$cap_s_price." / NOS</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($capping_s_cost,2)."</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($capping_s_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2)."</td>
                    <td width='10%' style='text-align:right'></td>
                </tr>";
                $total_capping_s_cost+=$capping_s_cost;
                $total_capping_s_quantity+=$capping_s_quantity;
                $i++;
            }
            else{
                echo "<tr>
                        <td colspan='6'>NO SHRINK SLEEVE FOR THIS JOB</td></tr>";
            }
        }?>

            <?php
            $total_capping_cost=0;
            $capping_cost=0;
            $total_capping_quantity=0;
            $capping_quantity=0;

            if($order_flag==1){

            $master_array= array('article_no' =>$this->uri->segment(5),'sales_ord_no'=>$this->uri->segment(4),'jobcard_type'=>'3');
            $data1=array_filter($master_array);
            $data2['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from="",$to="",$this->session->userdata['logged_in']['company_id']);

            }else{

            $master_array= array('article_no' =>$this->uri->segment(5),'sales_ord_no'=>$this->uri->segment(4));
            $data1=array_filter($master_array);
            $data2['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from="",$to="",$this->session->userdata['logged_in']['company_id']);
            }

            foreach ($data2['job_card'] as $job_card_row){
                $job_card_no=$job_card_row->mp_pos_no;

                    if($cap_metalization!=''){
                    $query=$this->db->query("SELECT sum(total_qty) as total_qty,calculated_purchase_price,article_no from reserved_quantity_manu where manu_order_no='$job_card_no' and article_no like '%CAME-%'");
                    }else{
                        $query=$this->db->query("SELECT sum(total_qty) as total_qty,calculated_purchase_price,article_no from reserved_quantity_manu where manu_order_no='$job_card_no' and article_no like '%CAPS-000%'");
                        //echo $this->db->last_query();
                    }

            

           // echo $this->db->last_query();

                $result_capping_value=$query->result();
                if($result_capping_value==TRUE){
                foreach($result_capping_value as $result_capping_value_row){
                     $cap_article=$this->common_model->get_article_name($result_capping_value_row->article_no,$this->session->userdata['logged_in']['company_id']);

                    $ar_capping_cost=($this->common_model->read_number($result_capping_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($result_capping_value_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

                   // echo $result_capping_value_row->total_qty;
                    //echo "<br/>";
                    //echo $total_dispatch;

                    $ar_capping_quantity=($this->common_model->read_number($result_capping_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

                    $ar_cap_price=$this->common_model->read_number($result_capping_value_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);
                }
                    $capping_quantity=$ar_capping_quantity;
                    $capping_cost=$ar_capping_cost;
                    $cap_price=$ar_cap_price;
                
           

            echo "<tr class='item'><td class='label' width='10%' >CAP</td>
                    <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                    <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$cap_article."</td>
                    <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".round($capping_quantity)." NOS</td>
                    <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".$cap_price." / NOS</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($capping_cost,2)."</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($capping_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2)."</td>
                    <td width='10%' style='text-align:right'></td>
                </tr>";
                $total_capping_cost+=$capping_cost;
                $total_capping_quantity+=$capping_quantity;
                $i++;
            }
            else{
                echo "<tr>
                        <td colspan='6'>NO CAPPING FOR THIS JOB</td></tr>";
            }
        }


       /* $total_capping_m_cost=0;
            $capping_m_cost=0;
            $total_capping_m_quantity=0;
            $capping_m_quantity=0;
            $master_array= array('article_no' =>$this->uri->segment(5),'sales_ord_no'=>$this->uri->segment(4));
            $data1=array_filter($master_array);
            $data2['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from="",$to="",$this->session->userdata['logged_in']['company_id']);
            foreach ($data2['job_card'] as $job_card_row){
                $job_card_no=$job_card_row->mp_pos_no;
           

            $query=$this->db->query("SELECT sum(total_qty) as total_qty,calculated_purchase_price,article_no from reserved_quantity_manu where manu_order_no='$job_card_no' and article_no like '%CAP-CAME-%'");

             $this->db->last_query();

                $result_capping_m_value=$query->result();
                if($result_capping_m_value==TRUE){
                foreach($result_capping_m_value as $result_capping_m_value_row){
                     $cap_m_article=$this->common_model->get_article_name($result_capping_m_value_row->article_no,$this->session->userdata['logged_in']['company_id']);

                    $ar_capping_m_cost=($this->common_model->read_number($result_capping_m_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($result_capping_m_value_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);


                    $ar_capping_m_quantity=($this->common_model->read_number($result_capping_m_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

                    $ar_cap_m_price=$this->common_model->read_number($result_capping_m_value_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);
                }
                    $capping_m_quantity=$ar_capping_m_quantity;
                    $capping_m_cost=$ar_capping_m_cost;
                    $cap_m_price=$ar_cap_m_price;
                
           

            echo "<tr class='item'><td class='label' width='10%' >CAP METALIZATION</td>
                    <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                    <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$cap_m_article."</td>
                    <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".round($capping_m_quantity)."</td>
                    <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>".$cap_m_price."</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".round($capping_m_cost,2)."</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'></td>
                    <td width='10%' style='text-align:right'></td>
                </tr>";
                $total_capping_m_cost+=$capping_m_cost;
                $total_capping_m_quantity+=$capping_m_quantity;
                $i++;
            }
            else{
                echo "<tr>
                        <td colspan='6'>NO METALIZATION FOR THIS JOB</td></tr>";
            }
        }
        */
        
        $total_capping_m_cost=0;
        echo "<tr class='heading'>
                <td><b>TOTAL</td>
                <td></td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'><b>&#8377; ".round($total_capping_cost+$total_capping_s_cost+$total_capping_m_cost,2)."</b></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round( ($total_capping_cost+$total_capping_s_cost+$total_capping_m_cost)/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2)."</td>
                <td></td>
            </tr>";
        ?>
        </table>

<!--
        <table cellpadding='5' cellspacing='0' style='border:1px solid #D9d9d9;'>
            <tr class="heading">
                <td colspan="8" style='border-bottom:1px solid #D9d9d9;'><b>CAPPING MATERIAL</td>
            </tr>
            <tr class="heading item">
                <td width="10%" ><b>GROUP</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b>MATERIAL</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b>QUANTITY</td>
                <td width="5%" style='border-right:1px solid #D9d9d9;text-align:right'>PRICE</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>TOTAL COST</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>COST/TUBE</td>
                <td width="10%" style='text-align:right'>PROCESSWISE COST/TUBE</td>
            </tr>
            <?php
            /*
            $total_capping_cost=0;
            $capping_cost=0;
            $total_capping_quantity=0;
            $capping_quantity=0;
            $master_array= array('article_no' =>$this->uri->segment(5),'sales_ord_no'=>$this->uri->segment(4));
            $data1=array_filter($master_array);
            $data2['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from="",$to="",$this->session->userdata['logged_in']['company_id']);
            foreach($data2['job_card'] as $job_card_row){
                $data=array('manu_order_no'=>$job_card_row->mp_pos_no,'completed_flag'=>'1','work_proc_no'=>'11');
            $data['job_card_issued']=$this->common_model->select_one_active_record_nonlanguage_without_archives_order_by('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$data,'article_no','work_proc_no');
            //echo $this->db->last_query();
            if($data['job_card_issued']==TRUE){
                $i=1;
            foreach ($data['job_card_issued'] as $job_card_row):

            $article_desc="";
            $calculated_purchase_price="";
            $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$job_card_row->article_no);
                foreach($data['article'] as $article_row){
                 $article_desc=$article_row->article_name;
                 $sub_group=$article_row->sub_group;
                 $main_group=$article_row->main_group;
                 $uom=$article_row->uom;
                }

            $data['workprocedure_types_master']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id',$job_card_row->work_proc_no);
                foreach($data['workprocedure_types_master'] as $row_workprocedure_types_master){
                    $process=$row_workprocedure_types_master->lang_description;
                }
				$cap_issue_qty=$this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id']);

            $query=$this->db->query("SELECT sum(total_qty) as total_qty,calculated_purchase_price from reserved_quantity_manu where manu_order_no='$job_card_row->manu_order_no' and article_no='$job_card_row->article_no' and type_flag='2'");

            //echo $this->db->last_query();

                $result_capping_value=$query->result();
                foreach($result_capping_value as $result_capping_value_row){

                    $ar_capping_cost=($this->common_model->read_number($result_capping_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($result_capping_value_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

                    $ar_capping_quantity=($this->common_model->read_number($result_capping_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

                    $ar_cap_price=$this->common_model->read_number($result_capping_value_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);
                }

                $m_capping_cost=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

                $m_capping_quantity=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

                $m_cap_price=$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

                if($ar_capping_quantity==$m_capping_quantity){
                    $cap_price=$m_cap_price;
                    $capping_quantity=$m_capping_quantity;
                    $capping_cost=$m_capping_cost;
                }else{
                    $capping_quantity=$ar_capping_quantity;
                    $capping_cost=$ar_capping_cost;
                    $cap_price=$ar_cap_price;
                }

			/*
            $capping_cost=($cap_issue_qty/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);
			
			$capping_quantity=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
            */

            //$capping_quantity=$cap_issue_qty;

        /*
            echo "<tr class='item'><td class='label' width='10%' >".$sub_group."</td>
                    <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                    <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$article_desc."</td>
                    <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".round($capping_quantity)."</td>
                    <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>".$cap_price."</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".round($capping_cost,2)."</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'></td>
                    <td width='10%' style='text-align:right'></td>
                </tr>";
                $total_capping_cost+=$capping_cost;
                $total_capping_quantity+=$capping_quantity;
                $i++;
            endforeach;
            }else{
                echo "<tr>
                        <td colspan='6'>NO CAPPING FOR THIS JOB</td></tr>";
            }
        }
        

        echo "<tr class='heading'>
                <td><b>TOTAL</td>
                <td></td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'><b>".round($total_capping_cost,2)."</b></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'>".round($total_capping_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2)."</td>
                <td></td>
            </tr>";
            */
        ?>
        </table>
    -->
        <br/>

        <table cellpadding='5' cellspacing='0' style='border:1px solid #D9d9d9;'>
            <tr class="heading">
                <td colspan="8" style='border-bottom:1px solid #D9d9d9;'><b>PACKING MATERIAL</td>
            </tr>
            <tr class="heading item">
                <td width="10%" ><b>GROUP</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b>MATERIAL</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b>QUANTITY</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>PRICE</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>TOTAL COST</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>COST/TUBE</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>PROCESSWISE COST/TUBE</td>
            </tr>
        <?php
            $total_packing_cost=0;
            $packing_quantity=0;
            $packing_cost=0;
            $total_packing_quantity=0;
            $master_array= array('article_no' =>$this->uri->segment(5),'sales_ord_no'=>$this->uri->segment(4));
            $data1=array_filter($master_array);
            $data2['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from="",$to="",$this->session->userdata['logged_in']['company_id']);
            foreach($data2['job_card'] as $job_card_row){
             $data=array('manu_order_no'=>$job_card_row->mp_pos_no,'completed_flag'=>'1','work_proc_no'=>'10','from_job_card'=>'1');
            $data['job_card_issued']=$this->common_model->select_one_active_record_nonlanguage_without_archives_order_by('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$data,'','work_proc_no');

            if($data['job_card_issued']==TRUE){
                $i=1;
            foreach ($data['job_card_issued'] as $job_card_row):
                $article_desc="";
                $calculated_purchase_price="";
                $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$job_card_row->article_no);
                foreach($data['article'] as $article_row){
                 $article_desc=$article_row->article_name;
                 $sub_group=$article_row->sub_group;
                 $main_group=$article_row->main_group;
                 $uom=$article_row->uom;
                }

            $data['workprocedure_types_master']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id',$job_card_row->work_proc_no);
                foreach($data['workprocedure_types_master'] as $row_workprocedure_types_master){
                    $process=$row_workprocedure_types_master->lang_description;
                }

            $packing_cost=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

            $packing_quantity=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

            echo "<tr class='item'><td class='label' width='10%' >".$sub_group."</td>
                    <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                    <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$article_desc."</td>
                    <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".round($packing_quantity,2)." ".$uom."</td>
                    <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id'])." / ".$uom."</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($packing_cost,2)."</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($packing_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2)."</td>
                    <td width='10%' style='text-align:right'></td>
                </tr>";
                $total_packing_cost+=$packing_cost;
                $total_packing_quantity+=$packing_quantity;
                $i++;
            endforeach;
            }else{
                echo "<tr><td colspan='6'>NO PACKING FOR THIS JOB</td></tr>";
            }
        }

            $total_other_packing_cost=0;
            $packing_type;
            if($packing_type==1){
                $query=$this->db->query("SELECT * from packing_material_consumption_master where apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
            }else{
                $query=$this->db->query("SELECT * from packing_material_consumption_master where apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1 and for_export<>1");
            }
            

            $result_other_packing=$query->result();
            //echo $this->db->last_query();
            if($result_other_packing==TRUE){
            foreach($result_other_packing as $result_other_packing_row){
                $other_packing=$result_other_packing_row->cost_per_tube*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

                echo "<tr class='item'><td class='label' width='10%'></td>
                        <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                        <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$result_other_packing_row->packing_material."</td>
                        <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'></td>
                        <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'></td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($other_packing,2)."</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($result_other_packing_row->cost_per_tube,3)."</td>
                        <td width='10%' style='text-align:right'></td>
                    </tr>";
                    $total_other_packing_cost+=$other_packing;
                }
                }else{
                    echo "<tr><td colspan='8'>PACKING MASTER IS NOT ENTERED</td></tr>";
                }
            $total_total_packing_cost=0;
            $total_total_packing_cost=$total_other_packing_cost+$total_packing_cost;
        echo "<tr class='heading'>
                <td><b>TOTAL</td>
                <td></td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'><b>&#8377; ".round($total_total_packing_cost,2)."</b></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($total_total_packing_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2)."</td>
                <td></td>
            </tr>";
        ?>
        </table>
        
        <br/>
        <table cellpadding='5' cellspacing='0' style='border:1px solid #D9d9d9;'>
            <tr class="heading">
                <td colspan="8" style='border-bottom:1px solid #D9d9d9;'><b>STORES AND SPARES</td>
            </tr>
            <tr class="heading item">
                <td width="10%" ><b>GROUP</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b>MATERIAL</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>TOTAL COST</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>COST/TUBE</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>PROCESSWISE COST/TUBE</td>
            </tr>
        <?php
            
            $total_stores_spares_cost=0;
            $query=$this->db->query("SELECT * from stores_and_spares_consumption_master where apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
            $result_stores_spares=$query->result();
            if($result_stores_spares==TRUE){
            foreach($result_stores_spares as $stores_spares_row){
                $stores_spares_cost=$stores_spares_row->cost_per_tube*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

                echo "<tr class='item'><td class='label' width='10%' >SPARES</td>
                        <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                        <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$stores_spares_row->stores_and_spares."</td>
                        <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&nbsp;</td>
                        <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&nbsp;</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($stores_spares_cost,2)."</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($stores_spares_row->cost_per_tube,2)."</td>
                        <td width='10%' style='text-align:right'></td>
                    </tr>";
                    $total_stores_spares_cost+=$stores_spares_cost;
                }
                }else{
                    echo "<tr><td colspan='8'>STORES AND SPARES MASTER IS NOT ENTERED</td></tr>";
                }

                echo "<tr class='heading'>
                <td><b>TOTAL</td>
                <td></td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'><b>&#8377; ".round($total_stores_spares_cost,2)."</b></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($total_stores_spares_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2)."</td>
                <td></td>
            </tr>";
            ?>
            </table>
            <br/>


            <table cellpadding='5' cellspacing='0' style='border:1px solid #D9d9d9;'>
            <tr class="heading">
                <td colspan="8" style='border-bottom:1px solid #D9d9d9;'><b>ADDITIONAL MATERIAL</td>
            </tr>

            <tr class="heading item">
                <td width="10%" ><b>GROUP</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b>MATERIAL</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b>QUANTITY</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>PRICE</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>TOTAL COST</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>COST/TUBE</td>
                <td width="10%" style='text-align:right'>PROCESSWISE COST/TUBE</td>
            </tr>
        <?php
        $total_additional_cost=0;
        $additional_cost=0;
        $total_additional_quantity=0;
        $additional_quantity=0;
        $master_array= array('article_no' =>$this->uri->segment(5),'sales_ord_no'=>$this->uri->segment(4));
        $data1=array_filter($master_array);
        $data2['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from="",$to="",$this->session->userdata['logged_in']['company_id']);
        foreach($data2['job_card'] as $job_card_row){
            $data=array('manu_order_no'=>$job_card_row->mp_pos_no,'completed_flag'=>'1','from_job_card'=>'0');

            $in=array('5','11');

            $data['job_card_issued']=$this->costsheet_model->select_additional('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$data,$in,'article_no','work_proc_no');
           //echo $this->db->last_query();

           //echo "<br/>";
            if($data['job_card_issued']==TRUE){
            $i=1;
            foreach ($data['job_card_issued'] as $job_card_row):
                $article_desc="";
                $calculated_purchase_price="";
                $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$job_card_row->article_no);
                foreach($data['article'] as $article_row){
                 $article_desc=$article_row->article_name;
                 $sub_group=$article_row->sub_group;
                 $main_group=$article_row->main_group;
                 $uom=$article_row->uom;

                 //echo $job_card_row->article_no;
                 //echo "<br/>";
                }

            $data['workprocedure_types_master']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id',$job_card_row->work_proc_no);
                foreach($data['workprocedure_types_master'] as $row_workprocedure_types_master){
                    $process=$row_workprocedure_types_master->lang_description;
                }

            $m_additional_cost=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

            $m_additional_quantity=($this->common_model->read_number($job_card_row->demand_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);



            $query=$this->db->query("SELECT sum(total_qty) as total_qty,calculated_purchase_price from reserved_quantity_manu where manu_order_no='$job_card_row->manu_order_no' and article_no='$job_card_row->article_no' and type_flag='4' and article_no  NOT LIKE '%LBL%' and article_no NOT LIKE '%CAP%' AND article_no NOT LIKE '%RM-CAS-%'");

          // echo $this->db->last_query();

                $result_additional_value=$query->result();
                foreach($result_additional_value as $result_additional_value_row){

                    $ar_additional_cost=($this->common_model->read_number($result_additional_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($result_additional_value_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);

                   $ar_additional_quantity=($this->common_model->read_number($result_additional_value_row->total_qty,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

                   
                }

                if($ar_additional_quantity==$m_additional_quantity){
                    
                    $additional_quantity=$m_additional_quantity;
                    $additional_cost=$m_additional_cost;
                }else{
                    $additional_quantity=$ar_additional_quantity;
                    $additional_cost=$ar_additional_cost;
                    //$cap_price=$ar_cap_price;
                }




            echo "<tr class='item'><td class='label' width='10%' >".$sub_group."</td>
                    <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                    <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$article_desc."</td>
                    <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".round($additional_quantity,2)." ".$uom."</td>
                    <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".$this->common_model->read_number($job_card_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id'])." / ".$uom."</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($additional_cost,2)."</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'></td>
                    <td width='10%'></td>
                </tr>";
                $total_additional_cost+=$additional_cost;
                $total_additional_quantity+=$additional_quantity;
                $i++;
            endforeach;
            }else{
                    echo "<tr><td colspan='8'>NO ADDITIONAL MATERIAL FOR THIS JOB</td></tr>";
                }
            }
        

        echo "<tr class='heading'>
                <td><b>TOTAL</td>
                <td></td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'>".round($total_additional_quantity,2)."</td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'><b>&#8377; ".round($total_additional_cost,2)."</b></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($total_additional_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2)."</td>
                <td></td>
            </tr>";
        ?>
        </table>
    </br>


        <table cellpadding='5' cellspacing='0' style='border:1px solid #D9d9d9;'>
            <tr class="heading">
                <td colspan="8" style='border-bottom:1px solid #D9d9d9;'><b>FREIGHT</td>
            </tr>
            <tr class="heading item">
                <td width="10%" ><b>GROUP</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b>MATERIAL</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b>QUANTITY</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>PRICE</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>TOTAL COST</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>COST/TUBE</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>PROCESSWISE COST/TUBE</td>
            </tr>

        <?php
             
            $total_freight=0;
            $total_freight_amount=0;
            $query=$this->db->query("SELECT * from freight_master where sleeve_id='$dia' and customer_no='$ar_invoice_master_row->customer_no' and apply_from_date<='$ar_invoice_master_row->invoice_date' and apply_to_date>='$ar_invoice_master_row->invoice_date' and archive<>1");
            $result_freight_value=$query->result();
            //echo $this->db->last_query();
            if($result_freight_value==TRUE){
            foreach($result_freight_value as $result_freight_value_row){
                $total_freight=$result_freight_value_row->cost_per_tube*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

                echo "<tr class='item'><td class='label' width='10%' >FREIGHT</td>
                        <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                        <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'></td>
                        <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])." NOS</td>
                        <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; </td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($total_freight,2)."</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($result_freight_value_row->cost_per_tube,2)."</td>
                        <td width='10%' style='text-align:right'></td>
                    </tr>";
                    $total_freight_amount+=$total_freight;
                }
                }else{
                    echo "<tr><td colspan='8'>FREIGHT IS NOT ENTERED</td></tr>";
                }
                

            ?>
        </table>

        <br/>

            <table cellpadding='5' cellspacing='0' style='border:1px solid #D9d9d9;'>
            <tr class="heading">
                <td colspan="8" style='border-bottom:1px solid #D9d9d9;'><b>TOTAL COST SUMMARY</td>
            </tr>
            <tr class="heading item">
                <td width="10%" ><b>GROUP</td>
                <td width="60%" colspan="4" style="border-right:1px solid #D9d9d9;"></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>TOTAL COST</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>COST/TUBE</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
            </tr>

            <tr class="item">
                <td width="10%">SLEEVE</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b></td>
                <td width="5%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_extrusion_cost,2);?></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_extrusion_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2);?></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
            </tr>

            <tr class="item">
                <td width="10%" >PURGING</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b></td>
                <td width="5%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_purging_cost,2);?></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_purging_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2);?></td>
                <td width="10%" style='text-align:right'></td>
            </tr>

            <tr class="item">
                <td width="10%" >SHOULDER</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b></td>
                <td width="5%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_heading_cost,2)?></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_heading_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2);?></td>
                <td width="10%" style='text-align:right'></td>
            </tr>

            <tr class="item">
                <td width="10%" >PRINTING</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b></td>
                <td width="5%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_total_printing_cost,2)?></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_total_printing_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2);?></td>
                <td width="10%" style='text-align:right'></td>
            </tr>

            <tr class="item">
                <td width="10%" >PRINTING CONSUMABLE</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b></td>
                <td width="5%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_consumable,2)?></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_consumable/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2);?></td>
                <td width="10%" style='text-align:right'></td>
            </tr>

            <tr class="item">
                <td width="10%" >LABEL</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b></td>
                <td width="5%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><?php echo round($total_labeling_cost,2)?></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><?php echo round($total_labeling_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2);?></td>
                <td width="10%" style='text-align:right'></td>
            </tr>

            <tr class="item">
                <td width="10%" >FOIL</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b></td>
                <td width="5%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_foiling_cost,2)?></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_foiling_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2);?></td>
                <td width="10%" style='text-align:right'></td>
            </tr>

            <tr class="item">
                <td width="10%" >SHOULDER FOIL</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b></td>
                <td width="5%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_shoulderfoil_cost,2)?></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_shoulderfoil_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2);?></td>
                <td width="10%" style='text-align:right'></td>
            </tr>

            <tr class="item">
                <td width="10%" >CAPPING</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b></td>
                <td width="5%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><?php echo round($total_capping_cost+$total_capping_s_cost+$total_capping_m_cost,2)?></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><?php echo round(($total_capping_cost+$total_capping_s_cost+$total_capping_m_cost)/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2);?></td>
                <td width="10%" style='text-align:right'></td>
            </tr>

            <tr class="item">
                <td width="10%" >PACKING</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b></td>
                <td width="5%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_total_packing_cost,2)?></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_total_packing_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2);?></td>
                <td width="10%" style='text-align:right'></td>
            </tr>

            <tr class="item">
                <td width="10%" >STORES & SPARES</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b></td>
                <td width="5%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_stores_spares_cost,2)?></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_stores_spares_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2);?></td>
                <td width="10%" style='text-align:right'></td>
            </tr>

            <tr class="item">
                <td width="10%" >ADDITIONAL MATERIAL</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b></td>
                <td width="5%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_additional_cost,2)?></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_additional_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2);?></td>
                <td width="10%" style='text-align:right'></td>
            </tr>

            <tr class="item">
                <td width="10%" >FREIGHT</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b></td>
                <td width="5%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_freight_amount,2);?></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_freight_amount/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2);?></td>
                <td width="10%" style='text-align:right'></td>
            </tr>

            <?php $total_final_cost=$total_extrusion_cost+$total_purging_cost+$total_heading_cost+$total_total_printing_cost+$total_consumable+$total_labeling_cost+$total_foiling_cost+$total_shoulderfoil_cost+$total_capping_cost+$total_capping_s_cost+$total_capping_m_cost+$total_total_packing_cost+$total_stores_spares_cost+$total_additional_cost+$total_freight_amount;
            ?>

            <tr class="item heading">
                <td width="10%" >TOTAL COST</td>
                <td width="60%" colspan="4" style="border-right:1px solid #D9d9d9;"></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_final_cost,2)?></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_final_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2);?></td>
                <td width="10%" style='text-align:right'></td>
            </tr>


            
        </table>

        <br/>
            <table cellpadding='5' cellspacing='0' style='border:1px solid #D9d9d9;'>

            <tr class="item heading">
                <td width="10%" >INVOICE VALUE</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><?php echo number_format($unit_rate_in_rupees*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']));?></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><?php echo $unit_rate_in_rupees;?></td>
                <td width="10%" style='text-align:right'></td>
            </tr>

            <tr class="item heading">
                <td width="10%" >TOTAL COST</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b></td>
                <td width="5%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><?php echo round($total_final_cost,2)?></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><?php echo round($total_final_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2);?></td>
                <td width="10%" style='text-align:right'></td>
            </tr>
            <?php $contribution=0;
            $contribution=$unit_rate_in_rupees*$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id'])-$total_final_cost;
            $contribution_cost_per_tube=$unit_rate_in_rupees-round($total_final_cost/$this->common_model->read_number($ar_invoice_details_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2);
            ?>
            <tr class="item heading">
                <td width="10%" >CONTRIBUTION</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b></td>
                <td width="5%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><?php echo round($contribution,2);?></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><?php echo round($contribution_cost_per_tube,2);?></td>
                <td width="10%" style='text-align:right'></td>
            </tr>

            <tr class="item heading">
                <td width="10%" >CON %</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b></td>
                <td width="5%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><?php echo round(($contribution_cost_per_tube/$unit_rate_in_rupees)*100);?>%</td>
                <td width="10%" style='text-align:right'></td>
            </tr>










        
        <?php endforeach;?>
    </div>
<?php endforeach;?>
