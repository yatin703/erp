

<?php 

    $CI=&get_instance();

    foreach ($springtube_aql_rfd_master as $master_row):

    $customer='';
    $order_date='';
    $ad_id='';
    $version_no='';
    $body_making_type='';
    $print_type_artwork='';
    $bom_no='';
    $bom_id='';
    $bom_version_no='';
    $total_order_quantity=0;

    //Jobcard details  //production_master----
    $production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no', $master_row->jobcard_no);

    foreach($production_master_result as $production_master_row) {
      $order_no=$production_master_row->sales_ord_no;
      $article_no=$production_master_row->article_no;
    }
    //Order details-----------
    $order_master_result=$this->sales_order_book_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_master.order_no',$order_no);
    foreach($order_master_result as $order_master_row){
        $customer=$order_master_row->customer_name;
        $order_date=$order_master_row->order_date;
    }

    $data_order_details=array(
    'order_no'=>$order_no,
    'article_no'=>$article_no
    );

    $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
    foreach($order_details_result as $order_details_row){
      $bom_no=$order_details_row->spec_id;
      $bom_version_no=$order_details_row->spec_version_no;
      $ad_id=$order_details_row->ad_id;
      $version_no=$order_details_row->version_no;
    }

    // Artwork Details------------------
                            
    $data=array('ad_id'=>$ad_id,'version_no'=>$version_no);
    $search=array();
    $data['artwork_springtube']=$this->artwork_springtube_model->active_record_search_new('springtube_artwork_devel_master',$data,$search,'','',$this->session->userdata['logged_in']['company_id']);

    //print_r($data['artwork_springtube']);
    // BOM Details---------
    $data=array('bom_no'=>$bom_no,'bom_version_no'=>$bom_version_no);

    $bill_of_material_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data);

    foreach ($bill_of_material_result as $bill_of_material_row) {
      $bom_id=$bill_of_material_row->bom_id;
      $film_code=$bill_of_material_row->sleeve_code;
       
    }                                               

    //SLEEVE---------------------------------

    $film_spec_id='';
    $film_spec_version='';

    $film_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$film_code);

    foreach($film_code_result as $film_code_row){                                       
        $film_spec_id=$film_code_row->spec_id;
        $film_spec_version=$film_code_row->spec_version_no;
    }

    $specs['spec_id']=$film_spec_id;
    $specs['spec_version_no']=$film_spec_version;

    $specs_result=$this->sales_order_book_model->select_film_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$specs);
    
    if($specs_result){

        foreach($specs_result as $specs_row){
                $sleeve_diameter=$specs_row->SLEEVE_DIA;
                $sleeve_length=$specs_row->SLEEVE_LENGTH;
                $sleeve_mb_2=$specs_row->FILM_MASTER_BATCH_2;
                $sleeve_mb_6=$specs_row->FILM_MASTER_BATCH_6;               

        }                                           
    }
?>
   
    <br/>
    <br/>  
    <div class="ui teal labels" style="text-align: center;">
      <div class="ui label">
        SPRING TUBE SQC REPORT
      </div>
    </div>

        <!-- <?php echo $master_row->final_approval_flag==1 ? '<span class="ui green right ribbon label"><i class="check circle icon"></i> Approved</span>' : '<span class="ui red right ribbon label">Unapproved</span>';?>

        <br/> -->

        <?php echo $this->common_model->view_date($master_row->aql_date,$this->session->userdata['logged_in']['company_id'])!='' ? '<span class="ui blue left ribbon label"><i class="calendar alternate outline icon"></i>'.$this->common_model->view_date($master_row->aql_date,$this->session->userdata['logged_in']['company_id']).'</span>' : '';
        ?>
        
        <br/>
        <br/>

        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">

            <tr class="heading" style="border-right:1px solid #D9d9d9;" >
                <td width="10%"> <i class="cogs icon"></i> PROCESS</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><?php echo 'SPRING TUBE SQC';?></td>
                <td width="15%"><i class="user secret icon"></i>QC NAME</td>                
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="30%"><?php echo $master_row->user_id ;?></td>
            </tr>            

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td width="10%">  CUSTOMER</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><?php echo $customer;?></td>
                <td width="15%"> PRODUCT CODE</td>                
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="30%"><?php echo $article_no ;?></td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td width="10%">  PRODUCT NAME</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><?php echo $this->common_model->get_article_name($article_no,$this->session->userdata['logged_in']['company_id']);?></td>
                <td width="15%"> SPECIFICATION</td>                
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="30%"><?php echo $sleeve_diameter.' X '.$sleeve_length.' MM' ;?></td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td width="10%">ORDER NO</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><?php echo "<a href='".base_url('index.php/sales_order_book/view/'.$order_no)."' target='_blank'> ".$order_no."</a>";?></td>
                <td width="15%">JOBCARD NO</td>                
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="30%"><?php echo "<a href='".base_url('index.php/sales_order_item_parameterwise/view_new/'.$master_row->jobcard_no.'/'.$bom_no.'/'.$bom_version_no)."' target='_blank'>".$master_row->jobcard_no."</a>" ;?></td>
            </tr>
            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td width="10%">ARTWORK</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><?php echo "<a href='".base_url('index.php/artwork_springtube/view/'.$ad_id.'/'.$version_no)."' target='_blank'>".$ad_id."_".$version_no."</a>";?></td>
                <td width="15%">VERSION</td>                
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="30%"><?php echo $version_no ;?></td>
            </tr>
            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td width="10%">SPEC NO</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><?php echo "<a href='".base_url('index.php/bill_of_material/view/'.$bom_id)."' target='_blank'>".$bom_no."_".$bom_version_no."</a>" ;?></td>
                <td width="15%">SPEC VERSION NO</td>                
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="30%"><?php echo $bom_version_no ;?></td>
            </tr>
        </table>
        <br/>               
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            
            <tr class="heading" style="border-right:1px solid #D9d9d9;" >
                <td width="30%" >BODYMAKING INSPECTION</td>
                <td width="5%" ></td> 
                <td width="15%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="30%"><b>PRINTING INSPECTION</b></td>
                <td width="5%" ></td>              
                <td width="15%" ></td>
            </tr>
            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td width="30%">SEAM WELDING (IN STARTUP BOX) DECOSEAM ONE SIDE</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="15%" style="border-right:1px solid #D9d9d9;"><?php echo $master_row->seam_welding_stratup_box;?></td>
                <td width="30%">SMUDGE PRINTING</td>                
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="15%"><?php echo $master_row->smudge_printing ;?></td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td width="30%">SEAM WELDING (IN OK BOX)</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="15%" style="border-right:1px solid #D9d9d9;"><?php echo $master_row->seam_welding_ok_box;?></td>
                <td width="30%">PRINT / FOIL MISS REGISTRATION</td>                
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="15%"><?php echo $master_row->print_miss_registration ;?></td>
            </tr> 
            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td width="30%">SHOULDER WELDING (IN OK BOX) ONE SIDE DECOSEAM</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="15%" style="border-right:1px solid #D9d9d9;"><?php echo $master_row->shoulder_welding_ok_box;?></td>
                <td width="30%">FOIL CUT / UNSHARP FOIL </td>                
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="15%"><?php echo $master_row->foil_cut ;?></td>
            </tr> 
            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td width="30%">INK FLAKING (INK WRINKLES IN SEAM) </td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="15%" style="border-right:1px solid #D9d9d9;"><?php echo $master_row->ink_flaking;?></td>
                <td width="30%">STOPAGE MARKS</td>                
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="15%"><?php echo $master_row->stopage_marks ;?></td>
            </tr> 
            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td width="30%">CAP ORIANTATION ALIGNMENT</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="15%" style="border-right:1px solid #D9d9d9;"><?php echo $master_row->cap_oriantation_alignment;?></td>
                <td width="30%">WITHOUT VARNSIH</td>                
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="15%"><?php echo $master_row->without_varnish ;?></td>
            </tr> 
            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td width="30%">WRONG POSITION TUBE CUTTING </td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="15%" style="border-right:1px solid #D9d9d9;"><?php echo $master_row->wrong_position_tube_cutting;?></td>
                <td width="30%">WET VARNISH / MOTLLING </td>                
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="15%"><?php echo $master_row->wet_varnish ;?></td>
            </tr> 
            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td width="30%">SCRATCH LINES</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="15%" style="border-right:1px solid #D9d9d9;"><?php echo $master_row->scratch_line;?></td>
                <td width="30%">STREAKS / NOZZLE LINES</td>                
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="15%"><?php echo $master_row->streaks_nozzle_lines ;?></td>
            </tr> 
            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td width="30%"> CAP GAP ISSUE</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="15%" style="border-right:1px solid #D9d9d9;"><?php echo $master_row->cap_gap_issue;?></td>
                <td width="30%">GHOST PRINTING</td>                
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="15%"><?php echo $master_row->ghost_printing ;?></td>
            </tr> 
            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td width="30%"></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="15%" style="border-right:1px solid #D9d9d9;"><?php echo '';?></td>
                <td width="30%">NOZZLE INK DOTS </td>                
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="15%"><?php echo $master_row->nozzle_ink_dots ;?></td>
            </tr> 
            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td width="30%"></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="15%" style="border-right:1px solid #D9d9d9;"><?php echo '';?></td>
                <td width="30%">REEL TRIMMING ISSUE</td>                
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="15%"><?php echo $master_row->reel_trimming_issue ;?></td>
            </tr> 
            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td width="30%"></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="15%" style="border-right:1px solid #D9d9d9;"><?php echo '';?></td>
                <td width="30%">OTHER PRINTING DEFECTS</td>                
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="15%"><?php echo $master_row->other_print_defects ;?></td>
            </tr>
            <tr class="heading" style="border-right:1px solid #D9d9d9;" >
                <td width="30%" >TOTAL BODYMAKING REJECTION</td>
                <td width="5%" ></td> 
                <td width="15%" style="border-right:1px solid #D9d9d9;"><?php echo $master_row->total_rejected_bodymaking_issue ;?></td>
                <td width="30%"><b>TOTAL PRINTING REJECTION</b></td>
                <td width="5%" ></td>              
                <td width="15%" ><?php echo $master_row->total_rejected_printing_issue ;?></td>
            </tr>
        </table>
    </br>
    
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;"> 

            <tr class="heading" style="border-right:1px solid #D9d9d9;" >
                <td width="30%" >SUMMARY</td>
                <td width="5%" ></td> 
                <td width="15%" ></td>
                <td width="30%"></td>
                <td width="5%" ></td>              
                <td width="15%" ></td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td width="30%" ><b>INSPECTION QTY</b></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td> 
                <td width="15%" style="border-right:1px solid #D9d9d9;"><b><?php echo $master_row->inspection_qty ;?></b></td>
                <td width="30%"><b><?php echo $CI->spring_aql_input_boxes($master_row->jobcard_no,$master_row->inspection_qty). ' BOXES';?></b></td>
                <td width="5%" ></td>              
                <td width="15%" ></td>
            </tr>
            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td width="30%" ><b>TOTAL REJECTED QTY</b></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td> 
                <td width="15%" style="border-right:1px solid #D9d9d9;"><b><?php echo $master_row->total_rejected_qty ;?></b></td>
                <td width="30%"><b><?php echo $CI->spring_aql_input_boxes($master_row->jobcard_no,$master_row->total_rejected_qty). ' BOXES';?></b></td>
                <td width="5%" ></td>              
                <td width="15%" ></td>
            </tr>
            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td width="30%" ><b>COUNTER SAMPLE</b></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td> 
                <td width="15%" style="border-right:1px solid #D9d9d9;" ><b><?php echo $master_row->counter_sample_qty ;?></b></td>
                <td width="30%"><b><?php echo ($master_row->counter_sample_qty!=0 ?$CI->spring_aql_input_boxes($master_row->jobcard_no,$master_row->counter_sample_qty). ' BOXES':'');?></b></td>
                <td width="5%" ></td>              
                <td width="15%" ></td>
            </tr>
            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td width="30%" ><b>RFD QTY</b></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td> 
                <td width="15%" style="border-right:1px solid #D9d9d9;"><b><?php echo $master_row->rfd_qty ;?></b></td>
                <td width="30%"><b><?php echo $CI->spring_aql_input_boxes($master_row->jobcard_no,$master_row->rfd_qty). ' BOXES';?></b></td>
                <td width="5%" ></td>              
                <td width="15%" ></td>
            </tr>
        </table>      
                
     <?php endforeach;?>
    </div>
</body>
</html>   