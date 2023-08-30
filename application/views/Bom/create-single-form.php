<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		$("#customer").autocomplete("<?php echo base_url('index.php/ajax/customer');?>", {selectFirst: true});
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

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">

									<tr>
										<td class="label"><b>PSM/PSP NO</b>  <span style="color:red;">*</span> :</td>
										<td><input type="text" name="article_no" id="article_no" size="60" value="<?php echo set_value('article_no');?>" /></td>
									</tr>
								
									<tr><td class="label"><b>&nbsp;</b></td><td class="label"><b>&nbsp;</b></td></tr>

									<tr>
										<td class="label"><b>Print Type</b> :</td>
										<td><select name="sleeve_dia" id="sleeve_dia"><option value=''>--Select Print Type--</option>
										<?php if($sleeve_dia==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($sleeve_dia as $sleeve_dia_row){
													echo "<option value='".$sleeve_dia_row->sleeve_diameter."//".$sleeve_dia_row->sleeve_id."'  ".set_select('sleeve_dia',''.$sleeve_dia_row->sleeve_diameter.'//'.$sleeve_dia_row->sleeve_id.'').">".$sleeve_dia_row->sleeve_diameter."</option>";
												}
										}?></select></td>
									</tr>

									<tr><td class="label"><b>&nbsp;</b></td><td class="label"><b>+</b></td></tr>

									<tr>
											<td class="label"><b>Tube Code <span style="color:red;">*</span></b></td>
											<td><input type="text" name="article_no" id="article_no" size="60" value="<?php echo set_value('article_no');?>" /></td>
									</tr>

									<tr><td class="label"><b>&nbsp;</b></td><td class="label"><b>+</b></td></tr>

									<tr>
											<td class="label"><b>Shoulder Code <span style="color:red;">*</span></b></td>
											<td><input type="text" name="article_no" id="article_no" size="60" value="<?php echo set_value('article_no');?>" /></td>
									</tr>
									<tr><td class="label"><b>&nbsp;</b></td><td class="label"><b>+</b></td></tr>

									<tr>
											<td class="label"><b>Label Code</b></td>
											<td><input type="text" name="article_no" id="article_no" size="60" value="<?php echo set_value('article_no');?>" /></td>
									</tr>
									<tr><td class="label"><b>&nbsp;</b></td><td class="label"><b>+</b></td></tr>

									<tr>
											<td class="label"><b>Cap Code <span style="color:red;">*</span></b></td>
											<td><input type="text" name="article_no" id="article_no" size="60" value="<?php echo set_value('article_no');?>" /></td>
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
				
				
				
				
				
			