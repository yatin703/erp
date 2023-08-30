<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		$("#customer").autocomplete("<?php echo base_url('index.php/ajax/customer');?>", {selectFirst: true});
		$("#article_no").autocomplete("<?php echo base_url('index.php/ajax/article_no');?>", {selectFirst: true});

		$("#cap_article_no").autocomplete("<?php echo base_url('index.php/ajax/cap_article_no');?>", {selectFirst: true});
		$("#cap_spec_no").autocomplete("<?php echo base_url('index.php/ajax/cap_spec_no');?>", {selectFirst: true});

		$("#cap_spec_no").live('keyup',function() {
   var cap_spec_no = $('#cap_spec_no').val();
   $("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
   $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/cap_spec_version_no",data: {cap_spec_no : $('#cap_spec_no').val()},cache: false,success: function(html){
    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
       $("#cap_spec_version_no").html(html);
    } 
    });
   });

		$("#cap_spec_version_no").change(function(event) {
   var cap_spec_no = $('#cap_spec_no').val();
   var cap_spec_version_no = $('#cap_spec_version_no').val();
   $("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/cap_spec_details",data: {cap_spec_no : $('#cap_spec_no').val(),cap_spec_version_no : $('#cap_spec_version_no').val()},cache: false,success: function(html){
    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
       $("#cap_spec_details").html(html);
    } 
    });
   });

		$("#cap_article_no").live('change',function() {
   var cap_article_no = $('#cap_article_no').val();
   var arr = cap_article_no.split('//');
   
   $("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
   $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/cap_spec_details",data: {cap_spec_no : arr[2],cap_spec_version_no : arr[3]},cache: false,success: function(html){
    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
       $("#cap_spec_details").html(html);
    } 
    });
   });

		$("#cap_article_no").live('keyup',function() {
   var cap_article_no = $('#cap_article_no').val();
   var arr = cap_article_no.split('//');
   
   $("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
   $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/cap_spec_details",data: {cap_spec_no : arr[2],cap_spec_version_no : arr[3]},cache: false,success: function(html){
    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
       $("#cap_spec_details").html(html);
    } 
    });
   });

		$("#article_no").live('keyup',function() {
   var article_no = $('#article_no').val();
   $("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
   $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/spec_version_no",data: {article_no : $('#article_no').val()},cache: false,success: function(html){
    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
       $("#spec_version_no").html(html);
    } 
    });
   });

		$("#article_no").live('keyup',function() {
   var article_no = $('#article_no').val();
   $("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
   $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/artwork_final_version_no",data: {article_no : $('#article_no').val()},cache: false,success: function(html){
    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
       $("#artwork_final_version_no").html(html);
    } 
    });
   });

		$(".supplier").autocomplete("<?php echo base_url('index.php/ajax/supplier');?>", {selectFirst: true});

		$("#sleeve_dia").change(function(event) {
   var sleeve_dia = $('#sleeve_dia').val();
   $("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/shoulder",data: {sleeve_dia : $('#sleeve_dia').val()},cache: false,success: function(html){
    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
       $("#shoulder").html(html);
    } 
    });
   });

		$("#shoulder").change(function(event) {
   var sleeve_dia = $('#sleeve_dia').val();
   var shoulder = $('#shoulder').val();
   $("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/shoulder_orifice",data: {sleeve_dia : $('#sleeve_dia').val(),shoulder : $('#shoulder').val()},cache: false,success: function(html){
    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
       $("#shoulder_orifice").html(html);
    } 
    });
   });

		$("#shoulder").change(function(event) {
   var sleeve_dia = $('#sleeve_dia').val();
   var shoulder = $('#shoulder').val();
   var shoulder_orifice = $('#shoulder_orifice').val();
   $("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/cap_type",data: {sleeve_dia : $('#sleeve_dia').val(),shoulder : $('#shoulder').val(),shoulder_orifice :$('#shoulder_orifice').val()},cache: false,success: function(html){
    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
       $("#cap_type").html(html);
    } 
    });
   });

		$("#cap_type").change(function(event) {
   var sleeve_dia = $('#sleeve_dia').val();
   var shoulder = $('#shoulder').val();
   var shoulder_orifice = $('#shoulder_orifice').val();
   var cap_type = $('#cap_type').val();
   $("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/cap_finish",data: {sleeve_dia : $('#sleeve_dia').val(),shoulder : $('#shoulder').val(),shoulder_orifice :$('#shoulder_orifice').val(),cap_type:$('#cap_type').val()},cache: false,success: function(html){
    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
       $("#cap_finish").html(html);
    } 
    });
   });

			$("#cap_finish").change(function(event) {
   var sleeve_dia = $('#sleeve_dia').val();
   var shoulder = $('#shoulder').val();
   var shoulder_orifice = $('#shoulder_orifice').val();
   var cap_type = $('#cap_type').val();
   var cap_finish = $('#cap_finish').val();
   $("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/cap_dia",data: {sleeve_dia : $('#sleeve_dia').val(),shoulder : $('#shoulder').val(),shoulder_orifice :$('#shoulder_orifice').val(),cap_type:$('#cap_type').val(),cap_finish:$('#cap_finish').val()},cache: false,success: function(html){
    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
       $("#cap_dia").html(html);
    } 
    });
   });

   $("#cap_dia").change(function(event) {
   var sleeve_dia = $('#sleeve_dia').val();
   var shoulder = $('#shoulder').val();
   var shoulder_orifice = $('#shoulder_orifice').val();
   var cap_type = $('#cap_type').val();
   var cap_finish = $('#cap_finish').val();
   var cap_dia = $('#cap_dia').val();
   $("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/cap_orifice",data: {sleeve_dia : $('#sleeve_dia').val(),shoulder : $('#shoulder').val(),shoulder_orifice :$('#shoulder_orifice').val(),cap_type:$('#cap_type').val(),cap_finish:$('#cap_finish').val(),cap_dia:$('#cap_dia').val()},cache: false,success: function(html){
    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
       $("#cap_orifice").html(html);
    } 
    });
   });


	});
</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save_five_layer_with_cap');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">
									<tr>
										<td class="label">Customer <span style="color:red;">*</span> :</td>
										<td><input type="text" name="customer" id="customer" size="60" value="<?php echo set_value('customer');?>" /></td>
									</tr>

									<tr>
										<td class="label">Article  <span style="color:red;">*</span> :</td>
										<td><input type="text" name="article_no" id="article_no" size="60" value="<?php echo set_value('article_no');?>" /></td>
									</tr>

									<tr>
										<td class="label">Version No <span style="color:red;">*</span> :</td>
										<td><select id="spec_version_no" name="spec_version_no">
										<?php if($this->input->post('spec_version_no')){
												echo "<option value='".$this->input->post('spec_version_no')."'>".$this->input->post('spec_version_no')."</option>";
										}else{
											echo "<option value=''>--Spec Version No--</option>";
											}?></select></td>
									</tr>

									<tr>
										<td class="label">Artwork <span style="color:red;">*</span> :</td>
										<td><select id="artwork_final_version_no" name="artwork_final_version_no">
										<?php if($this->input->post('artwork_final_version_no')){
											echo "<option value='".$this->input->post('artwork_final_version_no')."'>".$this->input->post('artwork_final_version_no')."</option>";
											}else{
												echo "<option value=''>--Artwork --</option>";
												}?>
											
										</select></td>
									</tr>

									<tr>
										<td class="label">Comment  :</td>
										<td><textarea name="comment" value="<?php echo set_value('comment');?>" cols="57"><?php echo set_value('comment');?></textarea> </td>
									</tr>

									<tr><td class="label"><b>&nbsp;</b></td><td class="label"><b>&nbsp;</b></td></tr>
								

									<tr><td class="label"><b>Tube Information</b></td></tr>

									<tr>
										<td class="label">Dia <span style="color:red;">*</span> :</td>
										<td><select name="sleeve_dia" id="sleeve_dia"><option value=''>--Select Sleeve Dia--</option>
										<?php if($sleeve_dia==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($sleeve_dia as $sleeve_dia_row){
													echo "<option value='".$sleeve_dia_row->sleeve_diameter."//".$sleeve_dia_row->sleeve_id."'  ".set_select('sleeve_dia',''.$sleeve_dia_row->sleeve_diameter.'//'.$sleeve_dia_row->sleeve_id.'').">".$sleeve_dia_row->sleeve_diameter."</option>";
												}
										}?></select></td>
									</tr>

									<tr>
											<td class="label">Length <span style="color:red;">*</span> : </td>
											<td><input type="text" name="sleeve_length" size="10" value="<?php echo set_value('sleeve_length');?>"></td>
										</tr>

									

									<tr>
										<td class="label">Print Type <span style="color:red;">*</span> :</td>
										<td><select name="print_type"><option value=''>--Select Print Type--</option>
										<?php if($print_type==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($print_type as $print_type_row){
													echo "<option value='".$print_type_row->lacquer_type."'  ".set_select('print_type',''.$print_type_row->lacquer_type.'').">".$print_type_row->lacquer_type."</option>";
												}
										}?></select></td>
									</tr>

									<tr><td class="label"><b>&nbsp;</b></td><td class="label"><b>&nbsp;</b></td></tr>

									<tr><td class="label"><b>Layer 1</b></td></tr>

									<tr>
										<td class="label">Gauge <span style="color:red;">*</span> :</td>
										<td><input type="text" name="gauge_one" maxlength="3" size="3" value="<?php echo set_value('gauge_one');?>"></td>
									</tr>

									<tr>
										<td class="label">MB <span style="color:red;">*</span> :</td>
										<td><select name="sl_masterbatch_one"><option value=''>--Select MB--</option>
										<?php foreach ($masterbatch as $masterbatch_row) {
											echo "<option value='".$masterbatch_row->article_no."' ".set_select('sl_masterbatch_one',$masterbatch_row->article_no).">".$masterbatch_row->lang_article_description."</option>";
										}?></select></td>

										<td>
										<input type="text" name="sl_mb_per_one" maxlength="3" size="3" value="<?php echo set_value('sl_mb_per_one');?>" placeholder="%">
										<input type="text" name="sl_mb_supplier_one" class="supplier" size="60"  value="<?php echo set_value('sl_mb_supplier_one');?>" placeholder="MB Supplier">
										</td>
										</tr>

										<tr>
										<td class="label">LDPE <span style="color:red;">*</span> :</td>
										<td><select name="sl_ldpe_one">
										<option value=''>--Select LDPE--</option>
										<?php
										foreach ($ldpe as $ldpe_row) {
											echo "<option value='".$ldpe_row->article_no."' ".set_select('sl_ldpe_one',$ldpe_row->article_no).">".$ldpe_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="text" name="sl_ldpe_per_one" maxlength="3" size="3" value="<?php echo set_value('sl_ldpe_per_one');?>" placeholder="%"></td>
										</tr>

										<tr>
										<td class="label">LLDPE <span style="color:red;">*</span> :</td>
										<td><select name="sl_lldpe_one">
										<option value=''>--Select LLDPE--</option>
										<?php
										foreach ($lldpe as $lldpe_row) {
											echo "<option value='".$lldpe_row->article_no."' ".set_select('sl_lldpe_one',$lldpe_row->article_no).">".$lldpe_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="text" name="sl_lldpe_per_one" maxlength="3" size="3" value="<?php echo set_value('sl_lldpe_per_one');?>" placeholder="%"></td>
										</tr>

										<tr>
										<td class="label">HDPE  :</td>
										<td><select name="sl_hdpe_one">
										<option value=''>--Select HDPE--</option>
										<?php
										foreach ($hdpe as $hdpe_row) {
											echo "<option value='".$hdpe_row->article_no."' ".set_select('sl_hdpe_one',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="text" name="sl_hdpe_per_one" maxlength="3" size="3" value="<?php echo set_value('sl_hdpe_per_one');?>" placeholder="%"></td>
										</tr>

									<tr><td class="label"><b>&nbsp;</b></td><td class="label"><b>&nbsp;</b></td></tr>

									<tr><td class="label"><b>Layer 2</b></td></tr>
										<tr>
											<td class="label">Gauge <span style="color:red;">*</span> :</td>
											<td><input type="text" name="gauge_two" maxlength="3" size="3" value="<?php echo set_value('gauge_two');?>"></td>
										</tr>

										<tr>
										<td class="label">Admer  :</td>
										<td><select name="sl_admer_two">
										<option value=''>--Select Admer--</option>
										<?php
										foreach ($admer as $admer_row) {
											echo "<option value='".$admer_row->article_no."' ".set_select('sl_admer_two',$admer_row->article_no).">".$admer_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="text" name="sl_admer_per_two" maxlength="3" size="3" value="<?php echo set_value('sl_admer_per_two');?>" placeholder="%"></td>
										</tr>

										<tr><td class="label"><b>&nbsp;</b></td><td class="label"><b>&nbsp;</b></td></tr>

										<tr><td class="label"><b>Layer 3</b></td></tr>
										<tr>
											<td class="label">Gauge <span style="color:red;">*</span> :</td>
											<td><input type="text" name="gauge_three" maxlength="3" size="3" value="<?php echo set_value('gauge_three');?>"></td>
										</tr>

										<tr>
										<td class="label">Evoh  :</td>
										<td><select name="sl_evoh_three">
										<option value=''>--Select Evoh--</option>
										<?php
										foreach ($evoh as $evoh_row) {
											echo "<option value='".$evoh_row->article_no."' ".set_select('sl_evoh_three',$evoh_row->article_no).">".$evoh_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="text" name="sl_evoh_per_three" maxlength="3" size="3" value="<?php echo set_value('sl_evoh_per_three');?>" placeholder="%"></td>
										</tr>

										<tr><td class="label"><b>&nbsp;</b></td><td class="label"><b>&nbsp;</b></td></tr>

										<tr><td class="label"><b>Layer 4</b></td></tr>
										<tr>
											<td class="label">Gauge <span style="color:red;">*</span> :</td>
											<td><input type="text" name="gauge_four" maxlength="3" size="3" value="<?php echo set_value('gauge_four');?>"></td>
										</tr>

										<tr>
										<td class="label">Admer  :</td>
										<td><select name="sl_admer_four">
										<option value=''>--Select Admer--</option>
										<?php
										foreach ($admer as $admer_row) {
											echo "<option value='".$admer_row->article_no."' ".set_select('sl_admer_four',$admer_row->article_no).">".$admer_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="text" name="sl_admer_per_four" maxlength="3" size="3" value="<?php echo set_value('sl_admer_per_four');?>" placeholder="%"></td>
										</tr>

									<tr><td class="label"><b>&nbsp;</b></td><td class="label"><b>&nbsp;</b></td></tr>

									<tr><td class="label"><b>Layer 5</b></td></tr>

										<tr>
											<td class="label">Gauge <span style="color:red;">*</span> :</td>
											<td><input type="text" name="gauge_five" maxlength="3" size="3" value="<?php echo set_value('gauge_five');?>"></td>
										</tr>

									<tr>
										<td class="label">MB <span style="color:red;">*</span> :</td>
										<td><select name="sl_masterbatch_five"><option value=''>--Select MB--</option>
										<?php foreach ($masterbatch as $masterbatch_row) {
											echo "<option value='".$masterbatch_row->article_no."' ".set_select('sl_masterbatch_five',$masterbatch_row->article_no).">".$masterbatch_row->lang_article_description."</option>";
										}?></select></td>

										<td>
										<input type="text" name="sl_mb_per_five" maxlength="3" size="3" value="<?php echo set_value('sl_mb_per_five');?>" placeholder="%">
										<input type="text" name="sl_mb_supplier_five" class="supplier" size="60"  value="<?php echo set_value('sl_mb_supplier_five');?>" placeholder="MB Supplier">
										</td>
										</tr>

										<tr>
										<td class="label">LDPE <span style="color:red;">*</span> :</td>
										<td><select name="sl_ldpe_five">
										<option value=''>--Select LDPE--</option>
										<?php
										foreach ($ldpe as $ldpe_row) {
											echo "<option value='".$ldpe_row->article_no."' ".set_select('sl_ldpe_five',$ldpe_row->article_no).">".$ldpe_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="text" name="sl_ldpe_per_five" maxlength="3" size="3" value="<?php echo set_value('sl_ldpe_per_five');?>" placeholder="%"></td>
										</tr>

										<tr>
										<td class="label">LLDPE <span style="color:red;">*</span> :</td>
										<td><select name="sl_lldpe_five">
										<option value=''>--Select LLDPE--</option>
										<?php
										foreach ($lldpe as $lldpe_row) {
											echo "<option value='".$lldpe_row->article_no."' ".set_select('sl_lldpe_five',$lldpe_row->article_no).">".$lldpe_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="text" name="sl_lldpe_per_five" maxlength="3" size="3" value="<?php echo set_value('sl_lldpe_per_five');?>" placeholder="%"></td>
										</tr>

										<tr>
										<td class="label">HDPE  :</td>
										<td><select name="sl_hdpe_five">
										<option value=''>--Select HDPE--</option>
										<?php
										foreach ($hdpe as $hdpe_row) {
											echo "<option value='".$hdpe_row->article_no."' ".set_select('sl_hdpe_five',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="text" name="sl_hdpe_per_five" maxlength="3" size="3" value="<?php echo set_value('sl_hdpe_per_five');?>" placeholder="%"></td>
										</tr>

									<tr><td class="label"><b>&nbsp;</b></td><td class="label"><b>&nbsp;</b></td></tr>

									<tr><td class="label"><b>Shoulder Information</b></td></tr>

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
											<td class="label">Shoulder Foil Tag  : </td>
											<td><input type="text" name="shoulder_foil_tag" size="10" value="<?php echo set_value('shoulder_foil_tag');?>"></td>
										</tr>

									<tr>
										<td class="label">MB <span style="color:red;">*</span> :</td>
										<td><select name="sh_masterbatch">
										<option value=''>--Select MB--</option>
										<?php
										foreach ($masterbatch as $masterbatch_row) {
											echo "<option value='".$masterbatch_row->article_no."' ".set_select('sh_masterbatch',$masterbatch_row->article_no).">".$masterbatch_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
											<input type="text" name="sh_mb_per" maxlength="3" size="3" value="<?php echo set_value('sh_mb_per');?>" placeholder="%">
											<input type="text" name="sh_mb_supplier" class="supplier" value="<?php echo set_value('sh_mb_supplier');?>" placeholder="MB Supplier">
										</td>
									</tr>

										<tr>
										<td class="label">HDPE <span style="color:red;">*</span> :</td>
										<td><select name="sh_hdpe_one">
										<option value=''>--Select HDPE--</option>
										<?php
										foreach ($hdpe as $hdpe_row) {
											echo "<option value='".$hdpe_row->article_no."' ".set_select('sh_hdpe_one',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td><input type="text" name="sh_hdpe_one_per" maxlength="3" size="3" value="<?php echo set_value('sh_hdpe_one_per');?>" placeholder="%"></td>
										</tr>

										<tr>
										<td class="label">HDPE <span style="color:red;">*</span> :</td>
										<td><select name="sh_hdpe_two">
										<option value=''>--Select HDPE--</option>
										<?php
										foreach ($hdpe as $hdpe_row) {
											echo "<option value='".$hdpe_row->article_no."' ".set_select('sh_hdpe_two',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="text" name="sh_hdpe_two_per" maxlength="3" size="3" value="<?php echo set_value('sh_hdpe_two_per');?>" placeholder="%"></td>
										</tr>

									<tr><td class="label"><b>&nbsp;</b></td><td class="label"><b>&nbsp;</b></td></tr>

									<tr>
										<td></td>
										<td class="label"><b>+</b></td>
									</tr>

									<tr>
										<td class="label"><b>Attach Cap</b></td>
									</tr>

									<tr>
										<td class="label">Cap Spec No <span style="color:red;">*</span> :</td>
										<td><input type="text" name="cap_spec_no" id="cap_spec_no" size="10" value="<?php echo set_value('cap_spec_no');?>" />&nbsp;&nbsp;&nbsp;Version No &nbsp;<span style="color:red;">*</span> : <select id="cap_spec_version_no" name="cap_spec_version_no">
										<?php
										if($this->input->post('cap_spec_version_no')){
											echo '<option value="'.$this->input->post('cap_spec_version_no').'">'.$this->input->post('cap_spec_version_no').'</option>';
										}else{
											echo '<option value="">--Version No--</option>';
										}
										?>
										</select>
										</td>
									</tr>


									<tr>
										<td class="label"><b></b></td>
										<td>OR</td>
									</tr>

									<tr>
										<td class="label">Cap Name  <span style="color:red;">*</span> :</td>
										<td><input type="text" name="cap_article_no" id="cap_article_no" size="60" value="<?php echo set_value('cap_article_no');?>" /></td>
									</tr>

									<tr>
											<td></td>
											<td id="cap_spec_details"></td>
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
				
				
				
				
				
			