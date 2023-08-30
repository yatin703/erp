<div class="form_design">
	<form name="" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save');?>" method="POST">
	<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
	<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		
			<table class="form_table_design" >
				<tr>
					<td>
						<table class="form_table_inner" >
							<tr>
								<td class="label">Master Property Name <span style="color:red;">*</span> :</td>
								<td><select name="master_property"><option value=''>--Select Master Property--</option>
								<?php 
									if($master_property==FALSE){
										echo "<option value=''>--Setup Required--</option>";
									}else{
										foreach($master_property as $master_property_row){
											echo "<option value='$master_property_row->master_property_id'  ".set_select('master_property',$master_property_row->master_property_id).">$master_property_row->lang_master_property_descr</option>";
										}
									}
								?>
								</select></td>
							</tr>

							<tr>
								<td class="label">Property <span style="color:red;">*</span> :</td>
								<td><input type="text" name="property" maxlength="64" size="50" value="<?php echo set_value('property');?>" /></td>
							</tr>

						</table>
					</td>
				</tr>
			</table>
		<button class="submit" name="submit">Save</button> <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>">Cancel</a>
	</form>
</div>
				
				