
<div class="record_form_design">
	<h3>Archive Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th>Reasons</th>
					<th>Cancel Flag</th>
					<th>For Stock</th>
					<th>For Sample</th>
					
										
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($order_close_reasons_master==FALSE){
					echo "<tr><td colspan='11'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)==''?1:$this->uri->segment(3));
							foreach($order_close_reasons_master as $row){
								echo "<tr>
									<td>".$i++."</td>
									

									<td> ".$row->reasons."</td>
									<td>".($row->cancel_flag==1 ? '<img src='.base_url('assets/img/tick.png').'>' : '-')."</td>
									<td>".($row->for_stock==1 ? '<img src='.base_url('assets/img/tick.png').'>' : '-')."</td>
									<td>".($row->for_sample==1 ? '<img src='.base_url('assets/img/tick.png').'>' : '-')."</td>
									
									
									
									<td>".($row->archive==1 ? 'Inactive' :'Active')."</td>
									<td>";

									foreach($formrights as $formrights_row){ 

									//echo"<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->sscm_id.'').">Modify</a>";

									echo ($formrights_row->dearchive=='1' ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/dearchive/'.$row->id).'" title="Dearchive"><i class="edit icon"></i></a> ' : '');

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