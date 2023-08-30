<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		$("#jobcard_no").autocomplete("<?php echo base_url('index.php/ajax_springtube/jobcard_extrusion_autocomplete');?>", {selectFirst: true});	
				
		
		if($("#release_to").val()==2){
			
			$("#tr_scrap_reason").show();

		}else{

			$("#tr_scrap_reason").hide();
		}

		$("#release_meters").blur(function(){
			
			if($("#release_meters").val()!='' || $("#release_meters").val()!='0'){


				
				if(parseInt($("#release_meters").val()) > parseInt($("#total_qc_hold_meters").val())){

					alert('Release meter must be less than or equal to Total hold meters');
					$("#release_meters").val('');
					$("#release_meters").focus();
				}
				
			}
		});

		$("#release_to").change(function(){

			if($("#release_to").val()==2){
				$("#tr_scrap_reason").show();

			}else{

				$("#tr_scrap_reason").hide();
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

						<?php foreach($springtube_extrusion_qc_master as $row):?>

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
							<td class="label">Total hold Meters  :</td>
							<td ><input type="text" name="total_qc_hold_meters" id="total_qc_hold_meters"  size="20" value="<?php echo set_value('total_qc_hold_meters',$row->total_qc_hold_meters);?>" readonly/></td>
						</tr>
						<tr>
							<td class="label">Release Meters  :</td>
							<td ><input type="text" name="release_meters" id="release_meters"  size="20" maxlength="10" value="<?php echo set_value('release_meters');?>" required/></td>
						</tr>
						<tr>
							<td class="label" >Release To:</td>
							<td><select name="release_to" id="release_to">					
								<option value="">--Please select--</option>
								<option value="1" <?php echo set_select('release_to','1');?> >SPRING EXTRUSION WIP</option>
								<option value="2" <?php echo set_select('release_to','2');?> >SPRING EXTRUSION QC SCRAP</option>
																
							</select>
							</td>
						</tr>
						<tr id="tr_scrap_reason">
							<td class="label">Reel Scrap Reasons :</td>
							<td>
								<?php if($springtube_extrusion_reel_scrap_reasons==TRUE){
											
									foreach($springtube_extrusion_reel_scrap_reasons as $springtube_extrusion_reel_scrap_reasons_row){
										if(!empty($this->input->post('scrap_reasons[]'))){

											echo'<input type="checkbox" name="scrap_reasons[]" value="'.$springtube_extrusion_reel_scrap_reasons_row->scrap_reason.'" '.(in_array($springtube_extrusion_reel_scrap_reasons_row->scrap_reason, $this->input->post('scrap_reasons[]'))?"checked":"").' >&nbsp;'.$springtube_extrusion_reel_scrap_reasons_row->scrap_reason.'<br/>';
										}else{
										echo'<input type="checkbox" name="scrap_reasons[]" value="'.$springtube_extrusion_reel_scrap_reasons_row->scrap_reason.'" >&nbsp;'.$springtube_extrusion_reel_scrap_reasons_row->scrap_reason.'<br/>';
										}
									}
							}?>
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




				
				
				
			