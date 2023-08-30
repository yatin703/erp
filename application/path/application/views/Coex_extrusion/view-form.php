

<?php foreach ($coex_extrusion as $row):?>
   
      
    <div class="ui teal labels" style="text-align: center;">
      <div class="ui label">
        COEX EXTRUSION  
      </div>
    </div>

        <?php echo $this->common_model->view_date($row->extrusion_date,$this->session->userdata['logged_in']['company_id'])!='' ? '<span class="ui blue left ribbon label"><i class="calendar alternate outline icon"></i>'.$this->common_model->view_date($row->extrusion_date,$this->session->userdata['logged_in']['company_id']).' '.$row->shift_name.'</span>' : '';
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
                <td width="10%"> <i class="bars icon"></i>SHIFT NO</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><?php echo $row->shift_name;?></td>
                <td width="15%"><i class="stop watch icon"></i>OPERATOR</td>                
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="30%"><?php echo $row->operator ;?></td>
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

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td width="10%"> <i class="bars icon"></i>RM CONSUMED</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><?php echo $row->rm_mixed_qty_kg;?> KG</td>
                <td width="15%"><i class="stop watch icon"></i>EXTRUDED TUBES</td>                
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="30%"><?php echo money_format('%!.0n',$row->ok_qty_no); echo " NO"; ?></td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td width="10%"> <i class="bars icon"></i>SLEEVE WEIGHT</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><?php echo $row->sleeve_weight_kg*1000;?> GM</td>
                <td width="15%"><i class="stop watch icon"></i>EXTRUDED TUBE WEIGHT</td>                
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="30%"><?php echo $row->sleeve_weight_kg*$row->ok_qty_no; echo " KG"; ?></td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td width="10%"> <i class="bars icon"></i>SCRAP WEIGHT</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><?php echo $row->scrap_weight_kg;?> KG</td>
                <td width="15%"><i class="stop watch icon"></i>SCRAP</td>                
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="30%"><?php echo money_format('%!.0n',$row->scrap_tube_no); echo " NO"; ?></td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td width="10%"> <i class="bars icon"></i>CUTTING SPEED</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><?php echo $row->cutting_speed_minutes;?> / Min</td>
                <td width="15%"><i class="stop watch icon"></i>Rejection</td>                
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="30%"><?php echo money_format('%!.0n',$row->rejection_percentage); echo "%"; ?></td>
            </tr>

        </table>
        
        
    <?php endforeach;?>
    
</body>
</html>   