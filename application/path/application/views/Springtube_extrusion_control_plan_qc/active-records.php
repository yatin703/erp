<div class="record_form_design">
	<h4>Active Records <?php echo ($this->input->post('from_date')!=''? 'From '.$this->input->post('from_date').' To '.$this->input->post('to_date'):'')?></h4>
	<div class="record_inner_design" style="overflow: scroll;">
			<table class="record_table_design_without_fixed">
				<tr>
					<!--<th>Action</th>-->
					<th>Sr no.</th>
					<th>Inspection Date</th>					
					<th>Shift</th>
					<th>Machine</th>
					<!--<th>Operator</th>-->
					<th>Customer</th>
					<!--<th>Jobcard No.</th>-->
					<th>Order No</th>					
					<th>Article No.</th>
					<th>Jobcard No.</th>
					<!--<th>Product Name</th>
					<th>BOM No.</th>
					<th>Film_code</th>
					<th>Dia</th>
					<th>Sleeve Length</th>
					<th>Width std</th>
					<th>Width actual</th>
					<th>Width status</th>
					<th>Thickness std</th>
					<th>Thickness actual</th>
					<th>Thickness status</th>
					<th>Roll length std</th>
					<th>Roll length actual</th>
					<th>Roll length status</th>
					<th>First layer micron std</th>
					<th>First layer micron actual</th>
					<th>First layer micron status</th>
					<th>Second layer micron std</th>
					<th>Second layer micron actual</th>
					<th>Second layer micron status</th>
					<th>Shird layer micron std</th>
					<th>Third layer micron actual</th>
					<th>Third layer micron status</th>
					<th>Fourth layer micron std</th>
					<th>Fourth layer micron actual</th>
					<th>Fourth layer micron status</th>
					<th>Fifth layer micron std</th>
					<th>Fifth layer micron actual</th>
					<th>Fifth layer micron status</th>
					<th>Sixth layer micron std</th>
					<th>Sixth layer micron actual</th>
					<th>Sixth layer micron status</th>
					<th>Seventh layer micron std</th>
					<th>Seventh layer micron actual</th>
					<th>Seventh layer micron status</th>
					<th>Grade perc of bland</th>
					<th>Grade perc of bland status</th>
					<th>Roll color</th>
					<th>Roll color status</th>
					<th>Color diffrence</th>
					<th>Color diffrence status</th>
					<th>Opacity</th>
					<th>Opacity status</th>
					<th>Roll winding</th>
					<th>Roll winding status</th>
					<th>Die line</th>
					<th>Die line status</th>
					<th>Scratch line</th>
					<th>Scratch line status</th>
					<th>Pit watermark</th>
					<th>Pit watermark status</th>
					<th>Contamination</th>
					<th>Contamination status</th>
					<th>Roll humps</th>
					<th>Roll humps status</th>
					<th>Color dispersion</th>
					<th>Color dispersion status</th>
					<th>COF SF DF</th>
					<th>COF SF DF status</th>
					<th>MB Color & perc</th>
					<th>MB color & perc status</th>
					<th>Master file Jobcard return status</th>
					<th>RM return status</th>
					<th>Red create status</th>
					<th>Rejected rolls clear status</th>
					<th>No loose tools status</th>
					<th>Machine cleane status</th>
					<th>Machine ready status</th>
					<th>Finger Comb status</th>
					<th>New job/Power Fail</th>
					<th>Shift change/Trial</th>
					<th>QC remarks</th>
					<th>QC inspection status</th>
					<th>QC Name</th>-->
					<th>Add parameters</th>	
					<th>Add Roll Thickness</th>
					<th>Action</th>									
					
				</tr>
				<?php if($springtube_extrusion_control_plan_qc==FALSE){
					echo "<tr><td colspan='22'>No Active Records Found</td></tr>";
				}else{
						$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
						
						$reel_length=$this->config->item('springtube_reel_length');

						foreach($springtube_extrusion_control_plan_qc as $master_row){

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
									<!--<td>";

										foreach ($formrights as $formrights_row) {

											echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$master_row->cp_id.'').'" target="_blank" title="View"><i class="print icon"></i></a>' : '');

											echo ($formrights_row->modify==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$master_row->cp_id.'').'" target="_blank" title="Modify"><i class="edit icon"></i></a> ' : '');

											echo ($formrights_row->delete==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$master_row->cp_id.'').'" target="_blank" title="Delete"><i class="trash icon"></i></a> ' : '');
											
										}
									echo"</td>

									-->";	
										
									echo "<td >".$i++."</td>			
									<td>".$this->common_model->view_date($master_row->inspection_date,$this->session->userdata['logged_in']['company_id'])."</td>";
									

									echo"<td>";
									if($master_row->inspection_time >'08:00:00' AND $master_row->inspection_time<'16:00:00' ){                  
								       echo '1st';                  
								      }else if($master_row->inspection_time >'16:00:00' AND $master_row->inspection_time <'23:59:59'){               
								        echo '2nd';                  
								      }else if($master_row->inspection_time >'00:00:00' AND $master_row->inspection_time <'07:59:59'){
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
									<td>".$master_row->width_std."</td>
									<td>".$master_row->width_actual."</td>
									<td>".($master_row->width_status==1?"PASS":($master_row->width_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->thickness_std."</td>
									<td>".$master_row->thickness_actual."</td>
									<td>".($master_row->thickness_status==1?"PASS":($master_row->thickness_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->reel_length_std."</td>
									<td>".$master_row->reel_length_actual."</td>
									<td>".($master_row->reel_length_status==1?"PASS":($master_row->reel_length_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->first_layer_micron_std."</td>
									<td>".$master_row->first_layer_micron_actual."</td>
									<td>".($master_row->first_layer_micron_status==1?"PASS":($master_row->first_layer_micron_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->second_layer_micron_std."</td>
									<td>".$master_row->second_layer_micron_actual."</td>
									<td>".($master_row->second_layer_micron_status==1?"PASS":($master_row->second_layer_micron_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->third_layer_micron_std."</td>
									<td>".$master_row->third_layer_micron_actual."</td>
									<td>".($master_row->third_layer_micron_status==1?"PASS":($master_row->third_layer_micron_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->fourth_layer_micron_std."</td>
									<td>".$master_row->fourth_layer_micron_actual."</td>
									<td>".($master_row->fourth_layer_micron_status==1?"PASS":($master_row->fourth_layer_micron_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->fifth_layer_micron_std."</td>
									<td>".$master_row->fifth_layer_micron_actual."</td>
									<td>".($master_row->fifth_layer_micron_status==1?"PASS":($master_row->fifth_layer_micron_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->sixth_layer_micron_std."</td>
									<td>".$master_row->sixth_layer_micron_actual."</td>
									<td>".($master_row->sixth_layer_micron_status==1?"PASS":($master_row->sixth_layer_micron_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->seventh_layer_micron_std."</td>
									<td>".$master_row->seventh_layer_micron_actual."</td>
									<td>".($master_row->seventh_layer_micron_status==1?"PASS":($master_row->seventh_layer_micron_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->grade_perc_of_bland."</td>
									<td>".($master_row->grade_perc_of_bland_status==1?"PASS":($master_row->grade_perc_of_bland_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->roll_color."</td>
									<td>".($master_row->roll_color_status==1?"PASS":($master_row->roll_color_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->color_diffrence."</td>
									<td>".($master_row->color_diffrence_status==1?"PASS":($master_row->color_diffrence_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->opacity."</td>
									<td>".($master_row->opacity_status==1?"PASS":($master_row->opacity_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->roll_winding."</td>
									<td>".($master_row->roll_winding_status==1?"PASS":($master_row->roll_winding_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->die_line."</td>
									<td>".($master_row->die_line_status==1?"PASS":($master_row->die_line_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->scratch_line."</td>
									<td>".($master_row->scratch_line_status==1?"PASS":($master_row->scratch_line_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->pit_watermark."</td>
									<td>".($master_row->pit_watermark_status==1?"PASS":($master_row->pit_watermark_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->contamination."</td>
									<td>".($master_row->contamination_status==1?"PASS":($master_row->contamination_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->roll_humps."</td>
									<td>".($master_row->roll_humps_status==1?"PASS":($master_row->roll_humps_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->color_dispersion."</td>
									<td>".($master_row->color_dispersion_status==1?"PASS":($master_row->color_dispersion_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->cof_sf_df."</td>
									<td>".($master_row->cof_sf_df_status==1?"PASS":($master_row->cof_sf_df_status==2?"FAIL":"N/A"))."</td>
									<td>".$master_row->mb_color_perc."</td>
									<td>".($master_row->mb_color_perc_status==1?"PASS":($master_row->mb_color_perc_status==2?"FAIL":"N/A"))."</td>
									
									<td>".($master_row->masterfile_jobcard_return_status==1?"YES":"NO")."</td>
									<td>".($master_row->rm_return_status==1?"YES":"NO")."</td>
									<td>".($master_row->red_create_status==1?"YES":"NO")."</td>
									<td>".($master_row->rejected_rolls_clear_status==1?"YES":"NO")."</td>
									<td>".($master_row->no_loose_tools_status==1?"YES":"NO")."</td>
									<td>".($master_row->machine_cleane_status==1?"YES":"NO")."</td>
									<td>".($master_row->machine_ready_status==1?"YES":"NO")."</td>
									<td>".($master_row->finger_comb_status==1?"YES":"NO")."</td>
									<td>".($master_row->new_job_status==1?"YES":"NO")."</td>
									<td>".($master_row->shift_change_status==1?"YES":"NO")."</td>
									<td>".$master_row->qc_remarks."</td>
									<td>".($master_row->qc_inspection_status==1?"APPROVED":($master_row->qc_inspection_status==2?"REJECT":"HOLD"))."</td>
									<td>".$this->common_model->get_user_name($master_row->user_id,$this->session->userdata['logged_in']['company_id'])."</td>
								-->	
									<td>";

									foreach ($formrights as $formrights_row){

										echo ($formrights_row->new==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/create_parameters/'.$master_row->cp_id.'').'" target="_blank" title="Add Parameter"><i class="plus icon"></i></a>' : '');

										echo"</td><td>";
										$control_plan_qc_film_thickness_result=$this->common_model->select_one_active_record('springtube_extrusion_control_plan_qc_film_thickness',$this->session->userdata['logged_in']['company_id'],'cp_id',$master_row->cp_id);
										
										if($control_plan_qc_film_thickness_result==FALSE){

											echo ($formrights_row->new==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/create_roll_thickness/'.$master_row->cp_id.'').'" target="_blank" title="Add Roll Thickness"><i class="plus icon"></i></a>' : '');
										}else{

											echo ($formrights_row->modify==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify_roll_thickness/'.$master_row->cp_id.'').'" target="_blank" title="Modify Roll Thickness"><i class="edit icon"></i></a>' : '');

										}
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