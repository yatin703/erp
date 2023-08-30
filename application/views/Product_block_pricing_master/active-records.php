<div class="record_form_design" >
<h3>Active Records</h3>
	<div class="record_inner_design" style="overflow: scroll;white-space: normal;">
			<table class="record_table_design">
				<tr>
					<th>Id</th>
					<th>Block</th>
					<th>From</th>
					<th>To</th>
					<th>Action</th>
				</tr>
				<?php if($product_block_pricing_master==FALSE){
					echo "<tr><td colspan='3'>No Active Records Found</td></tr>";
				}else{
							foreach($product_block_pricing_master as $row){

								echo "<tr>
									<td>$row->pbpm_id</td>
									<td>$row->block_name</td>
									<td>".money_format('%!.0n',$this->common_model->read_number($row->block_from,$this->session->userdata['logged_in']['company_id']))."</td>
									<td>".money_format('%!.0n',$this->common_model->read_number($row->block_to,$this->session->userdata['logged_in']['company_id']))."</td>
									<td>";
									foreach($formrights as $formrights_row){ 
										//echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->pbpm_id.'').'" target="_blank"><i class="print icon"></i></a> ' : '');
										echo ($formrights_row->copy==1 ? '<a href="#">Copy</a> ' : '');
										echo ($formrights_row->modify==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->pbpm_id.'').'"><i class="edit icon"></i></a> ' : '');
										echo ($row->archive<>1 && $formrights_row->delete==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->pbpm_id.'').'"><i class="trash icon"></i></a> ' : '');
									}
									echo "</td>
							</tr>";
							}
						}?>
								
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>