<div class="record_form_design">
<h3>Archive Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design">
				<tr>
					<th>Id</th>
					<th>Category</th>
					
					<th>Action</th>
				</tr>
				<?php if($customer==FALSE){
					echo "<tr><td colspan='14'>No Active Records Found</td></tr>";
				}else{
							foreach($customer as $row){

								echo "<tr>
									<td>$row->adr_category_id</td>
									<td>$row->category_name</td>
									<td>";
									foreach($formrights as $formrights_row){ 
										echo ($row->archive==1 && $formrights_row->dearchive==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/dearchive/'.$row->adr_category_id.'').'">Dearchive</a> ' : '');
									}
									echo "</td>
							</tr>";
							}
						}?>
								
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>