<div class="record_form_design">
<h3>Active Records</h3>
	<div class="record_inner_design" style="overflow:scroll;">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Action</th>
					<th>Id</th>
					<th>No</th>
					<th>Verison</th>
					<th>Date</th>
					<th>Product Code</th>
					<th>Product Desc</th>
					<th>Sleeve/Film Code</th>
					<th>Shoulder Code</th>
					<th>Cap Code</th>
					<th>Label Code</th>					
					<th>Print Type</th>
					<th>Box Type</th>
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
					<!--<th>Action</th>-->
				</tr>
				<?php if($bill_of_material==FALSE){
					echo "<tr><td colspan='34'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
								
							foreach($bill_of_material as $row){

								if(substr($row->sleeve_code,0,3)=="SLV"){
									

									//Sleeve-----
								$sleeve_spec_sheet=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$row->sleeve_code);
								if($sleeve_spec_sheet){

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
								}else{
									$sleeve_dia="";
									$sleeve_length="";
									$sleeve_spec_id="";
									$sleeve_master_batch="";
									$sleeve_spec_version_no="";
									$sleeve_mb_perc="";
								}

								}else{


								$film_spec_sheet=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$row->sleeve_code);

								if($film_spec_sheet){

									foreach ($film_spec_sheet as $film_spec_sheet_row) {
									
									$film_spec_id=$film_spec_sheet_row->spec_id;
									$film_spec_version_no=$film_spec_sheet_row->spec_version_no;

									$data=array('spec_id'=>$film_spec_id,
												'spec_version_no'=>$film_spec_version_no);

									$data['film_specs_details']=$this->sales_order_book_model->select_film_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data);
									//echo $this->db->last_query();

									foreach ($data['film_specs_details'] as $film_specs_details_row) {
										$sleeve_dia=$film_specs_details_row->SLEEVE_DIA;
										$sleeve_length=$film_specs_details_row->SLEEVE_LENGTH;
										$sleeve_master_batch=$film_specs_details_row->FILM_MASTER_BATCH_2;
										$sleeve_mb_perc=$film_specs_details_row->FILM_MB_PERC_2;


											}
										}
									}else{
										$sleeve_dia="";
										$sleeve_length="";
										$sleeve_spec_id="";
										$sleeve_master_batch="";
										$sleeve_spec_version_no="";
										$sleeve_mb_perc="";
									}

								}

								
								
								//Shoulder------------
								$shoulder_spec_sheet=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$row->shoulder_code);
								$shoulder_spec_id="";
								$shoulder_spec_version_no="";
								if($shoulder_spec_sheet){								
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
							    }else{

							    	$shoulder_dia="";
									$shoulder_type="";
									$shoulder_orifice="";
									$shoulder_master_batch="";
									$shoulder_mb_perc="";
									$shoulder_hdpe_one="";
									$shoulder_hdpe_one_perc="";
									$shoulder_hdpe_two="";
									$shoulder_hdpe_two_perc="";
									$shoulder_foil_tag="";
							    }


								//Cap----------------------------

								$cap_dia="";
								$cap_type="";
								$cap_finish="";
								$cap_orifice="";
								$cap_master_batch="";
								$cap_mb_perc="";
								$cap_foil_color="";
								$cap_pp="";
								$cap_pp_perc="";
								$cap_metalization="";
								$cap_shrink_sleeve="";

								$cap_spec_id="";
								$cap_spec_version_no="";

								if($row->cap_code!=''){

									$cap_spec_sheet=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$row->cap_code);
									
									if($cap_spec_sheet){

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
								   }
								   else{
								   		$cap_dia="";
										$cap_type="";
										$cap_finish="";
										$cap_orifice="";
										$cap_master_batch="";
										$cap_mb_perc="";
										$cap_foil_color="";
										$cap_pp="";
										$cap_pp_perc="";
										$cap_metalization="";
										$cap_shrink_sleeve="";
								   }

								} 
								  
							   //LABEL ----------------------	-----

								$label_spec_id="";
								$label_spec_version_no="";

								$label_spec_sheet=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$row->label_code);
								
								if($label_spec_sheet){

									foreach ($label_spec_sheet as $label_spec_sheet_row) {

										$label_spec_id=$label_spec_sheet_row->spec_id;
										$label_spec_version_no=$label_spec_sheet_row->spec_version_no;

										$data=array('spec_id'=>$label_spec_id,
													'spec_version_no'=>$label_spec_version_no);

										$data['label_specs_details']=$this->sales_order_book_model->select_label_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data);

										foreach ($data['label_specs_details'] as $label_specs_details_row) {
											$oe=$label_specs_details_row->OE;
											$se=$label_specs_details_row->SE;
											$label_name=$label_specs_details_row->LABEL_NAME;
											$label_lacquer_one=$label_specs_details_row->LABEL_LACQUER_ONE;
											$label_lacquer_one_perc=$label_specs_details_row->LABEL_LACQUER_ONE_PERC;
											$label_lacquer_two=$label_specs_details_row->LABEL_LACQUER_TWO;
											$label_lacquer_one_perc=$label_specs_details_row->LABEL_LACQUER_TWO_PERC;
										}
									}
							   }
							   else{
							   		$oe="";
							   		$se="";
									$label_name="";
									$label_lacquer_one="";
									$label_lacquer_one_perc="";
									$label_lacquer_two="";
									$label_lacquer_one_perc="";
									
							    }

								
								echo "<tr>
									<td>";
									foreach($formrights as $formrights_row){ 
										
										echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->bom_id).'" target="_blank" title="Print Preview"><i class="print icon"></i></a> ' : '');

										echo ($formrights_row->modify==1 && $row->final_approval_flag<>1 && $row->pending_flag<>1  ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->bom_id).'" title="Modify"><i class="edit icon"></i></a> ' : '');

										echo ($formrights_row->copy==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/copy/'.$row->bom_id).'" target="_blank"><i class="copy icon"></i></a> ' : '');

										echo ($row->archive<>1 && $formrights_row->delete==1 && $row->final_approval_flag<>1 && $row->user_id==$this->session->userdata['logged_in']['user_id'] ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->bom_id).'" title="Archive" ><i class="trash icon"></i></a> ' : '');
										
									}	

									echo"</td>
									<td>".$i."</td>
									<td><a href=".base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->bom_id.'')." target='_blank'>".$row->bom_no."</a></td>
									<td><b><a class='ui ".($row->final_approval_flag=='1' ? "green"  : "red")." circular label'>$row->bom_version_no</td>
									<td>".$this->common_model->view_date($row->bom_creation_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$row->article_no."</td>
									<td>".$this->common_model->get_article_name($row->article_no,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>
									".(substr($row->sleeve_code,0,3)=="SLV" ? "<a href='".base_url('index.php/Sleeve_specification/view/').$sleeve_spec_id."/".$sleeve_spec_version_no."'  target='_blank'>".$row->sleeve_code."</a>" : "<a href='".base_url('index.php/Spring_film_specification/view/').$film_spec_id."/".$film_spec_version_no."'  target='_blank'>".$row->sleeve_code."</a>" )."
									</td>
									
									<td><a href='".base_url('index.php/Shoulder_specification/view_shoulder/').$shoulder_spec_id."/".$shoulder_spec_version_no."'  target='_blank'>".$row->shoulder_code."</a></td>
									<td><a href='".base_url('index.php/cap_specification/view_cap/').$cap_spec_id."/".$cap_spec_version_no."'  target='_blank'>".$row->cap_code."</a></td>
									<td><a href='".base_url('index.php/label_specification/view_label/').$label_spec_id."/".$label_spec_version_no."'  target='_blank'>".$row->label_code."</a></td>
									<td>".$row->print_type."</td>
									<td>".($row->for_export==1?"EXPORT":"DOMESTIC")."</td>
									<td>".$sleeve_dia."</td>
									<td>".$sleeve_length."</td>
									<td>".$this->common_model->get_article_name($sleeve_master_batch,$this->session->userdata['logged_in']['company_id'])." ".$sleeve_mb_perc."%</td>
									<td>".$shoulder_dia."</td>
									<td>".$shoulder_type."</td>
									<td>".$shoulder_orifice."</td>
									<td>".$this->common_model->get_article_name($shoulder_master_batch,$this->session->userdata['logged_in']['company_id'])." ".$shoulder_mb_perc."%</td>
									<td>".$this->common_model->get_article_name($shoulder_hdpe_one,$this->session->userdata['logged_in']['company_id'])." ".$shoulder_hdpe_one_perc."%</td>
									<td>".$this->common_model->get_article_name($shoulder_hdpe_two,$this->session->userdata['logged_in']['company_id'])." ".$shoulder_hdpe_two_perc."%</td>
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
									
									<td><a class='ui tiny label'><i class='user icon'></i> ".strtoupper($this->common_model->get_user_name($row->user_id,$this->session->userdata['logged_in']['company_id']))."</a></td>
									<td>".$this->common_model->view_date($row->approval_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".($row->approved_by!='' ? "<a class='ui tiny label'><i class='checkmark box icon'></i>":'' )."".strtoupper($this->common_model->get_user_name($row->approved_by,$this->session->userdata['logged_in']['company_id']))."</td>
									";

									// foreach($formrights as $formrights_row){ 
										
									// 	echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->bom_id).'" target="_blank" title="Print Preview"><i class="print icon"></i></a> ' : '');

									// 	echo ($formrights_row->modify==1 && $row->final_approval_flag<>1 && $row->pending_flag<>1  ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->bom_id).'" title="Modify"><i class="edit icon"></i></a> ' : '');

									// 	echo ($formrights_row->copy==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/copy/'.$row->bom_id).'" target="_blank"><i class="copy icon"></i></a> ' : '');

									 	//echo ($row->archive<>1 && $formrights_row->delete==1 && $row->final_approval_flag<>1 && $row->user_id==$this->session->userdata['logged_in']['user_id'] ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->bom_id).'" title="Archive" ><i class="trash icon"></i></a> ' : '');
										
									 //}

								echo "</tr>";
								$i++;
							}
						}?>
								
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>