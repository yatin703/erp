<div class="record_form_design">
<h3>Active Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th>BOM No</th>
					<th>BOM Version No</th>
					<th>Article No</th>
					<th>Article Name</th>
					<th>Created By</th>
					<th>Approved By</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($bom==FALSE){
					echo "<tr><td colspan='9'>No Active Records Found</td></tr>";
				}else{
								$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
								
							foreach($bom as $bom_row){

								echo "<tr>
									<td>".$i."</td>
									<td>".$bom_row->bom_no."</td>
									<td>".$bom_row->bom_version_no."</td>
									<td>".$bom_row->bom_date."</td>
									<td>".$bom_row->article_no."</td>
									<td>".strtoupper($bom_row->article_name)."</td>
									<td>".strtoupper($bom_row->article_sub_description)."</td>
									<td>".strtoupper($bom_row->username)."</td>
									<td>".strtoupper($bom_row->approval_username)."</td>
									<td>".($row->archive==1 ? 'INACTIVE' : 'ACTIVE')."</td>
									<td>";
									foreach($formrights as $formrights_row){ 
										echo ($formrights_row->view==1 ? '' : '');
										echo ($formrights_row->copy==1 ? '' : '');
										echo ($formrights_row->modify==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$bom_row->article_no.'').'"><i class="edit icon"></i></a> ' : '');
										echo ($bom_row->archive<>1 && $formrights_row->delete==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$bom_row->article_no.'').'"><i class="trash icon"></i></a> ' : '');
										$i++;
									}
									echo "</td>
							</tr>";
							}
						}?>
								
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>