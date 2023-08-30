
<div class="record_form_design">
<h3>Archive Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Country Id</th>
					<th>Country Name</th>
					<th>Country Short Id</th>
					<th>Currency</th>
					<th>Currency Symbol</th>
					<th>Small Denomination</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($country==FALSE){
					echo "<tr><td colspan='9'>No Archive Records Found</td></tr>";
				}else{
								$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
							foreach($country as $row){
								echo "<tr>
									<td>$i</td>
									<td>$row->lang_country_name</td>
									<td>$row->country_short_id</td>
									<td>$row->currency_name</td>
									<td>$row->currency_symbol</td>
									<td>$row->currency_small_deno</td>
									<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>
									<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/dearchive/'.$row->country_id.'').">Dearchive</a>

									</td>
							</tr>";
							$i++;
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
					</div>
				</div>