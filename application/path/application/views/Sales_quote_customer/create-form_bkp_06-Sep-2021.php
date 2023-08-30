<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){

		$("#loading").hide(); $("#cover").hide();

		/*$("#customer_category").autocomplete("<?php echo base_url('index.php/ajax/customer_category_autocomplete');?>", {selectFirst: true});
		*/


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

		/*$("#add_contact_info").click(function(e){   			
		 	//var counter= $('#tbl_contact_info tr').length;	
		 	

		 	var counter= $('#tbl_contact_info tbody tr.class_contact_info').length+1; 
		 	//alert(counter);		
			var markup = '<tr class="class_contact_info" id="tr_'+ counter+ '"><td><table class="form_table_inner" ><tr><td class="label">Contact Name <span style="color:red;">*</span> :</td> <td><input type="hidden" name="sr_no[]" name="sr_no[]" value="<?php echo set_value('sr_no[]');?>"/><input type="text" name="contact_name[]" value="<?php echo set_value('contact_name[]');?>"></td> </tr></table></td></tr>';
			alert(markup);
				$("#tbl_contact_info").append(markup);
		});
	*/	
		// Contact Info---------------
		$("#add_contact_info").click(function(e){   			
		 	//var counter= $('#tbl_contact_info tr').length;	
		 	

		 	var counter= $('#tbl_contact_info tbody tr.class_contact_info').length+1; 
		 	//alert(counter);		
			var markup = '<tr class="class_contact_info" id="tr_'+counter+'"><td style="align:center;">'+counter+'</td><td width="50%"><table class="form_table_inner" ><tr><td class="label">Contact Name <span style="color:red;">*</span> :</td><td><input type="hidden" name="sr_no[]" id="sr_no[]" value="<?php echo set_value('sr_no[]');?>"/><input type="text" name="contact_name[]" value="<?php echo set_value('contact_name[]');?>" size="50"></td></tr><tr> <td class="label">Position <span style="color:red;">*</span> :</td><td><select name="position[]" ><option value="">--SELECT POSITION--</option><?php if($sales_quotes_designation_master==FALSE){echo'<option>--Setup Required--</option>'; } else{ foreach ($sales_quotes_designation_master as $row) { echo'<option value="'.$row->id.'" '.set_select('position[]',$row->id).'>'.$row->designation.'</option>'; } }?></select> </tr><tr> <td class="label">Comapny Contact No <span style="color:red;">*</span> :</td> <td><input type="text" name="company_contact_no[]" value="<?php echo set_value('company_contact_no[]');?>"></td><tr><td class="label">Personal Contact No <span style="color:red;">*</span> :</td><td><input type="text" name="personal_contact_no[]" value="<?php echo set_value('personal_contact_no[]');?>"/></td></tr><tr><td class="label">Company Email <span style="color:red;">*</span> :</td><td><input type="text" name="company_email[]" value="<?php echo set_value('company_email[]');?>" size="50"></td></tr><tr><td class="label">Personal Email <span style="color:red;">*</span> :</td><td><input type="text" name="personal_email[]" value="<?php echo set_value('personal_email[]');?>" size="50"> </td></tr> </table></td><td width="50"><table class="form_table_inner"><tr><td class="label">Located At <span style="color:red;">*</span> :</td><td><input type="text" name="located_at[]" value="<?php echo set_value('located_at[]');?>" size="50"></td></tr><tr> <td class="label">Birth Date <span style="color:red;">*</span> :</td><td><input type="date" name="birth_date[]" value="<?php echo set_value('birth_date[]');?>"></td></tr><tr><td class="label">Previous Job<span style="color:red;">*</span> :</td><td><input type="text" name="previous_job[]" value="<?php echo set_value('previous_job[]');?>"></td></tr><tr><td class="label">Previous Position <span style="color:red;">*</span> :</td> <td><select name="previous_position[]" ><option value="">--PREVIOUS POSITION--</option><?php if($sales_quotes_designation_master==FALSE){echo'<option>--Setup Required--</option>';} else{ foreach ($sales_quotes_designation_master as $row) {echo'<option value="'.$row->id.'" '.set_select('previous_position[]',$row->id).'>'.$row->designation.'</option>'; }}?></select></td> </tr><tr><td class="label">History If Any<span style="color:red;">*</span> :</td><td><input type="text" name="history_if_any[]" value="<?php echo set_value('history_if_any[]');?>" size="50"/> </td></tr><tr><td class="label">Active<span style="color:red;">*</span> :</td><td><select name="active <option value="">--Select Active--</option><option value="1" "<?php echo set_select('active[]','1');?>">Active</option><option value="0" "<?php echo set_select('active[]','0');?>">Inactive</option></select></td></tr><tr><td class="label">3D Representative  <span style="color:red;">*</span> :</td><td><select name="repesentative_3d[]" ><option value="">--3D REPRESENTATIVE--</option><?php if($employee_master==FALSE){echo'<option>--Setup Required--</option>';}else{ foreach ($employee_master as $row) { echo'<option value="'.$row->employee_id.'" '.set_select('repesentative_3d[]',$row->employee_id).'>'.strtoupper($row->name1.' '.$row->name2).'</option>';}}?></select></td></tr></table></td></tr>';			
			
			//alert(markup);
				$("#tbl_contact_info").append(markup);
		});

   		$("#remove_contact_info").click(function(e){

   				var header_row=0;
				var counter= $('#tbl_contact_info tbody tr.class_contact_info').length; 
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

   		// Product Info--------------
		$("#add_product_info").click(function(e){   			
		 	//var counter= $('#tbl_contact_info tr').length;		 	

		 	var counter= $('#tbl_product_info tbody tr.class_product_info').length+1; 
		 	//alert(counter);		
			var markup = '<tr class="class_product_info" id="product_info_tr_'+counter+'"> <td style="align:center;">'+counter+'</td><td width="50%"><table class="form_table_inner"><tr><td class="label">Product Name<span style="color:red;">*</span> :</td><td><input type="hidden" name="sr_no_product[]" name="sr_no_product[]" value="<?php echo set_value('sr_no_product[]');?>"/> <input type="text" name="product_name[]" value="<?php echo set_value('product_name[]');?>" size="50"/></td></tr><tr><td class="label">Product Type <span style="color:red;">*</span> :</td><td><select name="product_type[]"><option value="">--SELECT TYPE--</option><?php if($sales_quotes_product_types_master==FALSE){ echo'<option>--Setup Required--</option>';}else{foreach($sales_quotes_product_types_master as $row){echo'<option value="'.$row->id.'" '.set_select('product_type[]',$row->id).'>'.$row->product_type.'</option>';}}?> </select></td></tr><tr><td class="label">Category <span style="color:red;">*</span> :</td><td><select name="product_category[]"> <option value="">--SELECT CATEGORY--</option><?php if($sales_quotes_product_category_master==FALSE){echo'<option>--Setup Required--</option>';}else{foreach($sales_quotes_product_category_master as $row) {echo'<option value="'.$row->id.'" '.set_select('product_category[]',$row->id).'>'.$row->product_category.'</option>';}}?></select></td></tr><tr><td class="label">Packaging <span style="color:red;">*</span> :</td><td><select name="product_packaging[]"><option value="">--SELECT PACKAGING--</option><?php if($sales_quotes_packaging_master==FALSE){ echo'<option>--Setup Required--</option>'; }else{foreach($sales_quotes_packaging_master as $row){ echo'<option value="'.$row->id.'" '.set_select('product_packaging[]',$row->id).'>'.$row->packaging_type.'</option>';}}?></select></td></tr></table></td><td width="50%"><table class="form_table_inner"><tr><td class="label">Price Range<span style="color:red;">*</span> :</td> <td>Min: <input class="number" type="number" name="product_price_range_min[]" value="<?php echo set_value('product_price_range_min[]');?>"/> Max: <input class="number" type="number" name="product_price_range_max[]" value="<?php echo set_value('product_price_range_max[]');?>"/></td></tr><tr><td class="label">Price range of Products in Tubes <span style="color:red;">*</span> :</td><td>Min: <input class="number" type="number" name="product_price_range_intubes_min[]" value="<?php echo set_value('product_price_range_intubes_min[]');?>"/> Max: <input class="number" type="number" name="product_price_range_intubes_max[]" value="<?php echo set_value('product_price_range_intubes_max[]');?>"/></td></tr><tr><td class="label">Current Supplier<span style="color:red;">*</span> :</td><td><input type="text"  name="current_supplier[]" value="<?php echo set_value('current_supplier[]');?>" size="50"></td></tr><tr><td class="label">Current Printing Technology <span style="color:red;">*</span> :</td><td><select name="printing_technology[]"><option value="">--PRINTING TECHNOLOGY--</option> <?php if($sales_quotes_printing_technology_master==FALSE){ echo'<option>--Setup Required--</option>'; } else{ foreach ($sales_quotes_printing_technology_master as $row) {echo'<option value="'.$row->id.'" '.set_select('printing_technology[]',$row->id).'>'.$row->printing_technology.'</option>'; } }?></select></td></tr></table></td> </tr>';			
			
				//alert(markup);
				$("#tbl_product_info").append(markup);
		});

   		$("#remove_product_info").click(function(e){

			var header_row=0;
			var counter= $('#tbl_product_info tbody tr.class_product_info').length; 
			alert(counter);
			counter=counter-header_row;
			if(counter>1){
				if(confirm('Confirm delete!')){
					$("#product_info_tr_"+counter).remove();
				}
			}
			else{
				alert('Keep at least one record');
			}		
									
		});

		// Buying Potential--------------
		$("#add_buying_potential").click(function(e){   			
		 	//var counter= $('#tbl_contact_info tr').length;		 	

		 	var counter= $('#tbl_buying_potential tbody tr.class_buying_potential').length+1; 
		 	//alert(counter);	
		 	//var markup = '<tr class="class_product_info" id="product_info_tr_'+counter+'"> <td style="align:center;">'+counter+'</td><td width="45%"><table>';	
			
			var markup = '<tr class="class_buying_potential" id="buying_potential_tr_'+counter+'"> <td style="align:center;">'+counter+'</td><td width="50%"><table class="form_table_inner"><tr><td class="label">Supplier <span style="color:red;">*</span> :</td><td><select name="supplier[]"><option value="">--SELECT SUPPLIER--</option><?php if($sales_quotes_supplier_master==FALSE){ echo'<option>--Setup Required--</option>';} else{ foreach ($sales_quotes_supplier_master as $row) { echo'<option value="'.$row->supplier_id.'" '.set_select('position[]',$row->supplier_id).'>'.$row->supplier_name.'</option>'; }}?></select></td></tr><tr><td class="label">Tubes Currently Buying <span style="color:red;">*</span> :</td><td><select name="tubes_currently_buying[]"> <option value="">--SELECT TECHNOLOGY--</option><?php if($sales_quotes_printing_technology_master==FALSE){echo'<option>--Setup Required--</option>';}else{foreach ($sales_quotes_printing_technology_master as $row) {echo'<option value="'.$row->id.'" '.set_select('tubes_currently_buying[]',$row->id).'>'.$row->printing_technology.'</option>';} }?></select></td></tr></table></td> <td width="50%"><table class="form_table_inner"><tr><td class="label">Min Volume <span style="color:red;">*</span> :</td><td><input class="number1" type="number" name="min_volume[]" value="<?php echo set_value('min_volume[]');?>"></td></tr><tr><td class="label">Max Volume <span style="color:red;">*</span> :</td> <td><input class="number1" type="number" name="max_volume[]" value="<?php echo set_value('max_volume[]');?>"></td></tr><tr><td class="label">3D Volume <span style="color:red;">*</span> :</td><td><input class="number1" type="number" name="three_d_volume[]" value="<?php echo set_value('three_d_volume[]');?>"></td> </tr></table></td></tr>';			
				alert(markup);
				$("#tbl_buying_potential").append(markup);
		});

   		$("#remove_buying_potential").click(function(e){

			var header_row=0;
			var counter= $('#tbl_buying_potential tbody tr.class_buying_potential').length; 
			alert(counter);
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

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<fieldset>
			<legend>Customer Info :</legend>
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner"> 								 
						<tr>							
							<td class="label"> Customer: <span style="color:red;">*</span> :</td>
							<td colspan="3"><input type="text" name="customer_name" id="customer_name"  size="55" value="<?php echo set_value('customer_name');?>" required /></td>							
						</tr>
							<td class="label">Address <span style="color:red;">*</span> :</td>
							<td><textarea name="address" maxlength="512" rows="3" cols="55" value="<?php echo set_value('address');?>"><?php echo set_value('address');?></textarea></td>
						</tr>
						<tr>
							<td class="label">City <span style="color:red;">*</span> :</td>
							<td><input type="text" name="city" maxlength="100" size="20" value="<?php echo set_value('city');?>" />&nbsp;&nbsp;&nbsp; Pincode <span style="color:red;">*</span> : <input type="text" name="city_code" maxlength="6" size="20" value="<?php echo set_value('city_code');?>" pattern="[0-9]*" /></td>
						</tr>
						<!-- <tr>
							<td class="label">Pincode <span style="color:red;">*</span> :</td>
							<td><input type="text" name="city_code" maxlength="6" size="20" value="<?php echo set_value('city_code');?>" pattern="[0-9]*" /></td>
						</tr>						
						 -->
					</table>
				</td>
				<td width="50%">				
					<table class="form_table_inner">
						<tr>
							<td class="label">Company Type :</td>
							<td><select name="company_type" id="company_type"><option value=''>--Select Comapny type--</option>
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
						
						
					</table>				
				</td>	
			</tr>
		</table>					
		</fieldset>


		<!-- Contact Information -->
		<fieldset>
			<legend>Contact Information :</legend>			 
				<!-- <div class="middle_form_design"> -->
					<div class="ui buttons">
						<input type="button" value="Remove" id="remove_contact_info" class="ui button">
						<div class="or"></div>
						<input type="button" value="Add" id="add_contact_info" class="ui positive button">
					</div>					
					</br>
					 
					<table class="form_table_design" id="tbl_contact_info">
						<?php if(!empty($this->input->post('sr_no[]'))){
								$j=1;
								for($i=0;$i<count($this->input->post('sr_no[]'));$i++){										 
									echo'<tr class="class_contact_info" id="tr_"'.$j++.'>
										<td style="align:center;">'.$j++.'</td>
										<td width="50%">
											<table class="form_table_inner" >
												<tr>
													<td class="label">Contact Name <span style="color:red;">*</span> :</td>
													<td><input type="hidden" name="sr_no[]"/>
													<input type="text" name="contact_name[]" value="'.set_value('contact_name[]').'" size="50"/>
													</td>
												</tr>
												<tr>
													<td class="label">Position <span style="color:red;">*</span> :</td>
													<td><select name="position[]" >					
													<option value="">--SELECT POSITION--</option>';
													if($sales_quotes_designation_master==FALSE){
														echo'<option>--Setup Required--</option>';
													}
													else{
														foreach ($sales_quotes_designation_master as $row) {
															 
															echo'<option value="'.$row->id.'" '.set_select('position[]',$row->id).'>'.$row->designation.'</option>';
														}
													}
													echo'</select>
													</td>
												</tr>
												<tr>	
													<td class="label">Comapny Contact No <span style="color:red;">*</span> :</td>
													<td><input type="text" name="company_contact_no[]" value="'.set_value('company_contact_no[]').'">
													</td>
												</tr>
												<tr>	
													<td class="label">Personal Contact No <span style="color:red;">*</span> :</td>
													<td><input type="text" name="personal_contact_no[]" value="'.set_value('personal_contact_no[]').'">
													</td>
												</tr>
												<tr>	
													<td class="label">Company Email <span style="color:red;">*</span> :</td>
													<td><input type="text" name="company_email[]" value="'.set_value('company_email[]').'" size="50">
													</td>
												</tr>
												<tr>	
													<td class="label">Personal Email <span style="color:red;">*</span> :</td>
													<td><input type="text" name="personal_email[]" value="'.set_value('personal_email[]').'" size="50">
													</td>
												</tr>
											</table>
										</td>
										<td width="50%">
											<table class="form_table_inner">		
												<tr>	
													<td class="label">Located At <span style="color:red;">*</span> :</td>
													<td><input type="text" name="located_at[]" value="'.set_value('located_at[]').'" size="50">
													</td>
												</tr>
												<tr>	
													<td class="label">Birth Date <span style="color:red;">*</span> :</td>
													<td><input type="date" name="birth_date[]" value="'.set_value('birth_date[]').'">
													</td>
												</tr>
												<tr>	
													<td class="label">Previous Job<span style="color:red;">*</span> :</td>
													<td><input type="text" name="previous_job[]" value="'.set_value('previous_job[]').'">
													</td>
												</tr>
												<tr>
													<td class="label">Previous Position <span style="color:red;">*</span> :</td>
													<td><select name="previous_position[]" >					
													<option value="">--PREVIOUS POSITION--</option>';
													if($sales_quotes_designation_master==FALSE){
														echo'<option>--Setup Required--</option>';
													}
													else{
														foreach ($sales_quotes_designation_master as $row) {
															 
															echo'<option value="'.$row->id.'" '.set_select('previous_position[]',$row->id).'>'.$row->designation.'</option>';
														}
													}
													echo'</select>
													</td>
												</tr>
												<tr>	
													<td class="label">History If Any<span style="color:red;">*</span> :</td>
													<td><input type="text" name="history_if_any[]" value="'.set_value('history_if_any[]').'" size="50">
													</td>
												</tr>
												<tr>	
													<td class="label">Active<span style="color:red;">*</span> :</td>
													<td> 
														<select name="active[]">
															<option value="">--Select Active--</option>
															<option value="1" '.set_select('active[]','1').'>Active</option>
															<option value="0" '.set_select('active[]','0').'>Inactive</option>
														</select>		
													</td>
												</tr>
												<tr>
													<td class="label">3D Representative  <span style="color:red;">*</span> :</td>
													<td><select name="repesentative_3d[]" >					
													<option value="">--3D REPRESENTATIVE--</option>';
													if($employee_master==FALSE){
														echo'<option>--Setup Required--</option>';
													}
													else{
														foreach ($employee_master as $row) {
															 
															echo'<option value="'.$row->employee_id.'" '.set_select('repesentative_3d[]',$row->employee_id).'>'.strtoupper($row->name1.' '.$row->name2).'</option>';
														}
													}
													echo'</select>
													</td>
												</tr>
											</table>				
										</td>
									</tr>';
						
								}
							}	
							else{
								echo'<tr class="class_contact_info" id="tr_1">
										<td style="align:center;">1</td>
										<td width="50%">
											<table class="form_table_inner" >
												<tr>
													<td class="label">Contact Name <span style="color:red;">*</span> :</td>
													<td><input type="hidden" name="sr_no[]" value="'.set_value("sr_no[]").'"/>
													<input type="text" name="contact_name[]" value="'.set_value("contact_name[]").'" size="50"></td>
												</tr>
												<tr>
													<td class="label">Position <span style="color:red;">*</span> :</td>
													<td><select name="position[]" >					
													<option value="">--SELECT POSITION--</option>';
													if($sales_quotes_designation_master==FALSE){
														echo'<option>--Setup Required--</option>';
													}
													else{
														foreach ($sales_quotes_designation_master as $row) {
															 
															echo'<option value="'.$row->id.'" '.set_select("position[]",$row->id).'>'.$row->designation.'</option>';
														}
													}
													echo'</select>
													</td>
												</tr>

												<tr>	
													<td class="label">Comapny Contact No <span style="color:red;">*</span> :</td>
													<td><input type="text" name="company_contact_no[]" value="'.set_value('company_contact_no[]').'">
													</td>
												</tr>
												<tr>	
													<td class="label">Personal Contact No <span style="color:red;">*</span> :</td>
													<td><input type="text" name="personal_contact_no[]" value="'.set_value('personal_contact_no[]').'">
													</td>
												</tr>
												<tr>	
													<td class="label">Company Email <span style="color:red;">*</span> :</td>
													<td><input type="text" name="company_email[]" value="'.set_value('company_email[]').'" size="50">
													</td>
												</tr>
												<tr>	
													<td class="label">Personal Email <span style="color:red;">*</span> :</td>
													<td><input type="text" name="personal_email[]" value="'.set_value('personal_email[]').'" size="50">
													</td>
												</tr>
											</table>
										</td>
										<td width="50%">
											<table class="form_table_inner">		
												<tr>	
													<td class="label">Located At <span style="color:red;">*</span> :</td>
													<td><input type="text" name="located_at[]" value="'.set_value('located_at[]').'" size="50">
													</td>
												</tr>
												<tr>	
													<td class="label">Birth Date <span style="color:red;">*</span> :</td>
													<td><input type="date" name="birth_date[]" value="'.set_value('birth_date[]').'">
													</td>
												</tr>
												<tr>	
													<td class="label">Previous Job<span style="color:red;">*</span> :</td>
													<td><input type="text" name="previous_job[]" value="'.set_value('previous_job[]').'">
													</td>
												</tr>
												<tr>
													<td class="label">Previous Position <span style="color:red;">*</span> :</td>
													<td><select name="previous_position[]" >					
													<option value="">--PREVIOUS POSITION--</option>';
													if($sales_quotes_designation_master==FALSE){
														echo'<option>--Setup Required--</option>';
													}
													else{
														foreach ($sales_quotes_designation_master as $row) {
															 
															echo'<option value="'.$row->id.'" '.set_select('previous_position[]',$row->id).'>'.$row->designation.'</option>';
														}
													}
													echo'</select>
													</td>
												</tr>
												<tr>	
													<td class="label">History If Any<span style="color:red;">*</span> :</td>
													<td><input type="text" name="history_if_any[]" value="'.set_value('history_if_any[]').'" size="50">
													</td>
												</tr>
												<tr>	
													<td class="label">Active<span style="color:red;">*</span> :</td>
													<td> 
														<select name="active[]">
															<option value="">--Select Active--</option>
															<option value="1" '.set_select('active[]','1').'>Active</option>
															<option value="0" '.set_select('active[]','0').'>Inactive</option>
														</select		
													</td>
												</tr>
												<tr>
													<td class="label">3D Representative  <span style="color:red;">*</span> :</td>
													<td><select name="repesentative_3d[]" >					
													<option value="">--3D REPRESENTATIVE--</option>';
													if($employee_master==FALSE){
														echo'<option>--Setup Required--</option>';
													}
													else{
														foreach ($employee_master as $row) {
															 
															echo'<option value="'.$row->employee_id.'" '.set_select('repesentative_3d[]',$row->employee_id).'>'.strtoupper($row->name1.' '.$row->name2).'</option>';
														}
													}
													echo'</select>
													</td>
												</tr>
											</table>				
										</td>
									</tr>';
							}
						?>
					</table>
				<!-- </div>					  -->
		</fieldset>
		<!-- Product Information -->
		<fieldset>
			<legend>Product Information :</legend>			 
				<!-- <div class="middle_form_design"> -->
					<div class="ui buttons">
						<input type="button" value="Remove" id="remove_product_info" class="ui button">
						<div class="or"></div>
						<input type="button" value="Add" id="add_product_info" class="ui positive button">
					</div>					
					</br>
					 
					<table class="form_table_design" id="tbl_product_info">
						<?php if(!empty($this->input->post('sr_no_product[]'))){
								$j=1;
								for($i=0;$i<count($this->input->post('sr_no_product[]'));$i++){										 
									echo'<tr class="class_product_info" id="product_info_tr_"'.$j++.'>
										<td style="align:center;">'.$j++.'</td>
										<td width="50%">
											<table class="form_table_inner" >
												<tr>
													<td class="label">Product Name <span style="color:red;">*</span> :</td>
													<td><input type="hidden" name="sr_no_product[]" name="sr_no_product[]"/>
													<input type="text" name="product_name[]" value="'.set_value('product_name[]').'" size="50"></td>
												</tr>
												<tr>
													<td class="label">Product Type <span style="color:red;">*</span> :</td>
													<td><select name="product_type[]" >					
													<option value="">--SELECT TYPE--</option>';
													if($sales_quotes_product_types_master==FALSE){
														echo'<option>--Setup Required--</option>';
													}
													else{
														foreach ($sales_quotes_product_types_master as $row) {
															 
															echo'<option value="'.$row->id.'" '.set_select('product_type[]',$row->id).'>'.$row->product_type.'</option>';
														}
													}
													echo'</select>
													</td>
												</tr>
												<tr>
													<td class="label">Category <span style="color:red;">*</span> :</td>
													<td><select name="product_category[]" >					
													<option value="">--SELECT CATEGORY--</option>';
													if($sales_quotes_product_category_master==FALSE){
														echo'<option>--Setup Required--</option>';
													}
													else{
														foreach ($sales_quotes_product_category_master as $row) {
															 
															echo'<option value="'.$row->id.'" '.set_select('product_category[]',$row->id).'>'.$row->product_category.'</option>';
														}
													}
													echo'</select>
													</td>
												</tr>
												<tr>
													<td class="label">Packaging <span style="color:red;">*</span> :</td>
													<td><select name="product_packaging[]" >					
													<option value="">--SELECT PACKAGING--</option>';
													if($sales_quotes_packaging_master==FALSE){
														echo'<option>--Setup Required--</option>';
													}
													else{
														foreach ($sales_quotes_packaging_master as $row) {
															 
															echo'<option value="'.$row->id.'" '.set_select('product_packaging[]',$row->id).'>'.$row->packaging_type.'</option>';
														}
													}
													echo'</select>
													</td>
												</tr>										
												 
											</table>
										</td>
										<td width="50%">
											<table class="form_table_inner">		
												<tr>	
													<td class="label">Price Range<span style="color:red;">*</span> :</td>
													<td>Min: <input class="number" type="number" name="product_price_range_min[]" value="'.set_value('product_price_range_min[]').'" /> Max: <input class="number" type="number" name="product_price_range_max[]" value="'.set_value('product_price_range_max[]').'" />
													</td>
												</tr>
												<tr>	
													<td class="label">Price range of Products in Tubes <span style="color:red;">*</span> :</td>
													<td>Min: <input class="number" type="number" name="product_price_range_intubes_min[]" value="'.set_value('product_price_range_intubes_min[]').'" /> Max: <input class="number" type="number" name="product_price_range_intubes_max[]" value="'.set_value('product_price_range_intubes_max[]').'" />
													</td>
												</tr>
												 
												<tr>	
													<td class="label">Current Supplier<span style="color:red;">*</span> :</td>
													<td><input type="text"  name="current_supplier[]" value="'.set_value('current_supplier[]').'" size="50">
													</td>
												</tr> 
												<tr>
													<td class="label">Current Printing Technology <span style="color:red;">*</span> :</td>
													<td><select name="printing_technology[]" >					
													<option value="">--PRINTING TECHNOLOGY--</option>';
													if($sales_quotes_printing_technology_master==FALSE){
														echo'<option>--Setup Required--</option>';
													}
													else{
														foreach ($sales_quotes_printing_technology_master as $row) {
															 
															echo'<option value="'.$row->id.'" '.set_select('printing_technology[]',$row->id).'>'.$row->printing_technology.'</option>';
														}
													}
													echo'</select>
													</td>
												</tr>
												
											</table>				
										</td>
									</tr>';
						
								}
							}	
							else{
								echo'<tr class="class_product_info" id="product_info_tr_1">
										<td style="align:center;">1</td>
										<td width="50%">
											<table class="form_table_inner" >
												<tr>
													<td class="label">Product Name <span style="color:red;">*</span> :</td>
													<td><input type="hidden" name="sr_no_product[]" name="sr_no_product[]" value="'.set_value('sr_no_product[]').'"/>
													<input type="text" name="product_name[]" value="'.set_value('product_name[]').'" size="50"></td>
												</tr>
												<tr>
													<td class="label">Product Type <span style="color:red;">*</span> :</td>
													<td><select name="product_type[]" >					
													<option value="">--SELECT TYPE--</option>';
													if($sales_quotes_product_types_master==FALSE){
														echo'<option>--Setup Required--</option>';
													}
													else{
														foreach ($sales_quotes_product_types_master as $row) {
															 
															echo'<option value="'.$row->id.'" '.set_select('product_type[]',$row->id).'>'.$row->product_type.'</option>';
														}
													}
													echo'</select>
													</td>
												</tr>
												<tr>
													<td class="label">Category <span style="color:red;">*</span> :</td>
													<td><select name="product_category[]" >					
													<option value="">--SELECT CATEGORY--</option>';
													if($sales_quotes_product_category_master==FALSE){
														echo'<option>--Setup Required--</option>';
													}
													else{
														foreach ($sales_quotes_product_category_master as $row) {
															 
															echo'<option value="'.$row->id.'" '.set_select('product_category[]',$row->id).'>'.$row->product_category.'</option>';
														}
													}
													echo'</select>
													</td>
												</tr>
												<tr>
													<td class="label">Packaging <span style="color:red;">*</span> :</td>
													<td><select name="product_packaging[]" >					
													<option value="">--SELECT PACKAGING--</option>';
													if($sales_quotes_packaging_master==FALSE){
														echo'<option>--Setup Required--</option>';
													}
													else{
														foreach ($sales_quotes_packaging_master as $row) {
															 
															echo'<option value="'.$row->id.'" '.set_select('product_packaging[]',$row->id).'>'.$row->packaging_type.'</option>';
														}
													}
													echo'</select>
													</td>
												</tr>										
												 
											</table>
										</td>
										<td width="50%">
											<table class="form_table_inner">		
												<tr>	
													<td class="label">Price Range<span style="color:red;">*</span> :</td>
													<td>Min: <input class="number" type="number" name="product_price_range_min[]" value="'.set_value('product_price_range_min[]').'" /> Max: <input class="number" type="number" name="product_price_range_max[]" value="'.set_value('product_price_range_max[]').'" />
													</td>
												</tr>
												<tr>	
													<td class="label">Price range of Products in Tubes <span style="color:red;">*</span> :</td>
													<td>Min: <input class="number" type="number" name="product_price_range_intubes_min[]" value="'.set_value('product_price_range_intubes_min[]').'" /> Max: <input class="number" type="number" name="product_price_range_intubes_max[]" value="'.set_value('product_price_range_intubes_max[]').'" />
													</td>
												</tr>
												 
												<tr>	
													<td class="label">Current Supplier<span style="color:red;">*</span> :</td>
													<td><input type="text"  name="current_supplier[]" value="'.set_value('current_supplier[]').'" size="50">
													</td>
												</tr> 
												<tr>
													<td class="label">Current Printing Technology <span style="color:red;">*</span> :</td>
													<td><select name="printing_technology[]" >					
													<option value="">--PRINTING TECHNOLOGY--</option>';
													if($sales_quotes_printing_technology_master==FALSE){
														echo'<option>--Setup Required--</option>';
													}
													else{
														foreach ($sales_quotes_printing_technology_master as $row) {
															 
															echo'<option value="'.$row->id.'" '.set_select('printing_technology[]',$row->id).'>'.$row->printing_technology.'</option>';
														}
													}
													echo'</select>
													</td>
												</tr>
												
											</table>				
										</td>
									</tr>';
							}
						?>			

					</table>
				<!-- </div>					  -->
		</fieldset>

		<!-- Buying Potential -->
		<fieldset>
			<legend>Buying Potential :</legend>			 
				<!-- <div class="middle_form_design"> -->
					<div class="ui buttons">
						<input type="button" value="Remove" id="remove_buying_potential" class="ui button">
						<div class="or"></div>
						<input type="button" value="Add" id="add_buying_potential" class="ui positive button">
					</div>					
					</br>					
					<table class="form_table_design" id="tbl_buying_potential">
					<?php 	if(!empty($this->input->post('sr_no_buying_potential[]'))){
								$j=1;
								for($i=0;$i<count($this->input->post('sr_no_buying_potential[]'));$i++){										 
									echo'<tr class="class_buying_potential" id="buying_potential_tr_'.$j++.'">
										<td style="align:center;">'.$j++.'</td>
										<td width="50%">
											<table class="form_table_inner" >
												<tr>
													<td class="label">Supplier <span style="color:red;">*</span> :</td>
													<td>
													<input type="hidden" name="sr_no_buying_potential[]"/>

													<select name="supplier[]" >					
													<option value="">--SELECT SUPPLIER--</option>';
													if($sales_quotes_supplier_master==FALSE){
														echo'<option>--Setup Required--</option>';
													}
													else{
														foreach ($sales_quotes_supplier_master as $row) {
															 
															echo'<option value="'.$row->supplier_id.'" '.set_select('position[]',$row->supplier_id).'>'.$row->supplier_name.'</option>';
														}
													}
													echo'</select>
													</td>
												</tr>
												<tr>
													<td class="label">Tubes Currently Buying <span style="color:red;">*</span> :</td>
													<td><select name="tubes_currently_buying[]" >					
													<option value="">--SELECT TECHNOLOGY--</option>';
													if($sales_quotes_printing_technology_master==FALSE){
														echo'<option>--Setup Required--</option>';
													}
													else{
														foreach ($sales_quotes_printing_technology_master as $row) {
															 
															echo'<option value="'.$row->id.'" '.set_select('tubes_currently_buying[]',$row->id).'>'.$row->printing_technology.'</option>';
														}
													}
													echo'</select>
													</td>
												</tr>												
												 
											</table>
										</td>
										<td width="50%">
											<table class="form_table_inner">		
												<tr>	
													<td class="label">Min Volume <span style="color:red;">*</span> :</td>
													<td><input class="number1" type="number" name="min_volume[]" value="'.set_value('min_volume[]').'">
													</td>
												</tr>
												<tr>	
													<td class="label">Max Volume <span style="color:red;">*</span> :</td>
													<td><input class="number1" type="number" name="max_volume[]" value="'.set_value('max_volume[]').'">
													</td>
												</tr>
												<tr>	
													<td class="label">3D Volume <span style="color:red;">*</span> :</td>
													<td><input class="number1" type="number" name="three_d_volume[]" value="'.set_value('three_d_volume[]').'">
													</td>
												</tr>
											</table>				
										</td>
									</tr>';						
								}
							}	
							else{
								echo'<tr class="class_buying_potential" id="buying_potential_tr_1">
										<td style="align:center;">1</td>
										<td width="50%">
											<table class="form_table_inner"> 
												<tr>
													<td class="label">Supplier <span style="color:red;">*</span> :</td>
													<td><select name="supplier[]" >					
													<option value="">--SELECT SUPPLIER--</option>';
													if($sales_quotes_supplier_master==FALSE){
														echo'<option>--Setup Required--</option>';
													}
													else{
														foreach ($sales_quotes_supplier_master as $row) {
															 
															echo'<option value="'.$row->supplier_id.'" '.set_select('position[]',$row->supplier_id).'>'.$row->supplier_name.'</option>';
														}
													}
													echo'</select>
													</td>
												</tr>
												<tr>
													<td class="label">Tubes Currently Buying <span style="color:red;">*</span> :</td>
													<td><select name="tubes_currently_buying[]" >					
													<option value="">--SELECT TECHNOLOGY--</option>';
													if($sales_quotes_printing_technology_master==FALSE){
														echo'<option>--Setup Required--</option>';
													}
													else{
														foreach ($sales_quotes_printing_technology_master as $row) {
															 
															echo'<option value="'.$row->id.'" '.set_select('tubes_currently_buying[]',$row->id).'>'.$row->printing_technology.'</option>';
														}
													}
													echo'</select>
													</td>
												</tr>												
												 
											</table>
										</td>
										<td width="50%">
											<table class="form_table_inner">		
												<tr>	
													<td class="label">Min Volume <span style="color:red;">*</span> :</td>
													<td><input class="number1" type="number" name="min_volume[]" value="'.set_value('min_volume[]').'">
													</td>
												</tr>
												<tr>	
													<td class="label">Max Volume <span style="color:red;">*</span> :</td>
													<td><input class="number1" type="number" name="max_volume[]" value="'.set_value('max_volume[]').'">
													</td>
												</tr>
												<tr>	
													<td class="label">3D Volume <span style="color:red;">*</span> :</td>
													<td><input class="number1" type="number" name="three_d_volume[]" value="'.set_value('three_d_volume[]').'">
													</td>
												</tr>
											</table>				
										</td>
									</tr>';
							}
						?>
					</table>
					<!-- </div>									  -->
		</fieldset>

	</div>	

	<div class="form_design">
		<div class="ui buttons">
	  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui positive button" onClick="return confirm('Are you sure to save Record?');">Save</button>
		</div>
	</div>

	
</form>




				
				
				
			