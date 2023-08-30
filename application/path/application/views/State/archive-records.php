
<div class="record_form_design">
<h3>Archive Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Sr. No.</th>
					<th>Short Id</th>
					<th>State</th>
					<th>State Code</th>
					<th>Zone</th>
					<th>Country</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($state==FALSE){
					echo "<tr><td colspan='9'>No Archive Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)==''?0:$this->uri->segment(3));
							foreach($state as $row){
								echo "<tr>
									<td>".++$i."</td>
									<td>$row->zip_code</td>
									<td>$row->lang_city</td>
									<td>$row->state_code</td>
									<td>$row->lang_zone_name</td>
									<td>$row->lang_country_name</td>
									<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>
									<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/dearchive/'.$row->zip_code.'').">Dearchive</a>

									</td>
							</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
					</div>
				</div>