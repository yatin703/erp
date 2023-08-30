<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		
		$("#customer").autocomplete("<?php echo base_url('index.php/ajax/customer');?>", {selectFirst: true});

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
   alert(arr[2]);
   $("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
   $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/cap_spec_details",data: {cap_spec_no : arr[2],cap_spec_version_no : arr[3]},cache: false,success: function(html){
    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
       $("#cap_spec_details").html(html);
    } 
    });
   });

		$("#article_no").autocomplete("<?php echo base_url('index.php/ajax/article_no');?>", {selectFirst: true});

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
<?php foreach($specification as $specification_row):?>
	<?php
	$result_dia=$this->specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','1_1','srd_id','asc');

	foreach($result_dia as $dia_row){ $dia=$dia_row->relating_master_value; }

	$result_length=$this->specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','1_2','srd_id','asc');

	foreach($result_length as $length_row){ $length=$length_row->parameter_value; }

	$result_gauge=$this->specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','1_4','srd_id','asc');

	foreach($result_gauge as $gauge_row){ $gauge=$gauge_row->parameter_value; }

	$result_print_type=$this->specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','1_7','srd_id','asc');

	foreach($result_print_type as $print_type_row){ $print_types=$print_type_row->relating_master_value; }

	$result_sl_mb=$this->specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','1_5_0','srd_id','asc');

	foreach($result_sl_mb as $sl_mb_row){ $sl_mb=$sl_mb_row->mat_article_no; $sl_mb_per=$sl_mb_row->mat_info;}

	$result_sl_ldpe=$this->specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','1_6_0','srd_id','asc');
	if($result_sl_ldpe==FALSE){
				$sl_ldpe='';
				$sl_ldpe_per='';
			}else{
				foreach($result_sl_ldpe as $sl_ldpe_row){ $sl_ldpe=$sl_ldpe_row->mat_article_no; $sl_ldpe_per=$sl_ldpe_row->mat_info;}
			}

	$result_sl_lldpe=$this->specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','1_6_1','srd_id','asc');
	if($result_sl_lldpe==FALSE){
			$sl_lldpe='';
			$sl_lldpe_per='';
		}else{
			foreach($result_sl_lldpe as $sl_lldpe_row){ $sl_lldpe=$sl_lldpe_row->mat_article_no; $sl_lldpe_per=$sl_lldpe_row->mat_info;}
		}

	
	$result_sl_hdpe=$this->specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','1_6_2','srd_id','asc');
		if($result_sl_hdpe==FALSE){
			$sl_hdpe='';
			$sl_hdpe_per='';
		}else{
			foreach($result_sl_hdpe as $sl_hdpe_row){ $sl_hdpe=$sl_hdpe_row->mat_article_no; $sl_hdpe_per=$sl_hdpe_row->mat_info;}
		}

//Layer 2

		$result_gauge_two=$this->specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','2_4','srd_id','asc');
		if($result_gauge_two==FALSE){
			$gauge_two='';
		}else{
			foreach($result_gauge_two as $gauge_two_row){ $gauge_two=$gauge_two_row->parameter_value; }
		}

		$result_sl_hdpe_two=$this->specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','2_6_2','srd_id','asc');
		if($result_sl_hdpe_two==FALSE){
			$sl_hdpe_two='';
			$sl_hdpe_per_two='';
		}else{
			foreach($result_sl_hdpe_two as $sl_hdpe_two_row){ $sl_hdpe_two=$sl_hdpe_two_row->mat_article_no; $sl_hdpe_per_two=$sl_hdpe_two_row->mat_info;}
		}


		$result_sl_mb_two=$this->specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','2_5_0','srd_id','asc');
		if($result_sl_mb_two==FALSE){
			$sl_mb_two='';
			$sl_mb_per_two='';
		}else{
			foreach($result_sl_mb_two as $sl_mb_two_row){ $sl_mb_two=$sl_mb_two_row->mat_article_no; $sl_mb_per_two=$sl_mb_two_row->mat_info;}
		}
		

		$result_sl_mb_supplier_two=$this->specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','2_5_0','srd_id','asc');
		if($result_sl_mb_supplier_two==FALSE){
			$sl_mbb_two='';
		}else{
			foreach($result_sl_mb_supplier_two as $sl_mb_supplier_two_row){
			$data['sl_mb_supplier_two']=$this->supplier_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$sl_mb_supplier_two_row->supplier_no);
				if($data['sl_mb_supplier_two']==FALSE){
					$sl_mbb_two="";
				}else{
					foreach ($data['sl_mb_supplier_two'] as $sl_mbb_two_row) {
								$sl_mbb_two=$sl_mbb_two_row->name1."//".$sl_mbb_two_row->adr_company_id;
							}
			}

			}
		}

		$result_sl_ldpe_two=$this->specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','2_6_0','srd_id','asc');
	if($result_sl_ldpe_two==FALSE){
				$sl_ldpe_two='';
				$sl_ldpe_per_two='';
			}else{
				foreach($result_sl_ldpe_two as $sl_ldpe_two_row){ $sl_ldpe_two=$sl_ldpe_two_row->mat_article_no; $sl_ldpe_per_two=$sl_ldpe_two_row->mat_info;}
			}

	$result_sl_lldpe_two=$this->specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','2_6_1','srd_id','asc');
	if($result_sl_lldpe_two==FALSE){
			$sl_lldpe_two='';
			$sl_lldpe_per_two='';
		}else{
			foreach($result_sl_lldpe_two as $sl_lldpe_two_row){ $sl_lldpe_two=$sl_lldpe_two_row->mat_article_no; $sl_lldpe_per_two=$sl_lldpe_two_row->mat_info;}
		}


	
		
	//Shoulder

	$result_shoulder=$this->specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','3_2','srd_id','asc');

	foreach($result_shoulder as $shoulder_row){ $shoulder=$shoulder_row->relating_master_value;}

	$result_shoulder_orifice=$this->specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','3_4','srd_id','asc');

	foreach($result_shoulder_orifice as $shoulder_orifice_row){ $shoulder_orifice=$shoulder_orifice_row->relating_master_value;}

	$result_shoulder_foil=$this->specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','3_8','srd_id','asc');

	foreach($result_shoulder_foil as $shoulder_foil_row){ $shoulder_foil=$shoulder_foil_row->parameter_value;}

	$result_shoulder_mb=$this->specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','3_6_0','srd_id','asc');

	foreach($result_shoulder_mb as $shoulder_mb_row){ $shoulder_mb=$shoulder_mb_row->mat_article_no; $shoulder_mb_per=$shoulder_mb_row->mat_info;}

	$result_shoulder_hdpe_one=$this->specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','3_7_0','srd_id','asc');

	if($result_shoulder_hdpe_one==FALSE){
			$shoulder_hdpe_one='';
			$shoulder_hdpe_one_per='';
		}else{
			foreach($result_shoulder_hdpe_one as $shoulder_hdpe_one_row){ $shoulder_hdpe_one=$shoulder_hdpe_one_row->mat_article_no; $shoulder_hdpe_one_per=$shoulder_hdpe_one_row->mat_info;}
		}

	$result_shoulder_hdpe_two=$this->specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','3_7_1','srd_id','asc');

	if($result_shoulder_hdpe_two==FALSE){
				$shoulder_hdpe_two='';
				$shoulder_hdpe_two_per='';
			}else{
			foreach($result_shoulder_hdpe_two as $shoulder_hdpe_two_row){ $shoulder_hdpe_two=$shoulder_hdpe_two_row->mat_article_no; $shoulder_hdpe_two_per=$shoulder_hdpe_two_row->mat_info;}
		}

		$result_cap_spec=$this->specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','4_1','srd_id','asc');
		foreach($result_cap_spec as $cap_spec_row){ 
			$cap_spec=explode('//',$cap_spec_row->parameter_value);

			$result_cap=$this->specification_model->select_one_active_record('specification_sheet',$this->session->userdata['logged_in']['company_id'],'specification_sheet.spec_id',$cap_spec[0],'specification_sheet.spec_version_no',$cap_spec[1]);
			foreach($result_cap as $result_cap_row){
				$cap_article_no=$result_cap_row->article_name."//".$result_cap_row->article_no."//".$result_cap_row->spec_id."//".$result_cap_row->spec_version_no;
			}
		}

	$result_cap_type=$this->specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','4_2','srd_id','asc');

	foreach($result_cap_type as $cap_type_row){ $cap_types=$cap_type_row->relating_master_value;}

	$result_cap_finish=$this->specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','4_3','srd_id','asc');

	foreach($result_cap_finish as $cap_finish_row){ $cap_finishs=$cap_finish_row->relating_master_value;}

	$result_cap_dia=$this->specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','4_4','srd_id','asc');

	foreach($result_cap_dia as $cap_dia_row){ $cap_dias=$cap_dia_row->relating_master_value;}

	$result_cap_orifice=$this->specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','4_6','srd_id','asc');

	foreach($result_cap_orifice as $cap_orifice_row){ $cap_orifices=$cap_orifice_row->relating_master_value;}

	$result_cap_mb=$this->specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','4_7_0','srd_id','asc');

	foreach($result_cap_mb as $cap_mb_row){ $cap_mb=$cap_mb_row->mat_article_no; $cap_mb_per=$cap_mb_row->mat_info;}

	$result_cap_pp=$this->specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','4_8_1','srd_id','asc');

	foreach($result_cap_pp as $cap_pp_row){ $cap_pp=$cap_pp_row->mat_article_no; $cap_pp_per=$cap_pp_row->mat_info;}

	$result_cap_foil_color=$this->specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','4_9','srd_id','asc');

	foreach($result_cap_foil_color as $cap_foil_color_row){ $cap_foil_color=$cap_foil_color_row->parameter_value;}

	$result_cap_foil_width=$this->specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','4_10','srd_id','asc');

	foreach($result_cap_foil_width as $cap_foil_width_row){ $cap_foil_width=$cap_foil_width_row->parameter_value;}

	$result_cap_foil_dist=$this->specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','4_11','srd_id','asc');

	foreach($result_cap_foil_dist as $cap_foil_dist_row){ $cap_foil_dist=$cap_foil_dist_row->parameter_value;}

	$result_sl_mb_supplier=$this->specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','1_5_0','srd_id','asc');
	foreach($result_sl_mb_supplier as $sl_mb_supplier_row){
		$data['sl_mb_supplier']=$this->supplier_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$sl_mb_supplier_row->supplier_no);
		if($data['sl_mb_supplier']==FALSE){
			$sl_mbb="";
		}else{
				foreach ($data['sl_mb_supplier'] as $sl_mbb_row) {
				$sl_mbb=$sl_mbb_row->name1."//".$sl_mbb_row->adr_company_id;
			}
		}
		
	}


	$result_sh_mb_supplier=$this->specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','3_6_0','srd_id','asc');
	foreach($result_sh_mb_supplier as $sh_mb_supplier_row){
		$data['sh_mb_supplier']=$this->supplier_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$sh_mb_supplier_row->supplier_no);
		if($data['sh_mb_supplier']==FALSE){
			$sh_mbb="";
		}else{
			foreach ($data['sh_mb_supplier'] as $sh_mbb_row) {
			$sh_mbb=$sh_mbb_row->name1."//".$sh_mbb_row->adr_company_id;
			}
		}
	}


	$result_cap_mb_supplier=$this->specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','4_7_0','srd_id','asc');
	foreach($result_cap_mb_supplier as $cap_mb_supplier_row){
		$data['cap_mb_supplier']=$this->supplier_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$cap_mb_supplier_row->supplier_no);
		if($data['cap_mb_supplier']==FALSE){
			$cap_mbb="";
		}else{
			foreach ($data['cap_mb_supplier'] as $cap_mbb_row) {
				$cap_mbb=$cap_mbb_row->name1."//".$cap_mbb_row->adr_company_id;
			}
		}
	}

	



	?>
<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save_two_layer_with_cap_copy');?>" method="POST" >


	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">

									<tr>
										<td class="label">Spec Id * :</td>
										<td><input type="text" name="spec_id"  value="<?php echo set_value('spec_id',$specification_row->spec_id);?>" readonly/>
										<input type="hidden" name="record_no" value="<?php echo $specification_row->spec_id.'@@@'.$specification_row->spec_version_no;?>"></td>
									</tr>


									<tr>
										<td class="label">Customer * :</td>
										<td><input type="text" name="customer" id="customer" size="60" value="<?php echo set_value('customer',$specification_row->customer_name."//".$specification_row->adr_company_id);?>" /></td>
									</tr>

									<tr>
										<td class="label">Article  * :</td>
										<td><input type="text" name="article_no" id="article_no" size="60" value="<?php echo set_value('article_no',$specification_row->article_name."//".$specification_row->article_no);?>" /></td>
									</tr>

									<tr>
										<td class="label">Version No * :</td>
										<td><select name="spec_version_no" id="spec_version_no" readonly>
										<?php 
											$data['spec_version']=$this->specification_model->select_specification_verion_no('specification_sheet',$this->session->userdata['logged_in']['company_id'],'article_no',$specification_row->article_no);
              foreach ($data['spec_version'] as $spec_version_row) {
              	if($spec_version_row->spec_version_no==NULL){
                  $spec_version_no=1;
                }else{
                  $spec_version_no=$spec_version_row->spec_version_no;
                }
              }
              ?>
              <option value="<?php echo $spec_version_no;?>"><?php echo $spec_version_no;?></option>
										</select>
										<?php 
										if($this->input->post('copy_version_no')){
											echo '<input type="hidden" name="copy_version_no" value="'.$this->input->post('copy_version_no').'">';

										}else{
											echo '<input type="hidden" name="copy_version_no" value="'.$this->uri->segment(4).'">';
										}?></td>
									</tr>

									<tr>
										<td class="label">Artwork :</td>
										<td><select id="artwork_final_version_no" name="artwork_final_version_no">
										<?php if($specification_row->ad_id==''){
											//echo "<option value=''>No Artwork is attached</option>";

											$data['artwork_final_nonapproved_version_no']=$this->artwork_model->select_artwork_final_version('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'article_no',$specification_row->article_no,'final_approval_flag','0','archive<>','1','ad_date','desc','ad_id','desc','version_no','desc');

        			$data['artwork_final_version_no']=$this->artwork_model->select_artwork_final_version('artwork_devel_master',$this->session->userdata['logged_in']['company_id'],'article_no',$specification_row->article_no,'final_approval_flag','1','archive<>','1','ad_date','desc','ad_id','desc','version_no','desc');

											if($data['artwork_final_nonapproved_version_no']==FALSE){
						          $nonapproved_version=0;
														//echo "<option value=''>--//Setup Required--</option>";
										  }else{
						          foreach ($data['artwork_final_nonapproved_version_no'] as $artwork_final_nonapproved_version_no_row){
						            $nonapproved_version=$artwork_final_nonapproved_version_no_row->version_no;
						     	    }
						        } 

						        if($data['artwork_final_version_no']==FALSE){
						            $approved_version=0;
						            //echo "<option value=''>--Setup Required--</option>";
						            }else{
						          foreach ($data['artwork_final_version_no'] as $artwork_final_version_no_row){
						            $approved_version=$artwork_final_version_no_row->version_no;
						            //echo "<option value='".$artwork_final_version_no_row->ad_id."' ".set_select('artwork_final_version_no',''.$artwork_final_version_no_row->version_no.'').">".$artwork_final_version_no_row->ad_id."_R".$artwork_final_version_no_row->version_no."</option>";
						              }     
						          }

						        if($nonapproved_version>$approved_version){
						      	   echo "<option value=''>--Final Version is in Process</option>";
						        }else{
						          if($data['artwork_final_version_no']==FALSE){
						      	   //echo "<option value=''>--Setup Required--</option>";
						          }else{
						      				foreach ($data['artwork_final_version_no'] as $artwork_final_version_no_row){
						      				echo "<option value='".$artwork_final_version_no_row->ad_id."_R".$artwork_final_version_no_row->version_no."' ".set_select('artwork_final_version_no',''.$artwork_final_version_no_row->ad_id.'_R'.$artwork_final_version_no_row->version_no.'').">".$artwork_final_version_no_row->ad_id."_R".$artwork_final_version_no_row->version_no."</option>";
						            }     
						      	 }

						        }
										}else{
											echo '<option value='.$specification_row->ad_id."_R".$specification_row->version_no.'>'.$specification_row->ad_id."_R".$specification_row->version_no.'</option>';
											}
											?>
										</select></td>
									</tr>
								

									<tr><td class="label"><b>Tube Information</b></td></tr>

									<tr>
										<td class="label">Dia * :</td>
										<td><select name="sleeve_dia" id="sleeve_dia"><option value=''>--Select Sleeve Dia--</option>
										<?php if($sleeve_dia==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($sleeve_dia as $sleeve_dia_row){
													$selected=($sleeve_dia_row->sleeve_diameter==$dia ? 'selected' :'');
													echo "<option value='".$sleeve_dia_row->sleeve_diameter."//".$sleeve_dia_row->sleeve_id."'  ".set_select('sleeve_dia',''.$sleeve_dia_row->sleeve_diameter.'//'.$sleeve_dia_row->sleeve_id.'')." $selected>".$sleeve_dia_row->sleeve_diameter."</option>";
												}
										}?></select></td>
									</tr>

									<tr>
											<td class="label">Length * : </td>
											<td><input type="text" name="sleeve_length" size="10" value="<?php echo set_value('sleeve_length',$this->common_model->select_number_from_string($length));?>"></td>
										</tr>

									<tr>
										<td class="label">Print Type * :</td>
										<td><select name="print_type"><option value=''>--Select Print Type--</option>
										<?php if($print_type==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($print_type as $print_type_row){
													$selected=($print_type_row->lacquer_type==$print_types ? 'selected' :'');
													echo "<option value='".$print_type_row->lacquer_type."'  $selected ".set_select('print_type',''.$print_type_row->lacquer_type.'').">".$print_type_row->lacquer_type."</option>";
												}
										}?></select></td>
									</tr>

									<tr><td class="label"><b>Layer 1</b></td></tr>

									<tr>
										<td class="label">Gauge * :</td>
										<td><input type="text" name="gauge_one" maxlength="3" size="3" value="<?php echo set_value('gauge_one',$this->common_model->select_number_from_string($gauge));?>"></td>
									</tr>

									<tr>
										<td class="label">MB * :</td>
										<td><select name="sl_masterbatch_one"><option value=''>--Select MB--</option>
										<?php foreach ($masterbatch as $masterbatch_row) {
											$selected=($masterbatch_row->article_no==$sl_mb ? 'selected' : '');
											echo "<option value='".$masterbatch_row->article_no."' $selected ".set_select('sl_masterbatch_one',$masterbatch_row->article_no).">".$masterbatch_row->lang_article_description."</option>";
										}?></select></td>

										<td>
										<input type="text" name="sl_mb_per_one" maxlength="3" size="3" value="<?php echo set_value('sl_mb_per_one',$this->common_model->select_percentage_from_string($sl_mb_per));?>" placeholder="%">
										<input type="text" name="sl_mb_supplier_one" class="supplier" value="<?php echo set_value('sl_mb_supplier_one',$sl_mbb);?>" placeholder="MB Supplier">
										</td>
										</tr>

										<tr>
										<td class="label">LDPE * :</td>
										<td><select name="sl_ldpe_one">
										<option value=''>--Select LDPE--</option>
										<?php
										foreach ($ldpe as $ldpe_row) {
											$selected=( $ldpe_row->article_no==$sl_ldpe ? 'selected' : '');
											echo "<option value='".$ldpe_row->article_no."' $selected ".set_select('sl_ldpe_one',$ldpe_row->article_no).">".$ldpe_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="text" name="sl_ldpe_per_one" maxlength="3" size="3" value="<?php echo set_value('sl_ldpe_per_one',$this->common_model->select_percentage_from_string($sl_ldpe_per));?>" placeholder="%"></td>
										</tr>

										<tr>
										<td class="label">LLDPE * :</td>
										<td><select name="sl_lldpe_one">
										<option value=''>--Select LLDPE--</option>
										<?php
										foreach ($lldpe as $lldpe_row) {
											$selected=($lldpe_row->article_no==$sl_lldpe ? 'selected' : '');
											echo "<option value='".$lldpe_row->article_no."' $selected ".set_select('sl_lldpe_one',$lldpe_row->article_no).">".$lldpe_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="text" name="sl_lldpe_per_one" maxlength="3" size="3" value="<?php echo set_value('sl_lldpe_per_one',$this->common_model->select_percentage_from_string($sl_lldpe_per));?>" placeholder="%"></td>
										</tr>

										<tr>
										<td class="label">HDPE * :</td>
										<td><select name="sl_hdpe_one">
										<option value=''>--Select HDPE--</option>
										<?php
										foreach ($hdpe as $hdpe_row) {
											$selected=($hdpe_row->article_no==$sl_hdpe ? 'selected' : '');
											echo "<option value='".$hdpe_row->article_no."' $selected ".set_select('sl_hdpe_one',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="text" name="sl_hdpe_per_one" maxlength="3" size="3" value="<?php echo set_value('sl_hdpe_per_one',$this->common_model->select_percentage_from_string($sl_hdpe_per));?>" placeholder="%"></td>
										</tr>

									<tr><td class="label"><b>Layer 2</b></td></tr>

									<tr>
										<td class="label">Gauge * :</td>
										<td><input type="text" name="gauge_two" maxlength="3" size="3" value="<?php echo set_value('gauge_two',$this->common_model->select_number_from_string($gauge_two));?>"></td>
									</tr>

									<tr>
										<td class="label">MB * :</td>
										<td><select name="sl_masterbatch_two"><option value=''>--Select MB--</option>
										<?php foreach ($masterbatch as $masterbatch_row) {
											$selected=($masterbatch_row->article_no==$sl_mb_two ? 'selected' : '');
											echo "<option value='".$masterbatch_row->article_no."' $selected ".set_select('sl_masterbatch_two',$masterbatch_row->article_no).">".$masterbatch_row->lang_article_description."</option>";
										}?></select></td>

										<td>
										<input type="text" name="sl_mb_per_two" maxlength="3" size="3" value="<?php echo set_value('sl_mb_per_two',$this->common_model->select_percentage_from_string($sl_mb_per_two));?>" placeholder="%">
										<input type="text" name="sl_mb_supplier_two" class="supplier" value="<?php echo set_value('sl_mb_supplier_two',$sl_mbb_two);?>" placeholder="MB Supplier">
										</td>
										</tr>

										<tr>
										<td class="label">LDPE * :</td>
										<td><select name="sl_ldpe_two">
										<option value=''>--Select LDPE--</option>
										<?php
										foreach ($ldpe as $ldpe_row) {
											$selected=( $ldpe_row->article_no==$sl_ldpe_two ? 'selected' : '');
											echo "<option value='".$ldpe_row->article_no."' $selected ".set_select('sl_ldpe_two',$ldpe_row->article_no).">".$ldpe_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="text" name="sl_ldpe_per_two" maxlength="3" size="3" value="<?php echo set_value('sl_ldpe_per_two',$this->common_model->select_percentage_from_string($sl_ldpe_per_two));?>" placeholder="%"></td>
										</tr>

										<tr>
										<td class="label">LLDPE * :</td>
										<td><select name="sl_lldpe_two">
										<option value=''>--Select LLDPE--</option>
										<?php
										foreach ($lldpe as $lldpe_row) {
											$selected=($lldpe_row->article_no==$sl_lldpe_two ? 'selected' : '');
											echo "<option value='".$lldpe_row->article_no."' $selected ".set_select('sl_lldpe_two',$lldpe_row->article_no).">".$lldpe_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="text" name="sl_lldpe_per_two" maxlength="3" size="3" value="<?php echo set_value('sl_lldpe_per_two',$this->common_model->select_percentage_from_string($sl_lldpe_per_two));?>" placeholder="%"></td>
										</tr>

										<tr>
										<td class="label">HDPE * :</td>
										<td><select name="sl_hdpe_two">
										<option value=''>--Select HDPE--</option>
										<?php
										foreach ($hdpe as $hdpe_row) {
											$selected=($hdpe_row->article_no==$sl_hdpe_two ? 'selected' : '');
											echo "<option value='".$hdpe_row->article_no."' $selected ".set_select('sl_hdpe_two',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="text" name="sl_hdpe_per_two" maxlength="3" size="3" value="<?php echo set_value('sl_hdpe_per_two',$this->common_model->select_percentage_from_string($sl_hdpe_per_two));?>" placeholder="%"></td>
										</tr>

									<tr><td class="label"><b>Shoulder Information</b></td></tr>

									<tr>
										<td class="label">Shoulder * :</td>
										<td><select name="shoulder" id="shoulder"><option value=''>--Select Shoulder--</option>
										<?php if($shoulder_types==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($shoulder_types as $shoulder_types_row){
													$selected=($shoulder_types_row->shoulder_type==$shoulder ? 'selected' :'');
													echo "<option value='".$shoulder_types_row->shoulder_type."//".$shoulder_types_row->shld_type_id."' $selected ".set_select('shoulder',''.$shoulder_types_row->shoulder_type.'//'.$shoulder_types_row->shld_type_id.'').">".$shoulder_types_row->shoulder_type."</option>";
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
														$selected=($shoulder_orifice_row->shoulder_orifice==$shoulder_orifice ? 'selected' :'');
														echo "<option value='".$shoulder_orifice_row->shoulder_orifice."//".$shoulder_orifice_row->orifice_id."' $selected ".set_select('shoulder_orifice',''.$shoulder_orifice_row->shoulder_orifice.'//'.$shoulder_orifice_row->orifice_id.'').">".$shoulder_orifice_row->shoulder_orifice."</option>";
													}
											}?></select></td>
									</tr>

									<tr>
											<td class="label">Shoulder Foil Tag * : </td>
											<td><input type="text" name="shoulder_foil_tag" size="10" value="<?php echo set_value('shoulder_foil_tag',$shoulder_foil);?>"></td>
										</tr>

									<tr>
										<td class="label">MB * :</td>
										<td><select name="sh_masterbatch">
										<option value=''>--Select MB--</option>
										<?php
										foreach ($masterbatch as $masterbatch_row) {
											$selected=($masterbatch_row->article_no==$shoulder_mb ? 'selected' : '');
											echo "<option value='".$masterbatch_row->article_no."' $selected ".set_select('sh_masterbatch',$masterbatch_row->article_no).">".$masterbatch_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="text" name="sh_mb_per" maxlength="3" size="3" value="<?php echo set_value('sh_mb_per',$this->common_model->select_percentage_from_string($shoulder_mb_per));?>" placeholder="%">
										<input type="text" name="sh_mb_supplier" class="supplier" value="<?php echo set_value('sh_mb_supplier',$sh_mbb);?>" placeholder="MB Supplier">
										</td>

										
									</tr>

										<tr>
										<td class="label">HDPE * :</td>
										<td><select name="sh_hdpe_one">
										<option value=''>--Select HDPE--</option>
										<?php
										foreach ($hdpe as $hdpe_row) {
											$selected=($hdpe_row->article_no==$shoulder_hdpe_one ? 'selected' : '');
											echo "<option value='".$hdpe_row->article_no."' $selected ".set_select('sh_hdpe_one',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td><input type="text" name="sh_hdpe_one_per" maxlength="3" size="3" value="<?php echo set_value('sh_hdpe_one_per',$this->common_model->select_percentage_from_string($shoulder_hdpe_one_per));?>" placeholder="%"></td>
										</tr>

										<tr>
										<td class="label">HDPE * :</td>
										<td><select name="sh_hdpe_two">
										<option value=''>--Select HDPE--</option>
										<?php
										foreach ($hdpe as $hdpe_row) {
											$selected=($hdpe_row->article_no==$shoulder_hdpe_two ? 'selected' : '');
											echo "<option value='".$hdpe_row->article_no."' $selected ".set_select('sh_hdpe_two',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="text" name="sh_hdpe_two_per" maxlength="3" size="3" value="<?php echo set_value('sh_hdpe_two_per',$this->common_model->select_percentage_from_string($shoulder_hdpe_two_per));?>" placeholder="%"></td>
										</tr>

									<tr>
										<td class="label"><b>ATTACH CAP</b></td>
									</tr>

									<tr>
										<td class="label">Cap Spec No <span style="color:red;">*</span> :</td>
										<td><input type="text" name="cap_spec_no" id="cap_spec_no" size="60" value="<?php echo set_value('cap_spec_no',$cap_spec[0]);?>" /></td>
									</tr>

									<tr>
										<td class="label">Version No <span style="color:red;">*</span> :</td>
										<td><select id="cap_spec_version_no" name="cap_spec_version_no">
										<?php
										if($this->input->post('cap_spec_version_no')){
											echo '<option value="'.$cap_spec[1].'">'.$cap_spec[1].'</option>';
										}else{
											echo '<option value="'.$cap_spec[1].'">'.$cap_spec[1].'</option>';
										}
										?>
										</select></td>
										
										</tr>


									<tr>
										<td class="label"><b></b></td>
										<td>OR</td>
									</tr>

									<tr>
										<td class="label">Cap Article  <span style="color:red;">*</span> :</td>
										<td><input type="text" name="cap_article_no" id="cap_article_no" size="60" value="<?php echo set_value('cap_article_no',$cap_article_no);?>" /></td>
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
	  <button class="ui positive button">Save Copy</button>
		</div>
	</div>
		
</form>
<?php endforeach;?>
				
				
				
				
				
			