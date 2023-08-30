<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		$("#adr_company_id").autocomplete("<?php echo base_url('index.php/ajax/customer');?>", {selectFirst: true});
		//.blur(function(){ $("#bill_to_address").html('address'); })
		$("#adr_company_id").live('keyup',function(){
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/customer_address');?>",data: {adr_company_id : $("#adr_company_id").val()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#bill_to_address").html(html);
				} 
			});
		});

		$("#adr_company_id").live('keyup',function(){
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/customer_max_lead_time');?>",data: {adr_company_id : $("#adr_company_id").val()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#lead_time").html(html);
				} 
			});
		});

		$("#consin_adr_company_id").change(function(){
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/shipping_address');?>",data: {consin_adr_company_id : $("#consin_adr_company_id").val()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#ship_to_address").html(html);
				} 
			});
		});




		$("#export").live('click',function(){
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			if ($(this).is(":checked")) {
				$("#loading").hide(); $("#cover").hide();
                $(".sarl_unit_rate").removeAttr("disabled");
            }else {
            	$("#loading").hide(); $("#cover").hide();
                $(".sarl_unit_rate").attr("disabled", "disabled");
            }
		});

		$("#adr_company_id").live('keyup',function(){
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/ship_to');?>",data: {adr_company_id : $("#adr_company_id").val()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#consin_adr_company_id").html(html);
				} 
			});
		});

		$("#adr_company_id").blur(function() {
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/ship_to');?>",data: {adr_company_id : $("#adr_company_id").val()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#consin_adr_company_id").html(html);
				} 
			});
		});


		
		$("#product_name_1").autocomplete("<?php echo base_url('index.php/ajax/article_no');?>", {selectFirst: true});

		/*
		$("#product_name_1").live('keyup',function(){
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/spec_final_version_no');?>",data: {article_no : $("#product_name_1").val()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#product_spec_artwork_1").html(html);
				} 
			});
		});
*/


		$("#product_name_1").live('keyup',function(){
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/bom_no');?>",data: {article_no : $("#product_name_1").val()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#product_spec_artwork_1").html(html);
				} 
			});
		});

		$("#product_name_1").live('keyup',function(){
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/po_check');?>",data: {article_no : $("#product_name_1").val(),po_no : $("#po_no").val()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},500);
				$("#po_check").html(html);
				} 
			});
		});


		$("#currency").change(function(event) {
		   var currency = $('#currency').val().split("|")[0];
		   //alert(currency);
		   var country=$('#currency').val().split("|")[1];
		   //alert(country);
		   $("#loading").show();
					$("#cover").show();
					$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
		    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/currency_rate",data: { currency : currency},cache: false,success: function(html){
		    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
		       $("#exchange_rate").html(html);
		    } 
		    });
		  });

	  	$("#unit_rate_1").live('keyup',function(event) {
			  var unit_rate = parseFloat($(this).val());
			  var quantity = parseFloat($(this).closest('td').prev('td').find('input').val());
			  var total=0;
			 	if(isNaN(quantity) && quantity==0){
		    					alert("Enter the Quantity");
		    				}else if(isNaN(unit_rate) && unit_rate==0){
		    					alert("Enter the Unit Rate");
		    				}else if(!isNaN(unit_rate) && ! isNaN(unit_rate)){
		    					total=unit_rate*quantity;
		    					$(this).closest('td').next('td').find('input').val(total);
		    					document.getElementById($(this).closest('td').next('td').find('input')).value=total;
		    				}
			   });

  $("#tax_grid_1").live('change',function(){
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/tax_grid');?>",data: {tax_grid : $("#tax_grid_1").val(),
				amount :$('#amount_1').val()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);

				$("#tax_amount_1").html(html);
				} 
			});
		});

		$(".quantity").live ('change',function() {
    var total_quantity = 0;    
    $(".quantity").each(function() {
    	if(!isNaN($(this).val()) && $(this).val().length!=0) {
      total_quantity += parseFloat($(this).val());
      }    
    });
    $("#total_quantity").html(total_quantity);
  	});

  	$(".unit_rate").live ('change',function() {
    var total_amount = 0;    
    $(".amount").each(function() {
    	if(!isNaN($(this).val()) && $(this).val().length!=0) {
      total_amount += parseFloat($(this).val());
      }    
    });
    $("#total_amount").html("&#8377;"+total_amount+"/-");
  	});

  	$(".total_tax_amount").live ('keyup',function() {
    var total_tax_amount = 0;    
    $(".total_tax_amount").each(function() {
    	if(!isNaN($(this).val()) && $(this).val().length!=0) {
      total_tax_amount += parseFloat($(this).val());

      }    
    });
    $("#total_tax_amount").html("&#8377;"+total_tax_amount+"/-");
  	});


  var counter=0;

		var x = document.getElementsByName("sr_no[]");

		var counter=x.length+1;

		$("#add").live('click',function () {
					var newtr = $(document.createElement('tr')).attr("id", 'tr_'+counter);
					newtr.html('<td><input type="hidden" name="sr_no[]" value="'+counter+'"/>'+counter+'</td><td><input type="text" name="product_name_'+	counter+'" id="product_name_'+	counter+'" value="<?php echo set_value('product_name_"+counter+"');?>" size="50" placeholder="Goods Information"/><span id="product_spec_artwork_'+	counter+'"></span></td><td><input type="text" name="sarl_unit_rate_'+counter+'" id="sarl_unit_rate_'+counter+'" value="<?php echo set_value('sarl_unit_rate_"+counter+"');?>" maxlength="15" size="10" class="sarl_unit_rate" disabled/></td><td><input type="date" name="delivery_date_'+counter+'" id="delivery_date_'+counter+'"  value="<?php echo set_value('delivery_date_"+counter+"');?>" size="10" class="delivery_date" /></td><td><input type="text" name="quantity_'+counter+'" id="quantity_'+counter+'"  value="<?php echo set_value('quantity_"+counter+"');?>" maxlength="15" size="10" class="quantity" /></td><td><input type="text" name="unit_rate_'+counter+'" id="unit_rate_'+counter+'" value="<?php echo set_value('unit_rate_"+counter+"');?>" maxlength="15" size="10" class="unit_rate"/></td><td><input type="text" name="amount_'+counter+'" id="amount_' + counter + '" value="<?php echo set_value('amount_"+counter+"');?>" maxlength="15" size="10" class="amount" readonly/></td><td><select name="tax_grid_' + counter + '" id="tax_grid_' + counter + '" class="tax_grid"><option value="">--Select Tax--</option><?php if($tax_grid==FALSE){echo '<option value="">--Setup Required--</option>';}else{foreach($tax_grid as $tax_grid_row){echo '<option value="'.$tax_grid_row->tax_id.'"  '.set_select('tax_grid_"+ counter +"',''.$tax_grid_row->tax_id.'').'>'.$tax_grid_row->tax_grid_name.'</option>';}}?></select></td><td><span id="tax_amount_' + counter + '" class="tax"></span></td>');

					var lastcounter=counter-1;
					newtr.insertAfter("#tr_"+lastcounter);
					$("#product_name_"+counter).autocomplete("<?php echo base_url('index.php/ajax/article_no');?>", {selectFirst: true});
					var a=lastcounter+1;


					$("#product_name_" + a).live('keyup',function(){
						$("#loading").show(); $("#cover").show();
						$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
						$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/spec_final_version_no');?>",data: {article_no : $("#product_name_" + a).val()},cache: false,success: function(html){
							setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
							$("#product_spec_artwork_" + a).html(html);
									} 
								});
						});

						$("#unit_rate_" + a).live('keyup',function(event) {
		    			var unit_rate = parseFloat($(this).val());
		    			var quantity = parseFloat($(this).closest('td').prev('td').find('input').val());
		    			var total=0;

		    			if(isNaN(quantity) && quantity==0){
	    					alert("Enter the Quantity");
	    				}else if(isNaN(unit_rate) && unit_rate==0){
	    					alert("Enter the Unit Rate");
	    				}else if(!isNaN(unit_rate) && ! isNaN(unit_rate)){
	    					total=unit_rate*quantity;
	    					$(this).closest('td').next('td').find('input').val(total);
	    					document.getElementById($(this).closest('td').next('td').find('input')).value=total;
	    				}
		    		});

						$("#tax_grid_"+a).live('change',function(){
			
							$("#loading").show();
							$("#cover").show();
							$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
							$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/tax_grid');?>",data: {tax_grid : $(this).val(),amount :$('#amount_'+a).val()},cache: false,success: function(html){
								setTimeout(function () {$("#loading").hide();$("#cover").hide();},1000);
									$("#tax_amount_"+a).html(html);
								} 
							});
						});

						counter++;
				});


		$("#remove").click(function(){
			if(counter==2){ alert("No more textbox to remove"); return false;}
			counter--;
			$("#tr_" + counter).remove();
		});


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
										<td class="label">Bill To <span style="color:red;">*</span> :</td>
										<td><input type="text" name="adr_company_id" id="adr_company_id"  size="60" value="<?php echo set_value('adr_company_id');?>" /><span id='lead_time'></td>
									</tr>
									<tr>
										<td class="label">Billing Address <span style="color:red;">*</span> :</td>
										<td><span id="bill_to_address" style="font-family: verdana;font-size: 70%;"></td>
									</tr>

									<tr>
										<td class="label">Ship To   :</td>
										<td><select name="consin_adr_company_id" id="consin_adr_company_id">
											<option value=''>--Same As Bill To--</option>
											<?php
											foreach ($ship_to as $ship_to_row){
									            echo "<option value='".$ship_to_row->related_company_id."' ".set_select('consin_adr_company_id',''.$ship_to_row->related_company_id.'').">".$ship_to_row->relate."//".$ship_to_row->related_company_id."//".$ship_to_row->lang_property_name."</option>";
									          } ?> 
										</select></td>
									</tr>
									<tr>
										<td class="label">Shipping Address <span style="color:red;">*</span> :</td>
										<td><span id="ship_to_address" style="font-family: verdana;font-size: 70%;"></td>
									</tr>

									<tr>
										<td class="label">Po No <span style="color:red;">*</span> :</td>
										<td><input type="text" name="po_no" id="po_no" value="<?php echo set_value('po_no');?>"/></td>
									</tr>
									
									<tr>
										<td class="label">Po Date <span style="color:red;">*</span> :</td>
										<td><input type="date" name="po_date" value="<?php echo set_value('po_date');?>"/></td>
									</tr>
									<tr>
										<td class="label">Product Code :</td>
										<td><input type="text" name="cust_product_no" size="30" value="<?php echo set_value('cust_product_no');?>"/></td>
									</tr>

									<tr>
										<td class="label">Export  :</td>
										<td><input type="checkbox" name="export" id="export" value="1" <?php echo set_checkbox('export',1);?> /></td>
									</tr>

									<tr>
										<td class="label">For Sample  :</td>
										<td><input type="checkbox" name="for_sampling"  value="1" <?php echo set_checkbox('for_sampling',1);?> /></td>
									</tr>

									<tr>
										<td class="label">Currency :</td>
										<td>
											<select name="currency" id="currency"><option value=''>--Select Currency--</option>
											<?php if($country==FALSE){
															echo "<option value=''>--Currency Setup Required--</option>";}
												else{
													foreach($country as $country_row){
														
														echo '<option value="'.$country_row->currency_name.'|'.$country_row->country_id.'"  '.set_select('currency',''.$country_row->currency_name.'|'.$country_row->country_id.'').'>'.$country_row->currency_name.' ('.$country_row->country_short_id.')</option>';
													}
											}?>
											</select>
											<!--&nbsp; <a href="<?php echo base_url('index.php/currency')?>" target="_blank">Currency Master</a>
											-->
										</td>
									</tr>

									<tr>
										<td class="label">Exchange Rate :</td>
										<td>
											<select name="exchange_rate" id="exchange_rate">
											<option value=''>--Select Rate--</option>
											</select>

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
			</td>
			<td>
				<table>

					
					<tr>
						<td class="label">For Stock  :</td>
						<td><input type="checkbox" name="for_stock"  value="1" <?php echo set_checkbox('for_stock',1);?> /></td>
					</tr>
					<tr>
						<td class="label">Referense SO. :</td>
						<td><input type="text" name="ref_order_no" id="ref_order_no" value="<?php echo set_value('ref_order_no')?>" maxlength="30"> </td>
					</tr>
					<tr>
						<td class="label">Payment Term  :</td>
						<td><select name="payment_term"><option value=''>--Select Payment Term--</option>
						<?php if($payment_term==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
							else{
								foreach($payment_term as $payment_term_row){
									echo "<option value='".$payment_term_row->id."'  ".set_select('payment_term',''.$payment_term_row->id.'').">".$payment_term_row->lang_description." (".$payment_term_row->net_days." days) </option>";
								}
						}?>
						</select></td>
					</tr>

						<tr>
						<td class="label">Shipping Details  :</td>
						<td><select name="freight_type"><option value=''>--Select Shipping Details-</option>
						<?php if($freight_type==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
							else{
								foreach($freight_type as $freight_type_row){
									echo "<option value='".$freight_type_row->freight_type_id."'  ".set_select('freight_type',''.$freight_type_row->freight_type_id.'').">".$freight_type_row->lang_freight_type."</option>";
								}
						}?>
						</select></td>
					</tr>

						<tr>
							<td class="label">Comment :</td>
							<td><textarea name="comment" value="<?php echo set_value('comment');?>"><?php echo set_value('comment');?></textarea></td>
					</tr>

					<tr>
								<td>Po File <span style="color:red;">*</span> :</td>
								<td><input type="file" name="userfile" /></td>
					</tr>


				</table>
			</td>
		</tr>
	</table>
	</div>

				<div class="middle_form_design">
					<div class="middle_form_inner_design">
						
						<div class="ui buttons">
						<input type="button" value="Remove" id="remove" class="ui button">
						<div class="or"></div>
						<input type="button" value="Add" id="add" class="ui positive button">
						</div>

						<br/><br/>
						<table class="middle_form_table_design">
						<tr>
								<th>Sr NO</th>
								<th>Product</th>
								<th>SARL Unit/Rate</th>
								<th>Delivery Date</th>
								<th>Quantity</th>
								<th>Unit/Rate</th>
								<th>Amount</th>
								<th>Tax</th>
								<th>Tax Amount</th>
						</tr>
						<?php
						if($this->input->post('sr_no')){
							$total_quantity=0;
							$total_amount=0;
							$total_ttax_amount=0;
							for($i=1;$i<=count($this->input->post('sr_no[]'));$i++){?>

							<script>
							$(document).ready(function(){
							$("#loading").hide(); $("#cover").hide();

							$("#product_name_<?php echo $i;?>").autocomplete("<?php echo base_url('index.php/ajax/article_no');?>", {selectFirst: true});

							$("#product_name_<?php echo $i;?>").live('keyup',function(){
							$("#loading").show(); $("#cover").show();
							$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
							$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/bom_no');?>",data: {article_no : $("#product_name_<?php echo $i;?>").val()},cache: false,success: function(html){
								setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
								$("#product_spec_artwork_<?php echo $i;?>").html(html);
										} 
									});
							});

							$("#tax_grid_<?php echo $i;?>").live('change',function(){
								$("#loading").show(); $("#cover").show();
								$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
									$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/tax_grid');?>",data: {tax_grid : $(this).val(),
										amount :$(this).closest('td').prev('td').find('input').val()},cache: false,success: function(html){
										setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
										
									$("#tax_amount_<?php echo $i;?>").html(html);			
													
									} 
									});
								});

							$("#unit_rate_<?php echo $i;?>").live('keyup',function(event) {
								var unit_rate = parseFloat($(this).val());
						    var quantity = parseFloat($(this).closest('td').prev('td').find('input').val());
						    var total=0;
						    if(isNaN(quantity) && quantity==0){
						    	alert("Enter the Quantity");
						    }else if(isNaN(unit_rate) && unit_rate==0){
						    	alert("Enter the Unit Rate");
						    }else if(!isNaN(unit_rate) && ! isNaN(unit_rate)){
						    	total=unit_rate*quantity;
						    	$(this).closest('td').next('td').find('input').val(total);
						    	document.getElementById($(this).closest('td').next('td').find('input')).value=total;
						    }
						   });

							});
						</script>


							<?php
								$amount=$this->input->post('quantity_'.$i.'')*$this->input->post('unit_rate_'.$i.'');
								if($this->input->post('tax_grid_'.$i.'')){
									$data['tax_grid']=$this->common_model->select_tax_record('tax_grid_details',$this->session->userdata['logged_in']['company_id'],'tax_id',$this->input->post('tax_grid_'.$i.''));
								if($data['tax_grid']==FALSE){
									echo "No Record Found";
								}else{
											  global $total_tax_amount;
											  $total_tax_amount=0;
											  $a=array();
											  $tax_amount=0;
											  $ta_amount=0;
											  foreach ($data['tax_grid'] as $tax_grid_row){
											  	if($tax_grid_row->accu_flag==0 && $tax_grid_row->other_tax_code==''){ 
											    	$data['tax']=$this->common_model->select_one_active_record('tax_master',$this->session->userdata['logged_in']['company_id'],'tax_code',$tax_grid_row->tax_code);
											      foreach ($data['tax'] as $tax_value) {
											         $ta_amount=($amount/100)*$this->common_model->read_number($tax_value->tax_rate,$this->session->userdata['logged_in']['company_id']); 
											      }
											    }else{
											    	$tax_structure_value=explode("|||",$tax_grid_row->other_tax_code);
											      count($tax_structure_value);
											      $data['tax']=$this->common_model->select_one_active_record('tax_master',$this->session->userdata['logged_in']['company_id'],'tax_code',$tax_grid_row->tax_code);
											      foreach ($data['tax'] as $tax_value) {
											      foreach ($tax_structure_value as  $value) {
											        if($value=='basic'){}else{}
											       } 
											        $ta_amount=(($amount+$total_tax_amount)/100)*$this->common_model->read_number($tax_value->tax_rate,$this->session->userdata['logged_in']['company_id']);
											      }
											  }
											  array_push($a,$ta_amount);
											  $total_tax_amount +=$ta_amount;
											 }
												implode("|",$a);
									}
									$total_ttax_amount+=$total_tax_amount;
								}
							?>
							
							
							<tr id="tr_<?php echo $i;?>">
								<td><input type="hidden" name="sr_no[]" value="<?php echo $i;?>"/><?php echo $i;?></td>
								<td><input type="text" name="product_name_<?php echo $i;?>" id="product_name_<?php echo $i;?>" size="50" value="<?php echo set_value('product_name_'.$i.'');?>" placeholder="Goods Information"/>
								<span id="product_spec_artwork_<?php echo $i;?>"></span>
								</td>
								<td><input type="text" name="sarl_unit_rate_<?php echo $i;?>" id="sarl_unit_rate_<?php echo $i;?>" value="<?php echo set_value('sarl_unit_rate_'.$i.'');?>" maxlength="15" size="10"  class="sarl_unit_rate" disabled/></td>
								<td><input type="date" name="delivery_date_<?php echo $i;?>" id="delivery_date_<?php echo $i;?>" size="10" value="<?php echo set_value('delivery_date_'.$i.'');?>"/></td>
								<td><input type="text" name="quantity_<?php echo $i;?>" id="quantity_<?php echo $i;?>" value="<?php echo set_value('quantity_'.$i.'');?>" maxlength="15" size="10" class="quantity" /></td>
								<td><input type="text" name="unit_rate_<?php echo $i;?>" id="unit_rate_<?php echo $i;?>" value="<?php echo set_value('unit_rate_'.$i.'');?>" maxlength="15" size="10"  class="unit_rate" /></td>
								<td><input type="text" name="amount_<?php echo $i;?>" id="amount_<?php echo $i;?>" value="<?php echo set_value('amount_'.$i.'');?>" maxlength="15" size="10" class="amount" readonly/></td>
								<td><select name="tax_grid_<?php echo $i;?>" id="tax_grid_<?php echo $i;?>" class="tax_grid"><option value="">--Select Tax--</option>
								<?php 
										if($tax_grid==FALSE){
											echo "<option value=''>--Tax Grid Set up Required--</option>";
										}else{
											foreach ($tax_grid as $tax_grid_row) {
												echo "<option value='$tax_grid_row->tax_id' ".set_select('tax_grid_'.$i.'',''.$tax_grid_row->tax_id.'').">$tax_grid_row->tax_grid_name</option>";
											}
										}
										?>
							</select></td>
								<td><span id="tax_amount_<?php echo $i;?>"><input type="text" name="total_tax_amount" class="total_tax_amount" value="<?php echo $this->input->post('tax_grid_'.$i.'') ? $total_tax_amount : '0';?>"></span></td>
							</tr>



						<?php 
						$total_quantity+=$this->input->post('quantity_'.$i.'');
						$total_amount+=$this->input->post('amount_'.$i.'');
						
						}
						}else{?>
						<tr id="tr_1">
							<!-- <input type="text" name="" id="data_mismatch" readonly/> -->
							<td>
								<input type="hidden" name="sr_no[]" value="1"/>1</td>
							<td>
								<input type="text" name="product_name_1" id="product_name_1" class="product_name_11" size="50"  value="<?php echo set_value('product_name_1');?>" onkeyup="check_psm_no(this.value)"; placeholder="Goods Information"/>
								<span id="product_spec_artwork_1"></span>
								<span id="po_check"></span>
								<span id="data_mismatch"></span>
							</td>
							<td>
								<input type="text" name="sarl_unit_rate_1"  id="sarl_unit_rate_1" class="sarl_unit_rate" value="<?php echo set_value('sarl_unit_rate_1');?>" maxlength="15" size="10" disabled/></td>
							<td>
								<input type="date" name="delivery_date_1"  id="delivery_date_1" class="delivery_date" value="<?php echo set_value('delivery_date_1');?>" maxlength="10" size="10" /></td>
							<td>
								<input type="text" name="quantity_1"  id="quantity_1" class="quantity" value="<?php echo set_value('quantity_1');?>" maxlength="15" size="10" /></td>
							<td>
								<input type="text" name="unit_rate_1"  id="unit_rate_1" class="unit_rate" value="<?php echo set_value('unit_rate_1');?>" maxlength="15" size="10" /></td>
							<td><input type="text" name="amount_1" id="amount_1" class="amount" value="<?php echo set_value('amount_1');?>" maxlength="15" size="10" readonly/></td>
							<td><select name="tax_grid_1" id="tax_grid_1" class="tax_grid"><option value="">--Select Tax--</option>
								<?php 
										if($tax_grid==FALSE){
											echo "<option value=''>--Tax Grid Set up Required--</option>";
										}else{
											foreach ($tax_grid as $tax_grid_row) {
												echo "<option value='$tax_grid_row->tax_id' ".set_select('tax_grid_1',''.$tax_grid_row->tax_id.'').">$tax_grid_row->tax_grid_name</option>";
											}
										}
										?>
							</select></td>
							<td><span id="tax_amount_1"></span></td>

						</tr>
						
						<?php
						}
						?>
						<?php
						if($this->input->post('sr_no[]')){?>
						<tr>
							<td colspan="4" class="middle_form_total_design"><b>Total Quantity</b></td>
							<td><b><span id="total_quantity"><?php echo $total_quantity;?></span></b></td>
							<td><b>Net Amount</b></td>
							<td><b><span id="total_amount">&#8377;<?php echo $total_amount;?>/-</span></b></td>
							<td><b>Total Tax</b></td>
							<td><b><span id="total_tax_amount">&#8377;<?php echo $total_ttax_amount;?>/-</span></b></td>
						</tr>
						<?php }else{?>
						<tr>
							<td colspan="4" class="middle_form_total_design"><b>Total Quantity</b></td>
							<td><b><span id="total_quantity"></span></b></td>
							<td><b>Net Amount</b></td>
							<td><b><span id="total_amount">&#8377;0/-</span></b></td>
							<td><b>Total Tax</b></td>
							<td><b><span id="total_tax_amount">&#8377;0/-</span></b></td>
						</tr>
						<?php }?>
						</table>
						
					</div>
					
				</div>

					
	<div class="form_design">
		<div class="ui buttons">
	  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui positive button" onClick="return confirm('Are you sure to save Record?');">Save</button>
		</div>
	</div>
		
</form>


<script>
	function check_psm_no(product_name_1) {
   /* $.ajax({
            type: 'POST',
            //alert('Hi');
            url: "<?php echo base_url('index.php/sales_order_book/get_ajax_data');?>",
            async: false,
            dataType: 'json',
            data: {product_name_1 : $(".product_name_11").val()},
            success: function(res){
					    if (res.status == "200") {	
						    $('#data_mismatch').val(res.data['data_mismatch']);
						    //alert(res.data['data_mismatch']);
						    var text = "ADR & BOM Data Mismatch Error.";
						    if(res.data['data_mismatch']=='TRUE'){
						    	//alert('1');
						    }else{ 
						    	alert(text);
						    }
				      }else{
				      	$('#data_mismatch').val();
				      }
			  }
      });
    return false;
  }*/
</script>   
				
				
				
				
				
			