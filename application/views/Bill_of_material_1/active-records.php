<div class="record_form_design">
<h3>Active Records</h3>
	<div class="record_inner_design" style="overflow:scroll;">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th>Date</th>
					<th>Product Code</th>
					<th>Product Desc</th>
					<th>Sleeve Code</th>
					<th>Shoulder Code</th>
					<th>Cap Code</th>
					<th>Label Code</th>
					<!--<th>Sleeve Desc</th>-->
					<th>Sleeve Dia</th>
					<th>Sleeve Length</th>
					<th>Sleeve MB</th>					
					<!--<th>Shoulder Desc</th>-->
					<th>Shoulder Dia</th>
					<th>Shoulder Type</th>
					<th>Shoulder Orifice</th>
					<th>Shoulder MB</th>
					<th>Shoulder HDPE</th>
					<th>Shoulder HDPE</th>
					<th>Shoulder Foil</th>					
					<!--<th>Cap Desc</th>-->
					<th>Cap Dia</th>
					<th>Cap Type</th>
					<th>Cap Finish</th>
					<th>Cap Orifice</th>
					<th>Cap MB</th>
					<th>Cap PP</th>
					<th>Cap Foil Color</th>
					<th>Cap Shrink Sleeve</th>
					<th>Cap Metalization</th>
					<!--<th>Label Desc</th>-->
					<th>Created By</th>
					<th>Approved Date</th>
					<th>Approved By</th>
					<th>Action</th>
				</tr>
				<?php if($bill_of_material==FALSE){
					echo "<tr><td colspan='16'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
								
							foreach($bill_of_material as $row){
								//Sleeve-----
								$sleeve_spec_sheet=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$row->sleeve_code);
								foreach ($sleeve_spec_sheet as $sleeve_spec_sheet_row) {
									
									$sleeve_spec_id=$sleeve_spec_sheet_row->spec_id;
									$sleeve_spec_version_no=$sleeve_spec_sheet_row->spec_version_no;

									$data=array('spec_id'=>$sleeve_spec_id,
												'spec_version_no'=>$sleeve_spec_version_no);

									$data['sleeve_specs_details']=$this->sales_order_book_model->select_sleeve_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data);

									foreach ($data['sleeve_specs_details'] as $sleeve_specs_details_row) {
										$sleeve_dia=$sleeve_specs_details_row->SLEEVE_DIA;
										$sleeve_length=$sleeve_specs_details_row->SLEEVE_LENGTH;
										$sleeve_master_batch=$sleeve_specs_details_row->SLEEVE_MASTER_BATCH;
										$sleeve_mb_perc=$sleeve_specs_details_row->SLEEVE_MB_PERC;


									}
								}
								//Shoulder------------
								$shoulder_spec_sheet=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$row->shoulder_code);
								foreach ($shoulder_spec_sheet as $shoulder_spec_sheet_row) {
									
									$shoulder_spec_id=$shoulder_spec_sheet_row->spec_id;
									$shoulder_spec_version_no=$shoulder_spec_sheet_row->spec_version_no;

									$data=array('spec_id'=>$shoulder_spec_id,
												'spec_version_no'=>$shoulder_spec_version_no);
									$data['shoulder_specs_details']=$this->sales_order_book_model->select_shoulder_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data);

									foreach ($data['shoulder_specs_details'] as $shoulder_specs_details_row) {
										$shoulder_dia=$shoulder_specs_details_row->SHOULDER_DIA;
										$shoulder_type=$shoulder_specs_details_row->SHOULDER_STYLE;
										$shoulder_orifice=$shoulder_specs_details_row->SHOULDER_ORIFICE;
										$shoulder_master_batch=$shoulder_specs_details_row->SHOULDER_MASTER_BATCH;
										$shoulder_mb_perc=$shoulder_specs_details_row->SHOULDER_MB_PERC;
										$shoulder_hdpe_one=$shoulder_specs_details_row->SHOULDER_HDPE_ONE;
										$shoulder_hdpe_one_perc=$shoulder_specs_details_row->SHOULDER_HDPE_ONE_PERC;
										$shoulder_hdpe_two=$shoulder_specs_details_row->SHOULDER_HDPE_TWO;
										$shoulder_hdpe_two_perc=$shoulder_specs_details_row->SHOULDER_HDPE_TWO_PERC;
										$shoulder_foil_tag=$shoulder_specs_details_row->SHOULDER_FOIL_TAG;

									}
								}
								//Cap-----
								$cap_spec_sheet=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$row->cap_code);
								foreach ($cap_spec_sheet as $cap_spec_sheet_row) {

									$cap_spec_id=$cap_spec_sheet_row->spec_id;
									$cap_spec_version_no=$cap_spec_sheet_row->spec_version_no;

									$data=array('spec_id'=>$cap_spec_id,
												'spec_version_no'=>$cap_spec_version_no);

									$data['cap_specs_details']=$this->sales_order_book_model->select_cap_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data);

									foreach ($data['cap_specs_details'] as $cap_specs_details_row) {
										$cap_dia=$cap_specs_details_row->CAP_DIA;
										$cap_type=$cap_specs_details_row->CAP_STYLE;
										$cap_finish=$cap_specs_details_row->CAP_MOLD_FINISH;
										$cap_orifice=$cap_specs_details_row->CAP_ORIFICE;
										$cap_master_batch=$cap_specs_details_row->CAP_MASTER_BATCH;
										$cap_mb_perc=$cap_specs_details_row->CAP_MB_PERC;
										$cap_foil_color=$cap_specs_details_row->CAP_FOIL_COLOR;
										$cap_pp=$cap_specs_details_row->CAP_PP;
										$cap_pp_perc=$cap_specs_details_row->CAP_PP_PERC;
										$cap_metalization=$cap_specs_details_row->CAP_METALIZATION;
										$cap_shrink_sleeve=$cap_specs_details_row->CAP_SHRINK_SLEEVE;

									}
								}

								
								echo "<tr>
									<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->bom_id.'')." target='_blank'>".$row->bom_no."</a></td>
									<td>".$this->common_model->view_date($row->bom_creation_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$row->article_no."</td>
									<td>".$this->common_model->get_article_name($row->article_no,$this->session->userdata['logged_in']['company_id'])."</td>
									<td><a href='".base_url('index.php/Sleeve_specification/view/').$sleeve_spec_id."/".$sleeve_spec_version_no."'  target='_blank'>".$row->sleeve_code."</a></td>
									<td><a href='".base_url('index.php/Shoulder_specification/view_shoulder/').$shoulder_spec_id."/".$shoulder_spec_version_no."'  target='_blank'>".$row->shoulder_code."</a></td>
									<td><a href='".base_url('index.php/cap_specification/view_cap/').$cap_spec_id."/".$cap_spec_version_no."'  target='_blank'>".$row->cap_code."</a></td>
									<td>".$row->label_code."</td>
									<td>".$sleeve_dia."</td>
									<td>".$sleeve_length."</td>
									<td>".$this->common_model->get_article_name($sleeve_master_batch,$this->session->userdata['logged_in']['company_id'])." ".$sleeve_mb_perc."%</td>
									<td>".$shoulder_dia."</td>
									<td>".$shoulder_type."</td>
									<td>".$shoulder_orifice."</td>
									<td>".$this->common_model->get_article_name($shoulder_master_batch,$this->session->userdata['logged_in']['company_id'])." ".$shoulder_mb_perc."</td>
									<td>".$this->common_model->get_article_name($shoulder_hdpe_one,$this->session->userdata['logged_in']['company_id'])." ".$shoulder_hdpe_one_perc."</td>
									<td>".$this->common_model->get_article_name($shoulder_hdpe_two,$this->session->userdata['logged_in']['company_id'])." ".$shoulder_hdpe_two_perc."</td>
									<td>".$this->common_model->get_article_name($shoulder_foil_tag,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$cap_dia."</td>
									<td>".$cap_type."</td>
									<td>".$cap_finish."</td>
									<td>".$cap_orifice."</td>
									<td>".$this->common_model->get_article_name($cap_master_batch,$this->session->userdata['logged_in']['company_id'])." ".$cap_mb_perc."</td>
									<td>".$this->common_model->get_article_name($cap_pp,$this->session->userdata['logged_in']['company_id'])." ".$cap_pp_perc."</td>
									<td>".$cap_foil_color."</td>
									<td>".$cap_shrink_sleeve."</td>
									<td>".$cap_metalization."</td>
									
									<td><a class='ui tiny label'><i class='user icon'></i> ".$this->common_model->get_user_name($row->user_id,$this->session->userdata['logged_in']['company_id'])."</a></td>
									<td>".$this->common_model->view_date($row->approval_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".($row->approved_by!='' ? "<a class='ui tiny label'><i class='checkmark box icon'></i>":'' )."".$this->common_model->get_user_name($row->approved_by,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>";
									foreach($formrights as $formrights_row){ 
										
										echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->bom_id).'" target="_blank"><i class="print icon"></i></a> ' : '');

										echo ($formrights_row->modify==1 && $row->final_approval_flag<>1 && $row->pending_flag<>1 && $row->user_id==$this->session->userdata['logged_in']['user_id'] ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->bom_id).'"><i class="edit icon"></i></a> ' : '');

										echo ($row->archive<>1 && $formrights_row->delete==1 && $row->final_approval_flag<>1 && $row->user_id==$this->session->userdata['logged_in']['user_id'] ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->bom_id).'" ><i class="trash icon"></i></a> ' : '');
										
									}
									echo "</td>
								</tr>";
							}
						}?>
								
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>