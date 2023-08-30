<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		$("#article_no").autocomplete("<?php echo base_url('index.php/ajax/article_no');?>", {selectFirst: true});

		

		$("#currency").change(function(event) {
		   var currency = $('#currency').val().split("|")[0];
		   
		   var country=$('#currency').val().split("|")[1];
		   
		   $("#loading").show();
					$("#cover").show();
					$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
		    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/currency_rate",data: { currency : currency},cache: false,success: function(html){
		    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
		       $("#exchange_rate").html(html);
		    } 
		    });
		  });


		});
</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td width='50%'>
					<table class="form_table_inner">
						<tr>
							<td class="label">Price List Name  * :</td>
							<td><input type="text" name="price_list_name" value="<?php echo set_value('price_list_name');?>" /></td>
						</tr>
						
						<tr>
							<td class="label">Customer * :</td>
							<td><select name="customer_category" id="customer_category" ><option value=''>--Select Group--</option>
								<?php if($customer_category==FALSE){

										echo "<option value=''>--Setup Required--</option>";

									}else{
											foreach($customer_category as $customer_category_row){
												echo "<option value='".$customer_category_row->adr_category_id."'  ".set_select('customer_category',''.$customer_category_row->adr_category_id.'').">".$customer_category_row->category_name."</option>";
												
												}
											}
									?></select></td>
							</tr>

						
					</table>
				</td>
				<td></td>
			</tr>
		</table>
	</div>

	
	<div class="form_design">
		<button class="submit" name="submit">Search</button> <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>">Cancel</a>
	</div>
		
</form>
				
				
				
				
				
			