<div class="record_form_design">
	<h4>Active Records <?php echo ($this->input->post('from_date')!=''? 'From '.$this->input->post('from_date').' To '.$this->input->post('to_date'):'')?></h4>
	<div class="record_inner_design" style="overflow: scroll;">
			<table class="record_table_design_without_fixed">
				<tr>
					<!-- <th>Action</th> -->
					<th>Sr no.</th>
					<th>Inspection Date</th>					
					<th>Shift</th>
					<th>Machine</th>
					<!-- <th>Operator</th> -->
					<th>Customer</th>
					<!-- <th>Jobcard No.</th> -->
					<th>Order No</th>					
					<th>Article No.</th>
					<th>Jobcard No.</th>
					<!-- <th>Product Name</th>
					<th>BOM No.</th>
					<th>Film_code</th>
					<th>Dia</th>
					<th>Sleeve Length</th>
					<th>DE Value</th>
					<th>DE Value Status</th>
					<th>Treatment</th>
					<th>Treatment status</th>
					<th>Shade variation</th>
					<th>Shade variation status</th>
					<th>Text proof</th>
					<th>Text proof status</th>
					<th>Lacquer over under</th>
					<th>Lacquer over under status</th>
					<th>Non print area</th>
					<th>Non print area status</th>
					<th>I mark position</th>
					<th>I mark position status</th>
					<th>Repeat length variation</th>
					<th>Repeat length variation status</th>
					<th>Print cut</th>
					<th>Print cut status</th>
					<th>Smudge print</th>
					<th>Smudge print status</th>
					<th>Ink dot</th>
					<th>ink dot status</th>
					<th>Ghost print</th>
					<th>Ghost print status</th>
					<th>Motling</th>
					<th>Motling status</th>
					<th>Tape test</th>
					<th>Tape test status</th>
					<th>Rub test</th>
					<th>Rub test status</th>
					<th>Print surface line</th>
					<th>Print surface line status</th>
					<th>Miss print</th>
					<th>Miss print status</th>
					<th>Barcode test</th>
					<th>Barcode test status</th>
					<th>Contamination</th>
					<th>Contamination status</th>
					<th>Non lacquer area</th>
					<th>Non lacquer area status</th>
					<th>Wet lacquer</th>
					<th>Wet lacquer status</th>
					<th>Lacquer peeloff</th>
					<th>Lacquer peeloff status</th>
					<th>Wavy lacquer</th>
					<th>Wavy lacquer status</th>
					<th>Dull lacquer</th>
					<th>Dull lacquer status</th>
					<th>Dirty lacquer</th>
					<th>Dirty lacquer status</th>
					<th>Foil cut</th>
					<th>Foil cut status</th>
					<th>Foil shift vertical</th>
					<th>Foil shift vertical status</th>
					<th>Foil shift horizontal</th>
					<th>Foil shift horizontal status</th>
					<th>Foil thickness</th>
					<th>Foil thickness status</th>
					<th>Master file Jobcard return status</th>
					<th>RM return status</th>
					<th>Red create status</th>
					<th>Rejected rolls clear status</th>
					<th>Prev Job Film Roll Status</th>
					<th>No loose tools status</th>
					<th>Machine cleane status</th>
					<th>Machine ready status</th>
					<th>Finger Comb status</th>
					<th>New job/Power Fail</th>
					<th>Shift change/Trial</th>
					<th>QC remarks</th>
					<th>QC inspection status</th>
					<th>QC Name</th> -->
					<th>Add parameters</th>
					<th>Action</th>	
													
					
				</tr>
				<?php if($springtube_printing_control_plan_qc==FALSE){
					echo "<tr><td colspan='22'>No Active Records Found</td></tr>";
				}else{
						$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
						
						$reel_length=$this->config->item('springtube_reel_length');

						foreach($springtube_printing_control_plan_qc as $master_row){

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

							//Jobcard details  //production_master----
							$production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no', $master_row->jobcard_no);
  
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
		                      $ad_id=$order_details_row->ad_id;
		                      $version_no=$order_details_row->version_no;
		                    }
		                    // Artwork Details------------------
		                    
		                    $data=array('ad_id'=>$ad_id,'version_no'=>$version_no);
		                    $search=array();
		                    $data['artwork_springtube']=$this->artwork_springtube_model->active_record_search_new('springtube_artwork_devel_master',$data,$search,'','',$this->session->userdata['logged_in']['company_id']);

		                    //print_r($data['artwork_springtube']);


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
									<!--<td>";

										foreach ($formrights as $formrights_row) {

											echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$master_row->cp_id.'').'" target="_blank" title="View"><i class="print icon"></i></a>' : '');

											echo ($formrights_row->modify==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$master_row->cp_id.'').'" target="_blank" title="Modify"><i class="edit icon"></i></a> ' : '');

											echo ($formrights_row->delete==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$master_row->cp_id.'').'" target="_blank" title="Delete"><i class="trash icon"></i></a> ' : '');
											
										}

										
									echo "</td>-->
									<td >".$i++."</td>			
									<td>".$this->common_model->view_date($master_row->inspection_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<!--<td>".$master_row->inspection_time."</td>-->";
									echo"<td>";
									$time=substr($master_row->time_stamp,-8);

									if($time >'08:00:00' AND $time<'15:59:59' ){                  
								       echo '1st';                  
								      }else if($time >'16:00:00' AND $time <'23:59:59'){               
								        echo '2nd';                  
								      }else if($time >'00:00:00' AND $time <'07:59:59'){
								        echo '3rd';
								      }else{
								        echo '';
								      }									

									echo"</td>
									<td>".$master_row->machine_name."</td>
									<!--<td>".$master_row->operator."</td>-->
									<td>".$customer."</td>
									<!--<td>".$master_row->jobcard_no."</td>-->
									<td><a href='".base_url('index.php/sales_order_book/view/'.$order_no)."' target='_blank'>".$order_no."</td>
									<td>".$article_no."</td>
									<td><a href='".base_url('index.php/sales_order_item_parameterwise/view_new/'.$master_row->jobcard_no.'/'.$bom_no.'/'.$bom_version_no)."' target='_blank'>".$master_row->jobcard_no."</td>

									<!--<td>".$this->common_model->get_article_name($article_no,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$bom_no."</td>
									<td>".$film_code."</td>
									<td>".$sleeve_diameter."</td>
									<td>".$sleeve_length."</td>
									<td>".$master_row->de_value."</td>							
									<td>".($master_row->de_value_status==1?"PASS":($master_row->de_value_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->treatment."</td>							
									<td>".($master_row->treatment_status==1?"PASS":($master_row->treatment_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->shade_variation."</td>
									<td>".($master_row->shade_variation_status==1?"PASS":($master_row->reel_length_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->text_proof."</td>
									<td>".($master_row->text_proof_status==1?"PASS":($master_row->text_proof_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->lacquer_over_under."</td>
									<td>".($master_row->lacquer_over_under_status==1?"PASS":($master_row->lacquer_over_under_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->non_print_area."</td>					
									<td>".($master_row->non_print_area_status==1?"PASS":($master_row->non_print_area_status==2?"FAIL":"N/A"))."</td>									
									<td>".$master_row->i_mark_position."</td>
									<td>".($master_row->i_mark_position_status==1?"PASS":($master_row->i_mark_position_status==2?"FAIL":"N/A"))."</td>									
									<td>".$master_row->repeat_length_variation."</td>
									<td>".($master_row->repeat_length_variation_status==1?"PASS":($master_row->repeat_length_variation_status==2?"FAIL":"N/A"))."</td>									
									<td>".$master_row->print_cut."</td>
									<td>".($master_row->print_cut_status==1?"PASS":($master_row->print_cut_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->smudge_print."</td>						
									<td>".($master_row->smudge_print_status==1?"PASS":($master_row->smudge_print_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->ink_dot."</td>
									<td>".($master_row->ink_dot_status==1?"PASS":($master_row->ink_dot_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->ghost_print."</td>
									<td>".($master_row->ghost_print_status==1?"PASS":($master_row->ghost_print_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->motling."</td>
									<td>".($master_row->motling_status==1?"PASS":($master_row->motling_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->tape_test."</td>
									<td>".($master_row->tape_test_status==1?"PASS":($master_row->tape_test_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->rub_test."</td>
									<td>".($master_row->rub_test_status==1?"PASS":($master_row->rub_test_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->print_surface_line."</td>
									<td>".($master_row->print_surface_line_status==1?"PASS":($master_row->print_surface_line_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->miss_print."</td>
									<td>".($master_row->miss_print_status==1?"PASS":($master_row->miss_print_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->barcode_test."</td>
									<td>".($master_row->barcode_test_status==1?"PASS":($master_row->barcode_test_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->contamination."</td>
									<td>".($master_row->contamination_status==1?"PASS":($master_row->contamination_status==2?"FAIL":"N/A"))."</td>
									
									<td>".$master_row->non_lacquer_area."</td>
									<td>".($master_row->non_lacquer_area_status==1?"PASS":($master_row->non_lacquer_area_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->wet_lacquer."</td>
									<td>".($master_row->wet_lacquer_status==1?"PASS":($master_row->wet_lacquer_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->lacquer_peeloff."</td>
									<td>".($master_row->lacquer_peeloff_status==1?"PASS":($master_row->lacquer_peeloff_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->wavy_lacquer."</td>
									<td>".($master_row->wavy_lacquer_status==1?"PASS":($master_row->wavy_lacquer_status==2?"FAIL":"N/A"))."</td>
									
									<td>".$master_row->dull_lacquer."</td>
									<td>".($master_row->dull_lacquer_status==1?"PASS":($master_row->dull_lacquer_status==2?"FAIL":"N/A"))."</td>

									<td>".$master_row->dirty_lacquer."</td>
									<td>".($master_row->dirty_lacquer_status==1?"PASS":($master_row->dirty_lacquer_status==2?"FAIL":"N/A"))."</td>


									<td>".$master_row->foil_cut."</td>
									<td>".($master_row->foil_cut_status==1?"PASS":($master_row->foil_cut_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->foil_shift_vertical."</td>
									<td>".($master_row->foil_shift_vertical_status==1?"PASS":($master_row->foil_shift_vertical_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->foil_shift_horizontal."</td>
									<td>".($master_row->foil_shift_horizontal_status==1?"PASS":($master_row->foil_shift_horizontal_status==2?"FAIL":"N/A"))."</td>

									<td>".$master_row->foil_thickness."</td>
									<td>".($master_row->foil_thickness_status==1?"PASS":($master_row->foil_thickness_status==2?"FAIL":"N/A"))."</td>

									<td>".($master_row->masterfile_jobcard_return_status==1?"YES":"NO")."</td>
									<td>".($master_row->rm_return_status==1?"YES":"NO")."</td>
									<td>".($master_row->red_create_status==1?"YES":"NO")."</td>
									<td>".($master_row->rejected_rolls_clear_status==1?"YES":"NO")."</td>
									<td>".($master_row->no_film_roll_status==1?"YES":"NO")."</td>
									<td>".($master_row->no_loose_tools_status==1?"YES":"NO")."</td>
									<td>".($master_row->machine_cleane_status==1?"YES":"NO")."</td>
									<td>".($master_row->machine_ready_status==1?"YES":"NO")."</td>
									<td>".($master_row->finger_comb_status==1?"YES":"NO")."</td>
									 
									<td>".$master_row->qc_remarks."</td>
									<td>".($master_row->qc_inspection_status==1?"APPROVED":($master_row->qc_inspection_status==2?"REJECT":"HOLD"))."</td>
									<td>".$this->common_model->get_user_name($master_row->user_id,$this->session->userdata['logged_in']['company_id'])."</td>

									-->
									<td>";

									foreach ($formrights as $formrights_row){

										//echo"<td>";

										echo ($formrights_row->new==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/create_parameters/'.$master_row->cp_id.'').'" target="_blank" title="Add Parameter"><i class="add icon"></i></a>' : '');
								
										echo"</td>";

									}
									echo"<td>";
									foreach ($formrights as $formrights_row) {

										echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$master_row->cp_id.'').'" target="_blank" title="View"><i class="print icon"></i></a>' : '');

										echo ($formrights_row->modify==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$master_row->cp_id.'').'" target="_blank" title="Modify"><i class="edit icon"></i></a> ' : '');

										echo ($formrights_row->delete==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$master_row->cp_id.'').'" target="_blank" title="Delete"><i class="trash icon"></i></a> ' : '');
										
									}
									echo"</td>";

										

									

						}//master Foreach

					}?>
								
			</table>
			<div class="pagination"><?php echo $this->pagination->create_links();?></div>
	</div>
</div>