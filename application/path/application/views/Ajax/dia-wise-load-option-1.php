<?php/*
					setlocale(LC_MONETARY, 'en_IN');
					if($dia_wise_sales_coex==FALSE){

					}else{
						echo '<table class="ui sortable selectable celled table" style="font-size:10px;">
					        	<thead>
								   <tr>
								    	<th colspan="10"><a class="ui orange label">COEX SALES</a>'.($from_date!='' && $to_date!='' ? 
								    		' <a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date($from_date,$this->session->userdata['logged_in']['company_id']).'  TO '.$this->common_model->view_date($to_date,$this->session->userdata['logged_in']['company_id']).'</a><br/><br/>' : '');

								    	if(!empty($sleeve_dia_data)){

								    		$arr=explode(",",$sleeve_dia_data);
								    		foreach($arr as $sld){
								    			$sld=str_replace("'","",$sld);
								    			echo '<a class="ui label">'.$sld.'</a>';
								    		}
								    	}

								    	if(!empty($inv_type_data)){
								    		echo "<br/><br/>";
								    		$arr=explode(",",$inv_type_data);
								    		foreach($arr as $inv_type_data_row){
								    			$inv_type_data_row=str_replace("'","",$inv_type_data_row);
								    			echo '<a class="ui blue label">'.$inv_type_data_row.'</a>';
								    		}
								    	}

								    	if(!empty($customer_data)){
								    		
								    	$arr=explode(",",$customer_data);
								    	$i=1;
								    	foreach($arr as $cus){
								    		
								    		echo '<a class="ui label">'.$this->common_model->get_customer_name($cus,$this->session->userdata['logged_in']['company_id']).'</a>';
								    		if($i==4){
								    			echo "<br/><br/>";
								    		}
								    		$i++;
								    		
								    		}
								    		
								    	}
								    	 echo'</th>
								  </tr>
					        		<tr>
					        			<th></th>
					        			<th colspan="3" class="center aligned">SMALL DIA (19,22.6,25,30)</th>
					        			<th colspan="3" class="center aligned">BIG DIA (35,40,50)</th>
					        			<th colspan="3" class="center aligned">TOTAL</th>
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
					 $count=0;
					foreach($dia_wise_sales_coex as $row_coex){
						$small_dia_avg_price=0;
						$small_dia_avg_price=($row_coex->SMALL_DIA_VALUE!=0 ? $row_coex->SMALL_DIA_VALUE/$row_coex->SMALL_DIA : 0);
						$big_dia_avg_price=0;
						$big_dia_avg_price=($row_coex->BIG_DIA_VALUE!=0 ? $row_coex->BIG_DIA_VALUE/$row_coex->BIG_DIA : 0);
						$total_dia_quantity=0;
						$total_dia_quantity=$row_coex->SMALL_DIA+$row_coex->BIG_DIA;
						$total_dia_value=0;
						$total_dia_value=$row_coex->SMALL_DIA_VALUE+$row_coex->BIG_DIA_VALUE;
						$total_dia_avg_price=0;
						$total_dia_avg_price=$total_dia_value/$total_dia_quantity;
						echo "<tr>
								<td>".$row_coex->sales_year."-".strtoupper($row_coex->sales_month)."</td>
								<td class='negative right aligned'>".money_format('%!.0n',$row_coex->SMALL_DIA)."</td>
								<td class='negative right aligned'>".money_format('%.0n',$row_coex->SMALL_DIA_VALUE)."</td>
								<td class='negative right aligned'>&#8377;".round($small_dia_avg_price,2)."</td>
								<td class='positive right aligned'>".money_format('%!.0n',$row_coex->BIG_DIA)."</td>
								<td class='positive right aligned'>".money_format('%.0n',$row_coex->BIG_DIA_VALUE)."</td>
								<td class='positive right aligned'>&#8377;".round($big_dia_avg_price,2)."</td>
								<td class='warning right aligned'>".money_format('%!.0n',$total_dia_quantity)."</td>
								<td class='warning right aligned'>".money_format('%.0n',$total_dia_value)."</td>
								<td class='warning right aligned'>&#8377;".round($total_dia_avg_price,2)."</td>
					        </tr>";

					       $total_small_dia_coex_quantity+=$row_coex->SMALL_DIA;
					       $total_small_dia_coex_value+=$row_coex->SMALL_DIA_VALUE;
					       $total_big_dia_coex_quantity+=$row_coex->BIG_DIA;
					       $total_big_dia_coex_value+=$row_coex->BIG_DIA_VALUE;
					    }
					    $total_small_dia_coex_avg=($total_small_dia_coex_value!=0 ? $total_small_dia_coex_value/$total_small_dia_coex_quantity : '0');
					    $total_big_dia_coex_avg=($total_big_dia_coex_value!=0 ? $total_big_dia_coex_value/$total_big_dia_coex_quantity : '0');

					    $total_small_big_dia_coex_quantity=$total_small_dia_coex_quantity+$total_big_dia_coex_quantity;
					    $total_small_big_dia_coex_value=$total_small_dia_coex_value+$total_big_dia_coex_value;
					    $total_small_big_dia_coex_avg=$total_small_big_dia_coex_value/$total_small_big_dia_coex_quantity;

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
							  	</tr>
							  </thead>";

						echo '</table>';
					}
				?>
				

				<br/>
  				<?php
					setlocale(LC_MONETARY, 'en_IN');
					if($dia_wise_sales_spring==FALSE){

					}else{
						echo '<div style="text-align:center;"><i class="plus circle icon"></i></div><br/>
						<table class="ui sortable selectable celled table" style="font-size:10px;">
					        	<thead>
								   <tr>
								    	<th colspan="10"><a class="ui yellow label">SPRING SALES</a>'.($from_date!='' && $to_date!='' ? 
								    		' <a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date($from_date,$this->session->userdata['logged_in']['company_id']).'  TO '.$this->common_model->view_date($to_date,$this->session->userdata['logged_in']['company_id']).'</a><br/><br/>' : '');

								    	if(!empty($sleeve_dia_data)){

								    		$arr=explode(",",$sleeve_dia_data);
								    		foreach($arr as $sld){
								    			$sld=str_replace("'","",$sld);
								    			echo '<a class="ui label">'.$sld.'</a>';
								    		}
								    	}

								    	if(!empty($inv_type_data)){
								    		echo "<br/><br/>";
								    		$arr=explode(",",$inv_type_data);
								    		foreach($arr as $inv_type_data_row){
								    			$inv_type_data_row=str_replace("'","",$inv_type_data_row);
								    			echo '<a class="ui blue label">'.$inv_type_data_row.'</a>';
								    		}
								    	}

								    	if(!empty($customer_data)){
								    		
								    	$arr=explode(",",$customer_data);
								    	$i=1;
								    	foreach($arr as $cus){
								    		
								    		echo '<a class="ui label">'.$this->common_model->get_customer_name($cus,$this->session->userdata['logged_in']['company_id']).'</a>';
								    		if($i==4){
								    			echo "<br/><br/>";
								    		}
								    		$i++;
								    		
								    		}
								    		
								    	}
								    	 echo'</th>
								  </tr>
					        		<tr>
					        			<th></th>
					        			<th colspan="3" class="center aligned">SMALL DIA (19,22.6,25,30)</th>
					        			<th colspan="3" class="center aligned">BIG DIA (35,40,50)</th>
					        			<th colspan="3" class="center aligned">TOTAL</th>
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
					        		</tr>
					        	</thead>';
					 $total_small_dia_spring_quantity=0;
					 $total_small_dia_spring_value=0;
					 $total_small_dia_spring_avg=0;
					 $total_big_dia_spring_quantity=0;
					 $total_big_dia_spring_value=0;
					 $total_big_dia_spring_avg=0;
					 $total_small_big_dia_spring_quantity=0;
					 $total_small_big_dia_spring_value=0;
					 $total_small_big_dia_spring_avg=0;
					 $count=0;
					foreach($dia_wise_sales_spring as $row_coex){
						$small_dia_avg_price=0;
						$small_dia_avg_price=($row_coex->SMALL_DIA_VALUE!=0 ? $row_coex->SMALL_DIA_VALUE/$row_coex->SMALL_DIA : 0);
						$big_dia_avg_price=0;
						$big_dia_avg_price=($row_coex->BIG_DIA_VALUE!=0 ? $row_coex->BIG_DIA_VALUE/$row_coex->BIG_DIA : 0);
						$total_dia_quantity=0;
						$total_dia_quantity=$row_coex->SMALL_DIA+$row_coex->BIG_DIA;
						$total_dia_value=0;
						$total_dia_value=$row_coex->SMALL_DIA_VALUE+$row_coex->BIG_DIA_VALUE;
						$total_dia_avg_price=0;
						$total_dia_avg_price=$total_dia_value/$total_dia_quantity;
						echo "<tr>
								<td>".$row_coex->sales_year."-".strtoupper($row_coex->sales_month)."</td>
								<td class='negative right aligned'>".money_format('%!.0n',$row_coex->SMALL_DIA)."</td>
								<td class='negative right aligned'>".money_format('%.0n',$row_coex->SMALL_DIA_VALUE)."</td>
								<td class='negative right aligned'>&#8377;".round($small_dia_avg_price,2)."</td>
								<td class='positive right aligned'>".money_format('%!.0n',$row_coex->BIG_DIA)."</td>
								<td class='positive right aligned'>".money_format('%.0n',$row_coex->BIG_DIA_VALUE)."</td>
								<td class='positive right aligned'>&#8377;".round($big_dia_avg_price,2)."</td>
								<td class='warning right aligned'>".money_format('%!.0n',$total_dia_quantity)."</td>
								<td class='warning right aligned'>".money_format('%.0n',$total_dia_value)."</td>
								<td class='warning right aligned'>&#8377;".round($total_dia_avg_price,2)."</td>
					        </tr>";

					       $total_small_dia_spring_quantity+=$row_coex->SMALL_DIA;
					       $total_small_dia_spring_value+=$row_coex->SMALL_DIA_VALUE;
					       $total_big_dia_spring_quantity+=$row_coex->BIG_DIA;
					       $total_big_dia_spring_value+=$row_coex->BIG_DIA_VALUE;
					    }
					    $total_small_dia_spring_avg=($total_small_dia_spring_value!=0 ? $total_small_dia_spring_value/$total_small_dia_spring_quantity : '0');
					    $total_big_dia_spring_avg=($total_big_dia_spring_value!=0 ? $total_big_dia_spring_value/$total_big_dia_spring_quantity : '0');

					    $total_small_big_dia_spring_quantity=$total_small_dia_spring_quantity+$total_big_dia_spring_quantity;
					    $total_small_big_dia_spring_value=$total_small_dia_spring_value+$total_big_dia_spring_value;
					    $total_small_big_dia_spring_avg=$total_small_big_dia_spring_value/$total_small_big_dia_spring_quantity;

					    echo "<thead>
							    <tr>
							    	<th>TOTAL</th>
							    	<th class='negative right aligned'>".money_format('%!.0n',$total_small_dia_spring_quantity)."</th>
							    	<th class='negative right aligned'>".money_format('%.0n',$total_small_dia_spring_value)."</th>
							    	<th class='negative right aligned'>&#8377;".round($total_small_dia_spring_avg,2)."</th>
							    	<th class='positive right aligned'>".money_format('%!.0n',$total_big_dia_spring_quantity)."</th>
							    	<th class='positive right aligned'>".money_format('%.0n',$total_big_dia_spring_value)."</th>
							    	<th class='positive right aligned'>&#8377;".round($total_big_dia_spring_avg,2)."</th>
							    	<th class='warning right aligned'>".money_format('%!.0n',$total_small_big_dia_spring_quantity)."</th>
							    	<th class='warning right aligned'>".money_format('%.0n',$total_small_big_dia_spring_value)."</th>
							    	<th class='warning right aligned'>&#8377;".round($total_small_big_dia_spring_avg,2)."</th>
							  	</tr>
							  </thead>";

						echo '</table>';
					}
				?>



				<?php
					setlocale(LC_MONETARY, 'en_IN');
					if($dia_wise_sales_coex==FALSE || $dia_wise_sales_spring==FALSE){

					}else{
						echo '<br/>
								<div style="text-align:center;"><i class="bars icon"></i></div>
								<br/>
								<table class="ui sortable selectable celled table" style="font-size:10px;">
					        	<thead>

					        		<tr>
					        			<th>MONTH-YEAR</th>
					        			<th colspan="3" class="center aligned">SMALL DIA (19,22.6,25,30)</th>
					        			<th colspan="3" class="center aligned">BIG DIA (35,40,50)</th>
					        			<th colspan="3" class="center aligned">TOTAL</th>
					        		</tr>


					        		<tr>

								    	<th>'.($from_date!='' && $to_date!='' ? 
								    		''.$this->common_model->view_date($from_date,$this->session->userdata['logged_in']['company_id']).'  TO '.$this->common_model->view_date($to_date,$this->session->userdata['logged_in']['company_id']).'' : '').'</th>
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
								  </thead>
								  <tbody>
								   <tr>
								   		<td>COEX SALES</td>
								    	

								    	<td class="right aligned">'.money_format('%!.0n',$total_small_dia_coex_quantity).'</td>
								    	<td class="right aligned">'.money_format('%.0n',$total_small_dia_coex_value).'</td>
								    	<td class="right aligned">&#8377;'.round($total_small_dia_coex_avg,2).'</td>


								    	<td class="right aligned">'.money_format('%!.0n',$total_big_dia_coex_quantity).'</td>
								    	<td class="right aligned">'.money_format('%.0n',$total_big_dia_coex_value).'</td>
								    	<td class="right aligned">&#8377;'.round($total_big_dia_coex_avg,2).'</td>

								    	<td class="right aligned">'.money_format('%!.0n',$total_small_big_dia_coex_quantity).'</td>
								    	<td class="right aligned">'.money_format('%.0n',$total_small_big_dia_coex_value).'</td>
								    	<td class="right aligned">&#8377;'.round($total_small_big_dia_coex_avg,2).'</td>
								  	</tr>

								  	<tr>
								   		<td>SPRING SALES</td>
								   		<td class="right aligned">'.money_format('%!.0n',$total_small_dia_spring_quantity).'</td>
								    	<td class="right aligned">'.money_format('%.0n',$total_small_dia_spring_value).'</td>
								    	<td class="right aligned">&#8377;'.round($total_small_dia_spring_avg,2).'</td>


								    	<td class="right aligned">'.money_format('%!.0n',$total_big_dia_spring_quantity).'</td>
								    	<td class="right aligned">'.money_format('%.0n',$total_big_dia_spring_value).'</td>
								    	<td class="right aligned">&#8377;'.round($total_big_dia_spring_avg,2).'</td>


								    	<td class="right aligned">'.money_format('%!.0n',$total_small_big_dia_spring_quantity).'</td>
								    	<td class="right aligned">'.money_format('%.0n',$total_small_big_dia_spring_value).'</td>
								    	<td class="right aligned">&#8377;'.round($total_small_big_dia_spring_avg,2).'</td>
								  	</tr></tbody>';
								  		$avg=($total_small_big_dia_coex_value+$total_small_big_dia_spring_value)/($total_small_big_dia_coex_quantity+$total_small_big_dia_spring_quantity);
								  		$grand_total_small_dia_quantity=0;
								  		$grand_total_small_dia_quantity=$total_small_dia_coex_quantity+$total_small_dia_spring_quantity;
								  		$grand_total_small_dia_value=0;
								  		$grand_total_small_dia_value=$total_small_dia_coex_value+$total_small_dia_spring_value;

								  		$grand_total_small_dia_avg_price=($grand_total_small_dia_value!=0 ? ($grand_total_small_dia_value/$grand_total_small_dia_quantity) : 0);

								  		$grand_total_big_dia_quantity=0;
								  		$grand_total_big_dia_quantity=$total_big_dia_coex_quantity+$total_big_dia_spring_quantity;
								  		$grand_total_big_dia_value=0;
								  		$grand_total_big_dia_value=$total_big_dia_coex_value+$total_big_dia_spring_value;

								  		$grand_total_big_dia_avg_price=($grand_total_big_dia_value!=0 ? ($grand_total_big_dia_value/$grand_total_big_dia_quantity) : 0);

								 echo '<thead>
								 		<tr>
									   		<th>GRAND TOTAL</th>
									    	<th class="right aligned">'.money_format('%!.0n',$grand_total_small_dia_quantity).'</th>
									    	<th class="right aligned">'.money_format('%.0n',$grand_total_small_dia_value).'</th>
									    	<th class="right aligned">&#8377;'.round($grand_total_small_dia_avg_price,2).'</th>

									    	<th class="right aligned">'.money_format('%!.0n',$grand_total_big_dia_quantity).'</th>
									    	<th class="right aligned">'.money_format('%.0n',$grand_total_big_dia_value).'</th>
									    	<th class="right aligned">&#8377;'.round($grand_total_big_dia_avg_price,2).'</th>

									    	<th class="right aligned">'.money_format('%!.0n',$total_small_big_dia_coex_quantity+$total_small_big_dia_spring_quantity).'</th>
									    	<th class="right aligned">'.money_format('%.0n',$total_small_big_dia_coex_value+$total_small_big_dia_spring_value).'</th>
									    	<th class="right aligned">&#8377;'.round($avg,2).'</th>
								  		</tr>
								  		</thead>
								  	</table>';
					}
					

					*/?>