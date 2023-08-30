<style>	
   tr:hover {background-color:#e4e4e4;}
</style>

<div class="record_form_design">
<h4>Active Records</h4>
	<div class="record_inner_design"  style="overflow: scroll;white-space: nowrap;">
			<table class="record_table_design_without_fixed">
				<tr>
					<th></th>
					<th colspan="23">Artwork Details</th>
					<th colspan="3">Approval Detail</th>
				</tr>
				<tr>
					<th>#</th>
					<th>Action</th>
					<th>SAW No.</th>
					<th>Ver</th>
					<th>3D File</th>
					<th>Cust Appr File</th>
					<th>ADR Date</th>
					<th>Customer Name</th>
					<th>Article No</th>
					<th>Article/Variant Name</th>
					<th>Dia</th>
					<th>Tube Length</th>
					<th>Laminate/Substrate Color</th>
					<th>Print Type</th>
					<th>Cold Foil One</th>
					<th>Foil One Width</th>
					<th>Cold Foil Two</th>
					<th>Foil Two Width</th>
					<th>Pre Lacquer One</th>
					<th>Pre Lacquer Two</th>
					<th>Post Lacquer One</th>
					<th>Post Lacquer Two</th>
					<th>Non Lacquer Length</th>
					<th>Body Making/Seam Type</th>
					<th>ADR Created By</th>
					<th>Approved Date</th>
					<th>Approved By</th>
					
				</tr>
				<?php if($artwork_springtube==FALSE){
					echo "<tr><td colspan='22'>No Active Records Found</td></tr>";
				}else{
								$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
								
							foreach($artwork_springtube as $row){

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

								$result_cold_foil_one_length=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','19');
								$result_cold_foil_one_width=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','20');

								$result_cold_foil_two_length=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','21');
								$result_cold_foil_two_width=$this->artwork_springtube_model->select_details_record_where('springtube_artwork_devel_details',$this->session->userdata['logged_in']['company_id'],'ad_id',$row->ad_id,'version_no',$row->version_no,'artwork_para_id','22');




								echo "<tr>
									<td>".$i."</td>
									<td>";
									foreach($formrights as $formrights_row){ 

										echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->ad_id.'/'.$row->version_no).'" target="_blank"><i class="print icon"></i></a> ' : '');

										echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/xml/'.$row->ad_id.'/'.$row->version_no).'" target="_blank"><i class="download icon"></i></a> ' : '');

										echo ($formrights_row->modify==1 && $row->final_approval_flag<>1 && $row->pending_flag<>1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->ad_id.'/'.$row->version_no).'" target="_blank"><i class="edit icon"></i></a> ' : '');

										echo ($formrights_row->copy==1 && $formrights_row->modify==1 && $row->final_approval_flag<>1 && $row->pending_flag<>1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/attach/'.$row->ad_id.'/'.$row->version_no).'" target="_blank"><i class="attach icon"></i></a> ' : '');

										echo ($row->archive<>1 && $formrights_row->delete==1 && $row->final_approval_flag<>1 && $row->pending_flag<>1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->ad_id.'/'.$row->version_no).'" target="_blank"><i class="trash icon"></i></a> ' : '');

										echo ($formrights_row->copy==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/copy/'.$row->ad_id.'/'.$row->version_no).'" target="_blank"><i class="copy icon"></i></a> ' : '');

										
									}
									echo "</td>

									<td><a href='".base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->ad_id.'/'.$row->version_no)."' target='_blank'><b>".$row->ad_id."</b></a></td>
									<td><b><a class='ui ".($row->final_approval_flag=='1' ? "green"  : "red")." circular label'> $row->version_no</td>
									
									<!--<td style='color: ".($row->final_approval_flag==1? "green":"red").";font-size: 9pt;font-weight: 600;vertical-align: middle;'>$row->version_no</td>
									-->

									<td>".($row->artwork_image_nm!='' ? '<a href="'.base_url('assets/'.$this->session->userdata['logged_in']['company_id'].'/artwork_springtube/'.$row->artwork_image_nm.'').'" target="_blank"><i class="file pdf outline icon"></i></a>' :'')."</td>
									<td>";

									if($row->customer_artwork_pdf!=''){
									echo'<a href="'.base_url('assets/'.$this->session->userdata['logged_in']['company_id'].'/artwork_springtube/'.$row->customer_artwork_pdf.'').'" target="_blank"><i class="file pdf outline icon"></i></a>';
									//echo'<a href="" onclick="window.open('.base_url('assets/'.$this->session->userdata['logged_in']['company_id'].'/artwork_springtube/'.$row->customer_artwork_pdf.'').'" target="_blank" ><i class="file pdf outline icon"></i></a>';

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

											if($formrights_row->new==1 && $row->final_approval_flag=='0'){  ?>	


												<a href="#" onclick="window.open('<?php echo base_url().'index.php/'.$this->router->fetch_class().'/attach_customer_file/'.$row->ad_id.'/'.$row->version_no;?>','Customer Approved File','height=200,width=615')"><i class="attach icon"></i></a>
									<?php 
											}
										endforeach;

								}// Else


									echo "</td><td>".$this->common_model->view_date($row->ad_date,$this->session->userdata['logged_in']['company_id'])."</td>
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
											echo' MM';
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

											$cold_foil_1_length='';
											$cold_foil_1_width='';

											foreach($result_cold_foil_one_length as $cold_foil_one_length_row){

												$cold_foil_1_length=$cold_foil_one_length_row->parameter_value;
												
											}

											foreach($result_cold_foil_one_width as $cold_foil_one_width_row){
												$cold_foil_1_width=$cold_foil_one_width_row->parameter_value;									
											}
											//echo'<br>';
											//echo'&nbsp;';
											//echo ($cold_foil_1_length!=''?'(L-'.$cold_foil_1_length.'MM, W-'.$cold_foil_1_width.'MM)':'');



										}
										//$this->common_model->get_article_name($cold_foil_one_area_row->parameter_value,$this->session->user_data['logged_in']['company_id'])
									echo "</td>
									<td>".($cold_foil_1_width!=''?$cold_foil_1_width." MM":"")."</td>
									<td>";

									if($result_cold_foil_two==TRUE){

										foreach($result_cold_foil_two as $cold_foil_two_row){
											echo $this->common_model->get_article_name($cold_foil_two_row->parameter_value,$this->session->userdata['logged_in']['company_id']);											
										}

										$cold_foil_2_length='';
										$cold_foil_2_width='';

											foreach($result_cold_foil_two_length as $cold_foil_two_length_row){

												$cold_foil_2_length=$cold_foil_two_length_row->parameter_value;
												
											}

											foreach($result_cold_foil_two_width as $cold_foil_two_width_row){
												$cold_foil_2_width=$cold_foil_two_width_row->parameter_value;									
											}
											//echo'<br>';
											//echo'&nbsp;';
											//echo ($cold_foil_2_length!=''? ($cold_foil_2_length*$cold_foil_2_width)/1000000:'');
									}

									echo "</td>
									<td>".($cold_foil_2_width!=''?$cold_foil_2_width." MM":"")."</td>
									<td>";
										
										if($result_pre_lacquer_one==TRUE){

											foreach($result_pre_lacquer_one as $pre_lacquer_one_row){
											echo $this->common_model->get_article_name($pre_lacquer_one_row->parameter_value,$this->session->userdata['logged_in']['company_id']);

												foreach($result_pre_lacquer_one_perc as $pre_lacquer_one_perc){
													echo($pre_lacquer_one_perc->parameter_value!=''? ' '.$pre_lacquer_one_perc->parameter_value.' %':'');
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
												//echo strtoupper($non_varnish_length_row->parameter_value);
												echo ($non_varnish_length_row->parameter_value=='0'?'FULL VARNISH':$non_varnish_length_row->parameter_value.' MM');
											} 
									echo "</td>
										<td>";


											foreach($result_body_making_type as $body_making_type_row){
												echo strtoupper($body_making_type_row->parameter_value);
											} 
									echo "</td>

									<td><a class='ui tiny label'><i class='user icon'></i> ".substr(strtoupper($row->username),0,strpos($row->username,' '))."</a>
									</td>

									<!--<td>".substr(strtoupper($row->username),0,strpos($row->username,' '))."
									</td>-->
									
								
									<td>".$this->common_model->view_date($row->approval_date,$this->session->userdata['logged_in']['company_id'])."</td>

									<td>".($row->approval_username!='' ? "<a class='ui tiny label'><i class='checkmark box icon'></i>":'' )."".substr(strtoupper($row->approval_username),0,strpos($row->approval_username,' '))."</td>
									
									
									
							</tr>";
							$i++;
							}
						}?>
								
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>