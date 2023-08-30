 <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>

<script type="text/javascript">

	$(document).ready(function() {

		$("#loading").hide(); $("#cover").hide();
		
		// ------------------------------------------
		$("#invoice_no").autocomplete("<?php echo base_url('index.php/ajax/ar_invoice_no');?>", {selectFirst: true});
		$("#order_no").autocomplete("<?php echo base_url('index.php/ajax_springtube/spring_so_no');?>", {selectFirst: true});

		$("#tr_invoice").hide();
		$("#tr_order").hide();
		$("#tr_article_no").hide();
		$("#tr_invoice_tubes_checked").hide();
		$("#tr_order_tubes_hold").hide();

		$("#pallets").hide();
		$("#boxes").hide();
		//alert($("#complaint_source").val());
		// AFTER POST-------------------------------
		if($("#complaint_source").val()=="1"){
   			$("#tr_invoice").show();
   			$("#tr_article_no").show();
			$("#tr_order").hide();
			$("#order_no").val('');	   			
   		}else if($("#complaint_source").val()=="0"){
	   		$("#invoice_no").val('');
	   		$("#tr_article_no").show();
   			$("#tr_invoice").hide();
			$("#tr_order").show();
   		}else{
   			$("#invoice_no").val('');
	   		$("#order_no").val('');
	   		$("#tr_article_no").hide();
   			$("#tr_invoice").hide();
			$("#tr_order").hide();
			$("#tr_invoice_tubes_checked").hide();
			$("#tr_order_tubes_hold").hide();

   		}

   		if($('#order_no').val()!=''){

   			$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax_springtube/order_article_no",data: { order_no : $('#order_no').val()},cache: false,success: function(html){
			    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
			    		//alert(html);
				    	if(html!=''){
				    		$("#tr_article_no").show();
				    		$("#sp_article_no").html(html);
				    	}	
			       		
			    	} 
			});

   		}


   		if($('#invoice_no').val()!=''){

   			$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax_springtube/invoice_article_no",data: { invoice_no : $('#invoice_no').val(), article_no :  $('#article_no').val()},cache: false,success: function(html){
			    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
		    		//alert(html);
			    	if(html!=''){
			    		$("#tr_article_no").show();
			    		$("#sp_article_no").html(html);
			    	}	
			       		
			    } 
			});
   		}
   	

   		//--------------------------------------------------------------------
   		

		$("#complaint_source").change(function() {  	    
	   		var complaint_source = $(this).find(':selected').val();
	   		//alert(complaint_source);
	   		if(complaint_source=="1"){
	   			$("#tr_invoice").show();
	   			//$("#tr_article_no").show();
	   			$("#tr_invoice_tubes_checked").show();
	   			$("#order_no").val('');
	   			$("#sp_article_no").html('');
				$("#tr_order").hide();
				$("#tr_order_tubes_hold").hide();	   				   			
	   		}else if(complaint_source=="0"){
	   			$("#invoice_no").val('');
	   			$("#tr_invoice").hide();
	   			$("#tr_invoice_tubes_checked").hide();
				$("#tr_order").show();
				$("#tr_order_tubes_hold").show();
				$("#sp_article_no").html('');	   				   			
	   		}else{
	   			$("#invoice_no").val('');
	   			$("#order_no").val('');
	   			$("#tr_invoice").hide();
				$("#tr_order").hide();
				$("#tr_article_no").hide();
				$("#tr_invoice_tubes_checked").hide();
				$("#tr_order_tubes_hold").hide();
				$("#sp_article_no").html('');

	   		}
	   	});	

	   	$("#is_box_checked").click(function(){

	   		if($(this).is(":checked")){
	   			$("#boxes").show();
	   		}else{
	   			$("#boxes").hide();
	   		}

	   	});

	   	$("#is_pallet_checked").click(function(){

	   		if($(this).is(":checked")){
	   			$("#pallets").show();
	   		}else{
	   			$("#pallets").hide();
	   		}

	   	});

	   	$("#order_no").bind('keyup blur',function() {
			$("#loading").hide(); $("#cover").hide();
		   var order_no = $('#order_no').val();
		   var order_no_length=order_no.length;

		   		$("#order_article_no").html('');
			   	$("#loading").show();
				$("#cover").show();
				$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			   $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax_springtube/order_article_no",data: { order_no : $('#order_no').val()},cache: false,success: function(html){
			    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
			    		//alert(html);
				    	if(html!=''){
				    		$("#tr_article_no").show();
				    		$("#sp_article_no").html(html);
				    	}	
			       		
			    	} 
			    });

   		});

   		$("#invoice_no").bind('keyup blur',function() {
			$("#loading").hide(); $("#cover").hide();
		   var invoice_no = $('#invoice_no').val();
		   var invoice_no_length=invoice_no.length;

		   		$("#invoice_article_no").html('');
			   	$("#loading").show();
				$("#cover").show();
				$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			   $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax_springtube/invoice_article_no",data: { invoice_no : $('#invoice_no').val()},cache: false,success: function(html){
			    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
			    		//alert(html);
				    	if(html!=''){
				    		$("#tr_article_no").show();
				    		$("#sp_article_no").html(html);
				    	}	
			       		
			    	} 
			    });

   		});


	});
</script>


<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save');?>" method="POST" enctype="multipart/form-data"  >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>

		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner" >
						<tr>
							<td class="label">Email Date<span style="color:red;">*</span> :</td>
							<td>
								<input type="date" name="email_date" id="email_date" value="<?php echo set_value('email_date');?>"/>
								&nbsp;&nbsp;&nbsp;
								Complaint Source <span style="color:red;">*</span> 
								<select name="complaint_source" id="complaint_source">
									<option value="">Select Source</option>
									<option value="0" <?php echo set_select('complaint_source',0);?> >Internal</option>
									<option value="1" <?php echo set_select('complaint_source',1);?> >External</option>
								</select>
							</td>	
						</tr>
						<tr id="tr_invoice">
							<td class="label">Invoice No<span style="color:red;">*</span> :</td>
							<td><input type="text" name="invoice_no" id="invoice_no" value="<?php echo set_value('invoice_no');?>" placeholder="Enter Invoice No." />
							</td>
						</tr>
						<tr id="tr_order">
							<td class="label">Order No <span style="color:red;">*</span> :</td>
							<td><input type="text" name="order_no" id="order_no" value="<?php echo set_value('order_no');?>" placeholder="Enter Order No."/>
							</td>
							
						</tr>
						<tr id="tr_article_no">
							<td class="label">Article No <span style="color:red;">*</span> :</td>
							<td colspan="2">
								<span id="sp_article_no" style="font-size:12px;color:black;"></span>	
							</td>
						</tr>

						<tr>
							<td class="label">Claim Inspection <span style="color:red;">*</span> :</td>
							<td>
								<select name="claim_inspection" id="claim_inspection">
									<option value="">Select Claim Inspection</option>
									<option value="1" <?php echo set_select('claim_inspection',1);?> >Incoming</option>
									<option value="2" <?php echo set_select('claim_inspection',2);?> >Online</option>
								</select>
							</td>							
						</tr>

						<tr id="tr_invoice_tubes_checked">
							<td class="label">Tubes Checked <span style="color:red;">*</span> :</td>
							<td><input type="number" name="invoice_tubes_checked" id="invoice_tubes_checked" value="<?php echo set_value('invoice_tubes_checked');?>" placeholder="Enter No of tubes checked." min="0" max="1000000" step="1"/>
							</td>
							 	
						</tr>
						<tr id="tr_order_tubes_hold">
							<td class="label">Tubes Hold<span style="color:red;">*</span> :</td>
							<td><input type="number" name="order_tubes_hold" id="order_tubes_hold" value="<?php echo set_value('order_tubes_hold');?>" placeholder="Enter No. of tubes hold" min="0" max="1000000" step="1"/>
							</td>										 
							
						</tr>
						<tr>
							<td class="label">Defective Tubes<span style="color:red;">*</span> :</td>
							<td><input type="number" name="defective_tubes" name="defective_tubes" value="<?php echo set_value('defective_tubes');?>" placeholder="No. Of Defective Tubes" min="1" max="1000000" step="1"/>		
							</td>
							
						</tr>
						<tr>
							<td class="label">Pallets Checked</td>
							<td>
								<input type="checkbox" name="is_pallet_checked"  id="is_pallet_checked" value="1" <?php echo set_checkbox('is_pallet_checked',1,false);?> /> 
								<input type="number" name="pallets" id="pallets" min="0" max="1000" step="1"  value="<?php echo set_value('pallets');?>"  Placeholder="No. Of Pallets"/>
							</td>
						</tr>
						<tr>
							<td class="label" >Box Checked </td>
							<td>
								<input type="checkbox" name="is_box_checked" id="is_box_checked" value="1" <?php echo set_checkbox('is_box_checked',1,false);?> />
								<input type="number" name="boxes" id="boxes" min="0" max="1000" step="1"  value="<?php echo set_value('boxes');?>" Placeholder="No. Of Boxes"/></td>

						</tr>						 
						<tr>
							<td class="label">Evidence<span style="color:red;">*</span> :</td>
							<td><input type="file" multiple="" name="images[]" ></td>
						</tr>											
				</table>
				</td>
				
				<td  width="50%">
					<table class="form_table_inner" >
						<tr>
							<td class="label">Nature of complaint <span style="color:red;">*</span>:</td>
							<td><select name="complaint_nature[]" id="complaint_nature[]" multiple="true" size="17" >
								<!--<option value=''>--Select Nature Of Complaint--</option>-->
							<?php if($capa_complaint_nature_master==FALSE){
									echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach($capa_complaint_nature_master as $capa_complaint_nature_master_row){

										$selected=(!empty($this->input->post('complaint_nature[]'))?(in_array($this->input->post('complaint_nature[]'),$capa_complaint_nature_master_row->complaints,TRUE)?"selected":""):"");
										echo "<option value='".$capa_complaint_nature_master_row->complaints."'  ".set_select('complaint_nature[]',''.$capa_complaint_nature_master_row->complaints.'')." ".$selected.">".ucfirst(strtolower($capa_complaint_nature_master_row->category))."-".$capa_complaint_nature_master_row->complaints."</option>";
									}
							}?>
							</select></td>
						</tr>
						<tr>
							<td class="label">Shift :</td>
							<td>
								<select name="shift" id="shift">
									<option value=''>--Select Shift--</option>
									<?php if($springtube_shift_master==FALSE){
											echo "<option value=''>--Setup Required--</option>";
										}
										else{
											foreach($springtube_shift_master as $shift_row){
												echo "<option value='".$shift_row->shift_id."'  ".set_select('shift',''.$shift_row->shift_id.'').">".$shift_row->shift_name."</option>";
											}
									}?>
								</select>
							</td>
						</tr>
						<tr>
							<td class="label">Machine :</td>
							<td>
								<select name="machine" id="machine" >
									<option value=''>--Select Machine--</option>
								<?php if($coex_machine_master==FALSE){
									echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach($coex_machine_master as $coex_machine_master_row){

										echo "<option value='".$coex_machine_master_row->machine_id."'  ".set_select('machine',''.$coex_machine_master_row->machine_id.'').">".$coex_machine_master_row->machine_name."</option>";
									}
							}?>
							</td>
						</tr>

						<tr >
							<td class="label">Responsible Person:</td>
							<td><input type="text" name="operator" id="operator" value="<?php echo set_value('operator');?>"/>
							</td>
							
						</tr>
											
						<tr>
							<td class="label">Comment <span style="color:red;">*</span> :</td>
							<td><textarea name="comment"  rows="10" cols="60" value="<?php echo set_value('comment');?>" placeholder="Enter the comment"><?php echo set_value('comment');?></textarea></td>
						</tr>
					</table>
				</td>
				
			</tr>
						
		</table>	

	 
	<div class="middle_form_design">

		<div class="ui buttons">
		  <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
		  <div class="or"></div>
		  <button class="ui positive button" id="btnsubmit" onClick="return confirm('Are you sure to save record!');">Save</button>
		<!-- <input type="submit" class="ui positive button" value="Save"/>-->
		</div>
	

	</div>
		
</form>
				
				
				
				
				
			