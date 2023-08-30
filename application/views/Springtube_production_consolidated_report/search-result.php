<div class="record_form_design">
<h4>Springtube Production Consolidated Rports Records From <?php echo $this->input->post('from_date');?> TO <?php echo $this->input->post('to_date');?></h4>
	<div class="record_inner_design">
		<table class="record_table_design_without_fixed">
			<tr>
				<th>Id</th>
				<th>Customer</th>
				<th>Order No</th>					
				<th>Article No</th>
				<th>Article Description</th>
				<th>Order Quantity</th>
				<th>Setup Jobcards</th>				 
				<th>Extrusion Jobcards</th>
				<th>Planned Jobcard Meters</th>
				<th>Produced Jobcard Meters</th>				
				<th>QC Hold Meters</th>
				<th>Final Ok Meters</th>
				<th>Extrusion Waste %</th>
				<th>Total WIP Meters</th>
				<th>Total Issued to Printing</th>

				<th>Action</th>
			</tr>
			<?php if($order_master==FALSE){
				echo "<tr><td colspan='14'>No Active Records Found</td></tr>";
			}else{
				$n=1;
				foreach($order_master as $order_master_row){	
						
							
					echo"<tr>
						<td>".$n++."</td>
						<td>".$this->common_model->get_customer_name($order_master_row->customer_no,$this->session->userdata['logged_in']['company_id'])."</td>						
						<td><a href=".base_url('index.php/sales_order_book/view/'.$order_master_row->order_no)." target='_blank'>$order_master_row->order_no</a></td>						
						<td>$order_master_row->article_no</td>
						<td>".$this->common_model->get_article_name($order_master_row->article_no,$this->session->userdata['logged_in']['company_id'])."</td>
						<td>".$this->common_model->read_number($order_master_row->total_order_quantity,$this->session->userdata['logged_in']['company_id'])."</td>
						<td>";
						   // SETUP JOBCARDS----			
							$setup_jobcard_data=array();
							$setup_jobcard_data['sales_ord_no']=$order_master_row->order_no;
							$setup_jobcard_data['article_no']=$order_master_row->article_no;
							$setup_jobcard_data['jobcard_type']='4';
							$setup_jobcard_data['archive']='0';

							$setup_jobcard_result=$this->common_model->select_active_records_where('production_master',$this->session->userdata['logged_in']['company_id'],$setup_jobcard_data);
							foreach ($setup_jobcard_result as $setup_jobcard_row) {
								echo $setup_jobcard_row->mp_pos_no;
								echo'<br/>';
							}

						echo"</td><td>";
							// EXTRUSION JOBCARDS----			
							$extrusion_jobcard_data=array();
							$extrusion_jobcard_data['sales_ord_no']=$order_master_row->order_no;
							$extrusion_jobcard_data['article_no']=$order_master_row->article_no;
							$extrusion_jobcard_data['jobcard_type']='1';

							$extrusion_jobcard_result=$this->common_model->select_active_records_where('production_master',$this->session->userdata['logged_in']['company_id'],$extrusion_jobcard_data);
							foreach ($extrusion_jobcard_result as $extrusion_jobcard_row) {
								echo $extrusion_jobcard_row->mp_pos_no;
								echo'<br/>';
							}

				    echo"</td><td>";
				    		foreach ($extrusion_jobcard_result as $extrusion_jobcard_row) {
								echo $extrusion_jobcard_row->no_of_reels.' X '.$extrusion_jobcard_row->reel_length.' = '.$extrusion_jobcard_row->no_of_reels*$extrusion_jobcard_row->reel_length;

								echo'<br/>';
							}

					echo"</td><td>";
							foreach ($extrusion_jobcard_result as $extrusion_jobcard_row) {
								//echo $extrusion_jobcard_row->mp_pos_no ;
								$extrusion_search=array('jobcard_no' =>$extrusion_jobcard_row->mp_pos_no);
								$springtube_extrusion_production_result=$this->springtube_extrusion_production_model->active_details_records('springtube_extrusion_production_details',$extrusion_search);
								$sum_total_meters_produced=0;
								foreach($springtube_extrusion_production_result as $springtube_extrusion_production_row){

									$sum_total_meters_produced+=$springtube_extrusion_production_row->total_meters_produced;

								}
								echo $sum_total_meters_produced;
								echo'<br/>';
							}
					 		
					echo"</td><td>";
							foreach ($extrusion_jobcard_result as $extrusion_jobcard_row) {
								//echo $extrusion_jobcard_row->mp_pos_no ;
								$extrusion_search=array('jobcard_no' =>$extrusion_jobcard_row->mp_pos_no);
								$springtube_extrusion_production_result=$this->springtube_extrusion_production_model->active_details_records('springtube_extrusion_production_details',$extrusion_search);
								$sum_total_qc_hold_meters=0;
								foreach($springtube_extrusion_production_result as $springtube_extrusion_production_row){

									$sum_total_qc_hold_meters+=$springtube_extrusion_production_row->total_qc_hold_meters;

								}
								echo $sum_total_qc_hold_meters;
								echo'<br/>';
							}
							

					echo"</td><td>";
						foreach ($extrusion_jobcard_result as $extrusion_jobcard_row) {
								//echo $extrusion_jobcard_row->mp_pos_no ;
								$extrusion_search=array('jobcard_no' =>$extrusion_jobcard_row->mp_pos_no);
								$springtube_extrusion_production_result=$this->springtube_extrusion_production_model->active_details_records('springtube_extrusion_production_details',$extrusion_search);
								$sum_total_ok_meters=0;
								foreach($springtube_extrusion_production_result as $springtube_extrusion_production_row){

									$sum_total_ok_meters+=$springtube_extrusion_production_row->total_ok_meters;

								}
								echo $sum_total_ok_meters;
								echo'<br/>';
							}
							

					echo"</td><td>";

					foreach ($extrusion_jobcard_result as $extrusion_jobcard_row) {
								//echo $extrusion_jobcard_row->mp_pos_no ;
								$extrusion_search=array('jobcard_no' =>$extrusion_jobcard_row->mp_pos_no);
								$springtube_extrusion_production_result=$this->springtube_extrusion_production_model->active_details_records('springtube_extrusion_production_details',$extrusion_search);
								$sum_total_ok_meters=0;
								foreach($springtube_extrusion_production_result as $springtube_extrusion_production_row){

									$sum_total_ok_meters+=$springtube_extrusion_production_row->total_ok_meters;

								}
								//echo $sum_total_ok_meters;
								echo ($extrusion_jobcard_row->total_meters-$sum_total_ok_meters)/$extrusion_jobcard_row->total_meters*100;

								echo'<br/>';
					}

					echo"</td><td>";

					// EXTRUSION TOTAL WIP----			
						$extrusion_wip_data=array();
						$extrusion_wip_data['order_no']=$order_master_row->order_no;
						$extrusion_wip_data['article_no']=$order_master_row->article_no;
						$extrusion_wip_data['next_process']='0';

						$extrusion_wip_result=$this->common_model->select_active_records_where('springtube_extrusion_wip_master',$this->session->userdata['logged_in']['company_id'],$extrusion_wip_data);
						$sum_total_wip_ok_meters=0;
						foreach ($extrusion_wip_result as $extrusion_wip_row) {
							$sum_total_wip_ok_meters+=$extrusion_wip_row->total_ok_meters;
						}
						echo $sum_total_wip_ok_meters;


					echo"</td><td>";

					// EXTRUSION ISSUED TO PRINTING----			
						$issued_to_printing_data=array();
						$issued_to_printing_data['order_no']=$order_master_row->order_no;
						$issued_to_printing_data['article_no']=$order_master_row->article_no;
						$issued_to_printing_data['next_process']='9';

						$issued_to_printing_result=$this->common_model->select_active_records_where('springtube_extrusion_wip_master',$this->session->userdata['logged_in']['company_id'],$issued_to_printing_data);
						$sum_release_meters_to_printing=0;
						foreach ($issued_to_printing_result as $issued_to_printing_row) {
							$sum_release_meters_to_printing+=$issued_to_printing_row->release_meters;
						}
						echo $sum_release_meters_to_printing;


					echo"</td><td>";


				    echo"</tr>";
				}
			}?>
								
		</table>
	<!-- <div class="pagination"><?php echo $this->pagination->create_links();?></div> -->
	</div>
</div>