<div class="record_form_design">
	<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
<h4>Active Records</h4>
	<div class="record_inner_design" style="overflow: scroll;">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th>Date</th>
					<th>Paper Film No</th>
					<th>Dia</th>
					<!-- <th>Layer No</th> -->
					<th>Paper Film Name (Sales)</th>
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
								$data['specs_details']=$this->paper_film_specification_model->select_shoulder_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data);
								foreach($data['specs_details'] as $specs_details_row){
									$PE_PAPER_DIA=$specs_details_row->PE_PAPER_DIA;
									$PE_PAPER_WIDTH=$specs_details_row->PE_PAPER_WIDTH;
									$PE_PAPER_GUAGE=$specs_details_row->PE_PAPER_GUAGE;
									$PE_PAPER_LAYER_NO=$specs_details_row->PE_PAPER_LAYER_NO;
									$PE_PAPER_NAME_SALES=$specs_details_row->PE_PAPER_SALES;
									$LAYER_NO=$specs_details_row->PE_PAPER_LAYER_NO;

								}
								

								

								echo "<tr>
									<td>".$i."</td>";
								echo "<td>".$this->common_model->view_date($row->spec_created_date,$this->session->userdata['logged_in']['company_id'])."</td>";
								echo "<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/view_paper_film/'.$row->spec_id.'/'.$row->spec_version_no)." target='_blank'>".$row->article_no."</a></td>";
									echo "
									<td>".$PE_PAPER_DIA."</td>
									<td>".$PE_PAPER_NAME_SALES."</td>
									<td><a class='ui tiny label'><i class='user icon'></i> ".strtoupper($this->common_model->get_user_name($row->user_id,$this->session->userdata['logged_in']['company_id']))."</a></td>
									<td>".$this->common_model->view_date($row->approval_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".($row->approved_by!='' ? "<a class='ui tiny label'><i class='checkmark box icon'></i>":'' )."".strtoupper($this->common_model->get_user_name($row->approved_by,$this->session->userdata['logged_in']['company_id']))."</td>
									<td>";

									foreach($formrights as $formrights_row){ 

										echo ($row->archive==1 && $formrights_row->dearchive==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/dearchive_paper_film/'.$row->spec_id.'/'.$row->spec_version_no).'"><i class="recycle icon"></i></a> ' : '');


										
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