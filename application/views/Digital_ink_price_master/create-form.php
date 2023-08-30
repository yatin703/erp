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
										<td class="label" >From Date <span style="color:red;">* (3 Month)</span> :</td>
										<td><input type="date" name="from_date" id="from_date" value="<?php echo set_value('from_date');?>">
										<input type="date" name="to_date" id="to_date" value="<?php echo set_value('to_date');?>"></td>
									</tr>

									<tr>
										<td class="label">Ink Id<span style="color:red;">* </span> :</td>
										<td><input type="Number" name="ink_id" id="ink_id" step="any" value="<?php echo set_value('ink_id');?>" ></td>
									</tr>


									<tr>
										<td class="label">Rm<span style="color:red;">* </span> :</td>
										<td><input type="text" name="rm" id="rm" step="any" value="<?php echo set_value('rm');?>" size="60"></td>
									</tr>

									<tr>
										<td class="label">Other Charges PC<span style="color:red;">* </span> :</td>
										<td><input type="number" name="other_charges_pc" id="other_charges_pc" step="any" value="<?php echo set_value('other_charges_pc');?>" ></td>
									</tr>
									
									<tr>
										<td class="label">Rate of Exchange <span style="color:red;">* </span> :</td>
										<td><input type="number" name="rate_of_exchange" id="rate_of_exchange" step="any" value="<?php echo set_value('rate_of_exchange');?>" ></td>
									</tr>
									
																	 
						</table>			
								
				</td>
							
			</tr>
		</table>
					
	</div>

	<div class="form_design">
			
		<button class="submit" name="submit">Save</button> <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>">Cancel</a>
	</div>
</form>
