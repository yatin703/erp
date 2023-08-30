<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();

		$("#country").change('keyup',function(){
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/state');?>",data: {country : $("#country").val()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#state").html(html);
				} 
			});
		});

	});

</script>
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
										<td class="label">Dispacth Tolerance  :</td>
										<td>
											<input type="number" name="dispatch_tolerance" min="0" max="20" step="1" required>
										</td>
									</tr>
									<tr>
										<td class="label">Category :</td>
										<td><select name="category" id="category"><option value=''>--Select Category--</option>
										<?php if($category==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($category as $category_row){
													echo "<option value='".$category_row->adr_category_id."'  ".set_select('category',''.$category_row->adr_category_id.'').">".$category_row->category_name."</option>";
												}
										}?>
										</select></td>
									</tr>
									
									<tr>
										<td class="label">Company Name <span style="color:red;">*</span> :</td>
										<td><input type="text" name="name1" maxlength="150" size="60" value="<?php echo set_value('name1');?>" /></td>
									</tr>

									<tr>
										<td class="label">Gala/Flat/House No :</td>
										<td><input type="text" name="strno" maxlength="9" size="9" value="<?php echo set_value('strno');?>" /></td>
									</tr>

									<tr>
										<td class="label">Society/Building :</td>
										<td><input type="text" name="name2" maxlength="100" size="30" value="<?php echo set_value('name2');?>" /></td>
									</tr>

									<tr>
										<td class="label">Street :</td>
										<td><input type="text" name="street" maxlength="150" size="30" value="<?php echo set_value('street');?>" /></td>
									</tr>

									<tr>
										<td class="label">Area <span style="color:red;">*</span> :</td>
										<td><textarea name="name3" maxlength="256" rows="3" cols="40" value="<?php echo set_value('name3');?>"><?php echo set_value('name3');?></textarea></td>
									</tr>
									<tr>
										<td class="label">Pincode :</td>
										<td><input type="text" name="city_code" maxlength="6" size="20" value="<?php echo set_value('city_code');?>" pattern="[0-9]*" /></td>
									</tr>

									<tr>
										<td class="label">Country <span style="color:red;">*</span> :</td>
										<td><select name="country" id="country"><option value=''>--Select Country--</option>
										<?php if($country==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($country as $country_row){
													echo "<option value='".$country_row->country_id."'  ".set_select('country',''.$country_row->country_id.'').">".$country_row->lang_country_name."</option>";
												}
										}?>
										</select></td>
									</tr>

									<tr>
										<td class="label">State <span style="color:red;">*</span> :</td>
										<td><select name="state" id="state"><option value=''>--Select State--</option>
										<?php if($state==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($state as $state_row){
													echo "<option value='".$state_row->zip_code."'  ".set_select('state',''.$state_row->zip_code.'').">".$state_row->lang_city."</option>";
												}
										}?>
										</select></td>
									</tr>									

									<tr>
										<td class="label">Email <span style="color:red;">*</span> :</td>
										<td><input type="text" name="email" maxlength="200" size="60" value="<?php echo set_value('email');?>" /></td>
									</tr>

									

									<tr>
										<td class="label">Telephone <span style="color:red;">*</span> :</td>
										<td><input type="text" name="telephone1"  maxlength="50" size="20" value="<?php echo set_value('telephone1');?>" /></td>
									</tr>

									<tr>
										<td class="label">Mobile  :</td>
										<td><input type="text" name="telephone2"  maxlength="50" size="20" value="<?php echo set_value('telephone2');?>" /></td>
									</tr>
									<tr>
										<td class="label">Party Type  :</td>
										<td>
											<select name="party_type" id="party_type" >
												<option value="">--Please Select--</option>
												<option value="SEZ" <?php echo set_select('party_type','SEZ');?>>SEZ</option>
											</select>

										</td>
									</tr>
									
				</table>			
								
				</td>

				<td>
						<table class="form_table_inner">

							<tr>
										<td class="label">Property <span style="color:red;">*</span> :</td>
										<td><select name="property"><option value=''>--Select Property--</option>
										<?php if($property==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($property as $property_row){
													echo "<option value='".$property_row->property_id."'  ".set_select('property',''.$property_row->property_id.'').">".$property_row->lang_property_name."</option>";
												}
										}?>
										</select></td>
									</tr>

									<tr>
										<td class="label">Transit Period  <span style="color:red;">*</span> :</td>
										<td><input type="text" name="transit_days"  maxlength="11" size="11" value="<?php echo set_value('transit_days');?>" /></td>
									</tr>


									<tr>
										<td class="label">PAN No <span style="color:red;">*</span> :</td>
										<td><input type="text" name="post_box_code" value="<?php echo set_value('post_box_code');?>" /></td>
									</tr>

									<tr>
										<td class="label">Gst No <span style="color:red;">*</span> :</td>
										<td><input type="text" name="isdn_local" value="<?php echo set_value('isdn_local');?>" /></td>
									</tr>

									<tr>
										<td class="label">Payment Term <span style="color:red;">*</span> :</td>
										<td><select name="payment_term"><option value=''>--Select Payment Term--</option>
										<?php if($payment_term==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($payment_term as $payment_term_row){
													echo "<option value='".$payment_term_row->id."'  ".set_select('payment_term',''.$payment_term_row->id.'').">".$payment_term_row->lang_description." (".$payment_term_row->net_days." days) </option>";
												}
										}?>
										</select></td>
									</tr>


									<tr>
										<td class="label">Bank  :</td>
										<td><select name="bank"><option value=''>--Select Bank--</option>
										<?php if($bank==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($bank as $bank_row){
													echo "<option value='".$bank_row->bank_id."'  ".set_select('bank',''.$bank_row->bank_id.'').">".$bank_row->bank_name." (".$bank_row->bank_code.")</option>";
												}
										}?>
										</select></td>
									</tr>

									<tr>
										<td class="label">Account Type :</td>
										<td><input type="text" name="account_type" maxlength="20" size="20" value="<?php echo set_value('account_type');?>" /></td>
									</tr>

									<tr>
										<td class="label">Account No :</td>
										<td><input type="text" name="account_no" maxlength="35" size="20" value="<?php echo set_value('account_no');?>" /></td>
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
				
				
				
				
				
			