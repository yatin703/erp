<style>	
   tr:hover {background-color:#e4e4e4;}
   .total{font-weight:bold;}
   th{text-align:center;border-top: 1px solid rgba(34,36,38,.1)}
</style>
<div class="record_form_design">
	<h4>WIP Scrap Active Records <?php echo ($this->input->post('from_date')!=''? 'From '.$this->input->post('from_date').' To '.$this->input->post('to_date'):'')?></h4>
	<div class="record_inner_design" style="overflow: scroll;white-space: nowrap;">
			<table class="ui very basic collapsing celled table"  style="font-size:10px;" id="tbl_data">
				<thead>
				<tr>					
					<th>Sr no.</th>
					<th>Action</th>
					<th>Scrap Date</th>	
					<th>From Process</th>
					<th>Customer</th>										
					<th>Order No</th>					
					<th>Article No.</th>
					<th>Dia X Length</th>					
					<th>Microns</th>
					<th>Film_code</th>
					<th>Second layer MB</th> 			 
					<th>Sixth Layer MB</th>
					<th>Jobcard No.</th>
					<th>Scrap Meters</th>
					<th>Scrap Weight (Kgs)</th>
					<th>Scrap Reasons</th>
				</tr>
				</thead>
				<tbody>
				<?php 

				$sum_total_scrap_meters=0;
				$sum_scrap_qty=0;
				$sum_scrap_weight=0;
				
				if($springtube_extrusion_scrap_master==FALSE){
					echo "<tr><td colspan='14'>No Active Records Found</td></tr>";
				}else{
						$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
						
						//$reel_length=$this->config->item('springtube_reel_length');
						$reel_length='';

						foreach($springtube_extrusion_scrap_master as $master_row){

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

							$jobcard_qty=0;

							$scrap_qty=0;

							$single_tube_weight=0;

							$scrap_weight=0;

							$total_plan_meters=0;
							

							//Jobcard details  //production_master----
							$production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no', $master_row->jobcard_no);
  
		                    foreach($production_master_result as $production_master_row) {
		                      $order_no=$production_master_row->sales_ord_no;
		                      $article_no=$production_master_row->article_no;
		                      $reel_length=$production_master_row->reel_length;
		                      $jobcard_qty=$this->common_model->read_number($production_master_row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']);
		                      $total_plan_meters=$production_master_row->total_meters;
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


							//$scrap_qty=$this->common_model->jobcard_meters_to_qty($master_row->jobcard_no,$master_row->total_scrap_meters);

							$weight_result=$this->springtube_extrusion_production_model->get_job_weight_extrusion($master_row->jobcard_no,$this->session->userdata['logged_in']['company_id']);

							$total_weight=0;	
							foreach ($weight_result as $key => $weight_row) {
								$total_weight=$this->common_model->read_number($weight_row->total_qty,$this->session->userdata['logged_in']['company_id']);
							}

							$one_meter_weight=($total_weight/$total_plan_meters);

							$scrap_weight=$one_meter_weight*$master_row->total_scrap_meters;						
							$sum_scrap_weight+=$scrap_weight;

							echo"<tr>										
									<td >".$i++."</td>
									<td>";

										foreach ($formrights as $formrights_row) {

											//echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$master_row->qc_id.'').'" target="_blank" title="View"><i class="print icon"></i></a>' : '');

											echo ($formrights_row->new==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/qc_release/'.$master_row->scrap_id.'').'" title="Release"><i class="edit icon"></i></a> ' : '');

											echo ($formrights_row->delete==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$master_row->scrap_id.'').'" target="_blank" title="Delete"><i class="trash icon"></i></a> ' : '');
											
										}

										echo "</td>
										<td>".$this->common_model->view_date($master_row->scrap_date,$this->session->userdata['logged_in']['company_id'])."</td>
										<td>";
										$springtube_process_master_result=$this->common_model->select_one_active_record('springtube_process_master',$this->session->userdata['logged_in']['company_id'],'process_id',$master_row->from_process);
										foreach ($springtube_process_master_result as $springtube_process_master_row ) {
											echo $springtube_process_master_row->process_name;									
										}
										echo "</td>
										<td>".$customer."</td>			
									
									<td><a href='".base_url('index.php/sales_order_book/view/'.$order_no)."' target='_blank'> ".$order_no."</a></td>
									<td title='".$this->common_model->get_article_name($article_no,$this->session->userdata['logged_in']['company_id'])."'>".$article_no."</td>

									<td>".$master_row->sleeve_dia." X ".$master_row->sleeve_length  ."</td>
									<td>".$master_row->total_microns."</td>
									<td><a href='".base_url('index.php/spring_film_specification/view/'.$film_spec_id.'/'.$film_spec_version)."' target='_blank'>".$film_code."</td>
									<td>".$this->common_model->get_article_name($master_row->second_layer_mb,$this->session->userdata['logged_in']['company_id'])."</td>									 
									<td>".$this->common_model->get_article_name($master_row->sixth_layer_mb,$this->session->userdata['logged_in']['company_id'])."</td>

									<td><a href='".base_url('index.php/sales_order_item_parameterwise/view_new/'.$master_row->jobcard_no.'/'.$bom_no.'/'.$bom_version_no)."' target='_blank'>".$master_row->jobcard_no."</td>
									<td class='negative'><b>".money_format('%!.0n',$master_row->total_scrap_meters)."</b> <i>MTRS</i></td>
									<td class='negative'><b>".number_format($scrap_weight,2,'.',',')."</b><i> KGS</i></td>
									<td>".$master_row->scrap_reason."</td>
									";		 

									$sum_total_scrap_meters+=$master_row->total_scrap_meters;
									$sum_scrap_qty+=$scrap_qty;

						}//master Foreach

						echo"<tr class='total'><td colspan='13' style='text-align:right;'><b>TOTAL</b></td><td>".money_format('%!.0n',$sum_total_scrap_meters)."<i> MTRS</i></td><td>".number_format($sum_scrap_weight,2,'.',',')."<i> KGS</i></td><td></td><td></td></tr>";	

					}?>
				</tbody>						
			</table>
			<div class="pagination"><?php echo $this->pagination->create_links();?></div>
	</div>
</div>