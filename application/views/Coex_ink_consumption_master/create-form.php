<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/auto/jquery.autocomplete.css');?>" />
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/auto/jquery.autocomplete.js');?>"></script>
<script>
	$(document).ready(function(){

		$("#loading").hide(); $("#cover").hide();
		$("#product_name_1").autocomplete("<?php echo base_url('index.php/ajax/article_no');?>", {selectFirst: true});
		$("#artwork_no").autocomplete("<?php echo base_url('index.php/ajax/artwork_autocomplete');?>", {selectFirst: true});

		$("#product_name_1").live('keyup',function(){
			$("#loading").show(); $("#cover").show();
			$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
			$.ajax({type: "POST",url: "<?php echo base_url('index.php/ajax/bom_no');?>",data: {article_no : $("#product_name_1").val()},cache: false,success: function(html){
				setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
				$("#product_spec_artwork_1").html(html);
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
										<td class="label"><b>Product No</b>  <span style="color:red;">*</span> :</td>
										<td><input type="text" name="product_name_1" id="product_name_1" size="50"  value="<?php echo set_value('product_name_1');?>" placeholder="Goods Information"/>
											<span id="product_spec_artwork_1"></span></td>
									</tr>

									

									<tr>
										<td class="label">Version No  :</td>
										<td><input type="text" name="version_no"   size="10" value="<?php echo set_value('version_no');?>" /></td>
									</tr>

																
									<tr>
										<td class="label"><b>Flexo Ink</b><span style="color:red;">*</span> :</td>
										<td><input type="text" name="flexo_ink_gm_tube"  size="10" value="<?php echo set_value('flexo_ink_gm_tube');?>" /></td>
									</tr>

									<tr>
										<td class="label"><b>Screen Ink</b><span style="color:red;">*</span> :</td>
										<td><input type="text" name="screen_ink_gm_tube"  size="10" value="<?php echo set_value('screen_ink_gm_tube');?>" /></td>
									</tr>

									<tr>
										<td class="label"><b>Offset Ink</b><span style="color:red;">*</span> :</td>
										<td><input type="text" name="offset_ink_gm_tube" size="10" value="<?php echo set_value('offset_ink_gm_tube');?>" /></td>
									</tr>

									<tr>
										<td class="label"><b>Special Ink</b><span style="color:red;">*</span> :</td>
										<td><input type="text" name="special_ink_gm_tube" size="10" value="<?php echo set_value('special_ink_gm_tube');?>" /></td>
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

				
				
				
				
				
			