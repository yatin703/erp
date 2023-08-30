<script type='text/javascript'>	
function chkall(source) {
	checkboxes = document.getElementsByName('costsheet_id[]');
	for(var i=0, n=checkboxes.length;i<n;i++) {
		checkboxes[i].checked = source.checked;
	}
}
</script>
<div class="record_form_design">
<h4>Search Records From <?php echo $this->input->post('from_date');?> TO <?php echo $this->input->post('to_date');?> <i>Note : Green color records states the specific order numbers dispatches has been completed and closed</i></h4>
	 <div class="record_inner_design" style="overflow: scroll;">
					<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/compare');?>" method="POST" target="_blank">

						<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
						<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
						<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
					<table class="record_table_design_without_fixed">
					<thead>
						<tr>
							<th><div class='ui checkbox'><input type="checkbox" name="all_chk[]" onClick="chkall(this)"><label>Select All</label></div></th>
							<th>Invoice Date</th>
							<th>Invoice No.</th>
							<th>Bill To</th>
							<th>Order No.</th>
							<th>Order Status</th>
							<th>Dia</th>
							<th>Length</th>
							<th>Print Type</th>
							<th>Article No</th>
							<th>Article Description</th>
							<th>Dispatch Quantity</th>
							<th>Unit Rate</th>
							<th>Net Amount</th>
							<th>Spec</th>
							<th>Metalization</th>
							<th width="4000px">
								<?php
								$query=$this->db->query("SELECT DISTINCT article_name_info.article_group_id, article_name_info.main_group_id, article_group_desc.lang_article_group_desc
									FROM `reserved_quantity_manu`
									LEFT JOIN article_name_info ON reserved_quantity_manu.article_no = article_name_info.article_no
									LEFT JOIN article_group_desc ON article_group_desc.article_group_id = article_name_info.article_group_id
									WHERE reserved_quantity_manu.company_id = article_name_info.company_id
									AND reserved_quantity_manu.`date_required`
									BETWEEN '2018-04-01'
									AND '".$this->input->post('to_date')."'
									AND reserved_quantity_manu.type_flag =2
									AND article_name_info.main_group_id <>5
									AND article_group_desc.lang_article_group_desc IS NOT NULL
									GROUP BY article_name_info.article_group_id
									ORDER BY article_name_info.main_group_id ASC");

								$result=$query->result();	
								?>
								<table style="width:4000px;border: none;" cellspacing="0" cellpadding="0">
									<tr>
										<td style="width:200px;">JOBCARD</td>
										<?php 
										$i=0;
										global $total_array;
										foreach($result as $row_rm){
											echo "<td width='200px'>".substr($row_rm->lang_article_group_desc,0,5)."</td>";
											$total_array[$i]=0;
											$i++;
										}

										$total_array_cap=0;
										?>

										<td style="width:200px;">CAP</td>
										<td style="width:200px;">LABEL</td>
										<td style="width:200px;">SHD</td>
										<td style="width:200px;">EDGE BOA</td>
										<td style="width:200px;">DESICCANT</td>
										<td style="width:200px;">PALLETS</td>
										<td style="width:200px;">SHRNK FLM</td>
										<td style="width:200px;">BOPP TAPE</td>
										<td style="width:200px;">STICKERS</td>
										<td style="width:200px;">OTHER PM</td>
										<td style="width:200px;">LOCAL SPA</td>
										<td style="width:200px;">IMPORT SPA</td>
										<td style="width:200px;">SCR INK</td>
										<td style="width:200px;">OFF INK</td>
										<td style="width:200px;">FLX INK</td>
										<td style="width:200px;">DIGI INK</td>
										<td style="width:200px;">NO OF SCREN</td>
										<td style="width:200px;">SCREENS</td>
										<td style="width:200px;">NO OFF PLAT</td>
										<td style="width:200px;">OFFSET PLA</td>
										<td style="width:200px;">NO FLX PLAT</td>
										<td style="width:200px;">FLEXO PLA</td>
										<td style="width:200px;">UV</td>
										<td style="width:200px;">DECO</td>
										<td style="width:200px;">OTR CON</td>
										<td style="width:200px;">HYG CON</td>
										<td style="width:200px;">OTHER CON</td>
										<td style="width:200px;">FREIGHT</td>
										<td style="width:200px;">TOTAL COST</td>
										<td style="width:200px;">COST/TUBE</td>
										<td style="width:200px;">C/TUBE</td>
									</tr>
								</table>
							</th>
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
						    $sum_cap=0;
							$sum_shd=0;
						    $sum_label=0;
							$sum_shoulder=0;
						    $sum_edge_board=0;
						    $sum_desiccant=0;
						    $sum_pallet=0;
						    $sum_shrink_flim=0;
						    $sum_bopp_tape=0;
						    $sum_stickers=0;
						    $sum_other_pm=0;
						    $sum_local_spares=0;
						    $sum_import_spares=0;
						    $sum_screen_ink=0;
						    $sum_offset_ink=0;
						    $sum_flexo_ink=0;
						    $sum_digital_ink=0;
						    $sum_screens=0;
						    $sum_offset_plates=0;
						    $sum_flexo_plates=0;
						    $sum_uv=0;
						    $sum_decoseam_consumable=0;
						    $sum_other_consumable=0;
						    $sum_hygenic_consumable=0;
						    $sum_other_mix_consumable=0;
						    $sum_freight=0;
						    $sum_total_rm=0;
							foreach($ar_invoice_master as $mrow){

								

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

								if($this->input->post('order_no')!=''){

									$details_data['ref_ord_no']=$this->input->post('order_no');
									
								}

								if($this->input->post('print_type')!=''){
									$print=$this->input->post('print_type');

								}else{
									$print="";
								}
								$list_arr=array('0');
								$result=$this->costsheet_model->active_details_records('ar_invoice_details',$details_data,$print,$this->session->userdata['logged_in']['company_id'],$list_arr);
								//echo $this->db->last_query();
								//print_r($result);
								
								$rowspan=count($result);
							   // $tr=$rowspan;

							    if($rowspan>0){
							    	// Month And Year----
							    	$time=strtotime($mrow->invoice_date);
									$month=date("F",$time);
									$year=date("Y",$time);

									// Currency Details----------------------------------------
									//$currency=($mrow->currency_id!='' ? $mrow->currency_id:'');
									//$exchange_rate=($mrow->exchange_rate!='0' ?$ci->common_model->read_number($mrow->exchange_rate,$this->session->userdata['logged_in']['company_id']):'');
									
									
									$currency=($mrow->currency_id!='' ? $mrow->currency_id:'');
									if($mrow->invoice_date>='2019-06-01'){
									$exchange_rate=($mrow->exchange_rate!='0' ?$mrow->exchange_rate:'');
									}
									else{
										$exchange_rate=($mrow->exchange_rate!='0' ?$ci->common_model->read_number($mrow->exchange_rate,$this->session->userdata['logged_in']['company_id']):'');
									}

									foreach ($result as $drow){


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
										$so_result=$this->sales_invoice_book_model->active_details_records('order_details',$so_data,$this->session->userdata['logged_in']['company_id']);
										// echo $this->db->last_query();

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
										$cap_metalization="";	

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

										//ARTWORK DEATILS-----------------
										if(!empty($ad_id)){

											$artwork['ad_id']=$ad_id;
											$artwork['version_no']=$version_no;
											$search='';
											$from='';
											$to='';
											$artwork_result=$ci->artwork_model->active_record_search('artwork_devel_master',$artwork,$search,$from,$to,$this->session->userdata['logged_in']['company_id']);
											if($artwork_result){
											foreach ($artwork_result as $artwork_row) {
												$print_type_artwork=$artwork_row->print_type;
											}
											}else{
												$artwork_result=$this->artwork_springtube_model->active_record_search('springtube_artwork_devel_master',$artwork,$search,$from,$to,$this->session->userdata['logged_in']['company_id']);
			     								$this->db->last_query();
									            if($artwork_result){
													foreach ($artwork_result as $artwork_row) {
									                $print_type_artwork=$artwork_row->print_type;
													}
												}else{
													$print_type_artwork="";
												}
											}

										}else{
											$print_type_artwork="";
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

													}
											    }


											   $specs_lang_result=$this->common_model->select_active_records_where('specification_sheet_lang',$this->session->userdata['logged_in']['company_id'],$specs);
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
																	$cap_mb=$cap_specs_row->CAP_MASTER_BATCH;
																	$cap_foil=$this->common_model->get_article_name($cap_specs_row->CAP_FOIL_CODE,$this->session->userdata['logged_in']['company_id']);
																	$cap_shrink_sleeve=$this->common_model->get_article_name($cap_specs_row->CAP_SHRINK_SLEEVE_CODE,$this->session->userdata['logged_in']['company_id']);
																	$cap_metalization=$cap_specs_row->CAP_METALIZATION;							

																}
														    }
													    

													   

										    		}//SPECS MASTER

										        }//BOM RESULT

										    }//ELSE

										}//SPECS DETAILS	
								    
									    $unit_rate='';
										if($mrow->for_export=='1'){

											$unit_rate_in_rupees=$drow->calc_sell_price*$ci->common_model->read_number($exchange_rate,$this->session->userdata['logged_in']['company_id']);
											$net_amount_in_rupees=$ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id'])*($unit_rate_in_rupees);
											$total_tax_in_rupees=$ci->common_model->read_number($drow->total_tax,$this->session->userdata['logged_in']['company_id'])*$exchange_rate;
											//$gross_amount_in_rupees=$drow->calc_sell_price*$exchange_rate;

										}else{

											$unit_rate_in_rupees=$ci->common_model->read_number($drow->selling_price,$this->session->userdata['logged_in']['company_id']);
											$net_amount_in_rupees=$ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id'])*$unit_rate_in_rupees;								
											$total_tax_in_rupees=$ci->common_model->read_number($drow->total_tax,$this->session->userdata['logged_in']['company_id']);
											//$gross_amount_in_rupees=$drow->calc_sell_price*$exchange_rate;
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


									// Conditions-----------------
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

							if($print_type_artwork==""){
								$print_type_artwork=$print_type_bom;
							}
						//---------------------------------------------------------------------------------------
						
											$total_sum_of_rm=0;
											$status="";
											$status=$this->sales_order_book_model->get_order_status($drow->ref_ord_no);
											$flag=0;
											if($status=="Completed"){
												$flag=1;
											}else{
												$flag=0;
											}

											echo "<tr ".($this->sales_order_book_model->get_order_status($drow->ref_ord_no)=='Completed' ? 'style="background-color:#c2fbc2"' : '')." >
											<td><div class='ui checkbox'>
											<input type='checkbox' name='costsheet_id[]' value='$mrow->ar_invoice_no/$drow->ref_ord_no/$drow->article_no/$status/$flag/$drow->ar_pos_no'><label>".$n++."</label></div></td>
											<td>".$ci->common_model->view_date($mrow->invoice_date,$this->session->userdata['logged_in']['company_id'])."</td>
											<td><a href='".base_url('index.php/costsheet/view/'.$mrow->ar_invoice_no.'/'.$drow->ref_ord_no.'/'.$drow->article_no)."' target='_blank'>".$mrow->ar_invoice_no."</a></td>
											<td>".$mrow->name1."</td>
											<td><a href=".base_url('index.php/sales_order_book/view/'.$drow->ref_ord_no)." target='_blank'>".$drow->ref_ord_no."</a></td>
											<td>".$status."</td>
											<td>".$dia."</td>
											<td>".$length."</td>
											<td>".($print_type_artwork=='' ? $print_type_bom : $print_type_artwork)."</td>
											<td>".$drow->article_no."</td>
											<td>".$this->common_model->get_article_name($drow->article_no,$this->session->userdata['logged_in']['company_id'])."</td>
											<td>".number_format($ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']),2,'.',',')."</td>
											<td>".$unit_rate_in_rupees."</td>
											<td>".number_format($net_amount_in_rupees,2)."</td><td>";

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
											
											echo "&nbsp;
												<a href='".base_url()."/index.php/artwork_new/view/".$ad_id."/".$version_no." ' target='blank'>".($ad_id!=""? $ad_id."_R".$version_no:"")."
												</a></td>";

												?>

											<td><?php echo $cap_metalization;?></td>	
											<td width="4000px">
											<?php
											$query=$this->db->query("SELECT DISTINCT article_name_info.article_group_id, article_name_info.main_group_id, article_group_desc.lang_article_group_desc
												FROM `reserved_quantity_manu`
												LEFT JOIN article_name_info ON reserved_quantity_manu.article_no = article_name_info.article_no
												LEFT JOIN article_group_desc ON article_group_desc.article_group_id = article_name_info.article_group_id
												WHERE reserved_quantity_manu.company_id = article_name_info.company_id
												AND reserved_quantity_manu.`date_required`
												BETWEEN '2018-04-01'
												AND '".$this->input->post('to_date')."'
												AND reserved_quantity_manu.type_flag =2
												AND article_name_info.main_group_id <>5
												AND article_group_desc.lang_article_group_desc IS NOT NULL
												GROUP BY article_name_info.article_group_id
												ORDER BY article_name_info.main_group_id ASC");

											$result=$query->result();	
											?>
											<table style="width:4000px;border: none;" cellspacing="0" cellpadding="0">
												<tr>
													<td style="width:195px;">

														<table style="border:none;" cellspacing="0" cellpadding="0">
															<?php
															foreach($data2['job_card'] as $job_card_row){
																$job_card_data= array('manu_order_no'=>$job_card_row->mp_pos_no,'sales_order_no'=>$drow->ref_ord_no);
																$data3=array_filter($job_card_data);
																$data4['job_card_rm_details']=$this->common_model->select_one_active_record_nonlanguage_without_archives_order_by('reserved_quantity_manu',$this->session->userdata['logged_in']['company_id'],$data3,'',$order_by="");

																echo "<tr><td style='border:none;'>";

																	if(strtoupper(substr($spec_id,0,1))=="B"){
																		echo "<a href='".base_url('index.php/sales_order_item_parameterwise/view_new/'.$job_card_row->mp_pos_no.'/'.$spec_id.'/'.$spec_version_no.'')."' target='_blank'>$job_card_row->mp_pos_no</a>&nbsp;";
																	}else{
																		echo "<a href='".base_url('index.php/sales_order_item_parameterwise/view/'.$job_card_row->mp_pos_no.'/'.$spec_id.'/'.$spec_version_no.'')."' target='_blank'>$job_card_row->mp_pos_no</a>&nbsp;";
																	}
																	echo "</td></tr>";
																}
																?>
														</table>
													</td>
													<?php 
													$i=0;
													$total_sum_rm=0;
													foreach($result as $row_rm){
												echo "<td width='190px'>";

														$master_array= array('article_no' =>$drow->article_no,'sales_ord_no'=>$drow->ref_ord_no);
														$data1=array_filter($master_array);
														$data2['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from="",$to="",$this->session->userdata['logged_in']['company_id']);

														$total_total_rm=0;
														$total_rm=0;
														
														echo "<table style='border:none;'' cellspacing='0' cellpadding='0'>";
															foreach($data2['job_card'] as $job_card_row){

																echo "<tr><td style='border:none;'>";
																$query=$this->db->query("SELECT sum(reserved_quantity_manu.total_qty)*reserved_quantity_manu.calculated_purchase_price as rm_sum,article_name_info.article_group_id FROM `reserved_quantity_manu` LEFT JOIN article_name_info  ON  reserved_quantity_manu.article_no=article_name_info.article_no AND reserved_quantity_manu.company_id=article_name_info.company_id where reserved_quantity_manu.manu_order_no='$job_card_row->mp_pos_no' and  article_name_info.article_group_id='$row_rm->article_group_id' group by reserved_quantity_manu.calculated_purchase_price");
																
																$total_rm=0;
																$arr=array();
																$j=0;
																$result2=$query->result();
																foreach($result2 as $rm_sum){
																	$a=$this->common_model->read_number($rm_sum->rm_sum,$this->session->userdata['logged_in']['company_id']);
																	if(empty($a)){echo "";}
																	$total_rm+=$this->common_model->read_number(($a/$total_dispatch)*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']),$this->session->userdata['logged_in']['company_id']);
																	if($rm_sum->article_group_id==$row_rm->article_group_id){
																			$total_array[$i]+=($a/$total_dispatch)*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);
																		}
																		$j++;
																	}
																	echo number_format($total_rm,2);
																	$total_sum_rm+=$total_rm;
																echo "</td></tr>";

																}

																 

															echo "</table>
													</td>";
														$i++;
													}?>
													<td style="width:200px;">
														<table style='border:none;' cellspacing='0' cellpadding='0'>
														<?php 
														
							                          	$total_total_cap=0;
							                          	foreach($data2['job_card'] as $job_card_row){
							                          		echo "<tr><td style='border:none;'>";
							                          		$query=$this->db->query("SELECT sum(reserved_quantity_manu.qty)*reserved_quantity_manu.calculated_purchase_price as rm_sum,article_name_info.article_group_id FROM `reserved_quantity_manu` LEFT JOIN article_name_info  ON  reserved_quantity_manu.article_no=article_name_info.article_no AND reserved_quantity_manu.company_id=article_name_info.company_id where reserved_quantity_manu.manu_order_no='$job_card_row->mp_pos_no' and  article_name_info.main_group_id IN ('47','7') and reserved_quantity_manu.qty<>0");
							                          		$this->db->last_query();
							                          		$result2=$query->result();
							                          		$total_cap=0;
							                          		foreach($result2 as $rm_sum){

							                          			$c=$this->common_model->read_number($rm_sum->rm_sum,$this->session->userdata['logged_in']['company_id']);
							                          			//echo number_format(($this->common_model->read_number($c,$this->session->userdata['logged_in']['company_id'])));

																echo number_format(($this->common_model->read_number($c,$this->session->userdata['logged_in']['company_id']))/$total_dispatch*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']),2);

																$total_cap+=($this->common_model->read_number($c,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);



							                          		}
							                          		echo"</td></tr>";
							                          		$total_total_cap+=$total_cap;
							                          	}
							                          	//echo $total_total_cap;
							                          	?>
							                          </table>
													</td>
													<td style="width:200px;">

														<table style='border:none;' cellspacing='0' cellpadding='0'>
														<?php 
														
							                          	$total_total_label=0;
							                          	foreach($data2['job_card'] as $job_card_row){
							                          		echo "<tr><td style='border:none;'>";
							                          		$query=$this->db->query("SELECT sum(reserved_quantity_manu.qty)*reserved_quantity_manu.calculated_purchase_price as rm_sum,article_name_info.article_group_id FROM `reserved_quantity_manu` LEFT JOIN article_name_info  ON  reserved_quantity_manu.article_no=article_name_info.article_no AND reserved_quantity_manu.company_id=article_name_info.company_id where reserved_quantity_manu.manu_order_no='$job_card_row->mp_pos_no' and  article_name_info.main_group_id='5' and reserved_quantity_manu.qty<>0");
							                          		//echo $this->db->last_query();
							                          		$result2=$query->result();
							                          		$total_label=0;
							                          		foreach($result2 as $rm_sum){

							                          			$c=$this->common_model->read_number($rm_sum->rm_sum,$this->session->userdata['logged_in']['company_id']);

																echo number_format(($this->common_model->read_number($c,$this->session->userdata['logged_in']['company_id']))/$total_dispatch*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']),2);

																$total_label+=($this->common_model->read_number($c,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);
																
							                          		}
							                          		echo"</td></tr>";

							                          		$total_total_label+=$total_label;
							                          		
							                          	}
							                          	?>
							                          </table>

													</td>
													<td style="width:200px;">

														<table style='border:none;' cellspacing='0' cellpadding='0'>
														<?php 
														
							                          	$total_total_shoulder=0;
							                          	foreach($data2['job_card'] as $job_card_row){
							                          		echo "<tr><td style='border:none;'>";
							                          		$query=$this->db->query("SELECT reserved_quantity_manu.qty*reserved_quantity_manu.calculated_purchase_price as rm_sum,article_name_info.article_group_id FROM `reserved_quantity_manu` LEFT JOIN article_name_info  ON  reserved_quantity_manu.article_no=article_name_info.article_no AND reserved_quantity_manu.company_id=article_name_info.company_id where reserved_quantity_manu.manu_order_no='$job_card_row->mp_pos_no' and  article_name_info.main_group_id='41'");
							                          			//echo $this->db->last_query();
							                          		$result2=$query->result();
							                          		$total_shoulder=0;
							                          		foreach($result2 as $rm_sum){

							                          			$c=$this->common_model->read_number($rm_sum->rm_sum,$this->session->userdata['logged_in']['company_id']);

																number_format(($this->common_model->read_number($c,$this->session->userdata['logged_in']['company_id']))/$total_dispatch*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']),2);

																$total_shoulder+=($this->common_model->read_number($c,$this->session->userdata['logged_in']['company_id'])/$total_dispatch)*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);
																
							                          		}
							                          		echo $total_shoulder."</td></tr>";

							                          		$total_total_shoulder+=$total_shoulder;
							                          		
							                          	}
							                          	?>
							                          </table>

													</td>
													<td style="width:200px;">
														<?php
														$total_edge_board=0;
														if($mrow->for_export=='1'){
															 $query=$this->db->query("SELECT * from packing_material_consumption_master where packing_category_id='1' and apply_from_date<='$mrow->invoice_date' and apply_to_date>='$mrow->invoice_date' and archive<>1");
																//echo $this->db->last_query();
																$result_edge_board=$query->result();
																if($result_edge_board==TRUE){
																	foreach($result_edge_board as $rm_edge_board){

																		echo number_format($rm_edge_board->cost_per_tube*$ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']),2);
																		$total_edge_board+=$rm_edge_board->cost_per_tube*$ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);
																	}
																}else{
																	echo "<script>alert('Please set the Edge Board Cost/Tube in Master');</script>";
																}
																	
																
															}
														?>
													</td>
													<td style="width:200px;">
														<?php
														$total_desiccant=0;
														if($mrow->for_export=='1'){
															$query=$this->db->query("SELECT * from packing_material_consumption_master where packing_category_id='2' and apply_from_date<='$mrow->invoice_date' and apply_to_date>='$mrow->invoice_date' and archive<>1");
																//echo $this->db->last_query();
																$result_desiccant=$query->result();
																if($result_desiccant==TRUE){
																	foreach($result_desiccant as $rm_desiccant){

																		echo number_format($rm_desiccant->cost_per_tube*$ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']),2);
																		$total_desiccant+=$rm_desiccant->cost_per_tube*$ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);
																	}
																}else{
																	echo "<script>alert('Please set the Desiccant Cost/Tube in Master');</script>";
																}
															}
														?>

													</td>
													<td style="width:200px;">
														<?php
														$total_pallet=0;
														if($mrow->for_export=='1'){
															$query=$this->db->query("SELECT * from packing_material_consumption_master where packing_category_id='3' and apply_from_date<='$mrow->invoice_date' and apply_to_date>='$mrow->invoice_date' and archive<>1");
															$result_pallet=$query->result();
																if($result_pallet==TRUE){
																	foreach($result_pallet as $rm_pallet){

																	echo number_format($rm_pallet->cost_per_tube*$ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']),2);
																	$total_pallet+=$rm_pallet->cost_per_tube*$ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);
																	}
																}else{
																	echo "<script>alert('Please set the Pallet Cost/Tube in Master');</script>";
																}
																
															}
														?>

													</td>
													<td style="width:200px;">

														<?php
															$total_shrink_flim=0;
															$query=$this->db->query("SELECT * from packing_material_consumption_master where packing_category_id='4' and apply_from_date<='$mrow->invoice_date' and apply_to_date>='$mrow->invoice_date' and archive<>1");
																//echo $this->db->last_query();
																$result_shrink_flim=$query->result();
																
																if($result_shrink_flim==TRUE){
																	foreach($result_shrink_flim as $rm_shrink_flim){

																		echo number_format($rm_shrink_flim->cost_per_tube*$ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']),2);
																		$total_shrink_flim+=$rm_shrink_flim->cost_per_tube*$ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);
																	}
															}else{
																echo "<script>alert('Please set the Shrink Flim Cost/Tube in Master');</script>";
															}
															
														?>

													</td>
													<td style="width:200px;">
														<?php
															$total_bopp_tape=0;
															$query=$this->db->query("SELECT * from packing_material_consumption_master where packing_category_id='7' and apply_from_date<='$mrow->invoice_date' and apply_to_date>='$mrow->invoice_date' and archive<>1");
																//echo $this->db->last_query();
																$result_bopp_tape=$query->result();
																if($result_bopp_tape==TRUE){
																	foreach($result_bopp_tape as $rm_bopp_tape){

																		echo number_format($rm_bopp_tape->cost_per_tube*$ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']),2);
																		$total_bopp_tape+=$rm_bopp_tape->cost_per_tube*$ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);
																	}
																}else{
																	echo "<script>alert('Please set the Bopp Tape Cost/Tube in Master');</script>";
																}
															
														?>
													</td>
													<td style="width:200px;">
														<?php
															$total_stickers=0;
															$query=$this->db->query("SELECT * from packing_material_consumption_master where packing_category_id='5' and apply_from_date<='$mrow->invoice_date' and apply_to_date>='$mrow->invoice_date' and archive<>1");
																//echo $this->db->last_query();
																$result_stickers=$query->result();
																if($result_stickers==TRUE){
																	foreach($result_stickers as $rm_stickers){

																	echo number_format($rm_stickers->cost_per_tube*$ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']),2);
																	$total_stickers+=$rm_stickers->cost_per_tube*$ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);
																	}
																}else{
																	echo "<script>alert('Please set the Stickers Cost/Tube in Master');</script>";
																}
																
															
														?>
													</td>
													<td style="width:200px;">
														<?php
															$total_other_pm=0;
															$query=$this->db->query("SELECT * from packing_material_consumption_master where packing_category_id='6' and apply_from_date<='$mrow->invoice_date' and apply_to_date>='$mrow->invoice_date' and archive<>1");
																//echo $this->db->last_query();
																$result_other_pm=$query->result();
																if($result_other_pm==TRUE){
																	foreach($result_other_pm as $rm_other_pm){

																	echo number_format($rm_other_pm->cost_per_tube*$ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']),2);
																	$total_other_pm+=$rm_other_pm->cost_per_tube*$ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);
																	}
																}else{
																	echo "<script>alert('Please set the Other Packing Cost/Tube in Master');</script>";
																}
																
															
														?>
													</td>
													<td style="width:200px;">
														<?php
															$total_local_spares=0;
															$query=$this->db->query("SELECT * from stores_and_spares_consumption_master where stores_and_spares_category_id='0' and apply_from_date<='$mrow->invoice_date' and apply_to_date>='$mrow->invoice_date' and archive<>1");
																//echo $this->db->last_query();
																$result_local_spare=$query->result();
																if($result_local_spare==TRUE){
																	foreach($result_local_spare as $stores_local){

																	echo number_format($stores_local->cost_per_tube*$ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']),2);
																	$total_local_spares+=$stores_local->cost_per_tube*$ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);
																	}
																}else{
																	echo "<script>alert('Please set the Local Spares Cost/Tube in Master');</script>";
																}
																
															
														?>

													</td>
													<td style="width:200px;">
														<?php
															$total_import_spares=0;
															$query=$this->db->query("SELECT * from stores_and_spares_consumption_master where stores_and_spares_category_id='1' and apply_from_date<='$mrow->invoice_date' and apply_to_date>='$mrow->invoice_date' and archive<>1");
																//echo $this->db->last_query();
																$result_import_spares=$query->result();
																if($result_import_spares==TRUE){
																	foreach($result_import_spares as $stores_import){

																	echo number_format($stores_import->cost_per_tube*$ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']),2);
																	$total_import_spares+=$stores_import->cost_per_tube*$ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);
																	}
																}else{
																	echo "<script>alert('Please set the Import Spares Cost/Tube in Master');</script>";
																}
																
															
														?>
													</td>
													<td style="width:200px;">
														<?php 
														($print_type_artwork=='' ? $print_type_bom:$print_type_artwork);
														$total_screen_ink=0;
														
														if($mrow->invoice_date<'2020-10-01'){

															if(strcmp($print_type_artwork, 'SCREEN') == 0 || strcmp($print_type_artwork, 'SCREEN+UPTO NECK') == 0 || strcmp($print_type_artwork, 'SCREEN + LABEL') == 0){

																$screen_ink_value_row=0; 
																$query=$this->db->query("SELECT * from ink_consumption_master where lacquer_type_id='3' and apply_from_date<='$mrow->invoice_date' and apply_to_date>='$mrow->invoice_date' and archive<>1");

																$result_screen_ink_value=$query->result();
																	foreach($result_screen_ink_value as $result_screen_ink_value_row){
																		$screen_ink_value_row=$result_screen_ink_value_row->cost_per_tube*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);
																	}


																echo number_format($screen_ink_value_row,2);

																$total_screen_ink+=$screen_ink_value_row;

															}
														}else{

															$screen_ink_value_row=0;
															$s_screen_ink_value_row=0;
															$screen_ink_value_cost_per_kg=0;
															$s_screen_ink_value_cost_per_kg=0;
															$screen_ink_value_gm_tube=0;
															$s_screen_ink_value_gm_tube=0;
															$query=$this->db->query("SELECT * from ink_price_master where ink_id='3' and apply_from_date<='$mrow->invoice_date' and apply_to_date>='$mrow->invoice_date' and archive<>1");
															$result_screen_ink_value=$query->result();
															foreach($result_screen_ink_value as $result_screen_ink_value_row){
																$screen_ink_value_cost_per_kg=$result_screen_ink_value_row->cost_per_kg;
															}

															$query=$this->db->query("SELECT * from ink_price_master where ink_id='4' and apply_from_date<='$mrow->invoice_date' and apply_to_date>='$mrow->invoice_date' and archive<>1");
															$result_s_screen_ink_value=$query->result();
															foreach($result_s_screen_ink_value as $result_s_screen_ink_value_row){
																$s_screen_ink_value_cost_per_kg=$result_s_screen_ink_value_row->cost_per_kg;
															}

															$query=$this->db->query("SELECT * from coex_ink_consumption_master where article_no='$drow->article_no' and artwork_no='$ad_id' and artwork_version_no='$version_no' and archive<>1 limit 0,1");
															$result_screen_ink_gm_tube_result=$query->result();
															if($result_screen_ink_gm_tube_result==FALSE){

															}else{
																foreach($result_screen_ink_gm_tube_result as $result_screen_ink_gm_tube_row){
																
																$screen_ink_value_row=(($result_screen_ink_gm_tube_row->screen_ink_gm_tube*($drow->arid_qty/100))/1000)*$screen_ink_value_cost_per_kg;

																$s_screen_ink_value_row=(($result_screen_ink_gm_tube_row->special_ink_gm_tube*($drow->arid_qty/100))/1000)*$s_screen_ink_value_cost_per_kg;

																}
															}
														//echo number_format($screen_ink_value_row+$s_screen_ink_value_row,2);

															echo number_format($s_screen_ink_value_row,2);

															$total_screen_ink+=$s_screen_ink_value_row;

														}

														?>


													</td>
													<td style="width:200px;">

														<?php 

														($print_type_artwork=='' ? $print_type_bom:$print_type_artwork);
														$total_offset_ink=0;
															
															if($mrow->invoice_date<'2020-10-01'){


															if(strcmp($print_type_artwork, 'OFFSET') == 0 || strcmp($print_type_artwork, 'OFFSET SCREEN') == 0 || strcmp($print_type_artwork, 'PLAIN') == 0 || strcmp($print_type_artwork, 'LABEL OFFSET') == 0){

																$offset_ink_value_row=0;
																$query=$this->db->query("SELECT * from ink_consumption_master where lacquer_type_id='2' and apply_from_date<='$mrow->invoice_date' and apply_to_date>='$mrow->invoice_date' and archive<>1");
																		//echo $this->db->last_query();++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
																		$result_offset_ink_value=$query->result();
																		foreach($result_offset_ink_value as $result_offset_ink_value_row){
																			$offset_ink_value_row=$result_offset_ink_value_row->cost_per_tube*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);
																		}

																echo number_format($offset_ink_value_row,2);

																$total_offset_ink+=$offset_ink_value_row;

															}

														}else{

															$offset_ink_value_row=0;
															$offset_ink_value_cost_per_kg=0;
															$offset_ink_value_gm_tube=0;
															$query=$this->db->query("SELECT * from ink_price_master where ink_id='2' and apply_from_date<='$mrow->invoice_date' and apply_to_date>='$mrow->invoice_date' and archive<>1");
															$result_offset_ink_value=$query->result();
															foreach($result_offset_ink_value as $result_offset_ink_value_row){
																$offset_ink_value_cost_per_kg=$result_offset_ink_value_row->cost_per_kg;
															}

															$query=$this->db->query("SELECT * from coex_ink_consumption_master where article_no='$drow->article_no' and artwork_no='$ad_id' and artwork_version_no='$version_no' and archive<>1 limit 0,1");
															$result_offset_ink_gm_tube_result=$query->result();
															if($result_offset_ink_gm_tube_result==FALSE){

															}else{
																foreach($result_offset_ink_gm_tube_result as $result_offset_ink_gm_tube_row){
																
																$offset_ink_value_row=(($result_offset_ink_gm_tube_row->offset_ink_gm_tube*($drow->arid_qty/100))/1000)*$offset_ink_value_cost_per_kg;
																}
															}
															echo number_format($offset_ink_value_row,2);

															$total_offset_ink+=$offset_ink_value_row;

														}
														

														?>
													</td>
													<td style="width:200px;">

														<?php 



														($print_type_artwork=='' ? $print_type_bom:$print_type_artwork);
														$total_flexo_ink=0;
														if($mrow->invoice_date<'2020-10-01'){

														/*
														$conn=mysqli_connect('192.168.0.33','root','NewUser@php','twerp');

														$query5="SELECT * from costsheet_details where so_no='$drow->ref_ord_no' and psppsm_no='$drow->article_no'";
														$result55=mysqli_query($conn,$query5);
														
														while($flexo_ink_row = mysqli_fetch_array($result55)){*/

															if(strcmp($print_type_artwork, 'FLEXO') == 0 || strcmp($print_type_artwork, 'SCREEN+FLEXO') == 0 || strcmp($print_type_artwork, 'FLEXO+SCREEN') == 0){


																$flexo_ink_value_row=0;
																$query=$this->db->query("SELECT * from ink_consumption_master where lacquer_type_id='8' and apply_from_date<='$mrow->invoice_date' and apply_to_date>='$mrow->invoice_date' and archive<>1");
																		//echo $this->db->last_query();
																		$result_flexo_ink_value=$query->result();
																		foreach($result_flexo_ink_value as $result_flexo_ink_value_row){
																			$flexo_ink_value_row=$result_flexo_ink_value_row->cost_per_tube*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);
																		}

																echo number_format($flexo_ink_value_row,2);

																$total_flexo_ink+=$flexo_ink_value_row;

															}
														/*}*/
														}else{

															$flexo_ink_value_row=0;
															$flexo_ink_value_cost_per_kg=0;
															$flexo_ink_value_gm_tube=0;
															$query=$this->db->query("SELECT * from ink_price_master where ink_id='1' and apply_from_date<='$mrow->invoice_date' and apply_to_date>='$mrow->invoice_date' and archive<>1");
															$result_flexo_ink_value=$query->result();
															$this->db->last_query();
															foreach($result_flexo_ink_value as $result_flexo_ink_value_row){
																$flexo_ink_value_cost_per_kg=$result_flexo_ink_value_row->cost_per_kg;
															}

															$query=$this->db->query("SELECT * from coex_ink_consumption_master where article_no='$drow->article_no' and artwork_no='$ad_id' and artwork_version_no='$version_no' and archive<>1 limit 0,1");
															$result_flexo_ink_gm_tube_result=$query->result();
															if($result_flexo_ink_gm_tube_result==FALSE){

															}else{
																foreach($result_flexo_ink_gm_tube_result as $result_flexo_ink_gm_tube_row){
																
																$flexo_ink_value_row=(($result_flexo_ink_gm_tube_row->flexo_ink_gm_tube*($drow->arid_qty/100))/1000)*$flexo_ink_value_cost_per_kg;
																}
															}
															echo number_format($flexo_ink_value_row,2);

															$total_flexo_ink+=$flexo_ink_value_row;

														}
														?>

													</td>
													<td style="width:200px;">

														<?php 
														//SCREEN INK
														
														($print_type_artwork=='' ? $print_type_bom : $print_type_artwork);
														$total_digital_ink=0;
														/*
														$conn=mysqli_connect('192.168.0.33','root','NewUser@php','twerp');

														$query5="SELECT * from costsheet_details where so_no='$drow->ref_ord_no' and psppsm_no='$drow->article_no'";
														$result55=mysqli_query($conn,$query5);
														
														while($screen_ink_row = mysqli_fetch_array($result55)){*/

															//echo $print_type_bom;

															if(strcmp($print_type_artwork, 'FLEXO+DIGITAL+FLEXO') == 0 || strcmp($print_type_artwork, 'DIGITAL+FLEXO') == 0 || strcmp($print_type_artwork, 'FLEXO+DIGITAL') == 0){

																//echo $print_type_artwork;

																$digital_ink_value_row=0; 
																$query=$this->db->query("SELECT * from ink_consumption_master where lacquer_type_id='12' and apply_from_date<='$mrow->invoice_date' and apply_to_date>='$mrow->invoice_date' and archive<>1");

																$result_digital_ink_value=$query->result();
																	foreach($result_digital_ink_value as $result_digital_ink_value_row){
																		$digital_ink_value_row=$result_digital_ink_value_row->cost_per_tube*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);
																	}


																echo number_format($digital_ink_value_row,2);

																$total_digital_ink+=$digital_ink_value_row;

															}
														/*}*/

														?>
													</td>
													<?php
														$data['daily_plate_master']=$this->common_model->select_one_active_record('graphics_daily_plates_master',$this->session->userdata['logged_in']['company_id'],'order_no',$drow->ref_ord_no);
														if($data['daily_plate_master']==TRUE){
															$total_offset_plates=0;
															$total_screen_positive=0;
															$total_flexo_plates=0;
															$offset_plates=0;
															$screen_positive=0;
															$flexo_plates=0;
															foreach($data['daily_plate_master'] as $row_plate_record){

																$data_plates=array('dpr_id'=>$row_plate_record->dpr_id);
																//$this->load->model('daily_plates_record_model');
																$result_plates=$this->daily_plates_record_model->select_no_plates('graphics_daily_plates_details',$data_plates);
																//echo $this->db->last_query();
																foreach ($result_plates as $row_plates) {
																	$offset_plates=$row_plates->offset;
																	$screen_positive=$row_plates->screen;
																	$flexo_plates=$row_plates->flexo;
																}
																$total_offset_plates+=$offset_plates;
																$total_screen_positive+=$screen_positive;
																$total_flexo_plates+=$flexo_plates;
															}
														}else{
															$total_offset_plates=0;
															$total_screen_positive=0;
															$total_flexo_plates=0;
															$offset_plates=0;
															$screen_positive=0;
															$flexo_plates=0;
														}
															$total_screens=0;
															$screens=0;
															$data['daily_screen_master']=$this->common_model->select_one_active_record('graphics_daily_screen_master',$this->session->userdata['logged_in']['company_id'],'order_no',$drow->ref_ord_no);
															if($data['daily_screen_master']==TRUE){
																foreach($data['daily_screen_master'] as $row_screen_record){
																	$data_screens=array('dsr_id'=>$row_screen_record->dsr_id);
																//$this->load->model('daily_plates_record_model');
																	$result_screens=$this->daily_screen_record_model->select_no_screen('graphics_daily_screen_details',$data_screens);
																	foreach ($result_screens as $row_screens) {
																	$screens=$row_screens->screen;
																	}
																$total_screens+=$screens;
																}
															}
														
													?>

													<td style="width:200px;"><?php echo $total_screens;?></td>
													<td style="width:200px;">
														<?php 
														$screen_value=0;
														$total_screens=0;
														($print_type_artwork=='' ? $print_type_bom : $print_type_artwork);

														if(strpos($print_type_artwork, 'SCREEN+FLEXO') !== false || strpos($print_type_artwork, 'FLEXO+SCREEN') !== false || strpos($print_type_artwork, 'SCREEN') !== false || strpos($print_type_artwork, 'SCREEN + LABEL') !== false  || strpos($print_type_artwork, 'SCREEN+UPTO NECK') !== false || strpos($print_type_artwork, 'OFFSET SCREEN') !== false){

														$query=$this->db->query("SELECT * from screen_consumption_master where lacquer_type_id='3' and apply_from_date<='$mrow->invoice_date' and apply_to_date>='$mrow->invoice_date' and archive<>1");
														$result_screen_value=$query->result();
																if($result_screen_value==TRUE){
																	foreach($result_screen_value as $result_screen_value_row){
																		$screen_rate=$result_screen_value_row->consumption_unit_rate;
																	}

																	$screen_value=$screens*$screen_rate;
																	$screen_cost_per_tube=$screen_value/$total_dispatch;
																	$invoice_wise_offset_screen_value=$screen_cost_per_tube*$ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);
																	echo round($invoice_wise_offset_screen_value,2);
																	$total_screens+=$invoice_wise_offset_screen_value;

																}else{

																echo "<script>alert('Please set the Screen Price in Master');</script>";
																}
															}
															
														

														?>
														</td>
													<td style="width:200px;"><?php echo $total_offset_plates;?></td>
													<td style="width:200px;">

														<?php 
														$offset_plates_value=0;
														($print_type_artwork==''?$print_type_bom:$print_type_artwork);
														$total_offset_plates=0;
														

															if(strpos($print_type_artwork, 'OFFSET') !== false || strpos($print_type_artwork, 'OFFSET SCREEN') !== false){

																$query=$this->db->query("SELECT * from screen_consumption_master where lacquer_type_id='2' and apply_from_date<='$mrow->invoice_date' and apply_to_date>='$mrow->invoice_date' and archive<>1");
																$result_offset_value=$query->result();
																if($result_offset_value==TRUE){
																	foreach($result_offset_value as $result_offset_value_row){
																		$offset_plate_rate=$result_offset_value_row->consumption_unit_rate;
																	}
																	$offset_plates_value=$offset_plates*$offset_plate_rate;
																	$offset_plates_cost_per_tube=$offset_plates_value/$total_dispatch;
																	$invoice_wise_offset_plates_value=$offset_plates_cost_per_tube*$ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);
																	echo round($invoice_wise_offset_plates_value,2);
																	$total_offset_plates+=$invoice_wise_offset_plates_value;
																}else{
																echo "<script>alert('Please set the Offset Plate Price in Master');</script>";	
																}
															}

														?>

													</td>
													<td style="width:200px;"><?php echo $total_flexo_plates;?></td>
													<td style="width:200px;">

													<?php 
														$flexo_plates_value=0;
														($print_type_artwork==''? $print_type_bom : $print_type_artwork);
														$total_flexo_plates=0;
															if(strpos($print_type_artwork, 'FLEXO') !== false || strpos($print_type_artwork, 'SCREEN+FLEXO') !== false || strpos($print_type_artwork, 'FLEXO+SCREEN') !== false){

																$query=$this->db->query("SELECT * from screen_consumption_master where lacquer_type_id='6' OR lacquer_type_id='8' and apply_from_date<='$mrow->invoice_date' and apply_to_date>='$mrow->invoice_date' and archive<>1");

																$result_flexo_value=$query->result();
																if($result_flexo_value==TRUE){
																	foreach($result_flexo_value as $result_flexo_value_row){
																		$flexo_plate_rate=$result_flexo_value_row->consumption_unit_rate;
																	}

																	$flexo_plates_value=$flexo_plates*$flexo_plate_rate;
																	$flexo_plates_cost_per_tube=$flexo_plates_value/$total_dispatch;
																	$invoice_wise_flexo_plates_value=$flexo_plates_cost_per_tube*$ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);
																	echo round($invoice_wise_flexo_plates_value,2);
																	$total_flexo_plates+=$invoice_wise_flexo_plates_value;
																}else{
																echo "<script>alert('Please set the Flexo Plate Price in Master');</script>";
																}

															}

														?>

													</td>
													<td style="width:200px;">

														<?php

														//echo $print_type_bom;
														
														$data['lacquer_types_master']=$this->costsheet_model->select_one_active_record('lacquer_types_master',$this->session->userdata['logged_in']['company_id'],'lacquer_type',$print_type_bom);
														
														//echo $this->db->last_query();
															$m=0;
															foreach($data['lacquer_types_master'] as $lacquer_types_row){
																$lacquer_type_id=$lacquer_types_row->lacquer_type_id;
																$lacquer_array[$m] = $lacquer_type_id;
																$m++;

															}

														
															$query=$this->db->query("SELECT * from uv_consumption_master where lacquer_type_id='$lacquer_type_id' and apply_from_date<='$mrow->invoice_date' and apply_to_date>='$mrow->invoice_date' and archive<>1");
																//echo $this->db->last_query();
																$result_uv_lamp=$query->result();
																$total_uv=0;
																if($result_uv_lamp==TRUE){
																	foreach($result_uv_lamp as $uv_lamp){

																	echo number_format($uv_lamp->cost_per_tube*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']));

																	$total_uv+=$uv_lamp->cost_per_tube*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);
																	}
																}else{
																	echo "<script>alert('Please set the UV Lamp Cost/Tube in Master for $print_type_bom');</script>";
																}
																
															
														?>

													</td>
													<td style="width:200px;">
														<?php
														$total_decoseam_consumable=0;
														
															if($drow->order_flag==1){
																$query=$this->db->query("SELECT * from other_consumable_consumption_master where consumable_category_id='6' and apply_from_date<='$mrow->invoice_date' and apply_to_date>='$mrow->invoice_date' and archive<>1");
																//echo $this->db->last_query();
																$result_decoseam_consumable=$query->result();
																
																if($result_decoseam_consumable==TRUE){
																	foreach($result_decoseam_consumable as $decoseam_consumable){

																	echo number_format($decoseam_consumable->cost_per_tube*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']));
																	$total_decoseam_consumable+=$decoseam_consumable->cost_per_tube*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);
																	}
																}else{
																	echo "<script>alert('Please set the Decoseam Consumbale Cost/Tube in Master');</script>";
																}
															}
															
																
															
														?>


													</td>
													<td style="width:200px;">
														<?php
														
															$query=$this->db->query("SELECT * from other_consumable_consumption_master where consumable_category_id='1' and apply_from_date<='$mrow->invoice_date' and apply_to_date>='$mrow->invoice_date' and archive<>1");
																//echo $this->db->last_query();
																$result_other_consumable=$query->result();
																$total_other_consumable=0;
																if($result_other_consumable==TRUE){
																	foreach($result_other_consumable as $other_consumable){

																	echo number_format($other_consumable->cost_per_tube*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']));
																	$total_other_consumable+=$other_consumable->cost_per_tube*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);
																	}
																}else{
																	echo "<script>alert('Please set the Other Consumbale Cost/Tube in Master');</script>";
																}
																
															
														?>


													</td>
													<td style="width:200px;">
														<?php
														
															$query=$this->db->query("SELECT * from other_consumable_consumption_master where consumable_category_id='2' and apply_from_date<='$mrow->invoice_date' and apply_to_date>='$mrow->invoice_date' and archive<>1");
																//echo $this->db->last_query();
																$result_hygenic_consumable=$query->result();
																$total_hygenic_consumable=0;
																if($result_hygenic_consumable==TRUE){
																	foreach($result_hygenic_consumable as $hygenic_consumable){

																	echo number_format($hygenic_consumable->cost_per_tube*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']));
																	$total_hygenic_consumable+=$hygenic_consumable->cost_per_tube*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);
																	}
																}else{
																	echo "<script>alert('Please set the Hygenic Consumbale Cost/Tube in Master');</script>";
																}
																
															
														?>
													</td>

													<td style="width:200px;">
														
														<?php
														$total_screen_consumable=0;
														if(strcmp($print_type_artwork, 'SCREEN') == 0 || strcmp($print_type_artwork, 'SCREEN+UPTO NECK') == 0 || strcmp($print_type_artwork, 'SCREEN + LABEL') == 0){
															$query=$this->db->query("SELECT * from other_consumable_consumption_master where consumable_category_id='5' and apply_from_date<='$mrow->invoice_date' and apply_to_date>='$mrow->invoice_date' and archive<>1");
																//echo $this->db->last_query();
																$result_screen_consumable=$query->result();
																
																if($result_screen_consumable==TRUE){
																	foreach($result_screen_consumable as $screen_consumable){

																	echo number_format($screen_consumable->cost_per_tube*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']));
																	$total_screen_consumable+=$screen_consumable->cost_per_tube*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);
																	}
																}else{
																	echo "<script>alert('Please set the Screen Consumbale Cost/Tube in Master');</script>";
																}
																
															}


															$total_offset_consumable=0;
															if(strcmp($print_type_artwork, 'OFFSET') == 0 || strcmp($print_type_artwork, 'OFFSET SCREEN') == 0 || strcmp($print_type_artwork, 'PLAIN') == 0 || strcmp($print_type_artwork, 'LABEL OFFSET') == 0){
															$query=$this->db->query("SELECT * from other_consumable_consumption_master where consumable_category_id='4' and apply_from_date<='$mrow->invoice_date' and apply_to_date>='$mrow->invoice_date' and archive<>1");
																//echo $this->db->last_query();
																$result_offset_consumable=$query->result();
																if($result_offset_consumable==TRUE){
																	foreach($result_offset_consumable as $offset_consumable){

																	echo number_format($offset_consumable->cost_per_tube*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']));
																	$total_offset_consumable+=$offset_consumable->cost_per_tube*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);
																	}
																}else{
																	echo "<script>alert('Please Set the Offset Consumbale Cost/Tube in Master');</script>";
																}
																
															}

															$total_flexo_consumable=0;
															if(strcmp($print_type_artwork, 'FLEXO') == 0 || strcmp($print_type_artwork, 'SCREEN+FLEXO') == 0 || strcmp($print_type_artwork, 'FLEXO+SCREEN') == 0){
															$query=$this->db->query("SELECT * from other_consumable_consumption_master where consumable_category_id='3' and apply_from_date<='$mrow->invoice_date' and apply_to_date>='$mrow->invoice_date' and archive<>1");
																//echo $this->db->last_query();
																$result_flexo_consumable=$query->result();
																
																if($result_flexo_consumable==TRUE){
																	foreach($result_flexo_consumable as $flexo_consumable){

																	echo number_format($flexo_consumable->cost_per_tube*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']));
																	$total_flexo_consumable+=$flexo_consumable->cost_per_tube*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);
																	}
																}else{
																	echo "<script>alert('Please Set the Flexo Consumbale Cost/Tube in Master');</script>";
																}
																
															}

														?>
													</td>
													<td>
														
														<?php
															$total_freight=0;
												            $total_freight_amount=0;
												            $query=$this->db->query("SELECT * from freight_master where sleeve_id='$dia' and customer_no='$mrow->customer_no' and apply_from_date<='$mrow->invoice_date' and apply_to_date>='$mrow->invoice_date' and archive<>1");
												            $result_freight_value=$query->result();
												            //echo $this->db->last_query();
												            if($result_freight_value==TRUE){
												            foreach($result_freight_value as $result_freight_value_row){
												                $total_freight=$result_freight_value_row->cost_per_tube*$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);



												                    $total_freight_amount+=$total_freight;
												                }
												                }else{
												                    //echo "<tr><td colspan='8'>FREIGHT IS NOT ENTERED</td></tr>";
												                } 
												                echo $total_freight_amount;
												                ?>

													</td>



													<td style="width:200px;">
													<?php
													$total_sum_of_rm=$total_sum_rm+$total_total_cap+$total_total_label+$total_total_shoulder+$total_edge_board+$total_desiccant+$total_pallet+$total_shrink_flim+$total_bopp_tape+$total_stickers+$total_other_pm+$total_local_spares+$total_import_spares+$total_screen_ink+$total_offset_ink+$total_flexo_ink+$total_digital_ink+$total_screens+$total_offset_plates+$total_flexo_plates+$total_uv+$total_decoseam_consumable+$total_other_consumable+$total_hygenic_consumable+$total_screen_consumable+$total_offset_consumable+$total_flexo_consumable+$total_freight_amount;
													echo number_format($total_sum_of_rm,2);
													?>


													</td>
													<td style="width:200px;"><?php echo number_format($total_sum_of_rm/$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']),2);?></td>
													<td style="width:200px;"><?php echo number_format($unit_rate_in_rupees-$total_sum_of_rm/$this->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']),2);?></td>
												</tr>
											</table>
											</td>
									<?php 
									$sum_quantity+=$ci->common_model->read_number($drow->arid_qty,$this->session->userdata['logged_in']['company_id']);
									$sum_net_amount+=$net_amount_in_rupees;
									$sum_cap+=$total_total_cap;
									$sum_label+=$total_total_label;
									$sum_shoulder+=$total_total_shoulder;
									$sum_edge_board+=$total_edge_board;
									$sum_desiccant+=$total_desiccant;
									$sum_pallet+=$total_pallet;
									$sum_shrink_flim+=$total_shrink_flim;
									$sum_bopp_tape+=$total_bopp_tape;
									$sum_stickers+=$total_stickers;
									$sum_other_pm+=$total_other_pm;
									$sum_local_spares+=$total_local_spares;
									$sum_import_spares+=$total_import_spares;
									$sum_screen_ink+=$total_screen_ink;
									$sum_offset_ink+=$total_offset_ink;
									$sum_flexo_ink+=$total_flexo_ink;
									$sum_digital_ink+=$total_digital_ink;
									$sum_screens+=$total_screens;
								    $sum_offset_plates+=$total_offset_plates;
								    $sum_flexo_plates+=$total_flexo_plates;
								    $sum_uv+=$total_uv;
								    $sum_decoseam_consumable+=$total_decoseam_consumable;
								    $sum_other_consumable+=$total_other_consumable;
								    $sum_hygenic_consumable+=$total_hygenic_consumable;
								    $sum_other_mix_consumable+=$total_flexo_consumable+$total_offset_consumable+$total_screen_consumable;
								    $sum_freight+=$total_freight_amount;
								    $sum_total_rm+=$total_sum_of_rm;
									echo "</tr>";

									$count=$this->common_model->active_record_count_where('costsheet_master',$this->session->userdata['logged_in']['company_id'],'invoice_no',$mrow->ar_invoice_no,'article_no',$drow->article_no,'archive','0');
									
									
									if($count==0){
									 $data=array(
						                'invoice_no'=>$mrow->ar_invoice_no,
						                'company_id'=>$this->session->userdata['logged_in']['company_id'],
						                'invoice_date'=>$mrow->invoice_date,
						                'order_no'=>$drow->ref_ord_no,
						                'customer_id'=>$mrow->customer_no,
						                'article_no'=>$drow->article_no,
						                'dia'=>$dia,
						                'length'=>$length,
						                'print_type'=>$print_type_bom,
						                'dispatch_quantity'=>$drow->arid_qty/100,
						                'unit_rate'=>$unit_rate_in_rupees,
						                'archive'=>'0'
						              );

									 //$result=$this->common_model->save('costsheet_master',$data);
									}else{

									}
									}

									

								}//EK


								
							}

							echo "<tr><td colspan='11'>Total</td><td>".number_format($sum_quantity)."</td><td>".round(($sum_quantity!=0?$sum_net_amount/$sum_quantity:0),2)."</td>
							<td>".number_format($sum_net_amount,2)."</td>
							<td></td>
							<td></td>
							<td width='4000px'>";?>
							<table style="width:4000px;border: none;" cellspacing="0" cellpadding="0">
									<tr>
										<td style="width:200px;">JOBCARD</td>
										<?php 
										$query=$this->db->query("SELECT DISTINCT article_name_info.article_group_id, article_name_info.main_group_id, article_group_desc.lang_article_group_desc
										FROM `reserved_quantity_manu`
										LEFT JOIN article_name_info ON reserved_quantity_manu.article_no = article_name_info.article_no
										LEFT JOIN article_group_desc ON article_group_desc.article_group_id = article_name_info.article_group_id
										WHERE reserved_quantity_manu.company_id = article_name_info.company_id
										AND reserved_quantity_manu.`date_required`
										BETWEEN '2018-04-01'
										AND '".$this->input->post('to_date')."'
										AND reserved_quantity_manu.type_flag =2
										AND article_name_info.main_group_id <>5
										AND article_group_desc.lang_article_group_desc IS NOT NULL
										GROUP BY article_name_info.article_group_id
										ORDER BY article_name_info.main_group_id ASC");

									$result=$query->result();	
										$i=0;
										foreach($result as $row_rm){
											echo "<td width='200px'>".
											number_format($total_array[$i]/100,2)."
											</td>";
											$i++;
										}?>
										<td style="width:200px;"><?php echo number_format($sum_cap,2);?></td>
										<td style="width:200px;"><?php echo number_format($sum_label,2);?></td>
										<td style="width:200px;"><?php echo number_format($sum_shoulder,2);?></td>
										<td style="width:200px;"><?php echo number_format($sum_edge_board,2);?></td>
										<td style="width:200px;"><?php echo number_format($sum_desiccant,2);?></td>
										<td style="width:200px;"><?php echo number_format($sum_pallet,2);?></td>
										<td style="width:200px;"><?php echo number_format($sum_shrink_flim,2);?></td>
										<td style="width:200px;"><?php echo number_format($sum_bopp_tape,2);?></td>
										<td style="width:200px;"><?php echo number_format($sum_stickers,2);?></td>
										<td style="width:200px;"><?php echo number_format($sum_other_pm,2);?></td>
										<td style="width:200px;"><?php echo number_format($sum_local_spares,2);?></td>
										<td style="width:200px;"><?php echo number_format($sum_import_spares,2);?></td>
										<td style="width:200px;"><?php echo number_format($sum_screen_ink,2);?></td>
										<td style="width:200px;"><?php echo number_format($sum_offset_ink,2);?></td>
										<td style="width:200px;"><?php echo number_format($sum_flexo_ink,2);?></td>
										<td style="width:200px;"><?php echo number_format($sum_digital_ink,2);?></td>
										<td style="width:200px;"></td>
										<td style="width:200px;"><?php echo number_format($sum_screens,2);?></td>
										<td style="width:200px;"></td>
										<td style="width:200px;"><?php echo number_format($sum_offset_plates,2);?></td>
										<td style="width:200px;"></td>
										<td style="width:200px;"><?php echo number_format($sum_flexo_plates,2);?></td>
										<td style="width:200px;"><?php echo number_format($sum_uv,2);?></td>
										<td style="width:200px;"><?php echo number_format($sum_decoseam_consumable,2);?></td>
										<td style="width:200px;"><?php echo number_format($sum_other_consumable,2);?></td>
										<td style="width:200px;"><?php echo number_format($sum_hygenic_consumable,2);?></td>
										<td style="width:200px;"><?php echo number_format($sum_other_mix_consumable,2);?></td>
										<td style="width:200px;"><?php echo number_format($sum_freight,2);?></td>
										<td style="width:200px;"><?php echo number_format($sum_total_rm,2);?></td>
										<td style="width:200px;"><?php echo ($sum_quantity<>0 ? number_format($sum_total_rm/$sum_quantity,2) : 0);?></td>
										<td style="width:200px;"><?php echo number_format((($sum_quantity!=0?$sum_net_amount/$sum_quantity:0))-(($sum_quantity!=0?$sum_net_amount/$sum_quantity:0)),2);?></td>
									</tr>
								</table>

							<?php echo "
							</td>
							</tr>";
						} 
						?>



					</tbody>	
					</table>
					<table id="header-fixed"></table>
					<button class="ui green button" type ="submit" name="submit">Compare</button>
					<br/>
					<br/>
				</form>
					</div>
				</div>
				
				
				
				
				
			