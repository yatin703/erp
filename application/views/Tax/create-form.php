<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save');?>" method="POST" enctype="multipart/form-data">
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">
									
									<tr>
										<td class="label">Creation Date <span style="color:red;">*</span> :</td>
										<td><input type="date" name="creation_date" id="creation_date" size="20"  value="<?php echo set_value('creation_date'); ?>" /></td>

									</tr>
									
									<tr>
										<td class="label">Tax rate (%) <span style="color:red;">*</span> :</td>
										<td><input type="tax_rate" name="tax_rate" id="tax_rate" size="20"  value="<?php echo set_value('tax_rate'); ?>" /></td>

									</tr>
									
									<tr>
										<td class="label">Tax Code Description <span style="color:red;">*</span> :</td>
										<td><input type="lang_tax_code_desc" name="lang_tax_code_desc" id="lang_tax_code_desc" size="20"  value="<?php echo set_value('lang_tax_code_desc'); ?>" /></td>

									</tr>
									<tr>
										<td class="label">Sales Account Head  <span style="color:red;">*</span> :</td>
										<td><select name="account_head_id" id="account_head_id">
											<option value=''>--Select Account Head--</option>
										<?php if($sales_account_head==FALSE){
														echo "<option value=''>--Account Head Setup Required--</option>";}
											else{
												foreach($sales_account_head as $row){
													
													echo '<option value="'.$row->account_head_id.'"'.set_select('account_head_id',''.$row->account_head_id.'').' >'.$row->lang_description.'</option>';
												}
										}?>
										</select></td>
									</tr>
									<tr>
										<td class="label">Purchase Account Head   <span style="color:red;">*</span> :</td>
										<td><select name="account_head_id_p" id="account_head_id_p">
											<option value=''>--Select Account Head--</option>
										<?php if($purchase_account_head==FALSE){
														echo "<option value=''>--Account Head Setup Required--</option>";}
											else{
												foreach($purchase_account_head as $row){
													
													echo '<option value="'.$row->account_head_id.'"'.set_select('account_head_id_p',''.$row->account_head_id.'').' >'.$row->lang_description.'</option>';
												}
										}?>
										</select></td>
									</tr>

									<tr>
										<td class="label">Govt. Account Head   :</td>
										<td><select name="govt_acct_head_no" id="govt_acct_head_no">
											<option value=''>--Select Govt. Account Head--</option>
										<?php if($tr6_account_heads_master==FALSE){
														echo "<option value=''>--Govt. Account Head Setup Required--</option>";}
											else{
												foreach($tr6_account_heads_master as $row){
													
													echo '<option value="'.$row->tr6_acc_id.'"'.set_select('govt_acct_head_no',''.$row->tr6_acc_id.'').' >'.$row->acc_head_description.'</option>';
												}
										}?>
										</select></td>
									</tr>
									<tr>
										<td class="label">Group   :</td>
										<td><select name="tax_name" id="tax_name">
											<option value=''>--Select Group--</option>
										<?php if($tax_group==FALSE){
														echo "<option value=''>--Group Setup Required--</option>";}
											else{
												foreach($tax_group as $value){
													
													echo '<option value="'.$value.'"'.set_select('tax_name',''.$value.'').' >'.$value.'</option>';
												}
										}?>
										</select></td>
									</tr>
									<tr>
										<td class="label">Form No :</td>
										<td><input type="input" name="form_id" id="form_id" size="20"  value="<?php echo set_value('form_id',0); ?>" /></td>

									</tr>									
									<tr>
										<td class="label">TDS :</td>
										<td><input type="checkbox" name="for_tds" id="for_tds" size="20"  value="1" <?php echo set_checkbox('for_tds',1); ?> /></td>

									</tr>
									<tr>
										<td class="label">Not In Inclusive :</td>
										<td><input type="checkbox" name="not_in_incl_price" id="not_in_incl_price" size="20"  value="1" <?php echo set_checkbox('not_in_incl_price',1); ?> /></td>

									</tr>
									<tr>
										<td class="label">Not Passed On :</td>
										<td><input type="checkbox" name="not_passed_on" id="not_passed_on" size="20"  value="1" <?php echo set_checkbox('not_passed_on',1); ?> /></td>

									</tr>
									<tr>
										<td class="label">MRP Applicable :</td>
										<td><input type="checkbox" name="mrp_diff_av" id="mrp_diff_av" size="20"  value="1" <?php echo set_checkbox('mrp_diff_av',1); ?>/></td>

									</tr>

									<tr>
										<td class="label">Expense :</td>
										<td><input type="checkbox" name="exp_flg" id="exp_flg" size="20"  value="1"<?php echo set_checkbox('exp_flg',1); ?> /></td>

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
				
				
				
				
				
			