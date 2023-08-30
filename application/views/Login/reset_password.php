<article class="login_container"> 
			<div class="form_container">
				<div class="login_form_design">
				<form name="" action="<?php echo base_url('index.php/login/update_password');?>" method="POST">
				<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
					<table class="login" cellpadding="5">

						<tr><td class="first" rowspan="5" width='10%'>&nbsp;</td><td colspan="2"><b>Set New Password</b></td></tr>

						<tr><td class="label">New Password:</td><td><input type="password" name="new_password" /></td></tr>
						<tr><td class="label">Confirm Password:</td><td><input type="password" name="confirm_password" /></td></tr>
      <tr><td>&nbsp;</td><td><input type="submit" value="Update password"><input type="hidden" name="reset_code" value="<?php echo ($this->uri->segment(3)<>'' ? $this->uri->segment(3) : $this->input->post('reset_code'));?>" /></td></tr>

					</table>
				</form>	
				</div>
				
			</div>
		</article>
		