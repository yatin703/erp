<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		$("#jobcard_no").autocomplete("<?php echo base_url('index.php/ajax_springtube/jobcard_printing_autocomplete');?>", {selectFirst: true});	
				


	});//Jquery closed

</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save_parameters');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">

						<tr>
							<td class="label">Inspection Time <span style="color:red;">*</span> :</td>
							<td><input type="hidden" name="cp_id" value="<?php echo set_value('cp_id',$this->uri->segment(3));?>"> 
								<input type="text" name="time_slot"   value="<?php echo set_value('time_slot',date('H:i:s'));?>" readonly /></td>
							<td class="label">Operator  :</td>
							<td colspan="3"><input type="text" name="operator" id="operator"  size="20" value="<?php echo set_value('operator');?>" maxlength="50" required/></td>	
							
						</tr>						
						<tr>
							<td class="label" colspan="4">&nbsp;</td>					
						</tr>
						<tr>
							
							<th class="label">PARAMTERS </th>
							<th class="label">STD</th>
							<th class="label">TOLARANCE </th>
							<th class="label">ACTUAL</th>
							
						</tr>				 
											
						<tr>							
							<td class="label">Chiller Temperature  :</td>
							<td>-</td>
							<td>+/-</td>
							<td ><input type="text" name="chillar_temp" value="<?php echo set_value('chillar_temp');?>" size="20" required maxlength="4"/></td>
							 
							</td>
						</tr>
						<tr>							
							<td class="label"> Shaft Temperature :</td>
							<td>-</td>
							<td>+/-</td>
							<td ><input type="text" name="shaft_temp" value="<?php echo set_value('shaft_temp');?>" size="20" required maxlength="10"/></td>
							 
							</td>
						</tr>
						<tr>							
							<td class="label">Laminate Turming Cut :</td>
							<td>-</td>
							<td>+/-</td>
							<td ><input type="text" name="laminate_terming_cut" value="<?php echo set_value('laminate_terming_cut');?>" size="20" required maxlength="10"/></td>
							 
							</td>
						</tr>
						<tr>							
							<td class="label"> HF Temperature External :</td>
							<td>-</td>
							<td>+/-</td>
							<td ><input type="text" name="hf_temp_external" value="<?php echo set_value('hf_temp_external');?>" size="20" required maxlength="10"/></td>							 
							 
						</tr>
						<tr>							
							<td class="label"> HF Temperature Internal :</td>
							<td>-</td>
							<td>+/-</td>
							<td ><input type="text" name="hf_temp_internal" value="<?php echo set_value('hf_temp_internal');?>" size="20" required maxlength="10"/></td>				 
							
						</tr>
						<tr>							
							<td class="label">Pressure Metallic Belt Internal:</td>
							<td>-</td>
							<td>+/-</td>
							<td ><input type="text" name="pressure_metalic_belt_internal" value="<?php echo set_value('pressure_metalic_belt_internal');?>" size="20" required maxlength="10"/>
							</td>
							 
					</tr>
						<tr>							
							<td class="label">Pressure Metallic Belt External:</td>
							<td>-</td>
							<td>-</td>
							<td ><input type="text" name="pressure_metalic_belt_external" value="<?php echo set_value('pressure_metalic_belt_external');?>" size="20" required maxlength="50"/></td>
							 
							 
						</tr>
						<tr>							
							<td class="label">External Inductor Pressure 1 :</td>
							<td>-</td>
							<td>-</td>
							<td ><input type="text" name="external_inductor_pressure_1" value="<?php echo set_value('external_inductor_pressure_1');?>" size="20" required maxlength="10"/>
							</td>
							 
							 
						</tr>
						<tr>							
							<td class="label">External Inductor Pressure 2 :</td>
							<td>-</td>
							<td>-</td>
							<td ><input type="text" name="external_inductor_pressure_2" value="<?php echo set_value('external_inductor_pressure_2');?>" size="20" required maxlength="10"/></td>
							 
							 
						</tr>
						<tr>							
							<td class="label">Pressure Transition Pad :</td>
							<td>-</td>
							<td>+/-</td>
							<td ><input type="text" name="pressure_transition_pad" value="<?php echo set_value('pressure_transition_pad');?>" size="20" required maxlength="10"/></td>							 
							</td>
						</tr>
						<tr>							
							<td class="label">Pressure Roller 1 :</td>
							<td>-</td>
							<td>+/-</td>
							<td ><input type="text" name="pressure_roller_1" value="<?php echo set_value('pressure_roller_1');?>" size="20" required maxlength="10"/></td>
							 
							</td>
						</tr>
						<tr>							
							<td class="label"> Pressure Cooling Pad :</td>
							<td>-</td>
							<td>+/-</td>
							<td ><input type="text" name="pressure_cooling_pad" value="<?php echo set_value('pressure_cooling_pad');?>" size="20" required maxlength="10"/></td>							 
							</td>
						</tr>
						<tr>							
							<td class="label">Triple Reforming Roller :</td>
							<td>-</td>
							<td>+/-</td>
							<td ><input type="text" name="triple_reforming_roller" value="<?php echo set_value('triple_reforming_roller');?>" size="20" required maxlength="10"/></td>							 
							</td>
						</tr>
						<tr>							
							<td class="label">Single Reforming Roller :</td>
							<td>-</td>
							<td>+/-</td>
							<td ><input type="text" name="single_reforming_roller" value="<?php echo set_value('single_reforming_roller');?>" size="20" required maxlength="10"/></td>							 
							</td>
						</tr>
						<tr>							
							<td class="label">Torque Internal Belt :</td>
							<td>-</td>
							<td>+/-</td>
							<td ><input type="text" name="torque_internal_belt" value="<?php echo set_value('torque_internal_belt');?>" size="20" required maxlength="10"/></td>							 
							</td>
						</tr>
						<tr>							
							<td class="label">Torque External Belt :</td>
							<td>-</td>
							<td>+/-</td>
							<td ><input type="text" name="torque_external_belt" value="<?php echo set_value('torque_external_belt');?>" size="20" required maxlength="10"/></td>							 
							</td>
						</tr>
						<tr>							
							<td class="label">Welding Test Side Seam :</td>
							<td>-</td>
							<td>+/-</td>
							<td ><input type="text" name="welding_test_side_seam" value="<?php echo set_value('welding_test_side_seam');?>" size="20" required maxlength="10"/></td>							 
							</td>
						</tr>
						<tr>							
							<td class="label">Welding Test Tube Head :</td>
							<td>-</td>
							<td>+/-</td>
							<td ><input type="text" name="welding_test_tube_head" value="<?php echo set_value('welding_test_tube_head');?>" size="20" required maxlength="10"/></td>							 
							</td>
						</tr>
						<tr>							
							<td class="label">Cap Fitment :</td>
							<td>-</td>
							<td>+/-</td>
							<td ><input type="text" name="cap_fitment" value="<?php echo set_value('cap_fitment');?>" size="20" required maxlength="10"/></td>							 
							</td>
						</tr>
						<tr>							
							<td class="label">Air Leakage With Cap :</td>
							<td>-</td>
							<td>+/-</td>
							<td ><input type="text" name="air_leakage_with_cap" value="<?php echo set_value('air_leakage_with_cap');?>" size="20" required maxlength="10"/></td>							 
							</td>
						</tr>
						<tr>							
							<td class="label">Pull Force Snap Cap :</td>
							<td>-</td>
							<td>+/-</td>
							<td ><input type="text" name="pull_force_snap_cap" value="<?php echo set_value('pull_force_snap_cap');?>" size="20" required maxlength="10"/></td>							 
							</td>
						</tr>
						<tr>							
							<td class="label">Cap Alignment :</td>
							<td>-</td>
							<td>+/-</td>
							<td ><input type="text" name="cap_alignment" value="<?php echo set_value('cap_alignment');?>" size="20" required maxlength="10"/></td>							 
							</td>
						</tr>
						<tr>							
							<td class="label">Cap Foil Thickness :</td>
							<td>-</td>
							<td>+/-</td>
							<td ><input type="text" name="cap_foil_thickness" value="<?php echo set_value('cap_foil_thickness');?>" size="20" required maxlength="10"/></td>							 
							</td>
						</tr>				

					</table>
				</td>							
			</tr>
		</table>
					
	</div>
	
				


	<!-- <div class="form_design">
		<button class="submit" name="submit">Save</button> <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>">Cancel</a>
	</div> -->
	<div class="form_design">
		<div class="ui buttons">
	  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui positive button">Save</button>
		</div>
	</div>

	
</form>




				
				
				
			