


    <div class="ui teal labels" style="text-align: center;">
      <div class="ui label">
        BILL OF MATERIAL
      </div>
    </div>
     <?php foreach ($bill_of_material as $bill_of_material_row):?>

    

    <?php 
        echo($bill_of_material_row->final_approval_flag==1 ? '<span class="ui green right ribbon label">Approved</span>' : '<span class="ui red right ribbon label">Unapproved</span>');
    ?>

    <br/>

    <?php 
        echo ($this->common_model->view_date($bill_of_material_row->bom_creation_date,$this->session->userdata['logged_in']['company_id'])!='' ? '<span class="ui blue left ribbon label">'.$this->common_model->view_date($bill_of_material_row->bom_creation_date,$this->session->userdata['logged_in']['company_id']).'</span>' : '');
    ?>
    <br/>
    <br/>

    <!-- HEADER TABLE START........................-->

    <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
        
       
        <tr class="heading">
            <td width="10%"><b>BOM NO</b></td>
            <td width="5%"></td>
            <td width="35%"><?php echo $bill_of_material_row->bom_no."_".$bill_of_material_row->bom_version_no;?></b></td>
            <td width="10%">COMPONETS</td>
            <td width="5%"></td>
            <td width="35%">
                <div class="mini">
                <?php echo "<div  class='ui'>".$bill_of_material_row->sleeve_code."</div>";?>
                <?php echo "<div class='ui'>".$bill_of_material_row->shoulder_code."</div>";?>
                <?php echo "<div class='ui '>".$bill_of_material_row->label_code."</div>";?>
                <?php echo "<div class='ui'>".$bill_of_material_row->cap_code."</div>";?>
                </div>
            </td>
        </tr>

        <tr class="item">
            <td width="10%"><b>PRODUCT NO</b></td>
            <td width="5%"></td>
            <td width="35%"><b><?php echo $bill_of_material_row->article_no;?></b></td>
            <td width="10%"><b>PRODUCT NAME</b></td>
            <td width="5%"></td>
            <td width="35%"><b><?php echo strtoupper($this->common_model->get_article_name($bill_of_material_row->article_no,$this->session->userdata['logged_in']['company_id']));?></b></td>
        </tr>

        <tr class="item">
            <td><b>CREATED BY</b></td>
            <td></td>
            <td><?php echo strtoupper($bill_of_material_row->username); ?></td>
            <td><b>APPROVED BY</b></td>
            <td></td>
            <td><?php echo (empty($bill_of_material_row->approval_username) ? '-' : strtoupper($bill_of_material_row->approval_username)); ?></td>
        </tr>

        <tr class="item">
            <td><b>PRINT TYPE</b></td>
            <td></td>
            <td><?php echo strtoupper($bill_of_material_row->print_type); ?></td>
             <td><b>BOX TYPE</b></td>
            <td></td>
            <td><?php echo ($bill_of_material_row->for_export==1 ? "EXPORT":"DOMESTIC"); ?></td>
        </tr>

        <tr class="item">
            <td><b>COMMENT</b></td>
            <td></td>
            <td colspan="4"><?php echo strtoupper($bill_of_material_row->comment); ?></td>
            </tr>

    <?php endforeach;?>

    </table>

    <!-- HEADER TABLE END........................-->

    <!-- VIEW TABLE START........................-->
    

       
    <?php foreach ($sleeve_specification as $sleeve_specification_row):?>

    <?php

        $arr=explode("^^^",$sleeve_specification_row->dyn_qty_present);
        $arr1=explode("|",$arr[0]);
        $layers=$arr1[1];

    ?>

    <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
        <tr class="heading">
            <td width="15%"><?php echo $sleeve_specification_row->article_no;?></td>
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
                $search['spec_id']=$sleeve_specification_row->spec_id;
                $search['spec_version_no']=$sleeve_specification_row->spec_version_no;
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
                                            <td width="10%">'.($row->mat_article_no!='' ? $row->mat_info."%" :'').'</td>
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


    <?php foreach($shoulder_specification as $shoulder_specification_row):?>

    <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
        <tr class="heading">
            <td width="15%"><?php echo $shoulder_specification_row->article_no;?></td>
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

        <!-- SHOULDER DETAILS END............................................-->

        <!-- CAP DETAILS END.................................................-->

        <tr class="item">
            <td width="15%"><b>SHOULDER</b></td>
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
                                        if($specification_shoulder_details_row->parameter_name=='PEEL OFF TE') continue;  
                                        echo $specification_shoulder_details_row->parameter_name;

                                    }
                                ?>      
                            </td>
                            <td width="1%"></td>
                            <td width="15%">
                                <?php 
                                    echo (empty($specification_shoulder_details_row->parameter_value)  ? $specification_shoulder_details_row->relating_master_value : $specification_shoulder_details_row->parameter_value);
                                
                                    if($specification_shoulder_details_row->parameter_name=='SHOULDER FOIL TAG' && $specification_shoulder_details_row->parameter_value=="" && $specification_shoulder_details_row->relating_master_value=="" && $specification_shoulder_details_row->mat_article_no==""){

                                            echo "<i>NA</i>";
                                        
                                        }

                                        if($specification_shoulder_details_row->parameter_name=='PEEL OFF TE' && $specification_shoulder_details_row->parameter_value=="" && $specification_shoulder_details_row->relating_master_value=="" && $specification_shoulder_details_row->mat_article_no==""){

                                            echo "<i>NA</i>";
                                        
                                        }

                                        /*
                                        if($specification_shoulder_details_row->item_group_id==4 && $specification_shoulder_details_row->parameter_name=='PEEL OFF TE'){
                                            echo "NA";
                                        }
                                        */
                                ?>
                                
                            </td>
                            <td width="10%"><?php echo ($specification_shoulder_details_row->mat_info!='' ? $specification_shoulder_details_row->mat_info."%" : '');?></td>
                            <td width="40%">
                                <?php 
                                    if(!empty($specification_shoulder_details_row->mat_article_no)){
                                        $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$specification_shoulder_details_row->mat_article_no);
                                        foreach($data['article'] as $article_row){
                                            echo $article_row->article_name;
                                        }

                                    }else{

                                    }

                                    if($specification_shoulder_details_row->item_group_id==5 && $specification_shoulder_details_row->parameter_name=='MASTER BATCH'){
                                        
                                        if(!empty($specification_shoulder_details_row->supplier_no)){

                                            $data['supplier']=$this->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'adr_company_id',$specification_shoulder_details_row->supplier_no);
                                            foreach($data['supplier'] as $supplier_row){
                                                echo ' <b>['.$supplier_row->name1.']</b> ';
                                              
                                            }

                                        }
                                    }

                                    
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

<?php endforeach;?>

<?php 

if(empty($bill_of_material_row->label_code)){

}else{
    if(!empty($bill_of_material_row->label_code)){
    foreach($label_specification as $label_specification_row){ ?>

    <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
        <tr class="heading">
            <td width="15%"><?php echo $label_specification_row->article_no;?></td>
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

        <!-- SHOULDER DETAILS END............................................-->

        <!-- CAP DETAILS END.................................................-->

        <tr class="item">
            <td width="15%"><b>LABEL</b></td>
            <td width="85%">
                <table cellpadding="0" cellspacing="0" style="border:1px solid #ddd;">
                    <?php foreach($specification_label_details as $specification_label_details_row):?>
                        <tr>
                            <td width="19%">
                                <?php 
                                    if($specification_label_details_row->parameter_name=='' && $specification_label_details_row->material=='1'){

                                         $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$specification_label_details_row->mat_article_no);
                                            foreach($data['article'] as $article_row){
                                                echo $article_row->sub_group;
                                            }
                                       
                                        
                                    }
                                    else{
                                        if($specification_label_details_row->parameter_name=='DRAWING') continue;  
                                        echo $specification_label_details_row->parameter_name;

                                    }
                                ?>      
                            </td>
                            <td width="1%"></td>
                            <td width="15%">
                                <?php 
                                    echo (empty($specification_label_details_row->parameter_value)  ? $specification_label_details_row->relating_master_value : $specification_label_details_row->parameter_value." MM");
                                ?>
                                
                            </td>
                            <td width="10%"><?php echo ($specification_label_details_row->mat_info!='' ? $specification_label_details_row->mat_info."%":'');?></td>
                            <td width="40%">
                                <?php 
                                    if(!empty($specification_label_details_row->mat_article_no)){
                                        $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$specification_label_details_row->mat_article_no);
                                        foreach($data['article'] as $article_row){
                                            echo $article_row->article_name;
                                        }

                                    }

                                    if($specification_label_details_row->item_group_id==5 && $specification_label_details_row->parameter_name=='MASTER BATCH'){
                                        
                                        if(!empty($specification_label_details_row->supplier_no)){

                                            $data['supplier']=$this->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'adr_company_id',$specification_label_details_row->supplier_no);
                                            foreach($data['supplier'] as $supplier_row){
                                                echo ' <b>['.$supplier_row->name1.']</b> ';
                                              
                                            }

                                        }
                                    }
                                ?>
                                        
                            </td>
                            <td width="15%">
                                <?php 
                                    echo $specification_label_details_row->mat_article_no;

                                ?>
                                        
                            </td>
                        </tr>
                    <?php endforeach;?>
                </table>
            </td>
        </tr>
    </table>
<?php }
}
}
?>
    
    <?php 
    if(!empty($cap_specification)){
    foreach($cap_specification as $cap_specification_row):?>
    <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
        <tr class="heading">
            <td width="15%"><?php echo $cap_specification_row->article_no;?></td>
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

        <!-- SHOULDER DETAILS END............................................-->

        <!-- CAP DETAILS END.................................................-->

        <tr class="item">
            <td width="15%"><b>CAP</b>
                <?php 
                //$cap_article_no=$specification_row->article_no;
                $supplier_no="";
                $data['alternative_supplier']=$this->common_model->select_one_active_record('alternative_supplier',$this->session->userdata['logged_in']['company_id'],'article_no',$cap_specification_row->article_no);
                foreach ($data['alternative_supplier'] as $alternative_supplier_row) {
                    $supplier_no=$alternative_supplier_row->supplier_no;
                }
                if($supplier_no!=""){

                    $data['supplier']=$this->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'adr_company_id',$supplier_no);
                    foreach($data['supplier'] as $supplier_row){
                        echo ' <br>SUPPLIER NAME:- <i>'.$supplier_row->name1.'</i> ';
                      
                    }
                }

                ?>
            </td>
            <td width="85%">
                <table cellpadding="0" cellspacing="0" style="border:1px solid #ddd;">
                    <?php foreach($specification_cap_details as $specification_cap_details_row):?>
                        <tr>
                            <td width="19%">
                                <?php 
                                    if($specification_cap_details_row->parameter_name=='' && $specification_cap_details_row->material=='1'){

                                         $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$specification_cap_details_row->mat_article_no);
                                            foreach($data['article'] as $article_row){
                                                echo $article_row->sub_group;
                                            }
                                       
                                        
                                    }
                                    else{
                                        if($specification_cap_details_row->parameter_name=='DRAWING') continue;  
                                        echo $specification_cap_details_row->parameter_name;

                                    }
                                ?>      
                            </td>
                            <td width="1%"></td>
                            <td width="15%">
                                <?php 
                                //empty($specification_cap_details_row->parameter_value)
                                    echo ($specification_cap_details_row->parameter_value=='' ? $specification_cap_details_row->relating_master_value : $specification_cap_details_row->parameter_value);
                                
                                   if($specification_cap_details_row->parameter_name=='METALIZATION' && $specification_cap_details_row->parameter_value=="" && $specification_cap_details_row->relating_master_value=="" && $specification_cap_details_row->mat_article_no==""){

                                            echo "<i>NA</i>";
                                        
                                        }

                                    if($specification_cap_details_row->parameter_name=='CAP FOIL WIDTH' && $specification_cap_details_row->parameter_value=="" && $specification_cap_details_row->relating_master_value=="" && $specification_cap_details_row->mat_article_no==""){

                                            echo "<i>NA</i>";
                                        
                                        }

                                    if($specification_cap_details_row->parameter_name=='C.FOIL DIST FROM BOT' && $specification_cap_details_row->parameter_value=="" && $specification_cap_details_row->relating_master_value=="" && $specification_cap_details_row->mat_article_no==""){

                                            echo "<i>NA</i>";
                                        
                                        }

                                        if($specification_cap_details_row->parameter_name=='SHRINK SLEEVE' && $specification_cap_details_row->parameter_value=="" && $specification_cap_details_row->relating_master_value=="" && $specification_cap_details_row->mat_article_no==""){

                                            echo "<i>NA</i>";
                                        
                                        }

                                        if($specification_cap_details_row->parameter_name=='CAP FOIL COLOR' && $specification_cap_details_row->parameter_value=="" && $specification_cap_details_row->relating_master_value=="" && $specification_cap_details_row->mat_article_no==""){

                                            echo "<i>NA</i>";
                                        
                                        }


                                ?>
                                
                            </td>
                            <td width="10%"><?php echo ($specification_cap_details_row->mat_info!='' ? $specification_cap_details_row->mat_info."%":'');?></td>
                            <td width="40%">
                                <?php 
                                    if(!empty($specification_cap_details_row->mat_article_no)){
                                        $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$specification_cap_details_row->mat_article_no);
                                        foreach($data['article'] as $article_row){
                                            echo $article_row->article_name;
                                        }

                                    }

                                    if($specification_cap_details_row->item_group_id==5 && $specification_cap_details_row->parameter_name=='MASTER BATCH'){
                                        
                                        if(!empty($specification_cap_details_row->supplier_no)){

                                            $data['supplier']=$this->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'adr_company_id',$specification_cap_details_row->supplier_no);
                                            foreach($data['supplier'] as $supplier_row){
                                                echo ' <b>['.$supplier_row->name1.']</b> ';
                                              
                                            }

                                        }
                                    }
                                ?>
                                        
                            </td>
                            <td width="15%">
                                <?php 
                                    echo $specification_cap_details_row->mat_article_no;

                                ?>
                                        
                            </td>
                        </tr>
                    <?php endforeach;?>
                </table>
            </td>
        </tr>
    </table>

<?php endforeach;

    }

?>




<!-- VIEW TABLE END........................-->

<?php endforeach;

?>

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
