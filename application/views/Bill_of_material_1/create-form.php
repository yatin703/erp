<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		$("#article_no").autocomplete("<?php echo base_url('index.php/ajax/article_no');?>", {selectFirst: true});
		$("#sleeve_code").autocomplete("<?php echo base_url('index.php/ajax/approved_sleeve_autocomplete');?>", {selectFirst: true});
		$("#shoulder_code").autocomplete("<?php echo base_url('index.php/ajax/approved_shoulder_autocomplete');?>", {selectFirst: true});
		$("#cap_code").autocomplete("<?php echo base_url('index.php/ajax/approved_cap_autocomplete');?>", {selectFirst: true});
		$("#label_code").autocomplete("<?php echo base_url('index.php/ajax/approved_label_autocomplete');?>", {selectFirst: true});


	});
</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">

									<tr>
										<td class="label"><b>Product No</b>  <span style="color:red;">*</span> :</td>
										<td><input type="text" name="article_no" id="article_no" size="60" value="<?php echo set_value('article_no');?>" /></td>
									</tr>
								
									<tr><td class="label"><b>&nbsp;</b></td><td class="label"><b>+</b></td></tr>

									<tr>
											<td class="label"><b>Tube Code <span style="color:red;">*</span></b></td>
											<td><input type="text" name="sleeve_code" id="sleeve_code" size="60" value="<?php echo set_value('sleeve_code');?>" /></td>
									</tr>

									<tr><td class="label"><b>&nbsp;</b></td><td class="label"><b>+</b></td></tr>

									<tr>
											<td class="label"><b>Shoulder Code <span style="color:red;">*</span></b></td>
											<td><input type="text" name="shoulder_code" id="shoulder_code" size="60" value="<?php echo set_value('shoulder_code');?>" /></td>
									</tr>
									<tr><td class="label"><b>&nbsp;</b></td><td class="label"><b>+</b></td></tr>

									<tr>
											<td class="label"><b>Label Code</b></td>
											<td><input type="text" name="label_code" id="label_code" size="60" value="<?php echo set_value('label_code');?>" /></td>
									</tr>
									<tr><td class="label"><b>&nbsp;</b></td><td class="label"><b>+</b></td></tr>

									<tr>
											<td class="label"><b>Cap Code <span style="color:red;">*</span></b></td>
											<td><input type="text" name="cap_code" id="cap_code" size="60" value="<?php echo set_value('cap_code');?>" /></td>
									</tr>

									<tr><td class="label"><b>&nbsp;</b></td><td class="label"><b></b></td></tr>

									<tr>
										<td class="label"><b>Packing Type</b> :</td>
										<td><select name="for_export">
											<option value=''>--Select Packing Type--</option>
											<option value="0" <?php echo set_select('for_export','0');?>>LOCAL</option>
											<option value="1" <?php echo set_select('for_export','1');?>>EXPORT</option>
								          </select>
								      </td>
								    </tr>

								    <tr><td class="label"><b>&nbsp;</b></td><td class="label"><b></b></td></tr>

									<tr>
										<td class="label"><b>Approval Authority</b> :</td>
										<td><select name="approval_authority">
											<option value=''>--Select Authority--</option>
											<?php 
											foreach ($approval_authority as $approval_authority_row) {
								            echo "<option value='".$approval_authority_row->employee_id."' ".set_select('approval_authority',$approval_authority_row->employee_id).">".strtoupper($approval_authority_row->username)."</option>";
								            }
								             ?>
								          </select></td>
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
	  <button class="ui positive button">Save</button>
		</div>
	</div>
		
</form>

				
				
				
				
				
			