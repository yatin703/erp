
<div class="record_form_design">
	<h3>Active Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th>Cap Mould</th>
					<th>No of Cavity</th>
					<th>Cycle Time</th>
					<th>Runner Weight</th>
					<th>Action</th>
				</tr>
				<?php if($cap_mould_master==FALSE){
					echo "<tr><td colspan='6'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)=='' ? 1 : $this->uri->segment(3));
							foreach($cap_mould_master as $row){
								echo "<tr>
									<td>".$i++."</td>
									<td>$row->mould_name</td>
									<td>$row->no_of_cavity</td>
									<td>$row->cycle_time</td>
									<td>$row->runner_weight</td>
									<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->cap_mould_id.'').">Modify</a><a href=".base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->cap_mould_id.'')."> | Delete</a>

									</td>
							</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
	</div>
</div>