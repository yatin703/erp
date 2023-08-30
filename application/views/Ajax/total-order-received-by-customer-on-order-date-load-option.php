<!--<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/semantic/tablesort.js');?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>-->
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();



		$(".toggler").click(function(e){
        e.preventDefault();
        $('.cat'+$(this).attr('data-prod-cat')).toggle();
		});

		$("#check-all").hide();
		$('#check-all').click(function(){
			$(".inv_type").prop('checked', true);
			$("#uncheck-all").show();
			$("#check-all").hide();
			
		});

		$('#uncheck-all').click(function(){
			$("#check-all").show();
			$(".inv_type").attr('checked', false);
			$("#uncheck-all").hide();
		});
		
		$("#search").click(function(){
			$("#loading").show(); $("#cover").show();

			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/total_order_received_by_customer_on_order_date');?>",data: {from_date : $(".from_date").val(),to_date :$('.to_date').val(),sleeve_dia : $('.sleeve_dia:checked').serialize()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#check").html(html);
				} 
			});
		});


		

});

</script>
<?php
					setlocale(LC_MONETARY, 'en_IN');
					if($total_order_received_by_customer==FALSE){

					}else{
						echo '<table class="ui sortable selectable celled table" style="font-size:9px;">
					        	<thead>
								   <tr>
								    	<th colspan="29"><a class="ui orange label">TOTAL APPROVED ORDER RECEIVED FROM CUSTOMERS</a><a class="ui green label">ORDER DATE</a>'.($from_date!='' && $to_date!='' ? 
								    		' <a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date($from_date,$this->session->userdata['logged_in']['company_id']).'  TO '.$this->common_model->view_date($to_date,$this->session->userdata['logged_in']['company_id']).'</a><br/><br/>' : '').'
								    	
								    	</th>
								  </tr>
								 <tr>
					        			<th colspan="2"></th>
					        			<th colspan="21" class="center aligned" style="background-color:#f7ffe6">APPROVED</th>
					        			<th colspan="3" class="center aligned" style="background-color:#ffe7e7">UNAPPROVED</th>
					        			<th colspan="3" class="center aligned" style="background-color:#e0e0e0">TOTAL </th>
					        	  </tr>
								  <tr>
					        			<th colspan="2"></th>
					        			<th colspan="13" class="center aligned" style="background-color:#f7ffe6">COEX TUBE</th>
					        			<th colspan="4" class="center aligned" style="background-color:#f7ffe6">SPRING TUBE</th>
					        			<th colspan="4" class="center aligned" style="background-color:#f7ffe6">TOTAL APPROVED</th>
					        			<th colspan="3" class="center aligned" style="background-color:#ffe7e7">TOTAL UNAPPROVED</th>
					        			<th colspan="3" class="center aligned" style="background-color:#e0e0e0">APPROVED+UNAPPROVED</th>
					        	  </tr>
								  <tr>
					        			<th colspan="2"></th>
					        			<th colspan="3" class="center aligned" style="background-color:#f7ffe6">SCREEN+FLEXO</th>
					        			<th colspan="3" class="center aligned" style="background-color:#f7ffe6">OFFSET</th>
					        			<th colspan="3" class="center aligned" style="background-color:#f7ffe6">LABEL</th>
					        			<th colspan="4" class="center aligned" style="background-color:#e0e0e0">COEX TOTAL</th>
					        			<th colspan="4" class="center aligned" style="background-color:#f7ffe6">DIGITAL</th>
					        			<th colspan="4" class="center aligned" style="background-color:#f7ffe6"></th>					        			
					        			<th colspan="3" class="center aligned" style="background-color:#ffe7e7"></th>
					        			<th colspan="3" class="center aligned"  style="background-color:#e0e0e0"></th>
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
					        			<th class="right aligned">%</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG PRICE</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">%</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG PRICE</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">%</th>
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
					 $count=1;
					 $total_screen_flexo_quantity=0;
					 $total_screen_flexo_value=0;
					 $total_screen_flexo_avg=0;
					 $total_offset_quantity=0;
					 $total_offset_value=0;
					 $total_offset_avg=0;
					 $total_label_quantity=0;
					 $total_label_value=0;
					 $total_label_avg=0;
					 $total_coex_quantity=0;
					 $total_coex_value=0;
					 $total_coex_avg=0;
					 $total_digital_quantity=0;
					 $total_digital_value=0;
					 $total_digital_avg=0;
					 $total_approved_order_quantity=0;
					 $total_approved_order_value=0;
					 $total_approved_order_avg=0;

					 $total_unapproved_order_quantity=0;
					 $total_unapproved_order_value=0;
					 $total_unapproved_order_avg=0;


					 $total_unapproved_approved_order_quantity=0;
					 $total_unapproved_approved_order_value=0;
					 $total_unapproved_approved_order_avg=0;

					 $total_ten_screen_flexo_quantity=0;
					 $total_ten_screen_flexo_value=0;
					 $total_ten_screen_flexo_avg=0;
					 $total_ten_offset_quantity=0;
					 $total_ten_offset_value=0;
					 $total_ten_offset_avg=0;
					 $total_ten_label_quantity=0;
					 $total_ten_label_value=0;
					 $total_ten_label_avg=0;
					 $total_ten_coex_quantity=0;
					 $total_ten_coex_value=0;
					 $total_ten_coex_avg=0;
					 $total_ten_digital_quantity=0;
					 $total_ten_digital_value=0;
					 $total_ten_digital_avg=0;
					 $total_ten_approved_order_quantity=0;
					 $total_ten_approved_order_value=0;
					 $total_ten_approved_order_avg=0;

					 $total_ten_unapproved_order_quantity=0;
					 $total_ten_unapproved_order_value=0;
					 $total_ten_unapproved_order_avg=0;

					 $total_ten_unapproved_approved_order_quantity=0;
					 $total_ten_unapproved_approved_order_value=0;
					 $total_ten_unapproved_approved_order_avg=0;

					 $total_other_screen_flexo_quantity=0;
					 $total_other_screen_flexo_value=0;
					 $total_other_offset_quantity=0;
					 $total_other_offset_value=0;
					 $total_other_label_quantity=0;
					 $total_other_label_value=0;
					 $total_other_coex_quantity=0;
					 $total_other_coex_value=0;
				     $total_other_digital_quantity=0;
					 $total_other_digital_value=0;
					 $total_other_approved_order_quantity=0;
					 $total_other_approved_order_value=0;

					 $total_other_unapproved_order_quantity=0;
					 $total_other_unapproved_order_value=0;

					 $total_other_unapproved_approved_order_quantity=0;
					 $total_other_unapproved_approved_order_value=0;

					 $total_sales_coex_spring_quantity_for_per=0;
					 $total_sales_coex_spring_value_for_per=0;
					 $i=0;
					foreach($total_order_received_by_customer as $row){
						$total_sales_coex_spring_quantity_for_per+=$row->APPROVED_ORDER_QTY;
						$total_sales_coex_spring_value_for_per+=$row->APPROVED_ORDER_VALUE;
						$i++;
					}

					 
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

						$APPROVED_COEX_QTY=0;
						$APPROVED_COEX_QTY=$row->APPROVED_SCREEN_FLEXO_QTY+$row->APPROVED_OFFSET_QTY+$row->APPROVED_LABEL_QTY;

						$APPROVED_COEX_VALUE=0;
						$APPROVED_COEX_VALUE=$row->APPROVED_SCREEN_FLEXO_VALUE+$row->APPROVED_OFFSET_VALUE+$row->APPROVED_LABEL_VALUE;

						$APPROVED_COEX_AVG=0;
						$APPROVED_COEX_AVG=($APPROVED_COEX_VALUE<>0 ? ($APPROVED_COEX_VALUE/$APPROVED_COEX_QTY) : 0);

						$UNAPPROVED_AVG=0;
						$UNAPPROVED_AVG=($row->UNAPPROVED_ORDER_V<>0 ? ($row->UNAPPROVED_ORDER_V/$row->UNAPPROVED_ORDER_Q) : 0);

						$UNAPPROVED_APPROVED_AVG=0;
						$UNAPPROVED_APPROVED_AVG=(($row->UNAPPROVED_ORDER_V+$row->APPROVED_ORDER_VALUE)<>0 ? (($row->UNAPPROVED_ORDER_V+$row->APPROVED_ORDER_VALUE)/($row->UNAPPROVED_ORDER_Q+$row->APPROVED_ORDER_QTY)) : 0);


						
						echo "<tr  "; echo $a=($count>10 ? "class='cat1' style='display:none'" : "NO");  echo ">
								<td>$count</td>
								<td><b>".strtoupper($row->customer)."</b></td>
								<td class='positive right aligned'>".money_format('%!.0n',$row->APPROVED_SCREEN_FLEXO_QTY)."</td>
								<td class='positive right aligned'>".money_format('%.0n',$row->APPROVED_SCREEN_FLEXO_VALUE)."</td>
								<td class='positive right aligned'>&#8377;".round($APPROVED_SCREEN_FLEXO_AVG,2)."</td>
								<td class='positive right aligned'>".money_format('%!.0n',$row->APPROVED_OFFSET_QTY)."</td>
								<td class='positive right aligned'>".money_format('%.0n',$row->APPROVED_OFFSET_VALUE)."</td>
								<td class='positive right aligned'>&#8377;".round($APPROVED_OFFSET_AVG,2)."</td>
								<td class='positive aligned'>".money_format('%!.0n',$row->APPROVED_LABEL_QTY)."</td>
								<td class='positive aligned'>".money_format('%.0n',$row->APPROVED_LABEL_VALUE)."</td>
								<td class='positive aligned'>&#8377;".round($APPROVED_LABEL_AVG,2)."</td>

								<td class='active right aligned'>".money_format('%!.0n',$APPROVED_COEX_QTY)."</td>
								<td class='active right aligned'>".round((($APPROVED_COEX_QTY/$total_sales_coex_spring_quantity_for_per)*100))."%</td>
								<td class='active right aligned'>".money_format('%.0n',$APPROVED_COEX_VALUE)."</td>
								<td class='active right aligned'>&#8377;".round($APPROVED_COEX_AVG,2)."</td>

								<td class='positive right aligned'>".money_format('%!.0n',$row->APPROVED_DIGITAL_QTY)."</td>
								<td class='positive right aligned'>".round((($row->APPROVED_DIGITAL_QTY/$total_sales_coex_spring_quantity_for_per)*100))."%</td>
								<td class='positive right aligned'>".money_format('%.0n',$row->APPROVED_DIGITAL_VALUE)."</td>
								<td class='positive right aligned'>&#8377;".round($APPROVED_DIGITAL_AVG,2)."</td>

								<td class='active right aligned'>".money_format('%!.0n',$row->APPROVED_ORDER_QTY)."</td>
								<td class='active right aligned'>".round((($row->APPROVED_ORDER_QTY/$total_sales_coex_spring_quantity_for_per)*100))."%</td>
								<td class='active right aligned'>".money_format('%.0n',$row->APPROVED_ORDER_VALUE)."</td>
								<td class='active right aligned'>&#8377;".round($APPROVED_ORDER_AVG,2)."</td>
								<td class='negative right aligned'>".money_format('%!.0n',$row->UNAPPROVED_ORDER_Q)."</td>
								<td class='negative right aligned'>".money_format('%.0n',$row->UNAPPROVED_ORDER_V)."</td>
								<td class='negative right aligned'>&#8377;".round($UNAPPROVED_AVG,2)."</td>


								<td class='active right aligned'>".money_format('%!.0n',$row->UNAPPROVED_ORDER_Q+$row->APPROVED_ORDER_QTY)."</td>
								<td class='active right aligned'>".money_format('%.0n',$row->UNAPPROVED_ORDER_V+$row->APPROVED_ORDER_VALUE)."</td>
								<td class='active right aligned'>&#8377;".round($UNAPPROVED_APPROVED_AVG,2)."</td>
								
							</tr>";

					       $total_ten_screen_flexo_quantity+=$row->APPROVED_SCREEN_FLEXO_QTY;
					       $total_ten_screen_flexo_value+=$row->APPROVED_SCREEN_FLEXO_VALUE;
					       $total_ten_offset_quantity+=$row->APPROVED_OFFSET_QTY;
					       $total_ten_offset_value+=$row->APPROVED_OFFSET_VALUE;
					       $total_ten_label_quantity+=$row->APPROVED_LABEL_QTY;
					       $total_ten_label_value+=$row->APPROVED_LABEL_VALUE;
					       $total_ten_coex_quantity+=$APPROVED_COEX_QTY;
					       $total_ten_coex_value+=$APPROVED_COEX_VALUE;
					       $total_ten_digital_quantity+=$row->APPROVED_DIGITAL_QTY;
					       $total_ten_digital_value+=$row->APPROVED_DIGITAL_VALUE;

					       $total_ten_approved_order_quantity+=$row->APPROVED_ORDER_QTY;
					       $total_ten_approved_order_value+=$row->APPROVED_ORDER_VALUE;

					       $total_ten_unapproved_order_quantity+=$row->UNAPPROVED_ORDER_Q;
					       $total_ten_unapproved_order_value+=$row->UNAPPROVED_ORDER_V;

					       $total_ten_unapproved_approved_order_quantity+=$row->UNAPPROVED_ORDER_Q+$row->APPROVED_ORDER_QTY;
					       $total_ten_unapproved_approved_order_value+=$row->UNAPPROVED_ORDER_V+$row->APPROVED_ORDER_VALUE;


					        if($count==10){

					        	$total_ten_screen_flexo_avg=0;
					        	$total_ten_screen_flexo_avg=($total_ten_screen_flexo_value<>0 ? ($total_ten_screen_flexo_value/$total_ten_screen_flexo_quantity) : 0);

					        	$total_ten_offset_avg=0;
					        	$total_ten_offset_avg=($total_ten_offset_value<>0 ? ($total_ten_offset_value/$total_ten_offset_quantity) : 0);

					        	$total_ten_label_avg=0;
					        	$total_ten_label_avg=($total_ten_label_value<>0 ? ($total_ten_label_value/$total_ten_label_quantity) : 0);

					        	$total_ten_coex_avg=0;
					        	$total_ten_coex_avg=($total_ten_coex_value<>0 ? ($total_ten_coex_value/$total_ten_coex_quantity) : 0);

					        	$total_ten_digital_avg=0;
					        	$total_ten_digital_avg=($total_ten_digital_value<>0 ? ($total_ten_digital_value/$total_ten_digital_quantity) : 0);

					        	$total_ten_approved_order_avg=0;
					        	$total_ten_approved_order_avg=($total_ten_approved_order_value<>0 ? ($total_ten_approved_order_value/$total_ten_approved_order_quantity) : 0);

					        	$total_ten_unapproved_order_avg=0;
					        	$total_ten_unapproved_order_avg=($total_ten_unapproved_order_value<>0 ? ($total_ten_unapproved_order_value/$total_ten_unapproved_order_quantity) : 0);

					        	$total_ten_unapproved_approved_order_avg=0;
					        	$total_ten_unapproved_approved_order_avg=(($total_ten_unapproved_order_value+$total_ten_approved_order_value)<>0 ? (($total_ten_unapproved_order_value+$total_ten_approved_order_value)/($total_ten_unapproved_order_quantity+$total_ten_approved_order_quantity)) : 0);


					   echo "<thead>
					   			<tr>
								<th colspan='2'><b>TOP 10 TOTAL</b></th>
								<th class='positive right aligned'>".money_format('%!.0n',$total_ten_screen_flexo_quantity)."</th>
								<th class='positive right aligned'>".money_format('%.0n',$total_ten_screen_flexo_value)."</th>
								<th class='positive right aligned'>&#8377;".round($total_ten_screen_flexo_avg,2)."</th>
								<th class='positive right aligned'>".money_format('%!.0n',$total_ten_offset_quantity)."</th>
								<th class='positive right aligned'>".money_format('%.0n',$total_ten_offset_value)."</th>
								<th class='positive right aligned'>&#8377;".round($total_ten_offset_avg,2)."</th>
								<th class='positive aligned'>".money_format('%!.0n',$total_ten_label_quantity)."</th>
								<th class='positive aligned'>".money_format('%.0n',$total_ten_label_value)."</th>
								<th class='positive aligned'>&#8377;".round($total_ten_label_avg,2)."</th>

								<th class='active right aligned'>".money_format('%!.0n',$total_ten_coex_quantity)."</th>
								<th class='active right aligned'>".round((($total_ten_coex_quantity/$total_sales_coex_spring_quantity_for_per)*100))."%</th>
								<th class='active right aligned'>".money_format('%.0n',$total_ten_coex_value)."</th>
								<th class='active right aligned'>&#8377;".round($total_ten_coex_avg,2)."</th>

								<th class='positive right aligned'>".money_format('%!.0n',$total_ten_digital_quantity)."</th>
								<th class='positive right aligned'>".round((($total_ten_digital_quantity/$total_sales_coex_spring_quantity_for_per)*100))."%</th>
								<th class='positive right aligned'>".money_format('%.0n',$total_ten_digital_value)."</th>
								<th class='positive right aligned'>&#8377;".round($total_ten_digital_avg,2)."</th>

								<th class='active right aligned'>".money_format('%!.0n',$total_ten_approved_order_quantity)."</th>
								<th class='active right aligned'>".round((($total_ten_approved_order_quantity/$total_sales_coex_spring_quantity_for_per)*100))."%</th>
								<th class='active right aligned'>".money_format('%.0n',$total_ten_approved_order_value)."</th>
								<th class='active right aligned'>&#8377;".round($total_ten_approved_order_avg,2)."</th>

								<th class='negative right aligned'>".money_format('%!.0n',$total_ten_unapproved_order_quantity)."</th>
								<th class='negative right aligned'>".money_format('%.0n',$total_ten_unapproved_order_value)."</th>		
								<th class='negative right aligned'>".money_format('%.0n',$total_ten_unapproved_order_avg)."</th>

								<th class='negative right aligned'>".money_format('%!.0n',$total_ten_unapproved_approved_order_quantity)."</th>
								<th class='negative right aligned'>".money_format('%.0n',$total_ten_unapproved_approved_order_value)."</th>		
								<th class='negative right aligned'>".money_format('%.0n',$total_ten_unapproved_approved_order_avg)."</th>
							</tr>
							</thead>";

					        }
					        
					       $total_screen_flexo_quantity+=$row->APPROVED_SCREEN_FLEXO_QTY;
					       $total_screen_flexo_value+=$row->APPROVED_SCREEN_FLEXO_VALUE;
					       $total_offset_quantity+=$row->APPROVED_OFFSET_QTY;
					       $total_offset_value+=$row->APPROVED_OFFSET_VALUE;
					       $total_label_quantity+=$row->APPROVED_LABEL_QTY;
					       $total_label_value+=$row->APPROVED_LABEL_VALUE;
					       $total_coex_quantity+=$APPROVED_COEX_QTY;
					       $total_coex_value+=$APPROVED_COEX_VALUE;
					       $total_digital_quantity+=$row->APPROVED_DIGITAL_QTY;
					       $total_digital_value+=$row->APPROVED_DIGITAL_VALUE;
					       $total_approved_order_quantity+=$row->APPROVED_ORDER_QTY;
					       $total_approved_order_value+=$row->APPROVED_ORDER_VALUE;

					       $total_unapproved_order_quantity+=$row->UNAPPROVED_ORDER_Q;
					       $total_unapproved_order_value+=$row->UNAPPROVED_ORDER_V;

					       $total_unapproved_approved_order_quantity+=$row->UNAPPROVED_ORDER_Q+$row->APPROVED_ORDER_QTY;
					       $total_unapproved_approved_order_value+=$row->UNAPPROVED_ORDER_V+$row->APPROVED_ORDER_VALUE;



					       if($count>10){

					       	   $total_other_screen_flexo_quantity+=$row->APPROVED_SCREEN_FLEXO_QTY;
						       $total_other_screen_flexo_value+=$row->APPROVED_SCREEN_FLEXO_VALUE;
						       $total_other_offset_quantity+=$row->APPROVED_OFFSET_QTY;
						       $total_other_offset_value+=$row->APPROVED_OFFSET_VALUE;
						       $total_other_label_quantity+=$row->APPROVED_LABEL_QTY;
						       $total_other_label_value+=$row->APPROVED_LABEL_VALUE;
						       $total_other_coex_quantity+=$APPROVED_COEX_QTY;
						       $total_other_coex_value+=$APPROVED_COEX_VALUE;
						       $total_other_digital_quantity+=$row->APPROVED_DIGITAL_QTY;
						       $total_other_digital_value+=$row->APPROVED_DIGITAL_VALUE;

						       $total_other_approved_order_quantity+=$row->APPROVED_ORDER_QTY;
						       $total_other_approved_order_value+=$row->APPROVED_ORDER_VALUE;

						       $total_other_unapproved_order_quantity+=$row->UNAPPROVED_ORDER_Q;
						       $total_other_unapproved_order_value+=$row->UNAPPROVED_ORDER_V;



						       $total_other_unapproved_approved_order_quantity+=$row->UNAPPROVED_ORDER_Q+$row->APPROVED_ORDER_QTY;
						       $total_other_unapproved_approved_order_value+=$row->UNAPPROVED_ORDER_V+$row->APPROVED_ORDER_VALUE;

						       $total_other_unapproved_order_avg=($total_other_unapproved_order_value!=0 ? ($total_other_unapproved_order_value/$total_other_unapproved_order_quantity) : 0);

					    	   $total_other_unapproved_approved_order_avg=($total_other_unapproved_approved_order_value!=0 ? ($total_other_unapproved_approved_order_value/$total_other_unapproved_approved_order_quantity) : 0);


						       
					       }

					       $count++;
					   }


					   $total_other_screen_flexo_avg=($total_other_screen_flexo_value!=0 ? $total_other_screen_flexo_value/$total_other_screen_flexo_quantity : '0');
					    $total_other_offset_avg=($total_other_offset_value!=0 ? $total_other_offset_value/$total_other_offset_quantity : '0');
					    $total_other_label_avg=($total_other_label_value!=0 ? $total_other_label_value/$total_other_label_quantity : '0');
					    $total_other_coex_avg=($total_other_coex_value!=0 ? $total_other_coex_value/$total_other_coex_quantity : '0');
					    $total_other_digital_avg=($total_other_digital_value!=0 ? $total_other_digital_value/$total_other_digital_quantity : '0');
					   
					    $total_other_approved_order_avg=($total_other_approved_order_value!=0 ? ($total_other_approved_order_value/$total_other_approved_order_quantity) : 0);

					   
					    $total_other_unapproved_order_avg=($total_other_unapproved_order_value!=0 ? ($total_other_unapproved_order_value/$total_other_unapproved_order_quantity) : 0);


					    $total_other_unapproved_approved_order_avg=($total_other_unapproved_approved_order_value!=0 ? ($total_other_unapproved_approved_order_value/$total_other_unapproved_approved_order_quantity) : 0);


					    echo "</tbody>
					    	<thead>
					    	<tr>
								<td colspan='2'><a href='#'' class='toggler' data-prod-cat='1'><b>OTHER TOTAL</b></a></td>
								<td class='positive right aligned'>".money_format('%!.0n',$total_other_screen_flexo_quantity)."</td>
								<td class='positive right aligned'>".money_format('%.0n',$total_other_screen_flexo_value)."</td>
								<td class='positive right aligned'>&#8377;".round($total_other_screen_flexo_avg,2)."</td>
								<td class='positive right aligned'>".money_format('%!.0n',$total_other_offset_quantity)."</td>
								<td class='positive right aligned'>".money_format('%.0n',$total_other_offset_value)."</td>
								<td class='positive right aligned'>&#8377;".round($total_other_offset_avg,2)."</td>
								<td class='positive aligned'>".money_format('%!.0n',$total_other_label_quantity)."</td>
								<td class='positive aligned'>".money_format('%.0n',$total_other_label_value)."</td>
								<td class='positive aligned'>&#8377;".round($total_other_label_avg,2)."</td>

								<td class='active right aligned'>".money_format('%!.0n',$total_other_coex_quantity)."</td>
								<td class='active right aligned'>".round((($total_other_coex_quantity/$total_sales_coex_spring_quantity_for_per)*100))."%</td>
								<td class='active right aligned'>".money_format('%.0n',$total_other_coex_value)."</td>
								<td class='active right aligned'>&#8377;".round($total_other_coex_avg,2)."</td>

								<td class='positive right aligned'>".money_format('%!.0n',$total_other_digital_quantity)."</td>
								<td class='positive right aligned'>".round((($total_other_digital_quantity/$total_sales_coex_spring_quantity_for_per)*100))."%</td>
								<td class='positive right aligned'>".money_format('%.0n',$total_other_digital_value)."</td>
								<td class='positive right aligned'>&#8377;".round($total_other_digital_avg,2)."</td>

								<td class='active right aligned'>".money_format('%!.0n',$total_other_approved_order_quantity)."</td>
								<td class='active right aligned'>".round((($total_other_approved_order_quantity/$total_sales_coex_spring_quantity_for_per)*100))."%</td>
								<td class='active right aligned'>".money_format('%.0n',$total_other_approved_order_value)."</td>
								<td class='active right aligned'>&#8377;".round($total_other_approved_order_avg,2)."</td>



								<td class='negative right aligned'>".money_format('%!.0n',$total_other_unapproved_order_quantity)."</td>
								<td class='negative right aligned'>".money_format('%.0n',$total_other_unapproved_order_value)."</td>
								<td class='negative right aligned'>&#8377;".round($total_other_unapproved_order_avg,2)."</td>


								<td class='negative right aligned'>".money_format('%!.0n',$total_other_unapproved_approved_order_quantity)."</td>
								<td class='negative right aligned'>".money_format('%.0n',$total_other_unapproved_approved_order_value)."</td>
								<td class='negative right aligned'>&#8377;".round($total_other_unapproved_approved_order_avg,2)."</td>
							</tr>
							</thead>";



					    
					    $total_screen_flexo_avg=($total_screen_flexo_value!=0 ? $total_screen_flexo_value/$total_screen_flexo_quantity : '0');
					    $total_offset_avg=($total_offset_value!=0 ? $total_offset_value/$total_offset_quantity : '0');
					    $total_label_avg=($total_label_value!=0 ? $total_label_value/$total_label_quantity : '0');
					    $total_coex_avg=($total_coex_value!=0 ? $total_coex_value/$total_coex_quantity : '0');
					    $total_digital_avg=($total_digital_value!=0 ? $total_digital_value/$total_digital_quantity : '0');
					   
					    $total_approved_order_avg=($total_approved_order_value!=0 ? ($total_approved_order_value/$total_approved_order_quantity) : 0);


					    $total_unapproved_order_avg=($total_unapproved_order_value!=0 ? ($total_unapproved_order_value/$total_unapproved_order_quantity) : 0);

					    $total_unapproved_approved_order_avg=($total_unapproved_approved_order_value!=0 ? ($total_unapproved_approved_order_value/$total_unapproved_approved_order_quantity) : 0);

					     echo "<thead>
							    <tr>
							    	<th colspan='2'><b>GRAND TOTAL</b></th>
							    	<th class='negative right aligned'>".money_format('%!.0n',$total_screen_flexo_quantity)."</th>
							    	<th class='negative right aligned'>".money_format('%.0n',$total_screen_flexo_value)."</th>
							    	<th class='negative right aligned'>&#8377;".round($total_screen_flexo_avg,2)."</th>
							    	<th class='positive right aligned'>".money_format('%!.0n',$total_offset_quantity)."</th>
							    	<th class='positive right aligned'>".money_format('%.0n',$total_offset_value)."</th>
							    	<th class='positive right aligned'>&#8377;".round($total_offset_avg,2)."</th>
							    	<th class='positive right aligned'>".money_format('%!.0n',$total_label_quantity)."</th>
							    	<th class='positive right aligned'>".money_format('%.0n',$total_label_value)."</th>
							    	<th class='positive right aligned'>&#8377;".round($total_label_avg,2)."</th>

							    	<th class='active right aligned'>".money_format('%!.0n',$total_coex_quantity)."</th>
							    	<th class='active right aligned'>".round((($total_coex_quantity/$total_sales_coex_spring_quantity_for_per)*100))."%</th>
							    	<th class='active right aligned'>".money_format('%.0n',$total_coex_value)."</th>
							    	<th class='active right aligned'>&#8377;".round($total_coex_avg,2)."</th>

							    	<th class='positive right aligned'>".money_format('%!.0n',$total_digital_quantity)."</th>
							    	<th class='positive right aligned'>".round((($total_digital_quantity/$total_sales_coex_spring_quantity_for_per)*100))."%</th>
							    	<th class='positive right aligned'>".money_format('%.0n',$total_digital_value)."</th>
							    	<th class='positive right aligned'>&#8377;".round($total_digital_avg,2)."</th>

							    	<th class='active right aligned'>".money_format('%!.0n',$total_approved_order_quantity)."</th>
							    	<th class='active right aligned'>".round((($total_approved_order_quantity/$total_sales_coex_spring_quantity_for_per)*100))."%</th>
							    	<th class='active right aligned'>".money_format('%.0n',$total_approved_order_value)."</th>
							    	<th class='active right aligned'>&#8377;".round($total_approved_order_avg,2)."</th>

							    	<th class='active right aligned'>".money_format('%!.0n',$total_unapproved_order_quantity)."</th>
							    	<th class='active right aligned'>".money_format('%.0n',$total_unapproved_order_value)."</th>

							    	<th class='active right aligned'>&#8377;".round($total_unapproved_order_avg,2)."</th>


							    	<th class='active right aligned'>".money_format('%!.0n',$total_unapproved_approved_order_quantity)."</th>
							    	<th class='active right aligned'>".money_format('%.0n',$total_unapproved_approved_order_value)."</th>
							    	<th class='active right aligned'>&#8377;".round($total_unapproved_approved_order_avg,2)."</th>

							  	</tr>
							  </thead>
							 </tbody></table>";

					}
				?>

				