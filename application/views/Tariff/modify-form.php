<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST" enctype="multipart/form-data">
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">
									
							<?php foreach ($excise_rates_master as $row):?>
									<tr>
										<td class="label">Rate Id <span style="color:red;">*</span> :</td>
										<td><input type="text" name="erm_id"  value="<?php echo set_value('erm_id',$row->erm_id);?>" readonly />											
										</td>
									</tr>
									<tr>
										<td class="label">Tariff No <span style="color:red;">*</span>  :</td>
										<td><input type="text" name="cetsh_no" maxlength="15" size="20" value="<?php echo set_value('cetsh_no',$row->cetsh_no);?>"/></td>
									</tr>
									<tr>
										<td class="label">Tariff Heading <span style="color:red;">*</span>  :</td>
										<td><input type="text" name="lang_tariff_heading" maxlength="50" size="50" value="<?php echo set_value('lang_tariff_heading',$row->lang_tariff_heading);?>" /></td>
									</tr>
									<tr>
										<td class="label">Tariff Description  :</td>
										<td><input type="text" name="lang_tariff_descr" maxlength="200" size="50" value="<?php echo set_value('lang_tariff_descr',$row->lang_tariff_descr);?>" /></td>
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
				
				
				
				
				
			