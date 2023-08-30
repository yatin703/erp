
<div class="record_form_design">
	<h3>Archive Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th>Work Procedure Type</th>
					<th>Main Group</th>
					<th>Sub Group</th>
					<th>Second Sub Group</th>
					<th>Rejection %</th>					
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($workprocedure_types_master==FALSE){
					echo "<tr><td colspan='12'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)=='' ? 1 : $this->uri->segment(3));
							foreach($workprocedure_types_master as $row){
								echo "<tr>
									<td>".$i++."</td>
									<td>".strtoupper($row->lang_description)."</td>
									<td>".strtoupper($row->main_group)."</td>
									<td>".strtoupper($row->sub_group)."</td>
									<td>".strtoupper($row->second_sub_group)."</td>
									<td>".$this->common_model->read_number($row->rejection_perc,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>
									<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/dearchive/'.$row->work_proc_type_id.'').">Dearchive</a>

									</td>
							</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
	</div>
</div>