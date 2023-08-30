
<div class="record_form_design">
	<h3>Archive Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th>Shoulder Type</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($shoulder_types_master==FALSE){
					echo "<tr><td colspan='7'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)==''?1:$this->uri->segment(3));
							foreach($shoulder_types_master as $row){
								echo "<tr>
									<td>".$i++."</td>
									<td>$row->shoulder_type</td>
									<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>
									<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/dearchive/'.$row->shld_type_id.'').">Dearchive</a>

									</td>
							</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
	</div>
</div>