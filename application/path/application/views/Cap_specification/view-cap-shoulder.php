
<?php foreach ($specification as $specification_row):?>

    <div class="ui teal labels" style="text-align: center;">
      <div class="ui label">
        CAP COMPONENT
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

    <br/>
    <br/>

    <!-- HEADER TABLE START........................-->

    <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
            
        <tr class="heading">
            <td width="10%"><b>CAP NO</b></td>
            <td width="5%"></td>
            <td width="35%"><?php echo $specification_row->article_no;?></td>
            <td width="10%"><b>CAP NAME</b></td>
            <td width="5%"></td>
            <td width="35%"><?php echo $specification_row->article_name; ?></td>
            
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

        <!-- SHOULDER DETAILS END............................................-->

        <!-- CAP DETAILS END.................................................-->

        <tr class="item">
            <td width="15%"><b>CAP</b>
                </br>
                </br>
                </br>

                <?php
                    $cap_height='';
                    $cap_image='';
                    $cap_drawing='';

                    $cap_type='';
                    $cap_type_id='';
                    $cap_finish='';
                    $cap_finish_id='';
                    $cap_dia='';
                    $cap_dia_id='';
                    $cap_orifice='';
                    $cap_orifice_id='';

                    foreach($specification_cap_details as $specification_cap_details_row){

                        if($specification_cap_details_row->parameter_name=='STYLE'){
                           $cap_type=($specification_cap_details_row->parameter_value==''?$specification_cap_details_row->relating_master_value:$specification_cap_details_row->parameter_value);

                           if($cap_type!=''){
                                $cap_types_master_result=$this->common_model->select_one_active_record('cap_types_master',$this->session->userdata['logged_in']['company_id'],'cap_type',$cap_type);
                                foreach($cap_types_master_result as $cap_types_master_row){
                                    $cap_type_id=$cap_types_master_row->cap_type_id;
                                }
                            } 
                        }
                        if($specification_cap_details_row->parameter_name=='MOLD FINISH'){
                           $cap_finish=($specification_cap_details_row->parameter_value==''?$specification_cap_details_row->relating_master_value:$specification_cap_details_row->parameter_value);

                           if($cap_finish!=''){
                                $cap_finish_master_result=$this->common_model->select_one_active_record('cap_finish_master',$this->session->userdata['logged_in']['company_id'],'cap_finish',$cap_finish);
                                foreach($cap_finish_master_result as $cap_finish_master_row){
                                    $cap_finish_id=$cap_finish_master_row->cap_finish_id;
                                }

                           } 


                        }
                        if($specification_cap_details_row->parameter_name=='DIAMETER'){
                           $cap_dia=($specification_cap_details_row->parameter_value==''?$specification_cap_details_row->relating_master_value:$specification_cap_details_row->parameter_value);

                           if($cap_dia!=''){
                                $cap_diameter_master_result=$this->common_model->select_one_active_record('cap_diameter_master',$this->session->userdata['logged_in']['company_id'],'cap_dia',$cap_dia);
                                foreach($cap_diameter_master_result as $cap_diameter_master_row){
                                    $cap_dia_id=$cap_diameter_master_row->cap_dia_id;
                                }
                            } 


                        }
                        if($specification_cap_details_row->parameter_name=='ORIFICE'){
                           $cap_orifice=($specification_cap_details_row->parameter_value==''?$specification_cap_details_row->relating_master_value:$specification_cap_details_row->parameter_value);

                           if($cap_orifice!=''){
                                $cap_orifice_master_result=$this->common_model->select_one_active_record('cap_orifice_master',$this->session->userdata['logged_in']['company_id'],'cap_orifice',$cap_orifice);
                                foreach($cap_orifice_master_result as $cap_orifice_master_row){
                                    $cap_orifice_id=$cap_orifice_master_row->cap_orifice_id;
                                }
                            } 


                        }

                    }

                    $data=array('cap_type_id' =>$cap_type_id,
                                'cap_dia_id'=>$cap_dia_id,
                                'cap_finish_id'=>$cap_finish_id,
                                'cap_orifice_id'=>$cap_orifice_id,
                                'archive'=>'0');
                    //echo print_r($data);

                    $shoulder_orifice_dependancy_result=$this->common_model->select_active_records_where('shoulder_orifice_dependancy',$this->session->userdata['logged_in']['company_id'],$data);

                   // echo $this->db->last_query();

                    foreach ($shoulder_orifice_dependancy_result as $shoulder_orifice_dependancy_row) {
                        $cap_height=$shoulder_orifice_dependancy_row->cap_height;
                        $cap_image=$shoulder_orifice_dependancy_row->cap_image;
                        $cap_drawing=$shoulder_orifice_dependancy_row->cap_drawing;
                    }


                ?>

                <?php if($cap_image!=''){?>
                  <img src="<?php echo base_url('assets/'.$this->session->userdata['logged_in']['company_id'].'/caps/'.$cap_image.'');?>" style='margin: 10px;' alt="Cap Name"  width="75">
                <?php }?>


                
                </br>
                </br>
                </br>

                <?php 
                //$cap_article_no=$specification_row->article_no;
                $supplier_no="";
                $data['alternative_supplier']=$this->common_model->select_one_active_record('alternative_supplier',$this->session->userdata['logged_in']['company_id'],'article_no',$specification_row->article_no);
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
                                    echo ($specification_cap_details_row->parameter_value==''  ? $specification_cap_details_row->relating_master_value : $specification_cap_details_row->parameter_value);
                                ?>
                                
                            </td>
                            <td width="10%"><?php echo ($specification_cap_details_row->mat_info!='' ? $specification_cap_details_row->mat_info."%" : '');?></td>
                            <td width="40%">
                                <?php 
                                    if(!empty($specification_cap_details_row->mat_article_no)){
                                        $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$specification_cap_details_row->mat_article_no);
                                        foreach($data['article'] as $article_row){
                                            echo $article_row->article_name;
                                            echo $article_sub_description=( $article_row->article_sub_description!='' ? " [".$article_row->article_sub_description."]" : "");
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
                    <tr><td>CAP HEIGHT</td><td></td><td colspan="4"><?php echo $this->common_model->read_number($cap_height,$this->session->userdata['logged_in']['company_id']); ?> MM</td></tr>
                    <tr><td>DRAWING</td><td></td><td><?php echo $cap_drawing;?></td></tr>
                </table>
            </td>
        </tr>

    </table>

<!-- VIEW TABLE END........................-->

<?php endforeach;?>

    <!-- APPROVAL/FOLLOWUP TABLE START........................-->




<?php 
    
foreach ($sspecification as $specification_row):?>
    <br/>
    <div class="ui teal labels" style="text-align: center;">
      <div class="ui label">
        SHOULDER
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

    <br/>
    <br/>

    <!-- HEADER TABLE START........................-->

    <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
            
        <tr class="heading">
            <td width="10%"><b>SHOULDER</b></td>
            <td width="5%"></td>
            <td width="35%"><?php echo $specification_row->article_no;?></b></td>
            <td width="10%"><b></b></td>
            <td width="5%"></td>
            <td width="35%"></td>
            
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
                        <td width="40%">RM</td>
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
                            <td width="40%">
                                <?php 
                                    if(!empty($specification_shoulder_details_row->mat_article_no)){
                                        $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$specification_shoulder_details_row->mat_article_no);
                                        foreach($data['article'] as $article_row){
                                            echo $article_row->article_name;
                                            echo $article_sub_description=( $article_row->article_sub_description!='' ? " [".$article_row->article_sub_description."]" : "");
                                        }

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
                        </tr>
                    <?php endforeach;?>
                </table>
            </td>
        </tr>
    </table>

<!-- VIEW TABLE END........................-->

<?php endforeach;?>

</div>
</body>
</html>

