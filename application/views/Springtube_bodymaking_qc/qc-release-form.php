<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		$("#jobcard_no").autocomplete("<?php echo base_url('index.php/ajax_springtube/jobcard_bodymaking_autocomplete');?>", {selectFirst: true});	
				
		$("#release_meters").blur(function(){
			
			if($("#release_qty").val()!='' || $("#release_qty").val()!='0'){
				
				if(parseInt($("#release_qty").val()) > parseInt($("#qc_hold_qty").val())){

					alert('Release Qty must be less than or equal to Hold Qty');
					$("#release_qty").val('');
					$("#release_qty").focus();
				}
				
			}
		});

	});//Jquery closed

</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/qc_release_save');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">

						<?php foreach($springtube_bodymaking_qc_master as $row):?>

						<tr>
							<td class="label">Qc Date <span style="color:red;">*</span> :</td>
							<td><input type="hidden" name="qc_id" value="<?php echo set_value('qc_id',$row->qc_id);?>">
								<input type="date" name="qc_date"   value="<?php echo set_value('qc_date',$row->qc_date);?>" readonly /></td>
							
						</tr>
						<tr>
							<td class="label">Jobcard No.  :</td>
							<td ><input type="text" name="jobcard_no" id="jobcard_no"  size="20" value="<?php echo set_value('jobcard_no',$row->jobcard_no);?>" readonly/></td>
						</tr>
						<tr>
							<td class="label"> Qc hold Qty  :</td>
							<td ><input type="number" name="qc_hold_qty" id="qc_hold_qty"  size="20" value="<?php echo set_value('qc_hold_qty',$row->qc_hold_qty);?>" min="1" max="80000" maxlength="10" readonly/></td>
						</tr>
						<tr>
							<td class="label">Release Qty  :</td>
							<td ><input type="number" name="release_qty" id="release_qty"  size="20" min="1" max="80000" maxlength="10" value="<?php echo set_value('release_qty');?>" required/></td>
						</tr>
						<tr>
							<td class="label" >Release To:</td>
							<td>
								<select name="release_to">					
								<option value="">--Please select--</option>
								<option value="1" <?php echo set_select('release_to','1');?> >SPRING BODYMAKING RFD</option>
								<option value="2" <?php echo set_select('release_to','2');?> >SPRING BODYMAKING SCRAP</option>
																
								</select>
							</td>
						</tr>
						<tr>
							<td class="label">Qc Remarks :</td>
							<td>
								<textarea name="qc_remarks" id="qc_remarks" cols="40" rows="3" value="<?php echo trim(set_value('qc_remarks'));?>" maxlength="256">
								<?php echo trim(set_value('qc_remarks'));?>	
								</textarea>
							</td>
						</tr>

				<?php endforeach;?>		
						

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




				
				
				
			