<?php
					setlocale(LC_MONETARY, 'en_IN');
					if($pending_sales_order==FALSE){

					}else{
						echo '<table class="ui sortable selectable celled table" style="font-size:12px;">
					        	<thead>
								   <tr>
								    	<th colspan="20"><a class="ui orange label">'.$customer_name.' PENDING ORDER</a>'.($from_date!='' && $to_date!='' ? 
								    		' <a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date($from_date,$this->session->userdata['logged_in']['company_id']).'  TO '.$this->common_model->view_date($to_date,$this->session->userdata['logged_in']['company_id']).'</a><br/><br/>' : '').'</th>
								  </tr>
								  <tr>
					        			<th colspan="2"></th>
					        			<th colspan="3" class="center aligned">SCREEN+FLEXO</th>
					        			<th colspan="3" class="center aligned">OFFSET</th>
					        			<th colspan="3" class="center aligned">LABEL</th>

					        			<th colspan="3" class="center aligned">COEX TOTAL</th>

					        			<th colspan="3" class="center aligned">DIGITAL</th>
					        			<th colspan="3"  class="center aligned">TOTAL</th>
					        		</tr>
					        		<tr>
					        			<th>SR NO</th>
					        			<th>YEAR-MONTH</th>
					        			<th class="center aligned">QUANTITY</th>
					        			<th class="center aligned">VALUE</th>
					        			<th class="center aligned">AVG</th>
					        			<th class="center aligned">QUANTITY</th>
					        			<th class="center aligned">VALUE</th>
					        			<th class="center aligned">AVG</th>
					        			<th class="center aligned">QUANTITY</th>
					        			<th class="center aligned">VALUE</th>
					        			<th class="center aligned">AVG</th>

					        			<th class="center aligned">QUANTITY</th>
					        			<th class="center aligned">VALUE</th>
					        			<th class="center aligned">AVG</th>

					        			<th class="center aligned">QUANTITY</th>
					        			<th class="center aligned">VALUE</th>
					        			<th class="center aligned">AVG</th>
					        			<th class="center aligned">QUANTITY</th>
					        			<th class="center aligned">VALUE</th>
					        			<th class="center aligned">AVG</th>
					        			
					        		</tr>
					        	</thead>';
					
					 $count=1;
					 $last_count=0;
					 $total_dia_pending_quantity=0;
					 $total_screen_flexo_pending_quantity=0;
					 $total_offset_pending_quantity=0;
					 $total_label_pending_quantity=0;
					 $total_coex_pending_quantity=0;
					 $total_digital_pending_quantity=0;
					 $total_total_pending_quantity=0;

					 $total_screen_flexo_pending_value=0;
					 $total_offset_pending_value=0;
					 $total_label_pending_value=0;
					 $total_coex_pending_value=0;
					 $total_digital_pending_value=0;
					 $total_total_pending_value=0;

					foreach($pending_sales_order as $coex_order_row){
						$total_dia_pending_quantity=0;
						$total_dia_pending_quantity=$coex_order_row->SCREEN_FLEXO_PENDING_QTY+$coex_order_row->OFFSET_PENDING_QTY+$coex_order_row->LABEL_PENDING_QTY+$coex_order_row->DIGITAL_PENDING_QTY;
						$total_dia_coex_pending_quantity=0;
						$total_dia_coex_pending_quantity=$coex_order_row->SCREEN_FLEXO_PENDING_QTY+$coex_order_row->OFFSET_PENDING_QTY+$coex_order_row->LABEL_PENDING_QTY;

						$total_dia_pending_quantity_value=0;
						$total_dia_pending_quantity_value=$coex_order_row->SCREEN_FLEXO_PENDING_VALUE+$coex_order_row->OFFSET_PENDING_VALUE+$coex_order_row->LABEL_PENDING_VALUE+$coex_order_row->DIGITAL_PENDING_VALUE;

						$total_dia_coex_pending_quantity_value=0;
						$total_dia_coex_pending_quantity_value=$coex_order_row->SCREEN_FLEXO_PENDING_VALUE+$coex_order_row->OFFSET_PENDING_VALUE+$coex_order_row->LABEL_PENDING_VALUE;

						$total_dia_pending_quantity_avg_price=0;
						$total_dia_pending_quantity_avg_price=($total_dia_pending_quantity_value!=0 ? ($total_dia_pending_quantity_value/$total_dia_pending_quantity) : 0); 

						$total_dia_coex_pending_quantity_avg_price=0;
						$total_dia_coex_pending_quantity_avg_price=($total_dia_coex_pending_quantity_value!=0 ? ($total_dia_coex_pending_quantity_value/$total_dia_coex_pending_quantity) : 0);

						if($count==1){
							//$from_date=strtoupper($coex_order->sales_month)." ".$coex_order->sales_year;
						}


						$pending_screen_flexo_avg_price=0;
						$pending_screen_flexo_avg_price=($coex_order_row->SCREEN_FLEXO_PENDING_VALUE!=0 ? ($coex_order_row->SCREEN_FLEXO_PENDING_VALUE/$coex_order_row->SCREEN_FLEXO_PENDING_QTY) : 0);

						$pending_offset_avg_price=0;
						$pending_offset_avg_price=($coex_order_row->OFFSET_PENDING_VALUE!=0 ? ($coex_order_row->OFFSET_PENDING_VALUE/$coex_order_row->OFFSET_PENDING_QTY) : 0);

						$pending_label_avg_price=0;
						$pending_label_avg_price=($coex_order_row->LABEL_PENDING_VALUE!=0 ? ($coex_order_row->LABEL_PENDING_VALUE/$coex_order_row->LABEL_PENDING_QTY) : 0);

						$pending_digital_avg_price=0;
						$pending_digital_avg_price=($coex_order_row->DIGITAL_PENDING_VALUE!=0 ? ($coex_order_row->DIGITAL_PENDING_VALUE/$coex_order_row->DIGITAL_PENDING_QTY) : 0);



						echo "<tr>
								<td><b>$count</b></td>
								<td><b>$coex_order_row->order_year -".strtoupper($coex_order_row->order_month)."</b></td>
								<td class='negative right aligned'>".money_format('%!.0n',$coex_order_row->SCREEN_FLEXO_PENDING_QTY)."</td>
								<td class='negative right aligned'>".money_format('%.0n',$coex_order_row->SCREEN_FLEXO_PENDING_VALUE)."</td>
								<td class='negative right aligned'>&#8377;".round($pending_screen_flexo_avg_price,2)."</td>
								<td class='right aligned'>".money_format('%!.0n',$coex_order_row->OFFSET_PENDING_QTY)."</td>
								<td class='right aligned'>".money_format('%.0n',$coex_order_row->OFFSET_PENDING_VALUE)."</td>
								<td class='right aligned'>&#8377;".round($pending_offset_avg_price,2)."</td>
								<td class='positive right aligned'>".money_format('%!.0n',$coex_order_row->LABEL_PENDING_QTY)."</td>
								<td class='positive right aligned'>".money_format('%.0n',$coex_order_row->LABEL_PENDING_VALUE)."</td>
								<td class='positive right aligned'>&#8377;".round($pending_label_avg_price,2)."</td>

								<td class='right aligned'>".money_format('%!.0n',$total_dia_coex_pending_quantity)."</td>
								<td class='right aligned'>".money_format('%.0n',$total_dia_coex_pending_quantity_value)."</td>
								<td class='right aligned'>&#8377;".round($total_dia_coex_pending_quantity_avg_price,2)."</td>
								
								<td class='warning right aligned'>".money_format('%!.0n',$coex_order_row->DIGITAL_PENDING_QTY)."</td>
								<td class='warning right aligned'>".money_format('%.0n',$coex_order_row->DIGITAL_PENDING_VALUE)."</td>
								<td class='warning right aligned'>&#8377;".round($pending_digital_avg_price,2)."</td>
								<td class='right aligned'>".money_format('%!.0n',$total_dia_pending_quantity)."</td>
								<td class='right aligned'>".money_format('%.0n',$total_dia_pending_quantity_value)."</td>
								<td class='right aligned'>&#8377;".round($total_dia_pending_quantity_avg_price,2)."</td>
								
					        </tr>";

					       $total_screen_flexo_pending_quantity+=$coex_order_row->SCREEN_FLEXO_PENDING_QTY;
					       $total_offset_pending_quantity+=$coex_order_row->OFFSET_PENDING_QTY;
					       $total_label_pending_quantity+=$coex_order_row->LABEL_PENDING_QTY;
					       $total_coex_pending_quantity+=$total_dia_coex_pending_quantity;
					       $total_digital_pending_quantity+=$coex_order_row->DIGITAL_PENDING_QTY;

					       	$total_screen_flexo_pending_value+=$coex_order_row->SCREEN_FLEXO_PENDING_VALUE;
					 		$total_offset_pending_value+=$coex_order_row->OFFSET_PENDING_VALUE;
					 		$total_label_pending_value+=$coex_order_row->LABEL_PENDING_VALUE;
					 		$total_coex_pending_value+=$total_dia_coex_pending_quantity_value;
					 		$total_digital_pending_value+=$coex_order_row->DIGITAL_PENDING_VALUE;

					 		$total_screen_flexo_pending_avg_price=0;
							$total_screen_flexo_pending_avg_price=($total_screen_flexo_pending_value!=0 ? ($total_screen_flexo_pending_value/$total_screen_flexo_pending_quantity) : 0);

							$total_offset_pending_avg_price=0;
							$total_offset_pending_avg_price=($total_offset_pending_value!=0 ? ($total_offset_pending_value/$total_offset_pending_quantity) : 0);

							$total_label_pending_avg_price=0;
							$total_label_pending_avg_price=($total_label_pending_value!=0 ? ($total_label_pending_value/$total_label_pending_quantity) : 0);

							$total_coex_pending_avg_price=0;
							$total_coex_pending_avg_price=($total_coex_pending_value!=0 ? ($total_coex_pending_value/$total_coex_pending_quantity) : 0);

							$total_digital_pending_avg_price=0;
							$total_digital_pending_avg_price=($total_digital_pending_value!=0 ? ($total_digital_pending_value/$total_digital_pending_quantity) : 0);


					       $total_total_pending_quantity=$total_screen_flexo_pending_quantity+$total_offset_pending_quantity+$total_label_pending_quantity+$total_digital_pending_quantity;

					       $total_total_pending_value=$total_screen_flexo_pending_value+$total_offset_pending_value+$total_label_pending_value+$total_digital_pending_value;

					       $total_total_pending_avg_price=0;
					       $total_total_pending_avg_price=($total_total_pending_value!=0 ? ($total_total_pending_value/$total_total_pending_quantity) : 0);


					       $count++;
					       if($last_count==0){
							//$to_date=strtoupper($row_coex->sales_month)." ".$row_coex->sales_year;
							}
					    }

					    echo "<thead>
							    <tr>
							    	<th colspan='2'>TOTAL</th>
							    	<th class='right aligned'>".money_format('%!.0n',$total_screen_flexo_pending_quantity)."</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_screen_flexo_pending_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_screen_flexo_pending_avg_price,2)."</th>
							    	<th class='right aligned'>".money_format('%!.0n',$total_offset_pending_quantity)."</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_offset_pending_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_offset_pending_avg_price,2)."</th>
							    	<th class='right aligned'>".money_format('%!.0n',$total_label_pending_quantity)."</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_label_pending_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_label_pending_avg_price,2)."</th>
							    	<th class='right aligned'>".money_format('%!.0n',$total_coex_pending_quantity)."</th>
							    	<th class='right aligned'>".money_format('%!.0n',$total_coex_pending_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_coex_pending_avg_price,2)."</th>
							    						    	
							    	<th class='right aligned'>".money_format('%!.0n',$total_digital_pending_quantity)."</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_digital_pending_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_digital_pending_avg_price,2)."</th>
							    	<th class='right aligned'>".money_format('%!.0n',$total_total_pending_quantity)."</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_total_pending_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_total_pending_avg_price,2)."</th>

							  	</tr>
							  </thead>";

						echo '</table>';

					}
				?>