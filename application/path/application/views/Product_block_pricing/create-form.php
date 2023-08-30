<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		$("#article_no").autocomplete("<?php echo base_url('index.php/ajax/article_no');?>", {selectFirst: true});

		$("#article_no").live('keyup',function() {
	   	var article_no = $('#article_no').val();
	   	$("#loading").show();
		$("#cover").show();
		$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
		   $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/product_block_pricing_version_no",data: {article_no : $('#article_no').val()},cache: false,success: function(html){
		    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
		       $("#version_no").html(html);
		    } 
		    });
		   });

		$("#currency").change(function(event) {
		   var currency = $('#currency').val().split("|")[0];
		   
		   var country=$('#currency').val().split("|")[1];
		   
		   $("#loading").show();
					$("#cover").show();
					$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
		    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/currency_rate",data: { currency : currency},cache: false,success: function(html){
		    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
		       $("#exchange_rate").html(html);
		    } 
		    });
		  });


		});
</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td width='50%'>
					<table class="form_table_inner">
						<!--
						<tr>
							<td class="label">Product  * :</td>
							<td><input type="text" name="article_no" id="article_no"  size="60" value="<?php echo set_value('article_no');?>" required /></td>
						</tr>-->

						<tr>
							<td class="label">Price List Name * :</td>
							<td><input type="text" name="price_list_name"  size="60" value="<?php echo set_value('price_list_name');?>" required /></td>
						</tr>

						<tr>
							<td class="label">Customer * :</td>
							<td><select name="customer_category" id="customer_category" ><option value=''>--Select Group--</option>
								<?php if($customer_category==FALSE){

										echo "<option value=''>--Setup Required--</option>";

									}else{
											foreach($customer_category as $customer_category_row){
												echo "<option value='".$customer_category_row->adr_category_id."'  ".set_select('customer_category',''.$customer_category_row->adr_category_id.'').">".$customer_category_row->category_name."</option>";
												
												}
											}
									?></select></td>
							</tr>

						<tr>
							<td class="label">Currency  * :</td>
							<td><select name="currency" id="currency"><option value=''>--Select Currency--</option>
								<?php if($country==FALSE){
									echo "<option value=''>--Currency Setup Required--</option>";}
									else{
										foreach($country as $country_row){
											echo '<option value="'.$country_row->currency_name.'|'.$country_row->country_id.'"  '.set_select('currency',''.$country_row->currency_name.'|'.$country_row->country_id.'').'>'.$country_row->currency_name.' ('.$country_row->country_short_id.')</option>';
										}
									}?>
								</select></td>
						</tr>
						
					</table>
				</td>
				<td>
					<table class="form_table_inner">
						<!--<tr>
							<td class="label">Version No * :</td>
							<td><select id="version_no" name="version_no" required>
								<?php
								if($this->input->post('version_no')){
									echo '<option value="'.$this->input->post('version_no').'">'.$this->input->post('version_no').'</option>';
								}else{
									echo '<option value="">--Version No--</option>';
								}
								?>
								</select></td>
							</tr>-->
							<!--
						<tr>
								<td class="label">Exchange rate * :</td>
							<td>
								<select name="exchange_rate" id="exchange_rate">
									<option value=''>--Select Rate--</option>
								</select>
							</td>
						</tr>-->
					</table>
			</tr>
		</table>
	</div>
	<br/>
	<br/>
	<div class="middle_form_design">
		<div class="middle_form_inner_design">
			<table class="ui very basic collapsing celled table"  style="font-size:10px;">
			<thead>
			    <tr>
			    	<th>SR NO</th>
			    	<th>SLAB</th>
			    	<th>QUANTITY FROM</th>
			    	<th>QUANTITY TO</th>
			    	<th>FINAL UNIT PRICE</th>
			    	<th>FREIGHT</th>
			    	<th>OTHER COST</th>
			    	<th>MARKUP</th>
			    	<th>EX-WORKS</th>
			  </tr>
			</thead>

			  <tbody>
			  	<?php 
			  	if($product_block_pricing_master==FALSE){

			  	}else{
			  		$i=1;
			  		foreach($product_block_pricing_master as $product_block_pricing_master_row){?>

			  			<script>
							$(document).ready(function(){
								$("#unit_rate_<?php echo $i;?>").live('keyup',function(event) {
									var price_1 = parseFloat($("#price_1_<?php echo $i?>").val());
									var price_2 = parseFloat($("#price_2_<?php echo $i?>").val());
									var price_3 = parseFloat($("#price_3_<?php echo $i?>").val());
									var price_4 = parseFloat($("#price_4_<?php echo $i?>").val());
									var unit_rate=price_1-price_2-price_3-price_4;
									if (!isNaN(unit_rate)) {
									document.getElementById("unit_rate_<?php echo $i;?>").value=unit_rate.toFixed(4);
									}else{
										alert('Enter the Numeric Value');
									}
								});
							});
						</script>

						<?php

			  			echo "<tr>
						      <td><input type='hidden' name='sr_no[] value='$i'/>".$i."</td>
						      <td><input type='hidden' name='pbpm_id_$i' value='$product_block_pricing_master_row->pbpm_id'/>".$product_block_pricing_master_row->block_name."</td>
						      <td>".money_format('%!.0n',$this->common_model->read_number($product_block_pricing_master_row->block_from,$this->session->userdata['logged_in']['company_id']))."</td>
						      <td>".money_format('%!.0n',$this->common_model->read_number($product_block_pricing_master_row->block_to,$this->session->userdata['logged_in']['company_id']))."</td>
						      <td><input type='text' name='price_1_$i' value='".set_value('price_1_'.$i.'','0')."' maxlength='15' size='10'  id='price_1_$i' /></td>
						      <td><input type='text' name='price_2_$i' value='".set_value('price_2_'.$i.'','0')."' maxlength='15' size='10'  id='price_2_$i' /></td>
						      <td><input type='text' name='price_3_$i' value='".set_value('price_3_'.$i.'','0')."' maxlength='15' size='10'  id='price_3_$i' /></td>
						      <td><input type='text' name='price_4_$i' value='".set_value('price_4_'.$i.'','0')."' maxlength='15' size='10'  id='price_4_$i' /></td>
						      <td><input type='text' name='unit_rate_$i' value='".set_value('unit_rate_'.$i.'','0')."' maxlength='15' size='10'  id='unit_rate_$i' readonly/></td>
						    </tr>";
						    $i++;

			  		}
			  	}
			  	?>		    
			</tbody>
			</table>
		</div>
	</div>

	<div class="form_design">
		<div class="ui buttons">
	  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui positive button">Save</button>
		</div>
	</div>
		
</form>
				
				
				
				
				
			