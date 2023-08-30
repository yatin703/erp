
<div class="record_form_design">
<h3>Active Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Sr. No.</th>
					<th>Country Name</th>
					<th>For Currency</th>
					<th>To Currency</th>
					<th>Exchange Rate</th>
					<th>Date Changed</th>
					
				</tr>
				<?php if($currency_history==FALSE){
					echo "<tr><td colspan='9'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(6)==''?0:$this->uri->segment(3));
							foreach($currency_history as $row){
								echo "<tr>
									<td>".++$i."</td>
									<td>$row->lang_country_name</td>
									<td>$row->for_currency</td>
									<td>$row->to_currency</td>
									<td>".($row->exchange_rate!=0?$row->exchange_rate/100:$row->exchange_rate)."</td>
									<td>$row->date_created</td>
									
							</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
					</div>
				</div>