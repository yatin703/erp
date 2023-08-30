<div class="record_form_design">
	<h4>Archive Records <?php echo ($this->input->post('from_date')!=''? 'From '.$this->input->post('from_date').' To '.$this->input->post('to_date'):'')?></h4>
	<div class="record_inner_design" style="overflow: scroll; white-space: nowrap;">
			<table class="ui very basic collapsing celled table"  style="font-size:10px;">
				<tr>
					<thead>
					<th>Sr no.</th>
										
					<th>Quotation Date</th>
					<th>Quotation No</th>
					<th>Customer no</th>
					<th>Purchase Manager 1</th>
					<th>Purchase Manager 2</th>
					<th>Annual tube buy min</th>
					<th>Annual tube buy max</th>
					<th>Annual bottle buy min</th>
					<th>Annual bottle buy max</th>
					<th>Current customer</th>
					<th>Previous customer</th>
					<th>Prospect</th>
					<th>Current supplier</th>
					<th>Current supplier price min</th>
					<th>Current supplier price max</th>
					<th>Currently in tube</th>
					<th>Currently in bottle</th>
					<th>Currently in other pckg</th>
					<th>New product</th>
					<th>Sleeve dia</th>
					<th>Sleeve length</th>
					<th>Layer</th>
					<th>Tube mb</th>
					<th>Print type</th>
					<th>Special ink</th>
					<th>Tube foil</th>
					<th>Cap finish</th>
					<th>Cap mb</th>
					<th>Cap type</th>
					<th>Cap foil</th>
					<th>Cap shrink sleeve</th>
					<th>Cap metalization</th>
					<th>Shoulder foil</th>
					<th>Label price</th>
					<th><10k target contr</th>
					<th><10k quoted contr</th>
					<th><10k cost</th>
					<th><10k quoted price</th>
					<th>10k - 25k target contr</th>
					<th>10k - 25k quoted contr</th>
					<th>10k - 25k cost</th>
					<th>10k - 25k quoted price</th>
					<th>25k - 50k target contr</th>
					<th>25k - 50k quoted contr</th>
					<th>25k - 50k cost</th>
					<th>25k - 50k quoted price</th>
					<th>50k - 100k target contr</th>
					<th>50k - 100k quoted contr</th>
					<th>50k - 100k cost</th>
					<th>50k - 100k quoted price</th>
					<th>100k - 250k target contr</th>
					<th>100k - 250k quoted contr</th>
					<th>100k - 250k cost</th>
					<th>100k - 250k quoted price</th>
					<th>>250k target contr</th>
					<th>>250k quoted contr</th>
					<th>>250k cost</th>
					<th>>250k quoted price</th>
					<th>50g min</th>
					<th>50g max</th>
					<th>100g min</th>
					<th>100g max</th>
					<th>150g min</th>
					<th>150g max</th>
					<th>200g min</th>
					<th>200g max</th>
					<th>article no</th>
					<th>invoice date</th>
					<th>invoice no</th>
					<th>cost</th>
					<th>user id</th>					 
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
									<td>".$row->quotation_no."</td>									 
									<td>".$customer_name."</td>
									<td>".$row->pm_1."</td>
									<td>".$row->pm_2."</td>
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
									<td>".$row->new_product."</td>
									<td>".$row->sleeve_dia."</td>
									<td>".$row->sleeve_length."</td>
									<td>".$row->layer."</td>
									<td>".$row->tube_mb."</td>
									<td>".$row->print_type."</td>
									<td>".$row->special_ink."</td>
									<td>".$row->tube_foil."</td>
									<td>".$row->cap_finish."</td>
									<td>".$row->cap_mb."</td>
									<td>".$row->cap_type."</td>
									<td>".$row->cap_foil."</td>
									<td>".$row->cap_shrink_sleeve."</td>
									<td>".$row->cap_metalization."</td>
									<td>".$row->shoulder_foil."</td>
									<td>".$row->label_price."</td>
									<td>".$row->less_than_10k_target_contr."</td>
									<td>".$row->less_than_10k_quoted_contr."</td>
									<td>".$row->less_than_10k_cost."</td>
									<td>".$row->less_than_10k_quoted_price."</td>
									<td>".$row->_10k_to_25k_target_contr."</td>
									<td>".$row->_10k_to_25k_quoted_contr."</td>
									<td>".$row->_10k_to_25k_cost."</td>
									<td>".$row->_10k_to_25k_quoted_price."</td>
									<td>".$row->_25k_to_50k_target_contr."</td>
									<td>".$row->_25k_to_50k_quoted_contr."</td>
									<td>".$row->_25k_to_50k_cost."</td>
									<td>".$row->_25k_to_50k_quoted_price."</td>
									<td>".$row->_50k_to_100k_target_contr."</td>
									<td>".$row->_50k_to_100k_quoted_contr."</td>
									<td>".$row->_50k_to_100k_cost."</td>
									<td>".$row->_50k_to_100k_quoted_price."</td>
									<td>".$row->_100k_to_250k_target_contr."</td>
									<td>".$row->_100k_to_250k_quoted_contr."</td>
									<td>".$row->_100k_to_250k_cost."</td>
									<td>".$row->_100k_to_250k_quoted_price."</td>
									<td>".$row->greater_than_250k_target_contr."</td>
									<td>".$row->greater_than_250k_quoted_contr."</td>
									<td>".$row->greater_than_250k_cost."</td>
									<td>".$row->greater_than_250k_quoted_price."</td>
									<td>".$row->_50g_min."</td>
									<td>".$row->_50g_max."</td>
									<td>".$row->_100g_min."</td>
									<td>".$row->_100g_max."</td>
									<td>".$row->_150g_min."</td>
									<td>".$row->_150g_max."</td>
									<td>".$row->_200g_min."</td>
									<td>".$row->_200g_max."</td>
									<td>".$row->article_no."</td>
									<td>".$row->invoice_date."</td>
									<td>".$row->invoice_no."</td>
									<td>".$row->cost."</td>
									<td>".$this->common_model->get_user_name($row->user_id,$this->session->userdata['logged_in']['company_id'])."</td>
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