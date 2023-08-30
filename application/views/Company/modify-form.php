
<div class="form_design">
	<form name="" action="<?php echo base_url('index.php/company/update');?>" method="POST" >
	<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
	<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
	<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
	<?php foreach($company as $row):?>
		<table class="form_table_design">
		<tr>
			<td>
				<table class="form_table_inner" >
									<tr>
										<td class="label">Company Title <span style="color:red;">*</span> :</td>
										<td><input type="text" name="title" value="<?php echo set_value('title',$row->title);?>" />
										<input type="hidden" name="company_id" value="<?php echo $row->company_id;?>" /></td>
									</tr>
									<tr>
										<td class="label">Short Id <span style="color:red;">*</span> :</td>
										<td><input type="text" name="short_id" value="<?php echo set_value('short_id',$row->short_id);?>" /></td>
									</tr>
									
									<tr>
										<td class="label">Street <span style="color:red;">*</span> :</td>
										<td><textarea name="street" maxlength="256" rows="6" cols="40" value="<?php echo set_value('street',$row->street);?>"><?php echo set_value('street',$row->street);?></textarea></td>
									</tr>

									

									<tr>
										<td class="label">Country <span style="color:red;">*</span> :</td>
										<td><select name="country" id="country"><option value=''>--Select Country--</option>
										<?php if($country==FALSE){
														echo "<option value=''>--Country Setup Required--</option>";}
											else{
												foreach($country as $country_row){
													$selected=($row->country_code===$country_row->country_id ?'selected':'');
													echo "<option value='".$country_row->country_id."' $selected ".set_select('country',''.$country_row->country_id.'').">".$country_row->lang_country_name."</option>";
												}
										}?>
										</select></td>
									</tr>

									<tr>
										<td class="label">Postal Code <span style="color:red;">*</span> :</td>
										<td><input type="text" name="postal_code" maxlength="6" size="6" value="<?php echo set_value('postal_code',$row->post_box_code);?>"/></td>
									</tr>
									
									<tr>
										<td class="label">Phone One <span style="color:red;">*</span> :</td>
										<td><input type="number" name="phone_one" maxlength="15" size="15" value="<?php echo set_value('phone_one',$row->telephone1);?>" pattern="[0-9]{0,15}" /></td>
									</tr>

									<tr>
										<td class="label">Secondary Phone No :</td>
										<td><input type="number" name="phone_two" maxlength="15" size="15" value="<?php echo set_value('phone_two',$row->telephone2);?>" pattern="[0-9]{0,15}"/></td>
									</tr>

									<tr>
										<td class="label">Fax No :</td>
										<td><input type="text" name="fax_no" maxlength="15" size="15" value="<?php echo set_value('fax_no',$row->fax);?>"/></td>
									</tr>

								</table>
							</td>
							<td>
								<table class="form_table_inner">

									<tr>
										<td class="label">Email <span style="color:red;">*</span> :</td>
										<td><input type="text" name="email" maxlength="64" size="50" value="<?php echo set_value('email',$row->mail_info_contact);?>"/></td>
									</tr>

									<tr>
										<td class="label">Bank Name <span style="color:red;">*</span> :</td>
										<td><select name="bank"><option value=''>--Select Bank--</option>
										<?php if($bank==FALSE){
													echo "<option value=''>--Bank Setup Required--</option>";}
										else{
											foreach($bank as $bank_row){
												$selected=($row->bank_id===$bank_row->bank_id ? 'selected': '');
												echo "<option value='".$bank_row->bank_id."' $selected ".set_select('bank',''.$bank_row->bank_id.'').">".$bank_row->bank_name." - ".$bank_row->bank_code."</option>";
											}
										}?></select></td>
									</tr>

									<tr>
										<td class="label">Account No <span style="color:red;">*</span> :</td>
										<td><input type="text" name="account_no" maxlength="20" size="20"  value="<?php echo set_value('account_no',$row->account_no);?>"/></td>
									</tr>

									<tr>
										<td class="label">Sales Tax No :</td>
										<td><input type="text" name="sales_tax_no" maxlength="20" size="20"  value="<?php echo set_value('sales_tax_no',$row->sales_tax_no);?>"/></td>
									</tr>

									<tr>
										<td class="label">Income Tax No :</td>
										<td><input type="text" name="incometax_no" maxlength="20" size="20" value="<?php echo set_value('incometax_no',$row->incometax_no);?>"/></td>
									</tr>

								<tr>
										<td class="label">Website :</td>
										<td><input type="text" name="website" maxlength="64" size="50" value="<?php echo set_value('website',$row->home_page);?>"/></td>
									</tr>

								</table>
							</td>
						</tr>
					</table>
					<button class="submit" name="submit">Update</button> <a href="<?php echo base_url('index.php/company');?>">Back</a>
				<?php endforeach;?>
					</form>
				</div>
				
				
				
				
				
			