<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){

		$("#loading").hide(); $("#cover").hide();
		$("#article_no").autocomplete("<?php echo base_url('index.php/ajax/article_no');?>", {selectFirst: true});
		$("#sleeve_code").autocomplete("<?php echo base_url('index.php/ajax/approved_sleeve_autocomplete');?>", {selectFirst: true});
		$("#paper_film_code").autocomplete("<?php echo base_url('index.php/ajax/approved_paper_film_autocomplete');?>", {selectFirst: true});
		$("#shoulder_code").autocomplete("<?php echo base_url('index.php/ajax/approved_shoulder_autocomplete');?>", {selectFirst: true});
		$("#cap_code").autocomplete("<?php echo base_url('index.php/ajax/approved_cap_autocomplete');?>", {selectFirst: true});
		$("#label_code").autocomplete("<?php echo base_url('index.php/ajax/approved_label_autocomplete');?>", {selectFirst: true});

		$("#article_no").live('keyup',function() {
		   	var article_no = $('#article_no').val();
		   	$("#loading").show();
					$("#cover").show();
					$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({

			   	type: "POST",
			   	url: "<?php echo base_url(); ?>" + "index.php/ajax/bom_version_no",data: {article_no : $('#article_no').val()},
			   	cache: false,
			   	success: function(html){
			    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
			       		$("#bom_version_no").html(html);
			    } 
		    });

		});
		$("#article_no").blur( function() {
		   	var article_no = $('#article_no').val();
		   	if(article_no!=''){

		   		$("#loading").show();
					$("#cover").show();
					$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
				$.ajax({

				   	type: "POST",
				   	url: "<?php echo base_url(); ?>" + "index.php/ajax/bom_version_no",data: {article_no : $('#article_no').val()},
				   	cache: false,
				   	success: function(html){
				    		setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				       		$("#bom_version_no").html(html);
				    } 
			    });

		   	}
		   	

		});

		 $("#btnSubmit").click(function(e){

			if($("#cap_code").val()==""){				
				return confirm("Are you sure to go with out Cap?");

			}
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
										<td class="label"><b>Product No</b>  <span style="color:red;">*</span> :</td>
										<td><input type="text" name="article_no" id="article_no" size="60" value="<?php echo set_value('article_no');?>" /></td>
									</tr>
								
									<tr>
										<td class="label"><b>Version No </b><span style="color:red;">*</span> :</td>
										<td><select id="bom_version_no" name="bom_version_no">
										<?php if($this->input->post('bom_version_no')){
												echo "<option value='".$this->input->post('bom_version_no')."'>".$this->input->post('bom_version_no')."</option>";
										}else{
											echo "<option value=''>--Bom Version No--</option>";
											}?></select></td>
									</tr>

									<tr><td class="label"><b>&nbsp;</b></td><td class="label"><b>+</b></td>
									</tr>

									

									<tr>
										<td class="label"><b>Print Type <span style="color:red;">*</span></b></td>
										<td><select name="print_type" required><option value=''>--Select Print Type--</option>
										<?php if($print_type==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($print_type as $print_type_row){
													echo "<option value='".$print_type_row->lacquer_type."'  ".set_select('print_type',''.$print_type_row->lacquer_type.'').">".$print_type_row->lacquer_type."</option>";
												}
										}?>
										</select></td>
									</tr>

									<tr><td class="label"><b>&nbsp;</b></td><td class="label"><b>+</b></td></tr>

									<tr>
											<td class="label"><b>Tube/Film Code <span style="color:red;">*</span></b></td>
											<td><input type="text" name="sleeve_code" id="sleeve_code" size="60" value="<?php echo set_value('sleeve_code');?>" ></td>
											<td class="label"><b>+</b></td>
											<td class="label"><b>Paper Film Code <span style="color:red;">*</span></b></td>
											<td><input type="text" name="paper_film_code" id="paper_film_code" size="60" value="<?php echo set_value('paper_film_code');?>"></td>
									</tr>

									<tr><td class="label"><b>&nbsp;</b></td><td class="label"><b>+</b></td></tr>

									<tr>
											<td class="label"><b>Shoulder Code <span style="color:red;">*</span></b></td>
											<td><input type="text" name="shoulder_code" id="shoulder_code" size="60" value="<?php echo set_value('shoulder_code');?>" /></td>
									</tr>
									<tr><td class="label"><b>&nbsp;</b></td><td class="label"><b>+</b></td></tr>

									<tr>
											<td class="label"><b>Label Code</b></td>
											<td><input type="text" name="label_code" id="label_code" size="60" value="<?php echo set_value('label_code');?>" /></td>
									</tr>
									<tr><td class="label"><b>&nbsp;</b></td><td class="label"><b>+</b></td></tr>

									<tr>
											<td class="label"><b>Cap Code <span style="color:red;">*</span></b></td>
											<td><input type="text" name="cap_code" id="cap_code" size="60" value="<?php echo set_value('cap_code');?>" /></td>
									</tr>

									<tr><td class="label"><b>&nbsp;</b></td><td class="label"><b></b></td></tr>

									<tr>
										<td class="label"><b>Box Type <span style="color:red;">*</span> </b> :</td>
										<td><select name="for_export">
											<option value=''>--Select Box Type--</option>
											<option value="0" <?php echo set_select('for_export','0');?>>DOMESTIC</option>
											<option value="1" <?php echo set_select('for_export','1');?>>EXPORT</option>
								          </select>
								      </td>
								    </tr>

								    <tr><td class="label"><b>&nbsp;</b></td><td class="label"><b></b></td></tr>

								    <tr>
											<td class="label"><b>Comment</b> :</td>
											<td><textarea name="comment" value="<?php echo set_value('comment');?>" rows="3" cols="60"><?php echo set_value('comment');?></textarea></td>
									</tr>

									<tr><td class="label"><b>&nbsp;</b></td><td class="label"><b></b></td></tr>
									

									<tr>
										<td class="label"><b>Approval Authority</b> :</td>
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
	  <button class="ui positive button" id="btnSubmit">Save</button>
		</div>
	</div>
		
</form>

				
				
				
				
				
			