<div class="record_form_design">
<h3>Search Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design">
				<tr>
					<th>Id</th>
					<th>Category Name</th>
					<th>Action</th>
				</tr>
				<?php if($customer==FALSE){
					echo "<tr><td colspan='13'>No Active Records Found</td></tr>";
				}else{
							foreach($customer as $row){echo "<tr>
									<td>$row->adr_category_id</td>
									<td>$row->category_name</td><td>";
									foreach($formrights as $formrights_row){ 
										echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->adr_category_id.'').'" target="_blank"><i class="print icon"></i></a> ' : '');
										echo ($formrights_row->copy==1 ? '<a href="#">Copy</a> ' : '');
										echo ($formrights_row->modify==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->adr_category_id.'').'"><i class="edit icon"></i></a> ' : '');
										echo ($row->archive<>1 && $formrights_row->delete==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->adr_category_id.'').'"><i class="trash icon"></i></a> ' : '');
									}
									echo "</td>
							</tr>";
							}
						}?>
								
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>