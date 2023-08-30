
<div class="record_form_design">
	<h3>Active Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th colspan='2'>Stock Consumption Period</th>
					<th>Print Type</th>
					<th>Rm</th>
					<th>Stock Consumption Value</th>
					<th>No of Kg</th>
					
					<th>Cost/Kg</th>
					<th colspan='2'>Costsheet Period</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($ink_price_master==FALSE){
					echo "<tr><td colspan='11'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)==''?1:$this->uri->segment(3));
							foreach($ink_price_master as $row){
								echo "<tr>
									<td>".$i++."</td>
									<td>".$this->common_model->view_date($row->from_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$this->common_model->view_date($row->to_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>";

									if($row->ink_id==1){
										echo "FLEXO";
									}else if($row->ink_id==2){
										echo "OFFSET";
									}else if($row->ink_id==3){
										echo "SCREEN";
									}else{
										echo "SPECIAL INK";
									}

									echo "</td>
									<td>".$row->rm."</td>
																		
									<td>&#x20B9; ".number_format($row->consumption_value)."</td>
									<td>".$row->consumption_quantity." Kg</td>
									<td>&#x20B9; ".number_format($row->cost_per_kg,'0','.',',')."</td>
									<td>".$this->common_model->view_date($row->apply_from_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$this->common_model->view_date($row->apply_to_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>

									<td>";
								foreach($formrights as $formrights_row){

									echo ($formrights_row->modify=='1'? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->ipm_id).'" title="Modify"><i class="edit icon"></i></a>' : '');

									echo ($formrights_row->delete=='1'? '|<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->ipm_id).'" title="Delete"><i class="trash icon"></i></a>' : '');


									//echo"<a href=".base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->icm_id.'')."> | Delete</a>";

									//echo"<a href=".base_url('index.php/'.$this->router->fetch_class().'/copy/'.$row->icm_id.'')."> | Copy</a>";
								}
									echo"</td>
							</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
	</div>
</div>