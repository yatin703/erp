<div class="record_form_design">
<h3>Received Records</h3>
<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th>Date</th>
					<th>From</th>
					<th>TO</th>
					<th>Record No</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($followup_received==FALSE){
					echo "<tr><td colspan='14'>No Active Records Found</td></tr>";
				}else{
					$i=1;
							foreach($followup_received as $followup_received_row){

								echo "<tr>
									<td>$i</td>
									<td>".$this->common_model->view_date($followup_received_row->followup_date,$this->session->userdata['logged_in']['company_id'])."</td>
									
									<td>".strtoupper($followup_received_row->from_user)."</td>
									<td>".strtoupper($followup_received_row->to_user)."</td>
									<td>".str_replace('@@@', '_', $followup_received_row->record_no)."</td>
									<td>".($followup_received_row->status==1 ? 'PENDING' : '')."</td>
									<td>";
									foreach($formrights as $formrights_row){ 

										$arr = explode("@@@", $followup_received_row->record_no);

										$data=array('bom_no'=>$arr[0],
											'bom_version_no'=>$arr[1]);
										$bom_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data);
										if($bom_result){
											foreach($bom_result as $bom_row){
												$bom_id=$bom_row->bom_id;
											}
										}else{
											$bom_id="";
										}
										echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/bill_of_material/view/'.$bom_id).'" target="_blank"><i class="print icon"></i></a> ' : '');

										echo ($formrights_row->new==1 ? 
											'<a href="'.base_url('index.php/'.$this->router->fetch_class().'/approved/'.str_replace('@@@','/', $followup_received_row->record_no)).'/'.$followup_received_row->transaction_no.'"><i class="thumbs outline up icon"></i> 
											&nbsp; 

											<a href="'.base_url('index.php/'.$this->router->fetch_class().'/notapproved/'.str_replace('@@@','/', $followup_received_row->record_no)).'/'.$followup_received_row->transaction_no.'" ><i class="thumbs outline down icon"></i>'
											 : 
											 '');

										echo ($formrights_row->copy==1 ? '<a href="#">Copy</a> ' : '');

										echo ($formrights_row->modify==1 ? '<a href="">Modify</a> ' : '');

										echo ($formrights_row->delete==1 ? '<a href="">Delete</a> ' : '');
									}
									echo "</td>
							</tr>";
							$i++;
							}
						}?>
								
			</table>
	</div>

	<h3>Sent Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th>Date</th>
					<th>From</th>
					<th>TO</th>
					<th>Record No</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($followup_sent==FALSE){
					echo "<tr><td colspan='14'>No Active Records Found</td></tr>";
				}else{
					$i=1;
							foreach($followup_sent as $followup_sent_row){

								echo "<tr>
									<td>$i</td>
									<td>".$this->common_model->view_date($followup_sent_row->followup_date,$this->session->userdata['logged_in']['company_id'])."</td>
									
									<td>".strtoupper($followup_sent_row->from_user)."</td>
									<td>".strtoupper($followup_sent_row->to_user)."</td>
									<td>".str_replace('@@@', '_', $followup_sent_row->record_no)."</td>
									<td>".($followup_sent_row->status==1 ? 'PENDING' : '')."</td>
									<td>";
									foreach($formrights as $formrights_row){ 
										$a=str_replace('@@@','/', $followup_sent_row->record_no);
										if(substr($a,0,1)=='C'){ 
												$ab="view_cap";
											}else{ 
												$ab="view";
											}
										echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/specification/'.$ab.'/'.str_replace('@@@','/', $followup_sent_row->record_no)).'" target="_blank"><i class="print icon"></i></a> ' : '');


										echo ($formrights_row->copy==1 ? '<a href="#">Copy</a> ' : '');

										echo ($formrights_row->modify==1 ? '<a href="">Modify</a> ' : '');

										echo ($formrights_row->delete==1 ? '<a href="">Delete</a> ' : '');
									}
									echo "</td>
							</tr>";
							$i++;
							}
						}?>
								
			</table>
	</div>


</div>