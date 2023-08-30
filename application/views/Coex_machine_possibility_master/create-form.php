<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();


	});
</script>


<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save');?>" method="POST" enctype="multipart/form-data">
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">				



									
									<tr>
										<td class="label">Machine Name <span style="color:red;">* </span> :</td>
										<td><select name="machine_id"><option value=''>--Select Machine --</option>
										<?php if($machine==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($machine as $machine_row){
													echo "<option value='".$machine_row->machine_id."'  ".set_select('machine_id',''.$machine_row->machine_id.'').">".$machine_row->machine_name."</option>";
												}
										}?>
										</select></td>
									</tr>

									<tr>
										<td class="label">Sleeve Dia<span style="color:red;">*</span> :</td>
										<td><select name="sleeve_dia" id="sleeve_dia">
											<option value=''>--Select Dia--</option>
										<?php 
											if($sleeve_diameter_master==FALSE){
												echo "<option value=''>--Setup Required--</option>";
											}
											else{
												foreach($sleeve_diameter_master as $sleeve_diameter_master_row){
													echo "<option value='".$sleeve_diameter_master_row->sleeve_diameter."'  ".set_select('sleeve_dia',''.$sleeve_diameter_master_row->sleeve_diameter.'').">".$sleeve_diameter_master_row->sleeve_diameter."</option>";
												}
										}?>
										</select>
										</td>
									</tr>

									

									<tr>
										<td class="label">Print Type <span style="color:red;">*</span> :</td>
										<td><select name="print_type" required><option value=''>--Select Print Type--</option>
										<?php if($print_type==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($print_type as $print_type_row){
													echo "<option value='".$print_type_row->lacquer_type."'  ".set_select('print_type',''.$print_type_row->lacquer_type.'').">".$print_type_row->lacquer_type."</option>";
												}
										}?>
										</select></td>
									</tr>
									

									
									
																	 
						</table>			
								
				</td>
							
			</tr>
		</table>
					
	</div>

	<div class="form_design">
			
		

		<div class="ui buttons">
	  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui positive button" ;">Save</button>
			</div>

	</div>
</form>
