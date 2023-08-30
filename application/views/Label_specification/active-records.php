<div class="record_form_design">
<h4>Active Records</h4>
	<div class="record_inner_design" style="overflow:scroll">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th>Date</th>
					<th>Label No</th>
					<th>Label Material</th>
					<th>Lacquer One</th>
					<th>Lacquer Two</th>
					<th>Non Lacquering Height by Open End</th>
					<th>Non Labeling Height by Shoulder End</th>
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

							$data=array('spec_id'=>$row->spec_id,'spec_version_no'=>$row->spec_version_no);

							
							$data['specs_details']=$this->sales_order_book_model->select_label_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data);
								//echo $this->db->last_query();
								if($data['specs_details']==FALSE){
									$LABEL_NAME="";
									$LABEL_LACQUER_ONE="";
									$LABEL_LACQUER_ONE_PERC="";
									$LABEL_LACQUER_TWO="";
									$LABEL_LACQUER_TWO_PERC="";
									$LABEL_OE="";
									$LABEL_SE="";
								}else{
									foreach($data['specs_details'] as $specs_details_row){
										$LABEL_NAME=$specs_details_row->LABEL_NAME;
										$LABEL_LACQUER_ONE=$specs_details_row->LABEL_LACQUER_ONE;
										$LABEL_LACQUER_ONE_PERC=$specs_details_row->LABEL_LACQUER_ONE_PERC;
										$LABEL_LACQUER_TWO=$specs_details_row->LABEL_LACQUER_TWO;
										$LABEL_LACQUER_TWO_PERC=$specs_details_row->LABEL_LACQUER_TWO_PERC;
										$LABEL_OE=$specs_details_row->OE;
										$LABEL_SE=$specs_details_row->SE;
									}
							}

							$data['lacquer_one_result']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$LABEL_LACQUER_ONE);
								if($data['lacquer_one_result']==FALSE){
									$lacquer_one_name="";
									$lacquer_one_pc="";
								}else{
									foreach($data['lacquer_one_result'] as $lacquer_one_row){
										$lacquer_one_name=$lacquer_one_row->article_name;
										$lacquer_one_pc=$LABEL_LACQUER_ONE_PERC."%";
									}
								}

								$data['lacquer_two_result']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$LABEL_LACQUER_TWO);
								if($data['lacquer_two_result']==FALSE){
									$lacquer_two_name="";
									$lacquer_two_pc="";
								}else{
									foreach($data['lacquer_two_result'] as $lacquer_two_row){
										$lacquer_two_name=$lacquer_two_row->article_name;
										$lacquer_two_pc=$LABEL_LACQUER_TWO_PERC."%";
									}
								}
								

								echo "<tr>
									<td>".$i."</td>
									
									<td>".$this->common_model->view_date($row->spec_created_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/view_label/'.$row->spec_id.'/'.$row->spec_version_no)." target='_blank'>".$row->article_no."</a></td>
									<td>".$this->common_model->get_article_name($LABEL_NAME,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$lacquer_one_name." ".$lacquer_one_pc."</td>
									<td>".$lacquer_two_name." ".$lacquer_two_pc."</td>
									<td>".$LABEL_OE."</td>
									<td>".$LABEL_SE."</td>
									<td><a class='ui tiny label'><i class='user icon'></i> ".strtoupper($this->common_model->get_user_name($row->user_id,$this->session->userdata['logged_in']['company_id']))."</a></td>
									<td>".$this->common_model->view_date($row->approval_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".($row->approved_by!='' ? "<a class='ui tiny label'><i class='checkmark box icon'></i>":'' )."".strtoupper($this->common_model->get_user_name($row->approved_by,$this->session->userdata['logged_in']['company_id']))."</td>
									<td>";
									foreach($formrights as $formrights_row){ 

										echo ($formrights_row->view==1 && substr($row->dyn_qty_present,6,1)==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view_label/'.$row->spec_id.'/'.$row->spec_version_no).'" target="_blank" title="Print Preview"><i class="print icon" ></i></a> ' : '');

										echo ($formrights_row->modify==1 && $row->final_approval_flag<>1 && $row->pending_flag<>1  && $row->user_id==$this->session->userdata['logged_in']['user_id'] && substr($row->dyn_qty_present,6,1)==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify_label/'.$row->spec_id.'/'.$row->spec_version_no).'" title="Modify"><i class="edit icon"></i></a> ' : '');

										echo ($formrights_row->copy==1 && $row->final_approval_flag==1  ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/copy_label/'.$row->spec_id.'/'.$row->spec_version_no).'" target="_blank" title="Copy"><i class="copy icon"></i></a> ' : '');

										echo ($row->archive<>1 && $formrights_row->delete==1 && $row->final_approval_flag<>1 && $row->pending_flag<>1 && $row->user_id==$this->session->userdata['logged_in']['user_id'] ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete_label/'.$row->spec_id.'/'.$row->spec_version_no).'" title="Archive"><i class="trash icon"></i></a> ' : '');

										
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