<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){

		$("#loading").hide(); $("#cover").hide();

		$("#customer_category").autocomplete("<?php echo base_url('index.php/ajax/customer_category_autocomplete');?>", {selectFirst: true});
		$("#article_no").autocomplete("<?php echo base_url('index.php/ajax/article_no');?>", {selectFirst: true});
		$("#invoice_no").autocomplete("<?php echo base_url('index.php/ajax/ar_invoice_no');?>", {selectFirst: true});				


	});//Jquery closed

</script>
<style type="text/css">
	fieldset {border: 1px solid #8cacbb;}
	fieldset legend{font-weight: bold;}
</style>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">
						<tr>
							<td>
								<fieldset>
									<legend>Information:</legend>
									<table>						 
										<tr>							
											<td class="label"> Customer: <span style="color:red;">*</span> :</td>
											<td colspan="3"><input type="text" name="customer_category" id="customer_category"  size="55" value="<?php echo set_value('customer_category');?>" /></td>								
										</tr>
										<tr>							
											<td class="label">Purchase Manager 1 <span style="color:red;">*</span> :</td>
											<td colspan="3"><input type="text" name="pm_1" id="pm_1"  size="30" value="<?php echo set_value('pm_1');?>" maxlength="100"/></td>								
										</tr>
										<tr>							
											<td class="label">Purchase Manager 2 :</td>
											<td colspan="3"><input type="text" name="pm_2" id="pm_2"  size="30" value="<?php echo set_value('pm_2');?>" maxlength="100"/></td>								
										</tr>
										<tr>							
											<td class="label">Annual Tube Buy :</td>
											<td colspan="3"> Min: <input type="number" name="annual_tube_buy_min" id="annual_tube_buy_min" min="0" max="1000000000" value="<?php echo set_value('annual_tube_buy_min');?>" />
												Max: <input type="number" name="annual_tube_buy_max" id="annual_tube_buy_max" min="0" max="1000000000"value="<?php echo set_value('annual_tube_buy_max');?>" />
										
											</td>
										</tr>
										<tr>							
											<td class="label">Annual Bottle Buy :</td>
											<td colspan="3"> Min: <input type="number" name="annual_bottle_buy_min" id="annual_bottle_buy_min" min="0" max="1000000000"value="<?php echo set_value('annual_bottle_buy_min');?>" />
												Max: <input type="number" name="annual_bottle_buy_max" id="annual_bottle_buy_max" min="0" max="1000000000"value="<?php echo set_value('annual_bottle_buy_max');?>" />
										
											</td>								
										</tr>
										<tr>
											<td class="label">CurrentCustomer(LTM) <span style="color:red;">*</span> :</td>
											<td>
												<select name="current_customer" id="current_customer">
													<option value="">--Select--</option>
													<option value="YES" <?php echo set_select('current_customer','YES');?> >YES</option>
													<option value="NO" <?php echo set_select('current_customer','NO');?> >NO</option>
												</select>
											</td>							
											<td class="label">Previous Customer(LTM) <span style="color:red;">*</span> :</td>
											<td>
												<select name="previous_customer" id="previous_customer">
													<option value="">--Select--</option>
													<option value="YES" <?php echo set_select('previous_customer','YES');?> >YES</option>
													<option value="NO" <?php echo set_select('previous_customer','NO');?> >NO</option>
												</select>
											</td>
											
										</tr>						 
										<tr>
											<td class="label">Prospect (Never Bought) <span style="color:red;">*</span> :</td>
											<td>
												<select name="prospect" id="prospect">
													<option value="">--Select--</option>
													<option value="YES" <?php echo set_select('prospect','YES');?> >YES</option>
													<option value="NO" <?php echo set_select('prospect','NO');?> >NO</option>
												</select>
											</td>
										</tr>
										<tr>
											<td class="label">Current Supplier <span style="color:red;">*</span> :</td>
											<td colspan="3"><input type="text" name="current_supplier" id="current_supplier" size="55" value="<?php echo set_value('current_supplier');?>" maxlength="128" /></td>
										</tr>
										<tr>							
											<td class="label">Current Price :</td>
											<td colspan="3"> Min: <input type="number" name="current_supplier_price_min" id="current_supplier_price_min" min="0" max="1000000000"value="<?php echo set_value('current_supplier_price_min');?>" />
												Max: <input type="number" name="current_supplier_price_max" id="current_supplier_price_max" min="0" max="1000000000"value="<?php echo set_value('current_supplier_price_max');?>" />						
											</td>								
										</tr>
										<tr>
											<td class="label">Currently in Tube <span style="color:red;">*</span> :</td>
											<td>
												<select name="currently_in_tube" id="currently_in_tube">
													<option value="">--Select--</option>
													<option value="YES" <?php echo set_select('currently_in_tube','YES');?> >YES</option>
													<option value="NO" <?php echo set_select('currently_in_tube','NO');?> >NO</option>
												</select>
											</td>
											<td class="label">Currently in Bottle <span style="color:red;">*</span> :</td>
											<td>
												<select name="currently_in_bottle" id="currently_in_bottle">
													<option value="">--Select--</option>
													<option value="YES" <?php echo set_select('currently_in_bottle','YES');?> >YES</option>
													<option value="NO" <?php echo set_select('currently_in_bottle','NO');?> >NO</option>
												</select>
											</td>
										</tr>
										<tr>
											<td class="label">Currently in Other Packaging <span style="color:red;">*</span> :</td>
											<td>
												<select name="currently_in_other_pckg" id="currently_in_other_pckg">
													<option value="">--Select--</option>
													<option value="YES" <?php echo set_select('currently_in_other_pckg','YES');?> >YES</option>
													<option value="NO" <?php echo set_select('currently_in_other_pckg','NO');?> >NO</option>
												</select>
											</td>
											<td class="label">New Product <span style="color:red;">*</span> :</td>
											<td>
												<select name="new_product" id="new_product">
													<option value="">--Select--</option>
													<option value="YES" <?php echo set_select('new_product','YES');?> >YES</option>
													<option value="NO" <?php echo set_select('new_product','NO');?> >NO</option>
												</select>
											</td>
										</tr>
									</table>
								</fieldset>
							</td>
						</tr>					 							
						<!-- QUOTE -->
						<tr>
							<td colspan="4" width="100%">
								<fieldset>
										<legend>Quote:</legend>
								<table>
									<tr>
										<th>Quote</th><th>Target Contr.</th><th>Quoted Contr.</th><th>Cost</th><th>Quoted Price</th>
									</tr>
									<tr>
										<td class="label" width="25%"> < 10K</td>

										<td width="17%"><input type="number" name="less_than_10k_target_contr" id="less_than_10k_target_contr" min="0" max="1000" value="<?php echo set_value('less_than_10k_target_contr');?>" />
										</td>
										<td width="17%"><input type="number" name="less_than_10k_quoted_contr" id="less_than_10k_quoted_contr" min="0" max="1000"value="<?php echo set_value('less_than_10k_quoted_contr');?>" />
										</td>
										<td width="17%"><input type="number" name="less_than_10k_cost" id="less_than_10k_cost" min="0" max="1000"value="<?php echo set_value('less_than_10k_cost');?>" />
										</td>
										<td width="17%"> <input type="number" name="less_than_10k_quoted_price" id="less_than_10k_quoted_price" min="0" max="1000"value="<?php echo set_value('less_than_10k_quoted_price');?>" />
										</td>
									</tr>
									<tr>
										<td class="label" width="17%">10K - 25K</td>
										<td><input type="number" name="_10k_to_25k_target_contr" id="_10k_to_25k_target_contr" min="0" max="1000"value="<?php echo set_value('_10k_to_25k_target_contr');?>" />
										</td>
										<td><input type="number" name="_10k_to_25k_quoted_contr" id="_10k_to_25k_quoted_contr" min="0" max="1000"value="<?php echo set_value('_10k_to_25k_quoted_contr');?>" />
										</td>
										<td><input type="number" name="_10k_to_25k_cost" id="_10k_to_25k_cost" min="0" max="1000"value="<?php echo set_value('_10k_to_25k_cost');?>" />
										</td>
										<td><input type="number" name="_10k_to_25k_quoted_price" id="_10k_to_25k_quoted_price" min="0" max="1000"value="<?php echo set_value('_10k_to_25k_quoted_price');?>" />
										</td>
									</tr>
									<tr>
										<td class="label">25K - 50K</td>
										<td><input type="number" name="_25k_to_50k_target_contr" id="_25k_to_50k_target_contr" min="0" max="1000"value="<?php echo set_value('_25k_to_50k_target_contr');?>" />
										</td>
										<td><input type="number" name="_25k_to_50k_quoted_contr" id="_25k_to_50k_quoted_contr" min="0" max="1000"value="<?php echo set_value('_25k_to_50k_quoted_contr');?>" />
										</td>
										<td><input type="number" name="_25k_to_50k_cost" id="_25k_to_50k_cost" min="0" max="1000"value="<?php echo set_value('_25k_to_50k_cost');?>" />
										</td>
										<td><input type="number" name="_25k_to_50k_quoted_price" id="_25k_to_50k_quoted_price" min="0" max="1000"value="<?php echo set_value('_25k_to_50k_quoted_price');?>" />
										</td>
									</tr>
									<tr>
										<td class="label">50K - 100K</td>
										<td><input type="number" name="_50k_to_100k_target_contr" id="_50k_to_100k_target_contr" min="0" max="1000"value="<?php echo set_value('_50k_to_100k_target_contr');?>" />
										</td>
										<td><input type="number" name="_50k_to_100k_quoted_contr" id="_50k_to_100k_quoted_contr" min="0" max="1000"value="<?php echo set_value('_50k_to_100k_quoted_contr');?>" />
										</td>
										<td><input type="number" name="_50k_to_100k_cost" id="_50k_to_100k_cost" min="0" max="1000"value="<?php echo set_value('_50k_to_100k_cost');?>" />
										</td>
										<td><input type="number" name="_50k_to_100k_quoted_price" id="_50k_to_100k_quoted_price" min="0" max="1000"value="<?php echo set_value('_50k_to_100k_quoted_price');?>" />
										</td>
									</tr>
									<tr>
										<td class="label">100K -250K</td>
										<td><input type="number" name="_100k_to_250k_target_contr" id="_100k_to_250k_target_contr" min="0" max="1000"value="<?php echo set_value('_100k_to_250k_target_contr');?>" />
										</td>
										<td><input type="number" name="_100k_to_250k_quoted_contr" id="_100k_to_250k_quoted_contr" min="0" max="1000"value="<?php echo set_value('_100k_to_250k_quoted_contr');?>" />
										</td>
										<td><input type="number" name="_100k_to_250k_cost" id="_100k_to_250k_cost" min="0" max="1000"value="<?php echo set_value('_100k_to_250k_cost');?>" />
										</td>
										<td><input type="number" name="_100k_to_250k_quoted_price" id="_100k_to_250k_quoted_price" min="0" max="1000"value="<?php echo set_value('_100k_to_250k_quoted_price');?>" />
										</td>
									</tr>
									<tr>
										<td class="label">>250K</td>
										<td><input type="number" name="greater_than_250k_target_contr" id="greater_than_250k_target_contr" min="0" max="1000"value="<?php echo set_value('greater_than_250k_target_contr');?>" />
										</td>
										<td><input type="number" name="greater_than_250k_quoted_contr" id="greater_than_250k_quoted_contr" min="0" max="1000"value="<?php echo set_value('greater_than_250k_quoted_contr');?>" />
										</td>
										<td><input type="number" name="greater_than_250k_cost" id="greater_than_250k_cost" min="0" max="1000"value="<?php echo set_value('greater_than_250k_cost');?>" />
										</td>
										<td><input type="number" name="greater_than_250k_quoted_price" id="greater_than_250k_quoted_price" min="0" max="1000"value="<?php echo set_value('greater_than_250k_quoted_price');?>" />
										</td>
									</tr>

								</table>
							</fieldset>
							</td>
						</tr>
						
					</table>						 
				</td>
				<td width="50%">
					<table>
						<tr>
							<td colspan="4">
								<fieldset>
									<legend>Specification:</legend>
								<table>

									<tr>
										<td class="label">Sleeve Dia <span style="color:red;">*</span>:</td>
										<td><select name="sleeve_dia" id="sleeve_dia"><option value=''>--Select Dia--</option>
										<?php   if($sleeve_dia==FALSE){
													echo "<option value=''>--Setup Required--</option>";
												}
											else{
												foreach($sleeve_dia as $sleeve_dia_row){
													echo "<option value='".$sleeve_dia_row->sleeve_id."'  ".set_select('sleeve_dia',''.$sleeve_dia_row->sleeve_id.'').">".$sleeve_dia_row->sleeve_diameter."</option>";
												}
												}?></select>
										</td>
										<td class="label">Sleeve Length <span style="color:red;">*</span> :</td>
										<td><input type="number" name="sleeve_length" min="10"  max="500" step="0.1"  id="sleeve_length" size="5" maxlength="5" value="<?php echo set_value('sleeve_length');?>">
										</td>

									</tr>
									<tr>
										<td class="label">Layer <span style="color:red;">*</span> :</td>
										<td>
											<select name="layer" id="layer">
												<option value="">--Select Layer--</option>							 
												<option value="1" <?php echo set_select('layer',1);?> >1</option>
												<option value="2" <?php echo set_select('layer',2);?> >2</option>
												<option value="3" <?php echo set_select('layer',3);?> >3</option>
												<option value="4" <?php echo set_select('layer',4);?> >4</option>
												<option value="5" <?php echo set_select('layer',5);?> >5</option>
												<option value="6" <?php echo set_select('layer',6);?> >6</option>
												<option value="7" <?php echo set_select('layer',7);?> >7</option>
												
											</select>
										</td>
										<td class="label">Tube MB  <span style="color:red;">*</span> :</td>
										<td>
											<select name="tube_mb" id="tube_mb">
												<option value="">--Select Tube MB--</option>
												<option value="YES" <?php echo set_select('tube_mb','YES');?> >YES</option>
												<option value="NO" <?php echo set_select('tube_mb','NO');?> >NO</option>
											</select>	
												
										</td>
									</tr>
									<tr>
										<td class="label">Print Type <span style="color:red;">*</span> :</td>
										<td>
											<select name="print_type" class="print_type">
												<option value=''>--Print Type--</option>
										<?php if($print_type==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
										else{
											foreach($print_type as $print_type_row){
												echo "<option value='".$print_type_row->printing_group."'  ".set_select('print_type',''.$print_type_row->printing_group.'').">".$print_type_row->printing_group."</option>";
															}
											}?>
											</select>
										</td>
										<td class="label">Special Ink <span style="color:red;">*</span> :</td>	 
										<td>  
											<select name="special_ink" id="special_ink">
												<option value="">--Select Special ink--</option>
												<option value="YES" <?php echo set_select('special_ink','YES');?> >YES</option>
												<option value="NO" <?php echo set_select('special_ink','NO');?> >NO</option>
											</select>							
										</td>
									</tr>
									<tr>
										<td class="label">Tube Foil <span style="color:red;">*</span>:</td>
										<td colspan="3">
											<select name="tube_foil" id="tube_foil">
												<option value="">--Select Tube Foil--</option>
												<option value="YES" <?php echo set_select('tube_foil','YES');?> >YES</option>
												<option value="NO" <?php echo set_select('tube_foil','NO');?> >NO</option>
											</select>
										</td>
									</tr>

									<tr>
										<td class="label">Cap Finish <span style="color:red;">*</span> :</td>
										<td>
											<select name="cap_finish" id="cap_finish">
												<option value="">--Select Cap Finish--</option>
												<option value="GLOSS" <?php echo set_select('cap_finish','GLOSS');?> >GLOSS</option>
												<option value="MATT" <?php echo set_select('cap_finish','MATT');?> >MATT</option>
											</select>
										</td>	
										<td class="label">Cap MB <span style="color:red;">*</span> :</td>
										<td>
											<select name="cap_mb" id="cap_mb">
												<option value="">--Select Cap MB--</option>
												<option value="YES" <?php echo set_select('cap_mb','YES');?> >YES</option>
												<option value="NO" <?php echo set_select('cap_mb','NO');?> >NO</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="label">Cap Type <span style="color:red;">*</span> :</td>
										<td>
											<select name="cap_type" id="cap_type"><option value=''>--Select Cap Type--</option>
											<?php 	if($cap_type==FALSE){
													echo "<option value=''>--Setup Required--</option>";
												}
												else
												{
													foreach($cap_type as $cap_type_row){
													echo "<option value='".$cap_type_row->cap_type."' ".set_select('cap_type',$cap_type_row->cap_type).">".$cap_type_row->cap_type."</option>";
													}
												}
											?>
											</select>
										</td>
										<td class="label">Cap Foil <span style="color:red;">*</span> :</td>
										<td>							   
											<select name="cap_foil" id="cap_foil">
												<option value="">--Select Cap Foil--</option>
												<option value="YES" <?php echo set_select('cap_foil','YES');?> >YES</option>
												<option value="NO" <?php echo set_select('cap_foil','NO');?> >NO</option>
											</select>	
											
										</td>
									</tr>

									<tr>
										<td class="label">Cap Shirnk Sleeve <span style="color:red;">*</span> :</td>
										<td>
											<select name="cap_shrink_sleeve" id="cap_shrink_sleeve">
												<option value="">--Select Shrink Sleeve--</option>
												<option value="YES" <?php echo set_select('cap_shrink_sleeve','YES');?> >YES</option>
												<option value="NO" <?php echo set_select('cap_shrink_sleeve','NO');?> >NO</option>
											</select>
										</td>
										<td class="label">Cap Metalization <span style="color:red;">*</span> :</td>
										<td>									  
											<select name="cap_metalization" id="cap_metalization">
												<option value="">--Select Metalization--</option>
												<option value="YES" <?php echo set_select('cap_metalization','YES');?> >YES</option>
												<option value="NO" <?php echo set_select('cap_metalization','NO');?> >NO</option>
											</select>	
											
										</td>
									</tr>

									<tr>
										<td class="label">Shoulder Foil :</td>
										<td colspan="3">
											<select name="shoulder_foil" id="shoulder_foil">
												<option value="">--Select Tube Foil--</option>
												<option value="YES" <?php echo set_select('shoulder_foil','YES');?> >YES</option>
												<option value="NO" <?php echo set_select('shoulder_foil','NO');?> >NO</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="label">Label Price :</td>
										<td colspan="3"><input type="number" name="label_price" min="0"  max="500" step="0.1"  id="label_price" size="5" maxlength="5" value="<?php echo set_value('label_price');?>">
										</td>
									</tr>
								</table>
							</fieldset>
						</td>			

						<!-- Customer Price Range -->
						<tr>
							<td colspan="4">
						
								<fieldset>
									<LEGEND> Customer Product Price Range:</LEGEND>
									<table>		
									<tr>							
										<td class="label" width="35%">50g :</td>
										<td> Min: <input type="number" name="_50g_min" id="_50g_min" min="0" max="100"value="<?php echo set_value('_50g_min');?>" />
											Max: <input type="number" name="_50g_max" id="_50g_max" min="0" max="100"value="<?php echo set_value('_50g_max');?>" />						
										</td>								
									</tr>
									<tr>							
										<td class="label">100g :</td>
										<td> Min: <input type="number" name="_100g_min" id="_100g_min" min="0" max="100"value="<?php echo set_value('_100g_min');?>" />
											Max: <input type="number" name="_100g_max" id="_100g_max" min="0" max="100"value="<?php echo set_value('_100g_max');?>" />						
										</td>								
									</tr>
									<tr>							
										<td class="label">150g :</td>
										<td> Min: <input type="number" name="_150g_min" id="_150g_min" min="0" max="100"value="<?php echo set_value('_150g_min');?>" />
											Max: <input type="number" name="_150g_max" id="_150g_max" min="0" max="100"value="<?php echo set_value('_150g_max');?>" />						
										</td>								
									</tr>
									<tr>							
										<td class="label">200g :</td>
										<td> Min: <input type="number" name="_200g_min" id="_200g_min" min="0" max="100"value="<?php echo set_value('_200g_min');?>" />
											Max: <input type="number" name="_200g_max" id="_200g_max" min="0" max="100"value="<?php echo set_value('_200g_max');?>" />						
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
									<table>		
										<tr>
											<td class="label">Article no :</td>
											<td colspan="3"><input type="text" name="article_no" id="article_no"  size="55" value="<?php echo set_value('article_no');?>" />
											</td>
										</tr>
										<tr>
											<td class="label">Cost sheet date :</td>
											<td><input type="date" name="invoice_date"   value="<?php echo set_value('invoice_date');?>" />

											</td>
										</tr>
										<tr>
											<td class="label">Invoice no :</td>
											<td colspan="3"><input type="text" name="invoice_no" id="invoice_no"  value="<?php echo set_value('invoice_no');?>" />
											</td>
										</tr>
										<tr>							
										<td class="label">Cost :</td>
										<td>
											<input type="number" name="cost" id="cost" min="0" max="100" step="any" value="<?php echo set_value('cost');?>" />
										</td>	


									</table>
								</fieldset>
							</td>				
						</tr>
						<tr>
							<td class="label">Remarks <span style="color:red;">*</span> :</td>
							<td colspan="3">
								<textarea name="remarks" id="remarks" cols="50" rows="5" value="<?php echo trim(set_value('remarks'));?>" maxlength="512"><?php echo trim(set_value('remarks'));?></textarea>
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
	  		<button class="ui positive button" onClick="return confirm('Are you sure to save Record?');">Save</button>
		</div>
	</div>

	
</form>




				
				
				
			