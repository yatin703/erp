 <style>
      .tableFixHead {
        overflow-y: auto;
        height: 500px;
      }
      .tableFixHead thead th {
        position: sticky;
        top: 0;
      }
      .right{
      	text-align: right;
      }
  </style>

<div class="record_form_design">
	<h3>Search Records</h3>
	<div class="record_inner_design" >
		<div class="tableFixHead">
			<table class="record_table_design_without_fixed"  >
				<thead>
				<tr>
					<th colspan="15" style="text-align: center;">Invoice Details</th>
					
					<th colspan="20" style="text-align: center;">Cost Summary</th>
					
				</tr>
				
				<tr>
					<th>Id</th>
					<th>Status</th>
					<th>Invoice Date</th>
					<th>Invoice</th>
					<th>Customer</th>
					<th>Order</th>
					<th>Product</th>
					<!--<th>Product Name</th>-->
					<th>Dia</th>
					<th>Length</th>
					<th>Layer</th>
					<th>Print Type</th>

					<th>Shoulder</th>
					<th>Net Amount</th>
					<th>Total Cost</th>
					<th>Quantity</th>
					<th>Unit Rate</th>
					<th>Total Cost/Tube</th>
					<th>Contribution</th>
					<th>Contr %</th>
					<th>Sleeve</th>
					<th>Purg</th>
					<th>Shoulder</th>
					<th>Printing</th>
					<th>Consumable</th>
					<th>Label</th>
					<th>Foil</th>
					<th>Shoulder Foil</th>
					<th>Cap</th>
					<th>Moulding Cost</th>
					<th>Shrink Sleeve</th>
					<th>Packing</th>
					<th>Stores & Spares</th>
					<th>Additional</th>
					<th>Freight</th>
					<th>Other Cost</th>
					<th>Total Cost</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				setlocale(LC_MONETARY, 'en_IN');
				if($costsheet_master==FALSE){
					echo "<tr><td colspan='7'>No Active Records Found</td></tr>";
				}else{
								$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
								$total_net_amount=0;
								$total_cost=0;
								$total_quantity=0;
								$total_sales_avg_unit_price=0;
								$total_contr_avg_unit_price=0;
								$total_cost_avg_unit_price=0;
								$total_sleeve_cost=0;
								$total_purging_cost=0;
								$total_shoulder_cost=0;
								$total_printing_cost=0;
								$total_cosumable_cost=0;
								$total_label_cost=0;
								$total_foil_cost=0;
								$total_shoulder_foil_cost=0;
								$total_capping_cost=0;
								 $total_moulding_cost=0;
								 $total_shrink_sleeve_cost=0;
								 $total_packaging_cost=0;
								 $total_stores_spares_cost=0;
								 $total_additional_cost=0;
								 $total_freight_cost=0;
								 $total_other_cost=0;
								 $total_total_costing=0;


							foreach($costsheet_master as $row){


										$order_no=$row->order_no;								
										$order_master_result=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$order_no);
										
										$so_data=array();
										$so_data['order_no']=$row->order_no;
										$so_data['article_no']=$row->article_no;
										$so_result=$this->sales_invoice_book_model->active_details_records('order_details',$so_data,$this->session->userdata['logged_in']['company_id']);

										foreach ($order_master_result as $order_master_row) {
											$trans_closed=$order_master_row->trans_closed;
											$order_flag=$order_master_row->order_flag;
										}

										foreach ($so_result as $so_row) {
											$so_quantity=$so_row->total_order_quantity;
										}

										$order_no=$row->order_no;								
										$order_master_result=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$order_no);

										$master_array= array('article_no' => $row->article_no,
		                                                'sales_ord_no'=>$row->order_no);
		                          
		                          		$data1=array_filter($master_array);                      
		                          		$data2['job_card']=$this->job_card_model->active_record_search('production_master',$data1,$from="",$to="",$this->session->userdata['logged_in']['company_id']);
		                          	
				                      /* $address_master_result=$this->common_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'adr_company_id',$row->customer_id);

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
							$search_arr=array('ref_ord_no'=>$row->order_no,
											  'article_no'=>$row->article_no);
							
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
									$status="Manual Closed (Order cancelled)";
									$cancel_qty=number_format($total_order_quantity- $supplyqty,2,'.',',');
									$status.=number_format($total_order_quantity - $supplyqty,2,'.',',');
								}
								else if($supplyqty<$minus_tolerance_qty && $supplyqty>$minus_factory_dispatch_qty){																
									$status="Manual Closed";
									$cancel_qty=number_format($total_order_quantity - $supplyqty,2,'.',',');
									$status.=number_format($total_order_quantity - $supplyqty,2,'.',',');
								}
								elseif($supplyqty>=$minus_tolerance_qty && $supplyqty<$total_order_quantity){
									$status="Short Closed ";
									//$cancel_qty=number_format(get_value($row_order_details['total_order_quantity'])- $supplyqty,2,'.',',');
									$status.=number_format($total_order_quantity- $supplyqty,2,'.',',');
								}
								else{
									
									$status="Completed ";
								}
								
							}else{								
								
								if($total_order_quantity<=$supplyqty && $supplyqty<>0){
									$status="Completed ";
									$flag=1;

									//$status="Completed (INV)";
								}
								elseif($total_order_quantity>$supplyqty && $supplyqty<>0){
									$status="Pending ";
									//$status="Partially Completed (INV)";
									$status.=number_format($total_order_quantity- $supplyqty,2,'.',',');
									$flag=0;

								}
								else{
									$flag=0;
									$status="Pending";
								}
								
							}

								*/

							$status="";
							$status=$this->sales_order_book_model->get_order_status($row->order_no);
							$invoice=array('ar_invoice_no'=>$row->invoice_no,'article_no'=>$row->article_no);
							$invoice_details=$this->common_model->select_one_active_record_nonlanguage_without_archives('ar_invoice_details',$this->session->userdata['logged_in']['company_id'],$invoice);
							if($invoice_details==FALSE){
								$layer_no="";
							}else{
								foreach($invoice_details as $invoice_details_row){
									$layer_no=$invoice_details_row->layer_no;
								}
							}
							$da=array('ar_invoice_no'=>$row->invoice_no,'article_no'=>$row->article_no);
							$shoulder_result=$this->common_model->select_one_active_record_nonlanguage_without_archives('ar_invoice_details',$this->session->userdata['logged_in']['company_id'],$da);
							if($shoulder_result==TRUE){
								foreach($shoulder_result as $shoulder_row){
									$shoulder_type=$shoulder_row->shoulder_type;
								}
							}else{
								$shoulder_type="";
							}

							echo "<tr ".($this->sales_order_book_model->get_order_status($row->order_no)=='Completed' ? 'style="background-color:#c2fbc2"' : '')." >
									<td>".$i."</td>
									<td>".$this->sales_order_book_model->get_order_status($row->order_no)."</td>
									<td>".$this->common_model->view_date($row->invoice_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td><a href='".base_url('index.php/costsheet/view/'.$row->invoice_no.'/'.$row->order_no.'/'.$row->article_no)."' target='_blank'>".$row->invoice_no."</td>
									<td>".$this->common_model->get_parent_name($row->article_no,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$row->order_no."</td>
									<td>".$row->article_no."</td>
									"; //<td>".$this->common_model->get_article_name($row->article_no,$this->session->userdata['logged_in']['company_id'])."</td>
									echo "
									<td>".$row->dia."</td>
									<td>".$row->length."</td>
									<td>".$layer_no."</td>
									<td>".$row->print_type."</td>

									<td>".$shoulder_type."</td>

									<td>".money_format('%.0n',$row->dispatch_quantity*$row->unit_rate)."</td>
									<td>".money_format('%.0n',$row->total_costing)."</td>
									<td>".money_format('%!.0n',$row->dispatch_quantity)."</td>
									<td><b>".$row->unit_rate."</b></td>
									<td>".$row->total_cost."</td>
									<td><b>".$row->con_per_tube."</b></td>
									<td>".(round((($row->unit_rate-$row->total_cost)/$row->unit_rate)*100)>50 ? "<a class='ui green circular label'>".round((($row->unit_rate-$row->total_cost)/$row->unit_rate)*100)."%</a>" : "<a class='ui red circular label'>".round((($row->unit_rate-$row->total_cost)/$row->unit_rate)*100)."%</a>")." </td>
									<td class='right'>".($row->sleeve_cost!=0 ? money_format('%.0n',$row->sleeve_cost) : '')."</td>
									<td class='right aligned'>".($row->purging_cost!=0 ? money_format('%.0n',$row->purging_cost) : '')."</td>
									<td class='right aligned'>".($row->shoulder_cost!=0 ? money_format('%.0n',$row->shoulder_cost) : '')."</td>
									<td class='right aligned'>".($row->printing_cost!=0 ? money_format('%.0n',$row->printing_cost) : '')."</td>
									<td class='right aligned'>".($row->cosumable_cost!=0 ? money_format('%.0n',$row->cosumable_cost) : '')."</td>
									<td class='right aligned'>".($row->label_cost!=0 ? money_format('%.0n',$row->label_cost) : '')."</td>
									<td class='right aligned'>".($row->foil_cost!=0 ? money_format('%.0n',$row->foil_cost) : '')."</td>
									<td class='right aligned'>".($row->shoulder_foil_cost!=0 ? money_format('%.0n',$row->shoulder_foil_cost) : '')."</td>
									<td class='right aligned'>".($row->capping_cost!=0 ? money_format('%.0n',$row->capping_cost) : '')."</td>
									<td class='right aligned'>".($row->moulding_cost!=0 ? money_format('%.0n',$row->moulding_cost) : '')."</td>
									<td class='right aligned'>".($row->shrink_sleeve_cost!=0 ? money_format('%.0n',$row->shrink_sleeve_cost) : '')."</td>
									<td class='right aligned'>".($row->packaging_cost!=0 ? money_format('%.0n',$row->packaging_cost) : '')."</td>
									<td class='right aligned'>".($row->stores_spares_cost!=0 ? money_format('%.0n',$row->stores_spares_cost) : '')."</td>
									<td class='right aligned'>".($row->additional_cost!=0 ? money_format('%.0n',$row->additional_cost) : '')."</td>
									<td class='right aligned'>".($row->freight_cost!=0 ? money_format('%.0n',$row->freight_cost) : '')."</td>
									<td class='right aligned'>".($row->other_cost!=0 ? money_format('%.0n',$row->other_cost) : '')."</td>
									<td class='right aligned'>".($row->total_costing!=0 ? money_format('%.0n',$row->total_costing) : '')."</td>
									
								 </tr>";
								 $i++;
								 $total_net_amount+=$row->dispatch_quantity*$row->unit_rate;
								 $total_cost+=$row->total_costing;
								 $total_quantity+=$row->dispatch_quantity;
								 $total_sleeve_cost+=$row->sleeve_cost;
								 $total_purging_cost+=$row->purging_cost;
								 $total_shoulder_cost+=$row->shoulder_cost;
								 $total_printing_cost+=$row->printing_cost;
								 $total_cosumable_cost+=$row->cosumable_cost;
								 $total_label_cost+=$row->label_cost;
								 $total_foil_cost+=$row->foil_cost;
								 $total_shoulder_foil_cost+=$row->shoulder_foil_cost;
								 $total_capping_cost+=$row->capping_cost;
								 $total_moulding_cost+=$row->moulding_cost;
								 $total_shrink_sleeve_cost+=$row->shrink_sleeve_cost;
								 $total_packaging_cost+=$row->packaging_cost;
								 $total_stores_spares_cost+=$row->stores_spares_cost;
								 $total_additional_cost+=$row->additional_cost;
								 $total_freight_cost+=$row->freight_cost;
								 $total_other_cost+=$row->other_cost;
								 $total_total_costing+=$row->total_costing;

							}
							$total_sales_avg_unit_price=$total_net_amount/$total_quantity;
							$total_cost_avg_unit_price=$total_cost/$total_quantity;
							$total_contr_avg_unit_price=($total_sales_avg_unit_price-$total_cost_avg_unit_price);
							echo "<tr>
									<td colspan='12'></td>
									<td>".money_format('%.0n',$total_net_amount)."</td>
									<td>".money_format('%.0n',$total_cost)."</td>
									<td>".money_format('%!.0n',$total_quantity)."</td>
									<td><a class='ui green circular label'>".number_format($total_sales_avg_unit_price,2)."</a></td>
									<td><a class='ui red circular label'>".number_format($total_cost_avg_unit_price,2)."</a></td>
									<td><a class='ui blue circular label'>".number_format($total_contr_avg_unit_price,2)."<a/></td>
									<td>".(number_format(($total_contr_avg_unit_price/$total_sales_avg_unit_price)*100) >50 ? "<a class='ui green circular label'>".number_format(($total_contr_avg_unit_price/$total_sales_avg_unit_price)*100)."%</a>" : "<a class='ui red circular label'>".number_format(($total_contr_avg_unit_price/$total_sales_avg_unit_price)*100)."%</a>")."</td>
									<td>".money_format('%.0n',$total_sleeve_cost)."</td>
									<td>".money_format('%.0n',$total_purging_cost)."</td>
									<td>".money_format('%.0n',$total_shoulder_cost)."</td>
									<td>".money_format('%.0n',$total_printing_cost)."</td>
									<td>".money_format('%.0n',$total_cosumable_cost)."</td>
									<td>".money_format('%.0n',$total_label_cost)."</td>
									<td>".money_format('%.0n',$total_foil_cost)."</td>
									<td>".money_format('%.0n',$total_shoulder_foil_cost)."</td>
									<td>".money_format('%.0n',$total_capping_cost)."</td>
									<td>".money_format('%.0n',$total_moulding_cost)."</td>
									<td>".money_format('%.0n',$total_shrink_sleeve_cost)."</td>
									<td>".money_format('%.0n',$total_packaging_cost)."</td>
									<td>".money_format('%.0n',$total_stores_spares_cost)."</td>
									<td>".money_format('%.0n',$total_additional_cost)."</td>
									<td>".money_format('%.0n',$total_freight_cost)."</td>
									<td>".money_format('%.0n',$total_other_cost)."</td>
									<td>".money_format('%.0n',$total_total_costing)."</td>
									</tr>";
						}?>
						</tbody>
						</table>
	</div>				
	</div>
</div>