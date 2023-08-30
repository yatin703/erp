
<div class="record_form_design">
<h3>Active Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Sr. No.</th>
					<th>Accounting Year</th>
					<th>Financial Year Start</th>
					<th>Financial Year End</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($account_periods_master==FALSE){
					echo "<tr><td colspan='9'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)==''?0:$this->uri->segment(3));
							foreach($account_periods_master as $row){
								echo "<tr>
									<td>".++$i."</td>
									<td>$row->accounting_year</td>
									<td>$row->fin_year_start</td>
									<td>$row->fin_year_end</td>
									<td>".($row->status==1 ? 'Inactive' :'Active')."</td>
									<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->accounting_year.'').">Modify</a><a href=".base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->accounting_year.'')."> | Delete</a>

									</td>
							</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
					</div>
				</div>