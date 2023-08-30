<br/>
<br/>
<table class="ui very basic collapsing celled table"  style="font-size:10px;">
				<thead>
				<tr>
					<th>Id</th>
					<th>Price List Name</th>
					<th>Customer</th>
					<th>Block</th>
					<th>Quantity From</th>
					<th>Quantity To</th>
					<th>Currency</th>
					<th>Final Unit Price</th>
					<th>Freight</th>
					<th>Other Cost</th>
					<th>Mark Up</th>
					<th>Ex-Works</th>
				</tr>
				</thead>
				<tbody>
				<?php if($product_block_pricing==FALSE){
					echo "<tr><td colspan='12'>No Active Records Found</td></tr>";
				}else{
							foreach($product_block_pricing as $row){

								echo "<tr>
									<td>$row->pbp_id</td>
									<td>$row->price_list_name</td>
									<td><b>$row->category_name</b></td>
									<td class='right aligned'>$row->block_name</td>
									<td class='right aligned'>".money_format('%!.0n',$this->common_model->read_number($row->block_from,$this->session->userdata['logged_in']['company_id']))."</td>
									<td class='right aligned'>".money_format('%!.0n',$this->common_model->read_number($row->block_to,$this->session->userdata['logged_in']['company_id']))."</td>
									<td>$row->currency_id</td>
									<td class='positive right aligned'><b>".money_format('%!.0n',$this->common_model->read_number($row->price_1,$this->session->userdata['logged_in']['company_id']))."</b></td>
									<td class='warning right aligned'>".money_format('%!.0n',$this->common_model->read_number($row->price_2,$this->session->userdata['logged_in']['company_id']))."</td>
									<td class='negative right aligned'>".money_format('%!.0n',$this->common_model->read_number($row->price_3,$this->session->userdata['logged_in']['company_id']))."</td>
									<td class='positive right aligned'>".money_format('%!.0n',$this->common_model->read_number($row->price_4,$this->session->userdata['logged_in']['company_id']))."</td>
									<td class='active right aligned'>".$this->common_model->read_number($row->unit_price,$this->session->userdata['logged_in']['company_id'])."</td>
									
							</tr>";
							}
						}?>
					</tbody>			
				</table>