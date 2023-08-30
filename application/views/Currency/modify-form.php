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

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST" enctype="multipart/form-data">
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">

		
			<tr>
				<td>
					<table class="form_table_inner">

						<?php foreach($currency_rates_master as $row):?>
									
									<tr>
										<td class="label">Country  <span style="color:red;">*</span> :</td>
										<td>
										<input type="hidden" name="country_id" id="country_id"  value="<?php echo $row->country_id;?>" />
										<input type="text" name="lang_country_name" maxlength="10" size="20" value="<?php echo set_value('lang_country_name',$row->lang_country_name);?>" readonly/></td>
									</tr>
									<tr>
										<td class="label">For Currency  <span style="color:red;">*</span> :</td>
										<td><input type="text" name="for_currency" maxlength="10" size="20" value="<?php echo set_value('for_currency',$row->for_currency);?>" readonly/></td>
									</tr>
									<tr>
										<td class="label">To Currency  <span style="color:red;">*</span> :</td>
										<td><input type="text" name="to_currency" maxlength="10" size="20" value="<?php echo set_value('to_currency',$row->to_currency);?>" readonly/></td>
									</tr>
									<tr>
										<td class="label">Exchange Rate :</td>
										<td><input type="text" name="exchange_rate" maxlength="10" size="20" value="<?php echo set_value('exchange_rate',($row->exchange_rate!=0? $row->exchange_rate/100 :$row->exchange_rate));?>"/></td>
									</tr>
									<tr>
										<td class="label">Old Exchange Rate  :</td>
										<td><input type="text" name="old_exch_rate" maxlength="10" size="20" value="<?php echo set_value('old_exch_rate',($row->old_exch_rate!=0 ? $row->old_exch_rate/100 :$row->old_exch_rate));?>"/></td>
									</tr>

						<?php endforeach;?>			

					</table>			
								
				</td>
							
			</tr>

		</table>
					
	</div>

	<div class="form_design">
			
		<button class="submit" name="submit">Update</button> <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>">Cancel</a>
	</div>
		
</form>
				
				
				
				
				
			