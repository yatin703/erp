<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		$("#article_no").autocomplete("<?php echo base_url('index.php/ajax/shoulder_autocomplete');?>", {selectFirst: true});
		$(".supplier").autocomplete("<?php echo base_url('index.php/ajax/supplier');?>", {selectFirst: true});

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


<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result');?>" method="POST" id="form1" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">
								<?php foreach ($account_periods_master as $account_periods_master_row ):?> 
									<tr>
										<td class="label" >From Date <span style="color:red;">*</span>  :</td>
										<td><input type="date" name="from_date" id="from_date" value="<?php echo set_value('from_date','2019-04-01');?>"/></td>
										<td class="label" >To Date <span style="color:red;">*</span>  :</td>
										<td><input type="date" name="to_date" id="to_date" value="<?php echo set_value('to_date',date('Y-m-d'));?>"/></td>
									</tr>
								<?php endforeach;?>
									<tr>
									<tr>
										<td class="label">Article  :</td>
										<td colspan="3"><input type="text" name="article_no" id="article_no" size="63" value="<?php echo set_value('article_no');?>" /></td>
									</tr>
									<tr>
										<td class="label">Dia <span style="color:red;">*</span> :</td>
										<td><select name="sleeve_dia" id="sleeve_dia"><option value=''>--Select Dia--</option>
										<?php if($sleeve_dia==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($sleeve_dia as $sleeve_dia_row){
													echo "<option value='".$sleeve_dia_row->sleeve_diameter."//".$sleeve_dia_row->sleeve_id."'  ".set_select('sleeve_dia',''.$sleeve_dia_row->sleeve_diameter.'//'.$sleeve_dia_row->sleeve_id.'').">".$sleeve_dia_row->sleeve_diameter."</option>";
												}
										}?></select></td>
									</tr>

										<tr>
										<td class="label">Shoulder <span style="color:red;">*</span> :</td>
										<td><select name="shoulder" id="shoulder"><option value=''>--Select Shoulder--</option>
										<?php if($shoulder_types==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($shoulder_types as $shoulder_types_row){
													echo "<option value='".$shoulder_types_row->shoulder_type."//".$shoulder_types_row->shld_type_id."'  ".set_select('shoulder',''.$shoulder_types_row->shoulder_type.'//'.$shoulder_types_row->shld_type_id.'').">".$shoulder_types_row->shoulder_type."</option>";
												}
										}?>
										</select></td>
									</tr>


									<tr>
											<td class="label">Shoulder Orifice  :</td>
											<td><select name="shoulder_orifice" id="shoulder_orifice"><option value=''>--Select Shoulder Orifice--</option>
											<?php if($shoulder_orifice==FALSE){
															echo "<option value=''>--Setup Required--</option>";}
												else{
													foreach($shoulder_orifice as $shoulder_orifice_row){
														echo "<option value='".$shoulder_orifice_row->shoulder_orifice."//".$shoulder_orifice_row->orifice_id."'  ".set_select('shoulder_orifice',''.$shoulder_orifice_row->shoulder_orifice.'//'.$shoulder_orifice_row->orifice_id.'').">".$shoulder_orifice_row->shoulder_orifice."</option>";
													}
											}?></select></td>
									</tr>


									<tr>
										<td class="label">Top Sealed Foil <span style="color:red;">*</span> :</td>
										<td><select name="shoulder_foil_tag" id="shoulder_foil_tag">
										<option value=''>--Select Foil--</option>
										<?php
										foreach ($hot_foil as $hot_foil_row) {
											echo "<option value='".$hot_foil_row->article_no."' ".set_select('shoulder_foil_tag',$hot_foil_row->article_no).">".$hot_foil_row->lang_article_description."</option>";
										}
										?>
										</select></td>
									</tr>


									<tr>
										<td class="label">MB <span style="color:red;">*</span> :</td>
										<td><select name="sh_masterbatch" id="sh_masterbatch">
										<option value=''>--Select MB--</option>
										<?php
										foreach ($masterbatch as $masterbatch_row) {
											echo "<option value='".$masterbatch_row->article_no."' ".set_select('sh_masterbatch',$masterbatch_row->article_no).">".$masterbatch_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td colspan="2">
										<input type="text" name="sh_mb_per" id="sh_mb_per" maxlength="3" size="3" value="<?php echo set_value('sh_mb_per');?>" placeholder="%">
										<input type="text" name="sh_mb_supplier" class="supplier" size="20" value="<?php echo set_value('sh_mb_supplier');?>" placeholder="MB Supplier">
										</td>
									</tr>

									<tr>
										<td class="label">HDPE <span style="color:red;">*</span> :</td>
										<td><select name="sh_hdpe_one" id="sh_hdpe_one">
										<option value=''>--Select HDPE--</option>
										<?php
										foreach ($hdpe as $hdpe_row) {
											echo "<option value='".$hdpe_row->article_no."' ".set_select('sh_hdpe_one',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td><input type="text" name="sh_hdpe_one_per" id="sh_hdpe_one_per" maxlength="3" size="3" value="<?php echo set_value('sh_hdpe_one_per');?>" placeholder="%"></td>
										</tr>

										<tr>
										<td class="label">HDPE <span style="color:red;">*</span> :</td>
										<td><select name="sh_hdpe_two" id="sh_hdpe_two">
										<option value=''>--Select HDPE--</option>
										<?php
										foreach ($hdpe as $hdpe_row) {
											echo "<option value='".$hdpe_row->article_no."' ".set_select('sh_hdpe_two',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="text" name="sh_hdpe_two_per" id="sh_hdpe_two_per" maxlength="3" size="3" value="<?php echo set_value('sh_hdpe_two_per');?>" placeholder="%"></td>
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

									<tr>
										<td class="label">Created by  :</td>
										<td><select name="user_id" id="user_id">
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
	  <button class="ui positive button" onClick="return validate_form();" >Search</button>
		</div>
	</div>
		
</form>
				
				
				
				
				
			