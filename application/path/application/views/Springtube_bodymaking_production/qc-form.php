<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){
		//$("#loading").hide(); $("#cover").hide();
		$("#jobcard_no_1").autocomplete("<?php echo base_url('index.php/ajax_springtube/jobcard_bodymaking_autocomplete');?>", {selectFirst: true});				
	
		$("#qc_ok_qty").live('keyup',function(){

			if($("#sleeve_with_cap").val()!=''){
				var sleeve_with_cap=parseInt($("#sleeve_with_cap").val());
				var qc_ok_qty=$("#qc_ok_qty").val();


				if(sleeve_with_cap>=qc_ok_qty){

					qc_hold_qty=sleeve_with_cap-qc_ok_qty;
					$("#qc_hold_qty").val(qc_hold_qty);

				}else{

					$("#qc_hold_qty").val('');
						alert('Total Ok Qty should not be grater than Total Sleeve With Cap Qty');
				}
			}else{
				$("#qc_hold_qty").val('');
			}

			
			
			// if($("#sleeve_with_cap").val()!='' && $("#qc_ok_qty").val()!=''){

			// 	var qc_hold_qty= $("#sleeve_with_cap").val()-$("#qc_ok_qty").val();
			// 	$("#qc_hold_qty").val(qc_hold_qty);
			// }
		});

	});//Jquery closed

</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/qc_save');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
	<?php foreach($springtube_bodymaking_production_master as $master_row): ?>	

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
					<th>Total Sleeve Produced (Qty)</th>					
					<th>Sleeve with Heading (Qty)</th>
					<th>Sleeve with Cap (Qty)</th>
					<th>QC Ok Qty</th>
					<th>QC Hold Qty</th>
					<th>QC Remarks</th>								
					
				</tr>

		    <?php  foreach ($springtube_bodymaking_production_details as $detail_row):?>

					<tr id="tr_<?php echo $detail_row->job_pos_no;?>">

						<td>
							<input type="hidden" name="details_id" value="<?php echo $detail_row->details_id;?>"/>
							<input type="hidden" name="job_pos_no" value="<?php echo $detail_row->job_pos_no;?>"/>JOB <?php echo $detail_row->job_pos_no;?>
						</td>					
						<td>
							<input type="text" name="jobcard_no"  id="jobcard_no" class="quantity" value="<?php echo set_value('jobcard_no',$detail_row->jobcard_no);?>"  size="20" readonly maxlength="50"/>
						</td>
						<td>
							<input type="number" name="total_sleeve_produced"  id="total_sleeve_produced" class="quantity" value="<?php echo set_value('total_sleeve_produced',$detail_row->total_sleeve_produced);?>" min="1" max="80000" step="1" size="30" readonly maxlength="10"/>
						</td>
						<td>
							<input type="number" name="sleeve_with_heading"  id="sleeve_with_heading" class="quantity" value="<?php echo set_value('sleeve_with_heading',$detail_row->sleeve_with_heading);?>" min="1" max="80000" step="1" size="30" readonly maxlength="10" />
						</td>
						<td>
							<input type="number" name="sleeve_with_cap"  id="sleeve_with_cap" class="quantity" value="<?php echo set_value('sleeve_with_cap',$detail_row->sleeve_with_cap);?>" min="1" max="80000" step="1" size="30" readonly maxlength="10"/>
						</td>						
						<td>
							<input type="number" name="qc_ok_qty"  id="qc_ok_qty" class="quantity" value="<?php echo set_value('qc_ok_qty',$detail_row->qc_ok_qty);?>" size="30" min="0" max="80000" step="1"  required/>
						</td>
						<td>
							<input type="number" name="qc_hold_qty"  id="qc_hold_qty" class="quantity" value="<?php echo set_value('qc_hold_qty',$detail_row->qc_hold_qty);?>" size="30" min="0" max="80000" step="1"  required readonly/>
						</td>
						<td>
							<textarea name="qc_remarks"  id="qc_remarks" cols="40" rows="3" value="<?php echo set_value('qc_remarks',$detail_row->qc_remarks);?>"  size="40" maxlength="225"><?php echo trim(set_value('qc_remarks',$detail_row->qc_remarks));?></textarea>
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




				
				
				
			