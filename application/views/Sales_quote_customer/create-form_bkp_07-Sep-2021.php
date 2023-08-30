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

		 	
		// Contact Info---------------
		$("#add_contact_info").click(function(e){   			
		 	//var counter= $('#tbl_contact_info tr').length;

		 	alert('ci');

		 	var counter= $('#tablePanton tr').length-1;			 	

		 	//var counter= $('#tbl_contact_info tbody tr.class_contact_info').length+1; 
		 	//alert(counter);		
			var markup = '<tr class="class_contact_info" id="tr_'+ counter +'"><td><input type="hidden" name="sr_no[]" value="'+counter+'"/>'+ counter +'</td><td><input type="text" name="contact_name[]" value="<?php echo set_value("contact_name[]");?>" size="20"/></td><td><select name="position[]" ><option value="">--POSITION--</option><?php if($sales_quotes_designation_master==FALSE){ echo'<option>--Setup Required--</option>';} else { foreach ($sales_quotes_designation_master as $row) { echo'<option value="'.$row->id.'" '.set_select("position[]",$row->id).'>'.$row->designation.'</option>';}}?></select></td><td><input type="text" name="company_contact_no[]" value="<?php echo set_value('company_contact_no[]');?>" size="10" maxlength="15"></td><td><input type="text" name="personal_contact_no[]" value="<?php echo set_value('personal_contact_no[]');?>" size="10" maxlength="15"> </td><td><input type="text" name="company_email[]" value="<?php echo set_value('company_email[]');?>" size="25"></td><td><input type="text" name="personal_email[]" value="<?php echo set_value('personal_email[]');?>" size="25"></td><td><input type="text" name="located_at[]" value="<?php echo set_value('located_at[]');?>" size="20"></td><td><input type="date" name="birth_date[]" value="<?php echo set_value('birth_date[]');?>"></td><td><input type="text" name="previous_job[]" value="<?php echo set_value('previous_job[]');?>"></td><td><select name="previous_position[]" ><option value="">--POSITION--</option><?php if($sales_quotes_designation_master==FALSE){echo'<option>--Setup Required--</option>';} else{ foreach ($sales_quotes_designation_master as $row){ echo'<option value="'.$row->id.'" '.set_select('previous_position[]',$row->id).'>'.$row->designation.'</option>'; }}?></select></td><td><input type="text" name="history_if_any[]" value="<?php echo set_value('history_if_any[]');?>" size="50"></td><td><select name="repesentative_3d[]"><option value="">--SELECT--</option><?php if($employee_master==FALSE){echo'<option>--Setup Required--</option>';} else{ foreach ($employee_master as $row){echo'<option value="'.$row->employee_id.'" '.set_select('repesentative_3d[]',$row->employee_id).'>'.strtoupper($row->name1.' '.$row->name2).'</option>';}}?> </select> </td> <td> <select name="active[]"><option value="">--STATUS--</option><option value="1" "<?php echo set_select('active[]','1');?>">Active</option><option value="0" "<?php echo set_select('active[]','0');?>">Inactive</option></select></td></tr>';			
			
			alert(markup);
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

		 	var counter= $('#tableBuyingPotential tr').length;			 	

		 	//var counter= $('#tbl_contact_info tbody tr.class_contact_info').length+1; 
		 	//alert(counter);		
			var markup = '<tr class="class_buying_potential" id="buying_potential_tr_'+ counter +'"><td><input type="hidden" name="buying_potential_sr_no[]" value="'+ counter +'"/>'+ counter +'</td> <td><select name="tubes_curretly_buying[]" ><option value="">--CURRENTLY BUYING--</option><?php if($sales_quotes_packaging_master==FALSE){ echo'<option>--Setup Required--</option>';} else { foreach ($sales_quotes_packaging_master as $row) { echo'<option value="'.$row->id.'" '.set_select("tubes_curretly_buying[]",$row->id).'>'.$row->packaging_type.'</option>';}}?></select></td><td><input type="number" name="min_volume[]" value="<?php echo set_value('min_volume[]');?>"></td><td><input type="number" name="max_volume[]" value="<?php echo set_value('max_volume[]');?>" size="10" maxlength="15"></td><td><input type="number" name="three_d_volume[]" value="<?php echo set_value('three_d_volume[]');?>"/></td>';		
			
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

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		 
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
						<td><input type="text" name="city" maxlength="100" size="20" value="<?php echo set_value('city');?>" />&nbsp;&nbsp;&nbsp; Pincode <span style="color:red;">*</span> : <input type="text" name="pin_code" maxlength="6" size="20" value="<?php echo set_value('pin_code');?>" pattern="[0-9]*" /></td>
					</tr>
					 
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
	</div>
	<br/>
	<br/>


		

		<!-- Contact Information -->		
		<div class="middle_form_design">
		<div class="middle_form_inner_design" style="overflow:scroll;font-size: 9px;" >
			
			<div class="ui buttons">
				<input type="button" value="Remove" id="remove_contact_info" class="ui button">
				<div class="or"></div>
				<input type="button" value="Add" id="add_contact_info" class="ui positive button">
			</div>		 

			<table class="ui very basic collapsing celled table" id="tablePanton" >
				<thead>
				<tr>
					<th colspan="3"></th>
					<th colspan="2">Contact No</th>
					<th colspan="2">Email</th>
					<th colspan="2"></th>
					<th colspan="2">Previous</th>
				</tr> 
				<tr>
					<th>Sr.No.</th>
					<th>Name </th>
					<th>Position</th>
					<th >Company</th>
					<th class="positive">Personal</th>
					<th>Company</th>
					<th>Personal</th>
					<th>Located At</th>
					<th>Birth Date</th>
					<th>Job</th>
					<th>Position</th>
					<th>History If Any</th>
					<th>3D Representative</th>
					<th>Status</th>							 
						
				</tr>
			</thead>
			<tbody>					 
			 
				<?php 
				if(!empty($this->input->post('sr_no[]'))){
						$j=1;
						for($i=0;$i<count($this->input->post('sr_no[]'));$i++){										 
							echo'<tr class="class_contact_info" id="tr_'.$j.'">
							<td><input type="hidden" name="sr_no[]" value="'.$j.'"/>
							'.$j.'</td>
							<td><input type="text" name="contact_name[]" value="'.set_value('contact_name[]').'" size="20"/></td>					 
							<!--<td><select name="position[]">					
							<option value="">--POSITION--</option>';
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
							<td><input type="text" name="company_contact_no[]" value="'.set_value('company_contact_no[]').'" size="10" maxlength="15">
							</td>							 
							<td><input type="text" name="personal_contact_no[]" value="'.set_value('personal_contact_no[]').'" size="10" maxlength="15">
							</td>							 
							<td><input type="text" name="company_email[]" value="'.set_value('company_email[]').'" size="25">
							</td>										 												 
							<td><input type="text" name="personal_email[]" value="'.set_value('personal_email[]').'" size="25">
							</td>
						 
							<td><input type="text" name="located_at[]" value="'.set_value('located_at[]').'" size="20">
							</td>
						 
							<td><input type="date" name="birth_date[]" value="'.set_value('birth_date[]').'">
							</td>
						 
							<td><input type="text" name="previous_job[]" value="'.set_value('previous_job[]').'">
							</td>									 
							 
							<td><select name="previous_position[]" >					
							<option value="">--POSITION--</option>';
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
							<td><input type="text" name="history_if_any[]" value="'.set_value('history_if_any[]').'" size="50">
							</td> 
							<td><select name="repesentative_3d[]" >					
							<option value="">--SELECT--</option>';
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
							<td> 
								<select name="active[]">
									<option value="">--STATUS--</option>
									<option value="1" '.set_select('active[]','1').'>Active</option>
									<option value="0" '.set_select('active[]','0').'>Inactive</option>
								</select		
							</td>-->
						</tr>';

						$j++;

						}
					}	
					else{
						 
						echo'<tr class="class_contact_info" id="tr_1">

							<td><input type="hidden" name="sr_no[]" value="1"/>
								1
							</td>
							<td> <input type="text" name="contact_name[]" value="'.set_value("contact_name[]").'" size="20"></td>
					 
							<td><select name="position[]" >					
							<option value="">--POSITION--</option>';
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
							<td><input type="text" name="company_contact_no[]" value="'.set_value('company_contact_no[]').'" size="10" maxlength="15">
							</td>							 
							<td><input type="text" name="personal_contact_no[]" value="'.set_value('personal_contact_no[]').'" size="10" maxlength="15">
							</td>							 
							<td><input type="text" name="company_email[]" value="'.set_value('company_email[]').'" size="25">
							</td>										 												 
							<td><input type="text" name="personal_email[]" value="'.set_value('personal_email[]').'" size="25">
							</td>
						 
							<td><input type="text" name="located_at[]" value="'.set_value('located_at[]').'" size="20">
							</td>
						 
							<td><input type="date" name="birth_date[]" value="'.set_value('birth_date[]').'">
							</td>
						 
							<td><input type="text" name="previous_job[]" value="'.set_value('previous_job[]').'">
							</td>									 
							 
							<td><select name="previous_position[]" >					
							<option value="">--POSITION--</option>';
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
						 
							<td><input type="text" name="history_if_any[]" value="'.set_value('history_if_any[]').'" size="50">
							</td>
						 
							<td><select name="repesentative_3d[]" >					
							<option value="">--SELECT--</option>';
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
							<td> 
								<select name="active[]">
									<option value="">--STATUS--</option>
									<option value="1" '.set_select('active[]','1').'>Active</option>
									<option value="0" '.set_select('active[]','0').'>Inactive</option>
								</select		
							</td>
						</tr>';
					}
				?>
			</tbody>
			</table>					 
		</div>
		</div>
		<br/>
	
		<div class="middle_form_design">
		<div class="middle_form_inner_design">

		<table class="form_table_design">
			<tr>
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
											<input type="checkbox" name="product_type[]" value="'.$row->id.'" '.(!empty($this->input->post('product_type[]'))?(in_array($row->id,$this->input->post('product_type[]'),TRUE)?"checked":""):"").'>
											<label>'.$row->product_type.'</label>
											</div><br/>';
								 
										}
									}
								?>
							</td>
						</tr>
						<tr>
							<td class="label">Category <span style="color:red;">*</span> :</td>
							<td> 
								<?php   if ($sales_quotes_product_category_master==FALSE){
										echo'';
										}else{
											foreach($sales_quotes_product_category_master as $row){
												echo'<div class="ui checkbox">
												<input type="checkbox" name="product_category[]" value="'.$row->id.'" '.(!empty($this->input->post('product_category[]'))?(in_array($row->id,$this->input->post('product_category[]'),TRUE)?"checked":""):"").'>
												<label>'.$row->product_category.'</label>
												</div><br/>';								 
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
						<td class="label">Packaging <span style="color:red;">*</span> :</td>
						<td> 
							 
							<?php
							if($sales_quotes_packaging_master==FALSE){ 
							 	 echo'';
							}else{
							 	foreach($sales_quotes_packaging_master as $row){ 

							 		echo'<div class="ui checkbox">
											<input type="checkbox" name="packaging_type[]" value="'.$row->id.'" '.(!empty($this->input->post('packaging_type[]'))?(in_array($row->id,$this->input->post('packaging_type[]'),TRUE)?"checked":""):"").'>
											<label>'.$row->packaging_type.'</label>
											</div><br/>';	
							 	}
						 	}?>
						 	</select>
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
												<input type="checkbox" name="printing_technology[]" value="'.$row->id.'" '.(!empty($this->input->post('printing_technology[]'))?(in_array($row->id,$this->input->post('printing_technology[]'),TRUE)?"checked":""):"").'>
												<label>'.$row->printing_technology.'</label>
												</div><br/>';
									} 
								}
								?>							 
						</td>
					</tr>
					<tr>
						<td class="label">Price Range<span style="color:red;">*</span> :</td>
						 <td>Min: <input class="number" type="number" name="product_price_range_min" value="<?php echo set_value('product_price_range_min');?>"/> Max: <input class="number" type="number" name="product_price_range_max" value="<?php echo set_value('product_price_range_max');?>"/>
						 </td>
					</tr>
					<tr>
						<td class="label">Price range of Products in Tubes <span style="color:red;">*</span> :</td><td>Min: <input class="number" type="number" name="product_price_range_intubes_min" value="<?php echo set_value('product_price_range_intubes_min');?>"/> Max: <input class="number" type="number" name="product_price_range_intubes_max" value="<?php echo set_value('product_price_range_intubes_max');?>"/>
						</td>
					</tr>
					<tr>
						<td class="label">Current Supplier<span style="color:red;">*</span> :</td>
						<td><input type="text"  name="current_supplier" value="<?php echo set_value('current_supplier');?>" size="50">
						</td>
					</tr>					
					</table>
				</td>
			</tr>
		</table>
		</div>
		</div>
		<!-- <br/> -->
		<!-- Buying Information -->		
		<div class="middle_form_design">
		<div class="middle_form_inner_design" style="overflow:scroll;font-size: 9px;" >
			
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
					<th>Min Volume</th>
					<th>Max Volume</th>
					<th>3D Volume</th>				 						 
						
				</tr>
			</thead>
			<tbody>					 
			 
				<?php
					if(!empty($this->input->post('sr_no_buying_potential[]'))){
						$j=1;
						for($i=0;$i<count($this->input->post('sr_no_buying_potential[]'));$i++){										 
							echo'<tr class="class_buying_potential" id="buying_potential_tr_'.$j.'">

							<td><input type="hidden" name="sr_no_buying_potential[]" value="'.$j.'"/>
							'.$j.'
							</td>
							<td><select name="tubes_curretly_buying[]" >					
							<option value="">--CURRENTLY BUYING--</option>';
							if($sales_quotes_packaging_master==FALSE){
								echo'<option>--Setup Required--</option>';
							}
							else{
								foreach ($sales_quotes_packaging_master as $row) {
									 
									echo'<option value="'.$row->id.'" '.set_select("tubes_curretly_buying[]",$row->id).'>'.$row->packaging_type.'</option>';
								}
							}
							echo'</select>
							</td>								 
							<td><input type="number" name="min_volume[]" value="'.set_value('min_volume[]').'">
							</td>							 
							<td><input type="number" name="max_volume[]" value="'.set_value('max_volume[]').'" size="10" maxlength="15">
							</td>							 
							<td><input type="number" name="three_d_volume[]" value="'.set_value('three_d_volume[]').'"/>
							</td>';

						$j++;
						}
					}	
					else{
						 
						echo'<tr class="class_buying_potential" id="buying_potential_tr_1">

							<td><input type="hidden" name="buying_potential_sr_no[]" value="1"/>
								1
							</td>						 
					 
							<td><select name="tubes_curretly_buying[]" >					
							<option value="">--CURRENTLY BUYING--</option>';
							if($sales_quotes_packaging_master==FALSE){
								echo'<option>--Setup Required--</option>';
							}
							else{
								foreach ($sales_quotes_packaging_master as $row) {
									 
									echo'<option value="'.$row->id.'" '.set_select("tubes_curretly_buying[]",$row->id).'>'.$row->packaging_type.'</option>';
								}
							}
							echo'</select>
							</td>								 
							<td><input type="number" name="min_volume[]" value="'.set_value('min_volume[]').'">
							</td>							 
							<td><input type="number" name="max_volume[]" value="'.set_value('max_volume[]').'" size="10" maxlength="15">
							</td>							 
							<td><input type="number" name="three_d_volume[]" value="'.set_value('three_d_volume[]').'"/>
							</td>				 												 
							 
						</tr>';
					}
				?>
			</tbody>
			</table>					 
		</div>
		</div>

	<div class="form_design">
		<div class="ui buttons">
	  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui positive button" onClick="return confirm('Are you sure to save Record?');">Save</button>
		</div>
	</div>


</div>	
	
</form>




				
				
				
			