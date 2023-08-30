<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){

		//$(document).attr("title", "<?php echo strtoupper($this->router->fetch_class());?>");

		$("#loading").hide(); $("#cover").hide();
		$("#adr_company_id").autocomplete("<?php echo base_url('index.php/ajax/customer');?>", {selectFirst: true});
		$("#article_no").autocomplete("<?php echo base_url('index.php/ajax/article_no');?>", {selectFirst: true});
		$("#order_no").autocomplete("<?php echo base_url('index.php/ajax/so_no_transaction_open');?>", {selectFirst: true});

		$("#customer_category").autocomplete("<?php echo base_url('index.php/ajax/customer_category_autocomplete');?>", {selectFirst: true});

	});		
		 
</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result_open_transaction');?>" id="form1" method="POST" >

	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>

		<fieldset style="border: 1px solid #8cacbb;">
			<legend><b>Open Transaction Search:</b></legend>
			<table class="form_table_design">
				<tr>
					<td width="50%">
						<table class="form_table_inner">
							<tr>
								<td class="label" >From Date <span style="color:red;">*</span>  :</td>
								<td><input type="date" name="from_date" id="from_date" value="<?php echo set_value('from_date');?>"/></td>
								<td class="label" >To Date <span style="color:red;">*</span>  :</td>
								<td><input type="date" name="to_date" id="to_date" value="<?php echo set_value('to_date');?>"/></td>
							</tr>
							<tr>
								<td class="label">Sales Order  :</td>
								<td ><input type="text" name="order_no" id="order_no" size="17" value="<?php echo set_value('order_no');?>"/>
								
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<div class="ui buttons">
						  				<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
						  				<div class="or"></div>
						  				<button class="ui positive button" onClick="return validate_form(); ">Search</button>
									</div>
								</td>
							</tr>	
																			 
						</table>
									
					</td>
					<td width="50%">
						<table class="form_table_inner">
							<tr>
								<td class="label">Customer :</td>
								<td colspan="3" ><input type="text" name="customer_category" id="customer_category" size="40" value="<?php echo set_value('customer_category');?>"/></td>
							</tr>							 						 
							<tr>
								<td class="label">Article   :</td>
								<td colspan="3"><input type="text" name="article_no" id="article_no"  size="60" value="<?php echo set_value('article_no');?>" /></td>
							</tr>
						</table>
					</td>			
								
				</tr>
			</table>
		</fieldset>					
	</div>		
</form>

		
				
				
				
			