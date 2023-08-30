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

							<?php foreach($shift_master as $row):

								?>
									
									<tr>
										<input type="hidden" name="shift_id" value="<?php echo $row->shift_id;?>" readonly>
										<td class="label">Shift No <span style="color:red;">* </span> :</td>
										<td><input type="text" name="shift_no" id="shift_no" value="<?php echo set_value('shift_no',$row->shift_no);?>" ></td>
									</tr>

									<tr>
										<td class="label">Machine Name <span style="color:red;">* </span> :</td>
										<td><select name="machine_id"><option value=''>--Select Process--</option>
										<?php if($machine==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($machine as $machine_row){
													$selected=($machine_row->machine_id==$row->machine_id ? 'selected' :'');
													echo "<option value='".$machine_row->machine_id."' $selected ".set_select('machine_name',''.$machine_row->machine_name.'').">".$machine_row->machine_name."</option>";
												}
										}?>
										</select></td>
									</tr>


									<tr>
										<td class="label">Shift Start Date <span style="color:red;">* </span> :</td>
										<td><input type="date" name="shift_start_date" id="shift_start_date" step="any" value="<?php echo set_value('shift_start_date',$row->shift_start_date);?>" ></td>
									</tr>
									<tr>
										<td class="label">Shift End Date <span style="color:red;">* </span> :</td>
										<td><input type="date" name="shift_end_date" id="shift_end_date" step="any" value="<?php echo set_value('shift_end_date',$row->shift_end_date);?>" ></td>
									</tr>

									<tr>
										<td class="label">Shift Start Time <span style="color:red;">* </span> :</td>
										<td><input type="datetime" name="shift_start_time" id="shift_start_time" step="any" value="<?php echo set_value('shift_start_time',$row->shift_start_time);?>" ></td>
									</tr>

									<tr>
										<td class="label">Shift End Time <span style="color:red;">* </span> :</td>
										<td><input type="datetime" name="shift_end_time" id="shift_end_time" step="any" value="<?php echo set_value('shift_end_time',$row->shift_end_time);?>" ></td>
									</tr>

									<tr>
										<td class="label">Holiday <span style="color:red;">* </span> :</td>
										<td><input type="number" name="holiday_flag" id="holiday_flag" step="any" value="<?php echo set_value('holiday_flag',$row->holiday_flag);?>" ></td>
									</tr>

									<tr>
										<td class="label">Preventive Maintenance <span style="color:red;">* </span> :</td>
										<td><input type="number" name="preventive_maintaince" id="preventive_maintaince" step="any" value="<?php echo set_value('preventive_maintaince',$row->preventive_maintaince);?>" ></td>
									</tr>

									<tr>
										<td class="label">Shift Minutes <span style="color:red;">* </span> :</td>
										<td><input type="number" name="shift_minutes" id="shift_minutes" step="any" value="<?php echo set_value('shift_minutes',$row->shift_minutes);?>" ></td>
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
				
