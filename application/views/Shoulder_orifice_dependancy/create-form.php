<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save');?>" method="POST" enctype="multipart/form-data">
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">
									
									<tr>
										<td class="label">Sleeve Diameter   :</td>
										<td><select name="sleeve_id" id="sleeve_id">
											<option value=''>--Select Sleeve Dia--</option>
										<?php if($sleeve_diameter_master==FALSE){
														echo "<option value=''>--Sleeve Dia Setup Required--</option>";}
											else{
												foreach($sleeve_diameter_master as $row){
													
													echo '<option value="'.$row->sleeve_id.'"'.set_select('sleeve_id',''.$row->sleeve_id.'').' >'.$row->sleeve_diameter.'</option>';
												}
										}?>
										</select></td>
									</tr>
									<tr>	
										<td class="label">Shoulder Type  :</td>
										<td><select name="shld_type_id" id="shld_type_id">
											<option value=''>--Select Shoulder Type--</option>
										<?php if($shoulder_types_master==FALSE){
													echo "<option value=''>--Shoulder Type Setup Required--</option>";}
											else{
												foreach($shoulder_types_master as $row){
													
													echo '<option value="'.$row->shld_type_id.'"'.set_select('shld_type_id',''.$row->shld_type_id.'').' >'.$row->shoulder_type.'</option>';
												}
										}?>
										</select></td>
									</tr>
									<tr>	
										<td class="label">Shoulder Orifice  :</td>
										<td><select name="shld_orifice_id" id="shld_orifice_id">
											<option value=''>--Select Shoulder Orifice--</option>
										<?php if($shoulder_orifice_master==FALSE){
													echo "<option value=''>--Shoulder Orifice Setup Required--</option>";}
											else{
												foreach($shoulder_orifice_master as $row){
													
													echo '<option value="'.$row->orifice_id.'"'.set_select('orifice_id',''.$row->orifice_id.'').' >'.$row->shoulder_orifice.'</option>';
												}
										}?>
										</select></td>
									</tr>
									<tr>
										<td class="label">Cap Diameter  :</td>
										<td><select name="cap_dia_id" id="cap_dia_id">
											<option value=''>--Select Cap Dia--</option>
										<?php if($cap_diameter_master==FALSE){
														echo "<option value=''>--Cap Dia Setup Required--</option>";}
											else{
												foreach($cap_diameter_master as $row){
													
													echo '<option value="'.$row->cap_dia_id.'"'.set_select('cap_dia_id',''.$row->cap_dia_id.'').' >'.$row->cap_dia.'</option>';
												}
										}?>
										</select></td>
									</tr>
									<tr>	
										<td class="label">Cap Orifice  :</td>
										<td><select name="cap_orifice_id" id="cap_orifice_id">
											<option value=''>--Select Cap Orifice--</option>
										<?php if($cap_orifice_master==FALSE){
													echo "<option value=''>--Cap Orifice Setup Required--</option>";}
											else{
												foreach($cap_orifice_master as $row){
													
													echo '<option value="'.$row->cap_orifice_id.'"'.set_select('cap_orifice_id',''.$row->cap_orifice_id.'').' >'.$row->cap_orifice.'</option>';
												}
										}?>
										</select></td>
									</tr>

									<tr>	
										<td class="label">Cap Type  :</td>
										<td><select name="cap_type_id" id="cap_type_id">
											<option value=''>--Select Cap Type--</option>
										<?php if($cap_types_master==FALSE){
													echo "<option value=''>--Cap Type Setup Required--</option>";}
											else{
												foreach($cap_types_master as $row){
													
													echo '<option value="'.$row->cap_type_id.'"'.set_select('cap_type_id',''.$row->cap_type_id.'').' >'.$row->cap_type.'</option>';
												}
										}?>
										</select></td>
									</tr>
									<tr>	
										<td class="label">Cap Finish  :</td>
										<td><select name="cap_finish_id" id="cap_finish_id">
											<option value=''>--Select Cap Finish--</option>
										<?php if($cap_finish_master==FALSE){
													echo "<option value=''>--Cap Finish Setup Required--</option>";}
											else{
												foreach($cap_finish_master as $row){
													
													echo '<option value="'.$row->cap_finish_id.'"'.set_select('cap_finish_id',''.$row->cap_finish_id.'').' >'.$row->cap_finish.'</option>';
												}
										}?>
										</select></td>
									</tr>
									<tr>
										<td class="label">Cap No. :</td>
										<td><input type="number" name="cap_no" id="cap_no" size="20"  maxlength="5" value="<?php echo set_value('cap_no'); ?>" /></td>

									</tr>
									<tr>
										<td class="label">Shoulder Weight  :</td>
										<td><input type="text" name="shld_weight" id="shld_weight" size="20"  maxlength="5" value="<?php echo set_value('shld_weight'); ?>" /></td>

									</tr>
									<tr>
										<td class="label">Cap Height  :</td>
										<td><input type="text" name="cap_height" id="cap_height" size="20"  maxlength="5" value="<?php echo set_value('cap_height'); ?>" /></td>

									</tr>
									<tr>
										<td class="label">Cap Weight  :</td>
										<td><input type="text" name="cap_weight" id="cap_weight" size="20"  maxlength="5" value="<?php echo set_value('cap_weight'); ?>" /></td>

									</tr>

									
					</table>			
								
				</td>
							
			</tr>
		</table>
					
	</div>

	<div class="form_design">
			
		<button class="submit" name="submit">Save</button> <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>">Cancel</a>
	</div>
		
</form>
				
				
				
				
				
			