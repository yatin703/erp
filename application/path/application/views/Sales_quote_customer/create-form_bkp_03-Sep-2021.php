<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){

		$("#loading").hide(); $("#cover").hide();

		//$("#customer_category").autocomplete("<?php echo base_url('index.php/ajax/customer_category_autocomplete');?>", {selectFirst: true});

		$("#country").change('keyup',function(){
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/state');?>",data: {country : $("#country").val()},cache: false,success: function(html){
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

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
		<table class="form_table_design">
								 
			<tr>							
				<td class="label"> Customer: <span style="color:red;">*</span> :</td>
				<td colspan="3"><input type="text" name="customer_name" id="customer_name"  size="55" value="<?php echo set_value('customer_name');?>" required /></td>							
			</tr>
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
				<td class="label">Address <span style="color:red;">*</span> :</td>
				<td><textarea name="name3" maxlength="52" rows="2" cols="40" value="<?php echo set_value('name3');?>"><?php echo set_value('name3');?></textarea></td>
			</tr>
			<tr>
				<td class="label">City <span style="color:red;">*</span> :</td>
				<td><input type="text" name="city" maxlength="100" size="20" value="<?php echo set_value('city');?>" /></td>
			</tr>
			<tr>
				<td class="label">Pincode <span style="color:red;">*</span> :</td>
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
			 					 		 							
						 
		</table>
		</br>
		</br>					
		<table width="100%">
			<tr>
				<td width="33%">
					<div class="middle_form_design">
						<div class="ui buttons">
							<input type="button" value="Remove" id="remove" class="ui button">
							<div class="or"></div>
							<input type="button" value="Add" id="add" class="ui positive button">
						</div>
						
						</br>
						</br>
						<table class="form_table_design">
											 
								<tr>
									<td class="label">Contact Name <span style="color:red;">*</span> :</td>
									<td><input type="text" name="contact_name[]"></td>
								</tr>	
						</table>
					</div>
				</td>
				<td width="33%">
					<div class="middle_form_design">
						<div class="ui buttons">
							<input type="button" value="Remove" id="remove" class="ui button">
							<div class="or"></div>
							<input type="button" value="Add" id="add" class="ui positive button">
						</div>
						
						</br>
						</br>
						<table class="form_table_design">
											 
								<tr>
									<td>DEF</td>
								</tr>	
						</table>
					</div>
				</td>
				<td width="33%">
					<div class="middle_form_design">
						<div class="ui buttons">
							<input type="button" value="Remove" id="remove" class="ui button">
							<div class="or"></div>
							<input type="button" value="Add" id="add" class="ui positive button">
						</div>
						
						</br>
						</br>
						<table class="form_table_design">
											 
								<tr>
									<td>GHI</td>
								</tr>	
						</table>
					</div>
				</td>
			</tr>
		</table>			









	</div>	

	<div class="form_design">
		<div class="ui buttons">
	  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui positive button" onClick="return confirm('Are you sure to save Record?');">Save</button>
		</div>
	</div>

	
</form>




				
				
				
			