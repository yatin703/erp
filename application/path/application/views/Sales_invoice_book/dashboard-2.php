<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

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
		<div class="ui menu">
		  <a class="red item"  data-tab="first">Coex & Spring </a>
		  <a class="orange item" data-tab="second">Top Customer</a>
		  <a class="yellow item" data-tab="third">Top Products</a>
		</div>

		<div class="ui tab active" data-tab="first">
		  	<?php
  				setlocale(LC_MONETARY, 'en_IN');
  				$query=$this->db->query("SELECT MONTH(ar_invoice_master.invoice_date) as month_no, LEFT(MONTHNAME( ar_invoice_master.invoice_date),3) as sales_month, YEAR( ar_invoice_master.invoice_date ) as sales_year, ar_invoice_details.order_flag,SUM( IF( ar_invoice_master.for_export =1, ar_invoice_details.arid_qty, 0 ) ) /100 AS export_quantity, SUM( IF( ar_invoice_master.for_export <>1, ar_invoice_details.arid_qty, 0 ) ) /100 AS domestic_quantity,SUM( IF( ar_invoice_master.for_export <>1, ar_invoice_master.totalprice, 0 ) ) /100 AS domestic_value, SUM( IF( ar_invoice_master.for_export =1, (ar_invoice_details.net_amount/100*ar_invoice_master.exchange_rate)/100 , 0 ) )  AS export_value
					FROM  ar_invoice_master
					INNER JOIN ar_invoice_details ON ar_invoice_master.ar_invoice_no = ar_invoice_details.ar_invoice_no
					WHERE ar_invoice_master.archive <>1
					AND ar_invoice_master.cancel_invoice <>1
					AND ar_invoice_details.sleeve_dia<>''
					AND ar_invoice_master.inv_type
					IN ( 1, 2, 8, 11 ) 
					GROUP BY MONTH( ar_invoice_master.invoice_date ) , YEAR( ar_invoice_master.invoice_date),ar_invoice_details.order_flag
					ORDER BY ar_invoice_master.invoice_date desc, MONTH( ar_invoice_master.invoice_date ) asc
					LIMIT 0,12");
					$result2=$query->result();
					$this->db->last_query();
  				?>

  				<?php
					$total_domestic_quantity=0;
					$total_domestic_value=0;
					$total_export_quantity=0;
					$total_export_value=0;
					$total_de_quantity=0;
					$total_de_value=0;
					$total_de_avg=0;
					$count = 1;
					if($result2==FALSE){

					}else{
					foreach($result2 as $row2){
					$total_sale_quantity=0;
					$total_sales_value=0;
					$total_avg_value=0;
						echo '<div class="ui label">
  								<table class="ui very basic collapsing celled table" >
					        	
					        	<thead>
								   <tr>
								    	<th colspan="4"><a  style="font-size:9px;" class="ui '.($row2->order_flag==1 ? "yellow" : "orange").' label">'.$row2->sales_month.' '.$row2->sales_year.' '.($row2->order_flag==1 ? "Spring" : "Coex").'</a></th>
								  </tr>
					        		<tr>
					        			<th>Sale</th>
					        			<th>Quantity</th>
					        			<th>Net</th>
					        			<th>Avg Rate</th>
					        		</tr>
					        	</thead>';
					        		$total_sale_quantity+=$row2->domestic_quantity+$row2->export_quantity;
					        		$total_sales_value+=$row2->domestic_value+$row2->export_value;
					        		$total_avg_value=$total_sales_value/$total_sale_quantity;
					        		echo "<tr>
					        			<td>Domestic</td>
					        			<td>".money_format('%!.0n',$row2->domestic_quantity)."</td>
					        			<td>".money_format('%.0n',$row2->domestic_value)."</td>
					        			<td>&#8377;".number_format($row2->domestic_value/$row2->domestic_quantity,2)."</td>
					        			</tr>";

					        		echo "<tr>
					        				<td>Export</td>
					        				<td>".money_format('%!.0n',$row2->export_quantity)."</td>
					        				<td>".money_format('%.0n',$row2->export_value)."</td>
					        				<td>&#8377;".$export_avg=($row2->export_value>0 ? number_format($row2->export_value/$row2->export_quantity,2) : '0')."</td>
					        				
					        				</tr>";

					        		echo "<tr>
					        				<td>Total</td>
					        				<td>".money_format('%!.0n',$total_sale_quantity)."</td>
					        				<td>".money_format('%.0n',$total_sales_value)."</td>
					        				<td>&#8377;".number_format($total_avg_value,2)."</td>
					        				
					        			</tr>";
					        		
					        	
					        echo '</table>
					      </div> ';
					      $total_domestic_quantity+=$row2->domestic_quantity;
					      $total_domestic_value+=$row2->domestic_value;
					      $total_export_quantity+=$row2->export_quantity;
					      $total_export_value+=$row2->export_value;
					      $total_de_quantity=$total_domestic_quantity+$total_export_quantity;
					      $total_de_value=$total_domestic_value+$total_export_value;
					      $total_de_avg=$total_de_value/$total_de_quantity;
					if ($count%2==0){  

						
					    echo '<span style="text-align:middle">+</span>
					    <div class="ui label">
					    <table class="ui very basic collapsing celled table" >

					    		<thead>
								   <tr>
								    	<th colspan="4">'.$row2->sales_month.' '.$row2->sales_year.' </th>
								  </tr>
					        		<tr>
					        			<th>Sale</th>
					        			<th>Quantity</th>
					        			<th>Net</th>
					        			<th>Avg Rate</th>
					        		</tr>
					        	</thead>
					        	<tr>
					        			<td>Domestic</td>
					        			<td>'.money_format('%!.0n',$total_domestic_quantity).'</td>
					        			<td>'.money_format('%.0n',$total_domestic_value).'</td>
					        			<td>&#8377;'.number_format($total_domestic_value/$total_domestic_quantity,2).'</td>
					        	</tr>

					        	<tr>
					        			<td>Export</td>
					        			<td>'.money_format('%!.0n',$total_export_quantity).'</td>
					        			<td>'.money_format('%.0n',$total_export_value).'</td>
					        			<td>&#8377;'.number_format($total_export_value/$total_export_quantity,2).'</td>
					        	</tr>

					        	<tr>
					        				<td>Total</td>
					        				<td>'.money_format('%!.0n',$total_de_quantity).'</td>
					        				<td>'.money_format('%.0n',$total_de_value).'</td>
					        				<td>&#8377;'.number_format($total_de_avg,2).'</td>
					        				
					        			</tr>

					    </table>
					    </div>';
					    $total_domestic_quantity=0;
					    $total_domestic_value=0;
					    $total_export_quantity=0;
					    $total_export_value=0;
					    $total_de_quantity=0;
						$total_de_value=0;
						$total_de_avg=0;
					}


					if ($count%2==0){  
					    echo "<br/><br/>";
					}
					$count++;
				}
			}
				?>
		</div>

		<div class="ui bottom attached tab segment" data-tab="second">
		  Second
		</div>


	</div>
</div>