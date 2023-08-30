<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script type="text/javascript">
	$(document).ready(function(){

		$("#loading").hide(); $("#cover").hide();
		 
		 
		var a=$("input[name='ink_composition']:checked").val();

		if(a=='2'){			 

			$("#tr_article").hide();
			$("#article_no").attr("required",false);
		}

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



	});
</script>

<?php foreach ($springtube_ink_master as $row):?>

<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST"  >
	
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>

		<table class="form_table_design">
			<tr>

				<td >
					<table class="form_table_inner">
						<tr><td><input type="hidden" name="ink_id" value="<?php echo $row->ink_id;?>"></td></tr>
						<tr>
							<td class="label">Substrate<span style="color:red;">*</span> :</td>
							<td><select name="substrate" id="substrate" required><option value=''>--Select Substrate--</option>
							<?php   if($springtube_laminate_color_master==FALSE){
										echo"<option value=''>--Setup Required--</option>";

									}else{
									foreach($springtube_laminate_color_master as $springtube_laminate_color_master_row){
										$selected=($springtube_laminate_color_master_row->laminate_color==$row->substrate ?'selected':'');
										echo "<option value='".$springtube_laminate_color_master_row->laminate_color."'  ".set_select('substrate',''.$springtube_laminate_color_master_row->laminate_color.'').$selected.">".$springtube_laminate_color_master_row->laminate_color."</option>";
									}
							}?>
							</select></td>
						</tr>
						<tr>
							<td class="label">Ink Manufacturer <span style="color:red;">*</span> :</td>
							<td><input type="text" name="ink_manufacturer" id="ink_manufacturer"  size="30" maxlength="100" value="<?php echo set_value('ink_manufacturer',$row->ink_manufacturer);?>"  placeholder="Ink Manufacturer" />
							</td>
							
						</tr>
						<tr>
							<td class="label">Ink Name <span style="color:red;">*</span> :</td>
							<td><input type="text" name="ink_name" id="ink_name"  size="30" maxlength="100" value="<?php echo set_value('ink_name',$row->ink_name);?>"  placeholder="Ink Name" />
							</td>
							
						</tr>						
						<tr>
							<td class="label">Ink Code <span style="color:red;">*</span> :</td>
							<td><input type="text" name="ink_code" id="ink_code"  size="30" maxlength="100" value="<?php echo set_value('ink_code',$row->ink_code);?>"  placeholder="Ink Code" />
							</td>
							
						</tr>
						<tr>
							<td class="label">Ink Category<span style="color:red;">*</span>:</td>
							<td>
								<input type="radio" name="ink_category" id="ink_category" value="FLEXO" <?php echo( $row->ink_category=='FLEXO' || $this->input->post('ink_category')=='FLEXO'? "checked":"");?> /> Flexo &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								<input type="radio" name="ink_category" id="ink_category" value="SCREEN" <?php echo($row->ink_category=='SCREEN' || $this->input->post('ink_category')=='SCREEN'? "checked":"");?>/> Screen &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								<input type="radio" name="ink_category" id="ink_category" value="OFFSET" <?php echo($row->ink_category=='OFFSET' || $this->input->post('ink_category')=='OFFSET'? "checked":"");?>/> Offset &nbsp&nbsp&nbsp&nbsp&nbsp
								<input type="radio" name="ink_category" id="ink_category" value="LACQUER" <?php echo($this->input->post('ink_category')=='LACQUER' || $row->ink_category== 'LACQUER' ? "checked":"");?>/> Lacquer &nbsp&nbsp&nbsp
								<input type="radio" name="ink_category" id="ink_category" value="GLUE" <?php echo($this->input->post('ink_category')=='GLUE' || $row->ink_category== 'GLUE' ? "checked":"");?>/>Glue
							</td>
						</tr>
						<tr>
							<td class="label">Ink Migration<span style="color:red;">*</span>:</td>
							<td>
								<input type="radio" name="ink_migration" id="ink_migration" value="LM" <?php echo($row->ink_migration=='LM' || $this->input->post('ink_migration')=='LM'? "checked":"");?>/> LM &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								<input type="radio" name="ink_migration" id="ink_migration" value="NON-LM" <?php echo( $row->ink_migration=='NON-LM' || $this->input->post('ink_migration')=='NON-LM'? "checked":"");?> /> NON-LM 

							</td>
						</tr>
						<tr>
							<td class="label">Ink Composition<span style="color:red;">*</span>:</td>
							<td>
								<input class="radio" type="radio" name="ink_composition" id="ink_composition" value="1" <?php echo($row->ink_composition==1 || $this->input->post('ink_composition')=='1'? "checked":"");?> /> Direct Ink &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								<input class="radio" type="radio" name="ink_composition" id="ink_composition" value="2" <?php echo($row->ink_composition==2 || $this->input->post('ink_composition')=='2'? "checked":"");?>/>  Mixture Ink

							</td>
						</tr>
						<tr id="tr_article">
							<td class="label">Article Name  <span style="color:red;">*</span> :</td>
							<td><select name="article_no" id="article_no">					
								<option value="">--Please Select--</option>
								<?php if($article==FALSE){
									echo'<option>--Setup Required--</option>';
								}
								else{
									foreach ($article as $article_row) {

										$selected=($row->article_no==$article_row->article_no?'selected':'');
										echo'<option value="'.$article_row->article_no.'" '.set_select('article_no',$article_row->article_no).$selected.'>'.$article_row->lang_article_description.($article_row->lang_sub_description!=''?'('.$article_row->lang_sub_description.')':'').'</option>';
									}
								}?>
								</select>
							</td>
						</tr>	

						<tr>
						<td class="label">Comment :</td>
							<td ><textarea name="comment" value="<?php echo set_value('comment',$row->comment);?>"><?php echo set_value('comment',$row->comment);?></textarea></td>
						</tr>
					</table>
				</td>
			</tr>

		</table>							
			
		
 
<div class="middle_form_design">
	
		<div class="ui buttons">
		  <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
		  <div class="or"></div>
		  <button class="ui positive button" id="btnsubmit" >Update</button>
		<!-- <input type="submit" class="ui positive button" value="Save"/>-->
		</div>
	

</div>
		
</form>
<?php endforeach;?>	

		
				
				
				
				
			