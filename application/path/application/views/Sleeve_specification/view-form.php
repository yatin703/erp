
<?php foreach ($specification as $specification_row):?>

    <div class="ui teal labels" style="text-align: center;">
      <div class="ui label">
        SLEEVE
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
            <td width="10%"><b>SLEEVE NO</b></td>
            <td width="5%"></td>
            <td width="35%"><?php echo $specification_row->article_no;?></b></td>
            <td width="10%">SLEEVE NAME</td>
            <td width="5%"></td>
            <td width="35%"><?php echo $specification_row->article_name;?></td>
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
                        <td width="10%">%</td>
                        <td width="40%">RM</td>
                        <td width="15%">CODE</td>
                    </tr>
                </table>
            </td>

        </tr>
        <?php 
            // LAYER WISE TR GENERATION START-------------------------------------------

            for($i=1;$i<=$layers;$i++):

                $search=array();
                $search['spec_id']=$this->uri->segment(3);
                $search['spec_version_no']=$this->uri->segment(4);
                $search['item_group_id']='3'; 
                $search['parameter_name !=']='DRAWING'; 
                $search['layer_no']=$i;
                $order_by='srd_id'; 
                $sequence='asc';

                $specification_sheet_details_sleeve=$this->common_model->select_active_records_where_order_by('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$search,$order_by,$sequence);
                //echo $this->db->last_query();
                $count=count($specification_sheet_details_sleeve);
        ?>
                <tr class="item">
                    <td width="15%"><b>SLEEVE LAYER (<?php echo $i;?>)</b></td>
                    <td width="85%">
                        <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
                            <?php
                                foreach($specification_sheet_details_sleeve as $row){

                                    echo'<tr class="details">
                                            <td width="19%">';
                                                if($row->parameter_name!=''){
                                                    if($row->parameter_name=='PRINT TYPE' && $i!=1) continue;
                                                     echo $row->parameter_name;
                                                }else{
                                                    if($row->mat_article_no!=''){
                                                        $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$row->mat_article_no);
                                                        foreach($data['article'] as $article_row){
                                                            echo $article_row->sub_group;
                                                        } 
                                                    }
                                                    
                                                } 

                                            echo'</td>
                                            <td width="1%"></td>
                                            <td width="15%">'.($row->parameter_value!='' ?$row->parameter_value : $row->relating_master_value).'</td>
                                            <td width="10%">'.($row->mat_info!='' ? $row->mat_info."%" :'').'</td>
                                            <td width="40%">';

                                                if($row->mat_article_no!=''){

                                                    $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$row->mat_article_no);
                                                        foreach($data['article'] as $article_row){
                                                            echo $article_row->article_name;
                                                            echo $article_sub_description=( $article_row->article_sub_description!='' ? " [".$article_row->article_sub_description."]" : "");
                                                        } 

                                                        if($row->item_group_id==3 && $row->parameter_name=='MASTER BATCH'){

                                                            $data['supplier']=$this->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'adr_company_id',$row->supplier_no);
                                                            foreach($data['supplier'] as $supplier_row){
                                                                echo ' <b>['.$supplier_row->name1.']</b> ';
                                                            }

                                                        }


                                                }
                                               
                                            echo'</td>
                                            <td width="15%">'; 
                                                if($row->material=='1'){
                                                     echo $row->mat_article_no;
                                             }
                                            echo'</td>
                                    </tr>';

                                }

                            ?>
                            
                        </table>
                    </td>
                </tr>

            <?php 
                endfor; 
                // LAYER WISE TR GENERATION STOP-------------------------------------------
            ?>
        <!-- SHOULDER DETAILS START............................................-->

        
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
