<div class="record_form_design">
<h4>Active Records</h4>
	<div class="record_inner_design" style="overflow: scroll;">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th>No</th>
					<th>Version</th>
					<th>Layer</th>
					<th>Date</th>
					<th>Customer</th>
					<th>Article No</th>
					<th>Article Name</th>
					<th>Cap</th>
					<th>Finish</th>
					<th>Dia</th>
					<th>Orifice</th>
					<th>Foil</th>
					<th>Shrink Sleeve</th>
					<th>MB</th>
					
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
								$data['specs_details']=$this->sales_order_book_model->select_cap_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data);
								foreach($data['specs_details'] as $specs_details_row){
									$CAP_STYLE=$specs_details_row->CAP_STYLE;
									$CAP_MOLD_FINISH=$specs_details_row->CAP_MOLD_FINISH;
									$CAP_ORIFICE=$specs_details_row->CAP_ORIFICE;
									$CAP_DIA=$specs_details_row->CAP_DIA;
									$CAP_FOIL_COLOR=$specs_details_row->CAP_FOIL_COLOR;
									$CAP_SHRINK_SLEEVE=$specs_details_row->CAP_SHRINK_SLEEVE;
									$CAP_MASTER_BATCH=$specs_details_row->CAP_MASTER_BATCH;
								}

								$data['cap_mb_result']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$CAP_MASTER_BATCH);

								foreach($data['cap_mb_result'] as $cap_mb_row){
									$mb_name=$cap_mb_row->article_name;
								}

								echo "<tr>
									<td>".$i."</td>
									<td><b>".$row->spec_id."</b></td>
									<td><b><a class='ui ".($row->approval_username!='' ? "green"  : "red")." circular label'> $row->spec_version_no </td>
									<td>".substr($row->dyn_qty_present,7,1)." LAYER</td>
									<td>".$this->common_model->view_date($row->spec_created_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".strtoupper($row->customer_name)."</td>
									<td>".$row->article_no."</td>
									<td>".strtoupper($row->article_name)."</td>
									<td>".$CAP_STYLE."</td>
									<td>".$CAP_MOLD_FINISH."</td>
									<td>".$CAP_DIA."</td>
									<td>".$CAP_ORIFICE."</td>
									<td>".$CAP_FOIL_COLOR."</td>
									<td>".$CAP_SHRINK_SLEEVE."</td>
									<td style='backgroud:$mb_name'>".$mb_name."</td>
									<td><a class='ui tiny label'><i class='user icon'></i> ".substr(strtoupper($row->username),0,strpos($row->username,' '))."</a></td>
									<td>".$this->common_model->view_date($row->approval_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".($row->approval_username!='' ? "<a class='ui tiny label'><i class='checkmark box icon'></i>":'' )."".substr(strtoupper($row->approval_username),0,strpos($row->approval_username,' '))."</td>
									<td>";
									foreach($formrights as $formrights_row){ 

										echo ($formrights_row->view==1 && substr($row->dyn_qty_present,4,1)==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view_cap/'.$row->spec_id.'/'.$row->spec_version_no).'" target="_blank"><i class="print icon"></i></a> ' : '');

										echo ($formrights_row->modify==1 && $row->final_approval_flag<>1 && $row->pending_flag<>1  && $row->user_id==$this->session->userdata['logged_in']['user_id'] && substr($row->dyn_qty_present,4,1)==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify_cap/'.$row->spec_id.'/'.$row->spec_version_no).'"><i class="edit icon"></i></a> ' : '');

									
										echo ($formrights_row->copy==1 && $row->final_approval_flag==1  ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/copy_cap/'.$row->spec_id.'/'.$row->spec_version_no).'" target="_blank"><i class="copy icon"></i></a> ' : '');

										echo ($row->archive<>1 && $formrights_row->delete==1 && $row->final_approval_flag<>1 && $row->pending_flag<>1 && $row->user_id==$this->session->userdata['logged_in']['user_id'] ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete_cap/'.$row->spec_id.'/'.$row->spec_version_no).'"><i class="trash icon"></i></a> ' : '');

										
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