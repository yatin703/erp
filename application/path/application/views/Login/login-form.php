
		<article class="login_container">
			<div class="form_container">
				<div class="login_form_design">
				<form name="" action="<?php echo base_url('index.php/login/validation');?>" method="POST">
				<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
					<table class="login" cellpadding="5">
						<tr><td class="first" rowspan="5" width='10%'>&nbsp;</td><td colspan="2"><b>Login</b></td></tr>

						<tr><td class="label">Username:</td><td><select name="username"><option value=''>--Select Username--</option>
						<?php if($user_data==FALSE){
							echo "<option value=''>--Company Setup Required--</option>";}
							else{
								foreach($user_data as $user_row){
									echo "<option value='".$user_row->user_id."' ".set_select('username',''.$user_row->user_id.'').">".ucwords(strtolower($user_row->login_name))."</option>";
									}
								}?></select></td></tr>

						<tr><td class="label">Password:</td><td><input type="password" name="password" /></td></tr>

						<tr><td class="label">Company:</td><td><select name="company">
						<?php if($company_data==FALSE){
							echo "<option value=''>--Company Setup Required--</option>";}
							else{
								foreach($company_data as $company_row){
									echo "<option value='".$company_row->company_id."' ".set_select('company',''.$company_row->company_id.'').">".$company_row->title."</option>";
									}
								}?></select></td></tr>

						<tr><td>&nbsp;</td><td><input type="submit" value="Login"></td></tr>
					</table>
				</form>	
				</div>
				
			</div>
		</article>
		