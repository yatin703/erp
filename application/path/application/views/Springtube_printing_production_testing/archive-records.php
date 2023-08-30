
<style>	
   tr:hover {background-color:#e4e4e4;}
</style>
<div class="record_form_design">
	<h4>Archive Records <?php echo ($this->input->post('from_date')!=''? 'From '.$this->input->post('from_date').' To '.$this->input->post('to_date'):'')?></h4>
	<div class="record_inner_design" style="overflow: scroll; white-space: nowrap;">
			<table class="record_table_design_without_fixed">
				<tr>
					<th>Action</th>
					<th>Sr no.</th>
					<th>Production Date</th>					
					<th>Shift</th>					
					<th>Machine</th>
					<th>Job Type</th>
					<th>Job Category</th>
					<th>Jobcard No.</th>
					<th>Jobsetup?</th>					
					<th>Customer</th>
					<th>Order No</th>
					<th>Article No.</th>
					<th>Product Name</th>
					<th>Dia</th>
					<th>Sleeve Length</th>
					<th>Print Type</th>
					<th>Laminate Color</th>
					<th>Body Making Type</th>
					<th>Jobcard Qty</th>
					<th>Jobcard Counter</th>
					<th>Total Printed Counter</th>										
					<th>Total Printed Qty</th>					
					<th>User Name</th>
					<th>Job Started On</th>
					<th>Job Ended On</th>
					<th>Job End Reason</th>
					<th>Remarks</th>
					<th>Action</th>
				
									
				</tr>	
				<?php 

				$sum_counter=0;
				$sum_printed_qty=0;
				$printing_done='0';
				$sum_jobcard_qty=0;
				$sum_jobcard_counter=0;

				if($springtube_printing_production_master==FALSE){
					echo "<tr><td colspan='25'>No Active Records Found</td></tr>";
				}
				else{

					$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
					
					$reel_length=$this->config->item('springtube_reel_length');
					$n=1;	
					foreach($springtube_printing_production_master as $master_row){
						
						

            			$details_data=array();
						$details_data['production_date']=$master_row->production_date;
						$details_data['shift']=$master_row->shift;

						if(!empty($this->input->post('order_no'))){
						 	
						 	$details_data['order_no']=$this->input->post('order_no');
						}
						if(!empty($this->input->post('jobcard_no'))){
						 	
						 	$details_data['jobcard_no']=$this->input->post('jobcard_no');
						}

						if(!empty($this->input->post('article_no'))){
						 	$arr=explode("//",$this->input->post('article_no'));
						 	$article_no=$arr[1];
						 	$details_data['article_no']=$article_no;
						}
							
						$result=$this->springtube_printing_production_model->select_active_shiftwise_master_records('springtube_printing_production_master',$details_data,$this->session->userdata['logged_in']['company_id']);
						//echo $this->db->last_query();
						
						$rowspan=count($result);
		    			$tr=$rowspan;

		    			if($rowspan>0){


		    				

		    				echo '<tr>
		    				<td rowspan="'.$rowspan.'">';
		    				foreach($formrights as $formrights_row){ 
								echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view_shiftwise/'.$master_row->production_date.'/'.$master_row->shift.'').'" target="_blank"><i class="print icon"></i></a> ' : '');
							}	

							echo '</td>
							<td rowspan="'.$rowspan.'">'.$n++.'</td>
							<td rowspan="'.$rowspan.'">'.$this->common_model->view_date($master_row->production_date,$this->session->userdata['logged_in']['company_id']).'</td>
							<td rowspan="'.$rowspan.'">'.$master_row->shift.'</td>
							';

							$r=0;
							foreach ($result as $drow){

								$jobcard_qty='';
								$ad_id='';
		            			$version_no='';
		            			$bom_no='';
		            			$bom_version_no='';
		            			$printing_done=0;
		            			

								$data['production_master']=$this->job_card_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$drow->jobcard_no);					        

						        foreach ($data['production_master'] as $production_master_row) {
						          
						            $jobcard_qty=$this->common_model->read_number($production_master_row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']);
						          
						            $printing_done=$production_master_row->printing_done;
						        }

								$data_order_details=array(
				                    'order_no'=>$drow->order_no,
				                    'article_no'=>$drow->article_no
				                    );

				                $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
				                foreach($order_details_result as $order_details_row){
				                  $ad_id=$order_details_row->ad_id;
				                  $version_no=$order_details_row->version_no;
				                  $bom_no=$order_details_row->spec_id;
				                  $bom_version_no=$order_details_row->spec_version_no;
				                }


				                $search_arr=array('production_id'=>$drow->production_id);
							
							    $springtube_printing_production_details_result=$this->springtube_printing_production_model->active_details_records('springtube_printing_production_details',$search_arr);
								$printed_counter=0;    
								foreach ($springtube_printing_production_details_result as $springtube_printing_production_details_row) {
									$printed_counter+=$springtube_printing_production_details_row->counter;
								}


								echo"<td>".$drow->machine_name."</td>
								<td>".$drow->job_type."</td>								
								<td >".($drow->job_category!=''?($drow->job_category==1?"NEW JOB":"REPEAT JOB"):"")."</td>
								<td><a href='".base_url('index.php/sales_order_item_parameterwise/view_new/'.$drow->jobcard_no.'/'.$bom_no.'/'.$bom_version_no)."' target='_blank'>".$drow->jobcard_no."</td>

								<td>";
								
								$data_search=array('jobcard_no'=>$drow->jobcard_no,'archive'=>'0');

								$springtube_printing_jobsetup_master_result=$this->common_model->select_active_records_where('springtube_printing_jobsetup_master',$this->session->userdata['logged_in']['company_id'],$data_search);

								if($springtube_printing_jobsetup_master_result==TRUE){

									foreach ($springtube_printing_jobsetup_master_result as $key => $springtube_printing_jobsetup_master_row) {
									
										echo
										"<a href='".base_url('index.php/Springtube_printing_jobsetup/view/'.$springtube_printing_jobsetup_master_row->job_id)."' target='_blank' style='color:#06c806;' ><i class='check circle icon'></i> Done<a>";
									}
								}else{

									echo'<a href="#" style="color: #f10606;"><i class="times circle icon"></i>Pending</a>';
								} 

								echo"</td>
								<td>".$this->common_model->get_customer_name($drow->customer,$this->session->userdata['logged_in']['company_id'])."</td>	
								<td><a href='".base_url('index.php/sales_order_book/view/'.$drow->order_no)."' target='_blank'> ".$drow->order_no."</a></td>			
								<td>".$drow->article_no."</td>
								<td>".$this->common_model->get_article_name($drow->article_no,$this->session->userdata['logged_in']['company_id'])."</td>										
								<td>".$drow->sleeve_dia."</td>
								<td>".$drow->sleeve_length."</td>
								<td>".$drow->print_type."</td>
								<td>".$drow->laminate_color."</td>
								<td>".$drow->body_making_type."</td>
								<td>".$jobcard_qty."</td>
								<td>".round($jobcard_qty/2)."</td>
								<td>".$printed_counter."</td>
								<td>".round($printed_counter*2)."</td>
								<td>".$this->common_model->get_user_name($drow->user_id,$this->session->userdata['logged_in']['company_id'])."</td>
								<td>".$this->common_model->view_date($drow->job_started_on,$this->session->userdata['logged_in']['company_id'])."</td>
								<td>".$this->common_model->view_date($drow->job_ended_on,$this->session->userdata['logged_in']['company_id'])."</td>
								<td>".$drow->shift_issue."</td>
								<td>".$drow->remarks."</td>
								<td >";
									foreach ($formrights as $formrights_row) {

										echo ($formrights_row->view==1 ? ' | <a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$drow->production_id.'').'" title="view" target="_blank"><i class="print icon"></i></a>' : '');									

										echo ($formrights_row->dearchive==1 ? ' | <a href="'.base_url('index.php/'.$this->router->fetch_class().'/dearchive/'.$drow->production_id.'').'" title="Dearchive" target="_blank"></i>Dearchive</a> ' : '');
											
									}
							echo"</td>

								</tr>";
								if($rowspan>1 && --$tr>0){
									echo'<tr>';
								}			

								$r++;


							}

            			 
					    }	


					}//master Foreach

						 

				}?>


								
			</table>
			<div class="pagination"><?php echo $this->pagination->create_links();?></div>
	</div>
</div>