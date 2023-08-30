<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		$("#adr_company_id").autocomplete("<?php echo base_url('index.php/ajax/supplier');?>", {selectFirst: true});

		$("#product_name_1").autocomplete("<?php echo base_url('index.php/ajax/purchase_article_no');?>", {selectFirst: true});

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
	    					total=parseFloat(total).toFixed(2);
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
					newtr.html('<td><input type="hidden" name="sr_no[]" value="'+counter+'"/>'+counter+'</td><td><input type="text" name="product_name_'+	counter+'" id="product_name_'+	counter+'" value="<?php echo set_value('product_name_"+counter+"');?>" size="50" placeholder="Goods Information"/></td><td><input type="text" name="quantity_'+counter+'" id="quantity_'+counter+'"  value="<?php echo set_value('quantity_"+counter+"');?>" maxlength="15" size="10" class="quantity" /></td><td><input type="text" name="unit_rate_'+counter+'" id="unit_rate_'+counter+'" value="<?php echo set_value('unit_rate_"+counter+"');?>" maxlength="15" size="10" class="unit_rate"/></td><td><input type="text" name="amount_'+counter+'" id="amount_' + counter + '" value="<?php echo set_value('amount_"+counter+"');?>" maxlength="15" size="10" class="amount" readonly/></td><td><select name="tax_grid_' + counter + '" id="tax_grid_' + counter + '" class="tax_grid"><option value="">--Select Tax--</option><?php if($tax_grid==FALSE){echo '<option value="">--Setup Required--</option>';}else{foreach($tax_grid as $tax_grid_row){echo '<option value="'.$tax_grid_row->tax_id.'"  '.set_select('tax_grid_"+ counter +"',''.$tax_grid_row->tax_id.'').'>'.$tax_grid_row->tax_grid_name.'</option>';}}?></select></td><td><span id="tax_amount_' + counter + '" class="tax"></span></td>');

					var lastcounter=counter-1;
					newtr.insertAfter("#tr_"+lastcounter);
					$("#product_name_"+counter).autocomplete("<?php echo base_url('index.php/ajax/purchase_article_no');?>", {selectFirst: true});
					var a=lastcounter+1;

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
	    					total=parseFloat(total).toFixed(2);
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

<?php foreach ($purchase_order_master as $order_row):?>
<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">
									<tr>
										<td class="label">Po No * :</td>
										<td><input type="text" name="po_no" value="<?php echo $order_row->po_no;?>" disabled>
										<input type="hidden" name="po_no" value="<?php echo $order_row->po_no;?>"></td>
									</tr>


									<tr>
										<td class="label">Supplier * :</td>
										<td><select name="adr_company_id">
											<?php 
												foreach($supplier as $supplier_row){
													$selected=($supplier_row->adr_company_id==$order_row->supplier_no ? 'selected' :'');
            echo "<option value='".$supplier_row->name1."//".$supplier_row->adr_company_id."//".$supplier_row->lang_property_name."' $selected ".set_select('adr_company_id',''.$supplier_row->adr_company_id.'').">".$supplier_row->name1."//".$supplier_row->adr_company_id."//".$supplier_row->lang_property_name."</option>";
												}
											?>
										</select></td>
									</tr>
									

								

									<tr>
										<td class="label">Warehouse * :</td>
										<td>
											<select name="warehouse_id" ><option value=''>--Select Warehouse--</option>
											<?php if($warehouse==FALSE){
															echo "<option value=''>--Warehouse Setup Required--</option>";}
												else{
													foreach($warehouse as $warehouse_row){
														$selected=($warehouse_row->room_no==$order_row->warehouse_id ? 'selected' : '');
														echo '<option value="'.$warehouse_row->room_no.'" '.$selected.' '.set_select('warehouse_id',''.$warehouse_row->room_no.'').'>'.$warehouse_row->lang_warehouse_name.'</option>';
													}
											}?>
											</select>
										</td>
									</tr>

										<tr>
										<td class="label">Freight * :</td>
										<td>
											<select name="freight_type_id" ><option value=''>--Select Freight--</option>
											<?php if($freight_type==FALSE){
															echo "<option value=''>--Freight Setup Required--</option>";}
												else{
													foreach($freight_type as $freight_type_row){
														$selected=($freight_type_row->freight_type_id==$order_row->freight_type_id ? 'selected' : '');
														echo '<option value="'.$freight_type_row->freight_type_id.'" '.$selected.' '.set_select('freight_type_id',''.$freight_type_row->freight_type_id.'').'>'.$freight_type_row->lang_freight_type.'</option>';
													}
											}?>
											</select>
										</td>
									</tr>
									
									

									<tr>
										<td class="label">Import  :</td>
										<td><input type="checkbox" name="import"  value="1" <?php echo set_checkbox('import',1);?> <?php echo ($order_row->for_import==1 ? 'value="1" checked' : 'value="0"');?>/></td>
									</tr>

									<tr>
										<td class="label">Currency :</td>
										<td>
											<select name="currency" id="currency"><option value=''>--Select Currency--</option>
											<?php if($country==FALSE){
															echo "<option value=''>--Currency Setup Required--</option>";}
												else{
													foreach($country as $country_row){
														$selected=($country_row->country_id===$order_row->country_id ? 'selected' : '');
														echo '<option value="'.$country_row->currency_name.'|'.$country_row->country_id.'" '.$selected.' '.set_select('currency',''.$country_row->currency_name.'|'.$country_row->country_id.'').'>'.$country_row->currency_name.' ('.$country_row->country_short_id.')</option>';
													}
											}?>
											</select>
										</td>
									</tr>

									<tr>
										<td class="label">Exchange Rate :</td>
										<td>
											<select name="exchange_rate" id="exchange_rate">
											<option value='<?php echo  $order_row->currency_id."|".$this->common_model->read_number($order_row->exchange_rate,$this->session->userdata['logged_in']['company_id'])."|".$order_row->exchange_rate_date;?>'>
											<?php echo $order_row->currency_id." ".$this->common_model->read_number($order_row->exchange_rate,$this->session->userdata['logged_in']['company_id'])." - ".$order_row->exchange_rate_date;?></option>
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
										<td class="label">Indent No :</td>
										<td><input type="text" name="po_req_no" value="<?php echo set_value('po_req_no',$order_row->po_req_no);?>"/></td>
									</tr>

									<tr>
										<td class="label">So No :</td>
										<td><input type="date" name="so_no" value="<?php echo set_value('so_no',$order_row->so_no);?>"/></td>
									</tr>
						
						<?php 
									$data['order_comment']=$this->common_model->select_one_active_record_nonlanguage_without_archive('purchase_order_master_lang',$this->session->userdata['logged_in']['company_id'],'purchase_order_master_lang.po_no',$order_row->po_no);
									if($data['order_comment']==FALSE){
									}else{
											foreach($data['order_comment'] as $order_comment_row){
													echo '<tr>
												<td class="label">Remark :</td>
												<td><textarea name="comment" value="'.set_value('comment',$order_comment_row->lang_addi_info).'">'.set_value('comment',$order_comment_row->lang_addi_info).'</textarea></td>
												</tr>';
											}
									}
									?>

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

							$("#product_name_<?php echo $i;?>").autocomplete("<?php echo base_url('index.php/ajax/purchase_article_no');?>", {selectFirst: true});

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
						    	total=parseFloat(total).toFixed(2);
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
						}else{
							$quantity=0;
							$amount=0;
							$t_quantity=0;
							$t_netamount=0;
							$t_tax=0;
						foreach($purchase_order_details as $order_details_row):
							$quantity=0;
							$amount=0;
							$quantity+=$this->common_model->read_number($order_details_row->po_qty,$this->session->userdata['logged_in']['company_id']);
						if($order_row->for_import==1){
							$amount+=$order_details_row->calc_sell_price*$this->common_model->read_number($order_details_row->po_qty,$this->session->userdata['logged_in']['company_id']);
						}else{
							$amount+=$this->common_model->read_number($order_details_row->price_per_unit,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($order_details_row->po_qty,$this->session->userdata['logged_in']['company_id']);
						}

							?>
						<script>
							$(document).ready(function(){
							$("#loading").hide(); $("#cover").hide();

							$("#product_name_<?php echo $order_details_row->pur_pos_no;?>").autocomplete("<?php echo base_url('index.php/ajax/purchase_article_no');?>", {selectFirst: true});

							$("#tax_grid_<?php echo $order_details_row->pur_pos_no;?>").live('change',function(){
								$("#loading").show(); $("#cover").show();
								$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
									$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/supplier_tax_grid');?>",data: {tax_grid : $(this).val(),
										amount :$(this).closest('td').prev('td').find('input').val()},cache: false,success: function(html){
										setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
										
									$("#tax_amount_<?php echo $order_details_row->pur_pos_no;?>").html(html);			
													
									} 
									});
								});

							$("#unit_rate_<?php echo $order_details_row->pur_pos_no;?>").live('keyup',function(event) {
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
							
						<tr id="tr_<?php echo $order_details_row->pur_pos_no;?>">
							<td>
								<input type="hidden" name="sr_no[]" value="<?php echo $order_details_row->pur_pos_no;?>"/><?php echo $order_details_row->pur_pos_no;?></td>
							<td>
							<?php
							$data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$order_details_row->article_no);
								foreach($data['article'] as $article_row){
									$article_name=$article_row->article_name;
								}
							?>
								<input type="text" name="product_name_<?php echo $order_details_row->pur_pos_no;?>" id="product_name_<?php echo $order_details_row->pur_pos_no;?>" size="50"  value="<?php echo set_value('product_name_'.$order_details_row->pur_pos_no.'',$article_name."//".$order_details_row->article_no);?>" placeholder="Goods Information"/></td>
							<td>
								<input type="text" name="quantity_<?php echo $order_details_row->pur_pos_no;?>"  id="quantity_<?php echo $order_details_row->pur_pos_no;?>" class="quantity" value="<?php echo set_value('quantity_'.$order_details_row->pur_pos_no.'', $this->common_model->read_number($order_details_row->po_qty,$this->session->userdata['logged_in']['company_id']));?>" maxlength="15" size="10" /></td>
								<?php if($order_row->for_import==1){
									echo '
								<td>
									<input type="text" name="unit_rate_'.$order_details_row->pur_pos_no.'"  id="unit_rate_'.$order_details_row->pur_pos_no.'" class="unit_rate" value="'.set_value('unit_rate_'.$order_details_row->pur_pos_no.'',$order_details_row->calc_sell_price).'" maxlength="15" size="10" /></td>';

									echo '
									<td><input type="text" name="amount_'.$order_details_row->pur_pos_no.'" id="amount_'.$order_details_row->pur_pos_no.'" class="amount" value="'.set_value('amount_'.$order_details_row->pur_pos_no.'',$order_details_row->calc_sell_price*$this->common_model->read_number($order_details_row->po_qty,$this->session->userdata['logged_in']['company_id'])).'" maxlength="15" size="10" readonly/></td>';

								}else{
									echo '
								<td>
									<input type="text" name="unit_rate_'.$order_details_row->pur_pos_no.'"  id="unit_rate_'.$order_details_row->pur_pos_no.'" class="unit_rate" value="'.set_value('unit_rate_'.$order_details_row->pur_pos_no.'',$this->common_model->read_number($order_details_row->price_per_unit,$this->session->userdata['logged_in']['company_id'])).'" maxlength="15" size="10" /></td>';

									echo '
									<td><input type="text" name="amount_'.$order_details_row->pur_pos_no.'" id="amount_'.$order_details_row->pur_pos_no.'" class="amount" value="'.set_value('amount_'.$order_details_row->pur_pos_no.'',$this->common_model->read_number($order_details_row->price_per_unit,$this->session->userdata['logged_in']['company_id'])*$this->common_model->read_number($order_details_row->po_qty,$this->session->userdata['logged_in']['company_id'])).'" maxlength="15" size="10" readonly/></td>';

									}?>
								
							<td><select name="tax_grid_<?php echo $order_details_row->pur_pos_no;?>" id="tax_grid_<?php echo $order_details_row->pur_pos_no;?>" class="tax_grid"><option value="">--Select Tax--</option>
								<?php 
										if($tax_grid==FALSE){
											echo "<option value=''>--Tax Grid Set up Required--</option>";
										}else{
											foreach ($tax_grid as $tax_grid_row) {
												$selected=($tax_grid_row->tax_id===$order_details_row->tax_pos_no ? 'selected' : '');
												echo "<option value='$tax_grid_row->tax_id' $selected ".set_select('tax_grid_'.$order_details_row->pur_pos_no.'',''.$tax_grid_row->tax_id.'').">$tax_grid_row->tax_grid_name</option>";
											}
										}
										?>
							</select></td>
							<td><span id="tax_amount_<?php echo $order_details_row->pur_pos_no;?>"><?php echo $this->common_model->read_number($order_details_row->po_qty,$this->session->userdata['logged_in']['company_id'])*$order_details_row->unit_tax;?></span></td>

						</tr>
						<?php 
						$t_quantity+=$quantity;
						$t_netamount+=$amount;
						$t_tax+=$this->common_model->read_number($order_details_row->po_qty,$this->session->userdata['logged_in']['company_id'])*$order_details_row->unit_tax;
						endforeach;?>
						<?php
						}
						?>
						<?php
						if($this->input->post('sr_no[]')){?>
						<tr>
							<td colspan="2" class="middle_form_total_design"><b>Total Quantity</b></td>
							<td><b><span id="total_quantity"><?php echo $total_quantity;?></span></b></td>
							<td><b>Net Amount</b></td>
							<td><b><span id="total_amount"><?php echo $total_amount;?>/-</span></b></td>
							<td><b>Total Tax</b></td>
							<td><b><span id="total_tax_amount"><?php echo $total_ttax_amount;?>/-</span></b></td>
						</tr>
						<?php }else{?>
						<tr>
							<td colspan="2" class="middle_form_total_design"><b>Total Quantity</b></td>
							<td><b><span id="total_quantity"><?php echo $t_quantity;?>/-</span></b></td>
							<td><b>Net Amount</b></td>
							<td><b><span id="total_amount"><?php echo $t_netamount;?>/-</span></b></td>
							<td><b>Total Tax</b></td>
							<td><b><span id="total_tax_amount"><?php echo $t_tax;?>/-</span></b></td>
						</tr>
						<?php }?>
						</table>
						
					</div>
					
				</div>

					
	<div class="form_design">
		<div class="ui buttons">
	  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui positive button">Update</button>
		</div>
	</div>
		
</form>
<?php endforeach;?>
				
				
				
				
				
			