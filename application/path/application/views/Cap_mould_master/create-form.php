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
							<td class="label">Mould Name  <span style="color:red;">*</span> :</td>
							<td><input type="text" name="mould_name" value="<?php echo set_value('mould_name');?>" /></td>
						</tr>

						<tr>
							<td class="label">No of Cavity <span style="color:red;">*</span> :</td>
							<td><input type="text" name="no_of_cavity" value="<?php echo set_value('no_of_cavity');?>" /></td>
						</tr>

						<tr>
							<td class="label">Cycle Time <span style="color:red;">*</span> :</td>
							<td><input type="text" name="cycle_time" value="<?php echo set_value('cycle_time');?>" /></td>
						</tr>

						<tr>
							<td class="label">Runner Weight <span style="color:red;">*</span> :</td>
							<td><input type="text" name="runner_weight" value="<?php echo set_value('runner_weight');?>" /></td>
						</tr>
											
									
					</table>			
								
				</td>
							
			</tr>
		</table>
					
	</div>

	<div class="form_design">
			
		<button class="ui button" name="submit">Save</button> <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>">Cancel</a>
	</div>
		
</form>
				
				
				
				
				
			