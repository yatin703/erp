<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

    $(document).ready(function(){

        $(".invoice-box").css("max-width", "1300px");
    });
 </script>
 <style type="text/css">
        table{
            border:1px solid #D9d9d9;

        }
</style>  

<?php foreach ($springtube_daily_plates_master as $springtube_daily_plates_master_row):?>
   <?php 
        $customer_name='';
        $article_desc='';
    
        $result_artwork=$this->artwork_springtube_model->select_one_active_record('springtube_artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'ad_id',$springtube_daily_plates_master_row->artwork_no,'version_no',$springtube_daily_plates_master_row->version_no);

        foreach ($result_artwork as $artwork_row) {
            $customer_name=$artwork_row->customer_name;
            $article_desc=$artwork_row->article_name;
        }

    ?>
    
    <div class="ui teal labels" style="text-align: center;">
      <div class="ui label">
        SPRINGTUBE PLATE DETAILS
      </div>
    </div>

        <!-- <?php echo $springtube_daily_plates_master_row->final_approval_flag==1 ? '<span class="ui green right ribbon label"><i class="check circle icon"></i> Approved</span>' : '<span class="ui red right ribbon label">Unapproved</span>';?> -->

        <br/>

        <?php echo $this->common_model->view_date($springtube_daily_plates_master_row->dpr_date,$this->session->userdata['logged_in']['company_id'])!='' ? '<span class="ui blue left ribbon label"><i class="calendar alternate outline icon"></i>'.$this->common_model->view_date($springtube_daily_plates_master_row->dpr_date,$this->session->userdata['logged_in']['company_id']).'</span>' : '';?>
        <br/>
        <br/>

        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            
            <tr class="heading" style="border-right:1px solid #D9d9d9;" >
                <td width="10%">CUSTOMER</td>
                <td width="5%"></td>
                <td width="5%"><b>ORDER NO</b></td>                
                <td width="5%"><b>ARTICLE NO</b></td>
                <td width="10%"><b>ARTICLE NAME</b></td>
                <td width="5%"><b>JOBCARD NO</b></td>
                <td width="5%"><b>ARTWORK NO</b></td>
                
                
            </tr>
        
            <tr class="item last">
                <td><?php echo $customer_name ;?></td>
                <td></td>
                <td><?php echo $springtube_daily_plates_master_row->order_no ;?></td>                
                <td><?php echo $springtube_daily_plates_master_row->article_no ;?></td> 
                <td><?php echo $article_desc ;?></td>               
                <td><?php echo $springtube_daily_plates_master_row->jobcard_no ;?></td>
                <td><?php echo $springtube_daily_plates_master_row->artwork_no.'R_ '.$springtube_daily_plates_master_row->version_no ;?></td>
                
            </tr>
        </table>


        
        <br/>

        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            
            <tr class="heading" style="border-right:1px solid #D9d9d9;" >
                <td width="10%">COMMENT</td>
                <td width="5%"></td>

                <td width="5%"><b>UPS</b></td>
                <td width="5%"><b>REPEAT</b></td>                
                <td width="10%"><b>REASON</b></td>                
                <td width="5%">SHIFT</td>
                <td width="5%">PLATE MAKER</td>
                
            </tr>
        
            <tr class="item last">
                <td><?php echo $springtube_daily_plates_master_row->comment ;?></td>
                <td></td>
                <td><?php echo $springtube_daily_plates_master_row->ups ;?></td>                
                <td><?php echo ($springtube_daily_plates_master_row->repeat);?></td> 
                <td><?php echo $springtube_daily_plates_master_row->reason ;?></td>             
                <td><?php echo $springtube_daily_plates_master_row->shift_id ;?></td>
                <td width="5%"><?php echo $springtube_daily_plates_master_row->user_id ;?></td>
                
            </tr>

        </table>       

       
        <br/>
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            
            <tr class="heading" style="border-right:1px solid #D9d9d9;" >
                <td width="10%">SR NO</td>
                <td width="5%"></td>
                <td width="5%"><b>PLATE TYPE</b></td>
                <td width="5%"><b>PANTONE</b></td>                
                <td width="10%"><b>DATE ON PLATE</b></td>                
                <td width="5%"><b>LABLE ON PLATE</b></td>
                <td width="5%"><b>NO. OF PLATES</b></td>
            </tr>
            <?php
            $i=1;
            $sum_of_plates=0;
                foreach ($springtube_daily_plates_details as  $details_row) {

                    $sum_of_plates+=$details_row->no_of_plates;
                    echo '<tr class="item last">
                        <td>'.$i++.'</td>
                        <td></td>
                        <td>Flexo </td>                        
                        <td>'.$details_row->pantone_name.'</td>                
                        <td>'.$details_row->date_on_plate.'</td> 
                        <td>'.$details_row->label_on_plate.'</td>               
                        <td>'.$details_row->no_of_plates.'</td>';
                }
                echo'</tr>
                <tr class="heading" style="border-right:1px solid #D9d9d9;"><td colspan="5" width="50%">TOTAL</td><td width="5%"></td><td width="5%">'.$sum_of_plates.'</td></tr>';
            ?>
        </table>
        <br/>
        <br/>
        
                
     <?php endforeach;?>
    </div>
</body>
</html>   