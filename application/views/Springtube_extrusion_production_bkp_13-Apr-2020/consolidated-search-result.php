<div class="record_form_design">
	<h4>Film Extrusion Consolidated report <?php echo ($this->input->post('from_date')!=''? 'From '.$this->input->post('from_date').' To '.$this->input->post('to_date'):'')?></h4>
	<div class="record_inner_design" style="overflow: scroll;">
			<table class="record_table_design_without_fixed">
				<tr>
					 
					<th>Sr no.</th>
					<th>Production Date</th>					
					<th>Customer</th>
					<th>Order No</th>
					<!--<th>Order Date</th>-->					
					<th>Article No.</th>
					<th>Article Desc</th>					 
					<th>Order Qty</th>					 
					<th>Extrdusion Jobcards</th>
					<th>Planned Jobcard Meters</th>
					<th>Total Meter Produced</th> 
					<th>QC Hold Meters</th>
					<th>Final Ok Meters</th>
					<th>Extrusion Waste %</th>
					<th>Total WIP Meters</th>
					<th>Total Issued to Printing</th>		 

					
				</tr>
				<?php 

				if($springtube_extrusion_production_master==FALSE){
					echo "<tr><td colspan='22'>No Active Records Found</td></tr>";
				}else{
						$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
						
						$reel_length=$this->config->item('springtube_reel_length');

						$sum_total_meters_produced=0;						 
						$sum_total_ok_meters=0;						 
						$sum_total_qc_hold_meters=0;						 

						foreach($springtube_extrusion_production_master as $master_row){
					 		$customer='';
					 		$order_no='';
					 		$article_no='';					 
							$bom_no='';
							$bom_version_no='';
							$total_order_quantity=0;
							$no_of_reels=0;
							$reel_length=0;
							$total_meters=0;
							$total_ok_meters=0;

							// JOBCARDS DETAILS ----			
							$production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no', $master_row->jobcard_no);

							foreach($production_master_result as $production_master_row) {
					            $order_no=$production_master_row->sales_ord_no;
					            $article_no=$production_master_row->article_no;
					            $no_of_reels=$production_master_row->no_of_reels;
								$reel_length=$production_master_row->reel_length;
								$total_meters=$production_master_row->total_meters;

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
		                      $total_order_quantity=$this->common_model->read_number($order_details_row->total_order_quantity,$this->session->userdata['logged_in']['company_id']);
		                    }

		                    //WIP Details------------------------
		                    // EXTRUSION TOTAL WIP----			
							$extrusion_wip_data=array();
							$extrusion_wip_data['jobcard_no']=$master_row->jobcard_no;
							$extrusion_wip_data['next_process']='0';

							$extrusion_wip_result=$this->common_model->select_active_records_where('springtube_extrusion_wip_master',$this->session->userdata['logged_in']['company_id'],$extrusion_wip_data);
							$sum_total_wip_ok_meters=0;
							foreach ($extrusion_wip_result as $extrusion_wip_row) {
								$sum_total_wip_ok_meters+=$extrusion_wip_row->total_ok_meters;
							}
							

							// EXTRUSION ISSUED TO PRINTING----			
							$issued_to_printing_data=array();
							$issued_to_printing_data['jobcard_no']=$master_row->jobcard_no;
							$issued_to_printing_data['next_process']='9';

							$issued_to_printing_result=$this->common_model->select_active_records_where('springtube_extrusion_wip_master',$this->session->userdata['logged_in']['company_id'],$issued_to_printing_data);
							//echo $this->db->last_query();
							$sum_release_meters_to_printing=0;
							foreach ($issued_to_printing_result as $issued_to_printing_row) {
								$sum_release_meters_to_printing+=$issued_to_printing_row->release_meters;
							}
	                     	                    

							echo"<tr>
							<td>".$i++."</td>
							<td>".$this->common_model->view_date($master_row->production_date,$this->session->userdata['logged_in']['company_id'])."</td>
							<td>".$customer."</td>
							<td><a href='".base_url('index.php/sales_order_book/view/'.$order_no)."' target='_blank'> ".$order_no."</a></td>
							
							<td>".$article_no."</td>
							<td>".$this->common_model->get_article_name($article_no,$this->session->userdata['logged_in']['company_id'])."</td>
							<td>".$total_order_quantity."</td>
							<td><a href='".base_url('index.php/sales_order_item_parameterwise/view_new/'.$master_row->jobcard_no.'/'.$bom_no.'/'.$bom_version_no)."' target='_blank'>".$master_row->jobcard_no."</td>				
							<td>".$no_of_reels." X ".$reel_length." = ".$total_meters."</td> </td>
							<td>".$master_row->total_meters_produced."</td>
							 <td>".$master_row->total_qc_hold_meters."</td>
							<td>".$master_row->total_ok_meters."</td> 
							<td>".round(($total_meters-$master_row->total_ok_meters)/($total_meters*100))."</td> 
							<td>".$sum_total_wip_ok_meters."</td>
							<td>".$sum_release_meters_to_printing."</td>
							 
						
							</tr>";

										 

						}//master Foreach

						// echo"<tr><td colspan='15' style='text-align:right;'><b>TOTAL</b></td><td>".$sum_total_meters_produced."</td><td>".$sum_reels_produced."</td><td>".$sum_total_job_weight."</td><td>".$sum_total_waste."</td><td>".$sum_total_ok_meters."</td><td>".$sum_ok_reels."</td><td>".$sum_total_qc_hold_meters."</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";

					}?>


								
			</table>
			<div class="pagination"><?php echo $this->pagination->create_links();?></div>
	</div>
</div>