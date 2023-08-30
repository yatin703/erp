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

						<?php foreach($length_master as $row):

							?>
							<tr>
								<td class="label" width="25%"> Dia <span style="color:red;">*</span>:</td>
								<td >
								<input type="hidden" name="length_id" value="<?php echo $row->length_id;?>" readonly>	
								<select name="sleeve_dia" id="sleeve_dia" required><option value=''>--Select Dia--</option>
								<?php if($sleeve_dia==FALSE){
												echo "<option value=''>--Setup Required--</option>";}
									else{
										foreach($sleeve_dia as $sleeve_dia_row){
											$selected=($sleeve_dia_row->sleeve_diameter==$row->dia ? 'selected' : '');

											echo "<option value='".$sleeve_dia_row->sleeve_diameter."//".$sleeve_dia_row->sleeve_id."' $selected ".set_select('dia',''.$sleeve_dia_row->sleeve_diameter.'//'.$sleeve_dia_row->sleeve_id.'').">".$sleeve_dia_row->sleeve_diameter."</option>";
										}
								}?>


								</select>
								</td>
							</tr>

							<tr>
								<td class="label">Length From <span style="color:red;">* </span> :</td>
								<td>
									
									<input type="text" name="length_from" id="length_from" step="any" value="<?php echo set_value('length_from',$row->length_from);?>" >
								</td>
							</tr>

							<tr>
								<td class="label">Length To <span style="color:red;">* </span> :</td>
								<td>
									<input type="text" name="length_to" id="length_to" step="any" value="<?php echo set_value('length_to',$row->length_to);?>" >
								</td>
							</tr>


									
						<?php endforeach;?>		

					</table>			
								
				</td>
							
			</tr>
		</table>
					
	</div>

	<div class="form_design">
			
		<div class="ui buttons">
	  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui positive button"  button class="submit" name="submit">Update</button>
		</div>
	</div>
		
</form>
				
