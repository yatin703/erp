<div class="record_form_design">
<h3>Active Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th>Main Group</th>
					<th>Sub Group</th>
					<th>Second Sub Group</th>
					<th>Article No</th>
					<th>Article Name</th>
					<th>Sub Description</th>
					<th>UOM</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($article==FALSE){
					echo "<tr><td colspan='7'>No Active Records Found</td></tr>";
				}else{
								$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
								
							foreach($article as $row){

								echo "<tr>
									<td>".$i."</td>
									<td>".strtoupper($row->main_group)."</td>
									<td>".strtoupper($row->sub_group)."</td>
									<td>".strtoupper($row->second_sub_group)."</td>
									<td>".strtoupper($row->article_no)."</td>
									<td>".strtoupper($row->article_name)."</td>
									<td>".strtoupper($row->article_sub_description)."</td>
									<td>".strtoupper($row->uom)."</td>
									<td>".($row->archive==1 ? 'INACTIVE' : 'ACTIVE')."</td>
									<td>";
										foreach($formrights as $formrights_row){ 
										echo ($row->archive==1 && $formrights_row->dearchive==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/dearchive/'.$row->main_group_id.'').'">Dearchive</a> ' : '');
									}
									echo "</td>
							</tr>";
							$i++;
							}
						}?>
								
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>