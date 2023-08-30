<style>
	tr:hover {background-color:#e4e4e4;}
</style>	
   
<div class="record_form_design">
	<h4>Active Records <?php echo ($this->input->post('from_date')!=''? 'From '.$this->input->post('from_date').' To '.$this->input->post('to_date'):'')?></h4>
	<div class="record_inner_design" style="overflow: scroll; white-space: nowrap;">
		
			<table class="record_table_design_without_fixed">
				<tr>
					
					<th>Sr no.</th>
					<th>From Process</th>
					<th>WIP Date</th>
					<th>Customer</th>					
					<th>Order No</th>
					<th>Order Date</th>	
					<th>Article No.</th>
					<th>Product Name</th>
					<th>BOM No.</th>
					<th>Film_code</th>
					<!--<th>Dia</th>
					<th>Sleeve Length</th>
					<th>Jobcard No.</th>
					<th>Film_code</th>-->

					<th>Microns</th>
					<th>Dia</th>
					<th>Sleeve Length</th>
					<th>Jobcard No.</th>
					<th>Second layer MB Code</th>
					<th>Second layer MB Name</th>
					<th>Sixth Layer MB Code</th>
					<th>Sixth Layer MB Name</th>
					<th>WIP Meters</th>
					<th>No. of Reels</th>
					<th>Ok Qty</th>
					<th>WIP Cost Per Meter</th>
					<th>Release To Process</th>
					<th>Release To Order</th>
					<th>Release Date</th>
					<th>Release Meters</th>
					<th>Release Reels</th>
					<th>Release Qty</th>
					<th>Released By</th>
					<th>Remarks</th>
					<th>Action</th>											
					
				</tr>
				<?php 

					$sum_total_ok_meters=0;
					$sum_total_ok_qty=0;

					$sum_total_release_meters=0;
					$sum_total_release_qty=0;

					$sum_reels=0;
					$sum_reels_release=0;

				if($springtube_extrusion_wip_master==FALSE){
					echo "<tr><td colspan='14'>No Active Records Found</td></tr>";
				}else{
						$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
						
						//$reel_length=$this->config->item('springtube_reel_length');
						$reel_length='';
						//$sum_total_meters_produced=0;
						

						foreach($springtube_extrusion_wip_master as $master_row){

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
		                      $reel_length=$production_master_row->reel_length;
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
							

							// echo"<tr".(strpos($order_no,'SO')!=''?"style='backgroun-color:pink;'":'')." >
								echo"<tr>		
									<td >".$i++."</td>
									<td>";
										$springtube_process_master_result=$this->common_model->select_one_active_record('springtube_process_master',$this->session->userdata['logged_in']['company_id'],'process_id',$master_row->from_process);
										foreach ($springtube_process_master_result as $springtube_process_master_row ) {
											echo $springtube_process_master_row->process_name;									
										}
									echo "</td>				
									<td>".$this->common_model->view_date($master_row->wip_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$this->common_model->get_customer_name($customer,$this->session->userdata['logged_in']['company_id'])."</td>

									<td><a href='".base_url('index.php/sales_order_book/view/'.$order_no)."' target='_blank'> ".$order_no."</a></td>
									<td>".$this->common_model->view_date($order_date,$this->session->userdata['logged_in']['company_id'])."</td>
									 
									<td>".$article_no."</td>
									<td>".$this->common_model->get_article_name($article_no,$this->session->userdata['logged_in']['company_id'])."</td>
									<td><a href='".base_url('index.php/bill_of_material/view/'.$bom_id)."' target='_blank'>".$bom_no."_".$bom_version_no."</td>
											
									<td><a href='".base_url('index.php/spring_film_specification/view/'.$film_spec_id.'/'.$film_spec_version)."' target='_blank'>".$master_row->film_code."</td>
									<td>".$master_row->total_microns."</td>
									<td>".$master_row->sleeve_dia."</td>
									<td>".$master_row->sleeve_length."</td>
									<td><a href='".base_url('index.php/sales_order_item_parameterwise/view_new/'.$master_row->jobcard_no.'/'.$bom_no.'/'.$bom_version_no)."' target='_blank'>".$master_row->jobcard_no."</td>						
									<td>".$master_row->second_layer_mb."</td>
									<td>".$this->common_model->get_article_name($master_row->second_layer_mb,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$master_row->sixth_layer_mb."</td>
									<td>".$this->common_model->get_article_name($master_row->sixth_layer_mb,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$master_row->total_ok_meters."</td>
									<td>".round($master_row->total_ok_meters/$reel_length,2)."</td>
									<td>".$master_row->ok_qty."</td>
									<td>".$master_row->wip_cost_per_meter."</td>
									<td>";
										$springtube_process_master_result=$this->common_model->select_one_active_record('springtube_process_master',$this->session->userdata['logged_in']['company_id'],'process_id',$master_row->next_process);
										foreach ($springtube_process_master_result as $springtube_process_master_row ) {
											echo $springtube_process_master_row->process_name;									
										}
									echo "</td>
									<td>".$master_row->release_to_order_no."</td>
									<td>".($master_row->release_date!='0000-00-00'?$master_row->release_date:'')."</td>
									<td>".$master_row->release_meters."</td>
									<td>".round($master_row->release_meters/$reel_length,2)."</td>
									<td>".$master_row->release_qty."</td>
									<td>".$master_row->release_by."</td>
									<td>".$master_row->release_remarks."</td>
									<td>";

										foreach ($formrights as $formrights_row) {

											echo ($formrights_row->new==1 && $master_row->status==0 && $master_row->wip_cost_per_meter !=0 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/wip_release/'.$master_row->wip_id.'').'" target="_blank" class="ui small green label"  title="WIP Release">WIP Release</a>' : '');

											// <a class="ui green label">Close JobCard</a>

											//echo ($formrights_row->modify==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$master_row->wip_id.'').'" target="_blank" title="Modify"><i class="edit icon"></i></a> ' : '');

											//echo ($formrights_row->delete==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$master_row->wip_id.'').'" target="_blank" title="Delete"><i class="trash icon"></i></a> ' : '');
											
										}

										echo "</td>";


								$sum_total_ok_meters+=$master_row->total_ok_meters;
								$sum_total_ok_qty+=$master_row->ok_qty;

								$sum_reels+=round($master_row->total_ok_meters/$reel_length,2);

								$sum_total_release_meters+=$master_row->release_meters;
								$sum_total_release_qty+=$master_row->release_qty;
								$sum_reels_release+=round($master_row->release_meters/$reel_length,2);		

						}//master Foreach

					echo"<tr><td colspan='18' style='text-align:right;'><b>TOTAL</b></td><td>".$sum_total_ok_meters."</td><td>".$sum_reels."</td><td>".$sum_total_ok_qty."</td><td></td><td></td><td></td><td></td><td>".$sum_total_release_meters."</td><td>".$sum_reels_release."</td><td>".$sum_total_release_qty."</td> <td></td><td></td><td></td></tr>";	

					}?>
								
			</table>

			<div class="pagination"><?php echo $this->pagination->create_links();?></div>
	</div>
</div>