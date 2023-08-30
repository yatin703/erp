<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();

		$("#customer_no").autocomplete("<?php echo base_url('index.php/ajax/customer');?>", {selectFirst: true});

	});
</script>


<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result');?>" method="POST" enctype="multipart/form-data">
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>

		
			
		<table class="form_table_design">
			
			<tr>
				<td>
					<table class="form_table_inner">		

						

						<tr>
							<td class="label">Remark<span style="color:red;">* </span> :</td>
							<td><input type="text" name="remark" id="remark" step="any" value="<?php echo set_value('remark');?>" ></td>
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
