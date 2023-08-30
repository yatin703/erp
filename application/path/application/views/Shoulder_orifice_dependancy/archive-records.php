
<div class="record_form_design">
	<h3>Archive Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th>Sleeve Diameter</th>
					<th>ShoulderType</th>
					<th>Shoulder Orifice</th>
					<th>Cap Diameter</th>
					<th>Cap Orifice</th>
					<th>Cap Type</th>
					<th>Cap Finish</th>
					<th>Cap No.</th>
					<th>Shoulder Weight</th>
					<th>Cap Height</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($shoulder_orifice_dependancy==FALSE){
					echo "<tr><td colspan='12'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)==''?1:$this->uri->segment(3));
							foreach($shoulder_orifice_dependancy as $row){
								echo "<tr>
									<td>".$i++."</td>
									<td>$row->sleeve_id</td>
									<td>$row->shoulder_type</td>
									<td>$row->shoulder_orifice</td>
									<td>$row->cap_dia</td>
									<td>$row->cap_orifice</td>
									<td>$row->cap_type</td>
									<td>$row->cap_finish</td>
									<td>$row->cap_no</td>
									<td>".$this->common_model->read_number($row->shld_weight,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$this->common_model->read_number($row->cap_height,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>
									<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/dearchive/'.$row->sod_id.'').">Dearchive</a>

									</td>
							</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
	</div>
</div>