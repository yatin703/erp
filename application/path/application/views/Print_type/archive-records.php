
<div class="record_form_design">
<h3>Archive Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Print Type Id</th>
					<th>Print Type</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($lacquer_types_master==FALSE){
					echo "<tr><td colspan='9'>No Active Records Found</td></tr>";
				}else{
							foreach($lacquer_types_master as $row){
								echo "<tr>
									<td>$row->lacquer_type_id</td>
									<td>".strtoupper($row->lacquer_type)."</td>
									<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>
									<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/dearchive/'.$row->lacquer_type_id.'').">Dearchive</a>

									</td>
							</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
					</div>
				</div>