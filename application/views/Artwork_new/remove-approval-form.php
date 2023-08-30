<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		
			

	});
</script>
<?php foreach($artwork as $artwork_row):?>
	
<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save_remove_approval');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">

									<tr>
										<td class="label">Artwork No * :</td>
										<td><input type="text" name="artwork_no" size="10" value="<?php echo set_value('artwork_no',$artwork_row->ad_id);?>" readonly/></td>
									</tr>
									<tr>
										<td class="label">Version No * :</td>
										<td><select id="version_no" name="version_no" readonly>
											<option value="<?php echo $artwork_row->version_no;?>"><?php echo $artwork_row->version_no;?></option>
										</select></td>
									</tr>
									<tr>
										<td class="label">Final Approval Flag :</td>
										<td><input type="text" name="final_approval_flag" id="final_approval_flag"   value="<?php echo set_value('final_approval_flag',$artwork_row->final_approval_flag);?>" required/></td>
									</tr>
									<tr>
										<td class="label">Pending Flag  * :</td>
										<td><input type="text" name="pending_flag" id="pending_flag"   value="<?php echo set_value('pending_flag',$artwork_row->pending_flag);?>" required /></td>
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
	  <button class="ui positive button" onClick="return confirm('Are you sure to update record');">Update</button>
		</div>
	</div>
		
</form>

<?php endforeach;?>
				
				
				
				
				
			