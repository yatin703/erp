<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		
		$("#label_no").autocomplete("<?php echo base_url('index.php/ajax/label');?>", {selectFirst: true});

		$("#label").autocomplete("<?php echo base_url('index.php/ajax/label');?>", {selectFirst: true});
		

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



		$("#label_no").live('keyup',function() {

			if($("#label_no").val()!=''){ var label_no=$("#label_no").val().split('//')[0];}else{var label_no="";}

   	if(label_no!=''){
   		$("#article_name").html("<span class='ui teal label'>"+label_no+"</span>");
   	}else{
						$("#article_name").html('');
				}
    
			});


		$("#lacquer_type_1").change(function(event) {

			if($("#label_no").val()!=''){ var label_no=$("#label_no").val().split('//')[0];}else{var label_no="";}

			if($("#lacquer_type_1 option:selected").val()!=''){ var lacquer_type_1=$("#lacquer_type_1 option:selected").text();}else{var lacquer_type_1="";}

			if($("#lacquer_mixing_pc_1").val()!=''){ var lacquer_mixing_pc_1=$("#lacquer_mixing_pc_1").val()+"%"; }else{var lacquer_mixing_pc_1="";}

   	if(lacquer_type_1!=''){
   		$("#article_name").html("<span class='ui teal label'>"+label_no+"</span><br/>+<br/><span class='ui white label'>"+lacquer_type_1+" "+lacquer_mixing_pc_1+"</span>");
   	}else{
						$("#article_name").html('');
				}
    
			});



		$("#lacquer_type_2").change(function(event) {

			if($("#label_no").val()!=''){ var label_no=$("#label_no").val().split('//')[0];}else{var label_no="";}

			if($("#lacquer_type_1 option:selected").val()!=''){ var lacquer_type_1=$("#lacquer_type_1 option:selected").text();}else{var lacquer_type_1="";}

			if($("#lacquer_type_2 option:selected").val()!=''){ var lacquer_type_2=$("#lacquer_type_2 option:selected").text();}else{var lacquer_type_2="";}

			if($("#lacquer_mixing_pc_1").val()!=''){ var lacquer_mixing_pc_1=$("#lacquer_mixing_pc_1").val()+"%"; }else{var lacquer_mixing_pc_1="";}

			if($("#lacquer_mixing_pc_2").val()!=''){ var lacquer_mixing_pc_2=$("#lacquer_mixing_pc_2").val()+"%"; }else{var lacquer_mixing_pc_2="";}

   	if(lacquer_type_2!=''){
   		$("#article_name").html("<span class='ui teal label'>"+label_no+"</span><br/>+<br/><span class='ui white label'>"+lacquer_type_1+" "+lacquer_mixing_pc_1+"</span><br/>+<br/><span class='ui white label'>"+lacquer_type_2+" "+lacquer_mixing_pc_2+"</span>");
   	}else{
						$("#article_name").html('');
				}
    
			});

		$("#non_lacquering_height_by_open_end").live('keyup',function() {

			if($("#label_no").val()!=''){ var label_no=$("#label_no").val().split('//')[0];}else{var label_no="";}

			if($("#lacquer_type_1 option:selected").val()!=''){ var lacquer_type_1=$("#lacquer_type_1 option:selected").text();}else{var lacquer_type_1="";}

			if($("#lacquer_type_2 option:selected").val()!=''){ var lacquer_type_2=$("#lacquer_type_2 option:selected").text();}else{var lacquer_type_2="";}

			if($("#lacquer_mixing_pc_1").val()!=''){ var lacquer_mixing_pc_1=$("#lacquer_mixing_pc_1").val()+"%"; }else{var lacquer_mixing_pc_1="";}

			if($("#lacquer_mixing_pc_2").val()!=''){ var lacquer_mixing_pc_2=$("#lacquer_mixing_pc_2").val()+"%"; }else{var lacquer_mixing_pc_2="";}

			if($("#non_lacquering_height_by_open_end").val()!=''){ var non_lacquering_height_by_open_end="OE"+$("#non_lacquering_height_by_open_end").val(); }else{var non_lacquering_height_by_open_end="";}

   	if(non_lacquering_height_by_open_end!=''){
   		$("#article_name").html("<span class='ui teal label'>"+label_no+"</span><br/>+<br/><span class='ui white label'>"+lacquer_type_1+" "+lacquer_mixing_pc_1+"</span><br/>+<br/><span class='ui white label'>"+lacquer_type_2+" "+lacquer_mixing_pc_2+"</span><br/>+<br/><span class='ui grey label'>"+non_lacquering_height_by_open_end+"</span>");
   	}else{
						$("#article_name").html('');
				}
    
			});


		$("#non_labeling_height_by_shoulder_end").live('keyup',function() {

			if($("#label_no").val()!=''){ var label_no=$("#label_no").val().split('//')[0];}else{var label_no="";}

			if($("#lacquer_type_1 option:selected").val()!=''){ var lacquer_type_1=$("#lacquer_type_1 option:selected").text();}else{var lacquer_type_1="";}

			if($("#lacquer_type_2 option:selected").val()!=''){ var lacquer_type_2=$("#lacquer_type_2 option:selected").text();}else{var lacquer_type_2="";}

			if($("#lacquer_mixing_pc_1").val()!=''){ var lacquer_mixing_pc_1=$("#lacquer_mixing_pc_1").val()+"%"; }else{var lacquer_mixing_pc_1="";}

			if($("#lacquer_mixing_pc_2").val()!=''){ var lacquer_mixing_pc_2=$("#lacquer_mixing_pc_2").val()+"%"; }else{var lacquer_mixing_pc_2="";}

			if($("#non_lacquering_height_by_open_end").val()!=''){ var non_lacquering_height_by_open_end="OE"+$("#non_lacquering_height_by_open_end").val(); }else{var non_lacquering_height_by_open_end="";}

			if($("#non_labeling_height_by_shoulder_end").val()!=''){ var non_labeling_height_by_shoulder_end="SE"+$("#non_labeling_height_by_shoulder_end").val(); }else{var non_labeling_height_by_shoulder_end="";}

   	if(non_labeling_height_by_shoulder_end!=''){
   		$("#article_name").html("<span class='ui teal label'>"+label_no+"</span><br/>+<br/><span class='ui white label'>"+lacquer_type_1+" "+lacquer_mixing_pc_1+"</span><br/>+<br/><span class='ui white label'>"+lacquer_type_2+" "+lacquer_mixing_pc_2+"</span><br/>+<br/><span class='ui grey label'>"+non_lacquering_height_by_open_end+"</span><br/>+<br/><span class='ui grey label'>"+non_labeling_height_by_shoulder_end+"</span>");
   	}else{
						$("#article_name").html('');
				}
    
			});

		$(".form_table_inner").live('mouseover',function() {

			if($("#label_no").val()!=''){

			if($("#label_no").val()!=''){ var label_no=$("#label_no").val().split('//')[0];}else{var label_no="";}

			if($("#lacquer_type_1 option:selected").val()!=''){ var lacquer_type_1=$("#lacquer_type_1 option:selected").text();}else{var lacquer_type_1="";}

			if($("#lacquer_type_2 option:selected").val()!=''){ var lacquer_type_2=$("#lacquer_type_2 option:selected").text();}else{var lacquer_type_2="";}

			if($("#lacquer_mixing_pc_1").val()!=''){ var lacquer_mixing_pc_1=$("#lacquer_mixing_pc_1").val()+"%"; }else{var lacquer_mixing_pc_1="";}

			if($("#lacquer_mixing_pc_2").val()!=''){ var lacquer_mixing_pc_2=$("#lacquer_mixing_pc_2").val()+"%"; }else{var lacquer_mixing_pc_2="";}

			if($("#non_lacquering_height_by_open_end").val()!=''){ var non_lacquering_height_by_open_end="OE"+$("#non_lacquering_height_by_open_end").val(); }else{var non_lacquering_height_by_open_end="";}

			if($("#non_labeling_height_by_shoulder_end").val()!=''){ var non_labeling_height_by_shoulder_end="SE"+$("#non_labeling_height_by_shoulder_end").val(); }else{var non_labeling_height_by_shoulder_end="";}


			$("#article_name").html("<span class='ui teal label'>"+label_no+"</span><br/>+<br/><span class='ui white label'>"+lacquer_type_1+" "+lacquer_mixing_pc_1+"</span><br/>+<br/><span class='ui white label'>"+lacquer_type_2+" "+lacquer_mixing_pc_2+"</span><br/>+<br/><span class='ui grey label'>"+non_lacquering_height_by_open_end+"</span><br/>+<br/><span class='ui grey label'>"+non_labeling_height_by_shoulder_end+"</span>");

		}else{
			$("#article_name").html('');
		}

			});

	});
</script>

<?php foreach($specification as $specification_row):?>
<?php
	$result_label=$this->label_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','8_1','srd_id','asc');

	foreach($result_label as $label_row){ 
		$label_no=$label_row->mat_article_no;
		$data['label_no']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$label_no);
		foreach($data['label_no'] as $label_name_row){
			$label_name=$label_name_row->article_name."//".$label_name_row->article_no;
		}

	}

	$result_label_oe=$this->label_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','8_4','srd_id','asc');

	foreach($result_label_oe as $label_oe_row){ $label_oe=$label_oe_row->parameter_value;}

	$result_label_se=$this->label_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','8_5','srd_id','asc');

	foreach($result_label_se as $label_se_row){ $label_se=$label_se_row->parameter_value;}

	$result_lacquer_one=$this->label_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','8_2','srd_id','asc');
	if($result_lacquer_one==FALSE){
		$lacquer_one="";
		$lacquer_one_pc="";
	}else{
		foreach($result_lacquer_one as $lacquer_one_row){ $lacquer_one=$lacquer_one_row->mat_article_no; $lacquer_one_pc=$lacquer_one_row->mat_info;}
	}

	$result_lacquer_two=$this->label_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','8_3','srd_id','asc');
	if($result_lacquer_two==FALSE){
		$lacquer_two="";
		$lacquer_two_pc="";
	}else{
		foreach($result_lacquer_two as $lacquer_two_row){ $lacquer_two=$lacquer_two_row->mat_article_no; $lacquer_two_pc=$lacquer_two_row->mat_info;}
	}
?>
<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save_label');?>" method="POST" >


	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">

									<tr>
										<td class="label">Main Group <span style="color:red;">*</span>:</td>
										<td><select name="main_group" id="main_group" required><option value=''>--Select Main Group--</option>
											<option value='44'>LABEL SLEEVE</option>
										<?php /*if($main_group==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($main_group as $main_group_row){
													echo "<option value='".$main_group_row->main_group_id."'  ".set_select('main_group',''.$main_group_row->main_group_id.'').">".strtoupper($main_group_row->lang_main_group_desc)."-".$main_group_row->main_group_id."</option>";
												}
										}*/?>
										</select></td>
									</tr>

										<tr>
										<td class="label">Label No <span style="color:red;">*</span>:</td>
										<td><select name="article_no" id="article_no" required>
										<?php if($this->input->post('article_no')){
											echo '<option value="'.$this->input->post('article_no').'">'.$this->input->post('article_no').'</option>';
										}else{
											echo '<option value="">--Select Article Code--</option>';
										}?></select></td>
										</tr>

									
									<tr>
										<td class="label">Label Material * : </td>
										<td><input type="text" name="label_no" id="label_no" size="60" value="<?php echo set_value('label_no',$label_name);?>" required/></td>
									</tr>

									<tr id="lacquer_type_1">
										<td class="label">Lacquer Type 1 <span style="color:red;">*</span>:</td>
										<td><select name="lacquer_type_1" id="lacquer_type_1" required><option value=''>--Select Lacquer--</option>
										<?php if($lacquer==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($lacquer as $lacquer_row){
													$selected=($lacquer_row->article_no==$lacquer_one ? 'selected' :'');
													echo "<option value='".$lacquer_row->article_no."'  $selected ".set_select('lacquer_type_1',$lacquer_row->article_no).">".$lacquer_row->lang_article_description."</option>";
												}
										}?></select><input type="number" min="0" max="100" step="1" name='lacquer_mixing_pc_1' id="lacquer_mixing_pc_1" size="3" value='<?php echo set_value('lacquer_mixing_pc_1',$lacquer_one_pc);?>'  placeholder="%"></td>
									</tr>

									<tr id="lacquer_type_2">
										<td class="label">Lacquer Type 2 :</td>
										<td><select name="lacquer_type_2" id="lacquer_type_2"><option value=''>--Select Lacquer--</option>
										<?php if($lacquer==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($lacquer as $lacquer_row){
													$selected=($lacquer_row->article_no==$lacquer_two ? 'selected' :'');
													echo "<option value='".$lacquer_row->article_no."' $selected ".set_select('lacquer_type_2',$lacquer_row->article_no).">".$lacquer_row->lang_article_description."</option>";
												}
										}?></select><input type="number"  min="0" max="100" step="1" name='lacquer_mixing_pc_2' id="lacquer_mixing_pc_2" size="3" value='<?php echo set_value('lacquer_mixing_pc_2',$lacquer_two_pc);?>'  placeholder="%"></td>
									</tr>

									<tr>
										<td class="label">Non Lacquering Height by Open End <span style="color:red;">*</span>:</td>
										<td><input type="number"  min="0" max="100" step="1" name="non_lacquering_height_by_open_end" id="non_lacquering_height_by_open_end" size="3" value='<?php echo set_value('non_lacquering_height_by_open_end',$label_oe);?>' required></td>
									</tr>

									<tr>
										<td class="label">Non Labeling Height by Shoulder End <span style="color:red;">*</span>:</td>
										<td><input type="number"  min="0" max="100" step="1" name="non_labeling_height_by_shoulder_end" id="non_labeling_height_by_shoulder_end" size="3" value='<?php echo set_value('non_labeling_height_by_shoulder_end',$label_se);?>' required></td>
									</tr>



									</table>
							</td>
							<td>
								<table>
									<tr>
										<td class="label">Label Component <span style="color:red;">*</span>:</td>
										<td><!--<span id="article_name" style="color:green;font-weight: bold"><?php echo set_value('article_name',$specification_row->article_name);?>
										<br/>
										<?php
										/*
												if(!empty($this->input->post('label_no'))){
							                $label_no=explode('//',$this->input->post('label_no'));
							                echo "<span class='ui teal label'>".$label_no[0]."</span>";
							              }else{
							                $label_no[0]='';
							                $label_no[1]='';
							              }

							              if(!empty($this->input->post('lacquer_type_1')) && !empty($this->input->post('lacquer_mixing_pc_1'))){

							              	$data['lacquer_type_1']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('lacquer_type_1'));
							              	if($data['lacquer_type_1']==FALSE){
							                $lacquer_type_1="";
							              	}else{
							                foreach($data['lacquer_type_1'] as $lacquer_type_1_row){
							                  $lacquer_type_1=$lacquer_type_1_row->article_name;
							                }
							              	}
							                $lacquer_mixing_pc_1=$this->input->post('lacquer_mixing_pc_1')."%";
							                echo "<br/>+<br/><span class='ui white label'>".$lacquer_type_1." ".$lacquer_mixing_pc_1."</span>";
							              }else{
							                $lacquer_type_1='';
							                $lacquer_mixing_pc_1='';
							              }




							              if(!empty($this->input->post('lacquer_type_2')) && !empty($this->input->post('lacquer_mixing_pc_2'))){

							              	$data['lacquer_type_2']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('lacquer_type_2'));
							              	if($data['lacquer_type_2']==FALSE){
							                $lacquer_type_2="";
							              	}else{
							                foreach($data['lacquer_type_2'] as $lacquer_type_2_row){
							                  $lacquer_type_2=$lacquer_type_2_row->article_name;
							                }
							              	}
							                $lacquer_mixing_pc_2=$this->input->post('lacquer_mixing_pc_2');
							                echo "<br/>+<br/><span class='ui white label'>".$lacquer_type_2." ".$lacquer_mixing_pc_2."</span>";
							              }else{
							                $lacquer_type_2='';
							                $lacquer_mixing_pc_2='';
							              }

							              if(!empty($this->input->post('non_lacquering_height_by_open_end'))){
							                $non_lacquering_height_by_open_end="OE ".$this->input->post('non_lacquering_height_by_open_end');
							                echo "<br/>+<br/><span class='ui grey label'>".$non_lacquering_height_by_open_end."</span>";
							              }else{
							                $non_lacquering_height_by_open_end='';
							              }

							              if(!empty($this->input->post('non_labeling_height_by_shoulder_end'))){
							                $non_labeling_height_by_shoulder_end="SE ".$this->input->post('non_labeling_height_by_shoulder_end');
							                echo "<br/>+<br/><span class='ui grey label'>".$non_labeling_height_by_shoulder_end."</span>";
							              }else{
							                $non_labeling_height_by_shoulder_end='';
							              }
							              */
							              ?>
											</span>--></td>
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
				
				
				
				
				
			