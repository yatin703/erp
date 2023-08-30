
<div class="record_form_design">
<h3>Active Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>User Id</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Username</th>
					<th>Password</th>
					<th>Admin</th>
					<th>User Level</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($user==FALSE){
					echo "<tr><td colspan='12'>No Active Records Found</td></tr>";
				}else{
							foreach($user as $row){
								echo "<tr>
									<td>$row->user_id</td>
									<td>$row->name1</td>
									<td>$row->name2</td>
									<td>$row->login_name</td>
									<td>".$this->login_model->cop_f_decrypt('pass',$row->password,"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890-/.")."</td>
									<td>".($row->admin==1 ? 'Yes' :'No')."</td>
									<td>$row->level_code_desc</td>
									<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>
									<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->user_id.'').">Modify</a><a href=".base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->user_id.'')."> | Delete</a>

									</td>
							</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
					</div>
				</div>