<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		$("#adr_company_id").autocomplete("<?php echo base_url('index.php/ajax/customer');?>", {selectFirst: true});
		//$("#consin_adr_company_id").autocomplete("<?php echo base_url('index.php/ajax/customer');?>", {selectFirst: true});
		$("#article_no").autocomplete("<?php echo base_url('index.php/ajax/article_no');?>", {selectFirst: true});
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


<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result_planning');?>" method="POST" >

	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
		<table class="form_table_design">
			<tr>
				<td width="50%">

					<table class="form_table_inner">

									<?php foreach ($account_periods_master as $account_periods_master_row ):?>
									<tr>
										<td class="label" >From Date <span style="color:red;">*</span>  :</td>
										<td><input type="date" name="from_date" id="from_date" value="<?php echo set_value('from_date',$account_periods_master_row->fin_year_start);?>"/></td>
										<td class="label" >To Date <span style="color:red;">*</span>  :</td>
										<td><input type="date" name="to_date" id="to_date" value="<?php echo set_value('to_date',date('Y-m-d'));?>"/></td>
									</tr>
									<?php endforeach;?>
																		
									<tr>
										<td class="label">Bill To   :</td>
										<td colspan="3"><input type="text" name="adr_company_id" id="adr_company_id"  size="60" value="<?php echo set_value('adr_company_id');?>" /></td>
									</tr>
									<tr>
										<td class="label">Ship To   :</td>
										<td colspan="3">
											<select name="consin_adr_company_id" id="consin_adr_company_id">
												<option value=''>--Same As Bill To--</option>
												<?php
													foreach ($ship_to as $ship_to_row){
										           	 	echo "<option value='".$ship_to_row->related_company_id."' ".set_select('consin_adr_company_id',''.$ship_to_row->related_company_id.'').">".$ship_to_row->relate."//".$ship_to_row->related_company_id."//".$ship_to_row->lang_property_name."</option>";
										        	}
										          ?>
											</select>
										</td>
									</tr>
									<tr>
										<td class="label">Article   :</td>
										<td colspan="3"><input type="text" name="article_no" id="article_no"  size="60" value="<?php echo set_value('article_no');?>" /></td>
									</tr>

									<tr>
										<td class="label">Saler Order  :</td>
										<td colspan="3"><input type="text" name="order_no" id="order_no" size="17" value="<?php echo set_value('order_no');?>"/></td>
									</tr>
									<tr>
										<td class="label"> Order Type  :</td>
										<td colspan="3">
											<select name="for_export" id="for_export" >

												<option value="">--Please Select--</option>
												<option value="0" <?php echo set_select('for_export','0');?>>Local</option>
												<option value="1" <?php echo set_select('for_export','1');?> >Export</option>
												
											</select>

										</td>
									</tr>
									<tr>
										<td class="label" > For Sample  :</td>
										<td colspan="3">
											<select name="for_sampling" id="for_sampling" >

												<option value="">--Please Select--</option>
												<option value="1" <?php echo set_select('for_sampling','1');?>>Yes</option>
												<option value="0" <?php echo set_select('for_sampling','0');?> >No</option>
												
											</select>

										</td>
									</tr>
									<tr>
										<td class="label"> Approval Status :</td>
										<td colspan="3">
											<select name="final_approval_flag" id="final_approval_flag" >
												<option value="">--Please Select--</option>
												<option value="1" <?php echo set_select('final_approval_flag','1'); ?> >Approved</option>
												<option value="0" <?php echo set_select('final_approval_flag','0'); ?>>Not Approved</option>
											</select>

										</td>
									</tr>
									<tr>
										<td class="label">Approval From Date  :</td>
										<td><input type="date" name="approval_from_date" id="approval_from_date" size="17" value="<?php echo set_value('approval_from_date');?>"/></td>
										<td class="label">Approval To Date  :</td>
										<td><input type="date" name="approval_to_date" id="approval_to_date" size="17" value="<?php echo set_value('approval_to_date');?>"/></td>
									</tr>

									<tr>
										<td class="label">Delivery From Date  :</td>
										<td><input type="date" name="delivery_from_date" id="delivery_from_date" size="17" value="<?php echo set_value('delivery_from_date');?>"/></td>
										<td class="label">Delivery To Date  :</td>
										<td><input type="date" name="delivery_to_date" id="delivery_to_date" size="17" value="<?php echo set_value('delivery_to_date');?>"/></td>
									</tr>						

									<tr>
										<td class="label"> Sort By  :</td>
										<td colspan="3">
											<select name="order_by" id="order_by" >
												<option value="">--Please Select--</option>
												<option value="order_details.total_order_quantity" <?php echo set_select('order_by','order_details.total_order_quantity'); ?> >By Order Quantity</option>
												<option value="order_master.total_value" <?php echo set_select('order_by','order_master.total_value'); ?>>By Order Value</option>
												<option value="order_details.selling_price" <?php echo set_select('order_by','order_details.selling_price'); ?>>By Unit Rate</option>
											</select>

										</td>
									</tr>
									<tr>
										<td class="label">Created by  :</td>
										<td colspan="3"><select name="user_id" id="user_id">
											<option value=''>--Select User--</option>
											<?php 
											foreach ($user_master as $user_master_row) {
							             echo "<option value='".$user_master_row->user_id."' ".set_select('user_id',$user_master_row->user_id).">".strtoupper($user_master_row->login_name)."</option>";
							             }
							             ?>
							            </select></td>
							        </tr>							


									
					</table>			
								
				</td>
				<td width="50%">
					<table class="form_table_inner">
									<tr>
										<td class="label"> Order Status  :</td>
										<td colspan="3">
											<select name="order_closed" id="order_closed" >
												<option value="">--Please Select--</option>
												<option value="0" <?php echo set_select('order_closed','0'); ?> >Open</option>
												<option value="1" <?php echo set_select('order_closed','1'); ?>> Completed</option>
												<option value="2" <?php echo set_select('order_closed','2'); ?>>Partially Completed</option>
																							
											</select>

										</td>
									</tr>
									
									<tr>
										<td class="label"> Transaction Status  :</td>
										<td colspan="3">
											<select name="trans_closed" id="trans_closed" >

												<option value="">--Please Select--</option>
												<option value="0" <?php echo set_select('trans_closed','0');?>>Open</option>
												<option value="1" <?php echo set_select('trans_closed','1');?> >Closed</option>
												

												
											</select>

										</td>
									</tr>
									
									<tr>
										<td class="label">Sleeve Diameter   :</td>
										<td><select name="sleeve_diameter" id="sleeve_diameter">
											<option value=''>--Please Select--</option>
										<?php if($sleeve_diameter_master==FALSE){
														echo "<option value=''>--Sleeve Dia Setup Required--</option>";}
											else{
												foreach($sleeve_diameter_master as $row){
													
													echo '<option value="'.$row->sleeve_diameter.'"'.set_select('sleeve_diameter',''.$row->sleeve_diameter.'').' >'.$row->sleeve_diameter.'</option>';
												}
										}?>
										</select></td>
									</tr>
									<tr>
										<td class="label">Sleeve Print Type   :</td>
										<td><select name="sleeve_print_type" id="sleeve_print_type">
											<option value=''>--Please Select--</option>
										<?php if($lacquer_types_master==FALSE){
														echo "<option value=''>--Sleeve Print Type Required--</option>";}
											else{
												foreach($lacquer_types_master as $row){
													
													echo '<option value="'.$row->lacquer_type.'"'.set_select('lacquer_type',''.$row->lacquer_type.'').' >'.$row->lacquer_type.'</option>';
												}
										}?>
										</select></td>
									</tr>
									<tr>	
										<td class="label">Shoulder Type  :</td>
										<td><select name="shoulder_type" id="shoulder_type">
											<option value=''>--Please Select--</option>
										<?php if($shoulder_types_master==FALSE){
													echo "<option value=''>--Shoulder Type Setup Required--</option>";}
											else{
												foreach($shoulder_types_master as $row){
													
													echo '<option value="'.$row->shoulder_type.'"'.set_select('shoulder_type',''.$row->shoulder_type.'').' >'.$row->shoulder_type.'</option>';
												}
										}?>
										</select></td>
									</tr>
									<tr>	
										<td class="label">Shoulder Orifice  :</td>
										<td><select name="shoulder_orifice" id="shoulder_orifice">
											<option value=''>--Please Select--</option>
										<?php if($shoulder_orifice_master==FALSE){
													echo "<option value=''>--Shoulder Orifice Setup Required--</option>";}
											else{
												foreach($shoulder_orifice_master as $row){
													
													echo '<option value="'.$row->shoulder_orifice.'"'.set_select('shoulder_orifice',''.$row->shoulder_orifice.'').' >'.$row->shoulder_orifice.'</option>';
												}
										}?>
										</select></td>
									</tr>
									
									<tr>	
										<td class="label">Cap Orifice  :</td>
										<td><select name="cap_orifice" id="cap_orifice">
											<option value=''>--Please Select--</option>
										<?php if($cap_orifice_master==FALSE){
													echo "<option value=''>--Cap Orifice Setup Required--</option>";}
											else{
												foreach($cap_orifice_master as $row){
													
													echo '<option value="'.$row->cap_orifice.'"'.set_select('cap_orifice',''.$row->cap_orifice.'').' >'.$row->cap_orifice.'</option>';
												}
										}?>
										</select></td>
									</tr>
									<tr>	
										<td class="label">Cap Finish  :</td>
										<td><select name="cap_finish" id="cap_finish">
											<option value=''>--Please Select--</option>
										<?php if($cap_finish_master==FALSE){
													echo "<option value=''>--Cap Finish Setup Required--</option>";}
											else{
												foreach($cap_finish_master as $row){
													
													echo '<option value="'.$row->cap_finish.'"'.set_select('cap_finish',''.$row->cap_finish.'').' >'.$row->cap_finish.'</option>';
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
	  		<button class="ui positive button">Search</button>
		</div>
	</div>
		
</form>
				
				
				
				
				
			