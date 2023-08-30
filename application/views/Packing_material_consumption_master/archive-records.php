
<div class="record_form_design">
	<h3>Archive Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th colspan='2'>Stock Consumption Period</th>
					<th>Packing Category</th>
					<th>Stock Consumption Value</th>
					<th>No of Tubes Sold in Consumption Period</th>
					<th>Cost/Tube</th>
					<th colspan='2'>Costsheet Period</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($packing_material_consumption_master==FALSE){
					echo "<tr><td colspan='9'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)==''?1:$this->uri->segment(3));
							foreach($packing_material_consumption_master as $row){
								echo "<tr>
									<td>".$i++."</td>
									<td>".$this->common_model->view_date($row->from_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$this->common_model->view_date($row->to_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>$row->packing_category</td>
									<!--<td>$row->packing_material</td>-->
									<td>".number_format($row->consumption_value,'2','.',',')."</td>
									<td>".number_format($row->sale_of_tubes,'0','.',',')."</td>
									<td>$row->cost_per_tube</td>
									<td>".$this->common_model->view_date($row->apply_from_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$this->common_model->view_date($row->apply_to_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>
									<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/dearchive/'.$row->pmcm_id.'').">Dearchive</a>

									</td>
							</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
	</div>
</div>