<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script type="text/javascript">

	$(document).ready(function() {

		$("#loading").hide(); $("#cover").hide();
		 

		// ------------------------------------------
		//$("#invoice_no").autocomplete("<?php echo base_url('index.php/ajax/ar_invoice_no');?>", {selectFirst: true});
		//$("#order_no").autocomplete("<?php echo base_url('index.php/ajax_springtube/spring_so_no');?>", {selectFirst: true});

		$("#tr_invoice").hide();
		$("#tr_order").hide();
		$("#tr_article_no").hide();
		$("#tr_invoice_tubes_checked").hide();
		$("#tr_order_tubes_hold").hide();

		$("#pallets").hide();
		$("#boxes").hide();
		
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

	});
</script>


<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/qc_update');?>" method="POST">
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
								<input type="date" name="email_date" id="email_date" value="<?php echo set_value('email_date',$row->email_date);?>" readonly/>&nbsp;&nbsp;&nbsp;
								Complaint Source <span style="color:red;">*</span>
								
								<select name="complaint_source" id="complaint_source" disabled>
									<option value="">Select Complaint Source</option>
									<option value="0" <?php echo set_select('complaint_source',$row->complaint_source);?> <?php echo($row->complaint_source=='0'?'selected':'');?> >Internal</option>
									<option value="1" <?php echo set_select('complaint_source',$row->complaint_source);?> <?php echo($row->complaint_source=='1'?'selected':'');?> >External</option>
								</select>
							</td>	
						</tr>
						<tr id="tr_invoice">
							<td class="label">Invoice No.<span style="color:red;">*</span> :</td>
							<td><input type="text" name="invoice_no" id="invoice_no" value="<?php echo set_value('invoice_no',($row->complaint_source==1?$row->reference_no:''));?>" placeholder="Enter Invoice No." readonly/>
							</td>
						</tr>

						<tr id="tr_order">
							<td class="label">Order No.<span style="color:red;">*</span> :</td>
							<td><input type="text" name="order_no" id="order_no" value="<?php echo set_value('order_no',($row->complaint_source==0?$row->reference_no:''));?>" placeholder="Enter Order No." readonly/>
							</td>
						</tr>
						
						<tr id="tr_article_no">
							<td class="label">Article No<span style="color:red;">*</span> :</td>
							<td colspan="4">
							<span id="sp_article_no" style="font-size:12px;color:black;">
								
								<table class="ui compact table"  style="font-size:9px;">
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

										if($checked!=''){

											echo'<tr>
												<td>'.$article_no_row->article_no.'
												</td>
												<td>'.$this->common_model->get_article_name($article_no_row->article_no,$this->session->userdata['logged_in']['company_id']).'</td>
												</tr>';
										}
										
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
							<select name="claim_inspection" id="claim_inspection" disabled>
								<option value="">Select Claim Inspection</option>
								<option value="1" <?php echo set_select('claim_inspection',1);?> <?php echo ($row->claim_inspection==1?'selected':'');?> >Incoming</option>
								<option value="2" <?php echo set_select('claim_inspection',2);?> <?php echo ($row->claim_inspection==2?'selected':'');?> >Online</option>
							</select>
						</td>
								
					</tr>
					<tr id="tr_invoice_tubes_checked">
							<td class="label">Tubes Checked<span style="color:red;">*</span> :</td>
							<td><input type="number" name="invoice_tubes_checked" id="invoice_tubes_checked" value="<?php echo set_value('invoice_tubes_checked',($row->complaint_source==1?$row->tubes_hold_checked:''));?>" placeholder="Enter No of tubes checked." min="0" max="1000000" step="1" readonly/>
							</td>
								 	
					</tr>
					<tr id="tr_order_tubes_hold">
						<td class="label">Tubes Hold<span style="color:red;">*</span> :</td>
						<td><input type="number" name="order_tubes_hold" id="order_tubes_hold" value="<?php echo set_value('order_tubes_hold',($row->complaint_source==0?$row->tubes_hold_checked:''));?>" placeholder="Enter No. of tubes hold" min="0" max="1000000" step="1" readonly/>
						</td>										 
							
					</tr>
					<tr>
						<td class="label">Defective Tubes<span style="color:red;">*</span> :</td>
						<td><input type="number" name="defective_tubes" name="defective_tubes" value="<?php echo set_value('defective_tubes', $row->defective_tubes);?>" placeholder="No. of Defective Tubes" min="1" max="1000000" step="1" readonly/>		
						</td>
							
					</tr>
					<tr>
						<td class="label">Pallets Checked</td>
						<td>
							 <input type="checkbox" name="is_pallet_checked"  id="is_pallet_checked" value="1" <?php echo set_checkbox('is_pallet_checked',$row->is_pallet_checked,($row->is_pallet_checked==1?true:false));?> disabled /> 
							<input type="number" name="pallets" id="pallets" min="0" max="1000" step="1"  value="<?php echo set_value('pallets',$row->pallets);?>"  Placeholder="No. Of Pallets" readonly/>
						</td>
					</tr>
					<tr>
						<td class="label">Box Checked</td>
						<td>
							<input type="checkbox" name="is_box_checked" id="is_box_checked" value="1" <?php echo set_checkbox('is_box_checked',$row->is_box_checked,($row->is_box_checked==1?true:false));?> disabled/>
							<input type="number" name="boxes" id="boxes" min="0" max="1000" step="1"  value="<?php echo set_value('boxes',$row->boxes);?>" Placeholder="No. Of Boxes" readonly/></td>

					</tr>							 
					<tr>
						<td class="label">Evidence<span style="color:red;">*</span> :</td>
						<td><input type="file" multiple="" name="images[]" disabled/>
						<input type="hidden" name="image_name" value="<?php echo set_value('image_name',$row->images);?>">

						<?php 
						if($row->images!=''){
							$img_arr=explode(",",$row->images);
							//print_r($img_arr);
							
							foreach ($img_arr as $key => $image_name) {

								$arr=explode(".",$image_name);
								if(count($arr)>1 && strtolower($arr[1])=='mp4'){
									echo'<video width="50" height="50" controls>
										<source src="'.base_url('assets/'.$this->session->userdata['logged_in']['company_id'].'/complaints/'.$image_name.'').'" type="video/mp4">
									</video>';

								}else{
									echo ($image_name!='' ? '<a href="'.base_url('assets/'.$this->session->userdata['logged_in']['company_id'].'/complaints/'.$image_name.'').'" target="_blank"><i class="file pdf outline icon"></i></a>' :'');
									
								}
								
								//echo'<a href="'.base_url('assets/'.$this->session->userdata['logged_in']['company_id'].'/complaints/'.$image_name.'').'" target="_blank"><i class="file pdf outline icon"></i></a>';
							}
							
							
						}
						?>
			
						</td>
					</tr>
					<tr>
						<td class="label">Nature of complaint<span style="color:red;">*</span> :</td>
						<td><select name="complaint_nature[]" id="complaint_nature[]" multiple="true" style="height:200px;" size="9" disabled><option value=''>--Select Nature Of Complaint--</option>
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
							</select>
							</td>
						</tr>
						<tr>
							<td class="label">Shift :</td>
							<td>
								<select name="shift" id="shift" disabled>
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
								<select name="machine" id="machine" disabled>
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
							<td><input type="text" name="operator" id="operator" value="<?php echo set_value('operator',$row->operator);?>" readonly/>
							</td>							
						</tr>
						<tr>
							<td class="label">Comment <span style="color:red;">*</span> :</td>
							<td><textarea name="comment" rows="10" cols="60" value="<?php echo set_value('comment');?>" placeholder="Enter the comment" readonly><?php echo set_value('comment',$row->comment);?></textarea></td>
						</tr>

							
												 
				</table>
			</td>				 
			<td width="50%">
						<table class="form_table_inner">
							<tr>	 
								<td class="label">Hourly Samples check <span style="color:red;">*</span> :</td>
								<td>
									<select name="hourly_samples_check" >
										<option value="" <?php echo set_select('hourly_samples_check',$row->hourly_samples_check);?> <?php echo($row->hourly_samples_check==''?"selected":"");?> >SELECT</option>							
										<option value="1" <?php echo set_select('hourly_samples_check',$row->hourly_samples_check);?> <?php echo($row->hourly_samples_check=='1'?"selected":"");?> >YES</option>
										<option value="0" <?php echo set_select('hourly_samples_check',$row->hourly_samples_check);?>  <?php echo($row->hourly_samples_check=='0'?"selected":"");?>>NO</option>		 
									</select>
									&nbsp; Retention Samples check  : 
									<select name="retention_samples_check" >							<option value="" <?php echo set_select('retention_samples_check',$row->retention_samples_check);?> <?php echo($row->retention_samples_check==''?"selected":"");?> >SELECT</option>

										<option value="1" <?php echo set_select('retention_samples_check',$row->retention_samples_check);?> <?php echo($row->retention_samples_check=='1'?"selected":"");?> >YES</option>
										<option value="0" <?php echo set_select('retention_samples_check',$row->retention_samples_check);?> <?php echo($row->retention_samples_check=='0'?"selected":"");?>>NO</option>		 
									</select>
								</td>
							</tr>							 
							<tr>
								<td class="label">BPR Check <span style="color:red;">*</span> :</td>
								<td>
									<select name="bpr_check" >
										<option value="" <?php echo set_select('bpr_check',$row->bpr_check);?> <?php echo($row->bpr_check==''?"selected":"");?> >SELECT</option>							
										<option value="1" <?php echo set_select('bpr_check',$row->bpr_check);?> <?php echo($row->bpr_check=='1'?"selected":"");?>>YES</option>
										<option value="0" <?php echo set_select('bpr_check',$row->bpr_check);?> <?php echo($row->bpr_check=='0'?"selected":"");?> <?php echo($row->bpr_check=='0'?"selected":"");?>>NO</option>		 
									</select>
									&nbsp;Samples Recieved :
									<select name="samples_recieved" >
										<option value="" <?php echo set_select('samples_recieved',$row->samples_recieved);?> <?php echo($row->samples_recieved==''?"selected":"");?> >SELECT</option>

										<option value="1" <?php echo set_select('samples_recieved',$row->samples_recieved);?> <?php echo($row->samples_recieved=='1'?"selected":"");?>>YES</option>
										<option value="0" <?php echo set_select('samples_recieved',$row->samples_recieved);?> <?php echo($row->samples_recieved=='0'?"selected":"");?>>NO</option>		 
									</select>
								</td>
							</tr>
							 
							<tr>
								<td class="label">Any Known Problem  :</td>
								<td>
									<select name="any_known_problem" >
										<option value="" <?php echo set_select('any_known_problem',$row->any_known_problem);?> <?php echo($row->any_known_problem==''?"selected":"");?> >SELECT</option>
																	
										<option value="1" <?php echo set_select('any_known_problem',$row->any_known_problem);?> <?php echo($row->any_known_problem=='1'?"selected":"");?>>YES</option>
										<option value="0" <?php echo set_select('any_known_problem',$row->any_known_problem);?> <?php echo($row->any_known_problem=='0'?"selected":"");?> >NO</option>		 
									</select>
								</td>
							</tr>
							<tr>
								<td class="label">Stage Problem Occurance :</td>
								<td>
									<input type="text" name="stage_problem_occurance" id="stage_problem_occurance"  value="<?php echo set_value('stage_problem_occurance',$row->stage_problem_occurance);?>" size="20" maxlength="100" required/> 
								</td>
							</tr>										
							<tr>
								<td class="label">Non-Conformity Details <span style="color:red;">*</span> :</td>
								<td><textarea name="investigation" rows="10" cols="50" value="<?php echo set_value('investigation');?>" required><?php echo set_value('investigation',$row->investigation);?></textarea></td>
							</tr>
							<tr>
								<td class="label">Investigation/Root Cause <span style="color:red;">*</span> :</td>
								<td><textarea name="root_cause"  rows="10" cols="50" value="<?php echo set_value('root_cause',$row->root_cause);?>" required><?php echo set_value('root_cause',$row->root_cause);?></textarea></td>
							</tr>
							<tr>
								<td class="label">Corrective Action <span style="color:red;">*</span> :</td>
								<td><textarea name="corrective_action" rows="10" cols="50" value="<?php echo set_value('corrective_action',$row->corrective_action);?>" required><?php echo set_value('corrective_action',$row->corrective_action);?></textarea></td>
							</tr>
							<tr>
								<td class="label" >
									Corrective Action Date <span style="color:red;">*</span> :
								</td>
								<td><input type="date" name="corrective_action_date" id="corrective_action_date"   value="<?php echo set_value('corrective_action_date',$row->corrective_action_date);?>"   /></td>
							</tr>
							<tr>
								<td class="label">Preventive Action <span style="color:red;">*</span> :</td>
								<td><textarea name="preventive_action"  rows="10" cols="50" value="<?php echo set_value('preventive_action',$row->preventive_action);?>" required><?php echo set_value('preventive_action',$row->preventive_action);?></textarea></td>
							</tr>
							<tr>
								<td class="label" >
									Preventive Action Date <span style="color:red;">*</span> :
								</td>
								<td><input type="date" name="preventive_action_date" id="preventive_action_date"   value="<?php echo set_value('preventive_action_date',$row->preventive_action_date);?>" /></td>
							</tr>
							<tr>
								<td class="label" >
								 <b>Training Provided</b>
								</td>
								<td>
									<input type="checkbox" name="is_training_provided" value="1" <?php echo set_checkbox('is_training_provided',1,($row->is_training_provided==1?true:false));?> >
									&nbsp;&nbsp;&nbsp;Training Date : &nbsp;&nbsp; 
									<input type="date" name="training_date" id="training_date"   value="<?php echo set_value('training_date',$row->training_date);?>"   />
								</td>
							</tr>
							<tr>
								<td class="label">Training Doc :</td>
								<td>
									<input type="file" name="training_doc">
									<input type="hidden" name="training_doc" value="<?php echo set_value('training_doc',$row->training_docs);?>">
									<?php 
										if($row->training_docs!=''){
											
											echo'<a href="'.base_url('assets/'.$this->session->userdata['logged_in']['company_id'].'/complaints/'.$row->training_docs.'').'" target="_blank"><i class="file pdf outline icon"></i>
											</a>';														
										}
									?>

								</td>
							</tr>
							<tr>
								<td class="label">Time Scale for Verification of Effectiveness  :</td>
								<td>
									<textarea name="verification_of_effectiveness" maxlength="512" rows="5" cols="50" value="<?php echo set_value('verification_of_effectiveness',$row->verification_of_effectiveness);?>"><?php echo set_value('verification_of_effectiveness',$row->verification_of_effectiveness);?></textarea>
								</td>
							</tr>
							<tr>
								<td class="label">Effectiveness of Action taken  :</td>
								<td>
									<textarea name="effectiveness_action_taken" maxlength="512" rows="5" cols="50" value="<?php echo set_value('effectiveness_action_taken',$row->effectiveness_action_taken);?>"><?php echo set_value('effectiveness_action_taken',$row->effectiveness_action_taken);?></textarea>
								</td>
							</tr>
							<tr>
								<td class="label">Cost of Poor Quality <span style="color:red;">*</span> :</td>
								<td><input type="number"  name="poor_quality_cost" name="poor_quality_cost" min="0" max="10000000" step="any" value="<?php echo set_value('poor_quality_cost',$row->poor_quality_cost);?>" required/>
									
								</td>								
							</tr>
							<tr>
								<td class="label">Complaint Status <span style="color:red;">*</span> :</td>
								<td>
									<select name="complaint_status" id="complaint_status" >
										<option value="" <?php echo set_select('complaint_status','');?> <?php echo($row->complaint_status==''?'selected':'');?>>Select Complaint Status</option>
										<option value="0" <?php echo set_select('complaint_status',0);?> <?php echo($row->complaint_status=='0'?'selected':'');?>>Rejected</option>
										<option value="1" <?php echo set_select('complaint_status',1);?> <?php echo($row->complaint_status=='1'?'selected':'');?>>Accepted</option>
										<option value="2" <?php echo set_select('complaint_status',2);?> <?php echo($row->complaint_status=='2'?'selected':'');?>>Observation</option>
									</select>
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
				
				
				
				
				
			