
					<?php
					setlocale(LC_MONETARY, 'en_IN');
					if($print_type_wise==FALSE){

					}else{
						echo '<table class="ui sortable selectable celled table" style="font-size:10px;">
					        	<thead>
								   <tr>
								    	<th colspan="32"><a class="ui orange label">CONTRIBUTION BY PRINT TYPE </a><a class="ui red label">MILLIONS </a>'.($from_date!='' && $to_date!='' ? 
								    		' <a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date($from_date,$this->session->userdata['logged_in']['company_id']).'  TO '.$this->common_model->view_date($to_date,$this->session->userdata['logged_in']['company_id']).'</a><br/><br/>' : '').'</th>
								  </tr>
								  <tr>
					        			<th colspan="2"></th>
					        			<th colspan="20" class="center aligned">COEX TUBE</th>
					        			<th colspan="5" class="center aligned">SPRING TUBE</th>
					        			<th colspan="5" class="center aligned">GRAND TOTAL</th>
					        	  </tr>
								  <tr>
					        			<th colspan="2"></th>
					        			<th colspan="5" class="center aligned">SCREEN+FLEXO</th>
					        			<th colspan="5" class="center aligned">OFFSET</th>
					        			<th colspan="5" class="center aligned">LABEL</th>
					        			<th colspan="5" class="center aligned">COEX</th>
					        			<th colspan="5" class="center aligned">DIGITAL</th>
					        			<th colspan="5" class="center aligned">MONTH WISE TOTAL</th>
					        		</tr>
					        		<tr>
					        			<th>SR NO</th>
					        			<th>YEAR- MONTH</th>
					        			<th class="active right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">CONTR</th>
					        			<th class="right aligned">AVG PRICE</th>					        			
					        			<th class="right aligned">CONTR/TUBE</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">CONTR</th>					        			
					        			<th class="right aligned">AVG PRICE</th>					        			
					        			<th class="right aligned">CONTR/TUBE</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">CONTR</th>
					        			<th class="right aligned">AVG PRICE</th>					        			
					        			<th class="right aligned">CONTR/TUBE</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">CONTR</th>
					        			<th class="right aligned">AVG PRICE</th>					        			
					        			<th class="right aligned">CONTR/TUBE</th>

					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">CONTR</th>
					        			<th class="right aligned">AVG PRICE</th>					        			
					        			<th class="right aligned">CONTR/TUBE</th>

					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">CONTR</th>
					        			<th class="right aligned">AVG PRICE</th>
					        			<th class="right aligned">CONTR/TUBE</th>

					        		</tr>
					        	</thead>';
					        	$i=1;
					        	$total_screen_flexo_quantity=0;
					        	$total_screen_flexo_value=0;
					        	$total_screen_flexo_contribution_value=0;

					        	$total_offset_quantity=0;
					        	$total_offset_value=0;
					        	$total_offset_contribution_value=0;

					        	$total_label_quantity=0;
					        	$total_label_value=0;
					        	$total_label_contribution_value=0;

					        	$total_coex_quantity=0;
					        	$total_coex_value=0;
					        	$total_coex_contribution_value=0;


					        	$total_spring_quantity=0;
					        	$total_spring_value=0;
					        	$total_spring_contribution_value=0;


					        	$total_grand_quantity=0;
					        	$total_grand_value=0;
					        	$total_grand_contribution_value=0;

								foreach($print_type_wise as $row_coex){
									$screen_flexo_avg_price=0;
									$screen_flexo_avg_price=($row_coex->SCREEN_FLEXO_SALE_VALUE!=0 ? $row_coex->SCREEN_FLEXO_SALE_VALUE/$row_coex->SCREEN_FLEXO_QUANTITY : 0);
									$screen_flexo_contribution_tube=0;
									$screen_flexo_contribution_tube=($row_coex->SCREEN_FLEXO_CONTR_VALUE!=0 ? $row_coex->SCREEN_FLEXO_CONTR_VALUE/$row_coex->SCREEN_FLEXO_QUANTITY : 0);


									$offset_avg_price=0;
									$offset_avg_price=($row_coex->OFFSET_SALE_VALUE!=0 ? $row_coex->OFFSET_SALE_VALUE/$row_coex->OFFSET_QUANTITY : 0);
									$offset_contribution_tube=0;
									$offset_contribution_tube=($row_coex->OFFSET_CONTR_VALUE!=0 ? $row_coex->OFFSET_CONTR_VALUE/$row_coex->OFFSET_QUANTITY : 0);

									$label_avg_price=0;
									$label_avg_price=($row_coex->LABEL_SALE_VALUE!=0 ? $row_coex->LABEL_SALE_VALUE/$row_coex->LABEL_QUANTITY : 0);
									$label_contribution_tube=0;
									$label_contribution_tube=($row_coex->LABEL_CONTR_VALUE!=0 ? $row_coex->LABEL_CONTR_VALUE/$row_coex->LABEL_QUANTITY : 0);

									$spring_avg_price=0;
									$spring_avg_price=($row_coex->SPRING_SALE_VALUE!=0 ? $row_coex->SPRING_SALE_VALUE/$row_coex->SPRING_QUANTITY : 0);
									$spring_contribution_tube=0;
									$spring_contribution_tube=($row_coex->SPRING_CONTR_VALUE!=0 ? $row_coex->SPRING_CONTR_VALUE/$row_coex->SPRING_QUANTITY : 0);	


									$total_print_type_coex_quantity=0;
									$total_print_type_coex_quantity=$row_coex->SCREEN_FLEXO_QUANTITY+$row_coex->OFFSET_QUANTITY+$row_coex->LABEL_QUANTITY;

									$total_print_type_coex_value=0;
									$total_print_type_coex_value=$row_coex->SCREEN_FLEXO_SALE_VALUE+$row_coex->OFFSET_SALE_VALUE+$row_coex->LABEL_SALE_VALUE;

									$total_print_type_coex_contr=0;
									$total_print_type_coex_contr=$row_coex->SCREEN_FLEXO_CONTR_VALUE+$row_coex->OFFSET_CONTR_VALUE+$row_coex->LABEL_CONTR_VALUE;

									$total_print_type_coex_avg_price=0;
									$total_print_type_coex_avg_price=($total_print_type_coex_value!=0 ? $total_print_type_coex_value/$total_print_type_coex_quantity : 0);

									$total_print_type_coex_contr_tube=0;
									$total_print_type_coex_contr_tube=($total_print_type_coex_contr!=0 ? $total_print_type_coex_contr/$total_print_type_coex_quantity : 0);

									$total_print_type_quantity=0;
									$total_print_type_quantity=$row_coex->SCREEN_FLEXO_QUANTITY+$row_coex->OFFSET_QUANTITY+$row_coex->LABEL_QUANTITY+$row_coex->SPRING_QUANTITY;

									$total_print_type_value=0;
									$total_print_type_value=$row_coex->SCREEN_FLEXO_SALE_VALUE+$row_coex->OFFSET_SALE_VALUE+$row_coex->LABEL_SALE_VALUE+$row_coex->SPRING_SALE_VALUE;

									$total_print_type_contr=0;
									$total_print_type_contr=$row_coex->SCREEN_FLEXO_CONTR_VALUE+$row_coex->OFFSET_CONTR_VALUE+$row_coex->LABEL_CONTR_VALUE+$row_coex->SPRING_CONTR_VALUE;

									$total_print_type_avg_price=0;
									$total_print_type_avg_price=($total_print_type_value!=0 ? $total_print_type_value/$total_print_type_quantity : 0);

									$total_print_type_contr_tube=0;
									$total_print_type_contr_tube=($total_print_type_contr!=0 ? $total_print_type_contr/$total_print_type_quantity : 0);	



						
									echo "<tr>
										<td>$i</td>
										<td><b>".$row_coex->costsheet_year."-".strtoupper($row_coex->costsheet_month)."</b></td>
										<td class='negative right aligned'>".$this->common_model->read_number_million($row_coex->SCREEN_FLEXO_QUANTITY)."</td>
										<td class='negative right aligned'>".$this->common_model->read_number_million($row_coex->SCREEN_FLEXO_SALE_VALUE)."</td>
										<td class='negative right aligned'>".$this->common_model->read_number_million($row_coex->SCREEN_FLEXO_CONTR_VALUE)."</td>
										<td class='negative right aligned'>&#8377;".round($screen_flexo_avg_price,2)."</td>										
										<td class='negative right aligned'>&#8377;".round($screen_flexo_contribution_tube,2)."</td>

										<td class='positive right aligned'>".$this->common_model->read_number_million($row_coex->OFFSET_QUANTITY)."</td>
										<td class='positive right aligned'>".$this->common_model->read_number_million($row_coex->OFFSET_SALE_VALUE)."</td>
										<td class='positive right aligned'>".$this->common_model->read_number_million($row_coex->OFFSET_CONTR_VALUE)."</td>
										<td class='positive right aligned'>&#8377;".round($offset_avg_price,2)."</td>										
										<td class='positive right aligned'>&#8377;".round($offset_contribution_tube,2)."</td>


										<td class='right aligned'>".$this->common_model->read_number_million($row_coex->LABEL_QUANTITY)."</td>
										<td class='right aligned'>".$this->common_model->read_number_million($row_coex->LABEL_SALE_VALUE)."</td>
										<td class='right aligned'>".$this->common_model->read_number_million($row_coex->LABEL_CONTR_VALUE)."</td>
										<td class='right aligned'>&#8377;".round($label_avg_price,2)."</td>										
										<td class='right aligned'>&#8377;".round($label_contribution_tube,2)."</td>


										<td class='active right aligned'>".$this->common_model->read_number_million($total_print_type_coex_quantity)."</td>
										<td class='active right aligned'>".$this->common_model->read_number_million($total_print_type_coex_value)."</td>
										<td class='active right aligned'>".$this->common_model->read_number_million($total_print_type_coex_contr)."</td>
										<td class='active right aligned'>&#8377;".round($total_print_type_coex_avg_price,2)."</td>	
										<td class='active right aligned'>&#8377;".round($total_print_type_coex_contr_tube,2)."</td>


										<td class='negative right aligned'>".$this->common_model->read_number_million($row_coex->SPRING_QUANTITY)."</td>
										<td class='negative right aligned'>".$this->common_model->read_number_million($row_coex->SPRING_SALE_VALUE)."</td>
										<td class='negative right aligned'>".$this->common_model->read_number_million($row_coex->SPRING_CONTR_VALUE)."</td>
										<td class='negative right aligned'>&#8377;".round($spring_avg_price,2)."</td>										
										<td class='negative right aligned'>&#8377;".round($spring_contribution_tube,2)."</td>

										<td class='active right aligned'>".$this->common_model->read_number_million($total_print_type_quantity)."</td>
										<td class='active right aligned'>".$this->common_model->read_number_million($total_print_type_value)."</td>
										<td class='active right aligned'>".$this->common_model->read_number_million($total_print_type_contr)."</td>
										<td class='active right aligned'>&#8377;".round($total_print_type_avg_price,2)."</td>	
										<td class='active right aligned'>&#8377;".round($total_print_type_contr_tube,2)."</td>


										</tr>";
										
									$i++;
									$total_screen_flexo_quantity+=$row_coex->SCREEN_FLEXO_QUANTITY;
									$total_screen_flexo_value+=$row_coex->SCREEN_FLEXO_SALE_VALUE;
									$total_screen_flexo_contribution_value+=$row_coex->SCREEN_FLEXO_CONTR_VALUE;
									$total_screen_flexo_avg_price=0;
									$total_screen_flexo_avg_price=($total_screen_flexo_value!=0 ? $total_screen_flexo_value/$total_screen_flexo_quantity : 0);

									$total_screen_flexo_contribution_price=0;
									$total_screen_flexo_contribution_price=($total_screen_flexo_contribution_value!=0 ? $total_screen_flexo_contribution_value/$total_screen_flexo_quantity : 0);



									$total_offset_quantity+=$row_coex->OFFSET_QUANTITY;
									$total_offset_value+=$row_coex->OFFSET_SALE_VALUE;
									$total_offset_contribution_value+=$row_coex->OFFSET_CONTR_VALUE;
									$total_offset_avg_price=0;
									$total_offset_avg_price=($total_offset_value!=0 ? $total_offset_value/$total_offset_quantity : 0);
									
									$total_offset_contribution_price=0;
									$total_offset_contribution_price=($total_offset_contribution_value!=0 ? $total_offset_contribution_value/$total_offset_quantity : 0);

									$total_label_quantity+=$row_coex->LABEL_QUANTITY;
									$total_label_value+=$row_coex->LABEL_SALE_VALUE;
									$total_label_contribution_value+=$row_coex->LABEL_CONTR_VALUE;
									$total_label_avg_price=0;
									$total_label_avg_price=($total_label_value!=0 ? $total_label_value/$total_label_quantity : 0);
									
									$total_label_contribution_price=0;
									$total_label_contribution_price=($total_label_contribution_value!=0 ? $total_label_contribution_value/$total_label_quantity : 0);


									$total_coex_quantity+=$total_print_type_coex_quantity;
									$total_coex_value+=$total_print_type_coex_value;
									$total_coex_contribution_value+=$total_print_type_coex_contr;
									$total_coex_avg_price=0;
									$total_coex_avg_price=($total_coex_value!=0 ? $total_coex_value/$total_coex_quantity : 0);
									
									$total_coex_contribution_price=0;
									$total_coex_contribution_price=($total_coex_contribution_value!=0 ? $total_coex_contribution_value/$total_coex_quantity : 0);

									$total_spring_quantity+=$row_coex->SPRING_QUANTITY;
									$total_spring_value+=$row_coex->SPRING_SALE_VALUE;
									$total_spring_contribution_value+=$row_coex->SPRING_CONTR_VALUE;
									$total_spring_avg_price=0;
									$total_spring_avg_price=($total_spring_value!=0 ? $total_spring_value/$total_spring_quantity : 0);
									
									$total_spring_contribution_price=0;
									$total_spring_contribution_price=($total_spring_contribution_value!=0 ? $total_spring_contribution_value/$total_spring_quantity : 0);


									$total_grand_quantity+=$total_print_type_quantity;
									$total_grand_value+=$total_print_type_value;
									$total_grand_contribution_value+=$total_print_type_contr;
									$total_grand_avg_price=0;
									$total_grand_avg_price=($total_grand_value!=0 ? $total_grand_value/$total_grand_quantity : 0);
									
									$total_grand_contribution_price=0;
									$total_grand_contribution_price=($total_grand_contribution_value!=0 ? $total_grand_contribution_value/$total_grand_quantity : 0);



								}

							echo "
							<thead>
								<tr>
								<th colspan='2'>GRAND TOTAL</th>
								<th class='right aligned'>".$this->common_model->read_number_million($total_screen_flexo_quantity)."</th>
								<th class='right aligned'>".$this->common_model->read_number_million($total_screen_flexo_value)."</th>
								<th class='right aligned'>".$this->common_model->read_number_million($total_screen_flexo_contribution_value)."</th>
								<th class='right aligned'>&#8377;".round($total_screen_flexo_avg_price,2)."</th>
								<th class='right aligned'>&#8377;".round($total_screen_flexo_contribution_price,2)."</th>

								<th class='right aligned'>".$this->common_model->read_number_million($total_offset_quantity)."</th>
								<th class='right aligned'>".$this->common_model->read_number_million($total_offset_value)."</th>
								<th class='right aligned'>".$this->common_model->read_number_million($total_offset_contribution_value)."</th>
								<th class='right aligned'>&#8377;".round($total_offset_avg_price,2)."</th>
								<th class='right aligned'>&#8377;".round($total_offset_contribution_price,2)."</th>

								<th>".$this->common_model->read_number_million($total_label_quantity)."</th>
								<th>".$this->common_model->read_number_million($total_label_value)."</th>
								<th>".$this->common_model->read_number_million($total_label_contribution_value)."</th>
								<th class='right aligned'>&#8377;".round($total_label_avg_price,2)."</th>
								<th class='right aligned'>&#8377;".round($total_label_contribution_price,2)."</th>

								<th class='right aligned'>".$this->common_model->read_number_million($total_coex_quantity)."</th>
								<th class='right aligned'>".$this->common_model->read_number_million($total_coex_value)."</th>
								<th class='right aligned'>".$this->common_model->read_number_million($total_coex_contribution_value)."</th>
								<th class='right aligned'>&#8377;".round($total_coex_avg_price,2)."</th>
								<th class='right aligned'>&#8377;".round($total_coex_contribution_price,2)."</th>


								<th class='right aligned'>".$this->common_model->read_number_million($total_spring_quantity)."</th>
								<th class='right aligned'>".$this->common_model->read_number_million($total_spring_value)."</th>
								<th class='right aligned'>".$this->common_model->read_number_million($total_spring_contribution_value)."</th>
								<th class='right aligned'>&#8377;".round($total_spring_avg_price,2)."</th>
								<th class='right aligned'>&#8377;".round($total_spring_contribution_price,2)."</th>


								<th class='right aligned'>".$this->common_model->read_number_million($total_grand_quantity)."</th>
								<th class='right aligned'>".$this->common_model->read_number_million($total_grand_value)."</th>
								<th class='right aligned'>".$this->common_model->read_number_million($total_grand_contribution_value)."</th>
								<th class='right aligned'>&#8377;".round($total_grand_avg_price,2)."</th>
								<th class='right aligned'>&#8377;".round($total_grand_contribution_price,2)."</th>

								</tr>
							</thead>
							</table>";
				}
				?>
				