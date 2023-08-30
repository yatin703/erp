<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result');?>" method="POST" enctype="multipart/form-data">
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">
									<tr>
										<td class="label">Bank Id :</td>
										<td><input type="text" name="Bank_id"  value="<?php echo set_value('bank_code');?>" /></td>
									</tr>
									<tr>
										<td class="label">Bank Code :</td>
										<td><input type="text" name="bank_code" maxlength="50" size="20" value="<?php echo set_value('bank_code');?>" /></td>
									</tr>
									<tr>
										<td class="label">Bank Name :</td>
										<td><input type="text" name="bank_name" maxlength="50" size="50" value="<?php echo set_value('bank_name');?>" /></td>
									</tr>

									<tr>
										<td class="label">Bank Address  :</td>
										<td><input type="text" name="bank_address" maxlength="200" size="50" value="<?php echo set_value('bank_address');?>" /></td>
									</tr>
									<tr>
										<td class="label">Credit Limit  :</td>
										<td><input type="text" name="od_limit_amount" maxlength="50" size="20" value="<?php echo set_value('od_limit_amount');?>" /></td>
									</tr>		
									
					</table>			
								
				</td>
							
			</tr>
		</table>
					
	</div>

	<div class="form_design">
			
		<button class="submit" name="submit">Search</button> <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>">Cancel</a>
	</div>
		
</form>
				
				
				
				
				
			