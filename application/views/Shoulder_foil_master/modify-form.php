<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST" enctype="multipart/form-data">
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">

							<?php foreach($shoulder_foil_master as $row):?>
									<tr>
										<td class="label">Shoulder Foil <span style="color:red;">* </span> :</td>
										<td>
											<input type="hidden" name='sfm_id' value='<?php echo $row->sfm_id;?>'><select name="shoulder_foil">
										<option value=''>--Select Foil-</option>
										<?php
										foreach ($shoulder_foil as $shoulder_foil_row) {
											$selected=($shoulder_foil_row->article_no==$row->article_no ? 'selected' :'');
											echo "<option value='".$shoulder_foil_row->article_no."' ".set_select('shoulder_foil',$shoulder_foil_row->article_no)." $selected>".$shoulder_foil_row->lang_article_description."</option>";
										}
										?>
										</select>
										</td>
									</tr>


									<tr>
										<td class="label">Sleeve Dia <span style="color:red;">* </span> :</td>
										<td>
											<select name="sleeve_dia" id="sleeve_dia"><option value=''>--Select Sleeve Dia--</option>
										<?php if($sleeve_dia==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($sleeve_dia as $sleeve_dia_row){
												$selected=($sleeve_dia_row->sleeve_id==$row->sleeve_id ? 'selected' :'');
													echo "<option value='".$sleeve_dia_row->sleeve_id."' ".set_select('sleeve_dia',''.$sleeve_dia_row->sleeve_id.'')." $selected >".$sleeve_dia_row->sleeve_diameter."</option>";
												}
										}?></select>
										</td>
									</tr>

									<tr>
										<td class="label">No of Tubes <span style="color:red;">*</span> :</td>
										<td><input type="text" name="no_of_tubes"  value="<?php echo set_value('no_of_tubes',$row->no_of_tubes);?>" /></td>
									</tr>

									<tr>
										<td class="label">Foil Width <span style="color:red;">*</span> :</td>
										<td><input type="text" name="one_roll_width_in_meter"  value="<?php echo set_value('one_roll_width_in_meter',$row->one_roll_width_in_meter);?>" /></td>
									</tr>

									<tr>
										<td class="label">Foil Length <span style="color:red;">*</span> :</td>
										<td><input type="text" name="one_roll_length_in_meter"  value="<?php echo set_value('one_roll_length_in_meter',$row->one_roll_length_in_meter);?>" /></td>
									</tr>

									<tr>
										<td class="label">Area <span style="color:red;">*</span> :</td>
										<td><input type="text" name="one_roll_sqm_area"  value="<?php echo set_value('one_roll_sqm_area',$row->one_roll_sqm_area);?>" /></td>
									</tr>

									<tr>
										<td class="label">Area/Tube <span style="color:red;">*</span> :</td>
										<td><input type="text" name="sqm_per_tube"  value="<?php echo set_value('sqm_per_tube',$row->sqm_per_tube);?>" /></td>
									</tr>
									
							<?php endforeach;?>		

					</table>			
								
				</td>
							
			</tr>
		</table>
					
	</div>

	<div class="form_design">
			
		<button class="submit" name="submit">Update</button> <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>">Cancel</a>
	</div>
		
</form>
				
