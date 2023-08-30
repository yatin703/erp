
<div class="record_form_design">
<h3>Archive Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Property Id</th>
					<th>Main Property</th>
					<th>Property</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($property==FALSE){
					echo "<tr><td colspan='13'>No Active Records Found</td></tr>";
				}else{
							foreach($property as $row){
								echo "<tr>
									<td>$row->property_id</td>
									<td>".strtoupper($row->lang_master_property_descr)."</td>
									<td>".strtoupper($row->lang_property_name)."</td>
									<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>
									<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/dearchive/'.$row->property_id.'').">Dearchive</a>
							</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
					</div>
				</div>
