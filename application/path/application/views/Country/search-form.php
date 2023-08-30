
<form name="" action="<?php echo base_url('index.php/country/search_result');?>" method="POST" enctype="multipart/form-data">
	<div class="form_design">
		<?php echo validation_errors();?>
		<?php if(isset($note)){ echo "<p>$note</p>";}?>
		<?php if(isset($error)){ echo "<p>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">
									
									<tr>
										<td class="label">Country Name :</td>
										<td><input type="text" name="lang_country_name" maxlength="64" size="20" value="<?php echo set_value('lang_country_name');?>" />
										</td>
									</tr>
									
									<tr>
										<td class="label">Country Short Id  :</td>
										<td><input type="text" name="country_short_id" maxlength="5" size="20" value="<?php echo set_value('country_short_id');?>" /></td>
									</tr>
									<tr>
										<td class="label">Currency :</td>
										<td><input type="text" name="currency_name" maxlength="64" size="20" value="<?php echo set_value('currency_name');?>"/></td>
									</tr>
									<tr>
										<td class="label">Currency Symbol  :</td>
										<td><input type="text" name="currency_symbol" maxlength="5" size="20" value="<?php echo set_value('currency_symbol');?>"/></td>
									</tr>

									<tr>
										<td class="label">Small Denomination  :</td>
										<td><input type="text" name="currency_small_deno" maxlength="10" size="20" value="<?php echo set_value('currency_small_deno');?>"/></td>
									</tr>


									<tr>
										<td class="label">Country Language :</td>
										<td><select name="language" id="language"><option value=''>--Select Language--</option>
										<?php if($language==FALSE){
														echo "<option value=''>--Language Setup Required--</option>";}
											else{
												foreach($language as $language_row){
													
													echo '<option value="'.$language_row->language_id.'"'.set_select('language',''.$language_row->language_id.'').' >'.$language_row->language_name.'</option>';
												}
										}?>
										</select></td>
									</tr>
					</table>			
								
				</td>
							
			</tr>
		</table>
					
	</div>

	<div class="form_design">
			
		<button class="submit" name="submit">Search</button> <a href="<?php echo base_url('index.php/country');?>">Cancel</a>
	</div>
		
</form>
				
				
				
				
				
			