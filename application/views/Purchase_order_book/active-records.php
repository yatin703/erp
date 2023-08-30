<div class="record_form_design">
	<div class="record_inner_design" style="overflow: scroll;">
		
					<table class="record_table_design_without_fixed" >

						<tr>
							<th>Sr. No.</th>
							<th>PO No.</th>
							<th>PO Date</th>
							<th>So No.</th>
							<th>Supplier Name</th>
							<th>Supplier GSTIN </th>
							<th>Currency</th>
							<th>Exchange Rate</th>
							<th>Main Group</th>
							<th>HSN Code</th>
							<th>Article Code</th>
							<th>Article Name</th>
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
							<th>Packing</th>
							<th>Freight</th>
							<th>Insurance</th>
							<th>Gross Amount</th>
							<th>Created By</th>
							<th>Approve By</th>
							<th>Approval Date</th>
							<th>Order Type</th>
							<th>Order Status</th>
							<th>Transaction Status</th>
							<th>Action</th>
					
						</tr>
				<?php if($purchase_order_master==FALSE){
					echo "<tr><td colspan='7'>No Records Found</td></tr>";
				}
				else 
				{
					$ci =&get_instance();
					$ci->load->model('purchase_order_book_model');
				    $ci->load->model('common_model');
				    $ci->load->model('article_model');
				    $ci->load->model('supplier_model');

				    $sum_quantity=0;
				    $sum_net_amount=0;
				    $sum_total_tax=0;
				    $sum_gross_amount=0;
				    $sum_packing=0;
				    $sum_freight=0;
				    $sum_insu=0;

				    $currency='';
				    $exchange_rate='';
				    $n=1;
					foreach($purchase_order_master as $mrow){

						$details_data=array();
						$details_data['po_no']=$mrow->po_no;
						if(!empty($this->input->post('article_no'))){
							$arr=explode("//",$this->input->post('article_no'));
							$article_no=$arr[1];
							$details_data['article_no']=$article_no;
						}
							
						$result=$ci->purchase_order_book_model->active_details_records('purchase_order_details',$details_data,$this->session->userdata['logged_in']['company_id']);
						//echo $this->db->last_query();

						$currency=($mrow->currency_id!='' ? $mrow->currency_id:'');
						$exchange_rate=($mrow->exchange_rate!='0' ? number_format($ci->common_model->read_number($mrow->exchange_rate,$this->session->userdata['logged_in']['company_id']),2,'.',','):'');

						$rowspan=count($result);
					    $tr=$rowspan;

					    if($rowspan>0){

								
							echo "<tr>
							<td rowspan='".$rowspan."'>".$n++."</td>
							<td rowspan='".$rowspan."'>".($mrow->final_approval_flag==1 ? "<i class='check circle icon'></i>" : "")." <a href=".base_url('index.php/'.$this->router->fetch_class().'/view/'.$mrow->po_no.'')." target='_blank'>".$mrow->po_no."</a></td>
							<td rowspan='".$rowspan."'>".$ci->common_model->view_date($mrow->po_date,$this->session->userdata['logged_in']['company_id'])."</td>
							<td rowspan='".$rowspan."'>".$mrow->so_no." </td>
							<td rowspan='".$rowspan."'>".$mrow->name1." (".strtoupper($mrow->lang_property_name).") </td>
							<td rowspan='".$rowspan."'>".$mrow->isdn_local."</td>
							<td rowspan='".$rowspan."'>".$currency."</td>
							<td rowspan='".$rowspan."'>".$exchange_rate."</td>
							";
								
							$r=0;
							$article_name='';
							$hsn_code='';
							$main_group='';
							foreach ($result as $drow){

								$article_result=$ci->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$drow->article_no);
								
								if($article_result==FALSE){
									$hsn_code="";
								}else{
									foreach($article_result as $article_row){
									$article_name=$article_row->article_name;
									$hsn_code="";
									$main_group=$article_row->main_group;
								}
							}

								

								if($mrow->for_import==1){

									$rate=$ci->common_model->read_number($drow->pricing_unit,$this->session->userdata['logged_in']['company_id']);

									$net_amount=$ci->common_model->read_number($drow->net_price,$this->session->userdata['logged_in']['company_id']);

									// $net_amount=$ci->common_model->read_number($drow->total_order_quantity,$this->session->userdata['logged_in']['company_id'])*$drow->calc_sell_price;

								}else{

									$rate=$ci->common_model->read_number($drow->price_per_unit,$this->session->userdata['logged_in']['company_id']);

									$net_amount=$ci->common_model->read_number($drow->net_price,$this->session->userdata['logged_in']['company_id']);

									// $net_amount=$ci->common_model->read_number($drow->po_qty,$this->session->userdata['logged_in']['company_id'])* $ci->common_model->read_number($drow->price_per_unit,$this->session->userdata['logged_in']['company_id']);

								}
								

									echo"
									<td>".strtoupper($main_group)."</td>
									<td>".$hsn_code."</td>
									<td>".$drow->article_no."</td>
									<td>".$article_name."</td>
									
									<td>".number_format($ci->common_model->read_number($drow->po_qty,$this->session->userdata['logged_in']['company_id']),2,'.',',')."</td>
									<td>".number_format($rate,2,'.',',')."</td>

									<td>".number_format($net_amount,2,'.',',')."</td>

									<td>".number_format($ci->common_model->read_number($drow->total_tax,$this->session->userdata['logged_in']['company_id']),2,'.',',')."</td>
									
									";
									$arr=explode("|",$drow->tax_grid_amount);

									$edit=$drow->tax_pos_no;
									$result=$ci->purchase_order_book_model->select_tax('tax_grid_details',$this->session->userdata['logged_in']['company_id'],'tax_id',$edit,'priority');

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

					    				// SUM------------------------------
					    				$sum_gross_amount+=$ci->common_model->read_number($mrow->total_with_tax,$this->session->userdata['logged_in']['company_id']);
					    				$sum_packing+=$ci->common_model->read_number($mrow->transport_packing,$this->session->userdata['logged_in']['company_id']);
									    $sum_freight+=$ci->common_model->read_number($mrow->freight_amt,$this->session->userdata['logged_in']['company_id']);
									    $sum_insu+=$ci->common_model->read_number($mrow->insu_amt,$this->session->userdata['logged_in']['company_id']);


					    				echo"
					    					<td rowspan='".$rowspan."'>".number_format($ci->common_model->read_number($mrow->transport_packing,$this->session->userdata['logged_in']['company_id']),2,'.',',')."</td>
					    					<td rowspan='".$rowspan."'>".number_format($ci->common_model->read_number($mrow->freight_amt,$this->session->userdata['logged_in']['company_id']),2,'.',',')."</td>
					    					<td rowspan='".$rowspan."'>".number_format($ci->common_model->read_number($mrow->insu_amt,$this->session->userdata['logged_in']['company_id']),2,'.',',')."</td>
					    					<td rowspan='".$rowspan."'>".number_format($ci->common_model->read_number($mrow->total_with_tax,$this->session->userdata['logged_in']['company_id']),2,'.',',')."</td>
					    					<td class='ellipses' rowspan='".$rowspan."'>".substr(strtoupper($mrow->login_name),0,strpos($mrow->login_name,' '))."</td>
											<td class='ellipses' rowspan='".$rowspan."'>".substr(strtoupper($ci->common_model->get_user_name($mrow->approved_by,$this->session->userdata['logged_in']['company_id'])),0,strpos($ci->common_model->get_user_name($mrow->approved_by,$this->session->userdata['logged_in']['company_id']),' '))."</td>
								            <td  rowspan='".$rowspan."'>".$ci->common_model->view_date($mrow->approval_date,$this->session->userdata['logged_in']['company_id'])."</td>
								            <td  rowspan='".$rowspan."'>".($mrow->for_import==1?"IMPORT":"LOCAL")."</td>
								            <td  rowspan='".$rowspan."'>";
								             	if($mrow->po_grir_completed==0){
								             		echo "PENDING";
								             	}
								             	if($mrow->po_grir_completed==1){
								             		echo "COMPLETED";
								             	}
								             	if($mrow->po_grir_completed==2){
								             		echo "PARTIALLY COMPLETED";
								             	}
											echo "</td>
											<td  rowspan='".$rowspan."'>".($mrow->inv_created_flag==1?"CLOSED":"OPEN")."</td>";
											echo"<td rowspan='".$rowspan."'>";
											foreach($formrights as $formrights_row){ 

												echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$mrow->po_no.'').'" target="_blank"><i class="print icon"></i></a> ' : '');
												echo ($formrights_row->modify==1 && $mrow->final_approval_flag<>1  && $mrow->user_id==$this->session->userdata['logged_in']['user_id'] ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$mrow->po_no.'').'"><i class="edit icon"></i></a> ' : '');
												echo ($mrow->archive<>1 && $formrights_row->delete==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$mrow->po_no.'').'"><i class="trash icon"></i></a> ' : '');
												
											}
											echo "</td>";

					    			}

									echo"</tr>";
									if($rowspan>1 && --$tr>0){
											echo'<tr>';
									}			

									$r++;

									//------TOTAL----------
									$sum_quantity+=$ci->common_model->read_number($drow->po_qty,$this->session->userdata['logged_in']['company_id']);
									$sum_net_amount+=$net_amount;
									$sum_total_tax+=$ci->common_model->read_number($drow->total_tax,$this->session->userdata['logged_in']['company_id']);

							}

						}//detail if	
						
					}


				} 
				?>
				<?php  
					echo"<tr>
						<td colspan='12' style='text-align:right;'><b>TOTAL</b></td>
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
						<td><b>".number_format($sum_packing,2,'.',',')."</b></td>
						<td><b>".number_format($sum_freight,2,'.',',')."</b></td>
						<td><b>".number_format($sum_insu,2,'.',',')."</b></td>
						<td><b>".number_format($sum_gross_amount,2,'.',',')."</b></td>
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
				
				
				
				
				
			