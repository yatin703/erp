<style>	
   tr:hover {background-color:#e4e4e4;}
</style>
<div class="record_form_design">
<h4>Active Records</h4>
	<div class="record_inner_design"  style="overflow: scroll; white-space: nowrap;">
			<table class="record_table_design_without_fixed">
				
				<tr>
					<th>Sr No.</th>
					<th>Action</th>
					<th>Setup Date</th>
					<th>Job Id</th>
					<th>Customer</th>
					<th>Order No</th>
					<th>Article No.</th>
					<!-- <th>Product Name</th> -->
					<th>Artwork</th>
					<!-- <th>Order Qty</th> -->
					<th>Dia X Length</th>
					<!-- <th>Length</th> -->
					<th>Print Type</th>
					<th>Film Color</th>
					<th>Body Making</th>
					<th>Jobcard No</th>
					<th>Jobcard Qty</th>
					<th>Printing Qty</th>					 					
					
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
					          $total_order_quantity=$this->common_model->read_number($order_details_row->total_order_quantity,$this->session->userdata['logged_in']['company_id']);
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
								<td>";
								foreach($formrights as $formrights_row){ 

										echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->job_id).'" target="_blank"><i class="print icon"></i></a> ' : '');

										echo ($formrights_row->modify==1 && $row->pending_flag==0 && $row->final_approval_flag<>1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->job_id).'" target="_blank"><i class="edit icon"></i></a> ' : '');

										echo ($formrights_row->copy==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/copy/'.$row->job_id).'" target="_blank"><i class="copy icon"></i></a> ' : '');										
										echo ($row->archive<>1 && $formrights_row->delete==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->job_id).'"><i class="trash icon" target="_blank"></i></a> ' : '');


																														
									}
								echo"</td>
								<td>".$this->common_model->view_date($row->jobsetup_date,$this->session->userdata['logged_in']['company_id'])."</td>
								<td style='color:#06c806;'>".($row->final_approval_flag==1?"<i class='check circle icon'></i>" : "")."<a href='".base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->job_id)."' target='_blank'></i>".$row->job_id."</a> 
								</td>
								<td>".$this->common_model->get_customer_name($customer,$this->session->userdata['logged_in']['company_id'])."</td>
								<td>".'<a href="'.base_url('index.php/sales_order_book/view/'.$order_no).'" target="_blank" >'.$order_no."</a></td>
								<td title='".$this->common_model->get_article_name($row->article_no,$this->session->userdata['logged_in']['company_id'])."'>".$article_no."</td>
								<!--<td>".$this->common_model->get_article_name($row->article_no,$this->session->userdata['logged_in']['company_id'])."</td>
								-->
								<td>".'<a href="'.base_url('index.php/artwork_springtube/view/'.$ad_id.'/'.$version_no).'" target="_blank" >'.($ad_id!=''?$ad_id."_R".$version_no:"")."</td>
								<!--<td>".number_format($total_order_quantity,0,'.',',')."</td>-->
								<td>".$dia." X ".$length." MM</td>
								<!--<td>".$length." MM</td>-->
								<td>".$print_type."</td>
								<td>".$laminate_color."</td>
								<td>".$body_making_type."</td>
								<td>".'<a href="'.base_url('index.php/sales_order_item_parameterwise/view_new/'.$row->jobcard_no.'/'.$bom_no.'/'.$bom_version_no).'" target="_blank" >'.$row->jobcard_no."</td>
								<td>".number_format($jobcard_qty,0,'.',',')."</td>
								<td>".number_format(round($printed_counter*2),0,'.',',')."</td>";
									

							echo "</tr>";				 


							$i++;
							}
						}?>							 
							 	
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>