<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();


		$("#sale_of_tubes").blur(function(){
			
								
			if($("#sale_of_tubes").val()!='' && $("#other_cost_value").val()!='0'){
					
					
						var cost_per_tube=	$("#other_cost_value").val() / $("#sale_of_tubes").val();
						cost_per_tube=cost_per_tube.toFixed(4);
						$("#cost_per_tube").val(cost_per_tube);
					
			}
		});

		


	});
</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result');?>" method="POST" enctype="multipart/form-data" autocomplete="off">
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">
									

									<tr>
										<td class="label" >Consumption Period <span style="color:red;">* (1 Month)</span> :</td>
										<td><input type="date" name="from_date" id="from_date" value="<?php echo set_value('from_date');?>">
										<input type="date" name="to_date" id="to_date" value="<?php echo set_value('to_date');?>"></td>
									</tr>
									<tr>
										<td class="label">Other Cost<span style="color:red;">*</span> :</td>
										<td><input type="text" name="other_cost" value="<?php echo set_value('other_cost');?>"></td>
									</tr>
									<tr>
										<td class="label">Order Type  :</td>
										<td >
											<select name="order_flag">

												<option value="">--Please Select--</option>
												<option value="0" <?php echo set_select('order_flag','0');?>>Coex</option>
												<option value="1" <?php echo set_select('order_flag','1');?> >Spring</option>
												<option value="3" <?php echo set_select('order_flag','3');?> >Other</option>
												
											</select>

										</td>
									</tr>

									<tr>
										<td class="label">Other Cost Value <span style="color:red;">* </span> :</td>
										<td><input type="text" name="other_cost_value" id="other_cost_value" value="<?php echo set_value('other_cost_value');?>"></td>
									</tr>

									<tr>
										<td class="label">No of Tubes Sold in Consumption Period <span style="color:red;">* <a href="<?php echo base_url('index.php/sales_invoice_book');?>" target="_blank">(From Sales Register)</a></span> :</td>
										<td><input type="text" name="sale_of_tubes" id="sale_of_tubes" value="<?php echo set_value('sale_of_tubes');?>"></td>
									</tr>

									<tr>
										<td class="label">Cost Per Tube <span style="color:red;">* (Automatic)</span> :</td>
										<td><input type="text" name="cost_per_tube"  id="cost_per_tube"value="<?php echo set_value('cost_per_tube');?>"></td>
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
