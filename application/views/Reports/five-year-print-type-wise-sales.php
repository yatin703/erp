<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/0.16.1/javascript/semantic.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.address/1.6/jquery.address.min.js"></script>
<script>
	$(document).ready(function(){
		$('.menu .item').tab();
		});
</script>

<div class="record_form_design">
	<div class="record_inner_design" style="overflow: scroll;">
		<div class="row">
			<div class="column">
				<div class="ui top attached tabular menu">
				  <a class="red item"  data-tab="first">JAN - DEC in INR</a>
				  <a class="orange item" data-tab="second">JAN - DEC in MIILLIONS</a>
				</div>

				<div class="ui bottom attached tab segment" data-tab="first" >
					<?php
					setlocale(LC_MONETARY, 'en_IN');
					if($sales_five_year_print_type_wise==FALSE){

					}else{
						echo '<table class="ui sortable selectable celled table" style="font-size:10px;">
					        	<thead>
								   <tr>
								    	<th colspan="20"><a class="ui orange label">5 YEAR SALES YEARWISE JAN TO DEC</a></th>
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
					        			<th colspan="3" class="center aligned">YEAR WISE TOTAL</th>
					        		</tr>
					        		<tr>
					        			<th>SR NO</th>
					        			<th>YEAR</th>
					        			<th class="active right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG P</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG P</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG P</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG P</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG P</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG P</th>
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
					foreach($sales_five_year_print_type_wise as $row_coex){
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
								<td><b>".$row_coex->sales_year." JAN - DEC</b></td>
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
					    $total_total_print_type_coex_avg=$total_total_print_type_coex_value/$total_total_print_type_coex_quantity;

					    $total_total_print_type_sales_quantity=$total_screen_flexo_quantity+$total_offset_quantity+$total_label_quantity+$total_digital_quantity;
					    $total_total_print_type_sales_value=$total_screen_flexo_value+$total_offset_value+$total_label_value+$total_digital_value;
					    $total_total_print_type_sales_avg=$total_total_print_type_sales_value/$total_total_print_type_sales_quantity;
					    /*
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
							  </thead>";*/

						echo '</table>';

					}
				?>
			</div>
			<div class="ui bottom attached tab segment" data-tab="second" style="overflow: scroll;">
					<?php
					setlocale(LC_MONETARY, 'en_IN');
					if($sales_five_year_print_type_wise==FALSE){

					}else{
						echo '<table class="ui sortable selectable celled table" style="font-size:10px;">
					        	<thead>
								   <tr>
								    	<th colspan="20"><a class="ui orange label">5 YEAR SALES YEARWISE JAN TO DEC in MILLIONS</a></th>
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
					        			<th colspan="3" class="center aligned">YEAR WISE TOTAL</th>
					        		</tr>
					        		<tr>
					        			<th>SR NO</th>
					        			<th>YEAR</th>
					        			<th class="active right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG P</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG P</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG P</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG P</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG P</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG P</th>
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
					foreach($sales_five_year_print_type_wise as $row_coex){
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
								<td><b>".$row_coex->sales_year." JAN - DEC</b></td>
								<td class='negative right aligned'>".$this->common_model->read_number_million($row_coex->SCREEN_FLEXO)."</td>
								<td class='negative right aligned'>".$this->common_model->read_number_million($row_coex->SCREEN_FLEXO_VALUE)."</td>
								<td class='negative right aligned'>&#8377;".round($screen_flexo_avg_price,2)."</td>
								<td class='positive right aligned'>".$this->common_model->read_number_million($row_coex->OFFSET)."</td>
								<td class='positive right aligned'>".$this->common_model->read_number_million($row_coex->OFFSET_VALUE)."</td>
								<td class='positive right aligned'>&#8377;".round($offset_avg_price,2)."</td>
								<td class='right aligned'>".$this->common_model->read_number_million($row_coex->LABEL)."</td>
								<td class='right aligned'>".$this->common_model->read_number_million($row_coex->LABEL_VALUE)."</td>
								<td class='right aligned'>&#8377;".round($label_avg_price,2)."</td>

								<td class='active right aligned'>".$this->common_model->read_number_million($total_prin_type_coex_quantity)."</td>
								<td class='active right aligned'>".$this->common_model->read_number_million($total_print_type_coex_value)."</td>
								<td class='active right aligned'>&#8377;".round($total_print_type_coex_avg_price,2)."</td>

								<td class='negative right aligned'>".$this->common_model->read_number_million($row_coex->DIGITAL)."</td>
								<td class='negative right aligned'>".$this->common_model->read_number_million($row_coex->DIGITAL_VALUE)."</td>
								<td class='negative right aligned'>&#8377;".round($digital_avg_price,2)."</td>

								<td class='active warning right aligned'>".$this->common_model->read_number_million($total_prin_type_quantity)."</td>
								<td class='active warning right aligned'>".$this->common_model->read_number_million($total_print_type_value)."</td>
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
					    $total_total_print_type_coex_avg=$total_total_print_type_coex_value/$total_total_print_type_coex_quantity;

					    $total_total_print_type_sales_quantity=$total_screen_flexo_quantity+$total_offset_quantity+$total_label_quantity+$total_digital_quantity;
					    $total_total_print_type_sales_value=$total_screen_flexo_value+$total_offset_value+$total_label_value+$total_digital_value;
					    $total_total_print_type_sales_avg=$total_total_print_type_sales_value/$total_total_print_type_sales_quantity;
					    /*
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
							  </thead>";*/

						echo '</table>';

					}
				?>
			</div>
			</div>
  		</div>
	</div>
</div>