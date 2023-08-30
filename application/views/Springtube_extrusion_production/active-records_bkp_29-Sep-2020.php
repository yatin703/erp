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

<<!-- style>	
   tr:hover {background-color:#e4e4e4;}
</style> -->
<script>
	$(document).ready(function(){

		$("#tbl_data .td_qc_hold").each(function(){
			//alert($(this).html());
			if($(this).html()!=''){
				$(this).parent("tr").css("background-color","pink");
			}

		})


	});

</script>
<div class="record_form_design">
	<h4>Active Records <?php echo ($this->input->post('from_date')!=''? 'From '.$this->input->post('from_date').' To '.$this->input->post('to_date'):'')?></h4>
	<div class="record_inner_design" style="white-space: nowrap;overflow: scroll;">
			<table class="record_table_design_without_fixed" id="tbl_data" >
				<tr>
					<th>Action</th>
					<th>Srno.</th>
					<th>Prod. Date</th>					
					<th>Shift</th>	
					<th>Customer</th>
					<th>Order No</th>
					<th>Article No.</th>
					<!-- <th>Product Name</th> -->
					<th>BOM No.</th> 
					<th>Dia</th>
					<th>Sleeve Length</th>
					<!-- <th>MB</th> -->
					<th>Job No.</th>
					<th>Jobcard No.</th>					
					<th>Reels Length</th>
					<th>Plan Production (Mtrs)</th>
					<th>Total Production (Mtrs)</th>
					<th>Reels Produced</th>
					<th>Ok Production(Mtrs)</th>
					<th>Ok Reels (Nos)</th>
					<th>QC Status</th>	
					<th>QC Hold (Mtrs)</th>
					<th>QC Released (Mtrs)</th>
					<th>QC Scrap (Mtrs)</th>			 
					<th>Jobcard Material Weight (Kg)</th>				
					<th>Job Weight (Kg)</th>
					<th>Trim Waste (Kg)</th>
					<th>Setup Jobcard</th>					
					<th>Setup Weight (Kg)</th>
					<th>Setup Meters</th>
					<th>Setup Reason</th>
					<th>Purging Jobcard</th>
					<th>Purging Weight (Kg)</th>
					<th>Purging Reason</th>					
					<th>QC Name</th>
					<th>QC Remarks</th>					
					<th>Qc Control Plan</th>
					<th>QC Incharge</th>
					<th>Shift Issues</th>
					<th>Remarks</th>
					<th>User Name</th>
					<!-- <th>Approved By</th>
					<th>Approval Date</th> -->

					
				</tr>
				<?php 

				if($springtube_extrusion_production_master==FALSE){
					echo "<tr><td colspan='22'>No Active Records Found</td></tr>";
				}else{
						$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
						
						//$reel_length=$this->config->item('springtube_reel_length');
						$reel_length='';
						$sum_plan_meters=0;
						$sum_total_meters_produced=0;
						$sum_reels_produced=0;
						$sum_total_ok_meters=0;
						$sum_total_setup_meters=0;
						$sum_total_setup_weight=0;
						$sum_total_purging_weight=0;
						$sum_ok_reels=0;
						$sum_total_qc_hold_meters=0;
						$sum_total_job_weight=0;									
						$sum_total_waste=0;
						$sum_qc_released=0;
						$sum_qc_scrap=0;
						$sum_wip=0;
						$sum_jobcard_material_weight=0;									

						foreach($springtube_extrusion_production_master as $master_row){

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

							$result=$this->springtube_extrusion_production_model->active_details_records('springtube_extrusion_production_details',$details_data);
							//echo $this->db->last_query();	
							 $rowspan=count($result);
					    	$tr=$rowspan;
					    	if($rowspan>0){					    		

								echo"<tr>
									<td rowspan='".$rowspan."'>";
									foreach ($formrights as $formrights_row) {

										// echo ($formrights_row->approval=='1' && $master_row->final_approval_flag!='1' ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/approval/'.$master_row->production_id.'').'" title="Approval" target="_blank"><i class="thumbs outline up icon"></i></a>' : '');


										echo ($formrights_row->view==1 ? ' | <a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$master_row->production_id.'').'" title="view" target="_blank"><i class="print icon"></i></a>' : '');

										echo ($formrights_row->modify==1 && $master_row->final_approval_flag<>1 ? ' | <a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$master_row->production_id.'').'" title="Modify" target="_blank"><i class="edit icon"></i></a>' : '');

										echo ($formrights_row->delete==1 ? ' | <a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$master_row->production_id.'').'" title="Delete" target="_blank"><i class="trash icon"></i></a> ' : '');
											
									}
									echo"</td>	
									
									<td rowspan='".$rowspan."'>".$i++."</td>
									<td rowspan='".$rowspan."'>".$this->common_model->view_date($master_row->production_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td rowspan='".$rowspan."'>".$master_row->shift."</td>";

									// $sum_total_meters_produced=0;
									// $sum_total_ok_meters=0;
									// $sum_total_qc_hold_meters=0;
									// $sum_total_job_weight=0;									
									// $sum_total_waste=0;
									

									$r=0;
									foreach ($result as $details_row){
										//Jobcard details  //production_master----
										$production_master_result=$this->common_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no', $details_row->jobcard_no);
              
					                    foreach($production_master_result as $production_master_row) {
					                      $order_no=$production_master_row->sales_ord_no;
					                      $article_no=$production_master_row->article_no;
					                      $reel_length=$production_master_row->reel_length;
					                      $total_meters=round($production_master_row->total_meters);
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

					                    $film_code='';

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
									
										echo"
										<td>".$customer."</td>
										<td><a href='".base_url('index.php/sales_order_book/view/'.$order_no)."' target='_blank'> ".$order_no."</a>
										</td>
										<td>".$article_no."</td>
										<!--<td>".$this->common_model->get_article_name($article_no,$this->session->userdata['logged_in']['company_id'])."</td>-->
										<td><a href='".base_url('index.php/bill_of_material/view/'.$bom_id)."' target='_blank'>".$bom_no."_".$bom_version_no."</td>
										<td>".$sleeve_diameter."</td>
										<td>".$sleeve_length." MM</td>
									<!--<td>".$this->common_model->get_article_name($sleeve_mb_2,$this->session->userdata['logged_in']['company_id']).($sleeve_mb_6!=''?' ,'.$this->common_model->get_article_name($sleeve_mb_6,$this->session->userdata['logged_in']['company_id']):'')."</td>
									-->
										<td>JOB-".$details_row->job_pos_no."</td>
										<td><a href='".base_url('index.php/sales_order_item_parameterwise/view_new/'.$details_row->jobcard_no.'/'.$bom_no.'/'.$bom_version_no)."' target='_blank'>".$details_row->jobcard_no."</td>
										<td>".$reel_length." </td>
										<td>".$total_meters." </td>
										<td>".$details_row->total_meters_produced."</td>
										<td>".round($details_row->total_meters_produced/$reel_length,2)."</td>
										<td>".($details_row->total_ok_meters!=''?$details_row->total_ok_meters."":"")."</td>
										<td>".round($details_row->total_ok_meters/$reel_length,2)."</td><td>";
										foreach ($formrights as $formrights_row) {
											// if( $formrights_row->new=='1' && $formrights_row->copy=='1' && $details_row->qc_check =='0' && $master_row->final_approval_flag=='1'){ 

											if($formrights_row->new=='1' && $formrights_row->copy=='1' && $details_row->qc_check =='0'){ 	

												echo '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/qc_inspection/'.$master_row->production_id.'/'.$details_row->details_id).'" title="Qc Check" target="_blank"><i class="edit icon"></i></a>';
											}else if($details_row->qc_check =='1'){
												echo"<a class='ui green label'>QC INSPECTION DONE</a>";
												if($formrights_row->modify=='1'){
													echo '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify_qc_inspection/'.$master_row->production_id.'/'.$details_row->details_id).'" title="Modify Qc Check" target="_blank"><i class="ui blue label">Modify Qc</i></a>';
												}
											}else{
												echo"<a class='ui blue label'>Qc Inspection Pending.</a>";
											}

										}

										echo"</td><td class='td_qc_hold'>";
										$qc_hold_meters=0;
										$data_qc_hold=array('details_id'=>$details_row->details_id,'status'=>0,'archive'=>0);
										$springtube_extrusion_qc_master_hold=$this->common_model->select_active_records_where('springtube_extrusion_qc_master',$this->session->userdata['logged_in']['company_id'],$data_qc_hold);

										foreach ($springtube_extrusion_qc_master_hold as $springtube_extrusion_qc_master_hold_row) {
											echo $qc_hold_meters=$springtube_extrusion_qc_master_hold_row->total_qc_hold_meters;
										}



										echo"</td><td>";
										$qc_released_meters=0;
										$data_qc_released=array('details_id'=>$details_row->details_id,'status'=>1,'next_process'=>6,'archive'=>0);
										$springtube_extrusion_qc_master_result=$this->common_model->select_active_records_where('springtube_extrusion_qc_master',$this->session->userdata['logged_in']['company_id'],$data_qc_released);

										foreach ($springtube_extrusion_qc_master_result as $springtube_extrusion_qc_master_row) {
											echo $qc_released_meters=$springtube_extrusion_qc_master_row->release_meters;
										}

										echo"</td><td>";

											$qc_scraped_meters=0;
											$data_qc_scraped=array('details_id'=>$details_row->details_id,'status'=>1,'next_process'=>11,'archive'=>0);
											$springtube_extrusion_qc_master_result_1=$this->common_model->select_active_records_where('springtube_extrusion_qc_master',$this->session->userdata['logged_in']['company_id'],$data_qc_scraped);

											foreach ($springtube_extrusion_qc_master_result_1 as $springtube_extrusion_qc_master_row_1) {
												echo $qc_scraped_meters=$springtube_extrusion_qc_master_row_1->release_meters;
											}

										
										echo"</td>
										<td>";
										$extrusion_search=array();
						                $extrusion_search['manu_order_no']=$details_row->jobcard_no;                
						                $extrusion_search['work_proc_no']=1;						                
						                 
						                $this->load->model('job_card_model');
						                $material_manufacturing_summary_result=$this->job_card_model->jobcard_material_total('material_manufacturing',$extrusion_search,$this->session->userdata['logged_in']['company_id']);
						                //echo $this->db->last_query();

						                foreach ($material_manufacturing_summary_result as $key => $material_manufacturing_summary_row) {
						                	echo $this->common_model->read_number($material_manufacturing_summary_row->demand_qty,$this->session->userdata['logged_in']['company_id']);
						                	$sum_jobcard_material_weight+=$this->common_model->read_number($material_manufacturing_summary_row->demand_qty,$this->session->userdata['logged_in']['company_id']);

						                }


										echo"</td>
										<td>".$details_row->total_job_weight."</td>
										<td>".$details_row->total_waste."</td>
										
										<td><a href='".base_url('index.php/sales_order_item_parameterwise/view_new/'.$details_row->setup_jobcard_no.'/'.$bom_no.'/'.$bom_version_no)."' target='_blank'>".$details_row->setup_jobcard_no."</td>
										<td>".$details_row->total_setup_weight."</td>
										<td>".$details_row->total_setup_meters."</td>
										<td>";
										$setup_reason_result=$this->common_model->select_one_active_record('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],'shift_issue_id', $details_row->setup_reason);              
					                    foreach($setup_reason_result as $setup_reason_row) {
					                      echo $setup_reason_row->shift_issue;
					                    }										
										echo"</td>
										<td><a href='".base_url('index.php/sales_order_item_parameterwise/view_new/'.$details_row->purging_jobcard.'/'.$bom_no.'/'.$bom_version_no)."' target='_blank'>".$details_row->purging_jobcard."</td>
										<td>".$details_row->total_purging_weight."</td>
										<td>";
										$purging_reason_result=$this->common_model->select_one_active_record('springtube_shift_issues_master',$this->session->userdata['logged_in']['company_id'],'shift_issue_id', $details_row->purging_reason);
              
					                    foreach($purging_reason_result as $purging_reason_row) {
					                      echo $purging_reason_row->shift_issue;
					                    }

										echo"</td>
										<td>".$this->common_model->get_user_name($details_row->qc_id,$this->session->userdata['logged_in']['company_id'])."</td>
										<td>".$details_row->qc_remarks."</td>";

										$sum_plan_meters+=$total_meters;
										$sum_total_meters_produced+=$details_row->total_meters_produced;
										$sum_reels_produced+=round($details_row->total_meters_produced/$reel_length,2);

										$sum_total_setup_meters+=$details_row->total_setup_meters;
										$sum_total_setup_weight+=$details_row->total_setup_weight;
										$sum_total_purging_weight+=$details_row->total_purging_weight;

										$sum_total_ok_meters+=$details_row->total_ok_meters;
										$sum_ok_reels+=round($details_row->total_ok_meters/$reel_length,2);
										//$sum_total_qc_hold_meters+=$details_row->total_qc_hold_meters;
										$sum_total_qc_hold_meters+=$qc_hold_meters;
										$sum_qc_released+=$qc_released_meters;
										$sum_qc_scrap+=$qc_scraped_meters;
										//$sum_wip+=

										$sum_total_job_weight+=	$details_row->total_job_weight;	
										$sum_total_waste+=$details_row->total_waste;

										
										echo"<td>";
										$springtube_extrusion_control_plan_qc_result=$this->common_model->select_one_active_record('springtube_extrusion_control_plan_qc',$this->session->userdata['logged_in']['company_id'],'jobcard_no',$details_row->jobcard_no);

										foreach ($springtube_extrusion_control_plan_qc_result as $springtube_extrusion_control_plan_qc_row) {

											echo '<a href="'.base_url('index.php/springtube_extrusion_control_plan_qc/view/'.$springtube_extrusion_control_plan_qc_row->cp_id.'').'" target="_blank" title="View"><i class="print icon"></i></a>';
											echo '</br>';
										}
										echo"</td>";
										 
										if($r==0){

											echo"<td rowspan='".$rowspan."'>".strtoupper($master_row->qc_incharge)."</td>
											<td rowspan='".$rowspan."'>".$master_row->shift_issues."</td>
											<td rowspan='".$rowspan."'>".$master_row->remarks."</td>
											<td rowspan='".$rowspan."'>".strtoupper($master_row->login_name)."</td>
											<!--td rowspan='".$rowspan."'>".strtoupper($this->common_model->get_user_name($master_row->approved_by,$this->session->userdata['logged_in']['company_id']))."</td>
											<td rowspan='".$rowspan."'>".($master_row->approved_date!='0000-00-00'? $this->common_model->view_date($master_row->approved_date,$this->session->userdata['logged_in']['company_id']):'')."</td>
											-->

											";										
									
										}


										echo "</tr>";
										if($rowspan>1 && --$tr>0){
											echo'<tr>';
										}

										$r++;

									}

					        }//Rowspan IF

						}//master Foreach

						echo"<tr style='font-weight:bold;'><td colspan='13' style='text-align:right;'><b>TOTAL</b></td>
						<!--<td>".$sum_plan_meters."</td>-->
						<td></td>
						<td>".$sum_total_meters_produced."</td>
						<td>".$sum_reels_produced."</td>
						<td>".$sum_total_ok_meters."</td>
						<td>".$sum_ok_reels."</td>
						<td></td>
						<td>".$sum_total_qc_hold_meters."</td>
						<td>".$sum_qc_released."</td>
						<td>".$sum_qc_scrap."</td>
						
						<td>".$sum_jobcard_material_weight."</td>
						<td>".$sum_total_job_weight."</td>
						<td>".$sum_total_waste."</td>
						<td></td>
						<td>".$sum_total_setup_weight."</td>
						<td>".$sum_total_setup_meters."</td>
						<td></td>
						<td></td>
						<td>".$sum_total_purging_weight."</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td><td></td><td></td><td></td><td></td></tr>";

					}?>


								
			</table>
			<div class="pagination"><?php echo $this->pagination->create_links();?></div>
	</div>
</div>