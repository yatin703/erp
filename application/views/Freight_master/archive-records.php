
<div class="record_form_design">
	<h3>Archive Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th>Customer</th>
					<th>Dia</th>
					<th>Cost/Tube</th>
					<th>Apply From date</th>
					<th>Apply To Date</th>					
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($freight_master==FALSE){
					echo "<tr><td colspan='9'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)==''?1:$this->uri->segment(3));
							foreach($freight_master as $row){
								echo "<tr>
									<td>".$i++."</td>
									<td>".$this->common_model->get_customer_name($row->customer_no,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$row->sleeve_id."</td>
									<td>&#8377; ".$row->cost_per_tube."</td>
									<td>".$this->common_model->view_date($row->apply_from_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$this->common_model->view_date($row->apply_to_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>
									<td>
									";

									foreach($formrights as $formrights_row){						

										echo ($formrights_row->dearchive=='1' ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/dearchive/'.$row->freight_master_id).'" title="Dearchive"><i class="edit icon"></i></a> ' : '');									
								    }
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
	</div>
</div>