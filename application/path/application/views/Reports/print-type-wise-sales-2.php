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
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/print_type_wise_sales');?>",data: {from_date : $(".from_date").val(),to_date :$('.to_date').val(),for_export :$('#for_export').val(),customer_no : $('.customer_no:checked').serialize(),sleeve_dia : $('.sleeve_dia:checked').serialize(),inv_type : $('.inv_type:checked').serialize(),customer_category :$('#customer_category').val()},cache: false,success: function(html){
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
										<td class="label"  width="25%">From Date <span style="color:red;">*</span>  :</td>
										<td  width="25%"><input type="date" name="from_date" class="from_date" value="<?php echo set_value('from_date',$account_periods_master_row->fin_year_start);?>"/></td>
										<td class="label"  width="25%">To Date <span style="color:red;">*</span>  :</td>
										<td  width="25%"><input type="date" name="to_date" class="to_date" value="<?php echo set_value('to_date',date('Y-m-d'));?>"/></td>
									</tr>
									<?php endforeach;
										}?>
									<!--
									<tr>
										<td class="label">Customer Group :</td>
										<td colspan="3" ><select name="customer_category" id="customer_category" ><option value=''>--Select Category--</option>
										<?php if($customer_category==FALSE){

													echo "<option value=''>--Setup Required--</option>";

												}else{
													foreach($customer_category as $customer_category_row){
														echo "<option value='".$customer_category_row->adr_category_id."'  ".set_select('customer_category',''.$customer_category_row->adr_category_id.'').">".$customer_category_row->category_name."</option>";
												
													}
												}
												?></select></td>
									</tr>-->
									<!--
									<tr>
										<td class="label">Customer   :</td>
										<td colspan="3" ><input type="text" name="customer" id="customer"  size="60" value="<?php echo set_value('customer');?>" /></td>
									</tr>
									-->
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
										<!--
										<td class="label" width="25%">Domestic/Export  :</td>
										<td width="25%"><select name="for_export" id="for_export" >

												<option value="">--Please Select--</option>
												<option value="2" <?php echo set_select('for_export','2');?>>Domestic</option>
												<option value="1" <?php echo set_select('for_export','1');?> >Export</option>
												
											</select>
										</td>-->
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
					<table>
						<tr>
							<td class="label" width="25%"> Invoice Types  :</td>
								<td colspan="3">
									<a id="check-all" class="submit-green" href="javascript:void(0);">Check all</a>
									<a id="uncheck-all" class="submit-green" href="javascript:void(0);">Uncheck all</a>
									<br/>
										<?php
										

											echo '<div class="ui checkbox">
													<input type="checkbox" name="inv_type" class="inv_type" value="1" checked><label>Inter State Sales (1)</label>
													</div><br/>';

											echo '<div class="ui checkbox">
													<input type="checkbox" name="inv_type" class="inv_type" value="2" checked><label>Local Sales (2)</label>
													</div><br/>';

											echo '<div class="ui checkbox">
													<input type="checkbox" name="inv_type" class="inv_type" value="3" checked><label>Local Export Sales(ANN-45) (3)</label>
													</div><br/>';

											echo '<div class="ui checkbox">
													<input type="checkbox" name="inv_type" class="inv_type" value="8" checked><label>SEZ Export Sales (8)</label>
													</div><br/>';

											echo '<div class="ui checkbox">
													<input type="checkbox" name="inv_type" class="inv_type" value="11" checked><label>Export Sales (11)</label>
													</div><br/>';
													/*
										if($invoice_types_master_lang==FALSE){


										}else{
											foreach($invoice_types_master_lang as $row){
													echo '<div class="ui checkbox">
													<input type="checkbox" name="inv_type" class="inv_type" value="'.$row->inv_type_id.'" checked><label>'.$row->lang_inv_type.'</label>
													</div><br/>';
											}
										}*/
																						
										?>
								</td>
						</tr>
					</table>
					<!--
					<table class="form_table_inner">
						<tr>
							<td class="label" width="25%"></td>
							<td width="75%"><span id="hello"></span></td>
						</tr>
					</table>-->
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
					if($print_type_wise_sales_coex==FALSE){

					}else{
						echo '<table class="ui sortable selectable celled table" style="font-size:10px;">
					        	<thead>
								   <tr>
								    	<th colspan="13"><a class="ui orange label">COEX SALES</a>';
								    	if($account_periods_master==FALSE){
								    	}else{
								    		foreach ($account_periods_master as $account_periods_master_row ){
								    			echo '<a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date($account_periods_master_row->fin_year_start,$this->session->userdata['logged_in']['company_id']).' TO '.$this->common_model->view_date(date('Y-m-d'),$this->session->userdata['logged_in']['company_id']).'</a><br/><br/>';
								    		}
								    	}
								    	echo '</th>
								  </tr>
								  <tr>
					        			<th></th>
					        			<th colspan="3" class="center aligned">SCREEN+FLEXO</th>
					        			<th colspan="3" class="center aligned">OFFSET</th>
					        			<th colspan="3" class="center aligned">LABEL</th>
					        			<th colspan="3" class="center aligned">TOTAL</th>
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
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG PRICE</th>
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
					 $total_total_print_type_coex_quantity=0;
					 $total_total_print_type_coex_value=0;
					 $total_total_print_type_coex_avg=0;
					 $count=0;
					 $last_count=0;
					foreach($print_type_wise_sales_coex as $row_coex){
						$screen_flexo_avg_price=0;
						$screen_flexo_avg_price=($row_coex->SCREEN_FLEXO_VALUE!=0 ? $row_coex->SCREEN_FLEXO_VALUE/$row_coex->SCREEN_FLEXO : 0);
						$offset_avg_price=0;
						$offset_avg_price=($row_coex->OFFSET_VALUE!=0 ? $row_coex->OFFSET_VALUE/$row_coex->OFFSET : 0);
						$label_avg_price=0;
						$label_avg_price=($row_coex->LABEL_VALUE!=0 ? $row_coex->LABEL_VALUE/$row_coex->LABEL : 0);
						$total_prin_type_quantity=0;
						$total_prin_type_quantity=$row_coex->SCREEN_FLEXO+$row_coex->OFFSET+$row_coex->LABEL;
						$total_print_type_value=0;
						$total_print_type_value=$row_coex->SCREEN_FLEXO_VALUE+$row_coex->OFFSET_VALUE+$row_coex->LABEL_VALUE;
						$total_print_type_avg_price=0;
						$total_print_type_avg_price=$total_print_type_value/$total_prin_type_quantity;
						if($count==0){
							$from_date=strtoupper($row_coex->sales_month)." ".$row_coex->sales_year;
						}
						echo "<tr>
								<td>".$row_coex->sales_year."-".strtoupper($row_coex->sales_month)."</td>
								<td class='negative right aligned'>".money_format('%!.0n',$row_coex->SCREEN_FLEXO)."</td>
								<td class='negative right aligned'>".money_format('%.0n',$row_coex->SCREEN_FLEXO_VALUE)."</td>
								<td class='negative right aligned'>&#8377;".round($screen_flexo_avg_price,2)."</td>
								<td class='positive right aligned'>".money_format('%!.0n',$row_coex->OFFSET)."</td>
								<td class='positive right aligned'>".money_format('%.0n',$row_coex->OFFSET_VALUE)."</td>
								<td class='positive right aligned'>&#8377;".round($offset_avg_price,2)."</td>
								<td class='right aligned'>".money_format('%!.0n',$row_coex->LABEL)."</td>
								<td class='right aligned'>".money_format('%.0n',$row_coex->LABEL_VALUE)."</td>
								<td class='right aligned'>&#8377;".round($label_avg_price,2)."</td>
								<td class='warning right aligned'>".money_format('%!.0n',$total_prin_type_quantity)."</td>
								<td class='warning right aligned'>".money_format('%.0n',$total_print_type_value)."</td>
								<td class='warning right aligned'>&#8377;".round($total_print_type_avg_price,2)."</td>
					        </tr>";

					       $total_screen_flexo_quantity+=$row_coex->SCREEN_FLEXO;
					       $total_screen_flexo_value+=$row_coex->SCREEN_FLEXO_VALUE;
					       $total_offset_quantity+=$row_coex->OFFSET;
					       $total_offset_value+=$row_coex->OFFSET_VALUE;
					       $total_label_quantity+=$row_coex->LABEL;
					       $total_label_value+=$row_coex->LABEL_VALUE;
					       $count++;
					       if($last_count==0){
							$to_date=strtoupper($row_coex->sales_month)." ".$row_coex->sales_year;
							}
					    }
					    $total_screen_flexo_avg=($total_screen_flexo_value!=0 ? $total_screen_flexo_value/$total_screen_flexo_quantity : '0');
					    $total_offset_avg=($total_offset_value!=0 ? $total_offset_value/$total_offset_quantity : '0');
					    $total_label_avg=($total_label_value!=0 ? $total_label_value/$total_label_quantity : '0');

					    $total_total_print_type_coex_quantity=$total_screen_flexo_quantity+$total_offset_quantity+$total_label_quantity;
					    $total_total_print_type_coex_value=$total_screen_flexo_value+$total_offset_value+$total_label_value;
					    $total_total_print_type_coex_avg=$total_total_print_type_coex_value/$total_total_print_type_coex_quantity;

					    echo "<thead>
							    <tr>
							    	<th>TOTAL</th>
							    	<th class='negative right aligned'>".money_format('%!.0n',$total_screen_flexo_quantity)."</th>
							    	<th class='negative right aligned'>".money_format('%.0n',$total_screen_flexo_value)."</th>
							    	<th class='negative right aligned'>&#8377;".round($total_screen_flexo_avg,2)."</th>
							    	<th class='positive right aligned'>".money_format('%!.0n',$total_offset_quantity)."</th>
							    	<th class='positive right aligned'>".money_format('%.0n',$total_offset_value)."</th>
							    	<th class='positive right aligned'>&#8377;".round($total_offset_avg,2)."</th>
							    	<th class='positive right aligned'>".money_format('%!.0n',$total_label_quantity)."</th>
							    	<th class='positive right aligned'>".money_format('%.0n',$total_label_value)."</th>
							    	<th class='positive right aligned'>&#8377;".round($total_label_avg,2)."</th>
							    	<th class='warning right aligned'>".money_format('%!.0n',$total_total_print_type_coex_quantity)."</th>
							    	<th class='warning right aligned'>".money_format('%.0n',$total_total_print_type_coex_value)."</th>
							    	<th class='warning right aligned'>&#8377;".round($total_total_print_type_coex_avg,2)."</th>
							  	</tr>
							  </thead>";

						echo '</table>';

					}
				?>
				
				<?php
					setlocale(LC_MONETARY, 'en_IN');
					if($print_type_wise_sales_spring==FALSE){

					}else{
						echo '
						<br/>
							<div style="text-align:center;"><i class="plus circle icon"></i></div>
						<br/>
						<table class="ui sortable selectable celled table" style="font-size:10px;">
					        	<thead>
								   <tr>
								    	<th colspan="13"><a class="ui yellow label">SPRING SALES</a>';
								    	if($account_periods_master==FALSE){
								    	}else{
								    		foreach ($account_periods_master as $account_periods_master_row ){
								    			echo '<a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date($account_periods_master_row->fin_year_start,$this->session->userdata['logged_in']['company_id']).' TO '.$this->common_model->view_date(date('Y-m-d'),$this->session->userdata['logged_in']['company_id']).'</a><br/><br/>';
								    		}
								    	}
								    	echo '</th>
								  </tr>

								  	<tr>
					        			<th></th>
					        			<th colspan="3" class="center aligned">FLEXO+DIGITAL+FLEXO</th>
					        			<th colspan="3" class="center aligned">DIGITAL+FLEXO</th>
					        			<th colspan="3" class="center aligned">TOTAL</th>
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
					 $total_flexo_digital_flexo_quantity=0;
					 $total_flexo_digital_flexo_value=0;
					 $total_flexo_digital_flexo_avg=0;
					 $total_flexo_digital_quantity=0;
					 $total_flexo_digital_value=0;
					 $total_flexo_digital_avg=0;
					 $total_total_print_type_quantity=0;
					 $total_total_print_type_value=0;
					 $total_total_print_type_avg=0;
					 $count=0;
					foreach($print_type_wise_sales_spring as $row_coex){
						$flexo_digital_flexo_avg_price=0;
						$flexo_digital_flexo_avg_price=($row_coex->FLEXO_DIGITAL_FLEXO_VALUE!=0 ? $row_coex->FLEXO_DIGITAL_FLEXO_VALUE/$row_coex->FLEXO_DIGITAL_FLEXO : 0);
						$flexo_digital_avg_price=0;
						$flexo_digital_avg_price=($row_coex->FLEXO_DIGITAL_VALUE!=0 ? $row_coex->FLEXO_DIGITAL_VALUE/$row_coex->FLEXO_DIGITAL : 0);
						
						$total_prin_type_quantity=0;
						$total_prin_type_quantity=$row_coex->FLEXO_DIGITAL+$row_coex->FLEXO_DIGITAL_FLEXO;
						$total_print_type_value=0;
						$total_print_type_value=$row_coex->FLEXO_DIGITAL_VALUE+$row_coex->FLEXO_DIGITAL_FLEXO_VALUE;
						$total_print_type_avg_price=0;
						$total_print_type_avg_price=$total_print_type_value/$total_prin_type_quantity;
						echo "<tr>
								<td>".$row_coex->sales_year."-".strtoupper($row_coex->sales_month)."</td>
								<td class='negative right aligned'>".money_format('%!.0n',$row_coex->FLEXO_DIGITAL_FLEXO)."</td>
								<td class='negative right aligned'>".money_format('%.0n',$row_coex->FLEXO_DIGITAL_FLEXO_VALUE)."</td>
								<td class='negative right aligned'>&#8377;".round($flexo_digital_flexo_avg_price,2)."</td>
								<td class='positive right aligned'>".money_format('%!.0n',$row_coex->FLEXO_DIGITAL)."</td>
								<td class='positive right aligned'>".money_format('%.0n',$row_coex->FLEXO_DIGITAL_VALUE)."</td>
								<td class='positive right aligned'>&#8377;".round($flexo_digital_avg_price,2)."</td>
								<td class='warning right aligned'>".money_format('%!.0n',$total_prin_type_quantity)."</td>
								<td class='warning right aligned'>".money_format('%.0n',$total_print_type_value)."</td>
								<td class='warning right aligned'>&#8377;".round($total_print_type_avg_price,2)."</td>
					        </tr>";

					       $total_flexo_digital_flexo_quantity+=$row_coex->FLEXO_DIGITAL_FLEXO;
					       $total_flexo_digital_flexo_value+=$row_coex->FLEXO_DIGITAL_FLEXO_VALUE;
					       $total_flexo_digital_quantity+=$row_coex->FLEXO_DIGITAL;
					       $total_flexo_digital_value+=$row_coex->FLEXO_DIGITAL_VALUE;

					    }
					    $total_flexo_digital_flexo_avg=($total_flexo_digital_flexo_value!=0 ? $total_flexo_digital_flexo_value/$total_flexo_digital_flexo_quantity : '0');
					    $total_flexo_digital_avg=($total_flexo_digital_value!=0 ? $total_flexo_digital_value/$total_flexo_digital_quantity : '0');

					    $total_total_print_type_quantity=$total_flexo_digital_flexo_quantity+$total_flexo_digital_quantity;
					    $total_total_print_type_value=$total_flexo_digital_flexo_value+$total_flexo_digital_value;
					    $total_total_print_type_avg=$total_total_print_type_value/$total_total_print_type_quantity;

					    echo "<thead>
							    <tr>
							    	<th>TOTAL</th>
							    	<th class='negative right aligned'>".money_format('%!.0n',$total_flexo_digital_flexo_quantity)."</th>
							    	<th class='negative right aligned'>".money_format('%.0n',$total_flexo_digital_flexo_value)."</th>
							    	<th class='negative right aligned'>&#8377;".round($total_flexo_digital_flexo_avg,2)."</th>
							    	<th class='positive right aligned'>".money_format('%!.0n',$total_flexo_digital_quantity)."</th>
							    	<th class='positive right aligned'>".money_format('%.0n',$total_flexo_digital_value)."</th>
							    	<th class='positive right aligned'>&#8377;".round($total_flexo_digital_avg,2)."</th>
							    	<th class='warning right aligned'>".money_format('%!.0n',$total_total_print_type_quantity)."</th>
							    	<th class='warning right aligned'>".money_format('%.0n',$total_total_print_type_value)."</th>
							    	<th class='warning right aligned'>&#8377;".round($total_total_print_type_avg,2)."</th>
							  	</tr>
							  </thead>";

						echo '</table>';
					}
				?>
				<?php
					setlocale(LC_MONETARY, 'en_IN');
					if($print_type_wise_sales_coex==FALSE || $print_type_wise_sales_spring==FALSE){

					}else{
						echo '
							<br/>
								<div style="text-align:center;"><i class="bars icon"></i></div>
							<br/>
							<div class="ui two column centered grid">
								<div class="column">
								<table class="ui sortable selectable celled table" style="font-size:10px;">
					        	<thead>
					        		<tr>
								   		<th>TUBE SALES</th>
								    	<th>YEAR</th>
								    	<th>QUANTITY</th>
								    	<th>VALUE</th>
								    	<th>AVG PRICE</th>
								  	</tr>
								</thead>
								<tbody>
								  	<tr>
								   		<td>COEX SALES</td>
								    	<td>'.$from_date.'-'.$to_date.'</td>
								    	<td>'.money_format('%!.0n',$total_total_print_type_coex_quantity).'</td>
								    	<td>'.money_format('%.0n',$total_total_print_type_coex_value).'</td>
								    	<td>&#8377;'.round($total_total_print_type_coex_avg,2).'</td>
								  	</tr>

								  	<tr>
								   		<td>SPRING SALES</td>
								    	<td>'.$from_date.'-'.$to_date.'</td>
								    	<td>'.money_format('%!.0n',$total_total_print_type_quantity).'</td>
								    	<td>'.money_format('%.0n',$total_total_print_type_value).'</td>
								    	<td>&#8377;'.round($total_total_print_type_avg,2).'</td>
								  	</tr></tbody>';
								  	$avg=($total_total_print_type_value+$total_total_print_type_coex_value)/($total_total_print_type_quantity+$total_total_print_type_coex_quantity);
								
								 echo '<thead>
								 		<tr>
								   		<th>TOTAL</th>
								    	<th></th>
								    	<th>'.money_format('%!.0n',$total_total_print_type_quantity+$total_total_print_type_coex_quantity).'</th>
								    	<th>'.money_format('%.0n',$total_total_print_type_value+$total_total_print_type_coex_value).'</th>
								    	<th>&#8377;'.round($avg,2).'</th>
								  		</tr>
								  	</thead>
								  </table>
								 </div>
								</div>';
					}
					?>

					


				</span>

			</div>
  		</div>
		

	

	</div>
</div>