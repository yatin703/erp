

<?php foreach ($springtube_printing_control_plan_qc as $master_row):

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
        CONTROL PLAN OF PRINTING SPRING TUBE
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
                <td width="35%" style="border-right:1px solid #D9d9d9;"><?php echo 'SPRINGTUBE PRINTING';?></td>
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
                <td> DE VALUE</td>
                <td style="border-right:1px solid #D9d9d9;"></td> 
                <td style="border-right:1px solid #D9d9d9;">DE<3</td>                 
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->de_value ;?></td>                
               
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->de_value_status==1?"PASS":($master_row->de_value_status==2?"FAIL":"N/A")) ;?></td>               
               
            </tr>
            <tr class="item">
                <td >TREATMENT</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">By surface tester testing (38=Pass, 42=Fail)</td>                 
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->treatment ;?></td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->treatment_status==1?"PASS":($master_row->treatment_status==2?"FAIL":"N/A"));?>
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
                <td>LACQUER (OVER/UNDER)</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">As per approved Artwork</td>
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->lacquer_over_under ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->lacquer_over_under_status==1?"PASS":($master_row->lacquer_over_under_status==2?"FAIL":"N/A"));?>
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
                <td>REPEAT LENGTH VARIATIOIN</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">No variation in repeat length</td>               
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->repeat_length_variation ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->repeat_length_variation_status==1?"PASS":($master_row->repeat_length_variation_status==2?"FAIL":"N/A"));?>
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
                <td><?php echo ($master_row->rejected_rolls_clear_status==1?"YES":"NO") ;?></td>                
                <td></td> 
                <td></td>               
               
            </tr>
            <tr class="item">
                <td>NO LOOSE TOOLS</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td><?php echo ($master_row->no_loose_tools_status==1?"YES":"NO") ;?></td>                
                <td></td> 
                <td></td>               
                
            </tr>
            <tr class="item last">
                <td>SURROUNDING AND MACHINE CLEAN</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td><?php echo ($master_row->machine_cleane_status==1?"YES":"NO") ;?></td>                
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
            $data['springtube_printing_control_plan_qc_details']=$this->common_model->select_one_active_record('springtube_printing_control_plan_qc_details',$this->session->userdata['logged_in']['company_id'],'cp_id',$master_row->cp_id);
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

                <?php foreach ($data['springtube_printing_control_plan_qc_details'] as $details_row){
                    
                echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.substr($details_row->inspection_time,0,5).'</b></td>';
                
                }
                ?>               
            </tr>

            <tr class="item">            
                <td >FLEXO-1 CORONA</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                
                <td style="border-right:1px solid #D9d9d9;">30</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-2</td>                
                

            <?php foreach ($data['springtube_printing_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->flexo_1_corona.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >UV POWER</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                
                <td style="border-right:1px solid #D9d9d9;">50</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-5</td>                
                

            <?php foreach ($data['springtube_printing_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->uv_power_1.'</b></td>';
                }
            ?>                 
            </tr>

            <tr class="item">            
                <td >UV SPEED</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                
                <td style="border-right:1px solid #D9d9d9;">5</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-1</td>                
                

            <?php foreach ($data['springtube_printing_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->uv_speed_1.'</b></td>';
                }
            ?>                 
            </tr>

            <tr class="item">            
                <td >FLEXO-2 CORONA</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                
                <td style="border-right:1px solid #D9d9d9;">30</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-2</td>                
                

            <?php foreach ($data['springtube_printing_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->flexo_2_corona.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >UV POWER</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                
                <td style="border-right:1px solid #D9d9d9;">50</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-5</td>                
                

            <?php foreach ($data['springtube_printing_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->uv_power_2.'</b></td>';
                }
            ?>                 
            </tr>

            <tr class="item">            
                <td >UV SPEED</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                
                <td style="border-right:1px solid #D9d9d9;">5</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-1</td>                
                

            <?php foreach ($data['springtube_printing_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->uv_speed_2.'</b></td>';
                }
            ?>                 
            </tr>

            <tr class="item">            
                <td >DIGITAl PRINTING SPEED</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                
                <td style="border-right:1px solid #D9d9d9;">40</td>                
                <td style="border-right:1px solid #D9d9d9;">-</td>                
                

            <?php foreach ($data['springtube_printing_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->printing_speed.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >CORONA DOSE</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                
                <td style="border-right:1px solid #D9d9d9;">-</td>                
                <td style="border-right:1px solid #D9d9d9;">-</td>                
                

            <?php foreach ($data['springtube_printing_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->corona_dose.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >UNWIND TENSION-TENSION-REWIND TENSION</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                
                <td style="border-right:1px solid #D9d9d9;">120-130-140</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-1</td>                
                

            <?php foreach ($data['springtube_printing_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->unwind_tension.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >UV CUTTING</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                
                <td style="border-right:1px solid #D9d9d9;">20-50-90-90</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-1</td>                
                

            <?php foreach ($data['springtube_printing_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->uv_cutting.'</b></td>';
                }
            ?>                 
            </tr>

            <tr class="item">            
                <td >DYNE TEST</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                
                <td style="border-right:1px solid #D9d9d9;">Check using surface tension (Tester no. 38 pass, 42 fail)</td>                
                <td style="border-right:1px solid #D9d9d9;"></td>                
                

            <?php foreach ($data['springtube_printing_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->dyne_test.'</b></td>';
                }
            ?>                 
            </tr>   


        
                
     <?php endforeach;?>
    </div>
</body>
</html>   