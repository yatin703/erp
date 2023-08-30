<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){

		//$(document).attr("title", "<?php echo strtoupper($this->router->fetch_class());?>");

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


<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result');?>" id="form1" method="POST" >

	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td width="55%">
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
										<td colspan="3" ><input type="text" name="adr_company_id" id="adr_company_id"  size="65" value="<?php echo set_value('adr_company_id');?>" /></td>
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
										<td colspan="3"><input type="text" name="article_no" id="article_no"  size="65" value="<?php echo set_value('article_no');?>" /></td>
									</tr>
									<tr>
										<td class="label">Customer Po No.  :</td>
										<td><input type="text" name="cust_order_no" id="cust_order_no" size="17" value="<?php echo set_value('cust_order_no');?>"/></td>
										<td class="label">Customer Po Date  :</td>
										<td><input type="date" name="cust_order_date" id="cust_order_date" size="17" value="<?php echo set_value('cust_order_date');?>"/></td>
									</tr>	
									<tr>
										<td class="label">Saler Order  :</td>
										<td  >

											<?php
											/*
											if($this->input->post('next_order_no')){
												
												echo '<input type="text" name="order_no" id="order_no" size="17" value="'.$this->input->post('next_order_no').'"/>';
											}else if($this->input->post('prev_order_no')){
												echo '<input type="text" name="order_no" id="order_no" size="17" value="'.$this->input->post('prev_order_no').'"/>';
											}else{*/
												echo '<input type="text" name="order_no" id="order_no" size="17" value="'.set_value('order_no').'"/>';
											/*}*/
											?>
											
										</td>
										<td class="label">Hold/Unhold  :</td>
										<td >
											<select name="hold_flag" id="hold_flag" >
												<option value="">--Please Select--</option>
												<option value="0" <?php echo set_select('hold_flag','0');?>>Unhold</option>
												<option value="1" <?php echo set_select('hold_flag','1');?> >Hold</option>
												
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
									
									 
					</table>			
								
				</td>
				<td width="45%">
					<table class="form_table_inner">									
									<tr>
										<td class="label"> Domestic/Export  :</td>
										<td colspan="3">
											<select name="for_export" id="for_export" >

												<option value="">--Please Select--</option>
												<option value="0" <?php echo set_select('for_export','0');?>>Domestic</option>
												<option value="1" <?php echo set_select('for_export','1');?> >Export</option>
												
											</select>

										</td>
									</tr>
									<tr>
										<td class="label">Order Type  :</td>
										<td colspan="3">
											<select name="order_flag" id="" >

												<option value="">--Please Select--</option>
												<option value="0" <?php echo set_select('order_flag','0');?>>Coex</option>
												<option value="1" <?php echo set_select('order_flag','1');?> >Spring</option>
												<option value="3" <?php echo set_select('order_flag','3');?> >Other</option>
												
											</select>

										</td>
									</tr>
									<tr>
										<td class="label" > For Stock  :</td>
										<td colspan="3">
											<select name="for_stock" id="for_stock" >

												<option value="">--Please Select--</option>
												<option value="1" <?php echo set_select('for_stock','1');?>>Yes</option>
												<option value="0" <?php echo set_select('for_stock','0');?> >No</option>												
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
										<td class="label"> Approval Status  :</td>
										<td colspan="3">
											<select name="final_approval_flag" id="final_approval_flag" >
												<option value="">--Please Select--</option>
												<option value="1" <?php echo set_select('final_approval_flag','1'); ?> >Approved</option>
												<option value="0" <?php echo set_select('final_approval_flag','0'); ?>>Not Approved</option>
											</select>
										</td>
									</tr>
									</tr>
										<tr>
										<td class="label"> Order Status  :</td>
										<td colspan="3">
											<select name="order_closed[]" id="order_closed[]" multiple >
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
										<td class="label">Created By :</td>
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

							
			</tr>
		</table>					
	</div>

	<div class="form_design">
		<div class="ui buttons">
	  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui positive button" onClick="return validate_form(); ">Search</button>
		</div>
	</div>

	



		
</form>

		
				
				
				
			