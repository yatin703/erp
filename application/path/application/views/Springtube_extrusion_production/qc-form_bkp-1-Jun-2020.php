<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){
		//$("#loading").hide(); $("#cover").hide();
		$("#jobcard_no_1").autocomplete("<?php echo base_url('index.php/ajax_springtube/jobcard_extrusion_autocomplete');?>", {selectFirst: true});	
				
	
		$("#total_ok_meters").live('keyup',function(){
			if($("#total_meters_produced").val()!='' && $("#total_ok_meters").val()!='' && $("#total_meters_produced").val()>=$("#total_ok_meters").val()){

				var total_qc_hold_meters= $("#total_meters_produced").val()-$("#total_ok_meters").val();
				$("#total_qc_hold_meters").val(total_qc_hold_meters);
			}
		});

	});//Jquery closed

</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/qc_save');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
	<?php foreach($springtube_extrusion_production_master as $master_row): ?>	

		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">									
						<tr>
							<td class="label">Production Date <span style="color:red;">*</span> :</td>
							<td>
								<input type="hidden" name="production_id" value="<?php echo $master_row->production_id;?>" readonly>
								<input type="date" name="production_date" value="<?php echo set_value('production_date',$master_row->production_date);?>" disabled /></td>
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
							<td><select name="machine" id="machine" disabled><option value=''>----Select Machine-----</option>
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
							<td><input type="text" name="qc_incharge" id="qc_incharge"  value="<?php echo set_value('qc_incharge',$master_row->qc_incharge);?>" maxlength="100" size="20" readonly/></td>
						</tr>


					</table>
			
				</td>
				<td>
					<table>
						<tr>
							<td class="label">Shift Issues :</td>
							<td><select name="shift_issue[]" id="shift_issue[]" multiple size="6" disabled><option value=''>--Select shift issues--</option>
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
								<textarea name="remarks" id="remarks" cols="40" rows="3" value="<?php echo trim(set_value('remarks',$master_row->remarks));?>" maxlength="500" readonly><?php echo trim(set_value('remarks',$master_row->remarks));?></textarea>
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
					<th>Total Ok Meters</th>
					<th>Total QC Hold Meters</th>
					<th>QC Remarks</th>					
					<th>Total Weight Of Job (Kg)</th>
					<th>Total Trim Waste (Kg)</th>
					
					
				</tr>

		    <?php  foreach ($springtube_extrusion_production_details as $detail_row):?>

					<tr id="tr_<?php echo $detail_row->job_pos_no;?>">

						<td>
							<input type="hidden" name="details_id" value="<?php echo $detail_row->details_id;?>"/>
							<input type="hidden" name="job_pos_no" value="<?php echo $detail_row->job_pos_no;?>"/>JOB <?php echo $detail_row->job_pos_no;?>
						</td>					
						<td>
							<input type="text" name="jobcard_no"  id="jobcard_no" class="quantity" value="<?php echo set_value('jobcard_no',$detail_row->jobcard_no);?>" maxlength="50" size="20" readonly/>
						</td>
						<td>
							<input type="number" name="total_meters_produced"  id="total_meters_produced" class="quantity" value="<?php echo set_value('total_meters_produced',$detail_row->total_meters_produced);?>" min="1" max="20000" step="0.1" size="30" readonly/>
						</td>
						<td>
							<input type="number" name="total_ok_meters"  id="total_ok_meters" class="quantity" value="<?php echo set_value('total_ok_meters',$detail_row->total_ok_meters);?>" min="1" max="20000" step="0.1" size="30" required />
						</td>
						<td>
							<input type="number" name="total_qc_hold_meters"  id="total_qc_hold_meters" class="quantity" value="<?php echo set_value('total_qc_hold_meters',$detail_row->total_qc_hold_meters);?>" min="0" max="20000" step="1" size="30" readonly/>
						</td>
						<td>
							<input type="text" name="qc_remarks"  id="qc_remarks" class="quantity" value="<?php echo set_value('qc_remarks',$detail_row->qc_remarks);?>"  size="40" maxlength="225" required/>
						</td>
						<td>
							<input type="number" name="total_job_weight"  id="total_job_weight" class="quantity" value="<?php echo set_value('total_job_weight',$detail_row->total_job_weight);?>" size="30" min="1" max="1000" step="0.1" readonly/>
						</td>
						<td>
							<input type="number" name="total_waste"  id="total_waste" class="quantity" value="<?php echo set_value('total_waste',$detail_row->total_waste);?>" size="30" min="1" max="1000" step="0.1" readonly/>
						</td>

					</tr>

					
		
			<?php endforeach;?>	

			</table>
		</div>
	</div>		

<?php endforeach;?>	

	<div class="form_design">
		<div class="ui buttons">
	  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui positive button">Save</button>
		</div>
	</div>

	
</form>




				
				
				
			