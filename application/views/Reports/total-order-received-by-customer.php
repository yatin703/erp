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
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/total_order_received_by_customer');?>",data: {from_date : $(".from_date").val(),to_date :$('.to_date').val(),sleeve_dia : $('.sleeve_dia:checked').serialize()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#check").html(html);
				} 
			});
		});


		

});

</script>
  

	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">
									<?php 
									if($account_periods_master==FALSE){
										echo "<tr><td>PLEASE SET THE FISCAL YEAR</td>";
									}else{
									foreach ($account_periods_master as $account_periods_master_row ):?>
									<tr>
										<td class="label"  width="25%">From Date <span style="color:red;">*</span>  :</td>
										<td  width="25%"><input type="date" name="from_date" class="from_date" value="<?php echo set_value('from_date',$account_periods_master_row->fin_year_start);?>"/></td>
										<td class="label"  width="25%">To Date <span style="color:red;">*</span>  :</td>
										<td  width="25%"><input type="date" name="to_date" class="to_date" value="<?php echo set_value('to_date',date('Y-m-d'));?>"/></td>
									</tr>
									<?php endforeach;
										}?>
									
									<tr>
										<td class="label" width="25%">Diameter :</td>
										<td width="25%">
												<?php if($sleeve_dia==FALSE){
												}else{
													foreach($sleeve_dia as $sleeve_dia_row){
													echo '<div class="ui checkbox">
													<input type="checkbox" name="sleeve_dia" class="sleeve_dia" value="'.$sleeve_dia_row->sleeve_diameter.'" checked><label>'.$sleeve_dia_row->sleeve_diameter.'</label>
													</div>';
													}
												}
												?>
										</td>
										
									</tr>
								
									<tr>
										<td>
											<div class="ui buttons">
										  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
										  		<div class="or"></div>
										  		<button class="ui positive button" id="search">Search</button>
											</div>
										</td>
									</tr>
					</table>
				</td>
				<td>
					
				</td>
			</tr>
		</table>
					
	</div>

	
	


<div class="record_form_design">
	<div class="record_inner_design" style="overflow: scroll;">
		<div class="row">
			<div class="column">
				<span id="check">
					<?php
					setlocale(LC_MONETARY, 'en_IN');
					if($total_order_received_by_customer==FALSE){

					}else{
						echo '<table class="ui sortable selectable celled table" style="font-size:9px;">
					        	<thead>
								   <tr>
								    	<th colspan="29"><a class="ui orange label">TOTAL APPROVED ORDER RECEIVED FROM CUSTOMERS</a> <a class="ui green label">APPROVAL DATE</a>';
								    	if($account_periods_master==FALSE){
								    	}else{
								    		foreach ($account_periods_master as $account_periods_master_row ){
								    			echo '<a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date($account_periods_master_row->fin_year_start,$this->session->userdata['logged_in']['company_id']).' TO '.$this->common_model->view_date(date('Y-m-d'),$this->session->userdata['logged_in']['company_id']).'</a><br/><br/>';
								    		}
								    	}
								    	echo '</th>
								  </tr>
								  <tr>
					        			<th colspan="2"></th>
					        			<th colspan="17" class="center aligned">APPROVED</th>
					        			<th colspan="4" class="center aligned">GRAND TOTAL</th>
					        	  </tr>
								  <tr>
					        			<th colspan="2"></th>
					        			<th colspan="13" class="center aligned">COEX TUBE</th>
					        			<th colspan="4" class="center aligned">SPRING TUBE</th>
					        			<th colspan="4" class="center aligned">TOTAL</th>
					        	  </tr>
								  <tr>
					        			<th colspan="2"></th>
					        			<th colspan="3" class="center aligned">SCREEN+FLEXO</th>
					        			<th colspan="3" class="center aligned">OFFSET</th>
					        			<th colspan="3" class="center aligned">LABEL</th>
					        			<th colspan="4" class="center aligned">COEX TOTAL</th>
					        			<th colspan="4" class="center aligned">DIGITAL</th>
					        			<th colspan="4" class="center aligned"></th>
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

						
						echo "<tr  "; echo $a=($count>10 ? "class='cat1' style='display:none'" : "NO");  echo ">
								<td>$count</td>
								<td><b>".strtoupper($row->customer)."</b></td>
								<td class='negative right aligned'>".money_format('%!.0n',$row->APPROVED_SCREEN_FLEXO_QTY)."</td>
								<td class='negative right aligned'>".money_format('%.0n',$row->APPROVED_SCREEN_FLEXO_VALUE)."</td>
								<td class='negative right aligned'>&#8377;".round($APPROVED_SCREEN_FLEXO_AVG,2)."</td>
								<td class='positive right aligned'>".money_format('%!.0n',$row->APPROVED_OFFSET_QTY)."</td>
								<td class='positive right aligned'>".money_format('%.0n',$row->APPROVED_OFFSET_VALUE)."</td>
								<td class='positive right aligned'>&#8377;".round($APPROVED_OFFSET_AVG,2)."</td>
								<td class='right aligned'>".money_format('%!.0n',$row->APPROVED_LABEL_QTY)."</td>
								<td class='right aligned'>".money_format('%.0n',$row->APPROVED_LABEL_VALUE)."</td>
								<td class='right aligned'>&#8377;".round($APPROVED_LABEL_AVG,2)."</td>

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


					   echo "<thead>
					   			<tr>
								<th colspan='2'><b>TOP 10 TOTAL</b></th>
								<th class='negative right aligned'>".money_format('%!.0n',$total_ten_screen_flexo_quantity)."</th>
								<th class='negative right aligned'>".money_format('%.0n',$total_ten_screen_flexo_value)."</th>
								<th class='negative right aligned'>&#8377;".round($total_ten_screen_flexo_avg,2)."</th>
								<th class='positive right aligned'>".money_format('%!.0n',$total_ten_offset_quantity)."</th>
								<th class='positive right aligned'>".money_format('%.0n',$total_ten_offset_value)."</th>
								<th class='positive right aligned'>&#8377;".round($total_ten_offset_avg,2)."</th>
								<th class='right aligned'>".money_format('%!.0n',$total_ten_label_quantity)."</th>
								<th class='right aligned'>".money_format('%.0n',$total_ten_label_value)."</th>
								<th class='right aligned'>&#8377;".round($total_ten_label_avg,2)."</th>

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

						       
					       }

					       $count++;
					   }


					   $total_other_screen_flexo_avg=($total_other_screen_flexo_value!=0 ? $total_other_screen_flexo_value/$total_other_screen_flexo_quantity : '0');
					    $total_other_offset_avg=($total_other_offset_value!=0 ? $total_other_offset_value/$total_other_offset_quantity : '0');
					    $total_other_label_avg=($total_other_label_value!=0 ? $total_other_label_value/$total_other_label_quantity : '0');
					    $total_other_coex_avg=($total_other_coex_value!=0 ? $total_other_coex_value/$total_other_coex_quantity : '0');
					    $total_other_digital_avg=($total_other_digital_value!=0 ? $total_other_digital_value/$total_other_digital_quantity : '0');
					   
					    $total_other_approved_order_avg=($total_other_approved_order_value!=0 ? ($total_other_approved_order_value/$total_other_approved_order_quantity) : 0);


					    echo "</tbody>
					    	<thead>
					    	<tr>
								<td colspan='2'><a href='#'' class='toggler' data-prod-cat='1'><b>OTHER TOTAL</b></a></td>
								<td class='negative right aligned'>".money_format('%!.0n',$total_other_screen_flexo_quantity)."</td>
								<td class='negative right aligned'>".money_format('%.0n',$total_other_screen_flexo_value)."</td>
								<td class='negative right aligned'>&#8377;".round($total_other_screen_flexo_avg,2)."</td>
								<td class='positive right aligned'>".money_format('%!.0n',$total_other_offset_quantity)."</td>
								<td class='positive right aligned'>".money_format('%.0n',$total_other_offset_value)."</td>
								<td class='positive right aligned'>&#8377;".round($total_other_offset_avg,2)."</td>
								<td class='right aligned'>".money_format('%!.0n',$total_other_label_quantity)."</td>
								<td class='right aligned'>".money_format('%.0n',$total_other_label_value)."</td>
								<td class='right aligned'>&#8377;".round($total_other_label_avg,2)."</td>

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
							</tr>
							</thead>";



					    
					    $total_screen_flexo_avg=($total_screen_flexo_value!=0 ? $total_screen_flexo_value/$total_screen_flexo_quantity : '0');
					    $total_offset_avg=($total_offset_value!=0 ? $total_offset_value/$total_offset_quantity : '0');
					    $total_label_avg=($total_label_value!=0 ? $total_label_value/$total_label_quantity : '0');
					    $total_coex_avg=($total_coex_value!=0 ? $total_coex_value/$total_coex_quantity : '0');
					    $total_digital_avg=($total_digital_value!=0 ? $total_digital_value/$total_digital_quantity : '0');
					   
					    $total_approved_order_avg=($total_approved_order_value!=0 ? ($total_approved_order_value/$total_approved_order_quantity) : 0);

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

							  	</tr>
							  </thead>
							 </tbody></table>";

					}
				?>
				
				

				</span>

			</div>
  		</div>
		

	

	</div>
</div>