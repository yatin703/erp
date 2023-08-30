
<div class="record_form_design">
<h3>Active Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Customer</th>
					<th>Relate To</th>
					<th>Property</th>
					<th>Action</th>
				</tr>
				<?php if($relate==FALSE){
					echo "<tr><td colspan='5'>No Active Records Found</td></tr>";
				}else{
							foreach($relate as $row){
								echo "<tr>
									<td>".strtoupper($row->customer)."</td>
									<td>".strtoupper($row->relate)."</td>
									<td>".strtoupper($row->lang_property_name)."</td>
									<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->related_company_id.'').">Modify</a>
													</td>
							</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
					</div>
				</div>