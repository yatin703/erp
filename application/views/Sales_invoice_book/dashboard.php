<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

<div class="record_form_design">
	<div class="record_inner_design" style="overflow: scroll;">
		<div class="ui grid">
			<div class="six wide column">
				
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
					
					$count = 1;
					if($result2==FALSE){

					}else{
					foreach($result2 as $row2){
					$total_sale_quantity=0;
					$total_sales_value=0;
					$total_avg_value=0;
						echo '<div class="ui label" style="font-size:8.5px;">
  								<table class="ui very basic collapsing celled table">
					        	
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
					      </div>';
					$total_sale_quantity=0;

					if ($count%2==0){  
					    echo "<br/><br/>";
					}
					$count++;
				}
			}
				?>

			</div>
  		
		

		<div class="ten wide column">
		    <h4 class="ui top attached block header">
    			<?php echo date('M Y',strtotime("-5 month"))."-".date('M Y'). " <a class='ui label' style='background-color:#29abe2;color:white'>Domestic</a> <a class='ui label' style='background-color:#ffc142;color:white'>Export</a>&nbsp;&nbsp;By Quantity";?>
  			</h4>
		      <?php
			$query=$this->db->query("select * from (SELECT MONTH( ar_invoice_master.invoice_date) as month_no, YEAR( ar_invoice_master.invoice_date) as year_no, LEFT(MONTHNAME( ar_invoice_master.invoice_date),3) as sales_month, YEAR( ar_invoice_master.invoice_date ) as sales_year, SUM( IF( ar_invoice_master.for_export =1, ar_invoice_details.arid_qty, 0 ) ) /100 AS Export, SUM( IF( ar_invoice_master.for_export <>1, ar_invoice_details.arid_qty, 0 ) ) /100 AS Domestic
			FROM  ar_invoice_master
			INNER JOIN ar_invoice_details ON ar_invoice_master.ar_invoice_no = ar_invoice_details.ar_invoice_no
			WHERE ar_invoice_master.archive <>1
			AND ar_invoice_master.cancel_invoice <>1
			AND ar_invoice_details.sleeve_dia<>''
			AND ar_invoice_master.inv_type
			IN ( 1, 2, 8, 11 ) 
			GROUP BY MONTH( ar_invoice_master.invoice_date ) , YEAR( ar_invoice_master.invoice_date)
			ORDER BY ar_invoice_master.invoice_date desc, MONTH( ar_invoice_master.invoice_date ) asc
			LIMIT 6) A order by year_no asc, month_no asc");
			$result=$query->result();
			?>

			<div id="morris-bar-chart" class="ui bottom attached segment"  style="height:350px;" data-colors="#000,#29abe2,#ffc142"></div>
			<script>
			var labelColor = jQuery('#morris-bar-chart').css('color');
			Morris.Bar({
			  element: 'morris-bar-chart',
			  data: [
			  <?php
			  $total_quantity=0;
			  $output = array ();
			  foreach($result as $row){
			  	$total_quantity=$row->Domestic+$row->Export;
			  	$output[] = "{ year : '$row->sales_month $row->sales_year', Domestic : $row->Domestic, Export : $row->Export , Total: $total_quantity}"; 
			  }
			  echo implode(',', $output);
			  ?>],
			  xkey: 'year',
			  ykeys: ['Total','Domestic','Export'],
			  labels: ['Total','Domestic Quantity','Export Quantity'],
			  gridTextColor: labelColor,
			  
			  hideHover:'auto',
			  barColors: jQuery('#morris-bar-chart').data('colors').split(',')
			});
			</script>
		   

		    	<h4 class="ui top attached block header">
    				<?php echo date('M Y',strtotime("-5 month"))."-".date('M Y'). " <a class='ui label' style='background-color:#1ab394;color:white'>Domestic</a> <a class='ui label' style='background-color:#ffc142;color:white'>Export</a>&nbsp;&nbsp;By Value";?>
  				</h4>
		      <?php
				$query=$this->db->query("select * from (SELECT MONTH( ar_invoice_master.invoice_date) as month_no,YEAR( ar_invoice_master.invoice_date) as year_no, LEFT(MONTHNAME( ar_invoice_master.invoice_date),3) as sales_month, YEAR( ar_invoice_master.invoice_date ) as sales_year, SUM( IF( ar_invoice_master.for_export <>1, ar_invoice_master.totalprice, 0 ) ) /100 AS domestic_value, SUM( IF( ar_invoice_master.for_export =1, (ar_invoice_details.net_amount/100*ar_invoice_master.exchange_rate)/100 , 0 ) )  AS export_value
				FROM  ar_invoice_master
				INNER JOIN ar_invoice_details ON ar_invoice_master.ar_invoice_no = ar_invoice_details.ar_invoice_no
				WHERE ar_invoice_master.archive <>1
				AND ar_invoice_master.cancel_invoice <>1
				AND ar_invoice_details.sleeve_dia<>''
				AND ar_invoice_master.inv_type
				IN ( 1, 2, 8, 11 ) 
				GROUP BY MONTH( ar_invoice_master.invoice_date ) , YEAR( ar_invoice_master.invoice_date)
				ORDER BY ar_invoice_master.invoice_date desc, MONTH( ar_invoice_master.invoice_date ) asc
				LIMIT 6) A order by year_no asc, month_no asc");
				$result=$query->result();
				?>

				<div id="morris-bar-chart-value" class="ui bottom attached segment" style="height:350px;" data-colors="#1ab394,#ffc142"></div>
				<script>
				var labelColor = jQuery('#morris-bar-chart-value').css('color');
				Morris.Bar({
				  element: 'morris-bar-chart-value',
				  data: [
				  <?php
				  $quantity=0;
				  $output = array ();
				  $domestic_value=0;
				  $export_value=0;
				  foreach($result as $row){
				  	$domestic_value=round($row->domestic_value);
				  	$export_value=round($row->export_value);
				  	$output[] = "{ year : '$row->sales_month $row->sales_year', Domestic : $domestic_value, Export : $export_value}"; 
				  }
				  echo implode(',', $output);
				  ?>],
				  xkey: 'year',
				  ykeys: ['Domestic','Export'],
				  labels: ['Domestic Value','Export Value'],
				  gridTextColor: labelColor,
				  stacked:true,
				  barColors: jQuery('#morris-bar-chart-value').data('colors').split(',')
				});
				</script>
		  </div>

		</div>
	</div>
</div>