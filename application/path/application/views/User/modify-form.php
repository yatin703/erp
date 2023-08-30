
<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">
									<?php foreach($user as $row):?>
									
									<tr>
										<td class="label">Employee <span style="color:red;">*</span> :</td>
										<td><select name="employee"><option value=''>--Select Employee--</option>
										<?php if($employee==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($employee as $employee_row){
													$selected=($row->user_id===$employee_row->employee_id ?'selected':'');
													echo "<option value='".$employee_row->employee_id."' $selected ".set_select('employee',''.$employee_row->employee_id.'').">".$employee_row->name1." ".$employee_row->name2."</option>";
												}
										}?>
										</select></td>
									</tr>

								<tr>
										<td class="label">Login Name <span style="color:red;">*</span> :</td>
										<td><input type="text" name="login_name" maxlength="50" size="20" value="<?php echo set_value('login_name',$row->login_name);?>" /></td>
									</tr>


									<tr>
										<td class="label">Password <span style="color:red;">*</span> :</td>
										<td><input type="password" name="password" value="<?php echo set_value('password');?>" /></td>
									</tr>


									<tr>
										<td class="label">Admin <span style="color:red;">*</span> :</td>
										<td><input type="checkbox" name="admin" <?php echo set_checkbox('admin',1);?>  <?php echo ($row->admin==1 ? 'value="1" checked' : 'value="0"');?>/></td>
									</tr>

									<tr>
											<td class="label">User Level <span style="color:red;">*</span> :</td>
											<td><select name="user_level"><option value=''>--Select User Level--</option>
											<?php if($user_level==FALSE){
															echo "<option value=''>--Setup Required--</option>";}
												else{
													foreach($user_level as $user_level_row){
														$selected=($row->user_level===$user_level_row->level_code ? 'selected' : '');
														echo "<option value='".$user_level_row->level_code."' $selected ".set_select('user_level',''.$user_level_row->level_code.'').">".$user_level_row->level_code_desc."</option>";
													}
											}?>
											</select>
											</td>
											
									</tr>

								<?php endforeach;?>	
				</table>			
								
				</td>
							
			</tr>
		</table>
					
	</div>

	<div class="form_design">
		<button class="submit" name="submit">Update</button> <a href="<?php echo base_url('index.php/'.$this->router->fetch_class().'');?>">Cancel</a>
	</div>
		
</form>
				
				
				
				
				
			