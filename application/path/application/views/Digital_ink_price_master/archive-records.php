
<div class="record_form_design">
	<h3>Active Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th>From date</th>
					<th>To Date</th>
					<th>Ink Id</th>
					<th>Rm</th>
					<th>Other Charges PC</th>
					<th>Rate of Exchange</th>
					<th>Apply From date</th>
					<th>Apply To Date</th>
										
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($digital_ink_price_master==FALSE){
					echo "<tr><td colspan='11'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)==''?1:$this->uri->segment(3));
							foreach($digital_ink_price_master as $row){
								echo "<tr>
									<td>".$i++."</td>
									<td>".$this->common_model->view_date($row->from_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$this->common_model->view_date($row->to_date,$this->session->userdata['logged_in']['company_id'])."</td>

									<td> ".$row->ink_id."</td>
									<td> ".$row->other_charges_pc." </td>
									<td> &#8377;".$row->other_charges_pc."  </td>
									<td> &#8377;".$row->rate_of_exchange." </td>
									<td>".$this->common_model->view_date($row->apply_from_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$this->common_model->view_date($row->apply_to_date,$this->session->userdata['logged_in']['company_id'])."</td>
									
									<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>
									<td>";

									foreach($formrights as $formrights_row){ 

									//echo"<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->sscm_id.'').">Modify</a>";

									echo ($formrights_row->dearchive=='1' ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/dearchive/'.$row->dipm_id).'" title="Dearchive"><i class="edit icon"></i></a> ' : '');

									//echo"<a href=".base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->sscm_id.'')."> | Delete</a>";
								    }

									echo"</td>
							</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
	</div>
</div>