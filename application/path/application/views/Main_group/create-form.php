
<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">
									
									<tr> 
										<td class="label">Main Group Desc <span style="color:red;">*</span> :</td>
										<td><input type="text" name="main_group" maxlength="50" size="20" value="<?php echo set_value('main_group');?>" /></td>
									</tr>

									<tr>
										<td class="label">Short Desc <span style="color:red;">*</span> :</td>
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
										<td class="label">Account Head <span style="color:red;">*</span> :</td>
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
										<td class="label">Sale/Purchase/Other <span style="color:red;">*</span> :</td>
										<td><select name="sales_pur_flag"><option value=''>--Select Type--</option>
														<option value="1" <?php echo  set_select('type', '1'); ?>>Sales</option>
														<option value="0" <?php echo  set_select('type', '0'); ?>>Purchase</option>
														<option value="2" <?php echo  set_select('type', '2'); ?>>Other</option>
										</select></td>
									</tr>

									<tr>
										<td class="label">Excisable :</td>
										<td><input type="checkbox" name="excise_flag" value="1" <?php echo set_checkbox('excise_flag',1);?> /></td>
									</tr>

									<tr>
										<td class="label">Spars  :</td>
										<td><input type="checkbox" name="spares_flag" value="1" <?php echo set_checkbox('spares_flag',1);?> /></td>
									</tr>

									<tr>
										<td class="label">Type <span style="color:red;">*</span> :</td>
										<td><select name="type"><option value=''>--Select Type--</option>
														<option value="1" <?php echo  set_select('type', '1'); ?>>RAW MATERIAL</option>
														<option value="2" <?php echo  set_select('type', '2'); ?>>TRADE MATERIAL</option>
														<option value="3" <?php echo  set_select('type', '3'); ?>>SERVICE</option>
														<option value="4" <?php echo  set_select('type', '4'); ?>>ASSETS</option>
										</select></td>
									</tr>
				</table>			
								
				</td>

				
							
			</tr>
		</table>
					
	</div>

	<div class="form_design">
		<button class="submit" name="submit">Save</button> <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>">Cancel</a>
	</div>
		
</form>
				
				
				
				
				
			