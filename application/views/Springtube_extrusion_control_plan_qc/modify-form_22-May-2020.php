<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		$("#jobcard_no").autocomplete("<?php echo base_url('index.php/ajax_springtube/jobcard_extrusion_autocomplete');?>", {selectFirst: true});	
				


	});//Jquery closed

</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
		<?php foreach ($springtube_extrusion_control_plan_qc as $row):?>
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">

						<tr>
							<td class="label">Inspection Date <span style="color:red;">*</span> :</td>
							<td><input type="hidden" name="cp_id" value="<?php echo $row->cp_id;?>" readonly>
								<input type="date" name="inspection_date"   value="<?php echo set_value('inspection_date',$row->inspection_date);?>" readonly /></td>
							
						</tr>
						<tr>
							<td class="label">Machine <span style="color:red;">*</span> :</td>
							<td><select name="machine" id="machine" readonly><option value=''>----Select Machine-----</option>
							<?php if($springtube_machine_master==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach($springtube_machine_master as $machine_row){
										$selected=($machine_row->machine_id==1?'selected':'');
										echo "<option value='".$machine_row->machine_id."'  ".set_select('machine',''.$machine_row->machine_id.'').$selected.">".$machine_row->machine_name."</option>";
									}
							}?>
							</select></td>
						</tr>
						<tr>	
							<td class="label">Jobcard No. :</td>
							<td>
								<input type="text" name="jobcard_no" id="jobcard_no"  size="20" value="<?php echo set_value('jobcard_no',$row->jobcard_no);?>" required/>
							</td>
							
						</tr>
						<!--<tr>
							<td class="label">Dia <span style="color:red;">*</span> :</td>
							<td><select name="sleeve_dia" id="sleeve_dia" required><option value=''>--Select Dia--</option>
								<?php   if($sleeve_dia==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
										else{
												foreach($sleeve_dia as $sleeve_dia_row){
													if($sleeve_dia_row->sleeve_id=='5'|| $sleeve_dia_row->sleeve_id=='6'||$sleeve_dia_row->sleeve_id=='7'){
														echo "<option value='".$sleeve_dia_row->sleeve_diameter."//".$sleeve_dia_row->sleeve_id."'  ".set_select('sleeve_dia',''.$sleeve_dia_row->sleeve_diameter.'//'.$sleeve_dia_row->sleeve_id.'').">".$sleeve_dia_row->sleeve_diameter."</option>";
													}
												}
										}?>
									</select>&nbsp;
							</td>
							<td class="label"> Length <span style="color:red;">*</span> :</td>
							<td> <input type="number" name="sleeve_length" min="85"  max="200" step="0.1"  id="sleeve_length" size="5" maxlength="6" value="<?php echo set_value('sleeve_length');?>" required>
							</td>
						</tr>
					
						<tr>

							<td class="label">Customer * :</td>
							<td colspan="3"><input type="text" name="customer" id="customer"  size="60" value="<?php echo set_value('customer');?>" required/></td>
						</tr>
						
						
						<tr>
							<td class="label">Product * :</td>
							<td colspan="3"><input type="text" name="article_no" id="article_no"  size="60" value="<?php echo set_value('article_no');?>"readonly/></td>
						</tr>
					-->		
						<tr>
							<td class="label">Operator  :</td>
							<td colspan="3"><input type="text" name="operator" id="operator"  size="20" value="<?php echo set_value('operator',$row->operator);?>" required/></td>
						</tr>		
						<tr>
							<td class="label" colspan="4"><b>LINE CLEARANCE (Y/N)</b></td>
						</tr>
						<tr>
							<td class="label" colspan="3">Master file and Jobcard reteurn to Production dept :</td>													
							<td><select name="masterfile_jobcard_return_status">					
								<option value="1" <?php echo($row->masterfile_jobcard_return_status=='1'?"selected":"")?> <?php echo set_select('masterfile_jobcard_return_status','1');?>>YES</option>
								<option value="0" <?php echo($row->masterfile_jobcard_return_status=='0'?"selected":"")?> <?php echo set_select('masterfile_jobcard_return_status','0');?>>NO</option>								
							</select></td>
						</tr>
						<tr>
							<td class="label" colspan="3">Remaining Raw material returned to Production area :</td>													
							<td><select name="rm_return_status">					
								<option value="1" <?php echo($row->rm_return_status=='1'? "selected":"")?> <?php echo set_select('rm_return_status','1');?>>YES</option>
								<option value="0" <?php echo($row->rm_return_status=='0'?"selected":"")?> <?php echo set_select('rm_return_status','0');?>>NO</option>								
							</select></td>
						</tr>
						<tr>
							<td class="label" colspan="3">Red create on every machine for Rejected material :</td>														
							<td><select name="red_create_status">					
								<option value="1" <?php echo($row->red_create_status=='1'?"selected":"")?> <?php echo set_select('red_create_status','1');?>>YES</option>
								<option value="0" <?php echo($row->red_create_status=='0'?"selected":"")?> <?php echo set_select('red_create_status','0');?>>NO</option>								
							</select></td>
						</tr>
						
						<tr>
							<td class="label" colspan="3">Clear all Rejected Rolls from the rejection area :</td>													
							<td><select name="rejected_rolls_clear_status">					
								<option value="1"  <?php echo($row->rejected_rolls_clear_status=='1'?"selected":"")?> <?php echo set_select('rejected_rolls_clear_status','1');?>>YES</option>
								<option value="0"  <?php echo($row->rejected_rolls_clear_status=='0'?"selected":"")?> <?php echo set_select('rejected_rolls_clear_status','0');?>>NO</option>								
							</select></td>
						</tr>
						<tr>
							<td class="label" colspan="3">No Loose Tools :</td>
							<td><select name="no_loose_tools_status">					
								<option value="1" <?php echo($row->no_loose_tools_status=='1'?"selected":"")?>  <?php echo set_select('no_loose_tools_status','1');?>>YES</option>
								<option value="0" <?php echo($row->no_loose_tools_status=='0'?"selected":"")?>  <?php echo set_select('no_loose_tools_status','0');?>>NO</option>								
							</select></td>
						</tr>
						<tr>
							<td class="label" colspan="3">Machine and Surrounding Clean :</td>
							<td><select name="machine_cleane_status">					
								<option value="1" <?php echo($row->machine_cleane_status=='1'?"selected":"")?> <?php echo set_select('machine_cleane_status','1');?>>YES</option>
								<option value="0" <?php echo($row->machine_cleane_status=='0'?"selected":"")?> <?php echo set_select('machine_cleane_status','0');?>>NO</option>								
							</select></td>
						</tr>
						<tr>
							<td class="label" colspan="3">Machine ready for Setup :</td>
							<td><select name="machine_ready_status">					
								<option value="1" <?php echo($row->machine_ready_status=='0'?"selected":"")?> <?php echo set_select('machine_ready_status','1');?> >YES</option>
								<option value="0" <?php echo($row->machine_ready_status=='0'?"selected":"")?> <?php echo set_select('machine_ready_status','0');?>>NO</option>								
							</select></td>
						</tr>
						<tr>
							<td class="label" colspan="3">Finger/Comb is cleaned :</td>
							<td><select name="finger_comb_status">					
								<option value="1" <?php echo( $row->finger_comb_status=='1'?"selected":"")?>  <?php echo set_select('finger_comb_status','1');?> >YES</option>
								<option value="0"  <?php echo($row->finger_comb_status=='0'?"selected":"")?> <?php echo set_select('finger_comb_status','0');?>>NO</option>								
							</select></td>
						</tr>

						
						<tr>
							<td class="label" colspan="4"><b>REASONS FOR SETUP APPROVAL</b></td>
						</tr>

						<tr>
							<td class="label" colspan="3">New Job/Power Failure/Change of Material:</td>
							<td><select name="new_job">					
								<option value="1" <?php echo($row->new_job=='1'?"selected":"")?> <?php echo set_select('new_job','1');?>>YES</option>
								<option value="0" <?php echo($row->new_job=='0'?"selected":"")?> <?php echo set_select('new_job','0');?>>NO</option>								
							</select>
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">Shift Change/Trial/Machine after maintenance:</td>
							<td><select name="shift_change">					
								<option value="1" <?php echo($row->shift_change=='1'?"selected":"")?>  <?php echo set_select('shift_change','1');?>>YES</option>
								<option value="0" <?php echo($row->shift_change=='0'?"selected":"")?> <?php echo set_select('shift_change','0');?>>NO</option>								
							</select>
							</td>
						</tr>

						<tr>
							<td class="label">Remarks :</td>
							<td colspan="3">
								<textarea name="qc_remarks" id="qc_remarks" cols="40" rows="3" value="<?php echo trim(set_value('qc_remarks',$row->qc_remarks));?>" maxlength="500"><?php echo trim(set_value('qc_remarks',$row->qc_remarks));?>	
								</textarea>
							</td>
						</tr>
						<tr>
							<td class="label" colspan="4"><b>APPROVALS</b></td>
						</tr>
						<tr>
							<td class="label" colspan="3">Status of Inspection:</td>
							<td><select name="qc_inspection_status">					
								<option value="">--Select status--</option>
								<option value="1" <?php echo($row->qc_inspection_status==1?"selected":"");?> <?php echo set_select('qc_inspection_status','1');?> >APPROVED</option>
								<option value="2" <?php echo($row->qc_inspection_status==2?"selected":"");?> <?php echo set_select('qc_inspection_status','2');?> >REJECT</option>
								<option value="0" <?php echo($row->qc_inspection_status==0?"selected":"");?> <?php echo set_select('qc_inspection_status','0');?> >HOLD</option>								
							</select>
							</td>
						</tr>
						

					</table>
			
				</td>
				<td>
					<table>						


						<tr>
							<th class="label">Parameter </th>
							<th class="label">Standards </th>
							<th class="label">Actual</th>
							<th class="label">Status Pass/Fail</th>
						</tr>
						<tr>
							<td class="label">Width (MM)+/-2 :</td>
							<td><input type="text" name="width_std"  value="<?php echo set_value('width_std',$row->width_std);?>" required /></td>
							<td ><input type="text" name="width_actual" value="<?php echo set_value('width_actual',$row->width_actual);?>" required/></td>
							<td><select name="width_status" required>
								
								<option value="1" <?php echo($row->width_status=='1'?"selected":"");?>  <?php echo set_select('width_status','1');?> >PASS</option>
								<option value="2" <?php echo($row->width_status=='2'?"selected":"");?> <?php echo set_select('width_status','2');?> >FAIL</option>
								<option value="0" <?php echo($row->width_status=='0'?"selected":"");?> <?php echo set_select('width_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Thickness (MM)+/-12 :</td>
							<td><input type="text" name="thickness_std" value="<?php echo set_value('thickness_std',$row->thickness_std);?>" required /></td>
							<td ><input type="text" name="thickness_actual" value="<?php echo set_value('thickness_actual',$row->thickness_actual);?>" required/></td>
							<td>
								<select name="thickness_status" required>
								<option value="1" <?php echo($row->thickness_status=='1'?"selected":"");?> <?php echo set_select('thickness_status','1');?>>PASS</option>
								<option value="2" <?php echo($row->thickness_status=='2'?"selected":"");?> <?php echo set_select('thickness_status','2');?>>FAIL</option>
								<option value="0" <?php echo($row->thickness_status=='0'?"selected":"");?> <?php echo set_select('thickness_status','0');?>>N/A</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="label">Roll Length (MM)+/-10 :</td>
							<td><input type="text" name="reel_length_std"  value="<?php echo set_value('reel_length_std',$row->reel_length_std);?>" required /></td>
							<td ><input type="text" name="reel_length_actual" value="<?php echo set_value('reel_length_actual',$row->reel_length_actual);?>" required/></td>
							<td><select name="reel_length_status" required>							
								<option value="1" <?php echo($row->reel_length_status=='1'?"selected":"");?> <?php echo set_select('reel_length_status','1');?>>PASS</option>
								<option value="2" <?php echo($row->reel_length_status=='2'?"selected":"");?> <?php echo set_select('reel_length_status','2');?>>FAIL</option>
								<option value="0" <?php echo($row->reel_length_status=='0'?"selected":"");?> <?php echo set_select('reel_length_status','0');?>>N/A</option>
								</select>
							</td>
						</tr>						
						<tr>
							<td class="label" colspan="4"><b> MULTYLAYER- 7 LAYER</b></td>
						</tr>
						<tr>
							<td class="label">First Layer Micron :</td>
							<td><input type="text" name="first_layer_micron_std"   value="<?php echo set_value('first_layer_micron_std',$row->first_layer_micron_std);?>" required /></td>
							<td ><input type="text" name="first_layer_micron_actual" value="<?php echo set_value('first_layer_micron_actual',$row->first_layer_micron_actual);?>" required/></td>
							<td><select name="first_layer_micron_status" required>							
								<option value="1" <?php echo($row->first_layer_micron_status=='1'?"selected":"");?> <?php echo set_select('first_layer_micron_status','1');?>>PASS</option>
								<option value="2" <?php echo($row->first_layer_micron_status=='2'?"selected":"");?> <?php echo set_select('first_layer_micron_status','2');?>>FAIL</option>
								<option value="0" <?php echo($row->first_layer_micron_status=='0'?"selected":"");?> <?php echo set_select('first_layer_micron_status','0');?>>N/A</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="label">Second Layer Micron :</td>
							<td><input type="text" name="second_layer_micron_std"   value="<?php echo set_value('second_layer_micron_std',$row->second_layer_micron_std);?>" required /></td>
							<td ><input type="text" name="second_layer_micron_actual" value="<?php echo set_value('second_layer_micron_actual',$row->second_layer_micron_actual);?>" required/></td>
							<td><select name="second_layer_micron_status" required>							
								<option value="1" <?php echo($row->second_layer_micron_status=='1'?"selected":"");?> <?php echo set_select('second_layer_micron_status','1');?>>PASS</option>
								<option value="2" <?php echo($row->second_layer_micron_status=='2'?"selected":"");?> <?php echo set_select('second_layer_micron_status','2');?>>FAIL</option>
								<option value="0" <?php echo($row->second_layer_micron_status=='0'?"selected":"");?> <?php echo set_select('second_layer_micron_status','0');?>>N/A</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="label">Third Layer Micron :</td>
							<td><input type="text" name="third_layer_micron_std"   value="<?php echo set_value('third_layer_micron_std',$row->third_layer_micron_std);?>" required /></td>
							<td ><input type="text" name="third_layer_micron_actual" value="<?php echo set_value('third_layer_micron_actual',$row->third_layer_micron_actual);?>" required/></td>
							<td><select name="third_layer_micron_status" required>					
								<option value="1" <?php echo($row->third_layer_micron_status=='1'?"selected":"");?> <?php echo set_select('third_layer_micron_status','1');?>>PASS</option>
								<option value="2" <?php echo($row->third_layer_micron_status=='2'?"selected":"");?> <?php echo set_select('third_layer_micron_status','2');?>>FAIL</option>
								<option value="0" <?php echo($row->third_layer_micron_status=='0'?"selected":"");?> <?php echo set_select('third_layer_micron_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Four Layer Micron :</td>
							<td><input type="text" name="fourth_layer_micron_std"   value="<?php echo set_value('fourth_layer_micron_std',$row->fourth_layer_micron_std);?>" required /></td>
							<td ><input type="text" name="fourth_layer_micron_actual" value="<?php echo set_value('fourth_layer_micron_actual',$row->fourth_layer_micron_actual);?>" required/></td>
							<td><select name="fourth_layer_micron_status" required>					
								<option value="1" <?php echo($row->fourth_layer_micron_status=='1'?"selected":"");?> <?php echo set_select('fourth_layer_micron_status','1');?>>PASS</option>
								<option value="2" <?php echo($row->fourth_layer_micron_status=='2'?"selected":"");?> <?php echo set_select('fourth_layer_micron_status','2');?>>FAIL</option>
								<option value="0" <?php echo($row->fourth_layer_micron_status=='0'?"selected":"");?> <?php echo set_select('fourth_layer_micron_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Fifth Layer Micron :</td>
							<td><input type="text" name="fifth_layer_micron_std"   value="<?php echo set_value('fifth_layer_micron_std',$row->fifth_layer_micron_std);?>" required/></td>
							<td ><input type="text" name="fifth_layer_micron_actual" value="<?php echo set_value('fifth_layer_micron_actual',$row->fifth_layer_micron_actual);?>" required/></td>
							<td><select name="fifth_layer_micron_status" required>							
								<option value="1" <?php echo($row->fifth_layer_micron_status=='1'?"selected":"");?> <?php echo set_select('fifth_layer_micron_status','1');?>>PASS</option>
								<option value="2" <?php echo($row->fifth_layer_micron_status=='2'?"selected":"");?> <?php echo set_select('fifth_layer_micron_status','2');?>>FAIL</option>
								<option value="0" <?php echo($row->fifth_layer_micron_status=='0'?"selected":"");?> <?php echo set_select('fifth_layer_micron_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Sixth Layer Micron :</td>
							<td><input type="text" name="sixth_layer_micron_std"   value="<?php echo set_value('sixth_layer_micron_std',$row->sixth_layer_micron_std);?>" required/></td>
							<td ><input type="text" name="sixth_layer_micron_actual" value="<?php echo set_value('sixth_layer_micron_actual',$row->sixth_layer_micron_actual);?>" required/></td>
							<td><select name="sixth_layer_micron_status" required>							
								<option value="1" <?php echo($row->sixth_layer_micron_status=='1'?"selected":"");?> <?php echo set_select('sixth_layer_micron_status','1');?>>PASS</option>
								<option value="2" <?php echo($row->sixth_layer_micron_status=='2'?"selected":"");?> <?php echo set_select('sixth_layer_micron_status','2');?>>FAIL</option>
								<option value="0" <?php echo($row->sixth_layer_micron_status=='0'?"selected":"");?> <?php echo set_select('sixth_layer_micron_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Seventh Layer Micron :</td>
							<td><input type="text" name="seventh_layer_micron_std"  value="<?php echo set_value('seventh_layer_micron_std',$row->seventh_layer_micron_std);?>" required /></td>
							<td ><input type="text" name="seventh_layer_micron_actual" value="<?php echo set_value('seventh_layer_micron_actual',$row->seventh_layer_micron_actual);?>" required/></td>
							<td><select name="seventh_layer_micron_status" required>							
								<option value="1" <?php echo($row->seventh_layer_micron_status=='1'?"selected":"");?> <?php echo set_select('seventh_layer_micron_status','1');?> >PASS</option>
								<option value="2" <?php echo($row->seventh_layer_micron_status=='2'?"selected":"");?> <?php echo set_select('seventh_layer_micron_status','2');?>>FAIL</option>
								<option value="0" <?php echo($row->seventh_layer_micron_status=='0'?"selected":"");?> <?php echo set_select('seventh_layer_micron_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Grade & % of Bland :</td>
							<td>Jobcard & Customer specific</td>
							<td ><input type="text" name="grade_perc_of_bland" value="<?php echo set_value('grade_perc_of_bland',$row->grade_perc_of_bland);?>" required/></td>
							<td><select name="grade_perc_of_bland_status" required>					
								<option value="1" <?php echo($row->grade_perc_of_bland_status=='1'?"selected":"");?> <?php echo set_select('grade_perc_of_bland_status','1');?>>PASS</option>
								<option value="2" <?php echo($row->grade_perc_of_bland_status=='2'?"selected":"");?> <?php echo set_select('grade_perc_of_bland_status','2');?>>FAIL</option>
								<option value="0"  <?php echo($row->grade_perc_of_bland_status=='0'?"selected":"");?> <?php echo set_select('grade_perc_of_bland_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Color of Roll :</td>
							<td>Jobcard & Customer specific</td>
							<td ><input type="text" name="roll_color" value="<?php echo set_value('roll_color',$row->roll_color);?>" required/></td>
							<td><select name="roll_color_status" required>							
								<option value="1" <?php echo($row->roll_color_status=='1'?"selected":"");?>  <?php echo set_select('roll_color_status','1');?>>PASS</option>
								<option value="2" <?php echo($row->roll_color_status=='2'?"selected":"");?>  <?php echo set_select('roll_color_status','2');?>>FAIL</option>
								<option value="0"  <?php echo($row->roll_color_status=='0'?"selected":"");?> <?php echo set_select('roll_color_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Color Diffrence :</td>
							<td>DE<3</td>
							<td ><input type="text" name="color_diffrence" value="<?php echo set_value('color_diffrence',$row->color_diffrence);?>" required/></td>
							<td><select name="color_diffrence_status" required="required">					
								<option value="1"  <?php echo($row->color_diffrence_status=='1'?"selected":"");?> <?php echo set_select('color_diffrence_status','1');?>>PASS</option>
								<option value="2" <?php echo($row->color_diffrence_status=='2'?"selected":"");?>  <?php echo set_select('color_diffrence_status','2');?>>FAIL</option>
								<option value="0" <?php echo($row->color_diffrence_status=='0'?"selected":"");?> <?php echo set_select('color_diffrence_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Opacity :</td>
							<td>>90%</td>
							<td ><input type="text" name="opacity" value="<?php echo set_value('opacity',$row->opacity);?>" required/></td>
							<td><select name="opacity_status" required>							
								<option value="1" <?php echo($row->opacity_status=='1'?"selected":"");?> <?php echo set_select('opacity_status','1');?> >PASS</option>
								<option value="2" <?php echo($row->opacity_status=='2'?"selected":"");?> <?php echo set_select('opacity_status','2');?>>FAIL</option>
								<option value="0" <?php echo($row->opacity_status=='0'?"selected":"");?> <?php echo set_select('opacity_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Winding Of Roll :</td>
							<td>Should be uniform</td>
							<td ><input type="text" name="roll_winding" value="<?php echo set_value('roll_winding',$row->roll_winding);?>" required/></td>
							<td><select name="roll_winding_status" required>							
								<option value="1" <?php echo($row->roll_winding_status=='1'?"selected":"");?>  <?php echo set_select('roll_winding_status','1');?>>PASS</option>
								<option value="2" <?php echo($row->roll_winding_status=='2'?"selected":"");?> <?php echo set_select('roll_winding_status','2');?>>FAIL</option>
								<option value="0" <?php echo($row->roll_winding_status=='0'?"selected":"");?> <?php echo set_select('roll_winding_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Die Line :</td>
							<td>No Die line</td>
							<td><input type="text" name="die_line" value="<?php echo set_value('die_line',$row->die_line);?>" required/></td>
							<td><select name="die_line_status">							
								<option value="1" <?php echo($row->die_line_status=='1'?"selected":"");?> <?php echo set_select('die_line_status','1');?>>PASS</option>
								<option value="2" <?php echo($row->die_line_status=='2'?"selected":"");?> <?php echo set_select('die_line_status','2');?>>FAIL</option>
								<option value="0" <?php echo($row->die_line_status=='0'?"selected":"");?> <?php echo set_select('die_line_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Scratch Line :</td>
							<td>No Scratch line</td>
							<td><input type="text" name="scratch_line" value="<?php echo set_value('scratch_line',$row->scratch_line);?>" required/></td>
							<td><select name="scratch_line_status" required="required">							
								<option value="1" <?php echo($row->scratch_line_status=='1'?"selected":"");?> <?php echo set_select('scratch_line_status','1');?>>PASS</option>
								<option value="2"  <?php echo($row->scratch_line_status=='2'?"selected":"");?><?php echo set_select('scratch_line_status','2');?>>FAIL</option>
								<option value="0"  <?php echo($row->scratch_line_status=='0'?"selected":"");?><?php echo set_select('scratch_line_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Pit/Watermark/Fisheye :</td>
							<td>No Pit/Watermark</td>
							<td><input type="text" name="pit_watermark" value="<?php echo set_value('pit_watermark',$row->pit_watermark);?>" required/></td>
							<td><select name="pit_watermark_status">							
								<option value="1" <?php echo($row->pit_watermark=='1'?"selected":"");?> <?php echo set_select('pit_watermark_status','1');?>>PASS</option>
								<option value="2"  <?php echo($row->pit_watermark=='2'?"selected":"");?><?php echo set_select('pit_watermark_status','2');?>>FAIL</option>
								<option value="0" <?php echo($row->pit_watermark=='0'?"selected":"");?> <?php echo set_select('pit_watermark_status','0');?>>N/A</option>
							</select></td>
						</tr>
						
						<tr>
							<td class="label">Contamination :</td>
							<td>No Contamination</td>
							<td><input type="text" name="contamination" value="<?php echo set_value('contamination',$row->contamination);?>" required/></td>
							<td><select name="contamination_status" required="required">							
								<option value="1" <?php echo($row->contamination_status=='1'?"selected":"");?> <?php echo set_select('contamination_status','1');?>>PASS</option>
								<option value="2" <?php echo($row->contamination_status=='2'?"selected":"");?> <?php echo set_select('contamination_status','2');?>>FAIL</option>
								<option value="0"  <?php echo($row->contamination_status=='0'?"selected":"");?><?php echo set_select('contamination_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Humps on Roll :</td>
							<td>No Humps surface should be even</td>
							<td><input type="text" name="roll_humps" value="<?php echo set_value('roll_humps',$row->roll_humps);?>" required/></td>
							<td><select name="roll_humps_status">							
								<option value="1" <?php echo($row->roll_humps_status=='1'?"selected":"");?> <?php echo set_select('roll_humps_status','1');?>>PASS</option>
								<option value="2" <?php echo($row->roll_humps_status=='2'?"selected":"");?> <?php echo set_select('roll_humps_status','2');?>>FAIL</option>
								<option value="0" <?php echo($row->roll_humps_status=='0'?"selected":"");?> <?php echo set_select('roll_humps_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Color Dispersion :</td>
							<td>Should be Uniform</td>
							<td><input type="text" name="color_dispersion" value="<?php echo set_value('color_dispersion',$row->color_dispersion);?>" required/></td>
							<td><select name="color_dispersion_status" required="required">			
								<option value="1" <?php echo($row->color_dispersion_status=='1'?"selected":"");?> <?php echo set_select('color_diffrence_status','1');?>>PASS</option>
								<option value="2" <?php echo($row->color_dispersion_status=='2'?"selected":"");?> <?php echo set_select('color_diffrence_status','2');?>>FAIL</option>
								<option value="0" <?php echo($row->color_dispersion_status=='0'?"selected":"");?> <?php echo set_select('color_diffrence_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">COF-SF/DF :</td>
							<td></td>
							<td><input type="text" name="cof_sf_df" value="<?php echo set_value('cof_sf_df',$row->cof_sf_df);?>" required/></td>
							<td><select name="cof_sf_df_status" required="required">				
								<option value="1" <?php echo($row->cof_sf_df_status=='1'?"selected":"");?> <?php echo set_select('cof_sf_df_status','1');?>>PASS</option>
								<option value="2" <?php echo($row->cof_sf_df_status=='1'?"selected":"");?> <?php echo set_select('cof_sf_df_status','1');?>>FAIL</option>
								<option value="0" <?php echo($row->cof_sf_df_status=='0'?"selected":"");?> <?php echo set_select('cof_sf_df_status','1');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Masterbatch Color & % :</td>
							<td>Jobcard & Customer specific</td>
							<td><input type="text" name="mb_color_perc" value="<?php echo set_value('mb_color_perc',$row->mb_color_perc);?>" required/></td>
							<td><select name="mb_color_perc_status" required="required">							
								<option value="1" <?php echo($row->mb_color_perc_status=='1'?"selected":"");?> <?php echo set_select('mb_color_perc_status','1');?>>PASS</option>
								<option value="2" <?php echo($row->mb_color_perc_status=='2'?"selected":"");?> <?php echo set_select('mb_color_perc_status','2');?>>FAIL</option>
								<option value="0" <?php echo($row->mb_color_perc_status=='0'?"selected":"");?> <?php echo set_select('mb_color_perc_status','0');?>>N/A</option>
							</select></td>
						</tr>					


					</table>


				</td>
							
			</tr>

		</table>
					
	</div>
	
				
<?php endforeach; ?>

	<div class="form_design">
		<div class="ui buttons">
	  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui positive button">Update</button>
		</div>
	</div>

	
</form>




				
				
				
			