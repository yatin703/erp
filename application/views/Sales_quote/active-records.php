<div class="record_form_design">
	<h4>Active Records <?php echo ($this->input->post('from_date')!=''? 'From '.$this->input->post('from_date').' To '.$this->input->post('to_date'):'')?></h4>
	<div class="record_inner_design" style="overflow:scroll; white-space: nowrap;">
			<table class="ui green sortable selectable celled table"  style="font-size:10px;">
				<thead>
				<tr>
						<th colspan="8">Information</th>
					<!-- 	<th colspan="2">Annual tube buy</th>
						<th colspan="2">Annual bottle buy </th>
						<th colspan="4">Customer</th>
						<th colspan="2">Current supplier price</th>
						<th colspan="4">Currently in</th>
					 -->	
					 	<th colspan="15">Specification</th>
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
						<th colspan="4">User</th>
				</tr>

				</thead>
					<thead>
					<tr>
					<th>Sr no.</th>
					<th>Action</th>					
					<th>Quotation Date</th>
					<th>Ver</th>
					<th>Quotation No</th>
					<th>Customer </th>
					<th>Purchase Manager </th>
					<!-- <th>Purchase Manager 2</th>
					<th>Min</th>
					<th>Max</th>
					<th>Min</th>
					<th>Max</th>
					<th>Current customer</th>
					<th>Previous customer</th>
					<th>Prospect</th>
					<th>Current supplier</th>
					<th>Min</th>
					<th>Max</th>
					<th>Tube</th>
					<th>Bottle</th>
					<th>Other packaging</th>
					 -->
					<th>Product Name</th>
					<th>Dia X Length</th>
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
					
					<th>5k price</th>
					
					<th>10k price</th>
					
					<th>25k price</th>
					
					<th>50k price</th>
					
					<th>100k price</th>
					
					<th>Free qty price</th>
				<!--	<th>Min</th>
					<th>Max</th>
					<th>Min</th>
					<th>Max</th>
					<th>Min</th>
					<th>Max</th>
					<th>Min</th>
					<th>Max</th>
				
					<th>article no</th>
					<th>invoice date</th>
				-->		
					<th>Invoice no</th>
					<th>Created by</th>	
					<th>Approved by</th>
					<th>Approved date</th>					 
					<th>remarks</th>					 
					 
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
									<td>";
										
										foreach ($formrights as $formrights_row) {

										echo ($formrights_row->view==1 && $row->final_approval_flag==1 ? '<a href="'.base_url('index.php/'.$this->router->fetch_class().'/view/'.$row->quotation_no.'/'.$row->version_no).'" title="view" target="_blank"><i class="print icon"></i></a> ' : '');

										echo ($formrights_row->modify==1 && $row->pending_flag==0 && $row->final_approval_flag==0 ?'  <a href="'.base_url('index.php/'.$this->router->fetch_class().'/modify/'.$row->quotation_no.'/'.$row->version_no).'" title="Modify" target="_blank"><i class="edit icon"></i></a> ' : '');

										echo ($formrights_row->delete==1 ? ' <a href="'.base_url('index.php/'.$this->router->fetch_class().'/delete/'.$row->id.'').'" title="Delete" target="_blank"><i class="trash icon"></i></a> ' : '');

										echo ($formrights_row->copy==1  ?'  <a href="'.base_url('index.php/'.$this->router->fetch_class().'/copy/'.$row->quotation_no.'/'.$row->version_no).'" title="Copy" target="_blank"><i class="copy icon"></i></a> ' : '');

										echo ($formrights_row->modify==1 && $row->pending_flag==1 && $row->final_approval_flag==1 ?'  <a href="'.base_url('index.php/'.$this->router->fetch_class().'/price_revision_modify/'.$row->quotation_no.'/'.$row->version_no).'" title="Modify" target="_blank"><i class="edit icon"></i></a> ' : '');

									if(!empty($row->_5k_rev_price) || (!empty($row->_10k_rev_price) || (!empty($row->_25k_rev_price) || (!empty($row->_50k_rev_price) || (!empty($row->_100k_rev_price) || (!empty($row->_free_rev_price))  ))))){		

										$data['version']=$this->sales_quote_model->select_quote_max_verion_no('sales_quote_master',$this->session->userdata['logged_in']['company_id'],'quotation_no',$row->quotation_no);
										//echo $this->db->last_query();	

											foreach ($data['version'] as $version_row) {

								                  if($version_row->version_no==NULL){

								                    $this->input->post('quotation_no')=='';
								                    $version_no = 1;

								                  }else{
								                    $version_no=$version_row->version_no;

								                   }
								               }
										  //echo $version_no;	    

										  if($version_no==$row->version_no){          

											echo ($formrights_row->modify==1 && $row->pending_flag==1 && $row->final_approval_flag==1 ?'  <a href="'.base_url('index.php/'.$this->router->fetch_class().'/price_revision/'.$row->quotation_no.'/'.$row->version_no).'" title="REV" target="_blank"><i class="map icon"></i></a> ' : '');	
											}										
										
										}

										
											
									}
									echo"</td>											
									<td>".$this->common_model->view_date($row->quotation_date,$this->session->userdata['logged_in']['company_id'])."</td>

									<td>".$row->version_no."</td>

									<td >".($row->final_approval_flag==1 ? "<i class='check green circle icon'></i>" : "")."".($row->pending_flag==1 && $row->final_approval_flag<>1 ? "<i class='telegram plane icon'></i>" : "")."".$row->quotation_no."</td>

										


									<td>".$customer_name."</td>
									<td>";
									$sales_quote_customer_contact_details=$this->common_model->select_one_record_with_company('address_category_contact_details',$this->session->userdata['logged_in']['company_id'],'address_category_contact_id',$row->pm_1);
									foreach ($sales_quote_customer_contact_details as $key => $sales_quote_customer_contact_details_row) {
										echo $sales_quote_customer_contact_details_row->contact_name;
									}				

									echo "</td>
									
									<!--<td>".$row->pm_2."</td>
									<td>".$row->annual_tube_buy_min."</td>
									<td>".$row->annual_tube_buy_max."</td>
									<td>".$row->annual_bottle_buy_min."</td>
									<td>".$row->annual_bottle_buy_max."</td>
									<td>".$row->current_customer."</td>
									<td>".$row->previous_customer."</td>
									<td>".$row->prospect."</td>
									<td>".$row->current_supplier."</td>
									<td>".$row->current_supplier_price_min."</td>
									<td>".$row->current_supplier_price_max."</td>
									<td>".($row->currently_in_tube==1?"YES":"NO")."</td>
									<td>".($row->currently_in_bottle==1?"YES":"NO")."</td>
									<td>".($row->currently_in_other_pckg==1?"YES":"NO")."</td>
									-->

									<td>".strtoupper($row->product_name)."</td>
									<td>".$row->sleeve_diameter." X ".$row->sleeve_length."</td>
									<td>".$row->layer."</td>
									<td>".strtoupper($row->tube_color)."</td>
									<td>".$row->print_type."</td>
									<td>".($row->tube_lacquer=="YES" ? "YES" : "-")."</td>
									<td>".($row->special_ink=="YES" ? "YES" : "-")."</td>
									<td>".($row->tube_foil=="YES" ? "YES" : "-")."</td>
									<td>".$row->cap_finish."</td>
									<td>".strtoupper($row->cap_color)."</td>
									<td>".$row->cap_type."</td>
									<td>".($row->cap_foil=="YES" ? "YES" : "-")."</td>
									<td>".($row->cap_shrink_sleeve=="YES" ? "YES" : "-")."</td>
									<td>".($row->cap_metalization=="YES" ? "YES" : "-")."</td>
									<td>".($row->shoulder_foil=="YES" ? "YES" : "-")."</td>
									<td>".$row->label_price."</td>
									
									<td>".($row->_5k_rev_price=='' ? $row->_5k_quoted_price : $row->_5k_rev_price)."</td>

									<td>".($row->_10k_rev_price=='' ? $row->_10k_quoted_price : $row->_10k_rev_price)."</td>

									<td>".($row->_25k_rev_price=='' ? $row->_25k_quoted_price : $row->_25k_rev_price)."</td>
									
									<td>".($row->_50k_rev_price=='' ? $row->_50k_quoted_price : $row->_50k_rev_price)."</td>

									<td>".($row->_100k_rev_price=='' ? $row->_100k_quoted_price : $row->_100k_rev_price)."</td>	
									
									<td>".($row->_free_rev_price=='' ? $row->free_quoted_price : $row->_free_rev_price)."</td>	
									
									
									
								<!--
																		
									
								-->

									<td><a href='".base_url('index.php/costsheet/view/'.$row->invoice_no.'/'.$row->order_no.'/'.$row->article_no)."' target='_blank'>".$row->invoice_no."</td>
									
									<td><a class='ui tiny label'><i class='user icon'></i>".$this->common_model->get_user_name($row->user_id,$this->session->userdata['logged_in']['company_id'])."</a></td>

									

									<td>".($row->final_approval_flag==1 ? "<a class='ui tiny label'><i class='checkmark box icon'></i>".substr(strtoupper($this->common_model->get_user_name($row->approved_by,$this->session->userdata['logged_in']['company_id'])),0,strpos($this->common_model->get_user_name($row->approved_by,$this->session->userdata['logged_in']['company_id']),' '))."</a>" : '')."</td>



									<td>".$this->common_model->view_date($row->approval_date,$this->session->userdata['logged_in']['company_id'])."</td>
									
									<td>".strtoupper($row->remarks)."</td>							 
 								 
									";
										

						} 

					}?>
				</tbody>				
			</table>
			<div class="pagination"><?php echo $this->pagination->create_links();?></div>
	</div>
</div>