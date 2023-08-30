 
<?php foreach ($capa_complaint_register_master as $row):
    $article_no='';
    $article_array=explode(",", $row->article_no);
    if(count($article_array)>0){
        $article_no=$article_array[0];
    }

?>            
    <div class="ui teal labels" style="text-align: center;">
      <div class="ui label">
        CORRECTIVE ACTION REPORT
      </div>
    </div>

    <br/>

    <!-- <?php  
        echo'<span class="ui green right ribbon label"><b>'.$row->complaint_no.'</b></span>';
    ?> -->


    <?php echo $this->common_model->view_date($row->email_date,$this->session->userdata['logged_in']['company_id'])!='' ? '<span class="ui blue left ribbon label"><i class="calendar alternate outline icon"></i>'.$this->common_model->view_date($row->email_date,$this->session->userdata['logged_in']['company_id']).'</span>' : '';?>
    <br/>

    <?php  
         
        if($row->complaint_status=='1'){
            echo'<span class="ui green right ribbon label"><b>ACCEPTED</b></span>';
        }
        else if($row->complaint_status=='2'){
            echo'<span class="ui blue right ribbon label"><b>OBSERVATION</b></span>';
        }
        else if($row->complaint_status=='0'){            
            echo'<span class="ui red right ribbon label"><b>REJECTED</b></span>';
        }
        else{
            echo "";
        }

    ?> 

    <br/>
    <br/>

    <table>
        <tr class="heading" style="border:1px solid #D9d9d9;">
            <td colspan='7' style="border:1px solid #D9d9d9;text-align:center;">CATEGORY OF POTENTIAL NON-CONFORMITY: Product / Process / System / Customer complaint / Customer feedback</td>
        </tr> 
    </table>
    <br/>

    <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            
            
        
            <tr class="heading">
                <td width="15%"><b>CUSTOMER</b></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="30%" style="border-right:1px solid #D9d9d9;"><?php echo $this->common_model->get_parent_name($article_no,$this->session->userdata['logged_in']['company_id']);?></td>
                
                <td width="15%"><b>PRODUCT CODE</b></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="30%">
                    <?php 
                    if(count($article_array)>0){
                        foreach ($article_array as $key => $article_no) {
                            echo $article_no; 
                            echo " ";
                        }
                    }                    
                    ?>                        
                </td>
            </tr>

            <tr class="item">
                <td><b>PRODUCT NAME</b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td colspan='4' ><?php 
                    if(count($article_array)>0){
                        foreach ($article_array as $key => $article_no) {
                            echo $this->common_model->get_article_name($article_no,$this->session->userdata['logged_in']['company_id']); 
                            echo ",";
        
                        }
                    }                    
                    ?></td>
            </tr>
            <tr class="item">
                <td><b>REF NO</b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $row->reference_no;?></td>
                <td><b>REF QUANTITY</b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $row->qty; ?> <i>Nos</i></td>                
            </tr>
            <tr class="item">
                <td><b>DEFECTIVE TUBES</b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $row->defective_tubes;?> <i>Nos</i></td>
                <td><b>TUBES HOLD / CHECKED</b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $row->tubes_hold_checked;?> <i>Nos</i></td>
                
            </tr>
            <tr class="item">
                <td><b>CLAIM INSPECTION</b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($row->claim_inspection==1? 'INCOMING':'ONLINE');?></td>
                <td><b>EVIDENCE</b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><?php
                    $evidence_array=explode(",",$row->images);
                    if(count($evidence_array)>0){
                        foreach ($evidence_array as $key => $image_name) {
                            echo ($image_name!='' ? '<a href="'.base_url('assets/'.$this->session->userdata['logged_in']['company_id'].'/complaints/'.$image_name.'').'" target="_blank"><i class="file pdf outline icon"></i></a>' :'');
                            echo'&nbsp';
                        }
                    }
                    
                 ?></td>
            </tr>

            
            <tr class="item">
                <td><b>NO OF PALLETS</b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $row->pallets;?></td>
                <td><b>NO OF BOXES</b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $row->boxes;?></td>
                
            </tr>
            <tr class="item">
                <td><b>COMPLAINT NATURE</b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td colspan="4" style="border-right:1px solid #D9d9d9;"><?php echo "<a class='ui mini red label'>".$row->complaint_nature."</a>"; ?></td>
                
            </tr>

            <tr class="item">
                <td><b>COMMENT</b></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td colspan="4" style="border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;"><?php echo $row->comment;?></td> 
            </tr>

            <?php 
                if($row->complaint_source=='0'){
                        echo'<tr>
                        <td><b>SHIFT</b></td>
                        <td style="border-right:1px solid #D9d9d9;"></td>
                        <td style="border-right:1px solid #D9d9d9;">'.$row->shift.'</td>
                        <td><b>MACHINE/RESP PERSON</b></td>
                        <td style="border-right:1px solid #D9d9d9;"></td>
                        <td style="border-right:1px solid #D9d9d9;">'.$row->machine.'/'.$row->operator.'</td>
                    </tr>';        
                }

            ?>

        
    </table>
    </br>


    <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">    
        <tr class="heading">
            <td colspan='7'>NON-CONFORMITY DETAILS</td>
        </tr>
        <tr style="border-right:1px solid #D9d9d9;">
            <td colspan='7'>

                <br><p><?php echo $row->investigation; ?></p><br>

            </td>
        </tr>
    </table>
    <br>
       
    <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
        <tr class="heading">
            <td colspan='7'>INVESTIGATION / ROOT CAUSE</td>
        </tr>
        <tr style="border-right:1px solid #D9d9d9;" >
            <td colspan='7'>
                <br><p><?php echo $row->root_cause; ?></p><br>
            </td>
        </tr>
    </table>  
    </br>        
    <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
        <tr class="heading">
            <td colspan='7'>CORRECTIVE ACTION <i> [Action on cause of detected non-conformity to avoid recurrence] </i></td>
        </tr>
        <tr style="border-right:1px solid #D9d9d9;">
            <td colspan='7'>
                <br/><p><?php echo $row->corrective_action;?></p><br/>
            </td>
        </tr>
        <tr class="heading">
            <td>RESPONSIBILITY <i>QA /PRODUCTION / MAINTENANCE</i></td>
            <td style="border-right:1px solid #D9d9d9">TARGET  DATE <?php echo $this->common_model->view_date($row->corrective_action_date,$this->session->userdata['logged_in']['company_id']); ?></td>
        </tr>
    </table>
    
    <br/>
        
    <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
        <tr class="heading">
            <td colspan='7'>PREVENTIVE  ACTION <i>[Action on cause of detected non-conformity to avoid  Occurrences] </i></td>
        </tr>
        <tr style="border-right:1px solid #D9d9d9;">
            <td colspan='7'>
                <br><p><?php echo $row->preventive_action; ?></p><br>
            </td>
        </tr> 

        <tr class="heading">
            <td>RESPONSIBILITY <i> QA /PRODUCTION / MAINTENANCE </i></td>
            <td style="border-right:1px solid #D9d9d9">TARGET DATE <?php echo $this->common_model->view_date($row->preventive_action_date,$this->session->userdata['logged_in']['company_id']); ?></td>
        </tr>   
    </table> 
    </br>

    <?php if($row->is_training_provided==1){?>


        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            <tr>
                <td width="20%"><b>TRAINING PROVIDED</b></td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="15%" style="border-right:1px solid #D9d9d9;"><?php echo ($row->is_training_provided==1 ? "<a class='ui mini green label'>YES</a>" : "<a class='ui mini red label'>NO</a>");?></td>
                <td width="20%" style="border-right:1px solid #D9d9d9;"><b><i class="calendar outline icon"></i>TRAINING DATE</b></td>
                <td width="20%" style="border-right:1px solid #D9d9d9;">
                    <?php echo ($row->training_date!='' ? $this->common_model->view_date($row->training_date,$this->session->userdata['logged_in']['company_id']):"");?>
                </td>
                <td width="15%">
                    <?php echo ($row->training_docs!='' ? '<a href="'.base_url('assets/'.$this->session->userdata['logged_in']['company_id'].'/complaints/'.$row->training_docs.'').'" target="_blank"><i class="file pdf outline icon"></i></a>' :'');?>
                </td>
            </tr>
        </table> 
        </br>
    <?php }?>    

    
    <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
        <tr class="heading">
            <td colspan='7'>TIME SCALE FOR VERIFICATION OF EFFECTIVENESS</td>
        </tr>
        <tr style="border-right:1px solid #D9d9d9;">
            <td colspan='7'>
                <br><p><?php echo $row->verification_of_effectiveness;?></p><br></td>
        </tr> 

        <tr class="heading">
            <td colspan='7'>EFFECTIVENESS OF ACTION TAKEN</td>
        </tr>
        <tr style="border-right:1px solid #D9d9d9;">
            <td colspan='7'>
                <br><p><?php echo $row->effectiveness_action_taken;?></p><br></td>
        </tr>   
    </table> 
    </br>




    <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">               
        <tr class="heading">
            <td width="49%">PREPARED BY</td>
            <td width="2%" style="border-right:1px solid #D9d9d9;"></td>             
            <td width="49%">APPROVED BY</td>                
            
        </tr>
        <tr >
            <td>
                <?php echo $this->common_model->get_user_name($row->qc_name,$this->session->userdata['logged_in']['company_id']);?></td>
            <td style="border-right:1px solid #D9d9d9;"></td>
            <td></td>
             
        </tr>
    </table>


 

  
                
    <?php endforeach;?>


    </div>
</body>
</html>   