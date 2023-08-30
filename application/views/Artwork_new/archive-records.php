<style>	
   tr:hover {background-color:#e4e4e4;}
</style>
<div class="record_form_design">
<h4>Archive Records</h4>
	<div class="record_inner_design"  style="overflow: scroll;white-space: nowrap">
			<table class="record_table_design_without_fixed">
				<tr>
					<th></th>
					<th colspan="18">Artwork Details</th>
					<th colspan="3">Approval Detail</th>
				</tr>
				<tr>
					<th>Id</th>
					<th>Action</th>
					<th>AW No</th>
					<th>Ver</th>
					<th>3D File</th>
					<th>ADR Date</th>
					<th>Customer</th>
					<th>Article No</th>
					<th>Article Name</th>
					<th>Dia</th>
					<th>Tube Length</th>
					<th>Tube Color</th>
					<th>Print Type</th>
					<th>Printing Upto Neck</th>
					<th>Foil One</th>
					<th>Foil Two</th>
					<th>Lacquer One</th>
					<th>Lacquer Two</th>
					<th>Sealing Non Lacquring Area</th>
					<th>ADR Created By</th>
					<th>Approved Date</th>
					<th>Approved By</th>
					<!-- <th>Action</th> -->
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
								$result_hot_foil_one=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','23');
								$result_hot_foil_one_per_tube=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','24');
								
								$result_hot_foil_two=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','25');
								$result_hot_foil_two_per_tube=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','26');

								$result_lacquer_type=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','12');

								$result_lacquer_one=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','27');
								
								$result_lacquer_one_pc=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','28');
								
								$result_lacquer_two=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','29');

								$result_lacquer_two_pc=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','30');

								$result_sealing_non_lacquring=$this->artwork_model->select_details_record_where('artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','5');


								echo "<tr>
									<td>".$i."</td>
									<td>";

									foreach($formrights as $formrights_row){ 

										echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->ad_id.'/'.$row->version_no).'" target="_blank"><i class="print icon"></i></a> ' : '');
										
										echo ($row->archive==1 && $formrights_row->dearchive==1 ? '<a  href="'.base_url('index.php/'.$this->router->fetch_class().'/dearchive/'.$row->ad_id.'/'.$row->version_no).'"><i class="recycle icon"></i></a> ' : '');
										
										
									}

									echo"</td>
									<td><a href='".base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->ad_id.'/'.$row->version_no)."' target='_blank'><b>".str_replace('AW','AW00',$row->ad_id)."</b></a></td>
									<td><b><a class='ui ".($row->final_approval_flag=='1' ? "green"  : "red")." circular label'> $row->version_no</td>
									<td>".($row->artwork_image_nm!='' ? '<a href="'.base_url('assets/'.$this->session->userdata['logged_in']['company_id'].'/artwork/'.$row->artwork_image_nm.'').'" target="_blank"><i class="file pdf outline icon"></i></a>' :'')."</td>
									<td>".$this->common_model->view_date($row->ad_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".strtoupper($row->customer_name)."</td>
									<td>".$row->article_no."</td>
									<td>".strtoupper($row->article_name.($row->article_sub_description!=''?' ('.$row->article_sub_description.')':''))."</td>
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
											$hot_foil=substr($hot_foil_row->parameter_value,strpos($hot_foil_row->parameter_value, "||") + 2);
											echo strtoupper(str_replace("^"," + ",$hot_foil));
										} 

										if($result_hot_foil_one==TRUE){

											foreach($result_hot_foil_one as $hot_foil_row){
											$hot_foil_row->parameter_value;
											$data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$hot_foil_row->parameter_value);
											if($data['article']==TRUE){
												foreach($data['article'] as $article_row){
													echo $article_row->article_name;
												}
												}
											}

											foreach($result_hot_foil_one_per_tube as $hot_foil_row){
												echo $result_hot_foil_one_per_tube=(!empty($hot_foil_row->parameter_value) ? " ".$hot_foil_row->parameter_value." SQM/TUBE" : "");
												//echo " ".$hot_foil_row->parameter_value."SQM/TUBE";
											}

										}
									echo "</td>
									<td>";

									if($result_hot_foil_two==TRUE){

										foreach($result_hot_foil_two as $hot_foil_row){
											//echo $hot_foil_row->parameter_value;

											$data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$hot_foil_row->parameter_value);
											if($data['article']==TRUE){
												foreach($data['article'] as $article_row){
													echo $article_row->article_name;
												}
											}
										}

										foreach($result_hot_foil_two_per_tube as $hot_foil_row){
											echo $result_hot_foil_one_per_tube=(!empty($hot_foil_row->parameter_value) ? " ".$hot_foil_row->parameter_value." SQM/TUBE" : "");
											}
										}

									echo "</td>
									<td>";
										foreach($result_lacquer_type as $lacquer_row){
											$lacquer=substr($lacquer_row->parameter_value,strpos($lacquer_row->parameter_value, "||") + 2);
											echo strtoupper(str_replace("^"," + ",$lacquer));
										} 


										if($result_lacquer_one==TRUE){

											foreach($result_lacquer_one as $result_lacquer_one_row){
											$result_lacquer_one_row->parameter_value;
											$data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$result_lacquer_one_row->parameter_value);
											if($data['article']==TRUE){
												foreach($data['article'] as $article_row){
													echo $article_row->article_name;
												}
												}
											}

											foreach($result_lacquer_one_pc as $result_lacquer_one_pc_row){
												echo $result_lacquer_one_pc_row=(!empty($result_lacquer_one_pc_row->parameter_value) ? " ".$result_lacquer_one_pc_row->parameter_value."%" : "");
												//echo " ".$hot_foil_row->parameter_value."SQM/TUBE";
											}

										}
									echo "</td>

									<td>";


										if($result_lacquer_two==TRUE){

											foreach($result_lacquer_two as $result_lacquer_two_row){
											$result_lacquer_two_row->parameter_value;
											$data['article']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$result_lacquer_two_row->parameter_value);
											if($data['article']==TRUE){
												foreach($data['article'] as $article_row){
													echo $article_row->article_name;
												}
												}
											}

											foreach($result_lacquer_two_pc as $result_lacquer_two_pc_row){
												echo $result_lacquer_two_pc_row=(!empty($result_lacquer_two_pc_row->parameter_value) ? " ".$result_lacquer_two_pc_row->parameter_value."%" : "");
												//echo " ".$hot_foil_row->parameter_value."SQM/TUBE";
											}

										}
										echo "</td>
										<td>";
										foreach($result_sealing_non_lacquring as $sealing_non_lacquring_row){
											echo strtoupper($sealing_non_lacquring_row->parameter_value);
										} 
									echo "</td>
									<td><a class='ui tiny label'><i class='user icon'></i> ".substr(strtoupper($row->username),0,strpos($row->username,' '))."</a></td>
									
								
									<td>".$this->common_model->view_date($row->approval_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".($row->approval_username!='' ? "<a class='ui tiny label'><i class='checkmark box icon'></i>":'' )."".substr(strtoupper($row->approval_username),0,strpos($row->approval_username,' '))."
									</td>
									
							</tr>";
							$i++;
							}
						}?>
								
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>