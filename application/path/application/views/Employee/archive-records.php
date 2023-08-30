
<div class="record_form_design">
<h3>Archive Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Employee Id</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Gender</th>
					<th>Email</th>
					<th>Mobile</th>
					<th>Address</th>
					<th>Date Of Birth</th>
					<th>Date Of Joining</th>
					<th>Date Of Exit</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($employee==FALSE){
					echo "<tr><td colspan='12'>No Active Records Found</td></tr>";
				}else{
							foreach($employee as $row){
								echo "<tr>
									<td>$row->employee_id</td>
									<td>$row->name1</td>
									<td>$row->name2</td>
									<td>".($row->gender==0?"M":"F")."</td>
									<td>$row->mailbox</td>
									<td>$row->mobile_no</td>
									<td>$row->street</td>
									<td>$row->dob</td>
									<td>$row->hire_date</td>
									<td>$row->exit_date</td>
									<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>
									<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/dearchive/'.$row->employee_id.'').">Dearchive</a></a>

									</td>
							</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
					</div>
				</div>