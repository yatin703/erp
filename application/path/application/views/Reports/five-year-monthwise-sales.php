<!--
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
  -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/0.16.1/javascript/semantic.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.address/1.6/jquery.address.min.js"></script>
<script>
	$(document).ready(function(){

		$('.menu .item').tab();

		$("#exporttoexcel_apr_mar").click(function(e){
		//alert(1);
		var pefix='5 years sales monthwise';
		var a = document.createElement('a');
		var data_type='data:application/vnd.ms-excel';
		var table_html=encodeURIComponent( $('#check').html());
		//alert(table_html);
		a.href = data_type + ', ' + table_html;
		a.download = pefix + '.xls';
		a.click();
		e.preventDefault();
		});

});
</script>
		
	
	


<div class="record_form_design">
	<div class="record_inner_design" style="overflow: scroll;">
		<div class="row">
			<div class="column">
				<div class="ui top attached tabular menu">
				  <a class="red item"  data-tab="first">APR - MAR in INR</a>
				  <a class="orange item" data-tab="second">JAN - DEC in INR</a>
				  <a class="red item"  data-tab="third">APR - MAR in Millions</a>
				  <a class="red item"  data-tab="four">JAN - DEC in Millions</a>
				</div>
				<div class="ui bottom attached tab segment active" data-tab="first">
				<span id="check">
					<?php
					setlocale(LC_MONETARY, 'en_IN');
					if($sales_apr_march_yearwise==FALSE){

					}else{
						echo '<table class="ui selectable celled table" style="font-size:10px;">
					        	<thead>
								   <tr>
								    	<th colspan="20"><a class="ui orange label">5 YEAR SALES MONTHWISE APR TO MAR</a></th>
								  </tr>
					        	  <tr>
					        			<th colspan="2"></th>
					        			<th colspan="3" class="center aligned">2016-17</th>
					        			<th colspan="3" class="center aligned">2017-18</th>
					        			<th colspan="3" class="center aligned">2018-19</th>
					        			<th colspan="3" class="center aligned">2019-20</th>
					        			<th colspan="3" class="center aligned">2020-21</th>
					        	  </tr>
								  
					        		<tr>
					        			<th>SR NO</th>
					        			<th>MONTH</th>
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
					 $i=1;
					 $total_quantity_fifteen_sixteen=0;
					 $total_value_fifteen_sixteen=0;
					 $total_avg_fifteen_sixteen=0;

					 $total_quantity_sixteen_seventeen=0;
					 $total_value_sixteen_seventeen=0;
					 $total_avg_sixteen_seventeen=0;

					 $total_quantity_seventeen_eighteen=0;
					 $total_value_seventeen_eighteen=0;
					 $total_avg_seventeen_eighteen=0;

					 $total_quantity_eighteen_nineteen=0;
					 $total_value_eighteen_nineteen=0;
					 $total_avg_eighteen_nineteen=0;

					 $total_quantity_nineteen_twenty=0;
					 $total_value_nineteen_twenty=0;
					 $total_avg_nineteen_twenty=0;

					 $total_quantity_twenty_twentyone=0;
					 $total_value_twenty_twentyone=0;
					 $total_avg_twenty_twentyone=0;

					 $chart_data = '';
					foreach($sales_apr_march_yearwise as $row){
						$avg_row_fifteen_sixteen=0;
						$avg_row_fifteen_sixteen=($row->value_fifteen_sixteen<>0 ? ($row->value_fifteen_sixteen/$row->quantity_fifteen_sixteen) : 0 );

						$avg_row_sixteen_seventeen=0;
						$avg_row_sixteen_seventeen=($row->value_sixteen_seventeen<>0 ? ($row->value_sixteen_seventeen/$row->quantity_sixteen_seventeen) : 0 );

						$avg_row_seventeen_eighteen=0;
						$avg_row_seventeen_eighteen=($row->value_seventeen_eighteen<>0 ? ($row->value_seventeen_eighteen/$row->quantity_seventeen_eighteen) : 0 );

						$avg_row_eighteen_nineteen=0;
						$avg_row_eighteen_nineteen=($row->value_eighteen_nineteen<>0 ? ($row->value_eighteen_nineteen/$row->quantity_eighteen_nineteen) : 0 );

						$avg_row_nineteen_twenty=0;
						$avg_row_nineteen_twenty=($row->value_nineteen_twenty<>0 ? ($row->value_nineteen_twenty/$row->quantity_nineteen_twenty) : 0 );

						$avg_row_twenty_twentyone=0;
						$avg_row_twenty_twentyone=($row->value_twenty_twentyone<>0 ? ($row->value_twenty_twentyone/$row->quantity_twenty_twentyone) : 0 );


						echo "<tr>
								<td>$i</td>
								<td><b>".strtoupper($row->sales_month)."</b></td>


								<td class='positive right aligned'>".money_format('%!.0n',$row->quantity_sixteen_seventeen)."</td>
								<td class='positive right aligned'>".money_format('%.0n',$row->value_sixteen_seventeen)."</td>
								<td class='positive right aligned'>&#8377;".round($avg_row_sixteen_seventeen,2)."</td>

								<td class='warning right aligned'>".money_format('%!.0n',$row->quantity_seventeen_eighteen)."</td>
								<td class='warning right aligned'>".money_format('%.0n',$row->value_seventeen_eighteen)."</td>
								<td class='warning right aligned'>&#8377;".round($avg_row_seventeen_eighteen,2)."</td>

								<td class='negative right aligned'>".money_format('%!.0n',$row->quantity_eighteen_nineteen)."</td>
								<td class='negative right aligned'>".money_format('%.0n',$row->value_eighteen_nineteen)."</td>
								<td class='negative right aligned'>&#8377;".round($avg_row_eighteen_nineteen,2)."</td>

								<td class='positive right aligned'>".money_format('%!.0n',$row->quantity_nineteen_twenty)."</td>
								<td class='positive right aligned'>".money_format('%.0n',$row->value_nineteen_twenty)."</td>
								<td class='positive right aligned'>&#8377;".round($avg_row_nineteen_twenty,2)."</td>

								<td class='warning right aligned'>".money_format('%!.0n',$row->quantity_twenty_twentyone)."</td>
								<td class='warning right aligned'>".money_format('%.0n',$row->value_twenty_twentyone)."</td>
								<td class='warning right aligned'>&#8377;".round($avg_row_twenty_twentyone,2)."</td>

					        </tr>";

					        $total_quantity_fifteen_sixteen+=$row->quantity_fifteen_sixteen;
					 		$total_value_fifteen_sixteen+=$row->value_fifteen_sixteen;

					 		$total_quantity_sixteen_seventeen+=$row->quantity_sixteen_seventeen;
					 		$total_value_sixteen_seventeen+=$row->value_sixteen_seventeen;

					 		$total_quantity_seventeen_eighteen+=$row->quantity_seventeen_eighteen;
					 		$total_value_seventeen_eighteen+=$row->value_seventeen_eighteen;
					 		
					 		$total_quantity_eighteen_nineteen+=$row->quantity_eighteen_nineteen;
					 		$total_value_eighteen_nineteen+=$row->value_eighteen_nineteen;

					 		$total_quantity_nineteen_twenty+=$row->quantity_nineteen_twenty;
					 		$total_value_nineteen_twenty+=$row->value_nineteen_twenty;
					 		
					 		$total_quantity_twenty_twentyone+=$row->quantity_twenty_twentyone;
					 		$total_value_twenty_twentyone+=$row->value_twenty_twentyone;
					 		

					 		$chart_data .= "{ y:'".$row->month_no."', QUANTITY_15_16:".$row->quantity_fifteen_sixteen.", QUANTITY_16_17:".$row->quantity_sixteen_seventeen.",
					 			QUANTITY_17_18:".$row->quantity_seventeen_eighteen.",
					 			QUANTITY_18_19:".$row->quantity_eighteen_nineteen.",
					 			QUANTITY_19_20:".$row->quantity_nineteen_twenty."
					 			QUANTITY_20_21:".$row->quantity_twenty_twentyone."
					 		}, ";
							$i++;
					    }

					    $chart_data = substr($chart_data, 0, -2);

					    $total_avg_fifteen_sixteen=($total_value_fifteen_sixteen<>0 ? ($total_value_fifteen_sixteen/$total_quantity_fifteen_sixteen) : 0);

					    $total_avg_sixteen_seventeen=($total_value_sixteen_seventeen<>0 ? ($total_value_sixteen_seventeen/$total_quantity_sixteen_seventeen) : 0);

					    $total_avg_seventeen_eighteen=($total_value_seventeen_eighteen<>0 ? ($total_value_seventeen_eighteen/$total_quantity_seventeen_eighteen) : 0);
					    
					    $total_avg_eighteen_nineteen=($total_value_eighteen_nineteen<>0 ? ($total_value_eighteen_nineteen/$total_quantity_eighteen_nineteen) : 0);

					    $total_avg_nineteen_twenty=($total_value_nineteen_twenty<>0 ? ($total_value_nineteen_twenty/$total_quantity_nineteen_twenty) : 0);


					    $total_avg_twenty_twentyone=($total_value_twenty_twentyone<>0 ? ($total_value_twenty_twentyone/$total_quantity_twenty_twentyone) : 0);

					    echo "<thead>
							    <tr>
							    	<th colspan='2'>TOTAL</th>
							    	
							    	<th class='negative right aligned'>".money_format('%!.0n',$total_quantity_sixteen_seventeen)."</th>
							    	<th class='negative right aligned'>".money_format('%.0n',$total_value_sixteen_seventeen)."</th>
							    	<th class='negative right aligned'>&#8377;".round($total_avg_sixteen_seventeen,2)."</th>

							    	<th class='negative right aligned'>".money_format('%!.0n',$total_quantity_seventeen_eighteen)."</th>
							    	<th class='negative right aligned'>".money_format('%.0n',$total_value_seventeen_eighteen)."</th>
							    	<th class='negative right aligned'>&#8377;".round($total_avg_seventeen_eighteen,2)."</th>

							    	<th class='negative right aligned'>".money_format('%!.0n',$total_quantity_eighteen_nineteen)."</th>
							    	<th class='negative right aligned'>".money_format('%.0n',$total_value_eighteen_nineteen)."</th>
							    	<th class='negative right aligned'>&#8377;".round($total_avg_eighteen_nineteen,2)."</th>

							    	<th class='negative right aligned'>".money_format('%!.0n',$total_quantity_nineteen_twenty)."</th>
							    	<th class='negative right aligned'>".money_format('%.0n',$total_value_nineteen_twenty)."</th>
							    	<th class='negative right aligned'>&#8377;".round($total_avg_nineteen_twenty,2)."</th>

							    	<th class='warning right aligned'>".money_format('%!.0n',$total_quantity_twenty_twentyone)."</th>
							    	<th class='warning right aligned'>".money_format('%.0n',$total_value_twenty_twentyone)."</th>
							    	<th class='warning right aligned'>&#8377;".round($total_avg_twenty_twentyone,2)."</th>


							  	</tr>
							  </thead>";

						echo '</table>
						';

					}
				?>
				<!--
				<button class="ui primary button" id="exporttoexcel_apr_mar">EXCEL</button>-->
				</span>
				</div>
				<div class="ui bottom attached tab segment" data-tab="second">
  					<?php
					setlocale(LC_MONETARY, 'en_IN');
					if($sales_jan_dec_yearwise==FALSE){

					}else{
						echo '<table class="ui selectable celled table" style="font-size:10px;">
					        	<thead>
								   <tr>
								    	<th colspan="20"><a class="ui orange label">5 YEAR SALES MONTHWISE JAN TO DEC</a></th>
								  </tr>

					        	  <tr>
					        			<th colspan="2"></th>
					        			<th colspan="3" class="center aligned">2017</th>
					        			<th colspan="3" class="center aligned">2018</th>
					        			<th colspan="3" class="center aligned">2019</th>
					        			<th colspan="3" class="center aligned">2020</th>
										<th colspan="3" class="center aligned">2021</th>					        			
					        	  </tr>
								  
					        		<tr>
					        			<th>SR NO</th>
					        			<th>MONTH</th>
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
					        	</thead>';
					 $i=1;
					 $total_quantity16=0;
					 $total_value16=0;
					 $total_avg16=0;

					 $total_quantity17=0;
					 $total_value17=0;
					 $total_avg17=0;

					 $total_quantity18=0;
					 $total_value18=0;
					 $total_avg18=0;


					 $total_quantity19=0;
					 $total_value19=0;
					 $total_avg19=0;

					 $total_quantity20=0;
					 $total_value20=0;
					 $total_avg20=0;

					 $total_quantity21=0;
					 $total_value21=0;
					 $total_avg21=0;

					foreach($sales_jan_dec_yearwise as $row){
						echo "<tr>
								<td>$i</td>
								<td><b>".strtoupper($row->sales_month)."</b></td>

								
								<td class='positive right aligned'>".money_format('%!.0n',$row->quantity17)."</td>
								<td class='positive right aligned'>".money_format('%.0n',$row->value17)."</td>
								<td class='positive right aligned'>&#8377;$row->avg17</td>

								<td class='warning right aligned'>".money_format('%!.0n',$row->quantity18)."</td>
								<td class='warning right aligned'>".money_format('%.0n',$row->value18)."</td>
								<td class='warning right aligned'>&#8377;$row->avg18</td>

								<td class='negative right aligned'>".money_format('%!.0n',$row->quantity19)."</td>
								<td class='negative right aligned'>".money_format('%.0n',$row->value19)."</td>
								<td class='negative right aligned'>&#8377;$row->avg19</td>

								<td class='positive right aligned'>".money_format('%!.0n',$row->quantity20)."</td>
								<td class='positive right aligned'>".money_format('%.0n',$row->value20)."</td>
								<td class='positive right aligned'>".($row->avg20<>0 ? "&#8377;$row->avg20" : "&#8377;0")."</td>

								<td class='warning right aligned'>".money_format('%!.0n',$row->quantity21)."</td>
								<td class='warning right aligned'>".money_format('%.0n',$row->value21)."</td>
								<td class='warning right aligned'>&#8377;$row->avg21</td>


					        </tr>";
					        $total_quantity16+=$row->quantity16;
					        $total_quantity17+=$row->quantity17;
					        $total_quantity18+=$row->quantity18;
					        $total_quantity19+=$row->quantity19;
					        $total_quantity20+=$row->quantity20;
					        $total_quantity21+=$row->quantity21;

					        $total_value16+=$row->value16;
					        $total_value17+=$row->value17;
					        $total_value18+=$row->value18;
					        $total_value19+=$row->value19;
					        $total_value20+=$row->value20;
					        $total_value21+=$row->value21;


							$i++;
					    }
					    $total_avg16=($total_value16<>0 ? ($total_value16/$total_quantity16) : 0);
					    $total_avg17=($total_value17<>0 ? ($total_value17/$total_quantity17) : 0);
					    $total_avg18=($total_value18<>0 ? ($total_value18/$total_quantity18) : 0);
					    $total_avg19=($total_value19<>0 ? ($total_value19/$total_quantity19) : 0);
					    $total_avg20=($total_value20<>0 ? ($total_value20/$total_quantity20) : 0);
						$total_avg21=($total_value21<>0 ? ($total_value21/$total_quantity21) : 0);

					    echo "<thead>
							    <tr>
							    	<th colspan='2'>TOTAL</th>

							    	<th class='negative right aligned'>".money_format('%!.0n',$total_quantity17)."</th>
							    	<th class='negative right aligned'>".money_format('%.0n',$total_value17)."</th>
							    	<th class='negative right aligned'>&#8377;".round($total_avg17,2)."</th>

							    	<th class='negative right aligned'>".money_format('%!.0n',$total_quantity18)."</th>
							    	<th class='negative right aligned'>".money_format('%.0n',$total_value18)."</th>
							    	<th class='negative right aligned'>&#8377;".round($total_avg18,2)."</th>

							    	<th class='negative right aligned'>".money_format('%!.0n',$total_quantity19)."</th>
							    	<th class='negative right aligned'>".money_format('%.0n',$total_value19)."</th>
							    	<th class='negative right aligned'>&#8377;".round($total_avg19,2)."</th>

							    	<th class='negative right aligned'>".money_format('%!.0n',$total_quantity20)."</th>
							    	<th class='negative right aligned'>".money_format('%.0n',$total_value20)."</th>
							    	<th class='negative right aligned'>&#8377;".round($total_avg20,2)."</th>

							    	<th class='negative right aligned'>".money_format('%!.0n',$total_quantity21)."</th>
							    	<th class='negative right aligned'>".money_format('%.0n',$total_value21)."</th>
							    	<th class='negative right aligned'>&#8377;".round($total_avg21,2)."</th>
							    
							    </tr>
							  </thead>";

						echo '</table>';

					}
				?>
				
				</div>
				<div class="ui bottom attached tab segment active" data-tab="third">
				<span id="check">
					<?php
					setlocale(LC_MONETARY, 'en_IN');
					if($sales_apr_march_yearwise==FALSE){

					}else{
						echo '<table class="ui selectable celled table" style="font-size:10px;">
					        	<thead>
								   <tr>
								    	<th colspan="20"><a class="ui orange label">5 YEAR SALES MONTHWISE APR TO MAR</a></th>
								  </tr>
					        	  <tr>
					        			<th colspan="2"></th>
					        			<th colspan="3" class="center aligned">2016-17</th>
					        			<th colspan="3" class="center aligned">2017-18</th>
					        			<th colspan="3" class="center aligned">2018-19</th>
					        			<th colspan="3" class="center aligned">2019-20</th>
					        			<th colspan="3" class="center aligned">2020-21</th>
					        			
					        	  </tr>
								  
					        		<tr>
					        			<th>SR NO</th>
					        			<th>MONTH</th>
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
					        	</thead>';
					 $i=1;
					 $total_quantity_fifteen_sixteen=0;
					 $total_value_fifteen_sixteen=0;
					 $total_avg_fifteen_sixteen=0;

					 $total_quantity_sixteen_seventeen=0;
					 $total_value_sixteen_seventeen=0;
					 $total_avg_sixteen_seventeen=0;

					 $total_quantity_seventeen_eighteen=0;
					 $total_value_seventeen_eighteen=0;
					 $total_avg_seventeen_eighteen=0;

					 $total_quantity_eighteen_nineteen=0;
					 $total_value_eighteen_nineteen=0;
					 $total_avg_eighteen_nineteen=0;

					 $total_quantity_nineteen_twenty=0;
					 $total_value_nineteen_twenty=0;
					 $total_avg_nineteen_twenty=0;

					 $total_quantity_twenty_twentyone=0;
					 $total_value_twenty_twentyone=0;
					 $total_avg_twenty_twentyone=0;

					 $chart_data = '';
					foreach($sales_apr_march_yearwise as $row){
						$avg_row_fifteen_sixteen=0;
						$avg_row_fifteen_sixteen=($row->value_fifteen_sixteen<>0 ? ($row->value_fifteen_sixteen/$row->quantity_fifteen_sixteen) : 0 );

						$avg_row_sixteen_seventeen=0;
						$avg_row_sixteen_seventeen=($row->value_sixteen_seventeen<>0 ? ($row->value_sixteen_seventeen/$row->quantity_sixteen_seventeen) : 0 );

						$avg_row_seventeen_eighteen=0;
						$avg_row_seventeen_eighteen=($row->value_seventeen_eighteen<>0 ? ($row->value_seventeen_eighteen/$row->quantity_seventeen_eighteen) : 0 );

						$avg_row_eighteen_nineteen=0;
						$avg_row_eighteen_nineteen=($row->value_eighteen_nineteen<>0 ? ($row->value_eighteen_nineteen/$row->quantity_eighteen_nineteen) : 0 );

						$avg_row_nineteen_twenty=0;
						$avg_row_nineteen_twenty=($row->value_nineteen_twenty<>0 ? ($row->value_nineteen_twenty/$row->quantity_nineteen_twenty) : 0 );

						$avg_row_twenty_twentyone=0;
						$avg_row_twenty_twentyone=($row->value_twenty_twentyone<>0 ? ($row->value_twenty_twentyone/$row->quantity_twenty_twentyone) : 0 );

						echo "<tr>
								<td>$i</td>
								<td><b>".strtoupper($row->sales_month)."</b></td>


								<td class='positive right aligned'>".$this->common_model->read_number_million($row->quantity_sixteen_seventeen)."</td>
								<td class='positive right aligned'>".$this->common_model->read_number_million($row->value_sixteen_seventeen)."</td>
								<td class='positive right aligned'>&#8377;".round($avg_row_sixteen_seventeen,2)."</td>

								<td class='warning right aligned'>".$this->common_model->read_number_million($row->quantity_seventeen_eighteen)."</td>
								<td class='warning right aligned'>".$this->common_model->read_number_million($row->value_seventeen_eighteen)."</td>
								<td class='warning right aligned'>&#8377;".round($avg_row_seventeen_eighteen,2)."</td>

								<td class='negative right aligned'>".$this->common_model->read_number_million($row->quantity_eighteen_nineteen)."</td>
								<td class='negative right aligned'>".$this->common_model->read_number_million($row->value_eighteen_nineteen)."</td>
								<td class='negative right aligned'>&#8377;".round($avg_row_eighteen_nineteen,2)."</td>

								<td class='positive right aligned'>".$this->common_model->read_number_million($row->quantity_nineteen_twenty)."</td>
								<td class='positive right aligned'>".$this->common_model->read_number_million($row->value_nineteen_twenty)."</td>
								<td class='positive right aligned'>&#8377;".round($avg_row_nineteen_twenty,2)."</td>

								<td class='negative right aligned'>".$this->common_model->read_number_million($row->quantity_twenty_twentyone)."</td>
								<td class='negative right aligned'>".$this->common_model->read_number_million($row->value_twenty_twentyone)."</td>
								<td class='negative right aligned'>&#8377;".round($avg_row_twenty_twentyone,2)."</td>

					        </tr>";

					        $total_quantity_fifteen_sixteen+=$row->quantity_fifteen_sixteen;
					 		$total_value_fifteen_sixteen+=$row->value_fifteen_sixteen;

					 		$total_quantity_sixteen_seventeen+=$row->quantity_sixteen_seventeen;
					 		$total_value_sixteen_seventeen+=$row->value_sixteen_seventeen;

					 		$total_quantity_seventeen_eighteen+=$row->quantity_seventeen_eighteen;
					 		$total_value_seventeen_eighteen+=$row->value_seventeen_eighteen;
					 		
					 		$total_quantity_eighteen_nineteen+=$row->quantity_eighteen_nineteen;
					 		$total_value_eighteen_nineteen+=$row->value_eighteen_nineteen;

					 		$total_quantity_nineteen_twenty+=$row->quantity_nineteen_twenty;
					 		$total_value_nineteen_twenty+=$row->value_nineteen_twenty;

					 		$total_quantity_twenty_twentyone+=$row->quantity_twenty_twentyone;
					 		$total_value_twenty_twentyone+=$row->value_twenty_twentyone;
					 		

					 		$chart_data .= "{ y:'".$row->month_no."', QUANTITY_15_16:".$row->quantity_fifteen_sixteen.", QUANTITY_16_17:".$row->quantity_sixteen_seventeen.",
					 			QUANTITY_17_18:".$row->quantity_seventeen_eighteen.",
					 			QUANTITY_18_19:".$row->quantity_eighteen_nineteen.",
					 			QUANTITY_19_20:".$row->quantity_nineteen_twenty."
					 		}, ";
							$i++;
					    }

					    $chart_data = substr($chart_data, 0, -2);

					    $total_avg_fifteen_sixteen=($total_value_fifteen_sixteen<>0 ? ($total_value_fifteen_sixteen/$total_quantity_fifteen_sixteen) : 0);

					    $total_avg_sixteen_seventeen=($total_value_sixteen_seventeen<>0 ? ($total_value_sixteen_seventeen/$total_quantity_sixteen_seventeen) : 0);

					    $total_avg_seventeen_eighteen=($total_value_seventeen_eighteen<>0 ? ($total_value_seventeen_eighteen/$total_quantity_seventeen_eighteen) : 0);
					    
					    $total_avg_eighteen_nineteen=($total_value_eighteen_nineteen<>0 ? ($total_value_eighteen_nineteen/$total_quantity_eighteen_nineteen) : 0);

					    $total_avg_nineteen_twenty=($total_value_nineteen_twenty<>0 ? ($total_value_nineteen_twenty/$total_quantity_nineteen_twenty) : 0);

					    $total_avg_twenty_twentyone=($total_value_twenty_twentyone<>0 ? ($total_value_twenty_twentyone/$total_quantity_twenty_twentyone) : 0);

					    echo "<thead>
							    <tr>
							    	<th colspan='2'>TOTAL</th>
							    	

							    	<th class='negative right aligned'>".$this->common_model->read_number_million($total_quantity_sixteen_seventeen)."</th>
							    	<th class='negative right aligned'>".$this->common_model->read_number_million($total_value_sixteen_seventeen)."</th>
							    	<th class='negative right aligned'>&#8377;".round($total_avg_sixteen_seventeen,2)."</th>

							    	<th class='negative right aligned'>".$this->common_model->read_number_million($total_quantity_seventeen_eighteen)."</th>
							    	<th class='negative right aligned'>".$this->common_model->read_number_million($total_value_seventeen_eighteen)."</th>
							    	<th class='negative right aligned'>&#8377;".round($total_avg_seventeen_eighteen,2)."</th>

							    	<th class='negative right aligned'>".$this->common_model->read_number_million($total_quantity_eighteen_nineteen)."</th>
							    	<th class='negative right aligned'>".$this->common_model->read_number_million($total_value_eighteen_nineteen)."</th>
							    	<th class='negative right aligned'>&#8377;".round($total_avg_eighteen_nineteen,2)."</th>

							    	<th class='negative right aligned'>".$this->common_model->read_number_million($total_quantity_nineteen_twenty)."</th>
							    	<th class='negative right aligned'>".$this->common_model->read_number_million($total_value_nineteen_twenty)."</th>
							    	<th class='negative right aligned'>&#8377;".round($total_avg_nineteen_twenty,2)."</th>

							    	<th class='negative right aligned'>".$this->common_model->read_number_million($total_quantity_twenty_twentyone)."</th>
							    	<th class='negative right aligned'>".$this->common_model->read_number_million($total_value_twenty_twentyone)."</th>
							    	<th class='negative right aligned'>&#8377;".round($total_avg_twenty_twentyone,2)."</th>

							  	</tr>
							  </thead>";

						echo '</table>
						';

					}
				?>
				<!--
				<button class="ui primary button" id="exporttoexcel_apr_mar">EXCEL</button>-->
				</span>
				</div>
				<div class="ui bottom attached tab segment" data-tab="four">
  					<?php
					setlocale(LC_MONETARY, 'en_IN');
					if($sales_jan_dec_yearwise==FALSE){

					}else{
						echo '<table class="ui selectable celled table" style="font-size:10px;">
					        	<thead>
								   <tr>
								    	<th colspan="20"><a class="ui orange label">5 YEAR SALES MONTHWISE JAN TO DEC</a></th>
								  </tr>

					        	  <tr>
					        			<th colspan="2"></th>
					        			<th colspan="3" class="center aligned">2017</th>
					        			<th colspan="3" class="center aligned">2018</th>
					        			<th colspan="3" class="center aligned">2019</th>
					        			<th colspan="3" class="center aligned">2020</th>
					        			<th colspan="3" class="center aligned">2021</th>
					        	  </tr>
								  
					        		<tr>
					        			<th>SR NO</th>
					        			<th>MONTH</th>
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
					        	</thead>';
					 $i=1;
					 $total_quantity16=0;
					 $total_value16=0;
					 $total_avg16=0;

					 $total_quantity17=0;
					 $total_value17=0;
					 $total_avg17=0;

					 $total_quantity18=0;
					 $total_value18=0;
					 $total_avg18=0;


					 $total_quantity19=0;
					 $total_value19=0;
					 $total_avg19=0;

					 $total_quantity20=0;
					 $total_value20=0;
					 $total_avg20=0;

					 $total_quantity21=0;
					 $total_value21=0;
					 $total_avg21=0;

					foreach($sales_jan_dec_yearwise as $row){
						echo "<tr>
								<td>$i</td>
								<td><b>".strtoupper($row->sales_month)."</b></td>

								<td class='positive right aligned'>".$this->common_model->read_number_million($row->quantity17)."</td>
								<td class='positive right aligned'>".$this->common_model->read_number_million($row->value17)."</td>
								<td class='positive right aligned'>&#8377;$row->avg17</td>

								<td class='warning right aligned'>".$this->common_model->read_number_million($row->quantity18)."</td>
								<td class='warning right aligned'>".$this->common_model->read_number_million($row->value18)."</td>
								<td class='warning right aligned'>&#8377;$row->avg18</td>

								<td class='negative right aligned'>".$this->common_model->read_number_million($row->quantity19)."</td>
								<td class='negative right aligned'>".$this->common_model->read_number_million($row->value19)."</td>
								<td class='negative right aligned'>&#8377;$row->avg19</td>

								<td class='positive right aligned'>".$this->common_model->read_number_million($row->quantity20)."</td>
								<td class='positive right aligned'>".$this->common_model->read_number_million($row->value20)."</td>
								<td class='positive right aligned'>".($row->avg20<>0 ? "&#8377;$row->avg20" : "&#8377;0")."</td>

								<td class='negative right aligned'>".$this->common_model->read_number_million($row->quantity21)."</td>
								<td class='negative right aligned'>".$this->common_model->read_number_million($row->value21)."</td>
								<td class='negative right aligned'>&#8377;$row->avg21</td>

					        </tr>";
					        $total_quantity16+=$row->quantity16;
					        $total_quantity17+=$row->quantity17;
					        $total_quantity18+=$row->quantity18;
					        $total_quantity19+=$row->quantity19;
					        $total_quantity20+=$row->quantity20;
					        $total_quantity21+=$row->quantity21;

					        $total_value16+=$row->value16;
					        $total_value17+=$row->value17;
					        $total_value18+=$row->value18;
					        $total_value19+=$row->value19;
					        $total_value20+=$row->value20;
					        $total_value21+=$row->value21;


							$i++;
					    }
					    $total_avg16=($total_value16<>0 ? ($total_value16/$total_quantity16) : 0);
					    $total_avg17=($total_value17<>0 ? ($total_value17/$total_quantity17) : 0);
					    $total_avg18=($total_value18<>0 ? ($total_value18/$total_quantity18) : 0);
					    $total_avg19=($total_value19<>0 ? ($total_value19/$total_quantity19) : 0);
					    $total_avg20=($total_value20<>0 ? ($total_value20/$total_quantity20) : 0);
					    $total_avg21=($total_value21<>0 ? ($total_value21/$total_quantity21) : 0);

					    echo "<thead>
							    <tr>
							    	<th colspan='2'>TOTAL</th>
							    	

							    	<th class='negative right aligned'>".$this->common_model->read_number_million($total_quantity17)."</th>
							    	<th class='negative right aligned'>".$this->common_model->read_number_million($total_value17)."</th>
							    	<th class='negative right aligned'>&#8377;".round($total_avg17,2)."</th>

							    	<th class='negative right aligned'>".$this->common_model->read_number_million($total_quantity18)."</th>
							    	<th class='negative right aligned'>".$this->common_model->read_number_million($total_value18)."</th>
							    	<th class='negative right aligned'>&#8377;".round($total_avg18,2)."</th>

							    	<th class='negative right aligned'>".$this->common_model->read_number_million($total_quantity19)."</th>
							    	<th class='negative right aligned'>".$this->common_model->read_number_million($total_value19)."</th>
							    	<th class='negative right aligned'>&#8377;".round($total_avg19,2)."</th>

							    	<th class='negative right aligned'>".$this->common_model->read_number_million($total_quantity20)."</th>
							    	<th class='negative right aligned'>".$this->common_model->read_number_million($total_value20)."</th>
							    	<th class='negative right aligned'>&#8377;".round($total_avg20,2)."</th>

							    	<th class='negative right aligned'>".$this->common_model->read_number_million($total_quantity21)."</th>
							    	<th class='negative right aligned'>".$this->common_model->read_number_million($total_value21)."</th>
							    	<th class='negative right aligned'>&#8377;".round($total_avg21,2)."</th>
							    </tr>
							  </thead>";

						echo '</table>';

					}
				?>
				
				</div>
			</div>
  		</div>
	<!--	
<script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
<script src="http://cdn.oesmith.co.uk/morris-0.4.1.min.js"></script>
	
	<div id="chart" style="height:1000px;"></div>
	<script>
	const monthNames = ["", "Jan", "Feb", "Mar", "Apr", "May", "Jun",
        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
    ];
	Morris.Bar({
	 element : 'chart',
	 data:[<?php echo $chart_data; ?>],
	 xkey:'y',
	 parseTime: false,

	 ykeys:['QUANTITY_15_16','QUANTITY_16_17','QUANTITY_17_18','QUANTITY_18_19','QUANTITY_19_20'],
	 xLabelFormat: function (x) {
            var index = parseInt(x.src.y);
            return monthNames[index];
        },
     XLabels : "month", 
	 labels:['2015-16','2016-17','2017-18','2018-19','2019-20'],
	 pointFillColors: ['#ffffff','#707f9b'],
 	 pointStrokeColors: ['#ffffff','#ffaaab'],
 	 lineColors: ['orange','green', 'blue', 'red','black'],
 	 redraw: true, 
	});
	</script>
-->

	</div>
</div>