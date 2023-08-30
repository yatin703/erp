<script type="text/javascript">
$(document).ready(function() {
		$("#loading").hide();
		$("#cover").hide();
    $("#module").change(function(event) {
    var module = $('#module').val();
    $("#loading").show();
				$("#cover").show();
				$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/module",data: {module : $('#module').val()},cache: false,success: function(html){
    	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
       $("#form").html(html);
    } 
    });
   });

    $("#form").change(function(event) {
    var module = $('#form').val();
    $("#loading").show();
				$("#cover").show();
				$('#loading').html('<img src="<?php echo base_url('assets/img/loading.gif');?>"> Loading...');
    $.ajax({type: "POST",url: "<?php echo base_url(); ?>" + "index.php/ajax/form",data: {form : $('#form').val()},cache: false,success: function(html){
    	setTimeout(function () {$("#loading").hide();$("#cover").hide();},200);
       $("#formrights").html(html);
    } 
    });
   });

});
</script>



				<div class="form_design">
					<form name="" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/save');?>" method="POST">
					<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
					<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
					<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
					<table class="form_table_design" >
						<tr>
							<td>
								<table class="form_table_inner" >
									<tr>
										<td class="label">Select User <span style="color:red;">*</span> :</td>
										<td><select name="user" id="user" ><option value=''>--Select User--</option>
									<?php if($user==FALSE){
													echo "<option value=''>--User Setup Required--</option>";}
										else{
											foreach($user as $user_row){
												echo "<option value='".$user_row->user_id."' ".set_select('user',''.$user_row->user_id.'').">".$user_row->login_name."</option>";
											}
									}?>
										</select></td>
									</tr>

									<tr>
										<td class="label">Select Module <span style="color:red;">*</span> :</td>
										<td><select name="module" id="module" ><option value=''>--Select Module--</option>
									<?php if($modules==FALSE){
													echo "<option value=''>--User Setup Required--</option>";}
										else{
											foreach($modules as $module_row){
												echo "<option value='".$module_row->module_id."' ".set_select('module',''.$module_row->module_id.'').">".$module_row->module_name."</option>";
											}
									}?>
										</select></td>
									</tr>

									<tr>
										<td class="label">Select Form <span style="color:red;">*</span> :</td>
										<td><select name="form" id="form"><option value=''>--Select Form--</option></select></td>
									</tr>

									<tr>
										<td class="label">Select Rights <span style="color:red;">*</span> :</td>
										<td><span id='formrights'></span></td>
									</tr>
									
								</table>
							</td>
							
						</tr>
					</table>
					<button class="submit" name="submit">Save</button> <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>">Cancel</a>
					</form>
				</div>
				
				
				
				
				
			