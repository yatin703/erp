<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();


		

		$(".supplier").autocomplete("<?php echo base_url('index.php/ajax/supplier');?>", {selectFirst: true});
		$("#customer").autocomplete("<?php echo base_url('index.php/ajax/customer');?>", {selectFirst: true});

		$("#main_group").change(function(event) {
   var main_group = $('#main_group').val();
   $("#loading").show();
		$("#cover").show();
		$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/main_group_article",data: {main_group : $('#main_group').val()},cache: false,success: function(html){
    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
       $("#article_no").html(html);
    } 
    });
   });

		$("#cap_type").change(function(event) {
   var cap_type = $('#cap_type').val();
   $("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			if($("#cap_type option:selected" ).val()!=''){
				$("#article_name").html($("#cap_type option:selected").text());
			}else{
				$("#article_name").html('');
			}
			
    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/spec_cap_finish",data: {cap_type:$('#cap_type').val()},cache: false,success: function(html){
    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
       $("#cap_finish").html(html);
    } 
    });
   });

				$("#cap_finish").change(function(event) {
   var cap_type = $('#cap_type').val();
   var cap_finish = $('#cap_finish').val();
   $("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			if($("#cap_type option:selected" ).val()!='' && $("#cap_finish option:selected" ).val()!=''){
				$("#article_name").html($("#cap_type option:selected").text()+" "+$("#cap_finish option:selected").text());
			}else{
				$("#article_name").html('');
			}
    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/spec_cap_dia",data: {cap_type:$('#cap_type').val(),cap_finish:$('#cap_finish').val()},cache: false,success: function(html){
    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
       $("#cap_dia").html(html);
    } 
    });
   });

   $("#cap_dia").change(function(event) {
   var cap_type = $('#cap_type').val();
   var cap_finish = $('#cap_finish').val();
   var cap_dia = $('#cap_dia').val();
   $("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			if($("#cap_type option:selected" ).val()!='' && $("#cap_finish option:selected" ).val()!='' && $("#cap_dia option:selected" ).val()!=''){
			$("#article_name").html($("#cap_type option:selected").text()+" "+$( "#cap_finish option:selected").text()+" "+$("#cap_dia option:selected" ).text());
			}else{
				$("#article_name").html('');
			}
    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/spec_cap_orifice",data: {cap_type:$('#cap_type').val(),cap_finish:$('#cap_finish').val(),cap_dia:$('#cap_dia').val()},cache: false,success: function(html){
    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
       $("#cap_orifice").html(html);

    } 
    });
   });

   $("#cap_orifice").change(function(event) {
   
   if($("#cap_type option:selected").val()!='' && $("#cap_finish option:selected" ).val()!='' && $("#cap_dia option:selected").val()!='' && $("#cap_orifice option:selected").val()!=''){
   		$("#article_name").html($("#cap_type option:selected" ).text()+" "+$( "#cap_finish option:selected").text()+" "+$( "#cap_dia option:selected" ).text()+" "+$("#cap_orifice option:selected").text());
				}else{
					$("#article_name").html('');
				}

   });

   $("#cap_masterbatch").change(function(event) {
   	if($("#cap_type option:selected" ).val()!='' && $("#cap_finish option:selected" ).val()!='' && $("#cap_dia option:selected" ).val()!='' && $("#cap_masterbatch option:selected").val()!=''){
   		 var a=$("#cap_type option:selected").text()+" "+$("#cap_finish option:selected").text()+" "+$("#cap_dia option:selected").text();

   		 if($("#cap_orifice option:selected").val()!=''){ var cap_ori=$("#cap_orifice option:selected").text();}else{var cap_ori="";}

   		 $("#article_name").html(a+" "+cap_ori+" "+$("#cap_masterbatch option:selected").text());
					}else{
					$("#article_name").html('');
				}

   });

		$("#cap_mb_per").live('keyup',function() {

   	if($("#cap_type option:selected" ).val()!='' && $("#cap_finish option:selected" ).val()!='' && $("#cap_dia option:selected" ).val()!='' && $("#cap_masterbatch option:selected").val()!=''){
   		 var a=$("#cap_type option:selected").text()+" "+$("#cap_finish option:selected").text()+" "+$("#cap_dia option:selected").text();

   		 if($("#cap_orifice option:selected").val()!=''){ var cap_ori=$("#cap_orifice option:selected").text();}else{var cap_ori="";}

   		 if($("#cap_mb_per").val()!=''){ var cap_mb_per=$("#cap_mb_per").val()+"%";}else{var cap_mb_per="";}
   		 
   		 $("#article_name").html(a+" "+cap_ori+" "+$("#cap_masterbatch option:selected").text()+" "+cap_mb_per);

					}else{
					$("#article_name").html('');
				}
    
			});

				

	});
</script>
<script type="text/javascript">
    $(document).ready(function(){
    $('#specific').change(function(){
    if($(this).is(":checked"))
    $('#hi').fadeIn('slow');
    else
    $('#hi').fadeOut('slow');
  		});
    });
</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save_cap');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">

								<tr>
										<td class="label">Main Group * :</td>
										<td><select name="main_group" id="main_group"><option value=''>--Select Main Group--</option>
										<?php if($main_group==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($main_group as $main_group_row){
													echo "<option value='".$main_group_row->main_group_id."'  ".set_select('main_group',''.$main_group_row->main_group_id.'').">".strtoupper($main_group_row->lang_main_group_desc)."-".$main_group_row->main_group_id."</option>";
												}
										}?>
										</select></td>
									</tr>

										<tr>
										<td class="label">Article No * :</td>
										<td><select name="article_no" id="article_no" >
										<?php if($this->input->post('article_no')){
											echo '<option value="'.$this->input->post('article_no').'">'.$this->input->post('article_no').'</option>';
										}else{
											echo '<option value="">--Select Article Code--</option>';
										}?>
														
										</select></td>
									</tr>
									<!--
									<tr>
										<td class="label">Customer Specific * :</td>
										<td><input type="checkbox" name="specific" id="specific" value="1" <?php echo set_checkbox('specific', '1'); ?>> Yes
									</tr>

									<tr id="hi" style="<?php if($this->input->post('specific')==1){}else { echo "display:none;"; } ?>">
										<td class="label">Customer <span style="color:red;">*</span> :</td>
										<td><input type="text" name="customer" id="customer" size="60" value="<?php echo set_value('customer');?>" /></td>
									</tr>-->

									<tr>
										<td class="label">Article Name * :</td>
										<td><span id="article_name" style="color:green;font-weight: bold">
											<?php
												if(!empty($this->input->post('cap_type'))){
                $cap_typee=explode('//',$this->input->post('cap_type'));
              }else{
                $cap_typee[0]='';
              }

              if(!empty($this->input->post('cap_finish'))){
                $cap_finishh=explode('//',$this->input->post('cap_finish'));
              }else{
                $cap_finishh[0]='';
              }

              if(!empty($this->input->post('cap_dia'))){
                $cap_diaa=explode('//',$this->input->post('cap_dia'));
              }else{
                $cap_diaa[0]='';
              }

              if(!empty($this->input->post('cap_orifice'))){
                $cap_orificee=explode('//',$this->input->post('cap_orifice'));
              }else{
                $cap_orificee[0]='';
              }

              if(!empty($this->input->post('cap_masterbatch'))){
                $cap_masterbatchh=explode('//',$this->input->post('cap_masterbatch'));
              }else{
                $cap_masterbatchh[1]='';
              }

              if(!empty($this->input->post('cap_mb_per'))){
              		$cap_mb_per=$this->input->post('cap_mb_per')."%";
              }else{
              		$cap_mb_per='';
              }

              echo $article_description=$cap_typee[0]." ".$cap_finishh[0]." ".$cap_diaa[0]." ".$cap_orificee[0]." ".$cap_masterbatchh[1]." ".$cap_mb_per;

											?>


										</span></td>
									</tr>

									<tr>
										<td class="label">Cap Type <span style="color:red;">*</span> :</td>
										<td><select name="cap_type" id="cap_type"><option value=''>--Select Cap Type--</option>
										<?php if($cap_type==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($cap_type as $cap_type_row){
													echo "<option value='".$cap_type_row->cap_type."//".$cap_type_row->cap_type_id."'  ".set_select('cap_type',''.$cap_type_row->cap_type.'//'.$cap_type_row->cap_type_id.'').">".$cap_type_row->cap_type."</option>";
												}
										}?>
										</select></td></tr>

										<tr>
											<td class="label">Cap Finish <span style="color:red;">*</span> :</td>
											<td><select name="cap_finish" id="cap_finish"><option value=''>--Select Cap Finish--</option>
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
											<td><select name="cap_dia" id="cap_dia"><option value=''>--Select Cap Dia--</option>
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
											<td><select name="cap_orifice" id="cap_orifice">
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
										<td><select name="cap_masterbatch" id="cap_masterbatch">
										<option value=''>--Select MB--</option>
										<?php
										foreach ($masterbatch as $masterbatch_row) {
											echo "<option value='".$masterbatch_row->article_no."//".$masterbatch_row->lang_article_description."' ".set_select('cap_masterbatch',$masterbatch_row->article_no."//".$masterbatch_row->lang_article_description).">".$masterbatch_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="text" name="cap_mb_per" maxlength="3" size="3" id="cap_mb_per" value="<?php echo set_value('cap_mb_per');?>" placeholder="%">
										<input type="text" name="cap_mb_supplier" class="supplier" size="60" value="<?php echo set_value('cap_mb_supplier');?>" placeholder="MB Supplier">
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
										<td>
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
											<td class="label">Cap Foil Width <span style="color:red;">*</span> :</td>
											<td><input type="text" name="cap_foil_width" value="<?php echo set_value('cap_foil_width');?>"></td>
										</tr>

										<tr>
											<td class="label">Cap Foil Dist From Bottom <span style="color:red;">*</span> :</td>
											<td><input type="text" name="cap_foil_dist_frm_bottom" value="<?php echo set_value('cap_foil_dist_frm_bottom');?>"></td>
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
				
				
				
				
				
			