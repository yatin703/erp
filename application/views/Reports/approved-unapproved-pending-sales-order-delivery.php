
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();

		//$("#customer_category").autocomplete("<?php echo base_url('index.php/ajax/customer_category_autocomplete');?>", {selectFirst: true});
		
		
		$("#search").click(function(){
			$("#loading").show(); $("#cover").show();

			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/approved_unapproved_pending_sales_order_on_delivery_date');?>",data: {from_date : $(".from_date").val(),to_date :$('.to_date').val(),convert:$('.convert').val(),
				for_export :$('#for_export').val(),customer_no : $('.customer_no:checked').serialize(),order_type : $('.order_type:checked').serialize(),customer_category :$('#customer_category').val()},cache: false,success: function(html){
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
										<?php $new_from_date = date('Y-m-d',strtotime('-120 days', strtotime($account_periods_master_row->fin_year_start)));?>
									<tr>
										<td class="label"  width="25%">From Date <span style="color:red;">*</span>  :</td>
										<td  width="25%"><input type="date" name="from_date" class="from_date" id="from_date" value="<?php echo set_value('from_date',$new_from_date);?>"/></td>
										<td class="label"  width="25%">To Date <span style="color:red;">*</span>  :</td>
										<td  width="25%"><input type="date" name="to_date" class="to_date" id="to_date" value="<?php echo set_value('to_date',date('Y-m-d',strtotime('+180 days')));?>"/></td>
									</tr>
									<?php endforeach;
									}?>

									<tr>
										<td colspan="4">
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
					<table class="form_table_inner">
						<!--<tr>
							<td class="label">Customer :</td>
							<td colspan="4" ><input type="text" name="customer_category" id="customer_category"  size="40" value="<?php echo set_value('customer_category');?>"/>
							</td>
						</tr>-->
						
						<tr>
							<td class="label" width="25%">Convert <span style="color:red;">*</span>  :</td>
							<td width="25%"><select name="convert" class="convert">
								<option value="0">INR</option>
								<option value="1">Millions</option>
							</select></td>
							<td class="label" width="25%"> Order Type  :</td>
							<td>
								<?php
									echo '<div class="ui checkbox">
											<input type="checkbox" name="order_type" class="order_type" value="0" checked><label>Domastic</label>
											</div><br/>';

									echo '<div class="ui checkbox">
											<input type="checkbox" name="order_type" class="order_type" value="1" checked><label>Export</label>
											</div><br/>';										
								?>
							</td>
						</tr>						
					</table>
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
					if($pending_sales_order==FALSE){

					}else{
						echo '<table class="ui sortable selectable celled table" style="font-size:12px;">
					        	<thead>
								   <tr>
								    	<th colspan="24"><a class="ui orange label">APPROVED & UNAPPROVED PENDING ORDER</a>
								    	<a class="ui green label">120 DAYS</a> 
								    	';
								    	if($account_periods_master==FALSE){
								    	}else{
								    		foreach ($account_periods_master as $account_periods_master_row ){

                								$new_from_date = date('Y-m-d',strtotime('-120 days', strtotime($account_periods_master_row->fin_year_start)));
								    			echo '<a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date($new_from_date,$this->session->userdata['logged_in']['company_id']).' TO '.$this->common_model->view_date(date('Y-m-d'),$this->session->userdata['logged_in']['company_id']).'</a><br/><br/>';
								    		}
								    	}
								    	echo '<a class="ui red label">EXCLUDING SAMPLE, DEVELOPMENT,CAP & STOCK SO</a></th>
								  </tr>
								  <tr>
					        			<th colspan="3"></th>
					        			<th colspan="3" class="center aligned">SCREEN+FLEXO</th>
					        			<th colspan="3" class="center aligned">OFFSET</th>
					        			<th colspan="3" class="center aligned">LABEL</th>
					        			<th colspan="3" class="center aligned">COEX TOTAL</th>
					        			<th colspan="3" class="center aligned">DIGITAL</th>
					        			<th colspan="3" class="center aligned">UNAPPROVED</th>
					        			<th colspan="3"  class="center aligned">TOTAL</th>
					        		</tr>
					        		<tr>
					        			<th>SR NO</th>
					        			<th>YEAR-MONTH</th>
					        			<th>CUSTOMER</th>
					        			<th class="center aligned">QUANTITY</th>
					        			<th class="center aligned">VALUE</th>
					        			<th class="center aligned">AVG</th>
					        			<th class="center aligned">QUANTITY</th>
					        			<th class="center aligned">VALUE</th>
					        			<th class="center aligned">AVG</th>
					        			<th class="center aligned">QUANTITY</th>
					        			<th class="center aligned">VALUE</th>
					        			<th class="center aligned">AVG</th>
					        			<th class="center aligned">QUANTITY</th>
					        			<th class="center aligned">VALUE</th>
					        			<th class="center aligned">AVG</th>
					        			<th class="center aligned">QUANTITY</th>
					        			<th class="center aligned">VALUE</th>
					        			<th class="center aligned">AVG</th>
					        			<th class="center aligned">QUANTITY</th>
					        			<th class="center aligned">VALUE</th>
					        			<th class="center aligned">AVG</th>
					        			<th class="center aligned">QUANTITY</th>
					        			<th class="center aligned">VALUE</th>
					        			<th class="center aligned">AVG</th>
					        			
					        		</tr>
					        	</thead>';
					
					 $count=1;
					 $last_count=0;
					 $total_dia_pending_quantity=0;
					 $total_screen_flexo_pending_quantity=0;
					 $total_offset_pending_quantity=0;
					 $total_label_pending_quantity=0;
					 $total_coex_pending_quantity=0;
					 $total_digital_pending_quantity=0;
					 $total_unknown_pending_quantity=0;
					 $total_total_pending_quantity=0;

					 $total_screen_flexo_pending_value=0;
					 $total_offset_pending_value=0;
					 $total_label_pending_value=0;
					 $total_coex_pending_value=0;
					 $total_digital_pending_value=0;
					 $total_unknown_pending_value=0;
					 $total_total_pending_value=0;

					foreach($pending_sales_order as $coex_order_row){
						$total_dia_pending_quantity=0;
						$total_dia_pending_quantity=$coex_order_row->SCREEN_FLEXO_PENDING_QTY+$coex_order_row->OFFSET_PENDING_QTY+$coex_order_row->LABEL_PENDING_QTY+$coex_order_row->DIGITAL_PENDING_QTY+$coex_order_row->UNKNOWN_PENDING_QTY;


						$total_dia_coex_pending_quantity=0;
						$total_dia_coex_pending_quantity=$coex_order_row->SCREEN_FLEXO_PENDING_QTY+$coex_order_row->OFFSET_PENDING_QTY+$coex_order_row->LABEL_PENDING_QTY;

						$total_dia_pending_quantity_value=0;
						$total_dia_pending_quantity_value=$coex_order_row->SCREEN_FLEXO_PENDING_VALUE+$coex_order_row->OFFSET_PENDING_VALUE+$coex_order_row->LABEL_PENDING_VALUE+$coex_order_row->DIGITAL_PENDING_VALUE+$coex_order_row->UNKNOWN_PENDING_VALUE;

						$total_dia_coex_pending_quantity_value=0;
						$total_dia_coex_pending_quantity_value=$coex_order_row->SCREEN_FLEXO_PENDING_VALUE+$coex_order_row->OFFSET_PENDING_VALUE+$coex_order_row->LABEL_PENDING_VALUE;

						$total_dia_pending_quantity_avg_price=0;
						$total_dia_pending_quantity_avg_price=($total_dia_pending_quantity_value!=0 ? ($total_dia_pending_quantity_value/$total_dia_pending_quantity) : 0); 

						$total_dia_coex_pending_quantity_avg_price=0;
						$total_dia_coex_pending_quantity_avg_price=($total_dia_coex_pending_quantity_value!=0 ? ($total_dia_coex_pending_quantity_value/$total_dia_coex_pending_quantity) : 0); 

						if($count==1){
							//$from_date=strtoupper($coex_order->sales_month)." ".$coex_order->sales_year;
						}


						$pending_screen_flexo_avg_price=0;
						$pending_screen_flexo_avg_price=($coex_order_row->SCREEN_FLEXO_PENDING_VALUE!=0 ? ($coex_order_row->SCREEN_FLEXO_PENDING_VALUE/$coex_order_row->SCREEN_FLEXO_PENDING_QTY) : 0);

						$pending_offset_avg_price=0;
						$pending_offset_avg_price=($coex_order_row->OFFSET_PENDING_VALUE!=0 ? ($coex_order_row->OFFSET_PENDING_VALUE/$coex_order_row->OFFSET_PENDING_QTY) : 0);

						$pending_label_avg_price=0;
						$pending_label_avg_price=($coex_order_row->LABEL_PENDING_VALUE!=0 ? ($coex_order_row->LABEL_PENDING_VALUE/$coex_order_row->LABEL_PENDING_QTY) : 0);

						$pending_digital_avg_price=0;
						$pending_digital_avg_price=($coex_order_row->DIGITAL_PENDING_VALUE!=0 ? ($coex_order_row->DIGITAL_PENDING_VALUE/$coex_order_row->DIGITAL_PENDING_QTY) : 0);

						$pending_unknown_avg_price=0;
						$pending_unknown_avg_price=($coex_order_row->UNKNOWN_PENDING_QTY!=0 ? ($coex_order_row->UNKNOWN_PENDING_VALUE/$coex_order_row->UNKNOWN_PENDING_QTY) : 0);

						?>

						<script>
							$(document).ready(function(){
								$(".tr_<?php echo $count;?>").hide();
								$("#id_<?php echo $count;?>").on("click", function(){
									//alert(1);
								    $(".tr_<?php echo $count;?>").slideToggle(1000);
								    $("#idd_<?php echo $count;?>").toggleClass('plus icon');
								    $("#idd_<?php echo $count;?>").toggleClass('minus icon');
								  });

							});

						</script>

						<?php



						echo "<tr id='id_".$count."'>
								<td><b>$count</b></td>
								<td><b>$coex_order_row->order_year -".strtoupper($coex_order_row->order_month)."</b></td>
								<td><i id='idd_".$count."' class='plus icon'></i></td>
								<td class='negative right aligned'>".money_format('%!.0n',$coex_order_row->SCREEN_FLEXO_PENDING_QTY)."</td>
								<td class='negative right aligned'>".money_format('%.0n',$coex_order_row->SCREEN_FLEXO_PENDING_VALUE)."</td>
								<td class='negative right aligned'>&#8377;".round($pending_screen_flexo_avg_price,2)."</td>
								<td class='right aligned'>".money_format('%!.0n',$coex_order_row->OFFSET_PENDING_QTY)."</td>
								<td class='right aligned'>".money_format('%.0n',$coex_order_row->OFFSET_PENDING_VALUE)."</td>
								<td class='right aligned'>&#8377;".round($pending_offset_avg_price,2)."</td>
								<td class='positive right aligned'>".money_format('%!.0n',$coex_order_row->LABEL_PENDING_QTY)."</td>
								<td class='positive right aligned'>".money_format('%.0n',$coex_order_row->LABEL_PENDING_VALUE)."</td>
								<td class='positive right aligned'>&#8377;".round($pending_label_avg_price,2)."</td>

								<td class='right aligned'>".money_format('%!.0n',$total_dia_coex_pending_quantity)."</td>
								<td class='right aligned'>".money_format('%.0n',$total_dia_coex_pending_quantity_value)."</td>
								<td class='right aligned'>&#8377;".round($total_dia_coex_pending_quantity_avg_price,2)."</td>
								
								<td class='warning right aligned'>".money_format('%!.0n',$coex_order_row->DIGITAL_PENDING_QTY)."</td>
								<td class='warning right aligned'>".money_format('%.0n',$coex_order_row->DIGITAL_PENDING_VALUE)."</td>
								<td class='warning right aligned'>&#8377;".round($pending_digital_avg_price,2)."</td>

								<td class='negative right aligned'>".money_format('%!.0n',$coex_order_row->UNKNOWN_PENDING_QTY)."</td>
								<td class='negative right aligned'>".money_format('%.0n',$coex_order_row->UNKNOWN_PENDING_VALUE)."</td>
								<td class='negative right aligned'>&#8377;".round($pending_unknown_avg_price,2)."</td>
								<td class='right aligned'>".money_format('%!.0n',$total_dia_pending_quantity)."</td>
								<td class='right aligned'>".money_format('%.0n',$total_dia_pending_quantity_value)."</td>
								<td class='right aligned'>&#8377;".round($total_dia_pending_quantity_avg_price,2)."</td>
								
					        </tr>";


					        $last_date = date('Y-m-t', strtotime(''.$coex_order_row->order_month.' '.$coex_order_row->order_year.''));
					        $first_date = date('Y-m-01', strtotime(''.$coex_order_row->order_month.' '.$coex_order_row->order_year.''));


					        $pending_sales_order_customer=$this->sales_order_book_model->approved_unapproved_pending_sales_order_delivery_date_by_customer('order_master',$first_date,$last_date,'');

					        //echo $this->db->last_query();
					        //echo "<br/>"; 

					        if($pending_sales_order_customer==TRUE){
								foreach($pending_sales_order_customer as $pending_sales_order_customer_row){
									$pending_sales_order_customer_screen_flexo_avg_price=0;
									$pending_sales_order_customer_screen_flexo_avg_price=($pending_sales_order_customer_row->SCREEN_FLEXO_PENDING_VALUE!=0 ? ($pending_sales_order_customer_row->SCREEN_FLEXO_PENDING_VALUE/$pending_sales_order_customer_row->SCREEN_FLEXO_PENDING_QTY) : 0);
									$pending_sales_order_customer_offset_avg_price=0;
									$pending_sales_order_customer_offset_avg_price=($pending_sales_order_customer_row->OFFSET_PENDING_VALUE!=0 ? ($pending_sales_order_customer_row->OFFSET_PENDING_VALUE/$pending_sales_order_customer_row->OFFSET_PENDING_QTY) : 0);
									$pending_sales_order_customer_label_avg_price=0;
									$pending_sales_order_customer_label_avg_price=($pending_sales_order_customer_row->LABEL_PENDING_VALUE!=0 ? ($pending_sales_order_customer_row->LABEL_PENDING_VALUE/$pending_sales_order_customer_row->LABEL_PENDING_QTY) : 0);

									$pending_sales_order_customer_digital_avg_price=0;
									$pending_sales_order_customer_digital_avg_price=($pending_sales_order_customer_row->DIGITAL_PENDING_VALUE!=0 ? ($pending_sales_order_customer_row->DIGITAL_PENDING_VALUE/$pending_sales_order_customer_row->DIGITAL_PENDING_QTY) : 0);

									$pending_sales_order_customer_unknown_avg_price=0;
									$pending_sales_order_customer_unknown_avg_price=($pending_sales_order_customer_row->UNKNOWN_PENDING_VALUE!=0 ? ($pending_sales_order_customer_row->UNKNOWN_PENDING_VALUE/$pending_sales_order_customer_row->UNKNOWN_PENDING_QTY) : 0);



									$total_pending_sales_order_customer_quantity=0;
									$total_pending_sales_order_customer_quantity=$pending_sales_order_customer_row->SCREEN_FLEXO_PENDING_QTY+$pending_sales_order_customer_row->OFFSET_PENDING_QTY+$pending_sales_order_customer_row->LABEL_PENDING_QTY+$pending_sales_order_customer_row->DIGITAL_PENDING_QTY+$pending_sales_order_customer_row->UNKNOWN_PENDING_QTY;


									$total_pending_sales_order_customer_coex_quantity=0;
									$total_pending_sales_order_customer_coex_quantity=$pending_sales_order_customer_row->SCREEN_FLEXO_PENDING_QTY+$pending_sales_order_customer_row->OFFSET_PENDING_QTY+$pending_sales_order_customer_row->LABEL_PENDING_QTY;

									$total_pending_sales_order_customer_value=0;
									$total_pending_sales_order_customer_value=$pending_sales_order_customer_row->SCREEN_FLEXO_PENDING_VALUE+$pending_sales_order_customer_row->OFFSET_PENDING_VALUE+$pending_sales_order_customer_row->LABEL_PENDING_VALUE+$pending_sales_order_customer_row->DIGITAL_PENDING_VALUE+$pending_sales_order_customer_row->UNKNOWN_PENDING_VALUE;

									$total_pending_sales_order_customer_coex_value=0;
									$total_pending_sales_order_customer_coex_value=$pending_sales_order_customer_row->SCREEN_FLEXO_PENDING_VALUE+$pending_sales_order_customer_row->OFFSET_PENDING_VALUE+$pending_sales_order_customer_row->LABEL_PENDING_VALUE;

									$total_pending_sales_order_customer_avg_price=0;
									$total_pending_sales_order_customer_avg_price=($total_pending_sales_order_customer_quantity!=0 ? ($total_pending_sales_order_customer_value/$total_pending_sales_order_customer_quantity) : 0); 

									$total_pending_sales_order_customer_coex_avg_price=0;
									$total_pending_sales_order_customer_coex_avg_price=($total_pending_sales_order_customer_coex_value!=0 ? ($total_pending_sales_order_customer_coex_value/$total_pending_sales_order_customer_coex_quantity) : 0); 

									echo "<tr class='tr_".$count."' style='display:none;font-size:9px;'>
											<td></td>
											<td></td>											
											<td><b>$pending_sales_order_customer_row->customer</b></td>										
											<td class='negative right aligned'>".money_format('%!.0n',$pending_sales_order_customer_row->SCREEN_FLEXO_PENDING_QTY)."</td>
											<td class='negative right aligned'>".money_format('%.0n',$pending_sales_order_customer_row->SCREEN_FLEXO_PENDING_VALUE)."</td>

											<td class='negative right aligned'>&#8377;".round($pending_sales_order_customer_screen_flexo_avg_price,2)."</td>
											<td class='right aligned'>".money_format('%!.0n',$pending_sales_order_customer_row->OFFSET_PENDING_QTY)."</td>
											<td class='right aligned'>".money_format('%.0n',$pending_sales_order_customer_row->OFFSET_PENDING_VALUE)."</td>
											<td class='right aligned'>&#8377;".round($pending_sales_order_customer_offset_avg_price,2)."</td>
											<td class='positive right aligned'>".money_format('%!.0n',$pending_sales_order_customer_row->LABEL_PENDING_QTY)."</td>
											<td class='positive right aligned'>".money_format('%.0n',$pending_sales_order_customer_row->LABEL_PENDING_VALUE)."</td>

											<td class='positive right aligned'>&#8377;".round($pending_sales_order_customer_label_avg_price,2)."</td>
											
											<td class='right aligned'>".money_format('%!.0n',$total_pending_sales_order_customer_coex_quantity)."</td>
											<td class='right aligned'>".money_format('%.0n',$total_pending_sales_order_customer_coex_value)."</td>
											<td class='right aligned'>&#8377;".round($total_pending_sales_order_customer_coex_avg_price,2)."</td>
											
											<td class='warning right aligned'>".money_format('%!.0n',$pending_sales_order_customer_row->DIGITAL_PENDING_QTY)."</td>
											<td class='warning right aligned'>".money_format('%.0n',$pending_sales_order_customer_row->DIGITAL_PENDING_VALUE)."</td>
											<td class='warning right aligned'>&#8377;".round($pending_sales_order_customer_digital_avg_price,2)."</td>
											<td class='negative right aligned'>".money_format('%!.0n',$pending_sales_order_customer_row->UNKNOWN_PENDING_QTY)."</td>
											<td class='negative right aligned'>".money_format('%.0n',$pending_sales_order_customer_row->UNKNOWN_PENDING_VALUE)."</td>
											<td class='negative right aligned'>&#8377;".round($pending_sales_order_customer_unknown_avg_price,2)."</td>
								

											<td class='right aligned'>".money_format('%!.0n',$total_pending_sales_order_customer_quantity)."</td>
											<td class='right aligned'>".money_format('%.0n',$total_pending_sales_order_customer_value)."</td>
											<td class='right aligned'>&#8377;".round($total_pending_sales_order_customer_avg_price,2)."</td>
											
								
										</tr>";
								}
							}



					       $total_screen_flexo_pending_quantity+=$coex_order_row->SCREEN_FLEXO_PENDING_QTY;
					       $total_offset_pending_quantity+=$coex_order_row->OFFSET_PENDING_QTY;
					       $total_label_pending_quantity+=$coex_order_row->LABEL_PENDING_QTY;
					       $total_coex_pending_quantity+=$total_dia_coex_pending_quantity;
					       $total_digital_pending_quantity+=$coex_order_row->DIGITAL_PENDING_QTY;
					       $total_unknown_pending_quantity+=$coex_order_row->UNKNOWN_PENDING_QTY;

					       	$total_screen_flexo_pending_value+=$coex_order_row->SCREEN_FLEXO_PENDING_VALUE;
					 		$total_offset_pending_value+=$coex_order_row->OFFSET_PENDING_VALUE;
					 		$total_label_pending_value+=$coex_order_row->LABEL_PENDING_VALUE;
					 		$total_coex_pending_value+=$total_dia_coex_pending_quantity_value;
					 		$total_digital_pending_value+=$coex_order_row->DIGITAL_PENDING_VALUE;				 		
					        $total_unknown_pending_value+=$coex_order_row->UNKNOWN_PENDING_VALUE;

					 		$total_screen_flexo_pending_avg_price=0;
							$total_screen_flexo_pending_avg_price=($total_screen_flexo_pending_value!=0 ? ($total_screen_flexo_pending_value/$total_screen_flexo_pending_quantity) : 0);

							$total_offset_pending_avg_price=0;
							$total_offset_pending_avg_price=($total_offset_pending_value!=0 ? ($total_offset_pending_value/$total_offset_pending_quantity) : 0);

							$total_label_pending_avg_price=0;
							$total_label_pending_avg_price=($total_label_pending_value!=0 ? ($total_label_pending_value/$total_label_pending_quantity) : 0);

							$total_coex_pending_avg_price=0;
							$total_coex_pending_avg_price=($total_coex_pending_value!=0 ? ($total_coex_pending_value/$total_coex_pending_quantity) : 0);


							$total_digital_pending_avg_price=0;
							$total_digital_pending_avg_price=($total_digital_pending_value!=0 ? ($total_digital_pending_value/$total_digital_pending_quantity) : 0);

							$total_unknown_pending_avg_price=0;
							$total_unknown_pending_avg_price=($total_unknown_pending_value!=0 ? ($total_unknown_pending_value/$total_unknown_pending_quantity) : 0);


					       $total_total_pending_quantity=$total_screen_flexo_pending_quantity+$total_offset_pending_quantity+$total_label_pending_quantity+$total_digital_pending_quantity+$total_unknown_pending_quantity;

					       $total_total_pending_value=$total_screen_flexo_pending_value+$total_offset_pending_value+$total_label_pending_value+$total_digital_pending_value+$total_unknown_pending_value;

					       $total_total_pending_avg_price=0;
					       $total_total_pending_avg_price=($total_total_pending_value!=0 ? ($total_total_pending_value/$total_total_pending_quantity) : 0);


					       $count++;
					       if($last_count==0){
							//$to_date=strtoupper($row_coex->sales_month)." ".$row_coex->sales_year;
							}
					    }

					    echo "<thead>
							    <tr>
							    	<th colspan='3'>TOTAL</th>
							    	<th class='right aligned'>".money_format('%!.0n',$total_screen_flexo_pending_quantity)."</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_screen_flexo_pending_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_screen_flexo_pending_avg_price,2)."</th>
							    	<th class='right aligned'>".money_format('%!.0n',$total_offset_pending_quantity)."</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_offset_pending_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_offset_pending_avg_price,2)."</th>
							    	<th class='right aligned'>".money_format('%!.0n',$total_label_pending_quantity)."</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_label_pending_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_label_pending_avg_price,2)."</th>
							    	
							    	<th class='right aligned'>".money_format('%!.0n',$total_coex_pending_quantity)."</th>
							    	<th class='right aligned'>".money_format('%!.0n',$total_coex_pending_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_coex_pending_avg_price,2)."</th>
							    	
							    	<th class='right aligned'>".money_format('%!.0n',$total_digital_pending_quantity)."</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_digital_pending_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_digital_pending_avg_price,2)."</th>
							    	
							    	<th class='right aligned'>".money_format('%!.0n',$total_unknown_pending_quantity)."</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_unknown_pending_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_unknown_pending_avg_price,2)."</th>
							    	<th class='right aligned'>".money_format('%!.0n',$total_total_pending_quantity)."</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_total_pending_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_total_pending_avg_price,2)."</th>

							  	</tr>
							  </thead>";

						echo '</table>';

					}
				?>


			</span>

			</div>
  		</div>
		

	

	</div>
</div>