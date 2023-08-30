
<div class="record_form_design">
	<h3>Active Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th>Article No</th>
					<th>Packing Box</th>
					<th>Ply</th>
					<th>Type</th>
					<th>Height</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($packing_box_parameter_master==FALSE){
					echo "<tr><td colspan='6'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)=='' ? 1 : $this->uri->segment(3));
							foreach($packing_box_parameter_master as $row){
								echo "<tr>
									<td>".$i++."</td>
									<td>".$row->article_no."</td>
									<td>$row->article_name </td>
									<td>$row->ply</td>
									<td>$row->type</td>
									<td>".$this->common_model->read_number($row->height,$this->session->userdata['logged_in']['company_id'])."</td>
								
									<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>
									<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->pbp_id.'').">Modify</a><a href=".base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->pbp_id.'')."> | Delete</a>

									</td>
							</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
	</div>
</div>