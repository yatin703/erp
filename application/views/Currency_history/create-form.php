
<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save');?>" method="POST" enctype="multipart/form-data">
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">

								
								<?php foreach($country_master_lang as $row):?>
									
									<tr>
										<td class="label">Country  <span style="color:red;">*</span> :</td>
										<td>
										
											<input type="hidden" name="country_id" id="country_id"  value="<?php echo $row->country_id;?>" />

											<input type="text" name="lang_country_name" maxlength="10" size="20" value="<?php echo set_value('lang_country_name',$row->lang_country_name);?>" readonly/>
										</td>
									</tr>

								<?php endforeach; ?>	

								<?php foreach($currency_rates_master as $row):?>

									<tr>
										<td class="label">For Currency  <span style="color:red;">*</span> :</td>
										<td><input type="text" name="for_currency" maxlength="10" size="20" value="<?php echo set_value('for_currency',$row->for_currency);?>" readonly/></td>
									</tr>
									<tr>
										<td class="label">To Currency  <span style="color:red;">*</span> :</td>
										<td><input type="text" name="to_currency" maxlength="10" size="20" value="<?php echo set_value('to_currency',$row->to_currency);?>" readonly/></td>
									</tr>
									<tr>
										<td class="label">Exchange Rate :</td>
										<td><input type="number" name="exchange_rate" maxlength="10" size="20" step="any" />
										</td>
									</tr>
									
								<?php endforeach; ?>		
						

					</table>			
								
				</td>
							
			</tr>
		</table>
					
	</div>

	<div class="form_design">
			
		<button class="submit" name="submit">Save</button> <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'/index/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'');?>">Cancel</a>
	</div>
		
</form>
				
				
				
				
				
			