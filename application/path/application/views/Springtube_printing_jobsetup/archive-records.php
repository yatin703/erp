<style>	
   tr:hover {background-color:#e4e4e4;}
</style>
<div class="record_form_design">
<h4>Archive Records</h4>
	<div class="record_inner_design"  style="overflow: scroll; white-space: nowrap;">
			<table class="record_table_design_without_fixed">
				
				<tr>
					<th>Sr No.</th>
					<th>Job Setup Date</th>
					<th>Customer</th>
					<th>Order No</th>
					<th>Article No.</th>
					<th>Product Name</th>
					<th>Artwork No.</th>
					<th>Order Qty</th>
					<th>Dia</th>
					<th>Sleeve Length</th>
					<th>Print Type</th>
					<th>Laminate Color</th>
					<th>Body Making Type</th>
					<th>Jobcard No</th>
					<th>Jobcard Qty</th>
					<th>Printing Qty</th>					 					
					<th>Action</th>
				</tr>
				<?php 				 

				if($springtube_printing_jobsetup_master==FALSE){
					echo "<tr><td colspan='19'>No Active Records Found</td></tr>";
				}else{
						$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
							 	
						foreach($springtube_printing_jobsetup_master as $row){
							$customer='';
							$jobcard_qty=0;
					        $order_no='';
					        $article_no='';
					        $ad_id='';
					        $version_no='';
					        $dia='';
					        $length='';
					        $print_type='';
					        $laminate_color='';
					        $body_making_type='';
					        $total_order_quantity='';
					        $printed_counter=0;

							$data['production_master']=$this->job_card_model->select_one_active_record('production_master',$this->session->userdata['logged_in']['company_id'],'mp_pos_no',$row->jobcard_no);
					        //echo $this->db->last_query();
					       

					        foreach ($data['production_master'] as $production_master_row) {
					          
					          $jobcard_qty=$this->common_model->read_number($production_master_row->actual_qty_manufactured,$this->session->userdata['logged_in']['company_id']);
					          $order_no=$production_master_row->sales_ord_no;
					          $article_no=$production_master_row->article_no;

					        }

					        $order_master_result=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$order_no);
					        foreach($order_master_result as $order_master_row){
					          $customer=$order_master_row->customer_no;                      
					        }

					        $data_order_details=array('order_no'=>$order_no,'article_no'=>$article_no);

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
					          $print_type=$springtube_artwork_row->print_type;
					          $dia=$springtube_artwork_row->sleeve_dia;
					          $length=$springtube_artwork_row->sleeve_length;
					          $laminate_color=$springtube_artwork_row->laminate_color;
					        }					        

					        $search_data=array('jobcard_no'=>$row->jobcard_no);
					        $counter_result=$this->springtube_printing_production_model->select_total_counter('springtube_printing_production_master',$search_data);
					        foreach ($counter_result as $counter_row) {
					          $printed_counter=$counter_row->total_counter;
					        }
								
							echo"<tr>
								<td>".$i."</td>
								<td>".$row->jobsetup_date."</td>
								<td>".$this->common_model->get_customer_name($customer,$this->session->userdata['logged_in']['company_id'])."</td>
								<td>".$order_no."</td>
								<td>".$article_no."</td>
								<td>".$this->common_model->get_article_name($row->article_no,$this->session->userdata['logged_in']['company_id'])."</td>
								<td>".($ad_id!=''?$ad_id."_R".$version_no:"")."</td>
								<td>".$total_order_quantity."</td>
								<td>".$dia."</td>
								<td>".$length."</td>
								<td>".$print_type."</td>
								<td>".$laminate_color."</td>
								<td>".$body_making_type."</td>
								<td>".$row->jobcard_no."</td>
								<td>".$jobcard_qty."</td>
								<td>".round($printed_counter*2)."</td>
								  
								<td>";
									foreach($formrights as $formrights_row){ 

										echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->job_id).'"><i class="print icon"></i></a> ' : '');
										 										
										echo ($row->archive==1 && $formrights_row->dearchive==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/dearchive/'.$row->job_id).'"><i class="trash icon"></i></a> ' : '');
																														
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