<div class="record_form_design">
	<h4>Active Records <?php echo ($this->input->post('from_date')!=''? 'From '.$this->input->post('from_date').' To '.$this->input->post('to_date'):'')?></h4>
	<div class="record_inner_design" style="overflow: scroll;">
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
					<th>Total Counter</th>											
					<th>Total Printed Qty</th>					
					<th>User Name</th>
									
				</tr>
				<?php 



				$sum_counter=0;

				if($springtube_printing_production_master==FALSE){
					echo "<tr><td colspan='22'>No Active Records Found</td></tr>";
				}else{
						$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
						
						$reel_length=$this->config->item('springtube_reel_length');
		

						foreach($springtube_printing_production_master as $master_row){
							$jobcard_qty='';
							$ad_id='';
                			$version_no='';
                			$bom_no='';
                			$bom_version_no='';

                			$data['production_master']=$this->job_card_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$master_row->jobcard_no);
					        

					        foreach ($data['production_master'] as $production_master_row) {
					          
					          $jobcard_qty=$this->common_model->read_number($production_master_row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']);
					          

					        }

							$data_order_details=array(
			                    'order_no'=>$master_row->order_no,
			                    'article_no'=>$master_row->article_no
			                    );

			                $order_details_result=$this->common_model->select_active_records_where('order_details',$this->session->userdata['logged_in']['company_id'],$data_order_details);
			                foreach($order_details_result as $order_details_row){
			                  $ad_id=$order_details_row->ad_id;
			                  $version_no=$order_details_row->version_no;
			                  $bom_no=$order_details_row->spec_id;
			                  $bom_version_no=$order_details_row->spec_version_no;
			                }	

							echo"<tr>
								<td >";
									foreach ($formrights as $formrights_row) {

										echo ($formrights_row->dearchive==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/dearchive/'.$master_row->production_id.'').'" title="Dearchive" target="_blank">Dearchive</a> ' : '');
											
									}
							echo"</td>	
									
							<td>".$i++."</td>
							<td>".$this->common_model->view_date($master_row->production_date,$this->session->userdata['logged_in']['company_id'])."</td>
							<td>".$master_row->shift."</td>
							<td >".$master_row->machine_name."</td>
							<td >".$master_row->job_type."</td>
							<td >".($master_row->job_category!=''?($master_row->job_category==1?"NEW JOB":"REPEAT JOB"):"")."</td>
							<td><a href='".base_url('index.php/sales_order_item_parameterwise/view_new/'.$master_row->jobcard_no.'/'.$bom_no.'/'.$bom_version_no)."' target='_blank'>".$master_row->jobcard_no."</td>
							<td>".$this->common_model->get_customer_name($master_row->customer,$this->session->userdata['logged_in']['company_id'])."</td>	
							<td><a href='".base_url('index.php/sales_order_book/view/'.$master_row->order_no)."' target='_blank'> ".$master_row->order_no."</a></td>			
							<td>".$master_row->article_no."</td>
							<td>".$this->common_model->get_article_name($master_row->article_no,$this->session->userdata['logged_in']['company_id'])."</td>										
							<td>".$master_row->sleeve_dia."</td>
							<td>".$master_row->sleeve_length."</td>
							<td>".$master_row->print_type."</td>
							<td>".$master_row->laminate_color."</td>
							<td>".$master_row->body_making_type."</td>
							<td>".$jobcard_qty."</td>
							<td>".$master_row->total_counter."</td>
							<td>".round($master_row->total_counter*2)."</td>
							<td>".$master_row->login_name."</td>
							";	
									
							$sum_counter+=$master_row->total_counter;
						}//master Foreach

						echo"<tr><td colspan='18' style='text-align:right;'><b>TOTAL</b></td><td><b>".$sum_counter."</b></td><td><b>".round($sum_counter*2)."</b></td><td></td></tr>";

					}?>


								
			</table>
			<div class="pagination"><?php echo $this->pagination->create_links();?></div>
	</div>
</div>