<div class="record_form_design" >
<h3>Archive Records</h3>
	<div class="record_inner_design" style="overflow: scroll;white-space: normal;">
			<table class="ui very basic collapsing celled table"  style="font-size:10px;">
				<thead>
				<tr>
					<th>Id</th>
					<th>Article No</th>
					<th>Version No</th>
					<th>Product Name</th>
					<th>Quantity Name</th>
					<th>Quantity</th>
					<th>Currency</th>
					<th>Ex-Works</th>
					<th>Freight</th>
					<th>Other Cost</th>
					<th>Mark Up</th>
					<th>Final Price</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php if($product_block_pricing==FALSE){
					echo "<tr><td colspan='3'>No Active Records Found</td></tr>";
				}else{
							foreach($product_block_pricing as $row){

								echo "<tr>
									<td>$row->pbp_id</td>
									<td>$row->article_no</td>
									<td>$row->version_no</td>
									<td>".$this->common_model->get_article_name($row->article_no,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".money_format('%!.0n',$this->common_model->read_number($row->block_from,$this->session->userdata['logged_in']['company_id']))."</td>
									<td>".money_format('%!.0n',$this->common_model->read_number($row->block_to,$this->session->userdata['logged_in']['company_id']))."</td>
									<td>$row->currency_id</td>
									<td>".money_format('%!.0n',$this->common_model->read_number($row->price_1,$this->session->userdata['logged_in']['company_id']))."</td>
									<td>".money_format('%!.0n',$this->common_model->read_number($row->price_2,$this->session->userdata['logged_in']['company_id']))."</td>
									<td>".money_format('%!.0n',$this->common_model->read_number($row->price_3,$this->session->userdata['logged_in']['company_id']))."</td>
									<td>".money_format('%!.0n',$this->common_model->read_number($row->price_4,$this->session->userdata['logged_in']['company_id']))."</td>
									<td>".$this->common_model->read_number($row->unit_price,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>";
									foreach($formrights as $formrights_row){ 
										echo ($row->archive==1 && $formrights_row->dearchive==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/dearchive/'.$row->article_no.'/'.$row->version_no).'">Dearchive</a> ' : '');
									}
									echo "</td>
							</tr>";
							}
						}?>
						</tbody>		
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>