<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){
		//$("#loading").hide(); $("#cover").hide();
		$("#jobcard_no_1").autocomplete("<?php echo base_url('index.php/ajax_springtube/jobcard_extrusion_autocomplete');?>", {selectFirst: true});	
				
		
		
		$("#add").live('click',function () {
			var header_row=1;
			var counter=$("#table_article tr").length;
			var mark_up='<tr id="tr_'+ counter +'"><td><input type="hidden" name="sr_no[]" value="'+counter+'"/>JOB '+counter+'</td><td><input type="text" name="jobcard_no_'+counter+'"  id="jobcard_no_'+counter+'" class="quantity" value="<?php echo set_value('jobcard_no_"+counter+"');?>" maxlength="50" size="20" required/></td><td><input type="number" name="total_meters_produced_'+counter+'"  id="total_meters_produced_'+counter+'" class="quantity" value="<?php echo set_value('total_meters_produced_"+counter+"');?>" min="0" max="20000" step="0.1" size="20" required/></td><td><input type="number" name="total_job_weight_'+counter+'"  id="total_job_weight_'+counter+'" class="quantity" value="<?php echo set_value('total_job_weight_"+counter+"');?>" min="0" max="10000" step="0.1" size="20" required/></td><td><input type="number" name="total_waste_'+counter+'"  id="total_waste_'+counter+'" class="quantity" value="<?php echo set_value('total_waste_"+counter+"');?>" min="1" max="10000" step="0.1" size="20" required/></td></tr>';

				//alert(mark_up);
				$("#table_article").append(mark_up);

				$("#jobcard_no_"+counter).autocomplete("<?php echo base_url('index.php/ajax_springtube/jobcard_extrusion_autocomplete');?>", {selectFirst: true});


					
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

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">									
						<tr>
							<td class="label">Production Date <span style="color:red;">*</span> :</td>
							<td><input type="date" name="production_date"   value="<?php echo set_value('production_date',date('Y-m-d'));?>" readonly /></td>
						</tr>
						<tr>
							<td class="label">Process Name <span style="color:red;">*</span> :</td>
							<td><select name="process" id="process" disabled><option value=''>--Select Process-</option>
							<?php if($springtube_process_master==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach($springtube_process_master as $process_row){
										$selected=($process_row->process_id=='1'?'selected':'');
										echo "<option value='".$process_row->process_id."'  ".set_select('process',''.$process_row->process_id.'').$selected.">".$process_row->process_name."</option>";
									}
							}?>
							</select></td>
						</tr>

						<tr>
							<td class="label">Machine <span style="color:red;">*</span> :</td>
							<td><select name="machine" id="machine" ><option value=''>----Select Machine-----</option>
							<?php if($springtube_machine_master==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach($springtube_machine_master as $machine_row){
										$selected=($machine_row->machine_id==1?'selected':'');
										echo "<option value='".$machine_row->machine_id."'  ".set_select('machine',''.$machine_row->machine_id.'').$selected.">".$machine_row->machine_name."</option>";
									}
							}?>
							</select></td>
						</tr>
						<tr>
							<td class="label">Qc Incharge Name: <span style="color:red;">*</span> :</td>
							<td><input type="text" name="qc_incharge" id="qc_incharge"  value="<?php echo set_value('qc_incharge');?>" maxlength="100" size="20" required/></td>
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
										
										echo "<option value='".$shift_issues_master_row->shift_issue."'  ".set_select('shift_issue[]',$shift_issues_master_row->shift_issue).">".$shift_issues_master_row->shift_issue."</option>";
									}
							}?>
							</select></td>
						</tr>

						<tr>
							<td class="label">Remarks :</td>
							<td>
								<textarea name="remarks" id="remarks" cols="40" rows="3" value="<?php echo trim(set_value('remarks'));?>" maxlength="500">
								<?php echo trim(set_value('remarks'));?>	
								</textarea>
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
					<th>Total Meters Produced</th>					
					<th>Total Weight Of Job (Kg)</th>
					<th>Total Waste (Kg)</th>
					
					
				</tr>

			<?php
				if(!empty($this->input->post('sr_no'))){

					$total_quantity=0;

					for($i=1;$i<=count($this->input->post('sr_no[]'));$i++){?>

						<script>
							$(document).ready(function(){

							$("#loading").hide(); $("#cover").hide();

							$("#jobcard_no_<?php echo $i;?>").autocomplete("<?php echo base_url('index.php/ajax_springtube/jobcard_extrusion_autocomplete');?>", {selectFirst: true});

							});
						</script>
						<tr id="tr_<?php echo $i;?>">

							<td><input type="hidden" name="sr_no[]" value="<?php echo $i;?>"/>JOB <?php echo $i;?>
							</td>
							<td>
							<input type="text" name="jobcard_no_<?php echo $i;?>"  id="jobcard_no_<?php echo $i;?>" class="quantity" value="<?php echo set_value('jobcard_no_'.$i.'');?>" maxlength="10" size="20" required/>
							</td>
							<td>
								<input type="number" name="total_meters_produced_<?php echo $i;?>"  id="total_meters_produced_<?php echo $i;?>" class="quantity" value="<?php echo set_value('total_meters_produced_'.$i.'');?>" min="0" max="20000" step="0.1" size="20" required/>
							</td>
							<td>
								<input type="number" name="total_job_weight_<?php echo $i;?>"  id="total_job_weight_<?php echo $i;?>" class="quantity" value="<?php echo set_value('total_job_weight_'.$i.'');?>" min="0" max="10000" step="0.1" size="20" required/>
							</td>
							<td>
								<input type="number" name="total_waste_<?php echo $i;?>"  id="total_waste_<?php echo $i;?>" class="quantity" value="<?php echo set_value('total_waste_'.$i.'');?>" min="1" max="10000" step="0.1" size="20" required/>
							</td>
							
						</tr>

			<?php 
							$total_quantity+=$this->input->post('quantity_'.$i.'');
					}

				}else{ 

			?>

					<tr id="tr_1">

						<td>
							<input type="hidden" name="sr_no[]" value="1"/>JOB 1
						</td>					
						<td>
							<input type="text" name="jobcard_no_1"  id="jobcard_no_1" class="quantity" value="<?php echo set_value('jobcard_no_1');?>" maxlength="50" size="20" required />
						</td>
						<td>
							<input type="number" name="total_meters_produced_1"  id="total_meters_produced_1" class="quantity" value="<?php echo set_value('total_meters_produced_1');?>" min="0" max="20000" step="0.1" size="30" required/>
						</td>
						<td>
							<input type="number" name="total_job_weight_1"  id="total_job_weight_1" class="quantity" value="<?php echo set_value('total_job_weight_1');?>" size="30" min="0" max="10000" step="0.1" required />
						</td>
						<td>
							<input type="number" name="total_waste_1"  id="total_waste_1" class="quantity" value="<?php echo set_value('total_waste_1');?>" size="30" min="0" max="10000" step="0.1" required />
						</td>

					</tr>
				
			<?php
				
				}
			?>


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




				
				
				
			