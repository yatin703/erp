
<div class="record_form_design">
	<h3>Active Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th colspan='2'>Stock Consumption Period</th>
					<th>Print Type</th>
					<!--<th>Rm</th>-->
					<th>Stock Consumption Value</th>
					<th>No of Kg</th>
					
					<th>Cost/Tube or Avg Cost/Kg</th>
					<th colspan='2'>Costsheet Period</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($ink_consumption_master==FALSE){
					echo "<tr><td colspan='11'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)==''?1:$this->uri->segment(3));
							foreach($ink_consumption_master as $row){
								echo "<tr>
									<td>".$i++."</td>
									<td>".$this->common_model->view_date($row->from_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$this->common_model->view_date($row->to_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>$row->lacquer_type</td>									
									<td>&#x20B9; ".number_format($row->consumption_value)."</td>
									<td>".$row->sale_of_tubes." NO</td>
									<td>&#x20B9; ".number_format($row->cost_per_tube,'4','.',',')."</td>
									<td>".$this->common_model->view_date($row->apply_from_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$this->common_model->view_date($row->apply_to_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>

									<td>";
								foreach($formrights as $formrights_row){

									echo ($formrights_row->modify=='1'? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->icm_id).'" title="Modify"><i class="edit icon"></i></a>' : '');
									echo ($formrights_row->delete=='1'? '|<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->icm_id).'" title="Delete"><i class="trash icon"></i></a>' : '');
									echo ($formrights_row->copy=='1'? '|<a href="'.base_url('index.php/'.$this->router->fetch_class().'/copy/'.$row->icm_id).'" title="Copy"><i class="copy icon"></i></a>' : '');

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