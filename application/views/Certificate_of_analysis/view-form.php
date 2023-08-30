<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php ucwords($this->router->fetch_class());?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/print.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/semantic/semantic.min.css');?>">

     <script src="<?php echo base_url('assets/js/pdf.js');?>"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>

     <style>
	input{width: 100%;}
	.align-ctr{text-align: center;}
	.align-ctr1{text-align: center;}
	.align-lft{text-align: left !important;}
    td.label.align-ctr{vertical-align: middle;}
    select{width: 100%;}
    .span-h{font-size: 12px;
    border-bottom: 1px solid #000000;}
   .span-required{color: red;}
   .bbtm{border-right:1px solid #D9d9d9;}
   .bbt{border-right:1px solid #D9d9d9;border-bottom:1px solid #D9d9d9;}
   .bg-parameter{background: #dffcfc;}
   .invoice-box table tr td:nth-child(2) {
    text-align: center;
}
.bbtr{
	border-right: 1px solid #D9d9d9;
    border-bottom: 0px solid #D9d9d9;
}
span.ui.green.right.ribbon.label{margin-bottom: 20px;}
span.ui.blue.left.ribbon.label.right {
    margin-left: 0px;
}
span.ui.green.right.ribbon.label.left {
    margin-left: 0px;
}
span.ui.red.right.ribbon.label.left {
    margin-left: 0px;
}
.doc-no{font-weight: 700;
    margin-top: -40px;
    text-align: right;
    color: red;}
span.ui.blue.left.ribbon.label.left{
	margin-bottom: 20px;
}
 .txt_ctr{
    text-align: center;
    padding: 6px 0px !important;
    }
    .invoice-box table td {
    padding: 3px !important;}
    .ui.grid>.column:not(.row) {
    padding-top: 0rem;
    padding-bottom: 0rem;
}



</style>
</head>
<body>

<!--  <div class="invoice-box" id="invoice"> 
    
    <div class="doc-no-align " >
      <div class="coa label">
        <h3>CERTIFICATE OF ANALYSIS</h3>
      </div>
      <div class="logo">     	
            <img src="<?php echo base_url('assets/img/logo.png');?>" style="max-width:130px;height:30px;">
      </div>
    </div> 

    <div class="doc-rev" >
      <div class="doc no">
        <p style="font-size: 12px;font-weight: 500;margin-right: 280px;color:red;">Document No: QC/F/22</p>
      </div>
      <div class="rev-no" style="text-align: center !important;">     	
        <p style="font-size: 12px;font-weight: 500;margin-right: 280px;color:red;">Revision No:05</p>
      </div>
      <div class="rev-date" style="text-align: right !important;">     	
        <p style="font-size: 12px;font-weight: 500;color:red;">Revision Date:16/05/2023</p>
      </div>
    </div> -->

<?php 

$date1 = $certificate_of_analysis['inspection_date'];
$date2 = '2023-05-15';

if($date1 >= $date2){
    
}else{
  echo "<div class='doc-no'style='text-align: right;'>
        DOC NO QC - F-22 <br> REV NO - 04 <br> REV DATE - 17.08.2022
    </div>

    <div class='ui teal labels' style='text-align: center;'>
      <div class='ui label'>
        CERTIFICATE OF ANALYSIS 
      </div>
    </div>";
}
?>

    <div class="ui grid">
	  <div class="two wide column">
	  	<?php echo $this->common_model->view_date($certificate_of_analysis['inspection_date'],$this->session->userdata['logged_in']['company_id'])!='' ? '<span class="ui blue left ribbon label left"><i class="calendar alternate outline icon"></i>'.$this->common_model->view_date($certificate_of_analysis['inspection_date'],$this->session->userdata['logged_in']['company_id']).' '.''.'</span>' : '';
        ?>
	  </div>

	  <div class="twelve wide column"> </div>
	  <div class="two wide column">
	  	<?php echo $certificate_of_analysis['final_approval_flag']==1 ? '<span class="ui green right ribbon label right"><i class="check circle icon"></i> Approved</span>' : '<span class="ui red right ribbon label right">Unapproved</span>';?>

	  	
	  </div>
	</div>
    
    <table class="form_table_inner" width="100%" cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">    <tr class="">
			<td width="15%" class="label bbt bg-parameter"><b>Certificate No.</b></td>
			<td width="35%" class="align-lft bbt" colspan="2"><?php echo $certificate_of_analysis['certificate_no'];?></td> 
			<td width="20%" class="label bbt bg-parameter"><b>Date</b></td>
			<td width="30%" class="align-lft bbt" colspan="2"><?php echo $this->common_model->view_date($certificate_of_analysis['inspection_date'],$this->session->userdata['logged_in']['company_id']);?></td>
		</tr> 

		<tr>
            <td width="15%" class="label bbt bg-parameter"><b>Customer Name</b></td>
			<td width="35%" class="align-lft  bbt" colspan="2"><?php echo $certificate_of_analysis['customer_name'];?></td> 
            <td width="20%" class="label bbt bg-parameter"><b>AQL</b></td>
			<td width="30%" class="align-lft bbt" colspan="2"><?php echo $certificate_of_analysis['quality'];?></td> 
		</tr>
                     
		<tr>
            <td width="15%" class="label bbt bg-parameter"><b>Product</b></td>
			<td width="35%" class="align-lft bbt" colspan="2"><?php echo $this->common_model->get_article_name($certificate_of_analysis['product_name'],$this->session->userdata['logged_in']['company_id']);?> - (PSM NO. <?php echo  $certificate_of_analysis['product_name']; ?>)</td> 
            <td width="20%" class="label bbt bg-parameter"><b>Total Qty</b></td>
			<td width="30%" class="align-lft bbt" colspan="2"><?php echo $certificate_of_analysis['total_qty'];?></td> 
		</tr>
                    
        <tr>
            <td width="15%" class="label bbtm bg-parameter"><b>SO NO.</b></td>
			<td width="35%" class="align-lft bbtm" colspan="2"><?php echo $certificate_of_analysis['so_no'];?></td> 
			<td width="20%" class="label bbtm bg-parameter"><b>Sample Size</b></td>
			<td width="30%" class="align-lft bbtm" colspan="2"><?php echo $certificate_of_analysis['sample_size'];?></td> 
		</tr>
    </table>

	<table class="form_table_inner" width="100%" cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;">	   <tr>
			<td class="label align-ctr bbt bg-parameter" colspan="6"><b><span class="span-h">Dimensional Compliance</span></b></td>
			<td class="label align-ctr bbt bg-parameter" style="text-align: center !important;" colspan="2"><b><span class="span-h">Monolayer/Multilayer</span></b></td>
		</tr>
		<tr>
			<td class="label align-ctr1 bbt" rowspan="8" ><b>Process</b> <br><br> <i style="margin-top: 30px;" class="arrow down icon"></i></td>
			<td class="label align-ctr1 bbt" rowspan="8" style="text-align: center !important;" ><b>Parameter</b> <br><br> <i style="margin-top: 30px;" class="arrow down icon"></i></td>
			<td class="label align-ctr1 bbt" rowspan="8"><b>Specification<br>(mm)</b> <br> <i style="margin-top: 30px;" class="arrow down icon"></i></td>
			<td class="label align-ctr1 bbt" rowspan="8"><b>Tolerance<br>(mm)</b><br> <i style="margin-top: 30px;" class="arrow down icon"></i></td>
			<td class="label align-ctr1 bbt" rowspan="8"><b>Actual<br>(mm) </b><br> <i style="margin-top: 30px;" class="arrow down icon"></i></td>
			<td class="label align-ctr1 bbt" rowspan="8"><b>Raw Material</b> <br> <i style="margin-top: 40px;" class="arrow right icon"></i></td>
		</tr>
      
      


				<tr>
					<td class="label align-ctr bbt">Layer 1</td>
					<td class="label align-ctr bbt"><?php echo $certificate_of_analysis['LAYER_1'];?></td>
				</tr>
				<tr>
					<td class="label align-ctr bbt">Layer 2</td>
					<td class="label align-ctr bbt"><?php echo $certificate_of_analysis['LAYER_2'];?></td>
				</tr>
				<tr>
					<td class="label align-ctr bbt">Layer 3</td>
					<td class="label align-ctr bbt"><?php echo $certificate_of_analysis['LAYER_3'];?></td>
				</tr>
				<tr>
					<td class="label align-ctr bbt">Layer 4</td>
					<td class="label align-ctr bbt"><?php echo $certificate_of_analysis['LAYER_4'];?></td>
				</tr>
				<tr>
					<td class="label align-ctr bbt">Layer 5</td>
					<td class="label align-ctr bbt"><?php echo $certificate_of_analysis['LAYER_5'];?></td>
				</tr>
				<tr>
					<td class="label align-ctr bbt">Layer 6</td>
					<td class="label align-ctr bbt"><?php echo $certificate_of_analysis['LAYER_6'];?></td>
				</tr>
				<tr>
					<td class="label align-ctr bbt">Layer 7</td>
					<td class="label align-ctr bbt"><?php echo $certificate_of_analysis['LAYER_7'];?></td>
				</tr>

				<tr>
					<td class="label align-ctr bbt" rowspan="13"><b>SLEEVE</b></td>
					<td class="label align-ctr bbt" rowspan="3"><b>Length</b></td>
					<td class="label align-ctr bbt" rowspan="4"><?php echo $certificate_of_analysis['specification_length'];?></td>
					<td class="label align-ctr bbt" rowspan="4">+/-1.5</td>
					<td class="label align-ctr bbt" rowspan="4"><?php echo $certificate_of_analysis['actual_length'];?></td>
					<td class="label align-ctr bbt" rowspan="4"><b>Master Batch %</b></td>
				</tr>
				
				<tr>
					<td class="label bbt">Inner Layer</td>

					<?php  $sleeve_outer = ($certificate_of_analysis['sleeve_outer_per']<>''   ? $certificate_of_analysis['sleeve_outer_per']."% " : '').' '.($certificate_of_analysis['sleeve_outer_layer_color']<>''  ? $certificate_of_analysis['sleeve_outer_layer_color']."" : '').''.($certificate_of_analysis['sleeve_outer_per']=='' && $certificate_of_analysis['sleeve_outer_layer_color']=='' ? ' ' : '');?>
					
					<td class="label bbt"><?php echo $sleeve_outer; ?></td>
				</tr>

				<tr>
					<td class="label bbt">Outer Layer</td>

					<?php  $sleeve_inner = ($certificate_of_analysis['sleeve_inner_per']<>''   ? $certificate_of_analysis['sleeve_inner_per']."% " : '').' '.($certificate_of_analysis['sleeve_inner_layer_color']<>''  ? $certificate_of_analysis['sleeve_inner_layer_color']."" : '').''.($certificate_of_analysis['sleeve_inner_per']=='' && $certificate_of_analysis['sleeve_inner_layer_color']=='' ? ' ' : '');?>

					<td class="label bbt"><?php echo $sleeve_inner;?></td>
				</tr>
				<tr>



						<tr>
							<td class="label align-ctr bbt" rowspan="6"><b>Inner Dia.</b></td>
							<td class="label align-ctr bbt" rowspan="6"><?php echo $certificate_of_analysis['specification_inner_dia'];?></td>
							<td class="label align-ctr bbt" rowspan="6"><?php echo $certificate_of_analysis['inner_tolerance'];?></td>
							<td class="label align-ctr bbt" rowspan="6"><?php echo $certificate_of_analysis['actual_inner_dia']; ?></td>
							<td class="label align-ctr bbt" rowspan="9"><b>Sleeve Thickness (Micron)</b></td>
						</tr>

						<tr>
							<td class="label align-ctr bbt">1st Layer</td>
							<td class="label align-ctr bbt"><?php echo $certificate_of_analysis['GUAGE_Layer_1']; ?></td>
						</tr>
						<tr>
							<td class="label align-ctr bbt">2nd Layer</td>
							<td class="label align-ctr bbt"><?php echo $certificate_of_analysis['GUAGE_Layer_2']; ?></td>
						</tr>
						<tr>
							<td class="label align-ctr bbt">3rd Layer</td>
							<td class="label align-ctr bbt"><?php echo $certificate_of_analysis['GUAGE_Layer_3']; ?></td>
						</tr>
						<tr>
							<td class="label align-ctr bbt">4th Layer</td>
							<td class="label align-ctr bbt"><?php echo $certificate_of_analysis['GUAGE_Layer_4']; ?></td>
						</tr>
						<tr>
							<td class="label align-ctr bbt">5th Layer</td>
							<td class="label align-ctr bbt"><?php echo $certificate_of_analysis['GUAGE_Layer_5']; ?></td>
						</tr>



						<tr>
							<td class="label align-ctr bbt" rowspan="3"><b>Outer Dia.</b></td>
							<td class="label align-ctr bbt" rowspan="3"><?php echo $certificate_of_analysis['specification_outer_dia']; ?></td>
							<td class="label align-ctr bbt"  rowspan="3"><?php echo $certificate_of_analysis['outer_tolerance']; ?></td>
							<td class="label align-ctr bbt" rowspan="3"><?php echo $certificate_of_analysis['actual_outer_dia'];?></td>
						</tr>
						<tr>
							<td class="label align-ctr bbt">6th Layer</td>
							<td class="label align-ctr bbt"><?php echo $certificate_of_analysis['GUAGE_Layer_6']; ?></td>
						</tr>
						<tr>
							<td class="label align-ctr bbt">7th Layer</td>
							<td class="label align-ctr bbt"><?php echo $certificate_of_analysis['GUAGE_Layer_7']; ?></td>
						</tr>


						<tr>
							<td class="label align-ctr bbt" rowspan="3"><b>SHOULDER</td>
							<td class="label align-ctr bbt"><b>Parameter</b></td>
							<td class="label align-ctr bbt"><b>Specification<br>(mm)</b></td>
							<td class="label align-ctr bbt"><b>Tolerance<br>(mm)</b></td>
							<td class="label align-ctr bbt"><b>Actual<br>(mm)</b></td>
							<td class="label align-ctr bbt"><b>Raw Material</b></td>
							<td class="label align-ctr bbt" colspan="2">HDPE</td>
						</tr>
						
						<tr>
							<td class="label align-ctr bbt"><b>Thread Type</b></td>
							<td class="label align-ctr bbt" colspan="2"><?php echo $certificate_of_analysis['shoulder_thread_type'];?></td>
							<td class="label align-ctr bbt"></td>
							<td class="label align-ctr bbt"><b>Master Batch</b></td>
							<td class="label align-ctr bbt" colspan="2"><?php echo $certificate_of_analysis['SHOULDER_MASTER_BATCH_COLOR'];?></td>
						</tr>
						
						<tr>
							<td class="label align-ctr bbt"><b>Orifice</b></td>
							<td class="label align-ctr bbt"><?php echo $certificate_of_analysis['specification_orifice'];?></td>
							<td class="label align-ctr bbt"> <?php echo $certificate_of_analysis['tolerance_orifice'];?></td>
							<td class="label align-ctr bbt"><?php echo $certificate_of_analysis['actual_orifice'];?></td>
							<td class="label align-ctr bbt"><b>Master Batch %</b></td>
							<td class="label align-ctr bbt" colspan="2"><?php echo $certificate_of_analysis['master_batch_orifice'];?>%</td>
						</tr>


						<tr>
							<td class="label align-ctr bbt" rowspan="6"><b>CAP</b></td>
							<td class="label align-ctr bbt"><b>Parameter</b></td>
							<td class="label align-ctr bbt"><b>Specification<br>(mm)</b></td>
							<td class="label align-ctr bbt"><b>Tolerance<br>(mm)</b></td>
							<td class="label align-ctr bbt"><b>Actual<br>(mm)</b></td>
							<td class="label align-ctr bbt"><b>Raw Material</b></td>
							<td class="label align-ctr bbt" colspan="2">PP</td>
						</tr>

						
						<tr>
							<td class="label align-ctr bbt"><b>Type</b></td>
							<td class="label align-ctr align-ctr bbt" colspan="3"><?php echo $certificate_of_analysis['cap_type'];?></td>
							<td class="label align-ctr bbt"><b>Master Batch</b></td>
							<td class="label align-ctr bbt" colspan="2"><?php echo $certificate_of_analysis['cap_master_batch_colour'];?></td>
						</tr>
						
						<tr>
							<td class="label align-ctr bbt"><b>Diameter</b></td>
							<td class="label align-ctr bbt"><?php echo $certificate_of_analysis['specification_diameter'];?></td>
							<td class="label align-ctr bbt">+/-0.2</td>
							<td class="label align-ctr bbt"> <?php echo $certificate_of_analysis['actual_diameter'];?></td>
							<td class="label align-ctr bbtr" rowspan="2"><b>Master Batch %</b></td>
							<td class="label align-ctr bbtr" colspan="2" rowspan="2"><?php echo $certificate_of_analysis['master_batch_diameter'];?>%</td>
						</tr>

						<tr>
							<td class="label align-ctr bbt"><b>Height</b></td>
							<td class="label align-ctr bbt"><?php echo $certificate_of_analysis['specification_height'];
						?></td>
							<td class="label align-ctr bbt">+/-0.2</td>
							<td class="label align-ctr bbt"><?php echo $certificate_of_analysis['actual_height'];?></td>
							
							
						</tr>

						
						<tr>
							<td class="label align-ctr bbt"><b>Cap Orifice</b></td>
							<td class="label align-ctr bbt"><?php echo $certificate_of_analysis['specification_cap_orifice'];?></td>
							<td class="label align-ctr bbt">+/-0.2</td>
							<td class="label align-ctr bbt"><?php echo $certificate_of_analysis['actual_cap_orifice'];?></td>
							<td class="label align-ctr bbtr">&nbsp;&nbsp;&nbsp;</td>
							<td class="label align-ctr bbtr" colspan="2">&nbsp;&nbsp;&nbsp;</td>
						</tr>
						
						<tr>
							<td class="label align-ctr bbt"><b>Shrink Sleeve</b></td>
							<td class="label align-ctr bbt" colspan="3"><?php echo $certificate_of_analysis['specification_shrink_sleeve'];?></td>
							<td class="label align-ctr bbtr" >&nbsp;&nbsp;&nbsp;</td>
							<td class="label align-ctr bbtr" colspan="2">&nbsp;&nbsp;&nbsp;</td>
						</tr>

						<?php
							if($certificate_of_analysis['lacquer_type']=='-'){?>
							   <tr>
								<td class="label align-ctr bbt"><b>LABEL</b></td>
								<td class="label align-ctr bbt"><b>Non. Lacq. Height</b></td>
								<td class="label align-ctr bbt"><?php echo $certificate_of_analysis['lbl_specification'];?></td>
								<td class="label align-ctr bbt">+/-1</td>
								<td class="label align-ctr bbt"><?php echo $certificate_of_analysis['lbl_actual_print'];?></td>
								<td class="label align-ctr bbt"><b>Lacquer Type</b></td>
								<td class="label align-ctr bbt" colspan="2"><?php echo $certificate_of_analysis['lbl_lacquer_type'];?></td>
							</tr>
						<?php }else{ ?>
							<tr>
								<td class="label align-ctr bbt"><b>PRINT</b></td>
								<td class="label align-ctr bbt"><b>Non. Lacq. Area</b></td>
								<td class="label align-ctr bbt"><?php echo $certificate_of_analysis['specification_print'];?></td>
								<td class="label align-ctr bbt">+/-1</td>
								<td class="label align-ctr bbt"><?php echo $certificate_of_analysis['actual_print'];?></td>
								<td class="label align-ctr bbt"><b>Lacquer Type</b></td>
								<td class="label align-ctr bbt" colspan="2"><?php echo $certificate_of_analysis['lacquer_type'];?></td>
							</tr>
						<?php } ?>

						<tr>
							<td class="label align-lft bbt bg-parameter" colspan="8"><b><span class="span-h">TESTING PARAMETERS:</span></b></td>
						</tr>
						<tr>
							<td class="label align-ctr bbt">1.</td>
							<td  class="label align-lft bbt" colspan="2">Air Leakage</td>
							<td class="label align-ctr bbt"> 
							 <?php if($certificate_of_analysis['air_leakage_status'] =='1'){
							 	echo 'PASS';
							 }elseif($certificate_of_analysis['air_leakage_status'] =='2'){
                                echo 'FAIL';
							 }else{
							 	echo 'N/A';
							 }?></td>

							<td class="label align-ctr bbt">9.</td>
							<td class="label align-lft bbt" colspan="2">Sleeve colour Opacity</td>
							<td class="label align-ctr bbt">
							<?php if($certificate_of_analysis['sleeve_colour_opacity_status'] =='1'){
							 	echo 'PASS';
							 }elseif($certificate_of_analysis['sleeve_colour_opacity_status'] =='2'){
                                echo 'FAIL';
							 }else{
							 	echo 'N/A';
							 }?>

						</tr>
						<tr>
							 <td class="label align-ctr bbt">2.</td>
							<td class="label align-lft bbt" colspan="2">Water Leakage</td>
							<td class="label align-ctr bbt">
               <?php if($certificate_of_analysis['water_package_status'] =='1'){
							 	echo 'PASS';
							 }elseif($certificate_of_analysis['water_package_status'] =='2'){
                                echo 'FAIL';
							 }else{
							 	echo 'N/A';
							 }?>
                            </td>

							<td class="label align-ctr bbt">10.</td>
							<td  class="label align-lft bbt" colspan="2">Gliding Test</td>
							<td class="label align-ctr bbt">
                            <?php if($certificate_of_analysis['gliding_test_status'] =='1'){
							 	echo 'PASS';
							 }elseif($certificate_of_analysis['gliding_test_status'] =='2'){
                                echo 'FAIL';
							 }else{
							 	echo 'N/A';
							 }?>
                            </td>
							</td>
							
						</tr>
						<tr>
							<td class="label align-ctr bbt">3.</td>
							<td  class="label align-lft  bbt" colspan="2">Cap Fitment</td>
							<td class="label align-ctr bbt">
                            <?php if($certificate_of_analysis['cap_fitment_status'] =='1'){
							 	echo 'PASS';
							 }elseif($certificate_of_analysis['cap_fitment_status'] =='2'){
                                echo 'FAIL';
							 }else{
							 	echo 'N/A';
							 }?></td>
							<td class="label align-ctr bbt">11.</td>
							<td class="label align-lft bbt" colspan="2">U.V Test</td>
							<td class="label align-ctr bbt">
                            <?php if($certificate_of_analysis['uv_test_status'] =='1'){
							 	echo 'PASS';
							 }elseif($certificate_of_analysis['uv_test_status'] =='2'){
                                echo 'FAIL';
							 }else{
							 	echo 'N/A';
							 }?>
							</td>
						</tr>
						<tr>
							<td class="label align-ctr bbt">4.</td>
							<td  class="label align-lft bbt" colspan="2">Shoulder Welding Test</td>
							<td class="label align-ctr bbt">
                            <?php if($certificate_of_analysis['shoulder_welding_test_status'] =='1'){
							 	echo 'PASS';
							 }elseif($certificate_of_analysis['shoulder_welding_test_status'] =='2'){
                                echo 'FAIL';
							 }else{
							 	echo 'N/A';
							 }?>
							</td>
							<td class="label align-ctr bbt">12.</td>
							<td class="label align-lft bbt" colspan="2">Drop Test</td>
							<td class="label align-ctr bbt">
                            <?php if($certificate_of_analysis['drop_test_status'] =='1'){
							 	echo 'PASS';
							 }elseif($certificate_of_analysis['drop_test_status'] =='2'){
                                echo 'FAIL';
							 }else{
							 	echo 'N/A';
							 }?></td>
						</tr>
						<tr>
							<td class="label align-ctr bbt">5.</td>
							<td  class="label align-lft bbt" colspan="2">ESCR Test</td>
							<td class="label align-ctr bbt">
                            <?php if($certificate_of_analysis['escr_test_status'] =='1'){
							 	echo 'PASS';
							 }elseif($certificate_of_analysis['escr_test_status'] =='2'){
                                echo 'FAIL';
							 }else{
							 	echo 'N/A';
							 }?>
							</td>
							<td class="label align-ctr bbt">13.</td>
							<td class="label align-lft bbt" colspan="2">Tape Test</td>
							<td class="label align-ctr bbt">
                            <?php if($certificate_of_analysis['tape_test_status'] =='1'){
							 	echo 'PASS';
							 }elseif($certificate_of_analysis['tape_test_status'] =='2'){
                                echo 'FAIL';
							 }else{
							 	echo 'N/A';
							 }?>
							 </td>
						</tr>
						<tr>
							<td class="label align-ctr bbt">6.</td>
							<td  class="label align-lft bbt" colspan="2">Odour Test</td>
							<td class="label align-ctr bbt">
                             <?php if($certificate_of_analysis['odour_test_status'] =='1'){
							 	echo 'PASS';
							 }elseif($certificate_of_analysis['odour_test_status'] =='2'){
                                echo 'FAIL';
							 }else{
							 	echo 'N/A';
							 }?></td>
							<td class="label align-ctr bbt">14.</td>
							<td class="label align-lft bbt" colspan="2">Rub Test</td>
							<td class="label align-ctr bbt">
							<?php if($certificate_of_analysis['rub_test_status'] =='1'){
							 	echo 'PASS';
							 }elseif($certificate_of_analysis['rub_test_status'] =='2'){
                                echo 'FAIL';
							 }else{
							 	echo 'N/A';
							 }?></td>
						</tr>
						<tr>
							<td class="label align-ctr bbt">7.</td>
							<td  class="label align-lft bbt" colspan="2">Vertically Test</td>
							<td class="label align-ctr bbt">
                            <?php if($certificate_of_analysis['vertically_test_status']  =='1'){
							 	echo 'PASS';
							 }elseif($certificate_of_analysis['vertically_test_status'] =='2'){
                                echo 'FAIL';
							 }else{
							 	echo 'N/A';
							 }?>
							 </td>
							<td class="label align-ctr bbt">15.</td>
							<td class="label align-lft bbt" colspan="2">Sealing Test</td>
							<td class="label align-ctr bbt">
                            <?php if($certificate_of_analysis['sealing_test_status']  =='1'){
							 	echo 'PASS';
							 }elseif($certificate_of_analysis['sealing_test_status'] =='2'){
                                echo 'FAIL';
							 }else{
							 	echo 'N/A';
							 }?>
							</td>
						</tr>
						<tr>
							<td class="label align-ctr bbt">8.</td>
							<td  class="label align-lft bbt" colspan="2">Sleeve Colour Difference</td>
							<td class="label align-ctr bbt">
                            <?php if($certificate_of_analysis['sleeve_colour_difference_status']  =='1'){
							 	echo 'PASS';
							 }elseif($certificate_of_analysis['bar_code_test_status']  =='2'){
                                echo 'FAIL';
							 }else{
							 	echo 'N/A';
							 }?>
							 </td>
							<td class="label align-ctr bbt">16.</td>
							<td class="label align-lft bbt" colspan="2">Bar Code Readable</td>
							<td class="label align-ctr bbt"> 
                             <?php if($certificate_of_analysis['bar_code_test_status'] =='1'){
							 	echo 'PASS';
							 }elseif($certificate_of_analysis['bar_code_test_status'] =='2'){
                                echo 'FAIL';
							 }else{
							 	echo 'N/A';
							 }?>
							</td>
						</tr>
						<tr>
							<td class="label align-lft bg-parameter" colspan="8"><b><span class="span-h">TESTING PARAMETERS: SPRING</span></b></td>
						</tr>
						<tr>
							<td class="label align-ctr bbt">17.</td>
							<td  class="label align-lft bbt" colspan="2">Welding Test Side Seam</td>
							<td class="label align-ctr bbt">
								 <?php if($certificate_of_analysis['welding_test_side_seam_status'] =='1'){
								 	echo 'PASS';
								 }elseif($certificate_of_analysis['welding_test_side_seam_status'] =='2'){
	                                echo 'FAIL';
								 }else{
								 	echo 'N/A';
								 }?>
						    </td>
							<td class="label align-ctr bbt" colspan="4"></td>

						</tr>
						<tr>
							<td class="label align-lft bbt bg-parameter" colspan="8"><b><span class="span-h">SAMPLING:</span></b></td>
						</tr>
						<tr>
							<td class="label align-lft bbt" colspan="2"><b>Total Number Of Pallets</b></td>
							<td class="label align-ctr bbt" colspan="2"><?php echo $certificate_of_analysis['total_number_of_pallets'];?></td>
							<td class="label align-lft bbt" colspan="2"><b>Sample Per Pallets</b></td>
							<td class="label align-ctr bbt" colspan="2"><?php echo $certificate_of_analysis['sample_per_pallets']; ?></td>
						</tr>
						<tr>
							<td  class="label align-lft bbt" colspan="2"><b>Number Of Pallets Rechecked</b></td>
							<td  class="label align-ctr bbt" colspan="2"><?php echo $certificate_of_analysis['number_of_pallets_rechecked']; ?></td>
							<td  class="label align-lft bbt" colspan="2"><b>Result</b></td>
							<td class="label align-ctr bbt" colspan="2">
                            <?php if($certificate_of_analysis['coa_result_status'] =='1'){
							 	echo 'PASS';
							 }else{
							 	echo 'FAIL';
							 }?>
							</td>
						</tr>
						<tr>
							<td  class="label align-lft bbt" colspan="2"><b>Prepared</b></td>
							<td  class="label align-ctr bbt" colspan="2"><?php echo $certificate_of_analysis['prepared_name']; ?></td>
							<td  class="label align-lft bbt" colspan="2"><b>Approved By</b></td>
							<td  class="label align-ctr bbt" colspan="2"><?php echo (empty($certificate_of_analysis['approval_username']) ? '-' : strtoupper($certificate_of_analysis['approval_username'])); ?>
						</tr>	
						<tr>
							 <td  class="label bbt txt_ctr" colspan="8"><b>This is an electronically generated document and therefore does not require any signature.</b></td>

						</tr>
					
			    </td>
					</table>

    
</body>
</html>           