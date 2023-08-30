<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">

							<?php foreach($country_master as $row):?>

									<tr>
										<td class="label">Country Name <span style="color:red;">*</span> :</td>
										<td><input type="text" name="lang_country_name" maxlength="64" size="20" value="<?php echo set_value('lang_country_name',$row->lang_country_name);?>" />
										<input type="hidden" name="country_id"  value="<?php echo set_value('country_id',$row->country_id);?>" />
										</td>
									</tr>
							<!--<?php endforeach;?>

							<?php foreach($country_master as $row):?>-->

									<tr>
										<td class="label">Country Short Id  :</td>
										<td><input type="text" name="country_short_id" maxlength="5" size="20" value="<?php echo set_value('country_short_id',$row->country_short_id);?>" /></td>
									</tr>
									<tr>
										<td class="label">Currency <span style="color:red;">*</span> :</td>
										<td><input type="text" name="currency_name" maxlength="64" size="20" value="<?php echo set_value('currency_name',$row->currency_name);?>"/></td>
									</tr>
									<tr>
										<td class="label">Currency Symbol  :</td>
										<td><input type="text" name="currency_symbol"  value="<?php echo set_value('currency_symbol',$row->currency_symbol);?>"/></td>
									</tr>

									<tr>
										<td class="label">Small Denomination  :</td>
										<td><input type="text" name="currency_small_deno" maxlength="10" size="20" value="<?php echo set_value('currency_small_deno',$row->currency_small_deno);?>"/></td>
									</tr>


									<tr>
										<td class="label">Country Language :</td>
										<td><select name="language" id="language"><option value=''>--Select Language--</option>
										<?php if($language==FALSE){
														echo "<option value=''>--Language Setup Required--</option>";}
											else{
												foreach($language as $language_row){

													$selected=($row->country_language_id===$language_row->language_id ? 'selected': '');
													
													echo '<option value="'.$language_row->language_id.'" '.$selected.' '.set_select('language',''.$language_row->language_id.'').' >'.$language_row->language_name.'</option>';
												}
										}?>
										</select></td>
									</tr>

							<?php endforeach;?>	
								
					</table>			
								
				</td>
							
			</tr>
		</table>
					
	</div>

	<div class="form_design">
			
		<button class="submit" name="submit">Update</button> <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>">Back</a>
	</div>
		
</form>
				
				
				
				
				
			