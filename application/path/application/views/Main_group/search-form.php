
<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">
									
									<tr> 
										<td class="label">Main Group ID  :</td>
										<td><input type="text" name="main_group_id" maxlength="10" size="10" value="<?php echo set_value('main_group_id');?>" /></td>
									</tr>

									<tr> 
										<td class="label">Main Group Desc  :</td>
										<td><input type="text" name="main_group" maxlength="50" size="20" value="<?php echo set_value('main_group');?>" /></td>
									</tr>

									<tr>
										<td class="label">Short Desc  :</td>
										<td><input type="text" name="short_desc" maxlength="15" size="15" value="<?php echo set_value('short_desc');?>" /></td>
									</tr>

									<tr>
										<td class="label">Category :</td>
										<td><select name="category"><option value=''>--Select Category--</option>
										<?php if($category==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($category as $category_row){
													echo "<option value='".$category_row->category_id."'  ".set_select('category',''.$category_row->category_id.'').">".$category_row->lang_category_name."</option>";
												}
										}?>
										</select></td>
									</tr>

									<tr>
										<td class="label">Tariff :</td>
										<td><select name="tariff"><option value=''>--Select Tariff--</option>
										<?php if($tariff==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($tariff as $tariff_row){
													echo "<option value='".$tariff_row->erm_id."'  ".set_select('tariff',''.$tariff_row->erm_id.'').">".strtoupper($tariff_row->tariff_heading)."-".$tariff_row->cetsh_no."</option>";
												}
										}?>
										</select></td>
									</tr>
									
									<tr>
										<td class="label">Account Head  :</td>
										<td><select name="account_head"><option value=''>--Select Account Head--</option>
										<?php if($account_head==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($account_head as $account_head_row){
													echo "<option value='".$account_head_row->account_head_id."'  ".set_select('account_head',''.$account_head_row->account_head_id.'').">".strtoupper($account_head_row->lang_description)."</option>";
												}
										}?>
										</select></td>
									</tr>

									<tr>
										<td class="label">Sale/Purchase/Other  :</td>
										<td><select name="sales_pur_flag"><option value=''>--Select Type--</option>
														<option value="1" <?php echo  set_select('type', '1'); ?>>Sales</option>
														<option value="0" <?php echo  set_select('type', '0'); ?>>Purchase</option>
														<option value="2" <?php echo  set_select('type', '2'); ?>>Other</option>
										</select></td>
									</tr>

									
									<tr>
										<td class="label">Type  :</td>
										<td><select name="type"><option value=''>--Select Type--</option>
														<option value="1" <?php echo  set_select('type', '1'); ?>>RAW MATERIAL</option>
														<option value="2" <?php echo  set_select('type', '1'); ?>>TRADE MATERIAL</option>
														<option value="3" <?php echo  set_select('type', '1'); ?>>SERVICE</option>
														<option value="4" <?php echo  set_select('type', '1'); ?>>ASSETS</option>
										</select></td>
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
				
				
				
				
				
			