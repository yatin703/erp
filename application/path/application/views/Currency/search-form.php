<script type="text/javascript">
$(document).ready(function() {
		$("#loading").hide();
		$("#cover").hide();
    $("#for_currency").change(function(event) {
    var for_currency = $('#for_currency').val();
    $("#loading").show();
				$("#cover").show();
				$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/currency",data: {for_currency : $('#for_currency').val()},cache: false,success: function(html){
    	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
       $("#to_currency").html(html);
    } 
    });
   });


});
</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result');?>" method="POST" enctype="multipart/form-data">
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">

									<tr>
										<td class="label">Country :</td>
										<td>
											<select name="country_id" id="country_id"><option value=''>--Select Country--</option>
											<?php if($country==FALSE){
															echo "<option value=''>--Country Setup Required--</option>";}
												else{
													foreach($country as $country_row){
														
														echo '<option value="'.$country_row->country_id.'"'.set_select('country_id',''.$country_row->country_id.'').' >'.$country_row->lang_country_name.'</option>';
													}
											}?>
											</select>
										</td>

									</tr>
									<tr>
										<td class="label">For Currency :</td>
										<td>
											<select name="for_currency" id="for_currency"><option value=''>--Please Select--</option>
											<?php if($for_currency==FALSE){
															echo "<option value=''>--Currency Setup Required--</option>";}
												else{
													foreach($for_currency as $for_currency_row){
														
														echo '<option value="'.$for_currency_row->currency_name.'"'.set_select('for_currency',''.$for_currency_row->currency_name.'').' >'.$for_currency_row->currency_name.'</option>';
													}
											}?>
											</select>
										</td>

									</tr>
									<tr>
										<td class="label">To Currency  :</td>
										<td>
											<select name="to_currency" id="to_currency"><option value=''>--Please Select--</option>
											<?php if($to_currency==FALSE){
															echo "<option value=''>--Currency Setup Required--</option>";}
												else{
													foreach($to_currency as $to_currency_row){
														
														echo '<option value="'.$to_currency_row->currency_name.'"'.set_select('to_currency',''.$to_currency_row->currency_name.'').' >'.$to_currency_row->currency_name.'</option>';
													}
											}?>
											</select>
										</td>

									</tr>
									<tr>
										<td class="label">Exchange Rate :</td>
										<td><input type="text" name="exchange_rate" maxlength="10" size="20" value="<?php echo set_value('exchange_rate');?>"/></td>
									</tr>
									<tr>
										<td class="label">Old Exchange Rate  :</td>
										<td><input type="text" name="old_exch_rate" maxlength="10" size="20" value="<?php echo set_value('old_exch_rate');?>"/></td>
									</tr>

					</table>			
								
				</td>
							
			</tr>
		</table>
					
	</div>

	<div class="form_design">
			
		<button class="submit" name="submit">Search</button> <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>">Cancel</a>
	</div>
		
</form>
				
				
				
				
				
			