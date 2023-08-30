<div class="record_form_design">
	<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
<h4>Active Records</h4>
	<div class="record_inner_design" style="overflow: scroll;">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th>Application Date</th>
					<th>Capex No</th>
					<th>Project Name</th>
					<th>Total Amount</th>
					<th>Applicant</th>
					<th>Attachment</th>
					<th>Approved Date</th>
					<th>Action</th>
				</tr>
				<?php if($capex==FALSE){
					echo "<tr><td colspan='16'>No Active Records Found</td></tr>";
				}else{
						$i=1;
						foreach($capex as $capex_row){

							echo "<tr>
									<td>".$i."</td>
									<td>".$this->common_model->view_date($capex_row->capex_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$capex_row->capex_no."</td>
									<td>".$capex_row->project_name."</td>
									<td>".$capex_row->total_amount."</td>
									<td>".$capex_row->username."</td>
									<td>".($capex_row->capex_file!='' ? '<a href="'.base_url('assets/'.$this->session->userdata['logged_in']['company_id'].'/capex/'.$capex_row->capex_file.'').'" target="_blank"><i class="file pdf outline icon"></i></a>' :'')."</td>
									<td>".$this->common_model->view_date($capex_row->approved_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>";

									foreach($formrights as $formrights_row){ 

										echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$capex_row->capex_no).'" target="_blank"><i class="print icon"></i></a> ' : '');


										echo ($formrights_row->modify==1 && $capex_row->final_approval_flag<>1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$capex_row->capex_no).'"><i class="edit icon"></i></a> ' : '');

										echo ($formrights_row->new==1 && $capex_row->final_approval_flag<>1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/attach/'.$capex_row->capex_no).'"><i class="attach icon"></i></a> ' : '');

										echo ($capex_row->archive<>1 && $formrights_row->delete==1 && $capex_row->final_approval_flag<>1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$capex_row->capex_no).'"><i class="trash icon"></i></a> ' : '');

										//echo ($formrights_row->copy==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/copy/'.$capex_row->capex_no).'" target="_blank"><i class="copy icon"></i></a> ' : '');
										
									} echo "</td>
									</tr>";
							$i++;
						}
					}
					?>
								
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>