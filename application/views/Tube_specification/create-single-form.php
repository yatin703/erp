<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		$("#customer").autocomplete("<?php echo base_url('index.php/ajax/customer');?>", {selectFirst: true});
		$("#article_no").autocomplete("<?php echo base_url('index.php/ajax/article_no');?>", {selectFirst: true});

		$("#cap_article_no").autocomplete("<?php echo base_url('index.php/ajax/cap_article_no');?>", {selectFirst: true});
		$("#label").autocomplete("<?php echo base_url('index.php/ajax/label');?>", {selectFirst: true});
		$("#cap_spec_no").autocomplete("<?php echo base_url('index.php/ajax/cap_spec_no');?>", {selectFirst: true});

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


		$(".supplier").autocomplete("<?php echo base_url('index.php/ajax/supplier');?>", {selectFirst: true});


		$("#sleeve_dia").change(function(event) {
   var sleeve_dia = $('#sleeve_dia').val();
   $("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			if($("#sleeve_dia option:selected" ).val()!=''){
				$("#article_name").html($("#sleeve_dia option:selected").text());
				$("#loading").hide();$("#cover").hide();
			}else{
				$("#article_name").html('');
			}
   });

				$("#sleeve_length").live('keyup',function() {
   var sleeve_dia = $('#sleeve_dia').val();
   var sleeve_length = $('#sleeve_length').val();
   $("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			if($("#sleeve_dia option:selected" ).val()!='' && $("#sleeve_length" ).val()!=''){
				$("#article_name").html($("#sleeve_dia option:selected").text()+" "+$("#sleeve_length").val());
				$("#loading").hide();$("#cover").hide();
			}else{
				$("#article_name").html('');
				
			}
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

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save_single_layer_with_cap');?>" method="POST" >
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
										<td class="label">Sleeve No * :</td>
										<td><select name="article_no" id="article_no" >
										<?php if($this->input->post('article_no')){
											echo '<option value="'.$this->input->post('article_no').'">'.$this->input->post('article_no').'</option>';
										}else{
											echo '<option value="">--Select Article Code--</option>';
										}?>
														
										</select></td>
									</tr>

									<tr>
										<td class="label">Sleeve Structure Name * :</td>
										<td><span id="article_name" style="color:green;font-weight: bold">
											<?php
												if(!empty($this->input->post('sleeve_dia'))){
                $sleeve_diaa=explode('//',$this->input->post('sleeve_dia'));
              }else{
                $sleeve_diaa[0]='';
              }

              if(!empty($this->input->post('sleeve_length'))){
                $sleeve_lengthh=explode('//',$this->input->post('sleeve_length'));
              }else{
                $sleeve_lengthh[0]='';
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

              echo $article_description=$sleeve_diaa[0]." ".$sleeve_lengthh[0]." ".$cap_diaa[0]." ".$cap_orificee[0]." ".$cap_masterbatchh[1]." ".$cap_mb_per;

											?>

									<tr>
										<td class="label">Dia <span style="color:red;">*</span> :</td>
										<td><select name="sleeve_dia" id="sleeve_dia"><option value=''>--Select Dia--</option>
										<?php if($sleeve_dia==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($sleeve_dia as $sleeve_dia_row){
													echo "<option value='".$sleeve_dia_row->sleeve_diameter."//".$sleeve_dia_row->sleeve_id."'  ".set_select('sleeve_dia',''.$sleeve_dia_row->sleeve_diameter.'//'.$sleeve_dia_row->sleeve_id.'').">".$sleeve_dia_row->sleeve_diameter."</option>";
												}
										}?></select>&nbsp;Length <span style="color:red;">*</span> : <input type="text" name="sleeve_length" id="sleeve_length" size="10" value="<?php echo set_value('sleeve_length');?>"></td>
									</tr>

									<tr>
										<td class="label">Gauge <span style="color:red;">*</span> :</td>
										<td><input type="text" name="gauge" id="gauge" maxlength="3" size="3" value="<?php echo set_value('gauge');?>"></td>
									</tr>

										<tr>
										<td class="label">LDPE <span style="color:red;">*</span> :</td>
										<td><select name="sl_ldpe" id="sl_ldpe">
										<option value=''>--Select LDPE--</option>
										<?php
										foreach ($ldpe as $ldpe_row) {
											echo "<option value='".$ldpe_row->article_no."' ".set_select('sl_ldpe',$ldpe_row->article_no).">".$ldpe_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="text" name="sl_ldpe_per" id="sl_ldpe_per" maxlength="3" size="3" value="<?php echo set_value('sl_ldpe_per');?>" placeholder="%"></td>
										</tr>

										<tr>
										<td class="label">LLDPE <span style="color:red;">*</span> :</td>
										<td><select name="sl_lldpe" id="sl_lldpe">
										<option value=''>--Select LLDPE--</option>
										<?php
										foreach ($lldpe as $lldpe_row) {
											echo "<option value='".$lldpe_row->article_no."' ".set_select('sl_lldpe',$lldpe_row->article_no).">".$lldpe_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="text" name="sl_lldpe_per" id="sl_lldpe_per" maxlength="3" size="3" value="<?php echo set_value('sl_lldpe_per');?>" placeholder="%"></td>
										</tr>

										<tr>
										<td class="label">HDPE  :</td>
										<td><select name="sl_hdpe" id="sl_hdpe">
										<option value=''>--Select HDPE--</option>
										<?php
										foreach ($hdpe as $hdpe_row) {
											echo "<option value='".$hdpe_row->article_no."' ".set_select('sl_hdpe',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="text" name="sl_hdpe_per"  id="sl_hdpe_per" maxlength="3" size="3" value="<?php echo set_value('sl_hdpe_per');?>" placeholder="%"></td>
										</tr>

										<tr>
										<td class="label">MB <span style="color:red;">*</span> :</td>
										<td><select name="sl_masterbatch"><option value=''>--Select MB--</option>
										<?php foreach ($masterbatch as $masterbatch_row) {
											echo "<option value='".$masterbatch_row->article_no."' ".set_select('sl_masterbatch',$masterbatch_row->article_no).">".$masterbatch_row->lang_article_description."</option>";
										}?></select></td>

										<td>
										<input type="text" name="sl_mb_per" maxlength="3" size="3" value="<?php echo set_value('sl_mb_per');?>" placeholder="%">
										<input type="text" name="sl_mb_supplier" class="supplier" size="60"  value="<?php echo set_value('sl_mb_supplier');?>" placeholder="MB Supplier">
										</td>
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
				
				
				
				
				
			