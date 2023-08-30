<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		$("#adr_company_id").autocomplete("<?php echo base_url('index.php/ajax/customer');?>", {selectFirst: true});
		//$("#consin_adr_company_id").autocomplete("<?php echo base_url('index.php/ajax/customer');?>", {selectFirst: true});

		$("#customer_category").autocomplete("<?php echo base_url('index.php/ajax/customer_category_autocomplete');?>", {selectFirst: true});

		$("#article_no").autocomplete("<?php echo base_url('index.php/ajax/article_no');?>", {selectFirst: true});
		$("#ar_invoice_no").autocomplete("<?php echo base_url('index.php/ajax/ar_invoice_no');?>", {selectFirst: true});
		$("#order_no").autocomplete("<?php echo base_url('index.php/ajax/so_no');?>", {selectFirst: true});

		$("#adr_company_id").live('keyup',function(){
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/ship_to');?>",data: {adr_company_id : $("#adr_company_id").val()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#consin_adr_company_id").html(html);
				} 
			});
		});

	});

</script>


<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/index_result');?>" method="POST" >

	<div class="form_design">

	<div class="ui teal labels" style="text-align: center;">
      <div class="ui label">COST/TUBE Report</div>
    </div>
    <br/>

		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">
									<tr>
										<td class="label" width="25%">From Date  <span style="color:red;">*</span> :</td>
										<td width="25%"><input type="date" name="from_date" id="from_date" value="<?php echo set_value('from_date',date('Y-m-d'));?>"/></td>
										<td class="label" width="25%">To Date <span style="color:red;">*</span> :</td>
										<td width="25%"><input type="date" name="to_date" id="to_date" value="<?php echo set_value('to_date',date('Y-m-d'));?>"/></td>
									</tr>

									<tr>
										<td class="label">Customer :</td>
										<td colspan="3" ><input type="text" name="customer_category" id="customer_category" size="40" value="<?php echo set_value('customer_category');?>"/></td>
									</tr>
									

									<tr>
										<td class="label">Product Name  :</td>
										<td colspan="3"><input type="text" name="article_no" id="article_no"  size="40" value="<?php echo set_value('article_no');?>" /></td>
									</tr>

									
									

									<tr>
										<td class="label">Sales Order No  :</td>
										<td colspan="3"><input type="text" name="order_no" id="order_no" size="17" value="<?php echo set_value('order_no');?>"/></td>
									</tr>
									

									<tr>
										<td class="label">Invoice No  :</td>
										<td colspan="3"><input type="text" name="invoice_no" id="ar_invoice_no" size="17" value="<?php echo set_value('invoice_no');?>"/></td>
									</tr>

									<tr>
										<td class="label">Order Type :</td>
										<td colspan="3">
											<select name="order_flag">
												<option value=''>--Select Order Type--</option>
											<option value='0' <?php echo set_select('order_flag','0');?>>Coex</option>
											<option value='1' <?php echo set_select('order_flag','1');?>>Spring Tube</option>
											<option value='4' <?php echo set_select('order_flag','4');?>>Pbl Tube</option>		
											</select>
										</td>
									</tr>

									<tr>
										<td class="label">Completed/Partial Dispatch :</td>
										<td colspan="3">
											<select name="status_flag">
												<option value=''>--Select Order Type--</option>
											<option value="1" <?php echo set_select('status_flag','1');?>>Completed</option>
											<option value="0" <?php echo set_select('status_flag','0');?>>Partial Dispatch</option>
											</select>
										</td>
									</tr>

									<tr>
										<td class="label">Status :</td>
										<td colspan="3">
											<select name="status">
												<option value=''>--Select--</option>
											<option value='Completed' <?php echo set_select('status','Completed');?>>Completed</option>
											<option value='Partial' <?php echo set_select('status','Partial');?>>Partial Dispatch</option>
											<option value='Short Closed' <?php echo set_select('status','Short Closed');?>>Short Closed</option>
											<option value='Manual Closed' <?php echo set_select('status','Manual Closed');?>>Manual Closed</option>		
											</select>
										</td>
									</tr>	

									<tr>
										<td class="label">Sort By Contrubution % :</td>
										<td colspan="3">
											<select name="sort_by">
												<option value=''>--Select--</option>
											<option value='con_percentage>=51' <?php echo set_select('sort_by','con_percentage>=50');?>>Above 50%</option>
											<option value='con_percentage<=50' <?php echo set_select('sort_by','con_percentage<=50');?>>Below 50%</option>
											<option value='con_percentage<=80' <?php echo set_select('sort_by','con_percentage<=80');?>>Less than 80%</option>		
											</select>
										</td>
									</tr>
									
									
					</table>			
								
				</td>
				<td width="50%">
					<table class="form_table_inner">

						

						<tr>
								<td class="label">Dia :</td>
								<td colspan="3"><select name="sleeve_dia"><option value=''>--Select Dia--</option>
								<?php if($sleeve_dia==FALSE){
												echo "<option value=''>--Setup Required--</option>";}
									else{
										foreach($sleeve_dia as $sleeve_dia_row){
											echo "<option value='".$sleeve_dia_row->sleeve_diameter."'  ".set_select('sleeve_dia',''.$sleeve_dia_row->sleeve_diameter.'').">".$sleeve_dia_row->sleeve_diameter."</option>";
										}
								}?>
								</select>
							Length From : <input type="text" name="sleeve_length_from" size="05" value="<?php echo set_value('sleeve_length_from');?>">

							Length To : <input type="text" name="sleeve_length_to" size="05" value="<?php echo set_value('sleeve_length_to');?>"></td>
							
								
						</tr>
						<tr>	
								<td class="label">Layer :</td>
								<td>
									<select name="layer" id="layer" >
										<option value="">--Select Layer--</option>							 
										<option value="1" <?php echo set_select('layer',1);?> >1</option>
										<option value="2" <?php echo set_select('layer',2);?> >2</option>
										<option value="3" <?php echo set_select('layer',3);?> >3</option>
										
										<option value="5" <?php echo set_select('layer',5);?> >5</option>
										
										<option value="7" <?php echo set_select('layer',7);?> >7</option>
										
									</select>
								

								Order By : 
								<select name="filter_by" >
										<option value="">--Select Order BY--</option>							 
										<option value="DIA" <?php echo set_select('filter_by','DIA');?> >DIA</option>
										<option value="LENGTH" <?php echo set_select('filter_by','LENGTH');?> >LENGTH</option>							
								</select>
								</td>
						</tr>

						<tr>
							<td class="label">Print Type :</td>
							<td colspan="3"><select name="print_type"><option value=''>--Select Print Type--</option>
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
							<td class="label">Shoulder Types :</td>
							<td><select name="shoulder_type" id="shoulder_type"><option value=''>--Select Shoulder--</option>
							<?php if($shoulder_types==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach($shoulder_types as $shoulder_types_row){
										echo "<option value='".$shoulder_types_row->shoulder_type."//".$shoulder_types_row->shld_type_id."'  ".set_select('shoulder_type',''.$shoulder_types_row->shoulder_type.'//'.$shoulder_types_row->shld_type_id.'').">".$shoulder_types_row->shoulder_type."</option>";
									}
							}?>
							</select></td>
						</tr>

						<tr>
							<td class="label">Cap Type  :</td>
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
							<td class="label">Cap Finish  :</td>
							<td>
								<select name="cap_finish" id="cap_finish">
									<option value="">--Select Cap Finish--</option>
									<option value="GLOSS" <?php echo set_select('cap_finish','GLOSS');?> >GLOSS</option>
									<option value="MATT" <?php echo set_select('cap_finish','MATT');?> >MATT</option>
								</select>
							</td>	
						</tr>
						
						

						<tr>
							<td class="label">Shoulder Foil  :</td>
							<td colspan="3">
								<select name="shoulder_foil" id="shoulder_foil" >
									<option value="">--Select Tube Foil--</option>
									<option value="YES" <?php echo set_select('shoulder_foil','YES');?> >YES</option>
									<option value="NO" <?php echo set_select('shoulder_foil','NO');?> >NO</option>
								</select>
							</td>
						</tr>

						<tr>
							<td class="label">Cap Foil  :</td>
							<td>							   
								<select name="cap_foil" id="cap_foil" >
									<option value="">--Select Cap Foil--</option>
									<option value="YES" <?php echo set_select('cap_foil','YES');?> >YES</option>
									<option value="NO" <?php echo set_select('cap_foil','NO');?> >NO</option>
								</select>	
								
							</td>
						</tr>
						<tr>
							<td class="label">Cap Metalization  :</td>
							<td>									  
								<select name="cap_metalization" id="cap_metalization" >
									<option value="">--Select Metalization--</option>
									<option value="YES" <?php echo set_select('cap_metalization','YES');?> >YES</option>
									<option value="NO" <?php echo set_select('cap_metalization','NO');?> >NO</option>
								</select>	
								
							</td>
						</tr>

						<tr>
							<td class="label">Cap Shirnk Sleeve  :</td>
							<td>
								<select name="cap_shrink_sleeve" id="cap_shrink_sleeve" >
									<option value="">--Select Shrink Sleeve--</option>
									<option value="YES" <?php echo set_select('cap_shrink_sleeve','YES');?> >YES</option>
									<option value="NO" <?php echo set_select('cap_shrink_sleeve','NO');?> >NO</option>
								</select>
							</td>
						</tr>

						<tr>
							<td class="label">Tube Foil :</td>
							<td colspan="3">
								<select name="tube_foil_1" id="tube_foil_1" >
									<option value="">--Select Tube Foil--</option>
									<option value="YES" <?php echo set_select('tube_foil','YES');?> >YES</option>
									<option value="NO" <?php echo set_select('tube_foil','NO');?> >NO</option>
								</select>
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
	  		<button class="ui positive button">Search</button>
		</div>
	</div>
		
</form>
				
				
				
				
				
			