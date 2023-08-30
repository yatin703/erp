<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<style type="text/css">
		/*body{
			margin-top: 100px;
			font-family: 'Trebuchet MS', serif;
			line-height: 1.6
		}*/
		.container{
			/*width: 800px;*/
			margin: 0 auto;
		}
		ul.tabs{
			margin: 0px;
			padding: 0px;
			list-style: none;
		}
		ul.tabs li{
			background: none;
			/*color: #222;*/
			color:#4183c4;
			display: inline-block;
			padding: 10px 15px;
			cursor: pointer;
			border-right: 1px solid #8cacbb;
			border-left: 1px solid #8cacbb; 
			border-top: 1px solid #8cacbb;
			border-bottom: 1px solid #8cacbb;   
		}

		ul.tabs li.current{
			/*background: #ededed;*/
			background: #dee7ec;
			/*color: #222;*/
			color:#4183c4;
		}

		.tab-content{
			display: none;
			/*background: #ededed;*/
			background: #ededed;
			padding: 15px;
		}

		.tab-content.current{
			display: inherit;
			/*width:100%;*/
		}
		/*textarea{
			width:375px;
			height:60px;
		}*/

		input[type=number]{
    	width: 150px;
		}
</style>

<style type="text/css">
        table{
            border:1px solid #D9d9d9;
            border-collapse: collapse;
            /*text-align: left;*/
            /*cellpadding="5" cellspacing="0" style="border:1px solid #D9d9d9;border-collapse: collapse;"*/
        }
        td,th{
             
            text-align: left;
            

        }
</style>
<script type="text/javascript">

	$(document).ready(function() {

		$("#loading").hide(); $("#cover").hide();

		// $('ul.tabs li').click(function(){

		// 	var tab_id = $(this).attr('data-tab');

		// 	$('ul.tabs li').removeClass('current');
		// 	$('.tab-content').removeClass('current');

		// 	$(this).addClass('current');
		// 	$("#"+tab_id).addClass('current');
		// });


		// ------------------------------------------
		$("#invoice_no").autocomplete("<?php echo base_url('index.php/ajax/ar_invoice_no');?>", {selectFirst: true});
		$("#order_no").autocomplete("<?php echo base_url('index.php/ajax_springtube/spring_so_no');?>", {selectFirst: true});

		$("#tr_invoice").hide();
		$("#tr_order").hide();
		$("#pallets").hide();
		$("#boxes").hide();
		//alert($("#complaint_source").val());
		// AFTER POST-------------------------------
		if($("#complaint_source").val()=="1"){
   			$("#tr_invoice").show();
			$("#tr_order").hide();	   			
   		}else if($("#complaint_source").val()=="0"){
   			$("#tr_invoice").hide();
			$("#tr_order").show();
   		}else{
   			$("#tr_invoice").hide();
			$("#tr_order").hide();
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
				$("#tr_order").hide();	   			
	   		}else if(complaint_source=="0"){
	   			$("#tr_invoice").hide();
				$("#tr_order").show();
	   		}else{
	   			$("#tr_invoice").hide();
				$("#tr_order").hide();
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
					<td width="40%">		 
						<!-- <div class="container">

							<ul class="tabs">
								<li class="tab-link current" data-tab="tab-1">Sales</li>
								<li class="tab-link" data-tab="tab-2">QC</li>
								
							</ul>								
							TAB SALES
							<div id="tab-1" class="tab-content current"> -->

								<table class="form_table_inner">
									<tr>
										<td >

											<table class="form_table_inner" >
												<tr>
													<td class="label">Complaint Source <span style="color:red;">*</span> :</td>
													<td>
														<input type="hidden" name="id" value="<?php echo set_value('id',$row->id);?>" readonly>
														<select name="complaint_source" id="complaint_source">
															<option value="">Select Complaint Source</option>
															<option value="0" <?php echo set_select('complaint_source',$row->complaint_source);?> <?php echo($row->complaint_source=='0'?'selected':'');?> >Internal</option>
															<option value="1" <?php echo set_select('complaint_source',$row->complaint_source);?> <?php echo($row->complaint_source=='1'?'selected':'');?> >External</option>
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
												<tr>
													<td class="label">Defective Tubes<span style="color:red;">*</span> :</td>
													<td><input type="number" name="defective_tubes" name="defective_tubes" value="<?php echo set_value('defective_tubes', $row->defective_tubes);?>" placeholder="No. Of Defective Tubes" min="1" max="1000000" step="1"/>		
													</td>
													
												</tr>
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
													<td class="label">Comment <span style="color:red;">*</span> :</td>
													<td><textarea name="comment" maxlength="256" rows="3" cols="40" value="<?php echo set_value('comment');?>" placeholder="Enter the comment"><?php echo set_value('comment',$row->comment);?></textarea></td>
												</tr>
												<tr><td class="label" >
													<b>Pallets Checked</b> &nbsp; <input type="checkbox" name="is_pallet_checked"  id="is_pallet_checked" value="1" <?php echo set_checkbox('is_pallet_checked',$row->is_pallet_checked,($row->is_pallet_checked==1?true:false));?> /> </td>
													<td>
														<input type="number" name="pallets" id="pallets" min="0" max="1000" step="1"  value="<?php echo set_value('pallets',$row->pallets);?>"  Placeholder="No. Of Pallets"/>
													</td>
												</tr>
												<tr><td class="label" >
													<b>Box Checked</b> &nbsp; <input type="checkbox" name="is_box_checked" id="is_box_checked" value="1" <?php echo set_checkbox('is_box_checked',$row->is_box_checked,($row->is_box_checked==1?true:false));?> /> 
												</td>
													<td><input type="number" name="boxes" id="boxes" min="0" max="1000" step="1"  value="<?php echo set_value('boxes',$row->boxes);?>" Placeholder="No. Of Boxes"/></td>

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
												<tr>
													<td class="label">Complaint Status <span style="color:red;">*</span> :</td>
													<td>
														<select name="complaint_status" id="complaint_status">
															<option value="">Select Complaint Status</option>
															<option value="0" <?php echo set_select('complaint_status',0);?> <?php echo ($row->complaint_status==0?'selected':'');?> >Rejected</option>
															<option value="1" <?php echo set_select('complaint_status',1);?> <?php echo ($row->complaint_status==1?'selected':'');?>>Accepted</option>
														</select>
													</td>
													
												</tr> 
											</table>											
												 
										</td>
									</tr>
								</table>

										

							<!-- </div>

							TAB QC

							<div id="tab-2" class="tab-content"> -->


					</td>
					<!-- <td>			

						<table class="form_table_inner">
									<tr>
										<td width="100%">

											<table class="form_table_inner">
												<tr>
													<td class="label">Hourly Samples check <span style="color:red;">*</span> :</td>
													<td>
														<select name="hourly_samples_check" required>							
															<option value="1" <?php echo set_select('hourly_samples_check','1');?>>YES</option>
															<option value="0" <?php echo set_select('hourly_samples_check','0');?>>NO</option>		 
														</select>
													</td>
												</tr>

												<tr>
													<td class="label">Retention Samples check <span style="color:red;">*</span> :</td>
													<td>
														<select name="retention_samples_check" required>							
															<option value="1" <?php echo set_select('retention_samples_check','1');?>>YES</option>
															<option value="0" <?php echo set_select('retention_samples_check','0');?>>NO</option>		 
														</select>
													</td>
												</tr>
												<tr>
													<td class="label">BPR Check <span style="color:red;">*</span> :</td>
													<td>
														<select name="bpr_check" required>							
															<option value="1" <?php echo set_select('bpr_check','1');?>>YES</option>
															<option value="0" <?php echo set_select('bpr_check','0');?>>NO</option>		 
														</select>
													</td>
												</tr>
												<tr>
													<td class="label">Samples Recieved <span style="color:red;">*</span> :</td>
													<td>
														<select name="samples_recieved" required>							
															<option value="1" <?php echo set_select('samples_recieved','1');?>>YES</option>
															<option value="0" <?php echo set_select('samples_recieved','0');?>>NO</option>		 
														</select>
													</td>
												</tr>
												<tr>
													<td class="label">Stage Problem Occurance <span style="color:red;">*</span> :</td>
													<td>
														<select name="stage_problem_occurance" required>							
															<option value="1" <?php echo set_select('stage_problem_occurance','1');?>>YES</option>
															<option value="0" <?php echo set_select('stage_problem_occurance','0');?>>NO</option>		 
														</select>
													</td>
												</tr>

												<tr>
													<td class="label">Any Known Problem <span style="color:red;">*</span> :</td>
													<td>
														<select name="any_known_problem" required>							
															<option value="1" <?php echo set_select('any_known_problem','1');?>>YES</option>
															<option value="0" <?php echo set_select('any_known_problem','0');?>>NO</option>		 
														</select>
													</td>
												</tr>
												<tr>
													<td class="label">Investigation <span style="color:red;">*</span> :</td>
													<td><textarea name="investigation" maxlength="256" rows="3" cols="40" value="<?php echo set_value('investigation');?>"><?php echo set_value('investigation');?></textarea></td>
												</tr>
												<tr>
													<td class="label">Root Cause <span style="color:red;">*</span> :</td>
													<td><textarea name="root_cause" maxlength="256" rows="3" cols="40" value="<?php echo set_value('root_cause');?>"><?php echo set_value('root_cause');?></textarea></td>
												</tr>
												<tr>
													<td class="label">Corrective Action <span style="color:red;">*</span> :</td>
													<td><textarea name="corrective_action" maxlength="256" rows="3" cols="40" value="<?php echo set_value('corrective_action');?>"><?php echo set_value('corrective_action');?></textarea></td>
												</tr>
												<tr>
													<td class="label">Preventive Action <span style="color:red;">*</span> :</td>
													<td><textarea name="preventive_action" maxlength="256" rows="3" cols="40" value="<?php echo set_value('preventive_action');?>"><?php echo set_value('root_cause');?></textarea></td>
												</tr>
												<tr><td class="label" >
													<input type="checkbox" name="is_training_provided" value="1" <?php echo set_checkbox('is_training_provided',1,false);?>  > <b>Training Provided</b></td>
													<td><input type="date" name="training_date" id="training_date"   value="<?php echo set_value('training_date');?>"   /></td>
												</tr>
												<tr>
													<td class="label">Time Scale for Verification of Effectiveness <span style="color:red;">*</span> :</td>
													<td>
														<textarea name="verification_of_effectiveness" maxlength="256" rows="3" cols="40" value="<?php echo set_value('verification_of_effectiveness');?>"><?php echo set_value('verification_of_effectiveness');?>
															
														</textarea>
													</td>
												</tr>

												<tr>
													<td class="label">Effectiveness of Action taken <span style="color:red;">*</span> :</td>
													<td>
														<textarea name="effectiveness_action_taken" maxlength="256" rows="3" cols="40" value="<?php echo set_value('effectiveness_action_taken');?>"><?php echo set_value('effectiveness_action_taken');?>
														</textarea>
													</td>
												</tr>

												<tr>
													<td class="label">Cost of Poor Quality <span style="color:red;">*</span> :</td>
													<td><input type="number"  name="poor_quality_cost" name="poor_quality_cost" min="0" max="10000000" step="any"/>
														
													</td>
													
												</tr>

											</table>	
												 
										</td>
									</tr>
							

						</table>
							</div>


						</div>container

					</td> -->

					<td>
						<table>
							<tr>
								<td>
									<span id="sp_article_no">
										
										<?php if($article_no_result==TRUE){

											
											$arr_article_no=explode(",",$row->article_no);

											//print_r($arr_article_no);
											foreach ($article_no_result as $key => $article_no_row){

												if(!empty($this->input->post('article_no[]'))){

													$checked=(in_array($article_no_row->article_no,$this->input->post('article_no[]'),TRUE)?"checked":"");
												}else{

													$checked=(in_array($article_no_row->article_no, $arr_article_no)?"checked":"");
												}


        										echo ' <input type="checkbox" name="article_no[]" id="article_no[]" value="'.$article_no_row->article_no.'" '.$checked.'/> &nbsp;'.$article_no_row->article_no.'</br>';
											}
												
											
										}

										?>
									</span>	
								</td>
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
				
				
				
				
				
			