<!--<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/semantic/tablesort.js');?>"></script>-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		/*$('table').tablesort();*/
		
		/*$("#adr_company_id").autocomplete("<?php echo base_url('index.php/ajax/customer');?>", {selectFirst: true});*/
		
		$("#search").click(function(){
			$("#loading").show(); $("#cover").show();

			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/mom');?>",data: {from_date : $(".from_date").val(),to_date :$('.to_date').val(),for_export :$('#for_export').val(),customer_no : $('.customer_no:checked').serialize(),sleeve_dia : $('.sleeve_dia:checked').serialize(),customer_category :$('#customer_category').val()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#check").html(html);
				} 
			});
		});


		$("#customer").keyup(function(event) {
            
            var customer = $('#customer').val();
            $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/bill_to",data: {customer : $('#customer').val()},cache: false,success: function(html){
                $("#hello").html(html);
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
									<tr>
										<td class="label" width="25%">From Date <span style="color:red;">*</span> :</td>
										<td width="25%"><input type="date" name="from_date" class="from_date" value="<?php echo set_value('from_date',date('Y-m-d'));?>"/></td>
										<td class="label" width="25%">To Date <span style="color:red;">*</span> :</td>
										<td width="25%"><input type="date" name="to_date" class="to_date" value="<?php echo set_value('to_date',date('Y-m-d'));?>"/></td>
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
					<table class="form_table_inner">
						<tr>
							<td class="label" width="25%"></td>
							<td width="75%"><span id="hello"></span></td>
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
					if($sales_order_summary==FALSE){

					}else{
						echo '<table class="ui sortable selectable celled table" style="font-size:9px;">
					        	<thead>
								   <tr>
								    	<th colspan="17"><a class="ui orange label">PENDING ORDER</a> <a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date('2019-04-01',$this->session->userdata['logged_in']['company_id']).'  TO '.$this->common_model->view_date(date('Y-m-d'),$this->session->userdata['logged_in']['company_id']).'</a></th>
								  </tr>
								  <tr>
					        			<th></th>
					        			<th>DIAMETER</th>
					        			<th colspan="3" class="center aligned">SCREEN+FLEXO</th>
					        			<th colspan="3" class="center aligned">OFFSET</th>
					        			<th colspan="3" class="center aligned">LABEL</th>
					        			<th colspan="3" class="center aligned">DIGITAL</th>
					        			<th colspan="3"  class="center aligned">TOTAL</th>
					        		</tr>
					        		<tr>
					        			<th>SR NO</th>
					        			<th></th>
					        			<th class="center aligned">QUANTITY</th>
					        			<th class="center aligned">VALUE</th>
					        			<th class="center aligned">AVG RATE</th>
					        			<th class="center aligned">QUANTITY</th>
					        			<th class="center aligned">VALUE</th>
					        			<th class="center aligned">AVG RATE</th>
					        			<th class="center aligned">QUANTITY</th>
					        			<th class="center aligned">VALUE</th>
					        			<th class="center aligned">AVG RATE</th>
					        			<th class="center aligned">QUANTITY</th>
					        			<th class="center aligned">VALUE</th>
					        			<th class="center aligned">AVG RATE</th>
					        			<th class="center aligned">QUANTITY</th>
					        			<th class="center aligned">VALUE</th>
					        			<th class="center aligned">AVG RATE</th>
					        			
					        		</tr>
					        	</thead>';
					
					 $count=1;
					 $last_count=0;
					 $total_dia_pending_quantity=0;
					 $total_screen_flexo_pending_quantity=0;
					 $total_offset_pending_quantity=0;
					 $total_label_pending_quantity=0;
					 $total_digital_pending_quantity=0;
					 $total_total_pending_quantity=0;

					 $total_screen_flexo_pending_value=0;
					 $total_offset_pending_value=0;
					 $total_label_pending_value=0;
					 $total_digital_pending_value=0;
					 $total_total_pending_value=0;

					foreach($sales_order_summary as $coex_order_row){
						$total_dia_pending_quantity=0;
						$total_dia_pending_quantity=$coex_order_row->SCREEN_FLEXO_PENDING_QTY+$coex_order_row->OFFSET_PENDING_QTY+$coex_order_row->LABEL_PENDING_QTY+$coex_order_row->DIGITAL_PENDING_QTY;
						$total_dia_pending_quantity_value=0;
						$total_dia_pending_quantity_value=$coex_order_row->SCREEN_FLEXO_PENDING_VALUE+$coex_order_row->OFFSET_PENDING_VALUE+$coex_order_row->LABEL_PENDING_VALUE+$coex_order_row->DIGITAL_PENDING_VALUE;
						$total_dia_pending_quantity_avg_price=0;
						$total_dia_pending_quantity_avg_price=($total_dia_pending_quantity_value!=0 ? ($total_dia_pending_quantity_value/$total_dia_pending_quantity) : 0); 
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



						echo "<tr>
								<td>$count</td>
								<td>$coex_order_row->sleeve_dia</td>
								<td class='negative right aligned'>".money_format('%!.0n',$coex_order_row->SCREEN_FLEXO_PENDING_QTY)."</td>
								<td class='negative right aligned'>".money_format('%.0n',$coex_order_row->SCREEN_FLEXO_PENDING_VALUE)."</td>
								<td class='negative right aligned'>&#8377;".round($pending_screen_flexo_avg_price,2)."</td>
								<td class='right aligned'>".money_format('%!.0n',$coex_order_row->OFFSET_PENDING_QTY)."</td>
								<td class='right aligned'>".money_format('%.0n',$coex_order_row->OFFSET_PENDING_VALUE)."</td>
								<td class='right aligned'>&#8377;".round($pending_offset_avg_price,2)."</td>
								<td class='positive right aligned'>".money_format('%!.0n',$coex_order_row->LABEL_PENDING_QTY)."</td>
								<td class='positive right aligned'>".money_format('%.0n',$coex_order_row->LABEL_PENDING_VALUE)."</td>
								<td class='positive right aligned'>&#8377;".round($pending_label_avg_price,2)."</td>
								<td class='warning right aligned'>".money_format('%!.0n',$coex_order_row->DIGITAL_PENDING_QTY)."</td>
								<td class='warning right aligned'>".money_format('%.0n',$coex_order_row->DIGITAL_PENDING_VALUE)."</td>
								<td class='warning right aligned'>&#8377;".round($pending_digital_avg_price,2)."</td>
								<td class='right aligned'>".money_format('%!.0n',$total_dia_pending_quantity)."</td>
								<td class='right aligned'>".money_format('%.0n',$total_dia_pending_quantity_value)."</td>
								<td class='right aligned'>&#8377;".round($total_dia_pending_quantity_avg_price,2)."</td>
								
					        </tr>";

					       $total_screen_flexo_pending_quantity+=$coex_order_row->SCREEN_FLEXO_PENDING_QTY;
					       $total_offset_pending_quantity+=$coex_order_row->OFFSET_PENDING_QTY;
					       $total_label_pending_quantity+=$coex_order_row->LABEL_PENDING_QTY;
					       $total_digital_pending_quantity+=$coex_order_row->DIGITAL_PENDING_QTY;

					       	$total_screen_flexo_pending_value+=$coex_order_row->SCREEN_FLEXO_PENDING_VALUE;
					 		$total_offset_pending_value+=$coex_order_row->OFFSET_PENDING_VALUE;
					 		$total_label_pending_value+=$coex_order_row->LABEL_PENDING_VALUE;
					 		$total_digital_pending_value+=$coex_order_row->DIGITAL_PENDING_VALUE;

					 		$total_screen_flexo_pending_avg_price=0;
							$total_screen_flexo_pending_avg_price=($total_screen_flexo_pending_value!=0 ? ($total_screen_flexo_pending_value/$total_screen_flexo_pending_quantity) : 0);

							$total_offset_pending_avg_price=0;
							$total_offset_pending_avg_price=($total_offset_pending_value!=0 ? ($total_offset_pending_value/$total_offset_pending_quantity) : 0);

							$total_label_pending_avg_price=0;
							$total_label_pending_avg_price=($total_label_pending_value!=0 ? ($total_label_pending_value/$total_label_pending_quantity) : 0);

							$total_digital_pending_avg_price=0;
							$total_digital_pending_avg_price=($total_digital_pending_value!=0 ? ($total_digital_pending_value/$total_digital_pending_quantity) : 0);


					       $total_total_pending_quantity=$total_screen_flexo_pending_quantity+$total_offset_pending_quantity+$total_label_pending_quantity+$total_digital_pending_quantity;

					       $total_total_pending_value=$total_screen_flexo_pending_value+$total_offset_pending_value+$total_label_pending_value+$total_digital_pending_value;

					       $total_total_pending_avg_price=0;
					       $total_total_pending_avg_price=($total_total_pending_value!=0 ? ($total_total_pending_value/$total_total_pending_quantity) : 0);


					       $count++;
					       if($last_count==0){
							//$to_date=strtoupper($row_coex->sales_month)." ".$row_coex->sales_year;
							}
					    }

					    echo "<thead>
							    <tr>
							    	<th>TOTAL</th>
							    	<th></th>
							    	<th class='right aligned'>".money_format('%!.0n',$total_screen_flexo_pending_quantity)."</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_screen_flexo_pending_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_screen_flexo_pending_avg_price,2)."</th>
							    	<th class='right aligned'>".money_format('%!.0n',$total_offset_pending_quantity)."</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_offset_pending_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_offset_pending_avg_price,2)."</th>
							    	<th class='right aligned'>".money_format('%!.0n',$total_label_pending_quantity)."</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_label_pending_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_label_pending_avg_price,2)."</th>
							    	<th class='right aligned'>".money_format('%!.0n',$total_digital_pending_quantity)."</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_digital_pending_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_digital_pending_avg_price,2)."</th>
							    	<th class='right aligned'>".money_format('%!.0n',$total_total_pending_quantity)."</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_total_pending_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_total_pending_avg_price,2)."</th>

							  	</tr>
							  </thead>";

						echo '</table>';

					}
				?>
				
				<?php
					setlocale(LC_MONETARY, 'en_IN');
					if($sales_invoice_summary==FALSE){

					}else{
						echo '<table class="ui sortable selectable celled table" style="font-size:9px;">
					        	<thead>
								   <tr>
								    	<th colspan="17"><a class="ui orange label">DELIVERED TO CUSTOMER</a> <a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date('2019-04-01',$this->session->userdata['logged_in']['company_id']).'  TO '.$this->common_model->view_date(date('Y-m-d'),$this->session->userdata['logged_in']['company_id']).'</a></th>
								  </tr>
								  <tr>
					        			<th></th>
					        			<th>DIAMETER</th>
					        			<th colspan="3" class="center aligned">SCREEN+FLEXO</th>
					        			<th colspan="3" class="center aligned">OFFSET</th>
					        			<th colspan="3" class="center aligned">LABEL</th>
					        			<th colspan="3" class="center aligned">DIGITAL</th>
					        			<th colspan="3"  class="center aligned">TOTAL</th>
					        		</tr>
					        		<tr>
					        			<th>SR NO</th>
					        			<th></th>
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
					
					 $count=1;
					 $last_count=0;
					 $total_sales_dia_quantity=0;
					 $total_sales_screen_flexo_quantity=0;
					 $total_sales_screen_flexo_value=0;
					 $total_sales_screen_flexo_avg=0;
					 $total_sales_offset_quantity=0;
					 $total_sales_offset_value=0;
					 $total_sales_offset_avg=0;
					 $total_sales_label_quantity=0;
					 $total_sales_label_value=0;
					 $total_sales_label_avg=0;
					 $total_sales_digital_quantity=0;
					 $total_sales_digital_value=0;
					 $total_sales_digital_avg=0;
					 $total_sales_total_quantity=0;
					 $total_sales_total_value=0;
					 $total_sales_total_avg=0;
					foreach($sales_invoice_summary as $sales_invoice_summary_row){

					$total_sales_dia_quantity=$sales_invoice_summary_row->SCREEN_FLEXO+$sales_invoice_summary_row->OFFSET+$sales_invoice_summary_row->LABEL+$sales_invoice_summary_row->DIGITAL;

					$total_sales_dia_value=$sales_invoice_summary_row->SCREEN_FLEXO_VALUE+$sales_invoice_summary_row->OFFSET_VALUE+$sales_invoice_summary_row->LABEL_VALUE+$sales_invoice_summary_row->DIGITAL_VALUE;

					$sales_screen_flexo_avg_price=0;
					$sales_screen_flexo_avg_price=($sales_invoice_summary_row->SCREEN_FLEXO_VALUE!=0 ? $sales_invoice_summary_row->SCREEN_FLEXO_VALUE/$sales_invoice_summary_row->SCREEN_FLEXO : 0);

					$sales_offset_avg_price=0;
					$sales_offset_avg_price=($sales_invoice_summary_row->OFFSET_VALUE!=0 ? $sales_invoice_summary_row->OFFSET_VALUE/$sales_invoice_summary_row->OFFSET : 0);

					$sales_label_avg_price=0;
					$sales_label_avg_price=($sales_invoice_summary_row->LABEL_VALUE!=0 ? $sales_invoice_summary_row->LABEL_VALUE/$sales_invoice_summary_row->LABEL : 0);

					$sales_digital_avg_price=0;
					$sales_digital_avg_price=($sales_invoice_summary_row->DIGITAL_VALUE!=0 ? $sales_invoice_summary_row->DIGITAL_VALUE/$sales_invoice_summary_row->DIGITAL : 0);
					
					$sales_total_avg_price=0;
					$sales_total_avg_price=($total_sales_dia_value!=0 ? $total_sales_dia_value/$total_sales_dia_quantity : 0);

						if($count==1){
							//$from_date=strtoupper($coex_order->sales_month)." ".$coex_order->sales_year;
						}
						echo "<tr>
								<td>$count</td>
								<td>$sales_invoice_summary_row->sleeve_dia</td>
								<td class='negative right aligned'>".money_format('%!.0n',$sales_invoice_summary_row->SCREEN_FLEXO)."</td>
								<td class='negative right aligned'>".money_format('%.0n',$sales_invoice_summary_row->SCREEN_FLEXO_VALUE)."</td>
								<td class='negative right aligned'>&#8377;".round($sales_screen_flexo_avg_price,2)."</td>
							
								<td  class='right aligned'>".money_format('%!.0n',$sales_invoice_summary_row->OFFSET)."</td>
								<td class='right aligned'>".money_format('%.0n',$sales_invoice_summary_row->OFFSET_VALUE)."</td>
								<td class='right aligned'>&#8377;".round($sales_offset_avg_price,2)."</td>
								
								<td  class='positive right aligned'>".money_format('%!.0n',$sales_invoice_summary_row->LABEL)."</td>
								<td class='positive right aligned'>".money_format('%.0n',$sales_invoice_summary_row->LABEL_VALUE)."</td>
								<td class='positive right aligned'>&#8377;".round($sales_label_avg_price,2)."</td>
								
								<td  class='warning right aligned'>".money_format('%!.0n',$sales_invoice_summary_row->DIGITAL)."</td>
								<td class='warning right aligned'>".money_format('%.0n',$sales_invoice_summary_row->DIGITAL_VALUE)."</td>
								<td class='warning right aligned'>&#8377;".round($sales_digital_avg_price,2)."</td>

								<td  class='right aligned'>".money_format('%!.0n',$total_sales_dia_quantity)."</td>
								<td class='right aligned'>".money_format('%!.0n',$total_sales_dia_value)."</td>
								<td class='right aligned'>&#8377;".round($sales_total_avg_price,2)."</td>
								
					        </tr>";

					       $total_sales_screen_flexo_quantity+=$sales_invoice_summary_row->SCREEN_FLEXO;
					       $total_sales_screen_flexo_value+=$sales_invoice_summary_row->SCREEN_FLEXO_VALUE;
					       $total_sales_offset_quantity+=$sales_invoice_summary_row->OFFSET;
					       $total_sales_offset_value+=$sales_invoice_summary_row->OFFSET_VALUE;
					       $total_sales_label_quantity+=$sales_invoice_summary_row->LABEL;
					       $total_sales_label_value+=$sales_invoice_summary_row->LABEL_VALUE;
					       $total_sales_digital_quantity+=$sales_invoice_summary_row->DIGITAL;
					       $total_sales_digital_value+=$sales_invoice_summary_row->DIGITAL_VALUE;

					       $total_sales_total_quantity=$total_sales_screen_flexo_quantity+$total_sales_offset_quantity+$total_sales_label_quantity+$total_sales_digital_quantity;
					       $total_sales_total_value=$total_sales_screen_flexo_value+$total_sales_offset_value+$total_sales_label_value+$total_sales_digital_value;

					       $total_sales_screen_flexo_avg=($total_sales_screen_flexo_value!=0 ? ($total_sales_screen_flexo_value/$total_sales_screen_flexo_quantity) : 0);
					       $total_sales_offset_avg=($total_sales_offset_value!=0 ? ($total_sales_offset_value/$total_sales_offset_quantity) : 0);
					       $total_sales_label_avg=($total_sales_label_value!=0 ? ($total_sales_label_value/$total_sales_label_quantity) : 0);
					       $total_sales_digital_avg=($total_sales_digital_value!=0 ? ($total_sales_digital_value/$total_sales_digital_quantity) : 0);
					       $total_sales_total_avg=($total_sales_total_value!=0 ? ($total_sales_total_value/$total_sales_total_quantity) : 0);

					       $count++;
					       if($last_count==0){
							//$to_date=strtoupper($row_coex->sales_month)." ".$row_coex->sales_year;
							}
					    }

					    echo "<thead>
							    <tr>
							    	<th>TOTAL</th>
							    	<th></th>
							    	<th class='right aligned'>".money_format('%!.0n',$total_sales_screen_flexo_quantity)."</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_sales_screen_flexo_value)."</th>
									<th class='right aligned'>&#8377;".round($total_sales_screen_flexo_avg,2)."</th>
							    	<th class='right aligned'>".money_format('%!.0n',$total_sales_offset_quantity)."</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_sales_offset_value)."</th>
									<th class='right aligned'>&#8377;".round($total_sales_offset_avg,2)."</th>
							    	<th class='right aligned'>".money_format('%!.0n',$total_sales_label_quantity)."</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_sales_label_value)."</th>
									<th class='right aligned'>&#8377;".round($total_sales_label_avg,2)."</th>
							    	<th class='right aligned'>".money_format('%!.0n',$total_sales_digital_quantity)."</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_sales_digital_value)."</th>
									<th class='right aligned'>&#8377;".round($total_sales_digital_avg,2)."</th>
							    	<th class='right aligned'>".money_format('%!.0n',$total_sales_total_quantity)."</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_sales_total_value)."</th>
									<th class='right aligned'>&#8377;".round($total_sales_total_avg,2)."</th>

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