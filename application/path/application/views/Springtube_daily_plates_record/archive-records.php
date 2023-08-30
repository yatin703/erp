<style>	
   tr:hover {background-color:#e4e4e4;}
</style>
<div class="record_form_design">
<h4>Archive Records</h4>
	<div class="record_inner_design"  style="overflow: scroll; white-space: nowrap;">
			<table class="record_table_design_without_fixed">
				
				<tr>
					<th>Sr No.</th>
					<th>Date</th>
					<th>Customer</th>
					<th>Order No.</th>
					<th>Article No.</th>
					<th>Article Name</th>					
					<th>Artwork No.</th> 
					<th>Jobcard No.</th>
					<th>Dia</th>
					<th>Tube Length</th>
					<th>Ups</th>
					<th>Repeat</th>
					<th>Plate Width</th>
					<th>Plate Height</th>
					<th>Total Plates</th>
					<th>Plate Sheet Used</th>
					<th>Plate Cost</th>
					<th>Shift</th>					 
					<th>Plate Making Reason</th>
					<th>Comment</th>
					<th>Plate Created By</th>
					<!--<th>Approved Date</th>
					<th>Approved By</th>-->
					<th>Action</th>
				</tr>
				<?php 

				$total_offset=0;

				if($springtube_daily_plates_master==FALSE){
					echo "<tr><td colspan='19'>No Active Records Found</td></tr>";
				}else{
							$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);

							 	
							foreach($springtube_daily_plates_master as $row){

								$customer='';
								$order_master_result=$this->common_model->select_one_active_record('order_master',$this->session->userdata['logged_in']['company_id'],'order_no',$row->order_no);

						        foreach($order_master_result as $order_master_row){
						          $customer=$order_master_row->customer_no;                      
						        }
								
								//Artwork Deatils-------------------------
					            $dataa=array('ad_id'=>$row->artwork_no,
					                    'version_no'=>$row->version_no 
					                      );
					            $springtube_artwork_result=$this->artwork_springtube_model->active_record_search_new('springtube_artwork_devel_master',$dataa,'','','',$this->session->userdata['logged_in']['company_id']);
					           // echo $this->db->last_query();

					            $body_making_type= '';
					            $sleeve_dia='';
					            $sleeve_length='';
					             foreach ($springtube_artwork_result as $springtube_artwork_row) {
					                $body_making_type=$springtube_artwork_row->body_making_type;
					                $sleeve_dia=$springtube_artwork_row->sleeve_dia;
					                $sleeve_length=$springtube_artwork_row->sleeve_length;
					            }

								
								echo"<tr>
									<td>".$i."</td>
									<td>".$this->common_model->view_date($row->dpr_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$this->common_model->get_customer_name($customer,$this->session->userdata['logged_in']['company_id'])."</td>
									<td><a href='".base_url('index.php/sales_order_book/view/'.$row->order_no)."' target='_blank'>".$row->order_no."</td>
									<td>".$row->article_no."</td>
									<td>".$this->common_model->get_article_name($row->article_no,$this->session->userdata['logged_in']['company_id'])."</td>
									<td><a href='".base_url('index.php/artwork_springtube/view/'.$row->artwork_no.'/'.$row->version_no)."' target='_blank'><b>".$row->artwork_no."_R".$row->version_no."</b></a></td>
									<!--<td>".$row->version_no."</td>-->
									<td><a href='".base_url('index.php/sales_order_item_parameterwise/view_new/'.$row->jobcard_no)."' target='_blank'>".$row->jobcard_no."</td>
									<td>".$sleeve_dia."</td>
									<td>".$sleeve_length." MM</td>
									<td>".$row->ups."</td>
									<td>".$row->repeat."</td>
									<td>".$row->plate_width." MM</td>
									<td>".$row->plate_height." MM</td>
									<td>".$row->total_plates."</td>
									<td>".$row->sheet_used."</td>
									<td> </td>
									<td>";
										$result_shift=$this->common_model->select_one_active_record('graphics_shift_master',$this->session->userdata['logged_in']['company_id'],'shift_id',$row->shift_id);
										foreach ($result_shift as $row_shift) {
											echo $row_shift->shift_name;
										}
										echo"</td>
										 
									<td>";
										$result_reason=$this->common_model->select_one_active_record('graphics_plate_making_reasons',$this->session->userdata['logged_in']['company_id'],'reason_id',$row->plate_making_reason);
										foreach ($result_reason as $row_reason) {
											echo $row_reason->reason;
										}
									echo "</td>									 
										 
										<td>".$row->comment."</td>
										<td><a class='ui tiny label'><i class='user icon'></i> ".strtoupper($this->common_model->get_user_name($row->user_id,$this->session->userdata['logged_in']['company_id']))."</a>
										</td>
										<!--<td>".($row->approved_date!='0000-00-00 00:00:00'?$this->common_model->view_date($row->approved_date,$this->session->userdata['logged_in']['company_id']):'')."</td>
										<td>";
										echo ($row->final_approval_flag<>0?"<a class='ui tiny label'><i class='user icon'></i> ".strtoupper($this->common_model->get_user_name($row->approved_by,$this->session->userdata['logged_in']['company_id']))."</a>":"");
										echo"</td>
										-->
										<td>";
										foreach($formrights as $formrights_row){ 

											echo ($row->archive==1 && $formrights_row->dearchive==1?'<a class="ui green label"  href="'.base_url('index.php/'.$this->router->fetch_class().'/dearchive/'.$row->dpr_id).'" target="_blank">Dearchive</a> ' : '');
																														
										}	


							echo "</td></tr>";

							//$total_offset+=$offset;
							// $total_screen+=$screen;
							// $total_flexo+=$flexo;


							$i++;
							}
						}?>
							 
							 	
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>