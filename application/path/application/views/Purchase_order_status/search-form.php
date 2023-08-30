<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		$("#adr_company_id").autocomplete("<?php echo base_url('index.php/ajax/supplier');?>", {selectFirst: true});
		//$("#consin_adr_company_id").autocomplete("<?php echo base_url('index.php/ajax/customer');?>", {selectFirst: true});
		$("#article_no").autocomplete("<?php echo base_url('index.php/ajax/purchase_article_no');?>", {selectFirst: true});

		

	});

</script>
<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">
									
						<tr>
							<td class="label" width="25%">From Date <span style="color:red;">*</span> :</td>
							<td width="25%"><input type="date" name="from_date" id="from_date" value="<?php echo set_value('from_date',date('Y-m-d'));?>"/></td>
							<td class="label" width="25%">To Date <span style="color:red;">*</span> :</td>
							<td width="25%"><input type="date" name="to_date" id="to_date" value="<?php echo set_value('to_date',date('Y-m-d'));?>"/></td>
						</tr>
						<tr>
							<td class="label">Supplier  :</td>
							<td colspan="3"><input type="text" name="adr_company_id" id="adr_company_id"  size="60" value="<?php echo set_value('adr_company_id');?>" /></td>
						</tr>
						
						<tr>
							<td class="label">Article   :</td>
							<td colspan="3"><input type="text" name="article_no" id="article_no"  size="60" value="<?php echo set_value('article_no');?>" /></td>
						</tr>
						<tr>
							<td class="label">PO No.  :</td>
							<td colspan="3"><input type="text" name="po_no" id="po_no" size="17" value="<?php echo set_value('po_no');?>"/></td>
						</tr>
									
									
					</table>			
				</td>
				<td width="50%">
					
					<table class="form_table_inner">
									
						<tr>
							<td class="label"> Order Type  :</td>
							<td colspan="3">
								<select name="for_import" id="for_import" >

									<option value="" <?php echo set_select('for_import','');?>>--Please Select--</option>
									<option value="0" <?php echo set_select('for_import','0');?>>Local</option>
									<option value="1" <?php echo set_select('for_import','1');?> >Import</option>
									
								</select>

							</td>
						</tr>
						
						<tr>
							<td class="label"> Approval Status  :</td>
							<td colspan="3">
								<select name="final_approval_flag" id="final_approval_flag" >
									<option value="" <?php echo set_select('final_approval_flag',''); ?>>--Please Select--</option>
									<option value="1" <?php echo set_select('final_approval_flag','1'); ?> >Approved</option>
									<option value="0" <?php echo set_select('final_approval_flag','0'); ?>>Not Approved</option>
								</select>

							</td>
						</tr>

						<tr>
							<td class="label"> Order Status  :</td>
							<td colspan="3">
								<select name="po_grir_completed" id="po_grir_completed" >

									<option value="" <?php echo set_select('po_grir_completed','');?>>--Please Select--</option>
									<option value="0" <?php echo set_select('po_grir_completed','0');?>>Open</option>
									<option value="1" <?php echo set_select('po_grir_completed','1');?> >Completed</option>
									<option value="2" <?php echo set_select('po_grir_completed','2');?> >Partially Completed</option>
								</select>

							</td>
						</tr>
						<tr>
							<td class="label"> Transaction Status  :</td>
							<td>
								<select name="trans_closed" id="trans_closed" >
									<option value="" <?php echo set_select('trans_closed','');?>>--Please Select--</option>
									<option value="0" <?php echo set_select('trans_closed','0');?>>Open</option>
									<option value="1" <?php echo set_select('trans_closed','1');?> >Closed</option>
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
				
				
				
				
				
			