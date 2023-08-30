<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		$("#jobcard_no").autocomplete("<?php echo base_url('index.php/ajax/jobcard_autocomplete');?>", {selectFirst: true});	
		
		/*$("#jobcard_no").live('keyup',function() {
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/jobcard_no');?>",data: {jobcard_no : $("#jobcard_no").val()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#jobcard_order_details").html(html);
				} 
			});
		});*/

		/*$("#jobcard_no").live('keyup',function() {
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/jobcard_material_details');?>",data: {jobcard_no : $("#jobcard_no").val()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#jobcard_material_details").html(html);
				} 
			});
		});*/

		

	});//Jquery closed

</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
		<table class="form_table_design">
			<tr>

				<td width="45%">
					<table class="form_table_inner">

						<tr>
							<td class="label" width="25%"><b>From Date</b><span style="color:red;">*</span> :</td>
							<td width="25%"><input type="date" name="from_date"  size="10" value="<?php echo set_value('from_date',date('Y-m-d'));?>" required/>
							</td>
							<td class="label" width="25%"><b>To Date</b><span style="color:red;">*</span> :</td>
							<td width="25%"><input type="date" name="to_date"  size="10" value="<?php echo set_value('to_date',date('Y-m-d'));?>" required/>
							</td>
							
						</tr>

						<tr>
							<td class="label"><b>Shift</b> :</td>
							<td><select name="shift" id="shift"><option value=''>--Shift--</option>
								<?php if($shift_master==FALSE){
												echo "<option value=''>--Setup Required--</option>";}
									else{
										foreach($shift_master as $shift_master_row){

											echo "<option value='".$shift_master_row->shift_id."'  ".set_select('shift',''.$shift_master_row->shift_id.'').">".$shift_master_row->shift_name."</option>";
										}
								}?></select></td>
								<td class="label"><b>Machine</b> :</td>
								<td><select name="machine" id="machine"><option value=''>--Machine--</option>
								<?php if($coex_machine_master==FALSE){
												echo "<option value=''>--Setup Required--</option>";}
									else{
										foreach($coex_machine_master as $machine_row){
											echo "<option value='".$machine_row->machine_id."'  ".set_select('machine',''.$machine_row->machine_id.'').">".$machine_row->machine_name."</option>";
										}
								}?>
							</select></td>
						</tr> 

						

						

						
						
						

					</table>
			
				</td>
				<td>
					<table class="form_table_inner">

						<tr>
							<td class="label"><b>Prepared By :</td>
							<td><input type="text" name="operator" size="10" value="<?php echo set_value('operator');?>">
							<td class="label"><b>Job Card</b> :</td>
							<td><input type="text" name="jobcard_no" id="jobcard_no"  size="15" value="<?php echo set_value('jobcard_no');?>"/>
							</td>
						</tr>

						<tr>
							<td class="label"><b>Order No :</td>
							<td><input type="text" name="order_no" size="10" value="<?php echo set_value('order_no');?>">
							<td class="label"><b>Product No :</td>
							<td><input type="text" name="product_no" size="15" value="<?php echo set_value('product_no');?>"/>
							</td>
						</tr>

					</table>
				</td>
				
				
							
			</tr>

		</table>
					
	</div>

	<div class="form_design">
		<div class="ui buttons">
	  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui positive button">Search</button>
		</div>
	</div>

	
</form>




				
				
				
			