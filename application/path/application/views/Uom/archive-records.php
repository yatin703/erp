<div class="record_form_design">
<h3>Archive Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Uom Id</th>
					<th>Description</th>
					<th>Short Id</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($uom==FALSE){
					echo "<tr><td colspan='9'>No Active Records Found</td></tr>";
				}else{
							foreach($uom as $row){
								echo "<tr>
									<td>$row->uom_id</td>
									<td>$row->lang_uom_desc</td>
									<td>$row->lang_uom_desc</td>
									<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>
									<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/dearchive/'.$row->uom_id.'').">Dearchive</a>

									</td>
							</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
					</div>
				</div>