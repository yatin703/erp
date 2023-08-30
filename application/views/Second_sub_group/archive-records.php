<div class="record_form_design">
<h3>Archive Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design">
				<tr>
					<th>Id</th>
					<th>Main Group</th>
					<th>Sub Group</th>
					<th>Second Sub Group</th>
					<th>Short desc</th>
					<th>Category</th>
					<th>Tariff No</th>
					<th>Account Head</th>
					<th>Cost Center</th>
					<th>Type</th>
					<th>Excisable</th>
					<th>Spares</th>
					<th>Type</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($second_sub_group==FALSE){
					echo "<tr><td colspan='14'>No Archive Records Found</td></tr>";
				}else{
							foreach($second_sub_group as $row){

								echo "<tr>
									<td>$row->sub_sub_grp_id</td>
									<td>".strtoupper($row->main_group)."</td>
									<td>".strtoupper($row->sub_group)."</td>
									<td>".strtoupper($row->second_sub_group)."</td>
									<td>".strtoupper($row->second_sub_group_short_id)."</td>
									<td>$row->category</td>
									<td>$row->tariff_no</td>
									<td>$row->account_head</td>
									<td>$row->cost_center</td>
									<td>".($row->sales_pur_flag==1 ? 'SALES' : '')."".($row->sales_pur_flag==0 ? 'PURCHASE' : '')." ".($row->sales_pur_flag==2 ? 'OTHER' : '')."</td>
									<td>".($row->excise_flag==1 ? 'YES' : '')."</td>
									<td>".($row->spares_flag==1 ? 'YES' : '')."</td>
									<td>".($row->mat_flag==1 ? 'RAW MATERIAL' : '')." ".($row->mat_flag==2 ? 'TRADE MATERIAL' : '')." ".($row->mat_flag==3 ? 'SERVICE' : '')." ".($row->mat_flag==4 ? 'ASSETS' : '')."</td>
									<td>".($row->archive==1 ? 'INACTIVE' : 'ACTIVE')."</td>
									<td>";
									foreach($formrights as $formrights_row){ 
										echo ($row->archive==1 && $formrights_row->dearchive==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/dearchive/'.$row->sub_sub_grp_id.'').'">Dearchive</a> ' : '');
									}
									echo "</td>
							</tr>";
							}
						}?>
								
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>