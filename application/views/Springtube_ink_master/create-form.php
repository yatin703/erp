<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script type="text/javascript">
	$(document).ready(function() {

		$("#loading").hide(); $("#cover").hide();


		$("#tr_article").hide();
		$("#article_no").attr("required",false);

		$("#article_no").autocomplete("<?php echo base_url('index.php/ajax_springtube/ink_lacquer_autocomplete');?>", {selectFirst: true});

		$(".radio").click(function() {
   			 
   			if($(this).val()==1){

   				$("#tr_article").show();
   				$("#article_no").attr("required",true);

   			}
   			else{
   				$("#tr_article").hide();
				$("#article_no").attr("required",false);
   			} 


	   	});	

		// if($("#ink_composition").val()==2){

		// 	$("#tr_article").hide();
		// 	$("#article_no").attr("required",false);

  //  		}else{
  //  			$("#tr_article").show();
  //  			$("#article_no").attr("required",true);

  //  		}




	});
</script>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save');?>" method="POST"  >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>

		<table class="form_table_design">
			<tr>
				<td >
					<table class="form_table_inner">
						<tr>
							<td class="label">Substrate<span style="color:red;">*</span> :</td>
							<td><select name="substrate" id="substrate" required><option value=''>--Select Substrate--</option>
							<?php   if($springtube_laminate_color_master==FALSE){
										echo"<option value=''>--Setup Required--</option>";

									}else{
									foreach($springtube_laminate_color_master as $springtube_laminate_color_master_row){
										echo "<option value='".$springtube_laminate_color_master_row->laminate_color."'  ".set_select('substrate',''.$springtube_laminate_color_master_row->laminate_color.'').">".$springtube_laminate_color_master_row->laminate_color."</option>";
									}
							}?>
							</select></td>
						</tr>
						<tr>
							<td class="label">Ink Manufacturer <span style="color:red;">*</span> :</td>
							<td><input type="text" name="ink_manufacturer" id="ink_manufacturer"  size="30" maxlength="100" value="<?php echo set_value('ink_manufacturer');?>"  placeholder="Ink Manufacturer" />
							</td>
							
						</tr>
						<tr>
							<td class="label">Ink Name <span style="color:red;">*</span> :</td>
							<td><input type="text" name="ink_name" id="ink_name"  size="30" maxlength="100" value="<?php echo set_value('ink_name');?>"  placeholder="Ink Name" />
							</td>
							
						</tr>						
						<tr>
							<td class="label">Ink Code <span style="color:red;">*</span> :</td>
							<td><input type="text" name="ink_code" id="ink_code"  size="30" maxlength="100" value="<?php echo set_value('ink_code');?>"  placeholder="Ink Code" />
							</td>
							
						</tr>
						<tr>
							<td class="label">Ink Category<span style="color:red;">*</span>:</td>
							<td>
								<input type="radio" name="ink_category" id="ink_category" value="FLEXO" <?php echo($this->input->post('ink_category')=='FLEXO'? "checked":"");?>/> Flexo &nbsp&nbsp&nbsp 
								<input type="radio" name="ink_category" id="ink_category" value="SCREEN" <?php echo($this->input->post('ink_category')=='SCREEN'? "checked":"");?>/> Screen &nbsp&nbsp&nbsp
								<input type="radio" name="ink_category" id="ink_category" value="OFFSET" <?php echo($this->input->post('ink_category')=='OFFSET'? "checked":"");?>/> Offset &nbsp&nbsp&nbsp
								<input type="radio" name="ink_category" id="ink_category" value="LACQUER" <?php echo($this->input->post('ink_category')=='LACQUER'? "checked":"");?>/> Lacquer &nbsp&nbsp&nbsp
								<input type="radio" name="ink_category" id="ink_category" value="GLUE" <?php echo($this->input->post('ink_category')=='GLUE'? "checked":"");?>/>Glue

							</td>
						</tr>
						<tr>
							<td class="label">Ink Migration<span style="color:red;">*</span>:</td>
							<td>
								<input type="radio" name="ink_migration" id="ink_migration" value="LM" <?php echo($this->input->post('ink_migration')=='LM'? "checked":"");?>/> LM &nbsp&nbsp&nbsp&nbsp
								<input type="radio" name="ink_migration" id="ink_migration" value="NON-LM" <?php echo($this->input->post('ink_migration')=='NON-LM'? "checked":"");?> /> NON-LM 

							</td>
						</tr>
						<tr>
							<td class="label">Ink Composition<span style="color:red;">*</span>:</td>
							<td>
								<input class="radio" type="radio" name="ink_composition" id="ink_composition" value="1" <?php echo($this->input->post('ink_composition')=='1'? "checked":"");?> /> Direct Ink &nbsp&nbsp&nbsp 
								<input class="radio" type="radio" name="ink_composition" id="ink_composition" value="2" <?php echo($this->input->post('ink_composition')=='2'? "checked":"");?>/>  Mixture Ink

							</td>
						</tr>
						<tr id="tr_article">
							<td class="label">Article Name  <span style="color:red;">*</span> :</td>
							<td><input type="text" name="article_no" id="article_no" maxlength="200" size="60" value="<?php echo set_value('article_no');?>" placeholder="Ink Name" required >
							</td>							 
						</tr>

						<tr>
						<td class="label">Comment :</td>
							<td ><textarea name="comment" value="<?php echo set_value('comment');?>"><?php echo set_value('comment');?></textarea></td>
						</tr>	
						
					</table>				 
				</td>							
			</tr>
		</table>
		

	 
	<div class="middle_form_design">

		<div class="ui buttons">
		  <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
		  <div class="or"></div>
		  <button class="ui positive button" id="btnsubmit" >Save</button>
		<!-- <input type="submit" class="ui positive button" value="Save"/>-->
		</div>
	

	</div>
		
</form>
				
				
				
				
				
			