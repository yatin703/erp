<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		$("#article_no").autocomplete("<?php echo base_url('index.php/ajax/article_no');?>", {selectFirst: true});

		//$("#pg_no").autocomplete("<?php echo base_url('index.php/ajax/pricing_grid');?>", {selectFirst: true});

		$("#customer_category").change(function(event) {
		   //alert(country);
		   $("#loading").show();
					$("#cover").show();
					$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
		    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/price_list_drop",data: { customer_category : $("#customer_category").val()},cache: false,success: function(html){
		    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
		       $("#pg_no").html(html);
		    } 
		    });
		  });


		$("#pg_no").change(function(event) {
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/pricing_list_details');?>",data: {pg_no : $("#pg_no").val()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#price_list_details").html(html);
				} 
			});
		});	


		});
</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td width='50%'>
					<table class="form_table_inner">
						
						<tr>
							<td class="label">Product  * :</td>
							<td><input type="text" name="article_no" id="article_no"  size="60" value="<?php echo set_value('article_no');?>" required /></td>
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


						<tr>
							<td class="label">Price List * :</td>
							<td><select name="pg_no" id="pg_no" ><option value=''>--Select Price List--</option>
								<?php if($pg_no==FALSE){

										echo "<option value=''>--Setup Required--</option>";

									}else{
											foreach($pg_no as $pg_no_row){
												echo "<option value='".$pg_no_row->pg_no."'  ".set_select('pg_no',''.$pg_no_row->pg_no.'').">".$pg_no_row->price_list_name."</option>";
												
												}
											}
									?></select></td>
						</tr>

						<!--

						<tr>
							<td class="label">Price Grid  * :</td>
							<td><input type="text" name="pg_no" id="pg_no"  size="60" value="<?php echo set_value('pg_no');?>" required /></td>
						</tr>-->

						</table>
				</td>
				<td>
			</tr>
		</table>

		<span id="price_list_details">
			
		</span>

	</div>

	


	<div class="form_design">
		<button class="submit" name="submit">Save</button> <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>">Cancel</a>
	</div>
		
</form>
				
				
				
				
				
			