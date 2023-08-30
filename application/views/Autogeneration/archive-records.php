
<div class="record_form_design">
<h3>Archive Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Employee Id</th>
					<th>Gender</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Email</th>
					<th>Mobile</th>
					<th>Date Of Birth</th>
					<th>Date Of Joining</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($employee==FALSE){
					echo "<tr><td colspan='9'>No Active Records Found</td></tr>";
				}else{
							foreach($employee as $row){
								echo "<tr>
									<td>$row->employee_id</td>
									<td>".($row->gender==0?"M":"F")."</td>
									<td>$row->name1</td>
									<td>$row->name2</td>
									<td>$row->mailbox</td>
									<td>$row->mobile_no</td>
									<td>$row->dob</td>
									<td>$row->hire_date</td>
									<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>
									<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->employee_id.'').">Modify</a><a href=".base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->employee_id.'')."> | Delete</a>

									</td>
							</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
					</div>
				</div>