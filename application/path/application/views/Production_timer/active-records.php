
	<script type="text/javascript">
	var auto_refresh = setInterval(function (){
	$('.time').load('<?php echo base_url('index.php/Login/time');?>').fadeIn("slow");}, 100); 
	</script>

	<script src="https://cdn.tiny.cloud/1/zefcv4c5th55cjm0i30q7czorh4yrqhi1jsq801s4p14vezy/tinymce/5/tinymce.min.js" referrerpolicy="origin"/></script>
	<script>
    tinymce.init({
      selector: '#mytextarea'
    });
  </script>


<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td width='50%'>
					<table class="form_table_inner">
						<tr>
							<td class="label">Date  * :</td>
							<td><input type="date" name="production_date" id="article_no"  size="60" value="<?php echo set_value('production_date',date('Y-m-d'));?>" required /></td>
						</tr>

						<tr>
							<td class="label">Machine  * :</td>
							<td><select name="currency" id="currency"><option value=''>--Select Machine--</option>
								<option value="1">GCM 1</option>
								<option value="2">GCM 2</option>
								</select></td>
						</tr>

						<textarea id="mytextarea" name="mytextarea">
      Hello, World!
    </textarea>
						
					</table>
				</td>
				<td>
				</td>
			</tr>
		</table>
	</div>



	<div class="middle_form_design">
		<div class="middle_form_inner_design">
			<table class="record_table_design_without_fixed" style="font-size:12px;">
			
			</table>
		</div>
	</div>

	<div class="form_design">
		<button class="submit" name="submit">Save</button> <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>">Cancel</a>
	</div>
		
</form>
	