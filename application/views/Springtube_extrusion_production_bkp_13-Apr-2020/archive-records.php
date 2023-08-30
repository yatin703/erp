<div class="record_form_design">
	<h4>Archive Records <?php echo ($this->input->post('from_date')!=''? 'From '.$this->input->post('from_date').' To '.$this->input->post('to_date'):'')?></h4>
	<div class="record_inner_design" style="overflow: scroll;">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Action</th>
					<th>Sr no.</th>
					<th>Production Date</th>					
					<th>Shift</th>
					<th>Process</th>
					<th>Machine</th>
					<!--<th>QC Incharge</th>
					<th>Shift Issues</th>
					<th>Remarks</th>
					<th>User</th>
					<th>Approved By</th>
					<th>Approval Date</th>-->
					<th>Order No</th>
					<th>Order Date</th>
					<th>Customer</th>
					<th>Article No.</th>
					<th>Product Name</th>
					<th>BOM No.</th>
					<th>Film_code</th>
					<th>Dia</th>
					<th>Sleeve Length</th>
					<!--<th>MB 2nd Layer</th>
					<th>MB 6th Layer</th>					
					<th>Sleeve Length For Extrusion</th>
					<th>Order Qty</th>
					<th>Jobcard Qty</th>
					<th>Reel Width</th>
					<th>Ups</th>-->
					<th>Jobcard No.</th>
					<th>Total Meter Produced</th>					
					<th>Total Weight of Job (Kg)</th>
					<th>Total Waste (Kg)</th>
					<th>QC Ok Meters</th>
					<th>QC Hold Meters</th>
					<th>QC Name</th>
					<th>QC Remarks</th>
					<th>QC Status</th>
					<th>QC Incharge</th>
					<th>Shift Issues</th>
					<th>Remarks</th>
					<th>User Name</th>
					<th>Approved By</th>
					<th>Approval Date</th>											
					
				</tr>
				<?php if($springtube_extrusion_production_master==FALSE){
					echo "<tr><td colspan='22'>No Active Records Found</td></tr>";
				}else{
						$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
						
						$reel_length=$this->config->item('springtube_reel_length');

						$sum_total_meters_produced=0;
						$sum_total_ok_meters=0;
						$sum_total_qc_hold_meters=0;
						$sum_total_job_weight=0;									
						$sum_total_waste=0;

						foreach($springtube_extrusion_production_master as $master_row){

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

							$details_data=array();
							$details_data['production_id']=$master_row->production_id;

							if(!empty($this->input->post('jobcard_no'))){
								$details_data['jobcard_no']=$this->input->post('jobcard_no');
							}
							if(!empty($this->input->post('order_no'))){
								$details_data['order_no']=$this->input->post('order_no');
							}
							if(!empty($this->input->post('article_no'))){
								$article_arr=explode("//",$this->input->post('article_no'));
								$details_data['article_no']=$article_arr[1];
							}
							if(!empty($this->input->post('film_code'))){
								$film_code_arr=explode("//",$this->input->post('film_code'));
								$details_data['film_code']=$film_code_arr[1];
							}

							$result=$this->springtube_extrusion_production_model->inactive_details_records('springtube_extrusion_production_details',$details_data);
							//echo $this->db->last_query();	
							 $rowspan=count($result);
					    	$tr=$rowspan;
					    	if($rowspan>0){
					    		

								echo"<tr>
									<td rowspan='".$rowspan."'>";
									foreach ($formrights as $formrights_row) {

										echo ($formrights_row->dearchive==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/dearchive/'.$master_row->production_id.'').'" title="Dearchive" target="_blank">Dearchive</a> ' : '');
											
									}
									echo"</td>	
									<td rowspan='".$rowspan."'>".$i++.($master_row->final_approval_flag== 1 ? "<i class='check circle icon'></i>" : "")."</td>			
									<td rowspan='".$rowspan."'>".$this->common_model->view_date($master_row->production_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td rowspan='".$rowspan."'>".$master_row->shift."</td>
									<td rowspan='".$rowspan."'>".$master_row->process_name."</td>
									<td rowspan='".$rowspan."'>".$master_row->machine_name."</td>
								<!--<td rowspan='".$rowspan."'>".$master_row->qc_incharge."</td>
									<td rowspan='".$rowspan."'>".$master_row->shift_issues."</td>
									<td rowspan='".$rowspan."'>".$master_row->remarks."</td>
									<td rowspan='".$rowspan."'>".$master_row->login_name."</td>
									<td rowspan='".$rowspan."'>".$this->common_model->get_user_name($master_row->approved_by,$this->session->userdata['logged_in']['company_id'])."</td>
									<td rowspan='".$rowspan."'>".($master_row->approved_date!='0000-00-00'? $this->common_model->view_date($master_row->approved_date,$this->session->userdata['logged_in']['company_id']):'')."</td>
								-->
									";

									$sum_total_meters_produced=0;
									$sum_total_ok_meters=0;
									$sum_total_qc_hold_meters=0;
									$sum_total_job_weight=0;									
									$sum_total_waste=0;
									

									$r=0;
									foreach ($result as $details_row){
										//Jobcard details  //production_master----
										$production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no', $details_row->jobcard_no);
              
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
										
										echo"<td><a href='".base_url('index.php/sales_order_book/view/'.$order_no)."' target='_blank'> ".$order_no."</a></td>
										<td>".$this->common_model->view_date($order_date,$this->session->userdata['logged_in']['company_id'])."</td>
										<td>".$customer."</td>
										<td>".$article_no."</td>
										<td>".$this->common_model->get_article_name($article_no,$this->session->userdata['logged_in']['company_id'])."</td>
										<td><a href='".base_url('index.php/bill_of_material/view/'.$bom_id)."' target='_blank'>".$bom_no."_".$bom_version_no."</td>
										<td><a href='".base_url('index.php/spring_film_specification/view/'.$film_spec_id.'/'.$film_spec_version)."' target='_blank'>".$film_code."</td>
										<td>".$sleeve_diameter."</td>
										<td>".$sleeve_length."</td>
										<td><a href='".base_url('index.php/sales_order_item_parameterwise/view_new/'.$details_row->jobcard_no.'/'.$bom_no.'/'.$bom_version_no)."' target='_blank'>".$details_row->jobcard_no."</td>
										<td>".$details_row->total_meters_produced."</td>
										<td>".$details_row->total_job_weight."</td>
										<td>".$details_row->total_waste."</td>
										<td>".$details_row->total_ok_meters."</td>
										<td>".$details_row->total_qc_hold_meters."</td>
										<td>".$this->common_model->get_user_name($details_row->qc_id,$this->session->userdata['logged_in']['company_id'])."</td>
										<td>".$details_row->qc_remarks."</td>
										<td>";

										$sum_total_meters_produced+=$details_row->total_meters_produced;
										$sum_total_ok_meters+=$details_row->total_ok_meters;
										$sum_total_qc_hold_meters+=$details_row->total_qc_hold_meters;
										$sum_total_job_weight+=	$details_row->total_job_weight;	
										$sum_total_waste+=$details_row->total_waste;

										foreach ($formrights as $formrights_row) {

											if( $formrights_row->new=='1' && $formrights_row->copy=='1' && $details_row->qc_check =='0' && $master_row->final_approval_flag=='1'){ 

												echo '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/qc_inspection/'.$master_row->production_id.'/'.$details_row->details_id).'" title="Qc Check" target="_blank"><i class="edit icon"></i></a>';
											}else if($details_row->qc_check =='1'){
												echo"<b>Qc Inspection done.</b>";
											}else{
												echo"<b>Qc Inspection Pending.</b>";
											}

										}
										echo"</td>";
										if($r==0){

											echo"<td rowspan='".$rowspan."'>".$master_row->qc_incharge."</td>
											<td rowspan='".$rowspan."'>".$master_row->shift_issues."</td>
											<td rowspan='".$rowspan."'>".$master_row->remarks."</td>
											<td rowspan='".$rowspan."'>".$master_row->login_name."</td>
											<td rowspan='".$rowspan."'>".$this->common_model->get_user_name($master_row->approved_by,$this->session->userdata['logged_in']['company_id'])."</td>
											<td rowspan='".$rowspan."'>".($master_row->approved_date!='0000-00-00'? $this->common_model->view_date($master_row->approved_date,$this->session->userdata['logged_in']['company_id']):'')."</td>";
											
									

										}


										echo "</tr>";
										if($rowspan>1 && --$tr>0){
											echo'<tr>';
										}

										$r++;

									}											
																



					        }//Rowspan IF

						}//master Foreach

						echo"<tr><td colspan='22' style='text-align:right;'><b>TOTAL</b></td><td>".$sum_total_meters_produced."</td><td>".$sum_total_job_weight."</td><td>".$sum_total_waste."</td><td>".$sum_total_ok_meters."</td><td>".$sum_total_qc_hold_meters."</td><td></td><td></td><td></td></tr>";

					}?>


								
			</table>
			<div class="pagination"><?php echo $this->pagination->create_links();?></div>
	</div>
</div>