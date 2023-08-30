<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

    $(document).ready(function(){

        $(".invoice-box").css("max-width", "1300px");
    });
 </script>
 <style type="text/css">
        table{
            border:1px solid #D9d9d9;

        }
</style>  

<?php foreach ($springtube_extrusion_control_plan_qc as $master_row):

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
    }
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


<?php 

$date1 = $master_row->inspection_date;
$date2 = '2023-05-15';

if($date1 > $date2){
    
}else{
  echo "<div class='ui teal labels' style='text-align: center;margin-top: 10px;'>
      <div class='ui label'>
        CONTROL PLAN OF EXTRUSION SPRING TUBE
      </div>
    </div>";
}
?> 


    <!-- <br/>  
    <div class="ui teal labels" style="text-align: center;">
      <div class="ui label">
        CONTROL PLAN OF EXTRUSION SPRING TUBE
      </div>
    </div> -->

        <!-- <?php echo $master_row->final_approval_flag==1 ? '<span class="ui green right ribbon label"><i class="check circle icon"></i> Approved</span>' : '<span class="ui red right ribbon label">Unapproved</span>';?>

        <br/> -->

        <?php echo $this->common_model->view_date($master_row->inspection_date,$this->session->userdata['logged_in']['company_id'])!='' ? '<span class="ui blue left ribbon label"><i class="calendar alternate outline icon"></i>'.$this->common_model->view_date($master_row->inspection_date,$this->session->userdata['logged_in']['company_id']).'</span>' : '';
        ?>
        
        <br/>
        <br/>

        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">

            <tr class="heading" style="border-right:1px solid #D9d9d9;" >
                <td width="15%"> <i class="cogs icon"></i> PROCESS</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%" style="border-right:1px solid #D9d9d9;"><?php echo 'SPRINGTUBE EXTRUSION';?></td>
                <td width="20%"><i class="user secret icon"></i> OPERATOR</td>                
                <td width="5%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="35%"><?php echo $master_row->operator ;?></td>
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
            
            



            <!-- <tr class="heading" style="border-right:1px solid #D9d9d9;" >
                <td width="11%">INSPECTION DATE</td>
                <td width="5%"></td>
                <td width="5%"><b>SHIFT</b></td>
                <td width="5%"><b>MACHINE</b></td>                
                <td width="5%"><b>OPERATOR NAME</b></td>                
                <td width="5%"><b>QC INPECTOR</b></td>
            </tr>
        
            <tr class="item last">
                <td><?php echo $this->common_model->view_date($master_row->inspection_date,$this->session->userdata['logged_in']['company_id']);?></td>
                <td></td>
                <td><?php echo $master_row->inspection_time;?></td>                
                <td><?php echo $master_row->machine_name;?></td> 
                <td><?php echo $master_row->operator;?></td>               
                <td><?php echo $master_row->user_id ;?></td>
               
                
            </tr> -->

        </table>


        <br/>

        <!-- <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            
            <tr class="heading" style="border-right:1px solid #D9d9d9;" >
                <td width="10%">CUSTOMER</td>
                <td width="5%"></td>
                <td width="5%"><b>ORDER NO</b></td>                
                <td width="5%"><b>ARTICLE NO</b></td>
                <td width="5%"><b>ARTICLE NAME</b></td>
                <td width="5%"><b>JOBCARD NO</b></td>
                
                
            </tr>
        
            <tr class="item last">
                <td><?php echo $customer ;?></td>
                <td></td>
                <td><?php echo $order_no ;?></td>                
                <td><?php echo $article_no ;?></td> 
                <td><?php echo $this->common_model->get_article_name($article_no,$this->session->userdata['logged_in']['company_id']);?></td>               
                <td><?php echo $master_row->jobcard_no ;?></td>
               
                
            </tr>

        </table> 
        <br/>
        -->

        <!-- <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            
            <tr class="heading" style="border-right:1px solid #D9d9d9;" >
                <td width="10%">SPECIFICATION</td>
                <td width="5%"></td>
                <td width="5%"></td>                
                <td width="5%"></td>
                <td width="5%"></td>
                <td width="5%"></td>
                
                
            </tr>
        
            <tr class="item last">
                <td><?php echo $sleeve_diameter.' X '.$sleeve_length.' MM' ;?></td>
                <td></td>
                <td></td>                
                <td></td> 
                <td></td>               
                <td></td>
               
                
            </tr>

        </table> 
        <br/>
        -->
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">
            
            <tr class="heading" style="border-right:1px solid #D9d9d9;" >
                <td width="15%" >PARAMETER</td>
                <td width="1%" style="border-right:1px solid #D9d9d9;"></td>
                <td width="11%" style="border-right:1px solid #D9d9d9;"><b>STANDARD</b></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"><b>ACTUAL</b></td>                
                <td width="5%" style="border-right:1px solid #D9d9d9;"><b>STATUS (PASS/FAIL)</b></td>
                                
            </tr>        
            <tr class="item">
                <td> WIDTH(MM) +/- 2</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->width_std ;?></td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->width_actual ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->width_status==1?"PASS":($master_row->width_status==2?"FAIL":"N/A")) ;?></td>               
               
            </tr>
            <tr class="item">
                <td >THICKNESS (MICRON) +/- 12</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->thickness_std ;?></td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->thickness_actual ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->thickness_status==1?"PASS":($master_row->thickness_status==2?"FAIL":"N/A"));?>
            </tr>
            <tr class="item">
                <td >LENGTH OF ROLL (MITERS) +/- 10</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->reel_length_std ;?></td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->reel_length_actual ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->reel_length_status==1?"PASS":($master_row->reel_length_status==2?"FAIL":"N/A"));?>
            </tr>
            <tr class="item">
                <td>FIRST LAYER (MICRON)</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->first_layer_micron_std ;?></td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->first_layer_micron_actual ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->first_layer_micron_status==1?"PASS":($master_row->first_layer_micron_status==2?"FAIL":"N/A"));?>
            </tr>
            <tr class="item">
                <td>SECOND LAYER (MICRON)</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->second_layer_micron_std ;?></td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->second_layer_micron_actual ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->second_layer_micron_status==1?"PASS":($master_row->second_layer_micron_status==2?"FAIL":"N/A"));?>
            </tr>
            <tr class="item">
                <td>THIRD LAYER (MICRON)</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->third_layer_micron_std ;?></td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->third_layer_micron_actual ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->third_layer_micron_status==1?"PASS":($master_row->third_layer_micron_status==2?"FAIL":"N/A"));?>
            </tr>
            <tr class="item">
                <td>FOURTH LAYER (MICRON)</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->fourth_layer_micron_std ;?></td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->fourth_layer_micron_actual ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->fourth_layer_micron_status==1?"PASS":($master_row->fourth_layer_micron_status==2?"FAIL":"N/A"));?>
            </tr>
            <tr class="item">
                <td>FIFTH LAYER (MICRON)</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->fifth_layer_micron_std ;?></td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->fifth_layer_micron_actual ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->fifth_layer_micron_status==1?"PASS":($master_row->fifth_layer_micron_status==2?"FAIL":"N/A"));?>
            </tr>
            <tr class="item">
                <td>SIXTH LAYER (MICRON)</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->sixth_layer_micron_std ;?></td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->sixth_layer_micron_actual ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->sixth_layer_micron_status==1?"PASS":($master_row->sixth_layer_micron_status==2?"FAIL":"N/A"));?>
            </tr>
            <tr class="item">
                <td>SEVENTH LAYER (MICRON)</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->seventh_layer_micron_std ;?></td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->seventh_layer_micron_actual ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->seventh_layer_micron_status==1?"PASS":($master_row->seventh_layer_micron_status==2?"FAIL":"N/A"));?>
            </tr>

            <tr class="item ">
                <td>GRADE & PERCENTAGE OF BLAND</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">As per job card and customer specification</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->grade_perc_of_bland ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->grade_perc_of_bland_status==1?"PASS":($master_row->grade_perc_of_bland_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >COLOR OF ROLL</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">As per job card and customer specification</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->roll_color ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->roll_color_status==1?"PASS":($master_row->roll_color_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >COLOR DIFFRENCE</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">DE<3</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->color_diffrence ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->color_diffrence_status==1?"PASS":($master_row->color_diffrence_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >OPACITY</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">>90%</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->opacity ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->opacity_status==1?"PASS":($master_row->opacity_status==2?"FAIL":"N/A"));?></td>
            </tr>

            <tr class="item">
                <td >WINDING OF ROLL</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">Should be Uniform</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->roll_winding ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->roll_winding_status==1?"PASS":($master_row->roll_winding_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >DIE LINE</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">No Die/Line</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->die_line ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->die_line_status==1?"PASS":($master_row->die_line_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >SCRATCH LINE</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">No Scratch line</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->scratch_line ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->scratch_line_status==1?"PASS":($master_row->scratch_line_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >PIT/WATERMARK/FISH EYE</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">No pit/Water mark</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->pit_watermark ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->pit_watermark_status==1?"PASS":($master_row->pit_watermark_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >CONTAMINATION</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">No Contamination</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->contamination ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->contamination_status==1?"PASS":($master_row->contamination_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >HUMPS ON ROLL</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">No Humps surface should be even</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->roll_humps ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->roll_humps_status==1?"PASS":($master_row->roll_humps_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >COLOR DISPERSION</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">should be Uniform </td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->color_dispersion ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->color_dispersion_status==1?"PASS":($master_row->color_dispersion_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >COF-SF/DF</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->cof_sf_df;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->cof_sf_df_status==1?"PASS":($master_row->cof_sf_df_status==2?"FAIL":"N/A"));?></td>
            </tr>
            <tr class="item">
                <td >MB COLOR CODE & PERCENTAGE</td>
                <td style="border-right:1px solid #D9d9d9;"></td>                
                <td style="border-right:1px solid #D9d9d9;">As per job card and customer specification</td>                
                <td style="border-right:1px solid #D9d9d9;"><?php echo $master_row->mb_color_perc ;?></td> 
                <td style="border-right:1px solid #D9d9d9;"><?php echo ($master_row->mb_color_perc_status==1?"PASS":($master_row->mb_color_perc_status==2?"FAIL":"N/A"));?></td>
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
             
            

        </table>
        <br/>


        <?php  
            $data['springtube_extrusion_control_plan_qc_details']=$this->common_model->select_one_active_record('springtube_extrusion_control_plan_qc_details',$this->session->userdata['logged_in']['company_id'],'cp_id',$master_row->cp_id);
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
                <td width="5%" >PARAMETER</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"><b>STANDARD</b></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"><b>TOLARANCE</b></td>

                <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){
                    
                echo'<td width="5%" style="border-right:1px solid #D9d9d9;"><b>'.substr($details_row->inspection_time,0,5).'</b></td>';
                
                }
                ?>               
            </tr>

        <!-- FOR EXTRUDURE A   -->  
            <tr class="item">            
                <td >EX- A</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 001</td>
                <td style="border-right:1px solid #D9d9d9;">90</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_a_actual_1.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >EX- A</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 002</td>
                <td style="border-right:1px solid #D9d9d9;">185</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_a_actual_2.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >EX- A</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 003</td>
                <td style="border-right:1px solid #D9d9d9;">195</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_a_actual_3.'</b></td>';
                }
            ?>                 
            </tr>

            <tr class="item">            
                <td >EX- A</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 004</td>
                <td style="border-right:1px solid #D9d9d9;">205</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_a_actual_4.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >EX- A</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 005</td>
                <td style="border-right:1px solid #D9d9d9;">210</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_a_actual_5.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >EX- A</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 006</td>
                <td style="border-right:1px solid #D9d9d9;">215</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_a_actual_6.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >EX- A</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 007</td>
                <td style="border-right:1px solid #D9d9d9;">225</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_a_actual_7.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >EX- A</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 008</td>
                <td style="border-right:1px solid #D9d9d9;">225</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_a_actual_8.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >EX- A</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 009</td>
                <td style="border-right:1px solid #D9d9d9;">225</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_a_actual_9.'</b></td>';
                }
            ?>                 
            </tr>

            <!-- FOR EXTRUDURE B   -->  
            <tr class="item">            
                <td >EX- B</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 001</td>
                <td style="border-right:1px solid #D9d9d9;">90</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_b_actual_1.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >EX- B</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 002</td>
                <td style="border-right:1px solid #D9d9d9;">185</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_b_actual_2.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >EX- B</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 003</td>
                <td style="border-right:1px solid #D9d9d9;">195</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_b_actual_3.'</b></td>';
                }
            ?>                 
            </tr>

            <tr class="item">            
                <td >EX- B</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 004</td>
                <td style="border-right:1px solid #D9d9d9;">205</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_b_actual_4.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >EX- B</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 005</td>
                <td style="border-right:1px solid #D9d9d9;">210</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_b_actual_5.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >EX- B</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 006</td>
                <td style="border-right:1px solid #D9d9d9;">215</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_b_actual_6.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >EX- B</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 007</td>
                <td style="border-right:1px solid #D9d9d9;">220</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_b_actual_7.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >EX- B</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 008</td>
                <td style="border-right:1px solid #D9d9d9;">225</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_b_actual_8.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >EX- B</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 009</td>
                <td style="border-right:1px solid #D9d9d9;">225</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_b_actual_9.'</b></td>';
                }
            ?>                 
            </tr>

            <!-- FOR EXTRUDURE C   -->  
            <tr class="item">            
                <td >EX- C</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 001</td>
                <td style="border-right:1px solid #D9d9d9;">80</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_c_actual_1.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >EX- C</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 002</td>
                <td style="border-right:1px solid #D9d9d9;">170</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_c_actual_2.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >EX- C</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 003</td>
                <td style="border-right:1px solid #D9d9d9;">190</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_c_actual_3.'</b></td>';
                }
            ?>                 
            </tr>

            <tr class="item">            
                <td >EX- C</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 004</td>
                <td style="border-right:1px solid #D9d9d9;">195</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_c_actual_4.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >EX- C</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 005</td>
                <td style="border-right:1px solid #D9d9d9;">210</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_c_actual_5.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >EX- C</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 006</td>
                <td style="border-right:1px solid #D9d9d9;">210</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_c_actual_6.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >EX- C</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 007</td>
                <td style="border-right:1px solid #D9d9d9;">210</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_c_actual_7.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >EX- C</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 008</td>
                <td style="border-right:1px solid #D9d9d9;">210</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_c_actual_8.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >EX- C</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 009</td>
                <td style="border-right:1px solid #D9d9d9;">210</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_a_actual_9.'</b></td>';
                }
            ?>                 
            </tr>

            <!-- FOR EXTRUDURE D   --> 

            <tr class="item">            
                <td >EX- D</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 001</td>
                <td style="border-right:1px solid #D9d9d9;">90</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_d_actual_1.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >EX- D</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 002</td>
                <td style="border-right:1px solid #D9d9d9;">195</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_d_actual_2.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >EX- D</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 003</td>
                <td style="border-right:1px solid #D9d9d9;">205</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_d_actual_3.'</b></td>';
                }
            ?>                 
            </tr>

            <tr class="item">            
                <td >EX- D</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 004</td>
                <td style="border-right:1px solid #D9d9d9;">210</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_d_actual_4.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >EX- D</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 005</td>
                <td style="border-right:1px solid #D9d9d9;">215</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_d_actual_5.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >EX-D</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 006</td>
                <td style="border-right:1px solid #D9d9d9;">225</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_d_actual_6.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >EX- D</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 007</td>
                <td style="border-right:1px solid #D9d9d9;">225</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_d_actual_7.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >EX- D</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 008</td>
                <td style="border-right:1px solid #D9d9d9;">225</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_d_actual_8.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >EX- D</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 009</td>
                <td style="border-right:1px solid #D9d9d9;">225</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_d_actual_9.'</b></td>';
                }
            ?>                 
            </tr>

            <!-- FOR EXTRUDURE E   --> 
            <tr class="item">            
                <td >EX- E</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 001</td>
                <td style="border-right:1px solid #D9d9d9;">90</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_e_actual_1.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >EX- E</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 002</td>
                <td style="border-right:1px solid #D9d9d9;">195</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_e_actual_2.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >EX- E</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 003</td>
                <td style="border-right:1px solid #D9d9d9;">200</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_e_actual_3.'</b></td>';
                }
            ?>                 
            </tr>

            <tr class="item">            
                <td >EX- E</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 004</td>
                <td style="border-right:1px solid #D9d9d9;">210</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_e_actual_4.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >EX- E</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 005</td>
                <td style="border-right:1px solid #D9d9d9;">215</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_e_actual_5.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >EX- E</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 006</td>
                <td style="border-right:1px solid #D9d9d9;">220</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_e_actual_6.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >EX- E</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 007</td>
                <td style="border-right:1px solid #D9d9d9;">220</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_e_actual_7.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >EX- E</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 008</td>
                <td style="border-right:1px solid #D9d9d9;">220</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_e_actual_8.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >EX- E</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 009</td>
                <td style="border-right:1px solid #D9d9d9;">220</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->ex_e_actual_9.'</b></td>';
                }
            ?>                 
            </tr>

            <!-- FOR FEED BLOCK   --> 
            <tr class="item">            
                <td >FEED BLOCK</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 001</td>
                <td style="border-right:1px solid #D9d9d9;">1</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->feed_block_actual_1.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >FEED BLOCK</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 002</td>
                <td style="border-right:1px solid #D9d9d9;">1</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->feed_block_actual_2.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >FEED BLOCK</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 003</td>
                <td style="border-right:1px solid #D9d9d9;">1</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->feed_block_actual_3.'</b></td>';
                }
            ?>                 
            </tr>

            <tr class="item">            
                <td >FEED BLOCK</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 004</td>
                <td style="border-right:1px solid #D9d9d9;">1</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->feed_block_actual_4.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >FEED BLOCK</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 005</td>
                <td style="border-right:1px solid #D9d9d9;">1</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->feed_block_actual_5.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >FEED BLOCK</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 006</td>
                <td style="border-right:1px solid #D9d9d9;">1</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->feed_block_actual_6.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >FEED BLOCK</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 007</td>
                <td style="border-right:1px solid #D9d9d9;">1</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->feed_block_actual_7.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >FEED BLOCK</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 008</td>
                <td style="border-right:1px solid #D9d9d9;">1</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->feed_block_actual_8.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >FEED BLOCK</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 009</td>
                <td style="border-right:1px solid #D9d9d9;">1</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->feed_block_actual_9.'</b></td>';
                }
            ?>                 
            </tr>

            <tr class="item">            
                <td >FEED BLOCK</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 013</td>
                <td style="border-right:1px solid #D9d9d9;">210</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->feed_block_actual_13.'</b></td>';
                }
            ?>                 
            </tr>

            <tr class="item">            
                <td >FEED BLOCK</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 014</td>
                <td style="border-right:1px solid #D9d9d9;">210</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->feed_block_actual_14.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >FEED BLOCK</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 015</td>
                <td style="border-right:1px solid #D9d9d9;">1</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->feed_block_actual_15.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >FEED BLOCK</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 016</td>
                <td style="border-right:1px solid #D9d9d9;">1</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->feed_block_actual_16.'</b></td>';
                }
            ?>                 
            </tr>

            <tr>            
                <td >FEED BLOCK</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 017</td>
                <td style="border-right:1px solid #D9d9d9;">1</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->feed_block_actual_17.'</b></td>';
                }
            ?>                 
            </tr> 


            <!-- FOR DIE HEAD  --> 
            <tr class="item">            
                <td >DIE HEAD</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 001</td>
                <td style="border-right:1px solid #D9d9d9;">230</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->die_head_actual_1.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >DIE HEAD</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 002</td>
                <td style="border-right:1px solid #D9d9d9;">240</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->die_head_actual_2.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >DIE HEAD</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 003</td>
                <td style="border-right:1px solid #D9d9d9;">240</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->die_head_actual_3.'</b></td>';
                }
            ?>                 
            </tr>

            <tr class="item">            
                <td >DIE HEAD</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 004</td>
                <td style="border-right:1px solid #D9d9d9;">1</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->die_head_actual_4.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >DIE HEAD</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 005</td>
                <td style="border-right:1px solid #D9d9d9;">1</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->die_head_actual_5.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >DIE HEAD</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 006</td>
                <td style="border-right:1px solid #D9d9d9;">1</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->die_head_actual_6.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >DIE HEAD</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 007</td>
                <td style="border-right:1px solid #D9d9d9;">1</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->die_head_actual_7.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >DIE HEAD</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 008</td>
                <td style="border-right:1px solid #D9d9d9;">1</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->die_head_actual_8.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >DIE HEAD</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"> ZONE 009</td>
                <td style="border-right:1px solid #D9d9d9;">1</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->die_head_actual_9.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >TEMPARATURE OF ROLL 1</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">30</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->roll_temp_1_actual.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >TEMPARATURE OF ROLL 2</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">30</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->roll_temp_2_actual.'</b></td>';
                }
            ?>                 
            </tr>
            <tr class="item">            
                <td >TEMPARATURE OF ROLL 3</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">30</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10C</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->roll_temp_3_actual.'</b></td>';
                }
            ?>                 
            </tr>

            <tr class="item">            
                <td >THICKNESS OF ROLL 1</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">450</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10 MIC</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->roll_thickness_actual.'</b></td>';
                }
            ?>                 
            </tr>

            <tr class="item">            
                <td >LENGTH OF ROLL 1</td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;"></td>
                <td style="border-right:1px solid #D9d9d9;">600</td>                
                <td style="border-right:1px solid #D9d9d9;">+/-10 METER</td>                
                

            <?php foreach ($data['springtube_extrusion_control_plan_qc_details'] as $details_row){                    
                echo'<td style="border-right:1px solid #D9d9d9;"><b>'.$details_row->roll_length_actual.'</b></td>';
                }
            ?>                 
            </tr>  

            
        </table>

<?php     
    $data_film_thickness=array(
    'cp_id'=>$master_row->cp_id,
    'archive'=>'0'
    );
    $springtube_extrusion_control_plan_qc_film_thickness_result=$this->common_model->select_active_records_where_order_by('springtube_extrusion_control_plan_qc_film_thickness',$this->session->userdata['logged_in']['company_id'],$data_film_thickness,'roll_no','asc');
    if($springtube_extrusion_control_plan_qc_film_thickness_result){


   
?>

        <br/>
        <table cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">

            <tr class="heading" style="border-right:1px solid #D9d9d9;" >
                <td  colspan="21" style="border-right:1px solid #D9d9d9;"> <i class="cogs icon"></i> FILM THICKNESS RIPORT</td>
                
                
            </tr>
            <tr class="heading" style="border-right:1px solid #D9d9d9;" >
                <td width="5%" colspan="11" style="border-right:1px solid #D9d9d9;" > ROLL THICKNESS FROM TOP SIDE STD-450 MIC TOLARANCE (+/-)12 MIC</td>
                <td width="5%" colspan="10" style="border-right:1px solid #D9d9d9;"> ROLL THICKNESS FROM BOTTOM SIDE STD-450 MIC TOLARANCE (+/-)12 MIC</td>
                
            </tr>
            <tr class="heading" style="border-right:1px solid #D9d9d9;" >
                <td width="5%" style="border-right:1px solid #D9d9d9;">ROLL NO</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;">TOP POS 1</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;">TOP POS 2</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;">TOP POS 3</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;">TOP POS 4</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;">TOP POS 5</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;">TOP POS 6</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;">TOP POS 7</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;">TOP POS 8</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;">TOP POS 9</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;">TOP POS 10</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;">BOT POS 1</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;">BOT POS 2</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;">BOT POS 3</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;">BOT POS 4</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;">BOT POS 5</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;">BOT POS 6</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;">BOT POS 7</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;">BOT POS 8</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;">BOT POS 9</td>
                <td width="5%" style="border-right:1px solid #D9d9d9;">BOT POS 10</td>
            </tr>
            <?php foreach ($springtube_extrusion_control_plan_qc_film_thickness_result as $film_width_row):?>

                <tr class="item" style="border-right:1px solid #D9d9d9;" >
                <td width="10%" style="border-right:1px solid #D9d9d9;"><?php echo $film_width_row->roll_no;?></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"><?php echo $film_width_row->top_pos_1;?></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"><?php echo $film_width_row->top_pos_2;?></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"><?php echo $film_width_row->top_pos_3;?></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"><?php echo $film_width_row->top_pos_4;?></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"><?php echo $film_width_row->top_pos_5;?></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"><?php echo $film_width_row->top_pos_6;?></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"><?php echo $film_width_row->top_pos_7;?></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"><?php echo $film_width_row->top_pos_8;?></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"><?php echo $film_width_row->top_pos_9;?></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"><?php echo $film_width_row->top_pos_10;?></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"><?php echo $film_width_row->bot_pos_1;?></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"><?php echo $film_width_row->bot_pos_2;?></td>
               <td width="5%" style="border-right:1px solid #D9d9d9;"><?php echo $film_width_row->bot_pos_3;?></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"><?php echo $film_width_row->bot_pos_4;?></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"><?php echo $film_width_row->bot_pos_5;?></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"><?php echo $film_width_row->bot_pos_6;?></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"><?php echo $film_width_row->bot_pos_7;?></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"><?php echo $film_width_row->bot_pos_8;?></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"><?php echo $film_width_row->bot_pos_9;?></td>
                <td width="5%" style="border-right:1px solid #D9d9d9;"><?php echo $film_width_row->bot_pos_10;?></td>
            </tr>

             <?php endforeach;?> 

        </table>

        <?php } ?> 


        
                
     <?php endforeach;?>
    </div>
</body>
</html>   