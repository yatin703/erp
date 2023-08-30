
<?php 
    
foreach ($specification as $specification_row):?>

    <div class="ui teal labels" style="text-align: center;">
      <div class="ui label">
        PAPER FILM
      </div>
    </div>

    <?php

        $arr=explode("^^^",$specification_row->dyn_qty_present);
        $arr1=explode("|",$arr[0]);
        $layers=$arr1[1];

    ?>

    <?php 
        echo($specification_row->final_approval_flag==1 ? '<span class="ui green right ribbon label">Approved</span>' : '<span class="ui red right ribbon label">Unapproved</span>');
    ?>

    <br/>

    <?php 
        echo ($this->common_model->view_date($specification_row->spec_created_date,$this->session->userdata['logged_in']['company_id'])!='' ? '<span class="ui blue left ribbon label">'.$this->common_model->view_date($specification_row->spec_created_date,$this->session->userdata['logged_in']['company_id']).'</span>' : '');
    ?>
    <br/>
    <br/>

    <!-- HEADER TABLE START........................-->

    <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
            
        <tr class="heading">
            <td width="10%"><b>PAPER FILM</b></td>
            <td width="5%"></td>
            <td width="35%"><?php echo $specification_row->article_no;?></b></td>
            <td width="10%"><b></b></td>
            <td width="5%"></td>
            <td width="35%"></td>
            
        </tr>
        <tr class="item">
            <td><b>CREATED BY</b></td>
            <td></td>
            <td><?php echo strtoupper($specification_row->username); ?></td>
            <td><b>APPROVED BY</b></td>
            <td></td>
            <td><?php echo (empty($specification_row->approval_username) ? '-' : strtoupper($specification_row->approval_username)); ?></td>
        </tr>
        
    </table>

    <!-- HEADER TABLE END........................-->

    <!-- VIEW TABLE START........................-->

    <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
        <tr class="heading">
            <td width="15%">PRODUCT</td>
            <td width="85%">
                <table cellpadding="0" cellspacing="0" border="0">
                    <tr class="heading">
                        <td width="19%">PARAMETER</td>
                        <td width="1%"></td>
                        <td width="15%">VALUE</td>
                        <td width="15%">CODE</td>
                    </tr>
                </table>
            </td>

        </tr>

        <!-- SHOULDER DETAILS END............................................-->

        <!-- CAP DETAILS END.................................................-->

        <tr class="item">
            <td width="15%"><b>PAPER FILM</b></td>
            <td width="85%">
                <table cellpadding="0" cellspacing="0" style="border:1px solid #ddd;">
                    <?php foreach($specification_shoulder_details as $specification_shoulder_details_row):?>
                        <tr>
                            <td width="19%">
                                <?php 
                                    if($specification_shoulder_details_row->parameter_name=='' && $specification_shoulder_details_row->material=='1'){

                                         $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$specification_shoulder_details_row->mat_article_no);
                                            foreach($data['article'] as $article_row){
                                                echo $article_row->sub_group;
                                            }
                                       
                                        
                                    }
                                    else{
                                        if($specification_shoulder_details_row->parameter_name=='DRAWING') continue;  
                                        echo $specification_shoulder_details_row->parameter_name;

                                    }
                                ?>      
                            </td>
                            <td width="1%"></td>
                            <td width="15%">
                                <?php 
                                    echo (empty($specification_shoulder_details_row->parameter_value)  ? $specification_shoulder_details_row->relating_master_value : $specification_shoulder_details_row->parameter_value);
                                ?>
                                
                            </td>
                            
                            <td width="15%">
                                <?php 
                                    echo $specification_shoulder_details_row->mat_article_no;

                                ?>
                                        
                            </td>
                        </tr>
                    <?php endforeach;?>
                </table>
            </td>
        </tr>
    </table>

<!-- VIEW TABLE END........................-->

<?php endforeach;?>

    <!-- APPROVAL/FOLLOWUP TABLE START........................-->

    <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
        <tr class="heading">
            <td colspan='6'>APPROVAL FOLLOWUPS</td>
        </tr>
        <tr class="heading">
            <td width="20%">SR NO</td>
            <td width="1%"></td>
            <td width="20%">DATE</td>
            <td width="20%">FROM</td>
            <td width="20%">TO</td>
            <td width="19%">STATUS</td>
        </tr>
        <?php 
            if($followup==FALSE){
                echo"<tr>
                        <td colspan='6'>NO RECORD FOUND</td>
                    </tr>";

            }else{
                foreach($followup as $followup_row){

                    echo "<tr class='item'>
                            <td>$followup_row->transaction_no</td>
                            <td></td>
                            <td>".$this->common_model->view_date($followup_row->followup_date,$this->session->userdata['logged_in']['company_id'])."</td>
                            <td>".strtoupper($followup_row->from_user)."</td>
                            <td>".strtoupper($followup_row->to_user)."</td>
                            <td>".($followup_row->status==99 ? 'SETTLED' : '')."
                                ".($followup_row->status==999 && $followup_row->approved_flag==1? 'APPROVED' : '')."
                                ".($followup_row->status==999 && $followup_row->approved_flag==2? 'REJECTED' : '')."
                                ".($followup_row->status==1 ? 'PENDING' : '')."</td>
                        </tr>";
                 }
            }
            ?>
    </table> 
    <!-- APPROVAL/FOLLOWUP TABLE END........................-->   

 


</div>
</body>
</html>
