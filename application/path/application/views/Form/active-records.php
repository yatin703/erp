
<div class="record_form_design">
<h3>Active Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Form Id</th>
					<th>Module</th>
					<th>Parent Name</th>
					<th>Form Name</th>
					<th>File Name</th>
					<th>View</th>
					<th>Create</th>
					<th>Modify</th>
					<th>Delete</th>
					<th>Copy</th>
					<th>Dearchive</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($form==FALSE){
					echo "<tr><td colspan='13'>No Active Records Found</td></tr>";
				}else{
							foreach($form as $row){
								echo "<tr>
									<td>$row->form_id</td>
									<td>$row->module_name</td>
									<td>$row->parent</td>
									<td>$row->form_name</td>
									<td>$row->file_name</td>
									<td>".($row->view==1 ? '<img src='.base_url('assets/img/tick.png').'>' : '-')."</td>
									<td>".($row->new==1 ? '<img src='.base_url('assets/img/tick.png').'>' : '-')."</td>
									<td>".($row->modify==1 ? '<img src='.base_url('assets/img/tick.png').'>' : '-')."</td>
									<td>".($row->delete==1 ? '<img src='.base_url('assets/img/tick.png').'>' : '-')."</td>
									<td>".($row->copy==1 ? '<img src='.base_url('assets/img/tick.png').'>' : '-')."</td>
									<td>".($row->dearchive==1 ? '<img src='.base_url('assets/img/tick.png').'>' : '-')."</td>
									<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>
									<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->form_id.'').">Modify | </a>
										<a href=".base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->form_id.'').">Delete</a></td>
							</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
					</div>
				</div>