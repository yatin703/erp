<?php
					setlocale(LC_MONETARY, 'en_IN');
					if($print_type_wise_sales_coex==FALSE){

					}else{
						echo '<table class="ui sortable selectable celled table" style="font-size:10px;">
					        	<thead>
								   <tr>
								    	<th colspan="20"><a class="ui orange label">'.$customer_name.' SALES</a>'.($from_date!='' && $to_date!='' ? 
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
								    	} echo'

								    	</th>
								  </tr>
								  <tr>
					        			<th colspan="2"></th>
					        			<th colspan="12" class="center aligned">COEX TUBE</th>
					        			<th colspan="3" class="center aligned">SPRING TUBE</th>
					        			<th colspan="3" class="center aligned">GRAND TOTAL</th>
					        	  </tr>
								  <tr>
					        			<th colspan="2"></th>
					        			<th colspan="3" class="center aligned">SCREEN+FLEXO</th>
					        			<th colspan="3" class="center aligned">OFFSET</th>
					        			<th colspan="3" class="center aligned">LABEL</th>
					        			<th colspan="3" class="center aligned">COEX TOTAL</th>
					        			<th colspan="3" class="center aligned">DIGITAL</th>
					        			<th colspan="3" class="center aligned">MONTH WISE TOTAL</th>
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
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG PRICE</th>
					        		</tr>
					        	</thead>';
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

					 $total_total_print_type_coex_quantity=0;
					 $total_total_print_type_coex_value=0;
					 $total_total_print_type_coex_avg=0;
					 $i=1;
					 $count=0;
					 $last_count=0;
					foreach($print_type_wise_sales_coex as $row_coex){
						$screen_flexo_avg_price=0;
						$screen_flexo_avg_price=($row_coex->SCREEN_FLEXO_VALUE!=0 ? $row_coex->SCREEN_FLEXO_VALUE/$row_coex->SCREEN_FLEXO : 0);
						$offset_avg_price=0;
						$offset_avg_price=($row_coex->OFFSET_VALUE!=0 ? $row_coex->OFFSET_VALUE/$row_coex->OFFSET : 0);
						$label_avg_price=0;
						$label_avg_price=($row_coex->LABEL_VALUE!=0 ? $row_coex->LABEL_VALUE/$row_coex->LABEL : 0);
						$digital_avg_price=0;
						$digital_avg_price=($row_coex->DIGITAL_VALUE!=0 ? $row_coex->DIGITAL_VALUE/$row_coex->DIGITAL : 0);



						$total_prin_type_coex_quantity=0;
						$total_prin_type_coex_quantity=$row_coex->SCREEN_FLEXO+$row_coex->OFFSET+$row_coex->LABEL;

						$total_print_type_coex_value=0;
						$total_print_type_coex_value=$row_coex->SCREEN_FLEXO_VALUE+$row_coex->OFFSET_VALUE+$row_coex->LABEL_VALUE;

						$total_print_type_coex_avg_price=0;
						$total_print_type_coex_avg_price=($total_print_type_coex_value!=0 ? $total_print_type_coex_value/$total_prin_type_coex_quantity : 0);

						$total_prin_type_quantity=0;
						$total_prin_type_quantity=$row_coex->SCREEN_FLEXO+$row_coex->OFFSET+$row_coex->LABEL+$row_coex->DIGITAL;
						$total_print_type_value=0;
						$total_print_type_value=$row_coex->SCREEN_FLEXO_VALUE+$row_coex->OFFSET_VALUE+$row_coex->LABEL_VALUE+$row_coex->DIGITAL_VALUE;
						$total_print_type_avg_price=0;
						$total_print_type_avg_price=$total_print_type_value/$total_prin_type_quantity;
						if($count==0){
							$from_date=strtoupper($row_coex->sales_month)." ".$row_coex->sales_year;
						}
						echo "<tr>
								<td>$i</td>
								<td><b>".$row_coex->sales_year."-".strtoupper($row_coex->sales_month)."</b></td>
								<td class='negative right aligned'>".money_format('%!.0n',$row_coex->SCREEN_FLEXO)."</td>
								<td class='negative right aligned'>".money_format('%.0n',$row_coex->SCREEN_FLEXO_VALUE)."</td>
								<td class='negative right aligned'>&#8377;".round($screen_flexo_avg_price,2)."</td>
								<td class='positive right aligned'>".money_format('%!.0n',$row_coex->OFFSET)."</td>
								<td class='positive right aligned'>".money_format('%.0n',$row_coex->OFFSET_VALUE)."</td>
								<td class='positive right aligned'>&#8377;".round($offset_avg_price,2)."</td>
								<td class='right aligned'>".money_format('%!.0n',$row_coex->LABEL)."</td>
								<td class='right aligned'>".money_format('%.0n',$row_coex->LABEL_VALUE)."</td>
								<td class='right aligned'>&#8377;".round($label_avg_price,2)."</td>

								<td class='active right aligned'>".money_format('%!.0n',$total_prin_type_coex_quantity)."</td>
								<td class='active right aligned'>".money_format('%.0n',$total_print_type_coex_value)."</td>
								<td class='active right aligned'>&#8377;".round($total_print_type_coex_avg_price,2)."</td>

								<td class='negative right aligned'>".money_format('%!.0n',$row_coex->DIGITAL)."</td>
								<td class='negative right aligned'>".money_format('%.0n',$row_coex->DIGITAL_VALUE)."</td>
								<td class='negative right aligned'>&#8377;".round($digital_avg_price,2)."</td>

								<td class='active warning right aligned'>".money_format('%!.0n',$total_prin_type_quantity)."</td>
								<td class='active warning right aligned'>".money_format('%.0n',$total_print_type_value)."</td>
								<td class='active warning right aligned'>&#8377;".round($total_print_type_avg_price,2)."</td>
					        </tr>";

					       $total_screen_flexo_quantity+=$row_coex->SCREEN_FLEXO;
					       $total_screen_flexo_value+=$row_coex->SCREEN_FLEXO_VALUE;
					       $total_offset_quantity+=$row_coex->OFFSET;
					       $total_offset_value+=$row_coex->OFFSET_VALUE;
					       $total_label_quantity+=$row_coex->LABEL;
					       $total_label_value+=$row_coex->LABEL_VALUE;
					       $total_digital_quantity+=$row_coex->DIGITAL;
					       $total_digital_value+=$row_coex->DIGITAL_VALUE;
					       $count++;
					       if($last_count==0){
							$to_date=strtoupper($row_coex->sales_month)." ".$row_coex->sales_year;
							}
							$i++;
					    }
					    $total_screen_flexo_avg=($total_screen_flexo_value!=0 ? $total_screen_flexo_value/$total_screen_flexo_quantity : '0');
					    $total_offset_avg=($total_offset_value!=0 ? $total_offset_value/$total_offset_quantity : '0');
					    $total_label_avg=($total_label_value!=0 ? $total_label_value/$total_label_quantity : '0');
					    $total_digital_avg=($total_digital_value!=0 ? $total_digital_value/$total_digital_quantity : '0');

					    $total_total_print_type_coex_quantity=$total_screen_flexo_quantity+$total_offset_quantity+$total_label_quantity;
					    $total_total_print_type_coex_value=$total_screen_flexo_value+$total_offset_value+$total_label_value;
					    
					    $total_total_print_type_coex_avg=($total_total_print_type_coex_quantity!=0?$total_total_print_type_coex_value/$total_total_print_type_coex_quantity:0);

					    $total_total_print_type_sales_quantity=$total_screen_flexo_quantity+$total_offset_quantity+$total_label_quantity+$total_digital_quantity;
					    $total_total_print_type_sales_value=$total_screen_flexo_value+$total_offset_value+$total_label_value+$total_digital_value;
					    $total_total_print_type_sales_avg=$total_total_print_type_sales_value/$total_total_print_type_sales_quantity;

					    echo "<thead>
							    <tr>
							    	<th colspan='2'>GRAND TOTAL</th>
							    	<th class='negative right aligned'>".money_format('%!.0n',$total_screen_flexo_quantity)."</th>
							    	<th class='negative right aligned'>".money_format('%.0n',$total_screen_flexo_value)."</th>
							    	<th class='negative right aligned'>&#8377;".round($total_screen_flexo_avg,2)."</th>
							    	<th class='positive right aligned'>".money_format('%!.0n',$total_offset_quantity)."</th>
							    	<th class='positive right aligned'>".money_format('%.0n',$total_offset_value)."</th>
							    	<th class='positive right aligned'>&#8377;".round($total_offset_avg,2)."</th>
							    	<th class='positive right aligned'>".money_format('%!.0n',$total_label_quantity)."</th>
							    	<th class='positive right aligned'>".money_format('%.0n',$total_label_value)."</th>
							    	<th class='positive right aligned'>&#8377;".round($total_label_avg,2)."</th>

							    	<th class='positive right aligned'>".money_format('%!.0n',$total_total_print_type_coex_quantity)."</th>
							    	<th class='positive right aligned'>".money_format('%.0n',$total_total_print_type_coex_value)."</th>
							    	<th class='positive right aligned'>&#8377;".round($total_total_print_type_coex_avg,2)."</th>

							    	<th class='positive right aligned'>".money_format('%!.0n',$total_digital_quantity)."</th>
							    	<th class='positive right aligned'>".money_format('%.0n',$total_digital_value)."</th>
							    	<th class='positive right aligned'>&#8377;".round($total_digital_avg,2)."</th>

							    	<th class='warning right aligned'>".money_format('%!.0n',$total_total_print_type_sales_quantity)."</th>
							    	<th class='warning right aligned'>".money_format('%.0n',$total_total_print_type_sales_value)."</th>
							    	<th class='warning right aligned'>&#8377;".round($total_total_print_type_sales_avg,2)."</th>
							  	</tr>
							  </thead>";

						echo '</table>';

					}
				?>

<?php
		/*			setlocale(LC_MONETARY, 'en_IN');
					if($print_type_wise_sales_coex==FALSE){

					}else{
						echo '<table class="ui sortable selectable celled table" style="font-size:10px;">
					        	<thead>
								   <tr>
								    	<th colspan="13">
								    	<a class="ui orange label">COEX PRINTING SALES</a>'.($from_date!='' && $to_date!='' ? 
								    		' <a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date($from_date,$this->session->userdata['logged_in']['company_id']).'  TO '.$this->common_model->view_date($to_date,$this->session->userdata['logged_in']['company_id']).'</a><br/><br/>' : '');

								    	if(!empty($sleeve_dia_data)){

								    		$arr=explode(",",$sleeve_dia_data);
								    		foreach($arr as $sld){
								    			$sld=str_replace("'","",$sld);
								    			echo '<a class="ui orange basic label">'.$sld.'</a>';
								    		}
								    		echo "<br/><br/>";
								    	}

								    	if(!empty($inv_type_data)){
								    		
								    		$arr=explode(",",$inv_type_data);
								    		foreach($arr as $inv_type_data_row){
								    			$inv_type_data_row=str_replace("'","",$inv_type_data_row);
								    			echo '<a class="ui blue label">'.$inv_type_data_row.'</a>';
								    		}
								    		echo "<br/><br/>";
								    	}

								    	if(!empty($customer_data)){
								    		
								    	$arr=explode(",",$customer_data);
								    	$i=1;
								    	foreach($arr as $cus){
								    		
								    		echo '<a class="ui grey label">'.$this->common_model->get_customer_name($cus,$this->session->userdata['logged_in']['company_id']).'</a>';
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
					        			<th colspan="3" class="center aligned">SCREEN+FLEXO</th>
					        			<th colspan="3" class="center aligned">OFFSET</th>
					        			<th colspan="3" class="center aligned">LABEL</th>
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
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG PRICE</th>
					        		</tr>
					        	</thead>';
					 $total_screen_flexo_quantity=0;
					 $total_screen_flexo_value=0;
					 $total_screen_flexo_avg=0;
					 $total_offset_quantity=0;
					 $total_offset_value=0;
					 $total_offset_avg=0;
					 $total_label_quantity=0;
					 $total_label_value=0;
					 $total_label_avg=0;
					 $total_total_print_type_coex_quantity=0;
					 $total_total_print_type_coex_value=0;
					 $total_total_print_type_coex_avg=0;
					 $count=0;
					 $last_count=0;
					foreach($print_type_wise_sales_coex as $row_coex){
						$screen_flexo_avg_price=0;
						$screen_flexo_avg_price=($row_coex->SCREEN_FLEXO_VALUE!=0 ? $row_coex->SCREEN_FLEXO_VALUE/$row_coex->SCREEN_FLEXO : 0);
						$offset_avg_price=0;
						$offset_avg_price=($row_coex->OFFSET_VALUE!=0 ? $row_coex->OFFSET_VALUE/$row_coex->OFFSET : 0);
						$label_avg_price=0;
						$label_avg_price=($row_coex->LABEL_VALUE!=0 ? $row_coex->LABEL_VALUE/$row_coex->LABEL : 0);
						$total_prin_type_quantity=0;
						$total_prin_type_quantity=$row_coex->SCREEN_FLEXO+$row_coex->OFFSET+$row_coex->LABEL;
						$total_print_type_value=0;
						$total_print_type_value=$row_coex->SCREEN_FLEXO_VALUE+$row_coex->OFFSET_VALUE+$row_coex->LABEL_VALUE;
						$total_print_type_avg_price=0;
						$total_print_type_avg_price=$total_print_type_value/$total_prin_type_quantity;
						if($count==0){
							$from_date=strtoupper($row_coex->sales_month)." ".$row_coex->sales_year;
						}
						echo "<tr>
								<td>".$row_coex->sales_year."-".strtoupper($row_coex->sales_month)."</td>
								<td class='negative right aligned'>".money_format('%!.0n',$row_coex->SCREEN_FLEXO)."</td>
								<td class='negative right aligned'>".money_format('%.0n',$row_coex->SCREEN_FLEXO_VALUE)."</td>
								<td class='negative right aligned'>&#8377;".round($screen_flexo_avg_price,2)."</td>
								<td class='positive right aligned'>".money_format('%!.0n',$row_coex->OFFSET)."</td>
								<td class='positive right aligned'>".money_format('%.0n',$row_coex->OFFSET_VALUE)."</td>
								<td class='positive right aligned'>&#8377;".round($offset_avg_price,2)."</td>
								<td class='right aligned'>".money_format('%!.0n',$row_coex->LABEL)."</td>
								<td class='right aligned'>".money_format('%.0n',$row_coex->LABEL_VALUE)."</td>
								<td class='right aligned'>&#8377;".round($label_avg_price,2)."</td>
								<td class='warning right aligned'>".money_format('%!.0n',$total_prin_type_quantity)."</td>
								<td class='warning right aligned'>".money_format('%.0n',$total_print_type_value)."</td>
								<td class='warning right aligned'>&#8377;".round($total_print_type_avg_price,2)."</td>
					        </tr>";

					       $total_screen_flexo_quantity+=$row_coex->SCREEN_FLEXO;
					       $total_screen_flexo_value+=$row_coex->SCREEN_FLEXO_VALUE;
					       $total_offset_quantity+=$row_coex->OFFSET;
					       $total_offset_value+=$row_coex->OFFSET_VALUE;
					       $total_label_quantity+=$row_coex->LABEL;
					       $total_label_value+=$row_coex->LABEL_VALUE;

					       $count++;
					       if($last_count==0){
							$to_date=strtoupper($row_coex->sales_month)." ".$row_coex->sales_year;
							}
					    }
					    $total_screen_flexo_avg=($total_screen_flexo_value!=0 ? $total_screen_flexo_value/$total_screen_flexo_quantity : '0');
					    $total_offset_avg=($total_offset_value!=0 ? $total_offset_value/$total_offset_quantity : '0');
					    $total_label_avg=($total_label_value!=0 ? $total_label_value/$total_label_quantity : '0');

					    $total_total_print_type_coex_quantity=$total_screen_flexo_quantity+$total_offset_quantity+$total_label_quantity;
					    $total_total_print_type_coex_value=$total_screen_flexo_value+$total_offset_value+$total_label_value;
					    $total_total_print_type_coex_avg=$total_total_print_type_coex_value/$total_total_print_type_coex_quantity;

					    echo "<thead>
							    <tr>
							    	<th>TOTAL</th>
							    	<th class='negative right aligned'>".money_format('%!.0n',$total_screen_flexo_quantity)."</th>
							    	<th class='negative right aligned'>".money_format('%.0n',$total_screen_flexo_value)."</th>
							    	<th class='negative right aligned'>&#8377;".round($total_screen_flexo_avg,2)."</th>
							    	<th class='positive right aligned'>".money_format('%!.0n',$total_offset_quantity)."</th>
							    	<th class='positive right aligned'>".money_format('%.0n',$total_offset_value)."</th>
							    	<th class='positive right aligned'>&#8377;".round($total_offset_avg,2)."</th>
							    	<th class='positive right aligned'>".money_format('%!.0n',$total_label_quantity)."</th>
							    	<th class='positive right aligned'>".money_format('%.0n',$total_label_value)."</th>
							    	<th class='positive right aligned'>&#8377;".round($total_label_avg,2)."</th>
							    	<th class='warning right aligned'>".money_format('%!.0n',$total_total_print_type_coex_quantity)."</th>
							    	<th class='warning right aligned'>".money_format('%.0n',$total_total_print_type_coex_value)."</th>
							    	<th class='warning right aligned'>&#8377;".round($total_total_print_type_coex_avg,2)."</th>
							  	</tr>
							  </thead>";

						echo '</table>';
					}
				?>
				<br/>

				<?php
					//echo $this->db->last_query();
					setlocale(LC_MONETARY, 'en_IN');
					if($print_type_wise_sales_spring==FALSE){

					}else{
						echo '
						<br/>
							<div style="text-align:center;"><i class="plus circle icon"></i></div>
						<br/>
						<table class="ui sortable selectable celled table" style="font-size:10px;">
					        	<thead>
								   <tr>
								    	<th colspan="13"><a class="ui yellow label">SPRING PRINTING SALES</a>'.($from_date!='' && $to_date!='' ? 
								    		' <a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date($from_date,$this->session->userdata['logged_in']['company_id']).'  TO '.$this->common_model->view_date($to_date,$this->session->userdata['logged_in']['company_id']).'</a><br/><br/>' : '');

								    	if(!empty($sleeve_dia_data)){

								    		$arr=explode(",",$sleeve_dia_data);
								    		foreach($arr as $sld){
								    			$sld=str_replace("'","",$sld);
								    			echo '<a class="ui yellow basic label">'.$sld.'</a>';
								    		}

								    		echo "<br/><br/>";
								    	}

								    	if(!empty($inv_type_data)){
								    		
								    		$arr=explode(",",$inv_type_data);
								    		foreach($arr as $inv_type_data_row){
								    			$inv_type_data_row=str_replace("'","",$inv_type_data_row);
								    			echo '<a class="ui blue label">'.$inv_type_data_row.'</a>';
								    		}
								    		echo "<br/><br/>";
								    	}

								    	if(!empty($customer_data)){
								    		
								    	$arr=explode(",",$customer_data);
								    	$i=1;
								    	foreach($arr as $cus){
								    		
								    		echo '<a class="ui grey label">'.$this->common_model->get_customer_name($cus,$this->session->userdata['logged_in']['company_id']).'</a>';
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
					        			<th colspan="3" class="center aligned">FLEXO+DIGITAL+FLEXO</th>
					        			<th colspan="3" class="center aligned">DIGITAL+FLEXO</th>
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
					 $total_flexo_digital_flexo_quantity=0;
					 $total_flexo_digital_flexo_value=0;
					 $total_flexo_digital_flexo_avg=0;
					 $total_flexo_digital_quantity=0;
					 $total_flexo_digital_value=0;
					 $total_flexo_digital_avg=0;
					 $total_total_print_type_quantity=0;
					 $total_total_print_type_value=0;
					 $total_total_print_type_avg=0;
					 $count=0;
					foreach($print_type_wise_sales_spring as $row_coex){
						$flexo_digital_flexo_avg_price=0;
						$flexo_digital_flexo_avg_price=($row_coex->FLEXO_DIGITAL_FLEXO_VALUE!=0 ? $row_coex->FLEXO_DIGITAL_FLEXO_VALUE/$row_coex->FLEXO_DIGITAL_FLEXO : 0);
						$flexo_digital_avg_price=0;
						$flexo_digital_avg_price=($row_coex->FLEXO_DIGITAL_VALUE!=0 ? $row_coex->FLEXO_DIGITAL_VALUE/$row_coex->FLEXO_DIGITAL : 0);
						
						$total_prin_type_quantity=0;
						$total_prin_type_quantity=$row_coex->FLEXO_DIGITAL+$row_coex->FLEXO_DIGITAL_FLEXO;
						$total_print_type_value=0;
						$total_print_type_value=$row_coex->FLEXO_DIGITAL_VALUE+$row_coex->FLEXO_DIGITAL_FLEXO_VALUE;
						$total_print_type_avg_price=0;
						$total_print_type_avg_price=$total_print_type_value/$total_prin_type_quantity;
						echo "<tr>
								<td>".$row_coex->sales_year."-".strtoupper($row_coex->sales_month)."</td>
								<td class='negative right aligned'>".money_format('%!.0n',$row_coex->FLEXO_DIGITAL_FLEXO)."</td>
								<td class='negative right aligned'>".money_format('%.0n',$row_coex->FLEXO_DIGITAL_FLEXO_VALUE)."</td>
								<td class='negative right aligned'>&#8377;".round($flexo_digital_flexo_avg_price,2)."</td>
								<td class='positive right aligned'>".money_format('%!.0n',$row_coex->FLEXO_DIGITAL)."</td>
								<td class='positive right aligned'>".money_format('%.0n',$row_coex->FLEXO_DIGITAL_VALUE)."</td>
								<td class='positive right aligned'>&#8377;".round($flexo_digital_avg_price,2)."</td>
								<td class='warning right aligned'>".money_format('%!.0n',$total_prin_type_quantity)."</td>
								<td class='warning right aligned'>".money_format('%.0n',$total_print_type_value)."</td>
								<td class='warning right aligned'>&#8377;".round($total_print_type_avg_price,2)."</td>
					        </tr>";

					       $total_flexo_digital_flexo_quantity+=$row_coex->FLEXO_DIGITAL_FLEXO;
					       $total_flexo_digital_flexo_value+=$row_coex->FLEXO_DIGITAL_FLEXO_VALUE;
					       $total_flexo_digital_quantity+=$row_coex->FLEXO_DIGITAL;
					       $total_flexo_digital_value+=$row_coex->FLEXO_DIGITAL_VALUE;

					    }
					    $total_flexo_digital_flexo_avg=($total_flexo_digital_flexo_value!=0 ? $total_flexo_digital_flexo_value/$total_flexo_digital_flexo_quantity : '0');
					    $total_flexo_digital_avg=($total_flexo_digital_value!=0 ? $total_flexo_digital_value/$total_flexo_digital_quantity : '0');

					    $total_total_print_type_quantity=$total_flexo_digital_flexo_quantity+$total_flexo_digital_quantity;
					    $total_total_print_type_value=$total_flexo_digital_flexo_value+$total_flexo_digital_value;
					    $total_total_print_type_avg=$total_total_print_type_value/$total_total_print_type_quantity;

					    echo "<thead>
							    <tr>
							    	<th>TOTAL</th>
							    	<th class='negative right aligned'>".money_format('%!.0n',$total_flexo_digital_flexo_quantity)."</th>
							    	<th class='negative right aligned'>".money_format('%.0n',$total_flexo_digital_flexo_value)."</th>
							    	<th class='negative right aligned'>&#8377;".round($total_flexo_digital_flexo_avg,2)."</th>
							    	<th class='positive right aligned'>".money_format('%!.0n',$total_flexo_digital_quantity)."</th>
							    	<th class='positive right aligned'>".money_format('%.0n',$total_flexo_digital_value)."</th>
							    	<th class='positive right aligned'>&#8377;".round($total_flexo_digital_avg,2)."</th>
							    	<th class='warning right aligned'>".money_format('%!.0n',$total_total_print_type_quantity)."</th>
							    	<th class='warning right aligned'>".money_format('%.0n',$total_total_print_type_value)."</th>
							    	<th class='warning right aligned'>&#8377;".round($total_total_print_type_avg,2)."</th>
							  	</tr>
							  </thead>";

						echo '</table>';
					}
				?>
				<?php
					setlocale(LC_MONETARY, 'en_IN');
					if($print_type_wise_sales_coex==FALSE || $print_type_wise_sales_spring==FALSE){

					}else{
						echo '<br/>
								<div style="text-align:center;"><i class="bars icon"></i></div>
								<br/>
								<div class="ui two column centered grid">
								<div class="column">
								<table class="ui sortable selectable celled table" style="font-size:10px;">
					        	<thead>
					        		<tr>
								   		<th>TUBE SALES</th>
								    	<th>MONTH-YEAR</th>
								    	<th>QUANTITY</th>
								    	<th>VALUE</th>
								    	<th>AVG PRICE</th>
								  	</tr>
								  </thead>
								  <tbody>
								   <tr>
								   		<td>COEX SALES</td>
								    	<td>'.$from_date.'-'.$to_date.'</td>
								    	<td>'.money_format('%!.0n',$total_total_print_type_coex_quantity).'</td>
								    	<td>'.money_format('%.0n',$total_total_print_type_coex_value).'</td>
								    	<td>&#8377;'.round($total_total_print_type_coex_avg,2).'</td>
								  	</tr>

								  	<tr>
								   		<td>SPRING SALES</td>
								    	<td>'.$from_date.'-'.$to_date.'</td>
								    	<td>'.money_format('%!.0n',$total_total_print_type_quantity).'</td>
								    	<td>'.money_format('%.0n',$total_total_print_type_value).'</td>
								    	<td>&#8377;'.round($total_total_print_type_avg,2).'</td>
								  	</tr></tbody>';
								  	$avg=($total_total_print_type_value+$total_total_print_type_coex_value)/($total_total_print_type_quantity+$total_total_print_type_coex_quantity);
								 echo '<thead>
								 		<tr>
								   		<th>TOTAL SALES</th>
								    	<th></th>
								    	<th>'.money_format('%!.0n',$total_total_print_type_quantity+$total_total_print_type_coex_quantity).'</th>
								    	<th>'.money_format('%.0n',$total_total_print_type_value+$total_total_print_type_coex_value).'</th>
								    	<th>&#8377;'.round($avg,2).'</th>
								  		</tr>
								  		</thead>
								  	</table>
								  </div>
								</div>';
					}*/
					?>