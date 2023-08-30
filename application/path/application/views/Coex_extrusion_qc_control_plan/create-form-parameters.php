

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save_parameter');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
		<table class="form_table_design">
			<tr>

				<td width="50%">
					<table class="form_table_inner">

						<tr>
							<td class="label"><b>Date</b><span style="color:red;">*</span> :</td>
							<td><input type="date" name="inspection_date"  size="10" value="<?php echo set_value('inspection_date',date('Y-m-d'));?>" required/></td>
							<td class="label"></td>
							<input type="hidden" name="ceqcp_id" value="<?php echo set_value('ceqcp_id',$this->uri->segment(3));?>">
							<td class="label"><b>Time</b><span style="color:red;">*</span> :</td>
							<td><input type="text" name="time"  size="10" value="<?php echo set_value('time',date('H:i:s'));?>" required></td>
						</tr>

						<tr>
							<td class="label" colspan="2"><b>&nbsp;</td>
							<td class="label"><b><b>MULTI LAYER</td>
							<td class="label"><b>&nbsp;</td>
							<td class="label"><b>&nbsp;</td>
						</tr>

						<tr>
							<td class="label" colspan="2"><b>PARAMETER</td>
							<td class="label"><b>STD</td>
							<td class="label"><b>TOLERANCE</td>
							<td class="label"><b>ACTUAL </td>
						</tr>

						<tr>
							<td colspan="2"><b>&nbsp;</td>
							<td><b>&nbsp;</td>
							<td><b>&nbsp;</td>
							<td><b>&nbsp;</td>
						</tr>

						<tr>
							<td class="label"><b>Extruder 1</td>
							<td class="label">Hooper Throat</td>
							<td><input type="text" name="extruder_1_hooper_throat_std" size="10" value="<?php echo set_value('extruder_1_hooper_throat_std');?>"></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="extruder_1_hooper_throat_actual" size="10" value="<?php echo set_value('extruder_1_hooper_throat_actual');?>"></td>
						</tr>

						<tr>
							<td class="label">&nbsp;</td>
							<td class="label">Zone-01</td>
							<td><input type="text" name="extruder_1_zone_1_std" size="10" value="<?php echo set_value('extruder_1_zone_1_std');?>"></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="extruder_1_zone_1_actual" size="10" value="<?php echo set_value('extruder_1_zone_1_actual');?>"></td>
						</tr>

						<tr>
							<td class="label">&nbsp;</td>
							<td class="label">Zone-02</td>
							<td><input type="text" name="extruder_1_zone_2_std" size="10" value="<?php echo set_value('extruder_1_zone_2_std');?>" required></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="extruder_1_zone_2_actual" size="10" value="<?php echo set_value('extruder_1_zone_2_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label">&nbsp;</td>
							<td class="label">Zone-03</td>
							<td><input type="text" name="extruder_1_zone_3_std" size="10" value="<?php echo set_value('extruder_1_zone_3_std');?>" required></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="extruder_1_zone_3_actual" size="10" value="<?php echo set_value('extruder_1_zone_3_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label">&nbsp;</td>
							<td class="label">Zone-04</td>
							<td><input type="text" name="extruder_1_zone_4_std" size="10" value="<?php echo set_value('extruder_1_zone_4_std');?>" required></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="extruder_1_zone_4_actual" size="10" value="<?php echo set_value('extruder_1_zone_4_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label">&nbsp;</td>
							<td class="label">Zone-06</td>
							<td><input type="text" name="extruder_1_zone_6_std" size="10" value="<?php echo set_value('extruder_1_zone_6_std');?>" required></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="extruder_1_zone_6_actual" size="10" value="<?php echo set_value('extruder_1_zone_6_actual');?>" required></td>
						</tr>


						<tr>
							<td class="label"><b>Extruder 2</td>
							<td>Hooper Throat</td>
							<td><input type="text" name="extruder_2_hooper_throat_std" size="10" value="<?php echo set_value('extruder_2_hooper_throat_std');?>" required></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="extruder_2_hooper_throat_actual" size="10" value="<?php echo set_value('extruder_2_hooper_throat_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label">&nbsp;</td>
							<td class="label">Zone-01</td>
							<td><input type="text" name="extruder_2_zone_1_std" size="10" value="<?php echo set_value('extruder_2_zone_1_std');?>" required></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="extruder_2_zone_1_actual" size="10" value="<?php echo set_value('extruder_2_zone_1_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label">&nbsp;</td>
							<td class="label">Zone-02</td>
							<td><input type="text" name="extruder_2_zone_2_std" size="10" value="<?php echo set_value('extruder_2_zone_2_std');?>" required></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="extruder_2_zone_2_actual" size="10" value="<?php echo set_value('extruder_2_zone_2_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label">&nbsp;</td>
							<td class="label">Zone-03</td>
							<td><input type="text" name="extruder_2_zone_3_std" size="10" value="<?php echo set_value('extruder_2_zone_3_std');?>" required></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="extruder_2_zone_3_actual" size="10" value="<?php echo set_value('extruder_2_zone_3_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label">&nbsp;</td>
							<td class="label">Zone-04</td>
							<td><input type="text" name="extruder_2_zone_4_std" size="10" value="<?php echo set_value('extruder_2_zone_4_std');?>" required></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="extruder_2_zone_4_actual" size="10" value="<?php echo set_value('extruder_2_zone_4_actual');?>" required></td>
						</tr>


						<tr>
							<td class="label"><b>Extruder 3</td>
							<td>Hooper Throat</td>
							<td><input type="text" name="extruder_3_hooper_throat_std" size="10" value="<?php echo set_value('extruder_3_hooper_throat_std');?>" required></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="extruder_3_hooper_throat_actual" size="10" value="<?php echo set_value('extruder_3_hooper_throat_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label">&nbsp;</td>
							<td class="label">Zone-01</td>
							<td><input type="text" name="extruder_3_zone_1_std" size="10" value="<?php echo set_value('extruder_3_zone_1_std');?>" required></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="extruder_3_zone_1_actual" size="10" value="<?php echo set_value('extruder_3_zone_1_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label">&nbsp;</td>
							<td class="label">Zone-02</td>
							<td><input type="text" name="extruder_3_zone_2_std" size="10" value="<?php echo set_value('extruder_3_zone_2_std');?>" required></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="extruder_3_zone_2_actual" size="10" value="<?php echo set_value('extruder_3_zone_2_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label">&nbsp;</td>
							<td class="label">Zone-03</td>
							<td><input type="text" name="extruder_3_zone_3_std" size="10" value="<?php echo set_value('extruder_3_zone_3_std');?>" required></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="extruder_3_zone_3_actual" size="10" value="<?php echo set_value('extruder_3_zone_3_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label">&nbsp;</td>
							<td class="label">Zone-04</td>
							<td><input type="text" name="extruder_3_zone_4_std" size="10" value="<?php echo set_value('extruder_3_zone_4_std');?>" required></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="extruder_3_zone_4_actual" size="10" value="<?php echo set_value('extruder_3_zone_4_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label"><b>Extruder 4</td>
							<td>Hooper Throat</td>
							<td><input type="text" name="extruder_4_hooper_throat_std" size="10" value="<?php echo set_value('extruder_4_hooper_throat_std');?>" required></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="extruder_4_hooper_throat_actual" size="10" value="<?php echo set_value('extruder_4_hooper_throat_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label">&nbsp;</td>
							<td class="label">Zone-01</td>
							<td><input type="text" name="extruder_4_zone_1_std" size="10" value="<?php echo set_value('extruder_4_zone_1_std');?>" required></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="extruder_4_zone_1_actual" size="10" value="<?php echo set_value('extruder_4_zone_1_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label">&nbsp;</td>
							<td class="label">Zone-02</td>
							<td><input type="text" name="extruder_4_zone_2_std" size="10" value="<?php echo set_value('extruder_4_zone_2_std');?>" required></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="extruder_4_zone_2_actual" size="10" value="<?php echo set_value('extruder_4_zone_2_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label">&nbsp;</td>
							<td class="label">Zone-03</td>
							<td><input type="text" name="extruder_4_zone_3_std" size="10" value="<?php echo set_value('extruder_4_zone_3_std');?>" required></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="extruder_4_zone_3_actual" size="10" value="<?php echo set_value('extruder_4_zone_3_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label">&nbsp;</td>
							<td class="label">Zone-04</td>
							<td><input type="text" name="extruder_4_zone_4_std" size="10" value="<?php echo set_value('extruder_4_zone_4_std');?>" required></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="extruder_4_zone_4_actual" size="10" value="<?php echo set_value('extruder_4_zone_4_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label">&nbsp;</td>
							<td class="label">Zone-05</td>
							<td><input type="text" name="extruder_4_zone_5_std" size="10" value="<?php echo set_value('extruder_4_zone_5_std');?>" required></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="extruder_4_zone_5_actual" size="10" value="<?php echo set_value('extruder_4_zone_5_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label">&nbsp;</td>
							<td class="label">Zone-06</td>
							<td><input type="text" name="extruder_4_zone_6_std" size="10" value="<?php echo set_value('extruder_4_zone_6_std');?>" required></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="extruder_4_zone_6_actual" size="10" value="<?php echo set_value('extruder_4_zone_6_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label">Die Head</td>
							<td class="label">Zone-06</td>
							<td><input type="text" name="die_head_zone_6_std" size="10" value="<?php echo set_value('die_head_zone_6_std');?>" required></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="die_head_zone_6_actual" size="10" value="<?php echo set_value('die_head_zone_6_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label">&nbsp;</td>
							<td class="label">Zone-07</td>
							<td><input type="text" name="die_head_zone_7_std" size="10" value="<?php echo set_value('die_head_zone_7_std');?>" required></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="die_head_zone_7_actual" size="10" value="<?php echo set_value('die_head_zone_7_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label">&nbsp;</td>
							<td class="label">Zone-08</td>
							<td><input type="text" name="die_head_zone_8_std" size="10" value="<?php echo set_value('die_head_zone_8_std');?>" required></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="die_head_zone_8_actual" size="10" value="<?php echo set_value('die_head_zone_8_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label">&nbsp;</td>
							<td class="label">Zone-09</td>
							<td><input type="text" name="die_head_zone_9_std" size="10" value="<?php echo set_value('die_head_zone_9_std');?>" required></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="die_head_zone_9_actual" size="10" value="<?php echo set_value('die_head_zone_9_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label">&nbsp;</td>
							<td class="label">Zone-10</td>
							<td><input type="text" name="die_head_zone_10_std" size="10" value="<?php echo set_value('die_head_zone_10_std');?>" required></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="die_head_zone_10_actual" size="10" value="<?php echo set_value('die_head_zone_10_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label">&nbsp;</td>
							<td class="label">Zone-11</td>
							<td><input type="text" name="die_head_zone_11_std" size="10" value="<?php echo set_value('die_head_zone_11_std');?>" required></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="die_head_zone_11_actual" size="10" value="<?php echo set_value('die_head_zone_11_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label">Screw RPM</td>
							<td class="label">Outer Layer</td>
							<td><input type="text" name="screw_rpm_outer_layer_std" size="10" value="<?php echo set_value('screw_rpm_outer_layer_std');?>" required></td>
							<td class="label">+/- 3 RPM</td>
							<td><input type="text" name="screw_rpm_outer_layer_actual" size="10" value="<?php echo set_value('screw_rpm_outer_layer_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label"></td>
							<td class="label">Admer Layer</td>
							<td><input type="text" name="screw_rpm_admer_layer_std" size="10" value="<?php echo set_value('screw_rpm_admer_layer_std');?>" required></td>
							<td class="label">+/- 3 RPM</td>
							<td><input type="text" name="screw_rpm_admer_layer_actual" size="10" value="<?php echo set_value('screw_rpm_admer_layer_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label"></td>
							<td class="label">Evoh Layer</td>
							<td><input type="text" name="screw_rpm_evoh_layer_std" size="10" value="<?php echo set_value('screw_rpm_evoh_layer_std');?>" required></td>
							<td class="label">+/- 3 RPM</td>
							<td><input type="text" name="screw_rpm_evoh_layer_actual" size="10" value="<?php echo set_value('screw_rpm_evoh_layer_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label"></td>
							<td class="label">Inner Layer</td>
							<td><input type="text" name="screw_rpm_inner_layer_std" size="10" value="<?php echo set_value('screw_rpm_inner_layer_std');?>" required></td>
							<td class="label">+/- 3 RPM</td>
							<td><input type="text" name="screw_rpm_inner_layer_actual" size="10" value="<?php echo set_value('screw_rpm_inner_layer_actual');?>" required></td>
						</tr>

						<tr>
							<td colspan="2">&nbsp;</td>
							<td colspan="3"><b>MONOLAYER</td>
						</tr>

						

						<tr>
							<td class="label">Temperature</td>
							<td class="label">Z1</td>
							<td><input type="text" name="temp_z1_std" size="10" value="<?php echo set_value('temp_z1_std');?>" required></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="temp_z1_actual" size="10" value="<?php echo set_value('temp_z1_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label"></td>
							<td class="label">Z2</td>
							<td><input type="text" name="temp_z2_std" size="10" value="<?php echo set_value('temp_z2_std');?>" required></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="temp_z2_actual" size="10" value="<?php echo set_value('temp_z2_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label"></td>
							<td class="label">Z3</td>
							<td><input type="text" name="temp_z3_std" size="10" value="<?php echo set_value('temp_z3_std');?>" required></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="temp_z3_actual" size="10" value="<?php echo set_value('temp_z3_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label"></td>
							<td class="label">Z4</td>
							<td><input type="text" name="temp_z4_std" size="10" value="<?php echo set_value('temp_z4_std');?>" required></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="temp_z4_actual" size="10" value="<?php echo set_value('temp_z4_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label"></td>
							<td class="label">Z5</td>
							<td><input type="text" name="temp_z5_std" size="10" value="<?php echo set_value('temp_z5_std');?>" required></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="temp_z5_actual" size="10" value="<?php echo set_value('temp_z5_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label"></td>
							<td class="label">Z6</td>
							<td><input type="text" name="temp_z6_std" size="10" value="<?php echo set_value('temp_z6_std');?>" required></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="temp_z6_actual" size="10" value="<?php echo set_value('temp_z6_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label"></td>
							<td class="label">Z7</td>
							<td><input type="text" name="temp_z7_std" size="10" value="<?php echo set_value('temp_z7_std');?>" required></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="temp_z7_actual" size="10" value="<?php echo set_value('temp_z7_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label"></td>
							<td class="label">Z8</td>
							<td><input type="text" name="temp_z8_std" size="10" value="<?php echo set_value('temp_z8_std');?>" required></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="temp_z8_actual" size="10" value="<?php echo set_value('temp_z8_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label"></td>
							<td class="label">Z9</td>
							<td><input type="text" name="temp_z9_std" size="10" value="<?php echo set_value('temp_z9_std');?>" required></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="temp_z9_actual" size="10" value="<?php echo set_value('temp_z9_actual');?>" required></td>
						</tr>

						

					</table>
			
				</td>
				
				<td>
					<table>
						

						<tr>
							<td class="label"><b>Job Card</b><span style="color:red;">*</span> :</td>
							<td class="label"><input type="text" name="jobcard_no" size="12" value="<?php echo set_value('jobcard_no',$this->uri->segment(4));?>" required></td>
							<td colspan="3"></td>
						</tr>

						<tr>
							<td colspan="5">&nbsp;</td>
						</tr>

						<tr>
							<td class="label" colspan="2"><b>PARAMETER</td>
							<td class="label"><b>STD</td>
							<td class="label"><b>TOLERANCE</td>
							<td class="label"><b>ACTUAL</td>
						</tr>

						<tr>
							<td colspan="5">&nbsp;</td>
						</tr>

						<tr>
							<td class="label">Screw RPM</td>
							<td class="label">Outer Layer</td>
							<td><input type="text" name="screw_rpm_outer_layer_std" size="10" value="<?php echo set_value('screw_rpm_outer_layer_std');?>" required></td>
							<td class="label">+/- 3 RPM</td>
							<td><input type="text" name="screw_rpm_outer_layer_actual" size="10" value="<?php echo set_value('screw_rpm_outer_layer_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label"></td>
							<td class="label">Admer Layer</td>
							<td><input type="text" name="screw_rpm_admer_layer_std" size="10" value="<?php echo set_value('screw_rpm_admer_layer_std');?>" required></td>
							<td class="label">+/- 3 RPM</td>
							<td><input type="text" name="screw_rpm_admer_layer_actual" size="10" value="<?php echo set_value('screw_rpm_admer_layer_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label"></td>
							<td class="label">Evoh Layer</td>
							<td><input type="text" name="screw_rpm_evoh_layer_std" size="10" value="<?php echo set_value('screw_rpm_evoh_layer_std');?>" required></td>
							<td class="label">+/- 3 RPM</td>
							<td><input type="text" name="screw_rpm_evoh_layer_actual" size="10" value="<?php echo set_value('screw_rpm_evoh_layer_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label"></td>
							<td class="label">Inner Layer</td>
							<td><input type="text" name="screw_rpm_inner_layer_std" size="10" value="<?php echo set_value('screw_rpm_inner_layer_std');?>" required></td>
							<td class="label">+/- 3 RPM</td>
							<td><input type="text" name="screw_rpm_inner_layer_actual" size="10" value="<?php echo set_value('screw_rpm_inner_layer_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label">Vacuum</td>
							<td class="label">Tank 1</td>
							<td><input type="text" name="vacuum_tank_1_std" size="10" value="<?php echo set_value('vacuum_tank_1_std');?>" required></td>
							<td class="label">+/- 0.2 KPA</td>
							<td><input type="text" name="vacuum_tank_1_actual" size="10" value="<?php echo set_value('vacuum_tank_1_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label"></td>
							<td class="label">Tank 2</td>
							<td><input type="text" name="vacuum_tank_2_std" size="10" value="<?php echo set_value('vacuum_tank_2_std');?>" required></td>
							<td class="label">+/- 0.2 KPA</td>
							<td><input type="text" name="vacuum_tank_2_actual" size="10" value="<?php echo set_value('vacuum_tank_2_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label">Water Temp</td>
							<td class="label">Tank 1</td>
							<td><input type="text" name="water_temp_tank_1_std" size="10" value="<?php echo set_value('water_temp_tank_1_std');?>" required></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="water_temp_tank_1_actual" size="10" value="<?php echo set_value('water_temp_tank_1_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label"></td>
							<td class="label">Tank 2</td>
							<td><input type="text" name="water_temp_tank_2_std" size="10" value="<?php echo set_value('water_temp_tank_2_std');?>" required></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="water_temp_tank_2_actual" size="10" value="<?php echo set_value('water_temp_tank_2_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label">Annealing Water Temp</td>
							<td class="label">T2</td>
							<td><input type="text" name="annealing_water_temp_t2_std" size="10" value="<?php echo set_value('annealing_water_temp_t2_std');?>" required></td>
							<td class="label">+/- 10* C</td>
							<td><input type="text" name="annealing_water_temp_t2_actual" size="10" value="<?php echo set_value('annealing_water_temp_t2_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label">Cutting Setting Value</td>
							<td></td>
							<td><input type="text" name="cutting_setting_value_std" size="10" value="<?php echo set_value('cutting_setting_value_std');?>" required></td>
							<td class="label"></td>
							<td><input type="text" name="cutting_setting_value_atual" size="10" value="<?php echo set_value('cutting_setting_value_atual');?>" required></td>
						</tr>
						
						<tr>
							<td class="label">Calibrator Water Cooling Level</td>
							<td class="label">D4</td>
							<td><input type="text" name="calibrator_water_d4_std" size="10" value="<?php echo set_value('calibrator_water_d4_std');?>" required></td>
							<td class="label">+/- 1L/Min</td>
							<td><input type="text" name="calibrator_water_d4_actual" size="10" value="<?php echo set_value('calibrator_water_d4_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label"></td>
							<td class="label">D5</td>
							<td><input type="text" name="calibrator_water_d5_std" size="10" value="<?php echo set_value('calibrator_water_d5_std');?>" required></td>
							<td class="label">+/- 1L/Min</td>
							<td><input type="text" name="calibrator_water_d5_actual" size="10" value="<?php echo set_value('calibrator_water_d5_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label"></td>
							<td class="label">D6</td>
							<td><input type="text" name="calibrator_water_d6_std" size="10" value="<?php echo set_value('calibrator_water_d6_std');?>" required></td>
							<td class="label">+/- 1L/Min</td>
							<td><input type="text" name="calibrator_water_d6_actual" size="10" value="<?php echo set_value('calibrator_water_d6_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label"></td>
							<td class="label">D7</td>
							<td><input type="text" name="calibrator_water_d7_std" size="10" value="<?php echo set_value('calibrator_water_d7_std');?>" required></td>
							<td class="label">+/- 1L/Min</td>
							<td><input type="text" name="calibrator_water_d7_actual" size="10" value="<?php echo set_value('calibrator_water_d7_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label"></td>
							<td class="label">D8</td>
							<td><input type="text" name="calibrator_water_d8_std" size="10" value="<?php echo set_value('calibrator_water_d8_std');?>" required></td>
							<td class="label">+/- 1L/Min</td>
							<td><input type="text" name="calibrator_water_d8_actual" size="10" value="<?php echo set_value('calibrator_water_d8_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label">Annealing Zone</td>
							<td class="label">D9</td>
							<td><input type="text" name="annealing_zone_d9_std" size="10" value="<?php echo set_value('annealing_zone_d9_std');?>" required></td>
							<td class="label">+/- 1L/Min</td>
							<td><input type="text" name="annealing_zone_d9_actual" size="10" value="<?php echo set_value('annealing_zone_d9_actual');?>" required></td>
						</tr>
						<tr>
							<td class="label">Annealing Zone</td>
							<td class="label">D10</td>
							<td><input type="text" name="annealing_zone_d10_std" size="10" value="<?php echo set_value('annealing_zone_d10_std');?>" required></td>
							<td class="label">+/- 1L/Min</td>
							<td><input type="text" name="annealing_zone_d10_actual" size="10" value="<?php echo set_value('annealing_zone_d10_actual');?>" required></td>
						</tr>
						<tr>
							<td class="label">Zumbac Value</td>
							<td class="label"><i>It subject to change diameter wise  and print type wise</i></td>
							<td><input type="text" name="zumbac_value_std" size="10" value="<?php echo set_value('zumbac_value_std');?>" required></td>
							<td class="label">-----</td>
							<td><input type="text" name="zumbac_value_actual" size="10" value="<?php echo set_value('zumbac_value_actual');?>" required></td>
						</tr>
						<tr>
							<td class="label">Length Observed</td>
							<td class="label"><i>As per Specification</td>
							<td><input type="text" name="length_observed_std" size="10" value="<?php echo set_value('length_observed_std');?>" required></td>
							<td class="label">+/- 1.0 mm</td>
							<td><input type="text" name="length_observed_actual" size="10" value="<?php echo set_value('length_observed_actual');?>" required></td>
						</tr>
						<tr>
							<td class="label">Outer Diameter</td>
							<td class="label"><i>As per Specification</td>
							<td><input type="text" name="outer_diameter_std" size="10" value="<?php echo set_value('outer_diameter_std');?>" required></td>
							<td class="label">+/- 1.0 mm</td>
							<td><input type="text" name="outer_diameter_actual" size="10" value="<?php echo set_value('outer_diameter_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label">Inner Diameter</td>
							<td class="label"><i>As per Specification</td>
							<td><input type="text" name="inner_diameter_std" size="10" value="<?php echo set_value('inner_diameter_std');?>" required></td>
							<td class="label">+/- 1.0 mm</td>
							<td><input type="text" name="inner_diameter_actual" size="10" value="<?php echo set_value('inner_diameter_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label">Thickness</td>
							<td class="label"><i>As per Specification</td>
							<td><input type="text" name="thickness_std" size="10" value="<?php echo set_value('thickness_std');?>" required></td>
							<td class="label">+/- 15 Mic</td>
							<td><input type="text" name="thickness_actual" size="10" value="<?php echo set_value('thickness_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label">Weight</td>
							<td class="label"><i>As per Formula</td>
							<td><input type="text" name="weight_std" size="10" value="<?php echo set_value('weight_std');?>" required></td>
							<td class="label">+/ 0.2 GM</td>
							<td><input type="text" name="weight_actual" size="10" value="<?php echo set_value('weight_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label">Hourly Sign Tube</td>
							<td class="label"><i>Should be Sign Availabel on Machine</td>
							<td><input type="text" name="hourly_sign_tube_std" size="10" value="<?php echo set_value('hourly_sign_tube_std');?>" required></td>
							<td class="label"></td>
							<td><input type="text" name="hourly_sign_tube_actual" size="10" value="<?php echo set_value('hourly_sign_tube_actual');?>" required></td>
						</tr>

						<tr>
							<td class="label">Checked by Operator</td>
							<td class="label"></td>
							<td></td>
							<td class="label"></td>
							<td><input type="text" name="checked_by_operator" size="10" value="<?php echo set_value('checked_by_operator');?>" required></td>
						</tr>

						<tr>
							<td class="label">Verified by QC</td>
							<td class="label"></td>
							<td></td>
							<td class="label"></td>
							<td><input type="text" name="verified_by_qc" size="10" value="<?php echo set_value('verified_by_qc');?>" required></td>
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




				
				
				
			