<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){
		//$("#loading").hide(); $("#cover").hide();
		$("#jobcard_no_1").autocomplete("<?php echo base_url('index.php/ajax_springtube/jobcard_printing_inspection_autocomplete');?>", {selectFirst: true});	
		
		$("#jobcard_no_1").bind('keyup blur',function() {
			var jobcard_no = $('#jobcard_no_1').val();
			//alert(jobcard_no);
			if(jobcard_no.length>=15){

				//if(!$("#jobcard_no_1").attr('readonly')){
				   	
				   $.ajax({

					   	type: "POST",
					   	url: "<?php echo base_url();?>/index.php/ajax_springtube/get_printing_quantity",
					   	data: {jobcard_no : $('#jobcard_no_1').val()},
					   	cache: false,
					   	success: function(html){
					    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);

					    		if(html!='0' || html!='' ){
					    			$("#printing_input_qty_1").val(html);
					       			
					    		}else{

					    			$("#printing_input_qty_1").val('');
					    		}
			 
					    },
						beforeSend: function(){
										$("#loading").show();
										$("#cover").show();
										$('#loading').html('<img src="images/loading.gif"> Loading...');	
										
						},
						complete: function(){
						 				$("#loading").hide(); $("#cover").hide();
										
										
						} 
				    });//AJAX Closed
				//}   


		   }else{

		   		$("#printing_input_qty_1").val('');
		   }

   		});

		
		$("#add").live('click',function () {
			var header_row=1;
			var counter=$("#table_article tr").length;
			var mark_up='<tr id="tr_'+ counter +'"><td><input type="hidden" name="sr_no[]" value="'+counter+'"/>JOB '+counter+'</td><td><input type="text" name="jobcard_no_'+counter+'"  id="jobcard_no_'+counter+'" class="quantity" value="<?php echo set_value('jobcard_no_"+counter+"');?>" maxlength="50" size="20" required/></td><td><input type="number" name="printing_input_qty_'+counter+'"  id="printing_input_qty_'+counter+'" class="quantity" value="<?php echo set_value('printing_input_qty_"+counter+"');?>" min="1" max="80000" step="1" size="20" required maxlength="10"/></td><!--<td><input type="number" name="inspected_output_meters_'+counter+'"  id="inspected_output_meters_'+counter+'" class="quantity" value="<?php echo set_value('inspected_output_meters_"+counter+"');?>" min="1" max="80000" step="1" size="20" required maxlength="10"/></td>--><td><input type="number" name="inspected_output_qty_'+counter+'"  id="inspected_output_qty_'+counter+'" class="quantity" value="<?php echo set_value('inspected_output_qty_"+counter+"');?>" min="1" max="80000" step="1" size="20" required maxlength="10"/></td><td><input type="checkbox" name="inspection_done_'+counter+'" value="1" <?php echo set_checkbox('inspection_done_"+counter+"',0,false);?> title="Is complete inspection done for this Jobcard?"/></td></tr>';

				//alert(mark_up);
				$("#table_article").append(mark_up);

				$("#jobcard_no_"+counter).autocomplete("<?php echo base_url('index.php/ajax_springtube/jobcard_printing_inspection_autocomplete');?>", {selectFirst: true});

				$("#jobcard_no_"+counter).bind('keyup blur',function() {

					var jobcard_no = $('#jobcard_no_'+counter).val();
					//alert(jobcard_no);
					if(jobcard_no.length>=15){

						//if(!$("#jobcard_no_1").attr('readonly')){
						   	
						   $.ajax({

							   	type: "POST",
							   	url: "<?php echo base_url();?>/index.php/ajax_springtube/get_printing_quantity",
							   	data: {jobcard_no : $('#jobcard_no_'+counter).val()},
							   	cache: false,
							   	success: function(html){
							    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);

						    		if(html!='0' || html!='' ){
						    			$("#printing_input_qty_"+counter).val(html);
						       			
						    		}else{

						    			$("#printing_input_qty_"+counter).val('');
						    		}
					 
							    },
								beforeSend: function(){
												$("#loading").show();
												$("#cover").show();
												$('#loading').html('<img src="images/loading.gif"> Loading...');	
												
								},
								complete: function(){
								 				$("#loading").hide(); $("#cover").hide();
												
												
								} 
						    });//AJAX Closed
						//}   


				   }else{

				   		$("#printing_input_qty_"+counter).val('');
				   }

		   		});

		});


		$("#remove").click(function(e){

				var header_row=1;
				var counter=$("#table_article tr").length;
				counter=counter-header_row;
				if(counter>1){
					if(confirm('Confirm delete!')){
						$("#tr_"+counter).remove();
					}
				}
				else{
					alert('No more textbox to remove');
				}
			
									
		});		 




	});//Jquery closed

</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
	<?php foreach($springtube_printing_inspection_master as $master_row): ?>	

		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">									
						<tr>
							<td class="label">Production Date <span style="color:red;">*</span> :</td>
							<td>
								<input type="hidden" name="production_id" value="<?php echo $master_row->production_id;?>" readonly>
								<input type="date" name="production_date" value="<?php echo set_value('production_date',$master_row->production_date);?>" /></td>
						</tr>
						<tr>
							<td class="label">Process Name <span style="color:red;">*</span> :</td>
							<td><select name="process" id="process" disabled><option value=''>--Select Process-</option>
							<?php if($springtube_process_master==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach($springtube_process_master as $process_row){
										$selected=($process_row->process_id=='5'?'selected':'');
										echo "<option value='".$process_row->process_id."'  ".set_select('process',''.$process_row->process_id.'').$selected.">".$process_row->process_name."</option>";
									}
							}?>
							</select></td>
						</tr>

						<tr>
							<td class="label">Machine <span style="color:red;">*</span> :</td>
							<td><select name="machine" id="machine" readonly><option value=''>----Select Machine-----</option>
							<?php if($springtube_machine_master==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach($springtube_machine_master as $machine_row){
										$selected=($machine_row->machine_id==$master_row->machine_id?'selected':'');
										echo "<option value='".$machine_row->machine_id."'  ".set_select('machine',''.$machine_row->machine_id.'').$selected.">".$machine_row->machine_name."</option>";
									}
							}?>
							</select></td>
						</tr>
						<tr>
							<td class="label">Qc Incharge Name: <span style="color:red;">*</span> :</td>
							<td><input type="text" name="qc_incharge" id="qc_incharge"  value="<?php echo set_value('qc_incharge',$master_row->qc_incharge);?>" maxlength="100" size="20"/></td>
						</tr>


					</table>
			
				</td>
				<td>
					<table>
						<tr>
							<td class="label">Shift Issues :</td>
							<td><select name="shift_issue[]" id="shift_issue[]" multiple size="6"><option value=''>--Select shift issues--</option>
							<?php if($springtube_shift_issues_master==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach($springtube_shift_issues_master as $shift_issues_master_row){

										$shift_issue_arr=explode("," , $master_row->shift_issues);

										$selected=(in_array($shift_issues_master_row->shift_issue, $shift_issue_arr)?'selected':'');

										echo "<option value='".$shift_issues_master_row->shift_issue."'  ".set_select('shift_issue[]',$shift_issues_master_row->shift_issue).$selected.">".$shift_issues_master_row->shift_issue."</option>";
									}
							}?>
							</select></td>
						</tr>

						<tr>
							<td class="label">Remarks :</td>
							<td>
								<textarea name="remarks" id="remarks" cols="40" rows="3" value="<?php echo trim(set_value('remarks',$master_row->remarks));?>" maxlength="500"><?php echo trim(set_value('remarks',$master_row->remarks));?></textarea>
							</td>
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
			<table class="middle_form_table_design" id="table_article">
				<tr>
					<th>Sr No.</th>
					<th>Jobcard No</th>									
					<th>Printing Input Qty</th>
					<th>Inspected Output (Qty)</th>
					<!-- <th>Inspected Output (Meters)</th> -->
					<th>Is Job Finished? </th>				
					
				</tr>

			<?php
				if(!empty($this->input->post('sr_no'))){

					//$total_quantity=0;

					for($i=1;$i<=count($this->input->post('sr_no[]'));$i++){?>

						<script>
							$(document).ready(function(){

								$("#loading").hide(); $("#cover").hide();

								$("#jobcard_no_<?php echo $i;?>").autocomplete("<?php echo base_url('index.php/ajax_springtube/jobcard_printing_inspection_autocomplete');?>", {selectFirst: true});

								$("#jobcard_no_<?php echo $i;?>").bind('keyup blur',function(){
									var jobcard_no = $('#jobcard_no_<?php echo $i;?>').val();
									//alert(jobcard_no);
									if(jobcard_no.length>=15){

									    //if(!$("#jobcard_no_1").attr('readonly')){
							   	
							   			$.ajax({

								   			type: "POST",
								   			url: "<?php echo base_url();?>/index.php/ajax_springtube/get_printing_quantity",
								   			data: {jobcard_no : $('#jobcard_no_<?php echo $i;?>').val()},
								   			cache: false,
								   			success: function(html){
								    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);

									    		if(html!='0' || html!='' ){
									    			$("#printing_input_qty_<?php echo $i;?>").val(html);
									       			
									    		}else{

									    			$("#printing_input_qty_<?php echo $i;?>").val('');
									    		}
						 
								    		},
											beforeSend: function(){
													$("#loading").show();
													$("#cover").show();
													$('#loading').html('<img src="images/loading.gif"> Loading...');	
													
											},
											complete: function(){
									 				$("#loading").hide(); $("#cover").hide();
													
													
											} 
							   			});//AJAX Closed

										//}   


					   				}else{

					   					$("#printing_input_qty_<?php echo $i;?>").val('');
					  				}

		   						});



							});//JQUERY
						</script>
						<tr id="tr_<?php echo $i;?>">

							<td><input type="hidden" name="sr_no[]" value="<?php echo $i;?>"/>JOB <?php echo $i;?>
							</td>
							<td>
							<input type="text" name="jobcard_no_<?php echo $i;?>"  id="jobcard_no_<?php echo $i;?>" class="quantity" value="<?php echo set_value('jobcard_no_'.$i.'');?>" maxlength="50" size="20" />
							</td>
							<td>
								<input type="number" name="printing_input_qty_<?php echo $i;?>"  id="printing_input_qty_<?php echo $i;?>" class="quantity" value="<?php echo set_value('printing_input_qty_'.$i.'');?>" min="1" max="80000" step="1" size="20" maxlength="10" />
							</td>							
							<td>
								<input type="number" name="inspected_output_qty_<?php echo $i;?>"  id="inspected_output_qty_<?php echo $i;?>" class="quantity" value="<?php echo set_value('inspected_output_qty_'.$i.'');?>" min="1" max="80000" step="1" size="20"  maxlength="10" />
							</td>
							<!-- <td>
								<input type="number" name="inspected_output_meters_<?php echo $i;?>"  id="inspected_output_meters_<?php echo $i;?>" class="quantity" value="<?php echo set_value('inspected_output_meters_'.$i.'');?>" min="1" max="80000" step="1" size="20" maxlength="10" />
							</td> -->

							<td>
							<input type="checkbox" name="inspection_done_<?php echo $i;?>" value="1" <?php echo set_checkbox('inspection_done_'.$i,0,false);?> title="Is complete inspection done for this Jobcard?" >
						</td>
							
						</tr>

			<?php 
							//$total_quantity+=$this->input->post('quantity_'.$i.'');
					}//Foreach

				}else{ 

			?>

			<?php foreach ($springtube_printing_inspection_details as $detail_row):?>

					<tr id="tr_<?php echo $detail_row->job_pos_no;?>">

						<td>
							<input type="hidden" name="sr_no[]" value="<?php echo $detail_row->job_pos_no;?>"/>JOB <?php echo $detail_row->job_pos_no;?>
						</td>					
						<td>
							<input type="text" name="jobcard_no_<?php echo $detail_row->job_pos_no;?>"  id="jobcard_no_<?php echo $detail_row->job_pos_no;?>" class="quantity" value="<?php echo set_value('jobcard_no_<?php echo $detail_row->job_pos_no;?>',$detail_row->jobcard_no);?>" maxlength="50" size="20" />
						</td>
						<td>
							<input type="number" name="printing_input_qty_<?php echo $detail_row->job_pos_no;?>"  id="printing_input_qty_<?php echo $detail_row->job_pos_no;?>" class="quantity" value="<?php echo set_value('printing_input_qty_<?php echo $detail_row->job_pos_no;?>',$detail_row->printing_input_qty);?>" min="1" max="80000" step="1" size="30"  required maxlength="10" />
						</td>
						
						<td>
							<input type="number" name="inspected_output_qty_<?php echo $detail_row->job_pos_no;?>"  id="inspected_output_qty_<?php echo $detail_row->job_pos_no;?>" class="quantity" value="<?php echo set_value('inspected_output_qty_<?php echo $detail_row->job_pos_no;?>',$detail_row->inspected_output_qty);?>" size="30" min="1" max="80000" step="1" required maxlength="10" />
						</td>
						<!-- <td>
							<input type="number" name="inspected_output_meters_<?php echo $detail_row->job_pos_no;?>"  id="inspected_output_meters_<?php echo $detail_row->job_pos_no;?>" class="quantity" value="<?php echo set_value('inspected_output_meters_<?php echo $detail_row->job_pos_no;?>',$detail_row->inspected_output_meters);?>" min="1" max="80000" size="30"  step="1" required maxlength="10" />
						</td> -->
						<td>
							<input type="checkbox" name="inspection_done_<?php echo $detail_row->job_pos_no;?>" value="1" <?php echo set_checkbox('inspection_done',$detail_row->inspection_done,($detail_row->inspection_done==1?true:false));?> title="Is complete inspection done for this Jobcard?" >
						</td>

					</tr>

					<script>
						$(document).ready(function(){

							$("#loading").hide(); $("#cover").hide();

							$("#jobcard_no_<?php echo $detail_row->job_pos_no;?>").autocomplete("<?php echo base_url('index.php/ajax_springtube/jobcard_printing_inspection_autocomplete');?>", {selectFirst: true});

							
							$("#jobcard_no_<?php echo $detail_row->job_pos_no;?>").bind('keyup blur',function() {

								var jobcard_no = $('#jobcard_no_<?php echo $detail_row->job_pos_no;?>').val();
								//alert(jobcard_no);
								if(jobcard_no.length>=15){

									//if(!$("#jobcard_no_1").attr('readonly')){
									   	
									   $.ajax({

										   	type: "POST",
										   	url: "<?php echo base_url();?>/index.php/ajax_springtube/get_printing_quantity",
										   	data: {jobcard_no : $('#jobcard_no_<?php echo $detail_row->job_pos_no;?>').val()},
										   	cache: false,
										   	success: function(html){
										    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);

										    		if(html!='0' || html!='' ){
										    			$("#printing_input_qty_<?php echo $detail_row->job_pos_no;?>").val(html);
										       			
										    		}else{

										    			$("#printing_input_qty_<?php echo $detail_row->job_pos_no;?>").val('');
										    		}
								 
										    },
											beforeSend: function(){
															$("#loading").show();
															$("#cover").show();
															$('#loading').html('<img src="images/loading.gif"> Loading...');	
															
											},
											complete: function(){
											 				$("#loading").hide(); $("#cover").hide();
															
															
											} 
									    });//AJAX Closed
									//}   


							    }else{

							   		$("#printing_input_qty_<?php echo $detail_row->job_pos_no;?>").val('');
							    }

					   		});


						});
					</script>	
		
			<?php endforeach;?>	


			<?php
				
				}
			?>


			</table>
		</div>
	</div>		

<?php endforeach;?>	
	<div class="form_design">
		<div class="ui buttons">
			  <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
			  <div class="or"></div>
			  <button class="ui positive button" id="btnsubmit" onClick="return confirm('Are you sure to update record!');" >Update</button>
			<!-- <input type="submit" class="ui positive button" value="Save"/>-->
		</div>
	</div>	
	
</form>




				
				
				
			