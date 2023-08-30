<div class="record_form_design">
<h3>Rejected Records</h3>
<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
	<div class="record_inner_design">
			<table class="ui red sortable celled table">
				<thead>
				<tr>
					<th>Id</th>
					<th>Date</th>
					<th>From</th>
					<th>TO</th>
					<th>Record No</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				</thead>
				<tbody>
				<?php if($followup_rejected==FALSE){
					echo "<tr><td colspan='14'>No Active Records Found</td></tr>";
				}else{
					$i=1;
							foreach($followup_rejected as $followup_rejected_row){

								echo "<tr>
									<td>$i</td>
									<td>".$this->common_model->view_date($followup_rejected_row->followup_date,$this->session->userdata['logged_in']['company_id'])."</td>
									
									<td>".strtoupper($followup_rejected_row->from_user)."</td>
									<td>".strtoupper($followup_rejected_row->to_user)."</td>
									<td>".str_replace('@@@', '_', $followup_received_row->record_no)."</td>
									<td>".($followup_rejected_row->status==1 ? 'PENDING' : '')."</td>
									<td>";
									foreach($formrights as $formrights_row){ 
										echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/certificate_of_analysis/view/'.str_replace('@@@', '/', $followup_received_row->record_no))).'" target="_blank"><i class="print icon"></i></a> ' : '');

										echo ($formrights_row->new==1 ? '<a href="#"></i>': '');

										echo ($formrights_row->copy==1 ? '<a href="#">Copy</a> ' : '');

										echo ($formrights_row->modify==1 ? '<a href="">Modify</a> ' : '');

										echo ($formrights_row->delete==1 ? '<a href="">Delete</a> ' : '');
									}
									echo "</td>
							</tr>";
							$i++;
							}
						}?>
				</tbody>			
			</table>
	</div>


</div>