<div class="record_form_design">
	<h4>Active Records <?php echo ($this->input->post('from_date')!=''? 'From '.$this->input->post('from_date').' To '.$this->input->post('to_date'):'')?></h4>
	<div class="record_inner_design" style="overflow: scroll;">
			<table class="record_table_design_without_fixed">
				<tr>
					<!--<th>Action</th>-->
					<th>Sr no.</th>
					<th>Machine Name</th>					
					
					<th>Process Name</th>
					<th>Tool ChangeOver <span style="color:red;">in min </span></th>
					<th>Job ChangeOver <span style="color:red;">in min </span></th>
					<th>Machine Capacity <span style="color:red;">per day </span> </th>
					<th>Machine Capacity <span style="color:red;">per min </span> </th>
					<th>Speed</th>
					<th>Status</th>
					<th>Action</th>									
					
				</tr>
				<?php if($coex_machine_master==FALSE){
					echo "<tr><td colspan='9'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)==''?1:$this->uri->segment(3));
							foreach($coex_machine_master as $row){
								echo "<tr>
									<td>".$row->machine_id."</td>
									

									<td> ".$row->machine_name."</td>
									
									
									<td> ".$row->lang_description."</td>

									<td> ".$row->tool_changeover."</td>
									<td> ".$row->job_changeover."</td>
									<td> ".$row->machine_capacity."</td>
									<td> ".$row->machine_capacity_per_minute."</td>

									


									<td> ".$row->speed."</td>
									
									
									
									<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>
									<td>";

									foreach($formrights as $formrights_row){ 

									//echo"<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->sscm_id.'').">Modify</a>";

									echo ($formrights_row->modify=='1' ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->machine_id).'" title="Modify"><i class="edit icon"></i>|</a> ' : '');

									echo ($formrights_row->delete=='1' ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->machine_id).'" title="Delete"><i class="trash icon"></i></a> ' : '');

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