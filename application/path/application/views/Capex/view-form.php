
<?php foreach ($capex as $capex_row):?>

    <div class="ui teal labels" style="text-align: center;">
      <div class="ui label">
        <?php echo $capex_row->capex_no;?>
      </div>
    </div>

        <?php echo $capex_row->final_approval_flag==1 ? '<a class="ui green right ribbon label">Approved</a>' : '<a class="ui  red right ribbon label">Unapproved</a>';?>
         <br/>

        <?php echo $this->common_model->view_date($capex_row->capex_date,$this->session->userdata['logged_in']['company_id'])!='' ? '<span class="ui blue left ribbon label">'.$this->common_model->view_date($capex_row->capex_date,$this->session->userdata['logged_in']['company_id']).'</span>' : '';?>
        <br/>
        <br/>

        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">

            
            <tr class="heading">
                <td width="20%"><b>PROJECT NAME</b> : <?php echo $capex_row->project_name; ?></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="25%" style="border-right:1px solid #D9d9d9;"><b>APPLICANT</b> : <?php echo $capex_row->applicant;?></td>
                
                <td width="20%"><b>PROJECT START DATE</b> : <?php echo ($capex_row->project_begin_date!='0000-00-00' ? $this->common_model->view_date($capex_row->project_begin_date,$this->session->userdata['logged_in']['company_id']) : '-');?></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="25%"><b>PROJECT END DATE <b/> : <?php echo ($capex_row->project_end_date!='0000-00-00' ? $this->common_model->view_date($capex_row->project_end_date,$this->session->userdata['logged_in']['company_id']) : '-');?></td>
            </tr>
        </table>
        <br/>
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            <tr class="heading">
                <td width="20%"><b>REPLACEMENT <input type="checkbox" <?php echo ($capex_row->replacement==1 ? 'checked' : '');?>></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="25%" style="border-right:1px solid #D9d9d9;"><b>IMPROVEMENT <input type="checkbox" <?php echo ($capex_row->improvement==1 ? 'checked' : '');?> ></td>
                <td width="20%"><b>EXPANSION <input type="checkbox" <?php echo ($capex_row->expansion==1 ? 'checked' : '');?>></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="25%" style="border-right:1px solid #D9d9d9;"><b>RENEWAL <input type="checkbox" <?php echo ($capex_row->renewal==1 ? 'checked' : '');?>></td>
            </tr>
        </table>
        <br/>
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            
           <tr class="heading">
                <td width="20%"><b>COST CENTER </b> : <?php echo $capex_row->cost_center;?></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="25%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="20%"><b>EXPECTED USEFUL LIFE </b> : <?php echo $capex_row->expected_useful_life;?> IN YEARS</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="25%"></td>
            </tr>
        </table>
        <br/>
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            <tr class="heading">
                <td width="20%"><b>CAPEX AMOUNT</b> : <?php echo number_format($capex_row->capex_amount,2);?>/-</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="25%" style="border-right:1px solid #D9d9d9;"><b>THIRD PARTY SERVICE AMOUNT</b> : <?php echo number_format($capex_row->third_party_service_amount,2);?>/-</td>
                <td width="20%"><b>OWN WORK AMOUNT</b> : <?php echo number_format($capex_row->own_work_amount,2);?>/-</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="30%"><b>TOTAL AMOUNT</b> : <?php echo number_format($capex_row->total_amount,2);?>/-</td>
            </tr>

        </table>
        <br/>
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
                <tr class="heading">
                    <td colspan="6"><b>1] STARTING SITUATION/PROBLEM FORMULATION</td>
                </tr>

                <tr class="item">
                    <td colspan="6"><?php echo $capex_row->problem;?></td>
                </tr>
        </table>
        <br/>
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
                <tr class="heading">
                    <td colspan="6"><b>2] SOLUTION PROPOSAL</td>
                </tr>

                <tr class="item">
                    <td colspan="6"><?php echo $capex_row->solution;?></td>
                </tr>
        </table>

        <br/>
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
                <tr class="heading">
                    <td colspan="6"><b>3] ADVANTAGE/RISK</td>
                </tr>

                <tr class="item">
                    <td colspan="6"><?php echo $capex_row->advantage;?></td>
                </tr>

                <tr class="item">
                    <td colspan="6"><?php echo $capex_row->risk;?></td>
                </tr>
        </table>
        <br/>

        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
                <tr class="heading">
                    <td colspan="6"><b>4] SAVINGS/COST</td>
                </tr>

                <tr class="item">
                    <td colspan="6"><?php echo $capex_row->saving;?></td>
                </tr>
        </table>
        <br/>

        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
                <tr class="heading">
                    <td colspan="6"><b>5] ALTERNATIVES</td>
                </tr>

                <tr class="item">
                    <td colspan="6"><?php echo $capex_row->alternative;?></td>
                </tr>
        </table>
        <br/>


        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
                <tr class="heading">
                    <td colspan="6"><b>6] IMPACT, IF REQUEST IS BEING DENIED</td>
                </tr>

                <tr class="item">
                    <td colspan="6"><?php echo $capex_row->impact;?></td>
                </tr>
        </table>    
        <br/>
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            <tr class="item">
                <td width="20%"><b>PROFITABILITY</b> : <?php echo $capex_row->profitability;?></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="25%"><b>ROI</b> : <?php echo $capex_row->roi;?></td>
                <td width="20%"><b>PAY BACK YEARS</b> : <?php echo $capex_row->pay_back_year;?></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="25%"><b>IRR</b> : <?php echo $capex_row->irr;?></td>
            </tr>

            <tr class="item">
                <td width="20%"><b>INFORM CLIENTS</b> : <input type="checkbox" <?php echo ($capex_row->inform_clients==1 ? 'checked' : '');?>></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="25%" style="border-right:1px solid #D9d9d9;"><b>EQUIPMENT QUALIFICATION</b> : <input type="checkbox" <?php echo ($capex_row->equipment_qualification==1 ? 'checked' : '');?>></td>
                <td width="20%"><b>PRODUCT VALIDATION</b> : <input type="checkbox" <?php echo ($capex_row->product_validation==1 ? 'checked' : '');?>></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="25%"></td>
            </tr>

            <tr class="item">
                <td width="20%"><b>PROJECT ORGANIZATION</b> : <?php echo $capex_row->project_organization;?></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="25%" colspan="4"><b>PROJECT TEAM MEMBERS</b> : <?php echo $capex_row->project_team_members;?></td>

            </tr>

        </table>
        <br/>

        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            <tr class="heading">
                <td colspan="6">DATE & SIGNATURES</td>
            </tr>


            <tr class="item">
                <td width="20%"><b>APPLICANT</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="25%" style="border-right:1px solid #D9d9d9;"><b>COO</td>
                <td width="20%"><b>FINANCE/CONTROL</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="25%"><b>MANAGING DIRECTOR</td>
            </tr>

            <tr>
                <td width="20%">&nbsp;</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="25%" style="border-right:1px solid #D9d9d9;">&nbsp;</td>
                <td width="20%">&nbsp;</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="25%">&nbsp;</td>
            </tr>

            <tr>
                <td width="20%"><?php echo $capex_row->applicant;?></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="25%" style="border-right:1px solid #D9d9d9;">&nbsp;</td>
                <td width="20%">&nbsp;</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="25%">&nbsp;</td>
            </tr>

        </table>
        <br/>
        <?php endforeach;?>
    

    </div>
</body>
        
  
</html>
