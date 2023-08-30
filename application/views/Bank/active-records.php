
<div class="record_form_design">
<h3>Active Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Bank Id</th>
					<th>Bank Code</th>
					<th>Bank Name</th>
					<th>Bank Addess</th>
					<th>Credit Limit</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($bank==FALSE){
					echo "<tr><td colspan='7'>No Active Records Found</td></tr>";
				}else{
							foreach($bank as $row){
								echo "<tr>
									<td>$row->bank_id</td>
									<td>$row->bank_code</td>
									<td>$row->bank_name</td>
									<td>$row->bank_address</td>
									<td>$row->od_limit_amount</td>
									<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>
									<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->bank_id.'').">Modify</a><a href=".base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->bank_id.'')."> | Delete</a>

									</td>
							</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
					</div>
				</div>