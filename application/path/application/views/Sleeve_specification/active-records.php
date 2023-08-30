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

							
							$data['specs_details']=$this->sales_order_book_model->select_sleeve_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data);
								if($data['specs_details']==FALSE){
									$SLEEVE_DIA="";
									$SLEEVE_LENGTH="";
									$SLEEVE_MASTER_BATCH="";
									$SLEEVE_MB_PERC="";
									$SLEEVE_GUAGE="";
									$SLEEVE_LDPE="";
									$SLEEVE_LDPE_PERC="";
									$SLEEVE_LLDPE="";
									$SLEEVE_LLDPE_PERC="";
									$SLEEVE_HDPE="";
									$SLEEVE_HDPE_PERC="";


									$SLEEVE_MASTER_BATCH_2="";
									$SLEEVE_MB_PERC_2="";
									$SLEEVE_GUAGE_2="";
									$SLEEVE_LDPE_2="";
									$SLEEVE_LDPE_PERC_2="";
									$SLEEVE_LLDPE_2="";
									$SLEEVE_LLDPE_PERC_2="";
									$SLEEVE_HDPE_2="";
									$SLEEVE_HDPE_PERC_2="";

									$SLEEVE_ADMER_2="";
									$SLEEVE_ADMER_PERC_2="";

									$SLEEVE_GUAGE_3="";
									$SLEEVE_EVOH="";
									$SLEEVE_EVOH_PERC="";
									$SLEEVE_MASTER_BATCH_3="";
									$SLEEVE_MB_PERC_3="";
									$SLEEVE_LDPE_3="";
									$SLEEVE_LDPE_PERC_3="";
									$SLEEVE_LLDPE_3="";
									$SLEEVE_LLDPE_PERC_3="";
									$SLEEVE_HDPE_3="";
									$SLEEVE_HDPE_PERC_3="";


									$SLEEVE_GUAGE_4="";
									$SLEEVE_ADMER_4="";
									$SLEEVE_ADMER_PERC_4="";


									$SLEEVE_GUAGE_5="";
									$SLEEVE_MASTER_BATCH_5="";
									$SLEEVE_MB_PERC_5="";
									$SLEEVE_LDPE_5="";
									$SLEEVE_LDPE_PERC_5="";
									$SLEEVE_LLDPE_5="";
									$SLEEVE_LLDPE_PERC_5="";
									$SLEEVE_HDPE_5="";
									$SLEEVE_HDPE_PERC_5="";

								}else{
									foreach($data['specs_details'] as $specs_details_row){
										$SLEEVE_DIA=$specs_details_row->SLEEVE_DIA;
										$SLEEVE_LENGTH=$specs_details_row->SLEEVE_LENGTH;
										$SLEEVE_GUAGE=(!empty($specs_details_row->SLEEVE_GUAGE) ? $specs_details_row->SLEEVE_GUAGE."MIC" : "");
										$SLEEVE_MASTER_BATCH=$specs_details_row->SLEEVE_MASTER_BATCH;
										$SLEEVE_MB_PERC=($specs_details_row->SLEEVE_MB_PERC!='' ? $specs_details_row->SLEEVE_MB_PERC."%" : "");
										$SLEEVE_LDPE=$specs_details_row->SLEEVE_LDPE;
										$SLEEVE_LDPE_PERC=(!empty($specs_details_row->SLEEVE_LDPE_PERC) ? $specs_details_row->SLEEVE_LDPE_PERC."%" : "");
										$SLEEVE_LLDPE=$specs_details_row->SLEEVE_LLDPE;
										$SLEEVE_LLDPE_PERC=(!empty($specs_details_row->SLEEVE_LLDPE_PERC) ? $specs_details_row->SLEEVE_LLDPE_PERC."%" : "");
										$SLEEVE_HDPE=$specs_details_row->SLEEVE_HDPE;
										$SLEEVE_HDPE_PERC=(!empty($specs_details_row->SLEEVE_HDPE_PERC) ? $specs_details_row->SLEEVE_HDPE_PERC."%" : "");;

										$SLEEVE_GUAGE_2=(!empty($specs_details_row->SLEEVE_GUAGE_2) ? $specs_details_row->SLEEVE_GUAGE_2."MIC" : "");
										$SLEEVE_MASTER_BATCH_2=$specs_details_row->SLEEVE_MASTER_BATCH_2;
										$SLEEVE_MB_PERC_2=($specs_details_row->SLEEVE_MB_PERC_2!='' ? $specs_details_row->SLEEVE_MB_PERC_2."%" : "");
										$SLEEVE_LDPE_2=$specs_details_row->SLEEVE_LDPE_2;
										$SLEEVE_LDPE_PERC_2=(!empty($specs_details_row->SLEEVE_LDPE_PERC_2) ? $specs_details_row->SLEEVE_LDPE_PERC_2."%" : "");
										$SLEEVE_LLDPE_2=$specs_details_row->SLEEVE_LLDPE_2;
										$SLEEVE_LLDPE_PERC_2=(!empty($specs_details_row->SLEEVE_LLDPE_PERC_2) ? $specs_details_row->SLEEVE_LLDPE_PERC_2."%" : "");
										$SLEEVE_HDPE_2=$specs_details_row->SLEEVE_HDPE_2;
										$SLEEVE_HDPE_PERC_2=(!empty($specs_details_row->SLEEVE_HDPE_PERC_2) ? $specs_details_row->SLEEVE_HDPE_PERC_2."%" : "");
									
										$SLEEVE_ADMER_2=$specs_details_row->SLEEVE_ADMER_2;
										$SLEEVE_ADMER_PERC_2=(!empty($specs_details_row->SLEEVE_ADMER_PERC_2) ? $specs_details_row->SLEEVE_ADMER_PERC_2."%" : "");


										$SLEEVE_GUAGE_3=(!empty($specs_details_row->SLEEVE_GUAGE_3) ? $specs_details_row->SLEEVE_GUAGE_3."MIC" : "");
										$SLEEVE_EVOH=$specs_details_row->SLEEVE_EVOH;
										$SLEEVE_EVOH_PERC=(!empty($specs_details_row->SLEEVE_EVOH_PERC) ? $specs_details_row->SLEEVE_EVOH_PERC."%" : "");
										$SLEEVE_MASTER_BATCH_3=$specs_details_row->SLEEVE_MASTER_BATCH_3;
										$SLEEVE_MB_PERC_3=($specs_details_row->SLEEVE_MB_PERC_3!='' ? $specs_details_row->SLEEVE_MB_PERC_3."%" : "");
										$SLEEVE_LDPE_3=$specs_details_row->SLEEVE_LDPE_3;
										$SLEEVE_LDPE_PERC_3=(!empty($specs_details_row->SLEEVE_LDPE_PERC_3) ? $specs_details_row->SLEEVE_LDPE_PERC_3."%" : "");
										$SLEEVE_LLDPE_3=$specs_details_row->SLEEVE_LLDPE_3;
										$SLEEVE_LLDPE_PERC_3=(!empty($specs_details_row->SLEEVE_LLDPE_PERC_3) ? $specs_details_row->SLEEVE_LLDPE_PERC_3."%" : "");
										$SLEEVE_HDPE_3=$specs_details_row->SLEEVE_HDPE_3;
										$SLEEVE_HDPE_PERC_3=(!empty($specs_details_row->SLEEVE_HDPE_PERC_3) ? $specs_details_row->SLEEVE_HDPE_PERC_3."%" : "");


										$SLEEVE_GUAGE_4=(!empty($specs_details_row->SLEEVE_GUAGE_4) ? $specs_details_row->SLEEVE_GUAGE_4."MIC" : "");
										$SLEEVE_ADMER_4=$specs_details_row->SLEEVE_ADMER_4;
										$SLEEVE_ADMER_PERC_4=(!empty($specs_details_row->SLEEVE_ADMER_PERC_4) ? $specs_details_row->SLEEVE_ADMER_PERC_4."%" : "");
										

										$SLEEVE_GUAGE_5=(!empty($specs_details_row->SLEEVE_GUAGE_5) ? $specs_details_row->SLEEVE_GUAGE_5."MIC" : "");
										$SLEEVE_MASTER_BATCH_5=$specs_details_row->SLEEVE_MASTER_BATCH_5;
										$SLEEVE_MB_PERC_5=($specs_details_row->SLEEVE_MB_PERC_5!='' ? $specs_details_row->SLEEVE_MB_PERC_5."%" : "");
										$SLEEVE_LDPE_5=$specs_details_row->SLEEVE_LDPE_5;
										$SLEEVE_LDPE_PERC_5=(!empty($specs_details_row->SLEEVE_LDPE_PERC_5) ? $specs_details_row->SLEEVE_LDPE_PERC_5."%" : "");
										$SLEEVE_LLDPE_5=$specs_details_row->SLEEVE_LLDPE_5;
										$SLEEVE_LLDPE_PERC_5=(!empty($specs_details_row->SLEEVE_LLDPE_PERC_5) ? $specs_details_row->SLEEVE_LLDPE_PERC_5."%" : "");
										$SLEEVE_HDPE_5=$specs_details_row->SLEEVE_HDPE_5;
										$SLEEVE_HDPE_PERC_5=(!empty($specs_details_row->SLEEVE_HDPE_PERC_5) ? $specs_details_row->SLEEVE_HDPE_PERC_5."%" : "");;

									}
							}

							$data['sleeve_mb_result']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$SLEEVE_MASTER_BATCH);
								if($data['sleeve_mb_result']==FALSE){
									$sleeve_mb_name="";
								}else{
									foreach($data['sleeve_mb_result'] as $sleeve_mb_row){
										$sleeve_mb_name=$sleeve_mb_row->article_name;
									}
								}

							$data['sleeve_ldpe_result']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$SLEEVE_LDPE);
								if($data['sleeve_ldpe_result']==FALSE){
									$sleeve_ldpe_name="";
								}else{
									foreach($data['sleeve_ldpe_result'] as $sleeve_ldpe_row){
										$sleeve_ldpe_name=$sleeve_ldpe_row->article_name;
									}
								}

							$data['sleeve_lldpe_result']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$SLEEVE_LLDPE);
								if($data['sleeve_lldpe_result']==FALSE){
									$sleeve_lldpe_name="";
								}else{
									foreach($data['sleeve_lldpe_result'] as $sleeve_lldpe_row){
										$sleeve_lldpe_name=$sleeve_lldpe_row->article_name;
									}
								}

							$data['sleeve_hdpe_result']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$SLEEVE_HDPE);
								if($data['sleeve_hdpe_result']==FALSE){
									$sleeve_hdpe_name="";
								}else{
									foreach($data['sleeve_hdpe_result'] as $sleeve_hdpe_row){
										$sleeve_hdpe_name=$sleeve_hdpe_row->article_name;
									}
								}

							$data['sleeve_mb_result']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$SLEEVE_MASTER_BATCH_2);
								if($data['sleeve_mb_result']==FALSE){
									$sleeve_mb_name_2="";
								}else{
									foreach($data['sleeve_mb_result'] as $sleeve_mb_row){
										$sleeve_mb_name_2=$sleeve_mb_row->article_name;
									}
								}

							$data['sleeve_ldpe_result']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$SLEEVE_LDPE_2);
								if($data['sleeve_ldpe_result']==FALSE){
									$sleeve_ldpe_name_2="";
								}else{
									foreach($data['sleeve_ldpe_result'] as $sleeve_ldpe_row){
										$sleeve_ldpe_name_2=$sleeve_ldpe_row->article_name;
									}
								}

							$data['sleeve_lldpe_result']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$SLEEVE_LLDPE_2);
								if($data['sleeve_lldpe_result']==FALSE){
									$sleeve_lldpe_name_2="";
								}else{
									foreach($data['sleeve_lldpe_result'] as $sleeve_lldpe_row){
										$sleeve_lldpe_name_2=$sleeve_lldpe_row->article_name;
									}
								}

							$data['sleeve_hdpe_result']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$SLEEVE_HDPE_2);
								if($data['sleeve_hdpe_result']==FALSE){
									$sleeve_hdpe_name_2="";
								}else{
									foreach($data['sleeve_hdpe_result'] as $sleeve_hdpe_row){
										$sleeve_hdpe_name_2=$sleeve_hdpe_row->article_name;
									}
								}


								$data['sleeve_admer_result']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$SLEEVE_ADMER_2);
								$SLEEVE_ADMER_2;
								if($data['sleeve_admer_result']==FALSE){
									$sleeve_admer_2="";
								}else{
									foreach($data['sleeve_admer_result'] as $sleeve_admer_row){
										$sleeve_admer_2=$sleeve_admer_row->article_name;
									}
								}


								$data['sleeve_evoh_result']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$SLEEVE_EVOH);
								
								if($data['sleeve_evoh_result']==FALSE){
									$sleeve_evoh_name="";
								}else{
									foreach($data['sleeve_evoh_result'] as $sleeve_evoh_row){
										$sleeve_evoh_name=$sleeve_evoh_row->article_name;
									}
								}


								$data['sleeve_mb_result']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$SLEEVE_MASTER_BATCH_3);
								if($data['sleeve_mb_result']==FALSE){
									$sleeve_mb_name_3="";
								}else{
									foreach($data['sleeve_mb_result'] as $sleeve_mb_row){
										$sleeve_mb_name_3=$sleeve_mb_row->article_name;
									}
								}

							$data['sleeve_ldpe_result']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$SLEEVE_LDPE_3);
								if($data['sleeve_ldpe_result']==FALSE){
									$sleeve_ldpe_name_3="";
								}else{
									foreach($data['sleeve_ldpe_result'] as $sleeve_ldpe_row){
										$sleeve_ldpe_name_3=$sleeve_ldpe_row->article_name;
									}
								}

							$data['sleeve_lldpe_result']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$SLEEVE_LLDPE_3);
								if($data['sleeve_lldpe_result']==FALSE){
									$sleeve_lldpe_name_3="";
								}else{
									foreach($data['sleeve_lldpe_result'] as $sleeve_lldpe_row){
										$sleeve_lldpe_name_3=$sleeve_lldpe_row->article_name;
									}
								}

							$data['sleeve_hdpe_result']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$SLEEVE_HDPE_3);
								if($data['sleeve_hdpe_result']==FALSE){
									$sleeve_hdpe_name_3="";
								}else{
									foreach($data['sleeve_hdpe_result'] as $sleeve_hdpe_row){
										$sleeve_hdpe_name_3=$sleeve_hdpe_row->article_name;
									}
								}

								$data['sleeve_admer_result']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$SLEEVE_ADMER_4);
								$SLEEVE_ADMER_2;
								if($data['sleeve_admer_result']==FALSE){
									$sleeve_admer_4="";
								}else{
									foreach($data['sleeve_admer_result'] as $sleeve_admer_row){
										$sleeve_admer_4=$sleeve_admer_row->article_name;
									}
								}


								$data['sleeve_mb_result']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$SLEEVE_MASTER_BATCH_5);
								if($data['sleeve_mb_result']==FALSE){
									$sleeve_mb_name_5="";
								}else{
									foreach($data['sleeve_mb_result'] as $sleeve_mb_row){
										$sleeve_mb_name_5=$sleeve_mb_row->article_name;
									}
								}

							$data['sleeve_ldpe_result']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$SLEEVE_LDPE_5);
								if($data['sleeve_ldpe_result']==FALSE){
									$sleeve_ldpe_name_5="";
								}else{
									foreach($data['sleeve_ldpe_result'] as $sleeve_ldpe_row){
										$sleeve_ldpe_name_5=$sleeve_ldpe_row->article_name;
									}
								}

							$data['sleeve_lldpe_result']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$SLEEVE_LLDPE_5);
								if($data['sleeve_lldpe_result']==FALSE){
									$sleeve_lldpe_name_5="";
								}else{
									foreach($data['sleeve_lldpe_result'] as $sleeve_lldpe_row){
										$sleeve_lldpe_name_5=$sleeve_lldpe_row->article_name;
									}
								}

							$data['sleeve_hdpe_result']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$SLEEVE_HDPE_5);
								if($data['sleeve_hdpe_result']==FALSE){
									$sleeve_hdpe_name_5="";
								}else{
									foreach($data['sleeve_hdpe_result'] as $sleeve_hdpe_row){
										$sleeve_hdpe_name_5=$sleeve_hdpe_row->article_name;
									}
								}

								echo "<tr>
									<td>".$i."</td>
									
									<td>".$this->common_model->view_date($row->spec_created_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->spec_id.'/'.$row->spec_version_no)." target='_blank'>".$row->article_no."</a></td>
									"; /*<td>".strtoupper($row->article_name)."</td>*/
									echo "
									<td>".$SLEEVE_DIA."</td>
									<td>".$SLEEVE_LENGTH." MM</td>
									<td>".substr($row->dyn_qty_present,7,1)."</td>
									<td>".$SLEEVE_GUAGE." ".$sleeve_mb_name." ".$SLEEVE_MB_PERC." ".$sleeve_ldpe_name." ".$SLEEVE_LDPE_PERC." ".$sleeve_lldpe_name." ".$SLEEVE_LLDPE_PERC." ".$sleeve_hdpe_name." ".$SLEEVE_HDPE_PERC."</td>
									<td>".$SLEEVE_GUAGE_2." ".$sleeve_admer_2." ".$SLEEVE_ADMER_PERC_2." ".$sleeve_mb_name_2." ".$SLEEVE_MB_PERC_2." ".$sleeve_ldpe_name_2." ".$SLEEVE_LDPE_PERC_2." ".$sleeve_lldpe_name_2." ".$SLEEVE_LLDPE_PERC_2." ".$sleeve_hdpe_name_2." ".$SLEEVE_HDPE_PERC_2."</td>
									<td>".$SLEEVE_GUAGE_3." ".$sleeve_evoh_name." ".$SLEEVE_EVOH_PERC." ".$sleeve_mb_name_3." ".$SLEEVE_MB_PERC_3." ".$sleeve_ldpe_name_3." ".$SLEEVE_LDPE_PERC_3." ".$sleeve_lldpe_name_3." ".$SLEEVE_LLDPE_PERC_3." ".$sleeve_hdpe_name_3." ".$SLEEVE_HDPE_PERC_3."</td>
									<td>".$SLEEVE_GUAGE_4." ".$sleeve_admer_4." ".$SLEEVE_ADMER_PERC_4."</td>
									<td>".$SLEEVE_GUAGE_5." ".$sleeve_mb_name_5." ".$SLEEVE_MB_PERC_5." ".$sleeve_ldpe_name_5." ".$SLEEVE_LDPE_PERC_5." ".$sleeve_lldpe_name_5." ".$SLEEVE_LLDPE_PERC_5." ".$sleeve_hdpe_name_5." ".$SLEEVE_HDPE_PERC_5." ".$sleeve_hdpe_name_5." ".$SLEEVE_HDPE_PERC_5."</td>
									<td><a class='ui tiny label'><i class='user icon'></i> ".strtoupper($this->common_model->get_user_name($row->user_id,$this->session->userdata['logged_in']['company_id']))."</a></td>
									<td>".$this->common_model->view_date($row->approval_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".($row->approved_by!='' ? "<a class='ui tiny label'><i class='checkmark box icon'></i>":'' )."".strtoupper($this->common_model->get_user_name($row->approved_by,$this->session->userdata['logged_in']['company_id']))."</td>
									<td>";
									foreach($formrights as $formrights_row){ 

										echo ($formrights_row->view==1 && substr($row->dyn_qty_present,7,1)==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->spec_id.'/'.$row->spec_version_no).'" target="_blank"><i class="print icon"></i></a> ' : '');

										echo ($formrights_row->view==1 && substr($row->dyn_qty_present,7,1)==2 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->spec_id.'/'.$row->spec_version_no).'" target="_blank"><i class="print icon"></i></a> ' : '');

										echo ($formrights_row->view==1 && substr($row->dyn_qty_present,7,1)==3 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->spec_id.'/'.$row->spec_version_no).'" target="_blank"><i class="print icon"></i></a> ' : '');

										echo ($formrights_row->view==1 && substr($row->dyn_qty_present,7,1)==5 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->spec_id.'/'.$row->spec_version_no).'" target="_blank"><i class="print icon"></i></a> ' : '');

										echo ($formrights_row->modify==1 && $row->final_approval_flag<>1 && $row->pending_flag<>1  && $row->user_id==$this->session->userdata['logged_in']['user_id'] && substr($row->dyn_qty_present,7,1)==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify_single_layer/'.$row->spec_id.'/'.$row->spec_version_no).'"><i class="edit icon"></i></a> ' : '');

										echo ($formrights_row->modify==1 && $row->final_approval_flag<>1 && $row->pending_flag<>1  && $row->user_id==$this->session->userdata['logged_in']['user_id'] && substr($row->dyn_qty_present,7,1)==2 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify_two_layer/'.$row->spec_id.'/'.$row->spec_version_no).'"><i class="edit icon"></i></a> ' : '');

										echo ($formrights_row->modify==1 && $row->final_approval_flag<>1 && $row->pending_flag<>1  && $row->user_id==$this->session->userdata['logged_in']['user_id'] && substr($row->dyn_qty_present,7,1)==3 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify_three_layer/'.$row->spec_id.'/'.$row->spec_version_no).'"><i class="edit icon"></i></a> ' : '');

										echo ($formrights_row->modify==1 && $row->final_approval_flag<>1 && $row->pending_flag<>1  && $row->user_id==$this->session->userdata['logged_in']['user_id'] && substr($row->dyn_qty_present,7,1)==5 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify_five_layer/'.$row->spec_id.'/'.$row->spec_version_no).'"><i class="edit icon"></i></a> ' : '');
										
										echo ($formrights_row->copy==1 && substr($row->dyn_qty_present,7,1)==1 && $row->final_approval_flag==1  ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/copy_single_layer/'.$row->spec_id.'/'.$row->spec_version_no).'" target="_blank"><i class="copy icon"></i></a> ' : '');

										echo ($formrights_row->copy==1 && substr($row->dyn_qty_present,7,1)==2 && $row->final_approval_flag==1  ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/copy_two_layer/'.$row->spec_id.'/'.$row->spec_version_no).'" target="_blank"><i class="copy icon"></i></a> ' : '');

										echo ($formrights_row->copy==1 && substr($row->dyn_qty_present,7,1)==3 && $row->final_approval_flag==1  ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/copy_three_layer/'.$row->spec_id.'/'.$row->spec_version_no).'" target="_blank"><i class="copy icon"></i></a> ' : '');

										echo ($formrights_row->copy==1 && substr($row->dyn_qty_present,7,1)==5 && $row->final_approval_flag==1  ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/copy_five_layer/'.$row->spec_id.'/'.$row->spec_version_no).'" target="_blank"><i class="copy icon"></i></a> ' : '');

										echo ($row->archive<>1 && $formrights_row->delete==1 && $row->final_approval_flag<>1 && $row->pending_flag<>1 && $row->user_id==$this->session->userdata['logged_in']['user_id'] ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete_single_layer/'.$row->spec_id.'/'.$row->spec_version_no).'"><i class="trash icon"></i></a> ' : '');

										
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