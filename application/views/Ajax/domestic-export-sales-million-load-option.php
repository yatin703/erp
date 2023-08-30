<?php
					setlocale(LC_MONETARY, 'en_IN');
					if($domestic_export_sales==FALSE){

					}else{
						echo '<table class="ui sortable selectable celled table" style="font-size:10px;">
					        	<thead>
								   <tr>
								    	<th colspan="28">
								    	<a class="ui red label">IN MILLIONS</a>
								    	<a class="ui orange label">DOMESTIC EXPORT SALES</a>
								    	'.($from_date!='' && $to_date!='' ? 
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
					        			<th colspan="3" class="center aligned">DOMESTIC SALE</th>
					        			<th colspan="3" class="center aligned">EXPORT SALE</th>
					        			<th colspan="3" class="center aligned">TOTAL SALE</th>
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
					 $total_domestic_quantity=0;
					 $total_domestic_value=0;
					 $total_domestic_avg=0;
					 $total_export_quantity=0;
					 $total_export_value=0;
					 $total_export_avg=0;
					 $total_total_sales_quantity=0;
					 $total_total_sales_value=0;
					 $total_total_sales_avg=0;


					 $count=0;
					foreach($domestic_export_sales as $row){
						$total_sales_quantity=0;
					 	$total_sales_value=0;
						$total_sales_value=$row->domestic_value+$row->export_value;
						$total_sales_quantity=$row->domestic_qty+$row->export_qty;
						$domestic_avg_price=0;
						$domestic_avg_price=($row->domestic_value!=0 ? $row->domestic_value/$row->domestic_qty : 0);
						$export_avg_price=0;
						$export_avg_price=($row->export_value!=0 ? $row->export_value/$row->export_qty : 0);
						$total_sales_avg_price=0;
						$total_sales_avg_price=($total_sales_value!=0 ? $total_sales_value/$total_sales_quantity : 0);


						

						echo "<tr title='$row->sales_month'>
								<td><b>".$row->sales_year."-".strtoupper($row->sales_month)."</b></td>
								<td class='negative right aligned'>".$this->common_model->read_number_million($row->domestic_qty)."</td>
								<td class='negative right aligned'>".$this->common_model->read_number_million($row->domestic_value)."</td>
								<td class='negative right aligned'>&#8377;".round($domestic_avg_price,2)."</td>
								<td class='positive right aligned'>".$this->common_model->read_number_million($row->export_qty)."</td>
								<td class='positive right aligned'>".$this->common_model->read_number_million($row->export_value)."</td>
								<td class='positive right aligned'>&#8377;".round($export_avg_price,2)."</td>
								<td class='warning right aligned'>".$this->common_model->read_number_million($total_sales_quantity)."</td>
								<td class='warning right aligned'>".$this->common_model->read_number_million($total_sales_value)."</td>
								<td class='warning right aligned'>&#8377;".round($total_sales_avg_price,2)."</td>

					        </tr>";

					       $total_domestic_quantity+=$row->domestic_qty;
					       $total_domestic_value+=$row->domestic_value;
					       $total_export_quantity+=$row->export_qty;
					       $total_export_value+=$row->export_value;
					    }
					    $total_total_sales_quantity=$total_domestic_quantity+$total_export_quantity;
					    $total_total_sales_value=$total_domestic_value+$total_export_value;
					    $total_domestic_avg=($total_domestic_value!=0 ? $total_domestic_value/$total_domestic_quantity : '0');
					    $total_export_avg=($total_export_value!=0 ? $total_export_value/$total_export_quantity : '0');
					    $total_total_sales_avg=($total_total_sales_value!=0 ? $total_total_sales_value/$total_total_sales_quantity : '0');
					    


					    echo "<thead>
							    <tr>
							    	<th>TOTAL</th>
							    	<th class='negative right aligned'>".$this->common_model->read_number_million($total_domestic_quantity)."</th>
							    	<th class='negative right aligned'>".$this->common_model->read_number_million($total_domestic_value)."</th>
							    	<th class='negative right aligned'>&#8377;".round($total_domestic_avg,2)."</th>
							    	<th class='positive right aligned'>".$this->common_model->read_number_million($total_export_quantity)."</th>
							    	<th class='positive right aligned'>".$this->common_model->read_number_million($total_export_value)."</th>
							    	<th class='positive right aligned'>&#8377;".round($total_export_avg,2)."</th>
							    	<th class='warning right aligned'>".$this->common_model->read_number_million($total_total_sales_quantity)."</th>
							    	<th class='warning right aligned'>".$this->common_model->read_number_million($total_total_sales_value)."</th>
							    	<th class='warning right aligned'>&#8377;".round($total_total_sales_avg,2)."</th>
							    </tr>
							  </thead>";

						echo '</table>';
					}
				?>

