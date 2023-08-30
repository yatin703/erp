
<?php 
    if($production==FALSE){
                    echo "<tr><td colspan='7'>No Records Found</td></tr>";
    }
    else{
            foreach ($production as $production_row)
            {    
                // Instanciating Models--------------------------------------
                    $spec_id=$this->uri->segment(4);
                    $spec_version_no=$this->uri->segment(5);
                    $ci =&get_instance();
                    $ci->load->model('common_model');
                    $ci->load->model('sales_order_book_model');
                    $ci->load->model('article_model');
                    $ci->load->model('customer_model');

                //---------------------------------------------------------------
                $jobcard_no=$this->uri->segment(3);
                $spec_id=$this->uri->segment(4);
                $spec_version_no=$this->uri->segment(5);
                $artwork_no='';
                $artwork_version='';
                $spec_sheet_comment='';
                $jobcard_qty= $ci->common_model->read_number($production_row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']);
                $order_no=$production_row->sales_ord_no;
                $user_name=$ci->common_model->get_user_name($production_row->employee_id,$this->session->userdata['logged_in']['company_id']);
                $order_date='';
                $customer_name='';
                $adr_company_id='';
                $article_no='';
                $article_name='';

                $sleeve_dia='';
                $sleeve_length='';
                $sleeve_master_batch='';
                $sleeve_master_batch_desc='';

                $shoulder_neck_type='';
                $shoulder_orifice='';
                $shoulder_master_batch='';
                $shoulder_master_batch_desc='';
                $shoulder_foil_tag='';

                $cap_dia='';
                $cap_style='';
                $cap_mold_finish='';
                $cap_orifice='';
                $cap_master_batch='';
                $cap_master_batch_desc='';
                $cap_foil_color='';
                $cap_foil_width='';
                $cap_foil_dist_from_bot='';


                //Specification Sheet result------------------
                    $specification_result=$this->specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$spec_id,'specification_sheet.spec_version_no',$spec_version_no);
                    foreach($specification_result as $specification_row){

                        $customer_name=$specification_row->customer_name;
                        $adr_company_id=$specification_row->adr_company_id;
                        $article_no=$specification_row->article_no;
                        $article_name=$specification_row->article_name;
                        $artwork_no=$specification_row->ad_id;
                        $artwork_version=$specification_row->version_no;

                    }

                 //Specification Sheet Lang--------------------
                    $spec_lang=array();
                    $spec_lang['spec_id']=$spec_id;
                    $spec_lang['spec_version_no']=$spec_version_no;

                  $specification_result_lang=$this->common_model->select_active_records_where('specification_sheet_lang',$this->session->userdata['logged_in']['company_id'],$spec_lang);
                    foreach($specification_result_lang as $specification_result_lang_row){

                        $spec_sheet_comment=$specification_result_lang_row->lang_comments;
                        

                    }


                // 
                $search=array();
                $search['spec_id']=$spec_id;
                $search['spec_version_no']=$spec_version_no;

                $specification_details_result=$this->sales_order_book_model->select_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$search);

                    foreach($specification_details_result as $specification_details_row){

                        $sleeve_dia=$specification_details_row->SLEEVE_DIA;
                        $sleeve_length=$specification_details_row->SLEEVE_LENGTH;
                        $sleeve_print_type=$specification_details_row->SLEEVE_PRINT_TYPE;
                        $sleeve_master_batch=$specification_details_row->SLEEVE_MASTER_BATCH;

                        $shoulder_neck_type=$specification_details_row->SHOULDER_NECK_TYPE;
                        $shoulder_orifice=$specification_details_row->SHOULDER_ORIFICE;
                        $shoulder_master_batch=$specification_details_row->SHOULDER_MASTER_BATCH;
                        $shoulder_foil_tag=$specification_details_row->SHOULDER_FOIL_TAG;

                        $cap_dia=$specification_details_row->CAP_DIA;
                        $cap_style=$specification_details_row->CAP_STYLE;
                        $cap_mold_finish=$specification_details_row->CAP_MOLD_FINISH;
                        $cap_orifice=$specification_details_row->CAP_ORIFICE;
                        $cap_master_batch=$specification_details_row->CAP_MASTER_BATCH;
                        $cap_master_batch_desc='';
                        $cap_foil_color=$specification_details_row->CAP_FOIL_COLOR;
                        $cap_foil_width=$specification_details_row->CAP_FOIL_WIDTH;
                        $cap_foil_dist_from_bot=$specification_details_row->CAP_FOIL_DIST_FROM_BOT;

                        $data['sleeve_article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$sleeve_master_batch);
                        foreach($data['sleeve_article'] as $sleeve_article_row){
                            $sleeve_master_batch_desc=$sleeve_article_row->article_name;                            
                        }
                        $data['shoulder_article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$shoulder_master_batch);
                        foreach($data['shoulder_article'] as $shoulder_article_row){
                            $shoulder_master_batch_desc=$shoulder_article_row->article_name;                            
                        }
                        $data['cap_article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$cap_master_batch);
                        foreach($data['cap_article'] as $cap_article_row){
                            $cap_master_batch_desc=$cap_article_row->article_name;                            
                        }




                    }  


                  echo '<span class="ui green right ribbon label">'.$production_row->mp_pos_no.'</span>';
?>

                <br/>

                <?php echo $this->common_model->view_date($production_row->manu_plan_date,$this->session->userdata['logged_in']['company_id'])!='' ? '<span class="ui blue left ribbon label">'.$this->common_model->view_date($production_row->manu_plan_date,$this->session->userdata['logged_in']['company_id']).'</span>' : '';
                ?>
                <br/>
                <br/>
                <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">

                    <tr class="heading">
                        <td width="10%">ORDER NO</td>
                        <td width="5%"></td>
                        <td width="35%"><a href="<?php echo base_url('index.php/sales_order_book/view/'.$order_no);?>" target='_blank'><?php echo $order_no;?></a></td>
                        <td width="10%">CUSTOMER</td>
                        <td width="5%"></td>
                        <td width="5%"><?php echo $customer_name;?></td>
                    </tr>
                    <tr class="item">
                        <td><b>ARTICLE NO</b></td>
                        <td></td>
                        <td><?php echo $article_no;?></td>
                        <td><b>ARTICLE NAME</b></td>
                        <td></td>
                        <td><?php echo $article_name; ?></td>
                       
                    
                    </tr> 

                    <tr class="item">
                        <td><b>SPEC</b></td>
                        <td width="5%"></td>
                        <td width="35%"><b><?php echo "<a href='".base_url()."/index.php/specification/view/".$spec_id."/".$spec_version_no." ' target='blank'>".($spec_id!=""? $spec_id:"")."</a>"; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>SPEC VERSION</b>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $spec_version_no;?></b></td>
                        <td width="10%"><b>ARTWORK NO</b></td>
                        <td width="5%"></td>
                        <td width="35%"><?php echo ($artwork_no!='' ? "<b><a href='".base_url('index.php/artwork/view/'.$artwork_no.'/'.$artwork_version)."' target='_blank'>".$artwork_no."</a></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>ARTWORK VERSION&nbsp;&nbsp;&nbsp;&nbsp;</b>".$artwork_version."": "NOT ATTACHED");?></td>
                    </tr>

                               
                    <tr class="item last">
                        <td><b>JOB CARD QUANTITY</b></td>
                        <td></td>
                        <td><?php echo $jobcard_qty; ?></td>
                        <td><b>CREATED BY</b></td>
                        <td></td>
                        <td><?php echo strtoupper($user_name); ?></td>
                    </tr>

                </table>
                <br/>

                <?php
                $data['specification']=$this->specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$spec_id,'specification_sheet.spec_version_no',$spec_version_no);
                foreach($data['specification'] as $specification_row){
                    $no_of_layer=substr($specification_row->dyn_qty_present,strpos($specification_row->dyn_qty_present,"|")+1,1);
                }
                ?>
                <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
                    <tr class="heading">
                        <td colspan="6">EXTRUSION</td>
                
                    </tr>
                    <tr class="item last">
                        <td width="10%"><b>SLEEVE DIA</b></td>
                        <td width="5%"></td>
                        <td width="35%"><?php echo $sleeve_dia ;?>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        &nbsp;&nbsp;&nbsp;
                                        <b>PRINT TYPE&nbsp;&nbsp;&nbsp;&nbsp;</b><?php echo $sleeve_print_type;?>
                        </td>
                        <td width="10%"><b>SLEEVE LENGTH</b></td>
                        <td width="5%"></td>
                        <td width="35%"><?php echo $sleeve_length; ?></td>
                    </tr>
                    
                </table>
                <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;"> 
                    <tr class="heading">
                        <td width="10%">LAYER</td>
                        <td width="5%"></td>
                        <td colspan="3">MATERIAL</td>
                
                    </tr>   
                    <?php
                    $pos_no=1;
                    for($i=1;$i<=$no_of_layer;$i++){

                        $data['specification_sleeve_details']=$this->specification_model->select_details_record_for_jobcardprint_where_gauge('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$spec_id,'specification_sheet_details.spec_version_no',$spec_version_no,'item_group_id','3','material','1','layer_no',$i,'srd_id','asc','layer_no','asc');
                      // echo  $this->db->last_query();
                        
                        foreach($data['specification_sleeve_details'] as $specification_sleeve_details_row){
                                                
                            
                            if(!empty($specification_sleeve_details_row->mat_info) && !empty($specification_sleeve_details_row->mat_article_no)){

                                $array_rm=explode(",",$specification_sleeve_details_row->rm);
                                $array_rm_per=explode(",",$specification_sleeve_details_row->rm_per);

                                echo "<tr class='item'>
                                        <td>LAYER ".$i."</td>
                                        <td></td>
                                        ";
                                        
                                        foreach(array_combine($array_rm, $array_rm_per) as $val_rm => $val_rm_per){

                                            $article_desc="";
                                            $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',ltrim($val_rm," "));
                                            //echo $this->db->last_query();
                                            foreach($data['article'] as $article_row){
                                                $article_desc=$article_row->article_name;
                                            }

                                            // Material Manufacturing----------------------

                                            $extrusion_search=array();
                                            $extrusion_search['manu_order_no']=$jobcard_no;
                                            $extrusion_search['article_no']=ltrim($val_rm," ");
                                            $extrusion_search['work_proc_no']=1;
                                            //$material_manu_search['part_pos_no']=$pos_no;

                                             $material_manufacturing=$this->common_model->select_active_records_where('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$extrusion_search);

                                            //echo $this->db->last_query();

                                             $extrusion_val='';
                                             foreach($material_manufacturing as $material_manufacturing_row)
                                            {
                                                $extrusion_val=$ci->common_model->read_number($material_manufacturing_row->demand_qty,$this->session->userdata['logged_in']['company_id']);
                                            }

                                            echo "<td style='border-right:1px solid #D9d9d9;'>".$article_desc." (".$val_rm_per.") = <b>" .$extrusion_val."</b></td>";


                                              

                                           $pos_no++; 
                                            
                                        }
                                        echo "
                                        
                                </tr>";
                            }

                            
                        }


                        
                    }
                    ?>
                    
            

                </table>
                
                <br/>

                <br/>


                <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
                    <tr class="heading">
                        <td colspan="8">HEADING</td>
                
                    </tr>
                    <tr class="item last">
                        <td width="10%"><b>SHOULDER</b></td>
                        <td width="5%"></td>
                        <td width="35%"><?php echo $shoulder_neck_type ;?>
                            
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        &nbsp;&nbsp;&nbsp;
                                        <b>SHOULDER ORIFICE&nbsp;&nbsp;&nbsp;&nbsp;</b><?php echo $shoulder_orifice; ?>
                        </td>
                        <td width="10%"><b>FOIL TAG</b></td>
                        <td width="5%"></td>
                        <td width="35%"><?php echo $shoulder_foil_tag; ?></td>
                    </tr>
                </table>

                <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">                    
                    <tr class="heading">
                        <td width="10%">MATERIAL</td>
                        <td width="5%"></td>
                        <td width="35%"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                
                    </tr>
                    <tr class='item'>
                    <td></td>
                    <td></td>
                <?php
                $data['specification_shoulder_details']=$this->specification_model->select_details_record_for_jobcard_where_gauge('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$spec_id,'specification_sheet_details.spec_version_no',$spec_version_no,'item_group_id','4','material','1','layer_no','1','srd_id','asc','layer_no','asc');
               $part_pos_no_heading=1;
                foreach($data['specification_shoulder_details'] as $specification_shoulder_details_row){
                    if(!empty($specification_shoulder_details_row->mat_info) && !empty($specification_shoulder_details_row->mat_article_no)){

                            $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$specification_shoulder_details_row->mat_article_no);
                                foreach($data['article'] as $article_row){
                                    $article_desc=$article_row->article_name;
                                    $article_group=$article_row->sub_group;
                                   
                                }

                                // Material Manufacturing----------------------

                                $heading_search=array();
                                $heading_search['manu_order_no']=$jobcard_no;
                                $heading_search['article_no']=$specification_shoulder_details_row->mat_article_no;
                                $heading_search['work_proc_no']=2;
                                //$material_manu_search['part_pos_no']=$pos_no;

                                 $material_manufacturing_1=$this->common_model->select_active_records_where('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$heading_search);

                               // echo $this->db->last_query();

                                 $heading_val='';
                                 foreach($material_manufacturing_1 as $material_manufacturing_1_row)
                                {
                                    $heading_val=$ci->common_model->read_number($material_manufacturing_1_row->demand_qty,$this->session->userdata['logged_in']['company_id']);
                                }


                         echo "
                         <td style='border:1px solid #D9d9d9;'>".$article_desc." (".$specification_shoulder_details_row->mat_info.")= <b>".$heading_val."</b></td>";
                         $part_pos_no_heading++;
                    }
                }

                ?>
                </tr>
                </table>

            </br>
                  
        <?php 
            if($artwork_no!=''){?>

                <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
                    <tr class="heading">
                        <td colspan="8">PRINTING</td>
                
                    </tr>
                    <tr class="heading"><td >ARTWORK NO</td><td></td><td >REVISION</td></tr>
                    <tr class="item"><td ><?php echo "<a href='".base_url()."/index.php/artwork/view/".$artwork_no."/".$artwork_version." ' target='blank'>".($artwork_no!=""? $artwork_no:"")."</a>"; ;?></td><td></td><td ><?php echo $artwork_version ;?></td></tr>
                </table>
            </br>

    <?php  }
       else{
        ?>

                <table cellpadding="5" cellspacing="0" style='border:1px solid #D9d9d9;'>
                    <tr class="heading">
                        <td colspan="8">LABELING</td>
                
                    </tr>
                    <tr class="heading"><td >LABEL CODE</td><td></td><td >LACQURE</td></tr>
                    <tr class="item"><td ><?php echo $spec_sheet_comment ;?></td><td></td><td ><?php echo $cap_mold_finish ;?></td></tr>
                </table>


    <?php } ?>



            </br>
                <table cellpadding="5" cellspacing="0" style='border:1px solid #D9d9d9;'>
                    <tr class="heading">
                        <td colspan="8">CAPPING</td>
                    </tr>
                    <tr class="heading"><td >CAP DIA</td><td >CAP STYLE</td><td></td><td >CAP FINISH</td><td >CAP ORIFICE</td> <td >MASTER BATCH</td><td>CAP FOIL COLOR</td> <td>CAP FOIL WIDTH</td><td>CAP FOIL DIST FROM BOT</td></tr>
                    <tr class="item"><td><?php echo $cap_dia;?></td><td><?php echo $cap_style ;?></td><td></td><td ><?php echo $cap_mold_finish ;?></td><td ><?php echo$cap_orifice; ?></td>
                        <td><?php echo$cap_master_batch_desc; ?></td><td><?php echo$cap_foil_color; ?><td><?php echo$cap_foil_width; ?></td><td><?php echo$cap_foil_dist_from_bot; ?></td></tr>
                </table>
     
    <?php

        } // Foreach
    } // Else

    ?>
    <br/>

    <table cellpadding="5" cellspacing="0">
                    <tr class="heading">
                        <td colspan="5">AGAINST JOB CARD</td>
                
                    </tr>
                    <tr class="heading">
                        <td width="20%">SR NO</td>
                        <td></td>
                        <td colspan="3">MATERIAL</td>

                    </tr>

                    <?php 
                    if($extrusion_additional==FALSE){
                        echo "<tr>
                                <td></td>
                                </tr>";
                    }else{
                        $i=1;
                       foreach($extrusion_additional as $extrusion_additional_row){

                        $article_desc="";
                        $article_uom="";
                        $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$extrusion_additional_row->article_no);
                        foreach($data['article'] as $article_row){
                            $article_desc=$article_row->article_name;
                            $article_uom=$article_row->uom;
                        }

                        echo "<tr>
                                <td width='20%''>$i</td>
                                <td></td>
                                <td>".$article_desc."=".$this->common_model->read_number($extrusion_additional_row->demand_qty,$this->session->userdata['logged_in']['company_id'])."($article_uom)</td>
                                <td>$extrusion_additional_row->article_no</td>
                                <td></td>
                            </tr>";
                            $i++;
                        } 
                    }
                    
                    ?>



    


    
    </div>
</body>
</html>
