<div class="record_form_design">
<h3>Active Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Rate Id</th>
					<th>Tariff No.</th>
					<th>Tariff Heading</th>
					<th>Tariff Description</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($excise_rates_master==FALSE){
					echo "<tr><td colspan='9'>No Active Records Found</td></tr>";
				}else{
							foreach($excise_rates_master as $row){
								echo "<tr>
									<td>$row->erm_id</td>
									<td>$row->cetsh_no</td>
									<td>$row->lang_tariff_heading</td>
									<td>$row->lang_tariff_descr</td>
									<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>
									<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/dearchive/'.$row->erm_id.'').">Dearchive</a>

									</td>
							</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
					</div>
				</div>