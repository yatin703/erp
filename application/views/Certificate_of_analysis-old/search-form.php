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
	input{width: 100%;}
    .align-ctr{text-align: center;}
	.align-ctr1{text-align: center;}
	.align-lft{text-align: left;}
    td.label.align-ctr{vertical-align: middle;}
    select{width: 100%;}
    .span-h{font-size: 16px;
    border-bottom: 1px solid #000000;}
    .span-required{color: red;}
</style>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result');?>" method="POST" enctype="multipart/form-data">
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
		<table class="form_table_design">
		  <tr>
			<td>
			  <table class="form_table_inner" width="100%">
				<tr>
					<td class="label"><b>Certificate No.</b><span style="color:red;">*</span> :</td>
					<td colspan="2"><input type="text" name="certificate_no"  Placeholder="Search Invoice No." id="certificate_no" size="" value="<?php echo set_value('certificate_no');?>" size="16" maxlength="16" onchange="check_invoice_no(this.value);" required/></td> 
					<td class="label"><b>Date</b><span style="color:red;">*</span> :</td>
					<td colspan="2"><input type="date" name="inspection_date"  size="10" id="invoice_date" value="<?php echo set_value('inspection_date',date('Y-m-d'));?>" required/></td>
					<td class="label"><b>SO NO.</b><span style="color:red;">*</span> :</td>
					<td colspan="2"><input type="text" name="so_no"  size="" Placeholder="Enter SO NO." id="order_no" readonly value="<?php echo set_value('so_no');?>"  required/></td>
				</tr> 

				<tr>
					<td class="label"><b>Product</b><span style="color:red;">*</span> :</td>
					<td colspan="2"><input type="text" name="product_name"  size="" Placeholder="Enter Product Name" id="aid_article_no"value="<?php echo set_value('product_name');?>" required/></td> 

					  <td class="label"><b>Customer Name</b><span style="color:red;">*</span> :</td>
					<td colspan="2"><input type="text" name="customer_name"  Placeholder="Enter Customer Name" size="" id="customer_name" value="<?php echo set_value('customer_name');?>" required/></td> 
				</tr>
			  </table>
			</td>		
		  </tr>
		  <tr>
			<td>
				<div class="ui buttons">
			  		<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
			  		<div class="or"></div>
			  		<button class="ui positive button">Search</button>
				</div>
			</td>
		  </tr>
		</table>			
	</div>
</form>

<script>
	function check_invoice_no(certificate_no) {
      
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url();?>index.php/certificate_of_analysis/get_ajax_ar_invoice_no_id",
            async: false,
            dataType: 'json',
            data: {certificate_no:certificate_no},
           // alert(data);
            success: function(res) {
                if (res.status == "200") {	
				   $('#invoice_date').val(res.data['invoice_date']); 
				   $('#aid_article_no').val(res.data['aid_article_no']); 
				   $('#customer_no').val(res.data['customer_no']); 
				   $('#customer_name').val(res.data['customer_name']); 
				   $('#order_no').val(res.data['order_no']); 
				   
                } else {
					$('#invoice_date').val('');                    
					$('#aid_article_no').val('');                    
					$('#customer_no').val('');  
					$('#customer_name').val('');      
					$('#order_no').val('');  
                }
            }
        });
        return false;
    }
</script>