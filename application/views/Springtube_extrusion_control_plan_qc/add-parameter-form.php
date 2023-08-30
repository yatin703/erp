<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		$("#jobcard_no").autocomplete("<?php echo base_url('index.php/ajax_springtube/jobcard_extrusion_autocomplete');?>", {selectFirst: true});	
				


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
					<?php 
					$a=1;
					foreach ($ex_a as $ex_a_row): ?>						
						<tr>
							
							<td class="label"> <b>EX-A</b> <?php echo $ex_a_row->parameter?>:</td>
							<td><input type="text" name="ex_a_std_value_<?php echo $ex_a_row->parameter_id;?>" value="<?php echo set_value('ex_a_std_value_'.$ex_a_row->parameter_id.'',$ex_a_row->std_value);?>" size="20" readonly /></td>
							<td ><input type="text" name="ex_a_tolarance_<?php echo $ex_a_row->parameter_id;?>" value="<?php echo set_value('ex_a_tolarance_'.$ex_a_row->parameter_id.'',$ex_a_row->tolarance);?>" readonly/></td>
							<td><input type="number" name="ex_a_actual_<?php echo $a;?>" value="<?php echo set_value('ex_a_actual_'.$a.'');?>" maxlength="3" min="1" max="500" <?php echo ($ex_a_row->std_value!=''?"required":""); ?> />
							</td>
						</tr>
					<?php
						$a++; 
					endforeach;?>

					<tr>
						<td class="label" colspan="4">&nbsp;</td>
					</tr>

					<?php 
						$b=1;
						foreach ($ex_b as $ex_b_row): ?>						
						<tr>
							
							<td class="label"> <b>EX-B</b> <?php echo $ex_b_row->parameter?>:</td>
							<td><input type="text" name="ex_b_std_value_<?php echo $ex_b_row->parameter_id;?>" value="<?php echo set_value('ex_b_std_value_'.$ex_b_row->parameter_id.'',$ex_b_row->std_value);?>" size="20" readonly /></td>
							<td ><input type="text" name="ex_b_tolarance_<?php echo $ex_b_row->parameter_id;?>" value="<?php echo set_value('ex_b_tolarance_'.$ex_b_row->parameter_id.'',$ex_b_row->tolarance);?>" readonly/></td>
							<td><input type="number" name="ex_b_actual_<?php echo $b;?>" value="<?php echo set_value('ex_b_actual_'.$b.'');?>" maxlength="3" min="1" max="500" <?php echo ($ex_b_row->std_value!=''?"required":""); ?>/>
							</td>
						</tr>
					<?php 
						$b++;
						endforeach;?>	

					<tr>
						<td class="label" colspan="4">&nbsp;</td>
					</tr>

					<?php 
						$c=1;
						foreach ($ex_c as $ex_c_row): ?>						
						<tr>							
							<td class="label"> <b>EX-C</b> <?php echo $ex_c_row->parameter?>:</td>
							<td><input type="text" name="ex_c_std_value_<?php echo $ex_c_row->parameter_id;?>" value="<?php echo set_value('ex_c_std_value_'.$ex_c_row->parameter_id.'',$ex_c_row->std_value);?>" size="20" readonly /></td>
							<td ><input type="text" name="ex_c_tolarance_<?php echo $ex_c_row->parameter_id;?>" value="<?php echo set_value('ex_c_tolarance_'.$ex_c_row->parameter_id.'',$ex_c_row->tolarance);?>" readonly/></td>
							<td><input type="number" name="ex_c_actual_<?php echo $c;?>" value="<?php echo set_value('ex_c_actual_'.$c.'');?>" maxlength="3" min="1" max="500" <?php echo ($ex_c_row->std_value!=''?"required":""); ?>/>
							</td>
						</tr>
					<?php 
						$c++;
						endforeach;?>
					<tr>
						<td class="label" colspan="4">&nbsp;</td>
					</tr>
					<?php 
						$d=1;
						foreach ($ex_d as $ex_d_row): ?>						
						<tr>							
							<td class="label"> <b>EX-D</b> <?php echo $ex_d_row->parameter?>:</td>
							<td><input type="text" name="ex_d_std_value_<?php echo $ex_d_row->parameter_id;?>" value="<?php echo set_value('ex_d_std_value_'.$ex_d_row->parameter_id.'',$ex_d_row->std_value);?>" size="20" readonly /></td>
							<td ><input type="text" name="ex_d_tolarance_<?php echo $ex_d_row->parameter_id;?>" value="<?php echo set_value('ex_d_tolarance_'.$ex_d_row->parameter_id.'',$ex_d_row->tolarance);?>" readonly/></td>
							<td><input type="number" name="ex_d_actual_<?php echo $d;?>" value="<?php echo set_value('ex_d_actual_'.$d.'');?>" maxlength="3" min="1" max="500" <?php echo ($ex_d_row->std_value!=''?"required":""); ?>/>
							</td>
						</tr>
					<?php 
						$d++;
						endforeach;?>
							

					</table>
			
				</td>
				<td>
					<table>	

						<tr>
							<td class="label">Operator  :</td>
							<td colspan="3"><input type="text" name="operator" id="operator"  size="20" value="<?php echo set_value('operator');?>" maxlength="50" required/></td>
						</tr>

						<tr>
							<td class="label" colspan="4">&nbsp;</td>					
						</tr>
						<tr>
							
							<th class="label">PARAMTERS </th>
							<th class="label">STD </th>
							<th class="label">TOLARANCE </th>
							<th class="label">ACTUAL</th>
							
						</tr>
					<?php 
						$e=1;
						foreach ($ex_e as $ex_e_row): ?>						
						<tr>
							
							<td class="label"> <b>EX-E </b> <?php echo $ex_e_row->parameter?>:</td>
							<td><input type="text" name="ex_e_std_value_<?php echo $ex_e_row->parameter_id;?>" value="<?php echo set_value('ex_e_std_value_'.$ex_e_row->parameter_id.'',$ex_e_row->std_value);?>" size="20" readonly /></td>
							<td ><input type="text" name="ex_e_tolarance_<?php echo $ex_e_row->parameter_id;?>" value="<?php echo set_value('ex_e_tolarance_'.$ex_e_row->parameter_id.'',$ex_e_row->tolarance);?>" readonly/></td>
							<td><input type="number" name="ex_e_actual_<?php echo $e;?>" value="<?php echo set_value('ex_e_actual_'.$e.'');?>" maxlength="3" min="1" max="500" <?php echo ($ex_e_row->std_value!=''?"required":""); ?>/>
							</td>

						</tr>
					<?php 
					$e++;
					endforeach;?>

					<tr>
						<td class="label" colspan="4">&nbsp;</td>
					</tr>

					<?php 
						$f=1;
						foreach ($feed_block as $feed_block_row): ?>						
						<tr>							
							<td class="label"> <b>FEED BLOCK </b> <?php echo $feed_block_row->parameter?>:</td>
							<td><input type="text" name="feed_block_std_value_<?php echo $feed_block_row->parameter_id;?>" value="<?php echo set_value('feed_block_std_value_'.$feed_block_row->parameter_id.'',$feed_block_row->std_value);?>" size="20" readonly /></td>
							<td ><input type="text" name="feed_block_tolarance_<?php echo $feed_block_row->tolarance;?>" value="<?php echo set_value('feed_block_tolarance'.$feed_block_row->parameter_id.'',$feed_block_row->tolarance);?>" readonly/></td>
							<td><input type="number" name="feed_block_actual_<?php echo $f;?>" value="<?php echo set_value('feed_block_actual_'.$f.'');?>" maxlength="3" min="1" max="500" <?php echo ($feed_block_row->std_value!=''?"required":""); ?>/>
							</td>
						</tr>
					<?php 
						$f++;
						endforeach;?>

					<tr>
						<td class="label" colspan="4">&nbsp;</td>
					</tr>
					<?php 
						$g=1;
						foreach ($die_head as $die_head_row): ?>						
						<tr>							
							<td class="label"> <b>DIE HEAD </b> <?php echo $die_head_row->parameter?>:</td>
							<td><input type="text" name="die_head_std_value_<?php echo $die_head_row->parameter_id;?>" value="<?php echo set_value('die_head_std_value_'.$die_head_row->parameter_id.'',$die_head_row->std_value);?>" size="20" readonly /></td>
							<td ><input type="text" name="die_head_tolarance_<?php echo $die_head_row->parameter_id;?>" value="<?php echo set_value('die_head_tolarance'.$die_head_row->parameter_id.'',$die_head_row->tolarance);?>" readonly/></td>
							<td><input type="number" name="die_head_actual_<?php echo $g;?>" value="<?php echo set_value('die_head_actual_'.$g.'');?>" maxlength="3" min="1" max="500" <?php echo ($die_head_row->std_value!=''?"required":""); ?> />
							</td>
						</tr>
					<?php 
					$g++;
					endforeach;?>

					<tr>
						<td class="label" colspan="4">&nbsp;</td>
					</tr>
					<tr>
						<td class="label">TEMPARATURE OF ROLL-1 :</td>
						<td><input type="text" name="roll_temp_1_std" value="<?php echo set_value('roll_temp_1_std','30');?>" readonly /></td>
						<td ><input type="text" name="roll_temp_1_tolarance" value="<?php echo set_value('roll_temp_1_tolarance','+/-10C');?>" readonly/></td>
						<td><input type="number" name="roll_temp_1_actual" value="<?php echo set_value('roll_temp_1_actual');?>" min="1" max="100" required /></td>
							
						
					</tr>
					<tr>
						<td class="label">TEMPARATURE OF ROLL-2 :</td>
						<td><input type="text" name="roll_temp_2_std" value="<?php echo set_value('roll_temp_2_std','30');?>" readonly /></td>
						<td ><input type="text" name="roll_temp_2_tolarance" value="<?php echo set_value('roll_temp_2_tolarance','+/-10C');?>" readonly/></td>
						<td><input type="number" name="roll_temp_2_actual" value="<?php echo set_value('roll_temp_2_actual');?>" min="1" max="100"  /></td>					
						
					</tr>

					<tr>
						<td class="label">TEMPARATURE OF ROLL-3 :</td>
						<td><input type="text" name="roll_temp_3_std" value="<?php echo set_value('roll_temp_3_std','30');?>" readonly /></td>
						<td ><input type="text" name="roll_temp_3_tolarance" value="<?php echo set_value('roll_temp_3_tolarance','+/-10C');?>" readonly/></td>
						<td><input type="number" name="roll_temp_3_actual" value="<?php echo set_value('roll_temp_3_actual');?>" min="1" max="100"  /></td>
						
					</tr>
					<tr>
						<td class="label">THICKNESS :</td>
						<td><input type="text" name="roll_thickness_std" value="<?php echo set_value('roll_thickness_std');?>" /></td>
						<td ><input type="text" name="roll_thickness_tolarance" value="<?php echo set_value('roll_thickness_tolarance','+/-12 MIC');?>" readonly/></td>
						<td><input type="number" name="roll_thickness_actual" value="<?php echo set_value('roll_thickness_actual');?>" min="300" max="700" required /></td>
						
					</tr>
					<tr>
						<td class="label">LENGTH OF ROLL :</td>
						<td><input type="text" name="roll_length_std" value="<?php echo set_value('roll_length_std');?>" /></td>
						<td ><input type="text" name="roll_length_tolarance" value="<?php echo set_value('roll_length_tolarance','+/-10 METERS');?>" readonly/></td>
						<td><input type="number" name="roll_length_actual" value="<?php echo set_value('roll_length_actual');?>" min="300" max="700" required /></td>						
						
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




				
				
				
			