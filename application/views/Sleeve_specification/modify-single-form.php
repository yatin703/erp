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


   $("#gauge").live('keyup',function() {

   if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0,2);}else{var sleeve_dia="";}

   if($("#sleeve_length").val()!=''){ var sleeve_length=$("#sleeve_length").val();}else{var sleeve_length="";}

   if($("#gauge").val()!=''){ var gauge=$("#gauge").val()+"MIC";}else{var gauge="";}

			if(gauge!=''){
				$("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"X"+sleeve_length+"</span>+<span class='ui teal label'>1 LAYER</span><br>+<br/><span class='ui teal label'>"+gauge+"</span>");
			}else{
				$("#article_name").html('');
			}

   });



   $("#sl_masterbatch").change(function(event) {

   if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0,2);}else{var sleeve_dia="";}

   if($("#sleeve_length").val()!=''){ var sleeve_length=$("#sleeve_length").val();}else{var sleeve_length="";}

   if($("#gauge").val()!=''){ var gauge=$("#gauge").val()+"MIC";}else{var gauge="";}

   if($("#sl_masterbatch option:selected").val()!=''){ var sl_masterbatch=$("#sl_masterbatch option:selected").text();}else{ var sl_masterbatch="";}

			if(sl_masterbatch!=''){
				$("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"X"+sleeve_length+"</span>+<span class='ui teal label'>1 LAYER</span><br>+<br/><span class='ui teal label'>"+sl_masterbatch+"</span>");
			}else{
				$("#article_name").html('');
			}
		});


	$("#sl_mb_per").live('keyup',function(){

   if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0,2);}else{var sleeve_dia="";}

   if($("#sleeve_length").val()!=''){ var sleeve_length=$("#sleeve_length").val();}else{var sleeve_length="";}

   if($("#gauge").val()!=''){ var gauge=$("#gauge").val()+"MIC";}else{var gauge="";}

   if($("#sl_masterbatch option:selected").val()!=''){ var sl_masterbatch=$("#sl_masterbatch option:selected").text();}else{ var sl_masterbatch="";}

   if($("#sl_mb_per").val()!=''){ var sl_mb_per=$("#sl_mb_per").val()+"%";}else{var sl_mb_per="";}

			if(sl_mb_per!=''){
				$("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"X"+sleeve_length+"</span>+<span class='ui teal label'>1 LAYER</span><br>+<br/><span class='ui teal label'>"+gauge+"</span><br>+<br/><span class='ui teal label'>"+sl_masterbatch+" "+sl_mb_per+"</span>");
			}else{
				$("#article_name").html('');
			}
		});


   $("#sl_ldpe").change(function(event) {

   if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0,2);}else{var sleeve_dia="";}

   if($("#sleeve_length").val()!=''){ var sleeve_length=$("#sleeve_length").val();}else{var sleeve_length="";}

   if($("#gauge").val()!=''){ var gauge=$("#gauge").val()+"MIC";}else{var gauge="";}

   if($("#sl_masterbatch option:selected").val()!=''){ var sl_masterbatch=$("#sl_masterbatch option:selected").text();}else{ var sl_masterbatch="";}

   if($("#sl_mb_per").val()!=''){ var sl_mb_per=$("#sl_mb_per").val()+"%";}else{var sl_mb_per="";}

   if($("#sl_ldpe option:selected").val()!=''){ var sl_ldpe=$("#sl_ldpe option:selected").text();}else{var sl_ldpe="";}

			if(sl_ldpe!=''){
				$("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"X"+sleeve_length+"</span>+<span class='ui teal label'>1 LAYER</span><br>+<br/><span class='ui teal label'>"+gauge+"</span><br>+<br/><span class='ui teal label'>"+sl_masterbatch+" "+sl_mb_per+"</span><br>+<br/><span class='ui teal label'>"+sl_ldpe+"</span>");
			}else{
				$("#article_name").html('');
			}

   });


   $("#sl_ldpe_per").live('keyup',function() {

   if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0,2);}else{var sleeve_dia="";}

   if($("#sleeve_length").val()!=''){ var sleeve_length=$("#sleeve_length").val();}else{var sleeve_length="";}

   if($("#gauge").val()!=''){ var gauge=$("#gauge").val()+"MIC";}else{var gauge="";}

   if($("#sl_masterbatch option:selected").val()!=''){ var sl_masterbatch=$("#sl_masterbatch option:selected").text();}else{ var sl_masterbatch="";}

   if($("#sl_mb_per").val()!=''){ var sl_mb_per=$("#sl_mb_per").val()+"%";}else{var sl_mb_per="";}

   if($("#sl_ldpe_per").val()!=''){ var sl_ldpe_per=$("#sl_ldpe_per").val()+"%";}else{var sl_ldpe_per="";}

   if($("#sl_ldpe option:selected").val()!=''){ var sl_ldpe=$("#sl_ldpe option:selected").text();}else{ var sl_ldpe="";}

			if(sl_ldpe_per!=''){
				$("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"X"+sleeve_length+"</span>+<span class='ui teal label'>1 LAYER</span><br>+<br/><span class='ui teal label'>"+gauge+"</span><br>+<br/><span class='ui teal label'>"+sl_masterbatch+" "+sl_mb_per+"</span><br>+<br/><span class='ui teal label'>"+sl_ldpe+" "+sl_ldpe_per+"</span>");
			}else{
				$("#article_name").html('');
			}

   });


   $("#sl_lldpe").change(function(event) {

   if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0,2);}else{var sleeve_dia="";}

   if($("#sleeve_length").val()!=''){ var sleeve_length=$("#sleeve_length").val();}else{var sleeve_length="";}

   if($("#gauge").val()!=''){ var gauge=$("#gauge").val()+"MIC";}else{var gauge="";}

   if($("#sl_masterbatch option:selected").val()!=''){ var sl_masterbatch=$("#sl_masterbatch option:selected").text();}else{ var sl_masterbatch="";}

   if($("#sl_mb_per").val()!=''){ var sl_mb_per=$("#sl_mb_per").val()+"%";}else{var sl_mb_per="";}

   if($("#sl_ldpe_per").val()!=''){ var sl_ldpe_per=$("#sl_ldpe_per").val()+"%";}else{var sl_ldpe_per="";}

   if($("#sl_ldpe option:selected").val()!=''){ var sl_ldpe=$("#sl_ldpe option:selected").text();}else{ var sl_ldpe="";}

   if($("#sl_lldpe option:selected").val()!=''){ var sl_lldpe=$("#sl_lldpe option:selected").text();}else{ var sl_lldpe="";}

			if(sl_lldpe!=''){
				$("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"X"+sleeve_length+"</span>+<span class='ui teal label'>1 LAYER</span><br>+<br/><span class='ui teal label'>"+gauge+"</span><br>+<br/><span class='ui teal label'>"+sl_masterbatch+" "+sl_mb_per+"</span><br>+<br/><span class='ui teal label'>"+sl_ldpe+" "+sl_ldpe_per+"</span><br>+<br/><span class='ui teal label'>"+sl_lldpe+"</span>");
			}else{
				$("#article_name").html('');
			}

   });


   $("#sl_lldpe_per").live('keyup',function() {

   if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0,2);}else{var sleeve_dia="";}

   if($("#sleeve_length").val()!=''){ var sleeve_length=$("#sleeve_length").val();}else{var sleeve_length="";}

   if($("#gauge").val()!=''){ var gauge=$("#gauge").val()+"MIC";}else{var gauge="";}

   if($("#sl_masterbatch option:selected").val()!=''){ var sl_masterbatch=$("#sl_masterbatch option:selected").text();}else{ var sl_masterbatch="";}

   if($("#sl_mb_per").val()!=''){ var sl_mb_per=$("#sl_mb_per").val()+"%";}else{var sl_mb_per="";}

   if($("#sl_ldpe_per").val()!=''){ var sl_ldpe_per=$("#sl_ldpe_per").val()+"%";}else{var sl_ldpe_per="";}

   if($("#sl_ldpe option:selected").val()!=''){ var sl_ldpe=$("#sl_ldpe option:selected").text();}else{ var sl_ldpe="";}

   if($("#sl_lldpe option:selected").val()!=''){ var sl_lldpe=$("#sl_lldpe option:selected").text();}else{ var sl_lldpe="";}

   if($("#sl_lldpe_per").val()!=''){ var sl_lldpe_per=$("#sl_lldpe_per").val()+"%";}else{var sl_lldpe_per="";}

			if(sl_lldpe_per!=''){
				$("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"X"+sleeve_length+"</span>+<span class='ui teal label'>1 LAYER</span><br>+<br/><span class='ui teal label'>"+gauge+"</span><br>+<br/><span class='ui teal label'>"+sl_masterbatch+" "+sl_mb_per+"</span><br>+<br/><span class='ui teal label'>"+sl_ldpe+" "+sl_ldpe_per+"</span><br>+<br/><span class='ui teal label'>"+sl_lldpe+" "+sl_lldpe_per+"</span>");
			}else{
				$("#article_name").html('');
			}

   });


   $("#sl_hdpe").change(function(event) {

   if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0,2);}else{var sleeve_dia="";}

   if($("#sleeve_length").val()!=''){ var sleeve_length=$("#sleeve_length").val();}else{var sleeve_length="";}

   if($("#gauge").val()!=''){ var gauge=$("#gauge").val()+"MIC";}else{var gauge="";}

   if($("#sl_masterbatch option:selected").val()!=''){ var sl_masterbatch=$("#sl_masterbatch option:selected").text();}else{ var sl_masterbatch="";}

   if($("#sl_mb_per").val()!=''){ var sl_mb_per=$("#sl_mb_per").val()+"%";}else{var sl_mb_per="";}

   if($("#sl_ldpe_per").val()!=''){ var sl_ldpe_per=$("#sl_ldpe_per").val()+"%";}else{var sl_ldpe_per="";}

   if($("#sl_ldpe option:selected").val()!=''){ var sl_ldpe=$("#sl_ldpe option:selected").text();}else{ var sl_ldpe="";}

   if($("#sl_lldpe option:selected").val()!=''){ var sl_lldpe=$("#sl_lldpe option:selected").text();}else{ var sl_lldpe="";}

   if($("#sl_hdpe option:selected").val()!=''){ var sl_hdpe=$("#sl_hdpe option:selected").text();}else{ var sl_hdpe="";}

			if(sl_hdpe!=''){
				$("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"X"+sleeve_length+"</span>+<span class='ui teal label'>1 LAYER</span><br>+<br/><span class='ui teal label'>"+gauge+"</span><br>+<br/><span class='ui teal label'>"+sl_masterbatch+" "+sl_mb_per+"</span><br>+<br/><span class='ui teal label'>"+sl_ldpe+" "+sl_ldpe_per+"</span><br>+<br/><span class='ui teal label'>"+sl_lldpe+"</span><br>+<br/><span class='ui teal label'>"+sl_hdpe+"</span>");
			}else{
				$("#article_name").html('');
			}

   });


   $("#sl_hdpe_per").live('keyup',function() {

   if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0,2);}else{var sleeve_dia="";}

   if($("#sleeve_length").val()!=''){ var sleeve_length=$("#sleeve_length").val();}else{var sleeve_length="";}

   if($("#gauge").val()!=''){ var gauge=$("#gauge").val()+"MIC";}else{var gauge="";}

   if($("#sl_masterbatch option:selected").val()!=''){ var sl_masterbatch=$("#sl_masterbatch option:selected").text();}else{ var sl_masterbatch="";}

   if($("#sl_mb_per").val()!=''){ var sl_mb_per=$("#sl_mb_per").val()+"%";}else{var sl_mb_per="";}

   if($("#sl_ldpe_per").val()!=''){ var sl_ldpe_per=$("#sl_ldpe_per").val()+"%";}else{var sl_ldpe_per="";}

   if($("#sl_ldpe option:selected").val()!=''){ var sl_ldpe=$("#sl_ldpe option:selected").text();}else{ var sl_ldpe="";}

   if($("#sl_lldpe option:selected").val()!=''){ var sl_lldpe=$("#sl_lldpe option:selected").text();}else{ var sl_lldpe="";}

   if($("#sl_lldpe_per").val()!=''){ var sl_lldpe_per=$("#sl_lldpe_per").val()+"%";}else{var sl_lldpe_per="";}

   if($("#sl_hdpe option:selected").val()!=''){ var sl_hdpe=$("#sl_hdpe option:selected").text();}else{ var sl_hdpe="";}

   if($("#sl_hdpe_per").val()!=''){ var sl_hdpe_per=$("#sl_hdpe_per").val()+"%";}else{var sl_hdpe_per="";}

			if(sl_lldpe_per!=''){
				$("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"X"+sleeve_length+"</span>+<span class='ui teal label'>1 LAYER</span><br>+<br/><span class='ui teal label'>"+gauge+"</span><br>+<br/><span class='ui teal label'>"+sl_masterbatch+" "+sl_mb_per+"</span><br>+<br/><span class='ui teal label'>"+sl_ldpe+" "+sl_ldpe_per+"</span><br>+<br/><span class='ui teal label'>"+sl_lldpe+" "+sl_lldpe_per+"</span><br>+<br/><span class='ui teal label'>"+sl_hdpe+" "+sl_hdpe_per+"</span>");
			}else{
				$("#article_name").html('');
			}

   });






  


			$(".form_table_inner").live('mouseover',function(){

			if($("#sleeve_dia option:selected").val()!=''){

   if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text().substr(0,2);}else{var sleeve_dia="";}

   if($("#sleeve_length").val()!=''){ var sleeve_length=$("#sleeve_length").val();}else{var sleeve_length="";}

   if($("#gauge").val()!=''){ var gauge=$("#gauge").val()+"MIC";}else{var gauge="";}

   if($("#sl_masterbatch option:selected").val()!=''){ var sl_masterbatch=$("#sl_masterbatch option:selected").text();}else{ var sl_masterbatch="";}

   if($("#sl_mb_per").val()!=''){ var sl_mb_per=$("#sl_mb_per").val()+"%";}else{var sl_mb_per="";}

   if($("#sl_ldpe_per").val()!=''){ var sl_ldpe_per=$("#sl_ldpe_per").val()+"%";}else{var sl_ldpe_per="";}

   if($("#sl_ldpe option:selected").val()!=''){ var sl_ldpe=$("#sl_ldpe option:selected").text();}else{ var sl_ldpe="";}

   if($("#sl_lldpe option:selected").val()!=''){ var sl_lldpe=$("#sl_lldpe option:selected").text();}else{ var sl_lldpe="";}

   if($("#sl_lldpe_per").val()!=''){ var sl_lldpe_per=$("#sl_lldpe_per").val()+"%";}else{var sl_lldpe_per="";}

   if($("#sl_hdpe option:selected").val()!=''){ var sl_hdpe=$("#sl_hdpe option:selected").text();}else{ var sl_hdpe="";}

   if($("#sl_hdpe_per").val()!=''){ var sl_hdpe_per=$("#sl_hdpe_per").val()+"%";}else{var sl_hdpe_per="";}

   $("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"X"+sleeve_length+"</span>+<span class='ui teal label'>1 LAYER</span><br>+<br/><span class='ui teal label'>"+gauge+"</span><br>+<br/><span class='ui teal label'>"+sl_masterbatch+" "+sl_mb_per+"</span><br>+<br/><span class='ui teal label'>"+sl_ldpe+" "+sl_ldpe_per+"</span><br>+<br/><span class='ui teal label'>"+sl_lldpe+" "+sl_lldpe_per+"</span><br>+<br/><span class='ui teal label'>"+sl_hdpe+" "+sl_hdpe_per+"</span>");
			}else{
				$("#article_name").html('');
			}
		});
	

	});
</script>
<?php foreach($specification as $specification_row):?>
	<?php
	$result_dia=$this->sleeve_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','1_1','srd_id','asc');

	foreach($result_dia as $dia_row){ $dia=$dia_row->relating_master_value; }

	$result_length=$this->sleeve_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','1_2','srd_id','asc');

	foreach($result_length as $length_row){ $length=$length_row->parameter_value; }

	$result_gauge=$this->sleeve_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','1_4','srd_id','asc');

	foreach($result_gauge as $gauge_row){ $gauge=$gauge_row->parameter_value; }

	$result_sl_mb=$this->sleeve_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','1_5_0','srd_id','asc');

	foreach($result_sl_mb as $sl_mb_row){ $sl_mb=$sl_mb_row->mat_article_no; $sl_mb_per=$sl_mb_row->mat_info;}

	$result_sl_ldpe=$this->sleeve_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','1_6_0','srd_id','asc');
	if($result_sl_ldpe==FALSE){
				$sl_ldpe='';
				$sl_ldpe_per='';
			}else{
				foreach($result_sl_ldpe as $sl_ldpe_row){ $sl_ldpe=$sl_ldpe_row->mat_article_no; $sl_ldpe_per=$sl_ldpe_row->mat_info;}
			}

	$result_sl_lldpe=$this->sleeve_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','1_6_1','srd_id','asc');
	if($result_sl_lldpe==FALSE){
			$sl_lldpe='';
			$sl_lldpe_per='';
		}else{
			foreach($result_sl_lldpe as $sl_lldpe_row){ $sl_lldpe=$sl_lldpe_row->mat_article_no; $sl_lldpe_per=$sl_lldpe_row->mat_info;}
		}

	
	$result_sl_hdpe=$this->sleeve_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','1_6_2','srd_id','asc');
		if($result_sl_hdpe==FALSE){
			$sl_hdpe='';
			$sl_hdpe_per='';
		}else{
			foreach($result_sl_hdpe as $sl_hdpe_row){ $sl_hdpe=$sl_hdpe_row->mat_article_no; $sl_hdpe_per=$sl_hdpe_row->mat_info;}
		}
	

	
	$result_sl_mb_supplier=$this->sleeve_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','1_5_0','srd_id','asc');
	foreach($result_sl_mb_supplier as $sl_mb_supplier_row){
		$data['sl_mb_supplier']=$this->supplier_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$sl_mb_supplier_row->supplier_no);
		if($sl_mb_supplier_row->supplier_no==''){
			$sl_mbb='';
		}else{
				foreach ($data['sl_mb_supplier'] as $sl_mbb_row) {
				$sl_mbb=$sl_mbb_row->name1."//".$sl_mbb_row->adr_company_id;
				}
		}
		
	}

	?>
<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update_single_layer');?>" method="POST" >


	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">

						<input type="hidden" name="spec_id"  value="<?php echo set_value('spec_id',$specification_row->spec_id);?>" />
						<input type="hidden" name="record_no" value="<?php echo $specification_row->spec_id.'@@@'.$specification_row->spec_version_no;?>">
						<input type="hidden" name="spec_version_no" value="<?php echo $specification_row->spec_version_no;?>">
								<!--
									<tr>
										<td class="label">Customer <span style="color:red;">*</span> :</td>
										<td><input type="text" name="customer" id="customer" size="60" value="<?php echo set_value('customer',$specification_row->customer_name."//".$specification_row->adr_company_id);?>" readonly/></td>
									</tr>-->

									<tr>
										<td class="label">Sleeve No <span style="color:red;">*</span> :</td>
										<td><input type="text" name="article_no" id="article_no" size="20" value="<?php echo set_value('article_no',$specification_row->article_no);?>" readonly/></td>
									</tr>

									<tr><td>&nbsp;</td><td>&nbsp;</td></tr>


									<tr>
										<td class="label">Dia <span style="color:red;">*</span> :</td>
										<td><select name="sleeve_dia" id="sleeve_dia" required><option value=''>--Select Dia--</option>
										<?php if($sleeve_dia==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($sleeve_dia as $sleeve_dia_row){
													$selected=($sleeve_dia_row->sleeve_diameter==$dia ? 'selected' :'');
													echo "<option value='".$sleeve_dia_row->sleeve_diameter."//".$sleeve_dia_row->sleeve_id."'  ".set_select('sleeve_dia',''.$sleeve_dia_row->sleeve_diameter.'//'.$sleeve_dia_row->sleeve_id.'')." $selected>".$sleeve_dia_row->sleeve_diameter."</option>";
												}
										}?></select>&nbsp;Length <span style="color:red;">*</span> : <input type="number" name="sleeve_length" id="sleeve_length" min="10"  max="300" step="0.50" size="5" maxlength="5" value="<?php echo set_value('sleeve_length',$length);?>" required></td>
									</tr>

									<tr>
										<td class="label">Gauge <span style="color:red;">*</span> :</td>
										<td><input type="number" name="gauge" id="gauge" name="gauge" min="350" max="550" step="50" value="<?php echo set_value('gauge',$this->common_model->select_number_from_string($gauge));?>" required></td>
									</tr>

									<tr><td>&nbsp;</td><td>&nbsp;</td></tr>

									<tr>
										<td class="label">MB <span style="color:red;">*</span> :</td>
										<td><select name="sl_masterbatch" id="sl_masterbatch" required><option value=''>--Select MB--</option>
										<?php foreach ($masterbatch as $masterbatch_row) {
											$selected=($masterbatch_row->article_no==$sl_mb ? 'selected' : '');
											echo "<option value='".$masterbatch_row->article_no."' $selected ".set_select('sl_masterbatch',$masterbatch_row->article_no).">".$masterbatch_row->lang_article_description."</option>";
										}?></select></td>

										<td>
										<input type="number" name="sl_mb_per" id="sl_mb_per" maxlength = "3" min="0"  max="25"  step="any" value="<?php echo set_value('sl_mb_per',$sl_mb_per);?>" placeholder="%" required size="3">
										<!--<input type="text" name="sl_mb_supplier" class="supplier" value="<?php echo set_value('sl_mb_supplier',$sl_mbb);?>" placeholder="MB Supplier">-->
										</td>
										</tr>

										<tr>
										<td class="label">LDPE :</td>
										<td><select name="sl_ldpe" id="sl_ldpe">
										<option value=''>--Select LDPE--</option>
										<?php
										foreach ($ldpe as $ldpe_row) {
											$selected=( $ldpe_row->article_no==$sl_ldpe ? 'selected' : '');
											echo "<option value='".$ldpe_row->article_no."' $selected ".set_select('sl_ldpe',$ldpe_row->article_no).">".$ldpe_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="number" name="sl_ldpe_per" id="sl_ldpe_per" min="0"  max="100" step="1" maxlength="3" size="3" value="<?php echo set_value('sl_ldpe_per',$this->common_model->select_number_from_string($sl_ldpe_per));?>" placeholder="%"></td>
										</tr>

										<tr>
										<td class="label">LLDPE :</td>
										<td><select name="sl_lldpe" id="sl_lldpe">
										<option value=''>--Select LLDPE--</option>
										<?php
										foreach ($lldpe as $lldpe_row) {
											$selected=($lldpe_row->article_no==$sl_lldpe ? 'selected' : '');
											echo "<option value='".$lldpe_row->article_no."' $selected ".set_select('sl_lldpe',$lldpe_row->article_no).">".$lldpe_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="number" name="sl_lldpe_per" id="sl_lldpe_per" min="0"  max="100" step="1" maxlength="3" size="3" value="<?php echo set_value('sl_lldpe_per',$this->common_model->select_number_from_string($sl_lldpe_per));?>" placeholder="%"></td>
										</tr>

										<tr>
										<td class="label">HDPE :</td>
										<td><select name="sl_hdpe" id="sl_hdpe">
										<option value=''>--Select HDPE--</option>
										<?php
										foreach ($hdpe as $hdpe_row) {
											$selected=($hdpe_row->article_no==$sl_hdpe ? 'selected' : '');
											echo "<option value='".$hdpe_row->article_no."' $selected ".set_select('sl_hdpe',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="number" name="sl_hdpe_per" id="sl_hdpe_per" min="0"  max="100" step="1" maxlength="3" size="3" value="<?php echo set_value('sl_hdpe_per',$this->common_model->select_number_from_string($sl_hdpe_per));?>" placeholder="%"></td>
										</tr>

										<tr><td>&nbsp;</td><td>&nbsp;</td></tr>

										<tr>
											<td class="label">Approval Authority :</td>
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
							<td rowspan="8">
								<table>
									<tr>
										<td class="label">Sleeve Com Name * :</td>
										<td><span id="article_name" style="color:green;font-weight: bold">
											<?php
												if(!empty($this->input->post('sleeve_dia'))){
								                $sleeve_dia=explode('//',$this->input->post('sleeve_dia'));
								                echo "<span class='ui teal label'>$sleeve_dia[0]</span>";
								              }else{
								                $sleeve_dia[0]='';
								                $sleeve_dia[1]='';
								              }

								              if(!empty($this->input->post('sleeve_length'))){
								                $sleeve_length=$this->input->post('sleeve_length');
								                echo "<span class='ui teal label'>$sleeve_dia[0]X$sleeve_length</span>";
								                echo "<br/>+<br/><span class='ui teal label'>1 Layer</span>";
								              }else{
								                $sleeve_lengthh='';
								              }

								              if(!empty($this->input->post('gauge'))){
								                $gauge=$this->input->post('gauge');
								                echo "<br/>+<br/><span class='ui teal label'>$gauge MIC</span>";
								              }else{
								                $gauge='';
								              }


								              if(!empty($this->input->post('sl_masterbatch')) || !empty($this->input->post('sl_mb_per'))){
								              $data['sl_masterbatch']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_masterbatch'));

								              	foreach($data['sl_masterbatch'] as $sl_masterbatch_row){
								              		$sl_mb_perr=$this->input->post('sl_mb_per')."%";
								                $sl_masterbatchh=$sl_masterbatch_row->article_name;
								                echo "<br/>+<br/><span class='ui teal label'>".$sl_masterbatchh." ".$sl_mb_perr."</span>";

								              }
								             	}else{
								             		$sl_masterbatchh="";
								             		$sl_mb_perr="";
								             	}

								              if(!empty($this->input->post('sl_ldpe')) && !empty($this->input->post('sl_ldpe_per'))){

								              	$data['sl_ldpe']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_ldpe'));
								              	if($data['sl_ldpe']==FALSE){
								                $sl_ldpe="";
								              	}else{
								                foreach($data['sl_ldpe'] as $sl_ldpe_row){
								                  $sl_ldpe=$sl_ldpe_row->article_name;
								                }
								              	}
								                $sl_ldpe_per=$this->input->post('sl_ldpe_per')."%";
								                echo "<br/>+<br/><span class='ui teal label'>".$sl_ldpe." ".$sl_ldpe_per."</span>";
								              }else{
								                $sl_ldpe='';
								                $sl_ldpe_per='';
								              }


								              if(!empty($this->input->post('sl_lldpe')) && !empty($this->input->post('sl_lldpe_per'))){

								              	$data['sl_lldpe']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_lldpe'));
								              	if($data['sl_lldpe']==FALSE){
								                $sl_lldpe="";
								              	}else{
								                foreach($data['sl_lldpe'] as $sl_lldpe_row){
								                  $sl_lldpe=$sl_lldpe_row->article_name;
								                }
								              	}
								                $sl_lldpe_per=$this->input->post('sl_lldpe_per')."%";
								                echo "<br/>+<br/><span class='ui teal label'>".$sl_lldpe." ".$sl_lldpe_per."</span>";
								              }else{
								                $sl_lldpe='';
								                $sl_lldpe_per='';
								              }


								              if(!empty($this->input->post('sl_hdpe')) && !empty($this->input->post('sl_hdpe_per'))){

								              	$data['sl_hdpe']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sl_hdpe'));
								              	if($data['sl_hdpe']==FALSE){
								                $sl_hdpe="";
								              	}else{
								                foreach($data['sl_hdpe'] as $sl_hdpe_row){
								                  $sl_hdpe=$sl_hdpe_row->article_name;
								                }
								              	}
								                $sl_hdpe_per=$this->input->post('sl_hdpe_per')."%";
								                echo "<br/>+<br/><span class='ui teal label'>".$sl_hdpe." ".$sl_hdpe_per."</span>";
								              }else{
								                $sl_hdpe='';
								                $sl_hdpe_per='';
								              }
								              ?>
										</span>
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
	  <button class="ui positive button">Update</button>
		</div>
	</div>
		
</form>
<?php endforeach;?>
				
				
				
				
				
			