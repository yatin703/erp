

<?php foreach ($springtube_printing_inspection_master as $master_row):?>
   
      
    <div class="ui teal labels" style="text-align: center;">
      <div class="ui label">
        PRINTING INSPECTION SHIFT REPORT
      </div>
    </div>

        <!-- <?php echo $master_row->final_approval_flag==1 ? '<span class="ui green right ribbon label"><i class="check circle icon"></i> Approved</span>' : '<span class="ui red right ribbon label">Unapproved</span>';?> -->

        <br/>

        <?php echo $this->common_model->view_date($master_row->production_date,$this->session->userdata['logged_in']['company_id'])!='' ? '<span class="ui blue left ribbon label"><i class="calendar alternate outline icon"></i>'.$this->common_model->view_date($master_row->production_date,$this->session->userdata['logged_in']['company_id']).'</span>' : '';?>
        <br/>
        <br/>

        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            
            <tr class="heading" style="border-right:1px solid #D9d9d9;" >
                <td width="10%"> <i class="cogs icon"></i> PROCESS</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><?php echo 'SPRINGTUBE PRINTING INSPECTION';?></td>
                <td width="15%"><i class="user secret icon"></i> QC INCHARGE</td>                
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="30%"><?php echo $master_row->qc_incharge ;?></td>
                
                
                
            </tr>
        
            <tr class="item">
                <td><i class="bars icon"></i> <b>MACHINE</b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->machine_name ;?></td>
                <td><i class="paypal icon"></i><b>SHIFT PROBLEMS</b></td>                
                <td style="border-right:1px solid #D9d9d9;"></td> 
                <td><div class="ui red label"><?php echo $master_row->shift_issues ;?></div></td>
            </tr>
            <tr class="item">
                <td> <i class="user icon"></i> <b>OPERATOR</b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->login_name ;?></td>              
                <td> <i class="sticky note icon"></i><b>REMARKS</b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td><?php echo $master_row->remarks;?></td>
            </tr>

            <tr class="item last">
                <td> <i class="stop watch icon"></i> <b>SHIFT</b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">
                <?php
                    echo $master_row->shift;

                    // if(substr($master_row->production_time,0,2)>='08' && substr($master_row->production_time,0,2)<'16' ) {
                    //     echo 'I SHIFT' ;
                    // }
                    // elseif(substr($master_row->production_time,0,2)>='16' && substr($master_row->production_time,0,2)<'12' ) {
                    //     echo 'II SHIFT' ;
                    // }
                    // elseif(substr($master_row->production_time,0,2)>='12' && substr($master_row->production_time,0,2)<'08' ) {
                    //     echo 'III SHIFT' ;
                    // }else{
                    //     echo'';
                    // }
                

                ?></td>              
                <td> <i class="stop watch icon"></i><b>TIME</b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><?php
                    echo $master_row->production_time;?></td>
               
            </tr>


        </table>


        
        <br/>                     
        <br/>
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            
            <tr class="heading" style="border-right:1px solid #D9d9d9;" >
                <td width="2%" style="border-right:1px solid #D9d9d9;">SR NO</td>
                <td width="1%"></td>
                <td width="7%" style="border-right:1px solid #D9d9d9;"><b>CUSTOMER</b></td>
                <td width="6%" style="border-right:1px solid #D9d9d9;"><b>ORDER</b></td>
                <td width="6%" style="border-right:1px solid #D9d9d9;"><b>PRODUCT</b></td>
                <td width="7%" style="border-right:1px solid #D9d9d9;"><b>JOBCARD</b></td>
                <td width="7%" style="border-right:1px solid #D9d9d9;"><b>DIA X LENGTH</b></td>
                <td width="7%" style="border-right:1px solid #D9d9d9;"><b>MB</b></td>
                <td width="3%" style="border-right:1px solid #D9d9d9;"><b>PRINTING OUTPUT (QTY)</b></td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"><b>INSPECTED OUTPUT (QTY)</b></td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"><b>SIDE TRIM WASTE (KG)</b></td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"><b>INSPECTION STATUS</b></td>           
                 
               
            </tr>
            <?php
            $i=1;
            $sum_inspection_input_qty=0;
            $sum_inspected_output_meters=0;
            $sum_inspected_output_qty=0;
            $sum_printing_output_qty=0;
            $sum_total_waste=0;
            $sum_side_trim_waste=0;
                
                foreach ($springtube_printing_inspection_details as  $details_row) {

                    $jobcard_qty=0;
                    $inspection_done='';
                    $production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no', $details_row->jobcard_no);

                    foreach($production_master_result as $production_master_row) {
                      $order_no=$production_master_row->sales_ord_no;
                      $article_no=$production_master_row->article_no;
                      $jobcard_qty=$this->common_model->read_number($production_master_row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']);
                      $inspection_done=$production_master_row->inspection_done;

                    }

                    $printing_output_qty=0;
                    $data_total_counter=array('jobcard_no'=>$details_row->jobcard_no);

                    $result_total_counter=$this->springtube_printing_production_model->select_total_counter('springtube_printing_production_master',$data_total_counter);
                    foreach ($result_total_counter as  $total_counter_row) {
                        $total_counter=$total_counter_row->total_counter;
                        $printing_output_qty=round($total_counter*2);
                    }

                    $sum_printing_output_qty+=$printing_output_qty;
                    $sum_inspection_input_qty+=$details_row->inspection_input_qty;
                    $sum_inspected_output_meters+=$details_row->inspected_output_meters;
                    $sum_inspected_output_qty+=$details_row->inspected_output_qty;
                    $sum_side_trim_waste+=$details_row->side_trim_waste;



                   // $sum_total_waste+=($details_row->inspection_input_qty-$details_row->inspected_output_qty);

                    

                    echo '<tr class="item">
                        <td style="border-right:1px solid #D9d9d9;">'.$i++.'</td>
                        <td></td>
                        <td style="border-right:1px solid #D9d9d9;">'.$this->common_model->get_customer_name($details_row->customer,$this->session->userdata['logged_in']['company_id']).'</td>
                        <td style="border-right:1px solid #D9d9d9;">'.$details_row->order_no.'</td>
                        <td style="border-right:1px solid #D9d9d9;">'.$this->common_model->get_article_name($details_row->article_no,$this->session->userdata['logged_in']['company_id']).'</td>
                        <td style="border-right:1px solid #D9d9d9;">'.$details_row->jobcard_no.'</td>
                        <td style="border-right:1px solid #D9d9d9;">'.$details_row->sleeve_dia.' X '.$details_row->sleeve_length.'</td>
                        <td style="border-right:1px solid #D9d9d9;">'.$this->common_model->get_article_name($details_row->second_layer_mb,$this->session->userdata['logged_in']['company_id']).'</td>
                        <!--<td style="border-right:1px solid #D9d9d9;">'.$details_row->inspection_input_qty.'</td>-->
                        <td style="border-right:1px solid #D9d9d9;">'.$printing_output_qty.'</td>
                         
                        <td style="border-right:1px solid #D9d9d9;">'.$details_row->inspected_output_qty.'</td>

                        <td style="border-right:1px solid #D9d9d9;">'.$details_row->side_trim_waste.'</td>
                        <td style="border-right:1px solid #D9d9d9;">'.($details_row->inspection_done=='1'? '<a href="#" style="color: #06c806;"><i class="check circle icon"></i>Done</a>':'').'</td>

                        <!--<td style="border-right:1px solid #D9d9d9;">'.($details_row->inspection_input_qty-$details_row->inspected_output_qty).'</td>
                        -->';
                }
                echo'</tr>
                <tr  class="item last" style="border-right:1px solid #D9d9d9;">
                <td colspan="8" style="border-right:1px solid #D9d9d9;"><b>TOTAL</b></td>
                <td style="border-right:1px solid #D9d9d9;"><b>'.$sum_printing_output_qty.'</b></td>                 
                <td style="border-right:1px solid #D9d9d9;"><b>'.$sum_inspected_output_qty.'</b></td>
                <td style="border-right:1px solid #D9d9d9;"><b>'.$sum_side_trim_waste.'</b></td>
                <td style="border-right:1px solid #D9d9d9;"><b></b></td>
                <!--<td style="border-right:1px solid #D9d9d9;"><b>'.$sum_total_waste.'</b></td>-->
				  


                </tr>';
        ?>    
        </table>

        <br/>
        <br/>
        
                
     <?php endforeach;?>
    </div>
</body>
</html>   
