<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();


		$("#consumption_quantity").blur(function(){
			
								
			if($("#consumption_quantity").val()!='' && $("#consumption_value").val()!='0'){
					
					
						var consumption_unit_rate=	$("#consumption_value").val() / $("#consumption_quantity").val();
						consumption_unit_rate=consumption_unit_rate.toFixed(4);
						$("#consumption_unit_rate").val(consumption_unit_rate);
					
			}
		});

		


	});
</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save');?>" method="POST" enctype="multipart/form-data" autocomplete="off">
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">
									<tr>
										<td class="label" colspan="2"> <span style="color:red;">*Note: </span> To take data of three months:</td>
										
									</tr>
									<tr>
										<td class="label">From Date <span style="color:red;">*</span> :</td>
										<td><input type="date" name="from_date" value="<?php echo set_value('from_date');?>"></td>
									</tr>

									<tr>
										<td class="label">To Date <span style="color:red;">*</span> :</td>
										<td><input type="date" name="to_date" value="<?php echo set_value('to_date');?>"></td>
									</tr>
									<tr>
										<td class="label">Print Type<span style="color:red;">*</span> :</td>
										<td><select name="lacquer_type_id" id="lacquer_type_id" multiple><option value=''>--Select Print Type--</option>
										<?php if($lacquer_types_master==FALSE){
														echo "<option value=''>--Setup Required--</option>";
												}
											else{
												foreach($lacquer_types_master as $lacquer_types_master_row){
													echo "<option value='".$lacquer_types_master_row->lacquer_type_id."'  ".set_select('lacquer_type_id',''.$lacquer_types_master_row->lacquer_type_id.'').">".$lacquer_types_master_row->lacquer_type."</option>";
												}
										}?>
										</select></td>
									</tr>

									<tr>
										<td class="label">RM <span style="color:red;">*</span> :</td>
										<td><input type="text" name="rm" value="<?php echo set_value('rm');?>"></td>
									</tr>

									<tr>
										<td class="label">Consumption Value <span style="color:red;">*</span> :</td>
										<td><input type="text" name="consumption_value" id="consumption_value" value="<?php echo set_value('consumption_value');?>"></td>
									</tr>

									<tr>
										<td class="label">Consumption Quantity <span style="color:red;">*</span> :</td>
										<td><input type="text" name="consumption_quantity"  id="consumption_quantity"value="<?php echo set_value('consumption_quantity');?>"></td>
									</tr>

									<tr>
										<td class="label">Consumption Unit Rate <span style="color:red;">*</span> :</td>
										<td><input type="text" name="consumption_unit_rate"  id="consumption_unit_rate"value="<?php echo set_value('consumption_unit_rate');?>"></td>
									</tr>

								<!--	<tr>
										<td class="label">Apply From date <span style="color:red;">*</span> :</td>
										<td><input type="date" name="apply_from_date" value="<?php echo set_value('apply_from_date');?>"></td>
									</tr>

									<tr>
										<td class="label">Apply To date <span style="color:red;">*</span> :</td>
										<td><input type="date" name="apply_to_date" value="<?php echo set_value('apply_to_date');?>"></td>
									</tr>
								-->	
									 
						</table>			
								
				</td>
							
			</tr>
		</table>
					
	</div>

	<div class="form_design">
			
		<button class="submit" name="submit">Save</button> <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>">Cancel</a>
	</div>
</form>
