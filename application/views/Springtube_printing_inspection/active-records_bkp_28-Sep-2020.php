
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){

		
	    $("table tr").click(function(e){
	    	$("table tr").removeClass('on-hower');	
	        $(this).addClass('on-hower');
	    });    


	});
</script>

<style>
	.on-hower{
        background-color:#e4e4e4;
    }
	tr:hover {background-color:#e4e4e4;}
</style>
<style>	
   tr:hover {background-color:#e4e4e4;}
</style>
<div class="record_form_design">
	<h4>Active Records <?php echo ($this->input->post('from_date')!=''? 'From '.$this->input->post('from_date').' To '.$this->input->post('to_date'):'')?></h4>
	<div class="record_inner_design" style="overflow: scroll;white-space: nowrap;">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Action</th>
					<th>Sr no.</th>
					<th>Production Date</th>					
					<th>Shift</th>					
					<th>Machine</th>					
					<th>Customer</th>
					<th>Order No</th>
					<th>Article No.</th>
					<th>Product Name</th>
					<th>BOM No.</th>					
					<th>Dia</th>
					<th>Sleeve Length</th>
					<th>MB</th>
					<th>Printing Jobsetup</th>					
					<th>Job No.</th>
					<th>Jobcard No.</th>
					<th>Jobcard Qty</th>
					<th>Total Printed Output (Qty)</th>
					<th>Input Taken For Inspection (Qty)</th>
					<!--<th>Inspected Output (Meters)</th>-->					
					<th>Inspected Output (Qty)</th>

					<th>Total Waste Qty</th>					
				<!---	<th>QC Ok Qty</th>					
					<th>QC Hold Qty</th>
					<th>QC Name</th>
					<th>QC Remarks</th>
					<th>QC Status</th>
					<th>Qc Control Plan</th>
				-->
					<th>Side Trim Waste (Kg)</th>
					<th>QC Incharge</th>
					<th>Shift Issues</th>
					<th>Remarks</th>
					<th>User Name</th>
				<!--<th>Approved By</th>
					<th>Approval Date</th>	
				-->				
				</tr>
				<?php 


				if($springtube_printing_inspection_master==FALSE){
					echo "<tr><td colspan='30'>No Active Records Found</td></tr>";
				}else{
						$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
						
						//$reel_length=$this->config->item('springtube_reel_length');

						$sum_jobcard_qty=0;
						$sum_inspection_input_qty=0;
						//$sum_inspected_output_meters=0;
						$sum_inspected_output_qty=0;
						
						$sum_waste_qty=0;
						$sum_printing_output_qty=0;
						$sum_side_trim_waste=0;
						 				

						foreach($springtube_printing_inspection_master as $master_row){

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

							$result=$this->springtube_printing_inspection_model->active_details_records('springtube_printing_inspection_details',$details_data);
							//echo $this->db->last_query();	
							$rowspan=count($result);
					    	$tr=$rowspan;
					    	if($rowspan>0){					    		

								echo"<tr>
									<td rowspan='".$rowspan."'>";
									foreach ($formrights as $formrights_row) {

										echo ($formrights_row->view==1 ? ' | <a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$master_row->production_id.'').'" title="view" target="_blank"><i class="print icon"></i></a>' : '');

										echo ($formrights_row->modify==1 && $master_row->final_approval_flag<>1 ? ' | <a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$master_row->production_id.'').'" title="Modify" target="_blank"><i class="edit icon"></i></a>' : '');

										echo ($formrights_row->delete==1 ? ' | <a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$master_row->production_id.'').'" title="Delete" target="_blank"><i class="trash icon"></i></a> ' : '');
											
									}
									echo"</td>	
									
									<td rowspan='".$rowspan."'>".$i++."</td>
									<td rowspan='".$rowspan."'>".$this->common_model->view_date($master_row->production_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td rowspan='".$rowspan."'>".$master_row->shift."</td>
									
									<td rowspan='".$rowspan."'>".$master_row->machine_name."</td>";


									$r=0;
									foreach ($result as $details_row){
										//Jobcard details  //production_master----
										
										$jobcard_qty=0;
										$production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no', $details_row->jobcard_no);
              
					                    foreach($production_master_result as $production_master_row) {
					                      $order_no=$production_master_row->sales_ord_no;
					                      $article_no=$production_master_row->article_no;
					                      $jobcard_qty=$this->common_model->read_number($production_master_row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']);
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

										$printing_output_qty=0;
										$data_total_counter=array( 'jobcard_no'=>$details_row->jobcard_no);

						        		$result_total_counter=$this->springtube_printing_production_model->select_total_counter('springtube_printing_production_master',$data_total_counter);
						        		foreach ($result_total_counter as  $total_counter_row) {
						          			$total_counter=$total_counter_row->total_counter;
						          			$printing_output_qty=round($total_counter*2);
						        		}

										
										echo"
										<td>".$customer."</td>
										<td><a href='".base_url('index.php/sales_order_book/view/'.$order_no)."' target='_blank'> ".$order_no."</a></td>						
										<td>".$article_no."</td>
										<td>".$this->common_model->get_article_name($article_no,$this->session->userdata['logged_in']['company_id'])."</td>
										<td><a href='".base_url('index.php/bill_of_material/view/'.$bom_id)."' target='_blank'>".$bom_no."_".$bom_version_no."</td>
										
										<td>".$sleeve_diameter."</td>
										<td>".$sleeve_length."</td>
										<td>".$this->common_model->get_article_name($sleeve_mb_2,$this->session->userdata['logged_in']['company_id']).($sleeve_mb_6!=''?' ,'.$this->common_model->get_article_name($sleeve_mb_6,$this->session->userdata['logged_in']['company_id']):'')."</td>
										<td>";
								
										$data_search=array('jobcard_no'=>$details_row->jobcard_no,'archive'=>'0');

										$springtube_printing_jobsetup_master_result=$this->common_model->select_active_records_where('springtube_printing_jobsetup_master',$this->session->userdata['logged_in']['company_id'],$data_search);

										if($springtube_printing_jobsetup_master_result==TRUE){

											foreach ($springtube_printing_jobsetup_master_result as $key => $springtube_printing_jobsetup_master_row) {
											
												echo
												"<a href='".base_url('index.php/Springtube_printing_jobsetup/view/'.$springtube_printing_jobsetup_master_row->job_id)."' target='_blank' style='color:#06c806;'><i class='check circle icon'></i>Done</a>";
											}
										}else{

											echo'<a href="#" style="color: #f10606;"><i class="times circle icon"></i>Pending</a>';
										} 

										echo"</td>
										<td>JOB-".$details_row->job_pos_no."</td>
										<td><a href='".base_url('index.php/sales_order_item_parameterwise/view_new/'.$details_row->jobcard_no.'/'.$bom_no.'/'.$bom_version_no)."' target='_blank'>".$details_row->jobcard_no."</td>
										<td>".$jobcard_qty."</td>
										
										<td>".$printing_output_qty."</td>
										<td>".$details_row->inspection_input_qty."</td>
										
										<td>".$details_row->inspected_output_qty."</td>
										<td>".($jobcard_qty-$details_row->inspected_output_qty)."</td>
										<td>".$details_row->side_trim_waste."</td>";


										$sum_jobcard_qty+=$jobcard_qty;
										$sum_printing_output_qty+= $printing_output_qty;
										
										$sum_inspection_input_qty+=$details_row->inspection_input_qty;
										//$sum_inspected_output_meters+=$details_row->inspected_output_meters;
										$sum_inspected_output_qty+=$details_row->inspected_output_qty;

										$sum_waste_qty+=($jobcard_qty-$details_row->inspected_output_qty);

										$sum_side_trim_waste+=$details_row->side_trim_waste;
										//$sum_qc_hold_qty+=	$details_row->qc_hold_qty;	
										

										// foreach ($formrights as $formrights_row) {
											
										// 	if( $formrights_row->new=='1' && $formrights_row->copy=='1' && $details_row->qc_check =='0'){ 	

										// 		echo '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/qc_inspection/'.$master_row->production_id.'/'.$details_row->details_id).'" title="Qc Check" target="_blank"><i class="edit icon"></i></a>';
										// 	}else if($details_row->qc_check =='1'){
										// 		echo"<b>Qc Inspection done.</b>";
										// 	}else{
										// 		echo"<b>Qc Inspection Pending.</b>";
										// 	}

										// }
										// echo"<td>";
										// $springtube_bodymaking_control_plan_qc_result=$this->common_model->select_one_active_record('springtube_bodymaking_control_plan_qc',$this->session->userdata['logged_in']['company_id'],'jobcard_no',$details_row->jobcard_no);


										// foreach ($springtube_bodymaking_control_plan_qc_result as $springtube_bodymaking_control_plan_qc_row) {

										// 	echo '<a href="'.base_url('index.php/springtube_bodymaking_control_plan_qc/view/'.$springtube_bodymaking_control_plan_qc_row->cp_id.'').'" target="_blank" title="View"><i class="print icon"></i></a>';
										// 	echo '</br>';
										// }

										// echo"</td>";


										
										if($r==0){

											echo"<td rowspan='".$rowspan."'>".strtoupper($master_row->qc_incharge)."</td>
											<td rowspan='".$rowspan."'>".$master_row->shift_issues."</td>
											<td rowspan='".$rowspan."'>".$master_row->remarks."</td>
											<td rowspan='".$rowspan."'>".strtoupper($master_row->login_name)."</td>";
																			
									
										}


										echo "</tr>";
										if($rowspan>1 && --$tr>0){
											echo'<tr>';
										}

										$r++;

									}

																			
																

								


					        }//Rowspan IF

						}//master Foreach

						echo"<tr style='font-weight:bold;'><td colspan='16' style='text-align:right;'><b>TOTAL</b></td><td>".$sum_jobcard_qty."</td><td>".$sum_printing_output_qty."</td><td>".$sum_inspection_input_qty."</td> <td>".$sum_inspected_output_qty."</td><td>".$sum_waste_qty."</td><td>".$sum_side_trim_waste."</td><td></td><td></td><td></td><td></td</tr>";

					}?>


								
			</table>
			<div class="pagination"><?php echo $this->pagination->create_links();?></div>
	</div>
</div>