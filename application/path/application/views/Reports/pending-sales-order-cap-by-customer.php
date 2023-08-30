
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
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/pending_sales_order_cap_by_customer');?>",data: {from_date : $(".from_date").val(),to_date :$('.to_date').val(),customer_category:$('#customer_category').val()},cache: false,success: function(html){
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
										<?php 
										$new_from_date = date('Y-m-d',strtotime('-120 days', strtotime($account_periods_master_row->fin_year_start)));
										?>
									<tr>
										<td class="label"  width="25%">From Date <span style="color:red;">*</span>  :</td>
										<td  width="25%"><input type="date" name="from_date" class="from_date"  value="<?php echo set_value('from_date',$new_from_date);?>"/></td>
										<td class="label"  width="25%">To Date <span style="color:red;">*</span>  :</td>
										<td  width="25%"><input type="date" name="to_date" class="to_date"  value="<?php echo set_value('to_date',date('Y-m-d'));?>"/></td>
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
						<tr>
							<td class="label" width="25%">Customer :</td>
							<td colspan="2" ><input type="text" name="customer_category" id="customer_category"  size="40" value="<?php echo set_value('customer_category');?>"/>
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
						echo '<table class="ui selectable celled table" style="font-size:10px;">
					        	<thead>
								   <tr>
								    	<th colspan="7"><a class="ui orange label">CAP FORECAST BY CUSTOMER</a>
								    	<a class="ui green label">PENDING ORDER OF LAST 120 DAYS FROM START DATE OF CURRENT FINANCIAL YEAR</a>
								    	';
								    	if($account_periods_master==FALSE){
								    	}else{
								    		foreach ($account_periods_master as $account_periods_master_row ){
								    			$from_date=$account_periods_master_row->fin_year_start;
								    			 $new_from_date = date('Y-m-d', strtotime('-120 days',strtotime($from_date)));

								    			echo '<a class="ui olive label"><i class="calendar icon"></i>'.$this->common_model->view_date($new_from_date,$this->session->userdata['logged_in']['company_id']).' TO '.$this->common_model->view_date(date('Y-m-d'),$this->session->userdata['logged_in']['company_id']).'</a><br/><br/>';
								    		}
								    	}
								    	echo '</th>
								  </tr>
					        		<tr>
					        			<th>SR NO</th>

					        			<th width="40%">CUSTOMER</th>
					        			
					        			<th colspan="2" class="center aligned">CAP CODE</th>
					        			<th class="right aligned">PENDING ORDER</th>
					        			<th class="right aligned">PENDING ORDER + TOLERANCE</th>
					        			
					        		</tr>
					        	</thead>';
					
					 $count=1;

					 $total_received_quantity=0;

					 $total_dispached_quantity=0;

					 $total_pending_quantity=0;

					 $total_pending_quantity_with_tolerence=0;

					foreach($pending_sales_order as $coex_order_row){


						?><script>
							$(document).ready(function(){

								$("#id_<?php echo $count;?>").live('click',function(){
									
									$(".tr_<?php echo $count;?>").slideToggle();
								    $("#idd_<?php echo $count;?>").toggleClass('plus circle icon');
								    $("#idd_<?php echo $count;?>").toggleClass('minus circle icon');
								});

							});

						</script>
						<?php

							$customer_wise=$this->sales_order_book_model->pending_sales_order_cap_by_customer_with_customer($new_from_date,date('Y-m-d'),$coex_order_row->adr_category_id);
							$d=0;
							$total_d=0;
					        if($customer_wise==TRUE){
							foreach($customer_wise as $customer_wise_row){
								$d=($customer_wise_row->dis_tolerance<>'' ? ($customer_wise_row->order_p+(($customer_wise_row->order_p/100)*$customer_wise_row->dis_tolerance)) : $customer_wise_row->order_p);
								$total_d+=$d;
							}
							}
						
						echo "<tr class='positive' style='font-size:11px;' id='id_".$count."'>
								<td><b>$count</b></td>
								<td><b>".$coex_order_row->customer."</b></td>
								<td><i id='idd_".$count."' class='minus circle icon'></i></td>
								<td></td>";
						echo    "<td class='right aligned'><b>".money_format('%!.0n',$coex_order_row->order_pending)."</b></td>
								<td class='right aligned'><b>".money_format('%!.0n',$total_d)."</b></td>
					        </tr>";
					       	

							$customer_wise=$this->sales_order_book_model->pending_sales_order_cap_by_customer_with_customer($new_from_date,date('Y-m-d'),$coex_order_row->adr_category_id);

					        if($customer_wise==TRUE){
							foreach($customer_wise as $customer_wise_row){
								echo "<tr class='tr_".$count."'>
									<td></td>
									<td>".$this->common_model->get_article_name($customer_wise_row->cap_code,$this->session->userdata['logged_in']['company_id'])."</td>
									<td><b>".($customer_wise_row->dis_tolerance<>'' ? $customer_wise_row->dis_tolerance."%" : '')."</b></td>
									<td><b>".$customer_wise_row->cap_code."</b></td>
									";

									//<td class='right aligned'>".money_format('%!.0n',$customer_wise_row->order_r)."</td>
									//<td class='right aligned'>".money_format('%!.0n',$customer_wise_row->order_d)."</td>
								echo "<td class='right aligned'>".money_format('%!.0n',$customer_wise_row->order_p)."</td>
								<td class='right aligned'>".$a=($customer_wise_row->dis_tolerance<>'' ? money_format('%!.0n',($customer_wise_row->order_p+(($customer_wise_row->order_p/100)*$customer_wise_row->dis_tolerance))) : money_format('%!.0n',$customer_wise_row->order_p))."</td>
								</tr>";
								}
							}else{
							}

					        $total_received_quantity+=$coex_order_row->order_received;

					        $total_dispached_quantity+=$coex_order_row->order_dispached;

					        $total_pending_quantity+=$coex_order_row->order_pending;

					        $total_pending_quantity_with_tolerence+=$total_d;

					        $count++;
					    }




					    echo "<thead>
							    <tr>
							    	<th colspan='4'>GRAND TOTAL</th>";
							    	//<th class='right aligned'>".money_format('%!.0n',$total_received_quantity)."</th>
							    	//<th class='right aligned'>".money_format('%!.0n',$total_dispached_quantity)."</th>
							echo "<th class='right aligned'>".money_format('%!.0n',$total_pending_quantity)."</th>
							<th class='right aligned'>".money_format('%!.0n',$total_pending_quantity_with_tolerence)."</th>
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