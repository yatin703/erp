
<div class="record_form_design">
	<h3>Archive Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th>Tax Code</th>
					<th>Tax Rate</th>
					<th>Creation Date</th>
					<th>Tax Code Description</th>
					<th>Sales Account Head Name</th>
					<th>Purchase Account Head Name</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($tax_master==FALSE){
					echo "<tr><td colspan='12'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)==''?1:$this->uri->segment(3));
							foreach($tax_master as $row){
								echo "<tr>
									<td>".$i++."</td>
									<td>$row->tax_code</td>
									<td>".$this->common_model->read_number($row->tax_rate,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$this->common_model->view_date($row->creation_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".strtoupper($row->lang_tax_code_desc)."</td>
									<td>".strtoupper($row->sales_accounr_head)."</td>
									<td>".strtoupper($row->purchase_accounr_head)."</td>
									<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>
									<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/dearchive/'.$row->tax_code.'').">Dearchive</a>

									</td>
							</tr>";
							}
						}?>
							
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>	
	</div>
</div>