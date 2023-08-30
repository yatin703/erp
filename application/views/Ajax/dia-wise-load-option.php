<?php
					setlocale(LC_MONETARY, 'en_IN');
					if($dia_wise_sales==FALSE){

					}else{
						echo '<table class="ui sortable selectable celled table" style="font-size:10px;">
					        	<thead>
								   <tr>
								    	<th colspan="28"><a class="ui orange label">COEX SALES</a>'.($from_date!='' && $to_date!='' ? 
								    		' <a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date($from_date,$this->session->userdata['logged_in']['company_id']).'  TO '.$this->common_model->view_date($to_date,$this->session->userdata['logged_in']['company_id']).'</a><br/><br/>' : '');

								    	if(!empty($sleeve_dia_data)){

								    		$arr=explode(",",$sleeve_dia_data);
								    		foreach($arr as $sld){
								    			$sld=str_replace("'","",$sld);
								    			echo '<a class="ui label">'.$sld.'</a>';
								    		}
								    		echo "<br/><br/>";
								    	}

								    	if(!empty($inv_type_data)){
								    		
								    		$arr=explode(",",$inv_type_data);
								    		foreach($arr as $inv_type_data_row){
								    			$inv_type_data_row=str_replace("'","",$inv_type_data_row);
								    			echo '<a class="ui blue label">'.$inv_type_data_row.'</a>';
								    		}
								    		echo "<br/>";
								    	} 

								    	echo '</th>
								  </tr>

								  	<tr>
					        			<th></th>
					        			<th colspan="9" class="center aligned">COEX TUBE</th>
					        			<th colspan="9" class="center aligned">SPRING TUBE</th>
					        			<th colspan="9" class="center aligned">GRAND TOTAL</th>
					        		</tr>

								  	<tr>
					        			<th></th>
					        			<th colspan="3" class="center aligned">SMALL DIA (19,22.6,25,30)</th>
					        			<th colspan="3" class="center aligned">BIG DIA (35,40,50)</th>
					        			<th colspan="3" class="center aligned">COEX TOTAL</th>

					        			<th colspan="3" class="center aligned">SMALL DIA (19,22.6,25,30)</th>
					        			<th colspan="3" class="center aligned">BIG DIA (35,40,50)</th>
					        			<th colspan="3" class="center aligned">DIGITAL TOTAL</th>

					        			<th colspan="3" class="center aligned">TOTAL SMALL DIA (19,22.6,25,30)</th>
					        			<th colspan="3" class="center aligned">TOTAL BIG DIA (35,40,50)</th>
					        			<th colspan="3" class="center aligned">TOTAL MONTH</th>
					        		</tr>


					        		<tr>
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

					        			<th class="active right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG PRICE</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG PRICE</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG PRICE</th>


					        			<th class="active right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG PRICE</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG PRICE</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG PRICE</th>
					        		</tr>
					        	</thead>';
					 $total_small_dia_coex_quantity=0;
					 $total_small_dia_coex_value=0;
					 $total_small_dia_coex_avg=0;
					 $total_big_dia_coex_quantity=0;
					 $total_big_dia_coex_value=0;
					 $total_big_dia_coex_avg=0;
					 $total_small_big_dia_coex_quantity=0;
					 $total_small_big_dia_coex_value=0;
					 $total_small_big_dia_coex_avg=0;

					 $total_small_dia_spring_quantity=0;
					 $total_small_dia_spring_value=0;
					 $total_small_dia_spring_avg=0;
					 $total_big_dia_spring_quantity=0;
					 $total_big_dia_spring_value=0;
					 $total_big_dia_spring_avg=0;
					 $total_small_big_dia_spring_quantity=0;
					 $total_small_big_dia_spring_value=0;
					 $total_small_big_dia_spring_avg=0;


					 $total_small_dia_sales_quantity=0;
					 $total_small_dia_sales_value=0;
					 $total_small_dia_sales_avg=0;
					 $total_big_dia_sales_quantity=0;
					 $total_big_dia_sales_value=0;
					 $total_big_dia_sales_avg=0;
					 $total_small_big_dia_sales_quantity=0;
					 $total_small_big_dia_sales_value=0;
					 $total_small_big_dia_sales_avg=0;


					 $count=0;
					foreach($dia_wise_sales as $row){
						$coex_small_dia_avg_price=0;
						$coex_small_dia_avg_price=($row->COEX_SMALL_DIA_VALUE!=0 ? $row->COEX_SMALL_DIA_VALUE/$row->COEX_SMALL_DIA : 0);
						$coex_big_dia_avg_price=0;
						$coex_big_dia_avg_price=($row->COEX_BIG_DIA_VALUE!=0 ? $row->COEX_BIG_DIA_VALUE/$row->COEX_BIG_DIA : 0);
						$total_coex_dia_quantity=0;
						$total_coex_dia_quantity=$row->COEX_SMALL_DIA+$row->COEX_BIG_DIA;
						$total_coex_dia_value=0;
						$total_coex_dia_value=$row->COEX_SMALL_DIA_VALUE+$row->COEX_BIG_DIA_VALUE;
						$total_coex_dia_avg_price=0;
						$total_coex_dia_avg_price=$total_coex_dia_value/$total_coex_dia_quantity;

						$spring_small_dia_avg_price=0;
						$spring_small_dia_avg_price=($row->SPRING_SMALL_DIA_VALUE!=0 ? $row->SPRING_SMALL_DIA_VALUE/$row->SPRING_SMALL_DIA : 0);
						$spring_big_dia_avg_price=0;
						$spring_big_dia_avg_price=($row->SPRING_BIG_DIA_VALUE!=0 ? $row->SPRING_BIG_DIA_VALUE/$row->SPRING_BIG_DIA : 0);
						$total_spring_dia_quantity=0;
						$total_spring_dia_quantity=$row->SPRING_SMALL_DIA+$row->SPRING_BIG_DIA;
						$total_spring_dia_value=0;
						$total_spring_dia_value=$row->SPRING_SMALL_DIA_VALUE+$row->SPRING_BIG_DIA_VALUE;
						$total_spring_dia_avg_price=0;
						$total_spring_dia_avg_price=($total_spring_dia_value!=0 ? ($total_spring_dia_value/$total_spring_dia_quantity) : 0);

						$total_sales_small_dia_quantity=0;
						$total_sales_small_dia_quantity=$row->COEX_SMALL_DIA+$row->SPRING_SMALL_DIA;
						$total_sales_small_dia_value=0;
						$total_sales_small_dia_value=$row->COEX_SMALL_DIA_VALUE+$row->SPRING_SMALL_DIA_VALUE;

						$total_sales_big_dia_quantity=0;
						$total_sales_big_dia_quantity=$row->COEX_BIG_DIA+$row->SPRING_BIG_DIA;
						$total_sales_big_dia_value=0;
						$total_sales_big_dia_value=$row->COEX_BIG_DIA_VALUE+$row->SPRING_BIG_DIA_VALUE;

						$total_sales_small_dia_avg_price=0;
						$total_sales_small_dia_avg_price=($total_sales_small_dia_value!=0 ? ($total_sales_small_dia_value/$total_sales_small_dia_quantity) : 0);

						$total_sales_big_dia_avg_price=0;
						$total_sales_big_dia_avg_price=($total_sales_big_dia_value!=0 ? ($total_sales_big_dia_value/$total_sales_big_dia_quantity) : 0);

						$total_sales_dia_quantity=0;
						$total_sales_dia_quantity=$row->SPRING_SMALL_DIA+$row->SPRING_BIG_DIA+$row->COEX_SMALL_DIA+$row->COEX_BIG_DIA;
						$total_sales_dia_value=0;
						$total_sales_dia_value=$row->SPRING_SMALL_DIA_VALUE+$row->SPRING_BIG_DIA_VALUE+$row->COEX_SMALL_DIA_VALUE+$row->COEX_BIG_DIA_VALUE;
						$total_sales_dia_avg_price=0;
						$total_sales_dia_avg_price=$total_sales_dia_value/$total_sales_dia_quantity;


						

						echo "<tr title='$row->sales_month'>
								<td><b>".$row->sales_year."-".strtoupper($row->sales_month)."</b></td>
								<td class='negative right aligned'>".money_format('%!.0n',$row->COEX_SMALL_DIA)."</td>
								<td class='negative right aligned'>".money_format('%.0n',$row->COEX_SMALL_DIA_VALUE)."</td>
								<td class='negative right aligned'>&#8377;".round($coex_small_dia_avg_price,2)."</td>
								<td class='positive right aligned'>".money_format('%!.0n',$row->COEX_BIG_DIA)."</td>
								<td class='positive right aligned'>".money_format('%.0n',$row->COEX_BIG_DIA_VALUE)."</td>
								<td class='positive right aligned'>&#8377;".round($coex_big_dia_avg_price,2)."</td>
								<td class='warning right aligned'>".money_format('%!.0n',$total_coex_dia_quantity)."</td>
								<td class='warning right aligned'>".money_format('%.0n',$total_coex_dia_value)."</td>
								<td class='warning right aligned'>&#8377;".round($total_coex_dia_avg_price,2)."</td>

								<td class='negative right aligned'>".money_format('%!.0n',$row->SPRING_SMALL_DIA)."</td>
								<td class='negative right aligned'>".money_format('%.0n',$row->SPRING_SMALL_DIA_VALUE)."</td>
								<td class='negative right aligned'>&#8377;".round($spring_small_dia_avg_price,2)."</td>
								<td class='positive right aligned'>".money_format('%!.0n',$row->SPRING_BIG_DIA)."</td>
								<td class='positive right aligned'>".money_format('%.0n',$row->SPRING_BIG_DIA_VALUE)."</td>
								<td class='positive right aligned'>&#8377;".round($spring_big_dia_avg_price,2)."</td>
								<td class='warning right aligned'>".money_format('%!.0n',$total_spring_dia_quantity)."</td>
								<td class='warning right aligned'>".money_format('%.0n',$total_spring_dia_value)."</td>
								<td class='warning right aligned'>&#8377;".round($total_spring_dia_avg_price,2)."</td>


								<td class='negative right aligned'>".money_format('%!.0n',$total_sales_small_dia_quantity)."</td>
								<td class='negative right aligned'>".money_format('%.0n',$total_sales_small_dia_value)."</td>
								<td class='negative right aligned'>&#8377;".round($total_sales_small_dia_avg_price,2)."</td>
								<td class='positive right aligned'>".money_format('%!.0n',$total_sales_big_dia_quantity)."</td>
								<td class='positive right aligned'>".money_format('%.0n',$total_sales_big_dia_value)."</td>
								<td class='positive right aligned'>&#8377;".round($total_sales_big_dia_avg_price,2)."</td>
								<td class='warning right aligned'>".money_format('%!.0n',$total_sales_dia_quantity)."</td>
								<td class='warning right aligned'>".money_format('%.0n',$total_sales_dia_value)."</td>
								<td class='warning right aligned'>&#8377;".round($total_sales_dia_avg_price,2)."</td>

					        </tr>";

					       $total_small_dia_coex_quantity+=$row->COEX_SMALL_DIA;
					       $total_small_dia_coex_value+=$row->COEX_SMALL_DIA_VALUE;
					       $total_big_dia_coex_quantity+=$row->COEX_BIG_DIA;
					       $total_big_dia_coex_value+=$row->COEX_BIG_DIA_VALUE;


					       $total_small_dia_spring_quantity+=$row->SPRING_SMALL_DIA;
					       $total_small_dia_spring_value+=$row->SPRING_SMALL_DIA_VALUE;
					       $total_big_dia_spring_quantity+=$row->SPRING_BIG_DIA;
					       $total_big_dia_spring_value+=$row->SPRING_BIG_DIA_VALUE;

					       $total_small_dia_sales_quantity+=$row->SPRING_SMALL_DIA+$row->COEX_SMALL_DIA;
					       $total_small_dia_sales_value+=$row->SPRING_SMALL_DIA_VALUE+$row->COEX_SMALL_DIA_VALUE;
					       $total_big_dia_sales_quantity+=$row->SPRING_BIG_DIA+$row->COEX_BIG_DIA;
					       $total_big_dia_sales_value+=$row->SPRING_BIG_DIA_VALUE+$row->COEX_BIG_DIA_VALUE;
					    }
					    $total_small_dia_coex_avg=($total_small_dia_coex_value!=0 ? $total_small_dia_coex_value/$total_small_dia_coex_quantity : '0');
					    $total_big_dia_coex_avg=($total_big_dia_coex_value!=0 ? $total_big_dia_coex_value/$total_big_dia_coex_quantity : '0');

					    $total_small_big_dia_coex_quantity=$total_small_dia_coex_quantity+$total_big_dia_coex_quantity;
					    $total_small_big_dia_coex_value=$total_small_dia_coex_value+$total_big_dia_coex_value;
					    $total_small_big_dia_coex_avg=$total_small_big_dia_coex_value/$total_small_big_dia_coex_quantity;


					    $total_small_dia_spring_avg=($total_small_dia_spring_value!=0 ? ($total_small_dia_spring_value/$total_small_dia_spring_quantity) : 0);
					    $total_big_dia_spring_avg=($total_big_dia_spring_value!=0 ? $total_big_dia_spring_value/$total_big_dia_spring_quantity : '0');

					    $total_small_big_dia_spring_quantity=$total_small_dia_spring_quantity+$total_big_dia_spring_quantity;
					    $total_small_big_dia_spring_value=$total_small_dia_spring_value+$total_big_dia_spring_value;
					    $total_small_big_dia_spring_avg=($total_small_big_dia_spring_value!=0 ? ($total_small_big_dia_spring_value/$total_small_big_dia_spring_quantity) : 0);


					    $total_small_dia_sales_avg=($total_small_dia_sales_value!=0 ? $total_small_dia_sales_value/$total_small_dia_sales_quantity : '0');
					    $total_big_dia_sales_avg=($total_big_dia_sales_value!=0 ? $total_big_dia_sales_value/$total_big_dia_sales_quantity : '0');

					    $total_small_big_dia_sales_quantity=$total_small_dia_sales_quantity+$total_big_dia_sales_quantity;
					    $total_small_big_dia_sales_value=$total_small_dia_sales_value+$total_big_dia_sales_value;
					    $total_small_big_dia_sales_avg=($total_small_big_dia_sales_value!=0 ? ($total_small_big_dia_sales_value/$total_small_big_dia_sales_quantity) :0);


					    echo "<thead>
							    <tr>
							    	<th>TOTAL</th>
							    	<th class='negative right aligned'>".money_format('%!.0n',$total_small_dia_coex_quantity)."</th>
							    	<th class='negative right aligned'>".money_format('%.0n',$total_small_dia_coex_value)."</th>
							    	<th class='negative right aligned'>&#8377;".round($total_small_dia_coex_avg,2)."</th>
							    	<th class='positive right aligned'>".money_format('%!.0n',$total_big_dia_coex_quantity)."</th>
							    	<th class='positive right aligned'>".money_format('%.0n',$total_big_dia_coex_value)."</th>
							    	<th class='positive right aligned'>&#8377;".round($total_big_dia_coex_avg,2)."</th>
							    	<th class='warning right aligned'>".money_format('%!.0n',$total_small_big_dia_coex_quantity)."</th>
							    	<th class='warning right aligned'>".money_format('%.0n',$total_small_big_dia_coex_value)."</th>
							    	<th class='warning right aligned'>&#8377;".round($total_small_big_dia_coex_avg,2)."</th>

							    	<th class='negative right aligned'>".money_format('%!.0n',$total_small_dia_spring_quantity)."</th>
							    	<th class='negative right aligned'>".money_format('%.0n',$total_small_dia_spring_value)."</th>
							    	<th class='negative right aligned'>&#8377;".round($total_small_dia_spring_avg,2)."</th>
							    	<th class='positive right aligned'>".money_format('%!.0n',$total_big_dia_spring_quantity)."</th>
							    	<th class='positive right aligned'>".money_format('%.0n',$total_big_dia_spring_value)."</th>
							    	<th class='positive right aligned'>&#8377;".round($total_big_dia_spring_avg,2)."</th>
							    	<th class='warning right aligned'>".money_format('%!.0n',$total_small_big_dia_spring_quantity)."</th>
							    	<th class='warning right aligned'>".money_format('%.0n',$total_small_big_dia_spring_value)."</th>
							    	<th class='warning right aligned'>&#8377;".round($total_small_big_dia_spring_avg,2)."</th>


							    	<th class='negative right aligned'>".money_format('%!.0n',$total_small_dia_sales_quantity)."</th>
							    	<th class='negative right aligned'>".money_format('%.0n',$total_small_dia_sales_value)."</th>
							    	<th class='negative right aligned'>&#8377;".round($total_small_dia_sales_avg,2)."</th>
							    	<th class='positive right aligned'>".money_format('%!.0n',$total_big_dia_sales_quantity)."</th>
							    	<th class='positive right aligned'>".money_format('%.0n',$total_big_dia_sales_value)."</th>
							    	<th class='positive right aligned'>&#8377;".round($total_big_dia_sales_avg,2)."</th>
							    	<th class='warning right aligned'>".money_format('%!.0n',$total_small_big_dia_sales_quantity)."</th>
							    	<th class='warning right aligned'>".money_format('%.0n',$total_small_big_dia_sales_value)."</th>
							    	<th class='warning right aligned'>&#8377;".round($total_small_big_dia_sales_avg,2)."</th>

							  	</tr>
							  </thead>";

						echo '</table>';
					}
				?>

