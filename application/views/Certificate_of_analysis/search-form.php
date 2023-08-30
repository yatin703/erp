<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		$("#certificate_no").autocomplete("<?php echo base_url('index.php/ajax/ar_invoice_no');?>", {selectFirst: true});
	});
</script>
<style>
	input[type="date"]{width: 100%;}
	input[type="text"]{width: 100%;}
</style>
<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
		<table class="form_table_design">
			<tr>					
					<tr>
						<td class="label"><b>From Date</b><span style="color:red;">*</span> :</td>
						<td width="25%"><input type="date" name="from_date"  size="10" value="<?php echo set_value('from_date',date('Y-m-d'));?>" required/>
						</td>
						<td class="label"><b>To Date</b><span style="color:red;">*</span> :</td>
						<td width="25%"><input type="date" name="to_date"  size="10" value="<?php echo set_value('to_date',date('Y-m-d'));?>" required/>
						</td>
						<td class="label"><b>Certificate No.</b></td>
						<td><input type="text" name="certificate_no"  Placeholder="Search Invoice No." id="certificate_no" size="" value="<?php echo set_value('certificate_no');?>" size="16" maxlength="16" onchange="check_invoice_no(this.value);" ></td>							
					</tr>
				<td>
					<tr>
						<td class="label"><b>SO NO.</b>:</td>
						<td class="label"><input type="text" name="so_no"  size="" Placeholder="Enter SO NO." id="order_no"  value="<?php echo set_value('so_no');?>" ></td>
						<td class="label"><b>Product</b>:</td>
						<td><input type="text" name="product_name"  size="" Placeholder="Enter Product Name" id="aid_article_no"value="<?php echo set_value('product_name');?>"></td>
						<td class="label"><b>Customer Name</b>:</td>
						<td><input type="text" name="customer_name"  Placeholder="Enter Customer Name" size="" id="customer_name" value="<?php echo set_value('customer_name');?>">
						</td>
					</tr>
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




				
				
				
			