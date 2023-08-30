<div class="record_form_design">
	<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
<h4>Active Records</h4>
	<div class="record_inner_design" style="overflow: scroll;">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th>Date</th>
					<th>Machine</th>
					<th>Shift</th>
					<th>Order No</th>
					<th>Product No</th>
					<th>Job No</th>
					<th>Add Parameters</th>
					<th>Edit Parameters</th>
					<th>Action</th>
				</tr>
				<?php if($coex_extrusion_qc_control_plan==FALSE){
					echo "<tr><td colspan='16'>No Active Records Found</td></tr>";
				}else{
						$i=1;
						foreach($coex_extrusion_qc_control_plan as $row){

							$order_flag='';								
							$data['order_master']=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$row->order_no);
							if($data['order_master']==FALSE){
								$order_flag='';	
							}else{
								foreach ($data['order_master'] as $order_master_row) {
									$order_flag=$order_master_row->order_flag;
								}
							}

							$data=array('order_no'=>$row->order_no,'article_no'=>$row->article_no);
							$data['spec']=$this->common_model->select_one_active_record_nonlanguage_without_archives('order_details',$this->session->userdata['logged_in']['company_id'],$data);
							//echo $this->db->last_query();
							if($data['spec']==FALSE){
								$spec_id="";
								$version="";
							}else{
								foreach($data['spec'] as $spec_row){
									$spec_id=$spec_row->spec_id;
									$version=$spec_row->spec_version_no;
								}
							}

							echo "<tr>
									<td>".$i."</td>
									<td>".$this->common_model->view_date($row->inspection_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$row->machine_name."</td>
									<td>".$row->shift_name."</td>
									<td>".$row->order_no."</td>
									<td>".$row->article_no."</td>
									<td><a href='".base_url('index.php/sales_order_item_parameterwise/view_new/'.$row->jobcard_no.'/'.$spec_id.'/'.$version)."' target='_blank'>".$row->jobcard_no."</a></td>
									<td>";

									foreach($formrights as $formrights_row){ 

										echo ($formrights_row->new==1 && $row->final_approval_flag<>1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/add/'.$row->ceqcp_id.'/'.$row->jobcard_no).'"><i class="plus icon"></i></a> ' : '');

										$data['coex_extrusion_qc_control_plan_parameter']=$this->common_model->select_one_active_record('coex_extrusion_qc_control_plan_parameter',$this->session->userdata['logged_in']['company_id'],'coex_extrusion_qc_control_plan_parameter.ceqcp_id',$row->ceqcp_id);


										} echo "</td>
										<td>";
										foreach($data['coex_extrusion_qc_control_plan_parameter'] as $coex_extrusion_qc_control_plan_parameter_row){
											echo substr($coex_extrusion_qc_control_plan_parameter_row->inspection_time,0,5)." ";

											echo ($formrights_row->modify==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify_parameter/'.$coex_extrusion_qc_control_plan_parameter_row->ceqcpp_id).'"><i class="edit icon"></i></a> ' : '');
										}
										echo "</td>

									<td>";

									foreach($formrights as $formrights_row){ 

										echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->ceqcp_id).'" target="_blank"><i class="print icon"></i></a> ' : '');


										echo ($formrights_row->modify==1 && $row->final_approval_flag<>1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->ceqcp_id).'"><i class="edit icon"></i></a> ' : '');

										echo ($row->archive<>1 && $formrights_row->delete==1 && $row->final_approval_flag<>1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->ceqcp_id).'"><i class="trash icon"></i></a> ' : '');
										
									} 
									echo "</td>

									</tr>";
							$i++;
						}
					}
					?>
								
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>