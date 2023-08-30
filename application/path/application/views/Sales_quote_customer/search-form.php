<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){

		$("#loading").hide(); $("#cover").hide();

		$("#customer_category").autocomplete("<?php echo base_url('index.php/ajax/customer_category_autocomplete');?>", {selectFirst: true});
		


		$("#country").change(function(){
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",
				url: "<?php echo base_url('index.php/ajax/state');?>",
				data: {country : $("#country").val()},
				cache: false,
				success: function(html){
					setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
					$("#state").html(html);
				} 
			});
		});

		 	
 

	});//Jquery closed

</script>
<style type="text/css">
	fieldset {border: 1px solid #8cacbb;}
	fieldset legend{font-weight: bold;}
	
	.number{
		width:25%;
	}
	.number1{
		width:100%;
	}	  
  
</style>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<fieldset>	
			<legend>Customer Information: </legend> 
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner"> 

						<tr>
							<td class="label" >From Date <span style="color:red;">*</span>  :</td>
							<td><input type="date" name="from_date" id="from_date" value="<?php echo set_value('from_date');?>"/></td>
							<td class="label" >To Date <span style="color:red;">*</span>  :</td>
							<td><input type="date" name="to_date" id="to_date" value="<?php echo set_value('to_date');?>"/></td>
						</tr>								 
						<tr>							
							<td class="label"> Customer: <span style="color:red;">*</span> :</td>
							<td colspan="3"><input type="text" name="customer_name" id="customer_category"  size="55" value="<?php echo set_value('customer_name');?>" /></td>							
						</tr>
							<td class="label">Address <span style="color:red;">*</span> :</td>
							<td colspan="3"><textarea name="address" maxlength="512" rows="3" cols="55" value="<?php echo set_value('address');?>"><?php echo set_value('address');?></textarea></td>
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
							<td class="label">City <span style="color:red;">*</span> :</td>
							<td colspan="3"><input type="text" name="city" maxlength="100" size="20" value="<?php echo set_value('city');?>"/></td>
						</tr>

						<tr>
							<td class="label">Pincode <span style="color:red;">*</span> :</td>
							<td colspan="3"><input type="text" name="pincode" maxlength="6" size="20" value="<?php echo set_value('pincode');?>" pattern="[0-9]*" /></td>
						
						</tr>
						 
					</table>
				</td>
				<td width="50%">				
					<table class="form_table_inner">
						<tr>
							<td class="label">Type :</td>
							<td><select name="company_type" id="company_type"><option value=''>--Select Company type--</option>
							<?php if($sales_quotes_company_type_master==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach($sales_quotes_company_type_master as $sales_quotes_company_type_master_row){
										echo "<option value='".$sales_quotes_company_type_master_row->id."'  ".set_select('company_type',''.$sales_quotes_company_type_master_row->id.'').">".$sales_quotes_company_type_master_row->company_type."</option>";
									}
							}?>
							</select></td>
						</tr>

						<tr>
								<td class="label">Ownership Type <span style="color:red;">*</span> :</td>
									<td> 
										<?php if($sales_quotes_ownership_type_master==FALSE){ 
												echo'';
											}else{
												foreach($sales_quotes_ownership_type_master as $row){
													echo'<div class="ui checkbox">
													<input type="checkbox" name="ownership[]" value="'.$row->ownership_type.'" '.(!empty($this->input->post('ownership[]'))?(in_array($row->ownership_type,$this->input->post('ownership[]'),TRUE)?"checked":""):"").'>
													<label>'.$row->ownership_type.'</label><br/>
													</div><br/>';								 
												}
											}
										?>
									</td>
						</tr>
						
					</table>				
				</td>	
			</tr>
		</table>
		</fieldset>					
	</div>
	<br/>
	 	<div class="middle_form_design">
		<div class="middle_form_inner_design" style="font-size: 13px;" >

			<fieldset>	
				<legend>Product Information: </legend>

				<table class="form_table_design">
					<tr>
						<td width="50%">
							<table class="form_table_inner"> 								 
								 <tr>
									<td class="label">Category <span style="color:red;">*</span> :</td>
									<td> 
										<?php   if ($sales_quotes_product_category_master==FALSE){
												echo'';
												}else{
													foreach($sales_quotes_product_category_master as $row){
														echo'<div class="ui checkbox">
														<input type="checkbox" name="product_category[]" value="'.$row->product_category.'" '.(!empty($this->input->post('product_category[]'))?(in_array($row->product_category,$this->input->post('product_category[]'),TRUE)?"checked":""):"").'>
														<label>'.$row->product_category.'</label><br/>
														</div><br/>';								 
													}
												}
										?>
									</td>
								</tr>


								<tr>
								<td class="label">Packaging <span style="color:red;">*</span> :</td>
								<td> 
									 
									<?php
									if($sales_quotes_packaging_master==FALSE){ 
									 	 echo'';
									}else{
									 	foreach($sales_quotes_packaging_master as $row){ 

									 		echo'<div class="ui checkbox">
													<input type="checkbox" name="packaging_type[]" value="'.$row->packaging_type.'" '.(!empty($this->input->post('packaging_type[]'))?(in_array($row->packaging_type,$this->input->post('packaging_type[]'),TRUE)?"checked":""):"").'>
													<label>'.$row->packaging_type.'</label><br/>
													</div><br/>';	
									 	}
								 	}?>
								 	</select>
								 </td>
								</tr>
							
								<tr>
								<td class="label">Product Price Range<span style="color:red;">*</span> :</td>
								 <td>Min: <input class="number" type="number" name="product_price_range_min" value="<?php echo set_value('product_price_range_min');?>"/> Max: <input class="number" type="number" name="product_price_range_max" value="<?php echo set_value('product_price_range_max');?>"/>
								 </td>
							</tr>
							<tr>
								<td class="label">Product Tube Price Range<span style="color:red;">*</span> :</td><td>Min: <input class="number" type="number" name="product_price_range_intubes_min" value="<?php echo set_value('product_price_range_intubes_min');?>"/> Max: <input class="number" type="number" name="product_price_range_intubes_max" value="<?php echo set_value('product_price_range_intubes_max');?>"/>
								</td>
							</tr>
							
								 					
							</table>
						</td>	
						<td width="50%">
							<table class="form_table_inner">
							 	
							 	<tr>
									<td class="label">Product Type <span style="color:red;">*</span> :</td>
									<td> 
										<?php if($sales_quotes_product_types_master==FALSE){ 
												echo'';
											}else{
												foreach($sales_quotes_product_types_master as $row){
													echo'<div class="ui checkbox">
													<input type="checkbox" name="product_type[]" value="'.$row->product_type.'" '.(!empty($this->input->post('product_type[]'))?(in_array($row->product_type,$this->input->post('product_type[]'),TRUE)?"checked":""):"").'>
													<label>'.$row->product_type.'</label><br/>
													</div><br/>';
										 
												}
											}
										?>
									</td>
								</tr>

								
							<tr>
								<td class="label">Current Printing Technology <span style="color:red;">*</span> :</td>
								<td>				 
										
										<?php if($sales_quotes_printing_technology_master==FALSE){ 
											echo''; 
										} 
										else{ 
											foreach ($sales_quotes_printing_technology_master as $row) {
												echo'<div class="ui checkbox">
														<input type="checkbox" name="printing_technology[]" value="'.$row->printing_technology.'" '.(!empty($this->input->post('printing_technology[]'))?(in_array($row->printing_technology,$this->input->post('printing_technology[]'),TRUE)?"checked":""):"").'>
														<label>'.$row->printing_technology.'</label><br/>
														</div><br/>';
											} 
										}
										?>							 
								</td>
							</tr> 							 
							
								<tr>
								<td class="label">Current Supplier <span style="color:red;">*</span> :</td>
								<td>				 
										
										<?php if($sales_quotes_supplier_master==FALSE){ 
											echo''; 
										} 
										else{ 
											foreach ($sales_quotes_supplier_master as $row) {
												echo'<div class="ui checkbox">
														<input type="checkbox" name="current_supplier[]" value="'.$row->supplier_name.'" '.(!empty($this->input->post('current_supplier[]'))?(in_array($row->supplier_name,$this->input->post('current_supplier[]'),TRUE)?"checked":""):"").'>
														<label>'.$row->supplier_name.'</label><br/>
														</div><br/>';
											} 
										}
										?>							 
								</td>
							</tr>
							 </table>
						</td>
					</tr>
				</table>
			</fieldset>	
		</div>
		</div>
 	<div class="form_design">
		<div class="ui buttons">
	  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui positive button" >Search</button>
		</div>
	</div>


</div>	
	
</form>




				
				
				
			