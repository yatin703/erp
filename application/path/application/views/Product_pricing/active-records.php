<div class="record_form_design" >
<h3>Active Records</h3>
	<div class="record_inner_design" style="overflow: scroll;white-space: normal;">
			<table class="ui very basic collapsing celled table"  style="font-size:10px;">
				<thead>
				<tr>
					<th>Id</th>
					<th>Date</th>
					<th>Product No</th>
					<th>Customer</th>
					<th>Price List</th>
					<th>Product Name</th>
					<th>Action</th>
				</tr>
				</thead>
				<tbody>
				<?php if($product_pricing==FALSE){
					echo "<tr><td colspan='4'>No Active Records Found</td></tr>";
				}else{
							foreach($product_pricing as $row){

						echo "<tr>
									<td>$row->pp_id</td>
									<td>".$this->common_model->view_date($row->product_pricing_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>$row->article_no</td>
									<td>$row->category_name</td>
									<td>$row->price_list_name</td>
									<td>".$this->common_model->get_article_name($row->article_no,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>";
									foreach($formrights as $formrights_row){ 

										echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->pp_id.'').'" target="_blank"><i class="print icon"></i></a> ' : '');

										echo ($formrights_row->modify==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->pp_id.'').'"><i class="edit icon"></i></a> ' : '');

										echo ($row->archive<>1 && $formrights_row->delete==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->pp_id.'').'"><i class="trash icon"></i></a> ' : '');
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