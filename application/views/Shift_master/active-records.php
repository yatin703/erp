<div class="record_form_design">
	<h4>Active Records <?php echo ($this->input->post('from_date')!=''? 'From '.$this->input->post('from_date').' To '.$this->input->post('to_date'):'')?></h4>
	<div class="record_inner_design" style="overflow: scroll;">
			<table class="record_table_design_without_fixed">
				<tr>
					<!--<th>Action</th>-->
					<th>Sr no.</th>
					<th>Machine Name</th>	
					
					<th>Shift No</th>					
					<th>Shift Start Date</th>
					<th>Shift End Date</th>
					<th>Shift Start Time</th>
					<th>Shift End Time</th>
					<th>Shift Minutes</th>
					<th>Holiday</th>
					<th>Preventive Maintenance</th>
					<th>Status</th>
					<th>Action</th>									
					
				</tr>
				<?php if($shift_master==FALSE){
					echo "<tr><td colspan='12'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)==''?1:$this->uri->segment(3));
							foreach($shift_master as $row){
								echo "<tr>
									<td>".$row->shift_id."</td>
									
									<td> ".$row->machine_name."</td>
									
									<td> ".$row->shift_no."</td>
									
									<td> ".$row->shift_start_date."</td>
									<td> ".$row->shift_end_date."</td>
									<td> ".$row->shift_start_time."</td>
									<td> ".$row->shift_end_time."</td>
									<td> ".$row->shift_minutes."</td>
									<td> ".$row->holiday_flag."</td>
									<td> ".$row->preventive_maintaince."</td>
									
									
									<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>
									<td>";

									foreach($formrights as $formrights_row){ 

									//echo"<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->sscm_id.'').">Modify</a>";

									echo ($formrights_row->modify=='1' ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->shift_id).'" title="Modify"><i class="edit icon"></i>|</a> ' : '');

									echo ($formrights_row->delete=='1' ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->shift_id).'" title="Delete"><i class="trash icon"></i></a> ' : '');

									//echo"<a href=".base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->sscm_id.'')."> | Delete</a>";
								    }

									echo"</td>
							</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
	</div>
</div>