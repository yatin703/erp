
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
					<th>Screen/Plates Consumed in Consumption Period</th>
					
					<th>Cost Per Screen/Plate</th>
					<th colspan='2'>Costsheet Period</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($screen_consumption_master==FALSE){
					echo "<tr><td colspan='11'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)==''?1:$this->uri->segment(3));
							foreach($screen_consumption_master as $row){
								echo "<tr>
									<td>".$i++."</td>
									<td>".$this->common_model->view_date($row->from_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$this->common_model->view_date($row->to_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>$row->lacquer_type</td>
									<!--<td>$row->rm</td>-->
									<td>&#8377; ".number_format($row->consumption_value)."</td>
									<td>".number_format($row->consumption_quantity)." NOS</td>
									<td>&#8377;".number_format($row->consumption_unit_rate)."</td>
									<td>".$this->common_model->view_date($row->apply_from_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$this->common_model->view_date($row->apply_to_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>
									<td>";
								foreach($formrights as $formrights_row){

									echo ($formrights_row->modify==1 ?'<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->scm_id).'" title="Modify"><i class="edit icon"></i></a> ' : '');	

									echo ($formrights_row->delete==1 ?'<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->scm_id).'" title="Delete"><i class="trash icon"></i></a> ' : '');

									echo ($formrights_row->copy==1 ?'<a href="'.base_url('index.php/'.$this->router->fetch_class().'/copy/'.$row->scm_id).'" title="Copy"><i class="copy icon"></i></a> ' : '');							
									//echo"<a href=".base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->scm_id.'').">Modify</a>";
									//echo"<a href=".base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->scm_id.'')."> | Delete</a>";
									//echo"<a href=".base_url('index.php/'.$this->router->fetch_class().'/copy/'.$row->scm_id.'')."> | Copy</a>";
								}	

								echo"</td>
							</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
	</div>
</div>