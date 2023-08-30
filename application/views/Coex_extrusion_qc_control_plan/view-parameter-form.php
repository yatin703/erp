

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
                <td >EXTRUDER 01</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">HOOPER THROAT</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_1_hooper_throat_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_1_hooper_throat_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td >EXTRUDER 01</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">ZONE 01</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_1_zone_1_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_1_zone_1_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td >EXTRUDER 01</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">ZONE 02</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_1_zone_2_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_1_zone_2_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td >EXTRUDER 01</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">ZONE 03</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_1_zone_3_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_1_zone_3_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td >EXTRUDER 01</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">ZONE 04</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_1_zone_4_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_1_zone_4_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td >EXTRUDER 01</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">ZONE 06</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_1_zone_6_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_1_zone_6_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td >EXTRUDER 02</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">HOOPER THROAT</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_2_hooper_throat_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_2_hooper_throat_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td >EXTRUDER 02</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">ZONE 01</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_2_zone_1_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_2_zone_1_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td >EXTRUDER 02</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">ZONE 02</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_2_zone_2_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_2_zone_2_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td >EXTRUDER 02</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">ZONE 03</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_2_zone_3_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_2_zone_3_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td >EXTRUDER 02</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">ZONE 04</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_2_zone_4_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_2_zone_4_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td >EXTRUDER 03</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">HOOPER THROAT</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_3_hooper_throat_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_3_hooper_throat_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td >EXTRUDER 03</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">ZONE 01</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_3_zone_1_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_3_zone_1_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td >EXTRUDER 03</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">ZONE 02</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_3_zone_2_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_3_zone_2_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td >EXTRUDER 03</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">ZONE 03</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_3_zone_3_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_3_zone_3_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td >EXTRUDER 03</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">ZONE 04</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_3_zone_4_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_3_zone_4_actual.'</b></td>';
                    }
                }?>
            </tr>


            <tr class="item">            
                <td >EXTRUDER 04</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">HOOPER THROAT</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_4_hooper_throat_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_4_hooper_throat_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td >EXTRUDER 04</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">ZONE 01</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_4_zone_1_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_4_zone_1_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td >EXTRUDER 04</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">ZONE 02</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_4_zone_2_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_4_zone_2_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td >EXTRUDER 04</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">ZONE 03</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_4_zone_3_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_4_zone_3_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td >EXTRUDER 04</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">ZONE 04</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_4_zone_4_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_4_zone_4_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td >EXTRUDER 04</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">ZONE 05</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_4_zone_5_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_4_zone_5_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td >EXTRUDER 04</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">ZONE 06</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_4_zone_6_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->extruder_4_zone_6_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td >DIE HEAD</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">ZONE 06</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->die_head_zone_6_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->die_head_zone_6_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td >DIE HEAD</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">ZONE 07</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->die_head_zone_7_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->die_head_zone_7_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td >DIE HEAD</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">ZONE 08</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->die_head_zone_8_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->die_head_zone_8_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td >DIE HEAD</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">ZONE 09</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->die_head_zone_9_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->die_head_zone_9_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td >DIE HEAD</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">ZONE 10</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->die_head_zone_10_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->die_head_zone_10_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td >DIE HEAD</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">ZONE 11</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->die_head_zone_11_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/-10*C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->die_head_zone_11_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td >SCREW RPM</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">OUTER LAYER</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->screw_rpm_outer_layer_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/-3 RPM</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->screw_rpm_outer_layer_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td >SCREW RPM</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">ADMER LAYER</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->screw_rpm_admer_layer_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/-3 RPM</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->screw_rpm_admer_layer_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td >SCREW RPM</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">EVOH LAYER</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->screw_rpm_evoh_layer_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/-3 RPM</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->screw_rpm_evoh_layer_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td >SCREW RPM</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">INNER LAYER</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->screw_rpm_inner_layer_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/-3 RPM</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->screw_rpm_inner_layer_std.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td >VACUUM</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">TANK 1</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->vacuum_tank_1_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/- 0.2 KPA</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->vacuum_tank_1_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td >VACUUM</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">TANK 2</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->vacuum_tank_2_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/- 0.2 KPA</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->vacuum_tank_2_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td >WATER TEMP</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">TANK 1</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->water_temp_tank_1_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/- 10* C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->water_temp_tank_1_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td >WATER TEMP</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">TANK 2</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->water_temp_tank_2_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/- 10* C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->water_temp_tank_2_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td >ANNEALING WATER TEMP</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">T2</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->annealing_water_temp_t2_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/- 10* C</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->annealing_water_temp_t2_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td >CUTTING SETTING VALUE</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">T2</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->cutting_setting_value_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;"></td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->cutting_setting_value_atual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td >CALIBRATOR WATER COOLING LEVEL</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">D4</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->calibrator_water_d4_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/- 1L/Min</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->calibrator_water_d4_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td >CALIBRATOR WATER COOLING LEVEL</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">D5</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->calibrator_water_d5_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/- 1L/Min</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->calibrator_water_d5_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td >CALIBRATOR WATER COOLING LEVEL</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">D6</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->calibrator_water_d6_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/- 1L/Min</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->calibrator_water_d6_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td >CALIBRATOR WATER COOLING LEVEL</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">D7</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->calibrator_water_d7_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/- 1L/Min</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->calibrator_water_d7_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td >CALIBRATOR WATER COOLING LEVEL</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">D8</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->calibrator_water_d8_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/- 1L/Min</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->calibrator_water_d8_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td >ANNEALING ZONE</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">D9</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->annealing_zone_d9_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/- 1L/Min</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->annealing_zone_d9_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td >ANNEALING ZONE</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">D10</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->annealing_zone_d10_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/- 1L/Min</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->annealing_zone_d10_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td >ZUMBAC VALUE</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">It subject to change diameter wise  and print type wise</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->zumbac_value_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;"></td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->zumbac_value_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td >LENGTH OBSERVED</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">AS PER SPECS</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->length_observed_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/- 0.1MM</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->length_observed_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td >OUTER DIAMTER</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">AS PER SPECS</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->outer_diameter_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/- 0.1MM</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->outer_diameter_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td >INNER DIAMTER</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">AS PER SPECS</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->inner_diameter_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/- 0.1MM</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->inner_diameter_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td >THICKNESS</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">AS PER SPECS</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->thickness_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/- 15 MIC</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->thickness_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td >WEIGHT</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">AS PER FORMULA</td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->weight_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;">+/- 0.2 Gm</td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->weight_actual.'</b></td>';
                    }
                }?>
            </tr>

            <tr class="item">            
                <td >HOURLY SIGN TUBE</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->hourly_sign_tube_std.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;"></td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->hourly_sign_tube_actual.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td >CHECKED BY OPERATOR</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->checked_by_operator.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;"></td>
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->checked_by_operator.'</b></td>';
                    }
                }?>
            </tr>
            <tr class="item">            
                <td >VERIFIED BY QC</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                
                <?php
                if($coex_extrusion_qc_control_plan_parameters==FALSE){

                }else{
                    foreach($coex_extrusion_qc_control_plan_parameters as $coex_extrusion_qc_control_plan_parameters_row){
                        echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.$coex_extrusion_qc_control_plan_parameters_row->verified_by_qc.'</b></td>';
                    }
                }?>                
                <td style="border-right:1px solid #D9d9d9;"></td>
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