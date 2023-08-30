<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

    $(document).ready(function(){

        $(".invoice-box").css("max-width", "1300px");
    });
 </script>

<?php foreach ($springtube_bodymaking_production_master as $master_row):?>
   
      
    <div class="ui teal labels" style="text-align: center;">
      <div class="ui label">
        SHIFT REPORT
      </div>
    </div>

        <?php echo $master_row->final_approval_flag==1 ? '<span class="ui green right ribbon label"><i class="check circle icon"></i> Approved</span>' : '<span class="ui red right ribbon label">Unapproved</span>';?>

        <br/>

        <?php echo $this->common_model->view_date($master_row->production_date,$this->session->userdata['logged_in']['company_id'])!='' ? '<span class="ui blue left ribbon label"><i class="calendar alternate outline icon"></i>'.$this->common_model->view_date($master_row->production_date,$this->session->userdata['logged_in']['company_id']).'</span>' : '';?>
        <br/>
        <br/>

        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            
            <tr class="heading" style="border-right:1px solid #D9d9d9;" >
                <td width="10%"> <i class="cogs icon"></i>MACHINE</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><?php echo $master_row->machine_name;?></td>
                <td width="15%"> <i class="stop watch icon"></i> <b>SHIFT</b></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="30%" style="border-right:1px solid #D9d9d9;">
                <?php
                    echo $master_row->shift;                       

                ?></td>
                 
            </tr>
            <tr class="item">
                <td> <i class="user icon"></i> <b>OPERATOR</b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->login_name ;?></td>              
                <td> <i class="sticky note icon"></i><b>QC INCHARGE</b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td><?php echo $master_row->qc_incharge;?></td>
            </tr>
        
            <tr class="item">
                <td><i class="bars icon"></i> <b>REMARKS</b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->remarks ;?></td>
                <td><i class="paypal icon"></i><b>SHIFT PROBLEMS</b></td>                
                <td style="border-right:1px solid #D9d9d9;"></td> 
                <td><div class="ui red label"><?php echo $master_row->shift_issues ;?></div></td>
            </tr>
          
           

        </table>


        
        <br/>                     
        <br/>
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9; text-align: left;">
            
            <tr class="heading" style="border-right:1px solid #D9d9d9;" >
                <td width="2%" style="border-right:1px solid #D9d9d9;">SR NO</td>
                <td width="1%"></td>
                <td width="10%" style="border-right:1px solid #D9d9d9;"><b>CUSTOMER</b></td>
                <td width="6%" style="border-right:1px solid #D9d9d9;"><b>ORDER</b></td>
                <td width="7%" style="border-right:1px solid #D9d9d9;"><b>DIA X LENGTH</b></td>
                <td width="7%" style="border-right:1px solid #D9d9d9;"><b>MB</b></td>
                <td width="7%" style="border-right:1px solid #D9d9d9;"><b>JOBCARD</b></td>
                <td width="7%" style="border-right:1px solid #D9d9d9;"><b>JOBCARD QTY</b></td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"><b>SLEEVE PRODUCTION</b></td>
                 <td width="1%" style="border-right:1px solid #D9d9d9;"><b>HEADING</b></td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"><b>CAPPINNG</b></td>
                <td width="2%" style="border-right:1px solid #D9d9d9;"><b>QC CHECK</b></td>
                <td width="3%" style="border-right:1px solid #D9d9d9;"><b>QC HOLD</b></td><td width="3%" style="border-right:1px solid #D9d9d9;"><b>OK PRODUCTION</b></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"><b>QC REMARKS</b></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"><b>QC CONTROL PLAN</b></td>
            </tr>
            <?php
            $i=1;
            $sum_total_sleeve_produced=0;
            $sum_sleeve_with_heading=0;
            $sum_sleeve_with_cap=0;
            $sum_qc_ok_qty=0;
            $sum_qc_hold_qty=0;
                
                foreach ($springtube_bodymaking_production_details as  $details_row) {

                    $sum_total_sleeve_produced+=$details_row->total_sleeve_produced;
                    $sum_sleeve_with_heading+=$details_row->sleeve_with_heading;
                    $sum_sleeve_with_cap+=$details_row->sleeve_with_cap;
                    $sum_qc_ok_qty+=$details_row->qc_ok_qty;
                    $sum_qc_hold_qty+=$details_row->qc_hold_qty;

                    $production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no', $details_row->jobcard_no);
                    $jobcard_qty=0;
                    foreach($production_master_result as $production_master_row) {
                      $order_no=$production_master_row->sales_ord_no;
                      $article_no=$production_master_row->article_no;
                      $jobcard_qty=$this->common_model->read_number($production_master_row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']);
                    }
                    

                    echo '<tr class="item">
                        <td style="border-right:1px solid #D9d9d9;">'.$i++.'</td>
                        <td></td>
                        <td style="border-right:1px solid #D9d9d9;">'.$this->common_model->get_customer_name($details_row->customer,$this->session->userdata['logged_in']['company_id']).'</td>
                        <td style="border-right:1px solid #D9d9d9;">'.$details_row->order_no.'</td>
                        
                        <td style="border-right:1px solid #D9d9d9;">'.$details_row->sleeve_dia.' X '.$details_row->sleeve_length.'</td>
                        <td style="border-right:1px solid #D9d9d9;">'.$this->common_model->get_article_name($details_row->second_layer_mb,$this->session->userdata['logged_in']['company_id']).'</td>
                        <td style="border-right:1px solid #D9d9d9;">'.$details_row->jobcard_no.'</td>
                        <td style="border-right:1px solid #D9d9d9;">'.number_format($jobcard_qty,0,'.',',').'</td>
                    
                        <td style="border-right:1px solid #D9d9d9;">'.number_format($details_row->total_sleeve_produced,0,'.',',').'</td> 
                        <td style="border-right:1px solid #D9d9d9;">'.number_format($details_row->sleeve_with_heading,0,'.',',').'</td>
                        <td style="border-right:1px solid #D9d9d9;">'.number_format($details_row->sleeve_with_cap,0,'.',',').'</td>
                         <td style="border-right:1px solid #D9d9d9;">'.($details_row->qc_check==1? '<i style="color:#06c806;" class="check circle icon"></i>':'<i style="color: #f10606;"><b>Qc Pending</b></i>').'</td>
                        <td style="border-right:1px solid #D9d9d9;">'.number_format($details_row->qc_hold_qty,0,'.',',').'</td> 
                        <td style="border-right:1px solid #D9d9d9;">'.number_format($details_row->qc_ok_qty,0,'.',',').'</td>               
                       
                        <td style="border-right:1px solid #D9d9d9;">'.$details_row->qc_remarks.'</td>
                        <td style="border-right:1px solid #D9d9d9;">';

                            $springtube_bodymaking_control_plan_qc_result=$this->common_model->select_one_active_record('springtube_bodymaking_control_plan_qc',$this->session->userdata['logged_in']['company_id'],'jobcard_no',$details_row->jobcard_no);

                            foreach ($springtube_bodymaking_control_plan_qc_result as $springtube_bodymaking_control_plan_qc_row) {

                                echo '<a href="'.base_url('index.php/springtube_bodymaking_control_plan_qc/view/'.$springtube_bodymaking_control_plan_qc_row->cp_id.'').'" target="_blank" title="View"><i class="print icon"></i></a>';
                                echo '</br>';
                            }
                                        

                        echo'</td> 
                        ';
                }
                echo'</tr>
                <tr  style="border-right:1px solid #D9d9d9;">
                <td colspan="8" style="border-right:1px solid #D9d9d9;"><b>TOTAL</b></td>
                <td style="border-right:1px solid #D9d9d9;"><b>'.number_format($sum_total_sleeve_produced,0,'.',',').'</b></td>
                <td style="border-right:1px solid #D9d9d9;"><b>'.number_format($sum_sleeve_with_heading,0,'.',',').'</b></td>
                <td style="border-right:1px solid #D9d9d9;"><b>'.number_format($sum_sleeve_with_cap,0,'.',',').'</b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                
                <td style="border-right:1px solid #D9d9d9;"><b>'.number_format($sum_qc_hold_qty,0,'.',',').'</b></td>
                 <td style="border-right:1px solid #D9d9d9;"><b>'.number_format($sum_qc_ok_qty,0,'.',',').'</b></td>
				 <td style="border-right:1px solid #D9d9d9;"></td>


                </tr>';
            ?>
        </table>
        <br/>
        <br/>
        
                
     <?php endforeach;?>
    </div>
</body>
</html>   