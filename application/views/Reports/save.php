<?php
					setlocale(LC_MONETARY, 'en_IN');
					if($top_customer_coex==FALSE){

					}else{
						echo '<table class="ui sortable selectable celled table" style="font-size:8px;">
					        	<thead>
								   <tr>
								    	<th colspan="19"><a class="ui orange label">SALES </a>';
								    	if($account_periods_master==FALSE){
								    	}else{
								    		foreach ($account_periods_master as $account_periods_master_row ){
								    			echo '<a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date($account_periods_master_row->fin_year_start,$this->session->userdata['logged_in']['company_id']).' TO '.$this->common_model->view_date(date('Y-m-d'),$this->session->userdata['logged_in']['company_id']).'</a><br/><br/>';
								    		}
								    	}
								    	echo '</th>
								  </tr>
								  <tr>
					        			<th></th>
					        			<th></th>
					        			<th colspan="3" class="center aligned">SCREEN+FLEXO</th>
					        			<th colspan="3" class="center aligned">OFFSET</th>
					        			<th colspan="3" class="center aligned">LABEL</th>
					        			<th colspan="3" class="center aligned">DIGITAL</th>
					        			<th colspan="5" class="center aligned">TOTAL</th>
					        		</tr>
								  <tr>
					        			<th>SR NO</th>
					        			<th>CUSTOMER</th>
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
					        			<th class="right aligned">QUANTITY %</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">VALUE %</th>
					        			<th class="right aligned">AVG PRICE</th>
					        		</tr>
					        	</thead>';
					 $count=1;
					 $last_count=0;
					 
					 $total_screen_flexo_coex_quantity=0;
					 $total_screen_flexo_coex_value=0;
					 $total_screen_flexo_coex_avg_price=0;

					 $total_offset_coex_quantity=0;
					 $total_offset_coex_value=0;
					 $total_offset_coex_avg_price=0;

					 $total_label_coex_quantity=0;
					 $total_label_coex_value=0;
					 $total_label_coex_avg_price=0;


					 $total_digital_spring_quantity=0;
					 $total_digital_spring_value=0;
					 $total_digital_spring_avg_price=0;

					 $total_sales_coex_quantity=0;
					 $total_sales_coex_value=0;
					 $total_sales_coex_avg_price=0;

					 $total_sales_coex_quantity_for_per=0;
					 $total_sales_coex_value_for_per=0;


					 $total_ten_screen_flexo_coex_quantity=0;
					 $total_ten_screen_flexo_coex_value=0;

					 $total_ten_offset_coex_quantity=0;
					 $total_ten_offset_coex_value=0;

					 $total_ten_label_coex_quantity=0;
					 $total_ten_label_coex_value=0;

					 $total_ten_digital_spring_quantity=0;
					 $total_ten_digital_spring_value=0;

					 $total_ten_sales_coex_quantity=0;
					 $total_ten_sales_coex_value=0;

					 $total_other_screen_flexo_coex_quantity=0;
					 $total_other_screen_flexo_coex_value=0;

					 $total_other_offset_coex_quantity=0;
					 $total_other_offset_coex_value=0;

					 $total_other_label_coex_quantity=0;
					 $total_other_label_coex_value=0;

					 $total_other_digital_spring_quantity=0;
					 $total_other_digital_spring_value=0;

					 $total_other_sales_coex_quantity=0;
					 $total_other_sales_coex_value=0;


					 $i=0;
					foreach($top_customer_coex as $row_coex){
						$total_sales_coex_quantity_for_per+=$row_coex->sale_quantity;
						$total_sales_coex_value_for_per+=$row_coex->value;
						$i++;
					}
						
					foreach($top_customer_coex as $row_coex){
						$avg_coex_rate=($row_coex->value/$row_coex->sale_quantity);
						$screen_flexo_avg_price=0;
						$screen_flexo_avg_price=($row_coex->SCREEN_FLEXO_VALUE!=0 ? $row_coex->SCREEN_FLEXO_VALUE/$row_coex->SCREEN_FLEXO : 0);
						$offset_avg_price=0;
						$offset_avg_price=($row_coex->OFFSET_VALUE!=0 ? $row_coex->OFFSET_VALUE/$row_coex->OFFSET : 0);
						$label_avg_price=0;
						$label_avg_price=($row_coex->LABEL_VALUE!=0 ? $row_coex->LABEL_VALUE/$row_coex->LABEL : 0);
						$digital_avg_price=0;
						$digital_avg_price=($row_coex->DIGITAL_VALUE!=0 ? $row_coex->DIGITAL_VALUE/$row_coex->DIGITAL : 0);

						echo "<tr "; echo $a=($count>10 ? "class='cat1' style='display:none'" : "NO");  echo ">
								<td>$count</td>
								<td>$row_coex->customer</td>
								<td class='negative right aligned'>".money_format('%!.0n',$row_coex->SCREEN_FLEXO)."</td>
								<td class='negative right aligned'>".money_format('%.0n',$row_coex->SCREEN_FLEXO_VALUE)."</td>
								<td class='negative right aligned'>&#8377;".round($screen_flexo_avg_price,2)."</td>
								<td class='positive right aligned'>".money_format('%!.0n',$row_coex->OFFSET)."</td>
								<td class='positive right aligned'>".money_format('%.0n',$row_coex->OFFSET_VALUE)."</td>
								<td class='positive right aligned'>&#8377;".round($offset_avg_price,2)."</td>
								<td class='right aligned'>".money_format('%!.0n',$row_coex->LABEL)."</td>
								<td class='right aligned'>".money_format('%.0n',$row_coex->LABEL_VALUE)."</td>
								<td class='right aligned'>&#8377;".round($label_avg_price,2)."</td>
								<td class='negative right aligned'>".money_format('%!.0n',$row_coex->DIGITAL)."</td>
								<td class='negative right aligned'>".money_format('%.0n',$row_coex->DIGITAL_VALUE)."</td>
								<td class='negative right aligned'>&#8377;".round($digital_avg_price,2)."</td>
								<td class='warning right aligned'>".money_format('%!.0n',$row_coex->sale_quantity)."</td>
								<td class='warning right aligned'>".round((($row_coex->sale_quantity/$total_sales_coex_quantity_for_per)*100))."%</td>
								<td class='warning right aligned'>".money_format('%.0n',$row_coex->value)."</td>
								<td class='warning right aligned'>".round((($row_coex->value/$total_sales_coex_value_for_per)*100))."%</td>
								<td class='warning right aligned'>&#8377;".round($avg_coex_rate,2)."</td>

								
					        </tr>";

					        

					        $total_ten_screen_flexo_coex_quantity+=$row_coex->SCREEN_FLEXO;
							$total_ten_screen_flexo_coex_value+=$row_coex->SCREEN_FLEXO_VALUE;

							$total_ten_offset_coex_quantity+=$row_coex->OFFSET;
							$total_ten_offset_coex_value+=$row_coex->OFFSET_VALUE;

							$total_ten_label_coex_quantity+=$row_coex->LABEL;
							$total_ten_label_coex_value+=$row_coex->LABEL_VALUE;

							$total_ten_digital_spring_quantity+=$row_coex->DIGITAL;
							$total_ten_digital_spring_value+=$row_coex->DIGITAL_VALUE;

							$total_ten_sales_coex_quantity+=$row_coex->sale_quantity;
							$total_ten_sales_coex_value+=$row_coex->value;

					        if($count==10){

					        	$total_ten_screen_flexo_coex_avg_price=0;
							    $total_ten_screen_flexo_coex_avg_price=($total_ten_screen_flexo_coex_value!=0 ? ($total_ten_screen_flexo_coex_value/$total_ten_screen_flexo_coex_quantity) : 0);

							    $total_ten_offset_coex_avg_price=0;
							    $total_ten_offset_coex_avg_price=($total_ten_offset_coex_value!=0 ? ($total_ten_offset_coex_value/$total_ten_offset_coex_quantity) : 0);

							    $total_ten_label_coex_avg_price=0;
							    $total_ten_label_coex_avg_price=($total_ten_label_coex_value!=0 ? ($total_ten_label_coex_value/$total_ten_label_coex_quantity) : 0);

							    $total_ten_digital_spring_avg_price=0;
							    $total_ten_digital_spring_avg_price=($total_ten_digital_spring_value!=0 ? ($total_ten_digital_spring_value/$total_ten_digital_spring_quantity) : 0);

							    $total_ten_sales_coex_avg_price=0;
							    $total_ten_sales_coex_avg_price=($total_ten_sales_coex_value!=0 ? ($total_ten_sales_coex_value/$total_ten_sales_coex_quantity) : 0);

					        	echo "<thead><tr>
										<th colspan='2'>TOP 10 TOTAL</th>
										<th class='negative right aligned'>".money_format('%!.0n',$total_ten_screen_flexo_coex_quantity)."</th>
										<th class='negative right aligned'>".money_format('%.0n',$total_ten_screen_flexo_coex_value)."</th>
										<th class='negative right aligned'>&#8377;".round($total_ten_screen_flexo_coex_avg_price,2)."</th>
										<th class='positive right aligned'>".money_format('%!.0n',$total_ten_offset_coex_quantity)."</th>
										<th class='positive right aligned'>".money_format('%.0n',$total_ten_offset_coex_value)."</th>
										<th class='positive right aligned'>&#8377;".round($total_ten_offset_coex_avg_price,2)."</th>
										<th class='right aligned'>".money_format('%!.0n',$total_ten_label_coex_quantity)."</th>
										<th class='right aligned'>".money_format('%.0n',$total_ten_label_coex_value)."</th>
										<th class='right aligned'>&#8377;".round($total_ten_label_coex_avg_price,2)."</th>

										<th class='negative right aligned'>".money_format('%!.0n',$total_ten_digital_spring_quantity)."</th>
										<th class='negative right aligned'>".money_format('%.0n',$total_ten_digital_spring_value)."</th>
										<th class='negative right aligned'>&#8377;".round($total_ten_digital_spring_avg_price,2)."</th>

										<th class='warning right aligned'>".money_format('%!.0n',$total_ten_sales_coex_quantity)."</th>
										<th class='warning right aligned'>".round((($total_ten_sales_coex_quantity/$total_sales_coex_quantity_for_per)*100))."%</th>

										<th class='warning right aligned'>".money_format('%.0n',$total_ten_sales_coex_value)."</th>
										<th class='warning right aligned'>".round((($total_ten_sales_coex_value/$total_sales_coex_value_for_per)*100))."%</th>
										<th class='warning right aligned'>&#8377;".round($total_ten_sales_coex_avg_price,2)."</th>
							        </tr></thead>";

					        }
					       $total_screen_flexo_coex_quantity+=$row_coex->SCREEN_FLEXO;
					       $total_screen_flexo_coex_value+=$row_coex->SCREEN_FLEXO_VALUE;

					       $total_offset_coex_quantity+=$row_coex->OFFSET;
					       $total_offset_coex_value+=$row_coex->OFFSET_VALUE;


					       $total_label_coex_quantity+=$row_coex->LABEL;
					       $total_label_coex_value+=$row_coex->LABEL_VALUE;

					       $total_digital_spring_quantity+=$row_coex->DIGITAL;
					       $total_digital_spring_value+=$row_coex->DIGITAL_VALUE;

					       $total_sales_coex_quantity+=$row_coex->sale_quantity;
					       $total_sales_coex_value+=$row_coex->value;

					       if($count>10){
					       	 $total_other_screen_flexo_coex_quantity+=$row_coex->SCREEN_FLEXO;
					       	 $total_other_screen_flexo_coex_value+=$row_coex->SCREEN_FLEXO_VALUE;

							 $total_other_offset_coex_quantity+=$row_coex->OFFSET;
							 $total_other_offset_coex_value+=$row_coex->OFFSET_VALUE;

							 $total_other_label_coex_quantity+=$row_coex->LABEL;
							 $total_other_label_coex_value+=$row_coex->LABEL_VALUE;

							 $total_other_digital_spring_quantity+=$row_coex->DIGITAL;
							 $total_other_digital_spring_value+=$row_coex->DIGITAL_VALUE;

							 $total_other_sales_coex_quantity+=$row_coex->sale_quantity;
							 $total_other_sales_coex_value+=$row_coex->value;
					       }

					       	$count++;
						       
					    }

					    	$total_other_screen_flexo_coex_avg_price=0;
					       	$total_other_screen_flexo_coex_avg_price=($total_other_screen_flexo_coex_value!=0 ? ($total_other_screen_flexo_coex_value/$total_other_screen_flexo_coex_quantity) : 0);

					       	$total_other_offset_coex_avg_price=0;
					       	$total_other_offset_coex_avg_price=($total_other_offset_coex_value!=0 ? ($total_other_offset_coex_value/$total_other_offset_coex_quantity) : 0);

					       	$total_other_label_coex_avg_price=0;
					       	$total_other_label_coex_avg_price=($total_other_label_coex_value!=0 ? ($total_other_label_coex_value/$total_other_label_coex_quantity) : 0);

					       	$total_other_digital_spring_avg_price=0;
					       	$total_other_digital_spring_avg_price=($total_other_digital_spring_value!=0 ? ($total_other_digital_spring_value/$total_other_digital_spring_quantity) : 0);

					       	$total_other_sales_coex_avg_price=0;
					       	$total_other_sales_coex_avg_price=($total_other_sales_coex_value!=0 ? ($total_other_sales_coex_value/$total_other_sales_coex_quantity) : 0);
					    
					    	

					    echo "<thead>
							    <tr>
							    	<th colspan='2'><a href='#'' class='toggler' data-prod-cat='1'>OTHER TOTAL</a></th>
							    	<th class='right aligned'>".money_format('%!.0n',$total_other_screen_flexo_coex_quantity)."</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_other_screen_flexo_coex_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_other_screen_flexo_coex_avg_price,2)."</th>

							    	<th class='right aligned'>".money_format('%!.0n',$total_other_offset_coex_quantity)."</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_other_offset_coex_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_other_offset_coex_avg_price,2)."</th>


							    	<th class='right aligned'>".money_format('%!.0n',$total_other_label_coex_quantity)."</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_other_label_coex_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_other_label_coex_avg_price,2)."</th>

							    	<th class='negative right aligned'>".money_format('%!.0n',$total_other_digital_spring_quantity)."</th>
									<th class='negative right aligned'>".money_format('%.0n',$total_other_digital_spring_value)."</th>
									<th class='negative right aligned'>&#8377;".round($total_other_digital_spring_avg_price,2)."</th>

							    	<th class='right aligned'>".money_format('%!.0n',$total_other_sales_coex_quantity)."</th>
							    	<th class='right aligned'>".round((($total_other_sales_coex_quantity/$total_sales_coex_quantity_for_per)*100))."%</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_other_sales_coex_value)."</th>
							    	<th class='right aligned'>".round((($total_other_sales_coex_value/$total_sales_coex_value_for_per)*100))."%</th>
							    	<th class='right aligned'>&#8377;".round($total_other_sales_coex_avg_price,2)."</th>

							  	</tr>
							  </thead>";


							$total_screen_flexo_coex_avg_price=0;
					       	$total_screen_flexo_coex_avg_price=($total_screen_flexo_coex_value!=0 ? ($total_screen_flexo_coex_value/$total_screen_flexo_coex_quantity) : 0);

					       	$total_offset_coex_avg_price=0;
					       	$total_offset_coex_avg_price=($total_offset_coex_value!=0 ? ($total_offset_coex_value/$total_offset_coex_quantity) : 0);

					       	$total_label_coex_avg_price=0;
					       	$total_label_coex_avg_price=($total_label_coex_value!=0 ? ($total_label_coex_value/$total_label_coex_quantity) : 0);

					       	$total_digital_spring_avg_price=0;
					       	$total_digital_spring_avg_price=($total_digital_spring_value!=0 ? ($total_digital_spring_value/$total_digital_spring_quantity) : 0);

					       	$total_sales_coex_avg_price=0;
					       	$total_sales_coex_avg_price=($total_sales_coex_value!=0 ? ($total_sales_coex_value/$total_sales_coex_quantity) : 0);

						 echo "<thead>
							    <tr>
							    	<th colspan='2'>TOTAL</th>
							    	<th class='right aligned'>".money_format('%!.0n',$total_screen_flexo_coex_quantity)."</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_screen_flexo_coex_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_screen_flexo_coex_avg_price,2)."</th>

							    	<th class='right aligned'>".money_format('%!.0n',$total_offset_coex_quantity)."</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_offset_coex_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_offset_coex_avg_price,2)."</th>


							    	<th class='right aligned'>".money_format('%!.0n',$total_label_coex_quantity)."</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_label_coex_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_label_coex_avg_price,2)."</th>

							    	<th class='negative right aligned'>".money_format('%!.0n',$total_digital_spring_quantity)."</th>
									<th class='negative right aligned'>".money_format('%.0n',$total_digital_spring_value)."</th>
									<th class='negative right aligned'>&#8377;".round($total_digital_spring_avg_price,2)."</th>

							    	<th class='right aligned'>".money_format('%!.0n',$total_sales_coex_quantity)."</th>
							    	<th class='right aligned'>".round((($total_sales_coex_quantity/$total_sales_coex_quantity_for_per)*100))."%</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_sales_coex_value)."</th>
							    	<th class='right aligned'>".round((($total_sales_coex_value/$total_sales_coex_value_for_per)*100))."%</th>
							    	<th class='right aligned'>&#8377;".round($total_sales_coex_avg_price,2)."</th>

							  	</tr>
							  </thead>";

						echo '</table>';

					}
				?>