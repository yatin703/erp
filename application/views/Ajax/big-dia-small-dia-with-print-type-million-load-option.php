
					<?php
					setlocale(LC_MONETARY, 'en_IN');
					if($print_type_wise==FALSE){

					}else{
						echo '<table class="ui sortable selectable celled table" style="font-size:12px;">
					        	<thead>
								   <tr>
								    	<th colspan="33">
								    	<a class="ui red label">IN MILLIONS</a>
								    	<a class="ui orange label">BIG DIA & SMALL DIA CONTRIBUTION BY PRINT TYPE</a>'.($from_date!='' && $to_date!='' ? 
								    		' <a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date($from_date,$this->session->userdata['logged_in']['company_id']).'  TO '.$this->common_model->view_date($to_date,$this->session->userdata['logged_in']['company_id']).'</a><br/><br/>' : '');
								    	echo '</th>
								  </tr>
								  <tr>
					        			<th colspan="3"></th>
					        			<th colspan="20" class="center aligned">COEX TUBE</th>
					        			<th colspan="5" class="center aligned">SPRING TUBE</th>
					        			<th colspan="5" class="center aligned">GRAND TOTAL</th>
					        	  </tr>
								  <tr>
					        			<th colspan="3"></th>
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
					        			<th>DIA</th>
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
										<td></td>
										<td class='negative right aligned'><b>".$this->common_model->read_number_million($row_coex->SCREEN_FLEXO_QUANTITY)."</b></td>
										<td class='negative right aligned'><b>".$this->common_model->read_number_million($row_coex->SCREEN_FLEXO_SALE_VALUE)."</b></td>
										<td class='negative right aligned'><b>".$this->common_model->read_number_million($row_coex->SCREEN_FLEXO_CONTR_VALUE)."</b></td>
										<td class='negative right aligned'><b>&#8377;".round($screen_flexo_avg_price,2)."</b></td>										
										<td class='negative right aligned'><b>&#8377;".round($screen_flexo_contribution_tube,2)."</b></td>

										<td class='positive right aligned'><b>".$this->common_model->read_number_million($row_coex->OFFSET_QUANTITY)."</b></td>
										<td class='positive right aligned'><b>".$this->common_model->read_number_million($row_coex->OFFSET_SALE_VALUE)."</b></td>
										<td class='positive right aligned'><b>".$this->common_model->read_number_million($row_coex->OFFSET_CONTR_VALUE)."</b></td>
										<td class='positive right aligned'><b>&#8377;".round($offset_avg_price,2)."</b></td>										
										<td class='positive right aligned'><b>&#8377;".round($offset_contribution_tube,2)."</b></td>


										<td class='right aligned'><b>".$this->common_model->read_number_million($row_coex->LABEL_QUANTITY)."</b></td>
										<td class='right aligned'><b>".$this->common_model->read_number_million($row_coex->LABEL_SALE_VALUE)."</b></td>
										<td class='right aligned'><b>".$this->common_model->read_number_million($row_coex->LABEL_CONTR_VALUE)."</b></td>
										<td class='right aligned'><b>&#8377;".round($label_avg_price,2)."</b></td>										
										<td class='right aligned'><b>&#8377;".round($label_contribution_tube,2)."</b></td>


										<td class='active right aligned'><b>".$this->common_model->read_number_million($total_print_type_coex_quantity)."</b></td>
										<td class='active right aligned'><b>".$this->common_model->read_number_million($total_print_type_coex_value)."</b></td>
										<td class='active right aligned'><b>".$this->common_model->read_number_million($total_print_type_coex_contr)."</b></td>
										<td class='active right aligned'><b>&#8377;".round($total_print_type_coex_avg_price,2)."</b></td>	
										<td class='active right aligned'><b>&#8377;".round($total_print_type_coex_contr_tube,2)."</b></td>


										<td class='negative right aligned'><b>".$this->common_model->read_number_million($row_coex->SPRING_QUANTITY)."</b></td>
										<td class='negative right aligned'><b>".$this->common_model->read_number_million($row_coex->SPRING_SALE_VALUE)."</b></td>
										<td class='negative right aligned'><b>".$this->common_model->read_number_million($row_coex->SPRING_CONTR_VALUE)."</b></td>
										<td class='negative right aligned'><b>&#8377;".round($spring_avg_price,2)."</b></td>										
										<td class='negative right aligned'><b>&#8377;".round($spring_contribution_tube,2)."</b></td>

										<td class='active right aligned'><b>".$this->common_model->read_number_million($total_print_type_quantity)."</b></td>
										<td class='active right aligned'><b>".$this->common_model->read_number_million($total_print_type_value)."</b></td>
										<td class='active right aligned'><b>".$this->common_model->read_number_million($total_print_type_contr)."</b></td>
										<td class='active right aligned'><b>&#8377;".round($total_print_type_avg_price,2)."</b></td>	
										<td class='active right aligned'><b>&#8377;".round($total_print_type_contr_tube,2)."</b></td>


										</tr>";

										$monthwise_small_dia=$this->costsheet_model->contribution_by_small_dia_with_print_type($row_coex->costsheet_month,$row_coex->costsheet_year);
										if($monthwise_small_dia==FALSE){

										}else{
											foreach($monthwise_small_dia as $monthwise_small_dia_row){
												$SCREEN_FLEXO_SMALL_DIA_AVG_PRICE=0;
												$SCREEN_FLEXO_SMALL_DIA_AVG_PRICE=($monthwise_small_dia_row->SCREEN_FLEXO_SMALL_DIA_VALUE<>0 ? $monthwise_small_dia_row->SCREEN_FLEXO_SMALL_DIA_VALUE/$monthwise_small_dia_row->SCREEN_FLEXO_SMALL_DIA : '0');

												$SCREEN_FLEXO_SMALL_DIA_CONTRIBUTION_PER_TUBE=0;
												$SCREEN_FLEXO_SMALL_DIA_CONTRIBUTION_PER_TUBE=($monthwise_small_dia_row->SCREEN_FLEXO_SMALL_DIA_CONTRIBUTION_VALUE<>0 ? $monthwise_small_dia_row->SCREEN_FLEXO_SMALL_DIA_CONTRIBUTION_VALUE/$monthwise_small_dia_row->SCREEN_FLEXO_SMALL_DIA : '0');

												$OFFSET_SMALL_DIA_AVG_PRICE=0;
												$OFFSET_SMALL_DIA_AVG_PRICE=($monthwise_small_dia_row->OFFSET_SMALL_DIA_VALUE<>0 ? $monthwise_small_dia_row->OFFSET_SMALL_DIA_VALUE/$monthwise_small_dia_row->OFFSET_SMALL_DIA : '0');

												$OFFSET_SMALL_DIA_CONTRIBUTION_PER_TUBE=0;
												$OFFSET_SMALL_DIA_CONTRIBUTION_PER_TUBE=($monthwise_small_dia_row->OFFSET_SMALL_DIA_CONTRIBUTION_VALUE<>0 ? $monthwise_small_dia_row->OFFSET_SMALL_DIA_CONTRIBUTION_VALUE/$monthwise_small_dia_row->OFFSET_SMALL_DIA : '0');

												$LABEL_SMALL_DIA_AVG_PRICE=0;
												$LABEL_SMALL_DIA_AVG_PRICE=($monthwise_small_dia_row->LABEL_SMALL_DIA_VALUE<>0 ? $monthwise_small_dia_row->LABEL_SMALL_DIA_VALUE/$monthwise_small_dia_row->LABEL_SMALL_DIA : '0');

												$LABEL_SMALL_DIA_CONTRIBUTION_PER_TUBE=0;
												$LABEL_SMALL_DIA_CONTRIBUTION_PER_TUBE=($monthwise_small_dia_row->LABEL_SMALL_DIA_CONTRIBUTION_VALUE<>0 ? $monthwise_small_dia_row->LABEL_SMALL_DIA_CONTRIBUTION_VALUE/$monthwise_small_dia_row->LABEL_SMALL_DIA : '0');

												$SPRING_SMALL_DIA_AVG_PRICE=0;
												$SPRING_SMALL_DIA_AVG_PRICE=($monthwise_small_dia_row->SPRING_SMALL_DIA_VALUE<>0 ? $monthwise_small_dia_row->SPRING_SMALL_DIA_VALUE/$monthwise_small_dia_row->SPRING_SMALL_DIA : '0');

												$SPRING_SMALL_DIA_CONTRIBUTION_PER_TUBE=0;
												$SPRING_SMALL_DIA_CONTRIBUTION_PER_TUBE=($monthwise_small_dia_row->SPRING_SMALL_DIA_CONTRIBUTION_VALUE<>0 ? $monthwise_small_dia_row->SPRING_SMALL_DIA_CONTRIBUTION_VALUE/$monthwise_small_dia_row->SPRING_SMALL_DIA : '0');

												$TOTAL_ROW_COEX_SMALL_DIA=0;
												$TOTAL_ROW_COEX_SMALL_DIA=$monthwise_small_dia_row->SCREEN_FLEXO_SMALL_DIA+$monthwise_small_dia_row->OFFSET_SMALL_DIA+$monthwise_small_dia_row->LABEL_SMALL_DIA;

												$TOTAL_ROW_COEX_SMALL_DIA_VALUE=0;
												$TOTAL_ROW_COEX_SMALL_DIA_VALUE=$monthwise_small_dia_row->SCREEN_FLEXO_SMALL_DIA_VALUE+$monthwise_small_dia_row->OFFSET_SMALL_DIA_VALUE+$monthwise_small_dia_row->LABEL_SMALL_DIA_VALUE;

												$TOTAL_ROW_COEX_SMALL_DIA_CONTRIBUTION_VALUE=0;
												$TOTAL_ROW_COEX_SMALL_DIA_CONTRIBUTION_VALUE=$monthwise_small_dia_row->SCREEN_FLEXO_SMALL_DIA_CONTRIBUTION_VALUE+$monthwise_small_dia_row->OFFSET_SMALL_DIA_CONTRIBUTION_VALUE+$monthwise_small_dia_row->LABEL_SMALL_DIA_CONTRIBUTION_VALUE;

												$TOTAL_ROW_COEX_SMALL_DIA_AVG_PRICE=0;
												$TOTAL_ROW_COEX_SMALL_DIA_AVG_PRICE=($TOTAL_ROW_COEX_SMALL_DIA_VALUE<>0 ? $TOTAL_ROW_COEX_SMALL_DIA_VALUE/$TOTAL_ROW_COEX_SMALL_DIA : '0');

												$TOTAL_ROW_COEX_SMALL_DIA_CONTRIBUTION_PER_TUBE=0;
												$TOTAL_ROW_COEX_SMALL_DIA_CONTRIBUTION_PER_TUBE=($TOTAL_ROW_COEX_SMALL_DIA_CONTRIBUTION_VALUE<>0 ? $TOTAL_ROW_COEX_SMALL_DIA_CONTRIBUTION_VALUE/$TOTAL_ROW_COEX_SMALL_DIA : '0');

												$GRAND_TOTAL_ROW_COEX_SMALL_DIA=0;
												$GRAND_TOTAL_ROW_COEX_SMALL_DIA=$monthwise_small_dia_row->SCREEN_FLEXO_SMALL_DIA+$monthwise_small_dia_row->OFFSET_SMALL_DIA+$monthwise_small_dia_row->LABEL_SMALL_DIA+$monthwise_small_dia_row->SPRING_SMALL_DIA;

												$GRAND_TOTAL_ROW_COEX_SMALL_DIA_VALUE=0;
												$GRAND_TOTAL_ROW_COEX_SMALL_DIA_VALUE=$monthwise_small_dia_row->SCREEN_FLEXO_SMALL_DIA_VALUE+$monthwise_small_dia_row->OFFSET_SMALL_DIA_VALUE+$monthwise_small_dia_row->LABEL_SMALL_DIA_VALUE+$monthwise_small_dia_row->SPRING_SMALL_DIA_VALUE;

												$GRAND_TOTAL_ROW_COEX_SMALL_DIA_CONTRIBUTION_VALUE=0;
												$GRAND_TOTAL_ROW_COEX_SMALL_DIA_CONTRIBUTION_VALUE=$monthwise_small_dia_row->SCREEN_FLEXO_SMALL_DIA_CONTRIBUTION_VALUE+$monthwise_small_dia_row->OFFSET_SMALL_DIA_CONTRIBUTION_VALUE+$monthwise_small_dia_row->LABEL_SMALL_DIA_CONTRIBUTION_VALUE+$monthwise_small_dia_row->SPRING_SMALL_DIA_CONTRIBUTION_VALUE;

												$GRAND_TOTAL_ROW_COEX_SMALL_DIA_AVG_PRICE=0;
												$GRAND_TOTAL_ROW_COEX_SMALL_DIA_AVG_PRICE=($GRAND_TOTAL_ROW_COEX_SMALL_DIA_VALUE<>0 ? $GRAND_TOTAL_ROW_COEX_SMALL_DIA_VALUE/$GRAND_TOTAL_ROW_COEX_SMALL_DIA : '0');

												$GRAND_TOTAL_ROW_COEX_SMALL_DIA_CONTRIBUTION_PER_TUBE=0;
												$GRAND_TOTAL_ROW_COEX_SMALL_DIA_CONTRIBUTION_PER_TUBE=($GRAND_TOTAL_ROW_COEX_SMALL_DIA_CONTRIBUTION_VALUE<>0 ? $GRAND_TOTAL_ROW_COEX_SMALL_DIA_CONTRIBUTION_VALUE/$GRAND_TOTAL_ROW_COEX_SMALL_DIA : '0');

										echo "<tr>
												<td></td>
												<td></td>
												<td>19,25,30</td>
												<td class='negative right aligned'>".$this->common_model->read_number_million($monthwise_small_dia_row->SCREEN_FLEXO_SMALL_DIA)."</td>
												<td class='negative right aligned'>".$this->common_model->read_number_million($monthwise_small_dia_row->SCREEN_FLEXO_SMALL_DIA_VALUE)."</td>
												<td class='negative right aligned'>".$this->common_model->read_number_million($monthwise_small_dia_row->SCREEN_FLEXO_SMALL_DIA_CONTRIBUTION_VALUE)."</td>
												<td class='negative right aligned'>&#8377;".round($SCREEN_FLEXO_SMALL_DIA_AVG_PRICE,2)."</td>
												<td class='negative right aligned'>&#8377;".round($SCREEN_FLEXO_SMALL_DIA_CONTRIBUTION_PER_TUBE,2)."</td>



												<td class='positive right aligned'>".$this->common_model->read_number_million($monthwise_small_dia_row->OFFSET_SMALL_DIA)."</td>
												<td class='positive right aligned'>".$this->common_model->read_number_million($monthwise_small_dia_row->OFFSET_SMALL_DIA_VALUE)."</td>
												<td class='positive right aligned'>".$this->common_model->read_number_million($monthwise_small_dia_row->OFFSET_SMALL_DIA_CONTRIBUTION_VALUE)."</td>
												<td class='positive right aligned'>&#8377;".round($OFFSET_SMALL_DIA_AVG_PRICE,2)."</td>
												<td class='positive right aligned'>&#8377;".round($OFFSET_SMALL_DIA_CONTRIBUTION_PER_TUBE,2)."</td>


												<td class='right aligned'>".$this->common_model->read_number_million($monthwise_small_dia_row->LABEL_SMALL_DIA)."</td>
												<td class='right aligned'>".$this->common_model->read_number_million($monthwise_small_dia_row->LABEL_SMALL_DIA_VALUE)."</td>
												<td class='right aligned'>".$this->common_model->read_number_million($monthwise_small_dia_row->LABEL_SMALL_DIA_CONTRIBUTION_VALUE)."</td>
												<td class='right aligned'>&#8377;".round($LABEL_SMALL_DIA_AVG_PRICE,2)."</td>
												<td class='right aligned'>&#8377;".round($LABEL_SMALL_DIA_CONTRIBUTION_PER_TUBE,2)."</td>


												<td class='active right aligned'>".$this->common_model->read_number_million($TOTAL_ROW_COEX_SMALL_DIA)."</td>
												<td class='active right aligned'>".$this->common_model->read_number_million($TOTAL_ROW_COEX_SMALL_DIA_VALUE)."</td>
												<td class='active right aligned'>".$this->common_model->read_number_million($TOTAL_ROW_COEX_SMALL_DIA_CONTRIBUTION_VALUE)."</td>
												<td class='active right aligned'>&#8377;".round($TOTAL_ROW_COEX_SMALL_DIA_AVG_PRICE,2)."</td>
												<td class='active right aligned'>&#8377;".round($TOTAL_ROW_COEX_SMALL_DIA_CONTRIBUTION_PER_TUBE,2)."</td>

												<td class='negative right aligned'>".$this->common_model->read_number_million($monthwise_small_dia_row->SPRING_SMALL_DIA)."</td>
												<td class='negative right aligned'>".$this->common_model->read_number_million($monthwise_small_dia_row->SPRING_SMALL_DIA_VALUE)."</td>
												<td class='negative right aligned'>".$this->common_model->read_number_million($monthwise_small_dia_row->SPRING_SMALL_DIA_CONTRIBUTION_VALUE)."</td>
												<td class='negative right aligned'>&#8377;".round($SPRING_SMALL_DIA_AVG_PRICE,2)."</td>
												<td class='negative right aligned'>&#8377;".round($SPRING_SMALL_DIA_CONTRIBUTION_PER_TUBE,2)."</td>

												<td class='active right aligned'>".$this->common_model->read_number_million($GRAND_TOTAL_ROW_COEX_SMALL_DIA)."</td>
												<td class='active right aligned'>".$this->common_model->read_number_million($GRAND_TOTAL_ROW_COEX_SMALL_DIA_VALUE)."</td>
												<td class='active right aligned'>".$this->common_model->read_number_million($GRAND_TOTAL_ROW_COEX_SMALL_DIA_CONTRIBUTION_VALUE)."</td>
												<td class='active right aligned'>&#8377;".round($GRAND_TOTAL_ROW_COEX_SMALL_DIA_AVG_PRICE,2)."</td>
												<td class='active right aligned'>&#8377;".round($GRAND_TOTAL_ROW_COEX_SMALL_DIA_CONTRIBUTION_PER_TUBE,2)."</td>

											 </tr>";
											}
										}

										$monthwise_BIG_dia=$this->costsheet_model->contribution_by_BIG_dia_with_print_type($row_coex->costsheet_month,$row_coex->costsheet_year);
										if($monthwise_BIG_dia==FALSE){

										}else{
											foreach($monthwise_BIG_dia as $monthwise_BIG_dia_row){
												$SCREEN_FLEXO_BIG_DIA_AVG_PRICE=0;
												$SCREEN_FLEXO_BIG_DIA_AVG_PRICE=($monthwise_BIG_dia_row->SCREEN_FLEXO_BIG_DIA_VALUE<>0 ? $monthwise_BIG_dia_row->SCREEN_FLEXO_BIG_DIA_VALUE/$monthwise_BIG_dia_row->SCREEN_FLEXO_BIG_DIA : '0');

												$SCREEN_FLEXO_BIG_DIA_CONTRIBUTION_PER_TUBE=0;
												$SCREEN_FLEXO_BIG_DIA_CONTRIBUTION_PER_TUBE=($monthwise_BIG_dia_row->SCREEN_FLEXO_BIG_DIA_CONTRIBUTION_VALUE<>0 ? $monthwise_BIG_dia_row->SCREEN_FLEXO_BIG_DIA_CONTRIBUTION_VALUE/$monthwise_BIG_dia_row->SCREEN_FLEXO_BIG_DIA : '0');

												$OFFSET_BIG_DIA_AVG_PRICE=0;
												$OFFSET_BIG_DIA_AVG_PRICE=($monthwise_BIG_dia_row->OFFSET_BIG_DIA_VALUE<>0 ? $monthwise_BIG_dia_row->OFFSET_BIG_DIA_VALUE/$monthwise_BIG_dia_row->OFFSET_BIG_DIA : '0');

												$OFFSET_BIG_DIA_CONTRIBUTION_PER_TUBE=0;
												$OFFSET_BIG_DIA_CONTRIBUTION_PER_TUBE=($monthwise_BIG_dia_row->OFFSET_BIG_DIA_CONTRIBUTION_VALUE<>0 ? $monthwise_BIG_dia_row->OFFSET_BIG_DIA_CONTRIBUTION_VALUE/$monthwise_BIG_dia_row->OFFSET_BIG_DIA : '0');

												$LABEL_BIG_DIA_AVG_PRICE=0;
												$LABEL_BIG_DIA_AVG_PRICE=($monthwise_BIG_dia_row->LABEL_BIG_DIA_VALUE<>0 ? $monthwise_BIG_dia_row->LABEL_BIG_DIA_VALUE/$monthwise_BIG_dia_row->LABEL_BIG_DIA : '0');

												$LABEL_BIG_DIA_CONTRIBUTION_PER_TUBE=0;
												$LABEL_BIG_DIA_CONTRIBUTION_PER_TUBE=($monthwise_BIG_dia_row->LABEL_BIG_DIA_CONTRIBUTION_VALUE<>0 ? $monthwise_BIG_dia_row->LABEL_BIG_DIA_CONTRIBUTION_VALUE/$monthwise_BIG_dia_row->LABEL_BIG_DIA : '0');

												$SPRING_BIG_DIA_AVG_PRICE=0;
												$SPRING_BIG_DIA_AVG_PRICE=($monthwise_BIG_dia_row->SPRING_BIG_DIA_VALUE<>0 ? $monthwise_BIG_dia_row->SPRING_BIG_DIA_VALUE/$monthwise_BIG_dia_row->SPRING_BIG_DIA : '0');

												$SPRING_BIG_DIA_CONTRIBUTION_PER_TUBE=0;
												$SPRING_BIG_DIA_CONTRIBUTION_PER_TUBE=($monthwise_BIG_dia_row->SPRING_BIG_DIA_CONTRIBUTION_VALUE<>0 ? $monthwise_BIG_dia_row->SPRING_BIG_DIA_CONTRIBUTION_VALUE/$monthwise_BIG_dia_row->SPRING_BIG_DIA : '0');

												$TOTAL_ROW_COEX_BIG_DIA=0;
												$TOTAL_ROW_COEX_BIG_DIA=$monthwise_BIG_dia_row->SCREEN_FLEXO_BIG_DIA+$monthwise_BIG_dia_row->OFFSET_BIG_DIA+$monthwise_BIG_dia_row->LABEL_BIG_DIA;

												$TOTAL_ROW_COEX_BIG_DIA_VALUE=0;
												$TOTAL_ROW_COEX_BIG_DIA_VALUE=$monthwise_BIG_dia_row->SCREEN_FLEXO_BIG_DIA_VALUE+$monthwise_BIG_dia_row->OFFSET_BIG_DIA_VALUE+$monthwise_BIG_dia_row->LABEL_BIG_DIA_VALUE;

												$TOTAL_ROW_COEX_BIG_DIA_CONTRIBUTION_VALUE=0;
												$TOTAL_ROW_COEX_BIG_DIA_CONTRIBUTION_VALUE=$monthwise_BIG_dia_row->SCREEN_FLEXO_BIG_DIA_CONTRIBUTION_VALUE+$monthwise_BIG_dia_row->OFFSET_BIG_DIA_CONTRIBUTION_VALUE+$monthwise_BIG_dia_row->LABEL_BIG_DIA_CONTRIBUTION_VALUE;

												$TOTAL_ROW_COEX_BIG_DIA_AVG_PRICE=0;
												$TOTAL_ROW_COEX_BIG_DIA_AVG_PRICE=($TOTAL_ROW_COEX_BIG_DIA_VALUE<>0 ? $TOTAL_ROW_COEX_BIG_DIA_VALUE/$TOTAL_ROW_COEX_BIG_DIA : '0');

												$TOTAL_ROW_COEX_BIG_DIA_CONTRIBUTION_PER_TUBE=0;
												$TOTAL_ROW_COEX_BIG_DIA_CONTRIBUTION_PER_TUBE=($TOTAL_ROW_COEX_BIG_DIA_CONTRIBUTION_VALUE<>0 ? $TOTAL_ROW_COEX_BIG_DIA_CONTRIBUTION_VALUE/$TOTAL_ROW_COEX_BIG_DIA : '0');

												$GRAND_TOTAL_ROW_COEX_BIG_DIA=0;
												$GRAND_TOTAL_ROW_COEX_BIG_DIA=$monthwise_BIG_dia_row->SCREEN_FLEXO_BIG_DIA+$monthwise_BIG_dia_row->OFFSET_BIG_DIA+$monthwise_BIG_dia_row->LABEL_BIG_DIA+$monthwise_BIG_dia_row->SPRING_BIG_DIA;

												$GRAND_TOTAL_ROW_COEX_BIG_DIA_VALUE=0;
												$GRAND_TOTAL_ROW_COEX_BIG_DIA_VALUE=$monthwise_BIG_dia_row->SCREEN_FLEXO_BIG_DIA_VALUE+$monthwise_BIG_dia_row->OFFSET_BIG_DIA_VALUE+$monthwise_BIG_dia_row->LABEL_BIG_DIA_VALUE+$monthwise_BIG_dia_row->SPRING_BIG_DIA_VALUE;

												$GRAND_TOTAL_ROW_COEX_BIG_DIA_CONTRIBUTION_VALUE=0;
												$GRAND_TOTAL_ROW_COEX_BIG_DIA_CONTRIBUTION_VALUE=$monthwise_BIG_dia_row->SCREEN_FLEXO_BIG_DIA_CONTRIBUTION_VALUE+$monthwise_BIG_dia_row->OFFSET_BIG_DIA_CONTRIBUTION_VALUE+$monthwise_BIG_dia_row->LABEL_BIG_DIA_CONTRIBUTION_VALUE+$monthwise_BIG_dia_row->SPRING_BIG_DIA_CONTRIBUTION_VALUE;

												$GRAND_TOTAL_ROW_COEX_BIG_DIA_AVG_PRICE=0;
												$GRAND_TOTAL_ROW_COEX_BIG_DIA_AVG_PRICE=($GRAND_TOTAL_ROW_COEX_BIG_DIA_VALUE<>0 ? $GRAND_TOTAL_ROW_COEX_BIG_DIA_VALUE/$GRAND_TOTAL_ROW_COEX_BIG_DIA : '0');

												$GRAND_TOTAL_ROW_COEX_BIG_DIA_CONTRIBUTION_PER_TUBE=0;
												$GRAND_TOTAL_ROW_COEX_BIG_DIA_CONTRIBUTION_PER_TUBE=($GRAND_TOTAL_ROW_COEX_BIG_DIA_CONTRIBUTION_VALUE<>0 ? $GRAND_TOTAL_ROW_COEX_BIG_DIA_CONTRIBUTION_VALUE/$GRAND_TOTAL_ROW_COEX_BIG_DIA : '0');

										echo "<tr>
												<td></td>
												<td></td>
												<td>35,40,50</td>
												<td class='negative right aligned'>".$this->common_model->read_number_million($monthwise_BIG_dia_row->SCREEN_FLEXO_BIG_DIA)."</td>
												<td class='negative right aligned'>".$this->common_model->read_number_million($monthwise_BIG_dia_row->SCREEN_FLEXO_BIG_DIA_VALUE)."</td>
												<td class='negative right aligned'>".$this->common_model->read_number_million($monthwise_BIG_dia_row->SCREEN_FLEXO_BIG_DIA_CONTRIBUTION_VALUE)."</td>
												<td class='negative right aligned'>&#8377;".round($SCREEN_FLEXO_BIG_DIA_AVG_PRICE,2)."</td>
												<td class='negative right aligned'>&#8377;".round($SCREEN_FLEXO_BIG_DIA_CONTRIBUTION_PER_TUBE,2)."</td>



												<td class='positive right aligned'>".$this->common_model->read_number_million($monthwise_BIG_dia_row->OFFSET_BIG_DIA)."</td>
												<td class='positive right aligned'>".$this->common_model->read_number_million($monthwise_BIG_dia_row->OFFSET_BIG_DIA_VALUE)."</td>
												<td class='positive right aligned'>".$this->common_model->read_number_million($monthwise_BIG_dia_row->OFFSET_BIG_DIA_CONTRIBUTION_VALUE)."</td>
												<td class='positive right aligned'>&#8377;".round($OFFSET_BIG_DIA_AVG_PRICE,2)."</td>
												<td class='positive right aligned'>&#8377;".round($OFFSET_BIG_DIA_CONTRIBUTION_PER_TUBE,2)."</td>


												<td class='right aligned'>".$this->common_model->read_number_million($monthwise_BIG_dia_row->LABEL_BIG_DIA)."</td>
												<td class='right aligned'>".$this->common_model->read_number_million($monthwise_BIG_dia_row->LABEL_BIG_DIA_VALUE)."</td>
												<td class='right aligned'>".$this->common_model->read_number_million($monthwise_BIG_dia_row->LABEL_BIG_DIA_CONTRIBUTION_VALUE)."</td>
												<td class='right aligned'>&#8377;".round($LABEL_BIG_DIA_AVG_PRICE,2)."</td>
												<td class='right aligned'>&#8377;".round($LABEL_BIG_DIA_CONTRIBUTION_PER_TUBE,2)."</td>


												<td class='active right aligned'>".$this->common_model->read_number_million($TOTAL_ROW_COEX_BIG_DIA)."</td>
												<td class='active right aligned'>".$this->common_model->read_number_million($TOTAL_ROW_COEX_BIG_DIA_VALUE)."</td>
												<td class='active right aligned'>".$this->common_model->read_number_million($TOTAL_ROW_COEX_BIG_DIA_CONTRIBUTION_VALUE)."</td>
												<td class='active right aligned'>&#8377;".round($TOTAL_ROW_COEX_BIG_DIA_AVG_PRICE,2)."</td>
												<td class='active right aligned'>&#8377;".round($TOTAL_ROW_COEX_BIG_DIA_CONTRIBUTION_PER_TUBE,2)."</td>

												<td class='negative right aligned'>".$this->common_model->read_number_million($monthwise_BIG_dia_row->SPRING_BIG_DIA)."</td>
												<td class='negative right aligned'>".$this->common_model->read_number_million($monthwise_BIG_dia_row->SPRING_BIG_DIA_VALUE)."</td>
												<td class='negative right aligned'>".$this->common_model->read_number_million($monthwise_BIG_dia_row->SPRING_BIG_DIA_CONTRIBUTION_VALUE)."</td>
												<td class='negative right aligned'>&#8377;".round($SPRING_BIG_DIA_AVG_PRICE,2)."</td>
												<td class='negative right aligned'>&#8377;".round($SPRING_BIG_DIA_CONTRIBUTION_PER_TUBE,2)."</td>

												<td class='active right aligned'>".$this->common_model->read_number_million($GRAND_TOTAL_ROW_COEX_BIG_DIA)."</td>
												<td class='active right aligned'>".$this->common_model->read_number_million($GRAND_TOTAL_ROW_COEX_BIG_DIA_VALUE)."</td>
												<td class='active right aligned'>".$this->common_model->read_number_million($GRAND_TOTAL_ROW_COEX_BIG_DIA_CONTRIBUTION_VALUE)."</td>
												<td class='active right aligned'>&#8377;".round($GRAND_TOTAL_ROW_COEX_BIG_DIA_AVG_PRICE,2)."</td>
												<td class='active right aligned'>&#8377;".round($GRAND_TOTAL_ROW_COEX_BIG_DIA_CONTRIBUTION_PER_TUBE,2)."</td>

											 </tr>";
											}
										}
										
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
								<th colspan='3'>GRAND TOTAL</th>
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

								<th class='right aligned'>".$this->common_model->read_number_million($total_label_quantity)."</th>
								<th class='right aligned'>".$this->common_model->read_number_million($total_label_value)."</th>
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