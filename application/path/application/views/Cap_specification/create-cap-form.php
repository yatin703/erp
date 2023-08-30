<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>

	function getWords(string){
    return string.split(/\s+/).slice(0,3).join(" ");
}


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


  $('#cap_type').change(function(event) {
        if ($('#cap_type').val()=='FLIPTOP//2'){
          $("#cap_shrink_sleeves").show();
        }else{
          $("#cap_shrink_sleeve").val('');
          $("#cap_shrink_sleeves").hide();
        }
      });

  $('#cap_shrink_sleeve').change(function(event) {
    if ($('#cap_type').val()=='FLIPTOP//2'){
      $("#cap_shrink_sleeves").show();
    }else{
      $("#cap_shrink_sleeve").val('');
      $("#cap_shrink_sleeves").hide();
      }
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

	$("#cap_type").change(function(event) {

    if($("#cap_type option:selected").val()!=''){ var cap_type=$("#cap_type option:selected").text(); }else{var cap_type="";}

    if(cap_type!=''){
      $("#article_name").html("<span class='ui teal label'>"+cap_type+"</span>");
    }else{
      $("#article_name").html('');
    }

  });

	$("#cap_finish").change(function(event) {
    
    if($("#cap_type option:selected").val()!=''){ var cap_type=$("#cap_type option:selected").text(); }else{var cap_type="";}
    if($("#cap_finish option:selected").val()!=''){ var cap_finish=$("#cap_finish option:selected").text();}else{var cap_finish="";}
    if(cap_finish!=''){
      $("#article_name").html("<span class='ui teal label'>"+cap_type+"</span>+<span class='ui teal label'>"+cap_finish+"</span>");
    }else{
      $("#article_name").html('');
    }

   });

   $("#cap_dia").change(function(event) {
    
    if($("#cap_type option:selected").val()!=''){ var cap_type=$("#cap_type option:selected").text(); }else{var cap_type="";}
    if($("#cap_finish option:selected").val()!=''){ var cap_finish=$("#cap_finish option:selected").text();}else{var cap_finish="";}
    if($("#cap_dia option:selected").val()!=''){ var cap_dia=$("#cap_dia option:selected").text();}else{var cap_dia="";}
    if(cap_dia!=''){
      $("#article_name").html("<span class='ui teal label'>"+cap_type+"</span>+<span class='ui teal label'>"+cap_finish+"</span>+<span class='ui teal label'>"+cap_dia+"</span>");
    }else{
      $("#article_name").html('');
    }

   });




   $("#cap_orifice").change(function(event) {
   
    if($("#cap_type option:selected").val()!=''){ var cap_type=$("#cap_type option:selected").text(); }else{var cap_type="";}

    if($("#cap_finish option:selected").val()!=''){ var cap_finish=$("#cap_finish option:selected").text();}else{var cap_finish="";}

    if($("#cap_dia option:selected").val()!=''){ var cap_dia=$("#cap_dia option:selected").text();}else{var cap_dia="";}

    if($("#cap_orifice option:selected").val()!=''){ var cap_ori=$("#cap_orifice option:selected").text();}else{var cap_ori="";}

    if(cap_ori!=''){

      $("#article_name").html("<span class='ui teal label'>"+cap_type+"</span>+<span class='ui teal label'>"+cap_finish+"</span>+<span class='ui teal label'>"+cap_dia+"</span>+<span class='ui teal label'>"+cap_ori+"</span>");

        }else{
          $("#article_name").html('');
        }

   });

   $("#cap_masterbatch").change(function(event) {
   	
    if($("#cap_type option:selected").val()!=''){ var cap_type=$("#cap_type option:selected").text(); }else{var cap_type="";}

    if($("#cap_finish option:selected").val()!=''){ var cap_finish=$("#cap_finish option:selected").text();}else{var cap_finish="";}

    if($("#cap_dia option:selected").val()!=''){ var cap_dia=$("#cap_dia option:selected").text();}else{var cap_dia="";}

    if($("#cap_orifice option:selected").val()!=''){ var cap_ori=$("#cap_orifice option:selected").text();}else{var cap_ori="";}

    if($("#cap_masterbatch option:selected").val()!=''){ var cap_masterbatch=$("#cap_masterbatch option:selected").text();}else{var cap_masterbatch="";}

    if(cap_masterbatch!=''){

      $("#article_name").html("<span class='ui teal label'>"+cap_type+"</span>+<span class='ui teal label'>"+cap_finish+"</span>+<span class='ui teal label'>"+cap_dia+"</span>+<span class='ui teal label'>"+cap_ori+"</span><br/>+<br><span class='ui teal label'>"+cap_masterbatch+"</span>");
    }else{
          $("#article_name").html('');
        }

   });

		$("#cap_mb_per").live('keyup',function() {

    if($("#cap_type option:selected").val()!=''){ var cap_type=$("#cap_type option:selected").text(); }else{var cap_type="";}

    if($("#cap_finish option:selected").val()!=''){ var cap_finish=$("#cap_finish option:selected").text();}else{var cap_finish="";}

    if($("#cap_dia option:selected").val()!=''){ var cap_dia=$("#cap_dia option:selected").text();}else{var cap_dia="";}

    if($("#cap_orifice option:selected").val()!=''){ var cap_ori=$("#cap_orifice option:selected").text();}else{var cap_ori="";}

    if($("#cap_masterbatch option:selected").val()!=''){ var cap_masterbatch=$("#cap_masterbatch option:selected").text();}else{var cap_masterbatch="";}

   	if($("#cap_mb_per").val()!=''){ var cap_mb_per=$("#cap_mb_per").val()+"%";}else{var cap_mb_per="";}
   		 
   	if(cap_mb_per!=''){

      $("#article_name").html("<span class='ui teal label'>"+cap_type+"</span>+<span class='ui teal label'>"+cap_finish+"</span>+<span class='ui teal label'>"+cap_dia+"</span>+<span class='ui teal label'>"+cap_ori+"</span><br/>+<br><span class='ui teal label'>"+cap_masterbatch+" "+cap_mb_per+"</span>");
    }else{
          $("#article_name").html('');
        }
    
		});


		$("#cap_shrink_sleeve").change(function(event) {

    if($("#cap_type option:selected").val()!=''){ var cap_type=$("#cap_type option:selected").text(); }else{var cap_type="";}

    if($("#cap_finish option:selected").val()!=''){ var cap_finish=$("#cap_finish option:selected").text();}else{var cap_finish="";}

    if($("#cap_dia option:selected").val()!=''){ var cap_dia=$("#cap_dia option:selected").text();}else{var cap_dia="";}

    if($("#cap_orifice option:selected").val()!=''){ var cap_ori=$("#cap_orifice option:selected").text();}else{var cap_ori="";}

    if($("#cap_masterbatch option:selected").val()!=''){ var cap_masterbatch=$("#cap_masterbatch option:selected").text();}else{var cap_masterbatch="";}

    if($("#cap_mb_per").val()!=''){ var cap_mb_per=$("#cap_mb_per").val()+"%";}else{var cap_mb_per="";}

   	if($("#cap_shrink_sleeve").val()!=''){ var cap_shrink_sleeve=$("#cap_shrink_sleeve option:selected").text();}else{var cap_shrink_sleeve="";}
   		
    if(cap_shrink_sleeve!=''){
   		 $("#article_name").html("<span class='ui teal label'>"+cap_type+"</span>+<span class='ui teal label'>"+cap_finish+"</span>+<span class='ui teal label'>"+cap_dia+"</span>+<span class='ui teal label'>"+cap_ori+"</span><br/>+<br><span class='ui teal label'>"+cap_masterbatch+" "+cap_mb_per+"</span><br/>+<br/><span class='ui black label'>"+getWords(cap_shrink_sleeve)+"</span>");

					}else{
					$("#article_name").html('');
				}
    
		});


		$("#cap_metalization").live('click',function() {

    if($("#cap_type option:selected").val()!=''){ var cap_type=$("#cap_type option:selected").text(); }else{var cap_type="";}

    if($("#cap_finish option:selected").val()!=''){ var cap_finish=$("#cap_finish option:selected").text();}else{var cap_finish="";}

    if($("#cap_dia option:selected").val()!=''){ var cap_dia=$("#cap_dia option:selected").text();}else{var cap_dia="";}

    if($("#cap_orifice option:selected").val()!=''){ var cap_ori=$("#cap_orifice option:selected").text();}else{var cap_ori="";}

    if($("#cap_masterbatch option:selected").val()!=''){ var cap_masterbatch=$("#cap_masterbatch option:selected").text();}else{var cap_masterbatch="";}

    if($("#cap_mb_per").val()!=''){ var cap_mb_per=$("#cap_mb_per").val()+"%";}else{var cap_mb_per="";}

    if($("#cap_shrink_sleeve").val()!=''){ var cap_shrink_sleeve=$("#cap_shrink_sleeve option:selected").text();}else{var cap_shrink_sleeve="";}

   	if($("#cap_metalization").is(":checked")){ var cap_metalization="METALIZED";}else{var cap_metalization="";}

    if(cap_metalization!=''){

   		 $("#article_name").html("<span class='ui teal label'>"+cap_type+"</span>+<span class='ui teal label'>"+cap_finish+"</span>+<span class='ui teal label'>"+cap_dia+"</span>+<span class='ui teal label'>"+cap_ori+"</span><br/>+<br><span class='ui teal label'>"+cap_masterbatch+" "+cap_mb_per+"</span><br/>+<br/><span class='ui black label'>"+getWords(cap_shrink_sleeve)+"</span><br/>+<br/><span class='ui grey label'>"+cap_metalization+"</span>");

					}else{
					$("#article_name").html('');
				}
    
			});


		$("#cap_metalization_color").live('keyup',function() {

			
   	if($("#cap_type option:selected").val()!=''){ var cap_type=$("#cap_type option:selected").text(); }else{var cap_type="";}

    if($("#cap_finish option:selected").val()!=''){ var cap_finish=$("#cap_finish option:selected").text();}else{var cap_finish="";}

    if($("#cap_dia option:selected").val()!=''){ var cap_dia=$("#cap_dia option:selected").text();}else{var cap_dia="";}

    if($("#cap_orifice option:selected").val()!=''){ var cap_ori=$("#cap_orifice option:selected").text();}else{var cap_ori="";}

    if($("#cap_masterbatch option:selected").val()!=''){ var cap_masterbatch=$("#cap_masterbatch option:selected").text();}else{var cap_masterbatch="";}

    if($("#cap_mb_per").val()!=''){ var cap_mb_per=$("#cap_mb_per").val()+"%";}else{var cap_mb_per="";}

    if($("#cap_shrink_sleeve").val()!=''){ var cap_shrink_sleeve=$("#cap_shrink_sleeve option:selected").text();}else{var cap_shrink_sleeve="";}

    if($("#cap_metalization").is(":checked")){ var cap_metalization="METALIZED";}else{var cap_metalization="";}

   	if($("#cap_metalization_color").val()!=''){ var cap_metalization_color=$("#cap_metalization_color").val();}else{var cap_metalization_color="";}

    if(cap_metalization_color!=''){

   		 $("#article_name").html("<span class='ui teal label'>"+cap_type+"</span>+<span class='ui teal label'>"+cap_finish+"</span>+<span class='ui teal label'>"+cap_dia+"</span>+<span class='ui teal label'>"+cap_ori+"</span><br/>+<br><span class='ui teal label'>"+cap_masterbatch+" "+cap_mb_per+"</span><br/>+<br/><span class='ui black label'>"+getWords(cap_shrink_sleeve)+"</span><br/>+<br/><span class='ui grey label'>"+cap_metalization_color+" "+cap_metalization+"</span>");

					}else{
					$("#article_name").html('');
				}
    
			});


		


		$("#cap_metalization_finish").change(function(event) {
			
   	if($("#cap_type option:selected").val()!=''){ var cap_type=$("#cap_type option:selected").text(); }else{var cap_type="";}

    if($("#cap_finish option:selected").val()!=''){ var cap_finish=$("#cap_finish option:selected").text();}else{var cap_finish="";}

    if($("#cap_dia option:selected").val()!=''){ var cap_dia=$("#cap_dia option:selected").text();}else{var cap_dia="";}

    if($("#cap_orifice option:selected").val()!=''){ var cap_ori=$("#cap_orifice option:selected").text();}else{var cap_ori="";}

    if($("#cap_masterbatch option:selected").val()!=''){ var cap_masterbatch=$("#cap_masterbatch option:selected").text();}else{var cap_masterbatch="";}

    if($("#cap_mb_per").val()!=''){ var cap_mb_per=$("#cap_mb_per").val()+"%";}else{var cap_mb_per="";}

    if($("#cap_shrink_sleeve").val()!=''){ var cap_shrink_sleeve=$("#cap_shrink_sleeve option:selected").text();}else{var cap_shrink_sleeve="";}

    if($("#cap_metalization").is(":checked")){ var cap_metalization="METALIZED";}else{var cap_metalization="";}

    if($("#cap_metalization_color").val()!=''){ var cap_metalization_color=$("#cap_metalization_color").val();}else{var cap_metalization_color="";}

   	if($("#cap_metalization_finish").val()!=''){ var cap_metalization_finish=$("#cap_metalization_finish option:selected").val();}else{var cap_metalization_finish="";}

    if(cap_metalization_finish!=''){
   		 $("#article_name").html("<span class='ui teal label'>"+cap_type+"</span>+<span class='ui teal label'>"+cap_finish+"</span>+<span class='ui teal label'>"+cap_dia+"</span>+<span class='ui teal label'>"+cap_ori+"</span><br/>+<br><span class='ui teal label'>"+cap_masterbatch+" "+cap_mb_per+"</span><br/>+<br/><span class='ui black label'>"+getWords(cap_shrink_sleeve)+"</span><br/>+<br/><span class='ui grey label'>"+cap_metalization_color+" "+cap_metalization_finish+" "+cap_metalization+"</span>");

					}else{
					$("#article_name").html('');
				}
    
			});



		$("#cap_foil").change(function(event) {

    if($("#cap_type option:selected").val()!=''){ var cap_type=$("#cap_type option:selected").text(); }else{var cap_type="";}

    if($("#cap_finish option:selected").val()!=''){ var cap_finish=$("#cap_finish option:selected").text();}else{var cap_finish="";}

    if($("#cap_dia option:selected").val()!=''){ var cap_dia=$("#cap_dia option:selected").text();}else{var cap_dia="";}

    if($("#cap_orifice option:selected").val()!=''){ var cap_ori=$("#cap_orifice option:selected").text();}else{var cap_ori="";}

    if($("#cap_masterbatch option:selected").val()!=''){ var cap_masterbatch=$("#cap_masterbatch option:selected").text();}else{var cap_masterbatch="";}

    if($("#cap_mb_per").val()!=''){ var cap_mb_per=$("#cap_mb_per").val()+"%";}else{var cap_mb_per="";}

    if($("#cap_shrink_sleeve").val()!=''){ var cap_shrink_sleeve=$("#cap_shrink_sleeve option:selected").text();}else{var cap_shrink_sleeve="";}

    if($("#cap_metalization").is(":checked")){ var cap_metalization="METALIZED";}else{var cap_metalization="";}

    if($("#cap_metalization_color").val()!=''){ var cap_metalization_color=$("#cap_metalization_color").val();}else{var cap_metalization_color="";}

    if($("#cap_metalization_finish").val()!=''){ var cap_metalization_finish=$("#cap_metalization_finish option:selected").val();}else{var cap_metalization_finish="";}

   	if($("#cap_foil option:selected").val()!=''){ var cap_foil="FOILED";}else{var cap_foil="";}

    if(cap_foil!=''){
   		 $("#article_name").html("<span class='ui teal label'>"+cap_type+"</span>+<span class='ui teal label'>"+cap_finish+"</span>+<span class='ui teal label'>"+cap_dia+"</span>+<span class='ui teal label'>"+cap_ori+"</span><br/>+<br><span class='ui teal label'>"+cap_masterbatch+" "+cap_mb_per+"</span><br/>+<br/><span class='ui black label'>"+getWords(cap_shrink_sleeve)+"</span><br/>+<br/><span class='ui grey label'>"+cap_metalization_color+" "+cap_metalization_finish+" "+cap_metalization+"</span><br/>+<br/><span class='ui grey label'>"+cap_foil);

					}else{
					$("#article_name").html('');
				}
    
			});



  $(".form_table_inner").live('mouseover',function() {
    if($("#cap_type option:selected").val()!=''){ var cap_type=$("#cap_type option:selected").text(); }else{var cap_type="";}

    if(cap_type!=''){

    

    if($("#cap_finish option:selected").val()!=''){ var cap_finish=$("#cap_finish option:selected").text();}else{var cap_finish="";}

    if($("#cap_dia option:selected").val()!=''){ var cap_dia=$("#cap_dia option:selected").text();}else{var cap_dia="";}

    if($("#cap_orifice option:selected").val()!=''){ var cap_ori=$("#cap_orifice option:selected").text();}else{var cap_ori="";}

    if($("#cap_masterbatch option:selected").val()!=''){ var cap_masterbatch=$("#cap_masterbatch option:selected").text();}else{var cap_masterbatch="";}

    if($("#cap_mb_per").val()!=''){ var cap_mb_per=$("#cap_mb_per").val()+"%";}else{var cap_mb_per="";}

    if($("#cap_shrink_sleeve").val()!=''){ var cap_shrink_sleeve=$("#cap_shrink_sleeve option:selected").text();}else{var cap_shrink_sleeve="";}

    if($("#cap_metalization").is(":checked")){ var cap_metalization="METALIZED";}else{var cap_metalization="";}

    if($("#cap_metalization_color").val()!=''){ var cap_metalization_color=$("#cap_metalization_color").val();}else{var cap_metalization_color="";}

    if($("#cap_metalization_finish").val()!=''){ var cap_metalization_finish=$("#cap_metalization_finish option:selected").val();}else{var cap_metalization_finish="";}

    if($("#cap_foil option:selected").val()!=''){ var cap_foil="FOILED";}else{var cap_foil="";}

       $("#article_name").html("<span class='ui teal label'>"+cap_type+"</span>+<span class='ui teal label'>"+cap_finish+"</span>+<span class='ui teal label'>"+cap_dia+"</span>+<span class='ui teal label'>"+cap_ori+"</span><br/>+<br><span class='ui teal label'>"+cap_masterbatch+" "+cap_mb_per+"</span><br/>+<br/><span class='ui black label'>"+getWords(cap_shrink_sleeve)+"</span><br/>+<br/><span class='ui grey label'>"+cap_metalization_color+" "+cap_metalization_finish+" "+cap_metalization+"</span><br/>+<br/><span class='ui grey label'>"+cap_foil);

          }else{
          $("#article_name").html('');
        }
    
      });


	


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

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save_cap');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner" id="form_table_inner">

								<tr>
										<td class="label">Main Group * :</td>
										<td><select name="main_group" id="main_group"><option value=''>--Select Main Group--</option>
                      <option value="47">CAPS-47</option>

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
										<td class="label">Cap No * :</td>
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
										<input type="number" name="cap_mb_per" maxlength="3" size="3" min="0" max="100" step="0.1" id="cap_mb_per" value="<?php echo set_value('cap_mb_per');?>" placeholder="%">
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
										<input type="number" name="pp_per" maxlength="3" size="3"  min="100" max="100" step="1" value="<?php echo set_value('pp_per');?>" placeholder="%"></td>
										</tr>

                   
										<tr id="cap_shrink_sleeves">
										<td class="label">Cap Shrink Sleeve :</td>
										<td><select name="cap_shrink_sleeve" id="cap_shrink_sleeve">
										<option value=''>--Select Shrink Sleeve--</option>
										<?php
										foreach ($cap_shrink_sleeve as $cap_shrink_sleeve_row) {
											echo "<option value='".$cap_shrink_sleeve_row->article_no."//".$cap_shrink_sleeve_row->lang_article_description."' ".set_select('cap_shrink_sleeve',$cap_shrink_sleeve_row->article_no."//".$cap_shrink_sleeve_row->lang_article_description).">".$cap_shrink_sleeve_row->lang_article_description."</option>";
										}
										?>
										</select></td>
										</tr>
                    
										<?php
                    if($this->input->post('cap_metalization') &&  $this->input->post('cap_metalization')==1){

                      echo '<tr>
                      <td class="label">Cap Metalization :</td>
                      <td><input type="checkbox" name="cap_metalization" id="cap_metalization" value="1" '.set_checkbox('cap_metalization',1).' /></td>
                    </tr>

                    <tr id="metalization_div">
                      <td></td><td>
                    Color : &nbsp;&nbsp;<select name="cap_metalization_color" id="cap_metalization_color">
                      <option value="">--Select--</option>
                      <option value="GOLD" "'.set_select('cap_metalization_color', 'GOLD').'">GOLD</option>
                      <option value="SILVER" "'.set_select('cap_metalization_color', 'SILVER').'">SILVER</option>
                      <option value="PINK" "'.set_select('cap_metalization_color', 'PINK').'">PINK</option>
                      <option value="CHAMPION" "'.set_select('cap_metalization_color', 'CHAMPION').'">CHAMPION</option>
                      <option value="WINE" "'.set_select('cap_metalization_color', 'WINE').'">WINE</option>
                      <option value="COPPER" "'.set_select('cap_metalization_color', 'COPPER').'">COPPER</option>
                      <option value="BELLISIMA" "'.set_select('cap_metalization_color', 'BELLISIMA').'">BELLISIMA</option>
                      
                      <option value="MAGENTA" "'.set_select('cap_metalization_color', 'MAGENTA').'">MAGENTA</option>
                      <option value="LIGHT PURPLE" "'.set_select('cap_metalization_color', 'LIGHT PURPLE').'">LIGHT PURPLE</option>
                      <option value="RHODAMINE RED" "'.set_select('cap_metalization_color', 'RHODAMINE RED').'">RHODAMINE RED</option>
                      <option value="ROSE GOLD" "'.set_select('cap_metalization_color', 'ROSE GOLD').'">ROSE GOLD</option>
                      <option value="SHINY GOLD" "'.set_select('cap_metalization_color', 'SHINY GOLD').'">SHINY GOLD</option>
                      <option value="COCO BROWN" "'.set_select('cap_metalization_color', 'COCO BROWN').'">COCO BROWN</option>

                    </select>


                    <br/>

                    Finish : <select name="cap_metalization_finish" id="cap_metalization_finish">
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
										Color : &nbsp;&nbsp;<select name="cap_metalization_color" id="cap_metalization_color">
                      <option value="">--Select--</option>
                      <option value='GOLD' <?php echo  set_select('cap_metalization_color', 'GOLD'); ?>>GOLD</option>
                      <option value='SILVER' <?php echo  set_select('cap_metalization_color', 'SILVER'); ?>>SILVER</option>
                      <option value='PINK' <?php echo  set_select('cap_metalization_color', 'PINK'); ?>>PINK</option>
                      <option value='CHAMPION' <?php echo  set_select('cap_metalization_color', 'CHAMPION'); ?>>CHAMPION</option>
                      <option value='WINE' <?php echo  set_select('cap_metalization_color', 'WINE'); ?>>WINE</option>
                      <option value='COPPER' <?php echo  set_select('cap_metalization_color', 'COPPER'); ?>>COPPER</option>
                      <option value='BELLISIMA' <?php echo  set_select('cap_metalization_color', 'BELISIMA'); ?>>BELLISIMA</option>
                      <option value='MAGENTA' <?php echo  set_select('cap_metalization_color', 'MAGENTA'); ?>>MAGENTA</option>
                      <option value='LIGHT PURPLE' <?php echo  set_select('cap_metalization_color', 'LIGHT PURPLE'); ?>>LIGHT PURPLE</option>
                      <option value='RHODAMINE RED' <?php echo  set_select('cap_metalization_color', 'RHODAMINE RED'); ?>>RHODAMINE RED</option>
                      <option value='ROSE GOLD' <?php echo  set_select('cap_metalization_color', 'ROSE GOLD'); ?>>ROSE GOLD</option>
                      <option value='SHINY GOLD' <?php echo  set_select('cap_metalization_color', 'SHINY GOLD'); ?>>SHINY GOLD</option>
                      <option value='COCO BROWN' <?php echo  set_select('cap_metalization_color', 'COCO BROWN'); ?>>COCO BROWN</option>
                    </select>

										<br/>

										Finish : &nbsp;<select name="cap_metalization_finish" id="cap_metalization_finish">
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
											<td><input type="number" min="1" max="5" step="any" name="cap_foil_width" size="3" maxlength="3" value="<?php echo set_value('cap_foil_width');?>"></td>
										</tr>

										<tr>
											<td class="label">Cap Foil Dist From Bottom :</td>
											<td><input type="number" min="0" max="20" step="any"  name="cap_foil_dist_frm_bottom" size="3" maxlength="3" value="<?php echo set_value('cap_foil_dist_frm_bottom');?>"></td>
										</tr>

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
              <td width="50%">
                <table class="form_table_inner" id="form_table_inner">

                  <tr>
                    <td class="label">Cap Name * :</td>
                    <td><!--<span  id="article_name">
                      <?php
                      /*
                            if(!empty($this->input->post('cap_type'))){
                              $cap_typee=explode('//',$this->input->post('cap_type'));
                              $cap_typee=$cap_typee[0];
                              echo "<span class='ui teal label'>$cap_typee</span>";
                            }else{
                              $cap_typee='';
                            }

                            if(!empty($this->input->post('cap_finish'))){
                              $cap_finishh=explode('//',$this->input->post('cap_finish'));
                              $cap_finishh=$cap_finishh[0];
                              echo "<span class='ui teal label'>$cap_typee</span>+<span class='ui teal label'>$cap_finishh</span>";
                            }else{
                              $cap_finishh='';
                            }

                            if(!empty($this->input->post('cap_dia'))){
                              $cap_diaa=explode('//',$this->input->post('cap_dia'));
                              $cap_diaa=$cap_diaa[0];
                              echo "<span class='ui teal label'>$cap_typee</span>+<span class='ui teal label'>$cap_finishh</span>+<span class='ui teal label'>$cap_diaa</span>";
                            }else{
                              $cap_diaa='';
                            }

                            if(!empty($this->input->post('cap_orifice'))){
                              $cap_orificee=explode('//',$this->input->post('cap_orifice'));
                              $cap_orificee=$cap_orificee[0];
                              echo "<span class='ui teal label'>$cap_typee</span>+<span class='ui teal label'>$cap_finishh</span>+<span class='ui teal label'>$cap_diaa</span>+<span class='ui teal label'>$cap_orificee</span>";
                            }else{
                              $cap_orificee='';
                            }

                            if(!empty($this->input->post('cap_masterbatch'))){
                              $cap_masterbatchh=explode('//',$this->input->post('cap_masterbatch'));
                              $cap_masterbatchh=$cap_masterbatchh[1];
                               echo "<span class='ui teal label'>$cap_typee</span>+<span class='ui teal label'>$cap_finishh</span>+<span class='ui teal label'>$cap_diaa</span>+<span class='ui teal label'>$cap_orificee</span><br/>+<br/><span class='ui teal label'>$cap_masterbatchh</span>";

                            }else{
                              $cap_masterbatchh='';
                            }

                            if(!empty($this->input->post('cap_mb_per'))){
                                $cap_mb_perr=$this->input->post('cap_mb_per')."%";

                                echo "<span class='ui teal label'>$cap_typee</span>+<span class='ui teal label'>$cap_finishh</span>+<span class='ui teal label'>$cap_diaa</span>+<span class='ui teal label'>$cap_orificee</span><br/>+<br/><span class='ui teal label'>$cap_masterbatchh $cap_mb_perr</span>";
                              }else{
                                $cap_mb_perr='';
                            }

                            if(!empty($this->input->post('cap_shrink_sleeve'))){
                              $cap_shrink_sleeves=explode('//',$this->input->post('cap_shrink_sleeve'));
                              $cap_shrink_sleeve_name=explode(' ',$cap_shrink_sleeves[1]);
                              $cap_shrink_sleeve_names=" ".$cap_shrink_sleeve_name[0]." ".$cap_shrink_sleeve_name[1]." ".$cap_shrink_sleeve_name[2];
                              echo "<span class='ui teal label'>$cap_typee</span>+<span class='ui teal label'>$cap_finishh</span>+<span class='ui teal label'>$cap_diaa</span>+<span class='ui teal label'>$cap_orificee</span><br/>+<br/><span class='ui teal label'>$cap_masterbatchh $cap_mb_perr</span><br/>+<br/><span class='ui black label'>$cap_shrink_sleeve_names</span>";
                            }else{
                              $cap_shrink_sleeves[0]='';
                              $cap_shrink_sleeves[1]='';
                              $cap_shrink_sleeve_name[2]='';
                             $cap_shrink_sleeve_names='';
                             $cap_shrink_sleeves="";
                            }

                            if(!empty($this->input->post('cap_metalization'))){
                              $cap_metalization=" ".$this->input->post('cap_metalization_color')." ".$this->input->post('cap_metalization_finish')." "."METALIZATION";
                              echo "<span class='ui teal label'>$cap_typee</span>+<span class='ui teal label'>$cap_finishh</span>+<span class='ui teal label'>$cap_diaa</span>+<span class='ui teal label'>$cap_orificee</span><br/>+<br/><span class='ui teal label'>$cap_masterbatchh $cap_mb_perr</span><br/>+<br/><span class='ui black label'>$cap_shrink_sleeve_names</span><br/>+<br/><span class='ui grey label'>$cap_metalization</span>";
                            }else{
                              $cap_metalization="";
                            }


                            if(!empty($this->input->post('cap_foil_color'))){
                              $cap_foil_color=explode('//',$this->input->post('cap_foil_color'));
                              $cap_foil_color_name=" FOILED";

                              echo "<span class='ui teal label'>$cap_typee</span>+<span class='ui teal label'>$cap_finishh</span>+<span class='ui teal label'>$cap_diaa</span>+<span class='ui teal label'>$cap_orificee</span><br/>+<br/><span class='ui teal label'>$cap_masterbatchh $cap_mb_perr</span><br/>+<br/><span class='ui black label'>$cap_shrink_sleeve_names</span><br/>+<br/><span class='ui grey label'>$cap_metalization</span><br/>+<br/><span class='ui grey label'>$cap_foil_color_name</span>";
                            }else{
                              $cap_foil_color="";
                              $cap_foil_color[0]='';
                              $cap_foil_color[1]='';
                              $cap_foil_color_name="";
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
				
				
				
				
				
			