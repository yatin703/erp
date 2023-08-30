
<div class="record_form_design">
	<h3>Active Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th>Dia</th>
					<th>Length From</th>
					<th>Length To</th>					
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($length_master==FALSE){
					echo "<tr><td colspan='9'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)==''?1:$this->uri->segment(3));
							foreach($length_master as $row){
								echo "<tr>
									<td>".$i++."</td>
									<td> ".$row->dia."</td>
									<td> ".$row->length_from." MM</td>
									<td> ".$row->length_to." MM</td>
									
									
									
									<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>
									<td>";

									foreach($formrights as $formrights_row){ 

									//echo"<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->sscm_id.'').">Modify</a>";

									echo ($formrights_row->modify=='1' ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->length_id).'" title="Modify"><i class="edit icon"></i>|</a> ' : '');

									echo ($formrights_row->delete=='1' ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->length_id).'" title="Delete"><i class="trash icon"></i></a> ' : '');

									//echo"<a href=".base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->sscm_id.'')."> | Delete</a>";
								    }

									echo"</td>
							</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
	</div>
</div>