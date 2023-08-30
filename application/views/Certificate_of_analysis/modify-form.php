<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>

<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		$("#certificate_no").autocomplete("<?php echo base_url('index.php/ajax/ar_invoice_no');?>", {selectFirst: true});

	});//Jquery closed
</script>

<style>
input{width: 100%;}
.align-ctr{text-align: center;}
.align-ctr1{text-align: center;}
.align-lft{text-align: left;}
td.label.align-ctr{vertical-align: middle;}
select{width: 100%;}
.span-h{font-size: 16px;
    border-bottom: 1px solid #000000;}
.span-required{color: red;}
.bg-parameter{background: #dffcfc;}
input {
    display: block;
    height: auto;
    width: 100%;
    background: #fff;
    border: 1px solid rgba(34,36,38,.15);
    border-radius: 0.28571429rem;
    box-shadow: 0 0 0 0 transparent inset;
    padding: 0.62em 1em;
    color: rgba(0,0,0,.87);
    -webkit-transition: color .1s ease,border-color .1s ease;
    transition: color .1s ease,border-color .1s ease;
}
select{
    display: block;
    height: auto;
    width: 100%;
    background: #fff;
    border: 1px solid rgba(34,36,38,.15);
    border-radius: 0.28571429rem;
    box-shadow: 0 0 0 0 transparent inset;
    padding: 0.62em 1em;
    color: rgba(0,0,0,.87);
    -webkit-transition: color .1s ease,border-color .1s ease;
    transition: color .1s ease,border-color .1s ease;
}
table.form_table_inner td {
    border: 0px solid #f9f9f9;}
</style>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST" >
	<div class="form_design">
        <?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
		<table class="form_table_design">
			<tr>
                <td>
					<table class="form_table_inner" width="100%">
		            <?php foreach($certificate_of_analysis as $row):?>	

					<tr>
						<td class="label align-ctr"><b>Certificate No.</b><span style="color:red;">*</span> :</td>
						<td colspan="3"><input type="text" name="certificate_no"  Placeholder="Search Invoice No." id="certificate_no" size="" value="<?php echo set_value('certificate_no',$row->certificate_no);?>" size="16" maxlength="16" onchange="check_invoice_no(this.value);"  readonly required/>
							 <input type="hidden" name="record_no"  value="<?php echo $row->certificate_no.'@@@'.$row->so_no.'@@@'.$row->product_name;?>">

						</td> 
						<td class="label align-ctr"><b>Date</b><span style="color:red;">*</span> :</td>
						<td colspan="3"><input type="date" name="inspection_date"  size="10" id="invoice_date" value="<?php echo set_value('inspection_date',$row->inspection_date);?>" readonly required/></td>
					</tr>

					<tr> 
						<td class="label align-ctr"><b>SO NO.</b><span style="color:red;">*</span> :</td>
						<td colspan="3"><input type="text" name="so_no"  size="" Placeholder="Enter SO NO." id="order_no" readonly value="<?php echo set_value('so_no',$row->so_no);?>"  readonly required/></td>

						<td class="label align-ctr"><b>Product</b><span style="color:red;">*</span> :</td>
						<td colspan="3"><input type="text" name="product_name"  size="" Placeholder="Enter Product Name" id="aid_article_no"value="<?php echo set_value('product_name',$row->product_name);?>" readonly required/></td> 
					</tr>

					<tr>
						<td class="label align-ctr"><b>Customer Name</b><span style="color:red;">*</span> :</td>
						<td colspan="3"><input type="text" name="customer_name"  Placeholder="Enter Customer Name" size="" id="customer_name" value="<?php echo set_value('customer_name',$row->customer_name);?>" readonly required/></td> 

						<td class="label align-ctr"><b>AQL</b> <span style="color:red;">*</span> :</td>
						<td colspan="3"><input type="text" name="quality" value="<?php echo set_value('quality',$row->quality);?>" required/></td> 
					</tr>

					<tr>
						<td class="label align-ctr"><b>Total Qty</b> <span style="color:red;">*</span> :</td>
						<td colspan="3"><input type="text" name="total_qty"  Placeholder="NOS" value="<?php echo set_value('total_qty',$row->total_qty);?>" required/></td> 
						<td class="label align-ctr"><b>Sample Size</b> <span style="color:red;">*</span> :</td>
						<td colspan="3"><input type="text" name="sample_size"  Placeholder="NOS" value="<?php echo set_value('sample_size',$row->sample_size);?>" required/></td> 
					</tr>

					<tr>
						<td class="label align-ctr bg-parameter" colspan="6"><b><span class="span-h">Dimensional Compliance</span></b></td>
						<td class="label align-ctr bg-parameter" colspan="2"><b><span class="span-h">Monolayer/Multilayer</span></b></td>
					</tr>
			
					<tr>
						<td class="label align-ctr1" rowspan="8"><b>Process</b> <br><br> <i style="margin-top: 40px;" class="arrow down icon"></i></td>
						<td class="label align-ctr1" rowspan="8"><b>Parameter</b> <br><br> <i style="margin-top: 40px;" class="arrow down icon"></i></td>
						<td class="label align-ctr1" rowspan="8"><b>Specification<br>(mm)</b> <br> <i style="margin-top: 40px;" class="arrow down icon"></i></td>
						<td class="label align-ctr1" rowspan="8"><b>Tolerance<br>(mm)</b><br> <i style="margin-top: 40px;" class="arrow down icon"></i></td>
						<td class="label align-ctr1" rowspan="8"><b>Actual<br>(mm) </b><br> <i style="margin-top: 40px;" class="arrow down icon"></i></td>
						<td class="label align-ctr1" rowspan="8"><b>Raw Material</b> <br> <i style="margin-top: 60px;" class="arrow right icon"></i></td>
					</tr>
					
					<tr>
						<td class="label align-ctr">1st Layer</td>
						<td class="label align-ctr">Data Show In View Page</td>
					</tr>

					<tr>
						<td class="label align-ctr">2nd Layer</td>
						<td class="label align-ctr">Data Show In View Page</td>
					</tr>
					
					<tr>
						<td class="label align-ctr">3rd Layer</td>
						<td class="label align-ctr">Data Show In View Page</td>
					</tr>
					
					<tr>
						<td class="label align-ctr">4th Layer</td>
						<td class="label align-ctr">Data Show In View Page</td>
					</tr>
			
					<tr>
						<td class="label align-ctr">5th Layer</td>
						<td class="label align-ctr">Data Show In View Page</td>
					</tr>
					
					<tr>
						<td class="label align-ctr">6th Layer</td>
						<td class="label align-ctr">Data Show In View Page</td>
					</tr>
					
					<tr>
						<td class="label  align-ctr">7th Layer</td>
						<td class="label align-ctr">Data Show In View Page</td>
					</tr>
					
					<tr>
						<td class="label align-ctr" rowspan="13"><b>SLEEVE</b></td>
						<td class="label align-ctr" rowspan="4"><b>Length<span class="span-required">*</span></b></td>
						<td class="label align-ctr" rowspan="4"><input type="text" name="specification_length"  Placeholder="Enter Specification Length" id="sleeve_length" readonly value="<?php echo set_value('specification_length',$row->specification_length);?>" required/></td>
						<td class="label align-ctr" rowspan="4">+/-1.5</td>
						<td class="label align-ctr" rowspan="4"><input type="text" name="actual_length"  Placeholder="Enter Actual Length" value="<?php echo set_value('actual_length',$row->actual_length);?>" required/></td>
						<td class="label align-ctr" rowspan="4"><b>Master Batch %</b></td>
					</tr>
					
					<tr>
						<td class="label">&nbsp;&nbsp;&nbsp;</td>
						<td class="label">&nbsp;&nbsp;&nbsp;</td>
					</tr>
					
					<tr>
						<td class="label">&nbsp;&nbsp;&nbsp;</td>
						<td class="label">&nbsp;&nbsp;&nbsp;</td>
					</tr>
					
					<tr>
						<td class="label">&nbsp;&nbsp;&nbsp;</td>
						<td class="label">&nbsp;&nbsp;&nbsp;</td>
					</tr>
			
					<tr>
						<td class="label align-ctr" rowspan="6"><b>Inner Dia.<span class="span-required">*</span></b></td>
						<td class="label align-ctr" rowspan="6"><input type="text" name="specification_inner_dia"  Placeholder="Enter Specification Inner Dia." id="inner_diameter" value="<?php echo set_value('specification_inner_dia',$row->specification_inner_dia);?>" readonly required/></td>
						<td class="label align-ctr" rowspan="6"><input type="text" name="inner_tolerance"  Placeholder="Enter inner tolerance" id="inner_tolerance" value="<?php echo set_value('inner_tolerance',$row->inner_tolerance);?>" readonly/></td>
						<td class="label align-ctr" rowspan="6"><input type="text" name="actual_inner_dia"  Placeholder="Enter Actual Inner Dia."  value="<?php echo set_value('actual_inner_dia',$row->actual_inner_dia);?>" required/></td>
						<td class="label align-ctr" rowspan="9"><b>Sleeve Thickness (Micron)</b></td>
					</tr>

					<tr>
						<td class="label align-ctr">1st Layer</td>
						<td class="label align-ctr">20 micron</td>
					</tr>
					
					<tr>
						<td class="label align-ctr">2nd Layer</td>
						<td class="label align-ctr">155 micron</td>
					</tr>
					
					<tr>
						<td class="label align-ctr">3rd Layer</td>
						<td class="label align-ctr">10 micron</td>
					</tr>
					
					<tr>
						<td class="label align-ctr">4th Layer</td>
						<td class="label align-ctr">25 micron</td>
					</tr>
			
					<tr>
						<td class="label align-ctr">5th Layer</td>
						<td class="label align-ctr">10 micron</td>
					</tr>
					
					<tr>
						<td class="label align-ctr" rowspan="3"><b>Outer Dia.<span class="span-required">*</span></b></td>
						<td class="label align-ctr" rowspan="3"><input type="text" name="specification_outer_dia"   Placeholder="Enter Specification Outer Dia." id="outer_diameter" value="<?php echo set_value('specification_outer_dia',$row->specification_outer_dia);?>" readonly required/></td>
						<td class="label align-ctr"  rowspan="3"><input type="text" name="outer_tolerance"   Placeholder="Enter outer tolerance" id="outer_tolerance" value="<?php echo set_value('outer_tolerance',$row->outer_tolerance);?>" readonly/></td>
						<td class="label align-ctr" rowspan="3"><input type="text" name="actual_outer_dia"  Placeholder="Enter Actual Outer Dia." value="<?php echo set_value('actual_outer_dia',$row->actual_outer_dia);?>" required/></td>
					</tr>

					<tr>
						<td class="label align-ctr">6th Layer</td>
						<td class="label align-ctr">210 micron</td>
					</tr>
					
					<tr>
						<td class="label align-ctr">7th Layer</td>
						<td class="label align-ctr">20 micron</td>
					</tr>

					<tr>
						<td class="label align-ctr" rowspan="3"><b>SHOULDER</td>
						<td class="label align-ctr"><b>Parameter</b></td>
						<td class="label align-ctr"><b>Specification<br>(mm)</b></td>
						<td class="label align-ctr"><b>Tolerance<br>(mm)</b></td>
						<td class="label align-ctr"><b>Actual<br>(mm)</b></td>
						<td class="label align-ctr"><b>Raw Material<span class="span-required">*</span></b></td>
						<td class="label align-ctr" colspan="2">HDPE</td>
					</tr>

					<tr>
						<td class="label align-ctr"><b>Thread Type<span class="span-required">*</span></b></td>
						<td class="label align-ctr" colspan="2"><input type="text" name="shoulder_thread_type"  Placeholder="Enter Thread Type" id="shoulder_style" value="<?php echo set_value('shoulder_thread_type',$row->shoulder_thread_type);?>" readonly required/></td>
						<td class="label align-ctr"></td>
						<td class="label align-ctr"><b>Master Batch<span class="span-required">*</span></b></td>
						<td class="label align-ctr" colspan="2"><input type="text" name="shoulder_master_batch"  Placeholder="Enter Master Batch" id="shoulder_batch" value="<?php echo set_value('shoulder_master_batch',$row->shoulder_master_batch);?>" readonly required/></td>
					</tr>
					
					<tr>
						<td class="label align-ctr"><b>Orifice<span class="span-required">*</span></b></td>
						<td class="label align-ctr"><input type="text" name="specification_orifice"  Placeholder="Enter Orifice Specification"  id="shoulder_orifice" value="<?php echo set_value('specification_orifice',$row->specification_orifice);?>" readonly required/></td>
						<td class="label align-ctr"><input type="text" name="tolerance_orifice"  Placeholder="Enter Orifice Tolerance" value="<?php echo set_value('tolerance_orifice',$row->tolerance_orifice);?>" readonly required/></td>
						<td class="label align-ctr"><input type="text" name="actual_orifice"  Placeholder="Enter Orifice Actual" value="<?php echo set_value('actual_orifice',$row->actual_orifice);?>" required/></td>
						<td class="label align-ctr"><b>Master Batch %<span class="span-required">*</span></b></td>
						<td class="label align-ctr" colspan="2"><input type="text" name="master_batch_orifice"  Placeholder="Enter %Master Batch" id="shoulder_info" value="<?php echo set_value('master_batch_orifice',$row->master_batch_orifice);?>" readonly required/></td>
					</tr>

					<tr>
						<td class="label align-ctr" rowspan="6"><b>CAP</b></td>
						<td class="label align-ctr"><b>Parameter</b></td>
						<td class="label align-ctr"><b>Specification<br>(mm)</b></td>
						<td class="label align-ctr"><b>Tolerance<br>(mm)</b></td>
						<td class="label align-ctr"><b>Actual<br>(mm)</b></td>
						<td class="label align-ctr"><b>Raw Material<span class="span-required">*</span></b></td>
						<td class="label align-ctr" colspan="2">PP</td>
					</tr>

					<tr>
						<td class="label align-ctr"><b>Type<span class="span-required">*</span></b></td>
						<td class="label align-ctr align-ctr" colspan="3"><input type="text" name="cap_type"  Placeholder="Enter Cap Type" id="cap_dia" value="<?php echo set_value('cap_type',$row->cap_type);?>" readonly required/></td>
						<td class="label align-ctr"><b>Master Batch<span class="span-required">*</span></b></td>
						<td class="label align-ctr" colspan="2"><input type="text" name="cap_master_batch_colour"  Placeholder="Enter Master Batch Colour" id="cap_master_batch_color" value="<?php echo set_value('cap_master_batch_colour',$row->cap_master_batch_colour);?>" readonly required/></td>
					</tr>

					<tr>
						<td class="label align-ctr"><b>Diameter<span class="span-required">*</span></b></td>
						<td class="label align-ctr"><input type="text" name="specification_diameter"  Placeholder="Enter Specification Diameter" id="" value="<?php echo set_value('specification_diameter',$row->specification_diameter);?>" readonly  required/></td>
						<td class="label align-ctr">+/-0.2</td>
						<td class="label align-ctr"><input type="text" name="actual_diameter"  Placeholder="Enter Actual Diameter" value="<?php echo set_value('actual_diameter',$row->actual_diameter);?>" required/></td>
						<td class="label align-ctr" rowspan="2"><b>Master Batch %<span class="span-required">*</span></b></td>
						<td class="label align-ctr" colspan="2" rowspan="2"><input type="text" name="master_batch_diameter"  Placeholder="Enter %Master Batch" id="cap_master_batch_info" value="<?php echo set_value('master_batch_diameter',$row->master_batch_diameter);?>" readonly required/></td>
					</tr>

					<tr>
						<td class="label align-ctr"><b>Height<span class="span-required">*</span></b></td>
						<td class="label align-ctr"><input type="text" name="specification_height"  Placeholder="Enter Specification Height"  value="<?php echo set_value('specification_height',$row->specification_height);?>" required/></td>
						<td class="label align-ctr">+/-0.2</td>
						<td class="label align-ctr"><input type="text" name="actual_height"  Placeholder="Enter Actual Height" value="<?php echo set_value('actual_height',$row->actual_height);?>" required/></td>
					</tr>

					<tr>
						<td class="label align-ctr"><b>Cap Orifice<span class="span-required">*</span></b></td>
						<td class="label align-ctr"><input type="text" name="specification_cap_orifice"  Placeholder="Enter Specification Cap Orifice"  id="cap_orifice" value="<?php echo set_value('specification_cap_orifice',$row->specification_cap_orifice);?>" readonly required/></td>
						<td class="label align-ctr">+/-0.2</td>
						<td class="label align-ctr"><input type="text" name="actual_cap_orifice" Placeholder="Enter Actual Cap Orifice"   value="<?php echo set_value('actual_cap_orifice',$row->actual_cap_orifice);?>" required/></td>
						<td class="label align-ctr">&nbsp;&nbsp;&nbsp;</td>
						<td class="label align-ctr" colspan="2">&nbsp;&nbsp;&nbsp;</td>
					</tr>

					<tr>
						<td class="label align-ctr"><b>Shrink Sleeve<span class="span-required">*</span></b></td>
						<td class="label align-ctr"><input type="text" name="specification_shrink_sleeve"  Placeholder="Enter Specification Shrink Sleeve"  id="cap_shrink_sleeve" value="<?php echo set_value('specification_shrink_sleeve',$row->specification_shrink_sleeve);?>" readonly required/></td>
						<td class="label align-ctr" >&nbsp;&nbsp;&nbsp;</td>
						<td class="label align-ctr"><input type="text" name="actual_shrink_sleeve"  Placeholder="Enter Actual Shrink Sleeve"  value="<?php echo set_value('actual_shrink_sleeve',$row->actual_shrink_sleeve);?>" /></td>
						<td class="label align-ctr" >&nbsp;&nbsp;&nbsp;</td>
						<td class="label align-ctr" colspan="2">&nbsp;&nbsp;&nbsp;</td>
					</tr>

					<tr>
						<td class="label align-ctr"><b>PRINT</b></td>
						<td class="label align-ctr"><b>Non. Lacq. Area<span class="span-required">*</span></b></td>
						<td class="label align-ctr"><input type="text" name="specification_print"  Placeholder="Enter Specification Print"  value="<?php echo set_value('specification_print',$row->specification_print);?>" readonly required/></td>
						<td class="label align-ctr">+/-1</td>
						<td class="label align-ctr"><input type="text" name="actual_print"  Placeholder="Enter Actual Print"  value="<?php echo set_value('actual_print',$row->actual_print);?>" required/></td>
						<td class="label align-ctr"><b>Lacquer Type<span class="span-required">*</span></b></td>
						<td class="label align-ctr" colspan="2"><input type="text" name="lacquer_type"  Placeholder="Enter Lacquer Type "  value="<?php echo set_value('lacquer_type',$row->lacquer_type);?>" readonly  required/></td>
					</tr>
					
					<td>
					
					<tr>
						<td class="label align-lft bg-parameter" colspan="8"><b><span class="span-h">TESTING PARAMETERS: COEX</span></b></td>
					</tr>
			
					<tr>
						<td class="label align-ctr">1.</td>
						<td  class="label align-lft" colspan="2">Air Leakage<span class="span-required">*</span></td>
						<td class="label align-ctr"><select name="air_leakage_status" required="required">				
							<option value="1" <?php echo ($row->air_leakage_status=='1' ? "selected" : ""); ?> <?php echo set_select('air_leakage_status','1');?>>PASS</option>

							<option value="2" <?php echo ($row->air_leakage_status=='2' ? "selected" : ""); ?> <?php echo set_select('air_leakage_status','2');?>>FAIL</option>
							<option value="0" <?php echo ($row->air_leakage_status=='0' ? "selected" : ""); ?> <?php echo set_select('air_leakage_status','0');?>>N/A</option>
						</select></td>

						<td class="label align-ctr">9.</td>
						<td class="label align-lft" colspan="2">Sleeve Colour Opacity<span class="span-required">*</span></td>
						<td class="label align-ctr"><select name="sleeve_colour_opacity_status" required="required">				
							<option value="1" <?php echo ($row->sleeve_colour_opacity_status=='1' ? "selected" : ""); ?> <?php echo set_select('sleeve_colour_opacity_status','1');?>>PASS</option>
							<option value="2" <?php echo ($row->sleeve_colour_opacity_status=='2' ? "selected" : ""); ?> <?php echo set_select('sleeve_colour_opacity_status','2');?>>FAIL</option>
							<option value="0" <?php echo ($row->sleeve_colour_opacity_status=='0' ? "selected" : ""); ?> <?php echo set_select('sleeve_colour_opacity_status','0');?>>N/A</option>
						</select></td>
					</tr>

					<tr>
						 <td class="label align-ctr">2.</td>
						<td class="label align-lft" colspan="2">Water Leakage<span class="span-required">*</span></td>
						<td class="label align-ctr"><select name="water_package_status" required="required">				
							<option value="1" <?php echo ($row->water_package_status=='1' ? "selected" : ""); ?> <?php echo set_select('water_package_status','1');?>>PASS</option>
							<option value="2" <?php echo ($row->water_package_status=='2' ? "selected" : ""); ?> <?php echo set_select('water_package_status','2');?>>FAIL</option>
							<option value="0" <?php echo ($row->water_package_status=='0' ? "selected" : ""); ?> <?php echo set_select('water_package_status','0');?>>N/A</option>
						</select>

						<td class="label align-ctr">10.</td>
						<td  class="label align-lft" colspan="2">Gliding Test<span class="span-required">*</span></td>
						<td class="label align-ctr"><select name="gliding_test_status" required="required">				
							<option value="1" <?php echo ($row->gliding_test_status=='1' ? "selected" : ""); ?> <?php echo set_select('gliding_test_status','1');?>>PASS</option>
							<option value="2" <?php echo ($row->gliding_test_status=='2' ? "selected" : ""); ?> <?php echo set_select('gliding_test_status','2');?>>FAIL</option>
							<option value="0" <?php echo ($row->gliding_test_status=='0' ? "selected" : ""); ?> <?php echo set_select('gliding_test_status','0');?>>N/A</option>
						</select></td>
						</td>
						
					</tr>

					<tr>
						<td class="label align-ctr">3.</td>
						<td  class="label align-lft" colspan="2">Cap Fitment<span class="span-required">*</span></td>
						<td class="label align-ctr"><select name="cap_fitment_status" required="required">				
							<option value="1" <?php echo ($row->cap_fitment_status=='1' ? "selected" : ""); ?> <?php echo set_select('cap_fitment_status','1');?>>PASS</option>
							<option value="2" <?php echo ($row->cap_fitment_status=='2' ? "selected" : ""); ?> <?php echo set_select('cap_fitment_status','2');?>>FAIL</option>
							<option value="0" <?php echo ($row->cap_fitment_status=='0' ? "selected" : ""); ?> <?php echo set_select('cap_fitment_status','0');?>>N/A</option>
						</select></td>
						<td class="label align-ctr">11.</td>
						<td class="label align-lft" colspan="2">U.V Test</td>
						<td class="label align-ctr"><select name="uv_test_status" required="required">				
							<option value="1" <?php echo ($row->uv_test_status=='1' ? "selected" : ""); ?> <?php echo set_select('uv_test_status','1');?>>PASS</option>
							<option value="2" <?php echo ($row->uv_test_status=='2' ? "selected" : ""); ?> <?php echo set_select('uv_test_status','2');?>>FAIL</option>
							<option value="0" <?php echo ($row->uv_test_status=='0' ? "selected" : ""); ?> <?php echo set_select('uv_test_status','0');?>>N/A</option>
						</select></td>
					</tr>
		
					<tr>
						<td class="label align-ctr">4.</td>
						<td  class="label align-lft" colspan="2">Shoulder Welding Test<span class="span-required">*</span></td>
						<td class="label align-ctr"><select name="shoulder_welding_test_status" required="required">				
							<option value="1" <?php echo ($row->shoulder_welding_test_status=='1' ? "selected" : ""); ?> <?php echo set_select('shoulder_welding_test_status','1');?>>PASS</option>
							<option value="2" <?php echo ($row->shoulder_welding_test_status=='2' ? "selected" : ""); ?> <?php echo set_select('shoulder_welding_test_status','2');?>>FAIL</option>
							<option value="0" <?php echo ($row->shoulder_welding_test_status=='0' ? "selected" : ""); ?> <?php echo set_select('shoulder_welding_test_status','0');?>>N/A</option>
						</select></td>
						<td class="label align-ctr">12.</td>
						<td class="label align-lft" colspan="2">Drop Test<span class="span-required">*</span></td>
						<td class="label align-ctr"><select name="drop_test_status" required="required">				
							<option value="1" <?php echo ($row->drop_test_status=='1' ? "selected" : ""); ?> <?php echo set_select('drop_test_status','1');?>>PASS</option>
							<option value="2" <?php echo ($row->drop_test_status=='2' ? "selected" : ""); ?> <?php echo set_select('drop_test_status','2');?>>FAIL</option>
							<option value="0" <?php echo ($row->drop_test_status=='0' ? "selected" : ""); ?> <?php echo set_select('drop_test_status','0');?>>N/A</option>
						</select></td>
					</tr>
		
					<tr>
						<td class="label align-ctr">5.</td>
						<td  class="label align-lft" colspan="2">ESCR Test<span class="span-required">*</span></td>
						<td class="label align-ctr"><select name="escr_test_status" required="required">				
							<option value="1" <?php echo ($row->escr_test_status=='1' ? "selected" : ""); ?> <?php echo set_select('escr_test_status','1');?>>PASS</option>
							<option value="2" <?php echo ($row->escr_test_status=='2' ? "selected" : ""); ?> <?php echo set_select('escr_test_status','2');?>>FAIL</option>
							<option value="0" <?php echo ($row->escr_test_status=='0' ? "selected" : ""); ?> <?php echo set_select('escr_test_status','0');?>>N/A</option>
						</select></td>
						<td class="label align-ctr">13.</td>
						<td class="label align-lft" colspan="2">Tape Test<span class="span-required">*</span></td>
						<td class="label align-ctr"><select name="tape_test_status" required="required">				
							<option value="1" <?php echo ($row->tape_test_status=='1' ? "selected" : ""); ?> <?php echo set_select('tape_test_status','1');?>>PASS</option>
							<option value="2" <?php echo ($row->tape_test_status=='2' ? "selected" : ""); ?> <?php echo set_select('tape_test_status','2');?>>FAIL</option>
							<option value="0" <?php echo ($row->tape_test_status=='0' ? "selected" : ""); ?> <?php echo set_select('tape_test_status','0');?>>N/A</option>
						</select></td>
					</tr>
		
					<tr>
						<td class="label align-ctr">6.</td>
						<td  class="label align-lft" colspan="2">Odour Test<span class="span-required">*</span></td>
						<td class="label align-ctr"><select name="odour_test_status" required="required">				
							<option value="1" <?php echo ($row->odour_test_status=='1' ? "selected" : ""); ?> <?php echo set_select('odour_test_status','1');?>>PASS</option>
							<option value="2" <?php echo ($row->odour_test_status=='2' ? "selected" : ""); ?> <?php echo set_select('odour_test_status','2');?>>FAIL</option>
							<option value="0" <?php echo ($row->odour_test_status=='0' ? "selected" : ""); ?> <?php echo set_select('odour_test_status','0');?>>N/A</option>
						</select></td>
						<td class="label align-ctr">14.</td>
						<td class="label align-lft" colspan="2">Rub Test<span class="span-required">*</span></td>
						<td class="label align-ctr"><select name="rub_test_status" required="required">				
							<option value="1" <?php echo ($row->rub_test_status=='1' ? "selected" : ""); ?> <?php echo set_select('rub_test_status','1');?>>PASS</option>
							<option value="2" <?php echo ($row->rub_test_status=='2' ? "selected" : ""); ?> <?php echo set_select('rub_test_status','2');?>>FAIL</option>
							<option value="0" <?php echo ($row->rub_test_status=='0' ? "selected" : ""); ?> <?php echo set_select('rub_test_status','0');?>>N/A</option>
						</select></td>
					</tr>
		
					<tr>
						<td class="label align-ctr">7.</td>
						<td  class="label align-lft" colspan="2">Vertically Test<span class="span-required">*</span></td>
						<td class="label align-ctr"><select name="vertically_test_status" required="required">				
							<option value="1" <?php echo ($row->vertically_test_status=='1' ? "selected" : ""); ?> <?php echo set_select('vertically_test_status','1');?>>PASS</option>
							<option value="2" <?php echo ($row->vertically_test_status=='2' ? "selected" : ""); ?> <?php echo set_select('vertically_test_status','2');?>>FAIL</option>
							<option value="0" <?php echo ($row->vertically_test_status=='0' ? "selected" : ""); ?> <?php echo set_select('vertically_test_status','0');?>>N/A</option>
						</select></td>
						<td class="label align-ctr">15.</td>
						<td class="label align-lft" colspan="2">Sealing Test<span class="span-required">*</span></td>
						<td class="label align-ctr"><select name="sealing_test_status" required="required">				
							<option value="1" <?php echo ($row->sealing_test_status=='1' ? "selected" : ""); ?> <?php echo set_select('sealing_test_status','1');?>>PASS</option>
							<option value="2" <?php echo ($row->sealing_test_status=='2' ? "selected" : ""); ?> <?php echo set_select('sealing_test_status','2');?>>>FAIL</option>
							<option value="0" <?php echo ($row->sealing_test_status=='0' ? "selected" : ""); ?> <?php echo set_select('sealing_test_status','0');?>>N/A</option>
						</select></td>
					</tr>
				
					<tr>
						<td class="label align-ctr">8.</td>
						<td  class="label align-lft" colspan="2">Sleeve Colour Difference<span class="span-required">*</span></td>
						<td class="label align-ctr"><select name="sleeve_colour_difference_status" required="required">				
							<option value="1" <?php echo ($row->sleeve_colour_difference_status=='1' ? "selected" : ""); ?> <?php echo set_select('sleeve_colour_difference_status','1');?>>PASS</option>
							<option value="2" <?php echo ($row->sleeve_colour_difference_status=='2' ? "selected" : ""); ?> <?php echo set_select('sleeve_colour_difference_status','2');?>>FAIL</option>
							<option value="0" <?php echo ($row->sleeve_colour_difference_status=='0' ? "selected" : ""); ?> <?php echo set_select('sleeve_colour_difference_status','0');?>>N/A</option>
						</select></td>
						<td class="label align-ctr">16.</td>
						<td class="label align-lft" colspan="2">Bar Code Readable<span class="span-required">*</span></td>
						<td class="label align-ctr"><select name="bar_code_test_status" required>				
							<option value="1" <?php echo ($row->bar_code_test_status=='1' ? "selected" : ""); ?> <?php echo set_select('bar_code_test_status','1');?>>PASS</option>
							<option value="2" <?php echo ($row->bar_code_test_status=='2' ? "selected" : ""); ?> <?php echo set_select('bar_code_test_status','2');?>>FAIL</option>
							<option value="0" <?php echo ($row->bar_code_test_status=='0' ? "selected" : ""); ?> <?php echo set_select('bar_code_test_status','0');?>>N/A</option>
						</select></td>
					</tr>
		
					<tr>
						<td class="label align-lft" colspan="8"><b><span class="span-h">TESTING PARAMETERS: SPRING</span></b></td>
					</tr>
				
					<tr>
						<td class="label align-ctr">17.</td>
						<td  class="label align-lft" colspan="2">Welding Test Side Seam<span class="span-required">*</span></td>
						<td class="label align-ctr"><select name="welding_test_side_seam_status" required>				
							<option value="1" <?php echo ($row->welding_test_side_seam_status=='1' ? "selected" : ""); ?> <?php echo set_select('welding_test_side_seam_status','1');?>>PASS</option>
							<option value="2" <?php echo ($row->welding_test_side_seam_status=='2' ? "selected" : ""); ?> <?php echo set_select('welding_test_side_seam_status','2');?>>FAIL</option>
							<option value="0" <?php echo ($row->welding_test_side_seam_status=='0' ? "selected" : ""); ?> <?php echo set_select('welding_test_side_seam_status','0');?>>N/A</option>
						</select><td>
						<td class="label align-ctr" colspan="4"></td>
					</tr>
					
					<tr>
						<td class="label align-lft bg-parameter" colspan="8"><b><span class="span-h">SAMPLING:</span></b></td>
					</tr>
									
					<tr>
						<td class="label align-lft" colspan="2"><b>Total Number Of Pallets<span class="span-required">*</span></b></td>
						<td class="label align-ctr" colspan=""><input type="text" name="total_number_of_pallets"  Placeholder="Enter Total Number Of Pallet"  value="<?php echo set_value('total_number_of_pallets',$row->total_number_of_pallets);?>" required/></td>
						<td class="label align-lft" colspan=""><b>Sample Per Pallets<span class="span-required">*</span></b></td>
						<td class="label align-ctr" colspan=""><input type="text" name="sample_per_pallets"  Placeholder="Enter Sample Per Pallets" value="<?php echo set_value('sample_per_pallets',$row->sample_per_pallets);?>" required/></td>
						<td  class="label align-lft" colspan=""><b>Number Of Pallets Rechecked<span class="span-required">*</span></b></td>
						<td  class="label align-ctr" colspan="2"><input type="text" name="number_of_pallets_rechecked"  Placeholder="Enter Number Of Pallets Rechecked" value="<?php echo set_value('number_of_pallets_rechecked',$row->number_of_pallets_rechecked);?>" required/></td>
						<td  class="label align-ctr" colspan=""></td>
					</tr>
											
					<tr>
						<td  class="label align-lft" colspan="2"><b>Result<span class="span-required">*</span></b></td>
						<td class="label align-ctr">
							<select name="coa_result_status" required>				
								<option value="1" <?php echo ($row->coa_result_status=='1' ? "selected" : ""); ?> <?php echo set_select('coa_result_status','1');?>>PASS</option>
								<option value="0" <?php echo ($row->coa_result_status=='0' ? "selected" : ""); ?> <?php echo set_select('coa_result_status','0');?>>FAIL</option>
							</select>
						</td>
						
						<!-- <td  class="label align-lft" colspan=""><b>Prepared By<span class="span-required">*</span></b></td>
						<td  class="label align-ctr" colspan=""><input type="text" Placeholder="Enter Prepared Name" name="prepared_name" value="<?php echo set_value('prepared_name',$row->prepared_name);?>" required/></td> -->
						
						<td  class="label align-lft" colspan=""><b>Approved By<span class="span-required">*</span></b></td>
						<td class="label align-ctr" colspan="2">
							<select name="approval_by">
								<option value=''>--Select Authority--</option>
								<?php 
									foreach ($approval_authority as $approval_authority_row) {
									echo "<option value='".$approval_authority_row->employee_id."' ".set_select('approval_authority',$approval_authority_row->employee_id).">".strtoupper($approval_authority_row->username)."</option>";
									}
								?>
							</select>
						</td>
						<td  class="label align-ctr" colspan=""></td>
					</tr>	
			        <?php endforeach;?>		
		            					</table>
				</td>		
			</tr>
		</table>			
	</div>
	<div class="form_design">
		<div class="ui buttons">
	  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui positive button">Update</button>
		</div>
	</div>	
</form>
	
	    