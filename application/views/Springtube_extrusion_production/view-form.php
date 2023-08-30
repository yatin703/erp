<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

    $(document).ready(function(){

        $(".invoice-box").css("max-width", "1300px");
    });
 </script>   
<?php foreach ($springtube_extrusion_production_master as $master_row):?>
   
      
    <div class="ui teal labels" style="text-align: center;">
      <div class="ui label">
        SHIFT REPORT
      </div>
    </div>

        <!-- <?php echo $master_row->final_approval_flag==1 ? '<span class="ui green right ribbon label"><i class="check circle icon"></i> Approved</span>' : '<span class="ui red right ribbon label">Unapproved</span>';?> -->

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
                <!-- <td width="15%"><i class="user secret icon"></i> QC INCHARGE</td>                
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="30%"><?php echo $master_row->qc_incharge ;?></td>                -->
                
                
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
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            
            <tr class="heading" style="border-right:1px solid #D9d9d9;" >
                <td width="2%" style="border-right:1px solid #D9d9d9;">SR NO</td>
                <td width="1%"></td>
                <td width="7%" style="border-right:1px solid #D9d9d9;"><b>CUSTOMER</b></td>
                <td width="6%" style="border-right:1px solid #D9d9d9;"><b>ORDER</b></td>
                 <td width="6%" style="border-right:1px solid #D9d9d9;"><b>ARTICLE NO</b></td>
                <td width="7%" style="border-right:1px solid #D9d9d9;"><b>JOBCARD</b></td>
                <td width="7%" style="border-right:1px solid #D9d9d9;"><b>DIA X LENGTH</b></td>
                <td width="7%" style="border-right:1px solid #D9d9d9;"><b>COLOR</b></td> 
                <td width="1%" style="border-right:1px solid #D9d9d9;"><b>TOTAL PRODUCTION (METERS)</b></td>
                <td width="3%" style="border-right:1px solid #D9d9d9;"><b>JOB WEIGHT (KG)</b></td> <td width="3%" style="border-right:1px solid #D9d9d9;"><b>TRIM WASTE (KG)</b></td>
                <td width="2%" style="border-right:1px solid #D9d9d9;"><b>QC CHECK</b></td>
                <td width="3%" style="border-right:1px solid #D9d9d9;"><b>QC HOLD (MTRS)</b></td><td width="3%" style="border-right:1px solid #D9d9d9;"><b>OK PRODUCTION (MTRS)</b></td> 
                <td width="7%" style="border-right:1px solid #D9d9d9;"><b>PURGING JOBCARD</b></td>
                <td width="7%" style="border-right:1px solid #D9d9d9;"><b>PURGING WEIGHT (KG)</b></td>
                <td width="7%" style="border-right:1px solid #D9d9d9;"><b>PURGING REASON</b></td>

                <td width="7%" style="border-right:1px solid #D9d9d9;"><b>SETUP JOBCARD</b></td>
                <td width="7%" style="border-right:1px solid #D9d9d9;"><b>SETUP WEIGHT (KG)</b></td>
                <td width="7%" style="border-right:1px solid #D9d9d9;"><b>SETUP REASON</b></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"><b>QC REMARKS</b></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"><b>QC CONTROL PLAN</b></td>
               
            </tr>
            <?php
            $i=1;
            $sum_total_ok_meters=0;
            $sum_total_qc_hold_meters=0;
            $sum_total_meters_produced=0;
            $sum_total_job_weight=0;
            $sum_total_waste=0;

            $sum_total_setup_meters=0;
            $sum_total_setup_weight=0;
            $sum_total_purging_weight=0;
                
                foreach ($springtube_extrusion_production_details as  $details_row) {

                    //$sum_total_ok_meters+=$details_row->total_ok_meters;
                    //$sum_total_qc_hold_meters+=$details_row->total_qc_hold_meters;
                    $sum_total_meters_produced+=$details_row->total_meters_produced;
                    $sum_total_job_weight+=$details_row->total_job_weight;
                    $sum_total_waste+=$details_row->total_waste;

                    $sum_total_setup_meters+=$details_row->total_setup_meters;
                    $sum_total_setup_weight+=$details_row->total_setup_weight;
                    $sum_total_purging_weight+=$details_row->total_purging_weight;

                    $total_ok_meters=0;
                    $ok_from_production=0;
                    $ok_from_qc=0;
                    $data_ok_meters=array('details_id'=>$details_row->details_id,'from_process'=>1,'archive'=>0);
                    $springtube_extrusion_wip_master_result=$this->common_model->select_active_records_where('springtube_extrusion_wip_master',$this->session->userdata['logged_in']['company_id'],$data_ok_meters);

                    foreach ($springtube_extrusion_wip_master_result as $springtube_extrusion_wip_master_row) {
                        $ok_from_production=$springtube_extrusion_wip_master_row->total_ok_meters;
                    }

                    $data_qc_ok_meters=array('details_id'=>$details_row->details_id,'from_process'=>7,'archive'=>0);
                    $springtube_extrusion_wip_master_result_1=$this->common_model->select_active_records_where('springtube_extrusion_wip_master',$this->session->userdata['logged_in']['company_id'],$data_qc_ok_meters);

                    foreach ($springtube_extrusion_wip_master_result_1 as $springtube_extrusion_wip_master_row_1) {
                        $ok_from_qc=$springtube_extrusion_wip_master_row_1->total_ok_meters;
                    }

                    $total_ok_meters=$ok_from_production+$ok_from_qc;
                    $sum_total_ok_meters+=$total_ok_meters;

                    echo '<tr class="item">
                        <td style="border-right:1px solid #D9d9d9;">'.$i++.'</td>
                        <td></td>
                        <td style="border-right:1px solid #D9d9d9;">'.$this->common_model->get_customer_name($details_row->customer,$this->session->userdata['logged_in']['company_id']).'</td>
                        <td style="border-right:1px solid #D9d9d9;">'.$details_row->order_no.'</td>
                        <td style="border-right:1px solid #D9d9d9;">'.$details_row->article_no.'</td>
                        <td style="border-right:1px solid #D9d9d9;">'.$details_row->jobcard_no.'</td>
                        <td style="border-right:1px solid #D9d9d9;">'.$details_row->sleeve_dia.' X '.$details_row->sleeve_length.'</td>
                        <td style="border-right:1px solid #D9d9d9;">'.$this->common_model->get_article_name($details_row->second_layer_mb,$this->session->userdata['logged_in']['company_id']).'</td>
                        
                        <td style="border-right:1px solid #D9d9d9;">'.$details_row->total_meters_produced.'</td>
                        <td style="border-right:1px solid #D9d9d9;">'.$details_row->total_job_weight.'</td> 
                        <td style="border-right:1px solid #D9d9d9;">'.$details_row->total_waste.'</td>
                        <td style="border-right:1px solid #D9d9d9;">'.($details_row->qc_check==1? '<i style="color:#06c806;" class="check circle icon"></i>':'<i style="color: #f10606;"><b>Qc Pending</b></i>').'</td>
                        <td style="border-right:1px solid #D9d9d9;">';

                        $qc_hold_meters=0;
                        $data_qc_hold=array('details_id'=>$details_row->details_id,'status'=>0,'archive'=>0);
                        $springtube_extrusion_qc_master_hold=$this->common_model->select_active_records_where('springtube_extrusion_qc_master',$this->session->userdata['logged_in']['company_id'],$data_qc_hold);

                        foreach ($springtube_extrusion_qc_master_hold as $springtube_extrusion_qc_master_hold_row) {
                            $qc_hold_meters=$springtube_extrusion_qc_master_hold_row->total_qc_hold_meters;
                        }

                        $sum_total_qc_hold_meters+=$qc_hold_meters;

                        echo($qc_hold_meters!=0?$qc_hold_meters." MTRS":"");
                        echo'</td>
                        <td style="border-right:1px solid #D9d9d9;">'.$total_ok_meters.'</td> 
                        
                        <td style="border-right:1px solid #D9d9d9;">'.$details_row->purging_jobcard.'</td>
                        <td style="border-right:1px solid #D9d9d9;">'.$details_row->total_purging_weight.'</td>
                        <td style="border-right:1px solid #D9d9d9;">';
                        $purging_reason_result=$this->common_model->select_one_active_record('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],'shift_issue_id', $details_row->purging_reason);
              
                            foreach($purging_reason_result as $purging_reason_row) {
                              echo $purging_reason_row->shift_issue;
                            }
                        echo'</td>
                        <td style="border-right:1px solid #D9d9d9;">'.$details_row->setup_jobcard_no.'</td>
                        <td style="border-right:1px solid #D9d9d9;">'.$details_row->total_setup_weight.'</td>
                        <td style="border-right:1px solid #D9d9d9;">';
                        $setup_reason_result=$this->common_model->select_one_active_record('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],'shift_issue_id', $details_row->setup_reason);
              
                            foreach($setup_reason_result as $setup_reason_row) {
                              echo $setup_reason_row->shift_issue;
                            }
                        echo'</td>                        
                        <td style="border-right:1px solid #D9d9d9;">'.$details_row->qc_remarks.'</td> 
                        <td style="border-right:1px solid #D9d9d9;">';

                            $springtube_extrusion_control_plan_qc_result=$this->common_model->select_one_active_record('springtube_extrusion_control_plan_qc',$this->session->userdata['logged_in']['company_id'],'jobcard_no',$details_row->jobcard_no);

                            foreach ($springtube_extrusion_control_plan_qc_result as $springtube_extrusion_control_plan_qc_row) {

                                echo '<a href="'.base_url('index.php/springtube_extrusion_control_plan_qc/view/'.$springtube_extrusion_control_plan_qc_row->cp_id.'').'" target="_blank" title="View"><i class="print icon"></i></a>';
                                echo '</br>';
                            }
                                        

                        echo'</td> 
                        ';
                }
                echo'</tr>
                <tr  class="item last" style="border-right:1px solid #D9d9d9;">
                <td colspan="7" ><b>TOTAL</b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><b>'.$sum_total_meters_produced.'</b></td>
                <td style="border-right:1px solid #D9d9d9;"><b>'.$sum_total_job_weight.'</b></td>
                <td style="border-right:1px solid #D9d9d9;"><b>'.$sum_total_waste.'</b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><b>'.$sum_total_ok_meters.'</b></td>
                <td style="border-right:1px solid #D9d9d9;"><b>'.$sum_total_qc_hold_meters.'</b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><b>'.$sum_total_purging_weight.'</b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><b></b></td>
                <td style="border-right:1px solid #D9d9d9;"><b>'.$sum_total_setup_weight.'</b></td>
                
                
                
                
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