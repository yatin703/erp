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
							$ad_id='';
							$version_no='';
							$customer_artwork_pdf='';
							foreach($followup_received as $followup_received_row){

								if($followup_received_row->record_no!=''){
									$arr_artwork_springtube=explode("@@@",$followup_received_row->record_no);
									$ad_id=$arr_artwork_springtube[0];
									$version_no=$arr_artwork_springtube[1];

									$data['artwork_springtube']=$this->artwork_springtube_model->select_one_active_record('springtube_artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'springtube_artwork_devel_master.ad_id',$ad_id,'springtube_artwork_devel_master.version_no',$version_no);

									foreach ($data['artwork_springtube'] as  $artwork_springtube_row) {
										$customer_artwork_pdf=$artwork_springtube_row->customer_artwork_pdf;
									}
									

								}
								if($customer_artwork_pdf!=''){	
								echo "<tr>
									<td>$i</td>
									<td>".$this->common_model->view_date($followup_received_row->followup_date,$this->session->userdata['logged_in']['company_id'])."</td>
									
									<td>".strtoupper($followup_received_row->from_user)."</td>
									<td>".strtoupper($followup_received_row->to_user)."</td>
									<td>".str_replace('@@@', '_', $followup_received_row->record_no)."</td>
									<td>".($followup_received_row->status==1 ? 'PENDING' : '')."</td>
									<td>";
									foreach($formrights as $formrights_row){ 



										echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/artwork_springtube/view/'.$ad_id.'/'.$version_no).'" target="_blank"><i class="print icon"></i></a> &nbsp;&nbsp; ' : '');



										echo ($formrights_row->new==1 ? 
											'<a href="'.base_url('index.php/'.$this->router->fetch_class().'/approved/'.$ad_id.'/'.$version_no).'/'.$followup_received_row->transaction_no.'"><i class="thumbs outline up icon"></i> 
											&nbsp;
											&nbsp;  

											<a href="'.base_url('index.php/'.$this->router->fetch_class().'/notapproved/'.$ad_id.'/'.$version_no).'/'.$followup_received_row->transaction_no.'" ><i class="thumbs outline down icon"></i>'
											 : 
											 '');

										echo ($formrights_row->copy==1 ? '<a href="#">Copy</a> ' : '');

										echo ($formrights_row->modify==1 ? '<a href="">Modify</a> ' : '');

										echo ($formrights_row->delete==1 ? '<a href="">Delete</a> ' : '');
									}
									echo "</td>
									</tr>";
								}	


							    $i++;

							}

					}?>
								
			</table>
	</div>


</div>