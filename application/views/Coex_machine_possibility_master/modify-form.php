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

							<?php foreach($coex_machine_possibility_master as $row):

								?>
									
									

									

									<tr>
										<input type="hidden" name="cmpm_id" value="<?php echo $row->cmpm_id;?>" readonly>
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
										<td class="label">Sleeve Dia<span style="color:red;">*</span> :</td>
										<td><select name="sleeve_dia" id="sleeve_dia">
											<option value=''>--Select Dia--</option>
										<?php 
											if($sleeve_diameter_master==FALSE){
												echo "<option value=''>--Setup Required--</option>";
											}
											else{
												foreach($sleeve_diameter_master as $sleeve_diameter_master_row){

													$selected=($sleeve_diameter_master_row->sleeve_diameter==$row->sleeve_dia?"selected":"");
													echo "<option value='".$sleeve_diameter_master_row->sleeve_diameter."'  ".set_select('sleeve_dia',''.$sleeve_diameter_master_row->sleeve_diameter.'').$selected.">".$sleeve_diameter_master_row->sleeve_diameter."</option>";
												}
										}?>
										</select>
										</td>
									</tr>

									
									<tr>
										<td class="label">Tube Print Type <span style="color:red;">*</span> :</td>
										<td>
											<select name="print_type" class="print_type" required>
												<option value=''>--Print Type--</option>
										<?php if($print_type==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
										else{
											foreach($print_type as $print_type_row){
												$selected=($print_type_row->lacquer_type==$row->print_type?'selected':'');
												echo "<option value='".$print_type_row->lacquer_type."'  ".set_select('print_type',''.$print_type_row->lacquer_type.'').$selected.">".$print_type_row->lacquer_type."</option>";
															}
											}?>
											</select>
										</td>
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
				
