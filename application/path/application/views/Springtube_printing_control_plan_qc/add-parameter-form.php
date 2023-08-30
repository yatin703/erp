<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		$("#jobcard_no").autocomplete("<?php echo base_url('index.php/ajax_springtube/jobcard_printing_autocomplete');?>", {selectFirst: true});	
				


	});//Jquery closed

</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save_parameters');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">

						<tr>
							<td class="label">Inspection Time <span style="color:red;">*</span> :</td>
							<td><input type="hidden" name="cp_id" value="<?php echo set_value('cp_id',$this->uri->segment(3));?>"> 
								<input type="text" name="time_slot"   value="<?php echo set_value('time_slot',date('H:i:s'));?>" readonly /></td>
							<td class="label">Operator  :</td>
							<td colspan="3"><input type="text" name="operator" id="operator"  size="20" value="<?php echo set_value('operator');?>" maxlength="50" required/></td>	
							
						</tr>						
						<tr>
							<td class="label" colspan="4">&nbsp;</td>					
						</tr>
						<tr>
							
							<th class="label">PARAMTERS </th>
							<th class="label">STD</th>
							<th class="label">TOLARANCE </th>
							<th class="label">ACTUAL</th>
							
						</tr>				 
											
						<tr>							
							<td class="label"> Flexo-1 Corona :</td>
							<td>30</td>
							<td>+/-2</td>
							<td ><input type="text" name="flexo_1_corona" value="<?php echo set_value('flexo_1_corona');?>" size="20" required maxlength="10"/></td>
							 
							</td>
						</tr>
						<tr>							
							<td class="label"> UV Power :</td>
							<td>50</td>
							<td>+/-5</td>
							<td ><input type="text" name="uv_power_1" value="<?php echo set_value('uv_power_1');?>" size="20" required maxlength="10"/></td>
							 
							</td>
						</tr>
						<tr>							
							<td class="label"> UV Speed :</td>
							<td>5</td>
							<td>+/-1</td>
							<td ><input type="text" name="uv_speed_1" value="<?php echo set_value('uv_speed_1');?>" size="20" required maxlength="10"/></td>
							 
							</td>
						</tr>
						<tr>							
							<td class="label"> Flexo-2 Corona :</td>
							<td>30</td>
							<td>+/-2</td>
							<td ><input type="text" name="flexo_2_corona" value="<?php echo set_value('flexo_2_corona');?>" size="20" required maxlength="10"/></td>
							 
							</td>
						</tr>
						<tr>							
							<td class="label"> UV Power :</td>
							<td>90</td>
							<td>+/-5</td>
							<td ><input type="text" name="uv_power_2" value="<?php echo set_value('uv_power_2');?>" size="20" required maxlength="10"/></td>
							 
							</td>
						</tr>
						<tr>							
							<td class="label"> UV Speed :</td>
							<td>5</td>
							<td>+/-1</td>
							<td ><input type="text" name="uv_speed_2" value="<?php echo set_value('uv_speed_2');?>" size="20" required maxlength="10"/></td>
							 
							</td>
						</tr>
						<tr>							
							<td class="label">Digital Printing Speed :</td>
							<td>40 Meter/Min</td>
							<td>-</td>
							<td ><input type="text" name="printing_speed" value="<?php echo set_value('printing_speed');?>" size="20" required maxlength="50"/></td>
							 
							</td>
						</tr>
						<tr>							
							<td class="label">Corona Dose :</td>
							<td>-</td>
							<td>-</td>
							<td ><input type="text" name="corona_dose" value="<?php echo set_value('corona_dose');?>" size="20" required maxlength="10"/></td>
							 
							</td>
						</tr>
						<tr>							
							<td class="label">Unwind tension-Tension-Rewind tention :</td>
							<td>120-130-140</td>
							<td>+/-1</td>
							<td ><input type="text" name="unwind_tension" value="<?php echo set_value('unwind_tension');?>" size="20" required maxlength="50"/></td>							 
							</td>
						</tr>
						<tr>							
							<td class="label">UV Cutting :</td>
							<td>20-50-90-90</td>
							<td>+/-1</td>
							<td ><input type="text" name="uv_cutting" value="<?php echo set_value('uv_cutting');?>" size="20" required maxlength="50"/></td>
							 
							</td>
						</tr>
						<tr>							
							<td class="label"> Dyne Test :</td>
							<td>Check using surface tension (Tester no. 38 pass, 42 fail)</td>
							<td></td>
							<td ><input type="text" name="dyne_test" value="<?php echo set_value('dyne_test');?>" size="20" required maxlength="50"/></td>
							 
							</td>
						</tr>				

					</table>
				</td>							
			</tr>
		</table>
					
	</div>
	
				


	<!-- <div class="form_design">
		<button class="submit" name="submit">Save</button> <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>">Cancel</a>
	</div> -->
	<div class="form_design">
		<div class="ui buttons">
	  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui positive button">Save</button>
		</div>
	</div>

	
</form>




				
				
				
			