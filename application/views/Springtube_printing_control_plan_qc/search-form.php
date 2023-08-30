<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		$("#jobcard_no").autocomplete("<?php echo base_url('index.php/ajax_springtube/jobcard_printing_autocomplete');?>", {selectFirst: true});	
				


	});//Jquery closed

</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">

						<tr>
							<td class="label">From Date <span style="color:red;">*</span>  :</td>
							<td><input type="date" name="from_date" id="from_date" size="30" value="<?php echo set_value('from_date',date('Y-m-d'));?>" ></td>
							<td class="label">To Date <span style="color:red;">*</span>  :</td>
							<td><input type="date" name="to_date" id="to_date" size="30" value="<?php echo set_value('to_date',date('Y-m-d'));?>" ></td>
						</tr>
						<tr>
							<td class="label">Machine <span style="color:red;">*</span> :</td>
							<td><select name="machine" id="machine" readonly><option value=''>----Select Machine-----</option>
							<?php if($springtube_machine_master==FALSE){
											echo "<option value=''>--Setup --</option>";}
								else{
									foreach($springtube_machine_master as $machine_row){
										$selected=($machine_row->machine_id==1?'selected':'');
										echo "<option value='".$machine_row->machine_id."'  ".set_select('machine',''.$machine_row->machine_id.'').$selected.">".$machine_row->machine_name."</option>";
									}
							}?>
							</select></td>
							<td class="label">Jobcard No. :</td>
							<td>
								<input type="text" name="jobcard_no" id="jobcard_no"  size="20" value="<?php echo set_value('jobcard_no');?>" />
							</td>
						</tr>						
							
						<tr>
							<td class="label">Operator  :</td>
							<td ><input type="text" name="operator" id="operator"  size="20" value="<?php echo set_value('operator');?>" /></td>
							<td class="label">Status of Inspection:</td>
							<td><select name="qc_inspection_status">					
								<option value="">--Select status--</option>
								<option value="1" <?php echo set_select('qc_inspection_status','1');?> >APPROVED</option>
								<option value="2" <?php echo set_select('qc_inspection_status','2');?> >REJECT</option>
								<option value="0" <?php echo set_select('qc_inspection_status','0');?> >HOLD</option>								
							</select>
							</td>
						</tr>

						<tr>
						<td class="label">Created By :</td>
						<td><select name="user_id" id="user_id">
							<option value=''>--Select User--</option>
							<?php 
							foreach ($user_master as $user_master_row) {
			             echo "<option value='".$user_master_row->user_id."' ".set_select('user_id',$user_master_row->user_id).">".strtoupper($user_master_row->login_name)."</option>";
			             }
			             ?>
			            </select></td>
						</tr>		
				<!--<tr>
							<td class="label" colspan="4"><b>LINE CLEARANCE (Y/N)</b></td>
						</tr>
						<tr>
							<td class="label" colspan="3">Master file and Jobcard reteurn to Production dept :</td>													
							<td><select name="masterfile_jobcard_return_status">					
								<option value="1" <?php echo set_select('masterfile_jobcard_return_status','1');?>>YES</option>
								<option value="0" <?php echo set_select('masterfile_jobcard_return_status','0');?>>NO</option>								
							</select></td>
						</tr>
						<tr>
							<td class="label" colspan="3">Remaining Raw material returned to Production area :</td>													
							<td><select name="rm_return_status">					
								<option value="1" <?php echo set_select('rm_return_status','1');?>>YES</option>
								<option value="0" <?php echo set_select('rm_return_status','0');?>>NO</option>								
							</select></td>
						</tr>
						<tr>
							<td class="label" colspan="3">Red create on every machine for Rejected material :</td>														
							<td><select name="red_create_status">					
								<option value="1" <?php echo set_select('red_create_status','1');?>>YES</option>
								<option value="0" <?php echo set_select('red_create_status','0');?>>NO</option>								
							</select></td>
						</tr>
						
						<tr>
							<td class="label" colspan="3">Clear all Rejected Rolls from the rejection area :</td>													
							<td><select name="rejected_rolls_clear_status">					
								<option value="1" <?php echo set_select('rejected_rolls_clear_status','1');?>>YES</option>
								<option value="0" <?php echo set_select('rejected_rolls_clear_status','0');?>>NO</option>								
							</select></td>
						</tr>
						<tr>
							<td class="label" colspan="3">No Loose Tools :</td>
							<td><select name="no_loose_tools_status">					
								<option value="1" <?php echo set_select('no_loose_tools_status','1');?>>YES</option>
								<option value="0" <?php echo set_select('no_loose_tools_status','0');?>>NO</option>								
							</select></td>
						</tr>
						<tr>
							<td class="label" colspan="3">Machine and Surrounding Clean :</td>
							<td><select name="machine_cleane_status">					
								<option value="1" <?php echo set_select('machine_cleane_status','1');?>>YES</option>
								<option value="0" <?php echo set_select('machine_cleane_status','0');?>>NO</option>								
							</select></td>
						</tr>
						<tr>
							<td class="label" colspan="3">Machine ready for Setup :</td>
							<td><select name="machine_ready_status">					
								<option value="1" <?php echo set_select('machine_ready_status','1');?> >YES</option>
								<option value="0" <?php echo set_select('machine_ready_status','0');?>>NO</option>								
							</select></td>
						</tr>
						<tr>
							<td class="label" colspan="3">Finger/Comb is cleaned :</td>
							<td><select name="finger_comb_status">					
								<option value="1" <?php echo set_select('finger_comb_status','1');?> >YES</option>
								<option value="0" <?php echo set_select('finger_comb_status','0');?>>NO</option>								
							</select></td>
						</tr>

						
						<tr>
							<td class="label" colspan="4"><b>REASONS FOR SETUP APPROVAL</b></td>
						</tr>

						<tr>
							<td class="label" colspan="3">New Job/Power Failure/Change of Material:</td>
							<td><select name="new_job">					
								<option value="1" <?php echo set_select('new_job','1');?>>YES</option>
								<option value="0" <?php echo set_select('new_job','0');?>>NO</option>								
							</select>
							</td>
						</tr>
						<tr>
							<td class="label" colspan="3">Shift Change/Trial/Machine after maintenance:</td>
							<td><select name="shift_change">					
								<option value="1" <?php echo set_select('shift_change','1');?>>YES</option>
								<option value="0" <?php echo set_select('shift_change','0');?>>NO</option>								
							</select>
							</td>
						</tr>

						<tr>
							<td class="label">Remarks :</td>
							<td colspan="3">
								<textarea name="qc_remarks" id="qc_remarks" cols="40" rows="3" value="<?php echo trim(set_value('qc_remarks'));?>" maxlength="500"><?php echo trim(set_value('qc_remarks'));?>	
								</textarea>
							</td>
						</tr>

						<tr>
							<td class="label" colspan="4"><b>APPROVALS</b></td>
						</tr>
				-->		
						
						

					</table>
			
			<!--</td>
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
							<td><input type="text" name="width_std"  value="<?php echo set_value('width_std');?>"  /></td>
							<td ><input type="text" name="width_actual" value="<?php echo set_value('width_actual');?>" /></td>
							<td><select name="width_status" >
								
								<option value="1" <?php echo set_select('width_status','1');?> >PASS</option>
								<option value="2" <?php echo set_select('width_status','2');?> >FAIL</option>
								<option value="0" <?php echo set_select('width_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Thickness (MM)+/-12 :</td>
							<td><input type="text" name="thickness_std" value="<?php echo set_value('thickness_std');?>"  /></td>
							<td ><input type="text" name="thickness_actual" value="<?php echo set_value('thickness_actual');?>" /></td>
							<td>
								<select name="thickness_status" >
								<option value="1" <?php echo set_select('thickness_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('thickness_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('thickness_status','0');?>>N/A</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="label">Roll Length (MM)+/-10 :</td>
							<td><input type="text" name="reel_length_std"  value="<?php echo set_value('reel_length_std');?>"  /></td>
							<td ><input type="text" name="reel_length_actual" value="<?php echo set_value('reel_length_actual');?>" /></td>
							<td><select name="reel_length_status" >							
								<option value="1" <?php echo set_select('reel_length_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('reel_length_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('reel_length_status','0');?>>N/A</option>
								</select>
							</td>
						</tr>						
						<tr>
							<td class="label" colspan="4"><b> MULTYLAYER- 7 LAYER</b></td>
						</tr>
						<tr>
							<td class="label">First Layer Micron :</td>
							<td><input type="text" name="first_layer_micron_std"   value="<?php echo set_value('first_layer_micron_std');?>"  /></td>
							<td ><input type="text" name="first_layer_micron_actual" value="<?php echo set_value('first_layer_micron_actual');?>" /></td>
							<td><select name="first_layer_micron_status" >							
								<option value="1" <?php echo set_select('first_layer_micron_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('first_layer_micron_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('first_layer_micron_status','0');?>>N/A</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="label">Second Layer Micron :</td>
							<td><input type="text" name="second_layer_micron_std"   value="<?php echo set_value('second_layer_micron_std');?>"  /></td>
							<td ><input type="text" name="second_layer_micron_actual" value="<?php echo set_value('second_layer_micron_actual');?>" /></td>
							<td><select name="second_layer_micron_status" >							
								<option value="1" <?php echo set_select('second_layer_micron_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('second_layer_micron_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('second_layer_micron_status','0');?>>N/A</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="label">Third Layer Micron :</td>
							<td><input type="text" name="third_layer_micron_std"   value="<?php echo set_value('third_layer_micron_std');?>"  /></td>
							<td ><input type="text" name="third_layer_micron_actual" value="<?php echo set_value('third_layer_micron_actual');?>" /></td>
							<td><select name="third_layer_micron_status" >					
								<option value="1" <?php echo set_select('third_layer_micron_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('third_layer_micron_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('third_layer_micron_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Four Layer Micron :</td>
							<td><input type="text" name="fourth_layer_micron_std"   value="<?php echo set_value('fourth_layer_micron_std');?>"  /></td>
							<td ><input type="text" name="fourth_layer_micron_actual" value="<?php echo set_value('fourth_layer_micron_actual');?>" /></td>
							<td><select name="fourth_layer_micron_status" >					
								<option value="1" <?php echo set_select('fourth_layer_micron_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('fourth_layer_micron_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('fourth_layer_micron_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Fifth Layer Micron :</td>
							<td><input type="text" name="fifth_layer_micron_std"   value="<?php echo set_value('fifth_layer_micron_std');?>" /></td>
							<td ><input type="text" name="fifth_layer_micron_actual" value="<?php echo set_value('fifth_layer_micron_actual');?>" /></td>
							<td><select name="fifth_layer_micron_status" >							
								<option value="1" <?php echo set_select('fifth_layer_micron_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('fifth_layer_micron_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('fifth_layer_micron_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Sixth Layer Micron :</td>
							<td><input type="text" name="sixth_layer_micron_std"   value="<?php echo set_value('sixth_layer_micron_std');?>" /></td>
							<td ><input type="text" name="sixth_layer_micron_actual" value="<?php echo set_value('sixth_layer_micron_actual');?>" /></td>
							<td><select name="sixth_layer_micron_status" >							
								<option value="1" <?php echo set_select('sixth_layer_micron_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('sixth_layer_micron_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('sixth_layer_micron_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Seventh Layer Micron :</td>
							<td><input type="text" name="seventh_layer_micron_std"  value="<?php echo set_value('seventh_layer_micron_std');?>"  /></td>
							<td ><input type="text" name="seventh_layer_micron_actual" value="<?php echo set_value('seventh_layer_micron_actual');?>" /></td>
							<td><select name="seventh_layer_micron_status" >							
								<option value="1" <?php echo set_select('seventh_layer_micron_status','1');?> >PASS</option>
								<option value="2" <?php echo set_select('seventh_layer_micron_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('seventh_layer_micron_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Grade & % of Bland :</td>
							<td>Jobcard & Customer specific</td>
							<td ><input type="text" name="grade_perc_of_bland" value="<?php echo set_value('grade_perc_of_bland');?>" /></td>
							<td><select name="grade_perc_of_bland_status" >					
								<option value="1" <?php echo set_select('grade_perc_of_bland_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('grade_perc_of_bland_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('grade_perc_of_bland_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Color of Roll :</td>
							<td>Jobcard & Customer specific</td>
							<td ><input type="text" name="roll_color" value="<?php echo set_value('roll_color');?>" /></td>
							<td><select name="roll_color_status" >							
								<option value="1"  <?php echo set_select('roll_color_status','1');?>>PASS</option>
								<option value="2"  <?php echo set_select('roll_color_status','2');?>>FAIL</option>
								<option value="0"  <?php echo set_select('roll_color_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Color Diffrence :</td>
							<td>DE<3</td>
							<td ><input type="text" name="color_diffrence" value="<?php echo set_value('color_diffrence');?>" /></td>
							<td><select name="color_diffrence_status" ="">					
								<option value="1" <?php echo set_select('color_diffrence_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('color_diffrence_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('color_diffrence_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Opacity :</td>
							<td>>90%</td>
							<td ><input type="text" name="opacity" value="<?php echo set_value('opacity');?>" /></td>
							<td><select name="opacity_status" >							
								<option value="1" <?php echo set_select('opacity_status','1');?> >PASS</option>
								<option value="2" <?php echo set_select('opacity_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('opacity_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Winding Of Roll :</td>
							<td>Should be uniform</td>
							<td ><input type="text" name="roll_winding" value="<?php echo set_value('roll_winding');?>" /></td>
							<td><select name="roll_winding_status" >							
								<option value="1" <?php echo set_select('roll_winding_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('roll_winding_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('roll_winding_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Die Line :</td>
							<td>No Die line</td>
							<td><input type="text" name="die_line" value="<?php echo set_value('die_line');?>" /></td>
							<td><select name="die_line_status">							
								<option value="1" <?php echo set_select('die_line_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('die_line_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('die_line_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Scratch Line :</td>
							<td>No Scratch line</td>
							<td><input type="text" name="scratch_line" value="<?php echo set_value('scratch_line');?>" /></td>
							<td><select name="scratch_line_status" ="">							
								<option value="1" <?php echo set_select('scratch_line_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('scratch_line_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('scratch_line_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Pit/Watermark/Fisheye :</td>
							<td>No Pit/Watermark</td>
							<td><input type="text" name="pit_watermark" value="<?php echo set_value('pit_watermark');?>" /></td>
							<td><select name="pit_watermark_status">							
								<option value="1" <?php echo set_select('pit_watermark_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('pit_watermark_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('pit_watermark_status','0');?>>N/A</option>
							</select></td>
						</tr>
						
						<tr>
							<td class="label">Contamination :</td>
							<td>No Contamination</td>
							<td><input type="text" name="contamination" value="<?php echo set_value('contamination');?>" /></td>
							<td><select name="contamination_status" ="">							
								<option value="1" <?php echo set_select('contamination_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('contamination_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('contamination_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Humps on Roll :</td>
							<td>No Humps surface should be even</td>
							<td><input type="text" name="roll_humps" value="<?php echo set_value('roll_humps');?>" /></td>
							<td><select name="roll_humps_status">							
								<option value="1" <?php echo set_select('roll_humps_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('roll_humps_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('roll_humps_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Color Dispersion :</td>
							<td>Should be Uniform</td>
							<td><input type="text" name="color_dispersion" value="<?php echo set_value('color_dispersion');?>" /></td>
							<td><select name="color_dispersion_status" ="">			
								<option value="1" <?php echo set_select('color_diffrence_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('color_diffrence_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('color_diffrence_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">COF-SF/DF :</td>
							<td></td>
							<td><input type="text" name="cof_sf_df" value="<?php echo set_value('cof_sf_df');?>" /></td>
							<td><select name="cof_sf_df_status" ="">				
								<option value="1" <?php echo set_select('cof_sf_df_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('cof_sf_df_status','1');?>>FAIL</option>
								<option value="0" <?php echo set_select('cof_sf_df_status','1');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Masterbatch Color & % :</td>
							<td>Jobcard & Customer specific</td>
							<td><input type="text" name="mb_color_perc" value="<?php echo set_value('mb_color_perc');?>" /></td>
							<td><select name="mb_color_perc_status" ="">							
								<option value="1" <?php echo set_select('mb_color_perc_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('mb_color_perc_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('mb_color_perc_status','0');?>>N/A</option>
							</select></td>
						</tr>					
					

					</table>
			-->		


				</td>
							
			</tr>

		</table>
					
	</div>
	
				


	<div class="form_design">
		<button class="submit" name="submit">Search</button> <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>">Cancel</a>
	</div>

	
</form>




				
				
				
			