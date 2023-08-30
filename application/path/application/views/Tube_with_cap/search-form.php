<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		$("#customer").autocomplete("<?php echo base_url('index.php/ajax/customer');?>", {selectFirst: true});
		$("#article_no").autocomplete("<?php echo base_url('index.php/ajax/article_no');?>", {selectFirst: true});


		$(".supplier").autocomplete("<?php echo base_url('index.php/ajax/supplier');?>", {selectFirst: true});

	});
</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">

									<tr>
										<td class="label">From Date :</td>
										<td><input type="date" name="from_date" id="from_date" value="<?php echo set_value('from_date');?>"/></td>
									</tr>
									
									<tr>
										<td class="label">To Date :</td>
										<td><input type="date" name="to_date" id="to_date" value="<?php echo set_value('to_date');?>"/></td>
									</tr>


									<tr>
										<td class="label">Customer :</td>
										<td><input type="text" name="customer" id="customer" size="60" value="<?php echo set_value('customer');?>" /></td>
									</tr>

									<tr>
										<td class="label">Article  :</td>
										<td><input type="text" name="article_no" id="article_no" size="60" value="<?php echo set_value('article_no');?>" /></td>
									</tr>

									<tr>
										<td class="label">Spec No :</td>
										<td><input type="text" name="spec_no" value="<?php echo set_value('spec_no');?>" /></td>
									</tr>

									<tr>
										<td class="label">Spec Version No :</td>
										<td><input type="text" name="spec_version_no" size="3" value="<?php echo set_value('spec_version_no');?>" /></td>
									</tr>

									<tr>
										<td class="label">Artwork No :</td>
										<td><input type="text" name="artwork_no"  value="<?php echo set_value('artwork_no');?>" /></td>
									</tr>

									<tr>
										<td class="label">Artwork Version No  :</td>
										<td><input type="text" name="artwork_version_no"  size="3" value="<?php echo set_value('artwork_version_no');?>" /></td>
									</tr>

									<tr>
										<td class="label">Approval Status  :</td>
										<td><select name="final_approval_flag" id="final_approval_flag" >
														<option value="" <?php echo (set_value('final_approval_flag')==""?"selected":"")?>>All</option>
														<option value="1" <?php echo (set_value('final_approval_flag')=="1"?"selected":"")?> >Approved</option>
														<option value="0" <?php echo (set_value('final_approval_flag')=="0"?"selected":"")?>>Not Approved</option>
														</select>
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
				
				
				
				
				
			