<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>

<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
        
        $("#search").click(function(){
			$("#loading").show(); $("#cover").show();

			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/ajax_sales_pcb');?>",data: {from_date : $(".from_date").val(),to_date :$('.to_date').val() },
				cache: false,
				success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#check").html(html);
				} 
			});
		});
		
        //$("#customer_category").autocomplete("<?php echo base_url('index.php/ajax/customer_category_autocomplete');?>", {selectFirst: true});

		//$("#ar_invoice_no").autocomplete("<?php echo base_url('index.php/ajax/ar_invoice_no');?>", {selectFirst: true});		
		
		/*$("#search").click(function(){
			$("#loading").show(); $("#cover").show();

			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/ajax_sales_pcb');?>",data: {from_date : $(".from_date").val(),to_date :$('.to_date').val(),ar_invoice_no:$("#ar_invoice_no").val() },
				cache: false,
				success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#check").html(html);
				} 
			});
		});*/

/*		$("#search").click(function(){
			$("#loading").show(); $("#cover").show();

			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/ajax_sales_pcb');?>",data: {from_date : $(".from_date").val(),to_date :$('.to_date').val(),customer_category:$("#customer_category").val() },
				cache: false,
				success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#check").html(html);
				} 
			});
		});*/
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
				    	<!-- <tr>
							<td class="label">Invoice No :</td>
							<td colspan="3" ><input type="text" name="ar_invoice_no" id="ar_invoice_no" size="40" value="<?php echo set_value('ar_invoice_no');?>"/></td>
						</tr> -->
						<!-- <tr>
							<td class="label">Customer :</td>
							<td colspan="3" ><input type="text" name="customer_category" id="customer_category" size="40" value="<?php echo set_value('customer_category');?>"/></td>
						</tr> -->
						<!-- 
						<tr>
							<td class="label" width="25%">Convert</td>
							<td colspan="3">
								<select name="convert" class="convert">
								<option value="0">INR</option>
								<option value="1">Millions</option>
								</select>
							</td>
						</tr> -->
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
			        <table class="record_table_design_without_fixed" id="table-1">
					    <thead>
							<tr>
								<th>Sr. No.</th>
								<th>Invoice Date</th>
								<th>Invoice No.</th>
								<th>Customer (Bill To)</th>
								<th>Layer No.</th>
								<th>Address (Bill To Address)</th>
								<th>State</th>
								<th>Contact No</th>
								<th>GST No</th>
								<th>GST Amount</th>	
							</tr>
						</thead>
					    <tbody>
						<?php 
                            $ci =&get_instance();
                            $exchange_rate=0; 
                            $freight_in_rupees=0;
                            $packaging_in_rupees=0;
                            $insurance_in_rupees=0;
                            $gross_amount_in_rupees=0;

						    if($ar_invoice_master==FALSE){
								echo "<tr><td colspan='9'>No Records Found</td></tr>";
							}
							else 
							{
								$ci =&get_instance();
								$ci->load->model('sales_invoice_book_model');
							    $ci->load->model('common_model');
							    $ci->load->model('article_model');
							    $ci->load->model('customer_model');
							    $n=1;
								foreach($ar_invoice_master as $mrow){
									
									   $exchange_rate=($mrow->exchange_rate!='0' ? $ci->common_model->read_number($mrow->exchange_rate,$this->session->userdata['logged_in']['company_id']):'');
				
										$freight_in_rupees=$ci->common_model->read_number($mrow->freight_amt,$this->session->userdata['logged_in']['company_id'])*$exchange_rate;
										
										$packaging_in_rupees=$ci->common_model->read_number($mrow->packagingcost,$this->session->userdata['logged_in']['company_id'])*$exchange_rate;
										
										$insurance_in_rupees=$ci->common_model->read_number($mrow->insu_amt,$this->session->userdata['logged_in']['company_id'])*$exchange_rate;
										
										$gross_amount_in_rupees= ($ci->common_model->read_number($mrow->totalpricewithtax,$this->session->userdata['logged_in']['company_id'])*$exchange_rate)+ $freight_in_rupees + $packaging_in_rupees + $insurance_in_rupees + $mrow->tcs_amt;

									if($mrow->layer_no!=''){
                                        $layer_no = $mrow->layer_no;
									}else{
										$layer_no='Not Applicable';
									}

									echo "<tr>
									<td>".$n++."</td>
									<td >".$ci->common_model->view_date($mrow->invoice_date,$this->session->userdata['logged_in']['company_id'])."</td>
									<td>".$mrow->ar_invoice_no."</td>							
									<td>".$mrow->name1." (".strtoupper($mrow->lang_property_name).") </td>
									<td>".$layer_no." </td>
									<td>".strtoupper($mrow->strno)." ".strtoupper($mrow->name2)." ".strtoupper($mrow->street)." ".strtoupper($mrow->name3)."</td>
									<td>".strtoupper($mrow->lang_city)."</td>
									<td>".$mrow->telephone1."</td>
									<td>".$mrow->isdn_local."</td>
									<td>".number_format($gross_amount_in_rupees,2,'.',',')."</td>";
								}
							} 
							?>
						</tbody>	
					</table>				
		            <div class="pagination"><?php echo $this->pagination->create_links();?></div>
		        </span>	
		    </div>
		</div>						
    </div>
</div>