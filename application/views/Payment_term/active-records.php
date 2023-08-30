
<div class="record_form_design">
<h3>Active Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th>Net Days</th>
					<th>Payment Term</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($payment_term==FALSE){
					echo "<tr><td colspan='4'>No Active Records Found</td></tr>";
				}else{
							foreach($payment_term as $row){
								echo "<tr>
									<td>".$row->id."</td>
									<td>".$row->net_days."</td>
									<td>".$row->lang_description."</td>
									
									<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>
									<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->id.'').">Modify</a><a href=".base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->id.'')."> | Delete</a>

									</td>
							</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
					</div>
				</div>