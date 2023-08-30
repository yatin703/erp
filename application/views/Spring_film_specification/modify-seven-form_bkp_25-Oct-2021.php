<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
   $(document).ready(function(){
      $("#loading").hide(); $("#cover").hide();

      $("#article_no").autocomplete("<?php echo base_url('index.php/ajax/article_no');?>", {selectFirst: true});


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

      $("#sleeve_dia").change(function(event) {
         $('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
         if($("#sleeve_dia option:selected" ).val()!=''){
            var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0, 2);
            $("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"</span>");
            $("#loading").hide();$("#cover").hide();
         }else{
            $("#article_name").html('');
         }
         });

      $("#sleeve_length").live('keyup',function() {
         if($("#sleeve_dia option:selected" ).val()!='' && $("#sleeve_length" ).val()!=''){
            var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0,2);
            var sleeve_length=$("#sleeve_length").val();
            $("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"X"+sleeve_length+"</span>+<span class='ui teal label'>1 LAYER</span>");
         }else{
            $("#article_name").html('');
            
         }
         });


   

   });
</script>
<?php foreach($specification as $specification_row):?>
	<?php
	$result_dia=$this->sleeve_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','1_1','srd_id','asc');

	if($result_dia==FALSE){
		$dia='';
	}else{
			foreach($result_dia as $dia_row){ $dia=$dia_row->relating_master_value; }
	}

	$result_length=$this->sleeve_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','1_2','srd_id','asc');
	if($result_dia==FALSE){
		$length='';
	}else{
		foreach($result_length as $length_row){ $length=$length_row->parameter_value; }
	}

	$result_print_type=$this->sleeve_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','1_7','srd_id','asc');
	if($result_print_type==FALSE){
		$print_types='';
	}else{
		foreach($result_print_type as $print_type_row){ $print_types=$print_type_row->relating_master_value; }
	}
	


	$result_gauge_one=$this->sleeve_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','1_4','srd_id','asc');
	if($result_gauge_one==FALSE){
		$gauge_one='';
	}else{
		foreach($result_gauge_one as $gauge_one_row){ $gauge_one=$gauge_one_row->parameter_value; }
	}
	
	$result_ldpe_one=$this->sleeve_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','1_6_0','srd_id','asc');
	if($result_ldpe_one==FALSE){
		$film_ldpe_one='';
		$film_ldpe_per_one='';
	}else{
		foreach($result_ldpe_one as $film_ldpe_one_row){ $film_ldpe_one=$film_ldpe_one_row->mat_article_no; $film_ldpe_per_one=$film_ldpe_one_row->mat_info;}
	}


   $result_lldpe_one=$this->sleeve_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','1_6_1','srd_id','asc');
   if($result_lldpe_one==FALSE){
      $film_lldpe_one='';
      $film_lldpe_per_one='';
   }else{
      foreach($result_lldpe_one as $film_lldpe_one_row){ $film_lldpe_one=$film_lldpe_one_row->mat_article_no; $film_lldpe_per_one=$film_lldpe_one_row->mat_info;}
   }


//Layer 2

		$result_gauge_two=$this->sleeve_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','2_4','srd_id','asc');
		if($result_gauge_two==FALSE){
			$gauge_two='';
		}else{
			foreach($result_gauge_two as $gauge_two_row){ $gauge_two=$gauge_two_row->parameter_value; }
		}

      $result_film_mb_two=$this->sleeve_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','2_5_0','srd_id','asc');
      if($result_film_mb_two==FALSE){
         $film_mb_two='';
         $film_mb_per_two='';
      }else{
         foreach($result_film_mb_two as $film_mb_two_row){ $film_mb_two=$film_mb_two_row->mat_article_no; $film_mb_per_two=$film_mb_two_row->mat_info;}
      }

      $result_film_ldpe_two=$this->sleeve_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','2_6_0','srd_id','asc');
		//echo $this->db->last_query();
		if($result_film_ldpe_two==FALSE){
			$film_ldpe_two='';
			$film_ldpe_per_two='';
		}else{
			foreach($result_film_ldpe_two as $film_ldpe_two_row){ 
				$film_ldpe_two=$film_ldpe_two_row->mat_article_no; 
				$film_ldpe_per_two=$film_ldpe_two_row->mat_info;}
		}

		$result_film_lldpe_two=$this->sleeve_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','2_6_1','srd_id','asc');
		//echo $this->db->last_query();
		if($result_film_lldpe_two==FALSE){
			$film_lldpe_two='';
			$film_lldpe_per_two='';
		}else{
			foreach($result_film_lldpe_two as $film_lldpe_two_row){ 
				$film_lldpe_two=$film_lldpe_two_row->mat_article_no; 
				$film_lldpe_per_two=$film_lldpe_two_row->mat_info;}
		}

		$result_film_hdpe_two=$this->sleeve_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','2_6_2','srd_id','asc');
		if($result_film_hdpe_two==FALSE){
			$film_hdpe_two='';
			$film_hdpe_per_two='';
		}else{
			foreach($result_film_hdpe_two as $film_hdpe_two_row){ $film_hdpe_two=$film_hdpe_two_row->mat_article_no; $film_hdpe_per_two=$film_hdpe_two_row->mat_info;}
		}


//Layer 3

		$result_gauge_three=$this->sleeve_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','3_4','srd_id','asc');
		if($result_gauge_three==FALSE){
			$gauge_three='';
		}else{
			foreach($result_gauge_three as $gauge_three_row){ $gauge_three=$gauge_three_row->parameter_value; }
		}


		$result_film_admer_three=$this->sleeve_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','3_6_4','srd_id','asc');
		if($result_film_admer_three==FALSE){
			$film_admer_three='';
			$film_admer_per_three='';
		}else{
			foreach($result_film_admer_three as $film_admer_three_row){ $film_admer_three=$film_admer_three_row->mat_article_no; $film_admer_per_three=$film_admer_three_row->mat_info;}
		}

		$result_film_hdpe_three=$this->sleeve_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','3_6_5','srd_id','asc');
		if($result_film_hdpe_three==FALSE){
			$film_hdpe_three='';
			$film_hdpe_per_three='';
		}else{
			foreach($result_film_hdpe_three as $film_hdpe_three_row){ $film_hdpe_three=$film_hdpe_three_row->mat_article_no; $film_hdpe_per_three=$film_hdpe_three_row->mat_info;}
		}

//Layer 4

		$result_gauge_four=$this->sleeve_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','4_4','srd_id','asc');
		if($result_gauge_four==FALSE){
			$gauge_four='';
		}else{
			foreach($result_gauge_four as $gauge_four_row){ $gauge_four=$gauge_four_row->parameter_value; }
		}

		$result_film_evoh_four=$this->sleeve_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','4_6_3','srd_id','asc');
		if($result_film_evoh_four==FALSE){
			$film_evoh_four='';
			$film_evoh_per_four='';
		}else{
			foreach($result_film_evoh_four as $film_evoh_four_row){ $film_evoh_four=$film_evoh_four_row->mat_article_no; $film_evoh_per_four=$film_evoh_four_row->mat_info;}
		}

		$result_film_hdpe_four=$this->sleeve_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','4_6_4','srd_id','asc');
		if($result_film_hdpe_four==FALSE){
			$film_hdpe_four='';
			$film_hdpe_per_four='';
		}else{
			foreach($result_film_hdpe_four as $film_hdpe_four_row){ $film_hdpe_four=$film_hdpe_four_row->mat_article_no; $film_hdpe_per_four=$film_hdpe_four_row->mat_info;}
		}

//Layer 5

		$result_gauge_five=$this->sleeve_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','5_4','srd_id','asc');
		if($result_gauge_five==FALSE){
			$gauge_five='';
		}else{
			foreach($result_gauge_five as $gauge_five_row){ $gauge_five=$gauge_five_row->parameter_value; }
		}

		$result_film_admer_five=$this->sleeve_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','5_6_4','srd_id','asc');
		if($result_film_admer_five==FALSE){
			$film_admer_five='';
			$film_admer_per_five='';
		}else{
			foreach($result_film_admer_five as $film_admer_five_row){ $film_admer_five=$film_admer_five_row->mat_article_no; $film_admer_per_five=$film_admer_five_row->mat_info;}
		}

		$result_film_hdpe_five=$this->sleeve_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','5_6_5','srd_id','asc');
		if($result_film_hdpe_five==FALSE){
			$film_hdpe_five='';
			$film_hdpe_per_five='';
		}else{
			foreach($result_film_hdpe_five as $film_hdpe_five_row){ $film_hdpe_five=$film_hdpe_five_row->mat_article_no; $film_hdpe_per_five=$film_hdpe_five_row->mat_info;}
		}



//Layer Six

		$result_gauge_six=$this->sleeve_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','6_4','srd_id','asc');
		if($result_gauge_six==FALSE){
			$gauge_six='';
		}else{
			foreach($result_gauge_six as $gauge_six_row){ $gauge_six=$gauge_six_row->parameter_value; }
		}

		$result_film_mb_six=$this->sleeve_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','6_5_0','srd_id','asc');
		if($result_film_mb_six==FALSE){
			$film_mb_six='';
			$film_mb_per_six='';
		}else{
			foreach($result_film_mb_six as $film_mb_six_row){ $film_mb_six=$film_mb_six_row->mat_article_no; $film_mb_per_six=$film_mb_six_row->mat_info;}
		}

		$result_film_ldpe_six=$this->sleeve_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','6_6_0','srd_id','asc');
		//echo $this->db->last_query();
		if($result_film_ldpe_six==FALSE){
			$film_ldpe_six='';
			$film_ldpe_per_six='';
		}else{
			foreach($result_film_ldpe_six as $film_ldpe_six_row){ 
				$film_ldpe_six=$film_ldpe_six_row->mat_article_no; 
				$film_ldpe_per_six=$film_ldpe_six_row->mat_info;}
		}


		$result_film_lldpe_six=$this->sleeve_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','6_6_1','srd_id','asc');
		if($result_film_lldpe_six==FALSE){
				$film_lldpe_six='';
				$film_lldpe_per_six='';
			}else{
				foreach($result_film_lldpe_six as $film_lldpe_six_row){ 
					$film_lldpe_six=$film_lldpe_six_row->mat_article_no; 
					$film_lldpe_per_six=$film_lldpe_six_row->mat_info;}
			}

		$result_film_hdpe_six=$this->sleeve_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','6_6_2','srd_id','asc');
		if($result_film_hdpe_six==FALSE){
			$film_hdpe_six='';
			$film_hdpe_per_six='';
		}else{
			foreach($result_film_hdpe_six as $film_hdpe_six_row){ 
				$film_hdpe_six=$film_hdpe_six_row->mat_article_no; 
				$film_hdpe_per_six=$film_hdpe_six_row->mat_info;}
		}

//Layer Seven

		$result_gauge_seven=$this->sleeve_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','7_4','srd_id','asc');
		if($result_gauge_seven==FALSE){
			$gauge_seven='';
		}else{
			foreach($result_gauge_seven as $gauge_seven_row){ $gauge_seven=$gauge_seven_row->parameter_value; }
		}

		$result_film_ldpe_seven=$this->sleeve_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','7_6_0','srd_id','asc');
		if($result_film_ldpe_seven==FALSE){
				$film_ldpe_seven='';
				$film_ldpe_per_seven='';
			}else{
				foreach($result_film_ldpe_seven as $film_ldpe_seven_row){ $film_ldpe_seven=$film_ldpe_seven_row->mat_article_no; $film_ldpe_per_seven=$film_ldpe_seven_row->mat_info;}
			}

		$result_film_lldpe_seven=$this->sleeve_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','7_6_1','srd_id','asc');
		if($result_film_lldpe_seven==FALSE){
				$film_lldpe_seven='';
				$film_lldpe_per_seven='';
			}else{
				foreach($result_film_lldpe_seven as $film_lldpe_seven_row){ $film_lldpe_seven=$film_lldpe_seven_row->mat_article_no; $film_lldpe_per_seven=$film_lldpe_seven_row->mat_info;}
			}

		?>
<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update_seven_layer');?>" method="POST" >


	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td width="40%">
					<table class="form_table_inner">

										<input type="hidden" name="spec_id"  value="<?php echo set_value('spec_id',$specification_row->spec_id);?>" readonly/>
										<input type="hidden" name="record_no" value="<?php echo $specification_row->spec_id.'@@@'.$specification_row->spec_version_no;?>">
										<input type="hidden" name="spec_version_no"  value="<?php echo set_value('spec_version_no',$specification_row->spec_version_no);?>" readonly/>

									<tr>
										<td class="label">Film No  <span style="color:red;">*</span> :</td>
										<td><input type="text" name="article_no" id="article_no" size="20" value="<?php echo set_value('article_no',$specification_row->article_no);?>" readonly /></td>
									</tr>
									
									<tr>
										<td class="label">Dia <span style="color:red;">*</span> :</td>
										<td><select name="sleeve_dia" id="sleeve_dia" required><option value=''>--Dia--</option>
										<?php if($sleeve_dia==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($sleeve_dia as $sleeve_dia_row){
													$selected=($sleeve_dia_row->sleeve_diameter==$dia ? 'selected' :'');
													echo "<option value='".$sleeve_dia_row->sleeve_diameter."//".$sleeve_dia_row->sleeve_id."'  ".set_select('sleeve_dia',''.$sleeve_dia_row->sleeve_diameter.'//'.$sleeve_dia_row->sleeve_id.'')." $selected>".$sleeve_dia_row->sleeve_diameter."</option>";
												}
										}?></select>Length : <span style="color:red;">*</span> :
											<input type="text" name="sleeve_length" id="sleeve_length" min="10"  max="300" step="0.1" size="5" value="<?php echo set_value('sleeve_length',$length);?>" required>
										</td>
									</tr>

									<tr><td class="label">&nbsp;</td><td class="label">&nbsp;</td></tr>

									<tr><td class="label"><b>1 Layer</b></td></tr>

									<tr>
										<td class="label">Gauge <span style="color:red;">*</span> :</td>
										<td><input type="number"  min="10" max="20" step="10" name="gauge_one" maxlength="5" size="5" value="<?php echo set_value('gauge',$gauge_one);?>" required></td>
									</tr>

									<tr>
										<td class="label">LDPE :</td>
										<td><select name="film_ldpe_one">
										<option value=''>--Select LDPE--</option>
										<?php
										foreach ($ldpe as $ldpe_row) {
											$selected=( $ldpe_row->article_no==$film_ldpe_one ? 'selected' : '');
											echo "<option value='".$ldpe_row->article_no."' $selected ".set_select('film_ldpe_one',$ldpe_row->article_no).">".$ldpe_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="number" name="film_ldpe_per_one"  min="0"  max="100" step="1"  maxlength="3" size="3" value="<?php echo set_value('film_ldpe_per_one',$this->common_model->select_percentage_from_string($film_ldpe_per_one));?>" placeholder="%"></td>
										</tr>

										<tr>
										<td class="label">LLDPE :</td>
										<td><select name="film_lldpe_one">
										<option value=''>--Select LLDPE--</option>
										<?php
										foreach ($lldpe as $lldpe_row) {
											$selected=($lldpe_row->article_no==$film_lldpe_one ? 'selected' : '');
											echo "<option value='".$lldpe_row->article_no."' $selected ".set_select('film_lldpe_one',$lldpe_row->article_no).">".$lldpe_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="number" name="film_lldpe_per_one"  min="0"  max="100" step="1"  maxlength="3" size="3" value="<?php echo set_value('film_lldpe_per_one',$this->common_model->select_percentage_from_string($film_lldpe_per_one));?>" placeholder="%"></td>
										</tr>

										
                           <tr><td class="label">&nbsp;</td><td class="label">&nbsp;</td></tr>

									<tr><td class="label"><b>2 Layer</b></td></tr>

									<tr>
										<td class="label">Gauge <span style="color:red;">*</span> :</td>
										<td><input type="number" name="gauge_two" min="100"  max="175" step="1"  id="gauge_two" maxlength="2" size="2" value="<?php echo set_value('gauge_two',$this->common_model->select_number_from_string($gauge_two));?>" required></td>
									</tr>

									<tr>
                                    <td class="label">MB <span style="color:red;">*</span> :</td>
                                    <td><select name="film_masterbatch_two" required><option value=''>--Select MB--</option>
                                    <?php foreach ($masterbatch as $masterbatch_row) {
                                    	$selected=($masterbatch_row->article_no==$film_mb_two ? 'selected' : '');
                                       echo "<option value='".$masterbatch_row->article_no."' $selected ".set_select('film_masterbatch_two',$masterbatch_row->article_no).">".$masterbatch_row->lang_article_description."</option>";
                                    }?></select></td>

                                    <td><input type="number" name="film_mb_per_two" min="0"  max="25" step="any" maxlength="4" size="4" value="<?php echo set_value('film_mb_per_two',$this->common_model->select_percentage_from_string($film_mb_per_two));?>" placeholder="%" required></td>
	                                 </tr>

	                                 <tr>
										<td class="label">LDPE :</td>
										<td><select name="film_ldpe_two">
										<option value=''>--Select LDPE--</option>
										<?php
										foreach ($ldpe as $ldpe_row) {
											$selected=( $ldpe_row->article_no==$film_ldpe_two ? 'selected' : '');
											echo "<option value='".$ldpe_row->article_no."' $selected ".set_select('film_ldpe_two',$ldpe_row->article_no).">".$ldpe_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="number" name="film_ldpe_per_two"  min="0"  max="100" step="1"  maxlength="3" size="3" value="<?php echo set_value('film_ldpe_per_two',$this->common_model->select_percentage_from_string($film_ldpe_per_two));?>" placeholder="%"></td>
										</tr>

	                                 <tr>
	                                 <td class="label">LLDPE <span style="color:red;">*</span> :</td>
	                                 <td><select name="film_lldpe_two" >
	                                 <option value=''>--Select LLDPE--</option>
	                                 <?php
	                                 foreach ($lldpe as $lldpe_row) {
	                                 	$selected=($lldpe_row->article_no==$film_lldpe_two ? 'selected' : '');
	                                    echo "<option value='".$lldpe_row->article_no."' $selected ".set_select('film_lldpe_two',$lldpe_row->article_no).">".$lldpe_row->lang_article_description."</option>";
	                                 }
	                                 ?>
	                                 </select></td>
	                                 <td>
	                                 <input type="number" name="film_lldpe_per_two" min="0"  max="100" step="1" maxlength="3" size="3" value="<?php echo set_value('film_lldpe_per_two',$this->common_model->select_percentage_from_string($film_lldpe_per_two));?>" placeholder="%" ></td>
	                                 </tr>

	                                 <tr>
	                                 <td class="label">HDPE  <span style="color:red;">*</span> :</td>
	                                 <td><select name="film_hdpe_two" >
	                                 <option value=''>--Select HDPE--</option>
	                                 <?php
	                                 foreach ($hdpe as $hdpe_row) {
	                                 	$selected=($hdpe_row->article_no==$film_hdpe_two ? 'selected' : '');
	                                    echo "<option value='".$hdpe_row->article_no."'  $selected ".set_select('film_hdpe_two',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
	                                 }
	                                 ?>
	                                 </select></td>
	                                 <td>
	                                 <input type="number" name="film_hdpe_per_two" min="0"  max="100" step="1" maxlength="3" size="3" value="<?php echo set_value('film_hdpe_per_two',$this->common_model->select_percentage_from_string($film_hdpe_per_two));?>" placeholder="%" ></td>
	                                 </tr>

                           <tr><td class="label">&nbsp;</td><td class="label">&nbsp;</td></tr>
									<tr><td class="label"><b>3 Layer</b></td></tr>

									<tr>
										<td class="label">Gauge <span style="color:red;">*</span> :</td>
										<td><input type="number" name="gauge_three" min="10"  max="20" step="10" id="gauge_three" maxlength="2" size="2" value="<?php echo set_value('gauge_three',$this->common_model->select_number_from_string($gauge_three));?>"></td>
									</tr>

									<tr>
										<td class="label">Admer <span style="color:red;">*</span> :</td>
										<td><select name="film_admer_three" id="" >
										<option value=''>--Select Admer--</option>
										<?php
										foreach ($admer as $admer_row) {
											$selected=($admer_row->article_no==$film_admer_three ? 'selected' : '');
											echo "<option value='".$admer_row->article_no."' $selected ".set_select('film_admer_three',$admer_row->article_no).">".$admer_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="number" name="film_admer_per_three" min="100" max="100" step="any" id="film_admer_per_three" maxlength="3" size="3" value="<?php echo set_value('film_admer_per_three',$this->common_model->select_percentage_from_string($film_admer_per_three));?>" placeholder="%" ></td>
									</tr>

									 <tr>
	                                 <td class="label">HDPE  <span style="color:red;">*</span> :</td>
	                                 <td><select name="film_hdpe_three" >
	                                 <option value=''>--Select HDPE--</option>
	                                 <?php
	                                 foreach ($hdpe as $hdpe_row) {
	                                 	$selected=($hdpe_row->article_no==$film_hdpe_three ? 'selected' : '');
	                                    echo "<option value='".$hdpe_row->article_no."'  $selected ".set_select('film_hdpe_three',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
	                                 }
	                                 ?>
	                                 </select></td>
	                                 <td>
	                                 <input type="number" name="film_hdpe_per_three" min="0"  max="100" step="1" maxlength="3" size="3" value="<?php echo set_value('film_hdpe_per_three',$this->common_model->select_percentage_from_string($film_hdpe_per_three));?>" placeholder="%" ></td>
	                                 </tr>

									

                           <tr><td class="label">&nbsp;</td><td class="label">&nbsp;</td></tr>
									<tr><td class="label"><b>4 Layer</b></td></tr>

									<tr>
										<td class="label">Gauge <span style="color:red;">*</span> :</td>
										<td><input type="number" name="gauge_four" min="15"  max="25" step="1" value="<?php echo set_value('gauge_four',$this->common_model->select_number_from_string($gauge_four));?>" required></td>
									</tr>

									<tr>
										<td class="label">Evoh <span style="color:red;">*</span> :</td>
										<td><select name="film_evoh_four">
										<option value=''>--Select Admer--</option>
										<?php
										foreach ($evoh as $evoh_row) {
											$selected=($evoh_row->article_no==$film_evoh_four ? 'selected' : '');
											echo "<option value='".$evoh_row->article_no."' $selected ".set_select('film_evoh_four',$evoh_row->article_no).">".$evoh_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="number" name="film_evoh_per_four" min="100" max="100" step="any" maxlength="3" size="3" value="<?php echo set_value('film_evoh_per_four',$this->common_model->select_percentage_from_string($film_evoh_per_four));?>" placeholder="%"></td>
									</tr>


									<tr>
	                                 <td class="label">HDPE  <span style="color:red;">*</span> :</td>
	                                 <td><select name="film_hdpe_four" >
	                                 <option value=''>--Select HDPE--</option>
	                                 <?php
	                                 foreach ($hdpe as $hdpe_row) {
	                                 	$selected=($hdpe_row->article_no==$film_hdpe_four ? 'selected' : '');
	                                    echo "<option value='".$hdpe_row->article_no."'  $selected ".set_select('film_hdpe_four',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
	                                 }
	                                 ?>
	                                 </select></td>
	                                 <td>
	                                 <input type="number" name="film_hdpe_per_four" min="0"  max="100" step="1" maxlength="3" size="3" value="<?php echo set_value('film_hdpe_per_four',$this->common_model->select_percentage_from_string($film_hdpe_per_four));?>" placeholder="%" ></td>
	                                </tr>

                           <tr><td class="label">&nbsp;</td><td class="label">&nbsp;</td></tr>
									<tr><td class="label"><b>5 Layer</b></td></tr>

									<tr>
										<td class="label">Gauge <span style="color:red;">*</span> :</td>
										<td><input type="number" name="gauge_five" min="10"  max="20" step="1" maxlength="2" size="2" value="<?php echo set_value('gauge_five',$gauge_five);?>" required></td>
									</tr>

									<tr>
										<td class="label">Admer <span style="color:red;">*</span> :</td>
										<td><select name="film_admer_five" id="film_admer_five">
										<option value=''>--Select Admer--</option>
										<?php
										foreach ($admer as $admer_row) {
											$selected=($admer_row->article_no==$film_admer_five ? 'selected' : '');
											echo "<option value='".$admer_row->article_no."' $selected ".set_select('film_admer_five',$admer_row->article_no).">".$admer_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="number" name="film_admer_per_five" min="100" max="100" step="any" maxlength="3" size="3" value="<?php echo set_value('film_admer_per_three',$this->common_model->select_percentage_from_string($film_admer_per_five));?>" placeholder="%"></td>
									</tr>

									<tr>
	                                 <td class="label">HDPE  <span style="color:red;">*</span> :</td>
	                                 <td><select name="film_hdpe_five" >
	                                 <option value=''>--Select HDPE--</option>
	                                 <?php
	                                 foreach ($hdpe as $hdpe_row) {
	                                 	$selected=($hdpe_row->article_no==$film_hdpe_five ? 'selected' : '');
	                                    echo "<option value='".$hdpe_row->article_no."'  $selected ".set_select('film_hdpe_five',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
	                                 }
	                                 ?>
	                                 </select></td>
	                                 <td>
	                                 <input type="number" name="film_hdpe_per_five" min="0"  max="100" step="1" maxlength="3" size="3" value="<?php echo set_value('film_hdpe_per_five',$this->common_model->select_percentage_from_string($film_hdpe_per_five));?>" placeholder="%" ></td>
	                                </tr>

									<tr><td class="label">&nbsp;</td><td class="label">&nbsp;</td></tr>
									<tr><td class="label"><b>6 Layer</b></td></tr>

									<tr>
										<td class="label">Gauge <span style="color:red;">*</span> :</td>
										<td><input type="number" name="gauge_six"  min="155" max="240" step="1" maxlength="5" size="5" value="<?php echo set_value('gauge_six',$gauge_six);?>" required></td>
									</tr>

									<tr>
                                    <td class="label">MB <span style="color:red;">*</span> :</td>
                                    <td><select name="film_masterbatch_six" required><option value=''>--Select MB--</option>
                                    <?php foreach ($masterbatch as $masterbatch_row) {
                                    	$selected=($masterbatch_row->article_no==$film_mb_six ? 'selected' : '');
                                       echo "<option value='".$masterbatch_row->article_no."' $selected ".set_select('film_masterbatch_six',$masterbatch_row->article_no).">".$masterbatch_row->lang_article_description."</option>";
                                    }?></select></td>

                                    <td><input type="number" name="film_mb_per_six" min="0"  max="25" step="any" maxlength="4" size="4" value="<?php echo set_value('film_mb_per_six',$this->common_model->select_percentage_from_string($film_mb_per_six));?>" placeholder="%" required></td>
	                                 </tr>

	                                 <tr>
										<td class="label">LDPE :</td>
										<td><select name="film_ldpe_six">
										<option value=''>--Select LDPE--</option>
										<?php
										foreach ($ldpe as $ldpe_row) {
											$selected=( $ldpe_row->article_no==$film_ldpe_six ? 'selected' : '');
											echo "<option value='".$ldpe_row->article_no."' $selected ".set_select('film_ldpe_six',$ldpe_row->article_no).">".$ldpe_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="number" name="film_ldpe_per_six"  min="0"  max="100" step="1"  maxlength="3" size="3" value="<?php echo set_value('film_ldpe_per_six',$this->common_model->select_percentage_from_string($film_ldpe_per_six));?>" placeholder="%"></td>
									</tr>

	                                 <tr>
	                                 <td class="label">LLDPE <span style="color:red;">*</span> :</td>
	                                 <td><select name="film_lldpe_six" >
	                                 <option value=''>--Select LLDPE--</option>
	                                 <?php
	                                 foreach ($lldpe as $lldpe_row) {
	                                 	$selected=($lldpe_row->article_no==$film_lldpe_six ? 'selected' : '');
	                                    echo "<option value='".$lldpe_row->article_no."' $selected ".set_select('film_lldpe_six',$lldpe_row->article_no).">".$lldpe_row->lang_article_description."</option>";
	                                 }
	                                 ?>
	                                 </select></td>
	                                 <td>
	                                 <input type="number" name="film_lldpe_per_six" min="0"  max="100" step="1" maxlength="3" size="3" value="<?php echo set_value('film_lldpe_per_six',$this->common_model->select_percentage_from_string($film_lldpe_per_six));?>" placeholder="%" ></td>
	                                 </tr>

	                                 <tr>
	                                 <td class="label">HDPE  <span style="color:red;">*</span> :</td>
	                                 <td><select name="film_hdpe_six" >
	                                 <option value=''>--Select HDPE--</option>
	                                 <?php
	                                 foreach ($hdpe as $hdpe_row) {
	                                 	$selected=($hdpe_row->article_no==$film_hdpe_six ? 'selected' : '');
	                                    echo "<option value='".$hdpe_row->article_no."'  $selected ".set_select('film_hdpe_six',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
	                                 }
	                                 ?>
	                                 </select></td>
	                                 <td>
	                                 <input type="number" name="film_hdpe_per_six" min="0"  max="100" step="1" maxlength="3" size="3" value="<?php echo set_value('film_hdpe_per_six',$this->common_model->select_percentage_from_string($film_hdpe_per_six));?>" placeholder="%" ></td>
	                                 </tr>

	                                <tr><td class="label">&nbsp;</td><td class="label">&nbsp;</td></tr>
									<tr><td class="label"><b>7 Layer</b></td></tr>

									<tr>
										<td class="label">Gauge <span style="color:red;">*</span> :</td>
										<td><input type="number" name="gauge_seven"  min="10" max="20" step="1" maxlength="5" size="5" value="<?php echo set_value('gauge_seven',$gauge_seven);?>" required></td>
									</tr>

									<tr>
	                                 <td class="label">LDPE <span style="color:red;">*</span> :</td>
	                                 <td><select name="film_ldpe_seven" required>
	                                 <option value=''>--Select LDPE--</option>
	                                 <?php
	                                 foreach ($ldpe as $ldpe_row) {
	                                 	$selected=($ldpe_row->article_no==$film_ldpe_seven ? 'selected' : '');
	                                    echo "<option value='".$ldpe_row->article_no."' $selected ".set_select('film_ldpe_seven',$ldpe_row->article_no).">".$ldpe_row->lang_article_description."</option>";
	                                 }
	                                 ?>
	                                 </select></td>
	                                 <td>
	                                 <input type="number" name="film_ldpe_per_seven" min="0"  max="100" step="1" maxlength="3" size="3" value="<?php echo set_value('film_ldpe_per_seven',$this->common_model->select_percentage_from_string($film_ldpe_per_seven));?>" placeholder="%" required></td>
	                                 </tr>

	                                 <tr>
	                                 <td class="label">LLDPE <span style="color:red;">*</span> :</td>
	                                 <td><select name="film_lldpe_seven" required>
	                                 <option value=''>--Select LDPE--</option>
	                                 <?php
	                                 foreach ($lldpe as $lldpe_row) {
	                                 	$selected=($lldpe_row->article_no==$film_lldpe_seven ? 'selected' : '');
	                                    echo "<option value='".$lldpe_row->article_no."' $selected ".set_select('film_lldpe_seven',$lldpe_row->article_no).">".$lldpe_row->lang_article_description."</option>";
	                                 }
	                                 ?>
	                                 </select></td>
	                                 <td>
	                                 <input type="number" name="film_lldpe_per_seven" min="0"  max="100" step="1" maxlength="3" size="3" value="<?php echo set_value('film_lldpe_per_seven',$this->common_model->select_percentage_from_string($film_lldpe_per_seven));?>" placeholder="%" required></td>
	                                 </tr>


                           <tr><td class="label">&nbsp;</td><td class="label">&nbsp;</td></tr>
									<tr>
											<td class="label"><b>Approval Authority</b></td>
											<td><select name="approval_authority">
												<option value=''>--Select Authority--</option>
												<?php 
													foreach ($approval_authority as $approval_authority_row) {
													echo "<option value='".$approval_authority_row->employee_id."' ".set_select('approval_authority',$approval_authority_row->employee_id).">".strtoupper($approval_authority_row->username)."</option>";
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
	  <button class="ui positive button">Update</button>
		</div>
	</div>
		
</form>
<?php endforeach;?>
				
				
				
				
				
			