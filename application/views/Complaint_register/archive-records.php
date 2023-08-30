<style>	
   tr:hover {background-color:#e4e4e4;}
</style>
<div class="record_form_design">
<h4>Archive Records</h4>
	<div class="record_inner_design"  style="overflow: scroll; white-space: nowrap;">
			<table class="record_table_design_without_fixed">
				<tr>
					<th colspan="20" style="text-align: center;">Sales</th>
					<th colspan="18" style="text-align: center;">QC</th>
					
				</tr>
				<tr>
					<th>Sr No.</th>
					<th>Action</th>
					<th>Complaint Date</th>
					<th>Complaint No</th>
					<th>Customer</th>
					<th>Refrence No.</th>
					<th>Article No</th>
					<th>Qty</th>					
					<th>Complaint Source</th>					
					<th>Defective Tubes</th>
					<th>Complaint Nature</th>
					<th>Pallet Checked</th>
					<th>No. Of Pallets</th>
					<th>Box Checked</th>
					<th>No. Of Boxes</th>
					<th>Claim Inspection</th>
					<th>Complaint Status</th>
					<th>Evidence</th>
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
					<th>Time Scale for Verification of Effectiveness</th>
					<th>Effectiveness of Action taken</th>
					<th>Cost of Poor Quality</th>
					

				 					
					
				</tr>
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
																			
										echo ($row->archive==1 && $formrights_row->dearchive==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/dearchive/'.$row->id).'"><i class="edit icon" target="_blank"></i></a> ' : '');


																														
									}
								echo"</td>
								<td>".$this->common_model->view_date($row->complaint_date,$this->session->userdata['logged_in']['company_id'])."</td>
								<td>".$row->complaint_no."</td>
								<td>".$this->common_model->get_customer_name($row->customer,$this->session->userdata['logged_in']['company_id'])."</td>
								<td>".$row->reference_no."</td>
								<td>".$row->article_no."</td>
								<td>".($row->qty!=''?number_format($row->qty,0,'.',','):"")."</td>
								<td>".($row->complaint_source==1?"EXTERNAL":"INTERNAL")."</td>
								<td>".($row->defective_tubes!=''?number_format($row->defective_tubes,0,'.',','):"")."</td>
								
								<td>".strtoupper($row->complaint_nature)."</td>";
								// $complaint_arr=explode(",",$row->complaint_nature);
								// $complaint_nature_result=$this->common_model->select_active_records_where_in('capa_complaint_nature_master',$data=array(),'id',$complaint_arr);
								// foreach ($complaint_nature_result as $key => $complaint_nature_row) {
								// 	echo strtoupper($complaint_nature_row->complaints).', ';
								// }


								echo "
								<td>".($row->is_pallet_checked==1?"YES":"NO")."</td>
								<td>".$row->pallets."</td>
								<td>".($row->is_box_checked==1?"YES":"NO")."</td>
								<td>".$row->boxes."</td>
								<td>".($row->claim_inspection==1?"INCOMING":"ONLINE")."</td>
								<td>".($row->complaint_status==1?"ACCEPTED":"REJECTED")."</td>
								<td>";

								$array=explode(",",$row->images);
								foreach ($array as $key => $image_name) {
									echo ($image_name!='' ? '<a href="'.base_url('assets/'.$this->session->userdata['logged_in']['company_id'].'/complaints/'.$image_name.'').'" target="_blank"><i class="file pdf outline icon"></i></a>' :'');
									echo'&nbsp';
								}

								echo"</td>
								<td>".$row->comment."</td>
								<td>".$this->common_model->get_user_name($row->user_id,$this->session->userdata['logged_in']['company_id'])."</td>
								<td>";

								
								if($formrights_row->new=='1' && $formrights_row->copy=='1' && $row->qc_check =='0'){ 

									echo '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/qc/'.$row->id).'" title="Qc" target="_blank"><i class="edit icon"></i></a>';

								}elseif($row->qc_check==1){
									echo"<i style='color:#06c806;' class='check circle icon'></i>";
								}
								if($row->qc_check =='0'){

									echo'<a href="#" style="color: #f10606;"><i class="times circle icon"></i>Pending</a>';
								}
								if($formrights_row->modify=='1' && $formrights_row->copy=='1'){ 

									echo '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/qc_modify/'.$row->id).'" title="Qc" target="_blank"><i class="edit icon"></i></a>';

								}

							echo"</td>
							<td>".($row->qc_date!=''?$this->common_model->view_date($row->qc_date,$this->session->userdata['logged_in']['company_id']):"")."</td>
							<td>".$this->common_model->get_user_name($row->qc_name,$this->session->userdata['logged_in']['company_id'])."</td>
							<td>".($row->hourly_samples_check==1?"YES":"NO")."</td>
							<td>".($row->retention_samples_check==1?"YES":"NO")."</td>
							<td>".($row->bpr_check==1?"YES":"NO")."</td>
							<td>".($row->samples_recieved==1?"YES":"NO")."</td>
							<td>".($row->stage_problem_occurance==1?"YES":"NO")."</td>
							<td>".($row->any_known_problem==1?"YES":"NO")."</td>
							<td>".$row->investigation."</td>
							<td>".$row->root_cause."</td>
							<td>".$row->corrective_action."</td>
							<td>".$row->preventive_action."</td>
							<td>".($row->is_training_provided==1?"YES":"NO")."</td>
							<td>".($row->training_date!=''?$this->common_model->view_date($row->training_date,$this->session->userdata['logged_in']['company_id']):"")."</td>
							<td>".$row->verification_of_effectiveness."</td>
							<td>".$row->effectiveness_action_taken."</td>
							<td>".$row->poor_quality_cost."</td></tr>";				 


							$i++;
							}
						}?>							 
							 	
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>