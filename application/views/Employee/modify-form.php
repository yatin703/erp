
<form name="<?php echo $this->router->fetch_class();?>" action="<?php echo base_url('index.php/'.$this->router->fetch_class().'/update');?>" method="POST" >
	<div class="form_design">
		<?php echo validation_errors("<p class='alert alert-error'>","</p>");?>
		<?php if(isset($note)){ echo "<p class='alert alert-success'>$note</p>";}?>
		<?php if(isset($error)){ echo "<p class='alert alert-error'>$error</p>";}?>
		<table class="form_table_design">
			<tr>
				<td>
					<table class="form_table_inner">
									<?php foreach($employee as $row):?>
									<tr>
										<td class="label">First Name <span style="color:red;">*</span> :</td>
										<td><input type="text" name="name1" maxlength="50" size="20" value="<?php echo set_value('name1',$row->name1);?>" />
										<input type="hidden" name="employee_id"  value="<?php echo $row->employee_id;?>" /></td>
									</tr>

									<tr>
										<td class="label">Last Name <span style="color:red;">*</span> :</td>
										<td><input type="text" name="name2" maxlength="50" size="20" value="<?php echo set_value('name2',$row->name2);?>" /></td>
									</tr>

									<tr>
										<td class="label">Gender <span style="color:red;">*</span> :</td>
										<td><select name="gender" id="gender">
												<option value=''>--Select Gender--</option>
												<option value='0' <?php echo set_select('gender',0); echo $selected=($row->gender==0 ? 'selected' :'');?> >Male</option>
												<option value='1' <?php echo set_select('gender',1); echo $selected=($row->gender==1 ? 'selected' :'');?> >Female</option>
											</select>
										</td>
									</tr>

									<tr>
										<td class="label">Marital Status <span style="color:red;">*</span> :</td>
										<td><select name="marital_status" >
												<option value=''>--Select Marital Status--</option>
												<option value='0' <?php echo set_select('marital_status',0); echo $selected=($row->marital_status==0 ? 'selected' :'');?>>Unmarried</option>
												<option value='1' <?php echo set_select('marital_status',1); echo $selected=($row->marital_status==1 ? 'selected' :'');?>>Married</option>
											</select>
										</td>
									</tr>

									<tr>
										<td class="label">Address <span style="color:red;">*</span> :</td>
										<td><textarea name="street" maxlength="256" rows="3" cols="40" value="<?php echo set_value('street',$row->street);?>"><?php echo set_value('street',$row->street);?></textarea></td>
									</tr>

									<tr>
										<td class="label">Country <span style="color:red;">*</span> :</td>
										<td><select name="country"><option value=''>--Select Country--</option>
										<?php if($country==FALSE){
														echo "<option value=''>--Setup Required--</option>";}
											else{
												foreach($country as $country_row){
													$selected=($row->country_id===$country_row->country_id ?'selected':'');
													echo "<option value='".$country_row->country_id."' $selected ".set_select('country',''.$country_row->country_id.'').">".$country_row->lang_country_name."</option>";
												}
										}?>
										</select></td>
									</tr>

									<tr>
										<td class="label">Email <span style="color:red;">*</span> :</td>
										<td><input type="text" name="mailbox" maxlength="50" size="20" value="<?php echo set_value('mailbox',$row->mailbox);?>" /></td>
									</tr>

									<tr>
										<td class="label">Mobile No. <span style="color:red;">*</span> :</td>
										<td><input type="text" name="mobile_no"  maxlength="15" size="20" value="<?php echo set_value('mobile_no',$row->mobile_no);?>" /></td>
									</tr>


									<tr>
										<td class="label">Date Of Birth <span style="color:red;">*</span> :</td>
										<td><input type="text" name="dob" value="<?php echo set_value('dob',$row->dob);?>" /></td>
									</tr>

									<tr>
										<td class="label">Department <span style="color:red;">*</span> :</td>
										<td><select name="department"><option value=''>--Select Department--</option>
										<?php 
											if($department==FALSE){
												echo "<option value=''>--Setup Required--</option>";
											}else{
												foreach($department as $department_row){
													$selected=($row->department_id===$department_row->department_id ?'selected':'');
													echo "<option value='$department_row->department_id' $selected ".set_select('department',$department_row->department_id).">$department_row->lang_department_desc</option>";
												}
											}
											?>
										</select></td>
									</tr>
									
									<tr>
										<td class="label">Date Of Joining <span style="color:red;">*</span> :</td>
										<td><input type="text" name="hire_date" id="from_date" value="<?php echo set_value('hire_date',$row->hire_date);?>" /></td>
									</tr>

									<tr>
										<td class="label">Date Of Exit :</td>
										<td><input type="text" name="exit_date" id="to_date" value="<?php echo set_value('exit_date',$row->exit_date);?>" /></td>
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
				
				
				
				
				
			