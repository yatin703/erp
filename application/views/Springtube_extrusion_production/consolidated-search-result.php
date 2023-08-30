<style>	
   tr:hover {background-color:#e4e4e4;}
</style>
<div class="record_form_design">
	<h4>Film Extrusion Consolidated report <?php echo ($this->input->post('from_date')!=''? 'From '.$this->input->post('from_date').' To '.$this->input->post('to_date'):'')?></h4>
	<div class="record_inner_design" style="white-space: nowrap;overflow: scroll;">
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
					<th>Purging Jobcard</th>
					<th>Purging Weight</th>
					<th>Setup Jobcard</th>
					<th>Setup meters</th>					 
					<th>Extrdusion Jobcard</th>
					<th>Planned Jobcard Meters</th>
					<th>Total Meter Produced</th>
					<th>QC Status</th> 
					<th>QC Hold Meters</th>
					<th>Final Ok Meters</th>
					<th>QC Pending Meters</th>
					<th>QC to WIP</th>
					<th>QC to Scrap</th>					
					<th>Total WIP Meters</th>
					<!-- <th>Extrusion Waste %</th> -->
					<th>Total Issued to Printing</th>		 

					
				</tr>
				<?php 

				if($springtube_extrusion_production_master==FALSE){
					echo "<tr><td colspan='22'>No Active Records Found</td></tr>";
				}else{
						$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
						
						//$reel_length=$this->config->item('springtube_reel_length');

						$reel_length='';

						$sum_total_meters_produced=0;						 
						$sum_total_ok_meters=0;						 
						$sum_total_qc_hold_meters='';						 

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

		                    //TOTAL QC HOLD ---------------------------
							$data_qc_hold=array('details_id'=>$master_row->details_id,'status'=>'0','archive'=>0);
							$springtube_extrusion_qc_master_result=$this->common_model->select_active_records_where('springtube_extrusion_qc_master',$this->session->userdata['logged_in']['company_id'],$data_qc_hold);             								
							$total_qc_hold_meters=0;
							foreach ($springtube_extrusion_qc_master_result as $springtube_extrusion_qc_master_row) {
							 	$total_qc_hold_meters+=$springtube_extrusion_qc_master_row->total_qc_hold_meters;
							}

							//QC RELEASED TO WIP-----------------------------
							$data_qc_released=array('details_id'=>$master_row->details_id,'status'=>'1','next_process'=>'6','archive'=>0);
							$springtube_extrusion_qc_master_result=$this->common_model->select_active_records_where('springtube_extrusion_qc_master',$this->session->userdata['logged_in']['company_id'],$data_qc_released);             								
							$total_qc_release_meters_to_wip='';
							foreach ($springtube_extrusion_qc_master_result as $springtube_extrusion_qc_master_row){
							 	$total_qc_release_meters_to_wip+=$springtube_extrusion_qc_master_row->release_meters;
							}
							

							//QC RELEASED TO SCRAP---------------------------
							$dataa=array('details_id'=>$master_row->details_id,'status'=>'1','next_process'=>'11','archive'=>0);
							$springtube_extrusion_qc_master_result=$this->common_model->select_active_records_where('springtube_extrusion_qc_master',$this->session->userdata['logged_in']['company_id'],$dataa);             								
							$total_qc_release_meters_to_scrap='';
							foreach ($springtube_extrusion_qc_master_result as $springtube_extrusion_qc_master_row) {
							 	$total_qc_release_meters_to_scrap+=$springtube_extrusion_qc_master_row->release_meters;
							}

		                    //WIP Details------------------------
		                    // EXTRUSION TOTAL WIP----			
							$extrusion_wip_data=array();
							$extrusion_wip_data['details_id']=$master_row->details_id;
							$extrusion_wip_data['status']='0';
							$extrusion_wip_data['next_process']='0';
							$extrusion_wip_data['archive']='0';

							$extrusion_wip_result=$this->common_model->select_active_records_where('springtube_extrusion_wip_master',$this->session->userdata['logged_in']['company_id'],$extrusion_wip_data);
							$sum_total_wip_ok_meters='';
							foreach ($extrusion_wip_result as $extrusion_wip_row) {
								$sum_total_wip_ok_meters+=$extrusion_wip_row->total_ok_meters;
							}
							

							// EXTRUSION ISSUED TO PRINTING----			
							$issued_to_printing_data=array();
							$issued_to_printing_data['details_id']=$master_row->details_id;
							$issued_to_printing_data['status']='1';
							$issued_to_printing_data['archive']='0';

							$issued_to_printing_result=$this->common_model->select_active_records_where('springtube_extrusion_wip_master',$this->session->userdata['logged_in']['company_id'],$issued_to_printing_data);
							//echo $this->db->last_query();
							$sum_release_meters_to_printing='';
							foreach ($issued_to_printing_result as $issued_to_printing_row) {
								$sum_release_meters_to_printing+=$issued_to_printing_row->release_meters;
							}
	                     	                    

							echo"<tr ".($total_qc_hold_meters>0?"style='background-color:pink;'":"").">
							<td>".$i++."</td>
							<td>".$this->common_model->view_date($master_row->production_date,$this->session->userdata['logged_in']['company_id'])."</td>
							<td>".$customer."</td>
							<td><a href='".base_url('index.php/sales_order_book/view/'.$order_no)."' target='_blank'> ".$order_no."</a></td>
							
							<td>".$article_no."</td>
							<td>".$this->common_model->get_article_name($article_no,$this->session->userdata['logged_in']['company_id'])."</td>
							<td>".number_format($total_order_quantity)."</td>
							<td><a href='".base_url('index.php/sales_order_item_parameterwise/view_new/'.$master_row->purging_jobcard.'/'.$bom_no.'/'.$bom_version_no)."' target='_blank'>".$master_row->purging_jobcard."</td>
							<td>".$master_row->total_purging_weight."</td>
							<td><a href='".base_url('index.php/sales_order_item_parameterwise/view_new/'.$master_row->setup_jobcard_no.'/'.$bom_no.'/'.$bom_version_no)."' target='_blank'>".$master_row->setup_jobcard_no."</td>
							<td>".$master_row->total_setup_meters."</td>

							<td><a href='".base_url('index.php/sales_order_item_parameterwise/view_new/'.$master_row->jobcard_no.'/'.$bom_no.'/'.$bom_version_no)."' target='_blank'>".$master_row->jobcard_no."</td>				
							<td title='Planned Jobcard Meters'>".$no_of_reels." X ".$reel_length." = ".round($total_meters,2)."</td> </td>
							<td title='Total Meter Produced'>".$master_row->total_meters_produced."</td>
							<td>".($master_row->qc_check==0?" <a class='ui blue label'>QC Inspection Pending</a>":"<a class='ui green label'>QC Inspection Done</a>")."</td>
							 <td title='QC Hold Meters'>".($master_row->total_qc_hold_meters==0?"":$master_row->total_qc_hold_meters)."</td>
							<td title='Final Ok Meters'>".($master_row->total_ok_meters==0?"":$master_row->total_ok_meters)."</td>
							<td title='QC Pending Meters'>".$total_qc_hold_meters."</td>
							<td title='QC to WIP'>".$total_qc_release_meters_to_wip."</td>
							<td title='QC to Scrap'>".$total_qc_release_meters_to_scrap."</td>					 
							<td title='Total WIP Meters'>".$sum_total_wip_ok_meters."</td>
							<!--<td titel='Extrusion Waste %'>".round(($total_meters-$sum_total_wip_ok_meters)*100/$total_meters,2)."%</td>-->
							<td title='Issued To Printing'>".$sum_release_meters_to_printing."</td>							 
						
							</tr>";

										 

						}//master Foreach

						// echo"<tr><td colspan='15' style='text-align:right;'><b>TOTAL</b></td><td>".$sum_total_meters_produced."</td><td>".$sum_reels_produced."</td><td>".$sum_total_job_weight."</td><td>".$sum_total_waste."</td><td>".$sum_total_ok_meters."</td><td>".$sum_ok_reels."</td><td>".$sum_total_qc_hold_meters."</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";

				}?>


								
			</table>
			<div class="pagination"><?php echo $this->pagination->create_links();?></div>
	</div>
</div>