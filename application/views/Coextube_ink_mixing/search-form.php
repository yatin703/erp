<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script type="text/javascript">
	$(document).ready(function(){

		$("#loading").hide(); $("#cover").hide();
		 
		$("#pantone_code").autocomplete("<?php echo base_url('index.php/ajax_coextube/coextube_ink_for_jobsetup_autocomplete');?>", {selectFirst: true});
	});
</script>
<style type="text/css">
	.middle_form_design {
    width: 100%;
    min-height: 0px;}
    .record_form_design {
    width: 100%;}
</style>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result');?>" method="POST"  >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">

						<tr>
							<td class="label">From Date <span style="color:red;">*</span>  :</td>
							<td><input type="date" name="from_date" id="from_date" size="30" value="<?php echo set_value('from_date');?>" ></td>
							<td class="label">To Date <span style="color:red;">*</span>  :</td>
							<td><input type="date" name="to_date" id="to_date" size="30" value="<?php echo set_value('to_date');?>" ></td>
						</tr>
						<tr>
							<td class="label">Pantone Code* :</td>
							<td colspan="3"><input type="text" name="pantone_code" id="pantone_code"  size="60" value="<?php echo set_value('pantone_code');?>" placeholder="Pantone Code"/></td>
							 
						</tr>
						 
											
					</table>	
				</td>							
			</tr>
		</table>

		<!-- <div class="middle_form_design">
			
		
</div> -->
<div class="middle_form_design">

	
		<div class="ui buttons">
		  <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
		  <div class="or"></div>
		  <button class="ui positive button" id="btnsubmit" >Search</button>
		<!-- <input type="submit" class="ui positive button" value="Save"/>-->
		</div>
	

</div>
		
</form>
				
				
				
				
				
			