<style>	
   tr:hover {background-color:#e4e4e4;}
</style>
<div class="record_form_design">
	<h4>Active Records <?php echo ($this->input->post('from_date')!=''? 'From '.$this->input->post('from_date').' To '.$this->input->post('to_date'):'')?></h4>
	<div class="record_inner_design" style="overflow: scroll; white-space: nowrap;">
			<table class="ui green sortable celled table"  style="font-size:9px;">
				<tr>
					<thead>
						<th style="text-align:center" colspan="9">Order Details</th>
						<th style="text-align:center" colspan="6">Printing</th>
						<th style="text-align:center" colspan="8">Inspection</th>
						<th style="text-align:center" colspan="8">Bodymaking</th>
						<th style="text-align:center" colspan="8">SQC</th>
						<th style="text-align:center" colspan="3">RFD</th>
					</thead>
				</tr>
				<tr>
					<thead>
					<th>Sr no.</th>					
					<th>Action</th>		
					<th>Date</th>
					<th>Customer</th>					
					<th>Order No</th>									
					<th>Article No.</th>
					<!-- <th>Article Desc</th>					 -->
					<!-- <th>Microns</th> -->
					<th>Dia</th>
					<th>Length</th>
				<!--<th>Second layer MB</th>					
					<th>Sixth Layer MB</th>
				-->
					<th>Order Qty</th>
					<th>Jobcard %</th>
					<!-- Printing -->
					<th>Jobcard Qty</th>
					<th>Production</th>
					<th>Scrap</th>					
					<th>Status</th>
					<th>R %</th>

					<!-- Inspection -->
					<th>Insp.<SUP>n</SUP> Input</th>
					<th>Insp.<SUP>n</SUP> Done</th>
					<th>Insp.<SUP>n</SUP> Pending</th>
					<th>Scrap</th>								
					<th>WIP</th>
					<th>WIP Scrap</th>					
					<th>Status</th>	
					<th>R %</th>		
					<!-- Bodymaking -->
					<th>Jobcard Qty</th>					
					<th>OK Qty</th>
					<th>QC Pending</th>
					<th>QC Hold</th>
					<th>Scrap</th>
					<th>WIP</th>
					<th>WIP Scrap</th>
					<th>Status</th>

					<th>SQC Input</th>
					<th>SQC Output</th>
					<th>Total SQC Reject<sup>n</sup></th>
					<th>SQC Print.. Reject<sup>n</sup></th>
					<th>SQC Body.. Reject<sup>n</sup>
					<th>Counter Sample</th> 
					<th>Status</th>
					<th>R %</th>
<!-- 					<th>Printing R %</th>
					<th>Bodymaking R%</th> -->

					<th>Total RFD</th>
					<th>Dispatched Qty</th>
					<th>R %</th>
					
				</tr>
			</thead>
			<tbody>
				<?php 

					
					$sum_total_jobcard_qty=0;
					$sum_total_printing_qty=0;
					$sum_total_scrap_qty=0;
					$sum_total_inspection_qty=0;
					$sum_total_printing_wip=0;
					// $sum_release_qty=0;
					$sum_total_bodymaking_jobcard_qty=0;
					$sum_total_bodymaking_ok_qty=0;							
					$sum_total_bodymaking_wip=0;
					
					$sum_total_aql_input=0;
					$sum_total_aql_output=0;
					$sum_total_aql_rejection=0;
					$sum_total_rfd_qty=0;
					$sum_total_dispatch_qty=0;

				if($springtube_printing_production_master==FALSE){
					echo "<tr><td colspan='14'>No Active Records Found</td></tr>";
				}else{
						$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
						
						$reel_length=$this->config->item('springtube_reel_length');

						//$sum_total_meters_produced=0;
						

						foreach($springtube_printing_production_master as $master_row){

							$customer='';	
							$customer='';               
			                $order_no='';
			                $article_no='';
			                $order_qty=0;
			                $sleeve_diameter='';
			                $sleeve_length='';
			                $total_microns='';
			                $film_mb_2='';
			                $film_mb_6='';
			                $film_code='';						
		                    $order_master_result=$this->sales_order_book_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_master.order_no',$master_row->order_no);

							$hold_flag=0;
							foreach($order_master_result as $order_master_row){
								$customer=$order_master_row->customer_no;
								$order_date=$order_master_row->order_date;
								$hold_flag=$order_master_row->hold_flag;
							}

		                    $data_order_details=array(
		                    'order_no'=>$master_row->order_no,
		                    'article_no'=>$master_row->article_no
		                    );

		                    $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
		                    foreach($order_details_result as $order_details_row){
		                      $bom_no=$order_details_row->spec_id;
		                      $bom_version_no=$order_details_row->spec_version_no;
		                      $order_qty=$this->common_model->read_number($order_details_row->total_order_quantity,$this->session->userdata['logged_in']['company_id']);

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
										$micron_1=$specs_row->FILM_GUAGE_1;
				                      	$micron_2=$specs_row->FILM_GUAGE_2;
				                      	$film_mb_2=$specs_row->FILM_MASTER_BATCH_2;
				                      	$micron_3=$specs_row->FILM_GUAGE_3;
				                      	$micron_4=$specs_row->FILM_GUAGE_4;
				                      	$micron_5=$specs_row->FILM_GUAGE_5;
				                      	$micron_6=$specs_row->FILM_GUAGE_6;
				                      	$film_mb_6=$specs_row->FILM_MASTER_BATCH_6;
				                      	$micron_7=$specs_row->FILM_GUAGE_7;
			                       
			                  	}
			                }  	


			                $total_microns=$micron_1+$micron_2+$micron_3+$micron_4+$micron_5+$micron_6+$micron_7; 

			                $sleeve_dia_id='';
					        $result_sleeve_diameter_master=$this->common_model->select_one_active_record('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id'],'sleeve_diameter',$sleeve_diameter);
					        //print_r($result_sleeve_diameter_master);
					        foreach ($result_sleeve_diameter_master as $sleeve_diameter_master_row ) {
					          $sleeve_dia_id=$sleeve_diameter_master_row->sleeve_id;
					       
					        }

					        $data=array('sleeve_dia_id'=>$sleeve_dia_id);

					        $result_spring_width_calculation=$this->common_model->select_active_records_where('spring_width_calculation',$this->session->userdata['logged_in']['company_id'],$data);

					        $reel_width=0;
					        $ups=0;
					        //$sleeve_length_extrusion=$sleeve_length+2.5;
					        foreach ($result_spring_width_calculation as $spring_width_calculation_row) {
					          $ups=$spring_width_calculation_row->ups;
					          $reel_width=($spring_width_calculation_row->slit_width)+($spring_width_calculation_row->ups*$spring_width_calculation_row->distance_each_side);
					        }

					       // Printing Section-----------

			                $data_print=array(
							'sales_ord_no'=>$master_row->order_no,
							'article_no'=>$master_row->article_no,
							'archive'=>0,
							'Jobcard_type'=>2);

							$production_master_result=$this->common_model->select_active_records_where('production_master',$this->session->userdata['logged_in']['company_id'],$data_print);								
							$total_jobcard_qty=0;
							$jobcard_perc=0;
							$total_printing_qty=0;
							$total_scrap_qty=0;
							$total_inspection_input=0;
							$total_inspection_qty=0;
							$total_inspection_pending=0;
							$total_inspection_scrap_qty=0;							
							$total_printing_wip=0;



							//Checking Printing Done Status----
							$printing_done=1;
							foreach ($production_master_result as $key => $production_master_row) {
								if($production_master_row->printing_done=='0'){

									$printing_done=0;
									break;
								}
							}

							//Checking Inspection Done Status----
							$inspection_done=1;
							foreach ($production_master_result as $key => $production_master_row) {
								if($production_master_row->inspection_done=='0'){

									$inspection_done=0;
									break;
								}
							}

							foreach ($production_master_result as $key => $production_master_row) {

								$jobcard_qty=0;
								$jobcard_qty=$this->common_model->read_number($production_master_row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']);

								$total_jobcard_qty+=$jobcard_qty;
								
							// TOTAL PRINTING PRODUCTION--------------	

								$data_total_counter=array(
					            	'jobcard_no'=>$production_master_row->mp_pos_no
					            );
					            $result_total_counter=$this->springtube_printing_production_model->select_total_counter('springtube_printing_production_master',$data_total_counter);
					            
					            $total_counter=0;
					            $printing_qty=0;

					            foreach ($result_total_counter as  $total_counter_row) {
					                $total_counter=$total_counter_row->total_counter;
					                $printing_qty=$total_counter*$ups;
					            }

					            if($production_master_row->printing_done=='1'){
					            	$total_scrap_qty+=($jobcard_qty-$printing_qty);
					            }

					            $total_printing_qty+=$printing_qty;

							// TOTAL PRINTING INSPECTION--------------

					            $inspection_input=0;
                      			$inspected_output_qty=0;
                      			$inspection_pending=0;
                      			$inspection_scrap_qty=0;

					            $data_search=array('jobcard_no'=>$production_master_row->mp_pos_no);
                      			$springtube_printing_inspection_result=$this->springtube_printing_inspection_model->select_total_inspection_qty('springtube_printing_inspection_master',$data_search);
                      			//echo $this->db->last_query();
                      			
                      			foreach ($springtube_printing_inspection_result as $springtube_printing_inspection_row) {

                      				if($springtube_printing_inspection_row->total_inspected_output_qty>0){

                      					$data_total_counter=array(
						            	'jobcard_no'=>$production_master_row->mp_pos_no
							            );
							            $result_total_counter=$this->springtube_printing_production_model->select_total_counter('springtube_printing_production_master',$data_total_counter);
							            
							            $total_counter=0;
							            $printing_qty=0;

							            foreach ($result_total_counter as  $total_counter_row) {
							                $total_counter=$total_counter_row->total_counter;
							                $printing_qty=$total_counter*$ups;
							            }


							            $inspection_input=$printing_qty;
							            $inspected_output_qty=$springtube_printing_inspection_row->total_inspected_output_qty;

							            if($production_master_row->inspection_done=='1'){

							            	$inspection_scrap_qty=($inspection_input-$inspected_output_qty);
							            	$total_inspection_scrap_qty+=$inspection_scrap_qty;
							            }else{
							            	$inspection_pending=($inspection_input-$inspected_output_qty);
							            	$total_inspection_pending+=$inspection_pending;
							            }

							            $total_inspection_input+=$inspection_input;
              							$total_inspection_qty+=$inspected_output_qty;

                      				}                        			
                        
              					}

              					$jobcard_perc=(($total_jobcard_qty-$order_qty)/$order_qty)*100;

              					// $total_inspection_input+=$inspection_input;
              					// $total_inspection_qty+=$inspected_output_qty;


              					// Printing WIP--------------------

              					$data_search_wip=array(
					            	'jobcard_no'=>$production_master_row->mp_pos_no,
					            	'archive'=>'0',
					            	'from_process'=>'15',
					            	'status'=>'0'
					            );

              					$springtube_printing_wip_master_after_result=$this->springtube_printing_wip_after_print_model->active_record_search('springtube_printing_wip_master_after',$this->session->userdata['logged_in']['company_id'],$data_search_wip,'','');

              					foreach ($springtube_printing_wip_master_after_result as $key => $springtube_printing_wip_master_after_row) {
              						$total_printing_wip+=$springtube_printing_wip_master_after_row->aprint_wip_qty;              					 	
              					}
								
							}// Printing Production master-----------------

							// Bodymaking Production Section-----------------

							

							$data_bodymaking=array(
							'sales_ord_no'=>$master_row->order_no,
							'article_no'=>$master_row->article_no,
							'archive'=>0,
							'Jobcard_type'=>3);

							$production_master_result_1=$this->common_model->select_active_records_where('production_master',$this->session->userdata['logged_in']['company_id'],$data_bodymaking);	

							//$bodymaking_done=0;

							$total_bodymaking_jobcard_qty='';
							$total_bodymaking_ok_qty='';
							$total_bodymaking_qchold_qty='';
							$total_bodymaking_sleeve='';	
							$total_bodymaking_heading='';
							$total_bodymaking_capping='';
							$total_bodymaking_qc_pending='';	
							$total_bodymaking_scrap='';				
							

							$total_bodymaking_wip='';
							
							$total_aql_input='';
							$total_aql_output='';
							$total_aql_rejection='';
							$total_aql_bodymaking_rejection='';
							$total_aql_printing_rejection='';
							$total_aql_counter_sample_qty='';
							
							$total_rfd_qty='';
							$total_dispatch_qty='';

							//Checking Bodymaking Done Status----
							$bodymaking_done=1;
							if($production_master_result_1==FALSE){
								$bodymaking_done=0;
							}else{
								foreach ($production_master_result_1 as $key => $production_master_row_1) {
									if($production_master_row_1->bodymaking_done=='0'){

										$bodymaking_done=0;
										break;
									}
								}
							}

							foreach ($production_master_result_1 as $key => $production_master_row_1) { 

								$bodymaking_jobcard_qty=0;
								$bodymaking_jobcard_qty=$this->common_model->read_number($production_master_row_1->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']);
								// Jobcard Qty---------
								$total_bodymaking_jobcard_qty+=$this->common_model->read_number($production_master_row_1->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']);

								// Bodymaking Production Qty-----------

								$data_bodymaking=array('jobcard_no'=>$production_master_row_1->mp_pos_no,'archive'=>'0');
								
								$springtube_bodymaking_production_details_result=$this->springtube_bodymaking_production_model->active_details_records('springtube_bodymaking_production_details',$data_bodymaking);

								$bodymaking_ok_qty=0;
								$bodymaking_qc_pending=0;

								foreach ($springtube_bodymaking_production_details_result as $key => $springtube_bodymaking_production_details_row) {
									
									if($springtube_bodymaking_production_details_row->qc_check=='1'){

										$bodymaking_ok_qty+=$springtube_bodymaking_production_details_row->qc_ok_qty;
										$total_bodymaking_sleeve+=$springtube_bodymaking_production_details_row->total_sleeve_produced;
										$total_bodymaking_heading+=$springtube_bodymaking_production_details_row->sleeve_with_heading;
										$total_bodymaking_capping+=$springtube_bodymaking_production_details_row->sleeve_with_cap;



									}
									else{
										$bodymaking_qc_pending+=$springtube_bodymaking_production_details_row->sleeve_with_cap;
										
									}								
									
								}

								$total_bodymaking_ok_qty+=$bodymaking_ok_qty;
								$total_bodymaking_qc_pending+=$bodymaking_qc_pending;
								// QC Hold Qty---------------

								$data_qc=array(
									'jobcard_no'=>$production_master_row_1->mp_pos_no,
									'archive'=>'0',
									'status'=>'0');

								$springtube_bodymaking_qc_master_result=$this->common_model->select_active_records_where('springtube_bodymaking_qc_master',$this->session->userdata['logged_in']['company_id'],$data_qc);

								$bodymaking_qchold_qty=0;
								foreach ($springtube_bodymaking_qc_master_result as $key => $springtube_bodymaking_qc_master_row) {
									$bodymaking_qchold_qty=$springtube_bodymaking_qc_master_row->qc_hold_qty;

									$total_bodymaking_qchold_qty+=$bodymaking_qchold_qty;
								}
								$bodymaking_scrap=0;
								if($bodymaking_qchold_qty==0 && $bodymaking_ok_qty>0){

									$bodymaking_scrap=($bodymaking_jobcard_qty-$bodymaking_ok_qty);

									$total_bodymaking_scrap+=$bodymaking_scrap;

								}

								// Bodymaking WIP QTY----------------------
								$data_bodymaking_wip=array(
									'jobcard_no'=>$production_master_row_1->mp_pos_no,
					            	'archive'=>'0',
					            	'status'=>'0',
					            	);
								$springtube_bodymaking_wip_master_result=$this->springtube_bodymaking_wip_model->active_record_search('springtube_bodymaking_wip_master',$this->session->userdata['logged_in']['company_id'],$data_bodymaking_wip,'',''); 

								foreach ($springtube_bodymaking_wip_master_result as $key => $springtube_bodymaking_wip_master_row) {
									$total_bodymaking_wip+=$springtube_bodymaking_wip_master_row->bm_wip_qty;
								}

								//Springtube AQL-------------------------
								$data_aql=array(
									'jobcard_no'=>$production_master_row_1->mp_pos_no,
					            	'archive'=>'0',
					            	'from_process'=>'13');

								$springtube_aql_rfd_master_result=$this->springtube_aql_rfd_model->active_record_search('springtube_aql_rfd_master',$this->session->userdata['logged_in']['company_id'],$data_aql,'',''); 
								$aql_input=0;
								$aql_output=0;
								$aql_rejection=0;
								$aql_bodymaking_rejection=0;
								$aql_printing_rejection=0;
								$aql_counter_sample_qty=0;

								foreach ($springtube_aql_rfd_master_result as $key => $springtube_aql_rfd_master_row) {
									$aql_input=$springtube_aql_rfd_master_row->inspection_qty;
									$aql_output=$springtube_aql_rfd_master_row->rfd_qty;
									$aql_rejection=$springtube_aql_rfd_master_row->total_rejected_qty;
									$aql_bodymaking_rejection=$springtube_aql_rfd_master_row->total_rejected_bodymaking_issue;
									$aql_printing_rejection=$springtube_aql_rfd_master_row->total_rejected_printing_issue;
									$aql_counter_sample_qty=$springtube_aql_rfd_master_row->counter_sample_qty;


									$total_aql_input+=$aql_input;
									$total_aql_output+=$aql_output;
									$total_aql_rejection+=$aql_rejection;
									$total_aql_bodymaking_rejection+=$aql_bodymaking_rejection;
									$total_aql_printing_rejection+=$aql_printing_rejection;
									$total_aql_counter_sample_qty+=$aql_counter_sample_qty;

								}

								//Springtube RFD-------------------------
								$data_rfd=array(
									'jobcard_no'=>$production_master_row_1->mp_pos_no,
					            	'archive'=>'0',
					            	'from_process'=>'17');

								$springtube_rfd_master_result=$this->springtube_aql_rfd_model->active_record_search('springtube_rfd_master',$this->session->userdata['logged_in']['company_id'],$data_rfd,'',''); 

								foreach ($springtube_rfd_master_result as $key => $springtube_rfd_master_row) {
									$total_rfd_qty+=$springtube_rfd_master_row->rfd_qty;
									$total_dispatch_qty+=$springtube_rfd_master_row->release_qty;
								}




							}	

							// Invoice Details------------------
							$supply_qty=0;	
							$invoice=array();
							$invoice['ref_ord_no']=$master_row->order_no;
							$invoice['article_no']=$master_row->article_no;

							$supply_qty_result=$this->sales_order_status_model->sum_supply_qty('ar_invoice_master',$invoice,$this->session->userdata['logged_in']['company_id']);

							foreach($supply_qty_result as $supply_qty_row){
								$supply_qty=$this->common_model->read_number($supply_qty_row->supply_qty,$this->session->userdata['logged_in']['company_id']);

							}	

							$final_rejection=($supply_qty>0?round((($total_jobcard_qty-$supply_qty)/$total_jobcard_qty)*100):"");						

							echo"<tr>
										
									<td >".$i++."</td><td>";
									foreach($formrights as $formrights_row){
										echo'';												
									}
									echo"</td>
									<td>".$this->common_model->view_date($master_row->production_date,$this->session->userdata['logged_in']['company_id'])."</td>	
									<td>".$this->common_model->get_parent_name($master_row->article_no,$this->session->userdata['logged_in']['company_id'])."</td>								
									<td><a href='".base_url('index.php/sales_order_book/view/'.$master_row->order_no)."' target='_blank'> ".$master_row->order_no."</a></td>
									<td title='".$this->common_model->get_article_name($master_row->article_no,$this->session->userdata['logged_in']['company_id'])."'>".$master_row->article_no."</td>
									<!--<td>".$total_microns."</td>-->
									<td>".$sleeve_diameter."</td>
									<td>".$sleeve_length."</td>
									<td class='warning right aligned'><b>".number_format($order_qty,0,'.',',')."</b> <i>NOS</i></td>

									<!--<td>".$this->common_model->get_article_name($sleeve_mb_2,$this->session->userdata['logged_in']['company_id'])."</td>									
									<td>".$this->common_model->get_article_name($sleeve_mb_6,$this->session->userdata['logged_in']['company_id'])."</td> 
									-->
									<td>".($jobcard_perc==0?"":($jobcard_perc<=30?"<a class='ui green circular label'>".round($jobcard_perc)." % </a>":"<a class='ui red circular label'>".round($jobcard_perc)." % </a>"))."</td>

									<!--printing-->
									<td class='positive right aligned'><b>".number_format($total_jobcard_qty,0,'.',',')."</b> <i>NOS</i></td>
									<td class='positive right aligned'><b>".number_format($total_printing_qty,0,'.',',')."</b> <i>NOS</i></td>
									<td class='negative right aligned'><b>".number_format($total_scrap_qty,0,'.',',')."</b> <i>NOS</i></td>
									
									<td>".($printing_done==1?"<i style='color:#06c806;' class='check circle icon'></i>":"<i style='color: #f10606;' class='times circle icon'></i>")."</td>
									<td>".($printing_done==1 && $total_scrap_qty>=0 && $total_jobcard_qty >0?round((($total_scrap_qty/$total_jobcard_qty)*100))." %":'')."</td>
									
									<!--Inspection-->									
									<td class='positive right aligned'><b>".($total_inspection_input>0 ? number_format($total_inspection_input,0,'.',',')."</b> <i>NOS</i>":"")."</td>
									<td class='positive right aligned'><b>".($total_inspection_qty>0?number_format($total_inspection_qty,0,'.',',')."</b> <i>NOS</i>":"")."</td>
									<td class='positive right aligned'><b>".($total_inspection_pending>0?number_format($total_inspection_pending,0,'.',',')."</b> <i>NOS</i>":"")."</td>
									<td class='negative right aligned'><b>".($total_inspection_scrap_qty>0?number_format($total_inspection_scrap_qty,0,'.',',')."</b> <i>NOS</i>":($total_inspection_input>0?"0 <i>NOS</i>":""))."</td>

									<td class='positive right aligned'><b>".($total_printing_wip>0?number_format($total_printing_wip,0,'.',',')."</b> <i>NOS</i>":($total_inspection_input>0?"0 <i>NOS</i>":""))."</td>
									<td></td>
									
									<td>".($inspection_done=='1' ?"<i style='color:#06c806;' class='check circle icon'></i>":"<i style='color: #f10606;' class='times circle icon'></i>")."</td>
									<td>".($inspection_done=='1' && $total_inspection_scrap_qty>=0 && $total_inspection_input>0 ?round(($total_inspection_scrap_qty/$total_inspection_input)*100)." %":"")."</td>

									<!--Bodymaking -->
									<td class='positive right aligned'><b>".($total_bodymaking_jobcard_qty!=''?number_format($total_bodymaking_jobcard_qty,0,'.',',')."</b> <i>NOS</i>":"")."</td>
									<td class='positive right aligned'><b>".($total_bodymaking_ok_qty!=''?number_format($total_bodymaking_ok_qty,0,'.',',')."</b> <i>NOS</i>":"")."</td>
									<td class='negative right aligned'><b>".($total_bodymaking_qc_pending!=''?number_format($total_bodymaking_qc_pending,0,'.',',')."</b> <i>NOS</i>":"")."</td>
									<td class='negative right aligned'><b>".($total_bodymaking_qchold_qty!=''?number_format($total_bodymaking_qchold_qty,0,'.',',')."</b> <i>NOS</i>":"")."</td>
									<td class='negative right aligned'><b>".($total_bodymaking_scrap!=''?number_format($total_bodymaking_scrap,0,'.',',')."</b> <i>NOS</i>":"")."</td>
									<td class='positive right aligned'><b>".($total_bodymaking_wip>0?number_format($total_bodymaking_wip,0,'.',',')."</b> <i>NOS</i>":($total_bodymaking_ok_qty>0?"0 <i>NOS</i>":""))."</td>
									<td></td>
									<td>".($bodymaking_done=='1' ?"<i style='color:#06c806;' class='check circle icon'></i>":"<i style='color: #f10606;' class='times circle icon'></i>")."</td>
									<!-- Spring AQL--->
									<td class='positive right aligned'><b>".($total_aql_input!=''?number_format($total_aql_input,0,'.',',')."</b> <i>NOS</i>":"")."</td>
									<td class='positive right aligned'><b>".($total_aql_output!=''?number_format($total_aql_output,0,'.',',')."</b> <i>NOS</i>":"")."</td>
									<td class='negative right aligned'><b>".($total_aql_rejection!=''?number_format($total_aql_rejection,0,'.',',')."</b> <i>NOS</i>":"")."</td>
									<td class='negative right aligned'><b>".($total_aql_printing_rejection!=''?number_format($total_aql_printing_rejection,0,'.',',')."</b> <i>NOS</i>":"")."</td>
									<td class='negative right aligned'><b>".($total_aql_bodymaking_rejection!=''?number_format($total_aql_bodymaking_rejection,0,'.',',')."</b> <i>NOS</i>":"")."</td>
									<td class='negative right aligned'><b>".($total_aql_counter_sample_qty!=''?number_format($total_aql_counter_sample_qty,0,'.',',')."</b> <i>NOS</i>":"")."</td>
									<td>".($total_rfd_qty!=''&& $supply_qty>=$total_rfd_qty?"<i style='color:#06c806;' class='check circle icon'></i>":"<i style='color: #f10606;' class='times circle icon'></i>")."</td>
									<td>".($total_aql_rejection>0?round(($total_aql_rejection/$total_aql_input)*100)." %":"")."</td>
									<!--<td>".($total_aql_printing_rejection>0?round(($total_aql_printing_rejection/$total_aql_input)*100)." %":"")."</td>
									<td>".($total_aql_bodymaking_rejection>0?round(($total_aql_bodymaking_rejection/$total_aql_input)*100)." %":"")."</td>
									-->

									<td class='positive right aligned'><b>".($total_rfd_qty!=''?number_format($total_rfd_qty,0,'.',',')."</b> <i>NOS</i>":"")."</td>
									<td class='positive right aligned'><b>".($supply_qty!=''?number_format($supply_qty,0,'.',',')."</b> <i>NOS</i>":"")."</td>

									<td>".($final_rejection!=""?"<a class='ui red circular label'>".$final_rejection." % </a>":"")."</td>
									";								
									
									$sum_total_jobcard_qty+=$total_jobcard_qty;
									$sum_total_printing_qty+=$total_printing_qty;
									$sum_total_scrap_qty+=$total_scrap_qty;

									
									$sum_total_inspection_qty+=$total_inspection_qty;

									$sum_total_printing_wip+=$total_printing_wip;

									$sum_total_bodymaking_jobcard_qty+=$total_bodymaking_jobcard_qty;
									$sum_total_bodymaking_ok_qty+=$total_bodymaking_ok_qty;
									$sum_total_bodymaking_wip+=$total_bodymaking_wip;
									
									$sum_total_aql_input+=$total_aql_input;
									$sum_total_aql_output+=$total_aql_output;
									$sum_total_aql_rejection+=$total_aql_rejection;
									
									$sum_total_rfd_qty+=$total_rfd_qty;
									$sum_total_dispatch_qty+=$total_dispatch_qty;

						}//master Foreach

					/*echo"<tr><td colspan='9' style='text-align:right;'><b>TOTAL</b></td>
					<td class='positive right aligned'><b>".number_format($sum_total_jobcard_qty,0,'.',',')."</b> <i>NOS</i></td>
					<td class='positive right aligned'><b>".number_format($sum_total_printing_qty,0,'.',',')."</b> <i>NOS</i></td>
					<td class='positive right aligned'><b>".number_format($sum_total_scrap_qty,0,'.',',')."</b> <i>NOS</i></td>
					<td class='positive right aligned'><b>".number_format($sum_total_inspection_qty,0,'.',',')."</b> <i>NOS</i></td>
					<td class='positive right aligned'><b>".number_format($sum_total_printing_wip,0,'.',',')."</b> <i>NOS</i></td>
					<td></td>
					<td class='positive right aligned'><b>".number_format($sum_total_bodymaking_jobcard_qty,0,'.',',')."</b> <i>NOS</i></td>
					<td class='positive right aligned'><b>".number_format($sum_total_bodymaking_ok_qty,0,'.',',')."</b> <i>NOS</i></td>
					<td></td>					
					<td class='positive right aligned'><b>".number_format($sum_total_bodymaking_wip,0,'.',',')."</b> <i>NOS</i></td>
					<td></td>
					<td> </td>
					<td class='positive right aligned'><b>".number_format($sum_total_aql_input,0,'.',',')."</b> <i>NOS</i></td>
					<td></td>
					<td class='positive right aligned'><b>".number_format($sum_total_rfd_qty,0,'.',',')."</b> <i>NOS</i></td>
					<td class='positive right aligned'><b>".number_format($sum_total_dispatch_qty,0,'.',',')."</b> <i>NOS</i></td>
					
					</tr>";
					*/	

					}?>
				</tbody>				
			</table>
			<div class="pagination"><?php echo $this->pagination->create_links();?></div>
	</div>
</div>


