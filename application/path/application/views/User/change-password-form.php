
<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/change_password_save');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">

						<tr>
							<td class="label">New Password <span style="color:red;">*</span> :</td>
							<td><input type="new_password" name="new_password" value="<?php echo set_value('new_password');?>" />
							</td>
						</tr>
						<tr>
							<td class="label">Confirm Password <span style="color:red;">*</span> :</td>
							<td><input type="confirm_password" name="confirm_password" value="<?php echo set_value('confirm_password');?>" />
							</td>
						</tr>
						
								
					</table>			
								
				</td>
							
			</tr>
		</table>
					
	</div>

	<div class="form_design">
		<button class="submit" name="submit">Update</button> <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>">Cancel</a>
	</div>
		
</form>
				
				
				
				
				
			