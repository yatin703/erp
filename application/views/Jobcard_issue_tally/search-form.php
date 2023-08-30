<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();

		//$("#part_no").autocomplete("http://192.168.0.33/erp/index.php/ajax/purchase_article_no", {selectFirst: true});
		$("#part_no").autocomplete("<?php echo base_url('index.php/ajax/purchase_article_no');?>", {selectFirst: true});

		//$("#jobcard_no").autocomplete("http://192.168.0.33/erp/index.php/ajax/jobcard_autocomplete", {selectFirst: true});
		$("#jobcard_no").autocomplete("<?php echo base_url('index.php/ajax/jobcard_autocomplete');?>", {selectFirst: true});

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
										<td class="label" width="25%">From Date <span style="color:red;">*</span> :</td>
										<td width="25%"><input type="date" name="from_date" id="from_date" value="<?php echo set_value('from_date',date('Y-m-d'));?>"/></td>
										<td class="label" width="25%">To Date <span style="color:red;">*</span> :</td>
										<td width="25%"><input type="date" name="to_date" id="to_date" value="<?php echo set_value('to_date',date('Y-m-d'));?>"/></td>
									</tr>
									<tr>
										<td class="label">Jobcard No  :</td>
										<td><input type="text" name="jobcard_no" id="jobcard_no" maxlength="50" size="18" value="<?php echo set_value('jobcard_no');?>" /></td>
										<td class="label">Status  :</td>
										<td>
										<select name="status"><option value="--">--Select Status--</option>
											<option value="POSTED" <?php echo set_select('status','POSTED');?>>POSTED</option>
											<option value="ERROR" <?php echo set_select('status','ERROR');?>>ERROR</option>
											<option value="" <?php echo set_select('status','NOT POSTED');?>>NOT POSTED</option>
										</select>											
										</td>
									</tr>
									<tr>
										<td class="label">Article No  :</td>
										<td colspan="3"><input type="text" name="part_no" id="part_no" maxlength="50" size="65" value="<?php echo set_value('part_no');?>" /></td>								
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
				
				
				
				
				
			