<div class="record_form_design">
<h3>Archive Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design">
				<tr>
					<th></th>
					<th colspan="13">Artwork Details</th>
					<th colspan="4">Approval Detail</th>
				</tr>
				<tr>
					<th>Id</th>
					<th>No</th>
					<th>Verison</th>
					<th>Date</th>
					<th>Customer</th>
					<th>Article No</th>
					<th>Article Name</th>
					<th>Dia</th>
					<th>Length</th>
					<th>Color</th>
					<th>Print Type</th>
					<th>Printing Upto Neck</th>
					<th>Hot Foil</th>
					<th>Lacquer Type</th>
					<th>Created By</th>
					<th>Date</th>
					<th>Approved By</th>
					<th>Action</th>
				</tr>
				<?php if($artwork==FALSE){
					echo "<tr><td colspan='19'>No Active Records Found</td></tr>";
				}else{
								$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
								
							foreach($artwork as $row){

								$result_dia=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','1');
								$result_length=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','2');
								$result_sleeve_color=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','7');
								$result_print_type=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','17');
								$result_printing_upto_neck=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','8');

								$result_hot_foil=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','11');

								$result_lacquer_type=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','12');


								echo "<tr>
									<td>".$i."</td>
									<td>".$row->ad_id."</td>
									<td>".$row->version_no." ".($row->artwork_image_nm!='' ? '<a href="'.base_url('assets/images/'.$row->artwork_image_nm.'').'" ><i class="file pdf outline icon"></i></a>' :'')." ".($row->final_approval_flag==1 ? '<i class="check circle icon"></i>' : '')."</td>
									<td>".$this->common_model->view_date($row->ad_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".strtoupper($row->customer_name)."</td>
									<td>".$row->article_no."</td>
									<td>".strtoupper($row->article_name)."</td>
									<td>";
									foreach($result_dia as $dia_row){
										echo $dia_row->parameter_value;
									} 
									echo "</td>
									<td>";
										foreach($result_length as $length_row){
											echo $length_row->parameter_value;
										} 
									echo "</td>
									<td>";
										foreach($result_sleeve_color as $sleeve_color_row){
											echo strtoupper($sleeve_color_row->parameter_value);
										} 
									echo "</td>
									<td>";
										foreach($result_print_type as $print_type_row){
											echo strtoupper($print_type_row->parameter_value);
										} 
									echo "</td>
									<td>";
										foreach($result_printing_upto_neck as $printing_upto_neck_row){
											echo strtoupper($printing_upto_neck_row->parameter_value);
										} 
									echo "</td>
									<td>";
										foreach($result_hot_foil as $hot_foil_row){
											echo strtoupper($hot_foil_row->parameter_value);
										} 
									echo "</td>
									<td>";
										foreach($result_lacquer_type as $lacquer_row){
											echo strtoupper($lacquer_row->parameter_value);
										} 
									echo "</td>
									<td>".substr(strtoupper($row->username),0,strpos($row->username,' '))."</td>
									
								
									<td>".$this->common_model->view_date($row->approval_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".substr(strtoupper($row->approval_username),0,strpos($row->approval_username,' '))."</td>
									<td>";
										foreach($formrights as $formrights_row){ 
										echo ($row->archive==1 && $formrights_row->dearchive==1 ? '<a  href="'.base_url('index.php/'.$this->router->fetch_class().'/dearchive/'.$row->ad_id.'/'.$row->version_no).'"><i class="recycle icon"></i></a> ' : '');
									}
									echo "</td>
							</tr>";
							}
						}?>
								
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>