<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>

<script>

	$(document).ready(function(){

		$("#loading").hide(); $("#cover").hide();

		$("#customer_category").autocomplete("<?php echo base_url('index.php/ajax/customer_category_autocomplete');?>", {selectFirst: true});

		$("#adr_company_id").autocomplete("<?php echo base_url('index.php/ajax/customer');?>", {selectFirst: true});
		//.blur(function(){ $("#bill_to_address").html('address'); })
		$("#adr_company_id").live('keyup',function(){
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/customer_address');?>",data: {adr_company_id : $("#adr_company_id").val()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#bill_to_address").html(html);
				} 
			});
		});

		$("#primary_contact").autocomplete("<?php echo base_url('index.php/ajax/primary_contact_autocomplete');?>", {selectFirst: true});

		$("#secondary_contact").autocomplete("<?php echo base_url('index.php/ajax/primary_contact_autocomplete');?>", {selectFirst: true});



        $('.a').css('display', 'none');

		$('input[type="radio"]').click(function() {
             var inputValue = $(this).attr("value");

             if(inputValue=="2"){
             	//alert(inputValue);
             	//$("p").hide();
             	$('.h').css('display', 'none');         	
             	$('.a').css('display', '');
             }else{
             	$('.h').css('display', '');

             	$('.a').css('display', 'none');
             }
             // alert("Radio button " + inputValue + " is selected");
          });
		


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
	th{
		align:center;
	}	  
  
</style>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save');?>" method="POST" enctype="multipart/form-data">
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
		<fieldset>	
			<legend>Customer Information </legend>
		 
			<table class="form_table_design">
			<tr>
			<td width="50%">
				<table class="form_table_inner">
					<tr>							
						<td class="label"> New </td>
						<td colspan="3"><input type="radio" name="new" id="new" checked="checked" value="1" <?php echo set_radio('new','1',True);?>/>&nbsp; Existing
						<input type="radio" name="new" id="existing" value="2" <?php echo set_radio('new','2');?>></td>
														
					</tr>
					

					<tr>							
						<td class="label"> Customer <span style="color:red;">*</span></td>
						<td colspan="3"><input type="text" name="customer_category" id="customer_category" size="40" value="<?php echo set_value('customer_category');?>"/></td>							
					</tr>
					
					<tr class="a">
						<td class="label">Bill To <span style="color:red;">*</span> :</td>
						<td><input type="text" name="adr_company_id" id="adr_company_id"  size="60" value="<?php echo set_value('adr_company_id');?>" /></td>
					</tr>
					<tr  class="a">
						<td class="label">Billing Address <span style="color:red;">*</span> :</td>
						<td><span id="bill_to_address" style="font-family: verdana;font-size: 70%;"></td>
					</tr>

					<tr class="h">
						<td class="label">Address <span style="color:red;">*</span> </td>
						<td><textarea name="address" maxlength="512" rows="3" cols="55" value="<?php echo set_value('address');?>"><?php echo set_value('address');?></textarea></td>
					</tr>
					<tr class="h">
						<td class="label">Country <span style="color:red;">*</span></td>
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

					<tr class="h">
						<td class="label">State <span style="color:red;">*</span></td>
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

					<tr class="h">
						<td class="label">City <span style="color:red;">*</span></td>
						<td><input type="text" name="city" maxlength="100" size="20" value="<?php echo set_value('city');?>"/>
						</td>
							
					</tr>
					<tr class="h">
						<td class="label">Pincode <span style="color:red;">*</span></td>
						<td><input type="text" name="pincode" maxlength="6" size="20" value="<?php echo set_value('pincode');?>" pattern="[0-9]*" /></td>
					</tr>
					</span>
					 
				</table>
			</td>
			<td width="50%">				
				<table class="form_table_inner">
					<tr>
						<td class="label">Type <span style="color:red;">*</span></td>
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
							<td class="label">Ownership Type</td>
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

		<br/>

		<fieldset>
			<legend>Contact Information </legend>

			<table class="form_table_design">
			<tr>
			<td width="50%">
				<table class="form_table_inner"> 								 
					<tr>							
						<td class="label">Primary Contact <span style="color:red;">*</span></td>
						<td colspan="3"><input type="text" id="primary_contact" class="primary_contact" name="primary_contact" size="40" value="<?php echo set_value('primary_contact');?>"/></td>							
					</tr>
					 
				</table>
			</td>
			<td width="50%">				
				<table class="form_table_inner">
					<tr>							
						<td class="label">Secondary Contact </td>
						<td colspan="3"><input type="text" id="secondary_contact" class="secondary_contact" name="secondary_contact" size="40" value="<?php echo set_value('secondary_contact');?>"/></td>							
					</tr>
					
				</table>				
			</td>	
			</tr>
			</table>
		</fieldset>
	</div>


	
	
	<br/>

		

		<!-- Contact Information -->		
		<!--<div class="middle_form_design">
		<div class="middle_form_inner_design" style="overflow:scroll;font-size:13px;">

			<fieldset>	
			<legend>Contact Info: </legend>
			
			<div class="ui buttons">
				<input type="button" value="Remove" id="remove_contact_info" class="ui button">
				<div class="or"></div>
				<input type="button" value="Add" id="add_contact_info" class="ui positive button">
			</div>		 

			<table class="ui very basic collapsing celled table" id="tablePanton" >
				<thead>
				<tr>
					<th colspan="3" class="center aligned">Contact Name</th>
					<th colspan="2" class="center aligned">Contact No</th>
					<th colspan="2" class="center aligned">Email</th>
					<th colspan="2" class="center aligned"></th>
					<th colspan="3" class="center aligned">Previous</th>
					<th colspan="2"></th>
				</tr> 
				<tr>
					<th>Sr.No.</th>
					<th>Name </th>
					<th>Position</th>
					<th>Company</th>
					<th>Personal</th>
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

					//print_r($this->input->post('contact_name[]'));
						$j=1;
						for($i=0;$i<count($this->input->post('sr_no[]'));$i++){										 
							echo'<tr class="class_contact_info" id="tr_'.$j.'">
							<td><input type="hidden" name="sr_no[]" value="'.$j.'"/>
							'.$j.'</td>
							<td><input type="text" name="contact_name[]" value="'.set_value('contact_name['.$i.']').'" size="20"/></td>					 
							<td><select name="position[]">					
							<option value="">--POSITION--</option>';
							if($sales_quotes_designation_master==FALSE){
								echo'<option>--Setup Required--</option>';
							}
							else{
								foreach ($sales_quotes_designation_master as $row) {
									$selected=($this->input->post('position['.$i.']')==$row->id?"selected":"");
									echo'<option value="'.$row->id.'" '.$selected.'>'.$row->designation.'</option>';
								}
							}
							echo'</select>
							</td>								 
							<td><input type="text" name="company_contact_no[]" value="'.set_value('company_contact_no['.$i.']').'" size="10" maxlength="15">
							</td>							 
							<td><input type="text" name="personal_contact_no[]" value="'.set_value('personal_contact_no['.$i.']').'" size="10" maxlength="15">
							</td>							 
							<td><input type="text" name="company_email[]" value="'.set_value('company_email['.$i.']').'" size="25">
							</td>								 												 
							<td><input type="text" name="personal_email[]" value="'.set_value('personal_email['.$i.']').'" size="25">
							</td>
						 
							<td><input type="text" name="located_at[]" value="'.set_value('located_at['.$i.']').'" size="20">
							</td>
						 
							<td><input type="date" name="birth_date[]" value="'.set_value('birth_date['.$i.']').'">
							</td>
						 
							<td><input type="text" name="previous_job[]" value="'.set_value('previous_job['.$i.']').'">
							</td>									 
							 
							<td><select name="previous_position[]" >					
							<option value="">--POSITION--</option>';
							if($sales_quotes_designation_master==FALSE){
								echo'<option>--Setup Required--</option>';
							}
							else{
								foreach ($sales_quotes_designation_master as $row) {
									$selected=($this->input->post('previous_position['.$i.']')==$row->id?"selected":""); 
									echo'<option value="'.$row->id.'" '.$selected.'>'.$row->designation.'</option>';
								}
							}
							echo'</select>
							</td>						 
							<td><input type="text" name="history_if_any[]" value="'.set_value('history_if_any['.$i.']').'" size="50">
							</td> 
							<td><select name="repesentative_3d[]" >					
							<option value="">--SELECT--</option>';
							if($employee_master==FALSE){
								echo'<option>--Setup Required--</option>';
							}
							else{
								foreach ($employee_master as $row) {

									$selected=($this->input->post('repesentative_3d['.$i.']')==$row->employee_id?"selected":"");
									 
									echo'<option value="'.$row->employee_id.'" '.$selected.'>'.strtoupper($row->name1.' '.$row->name2).'</option>';
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
									 
									echo'<option value="'.$row->id.'" '.set_select("position[]").'>'.$row->designation.'</option>';
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
									 
									echo'<option value="'.$row->id.'" '.set_select('previous_position[]').'>'.$row->designation.'</option>';
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
				</fieldset>					 
		</div>
		</div>
		<br/>-->
	
		<div class="middle_form_design">
		<div class="middle_form_inner_design" style="font-size: 13px;" >
		<fieldset>
			<legend>Product Information :</legend>		
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
												<input type="checkbox" name="product_category[]" value="'.$row->product_category.'" '.(!empty($this->input->post('product_category[]'))?(in_array($row->product_category,$this->input->post('product_category[]'),TRUE)?"checked":""):"").'>
												<label>'.$row->product_category.'</label>
												<br/>
												</div><br/>';								 
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
											<input type="checkbox" name="packaging_type[]" value="'.$row->packaging_type.'" '.(!empty($this->input->post('packaging_type[]'))?(in_array($row->packaging_type,$this->input->post('packaging_type[]'),TRUE)?"checked":""):"").'>
											<label>'.$row->packaging_type.'</label>
											<br/>
											</div><br/>';	
							 	}
						 	}?>
						 	</select>
						 </td>
						</tr>

						<tr>
							<td class="label">Product Price M.R.P <span style="color:red;">*</span></td>
							 <td>Min  <input class="number" type="number" name="product_price_range_min" value="<?php echo set_value('product_price_range_min');?>"/> Max <input class="number" type="number" name="product_price_range_max" value="<?php echo set_value('product_price_range_max');?>"/>
							 </td>
						</tr>

						<tr>
							<td class="label">Product Tube Price  <span style="color:red;">*</span></td>
							 <td>Min  <input class="number" type="number" name="product_price_range_intubes_min" value="<?php echo set_value('product_price_range_intubes_min');?>"/> Max <input class="number" type="number" name="product_price_range_intubes_max" value="<?php echo set_value('product_price_range_intubes_max');?>"/>
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
											<input type="checkbox" name="product_type[]" value="'.$row->product_type.'" '.(!empty($this->input->post('product_type[]'))?(in_array($row->product_type,$this->input->post('product_type[]'),TRUE)?"checked":""):"").'>
											<label>'.$row->product_type.'</label><br/>
											</div><br/>';
								 
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
												<input type="checkbox" name="printing_technology[]" value="'.$row->printing_technology.'" '.(!empty($this->input->post('printing_technology[]'))?(in_array($row->printing_technology,$this->input->post('printing_technology[]'),TRUE)?"checked":""):"").'>
												<label>'.$row->printing_technology.'</label><br/>
												</div><br/>';
									} 
								}
								?>							 
						</td>
					</tr>
					
					<tr>
						<td class="label">Current Supplier <span style="color:red;">*</span></td>
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
					
					<tr>
						<td class="label">Customer rating</td>
						<td><input type="file" multiple="" name="images[]" ></td>
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
		<div class="middle_form_inner_design" style="overflow:scroll;font-size: 13px;" >

			<fieldset>
			<legend>(Yearly) Buying Potential:</legend>	
			
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
							<td><input type="text" name="min_volume[]" value="'.set_value('min_volume['.$i.']').'">
							</td>							 
							<td><input type="text" name="max_volume[]" value="'.set_value('max_volume['.$i.']').'" >
							</td>							 
							<td><input type="text" name="three_d_volume[]" value="'.set_value('three_d_volume[]').'"/>
							</td>';

						$j++;
						}
					}	
					else{
						 
						echo'<tr class="class_buying_potential" id="buying_potential_tr_1">

							<td><input type="hidden" name="buying_potential_sr_no[]" value="1"/>
								1
							</td>						 
					 
							<td><select name="tubes_currently_buying[]" >					
							<option value="">--CURRENTLY BUYING--</option>';
							if($sales_quotes_packaging_master==FALSE){
								echo'<option>--Setup Required--</option>';
							}
							else{
								foreach ($sales_quotes_packaging_master as $row) {
									 
									echo'<option value="'.$row->id.'" '.set_select("tubes_currently_buying[]").'>'.$row->packaging_type.'</option>';
								}
							}
							echo'</select>
							</td>								 
							<td><input type="text" name="min_volume[]" value="'.set_value('min_volume[]').'">
							</td>							 
							<td><input type="text" name="max_volume[]" value="'.set_value('max_volume[]').'" >
							</td>							 
							<td><input type="text" name="three_d_volume[]" value="'.set_value('three_d_volume[]').'"/>
							</td>				 												 
							 
						</tr>';
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
	  		<button class="ui positive button" onClick="return confirm('Are you sure to save Record?');">Save</button>
		</div>
	</div>


</div>	
	
</form>




				
				
				
			