<div class="record_form_design">
	<h3>Archive Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th>Packing Box</th>
					<th>Type</th>
					<th>Height</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($packing_box_parameter_master==FALSE){
					echo "<tr><td colspan='6'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)==''?1:$this->uri->segment(3));
							foreach($packing_box_parameter_master as $row){
								echo "<tr>
									<td>".$i++."</td>
									<td>$row->article_name</td>
									<td>$row->type</td>
									<td>".$this->common_model->read_number($row->height,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>
									<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/dearchive/'.$row->pbp_id.'').">Dearchive</a>

									</td>
							</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
	</div>
</div>