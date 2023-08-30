
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		
		$(".toggler").click(function(e){
        e.preventDefault();
        $('.cat'+$(this).attr('data-prod-cat')).toggle();
		});
		
		$("#search").click(function(){
			$("#loading").show(); $("#cover").show();

			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/top_customer_sales');?>",data: {from_date : $(".from_date").val(),to_date :$('.to_date').val()},cache: false,success: function(html){
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
									<!--
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
				<!--
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
					if($top_customer_coex==FALSE){

					}else{
						echo '<table class="ui sortable selectable celled table" style="font-size:10px;">
					        	<thead>
								   <tr>
								    	<th colspan="19"><a class="ui orange label">SALES </a>';
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
					        			<th colspan="9" class="center aligned">COEX TUBE</th>
					        			<th colspan="3" class="center aligned">SPRING TUBE</th>
					        			<th colspan="5" class="center aligned">GRAND TOTAL</th>
					        		</tr>
								  	<tr>
					        			<th colspan="2"></th>
					        			<th colspan="3" class="center aligned">SCREEN+FLEXO</th>
					        			<th colspan="3" class="center aligned">OFFSET</th>
					        			<th colspan="3" class="center aligned">LABEL</th>
					        			<th colspan="3" class="center aligned">DIGITAL</th>
					        			<th colspan="5" class="center aligned">TOTAL</th>
					        		</tr>
								  <tr>
					        			<th>SR NO</th>
					        			<th>CUSTOMER</th>
					        			<th class="active right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">AVG</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">Q %</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">V %</th>
					        			<th class="right aligned">AVG</th>
					        		</tr>
					        	</thead><tbody>';
					 $count=1;
					 $last_count=0;
					 
					 $total_screen_flexo_coex_quantity=0;
					 $total_screen_flexo_coex_value=0;
					 $total_screen_flexo_coex_avg_price=0;

					 $total_offset_coex_quantity=0;
					 $total_offset_coex_value=0;
					 $total_offset_coex_avg_price=0;

					 $total_label_coex_quantity=0;
					 $total_label_coex_value=0;
					 $total_label_coex_avg_price=0;


					 $total_digital_spring_quantity=0;
					 $total_digital_spring_value=0;
					 $total_digital_spring_avg_price=0;

					 $total_sales_coex_quantity=0;
					 $total_sales_coex_value=0;
					 $total_sales_coex_avg_price=0;

					 $total_sales_coex_quantity_for_per=0;
					 $total_sales_coex_value_for_per=0;


					 $total_ten_screen_flexo_coex_quantity=0;
					 $total_ten_screen_flexo_coex_value=0;

					 $total_ten_offset_coex_quantity=0;
					 $total_ten_offset_coex_value=0;

					 $total_ten_label_coex_quantity=0;
					 $total_ten_label_coex_value=0;

					 $total_ten_digital_spring_quantity=0;
					 $total_ten_digital_spring_value=0;

					 $total_ten_sales_coex_quantity=0;
					 $total_ten_sales_coex_value=0;

					 $total_other_screen_flexo_coex_quantity=0;
					 $total_other_screen_flexo_coex_value=0;

					 $total_other_offset_coex_quantity=0;
					 $total_other_offset_coex_value=0;

					 $total_other_label_coex_quantity=0;
					 $total_other_label_coex_value=0;

					 $total_other_digital_spring_quantity=0;
					 $total_other_digital_spring_value=0;

					 $total_other_sales_coex_quantity=0;
					 $total_other_sales_coex_value=0;


					 $i=0;
					foreach($top_customer_coex as $row_coex){
						$total_sales_coex_quantity_for_per+=$row_coex->sale_quantity;
						$total_sales_coex_value_for_per+=$row_coex->value;
						$i++;
					}
						
					foreach($top_customer_coex as $row_coex){
						$avg_coex_rate=($row_coex->value/$row_coex->sale_quantity);
						$screen_flexo_avg_price=0;
						$screen_flexo_avg_price=($row_coex->SCREEN_FLEXO_VALUE!=0 ? $row_coex->SCREEN_FLEXO_VALUE/$row_coex->SCREEN_FLEXO : 0);
						$offset_avg_price=0;
						$offset_avg_price=($row_coex->OFFSET_VALUE!=0 ? $row_coex->OFFSET_VALUE/$row_coex->OFFSET : 0);
						$label_avg_price=0;
						$label_avg_price=($row_coex->LABEL_VALUE!=0 ? $row_coex->LABEL_VALUE/$row_coex->LABEL : 0);
						$digital_avg_price=0;
						$digital_avg_price=($row_coex->DIGITAL_VALUE!=0 ? $row_coex->DIGITAL_VALUE/$row_coex->DIGITAL : 0);

						echo "<tr "; echo $a=($count>10 ? "class='cat1' style='display:none'" : "NO");  echo ">
								<td>$count</td>
								<td>$row_coex->customer</td>
								<td class='negative right aligned'>".money_format('%!.0n',$row_coex->SCREEN_FLEXO)."</td>
								<td class='negative right aligned'>".money_format('%.0n',$row_coex->SCREEN_FLEXO_VALUE)."</td>
								<td class='negative right aligned'>&#8377;".round($screen_flexo_avg_price,2)."</td>
								<td class='positive right aligned'>".money_format('%!.0n',$row_coex->OFFSET)."</td>
								<td class='positive right aligned'>".money_format('%.0n',$row_coex->OFFSET_VALUE)."</td>
								<td class='positive right aligned'>&#8377;".round($offset_avg_price,2)."</td>
								<td class='right aligned'>".money_format('%!.0n',$row_coex->LABEL)."</td>
								<td class='right aligned'>".money_format('%.0n',$row_coex->LABEL_VALUE)."</td>
								<td class='right aligned'>&#8377;".round($label_avg_price,2)."</td>
								<td class='negative right aligned'>".money_format('%!.0n',$row_coex->DIGITAL)."</td>
								<td class='negative right aligned'>".money_format('%.0n',$row_coex->DIGITAL_VALUE)."</td>
								<td class='negative right aligned'>&#8377;".round($digital_avg_price,2)."</td>
								<td class='warning right aligned'>".money_format('%!.0n',$row_coex->sale_quantity)."</td>
								<td class='warning right aligned'>".round((($row_coex->sale_quantity/$total_sales_coex_quantity_for_per)*100))."%</td>
								<td class='warning right aligned'>".money_format('%.0n',$row_coex->value)."</td>
								<td class='warning right aligned'>".round((($row_coex->value/$total_sales_coex_value_for_per)*100))."%</td>
								<td class='warning right aligned'>&#8377;".round($avg_coex_rate,2)."</td>

								
					        </tr>";

					        

					        $total_ten_screen_flexo_coex_quantity+=$row_coex->SCREEN_FLEXO;
							$total_ten_screen_flexo_coex_value+=$row_coex->SCREEN_FLEXO_VALUE;

							$total_ten_offset_coex_quantity+=$row_coex->OFFSET;
							$total_ten_offset_coex_value+=$row_coex->OFFSET_VALUE;

							$total_ten_label_coex_quantity+=$row_coex->LABEL;
							$total_ten_label_coex_value+=$row_coex->LABEL_VALUE;

							$total_ten_digital_spring_quantity+=$row_coex->DIGITAL;
							$total_ten_digital_spring_value+=$row_coex->DIGITAL_VALUE;

							$total_ten_sales_coex_quantity+=$row_coex->sale_quantity;
							$total_ten_sales_coex_value+=$row_coex->value;

					        if($count==10){

					        	$total_ten_screen_flexo_coex_avg_price=0;
							    $total_ten_screen_flexo_coex_avg_price=($total_ten_screen_flexo_coex_value!=0 ? ($total_ten_screen_flexo_coex_value/$total_ten_screen_flexo_coex_quantity) : 0);

							    $total_ten_offset_coex_avg_price=0;
							    $total_ten_offset_coex_avg_price=($total_ten_offset_coex_value!=0 ? ($total_ten_offset_coex_value/$total_ten_offset_coex_quantity) : 0);

							    $total_ten_label_coex_avg_price=0;
							    $total_ten_label_coex_avg_price=($total_ten_label_coex_value!=0 ? ($total_ten_label_coex_value/$total_ten_label_coex_quantity) : 0);

							    $total_ten_digital_spring_avg_price=0;
							    $total_ten_digital_spring_avg_price=($total_ten_digital_spring_value!=0 ? ($total_ten_digital_spring_value/$total_ten_digital_spring_quantity) : 0);

							    $total_ten_sales_coex_avg_price=0;
							    $total_ten_sales_coex_avg_price=($total_ten_sales_coex_value!=0 ? ($total_ten_sales_coex_value/$total_ten_sales_coex_quantity) : 0);

					        	echo "<thead><tr>
										<th colspan='2'>TOP 10 TOTAL</th>
										<th class='negative right aligned'>".money_format('%!.0n',$total_ten_screen_flexo_coex_quantity)."</th>
										<th class='negative right aligned'>".money_format('%.0n',$total_ten_screen_flexo_coex_value)."</th>
										<th class='negative right aligned'>&#8377;".round($total_ten_screen_flexo_coex_avg_price,2)."</th>
										<th class='positive right aligned'>".money_format('%!.0n',$total_ten_offset_coex_quantity)."</th>
										<th class='positive right aligned'>".money_format('%.0n',$total_ten_offset_coex_value)."</th>
										<th class='positive right aligned'>&#8377;".round($total_ten_offset_coex_avg_price,2)."</th>
										<th class='right aligned'>".money_format('%!.0n',$total_ten_label_coex_quantity)."</th>
										<th class='right aligned'>".money_format('%.0n',$total_ten_label_coex_value)."</th>
										<th class='right aligned'>&#8377;".round($total_ten_label_coex_avg_price,2)."</th>

										<th class='negative right aligned'>".money_format('%!.0n',$total_ten_digital_spring_quantity)."</th>
										<th class='negative right aligned'>".money_format('%.0n',$total_ten_digital_spring_value)."</th>
										<th class='negative right aligned'>&#8377;".round($total_ten_digital_spring_avg_price,2)."</th>

										<th class='warning right aligned'>".money_format('%!.0n',$total_ten_sales_coex_quantity)."</th>
										<th class='warning right aligned'>".round((($total_ten_sales_coex_quantity/$total_sales_coex_quantity_for_per)*100))."%</th>

										<th class='warning right aligned'>".money_format('%.0n',$total_ten_sales_coex_value)."</th>
										<th class='warning right aligned'>".round((($total_ten_sales_coex_value/$total_sales_coex_value_for_per)*100))."%</th>
										<th class='warning right aligned'>&#8377;".round($total_ten_sales_coex_avg_price,2)."</th>
							        </tr></thead>";

					        }
					       $total_screen_flexo_coex_quantity+=$row_coex->SCREEN_FLEXO;
					       $total_screen_flexo_coex_value+=$row_coex->SCREEN_FLEXO_VALUE;

					       $total_offset_coex_quantity+=$row_coex->OFFSET;
					       $total_offset_coex_value+=$row_coex->OFFSET_VALUE;


					       $total_label_coex_quantity+=$row_coex->LABEL;
					       $total_label_coex_value+=$row_coex->LABEL_VALUE;

					       $total_digital_spring_quantity+=$row_coex->DIGITAL;
					       $total_digital_spring_value+=$row_coex->DIGITAL_VALUE;

					       $total_sales_coex_quantity+=$row_coex->sale_quantity;
					       $total_sales_coex_value+=$row_coex->value;

					       if($count>10){
					       	 $total_other_screen_flexo_coex_quantity+=$row_coex->SCREEN_FLEXO;
					       	 $total_other_screen_flexo_coex_value+=$row_coex->SCREEN_FLEXO_VALUE;

							 $total_other_offset_coex_quantity+=$row_coex->OFFSET;
							 $total_other_offset_coex_value+=$row_coex->OFFSET_VALUE;

							 $total_other_label_coex_quantity+=$row_coex->LABEL;
							 $total_other_label_coex_value+=$row_coex->LABEL_VALUE;

							 $total_other_digital_spring_quantity+=$row_coex->DIGITAL;
							 $total_other_digital_spring_value+=$row_coex->DIGITAL_VALUE;

							 $total_other_sales_coex_quantity+=$row_coex->sale_quantity;
							 $total_other_sales_coex_value+=$row_coex->value;
					       }

					       	$count++;
						       
					    }

					    	$total_other_screen_flexo_coex_avg_price=0;
					       	$total_other_screen_flexo_coex_avg_price=($total_other_screen_flexo_coex_value!=0 ? ($total_other_screen_flexo_coex_value/$total_other_screen_flexo_coex_quantity) : 0);

					       	$total_other_offset_coex_avg_price=0;
					       	$total_other_offset_coex_avg_price=($total_other_offset_coex_value!=0 ? ($total_other_offset_coex_value/$total_other_offset_coex_quantity) : 0);

					       	$total_other_label_coex_avg_price=0;
					       	$total_other_label_coex_avg_price=($total_other_label_coex_value!=0 ? ($total_other_label_coex_value/$total_other_label_coex_quantity) : 0);

					       	$total_other_digital_spring_avg_price=0;
					       	$total_other_digital_spring_avg_price=($total_other_digital_spring_value!=0 ? ($total_other_digital_spring_value/$total_other_digital_spring_quantity) : 0);

					       	$total_other_sales_coex_avg_price=0;
					       	$total_other_sales_coex_avg_price=($total_other_sales_coex_value!=0 ? ($total_other_sales_coex_value/$total_other_sales_coex_quantity) : 0);
					    
					    	

					    echo "</tbody><tfoot>
							    <tr>
							    	<th colspan='2'><a href='#'' class='toggler' data-prod-cat='1'>OTHER TOTAL</a></th>
							    	<th class='right aligned'>".money_format('%!.0n',$total_other_screen_flexo_coex_quantity)."</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_other_screen_flexo_coex_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_other_screen_flexo_coex_avg_price,2)."</th>

							    	<th class='right aligned'>".money_format('%!.0n',$total_other_offset_coex_quantity)."</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_other_offset_coex_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_other_offset_coex_avg_price,2)."</th>


							    	<th class='right aligned'>".money_format('%!.0n',$total_other_label_coex_quantity)."</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_other_label_coex_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_other_label_coex_avg_price,2)."</th>

							    	<th class='negative right aligned'>".money_format('%!.0n',$total_other_digital_spring_quantity)."</th>
									<th class='negative right aligned'>".money_format('%.0n',$total_other_digital_spring_value)."</th>
									<th class='negative right aligned'>&#8377;".round($total_other_digital_spring_avg_price,2)."</th>

							    	<th class='right aligned'>".money_format('%!.0n',$total_other_sales_coex_quantity)."</th>
							    	<th class='right aligned'>".round((($total_other_sales_coex_quantity/$total_sales_coex_quantity_for_per)*100))."%</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_other_sales_coex_value)."</th>
							    	<th class='right aligned'>".round((($total_other_sales_coex_value/$total_sales_coex_value_for_per)*100))."%</th>
							    	<th class='right aligned'>&#8377;".round($total_other_sales_coex_avg_price,2)."</th>

							  	</tr>
							  </tfoot>";


							$total_screen_flexo_coex_avg_price=0;
					       	$total_screen_flexo_coex_avg_price=($total_screen_flexo_coex_value!=0 ? ($total_screen_flexo_coex_value/$total_screen_flexo_coex_quantity) : 0);

					       	$total_offset_coex_avg_price=0;
					       	$total_offset_coex_avg_price=($total_offset_coex_value!=0 ? ($total_offset_coex_value/$total_offset_coex_quantity) : 0);

					       	$total_label_coex_avg_price=0;
					       	$total_label_coex_avg_price=($total_label_coex_value!=0 ? ($total_label_coex_value/$total_label_coex_quantity) : 0);

					       	$total_digital_spring_avg_price=0;
					       	$total_digital_spring_avg_price=($total_digital_spring_value!=0 ? ($total_digital_spring_value/$total_digital_spring_quantity) : 0);

					       	$total_sales_coex_avg_price=0;
					       	$total_sales_coex_avg_price=($total_sales_coex_value!=0 ? ($total_sales_coex_value/$total_sales_coex_quantity) : 0);

						 echo "<tfoot>
							    <tr>
							    	<th colspan='2'>GRAND TOTAL</th>
							    	<th class='right aligned'>".money_format('%!.0n',$total_screen_flexo_coex_quantity)."</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_screen_flexo_coex_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_screen_flexo_coex_avg_price,2)."</th>

							    	<th class='right aligned'>".money_format('%!.0n',$total_offset_coex_quantity)."</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_offset_coex_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_offset_coex_avg_price,2)."</th>


							    	<th class='right aligned'>".money_format('%!.0n',$total_label_coex_quantity)."</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_label_coex_value)."</th>
							    	<th class='right aligned'>&#8377;".round($total_label_coex_avg_price,2)."</th>

							    	<th class='negative right aligned'>".money_format('%!.0n',$total_digital_spring_quantity)."</th>
									<th class='negative right aligned'>".money_format('%.0n',$total_digital_spring_value)."</th>
									<th class='negative right aligned'>&#8377;".round($total_digital_spring_avg_price,2)."</th>

							    	<th class='right aligned'>".money_format('%!.0n',$total_sales_coex_quantity)."</th>
							    	<th class='right aligned'>".round((($total_sales_coex_quantity/$total_sales_coex_quantity_for_per)*100))."%</th>
							    	<th class='right aligned'>".money_format('%.0n',$total_sales_coex_value)."</th>
							    	<th class='right aligned'>".round((($total_sales_coex_value/$total_sales_coex_value_for_per)*100))."%</th>
							    	<th class='right aligned'>&#8377;".round($total_sales_coex_avg_price,2)."</th>

							  	</tr>
							  </tfoot>";

						echo '</table>';

					}
				?>
				</span>

			</div>
  		</div>
		

	

	</div>
</div>