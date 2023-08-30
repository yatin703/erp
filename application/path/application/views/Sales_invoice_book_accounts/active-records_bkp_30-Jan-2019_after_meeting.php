<script type="text/javascript">
$(document).ready(function() {
		$("#loading").hide();
		$("#cover").hide();


});
</script>

<div class="record_form_design">
		<div class="record_inner_design" style="overflow: scroll;">

				<table class="record_table_design_without_fixed" id="table-1">
					<thead>
						<tr>
							<th>Sr. No.</th>
							<th>Invoice No.</th>
							<th>Invoice Date</th>
							<th>Bill To</th>
							<th>Bill To GSTIN</th>
							<th>Ship To</th>
							<th>Ship To GSTIN</th>
							<th>Currency</th>
							<th>Exchange Rate</th>
							<th>So.No.</th>
							<th>Po No. / Po Date</th>
							<th>Article Code</th>
							<th>Article Name</th>
							<th>Delivery Date</th>
							<th>Spec</th>
							<th>Artwork</th>
							<th>Layer</th>
							<th>Dia</th>
							<th>Length</th>
							<th>Print Type</th>
							<th>Shoulder Type</th>
							<th>Shoulder Orifice</th>
							<th>Cap Dia</th>
							<th>Cap Type</th>
							<th>Cap Finish</th>
							<th>Cap Orifice</th>
							<th>Quantity</th>
							<th>Unit Rate</th>
							<th>Net Amount</th>
							<th>Total Tax</th>
							
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
							<th>Freight</th>
							<th>Packaging</th>
							<th>Insurance</th>
							<th>Discount</th>
							<th>Gross Amount</th>
							<th>Type</th>
							<th>Transporter</th>
							<th>LR No. Export</th>
							<th>LR Date Export</th>
							<th>LR No. Local</th>
							<th>LR Date Local</th>
							<th>Created By</th>
							
					
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

				    $n=1;
					foreach($ar_invoice_master as $mrow){

						// Article Search -------------------------------------
						$details_data=array();
						$details_data['ar_invoice_no']=$mrow->ar_invoice_no;
						if(!empty($this->input->post('article_no'))){
							$arr=explode("//",$this->input->post('article_no'));
							$article_no=$arr[1];
							$details_data['article_no']=$article_no;
						}
							
						$result=$ci->sales_invoice_book_model->active_details_records('ar_invoice_details',$details_data,$this->session->userdata['logged_in']['company_id']);
						//echo $this->db->last_query();
						
						$rowspan=count($result);
					    $tr=$rowspan;

					    if($rowspan>0){

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
							$exchange_rate=($mrow->exchange_rate!='0' ?$ci->common_model->read_number($mrow->exchange_rate,$this->session->userdata['logged_in']['company_id']):'');

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

							// Invoice Type---------------------------
							$invoice_type=$this->common_model->select_one_active_record('invoice_types_master_lang',$this->session->userdata['logged_in']['company_id'],'inv_type_id',$mrow->inv_type);
							foreach ($invoice_type as $invoice_type_row){
								$invoice_type=$invoice_type_row->lang_inv_type;
								
							}
								
							echo "<tr>
							<td rowspan='".$rowspan."'>".$n++."</td>
							<td rowspan='".$rowspan."'>".$mrow->ar_invoice_no."</td>
							<td rowspan='".$rowspan."'>".$ci->common_model->view_date($mrow->invoice_date,$this->session->userdata['logged_in']['company_id'])."</td>
							<td rowspan='".$rowspan."'>".$mrow->name1." (".strtoupper($mrow->lang_property_name).") </td>
							<td rowspan='".$rowspan."'>".$mrow->isdn_local."</td>
							<td rowspan='".$rowspan."'>".$ship_to."</td>
							<td rowspan='".$rowspan."'>".$ship_to_gst."</td>
							<td rowspan='".$rowspan."'>".$currency."</td>
							<td rowspan='".$rowspan."'>".$exchange_rate."</td>
							";


								
							$r=0;
							foreach ($result as $drow){

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
								$spec_id='';
								$spec_version_no='';
								$ad_id='';
								$version_no='';					
								

								//Order Info---------------------------------
								
								$order_no=$drow->ref_ord_no;								
								$order_master_result=$ci->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$order_no);
								
								$so_data=array();
								$so_data['order_no']=$drow->ref_ord_no;
								$so_data['article_no']=$drow->article_no;
								$so_result=$ci->sales_invoice_book_model->active_details_records('order_details',$so_data,$this->session->userdata['logged_in']['company_id']);
								//echo $this->db->last_query();

								

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
												$shoulder_type=$specs_row->SHOULDER_NECK_TYPE;
												$shoulder_orifice=$specs_row->SHOULDER_ORIFICE;
												$shoulder_foil=$specs_row->SHOULDER_FOIL_TAG;
												$cap_dia=$specs_row->CAP_DIA;
												$cap_type=$specs_row->CAP_STYLE;
												$cap_finish=$specs_row->CAP_MOLD_FINISH;
												$cap_orifice=$specs_row->CAP_ORIFICE;										

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

								}else{

									$unit_rate_in_rupees=$ci->common_model->read_number($drow->selling_price,$this->session->userdata['logged_in']['company_id']);
									$net_amount_in_rupees=$ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id'])*$unit_rate_in_rupees;								
									$total_tax_in_rupees=$ci->common_model->read_number($drow->total_tax,$this->session->userdata['logged_in']['company_id']);
									$freight_in_rupees=$ci->common_model->read_number($mrow->freight_amt,$this->session->userdata['logged_in']['company_id']);
									$packaging_in_rupees=$ci->common_model->read_number($mrow->packagingcost,$this->session->userdata['logged_in']['company_id']);
									$insurance_in_rupees=$ci->common_model->read_number($mrow->insu_amt,$this->session->userdata['logged_in']['company_id']);
									$discount_in_ruppes=$ci->common_model->read_number($mrow->discountamount,$this->session->userdata['logged_in']['company_id']);
									//$gross_amount_in_rupees=$drow->calc_sell_price*$exchange_rate;
								}
								

									echo"
									<td>".$drow->ref_ord_no."</td>
									<td>".($po_no!=''?$po_no." / ".$po_date:'')."</td>
									<td>".$drow->article_no."</td>
									<td>".$this->common_model->get_article_name($drow->article_no,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$ci->common_model->view_date(($drow->deli_date!='0000-00-00'?$drow->deli_date:""),$this->session->userdata['logged_in']['company_id'])."</td>
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
									<td><a href='".base_url()."/index.php/artwork_new/view/".$ad_id."/".$version_no." ' target='blank'>".($ad_id!=""? $ad_id."_R".$version_no:"")."</a></td>
									<td>".$layer_no."</td>
									<td>".$dia."</td>
									<td>".$length."</td>
									<td>".($print_type_artwork==''?$print_type_bom:$print_type_artwork)."</td>
									<td>".$shoulder_type."</td>
									<td>".$shoulder_orifice."</td>
									<td>".$cap_dia."</td>
									<td>".$cap_type."</td>
									<td>".$cap_finish."</td>
									<td>".$cap_orifice."</td>
									<td>".number_format($ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']),2,'.',',')."</td>
									<td>".$unit_rate_in_rupees."</td>
									<td>".number_format($net_amount_in_rupees,2)."</td>
									<td>".number_format($total_tax_in_rupees,2,'.',',')."</td>";

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
										 			echo number_format($arr[$j],2,'.',',');
										 			$total_array[$i]+=$arr[$j];
										 		}
										 		
										 	}
										 	$j++;

										}

										echo'</td>';

										$i++;


					    			}

					    			if($r==0){

					    				if($mrow->for_export==1){
					    					$gross_amount_in_rupees= $ci->common_model->read_number($mrow->totalpricewithtax,$this->session->userdata['logged_in']['company_id'])*$exchange_rate;
					    				}
					    				else{
					    					$gross_amount_in_rupees= $ci->common_model->read_number($mrow->totalpricewithtax,$this->session->userdata['logged_in']['company_id']);
					    				}
					    				

					    				$sum_gross_amount+=$gross_amount_in_rupees;
					    				$sum_freight+=$freight_in_rupees;
									    $sum_packaging+=$packaging_in_rupees;
									    $sum_insurance+=$insurance_in_rupees;
									    $sum_discount+=$discount_in_ruppes;

					    				echo"
										<td rowspan='".$rowspan."'>".number_format($freight_in_rupees,2,'.',',')."</td>
										<td rowspan='".$rowspan."'>".number_format($packaging_in_rupees,2,'.',',')."</td>
										<td rowspan='".$rowspan."'>".number_format($insurance_in_rupees,2,'.',',')."</td>
										<td rowspan='".$rowspan."'>".number_format($discount_in_ruppes,2,'.',',')."</td>
					    				<td rowspan='".$rowspan."'>".number_format($gross_amount_in_rupees,2,'.',',')."</td>
					    				<td rowspan='".$rowspan."'>".$invoice_type."</td>
					    				<td rowspan='".$rowspan."'>".$transporter_name."</td>
					    				<td rowspan='".$rowspan."'>".$lr_no."</td>
					    				<td rowspan='".$rowspan."'></td>
					    				<td rowspan='".$rowspan."'>".$lr_no_local."</td>
					    				<td rowspan='".$rowspan."'></td>
				    					<td class='ellipses' rowspan='".$rowspan."'>".substr(strtoupper($mrow->login_name),0,strpos($mrow->login_name,' '))."</td>";
								           
											

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
						<td colspan='26' style='text-align:right;'><b>TOTAL</b></td>
						<td><b>".number_format($sum_quantity,2,'.',',')."</b></td>
						<td></td>
						<td><b>".number_format($sum_net_amount,2,'.',',')."</b></td>
						<td><b>".number_format($sum_total_tax,2,'.',',')."</b></td>";
							$i=0;
							foreach ($tax_header as $row){
					    		echo'<td><b>'.number_format($total_array[$i],2,'.',',').'</b></td>';
					    		$i++;
					    	}
						echo"
						<td>".number_format($freight_in_rupees,2,'.',',')."</td>
						<td>".number_format($packaging_in_rupees,2,'.',',')."</td>
						<td>".number_format($insurance_in_rupees,2,'.',',')."</td>
						<td>".number_format($discount_in_ruppes,2,'.',',')."</td>
						 <td><b>".number_format($sum_gross_amount,2,'.',',')."</b></td>
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
					<div class="pagination"><?php echo $this->pagination->create_links();?></div>
								
	</div>
</div>