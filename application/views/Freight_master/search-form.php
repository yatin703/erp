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
							<td class="label">Customer <span style="color:red;">*</span> :</td>
							<td><input type="text" name="customer_no" id="customer_no"  size="60" value="<?php echo set_value('customer_no');?>" /></td>
						</tr>
						<tr>
							<td class="label">Dia<span style="color:red;">*</span> :</td>
							<td><select name="sleeve_id" id="sleeve_id">
								<option value=''>--Select Dia--</option>
							<?php 
								if($sleeve_diameter_master==FALSE){
									echo "<option value=''>--Setup Required--</option>";
								}
								else{
									foreach($sleeve_diameter_master as $sleeve_diameter_master_row){
										echo "<option value='".$sleeve_diameter_master_row->sleeve_diameter."'  ".set_select('sleeve_id',''.$sleeve_diameter_master_row->sleeve_diameter.'').">".$sleeve_diameter_master_row->sleeve_diameter."</option>";
									}
							}?>
							</select>
							</td>
						</tr>
						

						<tr>
							<td class="label">Cost Per Tube <span style="color:red;">* </span> :</td>
							<td><input type="number" name="cost_per_tube" id="cost_per_tube" step="any" value="<?php echo set_value('cost_per_tube');?>" ></td>
						</tr>
						<tr>
							<td class="label" >Apply From <span style="color:red;">* </span> :</td>
							<td><input type="date" name="from_date" id="from_date" value="<?php echo set_value('from_date');?>">
							<input type="date" name="to_date" id="to_date" value="<?php echo set_value('to_date');?>"></td>
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
