

<?php foreach ($springtube_bodymaking_control_plan_qc as $master_row):

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
   
      
    <div class="ui teal labels" style="text-align: center;">
      <div class="ui label">
        CONTROL PLAN OF BODY MAKING SPRING TUBE
      </div>
    </div>

        <!-- <?php echo $master_row->final_approval_flag==1 ? '<span class="ui green right ribbon label"><i class="check circle icon"></i> Approved</span>' : '<span class="ui red right ribbon label">Unapproved</span>';?>

        <br/> -->

        <?php echo $this->common_model->view_date($master_row->inspection_date,$this->session->userdata['logged_in']['company_id'])!='' ? '<span class="ui blue left ribbon label"><i class="calendar alternate outline icon"></i>'.$this->common_model->view_date($master_row->inspection_date,$this->session->userdata['logged_in']['company_id']).'</span>' : '';
        ?>
        
        <br/>
        <br/>

        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">

            <tr class="heading" style="border-right:1px solid #D9d9d9;" >
                <td width="10%"> <i class="cogs icon"></i> PROCESS</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><?php echo 'SPRINGTUBE BODY MAKING';?></td>
                <td width="15%"><i class="user secret icon"></i> OPERATOR</td>                
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="30%"><?php echo $master_row->operator ;?></td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td width="10%"> <i class="cogs icon"></i> MACHINE</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><?php echo $master_row->machine_name;?></td>
                <td width="15%"><i class="stop watch icon"></i> TIME</td>                
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="30%"><?php echo $master_row->inspection_time ;?></td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td width="10%"> <i class="bars icon"></i> CUSTOMER</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><?php echo $customer;?></td>
                <td width="15%"><i class="bars icon"></i> PRODUCT CODE</td>                
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="30%"><?php echo $article_no ;?></td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td width="10%"> <i class="bars icon"></i> PRODUCT NAME</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><?php echo $this->common_model->get_article_name($article_no,$this->session->userdata['logged_in']['company_id']);?></td>
                <td width="15%"><i class="bars icon"></i> SPECIFICATION</td>                
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="30%"><?php echo $sleeve_diameter.' X '.$sleeve_length.' MM' ;?></td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td width="10%"> <i class="bars icon"></i> ORDER NO</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><?php echo $order_no;?></td>
                <td width="15%"><i class="bars icon"></i> JOBCARD NO</td>                
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="30%"><?php echo $master_row->jobcard_no ;?></td>
            </tr>
            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td width="10%"> <i class="bars icon"></i> ARTWORK</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><?php echo $ad_id;?></td>
                <td width="15%"><i class="bars icon"></i> VERSION</td>                
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="30%"><?php echo $version_no ;?></td>
            </tr>
            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td width="10%"> <i class="user secret icon"></i> QC INCHARGE</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><?php echo $this->common_model->get_user_name($master_row->user_id,$this->session->userdata['logged_in']['company_id']);?></td>
                <td width="15%"><i class="user secret icon"></i> STATUS OF INSPECTION</td>                
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="30%"><?php echo ($master_row->qc_inspection_status==1?"APPROVED":($master_row->qc_inspection_status==2?"REJECT":"HOLD"));?></td>
            </tr>

            <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td width="10%">  REMARKS</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;" colspan="4"><?php echo $master_row->qc_remarks;?></td>
                <!-- <td width="15%"> </td>                
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="30%"></td> -->
            </tr>

        </table>


        <br/>
       
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            
            <tr class="heading" style="border-right:1px solid #D9d9d9;" >
                <td width="15%" >PARAMETER</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="11%" style="border-right:1px solid #D9d9d9;"><b>ACCEPTANCE CRITERIA</b></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"><b>OBSERVATIONS</b></td>                
                <td width="5%" style="border-right:1px solid #D9d9d9;"><b>STATUS (PASS/FAIL)</b></td>
                                
            </tr>        
             
            <tr class="item">
                <td >SHADE VARIATION</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">As per shade card or approved Pantone</td>               
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->shade_variation ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->shade_variation_status==1?"PASS":($master_row->shade_variation_status==2?"FAIL":"N/A"));?>
            </tr>
            <tr class="item">
                <td>TEXT PROOF</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">As per approved Artwork</td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->text_proof ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->text_proof_status==1?"PASS":($master_row->text_proof_status==2?"FAIL":"N/A"));?>
            </tr>
             
            <tr class="item">
                <td>NO PRINT AREA</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">As per approved Artwork</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->non_print_area ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->non_print_area_status==1?"PASS":($master_row->non_print_area_status==2?"FAIL":"N/A"));?>
            </tr>
            <tr class="item">
                <td>I MARK POSITION/REGISTRATION</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">Check against Positive</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->i_mark_position ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->i_mark_position_status==1?"PASS":($master_row->i_mark_position_status==2?"FAIL":"N/A"));?>
            </tr>
             
            <tr class="item">
                <td>PRINT CUT</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">No Print cut</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->print_cut ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->print_cut_status==1?"PASS":($master_row->print_cut_status==2?"FAIL":"N/A"));?>
            </tr>
            <tr class="item">
                <td>SMUDGE PRINT</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">No Smudge print</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->smudge_print ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->smudge_print_status==1?"PASS":($master_row->smudge_print_status==2?"FAIL":"N/A"));?>
            </tr>

            <tr class="item ">
                <td>INK DOT</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">No Ink dot</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->ink_dot ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->ink_dot_status==1?"PASS":($master_row->ink_dot_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >GHOST PRINT</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">No Ghost Print</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->ghost_print ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->ghost_print_status==1?"PASS":($master_row->ghost_print_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >MOTLING</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">No Motling</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->motling ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->motling_status==1?"PASS":($master_row->motling_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >TAPE TEST</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">Should be pass in 3M Scotch tape(616)</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->tape_test ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->tape_test_status==1?"PASS":($master_row->tape_test_status==2?"FAIL":"N/A"));?></td>
            </tr>

            <tr class="item">
                <td >RUB TEST</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">Should be pass in thumb rub</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->rub_test ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->rub_test_status==1?"PASS":($master_row->rub_test_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >PRINT SURFACE LINE</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">No print surface scratch line</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->print_surface_line ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->print_surface_line_status==1?"PASS":($master_row->print_surface_line_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >MISS PRINT</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">No miss print</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->miss_print ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->miss_print_status==1?"PASS":($master_row->miss_print_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >BARCODE TEST</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">Must be read by Barcode reader</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->barcode_test ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->barcode_test_status==1?"PASS":($master_row->barcode_test_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >CONTAMINATION ISSUE</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">No Contamination</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->contamination ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->contamination_status==1?"PASS":($master_row->contamination_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >NON LACQUER AREA</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">As per approved Artwork +-1mm</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->non_lacquer_area ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->non_lacquer_area_status==1?"PASS":($master_row->non_lacquer_area_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >WET LACQUER</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">No Wet lacquer</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->wet_lacquer ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->wet_lacquer_status==1?"PASS":($master_row->wet_lacquer_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >LACQUER PEELOFF</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">No Lacquer Peeloff</td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->lacquer_peeloff;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->lacquer_peeloff_status==1?"PASS":($master_row->lacquer_peeloff_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >WAVY LACQUER</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">No Wavy Lacquer</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->wavy_lacquer ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->wavy_lacquer_status==1?"PASS":($master_row->wavy_lacquer_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >DULL LACQUER</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">No Dull Lacquer</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->dull_lacquer ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->dull_lacquer_status==1?"PASS":($master_row->dull_lacquer_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >DIRTY LACQUER</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">No Dirty Lacquer</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->dirty_lacquer ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->dirty_lacquer_status==1?"PASS":($master_row->dirty_lacquer_status==2?"FAIL":"N/A"));?></td>
            </tr>

            <tr class="item">
                <td >FOIL CUT</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">Check against approved Artwork shrink positive</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->foil_cut ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->foil_cut_status==1?"PASS":($master_row->foil_cut_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >FOIL SHIFT (VERTICAL)</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">Check against approved Artwork shrink positive</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->foil_shift_vertical ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->foil_shift_vertical_status==1?"PASS":($master_row->foil_shift_vertical_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >FOIL SHIFT (HORIZONTAL)</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">Check against approved Artwork shrink positive</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->foil_shift_horizontal ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->foil_shift_horizontal_status==1?"PASS":($master_row->foil_shift_horizontal_status==2?"FAIL":"N/A"));?></td>
            </tr>

            <tr class="item">
                <td >FOIL THICKNESS</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">Check against approved Artwork shrink positive</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->foil_thickness ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->foil_thickness_status==1?"PASS":($master_row->foil_thickness_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >SLEEVE COLOR/CODE</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">As per jobcard and customer specification positive</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->sleeve_color_code ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->foil_thickness_status==1?"PASS":($master_row->sleeve_color_code_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >LENGTH OF TUBE</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">As per jobcard and customer specification positive</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->tube_length ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->foil_thickness_status==1?"PASS":($master_row->tube_length_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="heading"><td colspan="5">SHOULDER PARAMETER</td></tr>
            <tr class="item">
                <td >ORIFICE DIAMETER</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">As per jobcard and customer specification positive</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->orifice_diameter  ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->orifice_diameter_status==1?"PASS":($master_row->orifice_diameter_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >WELDING DEFECT</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">Welding breaking force NLT 45 N</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->welding_defect  ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->welding_defect_status==1?"PASS":($master_row->welding_defect_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >SHOULDER BLEND</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">Should be proper and Straight</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->shoulder_blend  ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->shoulder_blend_status==1?"PASS":($master_row->shoulder_blend_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >THREAD FLASH</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">No thread flash</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->thread_flash  ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->thread_flash_status==1?"PASS":($master_row->thread_flash_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >NO EXCESS MATERIAL</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">No Excess Material</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->excess_material  ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->excess_material_status==1?"PASS":($master_row->excess_material_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >SHORT SHOT</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">No short shot</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->short_shot  ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->short_shot_status==1?"PASS":($master_row->short_shot_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >ORIFICE BLOCK</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">Orifice should be clear and No block</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->orifice_block;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->orifice_block_status==1?"PASS":($master_row->orifice_block_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >FOLDING</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">No Folding</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->shoulder_folding  ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->shoulder_folding_status==1?"PASS":($master_row->shoulder_folding_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >TUBE PERFORATED</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">No tube perforated</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->tube_perforated  ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->tube_perforated_status==1?"PASS":($master_row->tube_perforated_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >SHOULDER CONTAMINATION</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">No contamination/dust/oil mark  </td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->shoulder_contamination  ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->shoulder_contamination_status==1?"PASS":($master_row->shoulder_contamination_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="heading"><td colspan="5">CAP PARAMETER</td></tr>
            <tr class="item">
                <td >PINTAL DAMAGE</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">No pintal damage</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->cap_pintle_damage;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->cap_pintle_damage_status==1?"PASS":($master_row->cap_pintle_damage_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >CAP DAMAGE</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">No cap damage</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->cap_damage;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->cap_damage_status==1?"PASS":($master_row->cap_damage_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >NO CRACK/SCRATCH IN CAP</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">No crack/scratch in cap</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->cap_scratch;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->cap_scratch_status==1?"PASS":($master_row->cap_scratch_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >CAP ALIGNMENT</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">Should be allign with eye mark</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->cap_allignment;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->cap_allignment_status==1?"PASS":($master_row->cap_allignment_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >TUBE FOLDING</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">No cap folding</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->cap_tube_folding;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->cap_tube_folding_status==1?"PASS":($master_row->cap_tube_folding_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >CAP FITTING</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">No gap between cap and shoulder and no loose cap</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->cap_fitting;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->cap_fitting_status==1?"PASS":($master_row->cap_fitting_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >AIR LEAKAGE WITH CAP</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">No air leakage 0.5 bar air leackage</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->cap_air_leackage;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->cap_air_leackage_status==1?"PASS":($master_row->cap_air_leackage_status==2?"FAIL":"N/A"));?></td>
            </tr>

            <tr class="item">
                <td >CAP ROTATION</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">No cap ratation</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->cap_rotation;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->cap_rotation_status==1?"PASS":($master_row->cap_rotation_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >PULL FORCE IN SNAP CAP</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;"> : Not remove easily</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->cap_pull_force;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->cap_pull_force_status==1?"PASS":($master_row->cap_pull_force_status==2?"FAIL":"N/A"));?></td>
            </tr>

            <tr class="item">
                <td >HINGE BREACK</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">No hinge breack</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->cap_hinge_breack;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->cap_hinge_breack_status==1?"PASS":($master_row->cap_hinge_breack_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >CAP SHRINK SLEEVE (PRINTED/PLAIN)</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">As per specification</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->cap_shrink_sleeve;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->cap_shrink_sleeve_status==1?"PASS":($master_row->cap_shrink_sleeve_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >CAP (WITH FOIL/WITHOUT FOIL)</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">As per specification</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->cap_foil;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->cap_foil_status==1?"PASS":($master_row->cap_foil_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >CAP FOIL THICKNESS VARIATION</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">Thickness should be as per specification</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->cap_foil_thickness_vari;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->cap_foil_thickness_vari_status==1?"PASS":($master_row->cap_foil_thickness_vari_status==2?"FAIL":"N/A"));?></td>
            </tr>









        </table>

        <br/>
        <br/>
               


        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            
            <tr class="heading" style="border-right:1px solid #D9d9d9;" >
                <td width="13%">LINE CLEARANCE (Y/N)</td>
                <td width="1%"></td>
                <td width="10%">STATUS (Y/N)</td>                
                <td width="5%"></td>
                <td width="5%"></td>
            </tr>
        
            <tr class="item ">
                <td>MASTER FILE AND JOBCARD RETURN TO PRODUCTION DEPARTMENT</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td ><?php echo ($master_row->masterfile_jobcard_return_status==1?"YES":"NO") ;?></td>                
                <td></td> 
                <td></td>               
                
            </tr>
            <tr class="item">
                <td>REMAINING RAW MATERIAL RETURNED TO PRODUCTION AREA</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td><?php echo ($master_row->rm_return_status==1?"YES":"NO") ;?></td>                
                <td></td> 
                <td></td>               
                
            </tr>
            <tr class="item">
                <td>RED CREATE ON EVERY MACHINE FOR REJECTED MATERIAL</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td><?php echo ($master_row->red_create_status==1?"YES":"NO") ;?></td>                
                <td></td> 
                <td></td>               
                
            </tr>
            <tr class="item">
                <td>CLEAR ALL REJECTED ROLLS FROM THE REJECTION AREA</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td><?php echo ($master_row->rejected_tubes_clear_status==1?"YES":"NO") ;?></td>                
                <td></td> 
                <td></td>               
               
            </tr>
            <tr class="item">
                <td>NO LOOSE TOOLS </td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td><?php echo ($master_row->no_loose_tools_status==1?"YES":"NO") ;?></td>                
                <td></td> 
                <td></td>               
                
            </tr>
            <tr class="item">
                <td>NO SLEEVE/TUBES OF PREV JOB</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td><?php echo ($master_row->no_tubes_prevjob_status==1?"YES":"NO") ;?></td>                
                <td></td> 
                <td></td>               
                
            </tr>
            <tr class="item last">
                <td>SURROUNDING AND MACHINE CLEAN</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td><?php echo ($master_row->machine_clean_status==1?"YES":"NO") ;?></td>                
                <td></td> 
                <td></td>               
               
            </tr>
            <tr class="item last">
                <td>CLEANING OF HOOPER FOR CAP AND SHOULDER</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td><?php echo ($master_row->hooper_cleaning_status==1?"YES":"NO") ;?></td>                
                <td></td> 
                <td></td>               
               
            </tr>
            <tr class="item last">
                <td>MACHINE READY FOR SET UP</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td><?php echo ($master_row->machine_ready_status==1?"YES":"NO") ;?></td>                
                <td></td> 
                <td></td>               
               
            </tr>
            <tr class="item last">
                <td>FINGER/COMB IS CLEANED</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td><?php echo ($master_row->finger_comb_status==1?"YES":"NO") ;?></td>                
                <td></td> 
                <td></td>               
                
            </tr>

        </table>

        <br/>

        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            
            <tr class="heading" style="border-right:1px solid #D9d9d9;" >
                <td width="13%">REASONS FOR SETUP APPROVAL</td>
                <td width="1%"></td>
                <td width="10%">STATUS (Y/N)</td>                
                <td width="5%"></td>
                <td width="5%"></td>
            </tr>

            <tr class="item">
                <td> </td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td  >
                    <input type="checkbox" name="new_job_status" value="1" <?php echo ($master_row->new_job_status==1 ? 'checked': '');?>>NEW JOB<br/>

                    <input type="checkbox" name="power_failure_status" value="1" <?php echo ($master_row->power_failure_status==1 ? 'checked': '');?>>POWER FAILURE<br/>

                    <input type="checkbox" name="change_of_rm_status" value="1" <?php echo ($master_row->change_of_rm_status==1 ? 'checked': '');?>>CHNAGE OF RM<br/>

                    <input type="checkbox" name="shift_change_status" value="1" <?php echo ($master_row->shift_change_status==1 ? 'checked': '');?>>SHIFT CHANGE<br/>

                    <input type="checkbox" name="trial_status" value="1" <?php echo ($master_row->trial_status==1 ? 'checked': '');?>>TRIAL<br/>

                    <input type="checkbox" name="machine_maintainance_status" value="1" <?php echo ($master_row->machine_maintainance_status==1 ? 'checked': '');?>>MACHINE MAINTAINANCE<br/>
                </td>
                <td></td> 
                <td></td>
            </tr>
       
            <!-- <tr class="item">
                <td>NEW JOB/POWER FAILURE/CHANGE OF MATERIAL</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td><?php echo ($master_row->new_job==1?"YES":"NO") ;?></td>
                <td></td> 
                <td></td>
            </tr>
            <tr class="item">
                <td>SHIFT CHANGE/TRIAL/MACHINE AFTER MAINTENANCE</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td><?php echo ($master_row->shift_change==1?"YES":"NO") ;?></td>
                <td></td> 
                <td></td>
            </tr> -->
            

        </table>
        <br/>

        <?php  
            $data['springtube_bodymaking_control_plan_qc_details']=$this->common_model->select_one_active_record('springtube_bodymaking_control_plan_qc_details',$this->session->userdata['logged_in']['company_id'],'cp_id',$master_row->cp_id);
        ?>
              
        <br/>

        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">

            <tr class="heading" style="border-right:1px solid #D9d9d9;" >
                <td width="50%"> <i class="cogs icon"></i> PROCESS MONITORING FOR EVERY TWO HOURS</td>
                <td width="1%" ></td>
                <td width="1%" ></td>
                <td width="1%" ></td>
                <td width="5%" ></td>
                <td width="50%"><i class="user secret icon"></i> ACTUAL</td>
                <td width="1%" ></td>
                <td width="1%" ></td>
                <td width="1%" ></td>
            </tr>
        </table>    
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">

            <tr class="heading" style="border-right:1px solid #D9d9d9;" >
                <td width="5%">PARAMETER</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                
                <td width="5%" style="border-right:1px solid #D9d9d9;"><b>STANDARD</b></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"><b>TOLARANCE</b></td>

                <?php foreach ($data['springtube_bodymaking_control_plan_qc_details'] as $details_row){
                    
                echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.substr($details_row->inspection_time,0,5).'</b></td>';
                
                }
                ?>               
            </tr>

            <tr class="item">            
                <td >CHILLER TEMPERATURE</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">19</td>                
                <td style="border-right:1px solid #D9d9d9;">18-22</td>                
                

            <?php foreach ($data['springtube_bodymaking_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->chillar_temp.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >SHAFT TEMP</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">25</td>                
                <td style="border-right:1px solid #D9d9d9;">25-30</td>                
                

            <?php foreach ($data['springtube_bodymaking_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->shaft_temp.'</b></td>';
                }
            ?>                 
            </tr>

            <tr class="item">            
                <td >LAMINATE TURMING CUT</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">-</td>                
                <td style="border-right:1px solid #D9d9d9;">-</td>                
                

            <?php foreach ($data['springtube_bodymaking_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->laminate_terming_cut.'</b></td>';
                }
            ?>                 
            </tr>

            <tr class="item">            
                <td >HF TEMPERATURE EXTERNAL </td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">50</td>                
                <td style="border-right:1px solid #D9d9d9;">50-90</td>                
                

            <?php foreach ($data['springtube_bodymaking_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->hf_temp_external.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >HF TEMPERATURE</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">190</td>                
                <td style="border-right:1px solid #D9d9d9;">190-210</td>                
                

            <?php foreach ($data['springtube_bodymaking_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->hf_temp_internal.'</b></td>';
                }
            ?>                 
            </tr>

            <tr class="item">            
                <td >PRESSURE METALIC BELT INTERNAL</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                
                <td style="border-right:1px solid #D9d9d9;">3 Bar</td>                
                <td style="border-right:1px solid #D9d9d9;">3-4.5 Bar</td>                
                

            <?php foreach ($data['springtube_bodymaking_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->pressure_metalic_belt_internal.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >PRESSURE METALIC BELT EXTERNAL</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;"> 3 Bar</td>                
                <td style="border-right:1px solid #D9d9d9;">3-4.5 Bar</td>                

            <?php foreach ($data['springtube_bodymaking_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->pressure_metalic_belt_external.'</b></td>';
                }
            ?>                 
            </tr>

            <tr class="item">            
                <td >EXTERNAL INDUCTOR PRESSURE 1</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">1 Bar</td>                
                <td style="border-right:1px solid #D9d9d9;">0.5-1.5 Bar</td> 

            <?php foreach ($data['springtube_bodymaking_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->external_inductor_pressure_1.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >EXTERNAL INDUCTOR PRESSURE 2</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">1 Bar</td>                
                <td style="border-right:1px solid #D9d9d9;">0.5-1.5 Bar</td> 

            <?php foreach ($data['springtube_bodymaking_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->external_inductor_pressure_2.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >PRESSURE TRANSITION PAD</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">1 Bar</td>                
                <td style="border-right:1px solid #D9d9d9;">0.5-1.5 Bar</td>              
                

            <?php foreach ($data['springtube_bodymaking_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->pressure_transition_pad.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >PRESSURE ROLLER 1</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                
                <td style="border-right:1px solid #D9d9d9;">1 Bar</td>                
                <td style="border-right:1px solid #D9d9d9;">0.5-1.5 Bar/td>                
                

            <?php foreach ($data['springtube_bodymaking_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->pressure_roller_1.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >PRESSURE COOLING PAD</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                
                <td style="border-right:1px solid #D9d9d9;">1 Bar</td>                
                <td style="border-right:1px solid #D9d9d9;">0.5-1.5 Bar</td>                
                

            <?php foreach ($data['springtube_bodymaking_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->pressure_cooling_pad.'</b></td>';
                }
            ?>                 
            </tr>

            <tr class="item">            
                <td >TRIPPLE REFORMING ROLLER/td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                
                <td style="border-right:1px solid #D9d9d9;">-</td>                
                <td style="border-right:1px solid #D9d9d9;">-</td>                
                

            <?php foreach ($data['springtube_bodymaking_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->triple_reforming_roller.'</b></td>';
                }
            ?>                 
            </tr>

            <tr class="item">            
                <td >SINGLE REFORMING ROLLER</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">1.5 Bar</td>                
                <td style="border-right:1px solid #D9d9d9;">1-2.5 Bar</td>                
                

            <?php foreach ($data['springtube_bodymaking_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->single_reforming_roller.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >TORQUE INTERNAL BELT</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                
                <td style="border-right:1px solid #D9d9d9;">60%/100.35%</td>                
                <td style="border-right:1px solid #D9d9d9;">60-90/100-105</td>                
                

            <?php foreach ($data['springtube_bodymaking_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->torque_internal_belt.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >TORQUE EXTERNAL BELT</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                
                <td style="border-right:1px solid #D9d9d9;">90%/105%</td>                
                <td style="border-right:1px solid #D9d9d9;">60-90/100-106</td>                
                

            <?php foreach ($data['springtube_bodymaking_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->torque_external_belt.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >WELDING TEST SIDE SEAM</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                
                <td style="border-right:1px solid #D9d9d9;">Welding breaking force NLT 45N</td>                
                <td style="border-right:1px solid #D9d9d9;">-</td>                
                

            <?php foreach ($data['springtube_bodymaking_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->welding_test_side_seam.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >WELDING TEST TUBE HEAD</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                
                <td style="border-right:1px solid #D9d9d9;">Welding breaking force NLT 45N</td>                
                <td style="border-right:1px solid #D9d9d9;">-</td>                
                

            <?php foreach ($data['springtube_bodymaking_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->welding_test_tube_head.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >CAP FITMENT</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                
                <td style="border-right:1px solid #D9d9d9;">No gap between cap and shoulder</td>                
                <td style="border-right:1px solid #D9d9d9;">-</td>                
                

            <?php foreach ($data['springtube_bodymaking_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->cap_fitment.'</b></td>';
                }
            ?>                 
            </tr>

            <tr class="item">            
                <td >AIR LEAKAGE WITH CAP</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                
                <td style="border-right:1px solid #D9d9d9;">No air leakage with 0.5 bar pressure</td>                
                <td style="border-right:1px solid #D9d9d9;">-</td>                
                

            <?php foreach ($data['springtube_bodymaking_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->air_leakage_with_cap.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >PULL FORCE WITH SNAP CAP</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                
                <td style="border-right:1px solid #D9d9d9;">Not remove easily</td>                
                <td style="border-right:1px solid #D9d9d9;">-</td>                
                

            <?php foreach ($data['springtube_bodymaking_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->pull_force_snap_cap.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >CAP ALIGNMENT</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                
                <td style="border-right:1px solid #D9d9d9;">Should be align with tube eye mark</td>                
                <td style="border-right:1px solid #D9d9d9;">+/- 1 MM</td>                
                

            <?php foreach ($data['springtube_bodymaking_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->cap_alignment.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >CAP FOIL THICKNESS</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                
                <td style="border-right:1px solid #D9d9d9;">As per specification</td>                
                <td style="border-right:1px solid #D9d9d9;">+/- 0.2 MM</td>                
                

            <?php foreach ($data['springtube_bodymaking_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->cap_foil_thickness.'</b></td>';
                }
            ?>                 
            </tr>
             
                
     <?php endforeach;?>
    </div>
</body>
</html>   