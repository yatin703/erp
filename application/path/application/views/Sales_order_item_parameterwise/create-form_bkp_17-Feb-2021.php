
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>

<script>
	$(document).ready(function(){

		// $("#reel_length").change(function(){

		// 	if($("#no_of_reels").val()==''){
		// 		alert('Please select No Of Reels');
		// 		$("#no_of_reels").focus();
		// 		return false;

		// 	}

		// 	if($("#reel_length").val()!='' && $("#no_of_reels").val()!=''){

		// 		var jobcard_length=parseInt($("#reel_length").val())*parseInt($("#no_of_reels").val());
		// 		//alert(jobcard_length);
		// 		$("#job_card_length_in_meters").val(jobcard_length);

		// 		$.ajax({type: "POST",
		// 			url: "<?php echo base_url('index.php/ajax_springtube/jobcard_reels_to_qty');?>",
		// 			data: {order_no : $("#order_no").val(),article_no : $("#article_no").val(),reel_length : $("#reel_length").val(),no_of_reels : $("#no_of_reels").val() },
		// 			cache: false,
		// 			success: function(html){
					
		// 			$("#job_card_quantity").val(html);

		// 			},
		// 			beforeSend: function(){
						
		// 				$("#loading").show();
		// 				$("#cover").show();
		// 				$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');	
												
		// 			},
		// 			complete: function(){

		// 				$("#loading").hide();
		// 				$("#cover").hide();
											
		// 			}  
		// 		});

		// 	}
		// });

		// $("#no_of_reels").blur(function(){

		// 	if($("#reel_length").val()==''){
		// 		alert('Please select Reel Length');
		// 		$("#reel_length").focus();
		// 		return false;

		// 	}


		// 	if($("#reel_length").val()!='' && $("#no_of_reels").val()!=''){

		// 		var jobcard_length=parseInt($("#reel_length").val())*parseInt($("#no_of_reels").val());
		// 		//alert(jobcard_length);
		// 		$("#job_card_length_in_meters").val(jobcard_length);

		// 		$.ajax({type: "POST",
		// 			url: "<?php echo base_url('index.php/ajax_springtube/jobcard_reels_to_qty');?>",
		// 			data: {order_no : $("#order_no").val(),article_no : $("#article_no").val(),reel_length : $("#reel_length").val(),no_of_reels : $("#no_of_reels").val() },
		// 			cache: false,
		// 			success: function(html){
					
		// 			$("#job_card_quantity").val(html);

		// 			},
		// 			beforeSend: function(){
						
		// 				$("#loading").show(); 
		// 				$("#cover").show();
		// 				$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');	
												
		// 			},
		// 			complete: function(){

		// 				$("#loading").hide();
		// 				$("#cover").hide();
											
		// 			}  
		// 		});

		// 	}
		// });

		// $("#no_of_reels").live('keyup',function(){

		// 	if($("#reel_length").val()==''){
		// 		alert('Please select Default Reel Length');
		// 		$("#reel_length").focus();
		// 		return false;

		// 	}

		// 	if($("#reel_length").val()!='' && $("#no_of_reels").val()!=''){

		// 		var jobcard_length=parseInt($("#reel_length").val())*parseFloat($("#no_of_reels").val());
		// 		//alert(jobcard_length);
		// 		$("#job_card_length_in_meters").val(jobcard_length);

		// 		$.ajax({type: "POST",
		// 			url: "<?php echo base_url('index.php/ajax_springtube/jobcard_reels_to_qty');?>",
		// 			data: {order_no : $("#order_no").val(),article_no : $("#article_no").val(),reel_length : $("#reel_length").val(),no_of_reels : $("#no_of_reels").val() },
		// 			cache: false,
		// 			success: function(html){
					
		// 			$("#job_card_quantity").val(html);

		// 			},
		// 			beforeSend: function(){
											
		// 				$("#loading").show(); 
		// 				$("#cover").show();
		// 				$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');	
												
		// 			},
		// 			complete: function(){

		// 				$("#loading").hide();
		// 				$("#cover").hide();
											
		// 			}  
		// 		});

		// 	}
		// });

		// $("#job_card_length_in_meters").live('keyup',function(){

		// 	if($("#reel_length").val()==''){
		// 		alert('Please select Default Reel Length');
		// 		$("#reel_length").focus();
		// 		return false;

		// 	}

		// 	if($("#reel_length").val()!='' && $("#job_card_length_in_meters").val()!=''){

		// 		var jobLength= $("#job_card_length_in_meters").val();				
		// 		var reel_length=$("#reel_length").val();
		// 		var no_of_reels=Math.abs(jobLength/reel_length);
		// 		//alert(no_of_reels);
		// 		no_of_reels = no_of_reels.toFixed(2);
		// 		$("#no_of_reels").val(no_of_reels);

		// 		///var jobcard_length=parseInt($("#reel_length").val())*parseFloat($("#no_of_reels").val());
		// 		//alert(jobcard_length);
		// 		//$("#job_card_length_in_meters").val(jobcard_length);

		// 		$.ajax({type: "POST",
		// 			url: "<?php echo base_url('index.php/ajax_springtube/jobcard_reels_to_qty');?>",
		// 			data: {order_no : $("#order_no").val(),article_no : $("#article_no").val(),reel_length : $("#reel_length").val(),no_of_reels : $("#no_of_reels").val() },
		// 			cache: false,
		// 			success: function(html){
					
		// 			$("#job_card_quantity").val(html);

		// 			},
		// 			beforeSend: function(){
											
		// 				$("#loading").show(); 
		// 				$("#cover").show();
		// 				$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');	
												
		// 			},
		// 			complete: function(){

		// 				$("#loading").hide();
		// 				$("#cover").hide();
											
		// 			}  
		// 		});

		// 	}
		// });


		 



	});
</script>	


<?php 
$order_flag=0;
$dispatch_tolerance='';
foreach ($order as $order_row):

	$order_flag=$order_row->order_flag;
	$adr_company_id=$order_row->customer_no;

	$address_master_result=$this->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'adr_company_id',$adr_company_id);

	foreach ($address_master_result as $address_master_row) {
		$dispatch_tolerance=$address_master_row->dispatch_tolerance;
	}

?>




<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save_job_card');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td >
					<table class="form_table_inner">
									<tr>
										<td class="label">Order No <span style="color: red;"><b>*</b></span> :</td>
										<td>
											<input type="hidden" name="order_flag" id="order_flag" value="<?php echo $order_row->order_flag;?>">
											<input type="text" name="order_no" id="order_no"value="<?php echo $order_row->order_no;?>" readonly>
										</td>
									</tr>

									<tr>
										<td class="label">Order Date <span style="color: red;"><b>*</b></span> :</td>
										<td><input type="text" name="order_date" value="<?php echo $order_row->order_date;?>" disabled>
										</td>
									</tr>

									<tr>
										<td class="label">Bill To <span style="color: red;"><b>*</b></span> :</td>
										<td>
											<input type="hidden" name="customer" value="<?php echo $order_row->customer_no;?>">
											<select name="adr_company_id" disabled>
											<?php 
												foreach($customer as $customer_row){
													$selected=($customer_row->adr_company_id==$order_row->customer_no ? 'selected' :'');
            echo "<option value='".$customer_row->name1."//".$customer_row->adr_company_id."//".$customer_row->lang_property_name."' $selected ".set_select('adr_company_id',''.$customer_row->adr_company_id.'').">".$customer_row->name1."//".$customer_row->adr_company_id."//".$customer_row->lang_property_name."</option>";
												}
											?>
										</select></td>
									</tr>
									<tr>
										<td class="label">Ship To   :</td>
										<td><select name="consin_adr_company_id" id="consin_adr_company_id" disabled>
											<option value=''>--Same As Bill To--</option>
											<?php
											foreach ($ship_to as $ship_to_row){
												$selected=($ship_to_row->related_company_id==explode("|",$order_row->consin_adr_company_id)[0] ? 'selected' :'');
            echo "<option value='".$ship_to_row->related_company_id."' ".set_select('consin_adr_company_id',''.$ship_to_row->related_company_id.'').">".$ship_to_row->relate."//".$ship_to_row->related_company_id."//".$ship_to_row->lang_property_name."</option>";
          } ?> 
										</select></td>
									</tr>

									<tr>
										<td class="label">Po No <span style="color: red;"><b>*</b></span> :</td>
										<td><input type="text" name="po_no" value="<?php echo set_value('po_no',$order_row->cust_order_no);?>" disabled/></td>
									</tr>
									
									<tr>
										<td class="label">Po Date <span style="color: red;"><b>*</b></span> :</td>
										<td><input type="date" name="po_date" value="<?php echo set_value('po_date',$order_row->order_date);?>" disabled/></td>
									</tr>

									<tr>
										<td class="label">Export  :</td>
										<td><input type="checkbox" name="export"  value="1" <?php echo set_checkbox('export',1);?> <?php echo ($order_row->for_export==1 ? 'value="1" checked' : 'value="0"');?> disabled/></td>
									</tr>

									<tr>
										<td class="label">For Sample  :</td>
										<td><input type="checkbox" name="for_sampling"  value="1" <?php echo set_checkbox('for_sampling',1);?> <?php echo ($order_row->for_sampling==1 ? 'value="1" checked' : 'value="0"');?> disabled/></td>
									</tr>

									<tr>
											<td class="label">Approval Authority :</td>
											<td><select name="approval_authority" disabled>
												<option value=''>--Select Authority--</option>
												<?php 
													foreach ($approval_authority as $approval_authority_row) {
														$selected=($approval_authority_row->employee_id==$order_row->approved_by ? 'selected' : '' );
													echo "<option value='".$approval_authority_row->employee_id."' $selected ".set_select('approval_authority',$approval_authority_row->employee_id).">".strtoupper($approval_authority_row->username)."</option>";
													}
												?>
											</select></td>
									</tr>


				</table>
			</td>
			<td>
				<table class="form_table_inner">
						<?php foreach($order_details as $order_details_row):?>
							<tr>
										<td class="label">Product Code <span style="color: red;"><b>*</b></span> :</td>
										<td><input type="text" name="article_no" id="article_no" value="<?php echo $order_details_row->article_no;?>" readonly>
										<input type="hidden" name="ord_pos_no" value="<?php echo $order_details_row->ord_pos_no;?>"></td>
							</tr>
							<tr>
										<td class="label">Product Name <span style="color: red;"><b>*</b></span> :</td>
										<td colspan="4"><input type="text" name="article_name" size="75" value="<?php echo $order_details_row->description;?>" disabled></td>
							</tr>

							<tr>
										<td class="label">Spec No <span style="color: red;"><b>*</b></span> :</td>
										<td><input type="text" name="spec_id" value="<?php  echo ($order_details_row->spec_id!='' ? $order_details_row->spec_id."_R".$order_details_row->spec_version_no : '');?>" readonly>
										<input type="hidden" name="spec_no" value="<?php  echo $order_details_row->spec_id;?>">
										<input type="hidden" name="spec_version_no" value="<?php  echo $order_details_row->spec_version_no;?>">
										</td>
										<td>
										<?php
										if(!empty($order_details_row->spec_id)){
											if(substr($order_details_row->spec_id,0,1)=="S"){
											echo ($order_details_row->spec_id!='' ? "<a href='".base_url()."/index.php/specification/view/".$order_details_row->spec_id."/".$order_details_row->spec_version_no."' target='_blank'>".$order_details_row->spec_id."_R".$order_details_row->spec_version_no."</a>" : '');
										}else{
											$bom=array('bom_no'=>$order_details_row->spec_id,
		                                    'bom_version_no'=>$order_details_row->spec_version_no);
		                                	$data['bom']=$this->common_model->select_active_records_where("bill_of_material",$this->session->userdata['logged_in']['company_id'],$bom);
		                                    foreach($data['bom'] as $bom_row){                                          
		                                        echo "<a href='".base_url()."/index.php/bill_of_material/view/".$bom_row->bom_id."' target='blank'>".$order_details_row->spec_id."_".$order_details_row->spec_version_no."</a>";
		                                    	}                                   
		                                	}
		                            	}

										?>
											
									</td>
							</tr>

							<tr>
										<td class="label">Artwork No <span style="color: red;"><b>*</b></span> :</td>
										<td>
											<input type="hidden" name="artwork_no" value="<?php  echo $order_details_row->ad_id;?>">
											<input type="hidden" name="artwork_version_no" value="<?php  echo $order_details_row->version_no;?>">
											<input type="text" name="ad_id" value="<?php echo ($order_details_row->ad_id!='' ? $order_details_row->ad_id."_R".$order_details_row->version_no : '');?>" readonly> 
										
										</td>
										<td>	
										<?php  
										if($order_row->order_flag==1){
											
											echo ($order_details_row->ad_id!='' ? "<a href='".base_url()."/index.php/artwork_springtube/view/".$order_details_row->ad_id."/".$order_details_row->version_no."' target='_blank'>".$order_details_row->ad_id."_R".$order_details_row->version_no."</a>" : '');

										}else{

											echo ($order_details_row->ad_id!='' ? "<a href='".base_url()."/index.php/artwork_new/view/".$order_details_row->ad_id."/".$order_details_row->version_no."' target='_blank'>".$order_details_row->ad_id."_R".$order_details_row->version_no."</a>" : '');

										}
										

										?></td>
							</tr>


							<!-- <tr>
										<td class="label">Order Quantity * :</td>
										<td><input type="text" name="order_qty" id="order_qty" value="<?php echo $this->common_model->read_number($order_details_row->total_order_quantity,$this->session->userdata['logged_in']['company_id']);?>" readonly></td>
							</tr> -->
							<?php
								$dia='';	
								$length='';
								$print_type='';

								$specs['spec_id']=$order_details_row->spec_id;
								$specs['spec_version_no']=$order_details_row->spec_version_no;

								$specs_result=$this->sales_order_book_model->select_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$specs);
								if($specs_result){
										foreach($specs_result as $specs_row){
											$dia=$specs_row->SLEEVE_DIA;
											$length=$specs_row->SLEEVE_LENGTH;
											$print_type=$specs_row->SLEEVE_PRINT_TYPE;

										}
								}else{

									$print_type_artwork='';
									if(!empty($order_details_row->ad_id)){

										$artwork['ad_id']=$order_details_row->ad_id;
										$artwork['version_no']=$order_details_row->version_no;
										$search='';
										$from='';
										$to='';
										$artwork_result=$this->artwork_model->active_record_search_new('artwork_devel_master',$artwork,$search,$from,$to,$this->session->userdata['logged_in']['company_id']);
										
										foreach ($artwork_result as $artwork_row) {
											$print_type_artwork=$artwork_row->print_type;
											
										}
									}

								// Bom Deatils-------------------	

									$bom_data['bom_no']=$order_details_row->spec_id;
									$bom_data['bom_version_no']=$order_details_row->spec_version_no;
						    		$bom_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$bom_data);
						    		$print_type_bom='';

						    		if($bom_result){


						    			$total_microns=0;
						    			foreach($bom_result as $bom_result_row){										
							    			$sleeve_code=$bom_result_row->sleeve_code;
							    			$shoulder_code=$bom_result_row->shoulder_code;
							    			$cap_code=$bom_result_row->cap_code;
							    			$label_code=$bom_result_row->label_code;
							    			$print_type_bom=$bom_result_row->print_type;
							    			$specs_comment=strtoupper($bom_result_row->comment);
						    			}

						    			$sleeve_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$sleeve_code);

							    		foreach($sleeve_code_result as $sleeve_code_row){										
							    			$sleeve_spec_id=$sleeve_code_row->spec_id;
							    			$sleeve_spec_version=$sleeve_code_row->spec_version_no;
							    		}
							    		$specs['spec_id']=$sleeve_spec_id;
										$specs['spec_version_no']=$sleeve_spec_version;

										if(strtoupper(substr($sleeve_code, 0,4))=='LMNF'){

											$specs_result=$this->sales_order_book_model->select_film_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$specs);
											//print_r($specs_result);


											$micron_1=0;
											$micron_2=0;
											$micron_3=0;
											$micron_4=0;
											$micron_5=0;
											$micron_6=0;
											$micron_7=0;


											foreach($specs_result as $specs_row){
											$dia=$specs_row->SLEEVE_DIA;
											$length=$specs_row->SLEEVE_LENGTH;
											$micron_1=$specs_row->FILM_GUAGE_1;
											$micron_2=$specs_row->FILM_GUAGE_2;
											$micron_3=$specs_row->FILM_GUAGE_3;
											$micron_4=$specs_row->FILM_GUAGE_4;
											$micron_5=$specs_row->FILM_GUAGE_5;
											$micron_6=$specs_row->FILM_GUAGE_6;
											$micron_7=$specs_row->FILM_GUAGE_7;
																						

										    }

										$total_microns=$micron_1+$micron_2+$micron_3+$micron_4+$micron_5+$micron_6+$micron_7;


										}else{

											$micron_1=0;
											$micron_2=0;
											$micron_3=0;
											$micron_4=0;
											$micron_5=0;

											$specs_result=$this->sales_order_book_model->select_sleeve_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$specs);
											//print_r($specs_result);

											foreach($specs_result as $specs_row){
											$dia=$specs_row->SLEEVE_DIA;
											$length=$specs_row->SLEEVE_LENGTH;
											$micron_1=$specs_row->SLEEVE_GUAGE;
											$micron_2=$specs_row->SLEEVE_GUAGE_2;
											$micron_3=$specs_row->SLEEVE_GUAGE_3;
											$micron_4=$specs_row->SLEEVE_GUAGE_4;
											$micron_5=$specs_row->SLEEVE_GUAGE_5;
																					

										    }
										$total_microns=$micron_1+$micron_2+$micron_3+$micron_4+$micron_5;

										}									


						    		}

						    		$print_type=($print_type_artwork==''?$print_type_bom:$print_type_artwork);

								}
							?>
							<tr>
										<td class="label">Dia <span style="color: red;"><b>*</b></span> :</td>
										<td><input type="text" name="dia" value="<?php echo $dia;?>" disabled></td>
										<td class="label">Length (MM) <span style="color: red;"><b>*</b></span> :</td>
										<td><input type="text" name="length" value="<?php echo $length;?>" disabled></td>
							</tr>

							<!-- <tr>
										<td class="label">Length * :</td>
										<td><input type="text" name="length" value="<?php echo $length;?>" disabled></td>
							</tr> -->

							<tr>
										<td class="label">Print Type <span style="color: red;"><b>*</b></span> :</td>
										<td><input type="text" name="print_type" value="<?php echo $print_type;?>" disabled></td>

										<td class="label">Total Microns (MM) <span style="color: red;"><b>*</b></span> :</td>
										<td><input type="text" name="total_microns" value="<?php echo $total_microns;?>" disabled></td>
							</tr>
							<!-- <tr>
										<td class="label">Total Microns :</td>
										<td><input type="text" name="total_microns" value="<?php echo $total_microns;?>" disabled></td>
							</tr> -->

							<tr>
								<td class="label">Order Quantity <span style="color: red;"><b>*</b></span> :</td>
								<td><input type="text" name="order_qty" id="order_qty" value="<?php echo $this->common_model->read_number($order_details_row->total_order_quantity,$this->session->userdata['logged_in']['company_id']);?>" readonly>
								</td>
							

								<td class="label">Customer Dispatch Tolerance % : </td>
									<td><input type="text" name="dispatch_tolerance" id="dispatch_tolerance" value="<?php echo $dispatch_tolerance;?>" disabled />
								</td>
							</tr>	

							<!-- <tr>
								<td class="label">Customer Dispatch Tolerance % :</td>
								<td><input type="text" name="dispatch_tolerance" id="dispatch_tolerance" value="<?php echo $dispatch_tolerance;?>" disabled /></td>

							</tr> -->


						<?php if($order_flag=='0'){?>

							<tr>
								<td class="label">Job Card Quantity <span style="color: red;"><b>*</b></span> :</td>
								<td><input type="text" name="job_card_quantity" value="<?php echo set_value('job_card_quantity');?>"></td>
							</tr>

						<?php }else{

								if(substr($order_row->order_no,0,2)=='ST'){
									$printing_rejection_perc=0;
									$bodymaking_rejection_perc=0;
								}else{

									$printing_rejection_perc=15;
									$bodymaking_rejection_perc=15;
								}

						 ?>

							<tr>
								<td class="label">Printing Rejection % :</td>
								<td><input type="text" name="printing_rejection" id="printing_rejection" value="<?php echo set_value('printing_rejection',$printing_rejection_perc);?>" readonly></td>

								<td class="label">Bodymaking Rejection % :</td>
								<td><input type="text" name="bodymaking_rejection" id="bodymaking_rejection" value="<?php echo set_value('bodymaking_rejection',$bodymaking_rejection_perc);?>" readonly></td>
							</tr>
							<!-- <tr>
								<td class="label">Bodymaking Rejection % :</td>
								<td><input type="text" name="bodymaking_rejection" id="bodymaking_rejection" value="<?php echo set_value('bodymaking_rejection',15);?>" readonly></td>
							</tr> -->

							<tr>
								<td class="label">Job Card Quantity * :</td>
								<td><input type="text" name="job_card_quantity" id="job_card_quantity"value="<?php echo set_value('job_card_quantity');?>"></td>

								<td class="label">Job Card Length in Meters * :</td>
								<td><input type="text" name="job_card_length_in_meters" id="job_card_length_in_meters"value="<?php echo set_value('job_card_length_in_meters');?>" readonly></td>
							</tr>
							<!-- <tr>
								<td class="label">Job Card Length in Meters * :</td>
								<td><input type="text" name="job_card_length_in_meters" id="job_card_length_in_meters"value="<?php echo set_value('job_card_length_in_meters');?>" readonly></td>
							</tr> -->
							<tr>
								<td class="label">Default Reel Length in Meters * :</td>
								<td><select name="reel_length" id="reel_length" required>
									<option value="">--Please select--</option>
									<option value="600" <?php echo set_select('reel_length','600');?>>600</option>
									<!-- <option value="700" <?php echo set_select('reel_length','700');?>>700</option> -->
									<option value="800" <?php echo set_select('reel_length','800');?>>800</option>
									<!-- <option value="900" <?php echo set_select('reel_length','900');?>>900</option>
									<option value="1000" <?php echo set_select('reel_length','1000');?>>1000</option>
									 --></select>

								</td>

								<td class="label">No of Reels * :</td>
								<td><input type="text" name="no_of_reels" id="no_of_reels" value="<?php echo set_value('no_of_reels');?>" readonly></td>
							</tr>

							<!-- <tr>
								<td class="label">No of Reels * :</td>
								<td><input type="text" name="no_of_reels" id="no_of_reels" value="<?php echo set_value('no_of_reels');?>" readonly></td>
							</tr> -->
							
							<!-- <tr>
								<td class="label">Job Card Length in Meters * :</td>
								<td><input type="text" name="job_card_length_in_meters" id="job_card_length_in_meters"value="<?php echo set_value('job_card_length_in_meters');?>"></td>
							</tr> -->
							<!-- <tr>
								<td class="label">Job Card Quantity * :</td>
								<td><input type="text" name="job_card_quantity" id="job_card_quantity"value="<?php echo set_value('job_card_quantity');?>"></td>
							</tr> -->

						<?php } ?>	
							<?php endforeach;?>
				</table>

			</td>

		</tr>
	</table>
	</div>


					
	<div class="form_design">
		<div class="ui buttons">
	  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui positive button">Create Job Card</button>
		</div>
	</div>

	<script type="text/javascript">
		
		$(document).ready(function(){

			if($("#order_flag").val()==1){

				$("#job_card_quantity").attr("readonly",true);

				var extra_qty=0;
				var jobcard_qty=0;
				var dispatch_tolerance=0;

				if($("#dispatch_tolerance").val()!=''){
					dispatch_tolerance=parseInt($("#dispatch_tolerance").val());
				}

				var order_qty=parseInt($("#order_qty").val());				 				
				var printing_rejection=parseInt($("#printing_rejection").val());
				var bodymaking_rejection=parseInt($("#bodymaking_rejection").val());

				var jobcard_perc=dispatch_tolerance+printing_rejection+bodymaking_rejection;
				//alert(jobcard_perc);
				extra_qty=Math.round(order_qty*jobcard_perc/100);
				jobcard_qty=order_qty+extra_qty;

				$("#job_card_quantity").val(jobcard_qty);

				if($("#job_card_quantity").val()!='' || $("#job_card_quantity").val()!=0) {


					$.ajax({type: "POST",
						url: "<?php echo base_url('index.php/ajax_springtube/jobcard_qty_to_meters_by_so');?>",
						data: {order_no : $("#order_no").val(),article_no : $("#article_no").val(),release_qty : $("#job_card_quantity").val() },
						cache: false,
						success: function(html){
							//alert(html);
						
						$("#job_card_length_in_meters").val(html);

						},
						beforeSend: function(){
							
							$("#loading").show();
							$("#cover").show();
							$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');	
													
						},
						complete: function(){

							$("#loading").hide();
							$("#cover").hide();
												
						}  
					});


				}


				$("#reel_length").change(function(){

					if($("#reel_length").val()!=''){

						var reel_length=parseInt($("#reel_length").val());
						var job_card_length_in_meters=parseInt($("#job_card_length_in_meters").val());

						var no_of_reels=Math.abs(job_card_length_in_meters/reel_length);

						$("#no_of_reels").val(no_of_reels.toFixed(2));

					}else{

						$("#no_of_reels").val('');
					}


				});


			}else{

				$("#job_card_quantity").attr("readonly",false);
			}



		});


	</script>
		
</form>
<?php endforeach;?>
				
				
				
				
				
			