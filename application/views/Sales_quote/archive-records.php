<div class="record_form_design">
	<h4>Archive Records <?php echo ($this->input->post('from_date')!=''? 'From '.$this->input->post('from_date').' To '.$this->input->post('to_date'):'')?></h4>
	<div class="record_inner_design" style="overflow: scroll; white-space: nowrap;">
			<table class="ui very basic collapsing celled table"  style="font-size:10px;">
				<tr >
					<thead style="text-align: center;">
						<th colspan="7">Information</th>
					<!-- 	<th colspan="2">Annual tube buy</th>
						<th colspan="2">Annual bottle buy </th>
						<th colspan="4">Customer</th>
						<th colspan="2">Current supplier price</th>
						<th colspan="4">Currently in</th>
					 -->	
					 	<th colspan="16">Specification</th>
						<th colspan="1">5K</th>
						<th colspan="1">10K</th>
						<th colspan="1">25K</th>
						<th colspan="1">50K</th>
						<th colspan="1">100K</th>
						<th colspan="1">Free Quantity</th>
						
					<!--<th colspan="2">Price Range 50g</th>
						<th colspan="2">Price Range 100g</th>
						<th colspan="2">Price Range 150g</th>
						<th colspan="2">Price Range 200g</th>
					-->	
						<th colspan="1">Cost Sheet Details</th>
						<th colspan="5">User</th>
						

					</thead>

				</tr>


				<tr>
					<thead>
					<th>Sr no.</th>
					
										
					<th>Quotation Date</th>
					<th>Quotation No</th>
					<th>Ver</th>
					<th>Customer </th>
					<th>Purchase Manager </th>
					<th>Product Name </th>
					

					
					<th>Sleeve dia</th>
					<th>Sleeve length</th>
					<th>Layer</th>
					<th>Tube color</th>
					<th>Print type</th>
					<th>Tube lacquer</th>

					<th>Special ink</th>
					<th>Tube foil</th>
					<th>Cap finish</th>
					<th>Cap color</th>
					<th>Cap type</th>
					<th>Cap foil</th>
					<th>Cap shrink sleeve</th>
					<th>Cap metalization</th>
					<th>Shoulder foil</th>
					<th>Label price</th>
					
					<th>5k quoted price</th>
					
					<th>10k quoted price</th>
					
					<th>25k quoted price</th>
					
					<th>50k quoted price</th>
					
					<th>100k quoted price</th>
					
					<th>Free quoted price</th>
				<!--	<th>Min</th>
					<th>Max</th>
					<th>Min</th>
					<th>Max</th>
					<th>Min</th>
					<th>Max</th>
					<th>Min</th>
					<th>Max</th>
				-->	
					
					<th>Invoice no</th>
					
					<th>Created by</th>	
					<th>Approved by</th>	
					<th>Approved date</th>					 
					<th>remarks</th>
					<th>Action</th>					 
					 
				</tr>
			</thead>
			<tbody>
				<?php 

					
				if($sales_quote_master==FALSE){
					echo "<tr><td colspan='14'>No Active Records Found</td></tr>";
				}else{
						$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
						
						foreach($sales_quote_master as $row){

							$customer_name='';

							$customer_category_result=$this->common_model->select_one_active_record('address_category_master',$this->session->userdata['logged_in']['company_id'],'adr_category_id',$row->customer_no);

							foreach ($customer_category_result as $key => $customer_category_row) {
								$customer_name=$customer_category_row->category_name;
							}

							 ;
							echo"<tr>
										
									<td >".$i++."</td>	

									<td>".$this->common_model->view_date($row->quotation_date,$this->session->userdata['logged_in']['company_id'])."</td>

									<td >".($row->final_approval_flag==1 ? "<i class='check circle icon'></i>" : "")." <a href=".base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->quotation_no)." target='_blank'>".$row->quotation_no."</a></td>	
									<td>".$row->version_no."</td>							 
									<td>".$customer_name."</td>
									<td>";
									$sales_quote_customer_contact_details=$this->common_model->select_one_record_with_company('address_category_contact_details',$this->session->userdata['logged_in']['company_id'],'address_category_contact_id',$row->pm_1);
									foreach ($sales_quote_customer_contact_details as $key => $sales_quote_customer_contact_details_row) {
										echo $sales_quote_customer_contact_details_row->contact_name;
									}				

									echo "</td>
									<td>".strtoupper($row->product_name)."</td>
									
									<td>".$row->sleeve_diameter."</td>
									<td>".$row->sleeve_length."</td>
									<td>".$row->layer."</td>

									<td>".strtoupper($row->tube_color)."</td>
									<td>".$row->print_type."</td>
									<td>".$row->tube_lacquer."</td>
									<td>".$row->special_ink."</td>
									<td>".$row->tube_foil."</td>
									<td>".$row->cap_finish."</td>
									<td>".strtoupper($row->cap_color)."</td>
									<td>".$row->cap_type."</td>
									<td>".$row->cap_foil."</td>
									<td>".$row->cap_shrink_sleeve."</td>
									<td>".$row->cap_metalization."</td>
									<td>".$row->shoulder_foil."</td>
									<td>".$row->label_price."</td>

									
									<td>".$row->_5k_quoted_price."</td>
									
									<td>".$row->_10k_quoted_price."</td>
									
									<td>".$row->_25k_quoted_price."</td>
									
									<td>".$row->_50k_quoted_price."</td>
									
									<td>".$row->_100k_quoted_price."</td>
									
									<td>".$row->free_quoted_price."</td>

									
									
									<td><a href='".base_url('index.php/costsheet/view/'.$row->invoice_no.'/'.$row->order_no.'/'.$row->article_no)."' target='_blank'>".$row->invoice_no."</td>
									
									
									<td><a class='ui tiny label'><i class='user icon'></i>".$this->common_model->get_user_name($row->user_id,$this->session->userdata['logged_in']['company_id'])."</a></td>
									<td>".($row->final_approval_flag==1 ? "<a class='ui tiny label'><i class='checkmark box icon'></i>".substr(strtoupper($this->common_model->get_user_name($row->approved_by,$this->session->userdata['logged_in']['company_id'])),0,strpos($this->common_model->get_user_name($row->approved_by,$this->session->userdata['logged_in']['company_id']),' '))."</a>" : '')."</td>
									<td>".$this->common_model->view_date($row->approval_date,$this->session->userdata['logged_in']['company_id'])."</td>
									

									<td>".$row->remarks."</td>							 
 								 
									<td>";
									foreach($formrights as $formrights_row){ 

										echo ($formrights_row->view==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->id).'" target="_blank"><i class="print icon"></i></a> ' : '');					

																			
										echo ($row->archive==1 && $formrights_row->dearchive==1  ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/dearchive/'.$row->id).'">Dearchive</i></a> ' : '');
																		
									}

									echo"</td>";

										

						} 

					}?>
				</tbody>				
			</table>
			<div class="pagination"><?php echo $this->pagination->create_links();?></div>
	</div>
</div>