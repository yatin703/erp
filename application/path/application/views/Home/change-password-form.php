
<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/change_password_save');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">

						<tr>
							<td class="label">New Password <span style="color:red;">*</span> :</td>
							<td><input type="password" name="new_password"  id="new_password" value="<?php echo set_value('new_password');?>" maxlength="20" required placeholder="New Password"/>&nbsp;<input type="checkbox" onclick="myFunction()"> Show Password
							</td>
						</tr>
						<tr>
							<td class="label">Confirm Password <span style="color:red;">*</span> :</td>
							<td><input type="password" name="confirm_password" id="confirm_password" value="<?php echo set_value('confirm_password');?>" maxlength="20" required placeholder="Confirm Password"/>
							</td>
							
						</tr>						
								
					</table>			
								
				</td>
							
			</tr>
			<tr>
				<td colspan="2">
					<div class="ui buttons">
						<a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>" class="ui button">Cancel</a>
						<div class="or"></div>
						<button class="ui positive button" id="btnsubmit" >Reset Password</button>
						 
					</div>
				</td>
			</tr>
		</table>
					
	</div>

	<!-- <div class="form_design">
		<button class="submit" name="submit">Change Password</button> <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>">Cancel</a>
	</div> -->
		
</form>
<script>
	
	function myFunction() {
	  var x = document.getElementById("new_password");
	  if (x.type === "password") {
	    x.type = "text";
	  } else {
	    x.type = "password";
	  }
	}
</script>
				
				
				
				
				
			