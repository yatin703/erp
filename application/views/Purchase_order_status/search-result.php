<div class="record_form_design">
<h4>Search Records From <?php echo $this->input->post('from_date');?> TO <?php echo $this->input->post('to_date');?>
	
	<a href="<?php echo base_url('/index.php/purchase_order_status/download_to_excel?from_date=').''.$this->input->post('from_date').'&to_date='.$this->input->post('to_date').'&adr_company_id='.$this->input->post('adr_company_id').'&article_no='.$this->input->post('article_no').'&po_no='.$this->input->post('po_no').'&for_import='.$this->input->post('for_import').'&final_approval_flag='.$this->input->post('final_approval_flag').'&po_grir_completed='.$this->input->post('po_grir_completed').'&trans_closed='.$this->input->post('trans_closed');?>" >
		<button class="ui icon blue mini button">
		  <i class="file excel outline icon"></i> Export to Excel
		</button>
	</a></br> 
</h4>

	<div class="record_inner_design" style="overflow: scroll;">
		
					<table class="record_table_design_without_fixed">

						<tr>
							<th>Sr. No.</th>
							<th>PO No.</th>
							<th>PO Date</th>
							<th>Supplier</th>							
							<th>SO No.</th>
							<th>Order Status</th>
							<th>Transaction Status</th>
							<th>Comments</th>
							<th>Main Group</th>
							<th>Sub Group</th>
							<th>Second Sub Group</th>
							<th>Article Code</th>
							<th>Article Name</th>
							<th>PO Qty</th>
							<th>Supply Qty</th>
							<th>Net Amount</th>
							<th>GRN Date</th>
							<th>GRN No.</th>
							<th>GRN QtY</th>
							<th>Invoice Date</th>
							<th>Invoice No</th>
							<th>Invoice Qty</th>
							<th>Invoice Amount</th>

							<!--<th>Net Amount</th>
							<th>Amount Received</th>-->
							
					
						</tr>
				<?php if($purchase_order_master==FALSE){
					echo "<tr><td colspan='7'>No Records Found</td></tr>";
				}
				else 
				{
					$ci =&get_instance();
					$ci->load->model('purchase_order_status_model');
				    $ci->load->model('common_model');
				    $ci->load->model('article_model');
				    $ci->load->model('customer_model');

				    $sum_po_quantity=0;
				    $sum_supply_quantity=0;
				    $sum_net_amount=0;
				    $sum_amount_received=0;

				    $html="";
				    $n=1;
					foreach($purchase_order_master as $mrow){

						$details_data=array();
						$details_data['po_no']=$mrow->po_no;

						if(!empty($this->input->post('article_no'))){

							$arr=explode("//",$this->input->post('article_no'));
							$article_no=$arr[1];

							$details_data['article_no']=$article_no;

						}
							
						$result=$ci->purchase_order_status_model->active_details_records('purchase_order_details',$details_data,$this->session->userdata['logged_in']['company_id']);
						//echo $this->db->last_query();
						
						$detail_count=count($result);
					    
					    if($detail_count>0){

					    	$detail_rowspan=0;
							$invoice_rowspan=0;
								
							$html.="<tr>
							<td rowspan='detail_rowspan'>".$n++."</td>
							<td rowspan='detail_rowspan'>".($mrow->final_approval_flag==1 ? "<i class='check circle icon'></i>" : "")." ".$mrow->po_no."</td>
							<td rowspan='detail_rowspan'>".$ci->common_model->view_date($mrow->po_date,$this->session->userdata['logged_in']['company_id'])."</td>
							<td rowspan='detail_rowspan'>".$mrow->name1." (".strtoupper($mrow->lang_property_name).") </td>
							<td rowspan='detail_rowspan'>".$mrow->so_no."</td>
							<td rowspan='detail_rowspan'>";
								if($mrow->po_grir_completed==0){
				             		$html.="OPEN";
				             	}
				             	if($mrow->po_grir_completed==1){
				             		$html.="COMPLETED";
				             	}
				             	if($mrow->po_grir_completed==2){
				             		$html.="PARTIALLY COMPLETED";
				             	}
				             $html.="</td>
				            <td  rowspan='detail_rowspan'>";
								             	if($mrow->inv_created_flag==1){
								             		$html.="MANUALLY CLOSED";
								             	}
							$html.="</td>
							<td rowspan='detail_rowspan'>".$mrow->lang_internal_remarks."</td>";
								
							//$r=0;
							foreach ($result as $drow){


								$supply_qty=0;

								$article_result=$ci->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$drow->article_no);
								foreach($article_result as $article_row){
									$article_name=$article_row->article_name.($article_row->article_sub_description!=''?' ('.$article_row->article_sub_description.')':'');
									$main_group=$article_row->main_group;
									$sub_group=$article_row->sub_group;
									$second_sub_group=$article_row->second_sub_group;
									
								}
								$grn=array();
								$grn['grir_purchase_details.po_no']=$drow->po_no;
								$grn['grir_purchase_details.article_no']=$drow->article_no;

								$supply_qty_result=$ci->purchase_order_status_model->sum_supply_qty('grir_purchase_header',$grn,$this->session->userdata['logged_in']['company_id']);

								foreach($supply_qty_result as $supply_qty_row){
									$supply_qty=$supply_qty_row->supply_qty;

								}

								$grn_result=$ci->purchase_order_status_model->active_grn_records('grir_purchase_header',$grn,$this->session->userdata['logged_in']['company_id']);

								//echo $this->db->last_query();
								$invoice_count=count($grn_result);
								$invoice_rowspan=$invoice_count;

								if($invoice_rowspan>0){
									$detail_rowspan+=$invoice_rowspan;
								}
								else{
									$invoice_rowspan=1;
									$detail_rowspan+=$invoice_rowspan;
								}

								//---TOTAL----

								$sum_po_quantity+=$ci->common_model->read_number($drow->po_qty,$this->session->userdata['logged_in']['company_id']);

								$html.="
									<td rowspan='".$invoice_rowspan."' title='Main Group'>".$main_group."</td>
									<td rowspan='".$invoice_rowspan."' title='Sub Group'>".$sub_group."</td>
									<td rowspan='".$invoice_rowspan."' title='Second Sub Group'>".$second_sub_group."</td>
									<td rowspan='".$invoice_rowspan."' title='Article No'>".$drow->article_no."</td>
									<td rowspan='".$invoice_rowspan."' title='Article Name'>".$article_name."</td>
									<td rowspan='".$invoice_rowspan."' title='Quantity'>".number_format($ci->common_model->read_number($drow->po_qty,$this->session->userdata['logged_in']['company_id']),2,'.',',')."</td>
									<td rowspan='".$invoice_rowspan."' title='Supply Quantity'>".number_format($ci->common_model->read_number($supply_qty,$this->session->userdata['logged_in']['company_id']),2,'.',',')."</td>
									<td rowspan='".$invoice_rowspan."' title='Net amount'>".number_format($ci->common_model->read_number($drow->net_price,$this->session->userdata['logged_in']['company_id']),2,'.',',')."</td>
									
									";

								if($invoice_count>0){
									$r=0;

									foreach($grn_result as $grn_row){

										$ap_invoice=array();
										$ap_invoice['ref_no']=$grn_row->delivery_note_no;
										$ap_invoice['article_no']=$grn_row->article_no;

										$ap_invoice_result=$ci->purchase_order_status_model->active_invoice_records('ap_invoice',$ap_invoice,$this->session->userdata['logged_in']['company_id']);
										$invoice_qty=0;
										$invoice_amount=0;
										foreach($ap_invoice_result as $ap_invoice_row){
											$invoice_no=$ap_invoice_row->ap_invoice_no;
											$invoice_date=$ci->common_model->view_date($ap_invoice_row->invoice_date,$this->session->userdata['logged_in']['company_id']);
											$invoice_qty=$ci->common_model->read_number($ap_invoice_row->quantity,$this->session->userdata['logged_in']['company_id']);
											$invoice_amount=$ci->common_model->read_number($ap_invoice_row->net_price,$this->session->userdata['logged_in']['company_id']);

										}


										$html.="
										<td title='GRN Date'>".$ci->common_model->view_date($grn_row->supply_date,$this->session->userdata['logged_in']['company_id'])."</td>
										<td title='GRN No'>".$grn_row->delivery_note_no."</td>
										<td title='Supply Quantity'>".$ci->common_model->read_number($grn_row->qty_received,$this->session->userdata['logged_in']['company_id'])."</td>

										<td title='Invoice Date'>".$invoice_date."</td>
										<td title='Invoice No'>".$invoice_no."</td>
										<td title='Invoice Qty'>".$invoice_qty."</td>
										<td title='Net Amount'>".number_format($invoice_amount,2,'.',',')."</td>";

										$html.="</tr>";
										
										
										if($invoice_rowspan>1){
											$html.="<tr>";
										}

										$r++;

										//----TOTAL--------
										$sum_supply_quantity+=$ci->common_model->read_number($grn_row->qty_received,$this->session->userdata['logged_in']['company_id']);
										// $sum_net_amount+=$ci->common_model->read_number($invoice_row->total_price,$this->session->userdata['logged_in']['company_id']);
										// $sum_amount_received+=$ci->common_model->read_number($invoice_row->amt_received,$this->session->userdata['logged_in']['company_id']);


									}//Invoice foreach

								}else{
									//Five TDs for empty invoice number-------------------
									$html.="<td></td><td></td><td></td><td></td><td></td>";
									// $html.="<td  rowspan='detail_rowspan'>".($mrow->for_export==1?"EXPORT":" ")."</td>
									// 	<td  rowspan='detail_rowspan'>".($mrow->for_sampling==1?"SAMPLE":" ")."</td>
								 //        <td  rowspan='detail_rowspan'>";
								 //        if($mrow->order_closed==0){
								 //             		$html.="OPEN";
								 //             	}
								 //             	if($mrow->order_closed==1){
								 //             		$html.="CLOSED";
								 //             	}
								 //             	if($mrow->order_closed==2){
								 //             		$html.="PARTIALLY CLOSED";
								 //             	}

								 //        $html.="</td>
								 //        <td  rowspan='detail_rowspan'>".($mrow->trans_closed==1?"MANUALLY CLOSED":"")."</td>";
									$html.="</tr>";

								}

								//$r++;

							}//Detail Foreach

							$html=str_replace("detail_rowspan",$detail_rowspan,$html);
							
							//echo $html;

						}//detail if

						
					}//Master foreach

					//HTML GENERATION
						echo $html;	

				} 

				?>
				<?php 
					// echo"<tr>
					// 		<td colspan='11' style='text-align:right;'><b>TOTAL</b></td>
					// 		<td><b>".number_format($sum_order_quantity,2,'.',',')."</b></td>
					// 		<td><b>".number_format($sum_invoice_quantity,2,'.',',')."</b></td>
					// 		<td></td>
					// 		<td></td>
					// 		<td></td>
					// 		<td><b>".number_format($sum_invoice_quantity,2,'.',',')."</b></td>
					// 		<td><b>".number_format($sum_net_amount,2,'.',',')."</b></td>
					// 		<td><b>".number_format($sum_amount_received,2,'.',',')."</b></td>
					// 		<!--<td></td>
					// 		<td></td>
					// 		<td></td>
					// 		<td></td> -->
					// </tr>";

				?>								
								
					</table>
					<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>
				
				
				
				
				
			