<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>

<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();


		$("#customer_category").autocomplete("<?php echo base_url('index.php/ajax/customer_category_autocomplete');?>", {selectFirst: true});		
		
		

		$("#search").click(function(){
			$("#loading").show(); $("#cover").show();

			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/ajax_sales_avg_dia');?>",data: {from_date : $(".from_date").val(),to_date :$('.to_date').val(),customer_category:$("#customer_category").val(),convert:$('.convert').val() },
				cache: false,
				success: function(html){
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

									$from_date=''; 
									if($account_periods_master==FALSE){
										echo "<tr><td>PLEASE SET THE FISCAL YEAR</td>";
									}else{
									foreach ($account_periods_master as $account_periods_master_row ):
											$from_date=$account_periods_master_row->fin_year_start;
										

										?>
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
				<table  class="form_table_inner">
						<tr>
							<td class="label">Customer :</td>
							<td colspan="3" ><input type="text" name="customer_category" id="customer_category" size="40" value="<?php echo set_value('customer_category');?>"/></td>
						</tr>
						<tr>
							<td class="label" width="25%">Convert</td>
							<td colspan="3">
								<select name="convert" class="convert">
								<option value="0">INR</option>
								<option value="1">Millions</option>
								</select>
							</td>
						</tr>
						
					</table>
				
				</td>
			</tr>
		</table>
					
	</div>

	
<div class="record_form_design">
	<div class="record_inner_design">
		<div class="row">
			<div class="column">
				<span id="check">
					<?php
					setlocale(LC_MONETARY, 'en_IN');
					$from_date='';
					if($sales_avg_dia==FALSE){

					}else{
						echo '<table class="ui sortable selectable celled table" style="font-size:10px;">
					        	<thead>
								    <tr>
								    	<th colspan="10"><a class="ui orange label">SALES AVG DIA</a>';
								    	if($account_periods_master==FALSE){
								    	}else{
								    		foreach ($account_periods_master as $account_periods_master_row ){

								    			$from_date=$account_periods_master_row->fin_year_start;

								    			echo '<a class="ui olive label"><i class="calendar icon"></i>'.date('d-M',strtotime($this->common_model->view_date($account_periods_master_row->fin_year_start,$this->session->userdata['logged_in']['company_id']))).' TO '.date('d-M',strtotime($this->common_model->view_date(date('Y-m-d'),$this->session->userdata['logged_in']['company_id']))).'</a> <a class="ui green label">LAST 3 YEAR</a>';
								    		}
								    	}
								    	echo '</th>
								    </tr>
								    <tr>
								    	<th style="text-align:center;">';

					        			if($account_periods_master==FALSE){
								    	}else{
								    		foreach ($account_periods_master as $account_periods_master_row ){
								    			echo '<a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date($account_periods_master_row->fin_year_start,$this->session->userdata['logged_in']['company_id']).' TO '.$this->common_model->view_date(date('Y-m-d'),$this->session->userdata['logged_in']['company_id']).'</a>';
								    		}
								    	}
								    	echo'</th>
					        			
					        			<th style="text-align:center;">';
					        			if($account_periods_master==FALSE){
								    	}else{
								    		foreach ($account_periods_master as $account_periods_master_row ){

					        					echo'<a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date( date("Y-m-d", strtotime("-1 year", strtotime($account_periods_master_row->fin_year_start))),$this->session->userdata['logged_in']['company_id']).' TO '.$this->common_model->view_date(date('Y-m-d',strtotime("-1 year")),$this->session->userdata['logged_in']['company_id']).'</a>';
					        				}
					        			}

					        			echo'</th>
					        			<th style="text-align:center;">';
					        			if($account_periods_master==FALSE){
								    	}else{
								    		foreach ($account_periods_master as $account_periods_master_row ){

					        					echo'<a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date( date("Y-m-d", strtotime("-2 year", strtotime($account_periods_master_row->fin_year_start))),$this->session->userdata['logged_in']['company_id']).' TO '.$this->common_model->view_date(date('Y-m-d',strtotime("-2 year")),$this->session->userdata['logged_in']['company_id']).'</a>';
					        				}
					        			}


					        			echo'</th>

					        	    </tr>					        	    
					        	</thead>
					        <tbody>
					        	<tr>

					        		<!---------------Currrent Year--------------------->
					        		<td> 
					        			<table class="ui sortable selectable celled table" >
									 		<thead>
									 		<tr>        			
							        			<th>DIA</th>					        			
							        			<th class="right aligned">SALES QTY</th>
							        			<th class="right aligned">DIA X VOLUME</th>

									        </tr>
									        </thead>
									        <tbody>';
									        $total_qty=0;
									        $total_volume=0;
											foreach ($sales_avg_dia as $key => $row) {			
											
												echo'<tr>																	
													<td><b>'.$row->sleeve_diameter.'</b></td>
													<td class="right aligned">'.money_format('%!.0n',$row->qty).'</td>
													<td class="right aligned">'.money_format('%!.0n',$row->dia_volume).'</td>';

												echo'</tr>';

												$total_qty+=$row->qty;
												$total_volume+=$row->dia_volume;
											}


										echo   '<tr>
												<td><b>TOTAL</b></td>
												<td class="right aligned">'.money_format('%!.0n',$total_qty).'</td>
												<td class="right aligned">'.money_format('%!.0n',$total_volume).'</td>
												</tr>

												<tr>
												<td><b>AVG DIA</b></td>
												<td class="right aligned"><a class="ui black label">'.($total_volume!='' ? money_format('%!.0n',$total_volume/$total_qty) : '-').'</a></td>
												<td class="right aligned"></td>
												</tr>
											</tbody>
										</table> 
									</td>
									<!---------------LAST Year--------------------->
									<td>
					        			<table class="ui sortable selectable celled table">
									 		<thead>
									 		<tr>        			
							        			<!--<th>DIA</th>-->					        			
							        			<th class="right aligned">SALES QTY</th>
							        			<th class="right aligned">DIA X VOLUME</th>

									        </tr>
									        </thead>
									        <tbody>';

									        $total_qty=0;
									        $total_volume=0;
											foreach ($sales_avg_dia_last_year as $key => $row) {
											
												echo'<tr>																	
													<!--<td>'.$row->sleeve_diameter.'</td>-->
													<td class="right aligned">'.money_format('%!.0n',$row->qty).'</td>
													<td class="right aligned">'.money_format('%!.0n',$row->dia_volume).'</td>';

												echo'</tr>';

												$total_qty+=$row->qty;
												$total_volume+=$row->dia_volume;
												
											}


										echo   '<tr>
												<td class="right aligned">'.money_format('%!.0n',$total_qty).'</td>
												<td class="right aligned">'.money_format('%!.0n',$total_volume).'</td>
												</tr>

												<tr>
												<td class="right aligned"><a class="ui black label">'.($total_volume!='' ? money_format('%!.0n',$total_volume/$total_qty) : '-').'</a></td>
												<td class="right aligned"></td>
												</tr>
											</tbody>
										</table> 
									</td>

									<!---------------LAST 2 Years--------------------->
									<td>
					        			<table class="ui sortable selectable celled table">
									 		<thead>
									 		<tr>        			
							        			<!--<th>DIA</th>-->					        			
							        			<th class="right aligned">SALES QTY</th>
							        			<th class="right aligned">DIA X VOLUME</th>

									        </tr>
									        </thead>
									        <tbody>';
									        $total_qty=0;
									        $total_volume=0;
											foreach ($sales_avg_dia_prev_year as $key => $row) {	
											
												echo'<tr>																	
													<!--<td>'.$row->sleeve_diameter.'</td>-->
													<td class="right aligned">'.money_format('%!.0n',$row->qty).'</td>
													<td class="right aligned">'.money_format('%!.0n',$row->dia_volume).'</td>';

												echo'</tr>';

												$total_qty+=$row->qty;
												$total_volume+=$row->dia_volume;
											}


										echo  '<tr>
												<td class="right aligned">'.money_format('%!.0n',$total_qty).'</td>
												<td class="right aligned">'.money_format('%!.0n',$total_volume).'</td>
												</tr>

												<tr>
												<td class="right aligned"><a class="ui black label">'.($total_volume!='' ? money_format('%!.0n',$total_volume/$total_qty) : '-').'</a></td>
												<td class="right aligned"></td>
												</tr>
												</tbody>
										</table> 
									</td>
								</tr>
							</tbody>
							</table>';
						

					}
				?>
				</span>
			</div>
  		</div>	

	</div>
</div>