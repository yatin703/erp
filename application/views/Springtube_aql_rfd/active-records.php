<div class="record_form_design">
	<h4>Active Records <?php echo ($this->input->post('from_date')!=''? 'From '.$this->input->post('from_date').' To '.$this->input->post('to_date'):'')?></h4>
	<div class="record_inner_design" style="overflow: scroll; white-space: nowrap;">
			<table class="ui green sortable selectable celled table"  style="font-size:10px;">
				<tr>
					<thead>
					<th>Sr no.</th>
					<th>Action</th>					
					<th>AQL Date</th>
					<th>Customer</th>					
					<th>Order No</th>									
					<th>Article No.</th>					
					<th>Microns</th>
					<th>Dia X Length</th>
					<th>Second layer MB</th>					
					<th>Sixth Layer MB</th>
					<th>Jobcard No.</th>
					<th>Jobcard Qty</th>
					<th>Bodymaking O/P</th>
					<th>Inspected Qty</th>
					<th>Bodymaking Issues</th>
					<th>Printing Issues</th>
					<th>Total Rejected</th>
					<th>Counter Sample Tubes</th>
					<th>RFD Qty</th>
					<th>From Process</th>					
					<th>Remarks</th>														
					
				</tr>
			</thead>
			<tbody>
				<?php 

					
					$sum_bm_wip_qty=0;
					$sum_rfd_qty=0;
					$sum_inspected_qty=0;
					$sum_total_bodymaking_rejected=0;
					$sum_total_printing_rejected=0;
					$sum_total_rejected=0;
					$sum_counter_sample_qty=0;

					//$sum_reels=0;
					//$sum_reels_release=0;

				if($springtube_aql_rfd_master==FALSE){
					echo "<tr><td colspan='14'>No Active Records Found</td></tr>";
				}else{
						$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
						
						$reel_length=$this->config->item('springtube_reel_length');

						//$sum_total_meters_produced=0;
						

						foreach($springtube_aql_rfd_master as $master_row){

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

							$jobcard_qty=0;

							//Jobcard details  //production_master----
							$production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no', $master_row->jobcard_no);
  
		                    foreach($production_master_result as $production_master_row) {
		                      $order_no=$production_master_row->sales_ord_no;
		                      $article_no=$production_master_row->article_no;
		                      $jobcard_qty=$this->common_model->read_number($production_master_row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']);
		                    }
		                    //Order details-----------
		                    $order_master_result=$this->sales_order_book_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_master.order_no',$order_no);

							
							foreach($order_master_result as $order_master_row){
								$customer=$order_master_row->customer_no;
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
							

							echo"<tr>
										
									<td >".$i++."</td>
									<td>";
										foreach ($formrights as $formrights_row) {

										echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$master_row->aql_id.'').'" title="view" target="_blank"><i class="print icon"></i></a> ' : '');

										echo ($formrights_row->modify==1 ?' | <a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$master_row->aql_id.'').'" title="Modify" target="_blank"><i class="edit icon"></i></a> ' : '');

										echo ($formrights_row->delete==1 ? ' | <a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$master_row->aql_id.'').'" title="Delete" target="_blank"><i class="trash icon"></i></a> ' : '');
											
									}
									echo"</td>											
									<td>".$this->common_model->view_date($master_row->aql_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<!--<td>".$this->common_model->get_customer_name($customer,$this->session->userdata['logged_in']['company_id'])."</td>
									-->
									<td>".$this->common_model->get_parent_name($article_no,$this->session->userdata['logged_in']['company_id'])."</td>									
									<td><a href='".base_url('index.php/sales_order_book/view/'.$order_no)."' target='_blank'> ".$order_no."</a></td>
									<!--<td>".$this->common_model->view_date($order_date,$this->session->userdata['logged_in']['company_id'])."</td>
									-->
									
									<td title='".$this->common_model->get_article_name($article_no,$this->session->userdata['logged_in']['company_id'])."'>".$article_no."</td>

									<!--<td >".$this->common_model->get_article_name($article_no,$this->session->userdata['logged_in']['company_id'])."</td>

									<td><a href='".base_url('index.php/bill_of_material/view/'.$bom_id)."' target='_blank'>".$bom_no."_".$bom_version_no."</td>

											
									<td><a href='".base_url('index.php/spring_film_specification/view/'.$film_spec_id.'/'.$film_spec_version)."' target='_blank'>".$master_row->film_code."</td>
									-->
									<td>".$master_row->total_microns."</td>
									<td>".$master_row->sleeve_dia." X ".$master_row->sleeve_length."</td>
									<!--<td>".$master_row->sleeve_length."</td>
									-->

									<td>".$this->common_model->get_article_name($master_row->second_layer_mb,$this->session->userdata['logged_in']['company_id'])."</td>									
									<td>".$this->common_model->get_article_name($master_row->sixth_layer_mb,$this->session->userdata['logged_in']['company_id'])."</td>
									
									<td><a href='".base_url('index.php/sales_order_item_parameterwise/view_new/'.$master_row->jobcard_no.'/'.$bom_no.'/'.$bom_version_no)."' target='_blank'>".$master_row->jobcard_no."
									</td>
									<td class='positive' style='text-align:right;'><b>".number_format($jobcard_qty,0,'.',',')."</b> <i>NOS</i>
									</td>									
									<td class='positive' style='text-align:right;'><b>".number_format($master_row->bm_wip_qty,0,'.',',')."</b> <i>NOS</i>
									</td>
									<td class='positive' style='text-align:right;'><b>".number_format($master_row->inspection_qty,0,'.',',')."</b> <i>NOS</i>
									</td>
									<td class='negative' style='text-align:right;'><b>".number_format($master_row->total_rejected_bodymaking_issue,0,'.',',')."</b> <i>NOS</i>
									</td>
									<td class='negative' style='text-align:right;'><b>".number_format($master_row->total_rejected_printing_issue,0,'.',',')."</b> <i>NOS</i>
									</td>
									<td class='negative' style='text-align:right;'><b>".number_format($master_row->total_rejected_qty,0,'.',',')."</b> <i>NOS</i>
									</td>	
									<td class='negative' style='text-align:right;'><b>".($master_row->counter_sample_qty!=''?number_format($master_row->counter_sample_qty,0,'.',','):0)."</b> <i>NOS</i>
									</td>								
									<td class='positive' style='text-align:right;'><b>".number_format($master_row->rfd_qty,0,'.',',')."</b> <i>NOS</i>
									</td>			
																		
									
									<td>";
									$springtube_process_master_result=$this->common_model->select_one_active_record('springtube_process_master',$this->session->userdata['logged_in']['company_id'],'process_id',$master_row->from_process);
									foreach ($springtube_process_master_result as $springtube_process_master_row ) {
										echo $springtube_process_master_row->process_name;									
									}
										
									echo "</td>";
									
								$sum_bm_wip_qty+=$master_row->bm_wip_qty;
								$sum_rfd_qty+=$master_row->rfd_qty;
								$sum_inspected_qty+=$master_row->inspection_qty;
								$sum_total_bodymaking_rejected+=$master_row->total_rejected_bodymaking_issue;
								$sum_total_printing_rejected+=$master_row->total_rejected_printing_issue;
								$sum_total_rejected+=$master_row->total_rejected_qty;
								$sum_counter_sample_qty+=$master_row->counter_sample_qty;
										

						}//master Foreach

					echo"<tr><td colspan='12' style='text-align:right;'><b>TOTAL</b></td><td></td><td class='positive right aligned'><b>".number_format($sum_inspected_qty,0,'.',',')."</b> <i>NOS</i></td>

					<td class='negative right aligned'><b>".number_format($sum_total_bodymaking_rejected,0,'.',',')."</b> <i>NOS</i></td>
					<td class='negative right aligned'><b>".number_format($sum_total_printing_rejected,0,'.',',')."</b> <i>NOS</i></td>
					<td class='negative right aligned'><b>".number_format($sum_total_rejected,0,'.',',')."</b> <i>NOS</i></td>
					<td class='negative right aligned'><b>".number_format($sum_counter_sample_qty,0,'.',',')."</b> <i>NOS</i></td>
					<td class='positive right aligned'><b>".number_format($sum_rfd_qty,0,'.',',')."</b> <i>NOS</i></td>					
					
					<td></td>
					<td></td>

					</tr>";	

					}?>
				</tbody>				
			</table>
			<div class="pagination"><?php echo $this->pagination->create_links();?></div>
	</div>
</div>