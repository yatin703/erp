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
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/contribution_by_customer');?>",data: {from_date : $(".from_date").val(),to_date :$('.to_date').val(),convert:$('.convert').val()},cache: false,success: function(html){
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
							<td class="label" width="25%">Convert</td>
							<td colspan="3"><select name="convert" class="convert">
								<option value="0">INR</option>
								<option value="1">Millions</option
							</select></td>
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
					if($print_type_wise==FALSE){

					}else{
						echo '<table class="ui sortable selectable celled table" style="font-size:9px;">
					        	<thead>
								   <tr>
								    	<th colspan="32"><a class="ui orange label">CONTRIBUTION BY CUSTOMER</a>';
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
					        			<th colspan="20" class="center aligned">COEX TUBE</th>
					        			<th colspan="5" class="center aligned">SPRING TUBE</th>
					        			<th colspan="5" class="center aligned">GRAND TOTAL</th>
					        	  </tr>
								  <tr>
					        			<th colspan="2"></th>
					        			<th colspan="5" class="center aligned">SCREEN+FLEXO</th>
					        			<th colspan="5" class="center aligned">OFFSET</th>
					        			<th colspan="5" class="center aligned">LABEL</th>
					        			<th colspan="5" class="center aligned">COEX</th>
					        			<th colspan="5" class="center aligned">DIGITAL</th>
					        			<th colspan="5" class="center aligned">MONTH WISE TOTAL</th>
					        		</tr>
					        		<tr>
					        			<th>SR NO</th>
					        			<th>CUSTOMER</th>
					        			<th class="active right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">CONTR</th>
					        			<th class="right aligned">AVG PRICE</th>					        			
					        			<th class="right aligned">CONTR/TUBE</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">CONTR</th>					        			
					        			<th class="right aligned">AVG PRICE</th>					        			
					        			<th class="right aligned">CONTR/TUBE</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">CONTR</th>
					        			<th class="right aligned">AVG PRICE</th>					        			
					        			<th class="right aligned">CONTR/TUBE</th>
					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">CONTR</th>
					        			<th class="right aligned">AVG PRICE</th>					        			
					        			<th class="right aligned">CONTR/TUBE</th>

					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">CONTR</th>
					        			<th class="right aligned">AVG PRICE</th>					        			
					        			<th class="right aligned">CONTR/TUBE</th>

					        			<th class="right aligned">QUANTITY</th>
					        			<th class="right aligned">VALUE</th>
					        			<th class="right aligned">CONTR</th>
					        			<th class="right aligned">AVG PRICE</th>
					        			<th class="right aligned">CONTR/TUBE</th>

					        		</tr>
					        	</thead>';
					        	$count=1;
					        	$i=1;
					        	$total_screen_flexo_quantity=0;
					        	$total_screen_flexo_value=0;
					        	$total_screen_flexo_contribution_value=0;

					        	$total_offset_quantity=0;
					        	$total_offset_value=0;
					        	$total_offset_contribution_value=0;

					        	$total_label_quantity=0;
					        	$total_label_value=0;
					        	$total_label_contribution_value=0;

					        	$total_coex_quantity=0;
					        	$total_coex_value=0;
					        	$total_coex_contribution_value=0;


					        	$total_spring_quantity=0;
					        	$total_spring_value=0;
					        	$total_spring_contribution_value=0;


					        	$total_grand_quantity=0;
					        	$total_grand_value=0;
					        	$total_grand_contribution_value=0;

					        	$total_ten_screen_flexo_quantity=0;
					        	$total_ten_screen_flexo_value=0;
					        	$total_ten_screen_flexo_contribution_value=0;

					        	$total_ten_offset_quantity=0;
					        	$total_ten_offset_value=0;
					        	$total_ten_offset_contribution_value=0;

					        	$total_ten_label_quantity=0;
					        	$total_ten_label_value=0;
					        	$total_ten_label_contribution_value=0;

					        	$total_ten_coex_quantity=0;
					        	$total_ten_coex_value=0;
					        	$total_ten_coex_contribution_value=0;

					        	$total_ten_spring_quantity=0;
					        	$total_ten_spring_value=0;
					        	$total_ten_spring_contribution_value=0;


					        	$total_ten_grand_quantity=0;
					        	$total_ten_grand_value=0;
					        	$total_ten_grand_contribution_value=0;



					        	$total_other_screen_flexo_quantity=0;
					        	$total_other_screen_flexo_value=0;
					        	$total_other_screen_flexo_contribution_value=0;

					        	$total_other_offset_quantity=0;
					        	$total_other_offset_value=0;
					        	$total_other_offset_contribution_value=0;

					        	$total_other_label_quantity=0;
					        	$total_other_label_value=0;
					        	$total_other_label_contribution_value=0;

					        	$total_other_coex_quantity=0;
					        	$total_other_coex_value=0;
					        	$total_other_coex_contribution_value=0;

					        	$total_other_spring_quantity=0;
					        	$total_other_spring_value=0;
					        	$total_other_spring_contribution_value=0;


					        	$total_other_grand_quantity=0;
					        	$total_other_grand_value=0;
					        	$total_other_grand_contribution_value=0;



								foreach($print_type_wise as $row_coex){
									$screen_flexo_avg_price=0;
									$screen_flexo_avg_price=($row_coex->SCREEN_FLEXO_SALE_VALUE!=0 ? $row_coex->SCREEN_FLEXO_SALE_VALUE/$row_coex->SCREEN_FLEXO_QUANTITY : 0);
									$screen_flexo_contribution_tube=0;
									$screen_flexo_contribution_tube=($row_coex->SCREEN_FLEXO_CONTR_VALUE!=0 ? $row_coex->SCREEN_FLEXO_CONTR_VALUE/$row_coex->SCREEN_FLEXO_QUANTITY : 0);


									$offset_avg_price=0;
									$offset_avg_price=($row_coex->OFFSET_SALE_VALUE!=0 ? $row_coex->OFFSET_SALE_VALUE/$row_coex->OFFSET_QUANTITY : 0);
									$offset_contribution_tube=0;
									$offset_contribution_tube=($row_coex->OFFSET_CONTR_VALUE!=0 ? $row_coex->OFFSET_CONTR_VALUE/$row_coex->OFFSET_QUANTITY : 0);

									$label_avg_price=0;
									$label_avg_price=($row_coex->LABEL_SALE_VALUE!=0 ? $row_coex->LABEL_SALE_VALUE/$row_coex->LABEL_QUANTITY : 0);
									$label_contribution_tube=0;
									$label_contribution_tube=($row_coex->LABEL_CONTR_VALUE!=0 ? $row_coex->LABEL_CONTR_VALUE/$row_coex->LABEL_QUANTITY : 0);

									$spring_avg_price=0;
									$spring_avg_price=($row_coex->SPRING_SALE_VALUE!=0 ? $row_coex->SPRING_SALE_VALUE/$row_coex->SPRING_QUANTITY : 0);
									$spring_contribution_tube=0;
									$spring_contribution_tube=($row_coex->SPRING_CONTR_VALUE!=0 ? $row_coex->SPRING_CONTR_VALUE/$row_coex->SPRING_QUANTITY : 0);	


									$total_print_type_coex_quantity=0;
									$total_print_type_coex_quantity=$row_coex->SCREEN_FLEXO_QUANTITY+$row_coex->OFFSET_QUANTITY+$row_coex->LABEL_QUANTITY;

									$total_print_type_coex_value=0;
									$total_print_type_coex_value=$row_coex->SCREEN_FLEXO_SALE_VALUE+$row_coex->OFFSET_SALE_VALUE+$row_coex->LABEL_SALE_VALUE;

									$total_print_type_coex_contr=0;
									$total_print_type_coex_contr=$row_coex->SCREEN_FLEXO_CONTR_VALUE+$row_coex->OFFSET_CONTR_VALUE+$row_coex->LABEL_CONTR_VALUE;

									$total_print_type_coex_avg_price=0;
									$total_print_type_coex_avg_price=($total_print_type_coex_value!=0 ? $total_print_type_coex_value/$total_print_type_coex_quantity : 0);

									$total_print_type_coex_contr_tube=0;
									$total_print_type_coex_contr_tube=($total_print_type_coex_contr!=0 ? $total_print_type_coex_contr/$total_print_type_coex_quantity : 0);

									$total_print_type_quantity=0;
									$total_print_type_quantity=$row_coex->SCREEN_FLEXO_QUANTITY+$row_coex->OFFSET_QUANTITY+$row_coex->LABEL_QUANTITY+$row_coex->SPRING_QUANTITY;

									$total_print_type_value=0;
									$total_print_type_value=$row_coex->SCREEN_FLEXO_SALE_VALUE+$row_coex->OFFSET_SALE_VALUE+$row_coex->LABEL_SALE_VALUE+$row_coex->SPRING_SALE_VALUE;

									$total_print_type_contr=0;
									$total_print_type_contr=$row_coex->SCREEN_FLEXO_CONTR_VALUE+$row_coex->OFFSET_CONTR_VALUE+$row_coex->LABEL_CONTR_VALUE+$row_coex->SPRING_CONTR_VALUE;

									$total_print_type_avg_price=0;
									$total_print_type_avg_price=($total_print_type_value!=0 ? $total_print_type_value/$total_print_type_quantity : 0);

									$total_print_type_contr_tube=0;
									$total_print_type_contr_tube=($total_print_type_contr!=0 ? $total_print_type_contr/$total_print_type_quantity : 0);	



						
									echo "<tr id='id_".$count."' "; echo $a=($count>10 ? "class='cat1' style='display:none'" : "NO");  echo ">
										<td>$count</td>
										<td><b>".$row_coex->customer."</b></td>
										<td class='negative right aligned'>".money_format('%!.0n',$row_coex->SCREEN_FLEXO_QUANTITY)."</td>
										<td class='negative right aligned'>".money_format('%.0n',$row_coex->SCREEN_FLEXO_SALE_VALUE)."</td>
										<td class='negative right aligned'>".money_format('%.0n',$row_coex->SCREEN_FLEXO_CONTR_VALUE)."</td>
										<td class='negative right aligned'>&#8377;".round($screen_flexo_avg_price,2)."</td>										
										<td class='negative right aligned'>&#8377;".round($screen_flexo_contribution_tube,2)."</td>

										<td class='positive right aligned'>".money_format('%!.0n',$row_coex->OFFSET_QUANTITY)."</td>
										<td class='positive right aligned'>".money_format('%.0n',$row_coex->OFFSET_SALE_VALUE)."</td>
										<td class='positive right aligned'>".money_format('%.0n',$row_coex->OFFSET_CONTR_VALUE)."</td>
										<td class='positive right aligned'>&#8377;".round($offset_avg_price,2)."</td>										
										<td class='positive right aligned'>&#8377;".round($offset_contribution_tube,2)."</td>


										<td class='right aligned'>".money_format('%!.0n',$row_coex->LABEL_QUANTITY)."</td>
										<td class='right aligned'>".money_format('%.0n',$row_coex->LABEL_SALE_VALUE)."</td>
										<td class='right aligned'>".money_format('%.0n',$row_coex->LABEL_CONTR_VALUE)."</td>
										<td class='right aligned'>&#8377;".round($label_avg_price,2)."</td>										
										<td class='right aligned'>&#8377;".round($label_contribution_tube,2)."</td>


										<td class='active right aligned'>".money_format('%!.0n',$total_print_type_coex_quantity)."</td>
										<td class='active right aligned'>".money_format('%.0n',$total_print_type_coex_value)."</td>
										<td class='active right aligned'>".money_format('%.0n',$total_print_type_coex_contr)."</td>
										<td class='active right aligned'>&#8377;".round($total_print_type_coex_avg_price,2)."</td>	
										<td class='active right aligned'>&#8377;".round($total_print_type_coex_contr_tube,2)."</td>


										<td class='negative right aligned'>".money_format('%!.0n',$row_coex->SPRING_QUANTITY)."</td>
										<td class='negative right aligned'>".money_format('%.0n',$row_coex->SPRING_SALE_VALUE)."</td>
										<td class='negative right aligned'>".money_format('%.0n',$row_coex->SPRING_CONTR_VALUE)."</td>
										<td class='negative right aligned'>&#8377;".round($spring_avg_price,2)."</td>										
										<td class='negative right aligned'>&#8377;".round($spring_contribution_tube,2)."</td>

										<td class='active right aligned'>".money_format('%!.0n',$total_print_type_quantity)."</td>
										<td class='active right aligned'>".money_format('%.0n',$total_print_type_value)."</td>
										<td class='active right aligned'>".money_format('%.0n',$total_print_type_contr)."</td>
										<td class='active right aligned'>&#8377;".round($total_print_type_avg_price,2)."</td>	
										<td class='active right aligned'>&#8377;".round($total_print_type_contr_tube,2)."</td>


										</tr>";

										$total_ten_screen_flexo_quantity+=$row_coex->SCREEN_FLEXO_QUANTITY;
										$total_ten_screen_flexo_value+=$row_coex->SCREEN_FLEXO_SALE_VALUE;
										$total_ten_screen_flexo_contribution_value+=$row_coex->SCREEN_FLEXO_CONTR_VALUE;
										


										$total_ten_offset_quantity+=$row_coex->OFFSET_QUANTITY;
										$total_ten_offset_value+=$row_coex->OFFSET_SALE_VALUE;
										$total_ten_offset_contribution_value+=$row_coex->OFFSET_CONTR_VALUE;
										
										$total_ten_label_quantity+=$row_coex->LABEL_QUANTITY;
										$total_ten_label_value+=$row_coex->LABEL_SALE_VALUE;
										$total_ten_label_contribution_value+=$row_coex->LABEL_CONTR_VALUE;
										
										$total_ten_spring_quantity+=$row_coex->SPRING_QUANTITY;
										$total_ten_spring_value+=$row_coex->SPRING_SALE_VALUE;
										$total_ten_spring_contribution_value+=$row_coex->SPRING_CONTR_VALUE;

									if($count==10){

										$total_ten_screen_flexo_avg_price=0;
										$total_ten_screen_flexo_avg_price=($total_ten_screen_flexo_value!=0 ? $total_ten_screen_flexo_value/$total_ten_screen_flexo_quantity : 0);

										$total_ten_screen_flexo_contribution_price=0;
										$total_ten_screen_flexo_contribution_price=($total_ten_screen_flexo_contribution_value!=0 ? $total_ten_screen_flexo_contribution_value/$total_ten_screen_flexo_quantity : 0);

										$total_ten_offset_avg_price=0;
										$total_ten_offset_avg_price=($total_ten_offset_value!=0 ? $total_ten_offset_value/$total_ten_offset_quantity : 0);
										
										$total_ten_offset_contribution_price=0;
										$total_ten_offset_contribution_price=($total_ten_offset_contribution_value!=0 ? $total_ten_offset_contribution_value/$total_ten_offset_quantity : 0);

										$total_ten_label_avg_price=0;
										$total_ten_label_avg_price=($total_ten_label_value!=0 ? $total_ten_label_value/$total_ten_label_quantity : 0);
										
										$total_ten_label_contribution_price=0;
										$total_ten_label_contribution_price=($total_ten_label_contribution_value!=0 ? $total_ten_label_contribution_value/$total_ten_label_quantity : 0);

										$total_ten_coex_quantity=$total_ten_screen_flexo_quantity+$total_ten_offset_quantity+$total_ten_label_quantity;
										$total_ten_coex_value=$total_ten_screen_flexo_value+$total_ten_offset_value+$total_ten_label_value;

										$total_ten_coex_contribution_value=$total_ten_screen_flexo_contribution_value+$total_ten_offset_contribution_value+$total_ten_label_contribution_value;

										$total_ten_coex_avg_price=0;
										$total_ten_coex_avg_price=($total_ten_coex_value!=0 ? $total_ten_coex_value/$total_ten_coex_quantity : 0);
										
										$total_ten_coex_contribution_price=0;
										$total_ten_coex_contribution_price=($total_ten_coex_contribution_value!=0 ? $total_ten_coex_contribution_value/$total_ten_coex_quantity : 0);

										$total_ten_spring_avg_price=0;
										$total_ten_spring_avg_price=($total_ten_spring_value!=0 ? $total_ten_spring_value/$total_ten_spring_quantity : 0);
										
										$total_ten_spring_contribution_price=0;
										$total_ten_spring_contribution_price=($total_ten_spring_contribution_value!=0 ? $total_ten_spring_contribution_value/$total_ten_spring_quantity : 0);

										$total_ten_grand_quantity=$total_ten_coex_quantity+$total_ten_spring_quantity;
					        			$total_ten_grand_value=$total_ten_coex_value+$total_ten_spring_value;
					        			$total_ten_grand_contribution_value=$total_ten_coex_contribution_value+$total_ten_spring_contribution_value;

					        			$total_ten_grand_avg_price=0;
										$total_ten_grand_avg_price=($total_ten_grand_value!=0 ? $total_ten_grand_value/$total_ten_grand_quantity : 0);
										
										$total_ten_grand_contribution_price=0;
										$total_ten_grand_contribution_price=($total_ten_grand_contribution_value!=0 ? $total_ten_grand_contribution_value/$total_ten_grand_quantity : 0);

										

										echo "<thead><tr>
										<th colspan='2'>TOP 10 TOTAL</th>
										<th class='negative right aligned'>".money_format('%!.0n',$total_ten_screen_flexo_quantity)."</th>
										<th class='negative right aligned'>".money_format('%.0n',$total_ten_screen_flexo_value)."</th>
										<th class='negative right aligned'>".money_format('%.0n',$total_ten_screen_flexo_contribution_value)."</th>
										<th class='negative right aligned'>&#8377;".round($total_ten_screen_flexo_avg_price,2)."</th>										
										<th class='negative right aligned'>&#8377;".round($total_ten_screen_flexo_contribution_price,2)."</th>

										<th class='positive right aligned'>".money_format('%!.0n',$total_ten_offset_quantity)."</th>
										<th class='positive right aligned'>".money_format('%.0n',$total_ten_offset_value)."</th>
										<th class='positive right aligned'>".money_format('%.0n',$total_ten_offset_contribution_value)."</th>
										<th class='positive right aligned'>&#8377;".round($total_ten_offset_avg_price,2)."</th>										
										<th class='positive right aligned'>&#8377;".round($total_ten_offset_contribution_price,2)."</th>

										<th class='right aligned'>".money_format('%!.0n',$total_ten_label_quantity)."</th>
										<th class='right aligned'>".money_format('%.0n',$total_ten_label_value)."</th>
										<th class='right aligned'>".money_format('%.0n',$total_ten_label_contribution_value)."</th>
										<th class='right aligned'>&#8377;".round($total_ten_label_avg_price,2)."</th>										
										<th class='right aligned'>&#8377;".round($total_ten_label_contribution_price,2)."</th>


										<th class='active right aligned'>".money_format('%!.0n',$total_ten_coex_quantity)."</th>

										<th class='active right aligned'>".money_format('%.0n',$total_ten_coex_value)."</th>
										<th class='active right aligned'>".money_format('%.0n',$total_ten_coex_contribution_value)."</th>
										<th class='active right aligned'>&#8377;".round($total_ten_coex_avg_price,2)."</th>	
										<th class='active right aligned'>&#8377;".round($total_ten_coex_contribution_price,2)."</th>

										<th class='negative right aligned'>".money_format('%!.0n',$total_ten_spring_quantity)."</th>
										<th class='negative right aligned'>".money_format('%.0n',$total_ten_spring_value)."</th>
										<th class='negative right aligned'>".money_format('%.0n',$total_ten_spring_contribution_value)."</th>
										<th class='negative right aligned'>&#8377;".round($total_ten_spring_avg_price,2)."</th>										
										<th class='negative right aligned'>&#8377;".round($total_ten_spring_contribution_price,2)."</th>

										<th class='active right aligned'>".money_format('%!.0n',$total_ten_grand_quantity)."</th>
										<th class='active right aligned'>".money_format('%.0n',$total_ten_grand_value)."</th>
										<th class='active right aligned'>".money_format('%.0n',$total_ten_grand_contribution_value)."</th>
										<th class='active right aligned'>&#8377;".round($total_ten_grand_avg_price,2)."</th>	
										<th class='active right aligned'>&#8377;".round($total_ten_grand_contribution_price,2)."</th>

										
										</tr></thead>";

									}

											
									$total_screen_flexo_quantity+=$row_coex->SCREEN_FLEXO_QUANTITY;
									$total_screen_flexo_value+=$row_coex->SCREEN_FLEXO_SALE_VALUE;
									$total_screen_flexo_contribution_value+=$row_coex->SCREEN_FLEXO_CONTR_VALUE;
									$total_screen_flexo_avg_price=0;
									$total_screen_flexo_avg_price=($total_screen_flexo_value!=0 ? $total_screen_flexo_value/$total_screen_flexo_quantity : 0);

									$total_screen_flexo_contribution_price=0;
									$total_screen_flexo_contribution_price=($total_screen_flexo_contribution_value!=0 ? $total_screen_flexo_contribution_value/$total_screen_flexo_quantity : 0);



									$total_offset_quantity+=$row_coex->OFFSET_QUANTITY;
									$total_offset_value+=$row_coex->OFFSET_SALE_VALUE;
									$total_offset_contribution_value+=$row_coex->OFFSET_CONTR_VALUE;
									$total_offset_avg_price=0;
									$total_offset_avg_price=($total_offset_value!=0 ? $total_offset_value/$total_offset_quantity : 0);
									
									$total_offset_contribution_price=0;
									$total_offset_contribution_price=($total_offset_contribution_value!=0 ? $total_offset_contribution_value/$total_offset_quantity : 0);

									$total_label_quantity+=$row_coex->LABEL_QUANTITY;
									$total_label_value+=$row_coex->LABEL_SALE_VALUE;
									$total_label_contribution_value+=$row_coex->LABEL_CONTR_VALUE;
									$total_label_avg_price=0;
									$total_label_avg_price=($total_label_value!=0 ? $total_label_value/$total_label_quantity : 0);
									
									$total_label_contribution_price=0;
									$total_label_contribution_price=($total_label_contribution_value!=0 ? $total_label_contribution_value/$total_label_quantity : 0);


									$total_coex_quantity+=$total_print_type_coex_quantity;
									$total_coex_value+=$total_print_type_coex_value;
									$total_coex_contribution_value+=$total_print_type_coex_contr;
									$total_coex_avg_price=0;
									$total_coex_avg_price=($total_coex_value!=0 ? $total_coex_value/$total_coex_quantity : 0);
									
									$total_coex_contribution_price=0;
									$total_coex_contribution_price=($total_coex_contribution_value!=0 ? $total_coex_contribution_value/$total_coex_quantity : 0);

									$total_spring_quantity+=$row_coex->SPRING_QUANTITY;
									$total_spring_value+=$row_coex->SPRING_SALE_VALUE;
									$total_spring_contribution_value+=$row_coex->SPRING_CONTR_VALUE;
									$total_spring_avg_price=0;
									$total_spring_avg_price=($total_spring_value!=0 ? $total_spring_value/$total_spring_quantity : 0);
									
									$total_spring_contribution_price=0;
									$total_spring_contribution_price=($total_spring_contribution_value!=0 ? $total_spring_contribution_value/$total_spring_quantity : 0);


									$total_grand_quantity+=$total_print_type_quantity;
									$total_grand_value+=$total_print_type_value;
									$total_grand_contribution_value+=$total_print_type_contr;
									$total_grand_avg_price=0;
									$total_grand_avg_price=($total_grand_value!=0 ? $total_grand_value/$total_grand_quantity : 0);
									
									$total_grand_contribution_price=0;
									$total_grand_contribution_price=($total_grand_contribution_value!=0 ? $total_grand_contribution_value/$total_grand_quantity : 0);


									if($count>10){

										$total_other_screen_flexo_quantity+=$row_coex->SCREEN_FLEXO_QUANTITY;
										$total_other_screen_flexo_value+=$row_coex->SCREEN_FLEXO_SALE_VALUE;
										$total_other_screen_flexo_contribution_value+=$row_coex->SCREEN_FLEXO_CONTR_VALUE;
										


										$total_other_offset_quantity+=$row_coex->OFFSET_QUANTITY;
										$total_other_offset_value+=$row_coex->OFFSET_SALE_VALUE;
										$total_other_offset_contribution_value+=$row_coex->OFFSET_CONTR_VALUE;
										
										$total_other_label_quantity+=$row_coex->LABEL_QUANTITY;
										$total_other_label_value+=$row_coex->LABEL_SALE_VALUE;
										$total_other_label_contribution_value+=$row_coex->LABEL_CONTR_VALUE;
										
										$total_other_spring_quantity+=$row_coex->SPRING_QUANTITY;
										$total_other_spring_value+=$row_coex->SPRING_SALE_VALUE;
										$total_other_spring_contribution_value+=$row_coex->SPRING_CONTR_VALUE;
							       }



									$i++;
									$count++;
								}


										$total_other_screen_flexo_avg_price=0;
										$total_other_screen_flexo_avg_price=($total_other_screen_flexo_value!=0 ? $total_other_screen_flexo_value/$total_other_screen_flexo_quantity : 0);

										$total_other_screen_flexo_contribution_price=0;
										$total_other_screen_flexo_contribution_price=($total_other_screen_flexo_contribution_value!=0 ? $total_other_screen_flexo_contribution_value/$total_other_screen_flexo_quantity : 0);

										$total_other_offset_avg_price=0;
										$total_other_offset_avg_price=($total_other_offset_value!=0 ? $total_other_offset_value/$total_other_offset_quantity : 0);
										
										$total_other_offset_contribution_price=0;
										$total_other_offset_contribution_price=($total_other_offset_contribution_value!=0 ? $total_other_offset_contribution_value/$total_other_offset_quantity : 0);

										$total_other_label_avg_price=0;
										$total_other_label_avg_price=($total_other_label_value!=0 ? $total_other_label_value/$total_other_label_quantity : 0);
										
										$total_other_label_contribution_price=0;
										$total_other_label_contribution_price=($total_other_label_contribution_value!=0 ? $total_other_label_contribution_value/$total_other_label_quantity : 0);

										$total_other_coex_quantity=$total_other_screen_flexo_quantity+$total_other_offset_quantity+$total_other_label_quantity;
										$total_other_coex_value=$total_other_screen_flexo_value+$total_other_offset_value+$total_other_label_value;

										$total_other_coex_contribution_value=$total_other_screen_flexo_contribution_value+$total_other_offset_contribution_value+$total_other_label_contribution_value;

										$total_other_coex_avg_price=0;
										$total_other_coex_avg_price=($total_other_coex_value!=0 ? $total_other_coex_value/$total_other_coex_quantity : 0);
										
										$total_other_coex_contribution_price=0;
										$total_other_coex_contribution_price=($total_other_coex_contribution_value!=0 ? $total_other_coex_contribution_value/$total_other_coex_quantity : 0);

										$total_other_spring_avg_price=0;
										$total_other_spring_avg_price=($total_other_spring_value!=0 ? $total_other_spring_value/$total_other_spring_quantity : 0);
										
										$total_other_spring_contribution_price=0;
										$total_other_spring_contribution_price=($total_other_spring_contribution_value!=0 ? $total_other_spring_contribution_value/$total_other_spring_quantity : 0);

										$total_other_grand_quantity=$total_other_coex_quantity+$total_other_spring_quantity;
					        			$total_other_grand_value=$total_other_coex_value+$total_other_spring_value;
					        			$total_other_grand_contribution_value=$total_other_coex_contribution_value+$total_other_spring_contribution_value;

					        			$total_other_grand_avg_price=0;
										$total_other_grand_avg_price=($total_other_grand_value!=0 ? $total_other_grand_value/$total_other_grand_quantity : 0);
										
										$total_other_grand_contribution_price=0;
										$total_other_grand_contribution_price=($total_other_grand_contribution_value!=0 ? $total_other_grand_contribution_value/$total_other_grand_quantity : 0);

							echo "
							</tbody>
								<thead>
								    <tr>
								    <th colspan='2'><a href='#'' class='toggler' data-prod-cat='1'>OTHER TOTAL</a></th>
							    	<th class='right aligned'>".money_format('%!.0n',$total_other_screen_flexo_quantity)."</th>
									<th class='right aligned'>".money_format('%.0n',$total_other_screen_flexo_value)."</th>
									<th class='right aligned'>".money_format('%.0n',$total_other_screen_flexo_contribution_value)."</th>
									<th class='right aligned'>&#8377;".round($total_other_screen_flexo_avg_price,2)."</th>
									<th class='right aligned'>&#8377;".round($total_other_screen_flexo_contribution_price,2)."</th>

									<th class='right aligned'>".money_format('%!.0n',$total_other_offset_quantity)."</th>
									<th class='right aligned'>".money_format('%.0n',$total_other_offset_value)."</th>
									<th class='right aligned'>".money_format('%.0n',$total_other_offset_contribution_value)."</th>
									<th class='right aligned'>&#8377;".round($total_other_offset_avg_price,2)."</th>
									<th class='right aligned'>&#8377;".round($total_other_offset_contribution_price,2)."</th>

									<th class='right aligned'>".money_format('%!.0n',$total_other_label_quantity)."</th>
									<th class='right aligned'>".money_format('%.0n',$total_other_label_value)."</th>
									<th class='right aligned'>".money_format('%.0n',$total_other_label_contribution_value)."</th>
									<th class='right aligned'>&#8377;".round($total_other_label_avg_price,2)."</th>
									<th class='right aligned'>&#8377;".round($total_other_label_contribution_price,2)."</th>

									<th class='right aligned'>".money_format('%!.0n',$total_other_coex_quantity)."</th>
									<th class='right aligned'>".money_format('%.0n',$total_other_coex_value)."</th>
									<th class='right aligned'>".money_format('%.0n',$total_other_coex_contribution_value)."</th>
									<th class='right aligned'>&#8377;".round($total_other_coex_avg_price,2)."</th>
									<th class='right aligned'>&#8377;".round($total_other_coex_contribution_price,2)."</th>


									<th class='right aligned'>".money_format('%!.0n',$total_other_spring_quantity)."</th>
									<th class='right aligned'>".money_format('%.0n',$total_other_spring_value)."</th>
									<th class='right aligned'>".money_format('%.0n',$total_other_spring_contribution_value)."</th>
									<th class='right aligned'>&#8377;".round($total_other_spring_avg_price,2)."</th>
									<th class='right aligned'>&#8377;".round($total_other_spring_contribution_price,2)."</th>


									<th class='right aligned'>".money_format('%!.0n',$total_other_grand_quantity)."</th>
									<th class='right aligned'>".money_format('%.0n',$total_other_grand_value)."</th>
									<th class='right aligned'>".money_format('%.0n',$total_other_grand_contribution_value)."</th>
									<th class='right aligned'>&#8377;".round($total_other_grand_avg_price,2)."</th>
									<th class='right aligned'>&#8377;".round($total_other_grand_contribution_price,2)."</th>	
								    </tr>
							   	</thead>
							<thead>
								<tr>
								<th colspan='2'>GRAND TOTAL</th>
								<th class='right aligned'>".money_format('%!.0n',$total_screen_flexo_quantity)."</th>
								<th class='right aligned'>".money_format('%.0n',$total_screen_flexo_value)."</th>
								<th class='right aligned'>".money_format('%.0n',$total_screen_flexo_contribution_value)."</th>
								<th class='right aligned'>&#8377;".round($total_screen_flexo_avg_price,2)."</th>
								<th class='right aligned'>&#8377;".round($total_screen_flexo_contribution_price,2)."</th>

								<th class='right aligned'>".money_format('%!.0n',$total_offset_quantity)."</th>
								<th class='right aligned'>".money_format('%.0n',$total_offset_value)."</th>
								<th class='right aligned'>".money_format('%.0n',$total_offset_contribution_value)."</th>
								<th class='right aligned'>&#8377;".round($total_offset_avg_price,2)."</th>
								<th class='right aligned'>&#8377;".round($total_offset_contribution_price,2)."</th>

								<th class='right aligned'>".money_format('%!.0n',$total_label_quantity)."</th>
								<th class='right aligned'>".money_format('%.0n',$total_label_value)."</th>
								<th class='right aligned'>".money_format('%.0n',$total_label_contribution_value)."</th>
								<th class='right aligned'>&#8377;".round($total_label_avg_price,2)."</th>
								<th class='right aligned'>&#8377;".round($total_label_contribution_price,2)."</th>

								<th class='right aligned'>".money_format('%!.0n',$total_coex_quantity)."</th>
								<th class='right aligned'>".money_format('%.0n',$total_coex_value)."</th>
								<th class='right aligned'>".money_format('%.0n',$total_coex_contribution_value)."</th>
								<th class='right aligned'>&#8377;".round($total_coex_avg_price,2)."</th>
								<th class='right aligned'>&#8377;".round($total_coex_contribution_price,2)."</th>


								<th class='right aligned'>".money_format('%!.0n',$total_spring_quantity)."</th>
								<th class='right aligned'>".money_format('%.0n',$total_spring_value)."</th>
								<th class='right aligned'>".money_format('%.0n',$total_spring_contribution_value)."</th>
								<th class='right aligned'>&#8377;".round($total_spring_avg_price,2)."</th>
								<th class='right aligned'>&#8377;".round($total_spring_contribution_price,2)."</th>


								<th class='right aligned'>".money_format('%!.0n',$total_grand_quantity)."</th>
								<th class='right aligned'>".money_format('%.0n',$total_grand_value)."</th>
								<th class='right aligned'>".money_format('%.0n',$total_grand_contribution_value)."</th>
								<th class='right aligned'>&#8377;".round($total_grand_avg_price,2)."</th>
								<th class='right aligned'>&#8377;".round($total_grand_contribution_price,2)."</th>

								</tr>
							</thead>
							</table>";
				}
				?>
				
				

				</span>

			</div>
  		</div>
		

	

	</div>
</div>