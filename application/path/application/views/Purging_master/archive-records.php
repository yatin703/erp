
<div class="record_form_design">
	<h3>Archive Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th>Purging Code</th>
					<th>Percentage</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($purging_perc_master==FALSE){
					echo "<tr><td colspan='5'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)=='' ? 1 : $this->uri->segment(3));
							foreach($purging_perc_master as $row){
								echo "<tr>
									<td>".$i++."</td>
									<td>$row->article_name</td>
									<td>".$this->common_model->read_number($row->purging_perc,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>
									<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/dearchive/'.$row->ppm_id.'').">Dearchive</a>

									</td>
							</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
	</div>
</div>