<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

    $(document).ready(function(){

        $(".invoice-box").css("max-width", "1300px");
    });
 </script> 

<?php foreach ($springtube_ink_mixing_master as $springtube_ink_mixing_master_row):?>
    
    </br>
    <div class="ui teal labels" style="text-align: center;">
      <div class="ui label">
        SPRINGTUBE INK MIXING DETAILS
      </div>
    </div>

        <br/>

        <?php echo $this->common_model->view_date($springtube_ink_mixing_master_row->ink_mixing_date,$this->session->userdata['logged_in']['company_id'])!='' ? '<span class="ui blue left ribbon label"><i class="calendar alternate outline icon"></i>'.$this->common_model->view_date($springtube_ink_mixing_master_row->ink_mixing_date,$this->session->userdata['logged_in']['company_id']).'</span>' : '';?>
        <br/>
        <br/>

        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            
            <tr class="heading" style="border-right:1px solid #D9d9d9;">

                <td width="20%" style="border-bottom:1px solid #D9d9d9;"><b>INK DESC</b></td>
                <td width="1%" style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;"></td>
                <td width="3%" style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;">MANUFACTURER</td>                
                <td width="15%" style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;"><b>INK NAME</b></td>                
                <td width="5%" style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;"><b>INK CODE</b></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;"><b>INK CATEGORY</b></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;"><b>INK MIGRATION</b></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;"><b>SUBSTRATE</b></td>
                
                
                
            </tr>
        
            <tr class="item">
                <td style="border-bottom:1px solid #D9d9d9;"><?php echo $springtube_ink_mixing_master_row->ink_desc ;?></td>
                <td style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;"><?php echo $springtube_ink_mixing_master_row->ink_manufacturer ;?></td>
                <td style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;"><?php echo $springtube_ink_mixing_master_row->ink_name ;?></td> 
                <td style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;"><?php echo $springtube_ink_mixing_master_row->ink_code ;?></td> 
                <td style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;"><?php echo $springtube_ink_mixing_master_row->ink_category ;?></td> 
                <td style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;"><?php echo $springtube_ink_mixing_master_row->ink_migration ;?></td>
                <td style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;"><?php echo $springtube_ink_mixing_master_row->substrate ;?></td>
                
                
            </tr>
        </table>        
        <br/>         
        <br/>
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            
            <tr class="heading" style="border-right:1px solid #D9d9d9;" >
                <td width="1%" style="border-bottom:1px solid #D9d9d9;" >SR NO</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;"></td>
                <td width="15%" style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;"><b>INK DESC</b></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;"><b>QUANTITY(GRAMS)</b></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;"><b>INK PERC.</b></td>                
                <td width="15%" style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;"><b>ARTICLE NAME</b></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;"><b>ARTICLE NO</b></td>
            </tr>
            <?php
            $i=1;
            $sum_of_quantity=0;
            $total_perc=0;
            foreach ($springtube_ink_mixing_details as  $details_row) {

                $sum_of_quantity+=$details_row->quantity;
                $total_perc+=$details_row->ink_perc;
                echo '<tr class="item">
                    <td style="border-bottom:1px solid #D9d9d9;" >'.$i++.'</td>
                    <td style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;"></td>                                             
                    <td style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;">'.$details_row->ink_desc.'</td>                
                    <td style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;">'.$details_row->quantity.'</td>
                    <td style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;">'.$details_row->ink_perc.' %</td>  
                                  
                    <td style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;">'.$this->common_model->get_article_name($details_row->article_no,$this->session->userdata['logged_in']['company_id']).'</td>
                    <td style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;">'.$details_row->article_no.'</td> 
                </tr>';
            }
                echo'<tr class="heading" style="border-right:1px solid #D9d9d9;"><td colspan="2" width="50%" style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;" >TOTAL</td><td width="5%" style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;"></td><td width="5%" style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;">'.$sum_of_quantity.'</td><td style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;">'.$total_perc.' %</td><td></td><td></td></tr>';
            ?>
        </table>
        <br/>
        <br/>
        
                
     <?php endforeach;?>
    </div>
</body>
</html>   