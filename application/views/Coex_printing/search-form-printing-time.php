<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		

		$("#customer_category").autocomplete("<?php echo base_url('index.php/ajax/customer_category_autocomplete');?>", {selectFirst: true});

		$("#article_no").autocomplete("<?php echo base_url('index.php/ajax/article_no');?>", {selectFirst: true});
		
		$("#order_no").autocomplete("<?php echo base_url('index.php/ajax/so_no');?>", {selectFirst: true});

		

	});

</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/printing_time_summary_result');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>

		<div class="ui teal labels" style="text-align: center;">
	      <div class="ui label">Printing Time Report</div>
	    </div>
	    <br/>
		
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">
						<tr>
							<td class="label"><b>From Date</b><span style="color:red;">*</span> :</td>
							<td><input type="date" name="from_date" size="10" value="<?php echo set_value('from_date',date('Y-m-d'));?>" required/>
							<b>To Date</b><span style="color:red;">*</span> :
							<input type="date" name="to_date" size="10" value="<?php echo set_value('to_date',date('Y-m-d'));?>" required/></td>
						</tr>
						<tr>
							<td class="label">Customer :</td>
							<td colspan="3" ><input type="text" name="customer_category" id="customer_category" size="40" value="<?php echo set_value('customer_category');?>"/></td>
						</tr>

						<tr>
							<td class="label">Order No  :</td>
							<td colspan="3"><input type="text" name="order_no" id="order_no" size="17" value="<?php echo set_value('order_no');?>"/></td>
						</tr>

					</table>
				</td>
				<td>
					<table class="form_table_inner">
						<tr>
							<td class="label"><b>Machine</b><span style="color:red;">*</span> :</td>
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

						<tr>
							<td class="label">Product :</td>
							<td colspan="3"><input type="text" name="article_no" id="article_no"  size="60" value="<?php echo set_value('article_no');?>" /></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<div class="form_design">
		<button class="submit" name="submit">Search</button> <a href="<?php echo base_url('index.php/coex_printing');?>">Cancel</a>
	</div>
</form>