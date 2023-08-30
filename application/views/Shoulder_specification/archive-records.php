<div class="record_form_design">
<h4>Active Records</h4>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<!--
					<th>Spec No</th>
					<th>Layer</th>-->
					<th>Date</th>
					<!--<th>Customer</th>-->
					<th>Article No</th>
					<th>Article Name</th>
					<th>Dia</th>
					<th>Type</th>
					<th>Orifice</th>
					<th>MB</th>
					<th>HDPE</th>
					<th>HDPE</th>
					<th>FOIL</th>
					<th>Created By</th>
					<th>Approved Date</th>
					<th>Approved By</th>
					<th>Action</th>
				</tr>
				<?php if($specification==FALSE){
					echo "<tr><td colspan='15'>No Active Records Found</td></tr>";
				}else{
								$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
								
							foreach($specification as $row){
								$data=array('spec_id'=>$row->spec_id,
									'spec_version_no'=>$row->spec_version_no);
								$data['specs_details']=$this->sales_order_book_model->select_shoulder_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data);
								//echo $this->db->last_query();
								foreach($data['specs_details'] as $specs_details_row){
									$SHOULDER_DIA=$specs_details_row->SHOULDER_DIA;
									$SHOULDER_STYLE=$specs_details_row->SHOULDER_STYLE;
									$SHOULDER_ORIFICE=$specs_details_row->SHOULDER_ORIFICE;
									$SHOULDER_MASTER_BATCH=$specs_details_row->SHOULDER_MASTER_BATCH;
									$SHOULDER_MB_SUPPLIER=$specs_details_row->SHOULDER_MB_SUPPLIER;
									$SHOULDER_MB_PERC=$specs_details_row->SHOULDER_MB_PERC;
									$SHOULDER_HDPE_ONE=$specs_details_row->SHOULDER_HDPE_ONE;
									$SHOULDER_HDPE_TWO=$specs_details_row->SHOULDER_HDPE_TWO;
									$SHOULDER_HDPE_ONE_PERC=$specs_details_row->SHOULDER_HDPE_ONE_PERC;
									$SHOULDER_HDPE_TWO_PERC=$specs_details_row->SHOULDER_HDPE_TWO_PERC;
									$SHOULDER_FOIL_TAG=$specs_details_row->SHOULDER_FOIL_TAG;
								}

								$data['shoulder_mb_result']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$SHOULDER_MASTER_BATCH);
								if($data['shoulder_mb_result']==FALSE){
									$shoulder_mb_name="";
								}else{
									foreach($data['shoulder_mb_result'] as $shoulder_mb_row){
										$shoulder_mb_name=$shoulder_mb_row->article_name;
									}
								}
								

								$data['shoulder_hdpe_one_result']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$SHOULDER_HDPE_ONE);
								if($data['shoulder_hdpe_one_result']==FALSE){
									$shoulder_hdpe_one_name="";
								}else{
									foreach($data['shoulder_hdpe_one_result'] as $shoulder_hdpe_one_row){
									$shoulder_hdpe_one_name=$shoulder_hdpe_one_row->article_name;
									}
								}


								$data['shoulder_hdpe_two_result']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$SHOULDER_HDPE_TWO);
								if($data['shoulder_hdpe_two_result']==FALSE){
									$shoulder_hdpe_two_name="";
								}else{
									foreach($data['shoulder_hdpe_two_result'] as $shoulder_hdpe_two_row){
									$shoulder_hdpe_two_name=$shoulder_hdpe_two_row->article_name;
									}
								}

								$data['shoulder_foil_tag_result']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$SHOULDER_FOIL_TAG);
								if($data['shoulder_foil_tag_result']==FALSE){
									$shoulder_foil_tag_name="";
								}else{
									foreach($data['shoulder_foil_tag_result'] as $shoulder_foil_tag_row){
									$shoulder_foil_tag_name=$shoulder_foil_tag_row->article_name;
									}
								}

								echo "<tr>
									<td>".$i."</td>";
									//echo "<td><b>".$row->spec_id."_R".$row->spec_version_no."</b></td>
									//<td>".substr($row->dyn_qty_present,7,1)."</td>
									echo "<td>".$this->common_model->view_date($row->spec_created_date,$this->session->userdata['logged_in']['company_id'])."</td>";
									//echo "<td>".strtoupper($row->customer_name)."</td>
									echo "<td>".$row->article_no."</td>
									<td>".strtoupper($row->article_name)."</td>
									<td>".$SHOULDER_DIA."</td>
									<td>".$SHOULDER_STYLE."</td>
									<td>".$SHOULDER_ORIFICE."</td>
									<td>".$shoulder_mb_name." ".$SHOULDER_MB_PERC."</td>
									<td>".$shoulder_hdpe_one_name." ".$SHOULDER_HDPE_ONE_PERC."</td>
									<td>".$shoulder_hdpe_two_name." ".$SHOULDER_HDPE_TWO_PERC."</td>
									<td>".$shoulder_foil_tag_name."</td>
									<td><a class='ui tiny label'><i class='user icon'></i> ".substr(strtoupper($row->username),0,strpos($row->username,' '))."</a></td>
									<td>".$this->common_model->view_date($row->approval_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".($row->approval_username!='' ? "<a class='ui tiny label'><i class='checkmark box icon'></i>":'' )."".substr(strtoupper($row->approval_username),0,strpos($row->approval_username,' '))."</td>
									<td>";
									foreach($formrights as $formrights_row){ 

										echo ($row->archive==1 && $formrights_row->dearchive==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/dearchive_shoulder/'.$row->spec_id.'/'.$row->spec_version_no).'"><i class="recycle icon"></i></a> ' : '');

										
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