<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){

		$("#loading").hide(); $("#cover").hide();

		$("#customer_category").autocomplete("<?php echo base_url('index.php/ajax/customer_category_autocomplete');?>", {selectFirst: true});

		$("#primary_contact").autocomplete("<?php echo base_url('index.php/ajax/primary_contact_autocomplete');?>", {selectFirst: true});

		$("#secondary_contact").autocomplete("<?php echo base_url('index.php/ajax/primary_contact_autocomplete');?>", {selectFirst: true});

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

		 	
		// Contact Info---------------
		$("#add_contact_info").click(function(e){   			
		 	//var counter= $('#tbl_contact_info tr').length;

		 	//alert('ci');

		 	var counter= $('#tablePanton tr').length-1;			 	

		 	//var counter= $('#tbl_contact_info tbody tr.class_contact_info').length+1; 
		 	//alert(counter);		
			var markup = '<tr class="class_contact_info" id="tr_'+ counter +'"><td><input type="hidden" name="sr_no[]" value="'+counter+'"/>'+ counter +'</td><td><input type="text" name="contact_name[]" size="20"/></td><td><select name="position[]" ><option value="">--POSITION--</option><?php if($sales_quotes_designation_master==FALSE){ echo'<option>--Setup Required--</option>';}else{foreach ($sales_quotes_designation_master as $row){echo'<option value="'.$row->id.'" >'.$row->designation.'</option>';}}?></select></td><td><input type="text" name="company_contact_no[]" size="10" maxlength="15"/></td><td><input type="text" name="personal_contact_no[]" size="10" maxlength="15"/></td><td><input type="text" name="company_email[]"  size="25"></td><td><input type="text" name="personal_email[]" size="25"></td><td><input type="text" name="located_at[]" size="20"></td><td><input type="date" name="birth_date[]"/></td><td><input type="text" name="previous_job[]"/></td><td><select name="previous_position[]" ><option value="">--POSITION--</option><?php if($sales_quotes_designation_master==FALSE){echo'<option>--Setup Required--</option>';}else{ foreach ($sales_quotes_designation_master as $row){echo'<option value="'.$row->id.'">'.$row->designation.'</option>';}}?></select></td><td><input type="text" name="history_if_any[]" size="50"/></td><td><select name="repesentative_3d[]"><option value="">--SELECT--</option><?php if($employee_master==FALSE){echo'<option>--Setup Required--</option>';}else{foreach ($employee_master as $row){echo'<option value="'.$row->employee_id.'">'.strtoupper($row->name1.' '.$row->name2).'</option>';}}?></select></td><td><select name="active[]"><option value="">--STATUS--</option><option value="1">Active</option><option value="0">Inactive</option></select></td></tr>';			
				//alert(markup);
				$("#tablePanton").append(markup);
		});

   		$("#remove_contact_info").click(function(e){

   				var header_row=2;
				//var counter= $('#tbl_contact_info tbody tr.class_contact_info').length; 
				var counter= $('#tablePanton tr').length;	
				//alert(counter);
				counter=counter-header_row;
				if(counter>1){
					if(confirm('Confirm delete!')){
						$("#tr_"+counter).remove();
					}
				}
				else{
					alert('Keep at least one record');
				}		
									
		});

   			 

  //  		$("#remove_product_info").click(function(e){

		// 	var header_row=0;
		// 	var counter= $('#tbl_product_info tbody tr.class_product_info').length; 
		// 	alert(counter);
		// 	counter=counter-header_row;
		// 	if(counter>1){
		// 		if(confirm('Confirm delete!')){
		// 			$("#product_info_tr_"+counter).remove();
		// 		}
		// 	}
		// 	else{
		// 		alert('Keep at least one record');
		// 	}		
									
		// });

		// Buying Potential--------------
	 
		$("#add_buying_potential").click(function(e){   			
		 	//var counter= $('#tbl_contact_info tr').length;

		 	var counter= $('#tableBuyingPotential tr').length;			 	

		 	//var counter= $('#tbl_contact_info tbody tr.class_contact_info').length+1; 
		 	//alert(counter);		
			var markup = '<tr class="class_buying_potential" id="buying_potential_tr_'+ counter +'"><td><input type="hidden" name="buying_potential_sr_no[]" value="'+ counter +'"/>'+ counter +'</td> <td><select name="tubes_currently_buying[]" ><option value="">--CURRENTLY BUYING--</option><?php if($sales_quotes_packaging_master==FALSE){ echo'<option>--Setup Required--</option>';} else { foreach ($sales_quotes_packaging_master as $row) { echo'<option value="'.$row->id.'">'.$row->packaging_type.'</option>';}}?></select></td><td><input type="text" name="min_volume[]"></td><td><input type="text" name="max_volume[]" size="10" maxlength="15"></td><td><input type="text" name="three_d_volume[]"/></td>';		
			
			//alert(markup);
				$("#tableBuyingPotential").append(markup);
		});

   		$("#remove_buying_potential").click(function(e){

   				var header_row=1;
				//var counter= $('#tbl_contact_info tbody tr.class_contact_info').length; 
				var counter= $('#tableBuyingPotential tr').length;	
				//alert(counter);
				counter=counter-header_row;
				if(counter>1){
					if(confirm('Confirm delete!')){
						$("#buying_potential_tr_"+counter).remove();
					}
				}
				else{
					alert('Keep at least one record');
				}		
									
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

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST" enctype="multipart/form-data">
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>


<?php foreach ($sales_quote_customer_master as $master_row):?>

		<fieldset>	
			<legend>Customer Information: </legend>
		 
			<table class="form_table_design">
				<tr>
					<td width="50%">
						<table class="form_table_inner"> 								 
							<tr>							
								<td class="label"> Customer: <span style="color:red;">*</span></td>
								<td colspan="3">
									<input type="hidden" name="address_category_details_id" value="<?php echo $master_row->address_category_details_id;?>">
									<?php $customer=$this->common_model->select_one_active_record('address_category_master',$this->session->userdata['logged_in']['company_id'],'adr_category_id',$master_row->adr_category_id);
									//echo $this->db->last_query();
										if($customer==FALSE){


										}else{
											foreach($customer as $customer_row){

												echo "<input type='text' name='customer_category' id='customer_category' size='40' value='".$customer_row->category_name."//".$customer_row->adr_category_id."' readonly>";
										
										}
									}

									?>


									</td>							
							</tr>
							<tr>
								<td class="label">Address <span style="color:red;">*</span></td>
								<td><textarea name="address" maxlength="512" rows="3" cols="55" value="<?php echo set_value('address',$master_row->address);?>" ><?php echo set_value('address',$master_row->address);?></textarea></td>
							</tr>
							<tr>
								<td class="label">Country <span style="color:red;">*</span></td>
								<td><select name="country" id="country"><option value=''>--Select Country--</option>
								<?php if($country==FALSE){
												echo "<option value=''>--Setup Required--</option>";}
									else{
										foreach($country as $country_row){
											$selected=($master_row->country==$country_row->country_id?"selected":"");
											echo "<option value='".$country_row->country_id."'  ".set_select('country',''.$country_row->country_id.'').$selected.">".$country_row->lang_country_name."</option>";
										}
								}?>
								</select></td>
							</tr>
							<tr>
								<td class="label">State <span style="color:red;">*</span></td>
								<td><select name="state" id="state"><option value=''>--Select State--</option>
								<?php if($state==FALSE){
												echo "<option value=''>--Setup Required--</option>";}
									else{
										foreach($state as $state_row){
											$selected=($master_row->state==$state_row->zip_code?"selected":"");
											echo "<option value='".$state_row->zip_code."'  ".set_select('state',''.$state_row->zip_code.'').$selected.">".$state_row->lang_city."</option>";
										}
								}?>
								</select></td>
							</tr>				
							
							<tr>
								<td class="label">City <span style="color:red;">*</span></td>
								<td><input type="text" name="city" maxlength="100" size="20" value="<?php echo set_value('city',$master_row->city);?>" /></td>
							</tr>
							<tr>
								<td class="label">Pincode <span style="color:red;">*</span></td>
								<td><input type="text" name="pincode" maxlength="6" size="20" value="<?php echo set_value('pincode',$master_row->pincode);?>" pattern="[0-9]*" /></td>
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
											$selected=($master_row->company_type==$sales_quotes_company_type_master_row->id?"selected":"");
											echo"<option value='".$sales_quotes_company_type_master_row->id."'  ".set_select('company_type',''.$sales_quotes_company_type_master_row->id.'').$selected.">".$sales_quotes_company_type_master_row->company_type."</option>";
										}
								}?>
								</select></td>
							</tr>

							<tr>
								<td class="label">Ownership Type <span style="color:red;">*</span></td>
								<td> 
									<?php if($sales_quotes_ownership_type_master==FALSE){ 
											echo'';
										}else{

											foreach($sales_quotes_ownership_type_master as $row){
												echo'<div class="ui checkbox">
												<input type="checkbox" name="ownership[]" value="'.$row->ownership_type.'" '.(!empty($this->input->post('ownership[]'))?(in_array($row->ownership_type,$this->input->post('ownership[]'),TRUE)?"checked":""):(in_array($row->ownership_type,explode(',', $master_row->ownership),TRUE)? "checked":"")).'>
												<label>'.$row->ownership_type.'</label>
												</div><br/><br/>';								 
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
			<br/>

		<fieldset>
			<legend>Contact Information </legend>

			<table class="form_table_design">
			<tr>
			<td width="50%">
				<table class="form_table_inner"> 								 
					<tr>							
						<td class="label">Primary Contact <span style="color:red;">*</span></td>
						<td colspan="3">
							<?php $primary_contact_result=$this->common_model->select_one_active_record('address_category_contact_details',$this->session->userdata['logged_in']['company_id'],'address_category_contact_id',$master_row->primary_contact_id);
									//echo $this->db->last_query();
										if($primary_contact_result==FALSE){


											echo '<input type="text" id="primary_contact" class="primary_contact" name="primary_contact" size="40" value="'.set_value('primary_contact').'"/>';


										}else{
											foreach($primary_contact_result as $primary_contact_row){

												echo "<input type='text' name='primary_contact' id='primary_contact' size='40' value='".$primary_contact_row->contact_name."//".$primary_contact_row->address_category_contact_id	."'>";
										
										}
									}

							?>
						</td>							
					</tr>
					 
				</table>
			</td>
			<td width="50%">				
				<table class="form_table_inner">
					<tr>							
						<td class="label">Secondary Contact </td>
						<td colspan="3">
							<?php $secondary_contact_result=$this->common_model->select_one_active_record('address_category_contact_details',$this->session->userdata['logged_in']['company_id'],'address_category_contact_id',$master_row->secondary_contact_id);
									//echo $this->db->last_query();
										if($secondary_contact_result==FALSE){

											echo '<input type="text" id="secondary_contact" name="secondary_contact" size="40" value="'.set_value('secondary_contact').'"/>';

										}else{
											foreach($secondary_contact_result as $secondary_contact_row){

												echo "<input type='text' name='secondary_contact' id='secondary_contact' size='40' value='".$secondary_contact_row->contact_name."//".$secondary_contact_row->address_category_contact_id."'>";
										
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

		<!-- Contact Information -->		
		
		<div class="middle_form_design">
		<div class="middle_form_inner_design" style="overflow:scroll;font-size: 10px;" >

		<fieldset>
			<legend>Product Info:</legend>	

		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">
						<tr>
							<td class="label">Category <span style="color:red;">*</span></td>
							<td> 
								<?php   if ($sales_quotes_product_category_master==FALSE){
										echo'';
										}else{
											foreach($sales_quotes_product_category_master as $row){
												echo'<div class="ui checkbox">
												<input type="checkbox" name="product_category[]" value="'.$row->product_category.'" '.(!empty($this->input->post('product_category[]'))?(in_array($row->product_category,$this->input->post('product_category[]'),TRUE)?"checked":""):(in_array($row->product_category,explode(',', $master_row->product_category),TRUE)? "checked":"")).'>
												<label>'.$row->product_category.'</label>
												</div><br/><br/>';								 
											}
										}
								?>
							</td>
						</tr>

						<tr>
						<td class="label">Packaging <span style="color:red;">*</span></td>
						<td> 
							 
							<?php
							if($sales_quotes_packaging_master==FALSE){ 
							 	 echo'';
							}else{
							 	foreach($sales_quotes_packaging_master as $row){ 

							 		echo'<div class="ui checkbox">
											<input type="checkbox" name="packaging_type[]" value="'.$row->packaging_type.'" '.(!empty($this->input->post('packaging_type[]'))?(in_array($row->packaging_type,$this->input->post('packaging_type[]'),TRUE)?"checked":""):(in_array($row->packaging_type,explode(',', $master_row->packaging_type),TRUE)? "checked":"")).'>
											<label>'.$row->packaging_type.'</label>
											</div><br/><br/>';	
							 	}
						 	}?>
						 	</select>
						 </td>
						</tr>

						<tr>
							<td class="label">Product Price M.R.P<span style="color:red;">*</span></td>
							 <td>Min: <input class="number" type="number" name="product_price_range_min" value="<?php echo set_value('product_price_range_min',$master_row->product_price_range_min);?>"/> Max: <input class="number" type="number" name="product_price_range_max" value="<?php echo set_value('product_price_range_max',$master_row->product_price_range_max);?>"/>
							 </td>
						</tr>

						<tr>
						<td class="label">Product Tube Price <span style="color:red;">*</span></td><td>Min: <input class="number" type="number" name="product_price_range_intubes_min" value="<?php echo set_value('product_price_range_intubes_min',$master_row->product_price_range_intubes_min);?>"/> Max: <input class="number" type="number" name="product_price_range_intubes_max" value="<?php echo set_value('product_price_range_intubes_max',$master_row->product_price_range_intubes_max);?>"/>
						</td>
					</tr>
					
						 					
					</table>
				</td>	
				<td width="50%">
					<table class="form_table_inner">
					 
					<tr>
							<td class="label">Product Type <span style="color:red;">*</span></td>
							<td> 
								<?php if($sales_quotes_product_types_master==FALSE){ 
										echo'';
									}else{
										foreach($sales_quotes_product_types_master as $row){
											echo'<div class="ui checkbox">
											<input type="checkbox" name="product_type[]" value="'.$row->product_type.'" '.(!empty($this->input->post('product_type[]'))?(in_array($row->product_type,$this->input->post('product_type[]'),TRUE)?"checked":""):(in_array($row->product_type,explode(',', $master_row->product_type),TRUE)? "checked":"")).'>
											<label>'.$row->product_type.'</label>
											</div><br/><br/>';
								 
										}
									}
								?>
							</td>
					</tr>


					<tr>
						<td class="label">Current Printing Technology <span style="color:red;">*</span></td>
						<td>				 
								
								<?php if($sales_quotes_printing_technology_master==FALSE){ 
									echo''; 
								} 
								else{ 
									foreach ($sales_quotes_printing_technology_master as $row) {
										echo'<div class="ui checkbox">
												<input type="checkbox" name="printing_technology[]" value="'.$row->printing_technology.'" '.(!empty($this->input->post('printing_technology[]'))?(in_array($row->printing_technology,$this->input->post('printing_technology[]'),TRUE)?"checked":""):(in_array($row->printing_technology,explode(',', $master_row->printing_technology),TRUE)?"checked":"")).'>
												<label>'.$row->printing_technology.'</label>
												</div><br/><br/>';
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
												<input type="checkbox" name="current_supplier[]" value="'.$row->supplier_name.'" '.(!empty($this->input->post('current_supplier[]'))?(in_array($row->supplier_name,$this->input->post('current_supplier[]'),TRUE)?"checked":""):(in_array($row->supplier_name,explode(',', $master_row->current_supplier),TRUE)?"checked":"")).'>
												<label>'.$row->supplier_name.'</label>
												</div><br/><br/>';
									} 
								}
								?>							 
						</td>
					</tr>
					
					<tr>
						<td class="label">Customer rating<span style="color:red;">*</span> :</td>
						<td><input type="file" multiple="" name="images[]" >
							<input type="hidden" name="image_path" value="<?php echo set_value('image_path',$master_row->images);?>">
							<?php 
								if($master_row->images!=''){
									$img_arr=explode(",",$master_row->images);
									//print_r($img_arr);
									
									foreach ($img_arr as $key => $image_name) {
										
										echo'<a href="'.base_url('assets/'.$this->session->userdata['logged_in']['company_id'].'/customer_quotation/'.$image_name.'').'" target="_blank"><i class="file pdf outline icon"></i>
										</a>';
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
		<br/>
		<!-- Buying Information -->		
		<div class="middle_form_design">
		<div class="middle_form_inner_design" style="overflow:scroll;font-size: 11px;" >
			<fieldset>
			<legend>Yearly Buying Potential:</legend>
			<div class="ui buttons">
				<input type="button" value="Remove" id="remove_buying_potential" class="ui button">
				<div class="or"></div>
				<input type="button" value="Add" id="add_buying_potential" class="ui positive button">
			</div>	
			<br/>	 
			<br/>
			<table class="ui very basic collapsing celled table" id="tableBuyingPotential" >
				<thead>				
				<tr>
					<th>Sr.No.</th>
					<th>Tubes Currently Buying </th>
					<th>Min Volume </th>
					<th>Max Volume </th>
					<th>3D Volume </th>				 						 
						
				</tr>
			</thead>
			<tbody>					 
			 
				<?php
					if(!empty($this->input->post('buying_potential_sr_no[]'))){
						$j=1;
						for($i=0;$i<count($this->input->post('buying_potential_sr_no[]'));$i++){										 
							echo'<tr class="class_buying_potential" id="buying_potential_tr_'.$j.'">

							<td><input type="hidden" name="buying_potential_sr_no[]" value="'.$j.'"/>
							'.$j.'
							</td>
							<td><select name="tubes_currently_buying[]" >					
							<option value="">--CURRENTLY BUYING--</option>';
							if($sales_quotes_packaging_master==FALSE){
								echo'<option>--Setup Required--</option>';
							}
							else{
								foreach ($sales_quotes_packaging_master as $row) {
									$selected=($this->input->post('tubes_currently_buying['.$i.']')==$row->id?"selected":"");
									echo'<option value="'.$row->id.'" '.$selected.'>'.$row->packaging_type.'</option>';
								}
							}
							echo'</select>
							</td>								 
							<td><input type="number" name="min_volume[]" value="'.set_value('min_volume['.$i.']').'">
							</td>							 
							<td><input type="number" name="max_volume[]" value="'.set_value('max_volume['.$i.']').'" size="10" maxlength="15">
							</td>							 
							<td><input type="number" name="three_d_volume[]" value="'.set_value('three_d_volume['.$i.']').'"/>
							</td>';

						$j++;
						}
					}	
					else{

						$search_arr=array('adr_category_id'=>$master_row->adr_category_id,
						'archive'=>'0');

						$sales_quote_customer_buying_potential_result=$this->common_model->select_active_records_where('sales_quote_customer_buying_potential',$this->session->userdata['logged_in']['company_id'],$search_arr);
						//$sales_quote_customer_buying_potential_result=$this->common_model->select_one_record_with_company('sales_quote_customer_buying_potential',$this->session->userdata['logged_in']['company_id'],'customer_id',$master_row->customer_id);
						//echo $this->db->last_query();

						$j=1;
						foreach($sales_quote_customer_buying_potential_result as $buying_potential_row ){ 
						 
							echo'<tr class="class_buying_potential" id="buying_potential_tr_'.$j.'">

							<td><input type="hidden" name="buying_potential_sr_no[]" value="'.$j.'"/>
							'.$j.'	
							</td>					 
					 
							<td><select name="tubes_currently_buying[]" >					
							<option value="">--CURRENTLY BUYING--</option>';
							if($sales_quotes_packaging_master==FALSE){
								echo'<option>--Setup Required--</option>';
							}
							else{
								foreach ($sales_quotes_packaging_master as $row) {
									$selected=($buying_potential_row->tubes_currently_buying==$row->id?"selected":""); 
									echo'<option value="'.$row->id.'" '.$selected.'>'.$row->packaging_type.'</option>';
								}
							}
							echo'</select>
							</td>								 
							<td><input type="text" name="min_volume[]" value="'.set_value('min_volume[]',$buying_potential_row->min_volume).'">
							</td>							 
							<td><input type="text" name="max_volume[]" value="'.set_value('max_volume[]',$buying_potential_row->max_volume).'" size="10" maxlength="15">
							</td>							 
							<td><input type="text" name="three_d_volume[]" value="'.set_value('three_d_volume[]',$buying_potential_row->three_d_volume).'"/>
							</td>				 												 
							 
							</tr>';
							$j++;
						}
					}
				?>
			</tbody>
			</table>
			</fieldset>					 
		</div>
		</div>

	<div class="form_design">
		<div class="ui buttons">
	  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui positive button" onClick="return confirm('Are you sure to Update Record?');">Update</button>
		</div>
	</div>

	<?php endforeach;?>	

</div>
	
</form>




				
				
				
			