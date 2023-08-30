<div class="record_form_design">
<h4>Archive Records</h4>
	<div class="record_inner_design"  style="overflow: scroll;white-space: nowrap;">
			<table class="record_table_design_without_fixed">
				
				<tr>
					<th>Sr No.</th>
					<th>Date</th>
					<th>Order No.</th>
					<th>Article No.</th>
					<th>Article Name</th>
					<th>Artwork</th>
					<th>Verison</th>
					<th>Jobcard No.</th>					
					<th>Dia</th>
					<th>Plate Nature</th>
					<th>Shift</th>
					<th>Machine</th>
					<th>Plate Making Reason</th>
					<th>Plate Maker</th>
					<th>Offset</th>
					<th>Screen</th>
					<th>Flexo</th>
					<th>Comment</th>
					<th>Created By</th>
					<th>Approved Date</th>
					<th>Approved By</th>
					<th>Action</th>
				</tr>
				<?php if($graphics_daily_plates_master==FALSE){
					echo "<tr><td colspan='19'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
								
							foreach($graphics_daily_plates_master as $row){
								// Dia-----------------
								$dia='';
								$data_dia=array('ad_id'=>$row->artwork_no,
												'version_no'=>$row->version_no,
												'artwork_para_id'=>'1',
												'company_id'=>$this->session->userdata['logged_in']['company_id']);
								$result_dia=$this->common_model->select_active_records_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],$data_dia);
								foreach ($result_dia as $row_dia) {
									$dia=$row_dia->parameter_value;
								}

								
								echo"<tr>
									<td>".$i."</td>
									<td>".$this->common_model->view_date($row->dpr_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".($row->final_approval_flag==1 ? "<i class='check circle icon'></i>" : "").$row->order_no."</td>
									<td>".$row->article_no."</td>
									<td>".$this->common_model->get_article_name($row->article_no,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$row->artwork_no."</td>
									<td>".$row->version_no."</td>
									<td>".$row->jobcard_no."</td>
									<td>".$dia."</td>
									<td>";
									// Plate Nature---------
										$offset=0;
										$screen=0;
										$flexo=0;

										$data_plates=array('dpr_id'=>$row->dpr_id);
										$result_plates=$this->daily_plates_record_model->select_no_plates('graphics_daily_plates_details',$data_plates);
										foreach ($result_plates as $row_plates) {
											$offset=$row_plates->offset;
											$screen=$row_plates->screen;
											$flexo=$row_plates->flexo;
										}

										if($offset>0 AND $screen==0 AND $flexo==0 ){
											echo'Metal';
										}
										else if($screen>0 AND $offset==0  AND $flexo==0)	{
											echo'Screen';
										}
										else if($flexo>0 AND $screen==0 AND $offset==0){
											echo'Flexo';
										}
										else if($screen>0 AND $flexo>0 AND $offset==0){
											echo 'Flexo + Screen';
										}
			
									echo "</td>
									<td>";
										$result_shift=$this->common_model->select_one_active_record('graphics_shift_master',$this->session->userdata['logged_in']['company_id'],'shift_id',$row->shift_id);
										foreach ($result_shift as $row_shift) {
											echo $row_shift->shift_name;
										}
										echo"</td>
										<td>";
										$result_machine=$this->common_model->select_one_active_record('graphics_machine_master',$this->session->userdata['logged_in']['company_id'],'machine_id',$row->machine_id);
										foreach ($result_machine as $row_machine) {
											echo $row_machine->machine_name;
										}
									echo "</td>
									<td>";
										$result_reason=$this->common_model->select_one_active_record('graphics_plate_making_reasons',$this->session->userdata['logged_in']['company_id'],'reason_id',$row->plate_making_reason);
										foreach ($result_reason as $row_reason) {
											echo $row_reason->reason;
										}
									echo "</td>
										<td>";
										$result_operator=$this->common_model->select_one_active_record('graphics_operator_master',$this->session->userdata['logged_in']['company_id'],'operator_id',$row->operator_id);
										foreach ($result_operator as $row_operator) {
											echo strtoupper($row_operator->operator_name);
										}

										echo"</td>
										<td>".$offset."</td>
										<td>".$screen."</td>
										<td>".$flexo."</td>
										<td>".$row->comment."</td>
										<td><a class='ui tiny label'><i class='user icon'></i> ".strtoupper($this->common_model->get_user_name($row->user_id,$this->session->userdata['logged_in']['company_id']))."</a>
										</td>
										<td>".($row->approved_date!='0000-00-00 00:00:00'?$this->common_model->view_date($row->approved_date,$this->session->userdata['logged_in']['company_id']):'')."</td>
										<td>";
										echo ($row->final_approval_flag<>0?"<a class='ui tiny label'><i class='user icon'></i> ".strtoupper($this->common_model->get_user_name($row->approved_by,$this->session->userdata['logged_in']['company_id']))."</a>":"");
										echo"</td>
										<td>";
										foreach($formrights as $formrights_row){ 

											echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->dpr_id).'" target="_blank"><i class="print icon"></i></a> ' : '');					

																				
											echo ($row->archive==1 && $formrights_row->dearchive==1  ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/dearchive/'.$row->dpr_id).'">Dearchive</i></a> ' : '');
																			
										}	


							echo "</td></tr>";
							$i++;
							}
						}?>
								
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>