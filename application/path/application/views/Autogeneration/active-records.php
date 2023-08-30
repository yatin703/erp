
<div class="record_form_design">
<h3>Active Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Number Format</th>
					<th>Text Code</th>
					<th>Current Value</th>
					<th>Action</th>
				</tr>
				<?php if($autogeneration==FALSE){
					echo "<tr><td colspan='5'>No Active Records Found</td></tr>";
				}else{
							foreach($autogeneration as $row){
								echo "<tr>
									<td>$row->number_format</td>
									<td>$row->textcode</td>
									<td>$row->curr_val</td>
									<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->form_id.'').">Modify</a></td>
							</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
					</div>
				</div>