
<div class="record_form_design">
<h3>Archive Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Form Id</th>
					<th>Module Name</th>
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
					echo "<tr><td colspan='13'>No Archive Records Found</td></tr>";
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
									<td>";if($row->archive==1){ echo "<a href=".base_url('index.php/'.$this->router->fetch_class().'/dearchive/'.$row->form_id.'').">Dearchive</a>";}echo "</td>
							</tr>";
							}
						}?>
								
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>