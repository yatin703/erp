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
   			$("#tr_invoice_tubes_checked").show();
			$("#tr_order").hide();
			$("#tr_order_tubes_hold").hide();

   		}else if($("#complaint_source").val()=="0"){
   			$("#tr_invoice").hide();
   			$("#tr_invoice_tubes_checked").hide();
			$("#tr_order").show();
			$("#tr_article_no").show();
			$("#tr_order_tubes_hold").show();
   		}else{
   			$("#tr_invoice").hide();
			$("#tr_order").hide();
			$("#tr_article_no").hide();
			$("#tr_invoice_tubes_checked").hide();
			$("#tr_order_tubes_hold").hide();
			 

   		}


   		/*if($('#order_no').val()!=''){

   			$.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax_springtube/order_article_no",data: { order_no : $('#order_no').val()},cache: false,success: function(html){
			    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
			    		//alert(html);
				    	if(html!=''){
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
			    		$("#sp_article_no").html(html);
			    	}	
			       		
			    } 
			});
   		}

   		*/


   		//alert($('#is_box_checked').is(':checked'));

   		if($("#is_box_checked").is(":checked")){
   			$("#boxes").show();
   		}else{
   			$("#boxes").hide();
   		}
   		if($("#is_pallet_checked").is(":checked")){
   			$("#pallets").show();
   		}else{
   			$("#pallets").hide();
   		}

	   	

   		//--------------------------------------------------------------------
   		

		$("#complaint_source").change(function() {  	    
	   		var complaint_source = $(this).find(':selected').val();
	   		//alert(complaint_source);
	   		if(complaint_source=="1"){
	   			$("#tr_invoice").show();
	   			$("#tr_invoice_tubes_checked").show();
				$("#tr_order").hide();
				$("#tr_order_tubes_hold").hide();	   				   			
	   		}else if(complaint_source=="0"){
	   			$("#tr_invoice").hide();
	   			$("#tr_invoice_tubes_checked").hide();
				$("#tr_order").show();
				$("#tr_order_tubes_hold").show();	   				   			
	   		}else{
	   			$("#tr_invoice").hide();
				$("#tr_order").hide();
				$("#tr_invoice_tubes_checked").hide();
				$("#tr_order_tubes_hold").hide();
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

	   	$("#order_no").bind('blur',function() {
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

   		$("#invoice_no").bind('blur',function() {
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


<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST" enctype="multipart/form-data"  >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>

		<?php foreach ($capa_complaint_register_master	 as $key => $row):?> 

			<table class="form_table_design">
				<tr>
					<td width="50%">
						<table class="form_table_inner" >
							<tr>
								<td class="label">Email Date<span style="color:red;">*</span> :</td>
								<td>
									<input type="hidden" name="id" value="<?php echo set_value('id',$row->id);?>" readonly>
									<input type="date" name="email_date" id="email_date" value="<?php echo set_value('email_date',$row->email_date);?>"/>
									&nbsp;&nbsp; Complaint Source <span style="color:red;">*</span>
									<select name="complaint_source" id="complaint_source">
										<option value="" >Select Complaint Source</option>
										<option value="0" <?php echo($row->complaint_source=='0'?'selected':'');?> >Internal</option>
										<option value="1" <?php echo($row->complaint_source=='1'?'selected':'');?> >External</option>
									</select>
								</td>
								 	
							</tr>
							 
							<tr id="tr_invoice">
								<td class="label">Invoice No.<span style="color:red;">*</span> :</td>
								<td><input type="text" name="invoice_no" id="invoice_no" value="<?php echo set_value('invoice_no',($row->complaint_source==1?$row->reference_no:''));?>" placeholder="Enter Invoice No." />
								</td>
								<!-- <td>
									<span id="invoice_article_no"></span> 
								</td> -->	
							</tr>
							<tr id="tr_order">
								<td class="label">Order No.<span style="color:red;">*</span> :</td>
								<td><input type="text" name="order_no" id="order_no" value="<?php echo set_value('order_no',($row->complaint_source==0?$row->reference_no:''));?>" placeholder="Enter Order No."/>
								</td>
								<!-- <td>	
								<span id="order_article_no"></span>		
								</td> -->
								
							</tr>
							<tr id="tr_article_no">
								<td class="label">Article No.<span style="color:red;">*</span> :</td>
								<td colspan="4">
								<span id="sp_article_no" style="font-size:12px;color:black;">

									<table class='ui very basic collapsing celled table' style='font-size:10px;'>
							            <thead>
							               <tr>
							               <th>Select</th>
							               <th>Product Name</th>
							               </tr>
							            </thead>
							            <tbody>
									
									<?php if($article_no_result==TRUE){

										
										$arr_article_no=explode(",",$row->article_no);

										//print_r($arr_article_no);
										foreach ($article_no_result as $key => $article_no_row){

											if(!empty($this->input->post('article_no[]'))){

												$checked=(in_array($article_no_row->article_no,$this->input->post('article_no[]'),TRUE)?"checked":"");
											}else{

												$checked=(in_array($article_no_row->article_no, $arr_article_no)?"checked":"");
											}

											echo'<tr>
												<td>';
    										echo '<input type="checkbox" name="article_no[]" id="article_no[]" value="'.$article_no_row->article_no.'" '.$checked.'/>'; 
    											echo'</td>
    											<td>';
    										echo $this->common_model->get_article_name($article_no_row->article_no,$this->session->userdata['logged_in']['company_id']).'//'.$article_no_row->article_no;
    										echo'</td>
    										</tr>';
										}
											
										
									}

									?>
									</tbody>
								</table>
								</span>	
								</td>
							</tr>

							<tr>
								<td class="label">Claim Inspection <span style="color:red;">*</span> :</td>
								<td>
									<select name="claim_inspection" id="claim_inspection">
										<option value="">Select Claim Inspection</option>
										<option value="1" <?php echo set_select('claim_inspection',1);?> <?php echo ($row->claim_inspection==1?'selected':'');?> >Incoming</option>
										<option value="2" <?php echo set_select('claim_inspection',2);?> <?php echo ($row->claim_inspection==2?'selected':'');?> >Online</option>
									</select>
								</td>
								
							</tr>

							<tr id="tr_invoice_tubes_checked">
								<td class="label">No.Of Tubes Checked.<span style="color:red;">*</span> :</td>
								<td><input type="number" name="invoice_tubes_checked" id="invoice_tubes_checked" value="<?php echo set_value('invoice_tubes_checked',($row->complaint_source==1?$row->tubes_hold_checked:''));?>" placeholder="Enter No of tubes checked." min="0" max="1000000" step="1"/>
								</td>
								 	
							</tr>
							<tr id="tr_order_tubes_hold">
								<td class="label">No.Of Tubes Hold<span style="color:red;">*</span> :</td>
								<td><input type="number" name="order_tubes_hold" id="order_tubes_hold" value="<?php echo set_value('order_tubes_hold',($row->complaint_source==0?$row->tubes_hold_checked:''));?>" placeholder="Enter No. of tubes hold" min="0" max="1000000" step="1"/>
								</td>										 
								
							</tr>
							<tr>
								<td class="label">Defective Tubes<span style="color:red;">*</span> :</td>
								<td><input type="number" name="defective_tubes" name="defective_tubes" value="<?php echo set_value('defective_tubes', $row->defective_tubes);?>" placeholder="No. Of Defective Tubes" min="1" max="1000000" step="1"/>		
								</td>
									
							</tr>
							<tr>
								<td class="label" >
								<b>Pallets Checked</b></td>
								<td>
									<input type="checkbox" name="is_pallet_checked"  id="is_pallet_checked" value="1" <?php echo set_checkbox('is_pallet_checked',$row->is_pallet_checked,($row->is_pallet_checked==1?true:false));?> />
									<input type="number" name="pallets" id="pallets" min="0" max="1000" step="1"  value="<?php echo set_value('pallets',$row->pallets);?>"  Placeholder="No. Of Pallets"/>
								</td>
							</tr>
							<tr>
								<td class="label" >
								<b>Box Checked</b>
							</td>
								<td>
									<input type="checkbox" name="is_box_checked" id="is_box_checked" value="1" <?php echo set_checkbox('is_box_checked',$row->is_box_checked,($row->is_box_checked==1?true:false));?>/>
									<input type="number" name="boxes" id="boxes" min="0" max="1000" step="1"  value="<?php echo set_value('boxes',$row->boxes);?>" Placeholder="No. Of Boxes"/>
								</td>

							</tr>

							<tr>
								<td class="label">Evidence<span style="color:red;">*</span> :</td>
								<td><input type="file" multiple="" name="images[]" >
								<input type="hidden" name="image_name" value="<?php echo set_value('image_name',$row->images);?>">

								<?php 
								if($row->images!=''){
									$img_arr=explode(",",$row->images);
									//print_r($img_arr);
									
									foreach ($img_arr as $key => $image_name) {
										
										echo'<a href="'.base_url('assets/'.$this->session->userdata['logged_in']['company_id'].'/complaints/'.$image_name.'').'" target="_blank"><i class="file pdf outline icon"></i>
										</a>';
									}								
									
								}
								?>
					
								</td>
							</tr>						 
						</table>
					</td>	
					<td >
					<table class="form_table_inner" >						
						<tr>
							<td class="label">Nature Of complaint :</td>
							<td><select name="complaint_nature[]" id="complaint_nature[]" multiple="true" size="9"><option value=''>--Select Nature Of Complaint--</option>
								<?php if($capa_complaint_nature_master==FALSE){
										echo "<option value=''>--Setup Required--</option>";}
									else{
										$arr=explode(",", $row->complaint_nature);
										//print_r($arr);
										foreach($capa_complaint_nature_master as $capa_complaint_nature_master_row){

											if(!empty($this->input->post('complaint_nature[]'))){

												$selected=(in_array($capa_complaint_nature_master_row->complaints,$this->input->post('complaint_nature[]'),TRUE)?"selected":"");

											}else{		

												$selected=(in_array($capa_complaint_nature_master_row->complaints,$arr,TRUE)?"selected":"");
											}
											
											echo "<option value='".$capa_complaint_nature_master_row->complaints."'  ".set_select('complaint_nature[]',''.$capa_complaint_nature_master_row->complaints.'')." ".$selected.">".$capa_complaint_nature_master_row->complaints."</option>";
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
												$selected=($shift_row->shift_id==$row->shift?'selected':'');
												echo "<option value='".$shift_row->shift_id."'  ".set_select('shift',''.$shift_row->shift_id.'')." ".$selected.">".$shift_row->shift_name."</option>";
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
										$selected=($coex_machine_master_row->machine_id==$row->machine?'selected':'');
										echo "<option value='".$coex_machine_master_row->machine_id."'  ".set_select('machine',''.$coex_machine_master_row->machine_id.'')." ".$selected.">".$coex_machine_master_row->machine_name."</option>";
									}
							}?>
							</td>
						</tr>

						<tr >
							<td class="label">Responsible Person:</td>
							<td><input type="text" name="operator" id="operator" value="<?php echo set_value('operator',$row->operator);?>"/>
							</td>
							
						</tr>						
							
						<tr>
							<td class="label">Comment <span style="color:red;">*</span> :</td>
							<td><textarea name="comment" rows="10" cols="60" value="<?php echo set_value('comment');?>" placeholder="Enter the comment"><?php echo set_value('comment',$row->comment);?></textarea></td>
						</tr>
					</table>
				</td>				
			</tr>						
		</table>	




	<?php endforeach;?> 

	<div class="middle_form_design">

		<div class="ui buttons">
		  <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
		  <div class="or"></div>
		  <button class="ui positive button" id="btnsubmit" onClick="return confirm('Are you sure to save record!');">Update</button>
		<!-- <input type="submit" class="ui positive button" value="Save"/>-->
		</div>
	

	</div>
		
</form>
				
				
				
				
				
			