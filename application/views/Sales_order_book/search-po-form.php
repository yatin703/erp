<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){

		//$(document).attr("title", "<?php echo strtoupper($this->router->fetch_class());?>");

		$("#loading").hide(); $("#cover").hide();
		$("#adr_company_id").autocomplete("<?php echo base_url('index.php/ajax/customer');?>", {selectFirst: true});
		
		$("#customer_category").autocomplete("<?php echo base_url('index.php/ajax/customer_category_autocomplete');?>", {selectFirst: true});
		});

</script>	

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result_po');?>" id="form1" method="POST" >

	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td width="55%">
					<table class="form_table_inner">

						<tr>
							<td class="label">Customer  :</td>
							<td colspan="3" ><input type="text" name="adr_company_id" id="adr_company_id"  size="65" value="<?php echo set_value('adr_company_id');?>" /></td>
						</tr>

						<tr>
							<td class="label">Customer Po No.  :</td>
							<td><input type="text" name="cust_order_no" id="cust_order_no" size="17" value="<?php echo set_value('cust_order_no');?>"/></td>
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
	  		<button class="ui positive button" id="search">Search</button>
		</div>
	</div>

	



		
</form>

		
				
				
				
			