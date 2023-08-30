<div class="record_form_design" >
<h3>Archive Records</h3>
	<div class="record_inner_design" style="overflow: scroll;white-space: normal;">
			<table class="ui very basic collapsing celled table"  style="font-size:10px;">
				<thead>
				<tr>
					<th>Id</th>
					<th>Date</th>
					<th>Article No</th>
					<th>Price Grid</th>
					<th>Action</th>
				</tr>
				</thead>
				<tbody>
				<?php if($product_pricing==FALSE){
					echo "<tr><td colspan='4'>No Archive Records Found</td></tr>";
				}else{
							foreach($product_pricing as $row){

						echo "<tr>
									<td>$row->pp_id</td>
									<td>".$this->common_model->view_date($row->product_pricing_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>$row->article_no</td>
									<td>$row->price_list_name</td>
									<td>";
									foreach($formrights as $formrights_row){ 

										echo ($row->archive==1 && $formrights_row->dearchive==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/dearchive/'.$row->pp_id.'').'"><i class="undo icon"></i></a> ' : '');
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