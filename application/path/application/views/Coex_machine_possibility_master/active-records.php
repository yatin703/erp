<div class="record_form_design">
	<h4>Active Records <?php echo ($this->input->post('from_date')!=''? 'From '.$this->input->post('from_date').' To '.$this->input->post('to_date'):'')?></h4>
	<div class="record_inner_design" style="overflow: scroll;">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Sr no.</th>
						
					<th>Machine Name</th>					
					<th>Sleeve Dia</th>
					<th>Print Type </th>
					
					<th>Status</th>
					<th>Action</th>			
				</tr>
				<?php if($coex_machine_possibility_master==FALSE){
					echo "<tr><td colspan='11'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)==''?1:$this->uri->segment(3));
							foreach($coex_machine_possibility_master as $row){
								echo "<tr>
									<td>".$row->cmpm_id."</td>
									

									
									<td> ".$row->machine_name."</td>
									
									<td> ".$row->sleeve_dia."</td>
									<td> ".$row->print_type."</td>
																		
									<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>
									<td>";

									foreach($formrights as $formrights_row){ 

									//echo"<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->cmpm_id.'').">Modify</a>";
									echo ($formrights_row->modify=='1' ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->cmpm_id).'" title="Modify"><i class="edit icon"></i>|</a> ' : '');

									echo ($formrights_row->delete=='1' ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->cmpm_id).'" title="Delete"><i class="trash icon"></i></a> ' : '');


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