<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){

		$("#loading").hide(); $("#cover").hide();

		$("#customer_category").autocomplete("<?php echo base_url('index.php/ajax/customer_category_autocomplete');?>", {selectFirst: true});
		
		$("#article_no").autocomplete("<?php echo base_url('index.php/ajax/article_no');?>", {selectFirst: true});
		$("#invoice_no").autocomplete("<?php echo base_url('index.php/ajax/ar_invoice_no');?>", {selectFirst: true});
		$("#tube_color").autocomplete("<?php echo base_url('index.php/ajax/tube_color');?>", {selectFirst: true});
		$("#shoulder_color").autocomplete("<?php echo base_url('index.php/ajax/tube_color');?>", {selectFirst: true});
		$("#cap_color").autocomplete("<?php echo base_url('index.php/ajax/tube_color');?>", {selectFirst: true});
		$("#quotation_no").autocomplete("<?php echo base_url('index.php/ajax/quotation_no');?>", {selectFirst: true});


		$("#customer_category").blur(function() {
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/purchase_manager');?>",data: {customer : $("#customer_category").val()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#pm_1").html(html);
				} 
			});
		});
		if($("#customer").val()!=''){
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/purchase_manager');?>",data: {customer : $("#customer").val()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#pm_1").html(html);
				} 
			});
		}

		$("#search").click(function() {
		var from = new Date(document.getElementById("from_date").value);
		var to = new Date(document.getElementById("to_date").value);

		var difference = to - from;
		var days = difference/(24*3600*1000);
		if(days>10){
			if(confirm("You are running report for "+days+" Days")==true){
				return true;
			}else{
				return false;	
			}
		}else{
			return true;
		}
		});				


	});

</script>
<style type="text/css">
	fieldset {border: 1px solid #8cacbb;}
	fieldset legend{font-weight: bold;}
	
	.number{
		width:25%;
	}
	.number1{
		width:100%;
	}
	
	  
  
</style>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner" width="100%">
						<tr>
							<td>
								<fieldset >
									<legend>Information:</legend>
									<table class="form_table_inner">
										<?php foreach ($account_periods_master as $account_periods_master_row ):?>
										<tr>
											<td class="label" >From Date <span style="color:red;">*</span>  :</td>
											<td><input type="date" name="from_date" id="from_date" value="<?php echo set_value('from_date','2020-04-01');?>"/></td>
											<td class="label" >To Date <span style="color:red;">*</span>  :</td>
											<td><input type="date" name="to_date" id="to_date" value="<?php echo set_value('to_date',date('Y-m-d'));?>"/></td>
										</tr>
										<?php endforeach;?>

										<tr>
											<td class="label">Quotation No :</td>
											<td colspan="3"><input type="text" name="quotation_no" id="quotation_no"  value="<?php echo set_value('quotation_no');?>" />
											</td>
										</tr>

										<tr>							
											<td class="label" width="26%"> Customer : </td>
											<td colspan="3"><input type="text" name="customer" id="customer_category"  size="50" value="<?php echo set_value('customer');?>"  /></td>							
										</tr>
										<tr>							
											<td class="label">Purchase Manager :</td>
											<td colspan="3">
												<select name="pm_1" id="pm_1" >
													<option value="">--Select PM--</option>
												
												</select>
											</td>								
										</tr>

										<tr>							
											<td class="label">Product Name :</td>
											<td colspan="3"> <input type="text"  name="product_name"  size="50" value="<?php echo set_value('product_name');?>" />
																	
											</td>								
										</tr>

										<tr>
											<td class="label">Payment Terms :</td>
											<td colspan="3"><input type="text" name="credit_days" value="<?php echo set_value('credit_days');?>" >
											</td>
										</tr>

										
									
											
										 
									</table>
								</fieldset>
							</td>
						</tr>
						<tr>
							<td colspan="4" >
								<fieldset>
									<legend>Tube Specification:</legend>
								<table class="form_table_inner">


									<tr>
										<td class="label" width="25%">Tube Dia :</td>
										<td width="25%"><select name="sleeve_dia" id="sleeve_dia" ><option value=''>--Select Dia--</option>
											<?php if($sleeve_dia==FALSE){
															echo "<option value=''>--Setup Required--</option>";}
												else{
													foreach($sleeve_dia as $sleeve_dia_row){
														echo "<option value='".$sleeve_dia_row->sleeve_diameter."//".$sleeve_dia_row->sleeve_id."'  ".set_select('sleeve_dia',''.$sleeve_dia_row->sleeve_diameter.'//'.$sleeve_dia_row->sleeve_id.'').">".$sleeve_dia_row->sleeve_diameter."</option>";
													}
											}?></select>
										</td>
										<td class="label" width="25%">Tube Length :</td>
										<td width="25%"><input type="number" class="number1" name="sleeve_length" min="10"  max="500" step="0.1"  id="sleeve_length" size="5" maxlength="5" value="<?php echo set_value('sleeve_length');?>">
										</td>

									</tr>

									<tr>
										<td class="label">Layer :</td>
										<td>
											<select name="layer" id="layer">
												<option value="">--Select Layer--</option>							 
												<option value="1" <?php echo set_select('layer',1);?> >1</option>
												<option value="2" <?php echo set_select('layer',2);?> >2</option>
												<option value="3" <?php echo set_select('layer',3);?> >3</option>
												
												<option value="5" <?php echo set_select('layer',5);?> >5</option>
												
												<option value="7" <?php echo set_select('layer',7);?> >7</option>
												
											</select>
										</td>
									</tr>
									
									<tr>
										<td class="label">Tube Color :</td>
										<td colspan="3"><input type="text" name="tube_color" id="tube_color" value="<?php echo set_value('tube_color');?>" >
										</td>
									</tr>

									<tr>
										<td class="label">Tube Lacquer :</td>
										<td>
											<select name="tube_lacquer" id="tube_lacquer" >
												<option value="">--Select Tube Lacquer--</option>
												<option value="GLOSS" <?php echo set_select('tube_lacquer','GLOSS');?> >GLOSS</option>
												<option value="MATT" <?php echo set_select('tube_lacquer','MATT');?> >MATT</option>
												<option value="SATIN_MATT" <?php echo set_select('tube_lacquer','SATIN_MATT');?> >SATIN MATT</option>
											</select>
										</td>
									</tr>

									<tr>
										<td class="label">Tube Print Type :</td>
										<td>
											<select name="print_type" class="print_type">
												<option value=''>--Select Print Type--</option>
										<?php if($print_type==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
										else{
											foreach($print_type as $print_type_row){
												echo "<option value='".$print_type_row->printing_group."'  ".set_select('print_type',''.$print_type_row->printing_group.'').">".$print_type_row->printing_group."</option>";
															}
											}?>
											</select>
										</td>
									</tr>
									<tr>
										<td class="label">Special Ink :</td>	 
										<td>  
											<select name="special_ink" id="special_ink">
												<option value="">--Select Special ink--</option>
												<option value="YES" <?php echo set_select('special_ink','YES');?> >YES</option>
												<option value="NO" <?php echo set_select('special_ink','NO');?> >NO</option>
											</select>							
										</td>
									</tr>
									

									

									

								</table>
							</fieldset>
						</td>			
					 </tr>

					 <tr>
					 	<td colspan="4" >
								<fieldset>
									<legend>Shoulder Specification:</legend>
								<table class="form_table_inner">

									<tr>
										<td class="label">Shoulder :</td>
										<td><select name="shoulder" id="shoulder"><option value=''>--Select Shoulder--</option>
										<?php if($shoulder_types==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($shoulder_types as $shoulder_types_row){
													echo "<option value='".$shoulder_types_row->shoulder_type."//".$shoulder_types_row->shld_type_id."'  ".set_select('shoulder',''.$shoulder_types_row->shoulder_type.'//'.$shoulder_types_row->shld_type_id.'').">".$shoulder_types_row->shoulder_type."</option>";
												}
										}?>
										</select></td>
									</tr>
									<tr>

											<td class="label">Shoulder Orifice  :</td>
											<td colspan="3"><select name="shoulder_orifice" id="shoulder_orifice"><option value=''>--Select Orifice--</option>
											<?php if($shoulder_orifice==FALSE){
															echo "<option value=''>--Setup Required--</option>";}
												else{
													foreach($shoulder_orifice as $shoulder_orifice_row){
														echo "<option value='".$shoulder_orifice_row->shoulder_orifice."//".$shoulder_orifice_row->orifice_id."'  ".set_select('shoulder_orifice',''.$shoulder_orifice_row->shoulder_orifice.'//'.$shoulder_orifice_row->orifice_id.'').">".$shoulder_orifice_row->shoulder_orifice."</option>";
													}
											}?></select></td>
									</tr>

									<tr>
										<td class="label">Shoulder Color :</td>
										<td colspan="3"><input type="text" name="shoulder_color"  id="shoulder_color" value="<?php echo set_value('shoulder_color');?>" >
										</td>
									</tr>

								</table>
							</fieldset>
						</td>						

					 </tr>

					 <tr>
					 	<td colspan="4" >
								<fieldset>
									<legend>Cap Specification:</legend>
								<table class="form_table_inner">

									<tr>
										<td class="label">Cap Type :</td>
										<td>
											<select name="cap_type" id="cap_type" ><option value=''>--Select Cap Type--</option>
											<?php if($cap_type==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($cap_type as $cap_type_row){
													echo "<option value='".$cap_type_row->cap_type."//".$cap_type_row->cap_type_id."'  ".set_select('cap_type',''.$cap_type_row->cap_type.'//'.$cap_type_row->cap_type_id.'').">".$cap_type_row->cap_type."</option>";
												}
										}?>
											</select>
										</td>
										
									</tr>

									<tr>
										<td class="label">Cap Finish :</td>
										<td>
											<select name="cap_finish" id="cap_finish">
												<option value="">--Select Cap Finish--</option>
												<option value="GLOSS" <?php echo set_select('cap_finish','GLOSS');?> >GLOSS</option>
												<option value="MATT" <?php echo set_select('cap_finish','MATT');?> >MATT</option>
											</select>
										</td>	
									</tr>

									<tr>
										<td class="label">Cap Dia :</td>
										<td><select name="cap_dia" id="cap_dia"><option value=''>--Select Cap Dia--</option>
										<?php if($cap_dia==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($cap_dia as $cap_dia_row){
													echo "<option value='".$cap_dia_row->cap_dia."//".$cap_dia_row->cap_dia_id."'  ".set_select('cap_dia',''.$cap_dia_row->cap_dia.'//'.$cap_dia_row->cap_dia_id.'').">".$cap_dia_row->cap_dia."</option>";
												}
										}?></select></td>
									</tr>

									<tr>
										<td class="label">Cap Orifice :</td>
										<td><select name="cap_orifice" id="cap_orifice">
										<option value=''>--Select Cap Orifice--</option>
											<?php if($cap_orifice==FALSE){
															echo "<option value=''>--Setup Required--</option>";}
												else{
													foreach($cap_orifice as $cap_orifice_row){
														echo "<option value='".$cap_orifice_row->cap_orifice."//".$cap_orifice_row->cap_orifice_id."'  ".set_select('cap_orifice',''.$cap_orifice_row->cap_orifice.'//'.$cap_orifice_row->cap_orifice_id.'').">".$cap_orifice_row->cap_orifice."</option>";
													}
											}?></select>
										</td>
									</tr>
									
										
									

									<tr>
										<td class="label">Cap Color :</td>
										<td colspan="3"><input type="text" name="cap_color" id="cap_color" value="<?php echo set_value('cap_color');?>" >
										</td>
									</tr>


								</table>
							</fieldset>
						</td>						

					 </tr>

					 <tr>
					 	<td colspan="4" >
								<fieldset>
									<legend>Decorative Elements:</legend>
								<table class="form_table_inner">

									<tr>
										<td class="label">Tube Foil :</td>
										<td colspan="3">
											<select name="tube_foil" id="tube_foil" >
												<option value="">--Select Tube Foil--</option>
												<option value="YES" <?php echo set_select('tube_foil','YES');?> >YES</option>
												<option value="NO" <?php echo set_select('tube_foil','NO');?> >NO</option>
											</select>
										</td>
									</tr>

									<tr>
										<td class="label">Shoulder Foil :</td>
										<td colspan="3">
											<select name="shoulder_foil" id="shoulder_foil" >
												<option value="">--Select Tube Foil--</option>
												<option value="YES" <?php echo set_select('shoulder_foil','YES');?> >YES</option>
												<option value="NO" <?php echo set_select('shoulder_foil','NO');?> >NO</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="label">Cap Shirnk Sleeve :</td>
										<td>
											<select name="cap_shrink_sleeve" id="cap_shrink_sleeve" >
												<option value="">--Select Shrink Sleeve--</option>
												<option value="YES" <?php echo set_select('cap_shrink_sleeve','YES');?> >YES</option>
												<option value="NO" <?php echo set_select('cap_shrink_sleeve','NO');?> >NO</option>
											</select>
										</td>
									</tr>

									<tr>
										<td class="label">Cap Foil :</td>
										<td>							   
											<select name="cap_foil" id="cap_foil" >
												<option value="">--Select Cap Foil--</option>
												<option value="YES" <?php echo set_select('cap_foil','YES');?> >YES</option>
												<option value="NO" <?php echo set_select('cap_foil','NO');?> >NO</option>
											</select>	
											
										</td>
									</tr>

										
									<tr>
										<td class="label">Cap Metalization :</td>
										<td>									  
											<select name="cap_metalization" id="cap_metalization" >
												<option value="">--Select Metalization--</option>
												<option value="YES" <?php echo set_select('cap_metalization','YES');?> >YES</option>
												<option value="NO" <?php echo set_select('cap_metalization','NO');?> >NO</option>
											</select>	
											
										</td>
									</tr>									

									<!-- <tr>
										<td class="label">Label Price :</td>
										<td colspan="3"><input type="number" class="number" name="label_price"    id="label_price" size="35" maxlength="5" value="<?php echo set_value('label_price');?>" >
										</td>
									</tr> -->

								</table>
							</fieldset>
						</td>						

					 </tr>		

					 <tr>
							<td colspan="4">
						
								<fieldset>
									<LEGEND> Freight Cost:</LEGEND>
									<table class="form_table_inner">		
									<tr>
										<td class="label">Freight  :</td>
										<td colspan="3"><input type="text" name="freight" id="freight"  value="<?php echo set_value('freight');?>" />
										</td>
									</tr>
									
									
									</table>
								</fieldset>
							</td>
						</tr>						
						
						
					</table>						 
				</td>
				<td width="50%">
					<table class="form_table_inner">
						<!-- QUOTE -->
						<tr>
							<td colspan="4" width="100%">
								<fieldset>
										<legend>Quote:</legend>
								<table class="form_table_inner" id="tblflag">
									<tr>
										<th></th>
										<th>Machine</th>
										<th>Capacity</th>
										<th>Speed</th>
										<th>Speed 90%</th>										
										<th>Setup Time</th>
										<th>Contribution</th>
										<span id="spnError" class="error" style="display: none; color: red;">Please select at-least one Checkbox.</span>
									</tr>
									<tr>
										<td width="2%"></td>
										<td width="10%"><select name="machine_type" id="machine_type" >
												<option value=''>--Machine --</option>
										<?php if($machine_type==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
										else{
											foreach($machine_type as $machine_type_row){
												echo "<option value='".$machine_type_row->machine_id."'  ".set_select('machine_type',''.$machine_type_row->machine_id.'').">".$machine_type_row->machine_name."</option>";
												}
											}?>
											</select>
											</td>
										<td width="3%">
										<input type="text" style="background-color: #ddd" readonly="readonly" name="capacity" id="capacity"  size="3" value="<?php echo set_value('capacity');?>"  /> 
										</td>
										<td width="10%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<input type="text" style="background-color: #ddd" readonly="readonly" name="running_speed" id="running_speed"  size="4" value="<?php echo set_value('running_speed');?>"  />
										</td>
										<td width="10%">&nbsp;&nbsp;&nbsp;&nbsp;
										<input type="text" style="background-color: #ddd" readonly="readonly" name="running_speed_90" id="running_speed_90"  size="4" value="<?php echo set_value('running_speed_90');?>"  />
										</td>
										<td width="10%">&nbsp;&nbsp;&nbsp;&nbsp;
										<input type="text" style="background-color: #ddd" readonly="readonly" name="job_changeover" id="job_changeover"  size="4" value="<?php echo set_value('job_changeover');?>"  />
										</td>
										<td width="10%">&nbsp;&nbsp;&nbsp;&nbsp;
										<input type="text" style="background-color: #ddd" readonly="readonly" name="min_contribution" id="min_contribution" size="4" value="<?php echo set_value('min_contribution');?>"  />
										</td>

									</tr>


									<tr>
										<th width="2%"> </th><th width="12%">Quote</th>
										<th width="3%">Waste %</th>
										<!-- <th width="10%">Target Contr.</th> --><th width="12%">Contr.</th><th width="12%">Cost</th>	<th width="12%">Quoted Price</th>
									</tr>
									<tr>

										<td><input type="checkbox" name="_5k_flag" id="_5k_flag" value="1" <?php echo set_checkbox('_5k_flag','1');?> /></td>

										<td class="label"> 5K <input type="hidden" name="_5k" id="_5k" value="5000"></td>
										<td><input type="text"  size="3" name="_5k_waste" id="_5k_waste"   value="<?php echo set_value('_5k_waste');?>" /></td>
										<!-- <td ><input type="text" class="number1" name="_5k_target_contr" id="_5k_target_contr"   value="<?php echo set_value('_5k_target_contr');?>"  />
										</td> -->
										<td ><input type="text" style="background-color: #ddd" class="number1" name="_5k_quoted_contr" id="_5k_quoted_contr"  value="<?php echo set_value('_5k_quoted_contr');?>"  size="4"/>
										</td>
										<td ><input readonly="readonly" style="background-color: #ddd" type="text" class="number1 _5k_quote_cost" name="_5k_cost" id="_5k_cost"  value="<?php echo set_value('_5k_cost');?>" size="4"/>
										</td>
										<td > <input type="text" style="background-color: #ddd" class="number1" name="_5k_quoted_price" id="_5k_quoted_price"  value="<?php echo set_value('_5k_quoted_price');?>" size="4"/>
										</td>
										
									</tr>
									<tr>
										<td><input type="checkbox" name="_10k_flag" id="_10k_flag" value="1" <?php echo set_checkbox('_10k_flag','1');?> /></td>
										<td class="label" >10K <input type="hidden" name="_10k" id="_10k" value="10000">
										</td>
										<td><input type="text"   size="3" name="_10k_waste" id="_10k_waste"  value="<?php echo set_value('_10k_waste');?>"  /></td>
										<!-- <td><input type="text" class="number1" name="_10k_target_contr" id="_10k_target_contr"  value="<?php echo set_value('_10k_target_contr');?>" />
										</td> -->
										<td><input type="text" style="background-color: #ddd" class="number1" name="_10k_quoted_contr" id="_10k_quoted_contr"  value="<?php echo set_value('_10k_quoted_contr');?>" />
										</td>
										<td><input readonly="readonly" style="background-color: #ddd" type="text" class="number1 _10k_quote_cost" name="_10k_cost"  id="_10k_cost"   value="<?php echo set_value('_10k_cost');?>"  />
										</td>
										<td><input type="text" style="background-color: #ddd" class="number1" name="_10k_quoted_price" id="_10k_quoted_price" value="<?php echo set_value('_10k_quoted_price');?>" />
										</td>
									</tr>
									<tr>
										<td><input type="checkbox" name="_25k_flag" id="_25k_flag" value="1" <?php echo set_checkbox('_25k_flag','1');?> /></td>
										<td class="label">25K  <input type="hidden" name="_25k" id="_25k" value="25000"> </td>
										<td><input type="text"   size="3" name="_25k_waste" id="_25k_waste"   value="<?php echo set_value('_25k_waste');?>"  /></td>
										<!-- <td><input type="text" class="number1" name="_25k_target_contr" id="_25k_target_contr"  value="<?php echo set_value('_25k_target_contr');?>" />
										</td> -->
										<td><input type="text" style="background-color: #ddd" class="number1" name="_25k_quoted_contr" id="_25k_quoted_contr"  value="<?php echo set_value('_25k_quoted_contr');?>" />
										</td>
										<td><input readonly="readonly" style="background-color: #ddd" type="text" class="number1 _25k_quote_cost" name="_25k_cost" id="_25k_cost"  value="<?php echo set_value('_25k_cost');?>" />
										</td>
										<td><input type="text" style="background-color: #ddd" class="number1" name="_25k_quoted_price" id="_25k_quoted_price"  value="<?php echo set_value('_25k_quoted_price');?>" />
										</td>
									</tr>
									<tr>
										<td><input type="checkbox" name="_50k_flag" id="_50k_flag" value="1" <?php echo set_checkbox('_50k_flag','1');?> /></td>
										<td class="label">50K <input type="hidden" name="_50k" id="_50k" value="50000"> </td>
										<td><input type="text"  size="3" name="_50k_waste" id="_50k_waste"   value="<?php echo set_value('_50k_waste');?>"  /></td>										
										<!-- <td><input type="text" class="number1" name="_50k_target_contr" id="_50k_target_contr"  value="<?php echo set_value('_50k_target_contr');?>" />
										</td> -->
										<td><input type="text" style="background-color: #ddd" class="number1" name="_50k_quoted_contr" id="_50k_quoted_contr"  value="<?php echo set_value('_50k_quoted_contr');?>" />
										</td>
										<td><input readonly="readonly" style="background-color: #ddd" type="text" class="number1 _50k_quote_cost" name="_50k_cost" id="_50k_cost"  value="<?php echo set_value('_50k_cost');?>"  />
										</td>
										<td><input type="text" style="background-color: #ddd" class="number1" name="_50k_quoted_price" id="_50k_quoted_price"  value="<?php echo set_value('_50k_quoted_price');?>" />
										</td>
									</tr>
									<tr>
										<td><input type="checkbox" name="_100k_flag" id="_100k_flag" value="1" <?php echo set_checkbox('_100k_flag','1');?> /></td>
										<td class="label">100K  <input type="hidden" name="_100k" id="_100k" value="100000"></td>
										<td><input type="text"  size="3" name="_100k_waste" id="_100k_waste"   value="<?php echo set_value('_100k_waste');?>"  /></td>
										<!-- <td><input type="text" class="number1" name="_100k_target_contr" id="_100k_target_contr"  value="<?php echo set_value('_100k_target_contr');?>"  />
										</td> -->
										<td><input type="text" style="background-color: #ddd" class="number1" name="_100k_quoted_contr" id="_100k_quoted_contr"  value="<?php echo set_value('_100k_quoted_contr');?>" />
										</td>
										<td><input readonly="readonly" style="background-color: #ddd" type="text" class="number1 _100k_quote_cost" name="_100k_cost" id="_100k_cost"  value="<?php echo set_value('_100k_cost');?>"  />
										</td>
										<td><input type="text" style="background-color: #ddd" class="number1" name="_100k_quoted_price" id="_100k_quoted_price" value="<?php echo set_value('_100k_quoted_price');?>" />
										</td>
									</tr>
									<tr>
										<td><input type="checkbox" name="free_flag" id="free_flag" value="1" <?php echo set_checkbox('free_flag','1');?> /></td>
										<td class="label"> <input type="text" name="free_quantity" id="free_quantity"  size="10" value="<?php echo set_value('free_quantity');?>"></td>
										<td><input type="text"  size="3" name="_free_quantity_waste" id="_free_quantity_waste"   value="<?php echo set_value('_free_quantity_waste');?>"  /></td>
										<!-- <td><input type="text" class="number1" name="free_target_contr" id="free_target_contr"  value="<?php echo set_value('free_target_contr');?>"  />
										</td> -->
										<td><input type="text" style="background-color: #ddd" class="number1" name="free_quoted_contr" id="free_quoted_contr"  value="<?php echo set_value('free_quoted_contr');?>" />
										</td>
										<td><input readonly="readonly" style="background-color: #ddd" type="text" class="number1 _free_quantity_quote_cost" name="free_cost" id="free_cost"  value="<?php echo set_value('free_cost');?>" />
										</td>
										<td><input type="text" style="background-color: #ddd" class="number1" name="free_quoted_price" id="free_quoted_price"  value="<?php echo set_value('free_quoted_price');?>"  />
										</td>
									</tr>

								</table>
							</fieldset>
							</td>
						</tr>
						
						
						<!-- Cost sheet details -->
						<tr>
							<td colspan="4">						
								<fieldset>
									<LEGEND> Cost Taken Based On:</LEGEND>
									<table class="form_table_inner">		
										
										<tr>
											<td class="label">Invoice no :</td>
											<td colspan="3"><input type="text" name="invoice_no" id="invoice_no"  value="<?php echo set_value('invoice_no');?>" />
											</td>
										</tr>
											


									</table>
								</fieldset>
							</td>				
						</tr>
						<tr>
							<td>
								<fieldset>
									<legend>Remarks:</legend>

								<table class="form_table_inner">
									<tr>
										<td class="label" width="27%">Remarks :</td>
										<td colspan="3" >
											<textarea name="remarks" id="remarks" cols="50" rows="5" value="<?php echo trim(set_value('remarks'));?>" maxlength="512"><?php echo trim(set_value('remarks'));?></textarea>
										</td>
									</tr>									
								</table>
								</fieldset>	
							</td>							
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
	  		<button class="ui positive button" id="search">Search</button>
		</div>
	</div>

	
</form>




				
				
				
			