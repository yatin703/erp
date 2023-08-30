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
   $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/version_no",data: {article_no : $('#article_no').val()},cache: false,success: function(html){
    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
       $("#version_no").html(html);
    } 
    });
   });

				var counter_hot_foil=0;

    var x = document.getElementsByName("hot_foil[]");

    var counter_hot_foil=x.length+1;
    $("#add_1").live('click',function () {
    	var newtr = $(document.createElement('tr')).attr("id", 'hot_foil_'+counter_hot_foil);
    	 newtr.html('<td>Hot Foil '+counter_hot_foil+' <input type="hidden" name="hot_foil[]" value="'+counter_hot_foil+'"/></td><td><input type="text" name="hot_foil_'+counter_hot_foil+'" id="hot_foil_'+counter_hot_foil+'" value="<?php echo set_value('hot_foil_"+counter_hot_foil+"');?>" /></td>');
    	 var lastcounter_hot_foil=counter_hot_foil-1;
    	 newtr.insertAfter("#hot_foil_"+lastcounter_hot_foil);
    	 counter_hot_foil++;
    });

    $("#remove_1").click(function(){
      if(counter_hot_foil==2){ alert("No more textbox to remove"); return false;}
         counter_hot_foil--;
          $("#hot_foil_" + counter_hot_foil).remove();
     });


    var counter_lacquer_type=0;

    var x = document.getElementsByName("lacquer_type[]");

    var counter_lacquer_type=x.length+1;
    $("#add_2").live('click',function () {
    	var newtr = $(document.createElement('tr')).attr("id", 'lacquer_type_'+counter_lacquer_type);
    	 newtr.html('<td>Lacquer Type '+counter_lacquer_type+' <input type="hidden" name="lacquer_type[]" value="'+counter_lacquer_type+'"/></td><td><input type="text" name="lacquer_type_'+counter_lacquer_type+'" id="lacquer_type_'+counter_lacquer_type+'" value="<?php echo set_value('lacquer_type_"+counter_lacquer_type+"');?>" /></td>');
    	 var lastcounter_lacquer_type=counter_lacquer_type-1;
    	 newtr.insertAfter("#lacquer_type_"+lastcounter_lacquer_type);
    	 counter_lacquer_type++;
    });

    $("#remove_2").click(function(){
      if(counter_lacquer_type==2){ alert("No more textbox to remove"); return false;}
         counter_lacquer_type--;
          $("#lacquer_type_" + counter_lacquer_type).remove();
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
										<td class="label">Customer * :</td>
										<td><input type="text" name="customer" id="customer"  size="60" value="<?php echo set_value('customer');?>" /></td>
									</tr>

									<tr>
										<td class="label">Article  * :</td>
										<td><input type="text" name="article_no" id="article_no"  size="60" value="<?php echo set_value('article_no');?>" /></td>
									</tr>

									<tr>
										<td class="label">Version No * :</td>
										<td><select id="version_no" name="version_no">
										<?php
										if($this->input->post('version_no')){
											echo '<option value="'.$this->input->post('version_no').'">'.$this->input->post('version_no').'</option>';
										}else{
											echo '<option value="">--Version No--</option>';
										}
										?>
										</select></td>
									</tr>
									
									<tr>
										<td class="label">Dia * :</td>
										<td><select name="sleeve_dia"><option value=''>--Select Sleeve Dia--</option>
										<?php if($sleeve_dia==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($sleeve_dia as $sleeve_dia_row){
													echo "<option value='".$sleeve_dia_row->sleeve_diameter."'  ".set_select('sleeve_dia',''.$sleeve_dia_row->sleeve_diameter.'').">".$sleeve_dia_row->sleeve_diameter."</option>";
												}
										}?>
										</select></td>
									</tr>

									<tr>
										<td class="label">Length * :</td>
										<td><input type="text" name="sleeve_length" size="10" value="<?php echo set_value('sleeve_length');?>"></td>
									</tr>

									<tr>
										<td class="label">Sleeve Color * :</td>
										<td><input type="text" name="sleeve_color" value="<?php echo set_value('sleeve_color');?>"></td>
									</tr>

									

									<tr>
										<td class="label">Print Type * :</td>
										<td><select name="print_type"><option value=''>--Select Print Type--</option>
										<?php if($print_type==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($print_type as $print_type_row){
													echo "<option value='".$print_type_row->lacquer_type."'  ".set_select('print_type',''.$print_type_row->lacquer_type.'').">".$print_type_row->lacquer_type."</option>";
												}
										}?>
										</select></td>
									</tr>

									<tr>
										<td class="label">Printing upto neck * :</td>
										<td><select name="printing_upto_neck"><option value="">--Select--</option>
											<option value="YES" <?php echo  set_select('printing_upto_neck', 'YES'); ?>>YES</option>
											<option value="NO" <?php echo  set_select('printing_upto_neck', 'NO'); ?>>NO</option>
										</select></td>
									</tr>

									
									<tr id="hot_foil_1">
										<td class="label">Hot Foil 1 :<input type="hidden" name="hot_foil[]" value="1" /></td>
										<td><select name="hot_foil_1"><option value=''>--Select Hot Foil--</option>
											<?php if($hot_foil==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($hot_foil as $hot_foil_row){
													echo "<option value='".$hot_foil_row->lang_article_description."'   ".set_select('hot_foil_1',$hot_foil_row->lang_article_description).">".$hot_foil_row->lang_article_description."</option>";
												}
										}?>
										</select></td>
									</tr>

									<tr id="hot_foil_2">
										<td class="label">Hot Foil 2  :<input type="hidden" name="hot_foil[]" value="2" /></td>
										<td><select name="hot_foil_2"><option value=''>--Select Hot Foil--</option>
											<?php if($hot_foil==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($hot_foil as $hot_foil_row){
													echo "<option value='".$hot_foil_row->lang_article_description."'  ".set_select('hot_foil_2',$hot_foil_row->lang_article_description).">".$hot_foil_row->lang_article_description."</option>";
												}
										}?>
										</select></td>
									</tr>

									<tr>
										<td class="label">Sealing Non Lacquring Area * :</td>
										<td><input type="text" name="sealing_non_lacquering_area" value="<?php echo set_value('sealing_non_lacquering_area');?>"></td>
									</tr>


									<tr id="lacquer_type_1">
										<td class="label">Lacquer Type 1 :<input type="hidden" name="lacquer_type[]" value="1"/></td>
										<td><select name="lacquer_type_1"><option value=''>--Select Lacquer--</option>
										<?php if($lacquer==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($lacquer as $lacquer_row){
													echo "<option value='".$lacquer_row->lang_article_description."'   ".set_select('lacquer_type_1',$lacquer_row->lang_article_description).">".$lacquer_row->lang_article_description."</option>";
												}
										}?></select></td>
									</tr>

									<tr id="lacquer_type_2">
										<td class="label">Lacquer Type 2 :<input type="hidden" name="lacquer_type[]" value="2"/></td>
										<td><select name="lacquer_type_2"><option value=''>--Select Lacquer--</option>
										<?php if($lacquer==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($lacquer as $lacquer_row){
													echo "<option value='".$lacquer_row->lang_article_description."'  ".set_select('lacquer_type_2',$lacquer_row->lang_article_description).">".$lacquer_row->lang_article_description."</option>";
												}
										}?></select></td>
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
				
				
				
				
				
			