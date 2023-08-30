
<div class="record_form_design">
<h3>Archive Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Room No.</th>
					<th>Warehouse Name</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($warehouse_design_lang==FALSE){
					echo "<tr><td colspan='9'>No Active Records Found</td></tr>";
				}else{
							foreach($warehouse_design_lang as $row){
								echo "<tr>
									<td>$row->room_no</td>
									<td>".strtoupper($row->lang_warehouse_name)."</td>
									<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>
									<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/dearchive/'.$row->room_no.'').">Dearchive</a>

									</td>
							</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
					</div>
				</div>