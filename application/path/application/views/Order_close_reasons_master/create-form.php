<div class="form_design">
	<form name="" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save');?>" method="POST">
	<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
	<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		
			<table class="form_table_design" >
				<tr>
					<td>
						<table class="form_table_inner" >
							
							<tr>
								<td class="label">Reason <span style="color:red;">*</span> :</td>
								<td><input type="text" name="reasons" maxlength="64" size="50" value="<?php echo set_value('reasons');?>" /></td>
							</tr>

							<tr>
								<td class="label">Cancel Flag  :</td>
								<td><input type="checkbox" name="cancel_flag" value="1"  <?php echo set_checkbox('cancel_flag','1',TRUE);?> /></td>
							</tr>

							<tr>
								<td class="label">For Stock	 :</td>
								<td><input type="checkbox" name="for_stock" value="1" <?php echo set_checkbox('for_stock','1');?>/></td>
							</tr>

							<tr>
								<td class="label">For Sample :</td>
								<td><input type="checkbox" name="for_sample" value="1" <?php echo set_checkbox('for_sample','1');?>/></td>
							</tr>

							


						</table>
					</td>
				</tr>
			</table>
		
			
		

		<div class="ui buttons">
	  		<br><a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui positive button" ;">Save</button>
			</div>

	
	</form>
</div>
				
				