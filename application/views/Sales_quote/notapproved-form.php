<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();

	});//Jquery closed

</script>
<style type="text/css">fieldset {border: 1px solid #8cacbb;}fieldset legend{font-weight: bold;}.number{width:25%;}.number1{width:100%;}</style>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/notapproved_update');?>" method="POST" enctype="multipart/form-data">
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<?php foreach($sales_quote_master as $row):?>

			<table class="form_table_design" id="abc">
			<tr>
				<td width="50%">
					<table class="form_table_inner" width="50%">
						<tr>
							<td>
								<fieldset>
									<legend>Information:</legend>
									<table class="form_table_inner">

										<tr>
											<td class="label"  width="26%"> Quotation No : <span style="color:red;">*</span> :</td>
											<td style="width: 0%;">
												<input type="text" name="quotation_no" value="<?php echo $row->quotation_no;?>" readonly>
											</td>		
											<td class="label" width="20%">Version No <span style="color:red;">*</span> :</td>
											<td width="25%">
											    <input type="text" name="version_no" size="5" value="<?php echo $row->version_no;?>" readonly >
											</td>								
										</tr>

										<tr>
											<td class="label"  width="26%"> Customer: <span style="color:red;">*</span> :</td>
											<td colspan="3">
												<input type="hidden" name="id" value="<?php echo $row->id;?>" readonly>
												<input type="hidden" name="transaction_no" value="<?php echo $this->uri->segment(5);?>" readonly>	
												<input type="hidden" name="record_no" value="<?php echo $row->quotation_no.'@@@'.$row->version_no;?>" readonly>
												<input type="text"  disabled  name="customer" id="customer_category"  size="50" value="<?php echo set_value('category_name',$row->category_name.'//'.$row->customer_no.'');?>" /></td>
										</tr>

										<tr>							
											<td class="label">Product Name <span style="color:red;">*</span> :</td>
											<td colspan="3"> <input type="text" disabled name="product_name"  size="50" value="<?php echo set_value('product_name',$row->product_name);?>" />
																	
											</td>								
										</tr>

										<tr>
											<td class="label">Payment Terms <span style="color:red;">*</span>  :</td>
											<td colspan="3"><input type="text" disabled name="credit_days" value="<?php echo set_value('credit_days',$row->credit_days	);?>" >
											</td>
									 	</tr>

									 	<tr>
											<td class="label">Date of Enquiry <span style="color:red;">*</span>  :</td>
											<td colspan="3"><input type="date" disabled name="enquiry_date" value="<?php echo set_value('enquiry_date',$row->enquiry_date	);?>" >
											</td>
									 	</tr>

									 	<tr>
											<td class="label">Rejection Reason <span style="color:red;">*</span>  :</td>
											<td colspan="3"><textarea id="rejected_reason" name="rejected_reason" rows="4" cols="50"></textarea>
											</td>
									 	</tr>
										


									</table>
								</fieldset>
							</td>
						</tr>
					</table>	
				</td>
			</tr>
		</table>
		<?php endforeach;?>				
	</div>

	<div class="form_design">
		<div class="ui buttons">
	  		<a href="<?php echo base_url('index.php/sales_quote_followup');?>" class="ui button">Cancel</a>
	  		<div class="or"></div>
	  		<button class="ui positive button" onClick="return confirm('Are you sure to Reject Record?');">Reject</button>
		</div>
	</div>	
</form>
				
				
				
			