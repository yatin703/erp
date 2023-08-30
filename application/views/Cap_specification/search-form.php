<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	function getWords(string){
    return string.split(/\s+/).slice(0,3).join(" ");
}


	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();

    $("#article_no").autocomplete("<?php echo base_url('index.php/ajax/article_no');?>", {selectFirst: true});
		$(".supplier").autocomplete("<?php echo base_url('index.php/ajax/supplier');?>", {selectFirst: true});
		//$("#customer").autocomplete("<?php echo base_url('index.php/ajax/customer');?>", {selectFirst: true});
	
		$("#cap_metalization").live('click',function() {
   if ($(this).is(":checked")) {
    $("#metalization_div").show();
   } else {
   	$("#metalization_div").hide();
   	$("#cap_metalization_color").val("");
   }
  });


				

	});
</script>



<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result');?>" id="form1" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner" id="form_table_inner">

					<?php foreach ($account_periods_master as $account_periods_master_row ):?> 
					<tr>
	                    <td class="label" >From Date <span style="color:red;">*</span>  :</td>
	                    <td><input type="date" name="from_date" id="from_date" value="<?php echo set_value('from_date');?>"/></td>
	                    <td class="label" >To Date <span style="color:red;">*</span>  :</td>
	                    <td><input type="date" name="to_date" id="to_date" value="<?php echo set_value('to_date');?>"/></td>
                    </tr>
                  <?php endforeach;?>
                  <tr>
								<tr>
										<td class="label">Article :</td>
										<td colspan="3"><input type="text" name="article_no" id="article_no"  size="62" value="<?php echo set_value('article_no');?>" /></td>
								</tr>
								<tr>
									<td class="label">Cap Type <span style="color:red;">*</span> :</td>
									<td colspan="3"><select name="cap_type" id="cap_type"><option value=''>--Select Cap Type--</option>
									<?php if($cap_type==FALSE){
													echo "<option value=''>--Setup Required--</option>";}
										else{
											foreach($cap_type as $cap_type_row){
												echo "<option value='".$cap_type_row->cap_type."//".$cap_type_row->cap_type_id."'  ".set_select('cap_type',''.$cap_type_row->cap_type.'//'.$cap_type_row->cap_type_id.'').">".$cap_type_row->cap_type."</option>";
											}
									}?>
									</select></td>
								</tr>

								<tr>
									<td class="label">Cap Finish <span style="color:red;">*</span> :</td>
									<td colspan="3"><select name="cap_finish" id="cap_finish"><option value=''>--Select Cap Finish--</option>
										<?php if($cap_finish==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($cap_finish as $cap_finish_row){
													echo "<option value='".$cap_finish_row->cap_finish."//".$cap_finish_row->cap_finish_id."'  ".set_select('cap_finish',''.$cap_finish_row->cap_finish.'//'.$cap_finish_row->cap_finish_id.'').">".$cap_finish_row->cap_finish."</option>";
												}
										}?>
									</select></td>
								</tr>

								<tr>
									<td class="label">Cap Dia <span style="color:red;">*</span> :</td>
									<td colspan="3"><select name="cap_dia" id="cap_dia"><option value=''>--Select Cap Dia--</option>
									<?php if($cap_dia==FALSE){
													echo "<option value=''>--Setup Required--</option>";}
										else{
											foreach($cap_dia as $cap_dia_row){
												echo "<option value='".$cap_dia_row->cap_dia."//".$cap_dia_row->cap_dia_id."'  ".set_select('cap_dia',''.$cap_dia_row->cap_dia.'//'.$cap_dia_row->cap_dia_id.'').">".$cap_dia_row->cap_dia."</option>";
											}
									}?></select></td>
								</tr>

								<tr>
										<td class="label">Cap Orifice :</td>
										<td colspan="3"><select name="cap_orifice" id="cap_orifice">
										<option value=''>--Select Cap Orifice--</option>
									<?php if($cap_orifice==FALSE){
													echo "<option value=''>--Setup Required--</option>";}
										else{
											foreach($cap_orifice as $cap_orifice_row){
												echo "<option value='".$cap_orifice_row->cap_orifice."//".$cap_orifice_row->cap_orifice_id."'  ".set_select('cap_orifice',''.$cap_orifice_row->cap_orifice.'//'.$cap_orifice_row->cap_orifice_id.'').">".$cap_orifice_row->cap_orifice."</option>";
											}
									}?></select></td>
								</tr>
								<tr>
									<td class="label">MB <span style="color:red;">*</span> :</td>
									<td ><select name="cap_masterbatch" id="cap_masterbatch">
									<option value=''>--Select MB--</option>
									<?php
									foreach ($masterbatch as $masterbatch_row) {
										echo "<option value='".$masterbatch_row->article_no."//".$masterbatch_row->lang_article_description."' ".set_select('cap_masterbatch',$masterbatch_row->article_no."//".$masterbatch_row->lang_article_description).">".$masterbatch_row->lang_article_description."</option>";
									}
									?>
									</select></td>
									<td colspan="2">
									<input type="text" name="cap_mb_per" maxlength="3" size="3" id="cap_mb_per" value="<?php echo set_value('cap_mb_per');?>" placeholder="%">
									<input type="text" name="cap_mb_supplier" class="supplier" size="25" value="<?php echo set_value('cap_mb_supplier');?>" placeholder="MB Supplier">
									</td>
								</tr>

								<tr>
										<td class="label">PP <span style="color:red;">*</span> :</td>
										<td><select name="cap_pp">
										<option value=''>--Select PP--</option>
										<?php
										foreach ($pp as $pp_row) {
											echo "<option value='".$pp_row->article_no."' ".set_select('cap_pp',$pp_row->article_no).">".$pp_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td colspan="2">
										<input type="text" name="pp_per" maxlength="3" size="3" value="<?php echo set_value('pp_per');?>" placeholder="%"></td>
								</tr>

								<tr>
										<td class="label">Cap Shrink Sleeve :</td>
										<td><select name="cap_shrink_sleeve" id="cap_shrink_sleeve">
										<option value=''>--Select Shrink Sleeve--</option>
										<?php
										foreach ($cap_shrink_sleeve as $cap_shrink_sleeve_row) {
											echo "<option value='".$cap_shrink_sleeve_row->article_no."//".$cap_shrink_sleeve_row->lang_article_description."' ".set_select('cap_shrink_sleeve',$cap_shrink_sleeve_row->article_no."//".$cap_shrink_sleeve_row->lang_article_description).">".$cap_shrink_sleeve_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<?php
						                    if($this->input->post('cap_metalization') &&  $this->input->post('cap_metalization')==1){

						                      echo '<tr>
						                      <td class="label">Cap Metalization :</td>
						                      <td><input type="checkbox" name="cap_metalization" id="cap_metalization" value="1" '.set_checkbox('cap_metalization',1).' /></td>
						                    </tr>

						                    <tr id="metalization_div">
						                      <td></td><td>
						                    Metalization Color:<input type="text" name="cap_metalization_color" maxlength="10" size="10" id="cap_metalization_color" value="'.set_value('cap_metalization_color').'">

						                    <br/>

						                    Metalization Finish:<select name="cap_metalization_finish" id="cap_metalization_finish">
						                      <option value="">--Select--</option>
						                      <option value="GLOSS" "'.set_select('cap_metalization_finish', 'GLOSS').'">GLOSS</option>
						                      <option value="MATT" "'.set_select('cap_metalization_finish', 'MATT').'">MATT</option>
						                    </select>
						                  </td>
						                  </tr>';
						                    }else{?>
							<tr>
											<td class="label">Cap Metalization :</td>
											<td><input type="checkbox" name="cap_metalization" id="cap_metalization" value="1" <?php echo set_checkbox('cap_metalization',1);?> /></td>
							</tr>

							<tr id="metalization_div" style="display: none">
											<td></td><td>
										Metalization Color:<input type="text" name="cap_metalization_color" maxlength="10" size="10" id="cap_metalization_color" value="<?php echo set_value('cap_metalization_color');?>">

										<br/>

										Metalization Finish:<select name="cap_metalization_finish" id="cap_metalization_finish">
											<option value="">--Select--</option>
											<option value='GLOSS' <?php echo  set_select('cap_metalization_finish', 'GLOSS'); ?>>GLOSS</option>
											<option value='MATT' <?php echo  set_select('cap_metalization_finish', 'MATT'); ?>>MATT</option>
										</select>
									</td>
							</tr>


                    <?php }
                    ?>

										<tr>
										<td class="label">Cap Foil :</td>
										<td><select name="cap_foil_color" id="cap_foil">
										<option value=''>--Select Foil--</option>
										<?php
										foreach ($cap_foil as $cap_foil_row) {
											echo "<option value='".$cap_foil_row->article_no."//".$cap_foil_row->lang_article_description."' ".set_select('cap_foil_color',$cap_foil_row->article_no."//".$cap_foil_row->lang_article_description).">".$cap_foil_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>


										<tr>
											<td class="label">Cap Foil Width :</td>
											<td><input type="text" name="cap_foil_width" size="3" maxlength="3" value="<?php echo set_value('cap_foil_width');?>"></td>
										</tr>

										<tr>
											<td class="label">Cap Foil Dist From Bottom :</td>
											<td><input type="text" name="cap_foil_dist_frm_bottom" size="3" maxlength="3" value="<?php echo set_value('cap_foil_dist_frm_bottom');?>"></td>
										</tr>
					                    <tr>
						                    <td class="label">Approval Status :</td>
						                    <td colspan="3"><select name="final_approval_flag">
						                      <option value="">--Please Select--</option>
						                      <option value="1" <?php echo set_select('final_approval_flag','1');?>>Approved</option>
						                      <option value="0" <?php echo set_select('final_approval_flag','0');?>>Not Approved</option>
						                    </select></td>
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
	  <button class="ui positive button"  >Search</button>
		</div>
	</div>
		
</form>
				
				
				
				
				
			