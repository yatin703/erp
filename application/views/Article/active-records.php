<div class="record_form_design">
<h3>Active Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th>Main Group</th>
					<th>Sub Group</th>
					<th>Second Sub Group</th>
					<th>Article No</th>
					<th>Article Name</th>
					<th>Sub Description</th>
					<th>UOM</th>
					<th>HSN/SAC No.</th>
					<th>HSN/SAC Desc</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php if($article==FALSE){
					echo "<tr><td colspan='7'>No Active Records Found</td></tr>";
				}else{
								$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
								
							foreach($article as $row){

								$hsn_no='';
								$hsn_desc='';

								echo "<tr>
									<td>".$i."</td>
									<td>".strtoupper($row->main_group)."</td>
									<td>".strtoupper($row->sub_group)."</td>
									<td>".strtoupper($row->second_sub_group)."</td>
									<td>".strtoupper($row->article_no)."</td>
									<td>".strtoupper($row->article_name)."</td>
									<td>".strtoupper($row->article_sub_description)."</td>
									<td>".strtoupper($row->uom)."</td>";

									$tariff_result=$this->tariff_model->select_one_active_record('excise_rates_master','excise_rates_master.erm_id',$row->excise_rate_id,$this->session->userdata['logged_in']['company_id']);
									foreach ($tariff_result as  $tariff_row){
										
										$hsn_no=$tariff_row->cetsh_no;
										$hsn_desc=strtoupper($tariff_row->lang_tariff_descr);
									}

									echo"<td>".$hsn_no."</td>
										<td>".$hsn_desc."</td>";
									echo "<td>".($row->archive==1 ? 'INACTIVE' : 'ACTIVE')."</td>
									<td>";
									foreach($formrights as $formrights_row){ 
										echo ($formrights_row->view==1 ? '' : '');
										echo ($formrights_row->copy==1 ? '' : '');
										echo ($formrights_row->modify==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->article_no.'').'"><i class="edit icon"></i></a> ' : '');
										echo ($row->archive<>1 && $formrights_row->delete==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->article_no.'').'" ><i class="trash icon"></i></a> ' : '');
										$i++;
									}
									echo "</td>
							</tr>";
							}
						}?>
								
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>