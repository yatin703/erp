<div class="form_design">
	
	<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST" enctype="multipart/form-data">
	
	<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
	<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
	<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
			<table class="form_table_design" >
				<tr>
					<td>
						<table class="form_table_inner" >
							<?php foreach($order_close_reasons_master as $row):

								?>
							
							
							<tr>
								<input type="hidden" name="id" value="<?php echo $row->id;?>" readonly>
								<td class="label">Reason <span style="color:red;">*</span> :</td>
								<td><input type="text" name="reasons" maxlength="64" size="50" value="<?php echo set_value('reasons',$row->reasons);?>" /></td>
							</tr>


							<tr>
								<td class="label">Cancel Flag	  :</td>
								<td><input type="checkbox" name="cancel_flag" value="1"  <?php echo set_checkbox('cancel_flag','1');?> <?php echo ($row->cancel_flag==1 ? 'value="1" checked' : 'value="NULL"');?>/></td>
							</tr>

							<tr>
								<td class="label">For Stock	  :</td>
								<td><input type="checkbox" name="for_stock" value="1" <?php echo set_checkbox('for_stock','1');?> <?php echo ($row->for_stock==1 ? 'value="1" checked' : 'value="NULL"');?>/></td>
							</tr>

							<tr>
								<td class="label">For Sample :</td>
								<td><input type="checkbox" name="for_sample" value="1" <?php echo set_checkbox('for_sample','1');?> <?php echo ($row->for_sample==1 ? 'value="1" checked' : 'value="NULL"');?>/></td>
							</tr>

							
							<?php endforeach;?>	
							


						</table>
					</td>
				</tr>
			</table>
		<div class="ui buttons">
	  		<br><a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui positive button"  button class="submit" name="submit">Update</button>
		</div>
	</form>
</div>
				
				