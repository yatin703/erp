<style>	
   tr:hover {background-color:#e4e4e4;}
</style>
<div class="record_form_design">
<h4>Active Records</h4>
	<div class="record_inner_design"  style="overflow: scroll; white-space: nowrap;">
			<table class="ui very basic collapsing celled table"  style="font-size:9px;">
				<thead>
				<tr>
					<th colspan="21" style="text-align: center;">Sales</th>
					<th colspan="23" style="text-align: center;">QC</th>
					
				</tr>
				<tr>
					<th>Sr No.</th>
					<th>Action</th>
					<th>Email Date</th>
					<th>Complaint Date</th>
					<th>Complaint No</th>
					<th>Customer</th>
					<th>Refrence No.</th>
					<th>Article No</th>
					<th>Qty</th>					
					<th>Complaint Source</th>
					<th>Claim Inspection</th>
					<th>Tubes CHecked/Hold</th>										
					<th>Defective Tubes</th>
					<th>Pallet Checked</th>
					<th>No. Of Pallets</th>
					<th>Box Checked</th>
					<th>No. Of Boxes</th>
					<th>Evidence</th>
					<th>Complaint Nature</th>
					<th>Shift</th>
					<th>Machine</th>
					<th>Responsible Person</th>
					<th>Comment</th>
					<th>Created by</th>	
					<th>QC Check</th>					
					<th>QC Date</th>
					<th>QC Name</th>
					<th>Hourly Samples check</th>				
					<th>Retention Samples check</th>
					<th>BPR Check </th>
					<th>Samples Recieved</th>
					<th>Stage Problem Occurance</th>
					<th>Any Known Problem</th>
					<th>Investigation</th>
					<th>Root Cause</th>
					<th>Corrective Action</th>
					<th>Preventive Action</th>
					<th>Training Provided?</th>
					<th>Training Date</th>
					<th>Training Docs</th>
					<th>Time Scale for Verification of Effectiveness</th>
					<th>Effectiveness of Action taken</th>
					<th>Cost of Poor Quality</th>
					<th>Complaint Status</th>			 					
					
				</tr>
			</thead>
			<tbody>
				<?php 				 

				if($capa_complaint_register_master==FALSE){
					echo "<tr><td colspan='19'>No Active Records Found</td></tr>";
				}else{
						$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
							 	
						foreach($capa_complaint_register_master as $row){
							$customer='';						 
								
							echo"<tr>
								<td>".$i."</td>
								<td>";
								foreach($formrights as $formrights_row){ 

										echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->id).'" target="_blank"><i class="print icon"></i></a> ' : '');

										echo ($formrights_row->modify==1  ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->id).'" target="_blank"><i class="edit icon"></i></a> ' : '');

										//echo ($formrights_row->copy==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/copy/'.$row->id).'" target="_blank"><i class="copy icon"></i></a> ' : '');										
										echo ($row->archive<>1 && $formrights_row->delete==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->id).'"><i class="trash icon" target="_blank"></i></a> ' : '');


																														
									}
								echo"</td>
								<td>".$this->common_model->view_date($row->email_date,$this->session->userdata['logged_in']['company_id'])."</td>
								
								<td>".$this->common_model->view_date($row->complaint_date,$this->session->userdata['logged_in']['company_id'])."</td>
								<td>";
								echo '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->id).'" target="_blank">'.$row->complaint_no.'</a>';
								echo "</td>
								<!--<td>".$this->common_model->get_customer_name($row->customer,$this->session->userdata['logged_in']['company_id'])."</td>
								-->
								<td>";
								$arr=explode(",", $row->article_no);
								//echo $arr[0];
								if(count($arr)>0){
									if($arr[0]!=''){
										echo $this->common_model->get_parent_name($arr[0],$this->session->userdata['logged_in']['company_id']);	
									}
								}
								
								echo
								"</td>

								<td>".$row->reference_no."</td>
								<td>".$row->article_no."</td>
								<td>".($row->qty!=''?number_format($row->qty,0,'.',','):"")."</td>
								<td>".($row->complaint_source==1?"EXTERNAL":"INTERNAL")."</td>
								<td>".($row->claim_inspection==1?"INCOMING":"ONLINE")."</td>
								<td>".($row->tubes_hold_checked!=''?number_format($row->tubes_hold_checked,0,'.',','):"")."</td>
								<td>".($row->defective_tubes!=''?number_format($row->defective_tubes,0,'.',','):"")."</td>
								<td>".($row->is_pallet_checked==1?"YES":"NO")."</td>
								<td>".$row->pallets."</td>
								<td>".($row->is_box_checked==1?"YES":"NO")."</td>
								<td>".$row->boxes."</td>
								<td>";

								$array=explode(",",$row->images);
								foreach ($array as $key => $image_name) {
									if($image_name!=''){
										$arr=explode(".",$image_name);
										if(count($arr)>1 && strtolower($arr[1])=='mp4'){
											echo'<video width="20" height="50" controls>
												<source src="'.base_url('assets/'.$this->session->userdata['logged_in']['company_id'].'/complaints/'.$image_name.'').'" type="video/mp4">
											</video>';

										}else{
											echo ($image_name!='' ? '<a href="'.base_url('assets/'.$this->session->userdata['logged_in']['company_id'].'/complaints/'.$image_name.'').'" target="_blank"><i class="file pdf outline icon"></i></a>' :'');
											
										}
										echo'&nbsp';
									}

									
								}
								echo"</td>
								<td>".strtoupper($row->complaint_nature)."</td>
								<td>".strtoupper($row->shift)."</td>
								<td>".strtoupper($row->machine)."</td>
								<td>".strtoupper($row->operator)."</td>  
								<td>".substr($row->comment,0,15)."</td>
								<td>".$this->common_model->get_user_name($row->user_id,$this->session->userdata['logged_in']['company_id'])."</td>
								<td>";								
								if($formrights_row->new=='1' && $formrights_row->copy=='1' && $row->qc_check =='0'){ 

									echo '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/qc/'.$row->id).'" title="Qc Form" target="_blank"><i class="edit icon"></i></a>';

								}elseif($row->qc_check==1){
									echo"<i style='color:#06c806;' class='check circle icon'></i>";
								}
								if($row->qc_check =='0' && $formrights_row->copy=='0'){

									echo'<a href="#" style="color: #f10606;"><i class="times circle icon"></i> QC Pending </a>';
								}
								if($formrights_row->modify=='1' && $formrights_row->copy=='1' && $row->qc_check =='1' ){ 

									echo '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/qc_modify/'.$row->id).'" title="Qc Modify" target="_blank"><i class="edit icon"></i></a>';

								}

							echo"</td>
							<td>".($row->qc_date!=''?$this->common_model->view_date($row->qc_date,$this->session->userdata['logged_in']['company_id']):"")."</td>
							<td>".$this->common_model->get_user_name($row->qc_name,$this->session->userdata['logged_in']['company_id'])."</td>
							<td>".($row->hourly_samples_check!=''?($row->hourly_samples_check=='1'?"YES":"NO"):'')."</td>
							<td>".($row->retention_samples_check!=''?($row->retention_samples_check=='1'?"YES":"NO"):'')."</td>
							<td>".($row->bpr_check!=''?($row->bpr_check=='1'?"YES":"NO"):'')."</td>
							<td>".($row->samples_recieved!=''?($row->samples_recieved=='1'?"YES":"NO"):'')."</td>
							<td>".$row->stage_problem_occurance."</td>
							<td>".($row->any_known_problem!=''?($row->any_known_problem=='1'?"YES":"NO"):'')."</td>
							<td>".substr($row->investigation,0,15)."</td>
							<td>".substr($row->root_cause,0,15)."</td>
							<td>".substr($row->corrective_action,0,15)."</td>
							<td>".substr($row->preventive_action,0,15)."</td>
							<td>".($row->is_training_provided=='1'?"YES":"")."</td>
							<td>".($row->training_date!=''?$this->common_model->view_date($row->training_date,$this->session->userdata['logged_in']['company_id']):"")."</td>
							<td>".($row->training_docs!='' ? '<a href="'.base_url('assets/'.$this->session->userdata['logged_in']['company_id'].'/complaints/'.$row->training_docs.'').'" target="_blank"><i class="file pdf outline icon"></i></a>' :'')."</td>
							<td>".substr($row->verification_of_effectiveness,0,15)."</td>
							<td>".substr($row->effectiveness_action_taken,0,15)."</td>
							<td>".$row->poor_quality_cost."</td>
							<td>";
							if($row->complaint_status=='1'){
								echo "ACCEPTED";
							}
							else if($row->complaint_status=='2'){
								echo "OBSERVATION";
							}
							else if($row->complaint_status=='0'){
								echo "REJECTED";
							}
							else{
								echo "";
							}
							echo"</td>
							</tr>";				 


							$i++;
							}
						}?>							 
						</tbody> 	
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>