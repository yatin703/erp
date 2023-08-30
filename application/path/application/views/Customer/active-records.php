<div class="record_form_design" >
<h3>Active Records</h3>
	<div class="record_inner_design" style="overflow: scroll;white-space: normal;">
			<table class="record_table_design">
				<tr>
					<th>Id</th>
					<th>Parent</th>
					<th>Customer</th>
					<th>Address</th>
					<th>Country</th>
					<th>State</th>
					<th>Email</th>
					<th>Contact</th>
					<th>Property</th>
					<th>Finance Account No</th>
					<th>Transit Days</th>
					<th>PAN No</th>
					<th>GST No</th>
					<th>Payment Term</th>
					<th>Last Bill Days</th>
					<th>Creation Date</th>
					<th>Tol %</th>
					<th>Lead Time</th>
					<th>Action</th>
				</tr>
				<?php if($customer==FALSE){
					echo "<tr><td colspan='14'>No Active Records Found</td></tr>";
				}else{
							foreach($customer as $row){

								$state_result=$this->customer_model->select_one_active_state_country_record('zip_code_master',$row->company_id,'zip_code',$row->zip_code);

								$country_result=$this->customer_model->select_one_active_state_country_record('country_master_lang',$row->company_id,'country_id',$row->country_id);

								echo "<tr>
									<td>$row->adr_company_id</td>
									<td>$row->category_name</td>
									<td>$row->name1</td>
									<td>$row->strno $row->name2 $row->street $row->street $row->name3 "."<br/>PIN : "."$row->city_code</td>
									<td>";if($country_result==FALSE){
																	echo '';
																}else{
																	foreach($country_result as $country){
																			echo "<i class='".strtolower($country->lang_country_name)." flag'></i>".$country->lang_country_name;
																	}
															}
									echo "</td>
									<td>";if($state_result==FALSE){
																echo '';
															}else{

															foreach($state_result as $state){
																	echo strtoupper($state->lang_city)." ".$state->state_code;
															}
													}

									echo ($row->zip_code!='' ? $row->zip_code : "pin missing");

									echo "</td>
									<td class='ellipses'>$row->email</td>
									<td>$row->telephone1 $row->telephone2</td>
									<td>".strtoupper($row->lang_property_name)."</td>
									<td>$row->financial_account_no</td>
									<td>$row->transit_days</td>
									<td>$row->post_box_code</td>
									<td class='ellipses'>$row->isdn_local</td>
									<td>$row->lang_description</td>
									<td>".$this->customer_model->last_bill_days_before('',$row->adr_company_id,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$this->common_model->view_date($row->contact_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>$row->dispatch_tolerance%</td>
									<td>".($row->max_lead_time!='' ? $row->max_lead_time." Days" : "")."</td>
									<td>";
									foreach($formrights as $formrights_row){ 
										echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->adr_company_id.'').'" target="_blank"><i class="print icon"></i></a> ' : '');
										echo ($formrights_row->copy==1 ? '<a href="#">Copy</a> ' : '');
										echo ($formrights_row->modify==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->adr_company_id.'').'"><i class="edit icon"></i></a> ' : '');
										echo ($row->archive<>1 && $formrights_row->delete==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->adr_company_id.'').'"><i class="trash icon"></i></a> ' : '');
									}
									echo "</td>
							</tr>";
							}
						}?>
								
						</table>
						<div class="pagination"><?php echo $this->pagination->create_links();?></div>
					</div>
				</div>