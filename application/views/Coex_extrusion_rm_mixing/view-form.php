

<?php foreach ($coex_extrusion_rm_mixing as $row):?>
   
      
    <div class="ui teal labels" style="text-align: center;">
      <div class="ui label">
        COEX EXTRUSION MIXING REPORT 
      </div>
    </div>

        <?php echo $this->common_model->view_date($row->mixing_date,$this->session->userdata['logged_in']['company_id'])!='' ? '<span class="ui blue left ribbon label"><i class="calendar alternate outline icon"></i>'.$this->common_model->view_date($row->mixing_date,$this->session->userdata['logged_in']['company_id']).' '.$row->shift_name.'</span>' : '';
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
                <td width="5%">SR NO</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="25%" style="border-right:1px solid #D9d9d9;">MATERIAL</td>
                <td width="20%" style="border-right:1px solid #D9d9d9;">MATERIAL CODE</td>
                <td width="10%" style="border-right:1px solid #D9d9d9;">RM USED</td>
                <td width="15%">BATCH NO</td>
            </tr>

            <?php if($coex_extrusion_rm_mixing_details==FALSE){

            }else{
                $total_rm_used=0;
                foreach($coex_extrusion_rm_mixing_details as $coex_extrusion_rm_mixing_details_row){
                echo "<tr class='item' style='border-right:1px solid #D9d9d9;'>
                        <td>".$coex_extrusion_rm_mixing_details_row->sr_no."</td>
                        <td style='border-right:1px solid #D9d9d9;'></td>
                        <td style='border-right:1px solid #D9d9d9;'>".$this->common_model->get_article_name($coex_extrusion_rm_mixing_details_row->material_code,$this->session->userdata['logged_in']['company_id'])."</td>
                        <td style='border-right:1px solid #D9d9d9;'>".$coex_extrusion_rm_mixing_details_row->material_code."</td>
                        <td style='border-right:1px solid #D9d9d9;'>".$this->common_model->read_number($coex_extrusion_rm_mixing_details_row->qty_mixed,$this->session->userdata['logged_in']['company_id'])." KG</td>
                        <td >".$coex_extrusion_rm_mixing_details_row->batch_no."</td>
                </tr>";
                $total_rm_used+=$coex_extrusion_rm_mixing_details_row->qty_mixed;
                }
                echo "<tr class='item last'>
                        <td><b>TOTAL</b></td>
                        <td>&nbsp;</td>
                        <td></td>
                        <td></td>
                        <td><b>".$this->common_model->read_number($total_rm_used,$this->session->userdata['logged_in']['company_id'])." KG </b></td>
                        <td></td>
                        </tr>";
            }
            ?>
        </table>
        <br/>
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            <tr class="heading" style="border-right:1px solid #D9d9d9;" >
                <td colspan="7">OUTPUT DETAILS</td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td width="10%">INITIAL COUNTER</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="10%" style="border-right:1px solid #D9d9d9;"><?php echo $this->common_model->read_number($row->initial_counter_reading,$this->session->userdata['logged_in']['company_id']);?></td>
                <td width="10%" style="border-right:1px solid #D9d9d9;">FINAL COUNTER</td>
                <td width="10%" style="border-right:1px solid #D9d9d9;"><?php echo $this->common_model->read_number($row->final_counter_reading,$this->session->userdata['logged_in']['company_id']);?></td>
                <td width="10%" style="border-right:1px solid #D9d9d9;">NUMBER OF SLEEVES</td>
                <td width="10%" style="border-right:1px solid #D9d9d9;"><?php echo $this->common_model->read_number($row->number_of_sleeves,$this->session->userdata['logged_in']['company_id']);?></td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td width="10%">SLEEVES WEIGHT</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="10%" style="border-right:1px solid #D9d9d9;"><?php echo $this->common_model->read_number($row->sleeves_weight,$this->session->userdata['logged_in']['company_id']);?>KG</td>
                <td width="10%" style="border-right:1px solid #D9d9d9;">SCRAP WEIGHT</td>
                <td width="10%" style="border-right:1px solid #D9d9d9;"><?php echo $this->common_model->read_number($row->scrap_weight,$this->session->userdata['logged_in']['company_id']);?>KG</td>
                <td width="10%" style="border-right:1px solid #D9d9d9;">LUMPS WEIGHT</td>
                <td width="10%" style="border-right:1px solid #D9d9d9;"><?php echo $this->common_model->read_number($row->lumps_weight,$this->session->userdata['logged_in']['company_id']);?>KG</td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td width="10%">OUTPUT WEIGHT</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="10%" style="border-right:1px solid #D9d9d9;"><?php echo $this->common_model->read_number($row->output_weight,$this->session->userdata['logged_in']['company_id']);?>KG</td>
                <td width="10%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="10%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="10%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="10%" style="border-right:1px solid #D9d9d9;"></td>
            </tr>

            <tr class="item last" style="border-right:1px solid #D9d9d9;" >
                <td width="10%"><b>PREPARED BY</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="10%" style="border-right:1px solid #D9d9d9;"><b><?php echo strtoupper($row->prepared_by);?></td>
                <td width="10%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="10%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="10%" style="border-right:1px solid #D9d9d9;"><b>CHECKED BY</td>
                <td width="10%" style="border-right:1px solid #D9d9d9;"><b><?php echo strtoupper($row->checked_by);?></td>
            </tr>

        </table>
    <?php endforeach;?>
    
</body>
</html>   