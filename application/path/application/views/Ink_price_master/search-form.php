<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();

		$("#customer_no").autocomplete("<?php echo base_url('index.php/ajax/customer');?>", {selectFirst: true});

	});
</script>


<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result');?>" method="POST" enctype="multipart/form-data">
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>

		<fieldset>
			<legend>Search:</legend>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">		

						<tr>
							<td class="label" >Stock Consumption Period <span style="color:red;">* (3 Month)</span> :</td>
							<td><input type="date" name="from_date" id="from_date" value="<?php echo set_value('from_date');?>">
							<input type="date" name="to_date" id="to_date" value="<?php echo set_value('to_date');?>"></td>
						</tr>

						<tr>
							<td class="label">Ink Type<span style="color:red;">*</span> :</td>
							<td><select name="ink_type">
								<option value="">--Please Select--</option>
									<option value="1" <?php echo set_select('ink_type','1');?>>Flexo</option>
									<option value="2" <?php echo set_select('ink_type','2');?>>Offset</option>
									<option value="3" <?php echo set_select('ink_type','3');?>>Screen</option>
									<option value="4" <?php echo set_select('ink_type','4');?>>Special Ink</option>
									
							</select></td>
						</tr>

						<tr>
							<td class="label">Stock Consumption Value <span style="color:red;">* (From Stock Report)</span> :</td>
							<td><input type="text" name="consumption_value" id="consumption_value" value="<?php echo set_value('consumption_value');?>"></td>
						</tr>

						<tr>
							<td class="label">Consumption Quantity<span style="color:red;">* <a href="<?php echo base_url('index.php/sales_invoice_book');?>" target="_blank">(From Stock Report)</a></span> :</td>
							<td><input type="text" name="consumption_quantity" id="consumption_quantity" value="<?php echo set_value('sale_of_tubes');?>"></td>
						</tr>

						<tr>
							<td class="label">Cost Per Kg <span style="color:red;">* (Automatic)</span> :</td>
							<td><input type="text" name="cost_per_kg"  id="cost_per_kg" value="<?php echo set_value('cost_per_kg');?>"></td>
						</tr>
																	 
						</table>			
								
				</td>
							
			</tr>
			<tr>
				<td>
					<div class="ui buttons">
				  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
				  		<div class="or"></div>
				  		<button class="ui positive button">Search</button>
					</div>
				</td>
			</tr>
		</table>
					
	</div>

	</fieldset>

</form>
