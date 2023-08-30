<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">

							<?php foreach($state as $row):?>
									<tr>
										<td class="label">State Short Id <span style="color:red;">*</span> :</td>
										<td><input type="text" name="zip_code" maxlength="20" size="20" value="<?php echo set_value('zip_code',$row->zip_code);?>" readonly /></td>
									</tr>

									<tr>
										<td class="label">State Name <span style="color:red;">*</span>  :</td>
										<td><input type="text" name="lang_city" maxlength="50" size="20" value="<?php echo set_value('lang_city',$row->lang_city);?>" /></td>
									</tr>

									<tr>
										<td class="label">State GST Code :</td>
										<td><input type="text" name="state_code"  maxlength="5" size="20" value="<?php echo set_value('state_code',$row->state_code);?>" /></td>
									</tr>

									<tr>
										<td class="label">Zone :</td>
										<td><select name="zone_id" id="zone_id"><option value=''>--Select Zone--</option>
										<?php if($zone==FALSE){
														echo "<option value=''>--Zone Setup Required--</option>";}
											else{
												foreach($zone as $zone_row){
													
													$selected=($zone_row->zone_id===$row->zone_id ? 'selected': '');

													echo '<option value="'.$zone_row->zone_id.'" '.$selected.' '.set_select('zone_id',''.$zone_row->zone_id.'').' >'.$zone_row->lang_zone_name.'</option>';
												}
										}?>
										</select></td>
									</tr>

									<tr>
										<td class="label">Country <span style="color:red;">*</span> :</td>
										<td><select name="country_id" id="country_id"><option value=''>--Select Country--</option>
										<?php if($country==FALSE){
														echo "<option value=''>--Country Setup Required--</option>";}
											else{
												foreach($country as $country_row){
													
													$selected=($country_row->country_id===$row->country_id ? 'selected': '');

													echo '<option value="'.$country_row->country_id.'" '.$selected.' '.set_select('country_id',''.$country_row->country_id.'').' >'.$country_row->lang_country_name.'</option>';
												}
										}?>
										</select></td>
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
				
				
				
				
				
			