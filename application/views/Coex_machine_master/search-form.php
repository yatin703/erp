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
							<td class="label">Machine Name :</td>
							<td><input type="text" name="machine_name" id="machine_name"  value="<?php echo set_value('machine_name');?>" ></td>
						</tr>



						<tr>
							<td class="label">Process Name :</td>
							<td><select name="process_id" id="process_id">
								<option value=''>--Please Select--</option>
							<?php if($process==FALSE){
											echo "<option value=''>--Process Setup Required--</option>";}
								else{
									foreach($process as $row){
										
										echo '<option value="'.$row->work_proc_type_id.'"'.set_select('process_id',''.$row->work_proc_type_id.'').' >'.$row->lang_description.'</option>';
									}
							}?>
							</select></td>
						</tr>

						

						<tr>
							<td class="label">Machine Capacity :</td>
							<td><input type="text" name="machine_capacity" id="machine_capacity" step="any" value="<?php echo set_value('machine_capacity');?>" ></td>
						</tr>

						<tr>
							<td class="label">Speed :</td>
							<td><input type="text" name="speed" id="speed" step="any" value="<?php echo set_value('speed');?>" ></td>
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
