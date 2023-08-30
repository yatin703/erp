<style>
    .pding{padding: 2px !important;}
</style>
<?php foreach ($coex_extrusion_qc_control_plan as $row):?>
   
      
    <div class="ui teal labels" style="text-align: center;">
      <div class="ui label">
        CONTROL PLAN OF EXTRUSION 
      </div>
    </div>

        <?php echo $this->common_model->view_date($row->inspection_date,$this->session->userdata['logged_in']['company_id'])!='' ? '<span class="ui blue left ribbon label"><i class="calendar alternate outline icon"></i>'.$this->common_model->view_date($row->inspection_date,$this->session->userdata['logged_in']['company_id']).' '.$row->shift_name.'</span>' : '';
        ?>
        
        <br/>
        <br/>

        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">

            <tr class="heading" style="border-right:1px solid #D9d9d9;" >
                <td width="10%"> <i class="cogs icon"></i> PROCESS</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><?php echo 'COEX EXTRUSION';?></td>
                <td width="10%"> <i class="cogs icon"></i> MACHINE</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%"><?php echo $row->machine_name;?></td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td width="10%"> <i class="bars icon"></i>ORDER NO</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><?php echo $row->order_no;?></td>
                <td width="15%"><i class="stop watch icon"></i>JOB CARD</td>                
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="30%"><?php echo $row->jobcard_no ;?></td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td width="10%"> <i class="bars icon"></i>PRODUCT NO</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><?php echo $row->article_no;?></td>
                <td width="15%"><i class="stop watch icon"></i>PRODUCT NAME</td>                
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="30%"><?php echo $this->common_model->get_article_name($row->article_no,$this->session->userdata['logged_in']['company_id']) ;?></td>
            </tr>

        </table>
        <br/>
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            
            <tr class="heading" style="border-right:1px solid #D9d9d9;" >
                <td width="15%" >PARAMETER</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="23%" style="border-right:1px solid #D9d9d9;">DIMESNSION</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;">ACTUAL</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;">STATUS</td>
                
                <td width="35%" style="border-right:1px solid #D9d9d9;">LINE CLEARANCE (Y/N) </td><td width="15%">STATUS</td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td>STD DIAMETER</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><table style='border:1px solid #ddd'><tr>
                                    <td style="border-right:1px solid #D9d9d9;"><i>19MM</td>
                                    <td style="border-right:1px solid #D9d9d9;"><i>22MM</td>
                                    <td style="border-right:1px solid #D9d9d9;"><i>25MM</td>
                                    <td style="border-right:1px solid #D9d9d9;"><i>30MM</td>
                                    <td style="border-right:1px solid #D9d9d9;"><i>35MM</td>
                                    <td style="border-right:1px solid #D9d9d9;"><i>40MM</td>
                                    <td style="border-right:1px solid #D9d9d9;"><i>50MM</td>
                                </tr>
                                </table></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $row->std_dia_actual;?></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($row->std_dia_status==1 ? "PASS" : "FAIL");?></td>
                
                <td style="border-right:1px solid #D9d9d9;">MASTER FILE AND JOBCARD RETURN TO PRODUCTION DEPARTMENT</td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($row->masterfile_jobcard_return_status==1 ? "PASS" : "FAIL");?></td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td>OUTER DIAMETER(MM) +/- 0.2</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><table style='border:1px solid #ddd'><tr>
                                    <td style='border-right:1px solid #ddd'><i>19MM</td>
                                    <td style='border-right:1px solid #ddd'><i>22MM</td>
                                    <td style='border-right:1px solid #ddd'><i>25MM</td>
                                    <td style='border-right:1px solid #ddd'><i>30MM</td>
                                    <td style='border-right:1px solid #ddd'><i>35MM</td>
                                    <td style='border-right:1px solid #ddd'><i>40MM</td>
                                    <td><i>50MM</td>
                                </tr>
                                </table></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $row->outer_dia_actual;?></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($row->outer_dia_status==1 ? "PASS" : "FAIL");?></td>
                
                <td style="border-right:1px solid #D9d9d9;">REMANING RAW MATERIAL RETURED TO PRODUCTION AREA</td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($row->rm_return_status==1 ? "PASS" : "FAIL");?></td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td>INNER DIAMETER(MM) +/- 0.26</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><table style='border:1px solid #ddd'><tr>
                                    <td style='border-right:1px solid #ddd'><i>18.4MM</td>
                                    <td style='border-right:1px solid #ddd'><i>24.1MM</td>
                                    <td style='border-right:1px solid #ddd'><i>29.2MM</td>
                                    <td style='border-right:1px solid #ddd'><i>34MM</td>
                                    <td style='border-right:1px solid #ddd'><i>39MM</td>
                                    <td><i>49MM</td>
                                </tr>
                                </table></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $row->inner_dia_actual;?></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($row->inner_dia_status==1 ? "PASS" : "FAIL");?></td>
                
                <td style="border-right:1px solid #D9d9d9;">RED CRATE ON EVERY MACHINE FOR REJECTED MATERIAL</td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($row->red_create_status==1 ? "PASS" : "FAIL");?></td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td>TOTAL WALL THICKNESS (Micron) +/-15</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><table style='border:1px solid #ddd'><tr>
                                    <td style='border-right:1px solid #ddd'><i>400</td>
                                    <td style='border-right:1px solid #ddd'><i>400</td>
                                    <td style='border-right:1px solid #ddd'><i>500</td>
                                    <td style='border-right:1px solid #ddd'><i>500</td>
                                    <td style='border-right:1px solid #ddd'><i>500</td>
                                    <td style='border-right:1px solid #ddd'><i>500</td>
                                    <td><i>550</td>
                                </tr>
                                </table></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $row->total_thickness_actual;?></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($row->total_thickness_status==1 ? "PASS" : "FAIL");?></td>
                
                <td style="border-right:1px solid #D9d9d9;">CLEAR ALL REJECTED SLEEVES FROM THE REJECTION AREA</td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($row->rejected_sleeves_clear_status==1 ? "PASS" : "FAIL");?></td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td>STD Weight (Gm) +/- 0.2</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><table style='border:1px solid #ddd'><tr>
                                    <td style='border-right:1px solid #ddd'><i>1.5</td>
                                    <td style='border-right:1px solid #ddd'><i>2.2</td>
                                    <td style='border-right:1px solid #ddd'><i>3.5</td>
                                    <td style='border-right:1px solid #ddd'><i>3.7</td>
                                    <td style='border-right:1px solid #ddd'><i>5.3</td>
                                    <td style='border-right:1px solid #ddd'><i>7.5</td>
                                    <td><i>9.5</td>
                                </tr>
                                </table></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $row->std_weight_actual;?></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($row->std_weight_status==1 ? "PASS" : "FAIL");?></td>
                
                <td style="border-right:1px solid #D9d9d9;">NO LOOSE TOOLS</td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($row->no_loose_tools_status==1 ? "PASS" : "FAIL");?></td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td>STD Length (MM)</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><table style='border:1px solid #ddd'><tr>
                                    <td style='border-right:1px solid #ddd'><i>65</td>
                                    <td style='border-right:1px solid #ddd'><i>85</td>
                                    <td style='border-right:1px solid #ddd'><i>90</td>
                                    <td style='border-right:1px solid #ddd'><i>85</td>
                                    <td style='border-right:1px solid #ddd'><i>100</td>
                                    <td style='border-right:1px solid #ddd'><i>125</td>
                                    <td><i>115</td>
                                </tr>
                                </table></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $row->std_length_actual;?></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($row->std_length_status==1 ? "PASS" : "FAIL");?></td>
                
                <td style="border-right:1px solid #D9d9d9;">NO SLEEVES OF PREVIOUS JOB</td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($row->no_sleeves_of_previous_job_status==1 ? "PASS" : "FAIL");?></td>
            </tr>

             <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td>Layer 1 Micron</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $row->gauge_layer_1;?></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($row->gauge_layer_one_status==1 ? "PASS" : "FAIL");?></td>
                
                <td style="border-right:1px solid #D9d9d9;">MACHINE AND SURROUNDING CLEAN</td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($row->machine_clean_status==1 ? "PASS" : "FAIL");?></td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td>Layer 2 Micron</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $row->gauge_layer_2;?></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($row->gauge_layer_two_status==1 ? "PASS" : "FAIL");?></td>
                
                <td style="border-right:1px solid #D9d9d9;">MACHINE READY FOR SETUP</td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($row->machine_ready_status==1 ? "PASS" : "FAIL");?></td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td>Layer 3 Micron</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $row->gauge_layer_3;?></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($row->gauge_layer_three_status==1 ? "PASS" : "FAIL");?></td>
                
                <td style="border-right:1px solid #D9d9d9;">FINGER/COMB IS CLEANED</td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($row->finger_comb_status==1 ? "PASS" : "FAIL");?></td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td>Layer 4 Micron</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $row->gauge_layer_4;?></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($row->gauge_layer_four_status==1 ? "PASS" : "FAIL");?></td>
                <td style="border-right:1px solid #D9d9d9;">REMARKS</td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $row->remark;?></td>
                
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td>Layer 5 Micron</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $row->gauge_layer_5;?></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($row->gauge_layer_five_status==1 ? "PASS" : "FAIL");?></td>
                <td style="border-right:1px solid #D9d9d9;">STATUS OF INSPECTION</td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($row->inspection_status==1 ? "APPROVED" : "");?><?php echo ($row->inspection_status==2 ? "REJECT" : "");?><?php echo ($row->inspection_status==0 ? "HOLD" : "");?></td>
                
            </tr>
            
            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td colspan="3">GRADE & % OF BLEND</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                 <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;" colspan="2">REASON FOR SETUP APPROVAL</td>                
            </tr>
            
            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td>Layer 1</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $row->layer_one;?></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($row->layer_one_status==1 ? "PASS" : "FAIL");?></td>
                
                <td style="border-right:0px solid #D9d9d9;">NEW JOB</td>
                <td style="border-right:0px solid #D9d9d9;"><input type="checkbox" name="new_job_status" value="1" <?php echo ($row->new_job_status==1 ? 'checked': '');?>></td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td>Layer 2</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $row->layer_two;?></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($row->layer_two_status==1 ? "PASS" : "FAIL");?></td>
                
                <td style="border-right:0px solid #D9d9d9;">POWER FAILURE</td>
                <td style="border-right:0px solid #D9d9d9;"><input type="checkbox" name="power_failure_status" value="1" <?php echo ($row->power_failure_status==1 ? 'checked': '');?>></td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td>Layer 3</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $row->layer_three;?></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($row->layer_three_status==1 ? "PASS" : "FAIL");?></td>
                
                <td style="border-right:0px solid #D9d9d9;">CHNAGE OF RM</td>
                <td style="border-right:0px solid #D9d9d9;"><input type="checkbox" name="change_of_rm_status" value="1" <?php echo ($row->change_of_rm_status==1 ? 'checked': '');?>></td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td>Layer 4</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $row->layer_four;?></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($row->layer_four_status==1 ? "PASS" : "FAIL");?></td>
                
                <td style="border-right:0px solid #D9d9d9;">SHIFT CHANGE</td>
                <td style="border-right:0px solid #D9d9d9;"><input type="checkbox" name="shift_change_status" value="1" <?php echo ($row->shift_change_status==1 ? 'checked': '');?>></td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td>Layer 5</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $row->layer_five;?></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($row->layer_five_status==1 ? "PASS" : "FAIL");?></td>
                
                <td style="border-right:0px solid #D9d9d9;">MOULD TRIAL</td>
                <td style="border-right:0px solid #D9d9d9;"><input type="checkbox" name="mould_trial_status" value="1" <?php echo ($row->mould_trial_status==1 ? 'checked': '');?>></td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td>LENGTH OF SLEEVE</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">JOBCARD & CUSTOMER SPECIFIC</td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $row->sleeve_length_actual;?></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($row->sleeve_length_status==1 ? "PASS" : "FAIL");?></td>
                
                <td style="border-right:0px solid #D9d9d9;">MACHINE MAINTAINANCE</td>
                <td style="border-right:0px solid #D9d9d9;"><input type="checkbox" name="machine_maintainance_status" value="1" <?php echo ($row->machine_maintainance_status==1 ? 'checked': '');?>></td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td>COLOUR DIFFERENCE</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">DE<3</td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $row->color_diffrence_actual;?></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($row->color_diffrence_status==1 ? "PASS" : "FAIL");?></td>
                
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
            </tr>

         

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td>OPACITY</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">90%</td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $row->opacity_actual;?></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($row->opacity_status==1 ? "PASS" : "FAIL");?></td>
                
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td>CUTTING QUALITY</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">SHOULD BE UNIFORM</td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $row->cutting_quality_actual;?></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($row->cutting_quality_status==1 ? "PASS" : "FAIL");?></td>
                
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td>DIE LINE</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">NO DIE LINE</td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $row->die_line_actual;?></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($row->die_line_status==1 ? "PASS" : "FAIL");?></td>
                
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td style="padding: 2px;">SCRATCH LINE</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;padding: 2px;"></td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;">NO SCRATCH LINE</td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;"><?php echo $row->scratch_line_actual;?></td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;"><?php echo ($row->scratch_line_status==1 ? "PASS" : "FAIL");?></td>
                
                <td style="border-right:1px solid #D9d9d9;padding: 2px;"></td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;"></td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td style="padding: 2px;">PIT/WATERMARK/FISHEYE</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;padding: 2px;"></td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;">NO PIT/WATERMARK</td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;"><?php echo $row->pit_watermark_actual;?></td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;"><?php echo ($row->pit_watermark_status==1 ? "PASS" : "FAIL");?></td>
                
                <td style="border-right:1px solid #D9d9d9;padding: 2px;"></td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;"></td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td style="padding: 2px;">CONTAMINATION</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;padding: 2px;"></td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;">NO CONTAMINATION</td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;"><?php echo $row->contamination_actual;?></td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;"><?php echo ($row->contamination_status==1 ? "PASS" : "FAIL");?></td>
                
                <td style="border-right:1px solid #D9d9d9;padding: 2px;"></td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;"></td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td style="padding: 2px;">RINGS INSIDE & OUTSIDE</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;padding: 2px;"></td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;">NO RINGS INSIDE & OUTSIDE</td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;"><?php echo $row->rings_inside_outside_actual;?></td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;"><?php echo ($row->rings_inside_outside_status==1 ? "PASS" : "FAIL");?></td>
                
                <td style="border-right:1px solid #D9d9d9;padding: 2px;"></td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;"></td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td style="padding: 2px;">COLOR DISPERSION</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;padding: 2px;"></td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;">SHOULD BE UNIFORM</td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;"><?php echo $row->color_dispersion_actual;?></td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;"><?php echo ($row->color_dispersion_status==1 ? "PASS" : "FAIL");?></td>
                
                <td style="border-right:1px solid #D9d9d9;padding: 2px;"></td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;"></td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td style="padding: 2px;">OVAL TUBE</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;padding: 2px;"></td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;">NO OVAL</td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;"><?php echo $row->oval_tube_actual;?></td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;"><?php echo ($row->oval_tube_status==1 ? "PASS" : "FAIL");?></td>
                
                <td style="border-right:1px solid #D9d9d9;padding: 2px;"></td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;"></td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td rowspan="3" colspan="2" style="border-right:1px solid #D9d9d9;padding: 2px;">MASTERBATCH COLOR & %</td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td style="border-right:1px solid #D9d9d9;padding: 2px;">Inner Layer:</td>
                <td style="border-right:1px solid #D9d9d9;text-align: left;padding: 2px;"><?php echo $row->master_batch_outer_layer;?></td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;"><?php echo ($row->inner_layer_master_batch_status==1 ? "PASS" : "FAIL");?></td>
                
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td style="border-right:1px solid #D9d9d9;">Outer Layer:</td>
                <td width="20%" style="border-right:1px solid #D9d9d9;text-align: left;"><?php echo $row->master_batch_inner_layer;?></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($row->inner_layer_master_batch_status==1 ? "PASS" : "FAIL");?></td>
                
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
            </tr>

            

        </table>

        <br/>
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">

            <tr class="heading" style="border-right:1px solid #D9d9d9;" >
                <td width="50%"> <i class="cogs icon"></i> PROCESS MONITORING FOR EVERY TWO HOURS</td>
                <td width="1%" ></td>
                <td width="1%" ></td>
                <td width="1%" ></td>
                <td width="5%" ></td>
                <td width="50%"><i class="user secret icon"></i> ACTUAL</td>
                <td width="1%" ></td>
                <td width="1%" ></td>
                <td width="1%" ></td>
            </tr>
        </table> 

        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">

            <tr class="heading" style="border-right:1px solid #D9d9d9;" >
                <td width="5%">PARAMETER</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="5%" >PARAMETER</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"><b>STANDARD</b></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"><b>TOLARANCE</b></td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.substr($coex_extrusion_qc_control_plan_parameters_row->inspection_time,0,5).'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td class="pding" >EXTRUDER 01</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">HOOPER THROAT</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_1_hooper_throat_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_1_hooper_throat_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td class="pding" >EXTRUDER 01</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">ZONE 01</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_1_zone_1_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_1_zone_1_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td class="pding">EXTRUDER 01</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">ZONE 02</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_1_zone_2_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_1_zone_2_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td class="pding" >EXTRUDER 01</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">ZONE 03</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_1_zone_3_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_1_zone_3_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td class="pding">EXTRUDER 01</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">ZONE 04</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_1_zone_4_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_1_zone_4_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td class="pding">EXTRUDER 01</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">ZONE 06</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_1_zone_6_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_1_zone_6_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td class="pding">EXTRUDER 02</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">HOOPER THROAT</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_2_hooper_throat_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_2_hooper_throat_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td class="pding">EXTRUDER 02</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">ZONE 01</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_2_zone_1_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_2_zone_1_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td class="pding">EXTRUDER 02</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">ZONE 02</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_2_zone_2_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_2_zone_2_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td class="pding">EXTRUDER 02</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">ZONE 03</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_2_zone_3_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_2_zone_3_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td class="pding">EXTRUDER 02</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">ZONE 04</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_2_zone_4_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_2_zone_4_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td class="pding">EXTRUDER 03</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">HOOPER THROAT</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_3_hooper_throat_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_3_hooper_throat_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td class="pding">EXTRUDER 03</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">ZONE 01</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_3_zone_1_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_3_zone_1_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td class="pding" >EXTRUDER 03</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">ZONE 02</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_3_zone_2_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_3_zone_2_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td class="pding" >EXTRUDER 03</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">ZONE 03</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_3_zone_3_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_3_zone_3_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td class="pding">EXTRUDER 03</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">ZONE 04</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_3_zone_4_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_3_zone_4_actual.'</b></td>';
                    }
                }?>
            </tr>


            <tr class="item">            
                <td class="pding">EXTRUDER 04</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">HOOPER THROAT</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_4_hooper_throat_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_4_hooper_throat_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td class="pding">EXTRUDER 04</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">ZONE 01</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_4_zone_1_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_4_zone_1_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td class="pding">EXTRUDER 04</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">ZONE 02</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_4_zone_2_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_4_zone_2_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td class="pding">EXTRUDER 04</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">ZONE 03</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_4_zone_3_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_4_zone_3_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td class="pding">EXTRUDER 04</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">ZONE 04</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_4_zone_4_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_4_zone_4_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td class="pding">EXTRUDER 04</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">ZONE 05</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_4_zone_5_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_4_zone_5_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td class="pding">EXTRUDER 04</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">ZONE 06</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_4_zone_6_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_4_zone_6_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td class="pding">DIE HEAD</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">ZONE 06</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->die_head_zone_6_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->die_head_zone_6_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td class="pding">DIE HEAD</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">ZONE 07</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->die_head_zone_7_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->die_head_zone_7_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td class="pding">DIE HEAD</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">ZONE 08</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->die_head_zone_8_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->die_head_zone_8_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td class="pding" >DIE HEAD</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">ZONE 09</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->die_head_zone_9_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->die_head_zone_9_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td class="pding" >DIE HEAD</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">ZONE 10</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->die_head_zone_10_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->die_head_zone_10_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td class="pding" >DIE HEAD</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">ZONE 11</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->die_head_zone_11_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->die_head_zone_11_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td class="pding">SCREW RPM</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">OUTER LAYER</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->screw_rpm_outer_layer_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/-3 RPM</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->screw_rpm_outer_layer_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td class="pding" >SCREW RPM</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">ADMER LAYER</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->screw_rpm_admer_layer_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/-3 RPM</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->screw_rpm_admer_layer_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td class="pding">SCREW RPM</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">EVOH LAYER</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->screw_rpm_evoh_layer_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/-3 RPM</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->screw_rpm_evoh_layer_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td class="pding">SCREW RPM</td>
                <td  class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">INNER LAYER</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->screw_rpm_inner_layer_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/-3 RPM</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->screw_rpm_inner_layer_std.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td class="pding" >VACUUM</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">TANK 1</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->vacuum_tank_1_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/- 0.2 KPA</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->vacuum_tank_1_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td class="pding" >VACUUM</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">TANK 2</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->vacuum_tank_2_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/- 0.2 KPA</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->vacuum_tank_2_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td class="pding" >WATER TEMP</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">TANK 1</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->water_temp_tank_1_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/- 10* C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->water_temp_tank_1_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td class="pding" >WATER TEMP</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">TANK 2</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->water_temp_tank_2_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/- 10* C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->water_temp_tank_2_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td class="pding" >ANNEALING WATER TEMP</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">T2</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->annealing_water_temp_t2_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/- 10* C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->annealing_water_temp_t2_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td class="pding" >CUTTING SETTING VALUE</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">T2</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->cutting_setting_value_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->cutting_setting_value_atual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td class="pding" >CALIBRATOR WATER COOLING LEVEL</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">D4</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->calibrator_water_d4_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/- 1L/Min</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->calibrator_water_d4_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td class="pding" >CALIBRATOR WATER COOLING LEVEL</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">D5</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->calibrator_water_d5_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/- 1L/Min</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->calibrator_water_d5_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td class="pding">CALIBRATOR WATER COOLING LEVEL</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">D6</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->calibrator_water_d6_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/- 1L/Min</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->calibrator_water_d6_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td class="pding">CALIBRATOR WATER COOLING LEVEL</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">D7</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->calibrator_water_d7_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/- 1L/Min</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->calibrator_water_d7_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td class="pding" >CALIBRATOR WATER COOLING LEVEL</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">D8</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->calibrator_water_d8_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/- 1L/Min</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->calibrator_water_d8_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td class="pding" >ANNEALING ZONE</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">D9</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->annealing_zone_d9_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/- 1L/Min</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->annealing_zone_d9_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td class="pding" >ANNEALING ZONE</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">D10</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->annealing_zone_d10_std.'</b></td>';
                    }
                }?>                
                <td class="pding" style="border-right:1px solid #D9d9d9;">+/- 1L/Min</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->annealing_zone_d10_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td class="pding" >ZUMBAC VALUE</td>
                <td class="pding" style="border-right:1px solid #D9d9d9;"></td>
                <td class="pding" style="border-right:1px solid #D9d9d9;">It subject to change diameter wise  and print type wise</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->zumbac_value_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;padding: 2px;"></td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->zumbac_value_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td style="padding: 2px;">LENGTH OBSERVED</td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;"></td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;">AS PER SPECS</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->length_observed_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;padding: 2px;">+/- 0.1MM</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->length_observed_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td style="padding: 2px;">OUTER DIAMTER</td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;"></td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;">AS PER SPECS</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->outer_diameter_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;padding: 2px;">+/- 0.1MM</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->outer_diameter_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td style="padding: 2px;">INNER DIAMTER</td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;"></td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;">AS PER SPECS</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->inner_diameter_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;padding: 2px;">+/- 0.1MM</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->inner_diameter_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td style="padding: 2px;">THICKNESS</td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;"></td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;">AS PER SPECS</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->thickness_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;padding: 2px;">+/- 15 MIC</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->thickness_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td style="padding: 2px;">WEIGHT</td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;"></td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;">AS PER FORMULA</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->weight_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;padding: 2px;">+/- 0.2 Gm</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->weight_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td style="padding: 2px;">HOURLY SIGN TUBE</td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;"></td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;"></td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->hourly_sign_tube_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;padding: 2px;"></td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->hourly_sign_tube_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td style="padding: 2px;">CHECKED BY OPERATOR</td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;"></td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;"></td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->checked_by_operator.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;padding: 2px;"></td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->checked_by_operator.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td style="padding: 2px;">VERIFIED BY QC</td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;"></td>
                <td style="border-right:1px solid #D9d9d9;padding: 2px;"></td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->verified_by_qc.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;padding: 2px;"></td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->verified_by_qc.'</b></td>';
                    }
                }?>
            </tr>
        </table>
        
                
     <?php endforeach;?>
    
</body>
</html>   