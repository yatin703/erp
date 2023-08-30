<div class="record_form_design">
<h3>Archive Records</h3>
	<div class="record_inner_design">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Id</th>
					<th>Job Card Creation Date</th>
					<th>Order No</th>
					<th>Order Quantity</th>
					<th>Job Card Quantity</th>
					<th>Job Card</th>
					<th>Article No</th>
					<th>Article Description</th>

					<th>Dia X Length</th>
					<th>Print Type</th>
					<th>Action</th>
				</tr>
				<?php if($job_card==FALSE){
					echo "<tr><td colspan='14'>No Active Records Found</td></tr>";
				}else{
					$n=1;
							foreach($job_card as $row){

								$SLEEVE_DIA="";
								$SLEEVE_LENGTH="";
								$SLEEVE_PRINT_TYPE="";
								$SHOULDER_NECK_TYPE="";
								$SHOULDER_ORIFICE="";
								$CAP_STYLE="";
								$CAP_MOLD_FINISH="";
								$CAP_ORIFICE="";

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
									<td>".number_format($order_quantity,0,'.',',')."</td>
									<td>".number_format($this->common_model->read_number($row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']),0,'.',',')."</td>
									
									<td><a href='".base_url('index.php/'.$this->router->fetch_class().'/view_new/'.$row->mp_pos_no.'/'.$spec_id.'/'.$version)."' target='_blank'>$row->mp_pos_no</a></td>
									
									<td>$row->article_no</td>
									<td>".$this->common_model->get_article_name($row->article_no,$this->session->userdata['logged_in']['company_id'])."</td>
									
									<td>$SLEEVE_DIA X $SLEEVE_LENGTH</td>
									<td>$SLEEVE_PRINT_TYPE</td>
									<td>";
									foreach($formrights as $formrights_row){ 
										echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/against_jobcard/'.$row->mp_pos_no.'/'.$spec_id.'/'.$version).'" target="_blank">ADDITINAL MATERIAL</a> ' : '');
										
									}
									echo "</td>
							</tr>";
							}
						}?>
								
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>