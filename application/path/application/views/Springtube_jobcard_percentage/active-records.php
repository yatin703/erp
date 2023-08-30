
<div class="record_form_design">
	<h3>Active Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th>Jobcard Type</th>
					<th>Percentage</th>
					<th>Action</th>
				</tr>
				<?php if($springtube_jobcard_perc_master==FALSE){
					echo "<tr><td colspan='4'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)=='' ? 1 : $this->uri->segment(3));
							foreach($springtube_jobcard_perc_master as $row){
								echo "<tr>
									<td>".$i++."</td>
									<td>$row->jobcard_type</td>
									<td>".$row->perc."</td>
									<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->id.'').">Modify</a><a href=".base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->id.'')."> | Delete</a>

									</td>
							</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
	</div>
</div>