
<div class="record_form_design">
	<h3>Archive Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th>Sleeve Dia</th>
					<th>NO OF TUBES/BOX</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($packing_box_master==FALSE){
					echo "<tr><td colspan='5'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)==''?1:$this->uri->segment(3));
							foreach($packing_box_master as $row){
								echo "<tr>
									<td>".$i++."</td>
									<td>$row->sleeve_diameter</td>
									<td>".$this->common_model->read_number($row->no_of_tubes_per_box,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>
									<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/dearchive/'.$row->pbm_id.'').">Dearchive</a>

									</td>
							</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
	</div>
</div>