<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		$("#customer").autocomplete("<?php echo base_url('index.php/ajax/customer');?>", {selectFirst: true});
		$("#article_no").autocomplete("<?php echo base_url('index.php/ajax/article_no_springtube');?>", {selectFirst: true});

		$("#article_no").live('keyup',function() {
		   var article_no = $('#article_no').val();
		   $("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
		   $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/artwork_version_no_springtube",data: {article_no : $('#article_no').val()},cache: false,success: function(html){
		    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
		       $("#version_no").html(html);
		    } 
		    });
        });
        $("#article_no").blur(function() {

		   var article_no = $('#article_no').val();

		   if(article_no!=''){
		   
			    $("#loading").show();
				$("#cover").show();
				$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			   $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/artwork_version_no_springtube",data: {article_no : $('#article_no').val()},cache: false,success: function(html){
			    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
			       $("#version_no").html(html);
			    } 
			    });
		    }


        });


		$("#pre_lacquer_1").change(function() {
   			$("#loading").hide(); $("#cover").hide();
   			$("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');		    
	   		var pre_lacquer_1 = $(this).find(':selected').val();
	    	if(pre_lacquer_1!=''){
	    		$('#pre_lacquer_1_perc').attr('required','required');
	    		$('#pre_lacquer_1_perc').attr('readonly',false);
	    	}
	    	else{
	    		$('#pre_lacquer_1_perc').attr('required',false);
	    		$('#pre_lacquer_1_perc').attr('readonly','readonly');
	    		$('#pre_lacquer_1_perc').val('');
	    	}
	    	$("#loading").hide(); $("#cover").hide();
		    
		});
		$("#pre_lacquer_2").change(function() {
   			$("#loading").hide(); $("#cover").hide();
   			$("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');		    
	   		var pre_lacquer_2 = $(this).find(':selected').val();
	    	if(pre_lacquer_2!=''){
	    		$('#pre_lacquer_2_perc').attr('required','required');
	    		$('#pre_lacquer_2_perc').attr('readonly',false);
	    	}else{
	    		$('#pre_lacquer_2_perc').attr('required',false);
	    		$('#pre_lacquer_2_perc').attr('readonly','readonly');
	    		$('#pre_lacquer_2_perc').val('');
	    	}
	    	$("#loading").hide(); $("#cover").hide();
		    
		});

		$("#post_lacquer_1").change(function() {
   			$("#loading").hide(); $("#cover").hide();
   			$("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');		    
	   		var post_lacquer_1 = $(this).find(':selected').val();
	    	if(post_lacquer_1!=''){
	    		$('#post_lacquer_1_perc').attr('required','required');
	    		$('#post_lacquer_1_perc').attr('readonly',false);
	    	}
	    	else{
	    		$('#post_lacquer_1_perc').attr('required',false);
	    		$('#post_lacquer_1_perc').attr('readonly','readonly');
	    		$('#post_lacquer_1_perc').val('');
	    	}
	    	$("#loading").hide(); $("#cover").hide();
		    
		});
		$("#post_lacquer_2").change(function() {
   			$("#loading").hide(); $("#cover").hide();
   			$("#loading").show();
			$("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');		    
	   		var post_lacquer_2 = $(this).find(':selected').val();
	    	if(post_lacquer_2!=''){
	    		$('#post_lacquer_2_perc').attr('required','required');
	    		$('#post_lacquer_2_perc').attr('readonly',false);
	    	}else{
	    		$('#post_lacquer_2_perc').attr('required',false);
	    		$('#post_lacquer_2_perc').attr('readonly','readonly');
	    		$('#post_lacquer_2_perc').val('');
	    	}
	    	$("#loading").hide(); $("#cover").hide();
		    
		});



	});
</script>

<script>

	function validate_form(){

		if(document.getElementById('customer').value==''){

			alert('Customer field is required');
			document.getElementById('customer').focus();
			return false;
		}
		if(document.getElementById('article_no').value==''){

			alert('Article field is required');
			document.getElementById('article_no').focus();
			return false;
		}
		if(document.getElementById('version_no').value==''){

			alert('Version no field is required');
			document.getElementById('version_no').focus();
			return false;
		}

		if(document.getElementById('sleeve_dia').value==''){

			alert('Dia field is required');
			document.getElementById('sleeve_dia').focus();
			return false;
		}

		if(document.getElementById('sleeve_dia').value==''){

			alert('Dia field is required');
			document.getElementById('sleeve_dia').focus();
			return false;
		}

		if(document.getElementById('sleeve_length').value==''){

			alert('Length(mm) field is required');
			document.getElementById('sleeve_length').focus();
			return false;
		}

		if(document.getElementById('sleeve_length').value==''){

			alert('Length(mm) field is required');
			document.getElementById('sleeve_length').focus();
			return false;
		}

		if(document.getElementById('laminate_color').value==''){

			alert('Laminate Color field is required');
			document.getElementById('laminate_color').focus();
			return false;
		}

		if(document.getElementById('print_type').value==''){

			alert('Print type field is required');
			document.getElementById('print_type').focus();
			return false;
		}

		if(document.getElementById('non_lacquer_length').value==''){

			alert('Non Lacquring Length(mm) field is required');
			document.getElementById('non_lacquer_length').focus();
			return false;
		}

		

		// if(document.getElementById('pre_lacquer_1').value=='' && document.getElementById('pre_lacquer_2').value=='' && document.getElementById('post_lacquer_1').value=='' && document.getElementById('post_lacquer_2').value==''){

		// 	alert('Lacquer is required either Pre or Post');
		// 	document.getElementById('pre_lacquer_1').focus();
		// 	return false;
		// }


		// if(document.getElementById('post_lacquer_1').value=='' && document.getElementById('post_lacquer_2').value=='' ){

		// 	if( document.getElementById('pre_lacquer_1').value!='' && document.getElementById('pre_lacquer_1_perc').value==''){

		// 		alert('Pre Lacquer 1 % is required');
		// 		document.getElementById('pre_lacquer_1_perc').focus();
		// 		return false;
		// 	}

		// 	if( document.getElementById('pre_lacquer_2').value!='' && document.getElementById('pre_lacquer_2_perc').value==''){

		// 		alert('Pre Lacquer 2 % is required');
		// 		document.getElementById('pre_lacquer_2_perc').focus();
		// 		return false;
		// 	}


		// 	var pre_lac_perc_1=parseInt(document.getElementById('pre_lacquer_1_perc').value);
		// 	var pre_lac_perc_2=parseInt(document.getElementById('pre_lacquer_2_perc').value);

		// 	pre_lac_perc_1=isNaN(pre_lac_perc_1)?0:pre_lac_perc_1;
		// 	pre_lac_perc_2=isNaN(pre_lac_perc_2)?0:pre_lac_perc_2;

		// 	alert(pre_lac_perc_1);

		// 	alert(pre_lac_perc_2);

			
		// 	var total_lac_perc=pre_lac_perc_1+pre_lac_perc_2;
		// 	alert(total_lac_perc);
		// 	if(total_lac_perc!=100){

		// 		alert('Total % of Pre Lacquer must be 100%');
		// 		document.getElementById('pre_lacquer_1_perc').focus();
		// 		return false;

		// 	}

		// }

		// if(document.getElementById('pre_lacquer_1').value=='' && document.getElementById('pre_lacquer_2').value=='' ){

		// 	if( document.getElementById('post_lacquer_1').value!='' && document.getElementById('post_lacquer_1_perc').value==''){

		// 		alert('Post Lacquer 1 % is required');
		// 		document.getElementById('post_lacquer_1_perc').focus();
		// 		return false;
		// 	}

		// 	if( document.getElementById('post_lacquer_2').value!='' && document.getElementById('post_lacquer_2_perc').value==''){

		// 		alert('Post Lacquer 2 % is required');
		// 		document.getElementById('post_lacquer_2_perc').focus();
		// 		return false;
		// 	}

		// 	var post_lac_perc_1=parseInt(document.getElementById('post_lacquer_1_perc').value);
		// 	var post_lac_perc_2=parseInt(document.getElementById('post_lacquer_2_perc').value);
			
		// 	var total_lac_perc=post_lac_perc_1+post_lac_perc_2;
		// 	if(total_lac_perc!=100){

		// 		alert('Total % of Post Lacquer must be 100%');
		// 		document.getElementById('post_lacquer_1_perc').focus();
		// 		return false;

		// 	}

		// }

		// if(document.getElementById('pre_lacquer_2').value!=''){

		// 	var pre_lac_perc_1=parseInt(document.getElementById('pre_lacquer_1_perc').value);
		// 	var pre_lac_perc_2=parseInt(document.getElementById('pre_lacquer_2_perc').value);
			
		// 	var total_lac_perc=pre_lac_perc_1+pre_lac_perc_2;

		// 	if(total_lac_perc!=100){

		// 		alert('Total % of Pre Lacquer must be 100%');
		// 		document.getElementById('pre_lacquer_1_perc').focus();
		// 		return false;

		// 	}

		// }

		// if(document.getElementById('post_lacquer_2').value!=''){

		// 	var post_lac_perc_1=parseInt(document.getElementById('post_lacquer_1_perc').value);
		// 	var post_lac_perc_2=parseInt(document.getElementById('post_lacquer_2_perc').value);
			
		// 	var total_lac_perc=post_lac_perc_1+post_lac_perc_2;
		// 	if(total_lac_perc!=100){

		// 		alert('Total % of Post Lacquer must be 100%');
		// 		document.getElementById('post_lacquer_1_perc').focus();
		// 		return false;

		// 	}

		// }

		// if(document.getElementById('pre_lacquer_1').value=!'' && document.getElementById('pre_lacquer_2').value=='' && document.getElementById('post_lacquer_1').value!='' && document.getElementById('post_lacquer_2').value=='' ){

		// 	var pre_lac_perc_1=parseInt(document.getElementById('pre_lacquer_1_perc').value);
		// 	var post_lac_perc_1=parseInt(document.getElementById('post_lacquer_1_perc').value);
			
		// 	var total_lac_perc=pre_lac_perc_1+post_lac_perc_1;
		// 	if(total_lac_perc!=200){

		// 		alert('Total % of Lacquer must be 200%');
		// 		document.getElementById('pre_lacquer_1_perc').focus();
		// 		return false;

		// 	}

		// }

		if(document.getElementById('body_making_type').value==''){

			alert('Body Making/Seam Type field is required');
			document.getElementById('body_making_type').focus();
			return false;
		}

		//return true;
		return confirm('Are you sure to save the record?');					
		
	}

</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save');?>" method="POST" autocomplete="off" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner" >									
									
						<tr>
							<td class="label">Customer <span style="color:red;">*</span> :</td>
							<td><input type="text" name="customer" id="customer"  size="60" value="<?php echo set_value('customer');?>" required/></td>
						</tr>

						<tr>
							<td class="label">Article  <span style="color:red;">*</span> :</td>
							<td><input type="text" name="article_no" id="article_no"  size="60" value="<?php echo set_value('article_no');?>" required /></td>
						</tr>

						<tr>
							<td class="label">Version No <span style="color:red;">*</span> :</td>
							<td><select id="version_no" name="version_no" required>
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
							<td class="label">Dia <span style="color:red;">*</span> :</td>
							<td><select name="sleeve_dia" id="sleeve_dia" required><option value=''>--Select Dia--</option>
							<?php if($sleeve_dia==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach($sleeve_dia as $sleeve_dia_row){
										echo "<option value='".$sleeve_dia_row->sleeve_diameter."'  ".set_select('sleeve_dia',''.$sleeve_dia_row->sleeve_diameter.'').">".$sleeve_dia_row->sleeve_diameter."</option>";
									}
							}?>
							</select>
						    Length(mm) <span style="color:red;">*</span> : <input type="number" name="sleeve_length" id="sleeve_length" size="10" value="<?php echo set_value('sleeve_length');?>" required min="50" max="500" step="any" placeholder="In mm"></td>
						</tr>

						<tr>
							<td class="label">Laminate Color <span style="color:red;" >*</span> :</td>
							<td><select name="laminate_color" id="laminate_color" required><option value=''>--Select Laminate Color--</option>
							<?php if($springtube_laminate_color_master==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach($springtube_laminate_color_master as $springtube_laminate_color_master_row){
										echo "<option value='".$springtube_laminate_color_master_row->laminate_color."'  ".set_select('laminate_color',''.$springtube_laminate_color_master_row->laminate_color.'').">".$springtube_laminate_color_master_row->laminate_color."</option>";
									}
							}?>
							</select></td>
						</tr>
						<tr>
							<td class="label">Print Type <span style="color:red;">*</span> :</td>
							<td><select name="print_type" id="print_type" required><option value=''>--Select Print Type--</option>
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
							<td class="label">&nbsp;</td><td class="label">&nbsp;</td>
						</tr>

						<tr>
							<td class="label"><b>Tube Foil Information</b></td>
						</tr>

						<tr id="cold_foil_1">
							<td class="label">Cold Foil 1 :</td>
							<td><select name="cold_foil_1" id='cold_foil_1'><option value=''>--Select Cold Foil 1--</option>
								<?php if($cold_foil==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach($cold_foil as $cold_foil_row){
										echo "<option value='".$cold_foil_row->article_no."'   ".set_select('cold_foil_1',$cold_foil_row->article_no).">".$cold_foil_row->lang_article_description."</option>";
									}
							}?>
							
							</select>
							<!--<input type="number" name='cold_foil_1_area' id="cold_foil_1_area" value='<?php echo set_value('cold_foil_1_area');?>' placeholder="SQM/Tube" min="0" max="1" step="0.00001" >-->

							<!--Length(mm) : <input type="number" name="cold_foil_1_length"  size="3" value="<?php echo set_value('cold_foil_1_length');?>" min="1" max="100" step="0.01" placeholder="In mm">
							Width(mm) : <input type="number" name="cold_foil_1_width"  size="3" value="<?php echo set_value('cold_foil_1_width');?>" min="1" max="100" step="0.01" placeholder="In mm">
							-->

							</td>
						</tr>

						<tr id="cold_foil_2">
							<td class="label">Cold Foil 2  :</td>
							<td><select name="cold_foil_2" id="cold_foil_2"><option value=''>--Select Cold Foil 2--</option>
							<?php if($cold_foil==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach($cold_foil as $cold_foil_row){
										echo "<option value='".$cold_foil_row->article_no."'  ".set_select('cold_foil_2',$cold_foil_row->article_no).">".$cold_foil_row->lang_article_description."</option>";
									}
							}?>
							
							</select>
							<!--<input type="number" name='cold_foil_2_area' id="cold_foil_2_area" value='<?php echo set_value('cold_foil_2_area');?>' placeholder="SQM/Tube"  min="0" max="1" step="0.00001">-->
						<!-- Length(mm) : <input type="number" name="cold_foil_2_length" id="cold_foil_2_length" size="3" value="<?php echo set_value('cold_foil_2_length');?>" min="1" max="100" step="0.01" placeholder="In mm" >
							Width(mm) : <input type="number" name="cold_foil_2_width"  size="3" value="<?php echo set_value('cold_foil_2_width');?>" min="1" max="100" step="0.01" placeholder="In mm">
						-->

							</td>
						</tr>

						<tr>
							<td class="label">&nbsp;</td><td class="label">&nbsp;</td>
						</tr>

						
									
				</table>			
								
				</td>
				<td>
					<table class="form_table_inner">

						<tr>
							<td class="label"><b>Lacquer Information</b></td>
						</tr>

						<tr>
							<td class="label">Non Lacquring Length(mm) <span style="color:red;">*</span> :</td>
							<td><input type="number" min="0" max="50" step="0.5" name="non_lacquer_length" id="non_lacquer_length" value="<?php echo set_value('non_lacquer_length');?>" required placeholder="in mm"></td>
						</tr>
						<tr>
							<td class="label"><b>Pre Lacquer</b></td>
						</tr>

						<tr >
							<td class="label">Pre Lacquer Type 1 :</td>
							<td><select name="pre_lacquer_1" id="pre_lacquer_1" ><option value=''>--Select Lacquer--</option>
							<?php if($lacquer==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach($lacquer as $lacquer_row){
										echo "<option value='".$lacquer_row->article_no."'   ".set_select('pre_lacquer_1',$lacquer_row->article_no).">".$lacquer_row->lang_article_description."</option>";
									}
							}?></select><input type="number" name='pre_lacquer_1_perc' id="pre_lacquer_1_perc" size="3" value='<?php echo set_value('pre_lacquer_1_perc');?>'  placeholder="%"  min="1" max="100" step="1"></td>
						</tr>

						<tr >
							<td class="label">Pre Lacquer Type 2 :</td>
							<td><select name="pre_lacquer_2" id="pre_lacquer_2"><option value=''>--Select Lacquer--</option>
							<?php if($lacquer==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach($lacquer as $lacquer_row){
										echo "<option value='".$lacquer_row->article_no."'  ".set_select('pre_lacquer_2',$lacquer_row->article_no).">".$lacquer_row->lang_article_description."</option>";
									}
							}?></select><input type="number" name='pre_lacquer_2_perc'  id="pre_lacquer_2_perc" size="3" value='<?php echo set_value('pre_lacquer_2_perc');?>'  placeholder="%" min="1" max="100" step="1" ></td>
						</tr>
						<tr>
							<td class="label"><b>Post Lacquer</b></td>
						</tr>
						<tr >
							<td class="label">Post Lacquer Type 1 :</td>
							<td><select name="post_lacquer_1" id="post_lacquer_1" ><option value=''>--Select Lacquer--</option>
							<?php if($lacquer==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach($lacquer as $lacquer_row){
										echo "<option value='".$lacquer_row->article_no."'   ".set_select('post_lacquer_1',$lacquer_row->article_no).">".$lacquer_row->lang_article_description."</option>";
									}
							}?></select><input type="number" name='post_lacquer_1_perc' id="post_lacquer_1_perc" size="3" value='<?php echo set_value('post_lacquer_1_perc');?>'  placeholder="%"  min="1" max="100" step="1" ></td>
						</tr>

						<tr >
							<td class="label">Post Lacquer Type 2 :</td>
							<td><select name="post_lacquer_2" id="post_lacquer_2"><option value=''>--Select Lacquer--</option>
							<?php if($lacquer==FALSE){
											echo "<option value=''>--Setup Required--</option>";}
								else{
									foreach($lacquer as $lacquer_row){
										echo "<option value='".$lacquer_row->article_no."'  ".set_select('post_lacquer_2',$lacquer_row->article_no).">".$lacquer_row->lang_article_description."</option>";
									}
							}?></select><input type="number" name='post_lacquer_2_perc'id="post_lacquer_2_perc" size="3" value='<?php echo set_value('post_lacquer_2_perc');?>'  placeholder="%" min="1" max="100" step="1" ></td>
						</tr>
						<tr>
							<td class="label">&nbsp;</td><td class="label">&nbsp;</td>
						</tr>
						<tr>
							<td class="label">Body Making/ Seam Type <span style="color:red;">*</span> :</td>
							<td><select name="body_making_type" id="body_making_type" required>
								<option value="">--Select Body Making/Seam Type--</option>
								<option value="FLOWSEAM" <?php echo($this->input->post('body_making_type')=='FLOWSEAM'?"selected":"");?>>FLOWSEAM</option>
								<option value="OVERLAP" <?php echo($this->input->post('body_making_type')=='OVERLAP'?"selected":"");?>>OVERLAP</option>
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
	  <button class="ui positive button" onClick="return validate_form();">Save</button>
		</div>
	</div>
		
</form>
				
				
				
				
				
			