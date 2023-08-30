<div class="ui teal labels" style="text-align: center;">
      <div class="ui label">COST SHEET BY PRODUCT</div>
</div>


<table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
        
            <tr class="heading">
                <td width="10%"><b>BILLING</b></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><?php echo $this->common_model->get_parent_name($article_no,$this->session->userdata['logged_in']['company_id']);?></td>
                <td width="10%"><b>PRODUCT CODE</p></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%"><?php echo $article_no;?> </td>
            </tr>

            <tr class="item">
                <td width="10%"><b>PRODUCT</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="50%" colspan='4' ><?php echo $this->common_model->get_article_name($article_no,$this->session->userdata['logged_in']['company_id']);?></td>
            </tr>




<?php
    
    setlocale(LC_MONETARY, 'en_IN');
    $data=array('ar_invoice_details.article_no'=>$this->uri->segment(3));

    $data['ar_invoice_master']=$this->sales_invoice_book_model->active_records_search_costsheet('ar_invoice_master',$data,$from_date,$to_date,$this->session->userdata['logged_in']['company_id']);


    if($data['ar_invoice_master']==TRUE){
        $invoice_no="";$order_no="";
        foreach($data['ar_invoice_master'] as $ar_invoice_master_row){
            $customer_no=$ar_invoice_master_row->customer_no;
            $dia=$ar_invoice_master_row->sleeve_dia;
            $length=$ar_invoice_master_row->sleeve_length;
            $layer_no=$ar_invoice_master_row->layer_no;
            $for_export=$ar_invoice_master_row->for_export;
            $print_type=$ar_invoice_master_row->print_type;
            $cap_metalization=$ar_invoice_master_row->cap_metalization;
            $exchange_rate=($ar_invoice_master_row->exchange_rate!='0' ? (strpos($ar_invoice_master_row->exchange_rate,".")!=''?$ar_invoice_master_row->exchange_rate : $this->common_model->read_number($ar_invoice_master_row->exchange_rate,$this->session->userdata['logged_in']['company_id'])) : '');
            $unit_rate='';
            $currency_id=($ar_invoice_master_row->currency_id!='' ? $ar_invoice_master_row->currency_id : '');

            $invoice_no.=$ar_invoice_master_row->ar_invoice_no.',';
            $order_no.=$ar_invoice_master_row->ref_ord_no.',';
            $order_flag=$ar_invoice_master_row->order_flag;

            }
        }

    ?>      

            <tr class="item">
                <td width="10%"><b>DIA X LENGTH</b></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><?php echo $dia."X".$length;?> <span style="border-left:1px solid #ddd;margin-left: 100px;padding-left: 10px;border-right:1px solid #ddd;padding-right: 10px;"><b>LAYER </b></span>&nbsp;&nbsp;&nbsp;<?php echo $layer_no;?></td>
                <td width="10%"><b>PRINT TYPE</p></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%"><?php echo $print_type;?></td>
            </tr>
            <tr class="item">
                <td width="10%"><b>ORDER NO</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><?php echo $order_no;?></td>
                <td width="10%"><b>INVOICE NO</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%"><?php echo $invoice_no;?></td>
            </tr>
        
        <?php
            $search=array('ar_invoice_details.article_no'=>$this->uri->segment(3));
            $data['product']=$this->costsheet_model->active_record_search_by_product('ar_invoice_master',$from_date,$to_date,$search,$customer_category="",$this->session->userdata['logged_in']['company_id'],$print="");
            $total_qty=0;
            foreach($data['product'] as $product_row){
                $total_qty=$product_row->total_qty;
                $amount=$product_row->amount;
                $sales_rate=$product_row->amount/$product_row->total_qty;
            }
        ?>


            <tr class="item">
                <td width="10%"><b>INVOICE RATE</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><?php echo round($sales_rate,2)?></td>
                <td width="10%"><b>INVOICE QTY</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%"><?php echo money_format('%!.0n',$total_qty);?></td>
            </tr>

            <tr class="item">
                <td width="10%"><b>INVOICE VALUE</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" colspan="3"><?php echo money_format('%.0n',$amount);?></td>
            </tr>
        
        </table>



<?php



    $data=array('ar_invoice_details.article_no'=>$this->uri->segment(3));

    $data['ar_invoice_master']=$this->sales_invoice_book_model->active_records_search_distinct_so_costsheet('ar_invoice_master',$data,$from_date,$to_date,$this->session->userdata['logged_in']['company_id']);

    $jobcard_no_list="";
    $total_dispatch=0;
    $total_dispatchh=0;
    if($data['ar_invoice_master']==TRUE){
        
        foreach($data['ar_invoice_master'] as $ar_invoice_master_row){
            $total_dispatch=0;
            $coex_jobcard_no='';
            $spring_printing_jobcard='';
            $spring_bodymaking_jobcard='';

            $data_jobcard= array('article_no' =>$this->uri->segment(3),'sales_ord_no'=>$ar_invoice_master_row->ref_ord_no,'archive'=>0);

            $result_production_master=$this->common_model->select_active_records_where('production_master',$this->session->userdata['logged_in']['company_id'],$data_jobcard);
            

            $order_details=array('ref_ord_no'=>$ar_invoice_master_row->ref_ord_no,'article_no'=>$this->uri->segment(3));
            $result_dispatch=$this->common_model->select_active_records_where('ar_invoice_details',$this->session->userdata['logged_in']['company_id'],$order_details);
            foreach($result_dispatch as $row_total_dispatch){
                $total_dispatch+=$this->common_model->read_number($row_total_dispatch->arid_qty,$this->session->userdata['logged_in']['company_id']);
            }
            $total_dispatchh+=$total_dispatch;


            $order_array= array('article_no' =>$this->uri->segment(3),'order_no'=>$ar_invoice_master_row->ref_ord_no);
            $result_order_details=$this->sales_order_book_model->active_details_records('order_details',$order_array,$this->session->userdata['logged_in']['company_id']);
            $aw="";
            $awv="";
            $packing_type="";
            if($result_order_details==TRUE){
                foreach($result_order_details as $result_order_details_row){
                    $aw=$result_order_details_row->ad_id;
                    $awv=$result_order_details_row->version_no;
                    $spec_id=$result_order_details_row->spec_id;
                    $spec_version_no=$result_order_details_row->spec_version_no;
                    $bom_data=array('bom_no'=>$spec_id,'bom_version_no'=>$spec_version_no);
                    $result_bom=$this->common_model->select_one_active_record_nonlanguage_without_archives('bill_of_material',$this->session->userdata['logged_in']['company_id'],$bom_data);
                    if($result_bom==TRUE){
                        foreach($result_bom as $result_bom_row){
                            $packing_type=$result_bom_row->for_export;
                        }
                    }

                }
            }


            $master_array= array('article_no' =>$this->uri->segment(3),'sales_ord_no'=>$ar_invoice_master_row->ref_ord_no);
            $data1=array_filter($master_array);
            $data2['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from="",$to="",$this->session->userdata['logged_in']['company_id']);
            foreach($data2['job_card'] as $job_card_row){

                $AddToEnd = "'";
                $AddToStart = "'";
                $comma=",";
                $jobcard_no_list.=$AddToStart.$job_card_row->mp_pos_no.$AddToEnd.$comma;
                
            }

        }
    }       

    $total_dispatchh;

    $jobcard_array=rtrim($jobcard_no_list,", ");


    echo "<br/><table cellpadding='5' cellspacing='0' style='border:1px solid #D9d9d9;'>
            <tr class='heading'>
                <td colspan='7' style='border-bottom:1px solid #D9d9d9;'><b>EXTRUSION PROCESS<b></td>
            </tr>
            <tr class='heading item'>
                <td width='10%'><b>GROUP</td>
                <td width='5%' style='border-right:1px solid #D9d9d9;'></td>
                <td width='35%' style='border-right:1px solid #D9d9d9;'><b>MATERIAL</td>
                <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'><b>QUANTITY</td>
                <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>PRICE</td>
                <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>TOTAL COST</td>
                <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>COST/TUBE</td>
                
            </tr>";
        

            $push_jobcards=array('completed_flag'=>'1','work_proc_no'=>'1','from_job_card'=>'1');
            $this->load->model('job_card_model');
            $data['jobcard_result']=$this->job_card_model->jobcard_material_summary_new('material_manufacturing',$push_jobcards,$this->session->userdata['logged_in']['company_id'],$jobcard_array);

            //echo $this->db->last_query();
            if($data['jobcard_result']==TRUE){
                $total_extrusion_cost=0;
                $extrusion_cost=0;
                $total_extrusion_quantity=0;
                $extrusion_quantity=0;
                foreach($data['jobcard_result'] as $job_card_row){

                    $article_desc="";
                    $calculated_purchase_price="";
                    $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$job_card_row->article_no);
                    foreach($data['article'] as $article_row){
                     $article_desc=$article_row->article_name;
                     $sub_group=$article_row->sub_group;
                     $main_group=$article_row->main_group;
                     $uom=$article_row->uom;
                    }

                    $extrusion_cost=($job_card_row->total_demand_qty/$total_dispatchh)*$total_qty*$job_card_row->avg_rate;

                    $extrusion_quantity=($job_card_row->total_demand_qty/$total_dispatchh)*$total_qty;

                    echo "<tr class='item'><td class='label' width='10%' >".strtoupper($main_group)."</td>
                    <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                    <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$article_desc."</td>
                    <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".round($extrusion_quantity,2)." ".$uom."</td>
                    <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($job_card_row->avg_rate,2)." / ".$uom."</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($extrusion_cost,2)."</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'></td>
                    
                </tr>";

                $total_extrusion_cost+=$extrusion_cost;
                $total_extrusion_quantity+=$extrusion_quantity;
                }

                echo "<tr class='heading'>
                <td><b>TOTAL</td>
                <td></td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'>".round($total_extrusion_quantity,2)."</td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'><b>&#8377; ".round($total_extrusion_cost,2)."</b></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($total_extrusion_cost/$total_qty,2)."</td>
                
            </tr>";
            }


    echo "</table>";

//END EXTRUSION

//START PURGING

    ?>
    <br/>
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
                
            </tr>
        <?php

        $total_purging_cost=0;
        $purging_cost=0;
        $total_purging_quantity=0;
        $purging_quantity=0;

            $push_jobcards=array('completed_flag'=>'1','work_proc_no'=>'9');
            $this->load->model('job_card_model');
            $data['jobcard_result']=$this->job_card_model->jobcard_material_summary_new('material_manufacturing',$push_jobcards,$this->session->userdata['logged_in']['company_id'],$jobcard_array);
            if($data['jobcard_result']==TRUE){

                foreach($data['jobcard_result'] as $job_card_row){
                    $article_desc="";
                    $calculated_purchase_price="";
                    $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$job_card_row->article_no);
                    foreach($data['article'] as $article_row){
                     $article_desc=$article_row->article_name;
                     $sub_group=$article_row->sub_group;
                     $main_group=$article_row->main_group;
                     $uom=$article_row->uom;
                    }

                    $purging_cost=($job_card_row->total_demand_qty/$total_dispatchh)*$total_qty*$job_card_row->avg_rate;

                    $purging_quantity=($job_card_row->total_demand_qty/$total_dispatchh)*$total_qty;

                    echo "<tr class='item'><td class='label' width='10%' >".strtoupper($main_group)."</td>
                    <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                    <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$article_desc."</td>
                    <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".round($purging_quantity,2)." ".$uom."</td>
                    <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($job_card_row->avg_rate,2)." / ".$uom."</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($purging_cost,2)."</td>
                    </tr>";


                    $total_purging_cost+=$purging_cost;
                    $total_purging_quantity+=$purging_quantity;

                }


                echo "<tr class='heading'>
                        <td><b>TOTAL</td>
                        <td></td>
                        <td style='border-right:1px solid #D9d9d9;'></td>
                        <td style='border-right:1px solid #D9d9d9;text-align:right'>".round($total_purging_quantity,2)."</td>
                        <td style='border-right:1px solid #D9d9d9;'></td>
                        <td style='border-right:1px solid #D9d9d9;text-align:right'><b>&#8377; ".round($total_purging_cost,2)."</b></td>
                        <td style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($total_purging_cost/$total_qty,2)."</td>
                        
                    </tr>";
            }

        ?>

        </table>
 
        <br/>
        <table cellpadding='5' cellspacing='0' style='border:1px solid #D9d9d9;'>
            
            <tr class="heading">
                <td colspan="8" style='border-bottom:1px solid #D9d9d9;'><b>HEADING PROCESS</td>
            </tr>

            <tr class="heading item">
                <td width="10%" ><b>GROUP</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b>MATERIAL</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b>QUANTITY</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>PRICE</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>TOTAL COST</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>COST/TUBE</td>
            </tr>


            <?php
            $total_heading_cost=0;
            $heading_cost=0;
            $total_heading_quantity=0;
            $heading_quantity=0;

            $push_jobcards=array('completed_flag'=>'1','work_proc_no'=>'2','from_job_card'=>'1');
            $this->load->model('job_card_model');
            $data['jobcard_result']=$this->job_card_model->jobcard_material_summary_new('material_manufacturing',$push_jobcards,$this->session->userdata['logged_in']['company_id'],$jobcard_array);
            if($data['jobcard_result']==TRUE){
                foreach($data['jobcard_result'] as $job_card_row){
                    $article_desc="";
                    $calculated_purchase_price="";
                    $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$job_card_row->article_no);
                    foreach($data['article'] as $article_row){
                     $article_desc=$article_row->article_name;
                     $sub_group=$article_row->sub_group;
                     $main_group=$article_row->main_group;
                     $uom=$article_row->uom;
                    }

                    $heading_cost=($job_card_row->total_demand_qty/$total_dispatchh)*$total_qty*$job_card_row->avg_rate;

                    $heading_quantity=($job_card_row->total_demand_qty/$total_dispatchh)*$total_qty;

                    echo "<tr class='item'><td class='label' width='10%' >".strtoupper($main_group)."</td>
                    <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                    <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$article_desc."</td>
                    <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".round($heading_quantity,2)." ".$uom."</td>
                    <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($job_card_row->avg_rate,2)." / ".$uom."</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($heading_cost,2)."</td>
                    </tr>";

                    $total_heading_cost+=$heading_cost;
                    $total_heading_quantity+=$heading_quantity;

                }

                echo "<tr class='heading'>
                <td><b>TOTAL</td>
                <td></td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'>".round($total_heading_quantity,2)."</td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'><b>&#8377; ".round($total_heading_cost,2)."</b></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($total_heading_cost/$total_qty,2)."</td>
                </tr>";
            }
        ?>
        </table>
        <br/>


        <table cellpadding='5' cellspacing='0' style='border:1px solid #D9d9d9;'>
            <tr class="heading">
                <td colspan="8" style='border-bottom:1px solid #D9d9d9;'><b>PRINTING PROCESS</b>
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
            </tr>

            <?php
            $total_printing_cost=0;
            $printing_cost=0;
            $total_printing_quantity=0;
            $printing_quantity=0;


            $push_jobcards=array('completed_flag'=>'1','work_proc_no'=>'3');
            $this->load->model('job_card_model');
            $data['jobcard_result']=$this->job_card_model->jobcard_material_summary_new('material_manufacturing',$push_jobcards,$this->session->userdata['logged_in']['company_id'],$jobcard_array);
            if($data['jobcard_result']==TRUE){
                foreach($data['jobcard_result'] as $job_card_row){

                    $article_desc="";
                    $calculated_purchase_price="";
                    $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$job_card_row->article_no);
                    foreach($data['article'] as $article_row){
                     $article_desc=$article_row->article_name;
                     $sub_group=$article_row->sub_group;
                     $main_group=$article_row->main_group;
                     $uom=$article_row->uom;
                    }



                    $printing_cost=($job_card_row->total_demand_qty/$total_dispatchh)*$total_qty*$job_card_row->avg_rate;

                    $printing_quantity=($job_card_row->total_demand_qty/$total_dispatchh)*$total_qty;

                    echo "<tr class='item'><td class='label' width='10%' >".strtoupper($main_group)."</td>
                    <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                    <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$article_desc."</td>
                    <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".round($printing_quantity,2)." ".$uom."</td>
                    <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($job_card_row->avg_rate,2)." / ".$uom."</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($printing_cost,2)."</td>
                    </tr>";


                    $total_printing_cost+=$printing_cost;
                    $total_printing_quantity+=$printing_quantity;

                }

                echo "<tr class='heading'>
                <td><b>TOTAL</td>
                <td></td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'>".round($total_printing_quantity,2)."</td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'><b>&#8377; ".round($total_printing_cost,2)."</b></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($total_printing_cost/$total_qty,2)."</td>
                </tr>";
            }


            $total_ink_cost=0;

        if(strcmp($print_type, 'SCREEN') == 0 || strcmp($print_type, 'SCREEN+UPTO NECK') == 0 || strcmp($print_type, 'SCREEN + LABEL') == 0 || strcmp($print_type, 'SCREEN+FLEXO') == 0 || strcmp($print_type, 'OFFSET SCREEN') == 0 || strcmp($print_type, 'FLEXO+SCREEN') == 0){

            $screen_ink_value_row=0;
            $s_screen_ink_value_row=0;
            $screen_ink_value_cost_per_kg=0;
            $s_screen_ink_value_cost_per_kg=0;
            $screen_ink_value_gm_tube=0;
            $s_screen_ink_value_gm_tube=0;

            $ink_data=array('ink_id'=>'3');

            $result_screen_ink_value=$this->costsheet_model->get_ink_cost('ink_price_master',$this->session->userdata['logged_in']['company_id'],$ink_data,$from_date,$to_date);
            if($result_screen_ink_value==TRUE){
                foreach($result_screen_ink_value as $result_screen_ink_value_row){

                    $screen_ink_value_cost_per_kg=$result_screen_ink_value_row->avg_cost_per_kg;
             


            $ink_data=array('ink_id'=>'4');

            $result_s_screen_ink_value=$this->costsheet_model->get_ink_cost('ink_price_master',$this->session->userdata['logged_in']['company_id'],$ink_data,$from_date,$to_date);
           // echo $this->db->last_query();
            if($result_s_screen_ink_value==TRUE){
                foreach($result_s_screen_ink_value as $result_s_screen_ink_value_row){

                    $s_screen_ink_value_cost_per_kg=$result_s_screen_ink_value_row->avg_cost_per_kg;
                }
            }

            $query=$this->db->query("SELECT * from coex_ink_consumption_master where article_no='".$this->uri->segment(3)."' and artwork_no='$aw' and artwork_version_no='$awv' and archive<>1 limit 0,1");
            $result_screen_ink_gm_tube_result=$query->result();
            $screen_ink_gm_tube=0;
            $s_screen_ink_gm_tube=0;
            if($result_screen_ink_gm_tube_result==TRUE){

                foreach($result_screen_ink_gm_tube_result as $result_screen_ink_gm_tube_row){

                    $screen_ink_value_row=($result_screen_ink_gm_tube_row->screen_ink_gm_tube*$total_qty)/1000*$screen_ink_value_cost_per_kg;
                    $screen_ink_gm_tube=$result_screen_ink_gm_tube_row->screen_ink_gm_tube;

                    $s_screen_ink_value_row=($result_screen_ink_gm_tube_row->special_ink_gm_tube*$total_qty)/1000*$s_screen_ink_value_cost_per_kg;

                    $s_screen_ink_gm_tube=$result_screen_ink_gm_tube_row->special_ink_gm_tube;
                }
            }

            echo "<tr class='item'><td class='label' width='10%' >SCREEN INK</td>
                        <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                        <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>SCREEN INK<br/>".$screen_ink_gm_tube." GM/TUBE X ".$total_qty."</td>
                        <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".round(($screen_ink_gm_tube*$total_qty/1000),2)." KGS</td>
                        <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($screen_ink_value_cost_per_kg,2)." / KGS</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($screen_ink_value_row,2)."</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round(($screen_ink_value_row)/$total_qty,2)."</td>
                        </tr>";
                if($s_screen_ink_gm_tube<>''){

                            echo "<tr class='item'><td class='label' width='10%' >SPECIAL SCREEN INK</td>
                        <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                        <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>SPECIAL INK <br/>".$s_screen_ink_gm_tube." GM/TUBE X ".$total_qty."</td>
                        <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".round(($s_screen_ink_gm_tube*$total_qty/1000),2)." KGS</td>
                        <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($s_screen_ink_value_cost_per_kg,2)." / KGS</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($s_screen_ink_value_row,2)."</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round(($s_screen_ink_value_row/$total_qty),2)."</td>
                        
                        </tr>";

                        }
               }
            }

            $total_ink_cost+=$screen_ink_value_row+$s_screen_ink_value_row; 
        }


        if(strcmp($print_type, 'OFFSET') == 0 || strcmp($print_type, 'OFFSET SCREEN') == 0  || strcmp($print_type, 'LABEL OFFSET') == 0){
            $offset_ink_value_row=0;
            $offset_ink_value_cost_per_kg=0;
            $offset_ink_value_gm_tube=0;
            $offset_ink_gm_tube="";

            $ink_data2=array('ink_id'=>'2');

            $result_offset_ink_value=$this->costsheet_model->get_ink_cost('ink_price_master',$this->session->userdata['logged_in']['company_id'],$ink_data2,$from_date,$to_date);

            if($result_offset_ink_value==TRUE){
                foreach($result_offset_ink_value as $result_offset_ink_value_row){
                    $offset_ink_value_cost_per_kg=$result_offset_ink_value_row->avg_cost_per_kg;
                }
            }

            $sql_offset="SELECT * from coex_ink_consumption_master where article_no='".$this->uri->segment(3)."' and artwork_no='$aw' and artwork_version_no='$awv' and archive<>1 limit 0,1";
            $query=$this->db->query($sql_offset);
            $result_offset_ink_gm_tube_result=$query->result();
            if($result_offset_ink_gm_tube_result==TRUE){
                foreach($result_offset_ink_gm_tube_result as $result_offset_ink_gm_tube_row){
                    
                    $offset_ink_value_row=(($result_offset_ink_gm_tube_row->offset_ink_gm_tube*$total_qty)/1000)*$offset_ink_value_cost_per_kg;
                    $offset_ink_gm_tube=$result_offset_ink_gm_tube_row->offset_ink_gm_tube;
                }
            }

            echo "<tr class='item'><td class='label' width='10%' >OFFSET INK</td>
                        <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                        <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>OFFSET<br/>".$offset_ink_gm_tube." GM/TUBE X ".$total_qty."</td>
                        <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".round(($offset_ink_gm_tube*$total_qty/1000),2)." KGS</td>
                        <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($offset_ink_value_cost_per_kg,2)."</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($offset_ink_value_row,2)."</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($offset_ink_value_row/$total_qty,2)."</td>
                        
                    </tr>";
            
        }

        if(strcmp($print_type, 'FLEXO') == 0 || strcmp($print_type, 'SCREEN+FLEXO') == 0 || strcmp($print_type, 'FLEXO+SCREEN') == 0){
            $flexo_ink_value_row=0;
            $flexo_ink_value_cost_per_kg=0;
            $flexo_ink_value_gm_tube=0;

            $ink_data3=array('ink_id'=>'1');

            $result_flexo_ink_value=$this->costsheet_model->get_ink_cost('ink_price_master',$this->session->userdata['logged_in']['company_id'],$ink_data3,$from_date,$to_date);

            if($result_flexo_ink_value==TRUE){
                foreach($result_flexo_ink_value as $result_flexo_ink_value_row){

                   $flexo_ink_value_cost_per_kg=$result_flexo_ink_value_row->avg_cost_per_kg;
                }
            }

            $flexo_ink_gm_tube=0;
            $query=$this->db->query("SELECT * from coex_ink_consumption_master where article_no='".$this->uri->segment(3)."' and artwork_no='$aw' and artwork_version_no='$awv' and archive<>1 limit 0,1");
            $result_flexo_ink_gm_tube_result=$query->result();
            if($result_flexo_ink_gm_tube_result==TRUE){
                $flexo_ink_gm_tube=0;
                foreach($result_flexo_ink_gm_tube_result as $result_flexo_ink_gm_tube_row){
                    
                    $flexo_ink_value_row=(($result_flexo_ink_gm_tube_row->flexo_ink_gm_tube*$total_qty)/1000)*$flexo_ink_value_cost_per_kg;
                    $flexo_ink_gm_tube=$result_flexo_ink_gm_tube_row->flexo_ink_gm_tube;
                }
            }

            echo "<tr class='item'><td class='label' width='10%' >FLEXO INK</td>
                        <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                        <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>FLEXO<br/>".$flexo_ink_gm_tube." GM/TUBE X ".$total_qty."</td>
                        <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".round(($flexo_ink_gm_tube*$total_qty/1000),2)." KGS</td>
                        <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($flexo_ink_value_cost_per_kg,2)."</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($flexo_ink_value_row,2)."</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($flexo_ink_value_row/$total_qty,2)."</td>
                        
                    </tr>";

            $total_ink_cost+=$flexo_ink_value_row;
            
        }

        if(strcmp($print_type, 'DIGITAL+FLEXO') == 0 || strcmp($print_type, 'FLEXO+DIGITAL') == 0 || strcmp($print_type, 'FLEXO+DIGITAL+FLEXO') == 0 ){
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
                <td style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($total_total_printing_cost/$total_qty,2)."</td>
                </tr>";
        

     ?>
        </table>
        <br/>

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
            </tr>
            
            
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
            </tr>

        <?php
        $total_labeling_cost=0;
        $labeling_cost=0;
        $total_labeling_quantity=0;
        $labeling_quantity=0;

        $data['jobcard_result']=$this->job_card_model->jobcard_material_summary_new_from_reserved_quantity_menu('reserved_quantity_manu',$push_jobcards='',$this->session->userdata['logged_in']['company_id'],$jobcard_array,'article_no','LBL');
        if($data['jobcard_result']==TRUE){
            foreach($data['jobcard_result'] as $job_card_row){
                    
                    $article_desc="";
                    $calculated_purchase_price="";
                    $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$job_card_row->article_no);
                    foreach($data['article'] as $article_row){
                     $article_desc=$article_row->article_name;
                     $sub_group=$article_row->sub_group;
                     $main_group=$article_row->main_group;
                     $uom=$article_row->uom;
                    }

                    $labeling_cost=($job_card_row->total_demand_qty/$total_dispatchh)*$total_qty*$job_card_row->avg_rate;

                    $labeling_quantity=($job_card_row->total_demand_qty/$total_dispatchh)*$total_qty;

                    echo "<tr class='item'><td class='label' width='10%' >".strtoupper($main_group)."</td>
                    <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                    <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$article_desc."</td>
                    <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".round($labeling_quantity,2)." ".$uom."</td>
                    <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($job_card_row->avg_rate,2)." / ".$uom."</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($labeling_cost,2)."</td>
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
                <td style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($total_labeling_cost/$total_qty,2)."</td>
            </tr>";
        }
        ?>
    </table>
    <br/>

        <table cellpadding='5' cellspacing='0' style='border:1px solid #D9d9d9;'>
            <tr class="heading">
                <td colspan="8" style='border-bottom:1px solid #D9d9d9;'><b>FOILING PROCESS</td>
            </tr>
            <tr class="heading item">
                <td width="10%" ><b>GROUP</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b>MATERIAL</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b>QUANTITY</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>PRICE</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>TOTAL COST</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>COST/TUBE</td>
            </tr>
        <?php
        $total_foiling_cost=0;
        $foiling_cost=0;
        $total_foiling_quantity=0;
        $foiling_quantity=0;

        $push_jobcards=array('completed_flag'=>'1','work_proc_no'=>'6');
            $this->load->model('job_card_model');
            $data['jobcard_result']=$this->job_card_model->jobcard_material_summary_new('material_manufacturing',$push_jobcards,$this->session->userdata['logged_in']['company_id'],$jobcard_array);
            if($data['jobcard_result']==TRUE){

                foreach($data['jobcard_result'] as $job_card_row){
                    $article_desc="";
                    $calculated_purchase_price="";
                    $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$job_card_row->article_no);
                    foreach($data['article'] as $article_row){
                     $article_desc=$article_row->article_name;
                     $sub_group=$article_row->sub_group;
                     $main_group=$article_row->main_group;
                     $uom=$article_row->uom;
                    }

                    $foiling_cost=($job_card_row->total_demand_qty/$total_dispatchh)*$total_qty*$job_card_row->avg_rate;

                    $foiling_quantity=($job_card_row->total_demand_qty/$total_dispatchh)*$total_qty;

                    echo "<tr class='item'><td class='label' width='10%' >".strtoupper($main_group)."</td>
                    <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                    <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$article_desc."</td>
                    <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".round($foiling_quantity,2)." ".$uom."</td>
                    <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($job_card_row->avg_rate,2)." / ".$uom."</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($foiling_cost,2)."</td>
                    </tr>";

                    $total_foiling_cost+=$foiling_cost;
                    $total_foiling_quantity+=$foiling_quantity;

                }

            echo "<tr class='heading'>
                    <td><b>TOTAL</td>
                    <td></td>
                    <td style='border-right:1px solid #D9d9d9;'></td>
                    <td style='border-right:1px solid #D9d9d9;text-align:right'>".round($total_foiling_quantity,2)."</td>
                    <td style='border-right:1px solid #D9d9d9;'></td>
                    <td style='border-right:1px solid #D9d9d9;text-align:right'><b>&#8377; ".round($total_foiling_cost,2)."</b></td>
                    <td style='text-align:right'>&#8377; ".round($total_foiling_cost/$total_qty,2)."</td>
                </tr>";
            }
        ?>
        </table>
        <br/>

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
                
            </tr>
            <?php
            $total_shoulderfoil_cost=0;
            $total_shoulderfoil_quantity=0;
            $shouldefoil_quantity=0;
            $shouldefoil_cost=0;

            $push_jobcards=array('completed_flag'=>'1','work_proc_no'=>'7');
            $this->load->model('job_card_model');
            $data['jobcard_result']=$this->job_card_model->jobcard_material_summary_new('material_manufacturing',$push_jobcards,$this->session->userdata['logged_in']['company_id'],$jobcard_array);
            if($data['jobcard_result']==TRUE){

                foreach($data['jobcard_result'] as $job_card_row){

                    $article_desc="";
                    $calculated_purchase_price="";
                    $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$job_card_row->article_no);
                    foreach($data['article'] as $article_row){
                     $article_desc=$article_row->article_name;
                     $sub_group=$article_row->sub_group;
                     $main_group=$article_row->main_group;
                     $uom=$article_row->uom;
                    }



                    $shouldefoil_cost=($job_card_row->total_demand_qty/$total_dispatchh)*$total_qty*$job_card_row->avg_rate;

                    $shouldefoil_quantity=($job_card_row->total_demand_qty/$total_dispatchh)*$total_qty;

                    echo "<tr class='item'><td class='label' width='10%' >".strtoupper($main_group)."</td>
                    <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                    <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$article_desc."</td>
                    <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".round($shouldefoil_quantity,2)." ".$uom."</td>
                    <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($job_card_row->avg_rate,2)." / ".$uom."</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($shouldefoil_cost,2)."</td>
                    </tr>";

                    $total_shoulderfoil_cost+=$foiling_cost;
                    $total_shoulderfoil_quantity+=$foiling_quantity;

                }


                    echo "<tr class='heading'>
                            <td><b>TOTAL</td>
                            <td></td>
                            <td style='border-right:1px solid #D9d9d9;'></td>
                            <td style='border-right:1px solid #D9d9d9;text-align:right'>".round($total_shoulderfoil_quantity,2)."</td>
                            <td style='border-right:1px solid #D9d9d9;'></td>
                            <td style='border-right:1px solid #D9d9d9;text-align:right'><b>&#8377; ".round($total_shoulderfoil_cost,2)."</b></td>
                            <td style='text-align:right'>&#8377; ".round($total_shoulderfoil_cost/$total_qty,2)."</td>
                        </tr>";
            }
            ?>
        </table>
        <br/>
        <table cellpadding='5' cellspacing='0' style='border:1px solid #D9d9d9;'>
            <tr class="heading">
                <td colspan="8" style='border-bottom:1px solid #D9d9d9;'><b>CAPPING MATERIAL</b></td>
            </tr>
            <tr class="heading item">
                <td width="10%" ><b>GROUP</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b>MATERIAL</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b>QUANTITY</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>PRICE</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>TOTAL COST</td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>COST/TUBE</td>
                
            </tr>

            <?php

            $total_capping_s_cost=0;
            $capping_s_cost=0;
            $total_capping_s_quantity=0;
            $capping_s_quantity=0;

            $data['jobcard_result']=$this->job_card_model->jobcard_material_summary_new_from_reserved_quantity_menu('reserved_quantity_manu',$push_jobcards='',$this->session->userdata['logged_in']['company_id'],$jobcard_array,'article_no','RM-CAS'); 

            if($data['jobcard_result']==TRUE){
                foreach($data['jobcard_result'] as $job_card_row){
                    $article_desc="";
                    $calculated_purchase_price="";
                    $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$job_card_row->article_no);
                    foreach($data['article'] as $article_row){
                         $article_desc=$article_row->article_name;
                         $sub_group=$article_row->sub_group;
                         $main_group=$article_row->main_group;
                         $uom=$article_row->uom;
                    }

                    $capping_s_cost=($job_card_row->total_demand_qty/$total_dispatchh)*$total_qty*$job_card_row->avg_rate;

                    $capping_s_quantity=($job_card_row->total_demand_qty/$total_dispatchh)*$total_qty;

                    echo "<tr class='item'><td class='label' width='10%' >".strtoupper($main_group)."</td>
                    <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                    <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$article_desc."</td>
                    <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".round($capping_s_quantity,2)." ".$uom."</td>
                    <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($job_card_row->avg_rate,2)." / ".$uom."</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($capping_s_cost,2)."</td>
                    </tr>";

                $total_capping_s_cost+=$capping_s_cost;
                $total_capping_s_quantity+=$capping_s_quantity;
                }

            }

            $total_capping_cost=0;
            $capping_cost=0;
            $total_capping_quantity=0;
            $capping_quantity=0;
            if($cap_metalization!=''){
                $data['jobcard_result']=$this->job_card_model->jobcard_material_summary_new_from_reserved_quantity_menu('reserved_quantity_manu',$push_jobcards='',$this->session->userdata['logged_in']['company_id'],$jobcard_array,'article_no','CAME-');
            }else{
                $data['jobcard_result']=$this->job_card_model->jobcard_material_summary_new_from_reserved_quantity_menu('reserved_quantity_manu',$push_jobcards='',$this->session->userdata['logged_in']['company_id'],$jobcard_array,'article_no','CAPS-000');   
            }
            if($data['jobcard_result']==TRUE){
                foreach($data['jobcard_result'] as $job_card_row){
                    $article_desc="";
                    $calculated_purchase_price="";
                    $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$job_card_row->article_no);
                    foreach($data['article'] as $article_row){
                     $article_desc=$article_row->article_name;
                     $sub_group=$article_row->sub_group;
                     $main_group=$article_row->main_group;
                     $uom=$article_row->uom;
                    }

                    $capping_cost=($job_card_row->total_demand_qty/$total_dispatchh)*$total_qty*$job_card_row->avg_rate;

                    $capping_quantity=($job_card_row->total_demand_qty/$total_dispatchh)*$total_qty;

                    echo "<tr class='item'><td class='label' width='10%' >".strtoupper($main_group)."</td>
                    <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                    <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$article_desc."</td>
                    <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".round($capping_quantity,2)." ".$uom."</td>
                    <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($job_card_row->avg_rate,2)." / ".$uom."</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($capping_cost,2)."</td>
                    </tr>";

                    $total_capping_cost+=$capping_cost;
                    $total_capping_quantity+=$capping_quantity;
                }
            }


                echo "<tr class='heading'>
                <td><b>TOTAL</td>
                <td></td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'><b>&#8377; ".round($total_capping_cost+$total_capping_s_cost,2)."</b></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round( ($total_capping_cost+$total_capping_s_cost)/$total_qty,2)."</td>
                </tr>";
            ?>
        </table>

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
            </tr>
            <?php
            $total_packing_cost=0;
            $packing_quantity=0;
            $packing_cost=0;
            $total_packing_quantity=0;

            $push_jobcards=array('completed_flag'=>'1','work_proc_no'=>'10','from_job_card'=>'1');
            $this->load->model('job_card_model');
            $data['jobcard_result']=$this->job_card_model->jobcard_material_summary_new('material_manufacturing',$push_jobcards,$this->session->userdata['logged_in']['company_id'],$jobcard_array);
            if($data['jobcard_result']==TRUE){
                foreach($data['jobcard_result'] as $job_card_row){

                    $article_desc="";
                    $calculated_purchase_price="";
                    $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$job_card_row->article_no);
                    foreach($data['article'] as $article_row){
                     $article_desc=$article_row->article_name;
                     $sub_group=$article_row->sub_group;
                     $main_group=$article_row->main_group;
                     $uom=$article_row->uom;
                    }

                    $packing_cost=($job_card_row->total_demand_qty/$total_dispatchh)*$total_qty*$job_card_row->avg_rate;

                    $packing_quantity=($job_card_row->total_demand_qty/$total_dispatchh)*$total_qty;

                    echo "<tr class='item'><td class='label' width='10%' >".strtoupper($main_group)."</td>
                    <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                    <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$article_desc."</td>
                    <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".round($packing_quantity,2)." ".$uom."</td>
                    <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($job_card_row->avg_rate,2)." / ".$uom."</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($packing_cost,2)."</td>
                    </tr>";

                    $total_packing_cost+=$packing_cost;
                    $total_packing_quantity+=$packing_quantity;
                    
                }
            }

            $total_other_packing_cost=0;
            if($packing_type==1){

                $packing_data=array('for_export'=>'1');

                $result_other_packing=$this->costsheet_model->get_packing_cost('packing_material_consumption_master',$this->session->userdata['logged_in']['company_id'],$packing_data="",$from_date,$to_date);
            }else{
                $packing_data=array('for_export'=>'0');
                $result_other_packing=$this->costsheet_model->get_packing_cost('packing_material_consumption_master',$this->session->userdata['logged_in']['company_id'],$packing_data,$from_date,$to_date);
            }

            if($result_other_packing==TRUE){
                foreach($result_other_packing as $result_other_packing_row){
                    $other_packing=$result_other_packing_row->avg_cost_per_tube*$total_qty;

                    echo "<tr class='item'><td class='label' width='10%'></td>
                        <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                        <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$result_other_packing_row->packing_material."</td>
                        <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'></td>
                        <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'></td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($other_packing,2)."</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($result_other_packing_row->avg_cost_per_tube,3)."</td>
                    </tr>";
                    $total_other_packing_cost+=$other_packing;
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
                <td style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($total_total_packing_cost/$total_qty,2)."</td>
                
            </tr>";
            }

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
            </tr>
            <?php
            $total_stores_spares_cost=0;

            $result_stores_spares=$this->costsheet_model->get_stores_and_sapres_cost('stores_and_spares_consumption_master',$this->session->userdata['logged_in']['company_id'],$data="",$from_date,$to_date);

            if($result_stores_spares==TRUE){
            foreach($result_stores_spares as $stores_spares_row){

                $stores_spares_cost=$stores_spares_row->avg_cost_per_tube*$total_qty;

                echo "<tr class='item'><td class='label' width='10%' >SPARES</td>
                        <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                        <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$stores_spares_row->stores_and_spares."</td>
                        <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&nbsp;</td>
                        <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&nbsp;</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($stores_spares_cost,2)."</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($stores_spares_row->avg_cost_per_tube,2)."</td>
                    </tr>";
                    $total_stores_spares_cost+=$stores_spares_cost;
                }
                echo "<tr class='heading'>
                <td><b>TOTAL</td>
                <td></td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'><b>&#8377; ".round($total_stores_spares_cost,2)."</b></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($total_stores_spares_cost/$total_qty,2)."</td></tr>";
                }

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
            </tr>
            <?php
            $total_additional_cost=0;
            $additional_cost=0;
            $total_additional_quantity=0;
            $additional_quantity=0;

            $push_jobcards=array('completed_flag'=>'1','from_job_card'=>'0');
            $not_in=array('5','11');
            $this->load->model('job_card_model');
            $data['jobcard_result']=$this->job_card_model->jobcard_additional_material_summary('material_manufacturing',$push_jobcards,$this->session->userdata['logged_in']['company_id'],$jobcard_array,$not_in);
            if($data['jobcard_result']==TRUE){
                foreach($data['jobcard_result'] as $job_card_row){

                    $article_desc="";
                    $calculated_purchase_price="";
                    $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$job_card_row->article_no);
                    foreach($data['article'] as $article_row){
                     $article_desc=$article_row->article_name;
                     $sub_group=$article_row->sub_group;
                     $main_group=$article_row->main_group;
                     $uom=$article_row->uom;
                    }



                    $additional_cost=($job_card_row->total_demand_qty/$total_dispatchh)*$total_qty*$job_card_row->avg_rate;

                    $additional_quantity=($job_card_row->total_demand_qty/$total_dispatchh)*$total_qty;

                    echo "<tr class='item'><td class='label' width='10%' >".strtoupper($main_group)."</td>
                    <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                    <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'>".$article_desc."</td>
                    <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".round($additional_quantity,2)." ".$uom."</td>
                    <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($job_card_row->avg_rate,2)." / ".$uom."</td>
                    <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($additional_cost,2)."</td>
                    </tr>";


                    $total_additional_cost+=$additional_cost;
                    $total_additional_quantity+=$additional_quantity;

                }

                echo "<tr class='heading'>
                <td><b>TOTAL</td>
                <td></td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'>".round($total_additional_quantity,2)."</td>
                <td style='border-right:1px solid #D9d9d9;'></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'><b>&#8377; ".round($total_additional_cost,2)."</b></td>
                <td style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($total_additional_cost/$total_qty,2)."</td>
                </tr>";
            }
            ?>
        </table>

        <br/>
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
            </tr>
            <?php
            $total_freight=0;
            $total_freight_amount=0;
            $result_freight_value=$this->costsheet_model->get_freight_cost('freight_master',$data=array('customer_no'=>$customer_no,'sleeve_id'=>$dia),$this->session->userdata['logged_in']['company_id'],$from_date,$to_date);

            //echo $this->db->last_query();

            if($result_freight_value==TRUE){
            foreach($result_freight_value as $result_freight_value_row){
                $total_freight=$result_freight_value_row->avg_cost_per_tube*$total_qty;

                echo "<tr class='item'><td class='label' width='10%' >FREIGHT</td>
                        <td class='label' width='5%' style='border-right:1px solid #D9d9d9;'></td>
                        <td class='label' width='35%' style='border-right:1px solid #D9d9d9;'></td>
                        <td class='label' width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>".$total_qty." NOS</td>
                        <td width='5%' style='border-right:1px solid #D9d9d9;text-align:right'></td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($total_freight,2)."</td>
                        <td width='10%' style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; ".round($result_freight_value_row->avg_cost_per_tube,2)."</td>
                    </tr>";
                    $total_freight_amount+=$total_freight;
                }
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
            </tr>

            <tr class="item">
                <td width="10%">SLEEVE</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b></td>
                <td width="5%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_extrusion_cost,2);?></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_extrusion_cost/$total_qty,2);?></td>
            </tr>
            <tr class="item">
                <td width="10%" >PURGING</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b></td>
                <td width="5%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_purging_cost,2);?></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_purging_cost/$total_qty,2);?></td>
                
            </tr>
            <tr class="item">
                <td width="10%" >SHOULDER</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b></td>
                <td width="5%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_heading_cost,2)?></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_heading_cost/$total_qty,2);?></td>
                
            </tr>

            <tr class="item">
                <td width="10%" >PRINTING</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b></td>
                <td width="5%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_total_printing_cost,2)?></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_total_printing_cost/$total_qty,2);?></td>
                
            </tr>

            <tr class="item">
                <td width="10%" >PRINTING CONSUMABLE</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b></td>
                <td width="5%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
                
            </tr>

            <tr class="item">
                <td width="10%" >LABEL</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b></td>
                <td width="5%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><?php echo round($total_labeling_cost,2)?></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><?php echo round($total_labeling_cost/$total_qty,2);?></td>
               
            </tr>

            <tr class="item">
                <td width="10%" >FOIL</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b></td>
                <td width="5%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_foiling_cost,2)?></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_foiling_cost/$total_qty,2);?></td>
                
            </tr>

            <tr class="item">
                <td width="10%" >SHOULDER FOIL</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b></td>
                <td width="5%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_shoulderfoil_cost,2)?></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_shoulderfoil_cost/$total_qty,2);?></td>
            </tr>

            <tr class="item">
                <td width="10%" >CAPPING</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b></td>
                <td width="5%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><?php echo round($total_capping_cost+$total_capping_s_cost,2)?></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><?php echo round(($total_capping_cost+$total_capping_s_cost)/$total_qty,2);?></td>
            </tr>

            <tr class="item">
                <td width="10%" >PACKING</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b></td>
                <td width="5%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_total_packing_cost,2)?></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_total_packing_cost/$total_qty,2);?></td>
                
            </tr>

            <tr class="item">
                <td width="10%" >STORES & SPARES</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b></td>
                <td width="5%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_stores_spares_cost,2)?></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_stores_spares_cost/$total_qty,2);?></td>
               
            </tr>

            <tr class="item">
                <td width="10%" >ADDITIONAL MATERIAL</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b></td>
                <td width="5%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_additional_cost,2)?></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_additional_cost/$total_qty,2);?></td>
                
            </tr>

            <tr class="item">
                <td width="10%" >FREIGHT</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b></td>
                <td width="5%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_freight_amount,2);?></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_freight_amount/$total_qty,2);?></td>
                
            </tr>
            <?php 
                $total_consumable=0;
                $total_capping_m_cost=0;
                $total_final_cost=$total_extrusion_cost+$total_purging_cost+$total_heading_cost+$total_total_printing_cost+$total_consumable+$total_labeling_cost+$total_foiling_cost+$total_shoulderfoil_cost+$total_capping_cost+$total_capping_s_cost+$total_capping_m_cost+$total_total_packing_cost+$total_stores_spares_cost+$total_additional_cost+$total_freight_amount;
            ?>

            <tr class="item heading">
                <td width="10%" >TOTAL COST</td>
                <td width="60%" colspan="4" style="border-right:1px solid #D9d9d9;"></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_final_cost,2)?></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'>&#8377; <?php echo round($total_final_cost/$total_qty,2);?></td>
               
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
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><?php echo number_format($sales_rate*$total_qty);?></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><?php echo round($sales_rate,2);?></td>
                
            </tr>

            <tr class="item heading">
                <td width="10%" >TOTAL COST</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b></td>
                <td width="5%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><?php echo round($total_final_cost,2)?></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><?php echo round($total_final_cost/$total_qty,2);?></td>
                
            </tr>
            <?php $contribution=0;
            $contribution=$sales_rate*$total_qty-$total_final_cost;
            $contribution_cost_per_tube=$sales_rate-round($total_final_cost/$total_qty,2);
            ?>
            <tr class="item heading">
                <td width="10%" >CONTRIBUTION EXCLUDING PRINTING CONSUMABLES
                </td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b></td>
                <td width="5%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><?php echo round($contribution,2);?></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><?php echo round($contribution_cost_per_tube,2);?></td>
                
            </tr>

            <tr class="item heading">
                <td width="10%" >CON %</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><b></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><b></td>
                <td width="5%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'></td>
                <td width="10%" style='border-right:1px solid #D9d9d9;text-align:right'><?php echo round(($contribution_cost_per_tube/$sales_rate)*100);?>%</td>
                
            </tr>
        </table>    
   


