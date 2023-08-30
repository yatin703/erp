<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		
		$("#customer").autocomplete("<?php echo base_url('index.php/ajax/customer');?>", {selectFirst: true});
		$(".supplier").autocomplete("<?php echo base_url('index.php/ajax/supplier');?>", {selectFirst: true});

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

<?php foreach($specification as $specification_row):?>
	<?php
	

	$result_cap_type=$this->cap_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','3_2','srd_id','asc');

	foreach($result_cap_type as $cap_type_row){ $cap_types=$cap_type_row->relating_master_value;}

	$result_cap_finish=$this->cap_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','3_3','srd_id','asc');

	foreach($result_cap_finish as $cap_finish_row){ $cap_finishs=$cap_finish_row->relating_master_value;}

	$result_cap_dia=$this->cap_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','3_4','srd_id','asc');

	foreach($result_cap_dia as $cap_dia_row){ $cap_dias=$cap_dia_row->relating_master_value;}

	$result_cap_orifice=$this->cap_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','3_6','srd_id','asc');

	foreach($result_cap_orifice as $cap_orifice_row){ $cap_orifices=$cap_orifice_row->relating_master_value;}

	$result_cap_mb=$this->cap_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','3_7_0','srd_id','asc');

	foreach($result_cap_mb as $cap_mb_row){ $cap_mb=$cap_mb_row->mat_article_no; $cap_mb_per=$cap_mb_row->mat_info;}


	$result_cap_foil=$this->cap_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','3_9','srd_id','asc');

	foreach($result_cap_foil as $cap_foil_row){ $cap_foils=$cap_foil_row->mat_article_no;}

	$result_cap_shrink_sleeve=$this->cap_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','3_5','srd_id','asc');

	foreach($result_cap_shrink_sleeve as $shrink_sleeve_row){ $cap_shrink_sleeves=$shrink_sleeve_row->mat_article_no;}


	$result_cap_pp=$this->cap_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','3_8_1','srd_id','asc');

	foreach($result_cap_pp as $cap_pp_row){ $cap_pp=$cap_pp_row->mat_article_no; $cap_pp_per=$cap_pp_row->mat_info;}

	$result_cap_foil_color=$this->cap_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','3_9','srd_id','asc');

	foreach($result_cap_foil_color as $cap_foil_color_row){ $cap_foil_color=$cap_foil_color_row->parameter_value;}

	$result_cap_foil_width=$this->cap_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','3_10','srd_id','asc');

	foreach($result_cap_foil_width as $cap_foil_width_row){ $cap_foil_width=$cap_foil_width_row->parameter_value;}

	$result_cap_foil_dist=$this->cap_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','3_11','srd_id','asc');

	foreach($result_cap_foil_dist as $cap_foil_dist_row){ $cap_foil_dist=$cap_foil_dist_row->parameter_value;}



	$result_cap_mb_supplier=$this->cap_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','3_7_0','srd_id','asc');
	foreach($result_cap_mb_supplier as $cap_mb_supplier_row){
		$data['cap_mb_supplier']=$this->supplier_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$cap_mb_supplier_row->supplier_no);
		if($cap_mb_supplier_row->supplier_no==''){
			$cap_mbb="";
		}else{
				foreach ($data['cap_mb_supplier'] as $cap_mbb_row) {
					$cap_mbb=$cap_mbb_row->name1."//".$cap_mbb_row->adr_company_id;
				}
		}
	}

	?>
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
									<tr>
										<td class="label">Article Name * :</td>
										<td><span id="article_name" style="color:green;font-weight: bold"><?php echo set_value('article_name',$specification_row->article_name);?>
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
              		$cap_mb_perr=$this->input->post('cap_mb_per')."%";
              }else{
              		$cap_mb_perr='';
              }

              //echo $article_description=$cap_typee[0]." ".$cap_finishh[0]." ".$cap_diaa[0]." ".$cap_orificee[0]." ".$cap_masterbatchh[1]." ".$cap_mb_per;

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
													$selected=($cap_type_row->cap_type==$cap_types ? 'selected' : '');
													echo "<option value='".$cap_type_row->cap_type."//".$cap_type_row->cap_type_id."' $selected ".set_select('cap_type',''.$cap_type_row->cap_type.'//'.$cap_type_row->cap_type_id.'').">".$cap_type_row->cap_type."</option>";
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
															$selected=($cap_finish_row->cap_finish==$cap_finishs ? 'selected' : '');
															echo "<option value='".$cap_finish_row->cap_finish."//".$cap_finish_row->cap_finish_id."' $selected ".set_select('cap_finish',''.$cap_finish_row->cap_finish.'//'.$cap_finish_row->cap_finish_id.'').">".$cap_finish_row->cap_finish."</option>";
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
														$selected=($cap_dia_row->cap_dia==$cap_dias ? 'selected' : '');
														echo "<option value='".$cap_dia_row->cap_dia."//".$cap_dia_row->cap_dia_id."' $selected ".set_select('cap_dia',''.$cap_dia_row->cap_dia.'//'.$cap_dia_row->cap_dia_id.'').">".$cap_dia_row->cap_dia."</option>";
													}
											}?></select></td>
										</tr>

									<tr>
											<td class="label">Cap Orifice <span style="color:red;">*</span> :</td>
											<td><select name="cap_orifice" id="cap_orifice">
											<option value=''>--Select Cap Orifice--</option>
										<?php if($cap_orifice==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($cap_orifice as $cap_orifice_row){
													$selected=($cap_orifice_row->cap_orifice==$cap_orifices ? 'selected' : '');
													echo "<option value='".$cap_orifice_row->cap_orifice."//".$cap_orifice_row->cap_orifice_id."'  $selected ".set_select('cap_orifice',''.$cap_orifice_row->cap_orifice.'//'.$cap_orifice_row->cap_orifice_id.'').">".$cap_orifice_row->cap_orifice."</option>";
												}
										}?></select></td>
										</tr>

										

									<tr>
										<td class="label">MB <span style="color:red;">*</span> :</td>
										<td><select name="cap_masterbatch" id="cap_masterbatch">
										<option value=''>--Select MB--</option>
										<?php
										
										foreach ($masterbatch as $masterbatch_row) {
											$selected=($masterbatch_row->article_no==$cap_mb ? 'selected' : '');
											echo "<option value='".$masterbatch_row->article_no."//".$masterbatch_row->lang_article_description."' $selected ".set_select('cap_masterbatch',$masterbatch_row->article_no."//".$masterbatch_row->lang_article_description).">".$masterbatch_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
											<input type="text" name="cap_mb_per" maxlength="3" size="3" id="cap_mb_per" value="<?php echo set_value('cap_mb_per',$this->common_model->select_number_from_string($cap_mb_per));?>" placeholder="%">
											<input type="text" name="cap_mb_supplier" class="supplier" value="<?php echo set_value('cap_mb_supplier',$cap_mbb);?>"  size="60" placeholder="MB Supplier"></td>
										</tr>

										<tr>
										<td class="label">PP <span style="color:red;">*</span> :</td>
										<td><select name="cap_pp">
										<option value=''>--Select PP--</option>
										<?php
										foreach ($pp as $pp_row) {
											$selected=($pp_row->article_no==$cap_pp ? 'selected' : '');
											echo "<option value='".$pp_row->article_no."' $selected ".set_select('cap_pp',$pp_row->article_no).">".$pp_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="text" name="pp_per" maxlength="3" size="3" value="<?php echo set_value('pp_per',$this->common_model->select_number_from_string($cap_pp_per));?>" placeholder="%"></td>
										</tr>

										<tr>
										<td class="label">Cap Shrink Sleeve :</td>
										<td><select name="cap_shrink_sleeve" id="cap_shrink_sleeve">
										<option value=''>--Select Shrink Sleeve--</option>
										<?php
										foreach ($cap_shrink_sleeve as $cap_shrink_sleeve_row) {
											$selected=($cap_shrink_sleeve_row->article_no==$cap_shrink_sleeves ? 'selected' : '');
											echo "<option value='".$cap_shrink_sleeve_row->article_no."//".$cap_shrink_sleeve_row->lang_article_description."' $selected ".set_select('cap_shrink_sleeve',$cap_shrink_sleeve_row->article_no."//".$cap_shrink_sleeve_row->lang_article_description).">".$cap_shrink_sleeve_row->lang_article_description."</option>";
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
											$selected=($cap_foil_row->article_no==$cap_foils ? 'selected' : '');
											echo "<option value='".$cap_foil_row->article_no."//".$cap_foil_row->lang_article_description."' $selected ".set_select('cap_foil_color',$cap_foil_row->article_no."//".$cap_foil_row->lang_article_description).">".$cap_foil_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>


										<tr>
											<td class="label">Cap Foil Width <span style="color:red;">*</span> :</td>
											<td><input type="text" name="cap_foil_width" value="<?php echo set_value('cap_foil_width',$cap_foil_width);?>"></td>
										</tr>

										<tr>
											<td class="label">Cap Foil Dist From Bottom <span style="color:red;">*</span> :</td>
											<td><input type="text" name="cap_foil_dist_frm_bottom" value="<?php echo set_value('cap_foil_dist_frm_bottom',$cap_foil_dist);?>"></td>
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
<?php endforeach;?>
				
				
				
				
				
			