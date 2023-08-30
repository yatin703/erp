<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){



		$("#report_to_1").autocomplete("<?php echo base_url('index.php/ajax/primary_contact_autocomplete');?>", {selectFirst: true});

		$("#loading").hide(); $("#cover").hide();



		$("#add_contact_info").click(function(e){ 
 
			//alert(1);
			var counter= $('#tablePanton tr').length-1;

			var markup = '<tr class="class_contact_info" id="tr_'+ counter +'"><td><input type="hidden" name="sr_no[]" value="'+counter+'"/>'+ counter +'</td><td><input type="text" name="contact_name[]" size="20"/></td><td><input type="text" name="rank[]" size="2"/></td><td><select name="position[]" ><option value="">--POSITION--</option><?php if($sales_quotes_designation_master==FALSE){ echo'<option>--Setup Required--</option>';}else{foreach ($sales_quotes_designation_master as $row){echo'<option value="'.$row->id.'" >'.$row->designation.'</option>';}}?></select></td><td><input type="text" name="report_to[]" id="report_to_'+counter+'" size="20"/></td><td><input type="text" name="company_contact_no[]" size="10" maxlength="15"/></td><td><input type="text" name="personal_contact_no[]" size="10" maxlength="15"/></td><td><input type="text" name="company_email[]"  size="25"></td><td><input type="text" name="personal_email[]" size="25"></td><td><input type="text" name="video_link[]" size="25"></td><td><input type="text" name="linked_in_link[]" size="25"></td><td><input type="text" name="located_at[]" size="20"></td><td><input type="date" name="birth_date[]"/></td><td><input type="date" name="anniversary_date[]"/></td><td><input type="text" name="hobbies[]"/></td><td><input type="text" name="previous_job[]"/></td><td><select name="previous_position[]" ><option value="">--POSITION--</option><?php if($sales_quotes_designation_master==FALSE){echo'<option>--Setup Required--</option>';}else{ foreach ($sales_quotes_designation_master as $row){echo'<option value="'.$row->id.'">'.$row->designation.'</option>';}}?></select></td><td><input type="date" name="previous_from_date[]"></td><td><input type="date" name="previous_to_date[]"></td><td><input type="text" name="history_if_any[]" size="50"/></td><td><select name="repesentative_3d[]"><option value="">--SELECT--</option><?php if($employee_master==FALSE){echo'<option>--Setup Required--</option>';}else{foreach ($employee_master as $row){echo'<option value="'.$row->employee_id.'">'.strtoupper($row->name1.' '.$row->name2).'</option>';}}?></select></td><td><select name="active[]"><option value="">--STATUS--</option><option value="1">Active</option><option value="0">Inactive</option></select></td></tr>';
			$("#tablePanton").append(markup);
			$("#report_to_"+counter).autocomplete("<?php echo base_url('index.php/ajax/primary_contact_autocomplete');?>", {selectFirst: true});
		});

		$("#remove_contact_info").click(function(e){

   				var header_row=2;
				//var counter= $('#tbl_contact_info tbody tr.class_contact_info').length; 
				var counter= $('#tablePanton tr').length;	
				//alert(counter);
				counter=counter-header_row;
				if(counter>1){
					if(confirm('Confirm delete!')){
						$("#tr_"+counter).remove();
					}
				}
				else{
					alert('Keep at least one record');
				}		
									
		});

	});//Jquery closed

</script>
<style type="text/css">
	fieldset {border: 1px solid #8cacbb;}
	fieldset legend{font-weight: bold;} 
</style>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save_contact');?>" method="POST" enctype="multipart/form-data">
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
<?php foreach ($customer_master as $master_row):?>
	
		<?php $customer_id=$master_row->adr_category_id;?>


			<table class="form_table_design">
				<tr>
					<td class="label"> Customer: <span style="color:red;">*</span></td>
					<td colspan="3">
					<input type="hidden" name="address_category_details_id" value="<?php echo $master_row->address_category_details_id;?>">
					<?php 
						$customer=$this->common_model->select_one_active_record('address_category_master',$this->session->userdata['logged_in']['company_id'],'adr_category_id',$master_row->adr_category_id);
								
						if($customer==FALSE){

						}else{
							foreach($customer as $customer_row){

							echo "<input type='text' name='customer_category' id='customer_category' size='40' value='".$customer_row->category_name."//".$customer_row->adr_category_id."' readonly>
								<input type='hidden' name='adr_category_id' value='".$customer_row->adr_category_id."'>";
										
								}
						}

						?>
					</td>							
				</tr>
			
			</table>
<?php endforeach;?>	
	</div>
		
		<div class="middle_form_design">
		<div class="middle_form_inner_design" style="overflow:scroll;font-size:13px;">
			
			<div class="ui buttons">
				<input type="button" value="Remove" id="remove_contact_info" class="ui button">
				<div class="or"></div>
				<input type="button" value="Add" id="add_contact_info" class="ui positive button">
			</div>		 

			<table class="ui very basic collapsing celled table" id="tablePanton" >
				<thead>
				<tr>
					<th colspan="5" class="center aligned">Contact Name</th>
					<th colspan="2" class="center aligned">Contact No</th>
					<th colspan="2" class="center aligned">Email</th>
					<th colspan="6" class="center aligned">Personal Details</th>
					<th colspan="5" class="center aligned">Previous Job Details</th>
					<th colspan="2"></th>
				</tr> 
				<tr>
					<th>Sr.No.</th>
					<th>Name </th>
					<th>Rank </th>
					<th>Position <a href="<?php echo base_url('index.php/designation_master');?>" target="_blank">link</a></th>
					<th>Report To</th>
					<th>Company</th>
					<th>Personal</th>
					<th>Company</th>
					<th>Personal</th>
					<th>Video Link</th>
					<th>Linked In Profile</th>
					<th>Located At</th>
					<th>Birth Date</th>
					<th>Anniversary</th>
					<th>Hobbies</th>
					<th>Company</th>
					
					<th>Position</th>
					<th>From</th>
					<th>To</th>
					<th>History If Any</th>
					<th>3D Representative</th>
					<th>Status</th>							 		
				</tr>
			</thead>
			<tbody>					 
			 
				<?php 
				if(!empty($this->input->post('sr_no[]'))){

					//print_r($this->input->post('contact_name[]'));
						$j=1;
						for($i=0;$i<count($this->input->post('sr_no[]'));$i++){										 
							echo'<tr class="class_contact_info" id="tr_'.$j.'">
							<td><input type="hidden" name="sr_no[]" value="'.$i.'"/>
							'.$j.'</td>
							<td><input type="text" name="contact_name[]" value="'.set_value('contact_name['.$i.']').'" size="20"/></td>	
							<td><input type="number" name="rank[]" value="'.set_value('rank['.$i.']').'" size="2">
							</td>

							<td><select name="position[]">					
							<option value="">--POSITION--</option>';
							if($sales_quotes_designation_master==FALSE){
								echo'<option>--Setup Required--</option>';
							}
							else{
								foreach ($sales_quotes_designation_master as $row) {
									$selected=($this->input->post('position['.$i.']')==$row->id?"selected":"");
									echo'<option value="'.$row->id.'" '.$selected.'>'.$row->designation.'</option>';
								}
							}
							echo'</select>
							</td>
							<td><input type="text" name="report_to[]" id="report_to_'.$j.'"  value="'.set_value('report_to['.$i.']').'" size="20"/></td>	
															 
							<td><input type="text" name="company_contact_no[]" value="'.set_value('company_contact_no['.$i.']').'" size="10" maxlength="15">
							</td>							 
							<td><input type="text" name="personal_contact_no[]" value="'.set_value('personal_contact_no['.$i.']').'" size="10" maxlength="15">
							</td>							 
							<td><input type="email" name="company_email[]" value="'.set_value('company_email['.$i.']').'" size="25">
							</td>								 												 
							<td><input type="email" name="personal_email[]" value="'.set_value('personal_email['.$i.']').'" size="25">
							</td>

							<td><input type="text" name="video_link[]" value="'.set_value('video_link['.$i.']').'" size="25">
							</td>
							<td><input type="text" name="linked_in_link[]" value="'.set_value('linked_in_link['.$i.']').'" size="25">
							</td>
						 
							<td><input type="text" name="located_at[]" value="'.set_value('located_at['.$i.']').'" size="20">
							</td>
						 
							<td><input type="date" name="birth_date[]" value="'.set_value('birth_date['.$i.']').'">
							</td>

							<td><input type="date" name="anniversary_date[]" value="'.set_value('anniversary_date['.$i.']').'">
							</td>

							<td><input type="text" name="hobbies[]" value="'.set_value('hobbies['.$i.']').'">
							</td>
						 
							<td><input type="text" name="previous_job[]" value="'.set_value('previous_job['.$i.']').'">
							</td>									 
							 
							<td><select name="previous_position[]" >					
							<option value="">--POSITION--</option>';
							if($sales_quotes_designation_master==FALSE){
								echo'<option>--Setup Required--</option>';
							}
							else{
								foreach ($sales_quotes_designation_master as $row) {
									$selected=($this->input->post('previous_position['.$i.']')==$row->id?"selected":""); 
									echo'<option value="'.$row->id.'" '.$selected.'>'.$row->designation.'</option>';
								}
							}
							echo'</select>
							</td>
							<td><input type="date" name="previous_from_date[]" value="'.set_value('previous_from_date['.$i.']').'">
							</td>

						 	<td><input type="date" name="previous_to_date[]" value="'.set_value('previous_to_date['.$i.']').'">
							</td>						 
							<td><input type="text" name="history_if_any[]" value="'.set_value('history_if_any['.$i.']').'" size="50">
							</td> 
							<td><select name="repesentative_3d[]" >					
							<option value="">--SELECT--</option>';
							if($employee_master==FALSE){
								echo'<option>--Setup Required--</option>';
							}
							else{
								foreach ($employee_master as $row) {

									$selected=($this->input->post('repesentative_3d['.$i.']')==$row->employee_id?"selected":"");
									 
									echo'<option value="'.$row->employee_id.'" '.$selected.'>'.strtoupper($row->name1.' '.$row->name2).'</option>';
								}
							}
							echo'</select>
							</td>
							<td> 
								<select name="active[]">
									<option value="">--STATUS--</option>
									<option value="1" '.set_select('active[]','1').'>Active</option>
									<option value="0" '.set_select('active[]','0').'>Inactive</option>
								</select		
							</td>
						</tr>';

						$j++;

						}
					}	
					else{
						 
						echo'<tr class="class_contact_info" id="tr_1">

							<td><input type="hidden" name="sr_no[]" value="1"/>
								1
							</td>
							<td> <input type="text" name="contact_name[]" value="'.set_value("contact_name[]").'" size="20"></td>
					 		<td><input type="text" name="rank[]" value="'.set_value('rank[]').'" size="2"></td>
							<td><select name="position[]" >					
							<option value="">--POSITION--</option>';
							if($sales_quotes_designation_master==FALSE){
								echo'<option>--Setup Required--</option>';
							}
							else{
								foreach ($sales_quotes_designation_master as $row) {
									 
									echo'<option value="'.$row->id.'" '.set_select("position[]").'>'.$row->designation.'</option>';
								}
							}
							echo'</select>
							</td>
							<td><input type="text" name="report_to[]" id="report_to_1" value="'.set_value("report_to[]").'" size="20"></td>
					 										 
							<td><input type="text" name="company_contact_no[]" value="'.set_value('company_contact_no[]').'" size="10" maxlength="15">
							</td>							 
							<td><input type="text" name="personal_contact_no[]" value="'.set_value('personal_contact_no[]').'" size="10" maxlength="15">
							</td>							 
							<td><input type="email" name="company_email[]" value="'.set_value('company_email[]').'" size="25">
							</td>										 												 
							<td><input type="email" name="personal_email[]" value="'.set_value('personal_email[]').'" size="25">
							</td>
							<td><input type="text" name="video_link[]" value="'.set_value('video_link[]').'" size="25">
							</td>

							<td><input type="text" name="linked_in_link[]" value="'.set_value('linked_in_link[]').'" size="25">
							</td>
						 
							<td><input type="text" name="located_at[]" value="'.set_value('located_at[]').'" size="20">
							</td>
						 
							<td><input type="date" name="birth_date[]" value="'.set_value('birth_date[]').'"></td>
							<td><input type="date" name="anniversary_date[]" value="'.set_value('anniversary_date[]').'"></td>

							<td><input type="text" name="hobbies[]" value="'.set_value('hobbies[]').'"></td>
						 
						 
							<td><input type="text" name="previous_job[]" value="'.set_value('previous_job[]').'">
							</td>									 
							 
							<td><select name="previous_position[]" >					
							<option value="">--POSITION--</option>';
							if($sales_quotes_designation_master==FALSE){
								echo'<option>--Setup Required--</option>';
							}
							else{
								foreach ($sales_quotes_designation_master as $row) {
									 
									echo'<option value="'.$row->id.'" '.set_select('previous_position[]').'>'.$row->designation.'</option>';
								}
							}
							echo'</select>
							</td>
						 	<td><input type="date" name="previous_from_date[]" value="'.set_value('previous_from_date[]').'">
							</td>

						 	<td><input type="date" name="previous_to_date[]" value="'.set_value('previous_to_date[]').'">
							</td>
							<td><input type="text" name="history_if_any[]" value="'.set_value('history_if_any[]').'" size="50">
							</td>
						 
							<td><select name="repesentative_3d[]" >					
							<option value="">--SELECT--</option>';
							if($employee_master==FALSE){
								echo'<option>--Setup Required--</option>';
							}
							else{
								foreach ($employee_master as $row) {
									 
									echo'<option value="'.$row->employee_id.'" '.set_select('repesentative_3d[]',$row->employee_id).'>'.strtoupper($row->name1.' '.$row->name2).'</option>';
								}
							}
							echo'</select>
							</td>
							<td> 
								<select name="active[]">
									<option value="">--STATUS--</option>
									<option value="1" '.set_select('active[]','1').'>Active</option>
									<option value="0" '.set_select('active[]','0').'>Inactive</option>
								</select		
							</td>
						</tr>';
					}
				?>
			</tbody>
			</table>			 
		</div>
		</div>

		
		<br/>
	

	<div class="form_design">
		<div class="ui buttons">
	  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui positive button" onClick="return confirm('Are you sure to save Record?');">Save</button>
		</div>
	</div>

	</form>

			
	<div class="middle_form_design">
		<div class="middle_form_inner_design" style="overflow:scroll;font-size:13px;">
			<h2>Already Exist</h2>
		<table class="ui very basic collapsing celled table">
				<thead>
				<tr>
					<th colspan="5" class="center aligned">Contact Name</th>
					<th colspan="2" class="center aligned">Contact No</th>
					<th colspan="2" class="center aligned">Email</th>
					<th colspan="6" class="center aligned">Personal Details</th>
					<th colspan="5" class="center aligned">Previous Job Details</th>
					<th colspan="2"></th>
				</tr> 
				<tr>
					<th>Sr.No.</th>
					<th>Name </th>
					<th>Rank </th>
					<th>Position</th>
					<th>Report To</th>
					<th>Company</th>
					<th>Personal</th>
					<th>Company</th>
					<th>Personal</th>
					<th>Video Link</th>
					<th>Linked In Profile</th>
					<th>Located At</th>
					<th>Birth Date</th>
					<th>Anniversary</th>
					<th>Hobbies</th>
					<th>Company</th>
					
					<th>Position</th>
					<th>From</th>
					<th>To</th>
					<th>History If Any</th>
					<th>3D Representative</th>
					<th>Status</th>							 		
				</tr>
			</thead>
			<tbody>
				<?php
				if(!empty($this->input->post('adr_category_id'))){

					$search= array(
							'adr_category_id'=>$this->input->post('adr_category_id'),
							'archive'=>0
						);
					}else{

						$search= array(
							'adr_category_id'=>$customer_id,
							'archive'=>0
						);

					}

						$sales_quote_customer_contact_details_result=$this->common_model->select_active_records_where('address_category_contact_details',$this->session->userdata['logged_in']['company_id'],$search);
						//echo $this->db->last_query();

						$j=1;
						foreach($sales_quote_customer_contact_details_result as $contact_details_row ){ 
						
							echo'<tr class="class_contact_info">

							<td>'.$j.'</td>
							<td><input type="text"  value="'.$contact_details_row->contact_name.'" size="20"></td>
					 		
							<td><input type="text"  value="'.$contact_details_row->rank.'" size="2"></td>
							<td><select >					
							<option value="">--POSITION--</option>';
							if($sales_quotes_designation_master==FALSE){
								echo'<option>--Setup Required--</option>';
							}
							else{
								foreach ($sales_quotes_designation_master as $row) {

									$selected=($contact_details_row->position==$row->id ? "selected" : "");
									 
									echo'<option value="'.$row->id.'" '.$selected.'>'.$row->designation.'</option>';
								}
							}
							echo'</select>
							</td>
							<td><input type="text"  value="'.$this->sales_quote_customer_model->get_client_name($data=array('address_category_contact_id'=>$contact_details_row->report_to)).'" size="20"></td>

							<td><input type="text" value="'.$contact_details_row->company_contact_no.'" size="10" maxlength="15">
							</td>							 
							<td><input type="text" value="'.$contact_details_row->personal_contact_no.'" size="10" maxlength="15">
							</td>							 
							<td><input type="text" value="'.$contact_details_row->company_email.'" size="25">
							</td>										 												 
							<td><input type="text" value="'.$contact_details_row->personal_email.'" size="25">
							</td>

							<td><input type="text" value="'.$contact_details_row->video_link.'" size="25">
							</td>

							<td><input type="text" value="'.$contact_details_row->linked_in_link.'" size="25">
							</td>
						 
							<td><input type="text" value="'.$contact_details_row->located_at.'" size="20">
							</td>
						 
							<td><input type="date" value="'.$contact_details_row->birth_date.'">
							</td>

							<td><input type="date" value="'.$contact_details_row->anniversary_date.'">
							</td>

							<td><input type="text" value="'.$contact_details_row->hobbies.'"></td>
						 
							

							<td><input type="text" value="'.$contact_details_row->previous_job.'">
							</td>									 
							 
							<td><select>					
							<option value="">--POSITION--</option>';
							if($sales_quotes_designation_master==FALSE){
								echo'<option>--Setup Required--</option>';
							}
							else{
								foreach ($sales_quotes_designation_master as $row) {
									$selected=($contact_details_row->previous_position==$row->id?"selected":""); 
									echo'<option value="'.$row->id.'" '.$selected.'>'.$row->designation.'</option>';
								}
							}
							echo'</select>
							</td>
						 	<td><input type="date"  value="'.set_value('previous_from_date',$contact_details_row->previous_from_date).'">
							</td>

						 	<td><input type="date" value="'.$contact_details_row->previous_to_date.'">
							</td>
							
							<td><input type="text" value="'.$contact_details_row->history_if_any.'" size="50">
							</td>
						 
							<td><select>					
							<option value="">--SELECT--</option>';
							if($employee_master==FALSE){
								echo'<option>--Setup Required--</option>';
							}
							else{
								foreach ($employee_master as $row) {
									$selected=($contact_details_row->repesentative_3d==$row->employee_id?"selected":""); 
									echo'<option value="'.$row->employee_id.'" '.$selected.'>'.strtoupper($row->name1.' '.$row->name2).'</option>';
								}
							}
							echo'</select>
							</td>
							<td> 
								<select>
									<option value="">--STATUS--</option>
									<option value="1" '.($contact_details_row->active=='1'?"selected":"").'>Active</option>
									<option value="0" '.($contact_details_row->active=='0'?"selected":"").'>Inactive</option>
								</select		
							</td>
						</tr>';
						$j++;
						}
				?>
			</tbody>
		</table>
		</div>
	</div>


</div>	
	




				
				
				
			