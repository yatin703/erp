<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST" enctype="multipart/form-data">
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">
									
							<?php foreach ($uom as $row):?>
									<tr>
										<td class="label">UOM Id <span style="color:red;">*</span> :</td>
										<td><input type="text" name="uom_id"  value="<?php echo set_value('uom_id',$row->uom_id);?>" readonly /></td>
									</tr>
									<tr>
										<td class="label">Description <span style="color:red;">*</span>  :</td>
										<td><input type="text" name="lang_uom_desc" maxlength="50" size="20" value="<?php echo set_value('lang_uom_desc',$row->lang_uom_desc);?>" /></td>
									</tr>
									<tr>
										<td class="label">Short Id :</td>
										<td><input type="text" name="lang_uom_short" maxlength="50" size="50" value="<?php echo set_value('lang_uom_short',$row->lang_uom_short);?>" /></td>
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
				
				
				
				
				
			