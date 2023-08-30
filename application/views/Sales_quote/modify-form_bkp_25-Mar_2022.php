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

		$("#customer_category").blur(function() {
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/purchase_manager');?>",data: {customer : $("#customer_category").val()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#pm_1").html(html);
				} 
			});
		});

		// if($("#customer").val()!=''){
		// 	$("#loading").show(); $("#cover").show();
		// 	$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
		// 	$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/purchase_manager');?>",data: {customer : $("#customer").val()},cache: false,success: function(html){
		// 		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
		// 		$("#pm_1").html(html);
		// 		} 
		// 	});
		// }

		//--------------------Quote price------------------------------------

		   $("#less_than_10k_packing").blur(function(){
					
										
					if($("#less_than_10k_quoted_contr").val()!='' && $("#less_than_10k_cost").val()!='' && $("#less_than_10k_freight").val()!='' && $("#less_than_10k_packing").val()!=''){
							
								//var less_than_10k_quoted_contr=$("#less_than_10k_quoted_contr").val();
								//alert(parseInt(less_than_10k_quoted_contr).toFixed(1));

								var less_than_10k_quoted_price=	parseFloat($("#less_than_10k_quoted_contr").val()) + parseFloat($("#less_than_10k_cost").val()) + parseFloat($("#less_than_10k_freight").val()) + parseFloat($("#less_than_10k_packing").val());
								$("#less_than_10k_quoted_price").val(less_than_10k_quoted_price.toFixed(2));
							
					}
				});

		   $("#_10k_to_25k_packing").blur(function(){
					
										
					if($("#_10k_to_25k_quoted_contr").val()!='' && $("#_10k_to_25k_cost").val()!='' && $("#_10k_to_25k_freight").val()!='' && $("#_10k_to_25k_packing").val()!=''){
							
								var _10k_to_25k_quoted_price=	parseFloat($("#_10k_to_25k_quoted_contr").val()) + parseFloat($("#_10k_to_25k_cost").val()) + parseFloat($("#_10k_to_25k_freight").val()) + parseFloat($("#_10k_to_25k_packing").val());
								$("#_10k_to_25k_quoted_price").val(_10k_to_25k_quoted_price.toFixed(2));
							
					}
				});

		   $("#_25k_to_50k_packing").blur(function(){
					
										
					if($("#_25k_to_50k_quoted_contr").val()!='' && $("#_25k_to_50k_cost").val()!='' && $("#_25k_to_50k_freight").val()!='' && $("#_25k_to_50k_packing").val()!=''){
							
								var _25k_to_50k_quoted_price=	parseFloat($("#_25k_to_50k_quoted_contr").val()) + parseFloat($("#_25k_to_50k_cost").val()) + parseFloat($("#_25k_to_50k_freight").val()) + parseFloat($("#_25k_to_50k_packing").val());
								$("#_25k_to_50k_quoted_price").val(_25k_to_50k_quoted_price.toFixed(2));
							
					}
				});

		   $("#_50k_to_100k_packing").blur(function(){
					
										
					if($("#_50k_to_100k_quoted_contr").val()!='' && $("#_50k_to_100k_cost").val()!='' && $("#_50k_to_100k_freight").val()!='' && $("#_50k_to_100k_packing").val()!=''){
							
								var _50k_to_100k_quoted_price=	parseFloat($("#_50k_to_100k_quoted_contr").val()) + parseFloat($("#_50k_to_100k_cost").val()) + parseFloat($("#_50k_to_100k_freight").val()) + parseFloat($("#_50k_to_100k_packing").val());
								$("#_50k_to_100k_quoted_price").val(_50k_to_100k_quoted_price.toFixed(2));
							
					}
				});

		   $("#_100k_to_250k_packing").blur(function(){
					
										
					if($("#_100k_to_250k_quoted_contr").val()!='' && $("#_100k_to_250k_cost").val()!='' && $("#_100k_to_250k_freight").val()!='' && $("#_100k_to_250k_packing").val()!=''){
							
								var _100k_to_250k_quoted_price=	parseFloat($("#_100k_to_250k_quoted_contr").val()) + parseFloat($("#_100k_to_250k_cost").val()) + parseFloat($("#_100k_to_250k_freight").val()) + parseFloat($("#_100k_to_250k_packing").val());
								$("#_100k_to_250k_quoted_price").val(_100k_to_250k_quoted_price.toFixed(2));
							
					}
				});

		   $("#greater_than_250k_packing").blur(function(){
					
										
					if($("#greater_than_250k_quoted_contr").val()!='' && $("#greater_than_250k_cost").val()!='' && $("#greater_than_250k_freight").val()!='' && $("#greater_than_250k_packing").val()!=''){
							
								var greater_than_250k_quoted_price=	parseFloat($("#greater_than_250k_quoted_contr").val()) + parseFloat($("#greater_than_250k_cost").val()) + parseFloat($("#greater_than_250k_freight").val()) + parseFloat($("#greater_than_250k_packing").val());
								$("#greater_than_250k_quoted_price").val(greater_than_250k_quoted_price.toFixed(2));
							
					}
				});			

//---------------CAP Metalization

   $("#cap_metalization").live('click',function() {
   if ($(this).is(":checked")) {
    $("#metalization_div").show();

   } else {
   	$("#metalization_div").hide();
   	$("#cap_metalization_color").val("");
   }
  });

    $("#cap_foil").live('click',function() {
   if ($(this).is(":checked")) {
    $("#foil_div").show();

   } else {
   	$("#foil_div").hide();
   	$("#cap_foil_width").val("");

   }
  });




			

	});//Jquery closed

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

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
		<?php foreach($sales_quote_master as $row):
			/*$customer_name='';
			$customer_category_result=$this->common_model->select_one_active_record('address_category_master',$this->session->userdata['logged_in']['company_id'],'adr_category_id',$row->customer_no);

			foreach ($customer_category_result as $key => $customer_category_row) {
				$customer_name=$customer_category_row->category_name."//".$customer_category_row->adr_category_id;
			}

			*/
			/*
			$customer_name='';
			$sales_quote_customer_master_result=$this->common_model->select_one_active_record('sales_quote_customer_master',$this->session->userdata['logged_in']['company_id'],'customer_id',$row->customer_no);

			foreach ($sales_quote_customer_master_result as $key => $sales_quote_customer_master_row) {
				$customer_name=$sales_quote_customer_master_row->customer_name."//".$sales_quote_customer_master_row->customer_id;
			}
				*/


		 ?>	

			<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner" width="100%">
						<tr>
							<td>
								<fieldset>
									<legend>Information:</legend>
									<table class="form_table_inner">						 
										<tr>

											<td class="label"  width="26%"> Customer: <span style="color:red;">*</span> :</td>
											<td colspan="3">
												<input type="hidden" name="id" value="<?php echo $row->id;?>" readonly>
												<input type="hidden" name="quotation_no" value="<?php echo $row->quotation_no;?>" readonly>
												<input type="text" name="customer" id="customer_category"  size="55" value="<?php echo set_value('category_name',$row->category_name.'//'.$row->customer_no.'');?>" required/></td>
												
																	
										</tr>
										<tr>							
											<td class="label">Purchase Manager <span style="color:red;">*</span> :</td>
											<td colspan="3">
												<select name="pm_1" id="pm_1" ><option value=''>--Select PM--</option>
												<?php if($purchase_manager==FALSE){
																echo "<option value=''>--Setup Required--</option>";}
													else{
														foreach($purchase_manager as $purchase_manager_row){
															$selected=($purchase_manager_row->address_category_contact_id==$row->pm_1?'selected' :'');
															echo "<option value='".$purchase_manager_row->address_category_contact_id."' ".$selected."".set_select('pm_1',''.$purchase_manager_row->address_category_contact_id.'').">".$purchase_manager_row->contact_name."</option>";
														}
												}?>
												</select>
											</td>
																												
											</td>								
										</tr>
									
										
										
										<tr>							
											<td class="label">Product Name <span style="color:red;">*</span> :</td>
											<td colspan="3"> <input type="text"  name="product_name"  size="55" value="<?php echo set_value('product_name',$row->product_name);?>" />
																	
											</td>								
										</tr>

										<tr>
											<td class="label">Payment Terms <span style="color:red;">*</span>  :</td>
											<td colspan="3"><input type="text" name="credit_days" value="<?php echo set_value('credit_days',$row->credit_days	);?>" >
											</td>
									 	</tr>

									 	<tr>
											<td class="label">Date of Enquiry <span style="color:red;">*</span>  :</td>
											<td colspan="3"><input type="date" name="enquiry_date" value="<?php echo set_value('enquiry_date',$row->enquiry_date	);?>" >
											</td>
									 	</tr>
										


									</table>
								</fieldset>
							</td>
						</tr>

						<tr>
							<td colspan="4">
								<fieldset>
									<legend>Tube Specification:</legend>
								<table class="form_table_inner">

									<tr>
										<td class="label">Layer <span style="color:red;">*</span> :</td>
										<td>
											<select name="layer" id="layer" required>
												<option value="">--Select Layer--</option>							 
												<option value="1" <?php echo set_select('layer',1);?>  <?php echo($row->layer=='1'?"selected":"");?>>1</option>
												<option value="2" <?php echo set_select('layer',2);?> <?php echo($row->layer=='2'?"selected":"");?>>2</option>
												<option value="3" <?php echo set_select('layer',3);?> <?php echo($row->layer=='3'?"selected":"");?> >3</option>
												
												<option value="5" <?php echo set_select('layer',5);?>  <?php echo($row->layer=='5'?"selected":"");?>>5</option>
												
												<option value="7" <?php echo set_select('layer',7);?>  <?php echo($row->layer=='7'?"selected":"");?>>7</option>
												
											</select>
										</td>
									</tr>

									<tr>
										<td class="label" width="25%">Sleeve Dia <span style="color:red;">*</span>:</td>
										<td width="25%"><select name="sleeve_dia" id="sleeve_dia" required><option value=''>--Select Dia--</option>
										<?php if($sleeve_dia==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($sleeve_dia as $sleeve_dia_row){
													$selected=($sleeve_dia_row->sleeve_id==$row->sleeve_dia ? 'selected' : '');

													echo "<option value='".$sleeve_dia_row->sleeve_diameter."//".$sleeve_dia_row->sleeve_id."' $selected ".set_select('sleeve_dia',''.$sleeve_dia_row->sleeve_diameter.'//'.$sleeve_dia_row->sleeve_id.'').">".$sleeve_dia_row->sleeve_diameter."</option>";
												}
										}?>


									</select>
										</td>
										<td class="label" width="25%">Sleeve Length <span style="color:red;">*</span> :</td>
										<td width="25%"><input type="number" class="number1" name="sleeve_length" min="10"  max="500" step="0.1"  id="sleeve_length"  maxlength="5" value="<?php echo set_value('sleeve_length',$row->sleeve_length);?>" required>
										</td>

									</tr>

									<tr>
										<td class="label">Tube Color <span style="color:red;">*</span>  :</td>
										<td colspan="3"><input type="text" name="tube_color" id="tube_color"value="<?php echo set_value('tube_color',$row->tube_color);?>" required>
										</td>
									</tr>
									
									<tr>
										<td class="label">Tube Lacquer <span style="color:red;">*</span> :</td>
										<td>
											<select name="tube_lacquer" id="tube_lacquer" required>
												<option value="">--Select Tube Lacquer--</option>
												<option value="GLOSS" <?php echo set_select('tube_lacquer','GLOSS');?> <?php echo($row->tube_lacquer=='GLOSS'?"selected":"");?> >GLOSS</option>
												<option value="MATT" <?php echo set_select('tube_lacquer','MATT');?> <?php echo($row->tube_lacquer=='MATT'?"selected":"");?> >MATT</option>
												<option value="SATIN_MATT" <?php echo set_select('tube_lacquer','SATIN_MATT');?> <?php echo($row->tube_lacquer=='SATIN MATT'?"selected":"");?> >SATIN MATT</option>
												<option value="SPOT" <?php echo set_select('tube_lacquer','SPOT');?> <?php echo($row->tube_lacquer=='SPOT'?"selected":"");?> >SPOT</option>
											</select>
										</td>
									</tr>
									<!--
									<tr>
										<td class="label">Tube Print Type <span style="color:red;">*</span> :</td>
										<td>
											<select name="print_type" class="print_type" required>
												<option value=''>--Print Type--</option>
										<?php if($print_type==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
										else{
											foreach($print_type as $print_type_row){
												$selected=($print_type_row->printing_group==$row->print_type?'selected':'');
												echo "<option value='".$print_type_row->printing_group."'  ".set_select('print_type',''.$print_type_row->printing_group.'').$selected.">".$print_type_row->printing_group."</option>";
															}
											}?>
											</select>
										</td>
									</tr>
								-->
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

									

									
									
									<tr>
										<td class="label">Special Ink <span style="color:red;">*</span> :</td>	 
										<td>  
											<select name="special_ink" id="special_ink" required>
												<option value="">--Select Special ink--</option>
												<option value="YES" <?php echo set_select('special_ink','YES');?> <?php echo($row->special_ink=='YES'?"selected":"");?>>YES</option>
												<option value="NO" <?php echo set_select('special_ink','NO');?> <?php echo($row->special_ink=='NO'?"selected":"");?> >NO</option>
											</select>							
										</td>
									</tr>

									


									
									
								</table>
							</fieldset>
						</td>
						</tr>


						<tr>
							<td colspan="4">
								<fieldset>
									<legend>Shoulder Specification:</legend>
								<table class="form_table_inner">

									<tr>
										<td class="label">Shoulder <span style="color:red;">*</span> :</td>
										<td><select name="shoulder" id="shoulder"><option value=''>--Select Shoulder--</option>
										

										<?php if($shoulder_types==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($shoulder_types as $shoulder_types_row){
													$selected=($shoulder_types_row->shld_type_id==$row->shoulder ? 'selected' : '');
													echo "<option value='".$shoulder_types_row->shoulder_type."//".$shoulder_types_row->shld_type_id."' $selected ".set_select('shoulder',''.$shoulder_types_row->shoulder_type.'//'.$shoulder_types_row->shld_type_id.'').">".$shoulder_types_row->shoulder_type."</option>";
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
													$selected=($shoulder_orifice_row->orifice_id==$row->shoulder_orifice ? 'selected' : '');
													echo "<option value='".$shoulder_orifice_row->shoulder_orifice."//".$shoulder_orifice_row->orifice_id."' $selected ".set_select('shoulder_orifice',''.$shoulder_orifice_row->shoulder_orifice.'//'.$shoulder_orifice_row->orifice_id.'').">".$shoulder_orifice_row->shoulder_orifice."</option>";
												}
										}?></select></td>
									</tr>
									

									<tr>
										<td class="label">Shoulder Color <span style="color:red;">*</span>  :</td>
										<td colspan="3"><input type="text" name="shoulder_color" id="shoulder_color" value="<?php echo set_value('shoulder_color',$row->shoulder_color);?>" required>
										</td>
									</tr>
								</table>
								</fieldset>
							</td>
				
						</tr>

						<tr>
							<td colspan="4">
								<fieldset>
									<legend>Cap  Specification:</legend>
								<table class="form_table_inner">

									<tr>
										<td class="label">Cap Type <span style="color:red;">*</span> :</td>
										<td>

											<select name="cap_type" id="cap_type" required><option value=''>--Select Cap Type--</option>
											

											<?php if($cap_type==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($cap_type as $cap_type_row){
													$selected=($cap_type_row->cap_type_id==$row->cap_type ? 'selected' : '');

													echo "<option value='".$cap_type_row->cap_type."//".$cap_type_row->cap_type_id."' $selected ".set_select('cap_type',''.$cap_type_row->cap_type.'//'.$cap_type_row->cap_type_id.'').">".$cap_type_row->cap_type."</option>";
												}
										}?>

											</select>
										</td>
									</tr>

									<tr>
										<td class="label">Cap Finish <span style="color:red;">*</span> :</td>
										<td>
											
											<select name="cap_finish" id="cap_finish" required>
												<option value="">--Select Cap Finish--</option>
												<?php if($cap_finish==FALSE){
																echo "<option value=''>--Setup Required--</option>";}
													else{
														foreach($cap_finish as $cap_finish_row){
															$selected=($cap_finish_row->cap_finish_id==$row->cap_finish? 'selected' : '');
															echo "<option value='".$cap_finish_row->cap_finish."//".$cap_finish_row->cap_finish_id."' $selected ".set_select('cap_finish',''.$cap_finish_row->cap_finish.'//'.$cap_finish_row->cap_finish_id.'').">".$cap_finish_row->cap_finish."</option>";
														}
												}?>
											</select>
										</td>	
										
									</tr>
									<tr>
										<td class="label">Cap Dia <span style="color:red;">*</span> :</td>
										<td><select name="cap_dia" id="cap_dia"><option value=''>--Select Cap Dia--</option>
										<?php if($cap_dia==FALSE){
															echo "<option value=''>--Setup Required--</option>";}
												else{
													foreach($cap_dia as $cap_dia_row){
														$selected=($cap_dia_row->cap_dia_id==$row->cap_dia ? 'selected' : '');
														echo "<option value='".$cap_dia_row->cap_dia."//".$cap_dia_row->cap_dia_id."' $selected ".set_select('cap_dia',''.$cap_dia_row->cap_dia.'//'.$cap_dia_row->cap_dia_id.'').">".$cap_dia_row->cap_dia."</option>";
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
													$selected=($cap_orifice_row->cap_orifice_id==$row->cap_orifice ? 'selected' : '');
													echo "<option value='".$cap_orifice_row->cap_orifice."//".$cap_orifice_row->cap_orifice_id."'  $selected ".set_select('cap_orifice',''.$cap_orifice_row->cap_orifice.'//'.$cap_orifice_row->cap_orifice_id.'').">".$cap_orifice_row->cap_orifice."</option>";
												}
										}?></select>
										</td>
									</tr>


									<tr>
										<td class="label">Cap Color <span style="color:red;">*</span>  :</td>
										<td colspan="3"><input type="text" name="cap_color" id="cap_color" value="<?php echo set_value('cap_color',$row->cap_color);?>" required>
										</td>
									</tr>
									
								</table>
								</fieldset>
							</td>
				
						</tr>

						<tr>
							<td colspan="4">
								<fieldset>
									<legend>Decorative Elements:</legend>
								<table class="form_table_inner">

									<tr>
										<td class="label">Tube Foil <span style="color:red;">*</span>:</td>
										<td colspan="3">
											<select name="tube_foil" id="tube_foil" required>
												<option value="">--Select Tube Foil--</option>
												<option value="YES" <?php echo set_select('tube_foil','YES');?> <?php echo($row->tube_foil=='YES'?"selected":"");?>>YES</option>
												<option value="NO" <?php echo set_select('tube_foil','NO');?> <?php echo($row->tube_foil=='NO'?"selected":"");?> >NO</option>
											</select>
										</td>
									</tr>

									<tr>
										<td class="label">Shoulder Foil <span style="color:red;">*</span>:</td>
										<td colspan="3">
											<select name="shoulder_foil" id="shoulder_foil" required>
												<option value="">--Select Tube Foil--</option>
												<option value="YES" <?php echo set_select('shoulder_foil','YES');?> <?php echo($row->shoulder_foil=='YES'?"selected":"");?>>YES</option>
												<option value="NO" <?php echo set_select('shoulder_foil','NO');?> <?php echo($row->shoulder_foil=='NO'?"selected":"");?>>NO</option>
											</select>
										</td>
									</tr>
									<!--
									<tr>
										<td class="label">Cap Foil <span style="color:red;">*</span> :</td>
										<td>							   
											<select name="cap_foil" id="cap_foil" required>
												<option value="">--Select Cap Foil--</option>
												<option value="YES" <?php echo set_select('cap_foil','YES');?> <?php echo($row->cap_foil=='YES'?"selected":"");?>>YES</option>
												<option value="NO" <?php echo set_select('cap_foil','NO');?> <?php echo($row->cap_foil=='NO'?"selected":"");?>>NO</option>
											</select>	
											
										</td>
									</tr>

									<tr>
										<td class="label">Cap Metalization <span style="color:red;">*</span> :</td>
										<td>									  
											<select name="cap_metalization" id="cap_metalization" required>
												<option value="">--Select Metalization--</option>
												<option value="YES" <?php echo set_select('cap_metalization','YES');?> <?php echo($row->cap_metalization=='YES'?"selected":"");?>>YES</option>
												<option value="NO" <?php echo set_select('cap_metalization','NO');?> <?php echo($row->cap_metalization=='NO'?"selected":"");?>>NO</option>
											</select>	
											
										</td>
									</tr>
								-->

									<tr>
										<td class="label">Cap Shirnk Sleeve <span style="color:red;">*</span> :</td>
										<td>
											<select name="cap_shrink_sleeve" id="cap_shrink_sleeve" required>
												<option value="">--Select Shrink Sleeve--</option>
												<option value="YES" <?php echo set_select('cap_shrink_sleeve','YES');?> <?php echo($row->cap_shrink_sleeve=='YES'?"selected":"");?>>YES</option>
												<option value="NO" <?php echo set_select('cap_shrink_sleeve','NO');?> <?php echo($row->cap_shrink_sleeve=='NO'?"selected":"");?> >NO</option>
											</select>
										</td>
									</tr>

									<!--//-----------------------CAP Metalizaion and Cap Foil CheckBox-->

									<?php
                    if($this->input->post('cap_metalization') &&  $this->input->post('cap_metalization')=='YES'){

                      echo '<tr>
                      <td class="label">Cap Metalization :</td>
                      <td><input type="checkbox" name="cap_metalization" id="cap_metalization" value="YES" '.set_checkbox('cap_metalization','YES').' '.($row->cap_metalization=='YES' ? 'value="YES" checked' : 'value="NO"').'/></td>
                    </tr>

                    <tr id="metalization_div">
                      <td></td><td>
                    Color : &nbsp;&nbsp;<select name="cap_metalization_color" id="cap_metalization_color">
                      <option value="">--Select--</option>
                      <option value="GOLD" "'.set_select('cap_metalization_color', 'GOLD').'">GOLD</option>
                      <option value="SILVER" "'.set_select('cap_metalization_color', 'SILVER').'">SILVER</option>
                      <option value="PINK" "'.set_select('cap_metalization_color', 'PINK').'">PINK</option>
                      <option value="CHAMPION" "'.set_select('cap_metalization_color', 'CHAMPION').'">CHAMPION</option>
                      <option value="WINE" "'.set_select('cap_metalization_color', 'WINE').'">WINE</option>
                      <option value="COPPER" "'.set_select('cap_metalization_color', 'COPPER').'">COPPER</option>
                      <option value="BELLISIMA" "'.set_select('cap_metalization_color', 'BELLISIMA').'">BELLISIMA</option>
                      
                      <option value="MAGENTA" "'.set_select('cap_metalization_color', 'MAGENTA').'">MAGENTA</option>
                      <option value="LIGHT PURPLE" "'.set_select('cap_metalization_color', 'LIGHT PURPLE').'">LIGHT PURPLE</option>
                      <option value="RHODAMINE RED" "'.set_select('cap_metalization_color', 'RHODAMINE RED').'">RHODAMINE RED</option>
                      <option value="ROSE GOLD" "'.set_select('cap_metalization_color', 'ROSE GOLD').'">ROSE GOLD</option>
                      <option value="SHINY GOLD" "'.set_select('cap_metalization_color', 'SHINY GOLD').'">SHINY GOLD</option>
                      <option value="COCO BROWN" "'.set_select('cap_metalization_color', 'COCO BROWN').'">COCO BROWN</option>

                    </select>


                    <br/>

                    Finish : <select name="cap_metalization_finish" id="cap_metalization_finish">
                      <option value="">--Select--</option>
                      <option value="GLOSS" "'.set_select('cap_metalization_finish', 'GLOSS').'">GLOSS</option>
                      <option value="MATT" "'.set_select('cap_metalization_finish', 'MATT').'">MATT</option>
                    </select>
                  </td>
                  </tr>';
                    }else{?>
							<tr>
								<td class="label">Cap Metalization :</td>
								<td><input type="checkbox" name="cap_metalization" id="cap_metalization" value="YES" <?php echo set_checkbox('cap_metalization','YES');?> <?php echo ($row->cap_metalization=='YES' ? 'value="YES" checked' : 'value="NO"');?> /></td>
							</tr>

							<tr id="metalization_div" <?php echo ($row->cap_metalization=='YES' ? '' : 'style="display: none"');?>>
								<td></td><td>
							Color : &nbsp;&nbsp;<select name="cap_metalization_color" id="cap_metalization_color">
                      <option value="">--Select--</option>
                      <option value='GOLD' <?php echo  set_select('cap_metalization_color', 'GOLD'); ?> <?php echo($row->cap_metalization_color=='GOLD'?"selected":"");?>>GOLD</option>
                      <option value='SILVER' <?php echo  set_select('cap_metalization_color', 'SILVER'); ?><?php echo($row->cap_metalization_color=='SILVER'?"selected":"");?>>SILVER</option>
                      <option value='PINK' <?php echo  set_select('cap_metalization_color', 'PINK'); ?><?php echo($row->cap_metalization_color=='PINK'?"selected":"");?>>PINK</option>
                      <option value='CHAMPION' <?php echo  set_select('cap_metalization_color', 'CHAMPION'); ?><?php echo($row->cap_metalization_color=='CHAMPION'?"selected":"");?>>CHAMPION</option>
                      <option value='WINE' <?php echo  set_select('cap_metalization_color', 'WINE'); ?> <?php echo($row->cap_metalization_color=='WINE'?"selected":"");?>>WINE</option>
                      <option value='COPPER' <?php echo  set_select('cap_metalization_color', 'COPPER'); ?> <?php echo($row->cap_metalization_color=='COPPER'?"selected":"");?>>COPPER</option>
                      <option value='BELLISIMA' <?php echo  set_select('cap_metalization_color', 'BELISIMA'); ?> <?php echo($row->cap_metalization_color=='BELLISIMA'?"selected":"");?>>BELLISIMA</option>
                      <option value='MAGENTA' <?php echo  set_select('cap_metalization_color', 'MAGENTA'); ?> <?php echo($row->cap_metalization_color=='MAGENTA'?"selected":"");?>>MAGENTA</option>
                      <option value='LIGHT PURPLE' <?php echo  set_select('cap_metalization_color', 'LIGHT PURPLE'); ?> <?php echo($row->cap_metalization_color=='LIGHT PURPLE'?"selected":"");?>>LIGHT PURPLE</option>
                      <option value='RHODAMINE RED' <?php echo  set_select('cap_metalization_color', 'RHODAMINE RED'); ?> <?php echo($row->cap_metalization_color=='RHODAMINE'?"selected":"");?>>RHODAMINE RED</option>
                      <option value='ROSE GOLD' <?php echo  set_select('cap_metalization_color', 'ROSE GOLD'); ?> <?php echo($row->cap_metalization_color=='ROSE GOLD'?"selected":"");?>>ROSE GOLD</option>
                      <option value='SHINY GOLD' <?php echo  set_select('cap_metalization_color', 'SHINY GOLD'); ?><?php echo($row->cap_metalization_color=='SHINY GOLD'?"selected":"");?>>SHINY GOLD</option>
                      <option value='COCO BROWN' <?php echo  set_select('cap_metalization_color', 'COCO BROWN'); ?><?php echo($row->cap_metalization_color=='COCO BROWN'?"selected":"");?>>COCO BROWN</option>
                    </select>

										<br/>

										Finish : &nbsp;<select name="cap_metalization_finish" id="cap_metalization_finish">
											<option value="">--Select--</option>
											<option value='GLOSS' <?php echo  set_select('cap_metalization_finish', 'GLOSS'); ?><?php echo($row->cap_metalization_finish=='GLOSS'?"selected":"");?> >GLOSS</option>
											<option value='MATT' <?php echo  set_select('cap_metalization_finish', 'MATT'); ?><?php echo($row->cap_metalization_finish=='MATT'?"selected":"");?>>MATT</option>
										</select>
									</td>
									</tr>


		                    <?php }
		                    ?>

										<tr>

									<?php
			                    if($this->input->post('cap_foil') &&  $this->input->post('cap_foil')=='YES'){

			                      echo '<tr>
			                      <td class="label">Cap Foil :</td>
			                      <td><input type="checkbox" name="cap_foil" id="cap_foil" value="YES" '.set_checkbox('cap_foil','YES').' '.($row->cap_foil=='YES' ? 'value="YES" checked' : 'value="NO"').'/></td>
			                    </tr>

			                    <tr id="foil_div">
			                      <td></td><td>
			                    Color : &nbsp;&nbsp;
			                    <input type="number" name="cap_foil_width" id="cap_foil_width" value="'.set_value('cap_foil_width').'">

			                    <br/>

			                    Cap Foil Dist From Bottom : &nbsp;
			                    <input type="number" min="0" max="20" step="any"  name="cap_foil_dist_frm_bottom" id="cap_foil_dist_frm_bottom" size="3" maxlength="3" value="'.set_value('cap_foil_dist_frm_bottom').'">
														
			                  </td>
			                  </tr>';
			                    }else{?>
										<tr>
											<td class="label">Cap Foil :</td>
											<td><input type="checkbox" name="cap_foil" id="cap_foil" value="YES" <?php echo set_checkbox('cap_foil','YES');?> <?php echo ($row->cap_foil=='YES' ? 'value="YES" checked' : 'value="NO"');?>/></td>
										</tr>

										<tr id="foil_div" <?php echo ($row->cap_foil=='YES' ? '' : 'style="display: none"');?>>
											<td></td><td>
										Cap Foil Width : &nbsp;&nbsp;
                    			 <input type="number" min="1" max="5" step="any" name="cap_foil_width" id="cap_foil_width" size="3" maxlength="3" value="<?php echo set_value('cap_foil_width',$row->cap_foil_width);?>">

										<br/>

										Cap Foil Dist From Bottom : &nbsp;
											<input type="number" min="0" max="20" step="any"  name="cap_foil_dist_frm_bottom" id="cap_foil_dist_frm_bottom" size="3" maxlength="3" value="<?php echo set_value('cap_foil_dist_frm_bottom',$row->cap_foil_dist_frm_bottom);?>">
									</td>
									</tr>


                    <?php }
                    ?>

									<tr>

									<!---------------------END --->	

									<tr>
										<td class="label">Label Price :</td>
										<td colspan="3"><input type="text" class="number" name="label_price"  id="label_price" size="5" maxlength="5" value="<?php echo set_value('label_price',$row->label_price);?>">
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
								<table>
									<tr>
										<th width="16%">Quote</th><th width="14%">Target Contr.</th><th width="14%">Quoted Contr.</th><th width="14%">Cost</th><th width="14%">Freight </th><th width="14%">Packaging  </th>
										<th width="14%">Quoted Price</th>
									</tr>
									<tr>
										<td class="label"> < 10K <span style="color:red;">*</span></td>

										<td ><input type="number" class="number1" name="less_than_10k_target_contr" id="less_than_10k_target_contr"   value="<?php echo set_value('less_than_10k_target_contr',$row->less_than_10k_target_contr);?>" required />
										</td>
										<td ><input type="number" class="number1" name="less_than_10k_quoted_contr" id="less_than_10k_quoted_contr"  value="<?php echo set_value('less_than_10k_quoted_contr',$row->less_than_10k_quoted_contr);?>" required/>
										</td>
										<td><input type="number" class="number1" name="less_than_10k_cost" id="less_than_10k_cost"  value="<?php echo set_value('less_than_10k_cost',$row->less_than_10k_cost);?>" required/>
										</td>

										<td><input type="number" class="number1" name="less_than_10k_freight" id="less_than_10k_freight"  value="<?php echo set_value('less_than_10k_freight',$row->less_than_10k_freight);?>" required/>
										</td>

										<td><input type="number" class="number1" name="less_than_10k_packing" id="less_than_10k_packing"  value="<?php echo set_value('less_than_10k_packing',$row->less_than_10k_packing);?>" required/>
										</td>


										<td> <input type="number" class="number1" name="less_than_10k_quoted_price" id="less_than_10k_quoted_price"  value="<?php echo set_value('less_than_10k_quoted_price',$row->less_than_10k_quoted_price);?>" required/>
										</td>
									</tr>
									<tr>
										<td class="label" width="17%">10K - 25K <span style="color:red;">*</span></td>
										<td><input type="number" class="number1" name="_10k_to_25k_target_contr" id="_10k_to_25k_target_contr"  value="<?php echo set_value('_10k_to_25k_target_contr',$row->_10k_to_25k_target_contr);?>" required />
										</td>
										<td><input type="number" class="number1" name="_10k_to_25k_quoted_contr" id="_10k_to_25k_quoted_contr"  value="<?php echo set_value('_10k_to_25k_quoted_contr',$row->_10k_to_25k_quoted_contr);?>" required/>
										</td>
										<td><input type="number" class="number1" name="_10k_to_25k_cost" id="_10k_to_25k_cost"  value="<?php echo set_value('_10k_to_25k_cost',$row->_10k_to_25k_cost);?>" required/>
										</td>

										<td><input type="number" class="number1" name="_10k_to_25k_freight" id="_10k_to_25k_freight"  value="<?php echo set_value('_10k_to_25k_freight',$row->_10k_to_25k_freight);?>" required/>
										</td>

										<td><input type="number" class="number1" name="_10k_to_25k_packing" id="_10k_to_25k_packing"  value="<?php echo set_value('_10k_to_25k_packing',$row->_10k_to_25k_packing);?>" required/>
										</td>

										<td><input type="number" class="number1" name="_10k_to_25k_quoted_price" id="_10k_to_25k_quoted_price"  value="<?php echo set_value('_10k_to_25k_quoted_price',$row->_10k_to_25k_quoted_price);?>" required/>
										</td>
									</tr>
									<tr>
										<td class="label">25K - 50K <span style="color:red;">*</span></td>
										<td><input type="number" class="number1" name="_25k_to_50k_target_contr" id="_25k_to_50k_target_contr"  value="<?php echo set_value('_25k_to_50k_target_contr',$row->_25k_to_50k_target_contr);?>"required />
										</td>
										<td><input type="number" class="number1" name="_25k_to_50k_quoted_contr" id="_25k_to_50k_quoted_contr"  value="<?php echo set_value('_25k_to_50k_quoted_contr',$row->_25k_to_50k_quoted_contr);?>" required/>
										</td>
										<td><input type="number" class="number1" name="_25k_to_50k_cost" id="_25k_to_50k_cost"  value="<?php echo set_value('_25k_to_50k_cost',$row->_10k_to_25k_cost);?>" required/>
										</td>

										<td><input type="number" class="number1" name="_25k_to_50k_freight" id="_25k_to_50k_freight"  value="<?php echo set_value('_25k_to_50k_freight',$row->_25k_to_50k_freight);?>" required/>
										</td>

										<td><input type="number" class="number1" name="_25k_to_50k_packing" id="_25k_to_50k_packing"  value="<?php echo set_value('_25k_to_50k_packing',$row->_25k_to_50k_packing);?>" required/>
										</td>

										<td><input type="number" class="number1" name="_25k_to_50k_quoted_price" id="_25k_to_50k_quoted_price"  value="<?php echo set_value('_25k_to_50k_quoted_price',$row->_10k_to_25k_quoted_price);?>" required/>
										</td>
									</tr>
									<tr>
										<td class="label">50K - 100K <span style="color:red;">*</span></td>
										<td><input type="number" class="number1" name="_50k_to_100k_target_contr" id="_50k_to_100k_target_contr"  value="<?php echo set_value('_50k_to_100k_target_contr',$row->_50k_to_100k_target_contr);?>" required/>
										</td>
										<td><input type="number" class="number1" name="_50k_to_100k_quoted_contr" id="_50k_to_100k_quoted_contr"  value="<?php echo set_value('_50k_to_100k_quoted_contr',$row->_50k_to_100k_quoted_contr);?>" required />
										</td>
										<td><input type="number" class="number1" name="_50k_to_100k_cost" id="_50k_to_100k_cost"  value="<?php echo set_value('_50k_to_100k_cost',$row->_50k_to_100k_cost);?>" required />
										</td>

										<td><input type="number" class="number1" name="_50k_to_100k_freight" id="_50k_to_100k_freight"  value="<?php echo set_value('_50k_to_100k_freight',$row->_50k_to_100k_freight);?>" required/>
										</td>

										<td><input type="number" class="number1" name="_50k_to_100k_packing" id="_50k_to_100k_packing"  value="<?php echo set_value('_50k_to_100k_packing',$row->_50k_to_100k_packing);?>" required/>
										</td>
										<td><input type="number" class="number1" name="_50k_to_100k_quoted_price" id="_50k_to_100k_quoted_price"  value="<?php echo set_value('_50k_to_100k_quoted_price',$row->_50k_to_100k_quoted_price);?>" required/>
										</td>
									</tr>
									<tr>
										<td class="label">100K -250K <span style="color:red;">*</span></td>
										<td><input type="number" class="number1" name="_100k_to_250k_target_contr" id="_100k_to_250k_target_contr"  value="<?php echo set_value('_100k_to_250k_target_contr',$row->_100k_to_250k_target_contr);?>" required/>
										</td>
										<td><input type="number" class="number1" name="_100k_to_250k_quoted_contr" id="_100k_to_250k_quoted_contr"  value="<?php echo set_value('_100k_to_250k_quoted_contr',$row->_100k_to_250k_quoted_contr);?>" required/>
										</td>
										<td><input type="number" class="number1" name="_100k_to_250k_cost" id="_100k_to_250k_cost"  value="<?php echo set_value('_100k_to_250k_cost',$row->_100k_to_250k_cost);?>" required/>
										</td>

										<td><input type="number" class="number1" name="_100k_to_250k_freight" id="_100k_to_250k_freight"  value="<?php echo set_value('_100k_to_250k_freight',$row->_100k_to_250k_freight);?>" required/>
										</td>

										<td><input type="number" class="number1" name="_100k_to_250k_packing" id="_100k_to_250k_packing"  value="<?php echo set_value('_100k_to_250k_packing',$row->_100k_to_250k_packing);?>" required/>
										</td>
										<td><input type="number" class="number1" name="_100k_to_250k_quoted_price" id="_100k_to_250k_quoted_price"  value="<?php echo set_value('_100k_to_250k_quoted_price',$row->_100k_to_250k_quoted_price);?>" required />
										</td>
									</tr>
									<tr>
										<td class="label">>250K <span style="color:red;">*</span></td>
										<td><input type="number" class="number1" name="greater_than_250k_target_contr" id="greater_than_250k_target_contr"  value="<?php echo set_value('greater_than_250k_target_contr',$row->greater_than_250k_target_contr);?>" />
										</td>
										<td><input type="number" class="number1" name="greater_than_250k_quoted_contr" id="greater_than_250k_quoted_contr"  value="<?php echo set_value('greater_than_250k_quoted_contr',$row->greater_than_250k_quoted_contr);?>" required/>
										</td>
										<td><input type="number" class="number1" name="greater_than_250k_cost" id="greater_than_250k_cost"  value="<?php echo set_value('greater_than_250k_cost',$row->greater_than_250k_cost);?>" required/>
										</td>

										<td><input type="number" class="number1" name="greater_than_250k_freight" id="greater_than_250k_freight"  value="<?php echo set_value('greater_than_250k_freight',$row->greater_than_250k_freight);?>" required/>
										</td>

										<td><input type="number" class="number1" name="greater_than_250k_packing" id="greater_than_250k_packing"  value="<?php echo set_value('greater_than_250k_packing',$row->greater_than_250k_packing);?>" required/>
										</td>
										<td><input type="number" class="number1" name="greater_than_250k_quoted_price" id="greater_than_250k_quoted_price"  value="<?php echo set_value('greater_than_250k_quoted_price',$row->greater_than_250k_quoted_price);?>" required />
										</td>
									</tr>

								</table>
							</fieldset>
							</td>
						</tr>
						


						<!-- Customer Price Range -->
						
						<!-- Cost sheet details -->
						<tr>
							<td colspan="4">						
								<fieldset>
									<LEGEND> Cost Taken Based On:</LEGEND>
									<table>		
										
										<tr>
											<td class="label">Invoice no :</td>
											<td colspan="3"><input type="text" name="invoice_no" id="invoice_no"  value="<?php echo set_value('invoice_no',$row->invoice_no);?>" />
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
											<td class="label" width="27%">Remarks  :</td>
											<td colspan="3">
												<textarea name="remarks" id="remarks" cols="50" rows="5" value="<?php echo trim(set_value('remarks'));?>" maxlength="512"><?php echo trim(set_value('remarks',$row->remarks));?></textarea>
											</td>
										</tr>
										<tr>
											<td class="label">Approval Authority :</td>
											<td><select name="approval_authority">
												<option value=''>--Select Authority--</option>
												<?php 
													foreach ($approval_authority as $approval_authority_row) {
													echo "<option value='".$approval_authority_row->employee_id."' ".set_select('approval_authority',$approval_authority_row->employee_id).">".strtoupper($approval_authority_row->username)."</option>";
													}
												?>
											</select></td>
									</tr>									
									</table>
								</fieldset>	
							</td>							
						</tr>

					</table>
				</td>							
			</tr>
		</table>
		<?php endforeach;?>		
					
	</div>
	<div class="form_design">
		<div class="ui buttons">
	  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui positive button" onClick="return confirm('Are you sure to update Record?');">Update</button>
		</div>
	</div>	
</form>
				
				
				
			