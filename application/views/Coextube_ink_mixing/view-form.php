<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

    $(document).ready(function(){

        $(".invoice-box").css("max-width", "");
    });
 </script> 

<?php foreach ($coextube_ink_mixing_master as $coextube_ink_mixing_master_row):?>
    
    </br>
    <div class="ui teal labels" style="text-align: center;">
      <div class="ui label">
        COEXTUBE INK MIXING DETAILS
      </div>
    </div>

        <br/>

        <?php echo $this->common_model->view_date($coextube_ink_mixing_master_row->ink_mixing_date,$this->session->userdata['logged_in']['company_id'])!='' ? '<span class="ui blue left ribbon label"><i class="calendar alternate outline icon"></i>'.$this->common_model->view_date($coextube_ink_mixing_master_row->ink_mixing_date,$this->session->userdata['logged_in']['company_id']).'</span>' : '';?>
        <br/>
        <br/>

        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            
            <tr class="heading" style="border-right:1px solid #D9d9d9;">
                
                <td width="50%" style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;"><b>Pantone Code : <?php echo $coextube_ink_mixing_master_row->pantone_code ;?></b></td>
                <td width="50%" style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;text-align:left;"><b>Substrate : <?php echo $coextube_ink_mixing_master_row->substrate ;?></b></td> 
                 
                <!-- <td width="30%" style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;background: #fff;text-align: left;"><?php echo $coextube_ink_mixing_master_row->pantone_code ;?></td> --> 
                       
                <!-- <td width="25%" style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;"><b>INK CATEGORY</b></td> 
        
                <td width="25%" style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;background: #fff;text-align: left;"><?php echo $coextube_ink_mixing_master_row->pantone_code ;?></td> -->
                
            </tr>
        </table>        
        <br/>         
        <br/>
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            
            <tr class="heading" style="border-right:1px solid #D9d9d9;" >
                <td width="1%" style="border-bottom:1px solid #D9d9d9;" >SR NO</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;"></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;"><b>ARTICLE NO</b></td>               
                <td width="15%" style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;"><b>ARTICLE NAME</b></td>
                 <td width="5%" style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;"><b>QUANTITY(GRAMS)</b></td> 
                
            </tr>

            <?php
            $i=1;
            $sum_of_quantity=0;
            foreach ($coextube_ink_mixing_details as  $details_row) {

                $sum_of_quantity+=$details_row->quantity;
                echo '<tr class="item">
                    <td style="border-bottom:1px solid #D9d9d9;" >'.$i++.'</td>
                    <td style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;"></td>                      
                     
                                  
                   
                    <td style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;">'.$details_row->ink_name.'</td>
                     <td style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;">'.$this->common_model->get_article_name($details_row->ink_name,$this->session->userdata['logged_in']['company_id']).'</td>
                    <td style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;">'.$details_row->quantity.'</td> 
                </tr>';
            }
                echo'<tr class="heading" style="border-right:1px solid #D9d9d9;"><td colspan="4" width="50%" style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;" >TOTAL</td>

                    <td width="5%" style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;    text-align: left;">'.$sum_of_quantity.'</td></tr>';
            ?>
        </table>
        <br/>
        <br/>
        
                
     <?php endforeach;?>
    </div>
</body>
</html>   