
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
                        $spec_id=$order_details_row->spec_id;
                        $spec_version_no=$order_details_row->spec_version_no;
                    }
                }
                // $from_wip_order_no='';
                // if($production_row->jobcard_type==2){

                //     $data_search=array('release_to_order_no' =>$production_row->sales_ord_no,'status'=>'1','archive'=>'0');
                //     $extrusion_wip_result=$this->springtube_extrusion_wip_model->active_record_search('springtube_extrusion_wip_master',$this->session->userdata['logged_in']['company_id'],$data_search,'','');
                //     //echo $this->db->last_query();
                     
                //     foreach ($extrusion_wip_result as $key => $extrusion_wip_row) {
                //        $from_wip_order_no=$extrusion_wip_row->order_no;
                //     }
                // }

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

                    <tr class="heading" >
                        <td width="15%" style="border-bottom:1px solid #D9d9d9;">ORDER NO</td>
                        <td width="1%" style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>
                        <td width="25%" style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"><a href="<?php echo base_url('index.php/sales_order_book/view/'.$production_row->sales_ord_no);?>" target='_blank'><?php echo $production_row->sales_ord_no;?></a></td>
                        <td width="15%" style="border-bottom:1px solid #D9d9d9;">ORDER QTY</td>
                        <td width="1%" style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>
                        <td width="25%" style="border-bottom:1px solid #D9d9d9;"><?php echo number_format($this->common_model->read_number($total_order_quantity,$this->session->userdata['logged_in']['company_id']),0,'.',',');?></td>
                    </tr>
                    <tr class="item">
                        <td style="border-bottom:1px solid #D9d9d9;"><b>ARTICLE NO</b></td>
                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>
                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"><?php echo $production_row->article_no;?></td>
                        <td style="border-bottom:1px solid #D9d9d9;"><b>ARTICLE NAME</b></td>
                        <td style="border-bottom:1px solid #D9d9d9;;border-right:1px solid #D9d9d9"></td>
                        <td style="border-bottom:1px solid #D9d9d9;"><?php echo $this->common_model->get_article_name($production_row->article_no,$this->session->userdata['logged_in']['company_id']); ?></td>
                       
                    
                    </tr>

                    <tr class="item">
                        <td style="border-bottom:1px solid #D9d9d9;"><b>BOM</b></td>
                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>
                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"><b>
                            <?php
                            //if(!empty($this->uri->segment(4))){

                            if(!empty($spec_id) && !empty($spec_version_no)){

                                $bom=array('bom_no'=>$spec_id,
                                    'bom_version_no'=>$spec_version_no);
                                $data['bom']=$this->common_model->select_active_records_where("bill_of_material",$this->session->userdata['logged_in']['company_id'],$bom);

                                foreach($data['bom'] as $bom_row){

                                    

                                    echo "<a href='".base_url()."/index.php/bill_of_material/view/".$bom_row->bom_id."' target='blank'>".$spec_id."_".$spec_version_no."</a>";
                                }

                            }

                            ?>


                        </b></td>
                        <td style="border-bottom:1px solid #D9d9d9;"><b>ARTWORK NO</b></td>
                        <td  style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>
                        <td  style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"><?php echo ($artwork_no!='' ? "<b><a href='".base_url('index.php/'.(substr($artwork_no,0,3)=='SAW'?'artwork_springtube':'artwork_new').'/view/'.$artwork_no.'/'.$artwork_version)."' target='_blank'>".$artwork_no."_".$artwork_version."</a>": "NOT ATTACHED");?></td>
                    </tr>

                               
                    
                    <tr class="item">
                        <td style="border-bottom:1px solid #D9d9d9;"><b> NO. OF REELS</b></td>
                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>
                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"><?php echo ($no_of_reels!=''?number_format($no_of_reels,2,'.',',').'<i> NOS<i> ( REEL LENGTH - '.$reel_length.'<i> MTRS</i>)':''); ?></td>
                        <td style="border-bottom:1px solid #D9d9d9;"><b>JOB LENGTH</b></td>
                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>
                        <!-- <td><?php echo $no_of_reels*$reel_length; ?></td> -->
                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"><?php

                        $from_wip_order_no='';
                        if($production_row->jobcard_type==2){

                            $data_search=array('springtube_printing_wip_master_before.print_jobcard_no' =>$production_row->mp_pos_no,'springtube_printing_wip_master_before.archive'=>'0');
                            $extrusion_wip_result=$this->springtube_printing_wip_before_print_model->active_record_search('springtube_printing_wip_master_before',$this->session->userdata['logged_in']['company_id'],$data_search,'','');
                            //echo $this->db->last_query();
                             $total_meters=0;
                            foreach ($extrusion_wip_result as $key => $extrusion_wip_row) {
                               $total_meters+=$extrusion_wip_row->bprint_wip_meters;
                               //$from_wip_order_no=$extrusion_wip_row->order_no;
                               echo '<a href="'.base_url('index.php/sales_order_book/view/'.$extrusion_wip_row->from_order_no).'" target="_blank"><b>'.$extrusion_wip_row->from_order_no.'</b></a>, '.$extrusion_wip_row->bprint_wip_meters.' <i>MTRS</i>';
                               echo'</br>';
                            }
                            echo '<b>TOTAL JOB METERS = '.$total_meters.' <i>MTRS</i></b>';
                        }
                        elseif($production_row->jobcard_type==1){
                            echo '<b>TOTAL JOB METERS = '.$no_of_reels*$reel_length.' <i>MTRS</i></b>';
                        }
                        elseif($production_row->jobcard_type==3){
                            echo '<b>TOTAL PRINTING INPUT = '.$production_row->total_meters.' <i>MTRS</i></b>';
                        }
                         

                         //echo ($total_meters!=''?number_format($total_meters,0,'.',','). ' <i>MTRS, '.($production_row->jobcard_type==2?' FROM ORDER NO. <a href="'.base_url('index.php/sales_order_book/view/'.$from_wip_order_no).'" target="_blank"><b>'.$from_wip_order_no.'</b></a>':''):''); 
                         ?></td>
                    </tr>
                    <tr class="item">
                        <td style="border-bottom:1px solid #D9d9d9 "><b>JOB CARD QTY</b></td>
                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>
                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"><?php echo number_format($jobcard_qty,0,'.',','); ?></td>
                        <td style="border-bottom:1px solid #D9d9d9; "><b>CREATED BY</b></td>
                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>
                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"><?php echo strtoupper($user_name); ?></td>
                    </tr>

                    <tr class="item">
                        <td style="border-top:1px solid #D9d9d9;"><b>JOB COMMNET</b></td>
                        <td style="border-top:1px solid #D9d9d9;"></td>
                        <td style="border-top:1px solid #D9d9d9;" colspan="4"><?php echo strtoupper($production_row->comment);?></td>
                    
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

                <!-- COMMENT -->
                <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
                <tr class="item last">
                        <td width="15%" style="border-bottom:1px solid #D9d9d9;"><b>SPEC COMMENT</b></td>
                        <td width="4%"  style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>
                        <td  style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"><?php echo $comment;?></td>
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

                                            $search_extr=array('jobcard_no'=>$jobcard_no,
                                                          'part_no'=>ltrim($val_rm," "),
                                                          'qty'=>$extrusion_val);
                                            $data['tally_material_issue_master_extr']=$this->jobcard_issue_tally_model->active_record_search('tally_material_issue_master',$search_extr,'','');
                                            //echo $this->db->last_query();
                                            //print_r($data['tally_material_issue_master_extr']);
                                            $error='';
                                            foreach ($data['tally_material_issue_master_extr'] as $key => $tally_row) {
                                                $error= $tally_row->remarks;    
                                            }

                                            echo "<td style='border-right:1px solid #D9d9d9;'>".$completed=($com==0?"":($error!=''?"<i class='x red circle icon'></i>":"<i class='check green circle icon'></i>"))." ".$article_desc." (".$val_rm_per."%) = <b>" .$extrusion_val."</b> ".$uom."</td>";


                                              

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
                           <td style="border-bottom:1px solid #D9d9d9;"></td>
                           <td style="border-bottom:1px solid #D9d9d9;"></td>
                           <td style="border-bottom:1px solid #D9d9d9;">'.$this->common_model->get_article_name($material_manufacturing_summary_row->article_no,$this->session->userdata['logged_in']['company_id']).' = <b>'.$this->common_model->read_number($material_manufacturing_summary_row->demand_qty,$this->session->userdata['logged_in']['company_id']).'</b> KGS</td>
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
                            <td width="5%" ></td>
                            <td style="border-bottom:1px solid #D9d9d9;">'.$completed=($purging_row->completed_flag==1 ? "<i class='check green circle icon'></i>" : "").' '.$article_desc.'= <b>'.$this->common_model->read_number($purging_row->demand_qty,$this->session->userdata['logged_in']['company_id']).'</b> '.$uom.'</td>
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
                $data['workprocedure_types_master']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id','2');
                    foreach($data['workprocedure_types_master'] as $workprocedure_types_master){
                      $heading_rejection=$this->common_model->read_number($workprocedure_types_master->rejection_perc,$this->session->userdata['logged_in']['company_id']);
                    }
                ?>


            

                <?php

                    if($printing_input==TRUE){

                        if($production_row->jobcard_type==2){                            

                           //ARTWORk PRINT VIEW START------------- 

                           $artwork_springtube_result=$this->artwork_springtube_model->select_one_active_record('springtube_artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'springtube_artwork_devel_master.ad_id',$artwork_no,'springtube_artwork_devel_master.version_no',$artwork_version);

                            $followup_result=$this->common_model->select_followup_records('followup',$this->session->userdata['logged_in']['company_id'],'record_no',$artwork_no.'@@@'.$artwork_version);


                            foreach ($artwork_springtube_result as $artwork_springtube_row){

                                $result_dia=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','1');
                                $result_length=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','2');
                                $result_sleeve_color=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','3');
                    
                                $result_cold_foil_one=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','4');
                                

                                $cold_foil_one_length='';
                                $cold_foil_one_width='';
                                $result_cold_foil_one_length=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','19');

                                foreach($result_cold_foil_one_length as $cold_foil_one_length_row){
                                    $cold_foil_one_length=$cold_foil_one_length_row->parameter_value;
                                } 

                                 $result_cold_foil_one_width=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','20');

                                    foreach($result_cold_foil_one_width as $cold_foil_one_width_row){
                                            $cold_foil_one_width=$cold_foil_one_width_row->parameter_value;
                                    } 

                                
                                $result_cold_foil_two=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','6');
                                // $result_cold_foil_two_area=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','7');
                                $cold_foil_two_length='';
                                $cold_foil_two_width='';
                                $result_cold_foil_two_length=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','21');
                                foreach($result_cold_foil_two_length as $cold_foil_two_length_row){
                                         $cold_foil_two_length=$cold_foil_two_length_row->parameter_value;
                                } 


                                $result_cold_foil_two_width=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','22');

                                foreach($result_cold_foil_two_width as $cold_foil_two_width_row){
                                         $cold_foil_two_width=$cold_foil_two_width_row->parameter_value;
                                } 



                                $result_pre_lacquer_one=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','8');
                                
                                $result_pre_lacquer_one_perc=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','9');
                                
                                $result_pre_lacquer_two=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','10');

                                $result_pre_lacquer_two_perc=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','11');

                                $result_post_lacquer_one=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','12');
                                
                                $result_post_lacquer_one_perc=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','13');
                                
                                $result_post_lacquer_two=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','14');

                                $result_post_lacquer_two_perc=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','15');

                                $result_non_varnish_length=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','16');

                                $result_body_making_type=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','17');

                                $result_print_type=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$artwork_springtube_row->ad_id,'version_no',$artwork_springtube_row->version_no,'artwork_para_id','18');



                                echo'</br>
                                <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
                                    <tr class="heading" >
                                        <td colspan="6" style="border-bottom:1px solid #D9d9d9;" ><b>ARTWORK DETAILS</td>
                                    </tr>    
                                    <tr class="heading">
                                        <td width="15%" style="border-bottom:1px solid #D9d9d9;"><b>ARTWORK NO</td>
                                        <td width="1%" style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>
                                        <td width="25%" style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"><b>'.$artwork_springtube_row->ad_id.'</b></td>
                                        <td width="15%" style="border-bottom:1px solid #D9d9d9;">VERSION NO</td>
                                        <td width="1%" style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>
                                        <td width="25%" style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;">'.$artwork_springtube_row->version_no.'</td>
                                        
                                    </tr>
                                    <tr class="item last">
                                        <td style="border-bottom:1px solid #D9d9d9;">CUSTOMER</td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;">'.$artwork_springtube_row->customer_name.'//'. $artwork_springtube_row->adr_company_id.
                                        '</td>
                                        
                                        <td style="border-bottom:1px solid #D9d9d9;">ARTICLE</td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;">'.$artwork_springtube_row->article_name.'//'.$artwork_springtube_row->article_no.'</td>
                                    </tr>
                                    <tr class="heading">
                                        <td colspan="6" style="border-bottom:1px solid #D9d9d9;">
                                            OTHER DETAILS
                                        </td>
                                       
                                    </tr>
                                    <tr class="item last">
                                        <td style="border-bottom:1px solid #D9d9d9;"><b>ARTWORK FILE</b></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>                                       
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;">'.($artwork_springtube_row->artwork_image_nm!='' ? '<a href="'.base_url('assets/'.$this->session->userdata['logged_in']['company_id'].'/artwork_springtube/'.$artwork_springtube_row->artwork_image_nm.'').'" target="_blank"><i class="file pdf outline icon"></i></a>' :'').'</td>
                                        <td style="border-bottom:1px solid #D9d9d9;"><b>CUSTOMER APPR FILE</b></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;">'.($artwork_springtube_row->customer_artwork_pdf!='' ? '<a href="'.base_url('assets/'.$this->session->userdata['logged_in']['company_id'].'/artwork_springtube/'.$artwork_springtube_row->customer_artwork_pdf.'').'" target="_blank"><i class="file pdf outline icon"></i></a>' :'').'</td>

                                        
                                    </tr>
                                    <tr class="item last">
                                        <td style="border-bottom:1px solid #D9d9d9;" ><b>DIA</b></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;">';
                                        foreach($result_dia as $dia_row){ echo $dia_row->parameter_value; 
                                        }
                                        echo'</td>
                                        <td style="border-bottom:1px solid #D9d9d9;"><b>LENGTH</b></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;">';
                                        foreach($result_length as $length_row){
                                         echo $length_row->parameter_value; 
                                        }
                                    echo'</td>
                                    </tr>
                                    <tr class="item last">
                                        <td style="border-bottom:1px solid #D9d9d9;"><b>LAMINATE COLOR</b></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;">';
                                        foreach($result_sleeve_color as $sleeve_color_row){ echo strtoupper($sleeve_color_row->parameter_value); 
                                        }
                                        echo'</td>
                                        <td style="border-bottom:1px solid #D9d9d9;"><b>PRINT TYPE</b></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;">';
                                        foreach($result_print_type as $print_type_row){ 
                                            echo $print_type_row->parameter_value; 
                                        }
                                        echo'                                           
                                        </td>
                                    </tr>
                                    <tr class="item last">
                                        <td style="border-bottom:1px solid #D9d9d9;"><b>NON LACQUER LENGTH</b></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;">';
                                        foreach($result_non_varnish_length as $non_varnish_length_row){ 
                                            echo ($non_varnish_length_row->parameter_value!='0'?$non_varnish_length_row->parameter_value.'MM':'FULL VARNISH'); 
                                        }
                                        echo'</td>
                                        <td style="border-bottom:1px solid #D9d9d9; "><b>BODY MAKING TYPE</b></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"> ';
                                        foreach($result_body_making_type as $body_making_type_row){ echo $body_making_type_row->parameter_value; 
                                        }
                                    echo'</tr>

                                        <tr class="item last">
                                        <td style="border-bottom:1px solid #D9d9d9; "><b>FOIL ONE</b></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;">';
                                        foreach($result_cold_foil_one as $cold_foil_one_row){
                                                                    //echo $cold_foil_one_row->parameter_value;
                                            echo $this->common_model->get_article_name($cold_foil_one_row->parameter_value,$this->session->userdata['logged_in']['company_id']);
                                                    } 
                                                                
                                        echo'                   
                                        </td>
                                        <td style="border-bottom:1px solid #D9d9d9;"><b>FOIL ONE (L X W)</b></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;">'.($cold_foil_one_length!=''? $cold_foil_one_length.' MM':'').($cold_foil_one_width!=''?' X '.$cold_foil_one_width.' MM':'').'</td>
                                    </tr>

                                    <tr class="item last">
                                        <td style="border-bottom:1px solid #D9d9d9;"><b>FOIL TWO</b></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;">';
                                            foreach($result_cold_foil_two as $cold_foil_two_row){
                                                                    //echo $cold_foil_one_row->parameter_value;
                                                        echo $this->common_model->get_article_name($cold_foil_two_row->parameter_value,$this->session->userdata['logged_in']['company_id']);
                                                    } 
                                                                
                                        echo'</td>
                                        <td style="border-bottom:1px solid #D9d9d9;"><b>FOIL TWO (L X W)</b></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;">'.($cold_foil_two_length!=''? $cold_foil_two_length.' MM':'').($cold_foil_two_width!=''?' X '.$cold_foil_two_width.' MM':'').'</td>
                                    </tr>
                                    <tr class="item last">
                                        <td style="border-bottom:1px solid #D9d9d9;"><b>PRE LACQUER ONE</b></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;">';
                                        foreach($result_pre_lacquer_one as $result_pre_lacquer_one_row){ echo $this->common_model->get_article_name($result_pre_lacquer_one_row->parameter_value,$this->session->userdata['logged_in']['company_id']); 
                                         }
                                         echo'</td>
                                        <td style="border-bottom:1px solid #D9d9d9;"><b>PRE LACQUER ONE %</b></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;">';
                                        foreach($result_pre_lacquer_one_perc as $pre_lacquer_one_perc_row){ echo $pre_lacquer_one_perc_row->parameter_value; 
                                        }
                                        echo'</td>
                                    </tr>
                                    <tr class="item last">
                                        <td style="border-bottom:1px solid #D9d9d9;"><b>PRE LACQUER TWO</b></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;">';
                                        foreach($result_pre_lacquer_two as $pre_lacquer_two_perc_row){ echo $this->common_model->get_article_name($pre_lacquer_two_perc_row->parameter_value,$this->session->userdata['logged_in']['company_id']); 
                                    }
                                    echo'</td>
                                        <td style="border-bottom:1px solid #D9d9d9; "><b>PRE LACQUER TWO %</b></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;">';
                                        foreach($result_pre_lacquer_two_perc as $pre_lacquer_two_perc_row){ 
                                            echo $pre_lacquer_two_perc_row->parameter_value; 
                                        }
                                        echo'</td>
                                    </tr>
                                    <tr class="item last">
                                        <td style="border-bottom:1px solid #D9d9d9;"><b>POST LACQUER ONE</b></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;">';
                                            foreach($result_post_lacquer_one as $result_post_lacquer_one_row){ echo $this->common_model->get_article_name($result_post_lacquer_one_row->parameter_value,$this->session->userdata['logged_in']['company_id']); 
                                            }
                                        echo'</td>
                                        <td style="border-bottom:1px solid #D9d9d9;"><b>POST LACQUER ONE %</b></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;">';
                                        foreach($result_post_lacquer_one_perc as $post_lacquer_one_perc_row){ echo $post_lacquer_one_perc_row->parameter_value;
                                        }
                                        echo'</td>
                                    </tr>
                                    <tr class="item last">
                                        <td style="border-bottom:1px solid #D9d9d9;"><b>POST LACQUER TWO</b></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;">';
                                        foreach($result_post_lacquer_two as $post_lacquer_two_perc_row){ echo $this->common_model->get_article_name($post_lacquer_two_perc_row->parameter_value,$this->session->userdata['logged_in']['company_id']); 
                                        }
                                        echo'</td>
                                        <td style="border-bottom:1px solid #D9d9d9;"><b>POST LACQUER TWO %</b></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;">';
                                        foreach($result_post_lacquer_two_perc as $post_lacquer_two_perc_row){ echo $post_lacquer_two_perc_row->parameter_value; 
                                        }
                                        echo'</td>
                                    </tr>
                                    <tr>
                                        <td style="border-bottom:1px solid #D9d9d9; "><b>CREATED ON</b></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;">'.($artwork_springtube_row->ad_date!='0000-00-00'?$this->common_model->view_date($artwork_springtube_row->ad_date,$this->session->userdata['logged_in']['company_id']):'').'</td>
                                        
                                        <td style="border-bottom:1px solid #D9d9d9;"><b>APPROVED ON</b></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;">'.($artwork_springtube_row->approval_date!='0000-00-00'?$this->common_model->view_date($artwork_springtube_row->approval_date,$this->session->userdata['logged_in']['company_id']):'').'</td>
                                    </tr>
                                    <tr  class="heading">
                                        <td style="border-bottom:1px solid #D9d9d9;"><b>CREATED BY</b></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>
                                        <td  style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;">'.strtoupper($artwork_springtube_row->username).'</td>
                                        
                                        <td style="border-bottom:1px solid #D9d9d9;"><b>APPROVED BY</b></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>
                                        <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;">'.strtoupper($artwork_springtube_row->approval_username).'</td>
                                    </tr>
                                    
                                    </table>
                                    </br>';

                                    /*

                                    echo'<table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
                                        <tr class="heading">
                                            <td colspan="6" style="border:1px solid #D9d9d9" >APPROVAL FOLLOWUPS</td>
                                        </tr>
                                        <tr class="heading">
                                            <td width="5%" style="border-bottom:1px solid #D9d9d9;">SR NO</td>
                                            <td width="1%" style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>
                                            <td width="15%" style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;">DATE</td>
                                            <td width="15%" style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;">FROM</td>
                                            <td width="15%" style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;">TO</td>
                                            <td width="15%" style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;">STATUS</td>
                                        </tr>';

                                    if($followup_result==FALSE){
                                        echo'<tr>
                                                <td colspan="6">NO RECORD FOUND</td>
                                            </tr>';

                                    }else{
                                        foreach($followup_result as $followup_row){ 
                                            echo '<tr class="item">
                                                <td style="border-bottom:1px solid #D9d9d9;">'.$followup_row->transaction_no.'</td>
                                                <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;"></td>
                                                <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;">'.$this->common_model->view_date($followup_row->followup_date,$this->session->userdata['logged_in']['company_id']).'</td>
                                                <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;">'.strtoupper($followup_row->from_user).'</td>
                                                <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;">'.strtoupper($followup_row->to_user).'</td>
                                                <td style="border-bottom:1px solid #D9d9d9;border-right:1px solid #D9d9d9;">'.($followup_row->status==99 ? 'SETTLED' : '').' '.($followup_row->status==999 && $followup_row->approved_flag==1? 'APPROVED' : '').'
                                                    '.($followup_row->status==999 && $followup_row->approved_flag==2? 'REJECTED' : '').'
                                                    '.($followup_row->status==1 ? 'PENDING' : '').'</td>
                                            </tr>
                                            ';

                                        }
                                    } 

                                    echo'</table></br>';
                                */


                            }

                        }


                        //END OF ARTWORK PRITING VIEW--------------------------------------




                        $data['workprocedure_types_master']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id','3');
                        foreach($data['workprocedure_types_master'] as $workprocedure_types_master){
                          $printing_rejection=$this->common_model->read_number($workprocedure_types_master->rejection_perc,$this->session->userdata['logged_in']['company_id']);
                        }

                        $printing_job_card_quantity=($jobcard_qty-($jobcard_qty/100)*$heading_rejection);
                        $printing_output_quantity=$printing_job_card_quantity-(($printing_job_card_quantity/100)*$printing_rejection);

                        $printing_job_card_quantity=$printing_job_card_quantity+(($printing_job_card_quantity/100)*$printing_rejection);

                    echo '
                    <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">';

                        echo'<tr class="heading">
                        <td colspan="8" style="border-bottom:1px solid #D9d9d9;">PRINTING INPUT FOR '.$jobcard_qty.' QUANTITY</td>
                        </tr>';

                        foreach($printing_input as $printing_input_row){

                           
                                $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$printing_input_row->article_no);
                                        foreach($data['article'] as $article_row){
                                            $article_desc=$article_row->article_name;
                                            $article_group=$article_row->sub_group;
                                            $uom=$article_row->uom;

                                           
                                        }

                                echo '<tr  >
                                <td width="10%" style="border-bottom:1px solid #D9d9d9;">EXTRUSION FILM</td>
                                <td width="4%" style="border-bottom:1px solid #D9d9d9;"></td>
                                <td width="55%" style="border:1px solid #D9d9d9;">'.$completed=($printing_input_row->completed_flag==1 ? "<i class='check green circle icon'></i>" : "").' '.$this->common_model->get_article_name($printing_input_row->article_no,$this->session->userdata['logged_in']['company_id']).' = <b>'.$this->common_model->read_number($printing_input_row->demand_qty,$this->session->userdata['logged_in']['company_id']).'</b> ';
                                if($printing_input_row->article_no=='CON-FLEXO-PLT-0029'){
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

                    if($printing==TRUE){

                        $data['workprocedure_types_master']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id','3');
                        foreach($data['workprocedure_types_master'] as $workprocedure_types_master){
                          $printing_rejection=$this->common_model->read_number($workprocedure_types_master->rejection_perc,$this->session->userdata['logged_in']['company_id']);
                        }

                        $printing_job_card_quantity=($jobcard_qty-($jobcard_qty/100)*$heading_rejection);
                        $printing_output_quantity=$printing_job_card_quantity-(($printing_job_card_quantity/100)*$printing_rejection);

                        $printing_job_card_quantity=$printing_job_card_quantity+(($printing_job_card_quantity/100)*$printing_rejection);

                    echo '<br/>
                    <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">';

                        echo'<tr class="heading">
                        <td colspan="8" style="border-bottom:1px solid #D9d9d9;">PRINTING MATERIAL FOR '.$jobcard_qty.' QUANTITY</td>
                        </tr>';

                    foreach($printing as $printing_row){


                        $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$printing_row->article_no);
                        foreach($data['article'] as $article_row){
                            $article_desc=$article_row->article_name;
                            $article_group=$article_row->sub_group;
                            $uom=$article_row->uom;

                           
                        }

                        $search=array('jobcard_no'=>$jobcard_no,
                                      'part_no'=>$printing_row->article_no,
                                      'qty'=>$this->common_model->read_number($printing_row->demand_qty,$this->session->userdata['logged_in']['company_id']));
                        $data['tally_material_issue_master']=$this->jobcard_issue_tally_model->active_record_search('tally_material_issue_master',$search,'','');
                        $error='';
                        foreach ($data['tally_material_issue_master'] as $key => $tally_row) {
                            $error= $tally_row->remarks;    
                        }         

                        echo '<tr  >
                        <td width="10%"></td>
                        <td width="4%" style="border-right:1px solid #D9d9d9;"></td>
                        <td width="55%" style="border-bottom:1px solid #D9d9d9;">'.$completed=($printing_row->completed_flag==0?"": ($error!=''?"<i class='x red circle icon'></i>":"<i class='check green circle icon'></i>")).' '.$this->common_model->get_article_name($printing_row->article_no,$this->session->userdata['logged_in']['company_id']).' = <b>'.$this->common_model->read_number($printing_row->demand_qty,$this->session->userdata['logged_in']['company_id']).'</b> ';
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
                        <td colspan="8" style="border-bottom:1px solid #D9d9d9;">FOILING MATERIAL FOR '.$jobcard_qty.' QUANTITY</td>
                        </tr>';

                    foreach($foiling as $foiling_row){
                        $search=array('jobcard_no'=>$jobcard_no,
                                      'part_no'=>$foiling_row->article_no,
                                      'qty'=>$this->common_model->read_number($foiling_row->demand_qty,$this->session->userdata['logged_in']['company_id']));
                        $data['tally_material_issue_master']=$this->jobcard_issue_tally_model->active_record_search('tally_material_issue_master',$search,'','');
                        $error='';
                        foreach ($data['tally_material_issue_master'] as $key => $tally_row) {
                            $error= $tally_row->remarks;    
                        } 

                        echo '<tr class="item">
                        <td width="10%"></td>
                        <td width="4%"style="border-right:1px solid #D9d9d9;"></td>
                        <td width="55%">'.$completed=($foiling_row->completed_flag==0?"": ($error!=''?"<i style='color:red;'class='x red circle icon'></i>":"<i class='check green circle icon'></i>")).' '.$this->common_model->get_article_name($foiling_row->article_no,$this->session->userdata['logged_in']['company_id']).' = <b>'.$this->common_model->read_number($foiling_row->demand_qty,$this->session->userdata['logged_in']['company_id']).'</b></td>
                        <!--<td width="10%"></td>
                        <td width="5%"></td>
                        <td width="55%"></td>
                        -->
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

                // DECOSEAM--------

                if($extrusion==TRUE && $production_row->jobcard_type==3){

                    echo '<br/>
                    <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
                        <tr class="heading">
                            <td colspan="8">DECOSEAM FOR '.$jobcard_qty.' QUANTITY</td>
                        </tr>';

                    $decoseam_issue_qty=0;       
                    foreach($extrusion as $extrusion_row){

                        $data['article']=$ci->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$extrusion_row->article_no);
                            //echo $this->db->last_query();
                        foreach($data['article'] as $article_row){
                            $article_desc=$article_row->article_name;
                            $uom=$article_row->uom;
                        }                      

                        $search=array('jobcard_no'=>$jobcard_no,
                                      'part_no'=>$extrusion_row->article_no,
                                      'qty'=>$this->common_model->read_number($extrusion_row->demand_qty,$this->session->userdata['logged_in']['company_id'])
                                    );
                        $data['tally_material_issue_master']=$this->jobcard_issue_tally_model->active_record_search('tally_material_issue_master',$search,'','');
                        $error='';
                        foreach ($data['tally_material_issue_master'] as $key => $tally_row) {
                            $error= $tally_row->remarks;    
                        }    
                    
                        echo '
                        <tr class="item">
                            <td width="10%"></td>
                            <td width="5%"></td>
                            <td style="border:1px solid #D9d9d9;">'.$completed=($extrusion_row->completed_flag==0?"": ($error!=''?"<i class='x red circle icon'></i>":"<i class='check green circle icon'></i>")).' '.$article_desc.'= <b>'.$this->common_model->read_number($extrusion_row->demand_qty,$this->session->userdata['logged_in']['company_id']).'</b> KM '.($error!=''? ' (<b><i>'.$error.'</i></b>)':'').'
                            </td>
                        </tr>';

                    }

                    echo "</table>";
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

                        $search=array('jobcard_no'=>$jobcard_no,
                                      'part_no'=>$capping_row->article_no,
                                      'qty'=>$cap_issue_qty);
                        $data['tally_material_issue_master']=$this->jobcard_issue_tally_model->active_record_search('tally_material_issue_master',$search,'','');
                        $error='';
                        foreach ($data['tally_material_issue_master'] as $key => $tally_row) {
                            $error= $tally_row->remarks;    
                        }    
                    
                    echo '
                        <tr class="item">
                            <td width="10%"></td>
                            <td width="5%"></td>
                            <td style="border:1px solid #D9d9d9;">'.$completed=($capping_row->completed_flag==0?"": ($error!=''?"<i class='x red circle icon'></i>":"<i class='check green circle icon'></i>")).' '.$article_desc.'= <b>'.($cap_issue_qty!=0?$cap_issue_qty:$this->common_model->read_number($capping_row->demand_qty,$this->session->userdata['logged_in']['company_id'])).'</b> '.$uom.($error!=''? ' (<b><i>'.$error.'</i></b>)':'').'</td>
                        </tr>';

                    }
                    echo "</table>";
                    

                }


                // Heading-------------------
                
                if($heading==FALSE){

                }else{

                    $data['workprocedure_types_master']=$this->process_model->select_one_active_record('workprocedure_types_master',$this->session->userdata['logged_in']['company_id'],'workprocedure_types_master.work_proc_type_id','2');
                    foreach($data['workprocedure_types_master'] as $workprocedure_types_master){
                        $capping_rejection=$this->common_model->read_number($workprocedure_types_master->rejection_perc,$this->session->userdata['logged_in']['company_id']);
                    }                                         

                    echo '<br/>
                    <table cellpadding="0" cellspacing="0" style="border:1px solid #D9d9d9;">
                            <tr class="heading">
                                <td colspan="8">HEADING FOR '.$jobcard_qty.' QUANTITY</td>
                            </tr>';

                     $shoulder_issue_qty=0;       
                    foreach($heading as $heading_row){

                        $data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$heading_row->article_no);
                            //echo $this->db->last_query();
                        foreach($data['article'] as $article_row){
                            $article_desc=$article_row->article_name;
                            $uom=$article_row->uom;
                        }
                     //Eknath-- 
                      $data_shoulder=array('manu_order_no' =>$jobcard_no,
                                        'article_no' =>$heading_row->article_no,
                                        'type_flag'=>'2');

                        $result_reserved_qty_manu_shoulder=$this->sales_order_item_parameterwise_model->get_total_issue_qty('reserved_quantity_manu',$this->session->userdata['logged_in']['company_id'],$data_shoulder);

                        //echo $this->db->last_query();
                        foreach ($result_reserved_qty_manu_shoulder as  $rqm_shoulder_row) {
                            $shoulder_issue_qty=$this->common_model->read_number($rqm_shoulder_row->qty,$this->session->userdata['logged_in']['company_id']);
                        } 

                        $search_heading=array('jobcard_no'=>$jobcard_no,
                                      'part_no'=>$heading_row->article_no,
                                      'qty'=>$shoulder_issue_qty);
                        $data['tally_material_issue_master_heading']=$this->jobcard_issue_tally_model->active_record_search('tally_material_issue_master',$search_heading,'','');
                        $error='';
                        foreach ($data['tally_material_issue_master_heading'] as $key => $tally_row) {
                            $error= $tally_row->remarks;    
                        }      
                    
                    echo '
                        <tr class="item">
                            <td width="10%"></td>
                            <td width="5%"></td>
                            <td style="border:1px solid #D9d9d9;">'.$completed=($heading_row->completed_flag==0?"": ($error!=''?"<i class='x red circle icon'></i>":"<i class='check green circle icon'></i>")).' '.$article_desc.'= <b>'.($shoulder_issue_qty!=0?$shoulder_issue_qty:$this->common_model->read_number($heading_row->demand_qty,$this->session->userdata['logged_in']['company_id'])).'</b> '.$uom.($error!=''? ' (<b><i>'.$error.'</i></b>)':'').'</td>
                        </tr>';

                    }
                    echo "</table>";
                    

                }
                ?>


                
                <br/>

                <?php $production_master=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$production_row->mp_pos_no);

            //echo $this->db->last_query();
                        if($production_master==TRUE){

                            foreach ($production_master as $production_master_row) {

                                echo '<div class="ui compact menu">
                                      
                                      <a class="item">
                                        <i class="recycle icon"></i> Reused
                                      </a>

                                      <a class="item">
                                        <i class="stop white icon"></i> Top Box
                                        '.($production_master_row->top_box_flag==1 ? "<i class='check green circle icon'></i>" : "<i class='x red circle icon'></i>").'
                                      </a>
                                      <a class="item">
                                        <i class="icon brown inbox"></i> Bottom Box
                                        '.($production_master_row->bottom_box_flag==1 ? "<i class='check green circle icon'></i>" : "<i class='x red circle icon'></i>").'
                                      </a>
                                    </div>';
                                    
                            }
                        }else{

                        }
                        ?>
            
            <br/>


                <!-- ---Boxes -->
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

                            $search_box=array('jobcard_no'=>$jobcard_no,
                                          'part_no'=>$box_row->article_no,
                                          'qty'=>$this->common_model->read_number($box_row->demand_qty,$this->session->userdata['logged_in']['company_id']));
                            $data['tally_material_issue_master_box']=$this->jobcard_issue_tally_model->active_record_search('tally_material_issue_master',$search_box,'','');
                            $error='';
                            foreach ($data['tally_material_issue_master_box'] as $key => $tally_row) {
                                $error= $tally_row->remarks;    
                            }    
                    
                    echo '
                        <tr>
                            <td width="10%"></td>
                            <td width="5%"></td>
                            <td style="border:1px solid #D9d9d9;">'.$completed=($box_row->completed_flag==0?"": ($error!=''?"<i class='x red circle icon'></i>":"<i class='check green circle icon'></i>")).' '.$article_desc.' '.$article_sub_description.'= <b>'.$this->common_model->read_number($box_row->demand_qty,$this->session->userdata['logged_in']['company_id']).'</b> '.$uom.($error!=''? ' (<b><i>'.$error.'</i></b>)':'').'</td>
                        </tr>';
                        $j++;

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
                                <td><i class='check green circle icon'></i> ".$article_desc."= <b>".$this->common_model->read_number($extrusion_additional_row->total_qty,$this->session->userdata['logged_in']['company_id'])." </b> $article_uom</td>
                                
                                <td></td>
                            </tr>";
                            $i++;
                        } 
                    }
                    
                    ?>



    


    
    </div>
</body>
</html>
