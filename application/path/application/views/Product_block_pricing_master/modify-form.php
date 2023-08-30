
<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
				<?php foreach($product_block_pricing_master as $row):?>
					<table class="form_table_inner">
						<tr>
							<td class="label">Block Name <span style="color:red;">*</span> :</td>
							<td><input type="text" name="block_name" maxlength="150" size="60" value="<?php echo set_value('block_name',$row->block_name);?>"/>
							<input type="hidden" name="pbpm_id" value="<?php echo $row->pbpm_id;?>" /></td>
						</tr>

						<tr>
							<td class="label">Block From <span style="color:red;">*</span> :</td>
							<td><input type="text" name="block_from" size="10" value="<?php echo set_value('block_from',$this->common_model->read_number($row->block_from,$this->session->userdata['logged_in']['company_id']));?>"  />
							</td>
						</tr>

						<tr>
							<td class="label">Block To <span style="color:red;">*</span> :</td>
							<td><input type="text" name="block_to"  size="10" value="<?php echo set_value('block_to',$this->common_model->read_number($row->block_to,$this->session->userdata['logged_in']['company_id']));?>"  />
							</td>
						</tr>

									
				</table>			
								
				</td>

				
							
			</tr>
		</table>
					<?php endforeach;?>
	</div>

	<div class="form_design">
		<button class="submit" name="submit">Update</button> <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>">Cancel</a>
	</div>
		
</form>
				
				
				
				
				
			