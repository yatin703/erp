
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
                $user_name=$ci->common_model->get_user_name($production_row->employee_id,$this->session->userdata['logged_in']['company_id']);
                $no_of_reels=$production_row->no_of_reels;
                $reel_length=$production_row->reel_length;
                $total_meters=$production_row->total_meters;

                $order_date='';
                $customer_name='';
                $adr_company_id='';
                $article_no='';
                $article_name='';
                $total_order_quantity='';
                $data=array('order_no'=>$production_row->sales_ord_no,
                    'article_no'=>$production_row->article_no);
                $result_order_details=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data);
                if($result_order_details){
                    foreach($result_order_details as $order_details_row){
                        $artwork_no=$order_details_row->ad_id;
                        $artwork_version=$order_details_row->version_no;
                        $total_order_quantity=$order_details_row->total_order_quantity;
                    }
                }

                echo'<br/>
                <div class="ui teal labels" style="text-align: center;">
                  <div class="ui label">
                    ';
                    if($production_row->jobcard_type==1){
                        echo'FILM EXTRUSION JOBCARD';
                    }elseif($production_row->jobcard_type==2){
                        echo'FILM PRINTING JOBCARD';
                    }elseif($production_row->jobcard_type==4){
                        echo'FILM EXTRUSION SETUP JOBCARD';
                    }elseif($production_row->jobcard_type==5){
                        echo'FILM EXTRUSION PURGING JOBCARD';
                    
                    }elseif($production_row->jobcard_type==3){
                        echo'FILM BODY MAKING JOBCARD';
                    }
                  echo'</div>
                </div>';


                echo '<span class="ui green right ribbon label">'.$production_row->mp_pos_no.'</span>';
?>

                <br/>

                <?php echo $this->common_model->view_date($production_row->manu_plan_date,$this->session->userdata['logged_in']['company_id'])!='' ? '<span class="ui blue left ribbon label">'.$this->common_model->view_date($production_row->manu_plan_date,$this->session->userdata['logged_in']['company_id']).'</span>' : '';
                ?>
                <br/>
                <br/>
                <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">

                    <tr class="heading">
                        <td width="15%">ORDER NO</td>
                        <td width="1%"></td>
                        <td width="25%"><a href="<?php echo base_url('index.php/sales_order_book/view/'.$production_row->sales_ord_no);?>" target='_blank'><?php echo $production_row->sales_ord_no;?></a></td>
                        <td width="15%">ORDER QTY</td>
                        <td width="1%"></td>
                        <td width="25%"><?php echo $this->common_model->read_number($total_order_quantity,$this->session->userdata['logged_in']['company_id']);?></td>
                    </tr>
                    <tr class="item">
                        <td><b>ARTICLE NO</b></td>
                        <td></td>
                        <td><?php echo $production_row->article_no;?></td>
                        <td><b>ARTICLE NAME</b></td>
                        <td></td>
                        <td><?php echo $this->common_model->get_article_name($production_row->article_no,$this->session->userdata['logged_in']['company_id']); ?></td>
                       
                    
                    </tr>

                    <tr class="item">
                        <td><b>BOM</b></td>
                        <td ></td>
                        <td ><b>
                            <?php
                            if(!empty($this->uri->segment(4))){



                                $bom=array('bom_no'=>$spec_id,
                                    'bom_version_no'=>$spec_version_no);
                                $data['bom']=$this->common_model->select_active_records_where("bill_of_material",$this->session->userdata['logged_in']['company_id'],$bom);

                                foreach($data['bom'] as $bom_row){

                                    

                                    echo "<a href='".base_url()."/index.php/bill_of_material/view/".$bom_row->bom_id."' target='blank'>".$spec_id."_".$spec_version_no."</a>";
                                }

                            }

                            ?>


                        </b></td>
                        <td  ><b>ARTWORK NO</b></td>
                        <td  ></td>
                        <td  ><?php echo ($artwork_no!='' ? "<b><a href='".base_url('index.php/'.(substr($artwork_no,0,3)=='SAW'?'artwork_springtube':'artwork_new').'/view/'.$artwork_no.'/'.$artwork_version)."' target='_blank'>".$artwork_no."_".$artwork_version."</a>": "NOT ATTACHED");?></td>
                    </tr>

                               
                    
                    <tr class="item">
                        <td><b>JOB CARD REELS</b></td>
                        <td ></td>
                        <td ><?php echo round($no_of_reels,2).' ( Default Reel Length is '.$reel_length.' Meters)'; ?></td>
                        <td><b>JOB CARD METERS</b></td>
                        <td></td>
                        <!-- <td><?php echo $no_of_reels*$reel_length; ?></td> -->
                        <td><?php echo $total_meters; ?></td>
                    </tr>
                    <tr class="item">
                        <td><b>JOB CARD QUANTITY</b></td>
                        <td ></td>
                        <td ><?php echo $jobcard_qty; ?></td>
                        <td><b>CREATED BY</b></td>
                        <td></td>
                        <td><?php echo strtoupper($user_name); ?></td>
                    </tr>

                </table>
                <br/>

                <?php

                $comment='';
                $sleeve_dia='';
                $sleeve_length='';
                $shoulder='';
                $shoulder_foil_tag='';
                $shoulder_orifice='';
                $no_of_layer=0; 
                $shoulder_spec_id='';
                $shoulder_spec_vesrion_no='';

                $data=array('bom_no'=>$spec_id,
                    'bom_version_no'=>$spec_version_no);

                $data['bom_details']=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data);


                foreach($data['bom_details'] as $bom_details_row){
                   $sleeve_code=$bom_details_row->sleeve_code;
                   $shoulder_code=$bom_details_row->shoulder_code;
                   $label_code=$bom_details_row->label_code;
                   $comment=$bom_details_row->comment;
                   $data['sleeve_code_specs_details']=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$sleeve_code);
                   foreach($data['sleeve_code_specs_details'] as $sleeve_code_specs_details_row){
                        $sleeve_spec_id=$sleeve_code_specs_details_row->spec_id;
                        $sleeve_spec_vesrion_no=$sleeve_code_specs_details_row->spec_version_no;
                        $dataa=array('spec_id'=>$sleeve_code_specs_details_row->spec_id,
                            'spec_version_no'=>$sleeve_code_specs_details_row->spec_version_no);

                        $data['sleeve_specification']=$this->common_model->select_active_records_where('specification_sheet',$this->session->userdata['logged_in']['company_id'],$dataa);
                            foreach($data['sleeve_specification'] as $sleeve_specification_row){
                                $no_of_layer=substr($sleeve_specification_row->dyn_qty_present,strpos($sleeve_specification_row->dyn_qty_present,"|")+1,1);
                        }
                        $this->load->model('sales_order_book_model');
                        $data['sleeve_specification_details']=$this->sales_order_book_model->select_sleeve_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$dataa);
                        foreach($data['sleeve_specification_details'] as $sleeve_specification_details_row){
                            $sleeve_length=$sleeve_specification_details_row->SLEEVE_LENGTH;
                            $sleeve_dia=$sleeve_specification_details_row->SLEEVE_DIA;
                        }


                   }



                   $data['shoulder_code_specs_details']=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$shoulder_code);
                   foreach($data['shoulder_code_specs_details'] as $shoulder_code_specs_details_row){
                        $shoulder_spec_id=$shoulder_code_specs_details_row->spec_id;
                        $shoulder_spec_vesrion_no=$shoulder_code_specs_details_row->spec_version_no;

                        $dataaa=array('spec_id'=>$shoulder_code_specs_details_row->spec_id,
                            'spec_version_no'=>$shoulder_code_specs_details_row->spec_version_no);


                        $data['shoulder_specification_details']=$this->sales_order_book_model->select_shoulder_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$dataaa);
                        foreach($data['shoulder_specification_details'] as $shoulder_specification_details_row){
                            $shoulder=$shoulder_specification_details_row->SHOULDER_STYLE;
                            $shoulder_orifice=$shoulder_specification_details_row->SHOULDER_ORIFICE;
                            $shoulder_foil_tag=$shoulder_specification_details_row->SHOULDER_FOIL_TAG;
                        }


                   }

                   if(!empty($label_code)){

                        $data['label_code_specs_details']=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$label_code);
                   foreach($data['label_code_specs_details'] as $label_code_specs_details_row){
                        $label_spec_id=$label_code_specs_details_row->spec_id;
                        $label_spec_vesrion_no=$label_code_specs_details_row->spec_version_no;

                        $dataaa=array('spec_id'=>$label_code_specs_details_row->spec_id,
                            'spec_version_no'=>$label_code_specs_details_row->spec_version_no);


                        $data['label_specification_details']=$this->sales_order_book_model->select_label_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$dataaa);
                        
                        if($data['label_specification_details']==FALSE){
                                    $LABEL_NAME="";
                                    $LABEL_LACQUER_ONE="";
                                    $LABEL_LACQUER_ONE_PERC="";
                                    $LABEL_LACQUER_TWO="";
                                    $LABEL_LACQUER_TWO_PERC="";
                                    $LABEL_OE="";
                                    $LABEL_SE="";
                                }else{
                                    foreach($data['label_specification_details'] as $specs_details_row){
                                        $LABEL_NAME=$specs_details_row->LABEL_NAME;
                                        $LABEL_LACQUER_ONE=$specs_details_row->LABEL_LACQUER_ONE;
                                        $LABEL_LACQUER_ONE_PERC=$specs_details_row->LABEL_LACQUER_ONE_PERC;
                                        $LABEL_LACQUER_TWO=$specs_details_row->LABEL_LACQUER_TWO;
                                        $LABEL_LACQUER_TWO_PERC=$specs_details_row->LABEL_LACQUER_TWO_PERC;
                                        $LABEL_OE=$specs_details_row->OE;
                                        $LABEL_SE=$specs_details_row->SE;
                                    }
                            }

                            $data['lacquer_one_result']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$LABEL_LACQUER_ONE);
                                if($data['lacquer_one_result']==FALSE){
                                    $lacquer_one_name="";
                                    $lacquer_one_pc="";
                                }else{
                                    foreach($data['lacquer_one_result'] as $lacquer_one_row){
                                        $lacquer_one_name=$lacquer_one_row->article_name;
                                        $lacquer_one_pc=$LABEL_LACQUER_ONE_PERC."%";
                                    }
                                }

                                $data['lacquer_two_result']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$LABEL_LACQUER_TWO);
                                if($data['lacquer_two_result']==FALSE){
                                    $lacquer_two_name="";
                                    $lacquer_two_pc="";
                                }else{
                                    foreach($data['lacquer_two_result'] as $lacquer_two_row){
                                        $lacquer_two_name=$lacquer_two_row->article_name;
                                        $lacquer_two_pc=$LABEL_LACQUER_TWO_PERC."%";
                                    }
                                }
                            }


                   }

                }


                $data['workprocedure_types_master']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id','1');
                    foreach($data['workprocedure_types_master'] as $workprocedure_types_master){
                      $extrusion_rejection=$this->common_model->read_number($workprocedure_types_master->rejection_perc,$this->session->userdata['logged_in']['company_id']);
                    }
                
                ?>
                <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
                <tr class="item last">
                        <td><b>COMMENT</b></td>
                        <td></td>
                        <td colspan='4'><?php echo $comment;?></td>
                    </tr>

                </table>
    <?php if($production_row->jobcard_type==1 || $production_row->jobcard_type==4){?>           
                <br/>
                <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
                    <tr class="heading">
                        <!-- <td colspan="6">EXTRUSION MATERIAL FOR <?php echo $jobcard_qty+($jobcard_qty/100)*$extrusion_rejection;?> QUANTITY</td> -->
                    <td colspan="6">EXTRUSION MATERIAL FOR <?php echo $jobcard_qty;?> QUANTITY</td>
                
                    </tr>
                    <tr class="item last">
                        <td width="10%"><b>SLEEVE DIA</b></td>
                        <td width="5%"></td>
                        <td width="35%"><?php echo $sleeve_dia ;?></td>
                        <td width="10%"><b>SLEEVE LENGTH</b></td>
                        <td width="5%"></td>
                        <td width="35%"><?php echo $sleeve_length.' MM'; ?></td>
                    </tr>
                    
                </table>
                <br/>
                <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;"> 
                    <tr class="heading">
                        <td width="10%">LAYER</td>
                        <td width="5%"></td>
                        <td colspan="3">MATERIAL</td>
                
                    </tr>   
                    <?php
                    $pos_no=1;
                    $total_guage=0;
                    for($i=1;$i<=$no_of_layer;$i++){

                        $data['specification_sleeve_details']=$this->specification_model->select_details_record_for_jobcardprint_where_gauge('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$sleeve_spec_id,'specification_sheet_details.spec_version_no',$sleeve_spec_vesrion_no,'item_group_id','3','mat_article_no<>','','layer_no',$i,'srd_id','asc','layer_no','asc');
                        $this->db->last_query();
                        
                        foreach($data['specification_sleeve_details'] as $specification_sleeve_details_row){
                                                
                           
                            if(!empty($specification_sleeve_details_row->mat_info) || !empty($specification_sleeve_details_row->mat_article_no)){

                                $array_rm=explode(",",$specification_sleeve_details_row->rm);
                                $array_rm_per=explode(",",$specification_sleeve_details_row->rm_per);

                                $data['specification_sleeve_details_guage']=$this->specification_model->select_details_record_for_jobcard_where_gauge('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$sleeve_spec_id,'specification_sheet_details.spec_version_no',$sleeve_spec_vesrion_no,'item_group_id','3','parameter_name','GUAGE','layer_no',$i,'srd_id','asc','layer_no','asc');
                                //$this->db->last_query();
                                if($data['specification_sleeve_details_guage']==TRUE){
                                    foreach($data['specification_sleeve_details_guage'] as $specification_sleeve_details_guage_row){
                                    $guage=$specification_sleeve_details_guage_row->parameter_value;
                                    $total_guage+=$guage;
                                    }
                                }
                                

                                echo "<tr class='item'>
                                        <td>LAYER ".$i." ".$guage."MIC</td>
                                        <td></td>
                                        ";
                                        
                                        foreach(array_combine($array_rm, $array_rm_per) as $val_rm =>$val_rm_per){

                                            $article_desc="";
                                            $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',ltrim($val_rm," "));
                                            //echo $this->db->last_query();
                                            foreach($data['article'] as $article_row){
                                                $article_desc=$article_row->article_name;
                                                $uom=$article_row->uom;
                                            }

                                            // Material Manufacturing----------------------

                                            $extrusion_search=array();
                                            $extrusion_search['manu_order_no']=$jobcard_no;
                                            $extrusion_search['article_no']=ltrim($val_rm," ");
                                            $extrusion_search['work_proc_no']=1;
                                            $extrusion_search['layer_no']=$i;
                                            //$material_manu_search['part_pos_no']=$pos_no;

                                             $material_manufacturing=$this->common_model->select_active_records_where('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$extrusion_search);

                                           // echo $this->db->last_query();

                                             $extrusion_val='';
                                             $com="";
                                             foreach($material_manufacturing as $material_manufacturing_row)
                                            {
                                                $extrusion_val=$ci->common_model->read_number($material_manufacturing_row->demand_qty,$this->session->userdata['logged_in']['company_id']);
                                                $com=$material_manufacturing_row->completed_flag;
                                            }

                                            echo "<td style='border-right:1px solid #D9d9d9;'>".$completed=($com==1 ? "<i class='check green circle icon'></i>" : "")." ".$article_desc." (".$val_rm_per."%) = <b>" .$extrusion_val."</b> ".$uom."</td>";


                                              

                                           $pos_no++; 
                                            
                                        }
                                        echo "
                                        
                                </tr>";
                            }

                            
                        }


                        
                    }
                    $pos_no++;
                    ?>
                    
            

                </table>

        <?php

                $extrusion_search=array();
                $extrusion_search['manu_order_no']=$jobcard_no;                
                $extrusion_search['work_proc_no']=1;


                $sum_demand_qty=0;
                 
                 $this->load->model('job_card_model');
                $material_manufacturing_summary_result=$this->job_card_model->jobcard_material_summary('material_manufacturing',$extrusion_search,$this->session->userdata['logged_in']['company_id']);

                //echo $this->db->last_query();


                echo'
                </br>
                <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;"> 
                    <tr class="heading">
                        <td width="10%">LAYER</td>
                        <td width="5%"></td>
                        <td colspan="3">MATERIAL SUMMARY FOR ('.$total_guage.' MIC )</td>
                
                    </tr> ';
                    
                    foreach ($material_manufacturing_summary_result as $material_manufacturing_summary_row) {

                        $sum_demand_qty+=$this->common_model->read_number($material_manufacturing_summary_row->demand_qty,$this->session->userdata['logged_in']['company_id']);
                        echo'<tr>
                           <td></td>
                           <td></td>
                           <td>'.$this->common_model->get_article_name($material_manufacturing_summary_row->article_no,$this->session->userdata['logged_in']['company_id']).' = <b>'.$this->common_model->read_number($material_manufacturing_summary_row->demand_qty,$this->session->userdata['logged_in']['company_id']).'</b> KGS</td>
                         </tr> ';
                       }
                 echo'</table>';

                 echo'<table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;"> 
                    <tr class="heading">
                        <td width="10%">TOTAL</td>
                        <td width="5%"></td>
                        <td width="40%"><b>'.$sum_demand_qty.'</b> KGS</td>
                    </tr>    
                </table>';        

    }//END IF  JOBCARD TYPE EXTRUSION AND SETUP  

    

                

        
                if($purging==FALSE){

                }else{
                    echo '<br/><table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
                            <tr class="heading">
                                <td >PURGING</td>
                                <td ></td>
                                <td >MATERIAL</td>
                            </tr>';
                    $sum_demand_qty=0;        
                    foreach($purging as $purging_row){
                        $uom='';
                        $data['article']=$ci->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$purging_row->article_no);
                            //echo $this->db->last_query();
                            foreach($data['article'] as $article_row){
                                $article_desc=$article_row->article_name;
                                $uom=$article_row->uom;
                            }
                    
                    echo '
                        <tr class="item">
                            <td width="10%"></td>
                            <td width="5%"></td>
                            <td style="border:1px solid #D9d9d9;">'.$completed=($purging_row->completed_flag==1 ? "<i class='check green circle icon'></i>" : "").' '.$article_desc.'= <b>'.$this->common_model->read_number($purging_row->demand_qty,$this->session->userdata['logged_in']['company_id']).'</b> '.$uom.'</td>
                        </tr>';
                        $sum_demand_qty+=$this->common_model->read_number($purging_row->demand_qty,$this->session->userdata['logged_in']['company_id']);

                    }
                    echo "</table>";

                    echo'<table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;"> 
                    <tr class="heading">
                        <td width="10%">TOTAL</td>
                        <td width="5%"></td>
                        <td width="40%"><b>'.$sum_demand_qty.'</b> KGS</td>
                    </tr>    
                </table>';  
                }
                ?>


                <?php 
                if($box==FALSE){

                }else{
                    echo '<br/><table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
                            <tr class="heading">
                                <td colspan="8">BOXES FOR '.$jobcard_qty.' QUANTITY</td>
                            </tr>';
                            $j=1;
                    foreach($box as $box_row){

                        $data['article']=$ci->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$box_row->article_no);
                            //echo $this->db->last_query();
                            foreach($data['article'] as $article_row){
                                $article_desc=$article_row->article_name;
                                $article_sub_description=$article_row->article_sub_description;
                                $uom=$article_row->uom;
                            }
                    
                    echo '
                        <tr>
                            <td width="10%"></td>
                            <td width="5%"></td>
                            <td style="border:1px solid #D9d9d9;">'.$completed=($box_row->completed_flag==1 ? "<i class='check green circle icon'></i>" : "").' '.$article_desc.' '.$article_sub_description.'= <b>'.$this->common_model->read_number($box_row->demand_qty,$this->session->userdata['logged_in']['company_id']).'</b> '.$uom.'</td>
                        </tr>';
                        $j++;

                    }
                    echo "</table>";
                }
                ?>
                

                <br/>

                <?php
                $data['workprocedure_types_master']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id','2');
                    foreach($data['workprocedure_types_master'] as $workprocedure_types_master){
                      $heading_rejection=$this->common_model->read_number($workprocedure_types_master->rejection_perc,$this->session->userdata['logged_in']['company_id']);
                    }
                ?>


                <!-- <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
                    <tr class="heading">
                        <td colspan="8">HEADING MATERIAL FOR <?php echo $jobcard_qty+($jobcard_qty/100)*$heading_rejection;?> QUANTITY</td>
                    </tr>
                    <tr class="item last">
                        <td width="10%"><b>SHOULDER</b></td>
                        <td width="5%"></td>
                        <td width="35%"><?php echo $shoulder ;?> <b>ORIFICE</b> <?php echo $shoulder_orifice; ?></b>
                        </td>
                        <td width="10%"><b>FOIL TAG</b></td>
                        <td width="5%"></td>
                        <td width="35%"><?php echo $shoulder_foil_tag=($shoulder_foil_tag!='' ? $this->common_model->get_article_name($shoulder_foil_tag,$this->session->userdata['logged_in']['company_id']) : "NO"); ?></td>
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
                $data['specification_shoulder_details']=$this->specification_model->select_details_record_for_jobcard_where_gauge('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'specification_sheet_details.spec_id',$shoulder_spec_id,'specification_sheet_details.spec_version_no',$shoulder_spec_vesrion_no,'item_group_id','4','material','1','layer_no','1','srd_id','asc','layer_no','asc');
               $part_pos_no_heading=1;
               
                foreach($data['specification_shoulder_details'] as $specification_shoulder_details_row){
                    if(!empty($specification_shoulder_details_row->mat_info) && !empty($specification_shoulder_details_row->mat_article_no)){

                            $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$specification_shoulder_details_row->mat_article_no);
                                foreach($data['article'] as $article_row){
                                    $article_desc=$article_row->article_name;
                                    $article_group=$article_row->sub_group;
                                    $uom=$article_row->uom;

                                   
                                }

                                // Material Manufacturing----------------------

                                $heading_search=array();
                                $heading_search['manu_order_no']=$jobcard_no;
                                $heading_search['article_no']=$specification_shoulder_details_row->mat_article_no;
                                $heading_search['work_proc_no']=2;
                                //$heading_search['part_pos_no']=$pos_no;
                                //$material_manu_search['part_pos_no']=$pos_no;

                                 $material_manufacturing_1=$this->common_model->select_active_records_where('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$heading_search);

                                

                                 $heading_val='';
                                 $com_head="";
                                foreach($material_manufacturing_1 as $material_manufacturing_1_row){
                                    $heading_val='';
                                    $heading_val=$ci->common_model->read_number($material_manufacturing_1_row->demand_qty,$this->session->userdata['logged_in']['company_id']);
                                    $com_head=$material_manufacturing_1_row->completed_flag;
                                    //$mm_id=$material_manufacturing_1_row->mm_id;
                                    //$pos_no++;

                                }




                         echo "
                         <td style='border:1px solid #D9d9d9;'>".$completed=($com_head==1 ? '<i class="check green circle icon"></i>' : "")." ".$article_desc." (".$specification_shoulder_details_row->mat_info."%)= <b>".$heading_val."</b> $uom </td>";
                         $part_pos_no_heading++;
                    }
                }

                ?>
                </tr>
                </table>

            -->

                <?php

                    if($printing==TRUE){

                        $data['workprocedure_types_master']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id','3');
                        foreach($data['workprocedure_types_master'] as $workprocedure_types_master){
                          $printing_rejection=$this->common_model->read_number($workprocedure_types_master->rejection_perc,$this->session->userdata['logged_in']['company_id']);
                        }

                        $printing_job_card_quantity=($jobcard_qty-($jobcard_qty/100)*$heading_rejection);
                        $printing_output_quantity=$printing_job_card_quantity-(($printing_job_card_quantity/100)*$printing_rejection);

                        $printing_job_card_quantity=$printing_job_card_quantity+(($printing_job_card_quantity/100)*$printing_rejection);

                    echo '<br/><table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">                    
                        <tr class="heading">
                        <td colspan="8">PRINTING MATERIAL FOR '.$jobcard_qty.' QUANTITY</td>
                        </tr>';

                    foreach($printing as $printing_row){


                        $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$printing_row->article_no);
                                foreach($data['article'] as $article_row){
                                    $article_desc=$article_row->article_name;
                                    $article_group=$article_row->sub_group;
                                    $uom=$article_row->uom;

                                   
                                }

                        echo '<tr  >
                        <td width="10%"></td>
                        <td width="5%"></td>
                        <td width="55%" style="border:1px solid #D9d9d9;">'.$completed=($printing_row->completed_flag==1 ? "<i class='check green circle icon'></i>" : "").' '.$this->common_model->get_article_name($printing_row->article_no,$this->session->userdata['logged_in']['company_id']).' = <b>'.$this->common_model->read_number($printing_row->demand_qty,$this->session->userdata['logged_in']['company_id']).'</b> ';
                        if($printing_row->article_no=='CON-FLEXO-PLT-0029'){
                            echo 'SQMM';
                        }else{
                            echo $uom;
                        }
                        
                        echo '</td>
                        <!--<td width="10%"></td>
                        <td width="5%"></td>
                        <td width="35%"></td>
                        -->
                        </tr>';


                        
                    }

                  echo '</table>';
                }else{
                    $printing_output_quantity="";
                }

                ?>


                 <?php 
                 $label_qty=0;
                if($labeling==FALSE){

                }else{
                    echo '<br><table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
                            <tr class="heading">
                                <td colspan="8">LABELING MATERIAL <i style="color:red">(QUANTITY BY STORE)</i></td>
                            </tr>';
                    foreach($labeling as $labeling_row){

                        $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$labeling_row->article_no);
                                foreach($data['article'] as $article_row){
                                    $article_desc=$article_row->article_name;
                                    $article_group=$article_row->sub_group;
                                    $uom=$article_row->uom;
                                }

                    
                        //if($labeling_row->demand_qty ==0){

                           $data_label=array('manu_order_no' =>$jobcard_no,
                                            'article_no' =>$labeling_row->article_no);

                            //print_r($data_label) ;

                            $result_reserved_qty_manu_label=$this->sales_order_item_parameterwise_model->get_total_issue_qty('reserved_quantity_manu',$this->session->userdata['logged_in']['company_id'],$data_label);

                            foreach ($result_reserved_qty_manu_label as  $rqml_row) {
                                $label_qty=$this->common_model->read_number($rqml_row->qty,$this->session->userdata['logged_in']['company_id']);
                            } 

                        // }else{
                        //     $label_qty=$this->common_model->read_number($labeling_row->demand_qty,$this->session->userdata['logged_in']['company_id']);
                        // } 


                    echo '
                        <tr class="item">
                            <td width="10%"></td>
                            <td width="5%"></td>
                            <td style="border:1px solid #D9d9d9;">'.$completed=($labeling_row->completed_flag==1 ? "<i class='check green circle icon'></i>" : "").' '.$this->common_model->get_article_name($labeling_row->article_no,$this->session->userdata['logged_in']['company_id']).'= <b>'.$label_qty.'</b> '.$uom.'</td>
                        </tr>';

                    }
                    echo "</table>";
                }
                ?>


                <?php
                    $foil=0;
                    if($foiling==TRUE){
                        $foil=1;

                        $data['workprocedure_types_master']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id','3');
                        foreach($data['workprocedure_types_master'] as $workprocedure_types_master){
                          $printing_rejection=$this->common_model->read_number($workprocedure_types_master->rejection_perc,$this->session->userdata['logged_in']['company_id']);
                        }
                        $printing_job_card_quantity="";
                        $printing_job_card_quantity=($jobcard_qty-($jobcard_qty/100)*$heading_rejection);
                        $printing_output_quantity=$printing_job_card_quantity-(($printing_job_card_quantity/100)*$printing_rejection);

                        $printing_job_card_quantity=$printing_job_card_quantity+(($printing_job_card_quantity/100)*$printing_rejection);

                        $data['workprocedure_types_master']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id','6');
                        foreach($data['workprocedure_types_master'] as $workprocedure_types_master){
                          $foiling_rejection=$this->common_model->read_number($workprocedure_types_master->rejection_perc,$this->session->userdata['logged_in']['company_id']);
                        }
                        
                        $foiling_job_card_quantity="";
                       //$foiling_job_card_quantity=($printing_output_quantity-($printing_output_quantity/100)*$foiling_rejection);
                        $foiling_job_card_quantity=$printing_output_quantity+(($printing_output_quantity/100)*$foiling_rejection);


                    echo '<br/><table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">                    
                        <tr class="heading">
                        <td colspan="8">FOILING MATERIAL FOR '.$foiling_job_card_quantity.' QUANTITY</td>
                        </tr>';

                    foreach($foiling as $foiling_row){
                        echo '<tr class="item">
                        <td width="10%"></td>
                        <td width="5%"></td>
                        <td width="35%">'.$completed=($foiling_row->completed_flag==1 ? "<i class='check green circle icon'></i>" : "").' '.$this->common_model->get_article_name($foiling_row->article_no,$this->session->userdata['logged_in']['company_id']).' = <b>'.$this->common_model->read_number($foiling_row->demand_qty,$this->session->userdata['logged_in']['company_id']).'</b></td>
                        <td width="10%"></td>
                        <td width="5%"></td>
                        <td width="35%"></td>
                        </tr>';


                        
                    }

                  echo '</table>';
                }

                ?>


                

                <?php

                    if($shoulder_foiling==TRUE){
                        $shoulder_foil=1;

                        $data['workprocedure_types_master']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id','3');
                            foreach($data['workprocedure_types_master'] as $workprocedure_types_master){
                              $printing_rejection=$this->common_model->read_number($workprocedure_types_master->rejection_perc,$this->session->userdata['logged_in']['company_id']);
                            }

                            $printing_job_card_quantity=($jobcard_qty-($jobcard_qty/100)*$heading_rejection);
                            $printing_output_quantity=$printing_job_card_quantity-(($printing_job_card_quantity/100)*$printing_rejection);
                            

                            $printing_job_card_quantity=$printing_job_card_quantity+(($printing_job_card_quantity/100)*$printing_rejection);

                        $data['workprocedure_types_master']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id','7');
                        foreach($data['workprocedure_types_master'] as $workprocedure_types_master){
                            $shoulder_foil_rejection=$this->common_model->read_number($workprocedure_types_master->rejection_perc,$this->session->userdata['logged_in']['company_id']);
                        }
                        $shoulder_foil_job_card_quantity="";
                        if($foil==1){

                            $data['workprocedure_types_master']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id','6');
                            foreach($data['workprocedure_types_master'] as $workprocedure_types_master){
                              $foiling_rejection=$this->common_model->read_number($workprocedure_types_master->rejection_perc,$this->session->userdata['logged_in']['company_id']);
                            }
                            
                            $foiling_job_card_quantity="";
                           //$foiling_job_card_quantity=($printing_output_quantity-($printing_output_quantity/100)*$foiling_rejection);
                            $foiling_job_card_quantity=$printing_output_quantity+(($printing_output_quantity/100)*$foiling_rejection);

                            $shoulder_foil_job_card_quantity=$foiling_job_card_quantity+(($foiling_job_card_quantity/100)*$shoulder_foil_rejection);
                        }else{

                            
                            
                            $shoulder_foil_job_card_quantity=$printing_output_quantity+(($printing_output_quantity/100)*$shoulder_foil_rejection);
                        }

                    echo '<br/><table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">                    
                        <tr class="heading">
                        <td colspan="8">SHOULDER FOILING MATERIAL FOR '.$shoulder_foil_job_card_quantity.' QUANTITY</td>
                        </tr>';

                    foreach($shoulder_foiling as $shoulder_foiling_row){
                        echo '<tr class="item">
                        <td width="10%"></td>
                        <td width="5%"></td>
                        <td width="35%">'.$completed=($shoulder_foiling_row->completed_flag==1 ? "<i class='check green circle icon'></i>" : "").' '.$this->common_model->get_article_name($shoulder_foiling_row->article_no,$this->session->userdata['logged_in']['company_id']).' = <b>'.$this->common_model->read_number($shoulder_foiling_row->demand_qty,$this->session->userdata['logged_in']['company_id']).'</b> SQM</td>
                        <td width="10%"></td>
                        <td width="5%"></td>
                        <td width="35%"></td>
                        </tr>';


                        
                    }

                  echo '</table>';
                }else{
                    $shoulder_foil="";
                }

                ?>


                <?php 
                if($capping==FALSE){

                }else{

                    $data['workprocedure_types_master']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id','11');
                      foreach($data['workprocedure_types_master'] as $workprocedure_types_master){
                        $capping_rejection=$this->common_model->read_number($workprocedure_types_master->rejection_perc,$this->session->userdata['logged_in']['company_id']);
                      }

                    $cap_job_card_quantity="";
                    if($foil==1){

                    $data['workprocedure_types_master']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id','6');
                    foreach($data['workprocedure_types_master'] as $workprocedure_types_master){
                      $foiling_rejection=$this->common_model->read_number($workprocedure_types_master->rejection_perc,$this->session->userdata['logged_in']['company_id']);
                    }
                    
                    $foiling_job_card_quantity="";
                    $foiling_job_card_quantity=$printing_output_quantity+(($printing_output_quantity/100)*$foiling_rejection);
                    $foiling_output_quantity=($printing_output_quantity-(($printing_output_quantity/100)*$foiling_rejection));
                    $cap_job_card_quantity=round($foiling_output_quantity+(($foiling_output_quantity/100)*$capping_rejection));

                      
                    }else if($shoulder_foil==1){

                        $data['workprocedure_types_master']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id','7');

                           foreach($data['workprocedure_types_master'] as $workprocedure_types_master){
                            $shoulder_foil_rejection=$this->common_model->read_number($workprocedure_types_master->rejection_perc,$this->session->userdata['logged_in']['company_id']);
                            }

                        
                        if($foil==1){
                        $shoulder_foil_job_card_quantity=$foiling_job_card_quantity+(($foiling_job_card_quantity/100)*$shoulder_foil_rejection);
                        $shoulder_foil_output_quantity=($foiling_output_quantity-(($foiling_output_quantity/100)*$shoulder_foil_rejection));
                        $cap_job_card_quantity=round($shoulder_foil_output_quantity+(($shoulder_foil_output_quantity/100)*$capping_rejection));

                        }else{
                            $shoulder_foil_job_card_quantity=$printing_output_quantity+(($printing_output_quantity/100)*$shoulder_foil_rejection);
                            $shoulder_foil_output_quantity=($printing_output_quantity-(($printing_output_quantity/100)*$shoulder_foil_rejection));
                            $cap_job_card_quantity=round($shoulder_foil_output_quantity+(($shoulder_foil_output_quantity/100)*$capping_rejection));
                        }
                      
                      }else{
                        $cap_job_card_quantity=round($printing_output_quantity+(($printing_output_quantity/100)*$capping_rejection));
                      }

                    echo '<br/><table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
                            <tr class="heading">
                                <td colspan="8">CAPPING FOR '.$jobcard_qty.' QUANTITY</td>
                            </tr>';

                     $cap_issue_qty=0;       
                    foreach($capping as $capping_row){

                        $data['article']=$ci->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$capping_row->article_no);
                            //echo $this->db->last_query();
                        foreach($data['article'] as $article_row){
                            $article_desc=$article_row->article_name;
                            $uom=$article_row->uom;
                        }
                     //Eknath-- 
                      $data_cap=array('manu_order_no' =>$jobcard_no,
                                        'article_no' =>$capping_row->article_no,
                                        'type_flag'=>'2');

                        $result_reserved_qty_manu_cap=$this->sales_order_item_parameterwise_model->get_total_issue_qty('reserved_quantity_manu',$this->session->userdata['logged_in']['company_id'],$data_cap);

                        //echo $this->db->last_query();
                        foreach ($result_reserved_qty_manu_cap as  $rqm_cap_row) {
                            $cap_issue_qty=$this->common_model->read_number($rqm_cap_row->qty,$this->session->userdata['logged_in']['company_id']);
                        }      
                    
                    echo '
                        <tr class="item">
                            <td width="10%"></td>
                            <td width="5%"></td>
                            <td style="border:1px solid #D9d9d9;">'.$completed=($capping_row->completed_flag==1 ? "<i class='check green circle icon'></i>" : "").' '.$article_desc.'= <b>'.($cap_issue_qty!=0?$cap_issue_qty:$this->common_model->read_number($capping_row->demand_qty,$this->session->userdata['logged_in']['company_id'])).'</b> '.$uom.'</td>
                        </tr>';

                    }
                    echo "</table>";
                    

                }
                ?>
                    
                
      


     
    <?php

        } // Foreach
    } // Else

    ?>
    <br/>

    <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
                    <tr class="heading">
                        <td colspan="5">AGAINST JOB CARD</td>
                
                    </tr>
                    <tr class="heading">
                        <td width="10%">SR NO</td>
                        <td  width="5%"></td>
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
                                <td>".$completed=($extrusion_additional_row->completed_flag==1 ? "<i class='check green circle icon'></i>" : "")." ".$article_desc."= <b>".$this->common_model->read_number($extrusion_additional_row->demand_qty,$this->session->userdata['logged_in']['company_id'])." </b> $article_uom</td>
                                
                                <td></td>
                            </tr>";
                            $i++;
                        } 
                    }
                    
                    ?>



    


    
    </div>
</body>
</html>
