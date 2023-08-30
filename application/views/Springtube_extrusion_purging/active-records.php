<div class="record_form_design">
	<h4>Active Records <?php echo ($this->input->post('from_date')!=''? 'From '.$this->input->post('from_date').' To '.$this->input->post('to_date'):'')?></h4>
	<div class="record_inner_design" style="overflow: scroll;">
			<table class="ui sortable selectable celled table" style="font-size:10px;">
				<thead>
				<tr>
					<th>Action</th>
					<th>Sr No.</th>
					<th>Purging Date</th>
					<th>Jobcard No.</th>
					<th>Ref Jobcard no.</th>
					<th>Order No</th>
					<th>Order Date</th>
					<th>Customer</th>
					<th>Article No.</th>
					<th>Product Name</th>
					<th>BOM No.</th>
					<th>Film_code</th>
					<th>Dia</th>
					<th>Sleeve Length</th>					
					<th>Reason</th>
					<th>Remarks</th>
					<th>User Name</th>
					<th>Approved Date</th>
					<th>Approved By</th>
					<th>PurgingMaterial</th>
					<th>Quantity(Kg)</th>
					<th>Rate</th>					
					<th>Amount</th>											
					
				</tr>
			</thead>
				<?php if($springtube_extrusion_purging_master==FALSE){
					echo "<tr><td colspan='22'>No Active Records Found</td></tr>";
				}else{
						$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
						
						$sum_qty=0;
						$sum_amount=0;
						foreach($springtube_extrusion_purging_master as $master_row){
							$order_no='';
							$article_no;
							$customer='';
							$order_date='';
							$ad_id='';
							$version_no='';	
							$body_making_type='';
							$print_type_artwork='';
							$bom_no='';
							$bom_id='';
							$bom_version_no='';
							$total_order_quantity=0;

							$production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no', $master_row->ref_jobcard_no);
              
					                    foreach($production_master_result as $production_master_row) {
					                      $order_no=$production_master_row->sales_ord_no;
					                      $article_no=$production_master_row->article_no;
					                    }
					                    //Order details-----------
					                    $order_master_result=$this->sales_order_book_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_master.order_no',$order_no);
										foreach($order_master_result as $order_master_row){
											$customer=$order_master_row->customer_name;
											$order_date=$order_master_row->order_date;
										}

					                    $data_order_details=array(
					                    'order_no'=>$order_no,
					                    'article_no'=>$article_no
					                    );

					                    $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
					                    foreach($order_details_result as $order_details_row){
					                      $bom_no=$order_details_row->spec_id;
					                      $bom_version_no=$order_details_row->spec_version_no;
					                    }
					                    // BOM Details---------
					                    $data=array('bom_no'=>$bom_no,'bom_version_no'=>$bom_version_no);

					                    $bill_of_material_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data);

					                    foreach ($bill_of_material_result as $bill_of_material_row) {
					                      $bom_id=$bill_of_material_row->bom_id;
					                      $film_code=$bill_of_material_row->sleeve_code;
					                       
					                    }			                    				

				                		//SLEEVE---------------------------------

				                		$film_spec_id='';
				                		$film_spec_version='';

				                		$film_code_result=$this->common_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$film_code);

							    		foreach($film_code_result as $film_code_row){										
							    			$film_spec_id=$film_code_row->spec_id;
							    			$film_spec_version=$film_code_row->spec_version_no;
							    		}

								    	$specs['spec_id']=$film_spec_id;
										$specs['spec_version_no']=$film_spec_version;

										$specs_result=$this->sales_order_book_model->select_film_specs_record('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],$specs);
										
										if($specs_result){

											foreach($specs_result as $specs_row){
													$sleeve_diameter=$specs_row->SLEEVE_DIA;
													$sleeve_length=$specs_row->SLEEVE_LENGTH;
													$sleeve_mb_2=$specs_row->FILM_MASTER_BATCH_2;
													$sleeve_mb_6=$specs_row->FILM_MASTER_BATCH_6;				

											}											
										}

							$details_data=array();
							$details_data['purging_id']=$master_row->purging_id;
							
							// if(!empty($this->input->post('article_no'))){
							// 	$article_arr=explode("//",$this->input->post('article_no'));
							// 	$details_data['article_no']=$article_arr[1];
							// }							

							$result=$this->springtube_extrusion_purging_model->active_details_records('springtube_extrusion_purging_details',$details_data);
							//echo $this->db->last_query();	
							$rowspan=count($result);
					    	$tr=$rowspan;
							
					    	if($rowspan>0){			    		

								echo"<tr>
									<td rowspan='".$rowspan."'>";
									foreach ($formrights as $formrights_row) {

										echo ($formrights_row->approval=='1' && $master_row->final_approval_flag!='1' ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/approval/'.$master_row->purging_id.'').'" title="Approval" target="_blank"><i class="thumbs outline up icon"></i></a>' : '');


										echo ($formrights_row->view==1 ? ' | <a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$master_row->purging_id.'').'" title="view" target="_blank"><i class="print icon"></i></a>' : '');

										echo ($formrights_row->modify==1 && $master_row->final_approval_flag<>1 ? ' | <a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$master_row->purging_id.'').'" title="Modify" target="_blank"><i class="edit icon"></i></a>' : '');

										echo ($formrights_row->delete==1 ? ' | <a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$master_row->purging_id.'').'" title="Delete" target="_blank"><i class="trash icon"></i></a> ' : '');
											
									}
									echo"</td>	
									<td rowspan='".$rowspan."'>".$i++.($master_row->final_approval_flag== 1 ? "<i class='check circle icon'></i>" : "")."</td>			
									<td rowspan='".$rowspan."'>".$this->common_model->view_date($master_row->purging_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td rowspan='".$rowspan."'><a href='".base_url('index.php/sales_order_item_parameterwise/view_new/'.$master_row->jobcard_no.'/'.$bom_no.'/'.$bom_version_no)."' target='_blank'>".$master_row->jobcard_no."</td>
									<td rowspan='".$rowspan."'><a href='".base_url('index.php/sales_order_item_parameterwise/view_new/'.$master_row->jobcard_no.'/'.$bom_no.'/'.$bom_version_no)."' target='_blank'>".$master_row->ref_jobcard_no."</td>
									<td rowspan='".$rowspan."'><a href='".base_url('index.php/sales_order_book/view/'.$order_no)."' target='_blank'> ".$order_no."</a></td>
								    <td rowspan='".$rowspan."'>".$order_date."</td>
									<td rowspan='".$rowspan."'>".$customer."</td>
									<td rowspan='".$rowspan."'>".$article_no."</td>
									<td rowspan='".$rowspan."'>".$this->common_model->get_article_name($article_no,$this->session->userdata['logged_in']['company_id'])."</td>
									<td rowspan='".$rowspan."'><a href='".base_url('index.php/bill_of_material/view/'.$bom_id)."' target='_blank'>".$bom_no."_".$bom_version_no."</td>
									<td rowspan='".$rowspan."'><a href='".base_url('index.php/spring_film_specification/view/'.$film_spec_id.'/'.$film_spec_version)."' target='_blank'>".$film_code."</td>
									<td rowspan='".$rowspan."'>".$sleeve_diameter."</td>
									<td rowspan='".$rowspan."'>".$sleeve_length."</td>
									<td rowspan='".$rowspan."'>".$master_row->reason."</td>
									<td rowspan='".$rowspan."'>".$master_row->remarks."</td>
									<td rowspan='".$rowspan."'>".$this->common_model->get_user_name($master_row->user_id,$this->session->userdata['logged_in']['company_id'])."</td>

									<td rowspan='".$rowspan."'>".$this->common_model->get_user_name($master_row->approved_by,$this->session->userdata['logged_in']['company_id'])."</td>
									<td rowspan='".$rowspan."'>".($master_row->approved_date!='0000-00-00'? $this->common_model->view_date($master_row->approved_date,$this->session->userdata['logged_in']['company_id']):'')."</td>
								
									";											
									

									$r=0;
									foreach ($result as $details_row){

										// EXTRUSION TOTAL WIP----
										$rate=0;
										$amount=0;

										$reserved_quantity_manu_data=array();
										$reserved_quantity_manu_data['manu_order_no']=$master_row->jobcard_no;
										$reserved_quantity_manu_data['article_no']=$details_row->article_no;

										$reserved_quantity_manu_result=$this->common_model->select_active_records_where('reserved_quantity_manu',$this->session->userdata['logged_in']['company_id'],$reserved_quantity_manu_data);
										
										foreach ($reserved_quantity_manu_result as $reserved_quantity_manu_row) {
											$rate=$this->common_model->read_number($reserved_quantity_manu_row->calculated_purchase_price,$this->session->userdata['logged_in']['company_id']);
											$amount=$this->common_model->read_number($reserved_quantity_manu_row->amt_manual,$this->session->userdata['logged_in']['company_id']);
										}
													
										echo"
										<td>".$this->common_model->get_article_name($details_row->article_no,$this->session->userdata['logged_in']['company_id'])."</td>
										<td>".$details_row->quantity."</td>
										<td>".$rate."</td>
										<td>".$amount."</td>";

										if($r==0){

											echo"<td rowspan='".$rowspan."'></td><td rowspan='".$rowspan."'></td>";
										}
											
										$sum_qty+=$details_row->quantity;
										$sum_amount+=$amount;
										echo "</tr>";
										if($rowspan>1 && --$tr>0){
											echo'<tr>';
										}

										$r++;

									}


					        }//Rowspan IF

						}//master Foreach

						echo"<tr><td colspan='20' style='text-align:right;'><b>TOTAL</b></td><td>".$sum_qty."</td><td></td><td>".$sum_amount."</td></tr>";

					}?>


								
			</table>
			<div class="pagination"><?php echo $this->pagination->create_links();?></div>
	</div>
</div>