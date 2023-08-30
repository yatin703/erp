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

	

			$("#sleeve_dia").change(function(event) {
   		var sleeve_dia = $('#sleeve_dia').val();
		   $("#loading").show();
					$("#cover").show();
					$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
					if($("#sleeve_dia option:selected" ).val()!=''){
						$("#article_name").html("<span class='ui teal label'>"+$("#sleeve_dia option:selected").text()+"<span>");
					}else{
						$("#article_name").html('');
					}
					
		    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/shoulder",data: {sleeve_dia : $('#sleeve_dia').val()},cache: false,success: function(html){
		    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
		       $("#shoulder").html(html);
		    } 
		    });
   		});

		$('#shoulder').change(function(event) {
	      if ($('#shoulder').val()=='ZELLER//6' || $('#shoulder').val()=='NOZZLE//3' || $('#shoulder').val()=='TEAR OFF//4' || $('#shoulder').val()=='BEVEL//2' ){
	      	$("#shoulder_foil_tag").val('');
	      	$("#shoulder_foils").hide();
	      }else{
	        $("#shoulder_foils").show();
	      }
	    });

	    $('#shoulder_foil_tag').change(function(event) {
	      if ($('#shoulder').val()=='ZELLER//6' || $('#shoulder').val()=='NOZZLE//3' || $('#shoulder').val()=='TEAR OFF//4' || $('#shoulder').val()=='BEVEL//2' ){
	      	$("#shoulder_foil_tag").val('');
	      	$("#shoulder_foils").hide();
	      }else{
	        $("#shoulder_foils").show();
	      }
	    });

	
		$("#shoulder").change(function(event) {
		   var sleeve_dia = $('#sleeve_dia').val();
		   var shoulder = $('#shoulder').val();
		   $("#loading").show();
					$("#cover").show();
					$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');


					if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text();}else{var sleeve_dia="";}

					if($("#shoulder option:selected").val()!=''){ var shoulder=$("#shoulder option:selected").text();}else{var shoulder="";}

					if(shoulder!=''){
						$("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"</span>+<span class='ui teal label'>"+shoulder+"</span>");
					}else{
						$("#article_name").html('');
					}
		    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/shoulder_orifice",data: {sleeve_dia : $('#sleeve_dia').val(),shoulder : $('#shoulder').val()},cache: false,success: function(html){
		    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
		       $("#shoulder_orifice").html(html);
		    } 
		    });
   		});


		$("#shoulder_orifice").change(function(event) {
   
		   if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text();}else{var sleeve_dia="";}

					if($("#shoulder option:selected").val()!=''){ var shoulder=$("#shoulder option:selected").text();}else{var shoulder="";}

					if($("#shoulder_orifice option:selected").val()!=''){ var shoulder_orifice=$("#shoulder_orifice option:selected").text();}else{var shoulder_orifice="";}

		   if(shoulder_orifice!=''){
		   		$("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"</span>+<span class='ui teal label'>"+shoulder+"</span>+<span class='ui teal label'>"+shoulder_orifice+"</span>");
						}else{
							$("#article_name").html('');
						}

		   });


		



		$("#sh_masterbatch").change(function(event) {


			if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text();}else{var sleeve_dia="";}

			if($("#shoulder option:selected").val()!=''){ var shoulder=$("#shoulder option:selected").text();}else{var shoulder="";}

			if($("#shoulder_orifice option:selected").val()!=''){ var shoulder_orifice=$("#shoulder_orifice option:selected").text();}else{var shoulder_orifice="";}

			if($("#sh_masterbatch option:selected").val()!=''){ var sh_masterbatch=$("#sh_masterbatch option:selected").text();}else{var sh_masterbatch="";}
   
   if(sh_masterbatch!=''){

   		$("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"</span>+<span class='ui teal label'>"+shoulder+"</span>+<span class='ui teal label'>"+shoulder_orifice+"</span>+<span class='ui teal label'>"+sh_masterbatch+"</span>");
				}else{
					$("#article_name").html('');
				}

   });


		$("#sh_mb_per").live('keyup',function() {

			if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text();}else{var sleeve_dia="";}

			if($("#shoulder option:selected").val()!=''){ var shoulder=$("#shoulder option:selected").text();}else{var shoulder="";}

			if($("#shoulder_orifice option:selected").val()!=''){ var shoulder_orifice=$("#shoulder_orifice option:selected").text();}else{var shoulder_orifice="";}

			if($("#sh_masterbatch option:selected").val()!=''){ var sh_masterbatch=$("#sh_masterbatch option:selected").text();}else{var sh_masterbatch="";}

			if($("#sh_mb_per").val()!=''){ var sh_mb_per=$("#sh_mb_per").val()+"%";}else{var sh_mb_per="";}

   	if(sh_mb_per!=''){

   		 $("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"</span>+<span class='ui teal label'>"+shoulder+"</span>+<span class='ui teal label'>"+shoulder_orifice+"</span>+<span class='ui teal label'>"+sh_masterbatch+" "+sh_mb_per+"</span>");

					}else{
						$("#article_name").html('');
				}
    
			});


		$("#sh_hdpe_one").change(function(event) {

			if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text();}else{var sleeve_dia="";}

			if($("#shoulder option:selected").val()!=''){ var shoulder=$("#shoulder option:selected").text();}else{var shoulder="";}

			if($("#shoulder_orifice option:selected").val()!=''){ var shoulder_orifice=$("#shoulder_orifice option:selected").text();}else{var shoulder_orifice="";}

			if($("#sh_masterbatch option:selected").val()!=''){ var sh_masterbatch=$("#sh_masterbatch option:selected").text();}else{var sh_masterbatch="";}

			if($("#sh_mb_per").val()!=''){ var sh_mb_per=$("#sh_mb_per").val()+"%";}else{var sh_mb_per="";}

			if($("#sh_hdpe_one option:selected").val()!=''){ var sh_hdpe_one=$("#sh_hdpe_one option:selected").text();}else{var sh_hdpe_one="";}
   
   if(sh_hdpe_one!=''){

   		$("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"</span>+<span class='ui teal label'>"+shoulder+"</span>+<span class='ui teal label'>"+shoulder_orifice+"</span>+<span class='ui teal label'>"+sh_masterbatch+" "+sh_mb_per+"</span><br/>+<br/><span class='ui white label'>"+sh_hdpe_one+"</span>");
				}else{
					$("#article_name").html('');
				}

   });


		$("#sh_hdpe_one_per").live('keyup',function() {

			if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text();}else{var sleeve_dia="";}

			if($("#shoulder option:selected").val()!=''){ var shoulder=$("#shoulder option:selected").text();}else{var shoulder="";}

			if($("#shoulder_orifice option:selected").val()!=''){ var shoulder_orifice=$("#shoulder_orifice option:selected").text();}else{var shoulder_orifice="";}

			if($("#sh_masterbatch option:selected").val()!=''){ var sh_masterbatch=$("#sh_masterbatch option:selected").text();}else{var sh_masterbatch="";}

			if($("#sh_mb_per").val()!=''){ var sh_mb_per=$("#sh_mb_per").val()+"%";}else{var sh_mb_per="";}

			if($("#sh_hdpe_one option:selected").val()!=''){ var sh_hdpe_one=$("#sh_hdpe_one option:selected").text();}else{var sh_hdpe_one="";}

			if($("#sh_hdpe_one_per").val()!=''){ var sh_hdpe_one_per=$("#sh_hdpe_one_per").val()+"%";}else{var sh_hdpe_one_per="";}
   
   if(sh_hdpe_one_per!=''){

   		$("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"</span>+<span class='ui teal label'>"+shoulder+"</span>+<span class='ui teal label'>"+shoulder_orifice+"</span>+<span class='ui teal label'>"+sh_masterbatch+" "+sh_mb_per+"</span><br/>+<br/><span class='ui white label'>"+sh_hdpe_one+" "+sh_hdpe_one_per+"</span>");
				}else{
					$("#article_name").html('');
				}

   });

		$("#sh_hdpe_two").change(function(event) {

			if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text();}else{var sleeve_dia="";}

			if($("#shoulder option:selected").val()!=''){ var shoulder=$("#shoulder option:selected").text();}else{var shoulder="";}

			if($("#shoulder_orifice option:selected").val()!=''){ var shoulder_orifice=$("#shoulder_orifice option:selected").text();}else{var shoulder_orifice="";}

			if($("#sh_masterbatch option:selected").val()!=''){ var sh_masterbatch=$("#sh_masterbatch option:selected").text();}else{var sh_masterbatch="";}

			if($("#sh_mb_per").val()!=''){ var sh_mb_per=$("#sh_mb_per").val()+"%";}else{var sh_mb_per="";}

			if($("#sh_hdpe_one option:selected").val()!=''){ var sh_hdpe_one=$("#sh_hdpe_one option:selected").text();}else{var sh_hdpe_one="";}

			if($("#sh_hdpe_one_per").val()!=''){ var sh_hdpe_one_per=$("#sh_hdpe_one_per").val()+"%";}else{var sh_hdpe_one_per="";}

			if($("#sh_hdpe_two option:selected").val()!=''){ var sh_hdpe_two=$("#sh_hdpe_two option:selected").text();}else{var sh_hdpe_two="";}
   
   if(sh_hdpe_two!=''){

   		$("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"</span>+<span class='ui teal label'>"+shoulder+"</span>+<span class='ui teal label'>"+shoulder_orifice+"</span>+<span class='ui teal label'>"+sh_masterbatch+" "+sh_mb_per+"</span><br/>+<br/><span class='ui white label'>"+sh_hdpe_one+" "+sh_hdpe_one_per+"</span><br/>+<br/><span class='ui white label'>"+sh_hdpe_two+"</span>");
				}else{
					$("#article_name").html('');
				}

   });


		$("#sh_hdpe_two_per").live('keyup',function() {

			if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text();}else{var sleeve_dia="";}

			if($("#shoulder option:selected").val()!=''){ var shoulder=$("#shoulder option:selected").text();}else{var shoulder="";}

			if($("#shoulder_orifice option:selected").val()!=''){ var shoulder_orifice=$("#shoulder_orifice option:selected").text();}else{var shoulder_orifice="";}

			if($("#sh_masterbatch option:selected").val()!=''){ var sh_masterbatch=$("#sh_masterbatch option:selected").text();}else{var sh_masterbatch="";}

			if($("#sh_mb_per").val()!=''){ var sh_mb_per=$("#sh_mb_per").val()+"%";}else{var sh_mb_per="";}

			if($("#sh_hdpe_one option:selected").val()!=''){ var sh_hdpe_one=$("#sh_hdpe_one option:selected").text();}else{var sh_hdpe_one="";}

			if($("#sh_hdpe_one_per").val()!=''){ var sh_hdpe_one_per=$("#sh_hdpe_one_per").val()+"%";}else{var sh_hdpe_one_per="";}

			if($("#sh_hdpe_two option:selected").val()!=''){ var sh_hdpe_two=$("#sh_hdpe_two option:selected").text();}else{var sh_hdpe_two="";}

			if($("#sh_hdpe_two_per").val()!=''){ var sh_hdpe_two_per=$("#sh_hdpe_two_per").val()+"%";}else{var sh_hdpe_two_per="";}
   
   if(sh_hdpe_two_per!=''){

   	$("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"</span>+<span class='ui teal label'>"+shoulder+"</span>+<span class='ui teal label'>"+shoulder_orifice+"</span>+<span class='ui teal label'>"+sh_masterbatch+" "+sh_mb_per+"</span><br/>+<br/><span class='ui white label'>"+sh_hdpe_one+" "+sh_hdpe_one_per+"</span><br/>+<br/><span class='ui white label'>"+sh_hdpe_two+" "+sh_hdpe_two_per+"</span>");
				}else{
					$("#article_name").html('');
				}

   });


	$("#sh_hdpe_three").change(function(event) {

			if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text();}else{var sleeve_dia="";}

			if($("#shoulder option:selected").val()!=''){ var shoulder=$("#shoulder option:selected").text();}else{var shoulder="";}

			if($("#shoulder_orifice option:selected").val()!=''){ var shoulder_orifice=$("#shoulder_orifice option:selected").text();}else{var shoulder_orifice="";}

			if($("#sh_masterbatch option:selected").val()!=''){ var sh_masterbatch=$("#sh_masterbatch option:selected").text();}else{var sh_masterbatch="";}

			if($("#sh_mb_per").val()!=''){ var sh_mb_per=$("#sh_mb_per").val()+"%";}else{var sh_mb_per="";}

			if($("#sh_hdpe_one option:selected").val()!=''){ var sh_hdpe_one=$("#sh_hdpe_one option:selected").text();}else{var sh_hdpe_one="";}

			if($("#sh_hdpe_one_per").val()!=''){ var sh_hdpe_one_per=$("#sh_hdpe_one_per").val()+"%";}else{var sh_hdpe_one_per="";}
			
			if($("#sh_hdpe_two option:selected").val()!=''){ var sh_hdpe_two=$("#sh_hdpe_two option:selected").text();}else{var sh_hdpe_two="";}

			if($("#sh_hdpe_two_per").val()!=''){ var sh_hdpe_two_per=$("#sh_hdpe_two_per").val()+"%";}else{var sh_hdpe_two_per="";}

			if($("#sh_hdpe_three option:selected").val()!=''){ var sh_hdpe_three=$("#sh_hdpe_three option:selected").text();}else{var sh_hdpe_three="";}
   
   if(sh_hdpe_three!=''){

   		$("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"</span>+<span class='ui teal label'>"+shoulder+"</span>+<span class='ui teal label'>"+shoulder_orifice+"</span>+<span class='ui teal label'>"+sh_masterbatch+" "+sh_mb_per+"</span><br/>+<br/><span class='ui white label'>"+sh_hdpe_one+" "+sh_hdpe_one_per+"</span><br/>+<br/><span class='ui white label'>"+sh_hdpe_two+" "+sh_hdpe_two_per+"</span><br/>+<br/><span class='ui white label'>"+sh_hdpe_three+"</span>");
		}else{
			$("#article_name").html('');
		}

   });


		$("#sh_hdpe_three_per").live('keyup',function() {

			if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text();}else{var sleeve_dia="";}

			if($("#shoulder option:selected").val()!=''){ var shoulder=$("#shoulder option:selected").text();}else{var shoulder="";}

			if($("#shoulder_orifice option:selected").val()!=''){ var shoulder_orifice=$("#shoulder_orifice option:selected").text();}else{var shoulder_orifice="";}

			if($("#sh_masterbatch option:selected").val()!=''){ var sh_masterbatch=$("#sh_masterbatch option:selected").text();}else{var sh_masterbatch="";}

			if($("#sh_mb_per").val()!=''){ var sh_mb_per=$("#sh_mb_per").val()+"%";}else{var sh_mb_per="";}

			if($("#sh_hdpe_one option:selected").val()!=''){ var sh_hdpe_one=$("#sh_hdpe_one option:selected").text();}else{var sh_hdpe_one="";}

			if($("#sh_hdpe_one_per").val()!=''){ var sh_hdpe_one_per=$("#sh_hdpe_one_per").val()+"%";}else{var sh_hdpe_one_per="";}

			if($("#sh_hdpe_two option:selected").val()!=''){ var sh_hdpe_two=$("#sh_hdpe_two option:selected").text();}else{var sh_hdpe_two="";}

			if($("#sh_hdpe_two_per").val()!=''){ var sh_hdpe_two_per=$("#sh_hdpe_two_per").val()+"%";}else{var sh_hdpe_two_per="";}
			
			if($("#sh_hdpe_three option:selected").val()!=''){ var sh_hdpe_three=$("#sh_hdpe_three option:selected").text();}else{var sh_hdpe_three="";}

			if($("#sh_hdpe_three_per").val()!=''){ var sh_hdpe_three_per=$("#sh_hdpe_three_per").val()+"%";}else{var sh_hdpe_three_per="";}
   
   if(sh_hdpe_three_per!=''){

	$("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"</span>+<span class='ui teal label'>"+shoulder+"</span>+<span class='ui teal label'>"+shoulder_orifice+"</span>+<span class='ui teal label'>"+sh_masterbatch+" "+sh_mb_per+"</span><br/>+<br/><span class='ui white label'>"+sh_hdpe_one+" "+sh_hdpe_one_per+"</span><br/>+<br/><span class='ui white label'>"+sh_hdpe_two+" "+sh_hdpe_two_per+"</span><br/>+<br/><span class='ui white label'>"+sh_hdpe_three+" "+sh_hdpe_three_per+"</span>");
			}else{
				$("#article_name").html('');
			}
   });
   	


		$("#shoulder_foil_tag").change(function(event) {

			if($("#sleeve_dia option:selected").val()!=''){ var sleeve_dia=$("#sleeve_dia option:selected").text();}else{var sleeve_dia="";}

			if($("#shoulder option:selected").val()!=''){ var shoulder=$("#shoulder option:selected").text();}else{var shoulder="";}

			if($("#shoulder_orifice option:selected").val()!=''){ var shoulder_orifice=$("#shoulder_orifice option:selected").text();}else{var shoulder_orifice="";}

			if($("#sh_masterbatch option:selected").val()!=''){ var sh_masterbatch=$("#sh_masterbatch option:selected").text();}else{var sh_masterbatch="";}

			if($("#sh_mb_per").val()!=''){ var sh_mb_per=$("#sh_mb_per").val()+"%";}else{var sh_mb_per="";}

			if($("#sh_hdpe_one option:selected").val()!=''){ var sh_hdpe_one=$("#sh_hdpe_one option:selected").text();}else{var sh_hdpe_one="";}

			if($("#sh_hdpe_one_per").val()!=''){ var sh_hdpe_one_per=$("#sh_hdpe_one_per").val()+"%";}else{var sh_hdpe_one_per="";}

			if($("#sh_hdpe_two option:selected").val()!=''){ var sh_hdpe_two=$("#sh_hdpe_two option:selected").text();}else{var sh_hdpe_two="";}

			if($("#sh_hdpe_two_per").val()!=''){ var sh_hdpe_two_per=$("#sh_hdpe_two_per").val()+"%";}else{var sh_hdpe_two_per="";}
			
			if($("#sh_hdpe_three option:selected").val()!=''){ var sh_hdpe_three=$("#sh_hdpe_three option:selected").text();}else{var sh_hdpe_three="";}

			if($("#sh_hdpe_three_per").val()!=''){ var sh_hdpe_three_per=$("#sh_hdpe_three_per").val()+"%";}else{var sh_hdpe_three_per="";}

			if($("#shoulder_foil_tag option:selected").val()!=''){ var shoulder_foil_tag=$("#shoulder_foil_tag option:selected").text();}else{var shoulder_foil_tag="";}

   
		   if(shoulder_foil_tag!=''){

		   		$("#article_name").html("<span class='ui teal label'>"+sleeve_dia+"</span>+<span class='ui teal label'>"+shoulder+"</span>+<span class='ui teal label'>"+shoulder_orifice+"</span>+<span class='ui teal label'>"+sh_masterbatch+" "+sh_mb_per+"</span><br/>+<br/><span class='ui white label'>"+sh_hdpe_one+" "+sh_hdpe_one_per+"</span><br/>+<br/><span class='ui white label'>"+sh_hdpe_two+" "+sh_hdpe_two_per+"</span><br/>+<br/><span class='ui white label'>"+sh_hdpe_three+" "+sh_hdpe_three_per+"</span><br/>+<br/><span class='ui grey label'>"+shoulder_foil_tag+"</span>");

						}else{
							$("#article_name").html('');
						}

		   });   

				
});
</script>

<?php foreach($specification as $specification_row):?>
	<?php
	

	$result_shoulder_dia=$this->shoulder_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','2_1','srd_id','asc');

	foreach($result_shoulder_dia as $shoulder_dia_row){ $shoulder_dias=$shoulder_dia_row->relating_master_value;}

	$result_shoulder_style=$this->shoulder_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','2_2','srd_id','asc');

	foreach($result_shoulder_style as $shoulder_style_row){ $shoulder_styles=$shoulder_style_row->relating_master_value;}

	$result_shoulder_orifice=$this->shoulder_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','2_4','srd_id','asc');

	foreach($result_shoulder_orifice as $shoulder_orifice_row){ $shoulder_orifices=$shoulder_orifice_row->relating_master_value;}


	$result_shoulder_mb=$this->shoulder_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','2_6_0','srd_id','asc');

	foreach($result_shoulder_mb as $shoulder_mb_row){ $shoulder_mb=$shoulder_mb_row->mat_article_no; $shoulder_mb_per=$shoulder_mb_row->mat_info;}


	$result_shoulder_foil=$this->shoulder_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','2_8','srd_id','asc');
	if($result_shoulder_foil==FALSE){
		$shoulder_foils="";
	}else{
		foreach($result_shoulder_foil as $shoulder_foil_row){ $shoulder_foils=$shoulder_foil_row->mat_article_no;}
	}


	$result_shoulder_hdpe_one=$this->shoulder_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','2_7_0','srd_id','asc');

	foreach($result_shoulder_hdpe_one as $result_shoulder_hdpe_one_row){ $shoulder_hdpe_one=$result_shoulder_hdpe_one_row->mat_article_no; $shoulder_hdpe_one_per=$result_shoulder_hdpe_one_row->mat_info;}

	$result_shoulder_hdpe_two=$this->shoulder_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','2_7_1','srd_id','asc');

	foreach($result_shoulder_hdpe_two as $result_shoulder_hdpe_two_row){ $shoulder_hdpe_two=$result_shoulder_hdpe_two_row->mat_article_no; $shoulder_hdpe_two_per=$result_shoulder_hdpe_two_row->mat_info;}

	$result_shoulder_hdpe_three=$this->shoulder_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','2_7_2','srd_id','asc');

	foreach($result_shoulder_hdpe_three as $result_shoulder_hdpe_three_row){ 
		$shoulder_hdpe_three=$result_shoulder_hdpe_three_row->mat_article_no; 
		$shoulder_hdpe_three_per=$result_shoulder_hdpe_three_row->mat_info;}


	$result_shoulder_mb_supplier=$this->shoulder_specification_model->select_details_record_where('specification_sheet_details',$this->session->userdata['logged_in']['company_id'],'spec_id',$specification_row->spec_id,'spec_version_no',$specification_row->spec_version_no,'srd_id','2_6_0','srd_id','asc');
	foreach($result_shoulder_mb_supplier as $shoulder_mb_supplier_row){
		$data['shoulder_mb_supplier']=$this->supplier_model->select_one_active_record('address_master',$this->session->userdata['logged_in']['company_id'],'address_master.adr_company_id',$shoulder_mb_supplier_row->supplier_no);
		if($shoulder_mb_supplier_row->supplier_no==''){
			$shoulder_mbb="";
		}else{
				foreach ($data['shoulder_mb_supplier'] as $shoulder_mbb_row) {
					$shoulder_mbb=$shoulder_mbb_row->name1."//".$shoulder_mbb_row->adr_company_id;
				}
		}
	}

	?>
<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save_shoulder');?>" method="POST" >


	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">

								<input type="hidden" name="spec_id"  value="<?php echo set_value('spec_id',$specification_row->spec_id);?>" readonly/>
								<input type="hidden" name="record_no" value="<?php echo $specification_row->spec_id.'@@@'.$specification_row->spec_version_no;?>">

								<input type="hidden" name="spec_version_no"  value="<?php echo set_value('spec_version_no',$specification_row->spec_version_no);?>" readonly/>

									<!--
									<tr id="hi" style="<?php if(!empty($specification_row->adr_company_id)){ $customer=$specification_row->customer_name."//".$specification_row->adr_company_id; }else { echo "display:none;"; $customer=""; } ?>">
										<td class="label">Customer <span style="color:red;">*</span> :</td>
										<td><input type="text" name="customer" id="customer" size="60" value="<?php echo set_value('customer',$customer);?>" /></td>
									</tr>-->
									

									<tr>
										<td class="label">Main Group * :</td>
										<td><select name="main_group" id="main_group"><option value=''>--Select Main Group--</option>
											<option value='46'>SHOULDER SLEEVE-46</option>
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
										<td class="label">Shoulder No * :</td>
										<td><select name="article_no" id="article_no" >
										<?php if($this->input->post('article_no')){
											echo '<option value="'.$this->input->post('article_no').'">'.$this->input->post('article_no').'</option>';
										}else{
											echo '<option value="">--Select Article Code--</option>';
										}?>
														
										</select></td>
									</tr>

									
									<tr><td>&nbsp;</td><td>&nbsp;</td></tr>

										<tr>
										<td class="label">Dia <span style="color:red;">*</span> :</td>
										<td><select name="sleeve_dia" id="sleeve_dia"><option value=''>--Select Dia--</option>
										<?php if($sleeve_dia==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($sleeve_dia as $sleeve_dia_row){
													$selected=($sleeve_dia_row->sleeve_diameter==$shoulder_dias ? 'selected' : '');
													echo "<option value='".$sleeve_dia_row->sleeve_diameter."//".$sleeve_dia_row->sleeve_id."' $selected ".set_select('sleeve_dia',''.$sleeve_dia_row->sleeve_diameter.'//'.$sleeve_dia_row->sleeve_id.'').">".$sleeve_dia_row->sleeve_diameter."</option>";
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
													$selected=($shoulder_types_row->shoulder_type==$shoulder_styles ? 'selected' : '');
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
														$selected=($shoulder_orifice_row->shoulder_orifice==$shoulder_orifices ? 'selected' : '');
														echo "<option value='".$shoulder_orifice_row->shoulder_orifice."//".$shoulder_orifice_row->orifice_id."' $selected ".set_select('shoulder_orifice',''.$shoulder_orifice_row->shoulder_orifice.'//'.$shoulder_orifice_row->orifice_id.'').">".$shoulder_orifice_row->shoulder_orifice."</option>";
													}
											}?></select></td>
									</tr>

									<tr><td>&nbsp;</td><td>&nbsp;</td></tr>

									

									<tr>
										<td class="label">MB <span style="color:red;">*</span> :</td>
										<td><select name="sh_masterbatch" id="sh_masterbatch">
										<option value=''>--Select MB--</option>
										<?php
										foreach ($masterbatch as $masterbatch_row) {
											$selected=($masterbatch_row->article_no==$shoulder_mb ? 'selected' : '');
											echo "<option value='".$masterbatch_row->article_no."' $selected ".set_select('sh_masterbatch',$masterbatch_row->article_no).">".$masterbatch_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										<td>
										<input type="number" name="sh_mb_per" id="sh_mb_per" maxlength="3" size="3" min="0" max="100" step="any" value="<?php echo set_value('sh_mb_per',$shoulder_mb_per);?>" placeholder="%">
										</td>
									</tr>

										<tr>
										<td class="label">HDPE <span style="color:red;">*</span> :</td>
										<td><select name="sh_hdpe_one" id="sh_hdpe_one" >
											<option value='RM-HDPE-000-0009'>HDPE RELIANCE M60075</option>
										<option value=''>--Select HDPE--</option>
										<?php
										foreach ($hdpe as $hdpe_row) {
											$selected=($hdpe_row->article_no==$shoulder_hdpe_one ? 'selected' : '');
											echo "<option value='".$hdpe_row->article_no."' $selected ".set_select('sh_hdpe_one',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
										}
										?>
										</select>
										<input type="hidden" name="sh_hdpe_one" value="RM-HDPE-000-0009" />


										</td>
										<td><input type="number" name="sh_hdpe_one_per" id="sh_hdpe_one_per" maxlength="3" size="3" min="0" max="100" step="1" value="<?php echo set_value('sh_hdpe_one_per','25',$shoulder_hdpe_one_per);?>" placeholder="%"></td>
										</tr>

										<tr>
										<td class="label">HDPE <span style="color:red;">*</span> :</td>
										<td><select name="sh_hdpe_two" id="sh_hdpe_two">
											<option value='RM-HDPE-000-0008'>HDPE RELIANCE F46003</option>
										<option value=''>--Select HDPE--</option>
										<?php
										foreach ($hdpe as $hdpe_row) {
											$selected=($hdpe_row->article_no==$shoulder_hdpe_two ? 'selected' : '');
											echo "<option value='".$hdpe_row->article_no."' $selected ".set_select('sh_hdpe_two',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
										}
										?>
										</select>
										<input type="hidden" name="sh_hdpe_two" value="RM-HDPE-000-0008" />
									</td>
										<td>
										<input type="number" name="sh_hdpe_two_per" id="sh_hdpe_two_per" maxlength="3" size="3"  min="0" max="100" step="1"  value="<?php echo set_value('sh_hdpe_two_per','25',$shoulder_hdpe_two_per);?>" placeholder="%" ></td>
										</tr>


										<tr>
											<td class="label">HDPE <span style="color:red;">*</span> :</td>
											<td><select name="sh_hdpe_three" id="sh_hdpe_three" >
												<option value='RM-HDPE-000-0008'>HDPE RELIANCE F46003</option>
											<option value=''>--Select HDPE--</option>
											<?php
											foreach ($hdpe as $hdpe_row) {
												$selected=($hdpe_row->article_no==$shoulder_hdpe_three ? 'selected' : '');
												echo "<option value='".$hdpe_row->article_no."' $selected ".set_select('sh_hdpe_three',$hdpe_row->article_no).">".$hdpe_row->lang_article_description."</option>";
											}
											?>
											</select>
											<input type="hidden" name="sh_hdpe_three" value="RM-HDPE-000-0008" />
										</td>
											<td>
											<input type="number" name="sh_hdpe_three_per" id="sh_hdpe_three_per" maxlength="3" size="3"  min="0" max="100" step="1"  value="<?php echo set_value('sh_hdpe_three_per','50',$shoulder_hdpe_three_per);?>" placeholder="%"></td>
									  </tr>


										<tr id="shoulder_foils">
										<td class="label">Top Sealed Foil <span style="color:red;">*</span> :</td>
										<td><select name="shoulder_foil_tag" id="shoulder_foil_tag">
										<option value=''>--Select Foil--</option>
										<?php
											$selected=($shoulder_foils=="RM-HSF-000-0023" ? 'selected' : '');
											echo "<option value='RM-HSF-000-0023' $selected ".set_select('shoulder_foil_tag','RM-HSF-000-0023').">TOP SEAL FOIL 32MM 16981</option>";
										
										?>
										</select></td>
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
							<td>
								<table>
									<tr>
										<td class="label">Shoulder Name * :</td>
										<td><span id="article_name"><?php $specification_row->article_name;?>
											<?php
												if(!empty($this->input->post('sleeve_dia'))){
									                $sleeve_diaa=explode('//',$this->input->post('sleeve_dia'));
									                echo "<span class='ui teal label'>$sleeve_diaa[0]</span>";
									              }else{
									                $sleeve_diaa[0]='';
									              }

									              if(!empty($this->input->post('shoulder'))){
									                $shoulderr=explode('//',$this->input->post('shoulder'));
									                echo "+<span class='ui teal label'>$shoulderr[0]</span>";
									              }else{
									                $shoulderr[0]='';
									              }

									              if(!empty($this->input->post('shoulder_orifice'))){
									                $shoulder_orificee=explode('//',$this->input->post('shoulder_orifice'));
									                echo "+<span class='ui teal label'>$shoulder_orificee[0]</span>";
									              }else{
									                $shoulder_orificee[0]='';
									              }

									              
									              //$this->load->article_model();
									              $data['sh_masterbatch']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sh_masterbatch'));
									              if($data['sh_masterbatch']==FALSE){

									              }else{
									              	foreach($data['sh_masterbatch'] as $sh_masterbatch_row){
									                $sh_masterbatchh=$sh_masterbatch_row->article_name;
									                //echo "+<span class='ui teal label'>$sh_masterbatchh</span>";
									              	}

									              	if(!empty($this->input->post('sh_mb_per'))){
									                $sh_mb_perr=$this->input->post('sh_mb_per')."%";
									                 
										              }else{
										                $sh_mb_perr='';
										             }

										             echo "+<span class='ui teal label'>$sh_masterbatchh $sh_mb_perr</span>";
									              }
									              

									              if(!empty($this->input->post('sh_hdpe_one'))){
									              $data['sh_hdpe_one']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sh_hdpe_one'));
									              foreach($data['sh_hdpe_one'] as $sh_hdpe_one_row){
									                $sh_hdpe_onee=$sh_hdpe_one_row->article_name;
									              }

									              if(!empty($this->input->post('sh_hdpe_one_per'))){
									                $sh_hdpe_one_perr=$this->input->post('sh_hdpe_one_per')."%";
									                
									              }else{
									                $sh_hdpe_one_perr='';
									              }

									              echo "<br/>+<br/><span class='ui white label'>$sh_hdpe_onee $sh_hdpe_one_perr</span>";

									             }else{
									             	$sh_hdpe_onee="";
									             }

									             

									             if(!empty($this->input->post('sh_hdpe_two'))){
									              $data['sh_hdpe_two']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sh_hdpe_two'));
									              foreach($data['sh_hdpe_two'] as $sh_hdpe_two_row){
									                $sh_hdpe_twoo=$sh_hdpe_two_row->article_name;
									              }

										              if(!empty($this->input->post('sh_hdpe_two_per'))){
										                $sh_hdpe_two_perr=$this->input->post('sh_hdpe_two_per')."%";
										                
										              }else{
										                $sh_hdpe_two_perr='';
										              }
										             echo "<br/>+<br/><span class='ui white label'>$sh_hdpe_twoo $sh_hdpe_two_perr</span>";
									             }else{
									             		$sh_hdpe_twoo="";
									             }


									             if(!empty($this->input->post('sh_hdpe_three'))){
													  $data['sh_hdpe_three']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('sh_hdpe_three'));
													  foreach($data['sh_hdpe_three'] as $sh_hdpe_three_row){
														$sh_hdpe_threee=$sh_hdpe_three_row->article_name;
													  }

														if(!empty($this->input->post('sh_hdpe_three_per'))){
														$sh_hdpe_three_perr=$this->input->post('sh_hdpe_three_per')."%";
														}else{
															$sh_hdpe_three_perr='';
														}
														 echo "<br/>+<br/><span class='ui white label'>$sh_hdpe_threee $sh_hdpe_three_perr</span>";
													 }else{
															$sh_hdpe_threee="";
													 }

									             

									              if(!empty($this->input->post('shoulder_foil_tag'))){
									              $data['shoulder_foil_tag']=$this->article_model->select_one_active_record('article',$this->session->userdata['logged_in']['company_id'],'article.article_no',$this->input->post('shoulder_foil_tag'));
									              foreach($data['shoulder_foil_tag'] as $shoulder_foil_tag_row){
									                $shoulder_foil_tagg=$shoulder_foil_tag_row->article_name;

									                echo "<br/>+<br/><span class='ui grey label'>$shoulder_foil_tagg</span>";
									              }
									             }else{
									             		$shoulder_foil_tagg="";
									             }
									             ?>
											</span></td>
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
				
				
				
				
				
			