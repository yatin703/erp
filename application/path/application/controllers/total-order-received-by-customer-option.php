<?php
					setlocale(LC_MONETARY, 'en_IN');
					if($total_order_received_by_customer==FALSE){

					}else{
						echo '<table class="ui sortable selectable celled table" style="font-size:10px;">
					        	<thead>
								   <tr>
								    	<th colspan="29"><a class="ui orange label">ORDER</a>'.($from_date!='' && $to_date!='' ? 
								    		' <a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date($from_date,$this->session->userdata['logged_in']['company_id']).'  TO '.$this->common_model->view_date($to_date,$this->session->userdata['logged_in']['company_id']).'</a><br/><br/>' : '').'
								    	
								    	</th>
								  </tr>
								  <tr>
					        			<th colspan="2"></th>
					        			<th colspan="12" class="center aligned">APPROVED</th>
					        			<th colspan="3" class="center aligned">GRAND TOTAL</th>
					        	  </tr>
								  <tr>
					        			<th colspan="2"></th>
					        			<th colspan="9" class="center aligned">COEX TUBE</th>
					        			<th colspan="3" class="center aligned">SPRING TUBE</th>
					        			<th colspan="3" class="center aligned">TOTAL</th>
					        	  </tr>
								  <tr>
					        			<th colspan="2"></th>
					        			<th colspan="3" class="center aligned">SCREEN+FLEXO</th>
					        			<th colspan="3" class="center aligned">OFFSET</th>
					        			<th colspan="3" class="center aligned">LABEL</th>
					        			<th colspan="3" class="center aligned">DIGITAL</th>
					        			<th colspan="3" class="center aligned"></th>
					        		</tr>
					        		<tr>
					        			<th>SR NO</th>
					        			<th>YEAR- MONTH</th>
					        			<th class="active right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG PRICE</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG PRICE</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG PRICE</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG PRICE</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG PRICE</th>
					        		</tr>
					        	</thead><tbody>';
					 $total_screen_flexo_quantity=0;
					 $total_screen_flexo_value=0;
					 $total_screen_flexo_avg=0;
					 $total_offset_quantity=0;
					 $total_offset_value=0;
					 $total_offset_avg=0;
					 $total_label_quantity=0;
					 $total_label_value=0;
					 $total_label_avg=0;

					 $total_digital_quantity=0;
					 $total_digital_value=0;
					 $total_digital_avg=0;

					 $total_approved_order_quantity=0;
					 $total_approved_order_value=0;
					 $total_approved_order_avg=0;

					 $i=1;
					foreach($total_order_received_by_customer as $row){

						$APPROVED_SCREEN_FLEXO_AVG=0;
						$APPROVED_SCREEN_FLEXO_AVG=($row->APPROVED_SCREEN_FLEXO_VALUE<>0 ? ($row->APPROVED_SCREEN_FLEXO_VALUE/$row->APPROVED_SCREEN_FLEXO_QTY) : 0);

						$APPROVED_OFFSET_AVG=0;
						$APPROVED_OFFSET_AVG=($row->APPROVED_OFFSET_VALUE<>0 ? ($row->APPROVED_OFFSET_VALUE/$row->APPROVED_OFFSET_QTY) : 0);

						$APPROVED_LABEL_AVG=0;
						$APPROVED_LABEL_AVG=($row->APPROVED_LABEL_VALUE<>0 ? ($row->APPROVED_LABEL_VALUE/$row->APPROVED_LABEL_QTY) : 0);

						$APPROVED_DIGITAL_AVG=0;
						$APPROVED_DIGITAL_AVG=($row->APPROVED_DIGITAL_VALUE<>0 ? ($row->APPROVED_DIGITAL_VALUE/$row->APPROVED_DIGITAL_QTY) : 0);

						$APPROVED_ORDER_AVG=0;
						$APPROVED_ORDER_AVG=($row->APPROVED_ORDER_VALUE<>0 ? ($row->APPROVED_ORDER_VALUE/$row->APPROVED_ORDER_QTY) : 0);

						
						echo "<tr>
								<td>$i</td>
								<td><b>".strtoupper($row->customer)."</b></td>
								<td class='negative right aligned'>".money_format('%!.0n',$row->APPROVED_SCREEN_FLEXO_QTY)."</td>
								<td class='negative right aligned'>".money_format('%.0n',$row->APPROVED_SCREEN_FLEXO_VALUE)."</td>
								<td class='negative right aligned'>&#8377;".round($APPROVED_SCREEN_FLEXO_AVG,2)."</td>
								<td class='positive right aligned'>".money_format('%!.0n',$row->APPROVED_OFFSET_QTY)."</td>
								<td class='positive right aligned'>".money_format('%.0n',$row->APPROVED_OFFSET_VALUE)."</td>
								<td class='positive right aligned'>&#8377;".round($APPROVED_OFFSET_AVG,2)."</td>
								<td class='right aligned'>".money_format('%!.0n',$row->APPROVED_LABEL_QTY)."</td>
								<td class='right aligned'>".money_format('%.0n',$row->APPROVED_LABEL_VALUE)."</td>
								<td class='right aligned'>&#8377;".round($APPROVED_LABEL_AVG,2)."</td>

								<td class='negative right aligned'>".money_format('%!.0n',$row->APPROVED_DIGITAL_QTY)."</td>
								<td class='negative right aligned'>".money_format('%.0n',$row->APPROVED_DIGITAL_VALUE)."</td>
								<td class='negative right aligned'>&#8377;".round($APPROVED_DIGITAL_AVG,2)."</td>

								<td class='right aligned'>".money_format('%!.0n',$row->APPROVED_ORDER_QTY)."</td>
								<td class='right aligned'>".money_format('%.0n',$row->APPROVED_ORDER_VALUE)."</td>
								<td class='right aligned'>&#8377;".round($APPROVED_ORDER_AVG,2)."</td>

								
					        </tr>";
					        
					       $total_screen_flexo_quantity+=$row->APPROVED_SCREEN_FLEXO_QTY;
					       $total_screen_flexo_value+=$row->APPROVED_SCREEN_FLEXO_VALUE;
					       $total_offset_quantity+=$row->APPROVED_OFFSET_QTY;
					       $total_offset_value+=$row->APPROVED_OFFSET_VALUE;
					       $total_label_quantity+=$row->APPROVED_LABEL_QTY;
					       $total_label_value+=$row->APPROVED_LABEL_VALUE;
					       $total_digital_quantity+=$row->APPROVED_DIGITAL_QTY;
					       $total_digital_value+=$row->APPROVED_DIGITAL_VALUE;

					       $total_approved_order_quantity+=$row->APPROVED_ORDER_QTY;
					       $total_approved_order_value+=$row->APPROVED_ORDER_VALUE;

						   $i++;
					    }
					    
					    $total_screen_flexo_avg=($total_screen_flexo_value!=0 ? $total_screen_flexo_value/$total_screen_flexo_quantity : '0');
					    $total_offset_avg=($total_offset_value!=0 ? $total_offset_value/$total_offset_quantity : '0');
					    $total_label_avg=($total_label_value!=0 ? $total_label_value/$total_label_quantity : '0');
					    $total_digital_avg=($total_digital_value!=0 ? $total_digital_value/$total_digital_quantity : '0');
					   
					    $total_approved_order_avg=($total_approved_order_value!=0 ? ($total_approved_order_value/$total_approved_order_quantity) : 0);
					    
						
					    echo "<thead>
							    <tr>
							    	<th colspan='2'>TOTAL</th>
							    	<th class='negative right aligned'>".money_format('%!.0n',$total_screen_flexo_quantity)."</th>
							    	<th class='negative right aligned'>".money_format('%.0n',$total_screen_flexo_value)."</th>
							    	<th class='negative right aligned'>&#8377;".round($total_screen_flexo_avg,2)."</th>
							    	<th class='positive right aligned'>".money_format('%!.0n',$total_offset_quantity)."</th>
							    	<th class='positive right aligned'>".money_format('%.0n',$total_offset_value)."</th>
							    	<th class='positive right aligned'>&#8377;".round($total_offset_avg,2)."</th>
							    	<th class='positive right aligned'>".money_format('%!.0n',$total_label_quantity)."</th>
							    	<th class='positive right aligned'>".money_format('%.0n',$total_label_value)."</th>
							    	<th class='positive right aligned'>&#8377;".round($total_label_avg,2)."</th>

							    	<th class='positive right aligned'>".money_format('%!.0n',$total_digital_quantity)."</th>
							    	<th class='positive right aligned'>".money_format('%.0n',$total_digital_value)."</th>
							    	<th class='positive right aligned'>&#8377;".round($total_digital_avg,2)."</th>

							    	<th class='warning right aligned'>".money_format('%!.0n',$total_approved_order_quantity)."</th>
							    	<th class='warning right aligned'>".money_format('%.0n',$total_approved_order_value)."</th>
							    	<th class='warning right aligned'>&#8377;".round($total_approved_order_avg,2)."</th>

							  	</tr>
							  </thead>
							 </tbody></table>";

					}
				?>
				