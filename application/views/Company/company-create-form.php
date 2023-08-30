<script type="text/javascript">
$(document).ready(function() {
    $("#country").change(function(event) {
    var country = $('#country').val();
    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/state",data: {country : $('#country').val()},cache: false,success: function(html){
       $("#state").html(html);
    } 
    });
   });

    $("#state").change(function(event) {
    var state = $('#state').val();
    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/city",data: {state : $('#state').val()},cache: false,success: function(html){
       $("#city").html(html);
    } 
    });
   });

});
</script>
<form name="" action="<?php echo base_url('index.php/company/save');?>" method="POST" enctype="multipart/form-data">
<div class="form_design">
<?php echo validation_errors();?>
	<?php if(isset($note)){ echo "<p>$note</p>";}?>
	<?php if(isset($error)){ echo "<p>$error</p>";}?>
		<table class="form_table_design">
		<tr>
			<td>
				<table class="form_table_inner">
									<tr>
										<td class="label">Company Name <span style="color:red;">*</span> :</td>
										<td><input type="text" name="name" maxlength="64" size="50" value="<?php echo set_value('name');?>" />
										</td>
									</tr>
									<tr>
										<td class="label">Company Id <span style="color:red;">*</span> :</td>
										<td><input type="text" name="company_id" maxlength="6" size="6" value="<?php echo set_value('company_id');?>" /></td>
									</tr>
									<tr>
										<td class="label">Short Id <span style="color:red;">*</span> :</td>
										<td><input type="text" name="short_id" maxlength="2" size="2" value="<?php echo set_value('short_id');?>" /></td>
									</tr>
									<tr>
										<td class="label">Logo  :</td>
										<td><input type="file" name="logo" value="<?php echo set_value('logo');?>"/></td>
									</tr>
									<tr>
										<td class="label">Address <span style="color:red;">*</span> :</td>
										<td><textarea name="address" maxlength="256" rows="3" cols="40" value="<?php echo set_value('address');?>"><?php echo set_value('address');?></textarea></td>
									</tr>
									<tr>
										<td class="label">Country <span style="color:red;">*</span> :</td>
										<td><select name="country" id="country"><option value=''>--Select Country--</option>
										<?php if($country==FALSE){
														echo "<option value=''>--Country Setup Required--</option>";}
											else{
												foreach($country as $country_row){
													$selected=($row->country_id===$country_row->country_id ?'selected':'');
													echo "<option value='".$country_row->country_id."' $selected ".set_select('country',''.$country_row->country_id.'').">".$country_row->lang_country_name."</option>";
												}
										}?>
										</select></td>
									</tr>

									<tr>
										<td class="label">State <span style="color:red;">*</span> :</td>
										<td><select name="state" id="state"><option value=''>--Select State--</option>
											<?php if($state==FALSE){
													echo "<option value=''>--State Setup Required--</option>";}
										else{
											foreach($state as $state_row){
												$selected=($row->state_id===$state_row->state_id ?'selected':'');
												echo "<option value='".$state_row->state_id."' $selected ".set_select('state',''.$state_row->state_id.'').">".$state_row->state_name."</option>";
											}
										}?>
										</select></td>
									</tr>

									<tr>
										<td class="label">City <span style="color:red;">*</span> :</td>
										<td><select name="city" id="city"><option value=''>--Select City--</option>
										<?php if($city==FALSE){
													echo "<option value=''>--City Setup Required--</option>";}
										else{
											foreach($city as $city_row){
												$selected=($row->city_id===$city_row->city_id ?'selected':'');
												echo "<option value='".$city_row->city_id."' $selected ".set_select('city',''.$city_row->city_id.'').">".$city_row->city_name."</option>";
											}
										}?></select></td>
									</tr>

									<tr>
										<td class="label">Zipcode <span style="color:red;">*</span> :</td>
										<td><input type="text" name="zipcode" maxlength="6" size="6" value="<?php echo set_value('zipcode');?>"/></td>
									</tr>
									
									<tr>
										<td class="label">Phone No <span style="color:red;">*</span> :</td>
										<td><input type="text" name="phone_no" maxlength="15" size="15" value="<?php echo set_value('phone_no');?>"/></td>
									</tr>

									<tr>
										<td class="label">Secondary Phone No :</td>
										<td><input type="text" name="secodary_phone_no" maxlength="15" size="15" value="<?php echo set_value('secodary_phone_no');?>"/></td>
									</tr>

									<tr>
										<td class="label">Fax No :</td>
										<td><input type="text" name="fax_no" maxlength="15" size="15" value="<?php echo set_value('fax_no');?>"/></td>
									</tr>
									
								</table>
								<td>
								<table class="form_table_inner" >
									<tr>
										<td class="label">Email <span style="color:red;">*</span>:</td>
										<td><input type="email" name="email" maxlength="256" size="50" value="<?php echo set_value('email');?>"/></td>
									</tr>

									<tr>
										<td class="label">Bcc Email :</td>
										<td><input type="email" name="bcc_email" maxlength="256" size="50" value="<?php echo set_value('bcc_email');?>"/></td>
									</tr>
									<tr>
										<td class="label">Bank Name <span style="color:red;">*</span> :</td>
										<td><select name="bank"><option value=''>--Select Bank--</option>
										<?php if($bank==FALSE){
													echo "<option value=''>--Bank Setup Required--</option>";}
										else{
											foreach($bank as $bank_row){
												$selected=($row->bank_id===$bank_row->bank_id ? 'selected': '');
												echo "<option value='".$bank_row->bank_id."' $selected ".set_select('bank',''.$bank_row->bank_id.'').">".$bank_row->bank_name." - ".$bank_row->ifsc_code."</option>";
											}
										}?></select></td>
									</tr>

									<tr>
										<td class="label">Account No <span style="color:red;">*</span> :</td>
										<td><input type="text" name="account_no" maxlength="20" size="20"  value="<?php echo set_value('account_no');?>"/></td>
									</tr>

									<tr>
										<td class="label">Vat No <span style="color:red;">*</span> :</td>
										<td><input type="text" name="vat_no" maxlength="20" size="20"  value="<?php echo set_value('vat_no');?>"/></td>
									</tr>

									<tr>
										<td class="label">Cst No <span style="color:red;">*</span> :</td>
										<td><input type="text" name="cst_no" maxlength="20" size="20" value="<?php echo set_value('cst_no');?>"/></td>
									</tr>

									<tr>
										<td class="label">Pan No <span style="color:red;">*</span> :</td>
										<td><input type="text" name="pan_no" maxlength="20" size="20" value="<?php echo set_value('pan_no');?>"/></td>
									</tr>

									<tr>
										<td class="label">Service Tax No :</td>
										<td><input type="text" name="service_tax_no" maxlength="20" size="20" value="<?php echo set_value('service_tax_no');?>"/></td>
									</tr>

									<tr>
										<td class="label">Excise No <span style="color:red;">*</span> :</td>
										<td><input type="text" name="excise_no" maxlength="20" size="20" value="<?php echo set_value('excise_no');?>"/></td>
									</tr>

									<tr>
										<td class="label">Excise Range <span style="color:red;">*</span> :</td>
										<td><input type="text" name="excise_range" maxlength="64" size="50" value="<?php echo set_value('excise_range');?>"/></td>
									</tr>

									<tr>
										<td class="label">Excise Division <span style="color:red;">*</span> :</td>
										<td><input type="text" name="excise_division" maxlength="64" size="50" value="<?php echo set_value('excise_division');?>"/></td>
									</tr>

									<tr>
										<td class="label">Commissionarate <span style="color:red;">*</span> :</td>
										<td><input type="text" name="commissionarate" maxlength="64" size="50" value="<?php echo set_value('commissionarate');?>"/></td>
									</tr>



								</table>
							</td>
							
						</tr>
					</table>
					
				</div>

		<div class="form_design">
			<table class="form_table_design">
				<tr>
					<td>
						<table class="form_table_inner">
							<tr><td class="label">First Name <span style="color:red;">*</span> :</td><td><input type="text" name="first_name" maxlength="64" size="30" value="<?php echo set_value('first_name');?>" /></td></tr>
							<tr><td class="label">Last Name <span style="color:red;">*</span> :</td><td><input type="text" name="last_name" maxlength="64" size="30" value="<?php echo set_value('last_name');?>"/></td></tr>
							<tr><td class="label">Email <span style="color:red;">*</span>:</td><td><input type="email" name="email" maxlength="256" size="30" value="<?php echo set_value('email');?>"/></td></tr>
							<tr><td class="label">Username <span style="color:red;">*</span>:</td><td><input type="text" name="username" maxlength="15" size="15" value="<?php echo set_value('username');?>"/></td></tr>
							<tr><td class="label">Password <span style="color:red;">*</span>:</td><td><input type="password" name="password" maxlength="15" size="15"/></td></tr>
									
						</table>
					</td>
				</tr>
				</table>
				<button class="submit" name="submit">Save</button> <a href="<?php echo base_url('index.php/company');?>">Cancel</a>
			</div>
		
		</form>
				
				
				
				
				
			