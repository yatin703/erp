<!--<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/semantic/tablesort.js');?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>-->
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		/*$('table').tablesort();*/
		
		/*$("#adr_company_id").autocomplete("<?php echo base_url('index.php/ajax/customer');?>", {selectFirst: true});*/
		
		$("#search").click(function(){
			$("#loading").show(); $("#cover").show();

			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/print_type_wise_sales_order');?>",data: {from_date : $(".from_date").val(),to_date :$('.to_date').val(),sleeve_dia : $('.sleeve_dia:checked').serialize()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#check").html(html);
				} 
			});
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
									<?php 
									if($account_periods_master==FALSE){
										echo "<tr><td>PLEASE SET THE FISCAL YEAR</td>";
									}else{
									foreach ($account_periods_master as $account_periods_master_row ):?>
									<tr>
										<td class="label"  width="25%">Order From Date <span style="color:red;">*</span>  :</td>
										<td  width="25%"><input type="date" name="from_date" class="from_date" value="<?php echo set_value('from_date',$account_periods_master_row->fin_year_start);?>"/></td>
										<td class="label"  width="25%">Order To Date <span style="color:red;">*</span>  :</td>
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
					if($print_type_wise_sales_order==FALSE){

					}else{
						echo '<table class="ui sortable selectable celled table" style="font-size:10px;">
					        	<thead>
								   <tr>
								    	<th colspan="29"><a class="ui orange label">SALES ORDER</a> <a class="ui green label">ON ORDER DATE</a>';
								    	if($account_periods_master==FALSE){
								    	}else{
								    		foreach ($account_periods_master as $account_periods_master_row ){
								    			echo '<a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date($account_periods_master_row->fin_year_start,$this->session->userdata['logged_in']['company_id']).' TO '.$this->common_model->view_date(date('Y-m-d'),$this->session->userdata['logged_in']['company_id']).'</a><br/><br/>';
								    		}
								    	}
								    	echo ' <a class="ui blue label">INCLUDING DOMESTIC, EXPORT & CANCELLED ORDER</a>
								    	<a class="ui red label">EXCLUDING SAMPLE, DEVELOPMENT,CAP & STOCK SO</a></th>
								  </tr>
								  <tr>
					        			<th colspan="2"></th>
					        			<th colspan="21" class="center aligned">APPROVED</th>
					        			<th colspan="3" class="center aligned">UNAPPROVED</th>
					        			<th colspan="3" class="center aligned">GRAND TOTAL</th>
					        	  </tr>
								  <tr>
					        			<th colspan="2"></th>
					        			<th colspan="12" class="center aligned">COEX TUBE</th>
					        			<th colspan="3" class="center aligned">SPRING TUBE</th>
					        			<th colspan="3" class="center aligned">OTHER (NO SPECS)</th>
					        			<th colspan="3" class="center aligned">TOTAL</th>
					        			<th colspan="3" class="center aligned">TOTAL</th>
					        			<th colspan="3" class="center aligned">TOTAL</th>
					        	  </tr>
								  <tr>
					        			<th colspan="2"></th>
					        			<th colspan="3" class="center aligned">SCREEN+FLEXO</th>
					        			<th colspan="3" class="center aligned">OFFSET</th>
					        			<th colspan="3" class="center aligned">LABEL</th>
					        			<th colspan="3" class="center aligned">COEX TOTAL</th>
					        			<th colspan="3" class="center aligned">DIGITAL</th>
					        			<th colspan="3" class="center aligned">OTHER</th>
					        			<th colspan="3" class="center aligned"></th>
					        			<th colspan="3" class="center aligned"></th>
					        			<th colspan="3" class="center aligned"></th>
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
					        	</thead><tbody>';
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

					 $total_other_quantity=0;
					 $total_other_value=0;
					 $total_other_avg=0;

					 $total_total_print_type_coex_quantity=0;
					 $total_total_print_type_coex_value=0;
					 $total_total_print_type_coex_avg=0;

					 $total_approved_order_quantity=0;
					 $total_approved_order_value=0;
					 $total_approved_order_avg=0;

					 $total_unapproved_order_quantity=0;
					 $total_unapproved_order_value=0;
					 $total_unapproved_order_avg=0;

					 $total_total_print_type_order_quantity=0;
					 $total_total_print_type_order_value=0;
					 $total_total_print_type_order_avg=0;

					 $i=1;
					foreach($print_type_wise_sales_order as $row){
						$total_prin_type_coex_quantity=0;
						$total_prin_type_coex_quantity=$row->APPROVED_SCREEN_FLEXO_QTY+$row->APPROVED_OFFSET_QTY+$row->APPROVED_LABEL_QTY;
						$total_prin_type_coex_value=0;
						$total_prin_type_coex_value=$row->APPROVED_SCREEN_FLEXO_VALUE+$row->APPROVED_OFFSET_VALUE+$row->APPROVED_LABEL_VALUE;
						$total_prin_type_coex_avg=($total_prin_type_coex_value!=0 ? ($total_prin_type_coex_value/$total_prin_type_coex_quantity) : 0);
						
						
						$total_prin_type_quantity=0;
						$total_prin_type_quantity=$row->UNAPPROVED_ORDER_QTY+$row->APPROVED_ORDER_QTY;
						$total_prin_type_value=0;
						$total_prin_type_value=$row->UNAPPROVED_ORDER_VALUE+$row->APPROVED_ORDER_VALUE;

						$total_prin_type_avg=0;
						$total_prin_type_avg=($total_prin_type_value!=0 ? ($total_prin_type_value/$total_prin_type_quantity) : 0);

						
						echo "<tr>
								<td>$i</td>
								<td><b>".$row->ORDER_YEAR."-".strtoupper($row->ORDER_MONTH)."</b></td>
								<td class='negative right aligned'>".money_format('%!.0n',$row->APPROVED_SCREEN_FLEXO_QTY)."</td>
								<td class='negative right aligned'>".money_format('%.0n',$row->APPROVED_SCREEN_FLEXO_VALUE)."</td>
								<td class='negative right aligned'>&#8377;".round($row->APPROVED_SCREEN_FLEXO_AVG,2)."</td>
								<td class='positive right aligned'>".money_format('%!.0n',$row->APPROVED_OFFSET_QTY)."</td>
								<td class='positive right aligned'>".money_format('%.0n',$row->APPROVED_OFFSET_VALUE)."</td>
								<td class='positive right aligned'>&#8377;".round($row->APPROVED_OFFSET_AVG,2)."</td>
								<td class='right aligned'>".money_format('%!.0n',$row->APPROVED_LABEL_QTY)."</td>
								<td class='right aligned'>".money_format('%.0n',$row->APPROVED_LABEL_VALUE)."</td>
								<td class='right aligned'>&#8377;".round($row->APPROVED_LABEL_AVG,2)."</td>

								<td class='active right aligned'>".money_format('%!.0n',$total_prin_type_coex_quantity)."</td>
								<td class='active right aligned'>".money_format('%.0n',$total_prin_type_coex_value)."</td>
								<td class='active right aligned'>&#8377;".round($total_prin_type_coex_avg,2)."</td>

								<td class='negative right aligned'>".money_format('%!.0n',$row->APPROVED_DIGITAL_QTY)."</td>
								<td class='negative right aligned'>".money_format('%.0n',$row->APPROVED_DIGITAL_VALUE)."</td>
								<td class='negative right aligned'>&#8377;".round($row->APPROVED_DIGITAL_AVG,2)."</td>

								<td class='positive right aligned'>".money_format('%!.0n',$row->APPROVED_OTHER_QTY)."</td>
								<td class='positive right aligned'>".money_format('%.0n',$row->APPROVED_OTHER_VALUE)."</td>
								<td class='positive right aligned'>&#8377;".round($row->APPROVED_OTHER_AVG,2)."</td>

								<td class='right aligned'>".money_format('%!.0n',$row->APPROVED_ORDER_QTY)."</td>
								<td class='right aligned'>".money_format('%.0n',$row->APPROVED_ORDER_VALUE)."</td>
								<td class='right aligned'>&#8377;".round($row->APPROVED_ORDER_AVG,2)."</td>


								<td class='negative right aligned'>".money_format('%!.0n',$row->UNAPPROVED_ORDER_QTY)."</td>
								<td class='negative right aligned'>".money_format('%.0n',$row->UNAPPROVED_ORDER_VALUE)."</td>
								<td class='negative right aligned'>&#8377;".round($row->UNAPPROVED_ORDER_AVG,2)."</td>

								<td class='active warning right aligned'>".money_format('%!.0n',$total_prin_type_quantity)."</td>
								<td class='active warning right aligned'>".money_format('%.0n',$total_prin_type_value)."</td>
								<td class='active warning right aligned'>&#8377;".round($total_prin_type_avg,2)."</td>
					        </tr>";
					        
					       $total_screen_flexo_quantity+=$row->APPROVED_SCREEN_FLEXO_QTY;
					       $total_screen_flexo_value+=$row->APPROVED_SCREEN_FLEXO_VALUE;
					       $total_offset_quantity+=$row->APPROVED_OFFSET_QTY;
					       $total_offset_value+=$row->APPROVED_OFFSET_VALUE;
					       $total_label_quantity+=$row->APPROVED_LABEL_QTY;
					       $total_label_value+=$row->APPROVED_LABEL_VALUE;
					       $total_digital_quantity+=$row->APPROVED_DIGITAL_QTY;
					       $total_digital_value+=$row->APPROVED_DIGITAL_VALUE;

					       $total_other_quantity+=$row->APPROVED_OTHER_QTY;
					       $total_other_value+=$row->APPROVED_OTHER_VALUE;

					       $total_approved_order_quantity+=$row->APPROVED_ORDER_QTY;
					       $total_approved_order_value+=$row->APPROVED_ORDER_VALUE;

					       $total_unapproved_order_quantity+=$row->UNAPPROVED_ORDER_QTY;
					       $total_unapproved_order_value+=$row->UNAPPROVED_ORDER_VALUE;

					       $total_total_print_type_order_quantity+=$total_prin_type_quantity;
					 	   $total_total_print_type_order_value+=$total_prin_type_value;

						   $i++;
					    }
					    
					    $total_screen_flexo_avg=($total_screen_flexo_value!=0 ? $total_screen_flexo_value/$total_screen_flexo_quantity : '0');
					    $total_offset_avg=($total_offset_value!=0 ? $total_offset_value/$total_offset_quantity : '0');
					    $total_label_avg=($total_label_value!=0 ? $total_label_value/$total_label_quantity : '0');
					    $total_digital_avg=($total_digital_value!=0 ? $total_digital_value/$total_digital_quantity : '0');
					    $total_other_avg=($total_other_value!=0 ? ($total_other_value/$total_other_quantity) : 0);
					    $total_approved_order_avg=($total_approved_order_value!=0 ? ($total_approved_order_value/$total_approved_order_quantity) : 0);
					    $total_unapproved_order_avg=($total_unapproved_order_value!=0 ? ($total_unapproved_order_value/$total_unapproved_order_quantity) : 0);
					    
					    

					    $total_total_print_type_coex_quantity=$total_screen_flexo_quantity+$total_offset_quantity+$total_label_quantity;
					    $total_total_print_type_coex_value=$total_screen_flexo_value+$total_offset_value+$total_label_value;
					    $total_total_print_type_coex_avg=($total_total_print_type_coex_value<>0 ? ($total_total_print_type_coex_value/$total_total_print_type_coex_quantity) : 0);

					    $total_total_print_type_order_avg=($total_total_print_type_order_value<>0 ? ($total_total_print_type_order_value/$total_total_print_type_order_quantity) : 0);
					    
						
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

							    	<th class='warning right aligned'>".money_format('%!.0n',$total_other_quantity)."</th>
							    	<th class='warning right aligned'>".money_format('%.0n',$total_other_value)."</th>
							    	<th class='warning right aligned'>&#8377;".round($total_other_avg,2)."</th>

							    	<th class='warning right aligned'>".money_format('%!.0n',$total_approved_order_quantity)."</th>
							    	<th class='warning right aligned'>".money_format('%.0n',$total_approved_order_value)."</th>
							    	<th class='warning right aligned'>&#8377;".round($total_approved_order_avg,2)."</th>

							    	

							    	<th class='warning right aligned'>".money_format('%!.0n',$total_unapproved_order_quantity)."</th>
							    	<th class='warning right aligned'>".money_format('%.0n',$total_unapproved_order_value)."</th>
							    	<th class='warning right aligned'>&#8377;".round($total_unapproved_order_avg,2)."</th>

							    	<th class='warning right aligned'>".money_format('%!.0n',$total_total_print_type_order_quantity)."</th>
							    	<th class='warning right aligned'>".money_format('%.0n',$total_total_print_type_order_value)."</th>
							    	<th class='warning right aligned'>&#8377;".round($total_total_print_type_order_avg,2)."</th>

							  	</tr>
							  </thead>";

						echo '</tbody></table>';

					}
				?>
				
				

				</span>

			</div>
  		</div>
		

	

	</div>
</div>