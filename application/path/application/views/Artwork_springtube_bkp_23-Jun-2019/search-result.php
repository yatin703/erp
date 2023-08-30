
<div class="record_form_design">
<h4>Search Records</h4>
<!--
<a href="<?php echo base_url('/index.php/artwork_springtube/export_to_excel?from_date=').''.$this->input->post('from_date').'&to_date='.$this->input->post('to_date').'&adr_company_id='.$this->input->post('adr_company_id').'&consin_adr_company_id='.$this->input->post('consin_adr_company_id').'&article_no='.$this->input->post('article_no').'&artwork_no='.$this->input->post('artwork_no').'&version_no='.$this->input->post('version_no').'&sleeve_length='.$this->input->post('sleeve_length').'&final_approval_flag='.$this->input->post('final_approval_flag').'&sleeve_color='.$this->input->post('sleeve_color').'&sleeve_dia='.$this->input->post('sleeve_dia').'&print_type='.$this->input->post('print_type').'&print_upto_neck='.$this->input->post('print_upto_neck').'&hot_foil='.$this->input->post('hot_foil').'&lacquer_type='.$this->input->post('lacquer_type').'&non_lacquer_area='.$this->input->post('non_lacquer_area');?>" >

<button class="ui icon blue mini button" id="export_to_excel">
		 <i class="file excel outline icon"></i> Export to Excel
</button>

</a>
</br>-->
	<div class="record_inner_design" style="overflow: scroll;">
			<table class="record_table_design_without_fixed">
				<tr>
					<th></th>
					<th colspan="19">Artwork Details</th>
					<th colspan="4">Approval Detail</th>
				</tr>
				<tr>
					<th>Id</th>
					<th>No</th>
					<th>Verison</th>
					<th>File</th>
					<th>Date</th>
					<th>Customer</th>
					<th>Article No</th>
					<th>Article Name</th>
					<th>Dia</th>
					<th>Length</th>
					<th>Laminate Color</th>
					<th>Print Type</th>
					<th>Cold Foil One</th>
					<th>Cold Foil Two</th>
					<th>Pre Lacquer One</th>
					<th>Pre Lacquer Two</th>
					<th>Post Lacquer One</th>
					<th>Post Lacquer Two</th>
					<th>Non Lacquer Length</th>
					<th>Body Making/Seam Type</th>
					<th>Created By</th>
					<th>Approved Date</th>
					<th>Approved By</th>
					<th>Action</th>
				</tr>
				<?php if($artwork_springtube==FALSE){
					echo "<tr><td colspan='19'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
								
							foreach($artwork_springtube as $row){

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

								$result_dia=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','1');
								$result_length=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','2');
								$result_sleeve_color=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','3');
												
								$result_cold_foil_one=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','4');
								$result_cold_foil_one_area=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','5');
								
								$result_cold_foil_two=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','6');
								$result_cold_foil_two_area=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','7');

								$result_pre_lacquer_one=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','8');
								
								$result_pre_lacquer_one_perc=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','9');
								
								$result_pre_lacquer_two=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','10');

								$result_pre_lacquer_two_perc=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','11');

								$result_post_lacquer_one=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','12');
								
								$result_post_lacquer_one_perc=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','13');
								
								$result_post_lacquer_two=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','14');

								$result_post_lacquer_two_perc=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','15');

								$result_non_varnish_length=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','16');

								$result_body_making_type=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','17');

								$result_print_type=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','18');


								echo "<tr>
									<td>".$i."</td>
									<td><a href='".base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->ad_id.'/'.$row->version_no)."' target='_blank'><b>".$row->ad_id."</b></a></td>
									<td><b><a class='ui ".($row->final_approval_flag=='1' ? "green"  : "red")." circular label'> $row->version_no</td>
									<td>".($row->artwork_image_nm!='' ? '<a href="'.base_url('assets/'.$this->session->userdata['logged_in']['company_id'].'/artwork/'.$row->artwork_image_nm.'').'" target="_blank"><i class="file pdf outline icon"></i></a>' :'')."</td>
									<td>".$this->common_model->view_date($row->ad_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".strtoupper($customer)."</td>
									<td>".$row->article_no."</td>
									<td>".$this->common_model->get_article_name($row->article_no,$this->session->userdata['logged_in']['company_id'])."</td>
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
										foreach($result_cold_foil_one as $cold_foil_one_row){
											//echo $cold_foil_one_row->parameter_value;
											echo $this->common_model->get_article_name($cold_foil_one_row->parameter_value,$this->session->userdata['logged_in']['company_id']);
										} 
										if($result_cold_foil_one==TRUE){

											foreach($result_cold_foil_one_area as $cold_foil_one_area_row){
												echo ($cold_foil_one_area_row->parameter_value!=''? ' ('.$cold_foil_one_area_row->parameter_value ." SQM/TUBE )":"");
												
											}

										}
										//$this->common_model->get_article_name($cold_foil_one_area_row->parameter_value,$this->session->user_data['logged_in']['company_id'])
									echo "</td>
									<td>";

									if($result_cold_foil_two==TRUE){

										foreach($result_cold_foil_two as $cold_foil_two_row){
											echo $this->common_model->get_article_name($cold_foil_two_row->parameter_value,$this->session->userdata['logged_in']['company_id']);											
										}

										foreach($result_cold_foil_two_area as $cold_foil_two_area_row){
											echo ($cold_foil_two_area_row->parameter_value!=''?' ('.$cold_foil_two_area_row->parameter_value." SQM/TUBE )":"");
										}
									}

									echo "</td>
									<td>";
										
										if($result_pre_lacquer_one==TRUE){

											foreach($result_pre_lacquer_one as $pre_lacquer_one_row){
											echo $this->common_model->get_article_name($pre_lacquer_one_row->parameter_value,$this->session->userdata['logged_in']['company_id']);

												foreach($result_pre_lacquer_one_perc as $pre_lacquer_one_perc){
													echo($pre_lacquer_one_perc->parameter_value!=''?' '.$pre_lacquer_one_perc->parameter_value.' %':'');
												}

											}
										}
									echo "</td>

									<td>";

										if($result_pre_lacquer_two==TRUE){

											foreach($result_pre_lacquer_two as $pre_lacquer_two_row){
												echo $this->common_model->get_article_name($pre_lacquer_two_row->parameter_value,$this->session->userdata['logged_in']['company_id']);
											
												foreach($result_pre_lacquer_two_perc as $pre_lacquer_two_perc_row){
													echo($pre_lacquer_two_perc_row->parameter_value!=''?' '.$pre_lacquer_two_perc_row->parameter_value.' %':'');
												}
										   }

										}
										echo "</td>
										<td>";

										if($result_post_lacquer_one==TRUE){

											foreach($result_post_lacquer_one as $post_lacquer_one_row){
											echo $this->common_model->get_article_name($post_lacquer_one_row->parameter_value,$this->session->userdata['logged_in']['company_id']);

												foreach($result_post_lacquer_one_perc as $post_lacquer_one_perc){
													echo($post_lacquer_one_perc->parameter_value!=''?' '.$post_lacquer_one_perc->parameter_value.' %':'');
												}

											}
										}
									echo "</td>

									<td>";

										if($result_post_lacquer_two==TRUE){

											foreach($result_post_lacquer_two as $post_lacquer_two_row){
												echo $this->common_model->get_article_name($post_lacquer_two_row->parameter_value,$this->session->userdata['logged_in']['company_id']);
											
												foreach($result_post_lacquer_two_perc as $post_lacquer_two_perc_row){
													echo($post_lacquer_two_perc_row->parameter_value!=''?' '.$post_lacquer_two_perc_row->parameter_value.' %':'');
												}
										   }

										}
										echo "</td>
										<td>";


											foreach($result_non_varnish_length as $non_varnish_length_row){
												echo strtoupper($non_varnish_length_row->parameter_value);
											} 
									echo "</td>
										<td>";


											foreach($result_body_making_type as $body_making_type_row){
												echo strtoupper($body_making_type_row->parameter_value);
											} 
									echo "</td>

									<td><a class='ui tiny label'><i class='user icon'></i> ".strtoupper($this->common_model->get_user_name($row->user_id,$this->session->userdata['logged_in']['company_id']))."</a></td>
									
								
									<td>".$this->common_model->view_date($row->approval_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".($row->approved_by!='' ? "<a class='ui tiny label'><i class='checkmark box icon'></i>":'' )."".strtoupper($this->common_model->get_user_name($row->approved_by,$this->session->userdata['logged_in']['company_id']))."</td>
									<td>";
									foreach($formrights as $formrights_row){ 

										echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->ad_id.'/'.$row->version_no).'" target="_blank"><i class="print icon"></i></a> ' : '');

										echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/xml/'.$row->ad_id.'/'.$row->version_no).'" target="_blank"><i class="download icon"></i></a> ' : '');

										echo ($formrights_row->modify==1 && $row->final_approval_flag<>1 && $row->pending_flag<>1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->ad_id.'/'.$row->version_no).'"><i class="edit icon"></i></a> ' : '');

										echo ($formrights_row->copy==1 && $row->final_approval_flag<>1 && $row->pending_flag<>1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/attach/'.$row->ad_id.'/'.$row->version_no).'"><i class="attach icon"></i></a> ' : '');

										echo ($row->archive<>1 && $formrights_row->delete==1 && $row->final_approval_flag<>1 && $row->pending_flag<>1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->ad_id.'/'.$row->version_no).'"><i class="trash icon"></i></a> ' : '');

										echo ($formrights_row->copy==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/copy/'.$row->ad_id.'/'.$row->version_no).'" target="_blank"><i class="copy icon"></i></a> ' : '');

										
									}
									echo "</td>
							</tr>";
							$i++;
							}
						}?>
								
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>