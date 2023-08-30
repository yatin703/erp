<script type="text/javascript">
$(document).ready(function() {
		$("#loading").hide();
		$("#cover").hide();

		$("#year").change(function(event) {
   var year = $('#year').val();
   var month = $('#month').val();
   $("#loading").show();
			$("#cover").show();
			$("#prev_records").hide();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/top_customer_order",data: {year : $('#year').val(),month : $('#month').val()},cache: false,success: function(html){
    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
       $("#records").html(html);
    } 
    });
   });

		$("#month").change(function(event) {
   var year = $('#year').val();
   var month = $('#month').val();
   $("#loading").show();
			$("#cover").show();
			$("#prev_records").hide();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/top_customer_order",data: {year : $('#year').val(),month : $('#month').val()},cache: false,success: function(html){
    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
       $("#records").html(html);
    } 
    });
   });



});
</script>

<div class="record_form_design">
		<div class="record_inner_design" style="overflow: scroll;">

<table class="record_table_design_without_fixed">
					<tr>
						<td class="label">Select :</td>
						<td>
						<?php $yearArray = range(2011, 2020);?>
						<select name="year" id="year">
			    <option value="">Select Year</option>
			    <?php
			    foreach ($yearArray as $year) {
			        // if you want to select a particular year
			        $selected = ($year == date("Y")) ? 'selected' : '';
			        echo '<option '.$selected.' value="'.$year.'">'.$year.'</option>';
			    }
			    ?>
						</select></td>
						<td><?php
										$monthArray = range(1, 12);
										?>
										<select name="month" id="month">
										    <option value="">Select Month</option>
										    <?php
										    foreach ($monthArray as $month) {
										    					$selected= ($month==date('m') ? 'selected' :'');
										        echo '<option value="'.$month.'" '.$selected.'>'.date('M', mktime(0, 0, 0, $month, 1)).'</option>';
										    }
										    ?>
										</select></td>
					</tr>
					</table>
					<div id="records"></div>
					<div id="prev_records">
					<table class="record_table_design_without_fixed">
					<tr>
						<th colspan='3'></th>
						<th colspan='4'>Total Orders</th>
					</tr>
					<tr>
						<th>Id</th>
						<th>Month-Year</th>
						<th>Customer</th>
						<th>Local</th>
						<th>Value</th>
						<th>Export</th>
						<th>Value</th>
					</tr>
					<?php if($top_orders==FALSE){

						echo "<tr>
													<td colspan='7'>No Record Found</td>
												</tr>";

					}else{
						$i=($this->uri->segment(3)=="" ? 1 : $this->uri->segment(3)+1);
						foreach($top_orders as $top_orders_row){
							echo "<tr>
														<td>$i</td>
														<td>".$top_orders_row->month_name."-".$top_orders_row->year."</td>
														<td>$top_orders_row->customer_name</td>
														<td>$top_orders_row->local</td>
														<td>".number_format($this->common_model->read_number($top_orders_row->local_value,$this->session->userdata['logged_in']['company_id']))."</td>
														<td>$top_orders_row->export</td>
														<td>".number_format($this->common_model->read_number($top_orders_row->export_value,$this->session->userdata['logged_in']['company_id']))."</td>
							</tr>";
							$i++;
						}
					}
					?>
				</table>

				</div>
			
				
			
						
	</div>