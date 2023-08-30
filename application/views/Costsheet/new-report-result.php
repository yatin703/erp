<div class="record_form_design">
<h4>Search Records From <?php echo $this->input->post('from_date');?> TO <?php echo $this->input->post('to_date');?></h4>
	 <div class="record_inner_design" style="overflow: scroll;">
		
					<table class="record_table_design_without_fixed" id="table-1">
					<thead>
						<tr>
							<th>Sr. No.</th>
							<th>Invoice Date</th>
							<th>Invoice No.</th>
							<th>Bill To</th>
							<th>Status</th>
							<th>Order No.</th>
							<th>Dia</th>
							<th>Length</th>
							<th>Print Type</th>
							<th>Article No</th>
							<th>Article Description</th>
							<th>Dispatch Quantity</th>
							<th>Unit Rate</th>
							<th>Net Amount</th>
							<th>LDPE KG FROM COSTSHEET</th>
							<th>LDPE KG FROM BOM</th>
							<th>LDPE DIFF %</th>


							<th>LLDPE KG FROM COSTSHEET</th>
							<th>LLDPE KG FROM BOM</th>
							<th>LLDPE DIFF %</th>

							<th>HDPE KG FROM COSTSHEET</th>
							<th>HDPE KG FROM BOM</th>
							<th>HDPE DIFF %</th>					
							
					
						</tr>
					</thead>
					<tbody>
				<?php if($ar_invoice_master==FALSE){
					echo "<tr><td colspan='7'>No Records Found</td></tr>";
				}
				else 
				{
					$ci =&get_instance();
					$ci->load->model('sales_invoice_book_model');
				    $ci->load->model('common_model');
				    $ci->load->model('article_model');
				    $ci->load->model('customer_model');

				    $sum_quantity=0;
				    $sum_net_amount=0;
				    $sum_total_tax=0;
				    $sum_gross_amount=0;
				    $currency='';
				    $exchange_rate=0;
				    $sum_freight=0;
				    $sum_packaging=0;
				    $sum_insurance=0;
				    $sum_discount=0;

				    $sum_tcs=0;

				    $n=1;
					foreach($ar_invoice_master as $mrow){

						$freight_in_rupees=0;
						$packaging_in_rupees=0;
						$insurance_in_rupees=0;
						$discount_in_ruppes=0;
						$tcs_in_ruppes=0;

						// Article Search -------------------------------------
						$details_data=array();
						$details_data['ar_invoice_no']=$mrow->ar_invoice_no;
						if(!empty($this->input->post('article_no'))){
							$arr=explode("//",$this->input->post('article_no'));
							$article_no=$arr[1];
							$details_data['article_no']=$article_no;

						}
						if(!empty($this->input->post('sleeve_dia'))){
							$details_data['sleeve_dia']=$this->input->post('sleeve_dia');

						}
						if($this->input->post('order_flag')!=''){

							$details_data['order_flag']=$this->input->post('order_flag');
							
						}

						if($this->input->post('print_type')!=''){
							$details_data['print_type']=$this->input->post('print_type');

						}
						//print_r($details_data);
							
						$result=$ci->sales_invoice_book_model->active_details_records('ar_invoice_details',$details_data,$this->session->userdata['logged_in']['company_id']);
						//echo $this->db->last_query();
						
						$rowspan=count($result);
					    $tr=$rowspan;

					    if($rowspan>0){
					    	// Month And Year----
					    	$time=strtotime($mrow->invoice_date);
							$month=date("F",$time);
							$year=date("Y",$time);

							// Ship to Details --------------------------------------------

							$ship_to='';
							$ship_to_gst='';
							if($mrow->consin_adr_company_id!=''){

								$arr=explode("|",$mrow->consin_adr_company_id);
								$consignee=$arr[0];
								$result_consignee=$ci->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$consignee);
								foreach ($result_consignee as $row_consignee){
									$ship_to=$row_consignee->name1.' ('.$row_consignee->lang_property_name.')';
									$ship_to_gst=$row_consignee->isdn_local;
								}


							}
							else{

								$ship_to=$mrow->name1." (".strtoupper($mrow->lang_property_name).")";
							}

							// Currency Details----------------------------------------
							$currency=($mrow->currency_id!='' ? $mrow->currency_id:'');
							// if($mrow->invoice_date>='2019-06-01'){
							// 	$exchange_rate=($mrow->exchange_rate!='0' ?$mrow->exchange_rate:'');
							// }
							// else{
								$exchange_rate=($mrow->exchange_rate!='0' ? $ci->common_model->read_number($mrow->exchange_rate,$this->session->userdata['logged_in']['company_id']):'');
							//}
							//echo $exchange_rate;
							
							$transporter_name="";
							$lr_no="";
							$lr_no_local="";
							// Dispatch details------------------------------------------
							$dispatch_result=$this->common_model->select_one_details_record('ar_invoice_dispatch_details',$this->session->userdata['logged_in']['company_id'],'ar_invoice_no',$mrow->ar_invoice_no);
							foreach ($dispatch_result as $dispatch_row){
								$transporter_name=$dispatch_row->transporter_name;
								$lr_no=$dispatch_row->lr_no;
								$lr_no_local=$dispatch_row->lr_no_local;
							}

							$invoice_type='';
							// Invoice Type---------------------------
							$invoice_type_result=$this->common_model->select_one_active_record('invoice_types_master_lang',$this->session->userdata['logged_in']['company_id'],'inv_type_id',$mrow->inv_type);
							foreach ($invoice_type_result as $invoice_type_result_row){
								$invoice_type=$invoice_type_result_row->lang_inv_type;
								
							}



								
							echo "<tr>
							<td rowspan='".$rowspan."'>".$n++."</td>
							<td rowspan='".$rowspan."'>".$ci->common_model->view_date($mrow->invoice_date,$this->session->userdata['logged_in']['company_id'])."</td>
							<td rowspan='".$rowspan."'>".$mrow->ar_invoice_no."</td>
							
							<td rowspan='".$rowspan."'>".$mrow->name1." (".strtoupper($mrow->lang_property_name).") </td>
							
							";


								
							$r=0;
							foreach ($result as $drow){


								$order_no=$drow->ref_ord_no;								
							$order_master_result=$ci->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$order_no);


										$so_data=array();
										$so_data['order_no']=$drow->ref_ord_no;
										$so_data['article_no']=$drow->article_no;
										$so_result=$this->sales_invoice_book_model->active_details_records('order_details',$so_data,$this->session->userdata['logged_in']['company_id']);

							foreach ($order_master_result as $order_master_row) {
											$po_no=$order_master_row->cust_order_no;
											$po_date=$order_master_row->cust_order_date;
											$trans_closed=$order_master_row->trans_closed;
											//$so_quantity=$order_master_row->total_order_quantity;
											//$pr_pos_complete_flag=$order_master_row->pr_pos_complete_flag;
										}



										foreach ($so_result as $so_row) {
											$spec_id=$so_row->spec_id;
											$spec_version_no=$so_row->spec_version_no;
											$ad_id=$so_row->ad_id;
											$version_no=$so_row->version_no;
											$so_quantity=$so_row->total_order_quantity;
											$pr_pos_complete_flag=$so_row->pr_pos_complete_flag;
											

										}


							$master_array= array('article_no' => $drow->article_no,
		                                                'sales_ord_no'=>$drow->ref_ord_no);
		                          
		                          		$data1=array_filter($master_array);                      
		                          		$data2['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from="",$to="",$this->session->userdata['logged_in']['company_id']);
		                          	
				                        $address_master_result=$this->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'adr_company_id',$mrow->customer_no);

									foreach ($address_master_result as $address_master_row) {

										$total_order_quantity=$this->common_model->read_number($so_quantity,$this->session->userdata['logged_in']['company_id']);									
										//Factory Tolerance-------	
										$factory_tolerance=30;
										$factory_tolerance_qty=($total_order_quantity*$factory_tolerance)/100;
										$minus_factory_dispatch_qty=$total_order_quantity-$factory_tolerance_qty;

										//Customer Tolerance-------		
										//$customer_tolerance=10;
										$customer_tolerance=0;
										$customer_tolerance=($address_master_row->dispatch_tolerance!=''?$address_master_row->dispatch_tolerance:0);

										if($customer_tolerance!=0){
											$tolerance_qty=($total_order_quantity*$customer_tolerance)/100;
											$plus_tolerance_qty=$total_order_quantity+$tolerance_qty;
											$minus_tolerance_qty=$total_order_quantity-$tolerance_qty;
										}
										else{
											
											$tolerance_qty=0;
											$plus_tolerance_qty=$total_order_quantity+$tolerance_qty;
											$minus_tolerance_qty=$total_order_quantity-$tolerance_qty;
											
										}
									}

							$total_arid_qty=0;
							$supplyqty=0;
							$cancel_qty=0;
							$search_arr=array('ref_ord_no'=>$drow->ref_ord_no,
											  'article_no'=>$drow->article_no);
							
							$ar_invoice_details_result=$this->common_model->select_active_records_where('ar_invoice_details',$this->session->userdata['logged_in']['company_id'],$search_arr);

							foreach ($ar_invoice_details_result as $ar_invoice_details_row) {
								$total_arid_qty+=$ar_invoice_details_row->arid_qty;
							}

							
							$supplyqty=$this->common_model->read_number($total_arid_qty,$this->session->userdata['logged_in']['company_id']);
							$flag=0;
							if($trans_closed==1){
								$flag=1;
								if($supplyqty==0)
								{	$status="Cancel Order";

									$cancel_qty=$total_order_quantity;
								}else if($supplyqty<$minus_factory_dispatch_qty){																
									$status="Manual Closed Order Cancelled";
									$cancel_qty=number_format($total_order_quantity- $supplyqty,2,'.',',');
									//$status.=number_format($total_order_quantity - $supplyqty,2,'.',',');
								}
								else if($supplyqty<$minus_tolerance_qty && $supplyqty>$minus_factory_dispatch_qty){																
									$status="Manual Closed Below Tolerance";
									$cancel_qty=number_format($total_order_quantity - $supplyqty,2,'.',',');
									$status.=number_format($total_order_quantity - $supplyqty,2,'.',',');
								}
								elseif($supplyqty>=$minus_tolerance_qty && $supplyqty<$total_order_quantity){
									$status="Short Closed";
									//$cancel_qty=number_format(get_value($row_order_details['total_order_quantity'])- $supplyqty,2,'.',',');
									//$status.=number_format($total_order_quantity- $supplyqty,2,'.',',');
								}
								else{
									
									$status="Completed";
								}
								
							}else{								
								
								if($total_order_quantity<=$supplyqty && $supplyqty<>0){
									$status="Completed";
									$flag=1;

									//$status="Completed (INV)";
								}
								elseif($total_order_quantity>$supplyqty && $supplyqty<>0){
									$status="Partial Dispatch";
									//$status="Partially Completed (INV)";
									//$status.=number_format($total_order_quantity- $supplyqty,2,'.',',');
									$flag=0;

								}
								else{
									$flag=0;
									$status="Pending";
								}
								
							}


								$order_details=array('ref_ord_no'=>$drow->ref_ord_no,'article_no'=>$drow->article_no);
								$result_dispatch=$this->common_model->select_active_records_where('ar_invoice_details',$this->session->userdata['logged_in']['company_id'],$order_details);
								$total_dispatch=0;
								foreach($result_dispatch as $row_total_dispatch){
									$total_dispatch+=$this->common_model->read_number($row_total_dispatch->arid_qty,$this->session->userdata['logged_in']['company_id']);
																		
									}

								//Order Info---------------------------------
								
								$order_no=$drow->ref_ord_no;								
								$order_master_result=$ci->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$order_no);
								
								$so_data=array();
								$so_data['order_no']=$drow->ref_ord_no;
								$so_data['article_no']=$drow->article_no;
								$so_result=$ci->sales_invoice_book_model->active_details_records('order_details',$so_data,$this->session->userdata['logged_in']['company_id']);
								//echo $this->db->last_query();

								$po_no='';
								$po_date='';
								$dia='';	
								$length='';
								$print_type_artwork='';
								$print_type_bom='';
								$layer_no='';
								$shoulder_type='';
								$shoulder_orifice='';
								$shoulder_foil='';
								$cap_dia='';
								$cap_type='';
								$cap_finish='';
								$cap_orifice='';
								$cap_shrink_sleeve='';
								$spec_id='';
								$spec_version_no='';
								$ad_id='';
								$version_no='';	

								foreach ($order_master_result as $order_master_row) {
									$po_no=$order_master_row->cust_order_no;
									$po_date=$order_master_row->cust_order_date;
								}

								foreach ($so_result as $so_row) {
									$spec_id=$so_row->spec_id;
									$spec_version_no=$so_row->spec_version_no;
									$ad_id=$so_row->ad_id;
									$version_no=$so_row->version_no;
								}

								//ARTWORK DEATILS-----------------
								if(!empty($ad_id)){

									$artwork['ad_id']=$ad_id;
									$artwork['version_no']=$version_no;
									$search='';
									$from='';
									$to='';
									$artwork_result=$ci->artwork_model->active_record_search('artwork_devel_master',$artwork,$search,$from,$to,$this->session->userdata['logged_in']['company_id']);
									foreach ($artwork_result as $artwork_row) {
										$print_type_artwork=$artwork_row->print_type;
									}

								}

								

								//SLEEVE DETAILS-----------------
								if(!empty($spec_id)){

									$specs['spec_id']=$spec_id;
									$specs['spec_version_no']=$spec_version_no;

									$specs_master_result=$ci->common_model->select_active_records_where('specification_sheet',$this->session->userdata['logged_in']['company_id'],$specs);
									if($specs_master_result){
										foreach($specs_master_result as $specs_master_result_row){
											$layer_arr=explode("|", $specs_master_result_row->dyn_qty_present);
											$layer_no=substr($layer_arr[1],0,1);							

										}


										$specs_result=$ci->sales_order_book_model->select_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$specs);
										
										if($specs_result){

											foreach($specs_result as $specs_row){
												$dia=$specs_row->SLEEVE_DIA;
												$length=$specs_row->SLEEVE_LENGTH;
												$print_type_bom=$specs_row->SLEEVE_PRINT_TYPE;
												$shoulder_type=$specs_row->SHOULDER_NECK_TYPE;
												$shoulder_orifice=$specs_row->SHOULDER_ORIFICE;
												$shoulder_foil=$specs_row->SHOULDER_FOIL_TAG;
												$cap_dia=$specs_row->CAP_DIA;
												$cap_type=$specs_row->CAP_STYLE;
												$cap_finish=$specs_row->CAP_MOLD_FINISH;
												$cap_orifice=$specs_row->CAP_ORIFICE;			
											}

											$specs_lang_result=$ci->common_model->select_active_records_where('specification_sheet_lang',$this->session->userdata['logged_in']['company_id'],$specs);

										    if($specs_lang_result){

										    	foreach ($specs_lang_result as $specs_lang_row) {

										    		$specs_comment= strtoupper($specs_lang_row->lang_comments);

											    	$a_ss=strpos(strtoupper($specs_lang_row->lang_comments),'SHRINK');
													$a_met=strpos(metaphone(strtoupper($specs_lang_row->lang_comments)),'MTL');
													$b_met=strpos(metaphone(strtoupper($specs_lang_row->lang_comments)),'MTLST');
													$c_met=strpos(metaphone(strtoupper($specs_lang_row->lang_comments)),'MTLS');
														
													if($a_ss){
														$cap_shrink_sleeve='YES';
													}
														
													if($a_met OR $b_met OR $c_met){
														$cap_metalization='YES';
													}
										    	}							    	

										    }
									    }	

								    }else{
								    	// BOM DEATILS-------

								    	$bom_data['bom_no']=$spec_id;
										$bom_data['bom_version_no']=$spec_version_no;

								    	$bom_result=$ci->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$bom_data);
								    	if($bom_result){

								    		foreach($bom_result as $bom_result_row){										
								    			$sleeve_code=$bom_result_row->sleeve_code;
								    			$shoulder_code=$bom_result_row->shoulder_code;
								    			$cap_code=$bom_result_row->cap_code;
								    			$label_code=$bom_result_row->label_code;
								    			$print_type_bom=$bom_result_row->print_type;
								    		}

								    		$sleeve_code_result=$ci->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$sleeve_code);

								    		foreach($sleeve_code_result as $sleeve_code_row){										
								    			$sleeve_spec_id=$sleeve_code_row->spec_id;
								    			$sleeve_spec_version=$sleeve_code_row->spec_version_no;
								    		}

								    		$specs['spec_id']=$sleeve_spec_id;
											$specs['spec_version_no']=$sleeve_spec_version;

											$specs_master_result=$ci->common_model->select_active_records_where('specification_sheet',$this->session->userdata['logged_in']['company_id'],$specs);
											if($specs_master_result){
													foreach($specs_master_result as $specs_master_result_row){
														$layer_arr=explode("|", $specs_master_result_row->dyn_qty_present);
														$layer_no=substr($layer_arr[1],0,1);							

													}
												$specs_result=$ci->sales_order_book_model->select_sleeve_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$specs);
												if($specs_result){
													foreach($specs_result as $specs_row){
														$dia=$specs_row->SLEEVE_DIA;
														$length=$specs_row->SLEEVE_LENGTH;								

													}
											    }
											    //SHOULDER----------

												$shoulder_code_result=$ci->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$shoulder_code);

									    		foreach($shoulder_code_result as $shoulder_code_row){										
									    			$shoulder_spec_id=$shoulder_code_row->spec_id;
									    			$shoulder_spec_version=$shoulder_code_row->spec_version_no;
									    		}

									    		$shoulder_specs['spec_id']=$shoulder_spec_id;
												$shoulder_specs['spec_version_no']=$shoulder_spec_version;

												$shoulder_specs_result=$ci->sales_order_book_model->select_shoulder_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$shoulder_specs);
												if($shoulder_specs_result){
													foreach($shoulder_specs_result as $shoulder_specs_row){
														$shoulder_type=$shoulder_specs_row->SHOULDER_STYLE;
														$shoulder_orifice=$shoulder_specs_row->SHOULDER_ORIFICE;
														$shoulder_foil_tag=$shoulder_specs_row->SHOULDER_FOIL_TAG;								

													}
											    }

											    //CAP------------

											    $cap_code_result=$ci->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$cap_code);
											    
											    $cap_spec_id='';
											    $cap_spec_version='';

									    		foreach($cap_code_result as $cap_code_row){										
									    			$cap_spec_id=$cap_code_row->spec_id;
									    			$cap_spec_version=$cap_code_row->spec_version_no;
									    		}

									    		$cap_specs['spec_id']=$cap_spec_id;
												$cap_specs['spec_version_no']=$cap_spec_version;

												$cap_specs_result=$ci->sales_order_book_model->select_cap_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$cap_specs);
												if($cap_specs_result){
													foreach($cap_specs_result as $cap_specs_row){
														$cap_dia=$cap_specs_row->CAP_DIA;
														$cap_type=$cap_specs_row->CAP_STYLE;
														$cap_finish=$cap_specs_row->CAP_MOLD_FINISH;
														$cap_orifice=$cap_specs_row->CAP_ORIFICE;
														$cap_shrink_sleeve=$cap_specs_row->CAP_SHRINK_SLEEVE;							

													}
											    }


								    		}//SPECS MASTER

								        }//BOM RESULT

								    }//ELSE

								}//SPECS DETAILS	
						    
							    $unit_rate='';
								if($mrow->for_export=='1'){

									$unit_rate_in_rupees=$drow->calc_sell_price*$exchange_rate;

									$net_amount_in_rupees=$ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id'])*($unit_rate_in_rupees);


									$total_tax_in_rupees=$ci->common_model->read_number($drow->total_tax,$this->session->userdata['logged_in']['company_id'])*$exchange_rate;
									$freight_in_rupees=$ci->common_model->read_number($mrow->freight_amt,$this->session->userdata['logged_in']['company_id'])*$exchange_rate;
									$packaging_in_rupees=$ci->common_model->read_number($mrow->packagingcost,$this->session->userdata['logged_in']['company_id'])*$exchange_rate;
									$insurance_in_rupees=$ci->common_model->read_number($mrow->insu_amt,$this->session->userdata['logged_in']['company_id'])*$exchange_rate;
									$discount_in_ruppes=$ci->common_model->read_number($mrow->discountamount,$this->session->userdata['logged_in']['company_id'])*$exchange_rate;
									//$gross_amount_in_rupees=$drow->calc_sell_price*$exchange_rate;

									// if($mrow->invoice_date>='2019-06-01'){
									// 	$freight_in_rupees=$ci->common_model->read_number($mrow->freight_amt,$this->session->userdata['logged_in']['company_id']);
									// 	$packaging_in_rupees=$ci->common_model->read_number($mrow->packagingcost,$this->session->userdata['logged_in']['company_id']);
									// 	$insurance_in_rupees=$ci->common_model->read_number($mrow->insu_amt,$this->session->userdata['logged_in']['company_id']);
									// }else{

									// 	$freight_in_rupees=$ci->common_model->read_number($mrow->freight_amt,$this->session->userdata['logged_in']['company_id'])*$exchange_rate;
									//     $packaging_in_rupees=$ci->common_model->read_number($mrow->packagingcost,$this->session->userdata['logged_in']['company_id'])*$exchange_rate;
									// 	$insurance_in_rupees=$ci->common_model->read_number($mrow->insu_amt,$this->session->userdata['logged_in']['company_id'])*$exchange_rate;

									// }

								}else{//DOMESTIC--------------------------

									if($mrow->invoice_date>='2019-06-01'){

										$unit_rate_in_rupees=$ci->common_model->read_number($drow->selling_price,$this->session->userdata['logged_in']['company_id']);
										//$net_amount_in_rupees=$ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id'])*$unit_rate_in_rupees;
										$net_amount_in_rupees=$ci->common_model->read_number($drow->net_amount,$this->session->userdata['logged_in']['company_id']);	

										$total_tax_in_rupees=$ci->common_model->read_number($drow->total_tax,$this->session->userdata['logged_in']['company_id']);
										$freight_in_rupees=$ci->common_model->read_number($mrow->freight_amt,$this->session->userdata['logged_in']['company_id']);
										$packaging_in_rupees=$ci->common_model->read_number($mrow->packagingcost,$this->session->userdata['logged_in']['company_id']);
										$insurance_in_rupees=$ci->common_model->read_number($mrow->insu_amt,$this->session->userdata['logged_in']['company_id']);
										$discount_in_ruppes=$ci->common_model->read_number($mrow->discountamount,$this->session->userdata['logged_in']['company_id']);
										//$gross_amount_in_rupees=$drow->calc_sell_price*$exchange_rate;

									}else{

										//$unit_rate_in_rupees=$ci->common_model->read_number($drow->selling_price,$this->session->userdata['logged_in']['company_id']);
										
										$unit_rate_in_rupees=$ci->common_model->read_number($drow->selling_price,$this->session->userdata['logged_in']['company_id']);
										$net_amount_in_rupees=$ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id'])*$unit_rate_in_rupees;								

										$total_tax_in_rupees=$ci->common_model->read_number($drow->total_tax,$this->session->userdata['logged_in']['company_id']);
										$freight_in_rupees=$ci->common_model->read_number($mrow->freight_amt,$this->session->userdata['logged_in']['company_id']);
										$packaging_in_rupees=$ci->common_model->read_number($mrow->packagingcost,$this->session->userdata['logged_in']['company_id']);
										$insurance_in_rupees=$ci->common_model->read_number($mrow->insu_amt,$this->session->userdata['logged_in']['company_id']);
										$discount_in_ruppes=$ci->common_model->read_number($mrow->discountamount,$this->session->userdata['logged_in']['company_id']);
										//$gross_amount_in_rupees=$drow->calc_sell_price*$exchange_rate;




									}

								}
								

									echo "
									<td>".$status."</td>
									<td><a href='".base_url('index.php/sales_order_book/view/'.$drow->ref_ord_no)."' target=_blank>".$drow->ref_ord_no."</a></td>
									<!--<td>".$drow->article_no."<br/></td>
									<td>".$this->common_model->get_article_name($drow->article_no,$this->session->userdata['logged_in']['company_id'])."
									</td>
									<td>".$ci->common_model->view_date(($drow->deli_date!='0000-00-00'?$drow->deli_date:""),$this->session->userdata['logged_in']['company_id'])."</td>
									<td>-->	

									";
									
									echo"<td>".$dia."</td>
									<td>".$length."</td>
									<td>".($print_type_artwork==''? $print_type_bom : $print_type_artwork)."</td>
									<td><a href='".base_url('index.php/costsheet/view/'.$mrow->ar_invoice_no.'/'.$drow->ref_ord_no.'/'.$drow->article_no)."' target='_blank'>".$drow->article_no."</a></td>
									<td>".$this->common_model->get_article_name($drow->article_no,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".number_format($ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']),2,'.',',')."</td>
									<td>".$unit_rate_in_rupees."</td>
									<td>".number_format($net_amount_in_rupees,2)."</td>
									<td>";

									$master_array= array('article_no' =>$drow->article_no,'sales_ord_no'=>$drow->ref_ord_no,'archive'=>'0');
									$data1=array_filter($master_array);
									$data2['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from="",$to="",$this->session->userdata['logged_in']['company_id']);

										$total_total_rm=0;
														$total_rm=0;
														
															foreach($data2['job_card'] as $job_card_row){

																$query=$this->db->query("SELECT sum(reserved_quantity_manu.total_qty) as rm_summ,article_name_info.article_group_id FROM `reserved_quantity_manu` LEFT JOIN article_name_info  ON  reserved_quantity_manu.article_no=article_name_info.article_no AND reserved_quantity_manu.company_id=article_name_info.company_id where reserved_quantity_manu.manu_order_no='$job_card_row->mp_pos_no' and  article_name_info.article_group_id='7'");
																//echo $this->db->last_query();
																
																$arr=array();
																$a=0;
																$result2=$query->result();
																foreach($result2 as $rm_sum){
																	//echo $rm_sum->rm_summ;
																	$a=$this->common_model->read_number($rm_sum->rm_summ,$this->session->userdata['logged_in']['company_id']);
																	if(empty($a)){echo "";}
																	
																	$total_rm+=($a/$total_dispatch)*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);
																		
																	
																	}
																	
																	

																}

																echo round($total_rm,2);


								echo "</td>
								<td>".$this->costsheet_model->get_material_qty($spec_id,$spec_version_no,$ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']),'7')."</td>";

								$ldpe_diff=(round($total_rm,2)-$this->costsheet_model->get_material_qty($spec_id,$spec_version_no,$ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']),'7'))/$this->costsheet_model->get_material_qty($spec_id,$spec_version_no,$ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']),'7')*100;
								echo "<td>".round($ldpe_diff)."%</td>

								<td>";

									$master_array= array('article_no' =>$drow->article_no,'sales_ord_no'=>$drow->ref_ord_no,'archive'=>'0');
									$data1=array_filter($master_array);
									$data2['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from="",$to="",$this->session->userdata['logged_in']['company_id']);

										$total_total_rm=0;
														$total_rm=0;
														
															foreach($data2['job_card'] as $job_card_row){

																$query=$this->db->query("SELECT sum(reserved_quantity_manu.total_qty) as rm_summ,article_name_info.article_group_id FROM `reserved_quantity_manu` LEFT JOIN article_name_info  ON  reserved_quantity_manu.article_no=article_name_info.article_no AND reserved_quantity_manu.company_id=article_name_info.company_id where reserved_quantity_manu.manu_order_no='$job_card_row->mp_pos_no' and  article_name_info.article_group_id='8'");
																//echo $this->db->last_query();
																
																$arr=array();
																$a=0;
																$result2=$query->result();
																foreach($result2 as $rm_sum){
																	//echo $rm_sum->rm_summ;
																	$a=$this->common_model->read_number($rm_sum->rm_summ,$this->session->userdata['logged_in']['company_id']);
																	if(empty($a)){echo "";}
																	
																	$total_rm+=($a/$total_dispatch)*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);
																		
																	
																	}
																	
																	

																}

																echo round($total_rm,2);


								echo "</td>
								<td>".$this->costsheet_model->get_material_qty($spec_id,$spec_version_no,$ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']),'8')."</td>";

								$lldpe_diff=(round($total_rm,2)-$this->costsheet_model->get_material_qty($spec_id,$spec_version_no,$ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']),'8'))/$this->costsheet_model->get_material_qty($spec_id,$spec_version_no,$ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']),'8')*100;
								echo "<td>".round($lldpe_diff)."%</td><td>";

									$master_array= array('article_no' =>$drow->article_no,'sales_ord_no'=>$drow->ref_ord_no,'archive'=>'0');
									$data1=array_filter($master_array);
									$data2['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from="",$to="",$this->session->userdata['logged_in']['company_id']);

										$total_total_rm=0;
														$total_rm=0;
														
															foreach($data2['job_card'] as $job_card_row){

																$query=$this->db->query("SELECT sum(reserved_quantity_manu.total_qty) as rm_summ,article_name_info.article_group_id FROM `reserved_quantity_manu` LEFT JOIN article_name_info  ON  reserved_quantity_manu.article_no=article_name_info.article_no AND reserved_quantity_manu.company_id=article_name_info.company_id where reserved_quantity_manu.manu_order_no='$job_card_row->mp_pos_no' and  article_name_info.article_group_id='6'");
																//echo $this->db->last_query();
																
																$arr=array();
																$a=0;
																$result2=$query->result();
																foreach($result2 as $rm_sum){
																	//echo $rm_sum->rm_summ;
																	$a=$this->common_model->read_number($rm_sum->rm_summ,$this->session->userdata['logged_in']['company_id']);
																	if(empty($a)){echo "";}
																	
																	$total_rm+=($a/$total_dispatch)*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);
																		
																	
																	}
																	
																	

																}

																echo round($total_rm,2);


								echo "</td>
								<td>";

								$hdpe=0;
								$hdpe=$this->costsheet_model->get_material_qty($spec_id,$spec_version_no,$ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']),'6')+$this->costsheet_model->get_shoulder_material_qty($spec_id,$spec_version_no,$ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']),'6');
								echo $hdpe;
								echo "</td><td>";

								echo $hdpe_diff=round(((round($total_rm,2)-$hdpe)/$hdpe)*100)."%";

									echo "</td>";
								
																           

					    		}

									echo"</tr>";

									if($rowspan>1 && --$tr>0){
											echo'<tr>';
									}			

									$r++;

									//------TOTAL----------
									$sum_quantity+=$ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);
									$sum_net_amount+=$net_amount_in_rupees;
									$sum_total_tax+=$total_tax_in_rupees;

							}

						} //detail if	
						
					}


				 
				?>		
						</tbody>	
					</table>
					</div>
				</div>
				
				
				
				
				
			