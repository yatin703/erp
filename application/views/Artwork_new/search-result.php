

<div class="record_form_design">
<h4>Search Records</h4>

<a href="<?php echo base_url('/index.php/artwork/export_to_excel?from_date=').''.$this->input->post('from_date').'&to_date='.$this->input->post('to_date').'&adr_company_id='.$this->input->post('adr_company_id').'&consin_adr_company_id='.$this->input->post('consin_adr_company_id').'&article_no='.$this->input->post('article_no').'&artwork_no='.$this->input->post('artwork_no').'&version_no='.$this->input->post('version_no').'&sleeve_length='.$this->input->post('sleeve_length').'&final_approval_flag='.$this->input->post('final_approval_flag').'&sleeve_color='.$this->input->post('sleeve_color').'&sleeve_dia='.$this->input->post('sleeve_dia').'&print_type='.$this->input->post('print_type').'&print_upto_neck='.$this->input->post('print_upto_neck').'&hot_foil='.$this->input->post('hot_foil').'&lacquer_type='.$this->input->post('lacquer_type').'&non_lacquer_area='.$this->input->post('non_lacquer_area');?>" >

<button class="ui icon blue mini button" id="export_to_excel">
		 <i class="file excel outline icon"></i> Export to Excel
</button>

</a>
</br>
	<div class="record_inner_design" style="overflow: scroll;white-space: nowrap;">
			<table class="record_table_design_without_fixed">
				<tr>
					<th></th>
					<th colspan="19">Artwork Details</th>
					<th colspan="4">Approval Detail</th>
				</tr>
				<tr>
					<th>Id</th>
					<th>Action</th>
					<th>AW No</th>
					<th>Ver</th>
					<th>3D File</th>
					<th>Cust Appr File</th>
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
					<th>Created By</th>
					<th>Approved Date</th>
					<th>Approved By</th>
					
				</tr>
				<?php if($artwork==FALSE){
					echo "<tr><td colspan='19'>No Active Records Found</td></tr>";
				}else{
								$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
								
							foreach($artwork as $row){

								$customer='';
								$article_name='';
								$result_customer=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$row->adr_company_id);

								foreach ($result_customer as $customer_row){
									$customer=$customer_row->name1;
								}

								$article_result=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$row->article_no);
								
								foreach($article_result as $article_row){
									$article_name=$article_row->article_name.($article_row->article_sub_description!=''?' ('.$article_row->article_sub_description.')':'');

								}

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


								echo "<tr>
									<td>".$i."</td><td>";

									foreach($formrights as $formrights_row){ 

										echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->ad_id.'/'.$row->version_no).'" target="_blank"><i class="print icon"></i></a> ' : '');
										
										echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/xml/'.$row->ad_id.'/'.$row->version_no).'" target="_blank"><i class="download icon"></i></a> ' : '');

										echo ($formrights_row->modify==1 && $row->final_approval_flag<>1 && $row->pending_flag<>1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->ad_id.'/'.$row->version_no).'"><i class="edit icon"></i></a> ' : '');

										echo ($formrights_row->copy==1 && $row->final_approval_flag<>1 && $row->pending_flag<>1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/attach/'.$row->ad_id.'/'.$row->version_no).'"><i class="attach icon"></i></a> ' : '');

										echo ($row->archive<>1 && $formrights_row->delete==1 && $row->final_approval_flag<>1 && $row->pending_flag<>1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->ad_id.'/'.$row->version_no).'"><i class="trash icon"></i></a> ' : '');

										echo ($formrights_row->copy==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/copy/'.$row->ad_id.'/'.$row->version_no).'" target="_blank"><i class="copy icon"></i></a> ' : '');

										

										echo ($row->archive<>1 && $formrights_row->delete==1 && $row->final_approval_flag==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/remove_approval/'.$row->ad_id.'/'.$row->version_no).'" target="_blank" title="Remove Approval"><i class="edit icon"></i></a> ' : '');

										echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/csv_coex/'.$row->ad_id.'/'.$row->version_no).'" target="_blank"><i class="file excel outline icon"></i></a> ' : '');

										
									}


									echo"</td><td><a href='".base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->ad_id.'/'.$row->version_no)."' target='_blank'><b>".str_replace('AW','AW00',$row->ad_id)."</b></a></td>
									<td><b><a class='ui ".($row->final_approval_flag=='1' ? "green"  : "red")." circular label'> $row->version_no</td>
									<td>".($row->artwork_image_nm!='' ? '<a href="'.base_url('assets/'.$this->session->userdata['logged_in']['company_id'].'/artwork/'.$row->artwork_image_nm.'').'" target="_blank"><i class="file pdf outline icon"></i></a>' :'')." "."</td>

									<td>";

									if($row->customer_artwork_pdf!=''){
									echo'<a href="'.base_url('assets/'.$this->session->userdata['logged_in']['company_id'].'/artwork/'.$row->customer_artwork_pdf.'').'" target="_blank"><i class="file pdf outline icon"></i></a>';



									foreach($formrights as $formrights_row):

											if($formrights_row->new==1  && $row->final_approval_flag=='0'){  
												
												?>
												<a href="#" onclick="window.open('<?php echo base_url().'index.php/'.$this->router->fetch_class().'/attach_customer_file/'.$row->ad_id.'/'.$row->version_no;?>','Customer Approved File','height=200,width=615')"><i class="attach icon"></i></a>
									<?php 
											}
									endforeach;


									}else{

										//echo '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/attach_customer_file/'.$row->ad_id.'/'.$row->version_no).'" target="_blank"><i class="attach icon"></i></a> ';
										foreach($formrights as $formrights_row):

											if($formrights_row->new==1 && $row->final_approval_flag=='1'){  ?>	


												<a href="#" onclick="window.open('<?php echo base_url().'index.php/'.$this->router->fetch_class().'/attach_customer_file/'.$row->ad_id.'/'.$row->version_no;?>','Customer Approved File','height=200,width=615')"><i class="attach icon"></i></a>
									<?php 
											}
										endforeach;

								}// Else


									echo "</td>

									<td>".$this->common_model->view_date($row->ad_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".strtoupper($customer)."</td>
									<td>".$row->article_no."</td>
									<td>".strtoupper($article_name)."</td>
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
									<td>".$row->non_lacquer_area."</td>
									<td><a class='ui tiny label'><i class='user icon'></i> ".strtoupper($this->common_model->get_user_name($row->user_id,$this->session->userdata['logged_in']['company_id']))."</a></td>
									
								
									<td>".$this->common_model->view_date($row->approval_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".($row->approved_by!='' ? "<a class='ui tiny label'><i class='checkmark box icon'></i>":'' )."".strtoupper($this->common_model->get_user_name($row->approved_by,$this->session->userdata['logged_in']['company_id']))."</td>";
									
									echo "
							</tr>";
							$i++;
							}
						}?>
								
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>