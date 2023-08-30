<div class="record_form_design">
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<h4>Sales Order Item Parameter Wise Records From <?php echo $this->input->post('from_date');?> TO <?php echo $this->input->post('to_date');?></h4>
	 <div class="record_inner_design" style="overflow: scroll;">
		
					<table class="record_table_design_without_fixed" >

						<tr>

							<th>Sr. No.</th>
							<th>Hold/Unhold</th>
							<th>Order No.</th>
							<th>Order Date</th>
							<th>Bill To</th>
							<th>Ship To</th>
							<th>Po No. / Po Date</th>
							<th>Currency</th>
							<th>Exchange Rate</th>
							<th>Layer</th>
							<th>Spec</th>
							<th>Artwork</th>
							<th>Article Code</th>
							<th>Article Name</th>
							<th>Delivery Date</th>
							<th>Sleeve Dia</th>
							<th>Sleeve Length</th>
							<th>Sleeve Master Batch</th>
							<th>Sleeve Print Type</th>
							<th>Shoulder Neck Type</th>
							<th>Shoulder Orifice</th>
							<th>Shoulder Master Batch</th>
							<th>Shoulder Foil Tag</th>
							<th>Cap Mold Finish</th>
							<th>Cap Orifice</th>
							<th>Cap Master Batch</th>							
							<th>Cap Foil Color</th>
							<th>Cap foil Width</th>
							<th>Cap Height</th>
							<th>Quantity</th>
							<th>Rest Qty</th>
							<th>Unit Rate</th>
							<th>Net Amount</th>
							<th>Jobcards Generated</th>
							<th>Created By</th>
							<th>Approved By</th>
							<th>Approval Date</th>
							<th>Order Type</th>
							<th>Is Sample</th>
							<th>Order Status</th>
							<th>Transaction Status</th>
							<th>Action</th>
							<!-- <th>Action</th> -->
							<th>Ready To Print (Meters)</th>
							<th>Action</th>
							<th>Ready To Body Making Qty</th>
							<th>Action</th>
					
						</tr>
				<?php if($order_master==FALSE){
					echo "<tr><td colspan='15'>No Records Found</td></tr>";
				}
				else{
					$n=1;
					foreach ($order_master as $order_master_row) {

						$ship_to='';
						$ship_to_gst='';
						$currency='';
						$exchange_rate='';						
						$sleeve_diameter='';
						$sleeve_length='';
						$sleeve_master_batch='';
						$sleeve_print_type='';
						$shoulder_type='';
						$shoulder_orifice='';
						$shoulder_master_batch='';
						$shoulder_foil_tag='';
						$cap_finish='';
						$cap_orifice='';
						$cap_master_batch='';
						$cap_foil_color='';
						$cap_foil_width='';
						$cap_height='';
						
						$layer='';
						$bom_id='';

						// Ship to Details------------------------------------------

						if($order_master_row->consin_adr_company_id!=''){

							$arr=explode("|",$order_master_row->consin_adr_company_id);
							 $consignee=$arr[0];
							$result_consignee=$this->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$consignee);
							foreach ($result_consignee as $row_consignee){
								$ship_to=$row_consignee->name1.' ('.$row_consignee->lang_property_name.')';
							 	$ship_to_gst=$row_consignee->isdn_local;
							}


						}
						else{

							$ship_to=$order_master_row->name1;
							$ship_to_gst=$order_master_row->isdn_local;
						}
						//Currency and Exchange rate-----------------------------------	

						$currency=($order_master_row->currency_id!='' ? $order_master_row->currency_id:'');
						$exchange_rate=($order_master_row->exchange_rate!='0' ?number_format($this->common_model->read_number($order_master_row->exchange_rate,$this->session->userdata['logged_in']['company_id']),2,'.',','):'');	
						
						// Specification Parameter search-------------------------------

						$search=array();
						if(!empty($this->input->post('sleeve_diameter'))){
                      		$search['sleeve_diameter']=$this->input->post('sleeve_diameter');
		                }
		                if(!empty($this->input->post('sleeve_print_type'))){
                      		$search['sleeve_print_type']=$this->input->post('sleeve_print_type');
		                }
		                if(!empty($this->input->post('shoulder_type'))){
		                    $search['shoulder_type']=$this->input->post('shoulder_type');
		                }
		                 if(!empty($this->input->post('shoulder_orifice'))){
		                    $search['shoulder_orifice']=$this->input->post('shoulder_orifice');
		                }
	                  	if(!empty($this->input->post('cap_orifice'))){
	                      $search['cap_orifice']=$this->input->post('cap_orifice');
	                  	}
	                  	if(!empty($this->input->post('cap_finish'))){
	                      $search['cap_finish']=$this->input->post('cap_finish');
		                }
		                $flag=0;
		                $spec_id='';
		                $spec_version_no='';		                

	                	$spec_id=$order_master_row->spec_id;
	                	$spec_version_no=$order_master_row->spec_version_no;

	                	if($spec_id!='' && $spec_version_no!=''){

	                		//SPECS DETAILS BY BOM
	                		if(strtoupper(substr($spec_id, 0,3))=='BOM'){
	                			//  BOM DETAILS--------------
	                			$sleeve_spec_id='';
	                			$sleeve_spec_version='';
	                			$shoulder_spec_id='';
	                			$shoulder_spec_version='';
	                			$cap_spec_id='';
								$cap_spec_version='';

	                			$bom_no=$spec_id;
	                			$bom_version_no=$spec_version_no;
	                			$data=array('bom_no'=>$bom_no,
	                						'bom_version_no'=>$bom_version_no);

	                			$bill_of_material_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data);

	                			foreach (
	                				$bill_of_material_result as $bill_of_material_row) {
	                				$bom_id=$bill_of_material_row->bom_id;
	                				$sleeve_code=$bill_of_material_row->sleeve_code;
						    		$shoulder_code=$bill_of_material_row->shoulder_code;
						    		$cap_code=$bill_of_material_row->cap_code;
						    		$label_code=$bill_of_material_row->label_code;
						    		$print_type_bom=$bill_of_material_row->print_type;
						    		$specs_comment=strtoupper($bill_of_material_row->comment);
	                			}

	                			//SLEEVE------------
	                			$sleeve_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$sleeve_code);

					    		foreach($sleeve_code_result as $sleeve_code_row){										
					    			$sleeve_spec_id=$sleeve_code_row->spec_id;
					    			$sleeve_spec_version=$sleeve_code_row->spec_version_no;
					    		}

					    		$specs['spec_id']=$sleeve_spec_id;
								$specs['spec_version_no']=$sleeve_spec_version;

								$specs_result=$this->sales_order_book_model->select_sleeve_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$specs);
										if($specs_result){
											foreach($specs_result as $specs_row){
												$sleeve_diameter=$specs_row->SLEEVE_DIA;
												$sleeve_length=$specs_row->SLEEVE_LENGTH;
												$sleeve_master_batch=$specs_row->SLEEVE_MASTER_BATCH;											

											}
									    }
									    //SHOULDER----------

										$shoulder_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$shoulder_code);

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
												$shoulder_foil=$shoulder_specs_row->SHOULDER_FOIL_TAG;	
												$shoulder_master_batch=$shoulder_specs_row->SHOULDER_MASTER_BATCH;								
											}
									    }

									    //CAP------------

									    $cap_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$cap_code);
									    
									    

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
												$cap_master_batch=$cap_specs_row->CAP_MASTER_BATCH;
												$cap_foil_color=$this->common_model->get_article_name($cap_specs_row->CAP_FOIL_COLOR,$this->session->userdata['logged_in']['company_id']);
												$cap_shrink_sleeve=$this->common_model->get_article_name($cap_specs_row->CAP_SHRINK_SLEEVE_CODE,$this->session->userdata['logged_in']['company_id']);
												$cap_metalization=$cap_specs_row->CAP_METALIZATION;							

											}

										}

	                			

							//------------------------------------------	
	                		}else{
	                			// SPECS DETAILS BY SPECS----------------
	                			$data=array('spec_id'=>$spec_id,
	                						'spec_version_no'=>$spec_version_no);
	                			$specification_result=$this->sales_order_item_parameterwise_model->select_specs_by_parameter('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data,$search);

	                			if(count($specification_result)>0){
	                				$flag=1;
	                				foreach($specification_result as $specification_row){

										$sleeve_diameter=$specification_row->sleeve_diameter;
										$sleeve_length=$specification_row->sleeve_length;
										$sleeve_master_batch=$specification_row->sleeve_master_batch;
										$sleeve_print_type=$specification_row->sleeve_print_type;
										$shoulder_type=$specification_row->shoulder_type;
										$shoulder_orifice=$specification_row->shoulder_orifice;
										$shoulder_master_batch=$specification_row->shoulder_master_batch;
										$shoulder_foil_tag=$specification_row->shoulder_foil_tag;
										$cap_finish=$specification_row->cap_finish;
										$cap_orifice=$specification_row->cap_orifice;
										$cap_master_batch=$specification_row->cap_master_batch;
										$cap_foil_color=$specification_row->cap_foil_color;
										$cap_foil_width=$specification_row->cap_foil_width;
										$cap_height=$specification_row->cap_height;
									}
								}else{

	                				continue;
	                			}

	                		} // END SPECS DETAILS BY SPECS      	

	                	}else{
	                		$sleeve_diameter='';
							$sleeve_length='';
							$sleeve_master_batch='';
							$sleeve_print_type='';
							$shoulder_type='';
							$shoulder_orifice='';
							$shoulder_master_batch='';
							$shoulder_foil_tag='';
							$cap_finish='';
							$cap_orifice='';
							$cap_master_bacth='';
							$cap_foil_color='';
							$cap_foil_width='';
							$cap_height='';
	                	}


	             		//  ROWS------------------------------------------------------

	                	echo"<tr>
								<td>".$n++."</td>
								<td>".($order_master_row->hold_flag==1 ?"<a class='ui red label'>HOLD</a>" : "<a class='ui green label'>UNHOLD</a>")."</td>
								<td>".($order_master_row->final_approval_flag==1 ? "<i class='check circle icon'></i>" : "")." <a href=".base_url('index.php/sales_order_book/view/'.$order_master_row->order_no)." target='_blank'>".$order_master_row->order_no."</a></td>
								<td>".$this->common_model->view_date($order_master_row->order_date,$this->session->userdata['logged_in']['company_id'])."</td>
								<td>".$order_master_row->name1."</td>
								<td>".$ship_to."</td>
								<td>".$order_master_row->cust_order_no." / ".$this->common_model->view_date($order_master_row->cust_order_date,$this->session->userdata['logged_in']['company_id'])."</td>
								<td>".$currency."</td>
								<td>".$exchange_rate."</td>
								";
								
								if($order_master_row->for_export==1){
									$unit_rate=0;
									$unit_rate=$order_master_row->calc_sell_price;
									$net_amount=$this->common_model->read_number($order_master_row->total_order_quantity,$this->session->userdata['logged_in']['company_id'])*$order_master_row->calc_sell_price;

								}else{

									$unit_rate=0;
									$unit_rate=number_format($this->common_model->read_number($order_master_row->selling_price,$this->session->userdata['logged_in']['company_id']),2,'.',',');

									$net_amount=$this->common_model->read_number($order_master_row->total_order_quantity,$this->session->userdata['logged_in']['company_id'])* $this->common_model->read_number($order_master_row->selling_price,$this->session->userdata['logged_in']['company_id']);
								}

								// REST QUANTITY-----------------
								$total_order_quantity=$this->common_model->read_number($order_master_row->total_order_quantity,$this->session->userdata['logged_in']['company_id']);
								$total_arid_qty=0;
								$supplyqty=0;
								$rest_qty=0;
								$search_arr=array('ref_ord_no'=>$order_master_row->order_no,
												  'article_no'=>$order_master_row->article_no);
								
								$ar_invoice_details_result=$this->common_model->select_active_records_where('ar_invoice_details',$this->session->userdata['logged_in']['company_id'],$search_arr);

								foreach ($ar_invoice_details_result as $ar_invoice_details_row) {
									$total_arid_qty+=$ar_invoice_details_row->arid_qty;
								}

								$supplyqty=$this->common_model->read_number($total_arid_qty,$this->session->userdata['logged_in']['company_id']);

								$rest_qty=$total_order_quantity-$supplyqty;

								echo"
								<td>".$layer."</td>
								<td><a href='".base_url().(substr($order_master_row->spec_id,0,1)=='S'? "/index.php/specification/view/$order_master_row->spec_id/$order_master_row->spec_version_no":"/index.php/bill_of_material/view/$bom_id")." ' target='blank'>".($order_master_row->spec_id!=""? $order_master_row->spec_id."_R".$order_master_row->spec_version_no:"")."</a></td>
								<td><a href='".base_url()."/index.php/".($order_master_row->ad_id!="" && substr($order_master_row->ad_id,0,3)=='SAW'?"artwork_springtube":"artwork_new")."/view/".$order_master_row->ad_id."/".$order_master_row->version_no." ' target='blank'>".($order_master_row->ad_id!=""? $order_master_row->ad_id."_R".$order_master_row->version_no:"")."</a></td>
								<td>".$order_master_row->article_no."</td>
								<td>".$this->common_model->get_article_name($order_master_row->article_no,$this->session->userdata['logged_in']['company_id'])."</td>
								<td>".$this->common_model->view_date(($order_master_row->delivery_date!='0000-00-00'?$order_master_row->delivery_date:""),$this->session->userdata['logged_in']['company_id'])."</td>
								
								<td>".$sleeve_diameter."</td>
								<td>".$sleeve_length."</td>
								<td>".$this->common_model->get_article_name($sleeve_master_batch,$this->session->userdata['logged_in']['company_id'])."</td>				
								<td>".$sleeve_print_type."</td>
								<td>".$shoulder_type."</td>
								<td>".$shoulder_orifice."</td>
								<td>".$this->common_model->get_article_name($shoulder_master_batch,$this->session->userdata['logged_in']['company_id'])."</td>
								<td>".$shoulder_foil_tag."</td>
								<td>".$cap_finish."</td>
								<td>".$cap_orifice."</td>
								<td>".$this->common_model->get_article_name($cap_master_batch,$this->session->userdata['logged_in']['company_id'])."</td>								
								<td>".$cap_foil_color."</td>
								<td>".$cap_foil_width."</td>
								<td>".$cap_height."</td>
								<td>".number_format($this->common_model->read_number($order_master_row->total_order_quantity,$this->session->userdata['logged_in']['company_id']),0,'.',',')."</td>
								<td>".number_format($rest_qty,0,'.',',')."</td>
								<td>".$unit_rate."</td>
								<td>".number_format($net_amount,2,'.',',')."</td>
								<td>";

									$sum_actual_qty_manufactured=0;
									// Jobcards generated--------------------------------
									$jobcard_data=array();
									$jobcard_data['sales_ord_no']=$order_master_row->order_no;
									$jobcard_data['article_no']=$order_master_row->article_no;

									$jobcard_result=$this->common_model->active_record_search('production_master',$jobcard_data,$this->session->userdata['logged_in']['company_id']);

									foreach($jobcard_result as $jobcard_row){

										if(!empty($order_master_row->spec_id)){
											if(substr($order_master_row->spec_id,0,1)=="S"){

												echo "<a target='_blank' href='".base_url('index.php/'.$this->router->fetch_class().'/view/'.$jobcard_row->mp_pos_no.'/'.$order_master_row->spec_id.'/'.$order_master_row->spec_version_no)."' >";

											}else{
												$bom=array('bom_no'=>$order_master_row->spec_id,
			                                    'bom_version_no'=>$order_master_row->spec_version_no);
			                                	$data['bom']=$this->common_model->select_active_records_where("bill_of_material",$this->session->userdata['logged_in']['company_id'],$bom);
			                                    foreach($data['bom'] as $bom_row){                                          
			                                    
			                                    echo "<a target='_blank' href='".base_url('index.php/'.$this->router->fetch_class().'/view_new/'.$jobcard_row->mp_pos_no.'/'.$order_master_row->spec_id.'/'.$order_master_row->spec_version_no)."' >";


			                                    } 
											}
										}
										

										 echo $jobcard_row->mp_pos_no."=".number_format($this->common_model->read_number($jobcard_row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']),2,'.',',');
										echo"</a>";
										echo"</br>";

										$sum_actual_qty_manufactured+=$this->common_model->read_number($jobcard_row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']);
									}
									echo "<p style='color:red !important;'> <u>TOTAL_GENERATED=".number_format($sum_actual_qty_manufactured,2,'.',',')."</u></p>";

								echo"</td>
								<td>".($order_master_row->user_id!='' ? strtoupper($this->common_model->get_user_name($order_master_row->user_id,$this->session->userdata['logged_in']['company_id'])): '')."</td>
								<td>".($order_master_row->approved_by!='' ? strtoupper($this->common_model->get_user_name($order_master_row->approved_by,$this->session->userdata['logged_in']['company_id'])): '')."</td>
								<td>".$this->common_model->view_date($order_master_row->approval_date,$this->session->userdata['logged_in']['company_id'])."</td>
								<td>".($order_master_row->for_export==1 ? "EXPORT":"LOCAL")."</td>
								<td>".($order_master_row->for_sampling==1 ? "SAMPLE":"")."</td>
								<td>";
					             	if($order_master_row->order_closed==0){
					             		echo "OPEN";
					             	}
					             	if($order_master_row->order_closed==1){
					             		echo "COMPLETED";
					             	}
					             	if($order_master_row->order_closed==2){
					             		echo "PARTIALLY COMPLETED";
					             	}
								echo "</td>
								<td>";
					             	if($order_master_row->trans_closed==1){
					             		echo "MANUALLY CLOSED";
					             	}
								             	
								echo "</td>";

									foreach($formrights as $formrights_row){ 
										echo"<td>";
										echo ($formrights_row->new==1 && $order_master_row->final_approval_flag==1 && $order_master_row->order_closed<>1 && $order_master_row->trans_closed<>1 && $order_master_row->ref_order_no=='' && $order_master_row->hold_flag<>1 &&  ? '<a target="_blank" href="'.base_url('index.php/'.$this->router->fetch_class().'/job_card/'.$order_master_row->order_no.'/'.$order_master_row->article_no).'">Create Job Card</a> ' : '');

										echo"</td>";
										// echo"<td>";
										// echo ($formrights_row->new==1 && $order_master_row->order_flag==1 && $order_master_row->final_approval_flag==1 && $order_master_row->order_closed<>1 && $order_master_row->trans_closed<>1 && $order_master_row->ref_order_no=='' ? '<a target="_blank" href="'.base_url('index.php/'.$this->router->fetch_class().'/setup_job_card/'.$order_master_row->order_no.'/'.$order_master_row->article_no).'">Create Setup Job Card</a> ' : '');

										// echo"</td>";
										echo"<td>";
										
										$data_search=array(
											'order_no'=>$order_master_row->order_no,
											'article_no'=>$order_master_row->article_no,
											'status'=>'0'
										);

										$springtube_printing_wip_master_before_result=$this->common_model->select_active_records_where('springtube_printing_wip_master_before',$this->session->userdata['logged_in']['company_id'],$data_search);
										
										$sum_bprint_wip_meters=0;
										foreach ($springtube_printing_wip_master_before_result as  $springtube_printing_wip_master_before_row) {
											
											echo $springtube_printing_wip_master_before_row->jobcard_no.'='.$springtube_printing_wip_master_before_row->bprint_wip_meters;
											$sum_bprint_wip_meters+=$springtube_printing_wip_master_before_row->bprint_wip_meters;
											echo"</br>";

										}
										echo "<p style='color:red !important;'> <u>TOTAL_READY_TO_PRINT=".$sum_bprint_wip_meters."</u></p>";
										
										echo"</td>";
										echo"<td>";

										echo ($formrights_row->new==1 && $order_master_row->order_flag==1 && $order_master_row->final_approval_flag==1 && $order_master_row->order_closed<>1 && $order_master_row->trans_closed<>1 && $sum_bprint_wip_meters>0 ? '<a target="_blank" href="'.base_url('index.php/springtube_printing_wip_before_print/create_printing_jobcard/'.$order_master_row->order_no.'/'.$order_master_row->article_no).'">Create Printing Job Card</a> ' : '');

										
										echo"</td>";

										echo"<td>";
										
										$data_search=array(
											'order_no'=>$order_master_row->order_no,
											'article_no'=>$order_master_row->article_no,
											'status'=>'0',
											'archive'=>'0'
										);

										$springtube_printing_wip_master_after_result=$this->common_model->select_active_records_where('springtube_printing_wip_master_after',$this->session->userdata['logged_in']['company_id'],$data_search);
										
										$sum_aprint_wip_qty=0;
										foreach ($springtube_printing_wip_master_after_result as  $springtube_printing_wip_master_after_row) {
											
											echo $springtube_printing_wip_master_after_row->jobcard_no.'='.$springtube_printing_wip_master_after_row->aprint_wip_qty;
											$sum_aprint_wip_qty+=$springtube_printing_wip_master_after_row->aprint_wip_qty;
											echo"</br>";

										}
										echo "<p style='color:red !important;'> <u>TOTAL_READY_TO_BODYMAKING=".$sum_aprint_wip_qty."</u></p>";
										
										echo"</td>";
										echo"<td>";

										echo ($formrights_row->new==1 && $order_master_row->order_flag==1 && $order_master_row->final_approval_flag==1 && $order_master_row->order_closed<>1 && $order_master_row->trans_closed<>1 && $sum_aprint_wip_qty>0 ? '<a target="_blank" href="'.base_url('index.php/springtube_printing_wip_after_print/create_bodymaking_jobcard/'.$order_master_row->order_no.'/'.$order_master_row->article_no).'">Create Bodymaking Job Card</a> ' : '');

										
										echo"</td>";									

									}
								echo"</tr>";



						
					}//FOREACH

				}//ELSE
			?>				
				</table>
					<div class="pagination"><?php echo $this->pagination->create_links();?></div>

					
		</div>
</div>

				
				
				
				
				
			