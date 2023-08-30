 
<div class="record_form_design">
<h3>Active Records</h3>
	<div class="record_inner_design" style="white-space: nowrap;overflow: scroll;">
			<table class="ui very compact celled table" style="font-size:10px;">
				<thead>
				<tr>
					<th>Id</th>
					<th>Job Card Date</th>
					<th>Order No</th>
					<th>Article No</th>
					<th>Dia X Length</th>
					<th>Print Type</th>
					<th>Order Qty</th>
					<th>Job Card</th>
					<th>Job Card Qty</th>
					<th>Job Card Plan MTRS</th>					
					<!--<th>Job Card</th>
					<th>Article No</th>
					<th>Article Description</th>
					<th>Dia X Length</th>
					<th>Print Type</th> -->
					<th>cost</th>
					<th>Remarks</th>
					<th colspan="4">Action</th>
					<th>Top Box Reused</th>
					<th>Bottom Box Reused</th>
				</tr>
				</thead>
				<tbody>
				<?php if($job_card==FALSE){
					echo "<tr><td colspan='14'>No Active Records Found</td></tr>";
				}else{
					$n=1;
							foreach($job_card as $row){

								$material_issue_flag=0;

								$SLEEVE_DIA="";
								$SLEEVE_LENGTH="";
								$SLEEVE_PRINT_TYPE="";
								$SHOULDER_NECK_TYPE="";
								$SHOULDER_ORIFICE="";
								$CAP_STYLE="";
								$CAP_MOLD_FINISH="";
								$CAP_ORIFICE="";

								$spec_id='';
								$version='';

								$order_flag='';								
								$data['order_master']=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$row->sales_ord_no);
								foreach ($data['order_master'] as $order_master_row) {
									$order_flag=$order_master_row->order_flag;
								}

								$data=array('order_no'=>$row->sales_ord_no,
									'article_no'=>$row->article_no);
								$data['spec']=$this->common_model->select_one_active_record_nonlanguage_without_archives('order_details',$this->session->userdata['logged_in']['company_id'],$data);
								$order_quantity=0;
								foreach($data['spec'] as $spec_row){
									$spec_id=$spec_row->spec_id;
									$version=$spec_row->spec_version_no;
									$order_quantity=$this->common_model->read_number($spec_row->total_order_quantity,$this->session->userdata['logged_in']['company_id']);

									$data=array('spec_id'=>$spec_id,
									'spec_version_no'=>$version);
									$data['specs_details']=$this->sales_order_book_model->select_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data);
									if($data['specs_details']){
										foreach($data['specs_details'] as $specs_details_row){
										$SLEEVE_DIA=$specs_details_row->SLEEVE_DIA;
										$SLEEVE_LENGTH=$specs_details_row->SLEEVE_LENGTH;
										$SLEEVE_PRINT_TYPE=$specs_details_row->SLEEVE_PRINT_TYPE;
										$SHOULDER_NECK_TYPE=$specs_details_row->SHOULDER_NECK_TYPE;
										$SHOULDER_ORIFICE=$specs_details_row->SHOULDER_ORIFICE;
										$CAP_STYLE=$specs_details_row->CAP_STYLE;
										$CAP_MOLD_FINISH=$specs_details_row->CAP_MOLD_FINISH;
										$CAP_ORIFICE=$specs_details_row->CAP_ORIFICE;
										}

									}else{

								    	// BOM DEATILS-------

								    	$bom_data['bom_no']=$spec_id;
										$bom_data['bom_version_no']=$version;

								    	$bom_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$bom_data);
								    	if($bom_result){

								    		foreach($bom_result as $bom_result_row){										
								    			$sleeve_code=$bom_result_row->sleeve_code;
								    			$shoulder_code=$bom_result_row->shoulder_code;
								    			$cap_code=$bom_result_row->cap_code;
								    			$label_code=$bom_result_row->label_code;
								    			$SLEEVE_PRINT_TYPE=$bom_result_row->print_type;
								    		}

								    		$sleeve_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$sleeve_code);
								    		$sleeve_spec_id="";
								    		$sleeve_spec_version="";
								    		foreach($sleeve_code_result as $sleeve_code_row){										
								    			$sleeve_spec_id=$sleeve_code_row->spec_id;
								    			$sleeve_spec_version=$sleeve_code_row->spec_version_no;
								    		}

								    		$specs['spec_id']=$sleeve_spec_id;
											$specs['spec_version_no']=$sleeve_spec_version;

											$specs_master_result=$this->common_model->select_active_records_where('specification_sheet',$this->session->userdata['logged_in']['company_id'],$specs);
											if($specs_master_result){
												foreach($specs_master_result as $specs_master_result_row){
													$layer_arr=explode("|", $specs_master_result_row->dyn_qty_present);
													$layer_no=substr($layer_arr[1],0,1);							

												}
												$specs_result=$this->sales_order_book_model->select_sleeve_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$specs);
												if($specs_result){
													foreach($specs_result as $specs_row){
														$SLEEVE_DIA=$specs_row->SLEEVE_DIA;
														$SLEEVE_LENGTH=$specs_row->SLEEVE_LENGTH;								

													}
											    }
											    //SHOULDER----------

												$shoulder_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$shoulder_code);
												$shoulder_spec_id="";
												$shoulder_spec_version="";
									    		foreach($shoulder_code_result as $shoulder_code_row){										
									    			$shoulder_spec_id=$shoulder_code_row->spec_id;
									    			$shoulder_spec_version=$shoulder_code_row->spec_version_no;
									    		}

									    		$shoulder_specs['spec_id']=$shoulder_spec_id;
												$shoulder_specs['spec_version_no']=$shoulder_spec_version;

												$shoulder_specs_result=$this->sales_order_book_model->select_shoulder_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$shoulder_specs);
												if($shoulder_specs_result){
													foreach($shoulder_specs_result as $shoulder_specs_row){
														$shoulder_type=$shoulder_specs_row->SHOULDER_STYLE;
														$shoulder_orifice=$shoulder_specs_row->SHOULDER_ORIFICE;
														$shoulder_foil_tag=$shoulder_specs_row->SHOULDER_FOIL_TAG;								

													}
											    }

											    //CAP------------

											    $cap_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$cap_code);
											    $cap_spec_id="";
											    $cap_spec_version="";
									    		foreach($cap_code_result as $cap_code_row){										
									    			$cap_spec_id=$cap_code_row->spec_id;
									    			$cap_spec_version=$cap_code_row->spec_version_no;
									    		}

									    		$cap_specs['spec_id']=$cap_spec_id;
												$cap_specs['spec_version_no']=$cap_spec_version;

												$cap_specs_result=$this->sales_order_book_model->select_cap_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$cap_specs);
												if($cap_specs_result){
													foreach($cap_specs_result as $cap_specs_row){
														$cap_dia=$cap_specs_row->CAP_DIA;
														$cap_type=$cap_specs_row->CAP_STYLE;
														$cap_finish=$cap_specs_row->CAP_MOLD_FINISH;
														$cap_orifice=$cap_specs_row->CAP_ORIFICE;							

													}
											    }


								    		}//SPECS MASTER

								        }//BOM RESULT

								    
									}
									

									if(!empty($spec_row->ad_id)){
										$artwork['ad_id']=$spec_row->ad_id;
										$artwork['version_no']=$spec_row->version_no;
										$search='';
										$from='';
										$to='';
										$artwork_result=$this->artwork_model->active_record_search('artwork_devel_master',$artwork,$search,$from,$to,$this->session->userdata['logged_in']['company_id']);
										foreach ($artwork_result as $artwork_row) {
											$SLEEVE_PRINT_TYPE=$artwork_row->print_type;
										}


									}

								}

								echo "<tr>
									<td>".$n++."</td>
									<td>".$this->common_model->view_date($row->manu_plan_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td><a href=".base_url('index.php/sales_order_book/view/'.$row->sales_ord_no)." target='_blank'>$row->sales_ord_no</a></td>
									<td>$row->article_no</td>
									<td>$SLEEVE_DIA X $SLEEVE_LENGTH</td>
									<td>$SLEEVE_PRINT_TYPE</td>
									<td>".number_format($order_quantity,0,'.',',')."</td>
									";
									
									

									if($order_flag=='1'){

										echo "<td><a href='".base_url('index.php/sales_order_item_parameterwise/view_new/'.$row->mp_pos_no.'/'.$spec_id.'/'.$version)."' target='_blank'>$row->mp_pos_no</a></td>";
									}else{

										if(strtoupper(substr($spec_id,0,1))=="B"){

										echo "<td><a href='".base_url('index.php/sales_order_item_parameterwise/view_new/'.$row->mp_pos_no.'/'.$spec_id.'/'.$version)."' target='_blank'>$row->mp_pos_no</a></td>";
									
										}else{
											echo "<td><a href='".base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->mp_pos_no.'/'.$spec_id.'/'.$version)."' target='_blank'>$row->mp_pos_no</a></td>";
										
										}

									}

									// if(strtoupper(substr($spec_id,0,1))=="B"){
									// 	echo "<td><a href='".base_url('index.php/sales_order_item_parameterwise/view_new/'.$row->mp_pos_no.'/'.$spec_id.'/'.$version.'')."' target='_blank'>$row->mp_pos_no</a></td>";
									
									// }else{
									// 	echo "<td><a href='".base_url('index.php/sales_order_item_parameterwise/view/'.$row->mp_pos_no.'/'.$spec_id.'/'.$version.'')."' target='_blank'>$row->mp_pos_no</a></td>";
									// }
									
									echo"
									<td>".number_format($this->common_model->read_number($row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']),0,'.',',')."</td>
									<td>".$row->total_meters."</td>

									<!--<td>$row->article_no</td>
									<td>".$this->common_model->get_article_name($row->article_no,$this->session->userdata['logged_in']['company_id'])."</td>
									
									<td>$SLEEVE_DIA X $SLEEVE_LENGTH</td>
									<td>$SLEEVE_PRINT_TYPE</td>
									-->
									<td>";
									if($row->jobcard_type==1){
										echo $row->extrusion_prod_cost_per_meter;
									}
									elseif($row->jobcard_type==4){
										echo $row->setup_prod_cost_per_meter;
									}
									elseif($row->jobcard_type==5){
										echo $row->purging_prod_cost_per_meter;
									}else if($row->jobcard_type==2){
										echo $row->printing_cost_per_qty;
										
									}
									echo"</td>
									<td>".$row->comment."</td>";
									foreach($formrights as $formrights_row){ 
										echo"<td>";	
										echo ($formrights_row->modify==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/issue_jobcard/'.$row->mp_pos_no.'/'.$spec_id.'/'.$version).'" target="_blank">ISSUE</a>' : '');
										echo"</td>
										<td>";

										if($row->jobcard_status==0 ){
											echo($formrights_row->modify==1 ? '<a href="'.base_url('index.php/sales_order_item_parameterwise/against_jobcard/'.$row->mp_pos_no.'/'.$spec_id.'/'.$version).'" target="_blank">AGAINST JOBCARDS </a>' : '');
											echo"";
										}
										echo"</td>

										<td>";
										

										//echo ($formrights_row->new==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/close_jobcard/'.$row->mp_pos_no.'/'.$spec_id.'/'.$version).'" target="_blank" title="Close Jobcard"><i class="edit icon"></i></a>' : '');

										// Extrusion JOBCARD CLOSE
										if($order_flag=='1' && $row->jobcard_status==1){

											echo"<a href='#' style='color:#06c806;'><i class='check circle icon'></i> Done<a>";

										}

										$qc_done=0;
										if($order_flag=='1' && $row->jobcard_status==0 && $row->jobcard_type==1 && $formrights_row->new==1){
											
											//Production---------
											$details_data=array('jobcard_no'=>$row->mp_pos_no,'archive'=>'0');


											$result_extrusion=$this->springtube_extrusion_production_model->active_details_records('springtube_extrusion_production_details',$details_data);
											//echo $this->db->last_query();

											foreach ($result_extrusion as $extrusion_row) {
												$qc_done=$extrusion_row->qc_check;
											}


											//IS QC HOLD ---------------------------
											$dataa=array('jobcard_no'=>$row->mp_pos_no,'status'=>'0','archive'=>0);
											$springtube_extrusion_qc_master_result=$this->common_model->select_active_records_where('springtube_extrusion_qc_master',$this->session->userdata['logged_in']['company_id'],$dataa);             								
          									$total_qc_hold_meters=0;
          									foreach ($springtube_extrusion_qc_master_result as $springtube_extrusion_qc_master_row) {
          									 	$total_qc_hold_meters+=$springtube_extrusion_qc_master_row->total_qc_hold_meters;
          									}

          									//echo $this->db->last_query();

          									// IS MATERIAL ISSUE COMPLETED AGAINST JOBCARD--

          									//$material_issue_flag=0;

          									$data_material_manu=array('manu_order_no'=>$row->mp_pos_no,'archive'=>0);

          									$material_manufacturing_result=$this->common_model->select_active_records_where('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$data_material_manu);

          									foreach ($material_manufacturing_result as $key => $material_manufacturing_row) {
          										
          										$count=$this->common_model->table_record_count_where_pkey('reserved_quantity_manu',$this->session->userdata['logged_in']['company_id'],'ref_mm_id',$material_manufacturing_row->mm_id);
          										if($count==0){				
          											$material_issue_flag=0;
          											break;
          										}else{
          											$material_issue_flag=1;
          										}
          									}

          									//$material_manufacturing_count=$this->common_model->table_record_count_where_pkey('material_manufacturing',$this->session->userdata['logged_in']['company_id'],'manu_order_no',$row->mp_pos_no);

          									//echo $this->db->last_query();
          									//$reserved_quantity_manu_count=$this->common_model->table_record_count_where_pkey('reserved_quantity_manu',$this->session->userdata['logged_in']['company_id'],'manu_order_no',$row->mp_pos_no);

          								//echo $this->db->last_query();	
          									

          									//if( $qc_done==1 && $total_qc_hold_meters==0  && ($material_manufacturing_count==$reserved_quantity_manu_count)){

          									//echo $qc_done;

          									if( $qc_done==1 && $total_qc_hold_meters==0  && $material_issue_flag==1 && $formrights_row->new==1){

											?>		
												<a id="jobcard_close" href="#" onclick="window.open('<?php echo base_url("/index.php/".$this->router->fetch_class()."/close_jobcard/$row->mp_pos_no/$spec_id/$version");?>','Close Jobcard','height=200,width=615')" title="Close Extrusion Jobcard" >CLOSE EXTRUSION JOBCARD</a>

									<?php   }
										
										}
										//PRinting JObcard close----

										if($order_flag=='1' && $row->jobcard_status==0 && $row->jobcard_type==2 && $formrights_row->new==1){

											$material_issue_flag=0;

          									$data_material_manu_print=array('manu_order_no'=>$row->mp_pos_no,'archive'=>0);

          									$material_manufacturing_print_result=$this->common_model->select_active_records_where('material_manufacturing',$this->session->userdata['logged_in']['company_id'],$data_material_manu_print);

          									foreach ($material_manufacturing_print_result as $key => $material_manufacturing_row) {
          										
          										$count=$this->common_model->table_record_count_where_pkey('reserved_quantity_manu',$this->session->userdata['logged_in']['company_id'],'ref_mm_id',$material_manufacturing_row->mm_id);
          										if($count==0){				
          											$material_issue_flag=0;
          											break;
          										}else{
          											$material_issue_flag=1;
          										}
          									}


											if($order_flag=='1' && $row->jobcard_status==0 && $row->jobcard_type==2 && $row->printing_done==1 && $row->inspection_done==1 && $material_issue_flag==1 && $formrights_row->new==1){
											?>	

											<a id="jobcard_close" href="#" onclick="window.open('<?php echo base_url("/index.php/".$this->router->fetch_class()."/close_jobcard/$row->mp_pos_no/$spec_id/$version");?>','Close Printing Jobcard','height=200,width=615')" title="Close Printing Jobcard">CLOSE PRINTING JOBCARD
											</a>

									<?php

											}
										} 


									echo"<td>".($formrights_row->delete==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->mp_pos_no).'" target="_blank" title="delete"><i class="trash icon"></i></a>' : '')."

									</td>";


									}// FOREACH FORM RIGHTS
									
									 echo "<td>".($row->top_box_flag==1 ? '<i class="check green circle icon"></i>' : '<i class="x red circle icon"></i>')."</td>";
									 echo "<td>".($row->bottom_box_flag==1 ? '<i class="check green circle icon"></i>' : '<i class="x red circle icon"></i>')."</td>";

									echo "</tr>
									";
							}
						}?>
							</tbody>
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>