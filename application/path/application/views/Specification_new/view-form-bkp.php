
<?php 

foreach ($specification as $specification_row):?>



        <?php echo $specification_row->final_approval_flag==1 ? '<span class="ui green right ribbon label">Approved</span>' : '<span class="ui red right ribbon label">Unapproved</span>';?>
        <br/>

        <?php echo $this->common_model->view_date($specification_row->spec_created_date,$this->session->userdata['logged_in']['company_id'])!='' ? '<span class="ui blue left ribbon label">'.$this->common_model->view_date($specification_row->spec_created_date,$this->session->userdata['logged_in']['company_id']).'</span>' : '';?>
        <br/>
        <br/>
        <table cellpadding="0" cellspacing="0">
            
            <tr class="heading">
                <td><b><?php echo strtoupper($this->router->fetch_class());?></b></td>
                <td>VERSION NO</td>
            </tr>
            
            <tr class="item">
                <td><b><?php echo $specification_row->spec_id;?></b></td>
                <td><b><?php echo $specification_row->spec_version_no;?></b></td>
            </tr>

            <tr class="item">
                <td>CUSTOMER</td>
                <td><?php echo $specification_row->customer_name;?>//<?php echo $specification_row->adr_company_id;?></td>
            </tr>

            <tr class="item">
                <td>ARTICLE</td>
                <td><?php echo $specification_row->article_name; ?>//<?php echo $specification_row->article_no;?></td>
            </tr>

            <tr class="item">
                <td>ARTWORK</td>
                <td><?php echo "<a href='".base_url('index.php/artwork/view/'.$specification_row->ad_id.'/'.$specification_row->version_no)."' target='_blank'>".$specification_row->ad_id; ?>//<?php echo $specification_row->version_no."</a>";?></td>
            </tr>

            <tr class="item">
                <td>CREATED BY</td>
                <td><?php echo strtoupper($specification_row->username); ?></td>
            </tr>

            <tr class="item">
                <td>APPROVED BY</td>
                <td><?php echo (empty($specification_row->approval_username) ? '-' : strtoupper($specification_row->approval_username)); ?></td>
            </tr>
            <tr class="item">
                <td>COMMENTS</td>
                <td><?php foreach ($specification_sheet_lang as $specification_sheet_lang_row) {
                   echo $specification_sheet_lang_row->lang_comments;
                } ?></td>
            </tr>

        </table>
        <table cellpadding="0" cellspacing="0" style="border:1px solid #ddd;">
            <tr class="heading">
                <td width="15%">PRODUCT</td>
                <td width="85%">
                    <table cellpadding="0" cellspacing="0" border="0">
                        <tr class="heading">
                            <td width="20%">PARAMETER</td>
                            <td></td>
                            <td width="10%">VALUE</td>
                            <td width="10%">%</td>
                            <td width="35%">RM</td>
                            <td width="25%">CODE</td>
                        </tr>
                    </table>
                </td>

            </tr>
            <tr class="item">
                <td width="15%">SLEEVE</td>
                <td width="85%">
                        <table cellpadding="0" cellspacing="0"  style="border:1px solid #ddd;">
                        <?php 

                        $i=1;
                        foreach($specification_sleeve_details as $specification_sleeve_details_row):?>

                            <?php if($specification_sleeve_details_row->layer_no>1){

                                if($specification_sleeve_details_row->parameter_name=='DIA' || $specification_sleeve_details_row->parameter_name=='LENGTH' || $specification_sleeve_details_row->parameter_name=='DRAWING' || $specification_sleeve_details_row->parameter_name=='PRINT TYPE'){
                                    echo '<tr><td colspan="5" style="border:0px solid #ddd;height:10px;"></td></tr>';
                                }else{
                                     ?>

                                     <tr class="details">
                                    <td width="20%"><?php if(empty($specification_sleeve_details_row->parameter_name)) {
                                    $data['article_group']=$this->sub_group_model->select_one_active_record('article_group',$this->session->userdata['logged_in']['company_id'],'article_group.article_group_id',$specification_sleeve_details_row->item_group_material);
                                        foreach($data['article_group'] as $article_group_row){
                                            echo $article_group_row->sub_group;
                                        }
                                    }else{
                                        echo $specification_sleeve_details_row->parameter_name;
                                    }?></td>
                                    <td></td>
                                    <td width="10%"><?php echo (empty($specification_sleeve_details_row->parameter_value)  ? $specification_sleeve_details_row->relating_master_value : $specification_sleeve_details_row->parameter_value);?></td>
                                    <td width="10%"><?php echo $specification_sleeve_details_row->mat_info;?></td>
                                    <td width="35%"><?php 
                                        if(!empty($specification_sleeve_details_row->mat_article_no)){
                                            $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$specification_sleeve_details_row->mat_article_no);
                                            foreach($data['article'] as $article_row){
                                                echo $article_row->article_name;
                                            }

                                        }?></td>
                                        <td width="25%"><?php echo $specification_sleeve_details_row->mat_article_no?></td>
                            </tr>

                                     <?php
                             }

                            }else{
                                ?>

                                <tr class="details">
                                <td width="20%"><?php if(empty($specification_sleeve_details_row->parameter_name)) {
                                    $data['article_group']=$this->sub_group_model->select_one_active_record('article_group',$this->session->userdata['logged_in']['company_id'],'article_group.article_group_id',$specification_sleeve_details_row->item_group_material);
                                        foreach($data['article_group'] as $article_group_row){
                                            echo $article_group_row->sub_group;
                                        }
                                    }else{
                                        echo $specification_sleeve_details_row->parameter_name;
                                    }?></td>
                                    <td></td>
                                    <td width="10%"><?php echo (empty($specification_sleeve_details_row->parameter_value)  ? $specification_sleeve_details_row->relating_master_value : $specification_sleeve_details_row->parameter_value);?></td>
                                    <td width="10%"><?php echo $specification_sleeve_details_row->mat_info;?></td>
                                    <td width="35%"><?php 
                                        if(!empty($specification_sleeve_details_row->mat_article_no)){
                                            $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$specification_sleeve_details_row->mat_article_no);
                                            foreach($data['article'] as $article_row){
                                                echo $article_row->article_name;

                                            }

                                        }
                                       

                                        ?></td>
                                        <td width="25%"><?php echo $specification_sleeve_details_row->mat_article_no;
                                         if(!empty($specification_sleeve_details_row->supplier_no) && $specification_sleeve_details_row->item_group_id==3){

                                            $data['supplier']=$this->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'adr_company_id',$specification_sleeve_details_row->supplier_no);
                                            foreach($data['supplier'] as $supplier_row){
                                                echo ' ['.$supplier_row->name1.'] ';

                                            }

                                        }
                                        ?></td>
                            </tr>

                                <?php
                            }
                            ?>

                            

                            
                        <?php 
                        
                        endforeach;?>
                        </table>
                    </td>
            </tr>
            
                <tr class="item">
                    <td width="15%">SHOULDER</td>
                    <td width="85%">
                        <table  cellpadding="0" cellspacing="0"  style="border:1px solid #ddd;">
                        <?php foreach($specification_shoulder_details as $specification_shoulder_details_row):?>
                            <tr><td width="20%"><?php if(empty($specification_shoulder_details_row->parameter_name)) {
                                    $data['article_group']=$this->sub_group_model->select_one_active_record('article_group',$this->session->userdata['logged_in']['company_id'],'article_group.article_group_id',$specification_shoulder_details_row->item_group_material);
                                        foreach($data['article_group'] as $article_group_row){
                                            echo $article_group_row->sub_group;
                                        }
                                    }else{
                                        echo $specification_shoulder_details_row->parameter_name;
                                    }?></td>
                                    <td></td>
                                    <td width="10%"><?php echo (empty($specification_shoulder_details_row->parameter_value)  ? $specification_shoulder_details_row->relating_master_value : $specification_shoulder_details_row->parameter_value);?></td>
                                    <td width="10%"><?php echo $specification_shoulder_details_row->mat_info;?></td>
                                    <td width="35%"><?php 
                                        if(!empty($specification_shoulder_details_row->mat_article_no)){
                                            $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$specification_shoulder_details_row->mat_article_no);
                                            foreach($data['article'] as $article_row){
                                                echo $article_row->article_name;
                                            }

                                        }?></td>
                                        <td width="25%"><?php echo $specification_shoulder_details_row->mat_article_no;
                                        if(!empty($specification_shoulder_details_row->supplier_no)&& $specification_shoulder_details_row->item_group_id==4){

                                            $data['supplier']=$this->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'adr_company_id',$specification_shoulder_details_row->supplier_no);
                                            foreach($data['supplier'] as $supplier_row){
                                                echo ' ['.$supplier_row->name1.'] ';
                                            }

                                        }
                                        ?></td>
                                    </tr>
                        <?php endforeach;?>
                        </table>
                    </td>
                </tr>
                <tr class="item">
                    <td width="15%">CAP</td>
                    <td width="85%">
                        <table cellpadding="0" cellspacing="0" style="border:1px solid #ddd;">
                        <?php foreach($specification_cap_details as $specification_cap_details_row):?>
                            <tr><td width="20%"><?php if(empty($specification_cap_details_row->parameter_name)) {
                                    $data['article_group']=$this->sub_group_model->select_one_active_record('article_group',$this->session->userdata['logged_in']['company_id'],'article_group.article_group_id',$specification_cap_details_row->item_group_material);
                                        foreach($data['article_group'] as $article_group_row){
                                            echo $article_group_row->sub_group;
                                        }
                                    }else{
                                        echo $specification_cap_details_row->parameter_name;
                                    }?></td>
                                    <td></td>
                                    <td width="10%"><?php echo (empty($specification_cap_details_row->parameter_value)  ? $specification_cap_details_row->relating_master_value : $specification_cap_details_row->parameter_value);?></td>
                                    <td width="10%"><?php echo $specification_cap_details_row->mat_info;?></td>
                                    <td width="35%"><?php 
                                        if(!empty($specification_cap_details_row->mat_article_no)){
                                            $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$specification_cap_details_row->mat_article_no);
                                            foreach($data['article'] as $article_row){
                                                echo $article_row->article_name;
                                            }

                                        }
                                        ?></td>
                                        <td width="25%"><?php echo $specification_cap_details_row->mat_article_no;
                                            if($specification_cap_details_row->item_group_id==5 && $specification_cap_details_row->parameter_name=='MASTER BATCH'){    
                                                if( !empty($specification_cap_details_row->supplier_no)){

                                                    $data['supplier']=$this->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'adr_company_id',$specification_cap_details_row->supplier_no);
                                                    foreach($data['supplier'] as $supplier_row){
                                                        echo ' ['.$supplier_row->name1.'] ';
                                                      
                                                    }

                                                }
                                        }
                                        ?></td>
                                    </tr>
                        <?php endforeach;?>
                        </table>
                    </td>
                </tr>
        </table>

        <?php endforeach;?>

        <table cellpadding="0" cellspacing="0">
            <tr class="heading">
                <td colspan='6'>APPROVAL FOLLOWUPS</td>
            </tr>
            <tr class="heading">
                <td>SR NO</td>
                <td></td>
                <td>DATE</td>
                <td>FROM</td>
                <td>TO</td>
                <td>STATUS</td>
            </tr>
            <?php 
                if($followup==FALSE){
                    echo "<tr>
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

        
    </div>
</body>
        
  
</html>
