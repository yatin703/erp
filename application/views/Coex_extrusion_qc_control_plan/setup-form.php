<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		$("#jobcard_no").autocomplete("<?php echo base_url('index.php/ajax/jobcard_autocomplete');?>", {selectFirst: true});	
		
		$("#jobcard_no").live('keyup',function() {
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/get_order_no');?>",data: {jobcard_no : $("#jobcard_no").val()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#order_no").val(html);
				} 
			});
		});	

		$("#jobcard_no").live('keyup',function() {
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/get_article_no');?>",data: {jobcard_no : $("#jobcard_no").val()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#article_no").val(html);
				} 
			});
		});	

		$("#jobcard_no").live('change',function() {
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/jobcard_details_dia');?>",data: {order_no : $("#order_no").val()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$(".standard_dia").val(html);
				} 
			});
		});	
		
		$("#jobcard_no").live('change',function() {
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/jobcard_details_length');?>",data: {order_no : $("#order_no").val()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#sleeve_length").val(html);
				} 
			});
		});	

		$("#jobcard_no").live('change',function() {
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/jobcard_details_dia_length');?>",data: {order_no : $("#order_no").val()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#specification").val(html);
				} 
			});
		});	

		

	});//Jquery closed

</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
		<table class="form_table_design">
			<tr>

				<td width="45%">
					<table class="form_table_inner">

						<tr>
							<td class="label"><b>Date</b><span style="color:red;">*</span> :</td>
							<td><input type="date" name="inspection_date"  size="10" value="<?php echo set_value('inspection_date',date('Y-m-d'));?>" required/></td>

							<td class="label"><b>Shift</b><span style="color:red;">*</span> :</td>
							<td><select name="shift" id="shift" required><option value=''>--Shift--</option>
								<?php if($shift_master==FALSE){
												echo "<option value=''>--Setup Required--</option>";}
									else{
										foreach($shift_master as $shift_master_row){

											echo "<option value='".$shift_master_row->shift_id."'  ".set_select('shift',''.$shift_master_row->shift_id.'').">".$shift_master_row->shift_name."</option>";
										}
								}?></select></td>
						</tr> 

						<tr>
							<td class="label"><b>Machine</b> <span style="color:red;">*</span> :</td>
							<td><select name="machine" id="machine" required><option value=''>--Machine--</option>
							<?php if($coex_machine_master==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach($coex_machine_master as $machine_row){
										echo "<option value='".$machine_row->machine_id."'  ".set_select('machine',''.$machine_row->machine_id.'').">".$machine_row->machine_name."</option>";
									}
							}?>
							</select></td>
							<td class="label"><b>Job Card</b> <span style="color:red;">*</span> :</td>
							<td><input type="text" name="jobcard_no" id="jobcard_no"  size="15" maxlength="14" value="<?php echo set_value('jobcard_no');?>" required/>
							</td>
						</tr>

						<!-- <tr>
							<td class="label"><b>Order No</b> <span style="color:red;">*</span> :</td>
							<td colspan="3"><span id="jobcard_order_details"><select name="order_no" id="order_no" required><option value=''>--Order No--</option></select>&nbsp;&nbsp;&nbsp;<b>Product No </b> <span style="color:red;">*</span> : &nbsp;&nbsp;&nbsp;<select name="article_no" id="article_no" required><option value=''>--Product No--</option></select></span></td>
						</tr> -->

						<tr>
							<td class="label"><b>Order No</b> <span style="color:red;">*</span> :</td>
							<td colspan="3"><input type="text" readonly name="order_no"  id="order_no" value="<?php echo set_value('order_no');?>" >&nbsp;&nbsp;&nbsp;
								<b>Product No </b> <span style="color:red;">*</span> : &nbsp;&nbsp;&nbsp;<input type="text" readonly name="article_no" id="article_no" size="13" value="<?php echo set_value('article_no');?>" required></td>
						</tr>


						<tr>
							<td class="label"><b>Specification</b><span style="color:red;">*</span>:</td>
							<td><input type="text" name="specification" id="specification" size="45" value="<?php echo set_value('specification');?>" required></td>
						</tr>

						<tr>
							<td class="label"><b>Operator </b><span style="color:red;">*</span> :</td>
							<td>
								<input type="text" hidden="hidden" name="module" value="SETUP" >	
								<input type="text" name="operator" size="10" value="<?php echo set_value('operator');?>" required>
								
							</td>
						</tr>

						<tr>
							<td colspan="4">
								<hr>	
							</td>	
							
						</tr>	
						
						
						<tr>
							<td class="label" colspan="">Remarks <span style="color:red;">*</span> :</td>
							<td>
								<textarea name="remark"  value="<?php echo trim(set_value('remark'));?>" maxlength="500" required><?php echo trim(set_value('remark'));?>	
								</textarea>
							</td>
						</tr>

						<tr>
							<td class="label" colspan="">Status of Inspection <span style="color:red;">*</span> :</td>
							<td><select name="inspection_status" required>					
								<option value="">--Select status--</option>
								<option value="1" <?php echo set_select('inspection_status','1');?> >APPROVED</option>
								<option value="2" <?php echo set_select('inspection_status','2');?> >REJECT</option>
								<option value="0" <?php echo set_select('inspection_status','0');?> >HOLD</option>
								</select>
							</td>
						</tr>

						<tr>
							<td class="label" colspan="">Inspector <span style="color:red;">*</span> :</td>
							<td><input type="text" name="inspector" size="10" value="<?php echo set_value('inspector');?>" required></td>
						</tr>					

					</table>
			
				</td>
				
				<td>
					<table>
						<tr>
							<td class="label"><b>Parameter</td>
							<td class="label"><b>Dimension</td>
							<td class="label"><b>Actual</td>
							<td class="label"><b>Status</td>
						</tr>

						<tr>
							<td class="label">Standard Dia <span style="color:red;">*</span> :</td>
							<td><table class="form_table_design">
								<tr>
									<td><input type="text" readonly style="font-style: italic; background-color: #ededed" name="standard_dia" class="standard_dia" value="<?php echo set_value('standard_dia');?>" >
									</td>									
								</tr>
								</table>
							</td>
							<td><input type="text" name="std_dia_actual" value="<?php echo set_value('dia_actual');?>" size="10" required/></td>
							<td><select name="std_dia_status" required="required">
								<option value="1" <?php echo set_select('std_dia_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('std_dia_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('std_dia_status','0');?>>N/A</option>
							</select></td>
						</tr>

						<tr>
							<td class="label">Outer Dia (MM) +/- 0.1 <span style="color:red;">*</span> :</td>
							<td><table class="form_table_design">
								<tr>
									<td><input type="text" readonly style="font-style: italic; background-color: #ededed" name="outer_dia" class="standard_dia" value="<?php echo set_value('standard_dia');?>" >
									</td>
								</tr>
								</table></td>
							<td><input type="text" name="outer_dia_actual" size="10" value="<?php echo set_value('outer_dia_actual');?>" required/></td>
							<td><select name="outer_dia_status" required="required">
								<option value="1" <?php echo set_select('outer_dia_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('outer_dia_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('outer_dia_status','0');?>>N/A</option>
							</select></td>
						</tr>


						<tr>
							<td class="label">Inner Diameter (MM) +/- 0.1 <span style="color:red;">*</span> :</td>
							<td><table class="form_table_design">
								<tr>
									<td><i>18.14 - 18.66</td>
									<td><i>20.94 - 21.46</td>
									<td><i>23.94 - 24.46</td>
									<td><i>28.94 - 29.46</td>
									<td><i>33.74 - 34.26</td>
									<td><i>38.74 - 39.26</td>
									<td><i>48.74 - 49.26</td>
								</tr>
								</table></td>
							<td><input type="text" name="inner_dia_actual" size="10" value="<?php echo set_value('inner_dia_actual');?>" required/></td>
							<td><select name="inner_dia_status" required="required">
								<option value="1" <?php echo set_select('inner_dia_status','1');?> >PASS</option>
								<option value="2" <?php echo set_select('inner_dia_status','2');?> >FAIL</option>
								<option value="0" <?php echo set_select('inner_dia_status','0');?>>N/A</option>
							</select></td>
						</tr>

						<tr>
							<td class="label">Total Wall Thickness (Micron) +/-15 <span style="color:red;">*</span> :</td>
							<td><table class="form_table_design">
								<tr>
									<td><i>400</td>
									<td><i>400</td>
									<td><i>500</td>
									<td><i>500</td>
									<td><i>500</td>
									<td><i>500</td>
									<td><i>550</td>
								</tr>
								</table></td>
							<td ><input type="text" name="total_thickness_actual" size="10" value="<?php echo set_value('total_thickness_actual');?>" required/></td>
							<td>
								<select name="total_thickness_status" required="required">
								<option value="1" <?php echo set_select('total_thickness_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('total_thickness_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('total_thickness_status','0');?>>N/A</option>
								</select>
							</td>
						</tr>

						<tr>
							<td class="label">Thickness Setting <span style="color:red;">*</span> :</td>
							<td><table class="form_table_design">
								<tr>
									<!-- <td><i></td> -->
									
								</tr>
								</table></td>
							<td><input type="text" name="thickness_settings" size="10" value="<?php echo set_value('thickness_settings');?>" required/></td>
							<td><select name="thickness_settings_status" required="required">
								<option value="1" <?php echo set_select('thickness_settings_status','1');?> >PASS</option>
								<option value="2" <?php echo set_select('thickness_settings_status','2');?> >FAIL</option>
								<option value="0" <?php echo set_select('thickness_settings_status','0');?>>N/A</option>
							</select></td>
						</tr>

						<tr>
							<td class="label">Opacity <span style="color:red;">*</span> :</td>
							<td>>90%</td>
							<td ><input type="text" name="opacity_actual" size="10" placeholder="Yes/No" value="<?php echo set_value('opacity_actual');?>" required/></td>
							<td><select name="opacity_status" required="required">							
								<option value="1" <?php echo set_select('opacity_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('opacity_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('opacity_status','0');?>>N/A</option>
							</select></td>
						</tr>

						<tr>
							<td class="label">Color Diffrence <span style="color:red;">*</span> :</td>
							<td>DE<3</td>
							<td ><input type="text" name="color_diffrence_actual" size="10" placeholder="Yes/No" value="<?php echo set_value('color_diffrence_actual');?>" required/></td>
							<td><select name="color_diffrence_status" required="required">					
								<option value="1" <?php echo set_select('color_diffrence_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('color_diffrence_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('color_diffrence_status','0');?>>N/A</option>
							</select></td>
						</tr>

						<tr>
							<td class="label">Oval Tube <span style="color:red;">*</span> :</td>
							<td>No Oval</td>
							<td><input type="text" name="oval_tube_actual" size="10" placeholder="Yes/No" value="<?php echo set_value('oval_tube_actual');?>" required/></td>
							<td><select name="oval_tube_status" required="required">				
								<option value="1" <?php echo set_select('oval_tube_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('oval_tube_status','1');?>>FAIL</option>
								<option value="0" <?php echo set_select('oval_tube_status','1');?>>N/A</option>
							</select></td>
						</tr>

						<tr>
							<td class="label">Length of Sleeve (Actual)<span style="color:red;">*</span> :</td>
							<td><input type="text" readonly style="font-style: italic; background-color: #ededed" name="sleeve_length" id="sleeve_length" value="<?php echo set_value('sleeve_length');?>" >
							</td>
							<td><input type="text" name="length_of_sleeve" size="10" value="<?php echo set_value('length_of_sleeve');?>" required/></td>
							<td><select name="length_of_sleeve_status" required="required">							
								<option value="1" <?php echo set_select('length_of_sleeve_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('length_of_sleeve_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('length_of_sleeve_status','0');?>>N/A</option>
							</select></td>
						</tr>	

						<tr>
							<td class="label">Visual Match (Coloured / Translucent Sleeves)<span style="color:red;">*</span> :</td>
							<td>Should match visual with shade card</td>
							<td><input type="text" name="visual_match" size="10" placeholder="Yes/No" value="<?php echo set_value('visual_match');?>" required/></td>
							<td><select name="visual_match_status" required="required">							
								<option value="1" <?php echo set_select('visual_match_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('visual_match_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('visual_match_status','0');?>>N/A</option>
							</select></td>
						</tr>	

						<tr>
							<td class="label">Cutting Quality <span style="color:red;">*</span> :</td>
							<td>Even Cut /  No Double Cut / No Notch</td>
							<td ><input type="text" name="cutting_quality_actual" size="10" placeholder="Yes/No" value="<?php echo set_value('cutting_quality_actual');?>" required/></td>
							<td><select name="cutting_quality_status" required="required">							
								<option value="1" <?php echo set_select('cutting_quality_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('cutting_quality_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('cutting_quality_status','0');?>>N/A</option>
							</select></td>
						</tr>

						<tr>
							<td class="label">Die Line <span style="color:red;">*</span> :</td>
							<td>No Die line</td>
							<td><input type="text" name="die_line_actual" size="10" placeholder="Yes/No" value="<?php echo set_value('die_line_actual');?>" required/></td>
							<td><select name="die_line_status" required="required">							
								<option value="1" <?php echo set_select('die_line_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('die_line_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('die_line_status','0');?>>N/A</option>
							</select></td>
						</tr>

						<tr>
							<td class="label">Scratch Line <span style="color:red;">*</span> :</td>
							<td>No Scratch line</td>
							<td><input type="text" name="scratch_line_actual" size="10" placeholder="Yes/No" value="<?php echo set_value('scratch_line_actual');?>" required/></td>
							<td><select name="scratch_line_status" required="required">							
								<option value="1" <?php echo set_select('scratch_line_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('scratch_line_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('scratch_line_status','0');?>>N/A</option>
							</select></td>
						</tr>

						<tr>
							<td class="label">Pit/Watermark/Fisheye <span style="color:red;">*</span> :</td>
							<td>No Pit/Watermark</td>
							<td><input type="text" name="pit_watermark_actual" size="10" placeholder="Yes/No" value="<?php echo set_value('pit_watermark_actual');?>" required/></td>
							<td><select name="pit_watermark_status" required="required">							
								<option value="1" <?php echo set_select('pit_watermark_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('pit_watermark_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('pit_watermark_status','0');?>>N/A</option>
							</select></td>
						</tr>

						<tr>
							<td class="label">Contamination <span style="color:red;">*</span> :</td>
							<td>No Contamination</td>
							<td><input type="text" name="contamination_actual" size="10" placeholder="Yes/No" value="<?php echo set_value('contamination_actual');?>" required/></td>
							<td><select name="contamination_status" required="required">							
								<option value="1" <?php echo set_select('contamination_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('contamination_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('contamination_status','0');?>>N/A</option>
							</select></td>
						</tr>

						<tr>
							<td class="label">Rings Inside & Outside <span style="color:red;">*</span> :</td>
							<td>No Rings Inside & Outside </td>
							<td><input type="text" name="rings_inside_outside_actual" size="10" placeholder="Yes/No" value="<?php echo set_value('rings_inside_outside_actual');?>" required/></td>
							<td><select name="rings_inside_outside_status">							
								<option value="1" <?php echo set_select('rings_inside_outside_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('rings_inside_outside_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('rings_inside_outside_status','0');?>>N/A</option>
							</select></td>
						</tr>

						<tr>
							<td class="label">Color Dispersion <span style="color:red;">*</span> :</td>
							<td>Should be Uniform</td>
							<td><input type="text" name="color_dispersion_actual" size="10" placeholder="Yes/No" value="<?php echo set_value('color_dispersion_actual');?>" required/></td>
							<td><select name="color_dispersion_status" required="required">			
								<option value="1" <?php echo set_select('color_dispersion_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('color_dispersion_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('color_dispersion_status','0');?>>N/A</option>
							</select></td>
						</tr>

						<tr>
							<td class="label">Check for Layer Separation <span style="color:red;">*</span> :</td>
							<td>No Layer Seperation</td>
							<td ><input type="text" name="check_layer_seperation" size="10" placeholder="Yes/No" value="<?php echo set_value('check_layer_seperation');?>" required/></td>
							<td><select name="check_layer_seperation_status" required="required">					
								<option value="1" <?php echo set_select('check_layer_seperation_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('check_layer_seperation_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('check_layer_seperation_status','0');?>>N/A</option>
							</select></td>
						</tr>

						<tr>
							<td class="label">Zumbach Value <span style="color:red;">*</span> :</td>
							<td>As per chart no.</td>
							<td ><input type="text" name="zumbach_value" size="10" placeholder="Yes/No" value="<?php echo set_value('zumbach_value');?>" required/></td>
							<td><select name="zumbach_value_status" required="required">							
								<option value="1"  <?php echo set_select('zumbach_value_status','1');?>>PASS</option>
								<option value="2"  <?php echo set_select('zumbach_value_status','2');?>>FAIL</option>
								<option value="0"  <?php echo set_select('zumbach_value_status','0');?>>N/A</option>
							</select></td>
						</tr>
						
						<tr>
							<td class="label">Check material composition<span style="color:red;">*</span> :</td>
							<td>Visual</td>
							<td><input type="text" name="check_material_composition" placeholder="Yes/No" size="10" value="<?php echo set_value('check_material_composition');?>" required/></td>
							<td><select name="check_material_composition_status" required="required">							
								<option value="1" <?php echo set_select('check_material_composition_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('check_material_composition_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('check_material_composition_status','0');?>>N/A</option>
							</select></td>
						</tr>	

						<tr>
							<td class="label">Others<span style="color:red;">*</span> :</td>
							<td></td>
							<td><input type="text" name="others" size="10" value="<?php echo set_value('others');?>" required/></td>
							<td><select name="others_status" required="required">							
								<option value="1" <?php echo set_select('others_status','1');?>>PASS</option>
								<option value="2" <?php echo set_select('others_status','2');?>>FAIL</option>
								<option value="0" <?php echo set_select('others_status','0');?>>N/A</option>
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
	  		<button class="ui positive button">Save</button>
		</div>
	</div>

	
</form>




				
				
				
			