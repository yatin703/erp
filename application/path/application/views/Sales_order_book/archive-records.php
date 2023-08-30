<script type="text/javascript">
$(document).ready(function() {
		$("#loading").hide();
		$("#cover").hide();

});
</script>

<div class="record_form_design">
		<div class="record_inner_design" style="overflow: scroll;">
				<table class="record_table_design_without_fixed"  >
						<tr>
							<th>Sr. No.</th>
							<th>Order No.</th>
							<th>Order Date</th>
							<th>Bill To</th>
							<!--<th>Bill To GSTIN</th>-->
							<th>Ship To</th>
							<!--<th>Ship To GSTIN</th>-->
							<th>Po No. / Po Date</th>
							<th>Currency</th>
							<th>Exchange Rate</th>
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
							<th>Cap dia</th>
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
							<th>Gross Amount</th>
							<th>Created By</th>
							<th>Approve By</th>
							<th>Approval Date</th>
							<th>Order Type</th>
							<th>Is Sample</th>
							<th>Status</th>							
							<th>Comments</th>
							<th>Action</th>
					
						</tr>
				<?php 

				$sum_quantity=0;
			    $sum_net_amount=0;
			    $sum_total_tax=0;
			    $sum_gross_amount=0;

				if($order_master==FALSE){
					echo "<tr><td colspan='24'>No Records Found</td></tr>";
				}
				else 
				{
					$ci =&get_instance();
					$ci->load->model('sales_order_book_model');
				    $ci->load->model('common_model');
				    $ci->load->model('article_model');
				    $ci->load->model('customer_model');				    

				    //MASTER ROW---------
				    
				    $n=1;
					foreach($order_master as $mrow){

						$details_data=array();
						$details_data['order_no']=$mrow->order_no;
						if(!empty($this->input->post('article_no'))){
							$arr=explode("//",$this->input->post('article_no'));
							$article_no=$arr[1];
							$details_data['article_no']=$article_no;
						}
							
						$result=$ci->sales_order_book_model->active_details_records('order_details',$details_data,$this->session->userdata['logged_in']['company_id']);
						//echo $this->db->last_query();
						
						$rowspan=count($result);
					    $tr=$rowspan;

					    if($rowspan>0){

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

							$currency=($mrow->currency_id!='' ? $mrow->currency_id:'');
							$exchange_rate=($mrow->exchange_rate!='0' ?number_format($ci->common_model->read_number($mrow->exchange_rate,$this->session->userdata['logged_in']['company_id']),2,'.',','):'');
								
							echo "<tr>
							<td rowspan='".$rowspan."'>".$n++."</td>
							<td rowspan='".$rowspan."'>".($mrow->final_approval_flag==1 ? "<i class='check circle icon'></i>" : "")." <a href=".base_url('index.php/'.$this->router->fetch_class().'/view/'.$mrow->order_no)." target='_blank'>".$mrow->order_no."</a></td>
							<td rowspan='".$rowspan."'>".$ci->common_model->view_date($mrow->order_date,$this->session->userdata['logged_in']['company_id'])."</td>
							<td rowspan='".$rowspan."'>".$mrow->name1." (".strtoupper($mrow->lang_property_name).") </td>
							<!--<td rowspan='".$rowspan."'>".$mrow->isdn_local."</td>-->
							<td rowspan='".$rowspan."'>".$ship_to."</td>
							<!--<td rowspan='".$rowspan."'>".$ship_to_gst."</td>-->
							<td rowspan='".$rowspan."'>".$mrow->cust_order_no." / ".$ci->common_model->view_date($mrow->cust_order_date,$this->session->userdata['logged_in']['company_id'])."</td>
							<td rowspan='".$rowspan."'>".$currency."</td>
							<td rowspan='".$rowspan."'>".$exchange_rate."</td>
							";

							//DETAILS ROW-----------------
								
							$r=0;
							foreach ($result as $drow){

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

								// $article_result=$ci->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$drow->article_no);
								
								// foreach($article_result as $article_row){
								// 	$article_name=$article_row->article_name.($article_row->article_sub_description!=''?' ('.$article_row->article_sub_description.')':'');

								// }


								//ARTWORK DEATILS--------

								if(!empty($drow->ad_id)){
									$artwork['ad_id']=$drow->ad_id;
									$artwork['version_no']=$drow->version_no;
									$search='';
									$from='';
									$to='';
									$artwork_result=$ci->artwork_model->active_record_search('artwork_devel_master',$artwork,$search,$from,$to,$this->session->userdata['logged_in']['company_id']);
									foreach ($artwork_result as $artwork_row) {
										$print_type_artwork=$artwork_row->print_type;
									}


								}
								$artwork['ad_id']=$drow->ad_id;
								$artwork['version_no']=$drow->version_no;

								// SLEEVE DETAILS-----
								if(!empty($drow->spec_id)){

									$specs['spec_id']=$drow->spec_id;
									$specs['spec_version_no']=$drow->spec_version_no;

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

								    	$bom_data['bom_no']=$drow->spec_id;
										$bom_data['bom_version_no']=$drow->spec_version_no;

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

						    

								if($mrow->for_export==1){

									$net_amount=$ci->common_model->read_number($drow->total_order_quantity,$this->session->userdata['logged_in']['company_id'])*$drow->calc_sell_price;

								}else{

									$net_amount=$ci->common_model->read_number($drow->total_order_quantity,$this->session->userdata['logged_in']['company_id'])* $ci->common_model->read_number($drow->selling_price,$this->session->userdata['logged_in']['company_id']);
								}

								//---NEW STATUS ADDED ON DEMAND OF PRAJAKTA----------------------------------------------
									// Tolerance-----------------
									$address_master_result=$ci->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'adr_company_id',$mrow->customer_no);

									foreach ($address_master_result as $address_master_row) {

										$total_order_quantity=$ci->common_model->read_number($drow->total_order_quantity,$this->session->userdata['logged_in']['company_id']);									
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

									// Conditions-----------------
									$total_arid_qty=0;
									$supplyqty=0;
									$cancel_qty=0;
									$search_arr=array('ref_ord_no'=>$drow->order_no,
													  'article_no'=>$drow->article_no);
									
									$ar_invoice_details_result=$this->common_model->select_active_records_where('ar_invoice_details',$this->session->userdata['logged_in']['company_id'],$search_arr);

									foreach ($ar_invoice_details_result as $ar_invoice_details_row) {
										$total_arid_qty+=$ar_invoice_details_row->arid_qty;
									}

									$supplyqty=$ci->common_model->read_number($total_arid_qty,$this->session->userdata['logged_in']['company_id']);

									if($mrow->trans_closed==1){
										if($supplyqty==0)
										{	$status="Cancel Order";
											$cancel_qty=$total_order_quantity;
										}else if($supplyqty<$minus_factory_dispatch_qty){																
											$status="Manual Closed (Order cancelled from customer end) ".($drow->pr_pos_complete_flag==0?"(INV)":"(PR)")."";
											$cancel_qty=number_format($total_order_quantity- $supplyqty,2,'.',',');
											$status.=number_format($total_order_quantity - $supplyqty,2,'.',',');
										}
										else if($supplyqty<$minus_tolerance_qty && $supplyqty>$minus_factory_dispatch_qty){																
											$status="Manual Closed (Below Tolerance) ".($drow->pr_pos_complete_flag==0?"(INV)":"(PR)")."";
											$cancel_qty=number_format($total_order_quantity - $supplyqty,2,'.',',');
											$status.=number_format($total_order_quantity - $supplyqty,2,'.',',');
										}
										elseif($supplyqty>=$minus_tolerance_qty && $supplyqty<$total_order_quantity){
											$status="Short Closed ".($drow->pr_pos_complete_flag==0?"(INV)":"(PR)")."";
											//$cancel_qty=number_format(get_value($row_order_details['total_order_quantity'])- $supplyqty,2,'.',',');
											$status.=number_format($total_order_quantity- $supplyqty,2,'.',',');
										}
										else{
											
											$status="Completed ".($drow->pr_pos_complete_flag==0?"(INV)":"(PR)")."";
										}
										
									}else{
										
										
										if($total_order_quantity<=$supplyqty && $supplyqty<>0){
											$status="Completed ".($drow->pr_pos_complete_flag==0?"(INV)":"(PR)")."";
											//$status="Completed (INV)";
										}
										elseif($total_order_quantity>$supplyqty && $supplyqty<>0){
											$status="Partially Completed ".($drow->pr_pos_complete_flag==0?"(INV)":"(PR)")."";
											//$status="Partially Completed (INV)";
											$status.=number_format($total_order_quantity- $supplyqty,2,'.',',');
										}
										else{
											
											$status="Pending";
										}
										
									}


								//---------------------------------------------------------------------------------------
								
								

									echo"
									<td>".$drow->article_no."</td>
									<td>".$this->common_model->get_article_name($drow->article_no,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$ci->common_model->view_date(($drow->delivery_date!='0000-00-00'?$drow->delivery_date:""),$this->session->userdata['logged_in']['company_id'])."</td>
									<td>";
									if(!empty($drow->spec_id)){

											if(substr($drow->spec_id,0,1)=="S"){
												echo "<a href='".base_url()."/index.php/specification/view/".$drow->spec_id."/".$drow->spec_version_no." ' target='blank'>".$drow->spec_id."_".$drow->spec_version_no."</a>";
											}else{
												$bom=array('bom_no'=>$drow->spec_id,
													'bom_version_no'=>$drow->spec_version_no);
												$data['bom']=$this->common_model->select_active_records_where("bill_of_material",$this->session->userdata['logged_in']['company_id'],$bom);
												
												foreach($data['bom'] as $bom_row){											
												echo "<a href='".base_url()."/index.php/bill_of_material/view/".$bom_row->bom_id."' target='blank'>".$drow->spec_id."_".$drow->spec_version_no."</a>";
												}									
											}
									}
									
									echo "</td>
									<td><a href='".base_url()."/index.php/artwork/view/".$drow->ad_id."/".$drow->version_no." ' target='blank'>".($drow->ad_id!=""? $drow->ad_id."_R".$drow->version_no:"")."</a></td>
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

									<td>".number_format($ci->common_model->read_number($drow->total_order_quantity,$this->session->userdata['logged_in']['company_id']),2,'.',',')."</td>
									<td>".number_format($ci->common_model->read_number($drow->selling_price,$this->session->userdata['logged_in']['company_id']),2,'.',',')."</td>
									<td>".number_format($net_amount,2,'.',',')."</td>

									<td>".number_format($ci->common_model->read_number($drow->total_tax,$this->session->userdata['logged_in']['company_id']),2,'.',',')."</td>
									
									";
									$arr=explode("|",$drow->tax_grid_amount);

									$edit=$drow->tax_pos_no;
									$result=$ci->sales_order_book_model->select_tax('tax_grid_details',$this->session->userdata['logged_in']['company_id'],'tax_id',$edit,'priority');

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

					    				$sum_gross_amount+=$ci->common_model->read_number($mrow->total_amount,$this->session->userdata['logged_in']['company_id']);

					    				echo"<td rowspan='".$rowspan."'>".number_format($ci->common_model->read_number($mrow->total_amount,$this->session->userdata['logged_in']['company_id']),2,'.',',')."</td>
					    					<td class='ellipses' rowspan='".$rowspan."'><a class='ui tiny label'><i class='user icon'></i>".substr(strtoupper($mrow->login_name),0,strpos($mrow->login_name,' '))."</a></td>
											<td class='ellipses' rowspan='".$rowspan."'>".($mrow->final_approval_flag==1 ? "<a class='ui tiny label'><i class='checkmark box icon'></i>".substr(strtoupper($ci->common_model->get_user_name($mrow->approved_by,$this->session->userdata['logged_in']['company_id'])),0,strpos($ci->common_model->get_user_name($mrow->approved_by,$this->session->userdata['logged_in']['company_id']),' '))."</a>" : '')."</td>
								            <td  rowspan='".$rowspan."'>".$ci->common_model->view_date($mrow->approval_date,$this->session->userdata['logged_in']['company_id'])."</td>
								            <td  rowspan='".$rowspan."'>".($mrow->for_export==1 ? "EXPORT":"LOCAL")."</td>
								            <td  rowspan='".$rowspan."'>".($mrow->for_sampling==1 ? "SAMPLE":"")."</td>
								            <td  rowspan='".$rowspan."'>".$status."</td>
											<td  rowspan='".$rowspan."'>".$mrow->lang_addi_info."</td>
											<td rowspan='".$rowspan."'>";
											foreach($formrights as $formrights_row){ 
												echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$mrow->order_no.'').'" target="_blank"><i class="print icon"></i></a> ' : '');
												echo ($formrights_row->modify==1 && $mrow->final_approval_flag<>1 && $mrow->pending_flag<>1 && $mrow->trans_closed<>1 && $mrow->user_id==$this->session->userdata['logged_in']['user_id'] ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$mrow->order_no.'').'"><i class="edit icon"></i></a> ' : '');
												echo ($mrow->archive<>1 && $formrights_row->delete==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$mrow->order_no.'').'"><i class="trash icon"></i></a> ' : '');

												
												
											}
											echo "</td>";

					    			}

									echo"</tr>";
									if($rowspan>1 && --$tr>0){
											echo'<tr>';
									}			

									$r++;

									//------TOTAL----------
									$sum_quantity+=$ci->common_model->read_number($drow->total_order_quantity,$this->session->userdata['logged_in']['company_id']);
									$sum_net_amount+=$net_amount;
									$sum_total_tax+=$ci->common_model->read_number($drow->total_tax,$this->session->userdata['logged_in']['company_id']);

							}

						}//detail if	
						
					}


				} 
				?>
				<?php  
					echo"<tr>
						<td colspan='23' style='text-align:right;'><b>TOTAL</b></td>
						<td><b>".number_format($sum_quantity,2,'.',',')."</b></td>
						<td></td>
						<td><b>".number_format($sum_net_amount,2,'.',',')."</b></td>
						<td><b>".number_format($sum_total_tax,2,'.',',')."</b></td>";
							$i=0;
							foreach ($tax_header as $row){
					    		echo'<td><b>'.number_format($total_array[$i],2,'.',',').'</b></td>';
					    		$i++;
					    	}
						echo"<td><b>".number_format($sum_gross_amount,2,'.',',')."</b></td>
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
					</table>
					<div class="pagination"><?php echo $this->pagination->create_links();?></div>

				
				</div>
			
				
			
						
	</div>
</div>