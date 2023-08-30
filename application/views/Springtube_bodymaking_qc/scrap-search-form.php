<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();

		$("#order_no").autocomplete("<?php echo base_url('index.php/ajax/so_no');?>", {selectFirst: true});
		$("#article_no").autocomplete("<?php echo base_url('index.php/ajax_springtube/article_no_springtube');?>", {selectFirst: true});

		$("#jobcard_no").autocomplete("<?php echo base_url('index.php/ajax_springtube/jobcard_bodymaking_autocomplete');?>", {selectFirst: true});

		$("#film_code").autocomplete("<?php echo base_url('index.php/ajax_springtube/film_autocomplete');?>", {selectFirst: true});
	});
</script>


<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/scrap_search_result');?>" method="POST"  >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">
						
						<tr><td class="label" colspan="5"><b>Scrap Search</b></td></tr>
						<tr><td class="label" >&nbsp;</td><td class="label" >&nbsp;</td><td class="label" >&nbsp;</td><td class="label" >&nbsp;</td></tr>
						<tr>
							<td class="label">From Date <span style="color:red;">*</span>  :</td>
							<td><input type="date" name="from_date" id="from_date" size="30" value="<?php echo set_value('from_date',date('Y-m-d'));?>" ></td>
							<td class="label">To Date <span style="color:red;">*</span>  :</td>
							<td><input type="date" name="to_date" id="to_date" size="30" value="<?php echo set_value('to_date',date('Y-m-d'));?>" ></td>
						</tr>
						<tr>
							<td class="label">SO No :</td>
							<td><input type="text" name="order_no" id="order_no"  value="<?php echo set_value('order_no');?>" maxlength="20" size="20"/></td>
							<td class="label">Jobcard No. :</td>
							<td><input type="text" name="jobcard_no" id="jobcard_no"  value="<?php echo set_value('jobcard_no');?>" maxlength="20" size="20"/></td>
						</tr>

					</table>			
								
				</td>
				<td width="50%">
					<table>
						
						<tr>
							<td class="label">SPSM/SPSP :</td>
							<td colspan="3"><input type="text" name="article_no" id="article_no"  value="<?php echo set_value('article_no');?>" maxlength="200" size="60"/></td>
							
						</tr>
						<tr>
							<td class="label">Film Code :</td>
							<td colspan="3"><input type="text" name="film_code" id="film_code"  value="<?php echo set_value('film_code');?>" maxlength="500" size="60"/></td>
							
						</tr>
						

					</table>
				</td>
											
			</tr>
		</table>

		<div class="middle_form_design">	
</div>
<div class="middle_form_design">

		<div class="ui buttons">
		  <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
		  <div class="or"></div>
		  <button class="ui positive button" id="btnsubmit" >Scrap Search</button>
		<!-- <input type="submit" class="ui positive button" value="Save"/>-->
		</div>
	

</div>
		
</form>
				
				
				
				
				
			