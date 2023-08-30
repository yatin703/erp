<div class="record_form_design">
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<h4>Sales Order Item Parameter Wise Records From <?php echo $this->input->post('from_date');?> TO <?php echo $this->input->post('to_date');?></h4>
	 <div class="record_inner_design" style="overflow: scroll;">
		
					<table class="record_table_design_without_fixed" >

						<tr>
							<th>Sr. No.</th>
							<th>Order No.</th>
							<th>Order Date</th>
							<th>Bill To</th>
							<th>Ship To</th>
							<th>Po No. / Po Date</th>
							<th>Currency</th>
							<th>Exchange Rate</th>
							<th>Layer</th>
							<th>Spec</th>
							<th>Artwork</th>
							<th>Article Code</th>
							<th>Article Name</th>
							<th>Delivery Date</th>
							<th>Sleeve Dia</th>
							<th>Sleeve Length</th>
							<th>Sleeve Master Batch</th>
							<th>Sleeve Print Type</th>
							<th>Shoulder Neck Type</th>
							<th>Shoulder Orifice</th>
							<th>Shoulder Master Batch</th>
							<th>Shoulder Foil Tag</th>
							<th>Cap Mold Finish</th>
							<th>Cap Orifice</th>
							
							<th>Cap Foil Color</th>
							<th>Cap foil Width</th>
							<th>Cap Height</th>
							<th>Quantity</th>
							<th>Unit Rate</th>
							<th>Net Amount</th>
							<th>Jobcards Generated</th>
							<th>Created By</th>
							<th>Approved By</th>
							<th>Approval Date</th>
							<th>Order Type</th>
							<th>Is Sample</th>
							<th>Order Status</th>
							<th>Transaction Status</th>
							<th>Action</th>
					
						</tr>
				<?php if($order_master==FALSE){
					echo "<tr><td colspan='7'>No Records Found</td></tr>";
				}
				else{
					// Instanciating Models--------------------------------------
					$ci =&get_instance();
					$ci->load->model('sales_order_item_parameterwise_model');
				    $ci->load->model('common_model');
				    $ci->load->model('article_model');
				    $ci->load->model('customer_model');

				    $sum_quantity=0;
				    $sum_net_amount=0;
				    			                	
				    $n=1;
					foreach($order_master as $mrow){

						$ship_to='';
						$ship_to_gst='';
						$currency='';
						$exchange_rate='';
						
						$sleeve_diameter='';
						$sleeve_length='';
						$sleeve_master_batch='';
						$sleeve_print_type='';
						$shoulder_type='';
						$shoulder_orifice='';
						$shoulder_master_batch='';
						$shoulder_foil_tag='';
						$cap_finish='';
						$cap_orifice='';
						$cap_master_bacth='';
						$cap_foil_color='';
						$cap_foil_width='';
						$cap_height='';

						// Ship to Details------------------------------------------

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

								$ship_to=$mrow->name1;
								$ship_to_gst=$mrow->isdn_local;
							}
						//Currency and Exchange rate-----------------------------------	

						$currency=($mrow->currency_id!='' ? $mrow->currency_id:'');
						$exchange_rate=($mrow->exchange_rate!='0' ?number_format($ci->common_model->read_number($mrow->exchange_rate,$this->session->userdata['logged_in']['company_id']),2,'.',','):'');	
						
						// Specification Parameter search------------------------- -----

						$data['spec_id']=$mrow->spec_id;
						$data['spec_version_no']=$mrow->spec_version_no;

						$search=array();
						if(!empty($this->input->post('sleeve_diameter'))){
                      		$search['sleeve_diameter']=$this->input->post('sleeve_diameter');
		                }
		                if(!empty($this->input->post('sleeve_print_type'))){
                      		$search['sleeve_print_type']=$this->input->post('sleeve_print_type');
		                }
		                if(!empty($this->input->post('shoulder_type'))){
		                    $search['shoulder_type']=$this->input->post('shoulder_type');
		                }
		                 if(!empty($this->input->post('shoulder_orifice'))){
		                    $search['shoulder_orifice']=$this->input->post('shoulder_orifice');
		                }
	                  	if(!empty($this->input->post('cap_orifice'))){
	                      $search['cap_orifice']=$this->input->post('cap_orifice');
	                  	}
	                  	if(!empty($this->input->post('cap_finish'))){
	                      $search['cap_finish']=$this->input->post('cap_finish');
		                }
			

						$specification_result=$ci->sales_order_item_parameterwise_model->select_specs_by_parameter('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$data,$search);
						
						if(count($specification_result)>0 OR 1){

							$sleeve_master_batch_desc='';
							$shoulder_master_batch_desc='';
							$cap_master_batch_desc='';

							foreach($specification_result as $specification_row){

								$sleeve_diameter=$specification_row->sleeve_diameter;
								$sleeve_length=$specification_row->sleeve_length;
								$sleeve_master_batch=$specification_row->sleeve_master_batch;
								$sleeve_print_type=$specification_row->sleeve_print_type;
								$shoulder_type=$specification_row->shoulder_type;
								$shoulder_orifice=$specification_row->shoulder_orifice;
								$shoulder_master_batch=$specification_row->shoulder_master_batch;
								$shoulder_foil_tag=$specification_row->shoulder_foil_tag;
								$cap_finish=$specification_row->cap_finish;
								$cap_orifice=$specification_row->cap_orifice;
								$cap_master_batch=$specification_row->cap_master_batch;
								$cap_foil_color=$specification_row->cap_foil_color;
								$cap_foil_width=$specification_row->cap_foil_width;
								$cap_height=$specification_row->cap_height;


								// Master batch code description------------------

								if($sleeve_master_batch!=''){
									$article_result=$ci->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$sleeve_master_batch);
								
									foreach($article_result as $article_row){
										$sleeve_master_batch_desc=$article_row->article_name;
									}
								}
								if($shoulder_master_batch!=''){

									$article_result=$ci->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$shoulder_master_batch);
								
									foreach($article_result as $article_row){
										$shoulder_master_batch_desc=$article_row->article_name;
									}
								}
								if($cap_master_batch!=''){

									$article_result=$ci->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$cap_master_batch);
								
									foreach($article_result as $article_row){
										$cap_master_batch_desc=$article_row->article_name;
									}
								}
								
							}
							
							// Jobcards generated--------------------------------
							$jobcard_data=array();
							$jobcard_data['sales_ord_no']=$mrow->order_no;
							$jobcard_data['article_no']=$mrow->article_no;

							$jobcard_result=$this->common_model->active_record_search('production_master',$jobcard_data,$this->session->userdata['logged_in']['company_id']);


							$layer="";
							$spec_id=$mrow->spec_id;
							$spec_version_no=$mrow->spec_version_no;
							$specification_sheet_result=$this->specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'spec_id',$spec_id,'spec_version_no',$spec_version_no);

							foreach ($specification_sheet_result as $specification_sheet_row) {
								$layer_arr=explode("|", $specification_sheet_row->dyn_qty_present);
								$layer=substr($layer_arr[1],0,1);
							}


							echo"<tr>
								<td>".$n++." <button type='button' name='add_cart' class='btn btn-sucess add_cart' data-sono='".$mrow->order_no."' data-articleno='".$mrow->article_no."'>ADD</button></td>
								<td>".($mrow->final_approval_flag==1 ? "<i class='check circle icon'></i>" : "")." <a href=".base_url('index.php/sales_order_book/view/'.$mrow->order_no)." target='_blank'>".$mrow->order_no."</a></td>
								<td>".$ci->common_model->view_date($mrow->order_date,$this->session->userdata['logged_in']['company_id'])."</td>
								<td>".$mrow->name1."</td>
								<td>".$ship_to."</td>
								<td>".$mrow->cust_order_no." / ".$ci->common_model->view_date($mrow->cust_order_date,$this->session->userdata['logged_in']['company_id'])."</td>
								<td>".$currency."</td>
								<td>".$exchange_rate."</td>
								";
								$article_result=$ci->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$mrow->article_no);
								
								foreach($article_result as $article_row){
									$article_name=$article_row->article_name.($article_row->article_sub_description!=''?' ('.$article_row->article_sub_description.')':'');


								}
								if($mrow->for_export==1){

									$net_amount=$ci->common_model->read_number($mrow->total_order_quantity,$this->session->userdata['logged_in']['company_id'])*$mrow->calc_sell_price;

								}else{

									$net_amount=$ci->common_model->read_number($mrow->total_order_quantity,$this->session->userdata['logged_in']['company_id'])* $ci->common_model->read_number($mrow->selling_price,$this->session->userdata['logged_in']['company_id']);
								}


								echo"
								<td>".$layer."</td>
								<td><a href='".base_url()."/index.php/specification/view/".$mrow->spec_id."/".$mrow->spec_version_no." ' target='blank'>".($mrow->spec_id!=""? $mrow->spec_id."_R".$mrow->spec_version_no:"")."</a></td>
								<td><a href='".base_url()."/index.php/artwork/view/".$mrow->ad_id."/".$mrow->version_no." ' target='blank'>".($mrow->ad_id!=""? $mrow->ad_id."_R".$mrow->version_no:"")."</a></td>
								<td>".$mrow->article_no."</td>
								<td>".$article_name."</td>
								<td>".$ci->common_model->view_date(($mrow->delivery_date!='0000-00-00'?$mrow->delivery_date:""),$this->session->userdata['logged_in']['company_id'])."</td>
								
								<td>".$sleeve_diameter."</td>
								<td>".$sleeve_length."</td>
								<td>".$sleeve_master_batch." [".$sleeve_master_batch_desc."]"."</td>
								<td>".$sleeve_print_type."</td>
								<td>".$shoulder_type."</td>
								<td>".$shoulder_orifice."</td>
								<td>".$shoulder_master_batch." [".$shoulder_master_batch_desc."]"."</td>
								<td>".$shoulder_foil_tag."</td>
								<td>".$cap_finish."</td>
								<td>".$cap_orifice."</td>
								
								<td>".$cap_foil_color."</td>
								<td>".$cap_foil_width."</td>
								<td>".$cap_height."</td>
								<td>".number_format($ci->common_model->read_number($mrow->total_order_quantity,$this->session->userdata['logged_in']['company_id']),2,'.',',')."</td>
								<td>".number_format($ci->common_model->read_number($mrow->selling_price,$this->session->userdata['logged_in']['company_id']),2,'.',',')."</td>
								<td>".number_format($net_amount,2,'.',',')."</td>
								<td>";
										$sum_actual_qty_manufactured=0;
									foreach($jobcard_result as $jobcard_row){
										echo "<a target='_blank' href='".base_url('index.php/'.$this->router->fetch_class().'/view/'.$jobcard_row->mp_pos_no.'/'.$mrow->spec_id.'/'.$mrow->spec_version_no)."' >";
										 echo $jobcard_row->mp_pos_no."=".number_format($ci->common_model->read_number($jobcard_row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']),2,'.',',');
										echo"</a>";
										echo"</br>";

										$sum_actual_qty_manufactured+=$ci->common_model->read_number($jobcard_row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']);
									}
									echo "<p style='color:red !important;'> <u>TOTAL_GENERATED=".number_format($sum_actual_qty_manufactured,2,'.',',')."</u></p>";

								echo"</td>
								<td>".($mrow->user_id!='' ? $ci->common_model->get_user_name($mrow->user_id,$this->session->userdata['logged_in']['company_id']): '')."</td>
								<td>".($mrow->approved_by!='' ? $ci->common_model->get_user_name($mrow->approved_by,$this->session->userdata['logged_in']['company_id']): '')."</td>
								<td>".$ci->common_model->view_date($mrow->approval_date,$this->session->userdata['logged_in']['company_id'])."</td>
								<td>".($mrow->for_export==1 ? "EXPORT":"LOCAL")."</td>
								<td>".($mrow->for_sampling==1 ? "SAMPLE":"")."</td>
								<td>";
					             	if($mrow->order_closed==0){
					             		echo "OPEN";
					             	}
					             	if($mrow->order_closed==1){
					             		echo "COMPLETED";
					             	}
					             	if($mrow->order_closed==2){
					             		echo "PARTIALLY COMPLETED";
					             	}
								echo "</td>
								<td>";
					             	if($mrow->trans_closed==1){
					             		echo "MANUALLY CLOSED";
					             	}
								             	
								echo "</td>
								<td>";
									foreach($formrights as $formrights_row){ 
										echo ($formrights_row->new==1 && $mrow->final_approval_flag==1 && $mrow->order_closed<>1 && $mrow->trans_closed<>1 ? '<a target="_blank" href="'.base_url('index.php/'.$this->router->fetch_class().'/job_card/'.$mrow->order_no.'/'.$mrow->article_no).'">Create Job Card</a> ' : '');
									}
								echo"</td>
								

							</tr>";
							// Total Sum----------------------

							$sum_net_amount+=$net_amount;
							$sum_quantity+=$ci->common_model->read_number($mrow->total_order_quantity,$this->session->userdata['logged_in']['company_id']);


						} //if

					} //Master foreach	
						
				
				
				 
					echo"<tr>
						<td colspan='27' style='text-align:right;'><b>TOTAL</b></td>
						<td><b>".number_format($sum_quantity,2,'.',',')."</b></td>
						<td></td>
						<td><b>".number_format($sum_net_amount,2,'.',',')."</b></td>
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
				}
			?>				
				</table>
					<div class="pagination"><?php echo $this->pagination->create_links();?></div>

					
		</div>
</div>

				
				
				
				
				
			