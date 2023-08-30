<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/semantic/tablesort.js');?>"></script>
<script>
	$(document).ready(function(){

		$('table').tablesort();

		$("#loading").hide(); $("#cover").hide();
		$("#search").click(function(){
			/*$("#loading").show(); $("#cover").show();*/

			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/dia_wise_sales');?>",data: {from_date : $(".from_date").val(),to_date :$('.to_date').val(),sleeve_dia : $('.sleeve_dia:checked').serialize()},cache: false,success: function(html){
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
									<tr>
										<td class="label" width="25%">From Date <span style="color:red;">*</span> :</td>
										<td width="25%"><input type="date" name="from_date" class="from_date" value="<?php echo set_value('from_date',date('Y-m-d'));?>"/></td>
										<td class="label" width="25%">To Date <span style="color:red;">*</span> :</td>
										<td width="25%"><input type="date" name="to_date" class="to_date" value="<?php echo set_value('to_date',date('Y-m-d'));?>"/></td>
									</tr>

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
						echo '<table class="ui sortable selectable celled table" style="font-size:12px;">
					        	<thead>
								   <tr>
								    	<th colspan="10"><a class="ui orange label">COEX SALES FOR YEAR</a></th>
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
					 $total_small_dia_quantity=0;
					 $total_small_dia_value=0;
					 $total_small_dia_avg=0;
					 $total_big_dia_quantity=0;
					 $total_big_dia_value=0;
					 $total_big_dia_avg=0;
					 $total_small_big_dia_quantity=0;
					 $total_small_big_dia_value=0;
					 $total_small_big_dia_avg=0;
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

					       $total_small_dia_quantity+=$row_coex->SMALL_DIA;
					       $total_small_dia_value+=$row_coex->SMALL_DIA_VALUE;
					       $total_big_dia_quantity+=$row_coex->BIG_DIA;
					       $total_big_dia_value+=$row_coex->BIG_DIA_VALUE;
					    }
					    $total_small_dia_avg=($total_small_dia_value!=0 ? $total_small_dia_value/$total_small_dia_quantity : '0');
					    $total_big_dia_avg=($total_big_dia_value!=0 ? $total_big_dia_value/$total_big_dia_quantity : '0');

					    $total_small_big_dia_quantity=$total_small_dia_quantity+$total_big_dia_quantity;
					    $total_small_big_dia_value=$total_small_dia_value+$total_big_dia_value;
					    $total_small_big_dia_avg=$total_small_big_dia_value/$total_small_big_dia_quantity;

					    echo "<tfoot>
							    <tr>
							    	<th>TOTAL</th>
							    	<th class='negative right aligned'>".money_format('%!.0n',$total_small_dia_quantity)."</th>
							    	<th class='negative right aligned'>".money_format('%.0n',$total_small_dia_value)."</th>
							    	<th class='negative right aligned'>&#8377;".round($total_small_dia_avg,2)."</th>
							    	<th class='positive right aligned'>".money_format('%!.0n',$total_big_dia_quantity)."</th>
							    	<th class='positive right aligned'>".money_format('%.0n',$total_big_dia_value)."</th>
							    	<th class='positive right aligned'>&#8377;".round($total_big_dia_avg,2)."</th>
							    	<th class='warning right aligned'>".money_format('%!.0n',$total_small_big_dia_quantity)."</th>
							    	<th class='warning right aligned'>".money_format('%.0n',$total_small_big_dia_value)."</th>
							    	<th class='warning right aligned'>&#8377;".round($total_small_big_dia_avg,2)."</th>
							  	</tr>
							  </tfoot>";

						echo '</table>';
					}
				?>
				

				<br/>
  				<?php
					setlocale(LC_MONETARY, 'en_IN');
					if($dia_wise_sales_spring==FALSE){

					}else{
						echo '<table class="ui sortable selectable celled table" style="font-size:12px;">
					        	<thead>
								   <tr>
								    	<th colspan="10"><a class="ui yellow label">SPRING SALES FOR YEAR</a></th>
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
					 $total_small_dia_quantity=0;
					 $total_small_dia_value=0;
					 $total_small_dia_avg=0;
					 $total_big_dia_quantity=0;
					 $total_big_dia_value=0;
					 $total_big_dia_avg=0;
					 $total_small_big_dia_quantity=0;
					 $total_small_big_dia_value=0;
					 $total_small_big_dia_avg=0;
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

					       $total_small_dia_quantity+=$row_coex->SMALL_DIA;
					       $total_small_dia_value+=$row_coex->SMALL_DIA_VALUE;
					       $total_big_dia_quantity+=$row_coex->BIG_DIA;
					       $total_big_dia_value+=$row_coex->BIG_DIA_VALUE;
					    }
					    $total_small_dia_avg=($total_small_dia_value!=0 ? $total_small_dia_value/$total_small_dia_quantity : '0');
					    $total_big_dia_avg=($total_big_dia_value!=0 ? $total_big_dia_value/$total_big_dia_quantity : '0');

					    $total_small_big_dia_quantity=$total_small_dia_quantity+$total_big_dia_quantity;
					    $total_small_big_dia_value=$total_small_dia_value+$total_big_dia_value;
					    $total_small_big_dia_avg=$total_small_big_dia_value/$total_small_big_dia_quantity;

					    echo "<tfoot>
							    <tr>
							    	<th>TOTAL</th>
							    	<th class='negative right aligned'>".money_format('%!.0n',$total_small_dia_quantity)."</th>
							    	<th class='negative right aligned'>".money_format('%.0n',$total_small_dia_value)."</th>
							    	<th class='negative right aligned'>&#8377;".round($total_small_dia_avg,2)."</th>
							    	<th class='positive right aligned'>".money_format('%!.0n',$total_big_dia_quantity)."</th>
							    	<th class='positive right aligned'>".money_format('%.0n',$total_big_dia_value)."</th>
							    	<th class='positive right aligned'>&#8377;".round($total_big_dia_avg,2)."</th>
							    	<th class='warning right aligned'>".money_format('%!.0n',$total_small_big_dia_quantity)."</th>
							    	<th class='warning right aligned'>".money_format('%.0n',$total_small_big_dia_value)."</th>
							    	<th class='warning right aligned'>&#8377;".round($total_small_big_dia_avg,2)."</th>
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