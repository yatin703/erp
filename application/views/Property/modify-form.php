<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST">
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">
									
							<?php foreach ($property as $row):?>
									<tr>
										<td class="label">Master Property <span style="color:red;">*</span> :</td>
										<td><select name="master_property"><option value=''>--Select Master Property--</option>
										<?php 
											if($master_property==FALSE){
												echo "<option value=''>--Setup Required--</option>";
											}else{
												foreach($master_property as $master_property_row){
													$selected=($row->master_property_id===$master_property_row->master_property_id ? 'selected':'');
													echo "<option value='$master_property_row->master_property_id'  $selected >$master_property_row->lang_master_property_descr</option>";
												}
											}
										?>
								</select>
								<input type="hidden" name="property_id" value="<?php echo $row->property_id;?>"></td>
									</tr>

									<tr>
										<td class="label">Property <span style="color:red;">*</span>  :</td>
										<td><input type="text" name="property" value="<?php echo set_value('property',$row->lang_property_name);?>" /></td>
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
				
				
				
				
				
			