
<div class="record_form_design">
	<h3>Active Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th>Lacquer Code</th>
					<th>Lacquer Name</th>
					<th>Dia</th>
					<th>Length From</th>
					<th>Length To</th>
					<th>Consumption Per Tube</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($lacquer_consumption_master==FALSE){
					echo "<tr><td colspan='8'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)=='' ? 1 : $this->uri->segment(3));
							foreach($lacquer_consumption_master as $row){
								echo "<tr>
									<td>".$i++."</td>
									<td>$row->article_no</td>
									<td>$row->article_name</td>
									<td>$row->sleeve_diameter</td>
									<td>$row->length_from</td>
									<td>$row->length_to</td>
									<td>$row->consumption_per_tube</td>
								
									<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>
									<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->lcm_id.'').">Modify</a><a href=".base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->lcm_id.'')."> | Delete</a>

									</td>
							</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
	</div>
</div>