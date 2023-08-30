<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		$("#jobcard_no").autocomplete("<?php echo base_url('index.php/ajax/jobcard_autocomplete');?>", {selectFirst: true});	
		
		$("#jobcard_no").live('keyup',function() {
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/jobcard_no');?>",data: {jobcard_no : $("#jobcard_no").val()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#jobcard_order_details").html(html);
				} 
			});
		});	

		

	});//Jquery closed

</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
		<table class="form_table_design">
			<tr>

				<td width="45%">
					<table class="form_table_inner">

						<tr>
							<td class="label"><b>Date</b><span style="color:red;">*</span> :</td>
							<td><input type="date" name="inspection_date"  size="10" value="<?php echo set_value('inspection_date',date('Y-m-d'));?>" required/></td>
							<td class="label"><b>Shift</b><span style="color:red;">*</span> :</td>
							<td><select name="shift" id="shift" required><option value=''>--Shift--</option>
								<?php if($shift_master==FALSE){
												echo "<option value=''>--Setup Required--</option>";}
									else{
										foreach($shift_master as $shift_master_row){

											echo "<option value='".$shift_master_row->shift_id."'  ".set_select('shift',''.$shift_master_row->shift_id.'').">".$shift_master_row->shift_name."</option>";
										}
								}?></select></td>
						</tr> 

						<tr>
							<td class="label"><b>Machine</b> <span style="color:red;">*</span> :</td>
							<td><select name="machine" id="machine" required><option value=''>--Machine--</option>
							<?php if($coex_machine_master==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach($coex_machine_master as $machine_row){
										echo "<option value='".$machine_row->machine_id."'  ".set_select('machine',''.$machine_row->machine_id.'').">".$machine_row->machine_name."</option>";
									}
							}?>
							</select></td>
							<td class="label"><b>Job Card</b> <span style="color:red;">*</span> :</td>
							<td><input type="text" name="jobcard_no" id="jobcard_no"  size="15" value="<?php echo set_value('jobcard_no');?>" required/>
							</td>
						</tr>

						<tr>
							<td class="label"><b>Order No</b> <span style="color:red;">*</span> :</td>
							<td colspan="3"><span id="jobcard_order_details"><select name="order_no" id="order_no" required><option value=''>--Order No--</option></select>&nbsp;&nbsp;&nbsp;<b>Product No </b> <span style="color:red;">*</span> : &nbsp;&nbsp;&nbsp;<select name="article_no" id="article_no" required><option value=''>--Product No--</option></select></span></td>
						</tr>

						<tr>
							<td class="label" colspan="3">Operator <span style="color:red;">*</span> :</td>
							<td><input type="text" name="operator" size="10" value="<?php echo set_value('operator');?>" required>
						</tr>

						<tr>
							<td class="label" colspan="4"><b>Line Clearance (Y/N)</b></td>
						</tr>
						<tr>
							<td class="label" colspan="3">Master file and Jobcard reteurn to Production dept <span style="color:red;">*</span> :</td>													
							<td><select name="masterfile_jobcard_return_status" required>					
								<option value="1" <?php echo set_select('masterfile_jobcard_return_status','1');?>>YES</option>
								<option value="0" <?php echo set_select('masterfile_jobcard_return_status','0');?>>NO</option>								
							</select></td>
						</tr>
						<tr>
							<td class="label" colspan="3">Remaining Raw material returned to Production area <span style="color:red;">*</span> :</td>													
							<td><select name="rm_return_status" required>					
								<option value="1" <?php echo set_select('rm_return_status','1');?>>YES</option>
								<option value="0" <?php echo set_select('rm_return_status','0');?>>NO</option>								
							</select></td>
						</tr>
						<tr>
							<td class="label" colspan="3">Red create on every machine for Rejected material <span style="color:red;">*</span> :</td>														
							<td><select name="red_create_status" required>					
								<option value="1" <?php echo set_select('red_create_status','1');?>>YES</option>
								<option value="0" <?php echo set_select('red_create_status','0');?>>NO</option>								
							</select></td>
						</tr>
						
						<tr>
							<td class="label" colspan="3">Clear all Rejected Sleeves from the rejection area <span style="color:red;">*</span> :</td>													
							<td><select name="rejected_sleeves_clear_status" required>					
								<option value="1" <?php echo set_select('rejected_sleeves_clear_status','1');?>>YES</option>
								<option value="0" <?php echo set_select('rejected_sleeves_clear_status','0');?>>NO</option>								
							</select></td>
						</tr>
						<tr>
							<td class="label" colspan="3">No Loose Tools <span style="color:red;">*</span> :</td>
							<td><select name="no_loose_tools_status" required>					
								<option value="1" <?php echo set_select('no_loose_tools_status','1');?>>YES</option>
								<option value="0" <?php echo set_select('no_loose_tools_status','0');?>>NO</option>								
							</select></td>
						</tr>
						<tr>
							<td class="label" colspan="3">No Sleeves of Previous Job <span style="color:red;">*</span> :</td>
							<td><select name="no_sleeves_of_previous_job_status" required>					
								<option value="1" <?php echo set_select('no_sleeves_of_previous_job_status','1');?>>YES</option>
								<option value="0" <?php echo set_select('no_sleeves_of_previous_job_status','0');?>>NO</option>								
							</select></td>
						</tr>
						<tr>
							<td class="label" colspan="3">Machine and Surrounding Clean <span style="color:red;">*</span> :</td>
							<td><select name="machine_clean_status" required>					
								<option value="1" <?php echo set_select('machine_clean_status','1');?>>YES</option>
								<option value="0" <?php echo set_select('machine_clean_status','0');?>>NO</option>								
							</select></td>
						</tr>
						<tr>
							<td class="label" colspan="3">Machine ready for Setup <span style="color:red;">*</span> :</td>
							<td><select name="machine_ready_status" required>					
								<option value="1" <?php echo set_select('machine_ready_status','1');?> >YES</option>
								<option value="0" <?php echo set_select('machine_ready_status','0');?>>NO</option>								
							</select></td>
						</tr>
						<tr>
							<td class="label" colspan="3">Finger/Comb is cleaned <span style="color:red;">*</span> :</td>
							<td><select name="finger_comb_status" required>					
								<option value="1" <?php echo set_select('finger_comb_status','1');?> >YES</option>
								<option value="0" <?php echo set_select('finger_comb_status','0');?>>NO</option>								
							</select></td>
						</tr>

						<tr>
							<td class="label" colspan="3">Reason for Setup Approval <span style="color:red;">*</span> :</td>
							<td><div class="ui checkbox"><input type="checkbox" name="new_job_status" value="1"><label>New Job</label></div><br/>
								<div class="ui checkbox"><input type="checkbox" name="power_failure_status" value="1"><label>Power Failure</label></div><br/>
								<div class="ui checkbox"><input type="checkbox" name="change_of_rm_status" value="1"><label>Change of Material</label></div><br/>
								<div class="ui checkbox"><input type="checkbox" name="shift_change_status" value="1"><label>Shift Change</label></div><br/>
								<div class="ui checkbox"><input type="checkbox" name="mould_trial_status" value="1"><label>Mould Trial</label></div><br/>
								<div class="ui checkbox"><input type="checkbox" name="machine_maintainance_status" value="1"><label>Machine Maintainance</label></div><br/>
								</td>
						</tr>
						
						<tr>
							<td class="label" colspan="3">Remarks <span style="color:red;">*</span> :</td>
							<td>
								<textarea name="remark"  value="<?php echo trim(set_value('remark'));?>" maxlength="500" required><?php echo trim(set_value('remark'));?>	
								</textarea>
							</td>
						</tr>

						<tr>
							<td class="label" colspan="3">Status of Inspection <span style="color:red;">*</span> :</td>
							<td><select name="inspection_status" required>					
								<option value="">--Select status--</option>
								<option value="1" <?php echo set_select('inspection_status','1');?> >APPROVED</option>
								<option value="2" <?php echo set_select('inspection_status','2');?> >REJECT</option>
								<option value="0" <?php echo set_select('inspection_status','0');?> >HOLD</option>
								</select>
							</td>
						</tr>

						<tr>
							<td class="label" colspan="3">Inspector <span style="color:red;">*</span> :</td>
							<td><input type="text" name="inspector" size="10" value="<?php echo set_value('inspector');?>" required></td>
						</tr>

						
						

					</table>
			
				</td>
				
				<td>
					<table>
						<tr>
							<td class="label"><b>Parameter</td>
							<td class="label"><b>Dimension</td>
							<td class="label"><b>Actual</td>
							<td class="label"><b>Status</td>
						</tr>

						<tr>
							<td class="label">Standard Dia <span style="color:red;">*</span> :</td>
							<td><table class="form_table_design">
								<tr>
									<td><i>19MM</td>
									<td><i>22MM</td>
									<td><i>25MM</td>
									<td><i>30MM</td>
									<td><i>35MM</td>
									<td><i>40MM</td>
									<td><i>50MM</td>
								</tr>
								</table>
							</td>
							<td><input type="text" name="std_dia_actual" value="<?php echo set_value('dia_actual');?>" size="10" required/></td>
							<td><select name="std_dia_status" required="required">
								<option value="1" <?php echo set_select('std_dia_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('std_dia_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('std_dia_status','0');?>>N/A</option>
							</select></td>
						</tr>

						<tr>
							<td class="label">Outer Dia (MM) +/- 0.1 <span style="color:red;">*</span> :</td>
							<td><table class="form_table_design">
								<tr>
									<td><i>19MM</td>
									<td><i>22MM</td>
									<td><i>25MM</td>
									<td><i>30MM</td>
									<td><i>35MM</td>
									<td><i>40MM</td>
									<td><i>50MM</td>
								</tr>
								</table></td>
							<td><input type="text" name="outer_dia_actual" size="10" value="<?php echo set_value('outer_dia_actual');?>" required/></td>
							<td><select name="outer_dia_status" required="required">
								<option value="1" <?php echo set_select('outer_dia_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('outer_dia_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('outer_dia_status','0');?>>N/A</option>
							</select></td>
						</tr>


						<tr>
							<td class="label">Inner Diameter (MM) +/- 0.1 <span style="color:red;">*</span> :</td>
							<td><table class="form_table_design">
								<tr>
									<td><i>18.4MM</td>
									<td><i>21.2MM</td>
									<td><i>24.1MM</td>
									<td><i>29.2MM</td>
									<td><i>34MM</td>
									<td><i>39MM</td>
									<td><i>49MM</td>
								</tr>
								</table></td>
							<td><input type="text" name="inner_dia_actual" size="10" value="<?php echo set_value('inner_dia_actual');?>" required/></td>
							<td><select name="inner_dia_status" required="required">
								<option value="1" <?php echo set_select('inner_dia_status','1');?> >PASS</option>
								<option value="2" <?php echo set_select('inner_dia_status','2');?> >FAIL</option>
								<option value="0" <?php echo set_select('inner_dia_status','0');?>>N/A</option>
							</select></td>
						</tr>

						<tr>
							<td class="label">Total Wall Thickness (Micron) +/-15 <span style="color:red;">*</span> :</td>
							<td><table class="form_table_design">
								<tr>
									<td><i>400</td>
									<td><i>400</td>
									<td><i>500</td>
									<td><i>500</td>
									<td><i>500</td>
									<td><i>500</td>
									<td><i>550</td>
								</tr>
								</table></td>
							<td ><input type="text" name="total_thickness_actual" size="10" value="<?php echo set_value('total_thickness_actual');?>" required/></td>
							<td>
								<select name="total_thickness_status" required="required">
								<option value="1" <?php echo set_select('total_thickness_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('total_thickness_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('total_thickness_status','0');?>>N/A</option>
								</select>
							</td>
						</tr>

						<tr>
							<td class="label">STD Weight (W) <span style="color:red;">*</span> :</td>
							<td><table class="form_table_design">
								<tr>
									<td><i>1.5</td>
									<td><i>2.2</td>
									<td><i>3.5</td>
									<td><i>3.7</td>
									<td><i>5.3</td>
									<td><i>7.5</td>
									<td><i>9.5</td>
								</tr>
								</table></td>
							<td ><input type="text" name="std_weight_actual" size="10" value="<?php echo set_value('std_weight_actual');?>" required/></td>
							<td>
								<select name="std_weight_status" required="required">
								<option value="1" <?php echo set_select('std_weight_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('std_weight_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('std_weight_status','0');?>>N/A</option>
								</select>
							</td>
						</tr>

						<tr>
							<td class="label">STD Length (L) <span style="color:red;">*</span> :</td>
							<td><table class="form_table_design">
								<tr>
									<td><i>65</td>
									<td><i>85</td>
									<td><i>90</td>
									<td><i>85</td>
									<td><i>100</td>
									<td><i>125</td>
									<td><i>115</td>
								</tr>
								</table></td>
							<td><input type="text" name="std_length_actual" size="10" value="<?php echo set_value('std_length_actual');?>" required/></td>
							<td><select name="std_length_status" required="required">
								<option value="1" <?php echo set_select('std_length_status','1');?> >PASS</option>
								<option value="2" <?php echo set_select('std_length_status','2');?> >FAIL</option>
								<option value="0" <?php echo set_select('std_length_status','0');?>>N/A</option>
							</select></td>
						</tr>

						<tr>
							<td class="label">Outer Layer Micron :</td>
							<td></td>
							<td ><input type="text" name="outer_layer_micron_actual" value="<?php echo set_value('outer_layer_micron_actual');?>" size="10" required/></td>
							<td><select name="outer_layer_micron_status" required="required">							
								<option value="1" <?php echo set_select('outer_layer_micron_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('outer_layer_micron_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('outer_layer_micron_status','0');?>>N/A</option>
								</select>
							</td>
						</tr>

						<tr>
							<td class="label">Inner Layer Micron :</td>
							<td></td>
							<td ><input type="text" name="inner_layer_micron_actual" value="<?php echo set_value('inner_layer_micron_actual');?>" size="10" /></td>
							<td><select name="inner_layer_micron_status">							
								<option value="1" <?php echo set_select('inner_layer_micron_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('inner_layer_micron_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('inner_layer_micron_status','0');?>>N/A</option>
								</select>
							</td>
						</tr>

						<tr>
							<td class="label">Admer :</td>
							<td></td>
							<td ><input type="text" name="admer_layer_one_micron_actual" value="<?php echo set_value('admer_layer_one_micron_actual');?>" size="10" /></td>
							<td><select name="admer_layer_one_micron_status" >					
								<option value="1" <?php echo set_select('admer_layer_one_micron_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('admer_layer_one_micron_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('admer_layer_one_micron_status','0');?>>N/A</option>
							</select></td>
						</tr>

						<tr>
							<td class="label">Evoh :</td>
							<td></td>
							<td ><input type="text" name="evoh_layer_micron_actual" value="<?php echo set_value('evoh_layer_micron_actual');?>" size="10" /></td>
							<td><select name="evoh_layer_micron_status" >					
								<option value="1" <?php echo set_select('evoh_layer_micron_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('evoh_layer_micron_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('evoh_layer_micron_status','0');?>>N/A</option>
							</select></td>
						</tr>

						<tr>
							<td class="label">Admer :</td>
							<td></td>
							<td ><input type="text" name="admer_layer_two_micron_actual" value="<?php echo set_value('admer_layer_two_micron_actual');?>" size="10"/></td>
							<td><select name="admer_layer_two_micron_status">							
								<option value="1" <?php echo set_select('admer_layer_two_micron_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('admer_layer_two_micron_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('admer_layer_two_micron_status','0');?>>N/A</option>
							</select></td>
						</tr>

						<tr>
							<td class="label">Grade & % of Blend <span style="color:red;">*</span> :</td>
							<td>Jobcard & Customer specific</td>
							<td ><input type="text" name="grade_perc_of_blend_actual" size="10" value="<?php echo set_value('grade_perc_of_blend_actual');?>" required/></td>
							<td><select name="grade_perc_of_blend_status" required="required">					
								<option value="1" <?php echo set_select('grade_perc_of_blend_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('grade_perc_of_blend_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('grade_perc_of_blend_status','0');?>>N/A</option>
							</select></td>
						</tr>

						<tr>
							<td class="label">Length of Sleeve <span style="color:red;">*</span> :</td>
							<td>Jobcard & Customer specific</td>
							<td ><input type="text" name="sleeve_length_actual" size="10" value="<?php echo set_value('sleeve_length_actual');?>" required/></td>
							<td><select name="sleeve_length_status" required="required">							
								<option value="1"  <?php echo set_select('sleeve_length_status','1');?>>PASS</option>
								<option value="2"  <?php echo set_select('sleeve_length_status','2');?>>FAIL</option>
								<option value="0"  <?php echo set_select('sleeve_length_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Color Diffrence <span style="color:red;">*</span> :</td>
							<td>DE<3</td>
							<td ><input type="text" name="color_diffrence_actual" size="10" value="<?php echo set_value('color_diffrence_actual');?>" required/></td>
							<td><select name="color_diffrence_status" required="required">					
								<option value="1" <?php echo set_select('color_diffrence_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('color_diffrence_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('color_diffrence_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Opacity <span style="color:red;">*</span> :</td>
							<td>>90%</td>
							<td ><input type="text" name="opacity_actual" size="10" value="<?php echo set_value('opacity_actual');?>" required/></td>
							<td><select name="opacity_status" required="required">							
								<option value="1" <?php echo set_select('opacity_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('opacity_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('opacity_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Cutting Quality <span style="color:red;">*</span> :</td>
							<td>Should be uniform</td>
							<td ><input type="text" name="cutting_quality_actual" size="10" value="<?php echo set_value('cutting_quality_actual');?>" required/></td>
							<td><select name="cutting_quality_status" required="required">							
								<option value="1" <?php echo set_select('cutting_quality_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('cutting_quality_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('cutting_quality_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Die Line <span style="color:red;">*</span> :</td>
							<td>No Die line</td>
							<td><input type="text" name="die_line_actual" size="10" value="<?php echo set_value('die_line_actual');?>" required/></td>
							<td><select name="die_line_status" required="required">							
								<option value="1" <?php echo set_select('die_line_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('die_line_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('die_line_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Scratch Line <span style="color:red;">*</span> :</td>
							<td>No Scratch line</td>
							<td><input type="text" name="scratch_line_actual" size="10" value="<?php echo set_value('scratch_line_actual');?>" required/></td>
							<td><select name="scratch_line_status" required="required">							
								<option value="1" <?php echo set_select('scratch_line_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('scratch_line_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('scratch_line_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Pit/Watermark/Fisheye <span style="color:red;">*</span> :</td>
							<td>No Pit/Watermark</td>
							<td><input type="text" name="pit_watermark_actual" size="10" value="<?php echo set_value('pit_watermark_actual');?>" required/></td>
							<td><select name="pit_watermark_status" required="required">							
								<option value="1" <?php echo set_select('pit_watermark_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('pit_watermark_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('pit_watermark_status','0');?>>N/A</option>
							</select></td>
						</tr>
						
						<tr>
							<td class="label">Contamination <span style="color:red;">*</span> :</td>
							<td>No Contamination</td>
							<td><input type="text" name="contamination_actual" size="10" value="<?php echo set_value('contamination_actual');?>" required/></td>
							<td><select name="contamination_status" required="required">							
								<option value="1" <?php echo set_select('contamination_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('contamination_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('contamination_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Rings Inside & Outside <span style="color:red;">*</span> :</td>
							<td>No Rings Inside & Outside </td>
							<td><input type="text" name="rings_inside_outside_actual" size="10" value="<?php echo set_value('rings_inside_outside_actual');?>" required/></td>
							<td><select name="rings_inside_outside_status">							
								<option value="1" <?php echo set_select('rings_inside_outside_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('rings_inside_outside_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('rings_inside_outside_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Color Dispersion <span style="color:red;">*</span> :</td>
							<td>Should be Uniform</td>
							<td><input type="text" name="color_dispersion_actual" size="10" value="<?php echo set_value('color_dispersion_actual');?>" required/></td>
							<td><select name="color_dispersion_status" required="required">			
								<option value="1" <?php echo set_select('color_dispersion_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('color_dispersion_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('color_dispersion_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Oval Tube <span style="color:red;">*</span> :</td>
							<td>No Oval</td>
							<td><input type="text" name="oval_tube_actual" size="10" value="<?php echo set_value('oval_tube_actual');?>" required/></td>
							<td><select name="oval_tube_status" required="required">				
								<option value="1" <?php echo set_select('oval_tube_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('oval_tube_status','1');?>>FAIL</option>
								<option value="0" <?php echo set_select('oval_tube_status','1');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Masterbatch Color & % <span style="color:red;">*</span> :</td>
							<td>Jobcard & Customer specific</td>
							<td><input type="text" name="mb_color_perc_actual" size="10" value="<?php echo set_value('mb_color_perc_actual');?>" required/></td>
							<td><select name="mb_color_perc_status" required="required">							
								<option value="1" <?php echo set_select('mb_color_perc_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('mb_color_perc_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('mb_color_perc_status','0');?>>N/A</option>
							</select></td>
						</tr>					


					</table>


				</td>
							
			</tr>

		</table>
					
	</div>
	
				


	<div class="form_design">
		<div class="ui buttons">
	  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui positive button">Save</button>
		</div>
	</div>

	
</form>




				
				
				
			