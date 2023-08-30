
<div class="record_form_design">
<h3>Active Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Company Id</th>
					<th>Short Id</th>
					<th>Company Name</th>
					<th>Street</th>
					<th>Postal</th>
					<th>Country</th>
					<th>Telephone</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($company==FALSE){
					echo "<tr><td colspan='9'>No Active Records Found</td></tr>";
				}else{
							foreach($company as $row){
								echo "<tr>
									<td>$row->company_id</td>
									<td>$row->short_id</td>
									<td>$row->title</td>
									<td>$row->street</td>
									<td>$row->post_box_code</td>
									<td>$row->country_name</td>
									<td>$row->telephone1</td>
									<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>
									<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->company_id.'').">Modify</a> | 
													<a href=".base_url('index.php/'.$this->router->fetch_class().'/parameter/'.$row->company_id.'').">Parameter</a>
									</td>
							</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
					</div>
				</div>