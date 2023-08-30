<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){
		$("#loading").hide(); $("#cover").hide();
		$("#adr_company_id").autocomplete("<?php echo base_url('index.php/ajax/customer');?>", {selectFirst: true});
		$("#article_no").autocomplete("<?php echo base_url('index.php/ajax/article_no_springtube');?>", {selectFirst: true});
		$("#artwork_no").autocomplete("<?php echo base_url('index.php/ajax/artwork_springtube_autocomplete');?>", {selectFirst: true});

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


	});
</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/search_result');?>" method="POST" id="artwork">
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td width="50%">
					<table class="form_table_inner">
									<tr>
										<td class="label" width="25%">From Date <span style="color:red;">*</span> :</td>
										<td width="25%"><input type="date" name="from_date" id="from_date" value="<?php echo set_value('from_date',date('2019-02-01'));?>"/></td>
										<td class="label" width="25%">To Date <span style="color:red;">*</span> :</td>
										<td width="25%"><input type="date" name="to_date" id="to_date" value="<?php echo set_value('to_date',date('Y-m-d'));?>"/></td>
									</tr>
									<tr>
										<td class="label">Customer  :</td>
										<td colspan="3" ><input type="text" name="adr_company_id" id="adr_company_id"  size="60" value="<?php echo set_value('adr_company_id');?>" /></td>
									</tr>

									<tr>
										<td class="label">Article   :</td>
										<td colspan="3"><input type="text" name="article_no" id="article_no"  size="60" value="<?php echo set_value('article_no');?>" /></td>
									</tr>

									<tr>
										<td class="label">Artwork No  :</td>
										<td ><input type="text" name="artwork_no" id="artwork_no"  size="15" value="<?php echo set_value('artwork_no');?>"  />
										</td>
										<td class="label">Version No  :</td>
										<td ><input type="text" name="version_no"   size="15" value="<?php echo set_value('version_no');?>" /></td>
									</tr>
										
									<tr>
										<td class="label">Sleeve Diameter   :</td>
										<td colspan="3"><select name="sleeve_dia" id="sleeve_dia">
											<option value=''>--Please Select--</option>
										<?php if($sleeve_dia==FALSE){
														echo "<option value=''>--Sleeve Dia Setup Required--</option>";}
											else{
												foreach($sleeve_dia as $row){
													
													echo '<option value="'.$row->sleeve_diameter.'"'.set_select('sleeve_dia',''.$row->sleeve_diameter.'').' >'.$row->sleeve_diameter.'</option>';
												}
										}?>
										</select></td>
									</tr>											

									<tr>
										<td class="label">Sleeve Length  :</td>
										<td colspan="3"><input type="number" name="sleeve_length" size="10" value="<?php echo set_value('sleeve_length');?>" min="50" max="500" step="any"></td>
									</tr>
									<tr>
										<td class="label">Laminate Color  :</td>
										<td colspan="3">
											<select name="laminate_color" ><option value=''>--Select Laminate Color--</option>
											<?php if($springtube_laminate_color_master==FALSE){
															echo "<option value=''>--Setup Required--</option>";}
												else{
													foreach($springtube_laminate_color_master as $springtube_laminate_color_master_row){
														echo "<option value='".$springtube_laminate_color_master_row->laminate_color."'  ".set_select('laminate_color',''.$springtube_laminate_color_master_row->laminate_color.'').">".$springtube_laminate_color_master_row->laminate_color."</option>";
													}
											}?>
											</select>
										</td>
									</tr>
									<tr>
										<td class="label">Print Type   :</td>
										<td colspan="3"><select name="print_type" id="print_type">
											<option value=''>--Please Select--</option>
										<?php if($print_type==FALSE){
														echo "<option value=''>--Print Type Setup Required--</option>";}
											else{
												foreach($print_type as $row){
													
													echo '<option value="'.$row->lacquer_type.'"'.set_select('print_type',''.$row->lacquer_type.'').' >'.$row->lacquer_type.'</option>';
												}
										}?>
										</select></td>
									</tr>

									<tr>
										<td class="label">Sleeve Type :</td>
										<td><select name="sleeve_type" id="sleeve_type" >
											<option value=''>--Select Sleeve Type--</option>
											<option value="ROUND" <?php echo set_select('sleeve_type','ROUND');?> >ROUND</option>
											<option value="OVAL" <?php echo set_select('sleeve_type','OVAL');?> >OVAL</option>
											</select>
										</td>
									</tr>
									
									<tr>
										<td class="label">Approval Status   :</td>
										<td colspan="3"><select name="final_approval_flag">
											<option value="">--Please Select--</option>
											<option value="1" <?php echo set_select('final_approval_flag',1);?>>Approved</option>
											<option value="0" <?php echo set_select('final_approval_flag',0);?>>Not Approved</option>
										</select></td>
									</tr>
									
				</table>			
				</td>

				<td width="50%">
					<table class="form_table_inner">

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
							
							</select></td>
						</tr>

						<tr>
							<td class="label">&nbsp;</td><td class="label">&nbsp;</td>
						</tr>

									<tr>
							<td class="label"><b>Lacquer Information</b></td>
						</tr>

						<tr>
							<td class="label">Non Lacquer Length :</td>
							<td><input type="number" min="0" max="50" step="0.5" name="non_lacquer_length" id="non_lacquer_length" value="<?php echo set_value('non_lacquer_length');?>"></td>
						</tr>
						<tr>
							<td class="label"><b>Pre Lacquer</b></td>
						</tr>

						<tr id="pre_lacquer_1">
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

						<tr id="pre_lacquer_2">
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
						<tr id="post_lacquer_1">
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

						<tr id="post_lacquer_2">
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
							<td><select name="body_making_type" id="body_making_type" >
								<option value="">--Select Body Making/Seam Type--</option>
								<option value="FLOWSEAM" <?php echo set_select('body_making_type',$this->input->post('body_making_type'));?>>FLOWSEAM</option>
								<option value="OVERLAP" <?php echo set_select('body_making_type',$this->input->post('body_making_type'));?>>OVERLAP</option>
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
	  <button class="ui positive button">Search</button>
		</div>
	</div>
		
</form>
				
				
				
				
				
			