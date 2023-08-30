
<div class="record_form_design">
	<h3>Active Records</h3>
		<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Form Id</th>
					<th>User</th>
					<th>Module</th>
					<th>Form Name</th>
					<th>View</th>
					<th>Create</th>
					<th>Modify</th>
					<th>Delete</th>
					<th>Copy</th>
					<th>Dearchive</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php 
				if($formrights==FALSE){
					echo "<tr><td colspan='12'>No Active Records Found</td></tr>";
				}else{
					foreach($formrights as $row){
						echo "<tr>
										<td>$row->formrights_id</td>
										<td>$row->login_name</td>
										<td>$row->module_name</td>
										<td>$row->form_name</td>
										<td>".($row->view==1 ? '<img src='.base_url('assets/img/tick.png').'>' : '-')."</td>
										<td>".($row->new==1 ? '<img src='.base_url('assets/img/tick.png').'>' : '-')."</td>
										<td>".($row->modify==1 ? '<img src='.base_url('assets/img/tick.png').'>' : '-')."</td>
										<td>".($row->delete==1 ? '<img src='.base_url('assets/img/tick.png').'>' : '-')."</td>
										<td>".($row->copy==1 ? '<img src='.base_url('assets/img/tick.png').'>' : '-')."</td>
										<td>".($row->dearchive==1 ? '<img src='.base_url('assets/img/tick.png').'>' : '-')."</td>
										<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>
										<td><a href=".base_url('index.php/formrights/modify/'.$row->formrights_id.'').">Modify</a>";
										if($row->archive<>1){ echo " | <a href=".base_url('index.php/formrights/delete/'.$row->formrights_id.'').">Delete</a>";}echo "</td>
									</tr>";
							}
						}
				?>
						
			</table>
			<div class="pagination"><?php echo $this->pagination->create_links();?></div>
		</div>
</div>