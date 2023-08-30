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
					<form name="" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST">
					<?php foreach ($formrights as $row):?>
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
												$selected=($row->user_id===$user_row->user_id ? 'selected':'');
												echo "<option value='".$user_row->user_id."' $selected>".$user_row->login_name."</option>";
											}
									}?>
										</select><input type='hidden' name='formrights_id' value='<?php echo $row->formrights_id;?>'></td>
									</tr>

									<tr>
										<td class="label">Select Module <span style="color:red;">*</span> :</td>
										<td><select name="module" id="module" ><option value=''>--Select Module--</option>
									<?php if($modules==FALSE){
													echo "<option value=''>--User Setup Required--</option>";}
										else{
											foreach($modules as $module_row){
												$selected=($row->module_id===$module_row->module_id ? 'selected':'');
												echo "<option value='".$module_row->module_id."' $selected>".$module_row->module_name."</option>";
											}
									}?>
										</select></td>
									</tr>

									<tr>
										<td class="label">Select Form <span style="color:red;">*</span> :</td>
										<td><select name="form" id="form">
										<?php if($form==FALSE){
													echo "<option value=''>--Form Setup Required--</option>";}
										else{
											foreach($form as $form_row){
												$selected=($row->form_id===$form_row->form_id? 'selected':'');
												echo "<option value='".$form_row->form_id."' $selected>".$form_row->form_name."</option>";
											}
									}?>
										
										</select></td>
									</tr>

									<tr>
										<td class="label">Select Rights <span style="color:red;">*</span> :</td>
										<td><span id='formrights'>
											<?php
											echo ($row->view==1 ? 'View : <input type="checkbox" name="view" value="1" checked>' : 'View : <input type="checkbox" name="view" value="1" >');
											echo ($row->new==1 ? 'New : <input type="checkbox" name="new" value="1" checked>' : 'New : <input type="checkbox" name="new" value="1" >');
											echo ($row->modify==1 ? 'Modify : <input type="checkbox" name="modify" value="1" checked>' : 'Modify : <input type="checkbox" name="modify" value="1" >');
											echo ($row->delete==1 ? 'Archive : <input type="checkbox" name="delete" value="1" checked>' : 'Archive : <input type="checkbox" name="delete" value="1" >');
											echo ($row->copy==1 ? 'Copy : <input type="checkbox" name="copy" value="1" checked>' : 'Copy : <input type="checkbox" name="copy" value="1" >');
											echo ($row->dearchive==1 ? 'Dearchive : <input type="checkbox" name="dearchive" value="1" checked>' : 'Dearchive : <input type="checkbox" name="dearchive" value="1" >');
											echo ($row->approval==1 ? 'Approval : <input type="checkbox" name="approval" value="1" checked>' : 'Approval : <input type="checkbox" name="approval" value="1" >');
											?>
										</span></td>
									</tr>
									
								</table>
							</td>
							
						</tr>
					</table>
					<button class="submit" name="submit">Update</button> <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>">Back</a>
					<?php endforeach;?>
					</form>
				</div>
				
				
				
				
				
			