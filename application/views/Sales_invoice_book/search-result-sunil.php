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

							<th>Billing Address</th>
							<th>Telephone</th>
							<th>Ship To</th>
							<th>Order No.</th>
							<th>Oc Date</th>
							<th>Po No.</th>
							<th>Po Date</th>
							<th>Customer Product Code</th>
							<th>Dia</th>
							<th>Length</th>
							<th>Print Type</th>
							<th>Article No</th>
							<th>Article Description</th>
							<th>Dispatch Quantity</th>
							<th>Unit Rate</th>
							<th>Net Amount</th>
							<th>Spec</th>
							<th>Artwork</th>
							<th>Layer</th>
							<!--<th>Delivery Date</th>-->
							<th>Shoulder Type</th>
							<!--<th>Shoulder Orifice</th>
							<th>Cap Dia</th>-->
							<th>Cap Type</th>
							<th>Cap Finish</th>
							<th>Cap Shrink Sleeve</th>
							<th>Cap Orifice</th>						
													
							<?php 
								global $total_array;
								
								if($tax_header==FALSE){
									echo "<th></th>";
								}else{
									$i=0;
									foreach ($tax_header as $row){
							    		echo'<th>'.ucwords(strtolower($row->lang_tax_code_desc)).'</th>';
							    		$total_array[$i]=0;
							    		$i++;
							    	}
								}
							?>
							<th>Total Tax</th>	
							<th>Freight</th>
							<th>Packing</th>
							<th>Insurance</th>
							<!--<th>Discount</th>-->
							<th>TCS On Sale</th>
							<th>Gross Amount</th>
							<th>Type</th>
							<th>Transporter</th>
							<th>LR No. Export</th>
							<th>LR Date Export</th>
							<th>LR No. Local</th>
							<th>LR Date Local</th>
							<th>Created By</th>
							<th>Year</th>
							<th>Month</th>
							<th>Date Diff</th>
						<?php foreach($formrights as $formrights_row){ 
								echo ($formrights_row->modify=='1'?'<th>Action</th>':'');
						    }
						?>     
							
					
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

							<td rowspan='".$rowspan."'>".$mrow->strno." ".$mrow->name2." ".$mrow->street." ".$mrow->name3." PIN ".$mrow->city_code." STATE : ".strtoupper($this->common_model->get_state_name($mrow->zip_code,$this->session->userdata['logged_in']['company_id']))."</td>
							<td rowspan='".$rowspan."'>".$mrow->telephone1." </td>
							<!--<td rowspan='".$rowspan."'>".$mrow->isdn_local."</td>-->
							<td rowspan='".$rowspan."'>".$ship_to."</td>
							<!--<td rowspan='".$rowspan."'>".$ship_to_gst."</td>
							<td rowspan='".$rowspan."'>".$currency."</td>
							<td rowspan='".$rowspan."'>".$exchange_rate."</td>-->
							";


								
							$r=0;
							foreach ($result as $drow){

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
								$cust_product_no='';

								foreach ($order_master_result as $order_master_row) {
									$po_no=$order_master_row->cust_order_no;
									$po_date=$order_master_row->cust_order_date;
									$oc_date=$ci->common_model->view_date(($order_master_row->oc_date!='0000-00-00'?$order_master_row->oc_date:""),$this->session->userdata['logged_in']['company_id']);
									$cust_product_no=$order_master_row->cust_product_no;
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
								

									echo"
									<td><a href='".base_url('index.php/sales_order_book/view/'.$drow->ref_ord_no)."' target=_blank>".$drow->ref_ord_no."</a></td>
									<td>".$oc_date."</a></td>	

									<td>".$po_no."</td>
									<td>".($po_no!=''?$po_date:'')."</td>
									<td>".$cust_product_no."</td>

									<!--<td>".$drow->article_no."<br/></td>
									<td>".$this->common_model->get_article_name($drow->article_no,$this->session->userdata['logged_in']['company_id'])."
									</td>
									<td>".$ci->common_model->view_date(($drow->deli_date!='0000-00-00'? $drow->deli_date:""),$this->session->userdata['logged_in']['company_id'])."</td>
									<td>-->	

									";
									
									echo"<td>".$dia."</td>
									<td>".$length."</td>
									<td>".($print_type_artwork==''? $print_type_bom : $print_type_artwork)."</td>
									<td><a href='".base_url('index.php/costsheet/view/'.$mrow->ar_invoice_no.'/'.$drow->ref_ord_no.'/'.$drow->article_no)."' target='_blank'>".$drow->article_no."</a>
									</td>
									<td>".$this->common_model->get_article_name($drow->article_no,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".number_format($ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']),2,'.',',')."</td>
									<td>".$unit_rate_in_rupees."</td>
									<td>".number_format($net_amount_in_rupees,2)."</td>
									<td>";

									if(!empty($spec_id)){

											if(substr($spec_id,0,1)=="S"){
												echo "<a href='".base_url()."/index.php/specification/view/".$spec_id."/".$spec_version_no." ' target='blank'>".$spec_id."_".$spec_version_no."</a>";
											}else{
												$bom=array('bom_no'=>$spec_id,
													'bom_version_no'=>$spec_version_no);
												$data['bom']=$this->common_model->select_active_records_where("bill_of_material",$this->session->userdata['logged_in']['company_id'],$bom);
												
												foreach($data['bom'] as $bom_row){											
												echo "<a href='".base_url()."/index.php/bill_of_material/view/".$bom_row->bom_id."' target='blank'>".$spec_id."_".$spec_version_no."</a>";
												}									
											}
									}
									
									echo "</td>
									<td><a href='".base_url()."/index.php/artwork_new/view/".$ad_id."/".$version_no." ' target='blank'>".($ad_id!=""? $ad_id."_R".$version_no:"")."
										</a>
									</td>
									<td>".$layer_no."</td>
									<td>".$shoulder_type."</td>
									<!--<td>".$shoulder_orifice."</td>
									<td>".$cap_dia."</td>-->
									<td>".$cap_type."</td>
									<td>".$cap_finish."</td>
									<td>".$cap_shrink_sleeve."</td>
									<td>".$cap_orifice."</td>
									";
									$arr=explode("|",$drow->tax_grid_amount);
									$edit=$drow->tax_pos_no;
									$result=$ci->sales_invoice_book_model->select_tax('tax_grid_details',$this->session->userdata['logged_in']['company_id'],'tax_id',$edit,'priority');

									$i=0;
									foreach ($tax_header as $trow){

								    	echo'<td>';

								    	$j=0;
								    	foreach ($result as $row) {

										 	if($row->tax_code==$trow->tax_code){
										 		

										 		if($arr[$j]!=''){
										 			if($mrow->for_export=='1'){

										 				$single_tax=$arr[$j]*$exchange_rate;
										 				echo number_format($single_tax,2,'.',',');
										 				$total_array[$i]+=$single_tax;

										 			}else{

										 				echo number_format($arr[$j],2,'.',',');
										 				$total_array[$i]+=$arr[$j];
										 			}

										 			
										 		}
										 		
										 	}
										 	$j++;

										}

										echo'</td>';

										$i++;


					    			}
					    			echo"<td>".number_format($total_tax_in_rupees,2,'.',',')."</td>";

					    			if($r==0){

					    				if($mrow->for_export==1){
					    					$gross_amount_in_rupees= ($ci->common_model->read_number($mrow->totalpricewithtax,$this->session->userdata['logged_in']['company_id'])*$exchange_rate)+ $freight_in_rupees + $packaging_in_rupees + $insurance_in_rupees + $mrow->tcs_amt;
					    				}
					    				else{
					    					$gross_amount_in_rupees= $ci->common_model->read_number($mrow->totalpricewithtax,$this->session->userdata['logged_in']['company_id'])
					    					+ $freight_in_rupees + $packaging_in_rupees + $insurance_in_rupees + $mrow->tcs_amt;
					    				}
					    				

					    				$sum_gross_amount+=$gross_amount_in_rupees;
					    				$sum_freight+=$freight_in_rupees;
									    $sum_packaging+=$packaging_in_rupees;
									    $sum_insurance+=$insurance_in_rupees;
									    $sum_discount+=$discount_in_ruppes;
									    $sum_tcs+=$mrow->tcs_amt;

					    				echo"
										<td rowspan='".$rowspan."'>".number_format($freight_in_rupees,2,'.',',')."</td>
										<td rowspan='".$rowspan."'>".number_format($packaging_in_rupees,2,'.',',')."</td>
										<td rowspan='".$rowspan."'>".number_format($insurance_in_rupees,2,'.',',')."</td>
										<!--<td rowspan='".$rowspan."'>".number_format($discount_in_ruppes,2,'.',',')."</td>-->
										<td rowspan='".$rowspan."'>".($mrow->tcs_amt!=''?number_format($mrow->tcs_amt,2,'.',','):0)."</td>
					    				<td rowspan='".$rowspan."'>".number_format($gross_amount_in_rupees,2,'.',',')."</td>
					    				<td rowspan='".$rowspan."'>".strtoupper($invoice_type)."</td>
					    				<td rowspan='".$rowspan."'>".$transporter_name."</td>
					    				<td rowspan='".$rowspan."'>".$lr_no."</td>
					    				<td rowspan='".$rowspan."'></td>
					    				<td rowspan='".$rowspan."'>".$lr_no_local."</td>
					    				<td rowspan='".$rowspan."'></td>
				    					<td class='ellipses' rowspan='".$rowspan."'>".substr(strtoupper($mrow->login_name),0,strpos($mrow->login_name,' '))."</td>
				    					<td rowspan='".$rowspan."'>".$year."</td>
				    					<td rowspan='".$rowspan."'>".strtoupper($month)."</td>
				    					<td rowspan='".$rowspan."'>".$this->common_model->days_diffrence($oc_date,$mrow->invoice_date)."</td>
				    					";

				    					 foreach($formrights as $formrights_row){ 

											echo ($formrights_row->modify=='1'? '<td><a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$mrow->ar_invoice_no.'').'" target="_blank"><i class="edit icon"></i></a></td>' : '');

						   				}							           

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


				} 
				?>
				<?php  
					echo"<tr>
						<td colspan='16' style='text-align:right;'><b>TOTAL</b></td>
						<td><b>".number_format($sum_quantity,2,'.',',')."</b></td>
						<td>".number_format(($sum_quantity!=0?$sum_net_amount/$sum_quantity:0),2,'.',',')."</td>
						<td><b>".number_format($sum_net_amount,2,'.',',')."</b></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>";
							$i=0;
							foreach ($tax_header as $row){
					    		echo'<td><b>'.number_format($total_array[$i],2,'.',',').'</b></td>';
					    		$i++;
					    	}
						echo"
						<td><b>".number_format($sum_total_tax,2,'.',',')."</b></td>
						<td>".number_format($freight_in_rupees,2,'.',',')."</td>
						<td>".number_format($packaging_in_rupees,2,'.',',')."</td>
						<td>".number_format($insurance_in_rupees,2,'.',',')."</td>
						<!--<td>".number_format($discount_in_ruppes,2,'.',',')."</td>-->
						<td><b>".number_format($sum_tcs,2,'.',',')."</b></td>
						 <td><b>".number_format($sum_gross_amount,2,'.',',')."</b></td>
						 <td></td>
						 <td></td>
						 <td></td>
						 <td></td>
						 <td></td>
						 <td></td>
						 <td></td>
						 <td></td>
						 <td></td>
						 <td></td>


					</tr>";

				?>			
						</tbody>	
					</table>
					<table id="header-fixed"></table>
					<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>
				
				
				
				
				
			