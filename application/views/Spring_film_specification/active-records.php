<div class="record_form_design">
<h4>Active Records</h4>
	<div class="record_inner_design" style="overflow: scroll;">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th>Date</th>
					<th>Sleeve No</th>
					<!--<th>Sleeve Name</th>-->
					<th>Dia</th>
					<th>Length</th>
					<th>Layer</th>
					<th>Layer 1 Details</th>
					<th>Layer 2 Details</th>
					<th>Layer 3 Details</th>
					<th>Layer 4 Details</th>
					<th>Layer 5 Details</th>
					<th>Layer 6 Details</th>
					<th>Layer 7 Details</th>
					<th>Created By</th>
					<th>Approved Date</th>
					<th>Approved By</th>
					<th>Action</th>
				</tr>
				<?php if($specification==FALSE){
					echo "<tr><td colspan='12'>No Active Records Found</td></tr>";
				}else{
								$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
								
							foreach($specification as $row){

							$data=array('spec_id'=>$row->spec_id,
									'spec_version_no'=>$row->spec_version_no);

							
							$data['specs_details']=$this->sales_order_book_model->select_film_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data);
							//echo $this->db->last_query();
								if($data['specs_details']==FALSE){
									$SLEEVE_DIA="";
									$SLEEVE_LENGTH="";
									
									$FILM_GUAGE_1="";
									$FILM_LDPE_1="";
									$FILM_LDPE_PERC_1="";

									$FILM_HDPE_1="";
									$FILM_HDPE_PERC_1="";
									$FILM_LLDPE_1="";
									$FILM_LLDPE_PERC_1="";


									$FILM_GUAGE_2="";
									$FILM_MASTER_BATCH_2="";
									$FILM_MB_PERC_2="";
									$FILM_LLDPE_2="";
									$FILM_LLDPE_PERC_2="";
									$FILM_HDPE_2="";
									$FILM_HDPE_PERC_2="";

									$FILM_GUAGE_3="";
									$FILM_ADMER_3="";
									$FILM_ADMER_PERC_3="";

									$FILM_GUAGE_4="";
									$FILM_EVOH_4="";
									$FILM_EVOH_PERC_4="";

									$FILM_GUAGE_5="";
									$FILM_ADMER_5="";
									$FILM_ADMER_PERC_5="";
									$FILM_HDPE_5="";
									$FILM_HDPE_PERC_5="";

									$FILM_GUAGE_6="";
									$FILM_MASTER_BATCH_6="";
									$FILM_MB_PERC_6="";
									$FILM_LLDPE_6="";
									$FILM_LLDPE_PERC_6="";
									$FILM_HDPE_6="";
									$FILM_HDPE_PERC_6="";

									$FILM_GUAGE_7="";
									$FILM_LDPE_7="";
									$FILM_LDPE_PERC_7="";
									$FILM_LLDPE_7="";
									$FILM_LLDPE_PERC_7="";
									$FILM_HDPE_7="";
									$FILM_HDPE_PERC_7="";

								}else{
									foreach($data['specs_details'] as $specs_details_row){
										$SLEEVE_DIA=$specs_details_row->SLEEVE_DIA;
										$SLEEVE_LENGTH=$specs_details_row->SLEEVE_LENGTH;

										$FILM_GUAGE_1=(!empty($specs_details_row->FILM_GUAGE_1) ? $specs_details_row->FILM_GUAGE_1."MIC" : "");
										$FILM_LDPE_1=$specs_details_row->FILM_LDPE_1;
										$FILM_LDPE_PERC_1=($specs_details_row->FILM_LDPE_PERC_1!='' ? $specs_details_row->FILM_LDPE_PERC_1."%" : "");
										$FILM_LLDPE_1=$specs_details_row->FILM_LLDPE_1;
										$FILM_LLDPE_PERC_1=(!empty($specs_details_row->FILM_LLDPE_PERC_1) ? $specs_details_row->FILM_LLDPE_PERC_1."%" : "");

										$FILM_HDPE_1=$specs_details_row->FILM_HDPE_1;
										$FILM_HDPE_PERC_1=($specs_details_row->FILM_HDPE_PERC_1!='' ? $specs_details_row->FILM_HDPE_PERC_1."%" : "");
										

										$FILM_GUAGE_2=(!empty($specs_details_row->FILM_GUAGE_2) ? $specs_details_row->FILM_GUAGE_2."MIC" : "");
										$FILM_MASTER_BATCH_2=$specs_details_row->FILM_MASTER_BATCH_2;
										$FILM_MB_PERC_2=($specs_details_row->FILM_MB_PERC_2!='' ? $specs_details_row->FILM_MB_PERC_2."%" : "");
										$FILM_LLDPE_2=$specs_details_row->FILM_LLDPE_2;
										$FILM_LLDPE_PERC_2=(!empty($specs_details_row->FILM_LLDPE_PERC_2) ? $specs_details_row->FILM_LLDPE_PERC_2."%" : "");
										$FILM_HDPE_2=$specs_details_row->FILM_HDPE_2;
										$FILM_HDPE_PERC_2=(!empty($specs_details_row->FILM_HDPE_PERC_2) ? $specs_details_row->FILM_HDPE_PERC_2."%" : "");
										
										$FILM_GUAGE_3=(!empty($specs_details_row->FILM_GUAGE_3) ? $specs_details_row->FILM_GUAGE_3."MIC" : "");								
										$FILM_ADMER_3=$specs_details_row->FILM_ADMER_3;
										$FILM_ADMER_PERC_3=(!empty($specs_details_row->FILM_ADMER_PERC_3) ? $specs_details_row->FILM_ADMER_PERC_3."%" : "");


										$FILM_GUAGE_4=(!empty($specs_details_row->FILM_GUAGE_4) ? $specs_details_row->FILM_GUAGE_4."MIC" : "");
										$FILM_EVOH_4=$specs_details_row->FILM_EVOH_4;
										$FILM_EVOH_PERC_4=(!empty($specs_details_row->FILM_EVOH_PERC_4) ? $specs_details_row->FILM_EVOH_PERC_4."%" : "");
										
										$FILM_GUAGE_5=(!empty($specs_details_row->FILM_GUAGE_5) ? $specs_details_row->FILM_GUAGE_5."MIC" : "");
										$FILM_ADMER_5=$specs_details_row->FILM_ADMER_5;
										$FILM_ADMER_PERC_5=(!empty($specs_details_row->FILM_ADMER_PERC_5) ? $specs_details_row->FILM_ADMER_PERC_5."%" : "");
										$FILM_HDPE_5=$specs_details_row->FILM_HDPE_5;
										$FILM_HDPE_PERC_5=(!empty($specs_details_row->FILM_HDPE_PERC_5) ? $specs_details_row->FILM_HDPE_PERC_5."%" : "");

										$FILM_GUAGE_6=(!empty($specs_details_row->FILM_GUAGE_6) ? $specs_details_row->FILM_GUAGE_6."MIC" : "");
										$FILM_MASTER_BATCH_6=$specs_details_row->FILM_MASTER_BATCH_6;
										$FILM_MB_PERC_6=($specs_details_row->FILM_MB_PERC_6!='' ? $specs_details_row->FILM_MB_PERC_6."%" : "");
										$FILM_LLDPE_6=$specs_details_row->FILM_LLDPE_6;
										$FILM_LLDPE_PERC_6=(!empty($specs_details_row->FILM_LLDPE_PERC_6) ? $specs_details_row->FILM_LLDPE_PERC_6."%" : "");
										$FILM_HDPE_6=$specs_details_row->FILM_HDPE_6;
										$FILM_HDPE_PERC_6=(!empty($specs_details_row->FILM_HDPE_PERC_6) ? $specs_details_row->FILM_HDPE_PERC_6."%" : "");
										
										$FILM_GUAGE_7=(!empty($specs_details_row->FILM_GUAGE_7) ? $specs_details_row->FILM_GUAGE_7."MIC" : "");
										$FILM_LDPE_7=$specs_details_row->FILM_LDPE_7;
										$FILM_LDPE_PERC_7=($specs_details_row->FILM_LDPE_PERC_7!='' ? $specs_details_row->FILM_LDPE_PERC_7."%" : "");
										$FILM_LLDPE_7=$specs_details_row->FILM_LLDPE_7;
										$FILM_LLDPE_PERC_7=(!empty($specs_details_row->FILM_LLDPE_PERC_7) ? $specs_details_row->FILM_LLDPE_PERC_7."%" : "");
										$FILM_HDPE_7=$specs_details_row->FILM_HDPE_7;
										$FILM_HDPE_PERC_7=(!empty($specs_details_row->FILM_HDPE_PERC_7) ? $specs_details_row->FILM_HDPE_PERC_7."%" : "");
										

									}
							}

							

								echo "<tr>
									<td>".$i."</td>
									
									<td>".$this->common_model->view_date($row->spec_created_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->spec_id.'/'.$row->spec_version_no)." target='_blank'>".$row->article_no."</a></td>
									"; /*<td>".strtoupper($row->article_name)."</td>*/
									echo "
									<td>".$SLEEVE_DIA."</td>
									<td>".$SLEEVE_LENGTH."</td>
									<td>".substr($row->dyn_qty_present,5,1)."</td>
									<td>".$FILM_GUAGE_1." ".$this->common_model->get_article_name($FILM_LDPE_1,$this->session->userdata['logged_in']['company_id'])." ".$FILM_LDPE_PERC_1." ".$this->common_model->get_article_name($FILM_LLDPE_1,$this->session->userdata['logged_in']['company_id'])." ".$FILM_LLDPE_PERC_1." ".$this->common_model->get_article_name($FILM_HDPE_1,$this->session->userdata['logged_in']['company_id'])." ".$FILM_HDPE_PERC_1."</td>
									<td>".$FILM_GUAGE_2." ".$this->common_model->get_article_name($FILM_MASTER_BATCH_2,$this->session->userdata['logged_in']['company_id'])." ".$FILM_MB_PERC_2." ".$this->common_model->get_article_name($FILM_LLDPE_2,$this->session->userdata['logged_in']['company_id'])." ".$FILM_LLDPE_PERC_2." ".$this->common_model->get_article_name($FILM_HDPE_2,$this->session->userdata['logged_in']['company_id'])." ".$FILM_HDPE_PERC_2."</td>
									<td>".$FILM_GUAGE_3." ".$this->common_model->get_article_name($FILM_ADMER_3,$this->session->userdata['logged_in']['company_id'])." ".$FILM_ADMER_PERC_3."</td>
									<td>".$FILM_GUAGE_4." ".$this->common_model->get_article_name($FILM_EVOH_4,$this->session->userdata['logged_in']['company_id'])." ".$FILM_EVOH_PERC_4."</td>
									<td>".$FILM_GUAGE_5." ".$this->common_model->get_article_name($FILM_ADMER_5,$this->session->userdata['logged_in']['company_id'])." ".$FILM_ADMER_PERC_5." ".$this->common_model->get_article_name($FILM_HDPE_5,$this->session->userdata['logged_in']['company_id'])." ".$FILM_HDPE_PERC_5."</td>
									<td>".$FILM_GUAGE_6." ".$this->common_model->get_article_name($FILM_MASTER_BATCH_6,$this->session->userdata['logged_in']['company_id'])." ".$FILM_MB_PERC_6." ".$this->common_model->get_article_name($FILM_LLDPE_6,$this->session->userdata['logged_in']['company_id'])." ".$FILM_LLDPE_PERC_6." ".$this->common_model->get_article_name($FILM_HDPE_6,$this->session->userdata['logged_in']['company_id'])." ".$FILM_HDPE_PERC_6."</td>

									<td>".$FILM_GUAGE_7." ".$this->common_model->get_article_name($FILM_LDPE_7,$this->session->userdata['logged_in']['company_id'])." ".$FILM_LDPE_PERC_7." ".$this->common_model->get_article_name($FILM_LLDPE_1,$this->session->userdata['logged_in']['company_id'])." ".$FILM_LLDPE_PERC_7." ".$this->common_model->get_article_name($FILM_HDPE_7,$this->session->userdata['logged_in']['company_id'])." ".$FILM_HDPE_PERC_7."</td>

									<td><a class='ui tiny label'><i class='user icon'></i> ".strtoupper($this->common_model->get_user_name($row->user_id,$this->session->userdata['logged_in']['company_id']))."</a></td>

									<td>".$this->common_model->view_date($row->approval_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".($row->approved_by!='' ? "<a class='ui tiny label'><i class='checkmark box icon'></i>":'' )."".strtoupper($this->common_model->get_user_name($row->approved_by,$this->session->userdata['logged_in']['company_id']))."</td>
									<td>";
									foreach($formrights as $formrights_row){ 

										

										echo ($formrights_row->view==1 && substr($row->dyn_qty_present,5,1)==7 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->spec_id.'/'.$row->spec_version_no).'" target="_blank"><i class="print icon"></i></a> ' : '');

										

										echo ($formrights_row->modify==1 && $row->final_approval_flag<>1 && $row->pending_flag<>1  && $row->user_id==$this->session->userdata['logged_in']['user_id'] && substr($row->dyn_qty_present,5,1)==7 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify_seven_layer/'.$row->spec_id.'/'.$row->spec_version_no).'"><i class="edit icon"></i></a> ' : '');
										
										echo ($formrights_row->copy==1 && substr($row->dyn_qty_present,5,1)==7 && $row->final_approval_flag==1  ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/copy_seven_layer/'.$row->spec_id.'/'.$row->spec_version_no).'" target="_blank"><i class="copy icon"></i></a> ' : '');


										echo ($row->archive<>1 && $formrights_row->delete==1 && $row->final_approval_flag<>1 && $row->pending_flag<>1 && $row->user_id==$this->session->userdata['logged_in']['user_id'] ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete_seven_layer/'.$row->spec_id.'/'.$row->spec_version_no).'"><i class="trash icon"></i></a> ' : '');
										
										echo ($row->archive<>1 && $formrights_row->approval==1 && $row->final_approval_flag<>1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/approved_by_factory/'.$row->spec_id.'/'.$row->spec_version_no).'"><i class="thumbs outline up icon"></i></a> ' : '');

										
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