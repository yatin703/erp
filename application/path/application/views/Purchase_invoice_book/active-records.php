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
							<th>Supplier Name</th>
							<th>Supplier GSTIN</th>							
							<th>Supplier Bill No.</th>
							<th>Supplier Bill Date</th>							
							<th>GRN No.</th>
							<th>Main Group</th>
							<th>Sub Group</th>
							<th>Second Sub Group</th>
							<th>HSN/SAC Code</th>
							<th>Article Code</th>
							<th>Article Name</th>
							<th>Unit</th>							
							<th>Quantity</th>
							<th>Unit Rate</th>
							<th>Amount</th>
							<th>Disc %/Amt Item wise</th>
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
							<th>Amount With Tax</th>
							<th>Disc % / Amt On Invoice</th>
							<th>Packing</th>
							<th>Freight</th>
							<th>Insurance</th>
							<th>Gross Amount</th>
							<th>Comments</th>
							<th>Invoice Type</th>							
							<th>Created By</th>
							
						</tr>
					</thead>
					<tbody>
				<?php if($ap_invoice==FALSE){
					echo "<tr><td colspan='7'>No Records Found</td></tr>";
				}
				else 
				{
					$ci =&get_instance();
					$ci->load->model('purchase_invoice_book_model');
				    $ci->load->model('common_model');
				    $ci->load->model('article_model');
				    $ci->load->model('customer_model');

				    $sum_quantity=0;
				    $sum_amount=0;
				    $sum_discount_amt_item_wise=0;
				    $sum_net_amount=0;
				    $sum_total_tax=0;
				    $sum_total_amount=0;
				    $sum_gross_amount=0;
				    $sum_freight=0;
				    $sum_packaging=0;
				    $sum_insurance=0;
				    $sum_discount=0;

				    $n=($this->uri->segment(3)==''?0:$this->uri->segment(3));
					foreach($ap_invoice as $mrow){

						// Article Search -------------------------------------
						$details_data=array();
						$details_data['ap_invoice_no']=$mrow->ap_invoice_no;
						if(!empty($this->input->post('article_no'))){
							$arr=explode("//",$this->input->post('article_no'));
							$article_no=$arr[1];
							$details_data['article_no']=$article_no;
						}
							
						$result=$ci->purchase_invoice_book_model->active_details_records('ap_invoice_details',$details_data,$this->session->userdata['logged_in']['company_id']);
						//echo $this->db->last_query();
						
						$rowspan=count($result);
					    $tr=$rowspan;

					    if($rowspan>0){
														
							echo "<tr>
							<td rowspan='".$rowspan."'>".++$n."</td>
							<td rowspan='".$rowspan."'>".($mrow->final_approval_flag==1 ? "<i class='check circle icon'></i>" : "")." <a href='http://192.168.0.50/ebizframe/images/000020/inv/".$mrow->invoice_image_nm."' target='_blank'>".$mrow->ap_invoice_no."</a></td>
							<td rowspan='".$rowspan."'>".$ci->common_model->view_date($mrow->invoice_date,$this->session->userdata['logged_in']['company_id'])."</td>
							<td rowspan='".$rowspan."'>".$mrow->name1." (".strtoupper($mrow->lang_property_name).") </td>
							<td rowspan='".$rowspan."'>".$mrow->isdn_local."</td>
							<td rowspan='".$rowspan."'>".$mrow->invoice_no."</td>
							<td rowspan='".$rowspan."'>".$mrow->received_date."</td>
							";
							
							$r=0;
							foreach ($result as $drow){
								$hsn_code='';
								// Article Info----------------------
								$article_result=$ci->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$drow->article_no);
								//echo $this->db->last_query();
								
								foreach($article_result as $article_row){

									$article_name=$article_row->article_name;
									$article_sub_description=$article_row->article_sub_description;
									$main_group=$article_row->main_group;
									$sub_group=$article_row->sub_group;
									$second_sub_group=$article_row->second_sub_group;
									$uom=$article_row->uom;

									$excise_rate_id=$article_row->excise_rate_id;

									$excise_rate_master=$ci->common_model->select_one_active_record('excise_rates_master',$this->session->userdata['logged_in']['company_id'],'excise_rates_master.erm_id',$excise_rate_id);

									foreach ($excise_rate_master as $key => $value) {
										$hsn_code=$value->cetsh_no;
									}
								}

								//GRN Info---------------------------------
								
								$delivery_note_no=$drow->ref_no;								
								$grir_purchase_header=$ci->common_model->select_one_active_record('grir_purchase_header',$this->session->userdata['logged_in']['company_id'],'delivery_note_no',$delivery_note_no);
								
								$grn_data=array();
								$grn_data['delivery_note_no']=$drow->ref_no;
								$grn_data['article_no']=$drow->article_no;
								$grn_result=$ci->purchase_invoice_book_model->active_details_records('grir_purchase_details',$grn_data,$this->session->userdata['logged_in']['company_id']);
								//echo $this->db->last_query();

								$po_no='';
								$po_date='';
								$import_flag='';

								foreach ($grir_purchase_header as $grir_purchase_header_row) {

									$grn_no=$grir_purchase_header_row->delivery_note_no;
									$grn_date=$grir_purchase_header_row->delivery_note_date;
									$import_flag=$grir_purchase_header_row->import_flag;
								}
						    
							 		$unit_rate=$ci->common_model->read_number($drow->unit_rate,$this->session->userdata['logged_in']['company_id']);
							 		$quantity=$ci->common_model->read_number($drow->quantity,$this->session->userdata['logged_in']['company_id']);

							 		$amount=$unit_rate*$quantity;

									$net_amount=$ci->common_model->read_number($drow->net_price,$this->session->userdata['logged_in']['company_id']);							
									$total_tax=$ci->common_model->read_number($drow->total_tax,$this->session->userdata['logged_in']['company_id']);
									$discount_perc_item_wise=$ci->common_model->read_number($drow->discount_perc,$this->session->userdata['logged_in']['company_id']);
									$discount_amt_item_wise=$ci->common_model->read_number($drow->discount_amount,$this->session->userdata['logged_in']['company_id']);

									$total_amount=$ci->common_model->read_number($drow->total_amount,$this->session->userdata['logged_in']['company_id']);

									echo"
									<td>".$grn_no."</td>
									<td>".strtoupper($main_group)."</td>
									<td>".strtoupper($sub_group)."</td>
									<td>".strtoupper($second_sub_group)."</td>
									<td>".$hsn_code."</td>
									<td>".$drow->article_no."</td>
									<td>".$article_name."</td>									
									<td>".$uom."</td>									
									<td>".number_format($quantity,2,'.',',')."</td>
									<td>".number_format($unit_rate,2,'.',',')."</td>
									<td>".number_format($amount,2,'.',',')."</td>
									<td>".number_format($discount_perc_item_wise,2,'.',',')."/".number_format($discount_amt_item_wise,2,'.',',')."</td>	
									<td>".number_format($net_amount,2)."</td>									
									<td>".number_format($total_tax,2,'.',',')."</td>
									
																	
									";

									$arr=explode("|",$drow->tax_calc_str);

									$edit=$drow->tax_pos_no;
									$result=$ci->purchase_invoice_book_model->select_tax('tax_grid_details',$this->session->userdata['logged_in']['company_id'],'tax_id',$edit,'priority');

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
					    			echo"<td>".number_format($total_amount,2)."</td>";

					    			if($r==0){   				
					    				

					    				$discount_perc=$ci->common_model->read_number($mrow->discount_per,$this->session->userdata['logged_in']['company_id']);
										$discount_amt=$ci->common_model->read_number($mrow->discount_amount,$this->session->userdata['logged_in']['company_id']);
										$freight=$ci->common_model->read_number($mrow->freight_amt,$this->session->userdata['logged_in']['company_id']);
										$packaging=$ci->common_model->read_number($mrow->packagingcost,$this->session->userdata['logged_in']['company_id']);
										$insurance=$ci->common_model->read_number($mrow->insu_amt,$this->session->userdata['logged_in']['company_id']);
										$gross_amount=$ci->common_model->read_number($mrow->total_amount_with_tax,$this->session->userdata['logged_in']['company_id']);


					    				echo"
					    				<td rowspan='".$rowspan."'>".number_format($discount_perc,2,'.',',')."/".number_format($discount_amt,2,'.',',')."</td>
										<td rowspan='".$rowspan."'>".number_format($freight,2,'.',',')."</td>
										<td rowspan='".$rowspan."'>".number_format($packaging,2,'.',',')."</td>
										<td rowspan='".$rowspan."'>".number_format($insurance,2,'.',',')."</td>	
										<td rowspan='".$rowspan."'>".number_format($gross_amount,2,'.',',')."</td>
										<td rowspan='".$rowspan."'>".$mrow->lang_remarks."</td>
					    				<td rowspan='".$rowspan."'>".($import_flag==1?"IMPORT":"LOCAL")."</td>
				    					<td class='ellipses' rowspan='".$rowspan."'>".substr(strtoupper($mrow->login_name),0,strpos($mrow->login_name,' '))."</td>";
								           
										$sum_gross_amount+=$gross_amount;
					    				$sum_freight+=$freight;
									    $sum_packaging+=$packaging;
									    $sum_insurance+=$insurance;
									    $sum_discount+=$discount_amt;	

					    			}

									echo"</tr>";
									if($rowspan>1 && --$tr>0){
											echo'<tr>';
									}			

									$r++;

									//------TOTAL----------
									$sum_quantity+=$ci->common_model->read_number($drow->quantity,$this->session->userdata['logged_in']['company_id']);
									$sum_amount+=$amount;
									$sum_discount_amt_item_wise+=$discount_amt_item_wise;
									$sum_net_amount+=$net_amount;
									$sum_total_tax+=$total_tax;
									$sum_total_amount+=$total_amount;

							}

						} //detail if	
						
					}


				} 
				?>
				<?php  
					echo"<tr>
						<td colspan='15' style='text-align:right;'><b>TOTAL</b></td>
						<td><b>".number_format($sum_quantity,2,'.',',')."</b></td>
						<td></td>
						<td><b>".number_format($sum_amount,2,'.',',')."</b></td>
						<td><b>".number_format($sum_discount_amt_item_wise,2,'.',',')."</b></td>
						<td><b>".number_format($sum_net_amount,2,'.',',')."</b></td>
						<td><b>".number_format($sum_total_tax,2,'.',',')."</b></td>";
							$i=0;
							foreach ($tax_header as $row){
					    		echo'<td><b>'.number_format($total_array[$i],2,'.',',').'</b></td>';
					    		$i++;
					    	}
						echo"
						<td>".number_format($sum_total_amount,2,'.',',')."</td>
						<td>".number_format($sum_freight,2,'.',',')."</td>
						<td>".number_format($sum_packaging,2,'.',',')."</td>
						<td>".number_format($sum_insurance,2,'.',',')."</td>
						<td>".number_format($sum_discount,2,'.',',')."</td>
						 <td><b>".number_format($sum_gross_amount,2,'.',',')."</b></td>
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
				
				
				
				
				
			