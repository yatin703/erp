
<div class="record_form_design">
	<h3>Active Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th colspan='2'>Stock Consumption Period</th>
					<th>Consumable Category</th>
					<th>Stock Consumption Value</th>
					<th>No of Tubes Sold in Consumption Period</th>
					<th>Cost/Tube</th>
					<th colspan='2'>Costsheet Period</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($other_consumable_consumption_master==FALSE){
					echo "<tr><td colspan='11'>No Active Records Found</td></tr>";
				}else{		$total_consumption_value=0;
							$total_cost_per_tube=0;
							$i=($this->uri->segment(3)==''?1:$this->uri->segment(3));
							foreach($other_consumable_consumption_master as $row){
								echo "<tr>
									<td>".$i++."</td>
									<td>".$this->common_model->view_date($row->from_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$this->common_model->view_date($row->to_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>$row->consumable_category</td>
									<!--<td>$row->consumable</td>-->
									<td>&#8377; ".number_format($row->consumption_value)."</td>
									<td>".number_format($row->sale_of_tubes,'0','.',',')." NOS</td>
									<td>&#8377; $row->cost_per_tube</td>
									<td>".$this->common_model->view_date($row->apply_from_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$this->common_model->view_date($row->apply_to_date,$this->session->userdata['logged_in']['company_id'])."</td>									
									<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>
									<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->ocm_id.'').">Modify</a><a href=".base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->ocm_id.'')."> | Delete</a></td>
							</tr>";
							$total_consumption_value+=$row->consumption_value;
							$total_cost_per_tube+=$row->cost_per_tube;
							}

							echo "<tr><td colspan='4'></td><td>&#8377; ".number_format($total_consumption_value)."</td><td></td><td>&#8377; $total_cost_per_tube</td><td colspan='4'></td></tr>";
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
	</div>
</div>