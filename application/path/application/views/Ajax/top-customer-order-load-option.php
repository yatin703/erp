<table class="record_table_design_without_fixed">
					<tr>
						<th colspan='3'></th>
						<th colspan='5'>Total Orders</th>
					</tr>
					<tr>
						<th>Id</th>
						<th>Month-Year</th>
						<th>Customer</th>
						<th>Quantity</th>
						<th>Local</th>
						<th>Value</th>
						<th>Export</th>
						<th>Value</th>
					</tr>
					<?php if($top_orders==FALSE){

						echo "<tr>
													<td colspan='7'>No Record Found</td>
												</tr>";

					}else{
						$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
						foreach($top_orders as $top_orders_row){
							echo "<tr>
														<td>$i</td>
														<td>".$top_orders_row->month_name."-".$top_orders_row->year."</td>
														<td>$top_orders_row->customer_name</td>
														<td>".number_format($this->common_model->read_number($top_orders_row->quantity,$this->session->userdata['logged_in']['company_id']))."</td>
														<td>$top_orders_row->local</td>
														<td>".number_format($this->common_model->read_number($top_orders_row->local_value,$this->session->userdata['logged_in']['company_id']))."</td>
														<td>$top_orders_row->export</td>
														<td>".number_format($this->common_model->read_number($top_orders_row->export_value,$this->session->userdata['logged_in']['company_id']))."</td>
							</tr>";
							$i++;
						}
					}
					?>
				</table>