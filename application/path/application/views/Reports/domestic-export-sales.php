<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/semantic/tablesort.js');?>"></script>
<script>
	$(document).ready(function(){

		$('table').tablesort();

		$("#loading").hide(); $("#cover").hide();
		$("#search").click(function(){
			$("#loading").show(); $("#cover").show();

			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/domestic_export_sales');?>",data: {from_date : $(".from_date").val(),to_date :$('.to_date').val(),convert:$('.convert').val(),sleeve_dia : $('.sleeve_dia:checked').serialize(),inv_type : $('.inv_type:checked').serialize()},cache: false,success: function(html){
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
						<!--<tr>
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
						</tr>-->
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
					if($domestic_export_sales==FALSE){

					}else{
						echo '<table class="ui sortable selectable celled table" style="font-size:10px;">
					        	<thead>
								   <tr>
								    	<th colspan="28"><a class="ui orange label">DOMESTIC EXPORT SALES</a>';
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
					        			<th colspan="3" class="center aligned">DOMESTIC SALE</th>
					        			<th colspan="3" class="center aligned">EXPORT SALE</th>
					        			<th colspan="3" class="center aligned">TOTAL SALE</th>
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


					 $count=0;
					 $total_domestic_quantity=0;
					 $total_domestic_value=0;
					 $total_domestic_avg=0;
					 $total_export_quantity=0;
					 $total_export_value=0;
					 $total_export_avg=0;
					 $total_total_sales_quantity=0;
					 $total_total_sales_value=0;
					 $total_total_sales_avg=0;
					foreach($domestic_export_sales as $row){
						$total_sales_quantity=0;
					 	$total_sales_value=0;
						$total_sales_value=$row->domestic_value+$row->export_value;
						$total_sales_quantity=$row->domestic_qty+$row->export_qty;
						$domestic_avg_price=0;
						$domestic_avg_price=($row->domestic_value!=0 ? $row->domestic_value/$row->domestic_qty : 0);
						$export_avg_price=0;
						$export_avg_price=($row->export_value!=0 ? $row->export_value/$row->export_qty : 0);
						$total_sales_avg_price=0;
						$total_sales_avg_price=($total_sales_value!=0 ? $total_sales_value/$total_sales_quantity : 0);

						echo "<tr title='$row->sales_month'>
								<td><b>".$row->sales_year."-".strtoupper($row->sales_month)."</b></td>
								<td class='negative right aligned'>".money_format('%!.0n',$row->domestic_qty)."</td>
								<td class='negative right aligned'>".money_format('%.0n',$row->domestic_value)."</td>
								<td class='negative right aligned'>&#8377;".round($domestic_avg_price,2)."</td>
								<td class='positive right aligned'>".money_format('%!.0n',$row->export_qty)."</td>
								<td class='positive right aligned'>".money_format('%.0n',$row->export_value)."</td>
								<td class='positive right aligned'>&#8377;".round($export_avg_price,2)."</td>
								<td class='warning right aligned'>".money_format('%!.0n',$total_sales_quantity)."</td>
								<td class='warning right aligned'>".money_format('%.0n',$total_sales_value)."</td>
								<td class='warning right aligned'>&#8377;".round($total_sales_avg_price,2)."</td>

					        </tr>";

					       $total_domestic_quantity+=$row->domestic_qty;
					       $total_domestic_value+=$row->domestic_value;
					       $total_export_quantity+=$row->export_qty;
					       $total_export_value+=$row->export_value;


					       }
					    $total_total_sales_quantity=$total_domestic_quantity+$total_export_quantity;
					    $total_total_sales_value=$total_domestic_value+$total_export_value;
					    $total_domestic_avg=($total_domestic_value!=0 ? $total_domestic_value/$total_domestic_quantity : '0');
					    $total_export_avg=($total_export_value!=0 ? $total_export_value/$total_export_quantity : '0');
					    $total_total_sales_avg=($total_total_sales_value!=0 ? $total_total_sales_value/$total_total_sales_quantity : '0');
					    


					    echo "<thead>
							    <tr>
							    	<th>TOTAL</th>
							    	<th class='negative right aligned'>".money_format('%!.0n',$total_domestic_quantity)."</th>
							    	<th class='negative right aligned'>".money_format('%.0n',$total_domestic_value)."</th>
							    	<th class='negative right aligned'>&#8377;".round($total_domestic_avg,2)."</th>
							    	<th class='positive right aligned'>".money_format('%!.0n',$total_export_quantity)."</th>
							    	<th class='positive right aligned'>".money_format('%.0n',$total_export_value)."</th>
							    	<th class='positive right aligned'>&#8377;".round($total_export_avg,2)."</th>
							    	<th class='warning right aligned'>".money_format('%!.0n',$total_total_sales_quantity)."</th>
							    	<th class='warning right aligned'>".money_format('%.0n',$total_total_sales_value)."</th>
							    	<th class='warning right aligned'>&#8377;".round($total_total_sales_avg,2)."</th>

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