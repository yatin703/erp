<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();

		
		$("#customer").autocomplete("<?php echo base_url('index.php/ajax/customer');?>", {selectFirst: true});

		$("#order_no").autocomplete("<?php echo base_url('index.php/ajax/so_no');?>", {selectFirst: true});

		$("#article_no").autocomplete("<?php echo base_url('index.php/ajax_springtube/article_no_springtube');?>", {selectFirst: true});

		$("#jobcard_no").autocomplete("<?php echo base_url('index.php/ajax_springtube/jobcard_extrusion_autocomplete');?>", {selectFirst: true});

		$("#film_code").autocomplete("<?php echo base_url('index.php/ajax_springtube/film_autocomplete');?>", {selectFirst: true});

		$("#from_order_no").autocomplete("<?php echo base_url('index.php/ajax/so_no');?>", {selectFirst: true});
	});
</script>


<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result_wip');?>" method="POST"  >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
		<fieldset style="border: 1px solid #8cacbb;">
		<legend><b>Printing WIP Report search</b></legend>
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">
						 
						<tr>
								<td class="label" >From Date <span style="color:red;">*</span>  :</td>
								<td><input type="date" name="from_date" id="from_date" value="<?php echo set_value('from_date',date('Y-m-d'));?>"/></td>
								<td class="label" >To Date <span style="color:red;">*</span>  :</td>
								<td><input type="date" name="to_date" id="to_date" value="<?php echo set_value('to_date',date('Y-m-d'));?>"/></td>
						</tr>
						 
					</table>			
								
				</td>
				<td width="50%">
					
				</td>
											
			</tr> 
			<tr><td colspan="2">
				<div class="ui buttons">
					  <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
					  <div class="or"></div>
					  <button class="ui positive button" id="btnsubmit" >Search</button>
					<!-- <input type="submit" class="ui positive button" value="Save"/>-->
				</div>
				
			</td></tr>
		</table>
		</fieldset>	

</div>
		
</form>
				
				
				
				
				
			