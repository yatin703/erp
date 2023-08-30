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

		
			
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">

								

						<tr>
							<td class="label" >From Date <span style="color:red;"> </span> :</td>
							<td><input type="date" name="shift_start_date" id="shift_start_date" value="<?php echo set_value('shift_start_date');?>"></td>
							<td class="label" >To Date  :</td>
							<td><input type="date" name="shift_end_date" id="shift_end_date" value="<?php echo set_value('shift_end_date');?>"></td>
						</tr>

						<tr>
							<td class="label">Machine Name :</td>
							<td><select name="machine_id" id="machine_id">
								<option value=''>--Please Select--</option>
							<?php if($machine==FALSE){
											echo "<option value=''>--Machine Setup Required--</option>";}
								else{
									foreach($machine as $row){
										
										echo '<option value="'.$row->machine_id.'"'.set_select('machine_id',''.$row->machine_id.'').' >'.$row->machine_name.'</option>';
									}
							}?>
							</select></td>
						</tr>

						

						<tr>
							<td class="label">Shift No<span style="color:red;"> </span> :</td>
							<td><input type="text" name="shift_no" id="shift_no"  value="<?php echo set_value('shift_no');?>" ></td>
						</tr>

						<tr>
							<td class="label">Holiday<span style="color:red;"> </span> :</td>
							<td><input type="Number" name="holiday_flag" id="holiday_flag" step="any" value="<?php echo set_value('holiday_flag');?>" ></td>
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

	

</form>
