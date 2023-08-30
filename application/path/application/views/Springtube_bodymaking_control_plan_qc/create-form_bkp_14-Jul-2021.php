<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		$("#jobcard_no").autocomplete("<?php echo base_url('index.php/ajax_springtube/jobcard_bodymaking_autocomplete');?>", {selectFirst: true});	
				


	});//Jquery closed

</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">

						<tr>
							<td class="label">Inspection Date <span style="color:red;">*</span> :</td>
							<td><input type="date" name="inspection_date"   value="<?php echo set_value('inspection_date',date('Y-m-d'));?>" /></td>

							
							<td class="label">Machine <span style="color:red;">*</span> :</td>
							<td><select name="machine" id="machine" readonly><option value=''>----Select Machine-----</option>
							<?php if($springtube_machine_master==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach($springtube_machine_master as $machine_row){
										$selected=($machine_row->machine_id==3?'selected':'');
										echo "<option value='".$machine_row->machine_id."'  ".set_select('machine',''.$machine_row->machine_id.'').$selected.">".$machine_row->machine_name."</option>";
									}
							}?>
							</select></td>
							
						</tr>
						
						<tr>	
							<td class="label">Jobcard No. :</td>
							<td>
								<input type="text" name="jobcard_no" id="jobcard_no"  size="20" value="<?php echo set_value('jobcard_no');?>" required/>
							</td>
							<td class="label">Operator  :</td>
							<td colspan="3"><input type="text" name="operator" id="operator"  size="20" value="<?php echo set_value('operator');?>" maxlength="50" required/></td>
							
						</tr>						

						<tr>
							<th class="label">PRINTING PARAMETER </th>
							<th class="label">ACCEPTANCE CRITERIA </th>
							<th class="label">OBSERVATION</th>
							<th class="label">STATUS PASS/FAIL</th>
						</tr>
						
						<tr>
							<td class="label">Shade Variations :</td>
							<td>As per shade card or approved Pantone</td>
							<td ><input type="text" name="shade_variation" value="<?php echo set_value('shade_variation');?>" required  size="10"/></td>
							<td><select name="shade_variation_status" required>							
								<option value="1" <?php echo set_select('shade_variation_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('shade_variation_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('shade_variation_status','0');?>>N/A</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="label">Text Proof:</td>
							<td>As per approved artwork </td>
							<td ><input type="text" name="text_proof" value="<?php echo set_value('text_proof');?>" required size="10"/></td>
							<td><select name="text_proof_status" required>							
								<option value="1" <?php echo set_select('text_proof_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('text_proof_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('text_proof_status','0');?>>N/A</option>
								</select>
							</td>
						</tr>
						
						<tr>
							<td class="label">Non Print Area :</td>
							<td>As per approved artwork</td>
							<td ><input type="text" name="non_print_area" value="<?php echo set_value('non_print_area');?>"  size="10" required/></td>
							<td><select name="non_print_area_status" required>					
								<option value="1" <?php echo set_select('non_print_area_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('non_print_area_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('non_print_area_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">I Mark Position/Registration :</td>
							<td>Check against Positive</td>
							<td ><input type="text" name="i_mark_position" value="<?php echo set_value('i_mark_position');?>"  size="10" required/></td>
							<td><select name="i_mark_position_status" required>					
								<option value="1" <?php echo set_select('i_mark_position_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('i_mark_position_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('i_mark_position_status','0');?>>N/A</option>
							</select></td>
						</tr>
						
						<tr>
							<td class="label">Print Cut :</td>
							<td>No Print cut</td>
							<td ><input type="text" name="print_cut" value="<?php echo set_value('print_cut');?>" size="10" required/></td>
							<td><select name="print_cut_status"  required>							
								<option value="1" <?php echo set_select('print_cut_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('print_cut_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('print_cut_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Smudge Print :</td>
							<td>No Smudge print</td>
							<td ><input type="text" name="smudge_print" value="<?php echo set_value('smudge_print');?>" size="10" required/></td>
							<td><select name="smudge_print_status" required>							
								<option value="1" <?php echo set_select('smudge_print_status','1');?> >PASS</option>
								<option value="2" <?php echo set_select('smudge_print_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('smudge_print_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Ink Dot :</td>
							<td>No Ink dot</td>
							<td ><input type="text" name="ink_dot" value="<?php echo set_value('ink_dot');?>"  size="10"required/></td>
							<td><select name="ink_dot_status" required>					
								<option value="1" <?php echo set_select('ink_dot_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('ink_dot_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('ink_dot_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Ghost Print :</td>
							<td>No Ghost Print</td>
							<td ><input type="text" name="ghost_print" value="<?php echo set_value('ghost_print');?>" size="10" required/></td>
							<td><select name="ghost_print_status" required>							
								<option value="1"  <?php echo set_select('ghost_print_status','1');?>>PASS</option>
								<option value="2"  <?php echo set_select('ghost_print_status','2');?>>FAIL</option>
								<option value="0"  <?php echo set_select('ghost_print_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Motling :</td>
							<td>No Motling</td>
							<td ><input type="text" name="motling" value="<?php echo set_value('motling');?>" size="10" required/></td>
							<td><select name="motling_status" required="required">					
								<option value="1" <?php echo set_select('motling_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('motling_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('motling_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Tape Test :</td>
							<td>Should be pass in 3M Scotch tape(616)</td>
							<td ><input type="text" name="tape_test" value="<?php echo set_value('tape_test');?>"  size="10" required/></td>
							<td><select name="tape_test_status" required>							
								<option value="1" <?php echo set_select('tape_test_status','1');?> >PASS</option>
								<option value="2" <?php echo set_select('tape_test_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('tape_test_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Rub Test :</td>
							<td>Should be pass in thumb rub</td>
							<td ><input type="text" name="rub_test" value="<?php echo set_value('rub_test');?>" size="10" required/></td>
							<td><select name="rub_test_status" required>							
								<option value="1" <?php echo set_select('rub_test_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('rub_test_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('rub_test_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Print Surface Line :</td>
							<td>No print surface scratch line</td>
							<td><input type="text" name="print_surface_line" value="<?php echo set_value('print_surface_line');?>"  size="10" required/></td>
							<td><select name="print_surface_line_status">							
								<option value="1" <?php echo set_select('print_surface_line_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('print_surface_line_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('print_surface_line_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Miss Print :</td>
							<td>No miss print</td>
							<td><input type="text" name="miss_print" value="<?php echo set_value('miss_print');?>" size="10" required/></td>
							<td><select name="miss_print_status" required="required">							
								<option value="1" <?php echo set_select('miss_print_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('miss_print_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('miss_print_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Barcode test :</td>
							<td>Must be read by Barcode reader</td>
							<td><input type="text" name="barcode_test" value="<?php echo set_value('barcode_test');?>" size="10" required/></td>
							<td><select name="barcode_test_status">							
								<option value="1" <?php echo set_select('barcode_test_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('barcode_test_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('barcode_test_status','0');?>>N/A</option>
							</select></td>
						</tr>						
						<tr>
							<td class="label">Contamination Issue :</td>
							<td>No Contamination</td>
							<td><input type="text" name="contamination" value="<?php echo set_value('contamination');?>" size="10" required/></td>
							<td><select name="contamination_status" required="required">							
								<option value="1" <?php echo set_select('contamination_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('contamination_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('contamination_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label" colspan="4"><b>CAPPING PARAMETER</b></td>
						</tr>
						<tr>
							<td class="label">Pintle Damage:</td>
							<td>No pintal damage </td>
							<td ><input type="text" name="cap_pintle_damage" value="<?php echo set_value('cap_pintle_damage');?>" required size="10"/></td>
							<td><select name="cap_pintle_damage_status" required>				
								<option value="1" <?php echo set_select('cap_pintle_damage_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('cap_pintle_damage_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('cap_pintle_damage_status','0');?>>N/A</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="label">Cap Damage :</td>
							<td>No cap damage</td>
							<td ><input type="text" name="cap_damage" value="<?php echo set_value('cap_damage');?>" size="10" required/></td>
							<td><select name="cap_damage_status" required>							
								<option value="1" <?php echo set_select('cap_damage_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('cap_damage_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('cap_damage_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label"> Crack/Scratch in Cap :</td>
							<td>No crack/scratch in cap</td>
							<td ><input type="text" name="cap_scratch" value="<?php echo set_value('cap_scratch');?>" size="10" required/></td>
							<td><select name="cap_scratch_status" required>							
								<option value="1" <?php echo set_select('cap_scratch_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('cap_scratch_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('cap_scratch_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Cap Allignment :</td>
							<td>Should be allign with eye mark</td>
							<td ><input type="text" name="cap_allignment" value="<?php echo set_value('cap_allignment');?>" size="10" required/></td>
							<td><select name="cap_allignment_status" required>				
								<option value="1" <?php echo set_select('cap_allignment_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('cap_allignment_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('cap_allignment_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Tube Folding :</td>
							<td>No cap folding</td>
							<td ><input type="text" name="cap_tube_folding" value="<?php echo set_value('cap_tube_folding');?>" size="10" required/></td>
							<td><select name="cap_tube_folding_status" required>				
								<option value="1" <?php echo set_select('cap_tube_folding_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('cap_tube_folding_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('cap_tube_folding_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Cap Fitting :</td>
							<td>No gap between cap and shoulder and no loose cap</td>
							<td ><input type="text" name="cap_fitting" value="<?php echo set_value('cap_fitting');?>" size="10" required/></td>
							<td><select name="cap_fitting_status" required>				
								<option value="1" <?php echo set_select('cap_fitting_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('cap_fitting_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('cap_fitting_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Air leakage with cap :</td>
							<td>No air leakage 0.5 bar air leackage</td>
							<td ><input type="text" name="cap_air_leackage" value="<?php echo set_value('cap_air_leackage');?>" size="10" required/></td>
							<td><select name="cap_air_leackage_status" required>			
								<option value="1" <?php echo set_select('cap_air_leackage_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('cap_air_leackage_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('cap_air_leackage_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Cap Rotation :</td>
							<td>No cap ratation</td>
							<td ><input type="text" name="cap_rotation" value="<?php echo set_value('cap_rotation');?>" size="10" required/></td>
							<td><select name="cap_rotation_status" required>				
								<option value="1" <?php echo set_select('cap_rotation_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('cap_rotation_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('cap_rotation_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Pull force in snap cap :</td>
							<td>Not remove easily</td>
							<td ><input type="text" name="cap_pull_force" value="<?php echo set_value('cap_pull_force');?>" size="10" required/></td>
							<td><select name="cap_pull_force_status" required>				
								<option value="1" <?php echo set_select('cap_pull_force_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('cap_pull_force_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('cap_pull_force_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Hinge breack :</td>
							<td>No hinge breack</td>
							<td ><input type="text" name="cap_hinge_breack" value="<?php echo set_value('cap_hinge_breack');?>" size="10" required/></td>
							<td><select name="cap_hinge_breack_status" required>			
								<option value="1" <?php echo set_select('cap_hinge_breack_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('cap_hinge_breack_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('cap_hinge_breack_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Cap shrink sleeve (printed/plain) :</td>
							<td>As per specification</td>
							<td ><input type="text" name="cap_shrink_sleeve" value="<?php echo set_value('cap_shrink_sleeve');?>" size="10" required/></td>
							<td><select name="cap_shrink_sleeve_status" required>				
								<option value="1" <?php echo set_select('cap_shrink_sleeve_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('cap_shrink_sleeve_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('cap_shrink_sleeve_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Cap (with foil/without foil) :</td>
							<td>As per specification</td>
							<td ><input type="text" name="cap_foil" value="<?php echo set_value('cap_foil');?>" size="10" required/></td>
							<td><select name="cap_foil_status" required>				
								<option value="1" <?php echo set_select('cap_foil_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('cap_foil_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('cap_foil_status','0');?>>N/A</option>
							</select></td>
						</tr>

						<tr>
							<td class="label">Cap foil thickness variation :</td>
							<td>Thickness should be as per specification</td>
							<td ><input type="text" name="cap_foil_thickness_vari" value="<?php echo set_value('cap_foil_thickness_vari');?>" size="10" required/></td>
							<td><select name="cap_foil_thickness_vari_status" required>				
								<option value="1" <?php echo set_select('cap_foil_thickness_vari_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('cap_foil_thickness_vari_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('cap_foil_thickness_vari_status','0');?>>N/A</option>
							</select></td>
						</tr>					
						

					</table>			
				</td>
				<td>
					<table>

						<tr>
							<td class="label" colspan="4"><b>LACQUER INFORMATION</b></td>
						</tr>
						<tr>
							<td class="label">Non Lacquer Area :</td>
							<td>As per approved Artwork +-1mm</td>
							<td><input type="text" name="non_lacquer_area" value="<?php echo set_value('non_lacquer_area');?>" size="10" required/></td>
							<td><select name="non_lacquer_area_status">							
								<option value="1" <?php echo set_select('non_lacquer_area_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('non_lacquer_area_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('non_lacquer_area_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Wet Lacquer :</td>
							<td>No Wet lacquer</td>
							<td><input type="text" name="wet_lacquer" value="<?php echo set_value('wet_lacquer');?>" size="10" required/></td>
							<td><select name="wet_lacquer_status" required="required">			
								<option value="1" <?php echo set_select('wet_lacquer_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('wet_lacquer_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('wet_lacquer_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Lacquer Peeloff :</td>
							<td>No Lacquer Peeloff</td>
							<td><input type="text" name="lacquer_peeloff" value="<?php echo set_value('lacquer_peeloff');?>" size="10" required/></td>
							<td><select name="lacquer_peeloff_status" required="required">				
								<option value="1" <?php echo set_select('lacquer_peeloff_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('lacquer_peeloff_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('lacquer_peeloff_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Wavy Lacquer:</td>
							<td>No Wavy Lacquer</td>
							<td><input type="text" name="wavy_lacquer" value="<?php echo set_value('wavy_lacquer');?>" size="10" required/></td>
							<td><select name="wavy_lacquer_status" required="required">							
								<option value="1" <?php echo set_select('wavy_lacquer_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('wavy_lacquer_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('wavy_lacquer_status','0');?>>N/A</option>
							</select></td>
						</tr>

						<tr>
							<td class="label">Dull Lacquer:</td>
							<td>No Dull Lacquer</td>
							<td><input type="text" name="dull_lacquer" value="<?php echo set_value('dull_lacquer');?>" size="10" required/></td>
							<td><select name="dull_lacquer_status" required="required">					
								<option value="1" <?php echo set_select('dull_lacquer_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('dull_lacquer_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('dull_lacquer_status','0');?>>N/A</option>
							</select></td>
						</tr>

						<tr>
							<td class="label">Dirty Lacquer:</td>
							<td>No Dirty Lacquer</td>
							<td><input type="text" name="dirty_lacquer" value="<?php echo set_value('dirty_lacquer');?>" size="10" required/></td>
							<td><select name="dirty_lacquer_status" required="required">					
								<option value="1" <?php echo set_select('dirty_lacquer_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('dirty_lacquer_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('dirty_lacquer_status','0');?>>N/A</option>
							</select></td>
						</tr>

						<tr>
							<td class="label" colspan="4"><b>FOIL/SHOULDER PARAMETER</b></td>
						</tr>
						<tr>
							<td class="label">Foil Cut :</td>
							<td>Check against approved Artwork shrink Positive</td>
							<td><input type="text" name="foil_cut" value="<?php echo set_value('foil_cut');?>" size="10" required/></td>
							<td><select name="foil_cut_status">							
								<option value="1" <?php echo set_select('foil_cut_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('foil_cut_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('foil_cut_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Foil Shift (Vertical) :</td>
							<td>Check against approved Artwork shrink Positive</td>
							<td><input type="text" name="foil_shift_vertical" value="<?php echo set_value('foil_shift_vertical');?>" size="10" required/></td>
							<td><select name="foil_shift_vertical_status" required="required">			
								<option value="1" <?php echo set_select('foil_shift_vertical_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('foil_shift_vertical_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('foil_shift_vertical_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Foil Shift (Horizontal) :</td>
							<td>Check against approved Artwork shrink Positive</td>
							<td><input type="text" name="foil_shift_horizontal" value="<?php echo set_value('foil_shift_horizontal');?>" size="10" required/></td>
							<td><select name="foil_shift_horizontal_status" required="required">			
								<option value="1" <?php echo set_select('foil_shift_horizontal_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('foil_shift_horizontal_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('foil_shift_horizontal_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Foil Thickness :</td>
							<td>Check against approved Artwork shrink Positive</td>
							<td><input type="text" name="foil_thickness" value="<?php echo set_value('foil_thickness');?>" size="10" required/></td>
							<td><select name="foil_thickness_status" required="required">		
								<option value="1" <?php echo set_select('foil_thickness_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('foil_thickness_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('foil_thickness_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Sleeve Color/Code :</td>
							<td>As per jobcard and customer specification</td>
							<td><input type="text" name="sleeve_color_code" value="<?php echo set_value('sleeve_color_code');?>" size="10" required/></td>
							<td><select name="sleeve_color_code_status" required="required">		
								<option value="1" <?php echo set_select('sleeve_color_code_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('sleeve_color_code_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('sleeve_color_code_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Length Of Tube :</td>
							<td>As per jobcard and customer specification</td>
							<td><input type="text" name="tube_length" value="<?php echo set_value('tube_length');?>" size="10" required/></td>
							<td><select name="tube_length_status" required="required">		
								<option value="1" <?php echo set_select('tube_length_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('tube_length_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('tube_length_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Orifice Diameter :</td>
							<td>As per jobcard and customer specification</td>
							<td><input type="text" name="orifice_diameter" value="<?php echo set_value('orifice_diameter');?>" size="10" required/></td>
							<td><select name="orifice_diameter_status" required="required">	
								<option value="1" <?php echo set_select('orifice_diameter_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('orifice_diameter_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('orifice_diameter_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Welding Defect :</td>
							<td>Welding breaking force NLT 45 N</td>
							<td><input type="text" name="welding_defect" value="<?php echo set_value('welding_defect');?>" size="10" required/></td>
							<td><select name="welding_defect_status" required="required">	
								<option value="1" <?php echo set_select('welding_defect_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('welding_defect_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('welding_defect_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Shoulder blend/Vertical test :</td>
							<td>Should be proper and Straight</td>
							<td><input type="text" name="shoulder_blend" value="<?php echo set_value('shoulder_blend');?>" size="10" required/></td>
							<td><select name="shoulder_blend_status" required="required">	
								<option value="1" <?php echo set_select('shoulder_blend_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('shoulder_blend_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('shoulder_blend_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Thread Flash :</td>
							<td>No thread flash</td>
							<td><input type="text" name="thread_flash" value="<?php echo set_value('thread_flash');?>" size="10" required/></td>
							<td><select name="thread_flash_status" required="required">	
								<option value="1" <?php echo set_select('thread_flash_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('thread_flash_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('thread_flash_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Excess Material :</td>
							<td>No Excess Material</td>
							<td><input type="text" name="excess_material" value="<?php echo set_value('excess_material');?>" size="10" required/></td>
							<td><select name="excess_material_status" required="required">	
								<option value="1" <?php echo set_select('excess_material_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('excess_material_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('excess_material_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Short Shot :</td>
							<td>No short shot</td>
							<td><input type="text" name="short_shot" value="<?php echo set_value('short_shot');?>" size="10" required/></td>
							<td><select name="short_shot_status" required="required">	
								<option value="1" <?php echo set_select('short_shot_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('short_shot_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('short_shot_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Orifice Block :</td>
							<td>Orifice should be clear and No block</td>
							<td><input type="text" name="orifice_block" value="<?php echo set_value('orifice_block');?>" size="10" required/></td>
							<td><select name="orifice_block_status" required="required">	
								<option value="1" <?php echo set_select('orifice_block_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('orifice_block_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('orifice_block_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Folding :</td>
							<td> No folding</td>
							<td><input type="text" name="shoulder_folding" value="<?php echo set_value('shoulder_folding');?>" size="10" required/></td>
							<td><select name="shoulder_folding_status" required="required">	
								<option value="1" <?php echo set_select('shoulder_folding_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('shoulder_folding_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('shoulder_folding_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Tube perforated :</td>
							<td> No tube perforated</td>
							<td><input type="text" name="tube_perforated" value="<?php echo set_value('tube_perforated');?>" size="10" required/></td>
							<td><select name="tube_perforated_status" required="required">	
								<option value="1" <?php echo set_select('tube_perforated_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('tube_perforated_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('tube_perforated_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
							<td class="label">Contamination/dust/oil mark :</td>
							<td> No contamination/dust/oil mark</td>
							<td><input type="text" name="shoulder_contamination" value="<?php echo set_value('shoulder_contamination');?>" size="10" required/></td>
							<td><select name="shoulder_contamination_status" required="required">	
								<option value="1" <?php echo set_select('shoulder_contamination_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('shoulder_contamination_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('shoulder_contamination_status','0');?>>N/A</option>
							</select></td>
						</tr>
						<tr>
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
							<td class="label" colspan="3">Remaining Ink & Lacquer is stored with proper identification :</td>													
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
							<td class="label" colspan="3">Clear all Rejected Tubes from the rejection area :</td>													
							<td><select name="rejected_tubes_clear_status">					
								<option value="1" <?php echo set_select('rejected_tubes_clear_status','1');?>>YES</option>
								<option value="0" <?php echo set_select('rejected_tubes_clear_status','0');?>>NO</option>								
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
							<td class="label" colspan="3">No Sleeves & tubes of Previous Job :</td>
							<td><select name="no_tubes_prevjob_status">					
								<option value="1" <?php echo set_select('no_tubes_prevjob_status','1');?>>YES</option>
								<option value="0" <?php echo set_select('no_tubes_prevjob_status','0');?>>NO</option>								
							</select></td>
						</tr>
						<tr>
							<td class="label" colspan="3">Machine and Surrounding Clean :</td>
							<td><select name="machine_clean_status">					
								<option value="1" <?php echo set_select('machine_clean_status','1');?>>YES</option>
								<option value="0" <?php echo set_select('machine_clean_status','0');?>>NO</option>								
							</select></td>
						</tr>
						<tr>
							<td class="label" colspan="3">Cleaning of Hooper for Cap/Shoulder with IPA :</td>
							<td><select name="hooper_cleaning_status">					
								<option value="1" <?php echo set_select('hooper_cleaning_status','1');?> >YES</option>
								<option value="0" <?php echo set_select('hooper_cleaning_status','0');?>>NO</option>								
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
							<td class="label" colspan="3">Reason for Setup Approval <span style="color:red;">*</span> :</td>
							<td><div class="ui checkbox"><input type="checkbox" name="new_job_status" value="1"><label>New Job</label></div><br/>
								<div class="ui checkbox"><input type="checkbox" name="power_failure_status" value="1"><label>Power Failure</label></div><br/>
								<div class="ui checkbox"><input type="checkbox" name="change_of_rm_status" value="1"><label>Change of Material</label></div><br/>
								<div class="ui checkbox"><input type="checkbox" name="shift_change_status" value="1"><label>Shift Change</label></div><br/>
								<div class="ui checkbox"><input type="checkbox" name="trial_status" value="1"><label>Trial</label></div><br/>
								<div class="ui checkbox"><input type="checkbox" name="machine_maintainance_status" value="1"><label>Machine Maintainance</label></div><br/>
								</td>
						</tr>
						<!-- <tr>
							<td class="label" colspan="3">New Job/Power Failure/Change of Material:</td>
							<td><select name="new_job">					
								<option value="1" <?php echo set_select('new_job','1');?>>YES</option>
								<option value="0" <?php echo set_select('new_job','0');?>>NO</option>								
							</select>
							</td>
						</tr> -->
						<!-- <tr>
							<td class="label" colspan="3">Shift Change/Trial/Machine after maintenance:</td>
							<td><select name="shift_change">					
								<option value="1" <?php echo set_select('shift_change','1');?>>YES</option>
								<option value="0" <?php echo set_select('shift_change','0');?>>NO</option>								
							</select>
							</td>
						</tr> -->
						<tr>
							<td class="label">Remarks :</td>
							<td colspan="3">
								<textarea name="qc_remarks" id="qc_remarks" cols="40" rows="3" value="<?php echo trim(set_value('qc_remarks'));?>" maxlength="500" required><?php echo trim(set_value('qc_remarks'));?>	
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
								<option value="1" <?php echo set_select('qc_inspection_status','1');?> >APPROVED</option>
								<option value="2" <?php echo set_select('qc_inspection_status','2');?> >REJECT</option>
								<option value="0" <?php echo set_select('qc_inspection_status','0');?> >HOLD</option>								
							</select>
							</td>
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




				
				
				
			