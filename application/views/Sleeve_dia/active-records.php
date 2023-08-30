
<div class="record_form_design">
	<h3>Active Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th>Sleeve Dia</th>
					<th>Coex Innear Diameter</th>
					<th>Coex Outer Diameter</th>
					<th>Coex Innear Tolerance</th>
					<th>Coex Outer Tolerance</th>
					<th>Spring Innear Diameter</th>
					<th>Spring Outer Diameter</th>
					<th>Spring Innear Tolerance</th>
					<th>Spring Outer Tolerance</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($sleeve_diameter_master==FALSE){
					echo "<tr><td colspan='4'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)==''?1:$this->uri->segment(3));
							foreach($sleeve_diameter_master as $row){
								echo "<tr>
									<td>".$i++."</td>
									<td>$row->sleeve_diameter</td>
									<td>$row->inner_diameter</td>
									<td>$row->outer_diameter</td>
									<td>$row->in_coex_tolerance</td>
									<td>$row->out_coex_tolerance</td>
									<td>$row->inner_dia_spring</td>
									<td>$row->outer_dia_spring</td>
									<td>$row->in_spring_tolerance</td>
									<td>$row->out_spring_tolerance</td>
									<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>
									<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->sleeve_id.'').">Modify</a><a href=".base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->sleeve_id.'')."> | Delete</a>

									</td>
							</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
	</div>
</div>