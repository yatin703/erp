

<div class="record_form_design">
<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
<h4>Runtime Records From <?php echo $this->input->post('from_date');?> TO <?php echo $this->input->post('to_date');?></h4>
	<div class="record_inner_design" style="overflow: scroll;">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th>Date</th>
					<th>Machine</th>
					<th>Start Time</th>
					<th>Started For</th>
					<th>Stop Time</th>
					<th>Runtime</th>
				</tr>
				<?php if($coex_machine_runtime==FALSE){
					echo "<tr><td colspan='7'>No Active Records Found</td></tr>";
				}else{
						$i=1;
						foreach($coex_machine_runtime as $row){

							
							echo "<tr>
									<td>".$i."</td>
									<td>".date("d-M-Y",strtotime($row->machine_start_time))."</td>
									<td>".$row->machine_name."</td>
									<td><a class='ui basic label'>".date("d-M-Y",strtotime($row->machine_start_time))."</a>
									<a class='ui basic label'>".date("h:i A",strtotime($row->machine_start_time))."</a></td>
									<td>".$row->coex_machine_start_stop_reasons."</td>
									<td>".($row->machine_stop_time=='0000-00-00 00:00:00' ? "-" : "<a class='ui basic label'>".date("d-M-Y",strtotime($row->machine_stop_time))."</a>
									<a class='ui basic label'>".date("h:i A",strtotime($row->machine_stop_time))."</a>")."</td>
									<td>".($row->machine_stop_time=='0000-00-00 00:00:00' ? '<a class="ui green label">Running</a>' : $this->common_model->time_diffrence($row->machine_stop_time,$row->machine_start_time))."</td>

									</tr>";
							$i++;
						}
					}
					?>
								
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>