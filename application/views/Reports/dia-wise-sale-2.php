<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/semantic/tablesort.js');?>"></script>
<script>
	$(document).ready(function(){

		$('table').tablesort();

		$("#loading").hide(); $("#cover").hide();
		$("#search").click(function(){
			$("#loading").show(); $("#cover").show();

			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/dia_wise_sales');?>",data: {from_date : $(".from_date").val(),to_date :$('.to_date').val(),sleeve_dia : $('.sleeve_dia:checked').serialize(),inv_type : $('.inv_type:checked').serialize()},cache: false,success: function(html){
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
										<td  width="25%"><input type="date" name="from_date" class="from_date" id="from_date" value="<?php echo set_value('from_date',$account_periods_master_row->fin_year_start);?>"/></td>
										<td class="label"  width="25%">To Date <span style="color:red;">*</span>  :</td>
										<td  width="25%"><input type="date" name="to_date" class="to_date" id="to_date" value="<?php echo set_value('to_date',date('Y-m-d'));?>"/></td>
									</tr>
									<?php endforeach;
										}?>

									<tr>
										<td class="label">Dia :</td>
										<td>
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
										<td></td>
										<td></td>
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
				<td width="50%">
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
					if($dia_wise_sales_coex==FALSE){

					}else{
						echo '<table class="ui sortable selectable celled table" style="font-size:10px;">
					        	<thead>
								   <tr>
								    	<th colspan="10"><a class="ui orange label">COEX SALES</a>';
								    	if($account_periods_master==FALSE){
								    	}else{
								    		foreach ($account_periods_master as $account_periods_master_row ){
								    			echo '<a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date($account_periods_master_row->fin_year_start,$this->session->userdata['logged_in']['company_id']).' TO '.$this->common_model->view_date(date('Y-m-d'),$this->session->userdata['logged_in']['company_id']).'</a><br/><br/>';
								    		}
								    	}
								    	echo '
								  </tr>

								  	<tr>
					        			<th></th>
					        			<th colspan="3" class="center aligned">SMALL DIA (19,22.6,25,30)</th>
					        			<th colspan="3" class="center aligned">BIG DIA (35,40,50)</th>
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
					 $total_small_dia_coex_quantity=0;
					 $total_small_dia_coex_value=0;
					 $total_small_dia_coex_avg=0;
					 $total_big_dia_coex_quantity=0;
					 $total_big_dia_coex_value=0;
					 $total_big_dia_coex_avg=0;
					 $total_small_big_dia_coex_quantity=0;
					 $total_small_big_dia_coex_value=0;
					 $total_small_big_dia_coex_avg=0;
					 $count=0;
					foreach($dia_wise_sales_coex as $row_coex){
						$small_dia_avg_price=0;
						$small_dia_avg_price=($row_coex->SMALL_DIA_VALUE!=0 ? $row_coex->SMALL_DIA_VALUE/$row_coex->SMALL_DIA : 0);
						$big_dia_avg_price=0;
						$big_dia_avg_price=($row_coex->BIG_DIA_VALUE!=0 ? $row_coex->BIG_DIA_VALUE/$row_coex->BIG_DIA : 0);
						$total_dia_quantity=0;
						$total_dia_quantity=$row_coex->SMALL_DIA+$row_coex->BIG_DIA;
						$total_dia_value=0;
						$total_dia_value=$row_coex->SMALL_DIA_VALUE+$row_coex->BIG_DIA_VALUE;
						$total_dia_avg_price=0;
						$total_dia_avg_price=$total_dia_value/$total_dia_quantity;
						echo "<tr>
								<td>".$row_coex->sales_year."-".strtoupper($row_coex->sales_month)."</td>
								<td class='negative right aligned'>".money_format('%!.0n',$row_coex->SMALL_DIA)."</td>
								<td class='negative right aligned'>".money_format('%.0n',$row_coex->SMALL_DIA_VALUE)."</td>
								<td class='negative right aligned'>&#8377;".round($small_dia_avg_price,2)."</td>
								<td class='positive right aligned'>".money_format('%!.0n',$row_coex->BIG_DIA)."</td>
								<td class='positive right aligned'>".money_format('%.0n',$row_coex->BIG_DIA_VALUE)."</td>
								<td class='positive right aligned'>&#8377;".round($big_dia_avg_price,2)."</td>
								<td class='warning right aligned'>".money_format('%!.0n',$total_dia_quantity)."</td>
								<td class='warning right aligned'>".money_format('%.0n',$total_dia_value)."</td>
								<td class='warning right aligned'>&#8377;".round($total_dia_avg_price,2)."</td>
					        </tr>";

					       $total_small_dia_coex_quantity+=$row_coex->SMALL_DIA;
					       $total_small_dia_coex_value+=$row_coex->SMALL_DIA_VALUE;
					       $total_big_dia_coex_quantity+=$row_coex->BIG_DIA;
					       $total_big_dia_coex_value+=$row_coex->BIG_DIA_VALUE;
					    }
					    $total_small_dia_coex_avg=($total_small_dia_coex_value!=0 ? $total_small_dia_coex_value/$total_small_dia_coex_quantity : '0');
					    $total_big_dia_coex_avg=($total_big_dia_coex_value!=0 ? $total_big_dia_coex_value/$total_big_dia_coex_quantity : '0');

					    $total_small_big_dia_coex_quantity=$total_small_dia_coex_quantity+$total_big_dia_coex_quantity;
					    $total_small_big_dia_coex_value=$total_small_dia_coex_value+$total_big_dia_coex_value;
					    $total_small_big_dia_coex_avg=$total_small_big_dia_coex_value/$total_small_big_dia_coex_quantity;

					    echo "<thead>
							    <tr>
							    	<th>TOTAL</th>
							    	<th class='negative right aligned'>".money_format('%!.0n',$total_small_dia_coex_quantity)."</th>
							    	<th class='negative right aligned'>".money_format('%.0n',$total_small_dia_coex_value)."</th>
							    	<th class='negative right aligned'>&#8377;".round($total_small_dia_coex_avg,2)."</th>
							    	<th class='positive right aligned'>".money_format('%!.0n',$total_big_dia_coex_quantity)."</th>
							    	<th class='positive right aligned'>".money_format('%.0n',$total_big_dia_coex_value)."</th>
							    	<th class='positive right aligned'>&#8377;".round($total_big_dia_coex_avg,2)."</th>
							    	<th class='warning right aligned'>".money_format('%!.0n',$total_small_big_dia_coex_quantity)."</th>
							    	<th class='warning right aligned'>".money_format('%.0n',$total_small_big_dia_coex_value)."</th>
							    	<th class='warning right aligned'>&#8377;".round($total_small_big_dia_coex_avg,2)."</th>
							  	</tr>
							  </thead>";

						echo '</table>';
					}
				?>
				

				<br/>
  				<?php
					setlocale(LC_MONETARY, 'en_IN');
					if($dia_wise_sales_spring==FALSE){

					}else{
						echo '<div style="text-align:center;"><i class="plus circle icon"></i></div><br/>
							<table class="ui sortable selectable celled table" style="font-size:10px;">
					        	<thead>
								   <tr>
								    	<th colspan="10"><a class="ui yellow label">SPRING SALES</a>';
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
					        			<th colspan="3" class="center aligned">SMALL DIA (19,22.6,25,30)</th>
					        			<th colspan="3" class="center aligned">BIG DIA (35,40,50)</th>
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
					 $total_small_dia_spring_quantity=0;
					 $total_small_dia_spring_value=0;
					 $total_small_dia_spring_avg=0;
					 $total_big_dia_spring_quantity=0;
					 $total_big_dia_spring_value=0;
					 $total_big_dia_spring_avg=0;
					 $total_small_big_dia_spring_quantity=0;
					 $total_small_big_dia_spring_value=0;
					 $total_small_big_dia_spring_avg=0;
					 $count=0;
					foreach($dia_wise_sales_spring as $row_coex){
						$small_dia_avg_price=0;
						$small_dia_avg_price=($row_coex->SMALL_DIA_VALUE!=0 ? $row_coex->SMALL_DIA_VALUE/$row_coex->SMALL_DIA : 0);
						$big_dia_avg_price=0;
						$big_dia_avg_price=($row_coex->BIG_DIA_VALUE!=0 ? $row_coex->BIG_DIA_VALUE/$row_coex->BIG_DIA : 0);
						$total_dia_quantity=0;
						$total_dia_quantity=$row_coex->SMALL_DIA+$row_coex->BIG_DIA;
						$total_dia_value=0;
						$total_dia_value=$row_coex->SMALL_DIA_VALUE+$row_coex->BIG_DIA_VALUE;
						$total_dia_avg_price=0;
						$total_dia_avg_price=$total_dia_value/$total_dia_quantity;
						echo "<tr>
								<td>".$row_coex->sales_year."-".strtoupper($row_coex->sales_month)."</td>
								<td class='negative right aligned'>".money_format('%!.0n',$row_coex->SMALL_DIA)."</td>
								<td class='negative right aligned'>".money_format('%.0n',$row_coex->SMALL_DIA_VALUE)."</td>
								<td class='negative right aligned'>&#8377;".round($small_dia_avg_price,2)."</td>
								<td class='positive right aligned'>".money_format('%!.0n',$row_coex->BIG_DIA)."</td>
								<td class='positive right aligned'>".money_format('%.0n',$row_coex->BIG_DIA_VALUE)."</td>
								<td class='positive right aligned'>&#8377;".round($big_dia_avg_price,2)."</td>
								<td class='warning right aligned'>".money_format('%!.0n',$total_dia_quantity)."</td>
								<td class='warning right aligned'>".money_format('%.0n',$total_dia_value)."</td>
								<td class='warning right aligned'>&#8377;".round($total_dia_avg_price,2)."</td>
					        </tr>";

					       $total_small_dia_spring_quantity+=$row_coex->SMALL_DIA;
					       $total_small_dia_spring_value+=$row_coex->SMALL_DIA_VALUE;
					       $total_big_dia_spring_quantity+=$row_coex->BIG_DIA;
					       $total_big_dia_spring_value+=$row_coex->BIG_DIA_VALUE;
					    }
					    $total_small_dia_spring_avg=($total_small_dia_spring_value!=0 ? $total_small_dia_spring_value/$total_small_dia_spring_quantity : '0');
					    $total_big_dia_spring_avg=($total_big_dia_spring_value!=0 ? $total_big_dia_spring_value/$total_big_dia_spring_quantity : '0');

					    $total_small_big_dia_spring_quantity=$total_small_dia_spring_quantity+$total_big_dia_spring_quantity;
					    $total_small_big_dia_spring_value=$total_small_dia_spring_value+$total_big_dia_spring_value;
					    $total_small_big_dia_spring_avg=$total_small_big_dia_spring_value/$total_small_big_dia_spring_quantity;

					    echo "<thead>
							    <tr>
							    	<th>TOTAL</th>
							    	<th class='negative right aligned'>".money_format('%!.0n',$total_small_dia_spring_quantity)."</th>
							    	<th class='negative right aligned'>".money_format('%.0n',$total_small_dia_spring_value)."</th>
							    	<th class='negative right aligned'>&#8377;".round($total_small_dia_spring_avg,2)."</th>
							    	<th class='positive right aligned'>".money_format('%!.0n',$total_big_dia_spring_quantity)."</th>
							    	<th class='positive right aligned'>".money_format('%.0n',$total_big_dia_spring_value)."</th>
							    	<th class='positive right aligned'>&#8377;".round($total_big_dia_spring_avg,2)."</th>
							    	<th class='warning right aligned'>".money_format('%!.0n',$total_small_big_dia_spring_quantity)."</th>
							    	<th class='warning right aligned'>".money_format('%.0n',$total_small_big_dia_spring_value)."</th>
							    	<th class='warning right aligned'>&#8377;".round($total_small_big_dia_spring_avg,2)."</th>
							  	</tr>
							  </thead>";

						echo '</table>';
					}
				?>


				<?php
					setlocale(LC_MONETARY, 'en_IN');
					if($dia_wise_sales_coex==FALSE || $dia_wise_sales_spring==FALSE){

					}else{
						echo '<br/>
								<div style="text-align:center;"><i class="bars icon"></i></div>
								<br/>
								<table class="ui sortable selectable celled table" style="font-size:10px;">
					        	<thead>

					        		<tr>
					        			<th>MONTH-YEAR</th>
					        			<th colspan="3" class="center aligned">SMALL DIA (19,22.6,25,30)</th>
					        			<th colspan="3" class="center aligned">BIG DIA (35,40,50)</th>
					        			<th colspan="3" class="center aligned">TOTAL</th>
					        		</tr>


					        		<tr>
								   		<th>';
								    	if($account_periods_master==FALSE){
								    	}else{
								    		foreach ($account_periods_master as $account_periods_master_row ){
								    			echo ''.$this->common_model->view_date($account_periods_master_row->fin_year_start,$this->session->userdata['logged_in']['company_id']).' TO '.$this->common_model->view_date(date('Y-m-d'),$this->session->userdata['logged_in']['company_id']).'';
								    		}
								    	}
								    	echo '</th>
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
								  </thead>
								  <tbody>
								   <tr>
								   		<td>COEX SALES</td>
								    	

								    	<td class="negative right aligned">'.money_format('%!.0n',$total_small_dia_coex_quantity).'</td>
								    	<td class="negative right aligned">'.money_format('%.0n',$total_small_dia_coex_value).'</td>
								    	<td class="negative right aligned">&#8377;'.round($total_small_dia_coex_avg,2).'</td>


								    	<td class="positive right aligned">'.money_format('%!.0n',$total_big_dia_coex_quantity).'</td>
								    	<td class="positive right aligned">'.money_format('%.0n',$total_big_dia_coex_value).'</td>
								    	<td class="positive right aligned">&#8377;'.round($total_big_dia_coex_avg,2).'</td>

								    	<td class="warning right aligned">'.money_format('%!.0n',$total_small_big_dia_coex_quantity).'</td>
								    	<td class="warning right aligned">'.money_format('%.0n',$total_small_big_dia_coex_value).'</td>
								    	<td class="warning right aligned">&#8377;'.round($total_small_big_dia_coex_avg,2).'</td>
								  	</tr>

								  	<tr>
								   		<td>SPRING SALES</td>
								   		<td class="negative right aligned">'.money_format('%!.0n',$total_small_dia_spring_quantity).'</td>
								    	<td class="negative right aligned">'.money_format('%.0n',$total_small_dia_spring_value).'</td>
								    	<td class="negative right aligned">&#8377;'.round($total_small_dia_spring_avg,2).'</td>


								    	<td class="positive right aligned">'.money_format('%!.0n',$total_big_dia_spring_quantity).'</td>
								    	<td class="positive right aligned">'.money_format('%.0n',$total_big_dia_spring_value).'</td>
								    	<td class="positive right aligned">&#8377;'.round($total_big_dia_spring_avg,2).'</td>


								    	<td class="warning right aligned">'.money_format('%!.0n',$total_small_big_dia_spring_quantity).'</td>
								    	<td class="warning right aligned">'.money_format('%.0n',$total_small_big_dia_spring_value).'</td>
								    	<td class="warning right aligned">&#8377;'.round($total_small_big_dia_spring_avg,2).'</td>
								  	</tr>

								  </tbody>';

								  		$avg=($total_small_big_dia_coex_value+$total_small_big_dia_spring_value)/($total_small_big_dia_coex_quantity+$total_small_big_dia_spring_quantity);
								  		$grand_total_small_dia_quantity=0;
								  		$grand_total_small_dia_quantity=$total_small_dia_coex_quantity+$total_small_dia_spring_quantity;
								  		$grand_total_small_dia_value=0;
								  		$grand_total_small_dia_value=$total_small_dia_coex_value+$total_small_dia_spring_value;

								  		$grand_total_small_dia_avg_price=($grand_total_small_dia_value!=0 ? ($grand_total_small_dia_value/$grand_total_small_dia_quantity) : 0);

								  		$grand_total_big_dia_quantity=0;
								  		$grand_total_big_dia_quantity=$total_big_dia_coex_quantity+$total_big_dia_spring_quantity;
								  		$grand_total_big_dia_value=0;
								  		$grand_total_big_dia_value=$total_big_dia_coex_value+$total_big_dia_spring_value;

								  		$grand_total_big_dia_avg_price=($grand_total_big_dia_value!=0 ? ($grand_total_big_dia_value/$grand_total_big_dia_quantity) : 0);

								echo '<thead>
								 		<tr>
									   		<th>GRAND TOTAL</th>
									    	<th class="right aligned">'.money_format('%!.0n',$grand_total_small_dia_quantity).'</th>
									    	<th class="right aligned">'.money_format('%.0n',$grand_total_small_dia_value).'</th>
									    	<th class="right aligned">&#8377;'.round($grand_total_small_dia_avg_price,2).'</th>

									    	<th class="right aligned">'.money_format('%!.0n',$grand_total_big_dia_quantity).'</th>
									    	<th class="right aligned">'.money_format('%.0n',$grand_total_big_dia_value).'</th>
									    	<th class="right aligned">&#8377;'.round($grand_total_big_dia_avg_price,2).'</th>

									    	<th class="right aligned">'.money_format('%!.0n',$total_small_big_dia_coex_quantity+$total_small_big_dia_spring_quantity).'</th>
									    	<th class="right aligned">'.money_format('%.0n',$total_small_big_dia_coex_value+$total_small_big_dia_spring_value).'</th>
									    	<th class="right aligned">&#8377;'.round($avg,2).'</th>
								  		</tr>
								  		</thead>
								  	</table>';
					}
					?>

				</span>

			</div>
  		</div>
		

	

	</div>
</div>