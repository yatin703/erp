<div class="record_form_design">
<h4>Active Records</h4>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th>Spec No</th>
					<th>Layer</th>
					<th>Date</th>
					<th>Customer</th>
					<th>Article No</th>
					<th>Article Name</th>
					<th>Artwork</th>
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


								echo "<tr>
									<td>".$i."</td>
									<td><b>".$row->spec_id."_R".$row->spec_version_no."</b></td>
									<td>".substr($row->dyn_qty_present,7,1)."</td>
									<td>".$this->common_model->view_date($row->spec_created_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".strtoupper($row->customer_name)."</td>
									<td>".$row->article_no."</td>
									<td>".strtoupper($row->article_name)."</td>
									<td>".(!empty($row->ad_id) ? $row->ad_id."_R".$row->version_no : "")."</td>
									
									<td><a class='ui tiny label'><i class='user icon'></i> ".substr(strtoupper($row->username),0,strpos($row->username,' '))."</a></td>
									<td>".$this->common_model->view_date($row->approval_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".($row->approval_username!='' ? "<a class='ui tiny label'><i class='checkmark box icon'></i>":'' )."".substr(strtoupper($row->approval_username),0,strpos($row->approval_username,' '))."</td>
									<td>";
									foreach($formrights as $formrights_row){ 

										echo ($row->archive==1 && $formrights_row->dearchive==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/dearchive/'.$row->spec_id.'/'.$row->spec_version_no).'"><i class="recycle icon"></i></a> ' : '');

										
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