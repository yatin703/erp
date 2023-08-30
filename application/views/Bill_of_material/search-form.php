<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		$("#bom_no").autocomplete("<?php echo base_url('index.php/ajax/bom_no_autocomplete');?>", {selectFirst: true});
		$("#article_no").autocomplete("<?php echo base_url('index.php/ajax/article_no');?>", {selectFirst: true});
		$("#sleeve_code").autocomplete("<?php echo base_url('index.php/ajax/approved_sleeve_autocomplete');?>", {selectFirst: true});
		$("#paper_film_code").autocomplete("<?php echo base_url('index.php/ajax/approved_paper_film_autocomplete');?>", {selectFirst: true});
		$("#shoulder_code").autocomplete("<?php echo base_url('index.php/ajax/approved_shoulder_autocomplete');?>", {selectFirst: true});
		$("#cap_code").autocomplete("<?php echo base_url('index.php/ajax/approved_cap_autocomplete');?>", {selectFirst: true});
		$("#label_code").autocomplete("<?php echo base_url('index.php/ajax/approved_label_autocomplete');?>", {selectFirst: true});
		$("#sleeve_master_batch").autocomplete("<?php echo base_url('index.php/ajax/raw_material_article_no');?>", {selectFirst: true});


	});
</script>

<script>
	function validate_form(){

		var x=document.getElementById("form1");
		var flag=0;
		for(i=0;i<x.length;i++){
			
			if(x.elements[i].value!='' && x.elements[i].name!='' &&  x.elements[i].name!='from_date' && x.elements[i].name!='to_date'){
				flag=1;								
			}
			if(document.getElementById('from_date').value!='' && document.getElementById('to_date').value!=''){
				flag=1;	
			}
		}

		if(flag==1){
			return true;
		}else{
			alert('From Date And To Date Should not be Blank.');

			if(document.getElementById('from_date').value==''){
				document.getElementById('from_date').focus();
				return false;
			}
			else{
				document.getElementById('to_date').focus();
				return false;
			}
			    
		}		
					
		
	}

</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result');?>" id="form1" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">

									<tr>
										<td class="label" width="25%">From Date :</td>
										<td width="25%"><input type="date" name="from_date" id="from_date" value="<?php echo set_value('from_date');?>"/></td>
										<td class="label" width="25%">To Date :</td>
										<td width="25%"><input type="date" name="to_date" id="to_date" value="<?php echo set_value('to_date');?>"/></td>
									</tr>

									<tr>
										<td class="label" width="25%">BOM No. :</td>
										<td width="25%"><input type="text" name="bom_no" id="bom_no"  size="17" value="<?php echo set_value('bom_no');?>"/></td>
										<td class="label" width="25%">BOM Version No. :</td>
										<td width="25%"><input type="number" name="bom_version_no" id="bom_version_no"  value="<?php echo set_value('bom_version_no');?>" min="1" max="50" step="1" style="width: 146px;" /></td>
									</tr>

									<tr>
										<td class="label"><b>PSM/PSP NO</b>  :</td>
										<td colspan="3"><input type="text" name="article_no" id="article_no" size="60" value="<?php echo set_value('article_no');?>" /></td>
									</tr>
								
									<tr><td class="label"><b>&nbsp;</b></td><td class="label" colspan="3"><b>+</b></td></tr>

									<tr>
											<td class="label"><b>Tube/Film Code </b></td>
											<td colspan="3"><input type="text" name="sleeve_code" id="sleeve_code" size="60" value="<?php echo set_value('sleeve_code');?>" /></td>
									</tr>

									<tr><td class="label"><b>&nbsp;</b></td><td class="label" colspan="3"><b>+</b></td></tr>



									<tr>
										<td class="label"><b>Paper Film Code </b></td>
											<td colspan="3"><input type="text" name="sleeve_code" id="paper_film_code" size="60" value="<?php echo set_value('sleeve_code');?>" /></td>
									</tr>

									<tr><td class="label"><b>&nbsp;</b></td><td class="label" colspan="3"><b>+</b></td></tr>

									<tr>
											<td class="label"><b>Shoulder Code </b></td>
											<td colspan="3"><input type="text" name="shoulder_code" id="shoulder_code" size="60" value="<?php echo set_value('shoulder_code');?>" /></td>
									</tr>
									<tr><td class="label"><b>&nbsp;</b></td><td class="label" colspan="3"><b>+</b></td></tr>

									<tr>
											<td class="label"><b>Label Code</b></td>
											<td colspan="3"><input type="text" name="label_code" id="label_code" size="60" value="<?php echo set_value('label_code');?>" /></td>
									</tr>

									<tr><td class="label"><b>&nbsp;</b></td><td class="label" colspan="3"><b>+</b></td></tr>

									<tr>
											<td class="label"><b>Cap Code </b></td>
											<td colspan="3"><input type="text" name="cap_code" id="cap_code" size="60" value="<?php echo set_value('cap_code');?>" /></td>
									</tr>

									<tr><td class="label"><b>&nbsp;</b></td><td class="label" colspan="3"></td></tr>
									
									<tr>
										<td class="label"> Approval Status :</td>
										<td colspan="3">
											<select name="final_approval_flag" id="final_approval_flag" >
												<option value="">--Please Select--</option>
												<option value="1" <?php echo set_select('final_approval_flag','1'); ?> >Approved</option>
												<option value="0" <?php echo set_select('final_approval_flag','0'); ?>>Not Approved</option>
											</select>

										</td>
									</tr>
									<tr>
										<td class="label"><b>Box Type </b></td>
										<td colspan="3"><select name="for_export" id="for_export" >
											<option value="">--Please Select--</option>
											<option value="1" <?php echo set_select('for_export','1'); ?> >EXPORT</option>
											<option value="0" <?php echo set_select('for_export','0'); ?>>DOMESTIC</option>
										</select></td>
									</tr>
									<tr>
										<td class="label"><b>BOM Type </b></td>
										<td colspan="3"><select name="bom_type" id="bom_type" >
											<option value="">--Please Select--</option>
											<option value="1" <?php echo set_select('bom_type','1'); ?> >SPRING</option>
											<option value="0" <?php echo set_select('bom_type','0'); ?>>COEX</option>
										</select></td>
									</tr>
								
								
									</table>
							</td>

							<td width="50%">
								<table class="form_table_inner">
									<tr>
										<td class="label">Print Type  :</td>
										<td><select name="print_type"><option value=''>--Select Print Type--</option>
										<?php if($print_type==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($print_type as $print_type_row){
													echo "<option value='".$print_type_row->lacquer_type."'  ".set_select('print_type',''.$print_type_row->lacquer_type.'').">".$print_type_row->lacquer_type."</option>";
												}
										}?>
										</select></td>
									</tr>									
									<tr>
										<td class="label">Sleeve Diameter   :</td>
										<td><select name="sleeve_dia" id="sleeve_dia">
											<option value=''>--Please Select--</option>
										<?php if($sleeve_diameter_master==FALSE){
														echo "<option value=''>--Sleeve Dia Setup Required--</option>";}
											else{
												foreach($sleeve_diameter_master as $row){
													
													echo '<option value="'.$row->sleeve_diameter.'"'.set_select('sleeve_dia',''.$row->sleeve_diameter.'').' >'.$row->sleeve_diameter.'</option>';
												}
										}?>
										</select></td>
									</tr>
									<tr>
										<td class="label">Sleeve Length  :</td>
										<td><input type="number" name="sleeve_length" value="<?php echo set_value('sleeve_length');?>" style="width:133px;" min="50" max="500" step="any"></td>
									</tr>
									<tr>
										<td class="label">Sleeve Layer  :</td>
										<td><select name="layer_no" id="layer_no">
											<option value='' <?php echo set_select('layer_no',' '); ?> >--Please Select--</option>
											<option value='1' <?php echo set_select('layer_no','1'); ?> >1</option>
											<option value='2' <?php echo set_select('layer_no','2'); ?> >2</option>
											<option value='3' <?php echo set_select('layer_no','3'); ?>>3</option>
											<option value='4' <?php echo set_select('layer_no','4'); ?>>4</option>
											<option value='5' <?php echo set_select('layer_no','5'); ?>>5</option>
											<option value='7' <?php echo set_select('layer_no','7'); ?>>7</option>
										</select>
										</td>
									</tr>

									<tr>
										<td class="label">Sleeve Master Batch  :</td>
										<td><select name="sleeve_layer_no" id="sleeve_layer_no">
											<option value='' <?php echo set_select('sleeve_layer_no',' '); ?> >--Layer Position--</option>
											<option value='1' <?php echo set_select('sleeve_layer_no','1'); ?> >1</option>
											<option value='2' <?php echo set_select('sleeve_layer_no','2'); ?> >2</option>
											<option value='3' <?php echo set_select('sleeve_layer_no','3'); ?>>3</option>
											<option value='4' <?php echo set_select('sleeve_layer_no','4'); ?>>4</option>
											<option value='5' <?php echo set_select('sleeve_layer_no','5'); ?>>5</option>
											<option value='6' <?php echo set_select('sleeve_layer_no','6'); ?>>6</option>
										</select>
										<input type="text" name="sleeve_master_batch" id="sleeve_master_batch" value="<?php echo set_value('sleeve_master_batch');?>" size="40">
										</td>
									</tr>

									<tr>	
										<td class="label">Shoulder Type  :</td>
										<td><select name="shoulder_type" id="shoulder_type">
											<option value=''>--Please Select--</option>
										<?php if($shoulder_types_master==FALSE){
													echo "<option value=''>--Shoulder Type Setup Required--</option>";}
											else{
												foreach($shoulder_types_master as $row){
													
													echo '<option value="'.$row->shoulder_type.'"'.set_select('shoulder_type',''.$row->shoulder_type.'').' >'.$row->shoulder_type.'</option>';
												}
										}?>
										</select></td>
									</tr>
									<tr>	
										<td class="label">Shoulder Orifice  :</td>
										<td><select name="shoulder_orifice" id="shoulder_orifice">
											<option value=''>--Please Select--</option>
										<?php if($shoulder_orifice_master==FALSE){
													echo "<option value=''>--Shoulder Orifice Setup Required--</option>";}
											else{
												foreach($shoulder_orifice_master as $row){
													
													echo '<option value="'.$row->shoulder_orifice.'"'.set_select('shoulder_orifice',''.$row->shoulder_orifice.'').' >'.$row->shoulder_orifice.'</option>';
												}
										}?>
										</select></td>
									</tr>

									<tr>
										<td class="label">Cap Diameter   :</td>
										<td><select name="cap_dia" id="cap_dia">
											<option value=''>--Please Select--</option>
										<?php if($cap_diameter_master==FALSE){
														echo "<option value=''>--Cap Dia Setup Required--</option>";}
											else{
												foreach($cap_diameter_master as $row){
													
													echo '<option value="'.$row->cap_dia.'"'.set_select('cap_dia',''.$row->cap_dia.'').' >'.$row->cap_dia.'</option>';
												}
										}?>
										</select></td>
									</tr>
									<tr>	
										<td class="label">Cap Type  :</td>
										<td><select name="cap_type" id="cap_type">
											<option value=''>--Please Select--</option>
										<?php if($cap_types_master==FALSE){
													echo "<option value=''>--Cap Type Setup Required--</option>";}
											else{
												foreach($cap_types_master as $row){
													
													echo '<option value="'.$row->cap_type.'"'.set_select('cap_type',''.$row->cap_type.'').' >'.$row->cap_type.'</option>';
												}
										}?>
										</select></td>
									</tr>
									
									<tr>	
										<td class="label">Cap Orifice  :</td>
										<td><select name="cap_orifice" id="cap_orifice">
											<option value=''>--Please Select--</option>
										<?php if($cap_orifice_master==FALSE){
													echo "<option value=''>--Cap Orifice Setup Required--</option>";}
											else{
												foreach($cap_orifice_master as $row){
													
													echo '<option value="'.$row->cap_orifice.'"'.set_select('cap_orifice',''.$row->cap_orifice.'').' >'.$row->cap_orifice.'</option>';
												}
										}?>
										</select></td>
									</tr>
									<tr>	
										<td class="label">Cap Finish  :</td>
										<td><select name="cap_finish" id="cap_finish">
											<option value=''>--Please Select--</option>
										<?php if($cap_finish_master==FALSE){
													echo "<option value=''>--Cap Finish Setup Required--</option>";}
											else{
												foreach($cap_finish_master as $row){
													
													echo '<option value="'.$row->cap_finish.'"'.set_select('cap_finish',''.$row->cap_finish.'').' >'.$row->cap_finish.'</option>';
												}
										}?>
										</select></td>
									</tr>
									<tr>
										<td class="label">Created By :</td>
										<td colspan="3"><select name="user_id" id="user_id">
											<option value=''>--Select User--</option>
											<?php 
											foreach ($user_master as $user_master_row) {
							             echo "<option value='".$user_master_row->user_id."' ".set_select('user_id',$user_master_row->user_id).">".strtoupper($user_master_row->login_name)."</option>";
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
	  <button class="ui positive button" onClick="return validate_form();">Search</button>
		</div>
	</div>
		
</form>

				
				
				
				
				
			