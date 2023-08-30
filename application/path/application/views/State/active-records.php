
<div class="record_form_design">
<h3>Active Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Sr. No.</th>
					<th>State Short Id</th>
					<th>State Name</th>
					<th>State GST Code</th>
					<th>Zone</th>
					<th>Country</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($state==FALSE){
					echo "<tr><td colspan='7'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)==''?0:$this->uri->segment(3));
							foreach($state as $row){
								echo "<tr>
									<td>".++$i."</td>
									<td>".strtoupper($row->zip_code)."</td>
									<td>".strtoupper($row->lang_city)."</td>
									<td>$row->state_code</td>
									<td>".strtoupper($row->lang_zone_name)."</td>
									<td>".strtoupper($row->lang_country_name)."</td>
									<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>
									<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->zip_code.'').">Modify</a><a href=".base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->zip_code.'')."> | Delete</a>

									</td>
							</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
					</div>
				</div>