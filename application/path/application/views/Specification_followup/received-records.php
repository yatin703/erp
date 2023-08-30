<div class="record_form_design">
<h3>Received Records</h3>
<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th>Date</th>
					<th>From</th>
					<th>To</th>
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
									<td>";
									$a=str_replace('@@@', ' ', $followup_received_row->record_no);

									if(substr($a,0,2)!='SP'){
									$abcd=str_replace('@@@', ' ', $followup_received_row->record_no);
									$arr=explode(" ",$abcd);
									$data=array('spec_id'=>$arr[0],
										'spec_version_no'=>$arr[1]);
									$this->load->model('common_model');
									$result=$this->common_model->select_active_records_where("specification_sheet",$this->session->userdata['logged_in']['company_id'],$data);
									foreach($result as $result_row){

										echo $result_row->article_no;
									}
									}
									/*
									if(substr($a,0,2)=='FS'){
									$abcd=str_replace('@@@', ' ', $followup_received_row->record_no);
									$arr=explode(" ",$abcd);
									$data=array('spec_id'=>$arr[0],
										'spec_version_no'=>$arr[1]);
									$this->load->model('common_model');
									$result=$this->common_model->select_active_records_where("spring_specification_sheet",$this->session->userdata['logged_in']['company_id'],$data);
									foreach($result as $result_row){
											echo $result_row->article_no;
										}
									}else{
									echo str_replace('@@@', '_', $followup_received_row->record_no);
									}*/

									echo "</td>
									<td>".($followup_received_row->status==1 ? 'PENDING' : '')."</td>
									<td>";
									foreach($formrights as $formrights_row){ 
										$a=str_replace('@@@','/', $followup_received_row->record_no);
										if(substr($a,0,2)=='CS'){ 
												$ab="cap_specification/view_cap/".str_replace('@@@','/', $followup_received_row->record_no)."";
											}

											if(substr($a,0,2)=='HS'){ 
												$ab="shoulder_specification/view_shoulder/".str_replace('@@@','/', $followup_received_row->record_no)."";
											}

											if(substr($a,0,2)=='SL'){ 
												$ab="sleeve_specification/view/".str_replace('@@@','/', $followup_received_row->record_no)."";
											}

											if(substr($a,0,2)=='LS'){ 
												$ab="label_specification/view_label/".str_replace('@@@','/', $followup_received_row->record_no)."";
											}
											if(substr($a,0,2)=='SP'){ 
												$ab="specification/view/".str_replace('@@@','/', $followup_received_row->record_no)."";
											}

											if(substr($a,0,2)=='FS'){ 
												$ab="Spring_film_specification/view/".str_replace('@@@','/', $followup_received_row->record_no)."";
											}

										echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$ab).'" target="_blank"><i class="print icon"></i></a> ' : '');

										echo ($formrights_row->new==1 ? 
											'<a href="'.base_url('index.php/'.$this->router->fetch_class().'/approved/'.str_replace('@@@','/', $followup_received_row->record_no)).'/'.$followup_received_row->transaction_no.'"><i class="thumbs outline up icon"></i> 
											&nbsp; 

											<a href="'.base_url('index.php/'.$this->router->fetch_class().'/notapproved/'.str_replace('@@@','/', $followup_received_row->record_no)).'/'.$followup_received_row->transaction_no.'" ><i class="thumbs outline down icon"></i>'
											 : 
											 '');

										//echo ($formrights_row->copy==1 ? '<a href="#">Copy</a> ' : '');

										//echo ($formrights_row->modify==1 ? '<a href="">Modify</a> ' : '');

										//echo ($formrights_row->delete==1 ? '<a href="">Delete</a> ' : '');
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
					<th>To</th>
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
									<td>";

									$a=str_replace('@@@', ' ', $followup_sent_row->record_no);
									//echo substr($a,0,2);
									if(substr($a,0,2)!='SP'){
									$abcd=str_replace('@@@', ' ', $followup_sent_row->record_no);
									$arr=explode(" ",$abcd);
									$data=array('spec_id'=>$arr[0],
										'spec_version_no'=>$arr[1]);
									$this->load->model('common_model');
									$result=$this->common_model->select_active_records_where("specification_sheet",$this->session->userdata['logged_in']['company_id'],$data);
									foreach($result as $result_row){
											echo $result_row->article_no;
										}
									}
									/*
									if(substr($a,0,2)=='FS'){
									$abcd=str_replace('@@@', ' ', $followup_sent_row->record_no);
									$arr=explode(" ",$abcd);
									$data=array('spec_id'=>$arr[0],
										'spec_version_no'=>$arr[1]);
									$this->load->model('common_model');
									$result=$this->common_model->select_active_records_where("spring_specification_sheet",$this->session->userdata['logged_in']['company_id'],$data);
									foreach($result as $result_row){
											echo $result_row->article_no;
										}
									}
									else{
										echo str_replace('@@@', '_', $followup_sent_row->record_no);
									}*/

									echo "</td>
									<td>".($followup_sent_row->status==1 ? 'PENDING' : '')."</td>
									<td>";
									foreach($formrights as $formrights_row){ 


										$a=str_replace('@@@','/', $followup_sent_row->record_no);
										if(substr($a,0,2)=='CS'){ 
												$ab="cap_specification/view_cap/".str_replace('@@@','/', $followup_sent_row->record_no)."";
											}
											if(substr($a,0,2)=='HS'){ 
												$ab="shoulder_specification/view_shoulder/".str_replace('@@@','/', $followup_sent_row->record_no)."";
											}

											if(substr($a,0,2)=='SL'){ 
												$ab="sleeve_specification/view/".str_replace('@@@','/', $followup_sent_row->record_no)."";
											}

											if(substr($a,0,2)=='LS'){ 
												$ab="label_specification/view_label/".str_replace('@@@','/', $followup_sent_row->record_no)."";
											}
											if(substr($a,0,2)=='SP'){ 
												$ab="specification/view/".str_replace('@@@','/', $followup_sent_row->record_no)."";
											}
											if(substr($a,0,2)=='FS'){ 
												$ab="Spring_film_specification/view/".str_replace('@@@','/', $followup_sent_row->record_no)."";
											}
										echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$ab).'" target="_blank"><i class="print icon"></i></a> ' : '');

									}
									echo "</td>
							</tr>";
							$i++;
							}
						}?>
								
			</table>
	</div>


</div>