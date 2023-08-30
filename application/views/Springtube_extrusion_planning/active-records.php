<div class="record_form_design">
	<h4>Active Records</h4>
	<div class="record_inner_design" style="overflow: scroll;">
			<table class="record_table_design_without_fixed">
				<tr>
					<!--<th>Id</th>-->
					<th>Seq. no.</th>
					<th>Planning From Date</th>
					<th>Planning To Date</th>
					<th>Order No</th>
					<th>Order Date</th>
					<th>Customer</th>
					<th>Article No.</th>
					<th>Product Name</th>
					<th>MB 2nd Layer</th>
					<th>MB 6th Layer</th>
					<th>Dia</th>
					<th>Sleeve Length</th>
					<th>Order Qty</th>
					<th>Pending Qty</th>
					<th>Sleeve Length For Extrusion</th>
					<th>Reel Width</th>
					<th>Extra %</th>
					<th>Planned Qty</th>
					<th>Ups</th>
					<th>Reel Length</th>
					<th>Final Length</th>
					<th>Calculated Reels</th>
					<th>No. Of Reels Planned.</th>					
					<th>Action</th>
				</tr>
				<?php if($spring_extrusion_planning_master==FALSE){
					echo "<tr><td colspan='12'>No Active Records Found</td></tr>";
				}else{
						$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
						
						$reel_length=$this->config->item('springtube_reel_length');

						foreach($spring_extrusion_planning_master as $row){

							$customer='';
							$order_date='';
							$ad_id='';
							$version_no='';
							$body_making_type='';
							$print_type_artwork='';
							$bom_no='';
							$bom_version_no='';
							$total_order_quantity=0;

							//Order Details----------------
							$order_master_result=$this->sales_order_book_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_master.order_no',$row->order_no);
							foreach($order_master_result as $order_master_row){
								$customer=$order_master_row->customer_name;
								$order_date=$order_master_row->order_date;
							}

							$data_order_details=array('order_no'=>$row->order_no,'article_no'=>$row->article_no);

							$order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
							foreach($order_details_result as $order_details_row){
								$total_order_quantity=$order_details_row->total_order_quantity;
								$ad_id=$order_details_row->ad_id;
								$version_no=$order_details_row->version_no;
								$bom_no=$order_details_row->spec_id;
								$bom_version_no=$order_details_row->spec_version_no;
							}
							//Artwork Deatils-------------------------
							$data=array('ad_id'=>$ad_id,
										'version_no'=>$version_no
									    );
							$springtube_artwork_result=$this->artwork_springtube_model->active_record_search_new('springtube_artwork_devel_master',$data,'','','',$this->session->userdata['logged_in']['company_id']);

							foreach ($springtube_artwork_result as $springtube_artwork_row) {
								$body_making_type=$springtube_artwork_row->body_making_type;
							}

							// Bill of Maaterial---------------------
							$ups=0;
							$sleeve_mb_2='';
							$sleeve_mb_6='';
							$sleeve_diameter='';
							$sleeve_length='';
							$reel_width='';

							if($bom_no!='' && $bom_version_no!='' ){

								$film_spec_id='';
	                			$film_spec_version='';
	                			
	                			$data=array('bom_no'=>$bom_no,
	                						'bom_version_no'=>$bom_version_no);

	                			$bill_of_material_result=$this->common_model->select_active_records_where('bill_of_material',$this->session->userdata['logged_in']['company_id'],$data);

	                			foreach (
	                				$bill_of_material_result as $bill_of_material_row) {
	                				$bom_id=$bill_of_material_row->bom_id;
	                				$film_code=$bill_of_material_row->sleeve_code;
						    		//$shoulder_code=$bill_of_material_row->shoulder_code;
						    		//$cap_code=$bill_of_material_row->cap_code;
						    		//$label_code=$bill_of_material_row->label_code;
						    		$print_type_bom=$bill_of_material_row->print_type;
						    		//$specs_comment=strtoupper($bill_of_material_row->comment);
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
									$sleeve_dia_id='';

									$result_sleeve_diameter_master=$this->common_model->select_one_active_record('sleeve_diameter_master',$this->session->userdata['logged_in']['company_id'],'sleeve_diameter',$sleeve_diameter);
									//print_r($result_sleeve_diameter_master);
									foreach ($result_sleeve_diameter_master as $sleeve_diameter_master_row ) {
										$sleeve_dia_id=$sleeve_diameter_master_row->sleeve_id;

										
									}
									$data=array('sleeve_dia_id'=>$sleeve_dia_id,
												'seam_type'=>$body_making_type,
												'ups'=>'2');

									$result_spring_width_calculation=$this->common_model->select_active_records_where('spring_width_calculation',$this->session->userdata['logged_in']['company_id'],$data);

									$reel_width=0;
									
									foreach ($result_spring_width_calculation as $spring_width_calculation_row) {
										$ups=$spring_width_calculation_row->ups;
										$reel_width=($spring_width_calculation_row->slit_width)+($spring_width_calculation_row->ups*$spring_width_calculation_row->distance_each_side);
									}
							    }
							}

							// Invoice Qty-----------------

							$supply_qty=0;
							$pending_qty=0;						

							$invoice_data=array();
							$invoice_data['ref_ord_no']=$row->order_no;
							$invoice_data['article_no']=$row->article_no;

							$supply_qty_result=$this->sales_order_status_model->sum_supply_qty('ar_invoice_master',$invoice_data,$this->session->userdata['logged_in']['company_id']);

							foreach($supply_qty_result as $supply_qty_row){
								$supply_qty=$supply_qty_row->supply_qty;

							}

							if($supply_qty==0){
								
								$pending_qty=$this->common_model->read_number($total_order_quantity,$this->session->userdata['logged_in']['company_id']);

								
							}else{
								$pending_qty=$this->common_model->read_number($total_order_quantity-$supply_qty,$this->session->userdata['logged_in']['company_id']);
							}

							$planned_qty=0;
							$planned_length=0;

							if($row->jobcard_perc!=''){

								$planned_qty=$pending_qty+($row->jobcard_perc/100*$pending_qty);
								

								if($ups!=0){

								  $planned_length=(($sleeve_length+2.5)*$planned_qty/1000)/$ups;

								}
							}

							


							
							echo"<tr ".($row->freeze_flag=='1'?"style='background-color:pink;'":"").">
								<td>".$row->sort_order."</td>							
								<td>".$this->common_model->view_date($row->planning_from_date,$this->session->userdata['logged_in']['company_id'])."</td>
								<td>".$this->common_model->view_date($row->planning_to_date,$this->session->userdata['logged_in']['company_id'])."</td>
								<td>".$row->order_no."</td>
								<td>".$this->common_model->view_date($order_date,$this->session->userdata['logged_in']['company_id'])."</td>
								<td>".$customer."</td>
								<td>".$row->article_no."</td>
								<td>".$this->common_model->get_article_name($row->article_no,$this->session->userdata['logged_in']['company_id'])."</td>
								<td>".$this->common_model->get_article_name($sleeve_mb_2,$this->session->userdata['logged_in']['company_id'])."</td>
								<td>".$this->common_model->get_article_name($sleeve_mb_6,$this->session->userdata['logged_in']['company_id'])."</td>
								<td>".$sleeve_diameter."</td>
								<td>".($sleeve_length!=''?$sleeve_length." MM":"")."</td>
								
								<td>".$this->common_model->read_number($total_order_quantity,$this->session->userdata['logged_in']['company_id'])."</td>
								<td>".$pending_qty."</td>								
								<td>".($sleeve_length!=''?($sleeve_length+2.5)." MM":"")."</td>
								<td>".$reel_width."</td>
								<td>".$row->jobcard_perc."</td>
								<td>".$planned_qty."</td>								
								<td>".$ups."</td>
								<td>".$reel_length."</td>
								<td>".$planned_length."</td>
								<td>".round($planned_length/$reel_length,2)."</td>
								<td>".ceil($planned_length/$reel_length)."</td>
								<td>";
								foreach($formrights as $formrights_row){

										echo ($formrights_row->modify=='1' && $row->freeze_flag<>'1'  ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->id).'" target="_blank"><i class="edit icon"></i></a>' : '');						
								}
								echo "</td>									
							</tr>";

							$i++;

						}
					}?>
								
			</table>
			<div class="pagination"><?php echo $this->pagination->create_links();?></div>
	</div>
</div>