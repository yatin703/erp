<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();


	});
</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST" enctype="multipart/form-data">
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">

							<?php foreach($coex_machine_master as $row):

								?>
									
									<tr>
										<input type="hidden" name="machine_id" value="<?php echo $row->machine_id;?>" readonly>
										<td class="label">Machine Name <span style="color:red;">* </span> :</td>
										<td><input type="text" name="machine_name" id="machine_name" value="<?php echo set_value('machine_name',$row->machine_name);?>" ></td>
									</tr>

									

									<tr>
										<td class="label">Process Name <span style="color:red;">* </span> :</td>
										<td><select name="process_id"><option value=''>--Select Process--</option>
										<?php if($process==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($process as $process_row){
													$selected=($process_row->work_proc_type_id==$row->process_id ? 'selected' :'');
													echo "<option value='".$process_row->work_proc_type_id."' $selected ".set_select('lang_description',''.$process_row->lang_description.'').">".$process_row->lang_description."</option>";
												}
										}?>
										</select></td>
									</tr>




									<tr>
										<td class="label">Machine Capacity <span style="color:red;">* </span> :</td>
										<td><input type="text" name="machine_capacity" id="machine_capacity" step="any" value="<?php echo set_value('machine_capacity',$row->machine_capacity);?>" ></td>
									</tr>

									<tr>
										<td class="label">Machine Capacity <span style="color:red;"> per min* </span> :</td>
										<td><input type="text" name="machine_capacity_per_minute" id="machine_capacity_per_minute" step="any" value="<?php echo set_value('machine_capacity_per_minute',$row->machine_capacity_per_minute);?>" ></td>
									</tr>

									<tr>
										<td class="label">Speed <span style="color:red;">* </span> :</td>
										<td><input type="text" name="speed" id="speed" step="any" value="<?php echo set_value('speed',$row->speed);?>" ></td>
									</tr>

									<tr>
										<td class="label">Tool ChangeOver <span style="color:red;">in min* </span> :</td>
										<td><input type="number" name="tool_changeover" id="tool_changeover" step="any" value="<?php echo set_value('tool_changeover',$row->tool_changeover);?>" ></td>
									</tr>

									<tr>
										<td class="label">Job ChangeOver <span style="color:red;">in min* </span> :</td>
										<td><input type="number" name="job_changeover" id="job_changeover" step="any" value="<?php echo set_value('job_changeover',$row->job_changeover);?>" ></td>
									</tr>



									
							<?php endforeach;?>		

					</table>			
								
				</td>
							
			</tr>
		</table>
					
	</div>

	<div class="form_design">
			
		<!--<button class="submit" name="submit">Update</button> <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>">Cancel</a>-->
	

	<div class="ui buttons">
	  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui positive button"  button class="submit" name="submit">Update</button>
	</div>

	</div>		
		
</form>
				
