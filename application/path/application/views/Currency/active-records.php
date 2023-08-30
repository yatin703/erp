
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
					<th>Old Exchange Rate</th>
					<th>Date Changed</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($currency_rates_master==FALSE){
					echo "<tr><td colspan='10'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)==''?0:$this->uri->segment(3));
							foreach($currency_rates_master as $row){
								echo "<tr>
									<td>".++$i."</td>
									<td>$row->lang_country_name</td>
									<td>$row->for_currency</td>
									<td>$row->to_currency</td>
									<td>".($row->exchange_rate!=0?$row->exchange_rate/100:$row->exchange_rate)."</td>
									<td>".($row->old_exch_rate!=0?$row->old_exch_rate/100:$row->old_exch_rate)."</td>
									<td>$row->date_changed</td>
									<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>

									<td>";

									foreach($formrights as $formrights_row){ 

											echo ($formrights_row->modify==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->country_id.'/'.$row->for_currency.'/'.$row->to_currency).'" title="Modify"><i class="edit icon"></i></a>' : '');										
											echo ($row->archive<>1 && $formrights_row->delete==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->country_id.'/'.$row->for_currency.'/'.$row->to_currency).'" title="Delete"><i class="trash icon"></i></a> ' : '');

											echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/currency_history/index/'.$row->country_id.'/'.$row->for_currency.'/'.$row->to_currency).'" target="blank"></i>Currency History</a>' : '');
																														
									}

									/*echo"<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->country_id.'/'.$row->for_currency.'/'.$row->to_currency).">Modify</a>
									<a href=".base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->country_id.'/'.$row->for_currency.'/'.$row->to_currency)."> | Delete </a>
									<a href=".base_url('index.php/currency_history/index/'.$row->country_id.'/'.$row->for_currency.'/'.$row->to_currency)." target='blank'> | Currency History </a>

									</td>";
									*/

							echo "</td></tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
					</div>
				</div>