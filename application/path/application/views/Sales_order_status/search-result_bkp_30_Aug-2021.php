<div class="record_form_design">
<h4>Search Records From <?php echo $this->input->post('from_date');?> TO <?php echo $this->input->post('to_date');?>
	
	<!--<a href="<?php echo base_url('/index.php/sales_order_status/download_to_excel?from_date=').''.$this->input->post('from_date').'&to_date='.$this->input->post('to_date').'&adr_company_id='.$this->input->post('adr_company_id').'&consin_adr_company_id='.$this->input->post('consin_adr_company_id').'&article_no='.$this->input->post('article_no').'&order_no='.$this->input->post('order_no').'&for_export='.$this->input->post('for_export').'&for_sampling='.$this->input->post('for_sampling').'&final_approval_flag='.$this->input->post('final_approval_flag').'&order_closed='.$this->input->post('order_closed').'&trans_closed='.$this->input->post('trans_closed');?>" >
		<button class="ui icon blue mini button">
		  <i class="file excel outline icon"></i> Export to Excel
		</button>
	</a></br> -->
</h4>

	<div class="record_inner_design" style="overflow: scroll;">
		
					<table class="record_table_design_without_fixed">

						<tr>
							<th>Sr. No.</th>
							
							<th>Order No.</th>
							<th>Order Date</th>
							<th>Bill To</th>
							<th>Ship To</th>
							<th>Po No</th>
							<th>Po Date</th>
							<th>Order Status</th>
							<th>Transaction Status</th>
							<th>Comments</th>
							<th>Article Code</th>
							<th>Article Name</th>
							<th>Order Qty</th>
							<th>JobcardQty</th>
							<th>Supply Qty</th>
							<th>Pending Qty</th>
							<th>Delivery Date</th>
							<th>Invoice No</th>
							<th>Invoice Date</th>
							<th>Invoice Quantity</th>
							<th>Gross Amount</th>
							<th>Amount Received</th>
							<th>Days</th>
							<!--<th>For Export</th>
							<th>Is Sample</th>
							<th>Order Status</th>
							<th>Trans Closed</th>-->
					
						</tr>
				<?php if($order_master==FALSE){
					echo "<tr><td colspan='7'>No Records Found</td></tr>";
				}
				else 
				{
					$ci =&get_instance();
					$ci->load->model('sales_order_status_model');
				    $ci->load->model('common_model');
				    $ci->load->model('article_model');
				    $ci->load->model('customer_model');

				    $sum_order_quantity=0;
				    $sum_invoice_quantity=0;
				    $sum_net_amount=0;
				    $sum_amount_received=0;
				    $sum_total_jobcard_qty=0;

				    $html="";
				    $n=1;
					foreach($order_master as $mrow){

						$details_data=array();
						$details_data['order_no']=$mrow->order_no;

						if(!empty($this->input->post('article_no'))){
							$arr=explode("//",$this->input->post('article_no'));
							$article_no=$arr[1];
							$details_data['article_no']=$article_no;
						}
						$customer_category='';
						if(!empty($this->input->post('customer_category'))){

			            	$arr_categary=explode("//",$this->input->post('customer_category'));
			            	$customer_category=$arr_categary[1];
			            }
									
						// $result=$ci->sales_order_status_model->active_details_records('order_details',$details_data,$this->session->userdata['logged_in']['company_id']);
						
						$result=$ci->sales_order_status_model->active_details_records_new('order_details',$details_data,$this->session->userdata['logged_in']['company_id'],$customer_category);
						//echo $this->db->last_query();
						
						$detail_count=count($result);
					    
					    if($detail_count>0){

					    	$detail_rowspan=0;
							$invoice_rowspan=0;

							$ship_to='';
							if($mrow->consin_adr_company_id!=''){

								$arr=explode("|",$mrow->consin_adr_company_id);
								$consignee=$arr[0];
								$result_consignee=$ci->customer_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$consignee);
								foreach ($result_consignee as $row_consignee){
									$ship_to=$row_consignee->name1.' ('.$row_consignee->lang_property_name.')';
								}


							}
							else{

								$ship_to=$mrow->name1." (".strtoupper($mrow->lang_property_name).")";
							}
								
							$html.="<tr>
							<td rowspan='detail_rowspan'>".$n++."</td>
							<td rowspan='detail_rowspan'>".($mrow->final_approval_flag==1 ? "<i class='check circle icon'></i>" : "")." <a href=".base_url('index.php/sales_order_book/view/'.$mrow->order_no.'')." target='_blank'>".$mrow->order_no."</a></td>
							<td rowspan='detail_rowspan'>".$ci->common_model->view_date($mrow->order_date,$this->session->userdata['logged_in']['company_id'])."</td>
							<td rowspan='detail_rowspan'>".$mrow->name1." (".strtoupper($mrow->lang_property_name).") </td>
							<td rowspan='detail_rowspan'>".$ship_to."</td>
							<td rowspan='detail_rowspan'>".$mrow->cust_order_no."</td>
							<td rowspan='detail_rowspan'>".$ci->common_model->view_date($mrow->cust_order_date,$this->session->userdata['logged_in']['company_id'])."</td>
							<td rowspan='detail_rowspan'>";
							$html.=$this->sales_order_book_model->get_order_status($mrow->order_no);
								// if($mrow->order_closed==0){
				    //          		$html.="OPEN";
				    //          	}
				    //          	if($mrow->order_closed==1){
				    //          		$html.="COMPLETED";
				    //          	}
				    //          	if($mrow->order_closed==2){
				    //          		$html.="PARTIALLY COMPLETED";
				    //          	}
				             $html.="</td>
				            <td  rowspan='detail_rowspan'>";
			             	if($mrow->trans_closed=='0'){
			             		$html.="TRANSACTION OPEN";
			          		}else{
			          			$html.="TRANSACTION CLOSED";
			          		}
							$html.="</td>
							<td rowspan='detail_rowspan'>".$mrow->lang_addi_info."</td>";
								
							//$r=0;

							foreach ($result as $drow){

								
								$pending_qty=0;
								$supply_qty=0;

								$article_result=$ci->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$drow->article_no);
								foreach($article_result as $article_row){
									$article_name=$article_row->article_name.($article_row->article_sub_description!=''?' ('.$article_row->article_sub_description.')':'');

								}
								$invoice=array();
								$invoice['ref_ord_no']=$drow->order_no;
								$invoice['article_no']=$drow->article_no;

								$supply_qty_result=$ci->sales_order_status_model->sum_supply_qty('ar_invoice_master',$invoice,$this->session->userdata['logged_in']['company_id']);

								foreach($supply_qty_result as $supply_qty_row){
									$supply_qty=$supply_qty_row->supply_qty;

								}

								$invoice_result=$ci->sales_order_status_model->active_invoice_records('ar_invoice_master',$invoice,$this->session->userdata['logged_in']['company_id']);

								//echo $this->db->last_query();
								$invoice_count=count($invoice_result);
								$invoice_rowspan=$invoice_count;

								if($invoice_rowspan>0){
									$detail_rowspan+=$invoice_rowspan;
								}
								else{
									$invoice_rowspan=1;
									$detail_rowspan+=$invoice_rowspan;
								}

								$pending_qty=$ci->common_model->read_number($drow->total_order_quantity,$this->session->userdata['logged_in']['company_id'])-$ci->common_model->read_number($supply_qty,$this->session->userdata['logged_in']['company_id']);

								//---TOTAL-----
								$sum_order_quantity+=$ci->common_model->read_number($drow->total_order_quantity,$this->session->userdata['logged_in']['company_id']);

								$html.="<td rowspan='".$invoice_rowspan."' title='Article No'>".$drow->article_no."</td>
									<td rowspan='".$invoice_rowspan."' title='Article Name'>".$article_name."</td>
									<td rowspan='".$invoice_rowspan."' title='Quantity'>".number_format($ci->common_model->read_number($drow->total_order_quantity,$this->session->userdata['logged_in']['company_id']),0,'.',',')."</td>";

									if ($mrow->order_flag==1) {

										$data_search=array('sales_ord_no' =>$drow->order_no,'article_no'=>$drow->article_no,'archive'=>0,'jobcard_type'=>2);

										$production_master_result=$this->common_model->select_active_records_where('production_master',$this->session->userdata['logged_in']['company_id'],$data_search);


									}
									else{

										$data_search=array('sales_ord_no' =>$drow->order_no,'article_no'=>$drow->article_no,'archive'=>0);

										$production_master_result=$this->common_model->select_active_records_where('production_master',$this->session->userdata['logged_in']['company_id'],$data_search);


									}

									$total_jobcard_qty=0;
									foreach ($production_master_result as $production_master_row) {
										//$html.= $production_master_row->mp_pos_no."=".$this->common_model->read_number($production_master_row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id'])."</br>";
										$total_jobcard_qty+=$this->common_model->read_number($production_master_row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']);

									}
									$sum_total_jobcard_qty+=$total_jobcard_qty;
									
									$html.="<td rowspan='".$invoice_rowspan."' style='".($total_jobcard_qty>0 && $supply_qty==0? 'color:red;':'')."'>".($total_jobcard_qty!=0?number_format($total_jobcard_qty,0,'.',','):0)."</td>";				
									

									$html.="</td>
									<td rowspan='".$invoice_rowspan."' title='Supply Quantity'>".number_format($ci->common_model->read_number($supply_qty,$this->session->userdata['logged_in']['company_id']),0,'.',',')."</td>
									<td rowspan='".$invoice_rowspan."' title='Pending Qty'>".number_format(($pending_qty>0?$pending_qty:0),0,'.',',')."</td>
									<td rowspan='".$invoice_rowspan."' title='Delivery Date'>".$ci->common_model->view_date($drow->delivery_date,$this->session->userdata['logged_in']['company_id'])."</td>
									";

								if($invoice_count>0){
									$r=0;

									foreach($invoice_result as $invoice_row){

										$days='';
										$diff='';	
										if($invoice_row->invoice_date!=''){											
											$po_date = date_create($mrow->cust_order_date);
											$invoice_date= date_create($invoice_row->invoice_date);	
											$diff=date_diff($po_date,$invoice_date);
											$days=$diff->format("%R%a days");
											
										}
										

										$supply_qty+=$ci->common_model->read_number($invoice_row->arid_qty,$this->session->userdata['logged_in']['company_id']);

										$html.="<td title='Invoice No'>".$invoice_row->ar_invoice_no."</td>
										<td title='Invoice Date'>".$ci->common_model->view_date($invoice_row->invoice_date,$this->session->userdata['logged_in']['company_id'])."</td>
										<td title='Invoice Quantity'>".number_format($ci->common_model->read_number($invoice_row->arid_qty,$this->session->userdata['logged_in']['company_id']),2,'.',',')."</td>
										<td title='Net Amount'>".number_format($ci->common_model->read_number($invoice_row->total_price,$this->session->userdata['logged_in']['company_id']),2,'.',',')."</td>
										<td title='Amount Received'>".number_format($ci->common_model->read_number($invoice_row->amt_received,$this->session->userdata['logged_in']['company_id']),2,'.',',')."</td>
										<td>".$days."</td>
										";

										// if($r==0){

										// 	$html.="<td  rowspan='detail_rowspan'>".($mrow->for_export==1?"EXPORT":" ")."</td>
										// 	<td  rowspan='detail_rowspan'>".($mrow->for_sampling==1?"SAMPLE":" ")."</td>
								  //       	<td  rowspan='detail_rowspan'>";
								  //       	if($mrow->order_closed==0){
								  //            		$html.="OPEN";
							   //           	}
							   //           	if($mrow->order_closed==1){
							   //           		$html.="CLOSED";
							   //           	}
							   //           	if($mrow->order_closed==2){
							   //           		$html.="PARTIALLY CLOSED";
							   //           	}

								  //       $html.="</td>
								  //       <td  rowspan='detail_rowspan'>".($mrow->trans_closed==1?"MANUALLY CLOSED":"")."</td>";

										// }

										$html.="</tr>";
										
										
										if($invoice_rowspan>1){
											$html.="<tr>";
										}

										$r++;

										//----TOTAL--------
										$sum_invoice_quantity+=$ci->common_model->read_number($invoice_row->arid_qty,$this->session->userdata['logged_in']['company_id']);
										$sum_net_amount+=$ci->common_model->read_number($invoice_row->total_price,$this->session->userdata['logged_in']['company_id']);
										$sum_amount_received+=$ci->common_model->read_number($invoice_row->amt_received,$this->session->userdata['logged_in']['company_id']);


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
					echo"<tr>
							<td colspan='12' style='text-align:right;'><b>TOTAL</b></td>
							<td><b>".number_format($sum_order_quantity,0,'.',',')."</b></td>
							<td><b>".number_format($sum_total_jobcard_qty,0,'.',',')."</b></td>
							<td><b>".number_format($sum_invoice_quantity,0,'.',',')."</b></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td><b>".number_format($sum_invoice_quantity,0,'.',',')."</b></td>
							<td><b>".number_format($sum_net_amount,2,'.',',')."</b></td>
							<td><b>".number_format($sum_amount_received,2,'.',',')."</b></td>
							<!--<td></td>
							<td></td>
							<td></td>
							<td></td>-->
					</tr>";
				?>								
								
					</table>
					<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>
				
				
				
				
				
			